<?php
/**
 * ParsleyValidator interface file.
 * @author Christoffer Lindqvist <christoffer.lindqvist@nordsoftware.com>
 * @copyright Copyright &copy; Nord Software 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nordsoftware.yii-parsley2.validators
 */

/**
 * Interface for all parsley validators.
 */
interface ParsleyValidator
{
    /**
     * Registers the parsley html attributes.
     * @param CModel $object the data object being validated.
     * @param string $attribute the name of the attribute to be validated.
     * @param array $htmlOptions the HTML attributes.
     * @param bool $html5Mode whether to use HTML5 attributes instead of data-attributes.
     */
    public function registerClientValidation($object, $attribute, &$htmlOptions, $html5Mode = false);
}