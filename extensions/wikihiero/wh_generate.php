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

include "wh_main.php";

if(array_key_exists("lang", $_GET)) {
	$lang = $_GET["lang"];
} else {
	$lang = "fr";
}
?>
<html lang=<?php echo htmlspecialchars( $lang ); ?>>
  <head>
    <title>WikiHiero - Table generator</title>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="/favicon.ico">
  </head>
  <body bgcolor="#DDDDDD">

    <big><?php echo "WikiHiero v".WH_VER_MAJ.".".WH_VER_MED.".".WH_VER_MIN; ?></big>

    <br /><br />Parsing hieroglyph files and creating tables...<br /><br />

    <?php

    $wh_prefabs = "\$wh_prefabs = array(\n";
    $wh_files   = "\$wh_files   = array(\n";

    $img_dir = dirname(__FILE__) . '/img/';

    if(is_dir($img_dir))
    {
      if ($dh = opendir($img_dir))
      {
        while (($file = readdir($dh)) !== false) 
        {
          if(stristr($file, WH_IMG_EXT))
          {
            list($width, $height, $type, $attr) = getimagesize($img_dir.$file);
            $wh_files .= "  \"".WH_GetCode($file)."\" => array( $width, $height ),\n";
            if(strchr($file,'&'))
              $wh_prefabs .= "  \"".WH_GetCode($file)."\",\n";
          }
        }
        closedir($dh);
      }
    }

    $wh_prefabs .= ");";
    $wh_files .= ");";

    echo "<pre>$wh_prefabs<br /><br />";
    echo "$wh_files<br /><br /></pre>";

    $file = fopen("wh_list.php", "w+");
    fwrite($file, "<?php\n\n");
    fwrite($file, "// File created by wh_generate.php version ".WH_VER_MAJ.".".WH_VER_MED.".".WH_VER_MIN."\n");
    fwrite($file, "// ".date("Y/m/d at H:i")."\n\n");
    fwrite($file, "global \$wh_prefabs, \$wh_files;\n\n");
    fwrite($file, "$wh_prefabs\n\n");
    fwrite($file, "$wh_files\n\n");
    fwrite($file, "?>");
    fclose($file);

    //if(file_exists("wh_list(0).php"))

    ?>

    <small><?php echo WH_Credit(); ?></small>

  </body>
</html>
