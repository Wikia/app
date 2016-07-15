<?php
/** Tagalog (Tagalog)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author AnakngAraw
 * @author Felipe Aira
 * @author Kaganer
 * @author Sky Harbor
 * @author tl.wikipedia.org sysops
 * @author לערי ריינהארט
 */

$namespaceNames = array(
	NS_MEDIA            => 'Midya',
	NS_SPECIAL          => 'Natatangi',
	NS_TALK             => 'Usapan',
	NS_USER             => 'Tagagamit',
	NS_USER_TALK        => 'Usapang_tagagamit',
	NS_PROJECT_TALK     => 'Usapang_$1',
	NS_FILE             => 'Talaksan',
	NS_FILE_TALK        => 'Usapang_talaksan',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Usapang_MediaWiki',
	NS_TEMPLATE         => 'Suleras',
	NS_TEMPLATE_TALK    => 'Usapang_suleras',
	NS_HELP             => 'Tulong',
	NS_HELP_TALK        => 'Usapang_tulong',
	NS_CATEGORY         => 'Kategorya',
	NS_CATEGORY_TALK    => 'Usapang_kategorya',
);

$namespaceAliases = array(
	'Talaksan'          => NS_FILE,
	'Usapang talaksan'  => NS_FILE_TALK,
	'Kaurian'         => NS_CATEGORY,
	'Usapang_kaurian' => NS_CATEGORY_TALK,
);

$specialPageAliases = array(
	'Allmessages'               => array( 'Lahat ng mga mensahe' ),
	'Allpages'                  => array( 'Lahat ng mga pahina', 'LahatPahina' ),
	'Ancientpages'              => array( 'Sinaunang mga pahina' ),
	'Blankpage'                 => array( 'Tanggalin ang nilalaman ng pahina' ),
	'Block'                     => array( 'Hadlangan', 'Hadlangan ang IP', 'Hadlangan ang tagagamit' ),
	'Blockme'                   => array( 'Hadlangang ako' ),
	'Booksources'               => array( 'Mga pinagmulang aklat' ),
	'BrokenRedirects'           => array( 'Naputol na mga panturo papunta sa ibang pahina', 'NaputulangPanturo' ),
	'Categories'                => array( 'Mga kaurian' ),
	'ChangePassword'            => array( 'Baguhin ang hudyat', 'Muling itakda ang hudyat', 'Muling magtakda ng hudyat' ),
	'Confirmemail'              => array( 'Tiyakin ang e-liham' ),
	'Contributions'             => array( 'Mga ambag' ),
	'CreateAccount'             => array( 'Likhain ang kuwenta', 'LikhaKuwenta' ),
	'Deadendpages'              => array( 'Mga pahinang sukol', 'Mga pahinang walang lagusan' ),
	'DeletedContributions'      => array( 'Naburang mga ambag' ),
	'Disambiguations'           => array( 'Mga paglilinaw', 'Paglilinaw' ),
	'DoubleRedirects'           => array( 'Nagkadalawang mga panturo papunta sa ibang pahina', 'DoblengPanturo' ),
	'Emailuser'                 => array( 'Tagagamit ng e-liham' ),
	'Export'                    => array( 'Pagluluwas' ),
	'Fewestrevisions'           => array( 'Pinakakaunting mga pagbabago' ),
	'FileDuplicateSearch'       => array( 'Paghahanap ng kamukhang talaksan' ),
	'Filepath'                  => array( 'Daanan ng talaksan' ),
	'Import'                    => array( 'Pag-aangkat' ),
	'Invalidateemail'           => array( 'Hindi tanggap na e-liham' ),
	'BlockList'                 => array( 'Talaan ng hinahadlangan', 'Talaan ng mga hinahadlangan', 'Talaan ng hinahadlangang IP' ),
	'LinkSearch'                => array( 'Paghahanap ng kawing' ),
	'Listadmins'                => array( 'Talaan ng mga tagapangasiwa' ),
	'Listbots'                  => array( 'Talaan ng mga bot' ),
	'Listfiles'                 => array( 'Itala ang mga talaksan', 'Talaan ng mga talaksan', 'Talaan ng mga larawan' ),
	'Listgrouprights'           => array( 'Talaan ng mga karapatan ng pangkat' ),
	'Listredirects'             => array( 'Talaan ng mga pagturo sa ibang pahina' ),
	'Listusers'                 => array( 'Talaan ng mga tagagamit', 'Talaan ng tagagamit' ),
	'Lockdb'                    => array( 'Ikandado ang kalipunan ng dato' ),
	'Log'                       => array( 'Tala', 'Mga tala' ),
	'Lonelypages'               => array( 'Nangungulilang mga pahina', 'Ulilang mga pahina' ),
	'Longpages'                 => array( 'Mahabang mga pahina' ),
	'MergeHistory'              => array( 'Pagsanibin ang kasaysayan' ),
	'MIMEsearch'                => array( 'Paghahanap ng MIME' ),
	'Mostcategories'            => array( 'Pinakamaraming mga kaurian' ),
	'Mostimages'                => array( 'Mga talaksang may pinakamaraming kawing', 'Pinakamaraming talaksan', 'Pinakamaraming larawan' ),
	'Mostlinked'                => array( 'Mga pahinang may pinakamaraming kawing', 'Pinakamaraming kawing' ),
	'Mostlinkedcategories'      => array( 'Mga kauriang may pinakamaraming kawing', 'Pinakagamiting mga kaurian' ),
	'Mostlinkedtemplates'       => array( 'Mga suleras na may pinakamaraming kawing', 'Pinakagamiting mga suleras' ),
	'Mostrevisions'             => array( 'Pinakamaraming mga pagbabago' ),
	'Movepage'                  => array( 'Ilipat ang pahina' ),
	'Mycontributions'           => array( 'Mga ambag ko' ),
	'Mypage'                    => array( 'Pahina ko' ),
	'Mytalk'                    => array( 'Usapan ko' ),
	'Newimages'                 => array( 'Bagong mga talaksan', 'Bagong mga larawan' ),
	'Newpages'                  => array( 'Bagong mga pahina' ),
	'Popularpages'              => array( 'Sikat na mga pahina' ),
	'Preferences'               => array( 'Mga nais' ),
	'Prefixindex'               => array( 'Talatuntunan ng unlapi' ),
	'Protectedpages'            => array( 'Mga pahinang nakasanggalang' ),
	'Protectedtitles'           => array( 'Mga pamagat na nakasanggalang' ),
	'Randompage'                => array( 'Alin man', 'Alin mang pahina' ),
	'Randomredirect'            => array( 'Pagtuturo papunta sa alin mang pahina' ),
	'Recentchanges'             => array( 'Mga huling binago', 'HulingBinago' ),
	'Recentchangeslinked'       => array( 'Nakakawing ng kamakailang pagbabago', 'Kaugnay na mga pagbabago' ),
	'Revisiondelete'            => array( 'Pagbura ng pagbabago' ),
	'Search'                    => array( 'Maghanap' ),
	'Shortpages'                => array( 'Maikling mga pahina' ),
	'Specialpages'              => array( 'Natatanging mga pahina' ),
	'Statistics'                => array( 'Mga estadistika', 'Estadistika' ),
	'Tags'                      => array( 'Mga tatak' ),
	'Uncategorizedcategories'   => array( 'Mga kauriang walang kaurian' ),
	'Uncategorizedimages'       => array( 'Mga talaksang walang kaurian', 'Mga larawang walang kaurian' ),
	'Uncategorizedpages'        => array( 'Mga pahinang walang kaurian' ),
	'Uncategorizedtemplates'    => array( 'Mga suleras na walang kaurian' ),
	'Undelete'                  => array( 'Huwag burahin' ),
	'Unlockdb'                  => array( 'Huwag ikandado ang kalipunan ng dato' ),
	'Unusedcategories'          => array( 'Hindi ginagamit na mga kaurian' ),
	'Unusedimages'              => array( 'Hindi ginagamit na mga talaksan', 'Hindi ginagamit na mga larawan' ),
	'Unusedtemplates'           => array( 'Mga suleras na hindi ginagamit' ),
	'Unwatchedpages'            => array( 'Mga pahinang hindi binabantayanan' ),
	'Upload'                    => array( 'Magkarga' ),
	'Userlogin'                 => array( 'Paglagda ng tagagamit', 'Maglagda' ),
	'Userlogout'                => array( 'Pag-alis sa pagkalagda ng tagagamit', 'AlisLagda' ),
	'Userrights'                => array( 'Mga karapatan ng tagagamit' ),
	'Version'                   => array( 'Bersyon' ),
	'Wantedcategories'          => array( 'Ninanais na mga kaurian' ),
	'Wantedfiles'               => array( 'Ninanais na mga talaksan' ),
	'Wantedpages'               => array( 'Ninanais na mga pahina', 'Putol na mga kawing' ),
	'Wantedtemplates'           => array( 'Ninanais na mga suleras' ),
	'Watchlist'                 => array( 'Talaan ng binabantayan', 'Bantayan' ),
	'Whatlinkshere'             => array( 'Ano ang nakakawing dito' ),
	'Withoutinterwiki'          => array( 'Walang ugnayang-wiki' ),
);

