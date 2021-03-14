<?php

namespace enyancc\ImagePalette\Jobs;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\MountManager;

use ColorThief\ColorThief;
use Statamic\Assets\Asset;

class GenerateImagePaletteJob extends GenerateImageJob
{
    protected function writePalette()
    {
        $asset = $this->asset;

        $palette = $this->getImagePalette($asset);

        $asset->set('palette', $palette);
        $asset->writeMeta($asset->generateMeta());
        $asset->save();
    }

    /**
     * Get the dimensions.
     *
     * @return array
     */
    private function getImagePalette(Asset $asset)
    {
        // Since assets may be located on external platforms like Amazon S3, we can't simply
        // grab the dimensions. So we'll copy it locally and read the dimensions from there.
        $manager = new MountManager([
            'source' => $asset->disk()->filesystem()->getDriver(),
            'cache' => $cache = $this->getCacheFlysystem(),
        ]);

        $cachePath = "{$asset->containerId()}/{$asset->path()}";

        if ($manager->has($destination = "cache://{$cachePath}")) {
            $manager->delete($destination);
        }

        $manager->copy("source://{$asset->path()}", $destination);
        $sourceImage = $cache->getAdapter()->getPathPrefix() . $cachePath;

        $palette  = ColorThief::getPalette($sourceImage, config('statamic.image-palette.limit', 8));



        foreach ($palette as $key => $rgb) {
            $palette[$key] = sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
        }

        $cache->delete($cachePath);

        return $palette ? $palette : null;
    }

    private function getCacheFlysystem()
    {
        $disk = 'dimensions-cache';

        config(["filesystems.disks.{$disk}" => [
            'driver' => 'local',
            'root' => storage_path('statamic/dimensions-cache'),
        ]]);

        return Storage::disk($disk)->getDriver();
    }
}
