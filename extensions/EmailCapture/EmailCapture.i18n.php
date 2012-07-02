<?php
/**
 * Internationalisation file for EmailCapture extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Trevor Parscal
 */
$messages['en'] = array(
	'emailcapture' => 'E-mail verification',
	'emailcapture-desc' => 'Capture e-mail addresses, and allow users to verify them through e-mail',
	'emailcapture-failure' => "Your e-mail was '''not''' verified.",
	'emailcapture-invalid-code' => 'Invalid confirmation code.',
	'emailcapture-already-confirmed' => 'Your e-mail address has already been confirmed.',
	'emailcapture-response-subject' => '{{SITENAME}} e-mail address verification',
	'emailcapture-response-body' => 'Hello!

Thank you for expressing interest in helping to improve {{SITENAME}}.

Please take a moment to confirm your e-mail by clicking on the link below:
$1

You may also visit:
$2

And enter the following confirmation code:
$3

We’ll be in touch shortly with how you can help improve {{SITENAME}}.

If you didn’t initiate this request, please ignore this e-mail and we won’t send you anything else.',
	'emailcapture-success' => 'Thank you!

Your e-mail has been successfully confirmed.',
	'emailcapture-instructions' => 'To verify your e-mail address, enter the code that was e-mailed to you and click "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Verification code:',
	'emailcapture-submit' => 'Verify e-mail address',
);

/** Message documentation (Message documentation)
 * @author Kghbln
 * @author Purodha
 * @author Yekrats
 */
$messages['qqq'] = array(
	'emailcapture' => 'The Email Capture extension will capture e-mail addresses, and allow users to verify them through e-mail. 
For more information, see [[mw:Extension:EmailCapture]].',
	'emailcapture-desc' => 'The Email Capture extension will capture e-mail addresses, and allow users to verify them through e-mail. 
For more information, see [[mw:Extension:EmailCapture]].
{{desc}}',
	'emailcapture-response-subject' => 'The Email Capture extension will capture e-mail addresses, and allow users to verify them through e-mail. 
For more information, see [[mw:Extension:EmailCapture]].
This is the subject line of the email sent to users.
{{Identical|SITENAME e-mail address confirmation}}',
	'emailcapture-instructions' => 'Used on [[Special:EmailCapture]], see image.
[[Image:TestWiki-Special-EmailCapture-L4H0.png|Screenshot of Special:EmailCapture|right|thumb]]',
	'emailcapture-verify' => 'Used on [[Special:EmailCapture]], see image.
[[Image:TestWiki-Special-EmailCapture-L4H0.png|Screenshot of Special:EmailCapture|right|thumb]]',
	'emailcapture-submit' => 'Used on [[Special:EmailCapture]], see image.
[[Image:TestWiki-Special-EmailCapture-L4H0.png|Screenshot of Special:EmailCapture|right|thumb]]',
);

/** Afrikaans (Afrikaans)
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'emailcapture' => 'E-pos verifiëring',
	'emailcapture-desc' => 'Capture e-pos adresse en gebruikers toelaat om hulle te verifieer via e-pos',
	'emailcapture-invalid-code' => 'Ongeldige bevestigingskode.',
	'emailcapture-already-confirmed' => 'Jou e-posadres is reeds bevestig.',
	'emailcapture-success' => 'Dankie!

Jou e-pos is suksesvol bevestig.',
	'emailcapture-verify' => 'Verifikasie kode:',
	'emailcapture-submit' => 'Verifieer e-pos adres',
);

/** Arabic (العربية)
 * @author AwamerT
 * @author Imksa
 * @author Meno25
 * @author OsamaK
 * @author محمد الجداوي
 */
$messages['ar'] = array(
	'emailcapture' => 'التحقق من البريد الإلكتروني',
	'emailcapture-desc' => 'التقاط عناوين البريد الإلكتروني، والسماح للمستخدمين بالتحقق منها عن طريق البريد الإلكتروني',
	'emailcapture-failure' => "البريد الإلكتروني الخاص بك  '''' 'لا يمكن ''''' التحقق منه.",
	'emailcapture-invalid-code' => 'رمز التفعيل غير صحيح.',
	'emailcapture-already-confirmed' => 'تم تأكيد بريدك الإلكتروني.',
	'emailcapture-response-subject' => 'التحقق من عنوان البريد الإلكتروني {{SITENAME}}',
	'emailcapture-response-body' => 'مرحباً!

شكرا لك الاهتمامك في المساعدة على تحسين {{SITENAME}}.

الرجاء التأكد من البريد الإلكتروني الخاص بك بواسطة النقر فوق الارتباط الموجود أدناه:
$1

ويمكنك أيضا زيارة:
$2

قم بإدخال رمز التأكيد التالي:
$3

سنكون على اتصال قريب مع  كيفية المساعدة في تحسين {{SITENAME}}.

إذا لم تكن مهتماً بهذا الطلب، الرجاء تجاهل هذا البريد الإلكتروني، ولن نرسل لك أي شيء آخر.',
	'emailcapture-success' => 'شكرًا
تم تأكيد البريد الإلكتروني الخاص بك بنجاح.',
	'emailcapture-instructions' => 'للتحقق من عنوان بريدك الإلكتروني  أدخل الكود الذي إرسال لك  بالبريد الإلكتروني ثم انقر فوق "{{التحقق من البريد الإلكتروني}}".',
	'emailcapture-verify' => 'رمز التحقق:',
	'emailcapture-submit' => 'تحقق من عنوان البريد الإلكتروني',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'emailcapture' => 'Праверка электроннай пошты',
	'emailcapture-desc' => 'Перахоплівае адрасы электроннай пошты, і дазваляе ўдзельнікам правяраць іх',
	'emailcapture-failure' => "Ваш адрас электроннай пошты '''ня''' быў правераны.",
	'emailcapture-invalid-code' => 'Няслушны код пацьверджаньня.',
	'emailcapture-already-confirmed' => 'Ваш адрас электроннай пошты ўжо быў пацьверджаны.',
	'emailcapture-response-subject' => 'Праверка адрасу электронную пошты для {{GRAMMAR:родны|{{SITENAME}}}}',
	'emailcapture-response-body' => 'Вітаем!

Дзякуй, за дапамогу ў паляпшэньні {{GRAMMAR:родны|{{SITENAME}}}}.

Калі ласка, знайдзіце час каб пацьвердзіць Ваш адрас электроннай пошты. Перайдзіце па спасылцы пададзенай ніжэй: 

$1

Таксама, Вы можаце наведаць:

$2

І увесьці наступны код пацьверджаньня:

$3

Хутка мы перададзім Вам інфармацыю, як Вы можаце дапамагчы ў паляпшэньні {{GRAMMAR:родны|{{SITENAME}}}}.

Калі Вы не дасылалі гэты запыт, калі ласка, праігнаруйце гэты ліст, і мы больш не будзем Вас турбаваць.',
	'emailcapture-success' => 'Дзякуем!

Ваш адрас электроннай пошты быў правераны пасьпяхова.',
	'emailcapture-instructions' => 'Каб праверыць Ваш адрас электроннай пошты, увядзіце код, які быў Вам дасланы па электроннай пошце і націсьніце кнопку «{{int:emailcapture-submit}}».',
	'emailcapture-verify' => 'Код праверкі:',
	'emailcapture-submit' => 'Праверыць адрас электроннай пошты',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'emailcapture' => 'Потвърждаване на електронна поща',
	'emailcapture-failure' => "Вашият адрес на електронна поща '''не беше''' потвърден.",
	'emailcapture-invalid-code' => 'Невалиден код за потвърждение.',
	'emailcapture-already-confirmed' => 'Адресът ви за електронна поща вече е бил потвърден.',
	'emailcapture-response-subject' => '{{SITENAME}}: Потвърждение на адрес за електронна поща',
	'emailcapture-response-body' => 'Здравейте!

Благодарим ви за изразения интерес да помогнете за подобряването на {{SITENAME}}.

Моля, отделете малко време, за да потвърдите адреса си за електронна поща, като щракнете на връзката по-долу:
$1

Можете също така да посетите:
$2

и да въведете следния код за потвърждение:
$3

Скоро след потвърждението, ще се свържем с вас с насоки как можете да подобрите {{SITENAME}}.

Ако не вие сте отправили заявката, моля, игнорирайте този имейл. Няма да получавате повече съобщения.',
	'emailcapture-success' => 'Благодарности!

Адресът за електронна поща беше потвърден успешно.',
	'emailcapture-instructions' => 'За да потвърдите вашия адрес за електронна поща, въведете кода, който ви е бил изпратен, и щракнете върху "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Код за потвърждение:',
	'emailcapture-submit' => 'Потвърди имейл адреса',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'emailcapture' => 'ই-মেইল নিশ্চিতকরণ',
	'emailcapture-response-subject' => '{{SITENAME}} সাইটের ই-মেইল ঠিকানা নিশ্চিতকরণ',
	'emailcapture-success' => 'আপনার ই-মেইল ঠিকানা সফলভাবে পরীক্ষিত হয়েছিলো।',
	'emailcapture-verify' => 'নিশ্চিতকরণ কোড:',
	'emailcapture-submit' => 'ই-মেইল ঠিকানা নিশ্চিতকরণ',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'emailcapture' => 'Gwiriañ ar postel',
	'emailcapture-desc' => "Pakañ a ra chomlec'hioù postel ha talvezout a ra d'an implijerien da wiriañ anezho dre bostel",
	'emailcapture-failure' => "'''N'eo ket bet''' gwiriekaet ho chomlec'h postel.",
	'emailcapture-invalid-code' => 'Kod kadarnaat direizh',
	'emailcapture-already-confirmed' => "Kadarnaet eo bet ho chomlec'h postel c'hoazh.",
	'emailcapture-response-subject' => "Gwiriadenn chomlec'h postel evit {{SITENAME}}",
	'emailcapture-response-body' => "Demat deoc'h !

Trugarez deoc'h da vezañ diskouezet bezañ dedennet d'hor skoazellañ evit gwellaat {{SITENAME}}.

Kemerit ur pennadig amzer evit kadarnaat ho chomlec'h postel en ur glikañ war al liamm a-is : 
$1

Gallout a rit ivez mont da welet :
$2

Ha merkañ ar c'hod kadarnaat da-heul :
$3

A-barzh pell ez aimp e darempred ganeoc'h evit ho skoazellañ da wellaat {{SITENAME}}.

Ma n'eo ket deuet ar goulenn ganeoc'h, na rit ket van ouzh ar postel-mañ, ne vo ket kaset mann ebet all deoc'h.",
	'emailcapture-success' => "Trugarez deoc'h !

Gwiriet eo bet ho chomlec'h postel ervat.",
	'emailcapture-instructions' => "Da wiriañ ho chomlec'h postel, merkit ar c'hod zo bet kaset deoc'h ha klikit war \"{{int:emailcapture-submit}}\".",
	'emailcapture-verify' => 'Kod gwiriekaat :',
	'emailcapture-submit' => "Gwiriekaat ar chomlec'h postel",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'emailcapture' => 'Potvrda putem e-maila',
	'emailcapture-failure' => "Vaš e-mail '''nije''' potvrđen.",
	'emailcapture-success' => 'Hvala vam!

Vaš e-mail je uspješno potvrđen.',
	'emailcapture-verify' => 'Kod za potvrdu:',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'emailcapture' => 'Ověření e-mailu',
	'emailcapture-desc' => 'Uchovává e-mailové adresy a umožňuje uživatelům jejich ověření pomocí e-mailu',
	'emailcapture-failure' => "Váš e-mail '''nebyl''' ověřen.",
	'emailcapture-invalid-code' => 'Neplatný ověřovací kód.',
	'emailcapture-already-confirmed' => 'Vaše e-mailová adresa již byla ověřena.',
	'emailcapture-response-subject' => 'Potvrzení e-mailové adresy pro {{grammar:4sg|{{SITENAME}}}}',
	'emailcapture-response-body' => 'Dobrý den!

Děkujeme za vyjádření zájmu pomoci vylepšit {{grammar:4sg|{{SITENAME}}}}.

Věnujte prosím chvilku potvrzení vaší e-mailové adresy kliknutím na následující odkaz:
$1

Také můžete navštívit:
$2

A zadat následující potvrzovací kód:
$3

Brzy se vám ozveme s informacemi, jak můžete pomoci {{grammar:4sg|{{SITENAME}}}} vylepšit.

Pokud tato žádost nepochází od vás, ignorujte prosím tento e-mail, nic dalšího vám posílat nebudeme.',
	'emailcapture-success' => 'Děkujeme!

Váš e-mail byl úspěšně potvrzen.',
	'emailcapture-instructions' => 'Abyste ověřili svou e-mailovou adresu, zadejte kód, který vám přišel e-mailem, a klikněte na „{{int:emailcapture-submit}}“.',
	'emailcapture-verify' => 'Ověřovací kód:',
	'emailcapture-submit' => 'Ověřit e-mailovou adresu',
);

/** German (Deutsch)
 * @author Kghbln
 * @author MF-Warburg
 * @author Metalhead64
 */
$messages['de'] = array(
	'emailcapture' => 'E-Mail-Bestätigung',
	'emailcapture-desc' => 'Ermöglicht das automatische Aufgreifen von E-Mail-Adressen und deren Bestätigung durch deren Benutzer per E-Mail',
	'emailcapture-failure' => "Deine E-Mail-Adresse wurde '''nicht''' bestätigt.",
	'emailcapture-invalid-code' => 'Ungültiger Bestätigungscode.',
	'emailcapture-already-confirmed' => 'Deine E-Mail-Adresse wurde bereits bestätigt.',
	'emailcapture-response-subject' => '{{SITENAME}} E-Mail-Bestätigung',
	'emailcapture-response-body' => 'Hallo!

Vielen Dank für dein Interesse an der Verbesserung von {{SITENAME}}.

Bitte nimm dir einen Moment Zeit, deine E-Mail-Adresse zu bestätigen, indem du auf den folgenden Link klickst:
$1

Du kannst auch die folgende Seite besuchen:
$2

Gib dort den nachfolgenden Bestätigungscode ein:
$3

Wir melden uns in Kürze dazu, wie du helfen kannst, {{SITENAME}} zu verbessern.

Sofern du diese Anfrage nicht ausgelöst hast, ignoriere einfach diese E-Mail. Wir werden dir dann nichts mehr zusenden.',
	'emailcapture-success' => 'Vielen Dank!

Deine E-Mail-Adresse wurde erfolgreich bestätigt.',
	'emailcapture-instructions' => 'Um deine E-Mail-Adresse zu bestätigen, gib bitte den Code ein, der dir per E-Mail zuschickt wurde und klicke anschließend auf „{{int:emailcapture-submit}}“.',
	'emailcapture-verify' => 'Bestätigungscode:',
	'emailcapture-submit' => 'E-Mail-Adresse bestätigen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'emailcapture-failure' => "Ihre E-Mail-Adresse wurde '''nicht''' bestätigt.",
	'emailcapture-response-body' => 'Hallo!

Vielen Dank für Ihr Interesse an der Verbesserung von {{SITENAME}}.

Bitte nehmen Sie sich einen Moment Zeit, Ihre E-Mail-Adresse zu bestätigen, indem Sie auf den folgenden Link klicken:
$1

Sie können auch die folgende Seite besuchen:
$2

Geben Sie dort den nachfolgenden Bestätigungscode ein:
$3

Wir melden uns in Kürze dazu, wie Sie helfen können, {{SITENAME}} zu verbessern.

Sofern Sie diese Anfrage nicht ausgelöst haben, ignorieren einfach diese E-Mail. Wir werden Ihnen dann nichts mehr zusenden.',
	'emailcapture-success' => 'Vielen Dank!

Ihre E-Mail-Adresse wurde erfolgreich bestätigt.',
	'emailcapture-instructions' => 'Um Ihre E-Mail-Adresse zu bestätigen, geben Sie bitte den Code ein, der Ihnen per E-Mail zuschickt wurde und klicken Sie anschließend auf „{{int:emailcapture-submit}}“.',
);

/** Greek (Ελληνικά)
 * @author AK
 * @author Glavkos
 * @author ZaDiak
 */
$messages['el'] = array(
	'emailcapture' => 'Επαλήθευση ηλεκτρονικού ταχυδρομείου',
	'emailcapture-failure' => "Το e-mail σας '''δεν''' επαληθεύτηκε.",
	'emailcapture-response-subject' => '{{SITENAME}} επαλήθευση ηλεκτρονικής διεύθυνσης',
	'emailcapture-response-body' => 'Γεια σας!

Ευχαριστούμε που δείξατε ενδιαφέρον στη βελτίωση της Βικπέδιας.

Παρακαλώ αφιερώστε λίγο χρόνο για να επιβεβαιώσετε την διεύθυνση ηλεκτρονικού ταχυδρομείου σας πατώντας τον παρακάτω σύνδεσμο: 

$1

Μπορείτε επίσης να επισκεφτείτε:

$2

Και πληκτρολογήστε τον ακόλουθο κωδικό επιβεβαίωσης:

$3

Θα επικοινωνήσουμε μαζί σας σύντομα για το πώς μπορείτε να βοηθήσετε στη βελτίωση της Βικιπέδιας.

Εάν δεν ξεκινήσατε εσείς αυτό το αίτημα, παρακαλώ αγνοήστε αυτό το μήνυμα και δε θα σας στείλουμε τίποτα άλλο.',
	'emailcapture-success' => 'Ευχαριστούμε!

Το e-mail σας έχει επιβεβαιωθεί με επιτυχία.',
	'emailcapture-instructions' => 'Για να επαληθεύσετε τη διεύθυνση ηλεκτρονικού ταχυδρομείου σας, πληκτρολογήστε τον κωδικό που σας στάλθηκε  και κάντε κλικ στο "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Κωδικός επαλήθευσης:',
	'emailcapture-submit' => 'Επιβεβαιώστε τη διεύθυνση ηλεκτρονικού ταχυδρομείου',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'emailcapture' => 'Retpoŝta kontrolado',
	'emailcapture-desc' => 'Kapti retpoŝadresojn, kaj permesi al uzantoj kontroli tion per retpoŝto',
	'emailcapture-failure' => "Via retpoŝtadreso '''ne estis''' kontrolita.",
	'emailcapture-invalid-code' => 'Malvalida konfirmkodo.',
	'emailcapture-already-confirmed' => 'Via retpoŝtadreso estas jam konfirmita.',
	'emailcapture-response-subject' => '{{SITENAME}} retpoŝta konfirmado',
	'emailcapture-response-body' => 'Saluton!

Dankon pro esprimante intereson helpi plibonigi {{SITENAME}}.

Bonvolu konfirmi vian retpoŝtadreson klakante la jenan ligilon:
$1

Ankaŭ vi povas viziti:
$2

kaj enigi la jenan konfirmkodon:
$3

Ni respondos baldaŭ kiel vi povas helpi plibonigi {{SITENAME}}.

Se vi ne eksendis ĉi tiun peton, bonvolu ignori ĉi tiun retpoŝton, kaj ni ne sendos al vi ion ajn.',
	'emailcapture-success' => 'Dankegon!

Via retpoŝtadreso estis sukcese kontrolita.',
	'emailcapture-instructions' => 'Por kontroli vian retpoŝtadreson, enigi la kodo kiu estis retpoŝtita al vi kaj klaku butonon "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Kontrolkodo:',
	'emailcapture-submit' => 'Konfirmi adreson de retpoŝto',
);

/** Spanish (Español)
 * @author Fitoschido
 * @author Imre
 * @author MetalBrasil
 * @author Platonides
 */
$messages['es'] = array(
	'emailcapture' => 'Verificación de correo electrónico',
	'emailcapture-desc' => 'Obtiene direcciones de e-mail y permite a los usuaros confirmarlas',
	'emailcapture-failure' => "Tu e-mail fue'''no''' verificada.",
	'emailcapture-invalid-code' => 'El código de validación no es válido.',
	'emailcapture-already-confirmed' => 'Tu dirección de correo electrónico ya ha sido confirmada.',
	'emailcapture-response-subject' => '{{SITENAME}} dirección de correo electrónico de verificación',
	'emailcapture-response-body' => '¡Hola!

Gracias por tu interés en ayudar a mejorar {{SITENAME}}.

Por favor, dedica un momento a confirmar tu correo electrónico haciendo clic en el siguiente enlace:
$1

Alternativamente, puedes visitar:
$2

E introducir el siguiente código de confirmación:
$3

Nos pondremos en contacto contigo con información para para ayudarte a mejorar {{SITENAME}}.

Si no realizaste esta solicitud, por favor ignora este correo y no te enviaremos más información.

Gracias por tu atención, con nuestros mejores deseos,
El equipo de {{SITENAME}}.',
	'emailcapture-success' => '¡Muchas gracias!  Tu e-mail ha sido confirmado exitosamente.',
	'emailcapture-instructions' => 'Para verificar su dirección de correo electrónico, escriba el código que fue enviado por correo electrónico a usted y haga clic en "{{int: emailcapture a presentar}}".',
	'emailcapture-verify' => 'Código de verificación:',
	'emailcapture-submit' => 'Verificar dirección de correo electrónico',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'emailcapture' => 'E-posti kinnitamine',
	'emailcapture-failure' => "Sinu e-posti aadressi '''ei''' kinnitatud.",
	'emailcapture-invalid-code' => 'Vigane kinnituskood.',
	'emailcapture-already-confirmed' => 'Sinu e-posti aadress on juba kinnitatud.',
	'emailcapture-response-subject' => '{{GRAMMAR:genitive|{{SITENAME}}}} e-posti aadressi kinnitus',
	'emailcapture-response-body' => 'Tere!

Aitäh, et tunned huvi {{GRAMMAR:genitive|{{SITENAME}}}} täiendamise vastu.

Palun leia natuke aega, et kinnitada oma e-posti aadress. Selleks klõpsa järgmist linki:
$1

Samuti võid minna järgmisele leheküljele:
$2

Ja sisestada järgmise kinnituskoodi:
$3

Võtame sinuga peagi ühendust, et rääkida, kuidas saad {{GRAMMAR:partitive|{{SITENAME}}}} täiendada.

Kui sa pole soovinud e-posti aadressi kinnitada, eira palun seda e-kirja ja me ei saada sulle enam midagi.',
	'emailcapture-success' => 'Aitäh!

Sinu e-posti aadress on edukalt kinnitatud.',
	'emailcapture-instructions' => 'Et oma e-posti aadress kinnitada, sisesta e-kirjatsi saadud kood ja klõpsa "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Kinnituskood:',
	'emailcapture-submit' => 'Kinnita e-posti aadress',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'emailcapture' => 'تأیید پست الکترونیکی',
	'emailcapture-desc' => 'ثبت نشانی های پست الکترونیکی، و به کاربران اجازه می‌دهد که آن‌ها از طریق پست الکترونیکی تأیید کنند',
	'emailcapture-failure' => "پست الکترونیکی شما تأیید '''نشده''' است.",
	'emailcapture-response-subject' => 'تأیید نشانی پست الکترونیکی {{SITENAME}}',
	'emailcapture-response-body' => 'سلام!

از شما برای ابراز علاقه در کمک به بهبود {{SITENAME}} تشکر می‌کنم.

لطفاً لحظه‌ای را برای تأیید پست الکترونیکی خود با کلیک بر روی پیوند مقابل، وقت بگذارید:
$1
شما همچنین می‌توانید پیوند مقابل را باز کرده:
$2

و کد مقابل را درون آن وارد کنید:
$3

ما به زودی با شما برای چگونگی کمک به {{SITENAME}} تماس می‌گیریم.

اگر شما این درخواست را نکرده‌اید، لطفاً این پست الکترونیکی را نادیده بگیرید و ما چیز دیگری برای شما ارسال نخواهیم کرد.',
	'emailcapture-success' => 'از شما متشکرم!

پست الکترونیکی شما با موفقیت تأیید شد.',
	'emailcapture-instructions' => 'برای تأیید نشانی پست الکترونیکی خود، کدی را که برای شما ارسال شده بود را وارد کنید و بر روی «{{int:emailcapture-submit}}» کلیک کنید.',
	'emailcapture-verify' => 'کد تأیید:',
	'emailcapture-submit' => 'تأیید پست الکترونیکی',
);

/** Finnish (Suomi)
 * @author Nedergard
 * @author Olli
 */
$messages['fi'] = array(
	'emailcapture' => 'Sähköpostin vahvistus',
	'emailcapture-desc' => 'Kaappaa sähköpostiosoitteet, ja salli käyttäjien vahvistaa ne sähköpostilla',
	'emailcapture-failure' => "Sähköpostiosoitettasi '''ei''' vahvistettu.",
	'emailcapture-invalid-code' => 'Virheellinen varmistuskoodi.',
	'emailcapture-already-confirmed' => 'Sähköpostiosoitteesi on jo varmennettu.',
	'emailcapture-response-subject' => 'Sivuston {{SITENAME}} sähköpostiosoitteen vahvistus',
	'emailcapture-response-body' => 'Hei!

Kiitos, että osoitit kiinnostusta {{SITENAME}} kehittämiseen.

Käytäthän hetken täyttääksesi kyselyn:
$1

Voit myös käydä:
$2

Ja syöttää seuraavan koodin:
$3

Otamme yhteyttä sinuun pian ja kerromme kuinka voit kehittää {{SITENAME}} sivustoa.

Jos et lähettänyt tätä pyyntöä itse, hylkää viesti ja emme enää lähetä sinulle uutta viestiä.',
	'emailcapture-success' => 'Kiitos!

Sähköpostiosoitteesi vahvistettiin onnistuneesti.',
	'emailcapture-instructions' => 'Vahvistaaksesi sähköpostiosoitteesi, syötä sinulle sähköpostilla lähetetty koodi ja napsauta "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Vahvistuskoodi:',
	'emailcapture-submit' => 'Vahvista sähköpostiosoite',
);

/** French (Français)
 * @author Hashar
 * @author IAlex
 * @author Sherbrooke
 * @author Urhixidur
 * @author Wyz
 */
$messages['fr'] = array(
	'emailcapture' => 'Vérification de courriel',
	'emailcapture-desc' => 'Capture des adresses de courriel et permet aux utilisateurs de les vérifier par courriel',
	'emailcapture-failure' => "Votre adresse de courriel n'a '''pas''' été vérifiée.",
	'emailcapture-invalid-code' => 'Code de confirmation incorrect.',
	'emailcapture-already-confirmed' => 'Votre adresse de courriel a déjà été confirmée.',
	'emailcapture-response-subject' => "Vérification d'adresse de courriel de {{SITENAME}}",
	'emailcapture-response-body' => 'Bonjour,

Merci de démontrer votre intérêt à améliorer le {{SITENAME}}.

Vérifiez votre adresse de courriel en suivant le lien suivant :
$1

Vous pouvez aussi visiter :
$2

et entrer le code de vérification suivant :
$3

Nous vous contacterons bientôt pour savoir comment vous pouvez aider à améliorer le {{SITENAME}}.

Si vous n’avez pas entamé cette requête, vous n’avez qu’à ignorer ce courriel et nous ne vous enverrons plus rien d’autre.',
	'emailcapture-success' => 'Merci !

Votre adresse de courriel a été vérifiée avec succès.',
	'emailcapture-instructions' => 'Pour vérifier votre adresse de courriel, entrez le code qui vous a été envoyé par courriel et cliquez sur « {{int:emailcapture-soumettre}} ».',
	'emailcapture-verify' => 'Code de vérification :',
	'emailcapture-submit' => "Vérifiez l'adresse de courriel",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'emailcapture' => 'Contrôlo d’adrèce èlèctronica',
	'emailcapture-desc' => 'Capture des adrèces èlèctroniques et pués pèrmèt ux utilisators de les controlar per mèssageria èlèctronica.',
	'emailcapture-failure' => "Voutra adrèce èlèctronica at '''pas''' étâ controlâ.",
	'emailcapture-invalid-code' => 'Code de confirmacion fôx.',
	'emailcapture-already-confirmed' => 'Voutra adrèce èlèctronica at ja étâ confirmâ.',
	'emailcapture-response-subject' => 'Contrôlo d’adrèce èlèctronica de {{SITENAME}}',
	'emailcapture-response-body' => 'Bonjorn !

Grant-marci d’avêr èxprimâ voutron entèrèt por édiér a mèlyorar {{SITENAME}}.

Volyéd prendre un moment por confirmar voutra adrèce èlèctronica en cliquent sur lo lim ce-desot :
$1

Vos pouede asse-ben visitar :
$2

et pués buchiér ceti code de confirmacion :
$3

Nos nos volens d’abôrd veriér vers vos avouéc la façon que vos pouede édiér a mèlyorar {{SITENAME}}.

Se vos éd pas fêt cela demanda, volyéd ignorar ceti mèssâjo et pués nos vos manderens ren d’ôtro.',
	'emailcapture-success' => 'Grant-marci !

Voutra adrèce èlèctronica at étâ controlâ avouéc reusséta.',
	'emailcapture-instructions' => 'Por controlar voutra adrèce èlèctronica, buchiéd lo code que vos at étâ mandâ per mèssageria èlèctronica et pués clicâd dessus « {{int:emailcapture-submit}} ».',
	'emailcapture-verify' => 'Code de contrôlo :',
	'emailcapture-submit' => 'Controlar l’adrèce èlèctronica',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'emailcapture' => 'Verificación do correo electrónico',
	'emailcapture-desc' => 'Captura enderezos de correo electrónico e permite aos usuarios comprobalos a través do propio correo electrónico',
	'emailcapture-failure' => "O seu correo electrónico '''non''' foi verificado.",
	'emailcapture-invalid-code' => 'Código de confirmación incorrecto.',
	'emailcapture-already-confirmed' => 'Xa se confirmou o seu enderezo de correo electrónico.',
	'emailcapture-response-subject' => 'Verificación do enderezo de correo electrónico de {{SITENAME}}',
	'emailcapture-response-body' => 'Ola!

Grazas por expresar interese en axudar a mellorar {{SITENAME}}.

Tome un momento para confirmar o seu correo electrónico premendo na ligazón que hai a continuación: 
$1

Tamén pode visitar:
$2

E inserir o seguinte código de confirmación:
$3

Poñerémonos en contacto con vostede para informarlle sobre como axudar a mellorar {{SITENAME}}.

Se vostede non fixo esta petición, ignore esta mensaxe e non lle enviaremos máis nada.',
	'emailcapture-success' => 'Grazas!

O seu enderezo de correo electrónico verificouse correctamente.',
	'emailcapture-instructions' => 'Para verificar o seu enderezo de correo electrónico, introduza o código que se lle enviou e prema en "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Código de verificación:',
	'emailcapture-submit' => 'Verificar o enderezo de correo electrónico',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 */
$messages['gsw'] = array(
	'emailcapture-verify' => 'Bstätigungscode:',
	'emailcapture-submit' => 'E-Mail-Adräss bstätige',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'emailcapture' => 'אימות כתובת דואר אלקטרוני',
	'emailcapture-desc' => 'לכידה של כתובת דואר אלקטרוני ואפשרות לאמת את הכתובת דרך דואר אלקטרוני',
	'emailcapture-failure' => "הדואר האלקטרוני שלך היה '''לא''' אומתה.",
	'emailcapture-invalid-code' => 'קוד אימות בלתי־תקין.',
	'emailcapture-already-confirmed' => 'כתובת הדוא״ל שלך כבר אומתה.',
	'emailcapture-response-subject' => 'אימות כתובת דואר אלקטרוני באתר {{SITENAME}}',
	'emailcapture-response-body' => 'שלום!

תודה על הבעת העניין בעזרה לאתר {{SITENAME}}.

אנא הקדישו דקה לאימות הדואר האלקטרוני שלכם באמצעות לחיצה על הקישור הבא:
$1

אפשר גם לבקר כאן:
$2

ולהכניס את קוד האימות הבא:
$3

אנחנו ניצור אתכם קשר עם מידע על הדרכים שבהן תוכלו לעזור לשפר את אתר {{SITENAME}}.

אם לא שלחתם את הבקשה הזאת, התעלמו מהמכתב הזה ולא נשלח להם עוד שום דבר.',
	'emailcapture-success' => 'תודה!

כתובת הדוא״ל שלכם אומתה בהצלחה.',
	'emailcapture-instructions' => 'כדי לאמת את כתובת הדוא״ל שלכם, הכניסו את הקוד שנשלח אליכם ולחצו על "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'קוד אימות:',
	'emailcapture-submit' => 'לאמת כתובת דוא״ל',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'emailcapture' => 'ई-मेल सत्यापन',
	'emailcapture-desc' => 'ई-मेल पते पर कब्जा करें, और सदस्यों को उनके ई-मेल द्वारा सत्यापित करने की अनुमति दें',
	'emailcapture-failure' => "आपकी ई-मेल सत्यापन '''नहीं''' हुई है ।",
	'emailcapture-invalid-code' => 'अमान्य पुष्टिकरण कोड ।',
	'emailcapture-already-confirmed' => 'आपका ई-मेल पता पहले से ही पुष्टि की गई है।',
	'emailcapture-response-subject' => '{{SITENAME}} ई-मेल पता सत्यापन',
	'emailcapture-response-body' => 'नमस्कार!

{{SITENAME}} को बेहतर बनाने के लिए मदद करने में रुचि व्यक्त करने के लिए धन्यवाद ।

कृपया नीचे दिए गए लिंक पर क्लिक करके अपने ई-मेल की पुष्टि करें:
$1

आप ये भी देख सकते हैं:
$2

और निम्न पुष्टिकरण कोड प्रविष्ट करें:
$3

हम शीघ्र ही {{SITENAME}} सुधार के लिए कैसे आप मदद कर सकते हैं ये जानकारी देंगे ।
यदि आप इस अनुरोध को आरंभ नहीं किया है, कृपया इस ई-मेल पर ध्यान न दें और हम और कुछ नहीं भेजेंगे ।',
	'emailcapture-success' => 'धन्यवाद!

आपके ई-मेल सफलतापूर्वक पुष्टि की गई है।',
	'emailcapture-instructions' => 'आपके ई-मेल पते को सत्यापित करने के लिए, कोड निवेश करें जो आपको ई-मेल किया गया था और क्लिक करें "{{int:emailcapture-submit}}"।',
	'emailcapture-verify' => 'सत्यापन कोड:',
	'emailcapture-submit' => 'ई-मेल पते जाँच करें',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'emailcapture' => 'E-mejlowe přepruwowanje',
	'emailcapture-desc' => 'Zmóžnja popadnjenje e-mejlowych adresow a dowola wužiwarjam je přez e-mejl přepruwować',
	'emailcapture-failure' => "Twoja e-mejl '''nje'''je so přepruwowała.",
	'emailcapture-invalid-code' => 'Njepłaćiwy wobkrućenski kod.',
	'emailcapture-already-confirmed' => 'Twoja e-mejlowa adresa bu hižo wobkrućena.',
	'emailcapture-response-subject' => '{{SITENAME}} – přepruwowanje e-mejloweje adresy',
	'emailcapture-response-body' => 'Halo!

Wulki dźak za twój zajim {{GRAMMAR:akuzatiw|{{SITENAME}}}} polěpšić.

Prošu bjer sej wokomik časa, zo by swoju e-mejl přez kliknjenje na slědowacy wotkaz wobkrućił:
$1

Móžeš tež slědowacu stronu wopytać:
$2

Zapodaj potom slědowacy wobkrućenski kod:
$3

Stajimy so za krótki čas z tobu do zwiska, zo bychmy ći zdźělili, kak móžeš pomhać, {{GRAMMAR:akuzatiw|{{SITENAME}}}} polěpšić.

Jeli njejsy tute naprašowanje pósłał, ignoruj prošu tutu e-mejl a njepósćelemy ći ničo wjace.',
	'emailcapture-success' => 'Wulki dźak!

Waša e-mejl je so wuspěšnje wobkrućiła.',
	'emailcapture-instructions' => 'Zo by swoju e-mejlowu adresu wobkrućił, zapodajće kod, kotryž je so ći přez e-mejl připósłał a klikń na "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Wobkrućenski kod:',
	'emailcapture-submit' => 'E-mejlowu adresu wobkrućić',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dj
 */
$messages['hu'] = array(
	'emailcapture' => 'E-mail ellenőrzése',
	'emailcapture-desc' => 'Rögzíti az email címeket és lehetőséget biztosít az ellenőrzésükre',
	'emailcapture-failure' => "Az e-mail címed ellenőrzése '''nem''' sikerült.",
	'emailcapture-invalid-code' => 'Érvénytelen ellenőrzőkód.',
	'emailcapture-already-confirmed' => 'Az e-mail címed már ellenőrzésre került.',
	'emailcapture-response-subject' => '{{SITENAME}} e-mail cím megerősítés',
	'emailcapture-success' => 'Köszönjük!

Az e-mail címed sikeresen ellenőrzésre került.',
	'emailcapture-verify' => 'Ellenőrző kód:',
	'emailcapture-submit' => 'E-mail cím megerősítése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'emailcapture' => 'Verification de e-mail',
	'emailcapture-desc' => 'Capturar adresses de e-mail, e permitter al usatores de verificar los per e-mail',
	'emailcapture-failure' => "Tu adresse de e-mail '''non''' ha essite verificate.",
	'emailcapture-invalid-code' => 'Codice de confirmation invalide.',
	'emailcapture-already-confirmed' => 'Tu adresse de e-mail ha jam essite confirmate.',
	'emailcapture-response-subject' => 'Verification del adresse de e-mail pro {{SITENAME}}',
	'emailcapture-response-body' => 'Salute!

Gratias pro haber interesse in adjutar a meliorar {{SITENAME}}.

Per favor prende un momento pro confirmar tu adresse de e-mail, con un clic super le ligamine sequente:
$1

Alternativemente, visita:
$2

...e entra le codice de confirmation sequente:
$3

Nos va tosto contactar te pro explicar como tu pote adjutar a meliorar {{SITENAME}}.

Si tu non ha initiate iste requesta, per favor ignora iste e-mail e nos non te inviara altere cosa.',
	'emailcapture-success' => 'Gratias!

Tu adresse de e-mail ha essite confirmate con successo.',
	'emailcapture-instructions' => 'Pro verificar tu adresse de e-mail, entra le codice que te esseva inviate in e-mail, e clicca super "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Codice de verification:',
	'emailcapture-submit' => 'Verificar adresse de e-mail',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'emailcapture' => 'Verifikasi surel',
	'emailcapture-desc' => 'Merekam alamat surel dan memungkinkan pengguna untuk melakukan verifikasi melalui surel',
	'emailcapture-failure' => "Surel Anda '''belum'' terverifikasi.",
	'emailcapture-response-subject' => 'Verifikasi alamat surel {{SITENAME}}',
	'emailcapture-response-body' => 'Halo!

Terima kasih Anda telah menyatakan minat untuk membantu penyempurnaan {{SITENAME}}.

Harap luangkan waktu sejenak untuk memverifikasikan alamat surel Anda dengan mengikuti tautan berikut:
$1

Anda juga dapat mengunjungi:
$2

dan memasukkan kode verifikasi berikut:
$3

Kami akan segera menghubungi Anda untuk memberi tahu cara membantu menyempurnakan {{SITENAME}}.

Jika Anda merasa tidak mengirim permintaan ini, harap abaikan saja surel ini dan kami tidak akan lagi mengirimkan apa pun kepada Anda.',
	'emailcapture-success' => 'Terima kasih!

Alamat surel Anda berhasil diverifikasi.',
	'emailcapture-instructions' => 'Untuk memverifikasi alamat surel Anda, masukkan kode yang dikirim melalui surel kepada Anda dan klik "{{int: emailcapture-submit}}".',
	'emailcapture-verify' => 'Kode verifikasi:',
	'emailcapture-submit' => 'Verifikasi alamat surel',
);

/** Italian (Italiano)
 * @author Aushulz
 * @author F. Cosoleto
 */
$messages['it'] = array(
	'emailcapture' => 'Verifica email',
	'emailcapture-failure' => "L'email '''non''' è stata verificata.",
	'emailcapture-invalid-code' => 'Codice di conferma non valido.',
	'emailcapture-already-confirmed' => "L'indirizzo email è già stato confermato.",
	'emailcapture-response-subject' => "{{SITENAME}}: conferma dell'indirizzo email",
	'emailcapture-response-body' => "Ciao e grazie per l'interesse mostrato nel contribuire a migliorare {{SITENAME}}.

Per favore, conferma il tuo indirizzo email cliccando sul collegamento sottostante:
$1

Si può anche visitare:
$2

e inserire il seguente codice di conferma:
$3

Nel caso non fossi stato tu ad attivare questa richiesta, ti preghiamo d'ignorare questa email e non se ne riceveranno altre da parte nostra.",
	'emailcapture-success' => 'Grazie!

La e-mail è stata confermata con successo.',
	'emailcapture-instructions' => 'Per verificare il tuo indirizzo e-mail, inserire il codice che ti è stato inviato tramite posta elettronica e cliccare su "{{int:emailcapture-presentare}}".',
	'emailcapture-verify' => 'Codice di verifica:',
	'emailcapture-submit' => 'Verifica indirizzo email',
);

/** Japanese (日本語)
 * @author Schu
 */
$messages['ja'] = array(
	'emailcapture' => '電子メールの検証',
);

/** Georgian (ქართული)
 * @author BRUTE
 */
$messages['ka'] = array(
	'emailcapture-success' => 'გმადლობთ!

თქვენი ი-მეილი წარმატებით დადასტურდა.',
	'emailcapture-verify' => 'დამოწმების კოდი:',
	'emailcapture-submit' => 'ი-მეილის დამოწმება',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'emailcapture' => '이메일 인증',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'emailcapture' => 'Adräß för de <i lang="en">e-mail</i> schnappe un prööve',
	'emailcapture-desc' => 'Schnabb en Adräß för de <i lang="en">e-mail</i> un lohß de Metmaacher se övver en <i lang="en">e-mail</i> beschtäätejje.',
	'emailcapture-failure' => "Ding <i lang=\"en\">e-mail</i> wood '''nit''' beschtätesch",
	'emailcapture-invalid-code' => 'Dä Schlößelkood för et Beschtääteje schtemmp nit.',
	'emailcapture-already-confirmed' => 'Ding Addräß fö de <i lang="en">e-mail<i> es ald bestätisch jewääse.',
	'emailcapture-response-subject' => '{{ucfirst:{{GRAMMAR:Genitiv ier feminine|{{SITENAME}}}}}} Beschtätejung för Adräße vun de <i lang="en">e-mail</i>',
	'emailcapture-response-body' => 'Mer bedangke uns för Ding Enträße, {{GRAMMAR:Akkusativ|{{SITENAME}}}} bäßer ze maache.

Nemm Der ene Momang, öm Ding e-mail Adräß ze beschtääteje, un donn däm Lingk heh follje:
$1

Do kanns och op heh di Sigg jonn:
$2

un dann dä Kood heh enjävve:
$3

Mer mälde ons bahl bei Der, wi de met {{GRAMMAR:Dativ|{{SITENAME}}}} hälfe kanns.

Wann De dat heh sällver nit aanjschtüße häs, donn nix, un mer don Der och nix mieh schecke.

Ene schööne Jrohß!',
	'emailcapture-success' => 'Ene schönne Dank!

Ding Adräß för de <i lang="en">e-mail</i> wood beschtäätesch.',
	'emailcapture-instructions' => 'Öm Ding Adräß för de <i lang="en">e-mail</i> ze bschtäätejje, donn onge dä Kood enjävve, dän De jescheck krääje häß, un donn dann op „{{int:emailcapture-submit}}“ klecke.',
	'emailcapture-verify' => 'Dä Kood för et Beschtäätejje:',
	'emailcapture-submit' => 'Lohß jonn!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'emailcapture' => 'E-Mail-Iwwerpréifung',
	'emailcapture-desc' => 'Mailadressen erfaassen, an de Benotzer erlabe fir ze per Mail ze validéieren',
	'emailcapture-failure' => "Är E-Mail konnt '''net''' confirméiert ginn.",
	'emailcapture-invalid-code' => 'Net valabele Confirmatiounscode.',
	'emailcapture-already-confirmed' => 'Är E-Mailadress gouf scho confirméiert.',
	'emailcapture-response-subject' => '{{SITENAME}} Mail-Confirmatioun',
	'emailcapture-response-body' => 'Bonjour! 

Merci fir Ären Interessie fir {{SITENAME}} ze verbesseren.

Huelt Iech w.e.g. een Ament Zäit fir Är Mailadress ze confirméieren, andeem Dir op dëse Link klickt:
$1

Dir kënnt och dës Säit besichen:
$2

Gitt do dëse Confirmatiouns-Code an:
$3

Mir mellen eis geschwënn, fir Iech ze soe, wéi Dir hëllefe kënnt fir {{SITENAME}} ze verbesseren.

Wann Dir dës Ufro net ausgeléist hutt, ignoréiert dës Mail einfach. Mir schécken Iech dann och näischt méi.',
	'emailcapture-success' => 'Merci!

Är E-Mailadress konnt confirméiert ginn.',
	'emailcapture-instructions' => 'Fir d\'Mailadress ze confirméieren, gitt de Code an deen Dir per Mail geschéckt kritt hutt a klickt "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Iwwerpréifungs-Code:',
	'emailcapture-submit' => 'E-Mail-Adress iwwerpréifen',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'emailcapture' => 'E-pašto patvirtinimas',
	'emailcapture-response-subject' => '{{SITENAME}} el. pašto adreso patvirtinimas',
	'emailcapture-success' => 'Ačiū!

Jūsų e-paštas buvo sėkmingai patvirtintas.',
	'emailcapture-instructions' => 'Norėdami patvirtinti savo elektroninio pašto adresą, įveskite kodą, kuris elektroniniu paštu buvo jums nusiųstas, ir paspauskite mygtuką "{{int: emailcapture-submit}}".',
	'emailcapture-verify' => 'Patvirtinimo kodas:',
	'emailcapture-submit' => 'Patvirtinti e-pašto adresą',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'emailcapture' => 'Потврда на е-пошта',
	'emailcapture-desc' => 'Заведување на е-поштенски адреси што корисниците можат да ги потврдат преку порака',
	'emailcapture-failure' => "Вашата е-пошта '''не''' е потврдена.",
	'emailcapture-invalid-code' => 'Неважечки потврден код.',
	'emailcapture-already-confirmed' => 'Вашата е-поштенска адреса е веќе потврдена.',
	'emailcapture-response-subject' => '{{SITENAME}} — Потврда на е-пошта',
	'emailcapture-response-body' => 'Здраво!

Ви благодариме што изразивте интерес да помогнете во развојот на {{SITENAME}}.

Потврдете ја вашата е-пошта на следнава врска: 

$1

Можете да ја посетите и страницата:

$2

Внесете го следниов потврден кон:

$3

Набргу ќе ви пишеме како можете да помогнете во подобрувањето на {{SITENAME}}.

Ако го немате побарано ова, занемарате ја поракава, и повеќе ништо нема да ви испраќаме.',
	'emailcapture-success' => 'Ви благодариме!

Вашата е-пошта е успешно потврдена.',
	'emailcapture-instructions' => 'За да ја потврдите вашата е-пошта, внесете го кодот што ви го испративме и стиснете на „{{int:emailcapture-submit}}“.',
	'emailcapture-verify' => 'Потврден код:',
	'emailcapture-submit' => 'Потврди е-пошта',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'emailcapture' => 'ഇമെയിൽ പരിശോധന',
	'emailcapture-desc' => 'ഇമെയിൽ സ്വയം എടുക്കുകയും ഉപയോക്താക്കളെ ഇമെയിൽ ഉപയോഗിച്ച് പരിശോധിക്കുകയും ചെയ്യുന്നു',
	'emailcapture-failure' => "താങ്കളുടെ ഇമെയിൽ വിലാസം '''പരിശോധിച്ചിട്ടില്ല'''.",
	'emailcapture-invalid-code' => 'സ്ഥിരീകരണ കോഡ് അസാധുവാണ്.',
	'emailcapture-already-confirmed' => 'താങ്കളുടെ ഇമെയിൽ വിലാസം മുമ്പേ തന്നെ സ്ഥിരീകരിക്കപ്പെട്ടതാണ്.',
	'emailcapture-response-subject' => '{{SITENAME}} സംരംഭത്തിലെ ഇമെയിൽ വിലാസ പരിശോധന',
	'emailcapture-response-body' => 'നമസ്കാരം!

{{SITENAME}} സംരംഭം മെച്ചപ്പെടുത്താനുള്ള താത്പര്യത്തിനു അകമഴിഞ്ഞ നന്ദി.

താഴെക്കൊടുത്തിരിക്കുന്ന കണ്ണി ഞെക്കി താങ്കളുടെ ഇമെയിൽ വിലാസം സ്ഥിരീകരിക്കാൻ ഒരു നിമിഷം ദയവായി ചിലവഴിക്കുക:
$1

ഇതും താങ്കൾക്ക് സന്ദർശിക്കാവുന്നതാണ്:
$2

എന്നിട്ട് താഴെ കൊടുത്തിരിക്കുന്ന സ്ഥിരീകരണ കോഡ് നൽകുക:
$3

{{SITENAME}} സംരംഭം മെച്ചപ്പെടുത്താൻ താങ്കൾക്ക് എങ്ങനെ സഹായിക്കാനാകും എന്ന് തീരുമാനിക്കാൻ ഞങ്ങൾ താങ്കളുമായി ഉടനെ ബന്ധപ്പെടുന്നതായിരിക്കും.

താങ്കളുടെ ഇച്ഛ പ്രകാരം അല്ല ഈ അഭ്യർത്ഥനയെങ്കിൽ, ഈ ഇമെയിൽ അവഗണിക്കുക, ഞങ്ങൾ താങ്കൾക്ക് പിന്നീടൊന്നും അയച്ച് ബുദ്ധിമുട്ടിയ്ക്കില്ല.',
	'emailcapture-success' => 'നന്ദി!

താങ്കളുടെ ഇമെയിൽ വിലാസം വിജയകരമായി സ്ഥിരീകരിച്ചിരിക്കുന്നു.',
	'emailcapture-instructions' => 'താങ്കളുടെ ഇമെയിൽ വിലാസം പരിശോധനയ്ക്കു പാത്രമാക്കുവാൻ, താങ്കൾക്ക് ഇമെയിൽ വഴി അയച്ചിട്ടുള്ള കോഡ് നൽകിയ ശേഷം "{{int:emailcapture-submit}}" ഞെക്കുക.',
	'emailcapture-verify' => 'പരിശോധനയ്ക്കുള്ള കോഡ്:',
	'emailcapture-submit' => 'ഇമെയിൽ വിലാസം പരിശോധനയ്ക്ക് പാത്രമാക്കുക',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'emailcapture' => 'Pengesahan e-mel',
	'emailcapture-desc' => 'Menangkap alamat e-mel dan membolehkan pengguna untuk mengesahkannya melalui e-mel',
	'emailcapture-failure' => "E-mel anda '''belum''' disahkan.",
	'emailcapture-invalid-code' => 'Kod pengesahan tidak sah.',
	'emailcapture-already-confirmed' => 'Alamat e-mel anda telah disahkan.',
	'emailcapture-response-subject' => 'Pengesahan alamat e-mel {{SITENAME}}',
	'emailcapture-response-body' => 'Selamat sejahtera!

Terima kasih kerana menunjukkan minat untuk membantu mempertingkatkan {{SITENAME}}.

Sila luangkan sedikit masa untuk mengesahkan e-mel anda dengan mengklik pautan berikut:

$1

Anda juga boleh melawati:

$2

Dan isikan kod pengesahan yang berikut:

$3

Kami akan menghubungi anda sebentar lagi dengan cara-cara untuk anda mempertingkat mutu {{SITENAME}}.

Jika bukan anda yang membuat permohonan ini, sila abaikan e-mel ini dan kami tidak akan menghantar apa-apa lagi kepada anda.',
	'emailcapture-success' => 'Terima kasih!

E-mel anda berjaya disahkan.',
	'emailcapture-instructions' => 'Untuk mengesahkan alamat e-mel anda, isikan kod yang dihantar kepada anda melalui e-mel, kemudian klik "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Kod pengesahan:',
	'emailcapture-submit' => 'Sahkan alamat e-mel',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Sjurhamre
 */
$messages['nb'] = array(
	'emailcapture' => 'E-postbekreftelse',
	'emailcapture-desc' => 'Samler inn e-postadresser, og lar brukere bekrefte dem via e-post',
	'emailcapture-failure' => "E-postadressen din ble '''ikke''' bekreftet",
	'emailcapture-response-subject' => 'E-postbekreftelse fra {{SITENAME}}',
	'emailcapture-response-body' => 'Bekreft e-postadressen din ved å følge lenken under:
$1

Eventuelt kan du besøke:
$2

Og skrive inn følgende bekreftelseskode:
$3

Takk for at du bekrefter e-postadressen din.',
	'emailcapture-success' => 'E-postadressen din har blitt bekreftet.',
	'emailcapture-instructions' => 'For å bekrefte e-postadressen din, skriver du inn koden du fikk på e-post, og klikker "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Bekreftelseskode:',
	'emailcapture-submit' => 'Bekreft e-postadresse',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'emailcapture' => 'E-mailadresbevestiging',
	'emailcapture-desc' => 'E-mailadressen bevestigen en stelt gebruikers in staat dit te doen via e-mail',
	'emailcapture-failure' => "Uw e-mailadres is '''niet''' bevestigd.",
	'emailcapture-invalid-code' => 'Ongeldige bevestigingscode.',
	'emailcapture-already-confirmed' => 'Uw e-mailadres is al bevestigd.',
	'emailcapture-response-subject' => 'E-mailadrescontrole van {{SITENAME}}',
	'emailcapture-response-body' => 'Hallo!

Bedankt voor uw interesse in het verbeteren van {{SITENAME}}.

Volg deze verwijzing om uw e-mailadres te bevestigen:
$1

U kunt ook deze verwijzing volgen:
$2

En daar de volgende bevestigingscode invoeren:
$3

We nemen binnenkort contact met u op over hoe u kunt helpen {{SITENAME}} te verbeteren.

Als u niet hebt gevraagd om dit bericht, negeer deze e-mail dan en dan krijgt u geen e-mail meer van ons.',
	'emailcapture-success' => 'Bedankt!

Uw e-mailadres is bevestigd.',
	'emailcapture-instructions' => 'Voer de code uit uw e-mail in om uw e-mailadres te bevestigen en klik daarna op "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Bevestigingscode:',
	'emailcapture-submit' => 'E-mailadres bevestigen',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'emailcapture-success' => 'Bedankt!

Je e-mailadres is bevestigd.',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'emailcapture' => 'ଇ-ମେଲ ଜାଞ୍ଚ',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'emailcapture' => 'Weryfikacja adresu e‐mailowego',
	'emailcapture-desc' => 'Przechowywanie adresów e‐mailowych i umożliwianie użytkownikom sprawdzenie ich poprzez e‐mail',
	'emailcapture-failure' => "Twój adres e‐mailowy '''nie''' został zweryfikowany.",
	'emailcapture-invalid-code' => 'Nieprawidłowy kod potwierdzający.',
	'emailcapture-already-confirmed' => 'Twój adres e‐mail został już potwierdzony.',
	'emailcapture-response-subject' => '{{SITENAME}} – weryfikacja adresu e‐mail',
	'emailcapture-response-body' => 'Witaj!

Dziękujemy za zainteresowanie udoskonalaniem {{GRAMMAR:D.lp|{{SITENAME}}}}.

Poświęć chwilę na potwierdzenie swojego adres e‐mail – kliknij link
$1

Możesz również odwiedzić
$2

i wprowadzić kod potwierdzający
$3

Będziemy nadal współpracować, aby udoskonalić {{GRAMMAR:B.lp|{{SITENAME}}}}.

Jeśli to nie Ty spowodowałeś wysłanie tego e‐maila, wystarczy że go zignorujesz – niczego więcej do Ciebie nie wyślemy.',
	'emailcapture-success' => 'Dziękujemy!

Twój adres e‐mailowy został zweryfikowany.',
	'emailcapture-instructions' => 'Jeśli chcesz potwierdzić swój adres poczty elektronicznej, wprowadź poniżej kod, który otrzymałeś e‐mailem i kliknij „{{int:emailcapture-submit}}”.',
	'emailcapture-verify' => 'Kod weryfikacji',
	'emailcapture-submit' => 'Potwierdź adres e‐mailowy',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'emailcapture' => 'Verìfica ëd pòsta eletrònica',
	'emailcapture-desc' => "A ciapa dj'adrësse ëd pòsta eletrònica, e a përmët a j'utent ëd verificheje për pòsta eletrònica",
	'emailcapture-failure' => "Soa adrëssa ëd pòsta eletrònica a l'é '''pa''' stàita verificà.",
	'emailcapture-invalid-code' => 'Còdes ëd conferma pa bon.',
	'emailcapture-already-confirmed' => "Soa adrëssa ëd pòsta eletrònica a l'é già stàita confermà.",
	'emailcapture-response-subject' => "Verìfica dl'adrëssa postal ëd {{SITENAME}}",
	'emailcapture-response-body' => "Cerea!

Mersì për sò anteresse a giuté a amelioré {{SITENAME}}.

Për piasì, ch'a pija un moment për confirmé soa adrëssa ëd pòsta eletrònica an sgnacand an sl'anliura sì-sota:
$1

A peul ëdcò visité:
$2

E buté ël ës còdes ëd verìfica:
$3

I la contatëroma prest për coma a peul giuté a amelioré {{SITENAME}}.

Si chiel a l'ha pa ancaminà costa arcesta, për piasì ch'a lassa perde 's mëssagi e i mandëroma gnente dj'àutr.",
	'emailcapture-success' => "Mersi!

Soa adrëssa ëd pòsta eletrònica a l'é stàita verificà për da bin.",
	'emailcapture-instructions' => "Për verifiché soa adrëssa ëd pòsta eletrònica, ch'a buta ël còdes ch'a l'é staje spedì e ch'a sgnaca \"{{int:emailcapture-submit}}\".",
	'emailcapture-verify' => 'Còdes ëd verìfica:',
	'emailcapture-submit' => "Ch'a verìfica l'adrëssa ëd pòsta eletrònica",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author SandroHc
 */
$messages['pt'] = array(
	'emailcapture' => 'Verificação do correio electrónico',
	'emailcapture-desc' => 'Capturar endereços de correio electrónico e permitir que os utilizadores os verifiquem através do próprio correio electrónico',
	'emailcapture-failure' => "O seu correio electrónico '''não''' foi verificado.",
	'emailcapture-already-confirmed' => 'O teu endereço de email  já foi confirmado.',
	'emailcapture-response-subject' => 'Verificação do endereço de correio electrónico, da {{SITENAME}}',
	'emailcapture-response-body' => 'Olá!

Obrigado por expressar interesse em ajudar a melhorar a {{SITENAME}}.

Confirme o seu endereço de correio electrónico, clicando o link abaixo, por favor:
$1

Também pode visitar:
$2

E introduzir o seguinte código de confirmação:
$3

Em breve irá receber informações sobre como poderá ajudar a melhorar a {{SITENAME}}.

Se não iniciou este pedido, ignore esta mensagem e não voltará a ser contactado.',
	'emailcapture-success' => 'Obrigado!

O seu correio electrónico foi confirmado.',
	'emailcapture-instructions' => 'Para verificar o seu endereço de correio electrónico, introduza o código que lhe foi enviado por correio electrónico e clique "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Código de verificação:',
	'emailcapture-submit' => 'Verificar endereço',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Pedroca cerebral
 */
$messages['pt-br'] = array(
	'emailcapture' => 'Verificação do e-mail',
	'emailcapture-desc' => 'Capturar endereços de e-mail e permitir que os usuários os verifiquem através do próprio e-mail',
	'emailcapture-failure' => "O seu e-mail '''não''' foi verificado.",
	'emailcapture-invalid-code' => 'Código de confirmação inválido.',
	'emailcapture-already-confirmed' => 'Seu endereço de email já foi confirmado.',
	'emailcapture-response-subject' => 'Verificação do endereço de e-mail, da {{SITENAME}}',
	'emailcapture-response-body' => 'Olá!

Obrigado por expressar interesse em ajudar a melhorar a {{SITENAME}}.

Confirme o seu endereço de e-mail, clicando o link abaixo, por favor:
$1

Você também pode visitar:
$2

E introduzir o seguinte código de confirmação:
$3

Em breve irá receber informações sobre como poderá ajudar a melhorar a {{SITENAME}}.

Se você não iniciou este pedido, ignore esta mensagem e você não voltará a ser contactado.',
	'emailcapture-success' => 'Obrigado!

O seu e-mail foi confirmado.',
	'emailcapture-instructions' => 'Para verificar o seu endereço de e-mail, introduza o código que lhe foi enviado por e-mail e clique "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Código de verificação:',
	'emailcapture-submit' => 'Verificar endereço de e-mail',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author Minisarm
 */
$messages['ro'] = array(
	'emailcapture' => 'Verificarea adresei de e-mail',
	'emailcapture-failure' => "Adresa dumneavoastră de e-mail '''nu''' a fost verificată.",
	'emailcapture-response-subject' => 'Verificarea adresei de e-mail la {{SITENAME}}',
	'emailcapture-response-body' => 'Bună ziua!

Vă mulțumim pentru interesul arătat față de procesul de îmbunătățire al proiectului {{SITENAME}}.

Vă rugăm să confirmați adresa de e-mail apăsând pe legătura de mai jos:
$1

Puteți vizita de asemenea și:
$2

Și să introduceți următorul cod de confirmare:
$3

Vă vom contacta în curând în legătură cu modul în care vă puteți implica în procesul de îmbunătățire al proiectului {{SITENAME}}.

Dacă nu sunteți dumneavoastră persoana care a cerut aceste indicații, vă rugăm să ignorați acest e-mail; nu vă vom mai trimite alte mesaje.',
	'emailcapture-success' => 'Mulțumim!

Adresa dumneavoastră de e-mail a fost confirmată cu succes.',
	'emailcapture-instructions' => 'Pentru verificarea adresei de e-mail, introduceți codul care v-a fost transmis prin e-mail și apăsați „{{int:emailcapture-submit}}”.',
	'emailcapture-verify' => 'Cod de verificare:',
	'emailcapture-submit' => 'Verifică adresa de e-mail',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'emailcapture' => "Verifeche de l'e-mail",
	'emailcapture-failure' => "L'e-mail toje '''non''' g'ha state verificate.",
	'emailcapture-invalid-code' => 'Codece de conferme invalide.',
	'emailcapture-response-subject' => "Verifeche de l'indirizze email pe {{SITENAME}}",
	'emailcapture-response-body' => "Cià!

Grazie purcé è avute inderesse a dà 'na màne pe migliorà {{SITENAME}}.

Pe piacere pigghiate 'nu mumende pe confermà 'a mail toje cazzanne 'u collegamende aqquà sotte:
$1

Tu puè pure 'ndrucà:
$2

E sckaffe 'u seguende codece de conferme:
$3

Rumanime in condatte e te decime cumme ne puè dà 'na mane pe migliorà {{SITENAME}}.

Ce tu non g'è mannate sta richieste, pe piacere no sce penzanne a sta e-mail e nuje no te manname cchiù ninde.",
	'emailcapture-success' => "Grazie!

'U 'nderizze e-mail tune ha state confermate cu successe.",
	'emailcapture-verify' => 'Codece de verifeche:',
	'emailcapture-submit' => "Verifeche d'u 'ndirizze e-mail",
);

/** Russian (Русский)
 * @author Dim Grits
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'emailcapture' => 'Подтверждение адреса электронной почты',
	'emailcapture-desc' => 'Захват адреса электронной почты, разрешение участникам подтверждать себя по электронной почте',
	'emailcapture-failure' => "Ваш адрес электронной почты '''не''' был подтверждён.",
	'emailcapture-invalid-code' => 'Неверный код подтверждения.',
	'emailcapture-already-confirmed' => 'Ваш адрес электронной почты подтверждён.',
	'emailcapture-response-subject' => 'Проверка адреса электронной почты {{SITENAME}}',
	'emailcapture-response-body' => 'Здравствуйте!

Спасибо за выражение интереса к улучшению проекта {{SITENAME}}.

Пожалуйста, подтвердите свой адрес электронной почты, перейдя по ссылке:
$1

Вы также можете зайти на страницу:
$2

и ввести следующий проверочный код:
$3

Вскоре мы сообщим вам, как можно помочь в улучшении проекта {{SITENAME}}.

Если вы не отправляли подобного запроса, пожалуйста, проигнорируйте это сообщение, мы больше не будем вас тревожить.',
	'emailcapture-success' => 'Спасибо!

Ваш адрес электронной почты был подтверждён.',
	'emailcapture-instructions' => 'Для подтверждения вашего адреса электронной почты, введите код, который был вам отправлен, и нажмите кнопку «{{int:emailcapture-submit}}».',
	'emailcapture-verify' => 'Код подтверждения:',
	'emailcapture-submit' => 'Подтвердить адрес электронной почты',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'emailcapture' => 'Перевірка імейлу',
	'emailcapture-desc' => 'Уховавать імейловы адресы і уможнює хоснователям їх овірїня помочов імейлу',
	'emailcapture-failure' => "Ваш імейл '''не быв''' овіреный.",
	'emailcapture-invalid-code' => 'Код потверджіня неправилный.',
	'emailcapture-already-confirmed' => 'Ваша адреса ел. пошты уж была потверджена.',
	'emailcapture-response-subject' => 'Потверджіня адресы ел. пошты про  {{grammar:4sg|{{SITENAME}}}}',
	'emailcapture-response-body' => 'Добрый день!

Дякуєме за выядрїня інтересу помочі вылїпшыти {{grammar:4sg|{{SITENAME}}}}.

Просиме, найдьте собі минутку на потверджіня вашой імейловой адресы кликнутём на наступный одказ:

$1

Можете тыж навщівити:

$2

І задати наступный код потверджіня:

$3

Дораз ся вам озвеме з інформаціями, як можете помочі {{grammar:4sg|{{SITENAME}}}} вылїпшыти.

Кідь тота жадость не походить од вас, іґноруйте тот імейл, ніч веце вам засылати не будеме.',
	'emailcapture-success' => 'Дякуєме!',
	'emailcapture-instructions' => 'Жебы сьте овірили свою імейлову адресу, уведьте код, котрый вам пришов імейлом, і кликните на „{{int:emailcapture-submit}}“.',
	'emailcapture-verify' => 'Овірёвачій код:',
	'emailcapture-submit' => 'Овірити імейлову адресу',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'emailcapture' => 'විද්‍යුත්-තැපැල් තහවුරුකිරීම',
	'emailcapture-failure' => "ඔබේ ඊ-තැපෑල තහවුරු කොට '''නොමැත'''.",
	'emailcapture-invalid-code' => 'වලංගු නොවන තහවුරු කිරීමේ කේතය.',
	'emailcapture-already-confirmed' => 'ඔබගේ විද්‍යුත්-තැපැල් ලිපිනය දැනටමත් තහවුරුකොට ඇත.',
	'emailcapture-response-subject' => '{{SITENAME}} විද්‍යුත්-තැපැල් ලිපිනය තහවුරුකිරීම',
	'emailcapture-response-body' => 'කොහොමද!

{{SITENAME}} වැඩිදියුණු කිරීම සඳහා උපකාර කිරීමට කැමැත්ත ප්‍රකාශ කළාට ස්තුතියි.

කරුණාකර පහත දැක්වෙන සබැඳිය මත ක්ලික් කිරීම මඟින් ඔබේ විද්‍යුත් තැපැල් ලිපිනය තහවුරු කිරීම සඳහා මොහොතක් ගත කරන්න: 

$1

ඔබට මෙයටද යා හැක:

$2

ඉන්පසු පහත දැක්වෙන තහවුරු කිරීමේ කේතය යොදන්න:

$3

ඔබට {{SITENAME}} වැඩිදියුණු කල හැක්කේ කෙසේදැයි දන්වමින් අපි ඔබව විගසින් දැනුවත් කරන්නෙමු.

ඔබ විසින් මෙම අයැදුම ඇතුළත් කලේ නැතිනම්, කරුණාකර මෙම පණිවුඩය නොසලකන්න ඉන්පසු අපි ඔබට වෙන මොනවත් එවන්නේ නැහැ.',
	'emailcapture-success' => 'ස්තුතියි!

ඔබේ විද්‍යුත්-තැපැල් ලිපිනය සාර්ථකව තහවුරු කරන ලදී.',
	'emailcapture-verify' => 'තහවුරු කිරීමේ කේතය:',
	'emailcapture-submit' => 'විද්‍යුත් තැපැල් ලිපිනය තහවුරු කරන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'emailcapture' => 'Zachytenie emailovej adresy',
	'emailcapture-desc' => 'Zachytiť emailovú adresu a umožniť používateľom overenie pomocou emailu',
	'emailcapture-failure' => "Váš e-mail '''nebol''' overený.",
	'emailcapture-response-subject' => 'Potvrdenie emailovej adresy pre {{GRAMMAR:akuzatív|{{SITENAME}}}}',
	'emailcapture-response-body' => 'Overiť svoju emailovú adresu nasledovaním tohto odkazu:

$1

Môžete tiež navštíviť:
$2

a zadať nasledovný overovací kód:
$3

Ďakujeme za overenie vašej emailovej adresy.',
	'emailcapture-success' => 'Vaša emailová adresa bola úspešne overená.',
	'emailcapture-instructions' => 'Ak chcete overiť svoju emailovú adresu, zadajte kód, ktorý vám bol zaslaný emailom a kliknite na „{{int:emailcapture-submit}}“.',
	'emailcapture-verify' => 'Overovací kód:',
	'emailcapture-submit' => 'Overiť e-mailovú adresu',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'emailcapture' => 'Preverjanje e-pošte',
	'emailcapture-desc' => 'Zajame e-poštne naslove in omogoča uporabnikom, da jih preverijo preko e-pošte',
	'emailcapture-failure' => "Vaš e-poštni naslov '''ni''' bil preverjen.",
	'emailcapture-invalid-code' => 'Neveljavna potrditvena koda.',
	'emailcapture-already-confirmed' => 'Vaš e-poštni naslov je že potrjen.',
	'emailcapture-response-subject' => 'Preverjanje e-poštnega naslova {{SITENAME}}',
	'emailcapture-response-body' => 'Pozdravljeni!

Zahvaljujemo se vam za izkazano zanimanje za pomoč pri izboljševanju {{GRAMMAR:rodilnik|{{SITENAME}}}}.

Prosimo, vzemite si trenutek in potrdite vaš e-poštni naslov s klikom na spodnjo povezavo:
$1

Obiščete lahko tudi:
$2

in vnesete naslednjo potrditveno kodo:
$3

Kmalu vam bomo sporočili, kako lahko pomagate izboljšati {{GRAMMAR:tožilnik|{{SITENAME}}}}.

Če tega niste zahtevali, prosimo, prezrite to e-pošto in ničesar več vam ne bomo poslali.',
	'emailcapture-success' => 'Hvala!

Vaš e-poštni naslov je bil uspešno potrjen.',
	'emailcapture-instructions' => 'Da preverite vaš e-poštni naslov, vnesite kodo, ki ste jo prejeli po e-pošti, in kliknite »{{int:emailcapture-submit}}«.',
	'emailcapture-verify' => 'Koda za preverjanje:',
	'emailcapture-submit' => 'Preveri e-poštni naslov',
);

/** Swedish (Svenska)
 * @author Diupwijk
 * @author Lokal Profil
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'emailcapture' => 'E-postbekräftelse',
	'emailcapture-desc' => 'Samlar in e-postadresser och låter användare kontrollera dem via e-post',
	'emailcapture-failure' => "Din e-postadress blev '''inte''' bekräftad.",
	'emailcapture-invalid-code' => 'Ogiltig bekräftelsekod.',
	'emailcapture-already-confirmed' => 'Din e-postadress har redan blivit bekräftad.',
	'emailcapture-response-subject' => 'Bekräftelse av e-postadress på {{SITENAME}}',
	'emailcapture-response-body' => 'Hej!

Tack för att ha uttryckt intresse av att hjälpa till att förbättra {{SITENAME}}.

Var god ta en stund att bekräfta din e-post genom att klicka på länken nedan:
$1

Du kan också besöka:
$2

Och ange följande bekräftelsekod:
$3

Vi kommer att kontakta dig inom kort med hur du kan förbättra {{SITENAME}}.

Om du inte påbörjade denna begäran, ignorera detta e-postmeddelande och vi kommer inte skicka någonting annat.',
	'emailcapture-success' => 'Tack!

Din e-post har bekräftats.',
	'emailcapture-instructions' => 'För att bekräfta din e-postadress, ange koden som du fick per e-post och klicka på "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Verifieringskod:',
	'emailcapture-submit' => 'Verifiera e-postadress',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'emailcapture' => 'ఈమెయిలు ధృవీకరణ',
	'emailcapture-desc' => 'ఈమెయిలు అడ్రసుల్ని సేకరించి, వాడుకరులు వాటిని ఈమెయిలు ద్వారా ధృవీకరించే వీలు కల్పించు',
	'emailcapture-failure' => 'మీ ఈమెయిలు ధృవీకరణ ’’’కాలేదు’’’.',
	'emailcapture-response-subject' => '{{SITENAME}} ఈ-మెయిలు చిరునామా తనిఖీ',
	'emailcapture-response-body' => 'కింది లింకుకు వెళ్ళి మీ ఈమెయిలు అడ్రసును ధృవీకరించండి:
$1

లేదా మీరు కింది లింకుకు వెళ్ళి:
$2

కింది ధృవీకరణ కోడును ఇవ్వవచ్చు:
$3

మీ ఈమెయిలు అడ్రసును ధృవీకరించినందుకు నెనరులు.',
	'emailcapture-success' => 'ధన్యవాదాలు!

మీ ఈమెయిలు చిరునామా నిర్ధారితమైంది.',
	'emailcapture-instructions' => 'మీ ఈమెయిలు అడ్రసును ధృవీకరించేందుకు, మీ ఈమెయిలైడీకి పంపించిన కోడును ఇచ్చి, "{{int:emailcapture-submit}}" ను నొక్కండి.',
	'emailcapture-verify' => 'తనిఖీ సంకేతం:',
	'emailcapture-submit' => 'ఈమెయిలు అడ్రసును ధృవీకరించు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'emailcapture' => 'Pagpapatunay ng e-liham',
	'emailcapture-desc' => 'Hulihin ang mga tirahan ng e-liham, at payagan ang mga tagagamit na patunayan sila sa pamamagitan ng e-liham',
	'emailcapture-failure' => "'''Hindi''' pa napapatunayan ang e-liham mo.",
	'emailcapture-response-subject' => 'Pagpapatunay ng E-liham ng {{SITENAME}}',
	'emailcapture-response-body' => 'Upang mapatunayang ang tirahan mo ng e-liham, sundan ang kawing na ito:
$1

Maaari mo ring dalawin ang:
$2
at ipasok ang sumusundo na kodigo ng pagpapatunay:
$3

Salamat sa pagpapatotoo ng tirahan mo ng e-liham.',
	'emailcapture-success' => 'Salamat!

Matagumpay na natiyak ang e-liham mo.',
	'emailcapture-instructions' => 'Upang mapatunayan ang tirahan mo ng e-liham, ipasok ang kodigong ipinadala sa iyo sa pamamagitan ng e-liham at pindutin ang "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Kodigo ng pagpapatotoo:',
	'emailcapture-submit' => 'Patunayan ang tirahan ng e-liham',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'emailcapture-invalid-code' => 'Geçersiz onay kodu.',
	'emailcapture-success' => 'Teşekkür ederiz!

E-posta başarıyla onaylamıştır.',
	'emailcapture-verify' => 'Doğrulama kodu:',
	'emailcapture-submit' => 'E-posta adresini doğrulayın.',
);

/** Ukrainian (Українська)
 * @author Dim Grits
 */
$messages['uk'] = array(
	'emailcapture' => 'Перевірка адреси електронної пошти',
	'emailcapture-desc' => 'Перехоплення адреси електронної пошти, дозвіл користувачам підтверджувати себе електронною поштою',
	'emailcapture-failure' => "Ваша електронна адреса '''не була''' перевірена.",
	'emailcapture-invalid-code' => 'Код підтвердження невірний.',
	'emailcapture-already-confirmed' => 'Ваша адреса електронної пошти вже підтверджена.',
	'emailcapture-response-subject' => 'Перевірка адреси електронної пошти {{SITENAME}}',
	'emailcapture-response-body' => 'Привіт! 
Дякуємо за виявлений інтерес щодо поліпшення {{SITENAME}}.

Будь ласка, знайдіть хвилинку часу, щоб підтвердити адресу електронної пошти, натиснувши на посилання нижче:
$1

Ви також можете відвідати: 
$2

і ввести наступний код підтвердження:
$3

Ми повідомимо вам як ви можете допомогти поліпшити {{SITENAME}}.

Якщо ви не відправляли цей запит, не звертайте уваги на цей лист, і ми не потурбуємо вас більше.
З найкращими побажаннями, команда {{SITENAME}}.',
	'emailcapture-success' => 'Дякуємо!
Ви підтвердили адресу власної електронної пошти.',
	'emailcapture-instructions' => 'Щоб підтвердити адресу електронної пошти, введіть код надісланий вам електронним листом і натисніть кнопку "{{int:emailcapture-submit}}".',
	'emailcapture-verify' => 'Код підтвердження:',
	'emailcapture-submit' => 'Підтвердити адресу електронної пошти',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'emailcapture' => 'Xác minh địa chỉ thư điện tử',
	'emailcapture-desc' => 'Bắt các địa chỉ thư điện tử và cho phép người dùng xác minh chúng qua thư điện tử',
	'emailcapture-failure' => "Địa chỉ thư điện tử của bạn '''chưa''' được xác minh.",
	'emailcapture-invalid-code' => 'Mã xác nhận không hợp lệ.',
	'emailcapture-already-confirmed' => 'Địa chỉ thư điện tử của bạn đã được xác nhận trước đây.',
	'emailcapture-response-subject' => 'Xác minh địa chỉ thư điện tử tại {{SITENAME}}',
	'emailcapture-response-body' => 'Xin chào!

Cám ơn bạn đã bày tỏ quan tâm về việc giúp cải tiến {{SITENAME}}.

Xin vui lòng xác nhận địa chỉ thư điện tử của bạn qua liên kết này:
$1

Bạn cũng có thể ghé thăm:
$2

và nhập mã xác minh sau:
$3

Chúng tôi sẽ sớm liên lạc với bạn với thông tin về giúp cải tiến {{SITENAME}}.

Nếu bạn không phải là người yêu cầu thông tin này, xin vui lòng kệ thông điệp này và chúng tôi sẽ không gửi cho bạn bất cứ gì nữa.',
	'emailcapture-success' => 'Cám ơn!

Địa chỉ thư điện tử của bạn đã được xác minh thành công.',
	'emailcapture-instructions' => 'Để xác minh địa chỉ thư điện tử của bạn, hãy nhập mã trong thư điện tử đã được gửi cho bạn và bấm nút “{{int:emailcapture-submit}}”.',
	'emailcapture-verify' => 'Mã xác minh:',
	'emailcapture-submit' => 'Xác minh địa chỉ thư điện tử',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Hydra
 * @author PhiLiP
 * @author 阿pp
 */
$messages['zh-hans'] = array(
	'emailcapture' => '电子邮件验证',
	'emailcapture-desc' => '捕获电子邮件地址，并允许用户通过电子邮件确认他们',
	'emailcapture-failure' => "您的电子邮件'''不'''是已验证。",
	'emailcapture-invalid-code' => '验证码无效。',
	'emailcapture-already-confirmed' => '您的电子邮箱地址已得到确认。',
	'emailcapture-response-subject' => '{{SITENAME}}邮箱地址确认',
	'emailcapture-response-body' => '您好！

谢谢您表示愿意帮助我们改善{{SITENAME}}。

请花一点时间，点击下面的链接来确认您的电子邮件：

$1

您还可以访问：

$2

然后输入下列确认码：

$3

我们会在短期内联系您，并向您介绍帮助我们改善{{SITENAME}}的方式。

如果这项请求并非由您发起，请忽略这封电子邮件，我们不会再向您发送任何邮件。',
	'emailcapture-success' => '谢谢！

您的电子邮件已成功地确认。',
	'emailcapture-instructions' => '输入邮件的标明的验证码并点击"{{int:emailcapture-submit}}"以验证您的邮箱地址。',
	'emailcapture-verify' => '验证码：',
	'emailcapture-submit' => '验证电子邮件地址',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'emailcapture' => '電子郵件驗證',
	'emailcapture-desc' => '捕獲電子郵件地址，並允許用戶通過電子郵件確認他們',
	'emailcapture-failure' => "您的電子郵件'''尚未'''驗證。",
	'emailcapture-invalid-code' => '確認碼無效。',
	'emailcapture-already-confirmed' => '你的電郵地址已經確認了。',
	'emailcapture-response-subject' => '{{SITENAME}}郵箱地址確認',
	'emailcapture-response-body' => '您好！

謝謝您表示願意幫助我們改善{{SITENAME}}。

請花一點時間，點擊下面的鏈接來確認您的電子郵件：

$1

您還可以訪問：

$2

然後輸入下列確認碼：

$3

我們會在短期內聯繫您，並向您介紹幫助我們改善{{SITENAME}}的方式。

如果這項請求並非由您發起，請忽略這封電子郵件，我們不會再向您發送任何郵件。',
	'emailcapture-success' => '謝謝！

您的電子郵件已成功地確認。',
	'emailcapture-instructions' => '為了驗證您的郵箱地址，輸入郵件的標明的驗證碼，然後點擊"{{int:emailcapture-submit}}"。',
	'emailcapture-verify' => '驗證碼：',
	'emailcapture-submit' => '驗證電子郵件地址',
);

