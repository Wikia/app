<?php
/*
 * Author: Inez Korczynski
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'AjaxLogin',
	'description' => 'Dynamic box which allow users to login and remind password',
	'author' => 'Inez Korczyński'
);

$wgHooks['GetHTMLAfterBody'][] = 'GetAjaxLoginForm';

function GetAjaxLoginForm($skin) {
	global $wgTitle, $wgUser;
	if(get_class($skin) != 'AwesomeTemplate' && $wgUser->isAnon() && $wgTitle->getNamespace() != 8 && $wgTitle->getDBkey() != 'Userlogin') {
		$tmpl = new EasyTemplate(dirname( __FILE__ ));
		echo $tmpl->execute('AjaxLogin');
	}
	return true;
}

$wgAjaxExportList[] = 'GetAjaxLogin';
function GetAjaxLogin() {
	$tmpl = new EasyTemplate(dirname( __FILE__ ));

	$ret = $tmpl->execute('AjaxLogin');

	// retunr just the <form>
	$start = strpos($ret, '<form');
	$end = strpos($ret, '</form>') + 7;
	$ret = substr($ret, $start, $end-$start);

	// make me modal
	$ret = '
	<div id="AjaxLogin" title="'.htmlspecialchars(wfMsg('login')).'">
		'.$ret.'
	</div>

	<script type="text/javascript">
		$("#AjaxLogin").makeModal();
	</script>';

	return new AjaxResponse( $ret );
}
