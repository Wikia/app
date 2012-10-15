<?php

class MetadataEditHooks {

	public static function wfMetadataEditExtractFromArticle( $editPage ) {
		global $wgMetadataWhitelist, $wgContLang;
		if ( $wgMetadataWhitelist == '' || !self::isValidMetadataNamespace( $editPage->mTitle->getNamespace() ) ) {
			return true;
		}

		$editPage->mMetaData = '';
		$s = '';
		$t = $editPage->textbox1;

		# MISSING : <nowiki> filtering

		# Categories and language links
		$t = explode( "\n" , $t );
		$catlow = strtolower( $wgContLang->getNsText( NS_CATEGORY ) );
		$cat = $ll = array();
		foreach ( $t as $key => $x ) {
			$y = trim( strtolower ( $x ) );
			while ( substr( $y , 0 , 2 ) == '[[' ) {
				$y = explode( ']]' , trim ( $x ) );
				$first = array_shift( $y );
				$first = explode( ':' , $first );
				$ns = array_shift( $first );
				$ns = trim( str_replace( '[' , '' , $ns ) );
				if ( $wgContLang->getLanguageName( $ns ) || strtolower( $ns ) == $catlow ) {
					$add = '[[' . $ns . ':' . implode( ':' , $first ) . ']]';
					if ( strtolower( $ns ) == $catlow ) $cat[] = $add;
					else $ll[] = $add;
					$x = implode( ']]', $y );
					$t[$key] = $x;
					$y = trim( strtolower( $x ) );
				} else {
					$x = implode( ']]' , $y );
					$y = trim( strtolower( $x ) );
				}
			}
		}
		if ( count( $cat ) ) $s .= implode( ' ' , $cat ) . "\n";
		if ( count( $ll ) ) $s .= implode( ' ' , $ll ) . "\n";
		$t = implode( "\n" , $t );

		# Load whitelist
		$sat = array () ; # stand-alone-templates; must be lowercase
		$wl_title = Title::newFromText( $wgMetadataWhitelist );
		if ( !$wl_title ) {
			throw new MWException( '$wgMetadataWhitelist is not set to a valid page title.' );
		}
		$wl_article = new Article ( $wl_title );
		$wl = explode ( "\n" , $wl_article->getContent() );
		foreach ( $wl AS $x ) {
			$isentry = false;
			$x = trim ( $x );
			while ( substr ( $x , 0 , 1 ) == '*' ) {
				$isentry = true;
				$x = trim ( substr ( $x , 1 ) );
			}
			if ( $isentry ) {
				$sat[] = strtolower ( $x );
			}

		}

		# Templates, but only some
		$t = explode( '{{' , $t );
		$tl = array() ;
		foreach ( $t as $key => $x ) {
			$y = explode( '}}' , $x , 2 );
			if ( count( $y ) == 2 ) {
				$z = $y[0];
				$z = explode( '|' , $z );
				$tn = array_shift( $z );
				if ( in_array( strtolower( $tn ) , $sat ) ) {
					$tl[] = '{{' . $y[0] . '}}';
					$t[$key] = $y[1];
					$y = explode( '}}' , $y[1] , 2 );
				}
				else $t[$key] = '{{' . $x;
			}
			elseif ( $key != 0 ) $t[$key] = '{{' . $x;
			else $t[$key] = $x;
		}
		if ( count( $tl ) ) $s .= implode( ' ' , $tl );
		$t = implode( '' , $t );

		$t = str_replace( "\n\n\n", "\n", $t );
		$editPage->textbox1 = $t;
		$editPage->mMetaData = $s;

		return true;
	}

	public static function wfMetadataEditOnImportData( $editPage, $request ) {
		if ( self::isValidMetadataNamespace( $editPage->mTitle->getNamespace() ) && $request->wasPosted() ) {
			$editPage->mMetaData = rtrim( $request->getText( 'metadata' ) );
		} else {
			$editPage->mMetaData = '';
		}

		return true;
	}

	public static function wfMetadataEditOnAttemptSave( $editPage ) {
		# Reintegrate metadata
		if ( $editPage->mMetaData != '' ) {
			$editPage->textbox1 .= "\n" . $editPage->mMetaData;
		}
		$editPage->mMetaData = '';

		return true;
	}

	public static function wfMetadataEditOnShowFields( $editPage ) {
		if ( !self::isValidMetadataNamespace( $editPage->mTitle->getNamespace() ) ) {
			return true;
		}

		global $wgContLang, $wgUser;
		$metadata = htmlspecialchars( $wgContLang->recodeForEdit( $editPage->mMetaData ) );

		$attribs = array();
		if ( $wgUser->getOption( 'editwidth' ) ) {
			$attribs['style'] = 'width:100%';
		}
		$attribs['cols'] = $wgUser->getIntOption( 'cols' );
		$attribs['rows'] = 3;

		$metadata = Html::rawElement( 'div', array( 'class' => 'mw-metadataedit-metadata' ),
			wfMsgWikiHtml( 'metadata_help' ) .
			Html::textarea( 'metadata', $metadata, $attribs )
		);
		$editPage->editFormTextAfterContent .= $metadata;

		return true;
	}

	public static function wfMetadataEditOnGetPreviewText( $editPage, &$toparse ) {
		if ( $editPage->mMetaData != '' ) {
			$toparse .= "\n" . $editPage->mMetaData;
		}
		return true;
	}

	public static function wfMetadataEditOnGetDiffText( $editPage, &$newText ) {
		if ( $editPage->mMetaData != '' ) {
			$newText .= "\n" . $editPage->mMetaData;
		}
		return true;
	}

	public static function isValidMetadataNamespace( $namespace ) {
		global $wgMetadataNamespaces;
		return in_array( $namespace,  $wgMetadataNamespaces );
	}
}
