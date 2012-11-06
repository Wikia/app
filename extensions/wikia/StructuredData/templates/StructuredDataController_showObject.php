<?php

	if (!$sdsObject) {
		die('Requested object doesn\'t exist!');
	}

	// Array of SD object properties 
	$properties = $sdsObject->getProperties(); 
	
?>

<div class="SDObject" id="SDObject">
	<h1><strong><?php echo $sdsObject->getName(); ?></strong></h1>
	<dl class="SDObjectDetails">
		<dt>Type:</dt>
		<dd><?php echo $sdsObject->getType(); ?></dd>
	</dl>
	
	<table class="article-table SDObjectProperties WikiaGrid">
		<caption>Object properties:</caption>
		<thead>
			<tr>
				<th class="grid-1">Property label:</th>
				<th class="grid-3">Property value:</th>
				<th class="grid-2">Wiki text sample:</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $properties as $property ) : ?>
				<?php 
					$propertyType = $property->getType();
					$propertyValue = $property->getValue();
					$propertyLabel = $property->getLabel();
					$propertyName = $property->getName();
					$proprtyHTML = $property->render( $context );
				?>
				
				
				<?php // Render HTML using renderers  ?>
				
				<?php if($proprtyHTML !== false) : ?>
					<tr>
						<th><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}',$propertyLabel)); ?>:</th>
						<td><?php echo $proprtyHTML;?></td>
						<td><pre><?php echo $propertyName; ?></pre></td>
					</tr>
					<?php continue; ?>
				<?php endif; ?>
				
				
				<?php // Render properties manually ?>
				<tr>
					<th><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}', $propertyLabel)); ?>:</th>
				
					<?php // display 'empty' for empty object properties ?>
					<?php if (empty($propertyValue)) : ?>
						<td><p class="empty">empty</p></td>
				
						<td><pre><?php echo $propertyName; ?></pre></td>
				</tr>
						<?php continue; ?>
					<? endif ?>
		
					<td><p><?php echo $propertyValue; ?></p></td>
					<td><pre><?php echo $propertyName; ?></pre></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>