<?php if($context == SD_CONTEXT_EDITING): ?>
	<!-- default object (SDElement, SDElementProperty) renderer -->
	<input type="hidden" name="<?=$params['fieldName'];?>" value="<?=$object->getId();?>" />
<?php endif; ?>
<a href="<?=$object->getSpecialPageUrl();?>"><?=htmlspecialchars( $object->getName() );?></a>