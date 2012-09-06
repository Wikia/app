<?php

class CommentCSV {

	public static function onCommentCSVDownload( $action, $article ) {
		global $wgOut, $wgUser, $wgArticleCommentsNamespaces;

		if ( $action !== 'commentcsv'
			|| !in_array( $article->getTitle()->getNamespace(), $wgArticleCommentsNamespaces ) ) {
			return true;
		}

		if ( !$wgUser->isAllowed( 'commentcsv' ) ) {
			throw new PermissionsError( 'commentcsv' );
		}

		if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $wgUser->mBlock );
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		$title = $article->getTitle();

		$csvText = self::getCsvText( $title );

		$wgOut->setArticleBodyOnly( true );
		self::setDownloadHeaders( $csvText );

		$wgOut->addHTML( $csvText );

		return false;
	}

	private static function getCsvText( $title ) {
		global $wgMemc, $wgCityId;

		$memkey = __METHOD__ . ":" . $wgCityId . ":" . $title->getPrefixedText();
		$cached = $wgMemc->get( $memkey );

		if ( empty( $cached ) ) {
			$articleC = ArticleCommentList::newFromTitle( $title );
			$comments = $articleC->getCommentPages( false, false );

			$csvArr = array(
				array( 'timestamp', 'username', 'comment', 'URL', 'reply to' )
			);

			foreach( $comments as $commentArr ) {
				if ( isset( $commentArr['level1'] ) && $commentArr['level1'] instanceof ArticleComment ) {
					$comment = $commentArr['level1']->getData( false );
					$csvArr[] = array(
						$comment['rawtimestamp'],
						$comment['username'],
						$comment['rawtext'],
						$commentArr['level1']->getTitle()->getFullURL()
					);
				}
				if ( isset( $commentArr['level2'] ) ) {
					foreach ( $commentArr['level2'] as $commentId => $reply ) {
						if ( $reply instanceof ArticleComment ) {
							$commentReply = $reply->getData( false );
							$csvArr[] = array(
								$commentReply['rawtimestamp'],
								$commentReply['username'],
								$commentReply['rawtext'],
								$reply->getTitle()->getFullURL(),
								$commentArr['level1']->getTitle()->getFullURL()
							);
						}
					}
				}
			}

			$csvHandle = fopen( 'php://temp', 'w' );
			foreach ( $csvArr as $fields ) {
				fputcsv( $csvHandle, $fields );
			}
			rewind( $csvHandle );
			$csvText = stream_get_contents( $csvHandle );
			fclose( $csvHandle );

			$wgMemc->set( $memkey, $csvText, 60 * 60 );
		} else {
			$csvText = $cached;
		}

		return $csvText;
	}

	private static function setDownloadHeaders( $output ) {
		header("Content-Description: File Transfer");

		//Use the switch-generated Content-Type
		header("Content-Type: text/plain");
		header("Content-Disposition: attachment; filename=\"comment-digest.csv\"");

		//Force the download
		header("Content-Transfer-Encoding: utf-8");
		header("Content-Length: " . strlen( $output ) );
	}
}
