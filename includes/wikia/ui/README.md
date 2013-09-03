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
        component01_config.json
        component01_doc.json
        css/
            component01_default.scss
            component01_[skin_name].scss
            component01_[skin_name].scss
            component01_[skin_name].scss
        js/
            component01_default.js
            component01_[skin_name].js
        templates/
            component01_type01.mustache
    component02/
        component02_config.json
        component02_doc.json
        css/
            component02_default.scss
        js/
            component02_default.js
        templates/
            component02_type01.mustache
            component02_type02.mustache
            component02_type03.mustache
</pre>

All core styles styles specific to skin will be stored in /skins/[skin_name]/. By these styles I mean things like css reset, colors and other core variables, typography etc. 
Instead of creating many small SCSS files for different parts of core styles I would like to put core styles into single file divided into sections. It will be easier to maintain and if we continue with creating different themes this could be a base template for each of them.
All skin independent styles (mixins, styles for corporate elements exp. hub colors) will be stored in /resources/wikia/styles/ 

## Rendering components on the PHP side
The \Wikia\UI\Factory class handles building component which means loading assets and component configuration file. It returns a new instance of the given component which is already configured and ready for rendering.

The \Wikia\UI\Component class handles all logic for rendering components: builds path to right template file, validates if all required template variables are set and finally calls `render()` method on template engine instance.

The following code is a basic example of the custom component JSON configuration file. It consist of component template variables and assets dependencies.

<pre>
{
  "templateVars": {
      "type01": {
          "name" : "styleguide-component-type01-description-message-key",
          "required": [ "href", "classes", "value" ],
          "optional": [ "label", "target" ]
      },
      "type02": {
          "name" : "styleguide-component-type02-description-message-key",
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
          'type' => 'link',
          'vars' => [
                    'href' => 'http://www.wikia.com',
                    'classes' => ['small'],
                    'value' => 'Just a button in form of a link',
                    'title' => 'Link which looks like a button!'
          ]
]
$button = \Wikia\UI\Factory::getInstance()->init( 'button' )->render( $params );
</pre>

In order to create multiple components (of the same type of different) in the same time following pattern will be used:
<pre>
$buttonParams = [
    "type" => "link",
    "vars" => [
        "href" => "http://www.wikia.com",
        "value" => "Wikia Home Page",
        "classes" => [ "button", "big" ],
    ]
];

$inputParams = [
    "type" => "text",
    "vars" => [
        "name" => "username",
        "value" => "joe",
        "classes" => [ "wide" ],
    ]
];

$list( $button, $input ) = \Wikia\UI\Factory::getInstance()->init( ['button', 'input'] );
$buttonMarkup = $button->render( $buttonParams );
$inputMarkup = $input->render( $inputParams );
</pre>

WARNING! Notice it IS NOT yet possible to call render() on results of \Wikia\UI\Factory::init() when an array passed as parameter. It causes a PHP Fatal error.

## Component's documentation on Special:Styleguide page
On Special:Styleguide page in "Component" section we're going to present all available components with UI and live preview.
In order to display your component on this page you have to create [component-name]_doc.json file which is similar to configuration file but more detailed. It contains three main elements:
* name -- which is a component name's message key in example: "styleguide-name-buttons",
* description -- which is a component's description message key in example: "styleguide-description-button",
* types -- different types of a component; keys of the elements here should be the same as keys of elements in `templateVars`

The `types` elements contain message keys for description of a component's type. They also provide information about each template variable: its name, type and message key for description.