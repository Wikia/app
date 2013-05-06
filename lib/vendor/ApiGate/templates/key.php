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
			<input type='hidden' name='formName' value='apiGate_apiKey_updateKeyInfo'/>
			<input type='hidden' name='apiKey' value='<?= $apiKeyObject->getApiKey() ?>'/>
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
				/** Section for whether key is enabled and any associated ban messages / ban-logs. **/

				// Display the status to users (as a mutable form if this is an Admin).
				if(ApiGate_Config::isAdmin()){
					$enabledSelected = ($apiKeyObject->isEnabled() ? " selected='selected'" : "" );
					$disabledSelected = ($apiKeyObject->isEnabled() ? "" : " selected='selected'" );
					$statusHtml = "<select name='enabled'>\n";
					$statusHtml .= "<option value='1'$enabledSelected>".i18n('apigate-keyinfo-status-enabled')."</option>\n";
					$statusHtml .= "<option value='0'$disabledSelected>".i18n('apigate-keyinfo-status-disabled')."</option>\n";
					$statusHtml .= "</select> - ";
					$statusHtml .= i18n( 'apigate-keyinfo-status-reasonforchange', "<input type='text' name='reason'/>" );
				} else {
					if($apiKeyObject->isEnabled()){
						$statusClass = "enabled";
						$statusMsg = i18n('apigate-keyinfo-status-enabled');
					} else {
						$statusClass = "disabled";
						$statusMsg = i18n('apigate-keyinfo-status-disabled');
					}
					$statusHtml = "<span class='status $statusClass'>$statusMsg</span>";
				}
				print i18n( 'apigate-keyinfo-status', $statusHtml );

				// If the key is disabled, show the user why.
				if(!$apiKeyObject->isEnabled()){
					$reasonBanned = $apiKeyObject->getReasonBanned();
					$reasonBanned = ($reasonBanned == null ? i18n('apigate-keyinfo-no-reason-found') : $apiKeyObject->getReasonBanned() );
					print "<div class='reasonDisabled'>\n" . i18n('apigate-keyinfo-reason-disabled', $reasonBanned) . "\n</div>\n";
				}

				// Always display the full banlog to admins if there are any events in it.
				if( ApiGate_Config::isAdmin() ){
					print "<div class='banLog'>\n" . i18n('apigate-keyinfo-banlog-heading') . "\n<br/>\n";
					print $apiKeyObject->getBanLogHtml()."</div>\n";
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
