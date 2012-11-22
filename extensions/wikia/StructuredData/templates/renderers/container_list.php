<?php
// list element (@set, @list) renderer
/* @var SDElementProperty $object */

$values = $object->getValue();

$renderList = ( count( $values ) > 1 || $context == SD_CONTEXT_EDITING) ? true : false;

if ( $renderList ) {

	$listType = ( !empty($params['list-type']) && $params['list-type']=="ordered" ) ? 'ordered' : 'unordered';

	echo ( $listType=='ordered') ? '<ol data-field-name="'.$object->getName().'">' :
					'<ul data-field-name="'.$object->getName().'">' ;
}

foreach( $values as $propertyValue ) {

	if ( $renderList ) echo '<li>';
	$propertyHTML = $propertyValue->render( $context, array( 'fieldName' => $object->getName() . '[]' ) );
	if ($propertyHTML !== false) {
		echo $propertyHTML;
	}
	else {
		$value = $propertyValue->getValue();
		if(is_object($value) && !isset($value->object)) {
			echo '<p class="empty">' . $value->id . '</p>';
		}
		else {
			if ($context == SD_CONTEXT_EDITING) {
				if($object->getType()->hasRange()) {
					echo '<div class="input-group"><input type="text" name="'. $object->getName() . '[]" value="'. $value . '" /> <button class="secondary remove">Remove</button></div>';
				} else {
					echo '<div class="input-group"><input type="text" name="'. $object->getName() . '[]" value="'. $value . '" /></div>';
				}

			}  else {
				echo $value;
			}
		}
	}
	if ( $renderList ) echo '</li>';
}

if ( $renderList ) {
	echo ( $listType=='ordered' ) ? '</ol>' : '</ul>';
}