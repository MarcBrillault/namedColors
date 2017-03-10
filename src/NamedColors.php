<?php

namespace Brio;

class NamedColors
{
    private static $_instance          = null;
    private        $_colorsClassesPath = __DIR__ . '/colors/';
    private        $_colors            = [];

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
            foreach ($self->_colors as $colorFamily => $colors) {
                foreach ($colors as $colorName => $colorData) {
                    if ($name == $colorName || $name == $colorData['name'] || $name == $colorData['reference']) {
                        return $colorData;
                    }
                }
            }
        } elseif (array_key_exists($index, $self->_colors)) {
            foreach ($self->_colors[$index] as $colorName => $colorData) {
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
     *
     * @return void
     */
    private function __construct()
    {
        $this->_createColorsArray();
        $this->_setFirst('html');
    }

    /**
     * This method's singleton
     *
     * @return \Brio\NamedColors
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
     *
     * @return void
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
                    $this->_colors[$name] = $colors;
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
        if (empty($this->_colors) || !array_key_exists($key, $this->_colors)) {
            return;
        }

        $tmp = $this->_colors[$key];
        unset($this->_colors[$key]);
        $this->_colors = array_merge([$key => $tmp], $this->_colors);
    }
}