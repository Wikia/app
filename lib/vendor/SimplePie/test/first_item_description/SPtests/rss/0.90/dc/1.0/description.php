<?php

class SimplePie_First_Item_Description_Test_RSS_090_DC_10_Description extends SimplePie_First_Item_Description_Test
{
	function data()
	{
		$this->data = 
'<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<item>
		<dc:description>Item Description</dc:description>
	</item>
</rdf:RDF>';
	}
	
	function expected()
	{
		$this->expected = 'Item Description';
	}
}

?>