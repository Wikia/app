dev
===

You can run Wikia's app locally using `docker-compose`.

* Build dev image: `docker build . -t php-wikia-dev` (run the command from this directory)
* Add the following entry to `/etc/hosts`: `127.0.0.1	wikia-local.com muppet.wikia-local.com`

Run:

```
docker-compose up
```

Then you can use `docker exec` to take a look inside the container:

```
docker exec -it dev_php-wikia_1 bash
```

## Permissions

To run unit tests set up the `app/tests/build` directory to be owned by `nobody:nogroup`.

To rebuild localisation cache you need to have `cache` directory created at the same level as `app` and `config` git clones.
`cache` directory should have `777` rights set up and have an empty file touched there.

## Troubleshouting 

* If you have problems with DNS host names resolution, you need to [disable `dnsmaqs` on your machine](https://askubuntu.com/questions/320921/having-dns-issues-when-connected-to-a-vpn-in-ubuntu-13-04).
