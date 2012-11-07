<?php
$values = $object->getValues();
if (empty($values) || $values[0] == null) {
	/*
	 *  property is empty
	 */
	echo '<p class="empty">empty</p>';

} elseif ( (is_array($values) && count($values) == 1) || !is_string($values) ) {
	/*
	 *  if we have single property (not array) or one-element array
	 *  we should display it as pure string not as <li> element
	 */
	echo is_array($values) ? $values[0] : $values;

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
			echo $reference;
		}
		echo '</li>';
	}

	echo ($rendererName == '@list') ? '</ol>' : '</ul>';

}
?>