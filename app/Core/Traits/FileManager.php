<?php

namespace App\Core\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileManager
{
    /**
     * Set the name to indicate what is the disk that must use
     * @var string
     */
    protected $disk_name;

    protected function getUploadFilename(UploadedFile $file): string
    {
        return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
    }

    protected function getBase64Filename(string $file)
    {
        return uniqid() . \Carbon\Carbon::now()->timestamp . '.' . $this->getBase64FileExtension($file);
    }

    protected function getBase64FileExtension(string $file)
    {
        return preg_replace(
            ["/data:[a-z]+\//", "/\+[a-z]+/", "/;/", "/base64/"],
            ['', '', '', ''],
            explode(',', $file)[0]
        );
    }

    public function path(string $filename): string
    {
        return Storage::disk($this->disk_name)->getDriver()->getAdapter()->getPathPrefix() . $filename;
    }

    protected function getFile(string $filename)
    {
        if (Storage::disk($this->disk_name)->exists($filename)) {
            return Storage::disk($this->disk_name)->get($filename);
        } else {
            return null;
        }
    }

    public function storeFile(UploadedFile $file, string $filename = null): string
    {
        $filename = is_null($filename) ? $this->getUploadFilename($file) : $filename;

        Storage::disk($this->disk_name)->put($filename, File::get($file));

        return $filename;
    }

    public function storeBase64File(string $filename, string $base64File): string
    {
        if (is_null($base64File)) {
            return null;
        }

        if (strpos($base64File, ';base64') !== false) {
            [, $base64File] = explode(';', $base64File);
            [, $base64File] = explode(',', $base64File);
        }

        $file = base64_decode($base64File);

        Storage::disk($this->disk_name)->put($filename, $file);

        return $filename;
    }

    /**
     * @param string $path
     * @param string|UploadedFile $file
     * @return string
     */
    protected function saveFile(string $path, $file): string
    {
        if ($file instanceof UploadedFile) {
            $file_path = $path . DIRECTORY_SEPARATOR . $this->getUploadFilename($file);
            $filename = $this->storeFile($file, $file_path);
        } else {
            $file_path = $path . DIRECTORY_SEPARATOR . $this->getBase64Filename($file);
            $filename = $this->storeBase64File($file_path, $file);
        }
        $filename = explode(DIRECTORY_SEPARATOR, $filename);
        return array_pop($filename);
    }

    public function deleteFile(string $filename)
    {
        if (Storage::disk($this->disk_name)->exists($filename)) {
            return Storage::disk($this->disk_name)->delete($filename);
        }
        return false;
    }

    public function fileToBase64(string $filename) {
        $file_to_convert = $this->getFile($filename);
        if ($file_to_convert) {
            return base64_encode($file_to_convert);
        }
        return null;
    }


}