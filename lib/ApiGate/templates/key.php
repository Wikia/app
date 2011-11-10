<div class='sub_module'>
	<?php
		// Highlight the nickname & apiKey if disabled
		$keyClass = "";
		if( !$apiKeyObject->isEnabled() ){
			$keyClass = " class='disabled'";
		}
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
					$reason = "<br/>";
				} else {
					$statusClass = "disabled";
					$statusMsg = i18n('apigate-keyinfo-status-disabled');
					$reasonBanned = $apiKeyObject->getReasonBanned();
					$reasonBanned = ($reasonBanned == null ? i18n('apigate-keyinfo-no-reason-found') : $apiKeyObject->getReasonBanned() );
					$reason = "<br/><div class='reasonBanned'>\n" . i18n('apigate-keyinfo-reason-disabled', $reasonBanned) . "\n</div>\n";
				}
				
				// Display the status to users or a mutable form if this is an Admin.
				if(ApiGate_Config::isAdmin()){
					
					print $reason;
				} else {
					$statusHtml = "<span class='status $statusClass'>$statusMsg</span>";
					print i18n( 'apigate-keyinfo-status', $statusHtml );
				}
			?>
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
