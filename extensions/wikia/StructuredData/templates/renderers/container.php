<?php
// list element (@set, @list) renderer
/* @var SDElementProperty $object */
$value = $object->getValue();
if ( !$object->isCollection() ) { // @todo - again we assume that collection can only contain references - this won't be always true
	/*
	 *  if we have single property (not array) or one-element array
	 *  we should display it as pure string not as <li> element
	 */
	echo $object->getValueObject()->render( $context );
} else {
	/*
	 * property is an array
	 */
	if ( !count( $value ) ) {
		if ($context != SD_CONTEXT_EDITING) {
			echo '<p class="empty">empty</p>';
		}
		if ($context == SD_CONTEXT_EDITING) {
			echo ($rendererName == '@list') ? '<ol data-field-name="'.$object->getName().'"></ol>' : '<ul data-field-name="'.$object->getName().'"></ul>';
		}
	} else {
		$renderList = ( count( $value ) > 1 || $context == SD_CONTEXT_EDITING) ? true : false;
		if ( $renderList ) echo ($rendererName == '@list') ? '<ol data-field-name="'.$object->getName().'">' : '<ul data-field-name="'.$object->getName().'">';
		foreach($value as $reference) {
			if ( $renderList ) echo '<li>';
			$referenceHTML = false;
			if (is_object($reference) && (!is_null($reference->object))) {
				$referenceHTML = $reference->object->render( $context, array( 'fieldName' => $object->getName() . '[]' ) );
			}
			if ($referenceHTML !== false) {
				echo $referenceHTML;
			}
			else {
				if(is_object($reference) && !isset($reference->object)) {
					echo '<p class="empty">' . $reference->id . '</p>';
				}
				else {
					echo $reference;
				}
			}
			if ( $renderList ) echo '</li>';
		}

		if ( $renderList ) echo ($rendererName == '@list') ? '</ol>' : '</ul>';
	}

	if ($context == SD_CONTEXT_EDITING) {
		if($object->getType()->hasRange()) {
			$types = $object->getType()->getAcceptedValues();
			if (array_key_exists('enum', $types)) {
				echo '<select>';
				echo '<option>choose...</option>';
				foreach ($types['enum'] as $value) {
					echo '<option value="' . $value . '">' . $value . '</option>';
				}
				echo '</select>';
			} else {
				echo '<button class="load-dropdown" data-range="' . join(' ', $types['classes']) .
					'">Add</button>';
			}
			//var_dump($object->getType()->getAcceptedValues());
		}
		else {
			echo " (object of type: " . $object->getType()->getName() . " has no range)";
		}
	}

}
