<?php
/** Oriya (ଓଡ଼ିଆ)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Ansumang
 * @author Jayantanth
 * @author Jnanaranjan Sahu
 * @author Jose77
 * @author MKar
 * @author Odisha1
 * @author Psubhashish
 * @author Sambiwiki
 * @author Shijualex
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 */

$digitTransformTable = array(
	'0' => '୦', # &#x0b66;
	'1' => '୧', # &#x0b67;
	'2' => '୨', # &#x0b68;
	'3' => '୩', # &#x0b69;
	'4' => '୪', # &#x0b6a;
	'5' => '୫', # &#x0b6b;
	'6' => '୬', # &#x0b6c;
	'7' => '୭', # &#x0b6d;
	'8' => '୮', # &#x0b6e;
	'9' => '୯', # &#x0b6f;
);

/** namespace translations from translatewiki.net
 * @author Shijualex
 * @author Psubhashish
 */
$namespaceNames = array(
	NS_MEDIA            => 'ମାଧ୍ୟମ',
	NS_SPECIAL          => 'ବିଶେଷ',
	NS_TALK             => 'ଆଲୋଚନା',
	NS_USER             => 'ବ୍ୟବହାରକାରୀ',
	NS_USER_TALK        => 'ବ୍ୟବହାରକାରୀଙ୍କ_ଆଲୋଚନା',
	NS_PROJECT_TALK     => '$1_ଆଲୋଚନା',
	NS_FILE             => 'ଫାଇଲ',
	NS_FILE_TALK        => 'ଫାଇଲ_ଆଲୋଚନା',
	NS_MEDIAWIKI        => 'ମିଡ଼ିଆଉଇକି',
	NS_MEDIAWIKI_TALK   => 'ମିଡ଼ିଆଉଇକି_ଆଲୋଚନା',
	NS_TEMPLATE         => 'ଛାଞ୍ଚ',
	NS_TEMPLATE_TALK    => 'ଛାଞ୍ଚ_ଆଲୋଚନା',
	NS_HELP             => 'ସହଯୋଗ',
	NS_HELP_TALK        => 'ସହଯୋଗ_ଆଲୋଚନା',
	NS_CATEGORY         => 'ଶ୍ରେଣୀ',
	NS_CATEGORY_TALK    => 'ଶ୍ରେଣୀ_ଆଲୋଚନା',
);

$namespaceAliases = array(
	'ବ୍ୟବହାରକାରି'          => NS_USER,
	'ବ୍ୟବହାରକାରିଁକ_ଆଲୋଚନା' => NS_USER_TALK,
	'ବ୍ୟବାହାରକାରୀ'          => NS_USER,
	'ବ୍ୟବାହାରକାରୀଙ୍କ_ଆଲୋଚନା' => NS_USER_TALK,
	'ଉଇକିପିଡ଼ିଆ_ଆଲୋଚନା' => NS_PROJECT_TALK,
	'ଟେଁପଲେଟ'             => NS_TEMPLATE,
	'ଟେଁପଲେଟ_ଆଲୋଚନା'     => NS_TEMPLATE_TALK,
	'ଟେମ୍ପଲେଟ'             => NS_TEMPLATE,
	'ଟେମ୍ପଲେଟ_ଆଲୋଚନା'     => NS_TEMPLATE_TALK,
	'ବିଭାଗ'                => NS_CATEGORY,
	'ବିଭାଗିୟ_ଆଲୋଚନା'      => NS_CATEGORY_TALK,
	'ସାହାଯ୍ୟ'                => NS_HELP,
	'ସାହାଯ୍ୟ_ଆଲୋଚନା'      => NS_HELP_TALK,
);

$specialPageAliases = array(
	'Activeusers'               => array( 'ସଚଳ_ସଭ୍ୟ' ),
	'Allmessages'               => array( 'ସବୁ_ମେସେଜ' ),
	'Allpages'                  => array( 'ସବୁ_ପୃଷ୍ଠା' ),
	'Ancientpages'              => array( 'ପୁରୁଣା_' ),
	'Blankpage'                 => array( 'ଖାଲି_ପୃଷ୍ଠା' ),
	'Block'                     => array( 'ଅଟକାଇଦେବେ', 'ଆଇପି_ଅଟକାଇଦେବେ', 'ଇଉଜରକୁ_ଅଟକାଇଦେବେ' ),
	'Blockme'                   => array( 'ମୋତେ_ଅଟକାଇଦିଅନ୍ତୁ' ),
	'Booksources'               => array( 'ଲେଖା_ନିଆଯାଇଥିବା_ବହି' ),
	'BrokenRedirects'           => array( 'ଭଙ୍ଗା_ଲେଉଟାଣି' ),
	'Categories'                => array( 'ଶ୍ରେଣୀ' ),
	'ChangeEmail'               => array( 'ଇମେଲ_ବଦଳାଇବେ' ),
	'ChangePassword'            => array( 'ପାସବାର୍ଡ଼_ବଦଳାଇବେ' ),
	'ComparePages'              => array( 'ପୃଷ୍ଠାକୁ_ତଉଲିବେ' ),
	'Confirmemail'              => array( 'ଇମେଲ_ଥୟ_କରିବେ' ),
	'Contributions'             => array( 'ଅବଦାନ' ),
	'CreateAccount'             => array( 'ଖାତା_ଖୋଲିବେ' ),
	'Deadendpages'              => array( 'ଆଗକୁ_ରାହା_ନଥିବା_ପୃଷ୍ଠା' ),
	'DeletedContributions'      => array( 'ହଟାଇ_ଦିଆଯାଇଥିବା_ଅବଦାନ' ),
	'Disambiguations'           => array( 'ଆବୁରୁଜାବୁରୁ_କଥା' ),
	'DoubleRedirects'           => array( 'ଦୁଇଥର_ଲେଉଟାଣି' ),
	'Emailuser'                 => array( 'ସଭ୍ୟଙ୍କୁ_ମେଲ_କରନ୍ତୁ' ),
	'Export'                    => array( 'ରପ୍ତାନି_କରିବା' ),
	'Fewestrevisions'           => array( 'ସବୁଠୁ_କମ_ସଙ୍କଳନ' ),
	'FileDuplicateSearch'       => array( 'ନକଲି_ଫାଇଲ_ଖୋଜା' ),
	'Filepath'                  => array( 'ଫାଇଲରାସ୍ତା' ),
	'Import'                    => array( 'ଆମଦାନି' ),
	'Invalidateemail'           => array( 'କାମକରୁନଥିବା_ଇମେଲ' ),
	'BlockList'                 => array( 'ତାଲିକାକୁ__ଅଟକାଇଦେବା' ),
	'LinkSearch'                => array( 'ଲିଙ୍କ_ଖୋଜା' ),
	'Listadmins'                => array( 'ପରିଛା_ତାଲିକା' ),
	'Listbots'                  => array( 'ବଟ_ମାନଙ୍କ_ତାଲିକା' ),
	'Listfiles'                 => array( 'ଫାଇଲ_ତାଲିକା' ),
	'Listgrouprights'           => array( 'ଗୋଠ_ନିୟମ_ତାଲିକା' ),
	'Listredirects'             => array( 'ଲେଉଟାଣି_ତାଲିକା' ),
	'Listusers'                 => array( 'ଇଉଜର_ତାଲିକା' ),
	'Lockdb'                    => array( 'ଡାଟାବେସ‌_କିଳିଦେବା' ),
	'Log'                       => array( 'ଲଗ' ),
	'Lonelypages'               => array( 'ଏକୁଟିଆ_ପୃଷ୍ଠା' ),
	'Longpages'                 => array( 'ଲମ୍ବା_ପୃଷ୍ଠା' ),
	'MergeHistory'              => array( 'ଇତିହାସକୁ_ମିଶାଇଦେବା' ),
	'MIMEsearch'                => array( 'MIME_ଖୋଜା' ),
	'Mostcategories'            => array( 'ଅଧିକ_ଶ୍ରେଣୀ' ),
	'Mostimages'                => array( 'ଅଧିକ_ଯୋଡ଼ା_ଫାଇଲ' ),
	'Mostlinked'                => array( 'ଅଧିକ_ଯୋଡ଼ା_ପୃଷ୍ଠା' ),
	'Mostlinkedcategories'      => array( 'ଅଧିକ_ଯୋଡ଼ା_ଶ୍ରେଣୀ' ),
	'Mostlinkedtemplates'       => array( 'ଅଧିକ_ଯୋଡ଼ା_ଛାଞ୍ଚ' ),
	'Mostrevisions'             => array( 'ଅଧିକ_ସଙ୍କଳନ' ),
	'Movepage'                  => array( 'ପୃଷ୍ଠାକୁ_ଘୁଞ୍ଚାଇବା' ),
	'Mycontributions'           => array( 'ମୋ_ଅବଦାନ' ),
	'Mypage'                    => array( 'ମୋ_ପୃଷ୍ଠା' ),
	'Mytalk'                    => array( 'ମୋ_ଆଲୋଚନା' ),
	'Myuploads'                 => array( 'ମୋ_ଅପଲୋଡ଼' ),
	'Newimages'                 => array( 'ନୂଆ_ଫାଇଲ' ),
	'Newpages'                  => array( 'ନୂଆ_ପୃଷ୍ଠା' ),
	'PermanentLink'             => array( 'ଚିରକାଳର_ଲିଙ୍କ' ),
	'Popularpages'              => array( 'ଜଣାଶୁଣା_ପୃଷ୍ଠା' ),
	'Preferences'               => array( 'ପସନ୍ଦସବୁ' ),
	'Prefixindex'               => array( 'ଆଗରେ_ଯୋଡ଼ାହେବା_ଇଣ୍ଡେକ୍ସ' ),
	'Protectedpages'            => array( 'କିଳାଯାଇଥିବା_ପୃଷ୍ଠା' ),
	'Protectedtitles'           => array( 'କିଳାଯାଇଥିବା_ନାଆଁ' ),
	'Randompage'                => array( 'ଇଆଡୁ_ଇଆଡୁ' ),
	'Randomredirect'            => array( 'ଜାହିତାହି_ଫେରଣାଲେଉଟାଣି' ),
	'Recentchanges'             => array( 'ନଗଦ_ବଦଳ' ),
	'Recentchangeslinked'       => array( 'ଜୋଡ଼ାଥିବା_ନଗଦ_ବଦଳ' ),
	'Revisiondelete'            => array( 'ସଙ୍କଳନଲିଭାଇଦିଅଦେବେ' ),
	'RevisionMove'              => array( 'ସଙ୍କଳନ' ),
	'Search'                    => array( 'ଖୋଜନ୍ତୁ' ),
	'Shortpages'                => array( 'ଛୋଟ_ପୃଷ୍ଠା' ),
	'Specialpages'              => array( 'ବିଶେଷ_ପୃଷ୍ଠା' ),
	'Statistics'                => array( 'ଗଣନା' ),
	'Tags'                      => array( 'ଚିହ୍ନସମୂହ' ),
	'Unblock'                   => array( 'ଫିଟାଇଦେବେ' ),
	'Uncategorizedcategories'   => array( 'ଅସଜଡ଼ା_ଶ୍ରେଣୀ' ),
	'Uncategorizedimages'       => array( 'ସଜଡ଼ା_ଶ୍ରେଣୀର_ଫାଇଲ' ),
	'Uncategorizedpages'        => array( 'ଅସଜଡ଼ା_ଫାଇଲସବୁ' ),
	'Uncategorizedtemplates'    => array( 'ଅସଜଡ଼ା_ଛାଞ୍ଚ' ),
	'Undelete'                  => array( 'ଲିଭାନ୍ତୁ_ନାହିଁ' ),
	'Unlockdb'                  => array( 'DBଖୋଲିବା' ),
	'Unusedcategories'          => array( 'ବ୍ୟବହାର_ହୋଇନଥିବା_ଶ୍ରେଣୀ' ),
	'Unusedimages'              => array( 'ବ୍ୟବହାର_ହୋଇନଥିବା_ଫାଇଲ' ),
	'Unusedtemplates'           => array( 'ବ୍ୟବହାର_ହୋଇନଥିବା_ଛାଞ୍ଚ' ),
	'Unwatchedpages'            => array( 'ଦେଖାଯାଇନଥିବା_ପୃଷ୍ଠାସବୁ' ),
	'Upload'                    => array( 'ଅପଲୋଡ଼' ),
	'UploadStash'               => array( 'ଷ୍ଟାସ_ଅପଲୋଡ଼_କରନ୍ତୁ' ),
	'Userlogin'                 => array( 'ସଭ୍ୟ_ଲଗ_ଇନ' ),
	'Userlogout'                => array( 'ସଭ୍ୟ_ଲଗ_ଆଉଟ' ),
	'Userrights'                => array( 'ସଭ୍ୟ_ଅଧିକାର' ),
	'Version'                   => array( 'ସଂସ୍କରଣ' ),
	'Wantedcategories'          => array( 'ଦରକାରି_ଶ୍ରେଣୀ' ),
	'Wantedfiles'               => array( 'ଦରକାରି_ଫାଇଲ' ),
	'Wantedpages'               => array( 'ଦରକାରି_ପୃଷ୍ଠା' ),
	'Wantedtemplates'           => array( 'ଦରକାରି_ଛାଞ୍ଚ' ),
	'Watchlist'                 => array( 'ଦେଖଣା_ତାଲିକା' ),
	'Whatlinkshere'             => array( 'ଏଠାରେ_କଣ_ଲିଙ୍କ_ଅଛି' ),
	'Withoutinterwiki'          => array( 'ଇଣ୍ଟରଉଇକି_ବିନା' ),
);

$magicWords = array(
	'redirect'                => array( '0', '#ଲେଉଟାଣି', '#REDIRECT' ),
	'noeditsection'           => array( '0', '_ବଦଳା_ନହେବାଶ୍ରେଣୀ_', '__NOEDITSECTION__' ),
	'currentmonth'            => array( '1', 'ଏବେକାର_ମାସ', 'ଏବେର_ମାସ୨', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonth1'           => array( '1', 'ଏବେର_ମାସ', 'CURRENTMONTH1' ),
	'currentmonthname'        => array( '1', 'ଏବେକାର_ମାସ_ନାଆଁ', 'CURRENTMONTHNAME' ),
	'currentmonthnamegen'     => array( '1', 'ଏବେକାର_ମାସ_ନାଆଁ_ସାଧାରଣ', 'CURRENTMONTHNAMEGEN' ),
	'currentmonthabbrev'      => array( '1', 'ଏବେକାର_ମାସ_ନାଆଁ_ସଂକ୍ଷିପ୍ତ', 'CURRENTMONTHABBREV' ),
	'currentday'              => array( '1', 'ଏବେକାର_ଦିନ', 'CURRENTDAY' ),
	'currentday2'             => array( '1', 'ଏବେକାର_ଦିନ୨', 'CURRENTDAY2' ),
	'currentdayname'          => array( '1', 'ଏବେକାର_ଦିନ_ନାଆଁ', 'CURRENTDAYNAME' ),
	'currentyear'             => array( '1', 'ଏବେକାର_ବର୍ଷ', 'CURRENTYEAR' ),
	'currenttime'             => array( '1', 'ଏବେକାର_ସମୟ', 'CURRENTTIME' ),
	'currenthour'             => array( '1', 'ଏବେକାର_ଘଣ୍ଟା', 'CURRENTHOUR' ),
	'localmonth'              => array( '1', 'ଏବେର_ମାସ୧', 'ସ୍ଥାନୀୟ_ମାସ୨', 'LOCALMONTH', 'LOCALMONTH2' ),
	'localmonth1'             => array( '1', 'ଏବେକାର_ମାସ୧', 'LOCALMONTH1' ),
	'localmonthname'          => array( '1', 'ମାସ୧ର_ନାଆଁ', 'LOCALMONTHNAME' ),
	'localmonthnamegen'       => array( '1', 'ସ୍ଥାନୀୟ_ମାସ୧_ନାଆଁ_ସାଧାରଣ', 'LOCALMONTHNAMEGEN' ),
	'localmonthabbrev'        => array( '1', 'ସ୍ଥାନୀୟ_ମାସର୧_ନାଆଁ_ସଂକ୍ଷିପ୍ତ', 'LOCALMONTHABBREV' ),
	'localday'                => array( '1', 'Local_ଦିନ', 'LOCALDAY' ),
	'localday2'               => array( '1', 'ସ୍ଥାନୀୟ_ଦିନ୨', 'LOCALDAY2' ),
	'localdayname'            => array( '1', 'ଦିନ', 'LOCALDAYNAME' ),
	'localyear'               => array( '1', 'ସ୍ଥାନୀୟ_ବର୍ଷ', 'LOCALYEAR' ),
	'localtime'               => array( '1', 'ସ୍ଥାନୀୟ_ସମୟ', 'LOCALTIME' ),
	'localhour'               => array( '1', 'ସ୍ଥାନୀୟ_ଘଣ୍ଟା', 'LOCALHOUR' ),
	'numberofpages'           => array( '1', 'ପୃଷ୍ଠା_ସଂଖ୍ୟା', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', 'ଲେଖା_ସଂଖ୍ୟା', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'ଫାଇଲ_ସଂଖ୍ୟା', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', 'ବ୍ୟବାହାରକାରୀ_ସଂଖ୍ୟା', 'NUMBEROFUSERS' ),
	'numberofactiveusers'     => array( '1', 'ସଚଳ_ବ୍ୟବାହାରକାରୀଙ୍କ_ସଂଖ୍ୟା', 'NUMBEROFACTIVEUSERS' ),
	'numberofedits'           => array( '1', 'ବଦଳ_ସଂଖ୍ୟା', 'NUMBEROFEDITS' ),
	'numberofviews'           => array( '1', 'କେତେଥର_ଦେଖାଯାଇଛି', 'NUMBEROFVIEWS' ),
	'pagename'                => array( '1', 'ପୃଷ୍ଠା_ନାଆଁ', 'PAGENAME' ),
	'pagenamee'               => array( '1', 'ପୃଷ୍ଠା_ନାମକାରଣକାରୀ', 'PAGENAMEE' ),
	'namespace'               => array( '1', 'ନେମସ୍ପେସ', 'NAMESPACE' ),
	'namespacee'              => array( '1', 'ନେମସ୍ପେସକାରୀ', 'NAMESPACEE' ),
	'talkspace'               => array( '1', 'ଟକସ୍ପେସ', 'TALKSPACE' ),
	'talkspacee'              => array( '1', 'ଟକସ୍ପେସକାରୀ', 'TALKSPACEE' ),
	'subjectspace'            => array( '1', 'ବିଷୟସ୍ପେସ', 'ଲେଖାସ୍ପେସ', 'SUBJECTSPACE', 'ARTICLESPACE' ),
	'msg'                     => array( '0', 'ମେସେଜ:', 'MSG:' ),
	'img_manualthumb'         => array( '1', 'ନଖଦେଖଣା=$1', 'ଦେଖଣା=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'               => array( '1', 'ଡାହାଣ', 'right' ),
	'img_left'                => array( '1', 'ବାଆଁ', 'left' ),
	'img_none'                => array( '1', 'କିଛି_ନୁହେଁ', 'none' ),
	'img_width'               => array( '1', '$1_ପିକସେଲ', '$1px' ),
	'img_center'              => array( '1', 'କେନ୍ଦ୍ର', 'center', 'centre' ),
	'img_framed'              => array( '1', 'ଫ୍ରେମକରା', 'framed', 'enframed', 'frame' ),
	'img_frameless'           => array( '1', 'ଫ୍ରେମନଥିବା', 'frameless' ),
	'img_border'              => array( '1', 'ବର୍ଡର', 'border' ),
	'img_baseline'            => array( '1', 'ବେସଲାଇନ', 'baseline' ),
	'img_top'                 => array( '1', 'ଉପର', 'top' ),
	'img_text_top'            => array( '1', 'ଲେଖା-ଉପର', 'text-top' ),
	'img_middle'              => array( '1', 'ମଝି', 'middle' ),
	'img_bottom'              => array( '1', 'ତଳ', 'bottom' ),
	'img_text_bottom'         => array( '1', 'ଲେଖା-ତଳ', 'text-bottom' ),
	'img_link'                => array( '1', 'ଲିଙ୍କ=$1', 'link=$1' ),
	'articlepath'             => array( '0', 'ଲେଖାର_ପଥ', 'ARTICLEPATH' ),
	'server'                  => array( '0', 'ସର୍ଭର', 'SERVER' ),
	'grammar'                 => array( '0', 'ବ୍ୟାକରଣ', 'GRAMMAR:' ),
	'gender'                  => array( '0', 'ଲିଙ୍ଗ', 'GENDER:' ),
	'plural'                  => array( '0', 'ବହୁବଚନ:', 'PLURAL:' ),
	'raw'                     => array( '0', 'କଞ୍ଚା', 'RAW:' ),
	'displaytitle'            => array( '1', 'ଦେଖଣାନାଆଁ', 'DISPLAYTITLE' ),
	'newsectionlink'          => array( '1', '_ନୂଆବିଭାଗଲିଙ୍କ_', '__NEWSECTIONLINK__' ),
	'nonewsectionlink'        => array( '1', '_ନୂଆ_ବିଭାଗ_ନକରିବା_ଲିଙ୍କ_', '__NONEWSECTIONLINK__' ),
	'currentversion'          => array( '1', 'ନଗଦ_ରିଭିଜନ', 'CURRENTVERSION' ),
	'numberofadmins'          => array( '1', 'ପରିଛାମାନଙ୍କତାଲିକା', 'NUMBEROFADMINS' ),
	'padleft'                 => array( '0', 'ବାଆଁପ୍ୟାଡ଼', 'PADLEFT' ),
	'padright'                => array( '0', 'ଡାହାଣପ୍ୟାଡ଼', 'PADRIGHT' ),
	'special'                 => array( '0', 'ବିଶେଷ', 'special' ),
	'filepath'                => array( '0', 'ଫାଇଲରାହା:', 'FILEPATH:' ),
	'tag'                     => array( '0', 'ଟାଗ', 'tag' ),
	'hiddencat'               => array( '1', '_ଲୁଚିଥିବାବିଭାଗ_', '__HIDDENCAT__' ),
	'pagesize'                => array( '1', 'ଫରଦଆକାର', 'PAGESIZE' ),
	'protectionlevel'         => array( '1', 'ପ୍ରତିରକ୍ଷାସ୍ତର', 'PROTECTIONLEVEL' ),
	'formatdate'              => array( '0', 'ତାରିଖରପ୍ରକାର', 'formatdate', 'dateformat' ),
	'url_path'                => array( '0', 'ବାଟ', 'PATH' ),
	'url_wiki'                => array( '0', 'ଉଇକି', 'WIKI' ),
	'url_query'               => array( '0', 'ପ୍ରଶ୍ନ', 'QUERY' ),
);

$digitGroupingPattern = "##,##,###";

