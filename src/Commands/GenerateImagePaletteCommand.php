<?php

namespace enyancc\ImagePalette\Commands;

use enyancc\ImagePalette\ImagePalette;
use Illuminate\Console\Command;
use Statamic\Contracts\Assets\Asset;
use Statamic\Contracts\Assets\AssetRepository;
use Statamic\Console\RunsInPlease;

class GenerateImagePaletteCommand extends Command
{
    use RunsInPlease;

    protected $signature = 'statamic:imagepalette:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate palette metadata for images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(AssetRepository $assets)
    {
        $assets = $assets->all()->filter(function (Asset $asset) {
            return $asset->isImage() && $asset->extension() !== 'svg';
        });

        $this->info("Generating responsive image versions for {$assets->count()} assets.");

        $this->getOutput()->progressStart($assets->count());

        /** @var \Statamic\Assets\AssetCollection $assets */
        $assets->each(function (Asset $asset) {

            $imagePalette = new ImagePalette($asset);
            $imagePalette->dispatchImageJob();

            $this->getOutput()->progressAdvance();
        });

        $this->getOutput()->progressFinish();
        $this->info("All jobs dispatched.");
    }
}
