<?php
/**
 * SpecialPage for ResearchTools extension
 * 
 * @file
 * @ingroup Extensions
 */

class SpecialResearchTools extends SpecialPage {

	protected static $pages = array(
		'dashboard' => 'ResearchToolsDashboardPage',
		'surveys' => 'ResearchToolsSurveysPage',
		'clicks' => 'ResearchToolsClicksPage',
		'prefs' => 'ResearchToolsPrefsPage',
	);

	public function __construct() {
		parent::__construct( 'ResearchTools' );
	}

	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest;

		$wgOut->addModules( array( 'ext.researchTools' ) );

		$this->setHeaders();

		$steps = explode( '/', $par );
		$base = array_shift( $steps );
		if ( !isset( self::$pages[$base] ) ) {
			$base = key( self::$pages );
		}

		ob_start();

		self::renderNavigation( $base );

		?><div class="researchTools-page"><?php

		$page = new self::$pages[$base];
		$page->main( $steps );

		?></div><?php

		$wgOut->addHtml( ob_get_clean() );
	}

	protected function renderNavigation( $base ) {
		global $wgUser;

		?>
		<ul class="researchTools-navigation">
			<?php foreach ( self::$pages as $page => $class ): ?>
			<li class="researchTools-navigation-item <?php echo $page == $base ? 'researchTools-navigation-item-current' : '' ?>">
				<?php echo $wgUser->getSkin()->link( $this->getTitle( $page ), wfMsg( "researchtools-page-$page" ) ) ?>
			</li>
			<?php endforeach; ?>
		</ul>
		<div style="clear:both"></div>
		<?php
	}
}
