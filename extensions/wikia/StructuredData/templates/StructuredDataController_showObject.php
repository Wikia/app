<?php

	if (!$sdsObject) {
		die('Requested object doesn\'t exist!');
	}

	// Array of SD object properties 
	$properties = $sdsObject->getProperties(); 
	
	//varDump($properties);
	
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
	//aasort($SDObject['properties'], "label");
	
?>

<div class="SDObject" id="SDObject">

	<h1><strong><?php echo $sdsObject->getName(); ?></strong></h1>
	<dl class="SDObjectDetails">
		<dt>Type:</dt>
		<dd><?php echo $sdsObject->getType(); ?></dd>
	</dl>
	
	<h3>Object properties:</h3>
	<dl class="SDObjectProperties">
	<?php foreach ( $properties as $property ) : ?>
		
		<?php 
			$propertyType = $property->getType();
			$propertyValue = $property->getValue();
			$propertyLabel = $property->getLabel();
			$propertyName = $property->getName();
			$proprtyHTML = $property->render();
			
			if($proprtyHTML !== false) { echo $proprtyHTML; continue; }
		?>
		<?php if (array_key_exists('missing', $propertyType)) : ?>
			<dt><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}',$propertyLabel)); ?>:</dt>
			<dd>
				<pre><?php print_r($propertyValue) ?></pre>
			</dd>
			<?php continue; ?>
		<?php endif ?>
		
		<dt><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}', $propertyLabel)); ?>:</dt>
		<dd>
			<?php if (empty($propertyValue)) : ?>
				<span class="empty">empty</span> 
				<?php continue; ?>
			<? endif ?>
			<?php switch ($propertyType['name']) :
				case 'xsd:anyURI' : ?>
					<a href="<?php echo $wgServer . '/' . $propertyValue; ?>" title="<?php echo $propertyValue; ?>"><?php echo $propertyValue; ?></a>
				<?php break; ?>
				<?php case '@set' ?>
				<?php case '@list' ?>
					<?php $listTag = ($propertyType['name'] == '@set') ? 'ul' : 'ol'; ?>
					<<?= $listTag?>>
						<?php foreach ($propertyValue as $reference) : ?>
							<?php 
								$referenceHTML = false;
								if (!is_null($reference->object)) {
									$referenceHTML = $reference->object->render();
								}
								if ($referenceHTML !== false) { echo $referenceHTML; continue; }
							?>
							<?php if ($propertyName == 'schema:photos') : ?>
								<li>	
									<figure>
										<img src="<?php echo $reference->object['properties'][6]['value']; ?>" alt="<?php echo $test->object['name']; ?>" />
										<figcaption><?php echo $reference->object['name']; ?></figcaption>
									</figure>
									<a href="<?php echo $test->object['url'] ?>" title="<?php echo $reference->object['name']; ?>"><?php echo $reference->object['url'] ?></a>
								</li>
							<?php else : ?>
								<li>
									<pre><?php print_r($reference) ?></pre>	
								
								</li>
							<?php endif; ?>
						<?php endforeach ?>
					</<?= $listTag?>>
				<?php break; ?>
				<?php default : ?>
					<?php echo $propertyValue; ?>
				<?php break; ?>
			<?php endswitch; ?>
			
		</dd>
	<?php endforeach; ?>
	
	</dl>
</div>