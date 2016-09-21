<?
/**
 * @var bool $isMonobookOrUncyclo
 * @var string $pageHeading
 * @var string $signupToken
 * @var string $username
 * @var string $email
 * @var string $birthyear
 * @var string $birthmonth
 * @var string $birthday
 * @var bool $isEn
 * @var string $createAccountButtonLabel
 * @var string $returnto
 * @var string $msg
 * @var array $avatars
 * @var array $popularWikis
 */

$form = [
	'id' => 'WikiaSignupForm',
	'method' => 'post',
	'inputs' => [
		[
			'type' => 'hidden',
			'name' => 'signupToken',
			'value' => Sanitizer::encodeAttribute( $signupToken ),
		],
		[ // fake username field ( not in use )
			'type' => 'hidden',
			'name' => 'username',
			'value' => '',
			'label' => wfMessage( 'yourname' )->escaped(),
		],
		[ // actual username field
			'type' => 'text',
			'name' => 'userloginext01',
			'value' => htmlspecialchars( $username ),
			'label' => wfMessage( 'yourname' )->escaped(),
			'isRequired' => true,
			'isInvalid' => ( !empty( $errParam ) && $errParam === 'username' ),
			'errorMsg' => ( !empty( $msg ) ? $msg : '' )
		],
		[
			'type' => 'text',
			'name' => 'email',
			'value' => Sanitizer::encodeAttribute( $email ),
			'label' => wfMessage( 'email' )->escaped(),
			'isRequired' => true,
			'isInvalid' => ( !empty( $errParam ) && $errParam === 'email' ),
			'errorMsg' => ( !empty( $msg ) ? $msg : '' )
		],
		[ // fake password field ( not in use )
			'type' => 'hidden',
			'name' => 'password',
			'value' => '',
			'label' => wfMessage( 'yourpassword' )->escaped(),
		],
		[ // actual password field
			'type' => 'password',
			'name' => 'userloginext02',
			'value' => '',
			'label' => wfMessage( 'yourpassword' )->escaped(),
			'isRequired' => true,
			'isInvalid' => ( !empty( $errParam ) && $errParam === 'password' ),
			'errorMsg' => ( !empty( $msg ) ? $msg : '' )
		],
		[
			'type' => 'hidden',
			'name' => 'wpRegistrationCountry',
			'value' => '',
		],
		[
			'type' => 'custom',
			'isRequired' => true,
			'isInvalid' => ( !empty( $errParam ) && $errParam === 'birthyear' ) || ( !empty( $errParam ) && $errParam === 'birthmonth' ) || ( !empty( $errParam ) && $errParam === 'birthday' ),
			'errorMsg' => ( !empty( $msg ) ? $msg : '' ),
			'output' => F::app()->renderPartial( 'UserSignupSpecial', 'birthday', [
				'birthyear' => $birthyear, 'birthmonth' => $birthmonth, 'birthday' => $birthday, 'isEn' => $isEn
			])
		],
		[
			'type' => 'custom',
			'isRequired' => true,
			'class' => 'captcha',
			'isInvalid' => ( !empty( $errParam ) && $errParam === 'wpCaptchaWord' ),
			'errorMsg' => ( !empty( $msg ) ? $msg : '' ),
			'output' => F::app()->renderView( 'UserSignupSpecial', 'captcha' ),
		],
		[
			'class' => 'opt-in-container hidden',
			'type' => 'checkbox',
			'name' => 'wpMarketingOptIn',
			'label' => wfMessage( 'userlogin-opt-in-label' )->escaped(),
		],
		[
			'type' => 'custom',
			'class' => 'submit-pane error',
			'output' => F::app()->renderPartial( 'UserSignupSpecial', 'submit', [
				'createAccountButtonLabel' => $createAccountButtonLabel
			]),
		]
	]
];

$form['isInvalid'] = !empty( $result ) && $result === 'error' && empty( $errParam );
$form['errorMsg'] = $form['isInvalid'] ? $msg : '';

if ( !empty( $returnto ) ) {
	$form['inputs'][] = [
		'type' => 'hidden',
		'name' => 'returnto',
		'value' => Sanitizer::encodeAttribute( $returnto ),
	];
}

if ( !empty( $byemail ) ) {
	$form['inputs'][] = [
		'type' => 'hidden',
		'name' => 'byemail',
		'value' => Sanitizer::encodeAttribute( $byemail )
	];
}
?>

<section class="WikiaSignup">
	<? if ( !$isMonobookOrUncyclo ): ?>
		<h2 class="pageheading">
			<?= $pageHeading ?>
		</h2>
		<h3 class="subheading"></h3>
		<div class="wiki-info">
			<?= F::app()->renderView( 'WikiHeader', 'Wordmark' ) ?>
			<p><?= wfMessage( 'usersignup-marketing-wikia' )->escaped() ?></p>
			<?= wfMessage( 'usersignup-marketing-login' )->parse() ?>
		</div>
	<? endif; ?>

	<div class="form-container">
		<? if ( !$isMonobookOrUncyclo ): ?>
			<? // 3rd party providers buttons ?>
			<?= $app->renderView( 'UserLoginSpecial', 'ProvidersTop', [ 'requestType' => 'signup' ] ) ?>
		<? endif; ?>
		<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $form ] ) ?>
	</div>
	<? if ( empty( $byemail ) ): ?>
		<div class="marketing">
			<h2><?= wfMessage( 'usersignup-marketing-benefits' )->escaped() ?></h2>
			<div class="benefit">
				<ul class="avatars">
					<? foreach ( $avatars as $avatar ) { ?>
					<li class="avatar"><img src="<?= $avatar ?>" width="30" height="30"></li>
					<? } ?>
				</ul>
				<h3><?= wfMessage( 'usersignup-marketing-community-heading' )->escaped() ?></h3>
				<p><?= wfMessage( 'usersignup-marketing-community' )->escaped() ?></p>
			</div>
			<div class="benefit">
				<h3><?= wfMessage( 'usersignup-marketing-global-heading' )->escaped() ?></h3>
				<p><?= wfMessage( 'usersignup-marketing-global' )->escaped() ?></p>
			</div>
			<div class="benefit">
				<h3><?= wfMessage( 'usersignup-marketing-creativity-heading' )->escaped() ?></h3>
				<p><?= wfMessage( 'usersignup-marketing-creativity' )->escaped() ?></p>
			</div>
		</div>
	<? endif; ?>
</section>
