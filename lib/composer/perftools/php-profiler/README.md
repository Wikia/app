# PHP Profiler

A PHP profiling library based on [XHGUI Data Collector][1].

This project replaces `header.php` approach from xhgui-collector with object based approach.

Supported profilers:
 - [Tideways XHProf v5.x](#tideways-xhprof-5): PHP >= 7.0
 - [XHProf](#xhprof): PHP >= 5.3, PHP >= 7.0
 - [Tideways v4.x](#tideways-4x): PHP >= 7.0
 - [UProfiler](#uprofiler): PHP >= 5.3, < PHP 7.0

This profiling library will auto-detect any supported profiler and use that.
The specific profiler can be choosen by `profiler` config key.

## Goals

 - Compatibility with PHP >= 5.3.0
 - No dependencies aside from the relevant extensions
 - Customizable and configurable so you can build your own logic on top of it

## Usage

In order to profile your application, you need to:
- [Install this package](#installation)
- [Install profiler extension](#installing-profilers)
- [Instantiate the profiler](#create-profiler)
- [Configure profiler to send data to XHGui](#config)

## Installation

The supported way to install this package is via [composer]:

```
composer require perftools/php-profiler
```

[composer]: https://getcomposer.org/

## Create profiler

Creating profiler would be something like this:

```php
<?php

// Add this block inside some bootstrapper or other "early central point in execution"
try {
    /**
     * The constructor will throw an exception if the environment
     * isn't fit for profiling (extensions missing, other problems)
     */
    $profiler = new \Xhgui\Profiler\Profiler($config);

    // The profiler itself checks whether it should be enabled
    // for request (executes lambda function from config)
    $profiler->start();
} catch (Exception $e){
    // throw away or log error about profiling instantiation failure
}
```

If you need to disable profiler doing `flush`, `session_write_close` and
`fastcgi_finish_request` at the end of profiling, pass `false` to register
shutdown handler:

```php
$profiler->start(false);
```

## Advanced Usage

You might want to control capture and sending yourself,
perhaps modify data before sending.

```php
/** @var \Xhgui\Profiler\Profiler $profiler */
// start profiling
$profiler->enable($flags, $options);

// run program
foo();

// stop profiler
$profiler_data = $profiler->disable();

// send $profiler_data to saver
$profiler->save($profiler_data);
```

## Config

Here's a reference config of what can be configured.

```php
<?php
$config = array(
    // If defined, use specific profiler
    // otherwise use any profiler that's found
    'profiler' => \Xhgui\Profiler\Profiler::PROFILER_TIDEWAYS_XHPROF,

    // This allows to configure, what profiling data to capture
    'profiler.flags' => array(
        \Xhgui\Profiler\ProfilingFlags::CPU,
        \Xhgui\Profiler\ProfilingFlags::MEMORY,
        \Xhgui\Profiler\ProfilingFlags::NO_BUILTINS,
        \Xhgui\Profiler\ProfilingFlags::NO_SPANS,
    ),

    // Saver to use.
    // Please note that 'pdo' and 'mongo' savers are deprecated
    // Prefer 'upload' or 'file' saver.
    'save.handler' => \Xhgui\Profiler\Profiler::SAVER_UPLOAD,

    // Environment variables to exclude from profiling data
    'profiler.exclude-env' => array(
        'APP_DATABASE_PASSWORD',
        'PATH',
    ),

    'profiler.options' => array(
    ),

    /**
     * Determine whether profiler should run.
     * This default implementation just disables the profiler.
     * Override this with your custom logic in your config
     * @return bool
     */
    'profiler.enable' => function () {
        return false;
    },

    /**
     * Creates a simplified URL given a standard URL.
     * Does the following transformations:
     *
     * - Remove numeric values after "=" in query string.
     *
     * @param string $url
     * @return string
     */
    'profiler.simple_url' => function($url) {
        return preg_replace('/=\d+/', '', $url);
    },

    /**
     * Enable this to clean up the url before submitting it to XHGui.
     * This way it is possible to remove sensitive data or discard any other data.
     *
     * The URL argument is the `REQUEST_URI` or `argv` value.
     *
     * @param string $url
     * @return string
     */
    'profiler.replace_url' => function($url) {
        return str_replace('token', '', $url);
    },
);
```

## Savers

To deliver captured data to XHGui, you will need one of the savers to submit to the datastore XHGui uses.

- [Upload saver](#upload-saver)
- [File saver](#file-saver)
- [MongoDB Saver](#mongodb-saver)
- [PDO Saver](#pdo-saver)

### Upload saver

This is the recommended saver as it's the easiest to set up.

Example config:

```php
    'save.handler' => \Xhgui\Profiler\Profiler::SAVER_UPLOAD,

    // Saving profile data by upload is only recommended with HTTPS
    // endpoints that have IP whitelists applied.
    'save.handler.upload' => array(
        'uri' => 'https://example.com/run/import',
        // The timeout option is in seconds and defaults to 3 if unspecified.
        'timeout' => 3,
        // the token must match 'upload.token' config in XHGui
        'token' => 'token',
    ),
```

### File saver

If your site cannot directly connect to your XHGui instance, you can choose
to save your data to a temporary file for a later import to XHGui.

Example config:

```php
    'save.handler' => \Xhgui\Profiler\Profiler::SAVER_FILE,
    'save.handler.file' => array(
        // Appends jsonlines formatted data to this path
        'filename' => '/tmp/xhgui.data.jsonl',
    ),
```

To import a saved files, use XHGui's provided `external/import.php` script.

### MongoDB Saver

For saving directly to MongoDB you would need [ext-mongo] for PHP 5
and [ext-mongodb] with [alcaeus/mongo-php-adapter] package for PHP 7
along with `perftools/xhgui-collector` package:

for PHP 5:
```
pecl install mongo
composer require perftools/xhgui-collector
```

for PHP 7:
```
pecl install mongodb
composer require perftools/xhgui-collector alcaeus/mongo-php-adapter
```

[ext-mongo]: https://pecl.php.net/mongo
[ext-mongodb]: https://pecl.php.net/mongodb
[alcaeus/mongo-php-adapter]: https://github.com/alcaeus/mongo-php-adapter

Example config:

```php
    'save.handler' => \Xhgui\Profiler\Profiler::SAVER_MONGODB,
    'save.handler.mongodb' => array(
        'dsn' => 'mongodb://127.0.0.1:27017',
        'database' => 'xhprof',
        // Allows you to pass additional options like replicaSet to MongoClient.
        // 'username', 'password' and 'db' (where the user is added)
        'options' => array(),
        // Allows you to pass driver options like ca_file to MongoClient
        'driverOptions' => array(),
    ),
```

### PDO Saver

PDO Saver should be able to save to any PDO driver connection.

You will need to install additionally `perftools/xhgui-collector` package:

```
composer require perftools/xhgui-collector
```

Example config:

```php
    'save.handler' => \Xhgui\Profiler\Profiler::SAVER_PDO,
    'save.handler.pdo' => array(
        'dsn' => 'sqlite:/tmp/xhgui.sqlite3',
        'user' => null,
        'pass' => null,
        'table' => 'results'
    ),
```

## Configure Profiling Rate

You may want to change how frequently you profile the application.  The
`profiler.enable` configuration option allows you to provide a callback
function that specifies the requests that are profiled.

The following example configures to profile 1 in 100 requests, excluding
requests with the `/blog` URL path:

```php
    'profiler.enable' => function() {
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '/blog') === 0) {
            return false;
        }

        return mt_rand(1, 100) === 42;
    },
```

In contrast, the following example instructs to profile _every_
request:

```php
    'profiler.enable' => function() {
        return true;
    },
```

## Configure 'Simple' URLs Creation

This library generates 'simple' URLs for each profile collected. These URLs are
used to generate the aggregate data used on the URL view. Since different
applications have different requirements for how URLs map to logical blocks of
code, the `profile.simple_url` configuration option allows you to provide
the logic used to generate the simple URL.

By default, all numeric values in the query string are removed.

```php
    'profile.simple_url' => function($url) {
        return preg_replace('/=\d+/', '', $url);
    },
```

## Configure ignored functions

You can use the `profiler.options` configuration value to set additional options
for the profiler extension. This is useful when you want to exclude specific
functions from your profiler data:

```php
    'profiler.options' => array(
        'ignored_functions' => array(
            'call_user_func',
            'call_user_func_array',
        ),
    ),
);
```

In addition, if you do not want to profile all PHP built-in functions,
Add `ProfilingFlags::NO_BUILTINS, to 'profiler.flags'.

## Run description

When Profiler object constructed, it determines that requirements are in place, whether
profiling should run, which save handler to construct and constructs the save handler.
In case of failures, it will throw an exception.

`enable` will detect an available profiler and call its enable function with the current
configuration.

`registerShutdownHandler` will ensure profer is running and then call
`register_shutdown_handler`. It will register a shutdown handler that provides the
calls for finishing profiling and storing the data.

[1]: https://packagist.org/packages/perftools/xhgui-collector
[2]: src/ProfilingFlags.php

## Installing profilers

For this library to capture profiling data, you would need any of the profiler extension.
Depending on your environment (PHP version), you may need to install different extension.

### XHProf

[XHProf] supports all PHP versions.

- `xhprof` 0.9.x requires PHP >= 5.3, < PHP 7.0
- `xhprof` 2.x requires PHP >= 7.0

for PHP 5:
```
pecl install xhprof-0.9.4
```

for PHP 7:
```
pecl install xhprof
```

Alternatively on `brew` (macOS) you can use packages from [kabel/pecl] tap:

```
brew install kabel/pecl/php@7.2-xhprof
brew install kabel/pecl/php@7.3-xhprof
brew install kabel/pecl/php-xhprof
```

[XHProf]: https://pecl.php.net/package/xhprof


### Tideways (4.x)

[Tideways] 4.x extension requires with PHP >= 7.0.

To install `tideways` extension, see their [installation documentation][Tideways].

```
curl -sSfL https://github.com/tideways/php-xhprof-extension/archive/v4.1.6.tar.gz | tar zx
cd php-xhprof-extension-4.1.6/
phpize
./configure
make
make install
echo extension=/usr/local/lib/php/pecl/20160303/tideways.so | tee /usr/local/etc/php/7.1/conf.d/ext-tideways.ini
```

[Tideways]: https://tideways.com/profiler/downloads

### Tideways XHProf (5.+)

[Tideways XHProf v5.x][tideways_xhprof] requires PHP >= 7.0.

To install `tideways_xhprof` extension, see their [installation documentation][tideways-xhprof-install].

[tideways_xhprof]: https://github.com/tideways/php-xhprof-extension
[tideways-xhprof-install]: https://github.com/tideways/php-xhprof-extension#installation

Alternatively on `brew` (macOS) you can use packages from [kabel/pecl] or [glensc/tap] taps:

```
brew install glensc/tap/php@7.1-tideways-xhprof
brew install kabel/pecl/php@7.2-tideways-xhprof
brew install kabel/pecl/php@7.3-tideways-xhprof
brew install kabel/pecl/php-tideways-xhprof
```

[kabel/pecl]: https://github.com/kabel/homebrew-pecl
[glensc/tap]: https://github.com/glensc/homebrew-tap

### UProfiler

[UProfiler] requires PHP >= 5.3, < PHP 7.0

To install `uprofiler` extension, see their [installation documentation][uprofiler-install].

[UProfiler]: https://github.com/FriendsOfPHP/uprofiler
[uprofiler-install]: https://github.com/FriendsOfPHP/uprofiler#installing-the-uprofiler-extension
