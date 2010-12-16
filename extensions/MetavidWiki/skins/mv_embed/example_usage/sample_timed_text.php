<?
do_sample_page();

function do_sample_page(){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>sample mv embed</title>
 	<script type="text/javascript" src="../mv_embed.js"></script> 	 	 
</head>
<body>
<h3> Mv_Embed Timed Text Examples:</h3>
Click on the little lower right "CC" icon to expose the timed text
<?php
$examples = Array();
//set up tags for easy display:
$roe_url = 'http://metavid.org/w/index.php?title=Special:MvExportStream&stream_name=House_proceeding_07-18-06_00&t=1:23:16/1:23:44&feed_format=roe';
$examples[] = array(  'tag'  => '<video roe="'.$roe_url.'" ></video>',
					  'desc' => 'Metavid based ROE file using CMML<br /> <pre>' .
						htmlspecialchars('<video roe="'.$roe_url.'" ></video>'). '</pre>'.
					  	'<iframe width="600" height="250" src="'.$roe_url.'" ></iframe>'
				);
$srt_tag = ''.
'<video src="sample_fish.ogg" poster="sample_fish.jpg" duration="26">
 	<text category="SUB" lang="en" type="text/x-srt" default="true"
 		title="english SRT subtitles" src="sample_fish_text_en.srt">
 	</text>
 	<text category="SUB" lang="es" type="text/x-srt"
 	 	title="spanish SRT subtitles" src="sample_fish_text_es.srt">
 	</text>
</video>';
$examples[] = array(  'tag'  => $srt_tag,
					  'desc' => '<h4>SRT text tags with languages and categories (ogg only)</h4><br /> ' .
					  	'<pre>' . htmlspecialchars( $srt_tag ) . '</pre>'
				);

?>
 <table border="1" cellpadding="6" width="950">
<?php foreach($examples as $ex){ ?>
 	<tr> 		
 		<td valign="top" width="410">
 			<?php echo $ex['tag'] ?>
 		</td>
 		<td valign="top">
 			<?php echo $ex['desc'] ?>
 		</td>
 	</tr>
<?php }
?>
 </table>
</body>
</html>
<?
}
?>