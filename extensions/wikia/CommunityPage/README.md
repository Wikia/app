# CommunityPage Extension

## Front-end Assets & Installation
This extension uses grunt and grunt-mustache for exporting mustache templates to JS, so they can be available for client-side rendering.

To install:

* Make sure npm is installed on your development environment (i.e. local computer or devbox) https://docs.npmjs.com/getting-started/installing-node
* `cd` into the scripts directory
* run `npm install` to download the dependencies. This will create a `node_modules` directory in `scripts` folder
 * Note that `node_modules` is gitignored
* After you update a template file, run `grunt` from inside the scripts folder to update templates.mustache.js
