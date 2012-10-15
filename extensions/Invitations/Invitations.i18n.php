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

/** Message documentation (Message documentation)
 * @author Purodha
 */
$messages['qqq'] = array(
	'invitations-desc' => 'Short description of this extension, shown on [[Special:Version]]. Do not translate or change links.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'invite-logentry' => 'het $1 uitgenodig om die funksie <i>$2</i> te gebruik.',
	'invitations-feature-notallowed' => 'U het nie toegang om <i>$1</i> te gebruik nie.',
	'invitations-inviteform-title' => "Nooi 'n gebruiker om $1 te gebruik",
	'invitations-inviteform-username' => 'Gebruiker om uit te nooi',
	'invitations-inviteform-submit' => 'Nooi uit',
	'invitations-error-baduser' => 'Dit lyk nie of die gebruiker wat u verskaf het bestaan nie.',
	'invitations-error-alreadyinvited' => 'Die gebruiker wat u verskaf het het reeds toegang tot hierdie funksie!',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 */
$messages['ar'] = array(
	'invite-logpage' => 'سجل الدعوات',
	'invite-logpagetext' => 'هذا سجل بالمستخدمين الداعين بعضهم البعض لاستخدام مميزات البرنامج المختلفة.',
	'invite-logentry' => 'دعا $1 لاستخدام خاصية <i>$2</i>.',
	'invitations' => 'أدر الدعوات لميزات البرنامج',
	'invitations-desc' => 'يسصمح [[Special:Invitations|بالتحكم في المميزات الجديدة]] بواسطة تحديدهم لنظام معتمد على الدعوات',
	'invitations-invitedlist-description' => 'لديك سماح إلى مميزات الدعوة فقط للبرنامج التالية.
للتحكم بالدعوات لميزة مفردة، اضغط على اسمها.',
	'invitations-invitedlist-none' => 'لم تتم دعوتك لاستخدام أي ميزات بالدعوة-فقط.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|دعوة واحدة|$1 دعوة}} متوفرة)',
	'invitations-pagetitle' => 'ميزات بالدعوة-فقط',
	'invitations-uninvitedlist-description' => 'لا يوجد لديك وصول إلى ميزات البرنامج بالدعوة فقط الأخرى هذه.',
	'invitations-uninvitedlist-none' => 'في هذا الوقت، لا مميزات برنامج أخرى محددة بالدعوة فقط.',
	'invitations-feature-pagetitle' => 'إدارة الدعوات - $1',
	'invitations-feature-access' => 'لديك حاليا صلاحية استخدام <i>$1</i>.',
	'invitations-feature-numleft' => 'أنت مازال لديك {{PLURAL:$2|دعوة واحدة باقية|<b>$1</b> من دعواتك ال$2 باقية}}.',
	'invitations-feature-noneleft' => 'لقد استخدمت كل دعواتك المحصصة لهذه الميزة',
	'invitations-feature-noneyet' => 'أنت مازالت لم تتلق كمية دعواتك لهذه الميزة.',
	'invitations-feature-notallowed' => 'لا يوجد لديك صلاحية استخدام <i>$1</i>.',
	'invitations-inviteform-title' => 'ادع مستخدما ليستخدم $1',
	'invitations-inviteform-username' => 'المستخدم لتتم دعوته',
	'invitations-inviteform-submit' => 'دعوة',
	'invitations-error-baduser' => 'المستخدم الذي حددته لا يبدو أنه موجود.',
	'invitations-error-alreadyinvited' => 'المستخدم الذي حددته لديه وصول لهذه الميزة أصلا!',
	'invitations-invite-success' => 'لقد دعوت $1 ليستخدم هذه الميزة بنجاح!',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'invite-logpage' => 'سجل الدعوات',
	'invite-logpagetext' => 'هذا سجل بالمستخدمين الداعين بعضهم البعض لاستخدام مميزات البرنامج المختلفة.',
	'invite-logentry' => 'دعا $1 لاستخدام خاصية <i>$2</i>.',
	'invitations' => 'أدر الدعوات لميزات البرنامج',
	'invitations-desc' => 'يسصمح [[Special:Invitations|بالتحكم فى المميزات الجديدة]] بواسطة تحديدهم لنظام معتمد على الدعوات',
	'invitations-invitedlist-description' => 'لديك سماح إلى مميزات الدعوة فقط للبرنامج التالية.
للتحكم بالدعوات لميزة مفردة، اضغط على اسمها.',
	'invitations-invitedlist-none' => 'لم تتم دعوتك لاستخدام أى ميزات بالدعوة-فقط.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|دعوة واحدة|$1 دعوة}} متوفرة)',
	'invitations-pagetitle' => 'ميزات بالدعوة-فقط',
	'invitations-uninvitedlist-description' => 'لا يوجد لديك وصول إلى ميزات البرنامج بالدعوة فقط الأخرى هذه.',
	'invitations-uninvitedlist-none' => 'فى هذا الوقت، لا مميزات برنامج أخرى محددة بالدعوة فقط.',
	'invitations-feature-pagetitle' => 'إدارة الدعوات - $1',
	'invitations-feature-access' => 'لديك حاليا صلاحية استخدام <i>$1</i>.',
	'invitations-feature-numleft' => 'أنت مازال لديك {{PLURAL:$2|دعوة واحدة باقية|<b>$1</b> من دعواتك ال$2 باقية}}.',
	'invitations-feature-noneleft' => 'لقد استخدمت كل دعواتك المحصصة لهذه الميزة',
	'invitations-feature-noneyet' => 'أنت مازالت لم تتلق كمية دعواتك لهذه الميزة.',
	'invitations-feature-notallowed' => 'لا يوجد لديك صلاحية استخدام <i>$1</i>.',
	'invitations-inviteform-title' => 'ادع مستخدما ليستخدم $1',
	'invitations-inviteform-username' => 'المستخدم لتتم دعوته',
	'invitations-inviteform-submit' => 'دعوة',
	'invitations-error-baduser' => 'المستخدم الذى حددته لا يبدو أنه موجود.',
	'invitations-error-alreadyinvited' => 'المستخدم الذى حددته لديه وصول لهذه الميزة أصلا!',
	'invitations-invite-success' => 'لقد دعوت $1 ليستخدم هذه الميزة بنجاح!',
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'invitations-inviteform-submit' => 'eilådn',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'invite-logpage' => 'Журнал запрашэньняў',
	'invite-logpagetext' => 'Гэта журнал запрашэньняў выкарыстоўваць магчымасьці праграмнага забесьпячэньня.',
	'invite-logentry' => 'запрасіў $1 выкарыстоўваць магчымасьць <i>$2</i>.',
	'invitations' => 'Кіраваньне запрашэньнямі выкарыстоўваць магчымасьці праграмнага забесьпячэньня',
	'invitations-desc' => 'Дазваляе [[Special:Invitations|кіраваць новымі магчымасьцямі]] з абмежаваньнем доступу з дапамогай сыстэмы запрашэньняў',
	'invitations-invitedlist-description' => 'Вы маеце доступ да наступных магчымасьцяў, якія даступныя толькі па запрашэньням.
Каб кіраваць запрашэньнямі да кожнай магчымасьці, націсьніце на яе назву.',
	'invitations-invitedlist-none' => 'Вы не былі запрошаны выкарыстоўваць якой-небудзь з магчымасьцяў, якія даступныя толькі па запрашэньнях.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Даступнае $1 запрашэньне|Даступныя $1 запрашэньні|Даступныя $1 запрашэньняў}})',
	'invitations-pagetitle' => 'Магчымасьці праграмнага забесьпячэньня, якія даступныя толькі па запрашэньнях',
	'invitations-uninvitedlist-description' => 'Вы ня маеце доступу да іншых магчымасьцяў праграмнага забесьпячэньня, якія даступныя толькі па запрашэньнях.',
	'invitations-uninvitedlist-none' => 'Зараз няма іншых магчымасьцяў праграмнага забесьпячэньня, якія даступныя толькі па запрашэньнях.',
	'invitations-feature-pagetitle' => 'Кіраваньне запрашэньнямі — $1',
	'invitations-feature-access' => 'Зараз Вы маеце доступ да выкарыстаньня <i>$1</i>.',
	'invitations-feature-numleft' => 'Вы ўсё яшчэ маеце {{PLURAL:$2|адно запрашэньне|<b>$1</b> з $2 {{PLURAL:$2|запрашэньня|запрашэньняў|запрашэньняў}}}}.',
	'invitations-feature-noneleft' => 'Вы выкарысталі ўсе Вашыя запрашэньні на гэтую магчымасьць',
	'invitations-feature-noneyet' => 'Вы яшчэ не атрымалі запрашэньняў для гэтай магчымасьці.',
	'invitations-feature-notallowed' => 'Вы ня маеце доступу для выкарыстаньня <i>$1</i>.',
	'invitations-inviteform-title' => 'Запрасіць удзельніка выкарыстоўваць $1',
	'invitations-inviteform-username' => 'Запрасіць удзельніка',
	'invitations-inviteform-submit' => 'Запрасіць',
	'invitations-error-baduser' => 'Удзельнік, якога Вы пазначылі, не існуе.',
	'invitations-error-alreadyinvited' => 'Удзельнік, якога Вы пазначылі, ужо мае доступ да гэтай магчымасьці!',
	'invitations-invite-success' => 'Вы пасьпяхова запрасілі $1 выкарыстоўваць гэтую магчымасьць!',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'invite-logpage' => 'Дневник на поканите',
	'invite-logpagetext' => 'Тази страница съдържа дневник на поканите между потребителите за достъп до различни услуги.',
	'invite-logentry' => 'покани $1 да използва <i>$2</i>.',
	'invitations' => 'Управление на поканите за различните услуги',
	'invitations-desc' => 'Позволява [[Special:Invitations|управление на новите възможности на софтуера]] като ги ограничава за използване чрез система с покани',
	'invitations-invitedlist-description' => 'Имате достъп до следните софтуерни възможности, достъпни с покана.
За управление на поканите за отделна възможности, щракнете върху името й.',
	'invitations-invitedlist-none' => 'Нямате покана да използвате нито една от софтуерните възможности, достъпни с покана.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Налична е една покана|Налични са $1 покани}})',
	'invitations-pagetitle' => 'Възможности на софтуера, достъпни с покана',
	'invitations-uninvitedlist-description' => 'Можете да получите достъп до тези софтуерни възможности само след покана.',
	'invitations-uninvitedlist-none' => 'На този етап няма други софтуерни възможности, които да са отбелязани, че са достъпни с покана.',
	'invitations-feature-pagetitle' => 'Управление на поканите - $1',
	'invitations-feature-access' => 'В момента имате достъп да използвате <i>$1</i>.',
	'invitations-feature-numleft' => 'Имате {{PLURAL:$2|една оставаща покана|оставащи <b>$1</b> от $2 покани}}.',
	'invitations-feature-noneleft' => 'Вече сте използвали всички отпуснати покани за тази услуга',
	'invitations-feature-noneyet' => 'Все още не сте получили своя дял от покани за тази софтуерна възможност.',
	'invitations-feature-notallowed' => 'Нямате достъп да използвате <i>$1</i>.',
	'invitations-inviteform-title' => 'Изпращане на покана на потребител да използва $1',
	'invitations-inviteform-username' => 'Потребител',
	'invitations-inviteform-submit' => 'Изпращане на покана',
	'invitations-error-baduser' => 'Посоченият потребител не съществува.',
	'invitations-error-alreadyinvited' => 'Посоченият потребител вече има достъп до тази услуга!',
	'invitations-invite-success' => 'Поканата на $1 за достъп до услугата беше изпратена успешно!',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'invite-logpage' => 'Marilh ar pedadennoù',
	'invite-logpagetext' => "Setu ur marilh eus an implijerien o pediñ implijerien all evit implijout an arc'hweladur eus meziantoù disheñvel",
	'invite-logentry' => "pedet en deus $1 da implijout arc'hweladur <i>$2</i>.",
	'invitations' => "Merañ pedadennoù an arc'hweladurioù meziant",
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Ur bedadenn|$1 pedadenn}} posupl a zo)',
	'invitations-feature-pagetitle' => 'Merañ ar bedadenn - $1',
	'invitations-feature-access' => 'Er mare-mañ ho peus ar moned evit implijout <i>$1</i>.',
	'invitations-feature-numleft' => "{{PLURAL:$2|Ur bedadenn|<b>$1</b> pedadenn diwar $2 pedadenn}} ho peus c'hoazh.",
	'invitations-feature-noneleft' => "Implijet ho peus o holl pedadennoù aotreet evit an arc'hweladur-mañ",
	'invitations-feature-noneyet' => "N'ho peus ket resevet ho pedadennoù evit an arc'hweladur-mañ.",
	'invitations-feature-notallowed' => "Ne c'helloc'h ket dont tre evit implijout <i>$1</i>.",
	'invitations-inviteform-title' => 'Pediñ un implijer da implijout $1',
	'invitations-inviteform-username' => 'Implijer da bediñ',
	'invitations-inviteform-submit' => 'Pediñ',
	'invitations-error-baduser' => "War a seblant n'ez eus ket eus an implijer ho peus meneget.",
	'invitations-error-alreadyinvited' => "An implijer ho peus meneget en deus dija ar moned d'an arc'hweladur-mañ !",
	'invitations-invite-success' => "Pedet ho peus $1 evit implijout an arc'hweladur-mañ !",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'invite-logpage' => 'Zapisnik pozivnica',
	'invite-logentry' => 'pozovi $1 da koristi mogućnost <i>$2</i>.',
	'invitations-desc' => 'Omogućava [[Special:Invitations|upravljanje novim mogućnostima]] putem pozivanja',
	'invitations-invitedlist-none' => 'Niste pozvani da koristite neku od mogućnosti softvera za pozivanje.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Jedan poziv|$1 poziva}} dostupno)',
	'invitations-uninvitedlist-description' => 'Nemate pristup do ovih drugih osobina softvera samo za pozivanje.',
	'invitations-feature-pagetitle' => 'Upravljanje pozivima - $1',
	'invitations-feature-access' => 'Trenutno imate pristup za upotrebu <i>$1</i>.',
	'invitations-feature-notallowed' => 'Nemate pristup za upotrebu <i>$1</i>.',
	'invitations-inviteform-title' => 'Pozovi korisnika da koristi $1',
	'invitations-inviteform-username' => 'Korisnik koji se poziva',
	'invitations-inviteform-submit' => 'Pozovi',
	'invitations-error-baduser' => 'Korisnik kojeg ste naveli ne postoji.',
	'invitations-error-alreadyinvited' => 'Korisnik kojeg ste naveli već ima pristup ovoj mogućnosti!',
	'invitations-invite-success' => 'Uspješno se pozvali $1 da koristi ovu mogućnost!',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'invitations-inviteform-submit' => 'Convida',
	'invitations-error-baduser' => "L'usuari especificat no sembla existir.",
	'invitations-error-alreadyinvited' => "L'usuari especificat ja té accés a aquesta funciónalitat!",
	'invitations-invite-success' => 'Heu convidat $1 a usar aquesta funcionalitat amb èxit!',
);

/** German (Deutsch)
 * @author Jens Liebenau
 * @author Melancholie
 * @author Pill
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'invite-logpage' => 'Einladungs-Logbuch',
	'invite-logpagetext' => 'Dies ist das Logbuch der einladungsbasierten Softwarefunktionen.',
	'invite-logentry' => 'hat $1 eingeladen, um die Softwarefunktionen <i>$2</i> zu nutzen.',
	'invitations' => 'Verwalte Einladungen/Aufforderungen für Software-Fähigkeiten (features)',
	'invitations-desc' => 'Ermöglicht die [[Special:Invitations|Verwaltung von Softwarefunktionen]] auf Basis von Einladungen',
	'invitations-invitedlist-description' => 'Du hast Zugang zu den folgenden einladungsbasierten Softwarefunktionen. Um Einladungen für eine bestimmte Softwarefunktion zu verwalten, klicke auf ihren Namen.',
	'invitations-invitedlist-none' => 'Du hast bisher keine Einladung zur Nutzung von einladungsbasierten Softwarefunktionen erhalten.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Eine Einladung/Aufforderung|$1 Einladungen/Aufforderungen}} verfügbar)',
	'invitations-pagetitle' => 'Softwarefunktionen auf Einladungs-Basis',
	'invitations-uninvitedlist-description' => 'Du hast keinen Zugang zu anderen einladungsbasierten Softwarefunktionen.',
	'invitations-uninvitedlist-none' => 'Zurzeit sind keine weiteren Softwarefunktionen einladungsbasiert.',
	'invitations-feature-pagetitle' => 'Einladungs-Verwaltung - $1',
	'invitations-feature-access' => 'Du hast Zugang zur Nutzung von <i>$1</i>.',
	'invitations-feature-numleft' => '{{PLURAL:$2|Dir steht noch eine Einladung|Dir stehen noch <b>$1</b> von insgesamt $2 Einladungen}} zur Verfügung.',
	'invitations-feature-noneleft' => 'Du hast alle dir zugewiesenen Einladungen für diese Softwarefunktion verbraucht.',
	'invitations-feature-noneyet' => 'Dir wurden noch keine Einladungen für diese Softwarefunktion zugewiesen.',
	'invitations-feature-notallowed' => 'Du hast keine Berechtigung, um <i>$1</i> zu nutzen.',
	'invitations-inviteform-title' => 'Lade einen Benutzer zu der Funktion $1 ein',
	'invitations-inviteform-username' => 'Einzuladender Benutzer',
	'invitations-inviteform-submit' => 'Einladen',
	'invitations-error-baduser' => 'Der angegebene Benutzer ist nicht vorhanden.',
	'invitations-error-alreadyinvited' => 'Der angegebene Benutzer hat bereits Zugang zu dieser Softwarefunktion!',
	'invitations-invite-success' => 'Du hast erfolgreich $1 zu dieser Softwarefunktion eingeladen!',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 */
$messages['de-formal'] = array(
	'invitations-invitedlist-description' => 'Sie haben Zugang zu den folgenden einladungsbasierten Softwarefunktionen. Um Einladungen für eine bestimmte Softwarefunktion zu verwalten, klicken Sie auf ihren Namen.',
	'invitations-invitedlist-none' => 'Sie haben bisher keine Einladung zur Nutzung von einladungsbasierten Softwarefunktionen erhalten.',
	'invitations-uninvitedlist-description' => 'Sie haben keinen Zugang zu anderen einladungsbasierten Softwarefunktionen.',
	'invitations-feature-access' => 'Sie haben Zugang zur Nutzung von <i>$1</i>.',
	'invitations-feature-numleft' => '{{PLURAL:$2|Ihnen steht noch eine Einladung|Ihnen stehen noch <b>$1</b> von insgesamt $2 Einladungen}} zur Verfügung.',
	'invitations-feature-noneleft' => 'Sie haben alle Ihnen zugewiesenen Einladungen für diese Softwarefunktion verbraucht.',
	'invitations-feature-noneyet' => 'Ihnen wurden noch keine Einladungen für diese Softwarefunktion zugewiesen.',
	'invitations-feature-notallowed' => 'Sie haben keine Berechtigung, um <i>$1</i> zu nutzen.',
	'invitations-invite-success' => 'Sie haben erfolgreich $1 zu dieser Softwarefunktion eingeladen!',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'invite-logpage' => 'Protokol pśepšosenja',
	'invite-logpagetext' => 'To jo protokol wužywarjow, kótarež jaden drugego pśepšosuju, aby wužywali wšake softwarowe funkcije  .',
	'invite-logentry' => 'jo pśepšosył $1, aby wón wužywał funkciju <i>$2</i>.',
	'invitations' => 'Pśepšosenja na softwarowe funkcije zastojaś',
	'invitations-desc' => 'Zmóžnja [[Special:Invitations|zastojanje nowych funkcijow]] pśez jich wobgranicowanje na system, kótaryž pomina se pśepšosenje',
	'invitations-invitedlist-description' => 'Maš pśistup na slědujuce softwarowe funkcije, kótarež pominaju se pśepšosenje. Aby zastojał pśepšosenja za jadnotliwu funkciju, klikni na jeje mě.',
	'invitations-invitedlist-none' => 'Njamaš pśepšosenje za wužywanje softwarowych funkcijow, kótarež pominaju se pśepšosenje.',
	'invitations-invitedlist-item-count' => '{{PLURAL:$1|Jadno pśepšosenje|$1 pśepšoseni|$1 pśepšosenja|$1 pśepšosenjow}} k dispoziciji',
	'invitations-pagetitle' => 'Softwarowe funkcije na zakłaźe pśepšosenja',
	'invitations-uninvitedlist-description' => 'Njamaš pśistup na toś te softwarowe funkcije, kótarež pominaju se na pśepšosenje.',
	'invitations-uninvitedlist-none' => 'Tuchylu njejsu dalšne softwarowe funkcije, kótarež pominaju se pśepšosenje.',
	'invitations-feature-pagetitle' => 'Zastojanje pśepšosenjow - $1',
	'invitations-feature-access' => 'Maš tuchylu pśistup, aby wužywał <i>$1</i>.',
	'invitations-feature-numleft' => 'Tebje {{PLURAL:$2|stoj hyšći jadne pśepšosenje|stojtej hyšći <b>$1</b> z $2 {{PLURAL:$2|pśepšosenja|pśepšosenjowu|pśepšosenjow|pśepšosenjow|stoje hyšći <b>$1</b> z $2 {{PLURAL:$2|pśepšosenja|pśepšosenjowu|pśepšosenjow|pśepšosenjow}}|stoj hyšći <b>$1</b> z $2 {{PLURAL:$2|pśepšosenja|pśepšosenjowu|pśepšosenjow|pśepšosenjow}}}}}} k dispoziciji.',
	'invitations-feature-noneleft' => 'Sy pśetrjebał wše tebje pśiźělone pśepšosenja za toś tu funkciju.',
	'invitations-feature-noneyet' => 'Dotychměst njejsy dostał swójo pśiźělenje pśepšosenjow za toś tu funkciju.',
	'invitations-feature-notallowed' => 'Njamaš pśistup, aby wužywał <i>$1</i>.',
	'invitations-inviteform-title' => 'Wužywarja pśepšosyś, aby wón wužywał $1',
	'invitations-inviteform-username' => 'Wužywaŕ, kótaryž ma se pśepšosyś',
	'invitations-inviteform-submit' => 'Pśepšosyś',
	'invitations-error-baduser' => 'Zda se, až wužywaŕ, kótaregož sy pódał, njeeksistěrujo.',
	'invitations-error-alreadyinvited' => 'Wužywaŕ, kótaregož sy pódał, ma južo pśistup k toś tej funkciji!',
	'invitations-invite-success' => 'Sy wuspěšnje pśepšosył $1, aby wón wužywał toś tu funkciju!',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Απεργός
 */
$messages['el'] = array(
	'invite-logpage' => 'Αρχείο καταγραφών προσκλήσεων',
	'invite-logpagetext' => 'Καταγραφές των προσκλήσεων σε χρήστες να χρησιμοποιήσουν διάφορες λειτουργίες λογισμικού.',
	'invite-logentry' => 'προσκάλεσε τον/την $1 να χρησιμοποιήσει τη λειτουργία <i>$2</i>.',
	'invitations' => 'Διαχείριση προσκλήσεων σε λειτουργίες λογισμικού',
	'invitations-desc' => 'Επιτρέπει τη [[Special:Invitations|διαχείριση καινούργιων λειτουργιών]] μέσω του περιορισμού τους σε ένα σύστημα βασισμένο σε προσκλήσεις',
	'invitations-invitedlist-description' => 'Έχετε πρόσβαση στις ακόλουθες λειτουργίες λογισμικού που χρειάζονται πρόσκληση. Για να διαχειριστείτε προσκλήσεις για μια μεμονωμένη λειτουργία, κάντε κλικ στο όνομά της.',
	'invitations-invitedlist-none' => 'Δεν προσκληθήκατε να χρησιμοποιήσετε καμία λειτουργία λογισμικού που χρειάζεται πρόσκληση.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Μια πρόσκληση διαθέσιμη|$1 προσκλήσεις διαθέσιμες}})',
	'invitations-pagetitle' => 'Λειτουργίες λογισμικού που χρειάζονται πρόσκληση',
	'invitations-uninvitedlist-description' => 'Δεν έχετε πρόσβαση σε αυτές τις άλλες λειτουργίες λογισμικού που χρειάζονται πρόσκληση.',
	'invitations-uninvitedlist-none' => 'Αυτή τη στιγμή, καμία άλλη λειτουργία λογισμικού δεν ορίζεται ως λειτουργία που χρειάζεται πρόσκληση.',
	'invitations-feature-pagetitle' => 'Διαχείριση Προσκλήσεων - $1',
	'invitations-feature-access' => 'Έχετε τώρα πρόσβαση να χρησιμοποιήσετε <i>$1</i>.',
	'invitations-feature-numleft' => 'Σας {{PLURAL:$2|απομένει ακόμα μια πρόσκληση|απομένουν ακόμα <b>$1</b> από τις $2 προσκλήσεις σας}}.',
	'invitations-feature-noneleft' => 'Έχετε χρησιμοποιήσει όλες τις κατανεμημένες προσκλήσεις σας για αυτή τη λειτουργία.',
	'invitations-feature-noneyet' => 'Δεν έχετε πάρει τη δική σας κατανομή των προσκλήσεων για αυτή τη λειτουργία.',
	'invitations-feature-notallowed' => 'Δεν έχετε πρόσβαση να χρησιμοποιήσετε <i>$1</i>.',
	'invitations-inviteform-title' => 'Πρόσκληση σε ένα χρήστη να χρησιμοποιήσει $1',
	'invitations-inviteform-username' => 'Χρήστης προς πρόσκληση',
	'invitations-inviteform-submit' => 'Πρόσκληση',
	'invitations-error-baduser' => 'Ο χρήστης που καθορίσατε δεν φαίνεται να υπάρχει.',
	'invitations-error-alreadyinvited' => 'Ο χρήστης που καθορίσατε έχει πρόσβαση ήδη σε αυτή τη λειτουργία!',
	'invitations-invite-success' => 'Έχετε προκαλέσει επιτυχώς τον/την $1 να χρησιμοποιήσει αυτή τη λειτουργία!',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'invite-logpage' => 'Protokolo de invitado',
	'invite-logpagetext' => 'Ĉi tiu protokolo de uzantoj invitantaj inter ili mem por uzi variajn programerojn.',
	'invite-logentry' => 'Vi invitis $1 por uzi la <i>$2</i> programeron.',
	'invitations' => 'Administru invitojn por programeroj',
	'invitations-desc' => 'Permesas [[Special:Invitations|administradon de novaj programeroj]] tiel limigante atingon al ili per invito-sistemo',
	'invitations-invitedlist-description' => 'Vi povas atingi la jenajn programerojn nur atingeblaj per invito. Administri invitojn por unuopa programero, klaku ties nomon.',
	'invitations-invitedlist-none' => 'Vi ne estis invitita por uzi programerojn atingeblajn nur per invito.',
	'invitations-invitedlist-item-count' => 'Havas vi {{PLURAL:$1|unu inviton|$1 invitojn}}.',
	'invitations-pagetitle' => 'Programeroj atingeblaj nur per invito',
	'invitations-uninvitedlist-description' => 'Vi ne eblas atingi aliajn programerojn haveblajn nur per invito.',
	'invitations-uninvitedlist-none' => 'Ĉi tiame, neniuj ajn programeroj estas atingeblaj nur per invito.',
	'invitations-feature-pagetitle' => 'Administrado de invitoj - $1',
	'invitations-feature-access' => 'Vi nune estas permesita uzi programeron <i>$1</i>.',
	'invitations-feature-numleft' => 'Vi ankoraŭ havas {{PLURAL:$2|unu ceteran inviton|<b>$1</b> el via $2 ceterajn invitojn}}.',
	'invitations-feature-noneleft' => 'Vi jam uzis ĉiujn de viaj disdonitaj invitoj por ĉi tiu programero',
	'invitations-feature-noneyet' => 'Vi ne jam ricevis vian disdonon de invitoj por ĉi tiu programero.',
	'invitations-feature-notallowed' => 'Vi ne havas atingon por uzi <i>$1</i>.',
	'invitations-inviteform-title' => 'Invitu uzanton por uzi programeron $1',
	'invitations-inviteform-username' => 'Uzanto por inviti',
	'invitations-inviteform-submit' => 'Inviti',
	'invitations-error-baduser' => 'La uzanto kiun vi enigis verŝajne ne ekzistas.',
	'invitations-error-alreadyinvited' => 'La uzanto kiun vi enigis jam povas atingi ĉi tiun programeron!',
	'invitations-invite-success' => 'Vi sukcesis inviti $1 por uzi ĉi tiun programeron!',
);

/** Spanish (Español)
 * @author Dmcdevit
 * @author Jatrobat
 * @author Sanbec
 */
$messages['es'] = array(
	'invite-logpage' => 'Registro de invitaciones',
	'invite-logpagetext' => 'Este es un registro de usuarios que invitan a otros a usar diversas funciones del software.',
	'invite-logentry' => '$1 ha sido invitado para usar la función <i>$2</i>.',
	'invitations' => 'Gestiona invitaciones para funciones del software',
	'invitations-desc' => 'Permite el [[Special:Invitations|control de nuevas funciones]] restringiéndolas mediante un sistema basado en invitaciones.',
	'invitations-invitedlist-description' => 'Tiene acceso a los siguientes funciones sólo por invitación. Para manejar invitaciones a una función específica, haga clic en su nombre.',
	'invitations-invitedlist-none' => 'No ha sido invitado usar ninguna función sólo por invitación.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Una invitación disponible|$1 invitaciones disponibles}})',
	'invitations-pagetitle' => 'Funciones sólo por invitación',
	'invitations-uninvitedlist-description' => 'No tiene acceso a estas otras funciones sólo por invitación.',
	'invitations-uninvitedlist-none' => 'Ahora mismo, ninguna otra función está designado sólo por invitación.',
	'invitations-feature-pagetitle' => 'Gestión de invitaciones - $1',
	'invitations-feature-access' => 'Tiene permiso para usar <i>$1</i>.',
	'invitations-feature-numleft' => 'Todavía te queda{{PLURAL:$2| una invitación|n <b>$1</b> invitaciones de las $2 que tenías}}.',
	'invitations-feature-noneleft' => 'Ha usado todo de sus invitaciones destinado a esta función.',
	'invitations-feature-noneyet' => 'No ha recibido su cuota de invitaciones para esta función.',
	'invitations-feature-notallowed' => 'No tiene permiso para usar <i>$1</i>.',
	'invitations-inviteform-title' => 'Invitar a un usuario a usar $1',
	'invitations-inviteform-username' => 'Usuario para invitar',
	'invitations-inviteform-submit' => 'Invitar',
	'invitations-error-baduser' => 'El usuario que usted eligió no existe.',
	'invitations-error-alreadyinvited' => 'El usuario que usted eligío ya tiene acceso a esta función!',
	'invitations-invite-success' => 'Ha invitado con éxito a $1 usar esta función.',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'invitations-inviteform-title' => 'Kutsu kasutaja $1 kasutama',
	'invitations-inviteform-username' => 'Kutsutav kasutaja',
	'invitations-inviteform-submit' => 'Kutsu',
	'invitations-error-baduser' => 'Märgitud kasutajanimi puudub.',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'invitations-inviteform-title' => 'Lankide bat $1 erabiltzeko gonbidatu',
	'invitations-inviteform-username' => 'Gonbidatu beharreko erabiltzailea',
	'invitations-inviteform-submit' => 'Gonbidatu',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Silvonen
 * @author Vililikku
 */
$messages['fi'] = array(
	'invite-logpage' => 'Kutsuloki',
	'invite-logpagetext' => 'Tämä on loki käyttäjien kutsuista muita käyttäjiä käyttämään ohjelmiston eri ominaisuuksia.',
	'invite-logentry' => 'kutsui käyttäjän $1 käyttämään ominaisuutta <i>$2</i>.',
	'invitations' => 'Hallitse kutsuja ohjelmien ominaisuuksiin',
	'invitations-desc' => 'Mahdollistaa [[Special:Invitations|uusien ominaisuuksien hallinnan]] rajoittamalla niiden käyttöoikeutta kutsupohjaisella järjestelmällä.',
	'invitations-invitedlist-description' => 'Sinulla on pääsy seuraaviin vain kutsutuille tarjolla oleviin ominaisuuksiin.
Yksittäisen ominaisuuden kutsuja voi hallita napsauttamalla sen nimestä.',
	'invitations-invitedlist-none' => 'Sinua ei ole kutsuttu käyttämään mitään vain kutsutuille tarjolla olevia ominaisuuksia.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Yksi kutsu|$1 kutsua}} jäljellä)',
	'invitations-pagetitle' => 'Vain kutsuille tarjolla olevat ohjelmien ominaisuudet',
	'invitations-uninvitedlist-description' => 'Sinulla ei ole pääsyä muihin vain kutsutuille tarjolla oleviin ominaisuuksiin.',
	'invitations-uninvitedlist-none' => 'Tällä hetkellä muita ominaisuuksia ei ole osoitettu vain kutsutuille tarjolla oleviksi.',
	'invitations-feature-pagetitle' => 'Kutsujen hallinta – $1',
	'invitations-feature-access' => 'Sinulla on oikeudet käyttää ominaisuutta <i>$1</i>.',
	'invitations-feature-numleft' => 'Sinulla on vielä {{PLURAL:$2|yksi kutsu jäljellä|<b>$1</b> kaikkiaan $2 kutsusta jäljellä}}.',
	'invitations-feature-noneleft' => 'Olet käyttänyt kaikki tälle ominaisuudelle myönnetyt kutsusi.',
	'invitations-feature-noneyet' => 'Et ole vielä saanut tälle ominaisuudelle myönnettyjä kutsujasi.',
	'invitations-feature-notallowed' => 'Sinulla ei ole oikeuksia käyttää ominaisuutta <i>$1</i>.',
	'invitations-inviteform-title' => 'Kutsu käyttäjä käyttämään ominaisuutta $1',
	'invitations-inviteform-username' => 'Kutsuttava käyttäjä',
	'invitations-inviteform-submit' => 'Kutsu',
	'invitations-error-baduser' => 'Annettua käyttäjätunnusta ei ole olemassa.',
	'invitations-error-alreadyinvited' => 'Annetulla käyttäjällä on jo oikeudet käyttää tätä ominaisuutta.',
	'invitations-invite-success' => 'Olet kutsunut käyttäjän $1 käyttämään tätä ominaisuutta.',
);

/** French (Français)
 * @author Grondin
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'invite-logpage' => 'Journal des invitations',
	'invite-logpagetext' => 'Voici un journal des utilisateurs en invitant d’autres pour utiliser les fonctionnalités de divers programmes',
	'invite-logentry' => 'a invité $1 à utiliser la fonctionnalité de <i>$2</i>.',
	'invitations' => 'Gère les invitations des fonctionnalités logicielles',
	'invitations-desc' => 'Permet [[Special:Invitations|la gestion des nouvelles fonctionnalités]] en les restreignant par une système basé sur l’invitation.',
	'invitations-invitedlist-description' => "Vous avez l'accès aux caractéristiques suivantes du logiciel d’invite seule. Pour gérer les invitations pour une caractéristique individuelle, cliquez sur son nom.",
	'invitations-invitedlist-none' => 'Vous n’avez pas été invité pour utiliser les fonctionnalités du logiciel d’invite seule.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Une invitation disponible|$1 invitations disponibles}})',
	'invitations-pagetitle' => 'Fonctionnalités du logiciel d’invite seule',
	'invitations-uninvitedlist-description' => 'Vous n’avez pas l’accès à ces autres caractéristiques du programme d’invite seule.',
	'invitations-uninvitedlist-none' => 'À cet instant, aucune fonctionnalité logicielle n’a été désignée par l’invite seule.',
	'invitations-feature-pagetitle' => 'Gestion de l’invitation - $1',
	'invitations-feature-access' => 'Vous avez actuellement l’accès pour utiliser <i>$1</i>.',
	'invitations-feature-numleft' => 'Il vous reste encore {{PLURAL:$2|une invitation|<b>$1</b> de vos $2 invitations}}.',
	'invitations-feature-noneleft' => "Vous avez utilisé l'ensemble de vos invitations permises pour cette fonctionnalité",
	'invitations-feature-noneyet' => 'Vous n’avez pas cependant reçu votre assignation des invitations pour cette fonctionnalité.',
	'invitations-feature-notallowed' => 'Vous n’avez pas l’accès pour utiliser <i>$1</i>.',
	'invitations-inviteform-title' => 'Inviter un utilisateur pour utiliser $1',
	'invitations-inviteform-username' => 'Utilisateur à inviter',
	'invitations-inviteform-submit' => 'Inviter',
	'invitations-error-baduser' => 'L’utilisateur que vous avez indiqué ne semble pas exister.',
	'invitations-error-alreadyinvited' => 'L’utilisateur que vous avez indiqué dispose déjà de l’accès à cette fonctionnalité !',
	'invitations-invite-success' => 'Vous avez invité $1 avec succès pour utiliser cette fonctionnalité !',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'invite-logpage' => 'Rexistro de invitacións',
	'invite-logpagetext' => 'Este é un rexistro dos usuarios que invitaron a outros a usar varias características do software.',
	'invite-logentry' => 'invitou a $1 a usar a característica <i>$2</i>.',
	'invitations' => 'Xestionar as caractarísticas do software das invitacións',
	'invitations-desc' => 'Permite [[Special:Invitations|a xestión de características novas]] a través da restrición nun sistema de invitación base',
	'invitations-invitedlist-description' => 'Ten acceso ás seguintes características do software só por invitación.
Para xestionar as invitacións para unha característica individual, faga clic no seu nome.',
	'invitations-invitedlist-none' => 'Non foi convidado a usar nunha das características do software só por invitación.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Unha invitación dispoñible|$1 invitacións dispoñibles}})',
	'invitations-pagetitle' => 'Características do software só por invitación',
	'invitations-uninvitedlist-description' => 'Non ten acceso a estoutras características do software só por invitación.',
	'invitations-uninvitedlist-none' => 'Arestora, ningunha outra característica do software é designada só por invitación.',
	'invitations-feature-pagetitle' => 'Xestión da invitación - $1',
	'invitations-feature-access' => 'Actualmente ten acceso para usar <i>$1</i>.',
	'invitations-feature-numleft' => 'Aínda ten {{PLURAL:$2|unha invitación restante|<b>$1</b>, dun total de $2 invitaciones restantes}}.',
	'invitations-feature-noneleft' => 'Usou todas as súas invitacións asignadas a esta característica',
	'invitations-feature-noneyet' => 'Aínda no recibiu a súa asignación de invitacións para esta característica.',
	'invitations-feature-notallowed' => 'Non ten acceso para usar <i>$1</i>.',
	'invitations-inviteform-title' => 'Invitar a un usuario a usar $1',
	'invitations-inviteform-username' => 'Usuario para invitar',
	'invitations-inviteform-submit' => 'Invitar',
	'invitations-error-baduser' => 'Parece que o usuario que especificou non existe.',
	'invitations-error-alreadyinvited' => 'O usuario que especificou xa ten acceso a esta característica!',
	'invitations-invite-success' => 'Invitou con éxito a $1 para usar esta característica!',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'invite-logpage' => 'Κατάλογος προσκλήσεων',
	'invitations-feature-pagetitle' => 'Διαχείρισις προσκλήσεως - $1',
	'invitations-inviteform-submit' => 'Προσκαλεῖν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'invite-logpage' => 'Yyladigs-Logbuech',
	'invite-logpagetext' => 'Des isch s Logbuch vu Benutzer, wu sich gegesytig dezue yylade verschideni Softwarefunktione z verwände.',
	'invite-logentry' => 'het $1 yyglade go d Softwarefunktione <i>$2</i> z nutze.',
	'invitations' => 'Yyladige/Ufforderige fir Software-Funktione verwalte',
	'invitations-desc' => 'Macht d [[Special:Invitations|Verwaltig vu Softwarefunktione]] megli uf dr Grundlag vun eme Yyladigs-Syschtem',
	'invitations-invitedlist-description' => 'Du hesch Zuegang zue däne yyladigsbasierte Softwarefunktione. Go Yyladige fir e bstimmti Softwarefunktion z verwalte, druck uf dr Name vun ere.',
	'invitations-invitedlist-none' => 'Du hesch no kei Yyladig kriegt yyladigsbasierti Softwarefunktione z nutze.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Ei Yyladig|$1 Yyladige}} verfiegbar)',
	'invitations-pagetitle' => 'Softwarefunktione uf dr Grundlag vu Yyladige',
	'invitations-uninvitedlist-description' => 'Du hesch kei Zuegang zue andere yyladigsbasierte Softwarefunktione.',
	'invitations-uninvitedlist-none' => 'Zur Zyt sin keini andere Softwarefunktione yyladigsbasiert.',
	'invitations-feature-pagetitle' => 'Yyladigs-Verwaltig - $1',
	'invitations-feature-access' => 'Du hesch Zuegang zue dr Nutzig vu <i>$1</i>.',
	'invitations-feature-numleft' => '{{PLURAL:$2|Dir stoht no ne Yyladig|Dir stehn no <b>$1</b> vú insgsamt $2 Yyladige}} z Verfiegig.',
	'invitations-feature-noneleft' => 'Du hesch alli Dir zuegwisene Yyladige fir die Softwarefunktion verbruucht',
	'invitations-feature-noneyet' => 'Dir sin no kei Yyladige fir die Softwarefunktion zuegwise wore.',
	'invitations-feature-notallowed' => 'Du hesch kei Berächtigung, <i>$1</i> z nutze.',
	'invitations-inviteform-title' => 'Lad e Benutzer zue dr Funktion $1 yy',
	'invitations-inviteform-username' => 'Benutzer, wu yyglade soll wäre',
	'invitations-inviteform-submit' => 'Yylade',
	'invitations-error-baduser' => 'Dr Benutzer, wu Du aagee hesch, git s schyns nit.',
	'invitations-error-alreadyinvited' => 'Dr Benutzer, wu du aagee hesch, het scho Zuegang zue däre Softwarefunktion!',
	'invitations-invite-success' => 'Du hesch $1 erfolgryych zue däre Softwarefunktion yyglade!',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'invite-logpage' => 'יומן ההזמנות',
	'invite-logpagetext' => 'זהו יומן ההזמנות שנשלחו בין המשתמשים לשימוש בתכונות תוכנה שונות.',
	'invite-logentry' => 'הזמין את $1 להשתמש בתכונה <i>$2</i>.',
	'invitations' => 'ניהול ההזמנות לתכונות תוכנה',
	'invitations-desc' => 'אפשרות ל[[Special:Invitations|ניהול תכונות חדשות]] באמצעות הגבלתם למערכת המבוססת על הזמנות בלבד',
	'invitations-invitedlist-description' => 'יש לכם גישה לתכונות התוכנה הבאות הדורשות הזמנה בלבד.
על מנת לנהל את ההזמנות לתכונה כלשהי, לחצו על שמה.',
	'invitations-invitedlist-none' => 'לא הוזמנתם להשתמש בתכונות תוכנה הזמינות בהזמנה בלבד כלשהן.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|הזמנה אחת זמינה|$1 הזמנות זמינות}})',
	'invitations-pagetitle' => 'תכונות תוכנה בהזמנה בלבד',
	'invitations-uninvitedlist-description' => 'אין לך גישה לתכונות תוכנה בהזמנה בלבד אלו.',
	'invitations-uninvitedlist-none' => 'לעת עתה, אין כל תכונות תוכנה המוקצות להזמנות בלבד.',
	'invitations-feature-pagetitle' => 'ניהול הזמנות - $1',
	'invitations-feature-access' => 'יש לכם כרגע גישה להשתמש בתכונה <i>$1</i>.',
	'invitations-feature-numleft' => 'עדיין {{PLURAL:$2|נותרה לכם הזמנה אחת|נותרו לכם <b>$1</b> מתוך $2 ההזמנות שלכם}}.',
	'invitations-feature-noneleft' => 'השתמשתם בכל ההזמנות המוקצות לכם עבור תכונה זו',
	'invitations-feature-noneyet' => 'עדיין לא קיבלתם את הקצאת ההזמנות עבור תכונה זו.',
	'invitations-feature-notallowed' => 'אין לכם גישה לשימוש בתכונה <i>$1</i>.',
	'invitations-inviteform-title' => 'הזמנת משתמשים לשימוש בתכונה $1',
	'invitations-inviteform-username' => 'משתמש להזמנה',
	'invitations-inviteform-submit' => 'הזמנה',
	'invitations-error-baduser' => 'ייתכן כי המשתמש שציינתם איננו קיים.',
	'invitations-error-alreadyinvited' => 'למשתמש שציינתם כבר יש גישה לתכונה זו!',
	'invitations-invite-success' => 'הזמנתם את המשתמש $1 בהצלחה להשתמש בתכונה זו!',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'invite-logpage' => 'आमंत्रण सूची',
	'invite-logpagetext' => 'यह अलग‍अलग प्रणाली फीचर्स का इस्तेमाल करके देखनेके लिये सदस्योंने एक दूसरे को दिये आमंत्रणोंकी सूची हैं।',
	'invite-logentry' => '<i>$2</i> फीचर इस्तेमाल करने के लिये $1 को आमंत्रित किया।',
	'invitations' => 'प्रणाली फीचर्स को दी हुई आमंत्रण नियंत्रित करें',
	'invitations-invitedlist-none' => 'आपको आमंत्रण आधारित प्रणाली फीचर्स देखनेके लिये एक भी आमंत्रण नहीं मिला हैं।',
	'invitations-pagetitle' => 'आमंत्रण आधारित प्रणाली फीचर्स',
	'invitations-uninvitedlist-description' => 'आपको यह अन्य आमंत्रण आधारित प्रणाली फीचर्स देखनेकी अनुमति नहीं हैं।',
	'invitations-uninvitedlist-none' => 'इस समयपर, अन्य कोईभी प्रणाली फीचर आमंत्रण आधारित नहीं रखा गया हैं।',
	'invitations-feature-pagetitle' => 'आमंत्रण व्यवस्थापन - $1',
	'invitations-feature-access' => 'आपको अभी <i>$1</i> का इस्तेमाल करने की अनुमति हैं।',
	'invitations-feature-numleft' => 'आपके पास अबभी $2 में से <b>$1</b> आमंत्रण बचे हुए हैं।',
	'invitations-feature-noneleft' => 'इस फीचर के लिये दिये गये सभी आमंत्रण आपने इस्तेमाल कर दिये हैं',
	'invitations-feature-noneyet' => 'इस फीचर के लिये अभी तक आपको आमंत्रण नहीं मिले हैं।',
	'invitations-feature-notallowed' => 'आपको <i>$1</i> का इस्तेमाल करने की अनुमति नहीं हैं।',
	'invitations-inviteform-title' => '$1 के इस्तेमाल के लिये सदस्यको आमंत्रित करें',
	'invitations-inviteform-username' => 'आमंत्रित करनेके लिये सदस्य',
	'invitations-inviteform-submit' => 'आमंत्रित करें',
	'invitations-error-baduser' => 'आपने दिया हुआ सदस्य अस्तित्वमें नहीं हैं।',
	'invitations-error-alreadyinvited' => 'आपने दिये हुए सदस्य को यह फीचर का इस्तेमाल करने की पहले से अनुमति हैं!',
	'invitations-invite-success' => 'आपने $1 को यह फीचर इस्तेमाल करने के लिये आमंत्रित किया!',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'invite-logpage' => 'Protokol přeprošenjow',
	'invite-logpagetext' => 'To je protokol wužiwarjow, kotřiž mjez sobu přeprošuja, zo bychu wšelake softwarowe funkcije wužiwali.',
	'invite-logentry' => 'je $1 přeprosył, zo by funkciju <i>$2</i> wužiwał.',
	'invitations' => 'Přeprošenja k softwarowym funkcijam zrjadować',
	'invitations-desc' => 'Zmóžnja [[Special:Invitations|zrjadowanje nowych funkcijow]] z wobmjezowanjom na system, kotryž na přeprošenja bazěruje',
	'invitations-invitedlist-description' => 'Maš přistup k slědowacym funkcijam softwary na zakładźe přeprošenjow.
Zo by softwaru za jednotliwu funkciju zrjadował, klikń na jeje mjeno.',
	'invitations-invitedlist-none' => 'Njejsy dotal přeprošenja za wužiwanje funkcijow softwary, kotraž na přeprošenjach bazěruje, dóstał',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Jedne přeprošenje|$1 přeprošeni|$1 přeprošenja|$1 přeprošenjow}} k dispoziciji)',
	'invitations-pagetitle' => 'Funkcije softwary na zakładźe přeprošenjow',
	'invitations-uninvitedlist-description' => 'Nimaš přistup k tutym druhim funkcijam softwary, kotraž na přeprošenjach bazěruje.',
	'invitations-uninvitedlist-none' => 'Tuchwilu njejsu žane softwarowe funkcije jako na přeprošenjach bazěrowace woznamjenjene.',
	'invitations-feature-pagetitle' => 'Zrjadowanje přeprošenja - $1',
	'invitations-feature-access' => 'Maš tuchwilu přistup k wužiwanju <i>$1</i>.',
	'invitations-feature-numleft' => 'Maš hišće {{PLURAL:$2|jedne přeprošenje|<b>$1</b> ze swojich $2 {{PLURAL:$2|přeprošenja|přeprošenjow|přeprošenjow|přeprošenjow}}}}.',
	'invitations-feature-noneleft' => 'Sy wšě swojich tebi přidźělenych přeprošenjow za tutu funkciju wužił',
	'invitations-feature-noneyet' => 'Dotal njejsu so ći žane přeprošenja za tutu funkciju přidźělili.',
	'invitations-feature-notallowed' => 'Nimaš přistup k wužiwanju <i>$1</i>.',
	'invitations-inviteform-title' => 'Wužiwarja za wužiwanje $1 přeprosyć',
	'invitations-inviteform-username' => 'Wužiwar, kotryž ma so přeprosyć',
	'invitations-inviteform-submit' => 'Přeprosyć',
	'invitations-error-baduser' => 'Wužiwar, kotrehož sy podał, njezda so eksistować.',
	'invitations-error-alreadyinvited' => 'Wužiwar, kotrehož sy podał, ma hižo přistup k tutej funkciji!',
	'invitations-invite-success' => 'Sy $1 wuspěšnje přeprosył, zo by tutu funkciju wužiwał!',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'invite-logpage' => 'Meghívások naplója',
	'invite-logpagetext' => 'Felhasználók naplója, akik meghívták egymást különböző programfunkciók használatára.',
	'invite-logentry' => 'meghívta $1 szerkesztőt a <i>$2</i> funkció használatára.',
	'invitations' => 'Meghívók kezelése különböző programfunkciókhoz',
	'invitations-desc' => '[[Special:Invitations|Új funkciók kezelése]] meghívó alapú rendszerre korlátozásukkal',
	'invitations-invitedlist-description' => 'Az alább felsorolt csak meghívásos alapon elérhető szoftverfunkciókhoz van hozzáférésed.
Egy egyedi funkció meghívóinak kezeléséhez kattints a nevére.',
	'invitations-invitedlist-none' => 'Még nem hívtak meg egyetlen csak meghívásos alapon elérhető programfunkció használatára sem.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|egy|$1}} elérhető meghívó)',
	'invitations-pagetitle' => 'Csak meghívással elérhető programfunkciók',
	'invitations-uninvitedlist-description' => 'Nincs hozzáférésed ezekhez ezen egyéb csak meghívásos programfunkciókhoz.',
	'invitations-uninvitedlist-none' => 'Jelenleg nincs más programfunkció, ami csak meghívásos alapon elérhető.',
	'invitations-feature-pagetitle' => 'Meghívókezelés – $1',
	'invitations-feature-access' => 'Jelenleg van hozzáférésed használni a következőt: <i>$1</i>.',
	'invitations-feature-numleft' => 'Még van {{PLURAL:$2|egy meghívód|<b>$1</b> meghívód a $2 darabból}}.',
	'invitations-feature-noneleft' => 'Elhasználtad az összes kiosztott meghívódat ehhez a funkcióhoz',
	'invitations-feature-noneyet' => 'Még nem kaptad meg a kiosztott meghívóidat ehhez a funkcióhoz.',
	'invitations-feature-notallowed' => 'Nincs hozzáférésed használni a következőt: <i>$1</i>.',
	'invitations-inviteform-title' => 'Szerkesztő meghívása $1 használatára',
	'invitations-inviteform-username' => 'Meghívandó szerkesztő',
	'invitations-inviteform-submit' => 'Meghívás',
	'invitations-error-baduser' => 'Úgy tűnik, hogy az általad megadott szerkesztő  nem létezik.',
	'invitations-error-alreadyinvited' => 'Az általad megadott szerkesztőnek már van hozzáférése ehhez a funkcióhoz!',
	'invitations-invite-success' => 'Sikeresen meghívtad $1 felhasználót ennek a funkciónak a használatára!',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'invite-logpage' => 'Registro de invitationes',
	'invite-logpagetext' => 'Isto es un registro del usatores invitante alteros a usar varie functiones del software.',
	'invite-logentry' => 'invitava $1 a usar le function <i>$2</i>.',
	'invitations' => 'Gerer invitationes a functiones del software',
	'invitations-desc' => 'Permitte le [[Special:Invitations|gerentia de nove functiones]] per restringer los con un systema a base de invitationes',
	'invitations-invitedlist-description' => 'Tu ha accesso al sequente functiones de software restringite al invitatos.
Pro gerer le invitationes a un function particular, clicca super le nomine de illo.',
	'invitations-invitedlist-none' => 'Tu non ha essite invitate a usar alcun functiones del software restringite a invitatos.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Un invitation|$1 invitationes}} disponibile)',
	'invitations-pagetitle' => 'Functiones del software restringite a invitatos',
	'invitations-uninvitedlist-description' => 'Tu non ha accesso a iste altere functiones del software restringite al invitatos.',
	'invitations-uninvitedlist-none' => 'A iste tempore, nulle altere functiones del software es restringite al invitatos.',
	'invitations-feature-pagetitle' => 'Gestion de invitationes - $1',
	'invitations-feature-access' => 'Tu ha ora accesso pro usar <i>$1</i>.',
	'invitations-feature-numleft' => 'Te resta ancora {{PLURAL:$2|un invitation|<b>$1</b> de tu $2 invitationes}}.',
	'invitations-feature-noneleft' => 'Tu ha usate tote tu quota de invitationes pro iste function',
	'invitations-feature-noneyet' => 'Tu non ha ancora recipite tu quota de invitationes pro iste function.',
	'invitations-feature-notallowed' => 'Tu non ha accesso pro usar <i>$1</i>.',
	'invitations-inviteform-title' => 'Invitar un usator a usar $1',
	'invitations-inviteform-username' => 'Usator a invitar',
	'invitations-inviteform-submit' => 'Invitar',
	'invitations-error-baduser' => 'Le usator que tu specificava non pare exister.',
	'invitations-error-alreadyinvited' => 'Le usator que tu specificava dispone ja de accesso a iste function!',
	'invitations-invite-success' => 'Tu ha invitate $1 a usar iste function con successo!',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'invite-logpage' => 'Log Undangan',
	'invite-logpagetext' => 'Ini adalah log pengguna mengundang satu sama lain dalam menggunakan berbagai fitur perangkat lunak.',
	'invite-logentry' => 'mengundang $1 menggunakan <i>$2</i> fitur.',
	'invitations' => 'Pengelolaan undangan untuk fitur perangkat lunak',
	'invitations-desc' => 'Memungkinkan [[Special:Invitations|manajemen fitur baru]] dengan membatasi mereka dalam sistem berbasis-undangan',
	'invitations-invitedlist-description' => 'Anda memiliki akses ke hanya-mengundang fitur perangkat lunak ini. 
Untuk mengelola undangan untuk setiap fitur, klik pada namanya.',
	'invitations-invitedlist-none' => 'Anda belum diundang untuk menggunakan hanya-mengundang fitur perangkat lunak.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Satu undangan|$1 undangan}} tersedia)',
	'invitations-pagetitle' => 'Hanya-Undang fitur perangkat lunak',
	'invitations-uninvitedlist-description' => 'Anda tidak memiliki akses ke hanya-mengundang fitur perangkat lunak yang lain.',
	'invitations-uninvitedlist-none' => 'Saat ini, tidak ada fitur perangkat lunak lain yang ditunjukkan sebagai hanya-undangan.',
	'invitations-feature-pagetitle' => 'Pengelolaan Undangan - $1',
	'invitations-feature-access' => 'Saat ini Anda memiliki akses untuk menggunakan <i>$1</i>.',
	'invitations-feature-numleft' => 'Anda masih memiliki {{PLURAL:$2|satu undangan tersisa|<b>$1</b> dari $2 undangan keluar  tersisa}}.',
	'invitations-feature-noneleft' => 'Anda sudah menggunakan semua alokasi undangan dari fitur ini',
	'invitations-feature-noneyet' => 'Andan belum menerima alokasi untuk undangan dari fitur ini.',
	'invitations-feature-notallowed' => 'Anda tidak memiliki akses untuk menggunakan <i>$1</i>.',
	'invitations-inviteform-title' => 'Undang pengguna untuk menggunakan $1',
	'invitations-inviteform-username' => 'Pengguna untuk diundang',
	'invitations-inviteform-submit' => 'Undangan',
	'invitations-error-baduser' => 'Pengguna yang anda tuju tidak terlihat keberadaanya.',
	'invitations-error-alreadyinvited' => 'Pengguna yang anda tuju sudah memiliki akses pada fitur ini!',
	'invitations-invite-success' => 'Anda berhasil mengundang $1 untuk menggunakan fitur ini!',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'invite-logpage' => '招待記録',
	'invite-logpagetext' => 'これは各種のソフトウェア機能を使えるように他の利用者の招待を行った利用者の記録です。',
	'invite-logentry' => '<i>$2</i>機能を使えるよう $1 を招待',
	'invitations' => 'ソフトウェア機能への招待を管理する',
	'invitations-desc' => '招待された利用者でなければ利用できないような[[Special:Invitations|新機能管理]]を実現する',
	'invitations-invitedlist-description' => 'あなたは以下の招待限定のソフトウェア機能を利用できます。各機能への招待を管理するには、その名前をクリックしてください。',
	'invitations-invitedlist-none' => 'あなたは招待限定のソフトウェア機能にはひとつも招待されていません。',
	'invitations-invitedlist-item-count' => '($1件の{{PLURAL:$1|招待}}があります)',
	'invitations-pagetitle' => '招待限定のソフトウェア機能',
	'invitations-uninvitedlist-description' => 'あなたはこれらの招待限定のソフトウェア機能を利用できません。',
	'invitations-uninvitedlist-none' => '現時点では、他に招待限定に設定されたソフトウェア機能はありません。',
	'invitations-feature-pagetitle' => '招待の管理 - $1',
	'invitations-feature-access' => 'あなたは現在、<i>$1</i> を利用できます。',
	'invitations-feature-numleft' => 'あなたにはまだ{{PLURAL:$2|1件の招待|$2件中 <b>$1件</b>の招待}}が残っています。',
	'invitations-feature-noneleft' => 'あなたはこの機能への招待の割り当てをすべて使い切りました。',
	'invitations-feature-noneyet' => 'あなたはこの機能への招待の割り当てをまだ受け取っていません。',
	'invitations-feature-notallowed' => 'あなたは <i>$1</i> を利用できません。',
	'invitations-inviteform-title' => '$1を使えるよう利用者を招待する',
	'invitations-inviteform-username' => '招待する利用者',
	'invitations-inviteform-submit' => '招待',
	'invitations-error-baduser' => '指定した利用者は存在しないようです。',
	'invitations-error-alreadyinvited' => '指定した利用者は既にこの機能を利用できます！',
	'invitations-invite-success' => 'この機能への $1 の招待に成功しました！',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'invite-logpage' => 'Log Undhangan',
	'invitations-feature-access' => 'Panjenengan saiki ana aksès kanggo nganggo <i>$1</i>.',
	'invitations-feature-notallowed' => 'Panjenengan ora ana aksès nganggo <i>$1</i>.',
	'invitations-inviteform-title' => 'Undhang sawijining panganggo supaya nganggo $1',
	'invitations-inviteform-username' => 'Panganggo sing diundhang',
	'invitations-inviteform-submit' => 'Undhang',
	'invitations-error-alreadyinvited' => 'Panganggo sing dispésifikasi panjenengan wis duwé aksès ing fitur iki!',
	'invitations-invite-success' => 'Panjenengan bisa sacara suksès ngundhang $1 supaya nganggo fitur iki!',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'invite-logpage' => 'កំណត់ហេតុនៃការអញ្ជើញ',
	'invite-logpagetext' => 'នេះជាកំណត់ហេតុនៃអ្នកប្រើប្រាស់ទាំងឡាយដែលបានអញ្ជើញគ្នា​អោយប្រើប្រាស់មុខងារសូហ្វវែរផ្សេងៗ។',
	'invite-logentry' => 'បានអញ្ជើញ $1 ឱ្យប្រើប្រាស់មុខងារ <i>$2</i>។',
	'invitations' => 'គ្រប់គ្រងការអញ្ជើញឱ្យប្រើប្រាស់មុខងារសូហ្វវែរ',
	'invitations-desc' => 'អនុញ្ញាតឱ្យ[[Special:Invitations|គ្រប់គ្រងមុខងារថ្មីៗ]]ដោយដាក់កំហិតឱ្យប្រើប្រាស់សម្រាប់តែអ្នកដែលមានលិខិតអញ្ជើញ',
	'invitations-invitedlist-none' => 'អ្នកមិនត្រូវបានគេអញ្ជើញឱ្យប្រើប្រាស់មុខងារសូហ្វវែរដែលត្រូវការឱ្យមានការអញ្ជើញទេ។',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|១លិខិតអញ្ជើញ|$1 លិខិតអញ្ជើញ}}នៅសល់)',
	'invitations-pagetitle' => 'មុខងារសូហ្វវែរសម្រាប់តែអ្នកមានលិខិតអញ្ជើញ',
	'invitations-uninvitedlist-description' => 'អ្នកមិនអាចចូលទៅក្នុងមុខងារសូហ្វវែរសម្រាប់តែអ្នកមានលិខិតអញ្ជើញបានទេ។',
	'invitations-feature-pagetitle' => 'ការគ្រប់គ្រងលិខិតអញ្ជើញ- $1',
	'invitations-feature-access' => 'បច្ចុប្បន្នអ្នកអាចចូលទៅប្រើ <i>$1</i>បាន។',
	'invitations-feature-numleft' => 'អ្នកនៅសល់{{PLURAL:$2|១លិខិតអញ្ជើញទៀត|<b>$1</b>លិខិតអញ្ជើញ ក្នុងចំណោម $2 លិខិតអញ្ជើញសរុប}}។',
	'invitations-feature-notallowed' => 'អ្នកមិនអាចចូលទៅប្រើប្រាស់ <i>$1</i> បានទេ។',
	'invitations-inviteform-title' => 'អញ្ជើញអ្នកប្រើប្រាស់ម្នាក់ឱ្យប្រើ $1',
	'invitations-inviteform-username' => 'អ្នកប្រើប្រាស់​ដែលត្រូវអញ្ជើញ',
	'invitations-inviteform-submit' => 'អញ្ជើញ',
	'invitations-error-baduser' => 'អ្នកប្រើប្រាស់ដែលអ្នកបានសំដៅ ហាក់ដូចជាមិនមានទេ។',
	'invitations-error-alreadyinvited' => 'អ្នកប្រើប្រាស់ដែលអ្នកបានសំដៅ មានសិទ្ឋិចូលទៅប្រើប្រាស់មុខងារនេះរួចហើយ!',
	'invitations-invite-success' => 'អ្នកបានអញ្ជើញ $1 ឱ្យប្រើប្រាស់មុខងារនេះដោយជោគជ័យ!',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'invite-logpage' => 'Et Logboch met de Enladunge',
	'invite-logpagetext' => 'Dat hee es dat Logboch met de Müjjeleschkeite fum Projramm, di op Enladung parat schtonn.',
	'invite-logentry' => 'hat dä Metmaacher „$1“ för „<i>$2</i>“ ze nozze ennjelade.',
	'invitations' => 'Ennladunge zoh Projramm-Eijeschaffte Verwallde',
	'invitations-desc' => 'Määt et jöt met [[Special:Invitations|neu Müjjeleschkeite]] fum Projramm ömzejonn, indämm dat mer se Beschrängk op bestemmpte Metmaacher dorj_e System fun Ennladunge.',
	'invitations-invitedlist-description' => 'Do häß Zojang zo onge de Eijeschaffte fum Projramm, di Der op Ennladung zur Ferföjung schtonn. Öm Ding Enladung för en beshtemmpte Eijeschaff ze beärrbeide, donn op dä iere Name klecke.',
	'invitations-invitedlist-none' => 'Do häß be jez kei Ennladung kräje, för en Projramm-Eijeschaff ze noze, di op Ennladung es.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Ein Ennladung|$1 Ennladunge|kei Ennladung}} sen müjjelesch)',
	'invitations-pagetitle' => 'Projramm-Eijeschaffte op Ennladung',
	'invitations-uninvitedlist-description' => 'Do häß keine Zojang zo andere Projramm-Eijeschaffte, di op Ennladung sin.',
	'invitations-uninvitedlist-none' => 'För der Momang sin kein andere Projramm-Eijeschaffte nor op Ennladung ze han.',
	'invitations-feature-pagetitle' => 'Ennladunge verwallde - $1',
	'invitations-feature-access' => 'Zo kanns em Momang „<i>$1</i>“ bruche.',
	'invitations-feature-numleft' => 'Do häs {{PLURAL:$1|noch <b>ein</b>|noch <b>$1</b>|<b>keine </b>}} fun
{{PLURAL:$2|Dinge <b>eine</b> Ennladung|Dinge <b>$2</b> Ennladunge|<b>keine</b> Ennladung}}
övverisch.',
	'invitations-feature-noneleft' => 'Do häß ald ll Ding müjjelesche Ennladunge verjovve.',
	'invitations-feature-noneyet' => 'Do hä moch kei Ennladunge zum ußjävve zojedeilt kräje.',
	'invitations-feature-notallowed' => 'Do häs nit dat Rääsch, för „<i>$1</i>“ ze noze.',
	'invitations-inviteform-title' => 'Lad ene Metmaacher zom „<i>$1</i>“ noze en.',
	'invitations-inviteform-username' => 'Dä Metmaacher zum Ennlade',
	'invitations-inviteform-submit' => 'Ennlade',
	'invitations-error-baduser' => 'Dä aanjejovve Metmaacher schingk et nit ze jävve.',
	'invitations-error-alreadyinvited' => 'Dä Metmaacher hät ald en Ennladung, udder och ene ander Zohjang fö di Projramm-Eijeschaff!',
	'invitations-invite-success' => 'De häs jäz dä Metmaacher „$1“ fö di Projamm-Eijeschaff ennjelade.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'invite-logpage' => 'Lëscht vun den Invitatiounen',
	'invite-logpagetext' => 'Dëst ass e Logbuch vu Benotzer déi een den aneren invitéieren fir verschidde Softwaren ze benotzen.',
	'invite-logentry' => "huet $1 invitéiert fir d'Functionalitéit <i>$2</i> ze benotzen.",
	'invitations' => 'Gestioun vun den Invitatioune fir Software-Functionalitéiten',
	'invitations-desc' => "Erméiglecht d'[[Special:Invitations|Gestioun vun neie Fonctionnalitéiten]] déi op déi Benotzer limitéiert sinn, déi dofir invitéiert ginn",
	'invitations-invitedlist-description' => 'Dir hutt Zougang zu dëse Software-Fonctiounen déi nëmme fir invitéiert Benotzer zougänglech sinn.
Fir Invitatioune fir eng bestëmmte fonctioun ze kréien, klickt w.e.g. op de jeweilegen Numm.',
	'invitations-invitedlist-none' => 'Dir gouft net invitéiert fir eng Softwarefonctioun ze benotze fir déi een invitéiert gëtt.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Eng Invitatioun|$1 Invitatioune}} disponibel)',
	'invitations-pagetitle' => 'Fonctionnalitéiten op Invitatiouns-Basis',
	'invitations-uninvitedlist-description' => 'Dir hutt keen Zougang zu den aneren op Invtatioun baséiert Software-Fonctiounen.',
	'invitations-uninvitedlist-none' => 'Zu dësem Zäitpunkt gëtt et keng aner Softarefonctiounen déi just fir invitéiert Benotzer disponibel sinn.',
	'invitations-feature-pagetitle' => 'Gestioun vun der Invitatioun - $1',
	'invitations-feature-access' => 'Dir kënnt elo <i>$1</i> benotzen.',
	'invitations-feature-numleft' => 'Dir hutt nach {{PLURAL:$2|eng Invitatioun |<b>$1</b> vun ären $2 Invitatiounen}} iwwreg.',
	'invitations-feature-noneleft' => 'Dir hutt all är Invitatiounen fir dës Fonctioun benotzt.',
	'invitations-feature-noneyet' => 'Dir hutt är Invitatioune fir dës Fonctioun nach net kritt.',
	'invitations-feature-notallowed' => 'Dir hutt keen Zougang fir <i>$1</i> ze benotzen.',
	'invitations-inviteform-title' => 'Ee Benotzer invitéiere fir $1 ze benotzen',
	'invitations-inviteform-username' => "Benotzer fir z'invitéieren",
	'invitations-inviteform-submit' => 'Invitéieren',
	'invitations-error-baduser' => 'De Benotzer deen Dir uginn hutt schéngt et net ze ginn.',
	'invitations-error-alreadyinvited' => 'Dee Benotzer deen Dir uginn hutt huet schonn Accès op déi Fonctioun!',
	'invitations-invite-success' => 'Dir hutt de(n) $1 invitéiert fir dës Fonctioun ze benotzen!',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'invite-logpage' => 'Дневник на покани',
	'invite-logpagetext' => 'Ова е дневник на корисниците кои си праќаат покани за користење на разни програмски можности.',
	'invite-logentry' => 'испрати покана до $1 за да користи <i>$2</i>.',
	'invitations' => 'Раководење со покани за програмски можности',
	'invitations-desc' => 'Овозможува [[Special:Invitations|раководење со нови можности]]  со тоа што ги ограничува преку систем на покани',
	'invitations-invitedlist-description' => 'Имате пристап до следниве програмски можности, достапни само со покана.
За раководење со поканите за поединечни можности, кликнете на името на можноста.',
	'invitations-invitedlist-none' => 'Не сте поканети да ја корисите оваа програмска можност, достапна само со покана.',
	'invitations-invitedlist-item-count' => '(Имате {{PLURAL:$1|една покана|$1 покани}} на располагање)',
	'invitations-pagetitle' => 'Можности на програмот достапни само со покана',
	'invitations-uninvitedlist-description' => 'Немате пристап до оваа и други програмски можности, кои се достапни само со покана.',
	'invitations-uninvitedlist-none' => 'Моментално нема други програмски можности достапни само со покана.',
	'invitations-feature-pagetitle' => 'Раководење со поканите - $1',
	'invitations-feature-access' => 'Моментално имате пристап да користите <i>$1</i>.',
	'invitations-feature-numleft' => '{{PLURAL:$2|Ви преостанува уште една покана|Ви преостануваат уште <b>$1</b> од $2 покани}}.',
	'invitations-feature-noneleft' => 'Ги искористивте сите покани кои ви следуваат за оваа можност',
	'invitations-feature-noneyet' => 'Немате добиено следување од покани за оваа можност.',
	'invitations-feature-notallowed' => 'Немате пристап да користите <i>$1</i>.',
	'invitations-inviteform-title' => 'Покана до корисник да користи $1',
	'invitations-inviteform-username' => 'Корисник',
	'invitations-inviteform-submit' => 'Покани',
	'invitations-error-baduser' => 'Се чини дека назначениот корисник не постои.',
	'invitations-error-alreadyinvited' => 'Назначениот корисник веќе има пристап до оваа можност!',
	'invitations-invite-success' => 'Успешно го поканивте корисникот $1 да ја користи оваа можност!',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'invite-logpage' => 'ക്ഷണത്തിന്റെ പ്രവര്‍ത്തനരേഖ',
	'invite-logpagetext' => 'വിവിധ സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകള്‍ പരീക്ഷിക്കുവാന്‍ ഉപയോക്താക്കള്‍ അന്യോന്യം ക്ഷണിക്കുന്നതിന്റെ പ്രവര്‍ത്തന രേഖയാണിത്.',
	'invite-logentry' => '<i>$2</i> എന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷത ഉപയോഗിക്കുവാന്‍  $1നെ ക്ഷണിച്ചു.',
	'invitations' => 'സോഫ്റ്റ്‌വെയര്‍ സവിശേഷത പരീക്ഷിക്കുവാനുള്ള ക്ഷണപത്രികകള്‍ പരിപാലിക്കുക',
	'invitations-invitedlist-description' => 'ക്ഷണത്തിലൂടെ മാത്രം പരീക്ഷിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകളില്‍,  താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്നവ‍ താങ്കള്‍ക്ക് പരീക്ഷിക്കാം. ഒരു പ്രത്യേക സവിശേഷതയ്ക്കുള്ള ക്ഷണപത്രിക പരിപാലിക്കാന്‍, പ്രസ്തുത പേരില്‍ ഞെക്കുക.',
	'invitations-invitedlist-none' => "'''ക്ഷണത്തിലൂടെ മാത്രം പരീക്ഷിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷത'''കള്‍ ഉപയോഗിക്കുവാന്‍ താങ്കള്‍ ക്ഷണിക്കപ്പെട്ടിട്ടില്ല.",
	'invitations-pagetitle' => 'ക്ഷണത്തിലൂടെ മാത്രം ഉപയോഗിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകള്‍',
	'invitations-uninvitedlist-description' => "മറ്റ് '''ക്ഷണത്തിലൂടെ മാത്രം പരീക്ഷിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകള്‍''' ഉപയോഗിക്കാനുള്ള അനുമതി  താങ്കള്‍ക്കില്ല.",
	'invitations-uninvitedlist-none' => "നിലവില്‍ മറ്റു സോഫ്റ്റ്‌വെയര്‍ സവിശേഷതകള്‍ ഒന്നും '''ക്ഷണത്തിലൂടെ മാത്രം പരീക്ഷിക്കുവാന്‍ സാധിക്കുന്ന സോഫ്റ്റ്‌വെയര്‍ സവിശേഷത''' ആയി രേഖപ്പെടുത്തിയിട്ടില്ല.",
	'invitations-feature-pagetitle' => 'ക്ഷണപത്രിക പരിപാലനം -  $1',
	'invitations-feature-access' => 'താങ്കള്‍‍ക്ക് നിലവില്‍ <i>$1</i> ഉപയോഗിക്കാനുള്ള അനുമതിയുണ്ട്.',
	'invitations-feature-numleft' => 'ബാക്കിയുള്ള $2 ക്ഷണപത്രികകളില്‍ താങ്കള്‍ക്ക് ഇപ്പോഴും  <b>$1</b> എണ്ണമുണ്ട്.',
	'invitations-feature-noneleft' => 'ഈ സവിശേഷതയുടെ ലഭ്യമായ ക്ഷണപത്രികകളെല്ലാം താങ്കള്‍ ഉപയോഗിച്ചു കഴിഞ്ഞു.',
	'invitations-feature-noneyet' => 'ഈ സവിശേഷതയുടെ താങ്കള്‍ക്ക് വരേണ്ട ക്ഷണപത്രിക താങ്കള്‍ക്ക് ലഭിച്ചിട്ടില്ല.',
	'invitations-feature-notallowed' => 'താങ്കള്‍ക്ക്  <i>$1</i> ഉപയോഗിക്കാനുള്ള അനുമതി ഇല്ല.',
	'invitations-inviteform-title' => '$1 ഉപയോഗിക്കുവാന്‍ വേണ്ടി ഉപയോക്താവിനെ ക്ഷണിക്കുക',
	'invitations-inviteform-username' => 'ക്ഷണിക്കപ്പെടേണ്ട ഉപയോക്താവ്',
	'invitations-inviteform-submit' => 'ക്ഷണിക്കുക',
	'invitations-error-baduser' => 'താങ്കള്‍ തിരഞ്ഞെടുത്ത ഉപയോക്തൃനാമം നിലവിലുള്ളതായി കാണുന്നില്ല.',
	'invitations-error-alreadyinvited' => 'താങ്കള്‍ തിരഞ്ഞെടുത്ത ഉപയോക്താവിനു ഇപ്പോള്‍ തന്നെ ഈ സവിശേഷത ലഭ്യമാണ്‌.',
	'invitations-invite-success' => 'ഈ സവിശേഷത ഉപയോഗിക്കുവാന്‍ താങ്കള്‍ $1നെ വിജയകരമായി ക്ഷണിച്ചിരിക്കുന്നു!',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'invite-logpage' => 'आमंत्रणांची सूची',
	'invite-logpagetext' => 'ही वेगवेगळ्या प्रणालींचे फीचर्स वापरून पाहण्यासाठी सदस्यांनी एकमेकांना दिलेल्या आमंत्रणांची सूची आहे.',
	'invite-logentry' => '<i>$2</i> फीचर वापरण्यासाठी $1 ला आमंत्रित केले.',
	'invitations' => 'प्रणाली फीचर्स ला दिलेली आमंत्रणे नियंत्रित करा',
	'invitations-desc' => 'आमंत्रण आधारित करुन [[Special:Invitations|नवीन फीचर्सना नियंत्रित]] करण्याची परवानगी देते',
	'invitations-invitedlist-description' => 'तुम्हाला खालीलपैकी फक्त आमंत्रण आधारित प्रणाली फीचर्स पाहता येतील.
एखाद्या विशिष्ट फीचर्सची आमंत्रणे पाहण्यासाठी, त्याच्या नावावर टिचकी द्या.',
	'invitations-invitedlist-none' => 'तुम्हाला आमंत्रण आधारित प्रणाली फीचर्स पाहण्यासाठी एकही आमंत्रण आलेले नाही.',
	'invitations-pagetitle' => 'आमंत्रण आधारित प्रणाली फीचर्स',
	'invitations-uninvitedlist-description' => 'तुम्हाला ही इतर आमंत्रण आधारित प्रणाली वैशिष्ठ्ये पाहण्याची अनुमती नाही.',
	'invitations-uninvitedlist-none' => 'या वेळी, इतर कुठलेही प्रणाली वैशिष्ठ्य आमंत्रण आधारित केलेले नाही.',
	'invitations-feature-pagetitle' => 'आमंत्रण व्यवस्थापन - $1',
	'invitations-feature-access' => 'तुम्हाला सध्या <i>$1</i> वापरण्याची अनुमती आहे.',
	'invitations-feature-numleft' => 'तुमच्याकडे अजून $2 पैकी <b>$1</b> आमंत्रणे उरलेली आहेत.',
	'invitations-feature-noneleft' => 'या फीचरसाठी देण्यात आलेली सर्व आमंत्रणे तुम्ही वापरलेली आहेत',
	'invitations-feature-noneyet' => 'या फीचरसाठी अजून तुम्हाला आमंत्रणे देण्यात आलेली नाहीत.',
	'invitations-feature-notallowed' => 'तुम्हाला <i>$1</i> वापरण्याची परवानगी नाही.',
	'invitations-inviteform-title' => '$1 वापरण्यासाठी एखाद्या सदस्याला आमंत्रण द्या',
	'invitations-inviteform-username' => 'आमंत्रित करावयाचा सदस्य',
	'invitations-inviteform-submit' => 'आमंत्रित करा',
	'invitations-error-baduser' => 'तुम्ही दिलेला सदस्य अस्तित्वात नाही.',
	'invitations-error-alreadyinvited' => 'तुम्ही दिलेल्या सदस्याला अगोदरच हे फीचर वापरण्याची परवानगी आहे!',
	'invitations-invite-success' => 'तुम्ही यशस्वीरित्या $1 ला हे फीचर वापरण्यासाठी आमंत्रित केलेले आहे!',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'invite-logpage' => 'Uitnodigingslogboek',
	'invite-logpagetext' => 'Dit is een logboek van gebruikers die elkaar uitnodigen om verschillende softwarefuncties te gebruiken.',
	'invite-logentry' => 'heeft $1 uitgenodigd om de functie <i>$2</i> te gebruiken.',
	'invitations' => 'Uitnodigingen voor softwarefuncties beheren',
	'invitations-desc' => 'Maakt het mogelijk het gebruik van [[Special:Invitations|nieuwe functionaliteit te beheren]] door deze alleen op uitnodiging beschikbaar te maken',
	'invitations-invitedlist-description' => 'U hebt toegang tot de volgende alleen op uitnodiging beschikbare functionaliteit. Om te verzenden uitnodigingen per functionaliteit te beheren, kunt u op de naam van de functionaliteit klikken.',
	'invitations-invitedlist-none' => 'U bent niet uitgenodigd om alleen op uitnodiging beschikbare functionaliteit te gebruiken.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Eén uitnodiging|$1 uitnodiging}} beschikbaar)',
	'invitations-pagetitle' => 'Functionaliteit alleen op uitnodiging beschikbaar',
	'invitations-uninvitedlist-description' => 'U hebt geen toegang tot deze andere alleen op uitnodiging beschikbare functionaliteit.',
	'invitations-uninvitedlist-none' => 'Er is op dit moment geen functionaliteit aangewezen die alleen op uitnodiging beschikbaar is.',
	'invitations-feature-pagetitle' => 'Uitnodigingenbeheer - $1',
	'invitations-feature-access' => 'U hebt op dit moment toestemming om <i>$1</i> te gebruiken.',
	'invitations-feature-numleft' => 'U hebt nog {{PLURAL:$2|één uitnodiging|<b>$1</b> van uw $2 uitnodigingen}} over.',
	'invitations-feature-noneleft' => 'U hebt alle uitnodigingen voor deze functionaliteit gebruikt',
	'invitations-feature-noneyet' => 'U hebt nog geen te verdelen uitnodigingen gekregen voor deze functionaliteit.',
	'invitations-feature-notallowed' => 'U hebt geen toestemming om <i>$1</i> te gebruiken.',
	'invitations-inviteform-title' => 'Een gebruiker uitnodigen om $1 te gebruiken',
	'invitations-inviteform-username' => 'Uit te nodigen gebruiker',
	'invitations-inviteform-submit' => 'Uitnodigen',
	'invitations-error-baduser' => 'De opgegeven gebruiker lijkt niet te bestaan.',
	'invitations-error-alreadyinvited' => 'De opgegeven gebruiker heeft al toegang tot deze functionaliteit.',
	'invitations-invite-success' => '$1 is uitgenodigd voor het gebruiken van deze functionaliteit!',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'invite-logpage' => 'Invitasjonslogg',
	'invite-logpagetext' => 'Dette er ein logg over brukarar som har invitert kvarandre til å nytta diverse programvarefunksjonar.',
	'invite-logentry' => 'inviterte $1 til å nytta funksjonen <i>$2</i>',
	'invitations' => 'Handsam invitasjonar til programvarefunksjonar',
	'invitations-desc' => 'Gjer det mogleg å [[Special:Invitations|kontrollera nye funksjonar]] ved å avgrensa dei til eit invitasjonsbasert system',
	'invitations-invitedlist-description' => 'Du har tilgjenge til fylgjande funksjonar som krev invitasjon.
Trykk på namnet åt ein funksjon for å handsama han.',
	'invitations-invitedlist-none' => 'Du har ikkje vorten invitert til å nytta funksjonar som krev invitasjon.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Éin invitasjon er tilgjengeleg|$1 invitasjonar er tilgjengelege}})',
	'invitations-pagetitle' => 'Funksjonar som krev invitasjon',
	'invitations-uninvitedlist-description' => 'Du har ikkje tilgjenge til desse funksjonane som krev invitasjon.',
	'invitations-uninvitedlist-none' => 'Ingen programvarefunksjonar krev invitasjon.',
	'invitations-feature-pagetitle' => 'Handsaming av invitasjonar – $1',
	'invitations-feature-access' => 'Du har tilgjenge til å nytta <i>$1</i>.',
	'invitations-feature-numleft' => 'Av dei $2 invitasjonane dine har du enno {{PLURAL:$1|éin|<b>$1</b>}} att.',
	'invitations-feature-noneleft' => 'Du har brukt alle invitasjonane dine for denne funksjonen',
	'invitations-feature-noneyet' => 'Du har ikkje fått tildelt din del av invitasjonar for denne funksjonen.',
	'invitations-feature-notallowed' => 'Du har ikkje tilgjenge til å bruka <i>$1</i>.',
	'invitations-inviteform-title' => 'Inviter ein brukar til å bruka $1',
	'invitations-inviteform-username' => 'Brukar som skal verta invitert',
	'invitations-inviteform-submit' => 'Inviter',
	'invitations-error-baduser' => 'Brukaren du oppgav finst ikkje.',
	'invitations-error-alreadyinvited' => 'Brukaren du oppgav har alt tilgjenge til denne funksjonen!',
	'invitations-invite-success' => 'Du har invitert $1 til å nytta denne funksjonen!',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'invite-logpage' => 'Invitasjonslogg',
	'invite-logpagetext' => 'Dette er en logg over hvilke brukere som har invitert hverandre til å bruke diverse programvarefunksjoner.',
	'invite-logentry' => 'inviterte $1 til å bruke funksjonen <i>$2</i>',
	'invitations' => 'Behandling av intiasjoner til programvarefunksjoner',
	'invitations-desc' => 'Gjør det mulig å [[Special:Invitations|kontrollere nye funksjoner]] ved å begrense dem med et invitasjonsbasert system',
	'invitations-invitedlist-description' => 'Du har tilgang til følgende funksjoner som krever invitasjon. Klikk på funksjonens navn for å behandle invitasjoner for de enkelte funksjonene.',
	'invitations-invitedlist-none' => 'Du har ikke blitt invitert til å bruke noen funksjoner som krever invitasjon.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Én invitasjon er tilgjengelig|$1 invitasjoner er tilgjengelige}})',
	'invitations-pagetitle' => 'Funksjoner som krever invitasjon',
	'invitations-uninvitedlist-description' => 'Du har ikke tilgang til disse funksjonene som krever invitasjon.',
	'invitations-uninvitedlist-none' => 'Ingen programvarefunksjoner krever invitasjon.',
	'invitations-feature-pagetitle' => 'Invitasjonsbehandling – $1',
	'invitations-feature-access' => 'Du har tilgang til å bruke <i>$1</i>.',
	'invitations-feature-numleft' => 'Av dine $2 invitasjoner har du fortsatt {{PLURAL:$1|én|<b>$1</b>}} igjen.',
	'invitations-feature-noneleft' => 'Du har brukt alle dine invitasjoner for denne funksjonen',
	'invitations-feature-noneyet' => 'Du har ikke fått tildelt din andel invitasjoner for denne funksjonen.',
	'invitations-feature-notallowed' => 'Du har ikke tilgang til å bruke <i>$1</i>.',
	'invitations-inviteform-title' => 'Inviter en bruker til å bruke $1',
	'invitations-inviteform-username' => 'Bruker som skal inviteres',
	'invitations-inviteform-submit' => 'Inviter',
	'invitations-error-baduser' => 'Brukeren du oppga finnes ikke.',
	'invitations-error-alreadyinvited' => 'Brukeren du oppga har allerede tilgang til denne funksjonen!',
	'invitations-invite-success' => 'Du har invitert $1 til å bruke denne funksjonen!',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'invite-logpage' => 'Jornal dels convits',
	'invite-logpagetext' => 'Vaquí un jornal dels utilizaires en convidant d’autres per utilizar las foncionalitats de divèrses programas',
	'invite-logentry' => 'a convidat $1 a utilizar la foncionalitat de <i>$2</i>.',
	'invitations' => 'Gerís los convits de las foncionalitats logicialas',
	'invitations-desc' => 'Permet [[Special:Invitations|la gestion de las foncionalitats novèlas]] en las restrenhent per un sistèma basat sul convit.',
	'invitations-invitedlist-description' => 'Avètz accès a las caracteristicas seguentas del logicial de convit sol. Per gerir los convits per una catacteristica individuala, clicatz sus son nom.',
	'invitations-invitedlist-none' => 'Sètz pas estat convidat per utilizar las foncionalitats del logicial de convit sol.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Un convit disponible|$1 convits disponibles}})',
	'invitations-pagetitle' => 'Foncionalitats del logiciel de convit sol',
	'invitations-uninvitedlist-description' => 'Avètz pas accès a aquestas autras caracteristicas del programa de convit sol.',
	'invitations-uninvitedlist-none' => 'En aqueste moment, cap de foncionalitat logiciala es pas estada designada pel convit sol.',
	'invitations-feature-pagetitle' => 'Gestion del convit - $1',
	'invitations-feature-access' => "Actualament, avètz l'accès per utilizar <i>$1</i>.",
	'invitations-feature-numleft' => 'Avètz encara {{PLURAL:$2|un convit vòstre daissat|<b>$1</b> $2 convits vòstres daissats}}.',
	'invitations-feature-noneleft' => "Avètz utilizat l'ensemble de vòstres convits permeses per aquesta foncionalitat",
	'invitations-feature-noneyet' => 'Çaquelà, avètz pas recebut vòstra assignacion dels convits per aquesta foncionalitat.',
	'invitations-feature-notallowed' => 'Avètz pas l’accès per utilizar <i>$1</i>.',
	'invitations-inviteform-title' => 'Convidar un utilizaire per utilizar $1',
	'invitations-inviteform-username' => 'Utilizaire de convidar',
	'invitations-inviteform-submit' => 'Convidar',
	'invitations-error-baduser' => "L’utilizaire qu'avètz indicat sembla pas existir.",
	'invitations-error-alreadyinvited' => "L’utilizaire qu'avètz indicat ja dispausa de l’accès a aquesta foncionalitat !",
	'invitations-invite-success' => 'Avètz convidat $1 amb succès per utilizar aquesta foncionalitat !',
);

/** Polish (Polski)
 * @author Maikking
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'invite-logentry' => 'zaprosił $1 do używania dodatku <i>$2</i>',
	'invitations-feature-notallowed' => 'Nie masz odpowiednich uprawnień do korzystania z <i>$1</i>.',
	'invitations-inviteform-submit' => 'Zaproś',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'invite-logpage' => "Registr ëd j'anvit",
	'invite-logpagetext' => "Sto-sì a l'é un registr ëd j'utent che as anvito l'un l'àutr a dovré le diferente possibilità dël programa.",
	'invite-logentry' => 'Anvità $1 a dovré la possibilità <i>$2</i>.',
	'invitations' => "Gestiss j'anvit a le possibilità software",
	'invitations-desc' => "A përmët le [[Special:Invitations|gestion ëd le neuve possibilità]] an restrinzendje a un sistema basà an sj'anvit",
	'invitations-invitedlist-description' => "It l'has mach acess a le caraterìstiche sì-sota dël programa mach a anvit.
Për gestì j'anvit për na sola caraterìstica, sgnaca an sël sò nòm.",
	'invitations-invitedlist-none' => 'It ses pa stàit anvità a dovré dle possibilità dël programa mach a anvit.',
	'invitations-invitedlist-item-count' => "({{PLURAL:$1|N'anvit disponìbil|$1 anvit disponibij}})",
	'invitations-pagetitle' => 'Possibilità software mach a anvit',
	'invitations-uninvitedlist-description' => "It l'has pa acess a coste àutre caraterìstiche dël programa mach a anvit.",
	'invitations-uninvitedlist-none' => 'Adess, gnun-e àutre possibilità software a son nominà mach a anvit.',
	'invitations-feature-pagetitle' => "Gestion ëd j'anvit - $1",
	'invitations-feature-access' => "Adess it l'has acess për dovré <i>$1</i>.",
	'invitations-feature-numleft' => "It l'has ancó {{PLURAL:$2|n'anvit restant|<b>$1</b> anvit restant dij tò $2}}.",
	'invitations-feature-noneleft' => "It l'has dovrà tùit ij tò anvit për sta possibilità-sì",
	'invitations-feature-noneyet' => "It l'has pa ancó arseivù toa alocassion d'anvit për sta possibilità-sì.",
	'invitations-feature-notallowed' => "It l'has pa acess për dovré <i>$1</i>.",
	'invitations-inviteform-title' => "Anvita n'utent a dovré $1",
	'invitations-inviteform-username' => 'Utent da anvité',
	'invitations-inviteform-submit' => 'Anvit',
	'invitations-error-baduser' => "L'utent ch'it l'has specificà a smija ch'a esista pa.",
	'invitations-error-alreadyinvited' => "L'utent ch'it l'has specificà a l'ha già acess a sta possibiltà-sì!",
	'invitations-invite-success' => "It l'has anvità con sucess $1 a dovré sta possibilità-sì!",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'invite-logpage' => 'د بلنې يادښت',
	'invitations-feature-notallowed' => 'تاسو د <i>$1</i> د کارونې لاسرسی نه لری.',
	'invitations-inviteform-title' => 'يوه کارونکي ته د $1 د کارولو بلنه ورکول',
	'invitations-inviteform-username' => 'بلل شوی کارونکی',
	'invitations-inviteform-submit' => 'بلنه ورکول',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'invite-logpage' => 'Registo de Convites',
	'invite-logpagetext' => 'Isto é um registo de utilizadores que se convidam uns aos outros a usarem as várias funcionalidades do software.',
	'invite-logentry' => 'convidou $1 a usar a funcionalidade <i>$2</i>.',
	'invitations' => 'Gerir convites para funcionalidades de software',
	'invitations-desc' => 'Permite [[Special:Invitations|a gestão de novas funcionalidades]] através da sua restrição a um sistema baseado em convites',
	'invitations-invitedlist-description' => 'Você tem acesso às seguintes funcionalidades do software atribuídas apenas por convite. Para gerir convites para uma funcionalidade individual, clique no seu nome.',
	'invitations-invitedlist-none' => 'Você não foi convidado a usar nenhuma funcionalidade do software atribuída apenas por convite.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Um convite disponível|$1 convites disponíveis}})',
	'invitations-pagetitle' => 'Funcionalidades do software atribuídas apenas por convite',
	'invitations-uninvitedlist-description' => 'Você não tem acesso a estas outras funcionalidades do software atribuídas apenas por convite.',
	'invitations-uninvitedlist-none' => 'Neste momento, mais nenhumas funcionalidades do software são atribuídas apenas por convite.',
	'invitations-feature-pagetitle' => 'Gestão de Convites - $1',
	'invitations-feature-access' => 'Actualmente não possui acesso ao uso de <i>$1</i>.',
	'invitations-feature-numleft' => 'Ainda lhe {{PLURAL:$2|resta um|restam <b>$1</b>}} dos seus $2 convites.',
	'invitations-feature-noneleft' => 'Você já utilizou toda a sua quota de convites para esta funcionalidade',
	'invitations-feature-noneyet' => 'Você ainda não recebeu a sua quota de convites para esta funcionalidade.',
	'invitations-feature-notallowed' => 'Não tem acesso ao uso de <i>$1</i>.',
	'invitations-inviteform-title' => 'Convidar um utilizador a usar $1',
	'invitations-inviteform-username' => 'Utilizador a convidar',
	'invitations-inviteform-submit' => 'Convidar',
	'invitations-error-baduser' => 'O utilizador que especificou parece não existir.',
	'invitations-error-alreadyinvited' => 'O utilizador que especificou já tem acesso a esta funcionalidade!',
	'invitations-invite-success' => 'Convidou $1 para usar esta funcionalidade com sucesso!',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'invite-logpage' => 'Registro de Convites',
	'invite-logpagetext' => 'Isto é um registro de utilizadores que se convidam uns aos outros para usar as várias funcionalidades do software.',
	'invite-logentry' => 'convidou $1 a usar a funcionalidade <i>$2</i>.',
	'invitations' => 'Gerenciar convites para funcionalidades de software',
	'invitations-desc' => 'Permite [[Special:Invitations|o gerenciamento de novas funcionalidades]] através da sua restrição a um sistema baseado em convites',
	'invitations-invitedlist-description' => 'Você tem acesso às seguintes funcionalidades do software atribuídas apenas por convite. Para gerenciar convites para uma funcionalidade individual, clique no seu nome.',
	'invitations-invitedlist-none' => 'Você não foi convidado a usar nenhuma funcionalidade do software atribuída apenas por convite.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Um convite disponível|$1 convites disponíveis}})',
	'invitations-pagetitle' => 'Funcionalidades do software atribuídas apenas por convite',
	'invitations-uninvitedlist-description' => 'Você não tem acesso a estas outras funcionalidades do software atribuídas apenas por convite.',
	'invitations-uninvitedlist-none' => 'Neste momento, nenhuma outra funcionalidade do software é atribuída apenas por convite.',
	'invitations-feature-pagetitle' => 'Gerenciamento de Convites - $1',
	'invitations-feature-access' => 'Atualmente você não possui acesso ao uso de <i>$1</i>.',
	'invitations-feature-numleft' => 'Ainda lhe {{PLURAL:$2|resta um|restam <b>$1</b>}} dos seus $2 convites.',
	'invitations-feature-noneleft' => 'Você já utilizou toda a sua quota de convites para esta funcionalidade',
	'invitations-feature-noneyet' => 'Você ainda não recebeu a sua quota de convites para esta funcionalidade.',
	'invitations-feature-notallowed' => 'Você não tem acesso ao uso de <i>$1</i>.',
	'invitations-inviteform-title' => 'Convidar um utilizador a usar $1',
	'invitations-inviteform-username' => 'Utilizador a convidar',
	'invitations-inviteform-submit' => 'Convidar',
	'invitations-error-baduser' => 'O utilizador que especificou parece não existir.',
	'invitations-error-alreadyinvited' => 'O utilizador que especificou já tem acesso a esta funcionalidade!',
	'invitations-invite-success' => 'Convidou $1 para usar esta funcionalidade com sucesso!',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'invite-logentry' => "qayakun $1 sutiyuqta <i>$2</i> nisqata llamk'achinanpaq.",
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|O invitaţie disponibilă|$1 invitaţii disponibile}})',
	'invitations-inviteform-submit' => 'Invitaţi',
	'invitations-error-baduser' => 'Utilizatorul specificat pare să nu existe.',
	'invitations-error-alreadyinvited' => 'Utilizatorul specificat are deja acces la această funcţionalitate!',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'invite-logpage' => 'Archivije de le invite',
	'invitations-inviteform-username' => 'Utende da invità',
	'invitations-inviteform-submit' => 'Invite',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'invite-logpage' => 'Журнал приглашений',
	'invite-logpagetext' => 'Это журнал приглашений использовать возможности программного обеспечения',
	'invite-logentry' => 'пригласил $1 использовать возможность <i>$2</i>',
	'invitations' => 'Управление приглашениями на возможности ПО',
	'invitations-desc' => 'Позволяет [[Special:Invitations|управлять новыми возможностями]], ограничивая к ним доступ с помощью системы приглашений',
	'invitations-invitedlist-description' => 'Вы имеете доступ к следующим возможностям программного обеспечения, доступным только по приглашениям. Чтобы управлять приглашениями каждой возможности ПО, щёлкните по её имени.',
	'invitations-invitedlist-none' => 'Вы не были приглашены использовать какую-либо возможность программы, из доступных только по приглашениям.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Доступно $1 приглашение|Доступно $1 приглашения|Доступно $1 приглашений}})',
	'invitations-pagetitle' => 'Возможность ПО только по приглашению',
	'invitations-uninvitedlist-description' => 'У вас нет доступа к другим возможностям ПО, доступным только по приглашениям.',
	'invitations-uninvitedlist-none' => 'В настоящее время нет других возможностей ПО, доступных только по приглашениям.',
	'invitations-feature-pagetitle' => 'Управление приглашениями — $1',
	'invitations-feature-access' => 'Сейчас вы имеете доступ к использованию <i>$1</i>.',
	'invitations-feature-numleft' => 'У вас остаётся {{PLURAL:$2|ещё одно приглашение|<b>$1</b> из $2 приглашений}}.',
	'invitations-feature-noneleft' => 'Вы использовали все выделенные вам приглашения для этой возможности',
	'invitations-feature-noneyet' => 'Вам ещё не было выделено приглашений для рассылки для этой возможности',
	'invitations-feature-notallowed' => 'У вас нет доступа к использованию <i>$1</i>.',
	'invitations-inviteform-title' => 'Приглашение участника использовать $1',
	'invitations-inviteform-username' => 'Участник',
	'invitations-inviteform-submit' => 'Пригласить',
	'invitations-error-baduser' => 'Участника, которого вы указали, по-видимому не существует.',
	'invitations-error-alreadyinvited' => 'Участник, которого вы указали, уже имеет доступ к этой возможности!',
	'invitations-invite-success' => 'Вы успешно пригласили участника $1 использовать эту возможность!',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'invite-logpage' => 'Záznam pozvánok',
	'invite-logpagetext' => 'Toto je záznam používateľov pozývajúcich sa navzájom používať rozličné možnosti softvéru.',
	'invite-logentry' => 'pozval $1 používať možnosť <i>$2</i>.',
	'invitations' => 'Spravovať pozvánky možností softvéru',
	'invitations-desc' => 'Umožňuje [[Special:Invitations|správu nových možností]] obmedzením prístupu k nim na báze pozvánok',
	'invitations-invitedlist-description' => 'Máte prístup k nasledovným možnostiam softvéru, ktoré sú prístupné iba na báze pozvánok. Spravovať pozvánky jednotlivých možností môžete po kliknutí na jej názov.',
	'invitations-invitedlist-none' => 'Neboli ste pozvaný používať žiadnu z možností softvéru s prístupom len na pozvanie.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Dostupná jedna pozvánka|Dostupné $1 pozvánky|Dostupných $1 pozvánok}})',
	'invitations-pagetitle' => 'Možnosti softvéru s prístupom len na pozvanie.',
	'invitations-uninvitedlist-description' => 'Nemáte prístup k týmto ostatným možnostiam softvéru s prístupom len na pozvanie.',
	'invitations-uninvitedlist-none' => 'Momentálne nie je prístup k žiadnym iným možnostiam softvéru určený len na pozvanie.',
	'invitations-feature-pagetitle' => 'Správa pozvánok - $1',
	'invitations-feature-access' => 'Momentálne máte prístup na používanie <i>$1</i>.',
	'invitations-feature-numleft' => '{{PLURAL:$1|Zostáva vám <b>$1 pozvánka</b>|Zostávajú vám <b>$1 pozvánky</b>|Zostáva vám <b>$1 pozvánok</b>}} z {{PLURAL:$2|vašej $2 pozvánky|vašich $2 pozvánok}}.',
	'invitations-feature-noneleft' => 'Využili ste všetky z vašich vyhradených pozvánok na prístup k tejto možnosti',
	'invitations-feature-noneyet' => 'Zatiaľ ste nedostali svoj podiel pozvánok na prístup k tejto možnosti.',
	'invitations-feature-notallowed' => 'Nemáte právo na prístup k <i>$1</i>.',
	'invitations-inviteform-title' => 'Pozvať používateľa na používanie $1',
	'invitations-inviteform-username' => 'Pozvať používateľa',
	'invitations-inviteform-submit' => 'Pozvať',
	'invitations-error-baduser' => 'Zdá sa, že používateľ, ktorého ste uviedli neexistuje.',
	'invitations-error-alreadyinvited' => 'Používateľ, ktorého ste uviedli, už má prístup k tejto možnosti.',
	'invitations-invite-success' => 'Úspešne ste pozvali používateľa $1 využívať túto možnosť!',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'invite-logpage' => 'Ienleedengs-Logbouk',
	'invite-logpagetext' => 'Dit is dät Logbouk fon do ienleedengsbasierde Softwarefunktione.',
	'invite-logentry' => 'häd $1 ienleeden, uum do Softwarefunktione <i>$2</i> tou bruuken.',
	'invitations-desc' => 'Moaket ju [[Special:Invitations|Ferwaltenge fon Softwarefunktione]] ap Gruund fon Ienleedengen muugelk',
	'invitations-invitedlist-description' => 'Du hääst Tougoang tou do foulgjende ienleedengsbasierde Softwarefunktione. Uum Ienleedengen foar ne bestimde Softwarefunktion tou ferwaltjen, klik ap hieren Noome.',
	'invitations-invitedlist-none' => 'Du hääst tou nu tou neen Ienleedengen foar dät Bruuken fon ienleedengsbasierde Softwarefunktione kriegen.',
	'invitations-pagetitle' => 'Softwarefunktione ap Ienleedengs-Basis',
	'invitations-uninvitedlist-description' => 'Du hääst naan Tougoang tou uur ienleedengsbasierde Softwarefunktione',
	'invitations-uninvitedlist-none' => 'Apstuuns sunt neen wiedere Softwarefunktione ienleedengsbasierd',
	'invitations-feature-pagetitle' => 'Ienleedengsferwaltenge - $1',
	'invitations-feature-access' => 'Du hääst Tougoang toun Gebruuk fon <i>$1</i>.',
	'invitations-feature-numleft' => 'Die {{PLURAL:$2|stoant noch een Ienleedenge|stounde noch <b>$1</b> fon mädnunner $2 Ienleedengen}}  tou Ferföigenge.',
	'invitations-feature-noneleft' => 'Du hääst aal die touwiesde Ienleedengen foar disse Softwarefunktion ferbruukt.',
	'invitations-feature-noneyet' => 'Die wuuden noch neen Ienleedengen foar disse Softwarefunktion touwiesd.',
	'invitations-feature-notallowed' => 'Du hääst neen Begjuchtigenge, uum <i>$1</i> tou bruuken.',
	'invitations-inviteform-title' => 'Leede n Benutser tou ju Funktion $1 ien',
	'invitations-inviteform-username' => 'Ientouleedenden Benutser',
	'invitations-inviteform-submit' => 'Ienleede',
	'invitations-error-baduser' => 'Dät lät, as wan die anroate Benutser nit bestoant.',
	'invitations-error-alreadyinvited' => 'Die anroate Benutser häd al Tougoang tou disse Softwarefunktion!',
	'invitations-invite-success' => 'Du hääst mäd Ärfoulch $1 tou disse Softwarefunktion ienleeden!',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'invite-logpage' => 'Invitationslogg',
	'invite-logpagetext' => 'Detta är en logg över vilka användare som har inviterat varandra till att använda diverse mjukvarefunktioner.',
	'invite-logentry' => 'inviterade $1 till att använda funktionen <i>$2</i>',
	'invitations' => 'Behandling av inbjudningar till programvarefunktioner',
	'invitations-desc' => 'Gör det möjligt att [[Special:Invitations|kontrollera nya funktioner]] genom att begränsa dem med ett inbjudningsbaserat system',
	'invitations-invitedlist-description' => 'Du har tillgång till följande funktioner som kräver en inbjudan. Klicka på funktionens namn för att behandla inbjudningar för dom enkla funktionerna.',
	'invitations-invitedlist-none' => 'Du har inte blivit inbjuden att använda några funktioner som kräver inbjudan.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|En inbjudning är tillgänglig|$1 inbjudningar är tillgängliga}})',
	'invitations-pagetitle' => 'Funktioner som kräver inbjudning',
	'invitations-uninvitedlist-description' => 'Du har inte tillgång till dessa funktioner som kräver inbjudan.',
	'invitations-uninvitedlist-none' => 'Inga programvarefunktioner kräver inbjudan.',
	'invitations-feature-pagetitle' => 'Inbjudningsbehandling - $1',
	'invitations-feature-access' => 'Du har tillgång att använda <i>$1</i>.',
	'invitations-feature-numleft' => 'Du har fortfarande {{PLURAL:$2|en inbjudning kvar|<b>$1</b> av dina $2 inbjudningar kvar}}.',
	'invitations-feature-noneleft' => 'Du har använt alla dina inbjudningar för den här funktionen',
	'invitations-feature-noneyet' => 'Du har inte tilldelats din andel inbjudningar för den här funktionen.',
	'invitations-feature-notallowed' => 'Du har inte tillgång att använda <i>$1</i>.',
	'invitations-inviteform-title' => 'Bjuder in en användare att använda $1',
	'invitations-inviteform-username' => 'Användare som ska bjudas in',
	'invitations-inviteform-submit' => 'Bjud in',
	'invitations-error-baduser' => 'Användaren du angav finns inte.',
	'invitations-error-alreadyinvited' => 'Användare du angav har redan tillgång till den här funktionen!',
	'invitations-invite-success' => 'Du har bjudit in $1 att använda den här funktionen!',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'invite-logpage' => 'ఆహ్వానాల చిట్టా',
	'invite-logentry' => '<i>$2</i> అనే విశేషాన్ని వాడడానికి $1ని ఆహ్వానించారు.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|ఒక ఆహ్వానం|$1 ఆహ్వానాలు}} ఉన్నాయి)',
	'invitations-feature-pagetitle' => 'ఆహ్వాన నిర్వహణ - $1',
	'invitations-feature-access' => '<i>$1</i>ని వాడడానికి ప్రస్తుతం మీకు అనుమతి ఉంది.',
	'invitations-feature-numleft' => 'మీ దగ్గర  ఇంకా  {{PLURAL:$2|ఒక ఆహ్వానము ఉంది|$2 ఆహ్వనాలలో<b>$1</b> మిగిలివున్నాయి}}.',
	'invitations-inviteform-title' => '$1ని వాడడానికి ఓ వాడుకరిని ఆహ్వానించండి',
	'invitations-inviteform-username' => 'ఆహ్వానించాల్సిన వాడుకరి',
	'invitations-inviteform-submit' => 'ఆహ్వానించు',
	'invitations-error-baduser' => 'మీరు చెప్పిన ఆ వాడుకరి లేనేలేరు.',
	'invitations-error-alreadyinvited' => 'మీరు చెప్పిన ఆ వాడుకరికి ఈ విశేషాన్ని వాడుకునే అనుమతి ఈపాటికే ఉంది!',
	'invitations-invite-success' => 'ఈ విశేషాన్ని వాడుకోమని $1ని మీరు విజయవంతంగా ఆహ్వానించారు!',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'invitations-inviteform-username' => 'Корбар барои таклиф',
	'invitations-inviteform-submit' => 'Таклиф',
	'invitations-error-baduser' => 'Корбари шумо мушаххас карда ба назар мерасад, ки вуҷуд надорад',
	'invitations-error-alreadyinvited' => 'Корбари шумо мушаххас карда аллакай ба ин хусусият дастрасӣ дорад!',
	'invitations-invite-success' => 'Барои истифодаи ин хусусия шумо $1-ро бо муваффақият таклиф кардед',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'invitations-inviteform-username' => 'Korbar baroi taklif',
	'invitations-inviteform-submit' => 'Taklif',
	'invitations-error-baduser' => 'Korbari şumo muşaxxas karda ba nazar merasad, ki vuçud nadorad',
	'invitations-error-alreadyinvited' => 'Korbari şumo muşaxxas karda allakaj ba in xususijat dastrasī dorad!',
	'invitations-invite-success' => 'Baroi istifodai in xususija şumo $1-ro bo muvaffaqijat taklif karded',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'invite-logpage' => 'Tala ng paanyaya',
	'invite-logpagetext' => 'Isa itong talaan ng mga tagagamit na nag-aanyaya sa bawat isa upang gamitin ang sari-saring mga kasangkapang-katangian ng sopwer.',
	'invite-logentry' => 'inanyayahan si $1 na gamitin ang kasangkapang-katangiang <i>$2</i>.',
	'invitations' => 'Pamahalaan ang mga paanyaya patungo sa mga kasangkapang-katangian ng sopwer',
	'invitations-desc' => 'Nagpapahintulot ng [[Special:Invitations|pamamahala ng bagong mga kasangkapang-katangian]]  sa pamamagitan ng paghangga sa kanila patungo sa isang sistemang nakabatay sa paanyaya',
	'invitations-invitedlist-description' => 'Maaari kang pumunta sa sumusunod na mga kasangkapang-katangiang ng sopwer na pang-inanyayahan  lamang.
Para mapamahalaan ang mga paanyaya para sa isang partikular na kasangkapang-katangian, pindutin ang pangalan nito.',
	'invitations-invitedlist-none' => 'Hindi ka inanyayahanang makagamit ng anumang mga kasangkapang-katangian ng sopwer na pang-inanyayahan lamang.',
	'invitations-invitedlist-item-count' => '({{PLURAL:$1|Isang paanyaya|$1 mga paanyaya}}ng makukuha)',
	'invitations-pagetitle' => 'Mga kasangkapang-katangian ng sopwer na pang-inanyayahan lamang',
	'invitations-uninvitedlist-description' => 'Hindi ka maaaring pumunta sa iba pang ganitong mga kasangkapang-katangian ng sopwer na pang-inanyayahan lamang.',
	'invitations-uninvitedlist-none' => 'Sa kasalukuyang panahon, walang mga kasangkapang-katangiang itinalaga bilang mga pang-inanyayahan lamang.',
	'invitations-feature-pagetitle' => 'Pamamahala ng paanyaya - $1',
	'invitations-feature-access' => 'Kasalukuyang makakapunta ka para gamitin ang <i>$1</i>.',
	'invitations-feature-numleft' => 'Mayroon ka pang {{PLURAL:$2|isang natitirang paanyaya|<b>$1</b> mula sa nalalabi mong $2 mga paanyaya}}',
	'invitations-feature-noneleft' => 'Nagamit mo na ang lahat ng inilaan mong mga paanyaya para sa kasangkapang-katangiang ito',
	'invitations-feature-noneyet' => 'Hindi mo pa natatanggap ang inilaang mga paanyaya mo na para sa ganitong kasangkapang-katangian.',
	'invitations-feature-notallowed' => 'Hindi ka makakapunta para gamitin ang <i>$1</i>.',
	'invitations-inviteform-title' => 'Anyayahan ang isang tagagamit na gamitin ang $1',
	'invitations-inviteform-username' => 'Aanyayahang tagagamit',
	'invitations-inviteform-submit' => 'Anyayahan',
	'invitations-error-baduser' => 'Tila hindi pa umiiral ang tinukoy mong tagagamit.',
	'invitations-error-alreadyinvited' => 'Ang tinukoy mong tagagamit ay nakakapunta na sa ganitong kasangkapang-katangian!',
	'invitations-invite-success' => 'Matagumpay mong naanyayahan si $1 upang magamit ang kasangkapang-katangiang ito!',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'invite-logpage' => 'Davet kaydı',
	'invitations' => 'Yazılım özelliklerine daveti yönet',
	'invitations-pagetitle' => 'Sadece davete dayanan yazılım özellikleri',
	'invitations-feature-pagetitle' => 'Davet yönetimi - $1',
	'invitations-inviteform-username' => 'Davet edilecek kullanıcı',
	'invitations-inviteform-submit' => 'Davet et',
	'invitations-error-baduser' => 'Belirttiğiniz kullanıcı görünüşe göre mevcut değil.',
	'invitations-error-alreadyinvited' => 'Belirttiğiniz kullanıcı zaten bu özelliğe erişime sahip!',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'invitations-desc' => 'Дозволяє [[Special:Invitations|управління новими функціями]], обмежуючи доступ до них за допомогою системи запрошень',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'invitations-inviteform-submit' => 'Kucta',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'invite-logpage' => 'Nhật trình thư mời',
	'invite-logpagetext' => 'Đây là nhật trình ghi lại những lời mời từ người dùng này tới người dùng khác để sử dụng những tính năng phần mềm khác nhau.',
	'invite-logentry' => 'đã mời $1 dùng tính năng <i>$2</i>.',
	'invitations' => 'Quản lý thư mời đối với các tính năng phần mềm',
	'invitations-desc' => 'Cho phép [[Special:Invitations|quản lý các tính năng mới]] bằng cách hạn chế họ dựa vào hệ thống thư mời',
	'invitations-invitedlist-description' => 'Bạn đã truy cập vào các tính năng phần mềm chỉ cho phép thư mời sau đây. Để quản lú các thư mời cho một tính năng riêng lẻ, hãy nhấn vào tên của nó.',
	'invitations-invitedlist-none' => 'Bạn chưa được mời sử dụng tính năng phần mềm chỉ dành cho thư mời nào.',
	'invitations-invitedlist-item-count' => '(Hiện có {{PLURAL:$1|một lời mời|$1 lời mời}})',
	'invitations-pagetitle' => 'Các tính năng phần mềm chỉ cho phép thư mời',
	'invitations-uninvitedlist-description' => 'Bạn không có quyền truy cập vào những tính năng phần mềm chỉ cho phép thư mời sau.',
	'invitations-uninvitedlist-none' => 'Vào lúc này, không có tính năng phần mềm nào khác được chỉ định chỉ cho phép thư mời.',
	'invitations-feature-pagetitle' => 'Quản lý Thư mời - $1',
	'invitations-feature-access' => 'Bạn hiện có quyền sử dụng <i>$1</i>.',
	'invitations-feature-numleft' => 'Bạn vẫn còn lại <b>$1</b>{{PLURAL:$2|| trong tổng số $2}} lời mời.',
	'invitations-feature-noneleft' => 'Bạn đã dùng tất cả các lời mời cho phép dành cho tính năng này',
	'invitations-feature-noneyet' => 'Bạn chưa nhận được lượng thư mời cung cấp dành cho tính năng này.',
	'invitations-feature-notallowed' => 'Bạn không có quyền sử dụng <i>$1</i>.',
	'invitations-inviteform-title' => 'Mời một thành viên sử dụng $1',
	'invitations-inviteform-username' => 'Thành viên được mời',
	'invitations-inviteform-submit' => 'Mời',
	'invitations-error-baduser' => 'Thành viên bạn chỉ định dường như không tồn tại.',
	'invitations-error-alreadyinvited' => 'Thành viên bạn chỉ định đã có quyền sử dụng tính năng này rồi!',
	'invitations-invite-success' => 'Bạn đã mời $1 sử dụng tính năng này!',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'invite-logpage' => '邀请记录',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'invite-logpage' => '邀請記錄',
);

