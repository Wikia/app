<?php
/**
 * Internationalisation file for extension Invitations
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'invite-logpage'                        => 'Invitation log',
	'invite-logpagetext'                    => 'This is a log of users inviting each other to use various software features.',
	'invite-logentry'                       => 'invited $1 to use the <i>$2</i> feature.',
	'invitations'                           => 'Manage invitations to software features',
	'invitations-desc'                      => 'Allows [[Special:Invitations|management of new features]] by restricting them to an invitation-based system',
	'invitations-invitedlist-description'   => 'You have access to the following invitation-only software features.
To manage invitations for an individual feature, click on its name.',
	'invitations-invitedlist-none'          => 'You have not been invited to use any invitation-only software features.',
	'invitations-invitedlist-item-count'    => '({{PLURAL:$1|One invitation|$1 invitations}} available)',
	'invitations-pagetitle'                 => 'Invite-only software features',
	'invitations-uninvitedlist-description' => 'You do not have access to these other invitation-only software features.',
	'invitations-uninvitedlist-none'        => 'At this time, no other software features are designated invitation-only.',
	'invitations-feature-pagetitle'         => 'Invitation management - $1',
	'invitations-feature-access'            => 'You currently have access to use <i>$1</i>.',
	'invitations-feature-numleft'           => 'You still have {{PLURAL:$2|one invitation left|<b>$1</b> out of your $2 invitations left}}.',
	'invitations-feature-noneleft'          => 'You have used all of your allocated invitations for this feature',
	'invitations-feature-noneyet'           => 'You have not yet received your allocation of invitations for this feature.',
	'invitations-feature-notallowed'        => 'You do not have access to use <i>$1</i>.',
	'invitations-inviteform-title'          => 'Invite a user to use $1',
	'invitations-inviteform-username'       => 'User to invite',
	'invitations-inviteform-submit'         => 'Invite',
	'invitations-error-baduser'             => 'The user you specified does not appear to exist.',
	'invitations-error-alreadyinvited'      => 'The user you specified already has access to this feature!',
	'invitations-invite-success'            => 'You have successfully invited $1 to use this feature!',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 */
$messages['ar'] = array(
	'invite-logpage'                        => 'سجل الدعوات',
	'invite-logentry'                       => 'دعا $1 لاستخدام خاصية <i>$2</i>.',
	'invitations'                           => 'أدر الدعوات لميزات البرنامج',
	'invitations-invitedlist-none'          => 'لم تتم دعوتك لاستخدام أي ميزات بالدعوة-فقط.',
	'invitations-pagetitle'                 => 'ميزات بالدعوة-فقط',
	'invitations-uninvitedlist-description' => 'لا توجد لديك صلاحية لهذه الميزات بالدعوة-فقط الأخرى.',
	'invitations-feature-pagetitle'         => 'إدارة الدعوات - $1',
	'invitations-feature-access'            => 'لديك حاليا صلاحية استخدام <i>$1</i>.',
	'invitations-feature-noneleft'          => 'لقد استخدمت كل دعواتك المحصصة لهذه الميزة',
	'invitations-feature-notallowed'        => 'لا يوجد لديك صلاحية استخدام <i>$1</i>.',
	'invitations-inviteform-title'          => 'ادعي مستخدم ليستخدم $1',
	'invitations-inviteform-username'       => 'المستخدم لتتم دعوته',
	'invitations-inviteform-submit'         => 'ادعي',
	'invitations-error-baduser'             => 'المستخدم الذي حددته لا يبدو أنه موجود.',
	'invitations-error-alreadyinvited'      => 'المستخدم الذي حددته لديه صلاحية لهذه الميزة أصلا!',
	'invitations-invite-success'            => 'لقد دعوت $1 ليستخدم هذه الميزة بنجاح!',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'invite-logpage'                      => 'Дневник на поканите',
	'invite-logpagetext'                  => 'Тази страница съдържа дневник на поканите между потребителите за достъп до различни услуги.',
	'invite-logentry'                     => 'покани $1 да използва <i>$2</i>.',
	'invitations'                         => 'Управление на поканите за различните услуги',
	'invitations-desc'                    => 'Позволява [[Special:Invitations|управление на новите възможности на софтуера]] като ги ограничава за използване чрез система с покани',
	'invitations-invitedlist-description' => 'Имате достъп до следните софтуерни възможности, достъпни с покана.
За управление на поканите за отделна възможности, щракнете върху името й.',
	'invitations-invitedlist-none'        => 'Нямате покана да използвате нито една от софтуерните възможности, достъпни с покана.',
	'invitations-invitedlist-item-count'  => '({{PLURAL:$1|Налична е една покана|Налични са $1 покани}})',
	'invitations-pagetitle'               => 'Възможности на софтуера, достъпни с покана',
	'invitations-uninvitedlist-none'      => 'На този етап няма други софтуерни възможности, които да са отбелязани, че са достъпни с покана.',
	'invitations-feature-pagetitle'       => 'Управление на поканите - $1',
	'invitations-feature-access'          => 'В момента имате достъп да използвате <i>$1</i>.',
	'invitations-feature-numleft'         => 'Имате {{PLURAL:$2|една оставаща покана|оставащи <b>$1</b> от $2 покани}}.',
	'invitations-feature-noneleft'        => 'Вече сте използвали всички отпуснати покани за тази услуга',
	'invitations-feature-notallowed'      => 'Нямате достъп да използвате <i>$1</i>.',
	'invitations-inviteform-title'        => 'Изпращане на покана на потребител да използва $1',
	'invitations-inviteform-username'     => 'Потребител',
	'invitations-inviteform-submit'       => 'Изпращане на покана',
	'invitations-error-baduser'           => 'Посоченият потребител не съществува.',
	'invitations-error-alreadyinvited'    => 'Посоченият потребител вече има достъп до тази услуга!',
	'invitations-invite-success'          => 'Поканата на $1 за достъп до услугата беше изпратена успешно!',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'invite-logpage'                        => 'Einladungs-Logbuch',
	'invite-logpagetext'                    => 'Dies ist das Logbuch der einladungsbasierten Softwarefunktionen.',
	'invite-logentry'                       => 'hat $1 eingeladen, um die Softwarefunktionen <i>$2</i> zu nutzen.',
	'invitations-desc'                      => 'Ermöglicht die [[Special:Invitations|Verwaltung von Softwarefunktionen]] auf Basis von Einladungen',
	'invitations-invitedlist-description'   => 'Du hast Zugang zu den folgenden einladungsbasierten Softwarefunktionen. Um Einladungen für eine bestimmte Softwarefunktion zu verwalten, klicke auf ihren Namen.',
	'invitations-invitedlist-none'          => 'Du hast bisher keine Einladung zur Nutzung von einladungsbasierten Softwarefunktionen erhalten.',
	'invitations-pagetitle'                 => 'Softwarefunktionen auf Einladungs-Basis',
	'invitations-uninvitedlist-description' => 'Du hast keinen Zugang zu anderen einladungsbasierten Softwarefunktionen.',
	'invitations-uninvitedlist-none'        => 'Zur Zeit sind keine weiteren Softwarefunktionen einladungsbasiert.',
	'invitations-feature-pagetitle'         => 'Einladungs-Verwaltung - $1',
	'invitations-feature-access'            => 'Du hast Zugang zur Nutzung von <i>$1</i>.',
	'invitations-feature-numleft'           => 'Dir stehen noch <b>$1</b> von insgesamt $2 Einladungen zur Verfügung.',
	'invitations-feature-noneleft'          => 'Du hast alle dir zugewiesenen Einladungen für diese Softwarefunktion verbraucht.',
	'invitations-feature-noneyet'           => 'Dir wurden noch keine Einladungen für diese Softwarefunktion zugewiesen.',
	'invitations-feature-notallowed'        => 'Du hast keine Berechtigung, um <i>$1</i> zu nutzen.',
	'invitations-inviteform-title'          => 'Lade einen Benutzer zu der Funktion $1 ein',
	'invitations-inviteform-username'       => 'Einzuladender Benutzer',
	'invitations-inviteform-submit'         => 'Einladen',
	'invitations-error-baduser'             => 'Der angegebene Benutzer ist nicht vorhanden.',
	'invitations-error-alreadyinvited'      => 'Der angegebene Benutzer hat bereits Zugang zu dieser Softwarefunktion!',
	'invitations-invite-success'            => 'Du hast erfolgreich $1 zu dieser Softwarefunktion eingeladen!',
);

/** Greek (Ελληνικά)
 * @author Απεργός
 */
$messages['el'] = array(
	'invite-logpage'                        => 'Αρχείο καταγραφών προσκλήσεων',
	'invite-logpagetext'                    => 'Καταγραφές των προσκλήσεων σε χρήστες να χρησιμοποιήσουν διάφορες λειτουργίες λογισμικού.',
	'invite-logentry'                       => 'προσκάλεσε τον/την $1 να χρησιμοποιήσει τη λειτουργία <i>$2</i>.',
	'invitations'                           => 'Διαχείριση προσκλήσεων σε λειτουργίες λογισμικού',
	'invitations-desc'                      => 'Επιτρέπει τη [[Special:Invitations|διαχείριση καινούργιων λειτουργιών]] μέσω του περιορισμού τους σε ένα σύστημα βασισμένο σε προσκλήσεις',
	'invitations-invitedlist-description'   => 'Έχετε πρόσβαση στις ακόλουθες λειτουργίες λογισμικού που χρειάζονται πρόσκληση. Για να διαχειριστείτε προσκλήσεις για μια μεμονωμένη λειτουργία, κάντε κλικ στο όνομά της.',
	'invitations-invitedlist-none'          => 'Δεν προσκληθήκατε να χρησιμοποιήσετε καμία λειτουργία λογισμικού που χρειάζεται πρόσκληση.',
	'invitations-pagetitle'                 => 'Λειτουργίες λογισμικού που χρειάζονται πρόσκληση',
	'invitations-uninvitedlist-description' => 'Δεν έχετε πρόσβαση σε αυτές τις άλλες λειτουργίες λογισμικού που χρειάζονται πρόσκληση.',
	'invitations-uninvitedlist-none'        => 'Αυτή τη στιγμή, καμία άλλη λειτουργία λογισμικού δεν ορίζεται ως λειτουργία που χρειάζεται πρόσκληση.',
	'invitations-feature-pagetitle'         => 'Διαχείριση Προσκλήσεων - $1',
	'invitations-feature-access'            => 'Έχετε τώρα πρόσβαση να χρησιμοποιήσετε <i>$1</i>.',
	'invitations-feature-numleft'           => 'Ακόμη σας μένουν <b>$1</b> από τις $2 προσκλήσεις σας.',
	'invitations-feature-noneleft'          => 'Έχετε χρησιμοποιήσει όλες τις κατανεμημένες προσκλήσεις σας για αυτή τη λειτουργία.',
	'invitations-feature-noneyet'           => 'Δεν έχετε πάρει τη δική σας κατανομή των προσκλήσεων για αυτή τη λειτουργία.',
	'invitations-feature-notallowed'        => 'Δεν έχετε πρόσβαση να χρησιμοποιήσετε <i>$1</i>.',
	'invitations-inviteform-title'          => 'Πρόσκληση σε ένα χρήστη να χρησιμοποιήσει $1',
	'invitations-inviteform-username'       => 'Χρήστης προς πρόσκληση',
	'invitations-inviteform-submit'         => 'Πρόσκληση',
	'invitations-error-baduser'             => 'Ο χρήστης που καθορίσατε δεν φαίνεται να υπάρχει.',
	'invitations-error-alreadyinvited'      => 'Ο χρήστης που καθορίσατε έχει πρόσβαση ήδη σε αυτή τη λειτουργία!',
	'invitations-invite-success'            => 'Έχετε προκαλέσει επιτυχώς τον/την $1 να χρησιμοποιήσει αυτή τη λειτουργία!',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'invite-logpage'                        => 'Protokolo de invitado',
	'invite-logpagetext'                    => 'Ĉi tiu protokolo de uzantoj invitantaj inter ili mem por uzi variajn programerojn.',
	'invite-logentry'                       => 'Vi invitis $1 por uzi la <i>$2</i> programeron.',
	'invitations'                           => 'Administru invitojn por programeroj',
	'invitations-desc'                      => 'Permesas [[Special:Invitations|administradon de novaj programeroj]] tiel limigante atingon al ili per invito-sistemo',
	'invitations-invitedlist-description'   => 'Vi povas atingi la jenajn programerojn nur atingeblaj per invito. Administri invitojn por unuopa programero, klaku ties nomon.',
	'invitations-invitedlist-none'          => 'Vi ne estis invitita por uzi programerojn atingeblajn nur per invito.',
	'invitations-invitedlist-item-count'    => 'Havas vi {{PLURAL:$1|unu inviton|$1 invitojn}}.',
	'invitations-pagetitle'                 => 'Programeroj atingeblaj nur per invito',
	'invitations-uninvitedlist-description' => 'Vi ne eblas atingi aliajn programerojn haveblajn nur per invito.',
	'invitations-uninvitedlist-none'        => 'Ĉi tiame, neniuj ajn programeroj estas atingeblaj nur per invito.',
	'invitations-feature-pagetitle'         => 'Administrado de invitoj - $1',
	'invitations-feature-access'            => 'Vi nune estas permesita uzi programeron <i>$1</i>.',
	'invitations-feature-numleft'           => 'Vi ankoraŭ havas {{PLURAL:$2|unu ceteran inviton|<b>$1</b> el via $2 ceterajn invitojn}}.',
	'invitations-feature-noneleft'          => 'Vi jam uzis ĉiujn de viaj disdonitaj invitoj por ĉi tiu programero',
	'invitations-feature-noneyet'           => 'Vi ne jam ricevis vian disdonon de invitoj por ĉi tiu programero.',
	'invitations-feature-notallowed'        => 'Vi ne havas atingon por uzi <i>$1</i>.',
	'invitations-inviteform-title'          => 'Invitu uzanton por uzi programeron $1',
	'invitations-inviteform-username'       => 'Uzanto por inviti',
	'invitations-inviteform-submit'         => 'Inviti',
	'invitations-error-baduser'             => 'La uzanto kiun vi enigis verŝajne ne ekzistas.',
	'invitations-error-alreadyinvited'      => 'La uzanto kiun vi enigis jam povas atingi ĉi tiun programeron!',
	'invitations-invite-success'            => 'Vi sukcesis inviti $1 por uzi ĉi tiun programeron!',
);

/** Spanish (Español)
 * @author Dmcdevit
 * @author Jatrobat
 */
$messages['es'] = array(
	'invitations-desc'                      => 'Permite [[Especial:Invitaciones|control de funciones nuevas]] por restringirlas a un sistema basado en invitaciones.',
	'invitations-invitedlist-description'   => 'Tiene acceso a los siguientes funciones sólo por invitación. Para manejar invitaciones a una función específica, haga clic en su nombre.',
	'invitations-invitedlist-none'          => 'No ha sido invitado usar ninguna función sólo por invitación.',
	'invitations-pagetitle'                 => 'Funciones sólo por invitación',
	'invitations-uninvitedlist-description' => 'No tiene acceso a estas otras functiones sólo por invitación.',
	'invitations-uninvitedlist-none'        => 'Ahora mismo, ninguna otra función está designado sólo por invitación.',
	'invitations-feature-pagetitle'         => 'Gestión de invitaciones - $1',
	'invitations-feature-access'            => 'Tiene permiso para usar <i>$1</i>.',
	'invitations-feature-numleft'           => 'Todavía tiene <b>$1</b> de sus $2 invitaciones.',
	'invitations-feature-noneleft'          => 'Ha usado todo de sus invitaciones destinado a esta función.',
	'invitations-feature-noneyet'           => 'No ha recibido su cuota de invitaciones para esta función.',
	'invitations-feature-notallowed'        => 'No tiene permiso para usar <i>$1</i>.',
	'invitations-inviteform-title'          => 'Invitar a un usuario a usar $1',
	'invitations-inviteform-username'       => 'Usuario para invitar',
	'invitations-inviteform-submit'         => 'Invitar',
	'invitations-error-baduser'             => 'El usuario que usted eligió no existe.',
	'invitations-error-alreadyinvited'      => 'El usuario que usted eligío ya tiene acceso a esta función!',
	'invitations-invite-success'            => 'Ha invitado con éxito a $1 usar esta función.',
);

/** French (Français)
 * @author Grondin
 * @author Verdy p
 */
$messages['fr'] = array(
	'invite-logpage'                        => 'Journal des invitations',
	'invite-logpagetext'                    => 'Voici un journal des utilisateurs en invitant d’autres pour utiliser les fonctionnalités de divers programmes',
	'invite-logentry'                       => 'a invité $1 à utiliser la fonctionnalité de <i>$2</i>.',
	'invitations'                           => 'Gère les invitations des fonctionnalités logicielles',
	'invitations-desc'                      => 'Permet [[Special:Invitations|la gestion des nouvelles fonctionnalités]] en les restreignant par une système basé sur l’invitation.',
	'invitations-invitedlist-description'   => "Vous avez l'accès aux caractéristiques suivantes du logiciel d’invite seule. Pour gérer les invitations pour une catactéristique individuelle, cliquez sur son nom.",
	'invitations-invitedlist-none'          => 'Vous n’avez pas été invité pour utiliser les fonctionnalités du logiciel d’invite seule.',
	'invitations-invitedlist-item-count'    => '({{PLURAL:$1|Une invitation disponible|$1 invitations disponibles}})',
	'invitations-pagetitle'                 => 'Fonctionnalités du logiciel d’invite seule',
	'invitations-uninvitedlist-description' => 'Vous n’avez pas l’accès à ces autres caractéristiques du programme d’invite seule.',
	'invitations-uninvitedlist-none'        => 'À cet instant, aucune fonctionnalité logicielle n’a été désignée par l’invite seule.',
	'invitations-feature-pagetitle'         => 'Gestion de l’invitation - $1',
	'invitations-feature-access'            => 'Vous avez actuellement l’accès pour utiliser <i>$1</i>.',
	'invitations-feature-numleft'           => 'Il vous reste encore {{PLURAL:$2|une invitation|<b>$1</b> de vos $2 invitations}}.',
	'invitations-feature-noneleft'          => "Vous avez utilisé l'ensemble de vos invitations permises pour cette fonctionnalité",
	'invitations-feature-noneyet'           => 'Vous n’avez pas cependant reçu votre assignation des invitations pour cette fonctionnalité.',
	'invitations-feature-notallowed'        => 'Vous n’avez pas l’accès pour utiliser <i>$1</i>.',
	'invitations-inviteform-title'          => 'Inviter un utilisateur pour utiliser $1',
	'invitations-inviteform-username'       => 'Utilisateur à inviter',
	'invitations-inviteform-submit'         => 'Inviter',
	'invitations-error-baduser'             => 'L’utilisateur que vous avez indiqué ne semble pas exister.',
	'invitations-error-alreadyinvited'      => 'L’utilisateur que vous avez indiqué dispose déjà de l’accès à cette fonctionnalité !',
	'invitations-invite-success'            => 'Vous invité $1 avec succès pour utiliser cette fonctionnalité !',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'invite-logpage'                        => 'Rexistro de invitacións',
	'invite-logpagetext'                    => 'Este é un rexistro dos usuarios que invitaron a outros a usar varias características do software.',
	'invite-logentry'                       => 'invitou a $1 a usar a característica <i>$2</i>.',
	'invitations'                           => 'Xestionar as caractarísticas do software das invitacións',
	'invitations-desc'                      => 'Permite [[Special:Invitations|a xestión de características novas]] a través da restrición nun sistema de invitación base',
	'invitations-invitedlist-description'   => 'Ten acceso ás seguintes características do software só por invitación.
Para xestionar as invitacións para unha característica individual, faga clic no seu nome.',
	'invitations-invitedlist-none'          => 'Non foi convidado a usar nunha das características do software só por invitación.',
	'invitations-invitedlist-item-count'    => '({{PLURAL:$1|Unha invitación dispoñible|$1 invitacións dispoñibles}})',
	'invitations-pagetitle'                 => 'Características do software só por invitación',
	'invitations-uninvitedlist-description' => 'Non ten acceso a estoutras características do software só por invitación.',
	'invitations-uninvitedlist-none'        => 'Arestora, ningunha outra característica do software é designada só por invitación.',
	'invitations-feature-pagetitle'         => 'Xestión da invitación - $1',
	'invitations-feature-access'            => 'Actualmente ten acceso para usar <i>$1</i>.',
	'invitations-feature-numleft'           => 'Aínda ten {{PLURAL:$2|unha invitación restante|<b>$1</b>, dun total de $2 invitaciones restantes}}.',
	'invitations-feature-noneleft'          => 'Usou todas as súas invitacións asignadas a esta característica',
	'invitations-feature-noneyet'           => 'Aínda no recibiu a súa asignación de invitacións para esta característica.',
	'invitations-feature-notallowed'        => 'Non ten acceso para usar <i>$1</i>.',
	'invitations-inviteform-title'          => 'Invitar a un usuario a usar $1',
	'invitations-inviteform-username'       => 'Usuario para invitar',
	'invitations-inviteform-submit'         => 'Invitar',
	'invitations-error-baduser'             => 'Parece que o usuario que especificou non existe.',
	'invitations-error-alreadyinvited'      => 'O usuario que especificou xa ten acceso a esta característica!',
	'invitations-invite-success'            => 'Invitou con éxito a $1 para usar esta característica!',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'invite-logpage'                        => 'आमंत्रण सूची',
	'invite-logpagetext'                    => 'यह अलग‍अलग प्रणाली फीचर्स का इस्तेमाल करके देखनेके लिये सदस्योंने एक दूसरे को दिये आमंत्रणोंकी सूची हैं।',
	'invite-logentry'                       => '<i>$2</i> फीचर इस्तेमाल करने के लिये $1 को आमंत्रित किया।',
	'invitations'                           => 'प्रणाली फीचर्स को दी हुई आमंत्रण नियंत्रित करें',
	'invitations-invitedlist-none'          => 'आपको आमंत्रण आधारित प्रणाली फीचर्स देखनेके लिये एक भी आमंत्रण नहीं मिला हैं।',
	'invitations-pagetitle'                 => 'आमंत्रण आधारित प्रणाली फीचर्स',
	'invitations-uninvitedlist-description' => 'आपको यह अन्य आमंत्रण आधारित प्रणाली फीचर्स देखनेकी अनुमति नहीं हैं।',
	'invitations-uninvitedlist-none'        => 'इस समयपर, अन्य कोईभी प्रणाली फीचर आमंत्रण आधारित नहीं रखा गया हैं।',
	'invitations-feature-pagetitle'         => 'आमंत्रण व्यवस्थापन - $1',
	'invitations-feature-access'            => 'आपको अभी <i>$1</i> का इस्तेमाल करने की अनुमति हैं।',
	'invitations-feature-numleft'           => 'आपके पास अबभी $2 में से <b>$1</b> आमंत्रण बचे हुए हैं।',
	'invitations-feature-noneleft'          => 'इस फीचर के लिये दिये गये सभी आमंत्रण आपने इस्तेमाल कर दिये हैं',
	'invitations-feature-noneyet'           => 'इस फीचर के लिये अभी तक आपको आमंत्रण नहीं मिले हैं।',
	'invitations-feature-notallowed'        => 'आपको <i>$1</i> का इस्तेमाल करने की अनुमति नहीं हैं।',
	'invitations-inviteform-title'          => '$1 के इस्तेमाल के लिये सदस्यको आमंत्रित करें',
	'invitations-inviteform-username'       => 'आमंत्रित करनेके लिये सदस्य',
	'invitations-inviteform-submit'         => 'आमंत्रित करें',
	'invitations-error-baduser'             => 'आपने दिया हुआ सदस्य अस्तित्वमें नहीं हैं।',
	'invitations-error-alreadyinvited'      => 'आपने दिये हुए सदस्य को यह फीचर का इस्तेमाल करने की पहले से अनुमति हैं!',
	'invitations-invite-success'            => 'आपने $1 को यह फीचर इस्तेमाल करने के लिये आमंत्रित किया!',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'invite-logpage'                   => 'Log Undhangan',
	'invitations-feature-access'       => 'Panjenengan saiki ana aksès kanggo nganggo <i>$1</i>.',
	'invitations-feature-notallowed'   => 'Panjenengan ora ana aksès nganggo <i>$1</i>.',
	'invitations-inviteform-title'     => 'Undhang sawijining panganggo supaya nganggo $1',
	'invitations-inviteform-username'  => 'Panganggo sing diundhang',
	'invitations-inviteform-submit'    => 'Undhang',
	'invitations-error-alreadyinvited' => 'Panganggo sing dispésifikasi panjenengan wis duwé aksès ing fitur iki!',
	'invitations-invite-success'       => 'Panjenengan bisa sacara suksès ngundhang $1 supaya nganggo fitur iki!',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author Chhorran
 * @author Lovekhmer
 */
$messages['km'] = array(
	'invite-logpage'                  => 'កំនត់ហេតុនៃការអញ្ជើញ',
	'invitations-inviteform-title'    => 'អញ្ជើញអ្នកប្រើប្រាស់ម្នាក់អោយប្រើ $1',
	'invitations-inviteform-username' => 'អ្នកប្រើប្រាស់​ដែលត្រូវអញ្ជើញ',
	'invitations-inviteform-submit'   => 'អញ្ជើញ',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'invite-logpage'                     => 'Lëscht vun den Invitatiounen',
	'invite-logentry'                    => "huet $1 invitéiert fir d'Functionalitéit <i>$2</i> ze benotzen.",
	'invitations'                        => 'Gestioun vun den Invitatioune fir Software-Functionalitéiten',
	'invitations-desc'                   => "Erméiglecht d'[[Special:Invitations|Gestioun vun neie Fonctionnalitéiten]] déi op déi Benotzer limitéiert sinn, déi dofir invitéiert ginn",
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Eng Invitatioun|$1 Invitatioune}} disponibel)',
	'invitations-pagetitle'              => 'Fonctionnalitéiten op Invitatiouns-Basis',
	'invitations-feature-pagetitle'      => 'Gestioun vun der Invitatioun - $1',
	'invitations-feature-access'         => 'Dir kënnt elo <i>$1</i> benotzen.',
	'invitations-feature-numleft'        => 'Dir hutt nach {{PLURAL:$2|eng Invitatioun |<b>$1</b> vun ären $2 Invitatiounen}} iwwreg.',
	'invitations-feature-noneleft'       => 'Dir hutt all är Invitatiounen fir dës Fonctioun benotzt.',
	'invitations-feature-noneyet'        => 'Dir hutt är Invitatioune fir dës Fonctioun nach net kritt.',
	'invitations-feature-notallowed'     => 'Dir hutt keen Zougang fir <i>$1</i> ze benotzen.',
	'invitations-inviteform-title'       => 'Ee Benotzer alueden fir $1 ze benotzen',
	'invitations-inviteform-username'    => 'Benotzer fir anzelueden',
	'invitations-inviteform-submit'      => 'Alueden',
	'invitations-error-baduser'          => 'De Benotzer deen Dir uginn huet schéngt et net ze ginn.',
	'invitations-error-alreadyinvited'   => 'Dee Benotzer deen Dir uginn huet huet schonn Accès op déi Fonctioun!',
	'invitations-invite-success'         => 'Dir hutt de(n) $1 invitéiert fir dës Fonctioun ze benotzen!',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'invite-logpage'                        => 'ക്ഷണത്തിന്റെ പ്രവര്‍ത്തനരേഖ',
	'invite-logpagetext'                    => 'വിവിധ സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകള്‍ പരീക്ഷിക്കുവാന്‍ ഉപയോക്താക്കള്‍ അന്യോന്യം ക്ഷണിക്കുന്നതിന്റെ പ്രവര്‍ത്തന രേഖയാണിത്.',
	'invite-logentry'                       => '<i>$2</i> എന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷത ഉപയോഗിക്കുവാന്‍  $1നെ ക്ഷണിച്ചു.',
	'invitations'                           => 'സോഫ്റ്റ്‌വെയര്‍ സവിശേഷത പരീക്ഷിക്കുവാനുള്ള ക്ഷണപത്രികകള്‍ പരിപാലിക്കുക',
	'invitations-invitedlist-description'   => 'ക്ഷണത്തിലൂടെ മാത്രം പരീക്ഷിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകളില്‍,  താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്നവ‍ താങ്കള്‍ക്ക് പരീക്ഷിക്കാം. ഒരു പ്രത്യേക സവിശേഷതയ്ക്കുള്ള ക്ഷണപത്രിക പരിപാലിക്കാന്‍, പ്രസ്തുത പേരില്‍ ഞെക്കുക.',
	'invitations-invitedlist-none'          => "'''ക്ഷണത്തിലൂടെ മാത്രം പരീക്ഷിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷത'''കള്‍ ഉപയോഗിക്കുവാന്‍ താങ്കള്‍ ക്ഷണിക്കപ്പെട്ടിട്ടില്ല.",
	'invitations-pagetitle'                 => 'ക്ഷണത്തിലൂടെ മാത്രം ഉപയോഗിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകള്‍',
	'invitations-uninvitedlist-description' => "മറ്റ് '''ക്ഷണത്തിലൂടെ മാത്രം പരീക്ഷിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകള്‍''' ഉപയോഗിക്കാനുള്ള അനുമതി  താങ്കള്‍ക്കില്ല.",
	'invitations-uninvitedlist-none'        => "നിലവില്‍ മറ്റു സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകള്‍ ഒന്നും '''ക്ഷണത്തിലൂടെ മാത്രം പരീക്ഷിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷത''' ആയി രേഖപ്പെടുത്തിയിട്ടില്ല.",
	'invitations-feature-pagetitle'         => 'ക്ഷണപത്രിക പരിപാലനം -  $1',
	'invitations-feature-access'            => 'താങ്കള്‍‍ക്ക് നിലവില്‍ <i>$1</i> ഉപയോഗിക്കാനുള്ള അനുമതിയുണ്ട്.',
	'invitations-feature-numleft'           => 'ബാക്കിയുള്ള $2 ക്ഷണപത്രികകളില്‍ താങ്കള്‍ക്ക് ഇപ്പോഴും  <b>$1</b> എണ്ണമുണ്ട്.',
	'invitations-feature-noneleft'          => 'ഈ സവിശേഷതയുടെ ലഭ്യമായ ക്ഷണപത്രികകളെല്ലാം താങ്കള്‍ ഉപയോഗിച്ചു കഴിഞ്ഞു.',
	'invitations-feature-noneyet'           => 'ഈ സവിശേഷതയുടെ താങ്കള്‍ക്ക് വരേണ്ട ക്ഷണപത്രിക താങ്കള്‍ക്ക് ലഭിച്ചിട്ടില്ല.',
	'invitations-feature-notallowed'        => 'നിങ്ങള്‍ക്ക്  <i>$1</i> ഉപയോഗിക്കാനുള്ള അനുമതി ഇല്ല.',
	'invitations-inviteform-title'          => '$1 ഉപയോഗിക്കുവാന്‍ വേണ്ടി ഉപയോക്താവിനെ ക്ഷണിക്കുക',
	'invitations-inviteform-username'       => 'ക്ഷണിക്കപ്പെടേണ്ട ഉപയോക്താവ്',
	'invitations-inviteform-submit'         => 'ക്ഷണിക്കുക',
	'invitations-error-baduser'             => 'താങ്കള്‍ തിരഞ്ഞെടുത്ത ഉപയോക്തൃനാമം നിലവിലുള്ളതായി കാണുന്നില്ല.',
	'invitations-error-alreadyinvited'      => 'താങ്കള്‍ തിരഞ്ഞെടുത്ത ഉപയോക്താവിനു ഇപ്പോള്‍ തന്നെ ഈ സവിശേഷത ലഭ്യമാണ്‌.',
	'invitations-invite-success'            => 'ഈ സവിശേഷത ഉപയോഗിക്കുവാന്‍ താങ്കള്‍ $1നെ വിജയകരമായി ക്ഷണിച്ചിരിക്കുന്നു!',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'invite-logpage'                        => 'आमंत्रणांची सूची',
	'invite-logpagetext'                    => 'ही वेगवेगळ्या प्रणालींचे फीचर्स वापरून पाहण्यासाठी सदस्यांनी एकमेकांना दिलेल्या आमंत्रणांची सूची आहे.',
	'invite-logentry'                       => '<i>$2</i> फीचर वापरण्यासाठी $1 ला आमंत्रित केले.',
	'invitations'                           => 'प्रणाली फीचर्स ला दिलेली आमंत्रणे नियंत्रित करा',
	'invitations-desc'                      => 'आमंत्रण आधारित करुन [[Special:Invitations|नवीन फीचर्सना नियंत्रित]] करण्याची परवानगी देते',
	'invitations-invitedlist-description'   => 'तुम्हाला खालीलपैकी फक्त आमंत्रण आधारित प्रणाली फीचर्स पाहता येतील.
एखाद्या विशिष्ट फीचर्सची आमंत्रणे पाहण्यासाठी, त्याच्या नावावर टिचकी द्या.',
	'invitations-invitedlist-none'          => 'तुम्हाला आमंत्रण आधारित प्रणाली फीचर्स पाहण्यासाठी एकही आमंत्रण आलेले नाही.',
	'invitations-pagetitle'                 => 'आमंत्रण आधारित प्रणाली फीचर्स',
	'invitations-uninvitedlist-description' => 'तुम्हाला ही इतर आमंत्रण आधारित प्रणाली वैशिष्ठ्ये पाहण्याची अनुमती नाही.',
	'invitations-uninvitedlist-none'        => 'या वेळी, इतर कुठलेही प्रणाली वैशिष्ठ्य आमंत्रण आधारित केलेले नाही.',
	'invitations-feature-pagetitle'         => 'आमंत्रण व्यवस्थापन - $1',
	'invitations-feature-access'            => 'तुम्हाला सध्या <i>$1</i> वापरण्याची अनुमती आहे.',
	'invitations-feature-numleft'           => 'तुमच्याकडे अजून $2 पैकी <b>$1</b> आमंत्रणे उरलेली आहेत.',
	'invitations-feature-noneleft'          => 'या फीचरसाठी देण्यात आलेली सर्व आमंत्रणे तुम्ही वापरलेली आहेत',
	'invitations-feature-noneyet'           => 'या फीचरसाठी अजून तुम्हाला आमंत्रणे देण्यात आलेली नाहीत.',
	'invitations-feature-notallowed'        => 'तुम्हाला <i>$1</i> वापरण्याची परवानगी नाही.',
	'invitations-inviteform-title'          => '$1 वापरण्यासाठी एखाद्या सदस्याला आमंत्रण द्या',
	'invitations-inviteform-username'       => 'आमंत्रित करावयाचा सदस्य',
	'invitations-inviteform-submit'         => 'आमंत्रित करा',
	'invitations-error-baduser'             => 'तुम्ही दिलेला सदस्य अस्तित्वात नाही.',
	'invitations-error-alreadyinvited'      => 'तुम्ही दिलेल्या सदस्याला अगोदरच हे फीचर वापरण्याची परवानगी आहे!',
	'invitations-invite-success'            => 'तुम्ही यशस्वीरित्या $1 ला हे फीचर वापरण्यासाठी आमंत्रित केलेले आहे!',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'invite-logpage'                        => 'Uitnodigingslogboek',
	'invite-logpagetext'                    => 'Dit is een logboek van gebruikers die elkaar uitnodigen om verschillende softwarefuncties te gebruiken.',
	'invite-logentry'                       => 'heeft $1 uitgenodigd om de functie <i>$2</i> te gebruiken.',
	'invitations'                           => 'Uitnodigingen voor softwarefuncties beheren',
	'invitations-desc'                      => 'Maakt het mogelijk het gebruik van [[Special:Invitations|nieuwe functionaliteit te beheren]] door deze alleen op uitnodiging beschikbaar te maken',
	'invitations-invitedlist-description'   => 'U hebt toegang tot de volgende alleen op uitnodiging beschikbare functionaliteit. Om te verzenden uitnodigingen per functionaliteit te beheren, kunt u op de naam van de functionaliteit klikken.',
	'invitations-invitedlist-none'          => 'U bent niet uitgenodigd om alleen op uitnodiging beschikbare functionaliteit te gebruiken.',
	'invitations-invitedlist-item-count'    => '({{PLURAL:$1|Eén uitnodiging|$1 uitnodiging}} beschikbaar)',
	'invitations-pagetitle'                 => 'Functionaliteit alleen op uitnodiging beschikbaar',
	'invitations-uninvitedlist-description' => 'U hebt geen toegang tot deze andere alleen op uitnodiging beschikbare functionaliteit.',
	'invitations-uninvitedlist-none'        => 'Er is op dit moment geen functionaliteit aangewezen die alleen op uitnodiging beschikbaar is.',
	'invitations-feature-pagetitle'         => 'Uitnodigingenbeheer - $1',
	'invitations-feature-access'            => 'U hebt op dit moment toestemming om <i>$1</i> te gebruiken.',
	'invitations-feature-numleft'           => 'U hebt nog {{PLURAL:$2|één uitnodiging|<b>$1</b> van uw $2 uitnodigingen}} over.',
	'invitations-feature-noneleft'          => 'U hebt alle uitnodigingen voor deze functionaliteit gebruikt',
	'invitations-feature-noneyet'           => 'U hebt nog geen te verdelen uitnodigingen gekregen voor deze functionaliteit.',
	'invitations-feature-notallowed'        => 'U hebt geen toestemming om <i>$1</i> te gebruiken.',
	'invitations-inviteform-title'          => 'Een gebruiker uitnodigen om $1 te gebruiken',
	'invitations-inviteform-username'       => 'Uit te nodigen gebruiker',
	'invitations-inviteform-submit'         => 'Uitnodigen',
	'invitations-error-baduser'             => 'De opgegeven gebruiker lijkt niet te bestaan.',
	'invitations-error-alreadyinvited'      => 'De opgegeven gebruiker heeft al toegang tot deze functionaliteit.',
	'invitations-invite-success'            => '$1 is uitgenodigd voor het gebruiken van deze functionaliteit!',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'invite-logpage'                        => 'Invitasjonslogg',
	'invite-logpagetext'                    => 'Dette er en logg over hvilke brukere som har invitert hverandre til å bruke diverse programvarefunksjoner.',
	'invite-logentry'                       => 'inviterte $1 til å bruke funksjonen <i>$2</i>',
	'invitations'                           => 'Behandling av intiasjoner til programvarefunksjoner',
	'invitations-desc'                      => 'Gjør det mulig å [[Special:Invitations|kontrollere nye funksjoner]] ved å begrense dem med et invitasjonsbasert system',
	'invitations-invitedlist-description'   => 'Du har tilgang til følgende funksjoner som krever invitasjon. Klikk på funksjonens navn for å behandle invitasjoner for de enkelte funksjonene.',
	'invitations-invitedlist-none'          => 'Du har ikke blitt invitert til å bruke noen funksjoner som krever invitasjon.',
	'invitations-invitedlist-item-count'    => '({{PLURAL:$1|Én invitasjon er tilgjengelig|$1 invitasjoner er tilgjengelige}})',
	'invitations-pagetitle'                 => 'Funksjoner som krever invitasjon',
	'invitations-uninvitedlist-description' => 'Du har ikke tilgang til disse funksjonene som krever invitasjon.',
	'invitations-uninvitedlist-none'        => 'Ingen programvarefunksjoner krever invitasjon.',
	'invitations-feature-pagetitle'         => 'Invitasjonsbehandling – $1',
	'invitations-feature-access'            => 'Du har tilgang til å bruke <i>$1</i>.',
	'invitations-feature-numleft'           => 'Av dine $2 invitasjoner har du fortsatt {{PLURAL:$1|én|<b>$1</b>}} igjen.',
	'invitations-feature-noneleft'          => 'Du har brukt alle dine invitasjoner for denne funksjonen',
	'invitations-feature-noneyet'           => 'Du har ikke fått tildelt din andel invitasjoner for denne funksjonen.',
	'invitations-feature-notallowed'        => 'Du har ikke tilgang til å bruke <i>$1</i>.',
	'invitations-inviteform-title'          => 'Inviter en bruker til å bruke $1',
	'invitations-inviteform-username'       => 'Bruker som skal inviteres',
	'invitations-inviteform-submit'         => 'Inviter',
	'invitations-error-baduser'             => 'Brukeren du oppga finnes ikke.',
	'invitations-error-alreadyinvited'      => 'Brukeren du oppga har allerede tilgang til denne funksjonen!',
	'invitations-invite-success'            => 'Du har invitert $1 til å bruke denne funksjonen!',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'invite-logpage'                        => 'Jornal dels convits',
	'invite-logpagetext'                    => 'Vaquí un jornal dels utilizaires en convidant d’autres per utilizar las foncionalitats de divèrses programas',
	'invite-logentry'                       => 'a convidat $1 a utilizar la foncionalitat de <i>$2</i>.',
	'invitations'                           => 'Gerís los convits de las foncionalitats logicialas',
	'invitations-desc'                      => 'Permet [[Special:Invitations|la gestion de las foncionalitats novèlas]] en las restrenhent per un sistèma basat sul convit.',
	'invitations-invitedlist-description'   => 'Avètz accès a las caracteristicas seguentas del logicial de convit sol. Per gerir los convits per una catacteristica individuala, clicatz sus son nom.',
	'invitations-invitedlist-none'          => 'Sètz pas estat convidat per utilizar las foncionalitats del logicial de convit sol.',
	'invitations-invitedlist-item-count'    => '({{PLURAL:$1|Un convit disponible|$1 convits disponibles}})',
	'invitations-pagetitle'                 => 'Foncionalitats del logiciel de convit sol',
	'invitations-uninvitedlist-description' => 'Avètz pas accès a aquestas autras caracteristicas del programa de convit sol.',
	'invitations-uninvitedlist-none'        => 'En aqueste moment, cap de foncionalitat logiciala es pas estada designada pel convit sol.',
	'invitations-feature-pagetitle'         => 'Gestion del convit - $1',
	'invitations-feature-access'            => "Actualament, avètz l'accès per utilizar <i>$1</i>.",
	'invitations-feature-numleft'           => 'Avètz encara {{PLURAL:$2|un convit vòstre daissat|<b>$1</b> $2 convits vòstres daissats}}.',
	'invitations-feature-noneleft'          => "Avètz utilizat l'ensemble de vòstres convits permeses per aquesta foncionalitat",
	'invitations-feature-noneyet'           => 'Çaquelà, avètz pas recebut vòstra assignacion dels convits per aquesta foncionalitat.',
	'invitations-feature-notallowed'        => 'Avètz pas l’accès per utilizar <i>$1</i>.',
	'invitations-inviteform-title'          => 'Convidar un utilizaire per utilizar $1',
	'invitations-inviteform-username'       => 'Utilizaire de convidar',
	'invitations-inviteform-submit'         => 'Convidar',
	'invitations-error-baduser'             => "L’utilizaire qu'avètz indicat sembla pas existir.",
	'invitations-error-alreadyinvited'      => "L’utilizaire qu'avètz indicat ja dispausa de l’accès a aquesta foncionalitat !",
	'invitations-invite-success'            => 'Avètz convidat $1 amb succès per utilizar aquesta foncionalitat !',
);

/** Polish (Polski)
 * @author McMonster
 * @author Sp5uhe
 * @author Maikking
 */
$messages['pl'] = array(
	'invite-logentry'                => 'zaprosił $1 do używania dodatku <i>$2</i>',
	'invitations-feature-notallowed' => 'Nie masz odpowiednich uprawnień do korzystania z <i>$1</i>.',
	'invitations-inviteform-submit'  => 'Zaproś',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'invitations-feature-notallowed'  => 'تاسو د <i>$1</i> د کارونې لاسرسی نه لری.',
	'invitations-inviteform-title'    => 'يوه کارونکي ته د $1 د کارولو بلنه ورکول',
	'invitations-inviteform-username' => 'بلل شوی کارونکی',
	'invitations-inviteform-submit'   => 'بلنه ورکول',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author 555
 * @author Siebrand
 */
$messages['pt'] = array(
	'invite-logpage'                        => 'Registo de Convites',
	'invite-logpagetext'                    => 'Isto é um registo de utilizadores que se convidam uns aos outros a usarem as várias funcionalidades do software.',
	'invite-logentry'                       => 'convidou $1 a usar a funcionalidade <i>$2</i>.',
	'invitations'                           => 'Gerir convites para funcionalidades de software',
	'invitations-desc'                      => 'Permite [[Special:Invitations|a gestão de novas funcionalidades]] através da sua restrição a um sistema baseado em convites',
	'invitations-invitedlist-description'   => 'Você tem acesso às seguintes funcionalidades do software atribuídas apenas por convite. Para gerir convites para uma funcionalidade individual, clique no seu nome.',
	'invitations-invitedlist-none'          => 'Você não foi convidado a usar nenhuma funcionalidade do software atribuída apenas por convite.',
	'invitations-pagetitle'                 => 'Funcionalidades do software atribuídas apenas por convite',
	'invitations-uninvitedlist-description' => 'Você não tem acesso a estas outras funcionalidades do software atribuídas apenas por convite.',
	'invitations-uninvitedlist-none'        => 'Neste momento, mais nenhumas funcionalidades do software são atribuídas apenas por convite.',
	'invitations-feature-pagetitle'         => 'Gestão de Convites - $1',
	'invitations-feature-access'            => 'Actualmente não possui acesso ao uso de <i>$1</i>.',
	'invitations-feature-numleft'           => 'Ainda lhe {{PLURAL:$2|resta um|restam <b>$1</b>}} dos seus $2 convites.',
	'invitations-feature-noneleft'          => 'Você já utilizou toda a sua quota de convites para esta funcionalidade',
	'invitations-feature-noneyet'           => 'Você ainda não recebeu a sua quota de convites para esta funcionalidade.',
	'invitations-feature-notallowed'        => 'Não tem acesso ao uso de <i>$1</i>.',
	'invitations-inviteform-title'          => 'Convidar um utilizador a usar $1',
	'invitations-inviteform-username'       => 'Utilizador a convidar',
	'invitations-inviteform-submit'         => 'Convidar',
	'invitations-error-baduser'             => 'O utilizador que especificou parece não existir.',
	'invitations-error-alreadyinvited'      => 'O utilizador que especificou já tem acesso a esta funcionalidade!',
	'invitations-invite-success'            => 'Convidou $1 para usar esta funcionalidade com sucesso!',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'invite-logpage'                        => 'Журнал приглашений',
	'invite-logpagetext'                    => 'Это журнал приглашений использовать возможности программного обеспечения',
	'invite-logentry'                       => 'пригласил $1 использовать возможность <i>$2</i>',
	'invitations'                           => 'Управление приглашениями на возможности ПО',
	'invitations-desc'                      => 'Позволяет [[Special:Invitations|управлять новыми возможностями]], ограничивая к ним доступ с помощью системы приглашений',
	'invitations-invitedlist-description'   => 'Вы имеете доступ к следующим возможностям программного обеспечения, доступным только по приглашениям. Чтобы управлять приглашениями каждой возможности ПО, щёлкните по её имени.',
	'invitations-invitedlist-none'          => 'Вы не были приглашены использовать какую-либо возможность программы, из доступных только по приглашениям.',
	'invitations-pagetitle'                 => 'Возможность ПО только по приглашению',
	'invitations-uninvitedlist-description' => 'У вас нет доступа к другим возможностям ПО, доступным только по приглашениям.',
	'invitations-uninvitedlist-none'        => 'В настоящее время нет других возможностей ПО, доступных только по приглашениям.',
	'invitations-feature-pagetitle'         => 'Управление приглашениями — $1',
	'invitations-feature-access'            => 'Сейчас вы имеете доступ к использованию <i>$1</i>.',
	'invitations-feature-numleft'           => 'У вас остаётся <b>$1</b> из $2 приглашений.',
	'invitations-feature-noneleft'          => 'Вы использовали все выделенные вам приглашения для этой возможности',
	'invitations-feature-noneyet'           => 'Вам ещё не было выделено приглашений для рассылки для этой возможности',
	'invitations-feature-notallowed'        => 'У вас нет доступа к использованию <i>$1</i>.',
	'invitations-inviteform-title'          => 'Приглашение участника использовать $1',
	'invitations-inviteform-username'       => 'Участник',
	'invitations-inviteform-submit'         => 'Пригласить',
	'invitations-error-baduser'             => 'Участника, которого вы указали, по-видимому не существует.',
	'invitations-error-alreadyinvited'      => 'Участник, которого вы указали, уже имеет доступ к этой возможности!',
	'invitations-invite-success'            => 'Вы успешно пригласили участника $1 использовать эту возможность!',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'invite-logpage'                        => 'Záznam pozvánok',
	'invite-logpagetext'                    => 'Toto je záznam používateľov pozývajúcich sa navzájom používať rozličné možnosti softvéru.',
	'invite-logentry'                       => 'pozval $1 používať možnosť <i>$2</i>.',
	'invitations'                           => 'Spravovať pozvánky možností softvéru',
	'invitations-desc'                      => 'Umožňuje [[Special:Invitations|správu nových možností]] obmedzením prístupu k nim na báze pozvánok',
	'invitations-invitedlist-description'   => 'Máte prístup k nasledovným možnostiam softvéru, ktoré sú prístupné iba na báze pozvánok. Spravovať pozvánky jednotlivých možností môžete po kliknutí na jej názov.',
	'invitations-invitedlist-none'          => 'Neboli ste pozvaný používať žiadnu z možností softvéru s prístupom len na pozvanie.',
	'invitations-invitedlist-item-count'    => '({{PLURAL:$1|Dostupná jedna pozvánka|Dostupné $1 pozvánky|Dostupných $1 pozvánok}})',
	'invitations-pagetitle'                 => 'Možnosti softvéru s prístupom len na pozvanie.',
	'invitations-uninvitedlist-description' => 'Nemáte prístup k týmto ostatným možnostiam softvéru s prístupom len na pozvanie.',
	'invitations-uninvitedlist-none'        => 'Momentálne nie je prístup k žiadnym iným možnostiam softvéru určený len na pozvanie.',
	'invitations-feature-pagetitle'         => 'Správa pozvánok - $1',
	'invitations-feature-access'            => 'Momentálne máte prístup na používanie <i>$1</i>.',
	'invitations-feature-numleft'           => '{{PLURAL:$1|Zostáva vám <b>$1 pozvánka</b>|Zostávajú vám <b>$1 pozvánky</b>|Zostáva vám <b>$1 pozvánok</b>}} z {{PLURAL:$2|vašej $2 pozvánky|vašich $2 pozvánok}}.',
	'invitations-feature-noneleft'          => 'Využili ste všetky z vašich vyhradených pozvánok na prístup k tejto možnosti',
	'invitations-feature-noneyet'           => 'Zatiaľ ste nedostali svoj podiel pozvánok na prístup k tejto možnosti.',
	'invitations-feature-notallowed'        => 'Nemáte právo na prístup k <i>$1</i>.',
	'invitations-inviteform-title'          => 'Pozvať používateľa na používanie $1',
	'invitations-inviteform-username'       => 'Pozvať používateľa',
	'invitations-inviteform-submit'         => 'Pozvať',
	'invitations-error-baduser'             => 'Zdá sa, že používateľ, ktorého ste uviedli neexistuje.',
	'invitations-error-alreadyinvited'      => 'Používateľ, ktorého ste uviedli, už má prístup k tejto možnosti.',
	'invitations-invite-success'            => 'Úspešne ste pozvali používateľa $1 využívať túto možnosť!',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'invite-logpage'                        => 'Ienleedengs-Logbouk',
	'invite-logpagetext'                    => 'Dit is dät Logbouk fon do ienleedengsbasierde Softwarefunktione.',
	'invite-logentry'                       => 'häd $1 ienleeden, uum do Softwarefunktione <i>$2</i> tou bruuken.',
	'invitations-desc'                      => 'Moaket ju [[Special:Invitations|Ferwaltenge fon Softwarefunktione]] ap Gruund fon Ienleedengen muugelk',
	'invitations-invitedlist-description'   => 'Du hääst Tougoang tou do foulgjende ienleedengsbasierde Softwarefunktione. Uum Ienleedengen foar ne bestimde Softwarefunktion tou ferwaltjen, klik ap hieren Noome.',
	'invitations-invitedlist-none'          => 'Du hääst tou nu tou neen Ienleedengen foar dät Bruuken fon ienleedengsbasierde Softwarefunktione kriegen.',
	'invitations-pagetitle'                 => 'Softwarefunktione ap Ienleedengs-Basis',
	'invitations-uninvitedlist-description' => 'Du hääst naan Tougoang tou uur ienleedengsbasierde Softwarefunktione',
	'invitations-uninvitedlist-none'        => 'Apstuuns sunt neen wiedere Softwarefunktione ienleedengsbasierd',
	'invitations-feature-pagetitle'         => 'Ienleedengsferwaltenge - $1',
	'invitations-feature-access'            => 'Du hääst Tougoang toun Gebruuk fon <i>$1</i>.',
	'invitations-feature-numleft'           => 'Die stounde noch <b>$1</b> fon mädnunner $2 Ienleedengen tou Ferföigenge.',
	'invitations-feature-noneleft'          => 'Du hääst aal die touwiesde Ienleedengen foar disse Softwarefunktion ferbruukt.',
	'invitations-feature-noneyet'           => 'Die wuuden noch neen Ienleedengen foar disse Softwarefunktion touwiesd.',
	'invitations-feature-notallowed'        => 'Du hääst neen Begjuchtigenge, uum <i>$1</i> tou bruuken.',
	'invitations-inviteform-title'          => 'Leede n Benutser tou ju Funktion $1 ien',
	'invitations-inviteform-username'       => 'Ientouleedenden Benutser',
	'invitations-inviteform-submit'         => 'Ienleede',
	'invitations-error-baduser'             => 'Dät lät, as wan die anroate Benutser nit bestoant.',
	'invitations-error-alreadyinvited'      => 'Die anroate Benutser häd al Tougoang tou disse Softwarefunktion!',
	'invitations-invite-success'            => 'Du hääst mäd Ärfoulch $1 tou disse Softwarefunktion ienleeden!',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'invite-logpage'                        => 'Invitationslogg',
	'invite-logpagetext'                    => 'Detta är en logg över vilka användare som har inviterat varandra till att använda diverse mjukvarefunktioner.',
	'invite-logentry'                       => 'inviterade $1 till att använda funktionen <i>$2</i>',
	'invitations'                           => 'Behandling av inbjudningar till programvarefunktioner',
	'invitations-desc'                      => 'Gör det möjligt att [[Special:Invitations|kontrollera nya funktioner]] genom att begränsa dem med ett inbjudningsbaserat system',
	'invitations-invitedlist-description'   => 'Du har tillgång till följande funktioner som kräver en inbjudan. Klicka på funktionens namn för att behandla inbjudningar för dom enkla funktionerna.',
	'invitations-invitedlist-none'          => 'Du har inte blivit inbjuden att använda några funktioner som kräver inbjudan.',
	'invitations-invitedlist-item-count'    => '({{PLURAL:$1|En inbjudning är tillgänglig|$1 inbjudningar är tillgängliga}})',
	'invitations-pagetitle'                 => 'Funktioner som kräver inbjudning',
	'invitations-uninvitedlist-description' => 'Du har inte tillgång till dessa funktioner som kräver inbjudan.',
	'invitations-uninvitedlist-none'        => 'Inga programvarefunktioner kräver inbjudan.',
	'invitations-feature-pagetitle'         => 'Inbjudningsbehandling - $1',
	'invitations-feature-access'            => 'Du har tillgång att använda <i>$1</i>.',
	'invitations-feature-numleft'           => 'Du har fortfarande {{PLURAL:$2|en inbjudning kvar|<b>$1</b> av dina $2 inbjudningar kvar}}.',
	'invitations-feature-noneleft'          => 'Du har använt alla dina inbjudningar för den här funktionen',
	'invitations-feature-noneyet'           => 'Du har inte tilldelats din andel inbjudningar för den här funktionen.',
	'invitations-feature-notallowed'        => 'Du har inte tillgång att använda <i>$1</i>.',
	'invitations-inviteform-title'          => 'Bjuder in en användare att använda $1',
	'invitations-inviteform-username'       => 'Användare som ska bjudas in',
	'invitations-inviteform-submit'         => 'Bjud in',
	'invitations-error-baduser'             => 'Användaren du angav finns inte.',
	'invitations-error-alreadyinvited'      => 'Användare du angav har redan tillgång till den här funktionen!',
	'invitations-invite-success'            => 'Du har bjudit in $1 att använda den här funktionen!',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'invite-logpage'                     => 'ఆహ్వానాల దినచర్య',
	'invite-logentry'                    => '<i>$2</i> అనే విశేషాన్ని వాడడానికి $1ని ఆహ్వానించారు.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|ఒక ఆహ్వానం|$1 ఆహ్వానాలు}} ఉన్నాయి)',
	'invitations-feature-pagetitle'      => 'ఆహ్వాన నిర్వహణ - $1',
	'invitations-feature-access'         => '<i>$1</i>ని వాడడానికి ప్రస్తుతం మీకు అనుమతి ఉంది.',
	'invitations-feature-numleft'        => 'మీ $2 ఆహ్వనాలలో మీ దగ్గర ఇంకా <b>$1</b> మిగిలివున్నాయి.',
	'invitations-inviteform-title'       => '$1ని వాడడానికి ఓ వాడుకరిని ఆహ్వానించండి',
	'invitations-inviteform-username'    => 'ఆహ్వానించాల్సిన వాడుకరి',
	'invitations-inviteform-submit'      => 'ఆహ్వానించు',
	'invitations-error-baduser'          => 'మీరు చెప్పిన ఆ వాడుకరి లేనేలేరు.',
	'invitations-error-alreadyinvited'   => 'మీరు చెప్పిన ఆ వాడుకరికి ఈ విశేషాన్ని వాడుకునే అనుమతి ఈపాటికే ఉంది!',
	'invitations-invite-success'         => 'ఈ విశేషాన్ని వాడుకోమని $1ని మీరు విజయవంతంగా ఆహ్వానించారు!',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'invitations-inviteform-username'  => 'Корбар барои таклиф',
	'invitations-inviteform-submit'    => 'Таклиф',
	'invitations-error-baduser'        => 'Корбари шумо мушаххас карда ба назар мерасад, ки вуҷуд надорад',
	'invitations-error-alreadyinvited' => 'Корбари шумо мушаххас карда аллакай ба ин хусусият дастрасӣ дорад!',
	'invitations-invite-success'       => 'Барои истифодаи ин хусусия шумо $1-ро бо муваффақият таклиф кардед',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'invite-logpage'                        => 'Nhật trình thư mời',
	'invite-logpagetext'                    => 'Đây là nhật trình ghi lại những lời mời từ người dùng này tới người dùng khác để sử dụng những tính năng phần mềm khác nhau.',
	'invite-logentry'                       => 'đã mời $1 dùng tính năng <i>$2</i>.',
	'invitations'                           => 'Quản lý thư mời đối với các tính năng phần mềm',
	'invitations-desc'                      => 'Cho phép [[Special:Invitations|quản lý các tính năng mới]] bằng cách hạn chế họ dựa vào hệ thống thư mời',
	'invitations-invitedlist-description'   => 'Bạn đã truy cập vào các tính năng phần mềm chỉ cho phép thư mời sau đây. Để quản lú các thư mời cho một tính năng riêng lẻ, hãy nhấn vào tên của nó.',
	'invitations-invitedlist-none'          => 'Bạn chưa được mời sử dụng tính năng phần mềm chỉ dành cho thư mời nào.',
	'invitations-pagetitle'                 => 'Các tính năng phần mềm chỉ cho phép thư mời',
	'invitations-uninvitedlist-description' => 'Bạn không có quyền truy cập vào những tính năng phần mềm chỉ cho phép thư mời sau.',
	'invitations-uninvitedlist-none'        => 'Vào lúc này, không có tính năng phần mềm nào khác được chỉ định chỉ cho phép thư mời.',
	'invitations-feature-pagetitle'         => 'Quản lý Thư mời - $1',
	'invitations-feature-access'            => 'Bạn hiện có quyền sử dụng <i>$1</i>.',
	'invitations-feature-numleft'           => 'Bạn vẫn còn lại <b>$1</b>{{PLURAL:$2|| trong tổng số $2}} lời mời.',
	'invitations-feature-noneleft'          => 'Bạn đã dùng tất cả các lời mời cho phép dành cho tính năng này',
	'invitations-feature-noneyet'           => 'Bạn chưa nhận được lượng thư mời cung cấp dành cho tính năng này.',
	'invitations-feature-notallowed'        => 'Bạn không có quyền sử dụng <i>$1</i>.',
	'invitations-inviteform-title'          => 'Mời một thành viên sử dụng $1',
	'invitations-inviteform-username'       => 'Thành viên được mời',
	'invitations-inviteform-submit'         => 'Mời',
	'invitations-error-baduser'             => 'Thành viên bạn chỉ định dường như không tồn tại.',
	'invitations-error-alreadyinvited'      => 'Thành viên bạn chỉ định đã có quyền sử dụng tính năng này rồi!',
	'invitations-invite-success'            => 'Bạn đã mời $1 sử dụng tính năng này!',
);

