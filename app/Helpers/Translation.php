<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Translation
{
    /**
     * Transform a string to parameters used for translation
     *
     * The string is of the format 'name:key1=value1|key2=value2'
     *
     * Such that it can be used as: __('name', ['key1' => value1, key2 => value2])
     * to retrieve corresponding translation field
     *
     * @param string $string
     *
     * @return array
     */
    public static function parseStringToTranslationParameters(string $string)
    {
        $string_parts = explode(':', $string);

        $name = (string) array_shift($string_parts);

        $attributes = [];

        if (!empty($string_parts)) {
            foreach (explode('|', $string_parts[0]) as $key_value) {
                $key_value_array = explode('=', $key_value);
                $attributes[$key_value_array[0]] = $key_value_array[1] ?? '';
            }
        }

        return compact('name', 'attributes');
    }

    /**
     * Transforms the parameters into a string parsable for translation
     *
     * Usage
     *
     * Translation::transformToTranslatableString('name', ['key1' => 'value1', 'key2' => 'value2'])
     * Returns 'name:key1=value1|key2=value2'
     *
     * @see \App\Helpers\Translation::parseStringToTranslationParameters()
     */
    public static function transformToTranslatableString(string $name, array $attributes = []): string
    {
        if (empty($attributes) || ! Arr::isAssoc($attributes)) {
            return $name;
        }

        return $name . ':' . http_build_query(Arr::dot($attributes), '', '|');
    }

    /**
     * Attempts to translates a message string returns the corresponding key and translated string
     *
     * Usage
     *
     * Translation::translateMessageToArray('name', ['key1' => 'value1'])
     * Simply returns does __('name', ['key1' => 'value1'])
     *
     * @param string $message
     * @param array $attributes
     * @param string $path_prefix
     *
     * @return array
     */
    public static function translateMessageToArray(string $message, array $attributes = [], string $path_prefix = null): array
    {
        $path = ! empty($path_prefix) ? "{$path_prefix}.{$message}" : $message;

        $key = null;
        $translated_message = __($path, $attributes);

        if (! Str::startsWith($translated_message, $path)) {
            $message = $translated_message;
            $key_parts = explode('.', $path);
            $key = Str::slug(end($key_parts), '_');
        }

        return ['key' => $key, 'message' => $message];
    }
}
