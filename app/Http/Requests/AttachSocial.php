<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;
use Social;

class AttachSocial extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->registerCustomValidators();

        return [
            'provider' => 'required|provider',
            'url' => 'required|social_url|max:255',
            'description' => 'max:1000',
        ];
    }

    /**
     * 
     */
    public function registerCustomValidators()
    {
        Validator::extend('social_url', function($name, $value){
            try {

                $provider = Social::get(request('provider'));
                return (bool) $provider->resolveUrl($value);

                
            } catch(\Exception $e) {

            }

            return false;
        });

        Validator::extend('provider', function($name, $value) {

            return (bool) config('socials.' . $value);

        });
    }
}
