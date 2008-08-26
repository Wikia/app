<?php
  $wgExtensionFunctions[] = "wfPaper";

 function wfPaper() {
     global $wgParser;
     $wgParser->setHook( "paper", "renderPaper" );
 }

 # The callback function for converting the input text to HTML output
 function renderPaper( $input, $argv, &$parser ) {
     # $argv is an array containing any arguments passed to the extension like <example argument="foo" bar>..

	global $wgExtensionsPath;

	$localParser = new Parser();
	$outputObj = $localParser->Parse($input, $parser->mTitle, $parser->mOptions);

	if(empty($argv['width'])==true)
		$width="100%";
	else  $width=$argv['width'];

	if(empty($argv['align'])==true)
		$align="left";
	else  $align=$argv['align'];

$ext_dir = "$wgExtensionsPath/3rdparty/Paper/";

$output='<table width="'.$width.'" align="'.$align.'" bgcolor="fbe7bd" style="border: 0px; margin: 0px; padding: 0px;" cellspacing=0>'
.'<tr>'
.'<td width=34 height=34 valign="top" style="background-image:url('. $ext_dir. '/Paper_l.png); border: 0px; margin: 0px; padding: 0px;"><img src="'. $ext_dir. '/Paper_ol.png"></td>'
.'<td style="background-image:url('. $ext_dir. '/Paper_o.png); background-repeat:repeat-x; border: 0px; margin: 0px; padding: 0px;"></td>'
.'<td width=34 height=34 valign="top" style="background-image:url('. $ext_dir. '/Paper_r.png); border: 0px; margin: 0px; padding: 0px;"><img src="'. $ext_dir. '/Paper_or.png"></td>'
.'</tr>'
.'<tr>'
.'<td style="background-image:url('. $ext_dir. '/Paper_l.png); background-repeat:repeat-y; border: 0px; margin: 0px; padding: 0px;"> &nbsp; </td>'
.'<td style="border: 0px; margin: 0px; padding: 0px; background-color:#FBE7BD;" bgcolor="#fbe7bd">' . $outputObj->getText() . '</td>'
.'<td style="background-image:url('. $ext_dir. '/Paper_r.png); border: 0px; margin: 0px; padding: 0px; border: 0px; margin: 0px; padding: 0px;"></td>'
.'</tr>'
.'<tr>'
.'<td width=34 height=34 valign="top" style="background-image:url('. $ext_dir. '/Paper_l.png); border: 0px; margin: 0px; padding: 0px;"><img src="'. $ext_dir. '/Paper_ul.png"></td>'
.'<td style="background-image:url('. $ext_dir. '/Paper_u.png); background-repeat:repeat-x; border: 0px; margin: 0px; padding: 0px;"></td>'
.'<td width=34 height=34 valign="top" style="background-image:url('. $ext_dir. '/Paper_r.png); border: 0px; margin: 0px; padding: 0px;"><img src="'. $ext_dir. '/Paper_ur.png"></td>'
.'</tr>'
.'</table>';

     return $output;
 }
?>
