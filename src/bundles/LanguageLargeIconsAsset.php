<?php

namespace soap\LanguageSwitcher\bundles;

use yii\web\AssetBundle;

/**
 * LanguageLargeIcons asset bundle
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class LanguageLargeIconsAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/soap/yii2-language-picker/src/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/language-switcher.min.css',
        'stylesheets/flags-large.min.css',
    ];

}
