<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\Translation;

class CreateRole extends Command
{
    protected $signature = 'command:create-role {key} {translations*}';
    protected $description = 'Create a role with translations';

    public function handle()
    {
        $key = $this->argument('key');
        $translations = $this->argument('translations');

        $name = null;
        $translationsData = [];
        foreach ($translations as $translation) {
            [$lang, $value] = explode(':', $translation);
            $translationsData[$lang] = $value;

            if ($lang === 'en') {
                $name = $value;
            }
        }

        if (!$name) {
            $this->error('English translation (en) is required!');
            return 1;
        }

        $role = Role::create([
            'name' => $name,
            'key' => $key,
        ]);

        foreach ($translationsData as $lang => $value) {
            Translation::create([
                'table_name' => $role->getTable(),
                'field_name' => 'name',
                'field_id' => $role->id,
                'language_url' => $lang,
                'field_value' => $value,
            ]);
        }

        $this->info("Role '{$key}' successfully created with translations.");
        return 0;
    }
}
