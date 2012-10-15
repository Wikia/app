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
	'emergencydesysop-desc' => 'Allows an administrator to sacrifice own privileges in order to desysop another administrator',

	//Extension Messages
	'emergencydesysop-title' => 'Remove administrator access from both current user and another administrator',
	'emergencydesysop-otheradmin' => 'Other administrator to degroup',
	'emergencydesysop-reason' => 'Reason for removal',
	'emergencydesysop-submit' => 'Submit',
	'emergencydesysop-incomplete' => 'All form fields are required, please try again.',
	'emergencydesysop-notasysop' => 'The target user is not in the administrator group.',
	'emergencydesysop-nogroups' => 'None',
	'emergencydesysop-done' => 'Action complete, both you and [[$1]] have been desysopped.',
	'emergencydesysop-invalidtarget' => 'The target user does not exist.',
	'emergencydesysop-blocked' => 'You cannot access this page while blocked',
	'emergencydesysop-noright' => 'You do not have sufficient permissions to access this page',

	//Rights Messages
	'right-emergencydesysop' => 'Able to desysop another user, mutually',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author Purodha
 * @author SPQRobin
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'emergencydesysop-desc' => '{{desc}}',
	'emergencydesysop-submit' => '{{Identical|Submit}}',
	'emergencydesysop-nogroups' => '{{Identical|None}}',
	'right-emergencydesysop' => '{{doc-right|emergencydesysop}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'emergencydesysop-submit' => 'Dien in',
	'emergencydesysop-nogroups' => 'Geen',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'emergencydesysop-submit' => 'Ninviar',
	'emergencydesysop-nogroups' => 'Garra',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'emergencydesysop' => 'سحب الإدارة الطارئ',
	'emergencydesysop-desc' => 'يسمح لإداري بالتضحية بصلاحياته، في سبيل عزل آخر',
	'emergencydesysop-title' => 'إزالة صلاحيات الإدارة من المستخدم الحالي ومدير نظام آخر معا',
	'emergencydesysop-otheradmin' => 'مدير النظام الآخر لإزالته من المجموعة',
	'emergencydesysop-reason' => 'سبب الحذف',
	'emergencydesysop-submit' => 'أرسل',
	'emergencydesysop-incomplete' => 'كل حقول الاستمارة مطلوبة، من فضلك حاول مرة ثانية.',
	'emergencydesysop-notasysop' => 'المستخدم المستهدف ليس في مجموعة الإداريين',
	'emergencydesysop-nogroups' => 'لا يوجد',
	'emergencydesysop-done' => 'الفعل اكتمل، كلا منك و [[$1]] تم عزله.',
	'emergencydesysop-invalidtarget' => 'المستخدم المراد غير موجود.',
	'emergencydesysop-blocked' => 'لا يمكن الدخول على هذه الصفحة أثناء المنع',
	'emergencydesysop-noright' => 'لا تملك الصلاحيات الكافية للدخول على هذه الصفحة',
	'right-emergencydesysop' => 'القدرة على عزل مستخدم آخر، بشكل متبادل',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'emergencydesysop-submit' => 'ܫܕܪ',
	'emergencydesysop-nogroups' => 'ܠܐ ܡܕܡ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ouda
 * @author Ramsis II
 */
$messages['arz'] = array(
	'emergencydesysop' => 'سحب الإدارة الطارئ',
	'emergencydesysop-desc' => 'يسمح لإدارى بالتضحية بصلاحياته، فى سبيل عزل آخر',
	'emergencydesysop-title' => 'إزالة صلاحيات الإدارة من المستخدم الحالى ومدير نظام آخر معا',
	'emergencydesysop-otheradmin' => 'مدير النظام الآخر لإزالته من المجموعة',
	'emergencydesysop-reason' => 'سبب الحذف',
	'emergencydesysop-submit' => 'تنفيذ',
	'emergencydesysop-incomplete' => 'كل الفراغات اللى فى الاستماره لازم تتملى. لو سمحت تحاول تانى',
	'emergencydesysop-notasysop' => 'اليوزر المستهدف مش عضو فى مجموعة السيسوبات',
	'emergencydesysop-nogroups' => 'لا يوجد',
	'emergencydesysop-done' => 'الفعل اكتمل، كلا منك و [[$1]] تم عزله.',
	'emergencydesysop-invalidtarget' => 'المستخدم المراد لا يوجد',
	'emergencydesysop-blocked' => 'لا يمكن الدخول على هذه الصفحة أثناء المنع',
	'emergencydesysop-noright' => 'انت ما عندكش التصاريح اللازمه عشان تدخل الصفحه دى',
	'right-emergencydesysop' => 'القدرة على عزل مستخدم آخر، بشكل متبادل',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Wertuose
 */
$messages['az'] = array(
	'emergencydesysop-submit' => 'Təsdiq et',
	'emergencydesysop-nogroups' => 'Heç biri',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'emergencydesysop' => 'Тэрміновае пазбаўленьне правоў адміністратара',
	'emergencydesysop-desc' => 'Дазваляе адміністратару ахвяраваць сваімі правамі для тэрміновага пазбаўленьне правоў іншага адміністратара',
	'emergencydesysop-title' => 'Пазбаўленьне правоў адміністратара цяперашняга удзельніка і іншага адміністратара',
	'emergencydesysop-otheradmin' => 'Іншы адміністратар, які будзе пазбаўлены правоў',
	'emergencydesysop-reason' => 'Прычына пазбаўленьня правоў адміністратара',
	'emergencydesysop-submit' => 'Пазбавіць правоў адміністратара',
	'emergencydesysop-incomplete' => 'Усе палі формы павінны быць запоўнены. Калі ласка, паспрабуйце зноў.',
	'emergencydesysop-notasysop' => 'Пазначаны ўдзельнік не зьяўляецца адміністратарам.',
	'emergencydesysop-nogroups' => 'Няма',
	'emergencydesysop-done' => 'Апэрацыя скончаная, Вы і [[$1]] былі пазбаўлены правоў адміністратара.',
	'emergencydesysop-invalidtarget' => 'Мэтавы ўдзельнік не існуе.',
	'emergencydesysop-blocked' => 'Вы ня маеце доступу да гэтай старонкі, пакуль Вы заблякаваны',
	'emergencydesysop-noright' => 'Вы ня маеце адпаведных правоў для доступу да гэтай старонкі',
	'right-emergencydesysop' => 'магчымасьць пазбаўленьня правоў адміністратара іншых удзельнікаў, коштам уласных правоў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'emergencydesysop-reason' => 'Причина за отстраняването',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'emergencydesysop' => 'জরুরী প্রশাসকত্ব বাতিল',
	'emergencydesysop-reason' => 'বাদ দেওয়ার কারণ',
	'emergencydesysop-submit' => 'জমা দাও',
	'emergencydesysop-incomplete' => 'সকল অংশ পূরণ করতে হবে, অনুগ্রহ করে আবার চেষ্টা করুন।',
	'emergencydesysop-notasysop' => 'লক্ষ্য ব্যবহারকারী প্রশাসক দলে নেই।',
	'emergencydesysop-nogroups' => 'কিছু নয়',
	'emergencydesysop-done' => 'অ্যাকশন সম্পূর্ণ, আপনি ও [[$1]] উভয়ের প্রশাসকত্বই বাতিল করা হয়েছে।',
	'emergencydesysop-invalidtarget' => 'লক্ষ্য ব্যবহারকারী নেই।',
	'emergencydesysop-blocked' => 'বাধাদানকৃত অবস্থায় আপনি এই পাতায় প্রবেশ করতে পারবেন না',
	'emergencydesysop-noright' => 'এই পাতায় প্রবেশ করার মত যথেষ্ট অনুমতি আপনার নেই',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'emergencydesysop' => 'Lemel gwirioù merour war-zifrae',
	'emergencydesysop-desc' => "Reiñ a ra an tu d'ur merour da aberzhiñ e wirioù merañ dezhañ e-unan evit gallout lemel kuit gwirioù ur merour all",
	'emergencydesysop-title' => 'Lemel a ra ar statud merour evit an implijer red hag un merour all war an hevelep tro',
	'emergencydesysop-otheradmin' => 'Merourien all da zistrollañ',
	'emergencydesysop-reason' => 'Abeg evit lemel',
	'emergencydesysop-submit' => 'Kas',
	'emergencydesysop-incomplete' => 'Rekis eo holl vaeziennoù ar furmskrid, esaeit en-dro mar plij.',
	'emergencydesysop-notasysop' => "An implijer buket n'emañ ket er strollad merañ.",
	'emergencydesysop-nogroups' => 'Hini ebet',
	'emergencydesysop-done' => 'Obererezh echuet, tennet eo bet ho kwirioù merour ha re [[$1]].',
	'emergencydesysop-invalidtarget' => "N'eus ket eus an implijer buket.",
	'emergencydesysop-blocked' => "N'hallit ket gwelet ar bajenn-mañ e-keit ha ma'z oc'h stanket",
	'emergencydesysop-noright' => "N'hoc'h eus ket aotreoù a-walc'h evit mont d'ar bajenn-mañ",
	'right-emergencydesysop' => 'Posupl lemel gwirioù merour un implijer all en ur goll gwirioù an-unan',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'emergencydesysop' => 'Uklanjanje sysop prava u nuždi',
	'emergencydesysop-desc' => 'Omogućuje administratoru da žrtvuje vlastite privilegije da bi uklonio administratorske privilegije drugom administratoru',
	'emergencydesysop-title' => 'Uklanjanje administratorskog pristupa za trenutnog korisnika i drugog administratora',
	'emergencydesysop-otheradmin' => 'Drugi administrator za degrupiranje',
	'emergencydesysop-reason' => 'Razlog za uklanjanje',
	'emergencydesysop-submit' => 'Pošalji',
	'emergencydesysop-incomplete' => 'Sva polja u obrascu su obavezna, molimo pokušajte ponovno.',
	'emergencydesysop-notasysop' => 'Ciljni korisnik nije u grupi administratora.',
	'emergencydesysop-nogroups' => 'Ništa',
	'emergencydesysop-done' => 'Akcija završena, Vi i [[$1]] više niste administratori.',
	'emergencydesysop-invalidtarget' => 'Ciljni korisnik ne postoji.',
	'emergencydesysop-blocked' => 'Ne možete pristupiti ovoj stranici dok ste blokirani',
	'emergencydesysop-noright' => 'Nemate dovoljno privilegija da pristupite ovoj stranici',
	'right-emergencydesysop' => 'mogućnost da administratori međusobno uklone svoja administratorska prava',
);

/** Catalan (Català)
 * @author Paucabot
 * @author Solde
 */
$messages['ca'] = array(
	'emergencydesysop-submit' => 'Envia',
	'emergencydesysop-incomplete' => 'Tots els camps del formulari són obligatoris, tornau-ho a provar.',
	'emergencydesysop-nogroups' => 'Cap',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'emergencydesysop-submit' => 'ناردن',
);

/** Czech (Česky)
 * @author Jkjk
 */
$messages['cs'] = array(
	'emergencydesysop' => 'Nouzové odstranění práv správce',
	'emergencydesysop-desc' => 'Umožňuje správci obětovat svoje vlastní práva, když je chce odebrat jinému správci',
	'emergencydesysop-title' => 'Odebrat práva správce aktuálnímu a jinému správci',
	'emergencydesysop-reason' => 'Důvod odebrání',
	'emergencydesysop-submit' => 'Odeslat',
	'emergencydesysop-incomplete' => 'Všechna pole formuláře jsou povinná, zkuste to znovu.',
	'emergencydesysop-notasysop' => 'Cílový uživatel není správcem.',
	'emergencydesysop-nogroups' => 'Nic',
	'emergencydesysop-done' => 'Operace dokončena, vy i [[$1]] už nejste správci.',
	'emergencydesysop-invalidtarget' => 'Cílový uživatel neexistuje.',
	'emergencydesysop-blocked' => 'Nemáte přístup na tuto stránku, protože jste zablokován.',
	'emergencydesysop-noright' => 'Nemáte dostatenčné oprávnění pro přístup k této stránce',
	'right-emergencydesysop' => 'Může odstranit práva správce jinému zároveň se svými',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Kghbln
 * @author Metalhead64
 * @author Purodha
 * @author Umherirrender
 */
$messages['de'] = array(
	'emergencydesysop' => 'Not-DeAdministrierung',
	'emergencydesysop-desc' => 'Ermöglicht einem Administrator, seine Privilegien aufzugeben, um den Adminstatus eines anderen Administrators zu entfernen',
	'emergencydesysop-title' => 'Entfernt den Administrator-Status des aktuellen und eines anderen Benutzers',
	'emergencydesysop-otheradmin' => 'Anderen Administrator zum Deklassieren',
	'emergencydesysop-reason' => 'Grund für die Entfernung',
	'emergencydesysop-submit' => 'Speichern',
	'emergencydesysop-incomplete' => 'Es werden Eingaben in allen Feldern benötigt. Bitte erneut versuchen.',
	'emergencydesysop-notasysop' => "Der gewählte Benutzer ist nicht in der Gruppe ''Administrator''.",
	'emergencydesysop-nogroups' => 'Keine',
	'emergencydesysop-done' => 'Aktion erfolgreich. Du und [[$1]] wurden degradiert.',
	'emergencydesysop-invalidtarget' => 'Der gewählte Benutzer existiert nicht.',
	'emergencydesysop-blocked' => 'Du kannst nicht auf diese Seite zugreifen, während du gesperrt bist',
	'emergencydesysop-noright' => 'Du hast nicht die erforderliche Berechtigung, um diese Seite aufrufen zu können.',
	'right-emergencydesysop' => 'Degradierung eines anderen Administrator auf Gegenseitigkeit',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'emergencydesysop-done' => 'Aktion erfolgreich. Sie und [[$1]] wurden degradiert.',
	'emergencydesysop-blocked' => 'Sie können nicht auf diese Seite zugreifen, während Sie gesperrt sind',
	'emergencydesysop-noright' => 'Sie haben nicht die erforderliche Berechtigung, um diese Seite aufrufen zu können.',
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

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'emergencydesysop' => 'Επείγουσα αφαίρεση δικαιωμάτων διαχειριστή',
	'emergencydesysop-reason' => 'Αιτία για την αφαίρεση:',
	'emergencydesysop-submit' => 'Υποβολή',
	'emergencydesysop-nogroups' => 'Κανένα',
	'emergencydesysop-invalidtarget' => 'Ο συγκεκριμένος χρήστης δεν υπάρχει.',
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

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author Sanbec
 */
$messages['es'] = array(
	'emergencydesysop' => 'Supresión de emergencia del privilegio de administrador',
	'emergencydesysop-desc' => 'Permite a un administrador sacrificar sus propios privilegios para retirar los privilegios de otro administrador',
	'emergencydesysop-title' => 'Suprimir el acceso de administrador del usuario actual y del otro administrador',
	'emergencydesysop-otheradmin' => 'Nombre del otro administrador',
	'emergencydesysop-reason' => 'Razones para remoción',
	'emergencydesysop-submit' => 'Enviar',
	'emergencydesysop-incomplete' => 'Todos los campos son requeridos, por favor, inténtalo de nuevo.',
	'emergencydesysop-notasysop' => 'El usuario objetivo no está en el grupo administrador.',
	'emergencydesysop-nogroups' => 'Ninguno',
	'emergencydesysop-done' => 'Acción realizada, ambos, usted y [[$1]] han perdido sus privilegios de administrador.',
	'emergencydesysop-invalidtarget' => 'El usuario objetivo no existe.',
	'emergencydesysop-blocked' => 'No puede acceder a esta página mientras esté bloqueado',
	'emergencydesysop-noright' => 'No tiene los permisos necesarios para acceder a esta página',
	'right-emergencydesysop' => 'Capáz de retirar los privilegios de administrador a otro usuario, perdiendo el suyo propio.',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'emergencydesysop-reason' => 'Ezabatzeko arrazoia',
	'emergencydesysop-submit' => 'Bidali',
	'emergencydesysop-nogroups' => 'Bat ere ez',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'emergencydesysop' => 'Ylläpitäjyyden hätäpoisto',
	'emergencydesysop-desc' => 'Mahdollistaa ylläpitäjän uhraamaan omat oikeutensa poistaakseen ylläpitäjän oikeudet toiselta ylläpitäjältä.',
	'emergencydesysop-title' => 'Poista ylläpitäjän oikeudet sekä nykyiseltä käyttäjältä että toiselta ylläpitäjältä',
	'emergencydesysop-otheradmin' => 'Ryhmästä poistettava toinen ylläpitäjä',
	'emergencydesysop-reason' => 'Poiston syy',
	'emergencydesysop-submit' => 'Lähetä',
	'emergencydesysop-incomplete' => 'Kaikki kentät ovat pakollisia, yritä uudestaan.',
	'emergencydesysop-notasysop' => 'Kohdekäyttäjä ei ole ylläpitäjäryhmässä.',
	'emergencydesysop-nogroups' => 'Ei mitään',
	'emergencydesysop-done' => 'Toiminto suoritettu, sekä sinulta että käyttäjältä [[$1]] on poistettu ylläpitäjän oikeudet.',
	'emergencydesysop-invalidtarget' => 'Kohdekäyttäjää ei ole olemassa.',
	'emergencydesysop-blocked' => 'Et voi käyttää tätä sivua ollessasi estettynä',
	'emergencydesysop-noright' => 'Sinulla ei ole oikeuksia tämän sivun käyttämiseen',
	'right-emergencydesysop' => 'Poistaa ylläpitäjän oikeudet toiselta käyttäjältä vastavuoroisesti',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'emergencydesysop' => 'Désysopage d’urgence',
	'emergencydesysop-desc' => 'Permet à un administrateur de renoncer à ses privilèges pour désysoper un autre administrateur',
	'emergencydesysop-title' => "Retire le statut d’administrateur à la fois pour l'utilisateur courant et pour un autre administrateur",
	'emergencydesysop-otheradmin' => 'Autre administrateur à dégrouper',
	'emergencydesysop-reason' => 'Motif du retrait',
	'emergencydesysop-submit' => 'Soumettre',
	'emergencydesysop-incomplete' => 'Tous les champs doivent être renseignés, veuillez essayer à nouveau.',
	'emergencydesysop-notasysop' => 'L’utilisateur visé n’est pas dans le groupe des administrateurs.',
	'emergencydesysop-nogroups' => 'Néant',
	'emergencydesysop-done' => "Action terminée, vos droits d'administrateur ainsi que ceux de [[$1]] ont été retirés.",
	'emergencydesysop-invalidtarget' => 'L’utilisateur visé n’existe pas.',
	'emergencydesysop-blocked' => 'Vous ne pouvez pas accéder à cette page tant que vous êtes bloqué{{GENDER:||e|(e)}}',
	'emergencydesysop-noright' => 'Vous n’avez pas les permissions suffisantes pour accéder à cette page',
	'right-emergencydesysop' => 'Possible de désysoper mutuellement un autre utilisateur.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'emergencydesysop' => 'Dèsisopâjo d’urgence',
	'emergencydesysop-reason' => 'Rêson du retrèt',
	'emergencydesysop-submit' => 'Sometre',
	'emergencydesysop-nogroups' => 'Niona',
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
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'emergencydesysop-submit' => 'Ὑποβάλλειν',
	'emergencydesysop-nogroups' => 'Οὐδέν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'emergencydesysop' => 'Not-Ammannestatusentzug',
	'emergencydesysop-desc' => 'Macht s eme Ammann megli, syyni Priviliegie ufzgee go eme andere Ammann dr Ammannestatus ewägneh',
	'emergencydesysop-title' => 'Nimmt dr Ammanne-Status vum aktuälle un vun eme andere Benutzer ewäg',
	'emergencydesysop-otheradmin' => 'Andere Ammann zum Deklassiere',
	'emergencydesysop-reason' => 'Grund fir s Useneh',
	'emergencydesysop-submit' => 'Ibertrage',
	'emergencydesysop-incomplete' => 'S bruucht Yygabe in allene Fälder, bitte nomol versueche.',
	'emergencydesysop-notasysop' => 'Dr gwehlt Benutzer ghert nit zue dr Ammanne.',
	'emergencydesysop-nogroups' => 'Keini',
	'emergencydesysop-done' => 'Aktion erfolgryych. Di un [[$1]] isch dr Ammannestatus ewägnuu wore.',
	'emergencydesysop-invalidtarget' => 'Dr Benutzer, wu Du gwehlt hesch, git s nit.',
	'emergencydesysop-blocked' => 'Derwylscht Du gsperrt bisch, chasch nit uf die Syte zuegryfe',
	'emergencydesysop-noright' => 'Du hesch d Rächt nit, wu s bruucht fir die Syte',
	'right-emergencydesysop' => 'S Rächt eme andre Ammann dr Status ewägzneh (gegesytig)',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'emergencydesysop' => 'הסרת הרשאות במצב חירום',
	'emergencydesysop-desc' => 'הוספת האפשרות למפעילים להקריב את ההרשאות של עצמו כדי להסיר את ההרשאות של מפעיל אחר',
	'emergencydesysop-title' => 'הסרת גישה להרשאות מפעיל מהמשתמש הנוכחי וממפעיל אחר',
	'emergencydesysop-otheradmin' => 'המפעיל האחר שהרשאותיו תוסרנה',
	'emergencydesysop-reason' => 'סיבת ההסרה',
	'emergencydesysop-submit' => 'שליחה',
	'emergencydesysop-incomplete' => 'כל שדות הטופס נדרשים, אנא נסו שוב.',
	'emergencydesysop-notasysop' => 'משתמש היעד איננו בקבוצת מפעילי המערכת.',
	'emergencydesysop-nogroups' => 'אין',
	'emergencydesysop-done' => 'הפעולה בוצעה, החשבון שלכם והחשבון [[$1]] כבר אינם מפעילים.',
	'emergencydesysop-invalidtarget' => 'משתמש היעד אינו קיים.',
	'emergencydesysop-blocked' => 'לא ניתן לגשת לדף זה בעודכם חסומים',
	'emergencydesysop-noright' => 'אין לכם הרשאות מספיקות לגשת לדף הזה',
	'right-emergencydesysop' => 'יכול להסיר את הרשאותיו של משתמש אחר באופן הדדי',
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

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'emergencydesysop' => 'Adminisztrátori jogosultság megvonása vészhelyzetben',
	'emergencydesysop-desc' => 'Lehetővé teszi hogy egy adminisztrátor elvegye egy másik adminisztrátor jogosultságát a sajátja feláldozása árán',
	'emergencydesysop-title' => 'Az adminisztrátori hozzáférés eltávolítása a jelenlegi és másik adminisztrátor fiókjáról',
	'emergencydesysop-otheradmin' => 'Másik adminisztrátor eltávolítása a csoportból',
	'emergencydesysop-reason' => 'Az eltávolítás indoka',
	'emergencydesysop-submit' => 'Elküldés',
	'emergencydesysop-incomplete' => 'Az űrlap minden beviteli mezőjét ki kell tölteni, kérlek próbáld újra.',
	'emergencydesysop-notasysop' => 'A cél szerkesztő nem az „adminisztrátor” csoport tagja.',
	'emergencydesysop-nogroups' => 'Nincs',
	'emergencydesysop-done' => 'Művelet végrehajtva, a saját és [[$1]] szerkesztő adminisztrátori jogosultsága eltávolítva.',
	'emergencydesysop-invalidtarget' => 'A cél szerkesztő nem létezik.',
	'emergencydesysop-blocked' => 'A blokk időtartama alatt nem érheted el ezt az oldalt',
	'emergencydesysop-noright' => 'Nincs megfelelő jogosultságod a lap eléréséhez',
	'right-emergencydesysop' => 'Adminisztrátori jogosultság kölcsönös eltávolítása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'emergencydesysop' => 'Disadmin de urgentia',
	'emergencydesysop-desc' => 'Permitte que un administrator sacrifica su proprie privilegios pro "disadministratorar" un altere administrator',
	'emergencydesysop-title' => 'Remotion del accesso de administrator, e del usator actual, e de un altere administrator',
	'emergencydesysop-otheradmin' => 'Altere administrator a retirar del gruppo',
	'emergencydesysop-reason' => 'Motivo pro le remotion',
	'emergencydesysop-submit' => 'Submitter',
	'emergencydesysop-incomplete' => 'Tote le campos de iste formulario es obligatori. Per favor reproba.',
	'emergencydesysop-notasysop' => 'Le usator visate non es in le gruppo de administratores.',
	'emergencydesysop-nogroups' => 'Necun',
	'emergencydesysop-done' => 'Action complete. Tu e [[$1]] non es plus administratores.',
	'emergencydesysop-invalidtarget' => 'Le usator visate non existe.',
	'emergencydesysop-blocked' => 'Tu non pote acceder a iste pagina durante que tu es blocate.',
	'emergencydesysop-noright' => 'Tu non ha sufficiente permissiones pro acceder a iste pagina.',
	'right-emergencydesysop' => 'Pote "disadministratorar" mutualmente un altere usator',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author IvanLanin
 */
$messages['id'] = array(
	'emergencydesysop' => 'Pemecatan Admin Darurat',
	'emergencydesysop-desc' => 'Mengijinkan seorang pengurus untuk mengorbankan hak-haknya untuk memecat seorang pengurus yang lain',
	'emergencydesysop-title' => 'Menghilangkan akses pengurus dari pengguna saat ini dan seorang pengurus lain',
	'emergencydesysop-otheradmin' => 'Pengurus lain yang akan dikeluarkan',
	'emergencydesysop-reason' => 'Alasan pengeluaran',
	'emergencydesysop-submit' => 'Kirim',
	'emergencydesysop-incomplete' => 'Semua harus diisi. Silakan dicoba lagi.',
	'emergencydesysop-notasysop' => 'Pengguna yang dimaksud bukanlah seorang pengurus.',
	'emergencydesysop-nogroups' => 'Tidak ada',
	'emergencydesysop-done' => 'Proses selesai, ANda dan [[$1]] telah dikeluarkan dari daftar pengurus.',
	'emergencydesysop-invalidtarget' => 'Pengguna yang dituju tidak ditemukan.',
	'emergencydesysop-blocked' => 'Anda tidak dapat mengakses halaman ini ketika sedang diblok',
	'emergencydesysop-noright' => 'Anda tidak memiliki izin yang memadai untuk mengakses halaman ini',
	'right-emergencydesysop' => 'Mampu untuk memecat seorang pengurus lain, bersama-sama',
);

/** Italian (Italiano)
 * @author Pietrodn
 */
$messages['it'] = array(
	'emergencydesysop' => "DeSysop d'emergenza",
	'emergencydesysop-desc' => 'Consente a un amministratore di sacrificare i propri privilegi al fine di desysoppare un altro amministratore',
	'emergencydesysop-title' => "Rimuovere l'accesso di amministratore sia dall'utente corrente sia da un altro amministratore",
	'emergencydesysop-otheradmin' => 'Altro amministratore da togliere dal gruppo',
	'emergencydesysop-reason' => 'Motivo per la rimozione',
	'emergencydesysop-submit' => 'Invia',
	'emergencydesysop-incomplete' => 'Tutti i campi del modulo sono obbligatori, si prega di riprovare.',
	'emergencydesysop-notasysop' => "L'utente interessato non è nel gruppo degli amministratori.",
	'emergencydesysop-nogroups' => 'Nessuno',
	'emergencydesysop-done' => 'Azione completata, sia tu sia [[$1]] siete stati desysoppati.',
	'emergencydesysop-invalidtarget' => "L'utente interessato non esiste.",
	'emergencydesysop-blocked' => 'Non puoi accedere a questa pagina mentre sei bloccato',
	'emergencydesysop-noright' => 'Non hai i permessi sufficienti per accedere a questa pagina',
	'right-emergencydesysop' => 'Desysoppa un altro utente, reciprocamente',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'emergencydesysop' => '緊急管理者解任',
	'emergencydesysop-desc' => '管理者が自らの権限を犠牲にして、別の利用者の管理者権限を除去できるようにする',
	'emergencydesysop-title' => '現在の利用者ともう一人の管理者の両方から管理者権限を除去する',
	'emergencydesysop-otheradmin' => '権限を除去するもう一人の管理者',
	'emergencydesysop-reason' => '除去の理由',
	'emergencydesysop-submit' => '送信',
	'emergencydesysop-incomplete' => 'フォームのすべての欄が必須です。もう一度試してください。',
	'emergencydesysop-notasysop' => '対象とした利用者は管理者ではありません。',
	'emergencydesysop-nogroups' => 'なし',
	'emergencydesysop-done' => '操作完了、あなたと[[$1]]の両名は管理者権限を除去されました。',
	'emergencydesysop-invalidtarget' => '対象とした利用者は存在しません。',
	'emergencydesysop-blocked' => 'あなたはブロック中にこのページにアクセスすることはできません。',
	'emergencydesysop-noright' => 'あなたはこのページにアクセスするために必要な許可がありません。',
	'right-emergencydesysop' => 'もう一人の利用者と管理者権限を相互に除去できる',
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
	'emergencydesysop-reason' => '권한을 해제하는 이유',
	'emergencydesysop-submit' => '확인',
	'emergencydesysop-done' => '명령 완료, 당신과 [[$1]] 사용자는 관리자 권한이 해제되었습니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'emergencydesysop' => 'Notfall — ene dorschjedriehte WikiKöbes erus schmiiße',
	'emergencydesysop-desc' => 'Määt et för Nuutfäll müjjelesch, zwei WikiKöbes op eimol erus schmiiße, sesch sellver, un eine dorschjedriehte Kolleje.',
	'emergencydesysop-title' => 'Nemmp däm Metmaacher sellver un enem andere de Rääschte fun enem WikiKöbes fott.',
	'emergencydesysop-otheradmin' => 'Dä andere, öm en uß dä Jrup „{{int:group-sysop}}“ eruß ze nämme',
	'emergencydesysop-reason' => 'Dä Jrund för et Rußschmiiße',
	'emergencydesysop-submit' => 'Lohß Jonn!',
	'emergencydesysop-incomplete' => 'Do moß en jedes Feld en dämm Fommulaa jet enjävve!',
	'emergencydesysop-notasysop' => 'Dä Metmaacher es jaa nit en dä Jopp „{{int:group-sysop}}“.',
	'emergencydesysop-nogroups' => 'Keine',
	'emergencydesysop-done' => 'Dat hät jefupp, dä [[$1]] un Du, Ühr sid jetz kein {{int:group-sysop}} mieh.',
	'emergencydesysop-invalidtarget' => 'Esu ene Metmaacher ham_mer nit.',
	'emergencydesysop-blocked' => 'Dat kanns De nit maache, esu lang wi De jespertt bes.',
	'emergencydesysop-noright' => 'Do häs nit dat Rääsch, op die Sigg ze jonn.',
	'right-emergencydesysop' => 'Kann enem andere Wiki-Köbes däm sing Rääsch affnämme.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'emergencydesysop-submit' => 'Tomar bike',
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

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'emergencydesysop' => 'Итно одземање администраторски права',
	'emergencydesysop-desc' => 'Дозволува администратор да ги жртвува своите привилегии за да одземе администраторски права на друг',
	'emergencydesysop-title' => 'Отстрани администраторски права на тековниот корисник и на друг администратор',
	'emergencydesysop-otheradmin' => 'Други администратори за одземање на права',
	'emergencydesysop-reason' => 'Причина за отстранување',
	'emergencydesysop-submit' => 'Поднеси',
	'emergencydesysop-incomplete' => 'Мора да се пополнат сите полиња; обидете се повторно',
	'emergencydesysop-notasysop' => 'Целниот корисник не е во групата на администратори.',
	'emergencydesysop-nogroups' => 'Нема',
	'emergencydesysop-done' => 'Постапката е завршена; вие и [[$1]] сте лишени од администраторски права',
	'emergencydesysop-invalidtarget' => 'Целниот корисник не постои.',
	'emergencydesysop-blocked' => 'Не можете да дојдете до страницата кога сте блокирани',
	'emergencydesysop-noright' => 'Немате доволно дозволи за пристап на оваа страница',
	'right-emergencydesysop' => 'Одземање на администраторски права заедно со своите',
);

/** Malayalam (മലയാളം)
 * @author Junaidpv
 */
$messages['ml'] = array(
	'emergencydesysop-submit' => 'സമർപ്പിക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'emergencydesysop-submit' => 'Явуулах',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'emergencydesysop-submit' => 'Serahkan',
	'emergencydesysop-nogroups' => 'Tiada',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'emergencydesysop' => 'Kriseavsetting av administrator',
	'emergencydesysop-desc' => 'Lar en administrator ofre egne privilegier for å avsette en annen administrator.',
	'emergencydesysop-title' => 'Fjern administratorrettighetene til både gjeldende bruker og en annen administrator.',
	'emergencydesysop-otheradmin' => 'Andre administratorer som skal avsettes',
	'emergencydesysop-reason' => 'Grunn for avsetting',
	'emergencydesysop-submit' => 'Utfør',
	'emergencydesysop-incomplete' => 'Alle skjemafeltene er påkrevd, vennligst prøv igjen.',
	'emergencydesysop-notasysop' => 'Målbrukeren er ikke en administrator.',
	'emergencydesysop-nogroups' => 'Ingen',
	'emergencydesysop-done' => 'Handling utført, både du og [[$1]] har blitt avsatt som administratorer.',
	'emergencydesysop-invalidtarget' => 'Målbrukeren eksisterer ikke.',
	'emergencydesysop-blocked' => 'Du kan ikke se denne siden når du er blokkert',
	'emergencydesysop-noright' => 'Du har ikke de påkrevde rettighetene til å se denne siden',
	'right-emergencydesysop' => 'Mulighet til å avsette seg selv og en annen administrator',
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

/** Oriya (ଓଡ଼ିଆ)
 * @author Jnanaranjan Sahu
 */
$messages['or'] = array(
	'emergencydesysop-reason' => 'ହଟାଇବାର କାରଣ',
	'emergencydesysop-submit' => 'ପଇଠ କରିବେ',
	'emergencydesysop-nogroups' => 'କିଛି ନାହିଁ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'emergencydesysop-nogroups' => 'Ken',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'emergencydesysop-nogroups' => 'Kään',
);

/** Polish (Polski)
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'emergencydesysop' => 'Awaryjne odbieranie uprawnień administratora',
	'emergencydesysop-desc' => 'Umożliwia administratorowi poświęcenie własnych uprawnień w celu odebrania uprawnień innemu administratorowi',
	'emergencydesysop-title' => 'Odbiera uprawnienia administratora zarówno bieżącemu użytkownikowi jak i innemu administratorowi',
	'emergencydesysop-otheradmin' => 'Administrator, któremu mają zostać odebrane uprawnienia',
	'emergencydesysop-reason' => 'Powód odebrania uprawnień',
	'emergencydesysop-submit' => 'Zapisz',
	'emergencydesysop-incomplete' => 'Wymagane jest wypełnienie wszystkich pól formularza, proszę spróbować ponownie.',
	'emergencydesysop-notasysop' => 'Wskazany użytkownik nie należy do grupy administratorów.',
	'emergencydesysop-nogroups' => 'Brak',
	'emergencydesysop-done' => 'Operacja wykonana, zarówno Ty jak i [[$1]] utraciliście uprawnienia administratora.',
	'emergencydesysop-invalidtarget' => 'Wskazany użytkownik nie istnieje.',
	'emergencydesysop-blocked' => 'Nie masz dostępu do tej strony, gdy jesteś zablokowany',
	'emergencydesysop-noright' => 'Nie posiadasz wystarczających uprawnień by mieć dostęp do tej strony',
	'right-emergencydesysop' => 'Możliwość odebrania uprawnień administratora innemu użytkownikowi, kosztem własnych uprawnień',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'emergencydesysop' => "DeSysop d'emergensa",
	'emergencydesysop-desc' => "A përmëtt a n'aministrador ëd sacrifiché ij sò privilegi për desysop n'àutr aministrador",
	'emergencydesysop-title' => "Gava ij drit d'aministrador da cost utent-sì e da n'àutr aministrador",
	'emergencydesysop-otheradmin' => 'Àutr aministrador ga gavé da la partìa',
	'emergencydesysop-reason' => 'Rason për gavé',
	'emergencydesysop-submit' => 'Spediss',
	'emergencydesysop-incomplete' => 'Tùit ij camp ëd la forma a son nessessari, për piasì preuva torna.',
	'emergencydesysop-notasysop' => "L'utent pontà a l'é pa ant la partìa dj'aministrador.",
	'emergencydesysop-nogroups' => 'Gnun',
	'emergencydesysop-done' => 'Assion completa, ti e [[$1]] i seve stàit desysop.',
	'emergencydesysop-invalidtarget' => "L'utent pontà a esist pa.",
	'emergencydesysop-blocked' => 'It peule pa vëdde sta pàgina-sì an ment it ses blocà',
	'emergencydesysop-noright' => "It l'has pa basta privilegi për vëdde sta pàgina-sì",
	'right-emergencydesysop' => "It peule desysop n'àutr utent, mutualment",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'emergencydesysop-submit' => 'سپارل',
	'emergencydesysop-nogroups' => 'هېڅ',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'emergencydesysop' => 'Remoção de Emergência dos Privilégios de Administrador',
	'emergencydesysop-desc' => 'Permite que um administrador sacrifique os seus próprios privilégios para retirar o privilégio de administrador a outro utilizador',
	'emergencydesysop-title' => 'Remover o acesso de administrador tanto ao utilizador actual como a outro administrador',
	'emergencydesysop-otheradmin' => 'Outro administrador a retirar do grupo',
	'emergencydesysop-reason' => 'Motivo para a remoção',
	'emergencydesysop-submit' => 'Enviar',
	'emergencydesysop-incomplete' => 'Todos os campos do formulário são obrigatórios. Tente novamente, por favor.',
	'emergencydesysop-notasysop' => 'O utilizador alvo não está no grupo dos administradores.',
	'emergencydesysop-nogroups' => 'Nenhum',
	'emergencydesysop-done' => 'Operação completa; foram removidos os privilégios de administardor a si e a [[$1]].',
	'emergencydesysop-invalidtarget' => 'O utilizador alvo não existe.',
	'emergencydesysop-blocked' => 'Não pode aceder a esta página enquanto estiver bloqueado',
	'emergencydesysop-noright' => 'Não tem permissões suficientes para aceder a esta página',
	'right-emergencydesysop' => 'Remover privilégios de administrador a outro utilizador, com efeito mútuo',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'emergencydesysop' => 'Remoção de Emergência do Acesso de Sysop',
	'emergencydesysop-desc' => 'Permite que um sysop sacrifique os seus próprios privilégios para retirar privilégios de sysop a outro',
	'emergencydesysop-title' => 'Remover acesso de sysop de ambos o utilizador atual e outro sysop',
	'emergencydesysop-otheradmin' => 'Outro sysop a retirar do grupo',
	'emergencydesysop-reason' => 'Razão para a remoção',
	'emergencydesysop-submit' => 'Enviar',
	'emergencydesysop-incomplete' => 'Todos os campos do formulário são obrigatórios. Por favor, tente novamente.',
	'emergencydesysop-notasysop' => 'O utilizador alvo não está no grupo de sysops.',
	'emergencydesysop-nogroups' => 'Nenhum',
	'emergencydesysop-done' => 'Ação completa, tanto a você como a [[$1]] foi removido o acesso de sysop.',
	'emergencydesysop-invalidtarget' => 'O utilizador alvo não existe.',
	'emergencydesysop-blocked' => 'Você não pode acessar esta página enquanto estiver bloqueado',
	'emergencydesysop-noright' => 'Você não possui permissões suficientes para acessar esta página',
	'right-emergencydesysop' => 'Remover privilégios de sysop a outro utilizador, mutuamente',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'emergencydesysop-reason' => 'Motiv pentru ștergere',
	'emergencydesysop-submit' => 'Trimite',
	'emergencydesysop-nogroups' => 'Niciunul',
	'emergencydesysop-invalidtarget' => 'Utilizatorul țintă nu există.',
	'emergencydesysop-noright' => 'Nu ai suficiente permisiuni pentru a accesa această pagină',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Kv75
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'emergencydesysop' => 'Аварийное снятие прав администратора',
	'emergencydesysop-desc' => 'Позволяет администратору жертвовать свои привилегии для снятия прав другого администратора',
	'emergencydesysop-title' => 'Снять права администратора у текущего участника и другого администратора',
	'emergencydesysop-otheradmin' => 'Другой администратор для снятия прав',
	'emergencydesysop-reason' => 'Причина удаления',
	'emergencydesysop-submit' => 'Выполнить',
	'emergencydesysop-incomplete' => 'Требуется заполнить все поля, пожалуйста, повторите.',
	'emergencydesysop-notasysop' => 'Целевой участник не состоит в группе администраторов.',
	'emergencydesysop-nogroups' => 'Нет',
	'emergencydesysop-done' => 'Действие успешно выполнено, вы и [[$1]] лишены прав администратора.',
	'emergencydesysop-invalidtarget' => 'Целевой участник не существует.',
	'emergencydesysop-blocked' => 'Вы не можете получить доступ к этой странице, будучи заблокированным',
	'emergencydesysop-noright' => 'Вы не имеете достаточных полномочий для доступа к этой странице',
	'right-emergencydesysop' => 'снятие прав администратора другого участника, вместе со своими',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'emergencydesysop-nogroups' => 'Nuddu',
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

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'emergencydesysop' => 'Скидање администраторских права за случај нужде',
	'emergencydesysop-desc' => 'Омогућује администратору да скине сопствена права да би их скинуо и другом администратору',
	'emergencydesysop-title' => 'Уклањање администраторских права са сопственог налога и налога другог администратора',
	'emergencydesysop-otheradmin' => 'Други администратор, чија права треба уклонити',
	'emergencydesysop-reason' => 'Разлог за уклањање',
	'emergencydesysop-submit' => 'Пошаљи',
	'emergencydesysop-incomplete' => 'Потребно је попунити сва поља форме, молим Вас да покушате поново.',
	'emergencydesysop-notasysop' => 'Циљани корисник није у групи администратора.',
	'emergencydesysop-nogroups' => 'Непопуњено',
	'emergencydesysop-done' => 'Акција је завршена. Ваша и администраторска права [[$1]] су уклоњена.',
	'emergencydesysop-invalidtarget' => 'Циљани корисник не постоји.',
	'emergencydesysop-blocked' => 'Не можете да приступите овој страни док сте под блоком.',
	'emergencydesysop-noright' => 'Немате права приступа овој страници.',
	'right-emergencydesysop' => 'Омогућава администратору да одузме администраторска права себи и другом администратору',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'emergencydesysop' => 'Skidanje administratorskih prava za slučaj nužde',
	'emergencydesysop-desc' => 'Omogućuje administratoru da skine sopstvena prava da bi ih skinuo i drugom administratoru',
	'emergencydesysop-title' => 'Uklanjanje administratorskih prava sa sopstvenog naloga i naloga drugog administratora',
	'emergencydesysop-otheradmin' => 'Drugi administrator, čija prava treba ukloniti',
	'emergencydesysop-reason' => 'Razlog za uklanjanje',
	'emergencydesysop-submit' => 'Potvrdi',
	'emergencydesysop-incomplete' => 'Potrebno je popuniti sva polja forme, molim Vas da pokušate ponovo.',
	'emergencydesysop-notasysop' => 'Ciljani korisnik nije u grupi administratora.',
	'emergencydesysop-nogroups' => 'Nepopunjeno',
	'emergencydesysop-done' => 'Akcija je završena. Vaša i administratorska prava [[$1]] su uklonjena.',
	'emergencydesysop-invalidtarget' => 'Ciljani korisnik ne postoji.',
	'emergencydesysop-blocked' => 'Ne možete da pristupite ovoj strani dok ste pod blokom.',
	'emergencydesysop-noright' => 'Nemate prava pristupa, potrebna da biste pristupili ovoj strani',
	'right-emergencydesysop' => 'Omogućava administratoru da oduzme administratorska prava sebi i drugom administratoru',
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
 * @author Chaduvari
 * @author Kiranmayee
 * @author Ravichandra
 * @author Veeven
 */
$messages['te'] = array(
	'emergencydesysop' => 'అత్యవసరంగా నిర్వాహకత్వం తొలగింపు',
	'emergencydesysop-desc' => 'ఓ నిర్వాహకుడు, మరో నిర్వాహకుని నిర్వాహకత్వం నుండి తీసెయ్యడం కోసం, తన స్వీయ అనుమతులను త్యాగం చేసే వీలు కల్పిస్తుంది',
	'emergencydesysop-title' => 'ప్రస్తుత వాడుకరికి, మరో నిర్వాహకునికీ ఉన్న నిర్వాహకత్వ అనుమతులను తీసివెయ్యి',
	'emergencydesysop-reason' => 'తొలగింపునకు కారణం',
	'emergencydesysop-submit' => 'దాఖలుచెయ్యి',
	'emergencydesysop-incomplete' => 'ఈ ఫారం లోని ఫీల్డులన్నీ ఆశ్యకం, మళ్ళీ ప్రయత్నించండి.',
	'emergencydesysop-notasysop' => 'లక్ష్యించిన వాడుకరి నిర్వాహక గుంపులో లేరు.',
	'emergencydesysop-nogroups' => 'ఏదీకాదు',
	'emergencydesysop-done' => 'చర్య పూర్తైంది. మీరు, [[$1]] గారు -ఇద్దరూ నిర్వాహకత్వాన్ని కోల్పోయారు.',
	'emergencydesysop-invalidtarget' => 'లక్ష్యించిన వాడుకరి ఉనికిలో లెరు.',
	'emergencydesysop-blocked' => 'నిరోధించబడి ఉండగా మీరు ఈ పేజీని చూడజాలరు.',
	'emergencydesysop-noright' => 'ఈ పుటను చూడ్డానికి మీకు అనుమతులు లేవు',
	'right-emergencydesysop' => 'ఒకరి నిర్వాహకత్వం మరొకరు రద్దు చేయవచ్చు',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'emergencydesysop-nogroups' => 'ไม่มี',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'emergencydesysop-submit' => 'Tabşyr',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'emergencydesysop' => 'Biglaang Pagtanggal Bilang Tagapagpaandar ng Sistema',
	'emergencydesysop-desc' => 'Nagpapahintulot sa isang tagapangasiwa na maiwaksi ang sariling mga pribilehiyo upang matanggal sa pagiging tagapagpaandar ng sistema ang isa pang tagapangasiwa',
	'emergencydesysop-title' => 'Tanggalin kapwa ang maka-tagapangasiwang pagpunta mula sa pangkasalukuyang tagagamit at isa pang tagapangasiwa',
	'emergencydesysop-otheradmin' => 'Iba pang tagapangasiwang tatanggalin mula sa pangkat',
	'emergencydesysop-reason' => 'Dahilan sa pagtanggal',
	'emergencydesysop-submit' => 'Ipasa',
	'emergencydesysop-incomplete' => 'Kailangan ang lahat ng mga kahanayan ng pormularyo, pakisubok uli.',
	'emergencydesysop-notasysop' => 'Wala sa loob ng pangkat ng tagapangasiwa ang pinupukol na tagagamit.',
	'emergencydesysop-nogroups' => 'Wala',
	'emergencydesysop-done' => 'Tapos na ang ginagawa, ikaw at si [[$1]] ay kapwa natanggal na mula sa pagiging tagapagpaandar ng sistema.',
	'emergencydesysop-invalidtarget' => 'Hindi umiiral ang pinupukol na tagagamit.',
	'emergencydesysop-blocked' => 'Hindi mo mapupuntahan ang pahinang ito habang hinahadlangan',
	'emergencydesysop-noright' => 'Wala kang sapat na mga kapahintulutan upang mapuntahan ang pahinang ito',
	'right-emergencydesysop' => 'Nagawang tanggalin na mula sa pagiging tagapagpaandar ng sistema ang isa pang tagagamit, pareho',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'emergencydesysop' => 'Acil Durum Hizmetlilik Azli',
	'emergencydesysop-desc' => 'Bir hizmetlinin başka bir hizmetliyi azletmek için kendi yetkilerinden feragat etmesini sağlamaktadır',
	'emergencydesysop-title' => 'Hem mevcut kullanıcıdan hem de diğer hizmetliden hizmetlilik erişimini kaldırır',
	'emergencydesysop-otheradmin' => 'Diğer hizmetli gruptan çıkarılacak',
	'emergencydesysop-reason' => 'Azil gerekçesi',
	'emergencydesysop-submit' => 'Gönder',
	'emergencydesysop-incomplete' => 'Tüm form alanları gereklidir, lütfen tekrar deneyin.',
	'emergencydesysop-notasysop' => 'Hedef kullanıcı hizmetli grubunda değil.',
	'emergencydesysop-nogroups' => 'Yok',
	'emergencydesysop-done' => 'İşlem tamamlandı, hem siz hem de [[$1]] hizmetlilikten azledildiniz.',
	'emergencydesysop-invalidtarget' => 'Hedef kullanıcı mevcut değil.',
	'emergencydesysop-blocked' => 'Engellenmişken bu sayfaya erişemezsiniz',
	'emergencydesysop-noright' => 'Bu sayfaya erişmek için yeterli izniniz yok',
	'right-emergencydesysop' => 'Diğer bir kullanıcıyı karşılıklı olarak azletme imkanı verir',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'emergencydesysop' => 'Аварійне позбавлення прав адміністратора',
	'emergencydesysop-desc' => 'Дозволяє адміністратору пожертвувати власними привілеями з метою позбавлення прав іншого адміністратора',
	'emergencydesysop-title' => 'Зняти права адміністратора з обох: поточного користувача та іншого адміністратора',
	'emergencydesysop-otheradmin' => 'Інший адміністратор для позбавлення прав',
	'emergencydesysop-reason' => 'Підстава позбавлення',
	'emergencydesysop-submit' => 'Виконати',
	'emergencydesysop-incomplete' => 'Необхідно заповнити всі поля форми, будь ласка, спробуйте ще раз.',
	'emergencydesysop-notasysop' => 'Цільовий користувач не входить в групу адміністраторів.',
	'emergencydesysop-nogroups' => 'Нема',
	'emergencydesysop-done' => 'Дію виконано, ви та [[$1]] позбавлені прав адміністратора.',
	'emergencydesysop-invalidtarget' => 'Цільового користувача не існує.',
	'emergencydesysop-blocked' => 'Ви не можете отримати доступ до цієї сторінки під час блокування',
	'emergencydesysop-noright' => 'У вас немає прав для доступу до цієї сторінки',
	'right-emergencydesysop' => 'Зняття прав адміністратора з іншого користувача, разом зі своїми',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'emergencydesysop-submit' => 'Oigeta',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'emergencydesysop' => 'Rút quyền quản lý khẩn cấp',
	'emergencydesysop-desc' => 'Cho phép bảo quản viên hy sinh quyền của mình để tước quyền sysop của quản lý khác',
	'emergencydesysop-title' => 'Bỏ quyền truy cập quản lý đối với thành viên hiện tại lẫn một bảo quản viên khác',
	'emergencydesysop-otheradmin' => 'Bảo quản viên khác cần bị tước quyền',
	'emergencydesysop-reason' => 'Lý do rút quyền',
	'emergencydesysop-submit' => 'Thực hiện',
	'emergencydesysop-incomplete' => 'Bạn cần điền đầy đủ mọi chỗ trống, xin hãy làm lại.',
	'emergencydesysop-notasysop' => 'Thành viên đích không nằm trong nhóm bảo quản viên.',
	'emergencydesysop-nogroups' => 'Không có',
	'emergencydesysop-done' => 'Đã hoàn thành tác vụ, cả bạn và [[$1]] đều đã bị tước quyền sysop.',
	'emergencydesysop-invalidtarget' => 'Thành viên đích không tồn tại.',
	'emergencydesysop-blocked' => 'Bạn không thể truy cập trang này khi đang bị cấm',
	'emergencydesysop-noright' => 'Bạn không có đủ quyền hạn để truy cập trang này',
	'right-emergencydesysop' => 'Có thể tước quyền sysop của thành viên khác bằng cách tước cả quyền sysop của mình',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'emergencydesysop-nogroups' => 'קיין',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Hzy980512
 */
$messages['zh-hans'] = array(
	'emergencydesysop' => '紧急移除管理员权限',
	'emergencydesysop-desc' => '允许管理员牺牲他们的特权，免除另一名管理员的权限。',
	'emergencydesysop-title' => '从现在这个账户或其它管理员账号上移除权限',
	'emergencydesysop-otheradmin' => '其他管理员去移除权限',
	'emergencydesysop-reason' => '移除理由',
	'emergencydesysop-submit' => '递交',
	'emergencydesysop-incomplete' => '请填写所有输入框之后再试一次。',
	'emergencydesysop-notasysop' => '目标用户不在管理员群组中。',
	'emergencydesysop-nogroups' => '无',
	'emergencydesysop-done' => '动作已完成，你和[[$1]]已被移除管理员权限。',
	'emergencydesysop-invalidtarget' => '目标用户不存在。',
	'emergencydesysop-blocked' => '您在封禁期内不能访问此页',
	'emergencydesysop-noright' => '您没有足够权限访问本页',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Horacewai2
 * @author Waihorace
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'emergencydesysop' => '緊急移除管理員權限',
	'emergencydesysop-desc' => '容許管理員犧牲他們的特權，免除另一名管理員的權限。',
	'emergencydesysop-otheradmin' => '其他管理員去移除權限',
	'emergencydesysop-reason' => '移除理由',
	'emergencydesysop-submit' => '遞交',
	'emergencydesysop-incomplete' => '請填寫所有輸入框之後再試一次。',
	'emergencydesysop-notasysop' => '目標使用者不在管理員群組中。',
	'emergencydesysop-nogroups' => '無',
	'emergencydesysop-done' => '動作已完成，你和[[$1]]已被移除管理員權限。',
	'emergencydesysop-invalidtarget' => '目標使用者不存在',
	'emergencydesysop-blocked' => '您在封禁期內不能存取本頁',
	'emergencydesysop-noright' => '您沒有足夠權限存取本頁',
);

