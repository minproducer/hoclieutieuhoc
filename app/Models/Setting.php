<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected static array $cache = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        if (isset(static::$cache[$key])) {
            return static::$cache[$key];
        }

        try {
            $setting = static::where('key', $key)->first();
            $value = $setting ? $setting->value : $default;
            static::$cache[$key] = $value;
            return $value;
        } catch (\Exception $e) {
            return $default;
        }
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        static::$cache[$key] = $value;
    }

    public static function clearCache(): void
    {
        static::$cache = [];
    }
}
