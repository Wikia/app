<?php foreach ( $buttons as $button ): ?>
	<?php
	$buttonType = !empty($button['type']) ? $button['type'] : 'button';
	$buttonClasses = 'control-button'
		. ($button['seqNo'] % 2 == 1 ? ' even' : '')
		. (!empty($button['className']) ? ' ' . $button['className'] : '');
	?>
	<?php switch( $buttonType ):
		// The odd formatting here is intentional, see: https://bugs.php.net/bug.php?id=36729
		case 'save': ?>
			<?php break ?>
		<?php case 'preview': ?>
			<?php break ?>
		<?php default: ?>
			<input class="<?=$buttonClasses?>"<?= !empty($button['disabled']) ? ' disabled="disabled"' : '' ?> id="<?=$button['name']?>" name="<?=$button['name']?>" type="<?=$buttonType?>" value="<?=$button['caption']?>" />
		<?php break ?>
		<?php endswitch ?>
<?php endforeach ?>
