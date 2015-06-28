<?php

namespace app\utils\processes;

use Yii;

class WindowsProcessRunner extends ProcessRunnerBase implements ProcessRunnerInterface {

    /**
     * @param string $path
     *
     * @return int
     */
    public function startProcess($path) {
        Yii::info("WindowsProcessRunner::startProcess - start /b $path");
        pclose(popen("start /b $path", 'w'));
    }

    /**
     * @param int $pid
     *
     * @return bool
     */
    public function killProcess($pid) {
        $handle = popen("taskkill /pid {$pid} /f", "r");
        $result = fread($handle, 100);
    }

    public function getPhpExecutable() {
        return $this->getPhpExecutablePath() . 'php.exe';
    }

    public function startPhpProcess($scriptPath) {
        $this->startProcess($this->getPhpExecutable() . ' ' . $this->getScriptBasePath(). '/' .$scriptPath);
    }
}