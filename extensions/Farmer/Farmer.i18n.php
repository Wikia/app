<?php
/**
 * Internationalisation file for Farmer extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

# Original messages by Gregory Szorc <gregory.szorc@gmail.com>
$messages['en'] = array (
	'farmer'                                 => 'Farmer',
	'farmer-desc'                            => 'Manage a MediaWiki farm',
	'farmercantcreatewikis'                  => 'You are unable to create wikis because you do not have the createwikis privilege',
	'farmercreateurl'                        => 'URL',
	'farmercreatesitename'                   => 'Site name',
	'farmercreatenextstep'                   => 'Next step',
	'farmernewwikimainpage'                  =>  "== Welcome to your wiki ==
If you are reading this, your new wiki has been installed correctly.
You can [[Special:Farmer|customize your wiki]].",
	'farmerwikiurl'                          => 'http://$1.myfarm',
	'farmerinterwikiurl'                     => 'http://$1.myfarm/$2',
	'farmer-about'                           => 'About',
	'farmer-about-text'                      => 'MediaWiki Farmer allows you to manage a farm of MediaWiki wikis.',
	'farmer-list-wiki'                       => 'List of wikis',
	'farmer-list-wiki-text'                  => '[[$1|List]] all wikis on {{SITENAME}}',
	'farmer-createwiki'                      => 'Create a wiki',
	'farmer-createwiki-text'                 => '[[$1|Create]] a new wiki now!',
	'farmer-administration'                  => 'Farm administration',
	'farmer-administration-extension'        => 'Manage extensions',
	'farmer-administration-extension-text'   => '[[$1|Manage]] installed extensions.',
	'farmer-admimistration-listupdate'       => 'Farm list update', # Should this be Update farm list instead?
	'farmer-admimistration-listupdate-text'  => '[[$1|Update]] list of wikis on {{SITENAME}}',
	'farmer-administration-delete'           => 'Delete a wiki',
	'farmer-administration-delete-text'      => '[[$1|Delete]] a wiki from the farm',
	'farmer-administer-thiswiki'             => 'Administer this wiki',
	'farmer-administer-thiswiki-text'        => '[[$1|Administer]] changes to this wiki',
	'farmer-notavailable'                    => 'Not available',
	'farmer-notavailable-text'               => 'This feature is only available on the main wiki',
	'farmer-wikicreated'                     => 'Wiki created',
	'farmer-wikicreated-text'                => 'Your wiki has been created.
It is accessible at $1',
	'farmer-default'                         => 'By default, nobody has permissions on this wiki except you.
You can change the user privileges via $1',
	'farmer-wikiexists'                      => 'Wiki exists',
	'farmer-wikiexists-text'                 => 'The wiki you are attempting to create, \'\'\'$1\'\'\', already exists.
Please go back and try another name.',
	'farmer-confirmsetting'                  => 'Confirm wiki settings',
	'farmer-confirmsetting-name'             => 'Name',
	'farmer-confirmsetting-title'            => 'Title',
	'farmer-confirmsetting-description'      => 'Description',
	'farmer-confirmsetting-reason'           => 'Reason',
	'farmer-description'                     => 'Description',
	'farmer-confirmsetting-text'             => 'Your wiki, \'\'\'$1\'\'\', will be accessible via $3.
The project namespace will be \'\'\'$2\'\'\'.
Links to this namespace will be of the form \'\'\'<nowiki>[[$2:Page name]]</nowiki>\'\'\'.
If this is what you want, press the \'\'\'confirm\'\'\' button below.',
	'farmer-button-confirm'                  => 'Confirm',
	'farmer-button-submit'                   => 'Submit',
	'farmer-createwiki-form-title'           => 'Create a wiki',
	'farmer-createwiki-form-text1'           => 'Use the form below to create a new wiki.',
	'farmer-createwiki-form-help'            => 'Help',
	'farmer-createwiki-form-text2'           => "; Wiki name: The name of the wiki.
Contains only letters and numbers.
The wiki name will be used as part of the URL to identify your wiki.
For example, if you enter '''title''', then your wiki will be accessed via <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3'           => '; Wiki title: Title of the wiki.
Will be used in the title of every page on your wiki.
Will also be the project namespace and interwiki prefix.',
	'farmer-createwiki-form-text4'           => '; Description: Description of wiki.
This is a text description about the wiki.
This will be displayed in the wiki list.',
	'farmer-createwiki-user'                 => 'Username',
	'farmer-createwiki-name'                 => 'Wiki name',
	'farmer-createwiki-title'                => 'Wiki title',
	'farmer-createwiki-description'          => 'Description',
	'farmer-createwiki-reason'               => 'Reason',
	'farmer-updatedlist'                     => 'Updated list',
	'farmer-notaccessible'                   => 'Not accessible',
	'farmer-notaccessible-test'              => 'This feature is only available on the parent wiki in the farm',
	'farmer-permissiondenied'                => 'Permission denied',
	'farmer-permissiondenied-text'           => 'You do not have permission to delete a wiki from the farm',
	'farmer-permissiondenied-text1'          => 'You do not have permission to access this page',
	'farmer-deleting'                        => 'The wiki "$1" has been deleted',
	'farmer-delete-confirm'                  => 'I confirm that I want to delete this wiki',
	'farmer-delete-confirm-wiki'             => "Wiki to delete: '''$1'''.",
	'farmer-delete-reason'                   => 'Reason for the deletion:',
	'farmer-delete-title'                    => 'Delete wiki',
	'farmer-delete-text'                     => 'Please select the wiki from the list below that you wish to delete',
	'farmer-delete-form'                     => 'Select a wiki',
	'farmer-delete-form-submit'              => 'Delete',
	'farmer-listofwikis'                     => 'List of wikis',
	'farmer-mainpage'                        => 'Main Page',
	'farmer-basic-title'                     => 'Basic parameters',
	'farmer-basic-title1'                    => 'Title',
	'farmer-basic-title1-text'               => 'Your wiki does not have a title. Set one <b>now</b>',
	'farmer-basic-description'               => 'Description',
	'farmer-basic-description-text'          => 'Set the description of your wiki below',
	'farmer-basic-permission'                => 'Permissions',
	'farmer-basic-permission-text'           => 'Using the form below, it is possible to alter permissions for users of this wiki.',
	'farmer-basic-permission-visitor'        => 'Permissions for every visitor',
	'farmer-basic-permission-visitor-text'   => 'The following permissions will be applied to every person who visits this wiki',
	'farmer-yes'                             => 'Yes',
	'farmer-no'                              => 'No',
	'farmer-basic-permission-user'           => 'Permissions for logged-in users',
	'farmer-basic-permission-user-text'      => 'The following permissions will be applied to every person who is logged into this wiki',
	'farmer-setpermission'                   => 'Set permissions',
	'farmer-defaultskin'                     => 'Default skin',
	'farmer-defaultskin-button'              => 'Set default skin',
	'farmer-extensions'                      => 'Active extensions',
	'farmer-extensions-button'               => 'Set active extensions',
	'farmer-extensions-extension-denied'     => 'You do not have permission to use this feature.
You must be a member of the farmeradmin group',
	'farmer-extensions-invalid'              => 'Invalid extension',
	'farmer-extensions-invalid-text'         => 'We could not add the extension because the file selected for inclusion could not be found',
	'farmer-extensions-available'            => 'Available extensions',
	'farmer-extensions-noavailable'          => 'No extensions are registered',
	'farmer-extensions-register'             => 'Register extension',
	'farmer-extensions-register-text1'       => 'Use the form below to register a new extension with the farm.
Once an extension is registered, all wikis will be able to use it.',
	'farmer-extensions-register-text2'       => "For the ''Include file'' parameter, enter the name of the PHP file as you would in LocalSettings.php.",
	'farmer-extensions-register-text3'       => "If the filename contains '''\$root''', that variable will be replaced with the MediaWiki root directory.",
	'farmer-extensions-register-text4'       => 'The current include paths are:',
	'farmer-extensions-register-name'        => 'Name',
	'farmer-extensions-register-includefile' => 'Include file',
	'farmer-error-exists'                    => 'Cannot create wiki. It already exists: $1',
	'farmer-error-noextwrite'                => 'Unable to write out extension file:',
	'farmer-log-name'                        => 'Wiki farm log',
	'farmer-log-header'                      => 'This is a log of changes made to the wiki farm.',
	'farmer-log-create'                      => 'created the wiki "$2"',
	'farmer-log-delete'                      => 'deleted the wiki "$2"',
	'right-farmeradmin'                      => 'Manage the wiki farm',
	'right-createwiki'                       => 'Create wikis in the wiki farm',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Meno25
 * @author Nike
 * @author Purodha
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'farmer-desc' => '{{desc}}',
	'farmercreateurl' => '{{optional}}',
	'farmernewwikimainpage' => 'Do not translate or change links.',
	'farmer-about' => '{{Identical|About}}',
	'farmer-list-wiki' => '{{Identical|List of wikis}}',
	'farmer-createwiki' => '{{Identical|Create a wiki}}',
	'farmer-confirmsetting-name' => '{{Identical|Name}}',
	'farmer-confirmsetting-title' => '{{Identical|Title}}',
	'farmer-confirmsetting-description' => '{{Identical|Description}}',
	'farmer-confirmsetting-reason' => '{{Identical|Reason}}',
	'farmer-description' => '{{Identical|Description}}',
	'farmer-confirmsetting-text' => 'You can ignore the warning about problematic link for now.',
	'farmer-button-confirm' => '{{Identical|Confirm}}',
	'farmer-button-submit' => '{{Identical|Submit}}',
	'farmer-createwiki-form-title' => '{{Identical|Create a wiki}}',
	'farmer-createwiki-form-help' => '{{Identical|Help}}',
	'farmer-createwiki-user' => '{{Identical|Username}}',
	'farmer-createwiki-description' => '{{Identical|Description}}',
	'farmer-createwiki-reason' => '{{Identical|Reason}}',
	'farmer-permissiondenied' => '{{Identical|Permission denied}}',
	'farmer-deleting' => '',
	'farmer-delete-reason' => '{{Identical|Reason for deletion}}',
	'farmer-delete-form-submit' => '{{Identical|Delete}}',
	'farmer-listofwikis' => '{{Identical|List of wikis}}',
	'farmer-mainpage' => '{{Identical|Main page}}',
	'farmer-basic-title1' => '{{Identical|Title}}',
	'farmer-basic-description' => '{{Identical|Description}}',
	'farmer-yes' => '{{Identical|Yes}}',
	'farmer-no' => '{{Identical|No}}',
	'farmer-extensions-register-name' => '{{Identical|Name}}',
	'right-farmeradmin' => '{{doc-right|farmeradmin}}',
	'right-createwiki' => '{{doc-right|createwiki}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'farmer-about' => 'Hün se',
	'farmer-createwiki-user' => 'Asa',
	'farmer-mainpage' => 'Pej Maha',
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'farmer-mainpage' => 'Piälehyt',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'farmer-createwiki-form-help' => 'Lagomatai',
	'farmer-createwiki-user' => 'Matahigoa he tagata',
	'farmer-delete-form-submit' => 'Tamate',
	'farmer-mainpage' => 'Matapatu Lau',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'farmer' => 'Boer',
	'farmer-desc' => "Bestuur van 'n MediaWiki plaas",
	'farmercantcreatewikis' => 'Jy is nie in staat om wikis te skep nie, omdat jy nie die "createwikis" voorreg het nie',
	'farmercreatesitename' => 'Werfnaam',
	'farmercreatenextstep' => 'Volgende stap',
	'farmernewwikimainpage' => '== Welkom by u wiki ==
As u hierdie lees, het u nuwe wiki korrek geïnstalleer.
U kan [[Special:Farmer|u wiki pas maak]].',
	'farmer-about' => 'Aangaande',
	'farmer-about-text' => "Met MediaWiki Farmer kan u die bestuur van 'n plaas van MediaWiki wikis doen.",
	'farmer-list-wiki' => "Lys van wiki's",
	'farmer-list-wiki-text' => '[[$1|Lys]] alle wikis op {{SITENAME}}',
	'farmer-createwiki' => "Skep 'n wiki",
	'farmer-createwiki-text' => "[[$1|Skep]] 'n nuwe wiki nou!",
	'farmer-administration' => 'Plaas administrasie',
	'farmer-administration-extension' => 'Bestuur uitbreidings',
	'farmer-administration-extension-text' => '[[$1|Bestuur]] geïnstalleerde uitbreidings.',
	'farmer-admimistration-listupdate' => 'Plaas lys bywerk',
	'farmer-admimistration-listupdate-text' => '[[$1|Werk]] lys van wikis op {{SITENAME}} by',
	'farmer-administration-delete' => "Verwyder 'n wiki",
	'farmer-administration-delete-text' => "[[$1|Verwyder]] 'n wiki van die plaas",
	'farmer-administer-thiswiki' => 'Administreer hierdie wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administreer]] veranderinge aan hierdie wiki',
	'farmer-notavailable' => 'Nie beskikbaar nie',
	'farmer-notavailable-text' => 'Hierdie funksie is slegs beskikbaar op die hoof wiki',
	'farmer-wikicreated' => 'Wiki geskep',
	'farmer-wikicreated-text' => 'U wiki is geskep. Dit is beskikbaar by $1',
	'farmer-default' => 'By verstek het niemand regte op hierdie wiki behalwe u.
U kan die gebruikerregte via $1 verander.',
	'farmer-wikiexists' => 'Wiki bestaan',
	'farmer-wikiexists-text' => "Die wiki wat u probeer skep, '''$1''', bestaan reeds.
Gaan asseblief terug en probeer 'n ander naam.",
	'farmer-confirmsetting' => 'Bevestig Wiki Opstelling',
	'farmer-confirmsetting-name' => 'Naam',
	'farmer-confirmsetting-title' => 'Titel',
	'farmer-confirmsetting-description' => 'Beskrywing',
	'farmer-confirmsetting-reason' => 'Rede',
	'farmer-description' => 'Beskrywing',
	'farmer-confirmsetting-text' => "U wiki, '''$1''', is toeganklik via $3. Die projek naamruimte sal '''$2''' wees. Skakels na hierdie naamruimte sal wees in die vorm '''<nowiki>[[$2:Bladsynaam]]</nowiki>'''. As dit is wat u wil hê, druk die '''bevestig''' knoppie hieronder.",
	'farmer-button-confirm' => 'Bevestig',
	'farmer-button-submit' => 'Dien in',
	'farmer-createwiki-form-title' => "Skep 'n wiki",
	'farmer-createwiki-form-text1' => "Gebruik die vorm hieronder om 'n nuwe wiki te skep.",
	'farmer-createwiki-form-help' => 'Hulp',
	'farmer-createwiki-form-text2' => "; Wiki naam: Die naam van die wiki.
Bevat slegs letters en nommers.
Die wiki naam sal as deel vorm van die URL wat gebruik word om u wiki te identifiseer.
Byvoorbeeld, as u '''titel''' invoer, dan sal u wiki toeganklik wees via <nowiki>http://</nowiki>'''titel'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Wiki titel: Titel van die wiki.
Sal in die titel van elke bladsy wat gebruik word op die wiki vertoon word.
Sal ook die projek en interwiki naamruimte voorvoegsel wees.',
	'farmer-createwiki-form-text4' => "; Beskrywing: Beskrywing van 'n wiki.
Hierdie is 'n teks beskrywing van die wiki.
Dit sal in die wiki lys vertoon word.",
	'farmer-createwiki-user' => 'Gebruikersnaam',
	'farmer-createwiki-name' => 'Wiki naam',
	'farmer-createwiki-title' => 'Wiki titel',
	'farmer-createwiki-description' => 'Beskrywing',
	'farmer-createwiki-reason' => 'Rede',
	'farmer-updatedlist' => 'Opgedateerde lys',
	'farmer-notaccessible' => 'Nie toeganklik',
	'farmer-notaccessible-test' => 'Hierdie funksie is slegs beskikbaar op die ouer-wiki in die plaas',
	'farmer-permissiondenied' => 'Geen toegang',
	'farmer-permissiondenied-text' => "U het nie toestemming om 'n wiki uit die plaas te verwyder nie",
	'farmer-permissiondenied-text1' => 'U het nie toegang om hierdie bladsy te besigtig nie.',
	'farmer-deleting' => 'Die wiki "$1" is verwyder',
	'farmer-delete-confirm' => 'Ek bevestig dat ek hierdie wiki wil verwyder',
	'farmer-delete-confirm-wiki' => "Wiki om teverwyder: '''$1'''.",
	'farmer-delete-reason' => 'Rede vir verwydering:',
	'farmer-delete-title' => 'Verwyder wiki',
	'farmer-delete-text' => 'Kies asseblief die wiki wat u wil verwyder uit die onderstaande lys',
	'farmer-delete-form' => "Kies 'n wiki",
	'farmer-delete-form-submit' => 'Skrap',
	'farmer-listofwikis' => "Lys van wiki's",
	'farmer-mainpage' => 'Tuisblad',
	'farmer-basic-title' => 'Basiese parameters',
	'farmer-basic-title1' => 'Titel',
	'farmer-basic-title1-text' => "Jou wiki het nie 'n titel nie. Stel een <b>nou</b> op",
	'farmer-basic-description' => 'Beskrywing',
	'farmer-basic-description-text' => 'Stel die beskrywing van u wiki hieronder',
	'farmer-basic-permission' => 'Regte',
	'farmer-basic-permission-text' => 'Met behulp van die vorm hieronder, is dit moontlik om regte vir die gebruikers van hierdie wiki te verander.',
	'farmer-basic-permission-visitor' => 'Regte vir elke besoeker',
	'farmer-basic-permission-visitor-text' => 'Die volgende regte sal op elke persoon wat hierdie wiki besoek toegepas word',
	'farmer-yes' => 'Ja',
	'farmer-no' => 'Nee',
	'farmer-basic-permission-user' => 'Regte vir aangetekende gebruikers',
	'farmer-basic-permission-user-text' => 'Die volgende regte sal op elke persoon wat ingeteken is by hierdie wiki toegepas word',
	'farmer-setpermission' => 'Stel regte',
	'farmer-defaultskin' => 'Standaard vel',
	'farmer-defaultskin-button' => 'Stel standaard vel',
	'farmer-extensions' => 'Aktiewe uitbreidings',
	'farmer-extensions-button' => 'Stel aktiewe uitbreidings',
	'farmer-extensions-extension-denied' => "Jy het nie toestemming om hierdie funksie te gebruik nie.
Jy moet n lid wees van die ''farmeradmin'' groep",
	'farmer-extensions-invalid' => 'Ongeldige uitbreiding',
	'farmer-extensions-invalid-text' => 'Ons kon nie die uitbreiding byvoeg nie, omdat die lêer gekies vir insluiting nie gevind kon word nie',
	'farmer-extensions-available' => 'Beskikbare uitbreidings',
	'farmer-extensions-noavailable' => 'Geen uitbreidings is geregistreer',
	'farmer-extensions-register' => 'Registreer uitbreiding',
	'farmer-extensions-register-text1' => "Gebruik die vorm hieronder om 'n nuwe uitbreiding in die plaas te registreer.
Sodra' n uitbreiding geregistreer is, sal alle wikis in staat te wees om dit te gebruik.",
	'farmer-extensions-register-text2' => "Vir die ''Sluit lêer in'' parameter, tik die naam van die PHP-lêer soos jy sou in die LocalSettings.php.",
	'farmer-extensions-register-text3' => "As die lêernaam '''\$root''' bevat, sal daardie veranderlike met die MediaWiki wortelvouer vervang word.",
	'farmer-extensions-register-text4' => 'Die huidige ingeslote paaie is:',
	'farmer-extensions-register-name' => 'Naam',
	'farmer-extensions-register-includefile' => 'Sluit in lêer',
	'farmer-error-exists' => 'Kan nie wiki skep nie. Dit bestaan reeds: $1',
	'farmer-error-noextwrite' => 'Nie in staat om die uitbreiding lêer te skryf nie:',
	'farmer-log-name' => 'Wiki plaas boekstaaf',
	'farmer-log-header' => "Hierdie is 'n boekstaaf van veranderinge gemaak aan die wiki plaas.",
	'farmer-log-create' => 'wiki "$2" is geskep',
	'farmer-log-delete' => 'wiki "$2" is verwyder',
	'right-farmeradmin' => 'Bestuur die wiki plaas',
	'right-createwiki' => 'Skep wikis in die wiki plaas',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'farmer-yes' => 'Po',
	'farmer-no' => 'Jo',
	'farmer-basic-permission-user' => 'Lejet për përdoruesit e regjistruar',
	'farmer-basic-permission-user-text' => 'Lejet e mëposhtme do të zbatohet për çdo person që është regjistruar në këtë wiki',
	'farmer-setpermission' => 'leje Set',
	'farmer-defaultskin' => 'Default lëkurës',
	'farmer-defaultskin-button' => 'lëkurës Set default',
	'farmer-extensions' => 'Active extensions',
	'farmer-extensions-button' => 'Set extensions aktiv',
	'farmer-extensions-extension-denied' => 'Ju nuk keni leje për të përdorni këtë funksion. Ju duhet të jetë një anëtar i grupit farmeradmin',
	'farmer-extensions-invalid' => 'zgjerimin e pavlefshme',
	'farmer-extensions-invalid-text' => 'Ne nuk mund te shtohet zgjerimi për shkak file e zgjedhur për përfshirjen nuk mund të gjendet',
	'farmer-extensions-available' => 'extensions në dispozicion',
	'farmer-extensions-noavailable' => 'Nuk extensions janë të regjistruar',
	'farmer-extensions-register' => 'zgjatje Regjistrohu',
	'farmer-extensions-register-text1' => 'Përdorni formularin e mëposhtëm për të regjistruar një shtyrje të re me të fermës. Pasi një zgjatje është e regjistruar, të gjitha wikis do të jetë në gjendje ta përdorin atë.',
	'farmer-extensions-register-text2' => "Për Përfshij skedarin''''parametër, shkruani emrin e PHP fotografi si ju do në LocalSettings.php.",
	'farmer-extensions-register-text3' => "Nëse emri i përmban'''rrënjë \$''', që ndryshueshme do të zëvendësohet me MediaWiki root directory.",
	'farmer-extensions-register-text4' => 'Përfshijnë aktuale shtigjet janë:',
	'farmer-extensions-register-name' => 'Emër',
	'farmer-extensions-register-includefile' => 'Përfshij fotografi',
	'farmer-error-exists' => 'Nuk mund te krijohet wiki. Ajo ekziston: $1',
	'farmer-error-noextwrite' => 'Në pamundësi për të shkruar nga zgjerim file:',
	'farmer-log-name' => 'Wiki log fermë',
	'farmer-log-header' => 'Ky është një regjistër për ndryshimet e bëra në fermë wiki.',
	'farmer-log-create' => 'krijoi wiki "$2"',
	'farmer-log-delete' => 'fshihet wiki "$2"',
	'right-farmeradmin' => 'Manage fermë wiki',
	'right-createwiki' => 'Krijo wikis në fermë wiki',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'farmer-confirmsetting-name' => 'ስም',
	'farmer-confirmsetting-title' => 'አርዕስት',
	'farmer-mainpage' => 'ዋና ገጽ',
	'farmer-basic-title1' => 'አርዕስት',
	'farmer-yes' => 'አዎ',
	'farmer-extensions-register-name' => 'ስም',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'farmer-confirmsetting-name' => 'Nombre',
	'farmer-confirmsetting-description' => 'Descripción',
	'farmer-confirmsetting-reason' => 'Razón',
	'farmer-description' => 'Descripción',
	'farmer-button-confirm' => 'Confirmar',
	'farmer-button-submit' => 'Ninviar',
	'farmer-createwiki-form-help' => 'Aduya',
	'farmer-createwiki-description' => 'Descripción',
	'farmer-createwiki-reason' => 'Razón',
	'farmer-delete-form-submit' => 'Borrar',
	'farmer-basic-description' => 'Descripción',
	'farmer-yes' => 'Sí',
	'farmer-no' => 'No',
	'farmer-extensions-register-name' => 'Nombre',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'farmer' => 'مزارع',
	'farmer-desc' => 'التحكم بمزرعة ميدياويكي',
	'farmercantcreatewikis' => 'أنت غير قادر على إنشاء ويكيات لأنك لا تمتلك الصلاحية createwikis',
	'farmercreateurl' => 'مسار',
	'farmercreatesitename' => 'اسم الموقع',
	'farmercreatenextstep' => 'الخطوة التالية',
	'farmernewwikimainpage' => '== مرحبا في الويكي الخاص بك ==
لو أنك تقرأ هذا، فالويكي الجديد الخاص بك تم تنصيبه بشكل صحيح.
يمكنك [[Special:Farmer|تخصيص الويكي الخاص بك]].',
	'farmer-about' => 'عن',
	'farmer-about-text' => 'مزارع ميدياويكي يسمح لك بإدارة مزرعة من ويكيات ميدياويكي.',
	'farmer-list-wiki' => 'قائمة الويكيات',
	'farmer-list-wiki-text' => '[[$1|عرض]] كل الويكيات في {{SITENAME}}',
	'farmer-createwiki' => 'إنشاء ويكي',
	'farmer-createwiki-text' => '[[$1|إنشاء]] ويكي جديد الآن!',
	'farmer-administration' => 'إدارة المزرعة',
	'farmer-administration-extension' => 'التحكم بالامتدادات',
	'farmer-administration-extension-text' => '[[$1|التحكم]] بالامتدادات المنصبة.',
	'farmer-admimistration-listupdate' => 'تحديث قائمة المزرعة',
	'farmer-admimistration-listupdate-text' => '[[$1|تحديث]] قائمة الويكيات في {{SITENAME}}',
	'farmer-administration-delete' => 'حذف ويكي',
	'farmer-administration-delete-text' => '[[$1|حذف]] ويكي من المزرعة',
	'farmer-administer-thiswiki' => 'إدارة هذه الويكي',
	'farmer-administer-thiswiki-text' => '[[$1|إدارة]] التغييرات إلى هذه الويكي',
	'farmer-notavailable' => 'غير متوفرة',
	'farmer-notavailable-text' => 'هذه الخاصية متوفرة فقط في الويكي الرئيسي',
	'farmer-wikicreated' => 'الويكي تم إنشاؤه',
	'farmer-wikicreated-text' => 'الويكي الخاص بك تم إنشاؤه.
يمكن الوصول إليه في $1',
	'farmer-default' => 'افتراضيا، لا أحد لديه سماحات في هذا الويكي فيماعداك.
يمكنك تغيير صلاحيات المستخدم من خلال $1',
	'farmer-wikiexists' => 'الويكي موجود',
	'farmer-wikiexists-text' => "الويكي التي تحاول إنشاءه، '''$1'''، موجود بالفعل.
من فضلك عد وجرب اسما آخر.",
	'farmer-confirmsetting' => 'تأكيد إعدادات الويكي',
	'farmer-confirmsetting-name' => 'الاسم',
	'farmer-confirmsetting-title' => 'العنوان',
	'farmer-confirmsetting-description' => 'الوصف',
	'farmer-confirmsetting-reason' => 'السبب',
	'farmer-description' => 'وصف',
	'farmer-confirmsetting-text' => "الويكي الخاص بك، '''$1'''، سيمكن الوصول إليه من خلال $3.
نطاق المشروع سيصبح '''$2'''.
الوصلات إلى هذا النطاق ستكون من الشكل '''<nowiki>[[$2:Page name]]</nowiki>'''.
لو أن هذا ما تريده، اضغط زر '''تأكيد''' بالأسفل.",
	'farmer-button-confirm' => 'تأكيد',
	'farmer-button-submit' => 'أرسل',
	'farmer-createwiki-form-title' => 'إنشاء ويكي',
	'farmer-createwiki-form-text1' => 'استخدم الاستمارة بالأسفل لإنشاء ويكي جديدة.',
	'farmer-createwiki-form-help' => 'مساعدة',
	'farmer-createwiki-form-text2' => "; اسم الويكي: الاسم الخاص بالويكي.
يحتوي فقط على حروف وأرقام.
اسم الويكي سيستخدم كجزء من المسار للتعرف على الويكي الخاصة بك.
على سبيل المثال، لو أنك أدخلت '''title'''، فسيصبح الويكي الخاص بك متاحا للوصول إليها من خلال <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; عنوان الويكي: العنوان الخاص بالويكي.
سيستخدم في عنوان كل صفحة في الويكي الخاصة بك.
سيصبح أيضا نطاق المشروع وبادئة الإنترويكي.',
	'farmer-createwiki-form-text4' => '; الوصف: وصف الويكي.
هذا نص لوصف الويكي.
هذا سيعرض في قائمة الويكي.',
	'farmer-createwiki-user' => 'اسم المستخدم',
	'farmer-createwiki-name' => 'اسم الويكي',
	'farmer-createwiki-title' => 'عنوان الويكي',
	'farmer-createwiki-description' => 'الوصف',
	'farmer-createwiki-reason' => 'السبب',
	'farmer-updatedlist' => 'قائمة محدثة',
	'farmer-notaccessible' => 'لا يمكن الوصول إليه',
	'farmer-notaccessible-test' => 'هذه الخاصية متوفرة فقط في الويكي الأساسي في المزرعة',
	'farmer-permissiondenied' => 'السماح مرفوض',
	'farmer-permissiondenied-text' => 'أنت لا تمتلك السماح لحذف ويكي من المزرعة',
	'farmer-permissiondenied-text1' => 'أنت لا تمتلك السماح لرؤية هذه الصفحة',
	'farmer-deleting' => 'الويكي "$1" تم حذفه',
	'farmer-delete-confirm' => 'أنا أؤكد أنني أريد حذف هذا الويكي',
	'farmer-delete-confirm-wiki' => "الويكي للحذف: '''$1'''.",
	'farmer-delete-reason' => 'سبب الحذف:',
	'farmer-delete-title' => 'حذف الويكي',
	'farmer-delete-text' => 'من فضلك اختر الويكي من القائمة بالأسفل الذي ترغب في حذفه',
	'farmer-delete-form' => 'اختر ويكي',
	'farmer-delete-form-submit' => 'احذف',
	'farmer-listofwikis' => 'قائمة الويكيات',
	'farmer-mainpage' => 'الصفحة الرئيسية',
	'farmer-basic-title' => 'المحددات الأساسية',
	'farmer-basic-title1' => 'عنوان',
	'farmer-basic-title1-text' => 'الويكي الخاص بك لا يمتلك عنوانا.  حدد واحدا <b>الآن</b>',
	'farmer-basic-description' => 'وصف',
	'farmer-basic-description-text' => 'ضع وصف الويكي الخاصة بك بالأسفل',
	'farmer-basic-permission' => 'سماحات',
	'farmer-basic-permission-text' => 'باستخدام الاستمارة بالأسفل، من الممكن تعديل السماحات لمستخدمي هذا الويكي.',
	'farmer-basic-permission-visitor' => 'السماحات لكل زائر',
	'farmer-basic-permission-visitor-text' => 'السماحات التالية سيتم تطبيقها على كل شخص يزور هذه الويكي',
	'farmer-yes' => 'نعم',
	'farmer-no' => 'لا',
	'farmer-basic-permission-user' => 'السماحات للمستخدمين المسجلين',
	'farmer-basic-permission-user-text' => 'السماحات التالية سيتم تطبيقها على كل شخص مسجل للدخول إلى هذا الويكي',
	'farmer-setpermission' => 'ضبط السماحات',
	'farmer-defaultskin' => 'الواجهة الافتراضية',
	'farmer-defaultskin-button' => 'ضبط الواجهة الافتراضية',
	'farmer-extensions' => 'الامتدادات النشطة',
	'farmer-extensions-button' => 'ضبط الامتدادات النشطة',
	'farmer-extensions-extension-denied' => 'أنت لا تمتلك السماح لاستخدام هذه الخاصية.
يجب أن تكون عضوا في مجموعة إداريي المزرعة',
	'farmer-extensions-invalid' => 'امتداد غير صحيح',
	'farmer-extensions-invalid-text' => 'لم يمكننا إضافة الامتداد لأن الملف المختار للتضمين لم يمكن إيجاده',
	'farmer-extensions-available' => 'الامتدادات المتوفرة',
	'farmer-extensions-noavailable' => 'لا امتدادات مسجلة',
	'farmer-extensions-register' => 'تسجيل امتداد',
	'farmer-extensions-register-text1' => 'استخدم الاستمارة بالأسفل لتسجيل امتداد جديد للمزرعة.
متى تم تسجيل امتداد ما، كل الويكيات ستصبح قادرة على استخدامه.',
	'farmer-extensions-register-text2' => "لمحدد ''Include File''، أدخل اسم ملف PHP كما كنت ستفعل في LocalSettings.php.",
	'farmer-extensions-register-text3' => "لو أن اسم الملف يحتوي على '''\$root'''، هذا المتغير سيتم استبداله بمجلد الجذر للميدياويكي.",
	'farmer-extensions-register-text4' => 'مسارات التضمين الحالية هي:',
	'farmer-extensions-register-name' => 'الاسم',
	'farmer-extensions-register-includefile' => 'ضمن الملف',
	'farmer-error-exists' => 'لم يمكن إنشاء الويكي.  هو موجود بالفعل: $1',
	'farmer-error-noextwrite' => 'غير قادر على كتابة ملف الامتداد:',
	'farmer-log-name' => 'سجل مزرعة الويكي',
	'farmer-log-header' => 'هذا سجل بالتغييرات المعمولة لمزرعة الويكي.',
	'farmer-log-create' => 'أنشأ الويكي "$2"',
	'farmer-log-delete' => 'حذف الويكي "$2"',
	'right-farmeradmin' => 'أدر مزرعة الويكي',
	'right-createwiki' => 'أنشئ ويكيات في مزرعة الويكي',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'farmercreatesitename' => 'ܫܡܐ ܕܕܘܟܬܐ',
	'farmer-list-wiki' => 'ܡܟܬܒܘܬܐ ܕܘܝܩܝ̈ܐ',
	'farmer-administration-delete' => 'ܫܘܦ ܘܝܩܝ',
	'farmer-wikicreated' => 'ܘܝܩܝ ܐܬܒܪܝܬ',
	'farmer-confirmsetting-name' => 'ܫܡܐ',
	'farmer-confirmsetting-title' => 'ܟܘܢܝܐ',
	'farmer-confirmsetting-description' => 'ܫܘܡܗܐ',
	'farmer-confirmsetting-reason' => 'ܥܠܬܐ',
	'farmer-description' => 'ܫܘܡܗܐ',
	'farmer-button-confirm' => 'ܚܬܬ',
	'farmer-button-submit' => 'ܫܕܪ',
	'farmer-createwiki-form-title' => 'ܒܪܝ ܘܝܩܝ',
	'farmer-createwiki-form-help' => 'ܥܘܕܪܢܐ',
	'farmer-createwiki-user' => 'ܫܡܐ ܕܡܦܠܚܢܐ',
	'farmer-createwiki-name' => 'ܫܡܐ ܕܘܝܩܝ',
	'farmer-createwiki-title' => 'ܟܘܢܝܐ ܕܘܝܩܝ',
	'farmer-createwiki-description' => 'ܫܘܡܗܐ',
	'farmer-createwiki-reason' => 'ܥܠܬܐ',
	'farmer-delete-reason' => 'ܥܠܬܐ ܕܫܝܦܐ:',
	'farmer-delete-title' => 'ܫܘܦ ܘܝܩܝ',
	'farmer-delete-form-submit' => 'ܫܘܦ',
	'farmer-listofwikis' => 'ܡܟܬܒܘܬܐ ܕܘܝܩܝ̈ܐ',
	'farmer-mainpage' => 'ܦܐܬܐ ܪܫܝܬܐ',
	'farmer-basic-title1' => 'ܟܘܢܝܐ',
	'farmer-basic-description' => 'ܫܘܡܗܐ',
	'farmer-yes' => 'ܐܝܢ',
	'farmer-no' => 'ܠܐ',
	'farmer-extensions-register-name' => 'ܫܡܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'farmer' => 'مزارع',
	'farmer-desc' => 'التحكم بمزرعة ميدياويكي',
	'farmercantcreatewikis' => 'أنت غير قادر على إنشاء ويكيات لأنك لا تمتلك الصلاحية createwikis',
	'farmercreateurl' => 'مسار',
	'farmercreatesitename' => 'اسم الموقع',
	'farmercreatenextstep' => 'الخطوة التالية',
	'farmernewwikimainpage' => '== مرحبا فى الويكى الخاص بك ==
لو أنك تقرأ هذا، فالويكى الجديد الخاص بك تم تنصيبه بشكل صحيح.
يمكنك [[Special:Farmer|تخصيص الويكى الخاص بك]].',
	'farmer-about' => 'حول',
	'farmer-about-text' => 'مزارع ميدياويكى يسمح لك بإدارة مزرعة من ويكيات ميدياويكى.',
	'farmer-list-wiki' => 'قائمة الويكيات',
	'farmer-list-wiki-text' => '[[$1|عرض]] كل الويكيات فى {{SITENAME}}',
	'farmer-createwiki' => 'إنشاء ويكي',
	'farmer-createwiki-text' => '[[$1|إنشاء]] ويكى جديد الآن!',
	'farmer-administration' => 'إدارة المزرعة',
	'farmer-administration-extension' => 'التحكم بالامتدادات',
	'farmer-administration-extension-text' => '[[$1|التحكم]] بالامتدادات المنصبة.',
	'farmer-admimistration-listupdate' => 'تحديث قائمة المزرعة',
	'farmer-admimistration-listupdate-text' => '[[$1|تحديث]] قائمة الويكيات فى {{SITENAME}}',
	'farmer-administration-delete' => 'حذف ويكي',
	'farmer-administration-delete-text' => '[[$1|حذف]] ويكى من المزرعة',
	'farmer-administer-thiswiki' => 'إدارة هذه الويكي',
	'farmer-administer-thiswiki-text' => '[[$1|إدارة]] التغييرات إلى هذه الويكي',
	'farmer-notavailable' => 'غير متوفرة',
	'farmer-notavailable-text' => 'هذه الخاصية متوفرة فقط فى الويكى الرئيسي',
	'farmer-wikicreated' => 'الويكى تم إنشاؤه',
	'farmer-wikicreated-text' => 'الويكى الخاص بك تم إنشاؤه.
يمكن الوصول إليه فى $1',
	'farmer-default' => 'افتراضيا، لا أحد لديه سماحات فى هذا الويكى فيماعداك.
يمكنك تغيير صلاحيات المستخدم من خلال $1',
	'farmer-wikiexists' => 'الويكى موجود',
	'farmer-wikiexists-text' => "الويكى التى تحاول إنشاءه، '''$1'''، موجود بالفعل.
من فضلك عد وجرب اسما آخر.",
	'farmer-confirmsetting' => 'تأكيد إعدادات الويكي',
	'farmer-confirmsetting-name' => 'الاسم',
	'farmer-confirmsetting-title' => 'العنوان',
	'farmer-confirmsetting-description' => 'الوصف',
	'farmer-description' => 'وصف',
	'farmer-confirmsetting-text' => "الويكى الخاص بك، '''$1'''، سيمكن الوصول إليه من خلال $3.
نطاق المشروع سيصبح '''$2'''.
الوصلات إلى هذا النطاق ستكون من الشكل '''<nowiki>[[$2:Page name]]</nowiki>'''.
لو أن هذا ما تريده، اضغط زر '''تأكيد''' بالأسفل.",
	'farmer-button-confirm' => 'تأكيد',
	'farmer-button-submit' => 'تنفيذ',
	'farmer-createwiki-form-title' => 'إنشاء ويكي',
	'farmer-createwiki-form-text1' => 'استخدم الاستمارة بالأسفل لإنشاء ويكى جديدة.',
	'farmer-createwiki-form-help' => 'مساعدة',
	'farmer-createwiki-form-text2' => "; اسم الويكي: الاسم الخاص بالويكى.
يحتوى فقط على حروف وأرقام.
اسم الويكى سيستخدم كجزء من المسار للتعرف على الويكى الخاصة بك.
على سبيل المثال، لو أنك أدخلت '''title'''، فسيصبح الويكى الخاص بك متاحا للوصول إليها من خلال <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; عنوان الويكي: العنوان الخاص بالويكى.
سيستخدم فى عنوان كل صفحة فى الويكى الخاصة بك.
سيصبح أيضا نطاق المشروع وبادئة الإنترويكى.',
	'farmer-createwiki-form-text4' => '; الوصف: وصف الويكى.
هذا نص لوصف الويكى.
هذا سيعرض فى قائمة الويكى.',
	'farmer-createwiki-user' => 'اسم المستخدم',
	'farmer-createwiki-name' => 'اسم الويكي',
	'farmer-createwiki-title' => 'عنوان الويكي',
	'farmer-createwiki-description' => 'الوصف',
	'farmer-updatedlist' => 'قائمة محدثة',
	'farmer-notaccessible' => 'لا يمكن الوصول إليه',
	'farmer-notaccessible-test' => 'هذه الخاصية متوفرة فقط فى الويكى الأساسى فى المزرعة',
	'farmer-permissiondenied' => 'السماح مرفوض',
	'farmer-permissiondenied-text' => 'أنت لا تمتلك السماح لحذف ويكى من المزرعة',
	'farmer-permissiondenied-text1' => 'أنت لا تمتلك السماح لرؤية هذه الصفحة',
	'farmer-deleting' => 'الويكى "$1" تم حذفه',
	'farmer-delete-title' => 'حذف الويكي',
	'farmer-delete-text' => 'من فضلك اختر الويكى من القائمة بالأسفل الذى ترغب فى حذفه',
	'farmer-delete-form' => 'اختر ويكي',
	'farmer-delete-form-submit' => 'حذف',
	'farmer-listofwikis' => 'قائمة الويكيات',
	'farmer-mainpage' => 'الصفحة الرئيسية',
	'farmer-basic-title' => 'المحددات الأساسية',
	'farmer-basic-title1' => 'عنوان',
	'farmer-basic-title1-text' => 'الويكى الخاص بك لا يمتلك عنوانا.  حدد واحدا <b>الآن</b>',
	'farmer-basic-description' => 'وصف',
	'farmer-basic-description-text' => 'ضع وصف الويكى الخاصة بك بالأسفل',
	'farmer-basic-permission' => 'سماحات',
	'farmer-basic-permission-text' => 'باستخدام الاستمارة بالأسفل، من الممكن تعديل السماحات لمستخدمى هذا الويكى.',
	'farmer-basic-permission-visitor' => 'السماحات لكل زائر',
	'farmer-basic-permission-visitor-text' => 'السماحات التالية سيتم تطبيقها على كل شخص يزور هذه الويكي',
	'farmer-yes' => 'نعم',
	'farmer-no' => 'لا',
	'farmer-basic-permission-user' => 'السماحات للمستخدمين المسجلين',
	'farmer-basic-permission-user-text' => 'السماحات التالية سيتم تطبيقها على كل شخص مسجل للدخول إلى هذا الويكي',
	'farmer-setpermission' => 'ضبط السماحات',
	'farmer-defaultskin' => 'الواجهة الافتراضية',
	'farmer-defaultskin-button' => 'ضبط الواجهة الافتراضية',
	'farmer-extensions' => 'الامتدادات النشطة',
	'farmer-extensions-button' => 'ضبط الامتدادات النشطة',
	'farmer-extensions-extension-denied' => 'أنت لا تمتلك السماح لاستخدام هذه الخاصية.
يجب أن تكون عضوا فى مجموعة إداريى المزرعة',
	'farmer-extensions-invalid' => 'امتداد غير صحيح',
	'farmer-extensions-invalid-text' => 'لم يمكننا إضافة الامتداد لأن الملف المختار للتضمين لم يمكن إيجاده',
	'farmer-extensions-available' => 'الامتدادات المتوفرة',
	'farmer-extensions-noavailable' => 'لا امتدادات مسجلة',
	'farmer-extensions-register' => 'تسجيل امتداد',
	'farmer-extensions-register-text1' => 'استخدم الاستمارة بالأسفل لتسجيل امتداد جديد للمزرعة.
متى تم تسجيل امتداد ما، كل الويكيات ستصبح قادرة على استخدامه.',
	'farmer-extensions-register-text2' => "لمحدد ''Include File''، أدخل اسم ملف PHP كما كنت ستفعل فى LocalSettings.php.",
	'farmer-extensions-register-text3' => "لو أن اسم الملف يحتوى على '''\$root'''، هذا المتغير سيتم استبداله بمجلد الجذر للميدياويكى.",
	'farmer-extensions-register-text4' => 'مسارات التضمين الحالية هي:',
	'farmer-extensions-register-name' => 'الاسم',
	'farmer-extensions-register-includefile' => 'ضمن الملف',
	'farmer-error-exists' => 'لم يمكن إنشاء الويكى.  هو موجود بالفعل: $1',
	'farmer-error-noextwrite' => 'غير قادر على كتابة ملف الامتداد:',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Wertuose
 */
$messages['az'] = array(
	'farmer-list-wiki' => 'Vikilərin siyahısı',
	'farmer-confirmsetting-name' => 'Ad',
	'farmer-confirmsetting-title' => 'Başlıq',
	'farmer-button-confirm' => 'Təsdiq et',
	'farmer-button-submit' => 'Təsdiq et',
	'farmer-createwiki-form-help' => 'Kömək',
	'farmer-createwiki-user' => 'İstifadəçi adı',
	'farmer-createwiki-name' => 'Viki adı',
	'farmer-createwiki-reason' => 'Səbəb',
	'farmer-delete-form-submit' => 'Sil',
	'farmer-listofwikis' => 'Vikilərin siyahısı',
	'farmer-mainpage' => 'Ana Səhifə',
	'farmer-basic-title1' => 'Başlıq',
	'farmer-yes' => 'Bəli',
	'farmer-no' => 'Xeyr',
	'farmer-extensions-register-name' => 'Ad',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'farmer-confirmsetting-reason' => 'Прычына',
	'farmer-button-confirm' => 'Пацвердзіць',
	'farmer-createwiki-form-help' => 'Даведка',
	'farmer-createwiki-reason' => 'Прычына',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'farmer' => 'Фэрмэр',
	'farmer-desc' => 'Кіраваньне фэрмай MediaWiki',
	'farmercantcreatewikis' => 'Вы ня можаце стварыць вікі, таму што ня маеце адпаведных правоў',
	'farmercreatesitename' => 'Назва сайта',
	'farmercreatenextstep' => 'Наступны крок',
	'farmernewwikimainpage' => '== Вітаем у Вашай вікі ==
Калі Вы чытаеце гэты тэкст, гэта азначае, што Вашая новая вікі была пасьпяхова ўсталяваная.
Вы можаце далей [[Special:Farmer|канфігураваць Вашую вікі]].',
	'farmer-about' => 'Пра фэрму',
	'farmer-about-text' => 'Пашырэньне фэрмер MediaWiki дазваляе Вам кіраваць фэрмай (групай сэрвэраў) вікі.',
	'farmer-list-wiki' => 'Сьпіс вікі',
	'farmer-list-wiki-text' => '[[$1|Сьпіс]] усіх вікі на сайце {{SITENAME}}',
	'farmer-createwiki' => 'Стварыць вікі',
	'farmer-createwiki-text' => '[[$1|Стварыць]] новую вікі!',
	'farmer-administration' => 'Кіраваньне фэрмай',
	'farmer-administration-extension' => 'Кіраваньне пашырэньнямі',
	'farmer-administration-extension-text' => '[[$1|Кіраваньне]] усталяванымі пашырэньнямі.',
	'farmer-admimistration-listupdate' => 'Абнаўленьне сьпісу фэрмаў',
	'farmer-admimistration-listupdate-text' => '[[$1|Абнаўленьне]] сьпісу вікі на сайце {{SITENAME}}',
	'farmer-administration-delete' => 'Выдаліць вікі',
	'farmer-administration-delete-text' => '[[$1|Выдаліць]] вікі з фэрмы',
	'farmer-administer-thiswiki' => 'Кіраваць гэтай вікі',
	'farmer-administer-thiswiki-text' => '[[$1|Адміністратыўныя]] зьмены ў гэтай вікі',
	'farmer-notavailable' => 'Не даступна',
	'farmer-notavailable-text' => 'Гэта магчымасьць даступна толькі ў галоўнай вікі',
	'farmer-wikicreated' => 'Вікі створаная',
	'farmer-wikicreated-text' => 'Ваша вікі была створаная.
Яна даступная на $1',
	'farmer-default' => 'Па змоўчваньні, ніхто, акрамя Вас, ня мае правоў у гэтай вікі.
Вы можаце зьмяніць правы ўдзельнікаў праз $1',
	'farmer-wikiexists' => 'Вікі існуе',
	'farmer-wikiexists-text' => "Вікі '''$1''', якую Вы спрабуеце стварыць, ужо існуе.
Калі ласка, вярніцеся і паспрабуйце іншую назву.",
	'farmer-confirmsetting' => 'Пацьвердзіць налады вікі',
	'farmer-confirmsetting-name' => 'Назва',
	'farmer-confirmsetting-title' => 'Назва',
	'farmer-confirmsetting-description' => 'Апісаньне',
	'farmer-confirmsetting-reason' => 'Прычына',
	'farmer-description' => 'Апісаньне',
	'farmer-confirmsetting-text' => "Ваша вікі, '''$1''', будзе даступна па адрасу $3.
Прастора назваў праекту будзе '''$2'''.
Спасылкі на гэту прастору назваў будуць у форме '''<nowiki>[[$2:Назва старонкі]]</nowiki>'''.
Калі гэта тое, што Вы жадаеце, націсьніце кнопку '''пацьвердзіць''' унізе.",
	'farmer-button-confirm' => 'Пацьвердзіць',
	'farmer-button-submit' => 'Адправіць',
	'farmer-createwiki-form-title' => 'Стварэньне вікі',
	'farmer-createwiki-form-text1' => 'Выкарыстоўвайце форму ніжэй, каб стварыць новую вікі.',
	'farmer-createwiki-form-help' => 'Дапамога',
	'farmer-createwiki-form-text2' => "; Назва вікі: Гэта назва вікі.
Можа ўтрымліваць толькі літары і лічбы.
Назва вікі будзе выкарыстоўвацца як частка URL-адрасу для вызначэньня Вашай вікі.
Напрыклад, калі ўведзяце '''title''', то Вашая вікі будзе даступна па адрасу <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Назва вікі: Гэта назва вікі.
Будзе выкарыстоўвацца ў назьве на кожнай старонцы ў Вашай вікі.
Таксама будзе выкарыстоўвацца ў прасторы назваў праекту і інтэрвікі-прэфікс.',
	'farmer-createwiki-form-text4' => '; Апісаньне: Апісаньне вікі.
Гэта тэкставае апісаньне вікі.
Яно будзе выкарыстоўвацца ў сьпісе вікі.',
	'farmer-createwiki-user' => 'Імя ўдзельніка',
	'farmer-createwiki-name' => 'Назва вікі',
	'farmer-createwiki-title' => 'Загаловак вікі',
	'farmer-createwiki-description' => 'Апісаньне',
	'farmer-createwiki-reason' => 'Прычына',
	'farmer-updatedlist' => 'Абноўлены сьпіс',
	'farmer-notaccessible' => 'Не даступна',
	'farmer-notaccessible-test' => 'Гэта магчымасьць даступная толькі на мацярынскай вікі фэрмы',
	'farmer-permissiondenied' => 'Доступ забаронены',
	'farmer-permissiondenied-text' => 'Вы ня маеце правоў на выдаленьне вікі з фэрмы',
	'farmer-permissiondenied-text1' => 'Вы ня маеце дазволу на доступ да гэтай старонкі',
	'farmer-deleting' => 'Вікі «$1» была выдаленая',
	'farmer-delete-confirm' => 'Я пацьвярджаю, што жадаю выдаліць гэту вікі',
	'farmer-delete-confirm-wiki' => "Вікі на выдаленьне: '''$1'''.",
	'farmer-delete-reason' => 'Прычына выдаленьня:',
	'farmer-delete-title' => 'Выдаленьне вікі',
	'farmer-delete-text' => 'Калі ласка, выберыце вікі, якую Вы жадаеце выдаліць, са сьпісу ніжэй',
	'farmer-delete-form' => 'Выбар вікі',
	'farmer-delete-form-submit' => 'Выдаліць',
	'farmer-listofwikis' => 'Сьпіс вікі',
	'farmer-mainpage' => 'Галоўная старонка',
	'farmer-basic-title' => 'Асноўныя парамэтры',
	'farmer-basic-title1' => 'Назва',
	'farmer-basic-title1-text' => 'Вашая вікі ня мае загалоўка. Устанавіце яго <b>зараз</b>',
	'farmer-basic-description' => 'Апісаньне',
	'farmer-basic-description-text' => 'Увядзіце апісаньне Вашай вікі ніжэй',
	'farmer-basic-permission' => 'Правы',
	'farmer-basic-permission-text' => 'Выкарыстоўвайце форму ніжэй, каб кіраваць правамі ўдзельнікаў гэтай вікі.',
	'farmer-basic-permission-visitor' => 'Правы для ўсіх наведвальнікаў',
	'farmer-basic-permission-visitor-text' => 'Наступнымі правамі будзе валодаць кожны наведвальнік гэтай вікі',
	'farmer-yes' => 'Так',
	'farmer-no' => 'Не',
	'farmer-basic-permission-user' => 'Правы зарэгістраваных удзельнікаў',
	'farmer-basic-permission-user-text' => 'Наступнымі правамі будзе валодаць кожны зарэгістраваны ўдзельнік гэтай вікі',
	'farmer-setpermission' => 'Устанавіць правы',
	'farmer-defaultskin' => 'Афармленьне па змоўчваньні',
	'farmer-defaultskin-button' => 'Устанавіць афармленьне па змоўчваньні',
	'farmer-extensions' => 'Актыўныя пашырэньні',
	'farmer-extensions-button' => 'Усталяваць актыўныя пашырэньні',
	'farmer-extensions-extension-denied' => 'Вы ня маеце правоў для выкарыстаньня гэтай магчымасьці.
Вы павінны ўваходзіць у групу адміністратараў фэрмы',
	'farmer-extensions-invalid' => 'Няслушнае пашырэньне',
	'farmer-extensions-invalid-text' => 'Вы ня можаце дадаць пашырэньне, таму што выбраны для даданьня файл ня знойдзены',
	'farmer-extensions-available' => 'Даступныя пашырэньні',
	'farmer-extensions-noavailable' => 'Няма зарэгістраваных пашырэньняў',
	'farmer-extensions-register' => 'Зарэгістраваныя пашырэньні',
	'farmer-extensions-register-text1' => 'Выкарыстоўвайце форму ніжэй для рэгістрацыі новага пашырэньня на фэрме.
Пасьля таго, як пашырэньне будзе зарэгістраванае, усе вікі змогуць яго выкарыстоўваць.',
	'farmer-extensions-register-text2' => "Увядзіце назву PHP-файла для парамэтру ''Include file'', так як у LocalSettings.php.",
	'farmer-extensions-register-text3' => "Калі назва файла ўтрымлівае '''\$root''', то гэтая зьменная будзе замененая на карэнную дырэкторыю MediaWiki.",
	'farmer-extensions-register-text4' => 'Існуючыя шляхі для ўключэньня:',
	'farmer-extensions-register-name' => 'Назва',
	'farmer-extensions-register-includefile' => 'Уключыць файл',
	'farmer-error-exists' => 'Немагчыма стварыць вікі. Яна ўжо існуе: $1',
	'farmer-error-noextwrite' => 'Немагчыма запісаць файл пашырэньня:',
	'farmer-log-name' => 'Журнал вікі-фэрмы',
	'farmer-log-header' => 'Гэта журнал зьменаў зробленых на вікі-фэрме.',
	'farmer-log-create' => 'створаная вікі «$2»',
	'farmer-log-delete' => 'выдаленая вікі «$2»',
	'right-farmeradmin' => 'кіраваньне вікі-фэрмай',
	'right-createwiki' => 'стварэньне вікі на вікі-фэрме',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 */
$messages['bg'] = array(
	'farmer' => 'Фермер',
	'farmer-desc' => 'Управление на МедияУики ферма',
	'farmercantcreatewikis' => 'Не можете да създавате уикита, тъй като нямате необходимите права („createwikis“)',
	'farmercreateurl' => 'Адрес',
	'farmercreatesitename' => 'Име на сайта',
	'farmercreatenextstep' => 'Следваща стъпка',
	'farmernewwikimainpage' => '== Добре дошли във Вашето уики ==
Ако виждате това, значи вашето ново уики е инсталирано правилно. За настройки на уикито може да се използва [[Special:Farmer]].',
	'farmer-about' => 'Информация',
	'farmer-about-text' => 'МедияУики Фермер позволява управлението на ферма от МедияУики уикита.',
	'farmer-list-wiki' => 'Списък на уикита',
	'farmer-list-wiki-text' => '[[$1|Списък]] на всички налични уикита в {{SITENAME}}',
	'farmer-createwiki' => 'Създаване на уики',
	'farmer-createwiki-text' => '[[$1|Създаване]] на ново уики',
	'farmer-administration' => 'Администриране на фермата',
	'farmer-administration-extension' => 'Управление на разширенията',
	'farmer-administration-extension-text' => '[[$1|Управление]] на инсталираните допълнения.',
	'farmer-admimistration-listupdate-text' => '[[$1|Обновяване]] на списъка с уикитата в {{SITENAME}}',
	'farmer-administration-delete' => 'Изтриване на уики',
	'farmer-administration-delete-text' => '[[$1|Изтриване]] на уики от фермата',
	'farmer-administer-thiswiki' => 'Администриране на това уики',
	'farmer-notavailable-text' => 'Тази възможност е достъпна само на основното уики',
	'farmer-wikicreated' => 'Уикито беше създадено',
	'farmer-wikicreated-text' => 'Уикито беше създадено.  Достъпно е на адрес $1',
	'farmer-default' => 'По подразбиране никой не притежава права на това уики освен вас. Потребителските права могат да бъадт променени чрез $1',
	'farmer-wikiexists' => 'Уикито съществува',
	'farmer-wikiexists-text' => "Уикито, което се опитвате да създадете, '''$1''', вече съществува. Необходимо е да се избере друго име.",
	'farmer-confirmsetting' => 'Потвърждаване на уики-настройките',
	'farmer-confirmsetting-name' => 'Име',
	'farmer-confirmsetting-title' => 'Заглавие',
	'farmer-confirmsetting-description' => 'Описание',
	'farmer-confirmsetting-reason' => 'Причина',
	'farmer-description' => 'Описание',
	'farmer-confirmsetting-text' => "Вашето уики '''$1''' ще бъде достъпно на адрес $3.
Проектното именно пространство е '''$2'''.
Препратките към това именно пространство ще са от вида '''<nowiki>[[$2:Page name]]</nowiki>'''.
Ако това е желанието ви, натиснете бутона '''потвърждаване''' по-долу.",
	'farmer-button-confirm' => 'Потвърждаване',
	'farmer-button-submit' => 'Изпращане',
	'farmer-createwiki-form-title' => 'Създаване на уики',
	'farmer-createwiki-form-text1' => 'Формулярът по-долу служи за създаване на ново уики.',
	'farmer-createwiki-form-help' => 'Помощ',
	'farmer-createwiki-form-text2' => "; Име на уикито: Може да съдържа само букви и числа.  Името на уикито ще бъде използвано като част от адреса на уикито.  Напр. ако името е '''title''', уикито ще бъде достъпно на адрес <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Заглавие на уикито: Заглавие на уикито.  Използва се в заглавието на всяка страница на уикито.  Също така е проектно именно пространство и представка за междууики.',
	'farmer-createwiki-form-text4' => '; Описание: Описание на уикито.  Текстово описание на уикито.  Показва се в списъка с уикита.',
	'farmer-createwiki-user' => 'Потребителско име',
	'farmer-createwiki-name' => 'Име на уикито',
	'farmer-createwiki-title' => 'Заглавие на уикито',
	'farmer-createwiki-description' => 'Описание',
	'farmer-createwiki-reason' => 'Причина',
	'farmer-notaccessible' => 'Недостъпно',
	'farmer-notaccessible-test' => 'Тази възможност е достъпна само на основното уики от фермата',
	'farmer-permissiondenied' => 'Достъпът е отказан',
	'farmer-permissiondenied-text' => 'Нямате права да изтривате уики от фермата',
	'farmer-permissiondenied-text1' => 'Нямате права да отворите тази страница',
	'farmer-deleting' => 'Уикито "$1" беше изтрито',
	'farmer-delete-title' => 'Изтриване на уики',
	'farmer-delete-text' => 'Изберете уикито, което желаете да изтриете, от списъка по-долу',
	'farmer-delete-form' => 'Избор на уики',
	'farmer-delete-form-submit' => 'Изтриване',
	'farmer-listofwikis' => 'Списък на уикитата',
	'farmer-mainpage' => 'Начална страница',
	'farmer-basic-title' => 'Основни параметри',
	'farmer-basic-title1' => 'Заглавие',
	'farmer-basic-title1-text' => 'Уикито няма заглавие. Необходимо е да се въведе заглавие',
	'farmer-basic-description' => 'Описание',
	'farmer-basic-description-text' => 'По-долу е необходимо да се въведе описание на уикито',
	'farmer-basic-permission' => 'Права',
	'farmer-basic-permission-text' => 'Чрез формуляра по-долу е възможно да бъдат променени правата за достъп на потребителите на уикито.',
	'farmer-basic-permission-visitor' => 'Права за всеки посетител',
	'farmer-yes' => 'Да',
	'farmer-no' => 'Не',
	'farmer-defaultskin' => 'Облик по подразбиране',
	'farmer-defaultskin-button' => 'Настройване на облик по подразбиране',
	'farmer-extensions-extension-denied' => 'Нямате права да използвате тази възможност на софтуера.
Необходимо е да притежавате членство в групата farmeradmin',
	'farmer-extensions-invalid' => 'Невалидно разширение',
	'farmer-extensions-invalid-text' => 'Разширението не може да бъде добавено, тъуй като избраният файл за включване не може да бъде открит',
	'farmer-extensions-available' => 'Налични разширения',
	'farmer-extensions-noavailable' => 'Не са регистрирани разширения',
	'farmer-extensions-register' => 'Регистриране на разширение',
	'farmer-extensions-register-text1' => 'Формулярът по-долу служи за регистриране на нови разширения за фермата. След като бъде регистрирано ново разширение, всички уикита ще могат да го използват.',
	'farmer-extensions-register-text3' => "Ако името на файла съдържа '''\$root''', тази променлива ще бъде заменена с основната директория на МедияУики.",
	'farmer-extensions-register-text4' => 'Текущите пътища за включване са:',
	'farmer-extensions-register-name' => 'Име',
	'farmer-extensions-register-includefile' => 'Включване на файл',
	'farmer-error-exists' => 'Уикито не може да бъде създадено, тъй като вече съществува: $1',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Ehsanulhb
 * @author Wikitanvir
 * @author Zaheen
 */
$messages['bn'] = array(
	'farmercreatesitename' => 'সাইটের নাম',
	'farmercreatenextstep' => 'পরবর্তী ধাপ',
	'farmer-about' => 'পরিচিতি',
	'farmer-list-wiki' => 'উইকিসমূহের তালিকা',
	'farmer-createwiki' => 'নতুন একটি উইকি তৈরি করুন',
	'farmer-createwiki-text' => 'এখনই একটি নতুন উইকি [[$1|তৈরি করুন]]!',
	'farmer-administration-delete' => 'একটি উইকি অপসারণ করুন',
	'farmer-wikicreated-text' => 'আপনার উইকি তৈরি করা হয়েছে।
এটি পাওয়া যাবে $1-এ',
	'farmer-wikiexists' => 'উইকি ইতিমধ্যেই রয়েছে',
	'farmer-confirmsetting' => 'উইকি সেটিংস নিশ্চিত করুন',
	'farmer-confirmsetting-name' => 'নাম',
	'farmer-confirmsetting-title' => 'শিরোনাম',
	'farmer-confirmsetting-description' => 'বিবরণ',
	'farmer-confirmsetting-reason' => 'কারণ',
	'farmer-description' => 'বিবরণ',
	'farmer-button-confirm' => 'নিশ্চিত করুন',
	'farmer-button-submit' => 'জমা দাও',
	'farmer-createwiki-form-title' => 'নতুন একটি উইকি তৈরি করুন',
	'farmer-createwiki-form-text1' => 'নতুন উইকি তৈরি করতে নিচের ফর্মটি ব্যবহার করুন।',
	'farmer-createwiki-form-help' => 'সাহায্য',
	'farmer-createwiki-user' => 'ব্যবহারকারী নাম',
	'farmer-createwiki-name' => 'উইকির নাম',
	'farmer-createwiki-title' => 'উইকির শিরোনাম',
	'farmer-createwiki-description' => 'বিবরণ',
	'farmer-createwiki-reason' => 'কারণ',
	'farmer-updatedlist' => 'হালনাগাদকৃত তালিকা',
	'farmer-notaccessible' => 'প্রবেশযোগ্য নয়',
	'farmer-permissiondenied' => 'অনুমতি প্রত্যাখ্যাত হয়েছে।',
	'farmer-deleting' => '"$1" উইকিটি অপসারিত হয়েছে',
	'farmer-delete-confirm' => 'আমি নিশ্চিত করছি যে আমি এই উইকিটি অপসারণ করতে চাই',
	'farmer-delete-confirm-wiki' => "যে উইকিটি অপসারণ করা হবে: '''$1'''।",
	'farmer-delete-reason' => 'অপসারণের কারণ:',
	'farmer-delete-title' => 'উইকিটি অপসারণ করুন',
	'farmer-delete-form' => 'একটি উইকি নির্বাচন করুন',
	'farmer-delete-form-submit' => 'অপসারণ',
	'farmer-listofwikis' => 'উইকিসমূহের তালিকা',
	'farmer-mainpage' => 'প্রধান পাতা',
	'farmer-basic-title' => 'প্রাথমিক প্যারামিটারসমূহ',
	'farmer-basic-title1' => 'শিরোনাম',
	'farmer-basic-description' => 'বিবরণ',
	'farmer-basic-description-text' => 'আপনার উইকির বিবরণ নিচে ঠিক করুন',
	'farmer-basic-permission' => 'অধিকারসমূহ',
	'farmer-basic-permission-visitor' => 'সকল প্রদর্শনকারীর জন্য অনুমতি',
	'farmer-yes' => 'হ্যাঁ',
	'farmer-no' => 'না',
	'farmer-basic-permission-user' => 'প্রবেশকৃত ব্যবহারকারী জন্য অনুমতি',
	'farmer-setpermission' => 'অনুমতি নির্ধারণ',
	'farmer-defaultskin' => 'প্রাথমিক স্কিন',
	'farmer-defaultskin-button' => 'প্রাথমিক স্কিন নির্বাচন',
	'farmer-extensions' => 'সক্রিয় এক্সটেনশনসমূহ',
	'farmer-extensions-button' => 'সক্রিয় এক্সটেনশনসমূহ ঠিক করুন',
	'farmer-extensions-register-name' => 'নাম',
	'farmer-extensions-register-includefile' => 'যোগকৃত ফাইল',
	'farmer-error-exists' => 'উইকি তৈরি করা সম্ভব নয়। এটি ইতিমধ্যেই রয়েছে: $1',
	'farmer-log-name' => 'উইকি ফার্ম লগ',
	'farmer-log-create' => '"$2" উইকি তৈরি করা হয়েছে',
	'farmer-log-delete' => '"$2" উইকি অপসারণ করা হয়েছে',
	'right-farmeradmin' => 'উইকি ফার্ম ব্যবস্থাপনা',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'farmer' => 'Feurmer',
	'farmer-desc' => 'Merañ ur feurm MediaWiki',
	'farmercantcreatewikis' => "N'oc'h ket gouest da grouiñ wikioù dre ma n'ho peus ket an aotre \"createwikis\" ret evit kement-mañ",
	'farmercreatesitename' => "Anv al lec'hienn",
	'farmercreatenextstep' => 'Pazenn da-heul',
	'farmernewwikimainpage' => "== Degemer mat en ho wiki ==
Mard emaoc'h o lenn ar gerioù-mañ eo bet staliet mat ho wiki nevez.
Gallout a rit [[Special:Farmer|personelaat ho wiki]].",
	'farmer-about' => 'Diwar-benn',
	'farmer-about-text' => 'An astenn MediaWiki Farmer a aotre aozañ ur strobad a wikioù o tont eus ar meziant MediaWiki.',
	'farmer-list-wiki' => 'Roll ar wikioù',
	'farmer-list-wiki-text' => "[[$1|Rollañ]] an holl wikioù war al lec'hienn-mañ.",
	'farmer-createwiki' => 'Krouiñ ur wiki',
	'farmer-createwiki-text' => '[[$1|Krouiñ]] ur wiki nevez bremañ !',
	'farmer-administration' => 'Mererezh ar feurm',
	'farmer-administration-extension' => 'Merañ an astennoù',
	'farmer-administration-extension-text' => '[[$1|Merañ]] an astennoù staliet.',
	'farmer-admimistration-listupdate' => 'Hizivadenn roll ar Wikioù',
	'farmer-admimistration-listupdate-text' => "[[$1|Hizivat]] roll an holl wikioù war al lec'hienn-mañ.",
	'farmer-administration-delete' => 'dilemel ur wiki',
	'farmer-administration-delete-text' => '[[$1|Dilemel]] ur wiki eus ar feurm',
	'farmer-administer-thiswiki' => 'Merañ ar wiki-mañ',
	'farmer-administer-thiswiki-text' => "[[$1|Merañ]] ar c'hemmoù war ar wiki-se.",
	'farmer-notavailable' => "N'eo ket hegerz",
	'farmer-notavailable-text' => "An arc'hwel-mañ zo da gaout er wiki pennañ hepken",
	'farmer-wikicreated' => 'Krouet eo ar wiki',
	'farmer-wikicreated-text' => 'Krouet eo bet ho wiki.
Kavout a rit anezhañ amañ : $1',
	'farmer-default' => "Den ebet nemedoc'h n'en deus aotreoù war ar wiki-mañ.
Gallout a rit cheñch aotreoù an implijerien dre $1",
	'farmer-wikiexists' => "Bez' ez eus eus ar wiki",
	'farmer-wikiexists-text' => "Bez ez eus dija eus ar wiki, '''$1''', emaoc'h o klask krouiñ.
Mar plij kit war gil hag adklaskit gant un anv all.",
	'farmer-confirmsetting' => 'Kadarnaat arventennoù ar wiki',
	'farmer-confirmsetting-name' => 'Anv',
	'farmer-confirmsetting-title' => 'Titl',
	'farmer-confirmsetting-description' => 'Deskrivadur',
	'farmer-confirmsetting-reason' => 'Abeg',
	'farmer-description' => 'Deskrivadur',
	'farmer-confirmsetting-text' => "Ho wiki, '''$1''', a vo kavet war $3.
Esaouenn anv ar raktres a vo '''$2'''.
Al liammoù davet an esaouenn anv-mañ o do ar stumm '''<nowiki>[[$2:Anv ar bajenn]]</nowiki>'''.
Ma 'z eo ar pezh a fell deoc'h, klikit war ar bouton '''Kadarnaat''' amañ da heul.",
	'farmer-button-confirm' => 'Kadarnaat',
	'farmer-button-submit' => 'Kas',
	'farmer-createwiki-form-title' => 'Krouiñ ur wiki',
	'farmer-createwiki-form-text1' => 'Implijout ar furmskrid amañ dindan da grouiñ ur wiki nevez.',
	'farmer-createwiki-form-help' => 'Skoazell',
	'farmer-createwiki-form-text2' => "; Anv ar Wiki : Anv ar wiki.
N'en deus nemet lizherennoù ha niveroù.
Implijet e vo anv ar wiki evel ul lodenn eus an URL a-benn anavezout ho wiki.
Da skouer, ma lakait '''titl''', neuze e vo kavet ho wiki war <nowiki>http://</nowiki>'''titl'''.madomani.",
	'farmer-createwiki-form-text3' => '; Titl ar Wiki : Titl ar wiki.
Implijet e vo e titl pep pajenn ho wiki.
Esaouenn anv ar raktres e vo ivez hag ar rakverk etrewiki.',
	'farmer-createwiki-form-text4' => '; Deskrivadur : Deskrivadur ar wiki.
Un destenn deskrivañ ar wiki eo.
Diskouezet e vo e roll ar wikioù.',
	'farmer-createwiki-user' => 'Anv implijer',
	'farmer-createwiki-name' => 'Anv ar wiki',
	'farmer-createwiki-title' => 'Titl ar wiki',
	'farmer-createwiki-description' => 'Deskrivadur',
	'farmer-createwiki-reason' => 'Abeg',
	'farmer-updatedlist' => 'Roll hizivaet',
	'farmer-notaccessible' => "Ne c'haller ket mont dezhañ",
	'farmer-notaccessible-test' => 'Ne gaver ar programm-mañ nemet war wiki pennañ an hollad-mañ a raktresoù.',
	'farmer-permissiondenied' => "Aotre nac'het",
	'farmer-permissiondenied-text' => "N'oc'h ket aotreet da zilemel ur wiki eus ar feurm",
	'farmer-permissiondenied-text1' => "N'oc'h ket aotreet da vont d'ar bajenn-mañ",
	'farmer-deleting' => 'Ar wiki « $1 » zo bet dilamet',
	'farmer-delete-confirm' => "Kadarnaat a ran em eus c'hoant da zilemel ar wiki-mañ",
	'farmer-delete-confirm-wiki' => "Wiki da zilemel : '''$1'''.",
	'farmer-delete-reason' => 'Abeg an dilammadenn :',
	'farmer-delete-title' => 'Dilemel ur wiki',
	'farmer-delete-text' => "Mar plij diuzit er roll a-is ar wiki ho peus c'hoant dilemel.",
	'farmer-delete-form' => 'Diuzañ ur wiki',
	'farmer-delete-form-submit' => 'Dilemel',
	'farmer-listofwikis' => 'Roll ar Wikioù',
	'farmer-mainpage' => 'Pajenn degemer',
	'farmer-basic-title' => 'Arventennoù diazez',
	'farmer-basic-title1' => 'Titl',
	'farmer-basic-title1-text' => "N'eus titl ebet gant ho wiki. Lakait unan <b>bremañ</b>",
	'farmer-basic-description' => 'Deskrivadur',
	'farmer-basic-description-text' => 'Lakaat deskrivadur ho wiki amañ dindan',
	'farmer-basic-permission' => 'Aotreoù',
	'farmer-basic-permission-text' => "Dre implijout ar furmskrid amañ dindan e c'haller cheñch aotreoù implijerien ar wiki-mañ.",
	'farmer-basic-permission-visitor' => 'Aotreoù evit pep gweladenner',
	'farmer-basic-permission-visitor-text' => 'An aotreoù-mañ a vo arloet ouzh kement den a weladenn ar wiki-mañ',
	'farmer-yes' => 'Ya',
	'farmer-no' => 'Ket',
	'farmer-basic-permission-user' => 'Aotreoù evit an implijerien kevreet',
	'farmer-basic-permission-user-text' => 'An aotreoù-mañ a vo arloet ouzh kement den hag a zo enrollet war ar wiki-mañ',
	'farmer-setpermission' => 'Lakaat an aotreoù',
	'farmer-defaultskin' => 'Neuz dre ziouer',
	'farmer-defaultskin-button' => 'Lakaat an neuz dre ziouer',
	'farmer-extensions' => 'Astennoù oberiant',
	'farmer-extensions-button' => 'Kefluniañ an astennoù oberiat',
	'farmer-extensions-extension-denied' => "N'hoc'h eus ket an aotre da implijout an arc'hweladur-mañ. Ret eo deoc'h bezañ ezel eus merourien ar velestradurezh lieswiki",
	'farmer-extensions-invalid' => 'Astenn direizh',
	'farmer-extensions-invalid-text' => "Ne c'hellomp ket ouzhpennañ an astenn-mañ dre ma ne gaver ket ar restr diuzet evit an enklozadur.",
	'farmer-extensions-available' => 'Astennoù da gaout',
	'farmer-extensions-noavailable' => "N'eus astenn marilhet ebet",
	'farmer-extensions-register' => 'Marilhañ un astenn',
	'farmer-extensions-register-text1' => "Implijit ar furmskrid da-heul evit enrollañ un astenn nevez gant an arc'hweladur-se.
Ur wech enrollet an astenn e c'hello an holl wikioù implijout anezhi.",
	'farmer-extensions-register-text2' => 'Evit an arventenn "Enklozañ ur restr", roit anv ar restr PHP hoc\'h eus c\'hoant e LocalSettings.php.',
	'farmer-extensions-register-text3' => "Ma 'z eus '''\$root''' e anv ar restr, e vo erlec'hiet ar varienn e kavlec'h gwrizienn MediaWiki.",
	'farmer-extensions-register-text4' => 'Hentad a-vremañ ar restroù include a zo :',
	'farmer-extensions-register-name' => 'Anv',
	'farmer-extensions-register-includefile' => 'Enklozañ ur restr',
	'farmer-error-exists' => "Ne c'haller ket krouiñ ar wiki. Bez' ez eus anezhañ dija : $1",
	'farmer-error-noextwrite' => "Ne c'haller ket skrivañ ar restr astenn :",
	'farmer-log-name' => 'Deizlevr ar feurm wiki',
	'farmer-log-header' => "Hemañ zo un deizlevr eus ar c'hemmoù degaset d'ar feurm wiki.",
	'farmer-log-create' => 'en deus krouet ar wiki « $2 »',
	'farmer-log-delete' => 'en deus dilamet ar wiki « $2 »',
	'right-farmeradmin' => 'Merañ ar feurm wikioù',
	'right-createwiki' => 'Krouiñ wikioù er feurm wiki',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Upravljanje MediaWiki farmom',
	'farmercantcreatewikis' => 'Vi niste u mogućnosti da napravite wiki jer nemate privilegije za pravljenje (createwikis)',
	'farmercreatesitename' => 'Ime sajta',
	'farmercreatenextstep' => 'slijedeći korak',
	'farmernewwikimainpage' => '== Dobrodošli na Vaš wiki ==
Ako čitate ovo, Vaš novi wiki je pravilno instaliran.
Možete [[Special:Farmer|prilagoditi Vaš wiki]].',
	'farmer-about' => 'O',
	'farmer-about-text' => 'MediaWiki Farmer Vam omogućava upravljanje farmom MediaWiki wikija.',
	'farmer-list-wiki' => 'Spisak wikija',
	'farmer-list-wiki-text' => '[[$1|Spisak]] svih wikija na {{SITENAME}}',
	'farmer-createwiki' => 'Napravi wiki',
	'farmer-createwiki-text' => '[[$1|Napravite]] novi wiki sad!',
	'farmer-administration' => 'Upravljanje farmom',
	'farmer-administration-extension' => 'Upravljanje proširenjima',
	'farmer-administration-extension-text' => '[[$1|Upravljaj]] instaliranim proširenjima.',
	'farmer-admimistration-listupdate' => 'Ažuriranje spiska farme',
	'farmer-admimistration-listupdate-text' => '[[$1|Ažuriranje]] spiska wikija na {{SITENAME}}',
	'farmer-administration-delete' => 'Obriši wiki',
	'farmer-administration-delete-text' => '[[$1|Obriši]] wiki iz farme',
	'farmer-administer-thiswiki' => 'Administriraj ovaj wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administriraj]] promjenama na ovoj wiki',
	'farmer-notavailable' => 'Nije dostupno',
	'farmer-notavailable-text' => 'Ova mogućnost je dostupna samo na glavnoj wiki',
	'farmer-wikicreated' => 'Wiki je napravljen',
	'farmer-wikicreated-text' => 'Vaš wiki je napravljen.
Dostupan je na $1',
	'farmer-wikiexists' => 'Wiki postoji',
	'farmer-confirmsetting' => 'Potvrdi wiki postavke',
	'farmer-confirmsetting-name' => 'Ime',
	'farmer-confirmsetting-title' => 'Naslov',
	'farmer-confirmsetting-description' => 'Opis',
	'farmer-confirmsetting-reason' => 'Razlog',
	'farmer-description' => 'Opis',
	'farmer-confirmsetting-text' => "Vaš wiki, '''$1''' će biti dostupan putem $3.
Projektni imenski prostor će biti '''$2'''.
Linkovi u ovaj imenski prostor će biti u formi ''<nowiki>[[$2:Page name]]</nowiki>'''.
Ako je ovo to što želite, pritisnite dugme '''potvrdi''' ispod.",
	'farmer-button-confirm' => 'Potvrdi',
	'farmer-button-submit' => 'Pošalji',
	'farmer-createwiki-form-title' => 'Napravi wiki',
	'farmer-createwiki-form-text1' => 'Koristite obrazac ispod za pravljenje novog wikija.',
	'farmer-createwiki-form-help' => 'Pomoć',
	'farmer-createwiki-form-text3' => '; Wiki naslov: Naslov wikija.
Bit će korišten u naslovu svake stranice na vašoj wiki.
Bit će također imenski prostor projekta i prefiks za međuwiki.',
	'farmer-createwiki-user' => 'Korisničko ime',
	'farmer-createwiki-name' => 'Ime wikija',
	'farmer-createwiki-title' => 'Wiki naslov',
	'farmer-createwiki-description' => 'Opis',
	'farmer-createwiki-reason' => 'Razlog',
	'farmer-updatedlist' => 'Ažurirani spisak',
	'farmer-notaccessible' => 'Ne može se pristupiti',
	'farmer-permissiondenied' => 'Pristup onemogućen',
	'farmer-permissiondenied-text' => 'Nemate dopuštenje da obrišete wiki iz farme',
	'farmer-delete-confirm' => 'Potvrđujem da želim obrisati ovu wiki',
	'farmer-delete-confirm-wiki' => "Wikiji za brisanje: '''$1'''.",
	'farmer-delete-reason' => 'Razlog za brisanje:',
	'farmer-delete-title' => 'Obriši wiki',
	'farmer-delete-form' => 'Odaberi wiki',
	'farmer-delete-form-submit' => 'Obriši',
	'farmer-listofwikis' => 'Spisak wikija',
	'farmer-mainpage' => 'Početna stranica',
	'farmer-basic-title' => 'Osnovni parametri',
	'farmer-basic-title1' => 'Naslov',
	'farmer-basic-description' => 'Opis',
	'farmer-basic-permission' => 'Dopuštenja',
	'farmer-basic-permission-visitor' => 'Odobrenja za svakog posjetioca',
	'farmer-yes' => 'Da',
	'farmer-no' => 'Ne',
	'farmer-setpermission' => 'Postavi dopuštenja',
	'farmer-defaultskin' => 'Pretpostavljena koža',
	'farmer-defaultskin-button' => 'Postavi pretpostavljenu kožu',
	'farmer-extensions' => 'Aktivna proširenja',
	'farmer-extensions-button' => 'Postavi aktivna proširenja',
	'farmer-extensions-extension-denied' => 'Nemate dopuštenje da koristite ove mogućnosti.
Morate biti član grupe farmeradmin',
	'farmer-extensions-invalid' => 'Nevaljano proširenje',
	'farmer-extensions-available' => 'Dostupna proširenja',
	'farmer-extensions-register-name' => 'Ime',
	'farmer-extensions-register-includefile' => 'Uključi datoteku',
	'farmer-error-exists' => 'Ne mogu napraviti wiki. Već postoji: $1',
	'farmer-log-name' => 'Zapisnik wiki farme',
	'farmer-log-create' => 'napravljen wiki "$2"',
	'farmer-log-delete' => 'obrisan wiki "$2"',
	'right-farmeradmin' => 'Upravljanje wiki farmom',
	'right-createwiki' => 'Pravljenje wikija u wiki farmi',
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'farmer' => 'Granger',
	'farmer-desc' => 'Gestioneu una granja de MediaWikis',
	'farmercreatesitename' => 'Nom del lloc',
	'farmercreatenextstep' => 'Següent pas',
	'farmer-about' => 'Quant a',
	'farmer-createwiki' => 'Crea un wiki',
	'farmer-confirmsetting-name' => 'Nom',
	'farmer-confirmsetting-title' => 'Títol',
	'farmer-confirmsetting-description' => 'Descripció',
	'farmer-confirmsetting-reason' => 'Motiu',
	'farmer-description' => 'Descripció',
	'farmer-button-submit' => 'Tramet',
	'farmer-createwiki-form-title' => 'Crea un wiki',
	'farmer-createwiki-description' => 'Descripció',
	'farmer-createwiki-reason' => 'Motiu',
	'farmer-delete-form-submit' => 'Elimina',
	'farmer-basic-title1' => 'Títol',
	'farmer-basic-description' => 'Descripció',
	'farmer-yes' => 'Sí',
	'farmer-no' => 'No',
	'farmer-extensions-register-name' => 'Nom',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'farmer-confirmsetting-reason' => 'Бахьан',
	'farmer-createwiki-form-help' => 'Нисвохаам',
	'farmer-createwiki-reason' => 'Бахьан',
	'farmer-yes' => 'Хlаъ',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'farmer-mainpage' => 'Fanhaluman',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'farmer-confirmsetting-reason' => 'هۆکار',
	'farmer-button-confirm' => 'پشتدار بکەرەوە',
	'farmer-button-submit' => 'ناردن',
	'farmer-createwiki-reason' => 'هۆکار',
	'farmer-delete-form-submit' => 'سڕینەوە',
);

/** Czech (Česky)
 * @author Jkjk
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'farmer' => 'Farmář',
	'farmer-desc' => 'Správa farmy MediaWiki',
	'farmercantcreatewikis' => 'Nemůžete vytvářet wiki, protože nemáte oprávnění createwikis',
	'farmercreatesitename' => 'Název lokality',
	'farmercreatenextstep' => 'Další krok',
	'farmer-about' => 'O stránce',
	'farmer-about-text' => 'MediaWiki Farmář vám umožní spravovat farmu MediaWiki wiki.',
	'farmer-list-wiki' => 'Seznam wiki',
	'farmer-list-wiki-text' => '[[$1|Seznam]] všech wiki na {{GRAMMAR:local|{{SITENAME}}}}',
	'farmer-createwiki' => 'Vytvořit wiki',
	'farmer-createwiki-text' => '[[$1|Vytvořte]] novou wiki teď!',
	'farmer-administration' => 'Správa farmy',
	'farmer-administration-extension' => 'Spravovat rozšíření',
	'farmer-admimistration-listupdate' => 'Aktualizace seznamu farem',
	'farmer-admimistration-listupdate-text' => '[[$1|Aktualizovat]] seznam wiki na {{SITENAME}}',
	'farmer-administration-delete' => 'Smazat wiki',
	'farmer-administration-delete-text' => '[[$1|Smazat]] wiki z farmy',
	'farmer-administer-thiswiki' => 'Spravovat tuto wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Spravovat]] změny v této wiki',
	'farmer-notavailable' => 'Nedostupné',
	'farmer-notavailable-text' => 'Tato fuknce je dostupná jen na hlavní wiki',
	'farmer-wikicreated' => 'Wiki vytvořena',
	'farmer-wikicreated-text' => 'Vaše wiki byla vytvořena.
Je dostupná na $1',
	'farmer-default' => 'Ve výchozím nastavení, nikdo kromě vás nemá privilegia na wiki.
Můžete změnit privilegia uživatelů na $1',
	'farmer-wikiexists' => 'Wiki existuje',
	'farmer-confirmsetting' => 'Potvrdit nastavení wiki',
	'farmer-confirmsetting-name' => 'Název',
	'farmer-confirmsetting-title' => 'Název',
	'farmer-confirmsetting-description' => 'Popis',
	'farmer-confirmsetting-reason' => 'Důvod',
	'farmer-description' => 'Popis',
	'farmer-button-confirm' => 'Potvrdit',
	'farmer-button-submit' => 'Odeslat',
	'farmer-createwiki-form-title' => 'Vytvořit wiki',
	'farmer-createwiki-form-text1' => 'Na vytvoření nové wiki použijte následující formulář.',
	'farmer-createwiki-form-help' => 'Nápověda',
	'farmer-createwiki-form-text4' => '; Popis: Popis wiki
Toto je textový popis wiki.
Tento text bude zobrazen v seznamu wiki.',
	'farmer-createwiki-user' => 'Uživatelské jméno',
	'farmer-createwiki-name' => 'Název wiki',
	'farmer-createwiki-title' => 'Titulek wiki',
	'farmer-createwiki-description' => 'Popis',
	'farmer-createwiki-reason' => 'Důvod',
	'farmer-updatedlist' => 'Aktualizovaný seznam',
	'farmer-notaccessible' => 'Nepřístupná',
	'farmer-notaccessible-test' => 'Tato funkce je dostupná jen na rodičovské wiki na farmě',
	'farmer-permissiondenied' => 'Nedostatečné oprávnění',
	'farmer-permissiondenied-text' => 'Nemáte oprávnění smazat wiki z farmy',
	'farmer-permissiondenied-text1' => 'Nemáte oprávnění k přístupu na tuto stránku',
	'farmer-delete-form-submit' => 'Smazat',
	'farmer-basic-title1' => 'Název',
	'farmer-basic-description' => 'Popis',
	'farmer-yes' => 'Ano',
	'farmer-no' => 'Ne',
	'farmer-extensions-register-name' => 'Název',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'farmer-createwiki-form-help' => 'помощь',
	'farmer-delete-form-submit' => 'поничьжє́ниѥ',
	'farmer-no' => 'нѣ́тъ',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'farmer-description' => 'Beskrivelse',
	'farmer-button-confirm' => 'Bekræft',
	'farmer-createwiki-form-help' => 'Hjælp',
	'farmer-createwiki-user' => 'Brugernavn',
	'farmer-createwiki-description' => 'Beskrivelse',
	'farmer-delete-form-submit' => 'Slet',
	'farmer-mainpage' => 'Forside',
	'farmer-basic-title1' => 'Titel',
	'farmer-basic-description' => 'Beskrivelse',
	'farmer-yes' => 'Ja',
	'farmer-no' => 'Nej',
	'farmer-extensions-register-name' => 'Navn',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author ChrisiPK
 * @author Imre
 * @author Jan Luca
 * @author Kghbln
 * @author Leithian
 * @author Melancholie
 * @author MichaelFrey
 * @author Pill
 * @author Purodha
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Verwalte eine MediaWiki-Farm',
	'farmercantcreatewikis' => 'Du kannst kein Wiki anlegen, da dir das Recht („createwikis“) dazu fehlt.',
	'farmercreatesitename' => 'Name der Website',
	'farmercreatenextstep' => 'Nächster Schritt',
	'farmernewwikimainpage' => '== Willkommen in deinem Wiki ==

Wenn du diesen Text liest, hast du dein neues Wiki korrekt installiert.
Du kannst es nach deinen Wünschen [[Special:Farmer|anpassen]].',
	'farmer-about' => 'Über',
	'farmer-about-text' => 'MediaWiki-Farmer ermöglicht es dir mehrere MediaWikis zu verwalten.',
	'farmer-list-wiki' => 'Liste Wikis auf',
	'farmer-list-wiki-text' => '[[$1|Liste]] aller Wikis auf {{SITENAME}}',
	'farmer-createwiki' => 'Ein Wiki anlegen',
	'farmer-createwiki-text' => '[[$1|Erstelle]] jetzt ein neues Wiki.',
	'farmer-administration' => 'Farm-Administration',
	'farmer-administration-extension' => 'Erweiterungen verwalten',
	'farmer-administration-extension-text' => '[[$1|Verwalte]] installierte Erweiterungen.',
	'farmer-admimistration-listupdate' => 'Farmenliste aktualisieren',
	'farmer-admimistration-listupdate-text' => '[[$1|Aktualisiere]] die Liste der Wikis auf {{SITENAME}}',
	'farmer-administration-delete' => 'Ein Wiki löschen',
	'farmer-administration-delete-text' => '[[$1|Lösche]] ein Wiki von der Farm',
	'farmer-administer-thiswiki' => 'Administriere dieses Wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Verwalte]] dieses Wiki',
	'farmer-notavailable' => 'Nicht verfügbar.',
	'farmer-notavailable-text' => 'Dieses Feature ist nur im Hauptwiki verfügbar',
	'farmer-wikicreated' => 'Wiki erstellt',
	'farmer-wikicreated-text' => 'Dein Wiki wurde erstellt.
Es befindet sich hier: $1',
	'farmer-default' => 'Am Anfang hat keiner außer dir irgendwelche Rechte in diesem Wiki.
Mittels $1 kannst du die Benutzerrechte verwalten',
	'farmer-wikiexists' => 'Wiki existiert',
	'farmer-wikiexists-text' => "Das Wiki – '''$1''' –, das du versuchst anzulegen, existiert bereits.
Bitte kehre zurück und versuche es mit einem anderen Namen",
	'farmer-confirmsetting' => 'Wiki-Einstellungen bestätigen',
	'farmer-confirmsetting-name' => 'Name',
	'farmer-confirmsetting-title' => 'Titel',
	'farmer-confirmsetting-description' => 'Beschreibung',
	'farmer-confirmsetting-reason' => 'Grund',
	'farmer-description' => 'Beschreibung',
	'farmer-confirmsetting-text' => "Dein Wiki – '''$1''' – wird über $3 erreichbar sein.
Der Projektnamensraum wird '''$2''' heißen.
Links zu diesem Namensraum werden die Form '''<nowiki>[[$2:Seitenname]]</nowiki>''' haben.
Wenn alles korrekt ist, so bestätige dies mit einem Klick auf '''Bestätigen'''.",
	'farmer-button-confirm' => 'Bestätigen',
	'farmer-button-submit' => 'Speichern',
	'farmer-createwiki-form-title' => 'Ein Wiki erstellen',
	'farmer-createwiki-form-text1' => 'Benutze das folgende Formular, um ein neues Wiki anzulegen.',
	'farmer-createwiki-form-help' => 'Hilfe',
	'farmer-createwiki-form-text2' => "; Wikiname: Der Name des Wikis.
Es darf nur die Buchstaben A–Z und Zahlen enthalten.
Der Wikiname wird als Teil der URL zum Wiki verwendet.
Wenn du zum Beispiel '''Name''' angibst, wird die URL zum Wiki <nowiki>http://</nowiki>'''name'''.example.com/ heißen.",
	'farmer-createwiki-form-text3' => '; Wikiname: Name des Wiki.
Er wird auf jeder Seite des Wikis verwendet.
Er wird ebenfalls der Titel des Projektnamensraumes und der Interwiki-Präfix sein.',
	'farmer-createwiki-form-text4' => '; Beschreibung: Beschreibung des Wikis.
Dieser Text beschreibt das Wiki und wird auf der Liste der Wikis angezeigt.',
	'farmer-createwiki-user' => 'Benutzername',
	'farmer-createwiki-name' => 'Wikiname',
	'farmer-createwiki-title' => 'Wikititel',
	'farmer-createwiki-description' => 'Beschreibung',
	'farmer-createwiki-reason' => 'Grund',
	'farmer-updatedlist' => 'Liste aktualisieren',
	'farmer-notaccessible' => 'Nicht verfügbar',
	'farmer-notaccessible-test' => 'Dieses Feature ist nur im Elternwiki der Farm verfügbar',
	'farmer-permissiondenied' => 'Zugriff verweigert',
	'farmer-permissiondenied-text' => 'Es ist dir nicht gestattet, ein Wiki von der Farm zu löschen',
	'farmer-permissiondenied-text1' => 'Du hast nicht die erforderliche Berechtigung, um diese Seite aufrufen zu können.',
	'farmer-deleting' => 'Das Wiki $1 wurde gelöscht',
	'farmer-delete-confirm' => 'Ich bestätige, dass ich dieses Wiki löschen möchte',
	'farmer-delete-confirm-wiki' => "Zu löschendes Wiki: '''$1'''.",
	'farmer-delete-reason' => 'Grund der Löschung:',
	'farmer-delete-title' => 'Wiki löschen',
	'farmer-delete-text' => 'Bitte wähle das Wiki das du löschen willst aus der Liste aus',
	'farmer-delete-form' => 'Wähle ein Wiki',
	'farmer-delete-form-submit' => 'Löschen',
	'farmer-listofwikis' => 'Liste der Wikis',
	'farmer-mainpage' => 'Hauptseite',
	'farmer-basic-title' => 'Grundsätzliche Parameter',
	'farmer-basic-title1' => 'Titel',
	'farmer-basic-title1-text' => 'Dein Wiki hat keinen Titel. Bitte trage ihn <b>jetzt</b> ein',
	'farmer-basic-description' => 'Beschreibung',
	'farmer-basic-description-text' => 'Füge unten die Beschreibung deines Wikis ein',
	'farmer-basic-permission' => 'Rechte',
	'farmer-basic-permission-text' => 'Mit dem folgenden Formular ist es möglich, die Benutzerrechte des Wikis zu verändern.',
	'farmer-basic-permission-visitor' => 'Gastrechte',
	'farmer-basic-permission-visitor-text' => 'Die folgenden Rechte gelten für Gäste im Wiki',
	'farmer-yes' => 'Ja',
	'farmer-no' => 'Nein',
	'farmer-basic-permission-user' => 'Rechte angemeldeter Benutzer',
	'farmer-basic-permission-user-text' => 'Die folgenden Rechte gelten für angemeldete Benutzer',
	'farmer-setpermission' => 'Rechte setzen',
	'farmer-defaultskin' => 'Standardskin',
	'farmer-defaultskin-button' => 'Standardskin setzen',
	'farmer-extensions' => 'Aktive Erweiterungen',
	'farmer-extensions-button' => 'Aktive Erweiterungen setzen',
	'farmer-extensions-extension-denied' => 'Es ist dir nicht gestattet, dieses Feature zu benutzen, denn dafür müsstest du der Admingruppe dieser Farm angehören',
	'farmer-extensions-invalid' => 'Ungültige Erweiterung',
	'farmer-extensions-invalid-text' => 'Die Erweiterung konnte nicht hinzugefügt werden, weil die zur Einbindung ausgewählte Datei nicht gefunden werden konnte',
	'farmer-extensions-available' => 'Verfügbare Erweiterungen',
	'farmer-extensions-noavailable' => 'Es wurden keine Erweiterungen registriert',
	'farmer-extensions-register' => 'Erweiterung anmelden',
	'farmer-extensions-register-text1' => 'Verwende die untenstehende Maske, um eine neue Erweiterung für die Farm zu registrieren.
Sobald eine Erweiterung registriert ist, können alle Wikis sie verwenden.',
	'farmer-extensions-register-text2' => "Gib den Namen der PHP-Datei im ''Include file''-Parameter so an, wie du ihn in LocalSettings.php angeben würdest.",
	'farmer-extensions-register-text3' => "Wenn der Dateiname '''\$root''' enthält, wird diese Variable durch das MediaWiki-Wurzelverzeichnis ersetzt.",
	'farmer-extensions-register-text4' => 'Die aktuell beinhalteten Pfade sind:',
	'farmer-extensions-register-name' => 'Name',
	'farmer-extensions-register-includefile' => 'Datei einbinden',
	'farmer-error-exists' => 'Das Wiki kann nicht angelegt werden, weil es bereits existiert: $1',
	'farmer-error-noextwrite' => 'Schreiben der Erweiterungsdatei nicht möglich:',
	'farmer-log-name' => 'Wiki-Farm Logbuch',
	'farmer-log-header' => 'Dieses Logbuch zeigt die Änderung an der Wiki-Farm.',
	'farmer-log-create' => 'erstellte das Wiki „$2“',
	'farmer-log-delete' => 'löschte das Wiki „$2“',
	'right-farmeradmin' => 'Wiki-Farm verwalten',
	'right-createwiki' => 'Wikis in der Wiki-Farm erstellen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author ChrisiPK
 * @author Imre
 * @author Kghbln
 * @author MichaelFrey
 */
$messages['de-formal'] = array(
	'farmercantcreatewikis' => 'Sie können kein Wiki anlegen, da Ihnen das Recht („createwikis“) dazu fehlt.',
	'farmernewwikimainpage' => '== Willkommen in Ihrem Wiki ==

Wenn Sie diesen Text lesen, haben Sie Ihr neues Wiki korrekt installiert.
Sie können es nach Ihren Wünschen [[Special:Farmer|anpassen]].',
	'farmer-about-text' => 'MediaWiki-Farmer ermöglicht es Ihnen mehrere MediaWikis zu verwalten.',
	'farmer-wikicreated-text' => 'Ihr Wiki wurde erstellt.
Es befindet sich hier: $1',
	'farmer-default' => 'Am Anfang hat keiner außer ihnen irgendwelche Rechte in diesem Wiki.
Mittels $1 können Sie die Benutzerrechte verwalten',
	'farmer-wikiexists-text' => "Das Wiki – '''$1''' –, das Sie versuchen anzulegen, existiert bereits.
Bitte kehren Sie zurück und versuchen Sie es mit einem anderen Namen",
	'farmer-confirmsetting-text' => "Ihr Wiki – '''$1''' – wird über $3 erreichbar sein.
Der Projektnamensraum wird '''$2''' heißen.
Links zu diesem Namensraum werden die Form '''<nowiki>[[$2:Seitenname]]</nowiki>''' haben.
Wenn alles korrekt ist, so bestätigen Sie dies mit einem Klick auf '''Bestätigen'''.",
	'farmer-createwiki-form-text2' => "; Wikiname: Der Name des Wikis.
Es darf nur die Buchstaben A–Z und Zahlen enthalten.
Der Wikiname wird als Teil der URL zum Wiki verwendet.
Wenn Sie zum Beispiel '''Name''' angeben, wird die URL zum Wiki <nowiki>http://</nowiki>'''name'''.example.com/ heißen.",
	'farmer-permissiondenied-text' => 'Es ist Ihnen nicht gestattet, ein Wiki von der Farm zu löschen',
	'farmer-permissiondenied-text1' => 'Sie haben nicht die erforderliche Berechtigung, um diese Seite aufrufen zu können.',
	'farmer-delete-text' => 'Bitte wählen Sie das Wiki, das Sie löschen möchten, aus der Liste aus',
	'farmer-basic-title1-text' => 'Ihr Wiki hat keinen Titel. Bitte tragen Sie ihn <b>jetzt</b> ein',
	'farmer-basic-description-text' => 'Fügen Sie unten die Beschreibung Ihres Wikis ein',
	'farmer-extensions-extension-denied' => 'Es ist Ihnen nicht gestattet, dieses Feature zu benutzen, denn dafür müssten Sie der Admingruppe dieser Farm angehören',
	'farmer-extensions-register-text1' => 'Verwenden Sie die untenstehende Maske, um eine neue Erweiterung für die Farm zu registrieren.
Sobald eine Erweiterung registriert ist, können alle Wikis sie verwenden.',
	'farmer-extensions-register-text2' => "Geben Sie den Namen der PHP-Datei im ''Include file''-Parameter so an, wie Sie ihn in LocalSettings.php angeben würden.",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'farmer' => 'Farmaŕ',
	'farmer-desc' => 'Farmu MediaWiki zastojaś',
	'farmercantcreatewikis' => 'Njamóžoš wikije napóraś, dokulaž njamaš pšawo ("createwikis")',
	'farmercreatesitename' => 'Mě sedła',
	'farmercreatenextstep' => 'Pśiducy kšac',
	'farmernewwikimainpage' => '== Witaj do swójogo wikija ==
Jolic to cytaš, twój wiki jo korektnje instalěrowany.
Móžoš [[Special:Farmer|swój wiki pśiměriś]].',
	'farmer-about' => 'Wó',
	'farmer-about-text' => 'MediaWiki Farmaŕ śi zmóžnja farmu wikijow MediaWiki zastojaś.',
	'farmer-list-wiki' => 'Lisćina wikijow',
	'farmer-list-wiki-text' => 'Wše wikije na {{GRAMMAR:lokatiw|{{SITENAME}}}} [[$1|nalicyś]]',
	'farmer-createwiki' => 'Wiki napóraś',
	'farmer-createwiki-text' => '[[$1|Napóraj]] něnto nowy wiki!',
	'farmer-administration' => 'Zastojanje farmy',
	'farmer-administration-extension' => 'Rozšyrjenja zastojaś',
	'farmer-administration-extension-text' => 'Instalěrowane rozšyrjenja [[$1|zastojaś]].',
	'farmer-admimistration-listupdate' => 'Aktualizacija lisćiny farmow',
	'farmer-admimistration-listupdate-text' => 'Lisćinu wikijow na {{GRAMMAR:lokatiw|{{SITENAME}}}} [[$1|aktualizěrowaś]]',
	'farmer-administration-delete' => 'Wiki lašowaś',
	'farmer-administration-delete-text' => 'Wiki z farmy [[$1|lašowaś]]',
	'farmer-administer-thiswiki' => 'Toś ten wiki administrěrowaś',
	'farmer-administer-thiswiki-text' => 'Změny toś togo wikija [[$1|administrěrowaś]]',
	'farmer-notavailable' => 'Njejo k dispoziciji',
	'farmer-notavailable-text' => 'Tuta funkcija stoj jano w głownem wikiju k dispoziciji',
	'farmer-wikicreated' => 'Wiki napórany',
	'farmer-wikicreated-text' => 'Twój wiki jo se napórał.
Jo pśistupny na $1',
	'farmer-default' => 'Po standarźe nichten njama pšawa za toś ten wiki, mimo tebje.
Móžoš wužywarske pšawa pśez $1 změniś.',
	'farmer-wikiexists' => 'Wiki eksistěrujo',
	'farmer-wikiexists-text' => "Wiki, kótaryž wopytujoš napóraś, '''$1''', južo eksistěrujo.
Pšosym źi slědk a wopytaj druge mě.",
	'farmer-confirmsetting' => 'Nastajenja wikija wobkšuśiś',
	'farmer-confirmsetting-name' => 'Mě',
	'farmer-confirmsetting-title' => 'Titel',
	'farmer-confirmsetting-description' => 'Wopisanje',
	'farmer-confirmsetting-reason' => 'Pśicyna',
	'farmer-description' => 'Wopisanje',
	'farmer-confirmsetting-text' => "Twój wiki, '''$1''', buźo pśistupny pśez $3.
Projektowy mjenjowy rum buźo '''$2'''.
Wótkaze k toś tomu mjenjowemu rumoju změju formu '''<nowiki>[[$2:Page name]]</nowiki>'''.
Jolic to coš, tłoc na slědujucy tłocašk '''wobkšuśiś'''.",
	'farmer-button-confirm' => 'Wobkšuśiś',
	'farmer-button-submit' => 'Wótpósłaś',
	'farmer-createwiki-form-title' => 'Wiki napóraś',
	'farmer-createwiki-form-text1' => 'Wužyj slědujucy formular, aby napórał nowy wiki.',
	'farmer-createwiki-form-help' => 'Pomoc',
	'farmer-createwiki-form-text2' => "; Wiki name: Mě wikija.
Wopśimujo jano pismiki a cyfry.
Mě wikija buźo se ako źěl URL wužywaś, aby identificěrował twój wiki.
Na pśikład, jolic zapódawaš '''titel''', ga twój wiki buźo pśistupny pśez <nowiki>http://</nowiki>'''titel'''.mójadomena.",
	'farmer-createwiki-form-text3' => '; Wiki title: Titel wikija.
Buźo se w titelu kuždego boka w twójom wikiju wužywaś.
Buźo teke mjenjowy rum projekta a prefiks interwiki.',
	'farmer-createwiki-form-text4' => '; Wopisanje: Wopisanje wikija.
To jo tekstowe wopisanje wikija.
To buźo se w lisćinje wikijow zwobraznjowaś.',
	'farmer-createwiki-user' => 'Wužywarske mě',
	'farmer-createwiki-name' => 'Mě wikija',
	'farmer-createwiki-title' => 'Titel wikija',
	'farmer-createwiki-description' => 'Wopisanje',
	'farmer-createwiki-reason' => 'Pśicyna',
	'farmer-updatedlist' => 'Lisćina zaktualizěrowana',
	'farmer-notaccessible' => 'Njepśistupny',
	'farmer-notaccessible-test' => 'Toś ta funkcija stoj jano w głownem wikiju farmy k dispoziciji',
	'farmer-permissiondenied' => 'Pšawo wótpokazane',
	'farmer-permissiondenied-text' => 'Njamaš pšawo wiki z farmy lašowaś',
	'farmer-permissiondenied-text1' => 'Njamaš pšawo, aby měł pśistup na toś ten bok',
	'farmer-deleting' => 'Wiki "$1" jo se wulašował',
	'farmer-delete-confirm' => 'Jo, cu toś ten wiki wulašowaś',
	'farmer-delete-confirm-wiki' => "Wiki, kótaryž ma se lašowaś: '''$1'''",
	'farmer-delete-reason' => 'Pśicyna za wulašowanje:',
	'farmer-delete-title' => 'Wiki lašowaś',
	'farmer-delete-text' => 'Pšosym wubjeŕ wiki, kótaryž coš lašowaś, ze slědujuceje lisćiny',
	'farmer-delete-form' => 'Wubjeŕ wiki',
	'farmer-delete-form-submit' => 'Lašowaś',
	'farmer-listofwikis' => 'Lisćina wikijow',
	'farmer-mainpage' => 'Głowny bok',
	'farmer-basic-title' => 'Zakładne parametry',
	'farmer-basic-title1' => 'Titel',
	'farmer-basic-title1-text' => 'Twój wiki njama titel. Daj jaden <b>něnto</b>',
	'farmer-basic-description' => 'Wopisanje',
	'farmer-basic-description-text' => 'Zapódaj dołojce wopisanje swójogo wikija',
	'farmer-basic-permission' => 'Pšawa',
	'farmer-basic-permission-text' => 'Z pomocu slědujucego formulara jo móžno pšawa za wužywarjow toś togo wikija změniś.',
	'farmer-basic-permission-visitor' => 'Pšawa za kuždego woglědowarja',
	'farmer-basic-permission-visitor-text' => 'Slědujuce pšawa płaśe za kuždu wósobu, kótaraž woglědujo k toś tomu wikijoju',
	'farmer-yes' => 'Jo',
	'farmer-no' => 'Ně',
	'farmer-basic-permission-user' => 'Pšawa za pśizjawjonych wužywarjow',
	'farmer-basic-permission-user-text' => 'Slědujuce pšawa płaśe za kuždu wósobu, kótaraž jo w toś tom wikiju pśizjawjona',
	'farmer-setpermission' => 'Pšawa stajiś',
	'farmer-defaultskin' => 'Standardna drastwa',
	'farmer-defaultskin-button' => 'Standardnu drastwu nastajiś',
	'farmer-extensions' => 'Aktiwne rozšyrjenja',
	'farmer-extensions-button' => 'Aktiwne rozšyrjenja stajiś',
	'farmer-extensions-extension-denied' => 'Njamaš pšawo toś tu funkciju wužywaś.
Musyš cłonk kupki farmarskich administratorow byś.',
	'farmer-extensions-invalid' => 'Njepłaśiwe rozšyrjenje',
	'farmer-extensions-invalid-text' => 'Njejo było móžno rozšyrjenje pśidaś, dokulaž za zapśěegnjenje wubrana dataja njejo dała se namakaś.',
	'farmer-extensions-available' => 'K dispoziciji stojece rozšyrjenja',
	'farmer-extensions-noavailable' => 'Žedne rozšyrjenja zregistrěrowane',
	'farmer-extensions-register' => 'Rozšyrjenje registrěrowaś',
	'farmer-extensions-register-text1' => 'Wužyj slědujucy formular, aby registrěrował nowe rozšyrjenje pśi farmje.
Gaž rozšyrjenje je zregistrěrowane, wše wikije mógu jo wužywaś.',
	'farmer-extensions-register-text2' => "Za parameter ''Include file'' zapódaj mě PHP-dataje, ako by było w dataji LocalSettings.php.",
	'farmer-extensions-register-text3' => "Jolic datajowe mě wopśimujo '''\$root''', ta wariabla buźo se pśez kórjenjowy zapis MediaWiki wuměnjaś.",
	'farmer-extensions-register-text4' => 'Aktualne sćažki include su:',
	'farmer-extensions-register-name' => 'Mě',
	'farmer-extensions-register-includefile' => 'Dataju zapśěgnuś',
	'farmer-error-exists' => 'Wiki njedajo se napóraś, eksistěrujo južo: $1',
	'farmer-error-noextwrite' => 'Njemóžno dataju rozšyrjenja pisaś:',
	'farmer-log-name' => 'Protokol wikijowego farma',
	'farmer-log-header' => 'To jo protokol změnow, kótarež su se na wikijowem farmje cynili.',
	'farmer-log-create' => 'jo załožył wiki "$2"',
	'farmer-log-delete' => 'jo wulašował wiki "$2"',
	'right-farmeradmin' => 'Wikijowu farmu zastojaś',
	'right-createwiki' => 'Wikije we wikijowej farmje napóraś',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'farmer-list-wiki' => 'Wikiwo ƒe xexlẽme',
	'farmer-createwiki-form-help' => 'Kpekpeɖeŋu',
	'farmer-delete-form-submit' => 'Tutui',
	'farmer-listofwikis' => 'Wikiwo ƒe xexlẽme',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['el'] = array(
	'farmer' => 'Αγρότης',
	'farmer-desc' => 'Διαχείριση μίας φάρμας MediaWiki',
	'farmercreatesitename' => 'Ονομασία ιστοτόπου',
	'farmercreatenextstep' => 'Επόμενο βήμα',
	'farmer-about' => 'Σχετικά',
	'farmer-list-wiki' => 'Κατάλογος των βίκι',
	'farmer-createwiki' => 'Δημιουργήστε ένα Wiki',
	'farmer-createwiki-text' => '[[$1|Δημιουργήστε]] ένα νέο wiki τώρα!',
	'farmer-administration' => 'Γενική διαχείριση',
	'farmer-administration-extension' => 'Διαχείριση επεκτάσεων',
	'farmer-admimistration-listupdate' => 'Ενημέρωση της λίστας των βίκι',
	'farmer-administration-delete' => 'Διαγράψτε ένα Wiki',
	'farmer-administration-delete-text' => '[[$1|Διαγραφή]] ενός βίκι από τη φάρμα',
	'farmer-administer-thiswiki' => 'Διαχείριση του Wiki',
	'farmer-notavailable' => 'Μη διαθέσιμος',
	'farmer-wikicreated' => 'Το Wiki δημιουργήθηκε',
	'farmer-wikiexists' => 'Το Wiki υπάρχει',
	'farmer-confirmsetting' => 'Επιβεβαίωση βικι-ρυθμίσεων',
	'farmer-confirmsetting-name' => 'Όνομα',
	'farmer-confirmsetting-title' => 'Τίτλος',
	'farmer-confirmsetting-description' => 'Περιγραφή',
	'farmer-confirmsetting-reason' => 'Αιτιολογία',
	'farmer-description' => 'Περιγραφή',
	'farmer-button-confirm' => 'Επιβεβαίωση',
	'farmer-button-submit' => 'Υποβολή',
	'farmer-createwiki-form-title' => 'Δημιουργήστε ένα Wiki',
	'farmer-createwiki-form-help' => 'Βοήθεια',
	'farmer-createwiki-user' => 'Όνομα χρήστη',
	'farmer-createwiki-name' => 'Ονομασία ιστοτόπου',
	'farmer-createwiki-title' => 'Τίτλος του βίκι',
	'farmer-createwiki-description' => 'Περιγραφή',
	'farmer-createwiki-reason' => 'Αιτιολογία',
	'farmer-updatedlist' => 'Ενημερωμένη λίστα',
	'farmer-notaccessible' => 'Μη διαθέσιμος',
	'farmer-permissiondenied' => 'Δεν έγινε αποδεκτή η παροχή άδειας',
	'farmer-delete-confirm-wiki' => "Wiki προς διαγραφή: '''$1'''.",
	'farmer-delete-reason' => 'Αιτία για την διαγραφή:',
	'farmer-delete-title' => 'Διαγραφή του Wiki',
	'farmer-delete-form' => 'Επιλέξτε ένα wiki',
	'farmer-delete-form-submit' => 'Διαγραφή',
	'farmer-listofwikis' => 'Λίστα των Wiki',
	'farmer-mainpage' => 'Κύρια Σελίδα',
	'farmer-basic-title' => 'Βασικοί Παράμετροι',
	'farmer-basic-title1' => 'Τίτλος',
	'farmer-basic-description' => 'Περιγραφή',
	'farmer-basic-permission' => 'Άδειες',
	'farmer-yes' => 'Ναι',
	'farmer-no' => 'Όχι',
	'farmer-setpermission' => 'Ρύθμιση αδειών',
	'farmer-defaultskin' => 'Προκαθορισμένη εμφάνιση',
	'farmer-defaultskin-button' => 'Ρύθμιση προεπιλεγμένης πρόσοψης',
	'farmer-extensions' => 'Ενεργές επεκτάσεις',
	'farmer-extensions-button' => 'Πύθμιση ενεργών επεκτάσεων',
	'farmer-extensions-invalid' => 'Μη έγκυρη επέκταση',
	'farmer-extensions-available' => 'Διαθέσιμες επεκτάσεις',
	'farmer-extensions-register' => 'Εγγραφή μίας επέκτασης',
	'farmer-extensions-register-name' => 'Όνομα',
	'farmer-extensions-register-includefile' => 'Συμπερίληψη αρχείου',
	'farmer-error-exists' => 'Αδύνατη η δημιουργία του Wiki. Υπάρχει ήδη: $1',
	'farmer-log-name' => 'Αρχείο της βικι-φάρμας',
);

/** British English (British English)
 * @author Reedy
 */
$messages['en-gb'] = array(
	'farmernewwikimainpage' => '== Welcome to your wiki ==
If you are reading this, your new wiki has been installed correctly.
You can [[Special:Farmer|customise your wiki]].',
);

/** Esperanto (Esperanto)
 * @author Amikeco
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'farmer-desc' => 'Administri MediaWiki-vikiaron',
	'farmercreatesitename' => 'Nomo de retejo',
	'farmercreatenextstep' => 'Posta ŝtupo',
	'farmernewwikimainpage' => '== Bonvenon al via vikio ==
Se vi legas tion ĉi, via vikio estas sukcese instalita.
Vi povas [[Special:Farmer|agordi vian vikion]].',
	'farmer-about' => 'Pri',
	'farmer-list-wiki' => 'Listo de Vikioj',
	'farmer-list-wiki-text' => '[[$1|Listigi]] ĉiujn vikiojn en {{SITENAME}}',
	'farmer-createwiki' => 'Krei Vikion',
	'farmer-createwiki-text' => '[[$1|Kreu]] novan vikion nun!',
	'farmer-administration-extension' => 'Kontroli Etendilojn',
	'farmer-administration-extension-text' => '[[$1|Administru]] instalitajn etendilojn.',
	'farmer-admimistration-listupdate-text' => '[[$1|Ĝisdatigi]] liston de vikioj en {{SITENAME}}',
	'farmer-administration-delete' => 'Forigi Vikion',
	'farmer-administration-delete-text' => '[[$1|Forigi]] vikion de the vikiaro.',
	'farmer-administer-thiswiki' => 'Administru ĉi vikion',
	'farmer-administer-thiswiki-text' => '[[$1|Administri]] ŝanĝojn al ĉi tiu vikion',
	'farmer-notavailable' => 'Ne atingebla',
	'farmer-notavailable-text' => 'Ĉi tiu ilo estas nur havebla en la ĉefa vikio.',
	'farmer-wikicreated' => 'Vikio estas kreita',
	'farmer-wikicreated-text' => 'Via vikio estis kreita. Ĝi estas havebla ĉe $1',
	'farmer-wikiexists' => 'Vikio ekzistas',
	'farmer-confirmsetting' => 'Konfirmu Vikiajn Parametrojn',
	'farmer-confirmsetting-name' => 'Nomo',
	'farmer-confirmsetting-title' => 'Titolo',
	'farmer-confirmsetting-description' => 'Priskribo',
	'farmer-confirmsetting-reason' => 'Kialo',
	'farmer-description' => 'Priskribo',
	'farmer-button-confirm' => 'Konfirmi',
	'farmer-button-submit' => 'Ek',
	'farmer-createwiki-form-title' => 'Krei Vikion',
	'farmer-createwiki-form-text1' => 'Uzu la jenan kamparon por krei novan vikion.',
	'farmer-createwiki-form-help' => 'Helpo',
	'farmer-createwiki-form-text4' => '; Priskribo: Priskribo de vikio.
Ĉi tiu estas teksta priskribo pri la vikio.
Ĉi tiu estos montrita en la vikia listo.',
	'farmer-createwiki-user' => 'Salutnomo',
	'farmer-createwiki-name' => 'Vikia nomo',
	'farmer-createwiki-title' => 'Vikia titolo',
	'farmer-createwiki-description' => 'Priskribo',
	'farmer-updatedlist' => 'Ĝisdatigi liston',
	'farmer-notaccessible' => 'Ne atingebla',
	'farmer-permissiondenied' => 'Permeso neita',
	'farmer-permissiondenied-text1' => 'Vi ne havas rajtojn por vidi tiun ĉi paĝon',
	'farmer-deleting' => 'Viki "$1" estas forigita',
	'farmer-delete-confirm-wiki' => "Vikio por forigi: '''$1'''.",
	'farmer-delete-title' => 'Forigi vikion',
	'farmer-delete-form' => 'Elektu vikion',
	'farmer-delete-form-submit' => 'Forigi',
	'farmer-listofwikis' => 'Listo de Vikioj',
	'farmer-mainpage' => 'Ĉefpaĝo',
	'farmer-basic-title' => 'Bazaj Parametroj',
	'farmer-basic-title1' => 'Titolo',
	'farmer-basic-title1-text' => 'Via vikio ne havas titolon. Faru titolon NUN',
	'farmer-basic-description' => 'Priskribo',
	'farmer-basic-description-text' => 'Faru la priskribon de via vikio suben',
	'farmer-basic-permission' => 'Permesoj',
	'farmer-basic-permission-visitor' => 'Permesoj por Ĉiu Vizitanto',
	'farmer-yes' => 'Jes',
	'farmer-no' => 'Ne',
	'farmer-basic-permission-user' => 'Rajtoj por Ensalutitaj Uzantoj',
	'farmer-setpermission' => 'Fari permesojn',
	'farmer-defaultskin' => 'Defaŭlta Veston',
	'farmer-defaultskin-button' => 'Konfiguru Defaŭltan Veston',
	'farmer-extensions' => 'Aktivaj Etendiloj',
	'farmer-extensions-button' => 'Faru Aktivajn Etendilojn',
	'farmer-extensions-extension-denied' => "Vi ne havas permeson por uzi ĉi tiu ilon.
Vi nepre estu membro de la ''farmeradmin'' grupo.",
	'farmer-extensions-invalid' => 'Nevalida Etendilo',
	'farmer-extensions-available' => 'Atingeblaj Etendiloj',
	'farmer-extensions-noavailable' => 'Neniuj etendiloj estas registritaj',
	'farmer-extensions-register' => 'Registri Etendilon',
	'farmer-extensions-register-name' => 'Nomo',
	'farmer-extensions-register-includefile' => 'Inkluzivi dosieron',
	'farmer-error-exists' => 'Ne povas krei vikion. Ĝi jam ekzistas: $1',
	'farmer-log-name' => 'Protokolo pri vikia farmo',
	'farmer-log-create' => 'kreis la vikion "$2"',
	'farmer-log-delete' => 'forigis la vikion "$2"',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Fitoschido
 * @author Imre
 * @author Jatrobat
 * @author Pertile
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'farmer' => 'Agricultor',
	'farmer-desc' => 'Gestionar una granja MediaWiki',
	'farmercantcreatewikis' => 'Eres incapaz de crear wikis porque no tienes privilegios createwikis',
	'farmercreatesitename' => 'Nombre del sitio',
	'farmercreatenextstep' => 'Próximo paso',
	'farmernewwikimainpage' => '== Bienvenido a tu wiki ==
Si estás leyendo esto, tu nuevo wiki ha sido instalado correctamente.
Puedes [[Special:Farmer|personalizar tu wiki]].',
	'farmer-about' => 'Acerca de',
	'farmer-about-text' => 'MediaWiki Farmer permite administrar una granja de wikis MediaWiki',
	'farmer-list-wiki' => 'Lista de wikis',
	'farmer-list-wiki-text' => '[[$1|listar]] todos los wikis en {{SITENAME}}',
	'farmer-createwiki' => 'Crear un wiki',
	'farmer-createwiki-text' => '[[$1|Crear]] un nuevo wiki ahora!',
	'farmer-administration' => 'Administración de la granja',
	'farmer-administration-extension' => 'Administrar extensiones',
	'farmer-administration-extension-text' => '[[$1|Administrar]] extensiones instaladas.',
	'farmer-admimistration-listupdate' => 'Actualización del listado de la granja',
	'farmer-admimistration-listupdate-text' => '[[$1|Actualizar]] lista de wikis en {{SITENAME}}',
	'farmer-administration-delete' => 'Borrar un wiki',
	'farmer-administration-delete-text' => '[[$1|Eliminar]] una wiki de la granja',
	'farmer-administer-thiswiki' => 'Administrar este wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administrar]] cambios a este wiki',
	'farmer-notavailable' => 'No disponible',
	'farmer-notavailable-text' => 'Esta característica está solamente disponible en el wiki principal',
	'farmer-wikicreated' => 'Wiki creado',
	'farmer-wikicreated-text' => 'Su wiki ha sido creado.
Es accesible en $1',
	'farmer-default' => 'Por defecto, nadie tiene permisos en este wiki excepto tú.
Puedes cambiar los privilegios de usuario a través de $1',
	'farmer-wikiexists' => 'El wiki existe',
	'farmer-wikiexists-text' => "La wiki que está intentando crear, '''$1''', ya existe.
Por favor vuelva atrás e intente con otro nombre.",
	'farmer-confirmsetting' => 'Confirmar configuraciones de wiki',
	'farmer-confirmsetting-name' => 'Nombre',
	'farmer-confirmsetting-title' => 'Título',
	'farmer-confirmsetting-description' => 'Descripción',
	'farmer-confirmsetting-reason' => 'Motivo',
	'farmer-description' => 'Descripción',
	'farmer-confirmsetting-text' => "Su wiki, '''$1''', será accesible a través de $3.
El espacio de nombres del proyecto será '''$2'''.
Los enlaces al espacio de nombre deberán tener la forma '''<nowiki>[[$2:Nombre de la página]]</nowiki>'''.
Si esto es lo que desea hacer, oprima el botón '''confirmar''' que se encuentra debajo.",
	'farmer-button-confirm' => 'Confirmar',
	'farmer-button-submit' => 'Enviar',
	'farmer-createwiki-form-title' => 'Crear un wiki',
	'farmer-createwiki-form-text1' => 'Usar el formulario de abajo para crear un nuevo wiki.',
	'farmer-createwiki-form-help' => 'Ayuda',
	'farmer-createwiki-form-text2' => "; Nombre Wiki: el nombre de la Wiki.
Contiene únicamente letras y números.
El nombre wiki será utilizado como parte de la URL para identificar a su wiki.
Por ejemplo, si ingresa '''título''', entonces su wiki será accedida a través de <nowiki>http://</nowiki>'''título'''.midominio.",
	'farmer-createwiki-form-text3' => '; Título Wiki: el título de la wiki.
Será utilizado en el título de cada página de su wiki.
También será el espacio de nombres del proyecto y el prefijo interwiki.',
	'farmer-createwiki-form-text4' => '; Descripción: Descripción del wiki.
Este es un texto descriptivo acerca del wiki.
Esto se mostrará en la lista wiki.',
	'farmer-createwiki-user' => 'Nombre de usuario',
	'farmer-createwiki-name' => 'Nombre de wiki',
	'farmer-createwiki-title' => 'Título de wiki',
	'farmer-createwiki-description' => 'Descripción',
	'farmer-createwiki-reason' => 'Motivo',
	'farmer-updatedlist' => 'Lista actualizada',
	'farmer-notaccessible' => 'No accesible',
	'farmer-notaccessible-test' => 'Esta característica está únicamente disponible en la wiki padre en la granja',
	'farmer-permissiondenied' => 'Permiso denegado',
	'farmer-permissiondenied-text' => 'No cuenta con los permisos para eliminar una wiki de la granja',
	'farmer-permissiondenied-text1' => 'No tiene permiso para acceder a esta página',
	'farmer-deleting' => 'El wiki "$1" ha sido borrado',
	'farmer-delete-confirm' => 'Confirmo que deseo borrar este wiki',
	'farmer-delete-confirm-wiki' => "Wiki a borrar: '''$1'''.",
	'farmer-delete-reason' => 'Razones para el borrado:',
	'farmer-delete-title' => 'Borrar wiki',
	'farmer-delete-text' => 'Por favor seleccione el wiki de la lista de abajo que desea borrar',
	'farmer-delete-form' => 'Seleccione un wiki',
	'farmer-delete-form-submit' => 'Borrar',
	'farmer-listofwikis' => 'Lista de wikis',
	'farmer-mainpage' => 'Página Principal',
	'farmer-basic-title' => 'Parámetros básicos',
	'farmer-basic-title1' => 'Título',
	'farmer-basic-title1-text' => 'Tu wiki no tiene título. Ponle uno <b>ahora</b>',
	'farmer-basic-description' => 'Descripción',
	'farmer-basic-description-text' => 'Establece la descripción de tu wiki abajo',
	'farmer-basic-permission' => 'Permisos',
	'farmer-basic-permission-text' => 'Usando el formulario de abajo, es posible alterar los permisos para los usuarios de este wiki.',
	'farmer-basic-permission-visitor' => 'Permisos para todo visitante',
	'farmer-basic-permission-visitor-text' => 'Los siguientes permisos serán aplicados a toda persona que visite este wiki',
	'farmer-yes' => 'Sí',
	'farmer-no' => 'No',
	'farmer-basic-permission-user' => 'Permisos para usuarios que han iniciado sesión',
	'farmer-basic-permission-user-text' => 'Los siguientes permisos le serán aplicados a cada persona que acceda registrada a este wiki',
	'farmer-setpermission' => 'Configurar permisos',
	'farmer-defaultskin' => 'Piel por defecto',
	'farmer-defaultskin-button' => 'Configurar piel por defecto',
	'farmer-extensions' => 'Extensiones activas',
	'farmer-extensions-button' => 'Configurar extensiones activas',
	'farmer-extensions-extension-denied' => 'No tiene los permisos para utilizar esta característica.
Debe ser un miembro del grupo farmeradmin',
	'farmer-extensions-invalid' => 'Extensión inválida',
	'farmer-extensions-invalid-text' => 'No se ha podido añadir la extensión porque el archivo seleccionado para incluir no se ha podido encontrar',
	'farmer-extensions-available' => 'Extensiones disponibles',
	'farmer-extensions-noavailable' => 'Ninguna extensión está registrada',
	'farmer-extensions-register' => 'Registrar extensión',
	'farmer-extensions-register-text1' => 'Utilice el formulario que se halla a continuación para registrar una nueva extensión en la granja.
Una vez que la extensión ha sido registrada, todas las wikis podrán utilizarla.',
	'farmer-extensions-register-text2' => "Para el parámetro ''Incluir archivo'', ingrese el nombre del archivo PHP tal como lo haría en LocalSettings.php.",
	'farmer-extensions-register-text3' => "Si el nombre del archivo contiene '''\$root''', dicha variable será reemplazada con el directorio raíz del MedaWiki.",
	'farmer-extensions-register-text4' => 'Las actuales rutas incluídas son:',
	'farmer-extensions-register-name' => 'Nombre',
	'farmer-extensions-register-includefile' => 'Incluir archivo',
	'farmer-error-exists' => 'No se puede crear wiki. Ya existe: $1',
	'farmer-error-noextwrite' => 'No se ha podido escribir el archivo de extensión:',
	'farmer-log-name' => 'Registro de la granja de wikis',
	'farmer-log-header' => 'Este es un registro de los cambios hechos a la granja de wikis.',
	'farmer-log-create' => 'Creado el wiki "$2"',
	'farmer-log-delete' => 'Borrado el wiki "$2"',
	'right-farmeradmin' => 'Gestionar la granja de wikis',
	'right-createwiki' => 'Crear wikis en la granja wiki',
);

/** Estonian (Eesti)
 * @author Pikne
 * @author Silvar
 */
$messages['et'] = array(
	'farmer-createwiki-user' => 'Kasutajanimi',
	'farmer-createwiki-name' => 'Viki nimi',
	'farmer-createwiki-title' => 'Wiki pealkiri',
	'farmer-createwiki-description' => 'Kirjeldus',
	'farmer-createwiki-reason' => 'Põhjus',
	'farmer-updatedlist' => 'Uuendatud nimekiri',
	'farmer-notaccessible' => 'Pole kättesaadav',
	'farmer-notaccessible-test' => 'See võimalus on olemas ainult serveri farmi, kesksel-vikil',
	'farmer-permissiondenied' => 'Õigused puuduvad',
	'farmer-permissiondenied-text' => 'Sul pole õigusi, et kustutada wikit farmist',
	'farmer-permissiondenied-text1' => 'Sul pole õigusi, sellele lehele ligipääsuks',
	'farmer-deleting' => 'Viki "$1" on kustutatud',
	'farmer-delete-confirm' => 'Ma kinnitan, et ma tahan seda vikit kustutada',
	'farmer-delete-confirm-wiki' => "Kustuta Viki: '''$1'''.",
	'farmer-delete-reason' => 'Põhjus selle kustutamiseks:',
	'farmer-delete-title' => 'Kustuta Viki',
	'farmer-delete-text' => 'Palun vali alt nimekirjast viki mida sa soovid kustutada',
	'farmer-delete-form' => 'Vali viki',
	'farmer-delete-form-submit' => 'Kustuta',
	'farmer-listofwikis' => 'Vikide nimekiri',
	'farmer-mainpage' => 'Esileht',
	'farmer-basic-title' => 'Põhi parametrid',
	'farmer-basic-title1' => 'Pealkiri',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 * @author Theklan
 */
$messages['eu'] = array(
	'farmer' => 'Nekazaria',
	'farmer-desc' => 'MediaWiki basetxe bat kudeatu',
	'farmercantcreatewikis' => 'Ezin dituzu wikiak sortu ez daukazulako createwikis eskumenik',
	'farmercreateurl' => 'URL',
	'farmercreatesitename' => 'Lekuaren izena',
	'farmercreatenextstep' => 'Hurrengo pausoa',
	'farmernewwikimainpage' => '== Ongietorria zure wikira ==
Hau irakurtzen bazaude zure wiki berria ondo instalatu da.
[[Special:Farmer|Zure wikia aldatu]] ahal duzu.',
	'farmer-list-wiki' => 'Wikien zerrenda',
	'farmer-createwiki' => 'Wiki bat sortu',
	'farmer-createwiki-text' => '[[$1|Sortu]] wiki berria orain!',
	'farmer-administration-delete' => 'Wikia ezabatu',
	'farmer-administer-thiswiki' => 'Wiki hau kudeatu',
	'farmer-wikicreated' => 'Wiki sortua',
	'farmer-wikiexists' => 'Wikia existitzen da',
	'farmer-confirmsetting-name' => 'Izena',
	'farmer-confirmsetting-title' => 'Izenburua',
	'farmer-confirmsetting-description' => 'Deskribapena',
	'farmer-confirmsetting-reason' => 'Arrazoia',
	'farmer-description' => 'Deskribapena',
	'farmer-button-confirm' => 'Baieztatu',
	'farmer-button-submit' => 'Bidali',
	'farmer-createwiki-form-title' => 'Wiki bat sortu',
	'farmer-createwiki-form-help' => 'Laguntza',
	'farmer-createwiki-user' => 'Erabiltzaile izena',
	'farmer-createwiki-name' => 'Wikiaren izena',
	'farmer-createwiki-title' => 'Wikiaren izenburua',
	'farmer-createwiki-description' => 'Deskribapena',
	'farmer-createwiki-reason' => 'Arrazoia',
	'farmer-delete-title' => 'Wikia ezabatu',
	'farmer-delete-form' => 'Wikia aukeratu',
	'farmer-delete-form-submit' => 'Ezabatu',
	'farmer-listofwikis' => 'Wikien zerrenda',
	'farmer-mainpage' => 'Azala',
	'farmer-basic-title1' => 'Izenburua',
	'farmer-basic-description' => 'Deskribapena',
	'farmer-basic-permission' => 'Baimenak',
	'farmer-yes' => 'Bai',
	'farmer-no' => 'Ez',
	'farmer-setpermission' => 'Baimenak esleitu',
	'farmer-extensions-register-name' => 'Izena',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'farmer-about' => 'درباره',
	'farmer-list-wiki' => 'فهرست ویکی‌های',
	'farmer-notavailable' => 'در دسترس نیست',
	'farmer-wikicreated' => 'ویکی ایجاد شد',
	'farmer-confirmsetting-name' => 'نام',
	'farmer-confirmsetting-title' => 'عنوان',
	'farmer-confirmsetting-description' => 'توضیحات',
	'farmer-confirmsetting-reason' => 'دلیل:',
	'farmer-description' => 'توضیحات',
	'farmer-createwiki-form-title' => 'ایجاد یک ویکی',
	'farmer-createwiki-form-help' => 'راهنما',
	'farmer-createwiki-user' => 'نام کاربری',
	'farmer-createwiki-name' => 'نام ویکی',
	'farmer-createwiki-title' => 'عنوان ویکی',
	'farmer-createwiki-description' => 'توضیحات',
	'farmer-delete-title' => 'حذف ویکی',
	'farmer-delete-form-submit' => 'حذف',
	'farmer-listofwikis' => 'فهرست ویکی‌های',
	'farmer-mainpage' => 'صفحهٔ اصلی',
	'farmer-basic-title1' => 'عنوان',
	'farmer-yes' => 'بله',
	'farmer-no' => 'خیر',
	'farmer-extensions-register-name' => 'نام',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'farmer' => 'Wikipelto',
	'farmer-desc' => 'Hallitse MediaWiki-farmia',
	'farmercantcreatewikis' => 'Et voi luoda uusia wikejä, koska sivulla ei ole <tt>createwikis</tt>-oikeutta.',
	'farmercreatesitename' => 'Sivuston nimi',
	'farmercreatenextstep' => 'Seuraava askel',
	'farmernewwikimainpage' => '== Tervetuloa wikiisi ==
Jos luet tätä, uusi wikisi on asennettu onnistuneesti. Voit halutessasi [[Special:Farmer|muuttaa wikin asetuksia]].',
	'farmer-about' => 'Tietoja',
	'farmer-about-text' => 'MediaWikin Farmer-laajennus mahdollistaa oman wikipellon hallitsemisen.',
	'farmer-list-wiki' => 'Wikilista',
	'farmer-list-wiki-text' => '[[$1|Lista]] kaikista {{SITENAME}}-sivuston wikeistä',
	'farmer-createwiki' => 'Uusi wiki',
	'farmer-createwiki-text' => '[[$1|Luo]] uusi wiki',
	'farmer-administration' => 'Pellon ylläpito',
	'farmer-administration-extension' => 'Laajennokset',
	'farmer-administration-extension-text' => '[[$1|Valitse]] käytettävät laajennokset.',
	'farmer-admimistration-listupdate' => 'Farmiluettelon päivitys',
	'farmer-admimistration-listupdate-text' => '[[$1|Päivitä]] sivuston {{SITENAME}} wikiluettelo',
	'farmer-administration-delete' => 'Poista wiki',
	'farmer-administration-delete-text' => '[[$1|Poista]] wiki farmista',
	'farmer-administer-thiswiki' => 'Hallinnoi tätä wikiä',
	'farmer-administer-thiswiki-text' => '[[$1|Hallinnoi]] muutoksia tähän wikiin',
	'farmer-notavailable' => 'Ei saatavilla',
	'farmer-notavailable-text' => 'Tämä ominaisuus on käytettävissä vain pääasiallisessa wikissä',
	'farmer-wikicreated' => 'Wiki luotu',
	'farmer-wikicreated-text' => 'Wikisi on luotu.
Se on käytettävissä osoitteessa $1',
	'farmer-default' => 'Oletusarvoisesti kenelläkään sinun lisäksesi ei ole oikeuksia tähän wikiin.
Voit muuttaa käyttäjäoikeuksia sivulla $1',
	'farmer-wikiexists' => 'Wiki on olemassa',
	'farmer-wikiexists-text' => 'Wiki, jota yrität luoda (”$1”) on jo olemassa.
Palaa takaisin ja kokeile toista nimeä.',
	'farmer-confirmsetting' => 'Vahvista wikin asetukset',
	'farmer-confirmsetting-name' => 'Nimi',
	'farmer-confirmsetting-title' => 'Otsikko',
	'farmer-confirmsetting-description' => 'Kuvaus',
	'farmer-confirmsetting-reason' => 'Syy',
	'farmer-description' => 'Kuvaus',
	'farmer-confirmsetting-text' => "Wikisi ”$1” tulee olemaan käytettävissä osoitteessa $3.
Projektin nimiavaruus tulee olemaan '''$2'''.
Linkit tähän nimiavaruuteen tulevat olemaan muotoa '''<nowiki>[[$2:Page name]]</nowiki>'''.
Jos tämä on oikein, valitse '''vahvista'''-nappi alla.",
	'farmer-button-confirm' => 'Vahvista',
	'farmer-button-submit' => 'Lähetä',
	'farmer-createwiki-form-title' => 'Luo wiki',
	'farmer-createwiki-form-text1' => 'Luo uusi wiki alla olevalla lomakkeella.',
	'farmer-createwiki-form-help' => 'Ohje',
	'farmer-createwiki-form-text2' => "; Wikin nimi
Sisältää vain kirjaimia ja numeroita.
Wikin nimeä käytetään osana URL-osoitetta tunnistamaan wikisi.
Esimerkiksi, jos syötät ”'''nimi'''”, wikisi tulee olemaan käytössä osoitteessa <nowiki>http://</nowiki>'''nimi'''.domain.",
	'farmer-createwiki-form-text3' => '; Wikin otsikko.
Tulee olemaan käytössä wikisi jokaisen sivun otsikossa.
On myös projektin nimiavaruudena ja interwiki-etuliitteenä.',
	'farmer-createwiki-form-text4' => '; Kuvaus: Wikin kuvaus.
Tämä on tekstikuvaus wikistä.
Se näytetään wikilistassa.',
	'farmer-createwiki-user' => 'Käyttäjätunnus',
	'farmer-createwiki-name' => 'Wikin nimi',
	'farmer-createwiki-title' => 'Wikin otsikko',
	'farmer-createwiki-description' => 'Kuvaus',
	'farmer-createwiki-reason' => 'Syy',
	'farmer-updatedlist' => 'Päivitetty lista',
	'farmer-notaccessible' => 'Ei pääsyä',
	'farmer-notaccessible-test' => 'Tämä ominaisuus on käytössä vain farmin isä-wikissä',
	'farmer-permissiondenied' => 'Käyttö estetty',
	'farmer-permissiondenied-text' => 'Sinulla ei ole oikeuksia poistaa wikiä farmista',
	'farmer-permissiondenied-text1' => 'Sinulla ei ole käyttöoikeuksia tähän sivuun',
	'farmer-deleting' => 'Wiki ”$1” on poistettu',
	'farmer-delete-confirm' => 'Vahvistan että haluan poistaa tämän wikin',
	'farmer-delete-confirm-wiki' => "Poistettava wiki: '''$1'''.",
	'farmer-delete-reason' => 'Poiston syy:',
	'farmer-delete-title' => 'Poista wiki',
	'farmer-delete-text' => 'Valitse poistettava wiki alla olevasta listasta',
	'farmer-delete-form' => 'Valitse wiki',
	'farmer-delete-form-submit' => 'Poista',
	'farmer-listofwikis' => 'Lista wikeistä',
	'farmer-mainpage' => 'Etusivu',
	'farmer-basic-title' => 'Perusarvot',
	'farmer-basic-title1' => 'Otsikko',
	'farmer-basic-title1-text' => 'Wikilläsi ei ole otsikkoa.  Aseta se <b>nyt</b>',
	'farmer-basic-description' => 'Kuvaus',
	'farmer-basic-description-text' => 'Lisää kuvaus wikistäsi alle',
	'farmer-basic-permission' => 'Käyttöoikeudet',
	'farmer-basic-permission-text' => 'Alla olevaa lomaketta käyttäen on mahdollista muokata tämän wikin käyttäjien käyttöoikeuksia.',
	'farmer-basic-permission-visitor' => 'Jokaisen vierailijan oikeudet',
	'farmer-basic-permission-visitor-text' => 'Seuraavat oikeudet annetaan jokaiselle tässä wikissä vierailevalle käyttäjälle',
	'farmer-yes' => 'Kyllä',
	'farmer-no' => 'Ei',
	'farmer-basic-permission-user' => 'Sisäänkirjautuneiden käyttäjien käyttöoikeudet',
	'farmer-basic-permission-user-text' => 'Seuraavat käyttöoikeudet annetaan jokaiselle sisäänkirjautuneelle käyttäjälle',
	'farmer-setpermission' => 'Aseta käyttöoikeudet',
	'farmer-defaultskin' => 'Oletusulkoasu',
	'farmer-defaultskin-button' => 'Aseta oletusulkoasu',
	'farmer-extensions' => 'Käytössä olevat laajennukset',
	'farmer-extensions-button' => 'Muuta käytössä olevia laajennuksia',
	'farmer-extensions-extension-denied' => 'Sinulla ei ole oikeuksia tämän toiminnon käyttämiseen.
Sinun tulee olla farmeradmin-ryhmän jäsen',
	'farmer-extensions-invalid' => 'Virheellinen laajennus',
	'farmer-extensions-invalid-text' => 'Laajennuksen lisääminen epäonnistui koska sisällytettäväksi valittua tiedostoa ei löytynyt',
	'farmer-extensions-available' => 'Saatavilla olevat laajennukset',
	'farmer-extensions-noavailable' => 'Yhtään laajennusta ei ole rekisteröity',
	'farmer-extensions-register' => 'Rekisteröi laajennus',
	'farmer-extensions-register-text1' => 'Käytä alla olevaa lomaketta rekisteröidäksesi uuden laajennuksen farmiin.
Kun laajennus on rekisteröity, kaikki wikit voivat käyttää sitä.',
	'farmer-extensions-register-text2' => "'''Sisällytä tiedosto''' -parametrin arvoksi anna PHP-tiedoston nimi kuin antaisit sen LocalSettings.php:ssä.",
	'farmer-extensions-register-text3' => "Jos tiedostonimi sisältää '''\$root'''-merkkijonon, se korvataan MediaWikin juurihakemistolla.",
	'farmer-extensions-register-text4' => 'Nykyiset sisällytyspolut ovat:',
	'farmer-extensions-register-name' => 'Nimi',
	'farmer-extensions-register-includefile' => 'Sisällytä tiedosto',
	'farmer-error-exists' => 'Wikiä ei voitu luoda.  Se on jo olemassa: $1',
	'farmer-error-noextwrite' => 'Laajennustiedoston kirjoittaminen epäonnistui:',
	'farmer-log-name' => 'Wiki-farmin loki',
	'farmer-log-header' => 'Tämä on loki wiki-farmiin tehdyistä muutoksista.',
	'farmer-log-create' => 'luotiin wiki ”$2”',
	'farmer-log-delete' => 'poistettiin wiki ”$2”',
	'right-farmeradmin' => 'Hallinnoida wikifarmia',
	'right-createwiki' => 'Luoda wikejä wikifarmiin',
);

/** French (Français)
 * @author Crochet.david
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Peter17
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'farmer' => 'Administration Multi Wikis',
	'farmer-desc' => 'Administre plusieurs wikis',
	'farmercantcreatewikis' => 'Vous ne pouvez pas créer des wikis car vous n’avez pas l’habilitation « createwikis » nécessaire pour cela.',
	'farmercreateurl' => 'adresse URL',
	'farmercreatesitename' => 'Nom du site',
	'farmercreatenextstep' => 'Étape suivante',
	'farmernewwikimainpage' => '== Bienvenue dans votre Wiki ==
Si vous lisez ce message, ceci indique que votre wiki a été installé correctement.
Vous pouvez [[Special:Farmer|individualiser votre wiki]].',
	'farmer-about' => 'À propos',
	'farmer-about-text' => 'L’extension MediaWiki Farmer vous permet, en permanence, d’organiser un ensemble de wikis issu du logiciel MediaWiki.',
	'farmer-list-wiki' => 'Liste des wikis',
	'farmer-list-wiki-text' => '[[$1|Lister]] tous les wikis sur ce site.',
	'farmer-createwiki' => 'Créer un Wiki',
	'farmer-createwiki-text' => '[[$1|Créer]] maintenant un nouveau wiki.',
	'farmer-administration' => 'Administration générale',
	'farmer-administration-extension' => 'Organiser les extensions',
	'farmer-administration-extension-text' => '[[$1|Organiser]] les extensions installées.',
	'farmer-admimistration-listupdate' => 'Mise à jour des la liste des Wikis',
	'farmer-admimistration-listupdate-text' => '[[$1|Mettre à jour]] la liste des wikis sur ce site.',
	'farmer-administration-delete' => 'Supprimer un Wiki',
	'farmer-administration-delete-text' => '[[$1|Supprimer]] un wiki depuis ce site d’administration générale',
	'farmer-administer-thiswiki' => 'Administrer ce Wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administrer]] les changements sur ce wiki.',
	'farmer-notavailable' => 'Non disponible',
	'farmer-notavailable-text' => 'Ce programme n’est disponible que sur le site principal',
	'farmer-wikicreated' => 'Wiki créé',
	'farmer-wikicreated-text' => 'Votre wiki a été créé. Il est disponible sur $1',
	'farmer-default' => 'Personne ne dispose, par défaut, de permissions sur ce wiki à part vous. Vous pouvez changer les privilèges utilisateur via $1',
	'farmer-wikiexists' => 'Le Wiki existe',
	'farmer-wikiexists-text' => "Le wiki intitulé '''$1''' et que vous vouliez créer, existe déjà.  Nous vous invitons à retourner en arrière et d’essayer un nouveau nom.",
	'farmer-confirmsetting' => 'Confirmer les paramètres du Wiki',
	'farmer-confirmsetting-name' => 'Nom',
	'farmer-confirmsetting-title' => 'Titre',
	'farmer-confirmsetting-description' => 'Description',
	'farmer-confirmsetting-reason' => 'Motif',
	'farmer-description' => 'Description',
	'farmer-confirmsetting-text' => "Votre wiki, '''$1''', sera accessible depuis l’adresse $3.
L'espace de noms du projet sera '''$2'''.
Les liens vers cet espace de noms seront de la forme '''<nowiki>[[$2:Nom de la page]]</nowiki>'''.
Si c’est bien ce que vous voulez, cliquez sur le bouton '''Confirmer''' ci-dessous.",
	'farmer-button-confirm' => 'Confirmer',
	'farmer-button-submit' => 'Soumettre',
	'farmer-createwiki-form-title' => 'Créer un Wiki',
	'farmer-createwiki-form-text1' => 'Utilisez le formulaire ci-dessous pour créer un nouveau wiki.',
	'farmer-createwiki-form-help' => 'Aide',
	'farmer-createwiki-form-text2' => "; Nom du Wiki : Le nom du Wiki.  Il ne contient que des lettres et des chiffres. Le nom du wiki sera utilisé comme une partie de l'adresse afin de l'identifier. À titre d'exemple, si vous entrez '''titre''', votre wiki sera accessible sur <nowiki>http://</nowiki>'''titre'''.mondomaine.",
	'farmer-createwiki-form-text3' => '; Titre du Wiki : Le titre du wiki.  Il sera utilisé dans le titre de chaque page de votre wiki. Il prendra le nom de l’espace « Project » ainsi que le préfixe interwiki.',
	'farmer-createwiki-form-text4' => '; Description : Description du wiki. Ceci consiste en un texte décrivant le wiki. Il sera affiché dans la liste des wikis.',
	'farmer-createwiki-user' => 'Nom d’utilisateur',
	'farmer-createwiki-name' => 'Nom du Wiki',
	'farmer-createwiki-title' => 'Titre du Wiki',
	'farmer-createwiki-description' => 'Description',
	'farmer-createwiki-reason' => 'Motif',
	'farmer-updatedlist' => 'Liste mise à jour',
	'farmer-notaccessible' => 'Non accessible',
	'farmer-notaccessible-test' => 'Ce programme est disponible uniquement sur le wiki principal de cet ensemble de projets.',
	'farmer-permissiondenied' => 'Permission refusée',
	'farmer-permissiondenied-text' => 'Vous n’avez pas la permission de supprimer un wiki depuis le site d’administration général.',
	'farmer-permissiondenied-text1' => 'Il ne vous est pas permis d’accéder à cette page.',
	'farmer-deleting' => 'Le wiki « $1 » a été supprimé',
	'farmer-delete-confirm' => 'Je confirme que je veux supprimer ce wiki',
	'farmer-delete-confirm-wiki' => "Wiki à supprimer : '''$1'''.",
	'farmer-delete-reason' => 'Motif de suppression :',
	'farmer-delete-title' => 'Supprimer un Wiki',
	'farmer-delete-text' => 'Veuillez sélectionner le wiki que vous désirez supprimer depuis la liste ci-dessous.',
	'farmer-delete-form' => 'Selectionnez un wiki',
	'farmer-delete-form-submit' => 'Supprimer',
	'farmer-listofwikis' => 'Liste des Wikis',
	'farmer-mainpage' => 'Accueil',
	'farmer-basic-title' => 'Paramètres de base',
	'farmer-basic-title1' => 'Titre',
	'farmer-basic-title1-text' => "Votre wiki ne dispose pas de titre. Indiquez en un '''maintenant'''",
	'farmer-basic-description' => 'Description',
	'farmer-basic-description-text' => 'Indiquez dans le cadre ci-dessous la description de votre wiki.',
	'farmer-basic-permission' => 'Autorisations',
	'farmer-basic-permission-text' => 'En utilisant le formulaire ci-dessous, il est possible de changer les habilitations des utilisateurs de ce wiki.',
	'farmer-basic-permission-visitor' => 'Habilitations pour chaque visiteur',
	'farmer-basic-permission-visitor-text' => 'Les habilitations suivantes seront applicables pour toutes les personnes qui visiteront ce wiki.',
	'farmer-yes' => 'Oui',
	'farmer-no' => 'Non',
	'farmer-basic-permission-user' => 'Habilitations pour les utilisateurs enregistrés',
	'farmer-basic-permission-user-text' => 'Les habilitations suivantes seront applicables à tous les utilisateurs enregistrés sur ce wiki.',
	'farmer-setpermission' => 'Configurer les habilitations',
	'farmer-defaultskin' => 'Apparences par défaut',
	'farmer-defaultskin-button' => 'Configurer l’apparence par défaut',
	'farmer-extensions' => 'Extensions actives',
	'farmer-extensions-button' => 'Configurer les extensions actives',
	'farmer-extensions-extension-denied' => 'Vous n’êtes pas habilité{{GENDER:||e|(e)}} pour l’utilisation de cette fonctionnalité. Vous devez être membre des administrateurs de l’administration multi wikis.',
	'farmer-extensions-invalid' => 'Extension invalide',
	'farmer-extensions-invalid-text' => 'Nous ne pouvons ajouter cette extension car le fichier sélectionné pour l’inclusion est introuvable.',
	'farmer-extensions-available' => 'Extensions disponibles',
	'farmer-extensions-noavailable' => 'Aucune extension n’est enregistrée.',
	'farmer-extensions-register' => 'Enregistrer une extension',
	'farmer-extensions-register-text1' => 'Utilisez le formulaire ci-dessous pour enregistrer une nouvelle extension avec cette fonctionnalité. Une fois l’extension enregistrée, tous les wikis pourront l’utiliser.',
	'farmer-extensions-register-text2' => "En ce qui concerne le paramètre ''Fichier Include'', indiquez le nom du fichier PHP que vous voulez dans LocalSettings.php.",
	'farmer-extensions-register-text3' => "Si le nom du fichier contient '''\$root''', cette variable sera remplacée par le répertoire racine de MediaWiki.",
	'farmer-extensions-register-text4' => 'Les chemins actuels des fichiers include sont :',
	'farmer-extensions-register-name' => 'Nom',
	'farmer-extensions-register-includefile' => 'Fichier à inclure',
	'farmer-error-exists' => 'L’interface ne peut créer le Wiki.  Il existe déjà : $1',
	'farmer-error-noextwrite' => 'Impossible d’écrire le fichier d’extension suivant :',
	'farmer-log-name' => 'Journal de la ferme wiki',
	'farmer-log-header' => 'Ce journal contient les modifications apportées à la ferme wiki.',
	'farmer-log-create' => 'a créé le wiki « $2 »',
	'farmer-log-delete' => 'a supprimé le wiki « $2 »',
	'right-farmeradmin' => 'Gérer la ferme de wikis',
	'right-createwiki' => 'Créer des wikis dans la ferme de wikis',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'farmer' => 'Grangiér',
	'farmer-desc' => 'Administre una grange MediaWiki.',
	'farmercreateurl' => 'adrèce URL',
	'farmercreatesitename' => 'Nom du seto',
	'farmercreatenextstep' => 'Ètapa aprés',
	'farmer-about' => 'A propôs',
	'farmer-list-wiki' => 'Lista des vouiquis',
	'farmer-list-wiki-text' => '[[$1|Listar]] tôs los vouiquis dessus {{SITENAME}}',
	'farmer-createwiki' => 'Fâre un vouiqui',
	'farmer-createwiki-text' => '[[$1|Fâre]] un novél vouiqui orendrêt !',
	'farmer-administration' => 'Administracion de la grange',
	'farmer-administration-extension' => 'Administrar les èxtensions',
	'farmer-administration-extension-text' => '[[$1|Administrar]] les èxtensions enstalâs.',
	'farmer-admimistration-listupdate' => 'Misa a jorn de la lista de la grange',
	'farmer-admimistration-listupdate-text' => '[[$1|Betar a jorn]] la lista des vouiquis dessus {{SITENAME}}',
	'farmer-administration-delete' => 'Suprimar un vouiqui',
	'farmer-administration-delete-text' => '[[$1|Suprimar]] un vouiqui dês la grange',
	'farmer-administer-thiswiki' => 'Administrar ceti vouiqui',
	'farmer-administer-thiswiki-text' => '[[$1|Administrar]] los changements sur cél vouiqui',
	'farmer-notavailable' => 'Pas disponiblo',
	'farmer-wikicreated' => 'Vouiqui fêt',
	'farmer-wikiexists' => 'Lo vouiqui ègziste',
	'farmer-confirmsetting' => 'Confirmar los paramètres du vouiqui',
	'farmer-confirmsetting-name' => 'Nom',
	'farmer-confirmsetting-title' => 'Titro',
	'farmer-confirmsetting-description' => 'Dèscripcion',
	'farmer-confirmsetting-reason' => 'Rêson',
	'farmer-description' => 'Dèscripcion',
	'farmer-button-confirm' => 'Confirmar',
	'farmer-button-submit' => 'Sometre',
	'farmer-createwiki-form-title' => 'Fâre un vouiqui',
	'farmer-createwiki-form-help' => 'Éde',
	'farmer-createwiki-user' => 'Nom d’usanciér',
	'farmer-createwiki-name' => 'Nom du vouiqui',
	'farmer-createwiki-title' => 'Titro du vouiqui',
	'farmer-createwiki-description' => 'Dèscripcion',
	'farmer-createwiki-reason' => 'Rêson',
	'farmer-updatedlist' => 'Lista betâ a jorn',
	'farmer-notaccessible' => 'Pas accèssiblo',
	'farmer-permissiondenied' => 'Pèrmission refusâ',
	'farmer-deleting' => 'Lo vouiqui « $1 » at étâ suprimâ',
	'farmer-delete-confirm-wiki' => "Vouiqui a suprimar : '''$1'''.",
	'farmer-delete-reason' => 'Rêson de la suprèssion :',
	'farmer-delete-title' => 'Suprimar un vouiqui',
	'farmer-delete-form' => 'Chouèsésséd un vouiqui',
	'farmer-delete-form-submit' => 'Suprimar',
	'farmer-listofwikis' => 'Lista des vouiquis',
	'farmer-mainpage' => 'Reçua',
	'farmer-basic-title' => 'Paramètres de bâsa',
	'farmer-basic-title1' => 'Titro',
	'farmer-basic-description' => 'Dèscripcion',
	'farmer-basic-permission' => 'Pèrmissions',
	'farmer-basic-permission-visitor' => 'Pèrmissions por châque visitor',
	'farmer-yes' => 'Ouè',
	'farmer-no' => 'Nan',
	'farmer-basic-permission-user' => 'Pèrmissions por los utilisators encartâs',
	'farmer-setpermission' => 'Dèfenir les pèrmissions',
	'farmer-defaultskin' => 'Habelyâjo per dèfôt',
	'farmer-defaultskin-button' => 'Dèfenir l’habelyâjo per dèfôt',
	'farmer-extensions' => 'Èxtensions actives',
	'farmer-extensions-button' => 'Dèfenir les èxtensions actives',
	'farmer-extensions-invalid' => 'Èxtension envalida',
	'farmer-extensions-available' => 'Èxtensions disponibles',
	'farmer-extensions-noavailable' => 'Niona èxtension est encartâ',
	'farmer-extensions-register' => 'Encartar una èxtension',
	'farmer-extensions-register-text4' => 'Los chemins d’ora des fichiérs a encllure sont :',
	'farmer-extensions-register-name' => 'Nom',
	'farmer-extensions-register-includefile' => 'Fichiér a encllure',
	'farmer-error-exists' => 'Empossiblo de fâre lo vouiqui. Ègziste ja : $1',
	'farmer-error-noextwrite' => 'Empossiblo d’ècrire ceti fichiér d’èxtension :',
	'farmer-log-name' => 'Jornal de la grange vouiqui',
	'farmer-log-header' => 'Ceti jornal contint los changements aportâs a la grange vouiqui.',
	'farmer-log-create' => 'at fêt lo vouiqui « $2 »',
	'farmer-log-delete' => 'at suprimâ lo vouiqui « $2 »',
	'right-farmeradmin' => 'Administrar la grange vouiqui',
	'right-createwiki' => 'Fâre des vouiquis dens la grange vouiqui',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'farmer-description' => 'Beskriuwing',
	'farmer-createwiki-user' => 'Meidoggernamme',
	'farmer-createwiki-description' => 'Beskriuwing',
	'farmer-delete-form-submit' => 'Wiskje',
	'farmer-mainpage' => 'Haadside',
	'farmer-basic-description' => 'Beskriuwing',
	'farmer-yes' => 'Ja',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'farmer' => 'Granxeiro',
	'farmer-desc' => 'Xestionar unha granxa MediaWiki',
	'farmercantcreatewikis' => 'Non pode crear wikis porque non ten os privilexios de creación de wikis',
	'farmercreatesitename' => 'Nome do sitio',
	'farmercreatenextstep' => 'Seguinte paso',
	'farmernewwikimainpage' => '== Dámoslle a benvida ao seu wiki ==
Se está a ler isto, o seu novo wiki foi instalado correctamente.
Pode [[Special:Farmer|personalizar o seu wiki]].',
	'farmer-about' => 'Acerca de',
	'farmer-about-text' => 'O granxeiro MediaWiki permítelle xestionar unha granxa de wikis MediaWiki.',
	'farmer-list-wiki' => 'Lista dos wikis',
	'farmer-list-wiki-text' => '[[$1|Lista]] de todos os sitios de {{SITENAME}}',
	'farmer-createwiki' => 'Crear un wiki',
	'farmer-createwiki-text' => '[[$1|Crear]] xa un novo wiki!',
	'farmer-administration' => 'Administración da granxa',
	'farmer-administration-extension' => 'Xestionar as extensións',
	'farmer-administration-extension-text' => '[[$1|Administrar]] as extensións instaladas.',
	'farmer-admimistration-listupdate' => 'Actualización da lista da granxa',
	'farmer-admimistration-listupdate-text' => '[[$1|Actualizar]] a lista de wikis en {{SITENAME}}',
	'farmer-administration-delete' => 'Eliminar un wiki',
	'farmer-administration-delete-text' => '[[$1|Borrar]] un wiki da granxa',
	'farmer-administer-thiswiki' => 'Administrar este wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administrar]] os cambios deste wiki',
	'farmer-notavailable' => 'Non dispoñible',
	'farmer-notavailable-text' => 'Esta característica só está dispoñible no wiki principal',
	'farmer-wikicreated' => 'Wiki creado',
	'farmer-wikicreated-text' => 'O seu wiki foi creado.
É accesíbel en $1',
	'farmer-default' => 'Por omisión, ninguén dispón de permisos neste wiki a excepción de vostede.
Pode modificar os privilexios de usuario mediante $1',
	'farmer-wikiexists' => 'O wiki existe',
	'farmer-wikiexists-text' => "O wiki que está intentando crear, '''$1''', xa existe.
Volva atrás e inténteo con outro nome.",
	'farmer-confirmsetting' => 'Confirmar as configuracións do wiki',
	'farmer-confirmsetting-name' => 'Nome',
	'farmer-confirmsetting-title' => 'Título',
	'farmer-confirmsetting-description' => 'Descrición',
	'farmer-confirmsetting-reason' => 'Motivo',
	'farmer-description' => 'Descrición',
	'farmer-confirmsetting-text' => "O seu wiki, '''\$1''', será accesible desde \$3.
O espazo de nomes do proxecto será '''\$2'''.
As ligazóns cara a este espazo de nomes serán da seginte forma: '''<nowiki>[[\$2:Nome da páxina]]</nowiki>'''.
Se isto é o que quere, prema no botón \"'''Confirmar'''\" de embaixo.",
	'farmer-button-confirm' => 'Confirmar',
	'farmer-button-submit' => 'Enviar',
	'farmer-createwiki-form-title' => 'Crear un wiki',
	'farmer-createwiki-form-text1' => 'Use el formulario de embaixo para crear un novo wiki.',
	'farmer-createwiki-form-help' => 'Axuda',
	'farmer-createwiki-form-text2' => "; Nome do wiki: O nome do wiki.
Contén só letras e números.
O nome do wiki será usado como parte da URL para identificar o seu wiki.
Por exemplo, se introduce '''título''', poderá acceder ao seu wiki desde <nowiki>http://</nowiki>'''título'''.dominio.",
	'farmer-createwiki-form-text3' => '; Título do wiki: Título do wiki.
Será usado no título de cada páxina no seu wiki.
Tamén será o espazo de nomes e o prefixo do interwiki do proxecto.',
	'farmer-createwiki-form-text4' => '; Descrición: Descrición do wiki.
Este é un texto descritivo sobre o wiki.
Isto aparecerá na lista dos wikis.',
	'farmer-createwiki-user' => 'Nome de usuario',
	'farmer-createwiki-name' => 'Nome do wiki',
	'farmer-createwiki-title' => 'Título do wiki',
	'farmer-createwiki-description' => 'Descrición',
	'farmer-createwiki-reason' => 'Motivo',
	'farmer-updatedlist' => 'Lista actualizada',
	'farmer-notaccessible' => 'Inaccesíbel',
	'farmer-notaccessible-test' => 'Esta característica só está dispoñible no wiki pai da granxa',
	'farmer-permissiondenied' => 'Permisos rexeitados',
	'farmer-permissiondenied-text' => 'Non ten permiso para borrar un wiki da granxa',
	'farmer-permissiondenied-text1' => 'Non ten permiso para acceder a esta páxina',
	'farmer-deleting' => 'O wiki "$1" foi borrado',
	'farmer-delete-confirm' => 'Confirmo que quero borrar este wiki',
	'farmer-delete-confirm-wiki' => "Wiki a borrar: '''$1'''.",
	'farmer-delete-reason' => 'Motivo para o borrado:',
	'farmer-delete-title' => 'Eliminar o wiki',
	'farmer-delete-text' => 'Por favor, seleccione o wiki que quere eliminar na lista de embaixo',
	'farmer-delete-form' => 'Seleccionar un wiki',
	'farmer-delete-form-submit' => 'Borrar',
	'farmer-listofwikis' => 'Lista dos wikis',
	'farmer-mainpage' => 'Portada',
	'farmer-basic-title' => 'Parámetros básicos',
	'farmer-basic-title1' => 'Título',
	'farmer-basic-title1-text' => 'O seu wiki non ten un título. Elixa un <b>agora</b>',
	'farmer-basic-description' => 'Descrición',
	'farmer-basic-description-text' => 'Poña a descrición do seu wiki embaixo',
	'farmer-basic-permission' => 'Permisos',
	'farmer-basic-permission-text' => 'O formulario de inferior permite mudar os permisos dos usuarios deste wiki.',
	'farmer-basic-permission-visitor' => 'Permisos para cada visitante',
	'farmer-basic-permission-visitor-text' => 'Os seguintes permisos serán aplicados a calquera persoa que visite este wiki',
	'farmer-yes' => 'Si',
	'farmer-no' => 'Non',
	'farmer-basic-permission-user' => 'Permisos para os usuarios rexistrados',
	'farmer-basic-permission-user-text' => 'Os seguintes permisos serán aplicados a cada persoa que estea rexistrada neste wiki',
	'farmer-setpermission' => 'Elixir permisos',
	'farmer-defaultskin' => 'Aparencia por defecto',
	'farmer-defaultskin-button' => 'Configurar a aparencia por defecto',
	'farmer-extensions' => 'Extensións activas',
	'farmer-extensions-button' => 'Elixir extensións activas',
	'farmer-extensions-extension-denied' => 'Non ten permiso para usar esta característica.
Debe ser un membro do grupo da administración da granxa',
	'farmer-extensions-invalid' => 'Extensión non válida',
	'farmer-extensions-invalid-text' => 'Non podemos engadir a extensión porque o arquivo seleccionado para incluír non se pode atopar',
	'farmer-extensions-available' => 'Extensións dispoñíbeis',
	'farmer-extensions-noavailable' => 'Non hai extensións rexistradas',
	'farmer-extensions-register' => 'Rexistrar a extensión',
	'farmer-extensions-register-text1' => 'Use o formulario de embaixo para rexistrar unha nova extención coa granxa.
Unha vez que a extensión estea rexistrada, todos os wikis poderana usar.',
	'farmer-extensions-register-text2' => "Para o parámetro ''Incluír o ficheiro'' insira o nome do ficheiro PHP como o quere en LocalSettings.php.",
	'farmer-extensions-register-text3' => "Se o nome do ficheiro contén '''\$root''', esa variable será reemprazada coa raíz do directorio MediaWiki.",
	'farmer-extensions-register-text4' => 'Os camiños incluídos actualmente son:',
	'farmer-extensions-register-name' => 'Nome',
	'farmer-extensions-register-includefile' => 'Incluír o ficheiro',
	'farmer-error-exists' => 'Non pode crear o wiki. Xa existe: $1',
	'farmer-error-noextwrite' => 'Non pode escribir a extensión do ficheiro:',
	'farmer-log-name' => 'Rexistro do wiki granxa',
	'farmer-log-header' => 'Este é un rexistro dos cambios feitos no wiki granxa.',
	'farmer-log-create' => 'creou o wiki "$2"',
	'farmer-log-delete' => 'eliminou o wiki "$2"',
	'right-farmeradmin' => 'Xestionar o wiki granxa',
	'right-createwiki' => 'Crear wikis no wiki granxa',
);

/** Gothic (Gothic)
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'farmer-delete-form-submit' => 'Taíran',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'farmercreatesitename' => 'Ὄνομα ἱστοτόπου',
	'farmercreatenextstep' => 'Ἑπόμενον βῆμα',
	'farmer-about' => 'Περί',
	'farmer-createwiki' => 'Ποιεῖν βίκι τι',
	'farmer-administration-delete' => 'Διαγράφειν βίκι τι',
	'farmer-notavailable' => 'Μὴ διαθέσιμος',
	'farmer-confirmsetting-name' => 'Ὄνομα',
	'farmer-confirmsetting-title' => 'Ἐπιγραφή',
	'farmer-confirmsetting-description' => 'Περιγραφή',
	'farmer-confirmsetting-reason' => 'Αἰτία',
	'farmer-description' => 'Περιγραφή',
	'farmer-button-confirm' => 'Κυροῦν',
	'farmer-button-submit' => 'Ὑποβάλλειν',
	'farmer-createwiki-form-title' => 'Ποιεῖν βίκι τι',
	'farmer-createwiki-form-help' => 'Βοήθεια',
	'farmer-createwiki-user' => 'Ὄνομα χρωμένου',
	'farmer-createwiki-description' => 'Περιγραφή',
	'farmer-createwiki-reason' => 'Αἰτία',
	'farmer-delete-form-submit' => 'Σβεννύναι',
	'farmer-mainpage' => 'Κυρία Δέλτος',
	'farmer-basic-title1' => 'Ἐπιγραφή',
	'farmer-basic-description' => 'Περιγραφή',
	'farmer-yes' => 'Ναί',
	'farmer-no' => 'Οὐ',
	'farmer-extensions-register-name' => 'Ὄνομα',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author J. 'mach' wust
 */
$messages['gsw'] = array(
	'farmer' => 'Wiki-Buur',
	'farmer-desc' => 'E MediaWiki-Hof verwalte',
	'farmercantcreatewikis' => 'Du chasch kei Wiki aalege, wel Dir s Rächt („createwikis“) dezue fählt.',
	'farmercreatesitename' => 'Name vu dr Website',
	'farmercreatenextstep' => 'Nechschte Schritt',
	'farmernewwikimainpage' => '== Willchu in Dyynem Wiki ==

Wänn Du dää Täxt liisesch, no hesch Dyy nej Wiki inschtalliert.
Du chasch s no Dyyne Winsch [[Special:Farmer|aapasse]].',
	'farmer-about' => 'Iber',
	'farmer-about-text' => 'MediaWiki-Farmer macht s Dir megli, mehreri MediaWiki z verwalte.',
	'farmer-list-wiki' => 'Wiki uflischte',
	'farmer-list-wiki-text' => '[[$1|Lischt]] vu allene Wiki uf {{SITENAME}}',
	'farmer-createwiki' => 'E Wiki aalege',
	'farmer-createwiki-text' => '[[$1|Leg]] jetz e nej Wiki aa.',
	'farmer-administration' => 'Hof-Verwaltig',
	'farmer-administration-extension' => 'Erwyterige verwalte',
	'farmer-administration-extension-text' => '[[$1|Verwalt]] inschtallierti Erwyterige.',
	'farmer-admimistration-listupdate' => 'Heflischt aktualisiere',
	'farmer-admimistration-listupdate-text' => '[[$1|Aktualisier]] d Lischt vu dr Wiki uf {{SITENAME}}',
	'farmer-administration-delete' => 'E Wiki lesche',
	'farmer-administration-delete-text' => '[[$1|Lesch]] e Wiki vum Hof',
	'farmer-administer-thiswiki' => 'Des Wiki verwalte',
	'farmer-administer-thiswiki-text' => 'Des Wiki [[$1|verwalte]]',
	'farmer-notavailable' => 'Nit verfiegbar',
	'farmer-notavailable-text' => 'Des Feature isch numen im Hauptwiki verfiegbar',
	'farmer-wikicreated' => 'Wiki aagleit',
	'farmer-wikicreated-text' => 'Dyy Wiki isch aagleit wore.
S isch doo: $1',
	'farmer-default' => 'Am Aafang het nieme ußer Dir irgedweleni Rächt in däm Wiki.
Mit $1 chasch d Benutzerrächt ändere',
	'farmer-wikiexists' => 'Wiki git s',
	'farmer-wikiexists-text' => "S Wiki – '''$1''' –, wu Du versuechsch aazlege, git s scho.
Bitte gang zrugg un versuech s mit eme andere Name",
	'farmer-confirmsetting' => 'Wiki-Yystellige bstätige',
	'farmer-confirmsetting-name' => 'Name',
	'farmer-confirmsetting-title' => 'Titel',
	'farmer-confirmsetting-description' => 'Bschryybig',
	'farmer-confirmsetting-reason' => 'Grund',
	'farmer-description' => 'Bschryybig',
	'farmer-confirmsetting-text' => "Dyy Wiki, '''$1''', wird iber $3 erreichbar syy.
Dr Projektnamensruum wird '''$2''' heiße.
Gleicher zue däm Namensruum wäre d Gstalt '''<nowiki>[[$2:Page name]]</nowiki>''' haa.
Wänn alles korräkt isch, no bstätig des mit eme Druck uf '''Bstätige'''.",
	'farmer-button-confirm' => 'Bstätige',
	'farmer-button-submit' => 'Abschicke',
	'farmer-createwiki-form-title' => 'E Wiki aalege',
	'farmer-createwiki-form-text1' => 'Bruuch des Formular go ne nej Wiki aalege.',
	'farmer-createwiki-form-help' => 'Hilf',
	'farmer-createwiki-form-text2' => "; Wikiname: Dr Name vum Wiki.
S derfe nume d Buechstaben A–Z un Zahle din syy.
Dr Wikiname wird as Teil vu dr URL zum Wiki bruucht.
Wänn Du zum Byypil '''Name''' aagisch, no wird d URL zum Wiki <nowiki>http://</nowiki>'''name'''.example.com/ heiße.",
	'farmer-createwiki-form-text3' => '; Wikiname: Name vum Wiki.
Er wird uf jedere Syte vum Wiki bruucht.
Er wird au dr Titel vum Projäktnamensruum un vum Interwiki-Präfix syy.',
	'farmer-createwiki-form-text4' => '; Bschryybig: Bschryybig vum Wiki.
Dää Täxt bschrybt s Wiki un wird uf dr Lischt vu dr Wiki aazeigt.',
	'farmer-createwiki-user' => 'Benutzername',
	'farmer-createwiki-name' => 'Wikiname',
	'farmer-createwiki-title' => 'Wikititel',
	'farmer-createwiki-description' => 'Bschryybig',
	'farmer-createwiki-reason' => 'Grund',
	'farmer-updatedlist' => 'Lischt aktualisiere',
	'farmer-notaccessible' => 'Nit verfiegbar',
	'farmer-notaccessible-test' => 'Des Feature isch numen im Elterewiki vum Hof verfiegbar',
	'farmer-permissiondenied' => 'Zuegriff verweigeret',
	'farmer-permissiondenied-text' => 'Du derfsch kei Wiki vum Hof lesche',
	'farmer-permissiondenied-text1' => 'Du derfsch uf die Syte nit zuegryfe',
	'farmer-deleting' => 'S Wiki „$1“ isch glescht wore',
	'farmer-delete-confirm' => 'Ich bstätig, ass i des Wiki will lesche',
	'farmer-delete-confirm-wiki' => "Wiki, wu soll glescht wäre: '''$1'''.",
	'farmer-delete-reason' => 'Grund fir d Leschig:',
	'farmer-delete-title' => 'Wiki lesche',
	'farmer-delete-text' => 'Bitte wehl s Wiki, wu Du witt leschen, us dr Lischt uus',
	'farmer-delete-form' => 'Wehl e Wiki',
	'farmer-delete-form-submit' => 'Lesche',
	'farmer-listofwikis' => 'Lischt vu dr Wiki',
	'farmer-mainpage' => 'Hauptsyte',
	'farmer-basic-title' => 'Grundsätzligi Parameter',
	'farmer-basic-title1' => 'Titel',
	'farmer-basic-title1-text' => 'Dyy Wiki het no kei Titel. Bitte setz en <b>jetz</b>',
	'farmer-basic-description' => 'Bschryybig',
	'farmer-basic-description-text' => 'Fieg unte d Bschryybig vu Dyynem Wiki yy',
	'farmer-basic-permission' => 'Rächt',
	'farmer-basic-permission-text' => 'Mit däm Formular isch s megli, d Benutzerrächt vum Wiki s ändere.',
	'farmer-basic-permission-visitor' => 'Gaschträcht',
	'farmer-basic-permission-visitor-text' => 'Die Rächt gälte fir Gescht im Wiki',
	'farmer-yes' => 'Jo',
	'farmer-no' => 'Nei',
	'farmer-basic-permission-user' => 'Rächt vu aagmäldete Benutzer',
	'farmer-basic-permission-user-text' => 'Die Rächt gälte fir aagmäldeti Benutzer',
	'farmer-setpermission' => 'Rächt setze',
	'farmer-defaultskin' => 'Standardoberflächi',
	'farmer-defaultskin-button' => 'Standardoberflächi setze',
	'farmer-extensions' => 'Alli Erwyterige',
	'farmer-extensions-button' => 'Aktivi Erwyterige setze',
	'farmer-extensions-extension-denied' => 'Du derfsch des Feature nit verwände, wel dodefir mießtsch zu dr Ammanne vu däm Hof ghere',
	'farmer-extensions-invalid' => 'Nit giltigi Erwyterig',
	'farmer-extensions-invalid-text' => 'D Erwyterig het nit chenne zuegfiegt wäre, wel d Datei, wu zue dr Yybindig uusgwehlt woren isch, isch nit gfunde wore',
	'farmer-extensions-available' => 'Verfiegbari Erwyterige',
	'farmer-extensions-noavailable' => 'S sin kei Erwyterige regischtriert wore',
	'farmer-extensions-register' => 'Erwyterig aamälde',
	'farmer-extensions-register-text1' => 'Bruuch die Maschke unte go ne neji Erwyterig fir dr Hof regischtriere.
Wänn e Erwyterig regischtriert isch, chenne alli Wiki si bruuche.',
	'farmer-extensions-register-text2' => "Gib dr Name vu dr PHP-Datei im ''Include file''-Parameter eso aa, wie Du ne in LocalSettings.php tetsch aagee.",
	'farmer-extensions-register-text3' => "Wänn s im Dateiname '''\$root''' din het, wird die Variable dur s MediaWiki-Wurzelverzeichnis ersetzt.",
	'farmer-extensions-register-text4' => 'D Pfad, wu s aktuäll din het, sin:',
	'farmer-extensions-register-name' => 'Name',
	'farmer-extensions-register-includefile' => 'Datei yybinde',
	'farmer-error-exists' => 'S Wiki cha nit aagleit wäre, wel s es scho git: $1',
	'farmer-error-noextwrite' => 'D Erwyterigsdatei schryybe isch nit megli:',
	'farmer-log-name' => 'Wiki-Hof-Logbuech',
	'farmer-log-header' => 'Des isch e Logbuech vu dr Änderige, wu am Wiki-Hof gmacht wore sin.',
	'farmer-log-create' => 'het s Wiki „$2“ aagleit',
	'farmer-log-delete' => 'het s Wiki „$2“ glescht',
	'right-farmeradmin' => 'Dr Wiki-Hof verwalte',
	'right-createwiki' => 'Wikis uf em Wiki-Hof aalege',
);

/** Gujarati (ગુજરાતી)
 * @author Dineshjk
 */
$messages['gu'] = array(
	'farmer-createwiki-user' => 'સભ્ય નામ:',
);

/** Manx (Gaelg)
 * @author MacTire02
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'farmer' => 'Eirinagh',
	'farmer-desc' => 'Gowaltys MediaWiki y reirey',
	'farmercreatesitename' => 'Ennym yn ynnyd',
	'farmercreatenextstep' => 'Yn chied keim elley',
	'farmer-about' => 'Mychione',
	'farmer-list-wiki' => 'Rolley dagh ooilley Wiki',
	'farmer-list-wiki-text' => '[[$1|Rolley]] dagh ooilley wiki er {{SITENAME}}',
	'farmer-createwiki' => 'Croo Wiki',
	'farmer-createwiki-text' => '[[$1|Croo]] wiki noa nish!',
	'farmer-administration' => 'Reirey gowaltys',
	'farmer-administration-delete' => 'Wiki y scryssey',
	'farmer-administration-delete-text' => '[[$1|Scryss]] wiki ass y gowaltys',
	'farmer-administer-thiswiki' => 'Yn Wiki shoh y reirey',
	'farmer-wikicreated' => "Ta'n Wiki crooit",
	'farmer-confirmsetting-name' => 'Ennym',
	'farmer-confirmsetting-title' => 'Ard-ennym',
	'farmer-confirmsetting-description' => 'Tuarastyl',
	'farmer-confirmsetting-reason' => 'Fa:',
	'farmer-description' => 'Tuarastyl',
	'farmer-button-submit' => 'Cur roish',
	'farmer-createwiki-form-title' => 'Croo Wiki',
	'farmer-createwiki-form-help' => 'Cooney',
	'farmer-createwiki-user' => 'Ennym yn ymmydeyr',
	'farmer-createwiki-name' => 'Ennym y Wiki',
	'farmer-createwiki-title' => 'Ard-ennym y Wiki',
	'farmer-createwiki-description' => 'Tuarastyl',
	'farmer-createwiki-reason' => 'Fa:',
	'farmer-deleting' => 'Va\'n wiki "$1" scrysst magh',
	'farmer-delete-title' => 'Scryss Wiki',
	'farmer-delete-form' => 'Gow wiki myr reih',
	'farmer-delete-form-submit' => 'Scryssey',
	'farmer-listofwikis' => 'Rolley dagh ooilley Wiki',
	'farmer-mainpage' => 'Ard-ghuillag',
	'farmer-basic-title1' => 'Ard-ennym',
	'farmer-basic-title1-text' => 'Cha nel kione-ghraue ec dty wiki. Cur ard-ennym da <b>nish</b>',
	'farmer-basic-description' => 'Tuarastyl',
	'farmer-yes' => 'Ta',
	'farmer-no' => 'Cha',
	'farmer-extensions-register-name' => 'Ennym',
	'farmer-extensions-register-includefile' => 'Goaill stiagh y coadan',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'farmer-confirmsetting-reason' => 'Dalili',
	'farmer-createwiki-reason' => 'Dalili',
	'farmer-delete-form-submit' => 'Soke',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'farmer-createwiki-user' => 'Yung-fu-miàng',
	'farmer-delete-form-submit' => 'Chhù-thet',
	'farmer-mainpage' => 'Thèu-chông',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'farmer-about' => 'E pili ana',
	'farmer-mainpage' => 'Papa kinohi',
	'farmer-extensions-register-name' => 'Inoa',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'farmer' => 'חוואי',
	'farmer-desc' => 'ניהול חוות מדיה־ויקי',
	'farmercantcreatewikis' => 'אין באפשרותכם ליצור אתרי ויקי כיוון שאין לכם את ההרשאה createwikis',
	'farmercreateurl' => 'כתובת',
	'farmercreatesitename' => 'שם האתר',
	'farmercreatenextstep' => 'הצעד הבא',
	'farmernewwikimainpage' => '== ברוכים הבאים לוויקי שלכם ==
אם אתם קוראים זאת, הוויקי החדש שלכם מותקן כראוי.
תוכלו [[Special:Farmer|להתאים את הוויקי שלכם]].',
	'farmer-about' => 'אודות',
	'farmer-about-text' => 'החוואי של מדיה־ויקי מאפשר לכם לנהל חווה של אתרי ויקי במדיה־ויקי',
	'farmer-list-wiki' => 'רשימת אתרי ויקי',
	'farmer-list-wiki-text' => '[[$1|הצגת]] כל אתרי הוויקי ב־{{SITENAME}}',
	'farmer-createwiki' => 'יצירת אתר ויקי',
	'farmer-createwiki-text' => '[[$1|יצירת]] אתר ויקי חדש כעת!',
	'farmer-administration' => 'ניהול חווה',
	'farmer-administration-extension' => 'ניהול הרחבות',
	'farmer-administration-extension-text' => '[[$1|ניהול]] הרחבות מותקנות.',
	'farmer-admimistration-listupdate' => 'עדכון רשימת החווה',
	'farmer-admimistration-listupdate-text' => '[[$1|עדכון]] רשימת אתרי הוויקי ב{{grammar:תחילית|{{SITENAME}}}}',
	'farmer-administration-delete' => 'מחיקת ויקי',
	'farmer-administration-delete-text' => '[[$1|מחיקת]] ויקי מהחווה',
	'farmer-administer-thiswiki' => 'ניהול ויקי זה',
	'farmer-administer-thiswiki-text' => '[[$1|ניהול]] השינויים לוויקי זה',
	'farmer-notavailable' => 'לא זמין',
	'farmer-notavailable-text' => 'תכונה זו זמינה עבור הוויקי הראשי בלבד',
	'farmer-wikicreated' => 'הוויקי נוצר',
	'farmer-wikicreated-text' => 'הוויקי שלכם נוצר.
ניתן לגשת אליו ב־$1',
	'farmer-default' => 'כברירת מחדל, לאף אחד אין הרשאות לוויקי זה מלבדך.
ניתן לשנות את הרשאות המשתמש דרך $1',
	'farmer-wikiexists' => 'הוויקי קיים',
	'farmer-wikiexists-text' => "הוויקי שהנכם מנסים ליצור '''$1''', כבר קיים.
יש לחזור ולנסות שם אחר.",
	'farmer-confirmsetting' => 'אישור הגדרות הוויקי',
	'farmer-confirmsetting-name' => 'שם',
	'farmer-confirmsetting-title' => 'כותרת',
	'farmer-confirmsetting-description' => 'תיאור',
	'farmer-confirmsetting-reason' => 'סיבה',
	'farmer-description' => 'תיאור',
	'farmer-confirmsetting-text' => "הוויקי שלכם , '''$1''', יהיה נגיש דרך $3.
מרחב השם של המיזם יהיה '''$2'''.
קישורים למרחב שם זה יהיו מהצורה  '''<nowiki>[[$2:שם העמוד]]</nowiki>'''.
אם זהו רצונכם, לחצו על כפתור ה'''אישור''' שלהלן.",
	'farmer-button-confirm' => 'אישור',
	'farmer-button-submit' => 'שליחה',
	'farmer-createwiki-form-title' => 'יצירת ויקי',
	'farmer-createwiki-form-text1' => 'השתמשו בטופס שלהלן ליצירת ויקי חדש.',
	'farmer-createwiki-form-help' => 'עזרה',
	'farmer-createwiki-form-text2' => "; שם אתר הוויקי: השם של אתר הוויקי.
מכיל אותיות ומספרים בלבד.
שם אתר הוויקי ישמש כחלק מהכתובת ה־URL של אתר הוויקי שלכם.
למשל, אם תזינו '''title''', ניתן יהיה לגשת אל אתר הוויקי שלכם דרך <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; כותרת הוויקי: הכותרת של הוויקי.
ישמש בכותרת של כל דף בוויקי שלכם.
כמו כן, ישמש כמרחב השם של המיזם וכקידומת הבינוויקי.',
	'farmer-createwiki-form-text4' => '; תיאור: התיאור של הוויקי.
זהו תיאור מילולי של הוויקי.
תיאור זה יוצג ברשימת אתרי הוויקי.',
	'farmer-createwiki-user' => 'שם המשתמש',
	'farmer-createwiki-name' => 'שם הוויקי',
	'farmer-createwiki-title' => 'כותרת הוויקי',
	'farmer-createwiki-description' => 'תיאור',
	'farmer-createwiki-reason' => 'סיבה',
	'farmer-updatedlist' => 'רשימה מעודכנת',
	'farmer-notaccessible' => 'לא נגיש',
	'farmer-notaccessible-test' => 'תכונה זו זמינה עבור הוויקי הראשי בחווה בלבד',
	'farmer-permissiondenied' => 'הגישה נדחתה',
	'farmer-permissiondenied-text' => 'אין לכם הרשאה למחוק ויקי מהחווה',
	'farmer-permissiondenied-text1' => 'אין לכם הרשאות גישה לדף זה',
	'farmer-deleting' => 'אתר הוויקי "$1" נמחק',
	'farmer-delete-confirm' => 'אני מאשר כי ברצוני למחוק את אתר הוויקי הזה',
	'farmer-delete-confirm-wiki' => "אתר ויקי למחיקה: '''$1'''.",
	'farmer-delete-reason' => 'סיבת המחיקה:',
	'farmer-delete-title' => 'מחיקת הוויקי',
	'farmer-delete-text' => 'אנא בחרו מהרשימה שלהלן את הוויקי שברצונכם למחוק',
	'farmer-delete-form' => 'בחירת ויקי',
	'farmer-delete-form-submit' => 'מחיקה',
	'farmer-listofwikis' => 'רשימת אתרי הוויקי',
	'farmer-mainpage' => 'עמוד ראשי',
	'farmer-basic-title' => 'פרמטרים בסיסיים',
	'farmer-basic-title1' => 'כותרת',
	'farmer-basic-title1-text' => 'לוויקי שלכם אין כותרת.  הגדירו אחת <b>כעת</b>',
	'farmer-basic-description' => 'תיאור',
	'farmer-basic-description-text' => 'הגדירו את תיאור הוויקי שלכם להלן',
	'farmer-basic-permission' => 'הרשאות',
	'farmer-basic-permission-text' => 'באמצעות הטופס שלהלן, ניתן לשנות את הרשאות המשתמשים בוויקי זה',
	'farmer-basic-permission-visitor' => 'ההרשאות של כל אורח',
	'farmer-basic-permission-visitor-text' => 'ההרשאות הבאות יחולו על כל אחד המבקר בוויקי זה',
	'farmer-yes' => 'כן',
	'farmer-no' => 'לא',
	'farmer-basic-permission-user' => 'הרשאות למשתמשים רשומים',
	'farmer-basic-permission-user-text' => 'ההרשאות הבאות יחולו על כל משתמש רשום באתר זה',
	'farmer-setpermission' => 'הגדרת הרשאות',
	'farmer-defaultskin' => 'עיצוב ברירת המחדל',
	'farmer-defaultskin-button' => 'הגדרת עיצוב ברירת המחדל',
	'farmer-extensions' => 'הרחבות פעילות',
	'farmer-extensions-button' => 'הגדרת ההרחבות הפעילות',
	'farmer-extensions-extension-denied' => 'אין לכם הרשאות לשנות תכונה זו.
עליכם להיות חברים בקבוצה farmeradmin',
	'farmer-extensions-invalid' => 'הרחבה בלתי תקינה',
	'farmer-extensions-invalid-text' => 'לא ניתן להוסיף את ההרחבה כיוון שהקובץ שנבחר להכללה אינו קיים',
	'farmer-extensions-available' => 'הרחבות אפשריות',
	'farmer-extensions-noavailable' => 'לא נרשמו הרחבות',
	'farmer-extensions-register' => 'רשימת הרחבה',
	'farmer-extensions-register-text1' => 'ניתן להשתמש בטופס שלהלן כדי לרשום הרחבה חדשה בחווה.
לאחר שההרחבה תירשם, כל אתרי הוויקי יוכלו להשתמש בה.',
	'farmer-extensions-register-text2' => "בפרמטר '''קובץ להכללה''', כתבו את שם קובץ ה־PHP כפי שיש לכותבו ב־LocalSettings.php.",
	'farmer-extensions-register-text3' => "אם שם הקובץ מכיל '''\$root''', משתנה זה יוחלף בתיקייה הראשית של מדיה־ויקי.",
	'farmer-extensions-register-text4' => 'נתיבי ההכללה הנוכחיים הינם:',
	'farmer-extensions-register-name' => 'שם',
	'farmer-extensions-register-includefile' => 'קובץ להכללה',
	'farmer-error-exists' => 'לא ניתן ליצור ויקי.  הוויקי כבר קיים: $1',
	'farmer-error-noextwrite' => 'לא ניתן לכתוב קובץ הרחבה:',
	'farmer-log-name' => 'יומן חוות אתרי הוויקי',
	'farmer-log-header' => 'זהו יומן השינויים שנערכו בחוות אתרי הוויקי.',
	'farmer-log-create' => 'יצר את אתר הוויקי "$2"',
	'farmer-log-delete' => 'מחק את אתר הוויקי "$2"',
	'right-farmeradmin' => 'ניהול חוות אתרי הוויקי',
	'right-createwiki' => 'יצירת אתרי וויקי בחוות אתרי הוויקי',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author आलोक
 */
$messages['hi'] = array(
	'farmer' => 'फ़ार्मर',
	'farmer-desc' => 'एक मीडियाविकि फ़ार्म बनायें',
	'farmercantcreatewikis' => 'आप विकि बना नहीं सकते हैं क्योंकी इसके लिये आवश्यक अधिकार आपके पास नहीं हैं',
	'farmercreatesitename' => 'स्थल का नाम',
	'farmercreatenextstep' => 'अगला स्टेप',
	'farmernewwikimainpage' => '== आपके विकिमें स्वागत ==
अगर आप यह पढ पा रहें हैं, तो आपका नया विकि शुरू हो चुका हैं। आपका विकि आपकी पसंदोंके अनुसार बदलने के लिये, कृपया [[Special:Farmer]] यहां जायें।',
	'farmer-about' => 'के बारे में',
	'farmer-about-text' => 'मीडियाविकी का फ़ार्मर आपको मीडियाविकि मैनेज करने के लिये सहायता देता हैं।',
	'farmer-list-wiki' => 'विकियोंकी सूची',
	'farmer-list-wiki-text' => '{{SITENAME}} पर उपलब्ध सभी विकियोंकी [[$1|सूची]]',
	'farmer-createwiki' => 'विकि बनायें',
	'farmer-createwiki-text' => 'अभी एक विकि [[$1|तैयार]] करें!',
	'farmer-administration' => 'फ़ार्म प्रबंधन',
	'farmer-administration-extension' => 'एक्स्टेंशन मैनेज करें',
	'farmer-administration-extension-text' => 'इन्स्टॉल किये हुए एक्स्टेंशन को [[$1|मैनेज]] करें।',
	'farmer-admimistration-listupdate' => 'फ़ार्म सूची अपडेट',
	'farmer-admimistration-listupdate-text' => '{{SITENAME}} पर उपलब्ध विकि सूची [[$1|अपडेट]]',
	'farmer-administration-delete' => 'विकि हटायें',
	'farmer-administration-delete-text' => 'इस फ़ार्मसे एक विकि [[$1|हटायें]]',
	'farmer-administer-thiswiki' => 'इस विकिका प्रबंधन करें',
	'farmer-administer-thiswiki-text' => 'इस विकिमें हुए बदलावोंका [[$1|प्रबंधन]] करें',
	'farmer-notavailable' => 'उपलब्ध नहीं हैं',
	'farmer-notavailable-text' => 'यह फीचर सिर्फ मुख्य विकिपर उपलब्ध हैं',
	'farmer-wikicreated' => 'विकि बना दिया है',
	'farmer-wikicreated-text' => 'आपका विकि बन गया हैं।
वह $1 यहां देखा जा सकता है',
	'farmer-default' => 'आपके अलावा इस विकिपर किसीकोभी कुछभी अधिकार नहीं हैं। आप $1 में जाकर सदस्य अधिकार बदल सकतें हैं',
	'farmer-wikiexists' => 'विकि पहलेसे अस्तित्वमें हैं',
	'farmer-wikiexists-text' => "आप जिसे चाहते हैं वह '''$1''' विकि पहलेसे अस्तित्व में हैं।
कृपया पीछे जाकर दुसरे नाम से कोशीश करें",
	'farmer-confirmsetting' => 'विकि सेटींग निश्चित करें',
	'farmer-confirmsetting-name' => 'नाम',
	'farmer-confirmsetting-title' => 'शीर्षक',
	'farmer-confirmsetting-description' => 'ज़ानकारी',
	'farmer-description' => 'ज़ानकारी',
	'farmer-button-confirm' => 'निश्चित करें',
	'farmer-button-submit' => 'भेजें',
	'farmer-createwiki-form-title' => 'विकि बनायें',
	'farmer-createwiki-form-text1' => 'नया विकि बनाने के लिये नीचे दिये गये फ़ार्म का इस्तेमाल करें।',
	'farmer-createwiki-form-help' => 'सहायता',
	'farmer-createwiki-user' => 'सदस्यनाम',
	'farmer-createwiki-name' => 'विकि नाम',
	'farmer-createwiki-title' => 'विकि शीर्षक',
	'farmer-createwiki-description' => 'ज़ानकारी',
	'farmer-updatedlist' => 'अपडेटेड सूची',
	'farmer-notaccessible' => 'उपलब्ध नहीं',
	'farmer-notaccessible-test' => 'यह फ़ीचर सिर्फ फ़ार्मके मुख्य विकिपर ही उपलब्ध हैं',
	'farmer-permissiondenied' => 'अनुमति नहीं दी',
	'farmer-permissiondenied-text' => 'इस फ़ार्म से विकि हटानेकी आपको अनुमति नहीं हैं',
	'farmer-permissiondenied-text1' => 'यह पन्ना देखनेकी आपको अनुमति नहीं हैं',
	'farmer-deleting' => '$1 को हटा रहें हैं',
	'farmer-delete-title' => 'विकि हटायें',
	'farmer-delete-text' => 'कृपया नीचे की सूचीसे हटाने के लिये विकि चुनें',
	'farmer-delete-form' => 'विकि चुनें',
	'farmer-delete-form-submit' => 'हटायें',
	'farmer-listofwikis' => 'विकि सूची',
	'farmer-mainpage' => 'मुखपृष्ठ',
	'farmer-basic-title' => 'बेसिक पैरेमीटर्स',
	'farmer-basic-title1' => 'शीर्षक',
	'farmer-basic-title1-text' => 'आपके विकिको शीर्षक नहीं दिया हुआ हैं। अभी दें',
	'farmer-basic-description' => 'ज़ानकारी',
	'farmer-basic-description-text' => 'आपके विकिके बारे में ज़ानकारी नीचे दें',
	'farmer-basic-permission' => 'अनुमति',
	'farmer-basic-permission-text' => 'नीचे दिये फ़ार्म का इस्तेमाल करके इस विकिपर सदस्योंको मिलनेवाली अनुमतियाँ बदली जा सकती हैं।',
	'farmer-basic-permission-visitor' => 'सभी भेंट देने वालोंके लिये अनुमति',
	'farmer-basic-permission-visitor-text' => 'नीचे दी हुई अनुमतियाँ सभी भेंट देनेवालोंको दी जायेगी',
	'farmer-yes' => 'हां',
	'farmer-no' => 'नहीं',
	'farmer-basic-permission-user' => 'लॉग इन किये हुए सदस्योंके लिये अनुमति',
	'farmer-basic-permission-user-text' => 'नीचे दी गई अनुमतियाँ विकि पर लॉग इन करने वाले सभी सदस्योंको दी जायेगी',
	'farmer-setpermission' => 'अनुमति दें',
	'farmer-defaultskin' => 'डिफॉल्ट स्कीन',
	'farmer-defaultskin-button' => 'डिफॉल्ट स्कीन चुनें',
	'farmer-extensions' => 'कार्यरत एक्स्टेंशन',
	'farmer-extensions-button' => 'कार्यरत एक्स्टेंशन्स सैट करें',
	'farmer-extensions-extension-denied' => 'आपको यह फ़ीचर इस्तेमाल करने की अनुमति नहीं हैं।
आप फ़ार्मर प्रबंधक ग्रुपमें होना आवश्यक हैं',
	'farmer-extensions-invalid' => 'अवैध एक्स्टेंशन',
	'farmer-extensions-invalid-text' => 'एक्स्टेंशन बढाया नहीं जा सका क्योंकी चुनी हुई फ़ाईल मिली नहीं',
	'farmer-extensions-available' => 'उपलब्ध एक्स्टेंशन्स',
	'farmer-extensions-noavailable' => 'कोईभी एक्स्टेंशन पंजिकृत नहीं हैं',
	'farmer-extensions-register' => 'एक्स्टेंशन पंजिकृत करें',
	'farmer-extensions-register-text2' => "''फ़ाईल मिलायें'' पॅरॅमीटरके लिये PHP फ़ाईल का नाम LocalSettings.php में जैसे दिया था वैसे दिजीयें।",
	'farmer-extensions-register-text3' => "अगर फ़ाईल नाममें '''\$root''' हैं, तो वह मीडियाविकिके मूल डाइरेक्टरीसे बदला जायेगा।",
	'farmer-extensions-register-text4' => 'अभीके इन्क्ल्यूड पाथ इस प्रकार हैं:',
	'farmer-extensions-register-name' => 'नाम',
	'farmer-extensions-register-includefile' => 'फ़ाईल मिलायें',
	'farmer-error-exists' => 'विकि बना नहीं सकते। वह पहले से अस्तित्वमें हैं: $1',
	'farmer-error-noextwrite' => 'एक्स्टेंशन फ़ाईल लिख नहीं पायें:',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'farmer-createwiki-form-help' => 'Bulig',
	'farmer-createwiki-user' => 'Ngalan sang Manog-gamit',
	'farmer-delete-form-submit' => 'Panason',
	'farmer-mainpage' => 'Mayor nga Panid',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'farmer-delete-form-submit' => 'Izbriši',
	'farmer-yes' => 'Da',
	'farmer-no' => 'Ne',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'farmer' => 'Farmar',
	'farmer-desc' => 'Farmu MediaWiki zrjadować',
	'farmercantcreatewikis' => 'Njemóžeš wikije wutworić, dokelž nimaš prawo za wutworjenje wikijow',
	'farmercreatesitename' => 'Mjeno sydła',
	'farmercreatenextstep' => 'Přichodny krok',
	'farmernewwikimainpage' => '== Witaj do twojeho Wikija ==
Jeli to čitaš, je so twój nowy wiki korektnje instalował.
Móžeš [[Special:Farmer|swój wiki přiměrić]].',
	'farmer-about' => 'Wo',
	'farmer-about-text' => 'MediaWiki Farmer ći dowola farmu wikijow MediaWiki zrjadować.',
	'farmer-list-wiki' => 'Lisćina Wikijow',
	'farmer-list-wiki-text' => '[[$1|Nalistuj]] wšě wikije we {{GRAMMAR:Lokatiw|{{SITENAME}}}}',
	'farmer-createwiki' => 'Wiki wutworić',
	'farmer-createwiki-text' => '[[$1|Wutwor]] nětko nowy wiki!',
	'farmer-administration' => 'Farmowa administracija',
	'farmer-administration-extension' => 'Rozšěrjenja zrjadować',
	'farmer-administration-extension-text' => 'Instalowane rozšěrjenja [[$1|zrjadować]]',
	'farmer-admimistration-listupdate' => 'Aktualizacija farmoweje lisćiny',
	'farmer-admimistration-listupdate-text' => '[[$1|Zaktualizuj]] lisćinu wikijow we {{GRAMMAR:Lokatiw|{{SITENAME}}}}',
	'farmer-administration-delete' => 'Wiki wušmórnyć',
	'farmer-administration-delete-text' => 'Wiki z farmy [[$1|wušmórnyć]]',
	'farmer-administer-thiswiki' => 'Tutón wiki administrować',
	'farmer-administer-thiswiki-text' => 'Změny na tutym wikiju [[$1|administrować]]',
	'farmer-notavailable' => 'Nic k dispoziciji',
	'farmer-notavailable-text' => 'Tuta funkcija jenož na hłownym wikiju k dispoziciji steji',
	'farmer-wikicreated' => 'Wiki wutworjeny',
	'farmer-wikicreated-text' => 'Twój wiki je so wutworił. Je pola $1 přistupny',
	'farmer-default' => 'Po standardźe nichtó nimo tebje dowolnosće we tutym wikiju nima. Móžeš wužiwarske prawa  z $1 změnić.',
	'farmer-wikiexists' => 'Wiki eksistuje',
	'farmer-wikiexists-text' => "Wiki, kotryž pospytuješ wutworjeć, '''$1''', hižo eksistuje. Prošu wróć so a spytaj druhe mjeno.",
	'farmer-confirmsetting' => 'Wikijowe nastajenja potwjerdźić',
	'farmer-confirmsetting-name' => 'Mjeno',
	'farmer-confirmsetting-title' => 'Titul',
	'farmer-confirmsetting-description' => 'Wopisanje',
	'farmer-confirmsetting-reason' => 'Přičina',
	'farmer-description' => 'Wopisanje',
	'farmer-confirmsetting-text' => "Twój wiki, '''$1''', budźe přez $3 přistupny być.
Projektowy mjenowy rum budźe '''$2'''.
Wotkazy k tutomu mjenowemu rumej změja formu '''<nowiki>[[$2:Page name]]</nowiki>'''.
Jeli to je to, štož chceš, stłóč deleka tłóčatko '''potwjerdźić'''.",
	'farmer-button-confirm' => 'Potwjerdźić',
	'farmer-button-submit' => 'Wotesłać',
	'farmer-createwiki-form-title' => 'Wiki wutworić',
	'farmer-createwiki-form-text1' => 'Wužij slědowacy formular, zo by nowy wiki wutworił.',
	'farmer-createwiki-form-help' => 'Pomoc',
	'farmer-createwiki-form-text2' => "; Wikijowe mjeno: Mjeno wikija. Wobsahuje jenož pismiki a ličby. Wikijowe mjeno budźe so jako dźěl URL wužiwać, zo by waš wiki identifikowało. Na přikład, jeli zapodaš '''titul''', da budźe twój wiki přez <nowiki>http://</nowiki>'''titul'''.mojadomejna přistupny.",
	'farmer-createwiki-form-text3' => '; Wikijowy titul: Titul wikija. Budźe so wužiwać w titulu kóždeje strony we weašim wikiju. Budźe tež projektowy mjenowy rum a interwikijowy prefiks.',
	'farmer-createwiki-form-text4' => '; Wopisanje: Wopisanje wikija. To je tekstowe wopisanje wo wikiju. Te budźe so we wikijowej lisćinje jewić.',
	'farmer-createwiki-user' => 'Wužiwarske mjeno',
	'farmer-createwiki-name' => 'Mjeno wikija',
	'farmer-createwiki-title' => 'Titul wikija',
	'farmer-createwiki-description' => 'Wopisanje',
	'farmer-createwiki-reason' => 'Přičina',
	'farmer-updatedlist' => 'Zaktualizowana lisćina',
	'farmer-notaccessible' => 'Njepřistupny',
	'farmer-notaccessible-test' => 'Tuta funkcija jenož w nadrjadowanym wikiju we farmje k dispoziciji steji',
	'farmer-permissiondenied' => 'Dowolnosć zapowědźena',
	'farmer-permissiondenied-text' => 'Nimaš dowolnosć, zo by wiki z farmy wušmórnył',
	'farmer-permissiondenied-text1' => 'Nimaš dowolnosć, zo by do tuteje strony zastupił',
	'farmer-deleting' => 'Wiki "$1" je so wušmórnył',
	'farmer-delete-confirm' => 'Haj, chcu tutón wiki zničić',
	'farmer-delete-confirm-wiki' => "Wiki, kotryž ma so zničić: '''$1'''.",
	'farmer-delete-reason' => 'Přičina za zničenje:',
	'farmer-delete-title' => 'Wiki wušmórnyć',
	'farmer-delete-text' => 'Prošu wubjer wiki ze slědowaceje lisćiny, kotryž chceš wušmórnyć',
	'farmer-delete-form' => 'Wiki wubrać',
	'farmer-delete-form-submit' => 'Wušmórnyć',
	'farmer-listofwikis' => 'Lisćina wikijow',
	'farmer-mainpage' => 'Hłowna strona',
	'farmer-basic-title' => 'Zakładne parametry',
	'farmer-basic-title1' => 'Titul',
	'farmer-basic-title1-text' => 'Twój wiki titul nima. Postaj NĚTKO jedyn.',
	'farmer-basic-description' => 'Wopisanje',
	'farmer-basic-description-text' => 'Postaj wopisanje slědowaceho wikija',
	'farmer-basic-permission' => 'Dowolnosće',
	'farmer-basic-permission-text' => 'Z pomocu slědowaceho formulara móžeš prawa za wužiwarjow tutoho wikija změnić.',
	'farmer-basic-permission-visitor' => 'Prawa za kóždeho wopytowarja',
	'farmer-basic-permission-visitor-text' => 'Slědowace dowolnosće nałožuja so na kóždu wosobu, kotraž tutón wiki wopytuje.',
	'farmer-yes' => 'Haj',
	'farmer-no' => 'Ně',
	'farmer-basic-permission-user' => 'Prawa za přizjewjenych wužiwarjow',
	'farmer-basic-permission-user-text' => 'Slědowace prawa budu so na kóždu wosobu nałožować, kotraž je so pola tutoho wikija přizjewiła.',
	'farmer-setpermission' => 'Prawa postajić',
	'farmer-defaultskin' => 'Standardny šat',
	'farmer-defaultskin-button' => 'Standardny šat nastajić',
	'farmer-extensions' => 'Aktiwne rozšěrjenja',
	'farmer-extensions-button' => 'Aktiwne rozšěrjenja nastajić',
	'farmer-extensions-extension-denied' => 'Nimaš dowolnosć, zo by tutu funkciju wužiwał. Dyrbiš čłon skupiny administratorow Farmera.',
	'farmer-extensions-invalid' => 'Njepłaćiwe rozšěrjenje',
	'farmer-extensions-invalid-text' => 'Njemóžachmy rozšěrjenje přidać, dokelž dataja, kotraž bu za zapřijeće wubrana, njebu namakana.',
	'farmer-extensions-available' => 'K dispoziciji stejace rozšěrjenja',
	'farmer-extensions-noavailable' => 'Njejsu žane rozšěrjenja zregistrowane',
	'farmer-extensions-register' => 'Rozšěrjenje registrować',
	'farmer-extensions-register-text1' => 'Wužij slědowacy formular, zo by nowe rozšěrjenje pola farmy registrował. Tak ruče kaž rozšěrjenje je so zregistrowało, móža wšě wikije je wužiwać.',
	'farmer-extensions-register-text2' => "Zapodaj za parameter ''Dataju zapřijeć'' mjeno dataje PHP tak, kaž by to w dataji LocalSettings.php činił.",
	'farmer-extensions-register-text3' => "Jeli datajowe mjeno '''\$root''' wobsahuje, budźe so tuta wariabla přez korjenjowy zapis narunować.",
	'farmer-extensions-register-text4' => 'Tuchwilne puće za zapřijimanje su:',
	'farmer-extensions-register-name' => 'Mjeno',
	'farmer-extensions-register-includefile' => 'Dataju zapřijeć',
	'farmer-error-exists' => 'Wiki njeda so wutowrić. Eksistuje hižo: $1',
	'farmer-error-noextwrite' => 'Rozšěrjenska dataja njeda so wupisać:',
	'farmer-log-name' => 'Protokol wikijoweho farma',
	'farmer-log-header' => 'To je protokol změnow, kotrež su so na wikijowym farmje činili.',
	'farmer-log-create' => 'je wiki "$2" załožił',
	'farmer-log-delete' => 'je wiki "$2" zničił',
	'right-farmeradmin' => 'Wikijowu formu zrjadować',
	'right-createwiki' => 'Wikije we wikijowej farmje wutworić',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'MediaWiki farm beállítása',
	'farmercantcreatewikis' => 'Nem készíthetsz wikiket, mert nincsenek wikikészítői jogaid',
	'farmercreatesitename' => 'Oldal neve',
	'farmercreatenextstep' => 'Következő lépés',
	'farmernewwikimainpage' => '==Üdvözlünk a wikidben==
Ha ezt olvasod, akkor az új wikid helyesen lett feltelepítve.
A wiki testreszabásához látogasd meg a [[Special:Farmer]] lapot.',
	'farmer-about' => 'Célja',
	'farmer-about-text' => 'A MediaWiki Farmer lehetővé teszi számodra MediaWiki wikik farmjának kezelését.',
	'farmer-list-wiki' => 'Wikik listája',
	'farmer-list-wiki-text' => '{{SITENAME}} összes wikijének [[$1|listája]]',
	'farmer-createwiki' => 'Wiki létrehozása',
	'farmer-createwiki-text' => 'Új wiki [[$1|készítése]] most!',
	'farmer-administration' => 'Farm adminisztráció',
	'farmer-administration-extension' => 'Kiterjesztések kezelése',
	'farmer-administration-extension-text' => 'Telepített kiterjesztések [[$1|kezelése]].',
	'farmer-admimistration-listupdate' => 'Wikik listájának frissítése',
	'farmer-admimistration-listupdate-text' => '{{SITENAME}}-wikik listájának [[$1|frissítése]]',
	'farmer-administration-delete' => 'Wiki törlése',
	'farmer-administration-delete-text' => 'Wiki [[$1|törlése]] a farmról',
	'farmer-administer-thiswiki' => 'Wiki adminisztrálása',
	'farmer-administer-thiswiki-text' => 'Változtatások [[$1|végzése]] a wikin',
	'farmer-notavailable' => 'Nem elérhető',
	'farmer-notavailable-text' => 'Ez a funkció csak a főwikiből érhető el',
	'farmer-wikicreated' => 'Wiki elkészítve',
	'farmer-wikicreated-text' => 'A wikid elkészült.  Elérhető $1 címen',
	'farmer-default' => 'Alapértelmezésként rajtad kívül senkinek nincsenek jogai a wikin. A $1 lapon keresztük változtathatod meg a felhasználói jogokat.',
	'farmer-wikiexists' => 'Wiki már létezik',
	'farmer-wikiexists-text' => "A wiki, amelyet megpróbáltál elkészíteni, '''$1''', már létezik.  Menj vissza, és próbálj meg egy másik nevet.",
	'farmer-confirmsetting' => 'Beállítások megerősítése',
	'farmer-confirmsetting-name' => 'Név',
	'farmer-confirmsetting-title' => 'Cím',
	'farmer-confirmsetting-description' => 'Leírás',
	'farmer-confirmsetting-reason' => 'Indoklás',
	'farmer-description' => 'Leírás',
	'farmer-confirmsetting-text' => "A wikid, '''$1''', elérhető a $3 címen.
A projektnévtér '''$2''' lesz.
Az erre a névtérre hivatkozó linkek formája '''<nowiki>[[$2:Page Name]]</nowiki>''' lesz.
Ha ez az, amit szeretnél, akkor kattints a '''megerősítés''' gombra.",
	'farmer-button-confirm' => 'Megerősítés',
	'farmer-button-submit' => 'Elküldés',
	'farmer-createwiki-form-title' => 'Wiki létrehozása',
	'farmer-createwiki-form-text1' => 'Az alábbi űrlap segítségével új wikit hozhatsz létre.',
	'farmer-createwiki-form-help' => 'Segítség',
	'farmer-createwiki-form-text2' => "; Wiki neve: A wiki leendő neve.  Csak betűek és számokat tartalmazhat.  A wiki nevét azonosításra használjuk az URL részeként.  Például ha a '''nev''' szöveget adod meg, akkor a wikid a <nowiki>http://</nowiki>'''nev'''.mydomain címről lesz elérhető.",
	'farmer-createwiki-form-text3' => '; Wiki címe: A wiki leendő címe.  Ez lesz a címe minden oldalnak a wikin, a projektnévtér és az interwiki előtag.',
	'farmer-createwiki-form-text4' => '; Leírás: A wiki leírása.  Ez egy szöveges leírás a wikiről.  A wikilistában fog megjelenni.',
	'farmer-createwiki-user' => 'Felhasználói név',
	'farmer-createwiki-name' => 'Wiki neve',
	'farmer-createwiki-title' => 'Wiki címe',
	'farmer-createwiki-description' => 'Leírás',
	'farmer-createwiki-reason' => 'Indoklás',
	'farmer-updatedlist' => 'Frissített lista',
	'farmer-notaccessible' => 'Nem elérhető',
	'farmer-notaccessible-test' => 'Ez a funkció csak a farm szülőwikijéből érhető el',
	'farmer-permissiondenied' => 'Engedély megtagadva',
	'farmer-permissiondenied-text' => 'Nincsen jogod wikit törölni a farmról',
	'farmer-permissiondenied-text1' => 'Nincs jogod az oldal megtekintéséhez',
	'farmer-deleting' => 'A(z) „$1” wiki törölve',
	'farmer-delete-confirm' => 'Megerősítem, hogy szeretném törölni ezt a wikit',
	'farmer-delete-confirm-wiki' => "Törlendő wiki: '''$1'''.",
	'farmer-delete-reason' => 'A törlés oka:',
	'farmer-delete-title' => 'Wiki törlése',
	'farmer-delete-text' => 'Válaszd ki a listából azt a wikit, amelyet törölni szeretnél',
	'farmer-delete-form' => 'Wiki kiválasztása',
	'farmer-delete-form-submit' => 'Törlés',
	'farmer-listofwikis' => 'Wikik listája',
	'farmer-mainpage' => 'Kezdőlap',
	'farmer-basic-title' => 'Alapparaméterek',
	'farmer-basic-title1' => 'Cím',
	'farmer-basic-title1-text' => 'A wikidnek nincs címe.  Adj meg egyet MOST',
	'farmer-basic-description' => 'Leírás',
	'farmer-basic-description-text' => 'Add meg a wikid leírását lent',
	'farmer-basic-permission' => 'Jogok',
	'farmer-basic-permission-text' => 'Az alábbi űrlap használatával beállíthatod a wiki felhasználóinak jogait.',
	'farmer-basic-permission-visitor' => 'Minden látogató jogai',
	'farmer-basic-permission-visitor-text' => 'A következő jogok fognak vonatkozni a wiki összes látogatójára',
	'farmer-yes' => 'Igen',
	'farmer-no' => 'Nem',
	'farmer-basic-permission-user' => 'Bejelentkezett felhasználók jogai',
	'farmer-basic-permission-user-text' => 'Az alábbi jogok fognak vonatkozni a wikire bejelentkező összes személyre',
	'farmer-setpermission' => 'Jogok beállítása',
	'farmer-defaultskin' => 'Alapértelmezett felület',
	'farmer-defaultskin-button' => 'Alapértelmezett felület beállítása',
	'farmer-extensions' => 'Aktív kiterjesztések',
	'farmer-extensions-button' => 'Aktív kiterjesztések beállítása',
	'farmer-extensions-extension-denied' => 'Nincs jogod a funkció használatára.  A farmeradminok csoportjába kell tartoznod.',
	'farmer-extensions-invalid' => 'Érvénytelen kiterjesztés',
	'farmer-extensions-invalid-text' => 'Nem tudtam hozzáadni a kiterjesztést, mert a beillesztésre kiválaszott fájl nem található',
	'farmer-extensions-available' => 'Elérhető kiterjesztések',
	'farmer-extensions-noavailable' => 'Nincsenek kiterjesztések regisztrálva',
	'farmer-extensions-register' => 'Kiterjesztés regisztrálása',
	'farmer-extensions-register-text1' => 'Az alábbi űrlap használatával új kiterjesztést regisztrálhatsz a farmra.  Miután egy kiterjesztést regisztráltál, minden wikin használható lesz.',
	'farmer-extensions-register-text2' => "A ''beillesztett fájl'' paraméterhez add meg annak a PHP fájlnak a nevét, amelyet beraknál a LocalSettings.php-be.",
	'farmer-extensions-register-text3' => "Ha a fájlnév tartalmazza a '''\$root''' paramétert, akkor az le lesz cserélve a MediaWiki gyökérkönyvtárára.",
	'farmer-extensions-register-text4' => 'A jelenleg figyelembe vett könyvtárak:',
	'farmer-extensions-register-name' => 'Név',
	'farmer-extensions-register-includefile' => 'Beillesztett fájl',
	'farmer-error-exists' => 'A wiki nem hozható létre.  Már létezik: $1',
	'farmer-error-noextwrite' => 'Nem sikerült írni a kiterjesztés fájlába:',
	'farmer-log-name' => 'Wikifarm napló',
	'farmer-log-header' => 'Ez a wikifarmon történt változások naplója.',
	'farmer-log-create' => '„$2” wiki létrehozva',
	'farmer-log-delete' => '„$2” wiki törölve',
	'right-farmeradmin' => 'Wiki farm kezelése',
	'right-createwiki' => 'wikik létrehozása a wikifarmon',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'farmer' => 'Fermero',
	'farmer-desc' => 'Gerer un ferma MediaWiki',
	'farmercantcreatewikis' => 'Tu non pote crear wikis proque tu non ha le privilegio "createwikis"',
	'farmercreatesitename' => 'Nomine del sito',
	'farmercreatenextstep' => 'Proxime passo',
	'farmernewwikimainpage' => '== Benvenite a tu wiki ==
Si tu lege isto, tu nove wiki ha essite installate correctemente.
Tu pote [[Special:Farmer|personalisar tu wiki]].',
	'farmer-about' => 'A proposito',
	'farmer-about-text' => 'Le extension MediaWiki Farmer te permitte gerer un "ferma" de wikis MediaWiki.',
	'farmer-list-wiki' => 'Lista de wikis',
	'farmer-list-wiki-text' => '[[$1|Lista]] de tote le wikis in {{SITENAME}}',
	'farmer-createwiki' => 'Crear un wiki',
	'farmer-createwiki-text' => '[[$1|Crear]] un nove wiki ora!',
	'farmer-administration' => 'Administration del ferma',
	'farmer-administration-extension' => 'Gerer extensiones',
	'farmer-administration-extension-text' => '[[$1|Gerer]] le extensiones installate.',
	'farmer-admimistration-listupdate' => 'Actusliation del lista de fermas',
	'farmer-admimistration-listupdate-text' => '[[$1|Actualisar]] le lista de wikis in {{SITENAME}}',
	'farmer-administration-delete' => 'Deler un wiki',
	'farmer-administration-delete-text' => '[[$1|Deler]] un wiki del ferma',
	'farmer-administer-thiswiki' => 'Administrar iste wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administrar]] cambios in iste wiki',
	'farmer-notavailable' => 'Non disponibile',
	'farmer-notavailable-text' => 'Iste function es solmente disponibile in le wiki principal',
	'farmer-wikicreated' => 'Wiki create',
	'farmer-wikicreated-text' => 'Tu wiki ha essite create.
Illo es accessibile a $1',
	'farmer-default' => 'Per predefinition, necuno ha permissiones in iste wiki a exception de te.
Tu pote cambiar le privilegios del usatores via $1',
	'farmer-wikiexists' => 'Le wiki existe',
	'farmer-wikiexists-text' => "Le wiki que tu tenta crear, '''$1''', existe ja.
Per favor retorna e prova un altere nomine.",
	'farmer-confirmsetting' => 'Confirmar configurationes del wiki',
	'farmer-confirmsetting-name' => 'Nomine',
	'farmer-confirmsetting-title' => 'Titulo',
	'farmer-confirmsetting-description' => 'Description',
	'farmer-confirmsetting-reason' => 'Motivo',
	'farmer-description' => 'Description',
	'farmer-confirmsetting-text' => "Tu wiki, '''$1''', essera accessibile via $3.
Le spatio de nomines del projecto essera '''$2'''.
Omne ligamines verso iste spatio de nomines habera le forma '''<nowiki>[[$2:Nomine de pagina]]</nowiki>'''.
Si isto es lo que tu vole, preme le button '''confirmar''' infra.",
	'farmer-button-confirm' => 'Confirmar',
	'farmer-button-submit' => 'Submitter',
	'farmer-createwiki-form-title' => 'Crear un wiki',
	'farmer-createwiki-form-text1' => 'Usa le formulario infra pro crear un nove wiki.',
	'farmer-createwiki-form-help' => 'Adjuta',
	'farmer-createwiki-form-text2' => "; Nomine del wiki: Le nomine del wiki.
Contine solmente litteras e numeros.
Le nomine del wiki facera parte del adresse URL pro identificar tu wiki.
Per exemplo, si tu entra '''titulo''', alora tu wiki essera accessibile via <nowiki>http://</nowiki>'''titulo'''.midominio.",
	'farmer-createwiki-form-text3' => '; Titulo del wiki: Le titulo del wiki.
Essera usate in le titulo de cata pagina in tu wiki.
Essera etiam le spatio de nomines e prefixo interwiki del projecto.',
	'farmer-createwiki-form-text4' => '; Description: Le description del wiki.
Isto es un texto explicative super le wiki,
pro figurar in le lista de wikis.',
	'farmer-createwiki-user' => 'Nomine de usator',
	'farmer-createwiki-name' => 'Nomine del wiki',
	'farmer-createwiki-title' => 'Titulo del wiki',
	'farmer-createwiki-description' => 'Description',
	'farmer-createwiki-reason' => 'Motivo',
	'farmer-updatedlist' => 'Lista actualisate',
	'farmer-notaccessible' => 'Non accessibile',
	'farmer-notaccessible-test' => 'Iste function es solmente disponibile in le wiki principal del ferma',
	'farmer-permissiondenied' => 'Permission refusate',
	'farmer-permissiondenied-text' => 'Tu non ha le permission de deler un wiki del ferma',
	'farmer-permissiondenied-text1' => 'Tu non ha le permission de acceder a iste pagina',
	'farmer-deleting' => 'Le wiki "$1" ha essite delite',
	'farmer-delete-confirm' => 'Io confirma que io vole deler iste wiki',
	'farmer-delete-confirm-wiki' => "Wiki a deler: '''$1'''.",
	'farmer-delete-reason' => 'Motivo del deletion:',
	'farmer-delete-title' => 'Deler wiki',
	'farmer-delete-text' => 'Per favor selige le wiki que tu vole deler del lista infra',
	'farmer-delete-form' => 'Selige un wiki',
	'farmer-delete-form-submit' => 'Deler',
	'farmer-listofwikis' => 'Lista de wikis',
	'farmer-mainpage' => 'Pagina principal',
	'farmer-basic-title' => 'Parametros de base',
	'farmer-basic-title1' => 'Titulo',
	'farmer-basic-title1-text' => 'Tu wiki non ha un titulo. Defini un titulo <b>ora</b>',
	'farmer-basic-description' => 'Description',
	'farmer-basic-description-text' => 'Defini a basso le description de tu wiki',
	'farmer-basic-permission' => 'Permissiones',
	'farmer-basic-permission-text' => 'Con le formulario infra, es possibile alterar permissiones pro usatores de iste wiki.',
	'farmer-basic-permission-visitor' => 'Permissiones pro omne visitator',
	'farmer-basic-permission-visitor-text' => 'Le sequente permissiones se applicara a omne persona qui visita iste wiki',
	'farmer-yes' => 'Si',
	'farmer-no' => 'No',
	'farmer-basic-permission-user' => 'Permissiones pro usatores authenticate',
	'farmer-basic-permission-user-text' => 'Le sequente permissiones se applicara a omne persona qui ha aperite un session in iste wiki',
	'farmer-setpermission' => 'Definir permissiones',
	'farmer-defaultskin' => 'Stilo predefinite',
	'farmer-defaultskin-button' => 'Predefinir un stilo',
	'farmer-extensions' => 'Extensiones active',
	'farmer-extensions-button' => 'Definir extensiones active',
	'farmer-extensions-extension-denied' => 'Tu non ha le permission de usar iste function.
Tu debe esser un membro del gruppo "farmeradmin"',
	'farmer-extensions-invalid' => 'Extension invalide',
	'farmer-extensions-invalid-text' => 'Nos non poteva adder le extension proque le file seligite pro inclusion non poteva esser trovate',
	'farmer-extensions-available' => 'Extensiones disponibile',
	'farmer-extensions-noavailable' => 'Nulle extension es registrate',
	'farmer-extensions-register' => 'Registrar extension',
	'farmer-extensions-register-text1' => 'Usa le formulario infra pro registrar un nove extension in le ferma.
Quando un extension es registrate, tote le wikis potera usar lo.',
	'farmer-extensions-register-text2' => "Pro le parametro ''Includer file'', entra le nomine del file PHP como tu lo facerea in le file LocalSettings.php.",
	'farmer-extensions-register-text3' => "Si le nomine del file contine '''\$root''', ille variable se reimplaciara per le directorio radice de MediaWiki.",
	'farmer-extensions-register-text4' => 'Le camminos de inclusion actual es:',
	'farmer-extensions-register-name' => 'Nomine',
	'farmer-extensions-register-includefile' => 'File de inclusion',
	'farmer-error-exists' => 'Non pote crear wiki. Illo existe ja: $1',
	'farmer-error-noextwrite' => 'Impossibile scriber al file de extension:',
	'farmer-log-name' => 'Registro del ferma wiki',
	'farmer-log-header' => 'Isto es un registro de modificationes facite al ferma de wikis.',
	'farmer-log-create' => 'creava le wiki "$2"',
	'farmer-log-delete' => 'deleva le wiki "$2"',
	'right-farmeradmin' => 'Gerer le ferma de wikis',
	'right-createwiki' => 'Crear wikis in le ferma de wikis',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Kelola sebuah farm MediaWiki',
	'farmercantcreatewikis' => 'Anda tidak bisa membuat wiki karena Anda tidak memiliki izin createwikis',
	'farmercreatesitename' => 'Nama situs',
	'farmercreatenextstep' => 'Tahap selanjutnya',
	'farmernewwikimainpage' => '== Selamat datang di wiki anda ==
Jika anda membaca ini, wiki baru anda telah di pasang dengan benar.
Anda dapat melakukan [[Special:Farmer|penyesuaian wiki anda]].',
	'farmer-about' => 'Tentang',
	'farmer-about-text' => 'MediaWiki Farmer mengijinkan anda untuk mengatur ternak wiki dari MediaWiki.',
	'farmer-list-wiki' => 'Daftar wiki',
	'farmer-list-wiki-text' => '[[$1|Daftar]] semua wiki pada {{SITENAME}}',
	'farmer-createwiki' => 'Buat wiki',
	'farmer-createwiki-text' => '[[$1|Buat]] wiki baru sekarang!',
	'farmer-administration' => 'Administrasi farm',
	'farmer-administration-extension' => 'Pengaturan ekstensi',
	'farmer-administration-extension-text' => '[[$1|Kelola]] ekstensi yang dipasang.',
	'farmer-admimistration-listupdate' => 'Pembaruan daftar farm',
	'farmer-admimistration-listupdate-text' => '[[$1|Perbarui]] daftar wiki di {{SITENAME}}',
	'farmer-administration-delete' => 'Hapus wiki',
	'farmer-administration-delete-text' => '[[$1|Hapus]] wiki dari farm',
	'farmer-administer-thiswiki' => 'Urus wiki ini',
	'farmer-administer-thiswiki-text' => '[[$1|Kelola]] perubahan terhadap wiki ini',
	'farmer-notavailable' => 'Tidak tersedia',
	'farmer-notavailable-text' => 'Fitur ini hanya tersedia di wiki utama',
	'farmer-wikicreated' => 'Wiki dibuat',
	'farmer-wikicreated-text' => 'Wiki Anda telah dibuat.
Dapat diakses di $1',
	'farmer-default' => 'Biasanya, tak seorang pun memiliki izin di wiki ini kecuali Anda.
Anda dapat mengubah izin pengguna melalui $1',
	'farmer-wikiexists' => 'Wiki sudah ada',
	'farmer-wikiexists-text' => 'Wiki yang akan Anda buat, "$1", sudah ada.
Silakan kembali dan coba nama yang lain.',
	'farmer-confirmsetting' => 'Konfirmasi pengaturan wiki',
	'farmer-confirmsetting-name' => 'Nama',
	'farmer-confirmsetting-title' => 'Judul',
	'farmer-confirmsetting-description' => 'Keterangan',
	'farmer-confirmsetting-reason' => 'Alasan',
	'farmer-description' => 'Keterangan',
	'farmer-confirmsetting-text' => "Wiki Anda, '''$1''', akan dapat diakses melalui $3.
Ruang nama proyek adalah '''$2'''.
pranala ke ruang nama ini akan berupa '''<nowiki>[[$2:Nama halaman]]</nowiki>'''.
Bila ini yang Anda inginkan, tekan tombol '''konfirmasi''' di bawah.",
	'farmer-button-confirm' => 'Konfirmasi',
	'farmer-button-submit' => 'Kirim',
	'farmer-createwiki-form-title' => 'Buat wiki',
	'farmer-createwiki-form-text1' => 'Gunakan formulir di bawah untuk membuat wiki baru.',
	'farmer-createwiki-form-help' => 'Bantuan',
	'farmer-createwiki-form-text2' => "; Nama wiki: Nama wiki.
Hanya berisi huruf dan angka.
Nama wiki akan digunakan sebagai bagian dair URL untuk mengidentifikasi wiki Anda.
Contohnya, bila Anda memasukkan \"judul\", maka wiki Anda dapat diakses melalui <nowiki>http://</nowiki>'''judul'''.domainku.",
	'farmer-createwiki-form-text3' => '; Judul wiki: Judul wiki.
Akan digunakan di judul setiap halaman di wiki Anda.
Juga akan menjadi ruang nama proyek dan prefiks interwiki.',
	'farmer-createwiki-form-text4' => '; Deskripsi: Deskripsi wiki.
Ini adalah teks deskripsi tentang wiki.
Ini akan ditampilkan di daftar wiki.',
	'farmer-createwiki-user' => 'Nama pengguna',
	'farmer-createwiki-name' => 'Nama wiki',
	'farmer-createwiki-title' => 'Judul wiki',
	'farmer-createwiki-description' => 'Keterangan',
	'farmer-createwiki-reason' => 'Alasan',
	'farmer-updatedlist' => 'Perbaharui daftar',
	'farmer-notaccessible' => 'Tidak dapat diakses',
	'farmer-notaccessible-test' => 'Fitur ini hanya tersedia di wiki induk di farm',
	'farmer-permissiondenied' => 'Izin ditolak',
	'farmer-permissiondenied-text' => 'Anda tidak memiliki izin untuk menghapus wiki dari farm',
	'farmer-permissiondenied-text1' => 'Anda tidak punya izin untuk mengakses halaman ini',
	'farmer-deleting' => 'Wiki "$1" telah dihapus',
	'farmer-delete-confirm' => 'Saya mengkonfirmasi bahwa saya ingin menghapus wiki ini',
	'farmer-delete-confirm-wiki' => "Wiki untuk dihapus: '''$1'''.",
	'farmer-delete-reason' => 'Alasan penghapusan:',
	'farmer-delete-title' => 'Hapus wiki',
	'farmer-delete-text' => 'Pilih wiki dari daftar di bawah yang ingin Anda hapus',
	'farmer-delete-form' => 'Pilih wiki',
	'farmer-delete-form-submit' => 'Hapus',
	'farmer-listofwikis' => 'Daftar wiki',
	'farmer-mainpage' => 'Halaman Utama',
	'farmer-basic-title' => 'Parameter dasar',
	'farmer-basic-title1' => 'Judul',
	'farmer-basic-title1-text' => 'Wiki Anda tak memiliki judul. Buat satu <b>sekarang</b>',
	'farmer-basic-description' => 'Keterangan',
	'farmer-basic-description-text' => 'Buat deskripsi wiki Anda di bawah',
	'farmer-basic-permission' => 'Hak',
	'farmer-basic-permission-text' => 'Gunakan formulir di bawah, bisa untuk mengubah izin pengguna wiki ini.',
	'farmer-basic-permission-visitor' => 'Izin untuk setiap pengunjung',
	'farmer-basic-permission-visitor-text' => 'Izin berikut akan diberlakukan pada setiap orang yang mengunjungi wiki ini',
	'farmer-yes' => 'Ya',
	'farmer-no' => 'Tidak',
	'farmer-basic-permission-user' => 'Izin untuk pengguna yang masuk log',
	'farmer-basic-permission-user-text' => 'Izin berikut akan diberlakukan pada setiap orang yang masuk log ke wiki ini',
	'farmer-setpermission' => 'Atur izin',
	'farmer-defaultskin' => 'Kulit baku',
	'farmer-defaultskin-button' => 'Buat kulit baku',
	'farmer-extensions' => 'Ekstensi aktif',
	'farmer-extensions-button' => 'Atur ekstensi aktif',
	'farmer-extensions-extension-denied' => 'Anda tidak memiliki izin untuk menggunakan fitur ini.
Anda harus menjadi anggota grup farmeradmin',
	'farmer-extensions-invalid' => 'Ekstensi salah',
	'farmer-extensions-invalid-text' => 'Kami tidak dapat menambahkan ekstensi karena berkas yang dipilih untuk dimasukkan tidak ditemukan',
	'farmer-extensions-available' => 'Ekstensi yang tersedia',
	'farmer-extensions-noavailable' => 'Tidak ada ekstensi yang didaftarkan',
	'farmer-extensions-register' => 'Daftarkan ekstensi',
	'farmer-extensions-register-text1' => 'Gunakan formulir di bawah untuk mendaftarkan ekstensi baru dengan farm.
Setelah ekstensi tersebut terdaftar, semua wiki dapat menggunakannya.',
	'farmer-extensions-register-text2' => 'Untuk parameter "Masukkan berkas", masukkan nama berkas PHP seperti di LocalSettings.php.',
	'farmer-extensions-register-text3' => "Bila nama berkas berisi '''\$root''', variabel tersebut akan digantikan dengan direktori root MediaWiki.",
	'farmer-extensions-register-text4' => 'Jalur masuk terbaru adalah:',
	'farmer-extensions-register-name' => 'Nama',
	'farmer-extensions-register-includefile' => 'Termasuk berkas',
	'farmer-error-exists' => 'Tidak dapat membuat wiki. telah ada : $1',
	'farmer-error-noextwrite' => 'Tidak bisa menghapus berkas ekstensi:',
	'farmer-log-name' => 'Log farm wiki',
	'farmer-log-header' => 'Ini adalah log perubahan yang dibuat di farm wiki.',
	'farmer-log-create' => 'buat wiki "$2"',
	'farmer-log-delete' => 'hapus wiki "$2"',
	'right-farmeradmin' => 'Kelola farm wiki',
	'right-createwiki' => 'Buat wiki di farm wiki',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'farmer-about' => 'Abwátà',
	'farmer-confirmsetting-reason' => 'Mgbaghaputa',
	'farmer-createwiki-reason' => 'Mgbaghaputa',
	'farmer-delete-form-submit' => 'Kàcha',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'farmer-confirmsetting-title' => 'Titulo',
	'farmer-basic-title1' => 'Titulo',
	'farmer-yes' => 'Yes',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'farmer-confirmsetting-name' => 'Nafn',
	'farmer-createwiki-user' => 'Notandanafn',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'farmer' => 'Fattore',
	'farmer-desc' => 'Gestisce una fattoria MediaWiki',
	'farmercantcreatewikis' => "Non puoi creare wiki perché non possiedi i privilegi ''createwikis''",
	'farmercreatesitename' => 'Nome sito',
	'farmercreatenextstep' => 'Passo successivo',
	'farmernewwikimainpage' => '== Benvenuto nella tua nuova wiki ==
Se stai leggendo questo messaggio, la tua wiki è stata installata correttamente.
Puoi [[Special:Farm|personalizzare la tua wiki]].',
	'farmer-about' => 'Informazioni',
	'farmer-about-text' => 'MediaWiki Farmer ti consente di gestire una fattoria di wiki MediaWiki.',
	'farmer-list-wiki' => 'Elenco di wiki',
	'farmer-list-wiki-text' => '[[$1|Elenca]] tutte le wiki su {{SITENAME}}',
	'farmer-createwiki' => 'Crea una wiki',
	'farmer-createwiki-text' => '[[$1|Crea]] una nuova wiki ora!',
	'farmer-administration' => 'Amministrazione della fattoria',
	'farmer-administration-extension' => 'Gestisci estensioni',
	'farmer-administration-extension-text' => '[[$1|Gestisci]] estensioni installate.',
	'farmer-admimistration-listupdate' => 'Aggiornamento della lista della fattoria',
	'farmer-admimistration-listupdate-text' => "[[$1|Aggiorna]] l'elenco delle wiki su {{SITENAME}}",
	'farmer-administration-delete' => 'Cancella una wiki',
	'farmer-administration-delete-text' => '[[$1|Elimina]] una wiki dalla fattoria',
	'farmer-administer-thiswiki' => 'Amministra questa wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Amministra]] i cambiamenti a questa wiki',
	'farmer-notavailable' => 'Non disponibile',
	'farmer-notavailable-text' => 'Questa caratteristica è disponibile solo sulla wiki principale',
	'farmer-wikicreated' => 'Wiki creata',
	'farmer-wikicreated-text' => 'La tua wiki è stata creata.
È accessibile a $1',
	'farmer-default' => 'Per default, nessuno ha permessi su questa wiki eccetto te.
Puoi cambiare i privilegi degli utenti attraverso $1',
	'farmer-wikiexists' => 'La wiki esiste',
	'farmer-wikiexists-text' => "La wiki che stai provando a creare, '''$1''', esiste già.
Torna indietro e prova a inserire un altro nome.",
	'farmer-confirmsetting' => 'Conferma le impostazioni della wiki',
	'farmer-confirmsetting-name' => 'Nome',
	'farmer-confirmsetting-title' => 'Titolo',
	'farmer-confirmsetting-description' => 'Descrizione',
	'farmer-confirmsetting-reason' => 'Motivo',
	'farmer-description' => 'Descrizione',
	'farmer-confirmsetting-text' => "La tua wiki, '''$1''', sarà accessibile attraverso $3.
Il namespace progetto sarà '''$2'''.
I collegamenti a questo namespace saranno del tipo '''<nowiki>[[$2:Page name]]</nowiki>'''.
Se è questo quello che vuoi, premi il pulstante '''conferma''' di seguito.",
	'farmer-button-confirm' => 'Conferma',
	'farmer-button-submit' => 'Invia',
	'farmer-createwiki-form-title' => 'Crea una wiki',
	'farmer-createwiki-form-text1' => 'Usa il modulo di seguito per creare una nuova wiki.',
	'farmer-createwiki-form-help' => 'Aiuto',
	'farmer-createwiki-form-text2' => "; Nome wiki: Il nome della wiki
Contiene solo lettere e numeri.
Il nome della wiki sarà usato come parte dell'URL per identificare la tua wiki.
Per esempio, se inserisci '''titolo''', allora la tua wiki sarà accessibile attraverso <nowiki>http://</nowiki>'''titolo'''.miodominio.",
	'farmer-createwiki-form-text3' => '; Titolo wiki: Titolo della wiki.
Sarà usato nel titolo di ogni pagina della tua wiki.
Sarà anche il nome del namespace progetto e dei prefissi degli interwiki.',
	'farmer-createwiki-form-text4' => "; Descrizione: Descrizione della wiki.
Questa è una descrizione della wiki.
Sarà mostrato nell'elenco delle wiki.",
	'farmer-createwiki-user' => 'Nome utente',
	'farmer-createwiki-name' => 'Nome wiki',
	'farmer-createwiki-title' => 'Titolo wiki',
	'farmer-createwiki-description' => 'Descrizione',
	'farmer-createwiki-reason' => 'Motivo',
	'farmer-updatedlist' => 'Elenco aggiornato',
	'farmer-notaccessible' => 'Non accessibile',
	'farmer-notaccessible-test' => 'Questa funzione è disponibile solo per la wiki genitore nella fattoria',
	'farmer-permissiondenied' => 'Permesso negato',
	'farmer-permissiondenied-text' => 'Non hai il permesso di eliminare una wiki dalla fattoria',
	'farmer-permissiondenied-text1' => 'Non hai il permesso di accedere a questa pagina',
	'farmer-deleting' => 'Il sito "$1" è stato cancellato',
	'farmer-delete-confirm' => 'Confermo di voler cancellare questo sito wiki',
	'farmer-delete-confirm-wiki' => "Sito wiki da cancellare: '''$1'''.",
	'farmer-delete-reason' => 'Motivo per la cancellazione:',
	'farmer-delete-title' => 'Cancella wiki',
	'farmer-delete-text' => "Seleziona nell'elenco la wiki che desideri cancellare",
	'farmer-delete-form' => 'Seleziona una wiki',
	'farmer-delete-form-submit' => 'Cancella',
	'farmer-listofwikis' => 'Elenco di wiki',
	'farmer-mainpage' => 'Pagina principale',
	'farmer-basic-title' => 'Parametri base',
	'farmer-basic-title1' => 'Titolo',
	'farmer-basic-title1-text' => 'La tua wiki non ha un titolo. Impostane uno <b>ora</b>',
	'farmer-basic-description' => 'Descrizione',
	'farmer-basic-description-text' => 'Imposta la descrizione della tua wiki di seguito',
	'farmer-basic-permission' => 'Permessi',
	'farmer-basic-permission-text' => 'Utilizzando il modulo seguente è possibile modificare i permessi degli utenti di questa wiki.',
	'farmer-basic-permission-visitor' => 'Permessi per tutti i visitatori',
	'farmer-basic-permission-visitor-text' => 'I permessi seguenti saranno applicati a tutte le persone che visiteranno questa wiki',
	'farmer-yes' => 'Sì',
	'farmer-no' => 'No',
	'farmer-basic-permission-user' => 'Permessi per gli utenti registrati',
	'farmer-basic-permission-user-text' => 'I permessi seguenti saranno applicati a tutti gli utenti registrati su questa wiki che avranno effettuato il login',
	'farmer-setpermission' => 'Imposta permessi',
	'farmer-defaultskin' => 'Skin di default',
	'farmer-defaultskin-button' => 'Imposta skin di default',
	'farmer-extensions' => 'Attiva estensioni',
	'farmer-extensions-button' => 'Imposta estensioni attive',
	'farmer-extensions-extension-denied' => 'Non hai il permesso di utilizzare questa funzione.
Devi essere un membro del gruppo farmeradmin',
	'farmer-extensions-invalid' => 'Estensione non valida',
	'farmer-extensions-invalid-text' => "Non è stato possibile aggiungere l'estensione perché il file selezionato per l'inclusione non può essere trovato",
	'farmer-extensions-available' => 'Estensioni disponibile',
	'farmer-extensions-noavailable' => 'Nessuna estensione è stata registrata',
	'farmer-extensions-register' => 'Registra estensione',
	'farmer-extensions-register-text1' => "Usa il modulo qui sotto per registrare una nuova estensione con la fattoria.
Una volta che l'estensione sarà stata registrata, tutte le wiki potranno usarla.",
	'farmer-extensions-register-text2' => "Per il parametro ''Include file'', inserisci il nome del file PHP come desideri in LocalSettings.php.",
	'farmer-extensions-register-text3' => "Se il nome del file contiene '''\$root''', quella variabile sarà sostituita con la cartella principale di MediaWiki.",
	'farmer-extensions-register-text4' => 'I percorsi attuali inclusi sono:',
	'farmer-extensions-register-name' => 'Nome',
	'farmer-extensions-register-includefile' => 'Includi file',
	'farmer-error-exists' => 'Impossibile creare wiki. Esiste già :$1',
	'farmer-error-noextwrite' => 'Impossibile scrivere file estensione:',
	'farmer-log-name' => 'Registro fattoria wiki',
	'farmer-log-header' => 'Di seguito sono elencati modifiche apportate alla fattoria di siti wiki.',
	'farmer-log-create' => 'ha creato il sito "$2"',
	'farmer-log-delete' => 'ha cancellato il sito "$2"',
	'right-farmeradmin' => 'Gestisce la fattoria di siti wiki',
	'right-createwiki' => 'Crea siti nella fattoria di siti wiki',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author 青子守歌
 */
$messages['ja'] = array(
	'farmer' => 'ウィキファーム管理',
	'farmer-desc' => 'MediaWiki ファームを管理する',
	'farmercantcreatewikis' => '新規ウィキ作成(createwikis)権限がないため、ウィキを作成できません',
	'farmercreatesitename' => 'サイト名',
	'farmercreatenextstep' => '次の手順',
	'farmernewwikimainpage' => '== あなたのウィキにようこそ ==
もしあなたがこれを読んでいるのなら、新しいウィキは正しくインストールされました。[[Special:Farmer|あなたのウィキをカスタマイズする]]ことができます。',
	'farmer-about' => '解説',
	'farmer-about-text' => 'MediaWiki Farmer を使うと MediaWiki のウィキファームを管理できるようになります。',
	'farmer-list-wiki' => 'ウィキ一覧',
	'farmer-list-wiki-text' => '{{SITENAME}} 上の全ウィキを[[$1|一覧する]]',
	'farmer-createwiki' => 'ウィキを作成する',
	'farmer-createwiki-text' => '新しいウィキを[[$1|作成する]]',
	'farmer-administration' => 'ファーム管理',
	'farmer-administration-extension' => '拡張機能を管理する',
	'farmer-administration-extension-text' => 'インストール済みの拡張機能を[[$1|管理する]]',
	'farmer-admimistration-listupdate' => 'ウィキ一覧を更新する',
	'farmer-admimistration-listupdate-text' => '{{SITENAME}} 上のウィキ一覧を[[$1|更新する]]',
	'farmer-administration-delete' => 'ウィキを削除する',
	'farmer-administration-delete-text' => 'ウィキをファームから[[$1|削除する]]',
	'farmer-administer-thiswiki' => 'このウィキを管理する',
	'farmer-administer-thiswiki-text' => 'このウィキへの変更を[[$1|管理する]]',
	'farmer-notavailable' => '利用不可',
	'farmer-notavailable-text' => 'この機能はメインウィキでのみ利用可能です',
	'farmer-wikicreated' => 'ウィキが作成されました',
	'farmer-wikicreated-text' => 'あなたのウィキが作成されました。$1 でアクセス可能です',
	'farmer-default' => '既定では、あなたを除く誰もこのウィキで許可をもっていません。利用者権限については $1 で変更できます',
	'farmer-wikiexists' => 'ウィキが存在します',
	'farmer-wikiexists-text' => "あなたが作成しようとしたウィキ '''$1''' は既に存在します。戻って別の名前を試してください。",
	'farmer-confirmsetting' => 'ウィキの設定を確認する',
	'farmer-confirmsetting-name' => '名前',
	'farmer-confirmsetting-title' => 'タイトル',
	'farmer-confirmsetting-description' => '概要',
	'farmer-confirmsetting-reason' => '理由',
	'farmer-description' => '概要',
	'farmer-confirmsetting-text' => "あなたのウィキ '''$1''' は $3 にてアクセスが可能になります。
プロジェクト名前空間は '''$2''' になり、その名前空間へのリンクは '''<nowiki>[[$2:ページ名]]</nowiki>''' という形式になります。
これで希望通りならば、以下の'''確認'''ボタンを押してください。",
	'farmer-button-confirm' => '確認',
	'farmer-button-submit' => '送信',
	'farmer-createwiki-form-title' => 'ウィキを作成する',
	'farmer-createwiki-form-text1' => '新しいウィキを作成するには以下のフォームを使ってください。',
	'farmer-createwiki-form-help' => 'ヘルプ',
	'farmer-createwiki-form-text2' => "; ウィキ名: ウィキの名前。
文字と数字のみから成る。ウィキ名はあなたのウィキを識別するURLの一部として使われます。例えば、'''title''' と入力すると、あなたのウィキは <nowiki>http://</nowiki>'''title'''.mydomain というような形式でアクセスされます。",
	'farmer-createwiki-form-text3' => '; ウィキタイトル: ウィキのタイトル。
あなたのウィキのすべてのページのタイトルで使われます。また、プロジェクト名前空間とインターウィキ接頭辞にもなります。',
	'farmer-createwiki-form-text4' => '; 概要: ウィキの概要。
ウィキについての解説文です。これはウィキ一覧で表示されます。',
	'farmer-createwiki-user' => '利用者名',
	'farmer-createwiki-name' => 'ウィキ名',
	'farmer-createwiki-title' => 'ウィキタイトル',
	'farmer-createwiki-description' => '概要',
	'farmer-createwiki-reason' => '理由',
	'farmer-updatedlist' => '更新済みの一覧',
	'farmer-notaccessible' => 'アクセス不可',
	'farmer-notaccessible-test' => 'この機能はファームの親ウィキでのみ利用可能です',
	'farmer-permissiondenied' => '許可されていません',
	'farmer-permissiondenied-text' => 'あなたはファームからウィキを削除する許可がありません。',
	'farmer-permissiondenied-text1' => 'あなたはこのページにアクセスする許可がありません',
	'farmer-deleting' => 'ウィキ「$1」は削除されました',
	'farmer-delete-confirm' => '私はこのウィキの削除を望むことを確認します。',
	'farmer-delete-confirm-wiki' => "削除するウィキ: '''$1'''",
	'farmer-delete-reason' => '削除の理由:',
	'farmer-delete-title' => 'ウィキを削除する',
	'farmer-delete-text' => '削除したいウィキを以下の一覧から選んでください',
	'farmer-delete-form' => 'ウィキを選択する',
	'farmer-delete-form-submit' => '削除',
	'farmer-listofwikis' => 'ウィキ一覧',
	'farmer-mainpage' => 'メインページ',
	'farmer-basic-title' => '基本的なパラメータ',
	'farmer-basic-title1' => 'タイトル',
	'farmer-basic-title1-text' => 'あなたのウィキにはタイトルがありません。<b>今</b>付けてください',
	'farmer-basic-description' => '概要',
	'farmer-basic-description-text' => 'あなたのウィキの概要を以下に書いてください',
	'farmer-basic-permission' => '許可',
	'farmer-basic-permission-text' => '以下のフォームを使うと、このウィキの利用者へ与える許可を変更することができます。',
	'farmer-basic-permission-visitor' => 'すべての訪問者への許可',
	'farmer-basic-permission-visitor-text' => '以下の許可はこのウィキを訪問したすべての人に適用されます',
	'farmer-yes' => 'はい',
	'farmer-no' => 'いいえ',
	'farmer-basic-permission-user' => 'ログイン利用者への許可',
	'farmer-basic-permission-user-text' => '以下の許可はこのウィキにログインしているすべての人に適用されます',
	'farmer-setpermission' => '許可を設定',
	'farmer-defaultskin' => 'デフォルトのスキン',
	'farmer-defaultskin-button' => 'デフォルトのスキンを設定',
	'farmer-extensions' => '利用する拡張機能',
	'farmer-extensions-button' => '利用する拡張機能を設定',
	'farmer-extensions-extension-denied' => 'あなたにはこの機能を使う許可がありません。ウィキファームの管理者グループ (farmeradmin) の一員である必要があります',
	'farmer-extensions-invalid' => '無効な拡張機能',
	'farmer-extensions-invalid-text' => 'インクルードすべきファイルが見つからなかったため、この拡張機能を追加することができませんでした',
	'farmer-extensions-available' => '利用可能な拡張機能',
	'farmer-extensions-noavailable' => '登録されている拡張機能はありません。',
	'farmer-extensions-register' => '拡張機能を登録',
	'farmer-extensions-register-text1' => '拡張機能をファームに新規登録するには以下のフォームを使ってください。拡張機能は一度登録されると、すべてのウィキで利用可能となります。',
	'farmer-extensions-register-text2' => 'パラメータ「インクルードファイル」には、LocalSettings.php に記述するPHPファイルの名前を入力してください。',
	'farmer-extensions-register-text3' => "ファイル名が '''\$root''' を含んでいる場合は、その変数が MediaWiki のルートディレクトリに置換されます。",
	'farmer-extensions-register-text4' => '現在のインクルードパス:',
	'farmer-extensions-register-name' => '名前',
	'farmer-extensions-register-includefile' => 'インクルードファイル',
	'farmer-error-exists' => 'ウィキを作成できません。既に存在しています: $1',
	'farmer-error-noextwrite' => '拡張機能ファイルへの書き出しができません:',
	'farmer-log-name' => 'ウィキファーム記録',
	'farmer-log-header' => 'これはウィキファームに対してなされた変更の記録です。',
	'farmer-log-create' => 'ウィキ「$2」を作成しました',
	'farmer-log-delete' => 'ウィキ「$2」を削除しました',
	'right-farmeradmin' => 'ウィキファームを管理する',
	'right-createwiki' => 'ウィキファーム内にウィキを作成する',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'farmercreatesitename' => 'Jeneng situs',
	'farmercreatenextstep' => 'Tahap sabanjuré',
	'farmernewwikimainpage' => '== Sugeng rawuh ing wiki panjenengan ==
Yèn panjenengan maca iki, wiki anyar panjenengan wis dipasang kanthi bener.
Panjenengan bisa [[Special:Farmer|nata wiki panjenengan]].',
	'farmer-about' => 'Perkara',
	'farmer-list-wiki' => 'Daftar Wiki',
	'farmer-createwiki' => 'Nggawé sawijining Wiki',
	'farmer-createwiki-text' => '[[$1|Nggawé]] wiki anyar saiki!',
	'farmer-administration-delete' => 'Mbusak sawijining Wiki',
	'farmer-administer-thiswiki' => 'Urusana Wiki iki',
	'farmer-notavailable' => 'Ora ana',
	'farmer-notavailable-text' => 'Fitur iki namung kacepakaké ing wiki utama',
	'farmer-wikicreated' => 'Wikiné wis digawé',
	'farmer-wikicreated-text' => 'Wiki panjenengan wis digawé.
Iku bisa diaksès ing $1',
	'farmer-wikiexists' => 'Wikiné èksis',
	'farmer-confirmsetting' => 'Konfirmasi Sètting Wiki',
	'farmer-confirmsetting-name' => 'Jeneng',
	'farmer-confirmsetting-title' => 'Irah-irahan',
	'farmer-confirmsetting-description' => 'Dèskripsi',
	'farmer-description' => 'Dèskripsi',
	'farmer-button-confirm' => 'Konfirmasi',
	'farmer-button-submit' => 'Kirim',
	'farmer-createwiki-form-title' => 'Nggawé sawijining Wiki',
	'farmer-createwiki-form-text1' => 'Enggonen formulir ing ngisor iki kanggo nggawé wiki anyar.',
	'farmer-createwiki-form-help' => 'Pitulung',
	'farmer-createwiki-user' => 'Jeneng panganggo',
	'farmer-createwiki-name' => 'Jeneng wiki',
	'farmer-createwiki-title' => 'Irah-irahan wiki',
	'farmer-createwiki-description' => 'Dèskripsi',
	'farmer-updatedlist' => 'Daftar sing dianyari',
	'farmer-notaccessible' => 'Ora bisa diaksès',
	'farmer-permissiondenied' => 'Idin ditolak',
	'farmer-permissiondenied-text1' => 'Panjenengan ora duwé idin kanggo ngaksès kaca iki',
	'farmer-deleting' => 'Wiki "$1" wis dibusak',
	'farmer-delete-title' => 'Busak Wiki',
	'farmer-delete-form' => 'Pilihen sawijining wiki',
	'farmer-delete-form-submit' => 'Busak',
	'farmer-mainpage' => 'Kaca Utama',
	'farmer-basic-title1' => 'Irah-irahan (judhul):',
	'farmer-basic-title1-text' => 'Wiki panjenengan ora duwé irah-irahan. Wènèhana SAIKI',
	'farmer-basic-description' => 'Dèskripsi',
	'farmer-basic-permission' => 'Kabèh idin',
	'farmer-yes' => 'Iya',
	'farmer-no' => 'Ora',
	'farmer-defaultskin' => 'Kulit Baku',
	'farmer-defaultskin-button' => 'Sèt Kulit Baku',
	'farmer-extensions-invalid' => 'Èkstènsi Ora Absah',
	'farmer-extensions-available' => 'Èkstènsi sing Ana',
	'farmer-extensions-register-name' => 'Jeneng',
	'farmer-extensions-register-includefile' => 'Mèlu Lebokna Berkas',
	'farmer-error-exists' => 'Ora bisa nggawé wiki. Sebabé wis ana: $1',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'farmer-confirmsetting-name' => 'სახელი',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'farmercantcreatewikis' => 'អ្នក​មិន​អាច​បង្កើត​វិគី​ទេ ពីព្រោះ​អ្នក​គ្មាន​អភ័យឯកសិទ្ឋិ​ក្នុង​ការបង្កើតវិគីទេ។',
	'farmercreatesitename' => 'ឈ្មោះតំបន់បណ្ដាញ',
	'farmercreatenextstep' => 'ជំហានបន្ទាប់',
	'farmernewwikimainpage' => '== សូមស្វាគមន៍ការមកកាន់វិគីរបស់លោកអ្នក ==
ប្រសិនបើអ្នកកំពុងតែអាន មានន័យថាវិគីថ្មីរបស់លោកអ្នកត្រូវបានដំឡើងត្រឹមត្រូវហើយ។

អ្នក​អាច​[[Special:Farmer|ប្ដូរ​វិគី​របស់​អ្នក​តាមបំណង]]។',
	'farmer-about' => 'អំពី',
	'farmer-list-wiki' => 'បញ្ជីវិគី',
	'farmer-list-wiki-text' => '[[$1|បញ្ជី]]នៃរាល់វិគី​នៅលើ {{SITENAME}}',
	'farmer-createwiki' => 'បង្កើតវិគី',
	'farmer-createwiki-text' => '[[$1|បង្កើត]]វិគីថ្មីមួយទៅ!',
	'farmer-administration-extension-text' => '[[$1|គ្រប់គ្រង]]ផ្នែកបន្ថែមដែលបានដំឡើង។',
	'farmer-admimistration-listupdate-text' => '[[$1|បន្ទាន់សម័យ]] បញ្ជី​នៃ​វិគី​លើ {{SITENAME}}',
	'farmer-administration-delete' => 'លុបវិគីចេញ',
	'farmer-administer-thiswiki' => 'អភិរក្សវិគីនេះ',
	'farmer-notavailable' => 'មិន​អាច​រកបាន',
	'farmer-wikicreated' => 'វិគីត្រូវបានបង្កើតហើយ',
	'farmer-wikiexists' => 'វិគីមានរូចហើយ',
	'farmer-wikiexists-text' => "វិគី​ដែលអ្នក​កំពុងព្យាយាមបង្កើត ('''$1''') មានរួចហើយ។ សូម​ត្រឡប់ក្រោយ​ហើយ​ព្យាយាម​ប្រើឈ្មោះផ្សេងទៀត។",
	'farmer-confirmsetting' => 'បញ្ជាក់ទទួលស្គាល់ ការកំណត់ វិគី',
	'farmer-confirmsetting-name' => 'ឈ្មោះ​៖',
	'farmer-confirmsetting-title' => 'ចំណងជើង​៖',
	'farmer-confirmsetting-description' => 'ការពិពណ៌នា​៖',
	'farmer-confirmsetting-reason' => 'មូលហេតុ',
	'farmer-description' => 'ការពិពណ៌នា',
	'farmer-button-confirm' => 'បញ្ជាក់ទទួលស្គាល់',
	'farmer-button-submit' => 'ដាក់ស្នើ',
	'farmer-createwiki-form-title' => 'បង្កើតវិគី',
	'farmer-createwiki-form-text1' => 'ប្រើប្រាស់​បែបបទ​ខាងក្រោម ដើម្បី​បង្កើត​វិគី​ថ្មី​មួយ​។',
	'farmer-createwiki-form-help' => 'ជំនួយ',
	'farmer-createwiki-user' => 'អត្តនាម',
	'farmer-createwiki-name' => 'ឈ្មោះវិគី',
	'farmer-createwiki-title' => 'ចំណងជើងវិគី',
	'farmer-createwiki-description' => 'ការពិពណ៌នា',
	'farmer-createwiki-reason' => 'មូលហេតុ',
	'farmer-updatedlist' => 'បញ្ជីត្រូវបានធ្វើឱ្យទាន់សម័យហើយ',
	'farmer-notaccessible' => 'មិនអាចចូលទៅបាន',
	'farmer-permissiondenied-text1' => 'អ្នក​ពុំ​មាន​ការអនុញ្ញាត​ឱ្យ​ចូលដំណើរការ​ទំព័រ​នេះ​ទេ',
	'farmer-deleting' => 'វិគី "$1" ត្រូវបានលុបចេញហើយ',
	'farmer-delete-confirm' => 'ខ្ញុំសូមអះអាងថាខ្ញុំពិតជាចង់លុបវិគីនេះចោលមែន',
	'farmer-delete-confirm-wiki' => "វិគីដែលត្រូវលុបចោល៖ '''$1''' ។",
	'farmer-delete-reason' => 'មូលហេតុ​ក្នុងការ​លុប​ចោល​៖',
	'farmer-delete-title' => 'លុបចោលវិគី',
	'farmer-delete-text' => 'ចូរ​ជ្រើសយក​វិគី​ពីបញ្ជីខាងក្រោម ដែល​អ្នកប្រាថ្នា​លុបចោល',
	'farmer-delete-form' => 'ជ្រើសរើសវិគី',
	'farmer-delete-form-submit' => 'លុបចោល',
	'farmer-listofwikis' => 'បញ្ជីវិគី',
	'farmer-mainpage' => 'ទំព័រដើម',
	'farmer-basic-title' => 'ប៉ារ៉ាម៉ែតគ្រឹះ',
	'farmer-basic-title1' => 'ចំណងជើង',
	'farmer-basic-title1-text' => 'វិគីរបស់លោកអ្នកមិនទាន់មានចំណងជើងទេ។ សូមដាក់ចំណងជើងឱ្យវាពេលនេះ!',
	'farmer-basic-description' => 'ការពិពណ៌នា',
	'farmer-basic-description-text' => 'ដាក់ការពណ៌នាអំពីវិគីរបស់អ្នកខាងក្រោមនេះ',
	'farmer-basic-permission' => 'ការអនុញ្ញាត',
	'farmer-basic-permission-text' => 'ដោយប្រើសំនុំបែបបទខាងក្រោម អ្នកអាចធ្វើការកែប្រែសិទ្ធិរបស់អ្នកប្រើប្រាស់នានានៅលើវិគីនេះ។',
	'farmer-basic-permission-visitor' => 'សិទ្ធិសំរាប់អ្នកទស្សនាទាំងអស់',
	'farmer-basic-permission-visitor-text' => 'សិទ្ធិខាងក្រោមនេះនឹងត្រូវបានអនុវត្តសំរាប់ជនទាំងអស់ដែលទស្សនាវិគីនេះ',
	'farmer-yes' => 'បាទ/ចាស៎',
	'farmer-no' => 'ទេ',
	'farmer-basic-permission-user' => 'សិទ្ធិសំរាប់អ្នកប្រើប្រាស់ដែលបានកត់ឈ្មោះចូល',
	'farmer-basic-permission-user-text' => 'សិទ្ធិខាងក្រោមនេះនឹងត្រូវបានអនុវត្តសំរាប់ជនទាំងអស់ដែលបានចុះឈ្មោះចូលវិគីនេះ',
	'farmer-setpermission' => 'កំណត់​សិទ្ធិ',
	'farmer-defaultskin' => 'សំបកលំនាំដើម',
	'farmer-defaultskin-button' => 'កំណត់​សំបក​លំនាំដើម',
	'farmer-extensions' => 'ផ្នែកបន្ថែម​សកម្ម',
	'farmer-extensions-button' => 'កំណត់​ផ្នែកបន្ថែម​សកម្ម',
	'farmer-extensions-register-name' => 'ឈ្មោះ',
	'farmer-error-exists' => 'មិនអាចបង្កើតវិគីបានទេ។ វាមានរួចជាស្រេចហើយ៖$1',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'farmer-confirmsetting-name' => 'ಹೆಸರು',
	'farmer-confirmsetting-title' => 'ಶೀರ್ಷಿಕೆ',
	'farmer-confirmsetting-description' => 'ವಿವರ',
	'farmer-confirmsetting-reason' => 'ಕಾರಣ',
	'farmer-description' => 'ವಿವರ',
	'farmer-createwiki-form-help' => 'ಸಹಾಯ',
	'farmer-createwiki-description' => 'ವಿವರ',
	'farmer-createwiki-reason' => 'ಕಾರಣ',
	'farmer-delete-form-submit' => 'ಅಳಿಸು',
	'farmer-mainpage' => 'ಮುಖ್ಯ ಪುಟ',
	'farmer-basic-title1' => 'ಶೀರ್ಷಿಕೆ',
	'farmer-basic-description' => 'ವಿವರ',
	'farmer-yes' => 'ಹೌದು',
	'farmer-no' => 'ಇಲ್ಲ',
	'farmer-extensions-register-name' => 'ಹೆಸರು',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'farmer-delete-form-submit' => 'Dilit',
	'farmer-mainpage' => 'Men Pej',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'farmer-about' => 'Angut sa Iwan',
	'farmer-createwiki-form-help' => 'Bolig',
	'farmer-delete-form-submit' => 'Para',
	'farmer-mainpage' => 'Pono nga Pahina',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'farmer' => 'MediaWiki Farmer - ene Shtall voll Wikis',
	'farmer-desc' => 'Donn ene Shtall voll MediaWiki Wikis verwallde.',
	'farmercantcreatewikis' => 'Do kanns kei Wiki neu aanlääje. Do fäählt Der et Rääch dozo („<i lang="en">createwikis</i>“)',
	'farmercreateurl' => 'URL',
	'farmercreatesitename' => 'Dä Webßait iere Name',
	'farmercreatenextstep' => 'Der näkßte Schrett',
	'farmernewwikimainpage' => '== Wellkumme op Dingem Wiki ==
Wann De dat heh lësse kannß, dann eß Ding Wiki öhndlesch opjesaz.
Öm Dingem Wiki sing Ėnshtëllonge zerääsch ze maache, doh jangk op di Sigk [[Special:Farmer]].',
	'farmer-about' => 'Üvver',
	'farmer-about-text' => 'MediaWiki Farmer hellef Der, ene Shtall voll met MediaWiki Wikis ze verwallde.',
	'farmer-list-wiki' => 'Lėßß met_te Wikiiß',
	'farmer-list-wiki-text' => 'Donn all de Wikis op {{GRAMMAR:Dativ|{{SITENAME}}}} [[$1|opliste]].',
	'farmer-createwiki' => 'E Wikki aanlääje',
	'farmer-createwiki-text' => 'Donn jetz e [[$1|neu Wiki aanlääje]]!',
	'farmer-administration' => 'Ene Shtall voll MediaWiki Wikis verwallde',
	'farmer-administration-extension' => 'Projramm_Zosätz verwallde',
	'farmer-administration-extension-text' => 'Don de [[$1|enshtalleete Zosatz-Projramme verwallde]].',
	'farmer-admimistration-listupdate' => 'Leß met Wikis op der neuste Shtand bränge',
	'farmer-admimistration-listupdate-text' => 'Donn {{GRAMMAR:Genitiv ier feminine|{{SITENAME}}}} [[$1|Wiki-Leß ändere]].',
	'farmer-administration-delete' => 'E Wikki fott maache',
	'farmer-administration-delete-text' => 'Donn [[$1|e Wiki hee fottlohße]].',
	'farmer-administer-thiswiki' => 'Donn dit Wiki hee verwallde',
	'farmer-administer-thiswiki-text' => 'Donn [[$1|dat Wiki hee verwallde]].',
	'farmer-notavailable' => 'Ham_mer nit',
	'farmer-notavailable-text' => 'Die Müjjeleschkeit hät mer bloß em Houpwiki',
	'farmer-wikicreated' => 'Wikki aanjelaat',
	'farmer-wikicreated-text' => 'Ding Wiki es aanjelaat.
Mer fengk et unger $1',
	'farmer-default' => 'Shtandattmäßesch hät Keine ußer Dir öhnds_e Rääsch en dämm Wiki.
Do kanns dä Metmaacher ier Rääschte em Wiki ändere övver: $1',
	'farmer-wikiexists' => 'Dat Wikki jidd_et alldt',
	'farmer-wikiexists-text' => 'Dat Wiki „$1“, wat De aanlääje wells, dat jidd-et ald.
Bes esu joot, jangk zerök un versök ene andere Name.',
	'farmer-confirmsetting' => 'Enstellunge för dat Wiki bestätije',
	'farmer-confirmsetting-name' => 'Name',
	'farmer-confirmsetting-title' => 'Tittel',
	'farmer-confirmsetting-description' => 'Beschrevve',
	'farmer-confirmsetting-reason' => 'Jrond',
	'farmer-description' => 'Beschrievung',
	'farmer-confirmsetting-text' => "Ding Wiki met däm Name '''$1''' weed övver $3 zo fenge sin.
Dä Name för däm Projäk sing Appachtemang weed doh '''$2''' sin.
Links op dat Appachtemang weede en dä Aat '''[<nowiki />[$2:Siggetittel]]''' sin.
Wann dat dat es, wat De wells, dann klecks De dä Knopp „'''{{int:farmer-button-confirm}}'''“ unge.",
	'farmer-button-confirm' => 'Beshtätije',
	'farmer-button-submit' => 'Lohß Jonn!',
	'farmer-createwiki-form-title' => 'E nöü Wikki opmaache',
	'farmer-createwiki-form-text1' => 'Övver dat Fommulaa hee kanns De e neu Wiki opmaache.',
	'farmer-createwiki-form-help' => 'Hölp',
	'farmer-createwiki-form-text2' => "; Däm Wiki singe Name :
Do dren sin eckersch Bochshtave un Zeffere, sönß nix.
Dä Name weed jebruch, öm als ene Deil en däm singe URL, op Ding Wiki ze zeije.
Wann De hee zem Beishpell '''tittel''' enndräähß, dann weed Ding Wiki met däm URL <nowiki>http://</nowiki>'''tittel'''.mydomain/ ze fenge sin.",
	'farmer-createwiki-form-text3' => '; Däm Wiki singe Tittel :
Dä weed en jeede Sigg en Dingem Wiki als Tittel jebruch.
Dä weed och dä Name vun däm Appachtemang met dä Sigge övver et Projäk waade.
Zojoderläz es dä dä Försatz för de Engewiki-Lenks op Ding Wiki, wann De esu jet ennjeschalldt häs.',
	'farmer-createwiki-form-text4' => '; Beschrievung :
Dä Text beschrief Ding Wiki, un weed en dä Leß met de Wikis aanjezeich.',
	'farmer-createwiki-user' => 'Metmaacher',
	'farmer-createwiki-name' => 'Däm Wiki singe Name',
	'farmer-createwiki-title' => 'Däm Wiki singe Tittel',
	'farmer-createwiki-description' => 'Beschrievung',
	'farmer-createwiki-reason' => 'Jrond',
	'farmer-updatedlist' => 'Leß op der neuste Shtand brenge',
	'farmer-notaccessible' => 'Nit zojänglesch',
	'farmer-notaccessible-test' => 'Dat es en Müjjeleschkeit, die De bloß em Vatterwiki en dämm Shtall vun Wikis häß.',
	'farmer-permissiondenied' => 'Dat es nit älaup',
	'farmer-permissiondenied-text' => 'Do häs nit dat Rääsch, hee en dä Farm e Wiki fottzeschmiiße',
	'farmer-permissiondenied-text1' => 'Do häs nit dat Rääsch, op hee die Sigg zozejriife',
	'farmer-deleting' => 'Dat Wiki „$1“ es jez fottjeschmeße',
	'farmer-delete-confirm' => 'Esch donn beschtähtejje, dat dat Wiki fott sull.',
	'farmer-delete-confirm-wiki' => "Dat Wiki zom Fottschmiiße: '''$1'''.",
	'farmer-delete-reason' => 'Der Jrond för et Fottschmiiße:',
	'farmer-delete-title' => 'E Wikki fott maache',
	'farmer-delete-text' => 'Donn dat Wiki uß dä Leß hee unge ußsöke, wat De fottschmiiße wells',
	'farmer-delete-form' => 'Don e Wiki ußsöke',
	'farmer-delete-form-submit' => 'Fott domet!',
	'farmer-listofwikis' => 'Less fun de Wikis',
	'farmer-mainpage' => 'Houpsigg',
	'farmer-basic-title' => 'Grundläje Parammeetere',
	'farmer-basic-title1' => 'Tittel',
	'farmer-basic-title1-text' => 'Ding Wiki hät keine Tittel. Donn <b>jetz</b> eine aanjevve.',
	'farmer-basic-description' => 'Beschrievung',
	'farmer-basic-description-text' => 'Jif unge de Beschrievung för Ding Wiki en',
	'farmer-basic-permission' => 'Rääschde',
	'farmer-basic-permission-text' => 'Met dämm Fommulaa unge, kanns De de Rääschte för de Metmaachere en dämm Wiki ändere.',
	'farmer-basic-permission-visitor' => '!!Fuzzy!!Räächte för Jeder Minsch ...........',
	'farmer-basic-permission-visitor-text' => 'Hee die Rääschte kritt jede Besöker dä en hee dat Wiki kütt',
	'farmer-yes' => 'Joh',
	'farmer-no' => 'Nää',
	'farmer-basic-permission-user' => 'Räächte för enjelogg Metmaacher',
	'farmer-basic-permission-user-text' => 'De Räächte hee noh kritt Jede, dä sesch en dämm Wiki enlogg',
	'farmer-setpermission' => 'Räächte sätze',
	'farmer-defaultskin' => 'Standat-Övverfläsch',
	'farmer-defaultskin-button' => 'Standat-Övverfläsch Endraare!',
	'farmer-extensions' => 'Aktive Zosäz för dem Wiki sing ẞofffwäer',
	'farmer-extensions-button' => 'Donn de aktive Zosatzprojramme faßlääje',
	'farmer-extensions-extension-denied' => 'Do häs nit dat Rääsch, hee die Müjjleschkeit ze bruche.
Doför möötß De ald en dä Metmaacher-Jropp <code lang="en">farmeradmin</code> sin.',
	'farmer-extensions-invalid' => 'Onjöltijje Zosatz zom Wiki',
	'farmer-extensions-invalid-text' => 'Dä Zosatz zom Wiki kunnt nit opjenumme un enjedraare wäde.
Mer han die Datei nit jefonge, die enjefööch wäde mööt.',
	'farmer-extensions-available' => 'Zosätz zom Wiki, die zor Wahl stonn',
	'farmer-extensions-noavailable' => 'Kein Zosätz zom Wiki enjedraare',
	'farmer-extensions-register' => 'Ene Zosatz zom Wiki endraare',
	'farmer-extensions-register-text1' => 'Met hee däm Fomulaa kanns De ene Zosatz för dem Wiki sing ẞoffwäer för Dinge MediaWiki-Shtall opnämme lohße.
Wann dat jemaat es, dann künne alle Wikis se bruche.',
	'farmer-extensions-register-text2' => 'Em <i lang="en">include file</i> Parrameter, do jif dä Name för en <code>.php</code> Datei esu aan, wie De die och en dä Datei <code>LocalSettings.php</code> endraare wööds.',
	'farmer-extensions-register-text3' => 'Wann en däm Name fun dä Dattëj <code>$root</code> dren shtish, dann shtëjt dat för dat Aanfangß_Fo\'zëjshnėß fun_de MedijaWikki ßofwäe.',
	'farmer-extensions-register-text4' => 'Em Momang sen jez de Paade för Dateie per <code>include</code> ze lade:',
	'farmer-extensions-register-name' => 'Name',
	'farmer-extensions-register-includefile' => '<i lang="en">include file</i>',
	'farmer-error-exists' => 'Dat Wikki „$1“ jidd_et alldt. Dat kan_nid_norr_enß nöü aanjelaat wääde.',
	'farmer-error-noextwrite' => 'Mer kunnte de Datei met dä Zosätz nit schriive:',
	'farmer-log-name' => 'Et Logboch fum Shtall vull Wikis',
	'farmer-log-header' => 'Dat Logboch hee zeisch de Änderunge aan däm Shtal vull Wikis.',
	'farmer-log-create' => 'hät dat Wiki „$2“ aanjelaat',
	'farmer-log-delete' => 'hät dat Wiki „$2“ fottjeschmeße',
	'right-farmeradmin' => 'Ene Shtall vull Wikis verwallde',
	'right-createwiki' => 'Neu Wikis en der Shtall vun de Wikis erin donn',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'farmer-about' => 'Der barê',
	'farmer-list-wiki' => 'Lîsteya wîkîyan',
	'farmer-wikicreated' => 'Wîkî hate afirandin',
	'farmer-confirmsetting-name' => 'Nav',
	'farmer-confirmsetting-title' => 'Sernav',
	'farmer-confirmsetting-reason' => 'Sedem',
	'farmer-button-submit' => 'Tomar bike',
	'farmer-createwiki-form-title' => 'Wîkîyekî biafirîne',
	'farmer-createwiki-form-help' => 'Alîkarî',
	'farmer-createwiki-user' => 'Navê bikarhêner',
	'farmer-createwiki-name' => 'Navê wîkîyê',
	'farmer-createwiki-title' => 'Sernavê wîkîyê',
	'farmer-createwiki-reason' => 'Sedem',
	'farmer-delete-reason' => 'Sedema jêbirinê:',
	'farmer-delete-title' => 'Wîkîyê jê bibe',
	'farmer-delete-form' => 'Wîkîyekî hilbijêre',
	'farmer-delete-form-submit' => 'Jê bibe',
	'farmer-listofwikis' => 'Lîsteya wîkîyan',
	'farmer-mainpage' => 'Destpêk',
	'farmer-basic-title1' => 'Sernav',
	'farmer-yes' => 'Erê',
	'farmer-no' => 'Na',
	'farmer-extensions-register-name' => 'Nav',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'farmer' => 'Administratioun vu méi Wikien',
	'farmer-desc' => 'Méi Wikien organiséieren',
	'farmercantcreatewikis' => 'Dir kënnt keng nei Wiki opmaachen well dir keng "cratewiki"-Rechter hutt',
	'farmercreatesitename' => 'Numm vum Site',
	'farmercreatenextstep' => 'Nächste Schrëtt',
	'farmernewwikimainpage' => '==Wëllkomm op ärer Wiki ==
Wann Dir dëst liest, gouf är Wiki korrekt installéiert.
Dir kënnt [[Special:Farmer|är Wiki elo astellen]].',
	'farmer-about' => 'Iwwer',
	'farmer-list-wiki' => 'Lëscht vun de Wikien',
	'farmer-list-wiki-text' => '[[$1|Lëscht]] vun alle Wikien op {{SITENAME}}',
	'farmer-createwiki' => 'Eng Wiki ufänken',
	'farmer-createwiki-text' => '[[$1|Maacht]] elo eng nei Wiki!',
	'farmer-administration' => 'Allgemeng Gestioun',
	'farmer-administration-extension' => 'Erweiderungen organiséieren',
	'farmer-administration-extension-text' => '[[$1|Organiséiert]] déi installeiert Erweiderungen.',
	'farmer-admimistration-listupdate' => 'Aktualisatioun vun der Lëscht vun de Wikien',
	'farmer-admimistration-listupdate-text' => 'Lëscht vun de Wikien op {{SITENAME}} [[$1|aktualiséieren]]',
	'farmer-administration-delete' => 'E Wiki läschen',
	'farmer-administration-delete-text' => 'Eng Wiki vun der Lëscht [[$1|läschen]]',
	'farmer-administer-thiswiki' => 'Dës Wiki administréieren',
	'farmer-administer-thiswiki-text' => '[[$1|Gestioun]] vun den Ännerunge vun dëser Wiki.',
	'farmer-notavailable' => 'Net disponibel',
	'farmer-notavailable-text' => 'Dëse Programm ass nëmmen op der Haapt-Wiki disponibel',
	'farmer-wikicreated' => 'Wiki gemaach',
	'farmer-wikicreated-text' => 'Är Wiki gouf elo ugeluecht.
Se ass op $1 disponibel.',
	'farmer-wikiexists' => "D'Wiki gëtt et",
	'farmer-wikiexists-text' => "D'Wiki déi Dir versicht unzeleeën, '''$1''', gëtt et schonn.
Gitt w.e.g. zréck a probéiert en aneren Numm.",
	'farmer-confirmsetting' => "Confirméiert d'Astellunge vun der Wiki",
	'farmer-confirmsetting-name' => 'Numm',
	'farmer-confirmsetting-title' => 'Titel',
	'farmer-confirmsetting-description' => 'Beschreiwung',
	'farmer-confirmsetting-reason' => 'Grond',
	'farmer-description' => 'Beschreiwung',
	'farmer-button-confirm' => 'Confirméieren',
	'farmer-button-submit' => 'Späicheren',
	'farmer-createwiki-form-title' => 'Eng Wiki ufänken',
	'farmer-createwiki-form-text1' => 'Benotzt de Formulaire hei ënnendrënner fir eng nei Wiki opzemaachen.',
	'farmer-createwiki-form-help' => 'Hëllef',
	'farmer-createwiki-form-text4' => '; Beschreiwung: Beschreiwung vun der Wiki.
Dëst ass eng Textbeschreiwung vun der Wiki.
Dësen Text gëtt an der wikilëscht gewisen.',
	'farmer-createwiki-user' => 'Benotzernumm',
	'farmer-createwiki-name' => 'Numm vun der Wiki',
	'farmer-createwiki-title' => 'Titel vun der Wiki',
	'farmer-createwiki-description' => 'Beschreiwung',
	'farmer-createwiki-reason' => 'Grond',
	'farmer-updatedlist' => 'Geännert Lëscht',
	'farmer-notaccessible' => 'Net zougänglech',
	'farmer-permissiondenied' => 'Erlaabnes refuséiert',
	'farmer-permissiondenied-text' => 'Dir hutt nët déi néideg Rechter fir eng Wiki vun dëser Lëscht ze läschen',
	'farmer-permissiondenied-text1' => 'Dir hutt net déi néideg Rechter fir op dës Säit ze goen',
	'farmer-deleting' => 'D\'Wiki "$1"  gouf geläscht',
	'farmer-delete-confirm' => 'Ech confirméieren datt ech dës Wiki läsche well',
	'farmer-delete-confirm-wiki' => "Wiki fir ze läschen: '''$1'''.",
	'farmer-delete-reason' => "Grond fir d'Läschen:",
	'farmer-delete-title' => 'Wiki läschen',
	'farmer-delete-text' => "Wielt d'Wiki déi Dir läsche wëllt aus der Lëscht hei ënnendrënner eraus",
	'farmer-delete-form' => 'Wielt eng Wiki eraus',
	'farmer-delete-form-submit' => 'Läschen',
	'farmer-listofwikis' => 'Lëscht vun de Wikien',
	'farmer-mainpage' => 'Haaptsäit',
	'farmer-basic-title' => 'Basisparameteren',
	'farmer-basic-title1' => 'Titel',
	'farmer-basic-title1-text' => "Är Wiki huet keen Titel. Gitt '''elo''' een un.",
	'farmer-basic-description' => 'Beschreiwung',
	'farmer-basic-description-text' => "Gitt d'Beschreiwung vun Ärer Wiki hei ënnendrënner an",
	'farmer-basic-permission' => 'Rechter',
	'farmer-basic-permission-visitor' => 'Rechter fir jidfereen',
	'farmer-yes' => 'Jo',
	'farmer-no' => 'Neen',
	'farmer-basic-permission-user' => 'Rechter fir ageloggte Benotzer',
	'farmer-basic-permission-user-text' => 'Dës Rechter kréien all déi Persounen déi op dëser Wiki ageloggt sinn',
	'farmer-setpermission' => 'Rechter configuréieren',
	'farmer-defaultskin' => 'Standard Ausgesinn (skin)',
	'farmer-defaultskin-button' => 'Standard-Layout (skin) festleeën',
	'farmer-extensions' => 'Aktiv Erweiderungen',
	'farmer-extensions-button' => 'Aktiv Erweiderungen astellen',
	'farmer-extensions-extension-denied' => 'Dir kënnt dës Fonctionalitéit net benotzen.
Dir musst dofir Member vum Grupp vun den Administrateure sinn.',
	'farmer-extensions-invalid' => 'Ongëlteg Erweiderung',
	'farmer-extensions-invalid-text' => "D'Erweiderung konnt net derbäigesat ginn wëll den erausgesichte Fichier deen derbäigesat sollt ginn net fonnt gouf.",
	'farmer-extensions-available' => 'Disponibel Erweiderungen',
	'farmer-extensions-noavailable' => 'Et ass keng Erweiderung registréiert',
	'farmer-extensions-register' => 'Erweiderung ofspäicheren',
	'farmer-extensions-register-name' => 'Numm',
	'farmer-error-exists' => "D'Wiki kann net gemaach ginn. Et gëtt se schonn: $1",
	'farmer-log-name' => 'Logbuch vun dëser Lëscht vu Wikien',
	'farmer-log-create' => 'huet d\'Wiki "$2" ugeluecht',
	'farmer-log-delete' => 'huet d\'Wiki "$2" geläscht',
	'right-farmeradmin' => 'Wiki-Farm geréieren',
);

/** Lithuanian (Lietuvių)
 * @author Tomasdd
 */
$messages['lt'] = array(
	'farmer-delete-form-submit' => 'Ištrinti',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'farmer-about' => 'Ap',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'farmer-createwiki-user' => 'Lietotājvārds',
	'farmer-createwiki-name' => 'Viki vārds',
	'farmer-createwiki-title' => 'Viki nosaukums',
	'farmer-createwiki-description' => 'Apraksts',
	'farmer-createwiki-reason' => 'Iemesls',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'farmer-createwiki-form-help' => 'Полшык',
	'farmer-createwiki-user' => 'Пайдаланышын лӱмжӧ',
	'farmer-delete-form-submit' => 'Шӧраш',
	'farmer-mainpage' => 'Тӱҥ лаштык',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'farmer' => 'Фармер',
	'farmer-desc' => 'Раководење со МедијаВики фарма',
	'farmercantcreatewikis' => 'Не можете да создавате викија бидејќи немате таква привилегија',
	'farmercreatesitename' => 'Име на мрежното место',
	'farmercreatenextstep' => 'Следен чекор',
	'farmernewwikimainpage' => '== Добредојдовте на вашето вики ==
Ако го гледате ова, значи дека вашето вики е правилно инсталирано.
Сега можете да го [[Special:Farmer|прилагодите викито]].',
	'farmer-about' => 'За Фармер',
	'farmer-about-text' => 'МедијаВики Фармер ви овозможува да раководите со фарма на МедијаВики викија.',
	'farmer-list-wiki' => 'Список на викија',
	'farmer-list-wiki-text' => '[[$1|Список]] на сите викија на {{SITENAME}}',
	'farmer-createwiki' => 'Создај вики',
	'farmer-createwiki-text' => '[[$1|Создајте]] ново вики!',
	'farmer-administration' => 'Администрирање на фармата',
	'farmer-administration-extension' => 'Раководење со додатоци',
	'farmer-administration-extension-text' => '[[$1|Раководете]] со инсталираните додатоци.',
	'farmer-admimistration-listupdate' => 'Подновување на списокот на фарми',
	'farmer-admimistration-listupdate-text' => '[[$1|Подновете]] го списокот на викија на {{SITENAME}}',
	'farmer-administration-delete' => 'Избриши вики',
	'farmer-administration-delete-text' => '[[$1|ИЗбришете]] вики од фармата',
	'farmer-administer-thiswiki' => 'Администрирање на ова вики',
	'farmer-administer-thiswiki-text' => '[[$1|Администрирање]] на промените на ова вики',
	'farmer-notavailable' => 'Недостапно',
	'farmer-notavailable-text' => 'Оваа можност е достапна само на главното вики',
	'farmer-wikicreated' => 'Викито е создадено',
	'farmer-wikicreated-text' => 'Вашето вики е создадено.
Достапно е на $1',
	'farmer-default' => 'По основно, никој освен вас нема дозволи на ова вики.
Можете да ги измените корисничките привилегии преку $1',
	'farmer-wikiexists' => 'Викито постои',
	'farmer-wikiexists-text' => "Викито кое сакате да го создадете, '''$1''', веќе постои.
Вратете се и изберете друго име.",
	'farmer-confirmsetting' => 'Потврди вики-нагодувања',
	'farmer-confirmsetting-name' => 'Име',
	'farmer-confirmsetting-title' => 'Наслов',
	'farmer-confirmsetting-description' => 'Опис',
	'farmer-confirmsetting-reason' => 'Причина',
	'farmer-description' => 'Опис',
	'farmer-confirmsetting-text' => "Вашето вики, '''$1''', ќе биде достапно преку $3.
Именскиот простор на проектот ќе биде '''$2'''.
Врските до овој именски простор ќе бидат од обликот '''<nowiki>[[$2:Page name]]</nowiki>'''.
Ако ова испадна како што сакавте, притиснете на копчето '''потврди''' подолу.",
	'farmer-button-confirm' => 'Потврди',
	'farmer-button-submit' => 'Испрати',
	'farmer-createwiki-form-title' => 'Создај вики',
	'farmer-createwiki-form-text1' => 'Образецот подолу служи за создавање на ново вики.',
	'farmer-createwiki-form-help' => 'Помош',
	'farmer-createwiki-form-text2' => "; Име на викито: Името на викито.
Содржи само букви и бројки.
Името на викито ќе се користи како дел од URL-адресата, за распознавање на вашето вики.
На пример, ако внесете '''title''', тогаш вашето вики ќе биде достапно преку <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Наслов на викито: Насловот за викито.
Ќе се користи во насловот на секоја страница на вашето вики.
Ова ќе биде и именски простор на проектот, како и интервики префикс.',
	'farmer-createwiki-form-text4' => '; Опис: Опис на викито.
Ова е текстуален опис на викито.
Ова ќе се прикаже во списокот на викија.',
	'farmer-createwiki-user' => 'Корисничко име',
	'farmer-createwiki-name' => 'Име на викито',
	'farmer-createwiki-title' => 'Наслов на викито',
	'farmer-createwiki-description' => 'Опис',
	'farmer-createwiki-reason' => 'Причина',
	'farmer-updatedlist' => 'Подновен список',
	'farmer-notaccessible' => 'Недостапно',
	'farmer-notaccessible-test' => 'Оваа можност е достапна само на матичното вики на фармата',
	'farmer-permissiondenied' => 'Дозволата е одбиена',
	'farmer-permissiondenied-text' => 'Немате дозвола за бришење на вики од фармата',
	'farmer-permissiondenied-text1' => 'Немате дозвола да ја отворите таа страница',
	'farmer-deleting' => 'Викито „$1“ е избришано',
	'farmer-delete-confirm' => 'Потврдувам дека сакам да го избришам ова вики',
	'farmer-delete-confirm-wiki' => "Вики за бришење: '''$1'''.",
	'farmer-delete-reason' => 'Причина за бришењето:',
	'farmer-delete-title' => 'Избриши вики',
	'farmer-delete-text' => 'Од списокот подолу одберете го викито што сакате да го избришете',
	'farmer-delete-form' => 'Одберете вики',
	'farmer-delete-form-submit' => 'Избриши',
	'farmer-listofwikis' => 'Список на викија',
	'farmer-mainpage' => 'Главна страница',
	'farmer-basic-title' => 'Основни параметри',
	'farmer-basic-title1' => 'Наслов',
	'farmer-basic-title1-text' => 'Вашето вики нема наслов. Дајте му наслов <b>сега</b>',
	'farmer-basic-description' => 'Опис',
	'farmer-basic-description-text' => 'Подолу дајте опис на вашето вики',
	'farmer-basic-permission' => 'Дозволи',
	'farmer-basic-permission-text' => 'Со образецот подолу може да се менуваат дозволите на корисниците на ова вики.',
	'farmer-basic-permission-visitor' => 'Дозволи за секој посетител',
	'farmer-basic-permission-visitor-text' => 'Следните дозволи ќе бидат доделени на секој што ќе го посети ова вики',
	'farmer-yes' => 'Да',
	'farmer-no' => 'Не',
	'farmer-basic-permission-user' => 'Дозволи за најавени корисници',
	'farmer-basic-permission-user-text' => 'Следните дозволи ќе бидат доделени на секој што ќе се најави на ова вики',
	'farmer-setpermission' => 'Постави дозволи',
	'farmer-defaultskin' => 'Матичен изглед',
	'farmer-defaultskin-button' => 'Постави матичен изглед',
	'farmer-extensions' => 'Активни додатоци',
	'farmer-extensions-button' => 'Постави активни додатоци',
	'farmer-extensions-extension-denied' => 'Немате дозвола да ја користите оваа можност.
Мора да бидете член во групата farmeradmin (администратори на фармата)',
	'farmer-extensions-invalid' => 'Неважечки додаток',
	'farmer-extensions-invalid-text' => 'Не можевме да го додадеме додатокот бидејќи одбраната податотека за вклучување не е најдена',
	'farmer-extensions-available' => 'Достапни додатоци',
	'farmer-extensions-noavailable' => 'Нема регистрирани додатоци',
	'farmer-extensions-register' => 'Регистрирај додаток',
	'farmer-extensions-register-text1' => 'Образецот подолу служи за регистрирање на нов додаток на фармата.
Откако ќе го регистрирате додатокот, сите викија ќе можат да го користат.',
	'farmer-extensions-register-text2' => "За параметарот ''Вклучи податотека'', внесете го името на PHP-податотеката како што се прави во LocalSettings.php.",
	'farmer-extensions-register-text3' => "Ако името на податотеката содржи '''\$root''', тогаш таа променлица ќе биде заменета со основниот директориум на МедијаВики.",
	'farmer-extensions-register-text4' => 'Постојните патеки за вклучување се:',
	'farmer-extensions-register-name' => 'Име',
	'farmer-extensions-register-includefile' => 'Вклучи ја податотеката',
	'farmer-error-exists' => 'Не може да се создаде викито. Тоа веќе постои: $1',
	'farmer-error-noextwrite' => 'Не можам да ја испишам податотеката на додатокот:',
	'farmer-log-name' => 'Дневник на вики-фармата',
	'farmer-log-header' => 'Ова е дневник на промените направени во вики-фармата.',
	'farmer-log-create' => 'создадено викито „$2“',
	'farmer-log-delete' => 'избришано викито „$2“',
	'right-farmeradmin' => 'Раководење со вики-фармата',
	'right-createwiki' => 'Создавање на викија на вики-фармата',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'farmer' => 'കാര്യസ്ഥൻ',
	'farmer-desc' => 'മീഡിയാവിക്കി പാടം പരിപാലിക്കുക',
	'farmercantcreatewikis' => 'വിക്കി സൃഷ്ടിക്കുവാനുള്ള അവകാശം താങ്കൾക്ക് നൽകിയിട്ടില്ലാത്തതിനാൽ വിക്കി സൃഷ്ടിക്കുവാൻ താങ്കൾക്ക് സാധിക്കില്ല',
	'farmercreatesitename' => 'സൈറ്റിന്റെ പേര്‌',
	'farmercreatenextstep' => 'അടുത്ത ഘട്ടം',
	'farmernewwikimainpage' => '== താങ്കളുടെ വിക്കിയിലേക്ക് സ്വാഗതം ==
താങ്കൾക്ക് ഇതു വായിക്കുവാൻ സാധിക്കുന്നുണ്ടെങ്കിൽ താങ്കളുടെ പുതിയ വിക്കി വിജയകരമായി ഇൻസ്റ്റോൾ ചെയ്തിരിക്കുന്നു. താങ്കൾക്ക് താങ്കളുടെ വിക്കി [[Special:Farmer|ക്രമീകരിച്ചെടുക്കാവുന്നതാണ്]].',
	'farmer-about' => 'വിവരണം',
	'farmer-about-text' => 'മീഡിയാവിക്കി കാര്യസ്ഥൻ എന്ന പദവി മീഡിയാവിക്കി വിക്കികളുടെ പാടം പരിപാലിക്കുന്നതിനു താങ്കളെ സഹായിക്കും.',
	'farmer-list-wiki' => 'വിക്കികളുടെ പട്ടിക',
	'farmer-list-wiki-text' => '{{SITENAME}} സം‌രംഭത്തിലുള്ള [[$1|വിക്കികളുടെ പട്ടിക]]',
	'farmer-createwiki' => 'ഒരു വിക്കി സൃഷ്ടിക്കുക',
	'farmer-createwiki-text' => 'പുതിയൊരു വിക്കി [[$1|സൃഷ്ടിക്കുക]]!',
	'farmer-administration' => 'പാടത്തിന്റെ കാര്യനിർ‌വഹണം',
	'farmer-administration-extension' => 'എക്സ്റ്റെൻഷൻ പരിപാലിക്കുക',
	'farmer-administration-extension-text' => 'ഇൻസ്റ്റോൾ ചെയ്ത എക്സ്റ്റൻഷനുകൾ  [[$1|പരിപാലിക്കുക]].',
	'farmer-admimistration-listupdate' => 'വിക്കിപാടത്തിന്റെ പട്ടികയുടെ പുതുക്കൽ',
	'farmer-admimistration-listupdate-text' => '{{SITENAME}} സം‌രംഭത്തിൽ വിക്കികളുടെ [[$1|പട്ടിക]] പുതുക്കുക',
	'farmer-administration-delete' => 'വിക്കി മായ്ക്കുക',
	'farmer-administration-delete-text' => 'പാടത്തു നിന്നു ഒരു വിക്കി [[$1|ഒഴിവാക്കുക]]',
	'farmer-administer-thiswiki' => 'ഈ വിക്കിയെ പരിപാലിക്കുക',
	'farmer-administer-thiswiki-text' => 'ഈ വിക്കിയിലെ മാറ്റങ്ങൾ [[$1|നിരീക്ഷിക്കുക]]',
	'farmer-notavailable' => 'ലഭ്യമല്ല',
	'farmer-notavailable-text' => 'ഈ സവിശേഷത പ്രധാനവിക്കിയിൽ മാത്രമേ ലഭ്യമുള്ളൂ',
	'farmer-wikicreated' => 'വിക്കി സൃഷ്ടിക്കപ്പെട്ടിരിക്കുന്നു',
	'farmer-wikicreated-text' => 'താങ്കളുടെ വിക്കി സൃഷ്ടിക്കപ്പെട്ടിരിക്കുന്നു.
അത് $1 എന്ന വിലാസത്തിൽ ലഭ്യമാണ്‌.',
	'farmer-default' => 'ഈ വിക്കിയിൽ സ്വതേ താങ്കൾക്ക് മാത്രമേ പ്രത്യേകാവകാശങ്ങൾ ഉള്ളൂ. ഉപയോക്താക്കളുടെ അവകാശങ്ങൾ $1 എന്ന താളിലൂടെ താങ്കൾക്ക് മാറ്റാവുന്നതാണ്‌.',
	'farmer-wikiexists' => 'വിക്കി നിലവിലുണ്ട്',
	'farmer-wikiexists-text' => "താങ്കൾ സൃഷ്ടിക്കുവാൻ ശ്രമിക്കുന്ന '''$1''' എന്ന വിക്കി നിലവിലുണ്ട്. ദയവായി തിരിച്ചു പോയി മറ്റൊരു പേരു തിരഞ്ഞെടുക്കൂ.",
	'farmer-confirmsetting' => 'വിക്കിയുടെ ക്രമീകരണങ്ങൾ സ്ഥിരീകരിക്കുക',
	'farmer-confirmsetting-name' => 'പേര്',
	'farmer-confirmsetting-title' => 'ശീർഷകം',
	'farmer-confirmsetting-description' => 'വിവരണം',
	'farmer-description' => 'വിവരണം',
	'farmer-confirmsetting-text' => "താങ്കളുടെ വിക്കിയിലേക്ക് '''$1''', $3 എന്ന വിലാസത്തിലൂടെ എത്താവുന്നതാണ്‌.
പദ്ധതിയുടെ നാമമേഖല '''$2''' എന്നായിരിക്കും.
ഈ നാമമേഖലയിലേക്കുള്ള കണ്ണികൾ '''<nowiki>[[$2:Page Name]]</nowiki>''' എന്ന രൂപത്തിൽ ആയിരിക്കും.
ഇതാണു താങ്കൾക്ക് വേണ്ടതെങ്കിൽ താഴെയുള്ള '''സ്ഥിരീകരിക്കുക''' എന്ന ബട്ടൺ അമർത്തുക.",
	'farmer-button-confirm' => 'സ്ഥിരീകരിക്കുക',
	'farmer-button-submit' => 'സമർപ്പിക്കുക',
	'farmer-createwiki-form-title' => 'ഒരു വിക്കി സൃഷ്ടിക്കുക',
	'farmer-createwiki-form-text1' => 'പുതിയൊരു വിക്കി ഉണ്ടാക്കാൻ താഴെയുള്ള ഫോം ഉപയോഗിക്കുക',
	'farmer-createwiki-form-help' => 'സഹായം',
	'farmer-createwiki-form-text2' => "; Wiki name: വിക്കിയുടെ പേര്‌.
അക്ഷരങ്ങളും അക്കങ്ങളും മാത്രമേ പാടുള്ളൂ.
താങ്കളൂടെ വിക്കിയെ തിരിച്ചറിയുവാൻ സഹായിക്കുന്ന URL-ൽ ഈ പേര്‌ ആയിരിക്കും കാണുക.
ഉദാഹരണത്തിനു താങ്കൾ '''title''' എന്നു ചേർത്താൽ, താങ്കളുടെ വിക്കിയിലേക്ക്  <nowiki>http://</nowiki>'''title'''.mydomain എന്ന വിലാസത്തിലൂടെ ആവും എത്തിപ്പെടാവുന്നത്.",
	'farmer-createwiki-form-text3' => '; Wiki name: വിക്കിയുടെ തലക്കെട്ട്
വിക്കിയിലെ ഓരോ താളിന്റേയും ശീർഷകത്തിൽ ഈ തലക്കെട്ടായിരിക്കും ഉപയോഗിക്കുക.
അതു തന്നെ ആയിരിക്കും പദ്ധതിയുടെ നാമമേഖലയും ഇന്റർ‌വിക്കി പൂർവ്വപ്രത്യയവും.',
	'farmer-createwiki-form-text4' => '; Description: വിക്കിയെക്കുറിച്ചുള്ള വിവരണം.
വിക്കിയെക്കുറിച്ചുള്ള വിവരണം.
വിക്കികളുടെ പട്ടികയിൽ ഈ വിവരണം ആയിരിക്കും പ്രദർശിപ്പിക്കുക.',
	'farmer-createwiki-user' => 'ഉപയോക്തൃനാമം',
	'farmer-createwiki-name' => 'വിക്കിയുടെ പേര്‌',
	'farmer-createwiki-title' => 'വിക്കിയുടെ തലക്കെട്ട്',
	'farmer-createwiki-description' => 'വിവരണം',
	'farmer-updatedlist' => 'പുതുക്കിയ പട്ടിക',
	'farmer-notaccessible' => 'എത്തിപ്പെടാൻ പറ്റിയില്ല',
	'farmer-notaccessible-test' => 'ഈ സവിശേഷത വിക്കിപാടത്തുള്ള പേരന്റ് വിക്കിക്കു മാത്രമേ ബാധകമാവൂ.',
	'farmer-permissiondenied' => 'അനുമതി നിഷേധിച്ചിരിക്കുന്നു',
	'farmer-permissiondenied-text' => 'പാടത്തു നിന്നു ഒരു വിക്കി ഒഴിവാക്കാനുള്ള അനുവാദം താങ്കൾക്കില്ല',
	'farmer-permissiondenied-text1' => 'ഈ താളിൽ പ്രവേശിക്കുവാൻ താങ്കൾക്ക് അനുമതിയില്ല',
	'farmer-deleting' => '"$1" എന്ന വിക്കി മായ്ച്ചിരിക്കുന്നു',
	'farmer-delete-title' => 'വിക്കി മായ്ക്കുക',
	'farmer-delete-text' => 'താങ്കൾ ഒഴിവാക്കാൻ ഉദ്ദേശിക്കുന്ന വിക്കി താഴെയുള്ള പട്ടികയിൽ നിന്നു തിരഞ്ഞെടുക്കുക',
	'farmer-delete-form' => 'ഒരു വിക്കി തിരഞ്ഞെടുക്കുക',
	'farmer-delete-form-submit' => 'മായ്ക്കുക',
	'farmer-listofwikis' => 'വിക്കികളുടെ പട്ടിക',
	'farmer-mainpage' => 'പ്രധാന താൾ',
	'farmer-basic-title1' => 'ശീർഷകം',
	'farmer-basic-title1-text' => 'താങ്കളുടെ വിക്കിക്ക് ഒരു തലക്കെട്ടില്ല. ഇപ്പോൾ ഒന്ന് ഉണ്ടാക്കൂ.',
	'farmer-basic-description' => 'വിവരണം',
	'farmer-basic-description-text' => 'താങ്കളുടെ വിക്കിയെ കുറിച്ചുള്ള വിവരണം താഴെ ചേർക്കൂ',
	'farmer-basic-permission' => 'അനുമതികൾ',
	'farmer-basic-permission-text' => 'ഈ വിക്കിയിലെ ഉപയോക്താക്കളുടെ അവകാശങ്ങളിൽ മാറ്റം വരുത്താൻ താങ്കൾക്ക്  താഴെയുള്ള ഫോം ഉപയോഗികാവുന്നതാണ്‌.',
	'farmer-basic-permission-visitor' => 'എല്ലാ സന്ദർശകർക്കുമുള്ള അവകാശങ്ങൾ',
	'farmer-basic-permission-visitor-text' => 'താഴെ പ്രദർശിപ്പിച്ചിരിക്കുന്ന അവകാശങ്ങൾ വിക്കിയിലെ ഓരോ ഉപയോക്താവിനും ബാധകമായിരിക്കും.',
	'farmer-yes' => 'ശരി',
	'farmer-no' => 'അല്ല',
	'farmer-basic-permission-user' => 'ലോഗിൻ ചെയ്ത ഉപയോക്താക്കൾക്കുള്ള അവകാശങ്ങൾ',
	'farmer-basic-permission-user-text' => 'താഴെ പ്രദർശിപ്പിച്ചിരിക്കുന്ന അവകാശങ്ങൾ വിക്കിയിൽ ലോഗിൻ ചെയ്യുന്ന ഓരോ ഉപയോക്താവിനും ബാധകമായിരിക്കും',
	'farmer-setpermission' => 'അവകാശങ്ങൾ ക്രമീകരിക്കുക',
	'farmer-defaultskin' => 'സ്വതവേയുള്ള രൂപം',
	'farmer-defaultskin-button' => 'സ്വതേ പ്രദർശിപ്പിക്കേണ്ട രൂപം സജ്ജീകരിക്കുക',
	'farmer-extensions' => 'സജീവമായ എക്സ്റ്റെൻഷനുകൾ',
	'farmer-extensions-button' => 'സജീവമായ എക്സ്റ്റെൻഷനുകൾ ക്രമീകരിക്കുക',
	'farmer-extensions-extension-denied' => 'ഈ സവിശേഷത ഉപയോഗിക്കുവാനുള്ള അനുമതി താങ്കൾക്കില്ല.
താങ്കൾ അതിനു  farmeradmin സംഘത്തിലെ അം‌ഗമായിരിക്കണം',
	'farmer-extensions-invalid' => 'അസാധുവായ എക്സ്റ്റെൻഷൻ',
	'farmer-extensions-available' => 'ലഭ്യമായ എക്സ്റ്റെൻഷനുകൾ',
	'farmer-extensions-noavailable' => 'എക്സ്റ്റെഷനുകൾ ഒന്നും രജിസ്റ്റർ ചെയ്തിട്ടില്ല',
	'farmer-extensions-register' => 'എക്സ്റ്റെൻഷൻ രെജിസ്റ്റർ ചെയ്യുക',
	'farmer-extensions-register-text1' => 'ഈ വിക്കി പാടത്ത് പുതിയൊരു എക്സ്റ്റെൻഷൻ രെജിസ്റ്റർ ചെയ്യുവാൻ താഴെയുള്ള ഫോം ഉപയോഗിക്കുക.
എക്സ്റ്റെൻഷൻ രെജിസ്റ്റർ ചെയ്തതിനു ശെഷം ഈ വിക്കിപാടത്തുള്ള എല്ലാ വിക്കികൾക്കും അതുപയോഗിക്കാം.',
	'farmer-extensions-register-name' => 'പേര്‌',
	'farmer-error-exists' => 'വിക്കി സൃഷ്ടിക്കുന്നതിനു കഴിഞ്ഞില്ല. അതു ഇപ്പോഴെ നിലവിലുണ്ട്: $1',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'farmer-confirmsetting-reason' => 'Шалтгаан',
	'farmer-button-submit' => 'Явуулах',
	'farmer-createwiki-user' => 'Хэрэглэгчийн нэр',
	'farmer-createwiki-reason' => 'Шалтгаан',
	'farmer-mainpage' => 'Нүүр хуудас',
	'farmer-yes' => 'Тийм',
	'farmer-no' => 'Үгүй',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'farmer' => 'फार्मर',
	'farmer-desc' => 'एक मीडियाविकि फार्म संपादा',
	'farmercantcreatewikis' => 'तुम्ही विकि तयार करू शकत नाही कारण त्यासाठी आवश्यक अधिकार तुम्हाला नाहीत',
	'farmercreateurl' => 'URL',
	'farmercreatesitename' => 'संकेतस्थळाचे नाव',
	'farmercreatenextstep' => 'पुढची पायरी',
	'farmernewwikimainpage' => '== तुमच्या विकिमध्ये स्वागत ==
जर तुम्ही हे वाचू शकत असाल, तर तुमचा नवीन विकि व्यवस्थितरित्या सुरू झालेला आहे. तुमचा विकि तुमच्या पसंतीनुसार बदलण्यासाठी, कृपया [[Special:Farmer]] इथे भेट द्या.',
	'farmer-about' => 'बद्दल माहिती',
	'farmer-about-text' => 'मीडियाविकिचा फार्मर तुम्हाला मीडियाविकि विकि सांभाळण्यासाठी मदत करतो.',
	'farmer-list-wiki' => 'विकिंची यादी',
	'farmer-list-wiki-text' => '{{SITENAME}} वरील सर्व विकिंची [[$1|यादी]]',
	'farmer-createwiki' => 'विकि तयार करा',
	'farmer-createwiki-text' => 'आत्ता एक विकि [[$1|तयार]] करा!',
	'farmer-administration' => 'फार्मचे प्रबंधन',
	'farmer-administration-extension' => 'विस्तार प्रबंधन करा',
	'farmer-administration-extension-text' => 'प्रस्थापना केलेल्या विस्तारांचे [[$1|प्रबंधन]] करा.',
	'farmer-admimistration-listupdate' => 'फार्म यादी ताजीतवानी करा',
	'farmer-admimistration-listupdate-text' => '{{SITENAME}} वरील विकिंची यादी [[$1|ताजीतवानी करा]]',
	'farmer-administration-delete' => 'विकि वगळा',
	'farmer-administration-delete-text' => 'या फार्म मधील एक विकि [[$1|वगळा]]',
	'farmer-administer-thiswiki' => 'ह्या विकिचे प्रबंधन करा',
	'farmer-administer-thiswiki-text' => 'या विकितील बदलांचे [[$1|प्रबंधन]] करा',
	'farmer-notavailable' => 'उपलब्ध नाही',
	'farmer-notavailable-text' => 'हे फीचर फक्त मुख्य विकिवर उपलब्ध आहे',
	'farmer-wikicreated' => 'विकि तयार झालेला आहे',
	'farmer-wikicreated-text' => 'तुमचा विकि तयार झालेला आहे. तो $1 इथे पाहता येईल',
	'farmer-default' => 'तुम्ही सोडून इतरांना या विकिवर कसलीही परवानगी नाही. तुम्ही $1 मधून सदस्य अधिकारांमध्ये बदल करू शकता',
	'farmer-wikiexists' => 'विकि अगोदरच अस्तित्वात आहे',
	'farmer-wikiexists-text' => "तुम्ही तयार करू इच्छित असलेला '''$1''' विकि, अगोदरच अस्तित्वात आहे. कृपया मागे जाऊन दुसर्‍या नावाने प्रयत्न करा.",
	'farmer-confirmsetting' => 'विकि सेटिंगची खात्री करा',
	'farmer-confirmsetting-name' => 'नाव',
	'farmer-confirmsetting-title' => 'शीर्षक',
	'farmer-confirmsetting-description' => 'माहिती',
	'farmer-description' => 'माहिती',
	'farmer-confirmsetting-text' => "तुमचा विकि, '''$1''', तुम्ही $3 इथे पाहू शकता.
या विकिचे प्रकल्प नामविश्व '''$2''' हे असेल.
या नामविश्वाचे दुवे '''<nowiki>[[$2:लेखाचे शीर्षक]]</nowiki>''' असे असतील.
जर तुम्हाला हेच अभिप्रेत असेल तर खालील '''खात्री करा''' ह्या कळीवर टिचकी मारा.",
	'farmer-button-confirm' => 'खात्री करा',
	'farmer-button-submit' => 'पाठवा',
	'farmer-createwiki-form-title' => 'विकि तयार करा',
	'farmer-createwiki-form-text1' => 'नवीन विकि तयार करण्यासाठी खालील अर्ज वापरा.',
	'farmer-createwiki-form-help' => 'साहाय्य',
	'farmer-createwiki-form-text2' => "; विकिचे नाव: विकिचे नाग. यामध्ये फक्त अक्षरे व अंक असू शकतात. विकिचे नाव तुमच्या विकिला ओळखण्यासाठी URL मध्ये वापरले जाईल. उदा. जर तुमच्या विकिचे नाव '''शीर्षक''' असेल, तर तुमचा विकि <nowiki>http://</nowiki>'''शीर्षक'''.mydomain इथे दिसेल.",
	'farmer-createwiki-form-text3' => '; विकि शीर्षक: विकिचे शीर्षक. हे प्रत्येक पानाच्या शीर्षकात वापरले जाईल. हे तुमचे प्रकल्प नामविश्व असेल तसेच आंतरविकीचे चिन्ह असेल.',
	'farmer-createwiki-form-text4' => '; माहिती: विकिची माहिती. ही मजकूरात लिहिलेली विकिबद्दलची माहिती असेल. ही विकिंच्या यादीत दाखविली जाईल.',
	'farmer-createwiki-user' => 'सदस्यनाम',
	'farmer-createwiki-name' => 'विकि नाव',
	'farmer-createwiki-title' => 'विकि शीर्षक',
	'farmer-createwiki-description' => 'माहिती',
	'farmer-updatedlist' => 'नवीन यादी',
	'farmer-notaccessible' => 'उपलब्ध नाही',
	'farmer-notaccessible-test' => 'हे फीचर फक्त फार्म मधील पालक विकिवर उपलब्ध आहे',
	'farmer-permissiondenied' => 'परवानगी नाकारली',
	'farmer-permissiondenied-text' => 'या फार्म मधील विकि वगळण्याची तुम्हाला परवानगी नाही',
	'farmer-permissiondenied-text1' => 'हे पान पहाण्याची तुम्हाला परवानगी नाही',
	'farmer-deleting' => '$1 ला वगळत आहे',
	'farmer-delete-title' => 'विकि वगळा',
	'farmer-delete-text' => 'कृपया खालील यादीतून वगळण्यासाठीचा विकि निवडा',
	'farmer-delete-form' => 'विकि निवडा',
	'farmer-delete-form-submit' => 'वगळा',
	'farmer-listofwikis' => 'विकिंची यादी',
	'farmer-mainpage' => 'मुखपृष्ठ',
	'farmer-basic-title' => 'मूलभूत मापदंड',
	'farmer-basic-title1' => 'शीर्षक',
	'farmer-basic-title1-text' => 'तुमच्या विकिला शीर्षक दिलेले नाही. आत्ता द्या',
	'farmer-basic-description' => 'माहिती',
	'farmer-basic-description-text' => 'तुमच्या विकिची माहिती खाली द्या',
	'farmer-basic-permission' => 'परवानग्या',
	'farmer-basic-permission-text' => 'खालील अर्ज वापरून या विकिवरील सदस्यांना मिळणार्‍या परवानग्या बदलता येतील.',
	'farmer-basic-permission-visitor' => 'सर्व भेट देणार्‍यांसाठी परवानग्या',
	'farmer-basic-permission-visitor-text' => 'खालील परवानग्या या विकिला भेट देणार्‍या सर्वांना देण्यात येतील',
	'farmer-yes' => 'होय',
	'farmer-no' => 'नाही',
	'farmer-basic-permission-user' => 'प्रवेश केलेल्या सदस्यांसाठी परवानग्या',
	'farmer-basic-permission-user-text' => 'खालील परवानग्या या विकिवर प्रवेश केलेल्या सर्वांना देण्यात येतील',
	'farmer-setpermission' => 'परवानग्या द्या',
	'farmer-defaultskin' => 'मूळ त्वचा',
	'farmer-defaultskin-button' => 'मूळ त्वचा निवडा',
	'farmer-extensions' => 'कार्यरत विस्तार',
	'farmer-extensions-button' => 'कार्यरत विस्तारांची आखणी करा',
	'farmer-extensions-extension-denied' => 'हे फिचर वापरण्याची परवानगी तुम्हाला नाही. तुम्ही या फार्मर प्रबंधक गटात सदस्य असणे आवश्यक आहे',
	'farmer-extensions-invalid' => 'अयोग्य विस्तार',
	'farmer-extensions-invalid-text' => 'एक्स्टेंशन वाढवू शकलो नाही कारण संचिका सापडली नाही',
	'farmer-extensions-available' => 'उपलब्ध विस्तार',
	'farmer-extensions-noavailable' => 'कोणत्याही विस्ताराची नोंदणी झालेली नाही',
	'farmer-extensions-register' => 'विस्ताराची नोंद्णी करा',
	'farmer-extensions-register-text1' => 'नवीन एक्स्टेंशन वाढविण्यासाठी खालील अर्ज वापरा. एकदा का एक्स्टेंशन वाढले की या फार्म मधील सर्व विकि ते वापरू शकतील.',
	'farmer-extensions-register-text2' => "''संचिका मिळवा'' पॅरॅमीटरसाठी PHP संचिकेचे नाव LocalSettings.php मध्ये जसे दिले तसे द्या.",
	'farmer-extensions-register-text3' => "जर संचिका नावात '''\$root''' असेल, तर ते मीडियाविकिच्या मूळ डिरेक्टरीने बदलले जाईल.",
	'farmer-extensions-register-text4' => 'सध्याचे मिळवायचे मार्ग (include path) असे आहेत:',
	'farmer-extensions-register-name' => 'नाव',
	'farmer-extensions-register-includefile' => 'संचिका मिळवा',
	'farmer-error-exists' => 'विकि तयार करू शकत नाही. तो अगोदरच अस्तित्वात आहे: $1',
	'farmer-error-noextwrite' => 'एक्स्टेंशन संचिका लिहू शकलेलो नाही:',
	'right-farmeradmin' => 'विकीशेताचे व्यवस्थापन करा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 */
$messages['ms'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Uruskan ladang MediaWiki',
	'farmercantcreatewikis' => 'Anda tidak boleh mencipta wiki kerana tiada kebenaran createwikis',
	'farmercreatesitename' => 'Nama tapak',
	'farmercreatenextstep' => 'Langkah seterusnya',
	'farmernewwikimainpage' => '== Selamat datang ke wiki anda ==
Jika anda membaca yang ini, wiki baru anda telah dipasang dengan betul.
Anda boleh [[Special:Farmer|mengubah suai wiki anda]].',
	'farmer-about' => 'Perihal',
	'farmer-about-text' => 'MediaWiki Farmer membolehkan anda menguruskan ladang wiki MediaWiki.',
	'farmer-list-wiki' => 'Senarai wiki',
	'farmer-list-wiki-text' => '[[$1|Senaraikan]] semua wiki di {{SITENAME}}',
	'farmer-createwiki' => 'Cipta wiki baru',
	'farmer-createwiki-text' => '[[$1|Cipta]] wiki baru sekarang!',
	'farmer-administration' => 'Pentadbiran ladang',
	'farmer-administration-extension' => 'Uruskan sambungan',
	'farmer-administration-extension-text' => '[[$1|Uruskan]] sambungan yang terpasang.',
	'farmer-admimistration-listupdate' => 'Kemas kini senarai ladang',
	'farmer-admimistration-listupdate-text' => '[[$1|Kemas kini]] senarai wiki di {{SITENAME}}',
	'farmer-administration-delete' => 'Hapuskan wiki',
	'farmer-administration-delete-text' => '[[$1|Hapuskan]] wiki di ladang',
	'farmer-administer-thiswiki' => 'Tadbir wiki ini',
	'farmer-administer-thiswiki-text' => '[[$1|Kawal selia]] perubahan pada wiki ini',
	'farmer-notavailable' => 'Tiada',
	'farmer-notavailable-text' => 'Ciri ini hanya terdapat di wiki utama',
	'farmer-wikicreated' => 'Wiki dicipta',
	'farmer-wikicreated-text' => 'Wiki anda telah dicipta.
Ia boleh dicapai di $1',
	'farmer-default' => 'Mengikut tetapan asali, tiada sesiapa yang mendapat kebenaran di wiki ini selain anda.
Anda boleh mengubah kebenaran pengguna melalui $1',
	'farmer-wikiexists' => 'Wiki wujud',
	'farmer-wikiexists-text' => "Wiki yang anda cuba cipta itu, '''$1''', sudah wujud.
Sila kembali dan cuba nama lain.",
	'farmer-confirmsetting' => 'Sahkan tetapan wiki',
	'farmer-confirmsetting-name' => 'Nama',
	'farmer-confirmsetting-title' => 'Tajuk',
	'farmer-confirmsetting-description' => 'Keterangan',
	'farmer-confirmsetting-reason' => 'Sebab',
	'farmer-description' => 'Keterangan',
	'farmer-confirmsetting-text' => "Wiki anda, '''$1''', akan boleh diakses melalui $3.
Ruang nama projeknya ialah '''$2'''.
Pautan kepada ruang nama ini akan berbentuk '''<nowiki>[[$2:Nama laman]]</nowiki>'''.
Jika inilah yang anda kehendaki, tekan butang '''sahkan''' di bawah.",
	'farmer-button-confirm' => 'Sahkan',
	'farmer-button-submit' => 'Hantar',
	'farmer-createwiki-form-title' => 'Cipta wiki baru',
	'farmer-createwiki-form-text1' => 'Gunakan borang di bawah untuk mencipta wiki baru.',
	'farmer-createwiki-form-help' => 'Bantuan',
	'farmer-createwiki-form-text2' => "; Nama wiki:
Hanya mengandungi huruf dan angka.
Nama wiki akan digunakan sebagai sebahagian URL untuk mengenal pasti wiki anda.
Contoh, jika anda isikan '''title''', wiki anda akan diakses melalui <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Tajuk wiki:
Akan digunakan dalam tajuk setiap laman dalam wiki anda.
Juga akan dijadikan ruang nama projek dan awalan antara wiki.',
	'farmer-createwiki-form-text4' => '; Keterangan:
Ini ialah keterangan wiki dalam bentuk teks.
Ini akan dipaparkan dalam senarai wiki.',
	'farmer-createwiki-user' => 'Nama pengguna',
	'farmer-createwiki-name' => 'Nama wiki',
	'farmer-createwiki-title' => 'Tajuk wiki',
	'farmer-createwiki-description' => 'Keterangan',
	'farmer-createwiki-reason' => 'Sebab',
	'farmer-updatedlist' => 'Senarai dikemas kini',
	'farmer-notaccessible' => 'Tidak boleh dicapai',
	'farmer-notaccessible-test' => 'Ciri ini hanya terdapat pada wiki induk di ladang',
	'farmer-permissiondenied' => 'Kebenaran ditolak',
	'farmer-permissiondenied-text' => 'Anda tiada kebenaran untuk menghapuskan wiki di ladang ini',
	'farmer-permissiondenied-text1' => 'Anda tiada kebenaran untuk mengakses laman ini',
	'farmer-deleting' => 'Wiki "$1" telah dihapuskan',
	'farmer-delete-confirm' => 'Saya mengesahkan bahawa saya mahu menghapuskan wiki ini',
	'farmer-delete-confirm-wiki' => "Wiki untuk dihapuskan: ''' $1 '''.",
	'farmer-delete-reason' => 'Sebab penghapusan:',
	'farmer-delete-title' => 'Hapuskan wiki',
	'farmer-delete-text' => 'Sila pilih wiki yang ingin anda hapuskan daripada senarai berikut',
	'farmer-delete-form' => 'Pilih wiki',
	'farmer-delete-form-submit' => 'Hapuskan',
	'farmer-listofwikis' => 'Senarai wiki',
	'farmer-mainpage' => 'Laman Utama',
	'farmer-basic-title' => 'Parameter asas',
	'farmer-basic-title1' => 'Tajuk',
	'farmer-basic-title1-text' => 'Wiki anda tiada tajuk. Tetapkan tajuk <b>sekarang</b>',
	'farmer-basic-description' => 'Keterangan',
	'farmer-basic-description-text' => 'Tetapkan keterangan wiki anda di bawah',
	'farmer-basic-permission' => 'Kebenaran',
	'farmer-basic-permission-text' => 'Anda boleh mengubah kebenaran pengguna wki ini dengan menggunakan borang yang berikut.',
	'farmer-basic-permission-visitor' => 'Kebenaran untuk setiap pengunjung',
	'farmer-basic-permission-visitor-text' => 'Kebenaran-kebenaran berikut akan dikenakan pada setiap orang yang mengunjungi wiki ini',
	'farmer-yes' => 'Ya',
	'farmer-no' => 'Tidak',
	'farmer-basic-permission-user' => 'Kebenaran untuk pengguna log masuk',
	'farmer-basic-permission-user-text' => 'Kebenaran-kebenaran berikut akan dikenakan pada setiap orang yang log masuk ke dalam wiki ini',
	'farmer-setpermission' => 'Tetapkan kebenaran',
	'farmer-defaultskin' => 'Kulit utama',
	'farmer-defaultskin-button' => 'Tetapkan kulit utama',
	'farmer-extensions' => 'Sambungan aktif',
	'farmer-extensions-button' => 'Tetapkan sambungan aktif',
	'farmer-extensions-extension-denied' => 'Anda tidak dibenarkan menggunakan ciri ini.
Anda mesti menjadi ahli kumpulan farmeradmin',
	'farmer-extensions-invalid' => 'Sambungan tidak sah',
	'farmer-extensions-invalid-text' => 'Sambungan ini tidak boleh ditambahkan kerana fail yang dipilih untuk dimasukkan tidak dapat ditemui',
	'farmer-extensions-available' => 'Sambungan yang sedia ada',
	'farmer-extensions-noavailable' => 'Tiada sambungan berdaftar',
	'farmer-extensions-register' => 'Daftarkan sambungan',
	'farmer-extensions-register-text1' => 'Gunakan borang di bawah untuk mendaftarkan sambungan baru dengan ladang.
Setelah sambungan didaftarkan, semua wiki boleh menggunakannya.',
	'farmer-extensions-register-text2' => "Untuk parameter ''Sertakan fail'', isikan nama fail PHP seperti mana yang anda lakukan di LocalSettings.php.",
	'farmer-extensions-register-text3' => "Jika nama fail mengandungi '''\$root''', pembolehubah itu akan digantikan dengan direktori akar MediaWiki.",
	'farmer-extensions-register-text4' => 'Laluan sertakan semasa ialah:',
	'farmer-extensions-register-name' => 'Nama',
	'farmer-extensions-register-includefile' => 'Sertakan fail',
	'farmer-error-exists' => 'Wiki tidak dapat dicipta. Ia sudah wujud: $1',
	'farmer-error-noextwrite' => 'Fail sambungan tidak dapat dikeluarkan:',
	'farmer-log-name' => 'Log ladang wiki',
	'farmer-log-header' => 'Ini ialah log perubahan yang dibuat pada ladang wiki.',
	'farmer-log-create' => 'mencipta wiki "$2"',
	'farmer-log-delete' => 'menghapuskan wiki "$2"',
	'right-farmeradmin' => 'Menguruskan ladang wiki',
	'right-createwiki' => 'Mencipta wiki di ladang wiki',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'farmer-createwiki-user' => 'Isem tal-utent',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$messages['mwl'] = array(
	'farmer-mainpage' => 'Páigina Percipal',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 * @author Sura
 */
$messages['myv'] = array(
	'farmer' => 'Хермер',
	'farmercreatenextstep' => 'Омбоце эскелькс',
	'farmer-list-wiki' => 'Викитнеде списка',
	'farmer-createwiki' => 'Шкамс вики',
	'farmer-notavailable' => 'Кедь маласо арась',
	'farmer-confirmsetting-name' => 'Лемезэ',
	'farmer-confirmsetting-title' => 'Коняксозо',
	'farmer-confirmsetting-description' => 'Чарькодевтемгакс',
	'farmer-description' => 'Чарькодевтемгакс',
	'farmer-button-confirm' => 'Кемекстамс',
	'farmer-createwiki-user' => 'Совицянь лем',
	'farmer-createwiki-description' => 'Чарькодевтемгакс',
	'farmer-delete-form-submit' => 'Нардамс',
	'farmer-mainpage' => 'Прякслопа',
	'farmer-basic-title1' => 'Конякс',
	'farmer-basic-description' => 'Чарькодевтемгакс',
	'farmer-yes' => 'Истя',
	'farmer-no' => 'Арась',
	'farmer-extensions-register-name' => 'Лемезэ',
);

/** Mazanderani (مازِرونی)
 * @author محک
 */
$messages['mzn'] = array(
	'farmer-about' => 'درباره',
	'farmer-createwiki-form-help' => 'راهنما',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 * @author Ricardo gs
 */
$messages['nah'] = array(
	'farmer-confirmsetting-name' => 'Tōcāitl',
	'farmer-button-submit' => 'Tiquihuāz',
	'farmer-createwiki-form-title' => 'Ticchīhuāz cē huiqui',
	'farmer-createwiki-user' => 'Tlatequitiltilīltōcāitl',
	'farmer-createwiki-name' => 'Huiqui tōcāitl',
	'farmer-deleting' => 'In huiqui "$1" ōmopoloh',
	'farmer-delete-title' => 'Ticpolōz huiqui',
	'farmer-delete-form-submit' => 'Ticpolōz',
	'farmer-listofwikis' => 'Mochi huiqui',
	'farmer-mainpage' => 'Calīxatl',
	'farmer-basic-title1' => 'Tōcāitl',
	'farmer-yes' => 'Quēmah',
	'farmer-no' => 'Ahmo',
	'farmer-extensions-register-name' => 'Tōcāitl',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Hold en MediaWiki-farm ved like',
	'farmercantcreatewikis' => 'Du kan ikke opprette wikier fordi du ikke har de riktige rettighetene',
	'farmercreatesitename' => 'Sidenavn',
	'farmercreatenextstep' => 'Neste steg',
	'farmernewwikimainpage' => '== Velkommen til wikien din ==
Om du leser dette, har din nye wiki blitt installert korrekt. Du kan [[Special:Farmer|skreddersy wikien din]].',
	'farmer-about' => 'Om',
	'farmer-about-text' => 'MediaWiki Farmer lar deg holde en hel farm av MediaWiki-wikier ved like.',
	'farmer-list-wiki' => 'Liste over wikier',
	'farmer-list-wiki-text' => '[[$1|Liste]] over alle wikiene på {{SITENAME}}',
	'farmer-createwiki' => 'Opprett en wiki',
	'farmer-createwiki-text' => '[[$1|Opprett]] en ny wiki nå!',
	'farmer-administration' => 'Farmadministrasjon',
	'farmer-administration-extension' => 'Hold utvidelser vedlike',
	'farmer-administration-extension-text' => 'Hold installerte utvidelser [[$1|ved like]].',
	'farmer-admimistration-listupdate' => 'Oppdater farmliste',
	'farmer-admimistration-listupdate-text' => '[[$1|Oppdater]] liste over wikier på {{SITENAME}}',
	'farmer-administration-delete' => 'Fjern en wiki',
	'farmer-administration-delete-text' => '[[$1|Fjern]] en wiki fra farmen',
	'farmer-administer-thiswiki' => 'Administrer denne wikien',
	'farmer-administer-thiswiki-text' => '[[$1|Administrer]] endringer i denne wikien',
	'farmer-notavailable' => 'Ikke tilgjengelig',
	'farmer-notavailable-text' => 'Denne egenskapen er bare tilgjengelig på hovedwikien',
	'farmer-wikicreated' => 'Wiki opprettet',
	'farmer-wikicreated-text' => 'Wikien din har blitt opprettet. Den er tilgjengelig på $1',
	'farmer-default' => 'Som utgangspunkt er det ingen andre enn deg som har rettigheter på denne wikien. Du kan endre brukerrettigheter via $1',
	'farmer-wikiexists' => 'Wikien finnes',
	'farmer-wikiexists-text' => "Wikien du prøver å opprette, '''$1''', finnes allerede. Gå tilbake og prøv med et annet navn.",
	'farmer-confirmsetting' => 'Bekreft wikiens innstillinger',
	'farmer-confirmsetting-name' => 'Navn',
	'farmer-confirmsetting-title' => 'Tittel',
	'farmer-confirmsetting-description' => 'Beskrivelse',
	'farmer-confirmsetting-reason' => 'Årsak',
	'farmer-description' => 'Beskrivelse',
	'farmer-confirmsetting-text' => "Wikien din, '''$1''', vil være tilgjengelig via $3.
Prosjektnavnerommet vil være '''$2'''.
Lenker til dette navnerommet vil være på formen '''<nowiki>[[$2:Sidenavn]]</nowiki>'''.
Om dette er det du vil, trykk på '''bekreft'''-knappen nedenfor.",
	'farmer-button-confirm' => 'Bekreft',
	'farmer-button-submit' => 'Lagre',
	'farmer-createwiki-form-title' => 'Opprett en wiki',
	'farmer-createwiki-form-text1' => 'Bruk skjemaet nedenfor for å opprette en ny wiki.',
	'farmer-createwiki-form-help' => 'Hjelp',
	'farmer-createwiki-form-text2' => "; Wikiens navn
: Navnet på wikien. Inneholder kun bokstaver og tall. Wikiens navn vil brukes i URL-en for å identifisere wikien. Om du for eksempel skriver inn ''tittel'', vil wikien din være tilgjengelig via <nowiki>http://</nowiki>''tittel''.mydomain.",
	'farmer-createwiki-form-text3' => '; Wikiens tittel
: Tittelen på wikien. Vil bli brukt i tittelen på enhver side på wikien din. Vil også brukes som navn på prosjektnavnerommet og som interwikiprefiks.',
	'farmer-createwiki-form-text4' => '; Bekskrivelse
: Beskrivelse av wikien. Denne vil vises i listen over wikier.',
	'farmer-createwiki-user' => 'Brukernavn',
	'farmer-createwiki-name' => 'Wikiens navn',
	'farmer-createwiki-title' => 'Wikiens tittel',
	'farmer-createwiki-description' => 'Beskrivelse',
	'farmer-createwiki-reason' => 'Årsak',
	'farmer-updatedlist' => 'Oppdatert liste',
	'farmer-notaccessible' => 'Utilgjengelig',
	'farmer-notaccessible-test' => 'Dette er kun tilgjengelig på farmens opphavswiki',
	'farmer-permissiondenied' => 'Tilgang nektet',
	'farmer-permissiondenied-text' => 'Du har ikke tillatelse til å fjerne wikier',
	'farmer-permissiondenied-text1' => 'Du har ikke tillatelse til å gå inn på denne siden',
	'farmer-deleting' => 'Wikien «$1» har blitt slettet',
	'farmer-delete-confirm' => 'Jeg bekrefter at jeg vil slette denne wikien',
	'farmer-delete-confirm-wiki' => "Wiki som skal slettes: '''$1'''.",
	'farmer-delete-reason' => 'Grunn for sletting:',
	'farmer-delete-title' => 'Fjern wiki',
	'farmer-delete-text' => 'Vennligst velg hvilken wiki du vil fjerne fra listen nedenunder',
	'farmer-delete-form' => 'Velg en wiki',
	'farmer-delete-form-submit' => 'Slett',
	'farmer-listofwikis' => 'Liste over wikier',
	'farmer-mainpage' => 'Hovedside',
	'farmer-basic-title' => 'Grunnparametere',
	'farmer-basic-title1' => 'Tittel',
	'farmer-basic-title1-text' => 'Wikien din har ikke en tittel. Velg en NÅ',
	'farmer-basic-description' => 'Beskrivelse',
	'farmer-basic-description-text' => 'Sett en beskrivelse for wikien din nedenfor',
	'farmer-basic-permission' => 'Tillatelser',
	'farmer-basic-permission-text' => 'Ved å bruke skjemaet under kan du endre brukeres rettigheter på denne wikien.',
	'farmer-basic-permission-visitor' => 'Rettigheter for alle besøkende',
	'farmer-basic-permission-visitor-text' => 'Følgende rettigheter vil bli gitt til alle som besøker wikien',
	'farmer-yes' => 'Ja',
	'farmer-no' => 'Nei',
	'farmer-basic-permission-user' => 'Rettigheter for innloggede brukere',
	'farmer-basic-permission-user-text' => 'Følgende rettigheter vil gis til alle innloggede brukere',
	'farmer-setpermission' => 'Sett rettigheter',
	'farmer-defaultskin' => 'Standardutseende',
	'farmer-defaultskin-button' => 'Sett standardutseende',
	'farmer-extensions' => 'Aktive utvidelser',
	'farmer-extensions-button' => 'Sett aktive utvidelser',
	'farmer-extensions-extension-denied' => 'Du har ikke tillatelse til å bruke denne funksjonen. Du må være medlem av brukergruppa farmeradmin',
	'farmer-extensions-invalid' => 'Ugyldig utvidelse',
	'farmer-extensions-invalid-text' => 'Vi kunne ikke legge til utvidelsen fordi filen som var valgt for inkludering ikke kunne bli funnet',
	'farmer-extensions-available' => 'Tilgjengelige utvidelser',
	'farmer-extensions-noavailable' => 'Ingen utvidelser er registrert',
	'farmer-extensions-register' => 'Registrer utvidelser',
	'farmer-extensions-register-text1' => 'Bruk skjemaet nedenfor for å registrere en ny utvidelse hos farmen. Når en utvidelse er registrert vil alle wikiene kunne bruke den.',
	'farmer-extensions-register-text2' => "For parameteret ''Inkluder fil'', skriv inn navnet på PHP-filen slik du ville gjort det i LocalSettings.php.",
	'farmer-extensions-register-text3' => "Dersom filnavnet inneholder '''\$root''', vil den variabelen erstattes med rotmappen til MediaWiki.",
	'farmer-extensions-register-text4' => 'De nåværende inkluderte stiene er:',
	'farmer-extensions-register-name' => 'Navn',
	'farmer-extensions-register-includefile' => 'Inkluder fil',
	'farmer-error-exists' => 'Kan ikke opprette wikien. Den finnes allerede: $1',
	'farmer-error-noextwrite' => 'Kunne ikke skrive ut utvidelsesfil:',
	'farmer-log-name' => 'Wiki farm loggen',
	'farmer-log-header' => 'Dette er en endringslogg for wiki-farmen.',
	'farmer-log-create' => 'opprettet wikien "$2"',
	'farmer-log-delete' => 'slettet wikien "$2"',
	'right-farmeradmin' => 'Administrer wiki-farmen',
	'right-createwiki' => 'Opprett wikier på wiki-farmen',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'farmer-about' => 'Över',
	'farmer-createwiki' => 'Wiki nee opstellen',
	'farmer-createwiki-text' => '[[$1|Stell]] nu en nee Wiki op!',
	'farmer-mainpage' => 'Hööftsiet',
	'farmer-yes' => 'Jo',
	'farmer-no' => 'Nee',
	'farmer-extensions-register-name' => 'Naam',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'farmer-createwiki-user' => 'प्रयोगकर्ता नाम',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'farmer' => "Meerdere wiki's beheren",
	'farmer-desc' => 'Een uitbreiding om verschillende MediaWiki-wikis via een hoofdwiki mee te beheren',
	'farmercantcreatewikis' => "U kunt geen wiki's aanmaken, omdat u het recht ''createwikis'' niet hebt",
	'farmercreatesitename' => 'Sitenaam',
	'farmercreatenextstep' => 'Volgende stap',
	'farmernewwikimainpage' => '== Welkom bij uw wiki ==
Als u dit leest, is uw wiki geïnstalleerd.
U kunt uw [[Special:Farmer|wiki aanpassen]].',
	'farmer-about' => 'Over',
	'farmer-about-text' => "Met MediaWikiFarmer kunt u een farm van MediaWiki wiki's beheren.",
	'farmer-list-wiki' => "Lijst van wiki's",
	'farmer-list-wiki-text' => "Alle wiki's op {{SITENAME}} [[$1|bekijken]]",
	'farmer-createwiki' => 'Een wiki maken',
	'farmer-createwiki-text' => '[[$1|Maak]] nu een nieuwe wiki!',
	'farmer-administration' => 'Farm beheren',
	'farmer-administration-extension' => 'Uitbreidingen beheren',
	'farmer-administration-extension-text' => 'Geïnstalleerde uitbreidingen [[$1|beheren]].',
	'farmer-admimistration-listupdate' => 'Farmlijst bijwerken',
	'farmer-admimistration-listupdate-text' => "De lijst van wiki's in {{SITENAME}} [[$1|bijwerken]]",
	'farmer-administration-delete' => 'Een wiki verwijderen',
	'farmer-administration-delete-text' => 'Een wiki uit de farm [[$1|verwijderen]]',
	'farmer-administer-thiswiki' => 'Deze wiki beheren',
	'farmer-administer-thiswiki-text' => 'Wijzigingen aan deze wiki [[$1|toepassen]]',
	'farmer-notavailable' => 'Niet beschikbaar',
	'farmer-notavailable-text' => 'Deze functie is alleen beschikbaar op de hoofdwiki',
	'farmer-wikicreated' => 'Wiki gemaakt',
	'farmer-wikicreated-text' => 'Uw wiki is gemaakt. Het is bereikbaar op $1',
	'farmer-default' => 'Standaard heeft niemand de rechten op deze wiki behalve u. U kunt de gebruikersrechten wijzigen via $1',
	'farmer-wikiexists' => 'Wiki bestaat',
	'farmer-wikiexists-text' => "De wiki die u probeert te maken, '''$1''', bestaat al. Gelieve terug te gaan en met een andere naam te proberen.",
	'farmer-confirmsetting' => 'Instellingen bevestigen',
	'farmer-confirmsetting-name' => 'Naam',
	'farmer-confirmsetting-title' => 'Titel',
	'farmer-confirmsetting-description' => 'Beschrijving',
	'farmer-confirmsetting-reason' => 'Reden',
	'farmer-description' => 'Beschrijving',
	'farmer-confirmsetting-text' => "Uw wiki '''$1''' wordt bereikbaar via $3.
De projectnaamruimte wordt '''$2'''.
Een verwijzing naar deze naamruimte wordt '''<nowiki>[[$2:Paginanaam]]</nowiki>'''.
Als dit in orde is, druk dan op de knop '''bevestigen'''.",
	'farmer-button-confirm' => 'Bevestigen',
	'farmer-button-submit' => 'Opslaan',
	'farmer-createwiki-form-title' => 'Een wiki maken',
	'farmer-createwiki-form-text1' => 'Gebruik het formulier hieronder om een nieuwe wiki te maken.',
	'farmer-createwiki-form-help' => 'Hulp',
	'farmer-createwiki-form-text2' => "; Naam wiki: de naam van de wiki. Bevat alleen letters en cijfers. De naam van de wiki wordt gebruikt als onderdeel van de URL om uw wiki te identificeren. Als u bijvoorbeeld '''titel''' opgeeft, dan is uw wiki te bereiken via <nowiki>http://</nowiki>'''titel'''.mijndomein.",
	'farmer-createwiki-form-text3' => '; Naam wiki: naam van de wiki. Deze naam wordt gebruikt op iedere pagina van uw wiki. De naam wordt ook gebruikt in de projectnaamruimte en als interwikivoorvoegsel.',
	'farmer-createwiki-form-text4' => '; Omschrijving: omschrijving van deze wiki. Deze tekst is te lezen in de wikilijst.',
	'farmer-createwiki-user' => 'Gebruikersnaam',
	'farmer-createwiki-name' => 'Wikinaam',
	'farmer-createwiki-title' => 'Wikititel',
	'farmer-createwiki-description' => 'Beschrijving',
	'farmer-createwiki-reason' => 'Reden',
	'farmer-updatedlist' => 'Bijgewerkte lijst',
	'farmer-notaccessible' => 'Niet bereikbaar',
	'farmer-notaccessible-test' => 'Deze optie is alleen beschikbaar in de hoofdwiki van de farm',
	'farmer-permissiondenied' => 'Geen toegang',
	'farmer-permissiondenied-text' => 'U hebt geen rechten om een wiki uit de farm te verwijderen',
	'farmer-permissiondenied-text1' => 'U hebt geen rechten om deze pagina te bekijken',
	'farmer-deleting' => 'De wiki "$1" is verwijderd',
	'farmer-delete-confirm' => 'Ik bevestig dat ik deze wiki wil verwijderen',
	'farmer-delete-confirm-wiki' => "Te verwijderen wiki: '''$1'''.",
	'farmer-delete-reason' => 'Reden voor verwijderen:',
	'farmer-delete-title' => 'Wiki verwijderen',
	'farmer-delete-text' => 'Geef in de onderstaande lijst aan welke wiki u wilt verwijderen',
	'farmer-delete-form' => 'Een wiki selecteren',
	'farmer-delete-form-submit' => 'Verwijderen',
	'farmer-listofwikis' => "Lijst van wiki's",
	'farmer-mainpage' => 'Hoofdpagina',
	'farmer-basic-title' => 'Basisinstellingen',
	'farmer-basic-title1' => 'Titel',
	'farmer-basic-title1-text' => 'Uw wiki heeft geen naam. Geef deze NU op',
	'farmer-basic-description' => 'Beschrijving',
	'farmer-basic-description-text' => 'Stel de beschrijving van uw wiki hieronder in',
	'farmer-basic-permission' => 'Rechten',
	'farmer-basic-permission-text' => 'Met het onderstaande formulier kunt u de rechten voor de gebruikers van deze wiki wijzigen.',
	'farmer-basic-permission-visitor' => 'Rechten voor iedere bezoeker',
	'farmer-basic-permission-visitor-text' => 'De volgende rechten zijn van toepassing op iedere bezoeker van de wiki',
	'farmer-yes' => 'Ja',
	'farmer-no' => 'Nee',
	'farmer-basic-permission-user' => 'Rechten voor aangemelde gebruikers',
	'farmer-basic-permission-user-text' => 'De volgende rechten zijn van toepassing op iedere aangemelde gebruiker van de wiki',
	'farmer-setpermission' => 'Rechten instellen',
	'farmer-defaultskin' => 'Standaard skin',
	'farmer-defaultskin-button' => 'Standaardskin instellen',
	'farmer-extensions' => 'Actieve uitbreidingen',
	'farmer-extensions-button' => 'Actieve uitbreidingen instellen',
	'farmer-extensions-extension-denied' => "U hebt geen toegang tot deze optie.
U moet lid zijn van de groep ''farmeradmin''.",
	'farmer-extensions-invalid' => 'Ongeldige uitbreidingen',
	'farmer-extensions-invalid-text' => 'De uitbreiding kon niet toegevoegd worden omdat het toe te voegen bestand niet is aangetroffen',
	'farmer-extensions-available' => 'Beschikbare uitbreidingen',
	'farmer-extensions-noavailable' => 'Er zijn geen uitbreidingen geregistreerd',
	'farmer-extensions-register' => 'Uitbreidingen toevoegen',
	'farmer-extensions-register-text1' => "Gebruik het onderstaande formulier om een uitbreiding voor de farm te registreren. Als een uitbreiding geregistreerd is, kunnen alle wiki's er gebruik van maken.",
	'farmer-extensions-register-text2' => "Voeg voor de parameter ''Includebestand'' de naam van het PHP-bestand in dat u als LocalSettings.php wikt gebruiken.",
	'farmer-extensions-register-text3' => "Als de bestandsnaam '''\$root''' bevat, wordt de variabele vervangen door de rootmap van MediaWiki.",
	'farmer-extensions-register-text4' => 'De volgende paden worden meegenomen:',
	'farmer-extensions-register-name' => 'Naam',
	'farmer-extensions-register-includefile' => 'Bestand opnemen',
	'farmer-error-exists' => 'De wiki kan niet aangemaakt worden. Deze bestaat al: $1',
	'farmer-error-noextwrite' => 'Het uitbreidingsbestand kon niet weggeschreven worden:',
	'farmer-log-name' => 'wikifarmlogboek',
	'farmer-log-header' => 'Dit is een logboek met de wijzigingen aan de wikifarm.',
	'farmer-log-create' => 'heeft de wiki "$2" aangemaakt',
	'farmer-log-delete' => 'heeft de wiki "$2" verwijderd',
	'right-farmeradmin' => 'De wikifarm beheren',
	'right-createwiki' => "Wiki's aanmaken in de wikifarm",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'farmer' => 'Handsam wikisamling',
	'farmer-desc' => 'Hald ei MediaWiki-samling ved like',
	'farmercantcreatewikis' => 'Du kan ikkje oppretta wikiar av di du ikkje har dei rette rettane',
	'farmercreatesitename' => 'Sidenamn',
	'farmercreatenextstep' => 'Neste steg',
	'farmernewwikimainpage' => '== Velkomen til wikien din ==
Om du les dette, har den nye wikien din vorten installert rett.
Du kan [[Special:Farmer|skreddarsy wikien din]].',
	'farmer-about' => 'Om',
	'farmer-about-text' => 'MediaWiki Farmer lèt deg halda ei heil samling av MediaWiki-wikiar ved like.',
	'farmer-list-wiki' => 'Lista over wikiar',
	'farmer-list-wiki-text' => '[[$1|Lista]] over alle wikiane på {{SITENAME}}',
	'farmer-createwiki' => 'Opprett ein wiki',
	'farmer-createwiki-text' => '[[$1|Opprett]] ein ny wiki no!',
	'farmer-administration' => 'Handsaming av wikisamling',
	'farmer-administration-extension' => 'Handsam utvidingar',
	'farmer-administration-extension-text' => '[[$1|Handsam]] installerte utvidingar.',
	'farmer-admimistration-listupdate' => 'Oppdater wikisamlingslista',
	'farmer-admimistration-listupdate-text' => '[[$1|Oppdater]] lista over wikiar på {{SITENAME}}',
	'farmer-administration-delete' => 'Slett ein wiki',
	'farmer-administration-delete-text' => '[[$1|Slett]] ein wiki frå samlinga',
	'farmer-administer-thiswiki' => 'Administrer denne wikien',
	'farmer-administer-thiswiki-text' => '[[$1|Administrer]] endringar i denne wikien',
	'farmer-notavailable' => 'Ikkje tilgjengeleg',
	'farmer-notavailable-text' => 'Denne eigenskapen er berre tilgjengeleg på hovudwikien',
	'farmer-wikicreated' => 'Wiki oppretta',
	'farmer-wikicreated-text' => 'Wikien din har vorten oppretta.
Han er tilgjengeleg på $1',
	'farmer-default' => 'Som utgangspunkt er det ingen utanom deg som har rettar på wikien.
Du kan endra brukarrettar gjennom $1',
	'farmer-wikiexists' => 'Wikien finst',
	'farmer-wikiexists-text' => "Wikien du freistar å oppretta, '''$1''', finst frå før.
Gå tilbake og freist med eit anna namn.",
	'farmer-confirmsetting' => 'Stadfest instillingane til wikien',
	'farmer-confirmsetting-name' => 'Namn',
	'farmer-confirmsetting-title' => 'Tittel',
	'farmer-confirmsetting-description' => 'Skildring',
	'farmer-confirmsetting-reason' => 'Grunngjeving',
	'farmer-description' => 'Skildring',
	'farmer-confirmsetting-text' => "Wikien din, '''$1''', vil vera tilgjengeleg gjennom $3.
Prosjektnamnerommet vil vera '''$2'''.
Lenkjer til namnerommet vil vera på forma '''<nowiki>[[$2:Sidenamn]]</nowiki>'''.
Om dette er det du vil, trykk på knappen ''{{int:Farmer-button-confirm}}'' nedanfor.",
	'farmer-button-confirm' => 'Stadfest',
	'farmer-button-submit' => 'Lagra',
	'farmer-createwiki-form-title' => 'Opprett ein wiki',
	'farmer-createwiki-form-text1' => 'Nytt skjemaet nedanfor for å oppretta ein ny wiki.',
	'farmer-createwiki-form-help' => 'Hjelp',
	'farmer-createwiki-form-text2' => "; Namnet på wikien: Namnet på wikien.
Inneheld berre bokstavar og tal. Namnet på wikien vil verta nytta i adressa for å identifisera wikien. Om du til dømes skriv inn ''tittel'', vil wikien din vera tilgjengeleg på <nowiki>http://</nowiki>''tittel''.mydomain.",
	'farmer-createwiki-form-text3' => '; Tittel på wikien: Tittelen på wikien.
Vil verta nytta i tittelen på kvar sida på wikien din. Han vil òg verta nytta som namn på prosjektnamnerommet og som interwikiprefiks.',
	'farmer-createwiki-form-text4' => '; Skildring: Skildring av wikien.
Dette er ein tekst som skildrar wikien.
Han vil verta vist i wikilista.',
	'farmer-createwiki-user' => 'Brukarnamn',
	'farmer-createwiki-name' => 'Namn på wiki',
	'farmer-createwiki-title' => 'Tittel på wiki',
	'farmer-createwiki-description' => 'Skildring',
	'farmer-createwiki-reason' => 'Grunn',
	'farmer-updatedlist' => 'Oppdatert lista',
	'farmer-notaccessible' => 'Utan tilgjenge',
	'farmer-notaccessible-test' => 'Dette er berre tilgjengeleg på opphavswikien i wikisamlinga',
	'farmer-permissiondenied' => 'Tilgjenge nekta',
	'farmer-permissiondenied-text' => 'Du har ikkje løyve til å sletta wikiar frå wikisamlinga',
	'farmer-permissiondenied-text1' => 'Du har ikkje løyve til å gå inn på denne sida',
	'farmer-deleting' => 'Wikien «$1» har vorte sletta',
	'farmer-delete-confirm' => 'Eg stadfestar at eg ynskjer å sletta denne wikien',
	'farmer-delete-confirm-wiki' => "Wiki som skal slettast: '''$1'''.",
	'farmer-delete-reason' => 'Grunn for slettinga:',
	'farmer-delete-title' => 'Slett wiki',
	'farmer-delete-text' => 'Oppgje frå lista under kva wiki du vil sletta',
	'farmer-delete-form' => 'Vel ein wiki',
	'farmer-delete-form-submit' => 'Slett',
	'farmer-listofwikis' => 'Lista over wikiar',
	'farmer-mainpage' => 'Hovudside',
	'farmer-basic-title' => 'Grunnparametrar',
	'farmer-basic-title1' => 'Tittel',
	'farmer-basic-title1-text' => 'Wikien din manglar ein tittel.  Vel ein <b>no</b>',
	'farmer-basic-description' => 'Skildring',
	'farmer-basic-description-text' => 'Gje ei skildring av wikien din nedanfor',
	'farmer-basic-permission' => 'Løyve',
	'farmer-basic-permission-text' => 'Ved å nytta skjemaet nedanfor kan du endra brukarrettar på wikien.',
	'farmer-basic-permission-visitor' => 'Rettar for alle vitjande',
	'farmer-basic-permission-visitor-text' => 'Dei følgjande rettane vil verta gjevne til alle som vitjar wikien',
	'farmer-yes' => 'Ja',
	'farmer-no' => 'Nei',
	'farmer-basic-permission-user' => 'Rettar for innlogga brukarar',
	'farmer-basic-permission-user-text' => 'Dei følgjande rettane vil verta gjevne til alle innlogga brukarar',
	'farmer-setpermission' => 'Fastsett rettar',
	'farmer-defaultskin' => 'Standardutsjånad',
	'farmer-defaultskin-button' => 'Set standardutsjånad',
	'farmer-extensions' => 'Aktive utvidingar',
	'farmer-extensions-button' => 'Set aktive utvidingar',
	'farmer-extensions-extension-denied' => 'Du har ikkje tilgjenge til denne funksjonen.
Du må vera medlem av brukargruppa farmeradmin for å nytta han',
	'farmer-extensions-invalid' => 'Ugyldig utviding',
	'farmer-extensions-invalid-text' => 'Me kunne ikkje leggja til utvidinga då fila som vart vald for inkludering ikkje kunne verta funnen.',
	'farmer-extensions-available' => 'Tilgjengelege utvidingar',
	'farmer-extensions-noavailable' => 'Ingen utvidingar er registrerte',
	'farmer-extensions-register' => 'Registrer utviding',
	'farmer-extensions-register-text1' => 'Nytt skjemaet under for å registrera ei ny utviding hos wikisamlinga.
Når ei utviding er registrert, vil alle wikiane kunna nytta seg av ho.',
	'farmer-extensions-register-text2' => "For parameteren ''Inkluder fil'', skriv inn namnet på PHP-fila slik du ville ha gjort det i LocalSettings.php.",
	'farmer-extensions-register-text3' => "I fall filnamnet inneheld '''\$root''', vil variabelen verta erstatta med rotmappa til MediaWiki.",
	'farmer-extensions-register-text4' => 'Dei noverande inkluderte stigane er:',
	'farmer-extensions-register-name' => 'Namn',
	'farmer-extensions-register-includefile' => 'Inkluder fil',
	'farmer-error-exists' => 'Kan ikkje oppretta wikien. Han finst frå før: $1',
	'farmer-error-noextwrite' => 'Kunne ikkje skriva ut utvidingsfil:',
	'farmer-log-name' => 'Wiki farm loggføring',
	'farmer-log-header' => 'Dette er ei loggføring av endringar gjort med wiki-farmen.',
	'farmer-log-create' => 'oppretta wikien «$2»',
	'farmer-log-delete' => 'sletta wikien «$2»',
	'right-farmeradmin' => 'Administrer wiki-farmen',
	'right-createwiki' => 'Opprett wikiar på wiki-farmen',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'farmer-list-wiki' => 'Lenano la di-Wiki',
	'farmer-createwiki' => 'Hlama Wiki',
	'farmer-administration-delete' => 'Phumula Wiki',
	'farmer-wikicreated' => 'Wiki e hlomilwe',
	'farmer-confirmsetting-name' => 'Leina',
	'farmer-confirmsetting-title' => 'Thaetlele',
	'farmer-createwiki-form-help' => 'Thušo',
	'farmer-createwiki-user' => 'Leina la mošomiši',
	'farmer-createwiki-name' => 'Leina la Wiki',
	'farmer-createwiki-title' => 'Thaetlele ya Wiki',
	'farmer-deleting' => 'Phumutše $1',
	'farmer-delete-form-submit' => 'Phumula',
	'farmer-listofwikis' => 'Lenano la di-Wiki',
	'farmer-basic-title1' => 'Thaetlele',
	'farmer-yes' => 'Ee',
	'farmer-no' => 'Aowa',
	'farmer-extensions-register-name' => 'Leina',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'farmer' => 'Administracion Multi Wikis',
	'farmer-desc' => 'Administra mantun wiki',
	'farmercantcreatewikis' => 'Podètz pas crear de wikis perque avètz pas l’abilitacion « createwikis » necessària per aquò.',
	'farmercreateurl' => "L'adreça",
	'farmercreatesitename' => 'Nom del site',
	'farmercreatenextstep' => 'Etapa seguenta',
	'farmernewwikimainpage' => '== Benvenguda dins vòstre Wiki ==
Se legissètz aqueste messatge, aquò indica que vòstre wiki es estat installat corrèctament.
Podètz [[Special:Farmer|individualizar vòstre wiki]].',
	'farmer-about' => 'A prepaus',
	'farmer-about-text' => 'L’extension MediaWiki Farmer vos permet, en permanéncia, d’organizar un ensemble de wikis eissit del logicial MediaWiki.',
	'farmer-list-wiki' => 'Lista dels wikis',
	'farmer-list-wiki-text' => '[[$1|Lista]] totes los wikis sus aqueste site.',
	'farmer-createwiki' => 'Crear un Wiki',
	'farmer-createwiki-text' => '[[$1|Crear]] ara un wiki novèl.',
	'farmer-administration' => 'Administracion generala',
	'farmer-administration-extension' => 'Organizar las extensions',
	'farmer-administration-extension-text' => '[[$1|Organiza]] las extensions installadas.',
	'farmer-admimistration-listupdate' => 'Mesa a jorn de la lista dels Wikis',
	'farmer-admimistration-listupdate-text' => '[[$1|Mesa a jorn]] de la lista dels wikis sus aqueste site.',
	'farmer-administration-delete' => 'Suprimir un Wiki',
	'farmer-administration-delete-text' => '[[$1|Suprimir]] un wiki dempuèi aqueste site d’administracion generala',
	'farmer-administer-thiswiki' => 'Administrar aqueste Wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administrar]] los cambiaments sus aqueste wiki.',
	'farmer-notavailable' => 'Pas disponible',
	'farmer-notavailable-text' => 'Aqueste programa es pas disponible que sul site principal',
	'farmer-wikicreated' => 'Wiki creat',
	'farmer-wikicreated-text' => 'Vòstre wiki es estat creat.
Es accessible sus $1',
	'farmer-default' => "Per defaut, degun dispausa pas de permissions sus aqueste wiki a despart de vos. Podètz cambiar los privilègis d'utilizaire via $1",
	'farmer-wikiexists' => 'Lo Wiki existís',
	'farmer-wikiexists-text' => "Lo wiki intitolat '''$1''' que voliatz crear, existís ja.  Vos convidam a tornar en rière e a ensajar un nom novèl.",
	'farmer-confirmsetting' => 'Confirmar los paramètres del Wiki',
	'farmer-confirmsetting-name' => 'Nom',
	'farmer-confirmsetting-title' => 'Títol',
	'farmer-confirmsetting-description' => 'Descripcion',
	'farmer-confirmsetting-reason' => 'Rason',
	'farmer-description' => 'Descripcion',
	'farmer-confirmsetting-text' => "Vòstre wiki, '''$1''', serà accessible dempuèi l'adreça $3.
L’espaci de nom del projècte serà '''$2'''.
Los ligams cap a aqueste espaci de noms seràn de la forma de '''<nowiki>[[$2:Nom de la pagina]]</nowiki>'''.
S’es plan çò que volètz, clicatz sul boton '''Confirmar''' çaijós.",
	'farmer-button-confirm' => 'Confirmar',
	'farmer-button-submit' => 'Sometre',
	'farmer-createwiki-form-title' => 'Crear un Wiki',
	'farmer-createwiki-form-text1' => 'Utilizatz lo formulari çaijós per crear un wiki novèl.',
	'farmer-createwiki-form-help' => 'Ajuda',
	'farmer-createwiki-form-text2' => "; Nom del Wiki : Lo nom del Wiki.  Conten pas que de letras e de chifras. Lo nom del wiki serà utilizat coma una partida de l'adreça per l'identificar. A títol d'exemple, se entratz '''títol''', vòstre wiki serà accessible sus <nowiki>http://</nowiki>'''títol'''.mondomeni.",
	'farmer-createwiki-form-text3' => '; Títol del Wiki : Lo títol del wiki. Serà utilizat dins lo títol de cada pagina de vòstre wiki. Prendrà lo nom de l’espaci « Project » e mai lo prefix interwiki.',
	'farmer-createwiki-form-text4' => '; Descripcion : Descripcion del wiki. Aquò consistís en un tèxte que descriu lo wiki. Serà afichat dins la lista dels wikis.',
	'farmer-createwiki-user' => 'Nom de l’utilizaire',
	'farmer-createwiki-name' => 'Nom del Wiki',
	'farmer-createwiki-title' => 'Títol del Wiki',
	'farmer-createwiki-description' => 'Descripcion',
	'farmer-createwiki-reason' => 'Rason',
	'farmer-updatedlist' => 'Lista mesa a jorn',
	'farmer-notaccessible' => 'Pas accessible',
	'farmer-notaccessible-test' => "Aqueste programa es disponible unicament sul wiki principal d'aquest ensemble de projèctes.",
	'farmer-permissiondenied' => 'Permission refusada',
	'farmer-permissiondenied-text' => 'Avètz pas la permission de suprimir un wiki dempuèi lo site d’administracion generala.',
	'farmer-permissiondenied-text1' => 'Vos es pas permes d’accedir a aquesta pagina.',
	'farmer-deleting' => 'Lo wiki « $1 » es estat suprimit',
	'farmer-delete-confirm' => 'Confirmi que vòli suprimir aqueste wiki',
	'farmer-delete-confirm-wiki' => "Wiki de suprimir : '''$1'''.",
	'farmer-delete-reason' => 'Motiu de supression :',
	'farmer-delete-title' => 'Suprimir un Wiki',
	'farmer-delete-text' => 'Seleccionatz lo wiki que desiratz suprimir dempuèi la lista çaijós.',
	'farmer-delete-form' => 'Seleccionatz un wiki',
	'farmer-delete-form-submit' => 'Suprimir',
	'farmer-listofwikis' => 'Lista dels Wikis',
	'farmer-mainpage' => 'Acuèlh',
	'farmer-basic-title' => 'Paramètres de basa',
	'farmer-basic-title1' => 'Títol',
	'farmer-basic-title1-text' => "Vòstre wiki dispausa pas de títol. Indicatz-ne un '''ara'''",
	'farmer-basic-description' => 'Descripcion',
	'farmer-basic-description-text' => 'Indicatz dins lo quadre çaijós la descripcion de vòstre wiki.',
	'farmer-basic-permission' => 'Abilitacions',
	'farmer-basic-permission-text' => "En utilizant lo formulari çaijós, es possible de cambiar las abilitacions dels utilizaires d'aqueste wiki.",
	'farmer-basic-permission-visitor' => 'Abilitacions per cada visitaire',
	'farmer-basic-permission-visitor-text' => 'Las abilitacions seguentas seràn aplicablas per totas las personas que visitaràn aqueste wiki.',
	'farmer-yes' => 'Òc',
	'farmer-no' => 'Non',
	'farmer-basic-permission-user' => 'Abilitacions pels utilizaires enregistrats',
	'farmer-basic-permission-user-text' => 'Las abilitacions seguentas seràn aplicablas a totes los utilizaires enregistrats sus aqueste wiki.',
	'farmer-setpermission' => 'Configurar las abilitacions',
	'farmer-defaultskin' => 'Aparéncias per defaut',
	'farmer-defaultskin-button' => 'Configurar l’aparéncia per defaut',
	'farmer-extensions' => 'Extensions activas',
	'farmer-extensions-button' => 'Configurar las extensions activas',
	'farmer-extensions-extension-denied' => "Sètz pas abilitat per l’utilizacion d'aquesta foncionalitat. Vos cal èsser membre dels administrators de l’administracion multi wikis.",
	'farmer-extensions-invalid' => 'Extension invalida',
	'farmer-extensions-invalid-text' => 'Podèm pas apondre aquesta extension perque lo fichièr seleccionat per l’inclusion es introbable.',
	'farmer-extensions-available' => 'Extensions disponiblas',
	'farmer-extensions-noavailable' => "Cap d'extension es pas enregistrada.",
	'farmer-extensions-register' => 'Enregistrar una extension',
	'farmer-extensions-register-text1' => 'Utilizatz lo formulari çaijós per enregistrar una extension novèla amb aquesta foncionalitat. Un còp l’extension enregistrada, totes los wikis la poiràn utilizar.',
	'farmer-extensions-register-text2' => "Per çò que concernís lo paramètre ''Fichier Include'', indicatz lo nom del fichièr PHP que voldretz dins LocalSettings.php.",
	'farmer-extensions-register-text3' => "Se lo nom del fichièr conten '''\$root''', aquesta variabla serà remplaçada pel repertòri raiç de MediaWiki.",
	'farmer-extensions-register-text4' => 'Los camins actuals dels fichièrs include son :',
	'farmer-extensions-register-name' => 'Nom',
	'farmer-extensions-register-includefile' => 'Fichièr Include',
	'farmer-error-exists' => 'L’interfàcia pòt pas crear lo Wiki. Existís ja : $1',
	'farmer-error-noextwrite' => 'Impossible d’escriure lo fichièr d’extension seguent :',
	'farmer-log-name' => 'Jornal de la bòria wiki',
	'farmer-log-header' => 'Aqueste jornal conten las modificacions aportadas a la bòria wiki.',
	'farmer-log-create' => 'a creat lo wiki « $2 »',
	'farmer-log-delete' => 'a suprimit lo wiki « $2 »',
	'right-farmeradmin' => 'Gerir la bòria de wikis',
	'right-createwiki' => 'Crear de wikis dins la bòria de wikis',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jnanaranjan Sahu
 * @author Jose77
 * @author Psubhashish
 */
$messages['or'] = array(
	'farmercreatesitename' => 'ସାଇଟ ନାମ',
	'farmercreatenextstep' => 'ପର ସୋପାନ',
	'farmer-about' => 'ବିଷୟରେ',
	'farmer-list-wiki' => 'ଉଇକିଗୁଡିକର ତାଲିକା',
	'farmer-createwiki' => 'ଗୋଟିଏ ଉଇକି ତିଆରି କରିବେ',
	'farmer-confirmsetting-title' => 'ଶିରୋନାମା',
	'farmer-createwiki-form-help' => 'ସହଯୋଗ',
	'farmer-createwiki-user' => 'ବ୍ୟବହାରକାରୀ ନାମ',
	'farmer-mainpage' => 'ପ୍ରଧାନ ପୃଷ୍ଠା',
	'farmer-basic-title1' => 'ଶିରୋନାମା',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'farmer-confirmsetting-title' => 'Сæргонд',
	'farmer-createwiki-user' => 'Архайæджы ном',
	'farmer-delete-form-submit' => 'Аппар',
	'farmer-basic-title1' => 'Сæргонд',
	'farmer-yes' => 'О',
	'farmer-no' => 'Нæ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'farmer' => 'Bauer',
	'farmer-desc' => 'Manage en MediaWiki-Bauerei',
	'farmercreatesitename' => 'Naame vun dem Gewebb',
	'farmer-about' => 'Iwwer',
	'farmer-list-wiki' => 'Lischt vun Wikis',
	'farmer-list-wiki-text' => '[[$1|Lischt]] vun alle Wikis uff {{SITENAME}}',
	'farmer-administration' => 'Administration vun de Bauerei',
	'farmer-confirmsetting-name' => 'Naame',
	'farmer-confirmsetting-title' => 'Titel',
	'farmer-confirmsetting-reason' => 'Grund',
	'farmer-createwiki-form-help' => 'Hilf',
	'farmer-createwiki-user' => 'Yuuser-Naame',
	'farmer-createwiki-name' => 'Naame vum Wiki',
	'farmer-createwiki-reason' => 'Grund',
	'farmer-delete-title' => 'Wiki lesche',
	'farmer-delete-form-submit' => 'Verwische',
	'farmer-listofwikis' => 'Lischt vun Wikis',
	'farmer-mainpage' => 'Haaptblatt',
	'farmer-basic-title1' => 'Titel',
	'farmer-yes' => 'Ya',
	'farmer-no' => 'Nee',
	'farmer-extensions-register-name' => 'Naame',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'farmer-createwiki-user' => 'Bruckernome',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'farmer-delete-form-submit' => 'Lesche',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Equadus
 * @author Leinad
 * @author Masti
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Zarządzanie farmą MediaWiki',
	'farmercantcreatewikis' => 'Nie możesz utworzyć nowej wiki, ponieważ nie masz uprawnienia createwiki.',
	'farmercreatesitename' => 'Nazwa witryny',
	'farmercreatenextstep' => 'Następny etap',
	'farmernewwikimainpage' => '== Witamy w swojej Wiki ==
Jeżeli czytasz ten tekst, oznacza to, że Twoja nowa wiki została zainstalowana prawidłowo.
Możesz [[Special:Farmer|dostosować wiki do swoich potrzeb]].',
	'farmer-about' => 'O farmie',
	'farmer-about-text' => 'Farmer MediaWiki pozwala na zarządzanie farmą wiki.',
	'farmer-list-wiki' => 'Spis Wiki',
	'farmer-list-wiki-text' => '[[$1|Spis]] wszystkich wiki na {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'farmer-createwiki' => 'Utwórz Wiki',
	'farmer-createwiki-text' => '[[$1|Stwórz]] teraz nową wiki!',
	'farmer-administration' => 'Zarządzanie farmą',
	'farmer-administration-extension' => 'Zarządzanie rozszerzeniami',
	'farmer-administration-extension-text' => '[[$1|Zarządzaj]] zainstalowanymi rozszerzeniami.',
	'farmer-admimistration-listupdate' => 'Aktualizacja spisu farmy',
	'farmer-admimistration-listupdate-text' => '[[$1|Aktualizacja]] spisu wiki na {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'farmer-administration-delete' => 'Usuń Wiki',
	'farmer-administration-delete-text' => '[[$1|Usuń]] wiki z farmy',
	'farmer-administer-thiswiki' => 'Zarządzaj tą Wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Rejestr zarządzania]] tą wiki',
	'farmer-notavailable' => 'Niedostępne',
	'farmer-notavailable-text' => 'Ta funkcja dostępna jest tylko na głównej wiki',
	'farmer-wikicreated' => 'Wiki została utworzona',
	'farmer-wikicreated-text' => 'Twoja wiki została utworzona.
Dostępna jest pod adresem $1',
	'farmer-default' => 'Domyślnie, nikt oprócz Ciebie nie ma uprawnień na tej wiki.
Możesz zmienić uprawnienia użytkowników poprzez $1',
	'farmer-wikiexists' => 'Wiki już istnieje',
	'farmer-wikiexists-text' => "Wiki którą próbujesz utworzyć '''$1''' już istnieje.
Spróbuj utworzyć wiki pod inną nazwą.",
	'farmer-confirmsetting' => 'Zapisz ustawienia Wiki',
	'farmer-confirmsetting-name' => 'Nazwa',
	'farmer-confirmsetting-title' => 'Tytuł',
	'farmer-confirmsetting-description' => 'Opis',
	'farmer-confirmsetting-reason' => 'Powód',
	'farmer-description' => 'Opis',
	'farmer-confirmsetting-text' => "Wiki '''$1''' będzie dostępna pod adresem $3.
Przestrzeń nazw projektu to '''$2'''.
Odnośniki do stron w tej przestrzeni będą postaci '''<nowiki>[[$2:Nazwa strony]]</nowiki>'''.
Jeśli wszystko się się zgadza, wciśnij znajdujący się poniżej przycisk '''Zapisz'''.",
	'farmer-button-confirm' => 'Zapisz',
	'farmer-button-submit' => 'Wyślij',
	'farmer-createwiki-form-title' => 'Utwórz Wiki',
	'farmer-createwiki-form-text1' => 'Użyj poniższego formularza aby utworzyć nową wiki.',
	'farmer-createwiki-form-help' => 'Pomoc',
	'farmer-createwiki-form-text2' => "; Nazwa wiki – jest to nazwa wiki.
Nazwa może zawierać wyłącznie litery i cyfry.
Będzie ona używana jako składowa adresu URL, by jednoznacznie ją identyfikować.
Jeżeli na przykład wprowadzisz nazwę '''las''', wiki będzie dostępna pod adresem <nowiki>http://</nowiki>'''las'''.mojadomena.",
	'farmer-createwiki-form-text3' => '; Tytuł wiki – jest to tytuł wiki.
Zostanie użyty jako tytuł na każdej stronie wiki.
Będzie także wykorzystywany jako nazwa przestrzeni projektu i przedrostek odnośników z innych wiki.',
	'farmer-createwiki-form-text4' => '; Opis – opis wiki.
Jest to tekst opisujący wiki.
Opis będzie wyświetlany w spisie wiki.',
	'farmer-createwiki-user' => 'Nazwa użytkownika',
	'farmer-createwiki-name' => 'Nazwa wiki',
	'farmer-createwiki-title' => 'Tytuł wiki',
	'farmer-createwiki-description' => 'Opis',
	'farmer-createwiki-reason' => 'Powód',
	'farmer-updatedlist' => 'Zaktualizowany spis',
	'farmer-notaccessible' => 'Niedostępna',
	'farmer-notaccessible-test' => 'Funkcja jest dostępna tylko w macierzystej wiki na farmie',
	'farmer-permissiondenied' => 'Dostęp zabroniony',
	'farmer-permissiondenied-text' => 'Nie masz uprawnień do usunięcia wiki z farmy',
	'farmer-permissiondenied-text1' => 'Nie masz uprawnień do dostępu do tej strony',
	'farmer-deleting' => 'Wiki „$1” została usunięta',
	'farmer-delete-confirm' => 'Potwierdzam, że chcę usunąć tę wiki',
	'farmer-delete-confirm-wiki' => "Wiki do usunięcia – '''$1'''.",
	'farmer-delete-reason' => 'Powód usunięcia',
	'farmer-delete-title' => 'Usuwanie Wiki',
	'farmer-delete-text' => 'Wybierz z poniższego spisu wiki, którą chcesz usunąć',
	'farmer-delete-form' => 'Wybierz wiki',
	'farmer-delete-form-submit' => 'Usuń',
	'farmer-listofwikis' => 'Spis wiki',
	'farmer-mainpage' => 'Strona główna',
	'farmer-basic-title' => 'Podstawowe parametry',
	'farmer-basic-title1' => 'Tytuł',
	'farmer-basic-title1-text' => 'Twoja wiki nie posiada tytułu. Ustaw go TERAZ',
	'farmer-basic-description' => 'Opis',
	'farmer-basic-description-text' => 'Ustaw poniżej opis dla swojej wiki',
	'farmer-basic-permission' => 'Uprawnienia',
	'farmer-basic-permission-text' => 'Używając poniższego formularza, można zmienić uprawnienia dla użytkowników tej wiki.',
	'farmer-basic-permission-visitor' => 'Uprawnienia dla wszystkich gości',
	'farmer-basic-permission-visitor-text' => 'Poniższe uprawnienia zostaną użyte dla każdej osoby, która odwiedzi tę wiki',
	'farmer-yes' => 'Tak',
	'farmer-no' => 'Nie',
	'farmer-basic-permission-user' => 'Dostęp dla zalogowanych użytkowników',
	'farmer-basic-permission-user-text' => 'Następujące uprawnienia zostaną użyte dla każdej osoby, która zaloguje się na tej wiki',
	'farmer-setpermission' => 'Ustaw uprawnienia',
	'farmer-defaultskin' => 'Domyślna skórka',
	'farmer-defaultskin-button' => 'Ustaw domyślną skórkę',
	'farmer-extensions' => 'Aktywne rozszerzenia',
	'farmer-extensions-button' => 'Ustaw aktywne rozszerzenia',
	'farmer-extensions-extension-denied' => 'Nie masz uprawnień by użyć tej funkcji.
Musisz być członkiem grupy farmeradmin',
	'farmer-extensions-invalid' => 'Niesprawne rozszerzenie',
	'farmer-extensions-invalid-text' => 'Nie można dodać rozszerzenia ponieważ wskazany do włączenia plik nie został odnaleziony',
	'farmer-extensions-available' => 'Dostępne rozszerzenia',
	'farmer-extensions-noavailable' => 'Brak zarejestrowanych rozszerzeń',
	'farmer-extensions-register' => 'Zarejestruj rozszerzenie',
	'farmer-extensions-register-text1' => 'Użyj poniższego formularza aby zarejestrować nowe rozszerzenie dla farmy.
Po zarejestrowaniu wszystkie wiki będą mogły korzystać z tego rozszerzenia.',
	'farmer-extensions-register-text2' => "Ustaw parametr ''Załącz plik'' na nazwę pliku PHP, podobnie jak w LocalSettings.php.",
	'farmer-extensions-register-text3' => "Jeżeli nazwa pliku zawiera '''\$root''', w miejsce tej zmiennej zostanie wstawione odwołanie do katalogu głównego MediaWiki.",
	'farmer-extensions-register-text4' => 'Bieżąca ścieżka dla dołączanych plików to',
	'farmer-extensions-register-name' => 'Nazwa',
	'farmer-extensions-register-includefile' => 'Załącz plik',
	'farmer-error-exists' => 'Nie można utworzyć wiki. Już istnieje: $1',
	'farmer-error-noextwrite' => 'Nie można zapisać pliku rozszerzenia:',
	'farmer-log-name' => 'Rejestr farmy wiki',
	'farmer-log-header' => 'Jest to rejestr zmian wykonanych w farmie wiki.',
	'farmer-log-create' => 'utworzył wiki „$2”',
	'farmer-log-delete' => 'usunął wiki „$2”',
	'right-farmeradmin' => 'Zarządzanie farmą wiki',
	'right-createwiki' => 'Tworzenie nowych wiki na farmie wiki',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'farmer' => 'Mansé',
	'farmer-desc' => 'Gestiss na fatorìa MediaWiki',
	'farmercantcreatewikis' => "It peule pa creé dle wiki përchè it l'has pa ël privilegi createwiki",
	'farmercreatesitename' => 'Nòm dël sit',
	'farmercreatenextstep' => 'Pass apress',
	'farmernewwikimainpage' => "== Bin ëvnù an soa wiki ==
S'a l'é an camin ch'a les sòn, soa neuva wiki a l'é stàita anstalà da bin.
A peul [[Special:Farmer|përsonalisé toa wiki]].",
	'farmer-about' => 'A propòsit',
	'farmer-about-text' => 'Mansé mediaWiki a-j përmët ëd gestì na fatorìa ëd wiki MediaWiki.',
	'farmer-list-wiki' => 'Lista ëd wiki',
	'farmer-list-wiki-text' => '[[$1|Listé]] tute le wiki dzora a {{SITENAME}}',
	'farmer-createwiki' => 'Crea na wiki',
	'farmer-createwiki-text' => '[[$1|Crea]] na neuva wiki adess!',
	'farmer-administration' => 'Aministrassion fatorìa',
	'farmer-administration-extension' => "Organisé j'estension",
	'farmer-administration-extension-text' => "[[$1|Organisé]] j'estension anstalà.",
	'farmer-admimistration-listupdate' => 'Agiorné la lista dle fatorìe',
	'farmer-admimistration-listupdate-text' => '[[$1|Modifiché]] la lista dle wiki dzora {{SITENAME}}',
	'farmer-administration-delete' => 'Scancelé na wiki',
	'farmer-administration-delete-text' => '[[$1|Scancelé]] na wiki da la fatorìa',
	'farmer-administer-thiswiki' => 'Aministra sta wiki-sì',
	'farmer-administer-thiswiki-text' => '[[$1|Aministré]] ij cangiament su sta wiki',
	'farmer-notavailable' => 'Pa disponìbil',
	'farmer-notavailable-text' => "Sta possibilità-sì a l'é mach disponìbil dzora a la wiki prinsipal",
	'farmer-wikicreated' => 'Wiki creà',
	'farmer-wikicreated-text' => "Soa wiki a l'é stàita creà.
A l'é acessìbil a $1",
	'farmer-default' => "Për sòlit, gnun a l'ha ij përmess su sta wiki-sì gavà che chiel.
A peule cangé ij privilegi dj'utent con $1",
	'farmer-wikiexists' => 'La wiki a esist',
	'farmer-wikiexists-text' => "La wiki '''$1''', ch'a vorìa creé, a esist già.
Për piasì, ch'a torna andré e ch'a preuva con n'àutr nòm.",
	'farmer-confirmsetting' => 'Conferma ampostassion dla wiki',
	'farmer-confirmsetting-name' => 'Nòm',
	'farmer-confirmsetting-title' => 'Tìtol',
	'farmer-confirmsetting-description' => 'Descrission',
	'farmer-confirmsetting-reason' => 'Rason',
	'farmer-description' => 'Descrission',
	'farmer-confirmsetting-text' => "Soa wiki, '''$1''', a sarà acessìbil via $3.
Lë spassi nominal dël proget a sarà '''$2'''.
Colegament a sto spassi nominal-sì a saran ëd la forma '''<nowiki>[[$2:Nòm pàgina]]</nowiki>'''.
Se sòn a l'é lòn ch'a veul, ch'a sgnaca ël boton '''conferma''' sì-sota.",
	'farmer-button-confirm' => 'Conferma',
	'farmer-button-submit' => 'Spediss',
	'farmer-createwiki-form-title' => 'Crea na wiki',
	'farmer-createwiki-form-text1' => 'Dovré ël formolari sì-sota për creé na neuva wiki.',
	'farmer-createwiki-form-help' => 'Agiut',
	'farmer-createwiki-form-text2' => "; Nòm wiki: Ël nòm ëd la wiki.
A conten mach litre e nùmer.
Ël nom ëd la wiki a sarà dovrà com part ëd l'adrëssa dl'aragnà për identifiché soa wiki.
Për esempi, s'a bat '''tìtol''', soa wiki a sarà acessìbil ansima a <nowiki>http://</nowiki>'''tìtol'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Tìtol ëd la wiki: Tìtol ëd la wiki.
A sarà dovrà ant ël tìtol ëd minca pàgina dzora a soa wiki.
A sarà ëdcò lë spassi nominal dël proget e ël prefiss antërwiki.',
	'farmer-createwiki-form-text4' => "; Descrission: Descission ëd la wiki.
Cost-sì a l'é un test ëd descrission ëd la wiki.
Sòn a sarà visualisà ant la lista dle wiki.",
	'farmer-createwiki-user' => 'Nòm utent',
	'farmer-createwiki-name' => 'Nòm dla wiki',
	'farmer-createwiki-title' => 'Tìtol dla wiki',
	'farmer-createwiki-description' => 'Descrission',
	'farmer-createwiki-reason' => 'Rason',
	'farmer-updatedlist' => 'Lista modificà',
	'farmer-notaccessible' => 'Pa acessìbil',
	'farmer-notaccessible-test' => "Sta possibilità-sì a l'é mach disponìbil ant la wiki mare ant la fatorìa",
	'farmer-permissiondenied' => 'Përmess negà',
	'farmer-permissiondenied-text' => "A l'ha pa ij përmess dë scancelé na wiki da la fatorìa",
	'farmer-permissiondenied-text1' => "It l'has pa ij përmess për vëdde sta pàgina-sì",
	'farmer-deleting' => 'La wiki "$1" a l\'é stàita scancelà',
	'farmer-delete-confirm' => 'I confermo che mi i veuj scancelé costa wiki',
	'farmer-delete-confirm-wiki' => "Wiki da scancelé: '''$1'''.",
	'farmer-delete-reason' => 'Rason për la scancelassion:',
	'farmer-delete-title' => 'Scancelé na wiki',
	'farmer-delete-text' => "Për piasì, ch'a selession-a da la lista sota la wiki ch'a veul scancelé",
	'farmer-delete-form' => 'Selession-a na wiki',
	'farmer-delete-form-submit' => 'Scancelé',
	'farmer-listofwikis' => 'Lista dle wiki',
	'farmer-mainpage' => 'Intrada',
	'farmer-basic-title' => 'Paràmeter ëd base',
	'farmer-basic-title1' => 'Tìtol',
	'farmer-basic-title1-text' => "Soa wiki a l'ha pa 'd tìtol. Ch'a na buta un <b>adess</b>",
	'farmer-basic-description' => 'Descrission',
	'farmer-basic-description-text' => "Ch'a buta sì-sota la descrission ëd soa wiki",
	'farmer-basic-permission' => 'Përmess',
	'farmer-basic-permission-text' => "An dovrand ël formolari sì-sota, a l'é possìbil modifiché ij përmess ëd j'utent dë sta wiki-sì.",
	'farmer-basic-permission-visitor' => 'Përmess për minca visitador',
	'farmer-basic-permission-visitor-text' => "Ij përmess sì-sota a saran aplicà a minca përson-a ch'a vìsita costa wiki",
	'farmer-yes' => 'É!',
	'farmer-no' => 'Nò',
	'farmer-basic-permission-user' => 'Përmess për utent intrà ant ël sistema',
	'farmer-basic-permission-user-text' => 'Ij përmess sì-sota a saran aplicà a minca përson-a che a intra ant ël sistema an costa wiki',
	'farmer-setpermission' => 'Ampòsta ij përmess',
	'farmer-defaultskin' => 'Pel stàndard',
	'farmer-defaultskin-button' => 'Ampòsta la pel dë stàndard',
	'farmer-extensions' => 'Estension ative',
	'farmer-extensions-button' => "Ampòsta j'estension ative",
	'farmer-extensions-extension-denied' => "A l'ha pa ij përmess ëd dovré sta possibilità-sì.
A deuv esse un mèmber ëd la partìa dj'aministrator dla fatorìa",
	'farmer-extensions-invalid' => 'Estension pa bon-a',
	'farmer-extensions-invalid-text' => "I podoma pa gionté l'estension përchè l'archivi selessionà për l'anclusion as treuva nen",
	'farmer-extensions-available' => 'Estension disponìbij',
	'farmer-extensions-noavailable' => 'A-i son gnun-e estension registrà',
	'farmer-extensions-register' => 'Registra estension',
	'farmer-extensions-register-text1' => "Ch'a deuvra ël formolari sì-sota për registré na neuva estension con la fatorìa.
Na vira che n'estension a l'é registrà, tute le wiki a podran dovrela.",
	'farmer-extensions-register-text2' => "Për ël paràmetr ''Anclud archivi'', ch'a buta ël nòm ëd l'archivi PHP ch'a veul an LocalSettings.php.",
	'farmer-extensions-register-text3' => "S'ël nòm dl'archivi a conten '''\$root''', cola variàbil a sarà rimpiassà con ël repertòri rèis ëd MediaWiki.",
	'farmer-extensions-register-text4' => "Al moment ij përcors d'anclud a son:",
	'farmer-extensions-register-name' => 'Nòm',
	'farmer-extensions-register-includefile' => 'Archivi da anclude',
	'farmer-error-exists' => 'La wiki as peul pa creesse. A esist già: $1',
	'farmer-error-noextwrite' => "A l'é impossìbil ëscrive j'archivi d'estension:",
	'farmer-log-name' => 'Registr ëd fatorìa wiki',
	'farmer-log-header' => "Cost-sì a l'é un registr dij cangiament fàit a la fatorìa wiki.",
	'farmer-log-create' => 'Creà la wiki "$2"',
	'farmer-log-delete' => 'a l\'ha scancelà la wiki "$2"',
	'right-farmeradmin' => 'Gestì la fatorìa wiki',
	'right-createwiki' => 'Creé dle wiki ant la fatorìa wiki',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'farmer' => 'بزګر',
	'farmercreatesitename' => 'د ويبځي نوم',
	'farmercreatenextstep' => 'بل ګام',
	'farmer-about' => 'په اړه',
	'farmer-list-wiki' => 'د ويکي ګانو لړليک',
	'farmer-createwiki' => 'يو ويکي جوړول',
	'farmer-administration-delete' => 'يو ويکي ړنګول',
	'farmer-wikicreated' => 'ويکي مو جوړ شو',
	'farmer-wikicreated-text' => 'ستاسې ويکي جوړ شو.
دا په $1 کې د لاسرسۍ وړ ده',
	'farmer-wikiexists' => 'ويکي مو شته',
	'farmer-confirmsetting-name' => 'نوم',
	'farmer-confirmsetting-title' => 'سرليک',
	'farmer-confirmsetting-reason' => 'سبب',
	'farmer-description' => 'څرګندونه',
	'farmer-button-submit' => 'سپارل',
	'farmer-createwiki-form-title' => 'يو ويکي جوړول',
	'farmer-createwiki-form-help' => 'لارښود',
	'farmer-createwiki-user' => 'کارن-نوم',
	'farmer-createwiki-name' => 'ويکي نوم',
	'farmer-createwiki-title' => 'ويکي سرليک',
	'farmer-createwiki-description' => 'څرګندونه',
	'farmer-createwiki-reason' => 'سبب',
	'farmer-permissiondenied' => 'د اجازې غوښتنه مو رد شوه',
	'farmer-permissiondenied-text1' => 'تاسې همدې مخ ته د لاسرسۍ پرېښله نلرۍ',
	'farmer-deleting' => 'د "$1" ويکي ړنګ شوی',
	'farmer-delete-title' => 'ويکي ړنګول',
	'farmer-delete-form' => 'يو ويکي وټاکۍ',
	'farmer-delete-form-submit' => 'ړنګول',
	'farmer-listofwikis' => 'د ويکي ګانو لړليک',
	'farmer-mainpage' => 'لومړی مخ',
	'farmer-basic-title1' => 'سرليک',
	'farmer-basic-title1-text' => 'ستاسې ويکي هېڅ يو سرليک هم نه لري. يو ورته وټاکۍ',
	'farmer-basic-description' => 'څرګندونه',
	'farmer-yes' => 'هو',
	'farmer-no' => 'نه',
	'farmer-extensions-register-name' => 'نوم',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Administre uma fazenda MediaWiki',
	'farmercantcreatewikis' => 'Não pode criar wikis porque não tem o privilégio "createwikis"',
	'farmercreatesitename' => 'Nome do site',
	'farmercreatenextstep' => 'Próximo passo',
	'farmernewwikimainpage' => '== Bem-vindo à sua Wiki ==
Se está a ler isto, a sua nova wiki foi correctamente instalada.
Pode agora [[Special:Farmer|personalizar a wiki]].',
	'farmer-about' => 'Sobre',
	'farmer-about-text' => 'MediaWiki Farmer permite-lhe gerir uma "fazenda" (um aglomerado) de wikis MediaWiki.',
	'farmer-list-wiki' => 'Lista de wikis',
	'farmer-list-wiki-text' => '[[$1|Listar]] todas as wikis na {{SITENAME}}',
	'farmer-createwiki' => 'Criar uma wiki',
	'farmer-createwiki-text' => '[[$1|Criar]] uma nova wiki agora!',
	'farmer-administration' => 'Administração da fazenda',
	'farmer-administration-extension' => 'Gerir extensões',
	'farmer-administration-extension-text' => '[[$1|Gerir]] extensões instaladas.',
	'farmer-admimistration-listupdate' => 'Actualização da lista da fazenda',
	'farmer-admimistration-listupdate-text' => '[[$1|Actualize]] a lista das wikis na {{SITENAME}}',
	'farmer-administration-delete' => 'Eliminar uma wiki',
	'farmer-administration-delete-text' => '[[$1|Eliminar]] uma wiki da fazenda',
	'farmer-administer-thiswiki' => 'Administrar esta wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administrar]] alterações a esta wiki',
	'farmer-notavailable' => 'Indisponível',
	'farmer-notavailable-text' => 'Esta funcionalidade só está disponível na wiki principal',
	'farmer-wikicreated' => 'Wiki criada',
	'farmer-wikicreated-text' => 'A sua wiki foi criada.
Está acessível em $1',
	'farmer-default' => 'Por omissão, ninguém excepto você tem permissões nesta wiki.
Pode alterar os privilégios dos utilizadores em $1',
	'farmer-wikiexists' => 'A wiki existe',
	'farmer-wikiexists-text' => "A wiki que está a tentar criar, '''$1''', já existe.
Por favor, volte atrás e introduza outro nome.",
	'farmer-confirmsetting' => 'Confirmar a configuração da wiki',
	'farmer-confirmsetting-name' => 'Nome',
	'farmer-confirmsetting-title' => 'Título',
	'farmer-confirmsetting-description' => 'Descrição',
	'farmer-confirmsetting-reason' => 'Motivo',
	'farmer-description' => 'Descrição',
	'farmer-confirmsetting-text' => "A sua wiki, '''$1''', estará acessível em $3.
O espaço nominal do projecto será '''$2'''.
Links para este espaço nominal terão o formato '''<nowiki>[[$2:Nome da página]]</nowiki>'''.
Se é isto que pretende, clique o botão '''confirmar''' abaixo.",
	'farmer-button-confirm' => 'Confirmar',
	'farmer-button-submit' => 'Enviar',
	'farmer-createwiki-form-title' => 'Criar uma wiki',
	'farmer-createwiki-form-text1' => 'Utilize o formulário abaixo para criar uma nova wiki.',
	'farmer-createwiki-form-help' => 'Ajuda',
	'farmer-createwiki-form-text2' => "; Nome da wiki: Contém apenas letras e números. O nome da wiki será usado como parte da URL para identificar a sua wiki. Por exemplo, se introduzir '''titulo''', então a sua wiki será acedida através de <nowiki>http://</nowiki>'''titulo'''.meudominio.",
	'farmer-createwiki-form-text3' => '; Título da wiki: Será usado no título de cada página na sua wiki. Será também o espaço nominal de projecto e o prefixo de interwikis.',
	'farmer-createwiki-form-text4' => '; Descrição: Descrição da wiki. Esta é uma descrição textual da wiki, própria do MediaWiki Farmer. Será mostrada na lista das wikis.',
	'farmer-createwiki-user' => 'Nome de utilizador',
	'farmer-createwiki-name' => 'Nome da wiki',
	'farmer-createwiki-title' => 'Título da wiki',
	'farmer-createwiki-description' => 'Descrição',
	'farmer-createwiki-reason' => 'Motivo',
	'farmer-updatedlist' => 'Lista actualizada',
	'farmer-notaccessible' => 'Inacessível',
	'farmer-notaccessible-test' => 'Esta funcionalidade só está disponível na wiki principal da fazenda',
	'farmer-permissiondenied' => 'Permissão negada',
	'farmer-permissiondenied-text' => 'Não tem permissão para eliminar uma wiki da fazenda',
	'farmer-permissiondenied-text1' => 'Não tem permissão para aceder a esta página',
	'farmer-deleting' => 'A wiki "$1" foi eliminada',
	'farmer-delete-confirm' => 'Confirmo que pretendo eliminar esta wiki',
	'farmer-delete-confirm-wiki' => "Wiki a eliminar: '''$1'''.",
	'farmer-delete-reason' => 'Motivo da eliminação:',
	'farmer-delete-title' => 'Eliminar Wiki',
	'farmer-delete-text' => 'Por favor, seleccione a wiki que deseja eliminar da lista abaixo',
	'farmer-delete-form' => 'Seleccione uma wiki',
	'farmer-delete-form-submit' => 'Eliminar',
	'farmer-listofwikis' => 'Lista das wikis',
	'farmer-mainpage' => 'Página Principal',
	'farmer-basic-title' => 'Parâmetros básicos',
	'farmer-basic-title1' => 'Título',
	'farmer-basic-title1-text' => 'A sua wiki não tem um título. Escolha um <b>agora<b>',
	'farmer-basic-description' => 'Descrição',
	'farmer-basic-description-text' => 'Introduza a descrição da sua wiki abaixo',
	'farmer-basic-permission' => 'Permissões',
	'farmer-basic-permission-text' => 'Usando o formulário abaixo, é possível alterar as permissões dos utilizadores desta wiki.',
	'farmer-basic-permission-visitor' => 'Permissões para todos os visitantes',
	'farmer-basic-permission-visitor-text' => 'As seguinte permissões serão aplicadas a todas as pessoas que visitem esta wiki',
	'farmer-yes' => 'Sim',
	'farmer-no' => 'Não',
	'farmer-basic-permission-user' => 'Permissões para utilizadores autenticados',
	'farmer-basic-permission-user-text' => 'As seguintes permissões serão aplicadas a todas as pessoas que se autentiquem nesta wiki',
	'farmer-setpermission' => 'Aplicar permissões',
	'farmer-defaultskin' => 'Tema padrão',
	'farmer-defaultskin-button' => 'Configurar tema por omissão',
	'farmer-extensions' => 'Extensões activas',
	'farmer-extensions-button' => 'Configurar extensões activas',
	'farmer-extensions-extension-denied' => 'Não tem permissão para usar esta funcionalidade.
Tem de ser membro do grupo "farmeradmin"',
	'farmer-extensions-invalid' => 'Extensão inválida',
	'farmer-extensions-invalid-text' => 'Não foi possível adicionar a extensão porque o ficheiro seleccionado para inclusão não foi encontrado',
	'farmer-extensions-available' => 'Extensões disponíveis',
	'farmer-extensions-noavailable' => 'Nenhuma extensão está registada',
	'farmer-extensions-register' => 'Registar extensão',
	'farmer-extensions-register-text1' => 'Use o seguinte formulário para registar uma nova extensão na fazenda.
Uma vez registada, todas as wikis podem usar a extensão.',
	'farmer-extensions-register-text2' => "Para o parâmetro ''Ficheiro a incluir'', introduza o nome do ficheiro PHP tal como faria no LocalSettings.php.",
	'farmer-extensions-register-text3' => "Se o nome do ficheiro contiver '''\$root''', essa variável será substituída pelo directório base do MediaWiki.",
	'farmer-extensions-register-text4' => 'Os caminhos de inclusão actuais são:',
	'farmer-extensions-register-name' => 'Nome',
	'farmer-extensions-register-includefile' => 'Ficheiro a incluir',
	'farmer-error-exists' => 'Não é possível criar a wiki. Ela já existe: $1',
	'farmer-error-noextwrite' => 'Não foi possível escrever o ficheiro de extensão:',
	'farmer-log-name' => 'Registo da fazenda',
	'farmer-log-header' => 'Este é um registo das alterações feitas na fazenda de wikis.',
	'farmer-log-create' => 'criou a wiki "$2"',
	'farmer-log-delete' => 'eliminou a wiki "$2"',
	'right-farmeradmin' => 'Administrar a fazenda de wikis',
	'right-createwiki' => 'Criar wikis na fazenda',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Crazymadlover
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Gerencie uma "farm" MediaWiki',
	'farmercantcreatewikis' => 'Você não pode criar wikis porque não possui o privilégio "createwikis"',
	'farmercreatesitename' => 'Nome do sítio',
	'farmercreatenextstep' => 'Próximo passo',
	'farmernewwikimainpage' => '== Bem-vindo ao seu Wiki ==
Se está a ler isto, o seu wiki foi corretamente instalado.
Pode agora [[Special:Farmer|personalizar o seu wiki]].',
	'farmer-about' => 'Sobre',
	'farmer-about-text' => 'MediaWiki Farmer permite-lhe gerenciar uma "farm" de wikis MediaWiki.',
	'farmer-list-wiki' => 'Lista de Wikis',
	'farmer-list-wiki-text' => '[[$1|Listar]] todos os wikis em {{SITENAME}}',
	'farmer-createwiki' => 'Criar um Wiki',
	'farmer-createwiki-text' => '[[$1|Criar]] um novo wiki já!',
	'farmer-administration' => 'Administração da "Farm"',
	'farmer-administration-extension' => 'Gerenciar Extensões',
	'farmer-administration-extension-text' => '[[$1|Gerenciar]] extensões instaladas.',
	'farmer-admimistration-listupdate' => 'Atualização da Lista da "Farm"',
	'farmer-admimistration-listupdate-text' => '[[$1|Atualize]] a lista de wikis em {{SITENAME}}',
	'farmer-administration-delete' => 'Apagar um Wiki',
	'farmer-administration-delete-text' => '[[$1|Apagar]] um wiki da "farm"',
	'farmer-administer-thiswiki' => 'Gerenciar este Wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administrar]] alterações a este wiki',
	'farmer-notavailable' => 'Não disponível',
	'farmer-notavailable-text' => 'Esta funcionalidade só está disponível no wiki principal',
	'farmer-wikicreated' => 'Wiki criado',
	'farmer-wikicreated-text' => 'O seu wiki foi criado. Ele está acessível em $1',
	'farmer-default' => 'Por padrão, ninguém tem permissões neste wiki à exceção de você. Pode alterar os privilégios dos utilizadores em $1',
	'farmer-wikiexists' => 'O wiki existe',
	'farmer-wikiexists-text' => "O wiki que está tentando criar, '''$1''', já existe. Por favor, volte e introduza um outro nome.",
	'farmer-confirmsetting' => 'Confirmar Configuração do Wiki',
	'farmer-confirmsetting-name' => 'Nome',
	'farmer-confirmsetting-title' => 'Título',
	'farmer-confirmsetting-description' => 'Descrição',
	'farmer-confirmsetting-reason' => 'Motivo',
	'farmer-description' => 'Descrição',
	'farmer-confirmsetting-text' => "O seu wiki, '''$1''', estará acessível através de $3.
O espaço nominal do projeto será '''$2'''.
Ligações para este espaço nominal terão o formato '''<nowiki>[[$2:Nome da página]]</nowiki>'''.
Se é isto que pretende, pressione o botão '''confirmar''' abaixo.",
	'farmer-button-confirm' => 'Confirmar',
	'farmer-button-submit' => 'Enviar',
	'farmer-createwiki-form-title' => 'Criar um Wiki',
	'farmer-createwiki-form-text1' => 'Utilize o formulário abaixo para criar um novo wiki.',
	'farmer-createwiki-form-help' => 'Ajuda',
	'farmer-createwiki-form-text2' => "; Nome do wiki: Contém apenas letras e números. O nome do wiki será usado como parte da URL para identificar o seu wiki. Por exemplo, se introduzir '''titulo''', então o seu wiki será acessado através de <nowiki>http://</nowiki>'''titulo'''.meudominio.",
	'farmer-createwiki-form-text3' => '; Título do wiki: Será usado no título de cada página no seu wiki. Será também o espaço nominal de projeto e o prefixo interwiki.',
	'farmer-createwiki-form-text4' => '; Descrição: Descrição do wiki. Este é a descrição textual sobre o wiki. Será mostrada na lista de wikis.',
	'farmer-createwiki-user' => 'Nome de utilizador',
	'farmer-createwiki-name' => 'Nome do Wiki',
	'farmer-createwiki-title' => 'Título do Wiki',
	'farmer-createwiki-description' => 'Descrição',
	'farmer-createwiki-reason' => 'Motivo',
	'farmer-updatedlist' => 'Lista atualizada',
	'farmer-notaccessible' => 'Não acessível',
	'farmer-notaccessible-test' => 'Esta funcionalidade só está disponível no wiki pai da "farm"',
	'farmer-permissiondenied' => 'Permissão negada',
	'farmer-permissiondenied-text' => 'Não tem permissão para apagar um wiki da "farm"',
	'farmer-permissiondenied-text1' => 'Não tem permissão para acessar esta página',
	'farmer-deleting' => 'A wiki "$1" foi removida',
	'farmer-delete-confirm' => 'Eu confirmo que pretendo eliminar este wiki',
	'farmer-delete-confirm-wiki' => "Wiki a apagar: '''$1'''.",
	'farmer-delete-reason' => 'Motivo da eliminação:',
	'farmer-delete-title' => 'Apagar Wiki',
	'farmer-delete-text' => 'Por favor, seleccione o wiki que deseja apagar na lista abaixo',
	'farmer-delete-form' => 'Selecione um wiki',
	'farmer-delete-form-submit' => 'Apagar',
	'farmer-listofwikis' => 'Lista de Wikis',
	'farmer-mainpage' => 'Página Principal',
	'farmer-basic-title' => 'Parâmetros Básicos',
	'farmer-basic-title1' => 'Título',
	'farmer-basic-title1-text' => 'O seu wiki não tem um título. Escolha um <b>agora</b>',
	'farmer-basic-description' => 'Descrição',
	'farmer-basic-description-text' => 'Introduza a descrição do seu wiki abaixo',
	'farmer-basic-permission' => 'Permissões',
	'farmer-basic-permission-text' => 'Usando o seguinte formulário, é possível alterar as permissões dos utilizadores deste wiki.',
	'farmer-basic-permission-visitor' => 'Permissões para cada visitante',
	'farmer-basic-permission-visitor-text' => 'As seguinte permissões serão aplicadas a todas as pessoas que visitem este wiki',
	'farmer-yes' => 'Sim',
	'farmer-no' => 'Não',
	'farmer-basic-permission-user' => 'Permissões para Utilizadores Autenticados',
	'farmer-basic-permission-user-text' => 'As seguintes permissões serão aplicadas a todas as pessoas que se autentiquem neste wiki',
	'farmer-setpermission' => 'Aplicar Permissões',
	'farmer-defaultskin' => 'Tema padrão',
	'farmer-defaultskin-button' => 'Configurar tema padrão',
	'farmer-extensions' => 'Extensões Ativas',
	'farmer-extensions-button' => 'Aplicar Extensões Ativas',
	'farmer-extensions-extension-denied' => 'Você não tem permissão para usar esta funcionalidade.
Você deve ser membro do grupo "farmeradmin"',
	'farmer-extensions-invalid' => 'Extensão Inválida',
	'farmer-extensions-invalid-text' => 'Não foi possível adicionar a extensão porque o arquivo seleciondo para inclusão não foi encontrado',
	'farmer-extensions-available' => 'Extensões Disponíveis',
	'farmer-extensions-noavailable' => 'Nenhuma extensão está registrada',
	'farmer-extensions-register' => 'Registrar Extensão',
	'farmer-extensions-register-text1' => 'Use o seguinte formulário para registrar uma nova extensão na "farm".  Uma vez registrada a extensão, todos os wikis poderão usá-la.',
	'farmer-extensions-register-text2' => "Para o parâmetro ''Arquivo de Inclusão'', introduza o nome do arquivo PHP tal como ficaria em LocalSettings.php.",
	'farmer-extensions-register-text3' => "Se o nome do arquivo contiver '''\$root''', essa variável será substituída pelo diretório raiz do MediaWiki.",
	'farmer-extensions-register-text4' => 'Os caminhos de inclusão atuais são:',
	'farmer-extensions-register-name' => 'Nome',
	'farmer-extensions-register-includefile' => 'Arquivo de Inclusão',
	'farmer-error-exists' => 'Não é possível criar wiki. Este já existe: $1',
	'farmer-error-noextwrite' => 'Não foi possível escrever o arquivo de extensão:',
	'farmer-log-name' => 'Registro da "farm" de wikis',
	'farmer-log-header' => 'Esse é um registro das mudanças feitas à "farm" de wikis',
	'farmer-log-create' => 'criou o wiki "$2"',
	'farmer-log-delete' => 'eliminou o wiki "$2"',
	'right-farmeradmin' => 'Gerenciar uma "farm" de wikis',
	'right-createwiki' => 'Criar wikis em uma "farm" de wikis',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'farmer-createwiki-form-help' => 'AƐawn',
	'farmer-delete-form-submit' => 'Sfaḍ',
	'farmer-mainpage' => 'Tasbtirt Tamzwarut',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'farmer' => 'Fermier',
	'farmercantcreatewikis' => 'Sunteţi în imposibilitatea de a crea wiki-uri, deoarece nu aveţi privilegiul createwikis',
	'farmercreatesitename' => 'Numele site-ului',
	'farmercreatenextstep' => 'Pasul următor',
	'farmer-about' => 'Despre',
	'farmer-list-wiki' => 'Listă de wiki',
	'farmer-createwiki' => 'Creează wiki',
	'farmer-createwiki-text' => '[[$1|Creează]] wiki nou acum!',
	'farmer-administration-extension' => 'Administrează extensiile',
	'farmer-administration-extension-text' => '[[$1|Administrează]] extensiile instalate.',
	'farmer-administration-delete' => 'Şterge wiki',
	'farmer-administer-thiswiki' => 'Administrează acest wiki',
	'farmer-notavailable' => 'Nu este disponibil',
	'farmer-notavailable-text' => 'Această funcţionalitate este disponibilă doar pe wiki-ul principal',
	'farmer-wikicreated' => 'Wiki creat',
	'farmer-wikicreated-text' => 'Wiki-ul a fost creat.
Este accesibil la $1',
	'farmer-default' => 'În mod implicit, nimeni nu are permisiuni pe acest wiki cu excepţia dvs.
Puteţi schimba privilegile utilizatorilor prin $1',
	'farmer-wikiexists' => 'Wiki există',
	'farmer-confirmsetting' => 'Confirmați setările wiki',
	'farmer-confirmsetting-name' => 'Nume',
	'farmer-confirmsetting-title' => 'Titlu',
	'farmer-confirmsetting-description' => 'Descriere',
	'farmer-confirmsetting-reason' => 'Motiv',
	'farmer-description' => 'Descriere',
	'farmer-button-confirm' => 'Confirmă',
	'farmer-button-submit' => 'Trimite',
	'farmer-createwiki-form-title' => 'Creează wiki',
	'farmer-createwiki-form-text1' => 'Foloseşte formularul de mai jos pentru a crea un nou wiki.',
	'farmer-createwiki-form-help' => 'Ajutor',
	'farmer-createwiki-user' => 'Nume de utilizator',
	'farmer-createwiki-name' => 'Nume wiki',
	'farmer-createwiki-title' => 'Titlu wiki',
	'farmer-createwiki-description' => 'Descriere',
	'farmer-createwiki-reason' => 'Motiv',
	'farmer-updatedlist' => 'Listă actualizată',
	'farmer-notaccessible' => 'Inaccesibil',
	'farmer-permissiondenied' => 'Permisiune refuzată',
	'farmer-permissiondenied-text1' => 'Nu aveţi permisiunea de a accesa această pagină',
	'farmer-deleting' => 'Wiki-ul "$1" a fost șters',
	'farmer-delete-confirm' => 'Confirm că vreau să șterg acest wiki',
	'farmer-delete-confirm-wiki' => "Wiki de șters: '''$1'''.",
	'farmer-delete-reason' => 'Motiv pentru ștergere:',
	'farmer-delete-title' => 'Şterge wiki',
	'farmer-delete-text' => 'Vă rugăm alegeţi wiki-ul din lista de mai jos pe care doriţi să îl ştergeţi',
	'farmer-delete-form' => 'Alegeți un wiki',
	'farmer-delete-form-submit' => 'Şterge',
	'farmer-listofwikis' => 'Listă de wiki',
	'farmer-mainpage' => 'Pagina principală',
	'farmer-basic-title' => 'Parametri de bază',
	'farmer-basic-title1' => 'Titlu',
	'farmer-basic-title1-text' => 'Wiki-ul tău nu are un titlu. Setează unul <b>acum</b>',
	'farmer-basic-description' => 'Descriere',
	'farmer-basic-permission' => 'Permisiuni',
	'farmer-basic-permission-visitor' => 'Permisiuni pentru fiecare utilizator',
	'farmer-basic-permission-visitor-text' => 'Următoarele permisiuni vor fi aplicate fiecărui utilizator care vizitează acest wiki',
	'farmer-yes' => 'Da',
	'farmer-no' => 'Nu',
	'farmer-basic-permission-user' => 'Permisiuni pentru utilizatori autentificați',
	'farmer-basic-permission-user-text' => 'Următoarele permisiuni vor fi aplicate fiecărei persoane care se autentifică în acest wiki',
	'farmer-setpermission' => 'Setați permisiunile',
	'farmer-defaultskin' => 'Stil implicit',
	'farmer-defaultskin-button' => 'Setează interfaţa implicită',
	'farmer-extensions' => 'Extensii active',
	'farmer-extensions-button' => 'Setează exteniile active',
	'farmer-extensions-invalid' => 'Extensie incorectă',
	'farmer-extensions-available' => 'Extensii disponibile',
	'farmer-extensions-noavailable' => 'Nici o extensie înregistrată',
	'farmer-extensions-register' => 'Înregistrează extensie',
	'farmer-extensions-register-name' => 'Nume',
	'farmer-extensions-register-includefile' => 'Include fișier',
	'farmer-error-exists' => 'Nu se poate crea wiki. Există deja: $1',
	'farmer-log-name' => 'Jurnal wiki fermă',
	'farmer-log-create' => 'creat wiki "$2"',
	'farmer-log-delete' => 'șters wiki "$2"',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'farmercreatesitename' => "Nome d'u site",
	'farmer-list-wiki' => 'Elenghe de le Uicchi',
	'farmer-notavailable' => 'Non disponibbile',
	'farmer-wikicreated' => 'Uicchi ccrejate',
	'farmer-confirmsetting-name' => 'Nome',
	'farmer-confirmsetting-title' => 'Titele',
	'farmer-confirmsetting-description' => 'Descrizione',
	'farmer-description' => 'Descrizione',
	'farmer-createwiki-form-help' => 'Ajiute',
	'farmer-createwiki-description' => 'Descrizione',
	'farmer-createwiki-reason' => 'Mutive',
	'farmer-delete-form-submit' => 'Scangille',
	'farmer-basic-title1' => 'Titele',
	'farmer-basic-description' => 'Descrizione',
	'farmer-extensions-register-name' => 'Nome',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Kaganer
 * @author Putnik
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'farmer' => 'Фермер',
	'farmer-desc' => 'Управление фермой MediaWiki',
	'farmercantcreatewikis' => 'Вы не можете создать вики, так как не имеете соответствующих прав.',
	'farmercreatesitename' => 'Имя сайта',
	'farmercreatenextstep' => 'Следующий шаг',
	'farmernewwikimainpage' => '== Добро пожаловать в свой вики-проект ==
Если вы читаете это сообщение, значит ваш новый вики-проект успешно и правильно установлен.
Теперь можно заняться [[Special:Farmer|дальнейшей настройкой]].',
	'farmer-about' => 'О расширении',
	'farmer-about-text' => 'Расширение «Фермер» (MediaWiki Farmer) позволяет вам управлять фермой (группой серверов) вики.',
	'farmer-list-wiki' => 'Список вики',
	'farmer-list-wiki-text' => '[[$1|Список]] всех вики на сайте {{SITENAME}}',
	'farmer-createwiki' => 'Создать вики',
	'farmer-createwiki-text' => '[[$1|Создать]] новую вики!',
	'farmer-administration' => 'Администрирование фермы',
	'farmer-administration-extension' => 'Управление расширениями',
	'farmer-administration-extension-text' => '[[$1|Управление]] установленными расширениями.',
	'farmer-admimistration-listupdate' => 'Обновление списка ферм',
	'farmer-admimistration-listupdate-text' => '[[$1|Обновление]] списка вики на сайте {{SITENAME}}',
	'farmer-administration-delete' => 'Удаление вики',
	'farmer-administration-delete-text' => '[[$1|Удалить]] вики с фермы',
	'farmer-administer-thiswiki' => 'Администрировать эту вики',
	'farmer-administer-thiswiki-text' => '[[$1|Административные]] изменения в этой вики',
	'farmer-notavailable' => 'недоступна',
	'farmer-notavailable-text' => 'Эта возможность доступна только на главной вики',
	'farmer-wikicreated' => 'Вики создана',
	'farmer-wikicreated-text' => 'Ваша вики была создана. Она доступна по $1',
	'farmer-default' => 'По умолчанию, никто, кроме вас, в этой вики не имеет прав.
Вы можете поменять права участников с помощью $1',
	'farmer-wikiexists' => 'Вики существует',
	'farmer-wikiexists-text' => "Вики '''$1''', которую вы попытались создать, уже существует. Пожалуйста, вернитесь и попробуйте другое имя.",
	'farmer-confirmsetting' => 'Подтвердить настройки вики',
	'farmer-confirmsetting-name' => 'Имя',
	'farmer-confirmsetting-title' => 'Заголовок',
	'farmer-confirmsetting-description' => 'Описание',
	'farmer-confirmsetting-reason' => 'Причина',
	'farmer-description' => 'Описание',
	'farmer-confirmsetting-text' => "Ваша вики '''$1''' будет доступна по $3.
Пространство имён проекта будет '''$2'''.
Ссылки на это пространство имён будут вида '''<nowiki>[[$2:Название страницы]]</nowiki>'''.
Если это то, чего вы хотите, нажмите кнопку «подтвердить» ниже.",
	'farmer-button-confirm' => 'Подтвердить',
	'farmer-button-submit' => 'Отправить',
	'farmer-createwiki-form-title' => 'Создание вики',
	'farmer-createwiki-form-text1' => 'Используйте данную форму, чтобы создать новую вики.',
	'farmer-createwiki-form-help' => 'Справка',
	'farmer-createwiki-form-text2' => "; Имя вики: Это название вашей вики. Может содержать только латинские буквы и цифры. Имя вики будет использоваться как часть URL-адреса. Например, если вы введёте '''title''', то ваша вики будет доступна по  <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Заголовок вики: Заголовок вики будет использовать в названии каждой страницы вашей вики, кроме того, такое значение будут иметь пространство имён проекта и интервики-приставка.',
	'farmer-createwiki-form-text4' => '; Описание: Описание вики — это текстовое описание, которое будет показываться в списке вики.',
	'farmer-createwiki-user' => 'Имя участника',
	'farmer-createwiki-name' => 'Имя вики',
	'farmer-createwiki-title' => 'Заголовок вики',
	'farmer-createwiki-description' => 'Описание',
	'farmer-createwiki-reason' => 'Причина',
	'farmer-updatedlist' => 'Обновлённый список',
	'farmer-notaccessible' => 'не доступна',
	'farmer-notaccessible-test' => 'Эта функция доступна только на родительской вике фермы',
	'farmer-permissiondenied' => 'В разрешении отказано',
	'farmer-permissiondenied-text' => 'У вас нет разрешения удалять вики с фермы',
	'farmer-permissiondenied-text1' => 'У вас нет разрешения на доступ к этой странице',
	'farmer-deleting' => 'Вики «$1» была удалена',
	'farmer-delete-confirm' => 'Я подтверждаю, что я хочу удалить эту вики',
	'farmer-delete-confirm-wiki' => "Вики для удаления: '''$1'''.",
	'farmer-delete-reason' => 'Причина удаления:',
	'farmer-delete-title' => 'Удаление вики',
	'farmer-delete-text' => 'Пожалуйста, выберите из списка вики, которую вы хотите удалить',
	'farmer-delete-form' => 'Выбор вики',
	'farmer-delete-form-submit' => 'Удалить',
	'farmer-listofwikis' => 'Список вики',
	'farmer-mainpage' => 'Главная страница',
	'farmer-basic-title' => 'Основные параметры',
	'farmer-basic-title1' => 'Заголовок',
	'farmer-basic-title1-text' => 'Ваша вики не имеет заголовка. Установите его СЕЙЧАС',
	'farmer-basic-description' => 'Описание',
	'farmer-basic-description-text' => 'Ниже можно дать описание вашей вики',
	'farmer-basic-permission' => 'Права',
	'farmer-basic-permission-text' => 'Используя данную форму, можно управлять правами участников этой вики',
	'farmer-basic-permission-visitor' => 'Права любого посетителя',
	'farmer-basic-permission-visitor-text' => 'Следующими правами будет обладать любой посетитель этой вики',
	'farmer-yes' => 'Да',
	'farmer-no' => 'Нет',
	'farmer-basic-permission-user' => 'Права зарегистрированных участников',
	'farmer-basic-permission-user-text' => 'Следующими правами обладает каждый зарегистрированный участник этой вики',
	'farmer-setpermission' => 'Установить права',
	'farmer-defaultskin' => 'Тема оформления по умолчанию',
	'farmer-defaultskin-button' => 'Установить тему оформления по умолчанию',
	'farmer-extensions' => 'Действующие расширения',
	'farmer-extensions-button' => 'Установить действующие расширения',
	'farmer-extensions-extension-denied' => 'У вас нет прав использовать эту функцию. Вы должны быть членом группы администраторов фермы (farmeradmin)',
	'farmer-extensions-invalid' => 'Ошибочное расширение',
	'farmer-extensions-invalid-text' => 'Вы не можете добавить расширение, так как выбранный для добавления файл не существует',
	'farmer-extensions-available' => 'Доступные расширения',
	'farmer-extensions-noavailable' => 'Расширений не зарегистрировано',
	'farmer-extensions-register' => 'Зарегистрировать расширение',
	'farmer-extensions-register-text1' => 'Эту форму можно использовать для регистрации нового расширения на ферме. После того, как расширение зарегистрировано, все вики смогут его использовать.',
	'farmer-extensions-register-text2' => "Параметр ''Include-файле'' должен содержать имя PHP-файла, в том виде, как оно должно быть указано в LocalSettings.php.",
	'farmer-extensions-register-text3' => "Если имя файла содержит '''\$root''', то эта переменная будет заменена на корневую директорию MediaWiki.",
	'farmer-extensions-register-text4' => 'Текущие пути include:',
	'farmer-extensions-register-name' => 'Имя',
	'farmer-extensions-register-includefile' => 'Include-файл',
	'farmer-error-exists' => 'Невозможно создать вики. Она уже существует: $1',
	'farmer-error-noextwrite' => 'Невозможно выписать файл расширения:',
	'farmer-log-name' => 'Журнал вики-фермы',
	'farmer-log-header' => 'Это журнал изменений, сделанных на вики-ферме.',
	'farmer-log-create' => 'создана вики «$2»',
	'farmer-log-delete' => 'удалена вики «$2»',
	'right-farmeradmin' => 'управление вики-фермой',
	'right-createwiki' => 'создание вики на вики-ферме',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'farmer-confirmsetting-name' => 'Мено',
	'farmer-confirmsetting-title' => 'Назва',
	'farmer-confirmsetting-description' => 'Попис',
	'farmer-confirmsetting-reason' => 'Причіна',
	'farmer-description' => 'Попис',
	'farmer-createwiki-user' => 'Мено хоснователя:',
	'farmer-createwiki-name' => 'Вікі мено',
	'farmer-createwiki-description' => 'Попис',
	'farmer-createwiki-reason' => 'Причіна',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'farmer-confirmsetting-name' => 'Nomu',
	'farmer-confirmsetting-title' => 'Tìtulu',
	'farmer-confirmsetting-reason' => 'Mutivu',
	'farmer-createwiki-reason' => 'Mutivu',
	'farmer-mainpage' => 'Pàggina principali',
	'farmer-basic-title1' => 'Tìtulu',
	'farmer-yes' => 'Sì',
	'farmer-no' => 'Nò',
	'farmer-extensions-register-name' => 'Nomu',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'farmer-button-submit' => 'Unesi',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'farmer' => 'Farmár',
	'farmer-desc' => 'Správa farmy MediaWiki',
	'farmercantcreatewikis' => 'Nemôžete vytvárať wiki, pretože nemáte oprávnenie createwikis',
	'farmercreatesitename' => 'Názov lokality',
	'farmercreatenextstep' => 'Ďalší krok',
	'farmernewwikimainpage' => '== Vitajte vo svojej wiki ==
Ak čítate tento text, vaša nová wiki bola správne nainštalovaná.
Svoju wiki môžete [[Special:Farmer|prispôsobiť]].',
	'farmer-about' => 'O stránke',
	'farmer-about-text' => 'MediaWiki Farmár vám umožňuje spravovať farmu wiki systému MediaWiki.',
	'farmer-list-wiki' => 'Zoznam wiki',
	'farmer-list-wiki-text' => '[[$1|Zoznam]] všetkých wiki na {{GRAMMAR:lokál|{{SITENAME}}}}',
	'farmer-createwiki' => 'Vytvoriť wiki',
	'farmer-createwiki-text' => '[[$1|Vytvorte]] teraz novú wiki!',
	'farmer-administration' => 'Správa farmy',
	'farmer-administration-extension' => 'Spravovať rozšírenia',
	'farmer-administration-extension-text' => '[[$1|Spravovať]] nainštalované rozšírenia.',
	'farmer-admimistration-listupdate' => 'Aktualizácia zoznamu fariem',
	'farmer-admimistration-listupdate-text' => '[[$1|Aktualizovať]] zoznam wiki na {{GRAMMAR:lokál|{{SITENAME}}}}',
	'farmer-administration-delete' => 'Zmazať wiki',
	'farmer-administration-delete-text' => '[[$1|Zmazať]] wiki z farmy',
	'farmer-administer-thiswiki' => 'Spravovať túto wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Spravovať]] zmeny tejto wiki',
	'farmer-notavailable' => 'Nedostupné',
	'farmer-notavailable-text' => 'Táto vlastnosť je dostupná iba na hlavnej wiki',
	'farmer-wikicreated' => 'Wiki bola vytvorená',
	'farmer-wikicreated-text' => 'Vaša wiki bola vytvorená. Je prístupná na $1',
	'farmer-default' => 'Štandardne nemá nikto privilégiá na tejto wiki okrem vás. Privilégiá používateľov môžete zmeniť prostredníctvom $1',
	'farmer-wikiexists' => 'Wiki existuje',
	'farmer-wikiexists-text' => "Wiki, ktorú ste sa pokúsili vytvoriť, '''$1''', už existuje. Prosím, choďte späť a skúste iný názov.",
	'farmer-confirmsetting' => 'Potvrdiť nastavenia wiki',
	'farmer-confirmsetting-name' => 'Názov',
	'farmer-confirmsetting-title' => 'Nadpis',
	'farmer-confirmsetting-description' => 'Popis',
	'farmer-confirmsetting-reason' => 'Dôvod',
	'farmer-description' => 'Popis',
	'farmer-confirmsetting-text' => "Vaša wiki, '''$1''', bude prístupná na $3.
Menný priestor projekt bude '''$2'''.
Odkazy na tento menný priestor budú v tvare '''<nowiki>[[$2:Názov stránky]]</nowiki>'''.
Ak je toto čo chcete, stlačte tlačidlo '''Potvrdiť''' dolu.",
	'farmer-button-confirm' => 'Potvrdiť',
	'farmer-button-submit' => 'Odoslať',
	'farmer-createwiki-form-title' => 'Vytvoriť wiki',
	'farmer-createwiki-form-text1' => 'Na vytvorenie novej wiki použite dolu uvedený formulár.',
	'farmer-createwiki-form-help' => 'Pomoc',
	'farmer-createwiki-form-text2' => "; Názov wiki: Názov vašej wiki. Obsahuje iba písmená a číslice.  Názov wiki sa použije ako súčasť URL, ktorý identifikuje vašu wiki. Napríklad ak zadáte '''názov''', k vašej wiki sa bude pristupovať pomocou <nowiki>http://</nowiki>'''názov'''.mojadoména.",
	'farmer-createwiki-form-text3' => '; Titul wiki: Titul vašej wiki. Použije sa v titule každej stránky vašej wiki. Bude tiež menným priestorom projektu a predponou interwiki odkazov.',
	'farmer-createwiki-form-text4' => '; Popis: Popis vašej wiki. Toto je textový popis wiki. Zobrazí sa v zozname wiki lokalít.',
	'farmer-createwiki-user' => 'Používateľské meno',
	'farmer-createwiki-name' => 'Názov wiki',
	'farmer-createwiki-title' => 'Titul wiki',
	'farmer-createwiki-description' => 'Popis',
	'farmer-createwiki-reason' => 'Dôvod',
	'farmer-updatedlist' => 'Aktualizovaný zoznam',
	'farmer-notaccessible' => 'Neprístupná',
	'farmer-notaccessible-test' => 'Táto možnosť je dostupná iba na rodičovskej wiki farmy',
	'farmer-permissiondenied' => 'Nedostatočné oprávnenie',
	'farmer-permissiondenied-text' => 'Nemáte oprávnenie zmazať wiki z farmy',
	'farmer-permissiondenied-text1' => 'Nemáte oprávnenie na prístup k tejto stránke',
	'farmer-deleting' => 'Wiki „$1“ bola zmazaná',
	'farmer-delete-confirm' => 'Potvrdzujem, že chcem zmazať túto wiki',
	'farmer-delete-confirm-wiki' => "Zmazať wiki: '''$1'''.",
	'farmer-delete-reason' => 'Dôvod zmazania:',
	'farmer-delete-title' => 'Zmazať wiki',
	'farmer-delete-text' => 'Prosím, zvoľte wiki, ktorú chcete zmazať, zo zoznamu dolu',
	'farmer-delete-form' => 'Vyberte wiki',
	'farmer-delete-form-submit' => 'Zmazať',
	'farmer-listofwikis' => 'Zoznam wiki',
	'farmer-mainpage' => 'Hlavná stránka',
	'farmer-basic-title' => 'Základné parametre',
	'farmer-basic-title1' => 'Titulok',
	'farmer-basic-title1-text' => 'Vaša wiki nemá titulok. Nastavte ho TERAZ',
	'farmer-basic-description' => 'Popis',
	'farmer-basic-description-text' => 'Dolu nastavte titulok vašej wiki',
	'farmer-basic-permission' => 'Oprávnenia',
	'farmer-basic-permission-text' => 'Pomocou tohto formulára je možné meniť oprávnenia používateľov tejto wiki.',
	'farmer-basic-permission-visitor' => 'Oprávnenia každého návštevníka',
	'farmer-basic-permission-visitor-text' => 'Nasledujúce oprávnenia sa použijú na každú osobu, ktorá navštívi túto wiki',
	'farmer-yes' => 'Áno',
	'farmer-no' => 'Nie',
	'farmer-basic-permission-user' => 'Oprávnenia prihlásených používateľov',
	'farmer-basic-permission-user-text' => 'Nasledujúce oprávnenia sa použijú na každú osobu, ktorá je na tejto wiki prihlásená',
	'farmer-setpermission' => 'Nastaviť oprávnenia',
	'farmer-defaultskin' => 'Štandardný vzhľad',
	'farmer-defaultskin-button' => 'Nastaviť štandardný vzhľad',
	'farmer-extensions' => 'Aktívne rozšírenia',
	'farmer-extensions-button' => 'Nastaviť aktívne rozšírenia',
	'farmer-extensions-extension-denied' => 'Nemáte oprávnenie používať túto vlastnosť. Musíte byť členom skupiny farmeradmin.',
	'farmer-extensions-invalid' => 'Neplatné rozšírenie',
	'farmer-extensions-invalid-text' => 'Nemohli sme pridať rozšírenie, pretože súbor zvolený na vloženie nebol nájdený',
	'farmer-extensions-available' => 'Dostupné rozšírenia',
	'farmer-extensions-noavailable' => 'Žiadne rozšírenia neboli zaregistrované',
	'farmer-extensions-register' => 'Registrovať rozšírenie',
	'farmer-extensions-register-text1' => 'Použite tento formulár na registráciu nového rozšírenia na farme. Keď raz rozšírenie zaregistrujete, všetky wiki na farme ho budú môcť používať.',
	'farmer-extensions-register-text2' => "Ako parameter ''Include súbor'' zadajte názov PHP súboru ako by ste napísali do LocalSettings.php.",
	'farmer-extensions-register-text3' => "Ak názov súboru obsahuje '''\$root''', táto premenná bude nahradená koreňovým adresárom MediaWiki.",
	'farmer-extensions-register-text4' => 'Aktuálne cesty include súborov sú:',
	'farmer-extensions-register-name' => 'Názov',
	'farmer-extensions-register-includefile' => 'Include súbor',
	'farmer-error-exists' => 'Nie je možné vytvoriť wiki. Už existuje: $1',
	'farmer-error-noextwrite' => 'Nebolo možné zapísať súbor rozšírenia:',
	'farmer-log-name' => 'Záznam wiki farmy',
	'farmer-log-header' => 'Toto je záznam zmien vykonaných vo farme wiki.',
	'farmer-log-create' => 'vytvoril wiki „$2“',
	'farmer-log-delete' => 'zmazal wiki „$2“',
	'right-farmeradmin' => 'Spravovať farmu wiki',
	'right-createwiki' => 'Vytvára wiki vo wiki farme',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'farmer' => 'Kmetovalec',
	'farmer-desc' => 'Upravljanje kmetije MediaWiki',
	'farmercreatesitename' => 'Ime strani',
	'farmercreatenextstep' => 'Naslednji korak',
	'farmer-about-text' => 'Kmetovalec MediaWiki vam omogoča upravljati kmetijo wikijev MediaWiki.',
	'farmer-list-wiki' => 'Seznam wikijev',
	'farmer-list-wiki-text' => '[[$1|Seznam]] vseh wikijev na {{SITENAME}}',
	'farmer-createwiki' => 'Ustvari wiki',
	'farmer-createwiki-text' => '[[$1|Ustvari]] nov wiki zdaj!',
	'farmer-administration' => 'Uprava kmetije',
	'farmer-administration-extension' => 'Upravljaj razširitve',
	'farmer-confirmsetting-reason' => 'Razlog',
	'farmer-createwiki-user' => 'Uporabniško ime',
	'farmer-createwiki-reason' => 'Razlog',
	'farmer-yes' => 'Da',
	'farmer-no' => 'Ne',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Nikola Smolenski
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'farmer' => 'Фармер',
	'farmer-desc' => 'Управљање фармом Медијавикија',
	'farmercantcreatewikis' => 'Не можете да направите вики јер немате дозволу за то',
	'farmercreateurl' => 'Адреса',
	'farmercreatesitename' => 'Назив сајта',
	'farmercreatenextstep' => 'Следећи корак',
	'farmernewwikimainpage' => '== Добро дошли на своју викију ==
Ако ово читате, ваш вики је инсталиран.
Можете да га подесите [[Special:Farmer|овде]].',
	'farmer-about' => 'О проширењу',
	'farmer-about-text' => 'Ово проширење вам омогућава да управљате фармом викија.',
	'farmer-list-wiki' => 'Списак викија',
	'farmer-list-wiki-text' => '[[$1|Списак]] свих викија на {{SITENAME}}',
	'farmer-createwiki' => 'Направи вики',
	'farmer-createwiki-text' => '[[$1|Направите]] нови вики!',
	'farmer-administration' => 'Администрација фарме',
	'farmer-administration-extension' => 'Управљање проширењима',
	'farmer-administration-extension-text' => '[[$1|Управљајте]] инсталираним проширењима.',
	'farmer-admimistration-listupdate' => 'Ажурирање списка фарме',
	'farmer-admimistration-listupdate-text' => '[[$1|Ажурирајте]] списак викија на {{SITENAME}}',
	'farmer-administration-delete' => 'Обриши викију',
	'farmer-administration-delete-text' => '[[$1|Обришите]] викију с фарме',
	'farmer-administer-thiswiki' => 'Управљај овом викијом',
	'farmer-administer-thiswiki-text' => '[[$1|Управљај]] изменама овог викија',
	'farmer-notavailable' => 'Недоступно',
	'farmer-notavailable-text' => 'Ова могућност је доступна само на главној викији',
	'farmer-wikicreated' => 'Викија је направљена.',
	'farmer-wikicreated-text' => 'Викија је направљена.
Доступна је на адреси $1',
	'farmer-default' => 'По подразумеваном, нико сем вас нема право приступа.
Можете да промените корисничка права преко $1',
	'farmer-wikiexists' => 'Викија постоји.',
	'farmer-wikiexists-text' => "Викија коју желите да направите, '''$1''', већ постоји.
Вратите се и покушајте с другим именом.",
	'farmer-confirmsetting' => 'Потврди поставке викија',
	'farmer-confirmsetting-name' => 'Име',
	'farmer-confirmsetting-title' => 'Наслов',
	'farmer-confirmsetting-description' => 'Опис',
	'farmer-confirmsetting-reason' => 'Разлог',
	'farmer-description' => 'Опис',
	'farmer-confirmsetting-text' => "Ваша викија, '''$1''', биће доступна на $3.
Именски простор пројекта биће '''$2'''.
Везе ка овом именском простору биће у обрасцу '''<nowiki>[[$2:Page name]]</nowiki>'''.
Ако то желите, кликните на дугме „потврди“ испод.",
	'farmer-button-confirm' => 'Потрвди',
	'farmer-button-submit' => 'Пошаљи',
	'farmer-createwiki-form-title' => 'Направите викију',
	'farmer-createwiki-form-text1' => 'Користите образац испод да бисте направили нову викију.',
	'farmer-createwiki-form-help' => 'Помоћ',
	'farmer-createwiki-form-text2' => "; Назив викије.
Садржи само слова и бројеве.
Назив викије биће коришћен као део URL адресе.
На пример, ако унесете '''title''', ваша викија биће доступна на адреси <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Наслов викије.
Ова вредност биће приказана на свакој страници викије.
Користиће се за именски простор пројекта, као и за међувики префикс.',
	'farmer-createwiki-form-text4' => '; Опис: опис викије.
Овде би требало да буде опис викије.
Ово ће бити приказано у списку викија.',
	'farmer-createwiki-user' => 'Корисничко име',
	'farmer-createwiki-name' => 'Назив викије',
	'farmer-createwiki-title' => 'Наслов викије',
	'farmer-createwiki-description' => 'Опис',
	'farmer-createwiki-reason' => 'Разлог',
	'farmer-updatedlist' => 'Ажуриран списак',
	'farmer-notaccessible' => 'Недоступно',
	'farmer-notaccessible-test' => 'Ова могућност је доступна само надређеној викији на фарми',
	'farmer-permissiondenied' => 'Приступ је одбијен.',
	'farmer-permissiondenied-text' => 'Немате дозволу за брисање викија с фарме',
	'farmer-permissiondenied-text1' => 'Немате дозволу да приступите овој страници',
	'farmer-deleting' => '„$1“ викија је обрисана.',
	'farmer-delete-confirm' => 'Потврђујем да желим да обришем ову викију',
	'farmer-delete-confirm-wiki' => "Викија за брисање: '''$1'''.",
	'farmer-delete-reason' => 'Разлог брисања:',
	'farmer-delete-title' => 'Брисање викија',
	'farmer-delete-text' => 'Изаберите викију коју желите да обришете са списка испод',
	'farmer-delete-form' => 'Изаберите викију',
	'farmer-delete-form-submit' => 'Обриши',
	'farmer-listofwikis' => 'Списак викија',
	'farmer-mainpage' => 'Главна страна',
	'farmer-basic-title' => 'Основни параметри',
	'farmer-basic-title1' => 'Наслов',
	'farmer-basic-title1-text' => 'Ваша викија нема наслов. Поставите га <b>одмах</b>',
	'farmer-basic-description' => 'Опис',
	'farmer-basic-description-text' => 'Испод поставите опис вашег викија',
	'farmer-basic-permission' => 'Дозволе',
	'farmer-basic-permission-text' => 'Могуће је изменити дозволе корисника користећи образац испод.',
	'farmer-basic-permission-visitor' => 'Дозволе сваког посетиоца',
	'farmer-basic-permission-visitor-text' => 'Следеће дозволе биће примењене на сваког корисника који посети ову викију',
	'farmer-yes' => 'Да',
	'farmer-no' => 'Не',
	'farmer-basic-permission-user' => 'Дозволе пријављених корисника',
	'farmer-basic-permission-user-text' => 'Следеће дозволе биће примењене на сваког пријављеног корисника овог викија',
	'farmer-setpermission' => 'Подеси дозволе',
	'farmer-defaultskin' => 'Подразумевана пресвлака',
	'farmer-defaultskin-button' => 'Подеси подразумевану пресвлаку',
	'farmer-extensions' => 'Активна проширења',
	'farmer-extensions-button' => 'Подеси активна проширења',
	'farmer-extensions-extension-denied' => 'Немате дозволу да користите ову могућност.
Морате бити члан farmeradmin групе.',
	'farmer-extensions-invalid' => 'Неисправно проширење',
	'farmer-extensions-invalid-text' => 'Додавање проширења није успело јер датотека означена за укључивање није пронађена.',
	'farmer-extensions-available' => 'Доступна проширења',
	'farmer-extensions-noavailable' => 'Ниједно проширење није уписано.',
	'farmer-extensions-register' => 'Упиши проширење',
	'farmer-extensions-register-text1' => 'Користите образац испод да бисте уписали ново проширење у фарму.
Када се проширење упише, сви викији ће моћи да га користе.',
	'farmer-extensions-register-text2' => "За параметар ''Укључивање датотека'', додајте назив PHP датотеке, као LocalSettings.php.",
	'farmer-extensions-register-text3' => "Ако назив датотеке садржи '''\$root''', та променљива биће замењена с основном фасциклом Медијавикија.",
	'farmer-extensions-register-text4' => 'Путање за укључивање:',
	'farmer-extensions-register-name' => 'Назив',
	'farmer-extensions-register-includefile' => 'Укључи датотеку',
	'farmer-error-exists' => 'Викија није направљена. Она већ постоји: $1',
	'farmer-error-noextwrite' => 'Писање датотеке проширења није успело:',
	'farmer-log-name' => 'Извештај фарме',
	'farmer-log-header' => 'Ово је списак измена фарме.',
	'farmer-log-create' => '{{GENDER:|је направио|је направила|направи}} „$2“ викију',
	'farmer-log-delete' => '{{GENDER:|је обрисао|је обрисала|обриса}} „$2“ викију',
	'right-farmeradmin' => 'управљање фармом викије',
	'right-createwiki' => 'прављење викија на фарми',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Upravljajte MedijaViki farmom',
	'farmercantcreatewikis' => 'Ne možete da napravite Viki zato što nemate createwikis prava pristupa',
	'farmercreateurl' => 'Adresa',
	'farmercreatesitename' => 'Ime sajta',
	'farmercreatenextstep' => 'Sledeći korak',
	'farmernewwikimainpage' => '== Dobro došli na Vaš Viki ==
Ako ovo čitate, Vaš Viki je ispravno instaliran.
Možete da [[Special:Farmer|podesite Vaš viki]].',
	'farmer-about' => 'O...',
	'farmer-about-text' => 'MedijaViki Farmer Vam omogućava da upravljate farmom MedijaViki Vikija.',
	'farmer-list-wiki' => 'Spisak Vikija',
	'farmer-list-wiki-text' => '[[$1|Spisak]] svih Vikija na {{SITENAME}}',
	'farmer-createwiki' => 'Napravite Viki',
	'farmer-createwiki-text' => '[[$1|Napravite]] novi Viki sada!',
	'farmer-administration' => 'Administracija farme',
	'farmer-administration-extension' => 'Podešavajte ekstenzije',
	'farmer-administration-extension-text' => '[[$1|Podešavajte]] instalirane ekstenzije.',
	'farmer-admimistration-listupdate' => 'Ažuriranje spiska farme',
	'farmer-admimistration-listupdate-text' => '[[$1|Ažurirajte]] spisak Vikija na {{SITENAME}}',
	'farmer-administration-delete' => 'Obrišite Viki',
	'farmer-administration-delete-text' => '[[$1|Obrišite]] Viki iz farme',
	'farmer-administer-thiswiki' => 'Administrirajte ovaj Viki',
	'farmer-administer-thiswiki-text' => '[[$1|Administrirajte]] promene nad ovim Vikijem',
	'farmer-notavailable' => 'Nedostupno',
	'farmer-notavailable-text' => 'Ova pogodnost je dostupna samo na glavnom Vikiju',
	'farmer-wikicreated' => 'Viki je napravljen',
	'farmer-wikicreated-text' => 'Vaš Viki je napravljen.
Dostupan je na $1',
	'farmer-default' => 'Po podrazumevanim podešavanjim, niko osim vas nema prava pristupa na ovom Vikiju.
Možete da promenite prava pristupa preko $1',
	'farmer-wikiexists' => 'Viki postoji',
	'farmer-wikiexists-text' => "Viki koga pokušavate da napravite, '''$1''', već postoji.
Molimo Vas da se vratite i pokušate sa drugim imenom.",
	'farmer-confirmsetting' => 'Potvrdi podešavanja Vikija',
	'farmer-confirmsetting-name' => 'Ime',
	'farmer-confirmsetting-title' => 'Naslov',
	'farmer-confirmsetting-description' => 'Opis',
	'farmer-confirmsetting-reason' => 'Razlog',
	'farmer-description' => 'Opis',
	'farmer-confirmsetting-text' => "Vaša vikija, '''$1''', biće dostupna na $3.
Imenski prostor projekta biće '''$2'''.
Veze ka ovom imenskom prostoru biće u obrascu '''<nowiki>[[$2:Page name]]</nowiki>'''.
Ako to želite, kliknite na dugme „potvrdi“ ispod.",
	'farmer-button-confirm' => 'Potrvdi',
	'farmer-button-submit' => 'Prihvati',
	'farmer-createwiki-form-title' => 'Napravite Viki',
	'farmer-createwiki-form-text1' => 'Koristite formu ispod da biste napravili novi Viki',
	'farmer-createwiki-form-help' => 'Pomoć',
	'farmer-createwiki-form-text2' => "; Naziv vikije.
Sadrži samo slova i brojeve.
Naziv vikije biće korišćen kao deo URL adrese.
Na primer, ako unesete '''title''', vaša vikija biće dostupna na adresi <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Naslov vikije.
Ova vrednost biće prikazana na svakoj stranici vikije.
Koristiće se za imenski prostor projekta, kao i za međuviki prefiks.',
	'farmer-createwiki-form-text4' => '; Opis: Opis Vikija.
Ovde treba da bude opis Vikija.
Ovo će biti prikazano u spisku Vikija.',
	'farmer-createwiki-user' => 'Korisničko ime',
	'farmer-createwiki-name' => 'Viki ime',
	'farmer-createwiki-title' => 'Viki naslov',
	'farmer-createwiki-description' => 'Opis',
	'farmer-createwiki-reason' => 'Razlog',
	'farmer-updatedlist' => 'Osevžen spisak',
	'farmer-notaccessible' => 'Nedostupno',
	'farmer-notaccessible-test' => 'Ova pogodnost je dostupna samo na glavnom Vikiju farme',
	'farmer-permissiondenied' => 'Prava pristupa odbijena',
	'farmer-permissiondenied-text' => 'Nemate potrebna prava da biste iz farme izbrisali ovaj Viki',
	'farmer-permissiondenied-text1' => 'Nemate prava pristupa ovoj strani',
	'farmer-deleting' => 'Viki "$1" je obrisan',
	'farmer-delete-confirm' => 'Potvrđujem da želim da obrišem ovaj Viki',
	'farmer-delete-confirm-wiki' => "Viki koji će biti obrisan: '''$1'''.",
	'farmer-delete-reason' => 'Razlog brisanja:',
	'farmer-delete-title' => 'Brisanje Vikija',
	'farmer-delete-text' => 'Molimo vas da sa spiska ispod izaberete Viki koga želite da obrišete',
	'farmer-delete-form' => 'Izaberi Viki',
	'farmer-delete-form-submit' => 'Obriši',
	'farmer-listofwikis' => 'Spisak Vikija',
	'farmer-mainpage' => 'Glavna strana',
	'farmer-basic-title' => 'Osnovni parametri',
	'farmer-basic-title1' => 'Naslov',
	'farmer-basic-title1-text' => 'Vaš Viki nema naslov. Postavite jedan <b>sada</b>',
	'farmer-basic-description' => 'Opis',
	'farmer-basic-description-text' => 'Postavlja opis Vašeg Vikija ispod',
	'farmer-basic-permission' => 'Prava pristupa',
	'farmer-basic-permission-text' => 'Koristeći formu ispod, moguće je izmeniti prava pristupa korisnika ovog Vikija',
	'farmer-basic-permission-visitor' => 'Prava pristupa za svakog posetioca',
	'farmer-basic-permission-visitor-text' => 'Sledeća prava pristupa će imati svaka osoba koja poseti ovu Viki',
	'farmer-yes' => 'Da',
	'farmer-no' => 'Ne',
	'farmer-basic-permission-user' => 'Prava pristupa za ulogovane korisnike',
	'farmer-basic-permission-user-text' => 'Sledeća prava pristupa će imati svaki ulogovani korisnik na ovaj Viki',
	'farmer-setpermission' => 'Podesi prava pristupa',
	'farmer-defaultskin' => 'Podrazumevana koža',
	'farmer-defaultskin-button' => 'Podesi podrazumevanu kožu',
	'farmer-extensions' => 'Aktivne ekstenzije',
	'farmer-extensions-button' => 'Podesi aktivne ekstenzije',
	'farmer-extensions-extension-denied' => 'Nemate dozvolu potrebnu da biste koristili ovu pogodnost.
Morate biti člank farmeradmin grupe.',
	'farmer-extensions-invalid' => 'Neispravna ekstenzija',
	'farmer-extensions-invalid-text' => 'Nismo mogli da dodamo ekstenziju zato što fajl označen za uključivanje nije pronađen',
	'farmer-extensions-available' => 'Raspoložive ekstenzije',
	'farmer-extensions-noavailable' => 'Nijedna ekstenzija nije registrovana',
	'farmer-extensions-register' => 'Registruj ekstenziju',
	'farmer-extensions-register-text1' => 'Koristite formu ispod da biste registrovali novu ekstenziju sa farmom.
Kad ekstenziju jedanput registrujete, svi Vikiji će moći da je koriste.',
	'farmer-extensions-register-text2' => "Za parametar ''Uključivanja fajla'', dodajte ime, kao što biste to uradili u LocalSettings.php.",
	'farmer-extensions-register-text3' => "Ako ime fajl sadrži '''\$root''', ta promenljiva će biti zamenjena sa glavnim direktorijumom MedijaVikija",
	'farmer-extensions-register-text4' => 'Trenutne putanje za uključivanje su:',
	'farmer-extensions-register-name' => 'Ime',
	'farmer-extensions-register-includefile' => 'Uključi fajl',
	'farmer-error-exists' => 'Vikija nije napravljena. Ona već postoji: $1',
	'farmer-error-noextwrite' => 'Pisanje datoteke proširenja nije uspelo:',
	'farmer-log-name' => 'Izveštaj farme',
	'farmer-log-header' => 'Ovo je spisak izmena farme.',
	'farmer-log-create' => 'napravljen viki "$2"',
	'farmer-log-delete' => 'obrisan viki "$2"',
	'right-farmeradmin' => 'upravljanje farmom vikije',
	'right-createwiki' => 'pravljenje vikija na farmi',
);

/** Swati (SiSwati)
 * @author Jatrobat
 */
$messages['ss'] = array(
	'farmer-mainpage' => 'Likhasi Lelikhulu',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'farmer-createwiki-form-help' => 'Hälpe',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'farmer-about' => 'Ngeunaan',
	'farmer-createwiki' => 'Jieun hiji Wiki',
	'farmer-confirmsetting-name' => 'Ngaran',
	'farmer-confirmsetting-title' => 'Judul',
	'farmer-confirmsetting-reason' => 'Alesan',
	'farmer-createwiki-user' => 'Landihan',
	'farmer-createwiki-reason' => 'Alesan',
	'farmer-basic-title1' => 'Judul',
	'farmer-basic-description' => 'Pedaran',
);

/** Swedish (Svenska)
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 * @author Per
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'farmer' => 'Farmer',
	'farmer-desc' => 'Sköt en MediaWiki farm',
	'farmercantcreatewikis' => 'Du är oförmögen till att skapa wikier för att du inte har skapa wikier privilegierna',
	'farmercreatesitename' => 'Sajtnamn',
	'farmercreatenextstep' => 'Nästa steg',
	'farmernewwikimainpage' => '== Välkommen till din wiki ==
Om du läser det här, har din nya wiki blivit korrekt installerad. Du kan [[Special:Farmer|skräddarsy din wiki]].',
	'farmer-about' => 'Om',
	'farmer-about-text' => 'MediaWiki Farmer tillåter dig att sköta en farm av MediaWiki wikier.',
	'farmer-list-wiki' => 'Lista över wikier',
	'farmer-list-wiki-text' => '[[$1|Lista]] alla wikier på {{SITENAME}}',
	'farmer-createwiki' => 'Skapa en wiki',
	'farmer-createwiki-text' => '[[$1|Skapa]] en ny wiki nu!',
	'farmer-administration' => 'Farm Administration',
	'farmer-administration-extension' => 'Sköt tilläggsprogram',
	'farmer-administration-extension-text' => '[[$1|Sköt]] installerade tilläggsprogram.',
	'farmer-admimistration-listupdate' => 'Uppdatera farm lista',
	'farmer-admimistration-listupdate-text' => '[[$1|Uppdatera]] lista över wikier på {{SITENAME}}',
	'farmer-administration-delete' => 'Ta bort en wiki',
	'farmer-administration-delete-text' => '[[$1|Radera]] en wiki från farmen',
	'farmer-administer-thiswiki' => 'Administratera denna wiki',
	'farmer-administer-thiswiki-text' => '[[$1|Administerar]] ändringar till denna wiki',
	'farmer-notavailable' => 'Inte tillgänglig',
	'farmer-notavailable-text' => 'Denna egenskap är endast tillgänglig på huvudwikin',
	'farmer-wikicreated' => 'Wiki skapad',
	'farmer-wikicreated-text' => 'Din wiki har skapats.  Den är tillgänglig på $1',
	'farmer-default' => 'Som utgångspunkt är det ingen annan en dig som har rättigheter på denna wiki. Du kan ändra användarrättigheter via $1',
	'farmer-wikiexists' => 'Wiki existerar',
	'farmer-wikiexists-text' => "Wikin du vill upprätta, '''$1''', finns redan. Gå tillbaka och pröva med ett annat namn.",
	'farmer-confirmsetting' => 'Bekräfta wiki-inställningar',
	'farmer-confirmsetting-name' => 'Namn',
	'farmer-confirmsetting-title' => 'Titel',
	'farmer-confirmsetting-description' => 'Beskrivning',
	'farmer-confirmsetting-reason' => 'Anledning',
	'farmer-description' => 'Beskrivning',
	'farmer-confirmsetting-text' => "Din wiki, '''$1''', vill bli tillgänglig via $3.
Projektnamnrymden ska vara '''$2'''.
Länkar till denna namnrymd ska vara på sättet '''<nowiki>[[$2:Sidenavn]]</nowiki>'''.
Om detta är det du vill, tryck på knappen ''{{int:Farmer-button-confirm}}'' nedan.",
	'farmer-button-confirm' => 'Bekräfta',
	'farmer-button-submit' => 'Lagra',
	'farmer-createwiki-form-title' => 'Skapa en wiki',
	'farmer-createwiki-form-text1' => 'Använd formuläret nedan för att skapa en ny wiki.',
	'farmer-createwiki-form-help' => 'Hjälp',
	'farmer-createwiki-form-text2' => "; Wikins namn: Namnet på wikin.
Innehåller endast bokstäver och siffror. Wikins namn kommer användas i URL-en för att identifiera wikin. Om du för exempel skriver in ''titel'', kommer din wiki vara tillgänglig via <nowiki>http://</nowiki>''tittel''.mydomain.",
	'farmer-createwiki-form-text3' => '; Wikins titel: Titeln på wikin.
Kommer bli använd i titeln på varje sida på din wiki. Kommer också användas som namn på projektnamnrymden och som interwikiprefix.',
	'farmer-createwiki-form-text4' => '; Beskrivning: Beskrivning av wikin. Den kommer att visas in wiki listan.',
	'farmer-createwiki-user' => 'Användarnamn',
	'farmer-createwiki-name' => 'Wikins namn',
	'farmer-createwiki-title' => 'Wikins titel',
	'farmer-createwiki-description' => 'Beskrivning',
	'farmer-createwiki-reason' => 'Anledning',
	'farmer-updatedlist' => 'Uppdaterad lista',
	'farmer-notaccessible' => 'Otillgänglig',
	'farmer-notaccessible-test' => 'Detta är endast tillgängligt på farmens upphovswiki',
	'farmer-permissiondenied' => 'Tillgång nekad',
	'farmer-permissiondenied-text' => 'Du har inte tillåtelse att ta bort wikier',
	'farmer-permissiondenied-text1' => 'Du har inte tillåtelse att gå in på denna sida',
	'farmer-deleting' => 'Wikin "$1" har raderats',
	'farmer-delete-confirm' => 'Jag bekräftar att jag vill radera denna wiki',
	'farmer-delete-confirm-wiki' => 'Wiki att radera: "$1"',
	'farmer-delete-reason' => 'Anledning till radering:',
	'farmer-delete-title' => 'Ta bort Wiki',
	'farmer-delete-text' => 'Var god välj vilken wiki du vill ta bort från listan nedan',
	'farmer-delete-form' => 'Välj en wiki',
	'farmer-delete-form-submit' => 'Radera',
	'farmer-listofwikis' => 'Lista över wikier',
	'farmer-mainpage' => 'Huvudsida',
	'farmer-basic-title' => 'Grundparametrar',
	'farmer-basic-title1' => 'Titel',
	'farmer-basic-title1-text' => 'Din wiki har inte en titel.  Välj en NU',
	'farmer-basic-description' => 'Beskrivning',
	'farmer-basic-description-text' => 'Ange en beskrivning för din wiki nedan',
	'farmer-basic-permission' => 'Tillåtelser',
	'farmer-basic-permission-text' => 'Vid användning av formuläret nedan kan du ändra användares rättigheter på denna wiki.',
	'farmer-basic-permission-visitor' => 'Rättigheter för alla besökare',
	'farmer-basic-permission-visitor-text' => 'Följande rättigheter kommer bli givna till alla som besöker wikin',
	'farmer-yes' => 'Ja',
	'farmer-no' => 'Nej',
	'farmer-basic-permission-user' => 'Rättigheter för inloggade användare',
	'farmer-basic-permission-user-text' => 'Följande rättigheter kommer ges till alla inloggade användare',
	'farmer-setpermission' => 'Ange rättigheter',
	'farmer-defaultskin' => 'Standardutseende',
	'farmer-defaultskin-button' => 'Ange standardutseende',
	'farmer-extensions' => 'Aktiva programtillägg',
	'farmer-extensions-button' => 'Ange aktiva programtillägg',
	'farmer-extensions-extension-denied' => 'Du har inte tillåtelse att använda denna funktion.
Du måste vara medlem av användargruppen farmeradmin',
	'farmer-extensions-invalid' => 'Ogiltigt programtillägg',
	'farmer-extensions-invalid-text' => 'Vi kunde inte lägga till programtillägget för filen som valdes för inkludering inte hittades',
	'farmer-extensions-available' => 'Tillgängliga programtillägg',
	'farmer-extensions-noavailable' => 'Inga programtillägg är registrerade',
	'farmer-extensions-register' => 'Registrera programtillägg',
	'farmer-extensions-register-text1' => 'Använd formuläret nedan för och registrera ett nytt programtillägg hos farmen. När ett programtillägg är registrerat kommer alla wikier kunna använda den.',
	'farmer-extensions-register-text2' => "För ''Inkludera fil''-parametern, skriv in namnet på PHP-filen som du ville gjort det i LocalSettings.php.",
	'farmer-extensions-register-text3' => "Om filnamnet innehåller '''\$root''', kommer den variabeln ersättas med rotmappen till MediaWiki.",
	'farmer-extensions-register-text4' => 'Dom nuvarande inkluderade vägarna är:',
	'farmer-extensions-register-name' => 'Namn',
	'farmer-extensions-register-includefile' => 'Inkludera fil',
	'farmer-error-exists' => 'Kan inte skapa wikin.  Den existerar redan: $1',
	'farmer-error-noextwrite' => 'Kunde inte skriva ut programtilläggsfil:',
	'farmer-log-create' => 'skapat wikin "$2"',
	'farmer-log-delete' => 'raderat wikin "$2"',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'farmer-mainpage' => 'Přodńo zajta',
	'farmer-extensions-register-name' => 'Mjano',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author Trengarasu
 */
$messages['ta'] = array(
	'farmercreatesitename' => 'தளத்தின் பெயர்',
	'farmercreatenextstep' => 'அடுத்த செயல்',
	'farmer-about' => 'விவரம்',
	'farmer-confirmsetting-name' => 'பெயர்',
	'farmer-confirmsetting-title' => 'தலைப்பு',
	'farmer-confirmsetting-description' => 'விளக்கம்',
	'farmer-confirmsetting-reason' => 'காரணம்',
	'farmer-description' => 'விளக்கம்',
	'farmer-createwiki-form-help' => 'உதவி',
	'farmer-createwiki-user' => 'பயனர் பெயர்',
	'farmer-createwiki-description' => 'விளக்கம்',
	'farmer-createwiki-reason' => 'காரணம்',
	'farmer-extensions-register-name' => 'பெயர்',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'farmer' => 'రైతు',
	'farmercantcreatewikis' => 'మీరు వికీలను సృష్టించలేకున్నారు ఎందుకంటే మీరు వికీలను సృష్టించే అధికారం లేదు.',
	'farmercreatesitename' => 'సైటు పేరు',
	'farmercreatenextstep' => 'తర్వాతి మెట్టు',
	'farmernewwikimainpage' => '== మీ వికీకి స్వాగతం ==
మీరిది చదువుతున్నారంటే, మీ కొత్త వికీ సరిగ్గానే స్థాపనమయ్యింది.  వికీని మీకు నచ్చినట్టు మలచుకోడానికి, [[Special:Farmer| మీ వికీని మలచుకో౦డి]]ని సందర్శించండి.',
	'farmer-about' => 'గురించి',
	'farmer-list-wiki' => 'వికీల యొక్క జాబితా',
	'farmer-list-wiki-text' => '{{SITENAME}}లోని అన్ని వికీల [[$1|జాబితా]]',
	'farmer-createwiki' => 'ఓ వికీని సృష్టించండి',
	'farmer-createwiki-text' => 'ఇప్పుడే ఓ కొత్త వికీని [[$1|సృష్టించండి]]!',
	'farmer-admimistration-listupdate-text' => '{{SITENAME}}లో నికీల జాబితాని [[$1|తాజాకరించండి]]',
	'farmer-administration-delete' => 'ఓ వికీని తొలగించండి',
	'farmer-administer-thiswiki' => 'ఈ వికీని నిర్వహించండి',
	'farmer-administer-thiswiki-text' => 'ఈ వికీలో జరిగిన మార్పులను [[$1|పర్యవేక్షించండి]]',
	'farmer-notavailable' => 'అందుబాటులో లేదు',
	'farmer-notavailable-text' => 'ఈ సౌలభ్యం ప్రధాన వికీలో మాత్రమే అందుబాటులో ఉంటుంది.',
	'farmer-wikicreated' => 'వికీ తయారయ్యింది',
	'farmer-wikicreated-text' => 'మీ వికీ తయారయ్యింది.  ఇది $1 వద్ద అందుబాటులో ఉంటుంది',
	'farmer-default' => 'మామూలుగా, మీకు తప్ప ఈ వికీలో ఇంకెవరికీ అనుమతులు ఉండవు. $1 ద్వారా మీరు వాడుకరి హక్కులని మార్చవచ్చు',
	'farmer-wikiexists' => 'వికీ ఉంది',
	'farmer-wikiexists-text' => "మీరు సృష్టించడానికి ప్రయత్నిస్తున్న '''$1''' అనే వికీ ఇప్పటికే ఉంది. వెనక్కి వెళ్ళి మరో పేరుతో ప్రయత్నించండి.",
	'farmer-confirmsetting' => 'వికీ అమరికలను నిర్ధారించండి',
	'farmer-confirmsetting-name' => 'పేరు',
	'farmer-confirmsetting-title' => 'శీర్షిక',
	'farmer-confirmsetting-description' => 'వివరణ',
	'farmer-confirmsetting-reason' => 'కారణం',
	'farmer-description' => 'వివరణ',
	'farmer-button-confirm' => 'నిర్ధారించు',
	'farmer-button-submit' => 'దాఖలుచెయ్యి',
	'farmer-createwiki-form-title' => 'ఓ వికీని సృష్టించండి',
	'farmer-createwiki-form-text1' => 'కొత్త వికీని సృష్టించడానికి క్రింది ఫారాన్ని ఉపయోగించండి.',
	'farmer-createwiki-form-help' => 'సహాయం',
	'farmer-createwiki-form-text3' => '; వికీ శీర్షిక: వికీ యొక్క శీర్షిక.  మీ వికీలోని ప్రతీ పేజీ యొక్క శీర్షికలోనూ కనబడుతుంది.  ఇది ప్రాజెక్టు యొక్క పేరుబరి మరియు అంతర్వికీ ఉపసర్గ కూడా.',
	'farmer-createwiki-form-text4' => '; వివరణ: వికీ యొక్క వివరణ.  ఇది వికీ గురించిన పాఠ్య వివరణ.  దీన్ని వికీల జాబితాలో చూపిస్తాం.',
	'farmer-createwiki-user' => 'వాడుకరిపేరు',
	'farmer-createwiki-name' => 'వికీ పేరు',
	'farmer-createwiki-title' => 'వికీ శీర్షిక',
	'farmer-createwiki-description' => 'వివరణ',
	'farmer-createwiki-reason' => 'కారణం',
	'farmer-updatedlist' => 'తాజాకరించిన జాబితా',
	'farmer-notaccessible' => 'అందుబాటులో లేదు',
	'farmer-permissiondenied' => 'అనుమతి నిరాకరించారు',
	'farmer-permissiondenied-text1' => 'ఈ పేజీని చూడడానికి మీకు అనుమతి లేదు',
	'farmer-deleting' => 'వికీ "$1" ని తొలగి౦చాము',
	'farmer-delete-reason' => 'తొలగింపునకు కారణం:',
	'farmer-delete-title' => 'వికీ తొలగింపు',
	'farmer-delete-text' => 'మీరు తొలగించాలనుకుంటున్న వికీని ఈ క్రింది జాబితానుండి ఎంచుకోండి',
	'farmer-delete-form' => 'ఓ వికీని ఎంచుకోండి',
	'farmer-delete-form-submit' => 'తొలగించు',
	'farmer-listofwikis' => 'వికీల యొక్క జాబితా',
	'farmer-mainpage' => 'మొదటి పేజీ',
	'farmer-basic-title1' => 'శీర్షిక',
	'farmer-basic-title1-text' => 'మీ వికీకి శీర్షిక లేదు. ఇప్పుడే పెట్టండి.',
	'farmer-basic-description' => 'వివరణ',
	'farmer-basic-description-text' => 'మీ వికీ యొక్క వివరణని క్రింద ఇవ్వండి',
	'farmer-basic-permission' => 'అనుమతులు',
	'farmer-basic-permission-text' => 'ఈ వికీలోని వాడుకర్ల అనుమతులను ఈ క్రింది ఫారం ఉపయోగించి మార్చవచ్చు.',
	'farmer-basic-permission-visitor' => 'ప్రతీ సందర్శకునికి అనుమతులు',
	'farmer-basic-permission-visitor-text' => 'ఈ వికీని సందర్శించే ప్రతీ వ్యక్తికీ ఈ క్రింది అనుమతులు వర్తిస్తాయి',
	'farmer-yes' => 'అవును',
	'farmer-no' => 'కాదు',
	'farmer-basic-permission-user' => 'ప్రవేశించిన వాడుకరులకు అనుమతులు',
	'farmer-basic-permission-user-text' => 'ఈ వికీలో ప్రవేశించిన ప్రతీ ఒక్కరికీ ఈ క్రింది అనుమతులు ఆపాదిస్తాం',
	'farmer-extensions-available' => 'అందుబాటులో ఉన్న పొడగింతలు',
	'farmer-extensions-noavailable' => 'పొడగింతలు ఏవీ నమోదుకాలేదు',
	'farmer-extensions-register' => 'పొడగింతను నమోదుచెయ్యండి',
	'farmer-extensions-register-text3' => "పైలుపేరులో '''\$root''' అనే చరరాశి ఉంటే, దాన్ని మీడియావికీ యొక్క రూట్ డైరెక్టరీతో ప్రతిక్షేపిస్తాం.",
	'farmer-extensions-register-name' => 'పేరు',
	'farmer-error-exists' => 'వికీని సృష్టించలేము. అది ఈపాటికే ఉంది: $1',
	'farmer-error-noextwrite' => 'పొడగింత ఫైలుని వ్రాయలేకున్నాం:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'farmer-about' => 'Kona-ba',
	'farmer-confirmsetting-name' => 'Naran',
	'farmer-confirmsetting-title' => 'Títulu',
	'farmer-createwiki-form-help' => 'Ajuda',
	'farmer-createwiki-user' => "Naran uza-na'in",
	'farmer-deleting' => 'Halakon ona wiki $1',
	'farmer-delete-form-submit' => 'Halakon',
	'farmer-mainpage' => 'Pájina Mahuluk',
	'farmer-basic-title1' => 'Títulu',
	'farmer-yes' => 'Sin',
	'farmer-no' => 'Lae',
	'farmer-extensions-register-name' => 'Naran',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'farmer' => 'Деҳқон',
	'farmer-desc' => 'Идора кардани киштзори МедиаВики',
	'farmercantcreatewikis' => 'Шумо наметавонед викиҳо эҷод кунед, чун шумо дорои имтиёзи эҷодивикиҳо нестед',
	'farmercreatesitename' => 'Номи сомона',
	'farmercreatenextstep' => 'Қадами баъдӣ',
	'farmernewwikimainpage' => '== Хуш омадед ба Викии Шумо ==
Агар шумо инро хонда истодаед, викии нави шумо дуруст насб шудааст.
Барои мӯътод кардан, лутфан аз [[Special:Farmer]] боздид кунед.',
	'farmer-about' => 'Дар бораи',
	'farmer-about-text' => 'Деҳқони МедиаВики ба шумо имкони идора кардани викиҳои МедиаВикиро медиҳад.',
	'farmer-list-wiki' => 'Феҳристи Викиҳо',
	'farmer-list-wiki-text' => 'Ҳамаи викиҳои дар {{SITENAME}} бударо [[$1|феҳрист]] кун',
	'farmer-createwiki' => 'Эҷод кардани Вики',
	'farmer-createwiki-text' => 'Ҳамакнун як викии ҷадид [[$1|эҷод]] кунед!',
	'farmer-administration' => 'Мудирияти Киштзор',
	'farmer-administration-extension' => 'Идора кардани Афзунаҳо',
	'farmer-administration-extension-text' => '[[$1|Идора кардани]] афзунаҳои насбшуда.',
	'farmer-admimistration-listupdate' => 'Барӯзшавии Феҳристи Киштзор',
	'farmer-admimistration-listupdate-text' => '[[$1|Барӯз]] кардани викиҳо дар {{SITENAME}}',
	'farmer-administration-delete' => 'Ҳазфи Вики',
	'farmer-administration-delete-text' => '[[$1|Ҳазф]] кардани вики аз киштзор',
	'farmer-administer-thiswiki' => 'Мудири кардани ин Вики',
	'farmer-administer-thiswiki-text' => '[[$1|Мудири кардани]] тағйироти ин Вики',
	'farmer-notavailable' => 'Дастрас нест',
	'farmer-notavailable-text' => 'Ин хусусият танҳо дар викии асосӣ дастрас аст',
	'farmer-wikicreated' => 'Вики эҷод шуд',
	'farmer-wikicreated-text' => 'Викии шумо эҷод шуд.
Он дар $1 дастрас аст',
	'farmer-default' => 'Аз рӯи пешфарз, ҳеҷ кас ба ғайр аз шумо ба ин вики иҷозат ндорад.
Шумо метавонед имтиёзоти корбариро тариқи $1 тағйир бидиҳед',
	'farmer-wikiexists' => 'Вики вуҷуд дорад',
	'farmer-wikiexists-text' => "Викие ки шумо кӯшиш эҷод кардан ҳасте, '''$1''', аллакай вуҷуд дорад.
Лутфан баргардед ва номи дигареро бисанҷед.",
	'farmer-confirmsetting' => 'Тасдиқи Танзимоти Вики',
	'farmer-confirmsetting-name' => 'Ном',
	'farmer-confirmsetting-title' => 'Унвон',
	'farmer-confirmsetting-description' => 'Тавсиф',
	'farmer-description' => 'Тавсифот',
	'farmer-button-confirm' => 'Таъйид',
	'farmer-button-submit' => 'Ирсол',
	'farmer-createwiki-form-title' => 'Эҷод кардани Вики',
	'farmer-createwiki-form-text1' => 'Барои эҷоди викии ҷадид аз форми зерин истифода баред.',
	'farmer-createwiki-form-help' => 'Роҳнамо',
	'farmer-createwiki-user' => 'Номи корбарӣ',
	'farmer-createwiki-name' => 'Номи Вики',
	'farmer-createwiki-title' => 'Унвони Вики',
	'farmer-createwiki-description' => 'Тавсифот',
	'farmer-updatedlist' => 'Феҳристи барӯзшуда',
	'farmer-notaccessible' => 'Дастрас нест',
	'farmer-permissiondenied' => 'Иҷоза рад шуд',
	'farmer-permissiondenied-text' => 'Шумо иҷозаи ҳазф кардани вики аз киштзорро надоред',
	'farmer-permissiondenied-text1' => 'Шумо иҷозати дастраси карданро ба ин саҳифа надоред',
	'farmer-deleting' => 'Дар ҳоли ҳазфи "$1"',
	'farmer-delete-title' => 'Ҳазф кардани Вики',
	'farmer-delete-text' => 'Лутфан викиеро, ки шумо майли ҳазф кардан доред, аз феҳристи зерин интихоб кунед',
	'farmer-delete-form' => 'Интихоб кардани вики',
	'farmer-delete-form-submit' => 'Ҳафз',
	'farmer-listofwikis' => 'Феҳристи Викиҳо',
	'farmer-mainpage' => 'Саҳифаи Аслӣ',
	'farmer-basic-title' => 'Параметерҳои асосӣ',
	'farmer-basic-title1' => 'Унвон',
	'farmer-basic-title1-text' => 'Викии шумо унвон надорад. ҲОЗИР як унвон гузоред',
	'farmer-basic-description' => 'Тавсифот',
	'farmer-basic-description-text' => 'Тавсифи викии худро дар зер зеҳоти қарор бидиҳед',
	'farmer-basic-permission' => 'Иҷозаҳо',
	'farmer-basic-permission-text' => 'Бо истифодаи форми зер, тағйир додани иҷозаҳои корбарон дар ин вики мумкин аст.',
	'farmer-basic-permission-visitor' => 'Иҷозаҳо барои Ҳар Ташрифовар',
	'farmer-basic-permission-visitor-text' => 'Иҷозаҳои зер ба ҳар шахсе, ки ба ин вики ташриф меоварад шомил хоҳад шуд',
	'farmer-yes' => 'Бале',
	'farmer-no' => 'Не',
	'farmer-basic-permission-user' => 'Иҷозаҳо барои Корбарони Вурудшуда',
	'farmer-setpermission' => 'Гузоштани Иҷозаҳо',
	'farmer-defaultskin' => 'Пӯстаи Пешфарз',
	'farmer-defaultskin-button' => 'Гузоштани Пӯстаи Пешфарз',
	'farmer-extensions' => 'Афзунаҳои Фаъол',
	'farmer-extensions-button' => 'Гузоштани Афзунаҳои Фаъол',
	'farmer-extensions-extension-denied' => 'Барои истифодаи ин хусусият шумо дорои иҷоза нестед.
Шумо бояд аъзои гурӯҳи деҳқонмудир бошед.',
	'farmer-extensions-invalid' => 'Афзунаи Номӯътабар',
	'farmer-extensions-available' => 'Афзунаҳои Дастрас',
	'farmer-extensions-noavailable' => 'Ҳеҷ афзунаҳое сабт нашудаанд',
	'farmer-extensions-register' => 'Сабт кардани Афзуна',
	'farmer-extensions-register-text1' => 'Барои сабти афзунаи ҷадид дар киштзор аз форми зер истифода баред.
Дар ҳолати сабт шудани афзуна, ҳамаи викиҳо қобили истифода аз он хоҳанд шуд.',
	'farmer-extensions-register-name' => 'Ном',
	'farmer-error-exists' => 'Наметавон вики эҷод кард.  Он аллакай вуҷуд дорад: $1',
	'farmer-error-noextwrite' => 'Қобили навиштани парвандаи афзуна нест:',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'farmer' => 'Dehqon',
	'farmer-desc' => 'Idora kardani kiştzori MediaViki',
	'farmercantcreatewikis' => 'Şumo nametavoned vikiho eçod kuned, cun şumo doroi imtijozi eçodivikiho nested',
	'farmercreatesitename' => 'Nomi somona',
	'farmercreatenextstep' => "Qadami ba'dī",
	'farmer-about' => 'Dar borai',
	'farmer-about-text' => 'Dehqoni MediaViki ba şumo imkoni idora kardani vikihoi MediaVikiro medihad.',
	'farmer-list-wiki' => 'Fehristi Vikiho',
	'farmer-list-wiki-text' => 'Hamai vikihoi dar {{SITENAME}} budaro [[$1|fehrist]] kun',
	'farmer-createwiki' => 'Eçod kardani Viki',
	'farmer-createwiki-text' => 'Hamaknun jak vikiji çadid [[$1|eçod]] kuned!',
	'farmer-administration' => 'Mudirijati Kiştzor',
	'farmer-administration-extension' => 'Idora kardani Afzunaho',
	'farmer-administration-extension-text' => '[[$1|Idora kardani]] afzunahoi nasbşuda.',
	'farmer-admimistration-listupdate' => 'Barūzşaviji Fehristi Kiştzor',
	'farmer-admimistration-listupdate-text' => '[[$1|Barūz]] kardani vikiho dar {{SITENAME}}',
	'farmer-administration-delete' => 'Hazfi Viki',
	'farmer-administration-delete-text' => '[[$1|Hazf]] kardani viki az kiştzor',
	'farmer-administer-thiswiki' => 'Mudiri kardani in Viki',
	'farmer-administer-thiswiki-text' => '[[$1|Mudiri kardani]] taƣjiroti in Viki',
	'farmer-notavailable' => 'Dastras nest',
	'farmer-notavailable-text' => 'In xususijat tanho dar vikiji asosī dastras ast',
	'farmer-wikicreated' => 'Viki eçod şud',
	'farmer-wikicreated-text' => 'Vikiji şumo eçod şud.
On dar $1 dastras ast',
	'farmer-default' => 'Az rūi peşfarz, heç kas ba ƣajr az şumo ba in viki içozat ndorad.
Şumo metavoned imtijozoti korbariro tariqi $1 taƣjir bidihed',
	'farmer-wikiexists' => 'Viki vuçud dorad',
	'farmer-wikiexists-text' => "Vikie ki şumo kūşiş eçod kardan haste, '''$1''', allakaj vuçud dorad.
Lutfan bargarded va nomi digarero bisançed.",
	'farmer-confirmsetting' => 'Tasdiqi Tanzimoti Viki',
	'farmer-confirmsetting-name' => 'Nom',
	'farmer-confirmsetting-title' => 'Unvon',
	'farmer-confirmsetting-description' => 'Tavsif',
	'farmer-description' => 'Tavsifot',
	'farmer-button-confirm' => "Ta'jid",
	'farmer-button-submit' => 'Irsol',
	'farmer-createwiki-form-title' => 'Eçod kardani Viki',
	'farmer-createwiki-form-text1' => 'Baroi eçodi vikiji çadid az formi zerin istifoda bared.',
	'farmer-createwiki-form-help' => 'Rohnamo',
	'farmer-createwiki-user' => 'Nomi korbarī',
	'farmer-createwiki-name' => 'Nomi Viki',
	'farmer-createwiki-title' => 'Unvoni Viki',
	'farmer-createwiki-description' => 'Tavsifot',
	'farmer-updatedlist' => 'Fehristi barūzşuda',
	'farmer-notaccessible' => 'Dastras nest',
	'farmer-permissiondenied' => 'Içoza rad şud',
	'farmer-permissiondenied-text' => 'Şumo içozai hazf kardani viki az kiştzorro nadored',
	'farmer-permissiondenied-text1' => 'Şumo içozati dastrasi kardanro ba in sahifa nadored',
	'farmer-delete-title' => 'Hazf kardani Viki',
	'farmer-delete-text' => 'Lutfan vikiero, ki şumo majli hazf kardan dored, az fehristi zerin intixob kuned',
	'farmer-delete-form' => 'Intixob kardani viki',
	'farmer-delete-form-submit' => 'Hafz',
	'farmer-listofwikis' => 'Fehristi Vikiho',
	'farmer-mainpage' => 'Sahifai Aslī',
	'farmer-basic-title' => 'Parameterhoi asosī',
	'farmer-basic-title1' => 'Unvon',
	'farmer-basic-title1-text' => 'Vikiji şumo unvon nadorad. HOZIR jak unvon guzored',
	'farmer-basic-description' => 'Tavsifot',
	'farmer-basic-description-text' => 'Tavsifi vikiji xudro dar zer zehoti qaror bidihed',
	'farmer-basic-permission' => 'Içozaho',
	'farmer-basic-permission-text' => 'Bo istifodai formi zer, taƣjir dodani içozahoi korbaron dar in viki mumkin ast.',
	'farmer-basic-permission-visitor' => 'Içozaho baroi Har Taşrifovar',
	'farmer-basic-permission-visitor-text' => 'Içozahoi zer ba har şaxse, ki ba in viki taşrif meovarad şomil xohad şud',
	'farmer-yes' => 'Bale',
	'farmer-no' => 'Ne',
	'farmer-basic-permission-user' => 'Içozaho baroi Korbaroni Vurudşuda',
	'farmer-setpermission' => 'Guzoştani Içozaho',
	'farmer-defaultskin' => 'Pūstai Peşfarz',
	'farmer-defaultskin-button' => 'Guzoştani Pūstai Peşfarz',
	'farmer-extensions' => "Afzunahoi Fa'ol",
	'farmer-extensions-button' => "Guzoştani Afzunahoi Fa'ol",
	'farmer-extensions-extension-denied' => "Baroi istifodai in xususijat şumo doroi içoza nested.
Şumo bojad a'zoi gurūhi dehqonmudir boşed.",
	'farmer-extensions-invalid' => "Afzunai Nomū'tabar",
	'farmer-extensions-available' => 'Afzunahoi Dastras',
	'farmer-extensions-noavailable' => 'Heç afzunahoe sabt naşudaand',
	'farmer-extensions-register' => 'Sabt kardani Afzuna',
	'farmer-extensions-register-text1' => 'Baroi sabti afzunai çadid dar kiştzor az formi zer istifoda bared.
Dar holati sabt şudani afzuna, hamai vikiho qobili istifoda az on xohand şud.',
	'farmer-extensions-register-name' => 'Nom',
	'farmer-error-exists' => 'Nametavon viki eçod kard.  On allakaj vuçud dorad: $1',
	'farmer-error-noextwrite' => 'Qobili naviştani parvandai afzuna nest:',
);

/** Thai (ไทย)
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'farmer-button-confirm' => 'ยืนยัน',
	'farmer-delete-form-submit' => 'ลบ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'farmer-confirmsetting-name' => 'At',
	'farmer-confirmsetting-description' => 'Düşündiriş',
	'farmer-description' => 'Düşündiriş',
	'farmer-button-submit' => 'Tabşyr',
	'farmer-createwiki-user' => 'Ulanyjy ady:',
	'farmer-createwiki-description' => 'Düşündiriş',
	'farmer-delete-form-submit' => 'Öçür',
	'farmer-basic-description' => 'Düşündiriş',
	'farmer-extensions-register-name' => 'At',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'farmer' => 'Magsasaka (tagapaglinang)',
	'farmer-desc' => 'Pamahalaan ang isang linangan o "bukid" ng MediaWiki',
	'farmercantcreatewikis' => 'Hindi mo nakayanang lumikha ng mga wiki kasi wala kang pribilehiyong lumikha ng mga wiki',
	'farmercreatesitename' => 'Pangalan ng sityo',
	'farmercreatenextstep' => 'Susunod na hakbang',
	'farmernewwikimainpage' => '== Maligayang pagdating sa iyong wiki ==
Kapag nababasa mo ito, nailuklok ng tama ang iyong bagong wiki.
Maaari mong [[Special:Farmer|iayon sa nais mong disenyo ang iyong wiki]].',
	'farmer-about' => 'Patungkol',
	'farmer-about-text' => "Nagpapahintulot ang Magsasaka ng Mediawiki (''MediaWiki Farmer'') na mapamahalaan mo ang isang linangan ng mga wiki ng MediaWiki.",
	'farmer-list-wiki' => 'Talaan ng mga wiki',
	'farmer-list-wiki-text' => '[[$1|Itala]] ang lahat ng mga wiking nasa {{SITENAME}}',
	'farmer-createwiki' => 'Lumikha ng isang wiki',
	'farmer-createwiki-text' => '[[$1|Lumikha]] na ngayon ng isang bagong wiki!',
	'farmer-administration' => 'Pangangasiwa ng linangan',
	'farmer-administration-extension' => 'Pamahalaan ang mga karugtong',
	'farmer-administration-extension-text' => '[[$1|Pamahalaan]] ang nakaluklok na mga karugtong.',
	'farmer-admimistration-listupdate' => 'Pagsasapanahon ng talaan ng linangan',
	'farmer-admimistration-listupdate-text' => '[[$1|Isapanahon]] ang talaan ng mga wiking nasa {{SITENAME}}',
	'farmer-administration-delete' => 'Burahin ang isang wiki',
	'farmer-administration-delete-text' => '[[$1|Burahin]] ang isang wiki mula sa linangan',
	'farmer-administer-thiswiki' => 'Pangasiwaan ang wiking ito',
	'farmer-administer-thiswiki-text' => '[[$1|Pangasiwaan]] ang mga pagbabago sa wiking ito',
	'farmer-notavailable' => 'Hindi makukuha',
	'farmer-notavailable-text' => 'Makukuha lamang ang kasangkapang-katangiang ito mula sa pangunahing wiki',
	'farmer-wikicreated' => 'Nalikha na ang wiki',
	'farmer-wikicreated-text' => 'Nalikha na ang iyong wiki.
Mapupuntahan ito sa $1',
	'farmer-default' => 'Bilang likas na katakdaan, walang ibang may mga kapahintulutan sa wiking ito maliban sa iyo.
Mababago mo ang mga pribilehiyo ng tagagamit sa pamamagitan ng $1',
	'farmer-wikiexists' => 'Umiiral na ang wiki',
	'farmer-wikiexists-text' => "Umiiral na ang wiking '''$1''' na sinusubok mong likhain.
Bumalik po lamang at sumubok ng iba pang pangalan.",
	'farmer-confirmsetting' => 'Tiyakin ang mga katakdaan ng wiki',
	'farmer-confirmsetting-name' => 'Pangalan',
	'farmer-confirmsetting-title' => 'Pamagat',
	'farmer-confirmsetting-description' => 'Paglalarawan',
	'farmer-confirmsetting-reason' => 'Dahilan',
	'farmer-description' => 'Paglalarawan',
	'farmer-confirmsetting-text' => "Ang wiki mong '''$1''' ay mapupuntahan sa pamamagitan ng $3.
Ang espasyo ng pangalan ng proyekto ay magiging '''$2'''.
Ang mga kawing papunta sa espasyo ng pangalang ito ay magiging nasa anyong '''<nowiki>[[$2:Page name]]</nowiki>'''.
Kung ito ang nais mo, pindutin ang pindutang '''tiyakin''' na nasa ibaba.",
	'farmer-button-confirm' => 'Tiyakin',
	'farmer-button-submit' => 'Ipasa',
	'farmer-createwiki-form-title' => 'Lumikha ng isang wiki',
	'farmer-createwiki-form-text1' => 'Gamitin ang pormularyong nasa ibaba upang makalikha ng isang bagong wiki.',
	'farmer-createwiki-form-help' => 'Tulong',
	'farmer-createwiki-form-text2' => "; Pangalan ng wiki: Ang pangalan ng wiki.
Naglalaman lamang ng mga titik at mga bilang.
Gagamitin ang pangalan ng wiki bilang bahagi ng URL upang makilala ang iyong wiki.
Halimbawa na, kapag pinasok mo ang '''pamagat''', mapupuntahan pagdaka ang wiki mo sa pamamagitan ng <nowiki>http://</nowiki>'''pamagat'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Pamagat ng wiki: Ang pamagat ng wiki.
Gagamitin sa loob ng pamagat ng bawat isang pahinang nasa ibabaw ng iyong wiki.
Magiging espasyo ng pangalan rin ng proyekto at unlapi ng ugnayang-wiki.',
	'farmer-createwiki-form-text4' => '; Paglalarawan: Paglalarawan ng wiki.
Isa itong teksto ng paglalarawan hinggil sa wiki.
Ipapakita ito sa loob ng talaan ng wiki.',
	'farmer-createwiki-user' => 'Pangalan ng tagagamit',
	'farmer-createwiki-name' => 'Pangalan ng wiki',
	'farmer-createwiki-title' => 'Pamagat ng wiki',
	'farmer-createwiki-description' => 'Paglalarawan',
	'farmer-createwiki-reason' => 'Dahilan',
	'farmer-updatedlist' => 'Naisapanahong talaan',
	'farmer-notaccessible' => 'Hindi mapupuntahan',
	'farmer-notaccessible-test' => 'Makukuha lamang ang kasangkapang-katangiang ito mula sa magulang na wiki na nasa loob ng linangan',
	'farmer-permissiondenied' => 'Ipinagkait ang pahintulot',
	'farmer-permissiondenied-text' => 'Walang kang pahintulot na burahin ang isang wiki mula sa linangan',
	'farmer-permissiondenied-text1' => 'Wala kang pahintulot na mapuntahan ang pahinang ito',
	'farmer-deleting' => 'Nabura na ang wiking "$1"',
	'farmer-delete-confirm' => 'Tinitiyak kong nais kong burahin ang wiking ito',
	'farmer-delete-confirm-wiki' => "Buburahing wiki: '''$1'''.",
	'farmer-delete-reason' => 'Dahilan ng pagbubura:',
	'farmer-delete-title' => 'Burahin ang wiki',
	'farmer-delete-text' => 'Pakipili ang wiking nais mong burahin mula sa talaang nasa ibaba',
	'farmer-delete-form' => 'Pumili ng isang wiki',
	'farmer-delete-form-submit' => 'Burahin',
	'farmer-listofwikis' => 'Talaan ng mga wiki',
	'farmer-mainpage' => 'Unang Pahina',
	'farmer-basic-title' => 'Payak na mga parametro',
	'farmer-basic-title1' => 'Pamagat',
	'farmer-basic-title1-text' => 'Wala pang pamagat ang wiki mo. Magtakda ng isa <b>ngayon</b>',
	'farmer-basic-description' => 'Paglalarawan',
	'farmer-basic-description-text' => 'Itakda sa ibaba ang paglalarawan ng iyong wiki',
	'farmer-basic-permission' => 'Mga kapahintulutan',
	'farmer-basic-permission-text' => 'Sa pamamagitan ng pormularyong nasa ibaba, maaaring mangyaring baguhin ang mga pahintulot para sa mga tagagamit ng wiking ito.',
	'farmer-basic-permission-visitor' => 'Mga kapahintulutan para sa bawat isang panauhin',
	'farmer-basic-permission-visitor-text' => 'Ang sumusunod na mga kapahintulutan ay ihahain sa bawat isang taong dadalaw sa wiking ito',
	'farmer-yes' => 'Oo',
	'farmer-no' => 'Hindi',
	'farmer-basic-permission-user' => 'Mga kapahintulutan para sa nakalagdang mga tagagamit',
	'farmer-basic-permission-user-text' => 'Ang sumusunod na mga kapahintulutan ay ihahain sa bawat isang taong lumagdang papasok sa wiking ito',
	'farmer-setpermission' => 'Itakda ang mga pahintulot',
	'farmer-defaultskin' => 'Likas na nakatakdang pabalat',
	'farmer-defaultskin-button' => 'Itakda ang likas na nakatakdang pabalat',
	'farmer-extensions' => 'Masisiglang mga karugtong',
	'farmer-extensions-button' => 'Itakda ang masisiglang mga karugtong',
	'farmer-extensions-extension-denied' => 'Wala kang pahintulot na gamitin ang kasangkapang-katangiang ito.
Dapat na isa kang kasapi ng pangkat ng tagapangasiwa ng linangan.',
	'farmer-extensions-invalid' => 'Hindi tanggap na karugtong',
	'farmer-extensions-invalid-text' => 'Hindi namin maidagdag ang karugtong dahil hindi matagpuan ang talaksang napili para isama',
	'farmer-extensions-available' => 'Mga makukuhang karugtong',
	'farmer-extensions-noavailable' => 'Walang nakatalang mga karugtong',
	'farmer-extensions-register' => 'Ipatala ang karugtong',
	'farmer-extensions-register-text1' => 'Gamitin ang pormularyong nasa ibaba upang maipatala sa linangan ang bagong karugtong.
Kapag naipatala na ang isang karugtong, magagamit na ito ng lahat ng mga wiki.',
	'farmer-extensions-register-text2' => "Para sa parametrong ''Isama ang talaksan'', ipasok ang pangalan ng talaksang PHP na katulad ng sa ginagawa mo sa loob ng LocalSettings.php.",
	'farmer-extensions-register-text3' => "Kapag naglalaman ang pangalan ng talaksan ng '''\$root''', ang pabagu-bagong halagang iyan ay mapapalitan ng ugat na direktoryo ng MediaWiki.",
	'farmer-extensions-register-text4' => 'Ang pangkasalukuyang pansamang mga daanan ay:',
	'farmer-extensions-register-name' => 'Pangalan',
	'farmer-extensions-register-includefile' => 'Isama ang talaksan',
	'farmer-error-exists' => 'Hindi malikha ang wiki. Umiiral na ito: $1',
	'farmer-error-noextwrite' => 'Hindi nagawang maisulat palabas ang talaksan ng karugtong:',
	'farmer-log-name' => 'Talaan ng sakahan ng wiki',
	'farmer-log-header' => 'Isa itong talaan ng mga pagbabagong ginawa sa sakahan ng wiki.',
	'farmer-log-create' => 'nilikha ang wiking "$2"',
	'farmer-log-delete' => 'binura ang wiking "$2"',
	'right-farmeradmin' => 'Pamahalaan ang sakahan ng wiki',
	'right-createwiki' => 'Lumikha ng mga wiki sa loob ng sakahan ng wiki',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Mach
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'farmercreatesitename' => 'Site adı',
	'farmercreatenextstep' => 'Sonraki adım',
	'farmer-about' => 'Hakkında',
	'farmer-list-wiki' => 'Wikilerin listesi',
	'farmer-createwiki' => 'Bir viki oluştur',
	'farmer-administration-extension' => 'Eklentileri yönet',
	'farmer-administer-thiswiki' => 'Bu vikiyi yönet',
	'farmer-wikiexists' => 'Viki mevcut',
	'farmer-confirmsetting' => 'Viki ayarlarını onayla',
	'farmer-confirmsetting-name' => 'İsim',
	'farmer-confirmsetting-title' => 'Başlık',
	'farmer-confirmsetting-description' => 'Tanım',
	'farmer-confirmsetting-reason' => 'Neden',
	'farmer-description' => 'Tanım',
	'farmer-button-confirm' => 'Onayla',
	'farmer-button-submit' => 'Gönder',
	'farmer-createwiki-form-title' => 'Bir viki oluştur',
	'farmer-createwiki-form-text1' => 'Yeni bir viki oluşturmak için aşağıdaki formu kullan.',
	'farmer-createwiki-form-help' => 'Yardım',
	'farmer-createwiki-user' => 'Kullanıcı adı',
	'farmer-createwiki-name' => 'Wiki adı',
	'farmer-createwiki-title' => 'Viki adı',
	'farmer-createwiki-description' => 'Açıklama',
	'farmer-createwiki-reason' => 'Gerekçe',
	'farmer-updatedlist' => 'Güncellenmiş liste',
	'farmer-notaccessible' => 'Erişilebilir değil',
	'farmer-permissiondenied' => 'İzin reddedildi',
	'farmer-permissiondenied-text1' => 'Bu sayfaya erişme izniniz yok',
	'farmer-delete-confirm' => 'Bu vikiyi silmek istediğimi onaylarım',
	'farmer-delete-confirm-wiki' => "Silinecek viki: '''$1'''.",
	'farmer-delete-reason' => 'Silme gerekçesi:',
	'farmer-delete-title' => 'Vikiyi sil',
	'farmer-delete-form' => 'Bir viki seç',
	'farmer-delete-form-submit' => 'Sil',
	'farmer-listofwikis' => 'Wikilerin listesi',
	'farmer-mainpage' => 'Ana sayfa',
	'farmer-basic-title' => 'Temel parametreler',
	'farmer-basic-title1' => 'Başlık',
	'farmer-basic-description' => 'Tanım',
	'farmer-basic-description-text' => 'Aşağıdan vikinizin tanımını ayarlayın',
	'farmer-basic-permission' => 'İzinler',
	'farmer-basic-permission-visitor' => 'Tüm ziyaretçiler için izinler',
	'farmer-yes' => 'Evet',
	'farmer-no' => 'Hayır',
	'farmer-basic-permission-user-text' => 'Aşağıdaki vikiler bu vikide oturum açan herkes için geçerli olacak',
	'farmer-setpermission' => 'İzinleri ayarla',
	'farmer-defaultskin' => 'Varsayılan görünüm',
	'farmer-defaultskin-button' => 'Varsayılan görünümü belirle',
	'farmer-extensions' => 'Aktif eklentiler',
	'farmer-extensions-invalid' => 'Geçersiz eklentiler',
	'farmer-extensions-available' => 'Kullanılabilir eklentiler',
	'farmer-extensions-noavailable' => 'Kaydedilmiş uzantı yok',
	'farmer-extensions-register' => 'Eklentiyi kaydet',
	'farmer-extensions-register-name' => 'İsim',
	'farmer-extensions-register-includefile' => 'Dosyayı dahil et',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'farmer-createwiki-user' => 'ئىشلەتكۇچى ئىسمى',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'farmer-createwiki-user' => 'Ishletkuchi ismi',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'farmercreatesitename' => 'Назва сайту',
	'farmercreatenextstep' => 'Наступний крок',
	'farmer-list-wiki' => 'Список вікі',
	'farmer-list-wiki-text' => '[[$1|Список]] усіх вікі на сайті {{SITENAME}}',
	'farmer-createwiki' => 'Створити вікі',
	'farmer-notavailable' => 'Не доступно',
	'farmer-notavailable-text' => 'Ця функція доступна тільки на головній вікі',
	'farmer-wikicreated' => 'Вікі створена',
	'farmer-wikiexists' => 'Вікі існує',
	'farmer-confirmsetting' => 'Підтвердьте налаштування вікі',
	'farmer-confirmsetting-name' => 'Назва',
	'farmer-confirmsetting-title' => 'Заголовок',
	'farmer-confirmsetting-description' => 'Опис',
	'farmer-confirmsetting-reason' => 'Причина',
	'farmer-description' => 'Опис',
	'farmer-button-confirm' => 'Підтвердити',
	'farmer-button-submit' => 'Надіслати',
	'farmer-createwiki-form-title' => 'Створити вікі',
	'farmer-createwiki-form-help' => 'Довідка',
	'farmer-createwiki-user' => "Ім'я користувача",
	'farmer-createwiki-name' => 'Назва вікі',
	'farmer-createwiki-title' => 'Заголовок вікі',
	'farmer-createwiki-description' => 'Опис',
	'farmer-createwiki-reason' => 'Причина',
	'farmer-updatedlist' => 'Оновлений список',
	'farmer-notaccessible' => 'Не доступна',
	'farmer-permissiondenied' => 'Доступ заборонено',
	'farmer-permissiondenied-text1' => 'Ви не маєте дозволу на доступ до цієї сторінки',
	'farmer-delete-reason' => 'Причина вилучення:',
	'farmer-delete-form' => 'Виберіть вікі',
	'farmer-delete-form-submit' => 'Вилучити',
	'farmer-listofwikis' => 'Список вікі',
	'farmer-mainpage' => 'Головна сторінка',
	'farmer-basic-title' => 'Основні параметри',
	'farmer-basic-title1' => 'Заголовок',
	'farmer-basic-description' => 'Опис',
	'farmer-basic-permission' => 'Права',
	'farmer-yes' => 'Так',
	'farmer-no' => 'Ні',
	'farmer-defaultskin' => 'Оформлення за умовчанням',
	'farmer-defaultskin-button' => 'Встановити стандартне оформлення',
	'farmer-extensions' => 'Активні розширення',
	'farmer-extensions-available' => 'Доступні розширення',
	'farmer-extensions-register-name' => 'Назва',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'farmer-confirmsetting-reason' => 'وجہ',
	'farmer-createwiki-reason' => 'وجہ',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'farmer' => 'Fermer',
	'farmercreatesitename' => 'Saitan nimi',
	'farmercreatenextstep' => "Jäl'ghine haškuz",
	'farmer-about' => 'Informacii',
	'farmer-list-wiki' => 'Wikiden nimikirjutez',
	'farmer-createwiki' => 'Säta wiki',
	'farmer-administration' => 'Ferman administracii',
	'farmer-administration-delete' => 'Čuta wiki poiš',
	'farmer-administer-thiswiki' => 'Administriruida nece wiki',
	'farmer-notavailable' => 'Mugošt ei ole',
	'farmer-wikicreated' => 'Wiki om sätud',
	'farmer-wikiexists' => 'Mugoi wiki om jo olemas',
	'farmer-confirmsetting-name' => 'Nimi',
	'farmer-confirmsetting-title' => 'Pälkirjutez',
	'farmer-confirmsetting-description' => 'Ümbrikirjutamine',
	'farmer-confirmsetting-reason' => 'Sü',
	'farmer-description' => 'Ümbrikirjutamine',
	'farmer-button-confirm' => 'Vahvištoitta',
	'farmer-button-submit' => 'Oigeta',
	'farmer-createwiki-form-title' => 'Säta wiki',
	'farmer-createwiki-form-text1' => "Kävutagat form alahan, miše säta uz' wiki.",
	'farmer-createwiki-form-help' => 'Abu',
	'farmer-createwiki-user' => 'Kävutajan nimi',
	'farmer-createwiki-name' => 'Wikin nimi',
	'farmer-createwiki-title' => 'Wikin pälkirjutez',
	'farmer-createwiki-description' => 'Ümbrikirjutand',
	'farmer-createwiki-reason' => 'Sü',
	'farmer-updatedlist' => 'Udištadud nimikirjutez',
	'farmer-notaccessible' => 'Ei voi nähta',
	'farmer-deleting' => '"$1"-wiki om čutud poiš',
	'farmer-delete-title' => 'Čuta wiki poiš',
	'farmer-delete-form' => 'Valita wiki',
	'farmer-delete-form-submit' => 'Čuta poiš',
	'farmer-listofwikis' => 'Wikiden nimikirjutez',
	'farmer-mainpage' => "Pälehtpol'",
	'farmer-basic-title' => 'Päparametrad',
	'farmer-basic-title1' => 'Pälkirjutez',
	'farmer-basic-title1-text' => "Teiden wikil ei ole pälkirjutest. Tehkat se <b>nügüd'</b>",
	'farmer-basic-description' => 'Ümbrikirjutand',
	'farmer-basic-permission' => 'Oiktused',
	'farmer-yes' => 'Ka',
	'farmer-no' => 'Ei',
	'farmer-basic-permission-user' => 'Registriruidud kävutajiden oiktused',
	'farmer-extensions-invalid' => 'Vär liža',
	'farmer-extensions-register-name' => 'Nimi',
	'farmer-extensions-register-includefile' => 'Mülütada fail',
	'farmer-log-delete' => '"$2"-wiki om heittud poiš',
	'right-createwiki' => 'Säta wiki wiki-fermas',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'farmer' => 'Nông trại',
	'farmer-desc' => 'Quản lý một nông trại MediaWiki',
	'farmercantcreatewikis' => 'Bạn không thể tạo wiki vì bạn không có quyền createwikis',
	'farmercreatesitename' => 'Tên trang',
	'farmercreatenextstep' => 'Bước tiếp theo',
	'farmernewwikimainpage' => '== Hoan nghênh đã đến với Wiki của bạn ==
Nếu bạn đang đọc câu này, wiki mới của bạn đã được cài đặt đúng đắn.
Bạn có thể [[Special:Farmer|điều chỉnh wiki của mình]].',
	'farmer-about' => 'Giới thiệu',
	'farmer-about-text' => 'Nông trại MediaWiki cho phép bạn quản lý một nông trại gồm các wiki MediaWiki.',
	'farmer-list-wiki' => 'Danh sách các Wiki',
	'farmer-list-wiki-text' => '[[$1|Liệt kê]] tất cả các wiki trên {{SITENAME}}',
	'farmer-createwiki' => 'Tạo một Wiki',
	'farmer-createwiki-text' => '[[$1|Tạo]] một wiki mới ngay bây giờ!',
	'farmer-administration' => 'Quản trị Nông trại',
	'farmer-administration-extension' => 'Quản lý phần mở rộng',
	'farmer-administration-extension-text' => '[[$1|Quản lý]] đã phần mở rộng đã cài đặt.',
	'farmer-admimistration-listupdate' => 'Cập nhật danh sách nông trại',
	'farmer-admimistration-listupdate-text' => '[[$1|Cập nhật]] danh sách các wiki trên {{SITENAME}}',
	'farmer-administration-delete' => 'Xóa một Wiki',
	'farmer-administration-delete-text' => '[[$1|Xóa]] một wiki ra khỏi nông trại',
	'farmer-administer-thiswiki' => 'Quản trị Wiki này',
	'farmer-administer-thiswiki-text' => '[[$1|Quản trị]] các thay đổi tại wiki này',
	'farmer-notavailable' => 'Không có sẵn',
	'farmer-notavailable-text' => 'Tính năng này chỉ có tại wiki chính',
	'farmer-wikicreated' => 'Đã tạo Wiki',
	'farmer-wikicreated-text' => 'Wiki của bạn đã được tạo.
Nó có thể vào được tại $1',
	'farmer-default' => 'Theo mặc định, không ai có quyền tại wiki này trừ bạn.
Bạn có thể thay đổi quyền thành viên thông qua $1',
	'farmer-wikiexists' => 'Wiki đã tồn tại',
	'farmer-wikiexists-text' => "Wiki mà bạn đang cố tạo, '''$1''', đã tồn tại.
Xin hãy quay lại và thử một tên khác.",
	'farmer-confirmsetting' => 'Xác nhận các thiết lập Wiki',
	'farmer-confirmsetting-name' => 'Tên',
	'farmer-confirmsetting-title' => 'Tựa',
	'farmer-confirmsetting-description' => 'Miêu tả',
	'farmer-confirmsetting-reason' => 'Lý do',
	'farmer-description' => 'Miêu tả',
	'farmer-confirmsetting-text' => "Wiki của bạn, '''$1''', sẽ vào được thông qua $3.
Không gian tên dự án sẽ là '''$2'''.
Liên kết đến không gian tên này sẽ có dạng '''<nowiki>[[$2:Page name]]</nowiki>'''.
Nếu đây là điều bạn muốn, hãy nhấn nút '''xác nhận''' ở dưới.",
	'farmer-button-confirm' => 'Xác nhận',
	'farmer-button-submit' => 'Chấp nhận',
	'farmer-createwiki-form-title' => 'Tạo một Wiki',
	'farmer-createwiki-form-text1' => 'Sử dụng mẫu dưới đây để tạo một wiki mới.',
	'farmer-createwiki-form-help' => 'Trợ giúp',
	'farmer-createwiki-form-text2' => "Ví dụ, nếu bạn gõ vào '''tựa đề''', wiki của bạn sẽ truy cập được thông qua <nowiki>http://</nowiki>'''tựa đề'''.tênmiền.",
	'farmer-createwiki-form-text3' => '; Tựa đề Wiki: Tựa đề của wiki.
Sẽ được dùng tại tựa đề của mỗi trang trong wiki của bạn.
Cũng sẽ là không gian tên dự án và tiền tốc liên wiki.',
	'farmer-createwiki-form-text4' => '; Miêu tả: Miêu tả wiki.
Đây là dòng miêu tả bằng chữ về wiki.
Nó sẽ được hiển thị tại danh sách wiki.',
	'farmer-createwiki-user' => 'Tên người dùng',
	'farmer-createwiki-name' => 'Tên wiki',
	'farmer-createwiki-title' => 'Tựa đề wiki',
	'farmer-createwiki-description' => 'Miêu tả',
	'farmer-createwiki-reason' => 'Lý do',
	'farmer-updatedlist' => 'Đã cập nhật danh sách',
	'farmer-notaccessible' => 'Không truy cập được',
	'farmer-notaccessible-test' => 'Tính năng này chỉ có tại wiki mẹ trong nông trại',
	'farmer-permissiondenied' => 'Không cho phép',
	'farmer-permissiondenied-text' => 'Bạn không có quyền xóa một wiki khỏi nông trại',
	'farmer-permissiondenied-text1' => 'Bạn không có quyền truy cập trang này',
	'farmer-deleting' => 'Đã xóa wiki “$1”',
	'farmer-delete-confirm' => 'Tôi muốn xóa wiki này',
	'farmer-delete-confirm-wiki' => "Wiki để xóa: '''$1'''.",
	'farmer-delete-reason' => 'Lý do xóa:',
	'farmer-delete-title' => 'Xóa Wiki',
	'farmer-delete-text' => 'Xin hãy chọn wiki mà bạn muốn xóa từ danh sách dưới đây',
	'farmer-delete-form' => 'Chọn một wiki',
	'farmer-delete-form-submit' => 'Xóa',
	'farmer-listofwikis' => 'Danh sách các Wiki',
	'farmer-mainpage' => 'Trang Chính',
	'farmer-basic-title' => 'Tham số cơ bản',
	'farmer-basic-title1' => 'Tựa đề',
	'farmer-basic-title1-text' => 'Wiki của bạn không có tựa đề.  Hãy thiết lập một cái NGAY BÂY GIỜ',
	'farmer-basic-description' => 'Miêu tả',
	'farmer-basic-description-text' => 'Ghi mô tả cho wiki của bạn ở phía dưới',
	'farmer-basic-permission' => 'Quyền hạn',
	'farmer-basic-permission-text' => 'Bằng cách sử dụng mẫu ở dưới, bạn có thể thay đổi quyền hạn cho thành viên của wiki này.',
	'farmer-basic-permission-visitor' => 'Quyền cho Mỗi Khách Viếng Thăm',
	'farmer-basic-permission-visitor-text' => 'Những quyền sau sẽ áp dụng cho mỗi người dùng đến thăm wiki này',
	'farmer-yes' => 'Có',
	'farmer-no' => 'Không',
	'farmer-basic-permission-user' => 'Quyền hạn cho Thành viên đăng nhập',
	'farmer-basic-permission-user-text' => 'Những quyền sau đây sẽ áp dụng cho những người đã đăng nhập vào wiki này',
	'farmer-setpermission' => 'Thiết lập quyền hạn',
	'farmer-defaultskin' => 'Hình dạng mặc định',
	'farmer-defaultskin-button' => 'Thiết lập hình dạng mặc định',
	'farmer-extensions' => 'Các phần mở rộng sẽ dùng',
	'farmer-extensions-button' => 'Thiết lập các phần mở rộng sẽ dùng',
	'farmer-extensions-extension-denied' => 'Bạn không có quyền sử dụng tính năng này.
Bạn phải thành viên của nhóm quản trị nông trại',
	'farmer-extensions-invalid' => 'Phần mở rộng không hợp lệ',
	'farmer-extensions-invalid-text' => 'Chúng tôi không thể thêm phần mở rộng vì không thể tìm thấy tập tin bạn chọn để nhúng vào',
	'farmer-extensions-available' => 'Những phần mở rộng có sẵn',
	'farmer-extensions-noavailable' => 'Không có phần mở rộng nào được đăng ký',
	'farmer-extensions-register' => 'Đăng ký phần mở rộng',
	'farmer-extensions-register-text1' => 'Sử dụng mẫu dưới đây để đăng ký một phần mở rộng mới cho nông trại.
Sau khi đã đăng ký một phần mở rộng, tất cả các wiki sẽ có thể sử dụng nó.',
	'farmer-extensions-register-text2' => "Đối với tham số ''Tập tin được nhúng'', gõ vào tên của tập tin PHP mà bạn đã ghi trong LocalSettings.php.",
	'farmer-extensions-register-text3' => "Nếu tập tin có chứa '''\$root''', biến đó sẽ được thay bằng thư mục gốc của MediaWiki.",
	'farmer-extensions-register-text4' => 'Đường dẫn để nhúng hiện tại là:',
	'farmer-extensions-register-name' => 'Tên',
	'farmer-extensions-register-includefile' => 'Nhúng tập tin',
	'farmer-error-exists' => 'Không thể khởi tạo wiki.  Nó đã tồn tại: $1',
	'farmer-error-noextwrite' => 'Không thể ghi ra tập tin mở rộng:',
	'farmer-log-name' => 'Nhật trình mạng wiki',
	'farmer-log-header' => 'Đây là nhật trình các thay đổi trên mạng wiki.',
	'farmer-log-create' => 'tạo wiki “$2”',
	'farmer-log-delete' => 'xóa wiki “$2”',
	'right-farmeradmin' => 'Quản lý nông trại wiki',
	'right-createwiki' => 'Tạo wiki trong nông trại wiki',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'farmer' => 'Farman',
	'farmercantcreatewikis' => 'No kanol jafön vüki bi no labol privilegi tefik („createwikis“)',
	'farmercreatesitename' => 'Sitanem',
	'farmer-about' => 'Tefü',
	'farmer-list-wiki' => 'Lised vükas',
	'farmer-createwiki' => 'Jafön vüki',
	'farmer-notavailable' => 'No gebidon',
	'farmer-wikicreated-text' => 'Vük olik pejafon.
Binon lügolovik as $1',
	'farmer-wikiexists' => 'Vük dabinon',
	'farmer-wikiexists-text' => "Vük, keli steifülol ad jafön, '''$1''', ya dabinon.
Geikolös e gebolös nemi votik.",
	'farmer-confirmsetting' => 'Fümedön parametemi vüka',
	'farmer-confirmsetting-name' => 'Nem',
	'farmer-confirmsetting-title' => 'Tiäd',
	'farmer-confirmsetting-description' => 'Bepenam',
	'farmer-description' => 'Bepenam',
	'farmer-button-confirm' => 'Fümedön',
	'farmer-button-submit' => 'Sedön',
	'farmer-createwiki-form-title' => 'Jafön vüki',
	'farmer-createwiki-form-text1' => 'Gebolös fometi dono ad jafön vüki nulik.',
	'farmer-createwiki-form-help' => 'Yuf',
	'farmer-createwiki-form-text2' => "; Vükanem: Nem vüka.
Ninädon te tonatis e numatis.
Vükanem pogebon as dil ela URL ad dientifükön vüki olik.
Samo, if penol '''tiäd''', tän vük olik potuvon medü <nowiki>http://</nowiki>'''tiäd'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Vükatiäd: Tiäd vüka.
Pogebon pö tiäd pada alik su vük olik.
Obinon i foyümot proyeganemaspada e yümas vüvükik.',
	'farmer-createwiki-form-text4' => '; Bepenam: Bepenam vüka.
Atos binon bepenam vödemik tefü vük.
Atos pajonon su vükalised.',
	'farmer-createwiki-user' => 'Gebananem',
	'farmer-createwiki-name' => 'Vükanem',
	'farmer-createwiki-title' => 'Vükatiäd',
	'farmer-createwiki-description' => 'Bepenam',
	'farmer-permissiondenied' => 'Däl no pegevon',
	'farmer-permissiondenied-text' => 'No labol däli ad moükön vüki se farm',
	'farmer-deleting' => 'Vük: "$1" pemoükon',
	'farmer-delete-title' => 'Moükön vüki',
	'farmer-delete-text' => 'Välolös vüki se lised dono ad pamoükön',
	'farmer-delete-form' => 'Välön vüki',
	'farmer-delete-form-submit' => 'Moükön',
	'farmer-listofwikis' => 'Lised vükas',
	'farmer-mainpage' => 'Cifapad',
	'farmer-basic-title' => 'Cifaparamets',
	'farmer-basic-title1' => 'Tiäd:',
	'farmer-basic-title1-text' => 'Vük olik no labon tiädi. Välolöd bali <b>anu</b>',
	'farmer-basic-description' => 'Bepenam',
	'farmer-basic-description-text' => 'Penolös bepenami vüka olik dono',
	'farmer-basic-permission' => 'Däls',
	'farmer-yes' => 'Si',
	'farmer-no' => 'Nö',
	'farmer-extensions-register-name' => 'Nem',
	'farmer-error-exists' => 'Vük no kanon pajafön bi ya dabinon: $1',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'farmer-confirmsetting-reason' => '理由：',
	'farmer-createwiki-reason' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'farmer-about' => 'וועגן',
	'farmer-confirmsetting-name' => 'נאָמען',
	'farmer-confirmsetting-title' => 'טיטל',
	'farmer-confirmsetting-description' => 'באַשרייַבונג',
	'farmer-confirmsetting-reason' => 'אורזאַך',
	'farmer-createwiki-form-title' => 'שאַפֿן אַ וויקי',
	'farmer-createwiki-form-help' => 'הילף',
	'farmer-createwiki-user' => 'באַניצער נאָמען',
	'farmer-createwiki-reason' => 'אורזאַך',
	'farmer-delete-form' => 'אויסקלויבן א וויקי',
	'farmer-delete-form-submit' => 'אויסמעקן',
	'farmer-basic-title1' => 'טיטל',
	'farmer-no' => 'ניין',
	'farmer-extensions-register-name' => 'נאָמען',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Hydra
 * @author Hzy980512
 * @author Liangent
 * @author PhiLiP
 * @author Wmr89502270
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'farmer' => '农场',
	'farmer-desc' => '管理一个MediaWiki农场',
	'farmercantcreatewikis' => '因为你没有createwikis权限，你不能创建wiki',
	'farmercreatesitename' => '网站名称',
	'farmercreatenextstep' => '下一步',
	'farmernewwikimainpage' => '== 欢迎来到你的wiki ==
如果你能读到这里，你能新wiki已经被正确安装。
你可以[[Special:Farmer|定制你的wiki]]。',
	'farmer-about' => '关于',
	'farmer-about-text' => 'MediaWiki农场允许你管理一个MediaWiki wiki的农场。',
	'farmer-list-wiki' => 'Wiki列表',
	'farmer-list-wiki-text' => '[[$1|列出]]{{SITENAME}}上的所有wiki',
	'farmer-createwiki' => '建立一个Wiki',
	'farmer-createwiki-text' => '立刻[[$1|创建]]一个新的wiki！',
	'farmer-administration' => '农场管理',
	'farmer-administration-extension' => '管理扩展',
	'farmer-administration-extension-text' => '[[$1|管理]]已安装的插件。',
	'farmer-admimistration-listupdate' => '农场列表更新',
	'farmer-admimistration-listupdate-text' => '[[$1|更新]]{{SITENAME}}上的wiki列表',
	'farmer-administration-delete' => '删除一个wiki',
	'farmer-administration-delete-text' => '从农场中[[$1|删除]]一个wiki',
	'farmer-administer-thiswiki' => '管理这个wiki',
	'farmer-administer-thiswiki-text' => '[[$1|管理]]这个wiki的改变',
	'farmer-notavailable' => '不可用',
	'farmer-notavailable-text' => '这个功能只在主wiki可用',
	'farmer-wikicreated' => 'Wiki已被建立',
	'farmer-wikicreated-text' => '你的wiki已经被创建。
它可以在 $1 被访问',
	'farmer-default' => '默认情况下，除了你，这个wiki上没有任何人有权限。
你可以通过 $1 改变用户权限',
	'farmer-wikiexists' => 'Wiki存在',
	'farmer-wikiexists-text' => "你正在尝试创建的wiki，'''$1'''，已经存在。
请后退并尝试另一个名字。",
	'farmer-confirmsetting' => '确认wiki设置',
	'farmer-confirmsetting-name' => '名字',
	'farmer-confirmsetting-title' => '标题',
	'farmer-confirmsetting-description' => '说明',
	'farmer-confirmsetting-reason' => '原因',
	'farmer-description' => '说明',
	'farmer-confirmsetting-text' => "您的维基'''$1'''将可以从$3进入。
项目名字空间将为'''$2'''。
链接至改名字空间的格式将为'''<nowiki>[[$2:页面名称]]</nowiki>'''。
确认无误后，请点击“确认”按钮。",
	'farmer-button-confirm' => '确认',
	'farmer-button-submit' => '提交',
	'farmer-createwiki-form-title' => '创建一个wiki',
	'farmer-createwiki-form-text1' => '使用下面的表单来创建一个新的wiki。',
	'farmer-createwiki-form-help' => '帮助',
	'farmer-createwiki-form-text2' => "; 维基名称：该维基的名称。
只包含字母和数字。
维基名称将作为子域名的一部分来指向您的维基。
例如，输入'''title'''作为名称，您的维基将需要使用<nowiki>http://</nowiki>'''title'''.mydomain来进入。",
	'farmer-createwiki-form-text3' => '; 维基标题：该维基的标题。
它将显示于您维基中的所有页面。
并且也会用作项目名字空间以及跨维基前缀。',
	'farmer-createwiki-form-text4' => '; 描述：该维基的描述。
描述该维基的文字。
将显示于维基列表中。',
	'farmer-createwiki-user' => '用户名',
	'farmer-createwiki-name' => 'Wiki名称',
	'farmer-createwiki-title' => 'Wiki标题',
	'farmer-createwiki-description' => '说明',
	'farmer-createwiki-reason' => '原因',
	'farmer-updatedlist' => '已更新的列表',
	'farmer-notaccessible' => '不可访问',
	'farmer-notaccessible-test' => '这个功能只在农场中的父wiki可用',
	'farmer-permissiondenied' => '权限错误',
	'farmer-permissiondenied-text' => '你没有从农场中删除一个wiki的权限',
	'farmer-permissiondenied-text1' => '你没有访问这个页面的权限',
	'farmer-deleting' => '“$1”已被删除',
	'farmer-delete-confirm' => '我确认我想要删除这个wiki',
	'farmer-delete-confirm-wiki' => "要删除的wiki：'''$1'''。",
	'farmer-delete-reason' => '删除的原因：',
	'farmer-delete-title' => '删除Wiki',
	'farmer-delete-text' => '请从下面的列表中选择你要删除的wiki',
	'farmer-delete-form' => '选择一个Wiki',
	'farmer-delete-form-submit' => '删除',
	'farmer-listofwikis' => 'wiki列表',
	'farmer-mainpage' => '首页',
	'farmer-basic-title' => '基本参数',
	'farmer-basic-title1' => '标题',
	'farmer-basic-title1-text' => '你的wiki没有一个标题。<b>现在</b>设置一个',
	'farmer-basic-description' => '说明',
	'farmer-basic-description-text' => '在下面设置你的wiki的描述',
	'farmer-basic-permission' => '权限',
	'farmer-basic-permission-text' => '使用下面的表格，它是可以修改此维基的用户的权限。',
	'farmer-basic-permission-visitor' => '用于每个访问者的权限',
	'farmer-basic-permission-visitor-text' => '下列权限将应用于每个用户访问此维基的人',
	'farmer-yes' => '是',
	'farmer-no' => '否',
	'farmer-basic-permission-user' => '用于已登录用户的权限',
	'farmer-basic-permission-user-text' => '下列权限将应用于已登录到此维基的每一个人',
	'farmer-setpermission' => '设置权限',
	'farmer-defaultskin' => '默认皮肤',
	'farmer-defaultskin-button' => '设为默认皮肤',
	'farmer-extensions' => '活跃的扩展',
	'farmer-extensions-button' => '设置活跃的扩展',
	'farmer-extensions-extension-denied' => '你没有使用这个功能的权限。
你必须是farmeradmin组的成员',
	'farmer-extensions-invalid' => '无效的扩展',
	'farmer-extensions-invalid-text' => '我们不能添加的扩展是因为找不到包含选定的文件',
	'farmer-extensions-available' => '可用的扩展',
	'farmer-extensions-noavailable' => '没有注册扩展',
	'farmer-extensions-register' => '注册扩展',
	'farmer-extensions-register-text1' => '使用下面的表单来为农场注册一个新的扩展。
一旦一个扩展被注册，所有的wiki都可以使用它。',
	'farmer-extensions-register-text3' => "若文件名包含'''\$root'''，则那个变量将用于代替MediaWiki的根目录。",
	'farmer-extensions-register-text4' => '目前的包含路径是：',
	'farmer-extensions-register-name' => '名称',
	'farmer-extensions-register-includefile' => '包括文件',
	'farmer-error-exists' => '不能创建wiki。它已经存在：$1',
	'farmer-error-noextwrite' => '不能写入扩展文件：',
	'farmer-log-name' => 'Wiki农场日志',
	'farmer-log-header' => '这是对wiki农场的改变的日志。',
	'farmer-log-create' => '创建了wiki “$2”',
	'farmer-log-delete' => '删除了wiki “$2”',
	'right-farmeradmin' => '管理wiki农场',
	'right-createwiki' => '在wiki农场中创建wiki',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'farmer' => '農場',
	'farmer-desc' => '管理一個 MediaWiki 農場',
	'farmercantcreatewikis' => '因為你沒有 createwikis 權限，你不能建立 wiki',
	'farmercreatesitename' => '網站名稱',
	'farmercreatenextstep' => '下一步',
	'farmernewwikimainpage' => '== 歡迎來到你的wiki ==
如果你能讀到這裡，你能新wiki已經被正確安裝。
你可以[[Special:Farmer|定製你的wiki]]。',
	'farmer-about' => '關於',
	'farmer-about-text' => 'MediaWiki 農場允許你管理一個 MediaWiki wiki 的農場。',
	'farmer-list-wiki' => 'Wiki 清單',
	'farmer-list-wiki-text' => '[[$1|列出]]{{SITENAME}}上的所有 wiki',
	'farmer-createwiki' => '建立一個 wiki',
	'farmer-createwiki-text' => '立刻[[$1|創建]]一個新的 wiki！',
	'farmer-administration' => '農場管理',
	'farmer-administration-extension' => '管理擴充套件',
	'farmer-administration-extension-text' => '[[$1|管理]]已安裝的插件。',
	'farmer-admimistration-listupdate' => '農場列表更新',
	'farmer-admimistration-listupdate-text' => '[[$1|更新]]{{SITENAME}}上的wiki列表',
	'farmer-administration-delete' => '刪除一個wiki',
	'farmer-administration-delete-text' => '從農場中[[$1|刪除]]一個wiki',
	'farmer-administer-thiswiki' => '管理這個 wiki',
	'farmer-administer-thiswiki-text' => '[[$1|管理]]這個 wiki 的改變',
	'farmer-notavailable' => '不可用',
	'farmer-notavailable-text' => '這個功能只在主 wiki 可用',
	'farmer-wikicreated' => '已建立 wiki',
	'farmer-wikicreated-text' => '你的 wiki 已經被建立。
它可以在 $1 被訪問',
	'farmer-default' => '預設情況下，除了你，這個 wiki 上沒有任何人有權限。
你可以通過 $1 改變用戶權限',
	'farmer-wikiexists' => 'Wiki 存在',
	'farmer-wikiexists-text' => "你正在嘗試建立的 wiki，'''$1'''，已經存在。
請後退並嘗試另一個名字。",
	'farmer-confirmsetting' => '確認 wiki 設定',
	'farmer-confirmsetting-name' => '名字',
	'farmer-confirmsetting-title' => '標題',
	'farmer-confirmsetting-description' => '描述',
	'farmer-confirmsetting-reason' => '原因',
	'farmer-description' => '描述',
	'farmer-button-confirm' => '確認',
	'farmer-button-submit' => '提交',
	'farmer-createwiki-form-title' => '建立一個 wiki',
	'farmer-createwiki-form-text1' => '使用下面的表單來建立一個新的 wiki。',
	'farmer-createwiki-form-help' => '說明',
	'farmer-createwiki-user' => '使用者名稱',
	'farmer-createwiki-name' => 'Wiki 名稱',
	'farmer-createwiki-title' => 'Wiki 標題',
	'farmer-createwiki-description' => '描述',
	'farmer-createwiki-reason' => '原因',
	'farmer-updatedlist' => '已更新的清單',
	'farmer-notaccessible' => '不可訪問',
	'farmer-notaccessible-test' => '這個功能只在農場中的父 wiki 可用',
	'farmer-permissiondenied' => '權限錯誤',
	'farmer-permissiondenied-text' => '你沒有從農場中刪除一個 wiki 的權限',
	'farmer-permissiondenied-text1' => '你沒有訪問這個頁面的權限',
	'farmer-deleting' => '「$1」已被刪除',
	'farmer-delete-confirm' => '我確認我想要刪除這個 wiki',
	'farmer-delete-confirm-wiki' => "要刪除的 wiki：'''$1'''。",
	'farmer-delete-reason' => '刪除的原因：',
	'farmer-delete-title' => '刪除 wiki',
	'farmer-delete-text' => '請從下面的列表中選擇你要刪除的 wiki',
	'farmer-delete-form' => '選擇一個 wiki',
	'farmer-delete-form-submit' => '刪除',
	'farmer-listofwikis' => 'wiki 列表',
	'farmer-mainpage' => '首頁',
	'farmer-basic-title' => '基本參數',
	'farmer-basic-title1' => '標題',
	'farmer-basic-title1-text' => '你的 wiki 沒有一個標題。<b>現在</b>設定一個',
	'farmer-basic-description' => '描述',
	'farmer-basic-description-text' => '在下面設定你的 wiki 的描述',
	'farmer-basic-permission' => '權限',
	'farmer-basic-permission-text' => '使用下面的表格，它是可以修改此維基的用戶的權限。',
	'farmer-basic-permission-visitor' => '用於每個訪問者的權限',
	'farmer-basic-permission-visitor-text' => '下列權限將應用於每個用戶訪問此維基的人',
	'farmer-yes' => '是',
	'farmer-no' => '否',
	'farmer-basic-permission-user' => '用於已登入用戶的權限',
	'farmer-basic-permission-user-text' => '下列權限將應用於已登錄到此維基的每一個人',
	'farmer-setpermission' => '設定權限',
	'farmer-defaultskin' => '預設外觀',
	'farmer-defaultskin-button' => '設為預設外觀',
	'farmer-extensions' => '活躍的擴充套件',
	'farmer-extensions-button' => '設定活躍的擴充套件',
	'farmer-extensions-extension-denied' => '你沒有使用這個功能的權限。
你必須是 farmeradmin 群組的成員',
	'farmer-extensions-invalid' => '無效的擴充套件',
	'farmer-extensions-invalid-text' => '我們不能添加的擴展是因為找不到包含選定的文件',
	'farmer-extensions-available' => '可用的擴充套件',
	'farmer-extensions-noavailable' => '沒有註冊的擴充套件',
	'farmer-extensions-register' => '註冊擴充套件',
	'farmer-extensions-register-text1' => '使用下面的表單來為農場註冊一個新的擴充套件。
一旦一個擴充套件被註冊，所有的 wiki 都可以使用它。',
	'farmer-extensions-register-text4' => '目前的包含路徑是：',
	'farmer-extensions-register-name' => '名稱',
	'farmer-extensions-register-includefile' => '包含檔案',
	'farmer-error-exists' => '不能建立 wiki。它已經存在：$1',
	'farmer-error-noextwrite' => '不能寫入擴充套件檔案：',
	'farmer-log-name' => 'Wiki 農場日誌',
	'farmer-log-header' => '這是對 wiki 農場的改變的日誌。',
	'farmer-log-create' => '建立了 wiki 「$2」',
	'farmer-log-delete' => '刪除了 wiki 「$2」',
	'right-farmeradmin' => '管理 wiki 農場',
	'right-createwiki' => '在 wiki 農場中建立 wiki',
);

