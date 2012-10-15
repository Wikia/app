<?php if ( !defined( 'MEDIAWIKI' ) ) exit; ?>
<fieldset class="htmlUiFieldset" rel="<?php echo $id ?>">
	<?php foreach( $elements as $element ): ?>
	<?php echo $element->render(); ?>
	<?php endforeach; ?>
</fieldset>
