<?php
error_reporting(E_ALL);
require_once(dirname(__FILE__)."/../commandLine.inc");

$dbr = wfGetDB(DB_MASTER, array(), 'stats');
$dbr2 = wfGetDB(DB_MASTER, array());

$cityDBnames = 'onetreehill
enantm
hellcats
lifeunexpected
90210
gossipgirl
lafemmenikita
smallville
supernatural
vampirediaries
reaper
charmed
gilmoregirls
7thheaven
everybodyhateschris
wwe
startrek
v
lost
lostpedia
sabrinatheteenagewitch
muppet
flashforward
scrubs
bachpad
wipeout
greysanatomy
privatepractice
modernfamily
thegates
desperatehousewives
dancingwiththestars
cougartown
castle
bostonlegal
generalhospital
allmychildren
onelifetolive
pushingdaisies
uglybetty
truegrit
alias
greek
prettylittleliars
secretlife
melissaandjoey
fridaynightlights
gilmoregirls
that70sshow
whatilikeaboutyou';

$cityIds = array();

$cityDBnamesArray = explode("\n", $cityDBnames);

foreach($cityDBnamesArray as $cityDBname) {
	$city_id = $dbr2->selectField('city_list', 'city_id', array('city_dbname' => trim($cityDBname)));
	if(empty($city_id)) {
		echo "No: ".trim($cityDBname);
		exit();
	}
	$cityIds[] = $city_id;
}

foreach($cityIds as $cityId) {

	$res = $dbr->query("select t2.pv_city_id, count(t2.pv_user_id) as c
	from page_views_weekly_user as t1
	inner join page_views_weekly_user as t2 on (t1.pv_user_id = t2.pv_user_id /*and t2.pv_city_id != t1.pv_city_id*/)
	where t1.pv_city_id = ".$cityId."
	group by t2.pv_city_id
	order by c desc
	limit 10;");

	$oneHundredIs = 0;
	
	foreach($res as $row) {
		$city_url = $dbr2->selectField('city_list', 'city_url', array('city_id' => $row->pv_city_id));

		if($cityId == $row->pv_city_id) {
			$oneHundredIs = $row->c;
			echo "\n\nData for wiki: ".$city_url."\n";
		} else {
			echo ceil((100 * $row->c) / $oneHundredIs) . "%\t";
			echo $city_url."\n";
		}
	}
	
	//echo "\n\n";
	
}	
