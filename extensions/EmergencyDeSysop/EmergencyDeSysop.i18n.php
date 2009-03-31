<?php
/**
 * Internationalisation file for extension EmergencyDeSysop.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	//About the Extension
	'emergencydesysop' => 'Emergency DeSysop',
	'emergencydesysop-desc' => 'Allows a sysop to sacrifice their own privileges, in order to desysop another',

	//Extension Messages
	'emergencydesysop-title' => 'Remove sysop access from both current user and another sysop',
	'emergencydesysop-otheradmin' => 'Other sysop to degroup',
	'emergencydesysop-reason' => 'Reason for removal',
	'emergencydesysop-submit' => 'Submit',
	'emergencydesysop-incomplete' => 'All form fields are required, please try again.',
	'emergencydesysop-notasysop' => 'The target user is not in the sysop group.',
	'emergencydesysop-nogroups' => 'None',
	'emergencydesysop-done' => 'Action complete, both you and [[$1]] have been desysopped.',
	'emergencydesysop-invalidtarget' => 'The target user does not exist.',
	'emergencydesysop-blocked' => 'You cannot access this page while blocked',
	'emergencydesysop-noright' => 'You do not have sufficient permissions to access this page',

	//Rights Messages
	'right-emergencydesysop' => 'Able to desysop another user, mutually',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author SPQRobin
 */
$messages['qqq'] = array(
	'emergencydesysop-desc' => 'Short desciption of this extension.
Shown in [[Special:Version]].
Do not translate or change tag names, or link anchors.',
	'emergencydesysop-nogroups' => '{{Identical|None}}',
	'right-emergencydesysop' => 'This is a user right description, as shown on [[Special:ListGroupRights]], e.g.',
);

/** Arabic (العربية)
 * @author Ouda
 */
$messages['ar'] = array(
	'emergencydesysop' => 'سحب الإدارة الطارئ',
	'emergencydesysop-reason' => 'سبب الحذف',
	'emergencydesysop-submit' => 'تنفيذ',
	'emergencydesysop-notasysop' => 'المستخدم المستهدف ليس في مجموعة الإداريين',
	'emergencydesysop-nogroups' => 'لا يوجد',
	'emergencydesysop-invalidtarget' => 'المستخدم المراد لا يوجد',
	'emergencydesysop-blocked' => 'لا يمكن الدخول على هذه الصفحة أثناء المنع',
	'emergencydesysop-noright' => 'لا تملك الصلاحيات الكافية للدخول على هذه الصفحة',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ouda
 */
$messages['arz'] = array(
	'emergencydesysop-reason' => 'سبب الحذف',
	'emergencydesysop-submit' => 'تنفيذ',
	'emergencydesysop-nogroups' => 'لا يوجد',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'emergencydesysop-nogroups' => 'Ništa',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Metalhead64
 * @author Purodha
 */
$messages['de'] = array(
	'emergencydesysop' => 'Not-DeSysop',
	'emergencydesysop-desc' => 'Ermöglicht einem Administrator, seine Privilegien aufzugeben, um den Adminstatus eines anderen Administrators zu entfernen',
	'emergencydesysop-title' => 'Entfernt den Sysop-Status des aktuellen und eines anderen Benutzers',
	'emergencydesysop-otheradmin' => 'Anderen Sysop zum Deklassieren',
	'emergencydesysop-reason' => 'Grund für die Entfernung',
	'emergencydesysop-submit' => 'Übertragen',
	'emergencydesysop-incomplete' => 'Es werden Eingaben in allen Feldern benötigt. Bitte erneut versuchen.',
	'emergencydesysop-notasysop' => "Der gewählte Benutzer ist nicht in der Gruppe ''Sysop''.",
	'emergencydesysop-nogroups' => 'Keine',
	'emergencydesysop-done' => 'Aktion erfolgreich. Du und [[$1]] wurden degradiert.',
	'emergencydesysop-invalidtarget' => 'Der gewählte Benutzer existiert nicht.',
	'emergencydesysop-blocked' => 'Du kannst nicht auf diese Seite zugreifen, während du gesperrt bist',
	'emergencydesysop-noright' => 'Du hast keine ausreichenden Berechtigungen für diese Seite',
	'right-emergencydesysop' => 'Das Recht zur Degradierung eines anderen Sysop auf Gegenseitigkeit',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'emergencydesysop' => 'Nuzowe wótrjaknjenje na swójski administratorowy status',
	'emergencydesysop-desc' => 'Zmóžnja administratoroju se na swóje priwilegije zbyś, aby wzeł drugemu administratoroju status administratora',
	'emergencydesysop-title' => 'Administratorowy status ako aktualnemu wužywarjeju tak teke drugemu administratoroju wześ',
	'emergencydesysop-otheradmin' => 'Drugi administrator za wótpóranje z kupki',
	'emergencydesysop-reason' => 'Pśicyna za wótpóranje',
	'emergencydesysop-submit' => 'Wótpósłaś',
	'emergencydesysop-incomplete' => 'Wše formularne póla su trěbne, pšosym wopytaj hyšći raz.',
	'emergencydesysop-notasysop' => 'Celowy wužywaŕ njejo w kupce administratorow.',
	'emergencydesysop-nogroups' => 'Žeden',
	'emergencydesysop-done' => 'Akcija dokóńcona, ako ty tak teke [[$1]] wěcej njamatej status administratora.',
	'emergencydesysop-invalidtarget' => 'Celowy wužywaŕ njeeksistěrujo.',
	'emergencydesysop-blocked' => 'Njamaš pśistup na toś ten bok měś, mjaztym až sy blokěrowany.',
	'emergencydesysop-noright' => 'Njamaš dosegajuce pšawa, aby měł pśistup na toś ten bok',
	'right-emergencydesysop' => 'Móžnosć drugemu wužywarjeju status amdministratora mjazsobnje wześ',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'emergencydesysop-reason' => 'Kialo por forigo',
	'emergencydesysop-submit' => 'Ek!',
	'emergencydesysop-nogroups' => 'Neniu',
	'emergencydesysop-invalidtarget' => 'La cela uzanto ne ekzistas.',
	'emergencydesysop-blocked' => 'Vi ne povas atingi ĉi tiun paĝon kiam forbarita',
	'emergencydesysop-noright' => 'Vi ne havas sufiĉajn rajtojn por atingi ĉi tiun paĝon',
);

/** Finnish (Suomi)
 * @author Str4nd
 */
$messages['fi'] = array(
	'emergencydesysop-invalidtarget' => 'Kohdekäyttäjää ei ole olemassa.',
);

/** French (Français)
 * @author Grondin
 */
$messages['fr'] = array(
	'emergencydesysop' => 'Désysopage d’urgence',
	'emergencydesysop-desc' => 'Permert à un administrateur de renoncer à ses propres limites, en ordre pour désysoper en autre',
	'emergencydesysop-title' => 'Retire les accès d’administreur, ensemble l’utilisateur actuel puis un autre.',
	'emergencydesysop-otheradmin' => 'Autre administrateur à dégrouper',
	'emergencydesysop-reason' => 'Motif du retrait',
	'emergencydesysop-submit' => 'Soumettre',
	'emergencydesysop-incomplete' => 'Tous les champs doivent être renseignés, veuillez essayer à nouveau.',
	'emergencydesysop-notasysop' => 'L’utilisateur visé n’est pas dans le groupe des administrateurs.',
	'emergencydesysop-nogroups' => 'Néant',
	'emergencydesysop-done' => 'Action terminée, vous et [[$1]] avez eu ensemble vos droits d’administrateur de retirés.',
	'emergencydesysop-invalidtarget' => 'L’utilisateur visé n’existe pas.',
	'emergencydesysop-blocked' => 'Vous ne pouvez pas accéder à cette page tant que vous êtes bloqué',
	'emergencydesysop-noright' => 'Vous n’avez pas les permissions suffisantes pour accéder à cette page',
	'right-emergencydesysop' => 'Possible de désysoper mutuellement un autre utilisateur.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'emergencydesysop' => 'Perda dos dereitos de administrador de emerxencia',
	'emergencydesysop-desc' => 'Permite a un administrador sacrificar os seus propios privilexios para arrebatarllos a outro',
	'emergencydesysop-title' => 'Eliminar os dereitos de administrador do usuario actual e mais os doutro',
	'emergencydesysop-otheradmin' => 'Outro administrador ao que retirar os privilexios',
	'emergencydesysop-reason' => 'Motivo para a eliminación',
	'emergencydesysop-submit' => 'Enviar',
	'emergencydesysop-incomplete' => 'Requírense todos os campos do formulario; por favor, inténteo de novo.',
	'emergencydesysop-notasysop' => 'O usuario inserido non está no grupo dos administradores.',
	'emergencydesysop-nogroups' => 'Ningún',
	'emergencydesysop-done' => 'A acción foi completada, vostede de mais "[[$1]]" perderon os seus dereitos de administrador.',
	'emergencydesysop-invalidtarget' => 'O usuario inserido non existe.',
	'emergencydesysop-blocked' => 'Non pode acceder a esta páxina mentres estea bloqueada',
	'emergencydesysop-noright' => 'Non ten os permisos suficientes para acceder a esta páxina',
	'right-emergencydesysop' => 'Capacitado para quitar, mutuamente, os permisos de administrador',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'emergencydesysop-nogroups' => 'Οὐδέν',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'emergencydesysop' => 'Hitno uklanjanje statusa',
	'emergencydesysop-desc' => 'Omogućava administratorima uklanjanje svog statusa, kako bi uklonili status drugome',
	'emergencydesysop-title' => 'Uklonite admin status sebi i drugom administratoru',
	'emergencydesysop-otheradmin' => 'Drugi administrator',
	'emergencydesysop-reason' => 'Razlog za uklanjanje',
	'emergencydesysop-submit' => 'Potvrdi',
	'emergencydesysop-incomplete' => 'Potrebno je ispuniti sva polja, pokušajte opet.',
	'emergencydesysop-notasysop' => 'Ciljani suradnik nije u skupini administratora.',
	'emergencydesysop-nogroups' => 'Ništa',
	'emergencydesysop-done' => 'Završeno, admin status je uklonjen vama i suradniku [[$1]].',
	'emergencydesysop-invalidtarget' => 'Ciljani suradnik ne postoji.',
	'emergencydesysop-blocked' => 'Ne možete pristupiti ovoj stranici dok ste blokirani.',
	'emergencydesysop-noright' => 'Nemate ovlasti za pristup ovoj stranici',
	'right-emergencydesysop' => 'Uzajamno uklanjanje admin statusa',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'emergencydesysop' => 'Nuzowe wzdaće na swójski administratorowy status',
	'emergencydesysop-desc' => 'Zmóžnja administratorej so swojich priwilegijow wzdać, zo by druhemu administratorej status administratora preč wzał',
	'emergencydesysop-title' => 'Wotstronja administratorowy status aktualneho a druheho administratora',
	'emergencydesysop-otheradmin' => 'Druhi administrator za wotstronjenje ze skupiny',
	'emergencydesysop-reason' => 'Přičina za wotstronjenje',
	'emergencydesysop-submit' => 'Wotpósłać',
	'emergencydesysop-incomplete' => 'Wšě formularne pola su trěbne, prošu spytaj hišće raz.',
	'emergencydesysop-notasysop' => 'Cilowy wužiwar njeje w skupinje administratorow.',
	'emergencydesysop-nogroups' => 'Žadyn',
	'emergencydesysop-done' => 'Akcija dokónčena, ty kaž tež [[$1]] hižo njemataj status administratora.',
	'emergencydesysop-invalidtarget' => 'Cilowy wužiwar njeeksistuje.',
	'emergencydesysop-blocked' => 'Njemóžeš na tutu stronu přistup měć, mjeztym zo sy zablokowany.',
	'emergencydesysop-noright' => 'Njemaš dosahace prawa, zo by na tutu stronu přistup měł.',
	'right-emergencydesysop' => 'Móžnosć druhemu wužiwarjej mjez sobu status administratora preč wzać',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'emergencydesysop-submit' => '送信',
	'emergencydesysop-nogroups' => 'なし',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'emergencydesysop-submit' => 'ដាក់ស្នើ',
	'emergencydesysop-nogroups' => 'គ្មាន',
	'emergencydesysop-invalidtarget' => 'មិនមាន​អ្នកប្រើប្រាស់​គោលដៅ​ទេ​។',
	'emergencydesysop-blocked' => 'អ្នក​មិន​អាច​ចូលដំណើរការ​ទំព័រ​នេះ​បាន​ទេ ខណៈ​ដែល​ត្រូវ​បាន​រាំងខ្ទប់​។',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'emergencydesysop' => '긴급 관리자 권한 해제',
	'emergencydesysop-otheradmin' => '권한을 해제할 다른 관리자',
	'emergencydesysop-submit' => '확인',
	'emergencydesysop-done' => '명령 완료, 당신과 [[$1]] 사용자는 관리자 권한이 해제되었습니다.',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'emergencydesysop' => 'Notfall — ene dorschjedriehte WikiKöbes erus schmiiße',
	'emergencydesysop-desc' => 'Määt et för Nuutfäll müjjelesch, zwei WikiKöbes op eimol erus schmiiße, sesch sellver, un eine dorschjedriehte Kolleje.',
	'emergencydesysop-title' => 'Nemmp däm Metmaacher sellver un enem andere de Rääschte fun enem WikiKöbes fott.',
	'emergencydesysop-otheradmin' => 'Dä andere, öm en uß dä Jrup „{{int:group-sysop}}“ eruß ze nämme',
	'emergencydesysop-reason' => 'Dä Jrund för et Rußschmiiße',
	'emergencydesysop-submit' => 'Loß Jonn!',
	'emergencydesysop-incomplete' => 'Do moß en jedes Feld en dämm Fommulaa jet enjävve!',
	'emergencydesysop-notasysop' => 'Dä Metmaacher es jaa nit en dä Jopp „{{int:group-sysop}}“.',
	'emergencydesysop-nogroups' => 'Keine',
	'emergencydesysop-done' => 'Dat hät jefupp, dä [[$1]] un Du, Ühr sid jetz kein {{int:group-sysop}} mieh.',
	'emergencydesysop-invalidtarget' => 'Esu ene Metmaacher ham_mer nit.',
	'emergencydesysop-blocked' => 'Dat kanns De nit maache, esu lang wi De jespertt bes.',
	'emergencydesysop-noright' => 'Do häs nit dat Rääsch, op die Sigg ze jonn.',
	'right-emergencydesysop' => 'Kann enem andere Wiki-Köbes däm sing Rääsch affnämme.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'emergencydesysop' => "Noutprozedur fir d'Adminrechter ewechzehuelen",
	'emergencydesysop-desc' => "Erlaabt et engem Administrateur seng eege REchter z'opferen fir engem Anere seng Adminrechter ewechzehuelen",
	'emergencydesysop-title' => "D'Administrateursrechter esouwuel dem aktuelle Benotzer wéi och engem aneren Adminstrateur ewechhuelen.",
	'emergencydesysop-otheradmin' => "Aneren Administrateur fir d'Adminrechter ewechzehuelen",
	'emergencydesysop-reason' => "Grond fir d'Ewechhuelen",
	'emergencydesysop-submit' => 'Späicheren',
	'emergencydesysop-incomplete' => "All d'Felder vum Formulaire mussen ausgefëllt sinn, versicht et w.e.g. nach eng Kéier.",
	'emergencydesysop-notasysop' => 'De gewielt Benotzer ass net am Grupp vun den Administrateuren.',
	'emergencydesysop-nogroups' => 'Keen',
	'emergencydesysop-done' => "Aktioun ofgeschloss, esouwuel Dir wéi och de Benotzer [[$1]] kruten d'Administraeursrechter ofgeholl.",
	'emergencydesysop-invalidtarget' => 'De gewielte Benotzer gëtt et net.',
	'emergencydesysop-blocked' => 'Dir kënnt net op dës Säit goen esoulaang wann Dir gespaart sidd',
	'emergencydesysop-noright' => 'Dir hutt net genuch Rechter fir op dës Säit ze goen',
	'right-emergencydesysop' => "Kann engem anere Benotzer d'Administrateursrechter ofhuele, géigesäiteg",
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'emergencydesysop' => 'Beheerdersrechten snel intrekken',
	'emergencydesysop-desc' => 'Stelt een beheerder in staat de eigen beheerdersrechten op te offeren om die van een andere beheerder in te trekken',
	'emergencydesysop-title' => 'De beheerdersrechten van zowel de huidige gebruiker als een andere beheerder intrekken',
	'emergencydesysop-otheradmin' => 'Beheerdersschap intrekken van',
	'emergencydesysop-reason' => 'Reden',
	'emergencydesysop-submit' => 'OK',
	'emergencydesysop-incomplete' => 'Alle velden zijn verplicht.',
	'emergencydesysop-notasysop' => 'De opgegeven gebruiker is geen beheerder.',
	'emergencydesysop-nogroups' => 'Geen',
	'emergencydesysop-done' => 'Handeling voltooid, de beheerdersrechten van zowel u als [[$1]] is ingetrokken.',
	'emergencydesysop-invalidtarget' => 'De opgegeven gebruiker bestaat niet.',
	'emergencydesysop-blocked' => 'U kunt deze pagina niet gebruiken omdat u geblokkeerd bent',
	'emergencydesysop-noright' => 'U hebt niet de nodige rechten om deze pagina te kunnen gebruiken',
	'right-emergencydesysop' => 'In staat om de beheerdersrechten van een andere gebruiker en zichzelf in te trekken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'emergencydesysop' => 'Nødsfallavsetjing av administrator',
	'emergencydesysop-desc' => 'Gjer det mogleg for ein administrator å ofra sine eigne privilegium for å avsetja ein annan administrator',
	'emergencydesysop-title' => 'Fjern administratorrettane til både den aktuelle brukaren og ein annan administrator.',
	'emergencydesysop-otheradmin' => 'Annan administrator som skal verta avsett',
	'emergencydesysop-reason' => 'Årsak for avsetjing',
	'emergencydesysop-submit' => 'Utfør',
	'emergencydesysop-incomplete' => 'All skjemafelta må verta fylte ut; prøv om att.',
	'emergencydesysop-notasysop' => 'Målbrukaren er ikkje ein administrator.',
	'emergencydesysop-nogroups' => 'Ingen',
	'emergencydesysop-done' => 'Handlinga har vorte gjennomført; både du og [[$1]] har mista administratorrettane.',
	'emergencydesysop-invalidtarget' => 'Målbrukaren finst ikkje',
	'emergencydesysop-blocked' => 'Du har ikkje tilgjenge til denne sida so lenge du er blokkert.',
	'emergencydesysop-noright' => 'Du har ikkje dei rette rettane til å få tilgjenge til denne sida.',
	'right-emergencydesysop' => 'Kan avsetja seg sjølv og ein annan administrator',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'emergencydesysop' => 'Desysopatge d’urgéncia',
	'emergencydesysop-desc' => 'Permet a un administrator de renonciar a sos pròpris limits, en òrdre per desysopar en autre',
	'emergencydesysop-title' => 'Leva los accèsses d’administrer, ensemble l’utilizaire actual puèi un autre.',
	'emergencydesysop-otheradmin' => 'Autre administrator de desgropar',
	'emergencydesysop-reason' => 'Motiu de levament',
	'emergencydesysop-submit' => 'Sometre',
	'emergencydesysop-incomplete' => 'Totes los camps devon èsser entresenhats, ensajatz tornamai.',
	'emergencydesysop-notasysop' => 'L’utilizaire visat es pas dins lo grop dels administrators.',
	'emergencydesysop-nogroups' => 'Nonrés',
	'emergencydesysop-done' => "Accion acabada, vos e [[$1]] avètz agut vòstres dreches d’administrator levats a l'encòp.",
	'emergencydesysop-invalidtarget' => 'L’utilizaire visat existís pas.',
	'emergencydesysop-blocked' => 'Podètz pas accedir a aquesta page tant que sètz blocat(ada)',
	'emergencydesysop-noright' => 'Avètz pas las permissions sufisentas per accedir a aquesta pagina',
	'right-emergencydesysop' => 'Possible de desysopar mutualament un autre utilizaire.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'emergencydesysop-nogroups' => 'هېڅ',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'emergencydesysop-reason' => 'Motiv pentru ştergere',
	'emergencydesysop-invalidtarget' => 'Utilizatorul ţintă nu există.',
);

/** Russian (Русский)
 * @author Rubin
 */
$messages['ru'] = array(
	'emergencydesysop-reason' => 'Причина удаления',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'emergencydesysop' => 'Núdzové odobratie správcovských práv',
	'emergencydesysop-desc' => 'Umožňuje správcovi obetovať vlastné práva, aby mohol odobrať práva inému',
	'emergencydesysop-title' => 'Odobrať práva správcu aktuálneho používateľa a iného správcu zároveň',
	'emergencydesysop-otheradmin' => 'Druhý správca',
	'emergencydesysop-reason' => 'Dôvod odstránenia',
	'emergencydesysop-submit' => 'Odoslať',
	'emergencydesysop-incomplete' => 'Je potrebné vyplniť všetky polia formulára, skúste to prosím znova.',
	'emergencydesysop-notasysop' => 'Cieľový používateľ nie je v skupine správcov.',
	'emergencydesysop-nogroups' => 'Žiadny',
	'emergencydesysop-done' => 'Operácia dokončená, vy aj [[$1]] ste boli zbavení správcovských práv.',
	'emergencydesysop-invalidtarget' => 'Cieľový používateľ neexistuje.',
	'emergencydesysop-blocked' => 'Nemáte prístup k tejto stránke, kým ste zablokovaný',
	'emergencydesysop-noright' => 'Nemáte dostatočné oprávnenie na prístup k tejto stránke',
	'right-emergencydesysop' => 'Dokáže odstrániť správcovské práva iného používateľa zároveň so svojimi',
);

/** Swedish (Svenska)
 * @author Micke
 */
$messages['sv'] = array(
	'emergencydesysop' => 'Nödfallsavsättning av administratör',
	'emergencydesysop-desc' => 'Möjliggör för en administratör att offra sina egna användarrättigheter för att avsätta en annan administratör',
	'emergencydesysop-title' => 'Ta bort administratörs-rättigheter från såväl den aktuella användaren som från en annan administratör',
	'emergencydesysop-otheradmin' => 'Annan administratör att avsätta',
	'emergencydesysop-reason' => 'Anledning till avsättandet',
	'emergencydesysop-submit' => 'Skicka',
	'emergencydesysop-incomplete' => 'Alla formulärfält måste fyllas i, försök igen.',
	'emergencydesysop-notasysop' => 'Målanvändaren är inte medlem i gruppen administratörer.',
	'emergencydesysop-nogroups' => 'Ingen',
	'emergencydesysop-done' => 'Handlingen är genomförd, både du och [[$1]] har tagits bort från gruppen "administratörer".',
	'emergencydesysop-invalidtarget' => 'Målanvändaren finns inte.',
	'emergencydesysop-blocked' => 'Du har inte tillgång till denna sida så länge du är blockerad',
	'emergencydesysop-noright' => 'Du har inte tillräckliga rättigheter för att få tillgång till denna sida',
	'right-emergencydesysop' => 'Möjlighet att ömsesidigt avsätta en annan användare',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'emergencydesysop-reason' => 'తొలగింపునకు కారణం',
	'emergencydesysop-submit' => 'దాఖలుచెయ్యి',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'emergencydesysop-desc' => '允许管理员牺牲他们的特权，免除另一名管理员的权限。',
	'emergencydesysop-reason' => '移除理由',
	'emergencydesysop-notasysop' => '目标用户不在管理员群组中。',
	'emergencydesysop-invalidtarget' => '目标用户不存在。',
	'emergencydesysop-blocked' => '您在封禁期内不能访问此页',
	'emergencydesysop-noright' => '您没有足够权限访问本页',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'emergencydesysop-desc' => '容許管理員犧牲他們的特權，免除另一名管理員的權限。',
	'emergencydesysop-reason' => '移除理由',
	'emergencydesysop-notasysop' => '目標使用者不在管理員群組中。',
	'emergencydesysop-invalidtarget' => '目標使用者不存在',
	'emergencydesysop-blocked' => '您在封禁期內不能存取本頁',
	'emergencydesysop-noright' => '您沒有足夠權限存取本頁',
);

