<?php
$messages['en'] = [
	// main component name and description
	'styleguide-name-modal' => 'Modal',
	'styleguide-description-modal' => 'Style guide component for modal',

	// parameters' documentation messages
	'styleguide-description-modal-id' => 'String, unique ide of the modal element',
	'styleguide-description-modal-size' => 'Size/type of a modal; one of three options',
	'styleguide-description-modal-content' => 'Modal content; it can be a HTML markup',
	'styleguide-description-modal-classes' => 'An array of strings; each string is a class name passed to class attribute of modal container',
	'styleguide-description-modal-title' => 'Title visible on the top of modal',
	'styleguide-description-modal-close-button' => "If set to true then a close button will be displayed in the modal's header otherwise it won't be rendered; by default it's set to true",
	'styleguide-description-modal-alt-link' => "OPTIONAL alternative link data in a modal's footer",
	'styleguide-description-modal-secondary-button' => "OPTIONAL secondary button in a modal's footer; result of UIComponent->render() method (HTML markup)",
	'styleguide-description-modal-primary-button' => "OPTIONAL primary button in a modal's footer; result of UIComponent->render() method (HTML markup)",

	// examples
	'styleguide-example-modal-small-description' => "A small modal height is flexible but no higher than 90% of view port and it has fixed width (400px). It should be use for rendering... As all modals please remember the title will have only one line.",
	'styleguide-example-modal-medium-description' => "A medium modal height is flexible but no higher than 90% of view port it's width is fixed but depends on screen size (500 or 700px). It should be use for rendering... As all modals please remember the title will have only one line.",
	'styleguide-example-modal-large-description' => "A large modal covers almost all view port. It should be use for rendering... As all modals please remember the title will have only one line.",
	'styleguide-example-modal-small-over-large-title' => "Small modal",
	'styleguide-example-modal-small-over-large-message' => "Small modal over large one example",
];
