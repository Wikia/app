<?php
// list element (@set, @list) renderer
/* @var SDElementProperty $object */

$values = $object->getWrappedValue();
$listOfValues = array();

/* @var SDElementPropertyValue $propertyValue */
foreach($values as $propertyValue) {
	$referenceHTML = $propertyValue->render( $context, array( 'fieldName' => $object->getName() . '[]' ) );
	if ($referenceHTML !== false) {
		$listOfValues[] = $referenceHTML;
	}
	else {
		$listOfValues[] = wfMsg('structureddata-container-render-failed');
	}
}

echo implode( ", ", $listOfValues );