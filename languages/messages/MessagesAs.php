<?php
/** Assamese (অসমীয়া)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Chaipau
 * @author Gahori
 * @author Gitartha.bordoloi
 * @author Jaminianurag
 * @author Nilamdyuti
 * @author Priyankoo
 * @author Psneog
 * @author Rajuonline
 * @author Reedy
 * @author Simbu123
 * @author Urhixidur
 */

$namespaceNames = array(
	NS_MEDIA            => 'মাধ্যম',
	NS_SPECIAL          => 'বিশেষ',
	NS_TALK             => 'বাৰ্তা',
	NS_USER             => 'সদস্য',
	NS_USER_TALK        => 'সদস্য_বাৰ্তা',
	NS_PROJECT_TALK     => '$1_বাৰ্তা',
	NS_FILE             => 'চিত্ৰ',
	NS_FILE_TALK        => 'চিত্ৰ_বাৰ্তা',
	NS_MEDIAWIKI        => 'মেডিয়াৱিকি',
	NS_MEDIAWIKI_TALK   => 'মেডিয়াৱিকি_বাৰ্তা',
	NS_TEMPLATE         => 'সাঁচ',
	NS_TEMPLATE_TALK    => 'সাঁচ_বাৰ্তা',
	NS_HELP             => 'সহায়',
	NS_HELP_TALK        => 'সহায়_বাৰ্তা',
	NS_CATEGORY         => 'শ্ৰেণী',
	NS_CATEGORY_TALK    => 'শ্ৰেণী_বাৰ্তা',
);

$namespaceAliases = array(
	'विशेष' => NS_SPECIAL,
	'वार्ता' => NS_TALK,
	'বার্তা' => NS_TALK,
	'सदस्य' => NS_USER,
	'सदस्य_वार्ता' => NS_USER_TALK,
	'সদস্য বার্তা' => NS_USER_TALK,
	'$1_वार्ता' => NS_PROJECT_TALK,
	'$1 বার্তা' => NS_PROJECT_TALK,
	'चित्र' => NS_FILE,
	'चित्र_वार्ता' => NS_FILE_TALK,
	'চিত্র' => NS_FILE,
	'চিত্র বার্তা' => NS_FILE_TALK,
	'MediaWiki বার্তা' => NS_MEDIAWIKI_TALK,
	'साँचा' => NS_TEMPLATE,
	'साँचा_वार्ता' => NS_TEMPLATE_TALK,
	'সাঁচ বার্তা' => NS_TEMPLATE_TALK,
	'সহায় বার্তা' => NS_HELP_TALK,
	'श्रेणी' => NS_CATEGORY,
	'श्रेणी_वार्ता' => NS_CATEGORY_TALK,
	'শ্রেণী' => NS_CATEGORY,
	'শ্রেণী বার্তা' => NS_CATEGORY_TALK,
);

$specialPageAliases = array(
	'Allpages'                  => array( 'সকলোবোৰ_পৃষ্ঠা' ),
	'Contributions'             => array( 'অৱদানবোৰ' ),
	'CreateAccount'             => array( 'সদস্যভুক্তি' ),
	'Listfiles'                 => array( 'চিত্ৰ-তালিকা' ),
	'Listgrouprights'           => array( 'গোটৰ_অধিকাৰসমূহ' ),
	'Listusers'                 => array( 'সদস্য-তালিকা' ),
	'Lonelypages'               => array( 'অকলশৰীয়া_পৃষ্ঠা' ),
	'Mycontributions'           => array( 'মোৰ_অৱদান' ),
	'Mypage'                    => array( 'মোৰ_পৃষ্ঠা' ),
	'Mytalk'                    => array( 'মোৰ_কথোপকথন' ),
	'Newimages'                 => array( 'নতুন_চিত্ৰ' ),
	'Popularpages'              => array( 'জনপ্ৰিয়_পৃষ্ঠাসমূহ' ),
	'Preferences'               => array( 'পচন্দ' ),
	'Randompage'                => array( 'আকস্মিক' ),
	'Recentchanges'             => array( 'শেহতীয়া_কাম' ),
	'Specialpages'              => array( 'বিশেষ_পৃষ্ঠাবোৰ' ),
	'Statistics'                => array( 'পৰিসংখ্যা' ),
	'Uncategorizedcategories'   => array( 'অবিন্যস্ত_শ্ৰেণীসমূহ' ),
	'Uncategorizedimages'       => array( 'অবিন্যস্ত_চিত্ৰবোৰ' ),
	'Uncategorizedpages'        => array( 'অবিন্যস্ত_পৃষ্ঠাসমূহ' ),
	'Uncategorizedtemplates'    => array( 'অবিন্যস্ত_সাঁচবোৰ' ),
	'Unusedcategories'          => array( 'অব্যৱহৃত_শ্ৰেণীসমূহ' ),
	'Unusedimages'              => array( 'অব্যৱহৃত_চিত্ৰবোৰ' ),
	'Upload'                    => array( 'বোজাই' ),
	'Userlogin'                 => array( 'সদস্যৰ_প্ৰবেশ' ),
	'Userlogout'                => array( 'সদস্যৰ_প্ৰস্থান' ),
	'Wantedcategories'          => array( 'আকাংক্ষিত_শ্ৰেণীসমূহ' ),
	'Wantedpages'               => array( 'আকাংক্ষিত_পৃষ্ঠাসমূহ' ),
	'Watchlist'                 => array( 'লক্ষ্যতালিকা' ),
);

$digitTransformTable = array(
	'0' => '০', # &#x09e6;
	'1' => '১', # &#x09e7;
	'2' => '২', # &#x09e8;
	'3' => '৩', # &#x09e9;
	'4' => '৪', # &#x09ea;
	'5' => '৫', # &#x09eb;
	'6' => '৬', # &#x09ec;
	'7' => '৭', # &#x09ed;
	'8' => '৮', # &#x09ee;
	'9' => '৯', # &#x09ef;
);

$digitGroupingPattern = "##,##,###";

