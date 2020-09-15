sailthru-php5-client
====================

[![Build Status](https://travis-ci.org/sailthru/sailthru-php5-client.svg?branch=master)](https://travis-ci.org/sailthru/sailthru-php5-client)
[![Coverage Status](https://coveralls.io/repos/github/sailthru/sailthru-php5-client/badge.svg?branch=master)](https://coveralls.io/github/sailthru/sailthru-php5-client?branch=master)

For installation instructions, documentation, and examples please visit:
[http://getstarted.sailthru.com/new-for-developers-overview/api-client-library/php5](http://getstarted.sailthru.com/new-for-developers-overview/api-client-library/php5)

A simple client library to remotely access the `Sailthru REST API` as per [http://getstarted.sailthru.com/developers/api](http://getstarted.sailthru.com/developers/api)

By default, it will make request in `JSON` format.

## Optional parameters for connection/read timeout settings

Increase timeout from 10 (default) to 30 seconds.

    $client = new Sailthru_Client($this->api_key, $this->secret, $this->api_url, array('timeout' => 30000, 'connect_timeout' => 30000));

## API Rate Limiting

Here is an example how to check rate limiting and throttle API calls based on that. For more information about Rate Limiting, see [Sailthru Documentation](https://getstarted.sailthru.com/new-for-developers-overview/api/api-technical-details/#Rate_Limiting)


```php
// get last rate limit info
$rate_limit_info = $sailthru_client->getLastRateLimitInfo("user", "POST");

// getRateLimitInfo returns null if given endpoint/method wasn't triggered previously
if ($rate_limit_info) {
    $limit = $rate_limit_info['limit'];
    $remaining = $rate_limit_info['remaining'];
    $reset_timestamp = $rate_limit_info['reset'];

    // throttle api calls based on last rate limit info
    if ($remaining <= 0) {
        $seconds_till_reset = $reset_timestamp - time();

        // sleep or perform other business logic before next user api call
        sleep($seconds_till_reset);
    }
}
```

## Tests

You can run the tests locally with:

```shell
vendor/bin/phpunit
```


