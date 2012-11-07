<?php
$value = $object->getValue();
$values = $object->getValues();
if ( !is_object($value) ) {
	/*
	 *  if we have single property (not array) or one-element array
	 *  we should display it as pure string not as <li> element
	 */
	echo $object->getValueObject()->render( $context );
} else {
	/*
	 * property is an array
	 */
	$renderList = ( is_array( $values ) && count( $values ) > 1 ) ? true : false;

	if ( $renderList ) echo ($rendererName == '@list') ? '<ol>' : '<ul>';
	foreach($values as $reference) {
		if ( $renderList ) echo '<li>';
		$referenceHTML = false;
		if (is_object($reference) && (!is_null($reference->object))) {
			$referenceHTML = $reference->object->render( $context );
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
