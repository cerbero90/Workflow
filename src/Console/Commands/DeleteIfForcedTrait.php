<?php

namespace Cerbero\Workflow\Console\Commands;

/**
 * Trait to delete files if forced.
 *
 * @author    Andrea Marco Sartori
 */
trait DeleteIfForcedTrait
{
    /**
     * Delete the given files if force is set.
     *
     * @author    Andrea Marco Sartori
     *
     * @return void
     */
    protected function deleteIfForced(array $files)
    {
        if (!$this->option('force')) {
            return;
        }

        foreach ($files as $file) {
            if ($this->files->exists($path = $this->getPath($file))) {
                $this->files->delete($path);
            }
        }
    }
}
