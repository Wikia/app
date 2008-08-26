<?php

$messages = array();

$messages['en'] = array(
		'extensiondistributor' => 'Download MediaWiki extension',
		'extdist-desc' => 'Extension for distributing snapshot archives of extensions',
		'extdist-not-configured' => 'Please configure $wgExtDistTarDir and $wgExtDistWorkingCopy',
		'extdist-wc-missing' => 'The configured working copy directory does not exist!',
		'extdist-no-such-extension' => 'No such extension "$1"',
		'extdist-no-such-version' => 'The extension "$1" does not exist in the version "$2".',
		'extdist-choose-extension' => 'Select which extension you want to download:',
		'extdist-wc-empty' => 'The configured working copy directory has no distributable extensions!',
		'extdist-submit-extension' => 'Continue',
		'extdist-current-version' => 'Current version (trunk)',
		'extdist-choose-version' => '
<big>You are downloading the <b>$1</b> extension.</big>

Select your MediaWiki version. 

Most extensions work across multiple versions of MediaWiki, so if your MediaWiki version is not here, or if you have a need for the latest extension features, try using the current version.',
		'extdist-no-versions' => 'The selected extension ($1) is not available in any version!',
		'extdist-submit-version' => 'Continue',
		'extdist-no-remote' => 'Unable to contact remote subversion client.',
		'extdist-remote-error' => 'Error from remote subversion client: <pre>$1</pre>',
		'extdist-remote-invalid-response' => 'Invalid response from remote subversion client.',
		'extdist-svn-error' => 'Subversion encountered an error: <pre>$1</pre>',
		'extdist-svn-parse-error' => 'Unable to process the XML from "svn info": <pre>$1</pre>',
		'extdist-tar-error' => 'Tar returned exit code $1:',
		'extdist-created' => "A snapshot of version <b>$2</b> of the <b>$1</b> extension for MediaWiki <b>$3</b> has been created. Your download should start automatically in 5 seconds. 

The URL for this snapshot is:
:$4
It may be used for immediate download to a server, but please do not bookmark it, since the contents will not be updated, and it may be deleted at a later date.

The tar archive should be extracted into your extensions directory. For example, on a unix-like OS:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

On Windows, you can use [http://www.7-zip.org/ 7-zip] to extract the files.

If your wiki is on a remote server, extract the files to a temporary directory on your local computer, and then upload '''all''' of the extracted files to the extensions directory on the server.

Note that some extensions need a file called ExtensionFunctions.php, located at <tt>extensions/ExtensionFunctions.php</tt>, that is, in the ''parent'' directory of this particular extension's directory. The snapshot for these extensions contains this file as a tarbomb, extracted to ./ExtensionFunctions.php. Do not neglect to upload this file to your remote server.

After you have extracted the files, you will need to register the extension in LocalSettings.php. The extension documentation should have instructions on how to do this.

If you have any questions about this extension distribution system, please go to [[Extension talk:ExtensionDistributor]].
",
		'extdist-want-more' => 'Get another extension',
);

/** Arabic (العربية)
 * @author OsamaK
 * @author Meno25
 */
$messages['ar'] = array(
	'extensiondistributor'            => 'تنزيل امتداد ميدياويكي',
	'extdist-desc'                    => 'امتداد لتوزيع أرشيفات ملتقطة للامتدادات',
	'extdist-not-configured'          => 'من فضلك اضبط $wgExtDistTarDir و $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'مجلد نسخة العمل المحدد غير موجود!',
	'extdist-no-such-extension'       => 'لا امتداد كهذا "$1"',
	'extdist-no-such-version'         => 'الامتداد "$1" لا يوجد في النسخة "$2".',
	'extdist-choose-extension'        => 'اختر أي امتدات تريد تحميله:',
	'extdist-wc-empty'                => 'مجلد نسخة العمل المضبوط ليس به امتدادات قابلة للتوزيع!',
	'extdist-submit-extension'        => 'استمر',
	'extdist-current-version'         => 'النسخة الحالية (جذع)',
	'extdist-choose-version'          => '<big>أنت تقوم بتنزيل امتداد <b>$1</b>.</big>

اختر نسخة ميدياويكي الخاصة بك.  

معظم الامتدادات تعمل خلال نسخ متعددة من ميدياويكي، لذا إذا كانت نسخة ميدياويكي الخاصة بك ليست هنا، أو لو كانت لديك حاجة لأحدث خواص الامتداد، حاول استخدام النسخة الحالية.',
	'extdist-no-versions'             => 'الامتداد المختار ($1) غير متوفر في أي نسخة!',
	'extdist-submit-version'          => 'استمرار',
	'extdist-no-remote'               => 'غير قادر على الاتصال بعميل سب فيرجن البعيد.',
	'extdist-remote-error'            => 'خطأ من عميل سب فيرجن البعيد: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'رد غير صحيح من عميل سب فيرجن البعيد.',
	'extdist-svn-error'               => 'سب فيرجن صادف خطأ: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'غير قادر على معالجة XML من "svn info": <pre>$1</pre>',
	'extdist-tar-error'               => 'تار أرجع كود خروج $1:',
	'extdist-created'                 => "لقطة من النسخة <b>$2</b> من الامتداد <b>$1</b> لميدياويكي <b>$3</b> تم إنشاؤها. تحميلك ينبغي أن يبدأ تلقائيا خلال 5 ثوان.  

المسار لهذه اللقطة هو:
:$4
ربما يستخدم للتحميل الفوري لخادم، لكن من فضلك لا تستخدمه كمفضلة، حيث أن المحتويات لن يتم تحديثها، وربما يتم حذفها في وقت لاحق.

أرشيف التار ينبغي أن يتم استخراجه إلى مجلد امتداداتك. على سبيل المثال، على نظام تشغيل شبيه بيونكس:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

على ويندوز، يمكنك استخدام [http://www.7-zip.org/ 7-زيب] لاستخراج الملفات.

لو أن الويكي الخاص بك على خادم بعيد، استخرج الملفات إلى مجلد مؤقت على حاسوبك المحلي، ثم ارفع '''كل''' الملفات المستخرجة إلى مجلد الامتدادات على الخادم.

لاحظ أن بعض الامتدادات تحتاج إلى ملف يسمى ExtensionFunctions.php، موجود في <tt>extensions/ExtensionFunctions.php</tt>، هذا, في المجلد ''الأب'' لمجلد الامتدادات المحدد هذا. اللقطة لهذه الامتدادات تحتوي على هذا الملف كتار بومب، يتم استخراجها إلى ./ExtensionFunctions.php. لا تتجاهل رفع هذا الملف إلى خادمك البعيد.

بعد استخراجك للملفات، ستحتاج إلى تسجيل الامتداد في LocalSettings.php. وثائق الامتداد ينبغي أن تحتوي على التعليمات عن كيفية عمل هذا.

لو كانت لديك أية أسئلة حول نظام توزيع الامتدادات هذا، من فضلك اذهب إلى [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more'               => 'الحصول على امتداد آخر',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'extensiondistributor'            => 'Сваляне на разширения за MediaWiki',
	'extdist-not-configured'          => 'Необходимо е да се настроят $wgExtDistTarDir и $wgExtDistWorkingCopy',
	'extdist-no-such-extension'       => 'Няма такова разширение „$1“',
	'extdist-no-such-version'         => 'Разширението „$1“ не съществува във версия „$2“.',
	'extdist-choose-extension'        => 'Изберете разширение, което желаете да свалите:',
	'extdist-submit-extension'        => 'Продължаване',
	'extdist-current-version'         => 'Текуща версия (trunk)',
	'extdist-choose-version'          => '<big>На път сте да изтеглите разширението <b>$1</b>.</big>

Изберете вашата версия на MediaWiki.  

Повечето разширения работят на много версии на MediaWiki, затова ако вашата версия на MediaWiki я няма или искате най-новите възможности на разширението, опитайте да използвате текущата версия.',
	'extdist-no-versions'             => 'Избраното разширение ($1) не е налично в никоя версия!',
	'extdist-submit-version'          => 'Продължаване',
	'extdist-no-remote'               => 'Не е възможно свързване с отдалечения subversion клиент.',
	'extdist-remote-error'            => 'Грешка от отдалечения subversion клиент: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Невалиден отговор от отдалечения Subversion клиент.',
	'extdist-svn-error'               => 'Възникна грешка в Subversion: <pre>$1</pre>',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'extensiondistributor'            => 'Stáhnout rozšíření MediaWiki',
	'extdist-desc'                    => 'Rozšíření pro distribuci archivů rozšíření',
	'extdist-not-configured'          => 'Prosím, nastavte $wgExtDistTarDir a $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'Adresář nastavený pro pracovní kopii neexistuje!',
	'extdist-no-such-extension'       => 'Rozšíření „$1” neexistuje',
	'extdist-no-such-version'         => 'Rozšíření „$1” neexistuje ve verzi „$2”',
	'extdist-choose-extension'        => 'Vyberte, které rozšíření chcete stáhnout:',
	'extdist-wc-empty'                => 'Nastavená pracvní kopie nemá nemá rozšíření, které je možné distribuovat!',
	'extdist-submit-extension'        => 'Pokračovat',
	'extdist-current-version'         => 'Aktuální verze (trunk)',
	'extdist-choose-version'          => '<big>Stahujete rozšíření <b>$1</b>.</big>

Vyberte vaši verzi MediaWiki.

Většina rozšíření funguje na více verzích MediaWiki, takže pokud tu není uvedená vaše verze MediaWiki nebo potřebujete novější verzi rozšíření, pokuste se použít aktuální verzi.',
	'extdist-no-versions'             => 'Zvolené rozšíření ($1) není dostupné v žádné verzi!',
	'extdist-submit-version'          => 'Pokračovat',
	'extdist-no-remote'               => 'Nepodařilo se kontaktovat vzdáleného klienta Subversion.',
	'extdist-remote-error'            => 'Chyba od vzdáleného klienta Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Neplatná odpověď od vzdáleného klienta Subversion.',
	'extdist-svn-error'               => 'Subversion narazil na chybu: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Nebylo možné zpracovat XML z výstupu „svn info”: <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar sknočil s návratovým kódem $1:',
	'extdist-want-more'               => 'Stáhnout jiné rozšíření',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'extensiondistributor'            => 'Herunterladen von MediaWiki-Erweiterung',
	'extdist-desc'                    => 'Erweiterung für die Verteilung von Schnappschuss-Archiven von Erweiterungen',
	'extdist-not-configured'          => 'Bitte konfiguriere $wgExtDistTarDir und $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'Das konfigurierte Kopien-Arbeitsverzeichnis ist nicht vorhanden!',
	'extdist-no-such-extension'       => 'Erweiterung „$1“ ist nicht vorhanden',
	'extdist-no-such-version'         => 'Die Erweiterung „$1“ gibt es nicht in der Version „$2“.',
	'extdist-choose-extension'        => 'Bitte wähle eine Erweiterung zum Herunterladen aus:',
	'extdist-wc-empty'                => 'Das konfigurierte Kopien-Arbeitsverzeichnis enthält keine zu verteilenden Erweiterungen!',
	'extdist-submit-extension'        => 'Weiter',
	'extdist-current-version'         => 'Aktuelle Version (trunk)',
	'extdist-choose-version'          => '
<big>Du lädst die <b>$1</b>-Erweiterung herunter.</big>

Bitte wähle deine MediaWiki-Version.

Die meisten Erweiterungen arbeiten mit vielen MediaWiki-Versionen zusammen. Wenn deine MediaWiki-Version hier nicht aufgeführt ist oder du die neuesten Fähigkeiten der Erweiterung nutzen möchtest, versuche es mit der aktuellen Version.',
	'extdist-no-versions'             => 'Die gewählte Erweiterung ($1) ist nicht in der allen Versionen verfügbar!',
	'extdist-submit-version'          => 'Weiter',
	'extdist-no-remote'               => 'Der ferngesteuerte Subversion-Client ist nicht erreichbar.',
	'extdist-remote-error'            => 'Fehlermeldung des ferngesteuerten Subversion-Client: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ungültige Antwort vom ferngesteuerten Subversion-Client.',
	'extdist-svn-error'               => 'Subversion hat einen Fehler gemeldet: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'XML-Daten von „svn info“ können nicht verarbeitet werden: <pre>$1</pre>',
	'extdist-tar-error'               => 'Das Tar-Programm lieferte den Beendigungscode $1:',
	'extdist-created'                 => "Ein Schnappschuss der Version <b>$2</b> der MediaWiki-Erweiterung <b>$1</b> wurde erstellt (MediaWiki Version <b>$3</b>). Der Download startet automatisch in 5 Sekunden.

Die URL für den Schnappschuss lautet:
:$4
Die URL ist nur zum sofortigen Download gedacht, bitte speichere sie nicht als Lesezeichen ab, da der Dateiinhalt nicht aktualisiert wird und zu einem späteren Zeitpunkt gelöscht werden kann.

Das Tar-Archiv sollte in das Erweiterungs-Verzeichnis entpackt werden. Auf einem Unix-ähnlichen Betriebssystem mit:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Unter Windows kannst du das Programm [http://www.7-zip.org/ 7-zip] zum Entpacken der Dateien verwenden.

Wenn dein Wiki auf einem entfernten Server läuft, entpacke die Dateien in ein temporäres Verzeichnis auf deinem lokalen Computer und lade dann '''alle''' entpackten Dateien auf den entfernten Server hoch.

Bitte beachte, dass einige Erweiterungen die Datei <tt>ExtensionFunctions.php</tt> benötigen. Sie liegt unter  <tt>extensions/ExtensionFunctions.php</tt>, dem Heimatverzeichnis der Erweiterungen. Der Schnappschuss dieser Erweiterung enthält diese Datei als tarbomb, entpackt nach <tt>./ExtensionFunctions.php</tt>. Vergiss nicht, auch diese Datei auf deinen entfernten Server hochzuladen.

Nachdem du die Dateien entpackt hast, musst du die Erweiterung in der <tt>LocalSettings.php</tt> registrieren. Die Dokumenation zur Erweiterung sollte eine Anleitung dazu enthalten.

Wenn du Fragen zu diesem Erweiterungs-Verteil-System hast, gehe bitte zur Seite [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more'               => 'Eine weitere Erweiterung holen.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'extdist-no-such-extension' => 'Etendilo "$1" ne ekzistas',
	'extdist-submit-extension'  => 'Daŭri',
	'extdist-current-version'   => 'Nuna versio (bazo)',
	'extdist-submit-version'    => 'Daŭri',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 */
$messages['fr'] = array(
	'extensiondistributor'            => 'Télécharger l’extension Mediawiki',
	'extdist-desc'                    => 'Extension pour la distribution des archives photographiques des extensions',
	'extdist-not-configured'          => 'Veuillez configurer $wgExtDistTarDir et $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'La répertoire de la copie de travail configurée n’existe pas !',
	'extdist-no-such-extension'       => 'Aucune extension « $1 »',
	'extdist-no-such-version'         => 'L’extension « $1 » n’existe pas dans la version « $2 ».',
	'extdist-choose-extension'        => 'Sélectionnez l’extension que vous voulez télécharger :',
	'extdist-wc-empty'                => 'Le répertoire de la copie de travail configurée n’a aucune extension distribuable !',
	'extdist-submit-extension'        => 'Continuer',
	'extdist-current-version'         => 'Version courante (trunk)',
	'extdist-choose-version'          => '<big>Vous êtes en train de télécharger l’extension <b>$1</b>.</big>

Sélectionnez votre version Mediawiki.

La plupart des extensions tourne sur différentes versions de MediaWiki. Aussi, si votre version n’est pas présente ici, ou si vous avez besoin des dernières fonctionnalités de l’extension, essayez d’utiliser la version courante.',
	'extdist-no-versions'             => 'L’extension sélectionnée ($1) est indisponible dans plusieurs versions !',
	'extdist-submit-version'          => 'Continuer',
	'extdist-no-remote'               => 'Impossible de contacter le client subversion distant.',
	'extdist-remote-error'            => 'Erreur du client subversion distant : <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Réponse incorrecte depuis le client subversion distant.',
	'extdist-svn-error'               => 'Subversion a rencontré une erreur : <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Impossible de traiter le XML à partir de « svn info » : <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar a retourné le code de sortie $1 :',
	'extdist-created'                 => "Une photo de la version <b>$2</b> de l’extension <b>$1</b> pour MediaWiki <b>$3</b> a été créée. Votre téléchargement devrait commencer automatiquement dans 5 secondes.

L'adresse de cette photo est :
:$4
Il peut être utilisé pour un téléchargement immédiat vers un serveur, mais évitez de l’inscrire dans vos signets, dès lors le contenu ne sera pas mis à jour, et peut être effacé à une date ultérieure.

L’archive tar devrait être extraite dans votre répertoire extensions. À titre d’exemple, sur un système basé sur UNIX :

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Sous Windows, vous pouvez utiliser [http://www.7-zip.org/ 7-zip] pour extraire les fichiers.

Si votre wiki se trouve sur un serveur distant, extrayez les fichiers dans un fichier temporaire sur votre ordinateur local, et ensuite téléversez les '''tous''' dans le répertoire extensions du serveur.

Notez bien que quelques extensions nécessite un fichier dénommé ExtensionFunctions.php, localisé sur  <tt>extensions/ExtensionFunctions.php</tt>, qui est dans le répertoire ''parent'' du répertoire particulier de ladite extension. L’image de ces extensions contiennent ce fichier dans l’archive tar lequel sera extrait sous ./ExtensionFunctions.php. Ne négligez pas de le téléverser aussi sur le serveur.

Une fois l’extraction faite, vous aurez besoin d’enregistrer l’extension dans LocalSettings.php. Celle-ci devrait posséder un mode opératoire pour cela.

Si vous avez des questions concernant ce système de distribution des extensions, veuillez aller sur [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more'               => 'Obtenir une autre extension',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'extensiondistributor'            => 'Descargar a extensión MediaWiki',
	'extdist-desc'                    => 'Extensión para distribuír arquivos fotográficos de extensións',
	'extdist-not-configured'          => 'Por favor, configure $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'O directorio da copia en funcionamento configurada non existe!',
	'extdist-no-such-extension'       => 'Non existe a extensión "$1"',
	'extdist-no-such-version'         => 'A extensión "$1" non existe na versión "$2".',
	'extdist-choose-extension'        => 'Seleccione a extensión que queira descargar:',
	'extdist-wc-empty'                => 'A copia configurada do directorio que funciona non ten extensións que se poidan distribuír!',
	'extdist-submit-extension'        => 'Continuar',
	'extdist-current-version'         => 'Versión actual (trunk)',
	'extdist-choose-version'          => '<big>Está descargando a extensión <b>$1</b>.</big>

Seleccione a súa versión MediaWiki.  

A maioría das extensións traballan con múltiples versións de MediaWiki, polo que se a súa versión de MediaWiki non está aquí, ou se precisa características da última extensión, probe a usar a versión actual.',
	'extdist-no-versions'             => 'A extensión seleccionada ($1) non está dispoñible en ningunha versión!',
	'extdist-submit-version'          => 'Continuar',
	'extdist-no-remote'               => 'Non se pode contactar co cliente da subversión remota.',
	'extdist-remote-error'            => 'Erro do cliente da subversión remota: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Resposta inválida do cliente da subversión remota.',
	'extdist-svn-error'               => 'A subversión atopou un erro: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Non se pode procesar o XML de "svn info": <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar devolveu o código de saída $1:',
	'extdist-created'                 => "Unha fotografía da versión <b>$2</b> da extensión <b>$1</b> de MediaWiki <b>$3</b> foi creada. A súa descarga debería comezar automaticamente en 5 segundos.  

A dirección URL desta fotografía é:
:$4
Poderá ser usada para descargala inmediatamente a un servidor, pero, por favor, non a engada á listaxe dos seus favoritos mentres o contido non é actualizado. Poderá tamén ser eliminada nuns días.

O arquivo tar deberá ser extraído no seu directorio de extensións. Por exemplo, nun sistema beseado no UNIX:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

No Windows, pode usar [http://www.7-zip.org/ 7-zip] para extraer os ficheiros.

Se o seu wiki está nun servidor remoto, extraia os ficheiros nun directorio temporal no seu computador e logo cargue '''todos''' os ficheiros extraídos no directorio de extensións do servidor.

Déase de conta de que algunhas extensións precisan dun ficheiro chamado ExtensionFunctions.php, localizado en <tt>extensions/ExtensionFunctions.php</tt>, que está no directorio ''parente'' deste directorio particular da extensión. A fotografía destas extensións contén este ficheiro como un tarbomb, extraído en ./ExtensionFunctions.php. Non se descoide ao cargar este ficheiro no seu servidor remoto.

Despois de extraer os ficheiros, necesitará rexistrar a extensión en LocalSettings.php. A documentación da extensión deberá ter instrucións de como facer isto.

Se ten algunha dúbida ou pregunta acerca do sistema de distribución das extensións, por favor, vaia a [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more'               => 'Obter outra extensión',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Melos
 */
$messages['it'] = array(
	'extensiondistributor'            => 'Scarica estensione MediaWiki',
	'extdist-desc'                    => 'Estensione per distribuire archivi snapshot delle estensioni',
	'extdist-not-configured'          => 'Configura $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'La directory di lavoro della copia configurata non esiste!',
	'extdist-no-such-extension'       => 'Nessuna estensione "$1"',
	'extdist-no-such-version'         => 'L\'estensione "$1" non esiste nella versione "$2".',
	'extdist-choose-extension'        => 'Seleziona quale estensione intendi scaricare:',
	'extdist-wc-empty'                => 'La directory di lavoro della copia configurata non contiene estensioni distribuibili!',
	'extdist-submit-extension'        => 'Continua',
	'extdist-current-version'         => 'Versione corrente (trunk)',
	'extdist-choose-version'          => "<big>Stai scaricando l'estensione <b>$1</b>.</big>

Seleziona la tua versione di MediaWiki.

Molte estensioni funzionano su più versioni di MediaWiki, quindi se la tua versione di MediaWiki non è qui o hai bisogno delle ultime funzioni dell'estensione, prova a usare la versione corrente.",
	'extdist-no-versions'             => "L'estensione selezionata ($1) non è disponibile in alcuna versione!",
	'extdist-submit-version'          => 'Continua',
	'extdist-no-remote'               => 'Impossibile contattare il client subversion remoto.',
	'extdist-remote-error'            => 'Errore dal client subversion remoto: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Risposta non valida dal client subversion remoto.',
	'extdist-svn-error'               => 'Subversion ha incontrato un errore: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Impossibile elaborare l\'XML da "svn info": <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar ha restituito il seguente exitcode $1:',
	'extdist-created'                 => "Un'istantanea della versione <b>$2</b> dell'estensione per MediaWiki <b>$3</b> è stata creata. Il tuo download dovrebbe partire automaticamente fra 5 secondi.

L'URL per questa istantanea è: 
:$4
Può essere usato per scaricare immediatamente dal server, ma non aggiungerlo ai Preferiti poiché il contenuto non sarà aggiornato e il collegamento potrebbe essere rimosso successivamente.

L'archivio tar dovrebbe essere estratto nella tua directory delle estensioni. Per esempio, su un sistema operativo di tipo unix: 

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Su Windows puoi usare [http://www.7-zip.org/ 7-zip] per estrarre i file.

Se la tua wiki si trova su un server remoto, estrai i file in una cartella temporanea sul tuo computer locale e in seguito carica '''tutti''' i file estratti nella directory delle estensioni sul server.

Fai attenzione che alcune estensioni hanno bisogno di un file chiamato ExtensionFunctions.php, situato in <tt>extensions/ExtensionFunctions.php</tt>, che è la cartella ''superiore'' di questa particolare directory della estensione. L'istantanea per queste estensioni contiene questo file come una tarbom, estratta in ./ExtensionFunctions.php. Non dimenticare di caricare questo file sul tuo server locale.

Dopo che hai estratto i file, avrai bisogno di registrare l'estensione in LocalSettings.php. Il manuale dell'estensione dovrebbe contenere le istruzioni su come farlo.

Se hai qualche domanda riguardo al sistema di distribuzione di questa estensione vedi [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more'               => "Prendi un'altra estensione",
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 */
$messages['km'] = array(
	'extdist-submit-extension' => 'បន្ត',
	'extdist-submit-version'   => 'បន្ត',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'extensiondistributor'      => 'MediaWiki Erweiderung eroflueden',
	'extdist-desc'              => "Erweiderung fir d'Verdeele vu Schnappschoss-Archive vun Erweiderungen",
	'extdist-no-such-extension' => 'Et gëtt keng Erweiderung "$1"',
	'extdist-no-such-version'   => 'D\'Erweiderung "$1" gëtt et net an der Versioun "$2".',
	'extdist-choose-extension'  => 'Wielt wat fir eng Erweiderung Dir wëllt eroflueden:',
	'extdist-submit-extension'  => 'Viru fueren',
	'extdist-current-version'   => 'Aktuell Versioun (trunk)',
	'extdist-no-versions'       => 'Déi gewielten Erweiderung ($1) ass a kenger Versioun disponibel!',
	'extdist-submit-version'    => 'Viru fueren',
	'extdist-want-more'         => 'Eng aner Erweiderung benotzen',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'extensiondistributor'            => 'MediaWiki-uitbreiding downloaden',
	'extdist-desc'                    => 'Uitbreiding voor het distribueren van uitbreidingen',
	'extdist-not-configured'          => 'Maak alstublieft de instellingen voor $wgExtDistTarDir en $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'De instelde werkmap bestaat niet!',
	'extdist-no-such-extension'       => 'De uitbreiding "$1" bestaat niet',
	'extdist-no-such-version'         => 'De uitbreiding "$1" bestaat niet in de versie "$2".',
	'extdist-choose-extension'        => 'Selecteer de uitbreiding die u wilt downloaden:',
	'extdist-wc-empty'                => 'De ingestelde werkmap bevat geen te distribueren uitbreidingen!',
	'extdist-submit-extension'        => 'Doorgaan',
	'extdist-current-version'         => 'Huidige versie (trunk)',
	'extdist-choose-version'          => '<big>U bent de uitbreiding <b>$1</b> aan het downloaden.</big>

Selecteer uw versie van MediaWiki.

De meeste uitbreidingen werken met meerdere versies van MediaWiki, dus als uw versie niet in de lijst staat, of als u behoefte hebt aan de nieuwste mogelijkheden van de uitbreidingen, gebruik dan de huidige versie.',
	'extdist-no-versions'             => 'De geselecteerde uitbreiding ($1) is in geen enkele versie beschikbaar!',
	'extdist-submit-version'          => 'Doorgaan',
	'extdist-no-remote'               => 'Het was niet mogelijk de externe subversionclient te benaderen.',
	'extdist-remote-error'            => 'Fout van de externe subversionclient: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ongeldig antwoord van de externe subversionclient.',
	'extdist-svn-error'               => 'Subversion geeft de volgende foutmelding: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Het was niet mogelijk de XML van "svn info" te verwerken: <pre>$1</pre>',
	'extdist-tar-error'               => 'Tat gaf de volgende exitcode $1:',
	'extdist-created'                 => 'De snapshot voor versie <b>$2</b> voor de uitbreiding <b>$1</b> voor MediaWiki <b>$3</b> is aangemaakt. Uw download start automatisch over 5 seconden.

De URL voor de snapshot is:
:$4
Deze verwijzing kan gebruikt worden door het direct downloaden van de server, maar maak alstublieft geen bladwijzers aan, omdat de inhoud bijgewerkt kan worden, of de snapshot op een later moment verwijderd kan worden.

Pak het tararchief uit in uw map "extensions/". Op een UNIX-achtig besturingssysteem gaat dat als volgt:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Op Windows kunt u [http://www.7-zip.org/ 7-zip] gebruiken om de bestanden uit te pakken.

Als uw wiki op een op afstand beheerde server staat, pak de bestanden dan uit in een tijdelijke map op uw computer. Upload daarna \'\'\'alle\'\'\' uitgepakte bestanden naar de map "extensions/" op de server.

Een aantal uitbreidingen hebben het bestand ExtensionFunctions.php nodig, <tt>extensions/ExtensionFunctions.php</tt>, dat in de map direct boven de map met de naam van de uitbreiding hoort te staan. De snapshots voor deze uitbreidingen bevatten dit bestand als tarbomb. Het wordt uitgepakt als ./ExtensionFunctions.php. Vergeet dit bestand niet te uploaden naar uw server.

Nadat u de bestanden hebt uitgepakt en op de juiste plaatst hebt neergezet, moet u de uitbreiding registreren in LocalSettings.php. In de documentatie van de uitbreiding treft u de instructies aan.

Als u vragen hebt over dit distributiesysteem voor uitbreidingen, ga dan naar [[Extension talk:ExtensionDistributor]].',
	'extdist-want-more'               => 'Nog een uitbreiding downloaden',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author EivindJ
 */
$messages['no'] = array(
	'extensiondistributor'            => 'Last ned utvidelser til MediaWiki',
	'extdist-desc'                    => 'Utvidelse for distribusjon av andre utvidelser',
	'extdist-not-configured'          => 'Still inn $wgExtDistTarDir og $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'Mappen med arbeidskopien finnes ikke.',
	'extdist-no-such-extension'       => 'Ingen utvidelse ved navn «$1»',
	'extdist-no-such-version'         => 'Versjon «$2» av «$1» finnes ikke',
	'extdist-choose-extension'        => 'Velg hvilken utvidelse du ønsker å laste ned:',
	'extdist-wc-empty'                => 'Mappen med arbeidskopien har ingen distribuerbare utvidelser.',
	'extdist-submit-extension'        => 'Fortsett',
	'extdist-current-version'         => 'Nåværende versjon (trunk)',
	'extdist-choose-version'          => '<big>Du laster ned utvidelsen <b>$1</b>.</big>

Angi hvilken MediaWiki-versjon du bruker.

De fleste utvidelser fungerer på flere versjoner av MediaWiki, så om versjonen du bruker ikke listes opp her, kan du prøve å velge den nyeste versjonen.',
	'extdist-no-versions'             => 'Den valgte utvidelsen ($1) er ikke tilgjengelig i noen versjon.',
	'extdist-submit-version'          => 'Fortsett',
	'extdist-no-remote'               => 'Kunne ikke kontakte ekstern SVN-klient.',
	'extdist-remote-error'            => 'Feil fra ekstern SVN-klient: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ugyldig svar fra ekstern SVN-klient.',
	'extdist-svn-error'               => 'SVN fant en feil: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Kunne ikke prosessere XML fra «svn info»: <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar ga utgangsfeilen $1:',
	'extdist-created'                 => "Et øyeblikksbilde av versjon <b>$2</b> av utvidelsen <b>$1</b> for MediaWiki <b>$3</b> har blitt opprettet. Nedlastingen vil begynne automatisk om fem&nbsp;sekunder.

Adressen til dette øyeblikksbildet er:
:$4
Adressen kan brukes for nedlasting til tjeneren, men ikke legg den til som bokmerke, for innholdet vil ikke bli oppdatert, og den kan slettes senere.

Tar-arkivet burde pakkes ut i din utvidelsesmappe; for eksempel, på et Unix-lignende operativsystem:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

På Windows kan du bruke [http://www.7-zip.org/ 7-zip] for å pakke ut filene.

Om wikien din er på en ekstern tjener, pakk ut filene i en midlertidig mappe på datamaskinen din, og last opp '''alle''' utpakkede filer i utvidelsesmappa på tjeneren.

Merk at noen utvidelser trenger en fil ved navn ExtensionFunctions.php, i mappa <tt>extensions/ExtensionFunctions.php</tt>, altså i ''foreldremappa'' til den enkelte utvidelsen sin mappe. Øyeblikksbildet for disse utvidelsene inneholder denne filen som en ''tarbomb'' som pakkes ut til ./ExtensionFunctions.php. Ikke glem å laste opp denne filen til den eksterne tjeneren.

Etter å ha pakket ut filene må du registrere utvidelsen i LocalSettings.php. Dokumentasjonen til utvidelsen burde ha instruksjoner på hvordan man gjør dette.

Om du har spørsmål om dette distribusjonssytemet for utvidelser, gå til [http://www.mediawiki.org/wiki/Extension_talk:ExtensionDistributor Extension talk:ExtensionDistributor].",
	'extdist-want-more'               => 'Hent flere utvidelser',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'extensiondistributor'            => 'Telecargar l’extension Mediawiki',
	'extdist-desc'                    => 'Extension per la distribucion dels archius fotografics de las extensions',
	'extdist-not-configured'          => 'Configuratz $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'Lo repertòri de la còpia de trabalh configurada existís pas !',
	'extdist-no-such-extension'       => "Pas cap d'extension « $1 »",
	'extdist-no-such-version'         => 'L’extension « $1 » existís pas dins la version « $2 ».',
	'extdist-choose-extension'        => 'Seleccionatz l’extension que volètz telecargar :',
	'extdist-wc-empty'                => "Lo repertòri de la còpia de trabalh configurada a pas cap d'extension distribuibla !",
	'extdist-submit-extension'        => 'Contunhar',
	'extdist-current-version'         => 'Version correnta (trunk)',
	'extdist-choose-version'          => "<big>Sètz a telecargar l’extension <b>$1</b>.</big>

Seleccionatz vòstra version Mediawiki.

La màger part de las extensions vira sus diferentas versions de MediaWiki. Atal, se vòstra version es pas presenta aicí, o s'avètz besonh de las darrièras foncionalitats de l’extension, ensajatz d’utilizar la version correnta.",
	'extdist-no-versions'             => 'L’extension seleccionada ($1) es indisponibla dins mantuna version !',
	'extdist-submit-version'          => 'Contunhar',
	'extdist-no-remote'               => 'Impossible de contactar lo client subversion distant.',
	'extdist-remote-error'            => 'Error del client subversion distant : <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Responsa incorrècta dempuèi lo client subversion distant.',
	'extdist-svn-error'               => 'Subversion a rencontrat una error : <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Impossible de tractar lo XML a partir de « svn info » : <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar a tornat lo còde de sortida $1 :',
	'extdist-created'                 => "Una fòto de la version <b>$2</b> de l’extension <b>$1</b> per MediaWiki <b>$3</b> es estada creada. Vòstre telecargament deuriá començar automaticament dins 5 segondas.

L'adreça d'aquesta fòto es :
:$4
Pòt èsser utilizat per un telecargament immediat cap a un servidor, mas evitatz de l’inscriure dins vòstres signets, tre alara lo contengut serà pas mes a jorn, e poirà èsser escafat a una data ulteriora.

L’archiu tar deuriá èsser extracha dins vòstre repertòri d'extensions. A títol d’exemple, sus un sistèma basat sus UNIX :

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Jos Windows, podètz utilizar [http://www.7-zip.org/ 7-zip] per extraire los fichièrs.

Se vòstre wiki se tròba sus un servidor distant, extractatz los fichièrs dins un fichièr temporari sus vòstre ordenador local, e en seguida televersatz los '''totes''' dins lo repertòri d'extensions del servidor.

Notatz plan que qualques extensions necessitan un fichièr nomenat ExtensionFunctions.php, localizat sus  <tt>extensions/ExtensionFunctions.php</tt>, qu'es dins lo repertòri ''parent'' del repertòri particular de ladicha extension. L’imatge d'aquestas extensions contenon aqueste fichièr dins l’archiu tar loqual serà extrach jos ./ExtensionFunctions.php. Neglijatz pas de le televersar tanben sul servidor.

Un còp l’extraccion facha, aurètz besonh d’enregistrar l’extension dins LocalSettings.php. Aquesta deuriá aver un mòde operatòri per aquò.

S'avètz de questions a prepaus d'aqueste sistèma de distribucion de las extensions, anatz sus [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more'               => 'Obténer una autra extension',
);

/** Polish (Polski)
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'extensiondistributor'      => 'Pobierz rozszerzenie MediaWiki',
	'extdist-no-such-extension' => 'Brak rozszerzenia „$1”',
	'extdist-submit-extension'  => 'Kontynuuj',
	'extdist-no-versions'       => 'Wybrane rozszerzenie „$1” nie jest dostępne w żadnej wersji oprogramowania!',
	'extdist-submit-version'    => 'Kontynuuj',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'extensiondistributor'     => 'Descarcă extensia MediaWiki',
	'extdist-submit-extension' => 'Continuă',
	'extdist-submit-version'   => 'Continuă',
);

/** Russian (Русский)
 * @author MaxSem
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'extensiondistributor'      => 'Скачать расширения MediaWiki',
	'extdist-desc'              => 'Расширение для скачивания дистрибутивов с расширениями',
	'extdist-not-configured'    => 'Пожалуйста, задайте $wgExtDistTarDir и $wgExtDistWorkingCopy',
	'extdist-wc-missing'        => 'Заданная в настройках директория с рабочей копией не существует!',
	'extdist-no-such-extension' => 'Расширение «$1» не найдено',
	'extdist-no-such-version'   => 'Версия $2 расширения «$1» не найдена.',
	'extdist-choose-extension'  => 'Выберите расширение для скачивания:',
	'extdist-wc-empty'          => 'Заданная в настройках директория с рабочей копией не имеет расширений для распространения!',
	'extdist-submit-extension'  => 'Продолжить',
	'extdist-current-version'   => 'Текущая версия (trunk)',
	'extdist-choose-version'    => '<big>Вы скачиваете расширение <b>«$1»</b>.</big>

Выберите свою версию MediaWiki.  

Большинство расширений работают с несколькими версиями MediaWiki, поэтому если установленная у вас версия здесь не приведена, или вам требуются возможности последней версии расширения — попробуйте последнюю версию.',
	'extdist-no-versions'       => 'Выбранное расширение («$1») не доступно ни в одной версии!',
	'extdist-submit-version'    => 'Продолжить',
	'extdist-no-remote'         => 'Не получилось связаться с удалённым клиентом Subversion.',
	'extdist-remote-error'      => 'Ошибка удалённого клиента Subversion: <pre>$1</pre>',
	'extdist-svn-error'         => 'Ошибка Subversion: <pre>$1</pre>',
	'extdist-svn-parse-error'   => 'Ошибка обработки XML, возвращённого командой «svn info»: <pre>$1</pre>',
	'extdist-tar-error'         => 'Tar вернул код ошибки $1:',
	'extdist-want-more'         => 'Скачать другое расширение',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'extensiondistributor'            => 'Stiahnuť rozšírenie MediaWiki',
	'extdist-desc'                    => 'Rozšírenie na distribúciu archívov rozšírení',
	'extdist-not-configured'          => 'Prosím, nastavte $wgExtDistTarDir a $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'Nastavený adresár pre pracovnú kópiu neexistuje!',
	'extdist-no-such-extension'       => 'Rozšírenie „$1” neexistuje',
	'extdist-no-such-version'         => 'Rozšírenie „$1” neexistuje vo verzii „$2”',
	'extdist-choose-extension'        => 'Vyberte, ktoré rozšírenie chcete stiahnuť:',
	'extdist-wc-empty'                => 'Nastavená pracovná kópia nemá rozšírenia, ktoré je možné distribuovať!',
	'extdist-submit-extension'        => 'Pokračovať',
	'extdist-current-version'         => 'Aktuálna verzia (trunk)',
	'extdist-choose-version'          => '<big>Sťahujete rozšírenie <b>$1</b>.</big>

Vyberte vašu verziu MediaWiki.

Väčšina rozšírení funguje na viacerých verziách MediaWiki, takže ak tu nie je vaša verzia MediaWiki uvedená alebo potrebujete najnovšiu vývojovú verziu rozšírenia, pokúste sa použiť aktuálnu verziu.',
	'extdist-no-versions'             => 'Zvolené rozšírenie ($1) nie je dostupné v žiadnej verzii!',
	'extdist-submit-version'          => 'Pokračovať',
	'extdist-no-remote'               => 'Nepodarilo sa kontaktovať vzdialeného klienta Subversion.',
	'extdist-remote-error'            => 'Chyba od vzdialeného klienta Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Neplatná odpoveď od vzdialeného klienta Subversion.',
	'extdist-svn-error'               => 'Subversion narazil na chybu: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Nebolo možné spracovať XML z výstupu „svn info”: <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar skončil s návratovým kódom $1:',
	'extdist-created'                 => "Obraz verzie <b>$2</b> rozšírenia <b>$1</b> pre MediaWiki <b>$3</b> bol stiahnutý. Sťahovanie by malo začať automaticky do 5 sekúnd.

URL tohto obrazu je:
:$4
Je možné ho použiť na okamžité stiahnutie na server, ale prosím neukladajte ho ako záložku, pretože jeho obsah sa nebude aktualizovať a neskôr môže byť zmazaný.

Tar archív by ste mali rozbaliť do vášho adresára s rozšíreniami. Príkad pre unixové systémy:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Na Windows môžete na rozbalenie súborov použiť [http://www.7-zip.org/ 7-zip].

Ak je vaša wiki na vzdialenom serveri, rozbaľte súbory do dočasného adresára na vašom lokálnom počítači a potom nahrajte '''všetky''' rozbalené súbory do adresára pre rozšírenia na serveri.

Všimnite si, že niektoré rozšírenia potrebujú nájsť súbor s názvom ExtensionFunctions.php v <tt>extensions/ExtensionFunctions.php</tt>, t.j. v ''nadradenom'' adresári adresára tohto konkrétneho rozšírenia. Snímka týchto rozšírení obsahuje tento súbor, ktorý sa rozbalí do ./ExtensionFunctions.php. Nezanedbajte nahrať tento súbor na vzdialený serer.

Po rozbalení súborov budete musieť rozšírenie zaregistrovať v LocalSettings.php. Dokumentácia k rozšíreniu by mala obsahovať informácie ako to spraviť.

Ak máte otázky týkajúce sa tohto systému distribúcie rozšírení, navštívte [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more'               => 'Stiahnuť iné rozšírenie',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Boivie
 */
$messages['sv'] = array(
	'extensiondistributor'            => 'Ladda ner tillägg till MediaWiki',
	'extdist-desc'                    => 'Tillägg för distribution av övriga tillägg',
	'extdist-not-configured'          => 'Var god bekräfta $wgExtDistTarDir och $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => 'Mappen med arbetskopian finns inte!',
	'extdist-no-such-extension'       => 'Ingen sådant tillägg "$1"',
	'extdist-no-such-version'         => 'Tillägget "$1" finns inte i versionen "$2".',
	'extdist-choose-extension'        => 'Välj vilket tillägg du vill ladda ner:',
	'extdist-wc-empty'                => 'Mappen med arbetskopian har inga distribuerbara tillägg!',
	'extdist-submit-extension'        => 'Fortsätt',
	'extdist-current-version'         => 'Nuvarande version (trunk)',
	'extdist-choose-version'          => '
<big>Du laddar ner tillägget <b>$1</b>.</big>

Ange vilken version av MediaWiki du använder.

De flesta tilläggen fungerar på flera versioner av MediaWiki, så om versionen du använder inte listas upp här, kan du pröva att välja den nyaste versionen.',
	'extdist-no-versions'             => 'Det valda tillägget ($1) är inte tillgängligt i någon version!',
	'extdist-submit-version'          => 'Fortsätt',
	'extdist-no-remote'               => 'Kunde inte kontakta extern SVN-klient.',
	'extdist-remote-error'            => 'Fel från extern SVN-klient: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ogiltigt svar från extern SVN-klient.',
	'extdist-svn-error'               => 'SVN hittade ett fel: <pre>$1</pre>',
	'extdist-svn-parse-error'         => 'Kunde inte processera XML från "svn info": <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar returnerade utgångskod $1:',
	'extdist-created'                 => "En ögonblicksbild av version <b>$2</b> av tillägget <b>$1</b> för MediaWiki <b>$3</b> har skapats. Din nerladdning ska starta automatiskt om 5 sekunder.

URLet för ögonblicksbilden är:
:$4
Den kan användas för direkt nedladdning till en server, men bokmärk den inte, för innehållet kommer inte uppdateras, och den kan bli raderad vid ett senare tillfälle.

Tar-arkivet ska packas upp i din extensions-katalog. Till exempel, på ett unix-likt OS:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

På Windows kan du använda [http://www.7-zip.org/ 7-zip] för att packa upp filerna.

Om din wiki är på en fjärrserver, packa upp filerna till en tillfällig katalog på din lokala dator, och ladda sedan upp '''alla''' uppackade filer till extensions-katalogen på servern.

Observera att några programtillägg behöver filen ExtensionFunctions.php, som finns i <tt>extensions/ExtensionFunctions.php</tt>, det är i ''föräldra''katalogen till just det här filtilläggets katalog. Ögonblicksbilden för dessa programtillägg innehåller den här filen som en tarbomb, uppackad till ./ExtensionFunctions.php. Glöm inte att ladda upp den filen till din fjärrserver.

Efter att du packat upp filerna, behöver du registrera programtillägget i LocalSettings.php. Programtilläggets dokumentation ska ha instruktioner om hur man gör det.

Om du har några frågor om programtilläggets distributionssystem, gå till [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more'               => 'Hämta andra tillägg',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'extdist-submit-extension' => 'కొనసాగించు',
	'extdist-submit-version'   => 'కొనసాగించు',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'extensiondistributor'            => '下載MediaWiki擴展',
	'extdist-desc'                    => '發佈擴展歸檔映像嘅擴展',
	'extdist-not-configured'          => '請設定 $wgExtDistTarDir 同 $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => '已經設定咗嘅工作複本目錄唔存在！',
	'extdist-no-such-extension'       => '無呢個擴展 "$1"',
	'extdist-no-such-version'         => '個擴展 "$1" 唔存在於呢個版本 "$2" 度。',
	'extdist-choose-extension'        => '揀你要去下載嘅擴展:',
	'extdist-wc-empty'                => '設定咗嘅工作複本目錄無可發佈嘅擴展！',
	'extdist-submit-extension'        => '繼續',
	'extdist-current-version'         => '現時版本 (trunk)',
	'extdist-choose-version'          => '
<big>你而家下載緊 <b>$1</b> 擴展。</big>

揀你要嘅 MediaWiki 版本。 

多數嘅擴展都可以響多個 MediaWiki 嘅版本度行到，噉如果你嘅 Mediawiki 版本唔響度，又或者你需要最新嘅擴展功能嘅話，試吓用最新嘅版本。',
	'extdist-no-versions'             => '所揀嘅擴展 ($1) 不適用於任何嘅版本！',
	'extdist-submit-version'          => '繼續',
	'extdist-no-remote'               => '唔能夠聯絡遠端 subversion 客戶端。',
	'extdist-remote-error'            => '自遠端 subversion 客戶端嘅錯誤: <pre>$1</pre>',
	'extdist-remote-invalid-response' => '自遠端 subversion 客戶端嘅無效回應。',
	'extdist-svn-error'               => 'Subversion 遇到一個錯誤: <pre>$1</pre>',
	'extdist-svn-parse-error'         => '唔能夠處理 "svn info" 嘅 XML: <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar 回應結束碼 $1:',
	'extdist-created'                 => "一個可供 MediaWiki <b>$3</b> 用嘅 <b>$1</b> 擴展之 <b>$2</b> 版本嘅映像已經整好咗。你嘅下載將會響5秒鐘之後自動開始。 

呢個映像嘅 URL 係:
:$4
佢可能會用響即時下載到伺服器度，但係請唔好記底響書籤度，因為裏面啲嘢可能唔會更新，亦可能會響之後嘅時間刪除。

個 tar 壓縮檔應該要解壓到你嘅擴展目錄。例如，響 unix 類 OS:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

響 Windows，你可以用 [http://www.7-zip.org/ 7-zip] 去解壓嗰啲檔案。

如果你嘅 wiki 係響一個遠端伺服器嘅話，就響電腦度解壓檔案到一個臨時目錄，然後再上載'''全部'''已經解壓咗嘅檔案到伺服器嘅擴展目錄。

要留意嘅有啲擴展係需要一個叫做 ExtensionFunctions.php 嘅檔案，響 <tt>extensions/ExtensionFunctions.php</tt>，即係，響呢個擴展目錄嘅''父''目錄。嗰啲擴展嘅映像都會含有以呢個檔案嘅 tarbomb 檔案，解壓到 ./ExtensionFunctions.php。唔好唔記得上載埋呢個檔案到你嘅遠端伺服器。

響你解壓咗啲檔案之後，你需要響 LocalSettings.php 度註冊番個擴展。個擴展說明講咗點樣可以做到呢樣嘢。

如果你有任何對於呢個擴展發佈系統有問題嘅話，請去[[Extension talk:ExtensionDistributor]]。
",
	'extdist-want-more'               => '攞另一個擴展',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'extensiondistributor'            => '下载MediaWiki扩展',
	'extdist-desc'                    => '发布扩展存档映像的扩展',
	'extdist-not-configured'          => '请设置 $wgExtDistTarDir 和 $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => '已经设置的工作复本目录不存在！',
	'extdist-no-such-extension'       => '没有这个扩展 "$1"',
	'extdist-no-such-version'         => '该扩展 "$1" 不存在于这个版本 "$2" 中。',
	'extdist-choose-extension'        => '选择您要去下载的扩展:',
	'extdist-wc-empty'                => '设置的工作复本目录无可发布之扩展！',
	'extdist-submit-extension'        => '继续',
	'extdist-current-version'         => '现时版本 (trunk)',
	'extdist-choose-version'          => '
<big>您现正下载 <b>$1</b> 扩展。</big>

选择您要的 MediaWiki 版本。 

多数的扩展都可以在多个 MediaWiki 版本上运行，如果您的 Mediawiki 版本不存在，又或者您需要最新的扩展功能的话，可尝试用最新的版本。',
	'extdist-no-versions'             => '所选择扩展 ($1) 不适用于任何的版本！',
	'extdist-submit-version'          => '继续',
	'extdist-no-remote'               => '不能够联络远端 subversion 客户端。',
	'extdist-remote-error'            => '自远端 subversion 客户端的错误: <pre>$1</pre>',
	'extdist-remote-invalid-response' => '自远端 subversion 客户端的无效反应。',
	'extdist-svn-error'               => 'Subversion 遇到一个错误: <pre>$1</pre>',
	'extdist-svn-parse-error'         => '不能够处理 "svn info" 之 XML: <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar 反应结束码 $1:',
	'extdist-created'                 => "一个可供 MediaWiki <b>$3</b> 使用的 <b>$1</b> 扩展之 <b>$2</b> 版本的映像已经建立。您的下载将会在5秒钟之后自动开始。 

这个映像的 URL 是:
:$4
它可能会用于即时下载到服务器中，但是请不要记录在书签中，因为里面?内容可能不会更新，亦可能会在之后的时间删除。

该 tar 压缩档应该要解压缩到您的扩展目录。例如，在 unix 类 OS:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

在 Windows，您可以用 [http://www.7-zip.org/ 7-zip] 去解压缩这些文件。

如果您的 wiki 是在一个远端服务器的话，就在电脑中解压缩文件到一个临时目录，然后再上载'''全部'''已经解压缩的文件到服务器的扩展目录上。

要留意的是有的扩展是需要一个名叫 ExtensionFunctions.php 的文件，在 <tt>extensions/ExtensionFunctions.php</tt>，即是，在这个扩展目录的''父''目录。那些扩展的映像都会含有以这个文件的 tarbomb 文件，解压缩到 ./ExtensionFunctions.php。不要忘记上载这个文件到您的远端服务器。

响您解压缩文件之后，您需要在 LocalSettings.php 中注册该等扩展。该扩展之说明会有指示如何做到它。

如果您有任何对于这个扩展发布系统有问题的话，请去[[Extension talk:ExtensionDistributor]]。
",
	'extdist-want-more'               => '取另一个扩展',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'extensiondistributor'            => '下載MediaWiki擴展',
	'extdist-desc'                    => '發佈擴展存檔映像的擴展',
	'extdist-not-configured'          => '請設定 $wgExtDistTarDir 和 $wgExtDistWorkingCopy',
	'extdist-wc-missing'              => '已經設定的工作複本目錄不存在！',
	'extdist-no-such-extension'       => '沒有這個擴展 "$1"',
	'extdist-no-such-version'         => '該擴展 "$1" 不存在於這個版本 "$2" 中。',
	'extdist-choose-extension'        => '選擇您要去下載的擴展:',
	'extdist-wc-empty'                => '設定的工作複本目錄無可發佈之擴展！',
	'extdist-submit-extension'        => '繼續',
	'extdist-current-version'         => '現時版本 (trunk)',
	'extdist-choose-version'          => '
<big>您現正下載 <b>$1</b> 擴展。</big>

選擇您要的 MediaWiki 版本。 

多數的擴展都可以在多個 MediaWiki 版本上運行，如果您的 Mediawiki 版本不存在，又或者您需要最新的擴展功能的話，可嘗試用最新的版本。',
	'extdist-no-versions'             => '所選擇擴展 ($1) 不適用於任何的版本！',
	'extdist-submit-version'          => '繼續',
	'extdist-no-remote'               => '不能夠聯絡遠端 subversion 客戶端。',
	'extdist-remote-error'            => '自遠端 subversion 客戶端的錯誤: <pre>$1</pre>',
	'extdist-remote-invalid-response' => '自遠端 subversion 客戶端的無效回應。',
	'extdist-svn-error'               => 'Subversion 遇到一個錯誤: <pre>$1</pre>',
	'extdist-svn-parse-error'         => '不能夠處理 "svn info" 之 XML: <pre>$1</pre>',
	'extdist-tar-error'               => 'Tar 回應結束碼 $1:',
	'extdist-created'                 => "一個可供 MediaWiki <b>$3</b> 使用的 <b>$1</b> 擴展之 <b>$2</b> 版本的映像已經建立。您的下載將會在5秒鐘之後自動開始。 

這個映像的 URL 是:
:$4
它可能會用於即時下載到伺服器中，但是請不要記錄在書籤中，因為裏面啲內容可能不會更新，亦可能會在之後的時間刪除。

該 tar 壓縮檔應該要解壓縮到您的擴展目錄。例如，在 unix 類 OS:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

在 Windows，您可以用 [http://www.7-zip.org/ 7-zip] 去解壓縮這些檔案。

如果您的 wiki 是在一個遠端伺服器的話，就在電腦中解壓縮檔案到一個臨時目錄，然後再上載'''全部'''已經解壓縮的檔案到伺服器的擴展目錄上。

要留意的是有的擴展是需要一個名叫 ExtensionFunctions.php 的檔案，在 <tt>extensions/ExtensionFunctions.php</tt>，即是，在這個擴展目錄的''父''目錄。那些擴展的映像都會含有以這個檔案的 tarbomb 檔案，解壓縮到 ./ExtensionFunctions.php。不要忘記上載這個檔案到您的遠端伺服器。

響您解壓縮檔案之後，您需要在 LocalSettings.php 中註冊該等擴展。該擴展之說明會有指示如何做到它。

如果您有任何對於這個擴展發佈系統有問題的話，請去[[Extension talk:ExtensionDistributor]]。
",
	'extdist-want-more'               => '取另一個擴展',
);

