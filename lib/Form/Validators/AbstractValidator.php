<?php

namespace Form\Validators;

use Translate\TranslateInterface;

/**
 * Description of AbstractValidator
 *
 * @author andrey <asamusev@archer-soft.com>
 */
abstract class AbstractValidator {

    /**
     * @var string
     */
    protected $validateValue;

    /**
     * @var string
     */
    protected $errorMessage = 'this field not valid';

    /**
     * @var TranslateInterface
     */
    protected $translate;

    /**
     * @var array
     */
    protected $attr = array();

    /**
     * set Validate Value
     *
     * @param string $value
     * @return \Form\Validators\AbstractValidator
     */
    public function setValidateValue($value) {
        $this->validateValue = $value;

        return $this;
    }

    /**
     * set Error Message
     *
     * @param string $errorMessage
     * @return \Form\Validators\AbstractValidator
     */
    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * get Error Message
     * @return string
     */
    public function getErrorMessage() {
        return $this->errorMessage;
    }

    /**
     * get attr
     * @return array
     */
    public function getAttr() {
        return $this->attr;
    }

    /**
     * set Attr
     * @param array $attr
     * @return \Form\Validators\AbstractValidator
     */
    public function setAttr(array $attr) {
        $this->attr = $attr;

        return $this;
    }

    /**
     * add attr
     * @param string $name
     * @param string $value
     */
    public function addAttr($name, $value) {
        $this->attr[$name] = $value;

        return $this;
    }

    /**
     * validate element
     * @return boolean
     */
    abstract function isValid();
}
