# General idea behind reusable UI
Darwin initiative put strong focus on maximizing UI consistency across Wikia. On the engineering level I would like to achieve this by creating repository of UI components that will be used to build user interfaces for product development.
BenefitsEdit:
* one code pattern for each components reused across wikia,
* separation of logic from view (components consist only of templates, css, js for interaction),
* easier code maintenance,
* each component documented in Wikia Style Guide.

## Reusable UI components repository folder structure
Components are stored in /resources/wikia/ui_components/ with following folder structure:

<pre>
ui_components/
    component01/
        component01_config.JSON
        component01_example.JSON
        css/
            component01_default.scss
            component01_[skin_name].scss
            component01_[skin_name].scss
            component01_[skin_name].scss
        js/
            component01_default.js
            component01_[skin_name].js
        templates/
            component01_default.mustache
            component01_type01.mustache
    component02/
        component02_config.JSON
        component02_example.JSON
        css/
            component02_default.scss
        js/
            component02_default.js
        templates/
            component02_default.mustache
            component02_type01.mustache
            component02_type02.mustache
            component02_type03.mustache
</pre>

All core styles styles specific to skin will be stored in /skins/[skin_name]/. By these styles I mean things like css reset, colors and other core variables, typography etc. 
Instead of creating many small SCSS files for different parts of core styles I would like to put core styles into single file divided into sections. It will be easier to maintain and if we continue with creating different themes this could be a base template for each of them.
All skin independent styles (mixins, styles for corporate elements exp. hub colors) will be stored in /resources/wikia/styles/ 

## Rendering components on the PHP side
The \Wikia\UI\Factory class handles building component which means loading assets and component configuration file. It returns a new instance of the given component which is already configured and ready for rendering.

The \Wikia\UI\Component class handles all logic for rendering components.

The following code is a basic example of the custom component JSON configuration file. It consist of component template variables and assets dependencies. This configuration files will also be used to automatically create documentation for each component in Wikia Styleguide (/Special:Styleguide).

<pre>
{
  "name-msg-key": "styleguide-component-name-message-key",
  "description-msg-key": "stylegiude-component-description-message-key",
  "templateVars": {
      "type01": {
          "name-var-msg-key" : "styleguide-component-type01-description-message-key",
          "required": [ "href", "classes", "value" ],
          "optional": [ "label", "target" ]
      },
      "type02": {
          "name-var-msg-key" : "styleguide-component-type02-description-message-key",
      "required": [ "name", "classes", "value" ],
      "optional": [ "label" ]
      }
  },
  dependencies: {
      js: [], // AM/RL packages / paths to files
      css: [] // AM/RL packages / paths to files
  } 
}
</pre>

The following code shows how to render a button in form of an anchor (type=link):
<pre>
$params = [
    "type" => "link",
    "vars" => [
        "href" => "http://www.wikia.com",
        "value" => "Wikia Home Page",
        "classes" => [ "button", "big" ],
    ]
];
$button = \Wikia\UI\Factory::getInstance()->init('button')->render($params);
</pre>
In order to create multiple components (of the same type of different) in the same time following pattern will be used:
<pre>
$aParams = [
    "type" => "link",
    "vars" => [
        "href" => "http://www.wikia.com",
        "value" => "Wikia Home Page",
        "classes" => [ "button", "big" ],
    ]
];

$bParams = [
    "type" => "input",
    "vars" => [
        "name" => "wikia-home-page-button",
        "value" => "Wikia Home Page",
        "classes" => [ "button" ],
    ]
];

$list($a, $b) = \Wikia\UI\Factory::getInstance()->init( ['button', 'button'] );
$aMarkup = $a->render($aParams);
$bMarkup = $b->render($bParams);
</pre>

WARNING! Notice it IS NOT yet possible to call render() on results of \Wikia\UI\Factory::init() when an array passed as parameter. It causes a PHP Fatal error.
