<?php
if($showButton){
	?><section class="module ChatRail_ButtonToOpenChat" style='text-align:center'><?php

	// TODO: Make this button automatically require a login before proceding (what class is that which gets this binding?).

	?>
		<button style='margin:0 auto' onclick="window.open('<?= $linkToSpecialChat ?>', 'wikiachat', '<?= $windowFeatures ?>')"><?= wfMsg('chat-rail-buttontext') ?></button>
	</section><?php
}
