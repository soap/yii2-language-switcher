<?php

namespace soap\LanguageSwitcher\bundles;

use yii\web\AssetBundle;

/**
 * LanguageSmallIcons asset bundle
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class LanguageSmallIconsAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/soap/yii2-language-switcher/src/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/language-switcher.min.css',
        'stylesheets/flags-small.min.css',
    ];

}
