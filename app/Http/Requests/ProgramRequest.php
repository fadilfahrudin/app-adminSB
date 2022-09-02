<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
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
            'title' => 'required|max:255',
            'program_by' => 'required|max:255',
            'types' => '',
            'description' => 'required',
            'target_amount' => 'required|integer',
            'end_program' => 'required|date',
            'banner_program' => 'required|image'
        ];
    }
}
