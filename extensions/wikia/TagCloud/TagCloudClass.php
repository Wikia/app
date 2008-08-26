<?php

class TagCloud {
	var $tags_min_pts = 8;
	var $tags_max_pts = 32;
	var $tags_highest_count = 0;
	var $tags_size_type = "pt";

	public function __construct($limit=10) {
		$this->limit = $limit;
		$this->initialize();
	}

	public function initialize(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT replace(replace(cl_to,'_News',''),'_Opinions','') as cl_to, count(*) as count FROM {$dbr->tableName( 'categorylinks' )} cl1 
			GROUP BY cl_to
			ORDER BY
			count DESC
			LIMIT 0,{$this->limit}";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$tag_name = Title::makeTitle( 14, $row->cl_to);
			$tag_text = $tag_name->getText();
			if( strtotime( $tag_text  ) == "" ){ //dont want dates to show up
				if($row->count > $this->tags_highest_count)$this->tags_highest_count = $row->count;
				$this->tags[ $tag_text ] = array("count" => $row->count);
			}
		}

		//sort tag array by key (tag name)
		if ($this->tags_highest_count == 0) return ;
		ksort($this->tags);
		/* and what if we have _1_ category? like on a new wiki with nteen articles, mhm? */
		if ($this->tags_highest_count == 1) {
			$coef = $this->tags_max_pts - $this->tags_min_pts ;	
		} else {
			$coef = ($this->tags_max_pts - $this->tags_min_pts)/(($this->tags_highest_count-1) * 2) ;
		}
		foreach ($this->tags as $tag => $att) {
			$this->tags[$tag]["size"] = $this->tags_min_pts + ($this->tags[$tag]["count"] - 1) * $coef ;
		}
	 }
}

?>
