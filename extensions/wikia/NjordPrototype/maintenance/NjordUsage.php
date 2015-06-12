<?php
/**
 * Maintenance script for generating CSV file with data about NJORD (MOM) usage.
 * Usage: $ SERVER_ID=1 php /usr/wikia/source/wiki/extensions/wikia/NjordPrototype/maintenance/NjordUsage.php
 */
ini_set( 'display_errors', '1' );
ini_set( 'error_reporting', E_ALL );

require_once( dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );
require_once( dirname( __FILE__ ) . '/../models/WikiDataModel.class.php' );

class NjordUsage extends Maintenance {

	static $wikiaData = [];

	const NJORD_VAR_NAME = 'wgEnableNjordExt';
	const NJORD_ARTICLE_PROP_TITLE = 'TITLE';
	const NJORD_ARTICLE_PROP_DESCR = 'DESCRIPTION';
	const NJORD_ARTICLE_PROP_IMAGE = 'IMAGE';
	const WIKI_CREATION_DATE = 'WIKI_CREATION_DATE';

	/**
	 * @param $cityId
	 * @return array
	 */
	public function getNjordData( $cityId ) {
		$db = $this->getDatabaseByCityId( $cityId );

		$sql = 'SELECT * FROM page_wikia_props WHERE propname IN (' .
			implode( ", ", array_values( $this->getNjordPropIds() ) ) . ')';

		$res = $db->query( $sql );
		$props = [];
		while ( $prop = $db->fetchObject( $res ) ) {
			$props[ $prop->propname ] = unserialize( $prop->props );
		}
		return $props;
	}

	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		$city_list_with_njord_ext = $this->getWikiIDsWithNjordExt();
		$date_created = $this->getWikiCreationDates( $city_list_with_njord_ext );

		if ( count( $city_list_with_njord_ext ) > 0 ) {
			$outputCSV = [];
			$outputHTML = [];
			foreach ( $city_list_with_njord_ext as $cityId ) {
				$njordData = $this->getNjordData( $cityId );
				$outputCSV[ ] = $this->formatOutputRowCSV( $cityId, $njordData, $date_created[ $cityId ] );
				$outputHTML[ ] = $this->formatOutputRowHTML( $cityId, $njordData );
			}
			$this->exportToCSV( $outputCSV );
			$this->exportToHTML( $outputHTML );
		} else {
			echo "COULD NOT FIND WIKIS WITH NJORD ENABLED!";
		}
	}

	public function getWikiCreationDates( $city_list ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$sql = 'SELECT city_id, city_created FROM city_list
				WHERE city_id IN (' . implode( ", ", $city_list ) . ')';

		$res = $dbr->query( $sql );

		$wikis = array();
		while($row = $dbr->fetchObject($res)) {
			$wikis[$row->city_id] = $row->city_created;
		}
		return $wikis;
	}

	/**
	 * @return string
	 */
	private function getOutputFileName( $ext = "csv" ) {
		return 'njord_' . date( "Y_m_d" ) . ".{$ext}";
	}

	private function exportToHTML( $data ) {
		$html_output = '<!doctype html>';
		$html_output .= '<html lang="en">';
		$html_output .= '<head><meta charset="utf-8"></head>';
		$html_output .= '<body>';
		$html_output .= '<table border="1">';
		$html_output .= '<tr>';
		$html_output .= '<th>Wikia</th>';
		$html_output .= '<th>' . self::NJORD_ARTICLE_PROP_TITLE . '</th>';
		$html_output .= '<th>' . self::NJORD_ARTICLE_PROP_DESCR . '</th>';
		$html_output .= '<th>' . self::NJORD_ARTICLE_PROP_IMAGE . '</th>';
		$html_output .= '</tr>';
		foreach ( $data as $row ) {
			$html_output .= '<tr>';
			$html_output .= '<td><a href="' . $row[ 'wiki_url' ] . '">' . $row[ 'wiki_url' ] . '</a></td>';
			$html_output .= '<td>' . htmlspecialchars( $row[ self::NJORD_ARTICLE_PROP_TITLE ] ) . '</td>';
			$html_output .= '<td>' . htmlspecialchars( $row[ self::NJORD_ARTICLE_PROP_DESCR ] ) . '</td>';
			$html_output .= '<td>
								<a href="' . $row[ self::NJORD_ARTICLE_PROP_IMAGE ] . '">
									<img width="400" src="' . $row[ self::NJORD_ARTICLE_PROP_IMAGE ] . '" alt="" />
								</a>
							</td>';
			$html_output .= '</tr>';
		}
		$html_output .= '</table>';
		$html_output .= '</body></html>';

		file_put_contents( $this->getOutputFileName( "html" ), $html_output );
		echo "DONE: " . $this->getOutputFileName( "html" ) . "\n";
	}

	/**
	 * @param $data
	 */
	private function exportToCSV( $data ) {
		if ( count( $data ) > 0 ) {
			$fp = fopen( $this->getOutputFileName(), 'w' );
			fputcsv( $fp, array_keys( $data[ 0 ] ), "\t" );
			foreach ( $data as $fields ) {
				fputcsv( $fp, $fields, "\t" );
			}
			fclose( $fp );
			echo "DONE: " . $this->getOutputFileName() . "\n";
		} else {
			echo "EMPTY DATASET.";
		}
	}

	/**
	 * @return array
	 */
	private function getWikiIDsWithNjordExt() {
		$db = wfGetDB( DB_MASTER, array(), 'wikicities' );
		$sql = 'SELECT cv_id FROM `city_variables_pool` WHERE cv_name="' . self::NJORD_VAR_NAME . '"';
		$res = $db->query( $sql );
		$cv_id = $db->fetchObject( $res );
		$city_list_with_njord_ext = [];
		if ( $cv_id ) {
			$cv_id = $cv_id->cv_id;
			$sql = 'SELECT cv_city_id FROM city_variables
					WHERE cv_variable_id=' . (int) $cv_id . ' AND cv_value="' . serialize( true ) . '" ORDER BY cv_city_id';

			$res = $db->query( $sql );
			while ( $cv = $db->fetchObject( $res ) ) {
				$cv_id = $cv->cv_city_id;
				$city_list_with_njord_ext[ ] = $cv_id;
			}
		}
		return $city_list_with_njord_ext;
	}

	/**
	 * @param $cityId
	 * @param $data
	 * @return array
	 */
	private function formatOutputRowHTML( $cityId, $data ) {
		$njordProps = $this->getNjordPropIds();

		$row = [];

		$row[ "wiki_url" ] = $this->getWikiaDataById( $cityId )->city_url;

		$row[ self::NJORD_ARTICLE_PROP_TITLE ] = $data[ $njordProps[ self::NJORD_ARTICLE_PROP_TITLE ] ];

		$row[ self::NJORD_ARTICLE_PROP_DESCR ] = $data[ $njordProps[ self::NJORD_ARTICLE_PROP_DESCR ] ];

		if ( !empty( $data[ $njordProps[ self::NJORD_ARTICLE_PROP_IMAGE ] ] ) ) {
			$heroImageTitle = $data[ $njordProps[ self::NJORD_ARTICLE_PROP_IMAGE ] ];
			$image = GlobalFile::newFromText( $heroImageTitle, $cityId );
			$row[ self::NJORD_ARTICLE_PROP_IMAGE ] = $image->getUrlGenerator()->original()->url();
		} else {
			$row[ self::NJORD_ARTICLE_PROP_IMAGE ] = null;
		}

		return $row;
	}

	/**
	 * @param $cityId
	 * @param $data
	 * @return array
	 */
	private function formatOutputRowCSV( $cityId, $data, $date_created ) {
		$njordProps = $this->getNjordPropIds();

		$row = [];

		$row[ "wiki_url" ] = $this->getWikiaDataById( $cityId )->city_url;

		$row[ self::NJORD_ARTICLE_PROP_TITLE . "_EXISTS" ] =
			(int) !empty( $data[ $njordProps[ self::NJORD_ARTICLE_PROP_TITLE ] ] );

		$row[ self::NJORD_ARTICLE_PROP_DESCR . "_EXISTS" ] =
			(int) !empty( $data[ $njordProps[ self::NJORD_ARTICLE_PROP_DESCR ] ] );

		$row[ self::NJORD_ARTICLE_PROP_IMAGE . "_EXISTS" ] =
			(int) !empty( $data[ $njordProps[ self::NJORD_ARTICLE_PROP_IMAGE ] ] );

		$row[ self::WIKI_CREATION_DATE ] = $date_created;

		return $row;
	}

	/**
	 * @param $cityId
	 * @return mixed
	 */
	private function getWikiaDataById( $cityId ) {
		if ( empty( self::$wikiaData[ $cityId ] ) ) {
			self::$wikiaData[ $cityId ] = WikiFactory::getWikiByID( $cityId );
		}
		return self::$wikiaData[ $cityId ];
	}

	/**
	 * @param $cityId
	 * @return DatabaseBase|TotallyFakeDatabase
	 */
	private function getDatabaseByCityId( $cityId ) {
		$wikia = $this->getWikiaDataById( $cityId );
		$wikiaDbName = $wikia->city_dbname;
		$db = wfGetDB( DB_SLAVE, array(), $wikiaDbName );
		return $db;
	}


	/**
	 * @return array
	 */
	private function getNjordPropIds() {
		return [
			self::NJORD_ARTICLE_PROP_DESCR => WikiDataModel::WIKI_HERO_DESCRIPTION_ID,
			self::NJORD_ARTICLE_PROP_TITLE => WikiDataModel::WIKI_HERO_TITLE_PROP_ID,
			self::NJORD_ARTICLE_PROP_IMAGE => WikiDataModel::WIKI_HERO_IMAGE_PROP_ID
		];
	}
}

$maintClass = 'NjordUsage';
require_once( DO_MAINTENANCE );
