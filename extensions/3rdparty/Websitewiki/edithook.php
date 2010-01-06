<?php

if( !defined( 'MEDIAWIKI' ) ) 
{
  echo( "This file is an extension to the MediaWiki software, and cannot be used standalone.\n" );
  die( 1 );
}

function fnwswEditHook($ea) { 
    global $wgOut;

    $newpage = $ea->mArticle->mTitle->mTextform;

    $title = Title::newFromUrl($ea->mArticle->mTitle->mUrlform);

    if(is_object($title) && $title->exists()) {
      return true;
    }

    if($ea->mArticle->mTitle->mNamespace == NS_MAIN && eregi("^[0-9a-zA-Z-]+\.(de$)|(at$)|(ch$)|(pl$)", $newpage)) {

	$wgOut->redirect( Title::newFromText( 'NeueWebsite', NS_SPECIAL )->getFullURL( "param=$newpage" ), 307 );

	return false;
    } else {
      return true;
    }
}
