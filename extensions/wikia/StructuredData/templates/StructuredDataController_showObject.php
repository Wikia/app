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
	
	<h3>Object properties:</h3>
	<dl class="SDObjectProperties">
	
	<?php foreach ( $properties as $property ) : ?>
		
		<?php 
			$propertyType = $property->getType();
			$propertyValue = $property->getValue();
			$propertyLabel = $property->getLabel();
			$propertyName = $property->getName();
			$proprtyHTML = $property->render( SD_CONTEXT_SPECIAL );
		?>
		
		<?php // Render HTML using renderers  ?>
		
		<?php if($proprtyHTML !== false) : ?>
			<dt><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}',$propertyLabel)); ?>:</dt>
			<dd>
				<?php echo $proprtyHTML;?>
			</dd>
			<?php continue; ?>
		<?php endif; ?>
		
		
		<?php // CharacterIn problematic property hack!!!! ?>
		
		<?php if (array_key_exists('missing', $propertyType)) : ?>
			<dt><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}',$propertyLabel)); ?>:</dt>
			<dd>
				<pre><?php print_r($propertyValue) ?></pre>
			</dd>
			<?php continue; ?>
		<?php endif ?>
		
		
		<?php // Render properties manually ?>
		
		<dt><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}', $propertyLabel)); ?>:</dt>
		<dd>
		
			<?php // display 'empty' for empty object properties ?>
			<?php if (empty($propertyValue)) : ?>
				<span class="empty">empty</span> 
				<?php continue; ?>
			<? endif ?>

			<?php echo $propertyValue; ?>

		</dd>
	<?php endforeach; ?>	
	</dl>
</div>