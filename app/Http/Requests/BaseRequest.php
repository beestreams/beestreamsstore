<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
    public function getImages()
    {
        $filesToReturn = [];
        $files = $this->files->all();
        foreach ($files['images'] as $key => $file) {
            $filesToReturn[] = $file;
            $file->alt_text = $this->images_alt_text[$key] ?? '';
        }
        return $filesToReturn;
    }
    public function getFiles()
    {
        $testfiles = [];
        foreach ($this->files as $key => $file) {
            $testfiles[$key]['file'] = $file;
        }
        return $testfiles;
    }
}
