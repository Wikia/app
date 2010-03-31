<?php
 
$Advertisement = new Advertisement();


$wgHooks['ArticleAfterFetchContent'][] = array( &$Advertisement,'OutputAdvertisementParserHook' );

//test - this purges the article from the cache (and refreshes it)
//$wgHooks['ArticleSaveComplete'][] = array( &$Advertisement,'PurgeArticle' );

class Advertisement
{
  const VERSION = '0.0.1';
 
  //wrapper function for specific hooks (method signature appropriate for certain hook(s)
  public function OutputAdvertisementAfterArticleFetch(&$article, &$content){
    return $this->OutOutputAdvertisement (&$content);
  }
  //wrapper for parser hooks - note that some parser hooks seem to get run more than once!
  public function OutputAdvertisementParserHook($parser, &$text, $stuff=""){
	return $this->OutputAdvertisement (&$text);
  }
  
  public function PurgeArticle(){
	global $wgArticle;
	$page = $wgArticle->getTitle()->getText();
	mail('asylvan@gmail.com','purging '.$page,"test");
	$wgArticle->doPurge();
	return true;
  }
  
  //This function takes a pointer the the pages text - could come from
  //parser, article, etc.  Note that some hooks may or may not render wikitext, so plan accordingly
  public function OutputAdvertisement(&$text ) {
   
     global $wgTitle;// Look in the Title class for handy accessors, also possibly in Article
     global $wgArticle;
     global $wgDBname;
     static $counter=0;
     
	$page = $wgArticle->getTitle()->getText();
	$mainpage = wfMsg('Mainpage');
	//Only show ads in main namespace, but not on the main page , assumes using MediaWiki:Mainpage for name of main page
	if($mainpage == $page || $wgTitle->getNamespace() != 0) return true;
	
	$pageid = $wgTitle->getArticleID();

	$check = "(pageid: $pageid wgDBname: $wgDBname)";

	$text = $text."\n<div id='ad' style='border:1px black solid; padding:3em;'>Advertisement test Here for ".$wgTitle->getText().$check;
	$text .= "<p>Sponsor this page [[Special:Sponsor]]</p>";
	$text .= "<p>". date("c") ."</p></div>"; 
	
    return true;
  }
}
?>