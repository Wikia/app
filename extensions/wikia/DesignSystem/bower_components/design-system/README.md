# Wikia | Design System

## Design System Reference Page
https://rawgit.com/Wikia/design-system/master/reference-page/index.html

### Confluence page
https://wikia-inc.atlassian.net/wiki/display/DESYS/Design+System

###Developing

1. Download repository
1. Go to repository
1. Run command: `npm run setup`, to install dependencies
1. Run command: `npm run dev`, to build Reference Page and to watch files
1. Start developing

### Scripts

- `npm run setup` - install all dependencies like node modules and bower components
- `npm run build` - build Reference Page and store output in *reference-page/index.html*
- `npm run dev` - build Reference Page on each file change
- `npm run test` - run Visual Regression Tests (this shouldn't be run manually, see [Visual Regression Testing](#visual-regression-testing))
- `npm run update-baseline` - run Visual Regression Tests and update the baseline images (this shouldn't be run manually, see [Visual Regression Testing](#visual-regression-testing))

### Live page reload

Running `npm run dev` will rebuild files on each change, but to see them live you have to refresh page in browser.
If you want it to be automatically, follow these steps:

1. Install [livereload browser extension](http://livereload.com/extensions/)
1. Open Reference Page reference-page/index.html (make sure that page is served from server, because accessing page from *file://* protocol will not work)
1. Make change in code
1. Enjoy your fresh page

If you are using IDE from JetBrains like IntelliJ IDEA, you can access Reference Page by:

1. Right click on *reference-page/index.html*
1. Select *Open in browser* and choose browser that you have livereload extension installed

### Visual Regression Testing

We use [visual-regression-testing](https://github.com/Wikia/visual-regression-testing) library to run tests that compare the look of the Design System Reference Page before and after the change.

Tests are running always on the same QA VM which makes results consistent. How the page looks depends not just on the code but also on the system, browser, fonts installed, screen size and so on. Comparing tests results between different systems doesn't make much sense as they will always differ. That's why we don't recommend running the VRT locally.

Tests are started on every push to the repo and if they fail on your branch you can't merge it to the `master`. When the tests fail Jenkins will add a commit comment with two links:

1. Jenkins workspace where you can see screenshots before and after the change and their diffs.
1. Jenkins job that will update the baseline on your branch. Run it when you're sure that the changes were correct.

### Design System Rest API

Some components, like the global navigation and footer, require a data source for items like link titles, urls, logo image references, etc. The data source is the design system rest API. It is currently built in MediaWiki but the plan is to turn it into a Java service. 

#### Rest API Links
* Example API requests: 
 * [English global footer for wookipedia](http://www.wikia.com/api/v1/design-system/wikis/147/en/global-footer)
 * [German global footer for fandom](http://www.wikia.com/api/v1/design-system/fandoms/1/de/global-navigation)
* [API Tests Repo](https://github.com/Wikia/api-tests)
 * [JSON schema](https://github.com/Wikia/api-tests/blob/master/apitests/DesignSystem/wds_schema.py)
 * Make sure tests are passing when changes are made to the design system rest API ;)
* [Example chef repo apache rewrites](https://github.com/Wikia/chef-repo/blob/ee56a97982b76cdc8d0c1543227492d3f252f10f/cookbooks/apache/templates/default/rewritesShort-fpm.conf.erb#L165)
* Some MediaWiki files of interest: 
 * [Footer model](https://github.com/Wikia/app/blob/8a5d246998f8dfc98f422eb30d345e29b9f78d82/includes/wikia/models/DesignSystemGlobalFooterModel.class.php)
 * [API Controller](https://github.com/Wikia/app/blob/8a5d246998f8dfc98f422eb30d345e29b9f78d82/includes/wikia/api/DesignSystemApiController.class.php)

## Contributors
See [contributors on GitHub](https://github.com/Wikia/design-system/graphs/contributors).

## Copyright
Code and documentation copyright 2016 Wikia, Inc.
