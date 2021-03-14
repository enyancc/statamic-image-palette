<?php

namespace enyancc\ImagePalette;

use Illuminate\Support\Collection;
use enyancc\ImagePalette\Jobs\GenerateImageJob;
use Statamic\Assets\Asset;
use Statamic\Facades\Asset as AssetFacade;
use Statamic\Fields\Value;


class ImagePalette {
    /** @var \Statamic\Assets\Asset */
    public $asset;

    public function __construct(Asset $assetParam)
    {
        $this->asset = $this->retrieveAsset($assetParam);
    }

    private function retrieveAsset($assetParam): Asset
    {
        if ($assetParam instanceof Asset) {
            return $assetParam;
        }

        if (is_string($assetParam)) {
            $asset = AssetFacade::findByUrl($assetParam);

            if (! $asset) {
                $asset = AssetFacade::findByPath($assetParam);
            }
        }

        if ($assetParam instanceof Value) {
            $asset = $assetParam->value();

            if ($asset instanceof Collection) {
                $asset = $asset->first();
            }
        }

        if (! isset($asset)) {
            throw AssetNotFoundException::create($assetParam);
        }

        return $asset;
    }

    public function buildImageJob(): GenerateImageJob
    {
        return app(GenerateImageJob::class, ['asset' => $this->asset]);
    }

    public function dispatchImageJob(): void
    {
        dispatch($this->buildImageJob());
    }

}