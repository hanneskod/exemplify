<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Name;

class NamespacedName implements NameInterface
{
    private const INVALID_CHAR_REGEXP = "/[^a-z0-9.\\/_-]/i";

    private string $namespace;
    private string $shortName;

    public static function fromString(string $name, string $defaultNamespace = ''): self
    {
        $parts = explode(self::NAMESPACE_DELIMITER, $name, 2);

        return new self(
            isset($parts[1]) ? $parts[0] : $defaultNamespace,
            $parts[1] ?? $parts[0]
        );
    }

    public function __construct(string $namespace, string $shortName)
    {
        $this->namespace = self::sanitizeName($namespace);
        $this->shortName = self::sanitizeName($shortName);
    }

    public function getCompleteName(): string
    {
        return $this->getNamespaceName()
            ? $this->getNamespaceName() . self::NAMESPACE_DELIMITER . $this->getShortName()
            : $this->getShortName();
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getNamespaceName(): string
    {
        return $this->namespace;
    }

    public function equals(NameInterface $name): bool
    {
        return $name->getCompleteName() == $this->getCompleteName();
    }

    public function isUnnamed(): bool
    {
        return false;
    }

    private static function sanitizeName(string $name): string
    {
        return preg_replace(
            self::INVALID_CHAR_REGEXP,
            '',
            str_replace(' ', '-', $name)
        );
    }
}