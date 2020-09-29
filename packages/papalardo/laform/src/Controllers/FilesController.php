<?php

namespace Papalardo\Laform\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Papalardo\Laform\Helper;
use Illuminate\Support\Facades\Storage;

class FilesController
{
    public function __invoke(Request $request)
    {
        $storage_disk = 'minio';
        $storage_path = Helper::normalizePath(implode('/', [request()->input('dir', '/'), (string) Str::uuid()]));
        $files = [];

        foreach (request()->file('files') as $file) {
            $path = $file->storeAs($storage_path, $file->getClientOriginalName(), $storage_disk);
            $files[] = [
                'path' => $path,
                'disk' => $storage_disk,
                'dir' => $storage_path,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'url' => Storage::disk($storage_disk)->url($path)
            ];
        }

        return response([
            'files' => $files
        ]);
    }
}
