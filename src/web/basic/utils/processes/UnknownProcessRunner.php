<?php
namespace app\utils\processes;

/**
 * Class UnknownProcessRunner
 */
class UnknownProcessRunner implements ProcessRunnerInterface {

    /**
     * @param string $path
     *
     * @return int
     */
    public function startProcess($path) {
        // TODO: Implement startProcess() method.
    }

    /**
     * @param int $pid
     *
     * @return bool
     */
    public function killProcess($pid) {
        // TODO: Implement killProcess() method.
    }

    public function getPhpExecutable() {
        // TODO: Implement getPhpExecutable() method.
    }

    public function startPhpProcess($scriptPath) {
        // TODO: Implement startPhpProcess() method.
    }

    public function getScriptBasePath() {
        // TODO: Implement getScriptBasePath() method.
    }
}