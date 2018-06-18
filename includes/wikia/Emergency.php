<?php
/**
 * Uncomment the following line to disable SemanticMediaWiki and related
 * extensions.
 * @see extensions/SemanticMediaWiki
 * @see extensions/SemanticForms
 * @see extensions/SemanticDrilldown
 * @see extensions/SemanticGallery
 * @see extensions/SemanticResultFormat
 * @see extensions/SemanticScribunto
 * @var bool $wgEnableSemanticMediaWikiExt
 */
// $wgEnableSemanticMediaWikiExt = false; 

/**
 * Uncomment the following line to disable account creation.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 */
// $wgGroupPermissions['*']['createaccount'] = false;

/**
 * Uncomment the following line to disable anonymous editing.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 */
// $wgGroupPermissions['*']['edit'] = false;

/**
 * Uncomment the following lines to disable editing for logged-in users.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 */
// $wgGroupPermissions['user']['edit'] = false;
// $wgGroupPermissions['autoconfirmed']['edit'] = false;

/**
 * Uncomment the following line to disable Nirvana API (wikia.php).
 * @see wikia.php
 * @var bool $wgEnableNirvanaAPI
 */
// $wgEnableNirvanaAPI = false;

/**
 * Uncomment the following line to disable MediaWiki API write operations.
 * @see api.php
 * @var bool $wgEnableWriteAPI
 */
// $wgEnableWriteAPI = false;

/**
 * Uncomment the following line to disable MediaWiki API completely.
 * @see api.php
 * @var bool $wgEnableAPI
 */
// $wgEnableAPI = false;

/**
 * Uncomment the following line to disable creating new communities.
 * @see extensions/wikia/CreateNewWiki
 * @var bool $wgEnableCreateNewWiki
 */
// $wgEnableCreateNewWiki = false;

/**
 * Uncomment the following line to disable per-wiki JavaScript for all
 * communities.
 * @var bool $wgUseSiteJs
 */
// $wgUseSiteJs = false;

/**
 * Uncomment the following lines to disable file uploads.
 * @var bool $wgEnableUploads
 * @var bool $wgAvatarsMaintenance
 * @var bool $wgUploadMaintenance
 */
// $wgEnableUploads = false;
// $wgAvatarsMaintenance = true;
// $wgUploadMaintenance = true;

/**
 * Uncomment the following line to fallback listed actions to 'view'.
 * @var Array $wgDisabledActionsWithViewFallback
 */
// $wgDisabledActionsWithViewFallback = [ 'diff', 'history', 'purge' ];

/**
 * Uncomment the following line to return HTTP 404 when pages from listed
 * namespaces are requested.
 * @var Array $wgWikiaDisabledNamespaces
 */
// $wgWikiaDisabledNamespaces = [ NS_TEMPLATE, NS_SPECIAL ];

/**
 * Uncomment the following line to disable interwiki transcluding.
 * @var bool $wgEnableScaryTranscluding
 */
// $wgEnableScaryTranscluding = false;

/**
 * Uncomment the following line to disable Verbatim extension.
 * @see /extensions/3rdparty/Verbatim
 * @var bool $wgEnableVerbatimExt
 */
// $wgEnableVerbatimExt = false;
