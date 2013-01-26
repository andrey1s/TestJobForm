<?php

namespace Form;

use Form\Elements;
use Translate\TranslateInterface;

/**
 * Description of Form
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class Form {

    /**
     *
     * @var array
     */
    private $elements = array();

    /**
     *
     * @var TranslateInterface
     */
    private $translate;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string
     */
    private $enctype;

    /**
     *
     * @var string POST|GET
     */
    private $method;

    /**
     *
     * @param string $name
     */
    public function __construct($name) {
        $this->setName($name);
    }

    /**
     * add Input Element
     *
     * @param string $name
     * @param string $type
     * @param array $attr
     * @return \Form\Elements\Input
     */
    public function addInputElement($name, $type = 'text', array $attr = array()) {
        $element = new Elements\Input($name, $type, $attr);
        $this->addElement($element);

        return $element;
    }

    /**
     * add Element
     *
     * @param \Form\Elements\AbstractElement $element
     * @return \Form\Form
     */
    public function addElement(Elements\AbstractElement $element) {
        $element->setFormName($this->getName());
        $element->setTranslate($this->translate);
        $this->elements[] = $element;

        return $this;
    }

    /**
     * add Elements
     *
     * @return \Form\Form
     */
    public function addElements() {
        $elements = func_get_args();
        foreach ($elements as $el) {
            $this->addElement($el);
        }
        return $this;
    }

    /**
     * render form
     *
     * @return string
     */
    public function render() {
        $form = '';
        foreach ($this->elements as $element) {
            $form .= $element->render();
        }

        return $form;
    }

    /**
     * bind form
     *
     * @param array $data
     * @return \Form\Form
     */
    public function bind(array $data) {
        foreach ($this->elements as $element) {
            if (isset($data[$element->getName()])) {
                $element->setValue($data[$element->getName()]);
            }
        }

        return $this;
    }

    /**
     * validate form
     *
     * @return boolean
     */
    public function isValid() {
        $valid = true;
        foreach ($this->elements as $element) {
            if (!$element->isValid()) {
                $valid = false;
            }
        }
        return $valid;
    }

    /**
     * get All values
     *
     * @return type
     */
    public function getValues() {
        $return = array();
        foreach ($this->elements as $element) {
            $return[$element->getName()] = $element->getValue();
        }

        return $return;
    }

    /**
     * get Value by name
     *
     * @param string $name
     * @return string
     */
    public function getValue($name) {
        $value = '';
        if ($el = $this->searchElement('Name', $name)) {
            $value = $el->getValue();
        }

        return $value;
    }

    /**
     * get Element
     *
     * @param string $name
     * @return \Form\Elements\AbstractElement | false
     */
    public function getElement($name) {
        return $this->searchElement('Name', $name);
    }

    /**
     * add translate
     *
     * @param \Translate\TranslateInterface $translate
     */
    public function setTranslate(TranslateInterface $translate = null) {
        $this->translate = $translate;
    }

    /**
     * get Name Form
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * set Form name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * get Enctype Form
     *
     * @return string
     */
    public function getEnctype() {
        if ($this->enctype) {
            return $this->enctype;
        } elseif ($this->searchElement('Type', 'file')) {
            $this->setEnctype(' multipart/form-data');
        } else {
            $this->setEnctype('application/x-www-form-urlencoded');
        }

        return $this->enctype;
    }

    /**
     * set Enctype form
     *
     * @param string $enctype
     */
    public function setEnctype($enctype) {
        $this->enctype = $enctype;
    }

    /**
     * get Method form
     *
     * @return string
     */
    public function getMethod() {
        if (!$this->method) {
            $this->setMethod('POST');
        }
        return $this->method;
    }

    /**
     * set Method form
     *
     * @param string $method POST|GET
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * validate REQUEST METHOD
     *
     * @param strind $method
     * @return booleam
     */
    public function isRequestMethod($method) {
        return $_SERVER['REQUEST_METHOD'] == $method;
    }

    /**
     * search element form
     *
     * @param string $name example Type|Name
     * @param string $value
     * @return \Form\Elements\AbstractElement
     * @throws \Exception
     */
    private function searchElement($name, $value) {
        $return = false;
        $method = 'get' . $name;
        $exist = array_filter($this->elements, function($el) use (&$value, &$method) {
                    if (!method_exists($el, $method)) {
                        throw new \Exception('method ' . $method . 'not exists');
                    }
                    return $el->{$method}() == $value;
                });
        if (count($exist)) {
            $return = current($exist);
        }
        return $return;
    }

}
