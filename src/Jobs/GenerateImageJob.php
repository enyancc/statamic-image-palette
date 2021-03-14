<?php

namespace enyancc\ImagePalette\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Statamic\Contracts\Assets\Asset;

abstract class GenerateImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Statamic\Assets\Asset */
    protected $asset;

    /** @var array */
    protected $params;

    public function __construct(Asset $asset, array $params = [])
    {
        $this->asset = $asset;
        $this->params = $params;

        $this->queue = config('statamic.responsive-images.queue', 'default');
    }

    public function handle()
    {
        return $this->writePalette();
    }

    abstract protected function writePalette();
}