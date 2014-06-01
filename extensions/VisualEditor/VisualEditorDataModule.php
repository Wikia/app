<?php
/**
 * Resource loader module providing extra data from the server to VisualEditor.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class VisualEditorDataModule extends ResourceLoaderModule {

	/* Protected Members */

	protected $origin = self::ORIGIN_USER_SITEWIDE;
	protected $gitInfo;
	protected $gitHeadHash;

	/* Methods */

	public function __construct () {
		$this->gitInfo = new GitInfo( __DIR__ );
	}

	public function getScript( ResourceLoaderContext $context ) {
		// Messages
		$msgInfo = $this->getMessageInfo();
		$parsedMesssages = array();
		$messages = array();
		foreach ( $msgInfo['args'] as $msgKey => $msgArgs ) {
			$parsedMesssages[ $msgKey ] = call_user_func_array( 'wfMessage', $msgArgs )
				->inLanguage( $context->getLanguage() )
				->parse();
		}
		foreach ( $msgInfo['vals'] as $msgKey => $msgVal ) {
			$messages[ $msgKey ] = $msgVal;
		}

		// Version information
		$language = Language::factory( $context->getLanguage() );

		$hash = $this->getGitHeadHash();
		$id = $hash ? substr( $this->getGitHeadHash(), 0, 7 ) : false;
		$url = $this->gitInfo->getHeadViewUrl();
		$date = $this->gitInfo->getHeadCommitDate();
		$dateString = $date ? $language->timeanddate( $date, true ) : '';

		return
			've.init.platform.addParsedMessages(' . FormatJson::encode(
				$parsedMesssages,
				ResourceLoader::inDebugMode()
			) . ');'.
			've.init.platform.addMessages(' . FormatJson::encode(
				$messages,
				ResourceLoader::inDebugMode()
			) . ');'.
			// Documented in .docs/external.json
			've.version = ' . FormatJson::encode(
				array(
					'id' => $id,
					'url' => $url,
					'timestamp' => $date,
					'dateString' => $dateString,
				), ResourceLoader::inDebugMode()
			) . ';';
	}

	protected function getMessageInfo() {
		$msgKeys = array();

		// Messages that just require simple parsing
		$msgArgs = array(
			'minoredit' => array( 'minoredit' ),
			'missingsummary' => array( 'missingsummary' ),
			'summary' => array( 'summary' ),
			'watchthis' => array( 'watchthis' ),
			'visualeditor-browserwarning' => array( 'visualeditor-browserwarning' ),
			'visualeditor-report-notice' => array( 'visualeditor-report-notice' ),
			'visualeditor-wikitext-warning' => array( 'visualeditor-wikitext-warning' ),
		);

		// Override message value
		$msgVals = array(
			'visualeditor-feedback-link' => wfMessage( 'visualeditor-feedback-link' )
				->inContentLanguage()
				->text(),
		);

		// Copyright warning (based on EditPage::getCopyrightWarning)
		global $wgRightsText;
		if ( $wgRightsText ) {
			$copywarnMsg = array( 'copyrightwarning',
				'[[' . wfMessage( 'copyrightpage' )->inContentLanguage()->text() . ']]',
				$wgRightsText );
		} else {
			$copywarnMsg = array( 'copyrightwarning2',
				'[[' . wfMessage( 'copyrightpage' )->inContentLanguage()->text() . ']]' );
		}
		// EditPage supports customisation based on title, we can't support that here
		// since these messages are cached on a site-level. $wgTitle is likely set to null.
		$title = Title::newFromText( 'Dwimmerlaik' );
		wfRunHooks( 'EditPageCopyrightWarning', array( $title, &$copywarnMsg ) );

		// Keys used in copyright warning
		$msgKeys[] = 'copyrightpage';
		$msgKeys[] = $copywarnMsg[0];
		// Normalise to 'copyrightwarning' so we have a consistent key in the front-end.
		$msgArgs[ 'copyrightwarning' ] = $copywarnMsg;

		$msgKeys = array_values( array_unique( array_merge(
			$msgKeys,
			array_keys( $msgArgs ),
			array_keys( $msgVals )
		) ) );

		return array(
			'keys' => $msgKeys,
			'args' => $msgArgs,
			'vals' => $msgVals,
		);
	}

	public function getMessages() {
		// We don't actually use the client-side message system for these messages.
		// But we're registering them in this standardised method to make use of the
		// getMsgBlobMtime utility to make cache invalidation work out-of-the-box.

		$msgInfo = $this->getMessageInfo();
		return $msgInfo['keys'];
	}

	public function getDependencies() {
		return array( 'ext.visualEditor.base' );
	}

	public function getModifiedTime( ResourceLoaderContext $context ) {
		return max(
			$this->getGitHeadModifiedTime( $context ),
			$this->getMsgBlobMtime( $context->getLanguage() ),
			// Also invalidate this module if this file changes (i.e. when messages were
			// added or removed, or when the Javascript invocation in getScript is changed).
			// Use 1 because 0 = now, would invalidate continously
			file_exists( __FILE__ ) ? filemtime( __FILE__ ) : 1
		);
	}

	protected function getGitHeadModifiedTime( ResourceLoaderContext $context ) {
		$cache = wfGetCache( CACHE_ANYTHING );
		$key = wfMemcKey( 'resourceloader', 'vedatamodule', 'changeinfo' );

		$hash = $this->getGitHeadHash();

		$result = $cache->get( $key );
		if ( is_array( $result ) && $result['hash'] === $hash ) {
			return $result['timestamp'];
		}
		$timestamp = wfTimestamp();
		$cache->set( $key, array(
			'hash' => $hash,
			'timestamp' => $timestamp,
		) );
		return $timestamp;
	}

	protected function getGitHeadHash() {
		if ( $this->gitHeadHash === null ) {
			$this->gitHeadHash = $this->gitInfo->getHeadSHA1();
		}
		return $this->gitHeadHash;
	}
}
