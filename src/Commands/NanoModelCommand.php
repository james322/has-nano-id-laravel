<?php

namespace james322\HasNanoId\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class NanoModelCommand extends Command
{
    protected $signature = 'nano:model {name : The model name}';

    protected $description = 'Create a new Eloquent model and migration with a public_key nano id column';

    public function handle(Filesystem $files): int
    {
        $modelClass = $this->qualifyModel($this->argument('name'));
        $modelPath = $this->modelPath($modelClass);

        if ($files->exists($modelPath)) {
            $this->components->error("Model [{$modelClass}] already exists.");

            return self::FAILURE;
        }

        $files->ensureDirectoryExists(dirname($modelPath));
        $files->put($modelPath, $this->modelContents($modelClass));

        $migrationPath = $this->migrationPath($this->tableName($modelClass));

        $files->ensureDirectoryExists(dirname($migrationPath));
        $files->put($migrationPath, $this->migrationContents($this->tableName($modelClass)));

        $this->components->info(sprintf('Model [%s] created successfully.', $modelClass));
        $this->components->info(sprintf('Migration [%s] created successfully.', basename($migrationPath)));

        return self::SUCCESS;
    }

    protected function qualifyModel(string $name): string
    {
        $name = str_replace('/', '\\', trim($name, '\\/'));

        if (Str::startsWith($name, 'App\\')) {
            return $name;
        }

        return 'App\\Models\\'.$name;
    }

    protected function modelPath(string $modelClass): string
    {
        $relativePath = Str::after($modelClass, 'App\\');

        return app_path(str_replace('\\', DIRECTORY_SEPARATOR, $relativePath).'.php');
    }

    protected function tableName(string $modelClass): string
    {
        return Str::snake(Str::pluralStudly(class_basename($modelClass)));
    }

    protected function migrationPath(string $table): string
    {
        return database_path('migrations/'.date('Y_m_d_His')."_create_{$table}_table.php");
    }

    protected function modelContents(string $modelClass): string
    {
        $namespace = Str::beforeLast($modelClass, '\\');
        $class = class_basename($modelClass);

        return <<<PHP
            <?php

            namespace {$namespace};

            use Illuminate\Database\Eloquent\Model;
            use james322\HasNanoId\HasNanoId;

            class {$class} extends Model
            {
                use HasNanoId;

                protected string \$nano_id_key = 'public_key';
            }

            PHP;
    }

    protected function migrationContents(string $table): string
    {
        return <<<PHP
            <?php

            use Illuminate\Database\Migrations\Migration;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Support\Facades\Schema;

            return new class extends Migration
            {
                public function up(): void
                {
                    Schema::create('{$table}', function (Blueprint \$table) {
                        \$table->id();
                        \$table->string('public_key');
                        \$table->timestamps();
                    });
                }

                public function down(): void
                {
                    Schema::dropIfExists('{$table}');
                }
            };

            PHP;
    }
}
