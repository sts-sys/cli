<?php
namespace sts\cli\command;

interface CommandInterface
{
    public function run(array $args): void;
}
