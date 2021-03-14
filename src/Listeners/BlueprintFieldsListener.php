<?php

namespace enyancc\ImagePalette\Listeners;

use Statamic\Events\AssetContainerBlueprintFound;

class BlueprintFieldsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function handle(AssetContainerBlueprintFound $event)
    {
        $event->blueprint->ensureFieldInSection('palette', [
            'type' => 'list',
            'listable' => 'hidden',
            'icon' => 'list',
            'display' => 'Palette'
        ], 'palette');
    }

}
