<div class='sub_module'>
	<?= i18n( 'apigate-userkeys-intro' ) ?>
<?php
	if(count($keys) > 0){
		?><ul><?php
		global $APIGATE_LINK_ROOT;
		foreach($keys as $apiKey){
			// TODO: Use nicknames if available.
			// TODO: Use nicknames if available.
			?><li><a href='<?= $APIGATE_LINK_ROOT."/key?apiKey=$apiKey" ?>'><?= $apiKey ?></a></li><?php
		}
		?></ul><?php
	} else {

		// TODO: message & link to register
		print "No API keys for current user yet."; // TODO: CHANGE TO i18n MESSAGE w/link or embed the register module!
		// TODO: message & link to register

	}
?>

	<?php
	global $APIGATE_CONTACT_EMAIL;
	$emailLink = "<a href='mailto:$APIGATE_CONTACT_EMAIL'>$APIGATE_CONTACT_EMAIL</a>";
	print i18n( 'apigate-userkeys-footer', $emailLink );
	?>
</div>
