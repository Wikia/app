	<div id="SharingToolbar" class="hidden">
<?php
	foreach($shareButtons as $shareButton) {
		echo '<div>';
		echo $shareButton->getShareBox();
		echo '</div>';
	}
?>
	</div>
