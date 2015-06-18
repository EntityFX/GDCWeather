<?php
namespace app\utils\logging;

use app\utils\Limit;
use Traversable;

interface RetrieveLogRepositoryInterface {
    /**
     * @param LoggingFilter $filter
     * @param LoggingOrder  $order
     * @param Limit         $limit
     *
     * @return LoggingData[]|Traversable
     */
    public function read(LoggingFilter $filter, LoggingOrder $order, Limit $limit);

    public function count(LoggingFilter $filter);
}