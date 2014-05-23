<?php
/**
 * ParsleyEmailValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validator for email addresses.
 */
class ParsleyEmailValidator extends CEmailValidator implements ParsleyValidator
{
    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        $html5Mode ? $htmlOptions['type'] = 'email' : $htmlOptions['data-parsley-type'] = 'email';
        if (isset($this->message)) {
            $htmlOptions['data-parsley-type-message'] = $this->message;
        }
    }
}