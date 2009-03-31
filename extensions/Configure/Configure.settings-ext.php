<?php
/**
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Array of all configurable extensions
 */
$extensions = array(

	// A
	array(
		'name' => 'AbsenteeLandlord',
		'settings' => array(
			'wgAbsenteeLandlordMaxDays' => 'int',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:AbsenteeLandlord',
	),
	array(
		'name' => 'AbuseFilter',
		'settings' => array(
			'wgAbuseFilterAvailableActions' => 'array',
			'wgAbuseFilterConditionLimit' => 'int',
			'wgAbuseFilterEmergencyDisableThreshold' => 'text', // FIXME: float
			'wgAbuseFilterEmergencyDisableCount' => 'int',
			'wgAbuseFilterEmergencyDisableAge' => 'int',
			'wgAbuseFilterParserClass' => 'text',
			'wgAbuseFilterNativeParser' => 'text',
			'wgAbuseFilterNativeSyntaxCheck' => 'text',
			'wgAbuseFilterNativeExpressionEvaluator' => 'text',
		),
		'array' => array(
			'wgAbuseFilterAvailableActions' => 'simple',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:AbuseFilter',
	),
	array(
		'name' => 'AdvancedRandom',
		'file' => 'SpecialAdvancedRandom.php',
	),
	array(
		'name' => 'AjaxQueryPages',
		'file' => 'Load.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:AjaxQueryPages',
	),
	array(
		'name' => 'AjaxShowEditors',
		'file' => 'Load.php',
		'settings' => array(
			'wgAjaxShowEditorsTimeout' => 'int',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:AjaxShowEditors',
	),
	array(
		'name' => 'AntiBot',
		'settings' => array(
			'wgAntiBotSecret' => 'text',
			'wgAntiBotPayloads' => 'array',
			'wgAntiBotPayloadTypes' => 'array',
		),
		'array' => array(
			'wgAntiBotPayloads' => 'array',
			'wgAntiBotPayloadTypes' => 'array',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:AntiBot',
	),
	array(
		'name' => 'AntiSpoof',
		'settings' => array(
			'wgAntiSpoofAccounts' => 'bool',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:AntiSpoof',
	),
	array(
		'name' => 'APC',
		'file' => 'ViewAPC.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:APC',
	),
	array(
		'name' => 'Asksql',
		'settings' => array(
			'wgAllowSysopQueries' => 'bool',
			'wgSqlLogFile' => 'text',
			'wgDBsqlpassword' => 'text',
			'wgDBsqluser' => 'text',
		),
		'view-restricted' => array(
			'wgDBsqlpassword',
			'wgDBsqluser',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Asksql',
	),
	array(
		'name' => 'AssertEdit',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Assert_Edit',
	),
	array(
		'name' => 'AuthorProtect',
		'url' => 'http://www.mediawiki.org/wiki/Extension:AuthorProtect',
	),
	array(
		'name' => 'Autoincrement',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Autoincrement',
	),

	// B
	array(
		'name' => 'Babel',
		'settings' => array(
			'wgBabelUseLevelZeroCategory' => 'bool',
			'wgBabelUseSimpleCategories' => 'bool',
			'wgBabelUseMainCategories' => 'bool',
			'wgLanguageCodesFiles' => 'array',
		),
		'array' => array(
			'wgLanguageCodesFiles' => 'assoc',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Babel',
	),
	array(
		'name' => 'BackAndForth',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Back-and-Forth',
	),
	array(
		'name' => 'BadImage',
		'settings' => array(
			'wgBadImageCache' => 'bool',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:Bad_Image_List',
	),
	array(
		'name' => 'Blahtex',
		'settings' => array(
			'wgBlahtex' => 'text',
			'wgBlahtexOptions' => 'text',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Blahtex',
	),
	array(
		'name' => 'BlockTitles',
		'settings' => array(
			'wgBlockTitlePatterns' => 'array',
		),
		'array' => array(
			'wgBlockTitlePatterns' => 'simple',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:BlockTitles',
	),
	array(
		'name' => 'BoardVote',
		'settings' => array(
			'wgBoardVoteDB' => 'text',
			'wgBoardCandidates' => 'array',
			'wgGPGCommand' => 'text',
			'wgGPGRecipient' => 'text',
			'wgGPGHomedir' => 'text',
			'wgGPGPubKey' => 'text',
			'wgBoardVoteEditCount' => 'int',
			'wgBoardVoteRecentEditCount' => 'int',
			'wgBoardVoteCountDate' => 'text',
			'wgBoardVoteRecentFirstCountDate' => 'text',
			'wgBoardVoteRecentCountDate' => 'text',
			'wgBoardVoteStartDate' => 'text',
			'wgBoardVoteEndDate' => 'text',
			'wgBoardVoteDBServer' => 'text',
		),
		'array' => array(
			'wgBoardCandidates' => 'simple',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:BoardVote',
	),
	array(
		'name' => 'BookInformation',
		'settings' => array(
			'wgBookInformationCache' => 'bool',
			'wgBookInformationDriver' => 'text',
			'wgBookInformationService' => 'array',
		),
		'array' => array(
			'wgBookInformationService' => 'assoc',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:BookInformation',
	),
	array(
		'name' => 'BreadCrumbs',
		'settings' => array(
			'wgBreadCrumbsDelimiter' => 'text',
			'wgBreadCrumbsCount' => 'int',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:BreadCrumbs',
	),

	// C
	array(
		'name' => 'Call',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Call',
	),
	array(
		'name' => 'CategoryIntersection',
		'url' => 'http://www.mediawiki.org/wiki/Extension:CategoryIntersection',
	),
	array(
		'name' => 'CategoryStepper',
		'settings' => array(
			'wgCategoryStepper' => 'array',
		),
		'array' => array(
			'wgCategoryStepper' => 'assoc',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:CategoryStepper',
	),
	array(
		'name' => 'CategoryTree',
		'settings' => array(
			'wgCategoryTreeMaxChildren' => 'int',
			'wgCategoryTreeAllowTag' => 'bool',
			'wgCategoryTreeDisableCache' => 'bool',
			'wgCategoryTreeDynamicTag' => 'bool',
			'wgCategoryTreeHTTPCache' => 'bool',
			'wgCategoryTreeForceHeaders' => 'bool',
			'wgCategoryTreeSidebarRoot' => 'text',
			'wgCategoryTreeHijackPageCategories' => 'bool',
			'wgCategoryTreeUnifiedView' => 'bool',
			'wgCategoryTreeMaxDepth' => 'array',
			'wgCategoryTreeExtPath' => 'text',
			# 'wgCategoryTreeVersion' => 'int',
			# 'wgCategoryTreeUseCategoryTable' => 'bool',
			'wgCategoryTreeOmitNamespace' => array( 0 => 'Never', 10 => 'Always', 20 => 'Category', 30 => 'Auto' ),
			'wgCategoryTreeDefaultMode' => array( 0 => 'Categories', 10 => 'Pages', 20 => 'All' ),
			'wgCategoryTreeCategoryPageMode' => array( 0 => 'Categories', 10 => 'Pages', 20 => 'All' ),
			'wgCategoryTreeDefaultOptions' => 'array',
			'wgCategoryTreeCategoryPageOptions' => 'array',
			'wgCategoryTreeSpecialPageOptions' => 'array',
			'wgCategoryTreeSidebarOptions' => 'array',
			'wgCategoryTreePageCategoryOptions' => 'array',
		),
		'array' => array(
			'wgCategoryTreeMaxDepth' => 'assoc',
			'wgCategoryTreeDefaultOptions' => 'assoc',
			'wgCategoryTreeCategoryPageOptions' => 'assoc',
			'wgCategoryTreeSpecialPageOptions' => 'assoc',
			'wgCategoryTreeSidebarOptions' => 'assoc',
			'wgCategoryTreePageCategoryOptions' => 'assoc',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:CategoryTree',
	),
	array(
		'name' => 'catfeed',
	),
	array(
		'name' => 'CentralAuth',
		'settings' => array(
			'wgCentralAuthDatabase' => 'text',
			'wgCentralAuthAutoNew' => 'bool',
			'wgCentralAuthAutoMigrate' => 'bool',
			'wgCentralAuthStrict' => 'bool',
			'wgCentralAuthDryRun' => 'bool',
			'wgCentralAuthCookies' => 'bool',
			'wgCentralAuthCookieDomain' => 'text',
			'wgCentralAuthCookiePrefix' => 'text',
			'wgCentralAuthAutoLoginWikis' => 'array',
			'wgCentralAuthLoginIcon' => 'text',
			'wgCentralAuthCreateOnView' => 'bool',
			'wgCentralAuthUDPAddress' => 'text',
			'wgCentralAuthNew2UDPPrefix' => 'text',
		),
		'array' => array(
			'wgCentralAuthAutoLoginWikis' => 'simple',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:CentralAuth',
	),
	array(
		'name' => 'CentralNotice',
		'settings' => array(
			'wgNoticeCentralPath' => 'text',
			'wgNoticeLocalPath' => 'text',
			'wgNoticeLang' => 'text',
			'wgNoticeProject' => 'text',
			'wgNoticeProjects' => 'array',
			'wgNoticeCentralDirectory' => 'text',
			'wgNoticeLocalDirectory' => 'text',
			'wgNoticeInfrastructure' => 'bool',
			'wgCentralNoticeLoader' => 'bool',
			'wgNoticeTestMode' => 'bool',
			'wgNoticeEnabledSites' => 'array',
			'wgNoticeTimeout' => 'int',
			'wgNoticeServerTimeout' => 'int',
			'wgNoticeCounterSource' => 'text',
		),
		'array' => array(
			'wgNoticeProjects' => 'simple',
		),
		'empty' => array(
			'wgNoticeCentralPath' => false,
			'wgNoticeLocalPath' => false,
			'wgNoticeCentralDirectory' => false,
			'wgNoticeLocalDirectory' => false,
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:CentralNotice',
	),
	array(
		'name' => 'ChangeAuthor',
		'file' => 'ChangeAuthor.setup.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:ChangeAuthor',
	),
	array(
		'name' => 'CharInsert',
		'url' => 'http://www.mediawiki.org/wiki/Extension:CharInsert',
	),
	array(
		'name' => 'CheckUser',
		'settings' => array(
			'wgCheckUserLog' => 'text',
			'wgCUDMaxAge' => 'int',
			'wgCheckUserMaxBlocks' => 'int',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:CheckUser',
	),
	array(
		'name' => 'ChemFunctions',
		'dir' => 'Chemistry',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Chemistry',
	),
	array(
		'name' => 'Chemicalsources',
		'dir' => 'Chemistry',
		'file' => 'SpecialChemicalsources.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Chemistry',
	),
	array(
		'name' => 'Citation',
	),
	array(
		'name' => 'Cite',
		'settings' => array(
			'wgAllowCiteGroups' => 'bool',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Cite/Cite.php'
	),
	array(
		'name' => 'SpecialCite',
		'dir' => 'Cite',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Cite/Special:Cite.php'
	),
	array(
		'name' => 'CleanChanges',
		'settings' => array(
			'wgCCUserFilter' => 'bool',
			'wgCCTrailerFilter' => 'bool',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:CleanChanges',
	),
	array(
		'name' => 'Click',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Click',
	),
	array(
		'name' => 'CodeReview',
		'settings' => array(
			'wgCodeReviewENotif' => 'bool',
			'wgSubversionProxy' => 'text',
			'wgSubversionProxyTimeout' => 'int',
			'wgSubversionUser' => 'text',
			'wgSubversionPassword' => 'text',
			'wgWikiSVN' => 'text',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:CodeReview',
	),
	array(
		'name' => 'Collection',
		'settings' => array(
			'wgCollectionMWServeURL' => 'text',
			'wgCollectionMWServeCredentials' => 'text',
			'wgCollectionMWServeCert' => 'text',
			'wgCollectionArticleNamespaces' => 'array',
			'wgCommunityCollectionNamespace' => 'int',
			'wgCollectionMaxArticles' => 'int',
			'wgLicenseName' => 'text',
			'wgLicenseURL' => 'text',
			'wgPDFTemplateBlacklist' => 'text',
			'wgCollectionTemplateExclusionCategory' => 'text',
			'wgCollectionFormats' => 'array',
			'wgCollectionPortletForLoggedInUsersOnly' => 'bool',
		),
		'array' => array(
			'wgCollectionArticleNamespaces' => 'ns-simple',
			'wgCollectionFormats' => 'assoc',
		),
		'empty' => array(
			'wgCollectionMWServeCert' => null,
			'wgLicenseName' => null,
			'wgLicenseURL' => null,
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Collection',
	),
	array(
		'name' => 'CommentPages',
		'settings' => array(
			'wgCommentPagesNS' => 'int',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:CommentPages',
	),
	array(
		'name' => 'CommentSpammer',
		'url' => 'http://www.mediawiki.org/wiki/Extension:CommentSpammer',
		'settings' => array(
			'wgCommentSpammerLog' => 'array',
		),
		'array' => array(
			'wgCommentSpammerLog' => 'assoc',
		),
	),
	array(
		'name' => 'ConfirmAccount',
		'file' => 'SpecialConfirmAccount.php',
		'settings' => array(
			'wgMakeUserPageFromBio' => 'bool',
			'wgAutoUserBioText' => 'text',
			'wgAutoWelcomeNewUsers' => 'bool',
			'wgUseRealNamesOnly' => 'bool',
			'wgRejectedAccountMaxAge' => 'int',
			'wgConfirmAccountRejectAge' => 'int',
			'wgAccountRequestThrottle' => 'int',
			'wgAccountRequestWhileBlocked' => 'bool',
			'wgAccountRequestMinWords' => 'int',
			'wgAccountRequestToS' => 'bool',
			'wgAccountRequestExtraInfo' => 'bool',
			'wgAccountRequestTypes' => 'array',
			'wgConfirmAccountSortkey' => 'array',
			'wgConfirmAccountSaveInfo' => 'bool',
			'wgConfirmAccountContact' => 'text',
			'wgConfirmAccountCaptchas' => 'bool',
			'wgConfirmAccountNotice' => 'bool',
			'wgAllowAccountRequestFiles' => 'bool',
			'wgAccountRequestExts' => 'array',
		),
		'array' => array(
			'wgAccountRequestTypes' => 'array',
			'wgConfirmAccountSortkey' => 'simple',
			'wgAccountRequestExts' => 'simple',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:ConfirmAccount',
	),
	array(
		'name' => 'ConfirmEdit',
		'settings' => array(
			'wgCaptchaClass' => 'text',
			'wgCaptchaWhitelistIP' => 'array',
			'wgCaptchaTriggers' => 'array',
			'wgCaptchaTriggersOnNamespace' => 'array',
			'wgCaptchaStorageClass' => 'text',
			'wgCaptchaSessionExpiration' => 'int',
			'wgCaptchaBadLoginExpiration' => 'int',
			'ceAllowConfirmedEmail' => 'bool',
			'wgCaptchaBadLoginAttempts' => 'int',
			'wgCaptchaWhitelist' => 'text',
			'wgCaptchaRegexes' => 'array',
		),
		'array' => array(
			'wgCaptchaWhitelistIP' => 'simple',
			'wgCaptchaTriggers' => 'assoc',
			'wgCaptchaTriggersOnNamespace' => 'array',
			'wgCaptchaRegexes' => 'simple',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:ConfirmEdit',
	),
	array(
		'name' => 'FancyCaptcha',
		'dir' => 'ConfirmEdit',
		'settings' => array(
			'wgCaptchaDirectory' => 'text',
			'wgCaptchaDirectoryLevels' => 'int',
			'wgCaptchaSecret' => 'text',
		),
	),
	array(
		'name' => 'MathCaptcha',
		'dir' => 'ConfirmEdit',
	),
	array(
		'name' => 'ContactPage',
		'settings' => array(
			'wgContactUser' => 'text',
			'wgContactSender' => 'text',
			'wgContactSenderName' => 'text',
			'wgContactRequireAll' => 'bool',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:ContactPage',
	),
	array(
		'name' => 'ContributionScores',
		'settings' => array(
			'wgContribScoreReports' => 'array',
			'wgContribScoreIgnoreBlockedUsers' => 'bool',
			'wgContribScoreIgnoreBots' => 'bool',
			'wgContribScoreDisableCache' => 'bool',
		),
		'array' => array(
			'wgContribScoreReports' => 'simple-dual',
		),
	),
	array(
		'name' => 'Contributionseditcount',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Contributionseditcount',
	),
	array(
		'name' => 'Contributors',
		'settings' => array(
			'wgContributorsLimit' => 'int',
			'wgContributorsThreshold' => 'int',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Contributors',
		'schema' => true,
	),
	array(
		'name' => 'ContributorsAddon',
		'url' => 'http://www.mediawiki.org/wiki/Extension:ContributorsAddon',
	),
	array(
		'name' => 'CountEdits',
		'settings' => array(
			'wgCountEditsMostActive' => 'bool',
		),
		'url' => 'http://www.mediawiki.wiki/wiki/Extension:CountEdits',
	),
	array(
		'name' => 'CreateBox',
		'url' => 'http://www.mediawiki.org/wiki/Extension:CreateBox',
	),
	array(
		'name' => 'CrossNamespaceLinks',
		'file' => 'SpecialCrossNamespaceLinks.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:CrossNamespaceLinks',
	),
	array(
		'name' => 'Crosswiki',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Crosswiki_Blocking',
	),
	array(
		'name' => 'CSS',
		'settings' => array(
			'wgCSSMagic' => 'text',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:CSS',
	),

	// D
	array(
		'name' => 'DeleteBatch',
		'url' => 'http://www.mediawiki.org/wiki/Extension:DeleteBatch',
	),
	array(
		'name' => 'DeletedContributions',
		'url' => 'http://www.mediawiki.org/wiki/Extension:DeletedContributions',
	),
	array(
		'name' => 'DeleteQueue',
		'settings' => array(
			'wgDeleteQueueExpiry' => 'array',
		),
		'array' => array(
			'wgDeleteQueueExpiry' => 'assoc',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:DeleteQueue',
	),
	array(
		'name' => 'DidYouMean',
		'settings' => array(
			'wgDymUseSeeTemplate' => 'bool',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:DidYouMean',
	),
	array(
		'name' => 'DisableSpecialPages',
		'settings' => array(
			'wgDisabledSpecialPages' => 'array',
		),
		'array' => array(
			'wgDisabledSpecialPages' => 'simple',
		),
	),
	array(
		'name' => 'DismissableSiteNotice',
		'settings' => array(
			'wgMajorSiteNoticeID' => 'int',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:DismissableSiteNotice',
	),
	array(
		'name' => 'Duplicator',
		'settings' => array(
			'wgDuplicatorRevisionLimit' => 'int',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:Duplicator',
	),

	// E
	array(
		'name' => 'EditCount',
		'file' => 'SpecialEditcount.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Editcount',
	),
	array(
		'name' => 'EditOwn',
		'settings' => array(
			'wgEditOwnExcludedNamespaces' => 'array',
		),
		'array' => array(
			'wgEditOwnExcludedNamespaces' => 'ns-simple',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:EditOwn',
	),
	array(
		'name' => 'EditSubpages',
		'url' => 'http://www.mediawiki.org/wiki/Extension:EditSubpages',
	),
	array(
		'name' => 'EditUser',
		'url' => 'http://www.mediawiki.org/wiki/Extension:EditUser',
	),
	array(
		'name' => 'ErrorHandler',
		'settings' => array(
			'wgErrorHandlerReport' => 'int',
			'wgErrorHandlerShowBackTrace' => 'bool',
			'wgErrorHandlerMaxStringSize' => 'int',
			'wgErrorHandlerAlwaysReport' => 'bool',
			'wgErrorHandlerLog' => 'text',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:ErrorHandler',
	),
	array(
		'name' => 'ExpandTemplates',
		'url' => 'http://www.mediawiki.org/wiki/Extension:ExpandTemplates',
	),

	// F
	array(
		'name' => 'FileSearch',
	),
	array(
		'name' => 'FindSpam',
#		'url'=>'http://www.mediawiki.org/wiki/Extension:Find_Spam',
	),
	array(
		'name' => 'FlaggedRevs',
		'settings' => array(
			'wgSimpleFlaggedRevsUI' => 'bool',
			'wgFlaggedRevTabs' => 'bool',
			'wgFlaggedRevsLowProfile' => 'bool',
			'wgFlaggedRevsNamespaces' => 'array',
			'wgFlaggedRevsPatrolNamespaces' => 'array',
			'wgFlaggedRevsWhitelist' => 'array',
			'wgFlaggedRevsOverride' => 'bool',
			'wgFlaggedRevsReviewForDefault' => 'bool',
			'wgFlaggedRevsPrecedence' => 'bool',
			'wgFlaggedRevsExceptions' => 'array',
			'wgFlaggedRevsComments' => 'bool',
			'wgReviewChangesAfterEdit' => 'bool',
			'wgFlaggedRevsAutoReview' => 'bool',
			'wgFlaggedRevsAutoReviewNew' => 'bool',
			'wgUseCurrentTemplates' => 'bool',
			'wgUseStableImages' => 'bool',
			'wgUseCurrentImages' => 'bool',
			'wgFlaggedRevTags' => 'array',
			'wgFlaggedRevValues' => 'int',
			'wgFlaggedRevPristine' => 'int',
			'wgFlagRestrictions' => 'array',
			'wgReviewCodes' => 'array',
			'wgFlaggedRevsStylePath' => 'text',
			'wgFlaggedRevsAutopromote' => 'array',
			'wgFlaggedRevsLogInRC' => 'bool',
			'wgFlaggedRevsOversightAge' => 'int',
			'wgFlaggedRevsBacklog' => 'int',
			'wgFlaggedRevsVisible' => 'array',
			'wgFlaggedRevsTalkVisible' => 'bool',
			'wgFeedbackNamespaces' => 'array',
			'wgFlaggedRevsFeedbackTags' => 'array',
			'wgFlaggedRevsFeedbackAge' => 'int',
			'wgFlaggedRevsStatsAge' => 'int',
			'wgPHPlotDir' => 'text',
			'wgSvgGraphDir' => 'text',
		),
		'array' => array(
			'wgFlaggedRevsNamespaces' => 'ns-simple',
			'wgFlaggedRevsPatrolNamespaces' => 'ns-simple',
			'wgFlaggedRevsWhitelist' => 'simple',
			'wgFlaggedRevsExceptions' => 'simple',
			'wgFlaggedRevTags' => 'assoc',
			'wgFlagRestrictions' => 'array',
			'wgReviewCodes' => 'simple',
			'wgFlaggedRevsAutopromote' => 'assoc',
			'wgFlaggedRevsVisible' => 'simple',
			'wgFeedbackNamespaces' => 'ns-simple',
			'wgFlaggedRevsFeedbackTags' => 'assoc',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:FlaggedRevs',
	),
	array(
		'name' => 'ForcePreview',
		'url' => 'http://www.mediawiki.org/wiki/Extension:ForcePreview',
	),
	array(
		'name' => 'FormPreloadPostCache',
	),

	// G
	array(
		'name' => 'Gadgets',
		'url' => 'http://mediawiki.org/wiki/Extension:Gadgets',
	),
	array(
		'name' => 'GlobalBlocking',
		'settings' => array(
			'wgGlobalBlockingDatabase' => 'text',
			'wgApplyGlobalBlocks' => 'bool',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:GlobalBlocking',
	),
	array(
		'name' => 'Gnuplot',
		'settings' => array(
			'wgGnuplotCommand' => 'text',
			'wgGnuplotDefaultTerminal' => 'text',
			'wgGnuplotDefaultSize' => 'text',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Gnuplot',
	),
	array(
		'name' => 'GoogleAdSense',
		'settings' => array(
			'wgGoogleAdSenseWidth' => 'int',
			'wgGoogleAdSenseHeight' => 'int',
			'wgGoogleAdSenseSrc' => 'text',
			'wgGoogleAdSenseClient' => 'text',
			'wgGoogleAdSenseSlot' => 'text',
			'wgGoogleAdSenseID' => 'text',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Google_AdSense_2',
	),
	array(
		'name' => 'GoToCategory',
		'url' => 'http://www.mediawiki.org/wiki/Extension:GoToCategory',
	),
	array(
		'name' => 'GroupPortal',
		'url' => 'http://www.mediawiki.org/wiki/Extension:GroupPortal',
	),

	// I
	array(
		'name' => 'ImageMap',
		'url' => 'http://www.mediawiki.org/wiki/Extension:ImageMap',
	),
	array(
		'name' => 'Inputbox',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Inputbox',
	),
	array(
		'name' => 'intersection',
		'file' => 'DynamicPageList.php',
		'settings' => array(
			'wgDLPminCategories' => 'int',
			'wgDLPmaxCategories' => 'int',
			'wgDLPMinResultCount' => 'int',
			'wgDLPMaxResultCount' => 'int',
			'wgDLPAllowUnlimitedResults' => 'bool',
			'wgDLPAllowUnlimitedCategories' => 'bool',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Intersection',
	),
	array(
		'name' => 'Interwiki',
		'file' => 'SpecialInterwiki.php',
		'url' => 'http://mediawiki.org/wiki/Extension:SpecialInterwiki',
	),
	array(
		'name' => 'InterwikiList',
		'url' => 'http://mediawiki.org/wiki/Extension:InterwikiList',
	),

	// L
	array(
		'name' => 'LinkSearch',
		'url' => 'http://www.mediawiki.org/wiki/Extension:LinkSearch',
	),

	// M
	array(
		'name' => 'Maintenance',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Maintenance',
	),
	array(
		'name' => 'MakeBot',
		'settings' => array(
			'wgMakeBotPrivileged' => 'bool',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:MakeBot',
	),
	array(
		'name' => 'Makesysop',
		'file' => 'SpecialMakesysop.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Makesysop',
	),

	// N
	array(
		'name' => 'Newuserlog',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Newuserlog',
	),
	array(
		'name' => 'Nuke',
		'file' => 'SpecialNuke.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Nuke',
	),

	// O
	array(
		'name' => 'OggHandler',
		'settings' => array(
			'wgPlayerStatsCollection' => 'bool',
			'wgFFmpegLocation' => 'text',
			'wgCortadoJarFile' => 'text',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:OggHandler',
	),
	array(
		'name' => 'OnlineStatus',
		'settings' => array(
			'wgAllowAnyUserOnlineStatusFunction' => 'bool',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:OnlineStatus',
	),
	array(
		'name' => 'OpenSearchXml',
		'settings' => array(
			'wgOpenSearchAdvertiseXml' => 'bool',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:OpenSearchXml',
	),
	array(
		'name' => 'Oversight',
		'file' => 'HideRevision.php',
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:Oversight',
	),

	// P
	array(
		'name' => 'ParserFunctions',
		'url' => 'http://meta.wikimedia.org/wiki/ParserFunctions',
	),
	array(
		'name' => 'PasswordReset',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Password_Reset',
	),
	array(
		'name' => 'Poem',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Poem',
	),
	array(
		'name' => 'PovWatch',
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:PovWatch',
	),

	// R
	array(
		'name' => 'Renameuser',
		'file' => 'SpecialRenameuser.php',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Renameuser',
	),

	// S
	array(
		'name' => 'SkinPerNamespace',
		'settings' => array(
			'wgSkinPerNamespace' => 'array',
			'wgSkinPerNamespaceOverrideLoggedIn' => 'bool',
		),
		'array' => array(
			'wgSkinPerNamespace' => 'ns-text',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:SkinPerNamespace',
	),
	array(
		'name' => 'SkinPerPage',
		'url' => 'http://www.mediawiki.org/wiki/Extension:SkinPerPage',
	),
	array(
		'name' => 'SocialProfile',
		'settings' => array(
			'wgUserBoard' => 'bool',
			'wgFriendingEnabled' => 'bool',
		),
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	),
	array(
		'name' => 'SpamRegex',
		'url' => 'http://www.mediawiki.org/wiki/Extension:SpamRegex',
	),
	array(
		'name' => 'SyntaxHighlight_GeSHi',
		'url' => 'http://www.mediawiki.org/wiki/Extension:SyntaxHighlight_GeSHi',
	),

	// T
	array(
		'name' => 'Timeline',
		'dir' => 'timeline',
		'url' => 'http://www.mediawiki.org/wiki/Extension:EasyTimeline',
	),
	array(
		'name' => 'TitleBlacklist',
		'settings' => array(
			'wgTitleBlacklistCaching' => 'array',
			'wgTitleBlacklistSources' => 'array',
		),
		'array' => array(
			'wgTitleBlacklistCaching' => 'assoc',
			'wgTitleBlacklistSources' => 'array',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Title_Blacklist',
	),
	array(
		'name' => 'TitleKey',
		'schema' => true,
		'url' => 'http://www.mediawiki.org/wiki/Extension:TitleKey',
	),
	array(
		'name' => 'TorBlock',
		'settings' => array(
			'wgTorBypassPermissions' => 'array',
			'wgTorLoadNodes' => 'bool',
			'wgTorAllowedActions' => 'array',
			'wgTorAutoConfirmAge' => 'int',
			'wgTorAutoConfirmCount' => 'int',
			'wgTorIPs' => 'array',
			'wgTorDisableAdminBlocks' => 'bool',
		),
		'array' => array(
			'wgTorBypassPermissions' => 'simple',
			'wgTorAllowedActions' => 'simple',
			'wgTorIPs' => 'simple',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:TorBlock',
	),
	array(
		'name' => 'Translate',
		'settings' => array(
			'wgTranslateExtensionDirectory' => 'text',
			'wgTranslateLanguageFallbacks' => 'array',
			'wgTranslateFuzzyBotName' => 'text',
			'wgTranslateCssLocation' => 'text',
			'wgTranslateDocumentationLanguageCode' => 'text',
			'wgTranslateBlacklist' => 'array',
			'wgTranslateAuthorBlacklist' => 'array',
			'wgTranslateMessageNamespaces' => 'array',
			'wgTranslateAC' => 'array',
			'wgTranslateGroupStructure' => 'array',
			'wgTranslateAddMWExtensionGroups' => 'bool',
			'wgTranslateEC' => 'array',
			'wgTranslateCC' => 'array',
			'wgTranslateTasks' => 'array',
			'wgTranslatePHPlot' => 'text',
			'wgTranslatePHPlotFont' => 'text',
			'wgTranslateTagTranslationLocation' => 'array',
		),
		'array' => array(
			'wgTranslateLanguageFallbacks' => 'assoc',
			'wgTranslateBlacklist' => 'array',
			'wgTranslateMessageNamespaces' => 'ns-simple',
			'wgTranslateAuthorBlacklist' => 'array',
			'wgTranslateAC' => 'assoc',
			'wgTranslateGroupStructure' => 'array',
			'wgTranslateEC' => 'simple',
			'wgTranslateCC' => 'assoc',
			'wgTranslateTasks' => 'assoc',
			'wgTranslateTagTranslationLocation' => 'simple',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Translate',
	),

	// U
	array(
		'name' => 'UserMerge',
		'settings' => array(
			'wgUserMergeProtectedGroups' => 'array',
		),
		'array' => array(
			'wgUserMergeProtectedGroups' => 'simple',
		),
		'url' => 'http://www.mediawiki.org/wiki/Extension:User_Merge_and_Delete',
	),
	array(
		'name' => 'UsernameBlacklist',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Username_Blacklist',
	),

	// W
	array(
		'name' => 'wikihiero',
		'url' => 'http://www.mediawiki.org/wiki/Extension:WikiHiero',
	),
);
