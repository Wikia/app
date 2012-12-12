<?
$tabs = array(
	'main' 			=> array('url' => sprintf( "%s/main", $mTitle->getLocalUrl() ), 'text' => wfMsg('wikistats_main_statistics_legend') )
);

if ( $userIsSpecial ) {
	$tabs['rollup']			= array('url' => sprintf( "%s/rollup", $mTitle->getLocalUrl() ), 'text' => wfMsg('wikistats_rollups') );
	if ( $wgCityId == 177 ) {
		$tabs['namespaces']		= array('url' => sprintf( "%s/namespaces", $mTitle->getLocalUrl() ), 'text' => wfMsg('wikistats_ns_statistics_legend') );
	}
	$tabs['breakdown'] 		= array('url' => sprintf( "%s/breakdown", $mTitle->getLocalUrl() ), 'text' => wfMsg('wikistats_breakdown_editors') );
	$tabs['anonbreakdown'] 	= array('url' => sprintf( "%s/anonbreakdown", $mTitle->getLocalUrl() ), 'text' => wfMsg('wikistats_breakdown_anons') );
	$tabs['activity'] 		= array('url' => sprintf( "%s/activity", $mTitle->getLocalUrl() ), 'text' => wfMsg('wikistats_active_useredits') );
}
?>
<div id="ws-addinfo" class="ws-addinfo"></div>
<ul id="ws_action_tabs" class="tabs">
<? foreach ( $tabs as $id => $values ) : ?>		
	<li id="ws_tab_<?=$id?>" class="<?= ($id == $mAction) ? 'selected' : ''?>"><a rel="nofollow" href="<?=$values['url']?>"><?=$values['text']?></a></li>
<? endforeach ?>
</ul>
