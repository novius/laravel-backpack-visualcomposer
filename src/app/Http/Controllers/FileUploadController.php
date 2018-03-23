<?php

namespace Novius\Backpack\VisualComposer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    function __construct(Request $request)
    {
        if (!$request->ajax()) {
            return abort(405);
        }
    }

    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            response()->json([
                'url' => null,
                'error' => true,
            ]);
        }

        $file = $request->file('file');
        $filename = $file->storePublicly('public');
        $url = Storage::url($filename);

        return response()->json([
            'url' => $url,
            'error' => false,
        ]);
    }
}
