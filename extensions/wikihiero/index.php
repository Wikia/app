<?php

//////////////////////////////////////////////////////////////////////////
//
// WikiHiero - A PHP convert from text using "Manual for the encoding of 
// hieroglyphic texts for computer input" syntax to HTML entities (table and
// images).
//
// Copyright (C) 2004 Guillaume Blanchard (Aoineko)
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
//////////////////////////////////////////////////////////////////////////

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) { 
	$IP = dirname( __FILE__ ) .'/../..';
}
require( "$IP/includes/WebStart.php" );

require('wh_language.php');
require('wikihiero.php');
#
# Initialization from request
#

# FIXME : use webRequest
if(isset($_POST["text"]))
	$text = $_POST["text"];
else
	$text = "anx-G5-zmA:tA:tA-nbty-zmA:tA:tA-sw:t-bit:t-<-zA-ra:.-mn:n-T:w-Htp:t*p->-anx-D:t:N17-!";

if(isset($_POST["scale"]))
	$scale = $_POST["scale"];
else
	$scale = $wh_scale;

if(isset($_POST["mode"]))
	$mode = $_POST["mode"];
else
	$mode = $wh_mode;

if(isset($_POST["lang"]))
	$lang = $_POST["lang"];
else if(isset($_GET["lang"]))
	$lang = $_GET["lang"];
else
	$lang = "fr";

if(isset($_POST["line"]))
	$line = $_POST["line"];
else
	$line = false;

#
# Various functions
#

function WH_Text( $index ) {
	global $wh_language;
	global $lang;

	if(isset($wh_language[$index])) {
		if(isset($wh_language[$index][$lang]))
			return $wh_language[$index][$lang];
		else
			return $wh_language[$index]["en"];
	}
	return '';
}

function WH_Packet( $ext ) {
	if(file_exists("wikihiero.$ext")) {
	    $size = filesize("wikihiero.$ext");
	    if($size <= 1024*1024) {
		      return sprintf("<a href=\"wikihiero.$ext\" title=\"%.2f Kb\">%s</a>", filesize("wikihiero.$ext")/1024, strtoupper($ext));
	    } else {
    	  return sprintf("<a href=\"wikihiero.$ext\" title=\"%.2f Mb\">%s</a>", filesize("wikihiero.$ext")/(1024*1024), strtoupper($ext));
		}
	} else {
		return "<font title=\"File <wikihiero.$ext> not found!\">".strtoupper($ext)."</font>";
	}
}

function WH_Table( $table ) {
	global $lang;
	$url = "wh_table.php?table=" . urlencode( $table ) . '&lang=' . urlencode( $lang );
	$encUrl = htmlspecialchars( Xml::encodeJsVar( $url ) );
	echo "<a href=\"#\" onClick=\"MyWindow=window.open($encUrl,'$table','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=300,left=20,top=20'); return false;\" title =\"".WH_Text($table)."\">$table</a>";
}

#
# Main code
#

$start_time = microtime();
list($a_dec, $a_sec) = explode(" ", $start_time);
$html = WikiHiero($text, $mode, $scale, $line);
list($b_dec, $b_sec) = explode(" ", microtime());
$process_time = sprintf("%0.3f sec", $b_sec - $a_sec + $b_dec - $a_dec);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
  <TITLE>WikiHiero</TITLE>
  <META http-equiv="Content-type" content="text/html; charset=UTF-8">
  <META name="Author" content="Guillaume Blanchard">
  <META name="Copyright" content="&copy; 2004 Guillaume Blanchard, Under free GNU Public Licence">
  <LINK rel="shortcut icon" href="/favicon.ico">
  <SCRIPT type="text/javascript">

    function LangLink(l)
    {
      document.wh_form.lang.value = l
      document.wh_form.submit()
    }

    function DisableScale(l)
    {
      document.wh_form.scale.disabled = l
    }

  </SCRIPT>
</HEAD>
<BODY style="background: #DDDDDD">

  <TABLE border="0">
  <TR valign="top"><TD>
 
    <BIG><?php echo "WikiHiero v".WH_VER_MAJ.".".WH_VER_MED.".".WH_VER_MIN; ?></BIG><br />
    <SMALL>[<?php 

      reset($wh_language['Lang']);
      while($l = current($wh_language['Lang']))
      {
        if(key($wh_language['Lang']) == $lang) 
          echo "<b>$l</b>";
        else
          echo "<a href=\"javascript:LangLink('".key($wh_language['Lang'])."');\">$l</a>";
        next($wh_language['Lang']);
        if($l = current($wh_language['Lang']))
          echo " | ";
      }
    ?>]</SMALL>
    <br /><br />

    <form name="wh_form" action="index.php?lang=<?php echo $lang; ?>" method="post">
      <textarea name="text" cols="60" rows="10" title="<?php echo WH_Text("Text"); ?>"><?php echo $text; ?></textarea>
      <br /><br />
      <input type="submit" title="<?php echo WH_Text("Convert"); ?>" value="<?php echo WH_Text("Convert"); ?>">
      <select title="<?php echo WH_Text("Mode"); ?>" name="mode">
        <option value="0" <?php if($mode==0) echo "selected"; ?> title="<?php echo WH_Text("TEXT");  ?>" onclick="javascript:DisableScale(true);">Text only
        <option value="1" <?php if($mode==1) echo "selected"; ?> title="<?php echo WH_Text("HTML");  ?>" onclick="javascript:DisableScale(false);">Simple HTML
        <option disabled value="2" <?php if($mode==2) echo "selected"; ?> title="<?php echo WH_Text("CSS");   ?>">HTML & CSS
        <option disabled value="3" <?php if($mode==3) echo "selected"; ?> title="<?php echo WH_Text("Image"); ?>">Image
      </select> 
      <?php echo WH_Text("Scale"); ?><input type="range" name="scale" <?php if($mode==0) echo "disabled"; ?> title="<?php echo WH_Text("Size"); ?>" min="1" max="999" size="3" maxlength="3" value="<?php echo htmlspecialchars( $scale ); ?>">%
      <?php echo WH_Text("Line"); ?><input type="checkbox" name="line" <?php if($line) echo "checked"; ?>>
      <input type="hidden" name="lang" value="<?php echo htmlspecialchars( $lang ); ?>">
    </form>

  </td><td valign="top">

  <b><?php echo WH_Text("Syntax"); ?></b><br />
    <tt>-</tt> <?php echo WH_Text("-"); ?><br />
    <tt>:</tt> <?php echo WH_Text(":"); ?><br />
    <tt>*</tt> <?php echo WH_Text("*"); ?><br />
    <tt>!</tt> <?php echo WH_Text("!"); ?><br />

    <br />
    <b><?php echo WH_Text("Tables"); ?></b><br />
    <?php WH_Table("Phoneme"); ?>
    | <?php WH_Table("A"); ?>
    | <?php WH_Table("B"); ?>
    | <?php WH_Table("C"); ?>
    | <?php WH_Table("D"); ?>
    | <?php WH_Table("E"); ?>
    | <?php WH_Table("F"); ?>
    | <?php WH_Table("G"); ?>
    | <?php WH_Table("H"); ?>
    | <?php WH_Table("I"); ?>
    | <?php WH_Table("J"); ?>
    | <?php WH_Table("K"); ?>
    | <?php WH_Table("L"); ?>
    | <?php WH_Table("M"); ?>
    | <?php WH_Table("N"); ?>
    | <?php WH_Table("O"); ?>
    | <?php WH_Table("P"); ?>
    | <?php WH_Table("Q"); ?>
    | <?php WH_Table("R"); ?>
    | <?php WH_Table("S"); ?>
    | <?php WH_Table("T"); ?>
    | <?php WH_Table("U"); ?>
    | <?php WH_Table("V"); ?>
    | <?php WH_Table("W"); ?>
    | <?php WH_Table("X"); ?>
    | <?php WH_Table("Y"); ?>
    | <?php WH_Table("Z"); ?>
    | <?php WH_Table("Aa"); ?>
    | <?php WH_Table("All"); ?>
    <br /><br />

    <b><?php echo WH_Text("Download"); ?></b><br />
    [<?php echo WH_Packet("rar"); ?>] - 
    [<?php echo WH_Packet("zip"); ?>] -
    <a href="README">ReadMe</a>

  </td></tr>
  </table>

  <br />
  <b>Images</b><br />
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-style:solid; border-width:1px; padding:1em; border-color:gray; background:#ffffff;">
  <tr valign="middle"><td>

  <?php echo $html; ?>

  </td></tr>
  </table>

  <br />
  <b>Source</b><br />
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-style:solid; border-width:1px; padding:1em; border-color:gray; background:#ffffff;">
  <tr valign="middle"><td>

  <pre><?php echo htmlentities($html); ?></pre>

  </td></tr>
  </table>

  <br />
  <table align="right"><tr><td>
  <a href="http://www.mozilla.org/products/firefox/" title="Get Firefox - The free browser">
  <img src="http://www.mozilla.org/products/firefox/buttons/getfirefox_88x31.png"
  width="88" height="31" border="0" alt="Get Firefox - The free browser"></a> 
  </td></tr></table>
  <small><?php echo "Parsing duration: $process_time"; ?></small>

  <br /><br />
  <small><?php echo WH_Credit(); ?></small>
</body>
</html>
