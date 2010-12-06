<?
$tabs = array(
	'main' 			=> array('url' => sprintf( "%s/main", $mTitle->getLocalUrl() ), 'text' => wfMsg('search') ),
	'monthly' 		=> array('url' => sprintf( "%s/monthly", $mTitle->getLocalUrl() ), 'text' => wfMsg('awc-metrics-hubs') ),
	'daily' 		=> array('url' => sprintf( "%s/daily", $mTitle->getLocalUrl() ), 'text' => wfMsg('awc-metrics-news-day') )	
);
?>
<div id="wfm-tabs" class="wikia-tabs">
	<ul id="wfm_action_tabs">
<? foreach ( $tabs as $id => $values ) : ?>		
		<li id="wfm_tab_<?=$id?>" class="<?= ($id == $mAction) ? 'selected' : ''?>"><a rel="nofollow" href="<?=$values['url']?>"><?=$values['text']?></a></li>
<? endforeach ?>
	</ul>
</div>
