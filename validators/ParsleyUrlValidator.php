<?php
/**
 * ParsleyUrlValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validates that a value is a valid url.
 */
class ParsleyUrlValidator extends CUrlValidator implements ParsleyValidator
{
    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        $html5Mode ? $htmlOptions['type'] = 'url' : $htmlOptions['data-parsley-type'] = 'url';
        if ($this->message) {
            $htmlOptions['data-parsley-type-message'] = $this->message;
        }
    }
}