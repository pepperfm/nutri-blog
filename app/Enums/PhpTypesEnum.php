<?php

declare(strict_types=1);

namespace App\Enums;

enum PhpTypesEnum: string
{
    case int = 'int';

    case string = 'string';

    case encodedString = 'encoded_string';

    case float = 'float';

    case bool = 'bool';

    case array = 'array';

    case object = 'object';

    public static function mappedTypes(): array
    {
        return [
            self::int->value => self::int->name,
            self::string->value => self::string->name,
            self::float->value => self::float->name,
            self::bool->value => self::bool->name,
            self::array->value => self::array->name,
            self::object->value => self::object->name,
        ];
    }
}
