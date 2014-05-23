<?php
/**
 * ParsleyNumberValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validates that a value is a valid number.
 */
class ParsleyNumberValidator extends CNumberValidator implements ParsleyValidator
{
    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        if ($this->integerOnly) {
            $htmlOptions['data-parsley-type'] = 'integer';
            if (isset($this->message)) {
                $htmlOptions['data-parsley-type-message'] = $this->message;
            }
        } elseif (isset($this->min, $this->max)) {
            if ($html5Mode) {
                $htmlOptions['type'] = 'range';
                $htmlOptions['min'] = $this->min;
                $htmlOptions['max'] = $this->max;
            } else {
                $htmlOptions['data-parsley-range'] = CJavaScript::encode(array($this->min, $this->max));
            }
            if (isset($this->message)) {
                $htmlOptions['data-parsley-range-message'] = $this->message;
            }
        } elseif (isset($this->min)) {
            if ($html5Mode) {
                $htmlOptions['type'] = 'number';
                $htmlOptions['min'] = $this->min;
            } else {
                $htmlOptions['data-parsley-min'] = $this->min;
            }
            if (isset($this->message)) {
                $htmlOptions['data-parsley-min-message'] = $this->message;
            }
        } elseif (isset($this->max)) {
            if ($html5Mode) {
                $htmlOptions['type'] = 'number';
                $htmlOptions['max'] = $this->max;
            } else {
                $htmlOptions['data-parsley-max'] = $this->max;
            }
            if (isset($this->message)) {
                $htmlOptions['data-parsley-max-message'] = $this->message;
            }
        } else {
            if ($html5Mode) {
                $htmlOptions['type'] = 'number';
            } else {
                $htmlOptions['data-parsley-type'] = 'number';
            }
            if (isset($this->message)) {
                $htmlOptions['data-parsley-type-message'] = $this->message;
            }
        }
    }
} 