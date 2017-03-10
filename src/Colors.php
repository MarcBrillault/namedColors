<?php

namespace Brio\NamedColors;

class Colors
{
    private static $_instance          = null;
    private        $_colorsClassesPath = __DIR__ . '/colors/';
    public         $colors             = [];

    /**
     * Returns an array with the color information if the color is found
     * Returns an empty array otherwise
     *
     * @param string $name
     * @param string $index
     * @return array
     */
    public static function findByName($name, $index = null)
    {
        $self = self::_getInstance();
        if ($index === null) {
            foreach ($self->colors as $colorFamily => $colors) {
                foreach ($colors as $colorName => $colorData) {
                    if ($name == $colorName || $name == $colorData['name'] || $name == $colorData['reference']) {
                        return $colorData;
                    }
                }
            }
        } elseif (array_key_exists($index, $self->colors)) {
            foreach ($self->colors[$index] as $colorName => $colorData) {
                if ($name == $colorName || $name == $colorData['name'] || $name == $colorData['reference']) {
                    return $colorData;
                }
            }
        }

        return [];
    }

    /**
     * @param string $name
     * @param string $index
     * @return string
     */
    public static function findHexByName($name, $index = null)
    {
        $return = self::findByName($name, $index);
        if (!empty($return)) {
            return $return['hexa'];
        }

        return null;
    }

    /**
     * NamedColors constructor.
     */
    private function __construct()
    {
        $this->_createColorsArray();
        $this->_setFirst('html');
    }

    /**
     * @return \Brio\NamedColors\Colors
     */
    private static function _getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Creates the main $_colors array, from the files found in the colors directory
     */
    private function _createColorsArray()
    {
        $files = scandir($this->_colorsClassesPath);
        foreach ($files as $file) {
            $pathinfo = pathinfo($file);
            if ($pathinfo['extension'] === 'php') {
                unset($colors);
                $name = $pathinfo['filename'];
                include($this->_colorsClassesPath . $file);
                if (isset($colors) && is_array($colors)) {
                    $this->colors[$name] = $colors;
                }
            }
        }
    }

    /**
     * Puts the $key key at the beginning of the $_colors array
     *
     * @param string $key
     * @return void
     */
    private function _setFirst($key)
    {
        if (empty($this->colors) || !array_key_exists($key, $this->colors)) {
            return;
        }

        $tmp = $this->colors[$key];
        unset($this->colors[$key]);
        $this->colors = array_merge([$key => $tmp], $this->colors);
    }
}