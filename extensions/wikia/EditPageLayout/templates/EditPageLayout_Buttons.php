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
			<input class="<?=$buttonClasses?>" tabindex="22" id="wpSave" name="wpSave" type="submit" value="<?= wfMessage('savearticle')->escaped() ?>" accesskey="<?=wfMessage('accesskey-save')->escaped();?>" />
			<!-- If JavaScript is enabled, disable the save button immediately. -->
			<script type="text/javascript">document.getElementById('wpSave').disabled=true;</script>
			<?php break ?>
		<?php case 'preview': ?>
			<?php
			$dropdown = array(array(
				"id" => "wpDiff",
				"accesskey" => wfMessage('accesskey-diff')->escaped(),
				"text" => wfMessage('showdiff')->escaped()
			));
			?>
			<?= $app->renderView( 'MenuButton', 'Index', array(
				'action' => array(
					'href' => '#',
					'text' => wfMessage( 'preview' )->escaped(),
					'id' => 'wpPreview',
					'tabindex' => 23
				),
				'class' => 'secondary '.$buttonClasses,
				'dropdown' => $dropdown
			)) ?>
			<?php break ?>
		<?php default: ?>
			<input class="<?=$buttonClasses?>"<?= !empty($button['disabled']) ? ' disabled="disabled"' : '' ?> id="<?=$button['name']?>" name="<?=$button['name']?>" type="<?=$buttonType?>" value="<?=$button['caption']?>" />
		<?php break ?>
		<?php endswitch ?>
<?php endforeach ?>
