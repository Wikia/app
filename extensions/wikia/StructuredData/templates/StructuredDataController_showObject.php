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
			$proprtyHTML = $property->render();
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
			
			<?php switch ($propertyType['name']) :
				
				// ordered and unordered list template
				case '@set':
				case '@list': ?>
					<?php $listTag = ($propertyType['name'] == '@set') ? 'ul' : 'ol'; ?>
					<<?= $listTag?>>
						<?php foreach ($property->getValues() as $reference) : ?>
							
							<?php // Render list using renderers ?>
							<?php 
								$referenceHTML = false;
								if (!is_null($reference->object)) {
									$referenceHTML = $reference->object->render( SD_CONTEXT_SPECIAL );
								}
								if ($referenceHTML !== false) { 
									echo $referenceHTML; 
									continue;
								}	
							?>
							
							<?php // Render list manually if needed…? ?>
							<pre><?php print_r($reference) ?></pre>
								
						<?php endforeach ?>
					</<?= $listTag?>>
				<?php break; ?>
				
				
				<?php default : ?>
				
					<?php // Default template for simple properties like string, date, boolean ?>
					<?php echo $propertyValue; ?>
				<?php break; ?>
				
			<?php endswitch; ?>
			
		</dd>
	<?php endforeach; ?>	
	</dl>
</div>