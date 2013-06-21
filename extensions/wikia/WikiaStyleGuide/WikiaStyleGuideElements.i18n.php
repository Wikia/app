<?php
/**
* Internationalization file for the WikiaStyleGuide extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'wikiastyleguide-dropdown-all' => 'All',
	'wikiastyleguide-dropdown-select-all' => 'Select All',
	'wikiastyleguide-dropdown-selected-items-list' => '$1 and $2 more',
	
	'wikiastyleguide-tooltip-icon-question-mark' => '?',
);

$messages['qqq'] = array(
	'wikiastyleguide-dropdown-all' => 'This is for a custom multiple choice dropdown (essentially a more powerful and more easily styled <select> element). Text shown when all items are selected.',
	'wikiastyleguide-dropdown-select-all' => 'Shown next to checkbox in toolbar. Used for selecting all other checkboxes.',
	'wikiastyleguide-dropdown-selected-items-list' => 'This text shown in the the dropdown when not all items selected can be dispalyed. $1 is the number of elements displayed, $2 is the number of elements not displayed.

This is for a custom multiple choice dropdown (essentially a more powerful and more easily styled <select> element).',
	'wikiastyleguide-tooltip-icon-question-mark' => 'An icon indicating a tooltip. When you hover over it a tooltip is shown. Translate this message only if the symbol commonly used to convey "help" in your language is different than a question mark (?).',
);
