<?php

namespace hanneskod\readmetester;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class ProjectServiceContainer extends Container
{
    protected $parameters = [];

    public function __construct()
    {
        $this->services = $this->privates = [];
        $this->methodMap = [
            'application' => 'getApplicationService',
        ];

        $this->aliases = [];
    }

    public function compile(): void
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled(): bool
    {
        return true;
    }

    public function getRemovedIds(): array
    {
        return [
            'Crell\\Tukio\\OrderedProviderInterface' => true,
            'Fig\\EventDispatcher\\AggregateProvider' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Psr\\EventDispatcher\\EventDispatcherInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'default_configuration' => true,
            'hanneskod\\readmetester\\Application' => true,
            'hanneskod\\readmetester\\Attribute\\AppendCode' => true,
            'hanneskod\\readmetester\\Attribute\\Assert' => true,
            'hanneskod\\readmetester\\Attribute\\DeclareDirective' => true,
            'hanneskod\\readmetester\\Attribute\\DeclareStrictTypes' => true,
            'hanneskod\\readmetester\\Attribute\\Example' => true,
            'hanneskod\\readmetester\\Attribute\\ExampleContext' => true,
            'hanneskod\\readmetester\\Attribute\\ExpectError' => true,
            'hanneskod\\readmetester\\Attribute\\ExpectNothing' => true,
            'hanneskod\\readmetester\\Attribute\\ExpectOutput' => true,
            'hanneskod\\readmetester\\Attribute\\Ignore' => true,
            'hanneskod\\readmetester\\Attribute\\IgnoreError' => true,
            'hanneskod\\readmetester\\Attribute\\IgnoreOutput' => true,
            'hanneskod\\readmetester\\Attribute\\IgnoreUnmarkedExamples' => true,
            'hanneskod\\readmetester\\Attribute\\Import' => true,
            'hanneskod\\readmetester\\Attribute\\Isolate' => true,
            'hanneskod\\readmetester\\Attribute\\Name' => true,
            'hanneskod\\readmetester\\Attribute\\NamespaceName' => true,
            'hanneskod\\readmetester\\Attribute\\PrependCode' => true,
            'hanneskod\\readmetester\\Attribute\\StartInHtmlMode' => true,
            'hanneskod\\readmetester\\Attribute\\StartInPhpNamespace' => true,
            'hanneskod\\readmetester\\Attribute\\UseClass' => true,
            'hanneskod\\readmetester\\Attribute\\UseConst' => true,
            'hanneskod\\readmetester\\Attribute\\UseFunction' => true,
            'hanneskod\\readmetester\\Compiler\\CompilerFactoryFactory' => true,
            'hanneskod\\readmetester\\Compiler\\CompilerFactoryInterface' => true,
            'hanneskod\\readmetester\\Compiler\\FileInput' => true,
            'hanneskod\\readmetester\\Compiler\\MultipassCompiler' => true,
            'hanneskod\\readmetester\\Compiler\\Pass\\CodeBlockImportingPass' => true,
            'hanneskod\\readmetester\\Compiler\\Pass\\DefaultCompilerPasses' => true,
            'hanneskod\\readmetester\\Compiler\\Pass\\FilterPass' => true,
            'hanneskod\\readmetester\\Compiler\\Pass\\RemoveIgnoredExamplesPass' => true,
            'hanneskod\\readmetester\\Compiler\\Pass\\TransformationPass' => true,
            'hanneskod\\readmetester\\Compiler\\Pass\\UniqueNamePass' => true,
            'hanneskod\\readmetester\\Compiler\\StdinInput' => true,
            'hanneskod\\readmetester\\Config\\ArrayRepository' => true,
            'hanneskod\\readmetester\\Config\\ConfigManager' => true,
            'hanneskod\\readmetester\\Config\\Configs' => true,
            'hanneskod\\readmetester\\Config\\DefaultConfigFactory' => true,
            'hanneskod\\readmetester\\Config\\Suite' => true,
            'hanneskod\\readmetester\\Config\\UserConfigRepository' => true,
            'hanneskod\\readmetester\\Config\\YamlRepository' => true,
            'hanneskod\\readmetester\\Event\\BaseEvent' => true,
            'hanneskod\\readmetester\\Event\\BootstrapIncluded' => true,
            'hanneskod\\readmetester\\Event\\ConfigurationIncluded' => true,
            'hanneskod\\readmetester\\Event\\DebugEvent' => true,
            'hanneskod\\readmetester\\Event\\ErrorEvent' => true,
            'hanneskod\\readmetester\\Event\\EvaluationDone' => true,
            'hanneskod\\readmetester\\Event\\EvaluationSkipped' => true,
            'hanneskod\\readmetester\\Event\\EvaluationStarted' => true,
            'hanneskod\\readmetester\\Event\\ExampleIgnored' => true,
            'hanneskod\\readmetester\\Event\\ExecutionStarted' => true,
            'hanneskod\\readmetester\\Event\\ExecutionStopped' => true,
            'hanneskod\\readmetester\\Event\\ExitStatusListener' => true,
            'hanneskod\\readmetester\\Event\\FileIncluded' => true,
            'hanneskod\\readmetester\\Event\\InvalidInput' => true,
            'hanneskod\\readmetester\\Event\\SuiteDone' => true,
            'hanneskod\\readmetester\\Event\\SuiteStarted' => true,
            'hanneskod\\readmetester\\Event\\TestFailed' => true,
            'hanneskod\\readmetester\\Event\\TestPassed' => true,
            'hanneskod\\readmetester\\Event\\TestingAborted' => true,
            'hanneskod\\readmetester\\ExampleProvider' => true,
            'hanneskod\\readmetester\\ExampleProviderInterface' => true,
            'hanneskod\\readmetester\\Example\\ArrayExampleStore' => true,
            'hanneskod\\readmetester\\Example\\CombinedExampleStore' => true,
            'hanneskod\\readmetester\\Example\\ExampleObj' => true,
            'hanneskod\\readmetester\\Exception\\InstantiatorException' => true,
            'hanneskod\\readmetester\\Exception\\InvalidInputException' => true,
            'hanneskod\\readmetester\\Exception\\InvalidInputLanguageException' => true,
            'hanneskod\\readmetester\\Exception\\InvalidPhpCodeException' => true,
            'hanneskod\\readmetester\\Exception\\InvalidRunnerException' => true,
            'hanneskod\\readmetester\\Expectation\\ErrorExpectation' => true,
            'hanneskod\\readmetester\\Expectation\\ExpectationEvaluator' => true,
            'hanneskod\\readmetester\\Expectation\\Failure' => true,
            'hanneskod\\readmetester\\Expectation\\OutputExpectation' => true,
            'hanneskod\\readmetester\\Expectation\\Success' => true,
            'hanneskod\\readmetester\\Expectation\\VoidExpectation' => true,
            'hanneskod\\readmetester\\FilesystemFacade' => true,
            'hanneskod\\readmetester\\Gherkish\\FeatureContext' => true,
            'hanneskod\\readmetester\\Gherkish\\Scenario' => true,
            'hanneskod\\readmetester\\InputLanguage\\Definition' => true,
            'hanneskod\\readmetester\\InputLanguage\\Markdown\\MarkdownCompilerFactory' => true,
            'hanneskod\\readmetester\\InputLanguage\\Markdown\\Parser' => true,
            'hanneskod\\readmetester\\InputLanguage\\ParserInterface' => true,
            'hanneskod\\readmetester\\InputLanguage\\ParsingCompiler' => true,
            'hanneskod\\readmetester\\InputLanguage\\ReflectiveExampleStoreTemplate' => true,
            'hanneskod\\readmetester\\Output\\DebugOutputtingSubscriber' => true,
            'hanneskod\\readmetester\\Output\\DefaultOutputtingSubscriber' => true,
            'hanneskod\\readmetester\\Output\\JsonOutputtingSubscriber' => true,
            'hanneskod\\readmetester\\Output\\SyntaxHighlighter' => true,
            'hanneskod\\readmetester\\Output\\VoidSyntaxHighlighter' => true,
            'hanneskod\\readmetester\\Runner\\ErrorOutcome' => true,
            'hanneskod\\readmetester\\Runner\\EvalRunner' => true,
            'hanneskod\\readmetester\\Runner\\OutputOutcome' => true,
            'hanneskod\\readmetester\\Runner\\ParallelRunner' => true,
            'hanneskod\\readmetester\\Runner\\ProcessRunner' => true,
            'hanneskod\\readmetester\\Runner\\RunnerFactory' => true,
            'hanneskod\\readmetester\\Runner\\SkippedOutcome' => true,
            'hanneskod\\readmetester\\Runner\\VoidOutcome' => true,
            'hanneskod\\readmetester\\TestMarshal' => true,
            'hanneskod\\readmetester\\Utils\\CodeBlock' => true,
            'hanneskod\\readmetester\\Utils\\Instantiator' => true,
            'hanneskod\\readmetester\\Utils\\Loader' => true,
            'hanneskod\\readmetester\\Utils\\NameObj' => true,
            'hanneskod\\readmetester\\Utils\\Regexp' => true,
            'hanneskod\\readmetester\\Version' => true,
        ];
    }

    /**
     * Gets the public 'application' shared autowired service.
     *
     * @return \Symfony\Component\Console\SingleCommandApplication
     */
    protected function getApplicationService()
    {
        $this->services['application'] = $instance = new \Symfony\Component\Console\SingleCommandApplication();

        $a = new \hanneskod\readmetester\Event\ExitStatusListener();
        $b = new \hanneskod\readmetester\Utils\Instantiator();
        $c = new \Fig\EventDispatcher\AggregateProvider();

        $d = new \Crell\Tukio\OrderedListenerProvider($b);
        $d->addListener([0 => $a, 1 => 'onTestFailed']);
        $d->addListener([0 => $a, 1 => 'onInvalidInput']);

        $c->addProvider($d);

        $e = new \Crell\Tukio\Dispatcher($c);

        $f = new \hanneskod\readmetester\Application(new \hanneskod\readmetester\Config\ConfigManager((new \hanneskod\readmetester\Config\DefaultConfigFactory())->createRepository()), $a, new \hanneskod\readmetester\ExampleProvider(new \hanneskod\readmetester\Compiler\CompilerFactoryFactory($b), new \hanneskod\readmetester\Compiler\Pass\DefaultCompilerPasses(new \hanneskod\readmetester\Compiler\Pass\TransformationPass(), new \hanneskod\readmetester\Compiler\Pass\UniqueNamePass(), new \hanneskod\readmetester\Compiler\Pass\CodeBlockImportingPass(), new \hanneskod\readmetester\Compiler\Pass\RemoveIgnoredExamplesPass($e)), new \hanneskod\readmetester\FilesystemFacade($e)), new \hanneskod\readmetester\Runner\RunnerFactory($b), new \hanneskod\readmetester\TestMarshal(new \hanneskod\readmetester\Expectation\ExpectationEvaluator(), $e), $e, $d);

        $instance->setName('Readme-Tester');
        $instance->setVersion((new \hanneskod\readmetester\Version())->getVersion());
        $instance->setCode($f);
        $f->configure($instance);

        return $instance;
    }
}
