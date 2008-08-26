<?php

if ( defined( 'MEDIAWIKI' ) ) {

	require_once ($GLOBALS['IP']."/extensions/wikia/SpamRegexBatch/SpamRegexBatch.php");

	class SpamBlacklist {
		var $spamList = null;
		var $settings = array();

		/**
		 * public constructor
		 */
		public function __construct( $settings = array() ) {
			if (empty($settings['regexes']))
				$settings['regexes'] = false;
			if (empty($settings['previousFilter']))
				$settings['previousFilter'] = false;
			if (empty($settings['files']))
				$settings['files'] = array( "http://meta.wikimedia.org/w/index.php?title=Spam_blacklist&action=raw&sb_ver=1" );
			if (empty($settings['warningTime']))
				$settings['warningTime'] = 600;
			if (empty($settings['expiryTime']))
				$settings['expiryTime'] = 900;
			if (empty($settings['warningChance']))
				$settings['warningChance'] = 100;

			if (empty($settings['memcache_file']))
				$settings['memcache_file']  = 'spam_blacklist_file';
			if (empty($settings['memcache_regexes']))
				$settings['memcache_regexes'] = 'spam_blacklist_regexes';

			wfLoadExtensionMessages( "SpamBlacklist" );
			$this->settings = $settings;
		}

		/**
		 * Check if the given local page title is a spam regex source.
		 * @param Title $title
		 * @return bool
		 */
		function isLocalSource( $title ) {
			global $wgDBname;

			if( $title->getNamespace() == NS_MEDIAWIKI ) {
				$sources = array(
					"Spam-blacklist",
					"Spam-whitelist" );
				if( in_array( $title->getDbKey(), $sources ) ) {
					return true;
				}
			}

			$thisHttp = $title->getFullUrl( 'action=raw' );
			$thisHttpRegex = '/^' . preg_quote( $thisHttp, '/' ) . '(?:&.*)?$/';

			foreach( $this->settings['files'] as $fileName ) {
				if ( preg_match( '/^DB: (\w*) (.*)$/', $fileName, $matches ) ) {
					if ( $wgDBname == $matches[1] ) {
						$sources[] = $matches[2];
						if( $matches[2] == $title->getPrefixedDbKey() ) {
							// Local DB fetch of this page...
							return true;
						}
					}
				} elseif( preg_match( $thisHttpRegex, $fileName ) ) {
					// Raw view of this page
					return true;
				}
			}

			return false;
		}

		public function set ($key, $val) {
			$this->settings[$key] = $val;
		}

		function clearCache() {
			global $wgMemc, $wgDBname;
			$wgMemc->delete( "$wgDBname:spam_blacklist_regexes" );
			wfDebugLog( 'SpamBlackList', "Spam blacklist local cache cleared.\n" );
		}

		public function getRegexes()
		{
			$this->spamList = new SpamRegexBatch("blacklist", $this->settings);
			$regexlists = $this->spamList->getRegexes();

			return $regexlists;
		}

		function filter( &$title, $text, $section )
		{
			global $wgArticle, $wgVersion, $wgOut, $wgParser, $wgUser;

			$fname = 'wfSpamRegexlistFilter';
			wfProfileIn( $fname );

			# Call the rest of the hook chain first
			if ( $this->settings['previousFilter'] ) {
				$f = $this->settings['previousFilter'];
				if ( $f( $title, $text, $section ) ) {
					wfProfileOut( $fname );
					return true;
				}
			}

			$this->settings['title'] = $title;
			$this->settings['text'] = $text;
			$this->settings['section'] = $section;

			$this->spamList = new SpamRegexBatch("blacklist", $this->settings);

			$regexlists = $this->spamList->getRegexes();
			$whitelists = $this->spamList->getWhitelists();

			if ( count( $regexlists ) ) {
				# Run parser to strip SGML comments and such out of the markup
				# This was being used to circumvent the filter (see bug 5185)
				$options = new ParserOptions();
				$text = $wgParser->preSaveTransform( $text, $title, $wgUser, $options );
				$out = $wgParser->parse( $text, $title, $options );
				$links = implode( "\n", array_keys( $out->getExternalLinks() ) );

				# Strip whitelisted URLs from the match
				if( is_array( $whitelists ) ) {
					wfDebugLog( 'SpamRegexBatch', "Excluding whitelisted URLs from " . count( $whitelists ) .
						" regexes: " . implode( ', ', $whitelists ) . "\n" );
					foreach( $whitelists as $regex ) {
						wfSuppressWarnings();
						$newLinks = preg_replace( $regex, '', $links );
						wfRestoreWarnings();
						if( is_string( $newLinks ) ) {
							// If there wasn't a regex error, strip the matching URLs
							$links = $newLinks;
						}
					}
				}

				# Do the match
				wfDebugLog( 'SpamRegexBatch', "Checking text against " . count( $regexlists ) .
					" regexes: " . implode( ', ', $regexlists ) . "\n" );
				$retVal = false;
				foreach( $regexlists as $regex ) {
					wfSuppressWarnings();
					$check = preg_match( $regex, $links, $matches );
					wfRestoreWarnings();
					if( $check ) {
						wfDebugLog( 'SpamRegexBatch', "Match!\n" );
						SpamRegexBatch::spamPage( $matches[0], $title );
						$retVal = true;
						break;
					}
				}
			} else {
				$retVal = false;
			}

			wfProfileOut( $fname );
			return $retVal;
		}
	}
} # End invocation guard
?>
