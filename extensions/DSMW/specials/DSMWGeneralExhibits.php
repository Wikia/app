<?php

/**
 * DSMW Special page
 *
 * TODO: only load when SRF is available?
 *
 * @copyright INRIA-LORIA-SCORE Team
 * 
 * @author  jean-Philippe Muller
 */
class DSMWGeneralExhibits extends SpecialPage {

	public function __construct() {
		parent::__construct( 'DSMWGeneralExhibits', 'delete' );
    }

    public function getDescription() {
        return wfMsg( 'dsmw-special-exhibits' );
    }

    /**
     * Executed when the user opens the "DSMW general exhibits" special page
     * Displays information about DSMW, e.g. all the DSMW PushFeeds in a timeline
     * (This special page works only when the Semantic Results Format extension is installed)
     *
     * There are 3 links used to see informations about Patches, PullFeeds or PushFeeds
     */
    public function execute() {
        global $wgOut, $wgRequest, $wgUser;

		if ( !$this->userCanExecute( $wgUser ) ) {
			// If the user is not authorized, show an error.
			$this->displayRestrictionError();
			return;
		}        
        
        $output = '<p>This page displays general informations about Distributed Semantic MediaWiki.</p>';

        $returntitle1 = Title::makeTitle( NS_SPECIAL, 'DSMWGeneralExhibits' );
        $output .= '<b><a href="' . htmlspecialchars( $returntitle1->getFullURL() ) . '?action=pushdisplay">[PushFeed data] </a></b>';

        $returntitle1 = Title::makeTitle( NS_SPECIAL, 'DSMWGeneralExhibits' );
        $output .= '<b><a href="' . htmlspecialchars( $returntitle1->getFullURL() ) . '?action=pulldisplay">[PullFeed data] </a></b>';

        $returntitle1 = Title::makeTitle( NS_SPECIAL, 'DSMWGeneralExhibits' );
        $output .= '<b><a href="' . htmlspecialchars( $returntitle1->getFullURL() ) . '?action=patchdisplay">[Patches data] </a></b>';


        $action = $wgRequest->getText( 'action' );

        switch ( $action ) {
            case "pushdisplay":
                $wikitext = '
==PushFeeds==
{{#ask: [[PushFeed:+]]
|?name
|?modification date
|?pushFeedServer
|?pushFeedName
|?hasPushHead
| format=exhibit
| views=timeline, table, tabular
| sort=modification date
| timelineHeight=400
|facets=modification date
|limit=500
}}
';
                break;
            case "pulldisplay":
                $wikitext = '
==PullFeeds==
{{#ask: [[PullFeed:+]]
|?name
|?modification date
|?pushFeedName
|?pushFeedServer
| format=exhibit
| views=timeline, table, tabular
| sort=modification date
| timelineHeight=400
|facets=modification date
|limit=500
}}
';
                break;
            case "patchdisplay":
                $wikitext = '
==Patches==
{{#ask: [[Patch:+]]
|?patchID
|?modification date
|?onPage
|?previous
| format=exhibit
| views=timeline, table, tabular
| sort=modification date
| timelineHeight=400
|facets=onPage, modification date
|limit=500
}}
';
                break;

            default:
                $wikitext = '
==Patches==
{{#ask: [[Patch:+]]
|?patchID
|?modification date
|?onPage
|?previous
| format=exhibit
| views=timeline, table, tabular
| sort=modification date
| timelineHeight=400
|facets=onPage, modification date
|limit=500
}}
';
                break;
        }

        $wgOut->addHTML( $output );
        $wgOut->addWikiText( $wikitext );

        return false;
	}

}
