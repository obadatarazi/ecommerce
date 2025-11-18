<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Lang;

trait EnumTrait
{
    public static function getOptions($translator): array
    {
        return array_map(function($item) use ($translator) {
            return [
                "label" => self::getByName($item->name)->trans($translator),
                "value" => $item->value
            ];
        }, self::cases());
    }

    public static function getByName($name): self
    {
        return self::from($name);
    }

    public function trans($translator): string
    {
        return Lang::get("enum." . $this->value, [], $translator);
    }
}
