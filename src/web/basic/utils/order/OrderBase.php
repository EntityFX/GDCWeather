<?php

namespace app\utils\order;

use app\utils\enum\OrderDirectionEnum;


/**
 * Базовый класс для сортировки
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common\Order
 */
abstract class OrderBase implements IOrder {

    /**
     * @var string|int
     */
    private $_attribute;


    /**
     * @var OrderDirectionEnum
     */
    private $_direction;

    function __construct() {
        $this->_direction = new OrderDirectionEnum(OrderDirectionEnum::ASC);
    }

    /**
     * @param OrderDirectionEnum $direction
     */
    public function setDirection(OrderDirectionEnum $direction) {
        $this->_direction = $direction;
    }

    /**
     * @return OrderDirectionEnum
     */
    public function getDirection() {
        return $this->_direction;
    }

    /**
     * @return array
     */
    protected abstract function getOrderFields();

    /**
     * @return string
     */
    protected abstract function defaultAttribute();

    /**
     *
     * @throws ValidationException
     * @return string|int
     */
    public function getField() {
        /** @var $fieldArray array */
        $fieldArray = $this->getAttributes();

        $attribute = $this->_attribute;
        if ($this->_attribute !== null && $this->_attribute !== '') {
            if (!in_array($this->_attribute, $fieldArray)) {
                throw new ValidationException("Class " . __CLASS__ . " doesn't contain order field");
            }
        } else {
            $attribute = $this->defaultAttribute();
        }
        $orderFields = $this->getOrderFields();

        return $orderFields[$attribute];
    }

    /**
     * @param $attribute Аттрибут сортировки
     */
    public function setAttribute($attribute) {
        $this->_attribute = (string)$attribute;
    }

    /**
     * @return array
     */
    public function getAttributes() {
        return array_keys($this->getOrderFields());
    }

    public function getDefaultAttribute(OrderDirectionEnum $direction = null) {
        return array(
            $this->defaultAttribute() => $direction !== null && $direction->getValue() === OrderDirectionEnum::DESC ? true : false
        );
    }
}
