<?php

if( !defined( 'MEDIAWIKI' ) ) 
{
  echo( "This file is an extension to the MediaWiki software, and cannot be used standalone.\n" );
  die( 1 );
}

function fnwswEditHook($ea) { 
    global $wgOut, $exDomainList;

    $newpage = $ea->mArticle->mTitle->mTextform;

    if($ea->mArticle->exists()) {
      return true;
    }

    if($ea->mArticle->mTitle->mNamespace == NS_MAIN && eregi($exDomainList, $newpage)) {

	$wgOut->redirect( Title::newFromText( 'NewWebsite', NS_SPECIAL )->getFullURL( "param=$newpage" ), 307 );

	return false;
    } else {
      return true;
    }
}
