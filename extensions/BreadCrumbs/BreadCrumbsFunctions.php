<?php

# The BreadCrumbs extension, an extension for providing an breadcrumbs
# navigation to users.

# @addtogroup Extensions
# @author Manuel Schneider <manuel.schneider@wikimedia.ch>
# @copyright © 2007 by Manuel Schneider
# @licence GNU General Public Licence 2.0 or later

if( !defined( 'MEDIAWIKI' ) ) {
  echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
  die();
}

function fnBreadCrumbsShowHook( &$m_pageObj ) {
  global $wgTitle;
  global $wgOut;
  global $wgUser;
  global $wgBreadCrumbsDelimiter;
  global $wgBreadCrumbsCount;
  
  # deserialize data from session into array:
  $m_BreadCrumbs = array();
  if( isset( $_SESSION['BreadCrumbs'] ) ) $m_BreadCrumbs = $_SESSION['BreadCrumbs'];
  # cache index of last element:
  $m_count = count( $m_BreadCrumbs ) - 1;

  # check for doubles:
  if( $m_count < 1 || $m_BreadCrumbs[ $m_count ] != $wgTitle->getPrefixedText() ) {
    if( $m_count >= 1) {
      # reduce the array set, remove older elements:
      $m_BreadCrumbs = array_slice( $m_BreadCrumbs, ( 1 - $wgBreadCrumbsCount ) );
    }
    # add new page:
    array_push( $m_BreadCrumbs, $wgTitle->getPrefixedText() );
  }
  # serialize data from array to session:
  $_SESSION['BreadCrumbs'] = $m_BreadCrumbs;
  # update cache:
  $m_count = count( $m_BreadCrumbs ) - 1;

  # acquire a skin object:
  $m_skin =& $wgUser->getSkin();
  # build the breadcrumbs trail:
  $m_trail = '<div id="BreadCrumbsTrail">';
  for( $i = 0; $i <= $m_count; $i++ ) {
    $m_trail .= $m_skin->makeLink( $m_BreadCrumbs[$i] );
    if( $i < $m_count ) $m_trail .= $wgBreadCrumbsDelimiter;
  }
  $m_trail .= '</div>';
  $wgOut->addHTML( $m_trail );

  # invalidate internal MediaWiki cache:
  $wgTitle->invalidateCache();
  $wgUser->invalidateCache();

  # Return true to let the rest work:
  return true;
}

## Entry point for the hook for printing the CSS:
function fnBreadCrumbsOutputHook( &$m_pageObj, &$m_parserOutput ) {
  global $wgScriptPath;

  # Register CSS file for our select box:
  $m_pageObj->addLink(
    array(
      'rel'   => 'stylesheet',
      'type'  => 'text/css',
      'href'  => $wgScriptPath . '/extensions/BreadCrumbs/BreadCrumbs.css'
    )
  );

  # Be nice:
  return true;
}
