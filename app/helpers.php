<?php

if (! function_exists('admin_media_url')) {
    /**
     * Resolve player/staff/news images (Cloudinary URL or local path).
     */
    function admin_media_url(?string $url, string $fallbackLabel = 'GS'): string
    {
        if ($url && (str_starts_with($url, 'http://') || str_starts_with($url, 'https://'))) {
            return $url;
        }

        if ($url) {
            return asset(ltrim($url, '/'));
        }

        $name = urlencode($fallbackLabel);

        return "https://ui-avatars.com/api/?name={$name}&background=C8102E&color=fff&size=128&bold=true";
    }
}
