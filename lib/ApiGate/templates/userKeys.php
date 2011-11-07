<div class='sub_module'>
	<?= i18n( 'apigate-userkeys-intro' ) ?>
<?php
	global $APIGATE_LINK_ROOT, $APIGATE_CONTACT_EMAIL;
	if(count($keyData) > 0){
		?><ul><?php
		foreach($keyData as $key){
			$apiKey = $key['apiKey'];
			$nickName = $key['nickName'];

			$enabled = $key['enabled'];
			$liClass = ($enabled ? "" : " class='disabled'");
			$disabledText = ($enabled ? "" : " (".i18n( 'apigate-userkeys-disabled' ).")");
			
			?><li<?= $liClass ?>><a href='<?= $APIGATE_LINK_ROOT."/key?apiKey=$apiKey" ?>'><?= $nickName ?></a><?= $disabledText ?></li><?php
		}
		?></ul><?php
	} else {

		// TODO: message & link to register
		print "No API keys for current user yet."; // TODO: CHANGE TO i18n MESSAGE w/link or embed the register module!
		// TODO: message & link to register

	}
?>

	<?php
	$registerLink = $APIGATE_LINK_ROOT."/register";
	$emailLink = "<a href='mailto:$APIGATE_CONTACT_EMAIL'>$APIGATE_CONTACT_EMAIL</a>";
	print i18n( 'apigate-userkeys-footer', $registerLink, $emailLink );
	?>
</div>
