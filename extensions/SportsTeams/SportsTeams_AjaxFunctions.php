<?php
// This function is referenced by ../LoginReg/SpecialUserRegister.php and
// SpecialUpdateProfile_Sports.php
// This was originally located in UserProfile/UserProfile_AjaxFunctions.php
$wgAjaxExportList[] = 'wfGetSportTeams';
function wfGetSportTeams( $sportId ) {
	$dbr = wfGetDB( DB_MASTER );

	$res = $dbr->select(
		'sport_team',
		array( 'team_id', 'team_name' ),
		array( 'team_sport_id' => intval( $sportId ) ),
		__METHOD__,
		array( 'ORDER BY' => 'team_name' )
	);

	$x = 0;
	$out = '{ "options": [';
	foreach ( $res as $row ) {
		if( $x != 0 ) {
			$out .= ',';
		}
		$out .= " {\"id\":{$row->team_id},\"name\":\"{$row->team_name}\"}";
		$x++;
	}

	$out .= ' ] }';

	return $out;
}