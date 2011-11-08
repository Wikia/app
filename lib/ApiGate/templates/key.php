<div class='sub_module'>
	TODO: Key info form for <?= $apiKeyObject->getApiKey() ?>
	<?php
		// TODO: Create the i18n strings
		
		
		// TODO: Highlight the nickname & apiKey if disabled
		$keyClass = "";
		if( !$apiKeyObject->isEnabled() ){
			$keyClass = "class='disabled'";
		}
		// TODO: Highlight the nickname & apiKey if disabled
		
		// TODO: If disabled, show the 'reason' value (make ApiGate_ApiKey lazy-load that so it just shows up through an accessor).
		// TODO: If disabled, show the 'reason' value (make ApiGate_ApiKey lazy-load that so it just shows up through an accessor).
		
		
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
			<input type='text' name='nickName' value='<?= $apiKeyObject->getNickName() ?>'/>
			<?= i18n( 'apigate-keyinfo-apiKey' ); ?>
			<strong><?= i18n( 'apigate-keyinfo-apiKey' ); ?></strong><br/>
			<?= i18n( 'apigate-keyinfo-name' ); ?><br/>
			<input type='text' name='firstName' value='<?= $firstName ?>' style='width:192px'/>
			&nbsp;<input type='text' name='lastName' value='<?= $lastName ?>' style='width:192px'/><br/>
			<br/>
			<?= i18n( 'apigate-keyinfo-email' ); ?><br/>
			<input type='text' name='email_1' value='<?= $email_1 ?>' style='width:400px'/><br/>
			<input type='text' name='email_2' value='<?= $email_2 ?>' style='width:400px'/><br/>
			<br/>
			<input type='submit' value='<?= i18n( 'apigate-keyinfo-submit' ) ?>'/><br/>
		</div>
	</form>

</div>
