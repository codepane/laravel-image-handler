
# Laravel Image Handler

Optimize and store images in multiple sizes easily.


### Installation steps
```
composer require codepane/laravel-image-handler
php artisan vendor:publish --provider="Codepane\LaravelImageHandler\ImageHandlerServiceProvider"
```

### Configuration

* After installation is done once you can see imagehandler.php under the config directory.
* You can update dimensions, format, and quality as per your need from a configuration file.
* You can also add a new dimension.



## Usage
Let's deep dive into this package for how to use it

### Store Image
```
use ImageHandler;

public function store()
{
    // its takes the default file name as it is
    ImageHandler::store($request->file);

    // in 2nd argument you can pass your custom file name with or without the path
    ImageHandler::store($request->file, 'file_name_with_or_without_path');
}
```

### Get Image
```
use ImageHandler;

public function get()
{
    // this will return the original image
    ImageHandler::get('original_file_name');

    // pass dimension as the second argument to get a specific dimension of the file
    ImageHandler::get('original_file_name', 'sm');
}
```

### Delete Image
```
use ImageHandler;

public function delete()
{
    ImageHandler::delete('original_file_name');
}
```


## Contributing

Contributions are always welcome!

- Make a pull request if you have to contribute to this lovely library!
- We will review and pull your request.
