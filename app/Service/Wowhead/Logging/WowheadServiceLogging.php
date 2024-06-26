<?php

namespace App\Service\Wowhead\Logging;

use App\Logging\StructuredLogging;

class WowheadServiceLogging extends StructuredLogging implements WowheadServiceLoggingInterface
{
    public function downloadMissingSpellIconsStart(): void
    {
        $this->start(__METHOD__);
    }

    public function downloadMissingSpellIconsFileExists(string $targetFile): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function downloadMissingSpellIconsEnd(): void
    {
        $this->end(__METHOD__);
    }

    public function downloadSpellIconDownloadResult(string $targetFilePath, bool $result): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

}
