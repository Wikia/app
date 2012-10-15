<?php
/**
 * @author jean-philippe muller & Morel Émile
 * @copyright INRIA-LORIA-ECOO project
 */

/**
 * A ChangeSet has patches which has operations
 * this function is used to integrate these operations
 * It's a local changeSet (downloaded from a remote site)
 * @param <String> $changeSetId with NS
 */
function integrate( $changeSetId, $patchIdList, $relatedPushServer, $csName ) {
// global $wgScriptExtension;
// $patchIdList = getPatchIdList($changeSetId);
//  $lastPatch = utils::getLastPatchId($pageName);
    global $wgServerName, $wgScriptPath, $wgScriptExtension, $wgOut;
    $urlServer = 'http://' . $wgServerName . $wgScriptPath . "/index.php/$csName";
    wfDebugLog( 'p2p', ' - function integrate : ' . $changeSetId );
    $i = 1;
    $j = count( $patchIdList );
    $pages = array();
    foreach ( $patchIdList as $patchId ) {
        $name = 'patch';
        $sub = substr( $patchId, 6, 3 );
        wfDebugLog( 'p2p', '  -> patchId : ' . $patchId );
        if ( !utils::pageExist( $patchId ) ) {// if this patch exists already, don't apply it
            wfDebugLog( 'p2p', '      -> patch unexist' );
            $url = utils::lcfirst( $relatedPushServer ) . "/api.php?action=query&meta=patch&papatchId=" . $patchId . '&format=xml';
            wfDebugLog( 'p2p', '      -> getPatch request url ' . $url );
            $patch = utils::file_get_contents_curl( $url );

            /*test if it is a xml file. If not, the server is not reachable via the url
             * Then we try to reach it with the .php5 extension
            */
            if ( strpos( $patch, "<?xml version=\"1.0\"?>" ) === false ) {
                $url = utils::lcfirst( $relatedPushServer ) . "/api.php5?action=query&meta=patch&papatchId=" . $patchId . '&format=xml';
                wfDebugLog( 'p2p', '      -> getPatch request url ' . $url );
                $patch = utils::file_get_contents_curl( $url );
            }
            if ( strpos( $patch, "<?xml version=\"1.0\"?>" ) === false ) $patch = false;

            if ( $patch === false ) throw new MWException( __METHOD__ . ': Cannot connect to Push Server (Patch API)' );
            $patch = trim( $patch );
            wfDebugLog( 'p2p', '      -> patch content :' . $patch );
            $dom = new DOMDocument();
            $dom->loadXML( $patch );

            $patchs = $dom->getElementsByTagName( $name );

            // when the patch is not found, mostly when the id passed
            // through the url is wrong
            if ( empty ( $patchs ) || is_null( $patchs ) )
                throw new MWException( __METHOD__ . ': Error: Patch not found!' );

            //        $patchID = null;
            foreach ( $patchs as $p ) {
                if ( $p->hasAttribute( "onPage" ) ) {
                    $onPage = $p->getAttribute( 'onPage' );
                }
                if ( $p->hasAttribute( "previous" ) ) {
                    $previousPatch = $p->getAttribute( 'previous' );
                }
                if ( $p->hasAttribute( "siteID" ) ) {
                    $siteID = $p->getAttribute( 'siteID' );
                }
                if ( $p->hasAttribute( "mime" ) ) {
                    $Mime = $p->getAttribute( 'mime' );
                }
                if ( $p->hasAttribute( "size" ) ) {
                    $Size = $p->getAttribute( 'size' );
                }
                if ( $p->hasAttribute( "url" ) ) {
                    $Url = $p->getAttribute( 'url' );
                }
                if ( $p->hasAttribute( "DateAtt" ) ) {
                    $Date = $p->getAttribute( 'DateAtt' );
                }
                if ( $p->hasAttribute( "siteUrl" ) ) {
                    $SiteUrl = $p->getAttribute( 'siteUrl' );
                }
                if ( $p->hasAttribute( "causal" ) ) {
                    $causal = $p->getAttribute( 'causal' );
                }
            }

            $operations = null;
            $op = $dom->getElementsByTagName( 'operation' );
            foreach ( $op as $o )
                $operations[] = $o->firstChild->nodeValue;
            $lastPatch = utils::getLastPatchId( $onPage );
            if ( $lastPatch == false ) $lastPatch = 'none';



            //            foreach ($operations as $operation) {
            //                $operation = operationToLogootOp($operation);
            //                if ($operation!=false && is_object($operation)) {
            //                    logootIntegrate($operation, $onPage);
            //                }
            //            }

            if ( !in_array( $onPage, $pages ) ) {
                $onPage1 = str_replace( array( ' ' ), array( '_' ), $onPage );
                utils::writeAndFlush( "<span style=\"margin-left:60px;\">Page: <A HREF=" . 'http://' . $wgServerName . $wgScriptPath . "/index.php/$onPage1>" . $onPage . "</A></span><br/>" );
                $pages[] = $onPage;
            }
            if ( $sub === 'ATT' ) {
                touch( utils::prepareString( $Mime, $Size, $Url ) );

                $DateLastPatch = utils::getLastAttPatchTimestamp( $onPage );
                // $DateOtherPatch = utils::getOtherAttPatchTimestamp($patchIdList);
                if ( $DateLastPatch == null ) {
                    downloadFile( $Url );
                    $edit = true;
                    utils::writeAndFlush( "<span style=\"margin-left:98px;\">download attachment (" . round( $Size / 1000000, 2 ) . "Mo)</span><br/>" );
                } elseif ( $DateLastPatch < $Date ) {
                    downloadFile( $Url );
                    $edit = true;
                    utils::writeAndFlush( "<span style=\"margin-left:98px;\">download attachment (" . round( $Size / 1000000, 2 ) . "Mo)</span><br/>" );
                } else {
                    newRev( $onPage );
                    $edit = false;
                }
                unlink( utils::prepareString( $Mime, $Size, $Url ) );
            }
            utils::writeAndFlush( "<span style=\"margin-left:80px;\">" . $i . "/" . $j . ": Integration of Patch: <A HREF=" . 'http://' . $wgServerName . $wgScriptPath . "/index.php/$patchId>" . $patchId . "</A></span><br/>" );
            if ( $sub === 'ATT' ) {
                $rev = logootIntegrateAtt( $onPage, $edit );
                if ( $rev > 0 ) {
                    $patch = new DSMWPatch( true, true, $operations, $SiteUrl, $causal, $patchId, $lastPatch, $siteID, $Mime, $Size, $Url, $Date );
                    $patch->storePage( $onPage, $rev );
                } else {
                    throw new MWException( __METHOD__ . ': article not saved!' );
                }
            }

            else {
                $rev = logootIntegrate( $operations, $onPage, $sub );
                if ( $rev > 0 ) {
                    $patch = new DSMWPatch( true, false, $operations, $SiteUrl, $causal, $patchId, $lastPatch, $siteID, null, null, null, null );
                    $patch->storePage( $onPage, $rev );
                }
                else {
                    throw new MWException( __METHOD__ . ': article not saved!' );
                }
            }
        }// end if pageExists
        $i++;
    }
    utils::writeAndFlush( "<span style=\"margin-left:30px;\">Go to <A HREF=" . $urlServer . ">ChangeSet</A></span> <br/>" );
}

/**
 *transforms a string operation from a patch page into a logoot operation
 * insertion or deletion
 * returns false if there is a problem with the type of the operation
 *
 * @param <String> $operation
 * @return <Object> logootOp
 */
function operationToLogootOp( $operation ) {
    wfDebugLog( 'p2p', ' - function operationToLogootOp : ' . $operation );
    $arr = array();
    $res = explode( ';', $operation );
    foreach ( $res as $key => $attr ) {
        $res[$key] = trim( $attr, " " );
    }

    $position = $res[2];
    $position = str_ireplace( '(', '', $position );
    $position = str_ireplace( ')', '', $position );
    $res1 = explode( ' ', $position );
    foreach ( $res1 as $id ) {
        $id1 = explode( ':', $id );
        $idArrray = new LogootId( $id1[0], $id1[1] );
        $arr[] = $idArrray;
    }
    $logootPos = new LogootPosition( $arr );

    //    if(strpos($res[3], '-5B-5B')!==false || strpos($res[3], '-5D-5D')!==false) {
    //        $res[3] = utils::decodeRequest($res[3]);
    //    }
    $res[3] = utils::contentDecoding( $res[3] );
    //    if($res[3]=="") $res[3]="\r\n";

    if ( $res[1] == "Insert" ) {
        $logootOp = new LogootIns( $logootPos, $res[3] );
    }
    elseif ( $res[1] == "Delete" ) {
        $logootOp = new LogootDel( $logootPos, $res[3] );
    }
    else {
        $logootOp = false;
    }
    return $logootOp;
}

/**
 *Integrates the operation(LogootOp) into the article via the logoot algorithm
 *
 * @param <Object> $operation
 * @param <String or Object> $article
 */
function logootIntegrate( $operations, $article ) {
    global $wgCanonicalNamespaceNames;
    $indexNS = 0;
    wfDebugLog( 'p2p', ' - function logootIntegrate : ' . $article );
    $dbr = wfGetDB( DB_SLAVE );
    if ( is_string( $article ) ) {
        // if there is a space in the title, repalce by '_'
        $article = str_replace( " ", "_", $article );

        if ( strpos( $article, ":" ) === false ) {
            $pageid = $dbr->selectField( 'page', 'page_id', array(
                    'page_title' => $article/*WithoutNS*/ ) );
        }
        else {// if there is a namespace
            preg_match( "/^(.+?)_*:_*(.*)$/S", $article, $tmp );
            $articleWithoutNS = $tmp[2];
            $NS = $tmp[1];
            if ( in_array( $NS, $wgCanonicalNamespaceNames ) ) {
                foreach ( $wgCanonicalNamespaceNames as $key => $value ) {
                    if ( $NS == $value ) $indexNS = $key;
                }
            }
            $pageid = $dbr->selectField( 'page', 'page_id', array(
                    'page_title' => $articleWithoutNS, 'page_namespace' => $indexNS ) );
        }
        // get the page namespace
        $pageNameSpace = $dbr->selectField( 'page', 'page_namespace', array(
                'page_id' => $pageid ) );

        /*the ns must not be a pullfeed, pushfeed, changeset or patch namespace.
         If the page name is the same in different ns we can get the wrong
         * page id
        */
        if ( $pageNameSpace == PULLFEED || $pageNameSpace == PUSHFEED ||
                $pageNameSpace == PATCH || $pageNameSpace == CHANGESET
        ) $pageid = 0;


        $lastRev = Revision::loadFromPageId( $dbr, $pageid );
        if ( is_null( $lastRev ) ) {
            $rev_id = 0;
        }
        else $rev_id = $lastRev->getId();

        wfDebugLog( 'p2p', '      -> pageId : ' . $pageid );
        wfDebugLog( 'p2p', '      -> rev_id : ' . $rev_id );
        $title = Title::newFromText( $article );
        $article = new Article( $title );
    }
    else {
        $rev_id = $article->getRevIdFetched();
    }
    $listOp = array();
    // $blobInfo = BlobInfo::loadBlobInfo($rev_id);
    $model = DSMWRevisionManager::loadModel( $rev_id );
    if ( ( $model instanceof boModel ) == false )
        throw new MWException( __METHOD__ . ': model loading problem!' );
    $logoot = new logootEngine( $model );

    foreach ( $operations as $operation ) {
        wfDebugLog( 'p2p', ' - operation : ' . $operation );
        wfDebugLog( 'testlog', ' - operation : ' . $operation );
        $operation = operationToLogootOp( $operation );

        if ( $operation != false && is_object( $operation ) ) {
            $listOp[] = $operation;
            wfDebugLog( 'testlog', ' -> Operation: ' . $operation->getLogootPosition()->toString() );
            // $blobInfo->integrateBlob($operation);
        }// end if
        //    else {
        //        throw new MWException( __METHOD__.': operation problem '.$operation );
        //        wfDebugLog('p2p',' - operation problem : '.$operation);
        //    }
    }// end foreach operations

    $modelAfterIntegrate = $logoot->integrate( $listOp );
    // $revId = utils::getNewArticleRevId();
    $status = $article->doEdit( $modelAfterIntegrate->getText(), $summary = "" );
    $revId = $status->value['revision']->getId();
    DSMWRevisionManager::storeModel( $revId, $sessionId = session_id(), $modelAfterIntegrate, $blobCB = 0 );
    return $revId;
    // sleep(4);
    if ( is_bool( $status ) ) return $status;
    else return $status->isGood();
}

/**
 *Integrates for attachment
 *
 * @param <String> $article
 */
function logootIntegrateAtt( $article, $edit ) {
    $dbr = wfGetDB( DB_SLAVE );
    $title = Title::newFromText( $article );
    $lastRevision = Revision::loadFromTitle( $dbr, $title );
    
    if ( $lastRevision->getPrevious() == null ) {
        $rev_id = 0;
    }
    else {
        $rev_id = $lastRevision->getPrevious()->getId();
    }
    
    $revID = $lastRevision->getId();
    $model = DSMWRevisionManager::loadModel( $rev_id );
    DSMWRevisionManager::storeModel( $revID, $sessionId = session_id(), $model, $blobCB = 0 );
    
    if ( $edit ) {
        $article = new Article( $title );
        $status = $article->doEdit( $model->getText(), $summary = "" );
    }
    return $revID;
}

function downloadFile( $url ) {
    global $wgServerName, $wgServer, $wgContLang, $wgAuth, $wgScriptPath,
    $wgScriptExtension, $wgMemc, $wgRequest;

    $apiUrl = $wgServer . $wgScriptPath . "/api" . $wgScriptExtension;

    $edittoken = $apiUrl . "?action=query&prop=info&intoken=edit&titles=Foo&format=xml";
    $edittoken = utils::file_get_contents_curl( $edittoken );
    $dom = new DOMDocument();
    $dom->loadXML( $edittoken );
    $edittoken = $dom->getElementsByTagName( 'page' );
    
    foreach ( $edittoken as $p ) {
        if ( $p->hasAttribute( "edittoken" ) ) {
            $token = $p->getAttribute( 'edittoken' );
        }
    }
    
    $token = str_replace( "+", "%2B", $token );

//    $url = $patch->getUrl();
    $onPage = preg_split( "/^.*\//", $url );
    $onPage = $onPage[1];
    $onPage = str_replace( array( ' ' ), array( '_' ), $onPage );
    $url = str_replace( array( ':', 'Http', ' ' ), array( '%3A', 'http', '_' ), $url );
    $download = $apiUrl . "?action=upload&filename=" . $onPage . "&url="
            . $url . "&token=" . $token . "&ignorewarnings=1";
    $resp = Http::post( $download );
    libxml_use_internal_errors( true );
    $sxe = simplexml_load_string( $resp );
}

function newRev( $article ) {
    global $wgCanonicalNamespaceNames;
    
    $indexNS = 0;
    $dbr = wfGetDB( DB_SLAVE );

    $article = str_replace( " ", "_", $article );
    preg_match( "/^(.+?)_*:_*(.*)$/S", $article, $tmp );
    $articleWithoutNS = $tmp[2];
    $NS = $tmp[1];
    
    if ( in_array( $NS, $wgCanonicalNamespaceNames ) ) {
        foreach ( $wgCanonicalNamespaceNames as $key => $value ) {
            if ( $NS == $value )
                $indexNS = $key;
        }
    }
    
    $title = Title::newFromText( $article );
    
    if ( !$title->exists() ) {
        $article = new Article( $title );
        $article->doEdit( '', '' );
    } else {
        $lastRevision = Revision::loadFromTitle( $dbr, $title );
        $rev_id = $lastRevision->getPrevious()->getId();
        $revID = $lastRevision->getId();
        $model = DSMWRevisionManager::loadModel( $rev_id );
        $article = new Article( $title );
        $article->quickEdit( $model->getText(), '' );
    }
}
