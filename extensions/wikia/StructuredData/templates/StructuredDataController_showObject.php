<?php

	if (!$sdsObject) {
		die('Requested object doesn\'t exist!');
	}

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

	<h1><strong><?php echo $SDObject['name']; ?></strong></h1>
	<dl class="SDObjectDetails">
		<dt>Type:</dt>
		<dd><?php echo $SDObject['type']; ?></dd>
	</dl>
	
	<h3>Object properties:</h3>
	<dl class="SDObjectProperties">
	<?php foreach ( $SDObject['properties'] as $property ) : ?>
		
		<?php if (array_key_exists('missing', $property['type'])) : ?>
			<dt><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}', $property['label'])); ?>:</dt>
			<dd>
				<pre><?php print_r($property['value']) ?></pre>
			</dd>
			<?php continue; ?>
		<?php endif ?>
		
		<dt><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}', $property['label'])); ?>:</dt>
		<dd>
			<?php if (empty($property['value']) || $property['value'] == null) { echo '<span class="empty">empty</span>'; continue; } ?>
			
			<?php switch ($property['type']['name']) :
				case 'xsd:anyURI' : ?>
					<a href="<?php echo $wgServer . '/' . $property['value']; ?>" title="<?php echo $property['value']; ?>"><?php echo $property['value'] ?></a>
				<?php break; ?>
				<?php case '@set' ?>
					<ul>
						<?php foreach ($property['value'] as $reference) : ?>
							<?php if ($property['name'] == 'schema:photos') : ?>
								<?php if ($test->object == null) {continue;} ?>
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
					</ul>
				<?php break; ?>
				<?php case '@list' ?>
					<ol>
						<?php foreach ($property['value'] as $reference) : ?>
							<li>
								<pre><?php print_r($reference) ?></pre>
							</li>
						<?php endforeach ?>
					</ol>
				<?php break; ?>
				<?php default : ?>
					<?php echo $property['value']; ?>
				<?php break; ?>
			<?php endswitch; ?>
			
		</dd>
	<?php endforeach; ?>
	
	</dl>
</div>