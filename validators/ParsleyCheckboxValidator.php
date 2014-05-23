<?php
/**
 * ParsleyCheckboxValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validator for checkboxes.
 */
class ParsleyCheckboxValidator extends CValidator implements ParsleyValidator
{
    /**
     * @var int the minimum amount of checkboxes that must be selected.
     */
    public $min;

    /**
     * @var int the maximum amount of checkboxes that must be selected.
     */
    public $max;

    /**
     * @inheritdoc
     */
    protected function validateAttribute($object, $attribute)
    {
        throw new CException('ParsleyCheckboxValidator server side validation not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        if (isset($this->min, $this->max)) {
            $htmlOptions['data-parsley-check'] = CJavaScript::encode(array($this->min, $this->max));
            if (isset($this->message)) {
                $htmlOptions['data-parsley-check-message'] = $this->message;
            }
        } elseif (isset($this->min)) {
            $htmlOptions['data-parsley-mincheck'] = $this->min;
            if (isset($this->message)) {
                $htmlOptions['data-parsley-mincheck-message'] = $this->message;
            }
        } elseif (isset($this->max)) {
            $htmlOptions['data-parsley-maxcheck'] = $this->max;
            if (isset($this->message)) {
                $htmlOptions['data-parsley-maxcheck-message'] = $this->message;
            }
        }
    }
}