<?php
/**
 * ParsleyCompareValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validator for comparing input values.
 */
class ParsleyCompareValidator extends CCompareValidator implements ParsleyValidator
{
    /**
     * @var string the CSS selector for the element to compare values with.
     */
    public $compareSelector;

    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        $htmlOptions['data-parsley-equalto'] = $this->compareSelector;
        if (isset($this->message)) {
            $htmlOptions['data-parsley-equalto-message'] = $this->message;
        }
    }
} 