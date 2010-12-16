<?php
// sample embed page (this could be plain html its a php script so that we can grab its location)

do_sample_page();

function do_sample_page(){
	$mv_path = 'http://' . $_SERVER['SERVER_NAME'] . substr( $_SERVER['REQUEST_URI'], 0, strrpos( $_SERVER['REQUEST_URI'], '/' ) ) . '/';
	$mv_path = str_replace( 'example_usage/', '', $mv_path );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>sample mv embed</title>
 	<script type="text/javascript" src="../mv_embed.js"></script>
</head>
<body>
<h3> Sample Embed</h3>
The <b>default attributes:</b>:
<span id="default_attr">
</span> <br />
Your embed type has been detected as: <b><span id="detect_type"></span></b>
<br />
Here are some sample embeds:<br />
<?php
$sample_embed = array();

$sample_embed[0]['tag'] = '<video  id="embed_vid" 
thumbnail="http://metavid.org/wiki/index.php?action=ajax&rs=mv_frame_server&stream_id=501&t=0:01:32&amp;size=400x300" 
roe="http://metavid.org/wiki/index.php?title=Special:MvExportStream&stream_name=House_proceeding_01-28-08&feed_format=roe&t=0:01:32/0:03:20" 
style="width:400px;height:300px" 
controls="true" embed_link="true" >	
	<source type="video/x-flv" src="http://mvbox2.cse.ucsc.edu/mvFlvServer.php/house_proceeding_01-28-08.flv?t=0:01:32/0:03:20"></source>
	<source type="video/ogg" src="http://metavidstorage01.ucsc.edu/media/house_proceeding_01-28-08.ogg?t=0:01:32/0:03:20"></source>
</video>';
$sample_embed[0]['desc'] = 'Sample Similar to metavid usage';


$sample_embed[1]['tag'] = '<video roe="http://metavid.org/wiki/index.php?title=Special:MvExportStream&feed_format=roe&stream_name=Senate_proceeding_06-06-06_1&t=0:07:50/0:09:06">';
$sample_embed[1]['desc'] = 'Demo of json ROE attribute';

$sample_embed[2]['tag'] = '<video id="v2" controls="true" src="sample_fish.ogg?t=0:0:0/0:0:26" poster="sample_fish.jpg"></video>';
$sample_embed[2]['desc'] = 'simple video with controls and thumbnail';


$sample_embed[3]['tag'] = '<video style="width:400px;height:300px" roe="http://metavid.org/w/index.php?title=Special:MvExportStream&stream_name=Senate_proceeding_08-01-07&t=0:05:38/0:05:58&feed_format=roe" ></video>';
$sample_embed[3]['desc'] = 'Demo of ROE only attribute';


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


// real video sample:
$smilURL = 'sample_smil.smil.xml';
$sample_embed[8]['tag'] = '<playlist id="smil_pl" src="' . $smilURL . '">';
$sample_embed[8]['desc'] = ' <br /><b>Crossfading Videos</b><br /><a href="http://service.real.com/help/library/guides/realone/ProductionGuide/HTML/htmfiles/transit.htm">source</a>
			The first video fades up from green when it starts to play, 
			and the second video fades down to green when it ends. 
			When the first video stops and the second video starts, 
			though, the two videos crossfade into each other' .
				'<br />' .
				'<iframe width="500" height="200" src="' . $smilURL . '">rss feed here</iframe>';
// empty sample embed (to only do one:)
// $sample_embed = array();
// $sample_embed[0]['tag']='<sequencer style="width:640px;height:480px;"/>';
// $sample_embed[0]['desc']='a video sequencer';

?>
  <table border="1" cellpadding="6" width="600">
  	<?php foreach ( $sample_embed as $key => $aval ) {
  		// $key!=8 && $key!=3  $key != 0  && $key != 1 &&  && $key!=3
  		if ( $key!=0 && $key!=8 )continue;
  	 ?>
	    <tr>
	      <td valign="top"><?php echo $aval['tag']?></td>
	      <td valign="top"><b>Sample Embed <?php echo $key?></b><br />
	      <?php echo $aval['desc'] ?><br />
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