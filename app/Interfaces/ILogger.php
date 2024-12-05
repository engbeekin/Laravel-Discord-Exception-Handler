<?php

namespace App\Interfaces;

interface ILogger
{
    public function addMessage(string $message, bool $showData = false): void;

    public function logMessages(): void;

    public function logException($exception, ?array $errorLocation): void;
}
