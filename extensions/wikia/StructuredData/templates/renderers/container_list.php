<?php
// list element (@set, @list) renderer
/* @var SDElementProperty $object */

$value = $object->getValue(true);

$renderList = ( count( $value ) > 1 || $context == SD_CONTEXT_EDITING) ? true : false;

if ( $renderList ) {

	$listType = ( !empty($params['list-type']) && $params['list-type']=="ordered" ) ? 'ordered' : 'unordered';

	echo ( $listType=='ordered') ? '<ol data-field-name="'.$object->getName().'">' :
					'<ul data-field-name="'.$object->getName().'">' ;
}

foreach( $value as $reference ) {

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
					echo '<div class="input-group"><input type="text" name="'. $object->getName() . '[]" value="'. $reference . '" /> <button class="secondary remove">Remove</button></div>';
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

if ( $renderList ) {
	echo ( $listType=='ordered' ) ? '</ol>' : '</ul>';
}