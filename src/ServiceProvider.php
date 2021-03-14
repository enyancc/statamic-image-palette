<?php

namespace enyancc\ImagePalette;

use enyancc\ImagePalette\Commands\GenerateImagePaletteCommand;
use enyancc\ImagePalette\Jobs\GenerateImageJob;
use enyancc\ImagePalette\Listeners\BlueprintFieldsListener;
use enyancc\ImagePalette\Listeners\GenerateImagePaletteListener;
use Statamic\Events\AssetContainerBlueprintFound;
use Statamic\Events\AssetUploaded;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{

    protected $listen = [
        AssetUploaded::class => [
            GenerateImagePaletteListener::class,
        ],
        AssetContainerBlueprintFound::class => [
            BlueprintFieldsListener::class
        ]
    ];

    protected $commands = [
        GenerateImagePaletteCommand::class,
        // RegenerateResponsiveVersionsCommand::class,
    ];


    public function boot()
    {
        parent::boot();

        $this
            ->bootAddonConfig()
            ->bindImageJob();
    }

    protected function bootAddonConfig(): self
    {
        $this->mergeConfigFrom(__DIR__.'/../config/image-palette.php', 'statamic.image-palette');

        $this->publishes([
            __DIR__.'/../config/image-palette.php' => config_path('statamic/image-palette.php'),
        ], 'image-palette-config');

        return $this;
    }

    private function bindImageJob(): self
    {
        $this->app->bind(GenerateImageJob::class, config('statamic.image-palette.image_job'));

        return $this;
    }
}
