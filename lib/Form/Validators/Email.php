<?php

namespace Form\Validators;

/**
 * Description of Email
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class Email extends AbstractValidator {

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = 'Please enter an email address.';

    /**
     * {@inheritdoc}
     */
    public function isValid() {
        return (boolean) filter_var($this->validateValue, FILTER_VALIDATE_EMAIL);
    }

}
