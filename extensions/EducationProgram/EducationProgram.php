<?php

/**
 * Initialization file for the Education Program extension.
 *
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:Education_Program
 * Support					https://www.mediawiki.org/wiki/Extension_talk:Education_Program
 * Source code:				http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/EducationProgram
 *
 * The source code makes use of a number of terms different from but corresponding to those in the UI:
 * * Org instead of Institution
 * * CA for campus ambassador
 * * OA for online ambassador
 *
 * @file EducationProgram.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to Education Program.
 *
 * @defgroup EducationProgram Education Program
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.19c', '<' ) ) { // Needs to be 1.19c because version_compare() works in confusing ways.
	die( '<b>Error:</b> Education Program requires MediaWiki 1.19 or above.' );
}

if ( !array_key_exists( 'CountryNames', $wgAutoloadClasses ) ) { // No version constant to check against :/
	die( '<b>Error:</b> Education Program depends on the <a href="https://www.mediawiki.org/wiki/Extension:CLDR">CLDR</a> extension.' );
}

define( 'EP_VERSION', '0.1 alpha' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Education Program',
	'version' => EP_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Education_Program',
	'descriptionmsg' => 'educationprogram-desc'
);

// i18n
$wgExtensionMessagesFiles['EducationProgram'] 		= dirname( __FILE__ ) . '/EducationProgram.i18n.php';
$wgExtensionMessagesFiles['EducationProgramAlias']	= dirname( __FILE__ ) . '/EducationProgram.i18n.alias.php';
$wgExtensionMessagesFiles['EPNamespaces'] 			= dirname( __FILE__ ) . '/EducationProgram.i18n.ns.php';

// Autoloading
$wgAutoloadClasses['EPHooks'] 						= dirname( __FILE__ ) . '/EducationProgram.hooks.php';
$wgAutoloadClasses['EPSettings'] 					= dirname( __FILE__ ) . '/EducationProgram.settings.php';

$wgAutoloadClasses['CourseHistoryAction'] 			= dirname( __FILE__ ) . '/actions/CourseHistoryAction.php';
$wgAutoloadClasses['EditCourseAction'] 				= dirname( __FILE__ ) . '/actions/EditCourseAction.php';
$wgAutoloadClasses['EditOrgAction'] 				= dirname( __FILE__ ) . '/actions/EditOrgAction.php';
$wgAutoloadClasses['EPEditAction'] 					= dirname( __FILE__ ) . '/actions/EPEditAction.php';
$wgAutoloadClasses['EPHistoryAction'] 				= dirname( __FILE__ ) . '/actions/EPHistoryAction.php';
$wgAutoloadClasses['EPViewAction'] 					= dirname( __FILE__ ) . '/actions/EPViewAction.php';
$wgAutoloadClasses['OrgHistoryAction'] 				= dirname( __FILE__ ) . '/actions/OrgHistoryAction.php';
$wgAutoloadClasses['ViewCourseAction'] 				= dirname( __FILE__ ) . '/actions/ViewCourseAction.php';
$wgAutoloadClasses['ViewOrgAction'] 				= dirname( __FILE__ ) . '/actions/ViewOrgAction.php';

$wgAutoloadClasses['ApiDeleteEducation'] 			= dirname( __FILE__ ) . '/api/ApiDeleteEducation.php';
$wgAutoloadClasses['ApiEnlist'] 					= dirname( __FILE__ ) . '/api/ApiEnlist.php';
$wgAutoloadClasses['ApiRefreshEducation'] 			= dirname( __FILE__ ) . '/api/ApiRefreshEducation.php';

$wgAutoloadClasses['EPCourse'] 						= dirname( __FILE__ ) . '/includes/EPCourse.php';
$wgAutoloadClasses['EPCoursePager'] 				= dirname( __FILE__ ) . '/includes/EPCoursePager.php';
$wgAutoloadClasses['EPDBObject'] 					= dirname( __FILE__ ) . '/includes/EPDBObject.php';
$wgAutoloadClasses['EPInstructor'] 					= dirname( __FILE__ ) . '/includes/EPInstructor.php';
$wgAutoloadClasses['EPLogFormatter'] 				= dirname( __FILE__ ) . '/includes/EPLogFormatter.php';
$wgAutoloadClasses['EPOrg'] 						= dirname( __FILE__ ) . '/includes/EPOrg.php';
$wgAutoloadClasses['EPOrgPager'] 					= dirname( __FILE__ ) . '/includes/EPOrgPager.php';
$wgAutoloadClasses['EPPager'] 						= dirname( __FILE__ ) . '/includes/EPPager.php';
$wgAutoloadClasses['EPStudent'] 					= dirname( __FILE__ ) . '/includes/EPStudent.php';
$wgAutoloadClasses['EPStudentPager'] 				= dirname( __FILE__ ) . '/includes/EPStudentPager.php';
$wgAutoloadClasses['EPUtils'] 						= dirname( __FILE__ ) . '/includes/EPUtils.php';
$wgAutoloadClasses['EPOA'] 							= dirname( __FILE__ ) . '/includes/EPOA.php';
$wgAutoloadClasses['EPOAPager'] 					= dirname( __FILE__ ) . '/includes/EPOAPager.php';
$wgAutoloadClasses['EPCA'] 							= dirname( __FILE__ ) . '/includes/EPCA.php';
$wgAutoloadClasses['EPCAPager'] 					= dirname( __FILE__ ) . '/includes/EPCAPager.php';
$wgAutoloadClasses['EPHTMLDateField'] 				= dirname( __FILE__ ) . '/includes/EPHTMLDateField.php';
$wgAutoloadClasses['EPHTMLCombobox'] 				= dirname( __FILE__ ) . '/includes/EPHTMLCombobox.php';
$wgAutoloadClasses['EPRevision'] 					= dirname( __FILE__ ) . '/includes/EPRevision.php';
$wgAutoloadClasses['EPRevisionPager'] 				= dirname( __FILE__ ) . '/includes/EPRevisionPager.php';
$wgAutoloadClasses['EPPageObject'] 					= dirname( __FILE__ ) . '/includes/EPPageObject.php';
$wgAutoloadClasses['EPFailForm'] 					= dirname( __FILE__ ) . '/includes/EPFailForm.php';
$wgAutoloadClasses['EPIRole'] 						= dirname( __FILE__ ) . '/includes/EPIRole.php';
$wgAutoloadClasses['EPRevisionedObject'] 			= dirname( __FILE__ ) . '/includes/EPRevisionedObject.php';
$wgAutoloadClasses['EPRoleObject'] 					= dirname( __FILE__ ) . '/includes/EPRoleObject.php';
$wgAutoloadClasses['EPArticle'] 					= dirname( __FILE__ ) . '/includes/EPArticle.php';
$wgAutoloadClasses['EPArticlePager'] 				= dirname( __FILE__ ) . '/includes/EPArticlePager.php';
$wgAutoloadClasses['EPArticleTable'] 				= dirname( __FILE__ ) . '/includes/EPArticleTable.php';
$wgAutoloadClasses['EPRevisionAction'] 				= dirname( __FILE__ ) . '/includes/EPRevisionAction.php';

$wgAutoloadClasses['CoursePage'] 					= dirname( __FILE__ ) . '/pages/CoursePage.php';
$wgAutoloadClasses['EPPage'] 						= dirname( __FILE__ ) . '/pages/EPPage.php';
$wgAutoloadClasses['OrgPage'] 						= dirname( __FILE__ ) . '/pages/OrgPage.php';

$wgAutoloadClasses['SpecialCourses'] 				= dirname( __FILE__ ) . '/specials/SpecialCourses.php';
$wgAutoloadClasses['SpecialEducationProgram'] 		= dirname( __FILE__ ) . '/specials/SpecialEducationProgram.php';
$wgAutoloadClasses['SpecialEPPage'] 				= dirname( __FILE__ ) . '/specials/SpecialEPPage.php';
$wgAutoloadClasses['SpecialInstitutions'] 			= dirname( __FILE__ ) . '/specials/SpecialInstitutions.php';
$wgAutoloadClasses['SpecialMyCourses'] 				= dirname( __FILE__ ) . '/specials/SpecialMyCourses.php';
$wgAutoloadClasses['SpecialStudent'] 				= dirname( __FILE__ ) . '/specials/SpecialStudent.php';
$wgAutoloadClasses['SpecialStudents'] 				= dirname( __FILE__ ) . '/specials/SpecialStudents.php';
$wgAutoloadClasses['SpecialEnroll'] 				= dirname( __FILE__ ) . '/specials/SpecialEnroll.php';
$wgAutoloadClasses['SpecialCAs'] 					= dirname( __FILE__ ) . '/specials/SpecialCAs.php';
$wgAutoloadClasses['SpecialOAs'] 					= dirname( __FILE__ ) . '/specials/SpecialOAs.php';
//$wgAutoloadClasses['SpecialCA'] 					= dirname( __FILE__ ) . '/specials/SpecialCA.php';
//$wgAutoloadClasses['SpecialOA'] 					= dirname( __FILE__ ) . '/specials/SpecialOA.php';
$wgAutoloadClasses['SpecialOAProfile'] 				= dirname( __FILE__ ) . '/specials/SpecialOAProfile.php';
$wgAutoloadClasses['SpecialCAProfile'] 				= dirname( __FILE__ ) . '/specials/SpecialCAProfile.php';
$wgAutoloadClasses['SpecialAmbassadorProfile'] 		= dirname( __FILE__ ) . '/specials/SpecialAmbassadorProfile.php';

// Special pages
$wgSpecialPages['MyCourses'] 						= 'SpecialMyCourses';
$wgSpecialPages['Institutions'] 					= 'SpecialInstitutions';
$wgSpecialPages['Student'] 							= 'SpecialStudent';
$wgSpecialPages['Students'] 						= 'SpecialStudents';
$wgSpecialPages['Courses'] 							= 'SpecialCourses';
$wgSpecialPages['EducationProgram'] 				= 'SpecialEducationProgram';
$wgSpecialPages['Enroll'] 							= 'SpecialEnroll';
$wgSpecialPages['CampusAmbassadors'] 				= 'SpecialCAs';
$wgSpecialPages['OnlineAmbassadors'] 				= 'SpecialOAs';
//$wgSpecialPages['CampusAmbassador'] 				= 'SpecialCA';
//$wgSpecialPages['OnlineAmbassador'] 				= 'SpecialOA';
$wgSpecialPages['CampusAmbassadorProfile'] 			= 'SpecialCAProfile';
$wgSpecialPages['OnlineAmbassadorProfile'] 			= 'SpecialOAProfile';

$wgSpecialPageGroups['MyCourses'] 					= 'education';
$wgSpecialPageGroups['Institutions'] 				= 'education';
$wgSpecialPageGroups['Student'] 					= 'education';
$wgSpecialPageGroups['Students'] 					= 'education';
$wgSpecialPageGroups['Courses'] 					= 'education';
$wgSpecialPageGroups['EducationProgram'] 			= 'education';
$wgSpecialPageGroups['CampusAmbassadors'] 			= 'education';
$wgSpecialPageGroups['OnlineAmbassadors'] 			= 'education';
//$wgSpecialPageGroups['CampusAmbassador'] 			= 'education';
//$wgSpecialPageGroups['OnlineAmbassador'] 			= 'education';
$wgSpecialPageGroups['CampusAmbassadorProfile'] 	= 'education';
$wgSpecialPageGroups['OnlineAmbassadorProfile'] 	= 'education';

// DB object classes
$egEPDBObjects = array();
$egEPDBObjects['EPRevision'] = array( 'table' => 'ep_revisions', 'prefix' => 'rev_' );
$egEPDBObjects['EPOrg'] = array( 'table' => 'ep_orgs', 'prefix' => 'org_' );
$egEPDBObjects['EPCourse'] = array( 'table' => 'ep_courses', 'prefix' => 'course_' );
$egEPDBObjects['EPStudent'] = array( 'table' => 'ep_students', 'prefix' => 'student_' );
$egEPDBObjects['EPOA'] = array( 'table' => 'ep_oas', 'prefix' => 'oa_' );
$egEPDBObjects['EPCA'] = array( 'table' => 'ep_cas', 'prefix' => 'ca_' );
$egEPDBObjects['EPArticle'] = array( 'table' => 'ep_articles', 'prefix' => 'article_' );
$egEPDBObjects[] = array( 'table' => 'ep_students_per_course', 'prefix' => 'spc_' );
$egEPDBObjects[] = array( 'table' => 'ep_oas_per_course', 'prefix' => 'opc_' );
$egEPDBObjects[] = array( 'table' => 'ep_cas_per_course', 'prefix' => 'cpc_' );

// API
$wgAPIModules['deleteeducation'] 					= 'ApiDeleteEducation';
$wgAPIModules['enlist'] 							= 'ApiEnlist';
$wgAPIModules['refresheducation'] 					= 'ApiRefreshEducation';

// Hooks
$wgHooks['LoadExtensionSchemaUpdates'][] 			= 'EPHooks::onSchemaUpdate';
$wgHooks['UnitTestsList'][] 						= 'EPHooks::registerUnitTests';
$wgHooks['PersonalUrls'][] 							= 'EPHooks::onPersonalUrls';
$wgHooks['GetPreferences'][] 						= 'EPHooks::onGetPreferences';
$wgHooks['SkinTemplateNavigation'][] 				= 'EPHooks::onPageTabs';
$wgHooks['SkinTemplateNavigation::SpecialPage'][] 	= 'EPHooks::onSpecialPageTabs';
$wgHooks['ArticleFromTitle'][] 						= 'EPHooks::onArticleFromTitle';
$wgHooks['CanonicalNamespaces'][] 					= 'EPHooks::onCanonicalNamespaces';
$wgHooks['TitleIsKnown'][] 							= 'EPHooks::onTitleIsKnown';

// Logging
$wgLogTypes[] = 'institution';
$wgLogTypes[] = 'course';
$wgLogTypes[] = 'student';
$wgLogTypes[] = 'online';
$wgLogTypes[] = 'campus';
$wgLogTypes[] = 'instructor';

$wgLogActionsHandlers['institution/*'] = 'EPLogFormatter';
$wgLogActionsHandlers['course/*'] = 'EPLogFormatter';
$wgLogActionsHandlers['student/*'] = 'EPLogFormatter';
$wgLogActionsHandlers['online/*'] = 'EPLogFormatter';
$wgLogActionsHandlers['campus/*'] = 'EPLogFormatter';
$wgLogActionsHandlers['instructor/*'] = 'EPLogFormatter';

// Rights
$wgAvailableRights[] = 'ep-org'; 			// Manage orgs
$wgAvailableRights[] = 'ep-course';			// Manage courses
$wgAvailableRights[] = 'ep-token';			// See enrollment tokens
$wgAvailableRights[] = 'ep-enroll';			// Enroll as a student
$wgAvailableRights[] = 'ep-remstudent';		// Disassociate students from terms
$wgAvailableRights[] = 'ep-online';			// Add or remove online ambassadors from terms
$wgAvailableRights[] = 'ep-campus';			// Add or remove campus ambassadors from terms
$wgAvailableRights[] = 'ep-instructor';		// Add or remove instructors from courses
$wgAvailableRights[] = 'ep-beonline';		// Add or remove yourself as online ambassador from terms
$wgAvailableRights[] = 'ep-becampus';		// Add or remove yourself as campus ambassador from terms
$wgAvailableRights[] = 'ep-beinstructor';	// Add or remove yourself as instructor from courses

// User group rights
$wgGroupPermissions['*']['ep-enroll'] = true;
$wgGroupPermissions['*']['ep-org'] = false;
$wgGroupPermissions['*']['ep-course'] = false;
$wgGroupPermissions['*']['ep-token'] = false;
$wgGroupPermissions['*']['ep-remstudent'] = false;
$wgGroupPermissions['*']['ep-online'] = false;
$wgGroupPermissions['*']['ep-campus'] = false;
$wgGroupPermissions['*']['ep-instructor'] = false;
$wgGroupPermissions['*']['ep-beonline'] = false;
$wgGroupPermissions['*']['ep-becampus'] = false;
$wgGroupPermissions['*']['ep-beinstructor'] = false;

$wgGroupPermissions['epstaff']['ep-org'] = true;
$wgGroupPermissions['epstaff']['ep-course'] = true;
$wgGroupPermissions['epstaff']['ep-token'] = true;
$wgGroupPermissions['epstaff']['ep-enroll'] = true;
$wgGroupPermissions['epstaff']['ep-remstudent'] = true;
$wgGroupPermissions['epstaff']['ep-online'] = true;
$wgGroupPermissions['epstaff']['ep-campus'] = true;
$wgGroupPermissions['epstaff']['ep-instructor'] = true;
$wgGroupPermissions['epstaff']['ep-beonline'] = true;
$wgGroupPermissions['epstaff']['ep-becampus'] = true;
$wgGroupPermissions['epstaff']['ep-beinstructor'] = true;

$wgGroupPermissions['epadmin']['ep-org'] = true;
$wgGroupPermissions['epadmin']['ep-course'] = true;
$wgGroupPermissions['epadmin']['ep-token'] = true;
$wgGroupPermissions['epadmin']['ep-enroll'] = true;
$wgGroupPermissions['epadmin']['ep-remstudent'] = true;
$wgGroupPermissions['epadmin']['ep-online'] = true;
$wgGroupPermissions['epadmin']['ep-campus'] = true;
$wgGroupPermissions['epadmin']['ep-instructor'] = true;
$wgGroupPermissions['epadmin']['ep-beonline'] = true;
$wgGroupPermissions['epadmin']['ep-becampus'] = true;
$wgGroupPermissions['epadmin']['ep-beinstructor'] = true;

$wgGroupPermissions['eponlineamb']['ep-org'] = true;
$wgGroupPermissions['eponlineamb']['ep-course'] = true;
$wgGroupPermissions['eponlineamb']['ep-token'] = true;
$wgGroupPermissions['eponlineamb']['ep-beonline'] = true;

$wgGroupPermissions['epcampamb']['ep-org'] = true;
$wgGroupPermissions['epcampamb']['ep-course'] = true;
$wgGroupPermissions['epcampamb']['ep-token'] = true;
$wgGroupPermissions['epcampamb']['ep-becampus'] = true;

$wgGroupPermissions['epinstructor']['ep-org'] = true;
$wgGroupPermissions['epinstructor']['ep-course'] = true;
$wgGroupPermissions['epinstructor']['ep-token'] = true;
$wgGroupPermissions['epinstructor']['ep-remstudent'] = true;
$wgGroupPermissions['epinstructor']['ep-online'] = true;
$wgGroupPermissions['epinstructor']['ep-campus'] = true;
$wgGroupPermissions['epinstructor']['ep-beinstructor'] = true;

$wgGroupPermissions['epstaff']['userrights'] = false;
$wgAddGroups['epstaff'] = array( 'epstaff', 'epadmin', 'eponlineamb', 'epcampamb', 'epinstructor' );
$wgRemoveGroups['epstaff'] = array( 'epstaff', 'epadmin', 'eponlineamb', 'epcampamb', 'epinstructor' );

$wgGroupPermissions['epadmin']['userrights'] = false;
$wgAddGroups['epadmin'] = array( 'eponlineamb', 'epcampamb', 'epinstructor' );
$wgRemoveGroups['epadmin'] = array( 'eponlineamb', 'epcampamb', 'epinstructor' );

// Namespaces
define( 'EP_NS_COURSE',				442 + 0 );
define( 'EP_NS_COURSE_TALK', 		442 + 1 );
define( 'EP_NS_INSTITUTION', 		442 + 2 );
define( 'EP_NS_INSTITUTION_TALK', 	442 + 3 );

// Resource loader modules
$moduleTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/resources',
	'remoteExtPath' => 'EducationProgram/resources'
);

$wgResourceModules['ep.core'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.js',
	),
);

$wgResourceModules['ep.api'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.api.js',
	),
	'dependencies' => array(
		'mediawiki.user',
		'ep.core',
	),
);

$wgResourceModules['ep.pager'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.pager.js',
	),
	'styles' => array(
		'ep.pager.css',
	),
	'dependencies' => array(
		'ep.api',
		'mediawiki.jqueryMsg',
		'jquery.ui.dialog',
	),
	'messages' => array(
		'ep-pager-confirm-delete',
		'ep-pager-delete-fail',
		'ep-pager-confirm-delete-selected',
		'ep-pager-delete-selected-fail',
	),
);

$wgResourceModules['ep.pager.course'] = $moduleTemplate + array(
	'messages' => array(
		'ep-pager-cancel-button-course',
		'ep-pager-delete-button-course',
		'ep-pager-confirm-delete-course',
		'ep-pager-confirm-message-course',
		'ep-pager-confirm-message-course-many',
		'ep-pager-retry-button-course',
		'ep-pager-summary-message-course',
	),
	'dependencies' => array(
		'ep.pager',
	),
);

$wgResourceModules['ep.pager.org'] = $moduleTemplate + array(
	'messages' => array(
		'ep-pager-cancel-button-org',
		'ep-pager-delete-button-org',
		'ep-pager-confirm-delete-org',
		'ep-pager-confirm-message-org',
		'ep-pager-confirm-message-org-many',
		'ep-pager-retry-button-org',
		'ep-pager-summary-message-org',
	),
	'dependencies' => array(
		'ep.pager',
	),
);

$wgResourceModules['ep.datepicker'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.datepicker.js',
	),
	'dependencies' => array(
		'jquery.ui.datepicker',
	),
);

$wgResourceModules['ep.combobox'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.combobox.js',
	),
	'styles' => array(
		'ep.combobox.css',
	),
	'dependencies' => array(
		'jquery.ui.core',
		'jquery.ui.widget',
		'jquery.ui.autocomplete',
	),
);

$wgResourceModules['ep.formpage'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.formpage.js',
	),
	'dependencies' => array(
		'jquery.ui.button',
	),
);

$wgResourceModules['ep.ambprofile'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.ambprofile.js',
	),
	'dependencies' => array(
		'jquery.ui.button',
		'ep.imageinput',
	),
);

$wgResourceModules['ep.imageinput'] = $moduleTemplate + array(
	'scripts' => array(
		'jquery.imageinput.js',
		'ep.imageinput.js',
	),
	'dependencies' => array(
		'jquery.ui.autocomplete',
	),
);

$wgResourceModules['ep.addorg'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.addorg.js',
	),
);

$wgResourceModules['ep.addcourse'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.addcourse.js',
	),
);

if ( array_key_exists( 'WikiEditorHooks', $GLOBALS['wgAutoloadClasses'] ) ) {
	$wgResourceModules['ep.formpage']['dependencies'][] = 'ext.wikiEditor.toolbar';
	$wgResourceModules['ep.ambprofile']['dependencies'][] = 'ext.wikiEditor.toolbar';
}

$wgResourceModules['ep.enlist'] = $moduleTemplate + array(
	'scripts' => array(
		'ep.enlist.js',
	),
	'dependencies' => array(
		'mediawiki.user',
		'jquery.ui.dialog',
		'ep.core',
		'ep.api',
		'mediawiki.jqueryMsg',
		'mediawiki.language'
	),
	'messages' => array(
		'ep-instructor-remove-title',
		'ep-online-remove-title',
		'ep-campus-remove-title',
		'ep-instructor-remove-button',
		'ep-online-remove-button',
		'ep-campus-remove-button',
		'ep-instructor-removing',
		'ep-online-removing',
		'ep-campus-removing',
		'ep-instructor-removal-success',
		'ep-online-removal-success',
		'ep-campus-removal-success',
		'ep-instructor-close-button',
		'ep-online-close-button',
		'ep-campus-close-button',
		'ep-instructor-remove-retry',
		'ep-online-remove-retry',
		'ep-campus-remove-retry',
		'ep-instructor-remove-failed',
		'ep-online-remove-failed',
		'ep-campus-remove-failed',
		'ep-instructor-cancel-button',
		'ep-online-cancel-button',
		'ep-campus-cancel-button',
		'ep-instructor-remove-text',
		'ep-online-remove-text',
		'ep-campus-remove-text',
		'ep-instructor-adding',
		'ep-online-adding',
		'ep-campus-adding',
		'ep-instructor-addittion-success',
		'ep-online-addittion-success',
		'ep-campus-addittion-success',
		'ep-instructor-addittion-self-success',
		'ep-online-addittion-self-success',
		'ep-campus-addittion-self-success',
		'ep-instructor-add-close-button',
		'ep-online-add-close-button',
		'ep-campus-add-close-button',
		'ep-instructor-add-retry',
		'ep-online-add-retry',
		'ep-campus-add-retry',
		'ep-instructor-addittion-failed',
		'ep-online-addittion-failed',
		'ep-campus-addittion-failed',
		'ep-instructor-add-title',
		'ep-online-add-title',
		'ep-campus-add-title',
		'ep-instructor-add-button',
		'ep-online-add-button',
		'ep-campus-add-button',
		'ep-instructor-add-self-button',
		'ep-online-add-self-button',
		'ep-campus-add-self-button',
		'ep-instructor-add-text',
		'ep-online-add-text',
		'ep-campus-add-text',
		'ep-instructor-add-self-text',
		'ep-online-add-self-text',
		'ep-campus-add-self-text',
		'ep-instructor-add-self-title',
		'ep-online-add-self-title',
		'ep-campus-add-self-title',
		'ep-instructor-add-cancel-button',
		'ep-online-add-cancel-button',
		'ep-campus-add-cancel-button',
		'ep-instructor-summary-input',
		'ep-online-summary-input',
		'ep-campus-summary-input',
		'ep-instructor-name-input',
		'ep-online-name-input',
		'ep-campus-name-input',
		'ep-course-no-instructor',
		'ep-course-no-online',
		'ep-course-no-campus',
		'ep-instructor-summary',
		'ep-online-summary',
		'ep-campus-summary',
	),
);

unset( $moduleTemplate );

$egEPSettings = array();

# The default value for the user preferences.
$wgDefaultUserOptions['ep_showtoplink'] = false;
