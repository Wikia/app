<?php

	if (!$sdsObject) {
		die('Requested object doesn\'t exist!');
	}

	// Array of SD object properties 
	$properties = $sdsObject->getProperties();
?>

<form class="WikiaForm SDObject" id="SDObject">
	<h1><strong><?php echo $sdsObject->getName(); ?></strong></h1>
	<?php if($context == SD_CONTEXT_SPECIAL): ?>
		<a href="?action=edit" class="wikia-button" title="Edit SDS Object">Edit</a>
	<?php endif; ?>
	<dl class="SDObjectDetails">
		<dt>Type:</dt>
		<dd><?php echo $sdsObject->getType(); ?></dd>
	</dl>
	
	<table class="article-table SDObjectProperties WikiaGrid">
		<caption>Object properties:</caption>
		<thead>
			<tr>
				<th class="grid-1">Property label:</th>
				<?php if($context == SD_CONTEXT_EDITING): ?>
					<th class="grid-5">Property value:</th>
				<?php else : ?>
					<th class="grid-3">Property value:</th>
					<th class="grid-2">Wiki text sample:</th>
				<?php endif; ?>
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
						<?php if($context == SD_CONTEXT_SPECIAL): ?>
							<td><pre><?php echo $propertyName; ?></pre></td>
						<?php endif; ?>
					</tr>
					<?php continue; ?>
				<?php endif; ?>
				
				
				<?php // Render properties manually ?>
				<tr>
					<th><?php echo ucfirst(preg_replace('/([A-Z])/', ' ${1}', $propertyLabel)); ?>:</th>
				
					<?php // display 'empty' for empty object properties ?>
					<?php if (empty($propertyValue)) : ?>
						<td><p class="empty">empty</p></td>
						<?php if($context == SD_CONTEXT_SPECIAL): ?>
							<td><pre><?php echo $propertyName; ?></pre></td>
						<?php endif; ?>
				</tr>
						<?php continue; ?>
					<? endif ?>
		
					<td><p><?php echo $propertyValue; ?></p></td>
					<?php if($context == SD_CONTEXT_SPECIAL): ?>
						<td><pre><?php echo $propertyName; ?></pre></td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</form>