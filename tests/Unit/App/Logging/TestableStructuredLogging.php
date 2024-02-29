<?php

namespace Tests\Unit\App\Logging;

use App\Logging\StructuredLogging;
use Illuminate\Log\LogManager;

class TestableStructuredLogging extends StructuredLogging
{
    private LogManager $logManager;

    /**
     * @param LogManager $logManager
     */
    public function __construct(LogManager $logManager)
    {
        parent::__construct();

        $this->logManager = $logManager;
    }


    public function start(string $functionName, array $context = []): void
    {
        parent::start($functionName, $context);
    }

    public function end(string $functionName, array $context = []): void
    {
        parent::end($functionName, $context);
    }

    public function debug(string $functionName, array $context = []): void
    {
        parent::debug($functionName, $context);
    }

    public function notice(string $functionName, array $context = []): void
    {
        parent::notice($functionName, $context);
    }

    public function info(string $functionName, array $context = []): void
    {
        parent::info($functionName, $context);
    }

    public function warning(string $functionName, array $context = []): void
    {
        parent::warning($functionName, $context);
    }

    public function error(string $functionName, array $context = []): void
    {
        parent::error($functionName, $context);
    }

    public function critical(string $functionName, array $context = []): void
    {
        parent::critical($functionName, $context);
    }

    public function emergency(string $functionName, array $context = []): void
    {
        parent::emergency($functionName, $context);
    }

    protected function logger(): LogManager
    {
        return $this->logManager;
    }
}
