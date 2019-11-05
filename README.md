# PHP Class\Interface\Trait names extractor from files.

This library extracts entity names from php files.  
Supports plain classes, multiple entity per file, classes within curly namespaces, etc.

![Build Status](https://travis-ci.org/alex-oleshkevich/classnames.svg)
[![Latest Stable Version](https://poser.pugx.org/alex-oleshkevich/classnames/v/stable?1)](https://packagist.org/packages/alex-oleshkevich/classnames)
[![Monthly Downloads](https://poser.pugx.org/alex-oleshkevich/classnames/d/monthly?1)](https://packagist.org/packages/alex-oleshkevich/classnames)
[![Total Downloads](https://poser.pugx.org/alex-oleshkevich/classnames/downloads?1)](https://packagist.org/packages/alex-oleshkevich/classnames)
[![Latest Unstable Version](https://poser.pugx.org/alex-oleshkevich/classnames/v/unstable?1)](https://packagist.org/packages/alex-oleshkevich/classnames)
[![Deps. Status](https://www.versioneye.com/user/projects/57e3b1ed6dfcd00042a4f686/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/57e3b1ed6dfcd00042a4f686)
 
### Installation  
```bash
composer install alex-oleshkevich/classnames
```

### Example  
```php
$extractor = new \ClassNames\ClassNames;
$classes = $extractor->getClassNames('/path/to/file.php');
// or 
$interfaces = $extractor->getInterfaceNames('/path/to/file.php');
// or 
$traits = $extractor->getTraitNames('/path/to/file.php');
```
All functions listed above return a plain array of found entities.
```php
// file "/path/to/file.php"
namespace TestAsset {
    class Asset {}
    class Asset2 {}
}

$extractor = new \ClassNames\ClassNames;
$classes = $extractor->getClassNames('/path/to/file.php');
print_r($classes);
/**
* Array
* (
*     [0] => TestAsset\Asset
*     [1] => TestAsset\Asset2
* )
*/
```

