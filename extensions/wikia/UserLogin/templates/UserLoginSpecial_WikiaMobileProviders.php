<?= $app->renderView( 'FacebookButton', 'index', array(
	'class' => 'ssoFbBtn',
	'text' => $wf->Msg( 'fbconnect-connect-simple' ),
	'tooltip' => ( !empty( $context ) && $context === 'signup' ? 
		$wf->Msg( 'userlogin-provider-tooltip-facebook-signup' ) : 
		$wf->Msg( 'userlogin-provider-tooltip-facebook' ) )
) ) ;?>
<div class=ssoSep><?= $wf->Msg( 'userlogin-provider-or') ;?></div>