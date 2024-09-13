<?php
namespace sts\cli;

interface CommandInterface
{
    public function run(array $args): void;
}
