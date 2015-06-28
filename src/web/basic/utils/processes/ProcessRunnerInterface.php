<?php

namespace app\utils\processes;

interface ProcessRunnerInterface {
    /**
     * @param string $path
     *
     * @return int
     */
    public function startProcess($path);

    public function startPhpProcess($scriptPath);

    /**
     * @param int $pid
     *
     * @return bool
     */
    public function killProcess($pid);

    public function getPhpExecutable();

    public function getScriptBasePath();
}