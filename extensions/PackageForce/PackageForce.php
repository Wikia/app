<?php
/**
 * Package Force extension - creates a special page to download packages of
 * useful templates etc.
 *
 * @file
 * @ingroup Extensions
 * @version 0.1
 * @author Svip <svip[ at ]diku[ dot ]dk>
 * @copyright Copyright © 2010 Svip
 * @link http://www.mediawiki.org/wiki/Extension:PackageForce Documentation
 */

# Alert the user that this is not a valid entry point to MediaWiki if
# they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
This is not a valid entry point, mister!

TRY CATCH AGAIN, EXCEPTION BOY
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Package Force',
	'version' => '0.1',
	'author' => 'Svip',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PackageForce',
	'descriptionmsg' => 'pf-desc',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['PackageForce'] = "$dir/PackageForce.i18n.php";
#$wgExtensionMessagesFiles['PackageForceMagic'] = "$dir/PackageForce.i18n.magic.php";

$wgExtensionMessagesFiles['PackageForceAlias'] = "$dir/PackageForce.alias.php";
$wgSpecialPages['PackageForce'] = 'PackageForceSpecial';
$wgSpecialPages['PackageForceAdmin'] = 'PackageForceAdminSpecial';

# New rights
$wgGroupPermissions['sysop']['packageforce-admin'] = true;
$wgGroupPermissions['sysop']['packageforce-edit'] = true;
$wgAvailableRights[] = 'packageforce-admin';
$wgAvailableRights[] = 'packageforce-edit';

# Create our own namespace
define( 'NS_PACKAGEFORCE', 1300 );
define( 'NS_PACKAGEFORCE_TALK', 1301 );

# Only English for now.
$wgExtraNamespaces[NS_PACKAGEFORCE] = 'PackageForce';
$wgExtraNamespaces[NS_PACKAGEFORCE_TALK] = 'PackageForce_talk';

$wgNamespaceProtection[NS_PACKAGEFORCE] =
	$wgNamespaceProtection[NS_PACKAGEFORCE_TALK] = array( 'packageforce-edit' );

# Database schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efPackageForceSchemaUpdates';

function efPackageForceSchemaUpdates( $updater = null ) {
	$dir = dirname( __FILE__ );

	# DB updates
	if ( $updater === null ) {
		global $wgExtNewTables, $wgDBtype;
		if ( $wgDBtype == 'mysql' ) {
			$wgExtNewTables[] = array( 'packageforce_packages', "$dir/PackageForce.sql" );
		}
	} else {
		if ( $updater->getDB()->getType() == 'mysql' ) {
			$updater->addExtensionUpdate( array( 'addTable', 'packageforce_packages',
				"$dir/PackageForce.sql", true ) );
		}
	}
	return true;
}

class PackageForceAdminSpecial extends SpecialPage {
	var $package = null;
	var $view = 'page';

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'PackageForceAdmin' );
		
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		$this->setHeaders();

		# Only for admins!
		if ( !$wgUser->isAllowed( 'packageforce-admin' ) ) {
			$wgOut->addWikiMsg( 'pf-error-only-admins-allowed' );
			return;
		}

		$menu = array(
			array(
				$this->getTitle()->getFullURL(),
				wfMsg( 'pf-admin-menu-default' )
			),
			array(
				$this->getTitle()->getFullURL(
					wfArrayToCGI( array(
						'view' => 'unsorted',
					) )
				),
				wfMsg( 'pf-admin-menu-unsortedtemplates' )
			),
		);

		$htmlMenu = '';

		foreach ( $menu as $i => $item ) {
			if ( $i !== 0 ) {
				$htmlMenu .= ' | ';
			}
			$htmlMenu .= '<a href="' . $item[0] . '">' . $item[1] . '</a>';
		}

		$wgOut->addHTML(
			'<div>' . $htmlMenu . '</div>'
		);

		# Get request data from, e.g.
		$view = $wgRequest->getText( 'view' );

		switch ( $view ) {
			case 'unsorted':
				$this->view = 'unsorted';
				break;
			default:
				$this->view = 'page';
				break;
		}

		$pager = new PackageForceList( $this );

		$wgOut->addHTML(
			$pager->getLimitForm() . '<br />' .
			$pager->getBody() .
			$pager->getNavigationBar()
		);
	}
}

class PackageForceSpecial extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'PackageForce' );
		
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();

		# Get request data from, e.g.
		$param = $wgRequest->getText( 'param' );

		$output = '';

		$wgOut->addWikiText( $output );
	}

}

class PackageForceList extends TablePager {
	var $listPage;

	static $packageFields = array(
		'page_title',
		'description',
		'content',
	);

	static $pageFields = array(
		'page_title',
		'type',
		'edit',
		'in_packages',
		'documentation',
	);

	static $unsortedFields = array(
		'page_title',
		'edit',
		'approve',
	);

	function __construct( $listPage ) {
		$this->listPage = $listPage;
		if ( $this->listPage->view == 'packages'
			&& $this->listPage->package == null )
		{
			$this->listPage->view = 'page';
		}
		parent::__construct();
	}

	function getQueryInfo() {
		if ( $this->listPage->view == 'page' ) {
			if ( $this->listPage->package != null ) {
				return array(
					'tables' => array(
						'packageforce_package_members',
						'packageforce_packages',
						'page',
					),
					'fields' => array(
						'page_title',
						'page_title AS edit',
						'pm_id AS documentation',
						'pk_name AS in_packages',
						'page_title AS type',
					),
					'conds' => array(
						'pm_package' => $this->listPage->package->getId()
					),
					'join_conds' => array (
						'packageforce_packages' =>
							array( 'join', 'pm_package = pk_id'),
						'page' =>
							array( 'join', 'page_id = pm_page'),
					),
					'options' => array(),
					'conds' => 'page_title NOT LIKE "%/doc/%"',
				);
			} else {
				return array(
					'tables' => array(
						'packageforce_package_members',
						'packageforce_packages',
						'page',
					),
					'fields' => array(
						'page_title',
						'page_id AS edit',
						'pm_id AS documentation',
						'pk_name AS in_packages',
						'page_title AS type',
					),
					'join_conds' => array(
						'packageforce_packages' =>
							array( 'join', 'pm_package = pk_id'),
						'page' =>
							array( 'join', 'page_id = pm_page'),
					),
					'options' => array(),
					'conds' => 'page_title NOT LIKE "%/doc/%"',
				);
			}
		} elseif ( $this->listPage->view == 'packages' ) {
			return array(
				'tables' => 'packageforce_packages',
				'fields' => '*',
				'options' => array()
			);
		} elseif ( $this->listPage->view == 'unsorted' ) {
			return array(
				'tables' => array(
					'page',
					'packageforce_package_members',
				),
				'fields' => array(
					'page_title',
					'page_id AS edit',
					'page_id AS approve',
				),
				'join_conds' => array(
					'packageforce_package_members' =>
						array( 'LEFT JOIN', 'pm_page = page_id'),
				),
				'conds' => array(
					'page_namespace' => NS_PACKAGEFORCE,
					'pm_id IS NULL',
					'page_title NOT LIKE "%/doc/%"',
				),
			);
		}
	}

	function isFieldSortable( $field ) {
		return in_array( $field, array(
			'page_title',
		) );
	}

	function formatValue( $name, $value ) {
		switch ( $name ) {
			case 'page_title':
				$parts = explode( '/', $value );
				if ( count( $parts ) >= 2 && $parts[0] == 'Template' ) {
					return '{{' . $parts[1] . '}}';
				} elseif ( $parts[2] != 'doc' ) {
					return $value;
				}
				return $value;
			case 'in_packages':
				return $value;
			case 'type':
				$parts = explode( '/', $value );
				if ( $parts[0] == 'Template' ) {
					return wfMsg( 'nstab-template' );
				}
				return $value;
			case 'edit':
				$title = Title::newFromID( $value );
				return '<a href="' . $title->getFullURL(wfArrayToCGI( array(
						'action' => 'edit',
					) )) . '">' . wfMsg( 'pf-admin-link-editlink-page' ) . '</a>';
			case 'approve':
				return '<a href="' . $this->listPage->getTitle()->getFullURL(
					wfArrayToCGI( array(
						'view'	=> 'approve',
						'id'	=> $value,
					) )
					) . '">' . wfMsg( 'pf-admin-link-approve' ) . '</a>';
			case 'documentation':
				return '<a href="' . $this->listPage->getTitle()->getFullURL(
					wfArrayToCGI( array(
						'view'	=> 'documentation',
						'id'	=> $value,
					) )
					) . '">' . wfMsg( 'pf-admin-link-view-documentation' ) . '</a>';
			default:
				return htmlspecialchars( $name . ': ' . $value );
		}
	}

	function getDefaultSort() {
		return 'page_title';
	}

	function getFieldNames() {
		$names = array();
		if ( $this->listPage->view == 'page' ) {
			$fields = self::$pageFields;
		} elseif ( $this->listPage->view == 'unsorted' ) {
			$fields = self::$unsortedFields;
		} else {
			$fields = self::$packageFields;
		}
		foreach ( $fields as $field ) {
			$names[$field] = wfMsg( 'pf-header-' . $field );
		}
		return $names;
	}

	function getTitle() {
		return $this->listPage->getTitle();
	}
}
