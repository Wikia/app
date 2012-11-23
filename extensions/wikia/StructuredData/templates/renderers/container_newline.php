<?php
// list element (@set, @list) renderer
/* @var SDElementProperty $object */

$values = $object->getWrappedValue();
$listOfValues = array();

/* @var SDElementPropertyValue $propertyValue */
foreach($values as $propertyValue) {
	//@todo - use $propertyValue->render
	$value = $propertyValue->getValue();

	if (is_object($value) && (!is_null($value->object))) {
		$referenceHTML = $value->object->render( $context, array( 'fieldName' => $object->getName() . '[]' ) );
	}

	if ($referenceHTML !== false) {
		$listOfValues[] = $referenceHTML;
	}
	else {
		if(is_object($value) && !isset($value->object)) {
			$listOfValues[] = $value->id;
		}
		else {
			$listOfValues[] = $value;
		}
	}

}

echo implode( "<br />", $listOfValues );