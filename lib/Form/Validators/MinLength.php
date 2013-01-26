<?php

namespace Form\Validators;

/**
 * Description of MinLength
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class MinLength extends AbstractValidator {

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = 'this field min';

    /**
     * @var intager
     */
    private $valid;

    /**
     * init
     *
     * @param integer $valid
     */
    public function __construct($valid) {
        $this->valid = $valid;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid() {
        return strlen($this->validateValue) > $this->valid;
    }

}
