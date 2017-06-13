<?php

namespace App\Files;

use Storage;
use SplFileInfo;
use App\Files\FileRepository;

/***
 * Use this trait on laravel models to save images and files
 *
 *  Setting up the FileHandler
 * **********************************
 *  Require in the trait by using it in the model class ( use MBKundzon\Files\FileHandler; )
 *  Set a public static $filePath on the model
 *  Make sure it follows this convention: public static $filePath = '/uploads/folder'
 *
 *  Saving the files:
 * **********************************
 *  Make sure the $allowedFiles is set and has the name of the input filed in the array
 *  $model = new Model; // Model using this trait
 *  $model->setFiles($formData); // $formData (Array)
 *  $model->save(); // This will trigger the save method below
 *
 **/

trait Fileable
{
    private static $files;
    private static $images;
    protected $allowedFiles = ['image', 'image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
    
    private $imgSizes = [ 'thumbnail' => ['100', null], 'square_thumb' => ['140', '140'], 'small' => ['250', null], 'medium' => ['500', null], 'large' => ['1200', null] ];

    private $model;

    public function files()
    {
        return $this->morphMany(File::class, 'fileable')->orderBy('order');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'storeable')
            ->orderBy('created_at', 'desc');
    }

    public function image()
    {
        return $this->morphOne(File::class, 'fileable')
            ->orderBy('created_at', 'desc')
            ->onlyImages();
    }

    public function images()
    {
        return $this->morphMany(File::class, 'fileable')
            ->onlyImages();
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            if (count(self::$files) > 0) {
                $fileRepository = new FileRepository();
                $fileRepository->setModel($model);
                $fileRepository->setFilePath(static::$filePath.'/'.$model->id);
                $fileRepository->saveFiles(self::$files);
            }
        });

        static::deleting(function ($model) {
            # Delete all the files when the model is deleted
            if (count($model->files) > 0) {
                $model->files->each(function ($file) {
                    $file->delete();
                });
            }
        });
    }

    public function setFiles($files)
    {
        $this::$files = $files;
    }
}
