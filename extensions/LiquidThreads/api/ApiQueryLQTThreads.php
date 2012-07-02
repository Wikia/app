<?php
/**
 * LiquidThreads API Query module
 *
 * Data that can be returned:
 * - ID
 * - Subject
 * - "host page"
 * - parent
 * - ancestor
 * - creation time
 * - modification time
 * - author
 * - summary article ID
 * - "root" page ID
 * - type
 */

class ApiQueryLQTThreads extends ApiQueryBase {
	// Property definitions
	static $propRelations = array(
		'id' => 'thread_id',
		'subject' => 'thread_subject',
		'page' => array(
			'namespace' => 'thread_article_namespace',
			'title' => 'thread_article_title'
		),
		'parent' => 'thread_parent',
		'ancestor' => 'thread_ancestor',
		'created' => 'thread_created',
		'modified' => 'thread_modified',
		'author' => array(
			'id' => 'thread_author_id',
			'name' => 'thread_author_name'
		),
		'summaryid' => 'thread_summary_page',
		'rootid' => 'thread_root',
		'type' => 'thread_type',
		'reactions' => null,
	);

	public function __construct( $query, $moduleName ) {
		parent :: __construct( $query, $moduleName, 'th' );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$prop = array_flip( $params['prop'] );
		$result = $this->getResult();
		$this->addTables( 'thread' );
		$this->addFields( 'thread_id' );

		foreach ( self::$propRelations as $name => $fields ) {
			// Pass a straight array rather than one with string
			// keys, to be sure that merging it into other added
			// arrays doesn't mess stuff up
			$this->addFieldsIf( array_values( (array)$fields ), isset( $prop[$name] ) );
		}

		// Check for conditions
		$conditionFields = array( 'page', 'root', 'summary', 'author', 'id' );
		foreach ( $conditionFields as $field ) {
			if ( isset( $params[$field] ) ) {
				$this->handleCondition( $field, $params[$field] );
			}
		}

		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addWhereRange( 'thread_id', $params['dir'],
			$params['startid'], $params['endid'] );

		if ( !$params['showdeleted'] ) {
			$delType = $this->getDB()->addQuotes( Threads::TYPE_DELETED );
			$this->addWhere( "thread_type != $delType" );
		}

		if ( $params['render'] ) {
			// All fields
			$allFields = array(
				'thread_id', 'thread_root', 'thread_article_namespace',
				'thread_article_title', 'thread_summary_page', 'thread_ancestor',
				'thread_parent', 'thread_modified', 'thread_created', 'thread_type',
				'thread_editedness', 'thread_subject', 'thread_author_id',
				'thread_author_name', 'thread_signature'
			);

			$this->addFields( $allFields );
		}

		$res = $this->select( __METHOD__ );

		$ids = array();
		$count = 0;
		foreach ( $res as $row )
		{
			if ( ++$count > $params['limit'] ) {
				// We've had enough
				$this->setContinueEnumParameter( 'startid', $row->thread_id );
				break;
			}

			$entry = array();
			foreach ( $prop as $name => $nothing ) {
				$fields = self::$propRelations[$name];
				self::formatProperty( $name, $fields, $row, $entry );
			}

			if ( isset( $entry['reactions'] ) ) {
				$result->setIndexedTagName( $entry['reactions'], 'reaction' );
			}

			// Render if requested
			if ( $params['render'] ) {
				self::renderThread( $row, $params, $entry );
			}

			$ids[$row->thread_id] = $row->thread_id;

			if ( $entry ) {
				$fit = $result->addValue( array( 'query',
						$this->getModuleName() ),
					$row->thread_id, $entry );
				if ( !$fit ) {
					$this->setContinueEnumParameter( 'startid', $row->thread_id );
					break;
				}
			}
		}

		if ( isset( $prop['reactions'] ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( 'thread_reaction', '*', array( 'tr_thread' => $ids ),
						__METHOD__ );

			foreach( $res as $row ) {
				$info = array(
				     'type' => $row->tr_type,
				     'user-id' => $row->tr_user,
				     'user-name' => $row->tr_user_text,
				     'value' => $row->tr_value,
				);

				$result->addValue( array( 'query', $this->getModuleName(), $row->tr_thread, 'reactions' ),
							null, $info );
			}
		}

		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'thread' );
	}

	static function renderThread( $row, $params, &$entry ) {
		// Set up OutputPage
		global $wgOut, $wgUser, $wgRequest;
		$oldOutputText = $wgOut->getHTML();
		$wgOut->clearHTML();

		// Setup
		$thread = Thread::newFromRow( $row );
		$article = $thread->root();

		if ( ! $article ) {
			return;
		}

		$title = $article->getTitle();
		$view = new LqtView( $wgOut, $article, $title, $wgUser, $wgRequest );

		// Parameters
		$view->threadNestingLevel = $params['renderlevel'];

		$renderpos = $params['renderthreadpos'];
		$rendercount = $params['renderthreadcount'];

		$options = array();
		if ( isset( $params['rendermaxthreadcount'] ) )
			$options['maxCount'] = $params['rendermaxthreadcount'];
		if ( isset( $params['rendermaxdepth'] ) )
			$options['maxDepth'] = $params['rendermaxdepth'];
		if ( isset( $params['renderstartrepliesat'] ) )
			$options['startAt' ] = $params['renderstartrepliesat'];

		$view->showThread( $thread, $renderpos, $rendercount, $options );

		$result = $wgOut->getHTML();
		$wgOut->clearHTML();
		$wgOut->addHTML( $oldOutputText );

		$entry['content'] = $result;
	}

	static function formatProperty( $name, $fields, $row, &$entry ) {
		if ( is_null( $fields ) ) {
			$entry[$name] = array();
		} elseif ( !is_array( $fields ) ) {
			// Common case.
			$entry[$name] = $row->$fields;
		} elseif ( $name == 'page' ) {
			// Special cases
			$nsField = $fields['namespace'];
			$tField = $fields['title'];
			$title = Title::makeTitle( $row->$nsField, $row->$tField );
			ApiQueryBase::addTitleInfo( $entry, $title, 'page' );
		} else {
			// Complicated case.
			foreach ( $fields as $part => $field ) {
				$entry[$name][$part] = $row->$field;
			}
		}
	}

	function addPageCond( $prop, $value ) {
		if ( count( $value ) === 1 ) {
			$cond = $this->getPageCond( $prop, $value[0] );
			$this->addWhere( $cond );
		} else {
			$conds = array();
			foreach ( $value as $page ) {
				$cond = $this->getPageCond( $prop, $page );
				$conds[] = $this->getDB()->makeList( $cond, LIST_AND );
			}

			$cond = $this->getDB()->makeList( $conds, LIST_OR );
			$this->addWhere( $cond );
		}
	}

	function getPageCond( $prop, $value ) {
		$fieldMappings = array(
			'page' => array(
				'namespace' => 'thread_article_namespace',
				'title' => 'thread_article_title',
			),
			'root' => array( 'id' => 'thread_root' ),
			'summary' => array( 'id' => 'thread_summary_id' ),
		);

		// Split.
		$t = Title::newFromText( $value );
		$cond = array();
		foreach ( $fieldMappings[$prop] as $type => $field ) {
			switch ( $type ) {
				case 'namespace':
					$cond[$field] = $t->getNamespace();
					break;
				case 'title':
					$cond[$field] = $t->getDBkey();
					break;
				case 'id':
					$cond[$field] = $t->getArticleID();
					break;
				default:
					ApiBase::dieDebug( __METHOD__, "Unknown condition type $type" );
			}
		}
		return $cond;
	}

	function handleCondition( $prop, $value ) {
		$titleParams = array( 'page', 'root', 'summary' );
		$fields = self::$propRelations[$prop];

		if ( in_array( $prop, $titleParams ) ) {
			// Special cases
			$this->addPageCond( $prop, $value );
		} elseif ( $prop == 'author' ) {
			$this->addWhereFld( 'thread_author_name', $value );
		} elseif ( !is_array( $fields ) ) {
			// Common case
			return $this->addWhereFld( $fields, $value );
		}
	}

	public function getCacheMode( $params ) {
		if ( $params['render'] ) {
			// Rendering uses $wgUser
			return 'anon-public-user-private';
		} else {
			return 'public';
		}
	}

	public function getAllowedParams() {
		return array (
			'startid' => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'endid' => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'dir' => array(
				ApiBase :: PARAM_TYPE => array(
					'newer',
					'older'
				),
				ApiBase :: PARAM_DFLT => 'newer'
			),
			'showdeleted' => false,
			'limit' => array(
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'prop' => array(
				ApiBase :: PARAM_DFLT => 'id|subject|page|parent|author',
				ApiBase :: PARAM_TYPE => array_keys( self::$propRelations ),
				ApiBase :: PARAM_ISMULTI => true
			),

			'page' => array(
				ApiBase :: PARAM_ISMULTI => true
			),
			'author' => array(
				ApiBase :: PARAM_ISMULTI => true
			),
			'root' => array(
				ApiBase :: PARAM_ISMULTI => true
			),
			'summary' => array(
				ApiBase :: PARAM_ISMULTI => true
			),
			'id' => array(
				ApiBase :: PARAM_ISMULTI => true
			),
			'render' => false,
			'renderlevel' => array(
				ApiBase :: PARAM_DFLT => 0,
			),
			'renderthreadpos' => array(
				ApiBase :: PARAM_DFLT => 1,
			),
			'renderthreadcount' => array(
				ApiBase :: PARAM_DFLT => 1,
			),
			'rendermaxthreadcount' => array(
				ApiBase :: PARAM_DFLT => null,
			),
			'rendermaxdepth' => array(
				ApiBase :: PARAM_DFLT => null,
			),
			'renderstartrepliesat' => array(
				ApiBase :: PARAM_DFLT => null,
			),
		);
	}

	public function getParamDescription() {
		return array (
			'startid' => 'The thread id to start enumerating from',
			'endid' => 'The thread id to stop enumerating at',
			'dir' => 'The direction in which to enumerate',
			'limit' => 'The maximum number of threads to list',
			'prop' => 'Which properties to get',
			'page' => 'Limit results to threads on a particular page(s)',
			'author' => 'Limit results to threads by a particular author(s)',
			'root' => 'Limit results to threads with the given root(s)',
			'summary' => 'Limit results to threads corresponding to the given summary page(s)',
			'id' => 'Get threads with the given ID(s)',
			'showdeleted' => 'Whether or not to show deleted threads',
			'render' => 'Whether or not to include the rendered thread in the results',
			'renderlevel' => 'When rendering, the level at which to start (for the sake of depth limits, etc)',
			'renderthreadpos' => 'When rendering, the position of the thread in the group of ' .
					'threads being rendered at that level (affects display somewhat)',
			'renderthreadcount' => 'When rendering, the number of threads in that level group',
			'rendermaxthreadcount' => 'When rendering, the maximum number of replies to show ' .
					'before adding a "Show more replies" link',
			'rendermaxdepth' => 'When rendering, the maximum depth of replies to show before ' .
					'showing a "Show X replies" link instead of replies',
			'renderstartrepliesat' => 'When rendering, the point at which to start showing replies ' .
					'(used internally to load extra replies)',
		);
	}

	public function getDescription() {
		return 'Show details of LiquidThreads threads.';
	}

	public function getExamples() {
 		return array(
 			'api.php?action=query&list=threads&thpage=Talk:Main_Page',
 			'api.php?action=query&list=threads&thid=1|2|3|4&thprop=id|subject|modified'
 		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryLQTThreads.php 95587 2011-08-26 23:50:06Z johnduhart $';
	}
}
