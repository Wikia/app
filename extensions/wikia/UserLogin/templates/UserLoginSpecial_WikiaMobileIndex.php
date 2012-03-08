<div id=wkLgn>
	<?= $app->renderView('UserLoginSpecial', 'Providers') ;?>
	<form method=post action='/wiki/Special:UserLogin?useskin=wikiamobile&action=login'>
		<input type=hidden name=loginToken value='<?= $loginToken ?>'>
		<input type=text name=username placeholder='<?= $wf->Msg('yourname')?>'<?= ($username) ? ' value="'.$username.'"' : ''?>>
		<input type=password name=password placeholder='<?= $wf->Msg('yourpassword') ?>'<?= ($password) ? ' value="'.$password.'"' : ''?>>
		<a href=recovery.php id=wkPwdRcv><?= $wf->Msg('userlogin-forgot-password') ?></a>
		<input type=submit value='<?= $wf->Msg('login') ?>' class='wkBtn main'>
	</form>
</div>