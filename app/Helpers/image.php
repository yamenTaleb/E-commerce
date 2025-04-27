<?php

if (!function_exists('storeImage')) {
    function storeImage($image, $directory): string|null
    {
        if ($image) {
            $imageName = $image->getClientOriginalName();
            $image->storeAs($directory, $imageName, 'public');
        } else
            return null;
        return $imageName;
    }
}
//$imageName = storeImage($request->file('image'), 'users');
