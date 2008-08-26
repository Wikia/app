<?php
/**
 * Internationalisation file for extension Todo.
 *
 * @addtogroup Extensions
 * @author Bertrand GRONDIN
 */

$messages = array();

$messages['en'] = array(
	'todo'                  => 'Todo list',
	'todo-desc'             => 'Experimental personal [[Special:Todo|todo list]] extension',
	'todo-tab'              => 'todo',
	'todo-new-queue'        => 'new',
	'todo-mail-subject'     => "Completed item on $1's todo list",
	'todo-mail-body'        => "You requested e-mail confirmation about the completion of an item you submitted to $1's online todo list.

Item: $2
Submitted: $3

This item has been marked as completed, with this comment:
$4",
	'todo-invalid-item'     => "Missing or invalid item",
	'todo-update-else-item' => "Trying to update someone else's items",
	'todo-unrecognize-type' => "Unrecognized type",
	'todo-user-invalide'    => "Todo given invalid, missing, or un-todoable user.",
	'todo-item-list'        => 'Your items',
	'todo-no-item'          => 'No todo items.',
	'todo-invalid-owner'    => 'Invalid owner on this item',
	'todo-add-queue'        => 'Add queue…',
	'todo-move-queue'       => 'Move to queue…',
	'todo-list-for'         => 'Todo list for',
	'todo-list-change'      => 'Change',
	'todo-list-cancel'      => 'Cancel',
	'todo-new-item'         => 'New item',
	'todo-issue-summary'    => 'Issue summary:',
	'todo-form-details'     => 'Details:',
	'todo-form-email'       => 'To receive notification by e-mail when the item is closed, type your address here:',
	'todo-form-submit'      => 'Submit query',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'todo-list-cancel' => "Mao'ạki",
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'todo-list-cancel' => 'Keskevytä',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'todo-list-cancel' => 'Чараш',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'todo-list-cancel' => 'Tiaki',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'todo-new-queue'    => 'nuut',
	'todo-list-cancel'  => 'Kanselleer',
	'todo-form-details' => 'Details:',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'todo'                  => 'قائمة للعمل',
	'todo-tab'              => 'للعمل',
	'todo-new-queue'        => 'جديد',
	'todo-mail-subject'     => 'المدخلة المكملة في قائمة $1 للعمل',
	'todo-mail-body'        => 'أنت طلبت تأكيدا بالبريد الإلكتروني حول إكمال مدخلة أنت أضفتها إلى قائمة $1 للعمل.

المدخلة: $2
المنفذة: $3

هذه المدخلة تم التعليم عليها كمكملة، مع هذا التعليق:
$4',
	'todo-invalid-item'     => 'مدخلة مفقودة أو غير صحيحة',
	'todo-update-else-item' => 'محاولة تحديث مدخلات شخص آخر',
	'todo-unrecognize-type' => 'نوع غير متعرف عليه',
	'todo-user-invalide'    => 'للعمل معطاة مستخدم غير صحيح، مفقود، أو لا يمكن إضافته للعمل.',
	'todo-item-list'        => 'مدخلاتك',
	'todo-no-item'          => 'لا مدخلات للعمل.',
	'todo-invalid-owner'    => 'مالك غير صحيح لهذه المدخلة',
	'todo-add-queue'        => 'أضف الطابور...',
	'todo-move-queue'       => 'انقل إلى الطابور...',
	'todo-list-for'         => 'قائمة للعمل ل',
	'todo-list-change'      => 'تغيير',
	'todo-list-cancel'      => 'إلغاء',
	'todo-new-item'         => 'مدخلة جديدة',
	'todo-issue-summary'    => 'ملخص القضية:',
	'todo-form-details'     => 'التفاصيل:',
	'todo-form-email'       => 'لاستقبال إخطار بواسطة البريد الإلكتروني عندما يتم إغلاق المدخلة، اكتب عنوانك هنا:',
	'todo-form-submit'      => 'تنفيذ',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'todo'                  => 'Списък със задачи',
	'todo-desc'             => 'Експериментално разширение за създаване на персонален [[Special:Todo|списък със задачи]]',
	'todo-unrecognize-type' => 'Неразпознат тип',
	'todo-add-queue'        => 'Добавяне на опашка…',
	'todo-move-queue'       => 'Преместване в опашка…',
	'todo-list-for'         => 'Списък със задачи за',
	'todo-list-change'      => 'Промяна',
	'todo-list-cancel'      => 'Отмяна',
	'todo-issue-summary'    => 'Резюме:',
	'todo-form-details'     => 'Детайли:',
	'todo-form-email'       => 'За получаване на оповестително писмо при приключване на задачата е необходимо да въведете своя адрес за е-поща:',
	'todo-form-submit'      => 'Изпращане на заявка',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'todo-new-queue'   => 'ny',
	'todo-list-cancel' => 'Afbryd',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'todo-item-list'    => 'Τα αντικείμενα σας',
	'todo-list-change'  => 'Αλλαγή',
	'todo-list-cancel'  => 'Έξοδος',
	'todo-new-item'     => 'Νέο αντικείμενο',
	'todo-form-details' => 'Λεπτομέρειες:',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'todo'              => 'Tasklisto',
	'todo-tab'          => 'tasko',
	'todo-new-queue'    => 'nova',
	'todo-list-change'  => 'Ŝanĝu',
	'todo-list-cancel'  => 'Nuligi',
	'todo-form-details' => 'Detaloj:',
);

/** French (Français)
 * @author Urhixidur
 */
$messages['fr'] = array(
	'todo'                  => 'Liste des tâches à exécuter',
	'todo-desc'             => 'Extension expérimentale d’une [[Special:Todo|liste personnelle de tâches à accomplir]]',
	'todo-tab'              => 'à faire',
	'todo-new-queue'        => 'Nouveau',
	'todo-mail-subject'     => 'Article achevé sur la liste des tâches de $1',
	'todo-mail-body'        => "Vous avez demandé la confirmation par courriel en ce qui concerne l'achèvement d'un article que vous aviez sur la liste des tâches de $1.

Article : $2
Soumis : $3

Cet article a été marqué comme terminé avec le commentaire suivant :
$4",
	'todo-invalid-item'     => 'Article manquant ou invalide',
	'todo-update-else-item' => "Tentative de mise à jour des articles de quelqu'un d'autre",
	'todo-unrecognize-type' => 'Type non reconnu',
	'todo-user-invalide'    => 'Tâche à faire invalide, manquante, ou utilisateur ne disposant pas des droits nécessaires pour cela.',
	'todo-item-list'        => 'Vos articles',
	'todo-no-item'          => 'Aucune tâche à exécuter',
	'todo-invalid-owner'    => 'Propriétaire de cet article invalide',
	'todo-add-queue'        => 'Ajouter à la queue…',
	'todo-move-queue'       => 'Déplacer vers la queue…',
	'todo-list-for'         => 'Liste des tâches à exécuter pour',
	'todo-list-change'      => 'Modifier',
	'todo-list-cancel'      => 'Annuler',
	'todo-new-item'         => 'Nouvel article',
	'todo-issue-summary'    => 'Résumé sommaire :',
	'todo-form-details'     => 'Précisions :',
	'todo-form-email'       => 'Pour recevoir les notifications par courriel une fois l’article clôturé, inscrivez votre adresse dans le cadre ci-dessous :',
	'todo-form-submit'      => 'Soumettre la requête',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'todo'                  => 'Lista de tarefas pendentes',
	'todo-desc'             => 'Extensión experimental da [[Special:Todo|lista persoal de tarefas pendentes]]',
	'todo-tab'              => 'tarefas pendentes',
	'todo-new-queue'        => 'novo',
	'todo-mail-subject'     => 'Completado o ítem da lista de tarefas pendentes de $1',
	'todo-mail-body'        => 'Solicitou unha confirmación por correo electrónico acerca do remate dun ítem que enviou á lista en liña de tarefas pendentes de $1.

Ítem: $2
Enviado: $3

Este ítem foi marcado como completado, con este comentario:
$4',
	'todo-invalid-item'     => 'Artigo perdido ou non válido',
	'todo-update-else-item' => 'Intentando actualizar os ítems de alguén',
	'todo-unrecognize-type' => 'Tipo non recoñecido',
	'todo-user-invalide'    => 'As tarefas pendentas dadas son inválidas, faltan, ou son dun usuario que non ten dereito para telas.',
	'todo-item-list'        => 'Os seus artigos',
	'todo-no-item'          => 'Non hai tarefas pendentes.',
	'todo-invalid-owner'    => 'Propietario inválido deste ítem',
	'todo-add-queue'        => 'Engadir cola…',
	'todo-move-queue'       => 'Mover á cola…',
	'todo-list-for'         => 'Lista de tarefas pendentes para',
	'todo-list-change'      => 'Cambiar',
	'todo-list-cancel'      => 'Cancelar',
	'todo-new-item'         => 'Novo artigo',
	'todo-issue-summary'    => 'Resumo do tema:',
	'todo-form-details'     => 'Detalles:',
	'todo-form-email'       => 'Para recibir unha notificación por correo electrónico cando o artigo esté pechado, teclee o seu enderezo aquí:',
	'todo-form-submit'      => 'Presentar Consulta',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'todo-list-cancel'  => 'रद्द करें',
	'todo-form-details' => 'विस्तॄत ज़ानकारी:',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'todo-list-cancel' => 'Kanselahon',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'todo'                  => 'Lisćina nadawkow',
	'todo-desc'             => 'Eksperimentelne rozšěrjenje za wosobinsku [[Special:Todo|lisćinu nadawkow]]',
	'todo-tab'              => 'nadawk',
	'todo-new-queue'        => 'nowy',
	'todo-mail-subject'     => 'Sčinjeny nadawk na lisćinje nadawkow $1',
	'todo-mail-body'        => 'Ty sy wo e-mejlowe potwjerdźenje wo sčinjenju nadawka požadał, kotryž sy do lisćiny nadawkow $1 w syći pósłał.

Nadawk: $2
Pósłany: $3

Tutón nadawk bu jako sčinjeny markěrowany, z tutym komentarom:
$4',
	'todo-invalid-item'     => 'Falowacy abo njepłaćiwy nadawk',
	'todo-update-else-item' => 'Pospyt nadawki někoho druheho aktualizować',
	'todo-unrecognize-type' => 'Njespóznaty typ',
	'todo-user-invalide'    => 'Daty nadawk je njepłaćiwy, faluje, abo wužiwar, kiž njemóže nadawk sčinić.',
	'todo-item-list'        => 'Twoje nadawki',
	'todo-no-item'          => 'Žane nadawki.',
	'todo-invalid-owner'    => 'Njepłaćiwy swójstwownik na tutym nadawku',
	'todo-add-queue'        => 'Čakanski rynk přidać...',
	'todo-move-queue'       => 'Do čakanskeho rynka přesunyć...',
	'todo-list-for'         => 'Lisćina nadawkow za',
	'todo-list-change'      => 'Změnić',
	'todo-list-cancel'      => 'Přetorhnyć',
	'todo-new-item'         => 'Nowy nadawk',
	'todo-issue-summary'    => 'Zjeće wudać:',
	'todo-form-details'     => 'Podrobnosće',
	'todo-form-email'       => 'Zo by zdźělenje z e-mejlu dóstał, hdyž so nadawk kónči, zapodaj tu swoju adresu:',
	'todo-form-submit'      => 'Naprašowanje wotesłać',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'todo-new-queue' => 'új',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'todo-list-cancel'  => 'Batalkan',
	'todo-form-details' => 'Rincian:',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'todo'                  => 'Daftar tugas',
	'todo-tab'              => 'tugas',
	'todo-new-queue'        => 'anyar',
	'todo-mail-subject'     => 'Perkara sing wis dilaksanakaké ing daftar tugas $1',
	'todo-unrecognize-type' => 'Jenisé ora ditepungi',
	'todo-add-queue'        => 'Tambah antrian…',
	'todo-move-queue'       => 'Pindhahna menyang antrian…',
	'todo-list-for'         => 'Daftar tugas kanggo',
	'todo-list-change'      => 'Ganti',
	'todo-list-cancel'      => 'Batal',
	'todo-new-item'         => 'Item anyar',
	'todo-issue-summary'    => 'Ringkesan:',
	'todo-form-details'     => 'Détail:',
	'todo-form-submit'      => 'Kirimna kwéri',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'todo'                  => 'បញ្ជីកិច្ចការ​ត្រូវ​ធ្វើ',
	'todo-tab'              => 'ត្រូវធ្វើ',
	'todo-new-queue'        => 'ថ្មី',
	'todo-unrecognize-type' => 'ប្រភេទមិនស្គាល់',
	'todo-add-queue'        => 'បន្ថែម ជួររង់ចាំ...',
	'todo-list-change'      => 'ផ្លាស់ប្តូរ',
	'todo-list-cancel'      => 'បោះបង់',
	'todo-new-item'         => 'របស់ថ្មី',
	'todo-form-details'     => 'លំអិត ៖',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'todo-list-cancel' => 'Kanselar',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'todo'                  => 'Opjaveliss',
	'todo-desc'             => 'Ene Zosatz för en persönliche [[Special:Todo|Opjaveliss]] för zem Ußprobeere',
	'todo-tab'              => 'Opjav',
	'todo-new-queue'        => 'neu',
	'todo-mail-subject'     => 'Erledichte Opjav en däm $1 sing Opjaveliss',
	'todo-mail-body'        => 'Do häs Der en E-Mail jewönsch, wann en Opjav erledich wöhr, die De em $1 en sing Opjaveliss jedonn häs. He is se:

De Opjav: $2
Enjedrage: $3

Se wood als erledich makeet mit dä Bemerkung:
$4

Ene schone Jroß.',
	'todo-invalid-item'     => 'Die Opjav fäält, odder se es kapott',
	'todo-update-else-item' => 'Enem andere Metmaacher sing Opjave ändere',
	'todo-unrecognize-type' => 'Di Aat Opjaav kenne mer nit',
	'todo-user-invalide'    => 'Die Opjav es kapott, nit doh, odder dä Medmaacher kann jaa kein Opjave han.',
	'todo-item-list'        => 'Ding Opjave',
	'todo-no-item'          => 'Kein Opjave en de Liss.',
	'todo-invalid-owner'    => 'Dä Medmaacher för die Opjaav is nit mööschlesch',
	'todo-add-queue'        => 'En Schlang dobei donn&nbsp;…',
	'todo-move-queue'       => 'En de Schlang donn&nbsp;…',
	'todo-list-for'         => 'Opjaveliss för',
	'todo-list-change'      => 'Ändere',
	'todo-list-cancel'      => 'Draanjevve',
	'todo-new-item'         => 'En neu Opjav',
	'todo-issue-summary'    => 'Zosammefassung:',
	'todo-form-details'     => 'Einzelheite:',
	'todo-form-email'       => 'Öm en E-Mail ze krijje, wann di Opjav avjeschlosse weed, jiv Ding E-Mai Adress hee en:',
	'todo-form-submit'      => 'Loß Jonn!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'todo'                  => 'Lëscht vun den Aufgaben',
	'todo-desc'             => 'Experimentell Erweiderung mat der perséinlecher [[Special:Todo|Lëscht vun Aufgaben]]',
	'todo-tab'              => 'fir ze maachen',
	'todo-new-queue'        => 'nei',
	'todo-invalid-item'     => 'Keen oder ongëltegen Objet',
	'todo-update-else-item' => "Versuch engem anere seng Objeten z'aktualiséieren",
	'todo-item-list'        => 'Är Objeten',
	'todo-no-item'          => 'Keng Objeten op der Lëscht vun den Aufgaben.',
	'todo-list-for'         => 'Lëscht vun den Aufgabe fir',
	'todo-list-change'      => 'Änneren',
	'todo-list-cancel'      => 'Annulléieren',
	'todo-new-item'         => 'Neien Objet',
	'todo-issue-summary'    => 'Resumé vun der Aufgab:',
	'todo-form-details'     => 'Detailer:',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'todo-new-queue'    => 'പുതിയത്',
	'todo-list-change'  => 'മാറ്റം',
	'todo-list-cancel'  => 'റദ്ദാക്കുക',
	'todo-new-item'     => 'പുതിയ ഇനം',
	'todo-form-details' => 'വിശദാംശങ്ങള്‍:',
	'todo-form-submit'  => 'ചോദ്യം (query) സമര്‍പ്പിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'todo'                  => 'करण्याची यादी',
	'todo-tab'              => 'करावयाच्या गोष्टी',
	'todo-new-queue'        => 'नवे',
	'todo-mail-subject'     => '$1 च्या करावयच्या गोष्टींच्या यादीतील पूर्ण झालेल्या नोंदी',
	'todo-invalid-item'     => 'चुकीचा किंवा अस्तित्वात नसलेला आयटम',
	'todo-unrecognize-type' => 'अनोळखी प्रकार',
	'todo-item-list'        => 'तुमचे आयटेम्स',
	'todo-no-item'          => 'करावयाच्या नोंदी नाहीत.',
	'todo-invalid-owner'    => 'या आयटमचा चुकीचा मालक',
	'todo-add-queue'        => 'रांग वाढवा...',
	'todo-move-queue'       => 'रांगेमध्ये हलवा...',
	'todo-list-for'         => '(ची) करावयाच्या गोष्टींची यादी',
	'todo-list-change'      => 'बदल',
	'todo-list-cancel'      => 'रद्द करा',
	'todo-new-item'         => 'नवीन नोंद',
	'todo-issue-summary'    => 'चर्चा सारांश:',
	'todo-form-details'     => 'तपशील:',
	'todo-form-submit'      => 'पृच्छा पाठवा',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'todo-list-cancel' => 'Ticcuepāz',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'todo'              => 'Opgavenlist',
	'todo-tab'          => 'Opgaven',
	'todo-new-queue'    => 'nee',
	'todo-no-item'      => 'Nix op de Opgavenlist.',
	'todo-list-for'     => 'Opgavenlist för',
	'todo-list-change'  => 'Ännern',
	'todo-list-cancel'  => 'Afbreken',
	'todo-new-item'     => 'Ne’e Opgaav',
	'todo-form-details' => 'Details:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 * @author GerardM
 */
$messages['nl'] = array(
	'todo'                  => 'Takenlijst',
	'todo-desc'             => 'Experimentele uitbreiding voor een persoonlijke [[Special:Todo|takenlijst]]',
	'todo-tab'              => 'taken',
	'todo-new-queue'        => 'nieuw',
	'todo-mail-subject'     => 'Afgerond actiepunt op actielijst $1',
	'todo-mail-body'        => 'U hebt gevraagd om een waarschuwing bij het sluiten van een actiepunt op de actielijst van $1.

Onderwerp: $2
Geopend: $3

Dit onderwerp is nu gemarkeerd als afgerond, met de volgende opmerking:
$4',
	'todo-invalid-item'     => 'Missend of ongeldig item',
	'todo-update-else-item' => 'Bezig met het bijwerken van de punten van iemand anders',
	'todo-unrecognize-type' => 'Onherkend type',
	'todo-user-invalide'    => 'Aan dit actiepunt hangt een gebruiker die een onjuiste naam heeft, niet bestaat, of geen gebruik kan maken van actiepunten.',
	'todo-item-list'        => 'Uw items',
	'todo-no-item'          => 'Geen tedoen-items.',
	'todo-invalid-owner'    => 'Ongeldige eigenaar voor dit item',
	'todo-add-queue'        => 'Wachtrij toevoegen…',
	'todo-move-queue'       => 'Verplaats naar wachtrij…',
	'todo-list-for'         => 'Takenlijst voor',
	'todo-list-change'      => 'Wijzigen',
	'todo-list-cancel'      => 'Annuleren',
	'todo-new-item'         => 'Nieuw item',
	'todo-issue-summary'    => 'Samenvatting onderwerp:',
	'todo-form-details'     => 'Details:',
	'todo-form-email'       => 'Voer hier uw e-mailadres in om een melding te krijgen als dit onderwerp wordt gesloten:',
	'todo-form-submit'      => 'Zoekopdracht uitvoeren',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'todo-new-queue'    => 'ny',
	'todo-list-cancel'  => 'Avbryt',
	'todo-form-details' => 'Detaljar:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'todo'                  => 'Oppgaveliste',
	'todo-desc'             => 'Eksperimentell personlig utvidelse for [[Special:Todo|oppgavelister]].',
	'todo-tab'              => 'oppgaver',
	'todo-new-queue'        => 'ny',
	'todo-mail-subject'     => 'Fullførte oppgave på $1s oppgaveliste',
	'todo-mail-body'        => 'Du ba om en e-postbekreftelse om fullføringen av en oppgave på $1s oppgaveliste.

Oppgave: $2
Fullført: $3

Oppgaven er merket som fullført, med denne kommentaren:
$4',
	'todo-invalid-item'     => 'Manglende eller ugyldig oppgave',
	'todo-update-else-item' => 'Prøver å oppdatere en annen persons oppgaver',
	'todo-unrecognize-type' => 'Type ikke gjenkjent',
	'todo-user-invalide'    => 'Oppgaven gitt til ugydlig, manglende eller upassende bruker.',
	'todo-item-list'        => 'Dine oppgaver',
	'todo-no-item'          => 'Ingen oppgaver.',
	'todo-invalid-owner'    => 'Ugyldig oppgaveeier.',
	'todo-add-queue'        => 'Legg til kø…',
	'todo-move-queue'       => 'Flytt til kø…',
	'todo-list-for'         => 'Oppgaveliste for',
	'todo-list-change'      => 'Endre',
	'todo-list-cancel'      => 'Avbryt',
	'todo-new-item'         => 'Ny oppgave',
	'todo-issue-summary'    => 'Sammendrag:',
	'todo-form-details'     => 'Detaljer:',
	'todo-form-email'       => 'Skriv inn e-postadressen din her for å mottå beskjed på e-post når oppgaven er fullført:',
	'todo-form-submit'      => 'Utfør',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'todo'                  => "Lista dels prètzfaches d'executar",
	'todo-desc'             => 'Extension experimentala d’una [[Special:Todo|lista personala de prètzfaches de realizar]]',
	'todo-tab'              => 'de far',
	'todo-new-queue'        => 'Novèl',
	'todo-mail-subject'     => 'Article acabat sus la lista dels prètzfaches de $1',
	'todo-mail-body'        => "Avètz demandat la confirmacion per corrièr electronic per çò que concernís l'acabament d'un article qu'aviatz sus la lista dels preètzfaches de $1. Article : $2 Somes : $3 Aqueste article es estat marcat coma acabat amb lo comentari seguent : $4",
	'todo-invalid-item'     => 'Article mancant o invalid',
	'todo-update-else-item' => "Temptativa de metre a jorn los articles de qualqu'un d'autre",
	'todo-unrecognize-type' => 'Tipe pas reconegut',
	'todo-user-invalide'    => 'Prètzfach de far invalid, mancant, o utilizaire disposant pas dels dreches necessaris per aquò.',
	'todo-item-list'        => 'Vòstres articles',
	'todo-no-item'          => "Cap de prètzfach d'executar pas",
	'todo-invalid-owner'    => "Proprietari d'aqueste article invalid",
	'todo-add-queue'        => 'Apondre a la coa…',
	'todo-move-queue'       => 'Desplaçar vèrs la coa…',
	'todo-list-for'         => "Lista dels prètzfaches d'executar per",
	'todo-list-change'      => 'Modificar',
	'todo-list-cancel'      => 'Anullar',
	'todo-new-item'         => 'Article novèl',
	'todo-issue-summary'    => 'Resumit brèu :',
	'todo-form-details'     => 'Precisions :',
	'todo-form-email'       => 'Per recebre las notificacions per corrièr electronic un còp l’article clausurat, inscrivissètz vòstra adreça dins lo quadre çaijós :',
	'todo-form-submit'      => 'Sometre la requèsta',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Wpedzich
 * @author McMonster
 */
$messages['pl'] = array(
	'todo'                  => 'Lista zadań do wykonania',
	'todo-desc'             => 'Eksperymentalne rozszerzenie udostępniające osobistą [[Special:Todo|listę zadań do wykonania]]',
	'todo-tab'              => 'zadania',
	'todo-new-queue'        => 'nowe',
	'todo-mail-subject'     => 'Zamknięto pozycję na liście zadań użytkownika $1',
	'todo-mail-body'        => 'Zaznaczyłeś opcję poinformowania Cię o zakończeniu czynności, którą dodałeś do listy zadań użytkownika $1 w trybie online.

Pozycja: $2
Przesłano: $3

Pozycję oznaczono jako wykonaną z następującym komentarzem:
$4',
	'todo-invalid-item'     => 'Nieprawidłowa lub nieistniejąca pozycja',
	'todo-update-else-item' => 'Próba uaktualnienia listy pozycji innego użytkownika',
	'todo-unrecognize-type' => 'Nie rozpoznano typu',
	'todo-user-invalide'    => 'Podano nieprawidłową lub nieistniejącą nazwę użytkownika, albo użytkownik nie jest w stanie wykorzystywać funkcji zadań do wykonania.',
	'todo-item-list'        => 'Twoje zadania',
	'todo-no-item'          => 'Brak wpisów na liście zadań do wykonania.',
	'todo-invalid-owner'    => 'Właściciel tego zadania jest nieprawidłowy',
	'todo-add-queue'        => 'Dodaj kolejkę…',
	'todo-move-queue'       => 'Przesuń do kolejki…',
	'todo-list-for'         => 'Lista zadań dla',
	'todo-list-change'      => 'Zmień',
	'todo-list-cancel'      => 'Anuluj',
	'todo-new-item'         => 'Nowa pozycja',
	'todo-issue-summary'    => 'Podsumowanie kwestii:',
	'todo-form-details'     => 'Szczegóły:',
	'todo-form-email'       => 'Jeśli chcesz otrzymać powiadomienie pocztą elektroniczna po zamknięciu tej pozycji, wpisz w polu poniżej swój adres e-mail:',
	'todo-form-submit'      => 'Wyślij zapytanie',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'todo-new-queue' => 'نوی',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'todo'                  => 'Lista de tarefas',
	'todo-tab'              => 'tarefas',
	'todo-new-queue'        => 'novo',
	'todo-mail-subject'     => 'Itens completos na lista de tarefas de $1',
	'todo-invalid-item'     => 'Item em falta ou inválido',
	'todo-unrecognize-type' => 'Tipo não reconhecido',
	'todo-item-list'        => 'Seus itens',
	'todo-no-item'          => 'Sem tarefas.',
	'todo-list-for'         => 'Lista de tarefas de',
	'todo-list-change'      => 'Alterar',
	'todo-list-cancel'      => 'Cancelar',
	'todo-new-item'         => 'Novo item',
	'todo-form-details'     => 'Detalhes:',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'todo-new-queue' => 'amaynu',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'todo-list-cancel'  => 'Anulează',
	'todo-form-details' => 'Detalii:',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'todo'                  => 'Zoznam úloh',
	'todo-desc'             => 'Experimentálne rozšírenie osobný [[Special:Todo|Zoznam úloh]]',
	'todo-tab'              => 'zoznam úloh',
	'todo-new-queue'        => 'nová',
	'todo-mail-subject'     => 'Dokončená úloha zo zoznamu používateľa $1',
	'todo-mail-body'        => 'Žiadali ste o potvrdzovací email po dokončení úlohy, ktorú ste poslali do zoznamu úloh používateľa $1.

Úloha: $2
Poslaná: $3

Táto úloha bola označená ako dokončená s týmto komentárom:
$4',
	'todo-invalid-item'     => 'Chýbajúca alebo neplatná úloha',
	'todo-update-else-item' => 'Pokúšate sa aktualizovať úlohy niekoho iného',
	'todo-unrecognize-type' => 'Nerozpoznaný typ',
	'todo-user-invalide'    => 'Zadaná úloha je neplatná, chýba alebo používateľ nepoužíva zoznam úloh',
	'todo-item-list'        => 'Vaše úlohy',
	'todo-no-item'          => 'Žiadne úlohy.',
	'todo-invalid-owner'    => 'Vlastník tejto položky je neplatný',
	'todo-add-queue'        => 'Pridať front…',
	'todo-move-queue'       => 'Presunúť do frontu…',
	'todo-list-for'         => 'Zoznam úloh používateľa',
	'todo-list-change'      => 'Zmeniť',
	'todo-list-cancel'      => 'Zrušiť',
	'todo-new-item'         => 'Nová úloha',
	'todo-issue-summary'    => 'Zhrnutie problému:',
	'todo-form-details'     => 'Podrobnosti:',
	'todo-form-email'       => 'Dostať upozornenie emailom, keď bude úloha uzatvorená. Napíšte svoju adresu:',
	'todo-form-submit'      => 'Poslať požiadavku',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Lejonel
 */
$messages['sv'] = array(
	'todo'                  => 'Uppgiftslista',
	'todo-desc'             => 'Exprimentell personligt tillägg för [[Special:Todo|uppgiftslistor]].',
	'todo-tab'              => 'uppgifter',
	'todo-new-queue'        => 'ny',
	'todo-mail-subject'     => 'Slutförde uppgift på $1s uppgiftslista',
	'todo-mail-body'        => 'Du efterfrågade en e-postbekräftning om slutförningen av en uppgift på $1s uppgiftslista.

Uppgift: $2
Slutförd: $3

Uppgiften har markerats som slutförd, med den här kommentaren:
$4',
	'todo-invalid-item'     => 'Missad eller ogiltig uppgift',
	'todo-update-else-item' => 'Prövar att uppdatera en annan persons uppgifter',
	'todo-unrecognize-type' => 'Okänd typ',
	'todo-user-invalide'    => 'Uppgiften angiven som ogiltig, missad eller opassande användare.',
	'todo-item-list'        => 'Dina uppgifter',
	'todo-no-item'          => 'Inga uppgifter.',
	'todo-invalid-owner'    => 'Ogiltig ägare av uppgiften',
	'todo-add-queue'        => 'Lägg till kö…',
	'todo-move-queue'       => 'Flytta till kö…',
	'todo-list-for'         => 'Uppgiftslista för',
	'todo-list-change'      => 'Ändra',
	'todo-list-cancel'      => 'Avbryt',
	'todo-new-item'         => 'Ny uppgift',
	'todo-issue-summary'    => 'Sammandrag:',
	'todo-form-details'     => 'Detaljer:',
	'todo-form-email'       => 'Skriv in din e-postadress här för att motta meddelanden på e-post när uppgiften är slutförd:',
	'todo-form-submit'      => 'Utför',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'todo'                  => 'చేయాల్సిన జాబితా',
	'todo-new-queue'        => 'కొత్తది',
	'todo-unrecognize-type' => 'గుర్తుతెలియని రకం',
	'todo-item-list'        => 'మీ అంశాలు',
	'todo-list-change'      => 'మార్చు',
	'todo-new-item'         => 'కొత్త అంశం',
	'todo-form-details'     => 'వివరాలు:',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'todo-new-queue'        => 'нав',
	'todo-unrecognize-type' => 'Навъи ношинос',
	'todo-list-change'      => 'Тағйир',
	'todo-list-cancel'      => 'Лағв',
	'todo-new-item'         => 'Маводи ҷадид',
	'todo-issue-summary'    => 'Хулосаи амал:',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'todo-list-change' => 'เปลี่ยน',
	'todo-list-cancel' => 'ยกเลิก',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'todo-new-queue' => 'yeni',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'todo-list-cancel' => 'Bãi bỏ',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'todo-new-queue'    => 'nulik',
	'todo-list-change'  => 'Votükön',
	'todo-form-details' => 'Notets:',
);

