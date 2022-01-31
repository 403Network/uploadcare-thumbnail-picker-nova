<?php

namespace FourZeroThree\UploadcareThumbnailPickerNova;

use Laravel\Nova\Fields\Field;

class UploadcareThumbnailPicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'uploadcare-thumbnail-picker';

    public function dependsOn($field)
    {
        return $this->withMeta([
            'dependency' => $field,
        ]);
    }
}
