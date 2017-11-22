<?php

class DWDimensionApiController extends WikiaApiController {
    const LIMIT = 100;
    const AFTER_DOMAIN = null;

    private function getSharedDbSlave() {
        global $wgExternalSharedDB;
        return wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
    }

	public function getWikiDomains()
    {
        $limit = $this->getRequest()->getVal( 'limit', static::LIMIT );
        $afterDomain = $this->getRequest()->getVal( 'after_domain', static::AFTER_DOMAIN );

        $db = $this->getSharedDbSlave();
        $dbResult = $db->select(
            ["city_domains"],
            ["city_id", "city_domain"],
            isset( $afterDomain ) ? [ "city_domain > ".$afterDomain ] : [],
            __METHOD__,
            [
                "ORDER BY" => "city_domain",
                "LIMIT" => $limit
            ]
        );
        $result = [];
        while ($row = $db->fetchObject($dbResult)) {
            $result[] = [
                'city_id' => $row->city_id,
                'city_domain' => $row->city_domain
            ];
        }

        $this->setResponseData(
            $result,
            null,
            WikiaResponse::CACHE_DISABLED
        );
    }
}