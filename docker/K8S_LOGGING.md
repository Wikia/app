In order for logs to be correctly processed on out kubernetes infrastructure, they MUST be printed to stdout as valid json, one log per line.

Due to a problem in PHP's zlog, which causes messages to be truncated (https://github.com/php/php-src/pull/2458) and `php-fpm` adding a prefix to stdout, we had to create an external logger for our MW instances.
MW will send logs to a socket (9999 by default), which will then be printed to stdout on a different container within the same pod.

Note that this is only a problem when using FPM. Therefore, code that uses the CLI SAPI—such as maintenance scripts—can and do directly log JSON messages to stdout without using the logger sidecar.

The logger's image is currently available at `artifactory.wikia-inc.com/sus/mediawiki-logger`.
