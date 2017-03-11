# NamedColors

Find a color's hexadecimal value from its name.

This library does not only list all the HTML colors, but also :

- Australian Independent Colour Standard (AS 2700)
- Some major brands color (_Google_, _Netflix_, _Facebook_, etc)
- [Federal Standard 595](https://en.wikipedia.org/wiki/Federal_Standard_595) colors
- [ISCC–NBS system](https://en.wikipedia.org/wiki/ISCC%E2%80%93NBS_system) colors
- [Natural Color System](https://en.wikipedia.org/wiki/Natural_Color_System) colors
- [RAL colour standard](https://en.wikipedia.org/wiki/RAL_colour_standard) colors
- [Resene](http://www.resene.co.nz/) colors
- [X11 colors](https://en.wikipedia.org/wiki/X11_color_names)
- and some other colors (Crayola colors, food colors, and even [XKCD's colors from its 2010 survey](https://blog.xkcd.com/2010/05/03/color-survey-results/))

## Installation

With composer :

```
composer require brio/named-colors
```

## Usage

```php
use Brio\NamedColors;

// Find a color from its name or reference
// Note that, if multiple matches are possible, the first match is returned
// html colors are always first to be matched
$color = NamedColorsColors::findHexByName('red'); // returns #FF0000
$color = Colors::findHexByName('Google Red'); // returns #EA4335

// Find a color from its name, with a specific color set
$color = NamedColorsColors::findHexByName('red', 'xkcd'); // returns #E50000
```

## Contributing

Feel free to add your own color schemes, as soon as they meet these requirements :
 
 - All colors schemes should be created in the `src/colors` directory
 - They must only contain one array, named `$colors`
 - Each item of this array must have one key, and these three values :
   - reference
   - name
   - hexa
 - The key should be a camelCase version of the color's name
 - `reference` and `name` are not mandatory
 - The `hexa` key is mandatory, it should contain the hexadecimal value of the color, prefixed with a sharp (`#`).