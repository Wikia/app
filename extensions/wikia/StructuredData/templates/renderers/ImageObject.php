<?php if($context == SD_CONTEXT_SPECIAL): ?>
	<?php $imgSrc = $object->getPropertyValue('schema:contentURL', false); ?>
	<figure>
		<?php if ($imgSrc != false) : ?>
			<img src="<?= $imgSrc ?>" />
		<?php endif; ?>
		<figcaption><?php echo $object->getPropertyValue('schema:name', false); ?></figcaption>
	</figure>
	<a href="<?php echo $object->getPropertyValue('schema:url', false); ?>" title=""><?php echo $imgSrc = $object->getPropertyValue('schema:url', false); ?></a>
<?php else : ?>
	<img src="<?= $object->getPropertyValue('schema:contentURL', false); ?>" />
<?php endif; ?>