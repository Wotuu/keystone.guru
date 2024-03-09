<?php

namespace App\Service\Cache\Logging;

use App\Logging\StructuredLogging;

class CacheServiceLogging extends StructuredLogging implements CacheServiceLoggingInterface
{

    public function clearIdleKeysStart(?int $seconds): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function clearIdleKeysFailedToDeleteAllKeys(int $amount, int $total): void
    {
        $this->error(__METHOD__, get_defined_vars());
    }

    public function clearIdleKeysProgress(int $index, int $deletedKeysCount): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function clearIdleKeysEnd(): void
    {
        $this->end(__METHOD__);
    }
}
