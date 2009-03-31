<?php
/**
 * Internationalisation file for IM Status extension
 *
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
        'imstatus-desc' => 'Adds tags to show various IM online status (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
        'imstatus_syntax' => 'Syntax',
        'imstatus_default' => 'Default',
        'imstatus_example' => 'Example',
        'imstatus_possible_val' => 'Possible values',
        'imstatus_max' => 'max',
        'imstatus_min' => 'min',
        'imstatus_or' => 'or',
        'imstatus_style' => 'style of the status indicator',
        'imstatus_action' => 'action when the button is clicked',
        'imstatus_details_saa' => 'For more details about all the styles and actions, see $1.',
        'imstatus_your_name' => 'your $1 name',

        'imstatus_aim_presence' => '$1 shows your status with a link that will launch AIM to send you an IM, provided the user has it installed.',
        'imstatus_aim_api' => '$1 shows your status with a link that will launch a <b>browser</b>, javascript version of AIM to send you an IM.',

        'imstatus_gtalk_code' => 'your google talk code',
        'imstatus_gtalk_get_code' => 'your google talk code: get it at $1.',
        'imstatus_gtalk_height' => 'height of the box, in pixels.',
        'imstatus_gtalk_width' => 'width of the box, in pixels.',

        'imstatus_icq_id' => 'your ICQ ID',
        'imstatus_icq_style' => 'a number ranging from 0 to 26 (yes, there are 27 available styles...).',

        'imstatus_live_code' => 'your Live Messenger website id',
        'imstatus_live_get_code' => 'your Live Messenger website id: <strong>this is not your e-mail address</strong>, you need to generate one in
<a href="$1">your live messenger options</a>.
The id you need to provide is the numbers and letters between "$2" and "$3".',

        'imstatus_skype_nbstyle' => 'Note: If you choose a style which is also an action, your action choice will be overridden by the action matching your chosen style.',

        'imstatus_xfire_size' => 'the button size, from $1 (biggest) to $2 (smallest).',

        'imstatus_yahoo_style' => 'the button style, from $1 (smallest) to $2 (biggest), $3 and $4 are for voicemail.',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'imstatus-desc' => 'Short description of the IMStatus extension, shown on [[Special:Version]].',
	'imstatus_live_get_code' => 'The parameters are pieces of static text to help a user find what he needs.
* $1 is "http://settings.messenger.live.com/applications/CreateHtml.aspx"
* $2 is "invitee="
* $3 is "@apps.messenger"',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'imstatus-desc' => 'يضيف وسوما لعرض حالات IM المتعددة على الإنترنت (AIM، جوجل تولك، ICQ، MSN/Live Messenger، سكايب، Xfire، ياهو)',
	'imstatus_syntax' => 'صياغة',
	'imstatus_default' => 'افتراضي',
	'imstatus_example' => 'مثال',
	'imstatus_possible_val' => 'قيم محتملة',
	'imstatus_max' => 'أقصى',
	'imstatus_min' => 'أدنى',
	'imstatus_or' => 'أو',
	'imstatus_style' => 'أسلوب مؤشر الحالة',
	'imstatus_action' => 'الفعل عند ضغط الزر',
	'imstatus_details_saa' => 'لمزيد من التفاصيل حول كل الأساليب والأفعال، انظر $1.',
	'imstatus_your_name' => 'اسم $1 الخاص بك',
	'imstatus_aim_presence' => '$1 تعرض حالتك مع وصلة تطلق AIM لترسل لك IM، إذا كان لدى المستخدم منصبا.',
	'imstatus_aim_api' => '$1 تعرض حالتك مع وصلة تطلق نسخة <b>متصفح</b>، جافاسكريبت من AIM لترسل لك IM.',
	'imstatus_gtalk_code' => 'كود جوجل تولك الخاص بك',
	'imstatus_gtalk_get_code' => 'كود جوجل تولك الخاص بك: احصل عليه في $1.',
	'imstatus_gtalk_height' => 'ارتفاع الصندوق، بالبكسل.',
	'imstatus_gtalk_width' => 'عرض الصندوق، بالبكسل.',
	'imstatus_icq_id' => 'رقم ICQ الخاص بك',
	'imstatus_icq_style' => 'رقم يتراوح من 0 إلى 26 (نعم، هناك 27 أسلوبا متوفرا...).',
	'imstatus_live_code' => 'رقم موقع ويب لايف ماسنجر الخاص بك',
	'imstatus_live_get_code' => 'رقم موقع ويب لايف ماسنجر الخاص بك: <strong>هذا ليس عنوان بريدك الإلكتروني</strong>، تحتاج إلى توليد واحد في
<a href="$1">خيارات لايف ماسنجر الخاصة بك</a>.
الرقم الذي تحتاج إلى توفيره هو الأرقام والحروف بين "$2" و "$3".',
	'imstatus_skype_nbstyle' => 'ملاحظة: إذا اخترت أسلوبا هو أيضا فعل، اختيارك للفعل سيطغى عليه بواسطة الفعل المطابق لأسلوبك المختار.',
	'imstatus_xfire_size' => 'حجم الزر، من $1 (أكبر) إلى $2 (أصغر).',
	'imstatus_yahoo_style' => 'أسلوب الزر، من $1 (أصغر) إلى $2 (أكبر)، $3 و $4 هما للبريد الصوتي.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'imstatus-desc' => 'يضيف وسوما لعرض حالات IM المتعددة على الإنترنت (AIM، جوجل تولك، ICQ، MSN/Live Messenger، سكايب، Xfire، ياهو)',
	'imstatus_syntax' => 'صياغة',
	'imstatus_default' => 'افتراضى',
	'imstatus_example' => 'مثال',
	'imstatus_possible_val' => 'قيم محتملة',
	'imstatus_max' => 'أقصى',
	'imstatus_min' => 'أدنى',
	'imstatus_or' => 'أو',
	'imstatus_style' => 'أسلوب مؤشر الحالة',
	'imstatus_action' => 'الفعل عند ضغط الزر',
	'imstatus_details_saa' => 'لمزيد من التفاصيل حول كل الأساليب والأفعال، انظر $1.',
	'imstatus_your_name' => 'اسم $1 الخاص بك',
	'imstatus_aim_presence' => '$1 تعرض حالتك مع وصلة تطلق AIM لترسل لك IM، إذا كان لدى المستخدم منصبا.',
	'imstatus_aim_api' => '$1 تعرض حالتك مع وصلة تطلق نسخة <b>متصفح</b>، جافاسكريبت من AIM لترسل لك IM.',
	'imstatus_gtalk_code' => 'كود جوجل تولك الخاص بك',
	'imstatus_gtalk_get_code' => 'كود جوجل تولك الخاص بك: احصل عليه فى $1.',
	'imstatus_gtalk_height' => 'ارتفاع الصندوق، بالبكسل.',
	'imstatus_gtalk_width' => 'عرض الصندوق، بالبكسل.',
	'imstatus_icq_id' => 'رقم ICQ الخاص بك',
	'imstatus_icq_style' => 'رقم يتراوح من 0 إلى 26 (نعم، هناك 27 أسلوبا متوفرا...).',
	'imstatus_live_code' => 'رقم موقع ويب لايف ماسنجر الخاص بك',
	'imstatus_live_get_code' => 'رقم موقع ويب لايف ماسنجر الخاص بك: <strong>هذا ليس عنوان بريدك الإلكترونى</strong>، تحتاج إلى توليد واحد في
<a href="$1">خيارات لايف ماسنجر الخاصة بك</a>.
الرقم الذى تحتاج إلى توفيره هو الأرقام والحروف بين "$2" و "$3".',
	'imstatus_skype_nbstyle' => 'ملاحظة: إذا اخترت أسلوبا هو أيضا فعل، اختيارك للفعل سيطغى عليه بواسطة الفعل المطابق لأسلوبك المختار.',
	'imstatus_xfire_size' => 'حجم الزر، من $1 (أكبر) إلى $2 (أصغر).',
	'imstatus_yahoo_style' => 'أسلوب الزر، من $1 (أصغر) إلى $2 (أكبر)، $3 و $4 هما للبريد الصوتي.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'imstatus_syntax' => 'Синтаксис',
	'imstatus_example' => 'Пример',
	'imstatus_possible_val' => 'Допустими стойности',
	'imstatus_or' => 'или',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'imstatus-desc' => 'Přidává značky zobrazující stav přítomnosti uživatelů různých IM sítí (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo!)',
	'imstatus_syntax' => 'Sntaxe',
	'imstatus_default' => 'Výchozí',
	'imstatus_example' => 'Příklad',
	'imstatus_possible_val' => 'Možné hodnoty',
	'imstatus_max' => 'max.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'nebo',
	'imstatus_style' => 'styl indikátoru stavu',
	'imstatus_action' => 'akce po kliknutí na tlačítko',
	'imstatus_details_saa' => 'Podrobnosti o stylech a akcích najdete na $1.',
	'imstatus_your_name' => 'vaše jméno na $1',
	'imstatus_aim_presence' => '$1 zobrazuje váš stav přítomnosti s odkazem, který spustí odeslání zprávy v AIM pokud ho má uživatel nainstalovaný.',
	'imstatus_aim_api' => '$1 zobrazuje váš stav přítomnosti s odkazem, který spustí odeslání zprávy ve <b>webovém prohlížeči</b>, javascriptové verzi AIM.',
	'imstatus_gtalk_code' => 'váš kód Google Talk',
	'imstatus_gtalk_get_code' => 'Svůj kód Google Talk získáte na $1.',
	'imstatus_gtalk_height' => 'výška okraje v pixelech',
	'imstatus_gtalk_width' => 'šířka okraje v pixelech',
	'imstatus_icq_id' => 'váš ICQ identifikátor',
	'imstatus_icq_style' => 'číslo v rozsahu 0-26 (ano, je dostupných 27 stylů…).',
	'imstatus_live_code' => 'váš identifikátor na webu Live Messenger',
	'imstatus_live_get_code' => 'váš identifikátor na webu Live Messenger: <strong>toto není vaše emailová adresa</strong>, musíte si ji vytvořit <a href="$1">ve svých nastaveních Live Messenger</a>.
Indentifikítor, který musíte zadat, jsou písmena a číslice mezi $2 a $3.',
	'imstatus_skype_nbstyle' => 'Poznámka: Pokud si zvolíte styl, který je i akcí, před vaší voublou akce bude mít přednost akce odpovídající zvolenému stylu.',
	'imstatus_xfire_size' => 'velikost tlačítka od $1 (největší) do $2 (nejmenší).',
	'imstatus_yahoo_style' => 'styl tlačítka od $1 (nejmenší) do $2 (největší), $3 a $4 slouží pro hlasovou poštu.',
);

/** German (Deutsch)
 * @author Purodha
 */
$messages['de'] = array(
	'imstatus-desc' => 'Fügt Tags hinzu, um den Online-Status verschiedener Instant-Messenger anzuzeigen (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Beispiel',
	'imstatus_possible_val' => 'Mögliche Werte',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'oder',
	'imstatus_style' => 'Stil der Status-Anzeige',
	'imstatus_action' => 'Aktion beim Klicken der Schaltfläche',
	'imstatus_details_saa' => 'Weitere Details zu den Stilen und Aktionen findet man auf: $1.',
	'imstatus_your_name' => 'dein $1-Name',
	'imstatus_aim_presence' => '$1 zeigt deinen Status mit einem Link, der AIM startet (sofern es installiert ist), um dir eine Nachricht zu senden.',
	'imstatus_aim_api' => '$1 zeigt deinen Status mit einem Link, der eine <b>Browser</b>, JavaScript Version von AIM, startet, um dir eine Nachricht zu senden.',
	'imstatus_gtalk_code' => 'dein Google-Talk Code',
	'imstatus_gtalk_get_code' => 'deinen Google-Talk Code erhälst du bei $1.',
	'imstatus_gtalk_height' => 'Höhe der Box in Pixel.',
	'imstatus_gtalk_width' => 'Breite der Box in Pixel.',
	'imstatus_icq_id' => 'deine ICQ-UIN',
	'imstatus_icq_style' => 'eine Zahl zwischen 0 und 26 (ja, es gibt 27 verschiedene Stile…).',
	'imstatus_live_code' => 'deine Live Messenger Website-ID',
	'imstatus_live_get_code' => 'deine Live Messenger Website-ID: <strong>Das ist nicht deine E-Mail-Adresse</strong>.
Du musst dir eine in den <a href="$1">Live Messenger Optionen</a> erstellen.
Die ID, die du benötigst, sind die Zahlen und Buchstaben zwischen „$2“ und „$3“.',
	'imstatus_skype_nbstyle' => 'Hinweis: wenn du einen Stil aussuchst, der auch eine Aktion beinhaltet, wird deine Aktionsauswahl durch die Aktion des Stiles ersetzt.',
	'imstatus_xfire_size' => 'die Größe der Schaltfläche, von $1 (größte) bis $2 (kleinste).',
	'imstatus_yahoo_style' => 'der Stil der Schaltfläche, von $1 (kleinste) bis $2 (größte), $3 und $4 sind für Voicemail.',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'imstatus_syntax' => 'Sintakso',
	'imstatus_default' => 'Defaŭlta',
	'imstatus_example' => 'Ekzemplo',
	'imstatus_possible_val' => 'Eblaj valutoj',
	'imstatus_max' => 'maks',
	'imstatus_min' => 'min',
	'imstatus_or' => 'aŭ',
	'imstatus_your_name' => 'via $1 nomo',
	'imstatus_gtalk_height' => 'alto de la skatolo, laux rastumeroj.',
	'imstatus_gtalk_width' => 'larĝo de la kesto, je rastumeroj',
	'imstatus_icq_id' => 'via ID de ICQ',
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'imstatus_example' => 'Ejemplo',
);

/** Persian (فارسی)
 * @author Mardetanha
 */
$messages['fa'] = array(
	'imstatus_default' => 'پیش‌فرض',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Vililikku
 */
$messages['fi'] = array(
	'imstatus-desc' => 'Lisää elementit monien pikaviestimien tilan näyttämiseen (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo).',
	'imstatus_syntax' => 'Syntaksi',
	'imstatus_default' => 'Oletus',
	'imstatus_example' => 'Esimerkki',
	'imstatus_possible_val' => 'Mahdolliset arvot',
	'imstatus_style' => 'tilanilmaisimen tyyli',
	'imstatus_action' => 'toimenpide, kun painiketta napsautetaan',
	'imstatus_details_saa' => 'Lisätietoja kaikista tyyleistä ja toimenpiteistä löytyy sivulta $1.',
	'imstatus_gtalk_height' => 'laatikon korkeus, pikseleinä.',
	'imstatus_gtalk_width' => 'laatikon leveys, pikseleinä.',
	'imstatus_icq_id' => 'ICQ-tunnuksesi',
	'imstatus_icq_style' => 'numero nollan ja 26:n väliltä (käytettävissä on siis 27 tyyliä).',
	'imstatus_live_code' => 'Live Messenger -sivuston tunnuksesi',
	'imstatus_live_get_code' => 'Live Messenger -sivuston tunnus: <strong>tämä ei ole sähköpostiosoitteesi</strong>. Sinun täytyy luoda se <a href="$1">Live Messenger -asetuksissasi</a>.
Tunnus, joka sinun pitää antaa, on numeroita ja kirjaimia merkkijonojen <code>$2</code> ja <code>$3</code> väliltä.',
);

/** French (Français)
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'imstatus-desc' => 'Ajoute des balises montrant l’état en ligne sur divers réseaux de communication (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntaxe',
	'imstatus_default' => 'Par défaut',
	'imstatus_example' => 'Exemple',
	'imstatus_possible_val' => 'Valeurs possibles',
	'imstatus_max' => 'max.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'ou',
	'imstatus_style' => 'style de l’indicateur d’état',
	'imstatus_action' => 'action quand le bouton est cliqué',
	'imstatus_details_saa' => 'Pour plus de détails au sujet des styles et actions, consultez $1.',
	'imstatus_your_name' => 'votre nom $1',
	'imstatus_aim_presence' => '$1 affiche votre état avec un lien qui lancera AIM pour vous envoyer un message instantané, pourvu que l’utilisateur l’ait installé.',
	'imstatus_aim_api' => '$1 affiche votre état avec un lien qui lancera dans un <b>navigateur</b> une version javascript de AIM pour vous envoyer un message instantané.',
	'imstatus_gtalk_code' => 'votre code Google Talk',
	'imstatus_gtalk_get_code' => 'votre code Google Talk : obtenez-le sur $1.',
	'imstatus_gtalk_height' => 'hauteur de la boîte, en pixels.',
	'imstatus_gtalk_width' => 'largeur de la boîte, en pixels.',
	'imstatus_icq_id' => 'votre identifiant ICQ',
	'imstatus_icq_style' => 'un nombre entre 0 et 26 (oui, il y a 27 styles disponibles...).',
	'imstatus_live_code' => 'votre identifiant sur le site Live Messenger',
	'imstatus_live_get_code' => 'votre identifiant sur le site Live Messenger : <strong>ce n’est pas votre adresse de messagerie</strong>, vous devez en générer un dans <a href="$1">vos options Live Messenger</a>.
L’identifiant à fournir ici est composé des chiffres et lettres entre « $2 » et « $3 ».',
	'imstatus_skype_nbstyle' => 'Note : si vous choisissez un style qui est aussi une action, votre choix d’action sera écrasé par l’action correspondant au style que vous avez choisi.',
	'imstatus_xfire_size' => 'la taille du bouton, de $1 (la plus grande) à $2 (la plus petite).',
	'imstatus_yahoo_style' => 'le style du bouton, de $1 (le plus petit) à $2 (le plus grand), $3 et $4 sont pour les messages vocaux.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'imstatus-desc' => 'Engade etiquetas para amosar varios status IM en liña (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Sintaxe',
	'imstatus_default' => 'Por defecto',
	'imstatus_example' => 'Exemplo',
	'imstatus_possible_val' => 'Valores posibles',
	'imstatus_max' => 'máx.',
	'imstatus_min' => 'mín.',
	'imstatus_or' => 'ou',
	'imstatus_style' => 'estilo do indicador do status',
	'imstatus_action' => 'acción cando o botón é premido',
	'imstatus_details_saa' => 'Para obter información sobre todos os estilos e accións, consulte $1.',
	'imstatus_your_name' => 'o seu nome $1',
	'imstatus_aim_presence' => '$1 mostra o seu status cunha ligazón que executará o AIM para enviarlle unha mensaxe instantánea, sempre que o usuario o teña instalado.',
	'imstatus_aim_api' => '$1 mostra o seu status cunha ligazón que executará desde un <b>navegador</b> unha versión JavaScript de AIM para enviarlle unha mensaxe instantánea.',
	'imstatus_gtalk_code' => 'o código da súa conversa Google',
	'imstatus_gtalk_get_code' => 'o código da súa conversa Google: obtéñao en $1.',
	'imstatus_gtalk_height' => 'alto da caixa, en píxeles.',
	'imstatus_gtalk_width' => 'ancho da caixa, en píxeles.',
	'imstatus_icq_id' => 'o seu ID no ICQ',
	'imstatus_icq_style' => 'un número de 0 a 26 (si, hai dispoñibles 27 estilos...).',
	'imstatus_live_code' => 'o seu ID da páxina web do Live Messenger',
	'imstatus_live_get_code' => 'o seu ID da páxina web do Live Messenger: <strong>este non é o seu enderezo de correo electrónico</strong>, necesita xerar un <a href="$1">nas súas opcións do Live Messenger</a>.
O ID que precisa proporcionar son os números e letras entre "$2" e "$3".',
	'imstatus_skype_nbstyle' => 'Nota: se escolle un estilo que tamén sexa unha acción, a súa escolla da acción será sobreescrita pola acción que coincida co estilo elixido.',
	'imstatus_xfire_size' => 'o botón do tamaño, de $1 (o maior) a $2 (o menor).',
	'imstatus_yahoo_style' => 'o botón do estilo, de $1 (o menor) a $2 (o maior), $3 e $4 son para as mensaxes faladas.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'imstatus_syntax' => 'Σύνταξις',
	'imstatus_max' => 'μέγ',
	'imstatus_min' => 'ἐλάχ',
	'imstatus_or' => 'ἢ',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'imstatus-desc' => 'הוספת תגיות מגוונות עבור המצבים המקוונים של רשתות המסרים המידיים (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'תחביר',
	'imstatus_default' => 'ברירת מחדל',
	'imstatus_example' => 'דוגמה',
	'imstatus_possible_val' => 'ערכים אפשריים',
	'imstatus_max' => 'מקסימום',
	'imstatus_min' => 'מינימום',
	'imstatus_or' => 'או',
	'imstatus_style' => 'סגנון מחוון המצב',
	'imstatus_action' => 'פעולה בעת הלחיצה על הכפתור',
	'imstatus_details_saa' => 'לפרטים נוספים על כל הסגנונות והפעולות, ראו $1.',
	'imstatus_your_name' => 'שם ה־$1 שלך',
	'imstatus_aim_presence' => '$1 מציג את המצב שלך וקישור שיפעיל את AIM לשליחת הודעה, במידה ולמשתמש יש AIM מותקן.',
	'imstatus_aim_api' => '$1 מציג את המצב שלך וקישור שיפעיל את גרסת <b>דפדפן</b> מבוססת JavaScript של AIM לשליחת הודעות אליך.',
	'imstatus_gtalk_code' => 'קוד ה־Google talk שלך',
	'imstatus_gtalk_get_code' => 'קוד ה־Google talk שלך: ניתן לקבלו ב־$1.',
	'imstatus_gtalk_height' => 'גובה התיבה, בפיקסלים.',
	'imstatus_gtalk_width' => 'רוחב התיבה, בפיקסלים.',
	'imstatus_icq_id' => 'מספר ה־ICQ שלך',
	'imstatus_icq_style' => 'מספר בין 0 ל־26 (כן, ישנם 27 סגנונות זמינים...).',
	'imstatus_live_code' => 'מזהה אתר ה־Live Messenger שלך',
	'imstatus_live_get_code' => 'מזהה אתר ה־Live Messenger שלך: <strong>זו אינה כתובת הדוא"ל שלך</strong>, צריך לייצר אותו באמצעות <a href="$1">אפשרויות ה־Live Messenger</a>.
המזהה שיש לכתוב כאן הוא המספרים והאותיות שבין "$2" ו־"$3".',
	'imstatus_skype_nbstyle' => 'הערה: בחירה בסגנון שהוא גם פעולה תגרום לכך שהפעולה שבחרת תידרס על ידי הפעולה התואמת לסגנון שבחרת.',
	'imstatus_xfire_size' => 'גדלי הכפתורים, מ־$1 (הגדול ביותר) עד $2 (הקטן ביותר).',
	'imstatus_yahoo_style' => 'סגנון הכפתור, מ־$1 (הקטן ביותר) עד $2 (הגדול ביותר). $3 ו־$4 משמשים לתא קולי.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'imstatus-desc' => 'Adde etiquettas pro monstrar le stato in linea de varie servicios de messageria instantanee (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntaxe',
	'imstatus_default' => 'Predefinition',
	'imstatus_example' => 'Exemplo',
	'imstatus_possible_val' => 'Valores possibile',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'o',
	'imstatus_style' => 'stilo del indicator de stato',
	'imstatus_action' => 'action quando le button es cliccate',
	'imstatus_details_saa' => 'Pro plus detalios super tote le stilos e actiones, vide $1.',
	'imstatus_your_name' => 'tu nomine de $1',
	'imstatus_aim_presence' => '$1 monstra tu stato con un ligamine que lanceara AIM pro inviar te un message instantanee, a condition que le usator lo ha installate.',
	'imstatus_aim_api' => '$1 monstra tu stato con un ligamine que lanceara in un <b>navigator del web</b> un version JavaScript de AIM pro inviar te un message instantanee.',
	'imstatus_gtalk_code' => 'tu codice de Google Talk',
	'imstatus_gtalk_get_code' => 'tu codice de Google Talk: obtene lo a $1.',
	'imstatus_gtalk_height' => 'altitude del quadro, in pixeles.',
	'imstatus_gtalk_width' => 'latitude del quadro, in pixeles.',
	'imstatus_icq_id' => 'tu numero de ICQ',
	'imstatus_icq_style' => 'un numero inter 0 e 26 (in effecto, il ha 27 stilos disponibile...).',
	'imstatus_live_code' => 'tu ID del sito web Live Messenger',
	'imstatus_live_get_code' => 'tu ID del sito web Live Messenger: <strong>isto non es tu adresse de e-mail.</strong> Tu debe generar un ID per medio de
<a href="$1">tu optiones de Live Messenger</a>.
Le ID a fornir hic es le numeros e litteras inter "$2" e "$3".',
	'imstatus_skype_nbstyle' => 'Nota: Si tu selige un stilo que es tamben un action, tu selection de action essera ultrapassate per le action correspondente a tu stilo seligite.',
	'imstatus_xfire_size' => 'le grandor del button, de $1 (le plus grande) a $2 (le plus parve).',
	'imstatus_yahoo_style' => 'le stilo del button, de $1 (le plus parve) a $2 (le plus grande), $3 e $4 es pro le messages vocal.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'imstatus_syntax' => 'វាក្យសម្ពន្ធ',
	'imstatus_default' => 'លំនាំដើម',
	'imstatus_example' => 'ឧទាហរណ៍',
	'imstatus_possible_val' => 'តម្លៃ​អាចធ្វើបាន',
	'imstatus_max' => 'អតិបរមា',
	'imstatus_min' => 'អប្បបរមា',
	'imstatus_or' => 'ឬ',
	'imstatus_your_name' => 'ឈ្មោះ $1 របស់​អ្នក',
	'imstatus_gtalk_height' => 'កម្ពស់​នៃ​ប្រអប់, គិតជា​ភីកសែល',
	'imstatus_gtalk_width' => 'ទទឹង​នៃ​ប្រអប់, គិតជា​ភីកសែល',
	'imstatus_icq_id' => 'អត្តលេខ ICQ របស់​អ្នក',
	'imstatus_xfire_size' => 'ទំហំ​ប៊ូតុង, ពី $1 (ធំបំផុត) ទៅ $2 (តូចបំផុត) ។',
	'imstatus_yahoo_style' => 'រចនាប័ទ្ម​ប៊ូតុង, ពី $1 (ធំបំផុត) ទៅ $2 (តូចបំផុត), $3 និង $4 គឺ​សម្រាប់​សារជាសំឡេង​។',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'imstatus-desc' => 'Brängk Befähle en et Wiki, öm der Online-Stattus en diverse <i lang="en">instant messengers (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)</i> ze zeije.',
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Shtandatt',
	'imstatus_example' => 'Bäijshpell',
	'imstatus_possible_val' => 'Müjjelesche Wääte',
	'imstatus_max' => 'et Hühßte',
	'imstatus_min' => 'et Winnishßte',
	'imstatus_or' => 'udder',
	'imstatus_style' => 'Shtiil för et Aanzäije',
	'imstatus_action' => 'wat sull paßeere, wam_mer drop kleck',
	'imstatus_details_saa' => 'Mieh övver et Ußsinn un de Annzäije, un wat se donn künne, kanns De op $1 fenge.',
	'imstatus_your_name' => 'Dinge Name op $1',
	'imstatus_aim_presence' => '$1 zäijsch Dinge Shtattus met enem Lengk, dä dä AIM aanwerrfe deiht, öm Der en Nohresch ze schecke — wann dä drop kleck, en och op singem Rääschner enshtalleet hät.',
	'imstatus_aim_api' => '$1 zäijsch Dinge Shtattus met enem Lengk, dä ene JavaScrip-Väsjohn fum AIM en Dingem Brauser aanwerrfe deiht, öm Der en Nohresch ze schecke.',
	'imstatus_gtalk_code' => 'Dinge <i lang="en">Google</i>-Klaaf-<i lang="en">Code</i>',
	'imstatus_gtalk_get_code' => 'Dinge <i lang="en">Google</i>-Klaaf-<i lang="en">Code</i> kriß De bäij $1.',
	'imstatus_gtalk_height' => 'Däm Kaste sing Hühde en Pixelle.',
	'imstatus_gtalk_width' => 'Däm Kaste sing Breed en Pixelle.',
	'imstatus_icq_id' => 'Ding ICQ-Kennung',
	'imstatus_icq_style' => 'En Zahl zwesche 0 un 26, et jitt nämmlesch 27 einzel Aate.',
	'imstatus_live_code' => 'Ding <i lang="en">Live Messenger Website-ID</i>',
	'imstatus_live_get_code' => 'Ding <i lang="en">Live Messenger Website-ID</i> — <strong>es nit Dinge e-mail-Address</strong> —
kanns De en <a href="$1">Dinge <i lang="en">Live Messenger</i> Enstellunge</a> maache lohße.
Wat De hee aanjevve moß, sen de Bochstave un Zahle zwesche „$2“ und „$3“.',
	'imstatus_skype_nbstyle' => "'''Opjepaß:''' Wann De Der en Aanzeisch ußsökß, woh ene Akßjuhn met enjeschloße es,
dann es ejal, wat De sellve hee för Dinge Lengk för en Akßjuhn ußjesooht häs.
De Akßjuhn en dä Aanzeisch weet jenumme.",
	'imstatus_xfire_size' => 'wi jruuß dä Knopp sinn sull, fum jrüüßte ($1) beß nohm kleijnßte ($2)',
	'imstatus_yahoo_style' => 'wi dä Knopp ußsinn sull, fum kleijnßte ($1) beß nohm jrüüßte ($2) — ($3) un ($4) sin för <i lang="en">voicemail</i>.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Beispill',
	'imstatus_possible_val' => 'Méiglech Werter',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'oder',
	'imstatus_your_name' => 'ären $1 Numm',
	'imstatus_gtalk_code' => 'Äre Google Talk Code',
	'imstatus_gtalk_height' => 'Höicht vun der Këscht a Pixel.',
	'imstatus_gtalk_width' => 'Breet vun der Këscht, a Pixel.',
	'imstatus_icq_id' => 'är ICQ ID',
	'imstatus_icq_style' => 'eng Zuel tëschent 0 a 26 (jo, et gëtt 27 verschidde Stylen ...).',
);

/** Macedonian (Македонски)
 * @author Brest
 */
$messages['mk'] = array(
	'imstatus_syntax' => 'Синтакса',
	'imstatus_default' => 'Основно',
	'imstatus_example' => 'Пример',
	'imstatus_possible_val' => 'Можни вредности',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'или',
	'imstatus_style' => 'стил на статус индикаторот',
	'imstatus_action' => 'акција кога ќе се кликне на копчето',
	'imstatus_your_name' => 'вашето $1 име',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'imstatus_max' => 'весемеде ламо',
	'imstatus_min' => 'весемеде аламо',
	'imstatus_or' => 'эли',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'imstatus_or' => 'nozo',
	'imstatus_your_name' => '$1 motōca',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'imstatus-desc' => 'Voegt tags toe voor de weergave van de online status voor IM (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire en Yahoo)',
	'imstatus_syntax' => 'Syntaxis',
	'imstatus_default' => 'Standaard',
	'imstatus_example' => 'Voorbeeld',
	'imstatus_possible_val' => 'Mogelijke waarden',
	'imstatus_max' => 'max.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'of',
	'imstatus_style' => 'stijl van de statusindicator',
	'imstatus_action' => 'actie als op de knop wordt geklikt',
	'imstatus_details_saa' => 'Zie $1 voor meer details over alle stijlen en acties.',
	'imstatus_your_name' => 'uw naam bij $1',
	'imstatus_aim_presence' => '$1 toont uw status met een verwijzing die AIM zal opstarten om u een IM te sturen, indien de gebruiker het geïnstalleerd heeft.',
	'imstatus_aim_api' => '$1 toont uw status met een verwijzing die een <b>browser</b> zal opstarten, javascriptversie van AIM om u een IM te sturen.',
	'imstatus_gtalk_code' => 'uw Google Talk-code',
	'imstatus_gtalk_get_code' => 'uw Google Talk-code: ontvang het op $1.',
	'imstatus_gtalk_height' => 'hoogte van de box, in pixels.',
	'imstatus_gtalk_width' => 'breedte van de box, in pixels.',
	'imstatus_icq_id' => 'uw ICQ-nummer',
	'imstatus_icq_style' => 'een getal ergens tussen 0 en 26 (ja, er zijn 27 beschikbare stijlen...).',
	'imstatus_live_code' => 'uw Live Messenger-websitenummer',
	'imstatus_live_get_code' => 'uw Live Messenger-websitenummer: <strong>dit is niet uw e-mailadres</strong>, u moet er één genereren in <a href="$1">uw Live Messenger-opties</a>.
Het nummer dat u moet opgeven is de nummers en letters tussen "$2" en "$3".',
	'imstatus_skype_nbstyle' => 'Opmerking: als u een stijl kiest die ook een actie is, zal uw actiekeuze overschreven worden door de actie die past bij uw gekozen stijl.',
	'imstatus_xfire_size' => 'de grootte van de knop, van $1 (grootst) tot $2 (kleinst)',
	'imstatus_yahoo_style' => 'de stijl van de knop, van $1 (kleinste) tot $2 (grootste), $3 en $4 voor voicemail.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'imstatus-desc' => 'Legg til merke for å visa forskjellige påloggingstatusar i direktemeldingsprogram (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntaks',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Døme',
	'imstatus_possible_val' => 'Moglege verdiar',
	'imstatus_max' => 'høgst',
	'imstatus_min' => 'minst',
	'imstatus_or' => 'eller',
	'imstatus_style' => 'stilen til statusindikatoren',
	'imstatus_action' => 'handling når knappen blir trykt på',
	'imstatus_details_saa' => 'For fleire detaljar om alle stilane og handlingane, sjå $1.',
	'imstatus_your_name' => 'ditt $1 namn',
	'imstatus_aim_presence' => '$1 syner statusen din med ei lenkja som vil fyra i gang AIM for å senda deg ei direktemelding, gjeve at brukaren har det installert.',
	'imstatus_aim_api' => '$1 syner statusen din med ei lenkja som vil fyra i gang ein <b>nettlesar</b>-javascript-versjon av AIM for å senda deg ei direktemelding.',
	'imstatus_gtalk_code' => 'google talk-koden din',
	'imstatus_gtalk_get_code' => 'google talk-koden din: få han på $1.',
	'imstatus_gtalk_height' => 'høgda til boksen i pikslar',
	'imstatus_gtalk_width' => 'breidda til boksen i pikslar',
	'imstatus_icq_id' => 'din ICQ-ID',
	'imstatus_icq_style' => 'eit tal i intervallet 0-26 (ja, det finst 27 tilgjengeleg stilar...).',
	'imstatus_live_code' => "ID'en til Live Messenger-nettstaden din",
	'imstatus_live_get_code' => 'ID\'en til Live Messenger-nettstaden din: <strong>dette er ikkje e-postadressa di</strong>, du må laga ein i 
<a href="$1">live messenger-vala dine</a>.
ID\'en du må oppgje er tala og bokstavane mellom  «$2» og «$3».',
	'imstatus_skype_nbstyle' => 'Merk: Om du vel ein stil som òg er ei handling, vil handlingsvalet ditt bli overkøyrt av handlinga som samsvarer med stilvalet ditt.',
	'imstatus_xfire_size' => 'knappestorleiken, frå $1 (størst) til $2 (minst).',
	'imstatus_yahoo_style' => 'knappestilen, frå $1 (minst) til $2 (størst), $3 og $4 er for lydpost.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'imstatus-desc' => 'Apond de balisas que mostran l’estat en linha sus divèrses reds de comunicacion (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Sintaxi',
	'imstatus_default' => 'Per defaut',
	'imstatus_example' => 'Exemple',
	'imstatus_possible_val' => 'Valors possiblas',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'o',
	'imstatus_style' => 'estil de l’indicador d’estat',
	'imstatus_action' => 'accion quand lo boton es clicat',
	'imstatus_details_saa' => 'Per mai de detalhs al subjècte dels estils e accions, consultatz $1.',
	'imstatus_your_name' => 'vòstre nom $1',
	'imstatus_aim_presence' => "$1 aficha vòstre estat amb un ligam qu'aviarà AIM per vos mandar un messatge instantanèu, baste que l’utilizaire l’aja installat.",
	'imstatus_aim_api' => "$1 aficha vòstre estat amb un ligam qu'aviarà dins un <b>navigador</b> una version javascript de AIM per vos mandar un messatge instantanèu.",
	'imstatus_gtalk_code' => 'vòstre còde Google Talk',
	'imstatus_gtalk_get_code' => 'vòstre còde Google Talk : obtenètz-lo sus $1.',
	'imstatus_gtalk_height' => 'nautor de la boita, en pixèls.',
	'imstatus_gtalk_width' => 'largor de la boita, en pixèls.',
	'imstatus_icq_id' => 'vòstre identificant ICQ',
	'imstatus_icq_style' => 'un nombre entre 0 e 26 (òc, i a 27 estils disponibles...).',
	'imstatus_live_code' => 'vòstre identificant sul sit Live Messenger',
	'imstatus_live_get_code' => 'vòstre identificant sul sit Live Messenger : <strong>es pas vòstra adreça de messatjariá</strong>, vos ne cal generir un dins <a href="$1">vòstras opcions Live Messenger</a>.
L’identificant de provesir aicí es compausat de chifras e letras entre « $2 » e « $3 ».',
	'imstatus_skype_nbstyle' => "Nòta : se causissètz un estil que tanben es una accion, vòstra causida d’accion serà espotida per l’accion que correspond a l'estil qu'avètz causit.",
	'imstatus_xfire_size' => 'la talha del boton, de $1 (la mai granda) a $2 (la mai pichona).',
	'imstatus_yahoo_style' => "l'estil del boton, de $1 (lo mai pichon) a $2 (lo mai grand), $3 e $4 son pels messatges vocals.",
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 */
$messages['pl'] = array(
	'imstatus-desc' => 'Dodaje znaczniki, by pokazać statusy w różnego rodzaju komunikatorach internetowych (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Składnia',
	'imstatus_default' => 'Domyślny',
	'imstatus_example' => 'Przykład',
	'imstatus_possible_val' => 'Możliwe wartości',
	'imstatus_max' => 'maksimum',
	'imstatus_min' => 'minimum',
	'imstatus_or' => 'lub',
	'imstatus_style' => 'styl wskaźnika statusu',
	'imstatus_action' => 'działanie, kiedy zostanie kliknięty przycisk',
	'imstatus_details_saa' => 'Aby uzyskać więcej informacji na temat wszystkich stylów i działania, zobacz $1.',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'imstatus-desc' => 'Adiciona marcas (tags) para mostrar vários estados de ligação de IM (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Sintaxe',
	'imstatus_default' => 'Padrão',
	'imstatus_example' => 'Exemplo',
	'imstatus_possible_val' => 'Valores possíveis',
	'imstatus_max' => 'máx',
	'imstatus_min' => 'mín',
	'imstatus_or' => 'ou',
	'imstatus_style' => 'estilo do indicador de estado',
	'imstatus_action' => 'acção quando o botão é pressionado',
	'imstatus_details_saa' => 'Para mais detalhes sobre todos os estilos e acções, veja $1.',
	'imstatus_your_name' => 'o seu nome $1',
	'imstatus_aim_presence' => '$1 mostra o seu estado com uma ligação que iniciará o AIM para lhe enviar uma IM, desde que o utilizador o tenha instalado.',
	'imstatus_aim_api' => '$1 mostra o seu estado com uma ligação que iniciará uma versão Javascript do AIM num <b>navegador</b> para lhe enviar uma IM.',
	'imstatus_gtalk_code' => 'o seu código Google Talk',
	'imstatus_gtalk_get_code' => 'o seu código Google Talk: obtenha-o em $1.',
	'imstatus_gtalk_height' => 'altura da caixa, em pixels.',
	'imstatus_gtalk_width' => 'largura da caixa, em pixels.',
	'imstatus_icq_id' => 'o seu ID do ICQ',
	'imstatus_icq_style' => 'um número entre 0 e 26 (sim, existem 27 estilos disponíveis...).',
	'imstatus_live_code' => 'o seu ID do sítio Live Messenger',
	'imstatus_live_get_code' => 'o seu ID do sítio Live Messenger: <strong>não é o seu endereço de e-mail</strong>, precisará de gerar um nas <a href="$1">opções do seu Live Messenger</a>.
O ID que você precisa de fornecer consiste em números e letras entre "$2" e "$3".',
	'imstatus_skype_nbstyle' => 'Nota: Se escolher um estilo que seja também uma acção, a sua escolha de acção será suplantada pela acção que corresponda ao seu estilo escolhido.',
	'imstatus_xfire_size' => 'o tamanho do botão, de $1 (maior) a $2 (menor).',
	'imstatus_yahoo_style' => 'o estilo do botão, de $1 (menor) a $2 (maior), $3 e $4 são para correio de voz.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'imstatus_syntax' => 'Sintaxă',
	'imstatus_default' => 'Implicit',
	'imstatus_example' => 'Exemplu',
	'imstatus_possible_val' => 'Valori posibile',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'sau',
	'imstatus_icq_style' => 'un număr între 0 şi 26 (da, există 27 de stiluri disponibile...).',
	'imstatus_xfire_size' => 'mărimea butoanelor, de la $1 (cel mai mare) la $2 (cel mai mic).',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'imstatus_syntax' => 'Sindasse',
	'imstatus_default' => 'De base',
	'imstatus_example' => 'Esembije',
	'imstatus_possible_val' => 'Valore possibbele',
	'imstatus_max' => 'massime',
	'imstatus_min' => 'minime',
	'imstatus_or' => 'o',
	'imstatus_style' => "stile d'u sione de state",
	'imstatus_action' => "azione quanne 'u bottone avène cazzete",
	'imstatus_details_saa' => "Pe cchiù dettaglie sus a le stile e l'aziune, vide $1.",
	'imstatus_your_name' => "'u $1 nome tue",
	'imstatus_aim_presence' => "$1 fece vedè 'u state cu 'nu collegamende ca fece partè AIM pe te manna 'nu IM (messagge istandanee), sembre ca l'utende l'ha installete.",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'imstatus_syntax' => 'Синтаксис',
	'imstatus_default' => 'По умолчанию',
	'imstatus_example' => 'Пример',
	'imstatus_possible_val' => 'Возможные значения',
	'imstatus_max' => 'макс.',
	'imstatus_min' => 'мин.',
	'imstatus_or' => 'или',
	'imstatus_style' => 'стиль индикатора состояния',
	'imstatus_icq_id' => 'ваш ICQ ID',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'imstatus-desc' => 'Pridáva značky zobrazujúce stav prítomnosti používateľa roznych IM sietí (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Štandardné',
	'imstatus_example' => 'Príklad',
	'imstatus_possible_val' => 'Možné hodnoty',
	'imstatus_max' => 'max.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'alebo',
	'imstatus_style' => 'štýl indikátora stavu',
	'imstatus_action' => 'operácia po kliknutí tlačidla',
	'imstatus_details_saa' => 'Podrobnosti o štýloch a operáciách nájdete na $1.',
	'imstatus_your_name' => 'vaše meno na $1',
	'imstatus_aim_presence' => '$1 zobrazuje váš stav prítomnosti s odkazom, ktorý spustí odoslanie správy v AIM ak ho má používateľ nainštalovaný.',
	'imstatus_aim_api' => '$1 zobrazuje váš stav prítomnosti s odkazom, ktorý spustí odoslanie správy vo <b>webovom prehliadači</b>, javascriptovej verzii AIM.',
	'imstatus_gtalk_code' => 'váš kód Google Talk',
	'imstatus_gtalk_get_code' => 'Svoj kód Google Talk získate na $1.',
	'imstatus_gtalk_height' => 'výška obdĺžnika v pixeloch',
	'imstatus_gtalk_width' => 'šírka obdĺžnika v pixeloch',
	'imstatus_icq_id' => 'váš ICQ identifikátor',
	'imstatus_icq_style' => 'číslo v rozsahu 0-26 (áno, to je 27 dostupných štýlov...).',
	'imstatus_live_code' => 'váš identifikátor na webe Live Messenger',
	'imstatus_live_get_code' => 'váš identifikátor na webe Live Messenger: <strong>toto nie je vaša emailová adresa</strong>, musíte si ju vytvoriť <a href="$1">vo svojich nastaveniach Live Messenger</a>.
Identifikátor, ktorý musíte zadať, sú písmená a číslice medzi „$2” a „$3”.',
	'imstatus_skype_nbstyle' => 'Pozn.: Ak si zvolíte štýl, ktorý je aj operáciou, pred vašou voľbou operácie bude mať prednosť operácia zodpovedajúca zvolenému štýlu.',
	'imstatus_xfire_size' => 'veľkosť tlačidla od $1 (najväčšia) do $2 (najmenšia).',
	'imstatus_yahoo_style' => 'štýl tlačidla od $1 (najväčší) do $2 (najmenší). $3 a $4 slúžia pre hlasovú poštu.',
);

/** Swedish (Svenska)
 * @author Najami
 */
$messages['sv'] = array(
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Exempel',
	'imstatus_max' => 'högst',
	'imstatus_min' => 'minst',
	'imstatus_or' => 'eller',
	'imstatus_your_name' => 'ditt $1 namn',
	'imstatus_gtalk_code' => 'din google talk-kod',
	'imstatus_gtalk_get_code' => 'din google talk-kod: få den på $1.',
	'imstatus_gtalk_height' => 'boxens höjd, i pixlar.',
	'imstatus_gtalk_width' => 'boxens bredd, i pixlar.',
	'imstatus_icq_id' => 'ditt ICQ-ID',
	'imstatus_xfire_size' => 'knappens storlek, från $1 (störst) till $2 (minst).',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'imstatus_example' => 'ఉదాహరణ',
	'imstatus_max' => 'గరిష్ఠ',
	'imstatus_min' => 'కనిష్ఠ',
	'imstatus_or' => 'లేదా',
	'imstatus_your_name' => 'మీ $1 పేరు',
	'imstatus_gtalk_height' => 'పెట్టె యొక్క ఎత్తు, పిక్సెళ్ళలో.',
	'imstatus_gtalk_width' => 'పెట్టె యొక్క వెడల్పు, పిక్సెళ్ళలో.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'imstatus-desc' => 'Nagdaragdag ng mga tatak upang maipakita ang sari-saring mga katayuan ng pagkakakonekta sa linya ng IM (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Palaugnayan',
	'imstatus_default' => 'Nakatakda',
	'imstatus_example' => 'Halimbawa',
	'imstatus_possible_val' => 'Maaaring maging mga halaga',
	'imstatus_max' => 'pinakamataas',
	'imstatus_min' => 'pinakamababa',
	'imstatus_or' => 'o',
	'imstatus_style' => 'estilo ng tagasabi ng kalagayan',
	'imstatus_action' => 'galaw kapag pinindot ang pindutan',
	'imstatus_details_saa' => 'Para sa mas marami pang mga detalye hinggil sa lahat ng mga estilo at mga galaw, tingnan ang $1.',
	'imstatus_your_name' => 'ang pangalan mong $1',
	'imstatus_aim_presence' => 'Ipinapakita ng $1 ang katayuan mo na may isang kawing na maglulunsad sa AIM upang mapadalhan ka ng isang IM, kung iniluklok/ini-instala ito ng tagagamit.',
	'imstatus_aim_api' => "Ipinapakita ng $1 ang katayuan mo na may isang kawing na maglulunsad sa isang <b>pantingin-tingin (''browser'')</b>, bersyong ''javascript'' ng AIM upang mapadalhan ka ng isang IM.",
	'imstatus_gtalk_code' => "ang kodigong pang-usapang ''google'' mo",
	'imstatus_gtalk_get_code' => "ang kodigong pang-usapang ''google'' mo: kunin ito mula sa $1.",
	'imstatus_gtalk_height' => 'taas ng kahon, sa mga piksel.',
	'imstatus_gtalk_width' => 'lapad ng kahon, sa mga piksel.',
	'imstatus_icq_id' => 'ang iyong ID na pang-ICQ',
	'imstatus_icq_style' => 'isang bilang na sumasakop mula 0 hanggang 26 (oo, mayroong makukuhang 27 mga estilo...).',
	'imstatus_live_code' => "ang id mong pang-websayt na \"Buhay na Mensahero\" (''Live Messenger'')",
	'imstatus_live_get_code' => 'ang iyong id na pang-"Buhay na Mensahero" (\'\'Live Messenger\'\'): <strong>hindi ito ang adres ng e-liham mo</strong>, kailangan mong lumikha ng isa sa
<a href="$1">mga pagpipilian mong pang-"buhay na mensahero"</a>.
Ang id na dapat mong ibigay ay ang mga bilang at mga titik na nasa pagitan ng "$2" at "$3".',
	'imstatus_skype_nbstyle' => 'Paunawa: Kapag pinili mo ang isang estilong isa rin galaw, ang napili mong galaw ay madaraig (mapapangingibabawan) ng galaw na tumutugma sa iyong piniling estilo.',
	'imstatus_xfire_size' => 'sukat ng pindutan, mula $1 (pinakamalaki) hanggang $2 (pinakamaliit).',
	'imstatus_yahoo_style' => 'estilo ng pindutan, mula $1 (pinakamaliit) hanggang $2 (pinakamalaki), para sa "liham na may tinig" (\'\'voicemail\'\') ang $3 at $4.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'imstatus-desc' => 'Thêm thẻ trạng thái của các dịch vụ tin nhắn nhanh (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo!)',
	'imstatus_syntax' => 'Cú pháp',
	'imstatus_default' => 'Mặc định',
	'imstatus_example' => 'Ví dụ',
	'imstatus_possible_val' => 'Các giá trị được chấp nhận',
	'imstatus_max' => 'tối đa',
	'imstatus_min' => 'tối thiểu',
	'imstatus_or' => 'hoặc',
	'imstatus_style' => 'kiểu nút trạng thái',
	'imstatus_action' => 'tác động khi bấm nút',
	'imstatus_details_saa' => 'Xem chi tiết về các kiểu và tác động tại $1.',
	'imstatus_your_name' => 'tên $1 của bạn',
	'imstatus_aim_presence' => '$1 hiển thị trạng thái của bạn dùng một liên kết, liên kết này sẽ chạy AIM để nhắn tin cho bạn, miễn là người dùng đã cài đặt nó.',
	'imstatus_aim_api' => '$1 hiển thị trạng thái của bạn dùng một liên kết, liên kết này sẽ chạy AIM <b>trong trình duyệt</b> và dùng JavaScript để nhắn tin cho bạn.',
	'imstatus_gtalk_code' => 'mã Google Talk của bạn',
	'imstatus_gtalk_get_code' => 'mã Google Talk của bạn (lấy từ $1).',
	'imstatus_gtalk_height' => 'chiều cao của hộp (pixel).',
	'imstatus_gtalk_width' => 'chiều ngang của hộp (pixel).',
	'imstatus_icq_id' => 'ID của bạn trên ICQ',
	'imstatus_icq_style' => 'số trong dãy từ 0 đến 26 (có 27 kiểu chứ…).',
	'imstatus_live_code' => 'ID website của bạn trên Live Messenger',
	'imstatus_live_get_code' => 'ID website của bạn trên Live Messenger: <strong>đây không phải là địa chỉ thư điện tử của bạn</strong>! Bạn cần phải tạo ra ID ở trang <a href="$1">tùy chọn Live Messenger</a>. Bạn cần cho vào ID có các số và chữ từ “$2” đến “$3”.',
	'imstatus_skype_nbstyle' => 'Chú ý: Nếu bạn chọn cùng kiểu cùng tác động, tác động của kiểu được chọn sẽ được sử dụng, thay vì tác động được chọn.',
	'imstatus_xfire_size' => 'cỡ nút, từ $1 (lớn nhất) đến $2 (nhỏ nhất).',
	'imstatus_yahoo_style' => 'kiểu nút, từ $1 (nhỏ nhất) đến $2 (lớn nhất); $3 và $4 dành cho thư thoại.',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'imstatus-desc' => '增加了显示各种即时通讯软件在线状态标签（例如AIM、Google Talk、ICQ、MSN/Live Messenger、Skype、Xfire、Yahoo）',
	'imstatus_syntax' => '语法',
	'imstatus_default' => '默认',
	'imstatus_example' => '例子',
	'imstatus_possible_val' => '可能值',
	'imstatus_max' => '最大',
	'imstatus_min' => '最小',
	'imstatus_or' => '或者',
	'imstatus_style' => '状态指示符的样式',
	'imstatus_action' => '当按钮按下时，就',
	'imstatus_details_saa' => '如要获得更多关于样式和动作的信息，请参见$1。',
	'imstatus_your_name' => '您的$1名称',
	'imstatus_aim_presence' => '$1显示了您的状态，并提供了一个链接，以便那些安装了AIM的用户可以直接发给您一个即时信息。',
	'imstatus_aim_api' => '$1显示了您的状态，并提供了一个链接，以启动<b>浏览器</b>，通过javascript版本的AIM发给您一个即时信息。',
	'imstatus_gtalk_code' => '您的Google Talk代码',
	'imstatus_gtalk_get_code' => '您的Google Talk代码：在$1获得它。',
	'imstatus_gtalk_height' => '箱体的高度，单位为pixel。',
	'imstatus_gtalk_width' => '箱体的宽度，单位为pixel。',
	'imstatus_icq_id' => '您的ICQ ID',
	'imstatus_icq_style' => '范围从0到26（没错，一共有27种样式可供选择……）。',
	'imstatus_live_code' => '您的Live Messenger网站ID',
	'imstatus_live_get_code' => '您的Live Messenger网站ID：<strong>并不是您的电子邮件地址</strong>，您需要在<a href="$1">您的live messenger选项
</a>中生成。
需要提供的ID由"$2"和"$3"之间的数字、字母组成。',
	'imstatus_xfire_size' => '按钮的大小，可从 $1 (最大) 到 $2 (最小)供选择。',
);

