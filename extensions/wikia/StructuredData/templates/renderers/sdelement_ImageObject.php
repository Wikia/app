<?php /* @var SDElement $object */
    if($context == SD_CONTEXT_SPECIAL): ?>
	<?php $imgSrc = $object->getPropertyValue('schema:contentURL', false); ?>
	<figure>
		<?php if ($imgSrc != false) : ?>
			<img src="<?= $imgSrc->getValue() ?>" />
		<?php endif; ?>
		<figcaption><?php echo $object->getName('schema:name'); ?></figcaption>
	</figure>
	<dl>
		<dt>Link to file page:</dt>
		<dd>
			<a href="<?php $url = $object->getPropertyValue('schema:url', false); echo ($url !== false) ? $url->getValue() : ''; ?>" title=""><?php echo($url !== false) ? $url->getValue() : ''; ?></a>
		</dd>
	</dl>
<?php elseif ($context == SD_CONTEXT_EDITING): ?>
	<input type="hidden" name="<?=$params['fieldName'];?>" value="<?=$object->getId();?>" />
	<a href="<?=$object->getObjectPageUrl($context);?>" title="<?=htmlspecialchars( $object->getName() ); ?>"><img src="<?php
		$imgSrc = $object->getPropertyValue('schema:contentURL', false);
		echo ($imgSrc !== false) ? $imgSrc->getValue() : '#';?>" alt="<?=htmlspecialchars( $object->getName() ); ?>" /></a>
	<button class="secondary remove">Remove</button>
<?php else : ?>
	<img src="<?php $imgSrc = $object->getPropertyValue('schema:contentURL', false); echo ($imgSrc !== false) ? $imgSrc->getValue() : '#'; ?>" />
<?php endif; ?>