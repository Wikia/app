<?php

if( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'Configure (WMF)',
	'author'         => 'Victor Vasiliev',
	'version'        => '0.1not-for-productional-use',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Configure_(WMF)',
	'description'    => 'Allows to change configuration of Wikimedia sites',
	'descriptionmsg' => 'configurewmf-desc',
);

// Name of the database to store configuration
$wgConfigureDatabase = 'wikiconfig';

// Mapping for extensions => variable to enable them
$wgConfigureExtensions = array(
	'ProofreadPage' => 'wmgUseProofreadPage',
	'LabeledTranscludedSections' => 'wmgUseLST',
	'Quiz' => 'wmgUseQuiz',
	'DynamicPageList' => 'wmgUseDPL',
	'Nuke' => 'wmgUseSpecialNuke',
);

// Available $wgConf tags
$wgConfigureAvailableTags = array( 'default' );

$wgConfigureStdlogo = '$stdlogo';

$wgExtensionMessagesFiles['ConfigureWMF'] = dirname( __FILE__ ) . '/ConfigureWMF.i18n.php';
$wgAutoloadClasses['ConfigureWMF']        = dirname( __FILE__ ) . '/ConfigureWMF.class.php';
$wgAutoloadClasses['SpecialConfigure']    = dirname( __FILE__ ) . '/ConfigureWMF.page.php';

$wgSpecialPages['Configure'] = 'SpecialConfigure';

$wgGroupPermissions['steward']['configure'] = true;
$wgGroupPermissions['developer']['configure'] = true;

$wgAvailableRights[] = 'configure';

$wgLogTypes[]                 = 'config';
$wgLogNames['config']         = 'configurewmf-log';
$wgLogHeaders['config']       = 'configurewmf-log-header';

foreach( ConfigureWMF::$settings as $name => $value ) {
	$logname = $name;
	if( isset( $value['__log__'] ) )
		$logname = $value['__log__'];
	$wgLogActions["config/{$logname}"] = "configurewmf-log-{$name}";
}
unset( $value );
unset( $name );

function efLoadConfiguration() {
	global $wgConfigure;
	if( !isset( $wgConfigure ) ) {
		$wgConfigure = new ConfigureWMF();
	}
}

function efLoadDefaultSettings() {
	global $wgGroupPermissions, $wgDefaultGroupPermissions;
	if( !isset( $wgDefaultGroupPermissions ) ) {
		$wgDefaultGroupPermissions = $wgGroupPermissions;
	}
}

// To be applied on $wgConf->settings
function efApplyConfiguration( &$settings ) {
	global $wgConfigure;
	efLoadConfiguration();
	$wgConfigure->applyConfiguration( $settings );
}
