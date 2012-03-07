<div id=wkLgn>
	<?= $app->renderView('UserLoginSpecial', 'Providers') ;?>
	<form method=post>
		<input type=hidden name=loginToken value='<?= $loginToken ?>'>
		<input type=text name=username placeholder='<?= $wf->Msg('yourname')?>'>
		<input type=password name=password placeholder='<?= $wf->Msg('yourpassword') ?>'>
		<a href=recovery.php id=wkPwdRcv><?= $wf->Msg('userlogin-forgot-password') ?></a>
		<input type=submit value='<?= $wf->Msg('login') ?>' class='wkBtn main'>
	</form>
</div>