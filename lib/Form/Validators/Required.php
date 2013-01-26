<?php

namespace Form\Validators;

/**
 * Description of Required
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class Required extends AbstractValidator {

    protected $errorMessage = 'Please fill out this field.';

    /**
     * init
     */
    public function __construct() {
        $this->addAttr('required', 'required');
    }

    /**
     * {@inheritdoc}
     */
    public function isValid() {
        $value = trim($this->validateValue);
        return empty($value);
    }

}
