<?php

declare(strict_types=1);

namespace App\Dto;

use App\Traits\Makeable;

abstract class BaseDto
{
    use Makeable;

    public static array $casts;

    /**
     * @param array|\stdClass $params
     *
     * @throws \JsonException
     */
    public function __construct(array|\stdClass $params = [])
    {
        static::$casts = $this->casts();

        foreach ((array) $params as $key => $param) {
            $camelKey = str($key)->camel()->value();
            if (property_exists($this, $camelKey)) {
                $this->castToType($camelKey, $param);
            }
        }
    }

    public function __get(string $name)
    {
        $camelKey = str($name)->camel()->value();

        return $this->$camelKey;
    }

    // public function __set(string $name, $value): void
    // {
    //     $this->$name = $value;
    // }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        $array = [];
        foreach ((array) $this as $key => $item) {
            $snakeKey = str($key)->snake()->replaceMatches('/([^\d])(\d++)/', '\1_\2')->value();
            $array[$snakeKey] = $item;
        }

        return $array;
    }

    /**
     * @param $param
     * @param string $key
     *
     * @throws \JsonException
     *
     * @return void
     */
    public function setType(&$param, string $key): void
    {
        $snakeKey = str($key)->snake()->replaceMatches('/([^\d])(\d++)/', '\1_\2')->value();
        if (!isset(static::$casts[$snakeKey])) {
            return;
        }
        $param = match (static::$casts[$snakeKey]) {
            \App\Enums\PhpTypesEnum::bool->value => filter_var($param, FILTER_VALIDATE_BOOLEAN),
            \App\Enums\PhpTypesEnum::int->value => (int) $param,
            \App\Enums\PhpTypesEnum::float->value => (float) $param,
            \App\Enums\PhpTypesEnum::array->value => json_decode($param, true, 512, JSON_THROW_ON_ERROR),
            \App\Enums\PhpTypesEnum::object->value => json_decode($param, false, 512, JSON_THROW_ON_ERROR),
            \App\Enums\PhpTypesEnum::string->value => (string) $param,
            \App\Enums\PhpTypesEnum::encodedString->value => json_encode($param, JSON_THROW_ON_ERROR),
            default => $param,
        };
    }

    /**
     * @throws \JsonException
     */
    protected function castToType(string $key, mixed $value): void
    {
        if (is_string($value)) {
            $this->setType($value, $key);
        }
        $this->$key = $value;
    }

    protected function castToString(string $key): string
    {
        $camelKey = str($key)->camel()->value();
        $param = $this->$camelKey;
        if (!is_string($param)) {
            $param = json_encode($param, JSON_THROW_ON_ERROR);
        }

        return $param;
    }

    protected function casts(): array
    {
        return [];
    }
}
