<?php

namespace Form\Validators;

/**
 * Description of MaxLength
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class MaxLength extends AbstractValidator {

    /**
     * @var string
     */
    protected $errorMessage = 'this field max length';

    /**
     * @var integer
     */
    private $valid;

    /**
     * init
     *
     * @param integer $valid
     */
    public function __construct($valid) {
        $this->valid = $valid;
        $this->addAttr('maxlength', $valid);
    }

    /**
     * {@inheritdoc}
     */
   public function isValid() {
        return strlen($this->validateValue) < $this->valid;
    }

}
