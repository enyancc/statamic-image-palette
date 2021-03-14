<?php

use \enyancc\ImagePalette\Jobs\GenerateImagePaletteJob;


return [

    /*
    |--------------------------------------------------------------------------
    | Generate Image Job
    |--------------------------------------------------------------------------
    |
    | The job used to generate images, by default this uses
    | \enyancc\ImagePalette\Jobs\GenerateImagePaletteJob::class
    |
    */

    'image_job' => GenerateImagePaletteJob::class,

    /*
    |--------------------------------------------------------------------------
    | Queue
    |--------------------------------------------------------------------------
    |
    | If the generate images job is being queued, specify the name of the
    | target queue. This falls back to the 'default' queue
    |
    */

    'queue' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Max Width
    |--------------------------------------------------------------------------
    |
    | Define a global max-width for generated images.
    | You can override this on the tag.
    |
    */

    'limit' => 10,
];