<?php
/**
 * Internationalization file for ProtectSite extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Eric Johnston <e.wolfie@gmail.com>
 */
$messages['en'] = array(
	'protectsite' => 'Protect site',
	'protectsite-desc' => 'Allows a site administrator to temporarily block various site modifications',
	'protectsite-text-protect' => '<!-- Instructions/Comments/Policy for use -->',
	'protectsite-text-unprotect' => '<!-- Instructions/Comments when protected -->',
	'protectsite-title' => 'Site protection settings',
	'protectsite-allowall' => 'All users',
	'protectsite-allowusersysop' => 'Registered users and administrators',
	'protectsite-allowsysop' => 'Administrators only',
	'protectsite-createaccount' => 'Allow creation of new accounts by',
	'protectsite-createpage' => 'Allow creation of pages by',
	'protectsite-edit' => 'Allow editing of pages by',
	'protectsite-move' => 'Allow moving of pages by',
	'protectsite-upload' => 'Allow file uploads by',
	'protectsite-timeout' => 'Timeout:',
	'protectsite-timeout-error' => "'''Invalid timeout.'''",
	'protectsite-maxtimeout' => 'Maximum: $1',
	'protectsite-comment' => 'Comment:',
	'protectsite-ucomment' => 'Unprotect comment:',
	'protectsite-until' => 'Protected until:',
	'protectsite-protect' => 'Protect',
	'protectsite-unprotect' => 'Unprotect',

	/* epic message duplication... */
	'protectsite-createaccount-0' => 'All users',
	'protectsite-createaccount-1' => 'Registered users and administrators',
	'protectsite-createaccount-2' => 'Administrators only',
	'protectsite-createpage-0' => 'All users',
	'protectsite-createpage-1' => 'Registered users and administrators',
	'protectsite-createpage-2' => 'Administrators only',
	'protectsite-edit-0' => 'All users',
	'protectsite-edit-1' => 'Registered users and administrators',
	'protectsite-edit-2' => 'Administrators only',
	'protectsite-move-0' => 'Registered users and administrators',
	'protectsite-move-1' => 'Administrators only',
	'protectsite-upload-0' => 'Registered users and administrators',
	'protectsite-upload-1' => 'Administrators only',
	/* end epic message duplication */

	'right-protectsite' => 'Limit actions that can be performed for some groups for a limited time',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'protectsite-desc' => '{{desc}}',
	'right-protectsite' => '{{doc-right|protectsite}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'protectsite-allowall' => 'Alle gebruikers',
	'protectsite-protect' => 'Beskerm',
	'protectsite-unprotect' => 'Verwyder beskerming',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'protectsite-allowall' => 'Bütün istifadəçilər',
	'protectsite-comment' => 'Şərh:',
	'protectsite-createaccount-0' => 'Bütün istifadəçilər',
	'protectsite-createpage-0' => 'Bütün istifadəçilər',
	'protectsite-edit-0' => 'Bütün istifadəçilər',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'protectsite' => 'Абарона сайту',
	'protectsite-desc' => 'Дазваляе адміністратару сайта часова блякаваць розныя зьмены сайту',
	'protectsite-text-protect' => '<!-- Інструкцыі/Камэнтары/Правілы выкарыстаньня -->',
	'protectsite-text-unprotect' => '<!-- Інструкцыі/Камэнтары, калі працуе абарона -->',
	'protectsite-title' => 'Устаноўкі абароны сайту',
	'protectsite-allowall' => 'Усім удзельнікам',
	'protectsite-allowusersysop' => 'Зарэгістраваным удзельнікам і адміністратарам',
	'protectsite-allowsysop' => 'Толькі адміністратарам',
	'protectsite-createaccount' => 'Дазволіць стварэньне новых рахункаў',
	'protectsite-createpage' => 'Дазволіць стварэньне старонак',
	'protectsite-edit' => 'Дазволіць рэдагаваньне старонак',
	'protectsite-move' => 'Дазволіць перанос старонак',
	'protectsite-upload' => 'Дазволіць загрузку файлаў',
	'protectsite-timeout' => 'Час дзеяньня абароны:',
	'protectsite-timeout-error' => "'''Няслушны час дзеяньня абароны.'''",
	'protectsite-maxtimeout' => 'Максымум: $1',
	'protectsite-comment' => 'Камэнтар:',
	'protectsite-ucomment' => 'Камэнтар зьняцьця абароны:',
	'protectsite-until' => 'Абаронены да:',
	'protectsite-protect' => 'Абараніць',
	'protectsite-unprotect' => 'Зьняць абарону',
	'protectsite-createaccount-0' => 'Усе ўдзельнікі',
	'protectsite-createaccount-1' => 'Зарэгістраваныя ўдзельнікі і адміністратары',
	'protectsite-createaccount-2' => 'Толькі адміністратары',
	'protectsite-createpage-0' => 'Усе ўдзельнікі',
	'protectsite-createpage-1' => 'Зарэгістраваныя ўдзельнікі і адміністратары',
	'protectsite-createpage-2' => 'Толькі адміністратары',
	'protectsite-edit-0' => 'Усе ўдзельнікі',
	'protectsite-edit-1' => 'Зарэгістраваныя ўдзельнікі і адміністратары',
	'protectsite-edit-2' => 'Толькі адміністратары',
	'protectsite-move-0' => 'Зарэгістраваныя ўдзельнікі і адміністратары',
	'protectsite-move-1' => 'Толькі адміністратары',
	'protectsite-upload-0' => 'Зарэгістраваныя ўдзельнікі і адміністратары',
	'protectsite-upload-1' => 'Толькі адміністратары',
	'right-protectsite' => 'абмежаваньне дзеяньняў, якія могуць быць выкананьня групай у вызначаны час',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'protectsite-allowall' => 'Всички потребители',
	'protectsite-allowusersysop' => 'Регистрирани потребители и администратори',
	'protectsite-allowsysop' => 'Само администратори',
	'protectsite-comment' => 'Коментар:',
	'protectsite-createaccount-0' => 'Всички потребители',
	'protectsite-createaccount-1' => 'Регистрирани потребители и администратори',
	'protectsite-createaccount-2' => 'Само администратори',
	'protectsite-createpage-0' => 'Всички потребители',
	'protectsite-createpage-1' => 'Регистрирани потребители и администратори',
	'protectsite-createpage-2' => 'Само администратори',
	'protectsite-edit-0' => 'Всички потребители',
	'protectsite-edit-1' => 'Регистрирани потребители и администратори',
	'protectsite-edit-2' => 'Само администратори',
	'protectsite-move-0' => 'Регистрирани потребители и администратори',
	'protectsite-move-1' => 'Само администратори',
	'protectsite-upload-0' => 'Регистрирани потребители и администратори',
	'protectsite-upload-1' => 'Само администратори',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'protectsite' => "Gwareziñ al lec'hienn",
	'protectsite-desc' => "Aotren a ra merour ul lechienn da stankañ kemmoù niverus bet degaset war al lec'hienn, evit ur prantad bennak",
	'protectsite-text-protect' => '<!-- Kemennoù / Displegadennoù / Reolennoù implijout -->',
	'protectsite-text-unprotect' => '<!-- Kemennoù / Displegadennoù pa vez gwarezet -->',
	'protectsite-title' => "Arventennoù gwareziñ al lec'hienn",
	'protectsite-allowall' => 'An holl implijerien',
	'protectsite-allowusersysop' => 'Implijerien enrollet ha merourien',
	'protectsite-allowsysop' => 'Merourien hepken',
	'protectsite-createaccount' => 'Aotren da grouiñ kontoù nevez dre',
	'protectsite-createpage' => 'Aotren da grouiñ pajennoù dre',
	'protectsite-edit' => 'Aotren da gemm pajennoù dre',
	'protectsite-move' => 'Aotren da adenvel pajennoù dre',
	'protectsite-upload' => 'Aotren da enporzhiañ restroù dre',
	'protectsite-timeout' => 'Termen',
	'protectsite-timeout-error' => "'''Termen direizh.'''",
	'protectsite-maxtimeout' => 'Maximum : $1',
	'protectsite-comment' => 'Evezhiadenn :',
	'protectsite-ucomment' => 'Evezhiadenn war an diwareziñ',
	'protectsite-until' => 'Gwarezet betek :',
	'protectsite-protect' => 'Gwareziñ',
	'protectsite-unprotect' => 'Diwareziñ',
	'protectsite-createaccount-0' => 'An holl implijerien',
	'protectsite-createaccount-1' => 'Implijerien enrollet ha merourien',
	'protectsite-createaccount-2' => 'Merourien hepken',
	'protectsite-createpage-0' => 'An holl implijerien',
	'protectsite-createpage-1' => 'Implijerien enrollet ha merourien',
	'protectsite-createpage-2' => 'Merourien hepken',
	'protectsite-edit-0' => 'An holl implijerien',
	'protectsite-edit-1' => 'Implijerien enrollet ha merourien',
	'protectsite-edit-2' => 'Merourien hepken',
	'protectsite-move-0' => 'Implijerien enrollet ha merourien',
	'protectsite-move-1' => 'Merourien hepken',
	'protectsite-upload-0' => 'Implijerien enrollet ha merourien',
	'protectsite-upload-1' => 'Merourien hepken',
	'right-protectsite' => "Bevenniñ a ra an oberoù a c'hall bezañ sevenet gant strolladoù zo evit ur prantad bennak",
);

/** German (Deutsch)
 * @author Geitost
 * @author Kghbln
 * @author LWChris
 */
$messages['de'] = array(
	'protectsite' => 'Seite schützen',
	'protectsite-desc' => 'Ermöglicht es einem Systemadministrator, vorübergehend verschiedene Aktionen für bestimmte Benutzergruppen des Wikis außer Kraft zu setzen',
	'protectsite-text-protect' => '<!-- Anweisungen/Kommentare/Nutzungsrichtlinie -->',
	'protectsite-text-unprotect' => '<!-- Anweisungen/Kommentare, sofern gesperrt -->',
	'protectsite-title' => 'Seitenschutzeinstellungen',
	'protectsite-allowall' => 'Alle Benutzer',
	'protectsite-allowusersysop' => 'Registrierte Benutzer und Administratoren',
	'protectsite-allowsysop' => 'Nur Administratoren',
	'protectsite-createaccount' => 'Erlaube die Erstellung neuer Benutzerkonten durch',
	'protectsite-createpage' => 'Erlaube die Erstellung von Seiten durch',
	'protectsite-edit' => 'Erlaube das Bearbeiten von Seiten durch',
	'protectsite-move' => 'Erlaube das Verschieben von Seiten durch',
	'protectsite-upload' => 'Erlaube das Hochladen von Dateien durch',
	'protectsite-timeout' => 'Dauer des Schutzes:',
	'protectsite-timeout-error' => "'''Ungültige Zeitangabe.'''",
	'protectsite-maxtimeout' => 'Maximale Dauer: $1',
	'protectsite-comment' => 'Grund:',
	'protectsite-ucomment' => 'Aufhebungsgrund:',
	'protectsite-until' => 'Geschützt bis:',
	'protectsite-protect' => 'Schützen',
	'protectsite-unprotect' => 'Schutz aufheben',
	'protectsite-createaccount-0' => 'Alle Benutzer',
	'protectsite-createaccount-1' => 'Registrierte Benutzer und Administratoren',
	'protectsite-createaccount-2' => 'Nur Administratoren',
	'protectsite-createpage-0' => 'Alle Benutzer',
	'protectsite-createpage-1' => 'Registrierte Benutzer und Administratoren',
	'protectsite-createpage-2' => 'Nur Administratoren',
	'protectsite-edit-0' => 'Alle Benutzer',
	'protectsite-edit-1' => 'Registrierte Benutzer und Administratoren',
	'protectsite-edit-2' => 'Nur Administratoren',
	'protectsite-move-0' => 'Registrierte Benutzer und Administratoren',
	'protectsite-move-1' => 'Nur Administratoren',
	'protectsite-upload-0' => 'Registrierte Benutzer und Administratoren',
	'protectsite-upload-1' => 'Nur Administratoren',
	'right-protectsite' => 'Durchführbare Aktionen für eine bestimmte Benutzergruppe während eines begrenzten Zeitraums einschränken',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Peter17
 * @author Translationista
 */
$messages['es'] = array(
	'protectsite' => 'Proteger el sitio',
	'protectsite-text-protect' => '<!-- Instrucciones/Comentario/Políticas de uso -->',
	'protectsite-text-unprotect' => '<!-- Instrucciones/Comentarios al estar protegidos-->',
	'protectsite-title' => 'Configuraciones de protección de sitio',
	'protectsite-allowall' => 'Todos los usuarios',
	'protectsite-allowusersysop' => 'Usuarios registrados y administradores de sistema',
	'protectsite-allowsysop' => 'Sólo administradores de sistema',
	'protectsite-createaccount' => 'Permitir creción de nuevas cuentas por',
	'protectsite-createpage' => 'Permitir creación de páginas por',
	'protectsite-edit' => 'Permitir edición de páginas por',
	'protectsite-move' => 'Permitir movimiento de páginas por',
	'protectsite-upload' => 'Permitir cargas de archivo por',
	'protectsite-timeout' => 'Tiempo de espera:',
	'protectsite-timeout-error' => "'''Tiempo de espera inválido.'''",
	'protectsite-maxtimeout' => 'Máximo:',
	'protectsite-comment' => 'Comentario:',
	'protectsite-ucomment' => 'Desproteger comentario:',
	'protectsite-until' => 'Protegido hasta:',
	'protectsite-protect' => 'Proteger',
	'protectsite-unprotect' => 'Desproteger',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'protectsite' => 'Suojaa sivusto',
	'protectsite-title' => 'Sivuston suojauksen asetukset',
	'protectsite-allowall' => 'Kaikki käyttäjät',
	'protectsite-allowusersysop' => 'Rekisteröityneet käyttäjät ja ylläpitäjät',
	'protectsite-allowsysop' => 'Vain ylläpitäjät',
	'protectsite-createaccount' => 'Salli seuraavien luoda uusia tunnuksia',
	'protectsite-createpage' => 'Salli seuraavien luoda uusia sivuja',
	'protectsite-edit' => 'Salli seuraavien muokata sivuja',
	'protectsite-move' => 'Salli seuraavien siirtää sivuja',
	'protectsite-upload' => 'Salli seuraavien tallentaa tiedostoja',
	'protectsite-timeout' => 'Aikakatkaisu:',
	'protectsite-timeout-error' => "'''Kelpaamaton aikakatkaisu.'''",
	'protectsite-maxtimeout' => 'Maksimi: $1',
	'protectsite-comment' => 'Kommentti:',
	'protectsite-ucomment' => 'Suojauksen poiston kommentti:',
	'protectsite-protect' => 'Suojaa',
	'protectsite-unprotect' => 'Poista suojaus',
	'right-protectsite' => 'Rajoittaa toimintoja, joita jotkin ryhmät voivat tehdä, tietyn aikaa',
);

/** French (Français)
 * @author Alexandre Emsenhuber
 * @author Balzac 40
 */
$messages['fr'] = array(
	'protectsite' => 'Protéger le site',
	'protectsite-desc' => 'Permet à un administrateur de site de bloquer temporairement diverses modifications du site',
	'protectsite-text-protect' => "<!-- Instructions / Commentaires / Règles d'utilisation -->",
	'protectsite-text-unprotect' => '<!-- Instructions / Commentaires lorsque protégé -->',
	'protectsite-title' => 'Paramètres de la protection du site',
	'protectsite-allowall' => 'Tous les utilisateurs',
	'protectsite-allowusersysop' => 'Utilisateurs enregistrés et administrateurs',
	'protectsite-allowsysop' => 'Administrateurs seulement',
	'protectsite-createaccount' => 'Autoriser la création de nouveaux comptes par',
	'protectsite-createpage' => 'Autoriser la création de comptes par',
	'protectsite-edit' => 'Autoriser les modifications de pages par',
	'protectsite-move' => 'Autoriser le renommage de pages par',
	'protectsite-upload' => 'Autoriser les imports de fichiers par',
	'protectsite-timeout' => 'Expiration :',
	'protectsite-timeout-error' => "'''Expiration invalide.'''",
	'protectsite-maxtimeout' => 'Maximum : $1',
	'protectsite-comment' => 'Commentaire :',
	'protectsite-ucomment' => 'Commentaire de déprotection :',
	'protectsite-until' => "Protéger jusqu'à :",
	'protectsite-protect' => 'Protéger',
	'protectsite-unprotect' => 'Déprotéger',
	'protectsite-createaccount-0' => 'Tous les utilisateurs',
	'protectsite-createaccount-1' => 'Les utilisateurs enregistrés et les administrateurs',
	'protectsite-createaccount-2' => 'Administrateurs seulement',
	'protectsite-createpage-0' => 'Tous les utilisateurs',
	'protectsite-createpage-1' => 'Les utilisateurs enregistrés et les administrateurs',
	'protectsite-createpage-2' => 'Administrateurs seulement',
	'protectsite-edit-0' => 'Tous les utilisateurs',
	'protectsite-edit-1' => 'Les utilisateurs enregistrés et les administrateurs',
	'protectsite-edit-2' => 'Administrateurs seulement',
	'protectsite-move-0' => 'Les utilisateurs enregistrés et les administrateurs',
	'protectsite-move-1' => 'Administrateurs seulement',
	'protectsite-upload-0' => 'Les utilisateurs enregistrés et les administrateurs',
	'protectsite-upload-1' => 'Administrateurs seulement',
	'right-protectsite' => 'Limiter les actions qui peuvent être effectuées pour certains groupes pour un temps limité',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'protectsite' => 'Protègiér lo seto',
	'protectsite-text-protect' => '<!-- Enstruccions / Comentèros / Règlles d’usâjo -->',
	'protectsite-text-unprotect' => '<!-- Enstruccions / Comentèros quand protègiê -->',
	'protectsite-title' => 'Paramètres de la protèccion du seto',
	'protectsite-allowall' => 'Tôs los usanciérs',
	'protectsite-allowusersysop' => 'Los usanciérs encartâs et los administrators',
	'protectsite-allowsysop' => 'Solament los administrators',
	'protectsite-createaccount' => 'Ôtorisar la crèacion de comptos novéls per',
	'protectsite-createpage' => 'Ôtorisar la crèacion de pâges per',
	'protectsite-edit' => 'Ôtorisar los changements de pâges per',
	'protectsite-move' => 'Ôtorisar lo renomâjo de pâges per',
	'protectsite-upload' => 'Ôtorisar los tèlèchargements de fichiérs per',
	'protectsite-timeout' => 'Èxpiracion :',
	'protectsite-timeout-error' => "'''Èxpiracion envalida.'''",
	'protectsite-maxtimeout' => 'U més : $1',
	'protectsite-comment' => 'Comentèro :',
	'protectsite-ucomment' => 'Comentèro de dèprotèccion :',
	'protectsite-until' => 'Protègiê tant qu’a :',
	'protectsite-protect' => 'Protègiér',
	'protectsite-unprotect' => 'Dèprotègiér',
	'protectsite-createaccount-0' => 'Tôs los usanciérs',
	'protectsite-createaccount-1' => 'Los usanciérs encartâs et los administrators',
	'protectsite-createaccount-2' => 'Solament los administrators',
	'protectsite-createpage-0' => 'Tôs los usanciérs',
	'protectsite-createpage-1' => 'Los usanciérs encartâs et los administrators',
	'protectsite-createpage-2' => 'Solament los administrators',
	'protectsite-edit-0' => 'Tôs los usanciérs',
	'protectsite-edit-1' => 'Los usanciérs encartâs et los administrators',
	'protectsite-edit-2' => 'Solament los administrators',
	'protectsite-move-0' => 'Los usanciérs encartâs et los administrators',
	'protectsite-move-1' => 'Solament los administrators',
	'protectsite-upload-0' => 'Los usanciérs encartâs et los administrators',
	'protectsite-upload-1' => 'Solament los administrators',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'protectsite' => 'Protexer o sitio',
	'protectsite-desc' => 'Permite que un administrador do sitio bloquee temporalmente varias modificacións do mesmo',
	'protectsite-text-protect' => '<!-- Instrucións/Comentarios/Política de uso -->',
	'protectsite-text-unprotect' => '<!-- Instrucións/Comentarios durante a protección -->',
	'protectsite-title' => 'Configuración da protección do sitio',
	'protectsite-allowall' => 'Todos os usuarios',
	'protectsite-allowusersysop' => 'Usuarios rexistrados e administradores',
	'protectsite-allowsysop' => 'Administradores soamente',
	'protectsite-createaccount' => 'Permitir a creación de novas contas por',
	'protectsite-createpage' => 'Permitir a creación de páxinas por',
	'protectsite-edit' => 'Permitir a edición de páxinas por',
	'protectsite-move' => 'Permitir o traslado de páxinas por',
	'protectsite-upload' => 'Permitir a carga de ficheiros por',
	'protectsite-timeout' => 'Remate:',
	'protectsite-timeout-error' => "'''Tempo de caducidade inválido.'''",
	'protectsite-maxtimeout' => 'Máximo: $1',
	'protectsite-comment' => 'Comentario:',
	'protectsite-ucomment' => 'Comentario de desprotección:',
	'protectsite-until' => 'Protexido ata:',
	'protectsite-protect' => 'Protexer',
	'protectsite-unprotect' => 'Desprotexer',
	'protectsite-createaccount-0' => 'Todos os usuarios',
	'protectsite-createaccount-1' => 'Usuarios rexistrados e administradores',
	'protectsite-createaccount-2' => 'Só os administradores',
	'protectsite-createpage-0' => 'Todos os usuarios',
	'protectsite-createpage-1' => 'Usuarios rexistrados e administradores',
	'protectsite-createpage-2' => 'Só os administradores',
	'protectsite-edit-0' => 'Todos os usuarios',
	'protectsite-edit-1' => 'Usuarios rexistrados e administradores',
	'protectsite-edit-2' => 'Só os administradores',
	'protectsite-move-0' => 'Usuarios rexistrados e administradores',
	'protectsite-move-1' => 'Só os administradores',
	'protectsite-upload-0' => 'Usuarios rexistrados e administradores',
	'protectsite-upload-1' => 'Só os administradores',
	'right-protectsite' => 'Limita as accións que algúns grupos poden realizar por un tempo limitado',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 */
$messages['gsw'] = array(
	'protectsite-allowall' => 'Alli Benutzer',
	'protectsite-allowusersysop' => 'Registrierti Benutzer un Ammanne',
	'protectsite-allowsysop' => 'Numme Ammanne',
	'protectsite-createaccount' => 'Erlaub s Aalege vu neje Benutzerkonte dur',
	'protectsite-createpage' => 'Erlaub s Erstelle vo neije Syte dur',
	'protectsite-edit' => 'Erlaub s Bearbeite vo neije Syte dur',
	'protectsite-move' => 'Erlaub s Verschiebe vo neije Syte dur',
	'protectsite-upload' => 'Erlaub s Uffelade vo Dateie dur',
	'protectsite-timeout' => 'Sperrduur:',
	'protectsite-timeout-error' => "'''Sperrduur isch nit gültig.'''",
	'protectsite-maxtimeout' => 'Maximali Sperrduur: $1',
	'protectsite-comment' => 'Aamerkig:',
	'protectsite-ucomment' => 'Aamerkig zur Freigab:',
	'protectsite-until' => 'Gsperrt bis:',
	'protectsite-protect' => 'Schitze',
	'protectsite-unprotect' => 'nümm schütze',
	'protectsite-createaccount-0' => 'Alli Benutzer',
	'protectsite-createaccount-1' => 'Registrierti Benutzer un Ammanne',
	'protectsite-createaccount-2' => 'Numme Ammanne',
	'protectsite-createpage-0' => 'Alli Benutzer',
	'protectsite-createpage-1' => 'Registrierti Benutzer un Ammanne',
	'protectsite-createpage-2' => 'Numme Ammanne',
	'protectsite-edit-0' => 'Alli Benutzer',
	'protectsite-edit-1' => 'Registrierti Benutzer un Ammanne',
	'protectsite-edit-2' => 'Numme Ammanne',
	'protectsite-move-0' => 'Registrierti Benutzer un Ammanne',
	'protectsite-move-1' => 'Numme Ammanne',
	'protectsite-upload-0' => 'Registrierti Benutzer un Ammanne',
	'protectsite-upload-1' => 'Numme Ammanne',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'protectsite' => 'Sydło škitać',
	'protectsite-desc' => 'Zmóžnja systemowemu administratorej, wšelake změny sydła nachwilu blokować',
	'protectsite-text-protect' => '<!-- Instrukcije/Komentary/Wužiwanske prawidła -->',
	'protectsite-text-unprotect' => '<!-- Instrukcije/Komentary, jeli škitany -->',
	'protectsite-title' => 'Nastajenja za škitanje sydła',
	'protectsite-allowall' => 'Wšitcy wužiwarjo',
	'protectsite-allowusersysop' => 'Zregistrowani wužiwarjo a administratorojo',
	'protectsite-allowsysop' => 'Jenož administratorojo',
	'protectsite-createaccount' => 'Dowolic, zo so konto załoži wot',
	'protectsite-createpage' => 'Dowolić, zo so strony wutworjeja wot',
	'protectsite-edit' => 'Dowolić, zo so strony wobdźěłuja wot',
	'protectsite-move' => 'Dowolić, zo so strony přesuwa wot',
	'protectsite-upload' => 'Dowolić, zo so dataje nahrawaja wot',
	'protectsite-timeout' => 'Překročenje časa',
	'protectsite-timeout-error' => "'''Njepłaćiwe překročenja časa.'''",
	'protectsite-maxtimeout' => 'Maksimum: $1',
	'protectsite-comment' => 'Komentar:',
	'protectsite-ucomment' => 'Komentar za wotstronjenje škita:',
	'protectsite-until' => 'Škitany hač do:',
	'protectsite-protect' => 'Škitać',
	'protectsite-unprotect' => 'Škit wotstronić',
	'protectsite-createaccount-0' => 'Wšitcy wužiwarjo',
	'protectsite-createaccount-1' => 'Zregistrowani wužiwarjo a administratorojo',
	'protectsite-createaccount-2' => 'Jenož administratorojo',
	'protectsite-createpage-0' => 'Wšitcy wužiwarjo',
	'protectsite-createpage-1' => 'Zregistrowani wužiwarjo a administratorojo',
	'protectsite-createpage-2' => 'Jenož administratorojo',
	'protectsite-edit-0' => 'Wšitcy wužiwarjo',
	'protectsite-edit-1' => 'Zregistrowani wužiwarjo a administratorojo',
	'protectsite-edit-2' => 'Jenož administratorojo',
	'protectsite-move-0' => 'Zregistrowani wužiwarjo a administratorojo',
	'protectsite-move-1' => 'Jenož administratorojo',
	'protectsite-upload-0' => 'Zregistrowani wužiwarjo a administratorojo',
	'protectsite-upload-1' => 'Jenož administratorojo',
	'right-protectsite' => 'Přewjedźomne akcije za wěste skupiny na wobmjezowany čas wobmjezować',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'protectsite' => 'Oldal védelme',
	'protectsite-title' => 'Oldal védelmi beállításai',
	'protectsite-allowall' => 'Összes felhasználó',
	'protectsite-allowsysop' => 'Csak adminisztrátorok',
	'protectsite-timeout' => 'Időtúllépés:',
	'protectsite-maxtimeout' => 'Legfeljebb:',
	'protectsite-comment' => 'Megjegyzés:',
	'protectsite-ucomment' => 'Védelem feloldása megjegyzés:',
	'protectsite-protect' => 'Védelem',
	'protectsite-unprotect' => 'Védelem feloldása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'protectsite' => 'Proteger sito',
	'protectsite-desc' => 'Permitte a un administrator del sito de blocar temporarimente varie modificationes del sito',
	'protectsite-text-protect' => '<!-- Instructiones/Commentos/Politica pro uso -->',
	'protectsite-text-unprotect' => '<!-- Instructiones/Commentos quando protegite -->',
	'protectsite-title' => 'Configuration del protection del sito',
	'protectsite-allowall' => 'Tote le usatores',
	'protectsite-allowusersysop' => 'Usatores registrate e administratores',
	'protectsite-allowsysop' => 'Administratores solmente',
	'protectsite-createaccount' => 'Permitter le creation de nove contos per',
	'protectsite-createpage' => 'Permitter le creation de paginas per',
	'protectsite-edit' => 'Permitter le modification de paginas per',
	'protectsite-move' => 'Permitter le renomination de paginas per',
	'protectsite-upload' => 'Permitter le incargamento de files per',
	'protectsite-timeout' => 'Expiration:',
	'protectsite-timeout-error' => "'''Expiration invalide.'''",
	'protectsite-maxtimeout' => 'Maximo: $1',
	'protectsite-comment' => 'Commento:',
	'protectsite-ucomment' => 'Commento de disprotection:',
	'protectsite-until' => 'Protegite usque a:',
	'protectsite-protect' => 'Proteger',
	'protectsite-unprotect' => 'Disproteger',
	'protectsite-createaccount-0' => 'Tote le usatores',
	'protectsite-createaccount-1' => 'Usatores registrate e administratores',
	'protectsite-createaccount-2' => 'Administratores solmente',
	'protectsite-createpage-0' => 'Tote le usatores',
	'protectsite-createpage-1' => 'Usatores registrate e administratores',
	'protectsite-createpage-2' => 'Administratores solmente',
	'protectsite-edit-0' => 'Tote le usatores',
	'protectsite-edit-1' => 'Usatores registrate e administratores',
	'protectsite-edit-2' => 'Administratores solmente',
	'protectsite-move-0' => 'Usatores registrate e administratores',
	'protectsite-move-1' => 'Administratores solmente',
	'protectsite-upload-0' => 'Usatores registrate e administratores',
	'protectsite-upload-1' => 'Administratores solmente',
	'right-protectsite' => 'Limitar actiones que pote esser exequite pro alcun gruppos durante un tempore limitate',
);

/** Indonesian (Bahasa Indonesia)
 * @author Kenrick95
 */
$messages['id'] = array(
	'protectsite-comment' => 'Komentar:',
	'protectsite-protect' => 'Lindungi',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'protectsite-allowall' => 'Tutti gli utenti',
	'protectsite-maxtimeout' => 'Massimo:',
	'protectsite-comment' => 'Oggetto:',
);

/** Japanese (日本語)
 * @author Tommy6
 * @author 青子守歌
 */
$messages['ja'] = array(
	'protectsite' => 'サイトの保護',
	'protectsite-text-protect' => '<!-- 利用時の方針/コメント/指示 -->',
	'protectsite-text-unprotect' => '<!-- 保護された時のコメント/指示 -->',
	'protectsite-title' => 'サイト保護の設定',
	'protectsite-allowall' => '全利用者',
	'protectsite-allowusersysop' => '登録利用者および管理者',
	'protectsite-allowsysop' => '管理者のみ',
	'protectsite-createaccount' => '新規アカウント作成を許可する利用者グループ',
	'protectsite-createpage' => 'ページ作成を許可する利用者グループ',
	'protectsite-edit' => '編集を許可する利用者グループ',
	'protectsite-move' => 'ページの移動を許可する利用者グループ',
	'protectsite-upload' => 'ファイルのアップロードを許可する利用者グループ',
	'protectsite-timeout' => '期間:',
	'protectsite-timeout-error' => "'''期間設定が不適切です'''",
	'protectsite-maxtimeout' => '最大:',
	'protectsite-comment' => '保護の理由:',
	'protectsite-ucomment' => '保護解除の理由:',
	'protectsite-until' => '保護期限：',
	'protectsite-protect' => '保護',
	'protectsite-unprotect' => '保護解除',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'protectsite-desc' => 'Löht dem Wiki sing Köbesse ongerscheidlijje Veränderonge aam Wiki op Zick verbeede.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'protectsite' => 'Site schützen',
	'protectsite-desc' => 'Erméiglecht et engem Administrateur vu engem Site fir verschidden Ännerungen um Site temporär ze spären',
	'protectsite-text-protect' => '<!-- Instruktiounen/Commentairen/Richtlinne fir de Gebrauch -->',
	'protectsite-text-unprotect' => '<!-- Instruktiounen/Bemierkunge wa gespaart -->',
	'protectsite-title' => 'Astellunge vun de Späre vum Site',
	'protectsite-allowall' => 'All Benotzer',
	'protectsite-allowusersysop' => 'Registréiert Benotzer an Administrateuren',
	'protectsite-allowsysop' => 'Nëmmen Administrateuren',
	'protectsite-createaccount' => 'Erlabe vum Uleeë vun neie Benotzerkonten duerch',
	'protectsite-createpage' => "Erlaabt d'Uleeë vu Säiten duerch",
	'protectsite-edit' => 'Erlabe vum Ännere vu Säiten duerch',
	'protectsite-move' => "D'Réckele vu Säiten erlaben fir",
	'protectsite-upload' => "D'Eropluede vu Fichieren erlaben fir",
	'protectsite-timeout' => 'Dauer vun der Spär:',
	'protectsite-timeout-error' => "'''Net valabel Dauer vun der Spär.'''",
	'protectsite-maxtimeout' => 'Maximum: $1',
	'protectsite-comment' => 'Bemierkung:',
	'protectsite-ucomment' => "Grond fir d'Ophiewe vun der Spär:",
	'protectsite-until' => 'Gespaart bis:',
	'protectsite-protect' => 'Spären',
	'protectsite-unprotect' => 'Spär ophiewen',
	'protectsite-createaccount-0' => 'All Benotzer',
	'protectsite-createaccount-1' => 'Registréiert Benotzer an Administrateuren',
	'protectsite-createaccount-2' => 'Nëmmen Administrateuren',
	'protectsite-createpage-0' => 'All Benotzer',
	'protectsite-createpage-1' => 'Registréiert Benotzer an Administrateuren',
	'protectsite-createpage-2' => 'Nëmmen Administrateuren',
	'protectsite-edit-0' => 'All Benotzer',
	'protectsite-edit-1' => 'Registréiert Benotzer an Administrateuren',
	'protectsite-edit-2' => 'Nëmmen Administrateuren',
	'protectsite-move-0' => 'Registréiert Benotzer an Administrateuren',
	'protectsite-move-1' => 'Nëmmen Administrateuren',
	'protectsite-upload-0' => 'Registréiert Benotzer an Administrateuren',
	'protectsite-upload-1' => 'Nëmmen Administrateuren',
	'right-protectsite' => 'Aktiounen déi vu bestëmmte Benotzergruppen während enger limitéierter Zäit agrenzen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'protectsite' => 'Заштити мреж. место',
	'protectsite-desc' => 'Му овозможува на администраторотпривремено да спречува разни измени на мреж-то место',
	'protectsite-text-protect' => '<!-- Инструкции/Коментари/Правила на употреба -->',
	'protectsite-text-unprotect' => '<!-- Инструкции/Коментари кога е заштитено -->',
	'protectsite-title' => 'Нагодувања на заштитата на мреж. место',
	'protectsite-allowall' => 'Сите корисници',
	'protectsite-allowusersysop' => 'Регистрирани корисници и систем-оператори',
	'protectsite-allowsysop' => 'Само систем-оператори',
	'protectsite-createaccount' => 'Дозволи создавање на нови сметки од',
	'protectsite-createpage' => 'Дозволи создавање на страници од',
	'protectsite-edit' => 'Дозволи уредување на страници од',
	'protectsite-move' => 'Дозволи преместување на страници од',
	'protectsite-upload' => 'Дозволи подигање на податотеки од',
	'protectsite-timeout' => 'Истекува:',
	'protectsite-timeout-error' => "'''Неважечки истек.'''",
	'protectsite-maxtimeout' => 'Максимум: $1',
	'protectsite-comment' => 'Коментар:',
	'protectsite-ucomment' => 'Тргни заштита од коментар:',
	'protectsite-until' => 'Заштитено до:',
	'protectsite-protect' => 'Заштити',
	'protectsite-unprotect' => 'Тргни заштита',
	'protectsite-createaccount-0' => 'Сите корисници',
	'protectsite-createaccount-1' => 'Регистрирани корисници и систем-оператори',
	'protectsite-createaccount-2' => 'Само систем-оператори',
	'protectsite-createpage-0' => 'Сите корисници',
	'protectsite-createpage-1' => 'Регистрирани корисници и систем-оператори',
	'protectsite-createpage-2' => 'Само систем-оператори',
	'protectsite-edit-0' => 'Сите корисници',
	'protectsite-edit-1' => 'Регистрирани корисници и систем-оператори',
	'protectsite-edit-2' => 'Само систем-оператори',
	'protectsite-move-0' => 'Регистрирани корисници и систем-оператори',
	'protectsite-move-1' => 'Само систем-оператори',
	'protectsite-upload-0' => 'Регистрирани корисници и систем-оператори',
	'protectsite-upload-1' => 'Само систем-оператори',
	'right-protectsite' => 'Привремено ограничете ги дејствата што можат да ги изведат извесни групи на корисници',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'protectsite' => 'Perlindungan tapak',
	'protectsite-desc' => 'Membolehkan pentadbir tapak menyekat pelbagai pengubahsuaian tapak buat sementara',
	'protectsite-text-protect' => '<!-- Arahan/Ulasan/Dasar penggunaan -->',
	'protectsite-text-unprotect' => '<!-- Arahan/Ulasan apabila dilindungi -->',
	'protectsite-title' => 'Tetapan perlindungan laman',
	'protectsite-allowall' => 'Semua pengguna',
	'protectsite-allowusersysop' => 'Pengguna yang berdaftar dan pentadbir',
	'protectsite-allowsysop' => 'Pentadbir sahaja',
	'protectsite-createaccount' => 'Benarkan pembukaan akaun baru oleh',
	'protectsite-createpage' => 'Benarkan penciptaan laman oleh',
	'protectsite-edit' => 'Benarkan penyuntingan laman oleh',
	'protectsite-move' => 'Benarkan pemindahan laman oleh',
	'protectsite-upload' => 'Benarkan muat naik fail oleh',
	'protectsite-timeout' => 'Tamat masa:',
	'protectsite-timeout-error' => "'''Tamat masa tidak sah.'''",
	'protectsite-maxtimeout' => 'Maksimum: $1',
	'protectsite-comment' => 'Ulasan:',
	'protectsite-ucomment' => 'Nyahlindung ulasan:',
	'protectsite-until' => 'Dilindungi hingga:',
	'protectsite-protect' => 'Lindungi',
	'protectsite-unprotect' => 'Nyahlindung',
	'protectsite-createaccount-0' => 'Semua pengguna',
	'protectsite-createaccount-1' => 'Pengguna yang berdaftar dan pentadbir',
	'protectsite-createaccount-2' => 'Pentadbir sahaja',
	'protectsite-createpage-0' => 'Semua pengguna',
	'protectsite-createpage-1' => 'Pengguna yang berdaftar dan pentadbir',
	'protectsite-createpage-2' => 'Pentadbir sahaja',
	'protectsite-edit-0' => 'Semua pengguna',
	'protectsite-edit-1' => 'Pengguna yang berdaftar dan pentadbir',
	'protectsite-edit-2' => 'Pentadbir sahaja',
	'protectsite-move-0' => 'Pengguna yang berdaftar dan pentadbir',
	'protectsite-move-1' => 'Pentadbir sahaja',
	'protectsite-upload-0' => 'Pengguna yang berdaftar dan pentadbir',
	'protectsite-upload-1' => 'Pentadbir sahaja',
	'right-protectsite' => 'Mengehadkan tindakan yang boleh dilakukan untuk sesetengah kumpulan buat masa yang terhad',
);

/** Mazanderani (مازِرونی)
 * @author محک
 */
$messages['mzn'] = array(
	'protectsite-unprotect' => 'موحافظت نکاردن',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'protectsite' => 'Beskytt side',
	'protectsite-text-protect' => '<!-- Instruksjoner/kommentarer/fremgangsmåte for bruk -->',
	'protectsite-text-unprotect' => '<!-- Instruksjoner/kommentarer når beskyttet -->',
	'protectsite-title' => 'Innstillinger for sidebeskyttelse',
	'protectsite-allowall' => 'Alle brukere',
	'protectsite-allowusersysop' => 'Registrerte brukere og systemoperatører',
	'protectsite-allowsysop' => 'Kun systemoperatører',
	'protectsite-createaccount' => 'Tillat opprettelse av nye kontoer av',
	'protectsite-createpage' => 'Tillat opprettelse av sider av',
	'protectsite-edit' => 'Tillat redigering av sider av',
	'protectsite-move' => 'Tillat flytting av sider av',
	'protectsite-upload' => 'Tillat filopplasting av',
	'protectsite-timeout' => 'Tidsavbrudd:',
	'protectsite-timeout-error' => "'''Ugyldig tidsavbrudd.'''",
	'protectsite-maxtimeout' => 'Maksimum:',
	'protectsite-comment' => 'Kommentar:',
	'protectsite-ucomment' => 'Opphev beskyttelse av kommentar:',
	'protectsite-until' => 'Beskyttet til:',
	'protectsite-protect' => 'Beskytt',
	'protectsite-unprotect' => 'Opphev beskyttelse',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'protectsite-comment' => 'टिप्पणी :',
);

/** Dutch (Nederlands)
 * @author Mark van Alphen
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'protectsite' => 'Beveilig site',
	'protectsite-desc' => 'Maakt het voor sitebeheerders mogelijk tijdelijk verschillende wijzigingen aan de site tegen te gaan',
	'protectsite-text-protect' => '<!-- Instructies/opmerkingen/beleid voor gebruik -->',
	'protectsite-text-unprotect' => '<!-- Instructies/opmerkingen als beveiligd -->',
	'protectsite-title' => 'Site beveilig instellingen',
	'protectsite-allowall' => 'Alle gebruikers',
	'protectsite-allowusersysop' => 'Geregistreerde gebruikers en beheerders',
	'protectsite-allowsysop' => 'Alleen beheerders',
	'protectsite-createaccount' => 'Sta creatie van nieuwe accounts toe voor',
	'protectsite-createpage' => "Sta creatie van pagina's toe voor",
	'protectsite-edit' => "Sta bewerken van pagina's toe voor",
	'protectsite-move' => "Sta hernoemen van pagina's toe voor",
	'protectsite-upload' => 'Sta bestand-uploads toe voor',
	'protectsite-timeout' => 'Verloop:',
	'protectsite-timeout-error' => "'''Ongeldig verloop.'''",
	'protectsite-maxtimeout' => 'Maximum: $1',
	'protectsite-comment' => 'Opmerking:',
	'protectsite-ucomment' => 'Beveiliging-opheffing opmerkingen:',
	'protectsite-until' => 'Beveiligd tot:',
	'protectsite-protect' => 'Beveilig',
	'protectsite-unprotect' => 'Beveiliging opheffen',
	'protectsite-createaccount-0' => 'Alle gebruikers',
	'protectsite-createaccount-1' => 'Geregistreerde gebruikers en beheerders',
	'protectsite-createaccount-2' => 'Alleen beheerders',
	'protectsite-createpage-0' => 'Alle gebruikers',
	'protectsite-createpage-1' => 'Geregistreerde gebruikers en beheerders',
	'protectsite-createpage-2' => 'Alleen beheerders',
	'protectsite-edit-0' => 'Alle gebruikers',
	'protectsite-edit-1' => 'Geregistreerde gebruikers en beheerders',
	'protectsite-edit-2' => 'Alleen beheerders',
	'protectsite-move-0' => 'Geregistreerde gebruikers en beheerders',
	'protectsite-move-1' => 'Alleen beheerders',
	'protectsite-upload-0' => 'Geregistreerde gebruikers en beheerders',
	'protectsite-upload-1' => 'Alleen beheerders',
	'right-protectsite' => 'Handelingen beperken die kunnen worden uitgevoerd voor sommige groepen voor een beperkte tijd',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'protectsite-comment' => 'Grund:',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'protectsite' => 'Zabezpiecz witrynę',
	'protectsite-allowsysop' => 'Tylko administratorzy',
	'protectsite-createaccount' => 'Zezwalaj na tworzenie nowych kont przez',
	'protectsite-createpage' => 'Zezwalaj na tworzenie stron przez',
	'protectsite-edit' => 'Zezwalaj na edycję stron przez',
	'protectsite-move' => 'Pozwól na przenoszenie stron przez',
	'protectsite-upload' => 'Pozwól na przesyłanie plików przez',
	'protectsite-timeout' => 'Limit czasu',
	'protectsite-maxtimeout' => 'Maksymalnie $1',
	'protectsite-comment' => 'Komentarz',
	'protectsite-protect' => 'Zabezpiecz',
	'protectsite-unprotect' => 'Odbezpiecz',
	'protectsite-createaccount-0' => 'Wszyscy użytkownicy',
	'protectsite-createaccount-1' => 'Zarejestrowani użytkownicy i administratorzy',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'protectsite' => 'Sit protet',
	'protectsite-text-protect' => '<!-- Istrussion/Coment/Polìtica për dovragi -->',
	'protectsite-text-unprotect' => '<!-- Istrussion/Coment quand protet -->',
	'protectsite-title' => 'Ampostassion ëd protession dël sit',
	'protectsite-allowall' => "Tùit j'utent",
	'protectsite-allowusersysop' => 'Utent registrà e aministrador',
	'protectsite-allowsysop' => 'Mach aministrador',
	'protectsite-createaccount' => 'Përmëtt creassion ëd neuv utent da',
	'protectsite-createpage' => 'Përmëtt creassion ëd pàgine da',
	'protectsite-edit' => 'Përmëtt modìfica ëd pàgine da',
	'protectsite-move' => 'Përmëtt tramuda ëd pàgine da',
	'protectsite-upload' => 'Përmëtt caria ëd pàgine da',
	'protectsite-timeout' => 'Timeout:',
	'protectsite-timeout-error' => "'''Timeout pa bon.'''",
	'protectsite-maxtimeout' => 'Màssim: $1',
	'protectsite-comment' => 'Coment:',
	'protectsite-ucomment' => 'Sprotegg coment:',
	'protectsite-until' => 'Protegg fin a:',
	'protectsite-protect' => 'Protet',
	'protectsite-unprotect' => 'Sprotet',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'protectsite-allowall' => 'ټول کارنان',
	'protectsite-protect' => 'ژغورل',
	'protectsite-unprotect' => 'نه ژغورل',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'protectsite' => 'Proteger o site',
	'protectsite-desc' => 'Permite que um administrador bloqueie temporariamente várias modificações do site',
	'protectsite-text-protect' => '<!-- Instruções/Comentários/Normas de utilização -->',
	'protectsite-text-unprotect' => '<!-- Instruções/Comentários quando sob protecção -->',
	'protectsite-title' => 'Configurações de protecção do site',
	'protectsite-allowall' => 'Todos os utilizadores',
	'protectsite-allowusersysop' => 'Utilizadores registrados e administradores',
	'protectsite-allowsysop' => 'Apenas administradores',
	'protectsite-createaccount' => 'Permitir a criação de contas novas por',
	'protectsite-createpage' => 'Permitir a criação de páginas por',
	'protectsite-edit' => 'Permitir a edição de páginas por',
	'protectsite-move' => 'Permitir a movimentação de páginas por',
	'protectsite-upload' => 'Permitir o envio de ficheiros por',
	'protectsite-timeout' => 'Prazo de expiração:',
	'protectsite-timeout-error' => "'''Prazo de expiração inválido.'''",
	'protectsite-maxtimeout' => 'Máximo: $1',
	'protectsite-comment' => 'Comentário:',
	'protectsite-ucomment' => 'Comentário de desprotecção:',
	'protectsite-until' => 'Sob protecção até:',
	'protectsite-protect' => 'Proteger',
	'protectsite-unprotect' => 'Desproteger',
	'protectsite-createaccount-0' => 'Todos os utilizadores',
	'protectsite-createaccount-1' => 'Utilizadores registrados e administradores',
	'protectsite-createaccount-2' => 'Apenas administradores',
	'protectsite-createpage-0' => 'Todos os utilizadores',
	'protectsite-createpage-1' => 'Utilizadores registrados e administradores',
	'protectsite-createpage-2' => 'Apenas administradores',
	'protectsite-edit-0' => 'Todos os utilizadores',
	'protectsite-edit-1' => 'Utilizadores registrados e administradores',
	'protectsite-edit-2' => 'Apenas administradores',
	'protectsite-move-0' => 'Utilizadores registrados e administradores',
	'protectsite-move-1' => 'Apenas administradores',
	'protectsite-upload-0' => 'Utilizadores registrados e administradores',
	'protectsite-upload-1' => 'Apenas administradores',
	'right-protectsite' => 'Limitar as operações que alguns grupos podem realizar por um tempo limitado',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'protectsite-allowall' => 'Todos os usuários',
	'protectsite-allowusersysop' => 'Usuários registrados e administradores',
	'protectsite-allowsysop' => 'Somente administradores',
	'protectsite-maxtimeout' => 'Máximo:',
	'protectsite-protect' => 'Proteger',
	'protectsite-unprotect' => 'Desproteger',
);

/** Russian (Русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'protectsite' => 'Защита сайта',
	'protectsite-text-protect' => '<!-- Инструкции/Комментарии/Правила для использования -->',
	'protectsite-text-unprotect' => '<!-- Инструкции/Комментарии при установленной защите -->',
	'protectsite-title' => 'Настройки защиты сайта',
	'protectsite-allowall' => 'Всем участникам',
	'protectsite-allowusersysop' => 'Зарегистрированным участникам и администраторам',
	'protectsite-allowsysop' => 'Только администраторам',
	'protectsite-createaccount' => 'Разрешить создание новых учётных записей',
	'protectsite-createpage' => 'Разрешить создание страниц',
	'protectsite-edit' => 'Разрешить правку страниц',
	'protectsite-move' => 'Разрешить переименование страниц',
	'protectsite-upload' => 'Разрешить загрузку файлов',
	'protectsite-timeout' => 'Время истечения:',
	'protectsite-timeout-error' => "'''Неверное время истечения.'''",
	'protectsite-maxtimeout' => 'Максимум:',
	'protectsite-ucomment' => 'Комментарий снятия защиты:',
	'protectsite-until' => 'Защищено до:',
	'protectsite-protect' => 'Защитить',
	'protectsite-unprotect' => 'Снять защиту',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'protectsite-allowall' => 'Сви корисници',
	'protectsite-allowusersysop' => 'Уписани корисници и администратори',
	'protectsite-allowsysop' => 'Само администратори',
	'protectsite-createpage' => 'Дозволи стварање страница од',
	'protectsite-edit' => 'Дозволи уређивање страна од стране',
	'protectsite-move' => 'Дозволи преусмеравање страна од стране',
	'protectsite-timeout' => 'Истиче:',
	'protectsite-maxtimeout' => 'Највише: $1',
	'protectsite-comment' => 'Коментар:',
	'protectsite-ucomment' => 'Скини заштиту са коментара:',
	'protectsite-until' => 'Заштићено до:',
	'protectsite-protect' => 'Заштити',
	'protectsite-unprotect' => 'Скини заштиту',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'protectsite-allowall' => 'Svi korisnici',
	'protectsite-allowusersysop' => 'Upisani korisnici i administratori',
	'protectsite-allowsysop' => 'Samo administratori',
	'protectsite-createpage' => 'Dozvoli stvaranje stranica od',
	'protectsite-edit' => 'Dozvoli uređivanje strana od strane',
	'protectsite-move' => 'Dozvoli preusmeravanje strana od strane',
	'protectsite-timeout' => 'Ističe:',
	'protectsite-maxtimeout' => 'Najviše: $1',
	'protectsite-comment' => 'Komentar:',
	'protectsite-ucomment' => 'Skini zaštitu sa komentara:',
	'protectsite-until' => 'Zaštićeno do:',
	'protectsite-protect' => 'Zaštiti',
	'protectsite-unprotect' => 'Skini zaštitu',
);

/** Swedish (Svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'protectsite' => 'Skydda sida',
	'protectsite-desc' => 'Låter en administratör tillfälligt blockera olika sidändringar',
	'protectsite-text-protect' => '<!-- Instruktioner/Kommentarer/Policy för användning -->',
	'protectsite-text-unprotect' => '<!-- Instruktioner/Kommentarer när skyddad -->',
	'protectsite-title' => 'Inställningar för sidskydd',
	'protectsite-allowall' => 'Alla användare',
	'protectsite-allowusersysop' => 'Registrerade användare och administratörer',
	'protectsite-allowsysop' => 'Endast administratörer',
	'protectsite-createaccount' => 'Tillåt skapande av nya konton av',
	'protectsite-createpage' => 'Tillåt skapande av sidor av',
	'protectsite-edit' => 'Tillåt redigering av sidor av',
	'protectsite-move' => 'Tillåt flyttning av sidor av',
	'protectsite-upload' => 'Tillåt filuppladdningar av',
	'protectsite-timeout' => 'Tidsuppehåll:',
	'protectsite-timeout-error' => "'''Ogiltigt tidsuppehåll.'''",
	'protectsite-maxtimeout' => 'Maximalt: $1',
	'protectsite-comment' => 'Kommentar:',
	'protectsite-ucomment' => 'Ta bort skydd från kommentar:',
	'protectsite-until' => 'Skyddad till:',
	'protectsite-protect' => 'Skydda',
	'protectsite-unprotect' => 'Ta bort skydd',
	'protectsite-createaccount-0' => 'Alla användare',
	'protectsite-createaccount-1' => 'Registrerade användare och administratörer',
	'protectsite-createaccount-2' => 'Endast administratörer',
	'protectsite-createpage-0' => 'Alla användare',
	'protectsite-createpage-1' => 'Registrerade användare och administratörer',
	'protectsite-createpage-2' => 'Endast administratörer',
	'protectsite-edit-0' => 'Alla användare',
	'protectsite-edit-1' => 'Registrerade användare och administratörer',
	'protectsite-edit-2' => 'Endast administratörer',
	'protectsite-move-0' => 'Registrerade användare och administratörer',
	'protectsite-move-1' => 'Endast administratörer',
	'protectsite-upload-0' => 'Registrerade användare och administratörer',
	'protectsite-upload-1' => 'Endast administratörer',
	'right-protectsite' => 'Begränsa åtgärder som kan utföras för vissa grupper under en begränsad tid',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'protectsite-text-protect' => '<!-- ఉపయోగించడానికి సూచనలు/వ్యాఖ్యలు/విధానం -->',
	'protectsite-title' => 'సైటు సంరక్షణ అమరికలు',
	'protectsite-allowall' => 'అందరు వాడుకరులు',
	'protectsite-allowusersysop' => 'నమోదైన వాడుకరులు మరియు నిర్వాహకులు',
	'protectsite-allowsysop' => 'నిర్వాహకులు మాత్రమే',
	'protectsite-maxtimeout' => 'గరిష్ఠం: $1',
	'protectsite-comment' => 'వ్యాఖ్య:',
	'protectsite-protect' => 'సంరక్షించు',
	'protectsite-createaccount-0' => 'వాడుకరులందరూ',
	'protectsite-createaccount-1' => 'నమోదైన వాడుకరులు మరియు నిర్వాహకులు',
	'protectsite-createaccount-2' => 'నిర్వాహకులు మాత్రమే',
	'protectsite-createpage-0' => 'వాడుకరులందరూ',
	'protectsite-createpage-1' => 'నమోదైన వాడుకరులు మరియు నిర్వాహకులు',
	'protectsite-createpage-2' => 'నిర్వాహకులు మాత్రమే',
	'protectsite-edit-0' => 'వాడుకరులందరూ',
	'protectsite-edit-1' => 'నమోదైన వాడుకరులు మరియు నిర్వాహకులు',
	'protectsite-edit-2' => 'నిర్వాహకులు మాత్రమే',
	'protectsite-move-0' => 'నమోదైన వాడుకరులు మరియు నిర్వాహకులు',
	'protectsite-move-1' => 'నిర్వాహకులు మాత్రమే',
	'protectsite-upload-0' => 'నమోదైన వాడుకరులు మరియు నిర్వాహకులు',
	'protectsite-upload-1' => 'నిర్వాహకులు మాత్రమే',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'protectsite' => 'Prutektahan ang sayt',
	'protectsite-desc' => 'Nagpapahintulot sa isang tagapangasiwa ng sityo upang pansamantalang hadlangan ang sari-saring mga pagbabago sa sityo',
	'protectsite-text-protect' => '<!-- Magagamit na mga tagubilin/Mga puna/Patakaran -->',
	'protectsite-text-unprotect' => '<!-- Mga tagubilin/Mga puna kapag nakasanggalang -->',
	'protectsite-title' => 'Mga katakdaang pamprutekta ng sityo',
	'protectsite-allowall' => 'Lahat ng mga tagagamit',
	'protectsite-allowusersysop' => 'Nakatalang mga tagagamit at mga tagapagpaandar ng sistema',
	'protectsite-allowsysop' => 'Mga tagapagpaandar lang ng sistema',
	'protectsite-createaccount' => 'Ipahintulot ang paglikha ng bagong mga akawnt sa pamamagitan ng',
	'protectsite-createpage' => 'Ipahintulot ang paglikha ng pahina sa pamamagitan ng',
	'protectsite-edit' => 'Pahintulutan ang pamamatnugot ng mga pahina sa pamamagitan ng',
	'protectsite-move' => 'Ipahintulot ang paglipat ng mga pahina sa pamamagitan ng',
	'protectsite-upload' => 'Ipahintulot ang paitaas na pagkakarga ng mga talaksan sa pamamagitan ng',
	'protectsite-timeout' => 'Pamamahinga:',
	'protectsite-timeout-error' => "'''Hindi Tanggap na Pamamahinga.'''",
	'protectsite-maxtimeout' => 'Pinakamataas: $1',
	'protectsite-comment' => 'Puna:',
	'protectsite-ucomment' => 'Huwag prutektahan ang puna:',
	'protectsite-until' => 'Isanggalang hanggang:',
	'protectsite-protect' => 'Isanggalang',
	'protectsite-unprotect' => 'Huwag isanggalang',
	'protectsite-createaccount-0' => 'Lahat ng mga tagagamit',
	'protectsite-createaccount-1' => 'Nagpatalang mga tagagamit at mga tagapangasiwa',
	'protectsite-createaccount-2' => 'Mga tagapangasiwa lamang',
	'protectsite-createpage-0' => 'Lahat ng mga tagagamit',
	'protectsite-createpage-1' => 'Nagpatalang mga tagagamit at mga tagapangasiwa',
	'protectsite-createpage-2' => 'Mga tagapangasiwa lamang',
	'protectsite-edit-0' => 'Lahat ng mga tagagamit',
	'protectsite-edit-1' => 'Nagpatalang mga tagagamit at mga tagapangasiwa',
	'protectsite-edit-2' => 'Mga tagapangasiwa lamang',
	'protectsite-move-0' => 'Nagpatalang mga tagagamit at mga tagapangasiwa',
	'protectsite-move-1' => 'Mga tagapangasiwa lamang',
	'protectsite-upload-0' => 'Nagpatalang mga tagagamit at mga tagapangasiwa',
	'protectsite-upload-1' => 'Mga tagapangasiwa lamang',
	'right-protectsite' => 'Hangganan ang mga kilos na maaaring ganapin para sa ilang mga pangkat sa loob ng hinahanggahang panahon',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'protectsite-title' => 'Налаштування захисту сайту',
	'protectsite-comment' => 'Коментар:',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'protectsite-allowall' => 'אַלע באַניצערס',
	'protectsite-protect' => 'שיצן',
	'protectsite-unprotect' => 'אראפנעמען שיץ',
	'protectsite-createaccount-0' => 'אַלע באַניצערס',
	'protectsite-createaccount-1' => 'איינגעשריבענע באניצער און סיסאפן',
	'protectsite-createaccount-2' => 'נאר סיסאפן',
	'protectsite-createpage-0' => 'אַלע באַניצער',
	'protectsite-createpage-1' => 'איינגעשריבענע באניצער און סיסאפן',
	'protectsite-createpage-2' => 'נאר סיסאפן',
	'protectsite-edit-0' => 'אַלע באַניצערס',
	'protectsite-edit-1' => 'איינגעשריבענע באניצער און סיסאפן',
	'protectsite-edit-2' => 'נאר סיסאפן',
	'protectsite-move-0' => 'איינגעשריבענע באניצער און סיסאפן',
	'protectsite-move-1' => 'נאר סיסאפן',
	'protectsite-upload-0' => 'איינגעשריבענע באניצער און סיסאפן',
	'protectsite-upload-1' => 'נאר סיסאפן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'protectsite-protect' => '保护',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'protectsite-protect' => '保護',
);

