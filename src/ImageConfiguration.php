<?php

namespace Codepane\LaravelImageHandler;

use Exception;

/**
 * trait image configuration
 */
trait ImageConfiguration
{
    /**
     * get quality for image
     *
     * @return int|string
     */
    public function getQuality(): int|string
    {
        $quality = config('imagehandler.quality');

        if(is_null($quality) || empty($quality))
            throw new Exception("Laravel Image Handler:: Quality not should be null or empty!");

        return $quality;
    }

    /**
     * get dimensions for image
     *
     * @return array|string
     */
    public function getDimensions(): array|string
    {
        $dimensions = config('imagehandler.dimensions');

        if(!$dimensions && count($dimensions) == 0)
            throw new Exception("Laravel Image Handler:: Dimensions are not valid. At least one dimension is mandatory!");

        return $dimensions;
    }

    /**
     * get storage disk for where to store image
     *
     * @return string
     */
    public function getStorageDisk()
    {
        return config('filesystems.default');
    }

    /**
     * It returns the format of the image
     *
     * @param string fileName The name of the file you want to get the format of.
     * @param string dimension The dimension of the image.
     *
     * @return string The format of the image.
     */
    public function getFormat(string $fileName = null, string $dimension = null)
    {
        $format = config('imagehandler.format');

        $allowedFormats = ['webp', 'jpeg', 'jpg', 'png'];

        if(is_null($format) || empty($format))
            throw new Exception("Laravel Image Handler:: Format should be exist or not null!");

        if(!in_array($format, $allowedFormats))
            throw new Exception("Laravel Image Handler:: Format should be webp or jpeg or jpeg or png!");

        return (!is_null($fileName) && !is_null($dimension) && $dimension == 'orig') ? pathInfo($fileName, PATHINFO_EXTENSION) : $format;
    }


    /**
     * It takes an image name, a time, and a dimension, and returns a new image name
     *
     * @param string imageName The name of the image file.
     * @param int time The time the image was last modified.
     * @param string dimension The dimension of the image.
     *
     * @return string The file name of the image.
     */
    public function makeFileName(string $imageName, int $time, string $dimension = null): string
    {
        $fileName = pathinfo($imageName, PATHINFO_FILENAME) . '-' . $dimension . '-'. $time;

        $directory = pathinfo($imageName, PATHINFO_DIRNAME);

        if(!empty($directory) && $directory != '.')
            $fileName = $directory . '/' . $fileName;

        $format = $this->getFormat($imageName, $dimension);

        return $fileName . '.' . $format;
    }

    /**
     * It takes a file name, splits it into two parts, and then returns the file name with the
     * dimension added to it
     *
     * @param string fileName The file name of the image.
     * @param string dimension The dimension of the image.
     *
     * @return string The file name with the dimension.
     */
    public function getFileName(string $fileName, string $dimension)
    {
        /* Getting the file extension of the file name. */
        $fileExt = $this->getFormat();

        $directory = pathinfo($fileName, PATHINFO_DIRNAME);

        /* Getting the file name without the extension. */
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);

        if(!empty($directory) && $directory != '.')
            $fileName = $directory . '/' . $fileName;

        /* Splitting the file name into two parts. The first part is the original file name and the second part is the time. */
        $fileNameWithDimension = preg_split('~-(?=[^-]*$)~', $fileName);

        /* Getting the time from the file name. */
        $time = $fileNameWithDimension[1];

        /* Splitting the file name into two parts. The first part is the original file name and the second part is the time. */
        $origFileName = preg_split('~-(?=[^-]*$)~', $fileNameWithDimension[0])[0];

        return $this->makeFileName($origFileName, $time, $dimension, $fileExt);
    }
}
