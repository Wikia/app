<?php
# Example WikiMedia extension
# with WikiMedia's extension mechanism it is possible to define
# new tags of the form
# <TAGNAME> some text </TAGNAME>
# the function registered by the extension gets the text between the
# tags as input and can transform it into arbitrary HTML code.
# Note: The output is not interpreted as WikiText but directly
#       included in the HTML output. So Wiki markup is not supported.
# To activate the extension, include it from your LocalSettings.php
# with: include("extensions/YourExtensionName.php");

$wgHooks['ParserFirstCallInit'][] = "screenshotExtension";

function screenshotExtension( $parser ) {
    $parser->setHook( "screenshot", "showScreenshot" );
    return true;
}

function showScreenshot( $input, $argv, &$parser )
{
  if(!$argv["name"])
    return "";

  $dom = strtolower($argv["name"]);

  if(ereg("[^-0-9.a-z]", $dom))
    return "";

  $img = "/websites/${dom[0]}/${dom[1]}/$dom.jpg";

  if(!file_exists("/var/www/htdocs.www.websitewiki.de/$img"))
    $img = "/skins/noscreenshot.png";

    $output = "<a href=\"http://www.$dom\" rel=\"nofollow\" alt=\"www.$dom\" title=\"www.$dom\" target=\"_new\"><img src=\"$img\" border=0></a>";
    return $output;
}
