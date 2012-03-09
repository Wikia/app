<?php
	$userErr = $pwdErr = false;
	if( !empty( $result ) && $result == 'error' ){
		if($errParam == 'username'){
			$userErr = true;
		}else{
			$pwdErr = true;
		}
	}
?>
<div id=wkLgn>
	<div id=fb-root></div>
	<?= $app->renderView('UserLoginSpecial', 'Providers') ;?>
	<form method=post action="<?= $formPostAction ?>?action=login">
		<input type=hidden name=loginToken value='<?= $loginToken ?>'>
		<input type=text name=username placeholder='<?= $wf->Msg('yourname')?>'<?= ($username) ? ' value="'.$username.'"' : ''?> <?= ($userErr) ? ' class=inpErr' : ''?>>
		<? if( $userErr ) : ?>
			<div class=wkErr><?= $msg ?></div>
		<? endif; ?>
			<input type=password name=password placeholder='<?= $wf->Msg('yourpassword') ?>'<?= ($password) ? ' value="'.$password.'"' : ''?> <?= ($pwdErr) ? ' class=inpErr' : ''?>>
			<? if( $pwdErr ) : ?>
				<div class=wkErr><?= $msg ?></div>
			<? endif; ?>
		<input type=submit value='<?= $wf->Msg('login') ?>' class='wkBtn main'>
	</form>
</div>