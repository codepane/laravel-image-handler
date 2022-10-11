
# Laravel Image Handler

Handle image in multiple different size with optimization.


### Installation steps
```
composer require codepane/laravel-image-handler
php artisan vendor:publish --provider="codepane\LaravelImageHandler\ImageHandlerServiceProvider"
```

### Configuration

* After installation done once you can see imagehandler.php under the config dirctory.
* You can udpate dimensions, format and quality as per your need from configuration file.
* You can also add new dimension.



## Usage
Lets deep dive into this package for how to use it

### Store Image
```
use ImageHandler;

public function store()
{
    // its take default file name as it is
    ImageHandler::store($request->file);

    // in 2nd argument you can pass your custom file name with or without path
    ImageHandler::store($request->file, 'file_name_with_or_without_path');
}
```

### Get Image
```
use ImageHandler;

public function get()
{
    // this will return original image
    ImageHandler::get('original_file_name');

    // pass dimension as second argument for get specific dimension of file
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

- Make pull request if you have to contribute for this lovely library!
- We will review and pull your request.
