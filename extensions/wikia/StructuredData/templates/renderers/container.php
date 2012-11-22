<?php
// list element (@set, @list) renderer
/* @var SDElementProperty $object */

$value = $object->getValue();

if ( !count( $value ) ) {

	if ($context != SD_CONTEXT_EDITING) {
		echo '<p class="empty">empty</p>';
	}
	if ($context == SD_CONTEXT_EDITING) {
		echo ($rendererName == '@list') ? '<ol data-field-name="'.$object->getName().'"></ol>' : '<ul data-field-name="'.$object->getName().'"></ul>';
		if( !$object->getType()->hasRange()) {
			echo '<div class="input-group"><input type="text" name="'. $object->getName() . '[]" value="" /></div>';
		}
	}

} else {

	if ( $context == SD_CONTEXT_DEFAULT && !empty( $params['list-type'] ) && in_array( $params['list-type'], array('coma', 'newline') ) ) {

	 	/*
	 	 * in-article context with <data>'s list-type property set as 'coma' or 'newline'
	 	 */
		echo $renderer->renderTemplate( 'container_'.$params['list-type'], 'container_'.$params['list-type'], $object, $context, $params );
	}
	else {

		/*
		 * any other context uses default container list ( ul/ol elements )
		 */
		if ( empty( $params['list-type'] ) ) {
			$params['list-type'] =  $rendererName == '@list' ? 'ordered' : 'unordered';
		}
		echo $renderer->renderTemplate( 'container_list', 'container_list', $object, $context, $params );
	}
}

if ( $context == SD_CONTEXT_EDITING ) {

	if ( $object->getType()->hasRange() ) {

		$types = $object->getType()->getAcceptedValues();
		if (count($types['classes']) == 1 && in_array('rdfs:Literal', $types['classes'])) {
			echo '<button class="add-input" data-range="' . join('', $types['classes']) . '">Add new</button>';
		} else {
			echo '<button class="load-dropdown" data-range="' . join(' ', $types['classes']) . '">Add</button>';
		}
		//var_dump($object->getType()->getAcceptedValues());
	}
	else {
		//echo '<input type="text" value="" name="'.$object->getName().'" />';
		//echo " (object of type: " . $object->getType()->getName() . " has no range)";
	}
}
