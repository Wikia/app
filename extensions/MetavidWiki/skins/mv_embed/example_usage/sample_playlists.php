<?php
do_sample_page();

function do_sample_page(){
// sample embed page (this could be plain html its a php script so that we can grab its location)
$mv_path = 'http://' . $_SERVER['SERVER_NAME'] . substr( $_SERVER['REQUEST_URI'], 0, strrpos( $_SERVER['REQUEST_URI'], '/' ) ) . '/';
$mv_path = str_replace( 'example_usage/', '', $mv_path );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>sample playlist usage</title>
 	<script type="text/javascript" src="<?php echo htmlspecialchars( $mv_path ) ?>mv_embed.js?urid=<?php echo time()?>"></script> 	
</head>
<body>
<h3> Sample Playlists</h3>
The <b>default attributes:</b>:
<span id="default_attr">
<?
$sample_embed = array();

// playlist tags:
$sample_embed[4]['tag'] = '<playlist id="playlist1" width="400" height="300"
src="sample_xspf.xml" controls="true" embed_link="true"/>';
$sample_embed[4]['desc'] = '<b>xspf</b> static xiph playlist <a href="http://metavid.org/wiki/index.php/Dorganisms">Dorganisms</a> <br /> <iframe width="500" height="200"
		src="sample_xspf.xml">xiph playlist disp here</iframe>';

$plurl = 'http://metavid.org/overlay/archive_browser/rss_filter_view?filters[0][type]=match&filters[0][val]=peace&start=0&rpp=10';
$sample_embed[5]['tag'] = '<playlist id="playlist2"
src="' . $plurl . '"/>';
$sample_embed[5]['desc'] = '<b>RSS</b> a podcast like dynamic feed for "peace"<br />' .
		'<iframe width="500" height="200" src="' . $plurl . '">rss feed here</iframe>';

$plurl = 'http://metavid.org/m3u/filters/filter_seq?filters[0][type]=match&filters[0][val]=war&start=0&rpp=10';
$sample_embed[6]['tag'] = '<playlist id="warplaylist" src="' . $plurl . '"/>';
// $sample_embed[6]['desc'] = '<b>m3u</b> dynamic playlist search for "war"<br /> <textarea cols="70" rows="9">'.file_get_contents($plurl).'</textarea>';


// sample smil
$smilURL = 'fresh_smil_load.php';
$sample_embed[8]['tag'] = '<playlist id="smil_pl" src="' . $smilURL . '" />';
$sample_embed[8]['desc'] = ' <br /><b>Crossfading Videos</b><br /><a href="http://service.real.com/help/library/guides/realone/ProductionGuide/HTML/htmfiles/transit.htm">source</a>
			The first video fades up from green when it starts to play, 
			and the second video fades down to green when it ends. 
			When the first video stops and the second video starts, 
			though, the two videos crossfade into each other' .
				'<br />' .
				'<iframe width="500" height="200" src="' . $smilURL . '">rss feed here</iframe>';

$smilURL = 'http://'.$_SERVER['SERVER_NAME'].'/wiki/index.php/Special:MvExportSequence/Test';
$sample_embed[9]['tag'] = '<playlist src="' . $smilURL . '" />';
$sample_embed[9]['desc'] = ' <br /><b>MediaWiki example:</b><br />'.
				'<br />' .
				'<iframe width="500" height="200" src="' . $smilURL . '">rss feed here</iframe>';

// empty sample embed (to only do one:)
// $sample_embed = array();
// $sample_embed[0]['tag']='<sequencer style="width:640px;height:480px;"/>';
// $sample_embed[0]['desc']='a video sequencer';

?>
  <table border="1" cellpadding="6" width="600">
  	<?php foreach ( $sample_embed as $key => $aval ) {
  		//  &&
  		if ( $key != 8 )continue;
  	 ?>
	    <tr>
	      <td valign="top"><?php echo $aval['tag']?></td>
	      <td valign="top"><b>Sample Embed <?php echo $key?></b><br />
	      <?php echo $aval['desc']?><br />
	      &lt;-- code used: <br />
	     <pre> <?php echo htmlentities( $aval['tag'] )?></pre>
	      </td>
	    </tr>
	    <?php // oput a separator between video and playlist
	    if ( $key == 5 ) {
	    	echo '<tr><td colspan="2"><b>Sample Playlists:</b></td></tr>';
	    }
   } ?>
  </table>
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />&nbsp;
  </body>
</html>
<?php
}
?>
