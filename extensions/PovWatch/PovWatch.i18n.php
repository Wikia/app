<?php
/**
 * Internationalisation file for extension PovWatch.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'povwatch'                         => 'PovWatch',
	'povwatch_desc'                    => 'Extension for [[Special:PovWatch|pushing pages on to the watchlists]] of other users',
	'povwatch_no_session'              => 'Error: Could not submit form due to a loss of session data.',
	'povwatch_not_allowed_push'        => 'You are not a PovWatch admin, you cannot push pages to watchlists.',
	'povwatch_already_subscribed'      => 'You are already subscribed to PovWatch',
	'povwatch_subscribed'              => 'You are now subscribed to PovWatch',
	'povwatch_not_subscribed'          => 'You are not subscribed to PovWatch, so you cannot unsubscribe.',
	'povwatch_unsubscribed'            => 'You have now unsubscribed from PovWatch',
	'povwatch_invalid_title'           => 'The title specified was invalid',
	'povwatch_pushed'                  => '[[$1]] has successfully been pushed to $2 user watchlist(s)',
	'povwatch_intro'                   => 'PovWatch is a service which allows contentious pages to be discreetly pushed on to the watchlists of subscribing administrators.

A log of recent watchlist pushes is available at [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'A [[Special:PovWatch/subscribers|list of subscribers]] is available.',
	'povwatch_subscriber_list_intro'   => '<strong>Subscriber list</strong>',
	'povwatch_not_allowed_subscribers' => 'You are not allowed to view the PovWatch subscriber list.',
	'povwatch_unknown_subpage'         => 'Unknown subpage.',
	'povwatch_push'                    => 'Push',
	'povwatch_push_intro'              => 'Use the form below to push pages on to the watchlists of subscribing users.
Please be careful typing the title: even non-existent titles can be added, and there is no way to remove a title once it has been pushed out.',
	'povwatch_title'                   => 'Title:',
	'povwatch_comment'                 => 'Log comment:',
	'povwatch_no_log'                  => 'There are no log entries.',
	'povwatch_no_subscribers'          => 'There are no subscribers.',
	'povwatch_unsubscribe_intro'       => 'You are subscribed to PovWatch.
Click the button below to unsubscribe.',
	'povwatch_unsubscribe'             => 'Unsubscribe',
	'povwatch_subscribe_intro'         => 'You are not subscribed to PovWatch.
Click the button below to subscribe.',
	'povwatch_subscribe'               => 'Subscribe',
	'povwatch_added'                   => 'added',
	'right-povwatch_admin'             => 'Administer user rights for adding pages to watchlists of other users',
	'right-povwatch_user'              => 'Add pages to watchlists of other users',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 */
$messages['af'] = array(
	'povwatch_title' => 'Titel:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'povwatch'                         => 'مراقبة بي أو في',
	'povwatch_desc'                    => 'امتداد [[Special:PovWatch|لدفع الصفحات إلى قوائم مراقبة]] المستخدمين الآخرين',
	'povwatch_no_session'              => 'خطأ: لم يمكن تنفيذ الاستمارة نتيجة فقد في بيانات الجلسة.',
	'povwatch_not_allowed_push'        => 'أنت لست إداري مراقبة بي أو في، لا يمكنك دفع صفحات إلى قوائم مراقبة.',
	'povwatch_already_subscribed'      => 'أنت مشترك بالفعل في مراقبة بي أو في',
	'povwatch_subscribed'              => 'أنت الآن مشترك في مراقبة بي أو في',
	'povwatch_not_subscribed'          => 'أنت غير مشترك في مراقبة بي أو في، لذا فلا يمكنك إلغاء الاشتراك.',
	'povwatch_unsubscribed'            => 'أنت الآن ألغيت الاشتراك في مراقبة بي أو في',
	'povwatch_invalid_title'           => 'العنوان المحدد كان غير صحيح',
	'povwatch_pushed'                  => '[[$1]] تم دفعها بنجاح إلى $2 قائمة مراقبة مستخدم',
	'povwatch_intro'                   => 'مراقبة بي أو في هي خدمة تسمح بإضافة صفحات معينة إلى قوائم مراقبة الإداريين المشتركين.

السجل بعمليات دفع قوائم المراقبة الحديثة متوفر في [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => '[[Special:PovWatch/subscribers|قائمة المشتركين]] متوفرة.',
	'povwatch_subscriber_list_intro'   => '<strong>قائمة المشتركين</strong>',
	'povwatch_not_allowed_subscribers' => 'أنت غير مسموح لك برؤية قائمة المشتركين في مراقبة بي أو في.',
	'povwatch_unknown_subpage'         => 'صفحة فرعية غير معروفة.',
	'povwatch_push'                    => 'دفع',
	'povwatch_push_intro'              => 'استخدم الاستمارة بالأسفل لدفع صفحات إلى قوائم مراقبة المستخدمين المشتركين. من فضلك كن حذرا عند كتابة العنوان: حتى العناوين غير الموجودة يمكن إضافتها، ولا توجد طريقة لإزالة عنوان ما متى تم دفعه.',
	'povwatch_title'                   => 'العنوان:',
	'povwatch_comment'                 => 'تعليق السجل',
	'povwatch_no_log'                  => 'لا توجد مدخلات سجل.',
	'povwatch_no_subscribers'          => 'لا يوجد مشتركون.',
	'povwatch_unsubscribe_intro'       => 'أنت مشترك في مراقبة بي أو في. اضغط الزر بالأسفل لإلغاء الاشتراك.',
	'povwatch_unsubscribe'             => 'إنهاء الاشتراك',
	'povwatch_subscribe_intro'         => 'أنت غير مشترك في مراقبة بي أو في. اضغط الزر بالأسفل للاشتراك.',
	'povwatch_subscribe'               => 'اشتراك',
	'povwatch_added'                   => 'تمت الإضافة',
	'right-povwatch_user'              => 'إضافة صفحات إلى قوائم مراقبة مستخدمين آخرين',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'povwatch_desc'                    => 'Разширение за [[Special:PovWatch|добавяне на страници в списъка за наблюдение]] на други потребители',
	'povwatch_no_session'              => 'Грешка: Формулярът не може да бъде изпратен заради загуба на данни от сесията.',
	'povwatch_not_allowed_push'        => 'Вие не сте PovWatch администратор, затова не можете да включвате страници в списъците за наблюдение.',
	'povwatch_already_subscribed'      => 'Вече сте се записал/а за PovWatch',
	'povwatch_subscribed'              => 'Сега сте записан/а за PovWatch',
	'povwatch_not_subscribed'          => 'Не сте записан/а за PovWatch, затова не можете да се отпишете.',
	'povwatch_unsubscribed'            => 'Сега сте отписан/а от PovWatch',
	'povwatch_invalid_title'           => 'Посоченото заглавие е невалидно',
	'povwatch_pushed'                  => '[[$1]] беше успешно добавена в списъка за наблюдение на $2',
	'povwatch_subscriber_list'         => 'Наличен е [[Special:PovWatch/subscribers|списък със записани]].',
	'povwatch_subscriber_list_intro'   => '<strong>Списък на абонираните</strong>',
	'povwatch_not_allowed_subscribers' => 'Нямате права да преглеждате списъка със записани за PovWatch.',
	'povwatch_unknown_subpage'         => 'Непозната подстраница.',
	'povwatch_title'                   => 'Заглавие:',
	'povwatch_no_log'                  => 'Дневникът не съдържа записи.',
	'povwatch_no_subscribers'          => 'Няма записани потребители.',
	'povwatch_unsubscribe_intro'       => 'Имате абонамент за PovWatch.
Натиснете бутона по-долу за отписване.',
	'povwatch_unsubscribe'             => 'Отписване',
	'povwatch_subscribe_intro'         => 'Нямате абонамент за PovWatch.
Натиснете бутона за абониране.',
	'povwatch_subscribe'               => 'Записване',
	'right-povwatch_admin'             => 'Администриране на потребителските права за добавяне на страници в списъка за наблюдение на другите потребители',
	'right-povwatch_user'              => 'добавяне на страници в списъка за наблюдение на други потребители',
);

/** Catalan (Català)
 * @author Jordi Roqué
 */
$messages['ca'] = array(
	'povwatch_title' => 'Títol:',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'povwatch_title' => 'Titel:',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'povwatch'                         => 'PovWatch',
	'povwatch_desc'                    => 'Erweiterung, um [[Special:PovWatch|Seiten auf die Beobachtungsliste]] anderer Benutzer hinzuzufügen',
	'povwatch_no_session'              => 'Fehler: Formulardaten können nicht verarbeitet werden, da die Sizungsdaten verloren gegangen sind.',
	'povwatch_not_allowed_push'        => 'Du bist kein PovWatch-Administrator und kannst fremden Beobachtungslisten keine Seiten hinzufügen.',
	'povwatch_already_subscribed'      => 'Du bist bereits für PovWatch registriert',
	'povwatch_subscribed'              => 'Du bist nun für PovWatch registriert',
	'povwatch_not_subscribed'          => 'Du bist nicht für PovWatch registriert; eine Abmeldung ist daher nicht möglich.',
	'povwatch_unsubscribed'            => 'Du bist nun von PovWatch abgemeldet',
	'povwatch_invalid_title'           => 'Der angegebene Seitenname ist ungültig',
	'povwatch_pushed'                  => '[[$1]] wurde erfolgreich der Beobachtungsliste von $2 hinzugefügt.',
	'povwatch_intro'                   => 'PovWatch ist ein Service, um umstrittene Seiten diskret den Beobachtungslisten von registrierten Administratoren hinzuzufügen.

Ein Logbuch der über mittels PovWatch hinzugefügten Seiten ist verfügbar unter [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'Eine [[Special:PovWatch/subscribers|Liste der registrierten Benutzer]] ist verfügbar.',
	'povwatch_subscriber_list_intro'   => '<strong>Liste der registrierten Benutzer</strong>',
	'povwatch_not_allowed_subscribers' => 'Du hast keine Berechtigung, die PovWatch-Benutzerliste einzusehen.',
	'povwatch_unknown_subpage'         => 'Unbekannte Unterseite',
	'povwatch_push'                    => 'Hinzufügen',
	'povwatch_push_intro'              => 'Benutze das Formular, um Seiten den Beobachtungslisten der registrierten Benutzer hinzuzufügen.
	Bitte beachte: auch nicht vorhandene Seiten können hinzugefügt werde und es gibt keinen Weg, dies rückgängig zu machen.',
	'povwatch_title'                   => 'Seitenname:',
	'povwatch_comment'                 => 'Logbuch-Kommentar:',
	'povwatch_no_log'                  => 'Das Logbuch enthält keine Einträge.',
	'povwatch_no_subscribers'          => 'Es gibt keine registrierten Benutzer.',
	'povwatch_unsubscribe_intro'       => 'Du bist für PovWatch registriert. Klicke auf die Schaltfläche, um dich abzumelden.',
	'povwatch_unsubscribe'             => 'Abmelden',
	'povwatch_subscribe_intro'         => 'Du bist nicht für PovWatch registriert. Klicke auf die Schaltfläche, um dich anzumelden.',
	'povwatch_subscribe'               => 'Registrieren',
	'povwatch_added'                   => 'hinzugefügt',
	'right-povwatch_admin'             => 'Administriere Benutzerrechte zur Hinzufügung von Seiten zur Beobachtungsliste anderer Benutzer',
	'right-povwatch_user'              => 'Hinzufügen von Seiten zur Beobachtungsliste anderer Benutzer',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'povwatch_title' => 'Τίτλος:',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'povwatch_invalid_title'   => 'La enigita titolo estis nevalida',
	'povwatch_unknown_subpage' => 'Nekonata subpaĝo.',
	'povwatch_title'           => 'Titolo:',
	'povwatch_comment'         => 'Komento por protokolo:',
	'povwatch_added'           => 'aldonita',
);

/** French (Français)
 * @author Urhixidur
 * @author Grondin
 */
$messages['fr'] = array(
	'povwatch'                         => 'Surveillance des guerres d’éditions',
	'povwatch_desc'                    => 'Extension permettant d’[[Special:PovWatch|ajouter des pages à la liste de suivi]] d’autres utilisateurs',
	'povwatch_no_session'              => 'Erreur : Impossible de soumettre le formulaire à la suite de la perte des données de la session.',
	'povwatch_not_allowed_push'        => 'Vous n’êtes pas un administrateur pour la surveillance des guerres d’édition. Vous ne pouvez pas ajouter les articles dans la liste correspondante.',
	'povwatch_already_subscribed'      => 'Vous êtes déjà inscrit pour la surveillance des guerres d’édition.',
	'povwatch_subscribed'              => 'Vous êtes maintenant inscrit pour la surveillance des guerres d’édition.',
	'povwatch_not_subscribed'          => 'Vous n’êtes pas inscrit pour la surveillance des guerres d’édition. Par conséquent, vous ne pouvez pas résilier d’inscription.',
	'povwatch_unsubscribed'            => 'Votre inscription pour la surveillance des guerres d’édition est maintenant résiliée.',
	'povwatch_invalid_title'           => 'Le titre indiqué est invalide.',
	'povwatch_pushed'                  => '[[$1]] a été inscrite avec succès dans la liste de surveillance de l’utilisateur $2.',
	'povwatch_intro'                   => 'La surveillance des guerres d’édition est un service qui autorise la surveillance discrète des articles conflictuels. Ceux-ci peuvent être inscrits dans la liste de surveillance des administrateurs enregistrés.

Un journal de surveillance des articles inscrits est disponible sur [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'Une [[Special:PovWatch/subscribers|liste des abonnés]] est disponible.',
	'povwatch_subscriber_list_intro'   => '<strong>Liste des abonnés</strong>',
	'povwatch_not_allowed_subscribers' => 'Vous n’avez pas la permission de visionner la liste des personnes inscrites pour la surveillance des guerres d’édition.',
	'povwatch_unknown_subpage'         => 'Sous-page inconnue.',
	'povwatch_push'                    => 'Inscrire',
	'povwatch_push_intro'              => 'Utilisez le formulaire ci-dessous pour inscrire les articles dans la liste de suivi affectée aux utilisateurs abonnés. Inscrivez scrupuleusement le titre : un article inexistant peut être spécifié, et il n’existe aucun moyen de retirer un titre une fois inscrit.',
	'povwatch_title'                   => 'Titre :',
	'povwatch_comment'                 => 'Commentaire du journal :',
	'povwatch_no_log'                  => 'Il n’existe aucune entrée dans le journal.',
	'povwatch_no_subscribers'          => 'Il n’existe aucune personne abonnée.',
	'povwatch_unsubscribe_intro'       => 'Vous êtes inscrit à la liste de surveillance des guerres d’édition. Cliquez sur le bouton ci-dessous pour vous désinscrire.',
	'povwatch_unsubscribe'             => 'Résilier',
	'povwatch_subscribe_intro'         => 'Vous n’êtes pas inscrit sur la liste de surveillance des guerres d’édition. Cliquez sur le bouton ci-dessous pour vous inscrire.',
	'povwatch_subscribe'               => 'Souscrire',
	'povwatch_added'                   => 'ajouté',
	'right-povwatch_admin'             => "Administrer les droits d’utilisateur pour l'ajout des pages à la liste de suivi des autres utilisateurs.",
	'right-povwatch_user'              => 'Ajoute des pages à la liste de suivi des autres utilisateurs',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'povwatch'                         => 'PovWatch',
	'povwatch_desc'                    => 'Extensión para [[Special:PovWatch|empurrar páxinas á listaxe de vixilancia]] doutros usuarios',
	'povwatch_no_session'              => 'Erro: non se pode enviar o formulario debido a unha perda dos datos de inicio da sesión.',
	'povwatch_not_allowed_push'        => 'Non é un administrador PovWatch, non pode empurrar páxinas ás listaxes de vixilancia doutros.',
	'povwatch_already_subscribed'      => 'Vostede está aínda subscrito a PovWatch',
	'povwatch_subscribed'              => 'Vostede está agora subscrito a PovWatch',
	'povwatch_not_subscribed'          => 'Non ten unha subscrición a PovWatch, polo que non a pode cancelar.',
	'povwatch_unsubscribed'            => 'Cancelouse a súa subscrición a PovWatch',
	'povwatch_invalid_title'           => 'O título especificado foi non válido',
	'povwatch_pushed'                  => '"[[$1]]" foi engadida con éxito á(s) páxinas(s) de vixilancia de $2',
	'povwatch_intro'                   => 'PovWatch é un servizo que permite que páxinas polémicas sexan "empurradas" discretamente ás listaxes de vixilancia dos adminitradores subscritos.

un rexistro dos "empurróns" ás listaxes de vixilancia recentes está dispoñible en [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'Unha [[Special:PovWatch/subscribers|listaxe de subscritores]] está dispoñíbel.',
	'povwatch_subscriber_list_intro'   => '<strong>Listaxe dos subscritores</strong>',
	'povwatch_not_allowed_subscribers' => 'Non ten permiso para ver a listaxe de subscrición de PovWatch.',
	'povwatch_unknown_subpage'         => 'Subpáxina descoñecida.',
	'povwatch_push'                    => 'Empurrar',
	'povwatch_push_intro'              => 'Use o formulario de embaixo para "empurrar" páxinas ás listaxes de vixilancia dos usuarios subscritos.
Por favor, sexa coidadoso ao teclear o título: incluso os títulos non existentes poden ser engadidos e non hai forma de eliminar un título unha vez que este foi "empurrado".',
	'povwatch_title'                   => 'Título:',
	'povwatch_comment'                 => 'Rexistro de comentarios:',
	'povwatch_no_log'                  => 'Non hai entradas no rexistro.',
	'povwatch_no_subscribers'          => 'Non hai subscritores.',
	'povwatch_unsubscribe_intro'       => 'Está subscrito a PovWatch.
Faga clic no botón de embaixo para cancelar a subscrición.',
	'povwatch_unsubscribe'             => 'Darse de baixa',
	'povwatch_subscribe_intro'         => 'Non está subscrito a PovWatch.
Faga clic no botón de embaixo para subscribirse.',
	'povwatch_subscribe'               => 'Subscribir',
	'povwatch_added'                   => 'engadido',
	'right-povwatch_admin'             => 'Administrar os dereitos de usuario para engadir páxinas ás listaxes de vixilancia doutros usuarios',
	'right-povwatch_user'              => 'Engadir páxinas á listaxe de vixilancia doutros usuarios',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'povwatch_title' => 'Ard-ennym:',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'povwatch'                       => 'पीओव्हीवॉच',
	'povwatch_already_subscribed'    => 'आप पहलेसे पीओव्हीवॉचके सदस्य हैं',
	'povwatch_subscribed'            => 'आप अब पीओव्हीवॉचके सदस्य बन गये हैं',
	'povwatch_invalid_title'         => 'दिया हुआ शीर्षक अवैध हैं',
	'povwatch_subscriber_list_intro' => '<strong>सदस्य सूची</strong>',
	'povwatch_unknown_subpage'       => 'अज्ञात उपपृष्ठ।',
	'povwatch_push'                  => 'घुसायें',
	'povwatch_title'                 => 'शीर्षक:',
	'povwatch_comment'               => 'टिप्पणी दें:',
	'povwatch_no_log'                => 'सूची में एन्ट्री नहीं हैं।',
	'povwatch_no_subscribers'        => 'सदस्य नहीं हैं।',
	'povwatch_unsubscribe'           => 'सदस्यत्व निकालें',
	'povwatch_subscribe'             => 'सदस्यत्व लें',
	'povwatch_added'                 => 'बढाया',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'povwatch_desc'                    => 'Rozšěrjenje za [[Special:PovWatch|zasunjenje stronow do wobkedźbowankow]] druhich wužiwarjow',
	'povwatch_no_session'              => 'Zmylk: Formular njeda so straty datow dla wotesłać.',
	'povwatch_not_allowed_push'        => 'Njejsy administrator za PovWatch, njemóžeš nastawki do wobkedźbowankow sunyć.',
	'povwatch_already_subscribed'      => 'Sy PovWatch hižo abonował',
	'povwatch_subscribed'              => 'Sy nětko PovWatch abonował',
	'povwatch_not_subscribed'          => 'Njejsy PovWatch abonował, tohodla njemóžeš jón wotskazać.',
	'povwatch_unsubscribed'            => 'Sy nětko PovWatch wotskazał',
	'povwatch_invalid_title'           => 'Podaty titul je njepłaćiwy',
	'povwatch_pushed'                  => '[[$1]] bu wuspěšnje do wobkedźbowankow wužiwarja $2 sunjeny.',
	'povwatch_intro'                   => 'PovWatch je słužba, kotraž dowola zwadne nastawki diskretnje do wobkedźbowankow abonowacych administratorow sunyć.

Protokol aktualnych wobkedźbowankow steji na [[Special:PovWatch/log]] k dispoziciji.',
	'povwatch_subscriber_list'         => '[[Special:PovWatch/subscribers|Lisćina abonentow]] steji k dispoziciji.',
	'povwatch_subscriber_list_intro'   => '<strong>Lisćina abonentow</strong>',
	'povwatch_not_allowed_subscribers' => 'Nimaš dowolnosć sej lisćinu abonentow PovWatch wobhladać.',
	'povwatch_unknown_subpage'         => 'Njeznata podstrona.',
	'povwatch_push'                    => 'Sunyć',
	'povwatch_push_intro'              => 'Wužij formular deleka, zo by nastawki do wobkedźbowankow abonowacych wužiwarjow sunył. Prošu bjer na kedźbu z pisanjom titula: samo njeeksistowace titule hodźa so přidać a njeje žana móžnosć titul wotstronić, kotryž bu přesunjeny.',
	'povwatch_title'                   => 'Titul:',
	'povwatch_comment'                 => 'Komentar protokolować:',
	'povwatch_no_log'                  => 'Protokolowe zapiski njejsu.',
	'povwatch_no_subscribers'          => 'Abonenća njejsu.',
	'povwatch_unsubscribe_intro'       => 'Sy PovWatch abonował. Klikń na tłóčatko deleka, zo by jón wotskazał.',
	'povwatch_unsubscribe'             => 'Wotskazać',
	'povwatch_subscribe_intro'         => 'Njejsy PovWatch abonował. Klikń na tłóčatko deleka, zo by jón abonował.',
	'povwatch_subscribe'               => 'Abonować',
	'povwatch_added'                   => 'přidaty',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'povwatch_title' => 'Cím:',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'povwatch_comment' => 'Commento pro registro:',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'povwatch_unknown_subpage' => 'Subkaca ora dimangertèni',
	'povwatch_push'            => 'Surung',
	'povwatch_title'           => 'Irah-irahan (judhul):',
	'povwatch_comment'         => 'Komentar log:',
	'povwatch_no_log'          => 'Ora ana èntri-èntri log',
	'povwatch_no_subscribers'  => 'Ora ana palanggané.',
	'povwatch_unsubscribe'     => 'Batal langganan',
	'povwatch_subscribe'       => 'Langganan',
	'povwatch_added'           => 'ditambah',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 */
$messages['km'] = array(
	'povwatch_title' => 'ចំណងជើង៖',
	'povwatch_added' => 'បានបន្ថែម',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'povwatch'                         => 'Iwwerwaachung vun Ännerungskonflikter',
	'povwatch_desc'                    => "Erweiderung fir [[Special:PovWatch|Säiten op d'Iwwerwwaachungslëscht]] vun anere Benotzer derbäizesetzen",
	'povwatch_no_session'              => "Feeler: De Formulaire konnt net verschafft ginn well d'Informatioune vun ärer Sessioun verluer gaang sinn.",
	'povwatch_not_allowed_push'        => "Dir sidd keen Administrateur fir d'Iwwerwaache vun Ännerungskonflikten (POV Watch). Dir kënnt keng Säiten op d'Iwwerwaachungslëschte vun anere Benotzer derbäisetzen.",
	'povwatch_already_subscribed'      => "Dir sidd scho fir d'Iwwerwwache vun Ännerungskonflikter ageschriwwen.",
	'povwatch_subscribed'              => "Dir sidd elo fir d'Iwwerwaache vun Ännerungskonflikter ageschriwwen.",
	'povwatch_not_subscribed'          => "Dir sidd net ageschriwwen fir Ännerungskonflikter z'iwwerwwachen. Dofir kënnt Dir iech och net ofmelden.",
	'povwatch_unsubscribed'            => "Dir hutt iech elo ofgemeld fir Ännerungskonflikter z'iwwerwaachen.",
	'povwatch_invalid_title'           => 'Den Titel deen Dir uginn hutt ass ongëlteg.',
	'povwatch_pushed'                  => '[[$1]] gouf op Iwwerwwachungslëscht(en) vum Bentzer $2 derbäigesat',
	'povwatch_intro'                   => "D'Iwwerwaache vun Ännerungskonflikten (PovWatch) erlaabt et fir ëmstridde Säiten diskret op d'Iwwerwaachungslëscht vun ageschriwwenen Administrateuren ze setzen.

Eng Lëscht vun de Säiten déi rezent ageschriwwe goufen ass [[Special:PovWatch/log|hei disponibel]].",
	'povwatch_subscriber_list'         => "D'[[Special:PovWatch/subscribers|Lëscht vun den ageschriwwene Benotzer fannt Dir hei]].",
	'povwatch_subscriber_list_intro'   => '<strong>Lëscht vun den ageschriwwene Benotzer</strong>',
	'povwatch_not_allowed_subscribers' => "Dir sidd net berechtegt fir d'Lëscht vun dene Benotzer ze gesinn déi ageschriwwe sinn fir Ännerungskonflikter z'iwwerwaachen.",
	'povwatch_unknown_subpage'         => 'Onbekannten Ënnersäit.',
	'povwatch_push'                    => 'Derbäisetzen',
	'povwatch_push_intro'              => "Benotzt de Formulaire ënnendrënner fir Säiten op d'Iwwerwaachungslëschte vun ageschriwwene Benotzer derbäizesetzen.

Sidd w.e.g. virsichteg wann Dir den Titel tippt: esouguer Säiten déi et net gëtt kënnen derbäigesat ginn, an et ass net méiglech den Titel nees ewechzehuelen wann et bis eemol derbäigesat gouf.",
	'povwatch_title'                   => 'Titel:',
	'povwatch_comment'                 => "Bemierkung (fir d'Logbicher/Lëschten):",
	'povwatch_no_log'                  => 'Dës Lëscht ass eidel.',
	'povwatch_no_subscribers'          => 'Et gëtt keng Benotzer déi sech ageschriwwen hunn.',
	'povwatch_unsubscribe_intro'       => "Dir sidd elo fir d'Iwwerwaache vun Ännerungskonflikter ageschriwwen.

Klickt the Knäppchen hei ënnendrënner fir iech ofzemelden.",
	'povwatch_unsubscribe'             => 'Ofmelden',
	'povwatch_subscribe_intro'         => "Dir sidd net ageschriwwen fir Ännerungskonflikter z'iwwerwaachen.

Klickt op de Knäppchen hei ënnendrënner fir iech anzeschreiwen.",
	'povwatch_subscribe'               => 'Aschreiwen',
	'povwatch_added'                   => 'derbäigesat',
	'right-povwatch_user'              => 'Säiten op Iwwerwaachungslëschte vun anere Benotzer derbäisetzen',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 * @author Tibor
 */
$messages['li'] = array(
	'povwatch'                         => 'POV-Beloer',
	'povwatch_no_session'              => "Fout: 't formeleer kós neet verwèrk waere ómdet de sessiegegaeves verlaore zeen gegange.",
	'povwatch_not_allowed_push'        => "De bis geine administrator van PovWatch en kèns gein pazjena's op volglieste zètte.",
	'povwatch_already_subscribed'      => 'Doe bös al geabonneertdj op POV-Beloer',
	'povwatch_subscribed'              => 'Doe bös noe geabonneerdj op POV-Beloer',
	'povwatch_not_subscribed'          => 'De bis neet geabonneerd op PovWatch, dus de kèns neet oetsjrieve.',
	'povwatch_unsubscribed'            => 'Doe bös oetgesjreve van POV-Beloer',
	'povwatch_invalid_title'           => 'De opgegaeve pazjenanaam is óngeljig',
	'povwatch_pushed'                  => '[[$1]] is succesvol toegeweze aan $2 volglies van gebroekers.',
	'povwatch_intro'                   => "POV-Beloer is 'ne deens dae 't meugelik maak geveulige pazjena's discreet op de volglies van geabonneerdje administrators te zitte.

'n Logbook mit recènt toegeweze pazjena's op volglies is te bekieke op [[Special:PovWatch/log]].",
	'povwatch_subscriber_list'         => "d'r Is 'ne [[Special:PovWatch/subscribers|lies mit abonnees]] besjikbaar.",
	'povwatch_subscriber_list_intro'   => '<strong>Abonnees</strong>',
	'povwatch_not_allowed_subscribers' => 'Doe moogs de lies van abonnees op POV-Beloer neet bekieke.',
	'povwatch_unknown_subpage'         => 'Ónbekindje subpazjena.',
	'povwatch_push'                    => 'Toewieze',
	'povwatch_push_intro'              => "Gebroek 't óngersjtaonde formeleer óm pazjena's op de volglies van abonnees te zètte. Bis veurzichtig bie 't inveure van de pazjena; zelfs neet-besjtaonde pazjena's kónne toegevoeg waere en de kèns de pazjena neet wusje es die is toegeweze.",
	'povwatch_title'                   => 'Pazjena:',
	'povwatch_comment'                 => 'Logbookopmèrking:',
	'povwatch_no_log'                  => "'t Logbook is laeg.",
	'povwatch_no_subscribers'          => "d'r Is nemes geabonneerdj.",
	'povwatch_unsubscribe_intro'       => 'Doe bös noe geabonneerdj op POV-Beloer. Klik op de óngerstäönde knoep óm uch oet te sjrieve.',
	'povwatch_unsubscribe'             => 'Oetsjrieve',
	'povwatch_subscribe_intro'         => 'Doe bös neet ingesjreve veur POV-Beloer. Klik op de óngerstäönde knoep óm uch te abonnere.',
	'povwatch_subscribe'               => 'Abonnere',
	'povwatch_added'                   => 'toegevoeg',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'povwatch_subscribed'              => 'താങ്കള്‍ ഇപ്പോള്‍ PovWatchന്റെ വരിക്കാരനാണ്‌',
	'povwatch_not_subscribed'          => 'താങ്കള്‍ PovWatch-ല്‍ വരിക്കാരനല്ല. അതിനാല്‍ അണ്‍‌സബ്‌സ്ക്രൈബ് ചെയ്യുന്നതിനു സാദ്ധ്യമല്ല,',
	'povwatch_unsubscribed'            => 'താങ്കള്‍ ഇപ്പോള്‍ PovWatchല്‍ നിന്നു അണ്‍സബ്‌സ്ക്രൈബ് ചെയ്തിരിക്കുന്നു.',
	'povwatch_invalid_title'           => 'താങ്കള്‍ തിരഞ്ഞെടുത്ത ശീര്‍ഷകം അസാധുവാണ്‌',
	'povwatch_subscriber_list'         => '[[Special:PovWatch/subscribers|വരിക്കാരുടെ പട്ടിക]] ലഭ്യമാണ്‌.',
	'povwatch_subscriber_list_intro'   => '<strong>വരിക്കാരുടെ പട്ടിക</strong>',
	'povwatch_not_allowed_subscribers' => 'PovWatchന്റെ വരിക്കാരുടെ പട്ടിക കാണുന്നതിനു താങ്കള്‍ക്ക് അനുവാദമില്ല',
	'povwatch_unknown_subpage'         => 'അജ്ഞാതമായ ഉപതാള്‍.',
	'povwatch_title'                   => 'ശീര്‍ഷകം:',
	'povwatch_comment'                 => 'അഭിപ്രായം രേഖപ്പെടുത്തുക:',
	'povwatch_no_log'                  => 'പ്രവര്‍ത്തന രേഖയില്‍ വിവരം ചേര്‍ത്തിട്ടില്ല.',
	'povwatch_no_subscribers'          => 'വരിക്കാര്‍ നിലവിലില്ല.',
	'povwatch_unsubscribe_intro'       => 'താങ്കള്‍ PovWatch-ല്‍ അംഗത്വമെടുത്തിരിക്കുന്നു. അംഗത്വം വിടാന്‍ താഴെയുള്ള ബട്ടണ്‍ ഞെക്കുക.',
	'povwatch_unsubscribe'             => 'അണ്‍‌സബ്‌സ്ക്രൈബ്',
	'povwatch_subscribe_intro'         => 'താങ്കള്‍ PovWatchല്‍ അംഗത്വം എടുത്തിട്ടില്ല. 
അംഗത്വം എടുക്കാന്‍ താഴെയുള്ള ബട്ടണ്‍ ഞെക്കുക.',
	'povwatch_subscribe'               => 'സബ്‌സ്ക്രൈബ്',
	'povwatch_added'                   => 'ചേര്‍ത്തു',
	'right-povwatch_admin'             => "മറ്റു ഉപയോക്താക്കളുടെ '''ശ്രദ്ധിക്കുന്ന താളുകളുടെ പട്ടിക'''യിലേക്കു താളുകള്‍ ചേര്‍ക്കാനുള്ള ഉപയോക്ത അവകാശം പരിപാലിക്കുക",
	'right-povwatch_user'              => "മറ്റു ഉപയോക്താക്കളുടെ '''ശ്രദ്ധിക്കുന്ന താളുകളുടെ പട്ടിക'''യിലേക്കു താളുകള്‍ ചേര്‍ക്കുക",
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'povwatch'                         => 'पीओव्हीवॉच',
	'povwatch_desc'                    => 'इतर सदस्यांच्या [[Special:PovWatch|पहार्‍याच्या सूचीत पाने घुसविण्यासाठी]]चे एक्स्टेंशन',
	'povwatch_no_session'              => 'त्रुटी: सेशन डाटा हरविल्यामुळे अर्ज पाठवू शकत नाही.',
	'povwatch_not_allowed_push'        => 'तुम्ही पीओव्हीवॉच प्रबंधक नाही, तुम्ही इतरांच्या पहार्‍याच्या सूचीत पाने घुसवू शकत नाही.',
	'povwatch_already_subscribed'      => 'तुम्ही अगोदरच पीओव्हीवॉचचे सदस्य आहात',
	'povwatch_subscribed'              => 'तुम्ही आता पीओव्हीवॉचचे सदस्य आहात',
	'povwatch_not_subscribed'          => 'तुम्ही पीओव्हीवॉचचे सदस्य नाहीत, त्यामुळे तुम्ही सदस्यत्व रद्द करू शकत नाही.',
	'povwatch_unsubscribed'            => 'तुम्ही आता पीओव्हीवॉचचे सदस्य नाहीत',
	'povwatch_invalid_title'           => 'दिलेले शीर्षक चुकीचे आहे',
	'povwatch_pushed'                  => '$2 सदस्याच्या पहार्‍याच्या सूचीत [[$1]] घुसविण्यात आलेले आहे',
	'povwatch_intro'                   => 'पीओव्हीवॉच ही अशी सेवा आहे जिच्यामुळे सदस्य प्रबंधकांच्या पहार्‍याच्या सूचीत वाद निर्माण करणारी पाने गुप्तरित्या घुसवता येतात.

अलीकडील काळात घुसवलेल्या पानांची सूची [[Special:PovWatch/log]] इथे उपलब्ध आहे.',
	'povwatch_subscriber_list'         => 'एक [[Special:PovWatch/subscribers|सदस्यांची यादी]] उपलब्ध आहे.',
	'povwatch_subscriber_list_intro'   => '<strong>सदस्यांची यादी</strong>',
	'povwatch_not_allowed_subscribers' => 'तुम्ही पीओव्हीवॉच सदस्यांची यादी बघू शकत नाही.',
	'povwatch_unknown_subpage'         => 'अनोळखी उपपान.',
	'povwatch_push'                    => 'घुसवा',
	'povwatch_push_intro'              => 'इतर सदस्यांच्या पहार्‍याच्या सूचीत पाने घुसविण्यासाठी खालील अर्ज वापरा.
कृपया शीर्षक काळजीपूर्वक लिहा: अस्तित्वात नसलेली पाने सुद्धा घुसवली जातील, व एकदा घुसवलेले पान काढून टाकण्याचा कुठलाही मार्ग नाही.',
	'povwatch_title'                   => 'शीर्षक:',
	'povwatch_comment'                 => 'शेरा नोंदवा:',
	'povwatch_no_log'                  => 'नोंद सापडली नाही.',
	'povwatch_no_subscribers'          => 'सदस्य नाहीत.',
	'povwatch_unsubscribe_intro'       => 'तुम्ही पीओव्हीवॉच चे सदस्य आहात.
सदस्यत्व रद्द करण्यासाठी खालील कळीवर टिचकी द्या.',
	'povwatch_unsubscribe'             => 'सदस्यत्व रद्द करा',
	'povwatch_subscribe_intro'         => 'तुम्ही पीओव्हीवॉचचे सदस्य नाहीत.
सदस्यत्व घेण्यासाठी खालील कळीवर टिचकी मारा.',
	'povwatch_subscribe'               => 'सदस्यत्व घ्या',
	'povwatch_added'                   => 'वाढविले',
	'right-povwatch_admin'             => 'इतर सदस्यांच्या पहार्‍याच्या सूची मध्ये पाने वाढविण्यासाठी आवश्यक अशा सदस्य अधिकारांचे प्रबंधन करा',
	'right-povwatch_user'              => 'इतर सदस्यांच्या पहार्‍याच्या सूचीत पाने वाढवा',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'povwatch_title' => 'Tōcāitl:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author GerardM
 * @author SPQRobin
 */
$messages['nl'] = array(
	'povwatch'                         => 'PovWatch',
	'povwatch_desc'                    => "[[Special:PovWatch|Speciale pagina]] om pagina's op de volglijst van andere gebruikers te plaatsen",
	'povwatch_no_session'              => 'Fout: het formulier kon niet verwerkt worden omdat de sessiegegevens verloren zijn gegaan.',
	'povwatch_not_allowed_push'        => "U bent geen beheerder van PovWatch en kan geen pagina's op volglijsten zetten.",
	'povwatch_already_subscribed'      => 'U bent al geabonneerd op PovWatch',
	'povwatch_subscribed'              => 'U bent nu geabonneerd op PovWatch',
	'povwatch_not_subscribed'          => 'U bent niet geabonneerd op PovWatch, dus u kunt niet uitschrijven.',
	'povwatch_unsubscribed'            => 'U bent uitgeschreven van PovWatch',
	'povwatch_invalid_title'           => 'De opgegeven paginanaam is ongeldig',
	'povwatch_pushed'                  => '[[$1]] is succesvol toegewezen aan $2 volglijsten van gebruikers.',
	'povwatch_intro'                   => "PovWatch is een dienst die het mogelijk maakt gevoelige pagina's discreet op de volglijst van geabonneerde beheerders te zetten.

Een logboek met recent toegewezen pagina's op volglijsten is te bekijken op [[Special:PovWatch/log]].",
	'povwatch_subscriber_list'         => 'Er is een [[Special:PovWatch/subscribers|lijst met abonnees]] beschikbaar.',
	'povwatch_subscriber_list_intro'   => '<strong>Abonnees</strong>',
	'povwatch_not_allowed_subscribers' => 'U mag de lijst van abonnees op PovWatch niet bekijken.',
	'povwatch_unknown_subpage'         => 'Onbekende subpagina.',
	'povwatch_push'                    => 'Toewijzen',
	'povwatch_push_intro'              => "Gebruik het onderstaande formulier om pagina's op de volglijst van abonnees te zetten.
Wees voorzichtig bij het invoeren van de pagina: zelfs niet-bestaande pagina's kunnen toegevoegd worden en u kunt de pagina niet verwijderen als die is toegewezen.",
	'povwatch_title'                   => 'Pagina:',
	'povwatch_comment'                 => 'Logboekopmerking:',
	'povwatch_no_log'                  => 'Het logboek is leeg.',
	'povwatch_no_subscribers'          => 'Er is niemand geabonneerd.',
	'povwatch_unsubscribe_intro'       => 'U bent nu geabonneerd op PovWatch. Klik op de onderstaande knop om u uit te schrijven.',
	'povwatch_unsubscribe'             => 'Uitschrijven',
	'povwatch_subscribe_intro'         => 'U bent niet ingeschreven voor PovWatch. Klik op de onderstaande knop om u te abonneren.',
	'povwatch_subscribe'               => 'Abonneren',
	'povwatch_added'                   => 'toegevoegd',
	'right-povwatch_admin'             => 'Beheer gebruikersrechten voor het toevoegen van artikelen aan de volglijst van andere gebruikers',
	'right-povwatch_user'              => "Pagina's toevoegen aan de volglijst van andere gebruikers",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'povwatch_title'   => 'Tittel:',
	'povwatch_comment' => 'Kommentar:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'povwatch'                         => 'PovWatch',
	'povwatch_desc'                    => 'Utvidelse for å [[Special:PovWatch|plassere sider på andre brukeres overvåkningsliste]]',
	'povwatch_no_session'              => 'Feil: Kunne ikke levere skjema på grunn av øktdatatap.',
	'povwatch_not_allowed_push'        => 'Du er ikke en PovWatch-administrator, du kan ikke plassere sider på overvåkningslister.',
	'povwatch_already_subscribed'      => 'Du abonnerer allerede på PovWatch',
	'povwatch_subscribed'              => 'Du abonnerer nå på PovWatch',
	'povwatch_not_subscribed'          => 'Du abonnerer ikke på PovWatch, så du kan ikke avslutte noe abonnement.',
	'povwatch_unsubscribed'            => 'Du har nå avsluttet abonnementet på PovWatch',
	'povwatch_invalid_title'           => 'Den gitte tittelen var ugyldig',
	'povwatch_pushed'                  => '[[$1]] har blitt plassert på $2 {{PLURAL:$2|overvåkningsliste|overvåkningslister}}.',
	'povwatch_intro'                   => 'PovWatch er en tjeneste som lar kontroversielle sider bli plassert på abonnerende administratorers overvåkningslister.

En log over nylige plasseringer er tilgjengelig på [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'En [[Special:PovWatch/subscribers|liste over abonnenter]] er tilgjengelig.',
	'povwatch_subscriber_list_intro'   => '<strong>Abonnentliste</strong>',
	'povwatch_not_allowed_subscribers' => 'Du kan ikke se listen over PovWatch-abonnenter.',
	'povwatch_unknown_subpage'         => 'Ukjent underside.',
	'povwatch_push'                    => 'Plasser',
	'povwatch_push_intro'              => 'Bruk skjemaet nedenfor for å plassere sider på abonnenters overvåkningslister.
Vær forsiktig når du skriver inn tittelen; også ikke-eksisterende sider kan legges til, og det er ingen måte å fjerne en tittel på med en gang den er plassert.',
	'povwatch_title'                   => 'Tittel:',
	'povwatch_comment'                 => 'Kommentar:',
	'povwatch_no_log'                  => 'Det er ingen elementer i loggen.',
	'povwatch_no_subscribers'          => 'Det er ingen abonnenter.',
	'povwatch_unsubscribe_intro'       => 'Du abonnerer på PovWatch. Klikk på knappen nedenfor for å avslutte abonnementet.',
	'povwatch_unsubscribe'             => 'Avslutt abonnement',
	'povwatch_subscribe_intro'         => 'Du abonnerer ikke på PovWatch. Klikk på knappen nedenfor for å abonnere.',
	'povwatch_subscribe'               => 'Abonner',
	'povwatch_added'                   => 'lagt til',
	'right-povwatch_admin'             => 'Administrere brukerrettigheter for hvem som kan legge til sider i andre brukeres overvåkningslister',
	'right-povwatch_user'              => 'Legge til sider i andres overvåkningslister',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'povwatch_title' => 'Thaetlele:',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'povwatch'                         => 'Susvelhança de las guèrras d’edicions',
	'povwatch_desc'                    => 'Extension permetent d’[[Special:PovWatch|apondre de paginas a la lista de seguit]] d’autres utilizaires',
	'povwatch_no_session'              => 'Error : Impossible de sometre lo formulari en seguida de la pèrda de las donadas de la sesilha.',
	'povwatch_not_allowed_push'        => 'Sètz pas un administrator per la susvelhança de las guèrras d’edicion. Podètz pas apondre los articles dins la lista correspondenta.',
	'povwatch_already_subscribed'      => 'Ja sètz inscrich(a) per la susvelhança de las guèrras d’edicion.',
	'povwatch_subscribed'              => 'Ara sètz inscrich(a) per la susvelhança de las guèrras d’edicion.',
	'povwatch_not_subscribed'          => 'Sètz pas marcat(ada) per la susvelhança de las guèrras d’edicions. Atal doncas, vos podètz pas desmarcar.',
	'povwatch_unsubscribed'            => 'Vòstra inscripcion per la susvelhança de las guèrras d’edicion ara es resiliada.',
	'povwatch_invalid_title'           => 'Lo títol indicat es invalid.',
	'povwatch_pushed'                  => '[[$1]] es estada inscricha amb succès dins la lista de susvelhança de l’utilizaire $2.',
	'povwatch_intro'                   => "La susvelhança de las guèrras d’edicion es un servici qu'autoriza la susvelhança discrèta dels articles conflictuals. Aquestes pòdon èsser inscriches dins la lista de susvelhança dels administrators enregistrats. Un jornal de susvelhança dels articles inscriches es disponible sus [[Special:PovWatch/log]].",
	'povwatch_subscriber_list'         => 'Una [[Special:PovWatch/subscribers|lista dels abonats]] es disponibla.',
	'povwatch_subscriber_list_intro'   => '<strong>Lista dels abonats</strong>',
	'povwatch_not_allowed_subscribers' => 'Avètz pas la permission de visionar la lista de las personas inscrichas per la susvelhança de las guèrras d’edicions.',
	'povwatch_unknown_subpage'         => 'Sospagina desconeguda.',
	'povwatch_push'                    => 'Inscriure',
	'povwatch_push_intro'              => "Utilizatz lo formulari çaijós per inscriure los articles dins la lista de susvelhança dels utilizaires abonats. Inscrivissetz escrupulosament lo títol : los articles pòdon quitament èsser ajustats, e existís pas cap d'eissida per o levar un còp inscrich.",
	'povwatch_title'                   => 'Títol :',
	'povwatch_comment'                 => 'Comentari del jornal :',
	'povwatch_no_log'                  => "Existís pas cap d'entrada dins lo jornal.",
	'povwatch_no_subscribers'          => 'Existís pas cap de persona abonada.',
	'povwatch_unsubscribe_intro'       => 'Sètz inscrich(-a) a la lista de susvelhança de las guèrras d’edicion. Clicatz sul boton çaijós per vos desinscriure.',
	'povwatch_unsubscribe'             => 'Resiliar',
	'povwatch_subscribe_intro'         => 'Sètz pas marcat(ada) sus la tièra de susvelhança de las guèrras d’edicions. Clicatz sul boton çaijós per vos marcar.',
	'povwatch_subscribe'               => 'Soscriure',
	'povwatch_added'                   => 'ajustat',
	'right-povwatch_admin'             => "Administrar los dreches d’utilizaire per l'ajust de paginas a la lista de seguit dels autres utilizaires.",
	'right-povwatch_user'              => 'Apondís de paginas a la lista de seguit dels autres utilizaires',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'povwatch_title' => 'Tytuł:',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'povwatch_invalid_title' => 'ستاسو ځانګړی شوی سرليک سم نه وو',
	'povwatch_title'         => 'سرليک:',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'povwatch_no_session'      => 'Erro: Não foi possível submeter o formulário devida a perda de dados da sessão.',
	'povwatch_invalid_title'   => 'O título especificado é inválido',
	'povwatch_unknown_subpage' => 'Subpágina desconhecida.',
	'povwatch_title'           => 'Título:',
	'povwatch_no_subscribers'  => 'Não existem subscritores.',
	'povwatch_unsubscribe'     => 'Cancelar subscrição',
	'povwatch_subscribe'       => 'Subscrever',
	'povwatch_added'           => 'adicionado',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'povwatch_title' => 'Titlu:',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'povwatch'                         => 'НтзНадзор',
	'povwatch_desc'                    => 'Расширение, позволяющее [[Special:PovWatch|помещать страницы в списки наблюдения]] других участников',
	'povwatch_no_session'              => 'Ошибка. Невозможно отправить форму из-за потери данных сессии.',
	'povwatch_not_allowed_push'        => 'Вы не являетесь администратором НтзНадзора, вы не можете помещать страницы в списки наблюдения.',
	'povwatch_already_subscribed'      => 'Вы уже подписаны на НтзНадзор',
	'povwatch_subscribed'              => 'Теперь вы подписаны на НтзНадзор',
	'povwatch_not_subscribed'          => 'Вы не подписаны на НтзНадзор, поэтому вы не можете отписаться.',
	'povwatch_unsubscribed'            => 'Вы отписались от НтзНадзора.',
	'povwatch_invalid_title'           => 'Указанный заголовок неверен',
	'povwatch_pushed'                  => '[[$1]] была успешно помещёна в список наблюдения $2 участника(ов)',
	'povwatch_intro'                   => 'НтзНадзор (PovWatch ) — служба, позволяющая скрытно помещать спорные страницы в списки наблюдения подписанных администраторов.

Журнал недавних помещений в списки наблюдения доступен на странице [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'Доступен [[Special:PovWatch/subscribers|список подписчиков]].',
	'povwatch_subscriber_list_intro'   => '<strong>Список подписчиков</strong>',
	'povwatch_not_allowed_subscribers' => 'Вам не разрешено просматривать список подписчиков НтзНадзора.',
	'povwatch_unknown_subpage'         => 'Неизвестная подстраница.',
	'povwatch_push'                    => 'Поместить',
	'povwatch_push_intro'              => 'Используйте форму ниже, чтобы поместить страницы в списки наблюдения подписанных участников. Пожалуйста, будьте осторожны набирая название: даже несуществующие названия могут быть добавлены, и нет никакой возможности удалить название, если оно уже было добавлено.',
	'povwatch_title'                   => 'Название:',
	'povwatch_comment'                 => 'Примечание для журнала:',
	'povwatch_no_log'                  => 'Нет записей в журнале.',
	'povwatch_no_subscribers'          => 'Нет подписчиков.',
	'povwatch_unsubscribe_intro'       => 'Вы подписались на НтзНадзор. Нажмите на кнопку ниже, чтобы отписаться.',
	'povwatch_unsubscribe'             => 'Отписаться',
	'povwatch_subscribe_intro'         => 'Вы не подписаны на НтзНадзор. Нажмите кнопку ниже, чтобы подписаться.',
	'povwatch_subscribe'               => 'Подписаться',
	'povwatch_added'                   => 'добавлен',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'povwatch'                         => 'PovWatch',
	'povwatch_desc'                    => 'Rozšírenie na [[Special:PovWatch|pridávanie stránok na zoznamy sledovaných stránok]] ostatných používateľov',
	'povwatch_no_session'              => 'Error: nebolo možné odoslať formulár kvôli strate údajov prihlasovacej relácie.',
	'povwatch_not_allowed_push'        => 'Nie ste správca PovWatch, nemôžete pridávať stránky na zoznamy sledovaných stránok.',
	'povwatch_already_subscribed'      => 'Už ste sa prihlásili na odber PovWatch',
	'povwatch_subscribed'              => 'Teraz ste sa prihlásili na odber PovWatch',
	'povwatch_not_subscribed'          => 'Nie ste prihlásený na odber PovWatch, takže ho nemôžete odhlásiť.',
	'povwatch_unsubscribed'            => 'Teraz ste sa odhlásili z odberu PovWatch',
	'povwatch_invalid_title'           => 'Zadaný názov bol neplatný',
	'povwatch_pushed'                  => '[[$1]] bolo úspešne pridané na {{PLURAL:$2|zoznam sledovaných stránok jedného používateľa|zoznamy sledovaných stránok $2 používateľov}}',
	'povwatch_intro'                   => 'PovWatch je služba, ktorá umožňuje diskrétne pridávať obsažné stránky na zoznamy sledovaných stránok správcov, ktorí si to objednali.

Záznam posledných zoznamov sledovaných stránok sa nachádza na [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'Je dostupný [[Special:PovWatch/subscribers|zoznam odoberateľov]].',
	'povwatch_subscriber_list_intro'   => '<strong>Zoznam odoberateľov</strong>',
	'povwatch_not_allowed_subscribers' => 'Nemáte oprávnenie prehliadať zoznam odoberateľov PovWatch.',
	'povwatch_unknown_subpage'         => 'Neznáma podstránka.',
	'povwatch_push'                    => 'Pridať',
	'povwatch_push_intro'              => 'Použite tento formulár na pridanie stránok na zoznamy sledovaných stránok používateľov, ktorí ich odoberajú. Prosím, buďte pozorní pri písaní názvu stránky, je možné pridať aj názvy neexistujúcich stránok a neexistuje spôsob ako ich odstrániť, keď raz boli pridané.',
	'povwatch_title'                   => 'Názov:',
	'povwatch_comment'                 => 'Komentár v zázname:',
	'povwatch_no_log'                  => 'Neexistujú žiadne položky záznamu.',
	'povwatch_no_subscribers'          => 'Neexistujú žiadni odoberatelia.',
	'povwatch_unsubscribe_intro'       => 'Prihlásili ste sa na odber PovWatch. Odhlásiť odber môžete kliknutím na tlačidlo dolu.',
	'povwatch_unsubscribe'             => 'Odhlásiť odber',
	'povwatch_subscribe_intro'         => 'Nie ste prihlásený na odber PovWatch. Prihlásiť odber môžete kliknutím na tlačidlo dolu.',
	'povwatch_subscribe'               => 'Prihlásiť odber',
	'povwatch_added'                   => 'pridaný',
	'right-povwatch_admin'             => 'Spravovať oprávnenie pridávať stránky do zoznamu sledovaných ostatných používateľov',
	'right-povwatch_user'              => 'Pridávať stránku do zoznamu sledovaných ostatných používateľov',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'povwatch_title' => 'Наслов:',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 * @author Jon Harald Søby
 */
$messages['sv'] = array(
	'povwatch'                         => 'PovBevakning',
	'povwatch_desc'                    => 'Programtillägg för att [[Special:PovWatch|placera sidor på andra användares bevakningslistor]]',
	'povwatch_no_session'              => 'Fel: Kunde inte leverera formulär på grund av tapp av sessionsdata.',
	'povwatch_not_allowed_push'        => 'Du är inte en PovBevaknings-administratör, du kan inte placera sidor på bevakningslistor.',
	'povwatch_already_subscribed'      => 'Du abonnerar redan på PovBevakning',
	'povwatch_subscribed'              => 'Du abonnerar nu på PovBevakning',
	'povwatch_not_subscribed'          => 'Du abonnerar inte på PovBevakning, så du kan inte sluta abonnera.',
	'povwatch_unsubscribed'            => 'Du har nu slutat abonnera på PovBevakning',
	'povwatch_invalid_title'           => 'Den angivna titeln var ogiltig',
	'povwatch_pushed'                  => '[[$1]] har placerats på $2 {{PLURAL:$2|bevakningslista|bevakningslistor}}',
	'povwatch_intro'                   => 'PovBevakning är en tjänst som låter kontroversiella sidor bli placerade på abonnerande administratörers bevakningslistor.

En logg över dom senaste placeringarna är tillgänglig på [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'En [[Special:PovWatch/subscribers|lista över abonnenter]] är tillgänglig.',
	'povwatch_subscriber_list_intro'   => '<strong>Lista över abonnenter</strong>',
	'povwatch_not_allowed_subscribers' => 'Du är inte tillåten att se listan över PovBevakning-abonnenter.',
	'povwatch_unknown_subpage'         => 'Okänd undersida.',
	'povwatch_push'                    => 'Tryck',
	'povwatch_push_intro'              => 'Använd formuläret nedan för att placera sidor på abonnenters bevakninglistor.
Var försiktig när du skriver in titeln; ej existerande sidor kan också läggas till, och det finns inget sätt att ta bort en titel när den har placerats ut.',
	'povwatch_title'                   => 'Titel:',
	'povwatch_comment'                 => 'Kommentar:',
	'povwatch_no_log'                  => 'Det finns inga element i loggen.',
	'povwatch_no_subscribers'          => 'Det finns inga abonnenter.',
	'povwatch_unsubscribe_intro'       => 'Du abonnerar på PovBevakning.
Klicka på knappen nedan för att avsluta abonnemanget.',
	'povwatch_unsubscribe'             => 'Avsluta abonnemang',
	'povwatch_subscribe_intro'         => 'Du abonnerar inte på PovBevakning.
Klicka på knappen nedan för att abonnera.',
	'povwatch_subscribe'               => 'Abonnera',
	'povwatch_added'                   => 'tillaggd',
	'right-povwatch_admin'             => 'Administrera användarrättigheter för tilläggande av sidor i andra användares bevakningslistor',
	'right-povwatch_user'              => 'Lägga till sidor i andra användares bevakningslistor',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'povwatch_invalid_title'         => 'మీరిచ్చిన శీర్షిక సరైనది కాదు',
	'povwatch_subscriber_list_intro' => '<strong>చందాదార్ల జాబితా</strong>',
	'povwatch_unknown_subpage'       => 'గుర్తుతెలియని ఉపపేజీ.',
	'povwatch_title'                 => 'శీర్షిక:',
	'povwatch_no_log'                => 'దినచర్యలో అంశాలేమీ లేవు.',
	'povwatch_no_subscribers'        => 'చందాదార్లు ఎవరూ లేరు.',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'povwatch_unknown_subpage' => 'Зерсаҳифаи ношинос.',
	'povwatch_title'           => 'Унвон:',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'povwatch_title' => 'Başlık:',
);

/** Ukrainian (Українська)
 * @author AS
 */
$messages['uk'] = array(
	'povwatch_title' => 'Назва:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'povwatch'                         => 'Theo dõi trung lập',
	'povwatch_desc'                    => 'Gói mở rộng để [[Special:PovWatch|đẩy trang vào danh sách theo dõi]] của thành viên khác',
	'povwatch_no_session'              => 'Lỗi: Không thể đăng mẫu do mất dữ liệu phiên làm việc.',
	'povwatch_not_allowed_push'        => 'Bạn không phải là một quản lý PovWatch, bạn không thể đẩy trang vào danh sách theo dõi.',
	'povwatch_already_subscribed'      => 'Bạn đã đăng ký vào PovWatch',
	'povwatch_subscribed'              => 'Hiện bạn đã đăng ký vào PovWatch',
	'povwatch_not_subscribed'          => 'Bạn chưa đăng ký vào PovWatch, do đó bạn không thể bỏ đăng ký.',
	'povwatch_unsubscribed'            => 'Hiện bạn đã bỏ đăng ký khỏi PovWatch',
	'povwatch_invalid_title'           => 'Tựa đề chỉ định không hợp lệ',
	'povwatch_pushed'                  => '[[$1]] đã được đẩy thành công vào $2 danh sách theo dõi thành viên',
	'povwatch_intro'                   => 'PovWatch là dịch vụ cho phép các trang có tranh cãi được đẩy vào danh sách theo dõi của những bảo quản viên đã đăng ký.

Một nhật trình các lần đẩy vào danh sách theo dõi gần đây có tại [[Special:PovWatch/log]].',
	'povwatch_subscriber_list'         => 'Cũng có một [[Special:PovWatch/subscribers|danh sách các người đã đăng ký]].',
	'povwatch_subscriber_list_intro'   => '<strong>Danh sách người đăng ký</strong>',
	'povwatch_not_allowed_subscribers' => 'Bạn không được phép xem danh sách người đăng ký PovWatch.',
	'povwatch_unknown_subpage'         => 'Không rõ trang con.',
	'povwatch_push'                    => 'Đẩy',
	'povwatch_push_intro'              => 'Dùng mẫu ở dưới để đẩy trang vào danh sách theo dõi của thành viên đã đăng ký.
Xin hãy gõ cẩn thận tựa đề: thậm chí những tựa đề không tồn tại cũng có thể được thêm vào, và không có cách nào bỏ một tựa đề khi nó đã được đẩy đi.',
	'povwatch_title'                   => 'Tên trang:',
	'povwatch_comment'                 => 'Ghi chú nhật trình:',
	'povwatch_no_log'                  => 'Không có mục nhật trình nào.',
	'povwatch_no_subscribers'          => 'Không có thành viên nào đăng ký.',
	'povwatch_unsubscribe_intro'       => 'Bạn đã đăng ký vào PovWatch.
Nhấn vào nút phía dưới để bỏ đăng ký.',
	'povwatch_unsubscribe'             => 'Ngừng theo dõi',
	'povwatch_subscribe_intro'         => 'Bạn không đăng ký vào PovWatch.
Nhấn vào nút phía dưới để đăng ký.',
	'povwatch_subscribe'               => 'Theo dõi',
	'povwatch_added'                   => 'được thêm vào',
	'right-povwatch_admin'             => 'Quản lý quyền thành viên để đưa trang vào danh sách thành viên của người khác',
	'right-povwatch_user'              => 'Thêm trang vào danh sách theo dõi của thành viên khác',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'povwatch_title' => 'Tiäd:',
);

