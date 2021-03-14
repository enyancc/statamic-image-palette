<?php

namespace enyancc\ImagePalette;

use Exception;

class AssetNotFoundException extends Exception
{
    public static function create($assetParam)
    {
        return new self("Could not find asset {$assetParam}");
    }
}