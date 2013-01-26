<?php

namespace Form\Elements;

use Form\Validators\AbstractValidator as Validator;

/**
 * Description of Input
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class Input extends AbstractElement {

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $value;

    /**
     *
     * @var string
     */
    protected $label;

    /**
     *
     * @var array
     */
    protected $validators;

    /**
     * init
     *
     * @param string $name
     * @param string $type
     * @param array $attr
     */
    public function __construct($name, $type = 'text', array $attr = array()) {
        $this->setName($name);
        $this->setType($type);
        $this->setArrayAttr($attr);
        $this->setLabel($name);
    }

    /**
     * add validators
     *
     * @return \Form\Elements\Input
     * @throws Exception
     */
    public function addValidators() {
        $validators = func_get_args();
        foreach ($validators as $validator) {
            if ($validator instanceof Validator) {
                $this->setArrayAttr($validator->getAttr());
                $this->validators[] = $validator;
            } else {
                throw new Exception('faled validator');
            }
        }

        return $this;
    }

    /**
     * validate Element
     *
     * @return boolean
     */
    public function isValid() {
        $valid = true;
        foreach ($this->validators as $validator) {
            $validator->setValidateValue($this->value);
            if ($validator->isValid() != true) {
                $valid = false;
                $this->addErrorMessage($validator->getErrorMessage());
            }
        }
        return $valid;
    }

    /**
     * get Type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * set Type
     *
     * @param string $type
     * @return \Form\Elements\Input
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * get Value
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * set Value
     * @param string $value
     * @return \Form\Elements\Input
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    /**
     * get Label
     *
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     *
     * @param type $label
     * @return \Form\Elements\Input
     */
    public function setLabel($label) {
        $this->label = $label;

        return $this;
    }

    /**
     * set Id
     *
     * @param string $id
     * @return \Form\Elements\Input
     */
    public function setId($id) {
        $this->attr['id'] = (string) $id;

        return $this;
    }

    /**
     * get Id
     *
     * @return string
     */
    public function getId() {
        return $this->attr['id'];
    }

    /**
     * render Element
     *
     * @return string
     */
    public function render() {
        if (!$this->getAttr('id')) {
            $this->setAttr('id', $this->getFormName() . '__' . $this->getName());
        }
        $value = '';
        if (!empty($this->value)) {
            $value = 'value="' . $this->value . '" ';
        }
        return '<label for="' . $this->getId() . '">' . $this->translate($this->label) . '</label>'
                . '<input type="' . $this->type . '" name="' . $this->name . '" ' . $value . $this->getStrAttr() . ' placeholder="' . $this->getLabel() . '">'
                . $this->getStrErrorMessage();
    }

}
