<?php /* @var SDElement $object */
    if($context == SD_CONTEXT_EDITING): ?>
	<!-- default object (SDElement) renderer -->
	<input type="hidden" name="<?=$params['fieldName'];?>" value="<?=$object->getId();?>" />
<?php endif; ?>
<a href="<?=$object->getObjectPageUrl($context);?>"><?=htmlspecialchars( $object->getName() );?></a>

<?php if($context == SD_CONTEXT_EDITING): ?>
	<button class="secondary remove"><?= wfMsg('structureddata-object-edit-remove-reference') ?></button>
<?php endif; ?>