<?php

namespace app\utils\processes;

use Yii;

class LinuxProcessRunner extends ProcessRunnerBase implements ProcessRunnerInterface {

    /**
     * @param string $path
     *
     * @return int
     */
    public function startProcess($path) {
        Yii::info("LinuxProcessRunner::startProcess - $path", 'application.components.common.processes.LinuxProcessRunner');
        shell_exec($path);
    }

    /**
     * @param int $pid
     *
     * @return bool
     */
    public function killProcess($pid) {
        $handle = exec("kill $pid");
    }

    public function getPhpExecutable() {
        return $this->getPhpExecutablePath() . 'php';
    }

    public function startPhpProcess($scriptPath) {
        $this->startProcess("nohup " . $this->getPhpExecutable() . ' ' . $this->getScriptBasePath() . '/' . "$scriptPath > /tmp/kontinent_worker_log.txt 2>&1 &");
    }
}
