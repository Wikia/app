<?php
/**
 * Internationalisation for PrivatePageProtection extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Daniel Kinzler
 */
$messages['en'] = array(
	'privatepp-desc' => 'Allows restricting page access based on user group',
	
	'privatepp-lockout-prevented' => 'Lockout prevented: You have tried to restrict access to this page to {{PLURAL:$2|the group|one of the groups}} $1. 
Since you are not a member of {{PLURAL:$2|this group|any of these groups}}, you would not be able to access the page after saving it. 
Saving was aborted to avoid this.',
);

/** Message documentation (Message documentation)
 * @author Daniel Kinzler
 */
$messages['qqq'] = array(
	'privatepp-desc' => '{{desc}}',
);

/** German (Deutsch)
 * @author Daniel Kinzler
 * @author Kghbln
 */
$messages['de'] = array(
	'privatepp-desc' => 'Ermöglicht das Beschränken das Zugangs zu Wikiseiten auf Basis von Benutzergruppen',
	'privatepp-lockout-prevented' => 'Die Aussperrung wurde verhindert: Du hast versucht, den Zugang zu dieser Seite auf {{PLURAL:$2|die Benutzergruppe|die Benutzergruppen}} $1 zu beschränken. 
Da du kein Mitglied {{PLURAL:$2|dieser Benutzergruppe|einer dieser Benutzergruppen}} bist, könntest du nach dem Speichern nicht mehr auf die Seite zugreifen. 
Um dies zu vermeiden, wurde das Speichern abgebrochen.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Daniel Kinzler
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'privatepp-lockout-prevented' => 'Die Aussperrung wurde verhindert: Sie haben versucht, den Zugang zu dieser Seite auf {{PLURAL:$2|die Benutzergruppe|die Benutzergruppen}} $1 zu beschränken. 
Da Sie kein Mitglied {{PLURAL:$2|dieser Benutzergruppe|einer dieser Benutzergruppen}} sind, könnten Sie nach dem Speichern nicht mehr auf die Seite zugreifen. 
Um dies zu vermeiden, wurde das Speichern abgebrochen.',
);

/** French (Français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'privatepp-desc' => "Permet de restreindre l'accès à la page à un groupe d'utilisateurs",
	'privatepp-lockout-prevented' => "Verrouillage empêché: Vous avez essayé de limiter l'accès à cette page {{PLURAL:$2|au groupe|un des groupes}} $1 .
Comme vous n'êtes pas membre de {{PLURAL:$2|ce groupe|un de ces groupes}}, vous ne seriez plus en mesure d'accéder à la page après l'avoir enregistrée.
L'enregistrement a été annulé pour éviter cela.",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'privatepp-desc' => 'Permite restrinxir o acceso ás páxinas segundo o grupo ao que pertenza o usuario',
	'privatepp-lockout-prevented' => 'Bloqueo preventivo: Intentou restrinxir o acceso a esta páxina aos membros {{PLURAL:$2|do grupo|dos grupos}} $1.
Dado que non pertence a {{PLURAL:$2|este grupo|ningún destes grupos}}, non poderá acceder á páxina despois de gardar.
Cancelouse o gardado para evitar isto.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'privatepp-desc' => 'Zmóžnja wobmjezowanje přistupa na strony na zakładźe wužiwarskeje skupiny',
	'privatepp-lockout-prevented' => 'Wuzamknjenje je so zadźěwało: Sy spytał přistup k tutej stronje na {{PLURAL:$2|skupinsku skupinu|jednu ze skupinow}} $1 wobmjezować. Dokelž čłon {{PLURAL:$2|tuteje skupiny|jedneje z tutych skupinow}} njejsy, njeby po składowanju žadyn přistup na stronu měł.
Składowanje je so přetorhnyło, zo by to wobešło.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'privatepp-desc' => 'Permitte restringer le accesso a paginas secundo le gruppo del usator',
	'privatepp-lockout-prevented' => 'Exclusion prevenite: Tu ha tentate limitar le accesso a iste pagina {{PLURAL:$2|al gruppo|a un del gruppos}} $1. 
Post que tu non es membro de {{PLURAL:$2|iste gruppo|alcun de iste gruppos}}, tu non poterea acceder al pagina post salveguardar lo. 
Le salveguarda ha essite abortate pro evitar isto.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'privatepp-desc' => 'Erlaabt et den Accès op Säiten, op Basis vun de Benotzergruppen, ze limitéiern',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'privatepp-desc' => 'Овозможува ограничување на пристапот до страници во зависност од корисничката група',
	'privatepp-lockout-prevented' => 'Ограничувањето на пристапот е спречено: Се обидовте страницата да ја направите пристапна само за членови на {{PLURAL:$2|групата|една од групите}} $1. 
Бидејќи не членувате во {{PLURAL:$2|групата|ниедна од нив}}, самите вие нема да можете да пристапите на неа откако ќе ја зачувате. 
За да се избегне ова, зачувувањето е откажано.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 */
$messages['nl'] = array(
	'privatepp-desc' => 'Laat toe paginatoegang te beperken volgens gebruikersgroep',
);

