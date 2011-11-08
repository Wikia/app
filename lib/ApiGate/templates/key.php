<div class='sub_module'>
	<?php
		// TODO: Create the i18n strings
		// TODO: Create the i18n strings

		// TODO: Highlight the nickname & apiKey if disabled
		$keyClass = "";
		if( !$apiKeyObject->isEnabled() ){
			$keyClass = " class='disabled'";
		}
		// TODO: Highlight the nickname & apiKey if disabled
	?>
	<form method="post" action="">
		<div>
			<input type='hidden' name='formName' value='apiGate_updateKeyInfo'/>
			<?php
				if( !empty($errorString ) ) {
					?><div class='error'><?= $errorString ?></div><?php
				}
			?>
			<?= i18n( 'apigate-keyinfo-nickname' ); ?><br/>
			<input type='text' name='nickName' placeholder='<?= i18n('apigate-keyinfo-hint-nickname') ?>' value='<?= $apiKeyObject->getNickName() ?>' style='font-size:1.5em'/><br/>
			<br/>
			<span<?= $keyClass ?>><?= i18n( 'apigate-keyinfo-apiKey', $apiKeyObject->getApiKey() ); ?></span><br/>
			<?php
				if($apiKeyObject->isEnabled()){
					$statusClass = "enabled";
					$statusMsg = i18n('apigate-keyinfo-status-enabled');
				} else {
					$statusClass = "disabled";
					$statusMsg = i18n('apigate-keyinfo-status-disabled');
				}
				$statusHtml = "<span class='status $statusClass'>$statusMsg</span>";
				print i18n( 'apigate-keyinfo-status', $statusHtml );
				
				// TODO: If disabled, show the 'reason' value (make ApiGate_ApiKey lazy-load that so it just shows up through an accessor).
				// TODO: If disabled, show the 'reason' value (make ApiGate_ApiKey lazy-load that so it just shows up through an accessor).
			?><br/>
			<br/>
			<?= i18n( 'apigate-keyinfo-name' ); ?><br/>
			<input type='text' name='firstName' value='<?= $apiKeyObject->getFirstName() ?>' style='width:192px'/>
			&nbsp;<input type='text' name='lastName' value='<?= $apiKeyObject->getLastName() ?>' style='width:192px'/><br/>
			<br/>
			<?= i18n( 'apigate-keyinfo-email' ); ?><br/>
			<input type='text' name='email_1' value='<?= $apiKeyObject->getEmail() ?>' style='width:400px'/><br/>
			<input type='text' name='email_2' value='<?= $apiKeyObject->getEmail() ?>' style='width:400px'/><br/>
			<br/>
			<input type='submit' value='<?= i18n( 'apigate-keyinfo-submit' ) ?>'/><br/>
		</div>
	</form>

</div>
