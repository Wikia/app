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
			$diff = [[
				"id" => "wpDiff",
				"accesskey" => wfMessage('accesskey-diff')->escaped(),
				"text" => wfMessage('showdiff')->escaped()
			]];

			if ( $showMobilePreview ): ?>
				<a href="#" id="<?= $diff[0]['id'] ?>" class="diff-link" accesskey="<?= $diff[0]['accesskey'] ?>">
					<?= $diff[0]['text'] ?>
				</a>
			<?php else: ?>
				<?= $app->renderView( 'MenuButton', 'Index', [
					'action' => [
						'href' => '#',
						'text' => wfMessage( 'preview' )->escaped(),
						'id' => 'wpPreview',
						'tabindex' => 23
					],
					'class' => 'secondary '.$buttonClasses,
					'dropdown' => $diff
				]) ?>
			<?php endif ?>
			<?php break ?>
		<?php default: ?>
			<input class="<?=$buttonClasses?>"<?= !empty($button['disabled']) ? ' disabled="disabled"' : '' ?> id="<?=$button['name']?>" name="<?=$button['name']?>" type="<?=$buttonType?>" value="<?=$button['caption']?>" />
		<?php break ?>
		<?php endswitch ?>
<?php endforeach ?>
