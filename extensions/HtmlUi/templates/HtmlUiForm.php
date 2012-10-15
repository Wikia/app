<?php if ( !defined( 'MEDIAWIKI' ) ) exit; ?>
<form class="htmlUiForm"<?php self::attributes( $attributes ) ?>>
	<?php foreach( $elements as $element ): ?>
	<?php echo $element->render(); ?>
	<?php endforeach; ?>
</form>
