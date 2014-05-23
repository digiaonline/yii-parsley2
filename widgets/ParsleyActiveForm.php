<?php
/**
 * ParsleyActiveForm class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.widgets
 */

/**
 * Active form with support for client-side validation through parsley.js.
 * @see http://parsleyjs.org/
 *
 * Methods accessible through the 'TbWidget' class:
 * @method string resolveId($id = null)
 * @method string publishAssets($path, $forceCopy = false)
 * @method void registerCssFile($url, $media = '')
 * @method void registerScriptFile($url, $position = null)
 * @method string resolveScriptVersion($filename, $minified = false)
 * @method CClientScript getClientScript()
 */
class ParsleyActiveForm extends TbActiveForm
{
    /**
     * Yii::t() is the default i18n locale.
     */
    const DEFAULT_I18N = 'yii';

    /**
     * @var bool if scripts should be registered through CClientScript component.
     */
    public $registerScripts = true;

    /**
     * @var array the javascript options for parsley.js.
     * @see http://parsleyjs.org/doc/annotated-source/defaults.html
     *
     * Plugin default options:
     * array (
     *  'namespace' => 'data-parsley-',
     *  'inputs' => 'input, textarea, select',
     *  'excluded' => 'input[type=button], input[type=submit], input[type=reset], input[type=hidden]',
     *  'priorityEnabled' => true,
     *  'uiEnabled' => true,
     *  'validationThreshold' => 3,
     *  'focus' => 'first',
     *  'trigger' => false,
     *  'errorClass' => 'parsley-error',
     *  'successClass' => 'parsley-success',
     *  'classHandler' => function (ParsleyField) {},
     *  'errorsContainer' => function (ParsleyField) {},
     *  'errorsWrapper' => '<ul class="parsley-errors-list"></ul>',
     *  'errorTemplate' => '<li></li>'
     * )
     */
    public $pluginOptions = array();

    /**
     * @var bool whether to use HTML5 attributes instead of data-attributes.
     */
    public $html5Mode = false;

    /**
     * @var string the locale to use for error message translation.
     * The default 'yii' means that error messages are translated through Yii::t().
     */
    public $i18n = self::DEFAULT_I18N;

    /**
     * @var string the asset path for parsley script files.
     */
    public $scriptAssetPathAlias = 'root.bower_components.parsleyjs.dist';

    /**
     * @var string the asset path for i18n translation files.
     */
    public $i18nAssetPathAlias = 'root.bower_components.parsleyjs.src.i18n';

    /**
     * @var array list of supported i18n locales provided by parsley.
     */
    protected static $supportedI18n = array(
        'bg', 'da', 'de', 'en', 'es', 'fr', 'he', 'id', 'it', 'ja', 'nl', 'pl', 'ru', 'sv', 'zh_cn'
    );

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->i18n !== self::DEFAULT_I18N && !in_array($this->i18n, self::$supportedI18n)) {
            throw new CException(sprintf('Unsupported i18n locale "%s".', $this->i18n));
        }
        if (!$this->registerScripts) {
            $this->htmlOptions['data-parsley-validate'] = '';
            $this->htmlOptions['data-parsley-plugin-options'] = CJSON::encode($this->pluginOptions);
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo TbHtml::endForm();

        if ($this->registerScripts) {
            $this->registerAssets();
            $this->registerDefaultMessages();
            $this->bindPlugin();
        }
    }

    /**
     * @inheritdoc
     */
    public function createInput($type, $model, $attribute, $htmlOptions = array(), $data = array())
    {
        $this->registerValidators($model, $attribute, $htmlOptions);
        return parent::createInput($type, $model, $attribute, $htmlOptions, $data);
    }

    /**
     * @inheritdoc
     */
    public function createControlGroup($type, $model, $attribute, $htmlOptions = array(), $data = array())
    {
        $this->registerValidators($model, $attribute, $htmlOptions);
        return parent::createControlGroup($type, $model, $attribute, $htmlOptions, $data);
    }

    /**
     * Registers the assets for this plugin, i.e. the parsley js script files.
     * @see http://parsleyjs.org/doc/index.html#installation
     */
    protected function registerAssets()
    {
        $this->publishAssets(Yii::getPathOfAlias($this->scriptAssetPathAlias));
        $fileName = YII_DEBUG ? 'parsley.js' : 'parsley.min.js';
        $this->registerScriptFile($fileName, CClientScript::POS_END);
        $fileName = YII_DEBUG ? 'parsley.remote.js' : 'parsley.remote.min.js';
        $this->registerScriptFile($fileName, CClientScript::POS_END);
    }

    /**
     * Registers the default error messages for the parsley validators.
     * @see http://parsleyjs.org/doc/index.html#psly-installation-localization
     */
    protected function registerDefaultMessages()
    {
        if ($this->i18n === self::DEFAULT_I18N) {
            $id = $this->getId();
            $messages = array(
                'defaultMessage' => Yii::t('validation', 'This value seems to be invalid.'),
                'type' => array(
                    'email' => Yii::t('validation', 'This value should be a valid email.'),
                    'url' => Yii::t('validation', 'This value should be a valid url.'),
                    'number' => Yii::t('validation', 'This value should be a valid number.'),
                    'integer' => Yii::t('validation', 'This value should be a valid integer.'),
                    'digits' => Yii::t('validation', 'This value should be digits.'),
                    'alphanum' => Yii::t('validation', 'This value should be alphanumeric.'),
                ),
                'required' => Yii::t('validation', 'This value should not be blank.'),
                'pattern' => Yii::t('validation', 'This value seems to be invalid.'),
                'min' => Yii::t('validation', 'This value should be greater than or equal to %s.'),
                'max' => Yii::t('validation', 'This value should be lower than or equal to %s.'),
                'range' => Yii::t('validation', 'This value should be between %s and %s.'),
                'minlength' => Yii::t('validation', 'This value is too short. It should have %s characters or more.'),
                'maxlength' => Yii::t('validation', 'This value is too long. It should have %s characters or less.'),
                'length' => Yii::t('validation', 'This value length is invalid. It should be between %s and %s characters long.'),
                'mincheck' => Yii::t('validation', 'You must select at least %s choices.'),
                'maxcheck' => Yii::t('validation', 'You must select %s choices or less.'),
                'check' => Yii::t('validation', 'You must select between %s and %s choices.'),
                'equalto' => Yii::t('validation', 'This value should be the same.'),
            );
            $messages = "window.ParsleyConfig.i18n.{$this->i18n} = " . CJSON::encode($messages);
            Yii::app()->clientScript->registerScript(__CLASS__ . "#{$id}messages", $messages);
        } elseif (in_array($this->i18n, self::$supportedI18n)) {
            $this->publishAssets(Yii::getPathOfAlias($this->i18nAssetPathAlias));
            $fileName = $this->i18n . '.js';
            $this->registerScriptFile($fileName, CClientScript::POS_END);
        }
    }

    /**
     * Binds the plugin with the given options.
     * @see http://parsleyjs.org/doc/index.html#usage
     */
    protected function bindPlugin()
    {
        $id = $this->getId();
        $options = !empty($this->pluginOptions) ? CJavaScript::encode($this->pluginOptions) : '';
        Yii::app()->clientScript->registerScript(
            __CLASS__ . "#{$id}plugin",
            "jQuery('#{$id}').parsley({$options}); window.ParsleyValidator.setLocale('{$this->i18n}');"
        );
    }

    /**
     * Registers the validators by adding validation HTML attributes to the given options.
     * @param CModel $model the model class.
     * @param string $attribute the attribute name.
     * @param array $htmlOptions the HTML attributes.
     */
    protected function registerValidators($model, $attribute, &$htmlOptions)
    {
        foreach ($model->getValidators($attribute) as $validator) {
            if ($validator instanceof ParsleyValidator) {
                $validator->registerClientValidation($model, $attribute, $htmlOptions, $this->html5Mode);
            }
        }
    }
}