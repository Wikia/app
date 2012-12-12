<?php
	if (!$sdsObject) {
		die(wfMsg('structureddata-object-doesnt-exist'));
	}

	// Array of SD object properties 
	$properties = $sdsObject->getProperties();
	$objectName = $sdsObject->getName();
	$objectId = $sdsObject->getId();
?>
<form class="WikiaForm SDObject" id="SDObject" method="POST">
	<?php if(!empty($updateResult)): ?>
		<div class="validation-main-message <?= (empty($updateResult->error)) ? 'success' : '' ?>">
			<?=$updateResult->message;?>
		<?php if(isset($updateResult->errors)): ?>
			<?php foreach ( $updateResult->errors as $errKey => $errVal ) { ?>
			<ul class="error-list">
			    <li><strong><?=$errKey?>:</strong><br /> <?php echo implode("<br />", $errVal); ?> </li>
			</ul>
			<?php } ?>
		<?php endif; ?>
                </div>
	<?php endif; ?>
	<h1><strong><?= $objectName; ?></strong></h1>
	<?php if($context == SD_CONTEXT_SPECIAL && $isEditAllowed): ?>
		<?php
			echo F::app()->renderView('MenuButton', 'Index', array(
				'action' => $menuButtonAction,
				'name' => $menuButtonName,
				'dropdown' => $dropDownItems,
				'image' => $menuButtonImage
			));
		?>
	<?php endif; ?>
	<dl class="SDObjectDetails">
		<dt><?= wfMsg('structureddata-object-type-label') ?>:</dt>
		<dd><a href="<?= SpecialPage::getTitleFor('StructuredData')->getLocalURL();
		?>?method=getCollection&objectType=<?=
		$sdsObject->getType(); ?>" title="<?=
		$sdsObject->getType
		(); ?>"><?= $sdsObject->getType
		(); ?></a></dd>
	</dl>
	<?/*<pre>ID: <?=$sdsObject->getId();?></pre>*/?>

	<table class="article-table SDObjectProperties WikiaGrid" data-object-type="<?=$sdsObject->getType()?>">
		<caption><?= wfMsg('structureddata-object-properties-table-caption') ?>:</caption>
		<thead>
			<tr>
				<th class="grid-1"><?= wfMsg('structureddata-object-table-th-prop-label') ?>:</th>
				<?php if($context == SD_CONTEXT_EDITING): ?>
					<th class="grid-5"><?= wfMsg('structureddata-object-table-th-prop-value') ?>:</th>
				<?php else : ?>
					<th class="grid-3"><?= wfMsg('structureddata-object-table-th-prop-value') ?>:</th>
					<th class="grid-2"><?= wfMsg('structureddata-object-table-th-wiki-text') ?>:</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $properties as $property ) : ?>
				<?php
					if ( !$sdsObject->isPropertyVisible( $property ) ) {
						continue;
					}
					$propertyLabel = $property->getLabel();
					$propertyName = $property->getName();
					$propertyHTML = $property->render( $context, array( 'objectId' => $objectId ) );
					$validationError = (isset($updateResult->errors) && array_key_exists($propertyName,
						$updateResult->errors)) ? true : false;
				    if (!empty($validationError)) {
					    $validationErrorMsg = $error = $updateResult->errors->{$propertyName}[0];
				    }
				?>

				<?php // Render HTML using renderers  ?>
				
				<?php if($propertyHTML !== false) : ?>
					<tr>
						<th><?= ucfirst(preg_replace('/([A-Z])/', ' ${1}',$propertyLabel)); ?>:</th>
						<td <?= (!empty($validationError)) ? 'class="validation-error"' : '' ?>>
							<?= $propertyHTML;?>
							<?php if (!empty($validationError)): ?>
							    <div class="validation-message"><?= $validationErrorMsg; ?></div>
							<?php endif; ?>
						</td>
						<?php if($context == SD_CONTEXT_SPECIAL): ?>
							<td><p class="example"><?= $sdsObject->getType() . '/' . $objectName . '/' .
								$propertyName; ?></p></td>
						<?php endif; ?>
					</tr>
					<?php continue; ?>
				<?php endif; ?>
				
				
				<?php // Render properties manually ?>
				<tr>
					<th><?= ucfirst(preg_replace('/([A-Z])/', ' ${1}', $propertyLabel)); ?>:</th>
					<td <?= (!empty($validationError)) ? 'class="validation-error"' : '' ?>>
						<p><?php echo $property->getWrappedValue()->render( $context, array( 'isCreateMode' => $isCreateMode, 'objectId' => $objectId ) ); ?></p>
						<?php if (!empty($validationError)): ?>
							<div class="validation-message"><?= $validationErrorMsg; ?></div>
						<?php endif; ?>
					</td>
					<?php if($context == SD_CONTEXT_SPECIAL): ?>
						<td><p class="example"><?= $sdsObject->getType() . '/' . $objectName . '/'. $propertyName;
							?></p>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if($context == SD_CONTEXT_EDITING): ?>
		<input type="submit" value="<?= wfMsg('structureddata-save-object-button') ?>" class="wikia-button SDObjectSave" />
	<?php endif; ?>
</form>