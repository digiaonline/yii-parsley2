<?php
/**
 * ParsleyAlphaNumericValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

class ParsleyAlphaNumericValidator extends CValidator implements ParsleyValidator
{
    /**
     * @inheritdoc
     */
    protected function validateAttribute($object, $attribute)
    {
        throw new CException('ParsleyAlphaNumericValidator server side validation not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        $htmlOptions['data-parsley-type'] = 'alphanum';
        if (isset($this->message)) {
            $htmlOptions['data-parsley-type-message'] = $this->message;
        }
    }
} 