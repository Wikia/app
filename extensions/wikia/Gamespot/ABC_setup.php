<?php

$wgHooks['AlternateNavLinks'][] = 'ABCNavLinks';

function ABCNavLinks()
{
	global $IP;
	$tmpl = new EasyTemplate($IP);
	$output = $tmpl->execute('/skins/monaco/abc/header.tmpl.php');

	echo $output;

	return false;
}

$wgHooks['SpecialFooter'][] = 'ABCFooter';

function ABCFooter()
{
	global $IP;
	$tmpl = new EasyTemplate($IP);
	$output = $tmpl->execute('/skins/monaco/abc/footer.tmpl.php');

	echo $output;

	return false;
}

global $wgForceSkin;
$wgForceSkin = 'monaco-abc';

for( $i=0; $i<16; $i++ ) {
	$wgNamespaceRobotPolicies[$i] = "noindex,nofollow";
}
$wgNamespaceRobotPolicies[110] = "noindex,nofollow";
$wgNamespaceRobotPolicies[111] = "noindex,nofollow";

?>
