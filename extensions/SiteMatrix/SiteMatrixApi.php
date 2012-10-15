<?php

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "SiteMatrix extension\n";
    exit( 1 );
}

/**
 * Query module to get site matrix
 * @ingroup API
 */
class ApiQuerySiteMatrix extends ApiQueryBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'sm');
	}

	public function execute() {
		$result = $this->getResult();
		$matrix = new SiteMatrix();
		$langNames = Language::getLanguageNames();

		$matrix_out = array(
			'count' => $matrix->getCount(),
		);

		$localLanguageNames = SiteMatrixPage::getLocalLanguageNames();

		$params = $this->extractRequestParams();
		$type = array_flip( $params['type'] );
		$state = array_flip( $params['state'] );

		$all = isset( $state['all'] );
		$closed = isset( $state['closed'] );
		$private = isset( $state['private'] );
		$fishbowl = isset( $state['fishbowl'] );

		if ( isset( $type['language'] ) ) {
			foreach ( $matrix->getLangList() as $lang ) {
				$langhost = str_replace( '_', '-', $lang );
				$language = array(
					'code' => $langhost,
					'name' => $langNames[$lang],
					'site' => array(),
				);
				if ( isset( $localLanguageNames[$lang] ) ) {
					$language['localname'] = $localLanguageNames[$lang];
				}

				foreach ( $matrix->getSites() as $site ) {
					if ( $matrix->exist( $lang, $site ) ) {
						$skip = true;

						if ( $all ) {
							$skip = false;
						}

						$url = $matrix->getCanonicalUrl( $lang, $site );
						$site_out = array(
							'url' => $url,
							'dbname' => $matrix->getDBName( $lang, $site ),
							'code' => $site,
						);
						if ( $matrix->isClosed( $lang, $site ) ) {
							$site_out['closed'] = '';
							if ( $closed ) {
								$skip = false;
							}
						}

						if ( $skip ) {
							continue;
						}
						$language['site'][] = $site_out;
					}
				}

				$result->setIndexedTagName( $language['site'], 'site' );
				$matrix_out[] = $language;
			}
		}

		$result->setIndexedTagName( $matrix_out, 'language' );
		$result->addValue( null, "sitematrix", $matrix_out );

		if ( isset( $type['special'] ) ) {

			$specials = array();
			foreach ( $matrix->getSpecials() as $special ){
				list( $lang, $site ) = $special;
				$url = $matrix->getCanonicalUrl( $lang, $site );

				$wiki = array();
				$wiki['url'] = $url;
				$wiki['dbname'] = $matrix->getDBName( $lang, $site );
				$wiki['code'] = str_replace( '_', '-', $lang ) . ( $site != 'wiki' ? $site : '' );

				$skip = true;

				if ( $all ) {
					$skip = false;
				}
				if ( $matrix->isPrivate( $lang . $site ) ) {
					$wiki['private'] = '';

					if ( $private ) {
						$skip = false;
					}
				}
				if ( $matrix->isFishbowl( $lang . $site ) ) {
					$wiki['fishbowl'] = '';

					if ( $fishbowl ) {
						$skip = false;
					}
				}
				if ( $matrix->isClosed( $lang, $site ) ) {
					$wiki['closed'] = '';

					if ( $closed ) {
						$skip = false;
					}
				}

				if ( $skip ) {
					continue;
				}

				$specials[] = $wiki;
			}

			$result->setIndexedTagName( $specials, 'special' );
			$result->addValue( "sitematrix", "specials", $specials );
		}
	}

	public function getAllowedParams() {
		return array(
			'type' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'special',
					'language'
				),
				ApiBase::PARAM_DFLT => 'special|language',
			),
			'state' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'all',
					'closed',
					'private',
					'fishbowl'
				),
				ApiBase::PARAM_DFLT => 'all',
			)
		);
	}

	public function getParamDescription() {
		return array(
			'type' => 'Filter the Site Matrix by type',
			'state' => 'Filter the Site Matrix by wiki state',
		);
	}

	public function getDescription() {
		return array(
			'Get Wikimedia sites list',
			'The code is either the unique identifier for specials else, for languages, the project code',
			'',
			'Wiki types:',
			' special  - One off, and multilingual Wikimedia projects',
			' language - Wikimedia projects under this language code',
			'Wiki states:',
			' closed   - No write access, full read access',
			' private  - Read and write restricted',
			' fishbowl - Restricted write access, full read access',
			);
	}

	public function getExamples() {
		return array(
			'api.php?action=sitematrix',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: SiteMatrixApi.php 107159 2011-12-23 14:49:34Z robin $';
	}
}
