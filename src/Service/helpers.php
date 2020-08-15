<?php

// Simple helper to include files more easily
function requireCoreFile($file)
{
    require __DIR__ . '/' . $file . '.php';
}

// Helper function to reference assets local to this project
function asset($asset)
{
    return ASSET_PREFIX . '/'. $asset;
}
