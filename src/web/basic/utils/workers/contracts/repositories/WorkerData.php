<?php

namespace app\utils\workers\contracts\repositories;
use SimpleXMLElement;
use DateTime;
use yii\base\Component;
use Yii;

/**
 * Class WorkerData
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property int              $id
 * @property string           $workerName           Навзвание воркера
 * @property string           $className            Имя класса - реализация воркера или его интерфейс
 * @property string           $description          Описание воркера
 * @property WorkerStatusEnum $status               состояние воркера
 * @property DateTime         $startDateTime        Начало работы воркера
 * @property DateTime         $endDateTime          Конец работы воркера
 * @property int              $pid                  PID процесса воркера
 * @property SimpleXmlElement $configuration        XML конфигурация
 */
class WorkerData extends Component {
    /**
     * @var int
     */
    private $_id;
    /**
     * @var string
     */
    private $_workerName;
    /**
     * @var string
     */
    private $_className;
    /**
     * @var WorkerStatusEnum
     */
    private $_status;
    /**
     * @var int
     */
    private $_pid;
    /**
     * @var DateTime
     */
    private $_startDateTime;
    /**
     * @var DateTime
     */
    private $_endDateTime;
    /**
     * @var string
     */
    private $_description;

    /**
     * @var SimpleXmlElement
     */
    private $_configuration;

    /**
     * @return DateTime
     */
    public function getEndDateTime() {
        return $this->_endDateTime;
    }

    /**
     * @param DateTime $endDateTime
     */
    public function setEndDateTime(DateTime $endDateTime = null) {
        $this->_endDateTime = $endDateTime;
    }

    /**
     * @return int
     */
    public function getPid() {
        return $this->_pid;
    }

    /**
     * @param int $pid
     */
    public function setPid($pid = null) {
        $this->_pid = $pid === null ? null : (int)$pid;
    }

    /**
     * @return DateTime
     */
    public function getStartDateTime() {
        return $this->_startDateTime;
    }

    /**
     * @param DateTime $startDateTime
     */
    public function setStartDateTime(DateTime $startDateTime = null) {
        $this->_startDateTime = $startDateTime;
    }

    /**
     * @param SimpleXmlElement $configuration
     */
    public function setConfiguration(SimpleXmlElement $configuration = null) {
        $this->_configuration = $configuration;
    }

    /**
     * @return SimpleXmlElement
     */
    public function getConfiguration() {
        return $this->_configuration;
    }

    /**
     * @return WorkerStatusEnum
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * @param WorkerStatusEnum $status
     */
    public function setStatus(WorkerStatusEnum $status) {
        $this->_status = $status;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->_description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->_description = (string)$description;
    }

    /**
     * @return string
     */
    public function getClassName() {
        return $this->_className;
    }

    /**
     * @param string $className
     */
    public function setClassName($className) {
        $this->_className = (string)$className;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->_id = (int)$id;
    }

    /**
     * @return string
     */
    public function getWorkerName() {
        return $this->_workerName;
    }

    /**
     * @param string $workerName
     */
    public function setWorkerName($workerName) {
        $this->_workerName = (string)$workerName;
    }

    public function getStatusText() {
        $list = array(
            WorkerStatusEnum::ACTIVE      => Yii::t('global', 'Активен'),
            WorkerStatusEnum::IN_PROGRESS => Yii::t('global', 'Выполняется'),
            WorkerStatusEnum::FAILED      => Yii::t('global', 'Ошибка'),
        );

        return $list[$this->_status->getValue()];
    }
}