<?php
/**
 * Implements Special:Piwik
 */

class Piwik extends SpecialPage {
	function __construct() {
		parent::__construct( 'Piwik', 'viewpiwik' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgPiwikURL, $wgScriptPath, $wgPiwikIDSite, $wgPiwikSpecialPageDate;

		

		$this->setHeaders();

		$wgOut->setPagetitle( 'Piwik' );

		$selfTitle = $this->getTitle();

		$lastvisits = wfMsg( 'piwik-lastvisits' );
		$countries = wfMsg( 'piwik-countries' );
		$browsers = wfMsg( 'piwik-browsers' );

		if ( $wgPiwikSpecialPageDate != 'today' && $wgPiwikSpecialPageDate != 'yesterday' ) {
			$wgPiwikSpecialPageDate = 'yesterday';
		}
		

		// checking
		$piwikpage = <<<PIWIK
		<h2>{$lastvisits}</h2>
		<iframe src="http://{$wgPiwikURL}index.php?module=Widgetize&amp;action=iframe&amp;columns[]=nb_visits&amp;moduleToWidgetize=VisitsSummary&amp;actionToWidgetize=getEvolutionGraph&amp;idSite={$wgPiwikIDSite}&amp;period=day&amp;date=last30&amp;disableLink=1" marginheight="0" marginwidth="0" frameborder="0" height="250" scrolling="no" width="100%"></iframe>

		<h2>{$countries}</h2>
		<iframe src="http://{$wgPiwikURL}index.php?module=Widgetize&amp;action=iframe&amp;moduleToWidgetize=UserCountry&amp;actionToWidgetize=getCountry&amp;idSite={$wgPiwikIDSite}&amp;period=day&amp;date={$wgPiwikSpecialPageDate}&amp;disableLink=1" marginheight="0" marginwidth="0" frameborder="0" scrolling="no" height="400" width="100%"></iframe>

		<h2>{$browsers}</h2>
		<iframe src="http://{$wgPiwikURL}index.php?module=Widgetize&amp;action=iframe&amp;moduleToWidgetize=UserSettings&amp;actionToWidgetize=getBrowser&amp;idSite={$wgPiwikIDSite}&amp;period=day&amp;date={$wgPiwikSpecialPageDate}&amp;disableLink=1" marginheight="0" marginwidth="0" frameborder="0" scrolling="no" height="400" width="100%"></iframe>

PIWIK;

		$wgOut->addHTML( $piwikpage );
	}
}
