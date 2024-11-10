
# Laravel Persian Normalizer

A Laravel package for Persian text normalization. This package helps to normalize Persian text and convert it into a standardized format. It handles tasks such as converting Persian digits to English, replacing Persian characters with standardized ones, and normalizing text for storage or display.

## Features

- Normalize Persian text to a standardized format
- Convert Persian numbers to English digits
- Replace Persian characters with their standardized equivalents
- Can be easily integrated into Laravel applications using middleware
- Configurable via the Laravel configuration system

## Installation

### 1. Install the Package

You can install the package via Composer by running the following command:

```bash
composer require mrgear/laravel-persian-normalizer
```

### 2. Publish the Configuration File (Optional)
After installing, you may publish the configuration file to customize the settings according to your application's needs:

```bash
php artisan vendor:publish --provider="MRGear\PersianNormalizer\PersianNormalizerServiceProvider" --tag="config"
```
This will publish the configuration file to `config/mrgear-persian-normalizer.php`.

## Usage

### Middleware Usage
To normalize Persian text for all incoming requests, you can use the provided middleware. The middleware will automatically normalize the input data of all requests except those specified in the `except` configuration.

#### 1. Apply Middleware in Routes
You can use the middleware in your routes like this:

```php
Route::middleware(['mrgear-persian-normalizer'])->group(function () {
    Route::post('/some-route', [SomeController::class, 'someMethod']);
});
```
This middleware will normalize all incoming data for requests that pass through this route.

#### 2. Customize Middleware Behavior
You can specify which fields to exclude from normalization using the `except` configuration in the `config/mrgear-persian-normalizer.php` file.

Example configuration:

```php
return [
    'except' => ['password', 'email'],
];
```

### Using the Normalizer Class Directly
You can also use the normalizer directly in your controllers or services.

```php
use MRGear\PersianNormalizer\Facades\Normalizer;

$data = request()->all();
$normalizedData = Normalizer::normalizeAll($data);

return response()->json($normalizedData);
```
This will normalize all the fields in the request except the ones specified in the `except` array.

## Configuration
The package is configurable via the `config/mrgear-persian-normalizer.php` file. The following settings are available:

- `except`: An array of field names to exclude from normalization. Example: `['password', 'email']`
- `lowercase`: An array of fields that should be converted to lowercase. Example: `['email', 'username']`
- `preserve`: If set to true, Persian characters will be preserved as they are and not converted to their normalized versions.

### Example

**Before Normalization**

```php
$request = [
    'name' => 'محمد',
    'email' => 'Mohammad@example.com',
    'phone' => '۰۹۱۲۳۴۵۶۷۸۹',
];
```

**After Normalization**

```php
$request = [
    'name' => 'محمد',  // no change if no normalization needed
    'email' => 'mohammad@example.com',
    'phone' => '09123456789',
];
```

## License
This package is open-source software licensed under the MIT License.
