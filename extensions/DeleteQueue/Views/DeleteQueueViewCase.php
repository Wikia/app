<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die;
}

class DeleteQueueViewCase extends DeleteQueueView {
	function show( $params ) {
		global $wgOut, $wgUser, $wgLang;

		$dqi = DeleteQueueItem::newFromId( $params[1] );

		if ( !$dqi ) {
			$wgOut->setPageTitle( wfMsg( 'deletequeue-case-no-case-title' ) );
			$wgOut->addWikiMsg( 'deletequeue-case-no-case', $params[1] );
			return;
		}

		$wgOut->setPageTitle( wfMsg( 'deletequeue-case-title' ) );

		$wgOut->addWikiMsg( 'deletequeue-case-intro' );

		if ( wfTimestamp( TS_UNIX, $dqi->getExpiry() ) < time() &&
				$wgUser->isAllowed( $dqi->getQueue() . '-review' )
		) {
			$wgOut->addWikiMsg(
				'deletequeue-case-needs-review',
				$this->getTitle( "case/" . $params[1] . "/review" )
			);
		}

		// Show basic data
		$sk = $wgUser->getSkin();
		$fields = array();
		$fields['deletequeue-case-page'] = $sk->link( $this->getTitle() );
		$fields['deletequeue-case-reason'] =
			DeleteQueueInterface::formatReason( null, $dqi->getReason() );

		$expiry = $dqi->getExpiry();
		if ( $expiry ) {
			$fields['deletequeue-case-expiry'] = $wgLang->timeanddate( $expiry );
		}
		$fields['deletequeue-case-votes'] = $dqi->formatVoteCount();

		$wgOut->addHTML(
			Xml::element( 'h2', null, wfMsg( 'deletequeue-case-details' ) ) .
			Xml::buildForm( $fields ) .
			Xml::element( 'h2', null, wfMsg( 'deletequeue-case-votes' ) )
			);
		$article = $dqi->getArticle();
		$this->showVotes( $article, $dqi );
	}

	/**
	 * Show current votes.
	 * @param $article Article object to show votes for.
	 */
	public function showVotes( $article, $dqi ) {
		global $wgOut, $wgUser, $wgRequest, $wgLang;

		$case_id = $dqi->getCaseId();
		$sk = $wgUser->getSkin();
		$article_name = $article->mTitle->getPrefixedText();

		$wgOut->addWikiMsg( 'deletequeue-showvotes-text', $article_name );

		$restrict_type = $wgRequest->getText( 'votetype' );

		if ( $restrict_type == 'none' || !$restrict_type ) {
			$restrict_type = '';
		} else {
			$wgOut->setSubTitle(
				wfMsg( "deletequeue-showvotes-showingonly-$restrict_type" )
			);
		}

		// Add "view only X" links
		$restrictableActions = array( 'none', 'endorse', 'object' );
		$restrictions = Xml::openElement( 'ul' );
		foreach ( $restrictableActions as $raction ) {
			$text = wfMsgExt( "deletequeue-showvotes-restrict-$raction", 'parseinline' );
			$link = $sk->link(
					$this->getTitle( "case/$case_id" ),
					$text,
					array(),
					array( 'votetype' => $raction )
				);
			$restrictions .= "\n<li>$link</li>";
		}
		$restrictions .= Xml::closeElement( 'ul' );

		$wgOut->addHTML( $restrictions );

		// Sort votes by user.
		$votes = $dqi->getVotes();

		$votesByUser = array();

		foreach ( $votes as $vote ) {
			$user = $vote['user'];

			if ( $restrict_type && $restrict_type != $vote['type'] )
				continue;

			if ( !isset( $votesByUser[$user] ) ) {
				$votesByUser[$user] = array();
			}

			$votesByUser[$user][] = $vote;
		}

		// Link batch.
		$lb = new LinkBatch();
		foreach ( array_keys( $votes ) as $user ) {
			$lb->add( NS_USER, $user );
			$lb->add( NS_USER_TALK, $user );
		}

		$voteDisplay = array();

		if ( count( $votesByUser ) == 0 ) {
			$suffix = $restrict_type ? "-$restrict_type" : '';
			$wgOut->addWikiMsg( "deletequeue-showvotes-none$suffix" );
		}

		// Display
		foreach ( $votesByUser as $user => $votes ) {
			$id = User::idFromName( $user );
			$user = $sk->userLink( $id, $user ) . '&nbsp;' .
				$sk->userToolLinks( $id, $user );

			$userVotes = array();

			foreach ( $votes as $vote ) {
				$type = $vote['type'];
				$comment = $sk->commentBlock( $vote['comment'] );
				$timestamp = $wgLang->timeanddate( $vote['timestamp'] );
				$thisvote = wfMsgExt(
					"deletequeue-showvotes-vote-$type",
					array( 'parseinline', 'replaceafter' ),
					$timestamp,
					$comment
				);

				if ( $vote['current'] == 0 )
					$thisvote = Xml::tags( 's', null, $thisvote );

				$userVotes[] = Xml::tags( 'li', array( 'class' => "mw-deletequeue-vote-$type" ), $thisvote );
			}

			$uv = $user . Xml::tags( 'ul', null, implode( "\n", $userVotes ) );
			$voteDisplay[] = Xml::tags( 'li', null, $uv );
		}

		$wgOut->addHTML( Xml::tags( 'ol', null, implode( "\n", $voteDisplay ) ) );
	}
}
