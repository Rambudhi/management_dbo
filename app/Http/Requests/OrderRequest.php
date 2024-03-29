<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'id_customer' => 'required',
            'order_name' => 'required',
            'status' => [
                'required', 
                 Rule::in(['N', 'S'])

                 //Note 
                //  N = new
                //  S = Second
            ],
        ];
    }
}
