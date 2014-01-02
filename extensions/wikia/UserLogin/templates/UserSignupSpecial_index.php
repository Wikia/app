<section class="WikiaSignup">
<?php if (!$isMonobookOrUncyclo) { ?>
	<h2 class="pageheading">
		<?= $pageHeading ?>
	</h2>
	<h3 class="subheading"></h3>
	<div class="wiki-info">
		<?= F::app()->renderView('WikiHeader', 'Wordmark') ?>
		<p><?= wfMessage('usersignup-marketing-wikia')->text() ?></p>
		<?= wfMessage('usersignup-marketing-login')->parse() ?>
	</div>

<?php } //$isMonobookOrUncyclo ?>
	<div class="form-container">
	<?php
		// 3rd party providers buttons
		if (!$isMonobookOrUncyclo) {
			echo $app->renderView('UserLoginSpecial', 'ProvidersTop', array('requestType' => 'signup') );
		}
	?>
<?php
	$form = array(
		'id' => 'WikiaSignupForm',
		'method' => 'post',
		'inputs' => array(
			array(
				'type' => 'hidden',
				'name' => 'signupToken',
				'value' => $signupToken
			),
			array( //fake username field (not in use)
				'type' => 'hidden',
				'name' => 'username',
				'value' => '',
				'label' => wfMessage('yourname')->text(),
			),
			array( //actual username field
				'type' => 'text',
				'name' => 'userloginext01',
				'value' => htmlspecialchars($username),
				'label' => wfMessage('yourname')->text(),
				'isRequired' => true,
				'isInvalid' => (!empty($errParam) && $errParam === 'username'),
				'errorMsg' => (!empty($msg) ? $msg : '')
			),
			array(
				'type' => 'text',
				'name' => 'email',
				'value' => $email,
				'label' => wfMessage('email')->text(),
				'isRequired' => true,
				'isInvalid' => (!empty($errParam) && $errParam === 'email'),
				'errorMsg' => (!empty($msg) ? $msg : '')
			),
			array( //fake password field (not in use)
				'type' => 'hidden',
				'name' => 'password',
				'value' => '',
				'label' => wfMessage('yourpassword')->text(),
			),
			array( //actual password field
				'type' => 'password',
				'name' => 'userloginext02',
				'value' => '',
				'label' => wfMessage('yourpassword')->text(),
				'isRequired' => true,
				'isInvalid' => (!empty($errParam) && $errParam === 'password'),
				'errorMsg' => (!empty($msg) ? $msg : '')
			),
			array(
				'type' => 'nirvanaview',
				'controller' => 'UserSignupSpecial',
				'view' => 'birthday',
				'isRequired' => true,
				'isInvalid' => (!empty($errParam) && $errParam === 'birthyear') || (!empty($errParam) && $errParam === 'birthmonth') || (!empty($errParam) && $errParam === 'birthday'),
				'errorMsg' => (!empty($msg) ? $msg : ''),
				'params' => array('birthyear' => $birthyear, 'birthmonth' => $birthmonth, 'birthday' => $birthday, 'isEn' => $isEn),
			),
			array(
				'type' => 'nirvana',
				'controller' => 'UserSignupSpecial',
				'method' => 'captcha',
				'isRequired' => true,
				'class' => 'captcha',
				'isInvalid' => (!empty($errParam) && $errParam === 'wpCaptchaWord'),
				'errorMsg' => (!empty($msg) ? $msg : '')
			),
			array(
				'type' => 'nirvanaview',
				'controller' => 'UserSignupSpecial',
				'view' => 'submit',
				'class' => 'submit-pane error',
				'params' => array('createAccountButtonLabel' => $createAccountButtonLabel)
			)
		)
	);

	$form['isInvalid'] = !empty($result) && $result === 'error' && empty($errParam);
	$form['errorMsg'] = $form['isInvalid'] ? $msg : '';

	if(!empty($returnto)) {
		$form['inputs'][] = array(
			'type' => 'hidden',
			'name' => 'returnto',
			'value' => $returnto
		);
	}

	if(!empty($byemail)) {
		$form['inputs'][] = array(
			'type' => 'hidden',
			'name' => 'byemail',
			'value' => $byemail
		);
	}

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
	</div>

	<? if(empty($byemail)) { ?>
    <div class="marketing">
        <h2><?= wfMessage('usersignup-marketing-benefits')->text() ?></h2>
        <div class="benefit">
            <ul class="avatars">
				<? foreach($avatars as $avatar) { ?>
                <li class="avatar"><img src="<?= $avatar ?>" width="30" height="30"></li>
				<? } ?>
            </ul>
            <h3><?= wfMessage('usersignup-marketing-community-heading')->text() ?></h3>
            <p><?= wfMessage('usersignup-marketing-community')->text() ?></p>
        </div>
        <div class="benefit">
            <ul class="wikis">
				<? foreach($popularWikis as $wiki ) { ?>
                <li class="wiki"><img src="<?= $wiki ?>" width="65" height="18"></li>
				<? } ?>
            </ul>
            <h3><?= wfMessage('usersignup-marketing-global-heading')->text() ?></h3>
            <p><?= wfMessage('usersignup-marketing-global')->text() ?></p>
        </div>
        <div class="benefit">
            <h3><?= wfMessage('usersignup-marketing-creativity-heading')->text() ?></h3>
            <p><?= wfMessage('usersignup-marketing-creativity')->text() ?></p>
        </div>
    </div>
	<?php } //marketing ?>
</section>
