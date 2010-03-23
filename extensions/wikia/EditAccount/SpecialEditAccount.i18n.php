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
	'editaccount-success-email-blank' => 'Successfully removed e-mail for account $1.',
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
	'editaccount-frame-close' => 'Deaktiveer gebruiker: $1',
	'editaccount-label-email' => 'Stel nuwe e-posadres',
	'editaccount-label-pass' => 'Stel nuwe wagwoord',
	'editaccount-label-realname' => 'Stel nuwe regte naam',
	'editaccount-submit-email' => 'Stoor E-pos',
	'editaccount-submit-pass' => 'Stoor wagwoord',
	'editaccount-submit-realname' => 'Stoor regte naam',
	'editaccount-submit-close' => 'Sluit rekening',
	'editaccount-status' => 'Statusboodskap',
	'editaccount-invalid-email' => '"$1" is nie \'n geldige e-posadres nie!',
	'editaccount-nouser' => 'Die gebruiker "$1" bestaan nie.',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'editaccount-submit-email' => 'Захаваць адрас электроннай пошты',
	'editaccount-submit-pass' => 'Захаваць пароль',
	'editaccount-submit-realname' => 'Захаваць сапраўднае імя',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'editaccount' => 'Kemmañ ar gont',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Kemmañ ur gont',
	'editaccount-frame-usage' => 'Notenn',
	'editaccount-label-select' => 'Dibab ur gont implijer',
	'editaccount-submit-account' => 'Merañ ar gont',
	'editaccount-frame-account' => 'Kemmoù ar gont implijer : $1',
	'editaccount-frame-close' => 'Diweredekaat ar gont implijer : $1',
	'editaccount-label-email' => "Termeniñ ur chomlec'h postel nevez",
	'editaccount-label-pass' => 'Termeniñ ur ger-tremen nevez',
	'editaccount-label-realname' => 'Termeniñ un anv klok nevez',
	'editaccount-submit-email' => 'Enrollañ ar postel',
	'editaccount-submit-pass' => 'Enrollañ ar ger-tremen',
	'editaccount-submit-realname' => 'Enrollañ an anv klok',
	'editaccount-submit-close' => 'Serriñ ar gont',
	'editaccount-status' => 'Kemenadenn statud',
	'editaccount-success-email' => 'Kemmet eo bet ar postel evit ar gont $1 da $2.',
	'editaccount-success-pass' => 'Kemmet eo bet ger tremen ar gont $1.',
	'editaccount-success-realname' => 'Kemmet eo bet anv gwir ar gont $1.',
	'editaccount-success-close' => 'Diweredekaet eo bet ar gont $1.',
	'editaccount-error-email' => "N'eo ket bet kemmet ar chomlec'h postel. Klaskit adarre pe kit a darempred gant ar skipailh teknikel.",
	'editaccount-error-pass' => "N'eo ket bet kemmet ar ger tremen. Klaskit adarre pe kit a darempred gant ar skipailh teknikel.",
	'editaccount-error-realname' => "N'eo ket bet kemmet an anv gwir. Klaskit adarre pe kit a darempred gant ar skipailh teknikel.",
	'editaccount-error-close' => 'Ur gudenn a zo bet pa vezer o serriñ ar gont. Klaskit adarre pe kit a darempred gant ar skipailh teknikel.',
	'editaccount-invalid-email' => 'N\'eo ket "$1" ur chomlec\'h postel reizh !',
	'editaccount-nouser' => 'N\'eus ket eus ar gont "$1" !',
	'editaccount-log' => 'Marilh ar gontoù implijer',
	'editaccount-log-header' => "Rollet e vez er pajenn-mañ ar c'hemmoù graet gant staff Wikia er penndibaboù implijer.",
	'editaccount-log-entry-email' => "en deus kemmet chmolec'h postel an implijer $2",
	'editaccount-log-entry-pass' => 'en deus kemmet ger tremen ar gont $2',
	'editaccount-log-entry-realname' => 'en deus kemmet anv gwir ar gont $2',
	'editaccount-log-entry-close' => 'en deus diweredekaet ar gont $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Diweredekaet eo bet ar gont.</div>',
	'right-editaccount' => 'Kemmañ penndibaboù implijerien all',
);

/** German (Deutsch) */
$messages['de'] = array(
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Dieses Benutzerkonto wurde deaktiviert.</div>',
);

/** Spanish (Español) */
$messages['es'] = array(
	'right-editaccount' => 'Editar las preferencias de otros usuarios',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'editaccount-submit-close' => 'بستن حساب کاربری',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'editaccount' => 'Muokkaa käyttäjätunnuksia',
	'editaccount-title' => 'Special: EditAccount',
	'editaccount-frame-manage' => 'Muokkaa käyttäjätunnusta',
	'editaccount-frame-usage' => 'Huomioi',
	'editaccount-usage' => 'Käyttäjäkohtaisen tiedot ovat talletettuna välimuistiin erikseen jokaista wikiä kohden. Kun asetat uuden salasanan tai sähköpostiosoitteen, välimuistiin tallennetut tiedot poistetaan vain tämän wikin kohdalla. Ohjaa käyttäjä kirjautumaan sisään tätä wikiä käyttäen välttääksesi ongelmia välimuistin kanssa.',
	'editaccount-label-select' => 'Valitse käyttäjätunnus',
	'editaccount-submit-account' => 'Hallinnoi tunnusta',
	'editaccount-frame-account' => 'Muokataan käyttäjätunnusta: $1',
	'editaccount-frame-close' => 'Poista käytöstä käyttäjätunnus: $1',
	'editaccount-label-email' => 'Aseta uusi sähköpostiosoite',
	'editaccount-label-pass' => 'Aseta uusi salasana',
	'editaccount-label-realname' => 'Aseta uusi oikea nimi',
	'editaccount-submit-email' => 'Tallenna sähköpostiosoite',
	'editaccount-submit-pass' => 'Tallenna salasana',
	'editaccount-submit-realname' => 'Tallenna oikea nimi',
	'editaccount-submit-close' => 'Sulje tunnus',
	'editaccount-usage-close' => 'Käyttäjätunnuksen voi poistaa käytöstä myös sekoittamalla sen salasanan ja poistamalla sen sähköpostiosoitteen. Huomioi, että nämä tiedot katoavat eikä niitä voi palauttaa.',
	'editaccount-warning-close' => '<b>Varoitus!</b> Olet poistamassa pysyvästi käytöstä käyttäjän <b>$1</b> tilin. Tämä ei voi palauttaa. Oletko varma, että haluat tehdä tämän?',
	'editaccount-status' => 'Tilaviesti',
	'editaccount-success-email' => 'Tunnuksen $1 sähköpostiosoite vaihdettiin onnistuneesti osoitteeseen $2.',
	'editaccount-success-pass' => 'Tunnuksen $1 salasana vaihdettiin onnistuneesti.',
	'editaccount-success-realname' => 'Tilin $1 oikea nimi vaihdettiin onnistuneesti.',
	'editaccount-success-close' => 'Tunnus $1 poistettiin käytöstä onnistuneesti.',
	'editaccount-error-email' => 'Sähköpostiosoitetta ei vaihdettu. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-error-pass' => 'Salasanaa ei vaihdettu. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-error-realname' => 'Oikea nimi ei vaihtunut. Yritä uudelleen tai ota yhteys tekniseen ryhmään.',
	'editaccount-error-close' => 'Tunnusta suljettaessa tapahtui virhe. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-invalid-email' => '"$1" ei ole kelvollinen sähköpostiosoite!',
	'editaccount-nouser' => 'Tunnusta nimeltä "$1" ei ole olemassa!',
	'editaccount-log' => 'Käyttäjätunnusloki',
	'editaccount-log-header' => 'Tämä sivu listaa Wikian henkilökunnan käyttäjäkohtaisiin asetuksiin tekemät muutokset.',
	'editaccount-log-entry-email' => 'muutti käyttäjän $2 sähköpostiosoitetta',
	'editaccount-log-entry-pass' => 'muutti käyttäjän $2 salasanaa',
	'editaccount-log-entry-realname' => 'käyttäjän $2 oikea nimi vaihtui',
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
	'editaccount-usage' => "Les données des utilisateurs sont cachées séparément pour chaque wiki. Si vous réinitialisez le mot de passe ou l'adresse électronique, le cache ne sera annulé que pour ce wiki. Veuillez rediriger l'utilisateur vers ce wiki pour qu'il se connecte avec son nouveau mot de passe pour éviter les problèmes de cache.",
	'editaccount-label-select' => 'Sélectionner un compte utilisateur',
	'editaccount-submit-account' => 'Gérer le compte',
	'editaccount-frame-account' => 'Modification du compte utilisateur : $1',
	'editaccount-frame-close' => 'Désactiver le compte utilisateur : $1',
	'editaccount-label-email' => 'Définir une nouvelle adresse électronique',
	'editaccount-label-pass' => 'Définir un nouveau mot de passe',
	'editaccount-label-realname' => 'Définir un nouveau nom complet',
	'editaccount-submit-email' => "Sauvegarder l'adresse électronique",
	'editaccount-submit-pass' => 'Sauvegarder le mot de passe',
	'editaccount-submit-realname' => 'Sauvegarder le nom complet',
	'editaccount-submit-close' => 'Clore le compte',
	'editaccount-usage-close' => 'Vous pouvez également désactiver un compte utilisateur en cryptant son mot de passe et en supprimant son adresse électronique. Veuillez notez que les données seront perdues et ne seront pas récupérables.',
	'editaccount-warning-close' => '<b>Attention !</b> Vous êtes sur le point de désactiver le compte utilisateur <b>$1</b> de manière permanente. Ceci ne peut pas être défait. Êtes-vous certain de vouloir effectuer cette opération ?',
	'editaccount-status' => 'Message de statut',
	'editaccount-success-email' => "L'adresse électronique du compte $1 a été modifiée avec succès à $2.",
	'editaccount-success-email-blank' => "L'adresse électronique du compte $1 a été supprimée avec succès.",
	'editaccount-success-pass' => 'Le mot de passe du compte $1 a été modifié avec succès.',
	'editaccount-success-realname' => 'Le nom complet du compte $1 a été modifié avec succès.',
	'editaccount-success-close' => 'Le compte $1 a été désactivé avec succès.',
	'editaccount-error-email' => "L'adresse électronique n'a pas été modifiée. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-pass' => "Le mot de passe n'a pas été modifié. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-realname' => "Le nom complet n'a pas été modifié. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-close' => "Un problème est survenu lors de la fermeture du compte. Veuillez ré-essayer ou contacter l'équipe technique.",
	'editaccount-invalid-email' => "« $1 » n'est pas une adresse électronique valide !",
	'editaccount-nouser' => "Le compte « $1 » n'existe pas !",
	'editaccount-log' => 'Journal des comptes utilisateurs',
	'editaccount-log-header' => 'Cette page liste les modifications faîtes au préférences utilisateur par le staff de Wikia.',
	'editaccount-log-entry-email' => "a modifié l'adresse électronique de l'utilisateur $2",
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
	'editaccount-success-email-blank' => 'Eliminouse con éxito o correo electrónico da conta $1.',
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
	'editaccount-submit-account' => 'Felhasználói fiók kezelése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'editaccount' => 'Modificar conto',
	'editaccount-title' => 'Special:Modificar conto',
	'editaccount-frame-manage' => 'Modificar un conto',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-usage' => 'Le datos de usator es retenite in cache separatemente pro cata wiki. Si tu reinitialisa un contrasigno o adresse de e-mail, le cache essera radite solmente pro iste wiki. Per favor dirige le usator a iste wiki pro aperir un session con un contrasigno novemente definite pro evitar problemas de cache.',
	'editaccount-label-select' => 'Selige un conto de usator',
	'editaccount-submit-account' => 'Gerer conto',
	'editaccount-frame-account' => 'Modification del conto de usator: $1',
	'editaccount-frame-close' => 'Disactivar le conto de usator: $1',
	'editaccount-label-email' => 'Definir nove adresse de e-mail',
	'editaccount-label-pass' => 'Definir nove contrasigno',
	'editaccount-label-realname' => 'Definir nove nomine real',
	'editaccount-submit-email' => 'Salveguardar e-mail',
	'editaccount-submit-pass' => 'Salveguardar contrasigno',
	'editaccount-submit-realname' => 'Salveguardar nomine real',
	'editaccount-submit-close' => 'Clauder conto',
	'editaccount-usage-close' => 'Tu pote equalmente disactivar un conto de usator per cryptar le contrasigno e remover le adresse de e-mail. Nota que iste datos essera irrecuperabilemente perdite.',
	'editaccount-warning-close' => '<b>Attention!</b> Tu es super le puncto de disactivar permanentemente le conto del usator <b>$1</b>. Isto es irreversibile. Es tu secur de voler facer isto?',
	'editaccount-status' => 'Message de stato',
	'editaccount-success-email' => 'E-mail del conto $1 cambiate a $2 con successo.',
	'editaccount-success-email-blank' => 'Le e-mail del conto $1 ha essite removite.',
	'editaccount-success-pass' => 'Contrasigno del conto $1 cambiate con successo.',
	'editaccount-success-realname' => 'Nomine real del conto $1 cambiate con successo.',
	'editaccount-success-close' => 'Conto $1 disactivate con successo.',
	'editaccount-error-email' => 'Le adresse de e-mail non ha essite cambiate. Reproba o contacta le equipa technic.',
	'editaccount-error-pass' => 'Le contrasigno non ha essite cambiate. Reproba o contacta le equipa technic.',
	'editaccount-error-realname' => 'Le nomine real non ha essite cambiate. Reproba o contacta le equipa technic.',
	'editaccount-error-close' => 'Un problema occurreva durante le clausura del conto. Reproba o contacta le equipa technic.',
	'editaccount-invalid-email' => '"$1" non es un adresse de e-mail valide!',
	'editaccount-nouser' => 'Le conto "$1" non existe!',
	'editaccount-log' => 'Registro de contos de usator',
	'editaccount-log-header' => 'Iste pagina lista le cambios facite al preferentias de usator per le personal de Wikia.',
	'editaccount-log-entry-email' => 'cambiava le adresse de e-mail del usator $2',
	'editaccount-log-entry-pass' => 'cambiava le contrasigno del usator $2',
	'editaccount-log-entry-realname' => 'cambiava le nomine real del usator $2',
	'editaccount-log-entry-close' => 'disactivava le conto $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Iste conto ha essite disactivate.</div>',
	'right-editaccount' => 'Modificar le preferentias de altere usatores',
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
	'editaccount-success-email-blank' => 'Е-поштата за сметката $1 е успешно отстранета.',
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
	'editaccount-success-email-blank' => 'Het e-mailadres voor $1 is verwijderd.',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'editaccount' => 'Rediger konto',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Rediger en konto',
	'editaccount-frame-usage' => 'Merk',
	'editaccount-label-select' => 'Velg en brukerkonto',
	'editaccount-submit-account' => 'Administrer konto',
	'editaccount-frame-account' => 'Redigerer brukerkonto: $1',
	'editaccount-frame-close' => 'Deaktiver brukerkonto: $1',
	'editaccount-label-email' => 'Angi ny e-postadresse',
	'editaccount-label-pass' => 'Angi nytt passord',
	'editaccount-label-realname' => 'Angi nytt virkelig navn',
	'editaccount-submit-email' => 'Lagre e-post',
	'editaccount-submit-pass' => 'Lagre passord',
	'editaccount-submit-realname' => 'Lagre virkelig navn',
	'editaccount-submit-close' => 'Lukk konto',
	'editaccount-usage-close' => 'Du kan også deaktivere en brukerkonto ved å tilfeldiggjøre passordet og fjerne e-postadressen. Legg merke til at denne dataen går tapt og ikke vil kunne gjenopprettes.',
	'editaccount-warning-close' => '<b>Forsiktig!</b> Du er i ferd med å permanent deaktivere kontoen til bruker <b>$1</b>. Dette kan ikke gjenopprettes. Er du sikker på at det er det du vil gjøre?',
	'editaccount-status' => 'Statusmelding',
	'editaccount-success-email' => 'Endret e-post for konto $1 til $2.',
	'editaccount-success-email-blank' => 'Fjernet e-post for kontoen $1.',
	'editaccount-success-pass' => 'Endret passord for konto $1.',
	'editaccount-success-realname' => 'Endret virkelig navn for konto $1.',
	'editaccount-success-close' => 'Deaktiverte konto $1.',
	'editaccount-error-email' => 'E-post ble ikke endret. Prøv igjen eller kontakt Tech Team.',
	'editaccount-error-pass' => 'Passord ble ikke endret. Prøv igjen eller kontakt Tech Team.',
	'editaccount-error-realname' => 'Virkelig navn ble ikke endret. Prøv igjen eller kontakt Tech Team.',
	'editaccount-error-close' => 'Et problem oppsto under lukking av kontoen. Prøv igjen eller kontakt Tech Team.',
	'editaccount-invalid-email' => '«$1» er ikke en gyldig e-postadresse!',
	'editaccount-nouser' => 'Kontoen «$1» finnes ikke!',
	'editaccount-log' => 'Brukerkontologg',
	'editaccount-log-header' => 'Denne siden lister opp endringer gjort på brukerinstillinger av Wikia Staff.',
	'editaccount-log-entry-email' => 'endret e-post for bruker $2',
	'editaccount-log-entry-pass' => 'endret passord for bruker $2',
	'editaccount-log-entry-realname' => 'endret virkelig navn for bruker $2',
	'editaccount-log-entry-close' => 'deaktiverte konto $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Denne kontoen har blitt deaktivert.</div>',
	'right-editaccount' => 'Rediger andre brukeres innstillinger',
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
	'editaccount-success-email-blank' => "Gavà da bin l'adrëssa ëd pòsta eletrònica dal cont $1.",
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

/** Brazilian Portuguese (Português do Brasil)
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'editaccount' => 'Editar conta',
	'editaccount-frame-manage' => 'Editar uma conta',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-usage' => 'Os dados de usuário estão em caches separados para cada wiki. Quando você redefine uma senha ou email, o cache será modificado apenas para essa wiki. Por favor, direcione o usuário de modo a realizar login nessa wiki com a nova senha, para evitar problemas de cache.',
	'editaccount-label-select' => 'Selecione uma conta de usuário',
	'editaccount-submit-account' => 'Administrar Contas',
	'editaccount-frame-account' => 'Editando conta de usuário: $1',
	'editaccount-frame-close' => 'Desabilitar conta de usuário: $1',
	'editaccount-label-email' => 'Definir novo endereço de email',
	'editaccount-label-pass' => 'Definir nova senha',
	'editaccount-label-realname' => 'Definir novo nome real',
	'editaccount-submit-email' => 'Salvar Email',
	'editaccount-submit-pass' => 'Salvar Senha',
	'editaccount-submit-realname' => 'Salvar Nome Real',
	'editaccount-submit-close' => 'Fechar Conta',
	'editaccount-usage-close' => 'Você também pode desabilitar uma conta de usuário mudando sua senha e removendo o endereço de email. Note que esses dados serão perdidos e nunca mais poderão ser recuperados.',
	'editaccount-warning-close' => '<b>Atenção!</b> Você está prestes a desativar permanentemente a conta de usuário <b>$1</b>. Essa ação não poderá ser revertida. Estando ciente disto, você tem certeza de que é isso que deseja fazer?',
	'editaccount-status' => 'Mensagem de status',
	'editaccount-success-email' => 'Email alterado com sucesso para a conta de $1 para $2.',
	'editaccount-success-pass' => 'Senha alterada com sucesso para a conta $1.',
	'editaccount-success-realname' => 'Nome real alterado com sucesso para a conta $1.',
	'editaccount-success-close' => 'Conta $1 desabilitada com sucesso.',
	'editaccount-error-email' => 'O email não foi alterado. Tente novamente ou contate a equipe de apoio (Tech Team).',
	'editaccount-error-pass' => 'A senha não foi alterada. Tente novamente ou contate a equipe de apoio (Tech Team).',
	'editaccount-error-realname' => 'O nome real não foi alterado. Tente novamente ou contate a equipe de apoio (Tech Team).',
	'editaccount-error-close' => 'Ocorreu um problema ao fechar a conta. Tente novamente ou contate a equipe de apoio (Tech Team).',
	'editaccount-invalid-email' => '"$1" não é um endereço de email válido!',
	'editaccount-nouser' => 'A conta "$1" não existe!',
	'editaccount-log' => 'Use o log de contas',
	'editaccount-log-header' => 'Essa página lista mudanças feitas nas preferências de usuário pela equipe do Wikia (Wikia Staff).',
	'editaccount-log-entry-email' => 'email alterado para o usuário $2',
	'editaccount-log-entry-pass' => 'senha alterada para o usuário $2',
	'editaccount-log-entry-realname' => 'nome real alterado para o usuário $2',
	'editaccount-log-entry-close' => 'desabilitada a conta $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Essa conta foi desabilitada.</div>',
	'right-editaccount' => 'Editar outras preferências de usuário',
);

/** Russian (Русский)
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'editaccount' => 'Изменение учётной записи',
	'editaccount-title' => 'Special:ИзменениеУчётнойЗаписи',
	'editaccount-frame-manage' => 'Изменение учётной записи',
	'editaccount-frame-usage' => 'Замечание',
	'editaccount-usage' => 'Данные кэшируются отдельно для каждой вики. При сбросе пароля или адреса электронной почты, кэш будет обновлён только для этой вики. Пожалуйста, попросите участника войти в эту вики с новым паролем, чтобы избежать проблем с кэшированием.',
	'editaccount-label-select' => 'Выберите учётную запись участника',
	'editaccount-submit-account' => 'Управление учётной записью',
	'editaccount-frame-account' => 'Изменение учётной записи участника: $1',
	'editaccount-frame-close' => 'Отключение учётной записи участника: $1',
	'editaccount-label-email' => 'Установка нового адреса эл. почты',
	'editaccount-label-pass' => 'Установка нового пароля',
	'editaccount-label-realname' => 'Установка нового настоящего имени',
	'editaccount-submit-email' => 'Сохранить адрес эл. почты',
	'editaccount-submit-pass' => 'Сохранить пароль',
	'editaccount-submit-realname' => 'Сохранить настоящее имя',
	'editaccount-submit-close' => 'Закрыть учётную запись',
	'editaccount-usage-close' => 'Вы также можете приостановить действие учётной записи, заменив её пароль и удалив адрес электронной почты. Обратите внимание, что эти данные будет невозможно восстановить.',
	'editaccount-warning-close' => '<b>Внимание!</b> Вы собираетесь навсегда отключить учётную запись пользователя <b>$1</b>. Это действие не может быть отменено. Вы уверены, что хотите сделать именно это?',
	'editaccount-status' => 'Статусное сообщение',
	'editaccount-success-email' => 'Адрес эл. почты для учётной записи $1 успешно изменён на $2.',
	'editaccount-success-email-blank' => 'Адрес электронной почты учётной записи $1 успешно удалён.',
	'editaccount-success-pass' => 'Пароль для учётной записи $1 успешно изменён.',
	'editaccount-success-realname' => 'Настоящее имя для учётной записи $1 успешно изменено.',
	'editaccount-success-close' => 'Учётная запись $1 успешно отключена.',
	'editaccount-error-email' => 'Адрес эл. почты не был изменён. Попробуйте ещё раз или свяжитесь с технической командой.',
	'editaccount-error-pass' => 'Пароль не был изменён. Попробуйте ещё раз или свяжитесь с технической командой.',
	'editaccount-error-realname' => 'Настоящее имя не было изменено. Попробуйте ещё раз или свяжитесь с технической командой.',
	'editaccount-error-close' => 'Возникла проблема при закрытии учётной записи. Попробуйте ещё раз или свяжитесь с технической командой.',
	'editaccount-invalid-email' => '«$1» не является допустимым адресом электронной почты!',
	'editaccount-nouser' => 'Учётная запись «$1» не существует!',
	'editaccount-log' => 'Журнал учётных записей',
	'editaccount-log-header' => 'На этой странице показаны изменения настроек участника, выполненные сотрудниками Викии',
	'editaccount-log-entry-email' => 'изменил адрес эл. почты участника $2',
	'editaccount-log-entry-pass' => 'изменил пароль участника $2',
	'editaccount-log-entry-realname' => 'изменил настоящее имя участника $2',
	'editaccount-log-entry-close' => 'отключил учётную запись $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Эта учётная запись была отключена.</div>',
	'right-editaccount' => 'Редактировать настройки других участников',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'editaccount' => 'Измена налога',
	'editaccount-frame-manage' => 'Уреди налог',
	'editaccount-label-email' => 'Постави нову адресу електронске поште (мејл)',
	'editaccount-label-pass' => 'Постави нову лозинку',
	'editaccount-label-realname' => 'Унеси ново право име',
	'editaccount-submit-email' => 'Сачувај е-пошту',
	'editaccount-submit-pass' => 'Сачувај лозинку',
	'editaccount-submit-realname' => 'Сачувај право име',
	'editaccount-submit-close' => 'Затвори налог',
	'editaccount-success-email' => 'Успешно променио е-пошту од налога $1 на $2.',
	'editaccount-success-pass' => 'Успешно променио лозинку за налог  $1.',
	'editaccount-success-realname' => 'успешно променио право име за налог  $1.',
	'editaccount-success-close' => 'Успешно затворио налог  $1.',
	'editaccount-invalid-email' => '"$1" је неважећа адреса електронске поште',
	'editaccount-nouser' => 'Не постоји налог "$1" !',
	'editaccount-log-entry-email' => ' промењена адреса е-поште за корисника $2',
	'editaccount-log-entry-pass' => ' промењена лозинка за корисника $2',
	'editaccount-log-entry-realname' => ' промењено право име за корисника $2',
	'editaccount-log-entry-close' => ' угашен налог $2',
);

