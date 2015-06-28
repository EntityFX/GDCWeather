<?php

namespace app\utils\workers;

interface WorkerInterceptorInterface {

    const EVENT_ON_BEGIN_RUN    = 'onBeginRun';

    const EVENT_ON_END_RUN      = 'onEndRun';

    const EVENT_ON_FAILED       = 'onFailed';

    /**
     * @return WorkerInterface
     */
    public function getWorker();

    public function processRun(array $args);
}