<?php /* @var SDElement $object */?>
<?php if ($context == SD_CONTEXT_EDITING): ?>
	<input type="hidden" name="<?=$params['fieldName'];?>" value="<?=$object->getId();?>" />
<?php endif; ?>
<?php if($context == SD_CONTEXT_SPECIAL || $context == SD_CONTEXT_EDITING): ?>
	<?php $imgSrc = $object->getPropertyValue('schema:contentURL', false); ?>
	<strong><a href="<?=$object->getObjectPageUrl($context);?>" title="<?=htmlspecialchars( $object->getName() );
		?>"><?=htmlspecialchars( $object->getName() ); ?></a></strong></br>
    <img src="<?php $imgSrc = $object->getPropertyValue('schema:contentURL',
	    false); echo ($imgSrc !== false) ?
	    $imgSrc->getValue() : '#';?>" alt="<?=htmlspecialchars( $object->getName() ); ?>" />
<?php endif; ?>
<?php if ($context == SD_CONTEXT_EDITING): ?>
	<button class="secondary remove"><?= wfMsg('structureddata-object-edit-remove-reference') ?></button>
<?php endif; ?>
<?php  if($context != SD_CONTEXT_SPECIAL && $context != SD_CONTEXT_EDITING): ?>
	<img src="<?php $imgSrc = $object->getPropertyValue('schema:contentURL', false); echo ($imgSrc !== false) ? $imgSrc->getValue() : '#'; ?>" />
<?php endif; ?>