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
