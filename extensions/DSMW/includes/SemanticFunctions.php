<?php

/**
 * @author jean-philippe muller
 * @copyright INRIA-LORIA-ECOO project
 */

/**
 * Returns an array of page titles received via the request
 *
 * @global <String> $wgServerName
 * @global <String> $wgScriptPath
 * @param <String> $request
 * @return <array>
 */
function getRequestedPages( $request ) {

        $results = array();
        $res = utils::getSemanticQuery( $request );
        if ( $res === false ) return false;
        $count = $res->getCount();
        for ( $i = 0; $i < $count; $i++ ) {

            $row = $res->getNext();
            if ( $row === false ) break;
            $row = $row[0];

            $col = $row->getContent();// SMWResultArray object
            foreach ( $col as $object ) {// SMWDataValue object
                $wikiValue = $object->getWikiValue();
                $results[] = $wikiValue;
            }
        }

        return $results;
}

/**
 *Gets the semantic request stored in the PushFeed page
 *
 * @global <String> $wgServerName
 * @global <String> $wgScriptPath
 * @param <String> $pfName pushfeed name
 * @return <String>
 */
function getPushFeedRequest( $pfName ) {

    $results = array();
    $res = utils::getSemanticQuery( '[[' . $pfName . ']]', '?hasSemanticQuery' );// PullFeed:PullBureau
    if ( $res === false )return false;
    $count = $res->getCount();
    for ( $i = 0; $i < $count; $i++ ) {

        $row = $res->getNext();
        if ( $row === false ) break;
        $row = $row[0];

        $col = $row->getContent();// SMWResultArray object
        foreach ( $col as $object ) {// SMWDataValue object
            $wikiValue = $object->getWikiValue();
            $results[] = $wikiValue;
        }
    }

    $value = utils::decodeRequest( $results[0] );
    return $value;
}

/**
 *Gets the previous changeSet ID (in the push action sequence)
 * @global <String> $wgServerName
 * @global <String> $wgScriptPath
 * @param <String> $pfName PushFeed name
 * @return <String> previous changeSet ID
 */
// function getPreviousCSID($pfName) {
//    global $wgServerName, $wgScriptPath;
//    $url = 'http://'.$wgServerName.$wgScriptPath.'/index.php';
//    $req = '[[ChangeSet:+]] [[inPushFeed::'.$pfName.']]';
//    $req = utils::encodeRequest($req);
//    $url = $url."/Special:Ask/".$req."/-3FchangeSetID/headers=hide/order=desc/format=csv/limit=1";
//    $string = file_get_contents($url);
//    if ($string=="") return false;
//    $string = explode(",", $string);
//    $string = $string[0];
//    $string = str_replace(',', '', $string);
//    $string = str_replace("\"", "", $string);
//    return $string;
// }

/**
 * Gets the published patches
 *
 * @global <String> $wgServerName
 * @global <String> $wgScriptPath
 * @param <String> $pfname PushFeed name
 * @return <array> array of the published patches' name
 */
function getPublishedPatches( $pfname ) {

    $results = array();
    $res = utils::getSemanticQuery( '[[ChangeSet:+]] [[inPushFeed::' . $pfname . ']]', '?hasPatch' );// PullFeed:PullBureau
    if ( $res === false ) return false;
    $count = $res->getCount();
    for ( $i = 0; $i < $count; $i++ ) {

        $row = $res->getNext();
        if ( $row === false ) break;
        $row = $row[1];

        $col = $row->getContent();// SMWResultArray object
        foreach ( $col as $object ) {// SMWDataValue object
            $wikiValue = $object->getWikiValue();
            $results[] = $wikiValue;
        }
    }
    $results = array_unique( $results );
    return $results;
}

/**
 *In a pushfeed page, the value of [[hasPushHead::]] has to be updated with the
 *ChangeSetId of the last generated ChangeSet
 *
 * @param <String> $name Pushfeed name
 * @param <String> $CSID ChangeSetID
 * @return <boolean> returns true if the update is successful
 */

function updatePushFeed( $name, $CSID ) {
// split NS and name
    preg_match( "/^(.+?)_*:_*(.*)$/S", $name, $m );
    $articleName = $m[2];

    // get PushFeed by name
    $title = Title::newFromText( $articleName, PUSHFEED );
    $dbr = wfGetDB( DB_SLAVE );
    $revision = Revision::loadFromTitle( $dbr, $title );
    $pageContent = $revision->getText();

    // get hasPushHead Value if exists
    $start = "[[hasPushHead::";
    $val1 = strpos( $pageContent, $start );
    if ( $val1 !== false ) {// if there is an occurence of [[hasPushHead::
        $startVal = $val1 + strlen( $start );
        $end = "]]";
        $endVal = strpos( $pageContent, $end, $startVal );
        $value = substr( $pageContent, $startVal, $endVal - $startVal );

        // update hasPushHead Value
        $result = str_replace( $value, $CSID, $pageContent );
        $pageContent = $result;
        if ( $result == "" )return false;
    } else {// no occurence of [[hasPushHead:: , we add
        $pageContent .= ' hasPushHead: [[hasPushHead::' . $CSID . ']]';
    }
    // save update
    $article = new Article( $title );
    $article->doEdit( $pageContent, $summary = "" );

    return true;
}

/**
 * Gets the last changeset(haspullhead) linked with the given pullfeed
 *
 * @global <String> $wgServerName
 * @global <String> $wgScriptPath
 * @param <String> $pfName pullfeed name
 * @return <String or bool> false if no pullhead
 */
function getHasPullHead( $pfName ) {// pullfeed name with ns

    $results = array();
    $res = utils::getSemanticQuery( '[[PullFeed:+]] [[name::' . $pfName . ']]', '?hasPullHead' );
    if ( $res === false ) return false;
    $count = $res->getCount();
    for ( $i = 0; $i < $count; $i++ ) {

        $row = $res->getNext();
        if ( $row === false ) break;
        $row = $row[1];

        $col = $row->getContent();// SMWResultArray object
        foreach ( $col as $object ) {// SMWDataValue object
            $wikiValue = $object->getWikiValue();
            $results[] = $wikiValue;
        }
    }
    if ( empty ( $results ) ) return false;
    else return $results[0];
}

/**
 * Gets the last changeset(haspushhead) linked with the given pushfeed
 *
 *
 * @global <String> $wgServerName
 * @global <String> $wgScriptPath
 * @param <String> $pfName pushfeed name
 * @return <String or bool> false if no pushhead
 */
function getHasPushHead( $pfName ) {// pushfeed name with ns

    $results = array();
    $res = utils::getSemanticQuery( '[[PushFeed:+]] [[name::' . $pfName . ']]', '?hasPushHead' );
    if ( $res === false ) return false;
    $count = $res->getCount();
    for ( $i = 0; $i < $count; $i++ ) {

        $row = $res->getNext();
        if ( $row === false ) break;
        $row = $row[1];

        $col = $row->getContent();// SMWResultArray object
        foreach ( $col as $object ) {// SMWDataValue object
            $wikiValue = $object->getWikiValue();
            $results[] = $wikiValue;
        }
    }
    if ( empty ( $results ) ) return false;
    else return $results[0];
}

/**
 *Gest the name of the push where the pullfeed has subscribed
 *
 * @global <type> $wgServerName
 * @global <type> $wgScriptPath
 * @param <type> $name pullfeed name
 * @return <type> pushfeed name
 */
function getPushName( $name ) {// pullfeed name with NS

    $results = array();
    $res = utils::getSemanticQuery( '[[PullFeed:+]] [[name::' . $name . ']]', '?pushFeedName' );
    if ( $res === false ) return false;
    $count = $res->getCount();
    for ( $i = 0; $i < $count; $i++ ) {

        $row = $res->getNext();
        if ( $row === false ) break;
        $row = $row[1];

        $col = $row->getContent();// SMWResultArray object
        foreach ( $col as $object ) {// SMWDataValue object
            $wikiValue = $object->getWikiValue();
            $results[] = $wikiValue;
        }
    }
    if ( empty ( $results ) ) return false;
    else return $results[0];
}

/**
 * Gets the URL of the pushfeed where the pullfeed has subscribed
 *
 * @global <String> $wgServerName
 * @global <String> $wgScriptPath
 * @param <String> $name pullfeed name
 * @return <String> Pushfeed Url
 */
function getPushURL( $name ) {// pullfeed name with NS

    $results = array();
    $res = utils::getSemanticQuery( '[[PullFeed:+]] [[name::' . $name . ']]', '?pushFeedServer' );
    if ( $res === false ) return false;
    $count = $res->getCount();
    for ( $i = 0; $i < $count; $i++ ) {

        $row = $res->getNext();
        if ( $row === false ) break;
        $row = $row[1];

        $col = $row->getContent();// SMWResultArray object
        foreach ( $col as $object ) {// SMWDataValue object
            $wikiValue = $object->getWikiValue();
            $results[] = $wikiValue;
        }
    }
    if ( empty ( $results ) ) return false;
    else return $results[0];
}
/**
 *In a pullfeed page, the value of [[hasPullHead::]] has to be updated with the
 *ChangeSetId of the last pulled ChangeSet
 *
 * @param <String> $name Pullfeed name (with namespace)
 * @param <String> $CSID ChangeSetID (without namespace)
 * @return <boolean> returns true if the update is successful
 */
function updatePullFeed( $name, $CSID ) {
// split NS and name
    preg_match( "/^(.+?)_*:_*(.*)$/S", $name, $m );
    $articleName = $m[2];

    // get PushFeed by name
    $title = Title::newFromText( $articleName, PULLFEED );
    $dbr = wfGetDB( DB_SLAVE );
    $revision = Revision::loadFromTitle( $dbr, $title );
    $pageContent = $revision->getText();

    // get hasPushHead Value if exists
    $start = "[[hasPullHead::";
    $val1 = strpos( $pageContent, $start );
    if ( $val1 !== false ) {// if there is an occurence of [[hasPushHead::
        $startVal = $val1 + strlen( $start );
        $end = "]]";
        $endVal = strpos( $pageContent, $end, $startVal );
        $value = substr( $pageContent, $startVal, $endVal - $startVal );

        // update hasPullHead Value
        $result = str_replace( $value, $CSID, $pageContent );
        $pageContent = $result;
        if ( $result == "" )return false;
    } else {// no occurence of [[hasPushHead:: , we add
        $pageContent .= ' hasPullHead: [[hasPullHead::' . $CSID . ']]';
    }
    // save update
    $article = new Article( $title );
    $article->doEdit( $pageContent, $summary = "" );

    return true;
}
