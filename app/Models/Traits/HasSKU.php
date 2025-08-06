<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasSKU
{
    public static function bootHasSku()
    {
        static::saving(function ($model) {
            if (empty($model->sku)) {
                $model->sku = $model->generateSku();
            }
        });
    }

    /**
     * Generate an SKU based on the item's name.
     *
     * @return string
     */
    public function generateSku(): string
    {
        $prefix = strtoupper(Str::slug(Str::words($this->name, 3, ''), '-'));
        $unique = uniqid();
        return $prefix . '-' . $unique;
    }
}
