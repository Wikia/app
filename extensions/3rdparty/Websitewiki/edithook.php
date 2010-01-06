<?php

if( defined( 'MEDIAWIKI' ) ) 
{

  function fnwswEditHook($ea)
  { 
    $newpage = $ea->mArticle->mTitle->mTextform;


    $title = Title::newFromUrl($ea->mArticle->mTitle->mUrlform);
    if(is_object($title) && $title->exists()) 
    {
      return true;
    }


/***   Google auto insert
    if(strstr($_SERVER['HTTP_USER_AGENT'], "Googlebot"))
      return true;
***/

    if($ea->mArticle->mTitle->mNamespace == NS_MAIN && eregi("^[0-9a-z-]+\.(de$)|(at$)|(ch$)", $newpage))
    {
      sleep(3);
      neue_website($newpage);
      header("Location: http://www.websitewiki.de/" . $ea->mArticle->mTitle->mUrlform, 307);
      exit;
    }
    else
      return true;
  } 

}
else 
{
  echo( "This file is an extension to the MediaWiki software, and cannot be used standalone.\n" );
  die( 1 );
}

?>
