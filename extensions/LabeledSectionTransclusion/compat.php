<?php

/**

This file contains compatability functions for other extensions which may
have called them, primarily DynamicPageList2.  This file is not used by the
Labeled Section Transclusion extension, but is provided to insulate other
extensions from code refactoring.

**/

///Fetch the page to be transcluded from the database.
function wfLst_fetch_($parser, $page, $ns = NS_MAIN) 
{
  $title = Title::newFromText($page,$ns);
  if ( !is_null( $title ) ) {
    $text = $parser->fetchTemplate($title);
  }
  return $text;
}


function wfLstIncludeHeading2($parser, $page='', $sec='', $to='') 
{
  return wfLstIncludeHeading($parser, $page, $sec, $to);
}


