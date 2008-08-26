<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This file is for MediaWiki platform, cannot be used standalone.\n";
    exit( 1 ) ;
}


class WikiListPager extends TablePager {
    var $mFieldNames = null;
    var $mMessages = array();
    var $mQueryConds = array();

    #--- constructor
    function __construct()
    {
        global $wgRequest, $wgMiserMode;
        if ( $wgRequest->getText( 'sort', 'img_date' ) == 'img_date' ) {
            $this->mDefaultDirection = true;
        } else {
            $this->mDefaultDirection = false;
        }
        $search = $wgRequest->getText( 'ilsearch' );
        if ( $search != '' && !$wgMiserMode ) {
            $nt = Title::newFromUrl( $search );
            if( $nt ) {
                $dbr = wfGetDB( DB_SLAVE );
                $m = $dbr->strencode( strtolower( $nt->getDBkey() ) );
                $m = str_replace( "%", "\\%", $m );
                $m = str_replace( "_", "\\_", $m );
                $this->mQueryConds = "";
             }
        }
        parent::__construct();
    }

    function getFieldNames()
    {
        if ( !$this->mFieldNames ) {
            $this->mFieldNames = array(
                'city_id' => wfMsg( "wf_city_id" ),
                'city_url' => wfMsg( "wf_city_url" ),
                'city_lang' => wfMsg( "wf_city_lang" ),
                'city_public' => wfMsg( "wf_city_public" ),
                'city_title' => wfMsg( "wf_city_title" ),
                'city_created' => wfMsg( "wf_city_created" ),
            );
        }
        return $this->mFieldNames;
    }

    function isFieldSortable( $field ) {
        static $sortable = array( "city_url", "city_public", "city_id", "city_lang" );
        return in_array( $field, $sortable );
    }

    function getDefaultSort() {
        return 'city_id';
    }

    function formatValue( $field, $value ) {
        global $wgLang;
        switch ( $field ) {
            case "city_url":
                $title = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
                preg_match("/http:\/\/([^\/]+)/", $value, $match );
                $link = sprintf("%s/%s", $title->getFullUrl(), strtolower( $match[1] ));
                return sprintf("<a href=\"%s\">%s</a>", $link, $value);
                break;
            case "city_public":
                switch($value) {
                    case 0:
                        return "<span style=\"color:#fe0000;font-weight:bold;font-size:small;\">disabled</span>";
                        break;
                    case 1:
                        return "<span style=\"color:darkgreen;font-weight:bold;font-size:small;\">enabled</span>";
                        break;
                    case 2:
                        return "<span style=\"color: #0000fe;font-weight:bold;font-size:small\">redirected</span>";
                        break;
                }
                break;
            default: return $value;
        }
    }

    function getQueryInfo() {
        $fields = $this->getFieldNames();
        unset( $fields['links'] );
        $fields = array_keys( $fields );
        return array(
            'tables' => 'city_list',
            'fields' => $fields,
            'conds' => $this->mQueryConds
        );
    }

    function getForm() {
        global $wgRequest, $wgMiserMode;
        $url = $this->getTitle()->escapeLocalURL();
        $search = $wgRequest->getText( 'ilsearch' );
        $s = "<form method=\"get\" action=\"$url\">\n" .
        wfMsgHtml( 'table_pager_limit', $this->getLimitSelect() );
        if ( !$wgMiserMode ) {
            $s .= "<br/>\n" .
            Xml::inputLabel( wfMsg( 'imagelist_search_for' ), 'ilsearch', 'mw-ilsearch', 20, $search );
        }
        $s .= " " . Xml::submitButton( wfMsg( 'table_pager_limit_submit' ) ) ." \n" .
            $this->getHiddenFields( array( 'limit', 'ilsearch' ) ) .
            "</form>\n";
        return $s;
    }
}
?>
