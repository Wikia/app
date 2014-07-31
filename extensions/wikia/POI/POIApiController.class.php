<?php

class POIApiController extends WikiaApiController {
	public function getNearbyQuests(){
		$data = json_decode('{
		  "quests": [
		    {
		      "id": 1234,
		      "title": "Meera Reed",
		      "ns": 0,
		      "url": "/wiki/Meera_Reed",
		      "revision": {
		        "id": 8792,
		        "user": "MarkvA",
		        "user_id": 1171508,
		        "timestamp": "1390496670"
		      },
		      "comments": 0,
		      "type": "article",
		      "abstract": "Quest description...",
		       "thumbnail": "http://img2.wikia.nocookie.net/__cb20140618075345/gameofthrones/images/thumb/6/62/Meera-Reed-Profile_2-HD.png/200px-0%2C523%2C0%2C523-Meera-Reed-Profile_2-HD.png",
		      "original_dimensions": {
		        "width": "523",
		        "height": "670"
		      },
		      "categories": [
		        "Weapons",
		        "Items"
		      ],
		      "metadata": {
		        "quest_id": "GP_Orc_3",
		        "map_location_x": 12.34,
		        "map_location_y": 56.78,
		        "map_region": "Map_Region_1",
		        "fingerprints": [
		          "fingerprint_1",
		          "fingerprint_2"
		        ]
		      }
		    }
		  ],
		  "basepath": "http://gameofthrones.wikia.com"
		}', true );

		$this->setResponseData( $data );
	}

	public function getNearbyQuests4Real() { //TODO: rename it to getNearbyQuests
		$lat = $this->request->getVal("lat");
		$long = $this->request->getVal("long");

		$nearBySearch = $movieSearch = new Wikia\Search\Services\NearbyPOISearchService();
		$resp = $nearBySearch->queryLocation($lat, $long);
		var_dump( $resp );
		die;
	}
}