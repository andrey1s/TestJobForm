<?php

namespace Form\Validators;

/**
 * Description of FileType
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class FileType extends AbstractValidator {

    /**
     *
     * @var string
     */
    protected $errorMessage = 'this field not valid filetype';

    /**
     *
     * @var array
     */
    private $fileTypes = array('image/jpeg', 'image/png', 'image/gif');

    /**
     * init
     * @param array $fileTypes
     */
    public function __construct(array $fileTypes) {
        $this->fileTypes = $fileTypes;
    }

    /**
     * validate Element
     *
     * @return boolean
     */
    public function isValid() {
        return empty($_FILES[$this->validateValue]['name']) || in_array($_FILES[$this->validateValue]['type'], $this->fileTypes);
    }

    /**
     * get File Type
     *
     * @return array
     */
    public function getFileTypes() {
        return $this->fileTypes;
    }

    /**
     * set File Type
     *
     * @param array $fileTypes
     */
    public function setFileTypes(array $fileTypes) {
        $this->fileTypes = $fileTypes;
    }

    /**
     * add File Type
     *
     * @param string $fileType
     */
    public function addFileType($fileType) {
        $this->fileTypes[] = $fileType;
    }

}
