<?php
/**
 * ParsleyRemoteValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validator with support for remote validation calls (Ajax).
 *
 * You can show frontend server-side specific error messages by returning:
 * { "error": "your custom message" } or { "message": "your custom message" }
 */
class ParsleyRemoteValidator extends CValidator implements ParsleyValidator
{
    /**
     * @var string the validation url.
     */
    public $url;

    /**
     * @var string request method, i.e. get or post.
     */
    public $method = 'get';

    /**
     * @var bool if you make cross domain Ajax calls and expect jsonp,
     * Parsley will accept these valid returns with a 200 response code:
     * 1, true,  { "success": "..." } and assumes false otherwise.
     */
    public $jsonp = false;

    /**
     * @inheritdoc
     */
    protected function validateAttribute($object, $attribute)
    {
        // client-side validation only.
    }

    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        // todo: add support for "data-parsley-remote-validator" and/or "data-parsley-remote-reverse"

        $htmlOptions['data-parsley-remote'] = CHtml::normalizeUrl($this->url);
        $htmlOptions['data-parsley-remote-options'] = CJavaScript::encode(
            array(
                'type' => strtoupper($this->method),
                'dataType' => $this->jsonp ? 'jsonp' : 'json',
            )
        );
        if (isset($this->message)) {
            $htmlOptions['data-parsley-remote-message'] = $this->message;
        }
    }
}