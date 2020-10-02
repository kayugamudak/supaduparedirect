<?php

namespace services;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger
{
    /**
     * @var string Путь к файлу
     */
    public $filePath;

    /**
     * @inheritdoc
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        if (!file_exists($this->filePath))
        {
            touch($this->filePath);
        }
    }

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = [])
    {
        file_put_contents($this->filePath, trim($message) . PHP_EOL, FILE_APPEND);
    }
}
