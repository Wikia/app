<?
/**
 * @var $adSlot
 * @var $wf WikiaFunctionWrapper
 */
?>
<aside id=wkAdPlc>
<div id=wkAdCls><?= $wf->Msg('wikiamobile-ad-close') ?></div>
<div id=wkAdWrp><script>window.addEventListener('load', function () {
	require(['ads'], function (ads) { ads.setupSlot('MOBILE_TOP_LEADERBOARD', '5x5', 'DARTMobile'); });
});</script></div>
</aside>
