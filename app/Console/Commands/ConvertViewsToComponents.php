<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertViewsToComponents extends Command
{
    protected $signature = 'convert:views';
    protected $description = 'Convert @extends views into Blade component layout with Tailwind styling';

    public function handle()
    {
        $viewDirs = [
            resource_path('views/admin'),
            resource_path('views/partner'),
            resource_path('views/client'),
        ];

        foreach ($viewDirs as $dir) {
            if (!File::exists($dir)) {
                $this->warn("Directory not found: $dir");
                continue;
            }

            $files = File::allFiles($dir);

            foreach ($files as $file) {
                $content = File::get($file->getRealPath());

                if (!str_contains($content, '@extends(\'layouts.app\')')) {
                    continue;
                }

                // Ambil isi dalam @section('content') ... @endsection
                if (preg_match('/@section\([\'"]content[\'"]\)(.*?)@endsection/s', $content, $matches)) {
                    $innerContent = trim($matches[1]);

                    $newContent = <<<BLADE
<x-app-layout>
    <div class="bg-white p-6 rounded-lg shadow">
        {$innerContent}
    </div>
</x-app-layout>
BLADE;

                    File::put($file->getRealPath(), $newContent);
                    $this->info("Converted: " . $file->getRelativePathname());
                } else {
                    $this->warn("No @section('content') found in: " . $file->getRelativePathname());
                }
            }
        }

        $this->info("✅ View conversion completed.");
    }
}
