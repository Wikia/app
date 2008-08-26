<?php


$wgExtensionFunctions[] = "wfAAmazon";

function wfAAmazon() 
{
    global $wgParser;
    # register the extension with the WikiText parser
    # the first parameter is the name of the new tag.
    # In this case it defines the tag <example> ... </example>
    # the second parameter is the callback function for
    # processing the text between the tags
    $wgParser->setHook( "amazon", "AAmazon" );
}

# The callback function for converting the input text to HTML output
function AAmazon( $input ) 
{
	global $wgOut;

	if($input=="")
		return '<iframe src="http://rcm-de.amazon.de/e/cm?t=opwiki-21&o=3&p=36&l=st1&mode=books-de&search=Eiichiro%20Oda&=1&fc1=&lt1=_blank&lc1=&bg1=&f=ifr" marginwidth="0" marginheight="0" width="600" height="520" border="0" frameborder="0" style="border:none;" scrolling="no"></iframe>';
	else
	{
		$isbn=$input;
		$temp=explode("-",$input);
		$num=implode("",$temp);
		$output='<a href="http://www.amazon.de/exec/obidos/redirect?link_code=ur2&tag=opwiki-21&camp=1638&creative=6742&path=ASIN%2F' . $num . '">' . $isbn . "</a>";
		
		return $output;

	}
}
?>
