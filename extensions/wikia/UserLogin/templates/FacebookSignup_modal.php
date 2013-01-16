<div class="UserLoginFacebook">
	<h1><?= wfMsg('usersignup-facebook-heading') ?></h1>
	<section class="UserLoginFacebookWrapper">
		<section class="UserLoginFacebookLeft">

<?php
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'username',
				'isRequired' => true,
				'label' => wfMsg('yourname'),
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'isRequired' => true,
				'label' => wfMsg('yourpassword'),
			),
			array(
				'type' => 'custom',
				'output' => '<span class="email-wrapper">' . wfMsg('email') . '<span class="email-tooltip" rel="tooltip" title="' . wfMsg('usersignup-facebook-email-tooltip') . '">?</span></span><strong class="fb-email">' . $fbEmail . '</strong>',
			),
			array(
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => $loginToken
			),
			array(
				'type' => 'nirvanaview',
				'controller' => 'UserSignupSpecial',
				'view' => 'submit',
				'class' => 'submit-pane error modal-pane',
				'params' => array('createAccountButtonLabel' => wfMsg('createaccount'))
			),
		),
		'method' => 'post',
	);

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
		</section>

		<section class="UserLoginFacebookRight">
			<h1><?= wfMsg('usersignup-facebook-have-an-account-heading') ?></h1>
			<p><?= wfMsg('usersignup-facebook-have-an-account') ?></p>
			<a class="wikia-button" href="<?= htmlspecialchars($specialUserLoginUrl) ?>"><?= wfMsg('login') ?></a>
		</section>
	</section>

	<a href="#" class="FacebookSignupConfigHeader">
		<img src="<?= $wg->BlankImgUrl ?>" class="chevron">
		<span class="hide"><?= wfMsg('userlogin-facebook-hide-preferences') ?></span>
		<span class="show"><?= wfMsg('userlogin-facebook-show-preferences') ?></span>
	</a>

<?php
	// print out FB feed preferences
	foreach ($fbFeedOptions as $option) {
		$optionElement = array(
			'type' => 'checkbox',
			'name' => $option['name'],
			'label' => $option['shortText'],
			'attributes' => array(
				'checked' => true
			)
		);
		if ($optionElement['name'] == 'fbconnect-push-allow-never') {
			$optionElement['attributes'] = array();
			$optionElement['class'] = 'indented';
		}
		$newOptions[] = $optionElement;
	}
	$formFb = array(
		'legend' => wfMsg('fbconnect-prefs-post'),
		'class' => 'FacebookSignupConfig',
		'inputs' => $newOptions,
		'method' => 'post',
	);

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $formFb))
?>
</div>
