	<div id="SharingToolbar">
<?php
	foreach($shareButtons as $shareButton) {
		echo '<div>';
		echo $shareButton->getShareBox();
		echo '</div>';
	}
?>
	</div>
