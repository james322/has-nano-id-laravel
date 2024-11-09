<?php

namespace james322\HasNanoId;

use Hidehalo\Nanoid\Client;

trait HasNanoId
{
    public static function bootHasNanoId(): void
    {
        static::creating(function ($model) {
            $model[$model->getNanoKey()] = (new Client)->formatedId($model->getNanoAlphabet(), $model->getNanoSize());
        });
    }

    public function getNanoKey(): string
    {
        return isset($this->nano_id_key) ? $this->nano_id_key : 'public_id';
    }

    public function getNanoAlphabet(): string
    {
        return isset($this->nano_id_alphabet) ? $this->nano_id_alphabet : config('nano-id.alphabet');
    }

    public function getNanoSize(): int
    {
        return isset($this->nano_id_size) ? $this->nano_id_size : config('nano-id.size');
    }
}
