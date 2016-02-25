<li class="SpeechBubble message  message-removed" <? if(${WallConst::hide}):?> style="display:none" <? endif;?>  >
	<div class='speech-bubble-message-removed' >
		<?php if(${WallConst::showundo}):?>
			<?php echo wfMsg(${WallConst::comment}->isMain() ? 'wall-'.( ${WallConst::comment}->isAdminDelete() ? 'deleted':'removed' ). '-thread-undo':'wall-removed-reply-undo', '<a data-id="'.${WallConst::comment}->getId().'"  class="message-undo-remove" >'.wfMsg('wall-message-undoremove').'</a>'); ?>
			<?php else:?>
				<?php echo wfMsg('wall-removed-reply'); ?>
			<?php endif;?>
	</div>
</li>
