<?php

class SimplePie_First_Item_Description_Test_RSS_20_Atom_10_Content extends SimplePie_First_Item_Description_Test
{
	function data()
	{
		$this->data = 
'<rss version="2.0" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:content>Item Description</a:content>
		</item>
	</channel>
</rss>';
	}
	
	function expected()
	{
		$this->expected = 'Item Description';
	}
}

?>