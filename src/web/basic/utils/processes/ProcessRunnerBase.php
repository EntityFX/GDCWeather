<?php

namespace app\utils\processes;

abstract class ProcessRunnerBase implements  ProcessRunnerInterface {
    protected function getPhpExecutablePath() {
        if (Yii::app()->workerManager->useInterpreterPath) {
            if (Yii::app()->workerManager->phpInterpreterPath !== null) {
                return Yii::app()->workerManager->phpInterpreterPath;
            }
            return PHP_BINDIR .'/';
        } else {
            return '';
        }
    }

    public function getScriptBasePath() {
        return $_SERVER[DOCUMENT_ROOT];
    }
}