<?php
/**
 * Api module for querying message translations.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2011, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Api module for querying message translations.
 *
 * @ingroup API TranslateAPI
 */
class ApiQueryMessageTranslations extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'mt' );
	}

	public function getCacheMode( $params ) {
		return 'public';
	}

	public function execute() {
		$params = $this->extractRequestParams();

		$title = Title::newFromText( $params['title'] );
		if ( !$title ) {
			$this->dieUsage( 'Invalid title' );
		}

		$handle = new MessageHandle( $title );
		if ( !$handle->isValid() ) {
			$this->dieUsage( 'Title does not correspond to a translatable message' );
		}

		$base = Title::makeTitle( $title->getNamespace(), $handle->getKey() );
		$namespace = $base->getNamespace();
		$message = $base->getDBKey();

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'page',
			array( 'page_namespace', 'page_title' ),
			array(
				'page_namespace' => $namespace,
				'page_title ' . $dbr->buildLike( "$message/", $dbr->anyString() ),
			),
			__METHOD__,
			array(
				'ORDER BY'  => 'page_title',
				'USE INDEX' => 'name_title',
			)
		);

		$titles = array();
		foreach ( $res as $row ) {
			$titles[] = $row->page_title;
		}
		$pageInfo = TranslateUtils::getContents( $titles, $namespace );

		$result = $this->getResult();
		$pages = array();
		$count = 0;

		foreach ( $pageInfo as $key => $info ) {
			if ( ++$count <= $params['offset'] ) {
				continue;
			}

			$tTitle = Title::makeTitle( $namespace, $key );
			$tHandle = new MessageHandle( $tTitle );

			$data = array(
				'title' => $tTitle->getPrefixedText(),
				'language' => $tHandle->getCode(),
				'lasttranslator' => $info[1],
			);

			$fuzzy = MessageHandle::hasFuzzyString( $info[0] ) || $tHandle->isFuzzy();

			if ( $fuzzy ) {
				$data['fuzzy'] = 'fuzzy';
			}

			$translation = str_replace( TRANSLATE_FUZZY, '', $info[0] );
			$result->setContent( $data, $translation );

			$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $data );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'offset', $count );
				break;
			}

		}

		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'message' );
	}

	public function getAllowedParams() {
		return array(
			'title' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'offset' => array(
				ApiBase::PARAM_DFLT => 0,
				ApiBase::PARAM_TYPE => 'integer',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'title' => 'Full title of a known message',
		);
	}

	public function getDescription() {
		return 'Query all translations for a single message';
	}

	public function getExamples() {
		return array(
			"api.php?action=query&meta=messagetranslations&mttitle=MediaWiki:January List of translations in the wiki for MediaWiki:January",
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryMessageTranslations.php 99764 2011-10-14 12:55:32Z nikerabbit $';
	}
}
