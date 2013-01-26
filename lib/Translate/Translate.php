<?php

namespace Translate;

/**
 * Description of Translate
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class Translate implements TranslateInterface {

    /**
     *
     * @var string
     */
    private $destination;

    /**
     *
     * @var array
     */
    private $lang;

    /**
     *
     * @var string
     */
    private $locale;

    /**
     * init
     *
     * @param string $destination
     * @param string $defaultLocale
     * @throws \Exception
     */
    public function __construct($destination, $defaultLocale) {
        $this->setDestination($destination);
        if (!is_readable($this->destination)) {
            throw new \Exception($this->destination . 'is not readable');
        }
        $lang = glob($this->destination . '/*.ini');
        foreach ($lang as $val) {
            $def = pathinfo($val, PATHINFO_FILENAME);
            $this->lang[pathinfo($val, PATHINFO_FILENAME)]['file'] = $val;
        }
        if (isset($this->lang[$defaultLocale])) {
            $this->setLocale($defaultLocale);
        } elseif (isset($def)) {
            $this->setLocale($def);
        } else {
            throw new \Exception('set Locale');
        }
    }

    /**
     * translate
     *
     * @param string $value
     * @return string
     */
    public function translate($value) {
        if (isset($this->lang[$this->locale]['text'][$value])) {
            return $this->lang[$this->locale]['text'][$value];
        }
        return $value;
    }

    /**
     * parse Lang File
     *
     * @return \Translate\Translate
     */
    public function parseLangFile() {
        $this->lang[$this->locale]['text'] = parse_ini_file($this->lang[$this->locale]['file']);
        return $this;
    }

    /**
     * set Locale
     *
     * @param string $locale
     * @return \Translate\Translate
     * @throws \Exception
     */
    public function setLocale($locale) {
        if (isset($this->lang[$locale])) {
            $this->locale = $locale;
            $this->parseLangFile();
        } else {
            throw new \Exception('set Locale');
        }

        return $this;
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
     * set Destination
     *
     * @param string $destination
     */
    public function setDestination($destination) {
        $this->destination = $destination;

        return $this;
    }

}
