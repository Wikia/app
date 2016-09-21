## How to update i18n
1. Update version number of `design-system-i18n` in `./package.json` file
1. Run `npm run setup` on your devbox which will:
  - install new version of `design-system-i18n`
  - build messages in MediaWiki format from the source files to `./i18n/` directory
  - rebuild localisation cache
  
## How to update styles and icons
1. Update version number of `design-system` in `./bower.json` file
1. Run `bower install`
1. Remember to commit file changes in `bower_components`
