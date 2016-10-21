<?php
/** Georgian (ქართული)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Alsandro
 * @author BRUTE
 * @author Dato deutschland
 * @author David1010
 * @author Dawid Deutschland
 * @author Malafaya
 * @author Reedy
 * @author Sopho
 * @author Temuri rajavi
 * @author ka.wikipedia.org sysops
 * @author לערי ריינהארט
 * @author გიორგიმელა
 */

$namespaceNames = array(
	NS_MEDIA            => 'მედია',
	NS_SPECIAL          => 'სპეციალური',
	NS_TALK             => 'განხილვა',
	NS_USER             => 'მომხმარებელი',
	NS_USER_TALK        => 'მომხმარებლის_განხილვა',
	NS_PROJECT_TALK     => '$1_განხილვა',
	NS_FILE             => 'ფაილი',
	NS_FILE_TALK        => 'ფაილის_განხილვა',
	NS_MEDIAWIKI        => 'მედიავიკი',
	NS_MEDIAWIKI_TALK   => 'მედიავიკის_განხილვა',
	NS_TEMPLATE         => 'თარგი',
	NS_TEMPLATE_TALK    => 'თარგის_განხილვა',
	NS_HELP             => 'დახმარება',
	NS_HELP_TALK        => 'დახმარების_განხილვა',
	NS_CATEGORY         => 'კატეგორია',
	NS_CATEGORY_TALK    => 'კატეგორიის_განხილვა',
);

$namespaceAliases = array(
	'მომხმარებელი_განხილვა' => NS_USER_TALK,
	'სურათი' => NS_FILE,
	'სურათი_განხილვა' => NS_FILE_TALK,
	'მედიავიკი_განხილვა' => NS_MEDIAWIKI_TALK,
	'თარგი_განხილვა' => NS_TEMPLATE_TALK,
	'დახმარება_განხილვა' => NS_HELP_TALK,
	'კატეგორია_განხილვა' => NS_CATEGORY_TALK,
);

$specialPageAliases = array(
	'DoubleRedirects'           => array( 'ორმაგიგადამისამართება' ),
	'BrokenRedirects'           => array( 'გაწყვეტილიგადამისამართება' ),
	'Disambiguations'           => array( 'მრავალმნიშვნელოვნება' ),
	'Userlogin'                 => array( 'შესვლა' ),
	'Userlogout'                => array( 'გასვლა' ),
	'CreateAccount'             => array( 'ანგარიშის შექმნა' ),
	'Preferences'               => array( 'კონფიგურაცია' ),
	'Watchlist'                 => array( 'კონტროლსია' ),
	'Recentchanges'             => array( 'ბოლოცვლილებები' ),
	'Upload'                    => array( 'ატვირთვა' ),
	'Listfiles'                 => array( 'სურსია' ),
	'Newimages'                 => array( 'ახსურათები' ),
	'Listusers'                 => array( 'მომხმარებელთა სია' ),
	'Statistics'                => array( 'სტატისტიკა' ),
	'Randompage'                => array( 'შემთხვევით', 'შემთხვევითიგვერდი' ),
	'Lonelypages'               => array( 'ობოლიგვერდები' ),
	'Uncategorizedpages'        => array( 'უკატეგორიო გვერდები' ),
	'Uncategorizedcategories'   => array( 'უკატეგორიო კატეგორიები' ),
	'Uncategorizedimages'       => array( 'უკატეგორიო ფაილები' ),
	'Uncategorizedtemplates'    => array( 'უკატეგორიო თარგები' ),
	'Unusedcategories'          => array( 'გამოუყკატეგორიები' ),
	'Unusedimages'              => array( 'გამოუყსურათები' ),
	'Wantedpages'               => array( 'საჭირო გვერდები' ),
	'Wantedcategories'          => array( 'მოთხოვნილიკატეგორიები' ),
	'Wantedfiles'               => array( 'საჭირო ფაილები' ),
	'Wantedtemplates'           => array( 'საჭირო თარგები' ),
	'Shortpages'                => array( 'მოკლეგვერდები' ),
	'Longpages'                 => array( 'გრძელიგვერდები' ),
	'Newpages'                  => array( 'ახალიგვერდები' ),
	'Ancientpages'              => array( 'მხცოვანიგვერდები' ),
	'Protectedpages'            => array( 'დაცული გვერდები' ),
	'Protectedtitles'           => array( 'დაცული სათაურები' ),
	'Allpages'                  => array( 'ყველაგვერდი' ),
	'Specialpages'              => array( 'განსაკუთრებული გვერდები' ),
	'Contributions'             => array( 'წვლილი' ),
	'Emailuser'                 => array( 'მიწერა მომხმარებელს' ),
	'Categories'                => array( 'კატეგორიები' ),
	'Version'                   => array( 'ვერსია' ),
	'Undelete'                  => array( 'აღდგენა' ),
	'Userrights'                => array( 'მომხმარებელთა უფლებები' ),
	'Mypage'                    => array( 'ჩემიგვერდი' ),
	'Mytalk'                    => array( 'ჩენი განხილვა' ),
	'Mycontributions'           => array( 'ჩემი წვლილი' ),
	'Popularpages'              => array( 'პოპგვერდები' ),
	'Search'                    => array( 'ძიება' ),
	'Withoutinterwiki'          => array( 'ინტერვიკისგარეშე' ),
);

$magicWords = array(
	'redirect'              => array( '0', '#გადამისამართება', '#REDIRECT' ),
	'nogallery'             => array( '0', '__უგალერეო__', '__NOGALLERY__' ),
	'subst'                 => array( '0', 'მიდგმ:', 'SUBST:' ),
	'img_thumbnail'         => array( '1', 'მინიატიურა', 'მინი', 'thumbnail', 'thumb' ),
	'img_right'             => array( '1', 'მარჯვნივ', 'right' ),
	'img_left'              => array( '1', 'მარცხნივ', 'left' ),
	'img_center'            => array( '1', 'ცენტრი', 'center', 'centre' ),
);

$linkPrefixExtension = true;
$linkTrail = '/^([a-zაბგდევზთიკლმნოპჟრსტუფქღყშჩცძწჭხჯჰ“»]+)(.*)$/sDu';

