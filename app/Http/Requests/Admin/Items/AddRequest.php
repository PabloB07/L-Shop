<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Items;

use App\Services\Item\Type;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:64',
            'description' => 'nullable',
            'item_type' => 'required',
            'image_type' => 'in:default,upload,browse',
            'file' => 'required_if:image_type,upload|file|image|mimes:jpeg,bmp,png,gif',
            'image_name' => 'required_if:image_type,browse|string|min:3',
            'signature' => 'required_unless:item_type,currency',
            'extra' => 'nullable'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'name' => __('content.admin.items.add.name'),
            'description' => __('content.admin.items.add.description'),
            'item_type' => __('common.type'),
            'extra' => $this->get('item_type') === Type::COMMAND ? __('content.admin.items.add.pattern') : __('content.admin.items.add.extra')
        ];
    }
}
