<?php
/** Finnish (Suomi)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Agony
 * @author Centerlink
 * @author Cimon Avaro
 * @author Crt
 * @author Harriv
 * @author Jaakonam
 * @author Jack Phoenix
 * @author Kaganer
 * @author Mobe
 * @author Nedergard
 * @author Nike
 * @author Ochs
 * @author Olli
 * @author Pxos
 * @author Silvonen
 * @author Str4nd
 * @author Tarmo
 * @author Tofu II
 * @author Veikk0.ma
 * @author Wix
 * @author Yaamboo
 * @author ZeiP
 * @author לערי ריינהארט
 */

$separatorTransformTable = array( ',' => "\xc2\xa0", '.' => ',' );

$namespaceNames = array(
	NS_MEDIA            => 'Media',
	NS_SPECIAL          => 'Toiminnot',
	NS_TALK             => 'Keskustelu',
	NS_USER             => 'Käyttäjä',
	// begin Wikia change
	// VOLDEV-64
	NS_USER_TALK        => 'Käyttäjän_keskustelusivu',
	// end Wikia change
	NS_PROJECT_TALK     => 'Keskustelu_{{GRAMMAR:elative|$1}}',
	NS_FILE             => 'Tiedosto',
	NS_FILE_TALK        => 'Keskustelu_tiedostosta',
	NS_MEDIAWIKI        => 'Järjestelmäviesti',
	NS_MEDIAWIKI_TALK   => 'Keskustelu_järjestelmäviestistä',
	NS_TEMPLATE         => 'Malline',
	NS_TEMPLATE_TALK    => 'Keskustelu_mallineesta',
	NS_HELP             => 'Ohje',
	NS_HELP_TALK        => 'Keskustelu_ohjeesta',
	NS_CATEGORY         => 'Luokka',
	NS_CATEGORY_TALK    => 'Keskustelu_luokasta',
);

$namespaceAliases = array(
	// begin Wikia change
	// VOLDEV-64
	'Keskustelu_käyttäjästä' => NS_USER_TALK,
	// end Wikia change
	'Kuva' => NS_FILE,
	'Keskustelu_kuvasta' => NS_FILE_TALK,
);


$datePreferences = array(
	'default',
	'fi normal',
	'fi seconds',
	'fi numeric',
	'ISO 8601',
);

$defaultDateFormat = 'fi normal';

$dateFormats = array(
	'fi normal time' => 'H.i',
	'fi normal date' => 'j. F"ta" Y',
	'fi normal both' => 'j. F"ta" Y "kello" H.i',

	'fi seconds time' => 'H:i:s',
	'fi seconds date' => 'j. F"ta" Y',
	'fi seconds both' => 'j. F"ta" Y "kello" H:i:s',

	'fi numeric time' => 'H.i',
	'fi numeric date' => 'j.n.Y',
	'fi numeric both' => 'j.n.Y "kello" H.i',
);

$datePreferenceMigrationMap = array(
	'default',
	'fi normal',
	'fi seconds',
	'fi numeric',
);

$bookstoreList = array(
	'Bookplus'                      => 'http://www.bookplus.fi/product.php?isbn=$1',
	'Helsingin yliopiston kirjasto' => 'http://pandora.lib.hel.fi/cgi-bin/mhask/monihask.py?volname=&author=&keyword=&ident=$1&submit=Hae&engine_helka=ON',
	'Pääkaupunkiseudun kirjastot'   => 'http://www.helmet.fi/search*fin/i?SEARCH=$1',
	'Tampereen seudun kirjastot'    => 'http://kirjasto.tampere.fi/Piki?formid=fullt&typ0=6&dat0=$1'
);

$magicWords = array(
	'redirect'                => array( '0', '#OHJAUS', '#UUDELLEENOHJAUS', '#REDIRECT' ),
	'notoc'                   => array( '0', '__EISISLUETT__', '__NOTOC__' ),
	'forcetoc'                => array( '0', '__SISLUETTPAKOTUS__', '__FORCETOC__' ),
	'toc'                     => array( '0', '__SISÄLLYSLUETTELO__', '__TOC__' ),
	'noeditsection'           => array( '0', '__EIOSIOMUOKKAUSTA__', '__NOEDITSECTION__' ),
	'noheader'                => array( '0', '__EIOTSIKKOA__', '__NOHEADER__' ),
	'currentmonth'            => array( '1', 'KULUVAKUU', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonthname'        => array( '1', 'KULUVAKUUNIMI', 'CURRENTMONTHNAME' ),
	'currentmonthnamegen'     => array( '1', 'KULUVAKUUNIMIGEN', 'CURRENTMONTHNAMEGEN' ),
	'currentmonthabbrev'      => array( '1', 'KULUVAKUUNIMILYHYT', 'CURRENTMONTHABBREV' ),
	'currentday'              => array( '1', 'KULUVAPÄIVÄ', 'CURRENTDAY' ),
	'currentday2'             => array( '1', 'KULUVAPÄIVÄ2', 'CURRENTDAY2' ),
	'currentdayname'          => array( '1', 'KULUVAPÄIVÄNIMI', 'CURRENTDAYNAME' ),
	'currentyear'             => array( '1', 'KULUVAVUOSI', 'CURRENTYEAR' ),
	'currenttime'             => array( '1', 'KULUVAAIKA', 'CURRENTTIME' ),
	'currenthour'             => array( '1', 'KULUVATUNTI', 'CURRENTHOUR' ),
	'localmonth'              => array( '1', 'PAIKALLINENKUU', 'LOCALMONTH', 'LOCALMONTH2' ),
	'localmonthname'          => array( '1', 'PAIKALLINENKUUNIMI', 'LOCALMONTHNAME' ),
	'localmonthnamegen'       => array( '1', 'PAIKALLINENKUUNIMIGEN', 'LOCALMONTHNAMEGEN' ),
	'localmonthabbrev'        => array( '1', 'PAIKALLINENKUUNIMILYHYT', 'LOCALMONTHABBREV' ),
	'localday'                => array( '1', 'PAIKALLINENPÄIVÄ', 'LOCALDAY' ),
	'localday2'               => array( '1', 'PAIKALLINENPÄIVÄ2', 'LOCALDAY2' ),
	'localdayname'            => array( '1', 'PAIKALLINENPÄIVÄNIMI', 'LOCALDAYNAME' ),
	'localyear'               => array( '1', 'PAIKALLINENVUOSI', 'LOCALYEAR' ),
	'localtime'               => array( '1', 'PAIKALLINENAIKA', 'LOCALTIME' ),
	'localhour'               => array( '1', 'PAIKALLINENTUNTI', 'LOCALHOUR' ),
	'numberofpages'           => array( '1', 'SIVUMÄÄRÄ', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', 'ARTIKKELIMÄÄRÄ', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'TIEDOSTOMÄÄRÄ', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', 'KÄYTTÄJÄMÄÄRÄ', 'NUMBEROFUSERS' ),
	'numberofedits'           => array( '1', 'MUOKKAUSMÄÄRÄ', 'NUMBEROFEDITS' ),
	'numberofviews'           => array( '1', 'SIVUHAKUMÄÄRÄ', 'NUMBEROFVIEWS' ),
	'pagename'                => array( '1', 'SIVUNIMI', 'PAGENAME' ),
	'pagenamee'               => array( '1', 'SIVUNIMIE', 'PAGENAMEE' ),
	'namespace'               => array( '1', 'NIMIAVARUUS', 'NAMESPACE' ),
	'namespacee'              => array( '1', 'NIMIAVARUUSE', 'NAMESPACEE' ),
	'talkspace'               => array( '1', 'KESKUSTELUAVARUUS', 'TALKSPACE' ),
	'talkspacee'              => array( '1', 'KESKUSTELUAVARUUSE', 'TALKSPACEE' ),
	'subjectspace'            => array( '1', 'AIHEAVARUUS', 'ARTIKKELIAVARUUS', 'SUBJECTSPACE', 'ARTICLESPACE' ),
	'subjectspacee'           => array( '1', 'AIHEAVARUUSE', 'ARTIKKELIAVARUUSE', 'SUBJECTSPACEE', 'ARTICLESPACEE' ),
	'fullpagename'            => array( '1', 'KOKOSIVUNIMI', 'FULLPAGENAME' ),
	'fullpagenamee'           => array( '1', 'KOKOSIVUNIMIE', 'FULLPAGENAMEE' ),
	'subpagename'             => array( '1', 'ALASIVUNIMI', 'SUBPAGENAME' ),
	'subpagenamee'            => array( '1', 'ALASIVUNIMIE', 'SUBPAGENAMEE' ),
	'basepagename'            => array( '1', 'KANTASIVUNIMI', 'BASEPAGENAME' ),
	'basepagenamee'           => array( '1', 'KANTASIVUNIMIE', 'BASEPAGENAMEE' ),
	'talkpagename'            => array( '1', 'KESKUSTELUSIVUNIMI', 'TALKPAGENAME' ),
	'talkpagenamee'           => array( '1', 'KESKUSTELUSIVUNIMIE', 'TALKPAGENAMEE' ),
	'subjectpagename'         => array( '1', 'AIHESIVUNIMI', 'ARTIKKELISIVUNIMI', 'SUBJECTPAGENAME', 'ARTICLEPAGENAME' ),
	'subjectpagenamee'        => array( '1', 'AIHESIVUNIMIE', 'ARTIKKELISIVUNIMIE', 'SUBJECTPAGENAMEE', 'ARTICLEPAGENAMEE' ),
	'subst'                   => array( '0', 'VASTINE:', 'SUBST:' ),
	'img_thumbnail'           => array( '1', 'pienoiskuva', 'pienois', 'thumbnail', 'thumb' ),
	'img_manualthumb'         => array( '1', 'pienoiskuva=$1', 'pienois=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'               => array( '1', 'oikea', 'right' ),
	'img_left'                => array( '1', 'vasen', 'left' ),
	'img_none'                => array( '1', 'tyhjä', 'none' ),
	'img_center'              => array( '1', 'keskitetty', 'keski', 'center', 'centre' ),
	'img_framed'              => array( '1', 'kehys', 'kehystetty', 'framed', 'enframed', 'frame' ),
	'img_frameless'           => array( '1', 'kehyksetön', 'frameless' ),
	'img_page'                => array( '1', 'sivu=$1', 'sivu $1', 'page=$1', 'page $1' ),
	'img_upright'             => array( '1', 'yläoikea', 'yläoikea=$1', 'yläoikea $1', 'upright', 'upright=$1', 'upright $1' ),
	'img_border'              => array( '1', 'reunus', 'border' ),
	'img_baseline'            => array( '1', 'perustaso', 'baseline' ),
	'img_sub'                 => array( '1', 'alaindeksi', 'sub' ),
	'img_super'               => array( '1', 'yläindeksi', 'super', 'sup' ),
	'img_top'                 => array( '1', 'ylös', 'ylhäällä', 'top' ),
	'img_middle'              => array( '1', 'keskellä', 'middle' ),
	'img_bottom'              => array( '1', 'alas', 'alhaalla', 'bottom' ),
	'img_link'                => array( '1', 'linkki=$1', 'link=$1' ),
	'sitename'                => array( '1', 'SIVUSTONIMI', 'SITENAME' ),
	'ns'                      => array( '0', 'NA:', 'NS:' ),
	'localurl'                => array( '0', 'PAIKALLINENOSOITE:', 'LOCALURL:' ),
	'localurle'               => array( '0', 'PAIKALLINENOSOITEE:', 'LOCALURLE:' ),
	'server'                  => array( '0', 'PALVELIN', 'SERVER' ),
	'servername'              => array( '0', 'PALVELINNIMI', 'SERVERNAME' ),
	'scriptpath'              => array( '0', 'SKRIPTIPOLKU', 'SCRIPTPATH' ),
	'grammar'                 => array( '0', 'TAIVUTUS:', 'GRAMMAR:' ),
	'gender'                  => array( '0', 'SUKUPUOLI:', 'GENDER:' ),
	'currentweek'             => array( '1', 'KULUVAVIIKKO', 'CURRENTWEEK' ),
	'currentdow'              => array( '1', 'KULUVAVIIKONPÄIVÄ', 'CURRENTDOW' ),
	'localweek'               => array( '1', 'PAIKALLINENVIIKKO', 'LOCALWEEK' ),
	'localdow'                => array( '1', 'PAIKALLINENVIIKONPÄIVÄ', 'LOCALDOW' ),
	'revisionid'              => array( '1', 'VERSIOID', 'REVISIONID' ),
	'revisionday'             => array( '1', 'VERSIOPÄIVÄ', 'REVISIONDAY' ),
	'revisionday2'            => array( '1', 'VERSIOPÄIVÄ2', 'REVISIONDAY2' ),
	'revisionmonth'           => array( '1', 'VERSIOKUUKAUSI', 'REVISIONMONTH' ),
	'revisionyear'            => array( '1', 'VERSIOVUOSI', 'REVISIONYEAR' ),
	'revisiontimestamp'       => array( '1', 'VERSIOAIKALEIMA', 'REVISIONTIMESTAMP' ),
	'plural'                  => array( '0', 'MONIKKO:', 'PLURAL:' ),
	'fullurl'                 => array( '0', 'TÄYSIOSOITE:', 'FULLURL:' ),
	'fullurle'                => array( '0', 'TÄYSIOSOITEE:', 'FULLURLE:' ),
	'displaytitle'            => array( '1', 'NÄKYVÄOTSIKKO', 'DISPLAYTITLE' ),
	'currentversion'          => array( '1', 'NYKYINENVERSIO', 'CURRENTVERSION' ),
	'currenttimestamp'        => array( '1', 'KULUVAAIKALEIMA', 'CURRENTTIMESTAMP' ),
	'localtimestamp'          => array( '1', 'PAIKALLINENAIKALEIMA', 'LOCALTIMESTAMP' ),
	'language'                => array( '0', '#KIELI:', '#LANGUAGE:' ),
	'numberofadmins'          => array( '1', 'YLLÄPITÄJÄMÄÄRÄ', 'NUMBEROFADMINS' ),
	'formatnum'               => array( '0', 'MUOTOILELUKU', 'FORMATNUM' ),
	'defaultsort'             => array( '1', 'AAKKOSTUS:', 'OLETUSAAKKOSTUS:', 'DEFAULTSORT:', 'DEFAULTSORTKEY:', 'DEFAULTCATEGORYSORT:' ),
	'filepath'                => array( '0', 'TIEDOSTOPOLKU:', 'FILEPATH:' ),
	'hiddencat'               => array( '1', '__PIILOLUOKKA__', '__HIDDENCAT__' ),
	'pagesize'                => array( '1', 'SIVUKOKO', 'PAGESIZE' ),
	'noindex'                 => array( '1', '__HAKUKONEKIELTO__', '__NOINDEX__' ),
	'protectionlevel'         => array( '1', 'SUOJAUSTASO', 'PROTECTIONLEVEL' ),
);

$specialPageAliases = array(
	'Activeusers'               => array( 'Aktiiviset_käyttäjät' ),
	'Allmessages'               => array( 'Järjestelmäviestit' ),
	'Allpages'                  => array( 'Kaikki_sivut' ),
	'Ancientpages'              => array( 'Kuolleet_sivut' ),
	'Badtitle'                  => array( 'Kelpaamaton_otsikko' ),
	'Blankpage'                 => array( 'Tyhjä_sivu' ),
	'Block'                     => array( 'Estä' ),
	'Blockme'                   => array( 'Estä_minut' ),
	'Booksources'               => array( 'Kirjalähteet' ),
	'BrokenRedirects'           => array( 'Virheelliset_ohjaukset', 'Virheelliset_uudelleenohjaukset' ),
	'Categories'                => array( 'Luokat' ),
	'ChangeEmail'               => array( 'Muuta_sähköpostiosoite' ),
	'ChangePassword'            => array( 'Muuta_salasana', 'Alusta_salasana' ),
	'ComparePages'              => array( 'Vertaa_sivuja' ),
	'Confirmemail'              => array( 'Varmista_sähköpostiosoite' ),
	'Contributions'             => array( 'Muokkaukset' ),
	'CreateAccount'             => array( 'Luo_tunnus' ),
	'Deadendpages'              => array( 'Linkittömät_sivut' ),
	'DeletedContributions'      => array( 'Poistetut_muokkaukset' ),
	'Disambiguations'           => array( 'Täsmennyssivut' ),
	'DoubleRedirects'           => array( 'Kaksinkertaiset_ohjaukset', 'Kaksinkertaiset_uudelleenohjaukset' ),
	'EditWatchlist'             => array( 'Muokkaa_tarkkailulistaa' ),
	'Emailuser'                 => array( 'Lähetä_sähköpostia' ),
	'Export'                    => array( 'Vie_sivuja' ),
	'Fewestrevisions'           => array( 'Vähiten_muokatut_sivut' ),
	'FileDuplicateSearch'       => array( 'Kaksoiskappaleiden_haku' ),
	'Filepath'                  => array( 'Tiedostopolku' ),
	'Import'                    => array( 'Tuo_sivuja' ),
	'Invalidateemail'           => array( 'Hylkää_sähköpostiosoite' ),
	'BlockList'                 => array( 'Muokkausestot' ),
	'LinkSearch'                => array( 'Linkkihaku' ),
	'Listadmins'                => array( 'Ylläpitäjät' ),
	'Listbots'                  => array( 'Botit' ),
	'Listfiles'                 => array( 'Tiedostoluettelo' ),
	'Listgrouprights'           => array( 'Käyttäjäryhmien_oikeudet' ),
	'Listredirects'             => array( 'Ohjaukset', 'Ohjaussivut', 'Uudelleenohjaukset' ),
	'Listusers'                 => array( 'Käyttäjät' ),
	'Lockdb'                    => array( 'Lukitse_tietokanta' ),
	'Log'                       => array( 'Loki', 'Lokit' ),
	'Lonelypages'               => array( 'Yksinäiset_sivut' ),
	'Longpages'                 => array( 'Pitkät_sivut' ),
	'MergeHistory'              => array( 'Liitä_muutoshistoria' ),
	'MIMEsearch'                => array( 'MIME-haku' ),
	'Mostcategories'            => array( 'Luokitelluimmat_sivut' ),
	'Mostimages'                => array( 'Viitatuimmat_tiedostot' ),
	'Mostlinked'                => array( 'Viitatuimmat_sivut' ),
	'Mostlinkedcategories'      => array( 'Viitatuimmat_luokat' ),
	'Mostlinkedtemplates'       => array( 'Viitatuimmat_mallineet' ),
	'Mostrevisions'             => array( 'Muokatuimmat_sivut' ),
	'Movepage'                  => array( 'Siirrä_sivu' ),
	'Mycontributions'           => array( 'Omat_muokkaukset' ),
	// begin Wikia change
	// VOLDEV-64
	'Mypage'                    => array( 'Omasivu', 'Oma_sivu' ),
	// end Wikia change
	'Mytalk'                    => array( 'Oma_keskustelu' ),
	'Myuploads'                 => array( 'Omat_tiedostot' ),
	'Newimages'                 => array( 'Uudet_tiedostot', 'Uudet_kuvat' ),
	'Newpages'                  => array( 'Uudet_sivut' ),
	'PasswordReset'             => array( 'Unohtuneen_salasanan_vaihto' ),
	'PermanentLink'             => array( 'Ikilinkki' ),
	'Popularpages'              => array( 'Suositut_sivut' ),
	'Preferences'               => array( 'Asetukset' ),
	'Prefixindex'               => array( 'Etuliiteluettelo' ),
	'Protectedpages'            => array( 'Suojatut_sivut' ),
	'Protectedtitles'           => array( 'Suojatut_sivunimet' ),
	'Randompage'                => array( 'Satunnainen_sivu' ),
	'Randomredirect'            => array( 'Satunnainen_ohjaus', 'Satunnainen_uudelleenohjaus' ),
	'Recentchanges'             => array( 'Tuoreet_muutokset' ),
	'Recentchangeslinked'       => array( 'Linkitetyt_muutokset' ),
	'Revisiondelete'            => array( 'Poista_muokkaus' ),
	'RevisionMove'              => array( 'Versioiden_siirto' ),
	'Search'                    => array( 'Haku' ),
	'Shortpages'                => array( 'Lyhyet_sivut' ),
	'Specialpages'              => array( 'Toimintosivut' ),
	'Statistics'                => array( 'Tilastot' ),
	'Tags'                      => array( 'Merkinnät' ),
	'Unblock'                   => array( 'Poista_esto' ),
	'Uncategorizedcategories'   => array( 'Luokittelemattomat_luokat' ),
	'Uncategorizedimages'       => array( 'Luokittelemattomat_tiedostot' ),
	'Uncategorizedpages'        => array( 'Luokittelemattomat_sivut' ),
	'Uncategorizedtemplates'    => array( 'Luokittelemattomat_mallineet' ),
	'Undelete'                  => array( 'Palauta' ),
	'Unlockdb'                  => array( 'Avaa_tietokanta' ),
	'Unusedcategories'          => array( 'Käyttämättömät_luokat' ),
	'Unusedimages'              => array( 'Käyttämättömät_tiedostot' ),
	'Unusedtemplates'           => array( 'Käyttämättömät_mallineet' ),
	'Unwatchedpages'            => array( 'Tarkkailemattomat_sivut' ),
	'Upload'                    => array( 'Tallenna', 'Lisää_tiedosto' ),
	'Userlogin'                 => array( 'Kirjaudu_sisään' ),
	'Userlogout'                => array( 'Kirjaudu_ulos' ),
	'Userrights'                => array( 'Käyttöoikeudet' ),
	'Version'                   => array( 'Versio' ),
	'Wantedcategories'          => array( 'Halutuimmat_luokat' ),
	'Wantedfiles'               => array( 'Halutuimmat_tiedostot' ),
	'Wantedpages'               => array( 'Halutuimmat_sivut' ),
	'Wantedtemplates'           => array( 'Halutuimmat_mallineet' ),
	'Watchlist'                 => array( 'Tarkkailulista' ),
	'Whatlinkshere'             => array( 'Tänne_viittaavat_sivut' ),
	'Withoutinterwiki'          => array( 'Kielilinkittömät_sivut' ),
);

$linkTrail = '/^([a-zäö]+)(.*)$/sDu';

