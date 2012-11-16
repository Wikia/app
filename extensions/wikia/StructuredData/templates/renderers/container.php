<?php
// list element (@set, @list) renderer
/* @var SDElementProperty $object */
$value = $object->getValue(true);
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
				if ($context == SD_CONTEXT_EDITING) {
					if($object->getType()->hasRange()) {
						echo '<div class="input-group"> !!!<input type="text" name="'. $object->getName() . '[]" value="'. $reference . '" /> <button class="secondary remove">Remove</button></div>';
					} else {
						echo '<div class="input-group"><input type="text" name="'. $object->getName() . '[]" value="'. $reference . '" /></div>';
					}

				}  else {
					echo $reference;
				}
			}
		}
		if ( $renderList ) echo '</li>';
	}

	if ( $renderList ) echo ($rendererName == '@list') ? '</ol>' : '</ul>';
}

if ($context == SD_CONTEXT_EDITING) {
	if($object->getType()->hasRange()) {
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
