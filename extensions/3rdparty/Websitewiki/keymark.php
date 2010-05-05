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

$wgExtensionFunctions[] = "keymarkExtension";

function keymarkExtension() {
    global $wgParser;
    # register the extension with the WikiText parser
    # the first parameter is the name of the new tag.
    # In this case it defines the tag <example> ... </example>
    # the second parameter is the callback function for
    # processing the text between the tags
    $wgParser->setHook( "keywords", "renderKeypage" );
}

# The callback function for converting the input text to HTML output
function renderKeypage( $input, $argv, &$parser ) {
    # $argv is an array containing any arguments passed to the
    # extension like <example argument="foo" bar>..
    # Put this on the sandbox page:  (works in MediaWiki 1.5.5)
    #   <example argument="foo" argument2="bar">Testing text **example** in between the new tags</example>

    $kwline = trim(html_entity_decode($input, ENT_QUOTES, "UTF-8"));

    $tok = strtok($kwline, ",;");

    $kws = array();
    while ($tok !== false)
    {
      $kws[] = strtolower(trim($tok));
      $tok = strtok(",;");
    }
    $kws = array_unique($kws);
    // var_dump($kws);
    $output = "<span class=\"small\">";

    $komma = "";
    if(count($kws))
      foreach($kws as $kw) {
		if(strlen($kw) > 80) {
			$kw = substr($kw, 0, 80);
		}

		$kwu = $kw;
		$kwu{0} = strtoupper($kwu{0});


		$output .= sprintf( "$komma<a href=\"%s\">%s</a>",
			Title::makeTitle( NS_SPECIAL, sprintf( "Keyword/%s", $kw )  )->getLocalURL(),
			$kwu
		);

		$komma = ", ";
	}

    $output .= "</span>\n";
    return $output;
}
