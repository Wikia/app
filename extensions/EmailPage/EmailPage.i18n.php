<?php
/**
 * Internationalisation file for extension EmailPage.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Nad
 */
$messages['en'] = array(
	'e-mailpage'          => "E-mail page",
	'ea-desc'             => "Send rendered HTML page to an e-mail address or list of addresses using [http://phpmailer.sourceforge.net phpmailer]",
	'ea-heading'          => 'E-mailing the page "[[$1]]"',
	'ea-group-info'       => "Additionally you can send the page to the members of a group",
	'ea-pagesend'         => 'Page "$1" sent from $2',
	'ea-nopage'           => "No page was specified for sending, please use the e-mail link from the sidebar or page actions.",
	'ea-norecipients'     => "No valid e-mail addresses found!",
	'ea-listrecipients'   => 'Listing {{PLURAL:$1|recipient|$1 recipients}}',
	'ea-error'            => "'''Error sending [[$1]]:''' ''$2''",
	'ea-denied'           => "Permission denied",
	'ea-sent'             => "Page [[$1]] sent successfully to '''$2''' {{PLURAL:$2|recipient|recipients}} by [[User:$3|$3]].",
	'ea-compose'          => "Compose content",
	'ea-show'             => "View recipient list",
	'ea-from'             => 'From:',
	'ea-to'               => 'To:',
	'ea-to-info'          => "E-mail addresses can be separated with one or more semicolon, comma, asterisk or newline characters",
	'ea-cc'               => 'CC:',
	'ea-send'             => "Send",
	'ea-subject'          => 'Subject:',
	'ea-message'          => 'Message:',
	'ea-message-info'     => "Prepend content with optional wikitext message",
	'ea-style'            => 'Style:',
	'ea-selectcss'        => "You can select a stylesheet",
	'ea-data'             => "Data",
	'ea-selectrecord'     => "These templates can be used to fill in fields in the message content",
	'ea-allusers'         => "All users"
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Purodha
 * @author Whym
 */
$messages['qqq'] = array(
	'e-mailpage' => 'The first heading text shown in a sending form of Special:EmailPage.',
	'ea-pagesend' => 'This message is used in the e-mail header as content of the "Subject: "-field.

Parameters:
* $1 - page title
* $2 - name of the wiki, same as <code lang="en"><nowiki>{{SITENAME}}
</nowiki></code>',
	'ea-denied' => '{{Identical|Permission denied}}',
	'ea-from' => '{{Identical|From}}',
	'ea-to' => '{{Identical|To}}',
	'ea-send' => '{{Identical|Send}}',
	'ea-subject' => '{{Identical|Subject}}',
	'ea-message' => '{{Identical|Message}}',
	'ea-data' => '{{Identical|Data}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'e-mailpage' => 'E-posbladsy',
	'ea-denied' => 'Toestemming geweier',
	'ea-compose' => 'Stel inhoud saam',
	'ea-show' => 'Wys lys van ontvangers',
	'ea-from' => 'Van:',
	'ea-to' => 'Aan:',
	'ea-cc' => 'CC:',
	'ea-send' => 'Stuur',
	'ea-subject' => 'Onderwerp:',
	'ea-message' => 'Boodskap:',
	'ea-style' => 'Styl:',
	'ea-selectcss' => 'U kan \'n "stylesheet" kies',
	'ea-data' => 'Data',
	'ea-allusers' => 'Alle gebruikers',
);

/** Arabic (العربية)
 * @author Imksa
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'e-mailpage' => 'إرسال رسالة للمستخدم',
	'ea-desc' => 'يرسل صفحة ناتجة ب HTML لعنوان بريد إلكتروني أو قائمة عناوين باستخدام [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== مراسلة الصفحة [[$1]] ===',
	'ea-group-info' => 'بالإضافة إلى ذلك يمكنك إرسال الصفحة إلى أعضاء مجموعة',
	'ea-pagesend' => 'الصفحة "$1" أُرسلت من $2',
	'ea-nopage' => 'لم يتم تحديد صفحة لارسالها  ، الرجاء استخدام الرابط البريد الإلكتروني من القائمة الجانبية أو من أحداث الصفحة.',
	'ea-norecipients' => 'لم يتم إيجاد عناوين بريد إلكتروني صحيحة!',
	'ea-listrecipients' => '=== {{PLURAL:$1|متلقي|$1 متلقي}} ===',
	'ea-error' => "'''خطأ في إرسال [[$1]]:''' ''$2''",
	'ea-denied' => 'السماح مرفوض',
	'ea-sent' => "الصفحة [[$1]] تم إرسالها بنجاح إلى '''$2''' {{PLURAL:$2|متلق|متلق}} بواسطة [[User:$3|$3]].",
	'ea-compose' => 'كتابة المحتوى',
	'ea-show' => 'عرض المتلقين',
	'ea-from' => 'من:',
	'ea-to' => 'إلى:',
	'ea-to-info' => 'يمكن فصل عناوين البريد الإلكتروني عن بعض باستخدام  الفاصلة المنقوطة أو فاصلة،أوسطر جديد',
	'ea-cc' => 'نسخة مخفية',
	'ea-send' => 'أرسل',
	'ea-subject' => 'الموضوع:',
	'ea-message' => 'الرسالة:',
	'ea-message-info' => 'الافتتاحية محتوى رسالة مع نص ويكي اختياري',
	'ea-style' => 'نمط:',
	'ea-selectcss' => 'يمكنك تحديد ورقة أنماط',
	'ea-data' => 'البيانات',
	'ea-selectrecord' => 'يمكن استخدام هذه القوالب لتعبئة الحقول في محتوى الرسالة',
	'ea-allusers' => 'كافة المستخدمين',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'e-mailpage' => 'إرسال رسالة للمستخدم',
	'ea-desc' => 'يرسل صفحة ناتجة ب HTML لعنوان بريد إلكترونى أو قائمة عناوين باستخدام [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== مراسلة الصفحة [[$1]] ===',
	'ea-pagesend' => 'الصفحة "$1" أُرسلت من $2',
	'ea-nopage' => 'من فضلك حدد صفحة للإرسال، على سبيل المثال "[[Special:e-mailpage/{{MediaWiki:Mainpage-url}}]]".',
	'ea-norecipients' => 'لم يتم إيجاد عناوين بريد إلكترونى صحيحة!',
	'ea-listrecipients' => '=== {{PLURAL:$1|متلقي|$1 متلقي}} ===',
	'ea-error' => "'''خطأ في إرسال [[$1]]:''' ''$2''",
	'ea-denied' => 'السماح مرفوض',
	'ea-sent' => "الصفحة [[$1]] تم إرسالها بنجاح إلى '''$2''' {{PLURAL:$2|متلق|متلق}} بواسطة [[User:$3|$3]].",
	'ea-compose' => 'كتابة المحتوى',
	'ea-show' => 'عرض المتلقين',
	'ea-send' => 'إرسال!',
	'ea-subject' => 'أدخل سطر عنوان للبريد الإلكتروني',
	'ea-message' => 'إرسال المحتوى برسالة اختيارية (نص ويكى)',
	'ea-selectcss' => 'اختر شريحة CSS',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Proger
 */
$messages['az'] = array(
	'e-mailpage' => 'E-poçt səhifəsi',
	'ea-from' => 'Kimdən:',
	'ea-to' => 'Kimə:',
	'ea-cc' => 'Surəti',
	'ea-send' => 'Göndər',
	'ea-subject' => 'Başlıq:',
	'ea-message' => 'Məktub:',
	'ea-style' => 'Stil:',
	'ea-data' => 'Tarix',
	'ea-allusers' => 'Bütün istifadəçilər',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'e-mailpage' => 'Даслаць старонку па электроннай пошце',
	'ea-desc' => 'Дасылае HTML-старонку на адрас электроннай пошты ці групу адрасоў, з выкарыстаньнем [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => 'Адпраўка старонкі «[[$1]]» па электроннай пошце',
	'ea-group-info' => 'Дадаткова Вы можаце даслаць старонку сябрам групы',
	'ea-pagesend' => 'Старонка «$1» дасланая з $2',
	'ea-nopage' => 'Ня выбраныя старонкі для адпраўкі. Калі ласка, выкарыстоўвайце спасылку на электронную пошту ў бакавой панэлі ці ў дзеяньнях старонкі.',
	'ea-norecipients' => 'Ня знойдзеныя слушныя адрасы электроннай пошты!',
	'ea-listrecipients' => '{{PLURAL:$1|Атрымальнік|Атрымальнікі}}',
	'ea-error' => "'''Памылка адпраўкі [[$1]]:''' ''$2''",
	'ea-denied' => 'Доступ забаронены',
	'ea-sent' => "Старонка [[$1]] дасланая пасьпяхова '''$2''' {{PLURAL:$2|атрымальніку|атрымальнікам|атрымальнікам}} ад [[User:$3|$3]].",
	'ea-compose' => 'Стварэньне зьместу',
	'ea-show' => 'Паказаць сьпіс атрымальнікаў',
	'ea-from' => 'Ад:',
	'ea-to' => 'Да:',
	'ea-to-info' => 'Адрасы электроннай пошты могуць падзяляцца адной ці болей кропкай з коскай, коскай, зоркай ці сымбалем пачатку новага радку',
	'ea-cc' => 'Копія:',
	'ea-send' => 'Даслаць',
	'ea-subject' => 'Тэма:',
	'ea-message' => 'Паведамленьне:',
	'ea-message-info' => 'Далучыць зьмест з магчымым паведамленьнем у вікі-фармаце',
	'ea-style' => 'Стыль:',
	'ea-selectcss' => 'Вы можаце выбраць табліцу стыляў',
	'ea-data' => 'Зьвесткі',
	'ea-selectrecord' => 'Гэтыя шаблёны могуць выкарыстоўвацца для запаўненьня палёў ў зьмесьце паведамленьня',
	'ea-allusers' => 'Усе ўдзельнікі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'ea-nopage' => 'Необходимо е да се посочи страница, която да бъде изпратена, напр. [[Special:e-mailpage/Начална страница]].',
	'ea-norecipients' => 'Не бяха намерени валидни адреси за е-поща!',
	'ea-listrecipients' => '=== Списък на $1 {{PLURAL:$1|получател|получателя}} ===',
	'ea-error' => "'''Грешка при изпращане на [[$1]]:''' ''$2''",
	'ea-show' => 'Показване на получателите',
	'ea-from' => 'От:',
	'ea-to' => 'До:',
	'ea-send' => 'Изпращане!',
	'ea-subject' => 'Тема:',
	'ea-message' => 'Съобщение:',
	'ea-selectcss' => 'Избиране на CSS стил',
	'ea-allusers' => 'Всички потребители',
);

/** Bengali (বাংলা)
 * @author Ehsanulhb
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'e-mailpage' => 'পাতা ই-মেইল',
	'ea-heading' => 'পাতা "[[$1]]"-কে ই-মেইল করো',
	'ea-group-info' => 'সেই সাথে আপনি এই পাতাটি একটু দলের সদস্যদের কাছে পাঠাতে পারেন',
	'ea-norecipients' => 'কোনো সঠিক ই-মেইল ঠিকানা খুঁজে পাওয়া যায়নি!',
	'ea-denied' => 'অনুমতি প্রত্যাখ্যাত হয়েছে।',
	'ea-from' => 'প্রেরক:',
	'ea-to' => 'প্রাপক:',
	'ea-cc' => 'সিসি:',
	'ea-send' => 'প্রেরণ',
	'ea-subject' => 'বিষয়:',
	'ea-message' => 'বার্তা:',
	'ea-style' => 'স্টাইল:',
	'ea-selectcss' => 'আপনি একটি স্টাইলশিট নির্বাচন করতে পারেন',
	'ea-data' => 'তথ্য',
	'ea-allusers' => 'সকল ব্যবহারকারী',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'e-mailpage' => 'Kas ar bajenn dre bostel',
	'ea-desc' => "Kas a ra ur bajenn doare HTML d'ur chomlec'h postel pe d'ur roll chomlec'hioù en ur ober gant [http://phpmailer.sourceforge.net phpmailer]",
	'ea-heading' => 'Kas ar bajenn dre bostel "[[$1]]"',
	'ea-group-info' => 'Gallout a rit kas ar bajenn da izili ur strollad ivez',
	'ea-pagesend' => 'Pajenn "$1" kaset adalek $2',
	'ea-nopage' => "N'eus bet spisaet pajenn ebet da vezañ kaset, grit gant al liamm postel er varrenn-gostez pe obererezhioù ar bajenn.",
	'ea-norecipients' => "N'eus bet kavet chomlec'h postel reizh ebet !",
	'ea-listrecipients' => 'O rollañ {{PLURAL:$1|resever|$1 resever}}',
	'ea-error' => "'''Fazi en ur gas [[$1]]:''' ''$2''",
	'ea-denied' => "Aotre nac'het",
	'ea-sent' => "Kaset eo bet ar bajenn [[$1]] ervat da '''$2''' {{PLURAL:$2|resever|resever}} gant [[User:$3|$3]].",
	'ea-compose' => 'Sevel ar pennad-skrid',
	'ea-show' => 'Gwelet roll ar reseverien',
	'ea-from' => 'Digant :',
	'ea-to' => 'Da :',
	'ea-to-info' => "Gallout a ra ar chomlec'hioù postel bezañ dispartiet dre ur pik-skej pe meur a hini, ur skej, ur steredennig pe arouezennoù linenn nevez",
	'ea-cc' => 'CC :',
	'ea-send' => 'Kas',
	'ea-subject' => 'Danvez :',
	'ea-message' => 'Postel :',
	'ea-message-info' => 'Lakaat ur gemennadenn diret e wikistestenn a-raok danvez ar postel',
	'ea-style' => 'Stil :',
	'ea-selectcss' => 'Dibabit ur follenn stil CSS',
	'ea-data' => 'Roadennoù',
	'ea-selectrecord' => "Ober gant ar patromoù-mañ a c'haller da leuniañ maeziennoù e diabarzh ar postel",
	'ea-allusers' => 'An holl implijerien',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'e-mailpage' => 'Stranica za e-mail',
	'ea-desc' => 'Omogućava slanje HTML stranice na adresu e-maila ili spisak adresa koristeći [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => 'E-mailom šaljem stranicu "[[$1]]"',
	'ea-group-info' => 'Dodatno možete poslati stranicu članovima grupe',
	'ea-pagesend' => 'Stranica "$1" poslana od $2',
	'ea-nopage' => 'Nije određena stranica za slanje, molimo koristite e-mail link iz menija sa strane ili akcije stranice.',
	'ea-norecipients' => 'Nisu pronađene valjane e-mail adrese!',
	'ea-listrecipients' => 'Prikazujem {{PLURAL:$1|primaoca|$1 primaoca}}',
	'ea-error' => "'''Greška pri slanju [[$1]]:''' ''$2''",
	'ea-denied' => 'Pristup onemogućen',
	'ea-sent' => "Stranica [[$1]] uspješno poslana na '''$2''' {{PLURAL:$2|primaoca|primaoca|primaoce}} od strane [[User:$3|$3]].",
	'ea-compose' => 'Unesi sadržaj',
	'ea-show' => 'Vidi spisak primaoca',
	'ea-from' => 'Od:',
	'ea-to' => 'Za:',
	'ea-to-info' => 'E-mail adrese mogu biti odvojene sa dvije tačke ili više njih, zarezom, zvijezdicom ili znakom za novi red',
	'ea-cc' => 'CC:',
	'ea-send' => 'Pošalji',
	'ea-subject' => 'Tema:',
	'ea-message' => 'Poruka:',
	'ea-message-info' => 'Spoji sadržaj sa opcionalnom porukom u wikitekstu',
	'ea-style' => 'Stil:',
	'ea-selectcss' => 'Možete odabrati CSS-stylesheet',
	'ea-data' => 'Podatak',
	'ea-selectrecord' => 'Ovi šabloni se mogu koristiti za ispunjavanje polja u sadržaju poruke',
	'ea-allusers' => 'Svi korisnici',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'ea-from' => 'Соьгар:',
	'ea-to' => 'Хьан:',
	'ea-message' => 'Хаам:',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'ea-to' => 'À:',
	'ea-subject' => 'Sughjettu:',
	'ea-message' => 'Messaghju:',
);

/** German (Deutsch)
 * @author Church of emacs
 * @author Kghbln
 * @author Leithian
 * @author kghbln
 */
$messages['de'] = array(
	'e-mailpage' => 'Per E-Mail versenden',
	'ea-desc' => 'Ermöglicht das Versenden von HTML-Seiten an E-Mail-Adressen oder E-Mail-Adresslisten mit [http://phpmailer.worxware.com/ PHPMailer]',
	'ea-heading' => '=== E-Mail-Versand von Seite „[[$1]]“ ===',
	'ea-group-info' => 'Zusätzlich kann die Seite an die Mitglieder einer Benutzergruppe gesandt werden',
	'ea-pagesend' => 'Seite „$1“ (aus $2)',
	'ea-nopage' => 'Zum Versenden wurde keine Seite angegeben. Bitte den Link „Per E-Mail versenden“ in der Seitenleiste unter Werkzeuge oder den entsprechenden Reiter oben in der Menüleiste verwenden.',
	'ea-norecipients' => 'Es sind keine E-Mail-Adressen zum Versenden vorhanden!',
	'ea-listrecipients' => '=== {{PLURAL:$1|Empfänger|$1 Empfänger}} ===',
	'ea-error' => "'''Fehler beim Versenden von Seite „[[$1]]“:''' $2",
	'ea-denied' => 'E-Mail-Versand konnte aufgrund fehlender Berechtigung nicht durchgeführt werden.',
	'ea-sent' => "Seite „[[$1]]“ wurde erfolgreich von [[User:$3|$3]] an '''$2''' {{PLURAL:$2|Empfänger|Empfänger}} versandt.",
	'ea-compose' => 'Nachricht verfassen',
	'ea-show' => 'Empfänger anzeigen',
	'ea-from' => 'Von:',
	'ea-to' => 'An:',
	'ea-to-info' => 'E-Mail-Adressen können mit einem Semikolon, Komma, Sternchen oder einem Zeichen für eine neue Zeile („\\n“) voneinander getrennt werden',
	'ea-cc' => 'CC:',
	'ea-send' => 'Senden',
	'ea-subject' => 'Betreff:',
	'ea-message' => 'Nachricht:',
	'ea-message-info' => 'Dem Inhalt der Seite eine Nachricht voranstellen (optional, Eingabe in Wikitext erforderlich):',
	'ea-style' => 'Stil:',
	'ea-selectcss' => 'Stylesheet auswählen:',
	'ea-data' => 'Daten',
	'ea-selectrecord' => 'Diese Vorlagen können genutzt werden, um in der Nachricht vorhandene Felder zu vervollständigen:',
	'ea-allusers' => 'Alle Benutzer',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 */
$messages['diq'] = array(
	'ea-data' => 'Daye',
);

/** Greek (Ελληνικά)
 * @author Glavkos
 */
$messages['el'] = array(
	'e-mailpage' => 'Σελίδα ηλεκτρονικού ταχυδρομείου',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'e-mailpage' => 'Retpoŝtigi paĝon',
	'ea-heading' => '=== Retpoŝtigante paĝon [[$1]] ===',
	'ea-pagesend' => 'Paĝo "$1" sendita de $2',
	'ea-nopage' => 'Bonvolu enigi paĝon por retsendi, ekz-e [[Special:e-mailpage/Main Page]].',
	'ea-norecipients' => 'Neniaj validaj retadresoj trovitaj!',
	'ea-listrecipients' => '=== Listo de $1 {{PLURAL:$1|ricevonto|ricevontoj}} ===',
	'ea-error' => "'''Eraro sendante [[$1]]:''' ''$2''",
	'ea-denied' => 'Malpermesite',
	'ea-sent' => "Paĝo [[$1]] sendita sukcese al '''$2''' {{PLURAL:$2|ricevonto|ricevontoj}} de [[User:$3|$3]].",
	'ea-compose' => 'Skribu enhavon',
	'ea-send' => 'Sendi!',
	'ea-selectcss' => 'Vi povas elekti CSS-tiparŝablono',
);

/** Spanish (Español)
 * @author Dferg
 * @author Fitoschido
 * @author Mor
 */
$messages['es'] = array(
	'e-mailpage' => 'Página de correo electrónico',
	'ea-group-info' => 'Además puedes enviar la página a los miembros de un grupo',
	'ea-pagesend' => 'Página «$1» enviada desde $2',
	'ea-denied' => 'Acceso denegado',
	'ea-from' => 'De:',
	'ea-to' => 'Para:',
	'ea-cc' => 'CC (con copia):',
	'ea-send' => 'Enviar',
	'ea-subject' => 'Asunto:',
	'ea-message' => 'Mensaje:',
	'ea-data' => 'Fecha',
	'ea-selectrecord' => 'Estas plantillas se pueden utilizar para rellenar los campos en el contenido del mensaje',
	'ea-allusers' => 'Todos los usuarios',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'ea-from' => 'از:',
	'ea-to' => 'به:',
);

/** French (Français)
 * @author Grondin
 * @author Od1n
 * @author Peter17
 */
$messages['fr'] = array(
	'e-mailpage' => 'Envoyer l’article par courriel',
	'ea-desc' => 'Envoie le rendu d’une page HTML à une adresse électronique où à une liste d’adresses en utilisant [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => '=== Envoi de la page [[$1]] par courrier électronique ===',
	'ea-group-info' => 'De plus, vous pouvez envoyer la page aux membres d’un groupe',
	'ea-pagesend' => 'Page « $1 » envoyée depuis $2',
	'ea-nopage' => 'Aucune page à envoyer n’a été spécifiée. Veuillez utiliser le lien d’envoi de la barre latérale ou les actions de la page.',
	'ea-norecipients' => 'Aucune adresse courriel de trouvée !',
	'ea-listrecipients' => '=== Liste de $1 {{PLURAL:$1|destinataire|destinataires}} ===',
	'ea-error' => "'''Erreur de l’envoi de [[$1]] :''' ''$2''",
	'ea-denied' => 'Permission refusée',
	'ea-sent' => "L'article [[$1]] a été envoyé avec succès à '''$2''' {{PLURAL:$2|destinataire|destinataires}} par [[User:$3|$3]].",
	'ea-compose' => 'Composer le contenu',
	'ea-show' => 'Visionner les destinataires',
	'ea-from' => 'De :',
	'ea-to' => 'À :',
	'ea-to-info' => 'Les adresses électroniques peuvent être séparées par un ou plusieurs point virgule, virgule, astérisque ou caractère de nouvelle ligne',
	'ea-cc' => 'Copie :',
	'ea-send' => 'Envoyer',
	'ea-subject' => 'Objet :',
	'ea-message' => 'Message :',
	'ea-message-info' => 'Faire précéder le contenu d’un message facultatif en wikitexte',
	'ea-style' => 'Style :',
	'ea-selectcss' => 'Vous pouvez sélectionner une feuille de style',
	'ea-data' => 'Données',
	'ea-selectrecord' => 'Ces modèles peuvent être utilisés pour remplir les champs dans le contenu du message',
	'ea-allusers' => 'Tous les utilisateurs',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'e-mailpage' => 'Mandar la pâge per mèssageria èlèctronica',
	'ea-heading' => 'Èxpèdicion de la pâge « [[$1]] » per mèssageria èlèctronica',
	'ea-pagesend' => 'Pâge « $1 » mandâ dês $2',
	'ea-norecipients' => 'Niona adrèce èlèctronica at étâ trovâ !',
	'ea-listrecipients' => 'Lista de $1 dèstinatèro{{PLURAL:$1||s}}',
	'ea-error' => "'''Èrror pendent l’èxpèdicion de [[$1]] :''' ''$2''",
	'ea-denied' => 'Pèrmission refusâ',
	'ea-compose' => 'Composar lo contegnu',
	'ea-show' => 'Vêre la lista de dèstinatèros',
	'ea-from' => 'De :',
	'ea-to' => 'Dèstinatèro :',
	'ea-cc' => 'Copia :',
	'ea-send' => 'Mandar',
	'ea-subject' => 'Sujèt :',
	'ea-message' => 'Mèssâjo :',
	'ea-style' => 'Stilo :',
	'ea-selectcss' => 'Vos pouede chouèsir una fôlye de stilo',
	'ea-data' => 'Balyês',
	'ea-allusers' => 'Tôs los usanciérs',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'e-mailpage' => 'Enviar a páxina por correo electrónico',
	'ea-desc' => 'Enviar páxinas HTML renderizadas a un enderezo de correo electrónico (ou a varios correos) usando [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== Enviando a páxina "[[$1]]" ===',
	'ea-group-info' => 'Ademais, pode enviar a páxina aos membros dun grupo',
	'ea-pagesend' => 'A páxina "$1" foi enviada desde $2',
	'ea-nopage' => 'Non especificou ningunha páxina para enviar; empregue a ligazón da caixa lateral para esta operación.',
	'ea-norecipients' => 'Non foi atopado ningún enderezo de correo electrónico válido!',
	'ea-listrecipients' => '{{PLURAL:$1|Nome do destinatario|Lista dos $1 destinatarios}}',
	'ea-error' => "'''Erro no envío de \"[[\$1]]\":''' ''\$2''",
	'ea-denied' => 'Permiso denegado',
	'ea-sent' => 'A páxina "[[$1]]" foi enviada con éxito a \'\'\'$2\'\'\' {{PLURAL:$2|destinatario|destinatarios}} por [[User:$3|$3]].',
	'ea-compose' => 'Compoñer o contido',
	'ea-show' => 'Mostrar os destinatarios',
	'ea-from' => 'De:',
	'ea-to' => 'Para:',
	'ea-to-info' => 'Os enderezos de correo electrónico pódense separar mediante un punto e coma, unha coma, un asterisco ou unha nova liña',
	'ea-cc' => 'Copia:',
	'ea-send' => 'Enviar',
	'ea-subject' => 'Asunto:',
	'ea-message' => 'Mensaxe:',
	'ea-message-info' => 'Inclúa unha mensaxe opcional con texto wiki antes do contido',
	'ea-style' => 'Estilo:',
	'ea-selectcss' => 'Pode seleccionar unha folla de estilo',
	'ea-data' => 'Datos',
	'ea-selectrecord' => 'Pódense empregar estes modelos para encher os campos no contido da mensaxe',
	'ea-allusers' => 'Todos os usuarios',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'e-mailpage' => 'Syte per E-Mail verschicke',
	'ea-desc' => 'Macht s Verschicke vu HTML-Syten an E-Mail-Adrässe oder E-Mail-Adrässlischte mit [http://phpmailer.worxware.com/ PHPMailer] megli',
	'ea-heading' => 'D Syte „[[$1]]“ per Mail verschicke',
	'ea-group-info' => 'Zuesätzli cha d Syte an d Mitglider vun ere Benutzergruppe gschickt wäre',
	'ea-pagesend' => 'Syte „$1“ (us $2)',
	'ea-nopage' => 'Zum Verschicke isch kei Syte aagee wore. Bitte dr Link „Syte per E-Mail verschicke“ in dr Syteleischte oder dr Ryter obe in dr Menüleischte verwände.',
	'ea-norecipients' => 'S git kei E-Mail-Adrässe zum Verschicke!',
	'ea-listrecipients' => 'Lischt mit {{PLURAL:$1|Empfänger|$1 Empfänger}}',
	'ea-error' => "'''Fähler bim Verschicke vu dr Syte „[[$1]]“:''' $2",
	'ea-denied' => 'Zuegriff verweigeret',
	'ea-sent' => "D Syte „[[$1]]“ isch erfolgryych vu [[User:$3|$3]] an '''$2''' {{PLURAL:$2|Empfänger|Empfänger}} verschickt wore.",
	'ea-compose' => 'Nochricht verfasse',
	'ea-show' => 'Empfänger aazeige',
	'ea-from' => 'Vu:',
	'ea-to' => 'An:',
	'ea-to-info' => 'E-Mail-Adrässe chenne mit eme Semikolon, Komma, Stärnli oder eme Zeiche fir e neji Zyyle („\\n“) vunenander drännt wäre',
	'ea-cc' => 'CC:',
	'ea-send' => 'Abschicke',
	'ea-subject' => 'Beträff:',
	'ea-message' => 'Nochricht:',
	'ea-message-info' => 'Vor dr Inhalt e optionali Wikitext-Nochricht stelle',
	'ea-style' => 'Stil:',
	'ea-selectcss' => 'Du chasch e Stylesheet uuswehle:',
	'ea-data' => 'Date',
	'ea-selectrecord' => 'Die Vorlage chenne brucht wäre go Fälder in dr Nochricht uusfille:',
	'ea-allusers' => 'Alli Benutzer',
);

/** Hebrew (עברית)
 * @author YaronSh
 */
$messages['he'] = array(
	'e-mailpage' => 'דף דוא״ל',
	'ea-desc' => 'שליחת עמוד HTML מעובד לכתובת דוא״ל או לרשימה של כתובות באמצעות [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => 'הדף "[[$1]]" נשלח בדוא״ל',
	'ea-group-info' => 'בנוסף באפשרות לשלוח דף לחברים בקבוצה מסוימת',
	'ea-pagesend' => 'הדף "$1" נשלח מהמקור $2',
	'ea-nopage' => 'לא צוין דף לשליחה, נא להשתמש בקישור הדוא״ל שבסרגל הצד או בפעולות הדף.',
	'ea-norecipients' => 'לא נמצאו כתובות דוא״ל תקניות!',
	'ea-listrecipients' => '{{PLURAL:$1|נמען אחד מופיע|$1 נמענים מופיעים}}',
	'ea-error' => "'''שגיאה בשליחת [[$1]]:''' ''$2''",
	'ea-denied' => 'ההרשאה נדחתה',
	'ea-sent' => "הדף [[$1]] נשלח בהצלחה ל'''$2''' {{PLURAL:$2|נמען אחד|מספר נמענים}} על ידי [[User:$3|$3]].",
	'ea-compose' => 'חיבור תוכן',
	'ea-show' => 'צפייה ברשימת הנמענים',
	'ea-from' => 'מאת:',
	'ea-to' => 'מען:',
	'ea-to-info' => 'ניתן להפריד את כתובות הדוא״ל באמצעות התווים: נקודה פסיק, פסיק, כוכבית או שורה חדשה',
	'ea-cc' => 'עותק:',
	'ea-send' => 'שליחה',
	'ea-subject' => 'נושא:',
	'ea-message' => 'הודעה:',
	'ea-message-info' => 'צירוף תוכן עם הודעת ויקיטקסט (לא בהכרח)',
	'ea-style' => 'סגנון:',
	'ea-selectcss' => 'ניתן לבחור בגיליון סגנון (CSS)',
	'ea-data' => 'נתונים',
	'ea-selectrecord' => 'ניתן להשתמש בתבניות אלה כדי למלא את כל השדות בתוכן ההודעה',
	'ea-allusers' => 'כל המשתמשים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'e-mailpage' => 'E-mejlowa strona',
	'ea-desc' => 'Rysowanu HTML-stronu na e-mejlowu adresu abo lisćinu adresow z pomocu [http://phpmailer.sourceforge.net phpmailer] pósłać',
	'ea-heading' => 'Strona "[[$1]]" so e-mejluje',
	'ea-group-info' => 'Přidatnje móžeš stronu na čłonow skupiny pósłać',
	'ea-pagesend' => 'Stronu "$1" wot $2 pósłana',
	'ea-nopage' => 'Žana strona za słanje podata, prošu wužij e-mejlowy wotkaz z bóčnicy abo akcije strony.',
	'ea-norecipients' => 'Žane płaćiwe e-mejlowe adresy namakane!',
	'ea-listrecipients' => '{{PLURAL:$1|přijimowar so nalistuje|$1 přijimowarjej so nalistujetaj|$1 přijimowarjo so nalistuja|$1 přijimowarjow so nalistuje}}',
	'ea-error' => "'''Zmylk při słanju [[$1]]:''' ''$2''",
	'ea-denied' => 'Dowolnosć zapowědźena',
	'ea-sent' => "Strona [[$1]] bu wot [[User:$3|$3]] wuspěšnje  na '''$2''' {{PLURAL:$2|přijimowarja|přijimowarjow|přijimowarjow|přijimowarjow}} pósłana.",
	'ea-compose' => 'Wobsah spisać',
	'ea-show' => 'Lisćinu přijimowarjow pokazać',
	'ea-from' => 'Wot:',
	'ea-to' => 'Komu:',
	'ea-to-info' => 'E-mejlowe adresy hodźa so přez semikolon, komu, asterisk abo linkowe łamanje wotdźělić',
	'ea-cc' => 'Kopija:',
	'ea-send' => 'Pósłać',
	'ea-subject' => 'Tema:',
	'ea-message' => 'Powěsć:',
	'ea-message-info' => 'Wobsah z opcionalnej powěsću we wikiteksće započeć',
	'ea-style' => 'Stil:',
	'ea-selectcss' => 'Móžeš stilowu předłohu wubrać',
	'ea-data' => 'Daty',
	'ea-selectrecord' => 'Tute předłohi hodźa so wužiwać, zo bychu pola w powěsći wupjelnili',
	'ea-allusers' => 'Wšitcy wužiwarjo',
);

/** Hungarian (Magyar)
 * @author Dj
 */
$messages['hu'] = array(
	'e-mailpage' => 'Email lap',
	'ea-heading' => '"[[$1]]" oldal elküldése',
	'ea-denied' => 'Engedély megtagadva',
	'ea-compose' => 'Tartalom összeállítása',
	'ea-show' => 'Címzettek megtekintése',
	'ea-from' => 'Feladó:',
	'ea-to' => 'Címzett:',
	'ea-to-info' => 'Az email címeket egy vagy több pontosvesszővel, vesszővel, csillaggal vagy új sor karakterrel lehet elválasztani',
	'ea-cc' => 'Másolatot kap:',
	'ea-send' => 'Küldés',
	'ea-subject' => 'Tárgy:',
	'ea-message' => 'Üzenet:',
	'ea-style' => 'Stílus:',
	'ea-selectcss' => 'Választhatsz egy stíluslapot',
	'ea-data' => 'Adat',
	'ea-allusers' => 'Összes felhasználó',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'e-mailpage' => 'Inviar pagina per e-mail',
	'ea-desc' => 'Inviar le rendition HTML de un pagina a un adresse de e-mail o a un lista de adresses con [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== Invio del pagina [[$1]] per e-mail ===',
	'ea-group-info' => 'In addition, tu pote inviar le pagina al membros de un gruppo',
	'ea-pagesend' => 'Pagina "$1" inviate ab $2',
	'ea-nopage' => 'Nulle pagina a inviar esseva specificate, per favor usa le ligamine de e-mail ab le barra lateral o actiones de pagina.',
	'ea-norecipients' => 'Nulle adresses de e-mail valide trovate!',
	'ea-listrecipients' => '=== {{PLURAL:$1|Destinatario|$1 destinatarios}} ===',
	'ea-error' => "'''Error durante le invio de [[$1]]:''' ''$2''",
	'ea-denied' => 'Permission refusate',
	'ea-sent' => "Le pagina [[$1]] ha essite inviate con successo a '''$2''' {{PLURAL:$2|destinatario|destinatarios}} per [[User:$3|$3]].",
	'ea-compose' => 'Componer contento',
	'ea-show' => 'Monstrar destinatarios',
	'ea-from' => 'Expeditor:',
	'ea-to' => 'Destinatario:',
	'ea-to-info' => 'Le adresses de e-mail pote esser separate per un o plus characteres de puncto e virgula, comma, asterisco o nove linea',
	'ea-cc' => 'CC:',
	'ea-send' => 'Inviar!',
	'ea-subject' => 'Subjecto:',
	'ea-message' => 'Message:',
	'ea-message-info' => 'Anteponer al contento un message optional in wikitexto',
	'ea-style' => 'Stilo:',
	'ea-selectcss' => 'Tu pote seliger un folio de stilo',
	'ea-data' => 'Datos',
	'ea-selectrecord' => 'Iste patronos pote esser usate pro completar campos in le contento del message',
	'ea-allusers' => 'Tote le usatores',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'e-mailpage' => 'Surel halaman',
	'ea-desc' => 'Kirim halaman HTML ke suatu alamat surel atau daftar alamat menggunakan [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => 'Kirimkan halaman "[[$1]]"',
	'ea-group-info' => 'Selain itu Anda dapat mengirim halaman ke anggota kelompok',
	'ea-pagesend' => 'Halaman "$1" dikirim dari $2',
	'ea-nopage' => 'Halaman yang akan dikirim belum ditentukan. Silakan gunakan surel halaman dari bilah sisi atau tindakan halaman.',
	'ea-norecipients' => 'Alamat surel yang sah tidak ditemukan!',
	'ea-listrecipients' => 'Daftar {{PLURAL:$1|penerima|$1 penerima}}',
	'ea-error' => "'''Kesalahan sewaktu mengirim [[$1]]:''' ''$2''",
	'ea-denied' => 'Izin ditolak',
	'ea-sent' => "Halaman [[$1]] berhasil dikirim ke '''$2''' {{PLURAL:$2|penerima|penerima}} oleh [[User:$3|$3]].",
	'ea-compose' => 'Tulis isi',
	'ea-show' => 'Lihat daftar penerima',
	'ea-from' => 'Dari:',
	'ea-to' => 'Untuk:',
	'ea-to-info' => 'Alamat surel dapat dipisahkan dengan satu atau lebih titik koma, koma, bintang, atau baris baru',
	'ea-cc' => 'Tembusan:',
	'ea-send' => 'Kirim',
	'ea-subject' => 'Perihal:',
	'ea-message' => 'Pesan:',
	'ea-message-info' => 'Tambahkan isi dengan pesan teks wiki opsional',
	'ea-style' => 'Gaya:',
	'ea-selectcss' => 'Anda dapat memilih lembar gaya',
	'ea-data' => 'Data',
	'ea-selectrecord' => 'Template ini dapat digunakan untuk mengisi kolom isi pesan',
	'ea-allusers' => 'Semua pengguna',
);

/** Italian (Italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'ea-norecipients' => 'Nessun indirizzo e-mail valido trovato!',
	'ea-denied' => 'Permesso negato',
	'ea-show' => 'Vedi elenco destinatari',
	'ea-from' => 'Da:',
	'ea-to' => 'A:',
	'ea-send' => 'Invia',
	'ea-subject' => 'Oggetto:',
	'ea-message' => 'Messaggio:',
	'ea-style' => 'Stile:',
	'ea-selectcss' => 'Puoi selezionare un foglio di stile',
	'ea-data' => 'Data',
	'ea-allusers' => 'Tutti gli utenti',
);

/** Japanese (日本語)
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'e-mailpage' => '電子メールでページを送信',
	'ea-desc' => '特定の電子メールアドレス、あるいは[http://phpmailer.sourceforge.net phpmailer]を使ってアドレスの一覧宛に、HTML描画されたページを送信',
	'ea-heading' => 'ページ「[[$1]]」を電子メールで送信',
	'ea-group-info' => 'さらに、グループのメンバーにページを送信できます',
	'ea-pagesend' => '$2から送信されたページ「$1」',
	'ea-nopage' => '送信するページが指定されませんでした。サイドバー内の電子メールのリンクを使用するか、ページ操作を行なってください。',
	'ea-norecipients' => '有効な電子メールアドレスが見つかりません！',
	'ea-listrecipients' => '{{PLURAL:$1|$1人の受信者}}の一覧',
	'ea-error' => "'''[[$1]]の送信のエラー：'''$2",
	'ea-denied' => '許可されていません',
	'ea-sent' => "[[User:$3|$3]]によって、ページ[[$1]]が'''$2'''人の受信者へ正しく送信されました。",
	'ea-compose' => '内容の作成',
	'ea-show' => '受信者一覧を表示',
	'ea-from' => '差出人：',
	'ea-to' => '宛先：',
	'ea-to-info' => '電子メールアドレスは1つ以上のセミコロン、カンマ、アスタリスクや改行文字で区切ることができます。',
	'ea-cc' => 'CC：',
	'ea-send' => '送信',
	'ea-subject' => '件名：',
	'ea-message' => '本文：',
	'ea-message-info' => '追加のウィキテキストのメッセージを本文の先頭に追加',
	'ea-style' => 'スタイル：',
	'ea-selectcss' => 'スタイルシートを選択できます',
	'ea-data' => '日付',
	'ea-selectrecord' => 'これらのテンプレートをメッセージの内容を入力するために使用することができます',
	'ea-allusers' => 'すべての利用者',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 */
$messages['km'] = array(
	'e-mailpage' => 'ទំព័រអ៊ីមែល',
	'ea-pagesend' => 'ទំព័រ"$1"ត្រូវបានបញ្ជូនពី$2',
	'ea-send' => 'ផ្ញើ!',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'e-mailpage' => 'Sigg pä <i lang="en">e-mail</i> verschecke',
	'ea-desc' => 'Scheck Sigge uss_em Wiki em fäädejje HTML-Fommaat met de <i lang="en">e-mail</i> aan ein udder mieh Adräße met däm Projramm <i lang="en">[http://phpmailer.sourceforge.net phpmailer]</i>.',
	'ea-heading' => 'De Sigg „[[$1]]“ met de <i lang="en">e-mail</i> verschecke.',
	'ea-group-info' => 'Do kanns di Sigg och noch aan de Metjleeder vun ene Metmaacherjropp verschecke.',
	'ea-pagesend' => 'De Sigg "$1" us {{GRAMMAR:Dativ|$2}}',
	'ea-nopage' => 'Kein Sigg zom Verschecke woor aanjejovve, bes esu joot, un donn dä Lengk aam Rand op dä Sigg nämme, di De veschecke wells.',
	'ea-norecipients' => 'Kein jölteje Adräß för de <i lang="en">e-mail</i> zom Verschecke jefonge!',
	'ea-listrecipients' => '{{PLURAL:$1|Ämfänger|De Leß met de Ämfänger|Kein Leß}}',
	'ea-error' => "'''Ene Fähler es opjetrodde beim Verschecke vun dä Sigg „[[$1]]“''' — ''$2''",
	'ea-denied' => 'Kein Rääsch, för <i lang="en">e-mail</i> ze verschecke',
	'ea-sent' => 'De Sigg „[[$1]]“ es {{GENDER:vum|vum|vum Metmaacher|vun dä|vum}} [[User:$3|$3]] aan {{PLURAL:$2|eine Emfänger|$2 Emfänger|keine}} verscheck woode.',
	'ea-compose' => 'Nohreesch schriive',
	'ea-show' => 'Ämfänger aanzeije',
	'ea-from' => 'Vum:',
	'ea-to' => 'Aan:',
	'ea-to-info' => 'Zwesche de Adräß för de <i lang="en">e-mail</i> künne Strechpunkte, Kommas, Stääncher, un Reije-Ende shtonn, esu vill wi mer well.',
	'ea-cc' => 'Koppije aan:',
	'ea-send' => 'Affschecke!',
	'ea-subject' => 'Theema:',
	'ea-message' => 'Dä Täx en dä Nohreesch:',
	'ea-message-info' => 'Donn heh dä Täx udder Wikicode vür dä Siggetext en de <i lang="en">e-mail</i>, kanns De ävver och läddesch lohße.',
	'ea-style' => 'Ußsinn noh:',
	'ea-selectcss' => 'För et Ußsinn kanns Do en CSS-Dattei ußwähle',
	'ea-data' => 'Daate',
	'ea-selectrecord' => 'Heh di Schabloone künne jebruch wääde, öm Felder en dä <i lang="en">e-mail</i> enzefölle.',
	'ea-allusers' => 'Alle Metmaacher',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'ea-from' => 'Ji',
	'ea-message' => 'Peyam',
	'ea-allusers' => 'Hemû bikarhêneran',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'e-mailpage' => 'Säit per Mail schécken',
	'ea-desc' => 'Schéckt generéiert HTML-Säiten un eng E-Mailadress oder eng Lëscht vun E-Mailadresse mat [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => '=== Säit [[$1]] peer E-Mail verschécken ===',
	'ea-group-info' => "Zousätzlech kënnt Dir d'Säit de Membere vun engem Grupp schécken",
	'ea-pagesend' => 'D\'Säit "$1" gouf verschéckt vum $2',
	'ea-nopage' => "Et gouf keng Säit ugi fir ze verschécken, benotzt w.e.g. den E-Mail-Link aus der säitlecher Läischt oder d'Aktioune vun der Säit.",
	'ea-norecipients' => 'Keng gëlteg E-Mailadress fonnt',
	'ea-listrecipients' => '=== {{PLURAL:$1|Destinataire|Lëscht vun de(n) $1 Destinatairen}} ===',
	'ea-error' => "'''Feeler beim Verschécke vun der Säit [[$1]]:''' ''$2''",
	'ea-denied' => 'Rechter refuséiert',
	'ea-sent' => "D'Säit [[$1]] gouf vum [[User:$3|$3]] u(n) '''$2''' {{PLURAL:$2|Destinataire|Destinataire}} geschéckt.",
	'ea-compose' => 'Inhalt zesummestellen',
	'ea-show' => 'Adressate weisen',
	'ea-from' => 'Vum:',
	'ea-to' => 'Fir:',
	'ea-to-info' => 'Mailadresse kënne engem oder méi Komma, Stréchpunkt, Stären oder Zeeche fir eng nei Linn ("\\n") getrennt ginn',
	'ea-cc' => 'Kopie:',
	'ea-send' => 'Schécken!',
	'ea-subject' => 'Sujet:',
	'ea-message' => 'Message:',
	'ea-message-info' => 'Virun den Inhalt vun der Säit een optionale Message am Wiki-Format setzen',
	'ea-style' => 'Style:',
	'ea-selectcss' => "Dir kënnt een ''CSS Stylesheet'' eraussichen",
	'ea-data' => 'Donnéeën',
	'ea-selectrecord' => 'Dës Schabloune kënne benotzt gi fir Felder am Inhalt vu Messagen auszefëllen',
	'ea-allusers' => 'All Benotzer',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'ea-message' => 'Viestejums:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'e-mailpage' => 'Страница за е-пошта',
	'ea-desc' => 'Испраќање на снимена HTML-страница на е-поштенска адреса или список на адреси со [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => 'Испраќање на страницата „[[$1]]“',
	'ea-group-info' => 'Покрај ова, страницата можете да ја испратите и на членови на група',
	'ea-pagesend' => 'Страницата „$1“ е испратена од $2',
	'ea-nopage' => 'Не наведовте страница за испраќање. Послужете се со врската за е-пошта во страничната лента или функциите на страницата.',
	'ea-norecipients' => 'Не пронајдов важечки е-поштенски адреси!',
	'ea-listrecipients' => 'Наведувам {{PLURAL:$1|примач|$1 примачи}}',
	'ea-error' => "'''Грешка при испраќањето на [[$1]]:''' ''$2''",
	'ea-denied' => 'Дозволата е одбиена',
	'ea-sent' => "Страницата [[$1]] е успешно испратена на '''$2''' {{PLURAL:$2|примач|примачи}} од [[User:$3|$3]].",
	'ea-compose' => 'Состави содржина',
	'ea-show' => 'Прикажи примачи',
	'ea-from' => 'Од:',
	'ea-to' => 'За:',
	'ea-to-info' => 'Е-поштенските адреси се одделуваат со една (или повеќе) точка-запирка, запирки, ѕвездички или знаци за нов ред',
	'ea-cc' => 'Примерок и за:',
	'ea-send' => 'Испрати',
	'ea-subject' => 'Наслов:',
	'ea-message' => 'Порака:',
	'ea-message-info' => 'Вметни дополнителна порака од викитекст на почетокот (незадолжително)',
	'ea-style' => 'Стил:',
	'ea-selectcss' => 'Можете да одберете стилска страница',
	'ea-data' => 'Податоци',
	'ea-selectrecord' => 'Овие шаблони служат за пополнување на полиња во содржината на пораката',
	'ea-allusers' => 'Сите корисници',
);

/** Malayalam (മലയാളം)
 * @author Junaidpv
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'e-mailpage' => 'ഇമെയില്‍ താള്‍',
	'ea-heading' => '=== [[$1]] എന്ന താള്‍ ഇമെയില്‍ ചെയ്യുന്നു ===',
	'ea-pagesend' => '$2 സം‌രംഭത്തില്‍ നിന്നു "$1" എന്ന താള്‍ അയച്ചു',
	'ea-nopage' => 'അയക്കുവാന്‍ വേണ്ടി ഒരു താള്‍ തിരഞ്ഞെടുക്കുക. ഉദാ: [[Special:e-mailpage/Main Page]]',
	'ea-norecipients' => 'സാധുവായ ഇമെയില്‍ വിലാസങ്ങള്‍ കണ്ടില്ല!',
	'ea-listrecipients' => '=== $1 {{PLURAL:$1|സ്വീകര്‍ത്താവിന്റെ|സ്വീകര്‍ത്താക്കളുടെ}} പട്ടിക ===',
	'ea-error' => "'''[[$1]] അയക്കുന്നതില്‍ പിഴവ്:''' ''$2''",
	'ea-denied' => 'അനുവാദം നിഷേധിച്ചിരിക്കുന്നു',
	'ea-sent' => "[[User:$3|$3]] എന്ന ഉപയോക്താവ് [[$1]] എന്ന താള്‍ വിജയകരമായി '''$2''' {{PLURAL:$2|സ്വീകര്‍ത്താവിനു|സ്വീകര്‍ത്താക്കള്‍ക്ക്}} അയച്ചിരിക്കുന്നു.",
	'ea-compose' => 'ഉള്ളടക്കം ചേര്‍ക്കുക',
	'ea-show' => 'സ്വീകര്‍ത്താക്കളെ പ്രദര്‍ശിപ്പിക്കുക',
	'ea-send' => 'അയക്കൂ!',
	'ea-subject' => 'വിഷയം:',
	'ea-message' => 'സന്ദേശം:',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'e-mailpage' => 'पान इ-मेल करा',
	'ea-desc' => ' [http://phpmailer.sourceforge.net पीएचपी मेलर] चा वापर करून एखादे पान एखाद्या इ-मेल पत्त्यावर किंवा इ-मेल पत्त्यांच्या यादीवर पाठवा.',
	'ea-heading' => '=== [[$1]] पान इ-मेल करीत आहे ===',
	'ea-pagesend' => '$2 ने "$1" पान पाठविले',
	'ea-nopage' => 'कृपया पाठविण्यासाठी एक पान निवडा, उदाहरणासाठी [[Special:e-mailpage/Main Page]].',
	'ea-norecipients' => 'योग्य इ-मेल पत्ता सापडला नाही!',
	'ea-listrecipients' => '=== $1 {{PLURAL:$1|सदस्याची|सदस्यांची}}यादी ===',
	'ea-error' => "'''पाठविण्यामध्ये त्रुटी [[$1]]:''' ''$2''",
	'ea-denied' => 'परवानगी नाकारली',
	'ea-sent' => "[[User:$3|$3]] ने [[$1]] पान '''$2''' {{PLURAL:$2|सदस्याला|सदस्यांना}} पाठविले.",
	'ea-compose' => 'मजकूर लिहा',
	'ea-show' => 'निवडलेले सदस्य दाखवा',
	'ea-send' => 'पाठवा!',
	'ea-subject' => 'इ-मेल चा विषय लिहा',
	'ea-message' => 'मजकूरा आधी वैकल्पिक संदेश लिहा (विकिसंज्ञा)',
	'ea-selectcss' => 'सीएसएस स्टाइलशीट पाठवा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'e-mailpage' => 'Laman e-mel',
	'ea-desc' => 'Hantar laman berbentuk HTML kepada alamat e-mel atau senarai alamat dengan menggunakan [http://phpmailer.sourceforge.net phpmailer]',
	'ea-denied' => 'Kebenaran ditolak',
);

/** Burmese (မြန်မာဘာသာ)
 * @author Erikoo
 */
$messages['my'] = array(
	'e-mailpage' => 'အီမေးပို့ရန်စာမျက်နှာ',
	'ea-heading' => 'ဤစာမျက်နှာအား email ပို့နေသည် "[[$1]]"',
	'ea-from' => 'မှ',
	'ea-to' => 'သို့',
	'ea-subject' => 'အကြောင်းရာ/ခေါင်းစဉ်',
	'ea-allusers' => 'အသုံးပြုသူအားလုံး',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'ea-send' => 'Кучомс',
	'ea-subject' => 'Мезде:',
	'ea-message' => 'Пачтямнэсь:',
	'ea-style' => 'Стилезэ:',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'e-mailpage' => 'E-mail zāzanilli',
	'ea-heading' => '=== E-mailhua in zāzanilli $1 ===',
	'ea-send' => 'Ticquihuāz',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'e-mailpage' => 'Send side som e-post',
	'ea-desc' => 'Send HTML-side til en eller flere e-postadresser ved hjelp av [http://phpmailer.sourceforge.net/ phpmailer].',
	'ea-heading' => '=== Send siden [[$1]] som e-post ===',
	'ea-group-info' => 'I tillegg kan du sende siden til medlemmene av en gruppe',
	'ea-pagesend' => 'Siden «$1» sendt fra $2',
	'ea-nopage' => 'Ingen side ble angitt for sending, bruk e-postlenken fra sidepanelet eller sidehandlinger.',
	'ea-norecipients' => 'Ingen gyldige e-postadresser funnet.',
	'ea-listrecipients' => '=== Liste over $1 {{PLURAL:$1|mottaker|mottakere}} ===',
	'ea-error' => "'''Feil under sending av [[$1]]:''' ''$2''",
	'ea-denied' => 'Ingen adgang',
	'ea-sent' => "Siden [[$1]] ble sendt til '''$2''' {{PLURAL:$2|mottaker|mottakere}} av [[User:$3|$3]].",
	'ea-compose' => 'Skriv inn innhold',
	'ea-show' => 'Vis mottakere',
	'ea-from' => 'Fra:',
	'ea-to' => 'Til:',
	'ea-to-info' => 'E-postadresser kan skilles med et eller flere semikolon, komma, stjerne eller linjeskift',
	'ea-cc' => 'CC:',
	'ea-send' => 'Send',
	'ea-subject' => 'Emne:',
	'ea-message' => 'Melding:',
	'ea-message-info' => 'Heng på innhold foran med valgfri wikitekstmelding',
	'ea-style' => 'Stil:',
	'ea-selectcss' => 'Du kan velge et stilark',
	'ea-data' => 'Data',
	'ea-selectrecord' => 'Disse malene kan brukes til å fylle ut felt i meldingsinnholdet',
	'ea-allusers' => 'Alle brukere',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'e-mailpage' => 'Pagina e-mailen',
	'ea-desc' => 'Stuur een gerenderde pagina naar een e-mailadres of een lijst van adressen met behulp van [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== Pagina [[$1]] e-mailen ===',
	'ea-group-info' => 'Daarnaast kun u de pagina naar leden van een groep sturen',
	'ea-pagesend' => 'Pagina "$1" is vanuit $2 verstuurd',
	'ea-nopage' => 'Geef een pagina op om te versturen, bijvoorbeeld [[Special:e-mailpage/Hoofdpagina]].',
	'ea-norecipients' => 'Er is geen geldig e-mailadres opgegeven!',
	'ea-listrecipients' => '=== Lijst met $1 {{PLURAL:$1|ontvanger|ontvangers}} ===',
	'ea-error' => "'''Fout bij het versturen van [[$1]]:''' ''$2''",
	'ea-denied' => 'U hebt geen rechten om deze handeling uit te voeren',
	'ea-sent' => "Pagina [[$1]] is verstuurd naar '''$2''' {{PLURAL:$2|ontvanger|ontvangers}} door [[User:$3|$3]].",
	'ea-compose' => 'Inhoud samenstellen',
	'ea-show' => 'Ontvangers weergeven',
	'ea-from' => 'Van:',
	'ea-to' => 'Aan:',
	'ea-to-info' => "E-mailadressen kunnen gescheiden worden door een of meer puntkomma's, komma's sterretjes of regeleinden",
	'ea-cc' => 'CC:',
	'ea-send' => 'Verzenden',
	'ea-subject' => 'Onderwerp:',
	'ea-message' => 'Bericht:',
	'ea-message-info' => 'Voor inhoud optionele wikitekst toevoegen',
	'ea-style' => 'Stijl:',
	'ea-selectcss' => 'U kunt een stylesheet selecteren',
	'ea-data' => 'Gegevens',
	'ea-selectrecord' => 'Deze sjablonen kunnen gebruikt worden om velden te vullen in de berichtinhoud',
	'ea-allusers' => 'Alle gebruikers',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'e-mailpage' => 'Mandar l’article per corrièr electronic',
	'ea-desc' => 'Manda lo rendut d’una pagina HTML a una adreça electronica o a una tièra d’adreças en utilizant [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => '=== Mandadís de la pagina [[$1]] per corrièr electronic ===',
	'ea-pagesend' => 'Pagina « $1 » mandada dempuèi $2',
	'ea-nopage' => 'Especificatz una pagina de mandar, per exemple [[Special:e-mailpage/Acuèlh]]',
	'ea-norecipients' => "Cap d'adreça de corrièr electronic pas trobada !",
	'ea-listrecipients' => '=== Tièra de $1 {{PLURAL:$1|destinatari|destinataris}} ===',
	'ea-error' => "'''Error del mandadís de [[$1]] :''' ''$2''",
	'ea-denied' => 'Permission refusada',
	'ea-sent' => "L'article [[$1]] es estat mandat amb succès a '''$2''' {{PLURAL:$2|destinatari|destinataris}} per [[User:$3|$3]].",
	'ea-compose' => 'Compausar lo contengut',
	'ea-show' => 'Visionar los destinataris',
	'ea-send' => 'Mandar !',
	'ea-subject' => 'Entrar una linha « objècte » pel corrièr electronic',
	'ea-message' => 'Apondre lo contengut al començament amb un messatge facultatiu (tèxt wiki)',
	'ea-selectcss' => "Seleccionar un fuèlh d'estil CSS",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jnanaranjan Sahu
 */
$messages['or'] = array(
	'ea-denied' => 'ଅନୁମତି ଦିଆଗଲାନାହିଁ',
	'ea-show' => 'ଗ୍ରାହକ ତାଲିକା ଦେଖିବେ',
	'ea-from' => 'କାହାଠାରୁ:',
	'ea-to' => 'କାହାକୁ:',
	'ea-send' => 'ପଠାଇବେ',
	'ea-subject' => 'ବିଷୟ :',
	'ea-message' => 'ସନ୍ଦେଶ :',
	'ea-style' => 'ଶୈଳୀ:',
	'ea-selectcss' => 'ଆପଣ ଗୋଟିଏ ଶୈଳୀ ବାଛିପରିବେ',
	'ea-data' => 'ତଥ୍ୟ',
	'ea-allusers' => 'ସମସ୍ତ ବ୍ୟବହାରକାରୀ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'ea-from' => 'Vun:',
	'ea-to' => 'Fer:',
	'ea-data' => 'Daade',
);

/** Polish (Polski)
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'e-mailpage' => 'Strona e‐maila',
	'ea-desc' => 'Wyślij stronę HTML na adres e-mail lub grupę adresów za pomocą [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== Wysłanie na e-mail strony [[$1]] ===',
	'ea-group-info' => 'Dodatkowo możesz wysłać stronę do członków grupy',
	'ea-pagesend' => 'Strona "$1" wysłana z $2',
	'ea-nopage' => 'Wybierz stronę do wysłania, przykładowo [[Special:e-mailpage/{{MediaWiki:Mainpage-url}}]].',
	'ea-norecipients' => 'Nie znaleziono prawidłowego adresu e-mail.',
	'ea-listrecipients' => '=== {{PLURAL:$1|Odbiorca|$1 odbiorców}} ===',
	'ea-error' => "'''Błąd podczas wysyłania [[$1]]:''' ''$2''",
	'ea-denied' => 'Odmowa dostępu',
	'ea-sent' => "Strona [[$1]] została wysłana do '''$2''' {{PLURAL:$2|odbiorcy|odbiorców}} przez [[User:$3|$3]].",
	'ea-compose' => 'Tworzenie zawartości',
	'ea-show' => 'Pokaż odbiorców',
	'ea-from' => 'Od',
	'ea-to' => 'Do',
	'ea-to-info' => 'Adresy e‐mail mogą być rozdzielane jednym lub więcej średnikiem, przecinkiem, gwiazdką lub znakiem rozpoczęcia nowej linii',
	'ea-cc' => 'CC',
	'ea-send' => 'Wyślij',
	'ea-subject' => 'Temat',
	'ea-message' => 'Wiadomość',
	'ea-message-info' => 'Poprzedź zawartość opcjonalnym komunikatem zapisanym z użyciem formatowania wiki',
	'ea-style' => 'Styl',
	'ea-selectcss' => 'Możesz określić arkusz stylów',
	'ea-data' => 'Dane',
	'ea-selectrecord' => 'Szablony te mogą zostać wykorzystywane do wypełnienia pól w treści wiadomości',
	'ea-allusers' => 'Wszyscy użytkownicy',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'e-mailpage' => 'د برېښليک مخ',
	'ea-send' => 'لېږل',
	'ea-message' => 'پيغام:',
	'ea-allusers' => 'ټول کارنان',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Pedroca cerebral
 */
$messages['pt'] = array(
	'e-mailpage' => 'Enviar páginas por correio electrónico',
	'ea-desc' => 'Enviar uma página na sua composição final em HTML, para um endereço electrónico ou para uma lista de endereços, usando o [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => 'A enviar a página "[[$1]]"',
	'ea-group-info' => 'Adicionalmente, pode enviar a página para os membros de um grupo',
	'ea-pagesend' => 'Página "$1" enviada da $2',
	'ea-nopage' => 'Não foi especificada nenhuma página para envio; use o link de envio disponível na barra lateral ou nas operações da página, por favor.',
	'ea-norecipients' => 'Não foi encontrado nenhum endereço de correio electrónico válido!',
	'ea-listrecipients' => 'A listar {{PLURAL:$1|o destinatário|$1 destinatários}}',
	'ea-error' => "'''Erro no envio de [[$1]]:''' ''$2''",
	'ea-denied' => 'Permissão negada',
	'ea-sent' => "A página [[$1]] foi enviada para '''$2''' {{PLURAL:$2|destinatário|destinatários}} por [[User:$3|$3]].",
	'ea-compose' => 'Compor a mensagem',
	'ea-show' => 'Ver a lista de destinatários',
	'ea-from' => 'De:',
	'ea-to' => 'Para:',
	'ea-to-info' => 'Os endereços podem ser separados com uma ou várias vírgulas, pontos e vírgula, asteriscos ou novas linhas',
	'ea-cc' => 'CC:',
	'ea-send' => 'Enviar',
	'ea-subject' => 'Assunto:',
	'ea-message' => 'Mensagem',
	'ea-message-info' => 'Anteceda o conteúdo com uma mensagem opcional em texto wiki',
	'ea-style' => 'Estilo:',
	'ea-selectcss' => 'Pode seleccionar uma folha de estilos',
	'ea-data' => 'Dados',
	'ea-selectrecord' => 'Estes modelos podem ser usados para preencher os campos no conteúdo da mensagem',
	'ea-allusers' => 'Todos os utilizadores',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Pedroca cerebral
 */
$messages['pt-br'] = array(
	'e-mailpage' => 'Enviar páginas por e-mail',
	'ea-desc' => 'Enviar uma página na sua composição final em HTML, para um endereço de e-mail ou para uma lista de endereços usando o [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => 'A enviar a página "[[$1]]"',
	'ea-group-info' => 'Além disso você pode enviar a página para os membros de um grupo',
	'ea-pagesend' => 'Página "$1" enviada da $2',
	'ea-nopage' => 'Não foi especificada nenhuma página para envio; por favor, use o link de envio disponível na barra lateral ou nas operações da página.',
	'ea-norecipients' => 'Não foi encontrado nenhum endereço de e-mail válido!',
	'ea-listrecipients' => 'Listando {{PLURAL:$1|o destinatário|$1 destinatários}}',
	'ea-error' => "'''Erro no envio de [[$1]]:''' ''$2''",
	'ea-denied' => 'Permissão negada',
	'ea-sent' => "A página [[$1]] foi enviada para '''$2''' {{PLURAL:$2|destinatário|destinatários}} por [[User:$3|$3]].",
	'ea-compose' => 'Compor a mensagem',
	'ea-show' => 'Ver a lista de destinatários',
	'ea-from' => 'De:',
	'ea-to' => 'Para:',
	'ea-to-info' => 'Os endereços podem ser separados com uma ou várias vírgulas, pontos e vírgula, asteriscos ou novas linhas',
	'ea-cc' => 'CC:',
	'ea-send' => 'Enviar',
	'ea-subject' => 'Assunto:',
	'ea-message' => 'Mensagem',
	'ea-message-info' => 'Inclua uma mensagem opcional em texto wiki',
	'ea-style' => 'Estilo:',
	'ea-selectcss' => 'Pode selecionar uma folha de estilos',
	'ea-data' => 'Dados',
	'ea-selectrecord' => 'Estes modelos podem ser usados para preencher os campos no conteúdo da mensagem',
	'ea-allusers' => 'Todos os usuários',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Minisarm
 */
$messages['ro'] = array(
	'ea-heading' => 'Se trimite pagina „[[$1]]”',
	'ea-denied' => 'Permisiune refuzată',
	'ea-from' => 'De la:',
	'ea-to' => 'Către:',
	'ea-send' => 'Trimite!',
	'ea-subject' => 'Subiect:',
	'ea-message' => 'Mesaj:',
	'ea-style' => 'Stil:',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'e-mailpage' => 'Отправить страницу',
	'ea-desc' => 'Отправка HTML-страниц на адрес электронной почты (или список адресов) с помощью [http://phpmailer.sourceforge.net phpmailer]',
	'ea-heading' => 'Оправка по электронной почте страницы «[[$1]]»',
	'ea-group-info' => 'Вы также можете отправить страницу членам группы',
	'ea-pagesend' => 'Страница «$1» отправлена из $2',
	'ea-nopage' => 'Не указана страница для отправки. Пожалуйста, воспользуйтесь ссылкой отправки на боковой панели или странице действий.',
	'ea-norecipients' => 'Не обнаружено корректного адреса электронной почты!',
	'ea-listrecipients' => 'Перечень из {{PLURAL:$1|$1 получателя|$1 получателей|$1 получателей}}',
	'ea-error' => "'''Ошибки отправки [[$1]].''' ''$2''",
	'ea-denied' => 'Доступ запрещён',
	'ea-sent' => "Страница [[$1]] успешно отправлена '''$2''' {{PLURAL:$2|получателю|получателям|получателям}} участником [[User:$3|$3]].",
	'ea-compose' => 'Составление текста',
	'ea-show' => 'Просмотр списка получателей',
	'ea-from' => 'От:',
	'ea-to' => 'Кому:',
	'ea-to-info' => 'Адреса электронной почты могут быть разделены точкой с запятой, запятой, звёздочкой или символом новой строки',
	'ea-cc' => 'Копия:',
	'ea-send' => 'Отправить',
	'ea-subject' => 'Тема:',
	'ea-message' => 'Сообщение:',
	'ea-message-info' => 'Присоединение содержания с возможным сообщением с викитекстом',
	'ea-style' => 'Стиль:',
	'ea-selectcss' => 'Вы можете выбрать стиль',
	'ea-data' => 'Данные',
	'ea-selectrecord' => 'Эти шаблоны могут использоваться для заполнения полей в содержимом письма',
	'ea-allusers' => 'Все участники',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'e-mailpage' => 'Poslať stránku emailom',
	'ea-desc' => 'Poslať stránku vo formáte HTML na emailovú adresu alebo zoznam adries pomocou [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== Poslanie stránky [[$1]] emailom ===',
	'ea-pagesend' => 'Článok „$1” poslaný z $2',
	'ea-nopage' => 'Prosím, uveďte stránku, ktorú chcete poslať, napr. [[Special:e-mailpage/Hlavná stránka]].',
	'ea-norecipients' => 'Nebola nájdená platná emailová adresa!',
	'ea-listrecipients' => '=== Zoznam $1 {{PLURAL:$1|príjemcu|príjemcov}} ===',
	'ea-error' => "'''Chyba pri odosielaní [[$1]]:''' ''$2''",
	'ea-denied' => 'Nemáte potrebné oprávnenie',
	'ea-sent' => "[[User:$3|$3]] úspešne poslal stránku [[$1]] '''$2''' {{PLURAL:$2|používateľovi|používateľom}}.",
	'ea-compose' => 'Napísať obsah správy',
	'ea-show' => 'Zobraziť príjemcov',
	'ea-send' => 'Poslať!',
	'ea-subject' => 'Zadajte predmet emailu',
	'ea-message' => 'Pred obsah pridať (nepovinne) správu (wikitext)',
	'ea-selectcss' => 'Vyberte CSS štýl',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'ea-send' => 'Kintun!',
);

/** Swedish (Svenska)
 * @author Fader
 * @author Jon Harald Søby
 * @author M.M.S.
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'e-mailpage' => 'E-posta sida',
	'ea-desc' => 'Skicka en renderad HTML-sida till en e-postadress eller en lista över adresser som använder [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== E-posta sidan [[$1]] ===',
	'ea-group-info' => 'Dessutom kan du skicka sidan till medlemmar i en grupp',
	'ea-pagesend' => 'Artikeln "$1" skickades från $2',
	'ea-nopage' => 'Ingen sida har angivits för att skicka, var god använd e-postlänken från sidofältet eller sidhandlingar.',
	'ea-norecipients' => 'Inga giltiga e-postadresser hittades!',
	'ea-listrecipients' => '=== Lista över $1 {{PLURAL:$1|mottagare|mottagare}} ===',
	'ea-error' => "'''Fel under sändande av [[$1]]:''' ''$2''",
	'ea-denied' => 'Åtkomst nekas',
	'ea-sent' => "Sidan [[$1]] har skickats till '''$2''' {{PLURAL:$2|mottagare|mottagare}} av [[User:$3|$3]].",
	'ea-compose' => 'Komponera innehåll',
	'ea-show' => 'Visa mottagare',
	'ea-from' => 'Från:',
	'ea-to' => 'Till:',
	'ea-to-info' => 'E-postadresser kan separeras med en eller flera semikolon, kommatecken, asterisk eller nyradstecken',
	'ea-cc' => 'CC:',
	'ea-send' => 'Skicka!',
	'ea-subject' => 'Ämne:',
	'ea-message' => 'Meddelande:',
	'ea-style' => 'Stil:',
	'ea-selectcss' => 'Du kan välja en stilmall',
	'ea-data' => 'Data',
	'ea-selectrecord' => 'Dessa mallar kan användas för att fylla i fält i meddelandets innehåll',
	'ea-allusers' => 'Alla användare',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'e-mailpage' => 'పేజీని ఈమెయిలు చెయ్యి',
	'ea-desc' => '[http://phpmailer.sourceforge.net phpmailer] ను వాడి రెండరైన HTML పేజీని ఒక ఈమెయిలు అడ్రసుకు గానీ, అడ్రసుల జాబితాకు గానీ పంపించు',
	'ea-heading' => '"[[$1]]" పేజీని ఈమెయిలు చేస్తున్నాం',
	'ea-group-info' => 'ఇంకా, ఈ పేజీని ఏదైనా గుంపు సభ్యులకు పంపించవచ్చు',
	'ea-pagesend' => '$2 నుండి వచ్చిన పేజీ "$1"',
	'ea-nopage' => 'ఏ పేజీని పంపించాలో ఇవ్వలేదు. సైడుపట్టీలో గానీ, పేజీ చర్యల్లో గానీ ఉన్న ఈమెయిలు లింకును వాడండి.',
	'ea-norecipients' => 'సరైన ఈమెయిలు అడ్రసు కనబడలేదు!',
	'ea-denied' => 'అనుమతిని నిరాకరించాం',
	'ea-sent' => "[[User:$3|$3]], పేజీ [[$1]] ని '''$2''' {{PLURAL:$2|గ్రాహకునికి|గ్రాహకులకు}} జయప్రదంగా పంపించారు.",
	'ea-show' => 'గ్రాహకుల జాబితా చూపించు',
	'ea-from' => 'నుండి:',
	'ea-to' => 'కు:',
	'ea-to-info' => 'ఈమెయిలు అడ్రసులను సెమికోలను, కామా, చుక్క లేదా న్యూలైను కారెక్టర్ల ద్వారా విడదీయవచ్చు',
	'ea-cc' => 'సిసి:',
	'ea-send' => 'పంపించు!',
	'ea-subject' => 'విషయం:',
	'ea-message' => 'సందేశం:',
	'ea-style' => 'శైలి:',
	'ea-data' => 'డేటా',
	'ea-allusers' => 'వాడుకరులందరికీ',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'e-mailpage' => 'Pahina ng e-liham',
	'ea-desc' => 'Ipadala ang iniharap na pahinang HTML sa isang tirahan ng e-liham o tala ng mga tirahan na ginagamit ang [http://phpmailer.sourceforge.net tagapagpadala ng PHP]',
	'ea-heading' => 'Ipinapadala sa pamamagitan ng e-liham ang pahinang "[[$1]]"',
	'ea-group-info' => 'Bilang karagdagan maipapadala mo ang pahina sa mga kasapi ng isang pangkat',
	'ea-pagesend' => 'Pahinang "$1" ipinadala mula sa $2',
	'ea-nopage' => 'Walang pahinang itinukoy na ipapadala, mangyaring gamitin ang kawing sa e-liham mula sa panggilid na halang o mga galaw na para sa pahina.',
	'ea-norecipients' => 'Walang natagpuang katanggap-tanggap na mga tirahan ng e-liham!',
	'ea-listrecipients' => 'Nagtatala ng {{PLURAL:$1|tatanggap|$1 mga tatanggap}}',
	'ea-error' => "'''Kamalian sa pagpapadala ng [[$1]]:''' ''$2''",
	'ea-denied' => 'Tinanggihan ang pahintulot',
	'ea-sent' => "Matagumpay na naipadala ang pahinang [[$1]] SA '''$2''' {{PLURAL:$2|tagatanggap|mga tagatanggap}} ni [[User:$3|$3]].",
	'ea-compose' => 'Gumawa ng nilalaman',
	'ea-show' => 'Tingnan ang talaan ng tatanggap',
	'ea-from' => 'Mula kay:',
	'ea-to' => 'Papunta kay:',
	'ea-to-info' => 'Ang mga tirahan ng e-liham ay maaaring paghiwa-hiwalayin ng isa or mas marami pang tuldukuwit, kuwit, bituin o mga panitik ng bagong-guhit',
	'ea-cc' => 'CC:',
	'ea-send' => 'Ipadala',
	'ea-subject' => 'Paksa:',
	'ea-message' => 'Mensahe:',
	'ea-message-info' => 'Dugtungan sa unahan ang nilalaman ng maaaring walang mensahe ng wikiteksto',
	'ea-style' => 'Estilo:',
	'ea-selectcss' => 'Makakapili ka ng isang banig ng estilo',
	'ea-data' => 'Dato',
	'ea-selectrecord' => 'Magagamit ang mga suleras na ito upang punuin ang mga hanay sa loob ng nilalaman ng mensahe',
	'ea-allusers' => 'Lahat ng mga tagagamit',
);

/** Turkish (Türkçe)
 * @author Emperyan
 */
$messages['tr'] = array(
	'e-mailpage' => 'E-posta sayfası',
	'ea-error' => "'''[[$1]] gönderme hatası:''' ''$2''",
	'ea-show' => 'Alıcı listesini görüntüle',
	'ea-from' => 'Gönderen:',
	'ea-to' => 'Alıcı:',
	'ea-send' => 'Gönder',
	'ea-subject' => 'Konu:',
	'ea-message' => 'İleti:',
	'ea-style' => 'Biçim:',
	'ea-allusers' => 'Tüm kullanıcılar',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'ea-data' => 'Дані',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'e-mailpage' => 'Trang thư điện tử',
	'ea-desc' => 'Gửi trang HTML giản lược đến một địa chỉ hoặc danh sách các địa chỉ thư điện tử dùng [http://phpmailer.sourceforge.net phpmailer].',
	'ea-heading' => '=== Gửi trang [[$1]] ===',
	'ea-nopage' => 'Không định rõ trang để gửi. Xin hãy sử dụng liên kết thư điện tử trong thanh bên hoặc phần tác vụ trang.',
	'ea-norecipients' => 'Không tìm thấy địa chỉ thư điện tử hợp lệ!',
	'ea-listrecipients' => '=== Danh sách $1 {{PLURAL:$1|người nhận|người nhận}} ===',
	'ea-error' => "'''Lỗi khi gửi [[$1]]:''' ''$2''",
	'ea-sent' => "Trang [[$1]] đã được [[User:$3|$3]] gửi thành công đến '''$2''' {{PLURAL:$2|người nhận|người nhận}}.",
	'ea-compose' => 'Soạn nội dung',
	'ea-show' => 'Hiển thị người nhận',
	'ea-from' => 'Từ:',
	'ea-to' => 'Đến:',
	'ea-cc' => 'Đồng gửi:',
	'ea-send' => 'Gửi!',
	'ea-subject' => 'Tiêu đề:',
	'ea-message' => 'Thông điệp',
	'ea-message-info' => 'Gắn nội dung với thông điệp mã wiki tùy chọn',
	'ea-style' => 'Kiểu:',
	'ea-selectcss' => 'Có thể chọn tập tin định kiểu',
	'ea-data' => 'Dữ liệu',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'ea-message' => 'מעלדונג:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'e-mailpage' => '电子邮件页',
	'ea-group-info' => '此外您可以向组成员发送页面',
	'ea-nopage' => '没有页面被指定为发送，请使用电子邮件链接栏或页面的行动。',
	'ea-norecipients' => '没有找到有效的电子邮件地址！',
	'ea-denied' => '被拒绝的权限',
	'ea-compose' => '撰写内容',
	'ea-show' => '查看收件人列表',
	'ea-from' => '从：',
	'ea-to' => '至：',
	'ea-to-info' => '可以与一个或多个分号、 逗号、 星号或换行字符分隔的电子邮件地址',
	'ea-cc' => '抄送：',
	'ea-send' => '发送',
	'ea-subject' => '主题：',
	'ea-message' => '信息：',
	'ea-style' => '风格：',
	'ea-selectcss' => '您可以选择样式表',
	'ea-data' => '数据',
	'ea-selectrecord' => '这些模板可用于填充邮件内容中的字段',
	'ea-allusers' => '所有用户',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'e-mailpage' => '電子郵件頁面',
	'ea-group-info' => '此外您可以向組成員發送頁面',
	'ea-nopage' => '沒有頁面被指定為發送，請使用電子郵件鏈接欄或頁面的行動。',
	'ea-norecipients' => '沒有找到有效的電子郵件地址！',
	'ea-denied' => '被拒絕的權限',
	'ea-compose' => '撰寫內容',
	'ea-show' => '查看收件人列表',
	'ea-from' => '從：',
	'ea-to' => '至：',
	'ea-to-info' => '可以與一個或多個分號、 逗號、 星號或換行字符分隔的電子郵件地址',
	'ea-cc' => '抄送：',
	'ea-send' => '發送',
	'ea-subject' => '主旨：',
	'ea-message' => '信息：',
	'ea-style' => '風格：',
	'ea-selectcss' => '您可以選擇樣式表',
	'ea-data' => '日期',
	'ea-selectrecord' => '這些模板可用於填充郵件內容中的字段',
	'ea-allusers' => '所有用戶',
);

