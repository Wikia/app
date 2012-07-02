<?php

/**
 * @addtogroup API
 */
class ApiWOMGetObjectModel extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action );
	}

	public function execute() {
		global $wgUser;

		$params = $this->extractRequestParams();
		if ( is_null( $params['title'] ) )
			$this->dieUsage( 'Must specify page title', 0 );
		if ( is_null( $params['xpath'] ) )
			$this->dieUsage( 'Must specify xpath', 1 );

		$page_name = $params['title'];
		$xpath = $params['xpath'];
		$type = $params['type'];
		$rid = $params['rid'];


		$articleTitle = Title::newFromText( $page_name );
		if ( !$articleTitle )
			$this->dieUsage( "Can't create title object ($page_name)", 2 );

		$article = new Article( $articleTitle );
		if ( !$article->exists() )
			$this->dieUsage( "Article doesn't exist ($page_name)", 3 );

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
<api><womget result="Success"><return>
{$xml}
</return></womget></api>
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
			'xpath' => null,
			'type' => array(
				ApiBase :: PARAM_DFLT => 'wiki',
				ApiBase :: PARAM_TYPE => array(
					'wiki',
					'count',
					'xml',
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
			'xpath' => 'DOM-like xpath to locate WOM object instances (http://www.w3schools.com/xpath/xpath_syntax.asp)',
			'type' => array (
				'Type to fetch useful wiki object data',
				'type = wiki, get wiki text of specified object',
				'type = count, get objects count with specified xpath',
				'type = xml, view "encoded objects\' xml" with specified xpath, usually use with format=xml',
			),
			'rid' => 'Revision id of specified page - by dafault latest updated revision (0) is used',
		);
	}

	protected function getDescription() {
		return 'Call to get object values to Wiki Object Model';
	}

	public function getExamples() {
		return array (
			'api.php?action=womget&title=Somepage&xpath=//template[@name=SomeTempate]/template_field[@key=templateparam]'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
