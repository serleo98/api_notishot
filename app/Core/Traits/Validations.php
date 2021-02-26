<?php

namespace App\Core\Traits;

use Illuminate\Contracts\Validation\Factory;

trait Validations
{
    /**
     * Validate the given request with the given rules.
     *
     * @param  array $data
     * @param  array $rules
     * @param  array $messages
     * @param  array $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        return $this->getValidationFactory()->make($data, $rules, $messages, $customAttributes);
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  array $data
     * @param  array $rules
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function isValid(array $data, array $rules)
    {
        return $this->validator($data, $rules)->passes();
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }
}
