<?php
/** Hebrew (עברית)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Agbad
 * @author Amire80
 * @author Drorsnir
 * @author Ijon
 * @author Ofekalef
 * @author Ofrahod
 * @author Rotem Dan (July 2003)
 * @author Rotem Liss (March 2006 on)
 * @author Rotemliss
 * @author YaronSh
 * @author ערן
 * @author שומבלע
 * @author תומר ט
 */

$rtl = true;

$linkTrail = '/^([a-zא-ת]+)(.*)$/sDu';
$fallback8bitEncoding = 'windows-1255';


$datePreferences = array(
	'default',
	'mdy',
	'dmy',
	'ymd',
	'hebrew',
	'ISO 8601',
);

$dateFormats = array(
	'mdy time' => 'H:i',
	'mdy date' => 'xg j, Y',
	'mdy both' => 'H:i, xg j, Y',

	'dmy time' => 'H:i',
	'dmy date' => 'j xg Y',
	'dmy both' => 'H:i, j xg Y',

	'ymd time' => 'H:i',
	'ymd date' => 'Y xg j',
	'ymd both' => 'H:i, Y xg j',

	'hebrew time' => 'H:i',
	'hebrew date' => 'xhxjj xjx xhxjY',
	'hebrew both' => 'H:i, xhxjj xjx xhxjY',

	'ISO 8601 time' => 'xnH:xni:xns',
	'ISO 8601 date' => 'xnY-xnm-xnd',
	'ISO 8601 both' => 'xnY-xnm-xnd"T"xnH:xni:xns',
);

$bookstoreList = array(
	'מיתוס'          => 'http://www.mitos.co.il/',
	'iBooks'         => 'http://www.ibooks.co.il/',
	'Barnes & Noble' => 'http://search.barnesandnoble.com/bookSearch/isbnInquiry.asp?isbn=$1',
	'Amazon.com'     => 'http://www.amazon.com/exec/obidos/ISBN=$1'
);

$magicWords = array(
	'redirect'                => array( '0', '#הפניה', '#REDIRECT' ),
	'notoc'                   => array( '0', '__ללא_תוכן_עניינים__', '__ללא_תוכן__', '__NOTOC__' ),
	'nogallery'               => array( '0', '__ללא_גלריה__', '__NOGALLERY__' ),
	'forcetoc'                => array( '0', '__חייב_תוכן_עניינים__', '__חייב_תוכן__', '__FORCETOC__' ),
	'toc'                     => array( '0', '__תוכן_עניינים__', '__תוכן__', '__TOC__' ),
	'noeditsection'           => array( '0', '__ללא_עריכה__', '__NOEDITSECTION__' ),
	'noheader'                => array( '0', '__ללא_כותרת__', '__NOHEADER__' ),
	'currentmonth'            => array( '1', 'חודש נוכחי', 'חודש נוכחי 2', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonth1'           => array( '1', 'חודש נוכחי 1', 'CURRENTMONTH1' ),
	'currentmonthname'        => array( '1', 'שם חודש נוכחי', 'CURRENTMONTHNAME' ),
	'currentmonthnamegen'     => array( '1', 'שם חודש נוכחי קניין', 'CURRENTMONTHNAMEGEN' ),
	'currentmonthabbrev'      => array( '1', 'קיצור חודש נוכחי', 'CURRENTMONTHABBREV' ),
	'currentday'              => array( '1', 'יום נוכחי', 'CURRENTDAY' ),
	'currentday2'             => array( '1', 'יום נוכחי 2', 'CURRENTDAY2' ),
	'currentdayname'          => array( '1', 'שם יום נוכחי', 'CURRENTDAYNAME' ),
	'currentyear'             => array( '1', 'שנה נוכחית', 'CURRENTYEAR' ),
	'currenttime'             => array( '1', 'שעה נוכחית', 'CURRENTTIME' ),
	'currenthour'             => array( '1', 'שעות נוכחיות', 'CURRENTHOUR' ),
	'localmonth'              => array( '1', 'חודש מקומי', 'חודש מקומי 2', 'LOCALMONTH', 'LOCALMONTH2' ),
	'localmonth1'             => array( '1', 'חודש מקומי 1', 'LOCALMONTH1' ),
	'localmonthname'          => array( '1', 'שם חודש מקומי', 'LOCALMONTHNAME' ),
	'localmonthnamegen'       => array( '1', 'שם חודש מקומי קניין', 'LOCALMONTHNAMEGEN' ),
	'localmonthabbrev'        => array( '1', 'קיצור חודש מקומי', 'LOCALMONTHABBREV' ),
	'localday'                => array( '1', 'יום מקומי', 'LOCALDAY' ),
	'localday2'               => array( '1', 'יום מקומי 2', 'LOCALDAY2' ),
	'localdayname'            => array( '1', 'שם יום מקומי', 'LOCALDAYNAME' ),
	'localyear'               => array( '1', 'שנה מקומית', 'LOCALYEAR' ),
	'localtime'               => array( '1', 'שעה מקומית', 'LOCALTIME' ),
	'localhour'               => array( '1', 'שעות מקומיות', 'LOCALHOUR' ),
	'numberofpages'           => array( '1', 'מספר דפים כולל', 'מספר דפים', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', 'מספר ערכים', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'מספר קבצים', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', 'מספר משתמשים', 'NUMBEROFUSERS' ),
	'numberofactiveusers'     => array( '1', 'מספר משתמשים פעילים', 'NUMBEROFACTIVEUSERS' ),
	'numberofedits'           => array( '1', 'מספר עריכות', 'NUMBEROFEDITS' ),
	'numberofviews'           => array( '1', 'מספר צפיות', 'NUMBEROFVIEWS' ),
	'pagename'                => array( '1', 'שם הדף', 'PAGENAME' ),
	'pagenamee'               => array( '1', 'שם הדף מקודד', 'PAGENAMEE' ),
	'namespace'               => array( '1', 'מרחב השם', 'NAMESPACE' ),
	'namespacee'              => array( '1', 'מרחב השם מקודד', 'NAMESPACEE' ),
	'talkspace'               => array( '1', 'מרחב השיחה', 'TALKSPACE' ),
	'talkspacee'              => array( '1', 'מרחב השיחה מקודד', 'TALKSPACEE' ),
	'subjectspace'            => array( '1', 'מרחב הנושא', 'מרחב הערכים', 'SUBJECTSPACE', 'ARTICLESPACE' ),
	'subjectspacee'           => array( '1', 'מרחב הנושא מקודד', 'מרחב הערכים מקודד', 'SUBJECTSPACEE', 'ARTICLESPACEE' ),
	'fullpagename'            => array( '1', 'שם הדף המלא', 'FULLPAGENAME' ),
	'fullpagenamee'           => array( '1', 'שם הדף המלא מקודד', 'FULLPAGENAMEE' ),
	'subpagename'             => array( '1', 'שם דף המשנה', 'SUBPAGENAME' ),
	'subpagenamee'            => array( '1', 'שם דף המשנה מקודד', 'SUBPAGENAMEE' ),
	'basepagename'            => array( '1', 'שם דף הבסיס', 'BASEPAGENAME' ),
	'basepagenamee'           => array( '1', 'שם דף הבסיס מקודד', 'BASEPAGENAMEE' ),
	'talkpagename'            => array( '1', 'שם דף השיחה', 'TALKPAGENAME' ),
	'talkpagenamee'           => array( '1', 'שם דף השיחה מקודד', 'TALKPAGENAMEE' ),
	'subjectpagename'         => array( '1', 'שם דף הנושא', 'שם הערך', 'SUBJECTPAGENAME', 'ARTICLEPAGENAME' ),
	'subjectpagenamee'        => array( '1', 'שם דף הנושא מקודד', 'שם הערך מקודד', 'SUBJECTPAGENAMEE', 'ARTICLEPAGENAMEE' ),
	'msg'                     => array( '0', 'הכללה:', 'MSG:' ),
	'subst'                   => array( '0', 'ס:', 'SUBST:' ),
	'safesubst'               => array( '0', 'ס בטוח:', 'SAFESUBST:' ),
	'msgnw'                   => array( '0', 'הכללת מקור', 'MSGNW:' ),
	'img_thumbnail'           => array( '1', 'ממוזער', 'thumbnail', 'thumb' ),
	'img_manualthumb'         => array( '1', 'ממוזער=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'               => array( '1', 'ימין', 'right' ),
	'img_left'                => array( '1', 'שמאל', 'left' ),
	'img_none'                => array( '1', 'ללא', 'none' ),
	'img_width'               => array( '1', '$1 פיקסלים', '$1px' ),
	'img_center'              => array( '1', 'מרכז', 'center', 'centre' ),
	'img_framed'              => array( '1', 'ממוסגר', 'מסגרת', 'framed', 'enframed', 'frame' ),
	'img_frameless'           => array( '1', 'לא ממוסגר', 'ללא מסגרת', 'frameless' ),
	'img_page'                => array( '1', 'דף=$1', 'דף $1', 'page=$1', 'page $1' ),
	'img_upright'             => array( '1', 'ימין למעלה', 'ימין למעלה=$1', 'ימין למעלה $1', 'upright', 'upright=$1', 'upright $1' ),
	'img_border'              => array( '1', 'גבולות', 'גבול', 'border' ),
	'img_baseline'            => array( '1', 'שורת הבסיס', 'baseline' ),
	'img_sub'                 => array( '1', 'תחתי', 'sub' ),
	'img_super'               => array( '1', 'עילי', 'super', 'sup' ),
	'img_top'                 => array( '1', 'למעלה', 'top' ),
	'img_text_top'            => array( '1', 'בראש הטקסט', 'text-top' ),
	'img_middle'              => array( '1', 'באמצע', 'middle' ),
	'img_bottom'              => array( '1', 'למטה', 'bottom' ),
	'img_text_bottom'         => array( '1', 'בתחתית הטקסט', 'text-bottom' ),
	'img_link'                => array( '1', 'קישור=$1', 'link=$1' ),
	'img_alt'                 => array( '1', 'טקסט=$1', 'alt=$1' ),
	'int'                     => array( '0', 'הודעה:', 'INT:' ),
	'sitename'                => array( '1', 'שם האתר', 'SITENAME' ),
	'ns'                      => array( '0', 'מרחב שם:', 'NS:' ),
	'nse'                     => array( '0', 'מרחב שם מקודד:', 'NSE:' ),
	'localurl'                => array( '0', 'כתובת יחסית:', 'LOCALURL:' ),
	'localurle'               => array( '0', 'כתובת יחסית מקודד:', 'LOCALURLE:' ),
	'articlepath'             => array( '0', 'נתיב הדפים', 'ARTICLEPATH' ),
	'server'                  => array( '0', 'כתובת השרת', 'שרת', 'SERVER' ),
	'servername'              => array( '0', 'שם השרת', 'SERVERNAME' ),
	'scriptpath'              => array( '0', 'נתיב הקבצים', 'SCRIPTPATH' ),
	'stylepath'               => array( '0', 'נתיב הסגנון', 'STYLEPATH' ),
	'grammar'                 => array( '0', 'דקדוק:', 'GRAMMAR:' ),
	'gender'                  => array( '0', 'מגדר:', 'GENDER:' ),
	'notitleconvert'          => array( '0', '__ללא_המרת_כותרת__', '__NOTITLECONVERT__', '__NOTC__' ),
	'nocontentconvert'        => array( '0', '__ללא_המרת_תוכן__', '__NOCONTENTCONVERT__', '__NOCC__' ),
	'currentweek'             => array( '1', 'שבוע נוכחי', 'CURRENTWEEK' ),
	'currentdow'              => array( '1', 'מספר יום נוכחי', 'CURRENTDOW' ),
	'localweek'               => array( '1', 'שבוע מקומי', 'LOCALWEEK' ),
	'localdow'                => array( '1', 'מספר יום מקומי', 'LOCALDOW' ),
	'revisionid'              => array( '1', 'מזהה גרסה', 'REVISIONID' ),
	'revisionday'             => array( '1', 'יום גרסה', 'REVISIONDAY' ),
	'revisionday2'            => array( '1', 'יום גרסה 2', 'REVISIONDAY2' ),
	'revisionmonth'           => array( '1', 'חודש גרסה', 'REVISIONMONTH' ),
	'revisionmonth1'          => array( '1', 'חודש גרסה 1', 'REVISIONMONTH1' ),
	'revisionyear'            => array( '1', 'שנת גרסה', 'REVISIONYEAR' ),
	'revisiontimestamp'       => array( '1', 'זמן גרסה', 'REVISIONTIMESTAMP' ),
	'revisionuser'            => array( '1', 'כותב גרסה', 'REVISIONUSER' ),
	'plural'                  => array( '0', 'רבים:', 'PLURAL:' ),
	'fullurl'                 => array( '0', 'כתובת מלאה:', 'FULLURL:' ),
	'fullurle'                => array( '0', 'כתובת מלאה מקודד:', 'FULLURLE:' ),
	'canonicalurl'            => array( '0', 'כתובת קנונית:', 'CANONICALURL:' ),
	'canonicalurle'           => array( '0', 'כתובת קנונית מקודד:', 'CANONICALURLE:' ),
	'lcfirst'                 => array( '0', 'אות ראשונה קטנה:', 'LCFIRST:' ),
	'ucfirst'                 => array( '0', 'אות ראשונה גדולה:', 'UCFIRST:' ),
	'lc'                      => array( '0', 'אותיות קטנות:', 'LC:' ),
	'uc'                      => array( '0', 'אותיות גדולות:', 'UC:' ),
	'raw'                     => array( '0', 'ללא עיבוד:', 'RAW:' ),
	'displaytitle'            => array( '1', 'כותרת תצוגה', 'DISPLAYTITLE' ),
	'rawsuffix'               => array( '1', 'ללא פסיק', 'R' ),
	'newsectionlink'          => array( '1', '__יצירת_הערה__', '__NEWSECTIONLINK__' ),
	'nonewsectionlink'        => array( '1', '__ללא_יצירת_הערה__', '__NONEWSECTIONLINK__' ),
	'currentversion'          => array( '1', 'גרסה נוכחית', 'CURRENTVERSION' ),
	'urlencode'               => array( '0', 'נתיב מקודד:', 'URLENCODE:' ),
	'anchorencode'            => array( '0', 'עוגן מקודד:', 'ANCHORENCODE' ),
	'currenttimestamp'        => array( '1', 'זמן נוכחי', 'CURRENTTIMESTAMP' ),
	'localtimestamp'          => array( '1', 'זמן מקומי', 'LOCALTIMESTAMP' ),
	'directionmark'           => array( '1', 'סימן כיווניות', 'DIRECTIONMARK', 'DIRMARK' ),
	'language'                => array( '0', '#שפה:', '#LANGUAGE:' ),
	'contentlanguage'         => array( '1', 'שפת תוכן', 'CONTENTLANGUAGE', 'CONTENTLANG' ),
	'pagesinnamespace'        => array( '1', 'דפים במרחב השם:', 'PAGESINNAMESPACE:', 'PAGESINNS:' ),
	'numberofadmins'          => array( '1', 'מספר מפעילים', 'NUMBEROFADMINS' ),
	'formatnum'               => array( '0', 'עיצוב מספר', 'FORMATNUM' ),
	'padleft'                 => array( '0', 'ריפוד משמאל', 'PADLEFT' ),
	'padright'                => array( '0', 'ריפוד מימין', 'PADRIGHT' ),
	'special'                 => array( '0', 'מיוחד', 'special' ),
	'defaultsort'             => array( '1', 'מיון רגיל:', 'DEFAULTSORT:', 'DEFAULTSORTKEY:', 'DEFAULTCATEGORYSORT:' ),
	'filepath'                => array( '0', 'נתיב לקובץ:', 'FILEPATH:' ),
	'tag'                     => array( '0', 'תגית', 'tag' ),
	'hiddencat'               => array( '1', '__קטגוריה_מוסתרת__', '__HIDDENCAT__' ),
	'pagesincategory'         => array( '1', 'דפים בקטגוריה', 'PAGESINCATEGORY', 'PAGESINCAT' ),
	'pagesize'                => array( '1', 'גודל דף', 'PAGESIZE' ),
	'index'                   => array( '1', '__לחיפוש__', '__INDEX__' ),
	'noindex'                 => array( '1', '__לא_לחיפוש__', '__NOINDEX__' ),
	'numberingroup'           => array( '1', 'מספר בקבוצה', 'NUMBERINGROUP', 'NUMINGROUP' ),
	'staticredirect'          => array( '1', '__הפניה_קבועה__', '__STATICREDIRECT__' ),
	'protectionlevel'         => array( '1', 'רמת הגנה', 'PROTECTIONLEVEL' ),
	'formatdate'              => array( '0', 'עיצוב תאריך', 'formatdate', 'dateformat' ),
	'url_path'                => array( '0', 'נתיב', 'PATH' ),
	'url_wiki'                => array( '0', 'ויקי', 'WIKI' ),
	'url_query'               => array( '0', 'שאילתה', 'QUERY' ),
	'defaultsort_noerror'     => array( '0', 'ללא שגיאה', 'noerror' ),
	'defaultsort_noreplace'   => array( '0', 'ללא החלפה', 'noreplace' ),
);

$specialPageAliases = array(
	'Activeusers'               => array( 'משתמשים_פעילים' ),
	'Allmessages'               => array( 'הודעות_המערכת' ),
	'Allpages'                  => array( 'כל_הדפים' ),
	'Ancientpages'              => array( 'דפים_מוזנחים' ),
	'Badtitle'                  => array( 'כותרת_שגויה' ),
	'Blankpage'                 => array( 'דף_ריק' ),
	'Block'                     => array( 'חסימה', 'חסימת_כתובת', 'חסימת_משתמש' ),
	'Blockme'                   => array( 'חסום_אותי' ),
	'Booksources'               => array( 'משאבי_ספרות', 'משאבי_ספרות_חיצוניים' ),
	'BrokenRedirects'           => array( 'הפניות_לא_תקינות', 'הפניות_שבורות' ),
	'Categories'                => array( 'קטגוריות', 'רשימת_קטגוריות' ),
	'ChangeEmail'               => array( 'שינוי_דואר_אלקטרוני', 'שינוי_דואל' ),
	'ChangePassword'            => array( 'שינוי_סיסמה' ),
	'ComparePages'              => array( 'השוואת_דפים' ),
	'Confirmemail'              => array( 'אימות_כתובת_דואר' ),
	'Contributions'             => array( 'תרומות', 'תרומות_המשתמש' ),
	'CreateAccount'             => array( 'הרשמה_לחשבון' ),
	'Deadendpages'              => array( 'דפים_ללא_קישורים' ),
	'DeletedContributions'      => array( 'תרומות_מחוקות' ),
	'Disambiguations'           => array( 'פירושונים', 'דפי_פירושונים' ),
	'DoubleRedirects'           => array( 'הפניות_כפולות' ),
	'EditWatchlist'             => array( 'עריכת_רשימת_המעקב' ),
	'Emailuser'                 => array( 'שליחת_דואר_למשתמש' ),
	'Export'                    => array( 'ייצוא', 'ייצוא_דפים' ),
	'Fewestrevisions'           => array( 'הגרסאות_המעטות_ביותר', 'הדפים_בעלי_מספר_העריכות_הנמוך_ביותר' ),
	'FileDuplicateSearch'       => array( 'חיפוש_קבצים_כפולים' ),
	'Filepath'                  => array( 'נתיב_לקובץ' ),
	'Import'                    => array( 'ייבוא', 'ייבוא_דפים' ),
	'Invalidateemail'           => array( 'ביטול_דואר' ),
	'JavaScriptTest'            => array( 'בדיקת_JavaScript' ),
	'BlockList'                 => array( 'רשימת_חסומים', 'רשימת_משתמשים_חסומים', 'משתמשים_חסומים' ),
	'LinkSearch'                => array( 'חיפוש_קישורים_חיצוניים' ),
	'Listadmins'                => array( 'רשימת_מפעילים' ),
	'Listbots'                  => array( 'רשימת_בוטים' ),
	'Listfiles'                 => array( 'רשימת_קבצים', 'רשימת_תמונות', 'קבצים', 'תמונות' ),
	'Listgrouprights'           => array( 'רשימת_הרשאות_לקבוצה' ),
	'Listredirects'             => array( 'רשימת_הפניות', 'הפניות' ),
	'Listusers'                 => array( 'רשימת_משתמשים', 'משתמשים' ),
	'Lockdb'                    => array( 'נעילת_בסיס_הנתונים' ),
	'Log'                       => array( 'יומנים' ),
	'Lonelypages'               => array( 'דפים_יתומים' ),
	'Longpages'                 => array( 'דפים_ארוכים' ),
	'MergeHistory'              => array( 'מיזוג_גרסאות' ),
	'MIMEsearch'                => array( 'חיפוש_MIME' ),
	'Mostcategories'            => array( 'הקטגוריות_הרבות_ביותר', 'הדפים_מרובי-הקטגוריות_ביותר' ),
	'Mostimages'                => array( 'הקבצים_המקושרים_ביותר', 'התמונות_המקושרות_ביותר' ),
	'Mostlinked'                => array( 'הדפים_המקושרים_ביותר', 'המקושרים_ביותר' ),
	'Mostlinkedcategories'      => array( 'הקטגוריות_המקושרות_ביותר' ),
	'Mostlinkedtemplates'       => array( 'התבניות_המקושרות_ביותר' ),
	'Mostrevisions'             => array( 'הגרסאות_הרבות_ביותר', 'הדפים_בעלי_מספר_העריכות_הגבוה_ביותר' ),
	'Movepage'                  => array( 'העברת_דף', 'העברה' ),
	'Mycontributions'           => array( 'התרומות_שלי' ),
	'Mypage'                    => array( 'הדף_שלי', 'דף_המשתמש_שלי' ),
	'Mytalk'                    => array( 'השיחה_שלי', 'דף_השיחה_שלי' ),
	'Myuploads'                 => array( 'ההעלאות_שלי' ),
	'Newimages'                 => array( 'קבצים_חדשים', 'תמונות_חדשות', 'גלריית_קבצים_חדשים', 'גלריית_תמונות_חדשות' ),
	'Newpages'                  => array( 'דפים_חדשים' ),
	'PasswordReset'             => array( 'איפוס_סיסמה' ),
	'PermanentLink'             => array( 'קישור_קבוע' ),
	'Popularpages'              => array( 'הדפים_הנצפים_ביותר', 'דפים_פופולריים' ),
	'Preferences'               => array( 'העדפות', 'ההעדפות_שלי' ),
	'Prefixindex'               => array( 'דפים_המתחילים_ב' ),
	'Protectedpages'            => array( 'דפים_מוגנים' ),
	'Protectedtitles'           => array( 'כותרות_מוגנות' ),
	'Randompage'                => array( 'אקראי', 'דף_אקראי' ),
	'Randomredirect'            => array( 'הפניה_אקראית' ),
	'Recentchanges'             => array( 'שינויים_אחרונים' ),
	'Recentchangeslinked'       => array( 'שינויים_בדפים_המקושרים' ),
	'Revisiondelete'            => array( 'מחיקת_ושחזור_גרסאות' ),
	'RevisionMove'              => array( 'העברת_גרסאות' ),
	'Search'                    => array( 'חיפוש' ),
	'Shortpages'                => array( 'דפים_קצרים' ),
	'Specialpages'              => array( 'דפים_מיוחדים' ),
	'Statistics'                => array( 'סטטיסטיקות' ),
	'Tags'                      => array( 'תגיות' ),
	'Unblock'                   => array( 'שחרור_חסימה' ),
	'Uncategorizedcategories'   => array( 'קטגוריות_חסרות_קטגוריה' ),
	'Uncategorizedimages'       => array( 'קבצים_חסרי_קטגוריה', 'תמונות_חסרות_קטגוריה' ),
	'Uncategorizedpages'        => array( 'דפים_חסרי_קטגוריה' ),
	'Uncategorizedtemplates'    => array( 'תבניות_חסרות_קטגוריות' ),
	'Undelete'                  => array( 'צפייה_בדפים_מחוקים' ),
	'Unlockdb'                  => array( 'שחרור_בסיס_הנתונים' ),
	'Unusedcategories'          => array( 'קטגוריות_שאינן_בשימוש' ),
	'Unusedimages'              => array( 'קבצים_שאינם_בשימוש', 'תמונות_שאינן_בשימוש' ),
	'Unusedtemplates'           => array( 'תבניות_שאינן_בשימוש' ),
	'Unwatchedpages'            => array( 'דפים_שאינם_במעקב' ),
	'Upload'                    => array( 'העלאה', 'העלאת_קובץ_לשרת' ),
	'UploadStash'               => array( 'מאגר_העלאות' ),
	'Userlogin'                 => array( 'כניסה_לחשבון', 'כניסה', 'כניסה_/_הרשמה_לחשבון' ),
	'Userlogout'                => array( 'יציאה_מהחשבון', 'יציאה' ),
	'Userrights'                => array( 'ניהול_הרשאות_משתמש', 'הפיכת_משתמש_למפעיל_מערכת', 'הענקת_או_ביטול_הרשאת_בוט' ),
	'Version'                   => array( 'גרסה', 'גרסת_התוכנה' ),
	'Wantedcategories'          => array( 'קטגוריות_מבוקשות' ),
	'Wantedfiles'               => array( 'קבצים_מבוקשים' ),
	'Wantedpages'               => array( 'דפים_מבוקשים' ),
	'Wantedtemplates'           => array( 'תבניות_מבוקשות' ),
	'Watchlist'                 => array( 'רשימת_המעקב', 'רשימת_מעקב', 'רשימת_המעקב_שלי' ),
	'Whatlinkshere'             => array( 'דפים_המקושרים_לכאן' ),
	'Withoutinterwiki'          => array( 'דפים_ללא_קישורי_שפה' ),
);

$namespaceNames = array(
	NS_MEDIA            => 'מדיה',
	NS_SPECIAL          => 'מיוחד',
	NS_MAIN             => '',
	NS_TALK             => 'שיחה',
	NS_USER             => 'משתמש',
	NS_USER_TALK        => 'שיחת_משתמש',
	NS_PROJECT_TALK     => 'שיחת_$1',
	NS_FILE             => 'קובץ',
	NS_FILE_TALK        => 'שיחת_קובץ',
	NS_MEDIAWIKI        => 'מדיה_ויקי',
	NS_MEDIAWIKI_TALK   => 'שיחת_מדיה_ויקי',
	NS_TEMPLATE         => 'תבנית',
	NS_TEMPLATE_TALK    => 'שיחת_תבנית',
	NS_HELP             => 'עזרה',
	NS_HELP_TALK        => 'שיחת_עזרה',
	NS_CATEGORY         => 'קטגוריה',
	NS_CATEGORY_TALK    => 'שיחת_קטגוריה',
);
$namespaceAliases = array(
	'תמונה'      => NS_FILE,
	'שיחת_תמונה' => NS_FILE_TALK,
);
$namespaceGenderAliases = array(
	NS_USER      => array( 'male' => 'משתמש', 'female' => 'משתמשת' ),
	NS_USER_TALK => array( 'male' => 'שיחת_משתמש', 'female' => 'שיחת_משתמשת' ),
);

