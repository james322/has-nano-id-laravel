<?php

use Illuminate\Database\Eloquent\Model as BaseModel;
use james322\HasNanoId\HasNanoId;

class Model extends BaseModel
{
    use HasNanoId;

    public $guarded = [];

    public $table = 'has_nano_id_laravel_table';
}

test('A model with HasNanoId will save with a nano id', function () {
    $model = Model::create([

    ]);

    expect($model->public_id)->toBeString()->not()->toBeEmpty();
    expect(strlen($model->public_id))->toBe(config('nano-id.size'));
});

test('nano id cannot be empty string', function () {
    $model = Model::create([
        'public_id' => '   ',
    ]);

    expect($model->public_id)->toBeString()->not()->toBeEmpty();
    expect(strlen($model->public_id))->toBe(config('nano-id.size'));
});

test('alphabet can be customized by model', function () {
    $model = new Model;
    $alphabet = 'not-real';
    $model->nano_id_alphabet = $alphabet;

    expect($model->getNanoAlphabet())
        ->toBe($alphabet)
        ->not()->toBe(config('nano-id.alphabet'));
});

test('size can be customized by model', function () {
    $model = new Model;
    $size = 10000;
    $model->nano_id_size = $size;

    expect($model->getNanoSize())
        ->toBe($size)
        ->not()->toBe(config('nano-id.size'));
});

test('nano id key can be customized by model', function () {
    $model = new Model;
    $oldNanoKey = $model->getNanoKey();
    $nanoKey = 'key_for_nano_pest';
    $model->nano_id_key = $nanoKey;

    expect($model->getNanoKey())
        ->toBe($nanoKey)
        ->not()->toBe($oldNanoKey);
});

test('manually set nano id wont be overridden', function () {
    $publicId = 'test-nano';
    $model = Model::create([
        'public_id' => $publicId,
    ]);

    expect($model->public_id)->toBe($publicId);
});
