This extensions runs ad stack using [@Wikia/ad-engine](https://github.com/Wikia/ad-engine) codebase.

**It is no longer supported!** AdEngine updates and code changes won't trigger asset build job, which will prepare a production package.

## How does it work?

All `*.js` files are build into `dist/` using webpack command 
on each merge to dev branch (by using `build_adengine_assets_app` Jenkins job).

Everything starts in `module.js` file.

### Build assets for development

```bash
npm run build
```

or

```bash
npm run watch
```

It's going to build all assets into `dist-dev/` directory (which is ignored). 
In order to force code to use dev assets you need to switch wg variable in your config. 
For example:

`Wikia/config` - `dev-<devbox-username>.php`:
```php
<?php

$wgAdDriverAdEngine3DevAssets = true;
```

When you are using dev assets it is possible to easily access prod (dist) assets 
by appending query url parameter: `?ae3_prod=1`.

⚠️ Sandbox is using dev assets by default when code is deployed with `debug` parameter.


### Build assets for production

⚠️ **Production `dist/` assets shouldn't be commited manually.** 
Everything should happen automatically on merging changes to `dev` branch.
