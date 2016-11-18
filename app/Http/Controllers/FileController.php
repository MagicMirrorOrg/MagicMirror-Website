<?php

namespace MagicMirror\Http\Controllers;

use Illuminate\Http\Request;

use MagicMirror\Http\Requests;

class FileController extends Controller
{
	/**
     * Instantiate a new FileController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('upload');
    }

	/**
     * Upload an image.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {

        $this->validate($request, [
            'file' => 'image|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->store('uploads');
            $fileName = str_replace("uploads/", "", $fileName);

            return ['success' => true, 'file' => $fileName, 'path' => action('FileController@fetch', ['$file' => $fileName])];
        }

        abort(415);
    }

	/**
     * Fetch an uploaded file.
     *
     * @param  String $file 	Filename.
     * @return \Illuminate\Http\Response
     */
    public function fetch($file)
    {
        $storagePath  = \Storage::getDriver()->getAdapter()->getPathPrefix();
        $filePath = $storagePath . '/uploads/' . $file;
        if (\File::exists($filePath)) {
            return response()->download($filePath, $file, [], 'inline');
        }

        abort(404);

    }

	/**
     * Fetch an uploaded image and allow resizing.
     *
	 * @param  String $file 	Filename.
	 * @param  String $size 	Desired size.
	 * @param  int $quality 	Quality.
     * @return \Illuminate\Http\Response
     */
    public function image($file, $size = null, $quality = 85)
    {
        return \Cache::rememberForever($file . $size . $quality, function () use ($file, $size, $quality) {
            $width = 1000;
            $height = 1000;

            $size = strtolower($size);

            if ($size && strrpos($size, 'x') > 0) {
                list($width, $height) = explode("x", $size);
            }

            $storagePath  = \Storage::getDriver()->getAdapter()->getPathPrefix();
            $filePath = $storagePath  . '/uploads/' . $file;
            $extension = \File::extension($filePath);

            $img = \Image::make($filePath);

            $img->resize($width, $height, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            });

            return $img->response($extension, $quality);
        });
    }
}
