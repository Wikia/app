<?php

/**
 * @addtogroup API
 */
class ApiWOMQuery extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action );
	}

	// given the 'key', return the result set of 'xpath' or wiki object id set
	// e.g., key=hello, world&action=womquery,
	// returns <match><id>1</id><type>text</type><start>20</start><end>30</end></match>
	// in wiki object id="1", the text part of WOM node, char index start at 20 and end at 30
	// for the paragraph instance, it will return id1, id2, id 3
	// given the 'key', specify the returning object type, same result set to the previous api
	// e.g., key=hello, world&action=womquery&return=sentence/paragraph/property value/template value/section...
	// for the paragraph instance,
	// return=sentence, it will return id3
	// return=paragraph, it will return id1, id2
	// given the 'key' and returning type, specify the context of required object, same return
	// e.g., key=hello, world&action=womquery&return=sentence&xpath=/page/section[3]
	// for the paragraph instance,
	// return=paragraph, xpath=sentence/.., it will return id2

	public function execute() {
		global $wgUser;

		$params = $this->extractRequestParams();
		if ( is_null( $params['title'] ) )
			$this->dieUsage( 'Must specify page title', 0 );
		if ( is_null( $params['key'] ) )
			$this->dieUsage( 'Must specify key', 1 );

		$page_name = $params['title'];
		$key = $params['key'];
		$rid = $params['rid'];
		$type = $params['type'];
		$xpath = $params['xpath'];

		$articleTitle = Title::newFromText( $page_name );
		if ( !$articleTitle )
			$this->dieUsage( "Can't create title object ($page_name)", 2 );

		$article = new Article( $articleTitle );
		if ( !$article->exists() )
			$this->dieUsage( "Article doesn't exist ($page_name)", 3 );

		if ( !$xpath ) {
			$xpath = '/';
		}
		try {
			$objs = WOMProcessor::getObjIdByXPath( $articleTitle, $xpath, $rid );
		} catch ( Exception $e ) {
			$err = $e->getMessage();
		}

		$result = array();

		if ( isset( $err ) ) {
			$result = array(
				'result' => 'Failure',
				'message' => array(),
			);
			$this->getResult()->setContent( $result['message'], $err );
		} else {
			$result['result'] = 'Success';

			// pay attention to special xml tag, e.g., <property><value>...</value></property>
			$result['return'] = array();
			if ( $type == 'count' ) {
				$count = 0;
				foreach ( $objs as $id ) {
					if ( $id == '' ) continue;
					++ $count;
				}
				$this->getResult()->setContent( $result['return'], $count );
			} else {
				$xml = '';
				$page_obj = WOMProcessor::getPageObject( $articleTitle, $rid );
				foreach ( $objs as $id ) {
					if ( $id == '' ) continue;
					$wobj = $page_obj->getObject( $id );
					$result['return'][$id] = array();
					if ( $type == 'xml' ) {
						$xml .= "<{$id} xml:space=\"preserve\">{$wobj->toXML()}</{$id}>";
//						$this->getResult()->setContent( $result['return'][$id], $wobj->toXML() );
					} else {
						$this->getResult()->setContent( $result['return'][$id], $wobj->getWikiText() );
					}
				}
				if ( $type == 'xml' ) {
					header ( "Content-Type: application/rdf+xml" );
					echo <<<OUTPUT
<?xml version="1.0" encoding="UTF-8" ?>
<api><womquery result="Success"><return>
{$xml}
</return></womquery></api>
OUTPUT;
					exit( 1 );
				}
			}
		}
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	protected function getAllowedParams() {
		return array (
			'title' => null,
			'key' => null,
			'xpath' => null,
			'type' => array(
				ApiBase :: PARAM_DFLT => WOM_TYPE_SENTENCE,
				ApiBase :: PARAM_TYPE => array(
					WOM_TYPE_SECTION,
					WOM_TYPE_PARAGRAPH,
					WOM_TYPE_SENTENCE,
				),
			),
			'rid' => array (
                                ApiBase :: PARAM_TYPE => 'integer',
                                ApiBase :: PARAM_DFLT => 0,
                                ApiBase :: PARAM_MIN => 0
                        ),
		);
	}

	protected function getParamDescription() {
		return array (
			'title' => 'Title of the page to modify',
			'key' => 'query key',
			'xpath' => 'DOM-like xpath to locate WOM object instances (http://www.w3schools.com/xpath/xpath_syntax.asp)',
			'type' => array (
				'Object type to fetch useful wiki object data',
			),
			'rid' => 'Revision id of specified page - by dafault latest updated revision (0) is used',
		);
	}

	protected function getDescription() {
		return 'Call to get objects to Wiki Object Model';
	}

	public function getExamples() {
		return array (
			'api.php?action=womquery&title=Somepage&key=hello,world'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
