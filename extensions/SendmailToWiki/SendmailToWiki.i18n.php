<?php
$messages = array();
 
/** English
 * @author Jure Kajzer - freakolowsky
 */
$messages['en'] = array( 
	'sendmailtowiki' => 'SendmailToWiki',
	'sendmailtowiki-desc' => 'Post wiki content through dedicated dynamic e-mail address',
	'prefs-sendmailtowiki' => 'Posting content with e-mail',
	'sendmailtowiki-inemail' => 'Dedicated e-mail address:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Blank field for PIN number disables posting content to wiki with your account.',
	'sendmailtowiki-err-pinlength' => 'PIN must contain exactly 5 numbers.',
	'sendmailtowiki-err-wrongprefix' => 'Wrong wiki account prefix. Contact your administrator.',
	'sendmailtowiki-err-invalidaccount' => 'Invalid account. Check the e-mail address you are sending to.',
	'sendmailtowiki-err-invalidsender' => 'Invalid sender. Check the e-mail address you are sending from.',
	'sendmailtowiki-err-invalidpin' => 'Invalid PIN. Access denied.',
	'sendmailtowiki-err-onlyplain' => 'Because of potential misinterpretations only pure text messages are accepted.',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 */
$messages['qqq'] = array(
	'sendmailtowiki-desc' => '{{desc}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'sendmailtowiki-desc' => 'Pos wiki-inhoud deur middel van toegewyde dinamiese e-posadresse',
	'prefs-sendmailtowiki' => 'Plaas inhoud deur middel van e-pos',
	'sendmailtowiki-inemail' => 'Toegewyde e-posadres:',
	'sendmailtowiki-inpin' => 'PIN-kode:',
	'prefs-help-sendmailtowiki_pin' => 'As die veld vir die PIN-kode leeg is, kan u nie bladsye skep via e-pos met u gebruiker nie.',
	'sendmailtowiki-err-pinlength' => 'Die PIN-kode moet presies 5 syfers bevat.',
	'sendmailtowiki-err-wrongprefix' => 'Verkeerde voorvoegsel vir wikigebruiker. Kontak u administrateur.',
	'sendmailtowiki-err-invalidaccount' => 'Ongeldige gebruiker. Kontroleer die adres waarna u e-pos stuur.',
	'sendmailtowiki-err-invalidsender' => 'Ongeldige afsender. Kontroleer die adres waarvan u e-pos stuur.',
	'sendmailtowiki-err-invalidpin' => 'Ongeldige PIN-kode. Toegang geweier.',
	'sendmailtowiki-err-onlyplain' => 'Om moontlike misinterpretasie te voorkom word slegs suiwer teks (MIME-type text/plain) aanvaar.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'sendmailtowiki-desc' => 'أرسل محتوى الويكي من خلال عنوان بريد إلكتروني ديناميكي مخصص',
	'prefs-sendmailtowiki' => 'إرسال المحتوى بالبريد الإلكتروني',
	'sendmailtowiki-inemail' => 'عنوان البريد الإلكتروني المخصص:',
	'sendmailtowiki-inpin' => 'بي آي إن:',
	'prefs-help-sendmailtowiki_pin' => 'حقل فارغ لPIN يعطل إرسال المحتوى للويكي بحسابك.',
	'sendmailtowiki-err-pinlength' => 'PIN يجب أن يحتوي على 5 أرقام بالضبط.',
	'sendmailtowiki-err-wrongprefix' => 'بادئة حساب ويكي خاطئة. اتصل بإداريك.',
	'sendmailtowiki-err-invalidaccount' => 'حساب غير صحيح. تحقق من عنوان البريد الإلكتروني الذي ترسل إليه.',
	'sendmailtowiki-err-invalidsender' => 'مرسل غير صحيح. تحقق من عنوان البريد الإلكتروني الذي ترسل منه.',
	'sendmailtowiki-err-invalidpin' => 'PIN غير صحيح. الدخول مرفوض.',
	'sendmailtowiki-err-onlyplain' => 'بسبب إساءة الفهم المحتملة فالرسائل النصية النقية فقط مقبولة.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'sendmailtowiki-inpin' => 'PIN:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'sendmailtowiki-desc' => 'Разьмяшчае зьмест ў {{GRAMMAR:месны|{{SITENAME}}}} праз выдзелены дынамічны адрас электроннай пошты',
	'prefs-sendmailtowiki' => 'Разьмяшчэньне зьмест праз электронную пошты',
	'sendmailtowiki-inemail' => 'Выдзелены адрас электроннай пошты:',
	'sendmailtowiki-inpin' => 'Пэрсанальны ідэнтыфікацыйны нумар:',
	'prefs-help-sendmailtowiki_pin' => 'Незапоўненае поле пэрсанальнага ідэнтыфікацыйнага нумару адключае магчымасьць разьмяшчэньня зьместу ў {{GRAMMAR:месны|{{SITENAME}}}} з Вашага рахунку.',
	'sendmailtowiki-err-pinlength' => 'Пэрсанальны ідэнтыфікацыйны нумар павінен утрымліваць 5 лічбаў.',
	'sendmailtowiki-err-wrongprefix' => 'Няслушны прэфікс рахунку ў {{GRAMMAR:месны|{{SITENAME}}}}. Зьвяжыцеся з Вашым адміністратарам.',
	'sendmailtowiki-err-invalidaccount' => 'Няслушны рахунак. Праверце адрас электроннай пошты, на які адбываецца дасылка.',
	'sendmailtowiki-err-invalidsender' => 'Няслушны адпраўшчык. Праверце адрас электроннай пошты, з якога Вы дасылаеце.',
	'sendmailtowiki-err-invalidpin' => 'Няслушны пэрсанальны ідэнтыфікацыйны нумар. У доступе адмоўлена.',
	'sendmailtowiki-err-onlyplain' => 'Каб пазьбегнуць супярэчнасьцяў, прымаюцца выключна тэкставыя паведамленьні.',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'sendmailtowiki-inpin' => 'পিন:',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'sendmailtowiki-desc' => "Postañ danvez wiki dre ur chomlec'h postel gouestlet dinamek",
	'prefs-sendmailtowiki' => 'Postañ danvez dre bostel',
	'sendmailtowiki-inemail' => "Chomlec'h postel gouestlet :",
	'sendmailtowiki-inpin' => 'PIN :',
	'prefs-help-sendmailtowiki_pin' => "Lezel gwerc'h maezienn an niverenn PIN a viro ouzhoc'h a embann danvez diwar ar wiki gant ho kont.",
	'sendmailtowiki-err-pinlength' => "5 niverenn hepken a ya d'ober ar PIN.",
	'sendmailtowiki-err-wrongprefix' => 'Rakger kont wiki direizh. Kit e darempred gant ar merour.',
	'sendmailtowiki-err-invalidaccount' => "Kont direizh. Gwiriañ chomlec'h postel an degemerer",
	'sendmailtowiki-err-invalidsender' => "Kaser direizh. Gwiriañ ar chomlec'h postel kas.",
	'sendmailtowiki-err-invalidpin' => "PIN direizh. Moned nac'het.",
	'sendmailtowiki-err-onlyplain' => "Abalamour da gammgeradurioù posupl ne vo degemret nemet ar c'hemennadennoù a ya testenn-rik d'o ober.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'sendmailtowiki-desc' => 'Slanje wiki sadržaja putem određene dinamičke e-mail adrese',
	'prefs-sendmailtowiki' => 'Slanje sadržaja putem e-maila',
	'sendmailtowiki-inemail' => 'Namjenska e-mail adresa:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Prazno polje za PIN broj ne dozvoljava slanej sadržaja na wiki sa vašeg računa.',
	'sendmailtowiki-err-pinlength' => 'PIN mora sadržavati tačno 5 cifara.',
	'sendmailtowiki-err-wrongprefix' => 'Pogrešan prefiks wiki računa. Kontaktirajte vašeg administratora.',
	'sendmailtowiki-err-invalidaccount' => 'Nevaljan račun. Provjerite e-mail adresu na koju šaljete.',
	'sendmailtowiki-err-invalidsender' => 'Nevaljan pošiljalac. Provjerite e-mail adresu sa koje se šalje.',
	'sendmailtowiki-err-invalidpin' => 'Nevaljan PIN. Pristup onemogućen.',
	'sendmailtowiki-err-onlyplain' => 'Zbog potencijalnih pogrešnih interpretacuha mogu se prihvatiti samo čisto tekstualne poruke.',
);

/** Catalan (Català)
 * @author Solde
 */
$messages['ca'] = array(
	'sendmailtowiki-inpin' => 'PIN:',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'sendmailtowiki-inpin' => 'PIN:',
);

/** German (Deutsch)
 * @author Imre
 */
$messages['de'] = array(
	'sendmailtowiki-desc' => 'Wiki-Inhalt über zugewiesene dynamische E-Mail-Adresse senden',
	'prefs-sendmailtowiki' => 'Sende Inhalte über E-Mail',
	'sendmailtowiki-inemail' => 'Zugewiesene E-Mail-Adresse:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Freies PIN-Eingabefeld deaktiviert Inhaltsübermittlung an Wiki von deinem Konto.',
	'sendmailtowiki-err-pinlength' => 'Die PIN muss genau 5 Ziffern enthalten.',
	'sendmailtowiki-err-wrongprefix' => 'Falsches Benutzerkonto-Prefix. Bitte Administrator kontaktieren.',
	'sendmailtowiki-err-invalidaccount' => 'Ungültiges Benutzerkonto. Überprüfe die E-Mail-Adresse, an die du sendest.',
	'sendmailtowiki-err-invalidsender' => 'Ungültiger Sender. Überprüfe die E-Mail-Adresse, von der du sendest.',
	'sendmailtowiki-err-invalidpin' => 'Ungültige PIN. Zugriff abgelehnt.',
	'sendmailtowiki-err-onlyplain' => 'Aufgrund potenzieller Fehlinterpretationen werden nur reine Textnachrichten akzeptiert.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 */
$messages['de-formal'] = array(
	'prefs-help-sendmailtowiki_pin' => 'Freies PIN-Eingabefeld deaktiviert Inhaltsübermittlung an Wiki von Ihrem Konto.',
	'sendmailtowiki-err-invalidaccount' => 'Ungültiges Benutzerkonto. Überprüfen Sie die E-Mail-Adresse, an die Sie senden.',
	'sendmailtowiki-err-invalidsender' => 'Ungültiger Sender. Überprüfen Sie die E-Mail-Adresse, von der Sie senden.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'sendmailtowiki-desc' => 'Wikiwopśimjeśe pśez rezerwěrowanu e-mailowu adresu pósłaś',
	'prefs-sendmailtowiki' => 'Wopśimjeśe z e-mailu pósłaś',
	'sendmailtowiki-inemail' => 'Rezerwěrowana e-mailowa adresa:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Prozne pólo za PIN-licbu znjemóžnja słanje wopśimjeśa do wikija z twójim kontom.',
	'sendmailtowiki-err-pinlength' => 'PIN musy eksaktnje 5 cyfrow měś.',
	'sendmailtowiki-err-wrongprefix' => 'Wopacny wikikontowy prefiks. Staj se ze swójim administratorom do zwiska.',
	'sendmailtowiki-err-invalidaccount' => 'Njepłaśiwe konto. Pśekontrolěruj e-mailowu adresu, na kótaruž coš pósłaś.',
	'sendmailtowiki-err-invalidsender' => 'Njepłaśiwy wótpósłaŕ. Pśekontrolěruj e-mailowu adresu, wót kótarejež coš pósłaś.',
	'sendmailtowiki-err-invalidpin' => 'Njepłaśiwny PIN. Pśistup zawobarany.',
	'sendmailtowiki-err-onlyplain' => 'Dla potentcielnych wopacnych interpretacijow akceptěruju se jano powěsći z lutnym tekstom.',
);

/** Greek (Ελληνικά)
 * @author ZaDiak
 */
$messages['el'] = array(
	'sendmailtowiki-inpin' => 'ΡΙΝ:',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'sendmailtowiki-inemail' => 'Dediĉita retadreso:',
	'sendmailtowiki-inpin' => 'Persona identignumero:',
	'sendmailtowiki-err-pinlength' => 'Persona identignumero nepre havu precize 5 numerojn.',
	'sendmailtowiki-err-invalidpin' => 'Malvalida persona identignumero. Atingo malpermesigita.',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Mor
 * @author Translationista
 */
$messages['es'] = array(
	'sendmailtowiki-desc' => 'Publicar contenido wiki a través de una dirección de correo electrónico dinámica dedicada',
	'prefs-sendmailtowiki' => 'Enviando contenido con correo electrónico',
	'sendmailtowiki-inemail' => 'Dirección de correo electrónico asignada:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'El campo de número PIN en blanco desactiva la publicación de contenido a la wiki con tu cuenta.',
	'sendmailtowiki-err-pinlength' => 'El PIN debe contener exactamente 5 números.',
	'sendmailtowiki-err-wrongprefix' => 'Prefijo de cuenta wiki erróneo. Por favor, contacta con el administrador.',
	'sendmailtowiki-err-invalidaccount' => 'Cuenta inválida. Revisa la dirección de correo electrónico a la que estás realizando el envío.',
	'sendmailtowiki-err-invalidsender' => 'Cuenta inválida. Revisa la dirección de correo electrónico desde la que estás realizando el envío.',
	'sendmailtowiki-err-invalidpin' => 'PIN no válido. Acceso denegado.',
	'sendmailtowiki-err-onlyplain' => 'Debido a potenciales malentendidos solamente mensajes de puro texto son aceptados.',
);

/** Finnish (Suomi)
 * @author ZeiP
 */
$messages['fi'] = array(
	'sendmailtowiki-desc' => 'Lähetä wiki-sisältöä erillisen dynaamisen sähköpostiosoitteen kautta',
	'prefs-sendmailtowiki' => 'Sisällön lähettäminen sähköpostilla',
	'sendmailtowiki-inemail' => 'Varattu sähköpostiosoite:',
	'sendmailtowiki-inpin' => 'Tunnusluku:',
	'prefs-help-sendmailtowiki_pin' => 'Tyhjä tunnusluku poistaa sisällön lähettämisen wikiin käytöstä tunnuksellasi.',
	'sendmailtowiki-err-pinlength' => 'Tunnusluvun tulee olla tasan 5 numeroa pitkä.',
	'sendmailtowiki-err-wrongprefix' => 'Väärä wiki-tunnusetuliite. Ota yhteyttä ylläpitäjään.',
	'sendmailtowiki-err-invalidaccount' => 'Virheellinen tunnus. Tarkista kohdesähköpostiosoite.',
	'sendmailtowiki-err-invalidsender' => 'Virheellinen lähettäjä. Tarkista sähköpostiosoite, josta lähetät.',
	'sendmailtowiki-err-invalidpin' => 'Virheellinen tunnusluku. Pääsy kielletty.',
	'sendmailtowiki-err-onlyplain' => 'Mahdollisten väärinkäsitysten vuoksi ainoastaan vain teksti -muotoiset viestit hyväksytään.',
);

/** French (Français)
 * @author PieRRoMaN
 * @author Urhixidur
 */
$messages['fr'] = array(
	'sendmailtowiki-desc' => 'Poster le contenu wiki via une adresse de courriel dédiée dynamique',
	'prefs-sendmailtowiki' => 'Publication du contenu par courriel',
	'sendmailtowiki-inemail' => 'Adresse de courriel dédiée :',
	'sendmailtowiki-inpin' => 'NIP :',
	'prefs-help-sendmailtowiki_pin' => 'Un champ vierge pour le NIP désactive la publication de contenu sur le wiki avec votre compte.',
	'sendmailtowiki-err-pinlength' => 'Le NIP doit contenir exactement 5 chiffres.',
	'sendmailtowiki-err-wrongprefix' => 'Préfixe de compte wiki erroné. Contactez l’administrateur.',
	'sendmailtowiki-err-invalidaccount' => 'Compte invalide. Vérifiez l’adresse de courriel de destination.',
	'sendmailtowiki-err-invalidsender' => 'Expéditeur invalide. Vérifiez l’adresse de courriel d’émission.',
	'sendmailtowiki-err-invalidpin' => 'NIP invalide. Accès refusé.',
	'sendmailtowiki-err-onlyplain' => 'En raison d’éventuelles erreurs d’interprétation, seuls les messages contenant du texte brut sont acceptés.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'prefs-sendmailtowiki' => 'Publecacion du contegnu per mèssageria èlèctronica',
	'sendmailtowiki-inemail' => 'Adrèce èlèctronica consacrâ :',
	'sendmailtowiki-inpin' => 'PIN :',
	'sendmailtowiki-err-pinlength' => 'Lo PIN dêt contegnir justo 5 chifros.',
	'sendmailtowiki-err-invalidpin' => 'PIN envalido. Accès refusâ.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'sendmailtowiki-desc' => 'Publicar contido wiki a través dun enderezo de correo electrónico dinámico',
	'prefs-sendmailtowiki' => 'Publicación de contido por correo electrónico',
	'sendmailtowiki-inemail' => 'Enderezo de correo electrónico dedicado:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Un campo baleiro para o número PIN desactiva a publicación de contidos no wiki coa súa conta.',
	'sendmailtowiki-err-pinlength' => 'O PIN debe conter exactamente 5 números.',
	'sendmailtowiki-err-wrongprefix' => 'Prefixo de conta wiki erróneo. Póñase en contacto co administrador.',
	'sendmailtowiki-err-invalidaccount' => 'Conta non válida. Comprobe o enderezo de correo electrónico de destino.',
	'sendmailtowiki-err-invalidsender' => 'Remitente non válido. Comprobe o enderezo de correo electrónico de procedencia.',
	'sendmailtowiki-err-invalidpin' => 'PIN non válido. Acceso rexeitado.',
	'sendmailtowiki-err-onlyplain' => 'Debido a posibles erros de interpretación, só se aceptan mensaxes de texto.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'sendmailtowiki-desc' => 'Wiki-Inhalt byytrage iber e zuegwiseni dynamischi E-Mail-Adräss',
	'prefs-sendmailtowiki' => 'Inhalt byytrage iber E-Mail',
	'sendmailtowiki-inemail' => 'Zuegwiseni E-Mail-Adräss:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Wänn Du s PIN-Fäld läär losch, no chasch kei Inhalt zum Wiki byytrage mit Dyym Benutzerkonto.',
	'sendmailtowiki-err-pinlength' => 'Dr PIN-Code muess genau 5 Zahle lang syy.',
	'sendmailtowiki-err-wrongprefix' => 'Falsche Vorsatz fir dr Wiki-Zuegang. Nimm Kontakt uf zue Dyym Administrator.',
	'sendmailtowiki-err-invalidaccount' => 'Nit giltig Benutzerkonto. Iberprief d E-Mail-Adräss, wu Du as Empfänger aagee hesch.',
	'sendmailtowiki-err-invalidsender' => 'Nit giltige Absänder. Iberprief d E-Mail-Adräss, wu Du as Absänder aagee hesch.',
	'sendmailtowiki-err-invalidpin' => 'Nit giltige PIN-Code. Zuegang verweigeret.',
	'sendmailtowiki-err-onlyplain' => 'Wäg meglige Fählinterpretatione sin nume Nochrichte mit reinem Text zuegloo.',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'sendmailtowiki-desc' => 'פרסום תוכן ויקי דרך כתובת דוא"ל דינמית ייעודית',
	'prefs-sendmailtowiki' => 'פרסום תוכן באמצעות דוא״ל',
	'sendmailtowiki-inemail' => 'כתובת דוא״ל ייעודית:',
	'sendmailtowiki-inpin' => 'מספר סודי:',
	'prefs-help-sendmailtowiki_pin' => 'שדה שחור למספר סודי מבטל את שליחת התוכן לוויקי עם החשבון שלך.',
	'sendmailtowiki-err-pinlength' => 'המספר הסודי צריך להכיל בדיוק 5 ספרות.',
	'sendmailtowiki-err-wrongprefix' => 'קידומת החשבון בוויקי שגויה. נא ליצור קשר עם המנהל שלך.',
	'sendmailtowiki-err-invalidaccount' => 'החשבון שגוי. אנא בדקו שוב את כתובת הדוא"ל אליה אתם שולחים.',
	'sendmailtowiki-err-invalidsender' => 'השולח שגוי. אנא בדקו את כתובת הדוא"ל ממנה אתם שולחים.',
	'sendmailtowiki-err-invalidpin' => 'מספר סודי שגוי. הגישה נחסמה.',
	'sendmailtowiki-err-onlyplain' => 'בגלל חוסר הבנה אפשרית, מתקבלות רק הודעות בטקסט טהור.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'sendmailtowiki-desc' => 'Wikiwobsah přez rezerwowanu dynamisku e-mejlowu adresu pósłać',
	'prefs-sendmailtowiki' => 'Wobsah přez e-mejl pósłać',
	'sendmailtowiki-inemail' => 'Rezerwowana e-mejlowa adresa:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Prózdne polo za PIN-čisło znjemóžnja słanje wobsaha do wikija z twojim kontom.',
	'sendmailtowiki-err-pinlength' => 'PIN dyrbi eksaktnje 5 cyfrow měć.',
	'sendmailtowiki-err-wrongprefix' => 'Wopačny wikikontowy prefiks. Staj so ze swojim administratorom do zwiska.',
	'sendmailtowiki-err-invalidaccount' => 'Njepłaćiwe konto. Přepruwuj e-mejlowu adresu, na kotruž chceš pósłać.',
	'sendmailtowiki-err-invalidsender' => 'Njepłaćiwy wotpósłar. Přepruwuj e-mejlowu adresu, z kotrejž chceš pósłać.',
	'sendmailtowiki-err-invalidpin' => 'Njepłaćiwy PIN. Přistup zapowědźeny.',
	'sendmailtowiki-err-onlyplain' => 'Dla potencielnych wopačnych interpretacijow so jenož powěsće z lutym tekstom akceptuja.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'sendmailtowiki-desc' => 'Wiki tartalom felküldése dedikált dinamikus e-mail címre',
	'prefs-sendmailtowiki' => 'Tartalom elküldése e-mailben',
	'sendmailtowiki-inemail' => 'Dedikált e-mail cím:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Az üresen hagyott PIN mező letiltja az e-mailben történő tartalomfelküldést a wikire a felhasználói fiókoddal.',
	'sendmailtowiki-err-pinlength' => 'A PIN-nek pontosan 5 számot kell tartalmaznia.',
	'sendmailtowiki-err-wrongprefix' => 'Hibás wiki felhasználói fiók előtag. Vedd fel a kapcsolatot az adminisztrátorokkal.',
	'sendmailtowiki-err-invalidaccount' => 'Érvénytelen felhasználói fiók. Ellenőrizd az e-mail címet, amelyre küldesz.',
	'sendmailtowiki-err-invalidsender' => 'Érvénytelen feladó. Ellenőrizd az e-mail címet, amelyről küldesz.',
	'sendmailtowiki-err-invalidpin' => 'Érvénytelen PIN. Hozzáférés megtagadva.',
	'sendmailtowiki-err-onlyplain' => 'A lehetséges félreértelmezések elkerülése miatt csak tisztán szöveges üzenetek elfogadhatóak.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'sendmailtowiki-desc' => 'Publicar contento wiki via un adresse de e-mail dynamic dedicate',
	'prefs-sendmailtowiki' => 'Publicar contento con e-mail',
	'sendmailtowiki-inemail' => 'Adresse de e-mail dedicate:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Si le campo pro le numero PIN es vacue, tu non pote publicar contento al wiki con tu conto.',
	'sendmailtowiki-err-pinlength' => 'Le PIN debe continer exactemente 5 numeros.',
	'sendmailtowiki-err-wrongprefix' => 'Prefixo de conto wiki incorrecte. Contacta tu administrator.',
	'sendmailtowiki-err-invalidaccount' => 'Conto invalide. Verifica le adresse e-mail de destination.',
	'sendmailtowiki-err-invalidsender' => 'Expeditor invalide. Verifica le adresse de e-mail del qual tu invia le messages.',
	'sendmailtowiki-err-invalidpin' => 'PIN invalide. Accesso refusate.',
	'sendmailtowiki-err-onlyplain' => 'Debite a potential errores de interpretation, solo le messages in texto simple es acceptate.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 */
$messages['id'] = array(
	'sendmailtowiki-desc' => 'Kirim isi wiki melalui alamat surel khusus yang dinamis',
	'prefs-sendmailtowiki' => 'Mengirimkan isi melalui surel',
	'sendmailtowiki-inemail' => 'Alamat surel khusus:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Kotak kosong untuk nomor PIN menghentikan pengiriman isi ke wiki menggunakan akun Anda.',
	'sendmailtowiki-err-pinlength' => 'PIN harus berisi 5 angka.',
	'sendmailtowiki-err-wrongprefix' => 'Prefiks akun wiki salah. Hubungi administrator Anda.',
	'sendmailtowiki-err-invalidaccount' => 'Akun salah. Cek alamat surel tujuan pengiriman Anda.',
	'sendmailtowiki-err-invalidsender' => 'Pengirim salah. Cek alamat surel asal pengiriman Anda.',
	'sendmailtowiki-err-invalidpin' => 'PIN salah. Akses ditolak.',
	'sendmailtowiki-err-onlyplain' => 'Karena kesalahpahaman, hanya pesan teks asli yang diterima.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'sendmailtowiki-inpin' => 'PIN:',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'sendmailtowiki-desc' => '専用の電子メールアドレスを通してウィキのコンテンツを投稿する',
	'prefs-sendmailtowiki' => '電子メールでコンテンツを投稿する',
	'sendmailtowiki-inemail' => '専用メールアドレス:',
	'sendmailtowiki-inpin' => '暗証番号:',
	'prefs-help-sendmailtowiki_pin' => '暗証番号を空欄にすると、あなたのアカウントではメールでウィキにコンテンツを投稿することができなくなります。',
	'sendmailtowiki-err-pinlength' => '暗証番号はちょうど5文字でなくてはなりません。',
	'sendmailtowiki-err-wrongprefix' => '誤ったウィキアカウント用接頭辞です。管理者に連絡してください。',
	'sendmailtowiki-err-invalidaccount' => 'アカウントが無効です。送信先のメールアドレスを確認してください。',
	'sendmailtowiki-err-invalidsender' => '送信者が無効です。送信元のメールアドレスを確認してください。',
	'sendmailtowiki-err-invalidpin' => '暗証番号が無効です。アクセスが拒否されました。',
	'sendmailtowiki-err-onlyplain' => '誤った解釈を防ぐために、純粋なテキストのメッセージのみを受け付けます。',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'sendmailtowiki-desc' => 'Donn övver en doför fallwieß faßjelaate Adräß övver <i lang="en">e-mail</i> en et Wiki schriive.',
	'prefs-sendmailtowiki' => 'Övver <i lang="en">e-mail</i> en et Wiki schriive',
	'sendmailtowiki-inemail' => 'De zohjedeijlte Adräß för <i lang="en">e-mail</i>:',
	'sendmailtowiki-inpin' => 'PIN-Kood:',
	'prefs-help-sendmailtowiki_pin' => 'Nix för dä PIN-Kood enzjävve schalldt et Schriive övver <i lang="en">e-mail</i> för Desch uß.',
	'sendmailtowiki-err-pinlength' => 'Dä PIN-Kood moß jenou 5 Zeffere lang sin.',
	'sendmailtowiki-err-wrongprefix' => 'Dat es ene verkehte Försaz fö ene Zohjang nohm Wiki. Donn ene Wiki_Köbes froore.',
	'sendmailtowiki-err-invalidaccount' => 'Dat es ene onjöltijje Zohjang zom Wiki. Donn de Adräß övverproove, woh Ding <i lang="en">e-mail</i> hen jejange es.',
	'sendmailtowiki-err-invalidsender' => 'Dat es ene onjöltijje Afsender. Donn Ding Äddräß pröve, vun woh De de <i lang="en">e-mail</i> verschek häß.',
	'sendmailtowiki-err-invalidpin' => 'Verkehte PIN-Kood. Zohjang nit zohjelohße.',
	'sendmailtowiki-err-onlyplain' => 'Domet et keine Dorjeneeijn jit, dum_mer bloß Nohreescht us öhndlijje Täxte aanämme.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'sendmailtowiki-desc' => 'Wki-Inhalt mat der zougewisener dynamescher E-Mailadress schécken',
	'prefs-sendmailtowiki' => 'Den Inhalt per E-Mail verschécken',
	'sendmailtowiki-inemail' => 'Zougewisen E-Mailadress:',
	'sendmailtowiki-inpin' => 'PIN:',
	'sendmailtowiki-err-pinlength' => 'De PIN muss genee 5 Zifferen hunn.',
	'sendmailtowiki-err-wrongprefix' => 'Falsche Prefix vum Benotzerkont. Kontaktéiert Ären Administrateur.',
	'sendmailtowiki-err-invalidaccount' => "Net valabele Kont. Kuckt w.e.g. d'E-Mailadress no op déi Dir Äre Mail schécke wëllt.",
	'sendmailtowiki-err-invalidsender' => 'Net valabelen Absender. Kuckt déi e-Mailadress no vun där Dir de Mail fortschéckt.',
	'sendmailtowiki-err-invalidpin' => 'PIN net valabel. Zougang refüséiert',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'sendmailtowiki-desc' => 'Објавување на вики-содржини преку специјална динамична е-поштенска адреса',
	'prefs-sendmailtowiki' => 'Објавување содржини со е-пошта',
	'sendmailtowiki-inemail' => 'Специјална е-поштенска адреса:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Празното поле за PIN-кодот не дозволува објавување на содржини на вики од вашата сметка.',
	'sendmailtowiki-err-pinlength' => 'PIN-кодот мора да содржи точно 5 броја.',
	'sendmailtowiki-err-wrongprefix' => 'Грешен префикс на вики-сметката. Контактирајте го администраторот.',
	'sendmailtowiki-err-invalidaccount' => 'Грешна сметка. Проверете ја е-поштенската адреса на која испраќате.',
	'sendmailtowiki-err-invalidsender' => 'Грешен праќач. Проверете ја е-поштенската адреса од која испраќате.',
	'sendmailtowiki-err-invalidpin' => 'Неважечки PIN. Влезот не ви е дозволен.',
	'sendmailtowiki-err-onlyplain' => 'За да се избегнат можни погрешни толкувања, се прифаќаат само пораки со прост текст.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'sendmailtowiki-desc' => "Wikipagina's aanmaken via een toegewezen dynamisch e-mailadres",
	'prefs-sendmailtowiki' => "Pagina's aanmaken via e-mail",
	'sendmailtowiki-inemail' => 'Toegewezen e-mailadres:',
	'sendmailtowiki-inpin' => 'PIN-code:',
	'prefs-help-sendmailtowiki_pin' => "Als het veld voor de PIN-code leeg is, kunt u geen pagina's aanmaken via e-mail met uw gebruiker.",
	'sendmailtowiki-err-pinlength' => 'De PIN-code moet precies vijf cijfers bevatten!',
	'sendmailtowiki-err-wrongprefix' => 'Verkeerd wikigebruikervoorvoegsel. Neem contact op met uw beheerder.',
	'sendmailtowiki-err-invalidaccount' => 'Ongeldige gebruiker. Controleer het e-mailadres waar u uw e-mail naar verzendt.',
	'sendmailtowiki-err-invalidsender' => 'Ongeldige afzenden. Controleer het e-mailadres waar u uw e-mails vandaan zendt.',
	'sendmailtowiki-err-invalidpin' => 'Ongeldige PIN-code. Geen toegang.',
	'sendmailtowiki-err-onlyplain' => 'Vanwege mogelijke interpretatieproblemen worden alleen berichten in platte tekst (MIME-type text/plain) geaccepteerd.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'sendmailtowiki-inpin' => 'PIN:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'sendmailtowiki-desc' => 'Legg inn wikiinnhold gjennom en dedikert dynamisk e-postadresse',
	'prefs-sendmailtowiki' => 'Legger til innhold via e-post',
	'sendmailtowiki-inemail' => 'Dedikert e-postadresse:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Om feltet for PIN-kode står tomt blir posting av innhold til wiki slått av for din konto.',
	'sendmailtowiki-err-pinlength' => 'PIN-koden må være akkurat 5 siffer.',
	'sendmailtowiki-err-wrongprefix' => 'Feil wikikontoprefiks. Kontakt din administrator.',
	'sendmailtowiki-err-invalidaccount' => 'Ugyldig konto. Sjekk e-postadressen du sender til.',
	'sendmailtowiki-err-invalidsender' => 'Ugyldig sender. Sjekk e-postadressen du sender fra.',
	'sendmailtowiki-err-invalidpin' => 'Ugyldig PIN. Ingen tilgang.',
	'sendmailtowiki-err-onlyplain' => 'På grunn av risikoen for feiltolkninger er kun rene tekstmeldinger tillatt.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'sendmailtowiki-desc' => 'Postar lo contengut wiki via una adreça de corrièl dedicada dinamica',
	'prefs-sendmailtowiki' => 'Publicacion del contengut per corrièl',
	'sendmailtowiki-inemail' => 'Adreça de corrièl dedicada :',
	'sendmailtowiki-inpin' => 'PIN :',
	'prefs-help-sendmailtowiki_pin' => 'Un camp void pel numèro PIN desactiva la publicacion de contengut sul wiki amb vòstre compte.',
	'sendmailtowiki-err-pinlength' => 'Lo PIN deu conténer exactament 5 chifras.',
	'sendmailtowiki-err-wrongprefix' => "Prefix de compte wiki erronèu. Contactatz l'administrator.",
	'sendmailtowiki-err-invalidaccount' => "Compte invalid. Verificatz l'adreça de corrièl de destinacion.",
	'sendmailtowiki-err-invalidsender' => "Expeditor invalid. Verificatz l'adreça de corrièl d'emission.",
	'sendmailtowiki-err-invalidpin' => 'PIN invalid. Accès refusat.',
	'sendmailtowiki-err-onlyplain' => "En rason d'eventualas errors d'interpretacions, sols los messatges que contenon de tèxte brut son acceptats.",
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'sendmailtowiki-desc' => 'Wysyłanie treści wiki poprzez dedykowany dynamiczny adres e‐mail',
	'prefs-sendmailtowiki' => 'Wysyłanie treści poprzez e‐mail',
	'sendmailtowiki-inemail' => 'Dedykowany adres e‐mail',
	'sendmailtowiki-inpin' => 'PIN',
	'prefs-help-sendmailtowiki_pin' => 'Puste pole na numer PIN wyłącza przesyłanie treści do wiki z Twojego konta.',
	'sendmailtowiki-err-pinlength' => 'PIN musi długość dokładnie 5 cyfr.',
	'sendmailtowiki-err-wrongprefix' => 'Zły przedrostek konta wiki. Skontaktuj się z administratorem.',
	'sendmailtowiki-err-invalidaccount' => 'Nieprawidłowe konto. Sprawdź adres pod który wysyłasz e‐mail.',
	'sendmailtowiki-err-invalidsender' => 'Nieprawidłowy nadawca. Sprawdź adres spod którego wysyłasz e‐mail.',
	'sendmailtowiki-err-invalidpin' => 'Nieprawidłowy PIN. Odmowa dostępu.',
	'sendmailtowiki-err-onlyplain' => 'Ze względu na możliwość nieprawidłowej interpretacji akceptowane są wyłącznie wiadomości czysto tekstowe.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'sendmailtowiki-desc' => 'Spediss contnù dla wiki con adrësse dinàmiche dedicà ëd pòsta eletrònica',
	'prefs-sendmailtowiki' => 'Publicassion ëd contnù për pòsta eletrònica',
	'sendmailtowiki-inemail' => 'Adrëssa ëd pòsta eletrònica dedicà:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Un camp veuid për ël nùmer PIN a disabìlita la publicassion ëd contnù an sla wiki con tò cont.',
	'sendmailtowiki-err-pinlength' => 'Ël PIN a dev conten-e pròpi 5 nùmer!',
	'sendmailtowiki-err-wrongprefix' => 'Prefiss dël cont wiki pa bon. Contata tò aministrator!',
	'sendmailtowiki-err-invalidaccount' => 'Cont pa bon. Contròla a che adrëssa ëd pòste eletrònica i të spedisse.',
	'sendmailtowiki-err-invalidsender' => "Mitent pa bon. Contròla l'adrëssa ëd pòsta eletrònica da andova i të spedisse.",
	'sendmailtowiki-err-invalidpin' => 'PIN pa bon. Intrada vietà.',
	'sendmailtowiki-err-onlyplain' => 'A càusa ëd possìbij antërpretassion pa bon-e a son mach acetà ëd mëssagi mach ëd test.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'sendmailtowiki-desc' => 'Publicação de conteúdos numa wiki, através de um endereço dedicado e dinâmico de correio electrónico',
	'prefs-sendmailtowiki' => 'Publicar conteúdos por correio electrónico',
	'sendmailtowiki-inemail' => 'Correio dedicado:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Número PIN vazio desactiva a publicação de conteúdos na wiki através da sua conta.',
	'sendmailtowiki-err-pinlength' => 'PIN tem de conter exactamente 5 algarismos!',
	'sendmailtowiki-err-wrongprefix' => 'Prefixo da conta wiki errado. Contacte o seu administrador!',
	'sendmailtowiki-err-invalidaccount' => 'Conta inválida. Verifique o endereço de correio de destino.',
	'sendmailtowiki-err-invalidsender' => 'Remetente inválido. Verifique o endereço de correio do remetente.',
	'sendmailtowiki-err-invalidpin' => 'PIN inválido. Acesso negado.',
	'sendmailtowiki-err-onlyplain' => 'Devido a potenciais erros de interpretação, só são aceites mensagens de texto.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'sendmailtowiki-desc' => 'Publicação de conteúdos numa wiki, através de um endereço de e-mail dinâmico e dedicado',
	'prefs-sendmailtowiki' => 'Publicar conteúdos por e-mail',
	'sendmailtowiki-inemail' => 'Endereço de e-mail dedicado:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Número PIN vazio desativa a publicação de conteúdos na wiki através da sua conta.',
	'sendmailtowiki-err-pinlength' => 'PIN precisa conter exatamente 5 algarismos.',
	'sendmailtowiki-err-wrongprefix' => 'Prefixo da conta wiki errado. Contate o seu administrador!',
	'sendmailtowiki-err-invalidaccount' => 'Conta inválida. Verifique o endereço de e-mail de destino.',
	'sendmailtowiki-err-invalidsender' => 'Remetente inválido. Verifique o endereço de e-mail do remetente.',
	'sendmailtowiki-err-invalidpin' => 'PIN inválido. Acesso negado.',
	'sendmailtowiki-err-onlyplain' => 'Devido a potenciais erros de interpretação, só são aceites mensagens de texto.',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'sendmailtowiki-desc' => 'Размещение содержимого вики посредством специального динамического адреса электронной почты',
	'prefs-sendmailtowiki' => 'Публикация текста с адресами электронной почтой',
	'sendmailtowiki-inemail' => 'Специальный адрес электронной почты:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Пустое поле ПИН-кода не позволяет разместить материал в вики с вашей учётной записи.',
	'sendmailtowiki-err-pinlength' => 'ПИН-код должен содержать ровно 5 цифр.',
	'sendmailtowiki-err-wrongprefix' => 'Неправильный префикс учётной записи в вики. Обратитесь к администратору.',
	'sendmailtowiki-err-invalidaccount' => 'Ошибочная учётная запись. Проверьте адрес электронной почты, на который производится отправка.',
	'sendmailtowiki-err-invalidsender' => 'Ошибочная значение отправителя. Проверьте адрес электронной почты, с которого вы отправляете.',
	'sendmailtowiki-err-invalidpin' => 'Ошибочный PIN-код. Отказано в доступе.',
	'sendmailtowiki-err-onlyplain' => 'Во избежание возможных недоразумений, допускаются исключительно текстовые сообщения.',
);

/** Slovenian (Slovenščina) */
$messages['sl'] = array(
	'sendmailtowiki-desc' => 'Pošiljanje wiki vsebine preko namenskega dinamičnega email naslova.',
	'prefs-sendmailtowiki' => 'Pošiljanje vsebine prek emaila',
	'sendmailtowiki-inemail' => 'Namenski email:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Prazno polje za PIN številko onemogoči pošiljanje vsebine na wiki prek vašega računa.',
	'sendmailtowiki-err-pinlength' => 'PIN mora vsebovati točno 5 številk!',
	'sendmailtowiki-err-wrongprefix' => 'Napačna wiki predpona. Kontaktirajte vašega administratorja!',
	'sendmailtowiki-err-invalidaccount' => 'Nepravilen račun. Preverite email naslov na katerega pošiljate.',
	'sendmailtowiki-err-invalidsender' => 'Nepravilen pošiljatelj. Preverite email naslov iz katerega pošiljate.',
	'sendmailtowiki-err-invalidpin' => 'Nepravilen PIN. Dostop zavrnjen.',
	'sendmailtowiki-err-onlyplain' => 'Zaradi potencialnega nepravilnega interpretiranja so podprta samo text/plain sporočila.',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'prefs-sendmailtowiki' => 'Postar innehåll via e-post',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Om PIN-koden lämnas blank så omöjliggörs det att posta innehåll till wikin med ditt konto.',
	'sendmailtowiki-err-pinlength' => 'PIN-koden måste bestå av exakt 5 siffror.',
	'sendmailtowiki-err-invalidaccount' => 'Ogiltigt konto. Kontrollera e-postadressen du skickar till.',
	'sendmailtowiki-err-invalidsender' => 'Ogiltig sändare. Kontrollera e-postadressen du skickar ifrån.',
	'sendmailtowiki-err-invalidpin' => 'Ogiltig PIN. Åtkomst nekad.',
	'sendmailtowiki-err-onlyplain' => 'Pågrund av risken för feltolkningar så är endast rena textmeddelanden tillåtna.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'sendmailtowiki-desc' => 'Ipaskil ang nilalaman ng wiki sa pamamagitan ng nakalaang masiglang adres ng e-liham',
	'prefs-sendmailtowiki' => 'Ipinapaskil ang nilalaman na may e-liham',
	'sendmailtowiki-inemail' => 'Nakalaang tirahan ng e-liham:',
	'sendmailtowiki-inpin' => 'PIN:',
	'prefs-help-sendmailtowiki_pin' => 'Hindi pinagagana ng walang lamang lugar para sa bilang ng PIN ang pagpapaskil ng nilalaman sa wiki na may akawnt mo.',
	'sendmailtowiki-err-pinlength' => 'Dapat na maglaman ng ganap na 5 mga bilang ang PIN.',
	'sendmailtowiki-err-wrongprefix' => 'Maling unlapi ng akawnt na pangwiki.  Makipag-ugnayan sa iyong tagapangasiwa.',
	'sendmailtowiki-err-invalidaccount' => 'Hindi tanggap na akawnt.  Suriin ang tirahan ng e-liham na padadalhan mo.',
	'sendmailtowiki-err-invalidsender' => 'Hindi tanggap na tagapagpadala.  Suriin ang tirahan ng e-liham na panggagalingan mo.',
	'sendmailtowiki-err-invalidpin' => 'Hindi tanggap na PIN. Tinanggihan ang pagpunta.',
	'sendmailtowiki-err-onlyplain' => 'Dahil sa maaaring maging maling pag-unawa tanging dalisay na mga mensaheng teksto lang ang tinatanggap.',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'prefs-sendmailtowiki' => 'E-posta ile içerik gönderiliyor',
	'sendmailtowiki-inemail' => 'Atanmış e-posta adresi:',
	'sendmailtowiki-inpin' => 'PIN:',
	'sendmailtowiki-err-pinlength' => 'PIN, tam olarak 5 rakam içermeli.',
	'sendmailtowiki-err-invalidsender' => 'Geçersiz gönderen. Gönderdiğiniz e-posta adresini kontrol edin.',
	'sendmailtowiki-err-invalidpin' => 'Geçersiz PIN. Erişime izin verilmedi.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'sendmailtowiki-desc' => 'Đăng nội dung wiki bằng cách gửi thư điện tử từ một địa chỉ động',
	'prefs-sendmailtowiki' => 'Gửi nội dung qua thư điện tử',
	'sendmailtowiki-inpin' => 'PIN:',
	'sendmailtowiki-err-pinlength' => 'Số PIN phải có đúng 5 chữ số.',
	'sendmailtowiki-err-wrongprefix' => 'Tiền tố tài khoản wiki sai; hãy liên lạc với bảo quản viên.',
	'sendmailtowiki-err-invalidaccount' => 'Tài khoản nhận không hợp lệ. Hãy kiểm tra địa chỉ nhận thư điện tử.',
	'sendmailtowiki-err-invalidsender' => 'Tài khoản gửi không hợp lệ. Hãy kiểm tra địa chỉ gửi thư điện tử.',
);

