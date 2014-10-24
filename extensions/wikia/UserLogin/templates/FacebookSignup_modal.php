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
					'tooltipIconTitle' => wfMessage('usersignup-facebook-email-tooltip')->plain(),
				),
			),
			array(
				'type' => 'custom',
				'output' => '<strong>' . htmlspecialchars( $fbEmail ) . '</strong>'
			),
			array(
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => Sanitizer::encodeAttribute( $loginToken ),
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
</div>