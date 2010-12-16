<?php
/**
 * All the hooks for DidYouMean
 */
class DidYouMeanHooks {

	# TODO this is called even when editing a new page
	public static function articleNoArticleText( &$article, &$text ) {
		wfDebug( 'HIPP: ' . __METHOD__ . "\n" );
   
		$sees = DidYouMean::lookup( 0, $article->getTitle()->getText() );
   
		sort($sees);
   
		if (count($sees))
			$text = DidYouMean::build_sees($sees) . $text;
   
		return true;
	}

	# this is called when using the Go/Search box but it is not called when entering
	# a URL for a non-existing article
	public static function specialSearchNoResults( $term ) {
		wfDebug( 'HIPP: ' . __METHOD__ . "\n" );
		
		$sees = DidYouMean::lookup( 0, $term );
		
		sort($sees);
   
		if ( count($sees) ) {
			global $wgOut;
			$wgOut->addWikiText( DidYouMean::build_sees($sees) );
		}
		return true;
	}
	
	# this is called per chunk of wikitext, not per article
	public static function parserBeforeStrip( &$parser, &$text, &$stripState ) {
		#wfDebug( 'HIPP: ' . __METHOD__ . "\n" );
   
		# if revisionid is 0 this is not an article chunk
		if( isset( $parser->mDymFirstChunk ) || !$parser->getVariableValue('revisionid') || $parser->getVariableValue('namespace'))
			return true;
   
		$parser->mDymFirstChunk = 'done';
   
		$title = $parser->getTitle();
		$parser->mDymSees = DidYouMean::lookup( $title->getArticleID(), $title->getText() );
   
		if (preg_match( "/{{[sS]ee\|([^}]*)}}/", $text, $see )) {
			wfDebug( "HIPP: see Hit\n" );
			$hasTemplate = true;
			$sees = explode("|", $see[1]);
		} elseif (preg_match( "/{{[xX]see(\|[^}]*)}}/", $text, $see )) {
			wfDebug( "HIPP: xsee Hit\n" );
			$hasTemplate = true;
			preg_match_all( "/\|\[\[([^]|]*)(?:\|([^|]*))?\]\](?: \(([^)]*)\))?/", $see[1], $ma );
			$sees = $ma[1];
		} else {
			wfDebug( "HIPP: (x)see Miss\n" );
			# there's no {{see}} in this chunk of wikitext
			# if this is the 1st chunk of the article itself we can put an empty {{see}} there.
			$hasTemplate = false;
			$sees = array();
		}
   
		# normalize entities and urlencoding to pure utf-8
		foreach ($sees as &$value)
			$value = rawurldecode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
   
		wfDebug( 'HIPP: Parser: ' . implode(', ', $sees) . "\n" );
		wfDebug( 'HIPP: DBase:  ' . implode(', ', $parser->mDymSees) . "\n" );
   
		# add in the stuff from the database lookup
		$sees = array_unique(array_merge($sees, $parser->mDymSees));
		sort($sees);
   
		wfDebug( 'HIPP: Merged: ' . implode(', ', $sees) . "\n" );
   
		# TODO is it better to use $parser->insertStripItem() ?
   
		if (count($sees)) {
			if( !$hasTemplate ) {
				// We need to squish in a fresh copy of the template...
				$text = "{{see|}}\n" . $text;
			}
			$built_sees = DidYouMean::build_sees($sees);
		} else {
			$built_sees = '';
		}
   
		$text = preg_replace(
			'/{{[xX]?[sS]ee\|[^}]*}}/',
			#$built_sees . '<div style="text-decoration:line-through">$0</div>',
			$built_sees,
			$text );
   
		return true;
	}
	
	public static function articleDelete( $article, $user, $reason ) {
		if ($article->getTitle()->getNamespace() != 0 || $article->isRedirect() == true)
			return true;

		DidYouMean::doDelete( $article->getID() );

		return true;
	}
	
	public static function titleMoveComplete( &$title, &$nt, &$wgUser, &$pageid, &$redirid ) {
		$oldtitletext = $title->getText();
		$oldns = $title->getNamespace();
		$newtitletext = $nt->getText();
		$newns = $nt->getNamespace();
   
		wfDebug( 'HIPP: ' . __METHOD__ . "\n" );
   
		if ($oldns != 0 && $newns != 0)
			return true;
   
		# TODO we can't always check if we're moving a redirect because the old article's content
		# TODO  has already been replaced with the redirect to the new title but a
		# TODO  new title's content is still "noarticletext" at this point!
		#$a1 = new Article( $title );
		#$a2 = new Article( $nt );
		#wfDebug( "HIPP: getContent() for isRedirect()\n\tfrom <<<" . $a1->getContent() . ">>>\n\t  to <<<" . $a2->getContent() . ">>>\n" );
		#if ($a1->isRedirect( $a->getContent() )) {
		#	wfDebug( "HIPP: moving a redirect (?)\n" );
		#	return true;
		#}
   
		if ($oldns == 0 && $newns == 0) {
			DidYouMean::doUpdate( $pageid, $newtitletext );
		} elseif ($oldns == 0) {
			DidYouMean::doDelete( $pageid );
		} elseif ($newns == 0) {
			DidYouMean::doInsert( $pageid, $newtitletext );
		}
   
		return true;
	}
	
	# called at action=edit. can detect if we're about to edit a redirect
	public static function alternateEdit( $editpage ) {
		global $wgParser;
   
		if ($editpage->mArticle->isRedirect())
			$wgParser->mDymRedirBeforeEdit = true;
   
		return 1;
	}
	
	# called at end of action=submit
	public static function articleSaveComplete( $article, $user, $text, $summary, $isminor, $dunno1, $dunno2, $flags ) {
		global $wgParser;
   
		if ($article->getTitle()->getNamespace() != 0)
			return true;
   
		if ($article->isRedirect($text)) {
			if (empty( $wgParser->mDymRedirBeforeEdit ) && !($flags & EDIT_NEW))
				DidYouMean::doDelete( $article->getID() );
		} else {
			if (!empty( $wgParser->mDymRedirBeforeEdit ) || $flags & EDIT_NEW)
				DidYouMean::doInsert( $article->getID(), $article->getTitle()->getText() );
		}
   
		$wgParser->mDymRedirBeforeEdit = false;
   
		return true;
	}
	
	public static function articleUndelete( &$title, &$create ) {
   
		if ($create == false || $title->getNamespace() != 0)
			return true;
   
		# TODO it's not possible to detect if the undeleted article is a redirect!
		#$artic1e = new Article( $title );
		#if ($article->isRedirect( $article->getContent() )) {
		#	return true;
		#}
   
		DidYouMean::doInsert( $title->getArticleId(), $title->getText() );
   
		return true;
	}
	
	public static function parserTestTables( &$tables ) {
		$tables[] = 'dympage';
		$tables[] = 'dymnorm';
		return true;
	}
}
