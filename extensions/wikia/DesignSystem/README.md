## How to update i18n
1. Update version number of `design-system-i18n` in `./package.json` file
1. Run `npm run setup` on your devbox which will:
  - install new version of `design-system-i18n`
  - build messages in MediaWiki format from the source files to `./i18n/` directory
  - rebuild localisation cache

## How to update mustache templates
 This extension uses grunt and grunt-mustache for exporting mustache templates to JS, so they can be available for client-side rendering.

1. Modify any of the mustache files in service/templates
1. run `npm run setup-template` to update templates.mustache.js

## How to update styles and icons
1. Update version number of `design-system` in `./bower.json` file
1. Run `bower install --force`
1. Remember to commit file changes in `bower_components`
