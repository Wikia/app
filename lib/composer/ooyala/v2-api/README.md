# Ooyala's V2 API PHP SDK

The PHP SDK is a client class for our V2 API.

## Requirements

This SDK uses cURL. So, in order to get it running, you need to have the
[libcurl](http://curl.haxx.se/) package installed. 

If PHP is manually compiled, don't forget to add the --with-curl[=DIR]
configuration option. Or in Linux environments to make sure a php5-curl or
similar package is installed. In a Windows environment, libeay32.dll and
ssleay32.dll must be present in the PATH environment variable.

## Usage

The approach is very simple. It allows you to do GET, POST, PUT, PATCH and
DELETE requests to our API by simply specifying the path to the API you want
to hit and depending of the call, an Array with parameters and an Array
containing the body of the request.

By specifying an associative array object to represent the JSON data you want
to send, you can make calls very fast and easily. First you need to create an
OoyalaApi object by passing your V2 API keys like this:

```php
<?php
    $api = new OoyalaApi("<api key>", "<secret key>");
```

Now lets get all the assets under the "Funny dogs" label:

```php
<?php
    $parameters = array("where" => "labels INCLUDES 'Funny dogs'");

    $results = $api->get("assets", $parameters);
    $assets = $results->items;
```
  
Now that we have our results on the assets ArrayList, lets print them out to
the console.

```php
<?php
    echo "Printing assets in the 'Funny dogs' label...";
    foreach($assets as $asset) {
        echo $asset->embed_code . " - " . $asset->name . "\n";
    }
```

It's that easy to work with this SDK!

## License

See LICENSE file.
