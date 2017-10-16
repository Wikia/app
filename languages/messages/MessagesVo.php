<?php
/** Volapük (Volapük)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Malafaya
 * @author Reedy
 * @author Smeira
 * @author לערי ריינהארט
 */

$namespaceNames = array(
	NS_MEDIA            => 'Nünamakanäd',
	NS_SPECIAL          => 'Patikos',
	NS_TALK             => 'Bespik',
	NS_USER             => 'Geban',
	NS_USER_TALK        => 'Gebanibespik',
	NS_PROJECT_TALK     => 'Bespik_dö_$1',
	NS_FILE             => 'Ragiv',
	NS_FILE_TALK        => 'Ragivibespik',
	NS_MEDIAWIKI        => 'Sitanuns',
	NS_MEDIAWIKI_TALK   => 'Bespik_dö_sitanuns',
	NS_TEMPLATE         => 'Samafomot',
	NS_TEMPLATE_TALK    => 'Samafomotibespik',
	NS_HELP             => 'Yuf',
	NS_HELP_TALK        => 'Yufibespik',
	NS_CATEGORY         => 'Klad',
	NS_CATEGORY_TALK    => 'Kladibespik',
);

$namespaceAliases = array(
	'Magod' => NS_FILE,
	'Magodibespik' => NS_FILE_TALK,
);

$datePreferences = array(
	'default',
	'vo',
	'vo plain',
	'ISO 8601',
);

$defaultDateFormat = 'vo';

$dateFormats = array(
	'vo time' => 'H:i',
	'vo date' => 'Y F j"id"',
	'vo both' => 'H:i, Y F j"id"',

	'vo plain time' => 'H:i',
	'vo plain date' => 'Y F j',
	'vo plain both' => 'H:i, Y F j',
);

$specialPageAliases = array(
	'DoubleRedirects'           => array( 'Lüodükömstelik', 'Lüodüköms telik' ),
	'BrokenRedirects'           => array( 'Lüodükömsdädik', 'Lüodüköms dädik' ),
	'Disambiguations'           => array( 'Telplänovs', 'Telplänovapads' ),
	'Userlogin'                 => array( 'Gebananunäd' ),
	'Userlogout'                => array( 'Gebanasenunäd' ),
	'Preferences'               => array( 'Buükams' ),
	'Watchlist'                 => array( 'Galädalised' ),
	'Recentchanges'             => array( 'Votükamsnulik' ),
	'Upload'                    => array( 'Löpükön' ),
	'Listfiles'                 => array( 'Ragivalised', 'Magodalised' ),
	'Newimages'                 => array( 'Ragivsnulik', 'Magodsnulik', 'Magods nulik' ),
	'Listusers'                 => array( 'Gebanalised' ),
	'Statistics'                => array( 'Statits' ),
	'Randompage'                => array( 'Padfädik', 'Pad fädik', 'Fädik' ),
	'Lonelypages'               => array( 'Padssoelöl', 'Pads soelöl' ),
	'Uncategorizedpages'        => array( 'Padsnenklads', 'Pads nen klads' ),
	'Uncategorizedcategories'   => array( 'Kladsnenklads', 'Klads nen klads' ),
	'Uncategorizedimages'       => array( 'Ragivsnenklads', 'Magodsnenklads', 'Magods nen klads' ),
	'Uncategorizedtemplates'    => array( 'Samafomotsnenklads', 'Samafomots nen klads' ),
	'Unusedcategories'          => array( 'Kladsnopageböls', 'Klad no pageböls' ),
	'Unusedimages'              => array( 'Ragivsnopageböls', 'Magodsnopageböls', 'Magods no pageböls' ),
	'Wantedpages'               => array( 'Pads mekabik', 'Padsmekabik', 'Padspavilöl', 'Yümsdädik', 'Pads pavilöl', 'Yüms dädik' ),
	'Wantedcategories'          => array( 'Klads mekabik', 'Kladsmekabik', 'Kladspavilöl', 'Klads pavilöl' ),
	'Wantedfiles'               => array( 'Ragivsmekabik' ),
	'Wantedtemplates'           => array( 'Samafomotsmekabik' ),
	'Mostlinked'                => array( 'Suvüno peyümöls' ),
	'Mostlinkedcategories'      => array( 'Klads suvüno peyümöls' ),
	'Mostlinkedtemplates'       => array( 'Samafomots suvüno peyümöls' ),
	'Mostimages'                => array( 'Ragivs suvüno peyümöls' ),
	'Shortpages'                => array( 'Padsbrefik' ),
	'Longpages'                 => array( 'Padslunik' ),
	'Newpages'                  => array( 'Padsnulik' ),
	'Ancientpages'              => array( 'Padsbäldik' ),
	'Protectedpages'            => array( 'Padspejelöl' ),
	'Protectedtitles'           => array( 'Tiädspejelöl' ),
	'Allpages'                  => array( 'Padsvalik' ),
	'Specialpages'              => array( 'Padspatik' ),
	'Contributions'             => array( 'Keblünots' ),
	'Confirmemail'              => array( 'Fümedönladeti' ),
	'Whatlinkshere'             => array( 'Yümsisio', 'Isio' ),
	'Movepage'                  => array( 'Topätükön' ),
	'Categories'                => array( 'Klads' ),
	'Version'                   => array( 'Fomam' ),
	'Allmessages'               => array( 'Nünsvalik' ),
	'Log'                       => array( 'Jenotalised', 'Jenotaliseds' ),
	'Mypage'                    => array( 'Padobik' ),
	'Mytalk'                    => array( 'Bespikobik' ),
	'Mycontributions'           => array( 'Keblünotsobik' ),
	'Search'                    => array( 'Suk' ),
	'Blankpage'                 => array( 'PadVagik' ),
);

