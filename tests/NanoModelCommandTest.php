<?php

use Illuminate\Filesystem\Filesystem;

use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->files = new Filesystem;
    $this->modelPath = app_path('Models/User.php');
    $this->migrationPath = database_path('migrations');

    $this->files->delete($this->modelPath);

    foreach ($this->files->glob($this->migrationPath.'/*_create_users_table.php') as $migration) {
        $this->files->delete($migration);
    }
});

afterEach(function () {
    $this->files->delete($this->modelPath);

    foreach ($this->files->glob($this->migrationPath.'/*_create_users_table.php') as $migration) {
        $this->files->delete($migration);
    }
});

test('nano model command creates a model with the nano id trait', function () {
    artisan('nano:model User')
        ->assertSuccessful();

    expect($this->modelPath)->toBeFile();
    expect($this->files->get($this->modelPath))
        ->toContain('namespace App\Models;')
        ->toContain('use james322\HasNanoId\HasNanoId;')
        ->toContain('use HasNanoId;')
        ->toContain("protected string \$nano_id_key = 'public_key';");
});

test('nano model command creates a migration with a public key column', function () {
    artisan('nano:model User')
        ->assertSuccessful();

    $migrations = $this->files->glob($this->migrationPath.'/*_create_users_table.php');

    expect($migrations)->toHaveCount(1);
    expect($this->files->get($migrations[0]))
        ->toContain("Schema::create('users'")
        ->toContain("\$table->string('public_key');")
        ->toContain("Schema::dropIfExists('users');");
});
