<?php

$messages = array();

$messages['en'] = array(
	'userprofilepage-desc' => 'Provides a user page that is fun and easy to update',

	'userprofilepage-edit-avatar-label' => 'Edit picture',
	'userprofilepage-users-notes-title' => 'About me',
	'userprofilepage-about-section-title' => 'My $1 interview',
	'userprofilepage-edit-button' => 'Edit',
	'userprofilepage-about-article-title' => 'About',
	'userprofilepage-about-empty-section' => 'This section is empty. Click edit to add some stuff here!',
	'userprofilepage-edit-permision-denied' => 'Edit permissions denied',
	'userprofilepage-edit-permision-denied-info' => 'You do not have permissions to edit somebody\'s user page or subpage',
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">Everyone on this wiki would love to know more about you!</div><a href="$1">Edit this section</a> to add more about yourself and tell us about the things you love.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 hasn\'t added any information yet.</div>You can <a href="$2">leave them a message</a> instead',
	'userprofilepage-user-doesnt-exists' => 'The user $1 does not exist on Wikia. Check out [[Special:WikiActivity|Wiki Activity]] to see who is active on this wiki.',
	'userprofilepage-user-anon' => 'This user hasn\'t registered on Wikia yet. [[Special:Signup|Sign up]] to register an account and claim edit points, badges and appreciation from your fellow editors!',
	
	// Masthead
	'userprofilepage-leave-message' => 'Leave message',
	'userprofilepage-edits-since' => 'Edits since joining this wiki<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 edited the <a href="$2">$3</a> page',
	'userprofilepage-user-last-action-new' => '$1 created <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 deleted the <a href="$2">$3</a> page',
        'userprofilepage-user-group-sysop' => 'Admin',
        'userprofilepage-user-group-staff' => 'Staff member',
        'userprofilepage-user-group-bot' => 'Bot',
        'userprofilepage-user-group-bureaucrat' => 'Bureaucrat',
        'userprofilepage-user-group-helper' => 'Helper',
	'userprofilepage-user-group-vstf' => 'VSTF',
	'userprofilepage-user-group-sysop-tooltip' => 'This user is an Admin on this wiki',
        'userprofilepage-user-group-staff-tooltip' => 'This user is a Wikia Staff member',
        'userprofilepage-user-group-bot-tooltip' => 'This user is a Bot',
        'userprofilepage-user-group-bureaucrat-tooltip' => 'This user is a Bureaucrat on this wiki',
        'userprofilepage-user-group-helper-tooltip' => 'This user is an Helper',
	'userprofilepage-user-group-vstf-tooltip' => 'This user is a member of the Spam Task Force',

	//Top Wikis
	'userprofilepage-top-wikis-title' => '$1\'s Top wikis',
	'userprofilepage-top-wikis-edit-count' => 'Number of Edits',
	'userprofilepage-top-wikis-hidden-see-more' => 'You have hidden {{PLURAL:$1|$1 wiki|$1 wikis}}',
	'userprofilepage-top-wikis-unhide-label' => 'unhide',
	'userprofilepage-top-wikis-hide-label' => 'hide',
	'userprofilepage-top-wikis-locked-label' => 'The current wiki can\'t be hidden',

	//Recent activity
	'userprofilepage-recent-activity-title' => '$1\'s recent activity',
	'userprofilepage-activity-edit'    => 'edited the $1 page',
	'userprofilepage-activity-new'     => 'created $1',
	'userprofilepage-activity-comment' => 'commented on $1',
	'userprofilepage-activity-image'   => 'uploaded an image to $1',
	'userprofilepage-activity-video'   => 'uploaded a video to $1',
	'userprofilepage-activity-delete'  => 'deleted the $1 page',
	'userprofilepage-activity-talk'    => 'left a message on $1\'s talk page',
	'userprofilepage-recent-activity-default' => '$1 has joined Wikia',
	'userprofilepage-top-recent-activity-see-more' => 'See all &gt;',

	//Top pages
	'userprofilepage-top-pages-title' => '$1\'s Top $2 Pages',
	'userprofilepage-top-page-unhide-label' => 'unhide',
	'userprofilepage-top-pages-hidden-see-more' => 'You have hidden {{PLURAL:$1|$1 page|$1 pages}}',
	'userprofilepage-top-pages-default' => 'You do not have any top pages yet. Why not check out some <a href="$1">random pages</a> on the wiki?',

	'recipes-template-aboutuser-fields' => '* wpTitle
** type|input
** label|title
** hint|title
** hintHideable|true
** required|true
** readOnly|true
* wpDescription
** type|input
** label|user-description
** hint|user-description
** hintHideable|true
** required|true
* wpBirthDate
** type|input
** label|user-birthdate
** hint|user-birthdate
** hintHideable|true
* wpSpecies
** type|input
** label|user-species
** hint|user-species
** hintHideable|true
* wpAbilities
** type|input
** label|user-abilities
** hint|user-abilities
** hintHideable|true
* wpGender
** type|input
** label|user-gender
** hint|user-gender
** hintHideable|true
* wpAffiliation
** type|input
** label|user-affiliation
** hint|user-affiliation
** hintHideable|true',
	'recipes-template-skip-toggle-types' => 'aboutuser',
	'recipes-template-user-description-label' => 'Description',
	'recipes-template-user-description-hint' => 'Short info about the user',
	'recipes-template-user-birthdate-label' => 'Birth date',
	'recipes-template-user-birthdate-hint' => 'Date of birth (in any format)',
	'recipes-template-user-species-label' => 'Species',
	'recipes-template-user-species-hint' => 'Species',
	'recipes-template-user-abilities-label' => 'Abilities',
	'recipes-template-user-abilities-hint' => 'Abilities',
	'recipes-template-user-gender-label' => 'Gender',
	'recipes-template-user-gender-hint' => 'Gender',
	'recipes-template-user-affiliation-label' => 'Affiliation',
	'recipes-template-user-affiliation-hint' => 'Affiliation',
	'recipes-template-aboutuser-wikitext' => '<!--Change at your own risk //--><div class="interview">
*<div class="question">How would you describe yourself?</div>
*<div class="answer"><<wpDescription>></div>
*<div class="question">When did you born?</div>
*<div class="answer"><<wpBirthDate>></div>
*<div class="question">What\'s your species?</div>
*<div class="answer"><<wpSpecies>></div>

*<div class="question">What are your abilities?</div>
*<div class="answer"><<wpAbilities>></div>
*<div class="question">What\'s your gender?</div>
*<div class="answer"><<wpGender>></div>
*<div class="question">Do you have any affiliation?</div>
*<div class="answer"><<wpAffiliation>></div></div>',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'userprofilepage-user-group-vstf' => 'See also {{msg-mw|Userprofilepage-user-group-vstf-tooltip}} as it defines "STF".
FIXME: What does the "V" initial stands for ?',
	'userprofilepage-top-pages-title' => 'Parameters:
* $1 is a username
* $2 is a wiki name',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'userprofilepage-edit-avatar-label' => 'Wysig foto',
	'userprofilepage-users-notes-title' => 'Oor my',
	'userprofilepage-edit-button' => 'Wysig',
	'userprofilepage-about-article-title' => 'Aangaande',
	'userprofilepage-user-doesnt-exists' => 'Die gebruiker $1 bestaan nie',
	'userprofilepage-leave-message' => "Laat 'n boodskap",
	'userprofilepage-user-last-action-edit' => '$1 het die bladsy <a href="$2">$3</a> gewysig',
	'userprofilepage-user-last-action-new' => '$1 het <a href="$2">$3</a> geskep',
	'userprofilepage-user-last-action-delete' => '$1 het die bladsy <a href="$2">$3</a> verwyder',
	'userprofilepage-user-group-sysop' => 'Administrateur',
	'userprofilepage-user-group-staff' => 'Personeellid',
	'userprofilepage-user-group-bot' => 'Robot',
	'userprofilepage-user-group-bureaucrat' => 'Burokraat',
	'userprofilepage-user-group-helper' => 'Helper',
	'userprofilepage-top-wikis-edit-count' => 'Aantal wysigings',
	'userprofilepage-top-wikis-unhide-label' => 'wys',
	'userprofilepage-top-wikis-hide-label' => 'versteek',
	'userprofilepage-recent-activity-title' => 'Onlangse aktiwiteite van $1',
	'userprofilepage-activity-new' => 'het $1 geskap',
	'userprofilepage-activity-comment' => "het 'n opmerking gemaak by $1",
	'userprofilepage-activity-image' => "het 'n beeld opgelaai by $1",
	'userprofilepage-activity-video' => "het 'n video opgelaai by $1",
	'userprofilepage-activity-delete' => 'het die bladsy $1 verwyder',
	'userprofilepage-recent-activity-default' => '$1 hat by Wikia aangesluit',
	'userprofilepage-top-recent-activity-see-more' => 'Wys alles',
	'userprofilepage-top-page-unhide-label' => 'wys',
	'recipes-template-user-description-label' => 'Beskrywing',
	'recipes-template-user-description-hint' => 'Kort opsomming van die gebruiker',
	'recipes-template-user-birthdate-label' => 'Geboortedatum',
	'recipes-template-user-birthdate-hint' => 'Geboortedatum (in enige formaat)',
	'recipes-template-user-species-label' => 'Soort',
	'recipes-template-user-species-hint' => 'Soort',
	'recipes-template-user-abilities-label' => 'Vaardighede',
	'recipes-template-user-abilities-hint' => 'Vaardighede',
	'recipes-template-user-gender-label' => 'Geslag',
	'recipes-template-user-gender-hint' => 'Geslag',
	'recipes-template-user-affiliation-label' => 'Affiliasie',
	'recipes-template-user-affiliation-hint' => 'Affiliasie',
);

/** Assamese (অসমীয়া) */
$messages['as'] = array(
	'userprofilepage-edit-avatar-label' => 'চিত্ৰ সম্পাদনা',
	'userprofilepage-users-notes-title' => 'মোৰ বিষয়ে',
	'userprofilepage-edit-button' => 'সম্পাদনা',
	'userprofilepage-about-article-title' => 'বিষয়ে',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'userprofilepage-edit-avatar-label' => 'Kemmañ ar skeudenn',
	'userprofilepage-users-notes-title' => 'Diwar ma fenn',
	'userprofilepage-about-section-title' => 'Ma $1 atersadenn',
	'userprofilepage-edit-button' => 'Kemmañ',
	'userprofilepage-about-article-title' => 'Diwar-benn',
	'userprofilepage-about-empty-section' => 'Goullo eo ar rann-mañ. Klikit war kemmañ evit ouzhpennañ danvez amañ !',
	'userprofilepage-edit-permision-denied-info' => "N'ho peus ket aotre da gemmañ pajenn pe ispajenn implijer unan bennak",
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">An holl war ar wiki-mañ a garfe gouzout un tamm hiroc\'h war ho penn !</div><a href="$1">Kemmañ ar rann-mañ</a> evit ouzhpennañ muioc\'h a draoù diwarnoc\'h ha lavarit deomp ar pezh a blij deoc\'h.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 n\'en deus ket ouzhpennet titouroù c\'hoazh.</div>Gellout a rit <a href="$2">lezel ur gemennadenn dezho</a> e plas',
	'userprofilepage-user-doesnt-exists' => "N'eus ket eus an implijer $1",
	'userprofilepage-leave-message' => 'Lezel ur gemennadenn',
	'userprofilepage-edits-since' => 'Kemmoù abaoe bezañ erruet war ar wiki-mañ<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 en deus kemmet ar bajenn <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 en deus krouet <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 en deus dilamet ar bajenn <a href="$2">$3</a>',
	'userprofilepage-user-group-sysop' => 'Merour',
	'userprofilepage-user-group-bot' => 'Bot',
	'userprofilepage-user-group-bureaucrat' => 'Bureviad',
	'userprofilepage-user-group-helper' => 'Skoazeller',
	'userprofilepage-user-group-sysop-tooltip' => 'An implijer-mañ a zo Merour war ar wiki-mañ',
	'userprofilepage-user-group-bot-tooltip' => 'An implijer-mañ a zo ur Bot',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'An implijer-mañ a zo Bureviad war ar wiki-mañ',
	'userprofilepage-user-group-helper-tooltip' => 'An implijer-mañ a zo Skoazeller war ar wiki-mañ',
	'userprofilepage-top-wikis-title' => 'Top wikioù $1',
	'userprofilepage-top-wikis-edit-count' => 'Niver a gemmoù',
	'userprofilepage-top-wikis-hidden-see-more' => 'Kuzhet ho peus {{PLURAL:$1|$1 wiki|$1 wiki}}',
	'userprofilepage-top-wikis-unhide-label' => 'diskouez',
	'userprofilepage-top-wikis-hide-label' => 'kuzhat',
	'userprofilepage-top-wikis-locked-label' => "Ne c'hell ket bezañ kuzhet ar wiki red",
	'userprofilepage-recent-activity-title' => 'Obererezh nevez $1',
	'userprofilepage-activity-edit' => 'zo bet kemmet ar bajenn $1 gantañ/ganti',
	'userprofilepage-activity-new' => 'krouet $1',
	'userprofilepage-activity-image' => 'en deus enporzhiet ur skeudenn war $1',
	'userprofilepage-activity-video' => 'en deus enporzhiet ur video war $1',
	'userprofilepage-activity-delete' => 'en deus dilamet ar bajenn $1',
	'userprofilepage-activity-talk' => 'en deus laosket ur gemennadenn war pajenn kaozeadenn $1',
	'userprofilepage-recent-activity-default' => '$1 a zo deuet war Wikia',
	'userprofilepage-top-recent-activity-see-more' => 'Gwelet pep tra',
	'userprofilepage-top-pages-title' => 'Pajennoù wellañ $1 war $2',
	'userprofilepage-top-page-unhide-label' => 'diskouez',
	'userprofilepage-top-pages-hidden-see-more' => 'Kuzhet ho peus {{PLURAL:$1|$1 bajenn|$1 pajenn}}',
	'recipes-template-user-description-label' => 'Deskrivadur',
	'recipes-template-user-description-hint' => 'Titouroù berr diwar-benn an implijer',
	'recipes-template-user-birthdate-label' => 'Deiziad ganedigezh',
	'recipes-template-user-birthdate-hint' => 'Deiziad ganedigezh (e forzh peseurt stumm)',
	'recipes-template-user-species-label' => 'Spesadoù',
	'recipes-template-user-species-hint' => 'Spesadoù',
	'recipes-template-user-abilities-label' => 'Barregezhioù',
	'recipes-template-user-abilities-hint' => 'Barregezhioù',
	'recipes-template-user-gender-label' => 'Jener',
	'recipes-template-user-gender-hint' => 'Jener',
	'recipes-template-user-affiliation-label' => 'Emezeladur',
	'recipes-template-user-affiliation-hint' => 'Emezeladur',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'userprofilepage-desc' => 'Daje mogućnost da se korisička stranica lahko i zabavno ažurira',
	'userprofilepage-edit-avatar-label' => 'Uredi sliku',
	'userprofilepage-users-notes-title' => 'O meni',
	'userprofilepage-about-section-title' => 'Moj $1 intervju',
	'userprofilepage-edit-button' => 'Uredi',
	'userprofilepage-about-article-title' => 'O',
	'userprofilepage-about-empty-section' => 'Ova sekcija je prazna. Kliknite na uredi da dodate nešto ovdje!',
	'userprofilepage-edit-permision-denied' => 'Uređivanje dopuštenja nije dozvoljeno',
	'userprofilepage-edit-permision-denied-info' => 'Nemate dopuštenja da uređujete nečiju korisničku stranicu ili podstranicu',
	'userprofilepage-leave-message' => 'Ostavite poruku',
	'userprofilepage-edits-since' => 'Izmjena od kako se pridružio ovoj wiki<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 je uredio stranicu <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 je napravio stranicu <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 je obrisao stranicu <a href="$2">$3</a>',
	'userprofilepage-top-wikis-title' => 'Najbolji wikiji od $1',
	'userprofilepage-top-wikis-edit-count' => 'Broj izmjena',
	'userprofilepage-top-wikis-hidden-see-more' => 'Sakrili ste {{PLURAL:$1|$1 wiki|$1 wikija}}',
	'userprofilepage-top-wikis-unhide-label' => 'otkrij',
	'userprofilepage-top-wikis-hide-label' => 'sakrij',
	'userprofilepage-recent-activity-title' => 'nedavna aktivnost od $1',
	'userprofilepage-activity-edit' => 'uređivao je $1 stranicu',
	'userprofilepage-activity-new' => 'je napravio $1',
	'userprofilepage-top-recent-activity-see-more' => 'Vidi sve',
	'userprofilepage-top-pages-title' => 'Najbolje $2 stranice korisnika $1',
	'userprofilepage-top-page-unhide-label' => 'otkrij',
	'recipes-template-user-description-label' => 'Opis',
	'recipes-template-user-description-hint' => 'Kratki podaci o korisniku',
	'recipes-template-user-birthdate-label' => 'Datum rođenja',
	'recipes-template-user-birthdate-hint' => 'Datum rođenja (bilo koji format)',
	'recipes-template-user-species-label' => 'Vrste',
	'recipes-template-user-species-hint' => 'Vrste',
	'recipes-template-user-abilities-label' => 'Sposobnosti',
	'recipes-template-user-abilities-hint' => 'Sposobnosti',
	'recipes-template-user-gender-label' => 'Spol',
	'recipes-template-user-gender-hint' => 'Spol',
	'recipes-template-user-affiliation-label' => 'Naklonost',
	'recipes-template-user-affiliation-hint' => 'Naklonost',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'userprofilepage-user-group-bot' => 'Шаболххо',
	'userprofilepage-user-group-bureaucrat' => 'Даржахо',
	'recipes-template-user-gender-label' => 'Ву/Йу',
	'recipes-template-user-gender-hint' => 'Ву/Йу',
);

/** German (Deutsch)
 * @author George Animal
 */
$messages['de'] = array(
	'userprofilepage-user-group-bureaucrat' => 'Bürokrat',
	'userprofilepage-user-group-helper' => 'Helfer',
	'recipes-template-user-birthdate-label' => 'Geburtsdatum:',
	'recipes-template-user-gender-label' => 'Geschlecht',
	'recipes-template-user-gender-hint' => 'Geschlecht',
	'recipes-template-user-affiliation-label' => 'Zugehörigkeit',
);

/** Spanish (Español)
 * @author VegaDark
 */
$messages['es'] = array(
	'userprofilepage-desc' => 'Proporciona una página de usuario que es divertida y fácil de actualizar',
	'userprofilepage-edit-avatar-label' => 'Editar imagen',
	'userprofilepage-users-notes-title' => 'Acerca de mí',
	'userprofilepage-about-section-title' => 'Mi $1 entrevista',
	'userprofilepage-edit-button' => 'Editar',
	'userprofilepage-about-article-title' => 'Acerca de',
	'userprofilepage-about-empty-section' => 'Esta sección está vacía. ¡Haz clic en editar para añadir algunas cosas aquí!',
	'userprofilepage-edit-permision-denied' => 'Permisos de edición denegados',
	'userprofilepage-edit-permision-denied-info' => 'No tienes los permisos para editar la página o subpágina de otros',
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">¡Toda la comunidad de esta wiki le gustaría saber más de ti!</div><a href="$1">Edita esta sección</a> para añadir más información sobre ti y dinos acerca de las cosas que te gustan.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 no ha añadido ninguna información aún.</div>Puedes <a href="$2">dejarles un mensaje</a>',
	'userprofilepage-user-doesnt-exists' => 'El usuario $1 no existe en Wikia. Revisa la [[Special:WikiActivity|Wiki Actividad]] para ver quién está activo en esta wiki.',
	'userprofilepage-user-anon' => 'Este usuario no se ha registrado aún en Wikia. ¡[[Special:Signup|Regístrate]] una cuenta nueva y reclama puntos de edición, logros y apreciaciones de tus amigos editores!',
	'userprofilepage-leave-message' => 'Dejar un mensaje',
	'userprofilepage-edits-since' => 'Ediciones desde que se unió a la wiki<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 editó la página <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 creó <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 borró la página <a href="$2">$3</a>',
	'userprofilepage-user-group-sysop' => 'Administrador',
	'userprofilepage-user-group-staff' => 'Staff de Wikia',
	'userprofilepage-user-group-bot' => 'Bot',
	'userprofilepage-user-group-bureaucrat' => 'Burócrata',
	'userprofilepage-user-group-helper' => 'Helper de Wikia',
	'userprofilepage-user-group-vstf' => 'Miembro del Spam Task Force',
	'userprofilepage-user-group-sysop-tooltip' => 'Este usuario es un Administrador en esta wiki',
	'userprofilepage-user-group-staff-tooltip' => 'Este usuario es un miembro del Staff de Wikia',
	'userprofilepage-user-group-bot-tooltip' => 'Este usuario es un Bot',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Este usuario es un Burócrata en esta wiki',
	'userprofilepage-user-group-helper-tooltip' => 'Este usuario es un Helper de Wikia',
	'userprofilepage-user-group-vstf-tooltip' => 'Este usuario es un miembro del Spam Task Force',
	'userprofilepage-top-wikis-title' => 'Mejores wikis de $1',
	'userprofilepage-top-wikis-edit-count' => 'Número de ediciones',
	'userprofilepage-top-wikis-hidden-see-more' => 'Has ocultado {{PLURAL:$1|$1 wiki|$1 wikis}}',
	'userprofilepage-top-wikis-unhide-label' => 'mostrar',
	'userprofilepage-top-wikis-hide-label' => 'ocultar',
	'userprofilepage-top-wikis-locked-label' => 'No se puede ocultar la wiki actual',
	'userprofilepage-recent-activity-title' => 'actividad reciente de $1',
	'userprofilepage-activity-edit' => 'editó la página $1',
	'userprofilepage-activity-new' => 'creó $1',
	'userprofilepage-activity-comment' => 'comentó en $1',
	'userprofilepage-activity-image' => 'subió una imagen a $1',
	'userprofilepage-activity-video' => 'subió un vídeo a $1',
	'userprofilepage-activity-delete' => 'borró la página $1',
	'userprofilepage-activity-talk' => 'dejó un mensaje en la página de discusión de $1',
	'userprofilepage-recent-activity-default' => '$1 se ha unido a Wikia',
	'userprofilepage-top-recent-activity-see-more' => 'Ver todo',
	'userprofilepage-top-pages-title' => 'Las mejores páginas de $1 en $2',
	'userprofilepage-top-page-unhide-label' => 'mostrar',
	'userprofilepage-top-pages-hidden-see-more' => 'Has ocultado {{PLURAL:$1|$1 página|$1 páginas}}',
	'userprofilepage-top-pages-default' => 'Aún no tienes una clasificación de páginas. ¿Por qué no echas un vistazo a algunas <a href="$1">páginas aleatorias</a> en la wiki?',
	'recipes-template-user-description-label' => 'Descripción',
	'recipes-template-user-description-hint' => 'Breve información sobre el usuario',
	'recipes-template-user-birthdate-label' => 'Fecha de nacimiento',
	'recipes-template-user-birthdate-hint' => 'Fecha de nacimiento (en cualquier formato)',
	'recipes-template-user-species-label' => 'Especies',
	'recipes-template-user-species-hint' => 'Especies',
	'recipes-template-user-abilities-label' => 'Habilidades',
	'recipes-template-user-abilities-hint' => 'Habilidades',
	'recipes-template-user-gender-label' => 'Sexo',
	'recipes-template-user-gender-hint' => 'Sexo',
	'recipes-template-user-affiliation-label' => 'Afiliación',
	'recipes-template-user-affiliation-hint' => 'Afiliación',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Nike
 * @author Tofu II
 */
$messages['fi'] = array(
	'userprofilepage-edit-avatar-label' => 'Muokkaa kuvaa',
	'userprofilepage-edit-button' => 'Muokkaa',
	'userprofilepage-user-group-bot' => 'Botti',
	'userprofilepage-user-group-helper' => 'Apulainen',
	'userprofilepage-user-group-sysop-tooltip' => 'Tämä käyttäjä on ylläpitäjä tässä wikissä',
	'userprofilepage-user-group-bot-tooltip' => 'Tämä käyttäjä on botti',
	'userprofilepage-top-wikis-edit-count' => 'Muokkausten määrä',
	'userprofilepage-top-wikis-hidden-see-more' => 'Olet piilottanut {{PLURAL:$1|$1 wikin|$1 wikiä}}',
	'userprofilepage-top-wikis-unhide-label' => 'näytä',
	'userprofilepage-top-wikis-hide-label' => 'piilota',
	'userprofilepage-activity-edit' => 'muokkasi sivua $1',
	'userprofilepage-recent-activity-default' => '$1 on liittynyt Wikiaan',
	'userprofilepage-top-recent-activity-see-more' => 'Näytä kaikki',
	'userprofilepage-top-page-unhide-label' => 'näytä',
	'recipes-template-user-description-label' => 'Kuvaus',
	'recipes-template-user-description-hint' => 'Lyhyesti tietoja käyttäjästä',
	'recipes-template-user-birthdate-label' => 'Syntymäaika',
	'recipes-template-user-birthdate-hint' => 'Syntymäaika (missä tahansa muodossa)',
	'recipes-template-user-gender-label' => 'Sukupuoli',
	'recipes-template-user-gender-hint' => 'Sukupuoli',
	'recipes-template-user-affiliation-label' => 'Kytkös',
	'recipes-template-user-affiliation-hint' => 'Kytkös',
);

/** French (Français)
 * @author Wyz
 */
$messages['fr'] = array(
	'userprofilepage-desc' => 'Fournit une page de profil utilisateur amusante et facile à mettre à jour',
	'userprofilepage-edit-avatar-label' => 'Modifiez l’image',
	'userprofilepage-users-notes-title' => 'À mon sujet',
	'userprofilepage-about-section-title' => 'Mon profil $1',
	'userprofilepage-edit-button' => 'Modifier',
	'userprofilepage-about-article-title' => 'À propos',
	'userprofilepage-about-empty-section' => 'Cette section est vide. Cliquez sur Modifier pour ajouter du contenu ici !',
	'userprofilepage-edit-permision-denied' => 'Autorisations de modification refusées',
	'userprofilepage-edit-permision-denied-info' => 'Vous n’êtes pas autorisé à modifier la page utilisateur de quelqu’un ou une sous-page',
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size:20px">Chacun sur ce wiki aimerait mieux vous connaître !</div><a href="$1">Modifier cette section</a> pour ajouter plus d’informations à votre sujet et nous parler des choses que vous aimez.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size:20px">$1 n’a pas encore ajouté d’informations.</div>Vous pouvez plutôt <a href="$2">lui laisser un message</a>',
	'userprofilepage-user-doesnt-exists' => 'L’utilisateur $1 n’existe pas sur Wikia. Vérifiez l’[[Special:WikiActivity|activité du wiki]] pour savoir qui est actif sur ce wiki.',
	'userprofilepage-user-anon' => 'Cet utilisateur ne s’est pas encore enregistré sur Wikia. Veuillez vous [[Special:Signup|inscrire]] pour créer un compte et réclamer des points de modification, des badges et des appréciations de la part des autres contributeurs !',
	'userprofilepage-leave-message' => 'Laisser un message',
	'userprofilepage-edits-since' => 'Modifications depuis l’inscription sur ce wiki<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 a modifié la page <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 a créé <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 a supprimé la page <a href="$2">$3</a>',
	'userprofilepage-user-group-sysop' => 'Administrateur',
	'userprofilepage-user-group-staff' => 'Membre du personnel',
	'userprofilepage-user-group-bot' => 'Robot',
	'userprofilepage-user-group-bureaucrat' => 'Bureaucrate',
	'userprofilepage-user-group-helper' => 'Assistant',
	'userprofilepage-user-group-vstf' => 'Nettoyeur',
	'userprofilepage-user-group-sysop-tooltip' => 'Cet utilisateur est un administrateur sur ce wiki',
	'userprofilepage-user-group-staff-tooltip' => 'Cet utilisateur est un membre du personnel Wikia',
	'userprofilepage-user-group-bot-tooltip' => 'Cet utilisateur est un robot sur ce wiki',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Cet utilisateur est un bureaucrate sur ce wiki',
	'userprofilepage-user-group-helper-tooltip' => 'Cet utilisateur fournit de l’assistance aux utilisateurs sur ce wiki',
	'userprofilepage-user-group-vstf-tooltip' => 'Cet utilisateur est membre du groupe de travail de lutte contre les contenus indésirables, abusifs ou malveillants.',
	'userprofilepage-top-wikis-title' => 'Les meilleurs wikis de $1',
	'userprofilepage-top-wikis-edit-count' => 'Nombre de modifications',
	'userprofilepage-top-wikis-hidden-see-more' => 'Vous avez masqué $1 wiki{{PLURAL:$1||s}}',
	'userprofilepage-top-wikis-unhide-label' => 'afficher',
	'userprofilepage-top-wikis-hide-label' => 'masquer',
	'userprofilepage-top-wikis-locked-label' => 'Le wiki actuel ne peut pas être masqué',
	'userprofilepage-recent-activity-title' => 'Activité récente de $1',
	'userprofilepage-activity-edit' => 'a modifié la page $1',
	'userprofilepage-activity-new' => 'a créé $1',
	'userprofilepage-activity-comment' => 'a commenté $1',
	'userprofilepage-activity-image' => 'a téléversé une image vers $1',
	'userprofilepage-activity-video' => 'a téléversé une vidéo vers $1',
	'userprofilepage-activity-delete' => 'a supprimé la page $1',
	'userprofilepage-activity-talk' => 'a laissé un message sur la page de discussion de $1',
	'userprofilepage-recent-activity-default' => '$1 a rejoint Wikia',
	'userprofilepage-top-recent-activity-see-more' => 'Tout voir',
	'userprofilepage-top-pages-title' => 'Les meilleures pages de $1 sur $2',
	'userprofilepage-top-page-unhide-label' => 'afficher',
	'userprofilepage-top-pages-hidden-see-more' => 'Vous avez masqué $1 page{{PLURAL:$1||s}}',
	'userprofilepage-top-pages-default' => 'Vous n’avez pas encore de classement de pages. Pourquoi ne pas vérifier certaines <a href="$1">pages au hasard</a> sur le wiki ?',
	'recipes-template-user-description-label' => 'Description',
	'recipes-template-user-description-hint' => 'Courtes infos au sujet de l’utilisateur',
	'recipes-template-user-birthdate-label' => 'Date de naissance',
	'recipes-template-user-birthdate-hint' => 'Date de naissance (dans n’importe quel format)',
	'recipes-template-user-species-label' => 'Espèces',
	'recipes-template-user-species-hint' => 'Espèces',
	'recipes-template-user-abilities-label' => 'Aptitudes',
	'recipes-template-user-abilities-hint' => 'Aptitudes',
	'recipes-template-user-gender-label' => 'Genre',
	'recipes-template-user-gender-hint' => 'Genre',
	'recipes-template-user-affiliation-label' => 'Affiliation',
	'recipes-template-user-affiliation-hint' => 'Affiliation',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'userprofilepage-desc' => 'Forni un pagina de usator que es amusante e facile a actualisar',
	'userprofilepage-edit-avatar-label' => 'Modificar imagine',
	'userprofilepage-users-notes-title' => 'A proposito de me',
	'userprofilepage-about-section-title' => 'Mi interview de $1',
	'userprofilepage-edit-button' => 'Modificar',
	'userprofilepage-about-article-title' => 'A proposito',
	'userprofilepage-about-empty-section' => 'Iste section es vacue. Clicca "Modificar" pro inserer qualcosa!',
	'userprofilepage-edit-permision-denied' => 'Permission de modification refusate',
	'userprofilepage-edit-permision-denied-info' => 'Tu non ha le permission de modificar le pagina o subpagina de un altere usator',
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">Omnes in iste wiki es curiose de cognoscer te!</div><a href="$1">Modifica iste section</a> pro adder informationes super te e dicer nos lo que tu ama.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 non ha ancora addite informationes.</div> Ma tu pote <a href="$2">lassar un message</a>.',
	'userprofilepage-user-doesnt-exists' => 'Le usator $1 non existe in Wikia. Reguarda le [[Special:WikiActivity|activitate del wiki]] pro saper qui es active in iste wiki.',
	'userprofilepage-user-anon' => 'Iste usator non es ancora inscribite in Wikia. [[Special:Signup|Registra te]] pro crear un conto e reciper punctos de modification, insignias e appreciation de tu co-redactores!',
	'userprofilepage-leave-message' => 'Lassar message',
	'userprofilepage-edits-since' => 'Modificationes depost adherentia a iste wiki<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 modificava le pagina <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 creava <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 deleva le pagina <a href="$2">$3</a>',
	'userprofilepage-user-group-sysop' => 'Admin',
	'userprofilepage-user-group-staff' => 'Membro del personal',
	'userprofilepage-user-group-bot' => 'Robot',
	'userprofilepage-user-group-bureaucrat' => 'Bureaucrate',
	'userprofilepage-user-group-helper' => 'Adjutor',
	'userprofilepage-user-group-vstf' => 'VSTF',
	'userprofilepage-user-group-sysop-tooltip' => 'Iste usator es un administrator de iste wiki',
	'userprofilepage-user-group-staff-tooltip' => 'Iste usator es un membro del personal de Wikia',
	'userprofilepage-user-group-bot-tooltip' => 'Iste usator es un robot',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Iste usator es un bureaucrate de iste wiki',
	'userprofilepage-user-group-helper-tooltip' => 'Iste usator es un adjutor de iste wiki',
	'userprofilepage-user-group-vstf-tooltip' => 'Iste usator es un membro del gruppo de labor anti-spam',
	'userprofilepage-top-wikis-title' => 'Le wikis principal de $1',
	'userprofilepage-top-wikis-edit-count' => 'Numero de modificationes',
	'userprofilepage-top-wikis-hidden-see-more' => 'Tu ha celate {{PLURAL:$1|$1 wiki|$1 wikis}}',
	'userprofilepage-top-wikis-unhide-label' => 'revelar',
	'userprofilepage-top-wikis-hide-label' => 'celar',
	'userprofilepage-top-wikis-locked-label' => 'Le wiki actual non pote esser celate',
	'userprofilepage-recent-activity-title' => 'Activitate recente de $1',
	'userprofilepage-activity-edit' => 'modificava le pagina $1',
	'userprofilepage-activity-new' => 'creava $1',
	'userprofilepage-activity-comment' => 'commentava $1',
	'userprofilepage-activity-image' => 'incargava un imagine a $1',
	'userprofilepage-activity-video' => 'incargava un video a $1',
	'userprofilepage-activity-delete' => 'deleva le pagina $1',
	'userprofilepage-activity-talk' => 'lassava un message sur le pagina de discussion de $1',
	'userprofilepage-recent-activity-default' => '$1 ha adherite a Wikia',
	'userprofilepage-top-recent-activity-see-more' => 'Vider totes',
	'userprofilepage-top-pages-title' => 'Le paginas $2 principal de $1',
	'userprofilepage-top-page-unhide-label' => 'revelar',
	'userprofilepage-top-pages-hidden-see-more' => 'Tu ha celate {{PLURAL:$1|$1 pagina|$1 paginas}}',
	'userprofilepage-top-pages-default' => 'Tu non ha ancora alcun pagina principal. Proque non explorar alcun <a href="$1">paginas aleatori</a> in le wiki?',
	'recipes-template-user-description-label' => 'Description',
	'recipes-template-user-description-hint' => 'Curte informationes super le usator',
	'recipes-template-user-birthdate-label' => 'Data de nascentia',
	'recipes-template-user-birthdate-hint' => 'Data de nascentia (in qualcunque formato)',
	'recipes-template-user-species-label' => 'Specie',
	'recipes-template-user-species-hint' => 'Specie',
	'recipes-template-user-abilities-label' => 'Capacitates',
	'recipes-template-user-abilities-hint' => 'Capacitates',
	'recipes-template-user-gender-label' => 'Sexo',
	'recipes-template-user-gender-hint' => 'Sexo',
	'recipes-template-user-affiliation-label' => 'Affiliation',
	'recipes-template-user-affiliation-hint' => 'Affiliation',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'userprofilepage-user-group-bot' => 'Bot',
	'userprofilepage-user-group-bureaucrat' => 'Bûrokrat',
	'userprofilepage-top-wikis-unhide-label' => 'nîşan bide',
	'userprofilepage-top-wikis-hide-label' => 'veşêre',
	'userprofilepage-top-page-unhide-label' => 'nîşan bide',
	'recipes-template-user-gender-label' => 'Zayend',
	'recipes-template-user-gender-hint' => 'Zayend',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'userprofilepage-top-wikis-hide-label' => 'verstoppen',
	'userprofilepage-top-pages-hidden-see-more' => 'Dir hutt {{PLURAL:$1|eng Säit|$1 Säite}} verstoppt',
	'recipes-template-user-description-label' => 'Beschreiwung',
	'recipes-template-user-birthdate-label' => 'Gebuertsdatum',
	'recipes-template-user-gender-label' => 'Geschlecht',
	'recipes-template-user-gender-hint' => 'Geschlecht',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'userprofilepage-desc' => 'Дава корисничка страница која лесно се дополнува, и тоа на забавен начин',
	'userprofilepage-edit-avatar-label' => 'Смени слика',
	'userprofilepage-users-notes-title' => 'За мене',
	'userprofilepage-about-section-title' => 'Мое интервју - $1',
	'userprofilepage-edit-button' => 'Уреди',
	'userprofilepage-about-article-title' => 'За страницава',
	'userprofilepage-about-empty-section' => 'Овој пасус е празен. Кликнете тука за да додадете нешто!',
	'userprofilepage-edit-permision-denied' => 'Не ви е дозволено да уредувате',
	'userprofilepage-edit-permision-denied-info' => 'Немате дозволи да уредувате нечија корисничка страница или потстраница',
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">Сите на ова вики многу би сакале да дознаат повеќе за вас!</div><a href="$1">Уредете го пасусов</a> - додајте повеќе информации за себе и вашите омилени нешта.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 сè уште нема внесено информации.</div>Но можете да <a href="$2">оставите порака</a>',
	'userprofilepage-user-doesnt-exists' => 'Корисникот $1 не постои на Викија. Проверете ги [[Special:WikiActivity|Викиактивностите]] за да видите кој е активен на ова вики.',
	'userprofilepage-user-anon' => 'Овој корисник сè уште се нема регистрирано на Викија. [[Special:Signup|Регистрирајте]] се за да направите сметка и да почнете да собирате бодови за уредување, значки и признание од вашите колеги-уредници!',
	'userprofilepage-leave-message' => 'Остави порака',
	'userprofilepage-edits-since' => 'Уредувања на ова вики<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 ја уреди страницата <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 ја создаде страницата <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 ја избриша страницата <a href="$2">$3</a>',
	'userprofilepage-user-group-sysop' => 'Админ',
	'userprofilepage-user-group-staff' => 'Член на персоналот',
	'userprofilepage-user-group-bot' => 'Бот',
	'userprofilepage-user-group-bureaucrat' => 'Бирократ',
	'userprofilepage-user-group-helper' => 'Помошник',
	'userprofilepage-user-group-vstf' => 'Противспамер',
	'userprofilepage-user-group-sysop-tooltip' => 'Корисников е Администратор на ова вики',
	'userprofilepage-user-group-staff-tooltip' => 'Корисников е член на персоналот на Викија',
	'userprofilepage-user-group-bot-tooltip' => 'Корисников е Бот',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Корисников е Бирократ на ова вики',
	'userprofilepage-user-group-helper-tooltip' => 'Корисников е Помошник на ова вики',
	'userprofilepage-user-group-vstf-tooltip' => 'Корисников е член на Работната група против спам',
	'userprofilepage-top-wikis-title' => 'Најкотирани викија на $1',
	'userprofilepage-top-wikis-edit-count' => 'Бр. на уредувања',
	'userprofilepage-top-wikis-hidden-see-more' => 'Сокривте {{PLURAL:$1|$1 вики|$1 вики}}',
	'userprofilepage-top-wikis-unhide-label' => 'откриј',
	'userprofilepage-top-wikis-hide-label' => 'скриј',
	'userprofilepage-top-wikis-locked-label' => 'Тековното вики не може да се крие',
	'userprofilepage-recent-activity-title' => 'Скорешни активности на $1',
	'userprofilepage-activity-edit' => 'ја уреди страницата $1',
	'userprofilepage-activity-new' => 'ја создаде страницата $1',
	'userprofilepage-activity-comment' => 'коментираше на страницата $1',
	'userprofilepage-activity-image' => 'подигна слика на $1',
	'userprofilepage-activity-video' => 'подигна видеоснимка на $1',
	'userprofilepage-activity-delete' => 'ја избриша страницата $1',
	'userprofilepage-activity-talk' => 'остави порака на страницата за разговор на $1',
	'userprofilepage-recent-activity-default' => '$1 се зачлени на Викија',
	'userprofilepage-top-recent-activity-see-more' => 'Сите',
	'userprofilepage-top-pages-title' => 'Најкотирани $2 страници на $1',
	'userprofilepage-top-page-unhide-label' => 'откриј',
	'userprofilepage-top-pages-hidden-see-more' => 'Сокривте {{PLURAL:$1|$1 страница|$1 страници}}',
	'userprofilepage-top-pages-default' => 'Сè уште немате најкотирани страници. Ви предлагаме да разгледате некои <a href="$1">случајни страници</a> на викито.',
	'recipes-template-skip-toggle-types' => 'закорисникот',
	'recipes-template-user-description-label' => 'Опис',
	'recipes-template-user-description-hint' => 'Кратки податоци за корисникот',
	'recipes-template-user-birthdate-label' => 'Датум на раѓање',
	'recipes-template-user-birthdate-hint' => 'Датум на раѓање (било кој формат)',
	'recipes-template-user-species-label' => 'Вид',
	'recipes-template-user-species-hint' => 'Вид',
	'recipes-template-user-abilities-label' => 'Способности',
	'recipes-template-user-abilities-hint' => 'Способности',
	'recipes-template-user-gender-label' => 'Пол',
	'recipes-template-user-gender-hint' => 'Пол',
	'recipes-template-user-affiliation-label' => 'Наклонетост',
	'recipes-template-user-affiliation-hint' => 'Наклонетост',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'userprofilepage-desc' => 'Biedt een leuke en eenvoudig bij te werken gebruikerspagina',
	'userprofilepage-edit-avatar-label' => 'Afbeelding bewerken',
	'userprofilepage-users-notes-title' => 'Over mij',
	'userprofilepage-about-section-title' => 'Mijn $1 interview',
	'userprofilepage-edit-button' => 'Bewerken',
	'userprofilepage-about-article-title' => 'Over',
	'userprofilepage-about-empty-section' => 'Deze sectie is leeg. Klik op bewerken om wat toe te voegen.',
	'userprofilepage-edit-permision-denied' => 'U kunt deze pagina niet bewerken',
	'userprofilepage-edit-permision-denied-info' => "U kunt gebruikerspagina's of subpagina's van gebruikerspagina van andere gebruikers niet bewerken.",
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">Iedereen in deze wiki wil graag meer over u weten.</div><a href="$1">Bewerk deze paragraaf</a> om meer over uzelf toe te voegen en iedereen te laten weten wat u bezig houdt.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 heeft nog geen informatie toegevoegd.</div>U kunt <a href="$2">een bericht achterlaten</a>.',
	'userprofilepage-user-doesnt-exists' => 'De gebruiker $1 bestaat niet bij Wikia. Kijk op [[Special:WikiActivity|Wikiactiviteit]] na wie er actief is op deze wiki.',
	'userprofilepage-user-anon' => 'Deze gebruiker is nog niet ingeschreven bij Wikia. [[Special:Signup|Schrijf u in]] om een gebruiker aan te maken en bewerkingspunten en waardering van uw medegebruikers te ontvangen.',
	'userprofilepage-leave-message' => 'Bericht achterlaten',
	'userprofilepage-edits-since' => 'Bewerkingen sinds aanmaken gebruiker<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 heeft de pagina <a href="$2">$3</a> bewerkt',
	'userprofilepage-user-last-action-new' => '$1 heeft <a href="$2">$3</a> aangemaakt',
	'userprofilepage-user-last-action-delete' => '$1 heeft de pagina <a href="$2">$3</a> verwijderd',
	'userprofilepage-user-group-sysop' => 'Beheerder',
	'userprofilepage-user-group-staff' => 'Medewerker',
	'userprofilepage-user-group-bot' => 'Robot',
	'userprofilepage-user-group-bureaucrat' => 'Bureaucraat',
	'userprofilepage-user-group-helper' => 'Hulpje',
	'userprofilepage-user-group-vstf' => 'Anti-spamgroeplid',
	'userprofilepage-user-group-sysop-tooltip' => 'Deze gebruiker is beheerder op deze wiki',
	'userprofilepage-user-group-staff-tooltip' => 'Deze gebruiker is een medewerker van Wikia',
	'userprofilepage-user-group-bot-tooltip' => 'Deze gebruiker is een robot',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Deze gebruiker is bureaucraat op deze wiki',
	'userprofilepage-user-group-helper-tooltip' => 'Deze gebruiker is een hulpje op deze wiki',
	'userprofilepage-user-group-vstf-tooltip' => 'Deze gebruiker is lid van de Anti-spamgroep',
	'userprofilepage-top-wikis-title' => "Topwiki'a van $1",
	'userprofilepage-top-wikis-edit-count' => 'Aantal bewerkingen',
	'userprofilepage-top-wikis-hidden-see-more' => "U hebt $1 verbogen {{PLURAL:$1|wiki|wiki's}}",
	'userprofilepage-top-wikis-unhide-label' => 'weergeven',
	'userprofilepage-top-wikis-hide-label' => 'verbergen',
	'userprofilepage-top-wikis-locked-label' => 'De huidige wiki kan niet verborgen worden',
	'userprofilepage-recent-activity-title' => 'Recente activiteit van $1',
	'userprofilepage-activity-edit' => 'heeft de pagina $1 bewerkt',
	'userprofilepage-activity-new' => 'heeft $1 aangemaakt',
	'userprofilepage-activity-comment' => 'heeft een opmerking gemaakt bij $1',
	'userprofilepage-activity-image' => 'heeft een afbeelding geüpload bij $1',
	'userprofilepage-activity-video' => 'heeft een video geüpload bij $1',
	'userprofilepage-activity-delete' => 'heeft de pagina $1 verwijderd',
	'userprofilepage-activity-talk' => 'heeft een bericht achtergelaten op de overlegpagina van $1',
	'userprofilepage-recent-activity-default' => '$1 is bij Wikia gekomen',
	'userprofilepage-top-recent-activity-see-more' => 'Alles bekijken',
	'userprofilepage-top-pages-title' => "Favoriete pagina's van $1 op $2",
	'userprofilepage-top-page-unhide-label' => 'weergeven',
	'userprofilepage-top-pages-hidden-see-more' => "U hebt $1 {{PLURAL:$1|pagina|pagina's}} verborgen",
	'userprofilepage-top-pages-default' => 'U hebt nog geen favoriete pagina\'s. Bekijk een aantal <a href="$1">willekeurige pagina\'s</a> op de wiki!',
	'recipes-template-user-description-label' => 'Beschrijving',
	'recipes-template-user-description-hint' => 'Informatie over de gebruiker',
	'recipes-template-user-birthdate-label' => 'Geboortedatum',
	'recipes-template-user-birthdate-hint' => 'Geboortedatum (in elke indeling)',
	'recipes-template-user-species-label' => 'Soort',
	'recipes-template-user-species-hint' => 'Soort',
	'recipes-template-user-abilities-label' => 'Deskundigheden',
	'recipes-template-user-abilities-hint' => 'Deskundigheden',
	'recipes-template-user-gender-label' => 'Geslacht',
	'recipes-template-user-gender-hint' => 'Geslacht',
	'recipes-template-user-affiliation-label' => 'Voorkeuren en interesses',
	'recipes-template-user-affiliation-hint' => 'Voorkeuren en interesses',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'userprofilepage-desc' => 'Gir en brukerside som er morsom og enkel å oppdatere',
	'userprofilepage-edit-avatar-label' => 'Rediger bilde',
	'userprofilepage-users-notes-title' => 'Om meg',
	'userprofilepage-about-section-title' => 'Mitt $1-intervju',
	'userprofilepage-edit-button' => 'Rediger',
	'userprofilepage-about-article-title' => 'Om',
	'userprofilepage-about-empty-section' => 'Denne seksjonen er tom. Klikk rediger for å legge til ting her!',
	'userprofilepage-edit-permision-denied' => 'Redigeringstillatelse nektet',
	'userprofilepage-edit-permision-denied-info' => 'Du har ikke tillatelse til å redigere andres brukersider eller undersider',
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">Alle på denne wikien vil gjerne vite mer om deg!</div><a href="$1">Rediger denne seksjonen</a> for å legge til mer om deg selv og fortelle oss om tingene du elsker.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 har ikke lagt til noen informasjon ennå.</div>Du kan<a href="$2">legge igjen en beskjed</a> istedenfor',
	'userprofilepage-user-doesnt-exists' => 'Brukeren $1 eksisterer ikke på Wikia. Sjekk ut [[Special:WikiActivity|Wiki-aktivitet]] for å se hvem som er aktiv på denne wikien.',
	'userprofilepage-user-anon' => 'Denne brukeren har ikke registrert seg på Wikia ennå. [[Special:Signup|Registrer en konto]] og motta redigeringspoeng, utmerkelser og anerkjennelse fra andre redaktører!',
	'userprofilepage-leave-message' => 'Legg igjen melding',
	'userprofilepage-edits-since' => 'Redigeringer siden brukeren registrerte seg<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 redigerte siden <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 opprettet <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 slettet siden <a href="$2">$3</a>',
	'userprofilepage-user-group-sysop' => 'Admin',
	'userprofilepage-user-group-staff' => 'Medlem av ledelsen',
	'userprofilepage-user-group-bot' => 'Robot',
	'userprofilepage-user-group-bureaucrat' => 'Byråkrat',
	'userprofilepage-user-group-helper' => 'Hjelper',
	'userprofilepage-user-group-vstf' => 'VSO',
	'userprofilepage-user-group-sysop-tooltip' => 'Denne brukeren er en administrator på denne wikien',
	'userprofilepage-user-group-staff-tooltip' => 'Denne brukeren er et medlem av Wikia-ledelsen',
	'userprofilepage-user-group-bot-tooltip' => 'Denne brukeren er en robot',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Denne brukeren er en byråkrat på denne wikien',
	'userprofilepage-user-group-helper-tooltip' => 'Denne brukeren er en hjelper på denne wikien',
	'userprofilepage-user-group-vstf-tooltip' => 'Denne brukeren er et medlem av Spam-oppryderne',
	'userprofilepage-top-wikis-title' => '$1s toppwikier',
	'userprofilepage-top-wikis-edit-count' => 'Antall redigeringer',
	'userprofilepage-top-wikis-hidden-see-more' => 'Du har skjult {{PLURAL:$1|$1 wiki|$1 wikier}}',
	'userprofilepage-top-wikis-unhide-label' => 'vis',
	'userprofilepage-top-wikis-hide-label' => 'skjul',
	'userprofilepage-top-wikis-locked-label' => 'Den gjeldende wikien kan ikke være skjult',
	'userprofilepage-recent-activity-title' => '$1s siste aktivitet',
	'userprofilepage-activity-edit' => 'redigerte siden $1',
	'userprofilepage-activity-new' => 'opprettet $1',
	'userprofilepage-activity-comment' => 'kommenterte $1',
	'userprofilepage-activity-image' => 'lastet opp et bilde til $1',
	'userprofilepage-activity-video' => 'lastet opp en video til $1',
	'userprofilepage-activity-delete' => 'slettet siden $1',
	'userprofilepage-activity-talk' => 'la igjen en melding på $1s diskusjonsside',
	'userprofilepage-recent-activity-default' => '$1 har blitt med på Wikia',
	'userprofilepage-top-recent-activity-see-more' => 'Se alle',
	'userprofilepage-top-pages-title' => '$1s $2-toppsider',
	'userprofilepage-top-page-unhide-label' => 'vis',
	'userprofilepage-top-pages-hidden-see-more' => 'Du har skjult {{PLURAL:$1|$1 side|$1 sider}}',
	'userprofilepage-top-pages-default' => 'Du har ingen toppsider ennå. Hvorfor ikke sjekke ut noen <a href="$1">tilfeldige sider</a> på denne wikien?',
	'recipes-template-user-description-label' => 'Beskrivelse',
	'recipes-template-user-description-hint' => 'Kort informasjon om brukeren',
	'recipes-template-user-birthdate-label' => 'Fødselsdato',
	'recipes-template-user-birthdate-hint' => 'Fødselsdato (i et hvilket som helst format)',
	'recipes-template-user-species-label' => 'Art',
	'recipes-template-user-species-hint' => 'Art',
	'recipes-template-user-abilities-label' => 'Evner',
	'recipes-template-user-abilities-hint' => 'Evner',
	'recipes-template-user-gender-label' => 'Kjønn',
	'recipes-template-user-gender-hint' => 'Kjønn',
	'recipes-template-user-affiliation-label' => 'Tilknytning',
	'recipes-template-user-affiliation-hint' => 'Tilknytning',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'userprofilepage-edit-avatar-label' => 'انځور سمول',
	'userprofilepage-edit-button' => 'سمول',
	'userprofilepage-about-article-title' => 'په اړه',
	'userprofilepage-top-wikis-hide-label' => 'پټول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'userprofilepage-desc' => 'Fornece uma página de utilizador divertida e fácil de actualizar',
	'userprofilepage-edit-avatar-label' => 'Editar imagem',
	'userprofilepage-users-notes-title' => 'Sobre mim',
	'userprofilepage-about-section-title' => 'A minha entrevista $1',
	'userprofilepage-edit-button' => 'Editar',
	'userprofilepage-about-article-title' => 'Sobre',
	'userprofilepage-about-empty-section' => 'Esta secção está vazia. Clique editar para acrescentar-lhe coisas!',
	'userprofilepage-edit-permision-denied' => 'Permissões de edição negadas',
	'userprofilepage-edit-permision-denied-info' => 'Não tem permissões para editar a página de utilizador ou subpáginas, de outro utilizador',
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">Todos nesta wiki adorariam saber mais sobre si!</div><a href="$1">Edite esta secção</a> para acrescentar pormenores sobre si e sobre as coisas de que gosta.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 ainda não acrescentou nenhuma informação.</div>Se quiser, pode <a href="$2">deixar-lhe uma mensagem</a>',
	'userprofilepage-user-doesnt-exists' => 'O utilizador $1 não existe na Wikia. Visite a [[Special:WikiActivity|Actividade na Wiki]] para saber quem está activo nesta wiki.',
	'userprofilepage-user-anon' => 'Este utilizador ainda não se registou na Wikia. [[Special:Signup|Registe-se]] para ter uma conta e receber pontos de edições, medalhas e o reconhecimento dos outros editores!',
	'userprofilepage-leave-message' => 'Deixar mensagem',
	'userprofilepage-edits-since' => 'Edições desde a adesão a esta wiki<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 editou a página <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 criou <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 eliminou a página <a href="$2">$3</a>',
	'userprofilepage-user-group-sysop' => 'Administrador',
	'userprofilepage-user-group-staff' => 'Membro da equipa',
	'userprofilepage-user-group-bot' => 'Robô',
	'userprofilepage-user-group-bureaucrat' => 'Burocrata',
	'userprofilepage-user-group-helper' => 'Ajudante',
	'userprofilepage-user-group-vstf' => 'VSTF',
	'userprofilepage-user-group-sysop-tooltip' => 'Este utilizador é um Administrador desta wiki',
	'userprofilepage-user-group-staff-tooltip' => 'Este utilizador é um membro da Equipa da Wikia',
	'userprofilepage-user-group-bot-tooltip' => 'Este utilizador é um Robô',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Este utilizador é um Burocrata nesta wiki',
	'userprofilepage-user-group-helper-tooltip' => 'Este utilizador é um Auxiliar nesta wiki',
	'userprofilepage-user-group-vstf-tooltip' => 'Este utilizador é um membro da Spam Task Force',
	'userprofilepage-top-wikis-title' => 'As Melhores Wikis, para $1',
	'userprofilepage-top-wikis-edit-count' => 'Número de edições',
	'userprofilepage-top-wikis-hidden-see-more' => 'Ocultou {{PLURAL:$1|$1 wiki|$1 wikis}}',
	'userprofilepage-top-wikis-unhide-label' => 'mostrar',
	'userprofilepage-top-wikis-hide-label' => 'ocultar',
	'userprofilepage-top-wikis-locked-label' => 'A wiki corrente não pode ser ocultada',
	'userprofilepage-recent-activity-title' => 'Actividades recentes de $1',
	'userprofilepage-activity-edit' => 'editou a página $1',
	'userprofilepage-activity-new' => 'criou $1',
	'userprofilepage-activity-comment' => 'comentou $1',
	'userprofilepage-activity-image' => 'enviou uma imagem para $1',
	'userprofilepage-activity-video' => 'enviou um vídeo para $1',
	'userprofilepage-activity-delete' => 'eliminou a página $1',
	'userprofilepage-activity-talk' => 'deixou uma mensagem na página de discussão de $1',
	'userprofilepage-recent-activity-default' => '$1 aderiu à Wikia',
	'userprofilepage-top-recent-activity-see-more' => 'Ver todos',
	'userprofilepage-top-pages-title' => 'Melhores Páginas da $2, para $1',
	'userprofilepage-top-page-unhide-label' => 'mostrar',
	'userprofilepage-top-pages-hidden-see-more' => 'Ocultou {{PLURAL:$1|$1 página|$1 páginas}}',
	'userprofilepage-top-pages-default' => 'Ainda não elegou as melhores páginas. Que tal ver algumas <a href="$1">páginas aleatórias</a> da wiki?',
	'recipes-template-user-description-label' => 'Descrição',
	'recipes-template-user-description-hint' => 'Informação breve sobre o utilizador',
	'recipes-template-user-birthdate-label' => 'Data de nascimento',
	'recipes-template-user-birthdate-hint' => 'Data de nascimento (em qualquer formato)',
	'recipes-template-user-species-label' => 'Espécie',
	'recipes-template-user-species-hint' => 'Espécie',
	'recipes-template-user-abilities-label' => 'Capacidades',
	'recipes-template-user-abilities-hint' => 'Capacidades',
	'recipes-template-user-gender-label' => 'Sexo',
	'recipes-template-user-gender-hint' => 'Sexo',
	'recipes-template-user-affiliation-label' => 'Afiliação',
	'recipes-template-user-affiliation-hint' => 'Afiliação',
);

/** Russian (Русский)
 * @author Byulent
 */
$messages['ru'] = array(
	'userprofilepage-edit-avatar-label' => 'Изменить картинку',
	'userprofilepage-users-notes-title' => 'Обо мне',
	'userprofilepage-about-section-title' => 'Моё $1 интервью',
	'userprofilepage-edit-button' => 'Редактировать',
	'userprofilepage-edit-permision-denied' => 'Редактирование запрещено',
	'userprofilepage-edit-permision-denied-info' => 'У вас недостаточно прав для редактирования страницы или подстраницы какого-либо пользователя',
	'userprofilepage-user-doesnt-exists' => 'Участник $1 не существует',
	'userprofilepage-leave-message' => 'Оставить сообщение',
	'userprofilepage-user-group-sysop' => 'Администратор',
	'userprofilepage-user-group-bot' => 'Бот',
	'userprofilepage-user-group-bureaucrat' => 'Бюрократ',
	'userprofilepage-user-group-helper' => 'Помощник',
	'userprofilepage-user-group-vstf' => 'VSTF',
	'userprofilepage-user-group-sysop-tooltip' => 'Этот пользователь является администратором этой вики',
	'userprofilepage-user-group-bot-tooltip' => 'Этот пользователь является ботом',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Этот пользователь является бюрократом этой вики',
	'userprofilepage-user-group-helper-tooltip' => 'Этот пользователь является помощником в этой вики',
	'userprofilepage-user-group-vstf-tooltip' => 'Этот пользователь является членом группы борьбы со спамом',
	'userprofilepage-top-wikis-title' => 'Топ-$1 вики',
	'userprofilepage-top-wikis-edit-count' => 'Число правок',
	'userprofilepage-top-wikis-hidden-see-more' => 'У вас {{PLURAL:$1|имеется $1 скрытая вики|имеются $1 скрытые вики|имеются $1 скрытых вики}}',
	'userprofilepage-top-wikis-unhide-label' => 'показать',
	'userprofilepage-top-wikis-hide-label' => 'скрыть',
	'userprofilepage-top-wikis-locked-label' => 'Текущая вики не может быть скрыта',
	'userprofilepage-activity-edit' => 'отредактировал страницу $1',
	'userprofilepage-activity-new' => 'создал $1',
	'userprofilepage-activity-image' => 'загрузил изображение в $1',
	'userprofilepage-activity-video' => 'загрузил видео в $1',
	'userprofilepage-activity-delete' => 'удалил страницу $1',
	'userprofilepage-top-recent-activity-see-more' => 'Смотреть все',
	'recipes-template-user-description-label' => 'Описание',
	'recipes-template-user-description-hint' => 'Краткая информация о пользователе',
	'recipes-template-user-birthdate-label' => 'Дата рождения',
	'recipes-template-user-birthdate-hint' => 'Дата рождения (в любом формате)',
	'recipes-template-user-gender-label' => 'Пол',
	'recipes-template-user-gender-hint' => 'Пол',
	'recipes-template-user-affiliation-label' => 'Принадлежность',
	'recipes-template-user-affiliation-hint' => 'Принадлежность',
);

/** Tachelhit (Tašlḥiyt) */
$messages['shi'] = array(
	'userprofilepage-edit-button' => '↓ Ẓreg (bddel)',
	'userprofilepage-about-article-title' => '↓ F',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'userprofilepage-edit-avatar-label' => 'Уређивање слике',
	'userprofilepage-users-notes-title' => 'О мени',
	'userprofilepage-about-section-title' => '$1 интервју',
	'userprofilepage-edit-button' => 'Уреди',
	'userprofilepage-about-article-title' => 'О чланку',
	'userprofilepage-leave-message' => 'Постави поруку',
	'userprofilepage-user-last-action-delete' => '{{GENDER:$1|је обрисао|је обрисала|обриса}} <a href="$2">$3</a> страницу',
	'userprofilepage-user-group-sysop' => 'Администратор',
	'userprofilepage-user-group-staff' => 'Уредник',
	'userprofilepage-user-group-bot' => 'Бот',
	'userprofilepage-user-group-bureaucrat' => 'Бирократа',
	'userprofilepage-user-group-helper' => 'Помоћник',
	'userprofilepage-user-group-vstf' => 'VSTF',
	'userprofilepage-user-group-sysop-tooltip' => 'Овај корисник је администратор викије',
	'userprofilepage-user-group-staff-tooltip' => 'Овај корисник је уредник Викије',
	'userprofilepage-user-group-bot-tooltip' => 'Овај корисник је бот',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Овај корисник је бирократа викије',
	'userprofilepage-user-group-helper-tooltip' => 'Овај корисник је помоћник',
	'userprofilepage-user-group-vstf-tooltip' => 'Овај корисник је члан Борбе против непожељних порука',
	'userprofilepage-top-wikis-title' => 'Топ викије члана $1',
	'userprofilepage-top-wikis-edit-count' => 'Број измена',
	'userprofilepage-top-wikis-hidden-see-more' => 'Сакрили сте {{PLURAL:$1|$1 викију|$1 викије|$1 викија}}',
	'userprofilepage-top-wikis-unhide-label' => 'откриј',
	'userprofilepage-top-wikis-hide-label' => 'сакриј',
	'userprofilepage-top-wikis-locked-label' => 'Ова викија се не може сакрити',
	'userprofilepage-recent-activity-title' => 'Скорашња активност члана $1',
	'userprofilepage-activity-edit' => 'измени $1 страницу',
	'userprofilepage-activity-new' => 'направи $1',
	'userprofilepage-activity-image' => 'отпреми видео снимак на $1',
	'userprofilepage-activity-video' => 'отпреми видео снимак на $1',
	'userprofilepage-activity-delete' => 'обриса $1 страницу',
	'userprofilepage-activity-talk' => 'постави поруку на корисничкој страници члана $1',
	'userprofilepage-recent-activity-default' => '$1 се придружи викији',
	'userprofilepage-top-recent-activity-see-more' => 'Прикажи све &gt;',
	'userprofilepage-top-pages-title' => '$1 топ $2 страница',
	'userprofilepage-top-page-unhide-label' => 'откриј',
	'recipes-template-user-description-label' => 'Опис',
	'recipes-template-user-description-hint' => 'Подаци о кориснику',
	'recipes-template-user-birthdate-label' => 'Датум рођења',
	'recipes-template-user-birthdate-hint' => 'Датум рођења',
	'recipes-template-user-species-label' => 'Врста',
	'recipes-template-user-species-hint' => 'Врста',
	'recipes-template-user-abilities-label' => 'Могућности',
	'recipes-template-user-abilities-hint' => 'Могућности',
	'recipes-template-user-gender-label' => 'Пол',
	'recipes-template-user-gender-hint' => 'Пол',
	'recipes-template-user-affiliation-label' => 'Удружење',
	'recipes-template-user-affiliation-hint' => 'Удружење',
);

/** Swedish (Svenska)
 * @author Tobulos1
 */
$messages['sv'] = array(
	'userprofilepage-desc' => 'Ger en användarsida som är rolig och lätt att uppdatera',
	'userprofilepage-edit-avatar-label' => 'Redigera bild',
	'userprofilepage-users-notes-title' => 'Om mig',
	'userprofilepage-about-section-title' => 'Min $1 intervju',
	'userprofilepage-edit-button' => 'Redigera',
	'userprofilepage-about-article-title' => 'Om',
	'userprofilepage-about-empty-section' => 'Detta avsnitt är tomt. Klicka på redigera för att lägga till lite saker här!',
	'userprofilepage-edit-permision-denied' => 'Redigeringstillstånd nekad',
	'userprofilepage-edit-permision-denied-info' => 'Du har inte behörighet att redigera någons användarsida eller delsida',
	'userprofilepage-empty-my-about-me-section' => '<div style="font-size: 20px">Alla på denna wiki skulle vilja veta mera om dig!</div><a href="$1">Redigera detta avsnitt</a> för att lägga till mer information om dig själv och berätta om saker som du gillar att göra.',
	'userprofilepage-empty-somebodys-about-me-section' => '<div style="font-size: 20px">$1 har inte lagt till någon information ännu.</div>Du kan <a href="$2">lämna dem ett meddelande</a> istället',
	'userprofilepage-user-doesnt-exists' => 'Användaren $1 existerar inte på Wikia. Kolla in [[Special:WikiActivity|Wiki Aktiviteten]] för att se vem som är aktiv på denna wiki.',
	'userprofilepage-user-anon' => 'Denna användare har inte registrerat sig på Wikia ännu. [[Special:Signup|Gå med]] och registrera ett konto och få redigerings-poäng, märken och uppskattning från andra redaktörer!',
	'userprofilepage-leave-message' => 'Lämna ett meddelande',
	'userprofilepage-edits-since' => 'Redigeringar sen han/hon gick med i wikin<br />$1',
	'userprofilepage-user-last-action-edit' => '$1 redigerade sidan <a href="$2">$3</a>',
	'userprofilepage-user-last-action-new' => '$1 skapade <a href="$2">$3</a>',
	'userprofilepage-user-last-action-delete' => '$1 raderade sidan <a href="$2">$3</a>',
	'userprofilepage-user-group-sysop' => 'Admin',
	'userprofilepage-user-group-staff' => 'Personalmedlem',
	'userprofilepage-user-group-bot' => 'Bot',
	'userprofilepage-user-group-bureaucrat' => 'Byråkrat',
	'userprofilepage-user-group-helper' => 'Hjälpare',
	'userprofilepage-user-group-vstf' => 'VSTF',
	'userprofilepage-user-group-sysop-tooltip' => 'Den här användaren är en administratör på denna wiki',
	'userprofilepage-user-group-staff-tooltip' => 'Denna användare är en personalmedlem för Wikia',
	'userprofilepage-user-group-bot-tooltip' => 'Den här användaren är en Bot',
	'userprofilepage-user-group-bureaucrat-tooltip' => 'Den här användaren är en Byråkrat på denna wiki',
	'userprofilepage-user-group-helper-tooltip' => 'Denna användare är en Hjälpare',
	'userprofilepage-user-group-vstf-tooltip' => 'Den här användaren är medlem av arbetsgruppen för spam',
	'userprofilepage-top-wikis-title' => '$1s Topp wikis',
	'userprofilepage-top-wikis-edit-count' => 'Antal redigeringar',
	'userprofilepage-top-wikis-hidden-see-more' => 'Du har dolt {{PLURAL:$1|$1 wiki|$1 wikis}}',
	'userprofilepage-top-wikis-unhide-label' => 'ta fram',
	'userprofilepage-top-wikis-hide-label' => 'göm',
	'userprofilepage-top-wikis-locked-label' => 'Den nuvarande wikin kan inte döljas',
	'userprofilepage-recent-activity-title' => '$1s senaste aktivitet',
	'userprofilepage-activity-edit' => 'redigerade $1 sidan',
	'userprofilepage-activity-new' => 'skapade $1',
	'userprofilepage-activity-comment' => 'kommenterade på $1',
	'userprofilepage-activity-image' => 'laddade upp en bild till $1',
	'userprofilepage-activity-video' => 'laddade upp en video till $1',
	'userprofilepage-activity-delete' => 'raderade $1 sidan',
	'userprofilepage-activity-talk' => 'lämnade ett meddelande på $1s diskussionssida',
	'userprofilepage-recent-activity-default' => '$1 har gått med i Wikia',
	'userprofilepage-top-recent-activity-see-more' => 'Se alla &gt;',
	'userprofilepage-top-pages-title' => '$1s Topp $2 Sidor',
	'userprofilepage-top-page-unhide-label' => 'ta fram',
	'userprofilepage-top-pages-hidden-see-more' => 'Du har dolt {{PLURAL:$1|$1 sida|$1 sidor}}',
	'userprofilepage-top-pages-default' => 'Du har inte några "topp" sidor ännu. Varför inte kolla in några <a href="$1">slumpmässiga sidor</a> på wikin?',
	'recipes-template-user-description-label' => 'Beskrivning',
	'recipes-template-user-description-hint' => 'Kort info om användaren',
	'recipes-template-user-birthdate-label' => 'Födelsedatum',
	'recipes-template-user-birthdate-hint' => 'Födelsedatum (i alla format)',
	'recipes-template-user-species-label' => 'Arter',
	'recipes-template-user-species-hint' => 'Arter',
	'recipes-template-user-abilities-label' => 'Förmågor',
	'recipes-template-user-abilities-hint' => 'Förmågor',
	'recipes-template-user-gender-label' => 'Kön',
	'recipes-template-user-gender-hint' => 'Kön',
	'recipes-template-user-affiliation-label' => 'Tillhörighet',
	'recipes-template-user-affiliation-hint' => 'Tillhörighet',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'userprofilepage-users-notes-title' => 'నా గురించి',
	'userprofilepage-edit-button' => 'మార్చు',
	'userprofilepage-about-article-title' => 'గురించి',
	'recipes-template-user-description-label' => 'వివరణ',
	'recipes-template-user-birthdate-label' => 'పుట్టిన రోజు',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'userprofilepage-users-notes-title' => 'Про мене',
	'userprofilepage-edit-button' => 'Редагувати',
	'userprofilepage-leave-message' => 'Залишити повідомлення',
	'userprofilepage-user-group-sysop' => 'Адміністратор',
	'userprofilepage-user-group-staff' => 'Співробітник',
	'userprofilepage-user-group-bot' => 'Бот',
	'userprofilepage-user-group-bureaucrat' => 'Бюрократ',
	'userprofilepage-user-group-sysop-tooltip' => 'Цей користувач — адміністратор цієї вікі',
	'userprofilepage-user-group-staff-tooltip' => 'Цей користувач — співробітник Wikia',
	'userprofilepage-user-group-bot-tooltip' => 'Цей користувач — бот',
	'userprofilepage-top-wikis-edit-count' => 'Кількість редагувань',
	'userprofilepage-top-wikis-unhide-label' => 'показати',
	'userprofilepage-top-wikis-hide-label' => 'сховати',
	'userprofilepage-top-page-unhide-label' => 'показати',
	'recipes-template-user-description-label' => 'Опис',
	'recipes-template-user-description-hint' => 'Коротка інформація про користувача',
	'recipes-template-user-birthdate-label' => 'Дата народження',
	'recipes-template-user-birthdate-hint' => 'Дата народження (в будь-якому форматі)',
	'recipes-template-user-gender-label' => 'Стать',
	'recipes-template-user-gender-hint' => 'Стать',
);

