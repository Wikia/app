<?php
// require_once 'PHPUnit/Framework/Assert.php';
// require_once '../files/utils.php';

function assertPageExist( $server, $pageName ) {
    $rev = file_get_contents( $server . '/api.php?action=query&prop=info&titles=' . $pageName . '&format=php' );
    $rev =  unserialize( $rev );
    $count = count( end( $rev['query']['pages'] ) );
    PHPUnit_Framework_Assert::assertTrue( $count > 3,
        'Page ' . $pageName . ' does not exist on ' . $server );
}

function assertContentEquals( $server1, $server2, $pageName ) {
    $contentPage1 = getContentPage( $server1, $pageName );
    $contentPage2 = getContentPage( $server2, $pageName );
    PHPUnit_Framework_Assert::assertEquals( $contentPage1, $contentPage2,
        'content page ' . $pageName . ' is not equals between ' . $server1 . ' and ' . $server2 );
}

function assertContentPatch( $server, $patchId, $clock, $pageName, $op, $previousPatch ) {
    $patchName = substr( $patchId, 0, -strlen( $clock -1 ) );
    $patch = getSemanticRequest( $server, '[[patchID::' . $patchId, '-3FonPage/-3FhasOperation/-3Fprevious' );

    PHPUnit_Framework_Assert::assertEquals( $pageName, $patch[0] );
    if ( strtolower( substr( $patch[2], 0, strlen( 'Patch:' ) ) ) == 'patch:' ) {
        $patch[2] = substr( $patch[2], strlen( 'patch:' ) );
    }
    PHPUnit_Framework_Assert::assertEquals( strtolower( $previousPatch ), strtolower( substr( $patch[2], 0, -1 ) ),
        'Previous patch on patch ' . $patchId . ' must be but is ' . $patch[2] );

    $opFound = explode( ',', $patch[1] );
    PHPUnit_Framework_Assert::assertTrue( count( $op[$pageName] ) == count( $opFound ),
        'Patch ' . $patchId . ' must contains ' . count( $op[$pageName] ) . ' operations but ' . count( $opFound ) . ' operations were found' );

    for ( $j = 0 ; $j < count( $opFound ) ; $j++ ) {
        $o = str_replace( ' ', '', $opFound[$j] );
        $opi = explode( ';', $o );
        PHPUnit_Framework_Assert::assertEquals( strtolower( substr( $patchName . ( $clock ), strlen( 'patch:' ) ) ), strtolower( $opi[0] ),
            'Operation id on patch ' . $patchId . ' must be ' . $patchName . ( $clock ) . ' but ' . strtolower( $opi[0] ) . ' was found' );
        $a = strtolower( $op[$pageName][$j][strtolower( $opi[1] )] );
        $b = strtolower( utils::contentDecoding( $opi[3] ) );
        PHPUnit_Framework_Assert::assertEquals( strtolower( $op[$pageName][$j][strtolower( $opi[1] )] ), strtolower( utils::contentDecoding( $opi[3] ) ) );
        $clock = $clock + 1;
    }
}

/*function assertCSFromPushIncluded($serverPush,$pushName,$serverPull,$pullName) {
    $pushhead = getSemanticRequest($serverPush, '[[name::PushFeed:'.$pushName, '-3FhasPushHead');
    $pushhead = substr($pushhead[0],0,-1);
    $pullhead = getSemanticRequest($serverPull, '[[name::PullFeed:'.$pullName, '-3FhasPullHead');
    $pullhead = substr($pullhead[0],0,-1);
    PHPUnit_Framework_Assert::assertEquals($pushhead, $pullhead,
        'failed pullHead in pull '.$pullName.', pullHead must be '.$pushHead.' but '.$pullHead.' was found');
    assertPageExist($serverPull,$pullhead);
}*/

function getContentPage( $server, $pageName ) {
    $php = file_get_contents( $server . '/api.php?action=query&prop=revisions&titles=' . $pageName . '&rvprop=content&format=php' );
    $array = $php = unserialize( $php );
    $array = $array['query']['pages'];
    $array = array_shift( $array );

    $content = $array['revisions'][0]["*"];
    return( $content );
}

function getSemanticRequest( $server, $request, $param, $sep = '!' ) {
    $request = utils::encodeRequest( $request );
    $url = $server . '/index.php/Special:Ask/' . $request . '/' . $param . '/format=csv/sep=' . $sep . '/limit=100';
    $php = file_get_contents( $server . '/index.php/Special:Ask/' . $request . '/' . $param . '/headers=hide/format=csv/sep=' . $sep . '/limit=100' );
    $array = explode( $sep, substr( $php, 0, -1 ) );
    if ( count( $array ) == 1 ) {
        return $array;
    }
    $arrayRes[] = $array[1];
    for ( $i = 2 ; $i < count( $array ) ; $i++ ) {
        $arrayRes[] = ereg_replace( '"', '', $array[$i] );
    }
    return $arrayRes;
}

function getPatchXML( $server, $patchId ) {
    $url = $server . '/api.php?action=query&meta=patch&papatchId=' . $patchId . '&format=xml';
    $patchContent = file_get_contents( $server . '/api.php?action=query&meta=patch&papatchId=' . $patchId . '&format=xml' );
    $dom = new DOMDocument();
    $dom->loadXML( $patchContent );
    return $dom;
}

    function arraytolower( $array ) {
        foreach ( $array as $key => $value ) {
            $array[$key] = strtolower( $value );
        }
        return $array;
    }

?>
