<?php

namespace App\Support;

/** The password rule used on sign up and when an admin changes their password. */
class StrongPassword
{
    public const MESSAGE = 'Password must be at least 8 characters and include an uppercase letter, a number and a special symbol.';

    public static function rules(): array
    {
        return [
            'required',
            'string',
            function ($attribute, $value, $fail) {
                if (
                    mb_strlen($value) < 8
                    || !preg_match('/[A-Z]/', $value)
                    || !preg_match('/[0-9]/', $value)
                    || !preg_match('/[^A-Za-z0-9]/', $value)
                ) {
                    $fail(self::MESSAGE);
                }
            },
        ];
    }
}
