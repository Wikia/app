<?php
class AbuseFilterVariableHolder {
	var $mVars = array();
	static $varBlacklist = array( 'context' );

	function setVar( $variable, $datum ) {
		$variable = strtolower( $variable );
		if ( !( $datum instanceof AFPData || $datum instanceof AFComputedVariable ) ) {
			$datum = AFPData::newFromPHPVar( $datum );
		}

		$this->mVars[$variable] = $datum;
	}

	function setLazyLoadVar( $variable, $method, $parameters ) {
		$placeholder = new AFComputedVariable( $method, $parameters );
		$this->setVar( $variable, $placeholder );
	}

	function getVar( $variable ) {
		$variable = strtolower( $variable );
		if ( isset( $this->mVars[$variable] ) ) {
			if ( $this->mVars[$variable] instanceof AFComputedVariable ) {
				$value = $this->mVars[$variable]->compute( $this );
				$this->setVar( $variable, $value );
				return $value;
			} elseif ( $this->mVars[$variable] instanceof AFPData ) {
				return $this->mVars[$variable];
			}
		} else {
			return new AFPData();
		}
	}

	static function merge() {
		$newHolder = new AbuseFilterVariableHolder;

		foreach ( func_get_args() as $addHolder ) {
			$newHolder->addHolder( $addHolder );
		}

		return $newHolder;
	}

	function addHolder( $addHolder ) {
		if ( !is_object( $addHolder ) ) {
			throw new MWException( 'Invalid argument to AbuseFilterVariableHolder::addHolder' );
		}
		$this->mVars = array_merge( $this->mVars, $addHolder->mVars );
	}

	function __wakeup() {
		// Reset the context.
		$this->setVar( 'context', 'stored' );
	}

	function exportAllVars() {
		$allVarNames = array_keys( $this->mVars );
		$exported = array();

		foreach ( $allVarNames as $varName ) {
			if ( !in_array( $varName, self::$varBlacklist ) ) {
				$exported[$varName] = $this->getVar( $varName )->toString();
			}
		}

		return $exported;
	}

	function varIsSet( $var ) {
		return array_key_exists( $var, $this->mVars );
	}

	/**
	 * Compute all vars which need DB access. Useful for vars which are going to be saved
	 * cross-wiki or used for offline analysis.
	 */
	function computeDBVars() {
		static $dbTypes = array(
			'links-from-wikitext-or-database',
			'load-recent-authors',
			'get-page-restrictions',
			'simple-user-accessor',
			'user-age',
			'user-groups',
			'revision-text-by-id',
			'revision-text-by-timestamp'
		);

		foreach ( $this->mVars as $name => $value ) {
			if ( $value instanceof AFComputedVariable &&
						in_array( $value->mMethod, $dbTypes ) ) {
					$value = $value->compute( $this );
					$this->setVar( $name, $value );
			}
		}
	}
}

class AFComputedVariable {
	var $mMethod, $mParameters;
	static $userCache = array();
	static $articleCache = array();

	function __construct( $method, $parameters ) {
		$this->mMethod = $method;
		$this->mParameters = $parameters;
	}

	/**
	 * It's like Article::prepareTextForEdit, but not for editing (old wikitext usually)
	 *
	 *
	 * @param $wikitext String
	 * @param $article Article
	 *
	 * @return object
	 */
	function parseNonEditWikitext( $wikitext, $article ) {
		static $cache = array();

		$cacheKey = md5( $wikitext ) . ':' . $article->mTitle->getPrefixedText();

		if ( isset( $cache[$cacheKey] ) ) {
			return $cache[$cacheKey];
		}

		global $wgParser;
		$edit = (object)array();
		$options = new ParserOptions;
		$options->setTidy( true );
		$edit->output = $wgParser->parse( $wikitext, $article->getTitle(), $options );
		$cache[$cacheKey] = $edit;

		return $edit;
	}

	static function userObjectFromName( $username ) {
		if ( isset( self::$userCache[$username] ) ) {
			return self::$userCache[$username];
		}

		wfDebug( "Couldn't find user $username in cache\n" );

		if ( count( self::$userCache ) > 1000 ) {
			self::$userCache = array();
		}

		if ( IP::isIPAddress( $username ) ) {
			$u = new User;
			$u->setName( $username );
			self::$userCache[$username] = $u;
			return $u;
		}

		$user = User::newFromName( $username );
		$user->load();
		self::$userCache[$username] = $user;

		return $user;
	}

	static function articleFromTitle( $namespace, $title ) {
		if ( isset( self::$articleCache["$namespace:$title"] ) ) {
			return self::$articleCache["$namespace:$title"];
		}

		if ( count( self::$articleCache ) > 1000 ) {
			self::$articleCache = array();
		}

		wfDebug( "Creating article object for $namespace:$title in cache\n" );

		$t = Title::makeTitle( $namespace, $title );
		self::$articleCache["$namespace:$title"] = new Article( $t );

		return self::$articleCache["$namespace:$title"];
	}

	static function getLinksFromDB( $article ) {
		// Stolen from ConfirmEdit
		$id = $article->getId();
		if ( !$id ) {
			return array();
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'externallinks',
			array( 'el_to' ),
			array( 'el_from' => $id ),
			__METHOD__
		);
		$links = array();
		foreach( $res as $row ) {
			$links[] = $row->el_to;
		}
		return $links;
	}

	function compute( $vars ) {
		$parameters = $this->mParameters;
		$result = null;
		switch( $this->mMethod ) {
			case 'diff':
				$text1Var = $parameters['oldtext-var'];
				$text2Var = $parameters['newtext-var'];
				$text1 = $vars->getVar( $text1Var )->toString();
				$text2 = $vars->getVar( $text2Var )->toString();
				$result = wfDiff( $text1, $text2 );
				$result = trim( preg_replace( "/^\\\\ No newline at end of file\n/m", '', $result ) );
				break;
			case 'diff-split':
				$diff = $vars->getVar( $parameters['diff-var'] )->toString();
				$line_prefix = $parameters['line-prefix'];
				$diff_lines = explode( "\n", $diff );
				$interest_lines = array();
				foreach ( $diff_lines as $line ) {
					if ( substr( $line, 0, 1 ) === $line_prefix ) {
						$interest_lines[] = substr( $line, strlen( $line_prefix ) );
					}
				}
				$result = $interest_lines;
				break;
			case 'links-from-wikitext':
				// This should ONLY be used when sharing a parse operation with the edit.

				$article = $parameters['article'];
				if ( $article ) {
					$textVar = $parameters['text-var'];

					$new_text = $vars->getVar( $textVar )->toString();
					$editInfo = $article->prepareTextForEdit( $new_text );
					$links = array_keys( $editInfo->output->getExternalLinks() );
					$result = $links;
					break;
				}
				// Otherwise fall back to database
			case 'links-from-wikitext-nonedit':
			case 'links-from-wikitext-or-database':
				$article = self::articleFromTitle(
					$parameters['namespace'],
					$parameters['title']
				);

				if ( $vars->getVar( 'context' )->toString() == 'filter' ) {
					$links = $this->getLinksFromDB( $article );
					wfDebug( "AbuseFilter: loading old links from DB\n" );
				} else {
					wfDebug( "AbuseFilter: loading old links from Parser\n" );
					$textVar = $parameters['text-var'];

					$wikitext = $vars->getVar( $textVar )->toString();
					$editInfo = $this->parseNonEditWikitext( $wikitext, $article );
					$links = array_keys( $editInfo->output->getExternalLinks() );
				}

				$result = $links;
				break;
			case 'link-diff-added':
			case 'link-diff-removed':
				$oldLinkVar = $parameters['oldlink-var'];
				$newLinkVar = $parameters['newlink-var'];

				$oldLinks = $vars->getVar( $oldLinkVar )->toString();
				$newLinks = $vars->getVar( $newLinkVar )->toString();

				$oldLinks = explode( "\n", $oldLinks );
				$newLinks = explode( "\n", $newLinks );

				if ( $this->mMethod == 'link-diff-added' ) {
					$result = array_diff( $newLinks, $oldLinks );
				}
				if ( $this->mMethod == 'link-diff-removed' ) {
					$result = array_diff( $oldLinks, $newLinks );
				}
				break;
			case 'parse-wikitext':
				// Should ONLY be used when sharing a parse operation with the edit.
	
				$article = $parameters['article'];
				if ( $article ) {
					$textVar = $parameters['wikitext-var'];

					$new_text = $vars->getVar( $textVar )->toString();
					$editInfo = $article->prepareTextForEdit( $new_text );
					$newHTML = $editInfo->output->getText();
					// Kill the PP limit comments. Ideally we'd just remove these by not setting the
					// parser option, but then we can't share a parse operation with the edit, which is bad.
					$result = preg_replace( '/<!--\s*NewPP limit report[^>]*-->\s*$/si', '', $newHTML );
					break;
				}
				// Otherwise fall back to database
			case 'parse-wikitext-nonedit':
				$article = self::articleFromTitle( $parameters['namespace'], $parameters['title'] );
				$textVar = $parameters['wikitext-var'];

				$text = $vars->getVar( $textVar )->toString();
				$editInfo = $this->parseNonEditWikitext( $text, $article );

				$result = $editInfo->output->getText();
				break;
			case 'strip-html':
				$htmlVar = $parameters['html-var'];
				$html = $vars->getVar( $htmlVar )->toString();
				$result = StringUtils::delimiterReplace( '<', '>', '', $html );
				break;
			case 'load-recent-authors':
				$cutOff = $parameters['cutoff'];
				$title = Title::makeTitle( $parameters['namespace'], $parameters['title'] );

				if ( !$title->exists() ) {
					$result = '';
					break;
				}

				$dbr = wfGetDB( DB_SLAVE );
				$res = $dbr->select( 'revision',
					'DISTINCT rev_user_text, rev_user',
					array(
						'rev_page' => $title->getArticleId(),
						'rev_timestamp<' . $dbr->addQuotes( $dbr->timestamp( $cutOff ) )
					),
					__METHOD__,
					array( 'ORDER BY' => 'rev_timestamp DESC', 'LIMIT' => 10 )
				);

				$users = array();
				foreach( $res as $row ) {
					if ( $row->rev_user > 0 ) {
						$userName = User::newFromId( $row->rev_user )->getName();
					} else {
						$userName = $row->rev_user_text;
					}
					$users[] = $userName;
				}
				$result = $users;
				break;
			case 'get-page-restrictions':
				$action = $parameters['action'];
				$title = Title::makeTitle( $parameters['namespace'], $parameters['title'] );

				$rights = $title->getRestrictions( $action );
				$rights = count( $rights ) ? $rights : array();
				$result = $rights;
				break;
			case 'simple-user-accessor':
				$user = $parameters['user'];
				$method = $parameters['method'];

				if ( !$user ) {
					throw new MWException( 'No user parameter given.' );
				}

				$obj = self::userObjectFromName( $user );

				if ( !$obj ) {
					throw new MWException( "Invalid username $user" );
				}

				$result = call_user_func( array( $obj, $method ) );
				break;
			case 'user-age':
				$user = $parameters['user'];
				$asOf = $parameters['asof'];
				$obj = self::userObjectFromName( $user );

				if ( $obj->getId() == 0 ) {
					$result = 0;
					break;
				}

				$registration = $obj->getRegistration();
				$result =
					wfTimestamp( TS_UNIX, $asOf ) -
						wfTimestampOrNull( TS_UNIX, $registration );
				break;
			case 'user-groups':
				$user = $parameters['user'];
				$obj = self::userObjectFromName( $user );
				$result = $obj->getEffectiveGroups();
				break;
			case 'length':
				$s = $vars->getVar( $parameters['length-var'] )->toString();
				$result = strlen( $s );
				break;
			case 'subtract':
				$v1 = $vars->getVar( $parameters['val1-var'] )->toFloat();
				$v2 = $vars->getVar( $parameters['val2-var'] )->toFloat();
				$result = $v1 - $v2;
				break;
			case 'revision-text-by-id':
				$rev = Revision::newFromId( $parameters['revid'] );
				$result = $rev->getText();
				break;
			case 'revision-text-by-timestamp':
				$timestamp = $parameters['timestamp'];
				$title = Title::makeTitle( $parameters['namespace'], $parameters['title'] );
				$dbr = wfGetDB( DB_SLAVE );

				$rev = Revision::loadFromTimestamp( $dbr, $title, $timestamp );

				if ( $rev ) {
					$result = $rev->getText();
				} else {
					$result = '';
				}
				break;
			default:
				if ( wfRunHooks( 'AbuseFilter-computeVariable',
									array( $this->mMethod, $vars ) ) ) {
					throw new AFPException( 'Unknown variable compute type ' . $this->mMethod );
				}
		}

		return $result instanceof AFPData
			? $result : AFPData::newFromPHPVar( $result );
	}
}
