<?php

namespace sts\command;

class GreetCommand
{
    public function run(array $args)
    {
        $name = $args[0] ?? 'World';
        echo "Salut, $name!\n";
    }
}
