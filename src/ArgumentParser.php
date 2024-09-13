<?php
namespace sts\cli;

class ArgumentParser
{
    private $arguments = [];
    private $options = [];

    public function __construct(array $args)
    {
        $this->parse($args);
    }

    private function parse(array $args): void
    {
        foreach ($args as $arg) {
            if (strpos($arg, '--') === 0) { // Este o opțiune
                $parts = explode('=', substr($arg, 2), 2);
                $this->options[$parts[0]] = $parts[1] ?? true; // Valoare `true` dacă nu este specificată
            } elseif (strpos($arg, '-') === 0) { // Este o opțiune scurtă
                $this->options[substr($arg, 1)] = true;
            } else { // Este un argument
                $this->arguments[] = $arg;
            }
        }
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOption(string $name, $default = null)
    {
        return $this->options[$name] ?? $default;
    }
}
