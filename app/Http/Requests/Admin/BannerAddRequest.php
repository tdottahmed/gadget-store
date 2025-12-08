<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $id
 * @property string $url
 * @property string $image
 * @property int $status
 */
class BannerAddRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'url' => 'required',
        ];
        
        // For Hero Slider, require multiple images array
        if ($this->input('banner_type') === 'Hero Slider') {
            $rules['images'] = 'required|array|min:1';
            $rules['images.*'] = 'required|image|mimes:jpg,jpeg,png,gif,bmp,webp|max:10240';
        } else {
            $rules['image'] = 'required|image|mimes:jpg,jpeg,png,gif,bmp,webp|max:10240';
        }
        
        return $rules;
    }

    public function messages(): array
    {
        return [
            'url.required' => translate('the_url_field_is_required'),
            'image.required' => translate('the_image_is_required'),
            'image.image' => translate('the_file_must_be_an_image'),
            'image.mimes' => translate('the_image_must_be_jpg_jpeg_png_gif_bmp_or_webp'),
            'image.max' => translate('the_image_must_not_exceed_10mb'),
            'images.required' => translate('at_least_one_image_is_required'),
            'images.array' => translate('images_must_be_an_array'),
            'images.min' => translate('at_least_one_image_is_required'),
            'images.*.required' => translate('each_image_is_required'),
            'images.*.image' => translate('each_file_must_be_an_image'),
            'images.*.mimes' => translate('each_image_must_be_jpg_jpeg_png_gif_bmp_or_webp'),
            'images.*.max' => translate('each_image_must_not_exceed_10mb'),
        ];
    }
    
    public function attributes(): array
    {
        return [
            'images.*' => translate('image'),
        ];
    }

}
