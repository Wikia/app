<?php
/**
 * Internationalization file for EditAccount extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 */
$messages['en'] = array(
	'editaccount' => 'Edit Account',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Edit an acccount',
	'editaccount-frame-usage' => 'Note',
	'editaccount-usage' => "User data is cached separately for each wiki. When you reset a password or e-mail, cache will be busted for this wiki only. Please direct the user to this wiki to log in with a newly set password to avoid cache issues.",
	'editaccount-label-select' => 'Select a user account',
	'editaccount-submit-account' => 'Manage Account',
	'editaccount-frame-account' => 'Editing user account: $1',
	'editaccount-frame-close' => 'Disable user account: $1',
	'editaccount-label-email' => 'Set new e-mail address',
	'editaccount-label-pass' => 'Set new password',
	'editaccount-label-realname' => 'Set new real name',
	'editaccount-submit-email' => 'Save E-Mail',
	'editaccount-submit-pass' => 'Save Password',
	'editaccount-submit-realname' => 'Save Real Name',
	'editaccount-submit-close' => 'Close Account',
	'editaccount-usage-close' => 'You can also disable a user account by scrambling its password and removing the e-mail address. Note that this data is lost and will not be recoverable.',
	'editaccount-warning-close' => '<b>Caution!</b> You are about to permanently disable the account of user <b>$1</b>. This cannot be reverted. Are you sure that is what you want to do?',
	'editaccount-status' => 'Status message',
	'editaccount-success-email' => 'Successfully changed e-mail for account $1 to $2.',
	'editaccount-success-pass' => 'Successfully changed password for account $1.',
	'editaccount-success-realname' => 'Successfully changed real name for account $1.',
	'editaccount-success-close' => 'Successfully disabled account $1.',
	'editaccount-error-email' => 'E-mail was not changed. Try again or contact the Tech Team.',
	'editaccount-error-pass' => 'Password was not changed. Try again or contact the Tech Team.',
	'editaccount-error-realname' => 'Real name was not changed. Try again or contact the Tech Team.',
	'editaccount-error-close' => 'A problem occured when closing account. Try again or contact the Tech Team.',
	'editaccount-invalid-email' => '"$1" is not a valid e-mail address!',
	'editaccount-nouser' => 'Account "$1" does not exist!',
	# logging
	'editaccount-log' => 'User accounts log',
	'editaccount-log-header' => 'This page lists changes made to user preferences by Wikia Staff.',
	'editaccount-log-entry-email' => 'changed e-mail for user $2',
	'editaccount-log-entry-pass' => 'changed password for user $2',
	'editaccount-log-entry-realname' => 'changed real name for user $2',
	'editaccount-log-entry-close' => 'disabled account $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">This account has been disabled.</div>',
	// For Special:ListGroupRights
	'right-editaccount' => "Edit other users' preferences",
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'editaccount' => 'Wysig gebruiker',
	'editaccount-frame-manage' => "Wysig 'n rekening",
	'editaccount-frame-usage' => 'Let op',
	'editaccount-label-select' => "Kies 'n gebruiker",
	'editaccount-submit-account' => 'Bestuur gebruiker',
	'editaccount-label-email' => 'Stel nuwe e-posadres',
	'editaccount-label-pass' => 'Stel nuwe wagwoord',
	'editaccount-label-realname' => 'Stel nuwe regte naam',
	'editaccount-submit-email' => 'Stoor E-pos',
	'editaccount-submit-pass' => 'Stoor wagwoord',
	'editaccount-submit-realname' => 'Stoor regte naam',
	'editaccount-submit-close' => 'Sluit rekening',
	'editaccount-invalid-email' => '"$1" is nie \'n geldige e-posadres nie!',
);


$messages['de'] = array(
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Dieses Benutzerkonto wurde deaktiviert.</div>',
);


$messages['es'] = array(
	'right-editaccount' => 'Editar las preferencias de otros usuarios',
);


$messages['fa'] = array(
	'editaccount-submit-close' => 'بستن حساب کاربری',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'editaccount' => 'Muokkaa käyttäjätunnuksia',
	'editaccount-frame-manage' => 'Muokkaa käyttäjätunnusta',
	'editaccount-frame-usage' => 'Huomioi',
	'editaccount-usage' => 'Käyttäjäkohtaisen tiedot ovat talletettuna välimuistiin erikseen jokaista wikiä kohden. Kun asetat uuden salasanan tai sähköpostiosoitteen, välimuistiin tallennetut tiedot poistetaan vain tämän wikin kohdalla. Ohjaa käyttäjä kirjautumaan sisään tätä wikiä käyttäen välttääksesi ongelmia välimuistin kanssa.',
	'editaccount-label-select' => 'Valitse käyttäjätunnus',
	'editaccount-submit-account' => 'Hallinnoi tunnusta',
	'editaccount-frame-account' => 'Muokataan käyttäjätunnusta: $1',
	'editaccount-frame-close' => 'Poista käytöstä käyttäjätunnus: $1',
	'editaccount-label-email' => 'Aseta uusi sähköpostiosoite',
	'editaccount-label-pass' => 'Aseta uusi salasana',
	'editaccount-submit-email' => 'Tallenna sähköpostiosoite',
	'editaccount-submit-pass' => 'Tallenna salasana',
	'editaccount-submit-close' => 'Sulje tunnus',
	'editaccount-usage-close' => 'Käyttäjätunnuksen voi poistaa käytöstä myös sekoittamalla sen salasanan ja poistamalla sen sähköpostiosoitteen. Huomioi, että nämä tiedot katoavat eikä niitä voi palauttaa.',
	'editaccount-status' => 'Tilaviesti',
	'editaccount-success-email' => 'Tunnuksen $1 sähköpostiosoite vaihdettiin onnistuneesti osoitteeseen $2.',
	'editaccount-success-pass' => 'Tunnuksen $1 salasana vaihdettiin onnistuneesti.',
	'editaccount-success-close' => 'Tunnus $1 poistettiin käytöstä onnistuneesti.',
	'editaccount-error-email' => 'Sähköpostiosoitetta ei vaihdettu. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-error-pass' => 'Salasanaa ei vaihdettu. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-error-close' => 'Tunnusta suljettaessa tapahtui virhe. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-invalid-email' => '"$1" ei ole kelvollinen sähköpostiosoite!',
	'editaccount-nouser' => 'Tunnusta nimeltä "$1" ei ole olemassa!',
	'editaccount-log' => 'Käyttäjätunnusloki',
	'editaccount-log-header' => 'Tämä sivu listaa Wikian henkilökunnan käyttäjäkohtaisiin asetuksiin tekemät muutokset.',
	'editaccount-log-entry-email' => 'muutti käyttäjän $2 sähköpostiosoitetta',
	'editaccount-log-entry-pass' => 'muutti käyttäjän $2 salasanaa',
	'editaccount-log-entry-close' => 'poisti käytöstä tunnuksen $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Tämä tunnus on poistettu käytöstä.</div>',
	'right-editaccount' => 'Muokata toisten käyttäjien asetuksia',
);

/** French (Français)
 * @author IAlex
 * @author Peter17
 */
$messages['fr'] = array(
	'editaccount' => 'Modifier le compte',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Modifier un compte',
	'editaccount-frame-usage' => 'Avis',
	'editaccount-usage' => "Les données des utilisateurs sont cachées séparément pour chaque wiki. Si vous réinitialisez le mot de passe ou l'adresse de courriel, le cache ne sera annulé que pour ce wiki. Veuillez rediriger l'utilisateur vers ce wiki pour qu'il se connecte avec son nouveau mot de passe pour éviter les problèmes de cache.",
	'editaccount-label-select' => 'Sélectionner un compte utilisateur',
	'editaccount-submit-account' => 'Gérer le compte',
	'editaccount-frame-account' => 'Modification du compte utilisateur : $1',
	'editaccount-frame-close' => 'Désactiver le compte utilisateur : $1',
	'editaccount-label-email' => 'Définir une nouvelle adresse de courriel',
	'editaccount-label-pass' => 'Définir un nouveau mot de passe',
	'editaccount-label-realname' => 'Définir un nouveau nom complet',
	'editaccount-submit-email' => "Sauvegarder l'adresse de courriel",
	'editaccount-submit-pass' => 'Sauvegarder le mot de passe',
	'editaccount-submit-realname' => 'Sauvegarder le nom complet',
	'editaccount-submit-close' => 'Clore le compte',
	'editaccount-usage-close' => 'Vous pouvez également désactiver un compte utilisateur en cryptant son mot de passe et en supprimant son adresse de courriel. Veuillez notez que les données seront perdues et ne seront pas récupérables.',
	'editaccount-warning-close' => '<b>Attention !</b> Vous êtes sur le point de désactiver le compte utilisateur <b>$1</b> de manière permanente. Ceci ne peut pas être défait. Êtes-vous certain de vouloir effectuer cette opération ?',
	'editaccount-status' => 'Message de statut',
	'editaccount-success-email' => "L'adresse de courriel du compte $1 a été modifiée avec succès à $2.",
	'editaccount-success-pass' => 'Le mot de passe du compte $1 a été modifié avec succès.',
	'editaccount-success-realname' => 'Le nom complet du compte $1 a été modifié avec succès.',
	'editaccount-success-close' => 'Le compte $1 a été désactivé avec succès.',
	'editaccount-error-email' => "L'adresse de courriel n'a pas été modifiée. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-pass' => "Le mot de passe n'a pas été modifié. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-realname' => "Le nom complet n'a pas été modifié. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-close' => "Un problème est survenu lors de la fermeture du compte. Veuillez ré-essayer ou contacter l'équipe technique.",
	'editaccount-invalid-email' => "« $1 » n'est pas une adresse de courriel valide !",
	'editaccount-nouser' => "Le compte « $1 » n'existe pas !",
	'editaccount-log' => 'Journal des comptes utilisateurs',
	'editaccount-log-header' => 'Cette page liste les modifications faîtes au préférences utilisateur par le staff de Wikia.',
	'editaccount-log-entry-email' => "a modifié l'adresse de courriel de l'utilisateur $2",
	'editaccount-log-entry-pass' => 'a modifié le mot de passe du compte $2',
	'editaccount-log-entry-realname' => 'a modifié le nom complet du compte $2',
	'editaccount-log-entry-close' => 'a désactivé le compte $2§',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Ce compte a été désactivé.</div>',
	'right-editaccount' => "Modifier les préférences d'autres utilisateurs",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'editaccount' => 'Editar a conta',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Editar unha conta',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-usage' => 'Os datos de usuario gárdanse na memoria caché por separado para cada wiki. Cando restablece un contrasinal ou correo electrónico, a caché só se anulará para este wiki. Por favor, dirixa ao usuario ata este wiki para que acceda ao sistema co seu novo contrasinal para así evitar problemas de caché.',
	'editaccount-label-select' => 'Seleccionar unha conta de usuario',
	'editaccount-submit-account' => 'Xestionar a conta',
	'editaccount-frame-account' => 'Edición da conta de usuario: $1',
	'editaccount-frame-close' => 'Desactivar a conta de usuario: $1',
	'editaccount-label-email' => 'Establecer un novo enderezo de correo electrónico',
	'editaccount-label-pass' => 'Establecer un novo contrasinal',
	'editaccount-label-realname' => 'Establecer un novo nome real',
	'editaccount-submit-email' => 'Gardar o correo electrónico',
	'editaccount-submit-pass' => 'Gardar o contrasinal',
	'editaccount-submit-realname' => 'Gardar o nome real',
	'editaccount-submit-close' => 'Pechar a conta',
	'editaccount-usage-close' => 'Tamén pode desactivar unha conta de usuario codificando o seu contrasinal e eliminando o enderezo de correo electrónico. Teña en conta que se perderá esa información e non se poderá recuperar.',
	'editaccount-warning-close' => '<b>Coidado!</b> Está a piques de desactivar permanentemente a conta do usuario <b>$1</b>. Isto non se pode reverter. Está seguro de que é o que quere facer?',
	'editaccount-status' => 'Mensaxe de estado',
	'editaccount-success-email' => 'O correo electrónico da conta $1 cambiouse con éxito a $2.',
	'editaccount-success-pass' => 'Cambiouse con éxito o contrasinal da conta $1.',
	'editaccount-success-realname' => 'Cambiouse con éxito o nome real da conta $1.',
	'editaccount-success-close' => 'Desactivouse con éxito a conta $1.',
	'editaccount-error-email' => 'Non se modificou o correo electrónico. Inténteo de novo ou póñase en contacto co equipo técnico.',
	'editaccount-error-pass' => 'Non se modificou o contrasinal. Inténteo de novo ou póñase en contacto co equipo técnico.',
	'editaccount-error-realname' => 'Non se modificou o nome real. Inténteo de novo ou póñase en contacto co equipo técnico.',
	'editaccount-error-close' => 'Houbo un problema ao pechar a conta. Inténteo de novo ou póñase en contacto co equipo técnico.',
	'editaccount-invalid-email' => '"$1" non é un enderezo de correo electrónico válido!',
	'editaccount-nouser' => 'A conta "$1" non existe!',
	'editaccount-log' => 'Rexistro de contas de usuario',
	'editaccount-log-header' => 'Esta páxina lista as modificacións feitas ás preferencias do usuario polo persoal de Wikia.',
	'editaccount-log-entry-email' => 'cambiou o correo electrónico do usuario $2',
	'editaccount-log-entry-pass' => 'cambiou o contrasinal do usuario $2',
	'editaccount-log-entry-realname' => 'cambiou o nome real do usuario $2',
	'editaccount-log-entry-close' => 'desactivou a conta $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Esta conta foi desactivada.</div>',
	'right-editaccount' => 'Editar as preferencias doutros usuarios',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'editaccount-frame-usage' => 'Megjegyzés',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'editaccount' => 'Уреди сметка',
	'editaccount-title' => 'Специјални:УредиСметка',
	'editaccount-frame-manage' => 'Уреди сметка',
	'editaccount-frame-usage' => 'Напомена',
	'editaccount-usage' => 'Корисничките податоци се кешираат посебно за секое вики. Кога ќе смените лозинка или е-пошта, кешот ќе се поднови само за ова вики. Упатете го корисникот кон ова вики да се најави со новосоздадена лозинка, за да избегне проблеми со кеширање.',
	'editaccount-label-select' => 'Одберете корисничка сметка',
	'editaccount-submit-account' => 'Раководење со сметка',
	'editaccount-frame-account' => 'Уредување на корисничка сметка: $1',
	'editaccount-frame-close' => 'Оневозможи корисничка сметка: $1',
	'editaccount-label-email' => 'Нова е-поштенска адреса',
	'editaccount-label-pass' => 'Нова лозинка',
	'editaccount-label-realname' => 'Ново вистинско име',
	'editaccount-submit-email' => 'Зачувај е-пошта',
	'editaccount-submit-pass' => 'Зачувај лозинка',
	'editaccount-submit-realname' => 'Зачувај вистинско име',
	'editaccount-submit-close' => 'Затвори сметка',
	'editaccount-usage-close' => 'Можете да оневозможите корисничка сметка со тоа што ќе ја претворите лозинката во нечитлива и ќе ја отстраните е-поштенската адреса. Имајте на ум дека овие податоци ќе се изгубат и нема да можат да се вратат.',
	'editaccount-warning-close' => '<b>Внимание!</b> На пат сте засекогаш да ја оневозможите сметката на корисникот <b>$1</b>. Оваа постапка не може да се врати. Дали сте сигурни дека сакате да го направите ова?',
	'editaccount-status' => 'Статусна порака',
	'editaccount-success-email' => 'Е-поштата за сметката $1 е успешно променета на $2.',
	'editaccount-success-pass' => 'Лозинката за сметката $1 е успешно променета.',
	'editaccount-success-realname' => 'Вистинското име за сметката $1 е успешно променето.',
	'editaccount-success-close' => 'Сметката $1 е успешно оневозможена.',
	'editaccount-error-email' => 'Е-поштата не е променета. Обидете се повторно или контактирајте ја Екипата за техничка поддршка',
	'editaccount-error-pass' => 'Лозинката не е променета. Обидете се повторно или контактирајте ја Екипата за техничка поддршка.',
	'editaccount-error-realname' => 'Вистинското име не е променето. Обидете се повторно или контактирајте ја Екипата за техничка поддршка.',
	'editaccount-error-close' => 'Се појави проблем при затворањето на сметката. Обидете се повторно или контактирајте ја Екипата за техничка поддршка',
	'editaccount-invalid-email' => '„$1“ не е важечка е-поштенска адреса!',
	'editaccount-nouser' => 'Сметката „$1“ не поостои',
	'editaccount-log' => 'Дневник на кориснички сметки',
	'editaccount-log-header' => 'Оваа страница ги прикажува промените во нагодувањата на корисниците направени од персоналот на Викија',
	'editaccount-log-entry-email' => 'променета е-поштата на корисникот $2',
	'editaccount-log-entry-pass' => 'променета лозинката на корисникот $2',
	'editaccount-log-entry-realname' => 'променето вистинското име на корисникот $2',
	'editaccount-log-entry-close' => 'оневозможена сметка $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Оваа сметка е оневозможена.</div>',
	'right-editaccount' => 'Уредување на нагодувања на други корисници',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'editaccount' => 'Gebruiker bewerken',
	'editaccount-title' => 'Gebruiker bewerken',
	'editaccount-frame-manage' => 'Gebruiker bewerken',
	'editaccount-frame-usage' => 'Let op',
	'editaccount-usage' => 'Gebruikersgevens worden voor iedere wiki apart in een cache bijgehouden.
Als u een wachtwoord of e-mailadres opnieuw instelt, wordt alleen de cache voor deze wiki ongeldig gemaakt.
Laat de gebruiker bij deze wiki aanmelden met een nieuw wachtwoord om problemen met de cache te voorkomen.',
	'editaccount-label-select' => 'Selecteer een gebruiker',
	'editaccount-submit-account' => 'Gebruiker beheren',
	'editaccount-frame-account' => 'Te bewerken gebruiker: $1',
	'editaccount-frame-close' => 'Te sluiten gebruiker: $1',
	'editaccount-label-email' => 'Nieuwe e-mailadres instellen',
	'editaccount-label-pass' => 'Nieuw wachtwoord instellen',
	'editaccount-label-realname' => 'Nieuwe echte naam instellen',
	'editaccount-submit-email' => 'E-mailadres opslaan',
	'editaccount-submit-pass' => 'Wachtwoord opslaan',
	'editaccount-submit-realname' => 'Echte naam opslaan',
	'editaccount-submit-close' => 'Gebruiker afsluiten',
	'editaccount-usage-close' => 'U kunt een gebruiker ook uitschakelen door een onbekend wachtwoord in te stellen en het e-mailadres te verwijderen.
De huidige gegevens gaan dan verloren en zijn niet te herstellen.',
	'editaccount-warning-close' => '<b>Let op!</b>
U staat op het punt de gebruiker <b>$1</b> permanent af te sluiten.
Dit kan niet ongedaan gemaakt worden.
Weet u zeker dat u dit wilt doen?',
	'editaccount-status' => 'Statusbericht',
	'editaccount-success-email' => 'Het e-mailadres voor gebruiker $1 is gewijzigd naar $2.',
	'editaccount-success-pass' => 'Het wachtwoord voor gebruiker $1 is gewijzigd.',
	'editaccount-success-realname' => 'De echte naam voor gebruiker $1 is gewijzigd.',
	'editaccount-success-close' => 'De gebruiker $1 is uitgeschakeld.',
	'editaccount-error-email' => 'Het e-mailadres is niet gewijzigd.
Probeer het opnieuw of neem contact op het met Tech Team.',
	'editaccount-error-pass' => 'Het wachtwoord is niet gewijzigd.
Probeer het opnieuw of neem contact op met het Tech Team.',
	'editaccount-error-realname' => 'De echte naam is niet gewijzigd.
Probeer het opnieuw of neem contact op met het Tech Team.',
	'editaccount-error-close' => 'Er is een probleem ontstaan bij het afsluiten van de gebruiker.
Probeer het opnieuw of neem contact op met het Tech Team.',
	'editaccount-invalid-email' => '"$1" is geen geldig e-mailadres.',
	'editaccount-nouser' => 'De gebruiker "$1" bestaat niet.',
	'editaccount-log' => 'Logboek gebruikers',
	'editaccount-log-header' => 'Op deze pagina staan wijzigingen in gebruikersvoorkeuren die door stafleden van Wikia zijn gemaakt.',
	'editaccount-log-entry-email' => 'heeft het e-mailadres voor gebruiker $2 aangepast',
	'editaccount-log-entry-pass' => 'heeft het wachtwoord voor gebruiker $2 aangepast',
	'editaccount-log-entry-realname' => 'heeft de echte naam voor gebruiker $2 aangepast',
	'editaccount-log-entry-close' => 'heeft gebruiker $2 uitgeschakeld',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Deze gebruiker is afgelsoten.</div>',
	'right-editaccount' => 'Voorkeuren van gebruikers bewerken',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'editaccount' => 'Modìfica Cont',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Modìfica un cont',
	'editaccount-frame-usage' => 'Nòta',
	'editaccount-usage' => "Ij dat utent a son butà an memòria local separatament për minca wiki. Quand ch'a ampòsta torna na ciav o n'adrëssa ëd pòsta eletrònica, la memòria local a sarà anulà mach për cola wiki. Për piasì ch'a adressa l'utent a cola wiki-là për intré con la neuva ciav për evité problema ëd memòria local.",
	'editaccount-label-select' => 'Selession-a un cont utent',
	'editaccount-submit-account' => 'Gestiss Cont',
	'editaccount-frame-account' => 'Modifiché cont utent: $1',
	'editaccount-frame-close' => 'Disabilité ël cont utent: $1',
	'editaccount-label-email' => 'Buté na neuva adrëssa ëd pòsta eletrònica',
	'editaccount-label-pass' => 'Ampòsta neuva ciav',
	'editaccount-label-realname' => 'Ampòsta neuv nòm ver',
	'editaccount-submit-email' => "Salvé l'adrëssa ëd pòsta eletrònica",
	'editaccount-submit-pass' => 'Salva Ciav',
	'editaccount-submit-realname' => 'Salva Nòm Ver',
	'editaccount-submit-close' => 'Sara Cont',
	'editaccount-usage-close' => "A peul ëdcò disabilité a un cont utent an cripté soa ciav e gavand soa adrëssa ëd pòsta eletrònica. Ch'a fasa atension che sto dat a l'é përdù e a l'é pa arcuperàbil.",
	'editaccount-warning-close' => "<b>Atension!</b> A l'é an camin ch'a disabìlita për sempe ël cont ëd l'utent <b>$1</b>. As peul pa torné andré. É-lo sigur ëd vorèj felo?",
	'editaccount-status' => 'Mëssagi dë stat',
	'editaccount-success-email' => "Cambià da bin l'adrëssa ëd pòsta eletrònica për ël cont $1 a $2.",
	'editaccount-success-pass' => 'Cambià da bin ciav për ël cont $1.',
	'editaccount-success-realname' => 'Cambià da bin ël nòm ver për ël cont $1.',
	'editaccount-success-close' => 'Disabilità da bin ël cont $1.',
	'editaccount-error-email' => "L'adrëssa ëd pòsta eletrònica e l'é pa stàita cambià. Ch'a preuva torna o ch'a contata l'Echip técnica.",
	'editaccount-error-pass' => "La ciav a l'é pa stàita cangià. Ch'a preuva torna o ch'a contata l'Echip técnica.",
	'editaccount-error-realname' => "Ël nòm ver a l'é pa stàit cangià. Ch'a preuva torna o ch'a contata l'Echip Técnica.",
	'editaccount-error-close' => "Un problema a l'é capità an sarand ël cont. Ch'a preuva torna o ch'a contata l'Echip técnica.",
	'editaccount-invalid-email' => '"$1" a l\'é n\'adrëssa ëd pòsta eletrònica pa bon-a!',
	'editaccount-nouser' => 'Cont "$1" a esist pa!',
	'editaccount-log' => 'Registr dël cont utent',
	'editaccount-log-header' => "Sta pàgina-sì a lista ij cangiament fàit ai gust ëd l'utent da l'Echip ëd Wikia.",
	'editaccount-log-entry-email' => "a l'ha cangià l'adrëssa ëd pòsta eletrònica për l'utent $2",
	'editaccount-log-entry-pass' => 'cangià ciav për utent $2',
	'editaccount-log-entry-realname' => 'cangià nòm ver për utent $2',
	'editaccount-log-entry-close' => 'disabilità cont $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Sto cont-sì a l\'é stàit disabilità.</div>',
	'right-editaccount' => "Modifiché ij gust ëd j'àutri utent",
);

/** Russian (Русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'editaccount-submit-email' => 'Сохранить email',
	'editaccount-submit-pass' => 'Сохранить пароль',
	'editaccount-submit-realname' => 'Сохранить настоящее имя',
	'editaccount-submit-close' => 'Закрыть учётную запись',
	'editaccount-usage-close' => 'Вы также можете приостановить действие учётной записи, заменив её пароль и удалив email-адрес. Обратите внимание, что эти данные будет невозможно восстановить.',
	'editaccount-warning-close' => '<b>Внимание!</b> Вы собираетесь навсегда отключить учётную запись пользователя <b>$1</b>. Это действие не может быть отменено. Вы уверены, что хотите сделать именно это?',
	'editaccount-status' => 'Статусное сообщение',
	'editaccount-success-email' => 'Email для учётной записи $1 успешно изменён на $2.',
	'editaccount-success-pass' => 'Пароль для учётной записи $1 успешно изменён.',
	'editaccount-success-realname' => 'Настоящее имя для учётной записи $1 успешно изменено.',
	'editaccount-success-close' => 'Учётная запись $1 успешно отключена.',
	'editaccount-nouser' => 'Учётная запись «$1» не существует!',
);

