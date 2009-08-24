<?php
/**
 * Internationalization file for DynamicPageList2 extension.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author m:User:Dangerman <cyril.dangerville@gmail.com>
 * @version 1.0.5
 * @version 1.0.8
 * 			removed blank lines at the end of the file
 * @version 1.0.9
 * 			added message: ERR_OpenReferences
*/

class DPL2_i18n
{
    // FATAL
    const FATAL_WRONGNS                  = 1;
    const FATAL_WRONGLINKSTO             = 2;
    const FATAL_TOOMANYCATS              = 3;
    const FATAL_TOOFEWCATS               = 4;
    const FATAL_NOSELECTION              = 5;
    const FATAL_CATDATEBUTNOINCLUDEDCATS = 6;
    const FATAL_CATDATEBUTMORETHAN1CAT   = 7;
    const FATAL_MORETHAN1TYPEOFDATE      = 8;
    const FATAL_WRONGORDERMETHOD         = 9;
    const FATAL_DOMINANTSECTIONRANGE     = 10;
    const FATAL_NOCLVIEW                 = 11;
    const FATAL_OPENREFERENCES           = 12;

    // ERROR

    // WARN
    const WARN_UNKNOWNPARAM                = 13;
    const WARN_WRONGPARAM                  = 14;
    const WARN_WRONGPARAM_INT              = 15;
    const WARN_NORESULTS                   = 16;
    const WARN_CATOUTPUTBUTWRONGPARAMS     = 17;
    const WARN_HEADINGBUTSIMPLEORDERMETHOD = 18;
    const WARN_DEBUGPARAMNOTFIRST          = 19;
    const WARN_TRANSCLUSIONLOOP            = 20;

    // INFO

    // DEBUG
    const DEBUG_QUERY = 21;

    // TRACE

    private static $messages = array();

    public static function getMessages()
    {
        /**
         * To translate messages into your language, create a self::$messages['lang'] array where 'lang' is your language code and take self::$messages['en'] as a model. Replace values with appropriate translations.
         */

         self::$messages['en'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "ERROR: Wrong '$0' parameter: '$1'! Help:  <code>$0= <i>empty string</i> (Main)$3</code>.",
            /**
             * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
             * $1: wrong parameter given by user
             */
            'dpl2_log_' . self::FATAL_WRONGLINKSTO => "ERROR: Wrong '$0' parameter: '$1'! Help:  <code>$0= <i>full pagename</i></code>.",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => 'ERROR: Too many categories! Maximum: $0. Help: increase <code>ExtDynamicPageList2::$maxCategoryCount</code> to specify more categories or set <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> for no limitation. (Set the variable in <code>LocalSettings.php</code>, after including <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => 'ERROR: Too few categories! Minimum: $0. Help: decrease <code>ExtDynamicPageList2::$minCategoryCount</code> to specify fewer categories. (Set the variable preferably in <code>LocalSettings.php</code>, after including <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "ERROR: You need to include at least one category if you want to use 'addfirstcategorydate=true' or 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "ERROR: If you include more than one category, you cannot use 'addfirstcategorydate=true' or 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'ERROR: You cannot add more than one type of date at a time!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "ERROR: You can use '$0' with 'ordermethod=[...,]$1' only!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW => "ERROR: Cannot perform logical operations on the Uncategorized pages (f.e. with the 'category' parameter) because the $0 view does not exist on the database! Help: have the database administrator execute this query: <code>$1</code>.",
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "WARNING: Unknown parameter '$0' is ignored. Help: available parameters: <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "WARNING: Wrong '$0' parameter: '$1'! Using default: '$2'. Help: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "WARNING: Wrong '$0' parameter: '$1'! Using default: '$2' (no limit). Help: <code>$0= <i>empty string</i> (no limit) | n</code>, with <code>n</code> a positive integer.",
            'dpl2_log_' . self::WARN_NORESULTS => 'WARNING: No results!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "WARNING: Add* parameters ('adduser', 'addeditdate', etc.)' and 'includepage' have no effect with 'mode=category'. Only the page namespace/title can be viewed in this mode.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "WARNING: 'headingmode=$0' has no effect with 'ordermethod' on a single component. Using: '$1'. Help: you can use not-$1 'headingmode' values with 'ordermethod' on multiple components. The first component is used for headings. E.g. 'ordermethod=category,<i>comp</i>' (<i>comp</i> is another component) for category headings.",
            /**
             * $0: 'log' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "WARNING: 'debug=$0' is not in first position in the DPL element. The new debug settings are not applied before all previous parameters have been parsed and checked.",
            /**
             * $0: title of page that creates an infinite transclusion loop
             */
            'dpl2_log_' . self::WARN_TRANSCLUSIONLOOP => "WARNING: An infinite transclusion loop is created by page '$0'.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'QUERY: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'There {{PLURAL:$1|is one article|are $1 articles}} in this heading.'
        );
        self::$messages['fr'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "ERREUR : Mauvais paramètre '$0' : '$1'! Aide :  <code>$0= <i>chaîne vide</i> (Principal)$3</code>. (Les équivalents avec des mots magiques sont aussi autorisés.)",
            /**
             * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
             * $1: wrong parameter given by user
             */
            'dpl2_log_' . self::FATAL_WRONGLINKSTO => "ERREUR : Mauvais paramètre '$0' : '$1'! Aide :  <code>$0= <i>Nom complet de la page</i></code>. (Les mots magiques sont autorisés.)",
            /**
             * $0: max number of categories that can be included
             */
	    'dpl2_log_' . self::FATAL_TOOMANYCATS => 'ERREUR : Trop de catégories ! Maximum : $0. Aide : accroître <code>ExtDynamicPageList2::$maxCategoryCount</code> pour autoriser plus de catégories ou régler <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> pour aucune limite. (À régler dans <code>LocalSettings.php</code>, après avoir inclus <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
	    'dpl2_log_' . self::FATAL_TOOFEWCATS => 'ERREUR : Pas assez de catégories ! Minimum : $0. Aide : décroître <code>ExtDynamicPageList2::$minCategoryCount</code> pour autoriser moins de catégories. (À régler dans <code>LocalSettings.php</code> de préférence, après avoir inclus <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "ERREUR : Vous devez inclure au moins une catégorie si vous voulez utiliser 'addfirstcategorydate=true' ou 'ordermethod=categoryadd' !",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "ERREUR : Si vous incluez plus d’une catégorie, vous ne pouvez pas utiliser 'addfirstcategorydate=true' ou 'ordermethod=categoryadd' !",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'ERREUR : Vous ne pouvez pas utiliser plus d’un type de date à la fois !',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "ERREUR : Vous ne pouvez utiliser '$0' qu’avec 'ordermethod=[...,]$1' !",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW => "ERREUR : Ne peut pas effectuer d’opérations logiques sur les pages sans catégories (avec la paramètre 'category') car la vue $0 n’existe pas dans la base de données ! Aide : demander à un administrateur de la base de données d'effectuer : <code>$1</code>.",
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "AVERTISSEMENT : Le paramètre inconnu '$0' est ignoré. Aide : paramètres disponibles : <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "AVERTISSEMENT : Mauvais paramètre '$0' : '$1'! Utilisation de la valeur par défaut : '$2'. Aide : <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "AVERTISSEMENT : Mauvais paramètre '$0' : '$1'! Utilisattion de la valeur par défaut : '$2' (aucune limite). Aide : <code>$0= <i>chaîne vide</i> (aucune limite) | n</code>, avec <code>n</code> un entier positif.",
            'dpl2_log_' . self::WARN_NORESULTS => 'AVERTISSEMENT : Aucun résultat !',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "AVERTISSEMENT : Les paramètres Add* ('adduser', 'addeditdate', etc.)' et 'includepage' n’ont aucun effet avec 'mode=category'. Seuls l’espace de nom et le titre de la page peuvent être vus dans ce mode..",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "AVERTISSEMENT : 'headingmode=$0' n'a aucun effet avec 'ordermethod' sur une simple composante. Utiliser : '$1'. Aide : vous pouvez utiliser not-$1  sur les valeurs de 'headingmode' avec 'ordermethod' sur plusieurs composantes.  La première composante est utilisée pour les en-têtes. Exemple : 'ordermethod=category,<i>comp</i>' (<i>comp</i> est une autre composante) pour les en-têtes de catégorie.",
            /**
             * $0: 'log' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "AVERTISSEMENT : 'debug=$0' n’est pas en première position dans l’élément DPL. Les nouveaux réglages de débogage ne seront appliqués qu’après que les paramètres précédents aient été vérifiés.",
            /**
             * $0: title of page that creates an infinite transclusion loop
             */
            'dpl2_log_' . self::WARN_TRANSCLUSIONLOOP => "AVERTISSEMENT : Une boucle d’inclusion infinie est créée par la page '$0'.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'REQUÊTE : <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'Il y a {{PLURAL:$1|un article|$1 articles}} dans cette section.'
        ); 
        self::$messages['he'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "שגיאה: פרמטר '$0' שגוי: '$1'! עזרה: <code>$0= <i>מחרוזת ריקה</i> (ראשי)$3</code>. (ניתן להשתמש גם בשווי ערך באמצעות מילות קסם.)",
            /**
             * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
             * $1: wrong parameter given by user
             */
            'dpl2_log_' . self::FATAL_WRONGLINKSTO => "שגיאה: פרמטר '$0' שגוי: '$1'! עזרה: <code>$0= <i>שם הדף המלא</i></code>. (ניתן להשתמש במילות קסם.)",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => 'שגיאה: קטגוריות רבות מדי! מקסימום: $0. עזרה: העלו את <code>ExtDynamicPageList2::$maxCategoryCount</code> כדי לציין עוד קטגוריות או הגדירו <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> כדי לבטל את ההגבלה. (הגידרו את המשתנה בקובץ <code>LocalSettings.php</code>, לאחר הכללת <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => 'שגיאה: קטגוריות מעטות מדי! מינימום: $0. עזרה: הורידו את <code>ExtDynamicPageList2::$minCategoryCount</code> כדי לציין פחות קטגוריות. (הגידרו את המשתנה בקובץ <code>LocalSettings.php</code>, לאחר הכללת <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "שגיאה: עליכם להכליל לפחות קטגוריה אחת אם ברצונכם להשתמש ב־'addfirstcategorydate=true' או ב־'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "שגיאה: אם אתם מכלילים יותר מקטגוריה אחת, אינכם יכולים להשתמש ב־'addfirstcategorydate=true' או ב־'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'שגיאה: אינכם יכולים להוסיף יותר מסוג אחד של תאריך בו זמנית!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "?????: ????????? ?????? ??'$0' ?? 'ordermethod=[...,]$1' ????!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW => "שגיאה: לא ניתן לבצע פעולות לוגיות על דפים ללא קטגוריות (למשל, עם הפרמטר 'קטגוריה') כיוון שתצוגת $0 אינה קיימת במסד הנתונים! עזרה: מנהל מסד הנתונים צריך להריץ את השאילתה: <code>$1</code>.",
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "אזהרה: בוצעה התעלמות מהפרמטר הלא ידוע '$0'. עזרה: פרמטרים זמינים: <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "אזהרה: פרמטר '$0' שגוי: '$1'! משתמש בברירת המחדל: '$2'. עזרה: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "אזהרה: פרמטר '$0' שגוי: '$1'! משתמש בברירת המחדל: '$2' (ללא הגבלה). עזרה: <code>$0= <i>מחרוזת ריקה</i> (ללא הגבלה) | n</code>, עם <code>n</code> כמספר שלם וחיובי.",
            'dpl2_log_' . self::WARN_NORESULTS => '?????: ??? ??????!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "אזהרה: להוספת* הפרמטרים ('adduser',‏ 'addeditdate' וכדומה) וכן ל־'includepage' אין השפעה עם 'mode=category'. ניתן לצפות רק במרחב השם או בכותרת הדף במצב זה.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "אזהרה: ל־'headingmode=$0' אין השפעה עם 'ordermethod' על פריט יחיד. משתמש ב: '$1'. עזרה: באפשרותכם להשתמש בערכים של 'headingmode' שאינם $1 עם 'ordermethod' על פריטים מרובים. משתמשים בפריט הראשון לכותרת. למשל, 'ordermethod=category,<i>comp</i>' (<i>comp</i> הוא פריט אחר) לכותרות הקטגוריה.",
            /**
             * $0: 'debug' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "אזהרה: 'debug=$0w הוא לא במקום הראשון ברכיב ה־DPL. הגדרות ניפוי השגיאות החדשות לא יחולו לפני שכל הפרמטרים הקודמים ינותחו וייבדקו.",
            /**
             * $0: title of page that creates an infinite transclusion loop
             */
            'dpl2_log_' . self::WARN_TRANSCLUSIONLOOP => "אזהרה: לולאת הכללה אינסופית נוצרה בדף '$0'.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'שאילתה: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => '{{PLURAL:$1|ישנם $1 דפים|ישנו דף אחד}} תחת כותרת זו.'
        );
        self::$messages['id'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "KESALAHAN: Parameter '$0' salah: '$1'! Bantuan: <code>$0= <i>string kosong</i> (Utama)$3</code>. (Ekivalen kata kunci juga diizinkan.)",
            /**
             * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
             * $1: wrong parameter given by user
             */
            'dpl2_log_' . self::FATAL_WRONGLINKSTO => "KESALAHAN: Parameter '$0' salah: '$1'! Bantuan:  <code>$0= <i>nama lengkap halaman</i></code>. (Kata kunci diizinkan.)",
            /**
             * $0: max number of categories that can be included
             */
	    'dpl2_log_' . self::FATAL_TOOMANYCATS => 'KESALAHAN: Kategori terlalu banyak! Maksimum: $0. Bantuan: perbesar <code>ExtDynamicPageList2::$maxCategoryCount</code> untuk memberikan lebih banyak kategori atau atur  <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> untuk menghapus batasan. (Atur variabel tersebut di <code>LocalSettings.php</code>, setelah mencantumkan <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
	    'dpl2_log_' . self::FATAL_TOOFEWCATS => 'KESALAHAN: Kategori terlalu sedikit! Minimum: $0. Bantuan: kurangi <code>ExtDynamicPageList2::$minCategoryCount</code> untuk mengurangi kategori. (Atur variabel tersebut di <code>LocalSettings.php</code>, setelah mencantumkan <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "KESALAHAN: Anda harus memberikan paling tidak satu kategori jika menggunakan 'addfirstcategorydate=true' atau 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "KESALAHAN: Jika Anda memberikan lebih dari satu kategori, Anda tidak dapat menggunakan 'addfirstcategorydate=true' atau 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'KESALAHAN: Anda tidak dapat memberikan lebih dari satu jenis tanggal dalam satu waktu!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "KESALAHAN: Anda dapat menggunakan '$0' hanya dengan 'ordermethod=[...,]$1'!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW => "KESALAHAN: Tidak dapat melakukan operasi logika pada halaman yang tak terkategori (misalnya dengan parameter 'kategori') karena view $0 tidak ada di basis data! Bantuan: mintalah admin basis data untuk menjalankan kueri berikut: <code>$1</code>.",
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "KESALAHAN: Paramater yang tak dikenal '$0' diabaikan. Bantuan: parameter yang tersedia: <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "KESALAHAN: Parameter '$0' salah: '$1'! Menggunakan konfigurasi baku: '$2'. Bantuan: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "KESALAHAN: Parameter '$0' salah: '$1'! Menggunakan konfigurasi baku: '$2' (tanpa limitasi). Bantuan: <code>$0= <i>string kosong</i> (tanpa limitasi) | n</code>, dengan <code>n</code> suatu bilangan positif.",
            'dpl2_log_' . self::WARN_NORESULTS => 'KESALAHAN: Hasil tak ditemukan!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "KESALAHAN: Menambahkan * parameter ('adduser', 'addeditdate', dll.)' dan 'includepage' tidak berpengaruh pada 'mode=category'. Hanya ruang nama/judul halaman yang dapat ditampilkan dengan mode ini.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "KESALAHAN: 'headingmode=$0' tidak berpengaruh dengan 'ordermethod' pada suatu komponen tunggal. Menggunakan: '$1'. Bantuan: Anda dapat menggunakan nilai not-$1 'headingmode' dengan 'ordermethod' terhadap beberapa komponen. Komponen pertama digunakan sebagai judul. Misalnya 'ordermethod=category,<i>comp</i>' (<i>comp</i> adalah komponen lain) untuk judul kategori.",
            /**
             * $0: 'log' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "KESALAHAN: 'debug=$0' tidak pada posisi pertama pada elemen DPL. Aturan debug tidak diterapkan sebelum semua variabel sebelumnya telah diparsing dan dicek.",
            /**
             * $0: title of page that creates an infinite transclusion loop
             */
            'dpl2_log_' . self::WARN_TRANSCLUSIONLOOP => "KESALAHAN: Suatu lingkaran transklusi tak hingga ditimbulkan oleh halaman '$0'.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'KUERI: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'Terdapat {{PLURAL:$1|artikel|artikel}} dalam judul ini.'
        );
        self::$messages['it'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "ERRORE nel parametro '$0': '$1'. Suggerimento:  <code>$0= <i>stringa vuota</i> (Principale)$3</code>.",
            /**
             * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
             * $1: wrong parameter given by user
             */
            'dpl2_log_' . self::FATAL_WRONGLINKSTO => "ERRORE nel parametro '$0': '$1'. Suggerimento:  <code>$0= <i>nome completo della pagina</i></code>.",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => 'ERRORE: Categorie sovrabbondanti (massimo $0). Suggerimento: aumentare il valore di <code>ExtDynamicPageList2::$maxCategoryCount</code> per indicare un numero maggiore di categorie, oppure impostare <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> per non avere alcun limite. (Impostare le variabili nel file <code>LocalSettings.php</code>, dopo l\'inclusione di <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => 'ERRORE: Categorie insufficienti (minimo $0). Suggerimento: diminuire il valore di <code>ExtDynamicPageList2::$minCategoryCount</code> per indicare un numero minore di categorie. (Impostare la variabile nel file <code>LocalSettings.php</code>, dopo l\'inclusione di <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "ERRORE: L'uso dei parametri 'addfirstcategorydate=true' e 'ordermethod=categoryadd' richiede l'inserimento di una o più categorie.",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "ERRORE: L'inserimento di più categorie impedisce l'uso dei parametri 'addfirstcategorydate=true' e 'ordermethod=categoryadd'.",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'ERRORE: Non è consentito l\'uso contemporaneo di più tipi di data.',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "ERRORE: L'uso del parametro '$0' è consentito unicamente con 'ordermethod=[...,]$1'.",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW => "ERRORE: Impossibile effettuare operazioni logiche sulle pagine prive di categoria (ad es. con il parametro 'category') in quanto il database non contiene la vista $0. Suggerimento: chiedere all'amministratore del database di eseguire la seguente query: <code>$1</code>.",
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "ATTENZIONE: Il parametro non riconosciuto '$0' è stato ignorato. Suggerimento: i parametri disponibili sono: <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "ATTENZIONE: Errore nel parametro '$0': '$1'. È stato usato il valore predefinito '$2'. Suggerimento: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "ATTENZIONE: errore nel parametro '$0': '$1'. È stato usato il valore predefinito '$2' (nessun limite). Suggerimento: <code>$0= <i>stringa vuota</i> (nessun limite) | n</code>, con <code>n</code> intero positivo.",
            'dpl2_log_' . self::WARN_NORESULTS => 'ATTENZIONE: Nessun risultato.',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "ATTENZIONE: I parametri add* ('adduser', 'addeditdate', ecc.)' non hanno alcun effetto quando è specificato 'mode=category'. In tale modalità vengono visualizzati unicamente il namespace e il titolo della pagina.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "ATTENZIONE: Il parametro 'headingmode=$0' non ha alcun effetto quando è specificato 'ordermethod' su un solo componente. Verrà utilizzato il valore '$1'. Suggerimento: è posibile utilizzare i valori diversi da $1 per il parametro 'headingmode' nel caso di 'ordermethod' su più componenti. Il primo componente viene usato per generare i titoli di sezione. Ad es. 'ordermethod=category,<i>comp</i>' (dove <i>comp</i> è un altro componente) per avere titoli di sezione basati sulla categoria.",
            /**
             * $0: 'debug' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "ATTENZIONE: Il parametro 'debug=$0' non è il primo elemento della sezione DPL. Le nuove impostazioni di debug non verranno applicate prima di aver completato il parsing e la verifica di tutti i parametri che lo precedono.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'QUERY: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'Questa sezione contiene {{PLURAL:$1|una voce|$1 voci}}.'
        );
        self::$messages['nl'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "FOUT: Verkeerde parameter '$0': '$1'! Hulp:  <code>$0= <i>lege string</i> (Main)$3</code>.",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => 'FOUT: Te veel categoriën! Maximum: $0. Hulp: verhoog <code>ExtDynamicPageList2::$maxCategoryCount</code> om meer categorieën op te kunnen geven of stel geen limiet in met <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code>. (Neem deze variabele op in <code>LocalSettings.php</code>, na het toevoegen van <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => 'FOUT: Te weinig categorieën! Minimum: $0. Hulp: verlaag <code>ExtDynamicPageList2::$minCategoryCount</code> om minder categorieën aan te hoeven geven. (Stel de variabele bij voorkeur in via <code>LocalSettings.php</code>, na het toevoegen van <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "FOUT: U dient tenminste één categorie op te nemen als u 'addfirstcategorydate=true' of 'ordermethod=categoryadd' wilt gebruiken!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "FOUT: Als u meer dan één categorie opneemt, kunt u 'addfirstcategorydate=true' of 'ordermethod=categoryadd' niet gebruiken!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'FOUT: U kunt niet meer dan één type of datum tegelijk gebruiken!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "FOUT: U kunt '$0' alleen met 'ordermethod=[...,]$1' gebruiken!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW =>          self::$messages['en']['dpl2_log_' . self::FATAL_NOCLVIEW],
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM =>          self::$messages['en']['dpl2_log_' . self::WARN_UNKNOWNPARAM],
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "WAARSCHUWING: Verkeerde parameter '$0': '$1'! Nu wordt de standaard gebruikt: '$2'. Hulp: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT =>          self::$messages['en']['dpl2_log_' . self::WARN_WRONGPARAM_INT],
            'dpl2_log_' . self::WARN_NORESULTS => 'WAARSCHUWING: Geen resultaten!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "WAARSCHUWING: Add* parameters ('adduser', 'addeditdate', etc.)' heeft geen effect bij 'mode=category'. Alleen de paginanaamruimte/titel is in deze modus te bekijken.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "WAARSCHUWING: 'headingmode=$0' heeft geen effect met 'ordermethod' op een enkele component. Nu wordt gebruikt: '$1'. Hulp: u kunt een niet-$1 'headingmode'-waarde gebruiken met 'ordermethod' op meerdere componenten. De eerste component wordt gebruikt als kop. Bijvoorbeeld 'ordermethod=category,<i>comp</i>' (<i>comp</i> is een ander component) voor categoriekoppen.",
            /**
             * $0: 'debug' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "WAARSCHUWING: 'debug=$0' is niet de eerste positie in het DPL-element. De nieuwe debuginstellingen zijn niet toegepast voor alle voorgaande parameters zijn verwerkt en gecontroleerd.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'QUERY: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'Er {{PLURAL:$1|is één pagina|zijn $1 pagina\'s}} onder deze kop.'
        );
        self::$messages['ru'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespacenamespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "ОШИБКА: неправильный «$0»-параметр: «$1»! Подсказка:  <code>$0= <i>пустая строка</i> (Основное)$3</code>.",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => 'ОШИБКА: слишком много категорий! Максимум: $0. Подсказка: увеличте <code>ExtDynamicPageList2::$maxCategoryCount</code> чтобы разрешить больше категорий или установите <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> для снятия ограничения. (Устанавливайте переменные в <code>LocalSettings.php</code>, после подключения <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => 'ОШИБКА: слишком мало категорий! Минимум: $0. Подсказка: уменьшите <code>ExtDynamicPageList2::$minCategoryCount</code> чтобы разрешить меньше категорий. (Устанавливайте переменную в <code>LocalSettings.php</code>, после подключения <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "ОШИБКА: вы должны включить хотя бы одну категорию, если вы хотите использовать «addfirstcategorydate=true» или «ordermethod=categoryadd»!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "ОШИБКА: если вы включаете больше одной категории, то вы не можете использовать «addfirstcategorydate=true» или «ordermethod=categoryadd»!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'ОШИБКА: вы не можете добавить более одного типа данных за раз!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "ОШИБКА: вы можете использовать «$0» только с «ordermethod=[...,]$1»!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW =>          self::$messages['en']['dpl2_log_' . self::FATAL_NOCLVIEW],
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "ПРЕДУПРЕЖДЕНИЕ: неизвестный параметр «$0» проигнорирован. Подсказка: доступные параметры: <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "ПРЕДУПРЕЖДЕНИЕ: неправильный параметр «$0»: «$1»! Использование параметра по умолчанию: «$2». Подсказка: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "ПРЕДУПРЕЖДЕНИЕ: неправильный параметр «$0»: «$1»! Использование параметра по умолчанию: «$2» (без ограничений). Подсказка: <code>$0= <i>пустая строка</i> (без ограничений) | n</code>, с <code>n</code> равным положительному целому числу.",
            'dpl2_log_' . self::WARN_NORESULTS => 'ПРЕДУПРЕЖДЕНИЕ: не найдено!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "ПРЕДУПРЕЖДЕНИЕ: Добавление* параметров («adduser», «addeditdate», и др.) не действительны с «mode=category». Только пространства имён или названия могут просматриваться в этом режиме.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "ПРЕДУПРЕЖДЕНИЕ: «headingmode=$0» не действителен с «ordermethod» в одном компоненте. Использование: «$1». Подсказка: вы можете использоватьe не-$1 «headingmode» значения с «ordermethod» во множестве компонентов. Первый компонент используется для заголовков. Например, «ordermethod=category,<i>comp</i>» (<i>comp</i> является другим компонентом) для заголовков категорий.",
            /**
             * $0: 'debug' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "ПРЕДУПРЕЖДЕНИЕ: «debug=$0» не находится на первом месте в DPL-элементе. Новые настройки отладки не будут применены пока все предыдущие параметры не будут разобраны и проверены.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'ЗАПРОС: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'В этом заголовке $1 {{PLURAL:$1|статья|статьи|статей}}.'
        );
        self::$messages['sk'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "CHYBA: nesprávny parameter '$0': '$1'! Pomocník <code>$0= <i>prázdny retazec</i> (Hlavný)$3<code>.",
            /**
             * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
             * $1: wrong parameter given by user
             */
            'dpl2_log_' . self::FATAL_WRONGLINKSTO => "CHYBA: Zlý parameter '$0': '$1'! Pomocník <code>$0= <i>plný názov stránky</i></code>.",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => 'CHYBA: Príli vela kategórií! Maximum: $0. Pomocník: zväcite <code>ExtDynamicPageList2::$maxCategoryCount</code>, aby ste mohli pecifikovat viac kategórií alebo nastavte <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> pre vypnutie limitu. (Premennú nastatavte v <code>LocalSettings.php</code>, potom ako bol includovaný <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => 'CHYBA: Príli málo kategórií! Minimum: $0. Pomocník: zníte <code>ExtDynamicPageList2::$minCategoryCount</code>, aby ste mohli pecifikovat menej kategórií. (Premennú nastavte najlepie v <code>LocalSettings.php</code> potom, ako v nom bol includovaný <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "CHYBA: Musíte uviest aspon jednu kategóriu ak chcete pouit 'addfirstcategorydate=true' alebo 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "CHYBA: Ak zahrniete viac ako jednu kategóriu, nemôete pouit 'addfirstcategorydate=true' alebo 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'CHYBA: Nemôete naraz pridat viac ako jeden typ dátumu!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "CHYBA: '$0' môete pouit iba s 'ordermethod=[...,]$1'!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW => "CHYBA: Nie je momoné vykonávat logické operácie na nekategorizovaných kategóriách (napr. s parametrom 'Kategória') lebo neexistuje na databázu pohlad $0! Pomocník: nech admin databázy vykoná tento dotaz: <code>$1</code>.",
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "VAROVANIE: Neznámy parameter '$0' ignorovaný. Pomocník: dostupné parametre: <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "VAROVANIE: Nesprávny '$0' parameter: '$1'! Pouívam tandardný '$2'. Pomocník: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "VAROVANIE: Nesprávny parameter  '$0': '$1'! Pouívam tandardný: '$2' (bez obmedzenia). Pomocník: <code>$0= <i>prázdny retazec</i> (bez obmedzenia) | n</code>, s kladným celým císlom <code>n</code>.",
            'dpl2_log_' . self::WARN_NORESULTS => 'VAROVANIE: No results!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "VAROVANIE: Parametre Add* ('adduser', 'addeditdate', atd' nepracujú s mode=category'. V tomto reime je moné prehliadat iba menná priestor/titulok stránky.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "VAROVANIE: 'headingmode=$0' nepracuje s 'ordermethod' na jednom komponente. Pouitie: '$1'. Pomocník: môete pouit not-$1 hodnoty 'headingmode' s 'ordermethod' na viaceré komponenty. Prvý komponent sa pouíva na nadpisy. Napr. 'ordermethod=category,<i>comp</i>' (<i>comp</i> je iný komponent) pre nadpisy kategórií.",
            /**
             * $0: 'debug' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "VAROVANIE: 'debug=$0' nie je na prvej pozícii v prvku DPL. Nové ladiacie nastavenia nebudú pouíté skôr ne budú parsované a skontrolované vetky predchádzajúce.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'DOTAZ: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'V tomto nadpise {{PLURAL:$1|je jeden clánok|sú $1 clánky|je $1 clánkov}}.'
        );
        self::$messages['sr-ec'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "ГРЕШКА: Погреан '$0' параметар: '$1'! Помоћ:  <code>$0= <i>погрешан стринг</i> (Главно)$3</code>. (Еквиваленти са магичним речима су такође дозвољени.)",
            /**
             * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
             * $1: wrong parameter given by user
             */
            'dpl2_log_' . self::FATAL_WRONGLINKSTO => "ГРЕШКА: Погрешан '$0' параметар: '$1'! Помоћ:  <code>$0= <i>пуно име странице</i></code>. (Магичне речи су дозвољене.)",
            /**
             * $0: max number of categories that can be included
             */
	    'dpl2_log_' . self::FATAL_TOOMANYCATS => 'ГРЕШКА: Превише категорија! Максимум је: $0. Помоћ: повећајте <code>ExtDynamicPageList2::$maxCategoryCount</code> како бисте поставили више категорија или промените <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> за без граница. (Подесите варијаблу у <code>LocalSettings.php</code>, након укључивања <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
	    'dpl2_log_' . self::FATAL_TOOFEWCATS => 'ГРЕШКА: Премало категорија! Минимум је: $0. Помоћ: повећајте <code>ExtDynamicPageList2::$minCategoryCount</code> како бисте поставили мање категорија. (Подесите варијаблу у <code>LocalSettings.php</code>, након укључивања <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "ГРЕШКА: Морате укључити бар једну категорију уколико желите да користите 'addfirstcategorydate=true' или 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "ГРЕШКА: Уколико укључујете више од једне категорије, не можете користити 'addfirstcategorydate=true' или 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'ГРЕШКА: Не можете додати више од једног типа датума!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "ГРЕШКА: Можете користити '$0' са 'ordermethod=[...,]$1' искључиво!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ГРЕШКА: Немогуће извршити операцију на некатегоризованим страницама (нпр. са 'category' параметром) зато што $0 преглед не постоји у бази података! Помоћ: нека администратор базе изврши овај упит: <code>$1</code>.",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW => "ERROR: Cannot perform logical operations on the Uncategorized pages (f.e. with the 'category' parameter) because the $0 view does not exist on the database! Help: have the database administrator execute this query: <code>$1</code>.",
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "ПАЖЊА: Непознат параметар '$0' је игнорисан. Помоћ: доступни параметри су: <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "ПАЖЊА: Погрешан '$0' параметар: '$1'! Користи се основни: '$2'. Помоћ: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "ПАЖЊА: Погрешан '$0' параметар: '$1'! Користи се основни: '$2' (без границе). Помоћ: <code>$0= <i>празан стринг</i> (без границе) | n</code>, с <code>n</code> је позитиван интегер.",
            'dpl2_log_' . self::WARN_NORESULTS => 'ПАЖЊА: Нема резултата!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "ПАЖЊА: Додавање* параметара ('adduser', 'addeditdate', итд.)' и 'includepage' нема ефекта са 'mode=category'. Искључиво име странице/именски простор могу да се виде у овом моду.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "ПАЖЊА: 'headingmode=$0' нема ефекта са 'ordermethod' на једној компоненти. Користи се: '$1'. Помоћ: не морате користити-$1 'headingmode' податке 'ordermethod' на више компоненти. Прва компонента се користи за наслов. Нпр. 'ordermethod=category,<i>компонента</i>' (<i>компонента</i> је друга компонента) за наслове категорија.",
            /**
             * $0: 'log' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "ПАЖЊА: 'debug=$0' није на првом месту у DPL елементу. Нова дебаг подешавања нису примењена пре свих параметара који су проверени",
            /**
             * $0: title of page that creates an infinite transclusion loop
             */
            'dpl2_log_' . self::WARN_TRANSCLUSIONLOOP => "ПАЖЊА: Бесконачна петљаса странице '$0'.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'УПИТ: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'У овом наслову се тренутно налази {{PLURAL:$1|један чланак|$1 чланка|$1 чланака}}.'
        );
        self::$messages['sr-el'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "GREŠKA: Pogrean '$0' parametar: '$1'! Pomoć:  <code>$0= <i>pogrešan string</i> (Glavno)$3</code>. (Ekvivalenti sa magičnim rečima su takođe dozvoljeni.)",
            /**
             * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
             * $1: wrong parameter given by user
             */
            'dpl2_log_' . self::FATAL_WRONGLINKSTO => "GREŠKA: Pogrešan '$0' parametar: '$1'! Pomoć:  <code>$0= <i>puno ime stranice</i></code>. (Magične reči su dozvoljene.)",
            /**
             * $0: max number of categories that can be included
             */
	    'dpl2_log_' . self::FATAL_TOOMANYCATS => 'GREŠKA: Previše kategorija! Maksimum je: $0. Pomoć: povećajte <code>ExtDynamicPageList2::$maxCategoryCount</code> kako biste postavili više kategorija ili promenite <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> za bez granica. (Podesite varijablu u <code>LocalSettings.php</code>, nakon uključivanja <code>DynamicPageList2.php</code>.)',
            /**
             * $0: min number of categories that have to be included
             */
	    'dpl2_log_' . self::FATAL_TOOFEWCATS => 'GREŠKA: Premalo kategorija! Minimum je: $0. Pomoć: povećajte <code>ExtDynamicPageList2::$minCategoryCount</code> kako biste postavili manje kategorija. (Podesite varijablu u <code>LocalSettings.php</code>, nakon uključivanja <code>DynamicPageList2.php</code>.)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "GREŠKA: Morate uključiti bar jednu kategoriju ukoliko želite da koristite 'addfirstcategorydate=true' ili 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "GREŠKA: Ukoliko uključujete više od jedne kategorije, ne možete koristiti 'addfirstcategorydate=true' ili 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => 'GREŠKA: Ne možete dodati više od jednog tipa datuma!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "GREŠKA: Možete koristiti '$0' sa 'ordermethod=[...,]$1' isključivo!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW => "GREŠKA: Nemoguće izvršiti operaciju na nekategorizovanim stranicama (npr. sa 'category' parametrom) zato što $0 pregled ne postoji u bazi podataka! Pomoć: neka administrator baze izvrši ovaj upit: <code>$1</code>.",
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "PAŽNJA: Nepoznat parametar '$0' je ignorisan. Pomoć: dostupni parametri su: <code>$1</code>.",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "PAŽNJA: Pogrešan '$0' parametar: '$1'! Koristi se osnovni: '$2'. Pomoć: <code>$0= $3</code>.",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "PAŽNJA: Pogrešan '$0' parametar: '$1'! Koristi se osnovni: '$2' (bez granice). Pomoć: <code>$0= <i>prazan string</i> (bez granice) | n</code>, s <code>n</code> je pozitivan integer.",
            'dpl2_log_' . self::WARN_NORESULTS => 'PAŽNJA: Nema rezultata!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "PAŽNJA: Dodavanje* parametara ('adduser', 'addeditdate', itd.)' i 'includepage' nema efekta sa 'mode=category'. Isključivo ime stranice/imenski prostor mogu da se vide u ovom modu.",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "PAŽNJA: 'headingmode=$0' nema efekta sa 'ordermethod' na jednoj komponenti. Koristi se: '$1'. Pomoć: ne morate koristiti-$1 'headingmode' podatke 'ordermethod' na više komponenti. Prva komponenta se koristi za naslov. Npr. 'ordermethod=category,<i>komponenta</i>' (<i>komponenta</i> je druga komponenta) za naslove kategorija.",
            /**
             * $0: 'log' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "PAŽNJA: 'debug=$0' nije na prvom mestu u DPL elementu. Nova debag podešavanja nisu primenjena pre svih parametara koji su provereni",
            /**
             * $0: title of page that creates an infinite transclusion loop
             */
            'dpl2_log_' . self::WARN_TRANSCLUSIONLOOP => "PAŽNJA: Beskonačna petljasa stranice '$0'.",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => 'UPIT: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => 'U ovom naslovu se trenutno nalazi {{PLURAL:$1|jedan članak|$1 članka|$1 članaka}}'
        );
        self::$messages['yue'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "錯誤: 錯嘅 '$0' 參數: '$1'! 幫助:  <code>$0= <i>空字串</i> (主)$3</code>。",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => '錯誤: 太多分類! 最大值: $0。 幫助: 增加 <code>ExtDynamicPageList2::$maxCategoryCount</code> 嘅值去指定更多嘅分類或者設定 <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> 以解除限制。 (當加上 <code>DynamicPageList2.php</code>之後，響<code>LocalSettings.php</code>度設定變數。)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => '錯誤: 太少分類! 最小值: $0. 幫助: 減少 <code>ExtDynamicPageList2::$minCategoryCount</code> 嘅值去指定更少嘅分類。 (當加上 <code>DynamicPageList2.php</code>之後，響<code>LocalSettings.php</code>度設定一個合適嘅變數。)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "錯誤: 如果你想去用 'addfirstcategorydate=true' 或者 'ordermethod=categoryadd' ，你需要包含最少一個分類!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "錯誤: 如果你包含多過一個分類，你唔可以用 'addfirstcategorydate=true' 或者 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => '錯誤: 你唔可以響一個時間度加入多個一種嘅日期!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "錯誤: 你只可以用 'ordermethod=[...,]$1' 響 '$0' 上!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW =>          self::$messages['en']['dpl2_log_' . self::FATAL_NOCLVIEW],
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "警告: 不明嘅參數 '$0' 被忽略。 幫助: 可用嘅參數: <code>$1</code>。",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "警告: 錯誤嘅 '$0' 參數: '$1'! 用緊預設嘅: '$2'。 幫助: <code>$0= $3</code>。",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "警告: 錯誤嘅 '$0' 參數: '$1'! 用緊預設嘅: '$2' (冇上限)。 幫助: <code>$0= <i>空字串</i> (冇上限) | n</code>, <code>n</code>係一個正整數。",
            'dpl2_log_' . self::WARN_NORESULTS => '警告: 無結果!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "警告: 加入* 參數 ('adduser', 'addeditdate', 等)' 係對 'mode=category' 冇作用嘅。只有頁空間名／標題至可以響呢個模式度睇到。",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "警告: 響單一部件中， 'ordermethod' 度用 'headingmode=$0' 係冇作用嘅。 用緊: '$1'。 幫助: 你可以用非$1 'headingmode' 數值，響多個部件中用 'ordermethod' 。第一個部件係用嚟做標題。例如響分類標題度用 'ordermethod=category,<i>comp</i>' (<i>comp</i>係另外一個部件) 。",
            /**
             * $0: 'debug' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "警告: 'debug=$0' 唔係第一個響DPL元素嘅第一位。新嘅除錯設定響所有參數都能夠處理同檢查之前都唔會應用。",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => '查訽: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => '響呢個標題度有$1篇文。'
        );
        self::$messages['zh-hans'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "错误: 错误的 '$0' 参数: '$1'! 帮助:  <code>$0= <i>空白字符串</i> (主)$3</code>。",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => '错误: 过多分类! 最大值: $0。 帮助: 增加 <code>ExtDynamicPageList2::$maxCategoryCount</code> 的值去指定更多的分类或设定 <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> 以解除限制。 (当加上 <code>DynamicPageList2.php</code>后，在<code>LocalSettings.php</code>中设定变量。)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => '错误: 过少分类! 最小值: $0。 帮助: 减少 <code>ExtDynamicPageList2::$minCategoryCount</code> 的值去指定更少的分类。 (当加上 <code>DynamicPageList2.php</code>后，在<code>LocalSettings.php</code>中设定一个合适的变量。)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "错误: 如果您想用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd' ，您需要包含最少一个分类!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "错误: 如果您包含多一个分类，您不可以用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => '错误: 您不可以在一个时间里加入多于一种的日期!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "错误: 你只可以用 'ordermethod=[...,]$1' 在 '$0' 上!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW =>          self::$messages['en']['dpl2_log_' . self::FATAL_NOCLVIEW],
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "警告: 不明的参数 '$0' 被忽略。 帮助: 可用的参数: <code>$1</code>。",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "警告: 错误的 '$0' 参数: '$1'! 正在使用默认值: '$2'。 帮助: <code>$0= $3</code>。",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "警告: 错误的 '$0' 参数: '$1'! 正在使用默认值: '$2' (没有上限)。 帮助: <code>$0= <i>空白字符串</i> (没有上限) | n</code>, <code>n</code>是一个正整数。",
            'dpl2_log_' . self::WARN_NORESULTS => '警告: 无结果!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "警告: 加入* 参数 ('adduser', 'addeditdate', 等)' 是对 'mode=category' 没有作用。只有页面空间名／标题才可以在这个模式度看到。",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "警告: 在单一部件中， 'ordermethod' 用 'headingmode=$0' 是没有作用的。 正在使用: '$1'。 帮助: 你可以用非$1 'headingmode' 数值，在多个部件中用 'ordermethod' 。第一个部是用来作标题。例如在分类标题中用 'ordermethod=category,<i>comp</i>' (<i>comp</i>是另外一个部件) 。",
            /**
             * $0: 'debug' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "警告: 'debug=$0' 不是第一个在DPL元素嘅第一位置。新的除错设定在所有参数都能处理和检查前都不会应用。",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => '查訽: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => '在这个标题中有$1篇条目。'
        );
        self::$messages['zh-hant'] = array(
            /*
                Log
             */
            // FATAL
            /**
             * $0: 'namespace' or 'notnamespace'
             * $1: wrong parameter given by user
             * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
             */
            'dpl2_log_' . self::FATAL_WRONGNS => "錯誤: 錯誤的 '$0' 參數: '$1'! 說明:  <code>$0= <i>空白字串</i> (主)$3</code>。",
            /**
             * $0: max number of categories that can be included
             */
            'dpl2_log_' . self::FATAL_TOOMANYCATS => '錯誤: 過多分類! 最大值: $0。 說明: 增加 <code>ExtDynamicPageList2::$maxCategoryCount</code> 的值去指定更多的分類或設定 <code>ExtDynamicPageList2::$allowUnlimitedCategories=true</code> 以解除限制。 (當加上 <code>DynamicPageList2.php</code>後，在<code>LocalSettings.php</code>中設定變數。)',
            /**
             * $0: min number of categories that have to be included
             */
            'dpl2_log_' . self::FATAL_TOOFEWCATS => '錯誤: 過少分類! 最小值: $0。 說明: 減少 <code>ExtDynamicPageList2::$minCategoryCount</code> 的值去指定更少的分類。 (當加上 <code>DynamicPageList2.php</code>後，在<code>LocalSettings.php</code>中設定一個合適的變數。)',
            'dpl2_log_' . self::FATAL_NOSELECTION => "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
            'dpl2_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS => "錯誤: 如果您想用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd' ，您需要包含最少一個分類!",
            'dpl2_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT => "錯誤: 如果您包含多一個分類，您不可以用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd'!",
            'dpl2_log_' . self::FATAL_MORETHAN1TYPEOFDATE => '錯誤: 您不可以在一個時間裡加入多於一種的日期!',
            /**
             * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
             * $1: last 'ordermethod' parameter required for $0
             */
            'dpl2_log_' . self::FATAL_WRONGORDERMETHOD => "錯誤: 你只可以用 'ordermethod=[...,]$1' 在 '$0' 上!",
            /**
             * $0: the number of arguments in includepage
             */
            'dpl2_log_' . self::FATAL_DOMINANTSECTIONRANGE => "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
            /**
             * $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
             * $1: SQL query to create the prefix_dpl_clview on your mediawiki DB
             */
            'dpl2_log_' . self::FATAL_NOCLVIEW =>          self::$messages['en']['dpl2_log_' . self::FATAL_NOCLVIEW],
            'dpl2_log_' . self::FATAL_OPENREFERENCES => 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',

            // WARN
            /**
             * $0: unknown parameter given by user
             * $1: list of DPL2 available parameters separated by ', '
             */
            'dpl2_log_' . self::WARN_UNKNOWNPARAM => "警告: 不明的參數 '$0' 被忽略。 說明: 可用的參數: <code>$1</code>。",
            /**
             * $3: list of valid param values separated by ' | '
             */
            'dpl2_log_' . self::WARN_WRONGPARAM => "警告: 錯誤的 '$0' 參數: '$1'! 正在使用預設值: '$2'。 說明: <code>$0= $3</code>。",
            /**
             * $0: param name
             * $1: wrong param value given by user
             * $2: default param value used instead by program
             */
            'dpl2_log_' . self::WARN_WRONGPARAM_INT => "警告: 錯誤的 '$0' 參數: '$1'! 正在使用預設值: '$2' (沒有上限)。 說明: <code>$0= <i>空白字串</i> (沒有上限) | n</code>, <code>n</code>是一個正整數。",
            'dpl2_log_' . self::WARN_NORESULTS => '警告: 無結果!',
            'dpl2_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS => "警告: 加入* 參數 ('adduser', 'addeditdate', 等)' 是對 'mode=category' 沒有作用。只有頁面空間名／標題才可以在這個模式度看到。",
            /**
             * $0: 'headingmode' value given by user
             * $1: value used instead by program (which means no heading)
             */
            'dpl2_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "警告: 在單一部件中， 'ordermethod' 用 'headingmode=$0' 是沒有作用的。 正在使用: '$1'。 說明: 你可以用非$1 'headingmode' 數值，在多個部件中用 'ordermethod' 。第一個部是用來作標題。例如在分類標題中用 'ordermethod=category,<i>comp</i>' (<i>comp</i>是另外一個部件) 。",
            /**
             * $0: 'debug' value
             */
            'dpl2_log_' . self::WARN_DEBUGPARAMNOTFIRST => "警告: 'debug=$0' 不是第一個在DPL元素嘅第一位置。新的除錯設定在所有參數都能處理和檢查前都不會應用。",

            // DEBUG
            /**
             * $0: SQL query executed to generate the dynamic page list
             */
            'dpl2_log_' . self::DEBUG_QUERY => '查訽: <code>$0</code>',

            /*
               Output formatting
             */
            /**
             * $1: number of articles
             */
            'dpl2_articlecount' => '在這個標題中有$1篇條目。'
        );
        self::$messages['sr'] = self::$messages['sr-ec'];
        self::$messages['zh-cn'] = self::$messages['zh-hans'];
        self::$messages['zh-hk'] = self::$messages['zh-hant'];
        self::$messages['zh-mo'] = self::$messages['zh-hant'];
        self::$messages['zh-my'] = self::$messages['zh-hans'];
        self::$messages['zh-sg'] = self::$messages['zh-hans'];
        self::$messages['zh-tw'] = self::$messages['zh-hant'];
        self::$messages['zh-yue'] = self::$messages['yue'];
        return self::$messages;
    }
}
