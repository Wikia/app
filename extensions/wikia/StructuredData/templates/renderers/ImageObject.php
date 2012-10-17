<?php if($context == SD_CONTEXT_SPECIAL): ?>
	<?php $imgSrc = $object->getPropertyValue('schema:contentURL', false); ?>
	<figure>
		<?php if ($imgSrc != false) : ?>
			<img src="<?= $imgSrc ?>" />
		<?php endif; ?>
		<figcaption>Lorem ipsum</figcaption>
	</figure>
	<a href="" title="">File Page Link</a>
<?php else : ?>
	<img src="<?= $object->getPropertyValue('schema:contentURL', false); ?>" />
<?php endif; ?>