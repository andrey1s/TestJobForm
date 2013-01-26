<?php

namespace Form\Elements;

use Translate\TranslateInterface;

/**
 * Description of AbstractElement
 *
 * @author andrey <asamusev@archer-soft.com>
 */
abstract class AbstractElement {

    /**
     * @var array
     */
    protected $attr = array();

    /**
     * @var string
     */
    protected $formName;

    /**
     * @var array
     */
    protected $errorMessages = array();

    /**
     * @var string
     */
    protected $name;

    /**
     * add Error Message
     *
     * @param string $message
     * @return array
     */
    public function addErrorMessage($message) {
        return $this->errorMessages[] = $message;
    }

    /**
     * get Error Messages
     *
     * @return array
     */
    public function getErrorMessages() {
        return $this->errorMessages;
    }

    /**
     * set Error Messages
     *
     * @param array $errorMessages
     * @return \Form\Elements\AbstractElement
     */
    public function setErrorMessages(array $errorMessages) {
        $this->errorMessages = $errorMessages;

        return $this;
    }

    /**
     * merge Attr
     *
     * @param array $attr
     * @return \Form\Elements\AbstractElement
     */
    public function setArrayAttr(array $attr) {
        $this->attr = array_merge($this->attr, $attr);

        return $this;
    }

    /**
     * set Attr
     *
     * @param string $name
     * @param string $value
     * @return \Form\Elements\AbstractElement
     */
    public function setAttr($name, $value) {
        $this->attr[$name] = $value;

        return $this;
    }

    /**
     * get Attr
     *
     * @param string $name
     * @return string
     */
    public function getAttr($name) {
        if (isset($this->attr[$name])) {
            return $this->attr[$name];
        }

        return '';
    }

    /**
     * get Error Messages
     *
     * @return string
     */
    public function getStrErrorMessage() {
        $text = '';
        foreach ($this->errorMessages as $message) {
            $text .= '<li>' . $this->translate($message) . '</li>';
        }
        if ($text) {
            $text = '<ul>' . $text . '</ul>';
        }
        return $text;
    }

    /**
     * get Attr string
     *
     * @return string
     */
    public function getStrAttr() {
        $str = '';
        foreach ($this->attr as $key => $val) {
            $str .= $key . '="' . $val . '" ';
        }
        return $str;
    }

    /**
     * set Ttranslate
     *
     * @param \Translate\TranslateInterface $translate
     * @return \Form\Elements\AbstractElement
     */
    public function setTranslate(TranslateInterface $translate = null) {
        $this->translate = $translate;

        return $this;
    }

    /**
     * translate
     * @param string $value
     * @return string
     */
    public function translate($value) {
        if ($this->translate) {
            return $this->translate->translate($value);
        }

        return $value;
    }

    /**
     * set Form Name
     * @param string $name
     * @return \Form\Elements\AbstractElement
     */
    public function setFormName($name) {
        $this->formName = $name;

        return $this;
    }

    /**
     * get Form Name
     * @return \Form\Elements\AbstractElement
     */
    public function getFormName() {
        return $this->formName;

        return $this;
    }

    /**
     * get Name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * set Name
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * render Element
     *
     * @return string
     */
    public abstract function render();
}
