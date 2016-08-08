<?php

namespace lajax\languagepicker\bundles;

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
    public $sourcePath = '@vendor/soap/yii2-language-picker/src/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/language-picker.min.css',
        'stylesheets/flags-small.min.css',
    ];

}
