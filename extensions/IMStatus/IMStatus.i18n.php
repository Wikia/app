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
        'imstatus_icq_style' => 'a number ranging from 0 to 26 (yes, there are 27 available styles).',

        'imstatus_live_code' => 'your Live Messenger website id',
        'imstatus_live_get_code' => 'your Live Messenger website id: <strong>this is not your e-mail address</strong>, you need to generate one in
<a href="$1">your Live Messenger options</a>.
The id you need to provide is the numbers and letters between "$2" and "$3".',

        'imstatus_skype_nbstyle' => 'Note: If you choose a style which is also an action, your action choice will be overridden by the action matching your chosen style.',

        'imstatus_xfire_size' => 'the button size, from $1 (biggest) to $2 (smallest).',

        'imstatus_yahoo_style' => 'the button style, from $1 (smallest) to $2 (biggest), $3 and $4 are for voicemail.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Nghtwlkr
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'imstatus-desc' => 'Kort beskrivelse av IMStatus-utvidelsen, vist i [[Special:Version]].',
	'imstatus_default' => '{{Identical|Default}}',
	'imstatus_example' => '{{Identical|Example}}',
	'imstatus_or' => '{{Identical|Or}}',
	'imstatus_live_get_code' => 'The parameters are pieces of static text to help a user find what he needs.
* $1 is "http://settings.messenger.live.com/applications/CreateHtml.aspx"
* $2 is "invitee="
* $3 is "@apps.messenger"',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'imstatus_syntax' => 'Sintaks',
	'imstatus_default' => 'Standaard',
	'imstatus_example' => 'Voorbeeld',
	'imstatus_possible_val' => 'Moontlike waardes',
	'imstatus_max' => 'maks.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'of',
	'imstatus_your_name' => 'u naam by $1',
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

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'imstatus_max' => 'ܡܬܚܐ ܥܠܝܐ',
	'imstatus_min' => 'ܡܬܚܐ ܬܚܬܝܐ',
	'imstatus_or' => 'ܐܘ',
	'imstatus_your_name' => 'ܫܡܐ $1 ܕܝܠܟ',
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
	'imstatus_yahoo_style' => 'أسلوب الزر، من $1 (أصغر) إلى $2 (أكبر)، $3 و $4 هما للبريد الصوتى.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Vago
 */
$messages['az'] = array(
	'imstatus_max' => 'maks',
	'imstatus_min' => 'min',
	'imstatus_or' => 'və ya',
	'imstatus_your_name' => 'sizin $1 adınız',
	'imstatus_icq_id' => 'sizin ICQ ID',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'imstatus-desc' => 'Дадае тэгі для паказу анлайн-статусу розных інтэрнэт-камунікатараў (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Сынтаксіс',
	'imstatus_default' => 'Па змоўчваньні',
	'imstatus_example' => 'Прыклад',
	'imstatus_possible_val' => 'Магчымыя значэньні',
	'imstatus_max' => 'максымум',
	'imstatus_min' => 'мінімум',
	'imstatus_or' => 'ці',
	'imstatus_style' => 'стыль індыкатара статусу',
	'imstatus_action' => 'дзеяньне, калі будзе націснутая кнопка',
	'imstatus_details_saa' => 'Дадатковай інфармацыю пра ўсе стылі і дзеяньні, глядзіце на $1.',
	'imstatus_your_name' => 'Ваша $1 імя',
	'imstatus_aim_presence' => '$1 паказвае Ваш статус са спасылкай, якая запускае AIM для дасылкі Вам паведамленьня, пры ўмове што ўдзельнік яго ўсталяваў.',
	'imstatus_aim_api' => '$1 паказвае Ваш статус са спасылкай якая запускае <b>браўзэр</b>, дзе javascript-вэрсія AIM дасылае Вам паведамленьне.',
	'imstatus_gtalk_code' => 'Ваш код у google talk',
	'imstatus_gtalk_get_code' => 'Ваш код у google talk: атрымаць на $1.',
	'imstatus_gtalk_height' => 'вышыня акенца ў піксэлях.',
	'imstatus_gtalk_width' => 'шырыня акенца ў піксэлях.',
	'imstatus_icq_id' => 'Ваш ідэнтыфікатар ICQ',
	'imstatus_icq_style' => 'лічба з дыяпазону ад 0 да 26 (так, ёсьць 27 даступных стыляў).',
	'imstatus_live_code' => 'Ваш ідэнтыфікатар на сайце Live Messenger',
	'imstatus_live_get_code' => 'Ваш ідэнтыфікатар на сайце Live Messenger: <strong>гэта ня Ваш адрас электроннай пошты</strong>, Вам неабходна стварыць яго у
<a href="$1">Вашых настройках Live Messenger</a>.
Неабходны Вам ідэнтыфікатар складаецца з лічбаў і літар з дыяпазону паміж «$2» і «$3».',
	'imstatus_skype_nbstyle' => 'Заўважце: калі Вы выберыце стыль, які зьяўляецца дзеяньнем, Ваш выбар дзеяньня будзе пераназначаны дзеяньнем, якое адпавядае выбранаму стылю.',
	'imstatus_xfire_size' => 'памер кнопкі, ад $1 (самы вялікі) да $2 (самы малы).',
	'imstatus_yahoo_style' => 'стыль кнопкі ад $1 (самы малы) да $2 (самы вялікі), $3 і $4 ужываюцца для галасавой пошты.',
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

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'imstatus_syntax' => 'সিনট্যাক্স',
	'imstatus_default' => 'পূর্বনির্ধারিত',
	'imstatus_example' => 'উদাহরণ',
	'imstatus_possible_val' => 'সম্ভব্য মান',
	'imstatus_max' => 'সর্বোচ্চ',
	'imstatus_min' => 'নূন্যতম',
	'imstatus_or' => 'অথবা',
	'imstatus_your_name' => 'আপনার $1 নাম',
	'imstatus_gtalk_code' => 'আপনার গুগল টক কোড',
	'imstatus_gtalk_get_code' => 'আপনার গুগল টক কো: $1-এ এটি পাবেন।',
	'imstatus_gtalk_height' => 'বক্সের উচ্চতা (পিক্সেলে)।',
	'imstatus_gtalk_width' => 'বক্সের প্রস্থ (পিক্সেলে)।',
	'imstatus_icq_id' => 'আপনার আইসিকিউ আইডি',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'imstatus-desc' => 'Ouzhpennañ balizennoù evit diskouez enlinenn ar statud (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Ereadur',
	'imstatus_default' => 'Dre ziouer',
	'imstatus_example' => 'Skouer',
	'imstatus_possible_val' => 'Talvoudennoù posupl',
	'imstatus_max' => 'muiañ',
	'imstatus_min' => 'nebeutañ',
	'imstatus_or' => 'pe',
	'imstatus_style' => 'stil ar merker statud',
	'imstatus_action' => "obererezh pa 'vez kliket ar bouton",
	'imstatus_details_saa' => "Evit kaout muioc'h a ditouroù diwar-benn ar stiloù hag an obererezhioù, kit wa welet $1.",
	'imstatus_your_name' => "hoc'h anv $1",
	'imstatus_aim_presence' => "$1 a ziskouez ho statud gant ul liamm hag a lañso AIM evit ma c'helfe un implijer kas deoc'h ur gemenadenn war eeun, m'en deus staliet pep tra.",
	'imstatus_aim_api' => '$1 a ziskouez ho statud gant ul liamm hag a lañso ur <b>merdeer</b>, un doare javascript eus AIM evit kas ur gemenadenn war eeun.',
	'imstatus_gtalk_code' => 'ho kod Google Talk',
	'imstatus_gtalk_get_code' => 'ho kod Google Talk : tapit anezhañ war $1.',
	'imstatus_gtalk_height' => 'uhelder ar boest, e piksel.',
	'imstatus_gtalk_width' => 'ledander ar boest, e piksel.',
	'imstatus_icq_id' => 'ho ID ICQ',
	'imstatus_icq_style' => 'un niver etre 0 ha 26 (ya, gellout a rit kaout 27 stil disheñvel).',
	'imstatus_live_code' => "ho ID war lec'hienn Live Messenger",
	'imstatus_live_get_code' => 'Ho ker tremen Live Messenger : <strong>n\'eo ket ho chomlec\'h postel</strong>, rankout a rit krouiñ unan en
<a href="$1">ho tibaboù Live Messenger</a>.
An ID ho peus da reiñ a zo savet gant sifroù ha lizherennoù etre "$2" ha "$3".',
	'imstatus_skype_nbstyle' => "Notenn : ma tibaboc'h ur stil hag a zo ivez un obererezh, ho tibab obererezh a vo flastret gant an obererezh a glot gant ar stil ho peus dibabet.",
	'imstatus_xfire_size' => 'ment ar bouton, eus $1 (an hini vrasañ) da $2 (an hini vihanañ).',
	'imstatus_yahoo_style' => 'doare ar bouton, eus $1 (an hini vihanañ) da $2 (an hini vrasañ), $3 ha $4 a zo kemennadennoù dre gomz.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'imstatus-desc' => 'Dodaje oznake za prikaz raznih online statusa za IM (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Sintaksa',
	'imstatus_default' => 'Pretpostavljeno',
	'imstatus_example' => 'Primjer',
	'imstatus_possible_val' => 'Moguće vrijednosti',
	'imstatus_max' => 'najviše',
	'imstatus_min' => 'najmanje',
	'imstatus_or' => 'ili',
	'imstatus_style' => 'stil statusnog pokazatelja',
	'imstatus_action' => 'akcija kada se klikne dugme',
	'imstatus_details_saa' => 'Za više detalja o svim stilovima i akcijama, pogledajte $1.',
	'imstatus_your_name' => 'Vaše $1 ime',
	'imstatus_aim_presence' => '$1 prikazuje Vaš status sa linkom koji će pokrenuti AIM da bi Vam poslao IM, koji je korisnik instalirao.',
	'imstatus_aim_api' => '$1 pokazuje Vaš status sa linkov koji pokreće <b>preglednik</b>, verziju javascript od AIM-a za slanje IM.',
	'imstatus_gtalk_code' => 'Vaš google talk kod',
	'imstatus_gtalk_get_code' => 'Vaš kod za google talk: uzmite ga na $1.',
	'imstatus_gtalk_height' => 'visina kutije, u pikselima.',
	'imstatus_gtalk_width' => 'širina kutije, u pikselima.',
	'imstatus_icq_id' => 'Vaš ICQ ID',
	'imstatus_icq_style' => 'broj između 0 i 26 (da, dostupno je 27 stilova...).',
	'imstatus_live_code' => 'vaš Live Messenger website id',
	'imstatus_live_get_code' => 'Vaš Live Messenger websajt id: <strong>ovo nije Vaša e-mail adresa</strong>, trebate da generišete jedan u <a href="$1">Vašim opcijama za live messenger</a>.
Id koji trebate da navedete su brojevi i slova između oznaka "$2" i "$3".',
	'imstatus_skype_nbstyle' => 'Napomena: Ako odaberete stil koji proizvodi akciju, Vaš izbor akcije će biti zamijenjen akcijom koja odgovara Vašem odabranom stilu.',
	'imstatus_xfire_size' => 'veličina dugmeta, od $1 (najveće) do $2 (najmanje).',
	'imstatus_yahoo_style' => 'stil dugmeta, od $1 (najmanje) do $2 (najveće), $3 i $4 su za zvučni mail.',
);

/** Catalan (Català)
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'imstatus_syntax' => 'Sintaxi',
	'imstatus_default' => 'Per defecte',
	'imstatus_example' => 'Exemple',
	'imstatus_possible_val' => 'Possibles valors',
	'imstatus_max' => 'màx',
	'imstatus_min' => 'mín',
	'imstatus_or' => 'o',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 * @author Utar
 */
$messages['cs'] = array(
	'imstatus-desc' => 'Přidává značky zobrazující stav přítomnosti uživatelů různých IM sítí (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo!)',
	'imstatus_syntax' => 'Syntaxe',
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
	'imstatus_icq_style' => 'číslo v rozsahu 0–26 (ano, je dostupných 27 stylů).',
	'imstatus_live_code' => 'váš identifikátor na webu Live Messenger',
	'imstatus_live_get_code' => 'váš identifikátor na webu Live Messenger: <strong>toto není vaše emailová adresa</strong>, musíte si ji vytvořit <a href="$1">ve svých nastaveních Live Messenger</a>.
Indentifikítor, který musíte zadat, jsou písmena a číslice mezi $2 a $3.',
	'imstatus_skype_nbstyle' => 'Poznámka: Pokud si zvolíte styl, který je i akcí, před vaší voublou akce bude mít přednost akce odpovídající zvolenému stylu.',
	'imstatus_xfire_size' => 'velikost tlačítka od $1 (největší) do $2 (nejmenší).',
	'imstatus_yahoo_style' => 'styl tlačítka od $1 (nejmenší) do $2 (největší), $3 a $4 slouží pro hlasovou poštu.',
);

/** German (Deutsch)
 * @author Purodha
 * @author Umherirrender
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
	'imstatus_gtalk_code' => 'dein Google-Talk-Code',
	'imstatus_gtalk_get_code' => 'deinen Google-Talk-Code erhälst du bei $1.',
	'imstatus_gtalk_height' => 'Höhe der Box in Pixel.',
	'imstatus_gtalk_width' => 'Breite der Box in Pixel.',
	'imstatus_icq_id' => 'deine ICQ-UIN',
	'imstatus_icq_style' => 'eine Zahl zwischen 0 und 26 (ja, es gibt 27 verschiedene Stile …).',
	'imstatus_live_code' => 'deine Live-Messenger-Website-ID',
	'imstatus_live_get_code' => 'deine Live-Messenger-Website-ID: <strong>Das ist nicht deine E-Mail-Adresse</strong>.
Du musst dir eine in den <a href="$1">Live-Messenger-Optionen</a> erstellen.
Die ID, die du benötigst, sind die Zahlen und Buchstaben zwischen „$2“ und „$3“.',
	'imstatus_skype_nbstyle' => 'Hinweis: wenn du einen Stil aussuchst, der auch eine Aktion beinhaltet, wird deine Aktionsauswahl durch die Aktion des Stiles ersetzt.',
	'imstatus_xfire_size' => 'die Größe der Schaltfläche, von $1 (größte) bis $2 (kleinste).',
	'imstatus_yahoo_style' => 'der Stil der Schaltfläche, von $1 (kleinste) bis $2 (größte), $3 und $4 sind für Voicemail.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'imstatus_your_name' => 'Ihr $1-Name',
	'imstatus_aim_presence' => '$1 zeigt Ihren Status mit einem Link, der AIM startet (sofern er installiert ist), um Ihnen eine Nachricht zu senden.',
	'imstatus_aim_api' => '$1 zeigt Ihren Status mit einem Link, der eine <b>Browser</b>, JavaScript Version von AIM, startet, um Ihnen eine Nachricht zu senden.',
	'imstatus_gtalk_code' => 'Ihr Google-Talk-Code',
	'imstatus_gtalk_get_code' => 'Ihren Google-Talk-Code erhalten Sie bei $1.',
	'imstatus_icq_id' => 'Ihre ICQ-UIN',
	'imstatus_live_code' => 'Ihre Live-Messenger-Website-ID',
	'imstatus_live_get_code' => 'Ihre Live-Messenger-Website-ID: <strong>Das ist nicht Ihre E-Mail-Adresse</strong>.
Sie müssen sich eine in den <a href="$1">Live-Messenger-Optionen</a> erstellen.
Die ID, die Sie benötigen, sind die Zahlen und Buchstaben zwischen „$2“ und „$3“.',
	'imstatus_skype_nbstyle' => 'Hinweis: wenn Sie einen Stil aussuchen, der auch eine Aktion beinhaltet, wird Ihre Aktionsauswahl durch die Aktion des Stiles ersetzt.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'imstatus-desc' => 'Pśidawa toflcki, aby pokazali onlinestatus wšakich internetnych powěstnikow (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntaksa',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Pśikład',
	'imstatus_possible_val' => 'Móžne gódnoty',
	'imstatus_max' => 'maks.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'abo',
	'imstatus_style' => 'stil statusowego pokazanja',
	'imstatus_action' => 'akcija pśi kliknjenju na tłocašk',
	'imstatus_details_saa' => 'Za dalšne drobnostki wo wšych stilach a akcijach, glědaj $1.',
	'imstatus_your_name' => 'twójo $1-mě',
	'imstatus_aim_presence' => '$1 pokazujo status z wótkazom, kótaryž buźo AIM startowaś, aby śi ned pósłał powěsć, jolic wužywaŕ jo jen instalěrował.',
	'imstatus_aim_api' => '$1 pokazujo twój status z wótkazom, kótaryž buźo <b>wobglědowak</b> startowaś, z javascriptoweju wersiju AIM, aby śi ned pósłał powěsć.',
	'imstatus_gtalk_code' => 'twój kod Google Talk',
	'imstatus_gtalk_get_code' => 'twój kod Google Talk: dostanjoš jen pla $1.',
	'imstatus_gtalk_height' => 'wusokosć kašćika w pikselach.',
	'imstatus_gtalk_width' => 'šyrokosć kašćika w pikselach.',
	'imstatus_icq_id' => 'twój ICQ-ID',
	'imstatus_icq_style' => 'licba mjazy 0 a 26 (jo, jo 27 k dispoziciji stojecych stilow...).',
	'imstatus_live_code' => 'twój websedłowy ID Live Messenger',
	'imstatus_live_get_code' => 'twój websedłowy ID Live Messenger: <strong>to njejo twója e-mailowa adresa</strong>, musyš jadnu w <a href="$1">twojich opcijach Live Messenger</a>.
ID, kótaryž musyš pódaś, su licby a pismiki mjazy "$2 a "$3".',
	'imstatus_skype_nbstyle' => 'Pokazka: Jolic wuběraš stil, kótaryž jo teke akcija, pśepišo se twój wuběrk akcijow pśez akciju, kótaryž wótpowědujo wubranemu stiloju.',
	'imstatus_xfire_size' => 'wulkosć tłocaška, wót $1 (nejwětša) do $2 (nejmjeńša).',
	'imstatus_yahoo_style' => 'stil tłocaška, wót $1 (nejmjeńšy) do $2 (nejwětšy), $3 a $4 stej za Voicemail.',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'imstatus_syntax' => 'Συντακτικό',
	'imstatus_default' => 'Προεπιλογή',
	'imstatus_example' => 'Παράδειγμα',
	'imstatus_possible_val' => 'Πιθανές τιμές',
	'imstatus_max' => 'μεγ',
	'imstatus_min' => 'ελαχ',
	'imstatus_or' => 'ή',
	'imstatus_your_name' => 'το όνομά σας $1',
	'imstatus_gtalk_height' => 'ύψος κουτιού σε πίξελ',
	'imstatus_gtalk_width' => 'πλάτος κουτιού σε πίξελ',
	'imstatus_icq_id' => 'η ταυτότητα ICQ σας',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'imstatus_syntax' => 'Sintakso',
	'imstatus_default' => 'Defaŭlta',
	'imstatus_example' => 'Ekzemplo',
	'imstatus_possible_val' => 'Eblaj valoroj',
	'imstatus_max' => 'maks',
	'imstatus_min' => 'min',
	'imstatus_or' => 'aŭ',
	'imstatus_your_name' => 'via $1 nomo',
	'imstatus_gtalk_height' => 'alto de la skatolo, laux rastumeroj.',
	'imstatus_gtalk_width' => 'larĝo de la kesto, je rastumeroj',
	'imstatus_icq_id' => 'via ID de ICQ',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Translationista
 */
$messages['es'] = array(
	'imstatus-desc' => 'Añade etiquetas para mostrar varios estados de mensajería instantánea en línea (AIM, Google Talk, ICQ, MSN / Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Sintaxis',
	'imstatus_default' => 'Por defecto',
	'imstatus_example' => 'Ejemplo',
	'imstatus_possible_val' => 'Valores posibles',
	'imstatus_max' => 'máximo',
	'imstatus_min' => 'mínimo',
	'imstatus_or' => 'o',
	'imstatus_style' => 'estilo del indicador de status',
	'imstatus_action' => 'acción cuando el botón está presionado',
	'imstatus_details_saa' => 'Para más detalles acerca de todos los estilos y acciones, vea $1.',
	'imstatus_your_name' => 'tu $1 nombre',
	'imstatus_aim_presence' => '$1 muestra tu status con un vínculo que ejecutará AIM para enviarte un mensaje instantáneo, siempre que el usuario lo haya instalado.',
	'imstatus_aim_api' => '$1 muestra tu estado con un vínculo que ejecutará un <b>navegador</b>, una versión JavaScript de AIM para enviarte un mensaje instantáneo.',
	'imstatus_gtalk_code' => 'tu código de discusión google',
	'imstatus_gtalk_get_code' => 'tu código de discusión google: obtenlo en $1.',
	'imstatus_gtalk_height' => 'altura de la tabla, en pixeles.',
	'imstatus_gtalk_width' => 'ancho de la tabla, en pixeles.',
	'imstatus_icq_id' => 'Tu ICQ ID',
	'imstatus_icq_style' => 'un número del 0 al 26 (sí, hay 27 estilos disponibles).',
	'imstatus_live_code' => 'tu ID de Live Messenger',
	'imstatus_live_get_code' => 'tu ID de Live Messenger: <strong>esta no es tu dirección de correo electrónico</strong>; debes generar uno <a href="$1">en tus opciones del Live Messenger</a>.El ID que debes proporcionar son los números y letras entre "$2" y "$3".',
	'imstatus_skype_nbstyle' => 'Observación: Si elige un estilo que sea también una acción, la acción elegida previamente será invalidada por la acción concordante con el estilo que elija.',
	'imstatus_xfire_size' => 'el tamaño del botón, de $1 (mayor) a $2 (menor).',
	'imstatus_yahoo_style' => 'el estilo del botón, de $1 (mayor) a $2 (menor), $3 y $4 son para correo de voz.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'imstatus_syntax' => 'Sintaxia',
	'imstatus_default' => 'Lehenetsia',
	'imstatus_example' => 'Adibidea',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'edo',
);

/** Persian (فارسی)
 * @author Mardetanha
 * @author Mjbmr
 */
$messages['fa'] = array(
	'imstatus_default' => 'پیش‌فرض',
	'imstatus_max' => 'حداکثر',
	'imstatus_min' => 'حداقل',
	'imstatus_or' => 'یا',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Vililikku
 * @author ZeiP
 */
$messages['fi'] = array(
	'imstatus-desc' => 'Lisää elementit monien pikaviestimien tilan näyttämiseen (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo).',
	'imstatus_syntax' => 'Syntaksi',
	'imstatus_default' => 'Oletus',
	'imstatus_example' => 'Esimerkki',
	'imstatus_possible_val' => 'Mahdolliset arvot',
	'imstatus_max' => 'enintään',
	'imstatus_min' => 'vähintään',
	'imstatus_or' => 'tai',
	'imstatus_style' => 'tilanilmaisimen tyyli',
	'imstatus_action' => 'toimenpide, kun painiketta napsautetaan',
	'imstatus_details_saa' => 'Lisätietoja kaikista tyyleistä ja toimenpiteistä löytyy sivulta $1.',
	'imstatus_your_name' => '$1-nimesi',
	'imstatus_aim_presence' => '$1 näyttää tilasi linkkinä, joka avaa AIM:n lähettämään sinulle pikaviestiä, jos käyttäjällä on se asennettuna.',
	'imstatus_aim_api' => '$1 näyttää tilasi linkkinä, joka avaa <b>selaimen</b> AIM:n JavaScript-versioon lähettämään sinulle pikaviestiä.',
	'imstatus_gtalk_code' => 'google talk -tunnuksesi',
	'imstatus_gtalk_get_code' => 'google talk -tunnuksesi: hanki se osoitteessa $1.',
	'imstatus_gtalk_height' => 'laatikon korkeus, pikseleinä.',
	'imstatus_gtalk_width' => 'laatikon leveys, pikseleinä.',
	'imstatus_icq_id' => 'ICQ-tunnuksesi',
	'imstatus_icq_style' => 'numero nollan ja 26:n väliltä (käytettävissä on siis 27 tyyliä).',
	'imstatus_live_code' => 'Live Messenger -sivuston tunnuksesi',
	'imstatus_live_get_code' => 'Live Messenger -sivuston tunnus: <strong>tämä ei ole sähköpostiosoitteesi</strong>. Sinun täytyy luoda se <a href="$1">Live Messenger -asetuksissasi</a>.
Tunnus, joka sinun pitää antaa, on numeroita ja kirjaimia merkkijonojen <code>$2</code> ja <code>$3</code> väliltä.',
	'imstatus_skype_nbstyle' => 'Huomaa: Jos valitset tyylin joka on myös toiminto, valitsemasi tyylin toiminto yliajaa valitsemasi toiminnon.',
	'imstatus_xfire_size' => 'painikkeen koko, $1:stä (suurin) $2:een (pienin).',
	'imstatus_yahoo_style' => 'painikkeen tyyli, $1:stä (pienin) $2:een (suurin), $3 ja $4 ovat äänivastaajalle.',
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
	'imstatus_aim_presence' => '$1 affiche votre état avec un lien qui lancera AIM pour permettre à un utilisateur de vous envoyer un message instantané, pourvu qu’il l’ait installé.',
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

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'imstatus_syntax' => 'Sintaxa',
	'imstatus_default' => 'Per dèfôt',
	'imstatus_example' => 'Ègzemplo',
	'imstatus_possible_val' => 'Valors possibles',
	'imstatus_max' => 'u més',
	'imstatus_min' => 'u muens',
	'imstatus_or' => 'ou ben',
	'imstatus_style' => 'stilo de l’endiquior d’ètat',
	'imstatus_action' => 'accion quand lo boton est clicâ',
	'imstatus_your_name' => 'voutron nom $1',
	'imstatus_gtalk_code' => 'voutron code Google Talk',
	'imstatus_gtalk_get_code' => 'voutron code Google Talk : avéd-lo dessus $1.',
	'imstatus_gtalk_height' => 'hôtior de la bouèta, en pixèls.',
	'imstatus_gtalk_width' => 'largior de la bouèta, en pixèls.',
	'imstatus_icq_id' => 'voutron numerô ICQ',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'imstatus-desc' => 'Engade etiquetas para mostrar varios estados de mensaxería instantánea (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
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
	'imstatus_aim_api' => '$1 mostra o seu estado cunha ligazón que executará un <b>navegador</b>, unha versión JavaScript de AIM para enviarlle unha mensaxe instantánea.',
	'imstatus_gtalk_code' => 'o código da súa conversa Google',
	'imstatus_gtalk_get_code' => 'o código da súa conversa Google: obtéñao en $1.',
	'imstatus_gtalk_height' => 'alto da caixa, en píxeles.',
	'imstatus_gtalk_width' => 'ancho da caixa, en píxeles.',
	'imstatus_icq_id' => 'o seu ID no ICQ',
	'imstatus_icq_style' => 'un número de 0 a 26 (si, hai dispoñibles 27 estilos...).',
	'imstatus_live_code' => 'o seu ID da páxina web do Live Messenger',
	'imstatus_live_get_code' => 'o seu ID da páxina web do Live Messenger: <strong>este non é o seu enderezo de correo electrónico</strong>, necesita xerar un <a href="$1">nas súas opcións do Live Messenger</a>.
O ID que precisa proporcionar son os números e letras entre "$2" e "$3".',
	'imstatus_skype_nbstyle' => 'Nota: se escolle un estilo que tamén sexa unha acción, a súa escolla da acción será sobrescrita pola acción que coincida co estilo elixido.',
	'imstatus_xfire_size' => 'o botón do tamaño, de $1 (o maior) a $2 (o menor).',
	'imstatus_yahoo_style' => 'o botón do estilo, de $1 (o menor) a $2 (o maior), $3 e $4 son para as mensaxes faladas.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'imstatus_syntax' => 'Σύνταξις',
	'imstatus_default' => 'Προκαθωρισμένη',
	'imstatus_max' => 'μέγ',
	'imstatus_min' => 'ἐλάχ',
	'imstatus_or' => 'ἢ',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'imstatus-desc' => 'Fiegt Tag zue go dr Online-Status vu verschidene Instant-Messenger aazeige (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Byyschpil',
	'imstatus_possible_val' => 'Megligi Wärt',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'oder',
	'imstatus_style' => 'Stil vu dr Status-Aazeig',
	'imstatus_action' => 'Aktion bim Drucke vu dr Schaltflächi',
	'imstatus_details_saa' => 'Wyteri Detail zue dr Stil un Aktione findsch uf: $1.',
	'imstatus_your_name' => 'Dyy $1-Name',
	'imstatus_aim_presence' => '$1 zeigt Dyy Status mit eme Gleich, wu AIM startet (wänn s inschtalliert isch) go Dir e Nochricht schicke.',
	'imstatus_aim_api' => '$1 zeigt Dyy Status mit eme Gleich, wu ne <b>Browser</b>, JavaScript-Version vu AIM, startet go Dir e Nochricht schicke.',
	'imstatus_gtalk_code' => 'Dyy Google-Talk-Code',
	'imstatus_gtalk_get_code' => 'Dyy Google-Talk-Code kriegsch bi $1.',
	'imstatus_gtalk_height' => 'Hechi vum Chaschte Pixel.',
	'imstatus_gtalk_width' => 'Breiti vum Chaschte in Pixel.',
	'imstatus_icq_id' => 'Dyy ICQ-UIN',
	'imstatus_icq_style' => 'e Zahl zwische 0 un 26 (jo, s git 27 verschideni Stil ...).',
	'imstatus_live_code' => 'Dyy Live Messenger Website-ID',
	'imstatus_live_get_code' => 'Dyy Live Messenger Website-ID: <strong>Des isch nit Dyy E-Mail-Adräss</strong>.
Du muesch Di eini in dr <a href="$1">Live Messenger Optione</a> aalege.
D ID, wu Du bruuchsch, sin d Zahlen un Buechstabe zwische „$2“ un „$3“.',
	'imstatus_skype_nbstyle' => 'Hiiwyys: wänn Du ne Stil uussuechsch, wu s au ne Aktion din het, wird Dyy Aktionsuuswahl dur d Aktion vum Stil ersetzt.',
	'imstatus_xfire_size' => 'd Greßi vu dr Schaltflächi, vu $1 (greschti) bis $2 (chleischti).',
	'imstatus_yahoo_style' => 'dr Stil vu dr Schaltflächi, vu $1 (chleischte) bis $2 (greschte), $3 un $4 sin fir Voicemail.',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'imstatus-desc' => 'הוספת תגים עבור המצבים המקוונים של מגוון רשתות המסרים המידיים (AIM&rlm;, Google Talk&rlm;, ICQ&rlm;, MSN/Live Messenger&rlm;, Skype&rlm;, Xfire&rlm;, Yahoo)',
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
	'imstatus_aim_presence' => '$1 מציג את המצב שלך וקישור שיפעיל את AIM לשליחת הודעה אם למשתמש יש AIM מותקן.',
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

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'imstatus-desc' => 'Přidawa taflički, zo bychu onlinestatus wšelakich internetnych powěstnikow (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo) zwobraznili',
	'imstatus_syntax' => 'Syntaksa',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Přikład',
	'imstatus_possible_val' => 'Móžne hódnoty',
	'imstatus_max' => 'maks.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'abo',
	'imstatus_style' => 'stil statusoweho wozjewjenja',
	'imstatus_action' => 'akcija při kliknjenju na tłóčatko',
	'imstatus_details_saa' => 'Za dalše podrobnosće wo wšěch stilach a akcijach, hlej $1.',
	'imstatus_your_name' => 'twoje $1-mjeno',
	'imstatus_aim_presence' => '$1 pokazuje twój status z wotkazom, kotryž startuje AIM (jeli wužiwar je jón instalował), zo by ći powěsć pósłał.',
	'imstatus_aim_api' => '$1 pokazuje twój status z wotkazom, kotryž budźe <b>wobhladowak</b> startować, z javascriptowej wersiju AIM, zo by ći hnydomnu powěsć pósłał.',
	'imstatus_gtalk_code' => 'twój kod googloweje diskusije',
	'imstatus_gtalk_get_code' => 'twój kod googloweje diskusije: dóstanješ jón pola $1.',
	'imstatus_gtalk_height' => 'wysokosć kašćika w pikselach',
	'imstatus_gtalk_width' => 'šěrokosć kašćika w pikselach.',
	'imstatus_icq_id' => 'twój ICQ-ID',
	'imstatus_icq_style' => 'ličba we wobłuku wot 0 do 25 (haj, je 27 k dispoziciji stejacych stilow...).',
	'imstatus_live_code' => 'twój websydłowy ID za Live Messenger',
	'imstatus_live_get_code' => 'twój websydłowy ID za Live Messenger: <strong>to njeje twoja e-mejlowa adresa</strong>, dyrbiš jednu w <a href="$1">twojich opcijach za Live messenger</a> wutworić.
ID, kotryž dyrbiš podać, su ličby a pismiki mjez "$2" a "$3".',
	'imstatus_skype_nbstyle' => 'Pokiw: jeli wuběraš stil, kotryž je tež akcija, budźe so twój wuběr akcijow přez akciju, kotraž wubranemu stilej wotpowěduje, přepisować.',
	'imstatus_xfire_size' => 'Wulkosć tłóčatka, wot $1 (najwjetša) do $2 (najmjeńša).',
	'imstatus_yahoo_style' => 'stil tłóčatka, wot $1 (najmjeńši) do $2 (najwjetši), $3 a $4 stej za Voicemail.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'imstatus-desc' => 'Tagek különböző azonnali üzenetküldő szolgáltatások bejelentkezési állapotának megjelenítésére (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Szintaxis',
	'imstatus_default' => 'Alapértelmezett',
	'imstatus_example' => 'Példa',
	'imstatus_possible_val' => 'Lehetséges értékek',
	'imstatus_max' => 'max.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'vagy',
	'imstatus_style' => 'állapotjelző stílusa',
	'imstatus_action' => 'művelet a gombra való kattintáskor',
	'imstatus_details_saa' => 'További részletekért az összes stílusról és műveletről lásd a következő lapot: $1.',
	'imstatus_your_name' => '$1-azonosító',
	'imstatus_aim_presence' => 'A(z) $1 megjeleníti az állapotodat egy hivatkozással, ami elindítja az AIM programot hogy azonnali üzenetet küldjenek neked (ha a felhasználónak telepítve van).',
	'imstatus_aim_api' => 'A(z) $1 megjeleníti a bejelentkezési állapotodat egy hivatkozással, ami elindít egy <b>böngészőt</b> az AIM javascript-es változatával, hogy azonnali üzenetet küldjenek neked.',
	'imstatus_gtalk_code' => 'a google talk kódod',
	'imstatus_gtalk_get_code' => 'a Google Talk kódodat a(z) $1 címen tudhatod meg.',
	'imstatus_gtalk_height' => 'a doboz magassága, képpontban.',
	'imstatus_gtalk_width' => 'a doboz szélessége, pixelekben.',
	'imstatus_icq_id' => 'az ICQ-azonosítód',
	'imstatus_icq_style' => '0-tól 26-ig terjedő szám (igen, 27 stílus van)',
	'imstatus_live_code' => 'a Live Messenger weboldal azonosítód',
	'imstatus_live_get_code' => 'a Live Messenger weboldal azonosítód: <strong>ez nem az e-mail címed</strong>, készítened kell egyet a <a href="$1">Live Messenger beállításaidnál</a>.
Az azonosító amit meg kell adnod az "$2" és "$3" közti számok és betűk.',
	'imstatus_skype_nbstyle' => 'Megjegyzés: ha olyan stílust választasz, ami egyben művelet is, az egyébként választott műveletet felül fogja bírálni a stílushoz tartozó.',
	'imstatus_xfire_size' => 'a gomb mérete, a legnagyobbtól ($1) a legkisebbig ($2).',
	'imstatus_yahoo_style' => 'a gomb stílusa a legkisebbtől ($1) a legnagyobbig ($2), $3 és $4 pedig a hangpostához.',
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
	'imstatus_skype_nbstyle' => 'Nota: Si tu selige un stilo que es tamben un action, tu selection de action essera supplantate per le action correspondente a tu stilo seligite.',
	'imstatus_xfire_size' => 'le grandor del button, de $1 (le plus grande) a $2 (le plus parve).',
	'imstatus_yahoo_style' => 'le stilo del button, de $1 (le plus parve) a $2 (le plus grande), $3 e $4 es pro le messages vocal.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 */
$messages['id'] = array(
	'imstatus-desc' => 'Menambahkan tag untuk menampilkan status daring dari berbagai IM (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Sintaks',
	'imstatus_default' => 'Baku',
	'imstatus_example' => 'Contoh',
	'imstatus_possible_val' => 'Nilai yang mungkin',
	'imstatus_max' => 'maks',
	'imstatus_min' => 'min',
	'imstatus_or' => 'atau',
	'imstatus_style' => 'gaya indikator status',
	'imstatus_action' => 'tindakan ketika tombol diklik',
	'imstatus_details_saa' => 'Untuk informasi lebih rinci tentang semua gaya dan tindakan, lihat $1.',
	'imstatus_your_name' => 'nama $1 Anda',
	'imstatus_aim_presence' => '$1 menunjukkan status Anda dengan pranala yang akan menjalankan AIM untuk mengirim Anda pesan istan, asalkan pengguna telah menginstalnya.',
	'imstatus_aim_api' => '$1 menunjukkan status Anda dengan pranala yang akan menjalankan suatu versi javascript <b>peramban</b> AIM untuk mengirimkan Anda pesan instan.',
	'imstatus_gtalk_code' => 'kode google talk Anda',
	'imstatus_gtalk_get_code' => 'kode google takl Anda: dapatkan di $1.',
	'imstatus_gtalk_height' => 'tinggi kotak, dalam piksel.',
	'imstatus_gtalk_width' => 'lebar kotak, dalam piksel',
	'imstatus_icq_id' => 'ID ICQ Anda',
	'imstatus_icq_style' => 'suatu angka berkisar antara 0 hingga 26 (ya, tersedia 27 gaya).',
	'imstatus_live_code' => 'ID situs web Live Messenger Anda',
	'imstatus_live_get_code' => 'ID situs web Live Messenger Anda: <strong>ini bukan alamat surel Anda</strong>, Anda perlu membuatnya di <a href="$1">opsi Live Messenger Anda</a>.
ID yang perlu Anda berikan adalah angka dan huruf antara "$2" dan "$3".',
	'imstatus_skype_nbstyle' => 'Catatan: Jika Anda memilih suatu gaya yang juga merupakan suatu tindakan, pilihan tindakan Anda akan diganti dengan tindakan yang cocok dengan gaya yang dipilih.',
	'imstatus_xfire_size' => 'ukuran tombol, dari $1 (terbesar) hingga $2 (terkecil).',
	'imstatus_yahoo_style' => 'gaya  tombol, dari $1 (terkecil) hingga $2 (terbesar), $3 dan $4 ditujukan untuk kotak suara.',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'imstatus-desc' => 'Aggiunge tag per mostrare lo stato di connessione in diversi programmi di messaggistica istantanea (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Sintassi',
	'imstatus_default' => 'Predefinito',
	'imstatus_example' => 'Esempio',
	'imstatus_possible_val' => 'Possibili valori',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'o',
	'imstatus_style' => "stile dell'indicatore di stato",
	'imstatus_action' => 'azione quando si fa clic sul pulsante',
	'imstatus_details_saa' => 'Per ulteriori informazioni su tutti gli stili e le azioni, consultare $1.',
	'imstatus_your_name' => 'tuo nome $1',
	'imstatus_aim_presence' => "$1 mostra il proprio stato con un collegamento che manderà un messaggio istantaneo via AIM, a condizione che l'utente lo abbia installato.",
	'imstatus_aim_api' => '$1 mostra il proprio stato con un collegamento che avvierà un <b>browser</b>, versione javascript di AIM per inviarti un messaggio istantaneo.',
	'imstatus_gtalk_code' => 'tuo codice google talk',
	'imstatus_gtalk_get_code' => 'tuo codice google talk: ottienilo a $1.',
	'imstatus_gtalk_height' => 'altezza della casella, in pixel.',
	'imstatus_gtalk_width' => 'larghezza della casella, in pixel.',
	'imstatus_icq_id' => 'tuo ID ICQ',
	'imstatus_icq_style' => 'un numero fra 0 e 26 (sì, ci sono 27 stili disponibili).',
	'imstatus_live_code' => 'tuo id del sito web Live Messenger',
	'imstatus_live_get_code' => 'tuo id del sito web Live Messenger: <strong>questo non è il tuo indirizzo email</strong>, è necessario generarne uno nelle <a href="$1">proprie opzioni Live Messenger</a>.
L\'id che bisogna fornire sono i numeri e le lettere fra "$2" e "$3".',
	'imstatus_skype_nbstyle' => "Nota: se si sceglie uno stile che è anche un'azione, la scelta dell'azione verrà sovrascritta dalle azioni che corrispondono allo stile scelto.",
	'imstatus_xfire_size' => 'dimensione del pulsante, da $1 (il più grande) a $2 (il più piccolo).',
	'imstatus_yahoo_style' => 'lo stile del pulsante, da $1 (il più piccolo) a $2 (il più grande), $3 e $4 sono per i messaggi vocali.',
);

/** Japanese (日本語)
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Mizusumashi
 */
$messages['ja'] = array(
	'imstatus-desc' => '各種インスタントメッセンジャーのオンライン状態を示すためのタグを追加する (AIM、Google トーク、ICQ、MSN/Live メッセンジャー、Skype、Xfire、Yahoo)',
	'imstatus_syntax' => '構文',
	'imstatus_default' => 'デフォルト',
	'imstatus_example' => '例',
	'imstatus_possible_val' => '可能な値',
	'imstatus_max' => '最大',
	'imstatus_min' => '最小',
	'imstatus_or' => 'または',
	'imstatus_style' => '状態の表示のスタイル',
	'imstatus_action' => 'ボタンがクリックされたときのアクション',
	'imstatus_details_saa' => 'すべてのスタイルとアクションについてのさらなる詳細は、$1をご参照ください。',
	'imstatus_your_name' => 'あなたの$1の名前',
	'imstatus_aim_presence' => '$1は、利用者がAIMをインストールしている場合にあなたにインスタントメッセージを送信するためにAIMを起動するリンクとともに、あなたの状態を表示します。',
	'imstatus_aim_api' => '$1は、あなたにインスタントメッセージを送信できるように、ブラウザーを起動して JavaScript 版の AIM を表示するリンクを付けて、あなたの状態を表示します。',
	'imstatus_gtalk_code' => 'あなたのGoogleトークコード',
	'imstatus_gtalk_get_code' => 'あなたのGoogleトークコード: $1で取得する。',
	'imstatus_gtalk_height' => 'ボックスの高さ(ピクセル単位)',
	'imstatus_gtalk_width' => 'ボックスの幅(ピクセル単位)',
	'imstatus_icq_id' => 'あなたのICQ ID',
	'imstatus_icq_style' => '0から26の範囲の数(つまり、27の有効なスタイルが存在します...)',
	'imstatus_live_code' => 'あなたのLive MessengerウェブサイトのID',
	'imstatus_live_get_code' => 'あなたのLiveメッセンジャー・ウェブサイトのID: <strong>これは、あなたのeメールアドレスではなく</strong>、 <a href="$1">あなたのLiveメッセンジャーのオプション</a>で取得する必要があります。
必要とされるIDは、"$2"と"$3"の間の文字と数字からなります。',
	'imstatus_skype_nbstyle' => '註: もし、あなたがアクションをともなったスタイルを選択したならば、あなたの選択したアクションは、選択されたスタイルに適合するアクションで上書きされます。',
	'imstatus_xfire_size' => '$1(最大)から$2(最小)のボタンのサイズ。',
	'imstatus_yahoo_style' => '$1(最大)から$2(最小)のボタンのスタイル($3と$4は、音声メール用)。',
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

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'imstatus_example' => 'ಉದಾಹರಣೆ',
);

/** Colognian (Ripoarisch)
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
	'imstatus_aim_presence' => '$1 zäijsch Dinge Shtattus met enem Lengk, dä dä AIM aanwerrfe deiht, öm Der en Nohreesch ze schecke — wann dä drop kleck, en och op singem Rääschner enshtalleet hät.',
	'imstatus_aim_api' => '$1 zäijsch Dinge Shtattus met enem Lengk, dä ene JavaScrip-Väsjohn fum AIM en Dingem Brauser aanwerrfe deiht, öm Der en Nohreesch ze schecke.',
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
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'imstatus-desc' => 'Setzt Markéierungen derbäi déi den Online-Status vu verschiddenen Instant Messanger Systemer (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo) weisen',
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Beispill',
	'imstatus_possible_val' => 'Méiglech Wäerter',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'oder',
	'imstatus_style' => 'Styl vum Indicateur vum Status',
	'imstatus_action' => 'Aktioun wann de Knäppche geklickt ass',
	'imstatus_details_saa' => "fir méi Detailer iwwer d'Stiler and d'Aktioune, kukckt w.e.g. $1.",
	'imstatus_your_name' => 'ären $1 Numm',
	'imstatus_gtalk_code' => 'Äre Google Talk Code',
	'imstatus_gtalk_get_code' => 'Ären Goggle-Talk-Code: Fot Iech en op $1.',
	'imstatus_gtalk_height' => 'Höicht vun der Këscht a Pixel.',
	'imstatus_gtalk_width' => 'Breet vun der Këscht, a Pixel.',
	'imstatus_icq_id' => 'är ICQ ID',
	'imstatus_icq_style' => 'eng Zuel tëschent 0 a 26 (jo, et gëtt 27 verschidde Stylen ...).',
	'imstatus_live_code' => 'Är Live Messenger Website-Idendifikatioun',
	'imstatus_xfire_size' => "d'Gréisst vum Knäppchen, vun $1 (gréissten) bis $2 (klengsten).",
	'imstatus_yahoo_style' => 'de Styl vum Knäppchen, vun $1 (klengsten) bis $2 (gréissten), $3 a(n) $4 si fir Voicemail.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'imstatus-desc' => 'Додава ознаки за приказ на разни сатуси во програми за инстант-пораки (IM)  (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Синтакса',
	'imstatus_default' => 'Основно',
	'imstatus_example' => 'Пример',
	'imstatus_possible_val' => 'Можни вредности',
	'imstatus_max' => 'max',
	'imstatus_min' => 'мин',
	'imstatus_or' => 'или',
	'imstatus_style' => 'стил на статус индикаторот',
	'imstatus_action' => 'дејство при кликнување на копчето',
	'imstatus_details_saa' => 'За повеќе подробности за сите стилови и дејства, погледајте $1.',
	'imstatus_your_name' => 'вашето $1 име',
	'imstatus_aim_presence' => '$1 го прикажува вашиот статус заедно со врска која ќе го отвори AIM за праќање на инстант-порака, доколку корисникот го има инсталирано.',
	'imstatus_aim_api' => '$1 го прикажува вашиот статус со врска која ќе отвори <b>прелистувач</b>, javascript-верзија на AIM за праќање на инстант-порака.',
	'imstatus_gtalk_code' => 'вашиот код на google talk',
	'imstatus_gtalk_get_code' => 'ваѓиот код на google talk code: преземете го на $1.',
	'imstatus_gtalk_height' => 'висината на кутијата, во пиксели.',
	'imstatus_gtalk_width' => 'ширината на кутијата, во пиксели.',
	'imstatus_icq_id' => 'вашиот ICQ ID',
	'imstatus_icq_style' => 'број од 0 до 26 (да, постојат 27 различни стилови).',
	'imstatus_live_code' => 'вашиот ID на мрежното место на Live Messenger',
	'imstatus_live_get_code' => 'вашиот ID на мрежното место на Live Messenger: <strong>ова не е вашата е-пошта</strong>, ќе треба да го создадете во
<a href="$1">вашите прилагодувања на Live Messenger</a>.
Во тој ИД треба да има букви и бројки од „$2“ до „$3“.',
	'imstatus_skype_nbstyle' => 'Напомена: Ако одберете стил кој е истовремено и дејство, вашиот избор на дејство ќе биде заменет со дејството соодветно на одбраниот стил.',
	'imstatus_xfire_size' => 'големина на копчето, од $1 (најголемо) до $2 (најмало).',
	'imstatus_yahoo_style' => 'стил на копчето, од $1 (најмало) до $2 (најголемо), $3 и $4 се за говорна пошта.',
);

/** Marathi (मराठी)
 * @author V.narsikar
 */
$messages['mr'] = array(
	'imstatus_example' => 'उदाहरण',
	'imstatus_possible_val' => 'शक्य असलेल्या किंमती',
	'imstatus_max' => 'जास्तीतजास्त',
	'imstatus_min' => 'कमीतकमी',
	'imstatus_or' => 'किंवा',
	'imstatus_action' => 'बटन टिचकविल्यावर काय क्रिया होते',
	'imstatus_your_name' => 'आपले $1 नाव',
	'imstatus_gtalk_height' => 'पिक्सेलमध्ये खिडकीची उंची',
	'imstatus_gtalk_width' => 'पिक्सेलमध्ये खिडकीची रुंदी',
	'imstatus_xfire_size' => 'बटनांचा आकार $1 (सर्वात मोठे) ते $2 (सर्वात लहान).',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'imstatus_default' => 'Asali',
	'imstatus_or' => 'atau',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'imstatus-desc' => 'Legg til merkelapper for å vise forskjellige påloggingsstatuser i direktemeldingsprogram (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntaks',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Eksempel',
	'imstatus_possible_val' => 'Mulige verdier',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'eller',
	'imstatus_style' => 'stilen til statusindikatoren',
	'imstatus_action' => 'handling når knappen blir klikket på',
	'imstatus_details_saa' => 'For flere detaljer om alle stilene og handligene, se $1.',
	'imstatus_your_name' => 'ditt $1 navn',
	'imstatus_aim_presence' => '$1 viser statusen din med en lenke som vil starte AIM for å sende deg en direktemelding, gitt at brukeren har det installert.',
	'imstatus_aim_api' => '$1 viser statusen din med en lenke som vil starte en <b>nettleser</b>-javaskriptversjon av AIM for å sende deg en direktemelding.',
	'imstatus_gtalk_code' => 'din google talk-kode',
	'imstatus_gtalk_get_code' => 'din google talk-kode: få den på $1.',
	'imstatus_gtalk_height' => 'boksens høyde, i piksler.',
	'imstatus_gtalk_width' => 'boksens bredde, i piksler.',
	'imstatus_icq_id' => 'din ICQ-ID',
	'imstatus_icq_style' => 'et tall i intervallet fra 0 til 26 (ja, det finnes 27 tilgjengelige stiler).',
	'imstatus_live_code' => "ID'en til ditt Live Messenger-nettsted",
	'imstatus_live_get_code' => 'ID\'en til ditt Live Messenger-nettsted: <strong>dette er ikke e-postadressen din</strong>, du må lage en i <a href="$1">dine Live Messenger-alternativ</a>.
ID\'en du må oppgi er tallene og bokstavene mellom "$2" og "$3".',
	'imstatus_skype_nbstyle' => 'Merk: Dersom du velger en stil som også er en handling vil handlingsvalget ditt bli overkjørt av handlingen som samsvarer med stilvalget ditt.',
	'imstatus_xfire_size' => 'knappens størrelse, fra $1 (størst) til $2 (minst).',
	'imstatus_yahoo_style' => 'knappes stil, fra $1 (minst) til $2 (størst), $3 og $4 er for lydpost.',
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
	'imstatus_gtalk_get_code' => 'uw Google Talk-code; deze is te verkrijgen op $1.',
	'imstatus_gtalk_height' => 'hoogte van het venster, in pixels.',
	'imstatus_gtalk_width' => 'breedte van het venster, in pixels.',
	'imstatus_icq_id' => 'uw ICQ-nummer',
	'imstatus_icq_style' => 'een getal tussen 0 en 26 (er zijn dus 27 beschikbare stijlen).',
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
	'imstatus_gtalk_height' => 'nautor de la bóstia, en pixèls.',
	'imstatus_gtalk_width' => 'largor de la bóstia, en pixèls.',
	'imstatus_icq_id' => 'vòstre identificant ICQ',
	'imstatus_icq_style' => 'un nombre entre 0 e 26 (òc, i a 27 estils disponibles...).',
	'imstatus_live_code' => 'vòstre identificant sul site Live Messenger',
	'imstatus_live_get_code' => 'vòstre identificant sul site Live Messenger : <strong>es pas vòstra adreça de messatjariá</strong>, vos ne cal generar una dins <a href="$1">vòstras opcions Live Messenger</a>.
L’identificant de provesir aicí es compausat de chifras e letras entre « $2 » e « $3 ».',
	'imstatus_skype_nbstyle' => "Nòta : se causissètz un estil que tanben es una accion, vòstra causida d’accion serà espotida per l’accion que correspond a l'estil qu'avètz causit.",
	'imstatus_xfire_size' => 'la talha del boton, de $1 (la mai granda) a $2 (la mai pichona).',
	'imstatus_yahoo_style' => "l'estil del boton, de $1 (lo mai pichon) a $2 (lo mai grand), $3 e $4 son pels messatges vocals.",
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'imstatus_example' => 'Beischpiel',
	'imstatus_or' => 'odder',
	'imstatus_icq_id' => 'dei ICQ-ID',
	'imstatus_icq_style' => 'en Zehl vun 0 bis 26 (ya, es gitt 27 verschiddeni Aarde …).',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
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
	'imstatus_your_name' => 'Twoja $1 nazwa',
	'imstatus_aim_presence' => '$1 pokazuje Twój status oraz link który uruchamia AIM przesyłając mu Twój identyfikator jeśli użytkownik ma zainstalowany program komunikatora.',
	'imstatus_aim_api' => '$1 pokazuje status z linkiem uruchamiającym w <b>przeglądarce</b> wersję JavaScript komunikatora AIM do wysyłania wiadomości błyskawicznych.',
	'imstatus_gtalk_code' => 'kod komunikatora google',
	'imstatus_gtalk_get_code' => 'kod komunikatora google – uzyskaj go z $1.',
	'imstatus_gtalk_height' => 'wysokość okna w pikselach.',
	'imstatus_gtalk_width' => 'szerokość okna w pikselach.',
	'imstatus_icq_id' => 'identyfikator ICQ',
	'imstatus_icq_style' => 'liczba z zakresu od 0 do 26 (tak, jest aż 27 dostępnych stylów...).',
	'imstatus_live_code' => 'Twój identyfikator webowy Live Messengera',
	'imstatus_live_get_code' => 'Twój identyfikator witryny Live Messanger – <strong>nie jest to Twój adres e‐mailowy</strong>; identyfikator musisz wygenerować w <a href="$1">opcjach swojego Live Messengera</a>.
Identyfikator jest ciągiem liter i cyfr umieszczonych pomiędzy „$2” a „$3”.',
	'imstatus_skype_nbstyle' => 'Uwaga: Jeśli wybierzesz styl, który jest związany z jakąś akcją, wybrane działanie zostanie nadpisane domyślną akcją odpowiadającą wybranemu stylowi.',
	'imstatus_xfire_size' => 'wielkość przycisku od $1 (największy) do $2 (najmniejszy).',
	'imstatus_yahoo_style' => 'styl przycisku od $1 (najmniejszy) do $2 (największy), $3 i $4 dla poczty głosowej.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'imstatus-desc' => 'A gionta dij tag për mosté vàire stat IM an linia (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfie, Yahoo)',
	'imstatus_syntax' => 'Sintassi',
	'imstatus_default' => 'Default',
	'imstatus_example' => 'Esempi',
	'imstatus_possible_val' => 'Valor possìbij',
	'imstatus_max' => 'màssim',
	'imstatus_min' => 'mìnim',
	'imstatus_or' => 'o',
	'imstatus_style' => "stil ëd l'andicator dë stat",
	'imstatus_action' => "assion quand ël boton a l'é sgnacà",
	'imstatus_details_saa' => "Për pi 'd detaj dzora tùit jë stij e j'assion, varda $1.",
	'imstatus_your_name' => 'tò nòm $1',
	'imstatus_aim_presence' => "$1 a mostra tò stat con un colegament che a farà parte AIM për mandete un mëssagi subitan, se l'utent a l'ha anstalalo.",
	'imstatus_aim_api' => "$1 a mostra tò stat con un colegament che a farà parte un <a>navigator</b>, version javascript d'AIM për mandete un mëssagi subitan.",
	'imstatus_gtalk_code' => 'tò còdes google talk',
	'imstatus_gtalk_get_code' => 'tò còdes google talk: pij-lo a $1.',
	'imstatus_gtalk_height' => 'autëssa dël box, an pixel.',
	'imstatus_gtalk_width' => 'larghëssa dël box, an pixel.',
	'imstatus_icq_id' => 'tò ID ICQ',
	'imstatus_icq_style' => 'un nùmer da 0 a 26 (é!, a-i son 27 stij disponìbij),',
	'imstatus_live_code' => 'tò identificativ an sël sit Live Messenger',
	'imstatus_live_get_code' => 'tò identificativ dël sit Live Messenger: <strong>cost-sì a l\'é pa toa adrëssa ëd pòsta eletrònica</strong>, it deve generene un an 
<a href="$1">toa opsion Live Messenger</a>.
L\'identificativ ch\'it deve dé a son ij nùmer e le litre an tra "$2" e "$3".',
	'imstatus_skype_nbstyle' => "Nòta: S'it serne në stil che a l'é ëdcò n'assion, toa assion sërnùa a sarà coatà da l'assion ch'a corispond a tò stil sërnù.",
	'imstatus_xfire_size' => 'la dimension dël boton, da $1 (ël pi gròss) a $2 (ël pi cit).',
	'imstatus_yahoo_style' => 'lë stil dël boton, da $1 (ël pi cit) a $2 (ël pi gròss), $3 e $4 a son për mëssagi vocaj.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'imstatus_default' => 'تلواليز',
	'imstatus_example' => 'بېلګه',
	'imstatus_or' => 'يا',
	'imstatus_your_name' => 'ستاسې $1 نوم',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'imstatus-desc' => 'Adiciona elementos (tags) para mostrar vários estados de ligação de IM (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
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
	'imstatus_aim_presence' => '$1 mostra o seu estado, com um link que iniciará o AIM para lhe enviar uma IM, se este tiver sido instalado.',
	'imstatus_aim_api' => '$1 mostra o seu estado, com um link que iniciará uma versão Javascript do AIM num <b>browser</b> para lhe enviar uma IM.',
	'imstatus_gtalk_code' => 'o seu código Google Talk',
	'imstatus_gtalk_get_code' => 'o seu código Google Talk: obtenha-o em $1.',
	'imstatus_gtalk_height' => 'altura da caixa, em pixels.',
	'imstatus_gtalk_width' => 'largura da caixa, em pixels.',
	'imstatus_icq_id' => 'o seu ID do ICQ',
	'imstatus_icq_style' => 'um número entre 0 e 26 (sim, existem 27 estilos disponíveis...).',
	'imstatus_live_code' => 'o seu ID do site Live Messenger',
	'imstatus_live_get_code' => 'o seu ID do Live Messenger: <strong>não é o seu endereço de correio electrónico</strong>, tem de gerar um ID nas <a href="$1">opções do Live Messenger</a>.
O ID que precisa de fornecer são os números e letras entre "$2" e "$3".',
	'imstatus_skype_nbstyle' => 'Nota: Se escolher um estilo que seja também uma acção, a sua escolha de acção será suplantada pela acção que corresponda ao seu estilo escolhido.',
	'imstatus_xfire_size' => 'o tamanho do botão, de $1 (maior) a $2 (menor).',
	'imstatus_yahoo_style' => 'o estilo do botão, de $1 (menor) a $2 (maior), $3 e $4 são para correio de voz.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'imstatus-desc' => 'Adiciona marcas (tags) para mostrar vários estados de ligação em IM (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Sintaxe',
	'imstatus_default' => 'Padrão',
	'imstatus_example' => 'Exemplo',
	'imstatus_possible_val' => 'Valores possíveis',
	'imstatus_max' => 'máx',
	'imstatus_min' => 'mín',
	'imstatus_or' => 'ou',
	'imstatus_style' => 'estilo do indicador de estado',
	'imstatus_action' => 'ação quando o botão é pressionado',
	'imstatus_details_saa' => 'Para mais detalhes sobre todos os estilos e ações, veja $1.',
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
	'imstatus_live_get_code' => 'o seu ID do sítio Live Messenger: <strong>não é o seu endereço de e-mail</strong>, você precisa gerar um nas <a href="$1">opções do seu Live Messenger</a>.
O ID que você precisa fornecer consiste em números e letras entre "$2" e "$3".',
	'imstatus_skype_nbstyle' => 'Nota: Se escolher um estilo que seja também uma ação, a sua escolha de ação será substituída pela ação que corresponda ao seu estilo escolhido.',
	'imstatus_xfire_size' => 'o tamanho do botão, de $1 (maior) a $2 (menor).',
	'imstatus_yahoo_style' => 'o estilo do botão, de $1 (menor) a $2 (maior), $3 e $4 são para correio de voz.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'imstatus_syntax' => 'Sintaxă',
	'imstatus_default' => 'Implicit',
	'imstatus_example' => 'Exemplu',
	'imstatus_possible_val' => 'Valori posibile',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'sau',
	'imstatus_your_name' => 'numele $1 tău',
	'imstatus_gtalk_height' => 'înălțimea cutiei, în pixeli.',
	'imstatus_gtalk_width' => 'lățimea cutiei, în pixeli.',
	'imstatus_icq_style' => 'un număr între 0 și 26 (da, există 27 de stiluri disponibile...).',
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
	'imstatus_gtalk_code' => "'u codece de google talk tune",
	'imstatus_gtalk_get_code' => "'u codece de google talk tune: pigghiale sus a $1.",
	'imstatus_gtalk_height' => "altezze d'a sckatele, in pixel.",
	'imstatus_gtalk_width' => "larghezze d'a sckatele, in pixel.",
	'imstatus_icq_id' => "l'ID de ICQ tune",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'imstatus-desc' => 'Добавляет теги для отображения различных статусов IM (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Синтаксис',
	'imstatus_default' => 'По умолчанию',
	'imstatus_example' => 'Пример',
	'imstatus_possible_val' => 'Возможные значения',
	'imstatus_max' => 'макс.',
	'imstatus_min' => 'мин.',
	'imstatus_or' => 'или',
	'imstatus_style' => 'стиль индикатора состояния',
	'imstatus_action' => 'действие при нажатии кнопки',
	'imstatus_details_saa' => 'Для подробностей о всех стилях и действиях, смотрите $1.',
	'imstatus_your_name' => 'ваше $1 имя',
	'imstatus_aim_presence' => '$1 показывает ваш статус вместе с ссылкой, которая запускает AIM для отправления сообщения, если у пользователя он установлен.',
	'imstatus_aim_api' => '$1 показывает ваш статус вместе с ссылкой, которая запускает <b>браузер</b>, с javascript-версий AIM для отправления сообщения.',
	'imstatus_gtalk_code' => 'ваш код google talk',
	'imstatus_gtalk_get_code' => 'ваш код google code: получите его на $1',
	'imstatus_gtalk_height' => 'высота блока, в пикселах.',
	'imstatus_gtalk_width' => 'ширина блока, в пикселах.',
	'imstatus_icq_id' => 'ваш ICQ ID',
	'imstatus_icq_style' => 'числа от 0 до 26 (да, существует 27 доступных стилей).',
	'imstatus_live_code' => 'ваш id вебсайта Live Messenger',
	'imstatus_live_get_code' => 'ваш id вебсайта Live Messenger: <strong>это не ваш адрес электронной почты</strong>, вы должны создать его в
<a href="$1">ваших настройках Live Messenger</a>.
В id должны быть буквы и цифры от «$2» до «$3».',
	'imstatus_skype_nbstyle' => 'Примечание. Если вы выбрали стиль, который является также действием, ваши действия будут переопределены действием, соответствующим выбранному вами стилю.',
	'imstatus_xfire_size' => 'размер кнопки, от $1 (наибольший) до $2 (наименьший).',
	'imstatus_yahoo_style' => 'стиль кнопки, от $1 (наименьший) до $2 (наибольший), $3 и $4 для голосовой почты.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'imstatus_syntax' => 'Сінтакс',
	'imstatus_default' => 'Імпліцітне',
	'imstatus_example' => 'Приклад',
	'imstatus_possible_val' => 'Можны годноты',
	'imstatus_max' => 'макс.',
	'imstatus_min' => 'мін.',
	'imstatus_or' => 'або',
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

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'imstatus_syntax' => 'Синтакса',
	'imstatus_default' => 'Подразумевано',
	'imstatus_example' => 'Пример',
	'imstatus_possible_val' => 'Могуће вредности',
	'imstatus_max' => 'највише',
	'imstatus_min' => 'мин',
	'imstatus_or' => 'или',
	'imstatus_action' => 'акција по клику дугмета',
	'imstatus_your_name' => 'Ваше $1 име',
	'imstatus_gtalk_height' => 'висина кутије, у пикселима.',
	'imstatus_gtalk_width' => 'ширина кутије, у пикселима.',
	'imstatus_icq_id' => 'Ваш ICQ ID',
	'imstatus_xfire_size' => 'величина дугмета, од $1 (највеће) до $2 (најмање).',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'imstatus_syntax' => 'Sintaksa',
	'imstatus_default' => 'Podrazumevano',
	'imstatus_example' => 'Primer',
	'imstatus_possible_val' => 'Moguće vrednosti',
	'imstatus_max' => 'maks',
	'imstatus_min' => 'min',
	'imstatus_or' => 'ili',
	'imstatus_action' => 'akcija po kliku dugmeta',
	'imstatus_your_name' => 'Vaše $1 ime',
	'imstatus_gtalk_height' => 'visina kutije, u pikselima.',
	'imstatus_gtalk_width' => 'širina kutije, u pikselima.',
	'imstatus_icq_id' => 'Vaš ICQ ID',
	'imstatus_xfire_size' => 'veličina dugmeta, od $1 (najveće) do $2 (najmanje).',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'imstatus-desc' => 'Föiget Tags bietou, uum dän Online-Stoatus fon ferskeedene Instant-Messengere antouwiesen (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Standoard',
	'imstatus_example' => 'Biespil',
	'imstatus_possible_val' => 'Muugelke Wäide',
	'imstatus_max' => 'max',
	'imstatus_min' => 'min',
	'imstatus_or' => 'of',
	'imstatus_style' => 'Stil fon ju Stoatus-Anwiesenge',
	'imstatus_action' => 'Aktion bie dät Klikken fon ju Skaltfläche',
	'imstatus_details_saa' => 'Wiedere Details tou do Stile un Aktione fint me ap: $1.',
	'imstatus_your_name' => 'din $1-Noome',
	'imstatus_aim_presence' => '$1 wiest din Stoatus mäd n Link, die AIM startet (sofier et installierd is), uum die ne Ättergjucht tou seenden.',
);

/** Swedish (Svenska)
 * @author Najami
 * @author Per
 */
$messages['sv'] = array(
	'imstatus-desc' => 'Lägg till tag för att visa olika status i direktmeddelandeprogram (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Syntax',
	'imstatus_default' => 'Standard',
	'imstatus_example' => 'Exempel',
	'imstatus_possible_val' => 'Möjliga värden',
	'imstatus_max' => 'högst',
	'imstatus_min' => 'minst',
	'imstatus_or' => 'eller',
	'imstatus_style' => 'stil på statusindikatorn',
	'imstatus_action' => 'handling när du klickar på knappen',
	'imstatus_details_saa' => 'För mer detaljer om all stilar och handlingar, se $1.',
	'imstatus_your_name' => 'ditt $1 namn',
	'imstatus_gtalk_code' => 'din google talk-kod',
	'imstatus_gtalk_get_code' => 'din google talk-kod: få den på $1.',
	'imstatus_gtalk_height' => 'boxens höjd, i pixlar.',
	'imstatus_gtalk_width' => 'boxens bredd, i pixlar.',
	'imstatus_icq_id' => 'ditt ICQ-ID',
	'imstatus_icq_style' => 'ett tal mellan 0 och 26 (ja det finns 27 möjliga stilar).',
	'imstatus_live_code' => 'ditt ID till Live Messenger sajten',
	'imstatus_skype_nbstyle' => 'Notera: Om du väljer en stil som också är en handling så kommer ditt handlingsval att bli ändrat till att matcha din valda stil.',
	'imstatus_xfire_size' => 'knappens storlek, från $1 (störst) till $2 (minst).',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'imstatus_default' => 'అప్రమేయం',
	'imstatus_example' => 'ఉదాహరణ',
	'imstatus_possible_val' => 'సాధ్యమయ్యే విలువలు',
	'imstatus_max' => 'గరిష్ఠ',
	'imstatus_min' => 'కనిష్ఠ',
	'imstatus_or' => 'లేదా',
	'imstatus_your_name' => 'మీ $1 పేరు',
	'imstatus_gtalk_height' => 'పెట్టె యొక్క ఎత్తు, పిక్సెళ్ళలో.',
	'imstatus_gtalk_width' => 'పెట్టె యొక్క వెడల్పు, పిక్సెళ్ళలో.',
	'imstatus_icq_style' => '0 నుండి 26 లోపు ఒక సంఖ్య (అవును, 27 శైలులు అందుబాటులో ఉన్నాయి).',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'imstatus_example' => 'Ezemplu',
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

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'imstatus_syntax' => 'Sözdizimi',
	'imstatus_default' => 'Varsayılan',
	'imstatus_example' => 'Örnek',
	'imstatus_possible_val' => 'Olası değerler',
	'imstatus_max' => 'maks',
	'imstatus_min' => 'min',
	'imstatus_or' => 'veya',
	'imstatus_style' => 'durum göstergesi biçemi',
	'imstatus_action' => 'düğmeye tıklandığında etkin',
	'imstatus_details_saa' => 'Tüm biçem ve işlemler hakkında daha fazla bilgi almak için $1 sayfasını inceleyin.',
	'imstatus_gtalk_code' => 'google talk kodunuz',
	'imstatus_gtalk_get_code' => 'google talk kodunuz: $1 kaynağından alın.',
	'imstatus_gtalk_height' => 'kutunun piksel cinsinden yüksekliği.',
	'imstatus_gtalk_width' => 'kutunun piksel cinsinden genişliği.',
	'imstatus_icq_id' => 'ICQ numaranız',
	'imstatus_icq_style' => '0 ile 26 arasında bir rakam (evet, 27 kullanılabilir biçem mevcut)',
	'imstatus_live_code' => 'Live Messenger web sitesi kimliğiniz',
	'imstatus_xfire_size' => 'düğme boyutu, $1 (en büyük) ile $2 (en küçük) arasında.',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ерней
 */
$messages['tt-cyrl'] = array(
	'imstatus_default' => 'Килешү буенча',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'imstatus-desc' => 'Додає мітки для відображення онлайн статусу з різних програм обміну миттєвими повідомленнями (AIM, Google Talk, ICQ, MSN/Live Messenger, Skype, Xfire, Yahoo)',
	'imstatus_syntax' => 'Синтаксис',
	'imstatus_default' => 'По замовчуванню',
	'imstatus_example' => 'Приклад',
	'imstatus_possible_val' => 'Можливі значення',
	'imstatus_max' => 'макс.',
	'imstatus_min' => 'мін.',
	'imstatus_or' => 'або',
	'imstatus_style' => 'стиль індикатору статусу',
	'imstatus_action' => 'дія при настисненні кнопки',
	'imstatus_details_saa' => 'Більш докладну інформацію по всіх стилях і діях, див. $1.',
	'imstatus_your_name' => "ваше $1 ім'я",
	'imstatus_aim_presence' => '$1 показує Ваш статус з посиланням на AIM, що відкриє AIM, за умови, якщо його користувач встановив.',
	'imstatus_aim_api' => '$1 показує Ваш статус з посиланням, що запустить <b>браузер</b>, з JavaScript версією AIM для обміну миттєвими повідомленнями.',
	'imstatus_gtalk_code' => 'Ваш код Google talk',
	'imstatus_gtalk_get_code' => 'Ваш код Google Talk: отримайте його на $1.',
	'imstatus_gtalk_height' => 'висота блока в пікселях.',
	'imstatus_gtalk_width' => 'ширина блока в пікселях.',
	'imstatus_icq_id' => 'Ваш номер ICQ',
	'imstatus_icq_style' => 'число від 0 до 26 (так, є 27 доступних стилів).',
	'imstatus_live_code' => 'Ваш Live Messenger ідентифікатор',
	'imstatus_live_get_code' => 'Ваш Live Messenger ідентифікатор: <strong>не є Вашим e-mail</strong>, його Вам потрібно створити в налаштуваннях
<a href="$1">Live Messenger</a>.
Ідентифікатор, який Ви повинні вказати, є числово-літерним від "$2" до "$3".',
	'imstatus_skype_nbstyle' => 'Примітка. Якщо Ви вибрали стить, що є дією, це буде перекрито відповідною дією з наступного обраного стилю.',
	'imstatus_xfire_size' => 'розмір кнопки, від $1 (найбільший) до $2 (найменший).',
	'imstatus_yahoo_style' => 'стиль кнопки, від $1 (найменьший) до $2 (найбільший), $3 і $4 призначені для голосової пошти.',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'imstatus_syntax' => 'Sintaksis',
	'imstatus_default' => 'Augotižjärgendusen mödhe',
	'imstatus_example' => 'Ozutez',
	'imstatus_max' => 'maks.',
	'imstatus_min' => 'min.',
	'imstatus_or' => 'vai',
	'imstatus_icq_id' => 'teiden ICQ ID',
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
	'imstatus_gtalk_height' => 'chiều cao của hộp (điểm ảnh).',
	'imstatus_gtalk_width' => 'chiều ngang của hộp (điểm ảnh).',
	'imstatus_icq_id' => 'ID của bạn trên ICQ',
	'imstatus_icq_style' => 'số trong dãy từ 0 đến 26 (có 27 kiểu chứ...).',
	'imstatus_live_code' => 'ID website của bạn trên Live Messenger',
	'imstatus_live_get_code' => 'ID website của bạn trên Live Messenger: <strong>đây không phải là địa chỉ thư điện tử của bạn</strong>! Bạn cần phải tạo ra ID ở trang <a href="$1">tùy chọn Live Messenger</a>. Bạn cần cho vào ID có các số và chữ từ “$2” đến “$3”.',
	'imstatus_skype_nbstyle' => 'Chú ý: Nếu bạn chọn cùng kiểu cùng tác động, tác động của kiểu được chọn sẽ được sử dụng, thay vì tác động được chọn.',
	'imstatus_xfire_size' => 'cỡ nút, từ $1 (lớn nhất) đến $2 (nhỏ nhất).',
	'imstatus_yahoo_style' => 'kiểu nút, từ $1 (nhỏ nhất) đến $2 (lớn nhất); $3 và $4 dành cho thư thoại.',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'imstatus_syntax' => 'Süntag',
	'imstatus_default' => 'Stad kösömik',
	'imstatus_example' => 'Sam',
	'imstatus_possible_val' => 'Völads mögik',
	'imstatus_max' => 'maxum',
	'imstatus_min' => 'minum',
	'imstatus_or' => 'u',
	'imstatus_style' => 'stül stadijoniana',
	'imstatus_details_saa' => 'Ad reidön patis pluik dö stüls e duns, logolös eli $1.',
	'imstatus_your_name' => 'nem-$1 olik',
	'imstatus_icq_id' => 'Dientifäd-ICQ olik',
	'imstatus_live_code' => 'Dientifäd olik pro bevüresodatopäd: Live Messenger',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'imstatus_or' => 'אדער',
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
	'imstatus_icq_style' => '范围从0到26（没错，一共有27种样式可供选择...…）。',
	'imstatus_live_code' => '您的Live Messenger网站ID',
	'imstatus_live_get_code' => '您的Live Messenger网站ID：<strong>并不是您的电子邮件地址</strong>，您需要在<a href="$1">您的live messenger选项
</a>中生成。
需要提供的ID由"$2"和"$3"之间的数字、字母组成。',
	'imstatus_xfire_size' => '按钮的大小，可从 $1 （最大） 到 $2 （最小）供选择。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'imstatus-desc' => '增加了顯示各種即時通訊軟體線上狀態標籤（例如AIM、Google Talk、ICQ、MSN/Live Messenger、Skype、Xfire、Yahoo）',
	'imstatus_syntax' => '語法',
	'imstatus_default' => '預設',
	'imstatus_example' => '例子',
	'imstatus_possible_val' => '可能值',
	'imstatus_max' => '最大',
	'imstatus_min' => '最小',
	'imstatus_or' => '或者',
	'imstatus_style' => '狀態指示燈的風格',
	'imstatus_action' => '當按鈕按下時，就',
	'imstatus_details_saa' => '欲了解更多關於樣式和動作的細節，請參見 $1。',
	'imstatus_your_name' => '您的 $1 名稱',
	'imstatus_aim_presence' => '$1 顯示了您的狀態，並提供了一個連結，以便那些安裝了 AIM 的用戶可以直接發給您一個即時訊息。',
	'imstatus_aim_api' => '$1 顯示了您的狀態，並提供了一個連結，以啟動<b>瀏覽器</b>，透過 Javascript 版本的 AIM 發給您一個即時訊息。',
	'imstatus_gtalk_code' => '您的 Google Talk 代碼',
	'imstatus_gtalk_get_code' => '您的 Google Talk 代碼：在 $1 獲得它。',
	'imstatus_gtalk_height' => '箱體的高度，單位為 pixel。',
	'imstatus_gtalk_width' => '寬度框中，單位為 pixel。',
	'imstatus_icq_id' => '您的 ICQ ID',
	'imstatus_icq_style' => '範圍從 0 到 26（沒錯，一共有 27 種樣式可供選擇...…）。',
	'imstatus_live_code' => '您的 Live Messenger 網站 ID',
	'imstatus_live_get_code' => '您的 Live Messenger 網站 ID：<strong>並不是您的電子郵件位址</strong>，您需要在<a href="$1">您的 Live Messenger 選項
</a>中生成。
需要提供的 ID 由「$2」和「$3」之間的數字、字母組成。',
	'imstatus_xfire_size' => '按鈕的大小，可從 $1 （最大） 到 $2 （最小）供選擇。',
);

