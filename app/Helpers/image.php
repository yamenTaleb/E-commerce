<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('storeImage')) {
    function storeImage($image, $directory): string|null
    {
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalName();
            $image->storeAs($directory, $imageName, 'public');
        } else
            return null;
        return $imageName;
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage($image, $directory): void
    {
        if ($image && Storage::disk('public')->exists($directory . $image))
            Storage::disk('public')->delete($directory . $image);
    }
}
