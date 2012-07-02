<?php
/**
 * OpenStackManager extension - lets users manage nova and swift
 *
 *
 * For more info see http://mediawiki.org/wiki/Extension:OpenStackManager
 *
 * @file
 * @ingroup Extensions
 * @author Ryan Lane <rlane@wikimedia.org>
 * @copyright © 2010 Ryan Lane
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'OpenStackManager',
	'author' => 'Ryan Lane',
	'version' => '1.3',
	'url' => 'http://mediawiki.org/wiki/Extension:OpenStackManager',
	'descriptionmsg' => 'openstackmanager-desc',
);

define( "NS_NOVA_RESOURCE", 498 );
define( "NS_NOVA_RESOURCE_TALK", 499 );
$wgExtraNamespaces[NS_NOVA_RESOURCE] = 'Nova_Resource';
$wgExtraNamespaces[NS_NOVA_RESOURCE_TALK] = 'Nova_Resource_Talk';
$wgContentNamespaces[] = NS_NOVA_RESOURCE;

$wgGroupPermissions['sysop']['manageproject'] = true;
$wgAvailableRights[] = 'manageproject';

$wgOpenStackManagerNovaDisableSSL = true;
$wgOpenStackManagerNovaServerName = 'localhost';
$wgOpenStackManagerNovaPort = 8773;
$wgOpenStackManagerNovaResourcePrefix = '/services/Cloud/';
$wgOpenStackManagerNovaAdminResourcePrefix = '/services/Admin/';
$wgOpenStackManagerNovaAdminKeys = array( 'accessKey' => '', 'secretKey' => '' );
$wgOpenStackManagerNovaKeypairStorage = 'ldap';
$wgOpenStackManagerLDAPDomain = '';
$wgOpenStackManagerLDAPUser = '';
$wgOpenStackManagerLDAPUserPassword = '';
$wgOpenStackManagerLDAPProjectBaseDN = '';
$wgOpenStackManagerLDAPGlobalRoles = array(
	'sysadmin' => '',
	'netadmin' => '',
	'cloudadmin' => '',
	);
$wgOpenStackManagerLDAPRolesIntersect = false;
$wgOpenStackManagerLDAPInstanceBaseDN = '';
$wgOpenStackManagerLDAPSudoerBaseDN = '';
$wgOpenStackManagerLDAPDefaultGid = '500';
$wgOpenStackManagerLDAPDefaultShell = '/bin/bash';
$wgOpenStackManagerDNSServers = array( 'primary' => 'localhost', 'secondary' => 'localhost' );
$wgOpenStackManagerDNSSOA = array(
	'hostmaster' => 'hostmaster@localhost.localdomain',
	'refresh' => '1800',
	'retry' => '3600',
	'expiry' => '86400',
	'minimum' => '7200'
	);
$wgOpenStackManagerPuppetOptions = array(
	'enabled' => false,
	'defaultclasses' => array(),
	'defaultvariables' => array(),
	'availableclasses' => array(),
	'availablevariables' => array(),
	);
$wgOpenStackManagerInstanceUserData = array(
	'cloud-config' => array(),
	'scripts' => array(),
	'upstarts' => array(),
	);
$wgOpenStackManagerInstanceDefaultImage = "";
$wgOpenStackManagerCreateResourcePages = true;
$wgOpenStackManagerCreateProjectSALPages = true;
$wgOpenStackManagerLDAPUseUidAsNamingAttribute = false;
$wgOpenStackManagerNovaDefaultProject = "";

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['OpenStackManager'] = $dir . 'OpenStackManager.i18n.php';
$wgExtensionMessagesFiles['OpenStackManagerAlias'] = $dir . 'OpenStackManager.alias.php';
$wgAutoloadClasses['OpenStackNovaInstance'] = $dir . 'OpenStackNovaInstance.php';
$wgAutoloadClasses['OpenStackNovaInstanceType'] = $dir . 'OpenStackNovaInstanceType.php';
$wgAutoloadClasses['OpenStackNovaImage'] = $dir . 'OpenStackNovaImage.php';
$wgAutoloadClasses['OpenStackNovaKeypair'] = $dir . 'OpenStackNovaKeypair.php';
$wgAutoloadClasses['OpenStackNovaController'] = $dir . 'OpenStackNovaController.php';
$wgAutoloadClasses['OpenStackNovaUser'] = $dir . 'OpenStackNovaUser.php';
$wgAutoloadClasses['OpenStackNovaDomain'] = $dir . 'OpenStackNovaDomain.php';
$wgAutoloadClasses['OpenStackNovaHost'] = $dir . 'OpenStackNovaHost.php';
$wgAutoloadClasses['OpenStackNovaAddress'] = $dir . 'OpenStackNovaAddress.php';
$wgAutoloadClasses['OpenStackNovaSecurityGroup'] = $dir . 'OpenStackNovaSecurityGroup.php';
$wgAutoloadClasses['OpenStackNovaSecurityGroupRule'] = $dir . 'OpenStackNovaSecurityGroupRule.php';
$wgAutoloadClasses['OpenStackNovaRole'] = $dir . 'OpenStackNovaRole.php';
$wgAutoloadClasses['OpenStackNovaVolume'] = $dir . 'OpenStackNovaVolume.php';
$wgAutoloadClasses['OpenStackNovaSudoer'] = $dir . 'OpenStackNovaSudoer.php';
$wgAutoloadClasses['OpenStackNovaArticle'] = $dir . 'OpenStackNovaArticle.php';
$wgAutoloadClasses['OpenStackNovaHostJob'] = $dir . 'OpenStackNovaHostJob.php';
$wgAutoloadClasses['OpenStackNovaPuppetGroup'] = $dir . 'OpenStackNovaPuppetGroup.php';
$wgAutoloadClasses['OpenStackNovaLdapConnection'] = $dir . 'OpenStackNovaLdapConnection.php';
$wgAutoloadClasses['SpecialNovaInstance'] = $dir . 'special/SpecialNovaInstance.php';
$wgAutoloadClasses['SpecialNovaKey'] = $dir . 'special/SpecialNovaKey.php';
$wgAutoloadClasses['SpecialNovaProject'] = $dir . 'special/SpecialNovaProject.php';
$wgAutoloadClasses['SpecialNovaDomain'] = $dir . 'special/SpecialNovaDomain.php';
$wgAutoloadClasses['SpecialNovaAddress'] = $dir . 'special/SpecialNovaAddress.php';
$wgAutoloadClasses['SpecialNovaSecurityGroup'] = $dir . 'special/SpecialNovaSecurityGroup.php';
$wgAutoloadClasses['SpecialNovaRole'] = $dir . 'special/SpecialNovaRole.php';
$wgAutoloadClasses['SpecialNovaVolume'] = $dir . 'special/SpecialNovaVolume.php';
$wgAutoloadClasses['SpecialNovaSudoer'] = $dir . 'special/SpecialNovaSudoer.php';
$wgAutoloadClasses['SpecialNovaPuppetGroup'] = $dir . 'special/SpecialNovaPuppetGroup.php';
$wgAutoloadClasses['SpecialNova'] = $dir . 'special/SpecialNova.php';
$wgAutoloadClasses['AmazonEC2'] = $dir . 'aws-sdk/sdk.class.php';
$wgAutoloadClasses['Spyc'] = $dir . 'Spyc.php';
$wgSpecialPages['NovaInstance'] = 'SpecialNovaInstance';
$wgSpecialPageGroups['NovaInstance'] = 'nova';
$wgSpecialPages['NovaKey'] = 'SpecialNovaKey';
$wgSpecialPageGroups['NovaKey'] = 'nova';
$wgSpecialPages['NovaProject'] = 'SpecialNovaProject';
$wgSpecialPageGroups['NovaProject'] = 'nova';
$wgSpecialPages['NovaDomain'] = 'SpecialNovaDomain';
$wgSpecialPageGroups['NovaDomain'] = 'nova';
$wgSpecialPages['NovaAddress'] = 'SpecialNovaAddress';
$wgSpecialPageGroups['NovaAddress'] = 'nova';
$wgSpecialPages['NovaSecurityGroup'] = 'SpecialNovaSecurityGroup';
$wgSpecialPageGroups['NovaSecurityGroup'] = 'nova';
$wgSpecialPages['NovaRole'] = 'SpecialNovaRole';
$wgSpecialPageGroups['NovaRole'] = 'nova';
$wgSpecialPages['NovaVolume'] = 'SpecialNovaVolume';
$wgSpecialPageGroups['NovaVolume'] = 'nova';
$wgSpecialPages['NovaSudoer'] = 'SpecialNovaSudoer';
$wgSpecialPageGroups['NovaSudoer'] = 'nova';
$wgJobClasses['addDNSHostToLDAP'] = 'OpenStackNovaHostJob';
$wgSpecialPageGroups['NovaPuppetGroup'] = 'nova';
$wgSpecialPages['NovaPuppetGroup'] = 'SpecialNovaPuppetGroup';

$wgHooks['LDAPSetCreationValues'][] = 'OpenStackNovaUser::LDAPSetCreationValues';
$wgHooks['LDAPModifyUITemplate'][] = 'OpenStackNovaUser::LDAPModifyUITemplate';
$wgHooks['LDAPUpdateUser'][] = 'OpenStackNovaUser::LDAPSetNovaInfo';

$commonModuleInfo = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'OpenStackManager/modules',
);

$wgResourceModules['ext.openstack'] = array(
	'styles' => 'ext.openstack.css',
) + $commonModuleInfo;

require_once( $dir . 'OpenStackNovaProject.php' );

# Schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efOpenStackSchemaUpdates';

/**
 * @param $updater DatabaseUpdater
 * @return bool
 */
function efOpenStackSchemaUpdates( $updater ) {
	$base = dirname( __FILE__ );
	switch ( $updater->getDB()->getType() ) {
	case 'mysql':
		$updater->addExtensionTable( 'openstack_puppet_groups', "$base/openstack.sql" );
		$updater->addExtensionTable( 'openstack_puppet_vars', "$base/openstack.sql" );
		$updater->addExtensionTable( 'openstack_puppet_classes', "$base/openstack.sql" );
		$updater->addExtensionUpdate( array( 'addField', 'openstack_puppet_groups', 'group_project', "$base/schema-changes/openstack_project_field.sql", true ) );
		break;
	}
	return true;
}
