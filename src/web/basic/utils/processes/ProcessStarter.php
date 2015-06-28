<?php

namespace app\utils\processes;

/**
 * Class ProcessStarter
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class ProcessStarter {
    public static function start($path) {
        self::getProcessRunner()->startProcess($path);
    }

    public static function startPhpScript($path) {
        self::getProcessRunner()->startPhpProcess($path);
    }

    public static function kill($pid) {
        self::getProcessRunner()->killProcess($pid);
    }

    public static function getPhpExecutable() {
        self::getProcessRunner()->getPhpExecutable();
    }

    /**
     *
     * @return ProcessRunnerInterface
     */
    private static function getProcessRunner() {
        $os = self::detectOs();
        switch ($os->getValue()) {
            case ProcessOsTypeEnum::WINDOWS :
                $processRunner = new WindowsProcessRunner();
                break;
            case ProcessOsTypeEnum::LINUX :
                $processRunner = new LinuxProcessRunner();
                break;
            default :
                $processRunner = new UnknownProcessRunner();
        }
        return $processRunner;
    }

    public static function detectOs() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return new ProcessOsTypeEnum(ProcessOsTypeEnum::WINDOWS);
        } else if (PHP_OS === 'Linux') {
            return new ProcessOsTypeEnum(ProcessOsTypeEnum::LINUX);
        }

        return new ProcessOsTypeEnum(ProcessOsTypeEnum::OTHER);
    }
}