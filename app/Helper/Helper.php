<?php

namespace App\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Helper
{

    public static function upload(Request $request, string $dir, string $fileName): null|string
    {
        if ($request->has($fileName)) {
            $newName = time() . '-' . Str::random(10) . '.' . $request->file($fileName)->getClientOriginalExtension();
            if ($request->file($fileName)->move($dir, $newName)) {
                return $newName;
            }
        }
        return null;

    }

    public static function getUrl($url): string
    {
        $convertUrlToValidUrlForSearch = str_replace('-', '', $url);
        $convertUrlToValidUrlForSearch = str_replace('/', ' ', $convertUrlToValidUrlForSearch);
        return preg_replace('/\s+/', '-', $convertUrlToValidUrlForSearch);

    }

    public static function removeFile(string $fullAddressName)
    {
        if (file_exists($fullAddressName)) {
            unlink($fullAddressName);
        }

    }
}
