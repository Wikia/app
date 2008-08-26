<?php

/**
 * WikiaApiQueryConfVar - ask for configuration variables
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>
 *
 * @todo use access for giving variables values only with proper access rights
 *
 * $Id: /local/wikia/releases/200712.3/extensions/wikia/WikiaApi/WikiaApiQueryConfGroups.php 2744 2007-12-18T07:35:06.275802Z emil  $
 */
class WikiaApiQueryConfGroups extends ApiQueryBase {

    /**
     * constructor
     */
	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, "wk");
	}

    /**
     * main function
     */
	public function execute() {

        #--- blank variables
        $wikia = $group = $variable = null;

		extract($this->extractRequestParams());

        #--- database instance
		$db =& $this->getDB();
        $db->selectDB( 'wikicities' );

		list( $tbl_cvg, $tbl_cvp, $tbl_cv ) = $db->tableNamesN( "city_variables_groups", "city_variables_pool", "city_variables" );
        if (!is_null( $wikia )) {
            $this->addTables("$tbl_cvp JOIN $tbl_cvg ON cv_variable_group = cv_group_id JOIN $tbl_cv ON cv_id = cv_variable_id");
            $this->addFields( array(
                "cv_group_id",
                "cv_group_name"
            ));
            $this->addWhereFld( "cv_city_id", $wikia );
            if (!is_null( $wikia )) {
                $this->addWhereFld( "cv_id", $variable );
            }
        }
        else {
            $this->addTables("$tbl_cvg");
            $this->addFields( array(
                "cv_group_id",
                "cv_group_name"
            ));
        }

		$data = array();

        $res = $this->select(__METHOD__);
        while ($row = $db->fetchObject($res)) {
            $data[$row->cv_group_id] = array(
                "id"	=> $row->cv_group_id,
                "name"	=> $row->cv_group_name,
            );
            ApiResult :: setContent( $data[$row->cv_group_id], $row->cv_group_name );
        }
		$db->freeResult($res);
		$this->getResult()->setIndexedTagName($data, 'item');
		$this->getResult()->addValue('query', $this->getModuleName(), $data);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: /local/wikia/releases/200712.3/extensions/wikia/WikiaApi/WikiaApiQueryConfGroups.php 2744 2007-12-18T07:35:06.275802Z emil  $';
	}

	public function getDescription() {
		return "Get Wiki configuration variables groups.";
	}

	public function getAllowedParams() {
		return array (
            "wikia" => array (
				ApiBase :: PARAM_TYPE => 'integer'
			)
		);
    }

	public function getParamDescription() {
		return array (
			'wikia' => 'Identifier in Wikia Factory',
		);
	}

	public function getExamples() {
		return array (
			'api.php?action=query&list=wkconfgroups',
			'api.php?action=query&list=wkconfgroups&wkwikia=1588',
		);
	}

};

?>
