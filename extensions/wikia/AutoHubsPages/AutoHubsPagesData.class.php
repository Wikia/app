<?php 

class AutoHubsPagesData{
	public function __construct($tag,$tagID,$lang){
		
	}
	
	public function topWikis($limit = 5,$day = 7){
		return 
			array(
				array( "wikiname" => "test", "count"  => 5,"wiki_url" => "#"  ),
				array( "wikiname" => "test", "count"  => 5,"wiki_url" => "#"  ),
				array( "wikiname" => "test", "count"  => 5,"wiki_url" => "#"  ),
				array( "wikiname" => "test", "count"  => 5,"wiki_url" => "#"  ),
				array( "wikiname" => "test", "count"  => 5,"wiki_url" => "#"  ),
			);	
	}
	
	public function topBlogs($limit = 3,$day = 7){
		return 
			array(
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game', 'wiki' => "testuser1", "level" => 5, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game',  'wiki' => "testuser1", "level" => 4, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game',  'wiki' => "testuser1", "level" => 3, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game',  'wiki' => "testuser1", "level" => 2, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game',  'wiki' => "testuser1", "level" => 1, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
			);			
	}  
	
	public function hotSpots($limit = 5,$day = 3){
		return 
			array(
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game', 'wiki' => "testuser1", "level" => 5, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game',  'wiki' => "testuser1", "level" => 4, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game',  'wiki' => "testuser1", "level" => 3, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game',  'wiki' => "testuser1", "level" => 2, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
				array( 'real_pagename' => 'tra lal la ', 'db' => 'dbname', 'hub' => 'game',  'wiki' => "testuser1", "level" => 1, "count"  => 5,"wiki_url" => "#", "page_url" => "#"  ),
			);			
	}
	
	public function topEditors($limit = 5,$day = 3){
		return 
			array(
				array( 'username' => "testuser1", "level" => 5, "count"  => 5, "href" => "#"  ),
				array( 'username' => "testuser2", "level" => 4, "count"  => 4, "href" => "#"  ),
				array( 'username' => "testuser3", "level" => 3, "count"  => 3, "href" => "#"  ),
				array( 'username' => "testuser4", "level" => 2, "count"  => 2, "href" => "#"  ),
				array( 'username' => "testuser5", "level" => 1, "count"  => 1, "href" => "#"  ),
			);	
	}
	
	static function newFromTagTitle(Title &$title){
		$out = new AutoHubsPagesData(0,0,0);
		return $out;
	}
	
	static function newFromTagID($tagID){
		$out = new AutoHubsPagesData();
		return $out;
	}
}