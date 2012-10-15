<?php
// sample embed page (this could be plain html its a php script so that we can grab its location)
do_testing_page();

function do_testing_page(){
	$mv_path = 'http://' . $_SERVER['SERVER_NAME'] . substr( $_SERVER['REQUEST_URI'], 0, strrpos( $_SERVER['REQUEST_URI'], '/' ) ) . '/';
	$mv_path = str_replace( 'example_usage/', '', $mv_path );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>sample mv embed</title>
 	<script type="text/javascript" src="../mv_embed.js?urid=<?php echo time()?>&debug=true"></script>
</head>
<body>
<h3>testing embed</h3>
  <table border="1" cellpadding="6" width="600">
	    <tr>
	      <td valign="top">
	      	<video src="http://192.168.1.235/wiki/extensions/MetavidWiki/skins/mv_embed/example_usage/sample_eclipse.ogg" poster="sample_eclipse.jpg" duration="7"></video>
	      </td>
	      <td valign="top"><b>Test embed</b><br />
	      </td>
	    </tr>	    
  </table>
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />&#160;
  </body>
</html>
<?php
}

