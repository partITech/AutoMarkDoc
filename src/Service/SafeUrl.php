<?php

namespace App\Service;

class SafeUrl
{
    public static function parse($url): string
    {
        // Remove leading "./"
        if (str_starts_with($url, './')) {
            $url = substr($url, 2);
        }

        // Optionally sanitize or forbid directory traversal like ".."
        // This is a simple example that just strips out ".."
        $safeUrl = str_replace('..', '', $url);
        // Trim and remove obvious attempts at directory traversal
        $safeUrl = trim($safeUrl);
        // Optionally remove any backslashes in case of Windows paths
        $safeUrl = str_replace('\\', '/', $safeUrl);


        // Encode the URL so special chars become safe in query strings
        $encodedUrl = rawurlencode($safeUrl);

        return $encodedUrl;
    }

}