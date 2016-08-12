# yii2-language-switcher

[![Latest Stable Version](https://poser.pugx.org/soap/yii2-language-switcher/v/stable)](https://packagist.org/packages/soap/yii2-language-switcher)
[![Total Downloads](https://poser.pugx.org/soap/yii2-language-switcher/downloads)](https://packagist.org/packages/soap/yii2-language-switcher)
[![Latest Unstable Version](https://poser.pugx.org/soap/yii2-language-switcher/v/unstable)](https://packagist.org/packages/soap/yii2-language-switcher)
[![License](https://poser.pugx.org/soap/yii2-language-switcher/license)](https://packagist.org/packages/soap/yii2-language-switcher)
[![composer.lock](https://poser.pugx.org/soap/yii2-language-switcher/composerlock)](https://packagist.org/packages/soap/yii2-language-switcher)

Yii2 language switcher to use with codemix/yii2-localeurls.


How to use
----------
First you have to make setting for codemix/yii2-localeurls. Please refer to his document.


```php
<?= \soap\LanguageSwitcher\widgets\LanguageSwitcher::widget([
    'skin' => \soap\LanguageSwitcher\widgets\LanguageSwitcher::SKIN_DROPDOWN,
    'size' => \soap\LanguageSwitcher\widgets\LanguageSwitcher::SIZE_SMALL
]);
```

