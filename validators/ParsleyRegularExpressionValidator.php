<?php
/**
 * ParsleyRegularExpressionValidator class file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Validator for regular expressions.
 */
class ParsleyRegularExpressionValidator extends CRegularExpressionValidator implements ParsleyValidator
{
    /**
     * @inheritdoc
     */
    public function validate($object,$attributes=null)
    {
        $this->normalizePattern();
        parent::validate($object, $attributes);
    }

    /**
     * @inheritdoc
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false)
    {
        $html5Mode ? $htmlOptions['pattern'] = $this->pattern : $htmlOptions['data-parsley-pattern'] = $this->pattern;
        if (isset($this->message)) {
            $htmlOptions['data-parsley-pattern-message'] = $this->message;
        }
    }

    /**
     * Normalizes regexp pattern, i.e. adds the beginning and ending delimiter.
     */
    protected function normalizePattern()
    {
        $this->pattern = '/' . $this->pattern . '/';
    }
}