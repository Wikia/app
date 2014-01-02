<div class="UserLoginFacebook">
	<h1><?= wfMessage('usersignup-facebook-heading')->escaped() ?></h1>
	<section class="UserLoginFacebookWrapper">
		<section class="UserLoginFacebookLeft">

<?php
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'username',
				'isRequired' => true,
				'label' => wfMessage('yourname')->escaped(),
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'isRequired' => true,
				'label' => wfMessage('yourpassword')->escaped(),
			),
			array(
				'type' => 'nirvana',
				'class' => 'email',
				'controller' => 'WikiaStyleGuideTooltipIconController',
				'method' => 'index',
				'params' => array(
					'text' => wfMessage('email')->escaped(),
					'tooltipIconTitle' => wfMessage('usersignup-facebook-email-tooltip')->escaped(),
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
				'params' => array('createAccountButtonLabel' => wfMessage('createaccount')->escaped())
			),
		),
		'method' => 'post',
	);

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
		</section>

		<section class="UserLoginFacebookRight">
			<h1><?= wfMessage('usersignup-facebook-have-an-account-heading')->escaped() ?></h1>
			<p><?= wfMessage('usersignup-facebook-have-an-account')->escaped() ?></p>
			<a class="wikia-button" href="<?= htmlspecialchars($specialUserLoginUrl) ?>"><?= wfMessage('login')->escaped() ?></a>
		</section>
	</section>

	<a href="#" class="FacebookSignupConfigHeader">
		<img src="<?= $wg->BlankImgUrl ?>" class="chevron">
		<span class="hide"><?= wfMessage('userlogin-facebook-hide-preferences')->escaped() ?></span>
		<span class="show"><?= wfMessage('userlogin-facebook-show-preferences')->escaped() ?></span>
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
		'legend' => wfMessage('fbconnect-prefs-post')->escaped(),
		'class' => 'FacebookSignupConfig',
		'inputs' => $newOptions,
		'method' => 'post',
	);

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $formFb))
?>
</div>
