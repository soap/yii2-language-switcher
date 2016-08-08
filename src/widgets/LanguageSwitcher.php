<?php

namespace soap\LanguageSwitcher\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\base\Widget;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Dropdown;

class LanguagePicker extends Widget
{
    /**
     * Type of pre-defined skins (drop down list).
     */
    const SKIN_DROPDOWN = 'dropdown';

    /**
     * Type of pre-defined skins (button list).
     */
    const SKIN_BUTTON = 'button';

    /**
     * Size of pre-defined skins (small).
     */
    const SIZE_SMALL = 'small';

    /**
     * Size of pre-defined skins (large).
     */
    const SIZE_LARGE = 'large';

    /**
     * @var array List of pre-defined skins.
     */
    private $_SKINS = [
        self::SKIN_DROPDOWN => [
            'itemTemplate' => '<li><a href="{link}" title="{language}"><i class="{language}"></i> {name}</a></li>',
            'activeItemTemplate' => '<a href="" title="{language}"><i class="{language}"></i> {name}</a>',
            'parentTemplate' => '<div class="language-picker dropdown-list {size}"><div>{activeItem}<ul>{items}</ul></div></div>',
        ],
        self::SKIN_BUTTON => [
            'itemTemplate' => '<a href="{link}" title="{language}"><i class="{language}"></i> {name}</a>',
            'activeItemTemplate' => '<a href="{link}" title="{language}" class="active"><i class="{language}"></i> {name}</a>',
            'parentTemplate' => '<div class="language-picker button-list {size}"><div>{items}</div></div>',
        ],
    ];

    /**
     * @var array List of pre-defined skins.
     */
    private $_SIZES = [
        self::SIZE_SMALL => 'soap\LanguagePicker\bundles\LanguageSmallIconsAsset',
        self::SIZE_LARGE => 'soap\LanguagePicker\bundles\LanguageLargeIconsAsset',
    ];
    /**
     * @var string ID of pre-defined skin (optional).
     */
    public $skin;

    /**
     *
     * @var string size of the icons.
     */
    public $size;

    /**
     * @var string The structure of the parent template.
     */
    public $parentTemplate;

    /**
     * @var string The structure of one entry in the list of language elements.
     */
    public $itemTemplate;

    /**
     * @var string The structure of the active language element.
     */
    public $activeItemTemplate;

    /**
     * example: http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
     * @var string Adding StyleSheet and its dependencies.
     */
    public $languageAsset;

    /**
     * @var boolean whether to HTML-encode the link labels.
     */
    public $encodeLabels = true;

    private static $_labels;

    private $_isError;

    private $_items = [];



    public function init()
    {
        $route = Yii::$app->controller->route;
        $appLanguage = Yii::$app->language;
        $params = $_GET;
        $this->_isError = $route === Yii::$app->errorHandler->errorAction;

        array_unshift($params, '/'.$route);

        foreach (Yii::$app->urlManager->languages as $language) {
            $isWildcard = substr($language, -2)==='-*';
            if (
                $language===$appLanguage ||
                // Also check for wildcard language
                $isWildcard && substr($appLanguage,0,2)===substr($language,0,2)
            ) {
                continue;   // Exclude the current language
            }
            if ($isWildcard) {
                $language = substr($language,0,2);
            }
            $params['language'] = $language;
            $this->_items[] = [
                'label' => self::label($language),
                'code' => $language,
                'url' => $params,
            ];
        }

        $this->_initSkin();

        parent::init();
    }

    public function run()
    {
        // Only show this widget if we're not on the error page
        if ($this->_isError) {
            return '';
        } else {
            //if ($this->skin == self::SKIN_BUTTON) {
            //    $languagePicker = $this->_renderButton($isInteger);
            //} else {
                $languagePicker = $this->_renderDropdown();
           // }

            echo $languagePicker;
        }
    }

    public static function label($code)
    {
        if (self::$_labels===null) {
            self::$_labels = [
                'th' => 'Thai',
                'en' => 'English',
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }

    /**
     * Initialising skin.
     */
    private function _initSkin()
    {

        if ($this->skin && empty($this->_SKINS[$this->skin])) {
            throw new \yii\base\InvalidConfigException('The skin does not exist: ' . $this->skin);
        }

        if ($this->size && empty($this->_SIZES[$this->size])) {
            throw new \yii\base\InvalidConfigException('The size does not exist: ' . $this->size);
        }

        if ($this->skin) {
            foreach ($this->_SKINS[$this->skin] as $property => $value) {
                if (!$this->$property) {
                    $this->$property = $value;
                }
            }
        }

        if ($this->size) {
            $this->languageAsset = $this->_SIZES[$this->size];
        }

        $this->_registerAssets();
    }

    /**
     * Adding Assets files to view.
     */
    private function _registerAssets()
    {
        if ($this->languageAsset) {
            $this->view->registerAssetBundle($this->languageAsset);
        }

    }
    /**
     * Rendering dropdown list.
     * @param boolean $isInteger
     * @return string
     */
    private function _renderDropdown()
    {
        $currentLanguage = [
            'code' => Yii::$app->language,
            'label' => self::label(Yii::$app->language),
            'url' => '#'
        ];

        $activeItem = $this->renderItem($currentLanguage, $this->activeItemTemplate);

        $items = '';
        foreach ($this->_items as $language) {
            $items .= $this->renderItem($language, $this->itemTemplate);
        }

        return strtr($this->parentTemplate, ['{activeItem}' => $activeItem, '{items}' => $items, '{size}' => $this->size]);
    }

    /**
     * Rendering languege element.
     * @param string $language The property of a given language.
     * @param string $name The property of a language name.
     * @param string $template The basic structure of a language element of the displayed language picker
     * Elements to replace: "{link}" URL to call when changing language.url
     *  "{name}" name corresponding to a language element, e.g.: English
     *  "{language}" unique identifier of the language element. e.g.: en, en-US
     * @return string the rendered result
     */
    protected function renderItem($language, $template)
    {

        if ($this->encodeLabels) {
            $label = Html::encode($language['label']);
            $name = Html::encode($language['code']);
        }

        return strtr($template, [
            '{link}' => Url::to($language['url']),
            '{name}' => $label,
            '{language}' => $name,
        ]);
    }
}