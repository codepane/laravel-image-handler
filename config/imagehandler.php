<?php

return [

    // Set the default image quality.
    'quality' => env('IMAGE_HANDLER_QUALITY', 75),

    // YOU CAN EDIT THIS DIMENSIONS AS PER YOU NEED
    'dimensions' => [
        /* This is the default image size for the small image. */
        'sm' => [
            'width' => 80,
            'height' => 80
        ],
        /* Setting the default image size for the medium image. */
        'md' => [
            'width' => 200,
            'height' => 200
        ],
        /* This is the default image size for the large image. */
        'lg' => [
            'width' => 450,
            'height' => 450
        ],

    ],

    /**
     * The readable image formats depend on the choosen driver (GD or Imagick) and your local configuration.
     *
     * Formats:
     * png, jpeg, gif, webp, tif, bmp, ico, psd, webp
     */
    'format' => env('IMAGE_HANDLER_FORMAT', 'webp')
];
