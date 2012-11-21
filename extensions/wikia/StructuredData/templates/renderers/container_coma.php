<?php
// list element (@set, @list) renderer
/* @var SDElementProperty $object */

$value = $object->getValue(true);
$listOfValues = array();

foreach($value as $reference) {

	if (is_object($reference) && (!is_null($reference->object))) {
		$referenceHTML = $reference->object->render( $context, array( 'fieldName' => $object->getName() . '[]' ) );
	}
	if ($referenceHTML !== false) {
		$listOfValues[] = $referenceHTML;
	}
	else {
		if(is_object($reference) && !isset($reference->object)) {
			$listOfValues[] = $reference->id;
		}
		else {
			$listOfValues[] = $reference;
		}
	}
}

echo implode( ", ", $listOfValues );