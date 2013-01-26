<?php

namespace Form\Elements;

/**
 * Description of File
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class File extends Input {

    /**
     *
     * @var string
     */
    private $destination;

    /**
     *
     * @var string
     */
    private $fileName;

    /**
     * init
     *
     * @param string $name
     * @param string $destination
     * @param array $attr
     */
    public function __construct($name, $destination, array $attr = array()) {
        $this->setDestination($destination);
        parent::__construct($name, 'file', $attr);
    }

    /**
     * set Destination
     *
     * @param string $destination
     */
    public function setDestination($destination) {
        $this->destination = $destination;
    }

    /**
     * get Destination
     *
     * @return string
     */
    public function getDestination() {
        return $this->destination;
    }

    /**
     * upload File
     * @return boolean
     * @throws \Exception
     */
    public function getValue() {
        if (empty($this->destination)) {
            throw new \Exception('please set destination patch');
        } elseif (!is_writable($this->destination)) {
            throw new \Exception('please set write destination patch');
        }
        if ($this->getFileName()) {
            if (move_uploaded_file($_FILES[$this->getName()]['tmp_name'], $this->getDestination() . $this->getFileName())) {
                return $this->getFileName();
            }
        }
        return false;
    }

    /**
     * getFile Name
     *
     * @return string
     */
    public function getFileName() {
        if (empty($this->fileName)) {
            $this->setFileName($_FILES[$this->getName()]['name']);
        }
        return $this->fileName;
    }

    /**
     * set File Name
     *
     * @param string $fileName
     */
    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    /**
     * validate Element
     *
     * @return boolean
     */
    public function isValid() {
        $valid = true;
        foreach ($this->validators as $validator) {
            $validator->setValidateValue($this->name);
            if ($validator->isValid() != true) {
                $valid = false;
                $this->addErrorMessage($validator->getErrorMessage());
            }
        }
        return $valid;
    }

}
