<?php
/**
 * ParsleyStringValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validator for strings.
 */
class ParsleyStringValidator extends CStringValidator implements ParsleyValidator
{
    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        if (isset($this->min, $this->max)) {
            $htmlOptions['data-parsley-length'] = CJavaScript::encode(array($this->min, $this->max));
            if (isset($this->message)) {
                $htmlOptions['data-parsley-length-message'] = $this->message;
            }
        } elseif (isset($this->min)) {
            $htmlOptions['data-parsley-minlength'] = $this->min;
            if (isset($this->message)) {
                $htmlOptions['data-parsley-minlength-message'] = $this->message;
            }
        } elseif (isset($this->max)) {
            $htmlOptions['data-parsley-maxlength'] = $this->max;
            if (isset($this->message)) {
                $htmlOptions['data-parsley-maxlength-message'] = $this->message;
            }
        }
    }
}