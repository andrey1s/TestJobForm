<?php

namespace Form\Elements;

/**
 * Description of Submit
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class Submit extends Input {

    /**
     *
     * @param string $name
     * @param string $type
     * @param array $attr
     */
    public function __construct($name, $type = 'text', array $attr = array()) {
        parent::__construct($name, $type, $attr);
        $this->setType('submit');
    }

    /**
     * render Submit Element
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
        return '<input type="' . $this->type . '" name="' . $this->name . '" ' . $value . $this->getStrAttr() . '">';
    }

}

?>
