<?php

namespace enyancc\ImagePalette\Listeners;

use enyancc\ImagePalette\ImagePalette;
use Statamic\Events\AssetUploaded;

class GenerateImagePaletteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AssetUploaded $event)
    {

        if (! $event->asset->isImage()) {
            return;
        }

        if ($event->asset->extension() === 'svg') {
            return;
        }

        $imagePalette = new ImagePalette($event->asset);
        $imagePalette->dispatchImageJob();

    }

}
