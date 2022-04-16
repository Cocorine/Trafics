<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name'   => 'required|max:255',
            'last_name'    => 'required|max:255',
            'gender'    => 'required',
            'phone_number' => 'required|unique:users|max:255',
            'email'        => 'sometimes|unique:users|max:255',
            //'roles'        => 'required|exists:roles|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'last_name.required' => 'Le nom de l\'utilisateur est requis',
            'first_name.required' => 'Le prénom de l\'utilisateur est requis',
            'gender.required' => 'Veuillez précisez le sexe de l\'utilisateur',
            'phone_number.required' => 'Le numéro de téléphone de l\'utilisateur est requis',
            'phone_number.unique' => 'Ce numéro de téléphone déjà enregistré sur le compte d\'un autre utilisateur. Veuillez changer.',
            'email.unique' => 'Cette adresse email est déjà enregistré sur le compte d\'un autre utilisateur. Veuillez changer.',
            'roles.exists' => 'Ce role n\'existe pas dans notre système. Veuillez vérifier',
        ];
    }
}
