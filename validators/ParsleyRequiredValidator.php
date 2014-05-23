<?php
/**
 * ParsleyRequiredValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validator for required values.
 */
class ParsleyRequiredValidator extends CRequiredValidator implements ParsleyValidator
{
    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        $html5Mode ? $htmlOptions['type'] = 'required' : $htmlOptions['data-parsley-required'] = 'true';
        if (isset($this->message)) {
            $htmlOptions['data-parsley-required-message'] = $this->message;
        }
    }
}