<?php

namespace Database\Seeders;

use App\Enums\Language;
use App\Models\Theme;
use App\Services\OxfordDictionaries\TranslateService;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Throwable;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        private readonly TranslateService $translateService
    ) {
    }

    private array $themes = [
        'Transport' => [
            'Car',
            'Bus',
            'Bicycle'
        ],
        'Family' => [
            'Father',
            'Mother',
            'Son'
        ]
    ];

    private array $translateTo = [
        Language::ES->value,
        Language::RU->value
    ];

    /**
     * Seed the application's database.
     * @throws Exception
     */
    public function run(): void
    {
        foreach ($this->themes as $theme => $words) {
            try {
                $theme = Theme::updateOrCreate([
                    'name' => $theme,
                ]);
                foreach ($words as $word) {
                    foreach ($this->translateTo as $language) {
                        $this->translateService->updateOrCreate($word, $theme->id, $language);
                    }
                }
            } catch (Throwable $exception) {
                Log::error($exception->getMessage());
                continue;
            }
        }
    }
}
