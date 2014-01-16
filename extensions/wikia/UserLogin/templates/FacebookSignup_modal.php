<div class="UserLoginFacebook">
	<section class="UserLoginFacebookWrapper">
		<section class="UserLoginFacebookLeft">

<?php
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'username',
				'isRequired' => true,
				'label' => wfMessage('yourname')->plain(),
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'isRequired' => true,
				'label' => wfMessage('yourpassword')->plain(),
			),
			array(
				'type' => 'nirvana',
				'class' => 'email',
				'controller' => 'WikiaStyleGuideTooltipIconController',
				'method' => 'index',
				'params' => array(
					'text' => wfMessage('email')->plain(),
					'tooltipIconTitle' => wfMessage('usersignup-facebook-email-tooltip')->plain(),
				),
			),
			array(
				'type' => 'custom',
				'output' => '<strong>' . $fbEmail . '</strong>'
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
				'params' => array('createAccountButtonLabel' => wfMessage('createaccount')->plain())
			),
		),
		'method' => 'post',
	);

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
		</section>

		<section class="UserLoginFacebookRight">
			<h1><?= wfMessage('usersignup-facebook-have-an-account-heading')->plain() ?></h1>
			<p><?= wfMessage('usersignup-facebook-have-an-account')->plain() ?></p>
			<a class="wikia-button" href="<?= htmlspecialchars($specialUserLoginUrl) ?>"><?= wfMessage('login')->plain() ?></a>
		</section>
	</section>

	<a href="#" class="FacebookSignupConfigHeader">
		<img src="<?= $wg->BlankImgUrl ?>" class="chevron">
		<span class="hide"><?= wfMessage('userlogin-facebook-hide-preferences')->plain() ?></span>
		<span class="show"><?= wfMessage('userlogin-facebook-show-preferences')->plain() ?></span>
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
		'legend' => wfMessage('fbconnect-prefs-post')->plain(),
		'class' => 'FacebookSignupConfig',
		'inputs' => $newOptions,
		'method' => 'post',
	);

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $formFb))
?>
</div>
