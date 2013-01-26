<?php

namespace Form\Validators;

/**
 * Description of NotBlank
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class NotBlank extends AbstractValidator {

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = 'Please fill out this field.';

    /**
     * {@inheritdoc}
     */
    public function isValid() {
        return (boolean) strlen($this->validateValue);
    }

}
