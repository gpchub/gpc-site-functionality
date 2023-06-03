<?php

namespace GpcSiteFunctionality\Lib\Gpc_Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Checkbox;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Colorpicker;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Datepicker;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Media;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Number;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Radio;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Select;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Select_Post;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Select_Term;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Text;
use GpcSiteFunctionality\Lib\Gpc_Fields\Fields\Textarea;

class Field_Factory
{
    /**
     * Make new field
     *
     * @param string $type
     * @param string $id
     * @param string $label
     * @return Field
     */
    public static function make( $type, $id, $label ) : Field
    {
        $field = null;
        switch ( $type ) {
            case 'text':
                $field = new Text($type, $id, $label);
                break;
            case 'checkbox':
                $field = new Checkbox($type, $id, $label);
                break;
            case 'radio':
                $field = new Radio($type, $id, $label);
                break;
            case 'select':
                $field = new Select($type, $id, $label);
                break;
            case 'select-post':
                $field = new Select_Post($type, $id, $label);
                break;
            case 'select-term':
                $field = new Select_Term($type, $id, $label);
                break;
            case 'textarea':
                $field = new Textarea($type, $id, $label);
                break;
            case 'number':
                $field = new Number($type, $id, $label);
                break;
            case 'colorpicker':
                $field = new Colorpicker($type, $id, $label);
                break;
            case 'datepicker':
                $field = new Datepicker($type, $id, $label);
                break;
            case 'media':
                $field = new Media($type, $id, $label);
                break;
            case 'gallery':
                $field = new Media($type, $id, $label);
                $field->set_multiple(true);
                break;
        }

        return $field;
    }
}