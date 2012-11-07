<?php
$value = $object->getValue();
$values = $object->getValues();
if ( $object->hasNoValue() ) {
	/*
	 *  property is empty
	 */
	echo '<p class="empty">empty</p>';

} elseif ( !is_object($value) ) {
	/*
	 *  if we have single property (not array) or one-element array
	 *  we should display it as pure string not as <li> element
	 */
	echo $value;
} else {
	/*
	 * property is an array
	 */
	echo ($rendererName == '@list') ? '<ol>' : '<ul>';
	foreach($values as $reference) {
		echo '<li>';
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
		echo '</li>';
	}

	echo ($rendererName == '@list') ? '</ol>' : '</ul>';

}
