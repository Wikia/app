# html5-skin
An open-source HTML5 UI skin based on [React.js](https://github.com/facebook/react) that overlays Ooyala V4 core player. This README contains introduction, setup and customization sections.

# Wikia changes
* added new gulp task `gulp build:all` which build `all.js` files with ooyala core.js and
main_html5.js and `all-with-youtube.js` which contains youtube plugin.
* added support for svg icons
* some of imports that we don't use are commented out in `html5-skin.scss` to make styles file smaller
* we currently use v.4.10.6 of Ooyala Player
* custom ad screen with player controls

## High Level Overview
`html5-skin` is a JS file that is made available externally to Ooyala core V4 player. It accepts and triggers general Ooyala Message Bus events from and to core player to change the behavior of video playback. All static files necessary to create and run video playback are hosted and can be accessed publicly. This skin repo are available to be git cloned or forked and be modified by developers (terms and condition apply).

### Plug and Play capability
`core.js` is a lightweight core player that enables basic video playback functionality and provides Message Bus environment. Most of additional capabilities such as ads, discovery and skin are separated from core player JS. You may want to load additional plugins.

## Examples
We have a sample HTML page ready for you. Check out [sample page](http://debug.ooyala.com/ea/index.html?ec=RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2&pbid=26e2e3c1049c4e70ae08a242638b5c40&pcode=5zb2wxOlZcNCe_HVT3a6cawW298X&core_player=http%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fcore.min.js&video_plugins=http%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fvideo-plugin%2Fmain_html5.min.js%0Ahttp%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fvideo-plugin%2Fosmf_flash.min.js%0Ahttp%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fvideo-plugin%2Fbit_wrapper.min.js&html5_skin=http%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fskin-plugin%2Fhtml5-skin.min.js&skin_asset=http%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fskin-plugin%2Fhtml5-skin.min.css&skin_config=http%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fskin-plugin%2Fskin.json&ad_plugin=http%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fad-plugin%2Ffreewheel.min.js&additional_plugins=http%3A%2F%2Fplayer.ooyala.com%2Fstatic%2Fv4%2Fstable%2F4.10.6%2Fother-plugin%2Fdiscovery_api.min.js&options=%7B%22freewheel-ads-manager%22%3A%7B%22fw_video_asset_id%22%3A%22NqcGg4bzoOmMiV35ZttQDtBX1oNQBnT-%22%2C%22html5_ad_server%22%3A%22http%3A%2F%2Fg1.v.fwmrm.net%22%2C%22fw_android_ad_server%22%3A%22http%3A%2F%2Fg1.v.fwmrm.net%2F%22%2C%22html5_player_profile%22%3A%2290750%3Aooyala_html5%22%2C%22fw_android_player_profile%22%3A%2290750%3Aooyala_android%22%2C%22fw_mrm_network_id%22%3A%22380912%22%7D%7D)

This simple test HTML page can also be hosted on your environment to showcase html5 skin.
```html
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <!-- V4 JS core and at least one video plugin is required. Plugins such as skin, discovery and Advertising need to be loaded separately -->
  <script src="//player.ooyala.com/static/v4/stable/4.10.6/core.min.js"></script>
  <script src="//player.ooyala.com/static/v4/stable/4.10.6/video-plugin/main_html5.min.js"></script>
  <script src="//player.ooyala.com/static/v4/stable/4.10.6/video-plugin/osmf_flash.min.js"></script>
  <script src="//player.ooyala.com/static/v4/stable/4.10.6/video-plugin/bit_wrapper.min.js"></script>
  <!-- Change these html5-skin.min.css and html5-skin.min.js to your local build if necessary -->
  <script src="//player.ooyala.com/static/v4/stable/4.10.6/skin-plugin/html5-skin.min.js"></script>
  <link rel="stylesheet" href="//player.ooyala.com/static/v4/stable/4.10.6/skin-plugin/html5-skin.min.css"/>
</head>

<body>
<div id='container'></div>
<script>
  var playerParam = {
    "pcode": "YOUR_PCODE",
    "playerBrandingId": "YOUR_PLAYER_ID",
    "debug":true,
    "skin": {
      // config contains the configuration setting for player skin. Change to your local config when necessary.
      "config": ""
    }
  };

  OO.ready(function() {
    window.pp = OO.Player.create('container', 'RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2', playerParam);
  });
</script>

</body>
</html>
```

## Developer Setup
1. [Install git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)

2. [Install Node.js] (https://nodejs.org/download/release/v0.10.33/) v0.10.33

3. Install [gulp](http://gulpjs.com) globally by running: `npm install --global gulp-cli`

4. Clone project: `git clone https://github.com/ooyala/html5-skin.git`

5. After cloning, just `cd` in there, install dependencies by running `npm install`

6. This project also makes use of *git submodule* for the config directory. This needs to be initialized
using *git submodule* commands:
   ```sh
       git submodule init
       git submodule update
       git pull
   ```
   The *init* and *update* should only need to be run once, afterward *git pull* will update the submodule as well as the parent repo.

7. Build the project by running: `gulp`

   This will perform an initial build and start a watch that will update the `build/` folder with any changes made in `js/` or `scss/` folders.

   Once the app is built a webserver will start and serve `sample.html` in your browser [http://0.0.0.0:4444/](http://0.0.0.0:4444/).

## Style
We use [Sass](http://sass-lang.com/) (SCSS) for CSS preprocessor.

Our [4-1 architecture pattern](http://sass-guidelin.es/#the-7-1-pattern) splits the Sass codebase over several files that are compiled into a single, minified stylesheet deployed to production.

This approach maintains modular, decoupled style without impacting performance.

```
scss/
|
|– base/
|   |– _normalize.scss   # makes browsers render elements more consistently
|   |– _reset.scss       # resets to common HTML elements, Adds additional rules on top of _normalize.scss
|   |– _variables.scss   # variables, colors, measurements, flags to enable/disable features
|   |– _base.scss        # boilerplate, app level styles
|   |– _type.scss        # typography rules, fonts, icons
|   ...
|
|– components/           # style to correspond to app views and components
|   |– _buttons.scss
|   |– _forms.scss
|   |– _[screen].scss
|   |– _[component].scss
|   ...
|
|– mixins/               # Sass tools and helpers used across project
|   |– _mixins.scss      # groups of reusable CSS functions
|   ...
|
|– skins/
|   |– _default.scss     # default skin, values pulled from /skin-plugin/config/skin.json
|   |– _alien.scss       # :alien: skin
|   ...
|
|
`– html5-skin.scss       # main Sass file
```

## Testing
To run tests, run this command:

    npm test

Add test files to directory `tests/`.

Test file should have same location and name as `js/` file with `-test` after test file name.

For example, component file `js/components/sharePanel.js` will have test file `tests/components/sharePanel-test.js`.

## Customization

### Relative Paths
Note that some necessary files are located with relative paths. Please verify that those files are properly placed in your web application. This includes:
- localization files
- asset files

### Simple Customization
Simple customization can be achieved by modifying `skin.json` settings. Furthermore, you are able to override skin setting during player create time. The example below hides description text and render playButton blue on start screen.

```javascript
var playerParam = {
  "skin": {
    "config": "//player.ooyala.com/static/v4/stable/4.10.6/skin-plugin/skin.json",
    "inline": {
      "startScreen": {"showDescription": false, "playIconStyle": {"color": "blue"}}
    }
  }
};
```

### Advanced Customization
Advanced customization is readily available by modifying JS files. Follow [Developer Setup](#developer-setup) section to create a local repository and to run build script. Built files are available inside build folder. You are welcomed to host your built skin javascript to be run with your player.
