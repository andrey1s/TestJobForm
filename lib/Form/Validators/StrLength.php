<?php

namespace Form\Validators;

/**
 * Description of StrLength
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class StrLength extends AbstractValidator {

    /**
     * @var integer
     */
    private $valid;

    /**
     * @param integer $valid
     */
    public function __construct($valid) {
        $this->valid = $valid;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid() {
        return strlen($this->validateValue) == $this->valid;
    }

}
