<?php

namespace app\utils\queries;
use app\utils\Guid;
use yii\base\Exception;

/**
 * Class FindByIdQueryBase
 * @property-read Guid|int $id Уникальный идентификатор
 */
class FindByIdQueryBase extends QueryBase {

    /**
     * @var int|Guid
     */
    private $_id;

    /**
     * @return Guid|int
     */
    public function getId() {
        return $this->_id;
    }

    public function __construct($id) {
        if (is_int($id) || $id instanceof Guid) {
            $this->_id = $id;
        } else {
            throw new Exception("Id in query may be Integer or Guid type");
        }
        parent::__construct();
    }


}