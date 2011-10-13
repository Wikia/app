
<h1><?= i18n( 'apigate-register-heading' ) ?></h1>
<form method="post" action="">
	<div>
		<?= i18n( 'apigate-register-name' ); ?><br/>
		<input type='text' name='firstName' placeholder='<?= i18n( 'apigate-register-hint-firstname' ); ?>' style='width:192px'/>
		&nbsp;<input type='text' name='lastName' placeholder='<?= i18n( 'apigate-register-hint-lastname' ); ?>' style='width:192px'/><br/>
		<?= i18n( 'apigate-register-email' ); ?><br/>
		<input type='text' name='email_1' placeholder='<?= i18n( 'apigate-register-hint-email' ); ?>' style='width:400px'/><br/>
		<input type='text' name='email_2' placeholder='<?= i18n( 'apigate-register-hint-confirm-email' ); ?>' style='width:400px'/><br/>
		<input type='submit' value='<?= i18n( 'apigate-register-submit' ) ?>'/>
	</div>
</form>
