COMPOSER_CMD=composer
PHIVE_CMD=phive

PHPSPEC_CMD=tools/phpspec
BEHAT_CMD=tools/behat
README_TESTER_CMD=bin/readme-tester
PHPSTAN_CMD=tools/phpstan
PHPCS_CMD=tools/phpcs
BOX_CMD=tools/box
PHPEG_CMD=phpeg

.DEFAULT_GOAL=all

TARGET=readme-tester.phar

CONTAINER=src/ProjectServiceContainer.php

PARSER_ROOT=src/Input/Markdown/Parser
PARSER=$(PARSER_ROOT).php

ETC_FILES:=$(shell find etc/ -type f -name '*')
SRC_FILES:=$(shell find src/ -type f -name '*.php' ! -path $(CONTAINER))

.PHONY: all
all: test analyze build check

.PHONY: clean
clean:
	rm -f composer.lock
	rm -rf vendor
	rm -rf tools

.PHONY: maintainer-clean
maintainer-clean: clean
	@echo 'This command is intended for maintainers to use; it'
	@echo 'deletes files that may need special tools to rebuild.'
	rm -f $(CONTAINER)
	rm -f $(PARSER)

.PHONY: build
build: $(CONTAINER) $(PARSER) $(TARGET)

$(TARGET): vendor/installed $(BOX_CMD) $(SRC_FILES) box.json.dist
	# TODO box does not currently run with php8, this is a temporary fix
	$(COMPOSER_CMD) install --prefer-dist --no-dev
	php7.4 -d phar.readonly=0 $(BOX_CMD) compile --no-restart -c box.json.php8_tmp_fix
	# $(BOX_CMD) compile
	$(COMPOSER_CMD) install

$(CONTAINER): vendor/installed $(ETC_FILES) $(SRC_FILES)
	bin/build_container > $@

$(PARSER): $(PARSER_ROOT).peg
	# TODO phpeg does not currently run with php8, this is a temporary fix
	# $(PHPEG_CMD) generate $<
	cd ..; php7.4 `which $(PHPEG_CMD)` generate readme-tester/$<

.PHONY: test
test: phpspec behat docs

.PHONY: phpspec
phpspec: vendor/installed $(PARSER) $(PHPSPEC_CMD)
	$(PHPSPEC_CMD) run

.PHONY: behat
behat: vendor/installed $(CONTAINER) $(PARSER) $(BEHAT_CMD)
	$(BEHAT_CMD) --stop-on-failure

.PHONY: docs
docs: vendor/installed $(CONTAINER) $(PARSER) $(README_TESTER_CMD)
	$(README_TESTER_CMD) README.md docs --runner process
	$(README_TESTER_CMD) README.md docs --runner eval

.PHONY: continuous-integration
continuous-integration: $(PHPSPEC_CMD) $(BEHAT_CMD) $(README_TESTER_CMD)
	$(PHPSPEC_CMD) run -v
	$(BEHAT_CMD) --verbose
	$(README_TESTER_CMD) README.md docs --output debug --runner process
	$(README_TESTER_CMD) README.md docs --output debug --runner eval
	$(MAKE) phpstan

.PHONY: check
check: $(TARGET)
	./$(TARGET) README.md docs --ignore docs/custom_attributes.md

.PHONY: analyze
analyze: phpstan phpcs

.PHONY: phpstan
phpstan: vendor/installed $(PHPSTAN_CMD)
	$(PHPSTAN_CMD) analyze -c phpstan.neon -l 8 src

.PHONY: phpcs
phpcs: $(PHPCS_CMD)
	# TODO phpcs does not currently run with php8, skipp temporary
	# $(PHPCS_CMD) src --standard=PSR2 --ignore=$(PARSER),$(CONTAINER)
	$(PHPCS_CMD) spec --standard=spec/ruleset.xml

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

tools/installed: .phive/phars.xml
	$(PHIVE_CMD) install --force-accept-unsigned --trust-gpg-keys CF1A108D0E7AE720,31C7E470E2138192
	touch $@

$(PHPSPEC_CMD): tools/installed

$(BEHAT_CMD): tools/installed

$(PHPSTAN_CMD): tools/installed

$(PHPCS_CMD): tools/installed

$(BOX_CMD): tools/installed

$(PHPEG_CMD):
	cgr scato/phpeg:^1
