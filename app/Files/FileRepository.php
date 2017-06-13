<?php

namespace App\Files;

use Illuminate\Database\Eloquent\Collection;
use Storage;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;

class FileRepository
{
    private $imgSizes = [
        'thumbnail'    => ['100', null],
        'square_thumb' => ['140', '140'],
        'small'        => ['250', null],
        'medium'       => ['500', null],
        'large'        => ['1200', null]
        ];

    private $filePath = 'uploads/';
    private $model;

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    public function saveFiles($files)
    {
        if (!is_array($files)) {
            $files = [$files];
        }
        foreach ($files as $file) {
            if (empty($file->file_name)) {
                $file->file_name = $this->generateFileName($file);
            }


            $file->file_path = "{$this->filePath}/{$this->model->id}/";
            // $file->file_size = $file->getClientSize();
            // dd($file);
            $file->mimetype = $file->getMimeType();

            # Prepare file model
            $file_model = new File();
            $file_model->mimetype = $file->getMimeType();
            $file_model->file_size = $file->getClientSize();
            $file_model->file_name = $file->file_name;
            $file_model->alt_text  = $file->alt_text;
            $file_model->file_path = $this->filePath;

            # Associate to storeable
            $file_model->fileable()->associate($this->model);
            
            # Upload file
            # Check if the file is an image
            // dd($file_model);
            if (substr($file_model->mimetype, 0, 5) == 'image') {
                # Create different image sizes & store them
                $this->storeImage($file, $file->file_name);
            }
            # Otherwise just store the file
            else {
                $this->storeFile($file, $file->file_name);
            }

            $file_model->save();
        }
    }

    private function storeImage($file, $file_name)
    {
        $imageManager = new ImageManager();
        $path = $file->file_path;
        # Create directory if it doesn't exist
        Storage::makeDirectory($path);

        if ($file->getMimeType() != "image/svg+xml") {
            foreach ($this->imgSizes as $size_name => $dimensions) {
                $width = $dimensions[0];
                $height = $dimensions[1];
                if (isset($width) && isset($height)) {
                    $image = $imageManager
                        ->make($file)
                        ->encode('jpg')

                        ->fit($width, $height, function ($constraint) {
                            $constraint->upSize();
                        })
                        ->save(config('filesystems.disks.local.root')."{$path}/{$size_name}_{$file_name}");
                } else {
                    $image = $imageManager->make($file)
                        ->encode('jpg')
                        ->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save(config('filesystems.disks.local.root')."{$path}/{$size_name}_{$file_name}");
                }
            }

            # Save original file aswell
            $this->storeFile($file, $file_name);
        }
        if ($file->getMimeType() == "image/svg+xml") {
            $this->storeFile($file, $file_name);
        }
    }

    private function storeFile($file, $file_name)
    {
        $path = $file->file_path;
        Storage::put("{$path}/{$file_name}", file_get_contents($file->getRealPath()));
    }

    private function generateFileName($file)
    {
        $random = str_random(6);
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // dd($file);
        $extension = $file->getClientOriginalExtension();
        # Example of the filename: orignalname_7hjsKm.jpg
        // $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME). "_" . str_random(6) . "." . ;

        # If the file exist, generate a new filename
        if (Storage::exists("{$this->filePath}/original_{$filename}")) {
            $filename = $this->generateFileName($file);
        }

        # Return the filename
        return $filename;
    }
}
