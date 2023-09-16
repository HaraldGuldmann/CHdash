<?php

namespace App\Http\Requests;

use App\Enums\ReferenceContentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => ['required'],
            'description'   => ['required'],
            'file'          => ['required', 'mimetypes:video/*,application/octet-stream', 'max:20000000'],
            'content_type'  => ['required', new EnumRule(ReferenceContentTypeEnum::class)],
            'isrc'          => ['required_if:content_type,'.ReferenceContentTypeEnum::audio()],
            'artist'        => ['required_if:content_type,'.ReferenceContentTypeEnum::audio()],
            'album'         => ['required_if:content_type,'.ReferenceContentTypeEnum::audio()]
        ];
    }
}
