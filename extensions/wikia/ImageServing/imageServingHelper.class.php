<?php
/*
 * Author: Tomek Odrobny
 * Class to serving list of top 5 images for article
 */
class imageServingHelper{
	static private $hookOnOff = false; // parser hook are off 
	
	public static function buildIndexOnPageEdit( $self ) {
		wfProfileIn(__METHOD__);
		$article = Article::newFromID( $self->mId );
		self::buildAndGetIndex( $article );
		wfProfileOut(__METHOD__);
		return true;
	}
	
	public static function buildAndGetIndex(Article $article) {
		wfProfileIn(__METHOD__);
		global $wgHooks;
		$startTime = Time();
		$articleText = $article->getRawText();
		$title = $article->getTitle();
		$content = $article->getContent();
		self::hookSwitch();
		$editInfo = $article->prepareTextForEdit( $content, $title->getLatestRevID() );
		self::hookSwitch(false);
		$out = array();
		preg_match_all("/(?<=(image mw=')).*(?=')/U", $editInfo->output->getText(), $out ); 
		self::bulidIndex($article->getID(), $out[0], true);
		wfProfileOut(__METHOD__);
	}
	
	/* hook replace images with some easy to parse tag :*/
	public static function replaceImages( $skin, $title, $file, $frameParams, $handlerParams, $time, $res ) {
		if (!self::$hookOnOff) {
			return true;
		}
		wfProfileIn(__METHOD__);
		
		$res = " <image mw='".$title->getDBKey()."' /> ";
		
		wfProfileOut(__METHOD__); 
		return false;
	}
	
	/* hook replace images with some easy to parse tag :*/
	public static function replaceGallery( $parser, $ig) {
		if (!self::$hookOnOff) {
			return true;
		}
		wfProfileIn(__METHOD__);
		$ig->parse();
		$data = $ig->getData();
		$res = "";
		foreach ( $ig->mImages  as $title ) {
			$res .= " <image mw='".$title[0]->getDBKey()."' /> "; 
		}
		
		$ig = new fakeIGimageServing( $res );
		wfProfileOut(__METHOD__);
		return false;
	}
	
	private static function hookSwitch($onOff = true) {
		self::$hookOnOff = $onOff;
	}
	
	private static function bulidIndex($articleId, $images, $ignoreEmpty = false) {
		/* 0 and 1 image don't need to be indexed */
		wfProfileIn(__METHOD__);
		$db = wfGetDB(DB_MASTER, array());
		if( (count($images) < 2) ) {
			if ($ignoreEmpty) {
				return true;	
				wfProfileOut(__METHOD__);
			}
			$db->delete( 'page_wikia_props', 
				array(		
					'page_id' =>  $articleId,
					'propname' => "imageOrder")
			);
			return true;
			wfProfileOut(__METHOD__);
		}
		
		$db->replace('page_wikia_props','',
			array(
				'page_id' =>  $articleId,
				'propname' => "imageOrder",
				'props' => serialize($images)
			)
		);
		wfProfileOut(__METHOD__);
		return true;
	}
}

/* fake class for replace image gallery in hook*/
class fakeIGimageServing {
	private $out;

	function __construct($in) {
		$this->out = $in; 	
	}

	function toHTML() {
		return $this->out;
	}	
}