<?php

namespace App\Console\Commands\CombatLog;

use App\Service\CombatLog\CombatLogServiceInterface;
use App\Service\CombatLog\ResultEvents\BaseResultEvent;

class OutputResultEvents extends BaseCombatLogCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'combatlog:outputresultevents {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes a combat log and outputs the result events in a file next to the combat log.';

    /**
     * Execute the console command.
     *
     * @param CombatLogServiceInterface $combatLogService
     *
     * @return int
     * @throws \Exception
     */
    public function handle(CombatLogServiceInterface $combatLogService): int
    {
        ini_set('memory_limit', '2G');

        $filePath = $this->argument('filePath');

        return $this->parseCombatLogRecursively($filePath, function (string $filePath) use ($combatLogService) {
            if (!str_contains($filePath, '.zip')) {
                $this->comment(sprintf('- Skipping file %s', $filePath));

                return 0;
            }

            return $this->outputResultEvents($combatLogService, $filePath);
        });
    }

    /**
     * @param CombatLogServiceInterface $combatLogService
     * @param string                    $filePath
     *
     * @return int
     * @throws \Exception
     */
    private function outputResultEvents(CombatLogServiceInterface $combatLogService, string $filePath): int
    {
        $this->info(sprintf('Parsing file %s', $filePath));

        $resultEvents = $combatLogService->getResultEvents($filePath);

        $resultingFile = str_replace(['.txt', '.zip'], '_events.txt', $filePath);

        $result = file_put_contents(base_path($resultingFile), $resultEvents->map(function (BaseResultEvent $resultEvent) {
            // Trim to remove CRLF, implode with PHP_EOL to convert to (most likely) linux line endings
            return trim($resultEvent->getBaseEvent()->getRawEvent());
        })->implode(PHP_EOL));

        if ($result) {
            $this->comment(sprintf('- Wrote %d events to %s', $resultEvents->count(), $resultingFile));
        } else {
            $this->warn(sprintf('- Unable to write to file %s', $resultingFile));
        }

        return $result > 0 ? 0 : -1;
    }
}