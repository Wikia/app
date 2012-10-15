<?php

	// Array of SD object properties 
	$SDObject = $sdsObject->toArray(); 
	
	
	// Alphabetically sort object properties labels
	function aasort(&$array, $key) {
		
		$sorter = array();
		$sortingResult = array();
		reset($array);
		
		foreach ($array as $index => $value) {
			$sorter[$index] = $value[$key];	
		}
		asort($sorter);
		
		foreach ($sorter as $index => $value) {
			$sortingResult[$index] = $array[$index];
		}
		$array = $sortingResult;
	
	}
	aasort($SDObject['properties'], "label");
	
?>

<div class="SDObject" id="SDObject">
	<h1><?php echo $SDObject['id']; ?></h1>
	<dl class="SDObjectDetails">
		<dt>Type:</dt>
		<dd><?php echo $SDObject['type']; ?></dd>
	</dl>
	<h3>Object properties:</h3>
	<dl class="SDObjectProperties">
	<?php foreach ( $SDObject['properties'] as $property ) : ?>
		<?php if (empty($property['value']) || $property['value'] == null) { continue; } ?>
		<dt><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}', $property['label'])); ?>:</dt>
		<dd>
			<?php switch ($property['type']) :
				case 'xsd:anyURI' : ?>
					<a href="<?php echo $property['value']; ?>" title="<?php echo $property['value']; ?>"><?php echo $property['value'] ?></a>
				<?php break; ?>
				<?php default : ?>
					<?php echo $property['value']; ?>
				<?php break; ?>
			<?php endswitch; ?>
		</dd>
	<?php endforeach; ?>
	</dl>
</div>