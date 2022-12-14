<?php

namespace Codepane\LaravelImageHandler;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageHandler
{
    /* Importing the methods from the `ImageConfiguration` trait. */
    use ImageConfiguration;

    /**
     * It takes an image, optimizes it, and stores it in the storage disk
     *
     * @param object image The image object.
     *
     * @return string The original file name.
     */
    public function store(object $image, string $imgPath = null): string
    {
        $dimensions = $this->getDimensions();
        $storageDisk = $this->getStorageDisk();
        $time = time();

        if(is_null($imgPath))
            $imgPath = $image->getClientOriginalName();

        /* Creating a file name for the original image. */
        $fileOriginalName = $this->makeFileName($imgPath, $time, 'orig');

        $this->makeDirectoryIfDoesNotExist($storageDisk, $fileOriginalName);

        $this->storeImg($storageDisk, $fileOriginalName, file_get_contents($image));

        foreach($dimensions as $key => $dimension) {

            /* Creating a file name for the image. */
            $fileName = $this->makeFileName($imgPath, $time, $key);

            /* Optimizing the image. */
            $optimizedImg = $this->optimize($image->getRealPath(), $dimension, $this->getFormat());

            /* Storing the image in the storage disk. */
            $this->storeImg($storageDisk, $fileName, $optimizedImg);
        }

        $fileBaseName = pathinfo($fileOriginalName, PATHINFO_BASENAME);

        return $fileBaseName;
    }

    /**
     * make a directory if does not exist
     *
     * @param string $storageDisk
     * @param string $fileName
     *
     * @return void
     */
    public function makeDirectoryIfDoesNotExist(string $storageDisk, string $fileName)
    {
        $directory = pathinfo($fileName, PATHINFO_DIRNAME);

        if(($storageDisk == 'local' || $storageDisk == 'public') && !Storage::disk($storageDisk)->exists($directory)) {
            $dirPath = Storage::disk($storageDisk)->path($directory);
            File::makeDirectory($dirPath, 0777);
        }
    }

    /**
     * It stores an image in a specified disk.
     *
     * @param string disk The disk you want to store the file on.
     * @param string fileName The name of the file you want to store.
     * @param string file The file to be stored.
     *
     * @return void
     */
    public function storeImg(string $disk, string $fileName, string $file): void
    {
        Storage::disk($disk)->put( $fileName, $file);
    }

    /**
     * It takes an image, resizes it to the dimensions provided, and returns the image in the format provided
     *
     * @param string image The image to be optimized
     * @param array dimensions An array of width and height.
     * @param string format The format of the image.
     *
     * @return string The image is being returned.
     */
    public function optimize(string $image, array $dimensions, string $format) : string
    {
        $manager = (new ImageManager());
        $image = $manager->make($image);
        $image->resize($dimensions['width'], $dimensions['height']);
        $image->encode($this->getFormat());

        return $image;
    }

    /**
     * It returns the file contents of the file with the given name and dimension
     *
     * @param string fileName The name of the file you want to get.
     * @param string dimension The dimension of the image you want to get.
     *
     * @return The file contents.
     */
    public function get(string $fileName, string $dimension = 'orig')
    {
        $fileName = $this->getFileName($fileName, $dimension);

        return Storage::disk($this->getStorageDisk())->get($fileName);
    }


    /**
     * It deletes the original file and all the resized versions of it
     *
     * @param string fileName The name of the file to be deleted.
     */
    public function delete(string $fileName): void
    {
        $dimensions = $this->getDimensions();
        $storageDisk = $this->getStorageDisk();

        if(!Storage::disk($storageDisk)->exists($fileName))
            throw new Exception("Laravel Image Handler:: File does not exists");

        $this->removeFile($storageDisk, $fileName);

        foreach($dimensions as $dimension => $val) {
            $fileName = $this->getFileName($fileName, $dimension);

            $this->removeFile($storageDisk, $fileName);
        }
    }

    /**
     * It removes a file from a storage disk
     *
     * @param string storageDisk The name of the storage disk you want to use.
     * @param string fileName The name of the file to be deleted.
     */
    public function removeFile(string $storageDisk, string $fileName): void
    {
        Storage::disk($storageDisk)->delete($fileName);
    }
}
