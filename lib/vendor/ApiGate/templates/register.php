
<h1><?= i18n( 'apigate-register-heading' ) ?></h1>
<form method="post" action="">
	<div>
		<input type='hidden' name='formName' value='apiGate_register'/>
		<?php
			if( !empty($errorString ) ) {
				?><div class='error'><?= $errorString ?></div><?php
			}
		?><?= i18n( 'apigate-register-name' ); ?><br/>
		<input type='text' name='firstName' placeholder='<?= i18n( 'apigate-register-hint-firstname' ); ?>' value='<?= $firstName ?>' style='width:192px'/>
		&nbsp;<input type='text' name='lastName' placeholder='<?= i18n( 'apigate-register-hint-lastname' ); ?>' value='<?= $lastName ?>' style='width:192px'/><br/>
		<br/>
		<?= i18n( 'apigate-register-email' ); ?><br/>
		<input type='text' name='email_1' placeholder='<?= i18n( 'apigate-register-hint-email' ); ?>' value='<?= $email_1 ?>' style='width:400px'/><br/>
		<input type='text' name='email_2' placeholder='<?= i18n( 'apigate-register-hint-confirm-email' ); ?>' value='<?= $email_2 ?>' style='width:400px'/><br/>
		<br/>
		<input type='submit' value='<?= i18n( 'apigate-register-submit' ) ?>'/><br/>
		<br/>
		<?= i18n( 'apigate-register-implicit-agreement' ) ?>
	</div>
</form>
