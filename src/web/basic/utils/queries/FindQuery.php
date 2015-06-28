<?php
/**
 * Created by JetBrains PhpStorm.
 * User: SolopiyA
 * Date: 02.07.13
 * Time: 19:51
 * To change this template use File | Settings | File Templates.
 */

namespace app\utils\queries;
use app\utils\filters\FilterBase;
use app\utils\Limit;
use app\utils\order\OrderBase;

/**
 * Class FindQuery
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property-read FilterBase $filter
 * @property-read OrderBase $order
 * @property-read Limit $limit
 */
class FindQuery extends QueryBase {
    /**
     * @var FilterBase
     */
    private $_filter;
    /**
     * @var OrderBase
     */
    private $_order;
    /**
     * @var Limit
     */
    private $_limit;

    public function __construct(FilterBase $filter = null, OrderBase $order = null, Limit $limit = null) {
        parent::__construct();
        $this->_filter = $filter;
        $this->_order  = $order;
        $this->_limit  = $limit;
    }

    /**
     * @return FilterBase
     */
    public function getFilter() {
        return $this->_filter;
    }

    /**
     * @return Limit
     */
    public function getLimit() {
        return $this->_limit;
    }

    /**
     * @return OrderBase
     */
    public function getOrder() {
        return $this->_order;
    }

}