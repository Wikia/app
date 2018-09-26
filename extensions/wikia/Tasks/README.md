Tasks
=====

This extension provides `proxy.php` entry point that is used by [Celery](https://github.com/Wikia/celery-workers) to execute MediaWiki offline tasks via HTTP.

## HTTP requests to `proxy.php`

`proxy.php` gets HTTP requests from Celery using the following URLs:

* devboxes - `http://tasks.<devbox name>.wikia-dev.pl/proxy.php`
* sandboxes - `http://community.<sandbox name>.wikia.com/extensions/wikia/Tasks/proxy/proxy.php`
* production - `http://prod.task.service.consul/proxy.php` (Apache) or `http://mediawiki-tasks/proxy.php` (Kubernetes) - this is handled by web-server rewrite

Task parameters and metadata are passed as POST request fields.
Additionally, ID of the wiki given task should be run for is passed via `X-Mw-Wiki-Id` HTTP request header.

`proxy.php` requires `X-Wikia-Internal-Request` request header to be present,
hence it can only be called from within Wikia infrastructure. Otherwise `HTTP 403 Forbidden` is returned.

## Response

`proxy.php` JSON response has the following structure:

```json
{
  "status": "success",
  "retval": null
}
```
