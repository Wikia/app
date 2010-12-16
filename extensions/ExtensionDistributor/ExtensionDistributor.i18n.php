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
		'extdist-current-version' => 'Development version (trunk)',
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

If you have any questions about this extension distribution system, please go to [[Extension talk:ExtensionDistributor]].",
		'extdist-want-more' => 'Get another extension',
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author Jon Harald Søby
 * @author Purodha
 * @author Александр Сигачёв
 */
$messages['qqq'] = array(
	'extensiondistributor' => '{{Identical|Download}}',
	'extdist-desc' => 'Short description of the Extdist extension, shown in [[Special:Version]]. Do not translate or change links.',
	'extdist-submit-extension' => '{{Identical|Continue}}',
	'extdist-submit-version' => '{{Identical|Continue}}',
	'extdist-created' => '* $1 - extension
* $2 - revision number
* $3 - branch name
* $4 - URL
* $5 - filename',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'extensiondistributor' => 'Laai MediaWiki-uitbreiding af',
	'extdist-not-configured' => 'Stel asseblief $wgExtDistTarDir en $wgExtDistWorkingCopy',
	'extdist-no-such-extension' => 'Die uitbreiding "$1" bestaan nie',
	'extdist-submit-extension' => 'Gaan voort',
	'extdist-current-version' => 'Ontwikkelingsweergawe (trunc)',
	'extdist-submit-version' => 'Gaan voort',
	'extdist-tar-error' => 'TAR stuur die volgende kode terug $1:',
	'extdist-want-more' => "Laai nog 'n uitbreiding af",
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'extensiondistributor' => 'تنزيل امتداد ميدياويكي',
	'extdist-desc' => 'امتداد لتوزيع أرشيفات ملتقطة للامتدادات',
	'extdist-not-configured' => 'من فضلك اضبط $wgExtDistTarDir و $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'مجلد نسخة العمل المحدد غير موجود!',
	'extdist-no-such-extension' => 'لا امتداد كهذا "$1"',
	'extdist-no-such-version' => 'الامتداد "$1" لا يوجد في النسخة "$2".',
	'extdist-choose-extension' => 'اختر أي امتدات تريد تنزيله:',
	'extdist-wc-empty' => 'مجلد نسخة العمل المضبوط ليس به امتدادات قابلة للتوزيع!',
	'extdist-submit-extension' => 'استمر',
	'extdist-current-version' => 'نسخة التطوير (جذع)',
	'extdist-choose-version' => '<big>أنت تقوم بتنزيل امتداد <b>$1</b>.</big>

اختر نسخة ميدياويكي الخاصة بك.

معظم الامتدادات تعمل خلال نسخ متعددة من ميدياويكي، لذا إذا كانت نسخة ميدياويكي الخاصة بك ليست هنا، أو لو كانت لديك حاجة لأحدث خواص الامتداد، حاول استخدام النسخة الحالية.',
	'extdist-no-versions' => 'الامتداد المختار ($1) غير متوفر في أي نسخة!',
	'extdist-submit-version' => 'استمرار',
	'extdist-no-remote' => 'غير قادر على الاتصال بعميل سب فيرجن البعيد.',
	'extdist-remote-error' => 'خطأ من عميل سب فيرجن البعيد: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'رد غير صحيح من عميل سب فيرجن البعيد.',
	'extdist-svn-error' => 'سب فيرجن صادف خطأ: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'غير قادر على معالجة XML من "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'تار أرجع كود خروج $1:',
	'extdist-created' => "لقطة من النسخة <b>$2</b> من الامتداد <b>$1</b> لميدياويكي <b>$3</b> تم إنشاؤها. تحميلك ينبغي أن يبدأ تلقائيا خلال 5 ثوان.

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
	'extdist-want-more' => 'الحصول على امتداد آخر',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'extensiondistributor' => 'تنزيل امتداد ميدياويكي',
	'extdist-desc' => 'امتداد لتوزيع أرشيفات ملتقطة للامتدادات',
	'extdist-not-configured' => 'من فضلك اضبط $wgExtDistTarDir و $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'مجلد نسخة العمل المحدد غير موجود!',
	'extdist-no-such-extension' => 'لا امتداد كهذا "$1"',
	'extdist-no-such-version' => 'الامتداد "$1" لا يوجد فى النسخة "$2".',
	'extdist-choose-extension' => 'اختر أى امتدات تريد تنزيله:',
	'extdist-wc-empty' => 'مجلد نسخة العمل المضبوط ليس به امتدادات قابلة للتوزيع!',
	'extdist-submit-extension' => 'استمر',
	'extdist-current-version' => 'نسخة التطوير (جذع)',
	'extdist-choose-version' => '<big>أنت تقوم بتنزيل امتداد <b>$1</b>.</big>

اختر نسخة ميدياويكى الخاصة بك.

معظم الامتدادات تعمل خلال نسخ متعددة من ميدياويكى، لذا إذا كانت نسخة ميدياويكى الخاصة بك ليست هنا، أو لو كانت لديك حاجة لأحدث خواص الامتداد، حاول استخدام النسخة الحالية.',
	'extdist-no-versions' => 'الامتداد المختار ($1) غير متوفر فى أى نسخة!',
	'extdist-submit-version' => 'استمرار',
	'extdist-no-remote' => 'غير قادر على الاتصال بعميل سب فيرجن البعيد.',
	'extdist-remote-error' => 'خطأ من عميل سب فيرجن البعيد: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'رد غير صحيح من عميل سب فيرجن البعيد.',
	'extdist-svn-error' => 'سب فيرجن صادف خطأ: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'غير قادر على معالجة XML من "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'تار أرجع كود خروج $1:',
	'extdist-created' => "لقطة من النسخة <b>$2</b> من الامتداد <b>$1</b> لميدياويكى <b>$3</b> تم إنشاؤها. تحميلك ينبغى أن يبدأ تلقائيا خلال 5 ثوان.

المسار لهذه اللقطة هو:
:$4
ربما يستخدم للتحميل الفورى لخادم، لكن من فضلك لا تستخدمه كمفضلة، حيث أن المحتويات لن يتم تحديثها، وربما يتم حذفها فى وقت لاحق.

أرشيف التار ينبغى أن يتم استخراجه إلى مجلد امتداداتك. على سبيل المثال، على نظام تشغيل شبيه بيونكس:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

على ويندوز، يمكنك استخدام [http://www.7-zip.org/ 7-زيب] لاستخراج الملفات.

لو أن الويكى الخاص بك على خادم بعيد، استخرج الملفات إلى مجلد مؤقت على حاسوبك المحلى، ثم ارفع '''كل''' الملفات المستخرجة إلى مجلد الامتدادات على الخادم.

لاحظ أن بعض الامتدادات تحتاج إلى ملف يسمى ExtensionFunctions.php، موجود فى <tt>extensions/ExtensionFunctions.php</tt>، هذا, فى المجلد ''الأب'' لمجلد الامتدادات المحدد هذا. اللقطة لهذه الامتدادات تحتوى على هذا الملف كتار بومب، يتم استخراجها إلى ./ExtensionFunctions.php. لا تتجاهل رفع هذا الملف إلى خادمك البعيد.

بعد استخراجك للملفات، ستحتاج إلى تسجيل الامتداد فى LocalSettings.php. وثائق الامتداد ينبغى أن تحتوى على التعليمات عن كيفية عمل هذا.

لو كانت لديك أية أسئلة حول نظام توزيع الامتدادات هذا، من فضلك اذهب إلى [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'الحصول على امتداد آخر',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'extensiondistributor' => 'Загрузіць пашырэньне MediaWiki',
	'extdist-desc' => 'Пашырэньне для распаўсюджваньня архіваў пашырэньняў',
	'extdist-not-configured' => 'Калі ласка, задайце $wgExtDistTarDir і $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Зададзеная працоўная копія дырэкторыі не існуе!',
	'extdist-no-such-extension' => 'Пашырэньне «$1» не існуе',
	'extdist-no-such-version' => 'Вэрсія «$2» пашырэньня «$1» ня знойдзеная.',
	'extdist-choose-extension' => 'Выберыце, якое пашырэньне Вы жадаеце загрузіць:',
	'extdist-wc-empty' => 'Зададзеная працоўная копія дырэкторыі ня мае пашырэньняў для распаўсюджваньня!',
	'extdist-submit-extension' => 'Працягваць',
	'extdist-current-version' => 'Вэрсія ў распрацоўцы (trunk)',
	'extdist-choose-version' => '<big>Вы загружаеце пашырэньне <b>$1</b>.</big>

Выберыце сваю вэрсію MediaWiki.

Большасьць пашырэньняў працуе зь некалькімі вэрсіямі MediaWiki, таму, калі тут няма Вашай вэрсіі MediaWiki, альбо Вам патрабуюцца магчымасьці апошняй вэрсіі, паспрабуйце апошнюю вэрсію.',
	'extdist-no-versions' => 'Выбранае пашырэньне ($1) не даступнае ні ў якой вэрсіі!',
	'extdist-submit-version' => 'Працягваць',
	'extdist-no-remote' => 'Не атрымалася скантактавацца з аддаленым кліентам Subversion.',
	'extdist-remote-error' => 'Памылка аддаленага кліента Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Няслушны адказ ад аддаленага кліента Subversion.',
	'extdist-svn-error' => 'Памылка Subversion: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Немагчыма апрацаваць XML ад «svn info»: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar вярнуў код памылкі $1:',
	'extdist-created' => "Быў створаны архіў вэрсіі <b>$2</b> пашырэньня <b>$1</b> MediaWiki <b>$3</b>. Загрузка пачнецца аўтаматычна праз 5 сэкундаў.

Спасылка на архіў:
:$4
Спасылку можна выкарыстоўваць для неадкладнай загрузкі на сэрвэр, але, калі ласка, не занатоўвайце яе, таму што зьмест ня будзе абнаўляцца і можа быць выдалены празь некаторы час.

Tar-архіў неабходна распакаваць у дырэкторыю пашырэньня. Напрыклад, у Unix-падобных сыстэмах гэта будзе выглядаць так:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

У сыстэмах Windows, для распакоўкі Вы можаце выкарыстоўваць праграму [http://www.7-zip.org/ 7-zip].

Калі Вашая вікі знаходзіцца на аддаленым сэрвэры, распакуйце файлы ў часовую дырэкторыю на Вашым кампутары, і потым загрузіце '''ўсе''' распакаваныя файлы ў дырэкторыю пашырэньня на сэрвэры.

Майце на ўвазе, што некаторыя пашырэньні патрабуюць файл з назвай ExtensionFunctions.php, які знаходзіцца на <tt>extensions/ExtensionFunctions.php</tt>, што знаходзіцца ў ''галоўнай'' дырэкторыі гэтага пашырэньня. Архіў гэтага пашырэньня ўтрымлівае гэты файл як tarbomb, які распакаваны ў ./ExtensionFunctions.php. Не забудзьце загрузіць гэты файл на Ваш аддалены сэрвэр.

Пасьля распакоўкі файлаў, Вам трэба зарэгістраваць пашырэньне ў LocalSettings.php. Дакумэнтацыя пашырэньня павінна ўтрымліваць інструкцыю, як гэта зрабіць.

Калі Вы маеце якія-небудзь пытаньні пра сыстэму ўсталяваньня пашырэньня, калі ласка, задайце іх на старонцы [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Атрымаць іншае пашырэньне',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Turin
 */
$messages['bg'] = array(
	'extensiondistributor' => 'Сваляне на разширения за MediaWiki',
	'extdist-not-configured' => 'Необходимо е да се настроят $wgExtDistTarDir и $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Настроената директория на работното копие не съществува!',
	'extdist-no-such-extension' => 'Няма такова разширение „$1“',
	'extdist-no-such-version' => 'Разширението „$1“ не съществува във версия „$2“.',
	'extdist-choose-extension' => 'Изберете разширение, което желаете да свалите:',
	'extdist-wc-empty' => 'Настроената директория на работното копие не съдържа разширения за разпространение!',
	'extdist-submit-extension' => 'Продължаване',
	'extdist-current-version' => 'Разработвана версия (trunk)',
	'extdist-choose-version' => '<big>На път сте да изтеглите разширението <b>$1</b>.</big>

Изберете вашата версия на MediaWiki.

Повечето разширения работят на много версии на MediaWiki, затова ако вашата версия на MediaWiki я няма или искате най-новите възможности на разширението, опитайте да използвате текущата версия.',
	'extdist-no-versions' => 'Избраното разширение ($1) не е налично в никоя версия!',
	'extdist-submit-version' => 'Продължаване',
	'extdist-no-remote' => 'Не е възможно свързване с отдалечения subversion клиент.',
	'extdist-remote-error' => 'Грешка от отдалечения subversion клиент: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Невалиден отговор от отдалечения Subversion клиент.',
	'extdist-svn-error' => 'Възникна грешка в Subversion: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Грешка при обработване на XML, върнат от командата "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar върна код за грешка $1:',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'extensiondistributor' => 'Pellgargañ an astenn MediaWiki',
	'extdist-not-configured' => 'Mar plij keflunit $wgExtDistTarDir ha $wgExtDistWorkingCopy',
	'extdist-wc-missing' => "N'eus ket eus kavlec'h evit an eilad labour kefluniet !",
	'extdist-no-such-extension' => 'N\'eus ket eus an astenn "$1"',
	'extdist-no-such-version' => 'N\'eus ket eus an astenn "$1" en doare "$2".',
	'extdist-choose-extension' => "Dibabit peseurt astenn ho peus c'hoant pellgargañ :",
	'extdist-submit-extension' => "Kenderc'hel",
	'extdist-current-version' => 'Doare diorroiñ (trunk)',
	'extdist-choose-version' => "<big>Emaoc'h o pellgargañ an astenn <b>$1</b>.</big>

Dibabit ho stumm MediaWiki.

Al lod vrasañ eus an astennoù a  ya en-dro war stumm disheñvel MediaWiki. Neuze ma n'emañ ket ho stumm amañ, pe m'ho peus ezhomm arc'hweladurioù ziwezhañ an astenn, klaskit implijout ar stumm a-vremañ.",
	'extdist-no-versions' => 'Dizimplijadus eo an astenn bet dibabet ($1) e stumm ebet !',
	'extdist-submit-version' => "Kenderc'hel",
	'extdist-tar-error' => "Tar en deus adtroet ar c'hod dont er-maez $1 :",
	'extdist-want-more' => 'Tapout un astenn all',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'extensiondistributor' => 'Učitaj MediaWiki proširenje',
	'extdist-desc' => 'Proširenja za raspodjelu snapshot arhiva za ekstenzije',
	'extdist-not-configured' => 'Molimo da podesite $wgExtDistTarDir i $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Podešeni radni direktorijum za kopije ne postoji!',
	'extdist-no-such-extension' => 'Nema takve ekstenzije "$1"',
	'extdist-no-such-version' => 'Proširenje "$1" ne postoji u verziji "$2".',
	'extdist-choose-extension' => 'Odaberite koje proširenje želite da učitate:',
	'extdist-wc-empty' => 'Konfigurirani radni direktorij kopiranja nema proširenja za distribuciju!',
	'extdist-submit-extension' => 'Nastavi',
	'extdist-current-version' => 'Razvojna verzija (trunk)',
	'extdist-choose-version' => '<big>Skidate proširenje <b>$1</b>.</big>

Odaberite Vašu verziju MediaWikija.

Većina proširenja radi na mnogim verzijama MediaWikija, pa ako se Vaša verzija MediaWikija ne nalazi ovdje, ili ako vam je potrebna za najnovije funkcije proširenja, pokušajte koristiti trenutnu verziju.',
	'extdist-no-versions' => 'Odabrano proširenje ($1) nije dostupno u nijednoj verziji!',
	'extdist-submit-version' => 'Nastavi',
	'extdist-no-remote' => 'Ne može se kontaktirati udaljeni klijent subverzije.',
	'extdist-remote-error' => 'Greška od udaljenog klijenta subverzije: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Nevaljan odgovor od udaljenog klijenta subverzije.',
	'extdist-svn-error' => 'Desila se greška kod subverzije: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Ne mogu procesirati XML formu iz "svn info": <pre>$1</pre>',
	'extdist-tar-error' => "Program ''tar'' je vratio izlazni kod $1:",
	'extdist-created' => "Napravljen je prikaz verzije <b>$2</b> od proširenja <b>$1</b> za MediaWiki <b>$3</b>. Vaše preuzimanje će otpočeti automatski za 5 sekundi.

URL za ovaj prikaz je:
:$4
Možete ga koristiti za direktno preuzimanje sa servera, ali ga ne stavljajte u favorite, pošto mu se sadržaj neće ažurirati, a možete ga obrisati kasnije.

Tar arhiva bi se trebala otpakovati u Vaš direktorij za proširenja. Na primjer, na OS-u poput Unixa i Linuxa:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Na Windowsu, možete koristiti [http://www.7-zip.org/ 7-zip] za otpakiranje datoteka.

Ako je Vaš wiki na udaljenom serveru, otpakujte datoteke u privremeni direktorij na Vašem računaru, zatim postavite '''sve''' otpakovane datoteke u direktorij za proširenja na serveru.

Zapamtite da neka proširenja trebaju datoteku pod imenom ExtensionFunctions.php, koja se nalazi u <tt>extensions/ExtensionFunctions.php</tt>, to jest, u ''nadređenom'' direktoriju određenog direktorija proširenja. Prikaz za ova proširenja sadrži ovu datoteku kao tarbomb, otpakovanu u  ./ExtensionFunctions.php. Nemojte zaboraviti postaviti ovu datoteku na Vaš udaljeni server.

Nakon što otpakujete datoteke, morat ćete registrovati proširenje u LocalSettings.php. Dokumentacija proširenja bi trebala imati detaljna objašnjenja kako se ovo radi.

Ako imate nekih pitanja oko ovog sistema distribucije proširenja, molimo pogledajte [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Nađi slijedeće proširenje',
);

/** Catalan (Català)
 * @author Paucabot
 * @author Solde
 */
$messages['ca'] = array(
	'extensiondistributor' => 'Descarrega una extensió de Mediawiki',
	'extdist-desc' => 'Extensió per distribuir arxius actualitzats de les extensions',
	'extdist-not-configured' => 'Per favor, configurau $wgExtDistTarDir i $wgExtDistWorkingCopy',
	'extdist-no-such-extension' => 'No existeix l\'extensió "$1"',
	'extdist-no-such-version' => 'L\'extensió "$1" no existeix en la versió "$2"',
	'extdist-choose-extension' => 'Seleccionau quina extensió voleu descarregar:',
	'extdist-submit-extension' => 'Continua',
	'extdist-current-version' => 'Versió de desenvolupament (trunk)',
	'extdist-choose-version' => "<big>Estau descarregant l'extensió <b>$1</b>.</big>

Seleccionau la vostra versió del Mediawiki.

La majoria d'extensions funcionen a les diferents versions de Mediawiki, així que si la vostra versió de Mediawiki no és aquí o si necessitau les darreres funcionalitats de l'extensió, provau d'usar la versió actual.",
	'extdist-no-versions' => "L'extensió seleccionada ($1) no està disponible en cap versió.",
	'extdist-submit-version' => 'Continua',
	'extdist-no-remote' => "No s'ha pogut contactar amb el client remot de Subversion.",
	'extdist-remote-error' => 'Error del client remot de Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Resposta invàlida del client remot de Subversion.',
	'extdist-svn-error' => 'Subversion ha trobat un error: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'No s\'ha pogut processar l\'XML de "svn info": <pre>$1</pre>',
	'extdist-tar-error' => "L'ordre tar ha retornat un codi de sortida $1:",
	'extdist-want-more' => 'Descarrega una altra extensió',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'extensiondistributor' => 'Stáhnout rozšíření MediaWiki',
	'extdist-desc' => 'Rozšíření pro distribuci archivů rozšíření',
	'extdist-not-configured' => 'Prosím, nastavte $wgExtDistTarDir a $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Adresář nastavený pro pracovní kopii neexistuje!',
	'extdist-no-such-extension' => 'Rozšíření „$1” neexistuje',
	'extdist-no-such-version' => 'Rozšíření „$1” neexistuje ve verzi „$2”',
	'extdist-choose-extension' => 'Vyberte, které rozšíření chcete stáhnout:',
	'extdist-wc-empty' => 'Nastavený adresář s pracovní kopií neobsahuje žádná rozšíření, která by bylo možné distribuovat!',
	'extdist-submit-extension' => 'Pokračovat',
	'extdist-current-version' => 'Vývojová verze (trunk)',
	'extdist-choose-version' => '<big>Stahujete rozšíření <b>$1</b>.</big>

Vyberte verzi MediaWiki.

Většina rozšíření funguje na více verzích MediaWiki, takže pokud tu vaše verze MediaWiki není uvedena nebo potřebujete nejnovější vlastnosti rozšíření, zkuste použít aktuální verzi.',
	'extdist-no-versions' => 'Zvolené rozšíření ($1) není dostupné v žádné verzi!',
	'extdist-submit-version' => 'Pokračovat',
	'extdist-no-remote' => 'Nepodařilo se kontaktovat vzdáleného klienta Subversion.',
	'extdist-remote-error' => 'Chyba od vzdáleného klienta Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Neplatná odpověď od vzdáleného klienta Subversion.',
	'extdist-svn-error' => 'Subversion narazil na chybu: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Nebylo možné zpracovat XML z výstupu „svn info”: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar sknočil s návratovým kódem $1:',
	'extdist-created' => "Balíček rozšíření <b>$1</b> ve verzi <b>$2</b> pro MediaWiki <b>$3</b> byl vytvořen. Jeho stahování by se mělo automaticky spustit za pět sekund.

Adresa tohoto balíčku je:
: $4
Můžete si odtud nyní balíček stáhnout, ale laskavě si tuto adresu nikam neukládejte, protože obsah odkazovaného souboru nebude aktualizován a soubor může být později smazán.

Tento tar si rozbalte do adresáře <tt>extensions</tt>. Na operačních systémech na bázi Unixu například:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Na Windows můžete balíček rozbalit pomocí programu [http://www.7-zip.org/ 7-zip].

Pokud vaše wiki běží na vzdáleném serveru, rozbalte si archiv do nějakého dočasného adresáře na lokálním počítači a poté nahrajte '''všechny''' rozbalené soubory do adresáře <tt>extensions</tt> na vzdáleném serveru.

Nezapomeňte, že některá rozšíření vyžadují soubor <tt>ExtensionFunctions.php</tt>, který se nachází na <tt>extensions/ExtensionFunctions.php</tt>, tzn. v adresáři ''nadřazeném'' příslušnému rozšíření. Vytvořený balíček tento soubor obsahuje, po rozbalení se objeví v aktuálním adresáři (<tt>./ExtensionFunctions.php</tt>). Nezapomeňte na vzdálený server nahrát i tento soubor.

Po rozbalení souborů budete muset rozšíření zaregistrovat v souboru <tt>LocalSettings.php</tt>. Podrobnější informace by měla obsahovat dokumentace k rozšíření.

Případné dotazy k tomuto systému distribuce rozšíření můžete klást na stránce [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Stáhnout jiné rozšíření',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Metalhead64
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'extensiondistributor' => 'MediaWiki-Erweiterungen herunterladen',
	'extdist-desc' => 'Erweiterung für die Verteilung von Schnappschuss-Archiven von Erweiterungen',
	'extdist-not-configured' => 'Bitte konfiguriere $wgExtDistTarDir und $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Das konfigurierte Kopien-Arbeitsverzeichnis ist nicht vorhanden!',
	'extdist-no-such-extension' => 'Erweiterung „$1“ ist nicht vorhanden',
	'extdist-no-such-version' => 'Die Erweiterung „$1“ gibt es nicht in der Version „$2“.',
	'extdist-choose-extension' => 'Bitte wähle eine Erweiterung zum Herunterladen aus:',
	'extdist-wc-empty' => 'Das konfigurierte Kopien-Arbeitsverzeichnis enthält keine zu verteilenden Erweiterungen!',
	'extdist-submit-extension' => 'Weiter',
	'extdist-current-version' => 'Entwicklerversion (trunk)',
	'extdist-choose-version' => '
<big>Du lädst die <b>$1</b>-Erweiterung herunter.</big>

Bitte wähle deine MediaWiki-Version.

Die meisten Erweiterungen arbeiten mit vielen MediaWiki-Versionen zusammen. Wenn deine MediaWiki-Version hier nicht aufgeführt ist oder du die neuesten Fähigkeiten der Erweiterung nutzen möchtest, versuche es mit der aktuellen Version.',
	'extdist-no-versions' => 'Die gewählte Erweiterung ($1) ist nicht in der allen Versionen verfügbar!',
	'extdist-submit-version' => 'Weiter',
	'extdist-no-remote' => 'Der ferngesteuerte Subversion-Client ist nicht erreichbar.',
	'extdist-remote-error' => 'Fehlermeldung des ferngesteuerten Subversion-Client: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ungültige Antwort vom ferngesteuerten Subversion-Client.',
	'extdist-svn-error' => 'Subversion hat einen Fehler gemeldet: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'XML-Daten von „svn info“ können nicht verarbeitet werden: <pre>$1</pre>',
	'extdist-tar-error' => 'Das Tar-Programm lieferte den Beendigungscode $1:',
	'extdist-created' => "Ein Schnappschuss der Version <b>$2</b> der MediaWiki-Erweiterung <b>$1</b> wurde erstellt (MediaWiki-Version <b>$3</b>). Der Download startet automatisch in 5 Sekunden.

Die URL für den Schnappschuss lautet:
:$4
Die URL ist nur zum sofortigen Download gedacht, bitte speichere sie nicht als Lesezeichen ab, da der Dateiinhalt nicht aktualisiert wird und zu einem späteren Zeitpunkt gelöscht werden kann.

Das Tar-Archiv sollte in das Erweiterungs-Verzeichnis entpackt werden. Auf einem Unix-ähnlichen Betriebssystem mit:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Unter Windows kannst du das Programm [http://www.7-zip.org/ 7-zip] zum Entpacken der Dateien verwenden.

Wenn dein Wiki auf einem entfernten Server läuft, entpacke die Dateien in ein temporäres Verzeichnis auf deinem lokalen Computer und lade dann '''alle''' entpackten Dateien auf den entfernten Server hoch.

Bitte beachte, dass einige Erweiterungen die Datei <tt>ExtensionFunctions.php</tt> benötigen. Sie liegt unter <tt>extensions/ExtensionFunctions.php</tt>, dem Heimatverzeichnis der Erweiterungen. Der Schnappschuss dieser Erweiterung enthält diese Datei als tarbomb, entpackt nach <tt>./ExtensionFunctions.php</tt>. Vergiss nicht, auch diese Datei auf deinen entfernten Server hochzuladen.

Nachdem du die Dateien entpackt hast, musst du die Erweiterung in der <tt>LocalSettings.php</tt> registrieren. Die Dokumentation zur Erweiterung sollte eine Anleitung dazu enthalten.

Wenn du Fragen zu diesem Erweiterungs-Verteil-System hast, gehe bitte zur Seite [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Eine weitere Erweiterung holen.',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 * @author MichaelFrey
 */
$messages['de-formal'] = array(
	'extdist-not-configured' => 'Bitte konfigurieren Sie $wgExtDistTarDir und $wgExtDistWorkingCopy',
	'extdist-choose-extension' => 'Bitte wählen Sie eine Erweiterung zum Herunterladen aus:',
	'extdist-choose-version' => '<big>Sie laden die <b>$1</b>-Erweiterung herunter.</big>

Bitte wählen Sie ihre MediaWiki-Version.

Die meisten Erweiterungen arbeiten mit vielen MediaWiki-Versionen zusammen. Wenn Ihre MediaWiki-Version hier nicht aufgeführt ist oder Sie die neuesten Fähigkeiten der Erweiterung nutzen möchtest, versuche es mit der aktuellen Version.',
	'extdist-created' => "Ein Schnappschuss der Version <b>$2</b> der MediaWiki-Erweiterung <b>$1</b> wurde erstellt (MediaWiki-Version <b>$3</b>). Der Download startet automatisch in 5 Sekunden.

Die URL für den Schnappschuss lautet:
:$4
Die URL ist nur zum sofortigen Download gedacht, bitte speichern Sie sie nicht als Lesezeichen ab, da der Dateiinhalt nicht aktualisiert wird und zu einem späteren Zeitpunkt gelöscht werden kann.

Das .tar-Archiv sollte in das Erweiterungs-Verzeichnis entpackt werden. Auf einem Unix-ähnlichen Betriebssystem mit:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Unter Windows können Sie das Programm [http://www.7-zip.org/ 7-zip] zum Entpacken der Dateien verwenden.

Wenn Ihr Wiki auf einem entfernten Server läuft, entpacken Sie die Dateien in ein temporäres Verzeichnis auf Ihrem lokalen Computer und laden Sie dann '''alle''' entpackten Dateien auf den entfernten Server hoch.

Bitte beachte, dass einige Erweiterungen die Datei <tt>ExtensionFunctions.php</tt> benötigen. Sie liegt unter <tt>extensions/ExtensionFunctions.php</tt>, dem Heimatverzeichnis der Erweiterungen. Der Schnappschuss dieser Erweiterung enthält diese Datei als tarbomb, entpackt nach <tt>./ExtensionFunctions.php</tt>. Vergiss nicht, auch diese Datei auf deinen entfernten Server hochzuladen.

Nachdem Sie die Dateien entpackt haben, müssen Sie die Erweiterung in der <tt>LocalSettings.php</tt> registrieren. Die Dokumentation zur Erweiterung sollte eine Anleitung dazu enthalten.

Wenn Sie Fragen zu diesem Erweiterungs-Verteil-System haben, gehen Sie bitte zur Seite [[Extension talk:ExtensionDistributor]].",
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'extensiondistributor' => 'Extensiyonê MediyaWikiyî bar bike',
	'extdist-desc' => 'Ekstensiyon ke ser ekstesiyonê vila kerdişî arşivê snapshotî',
	'extdist-not-configured' => 'Ma rica keno ke $wgExtDistTarDir u $wgExtDistWorkingCopy konfigure bike',
	'extdist-wc-missing' => 'Direktorê kopyayî yê konfigure çini yo!',
	'extdist-no-such-extension' => 'Ekstensiyonê "$1"î çini yo',
	'extdist-no-such-version' => 'Versiyonê "$2"î de ekstensiyonê "$1"î çini yo',
	'extdist-choose-extension' => 'Ekstensiyon ke ti wazeno bar bike ey weçine:',
	'extdist-wc-empty' => 'Direktorê kopyayî yê konfigure ekstensiyon xo çini yo!',
	'extdist-submit-extension' => 'Dewam bıker',
	'extdist-current-version' => 'versiyonê dewlemend kerdışi (trunk)',
	'extdist-choose-version' => 'parçeya <big><b>$1</b>i ani war.</big>

Versiyonê MedyaVikiyi bıweçinê.

zafi parçeyi versiyonê MedyaVikiyi de xebıtyeni, eke versiyonê MedyaVikiyi yê şıma tiya de çino, versiyonê rocaneyi bısehnê.',
	'extdist-no-versions' => 'Ektensiyonan ($1) ke ti weçina versiyanan bînan de çini yo!',
	'extdist-submit-version' => 'dewam bıker',
	'extdist-no-remote' => 'Nieşkeno muşteriyê subvert ê durî ra kontak bike.',
	'extdist-remote-error' => 'Muşteriyê subvert ê durî ra yew ğelet biyo: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Cevabê muşteriyê subvert ê durî raşt niyo.',
	'extdist-svn-error' => 'Subversiyon de yew ğelet biyo: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Formê XML î "svn info", nieşkeno process biko: <pre>$1</pre>',
	'extdist-tar-error' => 'Kodê tar return exitî $1:',
	'extdist-created' => "qey yew lehza esayişê parçeyê <b>$1</b>i u versiyonê <b>$2</b>i MediaWiki <b>$3</b> vıraziya. gani war ardışê şıma zerreyê panc deqiqe de bı otomatik destpêbıkero.

esayişê URLyi yê lehzayek:
:$4
no, qey war ardışê pêşkeşwaneki şuxuliyeno labele muhtewa rocane nêbena u ihtimalê hewnakerdışi zi esto nê sebeban ra işaretê cayan têarê mekerê.

arşiwê tari gani bıveciyo parçeya rêzbiyayişi. misal, sistemê karkerdışê tipê unix'an de:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Windows de, qey vetışê dosyayan şıma eşkêni [http://www.7-zip.org/ 7-zip] bışuxulni.

Eke wikiya şıma yew pêşkeşwano dûr de ya, dosyayanê xo compiterê xo u dıma '''heme''' dosyayê veteyan parçeya rêzkerdışê compiteri de kopya bıkerê.

tayê parçeyan de extiyaciyê na dosya ExtensionFunctions.php esta, <tt>extensions/ExtensionFunctions.php</tt> de, rêzkerdışo ''bıngeyın'' de yo. veciyayo ExtensionFunctions.php.

badê vetışê dosyayan, parçe LocalSettings.php'de gani qeyd bıbo. dokumantasyonê parçeyi raye mocnena şıma.

Eke no sistem de yew problemê şıma bıbo, kerem kerê şêrê [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Yewna ekstensiyon bigere',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'extensiondistributor' => 'Rozšyrjenje MediaWiki ześěgnuś',
	'extdist-desc' => 'Rozšyrjenje za rozdźělowanje archiwow rozšyrjenjow',
	'extdist-not-configured' => 'Pšosym konfigurěruj $wgExtDistTarDir a $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Konfigurěrowany zapis źěłoweje kopije njeeksistěrujo!',
	'extdist-no-such-extension' => 'Rozšyrjenje "$1" njeeksistěrujo',
	'extdist-no-such-version' => 'Rozšyrjenje "$1" njeeksistěrujo we wersiji "$2".',
	'extdist-choose-extension' => 'Wubjeŕ rozšyrjenje, kótarež coš ześěgnuś:',
	'extdist-wc-empty' => 'Konfigurěrowany zapis źěłoweje kopije njama rozdźělujobne rozšyrjenja!',
	'extdist-submit-extension' => 'Dalej',
	'extdist-current-version' => 'Wuwiśowa wersija (trunk)',
	'extdist-choose-version' => '<big>Ześěgujoš rozšyrjenje <b>$1</b>.</big>

Wubjeŕ swóju wersiju MediaWiki.

Nejwěcej rozšyrjenjow funkcioněrujo w někotarych wersijach MediaWiki, jolic stakim twója wersija MediaWiki njejo how abo trjebaš nejnowše funkcije rozšyrjenja, wopytaj aktualnu wersiju wužywaś.',
	'extdist-no-versions' => 'Wubrane rozšyrjenje ($1) njestoj k dispoziciji we wšych wersijach!',
	'extdist-submit-version' => 'Dalej',
	'extdist-no-remote' => 'Njemóžno zdalony klient Subversion kontaktěrowaś',
	'extdist-remote-error' => 'Zmólka wót zdalonego klienta Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Njepłaśiwe wótegrono wót zdalonego klienta Subversion.',
	'extdist-svn-error' => 'Subversion jo starcył na zmólku: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Njejo móžno XML-daty ze "svn info" pśeźěłaś: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar jo wróśił kod skóncenja $1:',
	'extdist-created' => "Pakśik wersije <b>$2</b> rozšyrjenja <b>$1</b> za MediaWiki <b>$3</b> jo se napórał. Twójo ześěgnjenje by měło za 5 sekundow awtomatiski startowaś.

URL za toś ten pakśik jo:
:$4
Dataja wužywa se, aby se ned ześěgnuła na serwer, ale pšosym njeskładuj ju ako załožk, dokulaž se wopśimjeśe njezaktualizěrujo a wóna móžo se pózdźej wulašowaś.

Tar-archiw by měł se do twójego zapisa rozšyrjenjow rozpakowaś. Na pśikład na uniksowych źěłowych systemach:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Na Windowsu móžoš [http://www.7-zip.org/ 7-zip] wužywaś, aby rozpakował dataje.

Jolic twój wiki jo na zdalonem serwerje, rozpakuj dataje do nachylnego zapisa na swójom lokalnem licadle a nagraj pótom '''wše''' rozpakowane dataje do zapisa rozšyrjenjow na serwerje.

Źiwaj na to, až někotare rozšyrjenja trjebaja dataju z mjenim ExtensionFunctions.php, kótaraž jo w <tt>extensions/ExtensionFunctions.php</tt>, to groni, w ''nadrědowanem'' zapisu zapisa wótpowědnego rozšyrjenja. Pakśik za toś te rozšyrjenja wopśimujo toś tu dataju ako tar-bombu, rozpakowanu do ./ExtensionFunctions.php. Njezabudni toś tu dataju do swójogo zdalonego serwera nagraś.

Za tym, az sy rozpakował dataje, musyš rozšyrjenje w dataji localSettings.php registrěrowaś. Dokumentacija rozšyrjenja by měła instrukcije wopśimjeś, kak se dajo cyniś.

Jolic maš pšašanja wo toś tom systemje rozdźělowanja rozšyrjenjow, źi pšosym k [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Druge rozšyrjenje wobstaraś',
);

/** Greek (Ελληνικά)
 * @author Dead3y3
 * @author Geraki
 * @author Omnipaedista
 */
$messages['el'] = array(
	'extensiondistributor' => 'Κατέβασμα επέκτασης Mediawiki',
	'extdist-desc' => 'Επέκταση για τη διανομή στιγμιοτύπων επεκτάσεων',
	'extdist-not-configured' => 'Παρακαλώ ρυθμίστε τα $wgExtDistTarDir και $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Ο καθορισμένος πηγαίος κατάλογος εργασίας δεν υπάρχει!',
	'extdist-no-such-extension' => 'Δεν υπάρχει επέκταση "$1"',
	'extdist-no-such-version' => 'Η επέκταση "$1" δεν υπάρχει στην έκδοση "$2".',
	'extdist-choose-extension' => 'Επιλέξτε ποια επέκταση θέλετε να κατεβάσετε:',
	'extdist-wc-empty' => 'Ο καθορισμένος πηγαίος κατάλογος εργασίας δεν έχει διανεμήσιμες επεκτάσεις!',
	'extdist-submit-extension' => 'Συνέχεια',
	'extdist-current-version' => 'Έκδοση ανάπτυξης (κορμός)',
	'extdist-choose-version' => '<big>Κατεβάζετε την επέκταση <b>$1</b>.</big>

Επιλέξτε την έκδοση του MediaWiki σας.

Οι περισσότερες επεκτάσεις λειτουργούν μεταξύ πολλαπλών εκδόσεων του MediaWiki, οπότε αν η έκδοση του MediaWiki σας δεν είναι εδώ ή αν έχετε ανάγκη τα τελευταία χαρακτηριστικά της επέκτασης, δοκιμάστε την τρέχουσα έκδοση.',
	'extdist-no-versions' => 'Η επιλεγμένη επέκταση ($1) δεν είναι διαθέσιμη σε καμία έκδοση!',
	'extdist-submit-version' => 'Συνέχεια',
	'extdist-no-remote' => 'Αδύνατη η επικοινωνία με τον απομακρυσμένο πελάτη subversion.',
	'extdist-remote-error' => 'Σφάλμα από τον απομακρυσμένο πελάτη subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Άκυρη απόκριση από τον απομακρυσμένο πελάτη subversion.',
	'extdist-svn-error' => 'Το σύστημα Subversion αντιμετώπισε ένα σφάλμα: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Αδύνατη η επεξεργασία της XML από το "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'To Tar επέστρεψε κωδικό εξόδου $1:',
	'extdist-created' => "Ένα στιγμιότυπο της έκδοσης <b>$2</b> της επέκτασης <b>$1</b> για το MediaWiki <b>$3</b> έχει δημιουργηθεί. Η λήψη σας θα πρέπει να ξεκινήσει αυτόματα σε 5 δευτερόλεπτα.

Το URL για αυτό το στιγμιότυπο είναι:
:$4
Μπορεί να χρησιμοποιηθεί για άμεση λήψη σε έναν εξυπηρετητή, αλλά παρακαλώ μην το βάλετε στους σελιδοδείκτες σας, αφού τα περιεχόμενα δεν θα ενημερωθούν, και μπορεί να διαγραφεί σε μια μεταγενέστερη ημερομηνία.

Το συμπιεσμένο αρχείο tar θα πρέπει να αποσυμπιεστεί στον κατάλογο επεκτάσεων σας. Για παράδειγμα, σε ένα unix-οειδές λειτουργικό σύστημα:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Στα Windows, μπορείτε να χρησιμοποιήσετε το πρόγραμμα [http://www.7-zip.org/ 7-zip] για να αποσυμπιέσετε τα αρχεία.

Αν το wiki σας είναι σε έναν απομακρυσμένο εξυπηρετητή, αποσυμπιέστε τα αρχεία σε έναν προσωρινό κατάλογο στον τοπικό σας υπολογιστή, και μετά επιφορτώστε '''όλα''' τα αποσυμπιεσμένα αρχεία στον κατάλογο επεκτάσεων στον εξυπηρετητή.

Σημειώστε ότι μερικές επεκτάσεις χρειάζονται ένα αρχείο με ονομασία ExtensionFunctions.php, το οποίο βρίσκεται στη διαδρομή <tt>extensions/ExtensionFunctions.php</tt>, δηλαδή στον ''πατρικό'' κατάλογο αυτού του συγκεκριμένου καταλόγου επεκτάσεων. Το στιγμιότυπο για αυτές τις επεκτάσεις περιέχει αυτό το αρχείο ως tarbomb, αποσυμπιεσμένο στο ./ExtensionFunctions.php. Μην αμελήσετε να επιφορτώσετε αυτό το αρχείο στον απομακρυσμένο εξυπηρετητή σας.

Αφότου αποσυμπιέσετε τα αρχεία, θα χρειαστεί να εγγράψετε την επέκταση στο αρχείο LocalSettings.php. Η τεκμηρίωση της επέκτασης θα πρέπει να έχει οδηγίες για το πως να το κάνετε.

Αν έχετε ερωτήσεις για αυτό το σύστημα διανομής επεκτάσεων, παρακαλώ πηγαίνετε στη σελίδα [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Άλλη επέκταση',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'extensiondistributor' => 'Elŝuti kromprogramon por MediaWiki',
	'extdist-desc' => 'Kromprogramo por distribui statikajn arkivojn de kromprogramoj',
	'extdist-not-configured' => 'Bonvolu konfiguri $wgExtDistTarDir kaj $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'La konfigurita laborspaca dosierujo ne ekzistas!',
	'extdist-no-such-extension' => 'Kromprogramo "$1" ne ekzistas',
	'extdist-no-such-version' => 'La kromprogramo "$1" ne ekzistas en la versio "$2".',
	'extdist-choose-extension' => 'Elektu kiun kromprogramon tiun vi volas elŝuti.',
	'extdist-wc-empty' => 'La konfigurita laborspaca dosierujo ne havas doneblaj kromprogramoj!',
	'extdist-submit-extension' => 'Daŭri',
	'extdist-current-version' => 'Disvolvada versio (bazo)',
	'extdist-choose-version' => '<big>Vi elŝutas la <b>$1</b> kromprogramon.</big>

Elektu vian MediaWiki-version.

Pliparto de kromprogramoj funkcias trans pluraj versioj de MediaWiki, do se via MediaWiki-versio ne estas trovebla cxi tie, aux se vi bezonas la plej novajn ecojn, provu uzi la plej lastan version.',
	'extdist-no-versions' => 'La elektita kromprogramo ($1) ne estas havebla en iu ajn versio!',
	'extdist-submit-version' => 'Daŭri',
	'extdist-no-remote' => 'Ne eblas kontakti eksteran klienton de subversion.',
	'extdist-remote-error' => 'Eraro de la ekstera kliento de subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Nevalida respondo de ekstera kliento de Subversion.',
	'extdist-svn-error' => 'Subversion renkontis eraron: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Ne eblas trakti la XML de "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar donis elirkodon $1:',
	'extdist-created' => "Statika kopio de versio <b>$2</b> de la <b>$1</b> kromprogramo por MediaWiki <b>$3</b> estis kreita. Via elŝuto komencos aŭtomate post 5 sekundoj.

La URL-o por ĉi tiu statika kopio estas:
:$4
Ĝi estas uzebla por tuja elŝuto al servilo, sed bonvolu ne aldoni legosignon al ĝin, ĉar la enhavo ne estos ĝisdata, kaj ĝi eble estos forigita ĉe posta dato.

La tar-arkivo estu eltirita en vian kromprograman dosierujon. Ekz-e, en Unikseca OS:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Kun Vindozo, vi povas utiligi [http://www.7-zip.org/ 7-zip] eltiri la dosierojn.

Se via vikio estas en ektera servilo, eltiru la dosierojn al provizoran dosierujon en via loka komputilo, kaj poste alŝutu '''ĉiuj''' de la eltiritaj dosieroj al la kromprograma dosierujo en la servilo.

Notu, ke iuj kromprogramoj bezonas dosieron nomitan ExtensionFunctions.php, lokitan en <tt>extensions/ExtensionFunctions.php</tt>, alivorte, la ''patra'' dosierujo de la dosierujo de ĉi tiu kromprogramo. La statika kopio por ĉi tiuj kromprogramoj enhavas ĉi tiun dosieron kiel ''tar-bombo'', eltiritan al ./ExtensionFunctions.php. Ne forgesu alŝuti ĉi tiun dosieron al via ekstera servilo.

Post vi eltiris la dosierojn, vi bezonas registri la kromprogramon en LocalSettings.php. La kromprograma dokumentado havos la instrukcioj kiel fari.

Se vi havas iujn demandojn pri ĉi tiu kromprograma distribuada sistemo, bonvolu komenti al [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Akiri pluan kromprogramon',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'extensiondistributor' => 'Descargar extensión MediaWiki',
	'extdist-not-configured' => 'Por favor configure $wgExtDistTarDir y $wgExtDistWorkingCopy',
	'extdist-no-such-extension' => 'No existe la extensión «$1»',
	'extdist-no-such-version' => 'la extensión "$1" no existe en la versión "$2".',
	'extdist-choose-extension' => 'Seleccione cual extensión desea descargar:',
	'extdist-submit-extension' => 'Continuar',
	'extdist-current-version' => 'versión en desarrollo (principal)',
	'extdist-choose-version' => '<big>Estás descargando la extensión <b>$1</b>.</big>

Selecciona tu versión MediaWiki.

La mayoría de extensiones funcionan a través de múltiples versiones de Mediawiki, entonces si tu versión Mediawiki no está aquí, o si necesitas las últimas características de las extensiones. trata de usar la versión actual.',
	'extdist-no-versions' => 'La extensión seleccionada ($1) no esta disponible en ninguna versión!',
	'extdist-submit-version' => 'Continuar',
	'extdist-svn-error' => "''Subversion'' encontró un error: <pre>$1</pre>",
	'extdist-svn-parse-error' => 'Incapaz de procesar el XML de "svn info": <pre>$1</pre>',
	'extdist-created' => "Una instantánea de la versión <b>$2</b> de la <b>$1</b> extensión para MediaWiki <b>$3</b> ha sido creada. Tu descarga debería comenzar automáticamente en 5 segundos.

El URL para esta instantánea es:
:$4
Puede ser usada para una descarga inmediata a un servidor, pero por favor no ponerlo como marcador, ya que los contenidos no serán actualizados, y pueden ser borrados en una fecha posterior.

El archivo brea debería ser extraído dentro de tu directorio de extensiones. Por ejemplo, en un sistema operativo tipo Unix:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

En Windows, Puedes usar [http://www.7-zip.org/ 7-zip] para extraer los archivos.

Si tu wiki está en un archivo remoto, extrae el archivo a un directorio temporal en tu computadora local, y luego carga '''todo''' de los archivos extraídos al directorio de extensiones en el servidor.

Nota que algunas extensiones necesitan un archivo llamado ExtensionFunctions.php, localizado en <tt>extensions/ExtensionFunctions.php</tt>, que está, en el directorio ''matriz'' de éste particular directorio de extensiones. la instantánea de estas extensiones contiene este archivo como una bomba de alquitrán, extraído a ./ExtensionFunctions.php. No olvides de cargar éste archivo a tu servidor remoto.

Después que has extraído los archivos, necesitarás registrar la extensión en LocalSettings.php. La documentación de extensiones deberían tener instrucciones de como hacer esto.

Si tienes algunas preguntas acerca de éste sistema de distribución de extensiones, por favor ve a [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Obtener otra extensión',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Ker
 * @author Pikne
 */
$messages['et'] = array(
	'extensiondistributor' => 'MediaWiki-laienduse allalaadimine',
	'extdist-desc' => 'Võimaldab jagada laienduste hetktõmmiste arhiivi.',
	'extdist-no-such-extension' => 'Laiendus "$1" puudub',
	'extdist-no-such-version' => 'Versioonis "$2" puudub laiendus "$1".',
	'extdist-choose-extension' => 'Vali laiendus, mida soovid alla laadida:',
	'extdist-submit-extension' => 'Jätka',
	'extdist-current-version' => "Arendusversioon (''trunk'')",
	'extdist-choose-version' => '<big>Laadid alla laiendust <b>$1</b>.</big>

Vali oma MediaWiki versioon.

Suurem osa laiendusi töötab erinevate MediaWiki versioonidega. Kui sinu MediaWiki versiooni pole siin või sa vajad laienduse uusimaid funktsioone, proovi kasutada praegust versiooni.',
	'extdist-no-versions' => 'Valitud laiendusest $1 pole saadaval ühtegi versiooni!',
	'extdist-submit-version' => 'Jätka',
	'extdist-want-more' => 'Hangi teine laiendus',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'extensiondistributor' => 'MediaWiki luzapena jaitsi',
	'extdist-submit-extension' => 'Jarraitu',
	'extdist-submit-version' => 'Jarraitu',
	'extdist-want-more' => 'Beste luzapen bat hartu',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'extensiondistributor' => 'بارگیری افزونهٔ مدیاویکی',
	'extdist-desc' => 'افزونه‌ای برای انتشار بایگانی‌های لحظه‌ای از افزونه‌ها',
	'extdist-not-configured' => 'لطفاً ‎$‎wgExtDistTarDir و ‎$wgExtDistWorkingCopy را تنظیم کنید',
	'extdist-wc-missing' => 'شاخهٔ کپی کاری تنظیم شده وجود ندارد!',
	'extdist-no-such-extension' => 'افزونه‌ای به نام «$1» وجود ندارد',
	'extdist-no-such-version' => 'افزونهٔ «$1» در نسخهٔ «$2» وجود ندارد.',
	'extdist-choose-extension' => 'افزونه‌ای را که می‌خواهید بارگیری کنید انتخاب کنید:',
	'extdist-wc-empty' => 'کپی کاری تنظیم شده افزونهٔ قابل انتشاری ندارد!',
	'extdist-submit-extension' => 'ادامه',
	'extdist-current-version' => 'نسخهٔ فعلی (تنه)',
	'extdist-choose-version' => '<big>شما در حال بارگیری افزونهٔ <b>$1</b> هستید.</big>

نسخهٔ مدیاویکی خود را انتخاب کنید.

بیشتر افزونه‌ها با نسخه‌های مختلف مدیاویکی کار می‌کنند، پس اگر نسخهٔ مدیاویکی شما این‌جا نیست، یا اگر می‌خواهید از آخرین امکانات افزونه استفاده کنید، نسخهٔ فعلی را استفاده کنید.',
	'extdist-no-versions' => 'افزونهٔ انتخاب شده ($1) برای هیچ کدام از نسخه‌ها در دسترس نیست!',
	'extdist-submit-version' => 'ادامه',
	'extdist-no-remote' => 'امکان برقراری ارتباط با برنامه ساب‌ورژن خارجی وجود ندارد.',
	'extdist-remote-error' => 'خطا از طرف برنامهٔ ساب‌ورژن خارجی: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'پاسخ غیر مجاز از طرف برنامهٔ ساب‌ورژن خارجی.',
	'extdist-svn-error' => 'ساب‌ورژن دچار یک خطا شد: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'امکان پردازش اکس‌ام‌ال دریافتی از «svn info» وجود ندارد: <pre>$1</pre>',
	'extdist-tar-error' => 'تار خطای خروج $1 برگرداند:',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'extensiondistributor' => 'Lataa MediaWikin laajennus',
	'extdist-desc' => 'Laajennus laajennusten tilannevedosarkistojen jakelulle.',
	'extdist-not-configured' => 'Aseta $wgExtDistTarDir ja $wgExtDistWorkingCopy.',
	'extdist-wc-missing' => 'Määritettyä työkopiohakemistoa ei ole olemassa.',
	'extdist-no-such-extension' => 'Laajennusta ”$1” ei löydy',
	'extdist-no-such-version' => 'Laajennus ”$1” ei sisälly versioon ”$2”.',
	'extdist-choose-extension' => 'Valitse mitkä laajennukset haluat ladata:',
	'extdist-wc-empty' => 'Määritetyssä työkopiohakemistossa ei ole jaeltavia laajennuksia.',
	'extdist-submit-extension' => 'Jatka',
	'extdist-current-version' => 'Kehitysversio (trunk)',
	'extdist-choose-version' => '<big>Olet lataamassa laajennusta <b>$1</b>.</big>

Valitse MediaWikisi versio.

Useimmat laajennukset toimivat useiden MediaWikin versioiden välillä. Jos MediaWikisi versiota ei ole täällä tai tarvitset viimeisimpiä ominaisuuksia laajennuksesta, kokeile nykyistä versiota.',
	'extdist-no-versions' => 'Valitusta laajennuksesta ($1) ei ole saatavilla yhtään versiota!',
	'extdist-submit-version' => 'Jatka',
	'extdist-no-remote' => 'Subversion-asiakasohjelmaan ei saatu yhteyttä.',
	'extdist-remote-error' => 'Virhe ulkoisesta subversion-asiakasohjelmasta: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Kelpaamaton vastaus ulkoiselta subversion-asiakasohjelmalta.',
	'extdist-svn-error' => 'Subversion kohtasi virheen: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'XML-dataa ei voitu käsitellä ”svn info” -komennosta: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar-ohjelman suoritus päättyi paluuarvoon $1:',
	'extdist-created' => "Tilannevedos laajennuksen <b>$1</b> versiosta <b>$2</b> MediaWikin versiolle <b>$3</b> on luotu. Latauksesi pitäisi alkaa automaattisesti viiden sekunnin kuluttua.

URL tälle tilannevedokselle on
:$4
Osoitetta voi käyttää välittömään lataukseen palvelimelle, mutta älä laita sitä kirjanmerkiksi, koska sen sisältö ei päivity ja se saatetaan poistaa.

Tar-paketti pitäisi purkaa extensions-hakemistoon. Esimerkiksi unix-tyylisessä käyttöjärjestelmässä se tapahtuu seuraavalla komennolla:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Windowsissa voit käyttää [http://www.7-zip.org/ 7-zip]-ohjelmaa tiedostojen purkamiseen.

Jos wikisi on etäpalvelimella, pura tiedostot väliaikaishakemistoon paikalliselle tietokoneelle ja tämän jälkeen lähetä '''kaikki''' puretut tiedostot extensions-hakemistoon etäpalvelimelle.

Huomaa, että jotkin laajennukset vaativat tiedoston ''ExtensionFunctions.php'', jonka sijainti on <tt>extensions/ExtensionFunctions.php</tt>. Tiedosto sijaitsee varsinaisen laajennushakemiston ''ylähakemistossa''. Näille laajennuksille luotu tilannevedos sisältää tämän tiedoston tar-pommina, purettuna juuressa ./ExtensionFunctions.php. Älä jätä lähettämättä tätä tiedostoa etäpalvelimellesi.

Kun olet purkanut tiedostot, sinun tulee rekisteröidä laajennus LocalSettings.php-tiedostoon. Laajennuksen ohjeissa pitäisi olla ohjeet siihen.

Jos sinulla on kysymyksiä tähän jakelujärjestelmään liittyen, sivulla [[Extension talk:ExtensionDistributor]] voi keskustella aiheesta.",
	'extdist-want-more' => 'Hae toinen laajennus',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Verdy p
 */
$messages['fr'] = array(
	'extensiondistributor' => 'Télécharger l’extension MediaWiki',
	'extdist-desc' => 'Extension pour la distribution des archives photographiques des extensions',
	'extdist-not-configured' => 'Veuillez configurer $wgExtDistTarDir et $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'La répertoire pour copies de travail configurée n’existe pas !',
	'extdist-no-such-extension' => 'Aucune extension « $1 »',
	'extdist-no-such-version' => 'L’extension « $1 » n’existe pas dans la version « $2 ».',
	'extdist-choose-extension' => 'Sélectionnez l’extension que vous voulez télécharger :',
	'extdist-wc-empty' => 'Le répertoire pour copies de travail configurée n’a aucune extension distribuable !',
	'extdist-submit-extension' => 'Continuer',
	'extdist-current-version' => 'Version de développement (trunk)',
	'extdist-choose-version' => '<big>Vous êtes en train de télécharger l’extension <b>$1</b>.</big>

Sélectionnez votre version de MediaWiki.

La plupart des extensions tourne sur différentes versions de MediaWiki. Aussi, si votre version n’est pas présente ici, ou si vous avez besoin des dernières fonctionnalités de l’extension, essayez d’utiliser la version courante.',
	'extdist-no-versions' => "L’extension sélectionnée ($1) n'est disponible dans aucune version !",
	'extdist-submit-version' => 'Continuer',
	'extdist-no-remote' => 'Impossible de contacter le client subversion distant.',
	'extdist-remote-error' => 'Erreur du client subversion distant : <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Réponse incorrecte depuis le client subversion distant.',
	'extdist-svn-error' => 'Subversion a rencontré une erreur : <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Impossible de traiter les données XML retournées par « svn info » : <pre>$1</pre>',
	'extdist-tar-error' => 'Tar a retourné le code de sortie $1 :',
	'extdist-created' => "Une copie instantanée de la version <b>$2</b> de l’extension <b>$1</b> pour MediaWiki <b>$3</b> a été créée. Votre téléchargement devrait commencer automatiquement dans 5 secondes.

L’adresse de cette copie est :
: $4
Elle peut être utilisée pour un téléchargement immédiat vers un serveur, mais évitez de l’inscrire dans vos signets, puisque son contenu ne sera pas mis à jour et peut être effacé à une date ultérieure.

L’archive tar devrait être extraite dans votre répertoire <tt>extensions</tt>. Par exemple sur un système semblable à Unix :

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Sous Windows, vous pouvez utiliser [http://www.7-zip.org/ 7-zip] pour extraire les fichiers.

Si votre wiki est hébergé sur un serveur distant, extrayez les fichiers dans un répertoire temporaire de votre ordinateur local, puis téléversez-les '''tous''' dans le répertoire extensions du serveur.

Notez que quelques extensions nécessitent un fichier nommé <tt>ExtensionFunctions.php</tt> stocké dans le répertoire <tt>extensions</tt>, lui-même situé dans le répertoire ''parent'' du répertoire particulier pour cette extension. L’image de telles extensions contient ce fichier dans l’archive tar, il sera extrait sous <tt>./ExtensionFunctions.php</tt>. N’omettez pas de le téléverser aussi sur votre serveur distant.

Une fois les fichiers extraits et installés, il vous faudra enregistrer l’extension dans <tt>LocalSettings.php</tt>. La documentation de l’extension devrait contenir un guide d’installation expliquant comment procéder.

Si vous avez des questions concernant ce système de distribution des extensions, veuillez consulter [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Obtenir une autre extension',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'extensiondistributor' => 'Tèlèchargiér l’èxtension MediaWiki',
	'extdist-desc' => 'Èxtension por la distribucion de les arch·ives fotografiques de les èxtensions.',
	'extdist-not-configured' => 'Volyéd configurar $wgExtDistTarDir et $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Lo rèpèrtouèro por copies d’ôvra configurâ ègziste pas !',
	'extdist-no-such-extension' => 'Gins d’èxtension « $1 »',
	'extdist-no-such-version' => 'L’èxtension « $1 » ègziste pas dens la vèrsion « $2 ».',
	'extdist-choose-extension' => 'Chouèsésséd l’èxtension que vos voléd tèlèchargiér :',
	'extdist-wc-empty' => 'Lo rèpèrtouèro por copies d’ôvra configurâ at gins d’èxtension distribuâbla !',
	'extdist-submit-extension' => 'Continuar',
	'extdist-current-version' => 'Vèrsion de dèvelopament (trunk)',
	'extdist-no-versions' => 'L’èxtension chouèsia ($1) est pas disponibla dens gins de vèrsion !',
	'extdist-submit-version' => 'Continuar',
	'extdist-no-remote' => 'Empossiblo de sè veriér vers lo cliant sot-vèrsion distant.',
	'extdist-remote-error' => 'Èrror du cliant sot-vèrsion distant : <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Rèponsa fôssa dês lo cliant sot-vèrsion distant.',
	'extdist-svn-error' => 'Sot-vèrsion at rencontrâ una èrror : <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Empossiblo de trètar les balyês XML retornâs per « svn info » : <pre>$1</pre>',
	'extdist-tar-error' => 'Tar at retornâ lo code de sortia $1 :',
	'extdist-want-more' => 'Avêr una ôtra èxtension',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'extensiondistributor' => 'Descargar a extensión MediaWiki',
	'extdist-desc' => 'Extensión para distribuír arquivos fotográficos de extensións',
	'extdist-not-configured' => 'Por favor, configure $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'O directorio da copia en funcionamento configurada non existe!',
	'extdist-no-such-extension' => 'Non existe a extensión "$1"',
	'extdist-no-such-version' => 'A extensión "$1" non existe na versión "$2".',
	'extdist-choose-extension' => 'Seleccione a extensión que queira descargar:',
	'extdist-wc-empty' => 'A copia configurada do directorio que funciona non ten extensións que se poidan distribuír!',
	'extdist-submit-extension' => 'Continuar',
	'extdist-current-version' => 'Versión en desenvolvemento (trunk)',
	'extdist-choose-version' => '<big>Está descargando a extensión <b>$1</b>.</big>

Seleccione a súa versión MediaWiki.

A maioría das extensións traballan con múltiples versións de MediaWiki, polo que se a súa versión de MediaWiki non está aquí, ou se precisa características da última extensión, probe a usar a versión actual.',
	'extdist-no-versions' => 'A extensión seleccionada ($1) non está dispoñible en ningunha versión!',
	'extdist-submit-version' => 'Continuar',
	'extdist-no-remote' => 'Non se pode contactar co cliente da subversión remota.',
	'extdist-remote-error' => 'Erro do cliente da subversión remota: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Resposta inválida do cliente da subversión remota.',
	'extdist-svn-error' => 'A subversión atopou un erro: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Non se pode procesar o XML de "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar devolveu o código de saída $1:',
	'extdist-created' => "Unha fotografía da versión <b>$2</b> da extensión <b>$1</b> de MediaWiki <b>$3</b> foi creada. A súa descarga debería comezar automaticamente en 5 segundos.

O enderezo URL desta fotografía é:
:$4
Poderá ser usada para descargala inmediatamente a un servidor, pero, por favor, non a engada á lista dos seus favoritos mentres o contido non é actualizado. Poderá tamén ser eliminada nuns días.

O arquivo tar deberá ser extraído no seu directorio de extensións. Por exemplo, nun sistema beseado no UNIX:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

No Windows, pode usar [http://www.7-zip.org/ 7-zip] para extraer os ficheiros.

Se o seu wiki está nun servidor remoto, extraia os ficheiros nun directorio temporal no seu computador e logo cargue '''todos''' os ficheiros extraídos no directorio de extensións do servidor.

Déase de conta de que algunhas extensións precisan dun ficheiro chamado ExtensionFunctions.php, localizado en <tt>extensions/ExtensionFunctions.php</tt>, que está no directorio ''parente'' deste directorio particular da extensión. A fotografía destas extensións contén este ficheiro como un tarbomb, extraído en ./ExtensionFunctions.php. Non se descoide ao cargar este ficheiro no seu servidor remoto.

Despois de extraer os ficheiros, necesitará rexistrar a extensión en LocalSettings.php. A documentación da extensión deberá ter instrucións de como facer isto.

Se ten algunha dúbida ou pregunta acerca do sistema de distribución das extensións, por favor, vaia a [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Obter outra extensión',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'extdist-submit-extension' => 'Συνεχίζειν',
	'extdist-submit-version' => 'Συνεχίζειν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'extensiondistributor' => 'MediaWiki-Erwyterige abelade',
	'extdist-desc' => 'Erwyterig fir d Verteilig vu Schnappschuss-Archiv vu Erwyterige',
	'extdist-not-configured' => 'Bitte konfigurier $wgExtDistTarDir un $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'S konfiguriert Kopie-Arbetsverzeichnis git s nit!',
	'extdist-no-such-extension' => 'D Erwyterig „$1“ git s nit',
	'extdist-no-such-version' => 'D Erwyterig „$1“ git s nit in dr Version „$2“.',
	'extdist-choose-extension' => 'Bitte wähl e Erwyterig uus zum Abelade:',
	'extdist-wc-empty' => 'Im konfigurierte Kopie-Arbetsverzeichnis git s kei Erwyterige, wu mer cha verteile!',
	'extdist-submit-extension' => 'Wyter',
	'extdist-current-version' => 'Entwickligs-Version (trunk)',
	'extdist-choose-version' => '<big>Du ladsch d <b>$1</b>-Erwyterig abe.</big>

Bitte wähl Dyyni MediaWiki-Version.

Di meischte Erwyterige schaffe mit vyyle MediaWiki-Versione zämme. Wänn Dyyni MediaWiki-Version doo nit ufgfiert isch oder Du di nejschte Fähigkeite vu dr Eryterig witt nutze, no versuech s mit dr aktuälle Version.',
	'extdist-no-versions' => 'Di gwählt Erwyterig ($1) git s nit in allene Versione!',
	'extdist-submit-version' => 'Wyter',
	'extdist-no-remote' => 'S git kei Kontakt zum färngstyyrte Subversion-Client.',
	'extdist-remote-error' => 'Fählermäldig vum färngstyyrte Subversion-Client: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Uugiltigi Antwort vum färngstyyrte Subversion-Client.',
	'extdist-svn-error' => 'Subversion het e Fähler gmäldet: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'XML-Date vu „svn info“ chenne nit verschafft wäre: <pre>$1</pre>',
	'extdist-tar-error' => 'S Tar-Programm het dr Beändigungscode $1 gliferet:',
	'extdist-created' => "E Schnappschuss vu dr Version <b>$2</b> vu dr MediaWiki-Erwyterig <b>$1</b> isch aagleit wore (MediaWiki-Version <b>$3</b>). S Abelade fangt automatisch in 5 Sekunde aa.

D URL fir dr Schnappschuss isch:
:$4
D URL isch nume zum sofortige Abelade dänkt, bitte spychere si nit as Läsezeiche ab, wel dr Dateiinhalt nit aktualisiert wird un speter cha glescht wäre.

S Tar-Archiv sott in s Erwyterigs-Verzeichnis uuspackt wäre. Uf eme Unix-ähnlige Betriebssystem mit:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Unter Windows chasch s Programm [http://www.7-zip.org/ 7-zip] zum Uuspacke vu dr Dateie neh.

Wänn Dyy Wiki uf eme entfärnte Server lauft, no pack d Dateie in e temporäre Verzeichnis uf Dyynem lokale Computer uus un lad deno '''alli''' uuspackte Dateie uf dr entfärnt Server uffe.

Bitte gib Acht, ass e Teil Erwyterige d Datei <tt>ExtensionFunctions.php</tt> bruuche. Si lyt unter <tt>extensions/ExtensionFunctions.php</tt>, em Heimetverzeichnis vu dr Erwyterige. Im Schnappschuss vu däre Erwyterig het s die Datei as tarbomb, no <tt>./ExtensionFunctions.php</tt> uuspackt. Vergiss nit, au die Datei uf Dyy entfärnte Server uufezlade.

Wänn Du d Dateie uuspackt hesch, muesch d Erwyterig in dr <tt>LocalSettings.php</tt> regischtriere. In dr Dokumentation zue dr Erwyterig sott s a Aaleitig derzue haa.

Wänn Du Froge hesch zue däm Erwyterigs-Verteil-Syschtem, no gang bitte uf d Syte [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'No ne Erwyterig hole',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'extensiondistributor' => 'הורדת הרחבה של מדיה־ויקי',
	'extdist-desc' => 'הרחבה להפצת קבצים מכווצים של הרחבות',
	'extdist-not-configured' => 'אנא הגדירו את $wgExtDistTarDir ואת $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'התיקייה שהוגדרה כתיקיית ההרחבות אינה קיימת!',
	'extdist-no-such-extension' => 'אין הרחבה בשם "$1"',
	'extdist-no-such-version' => 'ההרחבה "$1" אינה קיימת בגרסה "$2".',
	'extdist-choose-extension' => 'בחרו איזו הרחבה תרצו להוריד:',
	'extdist-wc-empty' => 'בתיקייה שהוגדרה כתיקיית ההרחבות אין הרחבות שניתן להוריד!',
	'extdist-submit-extension' => 'המשך',
	'extdist-current-version' => 'גרסת הפיתוח (trunk)',
	'extdist-choose-version' => '
<big>אתם מורידים את ההרחבה <b>$1</b>.</big>

אנא בחרו את גרסת מדיה־ויקי שאתם משתמשים בה.

רוב ההרחבות עובדות בגרסאות מרובות של מדיה־ויקי, לכן אם גרסת מדיה־ויקי שאתם משתמשים בה אינה מופיעה כאן, או אם אתם צריכים את התכונות האחרונות שנוספו להרחבה, נסו להשתמש בגרסה הנוכחית.',
	'extdist-no-versions' => 'ההרחבה שנבחרה ($1) אינה זמינה בשום גרסה!',
	'extdist-submit-version' => 'המשך',
	'extdist-no-remote' => 'לא ניתן להתחבר ללקוח ה־Subversion המרוחק.',
	'extdist-remote-error' => 'שגיאה מלקוח ה־Subversion המרוחק: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'תשובה בלתי תקינה מלקוח ה־Subversion המרוחק.',
	'extdist-svn-error' => 'תוכנת Subversion נתקלה בשגיאה: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'לא ניתן לעבד את ה־XML שהוחזר מפקודת "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'פקודת tar החזירה את קוד היציאה $1:',
	'extdist-created' => "נוצר קובץ של גרסה <b>$2</b> של ההרחבה <b>$1</b> עבור מדיה־ויקי <b>$3</b>. ההורדה תתחיל אוטומטית בעוד 5 שניות.

כתובת ה־URL של קובץ זה היא:
:$4
ניתן להשתמש בה להורדה מיידית לשרת, אבל אנא אל תוסיפו אותה לסימניות הדפדפן, כיוון שתכניה לא יעודכנו, וכיוון שייתכן שהיא תימחק מאוחר יותר.

עליכם לפרוס את קובץ ה־tar לתוך תיקיית ההרחבות שלכם. לדוגמה, במערכת הפעלה דמוית יוניקס:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

בחלונות, באפשרותכם להשתמש בתוכנת [http://www.7-zip.org/ 7-zip] כדי לפרוס את הקבצים.

אם אתר הוויקי שלכם הוא בשרת מרוחק, פרסו את הקבצים לתוך תיקייה זמנית במחשב המקומי שלכם, ואז העלו את '''כל''' הקבצים שנפרסו לתיקיית ההרחבות בשרת.

שימו לב שכמה הרחבות דורשות קובץ הנקרא ExtensionFunctions.php, הממוקם בתיקייה <tt>extensions/ExtensionFunctions.php</tt>, כלומר, בתיקיית ה'''הורה''' של התיקייה של ההרחבה המסוימת הזאת. הקובץ שנוצר להרחבות כאלה מכיל את הקובץ כקובץ שנפרס לתיקיית העבודה הנוכחית (Tarbomb), כלומר נפרס לנתיב ./ExtensionFunctions.php. אל תשכחו להעלות גם את הקובץ הזה לשרת המרוחק שלכם.

לאחר שפרסתם את הקבצים, תצטרכו לרשום את ההרחבה בקובץ LocalSettings.php. תיעוד ההרחבה אמור לכלול הנחיות כיצד לעשות זאת.

אם יש לכם שאלות כלשהן על מערכת הפצת ההרחבות הזו, אנא עברו לדף [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'הורדת הרחבה נוספת',
);

/** Croatian (Hrvatski)
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'extensiondistributor' => 'Snimi MediaWiki ekstenziju',
	'extdist-desc' => 'Ekstenzija za distribuciju inačica arhiva ekstenzija',
	'extdist-not-configured' => 'Molimo konfigurirajte $wgExtDistTarDir i $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Konfigurirani radni direktorij za kopiranje ne postoji!',
	'extdist-no-such-extension' => 'Nema takve ekstenziju "$1"',
	'extdist-no-such-version' => 'Ekstenzija "$1" ne postoji u verziji "$2".',
	'extdist-choose-extension' => 'Odaberite koju ekstenziju želite preuzeti:',
	'extdist-wc-empty' => 'U konfiguriranom radnom direktoriju za kopiranje nema ekstenzija za distribuciju!',
	'extdist-submit-extension' => 'Nastavi',
	'extdist-current-version' => 'Razvojna inačica (stablo)',
	'extdist-choose-version' => '<big>Preuzimate ekstenziju <b>$1</b>.</big> 

Izaberite vašu inačicu MedijaWikija.

Većina ekstenzija će raditi na više (ili svim) inačicama MedijaWikija, pa ako vaša inačica MedijaWikija nije ovdje, ili ako imate potrebu za najnovijim značajkama, pokušajte koristiti trenutnu inačicu.',
	'extdist-no-versions' => 'Odabrana ekstenzija ($1) nije dostupna u nijednoj inačici!',
	'extdist-submit-version' => 'Nastavi',
	'extdist-no-remote' => 'Ne mogu uspostaviti vezu s udaljenim SVN (subversion) klijentom.',
	'extdist-remote-error' => 'Pogrješka udaljenog SVN klijenta: <pre> $1 </pre>',
	'extdist-remote-invalid-response' => 'Neispravan odgovor od udaljenog SVN klijenta.',
	'extdist-svn-error' => 'SVN je naišao na pogrešku: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Nije moguće obraditi XML iz "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar je vratio izlazni kod $1:',
	'extdist-created' => 'Kreirana je snimka inačice <b>$2</b> ekstenzije <b>$1</b> MedijaWikija inačice <b>$3</b>. Vaše preuzimanje počinje za 5 sekundi.

URL snimke je:
:$4
Taj URL može biti rabljen za preuzimanje s poslužitelja, no molimo nemojte ga čuvati jer se sadržaj ne osvježava i moguće je njegovo brisanje s vremenom.

Tar arhivu trebalo bi raspakirati u vaš direktorij za ekstenzije. Na primjer, na unixoidnim operacijskim sustavima:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Na Windowsima možete rabiti [http://www.7-zip.org/ 7-zip] za raspakiravanje arhive.

Ukoliko je vaš wiki na udaljenom poslužitelju, raspakirajte datoteke u privremeni direktorij lokalno i potom ih sve snimite u direktorij za ekstenzije na poslužitelju.

Primijetite da neke ekstenzije trebaju datoteku ExtensionFunctions.php, koja se nalazi u direktoriju <tt>extensions/ExtensionFunctions.php</tt>, to jest u direktoriju iznad direktorija dotične ekstenzije.
Nemojte zaboraviti snimiti tu datoteku na poslužitelj.

Nakon što se raspakirali arhivu, potrebno je uključiti ekstenziju u LocalSettings.php datoteci. Dokumentacije ekstenzije opisuje taj postupak.

Ukoliko imate pitanja u svezi sustava distribucije ekstenzija, pogledajte ovu stranicu: [[Extension talk:ExtensionDistributor]].',
	'extdist-want-more' => 'Dohvati drugu ekstenziju',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'extensiondistributor' => 'Rožsěrjenje za MediaWiki sćahnyć',
	'extdist-desc' => 'Rozšěrjenje za rozdźělenje archiwow njejapkich fotow rozšěrjenjow',
	'extdist-not-configured' => 'Prošu konfiguruj $wgExtDistTarDir a $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Konfigurowany zapis dźěłoweje kopije njeeksistuje!',
	'extdist-no-such-extension' => 'Rozšěrjenje "$1" njeeksistuje',
	'extdist-no-such-version' => 'Rozšěrjenje "$1" we wersiji "$2" njeeksistuje.',
	'extdist-choose-extension' => 'Wubjer, kotre rozšěrjenje chceš sćahnyć:',
	'extdist-wc-empty' => 'Konfigurowany zapis dźěłoweje kopije nima rozdźělujomne rozšěrjenja!',
	'extdist-submit-extension' => 'Dale',
	'extdist-current-version' => 'Wuwićowa wersija (trunk)',
	'extdist-choose-version' => '<big>Sćahuješ rozšěrjenje <b>$1</b>.</big>

Wubjer swoju wersiju MediaWiki.

Najwjace rozšěrjenjow funguje přez wjacore wersije MediaWiki, jeli twoja wersija tuž tu njeje abo trjebaš najnowše funkcije rozšěrjenja, spytaj aktualnu wersiju wužiwać.',
	'extdist-no-versions' => 'Wubrane rozšěrjenje ($1) w žanej wersiji k dispoziciji njesteji!',
	'extdist-submit-version' => 'Dale',
	'extdist-no-remote' => 'Njeje móžno nazdalny klient Subversion kontaktować.',
	'extdist-remote-error' => 'Zmylk z nazdalneho klienta Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Njepłaćiwa wotmołwa nazdalneho klienta Subversion.',
	'extdist-svn-error' => 'Subversion je na zmylk storčił: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Njemóžno XML-daty wot "svn info" předźełać: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar je kod skónčenja $1 wróćił:',
	'extdist-created' => "Pakćik wersije <b>$2</b> rozšěrjenja <b>$1</b> wersije MediaWiki <b>$3</b> je so wutworił. Twoje sćehnjenje dyrbjało za 5 sekundow awtomatisce startować.

URL za tutón pakćik je:
:$4
Hodźi so za hnydomniše sćehnjenje do serwera wužiwać, prošu njeskładuj jón jako zapołožku, dokelž wobsah so njezaktualizuje a móhł so pozdźîso zničił.

Tar-archiw měł so do twojeho zapisa rozšěrjenjow wupakować, na přikład na uniksowym dźěłowym systemje:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Na Windowsu móžeš [http://www.7-zip.org/ 7-zip] wužiwać, zo by dataje wupakował.

Jeli twój wiki je na nazdalnym serwerje, wupakuj dataje do nachwilneho zapisa na swojim lokalnym ličaku a nahraj potom '''wšě''' wupakowane dataje do zapisa rozšěrjenjow na serwerje.

Dźiwaj na to, zo někotre rozšěrjenja trjebaja dataju z mjenom ExtensionFunctions.php, kotraž je na <tt>extensions/ExtensionFunctions.php</tt>, to rěka, w ''nadrjadowanym'' zapisu zapisa wotpowědneho rozšěrjenja. Pakćik za tute rozšěrjenja wobsahuje tutu dataju jako tar-bombu, wupakowana do ./ExtensionFunctions.php. Njezabudź tutu dataju na swój nazdalny serwer nahrać.

Po tym zo sy dataje wupakował, dyrbiš rozšěrjenje w dataji LocalSettings.php registrować. Dokumentacija rozšěrjenja dyrbjała instrukcije wobsahować, kak móžeš to činić.

Jeli maš prašenja wo systemje rozdźělowanja rozšěrjenjow, prošu dźi k [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Dalše rozšěrjenje wobstarać',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'extensiondistributor' => 'MediaWiki-kigészítők letöltése',
	'extdist-desc' => 'Kiegészítő kiegészítőcsomagok terjesztéséhez',
	'extdist-not-configured' => 'Kérlek állítsd be a $wgExtDistTarDir és a $wgExtDistWorkingCopy értékeit',
	'extdist-wc-missing' => 'A beállított másolat munkakönyvtár nem létezik!',
	'extdist-no-such-extension' => 'Nincs „$1” nevű kiegészítő',
	'extdist-no-such-version' => 'A(z) „$1” kiterjesztés nem létezik a(z) „$2” verzióban.',
	'extdist-choose-extension' => 'Válaszd ki, melyik kiterjesztést szeretnéd letölteni:',
	'extdist-wc-empty' => 'A beállított másolat munkakönyvtárban nincsenek terjeszthető kiterjesztések!',
	'extdist-submit-extension' => 'Folytatás',
	'extdist-current-version' => 'Fejlesztői verzió (trunk)',
	'extdist-choose-version' => '
<big>Éppen a(z) <b>$1</b> kiterjesztést töltöd le.</big>

Válaszd ki a MediaWiki verziót.

A legtöbb kiterjesztés működik a MediaWiki több verziójával, így ha az általad használt MediaWiki verzió nincs itt, vagy ha szükséged van a kiterjesztés legújabb funkcióira, próbáld az aktuális verziót használni.',
	'extdist-no-versions' => 'A választott kiterjesztés ($1) nem érhető el semmilyen verzióban!',
	'extdist-submit-version' => 'Folytatás',
	'extdist-no-remote' => 'Nem sikerült kapcsolódni a távoli Subversion klienshez.',
	'extdist-remote-error' => 'Hiba a távoli Subversion klienstől: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Érvénytelen válasz a távoli Subversion klienstől.',
	'extdist-svn-error' => 'A Subversion hibával tért vissza: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Az „svn info” által visszaadott XML-t nem sikerült feldolgozni: <pre>$1</pre>',
	'extdist-tar-error' => 'A tar által adott visszatérési kód $1:',
	'extdist-created' => "A(z) <b>$1</b> MediaWiki <b>$3</b> kiterjesztés <b>$2</b> verziójának pillanatfelvétele elkészült. A letöltés automatikusan megkezdődik 5 másodpercen belül.

A pillanatfelvétel URL-je:
:$4
Használható a szerverről való azonnali letöltésre, de kérlek ne tedd el a könyvjelzőid közé, mert a tartalma nem fog frissülni, és lehet hogy később törölve lesz.

A tar tömörítvényt a kiterjesztéseid könyvtárába kell kicsomagolni. Példa unix-szerű operációs rendszeren:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Windowson használhatod a [http://www.7-zip.org/ 7-zip]-et a fájlok kibontásához.

Ha a wikid egy távoli szerveren van, bontsd ki a fájlokat egy ideiglenes könyvtárba a helyi számítógépeden, majd tölds fel '''az összes''' kitömörített fájlt a szerver kiterjesztések könyvtárába.

Néhány kiterjesztésnek szüksége van egy ExtensionFunctions.php nevű fájlra, amelynek elérési útja: <tt>extensions/ExtensionFunctions.php</tt>, azaz az aktuális kiterjesztés ''szülő'' könyvtára. Ezeknek a kiterejsztéseknek a pillanatfelvétele tarbomb-ként tartalmazza ezt a fájlt, a ./ExtensionFunctions.php mappába kibontva. Ne felejtsd el feltölteni ezt a fájlt a távoli szerverre.

Miután kibontottad a fájlokat, regisztrálnod kell a kiterjesztést a LocalSettings.php-ben. Erről a kiterjesztés dokumentációjának kell bővebb útmutatást adnia.

Ha bármi kérdésed van a kiterjesztésterjesztő rendszerrel kapcsolatban, keresd fel az [[Extension talk:ExtensionDistributor]] lapot.",
	'extdist-want-more' => 'Másik kiterjesztés letöltése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'extensiondistributor' => 'Discargar extension MediaWiki',
	'extdist-desc' => 'Extension pro le distribution de archivos de instantaneos de extensiones',
	'extdist-not-configured' => 'Per favor configura $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Le directorio pro copias de travalio configurate non existe!',
	'extdist-no-such-extension' => 'Non existe un extension "$1"',
	'extdist-no-such-version' => 'Le extension "$1" non existe in le version "$2".',
	'extdist-choose-extension' => 'Selige le extension a discargar:',
	'extdist-wc-empty' => 'Le directorio pro copias de travalio configurate non ha extensiones distribuibile!',
	'extdist-submit-extension' => 'Continuar',
	'extdist-current-version' => 'Version de disveloppamento (trunco)',
	'extdist-choose-version' => '<big>Tu va discargar le extension <b>$1</b>.</big>

Per favor selige tu version de MediaWiki.

Le majoritate del extensiones functiona trans versiones de MediaWiki, ergo si tu version de MediaWiki non es presente, o si tu ha besonio del ultime functionalitate de extensiones, prova usar le version actual.',
	'extdist-no-versions' => 'Le extension seligite ($1) non es disponibile in alcun version!',
	'extdist-submit-version' => 'Continuar',
	'extdist-no-remote' => 'Non pote contactar le cliente Subversion remote.',
	'extdist-remote-error' => 'Error del cliente Subversion remote: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Responsa invalide del cliente Subversion remote.',
	'extdist-svn-error' => 'Subversion incontrava un error: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Non pote processar le formulario XML ab "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar retornava le codice de exito $1:',
	'extdist-created' => "Un instantaneo del version <b>\$2</b> del extension <b>\$1</b> pro MediaWiki <b>\$3</b> ha essite create.
Le discargamento debe comenciar automaticamente post 5 secundas.

Le adresse URL de iste instantaneo es:
:\$4
Es possibile usar iste adresse pro discargamento immediate verso un servitor, sed per favor non adde lo al lista de favoritos, post que le contento non essera actualisate, e illo pote esser delite plus tarde.

Le archivo tar debe esser extrahite in tu directorio de extensiones. Per exemplo, in un systema de operation de typo Unix:

<pre>
tar -xzf \$5 -C /var/www/mediawiki/extensions
</pre>

In Windows, tu pote usar [http://www.7-zip.org/ 7-zip] pro extraher le files.

Si tu wiki es situate in un servitor remote, extrahe le files in un directorio temporari in tu computator local, e postea carga '''tote''' le files extrahite verso le directorio de extensiones in le servitor.

Nota ben que alcun extensiones require un file con nomime ExtensionFunctions.php, situate a  <tt>extensions/ExtensionFunctions.php</tt>, isto es, in le directorio ''superior'' al directorio de iste extension particular. Le instantaneo pro iste extensiones contine iste file como un \"tarbomb\" que se extrahe in ./ExtensionFunctions.php. Non oblidar cargar iste file a tu servitor remote.

Quando tu ha extrahite le files, tu debe registrar le extension in LocalSettings.php. Le documentation del extension deberea continer instructiones super como facer lo.

Si tu ha alcun questiones super iste systema de distribution de extensiones, per favor visita [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Obtener un altere extension',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 */
$messages['id'] = array(
	'extensiondistributor' => 'Unduh pengaya MediaWiki',
	'extdist-desc' => 'Ekstensi untuk mendistribusikan arsip snapshot ekstensi',
	'extdist-not-configured' => 'Silakan mengkonfigurasi $wgExtDistTarDir dan $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Konfigurasi direktori Copy pekerjaan tidak ada!',
	'extdist-no-such-extension' => 'Tidak ada ekstensi "$1"',
	'extdist-no-such-version' => '

Ekstensi "$1" tidak ada dalam versi "$2".',
	'extdist-choose-extension' => '

Pilih ekstensi yang ingin Anda unduh:',
	'extdist-wc-empty' => 'Konfigurasi direktori salinan pekerjaan Anda tidak memiliki ekstensi yang harus didistibusikan!',
	'extdist-submit-extension' => 'Lanjutkan',
	'extdist-current-version' => 'Versi pengembangan (trunk)',
	'extdist-choose-version' => '<big>Anda mengunduh  <b>$1</b> ekstensi.</big>

Pilih versi MediaWiki anda.

Kebanyakan ekstensi bekerja di beberapa versi program MediaWiki, jadi jika versi MediaWiki Anda tidak ada di sini, atau jika Anda membutuhkan fitur ekstensi terbaru, coba gunakan versi terbaru.',
	'extdist-no-versions' => 'Ekstensi terpilih ($1) tidak tersedia di versi manapun!',
	'extdist-submit-version' => 'Lanjutkan',
	'extdist-no-remote' => 'Tidak dapat terhubung ke client subversio.',
	'extdist-remote-error' => 'Kesalahan dari subversion client: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'respon tidak sah dari subversion client.',
	'extdist-svn-error' => 'Subversion mengalami masalah: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Tidak dapat memproses XML dari "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar Mengembalikan kode keluar $1:',
	'extdist-created' => "Sebuah versi snapshot <b>$2</b> dari <b>$1</b> ekstensi untuk MediaWiki <b>$3</b> telah dibuat. Download anda akan dimulai secara otomatis dalam 5 detik. 

URL untuk snapshot ini adalah:  
:$4  
Ini dapat digunakan untuk men-download langsung ke server, tapi tolong jangan tandai itu, karena isinya tidak akan diupdate, dan dapat dihapus di kemudian hari. 

Arsip tar harus diekstrak ke direktori ekstensi anda. Sebagai contoh, pada sebuah OS unix-like:  

<pre>  
tar -xzf $5 -C /var/www/mediawiki/extensions  
</pre>  

Pada Windows, Anda dapat menggunakan [http://www.7-zip.org/ 7-zip] untuk mengekstrak file.  

Jika Wiki Anda di server jauh, ekstrak file ke direktori sementara pada komputer lokal Anda, dan kemudian meng-upload'' 'semua''' file  yang diekstrak ke direktori ekstensi pada server. 

Perhatikan bahwa beberapa ekstensi yang membutuhkan file yang bernama ExtensionFunctions.php, terletak di <tt>extensions/ExtensionFunctions.php</tt>, yaitu di''induk''direktori khusus ekstensi ini . Snapshot untuk perluasan ini berisi file ini sebagai tarbomb, diekstrak ke ./ExtensionFunctions.php. Jangan lalai untuk meng-upload file ini ke server jauh. 

Setelah Anda ekstrak file, Anda harus mendaftarkan ekstensi di LocalSettings.php. Dokumentasi exktensi harus mempunyai petunjuk tentang cara untuk melakukan ini. 

Jika Anda memiliki pertanyaan tentang sistem distribusi ekstensi ini, silakan ke [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => '

Dapatkan ekstensi lain',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author McDutchie
 * @author Melos
 */
$messages['it'] = array(
	'extensiondistributor' => 'Scarica estensione MediaWiki',
	'extdist-desc' => 'Estensione per distribuire archivi snapshot delle estensioni',
	'extdist-not-configured' => 'Configura $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'La directory per copie di lavoro configurata non esiste!',
	'extdist-no-such-extension' => 'Nessuna estensione "$1"',
	'extdist-no-such-version' => 'L\'estensione "$1" non esiste nella versione "$2".',
	'extdist-choose-extension' => 'Seleziona quale estensione intendi scaricare:',
	'extdist-wc-empty' => 'La directory per copie di lavoro configurata non contiene estensioni distribuibili!',
	'extdist-submit-extension' => 'Continua',
	'extdist-current-version' => 'Versione di sviluppo (trunk)',
	'extdist-choose-version' => "<big>Stai scaricando l'estensione <b>$1</b>.</big>

Seleziona la tua versione di MediaWiki.

Molte estensioni funzionano su più versioni di MediaWiki, quindi se la tua versione di MediaWiki non è qui o hai bisogno delle ultime funzioni dell'estensione, prova a usare la versione corrente.",
	'extdist-no-versions' => "L'estensione selezionata ($1) non è disponibile in alcuna versione!",
	'extdist-submit-version' => 'Continua',
	'extdist-no-remote' => 'Impossibile contattare il client subversion remoto.',
	'extdist-remote-error' => 'Errore dal client subversion remoto: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Risposta non valida dal client subversion remoto.',
	'extdist-svn-error' => 'Subversion ha incontrato un errore: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Impossibile elaborare l\'XML da "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar ha restituito il seguente exitcode $1:',
	'extdist-created' => "Un'istantanea della versione <b>$2</b> dell'estensione <b>$1</b> per MediaWiki <b>$3</b> è stata creata. Il tuo download dovrebbe partire automaticamente fra 5 secondi.

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
	'extdist-want-more' => "Prendi un'altra estensione",
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Marine-Blue
 */
$messages['ja'] = array(
	'extensiondistributor' => 'MediaWiki 拡張機能のダウンロード',
	'extdist-desc' => '拡張機能のスナップショットのアーカイブを配布するための拡張機能',
	'extdist-not-configured' => '$wgExtDistTarDirと$wgExtDistWorkingCopyの設定を行ってください',
	'extdist-wc-missing' => '指定されたコピー用ディレクトリが存在しません！',
	'extdist-no-such-extension' => '"$1"という拡張機能は存在しません',
	'extdist-no-such-version' => '拡張機能 "$1" に "$2" というバージョンは存在しません。',
	'extdist-choose-extension' => 'ダウンロードしたい拡張機能を選択してください:',
	'extdist-wc-empty' => '指定されたコピー先ディレクトリにダウンロードする拡張機能が存在しません！',
	'extdist-submit-extension' => '続行',
	'extdist-current-version' => '開発バージョン (trunk)',
	'extdist-choose-version' => '<big>拡張機能 <b>$1</b> をダウンロードしようとしています。</big>

あなたが利用しているMediaWikiのバージョンを選択してください。

多くの拡張機能は複数のバージョンで利用できますが、あなたの使用しているMediaWikiのバージョンが下記にない場合、最新版にアップデートする必要があります。',
	'extdist-no-versions' => '選択された拡張機能($1)は全てのバージョンで利用できません！',
	'extdist-submit-version' => '選択',
	'extdist-no-remote' => 'subversionクライアントと接続できませんでした。',
	'extdist-remote-error' => 'subversionクライアントがエラーを返しました: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'subversionクライアントが無効なレスポンスを返しました。',
	'extdist-svn-error' => 'Subversionでエラーが発生しました: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'XMLへの変換処理が正しく行われませんでした: <pre>$1</pre>',
	'extdist-tar-error' => 'tarが終了コード $1 を返しました:',
	'extdist-created' => "MediaWiki <b>$3</b> の拡張機能 <b>$1</b> バージョン <b>$2</b> のスナップショットが作成されました。5秒後、自動的にダウンロードが開始されます。

このスナップショットのURLは次の通りです:
:$4
今すぐダウンロードするようにして、このアドレスをブックマークしないようにしてください。コンテンツのアップデートに対応できません。また、ファイルは数日後に削除される可能性があります。

tar アーカイブは拡張機能ディレクトリに展開してください。Unix 系の OS では、例えば下記のようにします。

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Windows では [http://www.7-zip.org/ 7-zip] がアーカイブの展開に利用できます。

ウィキを遠隔サーバーに設置している場合、ローカル・コンピュータの一時ディレクトリにアーカイブを展開し、アーカイブに含まれていた'''全ての'''ファイルをサーバー上の拡張機能ディレクトリへアップロードしてください。

なお、いくつかの拡張機能は ExtensionFunctions.php というファイルを extensions/ExtensionFunctions.php、つまりこの拡張機能用ディレクトリの親ディレクトリに置く必要があります。このような拡張機能のスナップショットにはこのファイルが ''tarbomb'' として含まれていて、./ExtensionFunctions.php に展開します。このファイルを遠隔サーバーにアップロードするのを忘れないでください。

ファイルを全て展開したら、その拡張機能を LocalSettings.php へ登録する必要があります。具体的な作業手順は各拡張機能のドキュメントで解説されています。

この拡張機能の配布システムに何かご質問がある場合は、[[Extension talk:ExtensionDistributor]] でお尋ねください。",
	'extdist-want-more' => '他の拡張機能を入手',
);

/** Georgian (ქართული)
 * @author BRUTE
 */
$messages['ka'] = array(
	'extdist-submit-extension' => 'გაგრძელება',
	'extdist-submit-version' => 'გაგრძელება',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 */
$messages['km'] = array(
	'extensiondistributor' => 'ទាញយកផ្នែកបន្ថែមនៃមេឌាវិគី',
	'extdist-submit-extension' => 'បន្ត',
	'extdist-submit-version' => 'បន្ត',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'extensiondistributor' => '미디어위키 확장 기능 내려받기',
	'extdist-not-configured' => '$wgExtDistTarDir 과 $wgExtDistWorkingCopy를 설정하십시오.',
	'extdist-no-such-version' => '확장 기능 "$1"은 "$2" 버전용이 존재하지 않습니다.',
	'extdist-choose-extension' => '당신이 다운로드하기를 원하는 확장 기능을 선택하십시오:',
	'extdist-submit-extension' => '계속',
	'extdist-current-version' => '개발 중인 버전 (trunk)',
	'extdist-choose-version' => '
<big>당신은 <b>$1</b> 확장 기능을 다운로드하고 있습니다.</big>

당신의 미디어위키 버전을 선택하십시오.

대부분의 확장 기능은 미디어위키의 여러 버전에서도 동작합니다, 당신의 미디어위키 확장 기능이 여기 없거나 최신 버전이 필요하다면, 현재 버전 다운로드를 선택하십시오.',
	'extdist-submit-version' => '계속',
	'extdist-no-remote' => '외부 서브버전 클라이언트와 연결할 수 없습니다.',
	'extdist-remote-error' => '외부 서브버전 클라이언트에서 오류 발생: <pre>$1</pre>',
	'extdist-svn-error' => 'SVN에서 오류가 발생하렸습니다: <pre>$1</pre>',
	'extdist-created' => "미디어위키 확장 기능 <b>$1</b>의 <b>$2</b> 버전의 묶음 <b>$3</b> 이 생성되었습니다. 5초 후에 다운로드가 자동적으로 실행될 것입니다.

묶음의 URL은 다음에 있습니다:
:$4
이 URL은 서버에서 즉시 다운로드할 때 사용될 것입니다. 하지만 즐겨찾기에 추가하지는 마세요. 내용이 업데이트되지 않고, 나중에 이 URL은 삭제될 것입니다.

tar 압축 파일을 당신의 확장 기능 폴더에 압축을 푸십시오. 유닉스 계열의 운영 체제에서는:
<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>
을 이용하십시오.

윈도에서는 압축을 풀 때 [http://www.7-zip.org/ 7-zip]을 이용하실 수 있습니다.

만약 당신의 위키가 원격 서버에 있다면. 당신의 컴퓨터에 임시로 압축을 푼 뒤, 압축이 풀어진 '''모든''' 파일을 서버의 확장 기능 폴더에 올리십시오.

일부 확장 기능은<tt>extensions/ExtensionFunctions.php</tt>에 위치한 ExtensionFunctions.php라는 파일을 필요로 할 것입니다. 이 파일은 각각의 확장 기능 폴더의 상위 폴더에 위치하고 있습니다. 이러한 확장 기능의 묶음은 ./ExtensionFunctions.php에 압축이 풀리도록 이 파일을 포함하고 있습니다. 당신의 원격 서버에 이 파일을 올리는 것을 잊지 마십시오.

압축을 푼 후, 확장 기능을 LocalSettings.php에 등록해야 합니다. 확장 기능의 설명 문서가 어떻게 확장 기능을 등록하는 지에 대한 설명을 담고 있습니다.

이 확장 기능에 대해 어떤 질문이 있다면, [[Extension talk:ExtensionDistributor]] 문서를 방문해주십시오.",
	'extdist-want-more' => '다른 확장 기능 내려받기',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'extensiondistributor' => 'MediaWiki Zosatzprojramm erunger lade',
	'extdist-desc' => 'Zosazprojramm för Arschive met Zosazprojramme ze verteile.',
	'extdist-not-configured' => 'Bes esu joot un donn <code>$wgExtDistTarDir</code> un <code>$wgExtDistWorkingCopy</code> setze.',
	'extdist-wc-missing' => 'Dat Ärbeitsverzeischnes för de Kopije es nit do.',
	'extdist-no-such-extension' => 'Ene Zosatz „$1“ es nit do.',
	'extdist-no-such-version' => 'Ene Zosatz „$1“ es nit do, en de Version „$2“.',
	'extdist-choose-extension' => 'Sök Der us, wat för ene Zosatz De erunger lade wells:',
	'extdist-wc-empty' => 'En dämm Ärbeitsverzeischnes sin kein Zosätz dren, di mer verdeile künnte.',
	'extdist-submit-extension' => 'Wigger',
	'extdist-current-version' => 'De aktoelle Entwecklungs-Version (<i lang="en">trunk</i>)',
	'extdist-choose-version' => '<big>Do bes dä Zosatz <b>$1</b> am erunge lade.</big>

Sök Ding Version fun MediaWiki us.

De miißte Zosätz fungxjeneere met diverse Versione fun MediaWiki, alsu falls Ding Version nit dobei es, udder wann de Bedarref häß aan de neuste Müjjeleschkeite un Eijeschaffte, dann versök de aktoelle Version.',
	'extdist-no-versions' => 'Dä Zosatz „$1“ jitt et nit en alle Versione!',
	'extdist-submit-version' => 'Wigger',
	'extdist-no-remote' => 'Mer krijje keine Kontak zom <i lang="en">subversion (svn)</i> op däm andere Rääschner.',
	'extdist-remote-error' => 'Et <i lang="en">subversion (svn)</i> op däm andere Rääschner hät ene Fähler jefonge un jeschrevve: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Et <i lang="en">subversion (svn)</i> op däm andere Rääschner hät en Antwoot jejovve, met dä künne mer nix aanfange.',
	'extdist-svn-error' => 'Et <i lang="en">subversion (svn)</i> hät ene Fähler jefonge: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'De XML-Date fun <code lang="en">svn info</code> kunnte mer nit verärrbeide: <pre>$1</pre>',
	'extdist-tar-error' => 'Et Projramm <code lang="en">tar</code> jov uns der Beendijungskood $1:',
	'extdist-created' => "En Schnappschoß-Version fun dä Version <b>\$2</b> fun däm Zosatz „<b>\$1</b>“ för MediaWiki Version <b>\$3</b> eß aanjelaat woode. Et ErungerLade sull automattesch loß jonn, in fönnef Sekunde.

Dä URL för dä Schnappschoß es:
:\$4
Di Address is bloß för jetz jrad eronger ze lade jedaach. Donn se nit faßhallde. Der Datei ier Enhallt weed bahl övverhollt sin, un se weed och nit lang opjehovve.

En dä Datei es e <i lang=\"en\">tar</i>-Aschiif. Dat sullt en dat Verzeischnes met de MediaWiki-Zosätz ußjepack wäde. Med <i lang=\"en\">Unix</i> un äänlijje Bedriefß-Süsteme jeit dat en dä Aat:

<pre>
tar -xzf \$5 -C /var/www/mediawiki/extensions
</pre>

Med <i lang=\"en\">Windows</i>, kanns De [http://www.7-zip.org/ 7-zip] nämme.

Wann Ding Wiki nit op dämm Rääschner läuf, wo de di Aschif-Datei lijje häß, dann donn se en e Zwescheverzeichnis ußpacke, un dann donn '''jede''' usjepackte Datei un '''jedes''' usjepackte Verzeichnis op Dingem Wiki singe Server en et <code lang=\"en\">extensions</code>-Verzeichnis huhlade.

Paß op: Etlijje Zosätz bruche en Dattei mem Name <code>ExtensionFunctions.php</code> em Verzeischnes <tt>extensions/ExtensionFunctions.php</tt>, alsu em ''Bovver''verzeischnes fun dämm, wo däm Zosatz sing Projramme jewöhnlesch lijje. Dä Schnappschoß för esu en Zosätz enthällt di Dattei als e <code>tar</code>-Aschiif, noh <code>./ExtensionFunctions.php</code> ußjepack. Dengk draan, dat Dinge och huhzelaade.

Wan De mem Ußpacke (un velleich Huhlade) fadesch bes, do moß De dä Zosatz en  <code>LocalSettings.php</code> enndraare. De Dokementazjohn för dä Zosatz sät jenouer, wi dat em einzelne jeiht.

Wann De Frore övver dat Süßteem zom Zosätz erunger Lade haß, da jangk noh [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Noch ene Zosatz holle',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'extensiondistributor' => 'MediaWiki Erweiderung eroflueden',
	'extdist-desc' => "Erweiderung fir d'Verdeele vu Schnappschoss-Archive vun Erweiderungen",
	'extdist-not-configured' => 'Konfiguréiert w.e.g. $wgExtDistTarDir an $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Den agestallten Arbechts-Kopien-Repertoire gëtt et net!',
	'extdist-no-such-extension' => 'Et gëtt keng Erweiderung "$1"',
	'extdist-no-such-version' => 'D\'Erweiderung "$1" gëtt et net an der Versioun "$2".',
	'extdist-choose-extension' => 'Wielt wat fir eng Erweiderung Dir wëllt eroflueden:',
	'extdist-submit-extension' => 'Viru fueren',
	'extdist-current-version' => "Entwécklungs'versioun (trunk)",
	'extdist-choose-version' => "<big>Dir sidd amgaang d'<b>$1</b> Erweiderung erofzelueden.</big>

Wielt Är MediaWiki Versioun.

Déi meescht Erweiderunge fonctionnéiere mat verschiddene Versioune vu MediaWiki, wann Är Versioun vu MediaWiki net hei steet, oder wann der déi neiste Fonctioune vun den Erweiderunge braucht, da versicht déi neiste Versioun ze benotzen.",
	'extdist-no-versions' => 'Déi gewielten Erweiderung ($1) ass a kenger Versioun disponibel!',
	'extdist-submit-version' => 'Viru fueren',
	'extdist-svn-parse-error' => 'XML\'en vun "svn info" kënnen net verschafft ginn: <pre>$1</pre>',
	'extdist-want-more' => 'Eng aner Erweiderung benotzen',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'extensiondistributor' => 'Download MediaWiki extension',
	'extdist-desc' => 'Extension veur distributere snapshot archieve óf extensions',
	'extdist-not-configured' => 'Maak de instellinge veur $wgExtDistTarDir en $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'De instelde werkmap besteit neet!',
	'extdist-no-such-extension' => 'De uitbreiding "$1" besteit neet',
	'extdist-no-such-version' => 'De oetbreiing "$1" besteit neet in de versie "$2".',
	'extdist-choose-extension' => 'Selekteer de extensie dae se wils downloade:',
	'extdist-wc-empty' => 'De ingestelde werkmap bevat gein te distributere extensies!',
	'extdist-submit-extension' => 'Doorgaon',
	'extdist-current-version' => 'Óntwikkelverzje (trunk)',
	'extdist-choose-version' => '<big>De bös de uitbreiding <b>$1</b> aan t downloade.</big>

Selecteer de versie van MediaWiki.

De meiste uitbreidinge werke met meerdere versies van MediaWiki, dus as de versie neet in de lies steit, of as se behoefte höbs aan de nieuwste meugelikhede van de uitbreidinge, gebroek den de hujige versie.',
	'extdist-no-versions' => 'De geselecteerde uitbreiding ($1) is in gein enkele versie besjikbaar!',
	'extdist-submit-version' => 'Doorgaon',
	'extdist-no-remote' => 't Waas neet meugelik de externe subversionclient te benadere',
	'extdist-remote-error' => 'Fout van de externe subversionclient: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ongeldig antwoord van de externe subversionclient.',
	'extdist-svn-error' => 'Subversion göf de volgende foutmelding: <pre>$1</pre>',
	'extdist-svn-parse-error' => '\'t Waas neet meugelik de XML van "svn info" te verwerke: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar goof de volgende exitcode $1:',
	'extdist-created' => 'De snapshot voor versie <b>$2</b> voor de uitbreiding <b>$1</b> voor MediaWiki <b>$3</b> is aangemaakt. Uw download start automatisch over 5 seconden.

De URL voor de snapshot is:
:$4
Deze verwijzing kan gebruikt worden door het direct downloaden van de server, maar maak geen bladwijzers aan, omdat de inhoud bijgewerkt kan worden, of de snapshot op een later moment verwijderd kan worden.

Pak het tararchief uit in uw map "extensions/". Op een UNIX-achtig besturingssysteem gaat dat als volgt:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Op Windows kunt u [http://www.7-zip.org/ 7-zip] gebruiken om de bestanden uit te pakken.

Als uw wiki op een op afstand beheerde server staat, pak de bestanden dan uit in een tijdelijke map op uw computer. Upload daarna \'\'\'alle\'\'\' uitgepakte bestanden naar de map "extensions/" op de server.

Een aantal uitbreidingen hebben het bestand ExtensionFunctions.php nodig, <tt>extensions/ExtensionFunctions.php</tt>, dat in de map direct boven de map met de naam van de uitbreiding hoort te staan. De snapshots voor deze uitbreidingen bevatten dit bestand als tarbomb. Het wordt uitgepakt als ./ExtensionFunctions.php. Vergeet dit bestand niet te uploaden naar uw server.

Nadat u de bestanden hebt uitgepakt en op de juiste plaatst hebt neergezet, moet u de uitbreiding registreren in LocalSettings.php. In de documentatie van de uitbreiding treft u de instructies aan.

Als u vragen hebt over dit distributiesysteem voor uitbreidingen, ga dan naar [[Extension talk:ExtensionDistributor]].',
	'extdist-want-more' => "Nag 'n uitbreiding downloade",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'extensiondistributor' => 'Преземи го проширувањето за MediaWiki',
	'extdist-desc' => 'Проширување за дистрибуција на приказни архиви на проширувања',
	'extdist-not-configured' => 'Задајте $wgExtDistTarDir и $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Зададениот директориум со работниот примерок не постои!',
	'extdist-no-such-extension' => 'Нема проширување со име „$1“',
	'extdist-no-such-version' => 'Проширувањето „$1“ не постои во верзијата „$2“.',
	'extdist-choose-extension' => 'Одберете го проширувањето коешто сакате да го преземете',
	'extdist-wc-empty' => 'Зададениот директориум со работниот примерок нема дистрибутивни проширувања!',
	'extdist-submit-extension' => 'Продолжи',
	'extdist-current-version' => 'Развојна верзија (trunk)',
	'extdist-choose-version' => '<big>Го преземате проширувањето <b>$1</b>.</big>

Изберете ја вашата верзија на MediaWiki.

Највеќето проширувања работат на многу верзии на MediaWiki, така што ако вашата MediaWiki ја нема, или пак ако имате потреба од можностите во најновото проширување, тогаш пробајте ја последната верзија.',
	'extdist-no-versions' => 'Избраното проширување ($1) не е достапно во ниту една верзија!',
	'extdist-submit-version' => 'Продолжи',
	'extdist-no-remote' => 'Не можам да го контактирам оддалечениот Subversion клиент.',
	'extdist-remote-error' => 'Грешка од оддалечениот Subversion клиент: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Грешен одговор  од оддалечениот Subversion клиент.',
	'extdist-svn-error' => 'Настана грешка во Subversion: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Грешка при обработката на XML од „svn info“: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar го даде кодот на грешката $1:',
	'extdist-created' => "Направена е снимка од верзијата <b>$2</b> на проширувањето <b>$1</b> за MediaWiki <b>$3</b>. Преземањето треба да започне автоматски за 5 секунди.  URL-адресата за оваа снимка е:
:$4
Може да се користи за моментално симнување на опслужувач, но ве молиме да не правите прибелешка за него, бидејќи содржината нема да се обновува, а подоцна може да биде избришана.

Tar податотеката треба да ја распакувате во именикот за проширувања. На пример, на ОС од типот на unix:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Во Windows за таа намена можете да го употребите [http://www.7-zip.org/ 7-zip].

Ако вашето вики е на оддалечен сервер, отпакувајте ги податотеките во привремен именик на вашиот локален компјутер, а потоа подигнете ги '''сите''' отпакувани податотеки во именикот за проширувања на опслужувачот.

Имајте на ум дека некои проширувања бараат податотека наречена ExtensionFunctions.php, која ќе ја најдете на <tt>extensions/ExtensionFunctions.php</tt>, т.е., во ''родителскиот'' именик на именикот на ова конкретно проширување. Снимката за овие проширувања ја содржи оваа податотека како tar-бомба, која се распакува во ./ExtensionFunctions.php. Немојте да испуштите да ја подигнете оваа податотека на вашиот оддалечен опслужувач.

Откако ќе ги распакувате податотеките, ќе треба да го регистрирате проширувањето во LocalSettings.php. Документацијата на проширувањето треба да има инструкции за оваа постапка.

Доколку имате прашања за овој дистрибутивен систем на проширувања, обратете се на страницата [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Преземи друго проширување',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'extensiondistributor' => 'മീഡിയവിക്കി അനുബന്ധം ഡൗൺലോഡ് ചെയ്യുക',
	'extdist-desc' => 'അനുബന്ധങ്ങളുടെ തത്സമയ സഞ്ചയങ്ങൾ വിതരണം ചെയ്യാനുള്ള അനുബന്ധം',
	'extdist-not-configured' => 'ദയവായി $wgExtDistTarDir, $wgExtDistWorkingCopy എന്നിവ ക്രമീകരിക്കുക',
	'extdist-wc-missing' => 'പ്രവർത്തനം പകർത്താനായി ക്രമീകരിക്കപ്പെട്ട ഡയറക്റ്ററി നിലവിലില്ല!',
	'extdist-no-such-extension' => '"$1" എന്നൊരു അനുബന്ധം ഇല്ല',
	'extdist-no-such-version' => '"$2" പതിപ്പിൽ "$1" എന്നൊരു അനുബന്ധം ഇല്ല.',
	'extdist-choose-extension' => 'താങ്കൾക്ക് ഡൗൺലോഡ് ചെയ്യേണ്ട അനുബന്ധം തിരഞ്ഞെടുക്കുക:',
	'extdist-wc-empty' => 'പ്രവർത്തനം പകർത്താനായി ക്രമീകരിക്കപ്പെട്ട ഡയറക്റ്ററിയിൽ വിതരണം ചെയ്യാവുന്ന അനുബന്ധങ്ങളൊന്നും ഇല്ല!',
	'extdist-submit-extension' => 'തുടരുക',
	'extdist-current-version' => 'വികസനഘട്ടത്തിലുള്ള പതിപ്പ് (ട്രങ്ക്)',
	'extdist-choose-version' => '<big>താങ്കൾ <b>$1</b> എന്ന അനുബന്ധം ഡൗൺലോഡ് ചെയ്യുകയാണ്.</big>

താങ്കളുടെ മീഡിയവിക്കി പതിപ്പ് തിരഞ്ഞെടുക്കുക.

ബഹുഭൂരിപക്ഷം അനുബന്ധങ്ങളും മീഡിയവിക്കിയുടെ വിവിധ പതിപ്പുകളിൽ ഒരേപോലെ പ്രവർത്തിക്കാൻ പ്രാപ്തമാണ്, അതുകൊണ്ട് മീഡിയവിക്കി പതിപ്പ് ഇല്ലെങ്കിൽ, അല്ലെങ്കിൽ ഏറ്റവും പുതിയ അനുബന്ധ സവിശേഷതകളാണ് താങ്കൾക്ക് വേണ്ടതെങ്കിൽ, ഇപ്പോഴത്തെ പതിപ്പ് പരീക്ഷിക്കുക.',
	'extdist-no-versions' => 'തിരഞ്ഞെടുത്ത അനുബന്ധം ($1) ഒരു പതിപ്പിലും ലഭ്യമല്ല!',
	'extdist-submit-version' => 'തുടരുക',
	'extdist-no-remote' => 'വിദൂര സ‌ബ്‌‌വേർഷൻ ക്ലയന്റുമായി ബന്ധപ്പെടാൻ കഴിഞ്ഞില്ല.',
	'extdist-remote-error' => 'വിദൂര സബ്‌‌വേർഷൻ ക്ലയന്റിൽ നിന്നുണ്ടായ പിഴവ്: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'വിദൂര സബ്‌‌വേർഷൻ ക്ലയന്റ് അസാധുവായ പ്രതികരണമാണ് നൽകിയത്.',
	'extdist-svn-error' => 'സബ്‌‌വേർഷൻ ഒരു പിഴവ് അഭിമുഖീകരിക്കുന്നു: <pre>$1</pre>',
	'extdist-svn-parse-error' => '"svn info" തന്ന എക്സ്.എം.എൽ. ഉപയോഗിക്കാൻ കഴിയില്ല: <pre>$1</pre>',
	'extdist-tar-error' => 'ടാർ എക്സിറ്റ് കോഡ് $1 തിരിച്ചയച്ചിരിക്കുന്നു:',
	'extdist-created' => 'മീഡിയവിക്കി <b>$3</b> ഉപയോഗിക്കുന്ന <b>$1</b> അനുബന്ധത്തിന്റെ തത്സമയ പതിപ്പ് <b>$2</b> സൃഷ്ടിച്ചിരിക്കുന്നു. താങ്കളുടെ ഡൗൺലോഡ് 5 സെക്കന്റുകൾക്കുള്ളിൽ സ്വയം തുടങ്ങുന്നതാണ്.

ഈ തത്സമയ ശേഖരണത്തിന്റെ യൂ.ആർ.എൽ.:
:$4
ഇത് ഒരു സെർവറിലേയ്ക്കുള്ള ഡൗൺലോഡിന് ഇപ്പോൾ തന്നെ ഉപയോഗിക്കാവുന്നതാണ്, പക്ഷേ ദയവായി ഇത് ബുൿമാർക്ക് ചെയ്ത് വെയ്ക്കാതിരിക്കുക, ഉള്ളടക്കം പുതുക്കാതാകുമ്പോൾ പിന്നീടൊരിക്കൽ ഇത് നീക്കം ചെയ്യപ്പെട്ടേക്കാം.

ടാർ സഞ്ചയിക താങ്കളുടെ അനുബന്ധങ്ങളുടെ ഡയറക്റ്ററിയിലേയ്ക്ക് എക്സ്ട്രാക്റ്റ് ചെയ്യാവുന്നതാണ്. ഉദാഹരണത്തിന്, യുണിക്സ് സമാന ഓ.എസ്സിൽ:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>
എന്നുപയോഗിക്കുക.

വിൻഡോസിൽ, പ്രമാണങ്ങൾ എക്സ്ട്രാക്റ്റ് ചെയ്യാൻ [http://www.7-zip.org/ 7-സിപ്] ഉപയോഗിക്കാം.

താങ്കളുടെ വിക്കി ഒരു വിദൂര സെ‌‌ർവറിലാണെങ്കിൽ, താങ്കളുടെ കൈയിലെ കമ്പ്യൂട്ടറിലെ താത്കാലിക ഡയറക്റ്ററിയിലേയ്ക്ക് പ്രമാണങ്ങൾ എക്സ്ട്രാക്റ്റ് ചെയ്ത ശേഷം, അവ എല്ലാം സെർവറിലെ അനുബന്ധങ്ങൾക്കുള്ള ഡയറക്റ്ററിയിലേയ്ക്ക് അപ്‌‌ലോഡ് ചെയ്ത് നൽകുക.

ചില അനുബന്ധങ്ങൾക്ക് അനുബന്ധങ്ങൾക്കായുള്ള ഒരു പ്രത്യേക ഡയറക്റ്ററിയുടെ മാതൃ ഡയറക്റ്ററിയായ <tt>extensions/ExtensionFunctions.php</tt> എന്നതിലെ  ExtensionFunctions.php എന്ന പ്രമാണം ആവശ്യമാണെന്നോർക്കുക,  അനുബന്ധങ്ങളുടെ തത്സമയ രൂപങ്ങളിൽ ഈ പ്രമാണം ടാർബോംബ് ആയി ഉണ്ടായിരിക്കും, ./ExtensionFunctions.php ആയിട്ടായിരിക്കും എക്സ്‌‌ട്രാക്റ്റ് ചെയ്യപ്പെടുക. ഈ പ്രമാണം വിദൂര സെ‌‌ർവറിലേയ്ക്ക് അപ്‌‌ലോഡ് ചെയ്യുമ്പോൾ അവഗണിക്കാതിരിക്കുക.

പ്രമാണങ്ങൾ എക്സ്ട്രാക്റ്റ് ചെയ്ത ശേഷം, അവ LocalSettings.php എന്ന പ്രമാണത്തിൽ അടയാളപ്പെടുത്തേണ്ടതുണ്ട്. അനുബന്ധത്തിന്റെ സഹായത്തിൽ ഇതെങ്ങനെ ചെയ്യാമെന്ന് നൽകിയിട്ടുണ്ടായിരിക്കും.

ഈ അനുബന്ധ വിതരണ സംവിധാനത്തെ കുറിച്ച് എന്തെങ്കിലും ചോദ്യങ്ങൾ താങ്കൾക്കുണ്ടെങ്കിൽ, ദയവായി [[Extension talk:ExtensionDistributor]] പരിശോധിക്കുക.',
	'extdist-want-more' => 'മറ്റൊരു അനുബന്ധം നേടുക',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 * @author Aviator
 */
$messages['ms'] = array(
	'extensiondistributor' => 'Muat turun penyambung MediaWiki',
	'extdist-desc' => 'Penyambung khas untuk pengedaran arkib petikan penyambung',
	'extdist-not-configured' => 'Sila tetapkan konfigurasi $wgExtDistTarDir dan $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Direktori salinan kerja yang ditetapkan tidak wujud!',
	'extdist-no-such-extension' => 'Penyambung "$1" tidak wujud',
	'extdist-no-such-version' => 'Penyambung "$1" tidak mempunyai versi "$2".',
	'extdist-choose-extension' => 'Sila pilih penyambung yang ingin dimuat turun:',
	'extdist-wc-empty' => 'Direktori salinan kerja yang ditetapkan tidak mengandungi sebarang penyambung boleh edar!',
	'extdist-submit-extension' => 'Teruskan',
	'extdist-current-version' => 'Versi pembangunan (utama)',
	'extdist-choose-version' => '<big>Anda sedang memuat turun penyambung <b>$1</b>.</big>

Sila pilih versi MediaWiki anda.

Kebanyakan penyambung boleh digunakan dalam pelbagai versi MediaWiki. Oleh itu, jika versi MediaWiki anda tiada di sini, atau anda memerlukan penyambung dengan ciri-ciri terkini, anda boleh memilih untuk menggunakan versi semasa.',
	'extdist-no-versions' => 'Penyambung yang dipilih ($1) tiada dalam sebarang versi!',
	'extdist-submit-version' => 'Teruskan',
	'extdist-no-remote' => 'Pelanggan subversion jauh tidak dapat dihubungi.',
	'extdist-remote-error' => 'Ralat daripada pelanggan subversion jauh: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Jawapan tidak sah daripada pelanggan subversion jauh.',
	'extdist-svn-error' => 'Subversion mendapati ralat: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Tidak dapat memproses XML daripada "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar memulangkan kod keluar $1:',
	'extdist-created' => "Sebuah petikan bagi penyambung <b>$1</b> versi <b>$2</b> untuk MediaWiki <b>$3</b> telah dicipta. Proses muat turun akan dimulakan secara automatik dalam masa 5 saat.

URL untuk petikan ini ialah:
:$4
Alamat ini boleh digunakan untuk memuat turun ke dalam pelayan anda dengan segera. Akan tetapi, jangan tanda alamat ini kerana kandungannya tidak akan dikemaskinikan, dan kelak mungkin akan dihapuskan balik.

Arkib tar yang dimuat turun perlu dikeluarkan ke dalam direktori extensions anda. Sebagai contoh, untuk sistem pengendalian ala UNIX:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Untuk Windows pula, anda boleh menggunakan perisian [http://www.7-zip.org/ 7-zip] untuk mengeluarkan fail-fail yang berkenaan.

Sekiranya wiki anda terdapat dalam pelayan jauh, sila keluarkan fail-fail yang berkenaan ke dalam direktori sementara dalam komputer tempatan anda, kemudian muat naik '''semua''' fail yang telah dikeluarkan ke dalam direktori extensions dalam komputer pelayan.

Sesetengah penyambung memerlukan sebuah fail bernama ExtensionFunctions.php yang terletak di <tt>extensions/ExtensionFunctions.php</tt>, iaitu dalam direktori ''induk'' bagi direktori penyambung ini. Petikan bagi penyambung-penyambung ini mengandugi fail ini sebagai arkib tar, yang telah dikeluarkan ke dalam ./ExtensionFunctions.php. Jangan lupa untuk memuat naik fail ini ke dalam komputer jauh anda.

Selepas anda mengeluarkan fail-fail yang berkenaan, anda perlu mendaftarkan penyambung tersebut dalam LocalSettings.php. Anda boleh mendapatkan arahan untuk melakukan pendaftaran ini dengan merujuk dokumentasi yang disertakan dengan penyambung tersebut.

Sekiranya anda mempunyai sebarang soalan mengenai sistem pengedaran penyambung ini, sila kunjungi [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Dapatkan penyambung lagi',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'extdist-submit-extension' => 'Поладомс',
	'extdist-submit-version' => 'Поладомс',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'extensiondistributor' => 'MediaWiki-Extension dalladen',
	'extdist-desc' => 'Extension för dat Bereidstellen vun Snappschuss-Archiven von Extensions',
	'extdist-not-configured' => 'Stell $wgExtDistTarDir un $wgExtDistWorkingCopy in',
	'extdist-wc-missing' => 'De instellt Warkmapp för Kopien gifft dat gornich!',
	'extdist-no-such-extension' => 'Extension „$1“ gifft dat nich',
	'extdist-no-such-version' => 'De Extension „$1“ gifft dat nich in de Version „$2“.',
	'extdist-choose-extension' => 'Wähl de Extension ut, de du dalladen wullt:',
	'extdist-wc-empty' => 'In de instellt Warkmapp för Kopien sünd keen Extensions in!',
	'extdist-submit-extension' => 'Wiedermaken',
	'extdist-current-version' => 'Ne’este instabile Version (trunk)',
	'extdist-choose-version' => '<big>Du laadst de <b>$1</b>-Extension dal.</big>

Wähl dien MediaWiki-Version ut.

En groten Deel vun de Extensions arbeidt mit vele MediaWiki-Versionen. Wenn dien MediaWiki-Version hier nich opdükert oder du de ne’esten KNeep vun de Extension bruken wullt, denn versöök de aktuelle Version to bruken.',
	'extdist-no-versions' => 'De utwählte Extension ($1) is in keen Version verföögbor!',
	'extdist-submit-version' => 'Wiedermaken',
	'extdist-no-remote' => 'De feernstüürte Subversion-Client mellt sik nich.',
	'extdist-remote-error' => 'Fehler vun’n feernstüürt Subversion-Client: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ungüllige Antwoord vun’n feernstüürt Subversion-Client.',
	'extdist-svn-error' => 'Subversion hett en Fehler mellt: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'XML-Daten von „svn info“ kunnen nich verarbeidt warrn: <pre>$1</pre>',
	'extdist-tar-error' => 'Dat Tar-Programm mellt den Enn-Kood $1:',
	'extdist-created' => "En Snappschuss vun de Version <b>$2</b> vun de MediaWiki-Extension <b>$1</b> is opstellt worrn (MediaWiki-Version <b>$3</b>). Dat Dalladen geit automaatsch los in 5 Sekunnen.

De URL för den Snappschuss is:
:$4
De URL is blot för dat Dalladen nu glieks dacht, spieker ehr nich as Leesteken af, de Datei warrt nich opfrischt un kann later ganz wegdaan warrn.

Dat Tar-Archiv schull in de Extension-Mapp utpackt warrn. Op en Unix-achtig Bedrievssystem mit:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Ünner Windows kannst du dat Programm [http://www.7-zip.org/ 7-zip] för dat Utpacken vun de Datein bruken.

Wenn dien Wiki op en vun feern bedeenten Server löppt, pack de Datein in en temporäre Mapp op dien lokalen Reekner ut un laad denn '''all''' utpackte Datein op den Server hooch.

Acht dor op, dat welk Extensions de Datei <tt>ExtensionFunctions.php</tt> bruukt. De liggt ünner <tt>extensions/ExtensionFunctions.php</tt>, de Hööfdmapp för de Extensions. Bi den Snappschuss vun disse Extension is disse Datei ok as tarbomb bi, utpackt na <tt>./ExtensionFunctions.php</tt>. Vergeet nich, ok disse Datei op dien Server hoochtoladen.

Nadem du de Datein utpackt hest, musst du de Extension in de <tt>LocalSettings.php</tt> registreren. In de Doku för de Extension schull dor wat to stahn.

Wenn du Fragen to dit Extensions-Verdeel-System hest, gah man na de Sied [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'En annere Extension kriegen.',
);

/** Dutch (Nederlands)
 * @author Naudefj
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'extensiondistributor' => 'MediaWiki-uitbreiding downloaden',
	'extdist-desc' => 'Uitbreiding voor het distribueren van uitbreidingen',
	'extdist-not-configured' => 'Maak de instellingen voor $wgExtDistTarDir en $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'De instelde werkmap bestaat niet!',
	'extdist-no-such-extension' => 'De uitbreiding "$1" bestaat niet',
	'extdist-no-such-version' => 'De uitbreiding "$1" bestaat niet in de versie "$2".',
	'extdist-choose-extension' => 'Selecteer de uitbreiding die u wilt downloaden:',
	'extdist-wc-empty' => 'De ingestelde werkmap bevat geen te distribueren uitbreidingen!',
	'extdist-submit-extension' => 'Doorgaan',
	'extdist-current-version' => 'Ontwikkelversie (trunk)',
	'extdist-choose-version' => '<big>U bent de uitbreiding <b>$1</b> aan het downloaden.</big>

Selecteer uw versie van MediaWiki.

De meeste uitbreidingen werken met meerdere versies van MediaWiki, dus als uw versie niet in de lijst staat, of als u behoefte hebt aan de nieuwste mogelijkheden van de uitbreidingen, gebruik dan de huidige versie.',
	'extdist-no-versions' => 'De geselecteerde uitbreiding ($1) is in geen enkele versie beschikbaar!',
	'extdist-submit-version' => 'Doorgaan',
	'extdist-no-remote' => 'Het was niet mogelijk de externe subversionclient te benaderen.',
	'extdist-remote-error' => 'Fout van de externe subversionclient: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ongeldig antwoord van de externe subversionclient.',
	'extdist-svn-error' => 'Subversion geeft de volgende foutmelding: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Het was niet mogelijk de XML van "svn info" te verwerken: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar gaf de volgende exitcode $1:',
	'extdist-created' => 'De snapshot voor versie <b>$2</b> voor de uitbreiding <b>$1</b> voor MediaWiki <b>$3</b> is aangemaakt. Uw download start automatisch over 5 seconden.

De URL voor de snapshot is:
:$4
Deze verwijzing kan gebruikt worden door het direct downloaden van de server, maar maak geen bladwijzers aan, omdat de inhoud bijgewerkt kan worden, of de snapshot op een later moment verwijderd kan worden.

Pak het tararchief uit in uw map "extensions/". Op een UNIX-achtig besturingssysteem gaat dat als volgt:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Op Windows kunt u [http://www.7-zip.org/ 7-zip] gebruiken om de bestanden uit te pakken.

Als uw wiki op een op afstand beheerde server staat, pak de bestanden dan uit in een tijdelijke map op uw computer. Upload daarna \'\'\'alle\'\'\' uitgepakte bestanden naar de map "extensions/" op de server.

Een aantal uitbreidingen hebben het bestand ExtensionFunctions.php nodig, <tt>extensions/ExtensionFunctions.php</tt>, dat in de map direct boven de map met de naam van de uitbreiding hoort te staan. De snapshots voor deze uitbreidingen bevatten dit bestand als tarbomb. Het wordt uitgepakt als ./ExtensionFunctions.php. Vergeet dit bestand niet te uploaden naar uw server.

Nadat u de bestanden hebt uitgepakt en op de juiste plaatst hebt neergezet, moet u de uitbreiding registreren in LocalSettings.php. In de documentatie van de uitbreiding treft u de instructies aan.

Als u vragen hebt over dit distributiesysteem voor uitbreidingen, ga dan naar [[Extension talk:ExtensionDistributor]].',
	'extdist-want-more' => 'Nog een uitbreiding downloaden',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'extensiondistributor' => 'Last ned utvidingar til MediaWiki',
	'extdist-desc' => 'Utviding for distribuering av andre utvidingar',
	'extdist-not-configured' => 'Still inn $wgExtDistTarDir og $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Mappa med arbeidskopien finst ikkje!',
	'extdist-no-such-extension' => 'Inga utviding med namnet "$1"',
	'extdist-no-such-version' => 'Versjon «$2» av «$1» finst ikkje',
	'extdist-choose-extension' => 'Vel kva utviding du ønskjer å lasta ned:',
	'extdist-wc-empty' => 'Mappa med arbeidskopien har ingen utvidingar som kan bli distribuerte.',
	'extdist-submit-extension' => 'Hald fram',
	'extdist-current-version' => 'Utviklingsverjson (trunk)',
	'extdist-choose-version' => '<big>Du lastar ned utvidinga <b>$1</b>.</big>

Oppgje kva MediaWiki-versjon du nyttar.

Dei fleste utvidingane fungerer på fleire versjonar av MediaWiki, so om versjonen du nyttar ikkje er lista opp her, eller om du har bruk for dei siste utvidingseigenskapane, kan du prøva å nytta den noverande versjonen.',
	'extdist-no-versions' => 'Den valte utvidinga ($1) er ikkje tilgjengeleg i nokon versjon!',
	'extdist-submit-version' => 'Hald fram',
	'extdist-no-remote' => 'Kunne ikkje kontakta ekstern SVN-klient.',
	'extdist-remote-error' => 'Feil frå ekstern SVN-klient: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ugyldig svar frå ekstern SVN-klient.',
	'extdist-svn-error' => 'SVN fann ein feil: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Kunne ikkje handsama XML frå "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar returnerte utgangskoden $1:',
	'extdist-created' => "Eit snøggskot av versjon <b>$2</b> av utvidinga <b>$1</b> for MediaWiki <b>$3</b> er blitt oppretta. Nedlastinga vil starta automatisk om fem&nbsp;sekund.

Adressa til snøggskotet er:
:$4
Adressa kan bli brukt for nedlasting til tenaren, men ikkje legg ho til som bokmerke, for innhaldet vil ikkje bli oppdatert, og ho kan bli sletta seinare.

Tar-arkivet burde bli pakka ut i utvidingsmappa di; til dømes på eit Unix-liknande operativsystem:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

På Windows kan du nytta [http://www.7-zip.org/ 7-zip] for å pakka ut filene.

Om wikien din er på ein ekstern tenar, pakk ut filene i ei midlertidig mappa på datamaskinen din, og last opp '''alle''' utpakka filer i utvidingsmappa på tenaren.

Merk at nokre utvidingar treng ei fil med namnet ExtensionFunctions.php, i mappa <tt>extensions/ExtensionFunctions.php</tt>, altso i ''foreldremappa'' til den enkelte utvidinga si mappa. Snøggskotet for desse utvidingane inneheld denne fila som ein ''tarbomb'' som blir pakka ut til ./ExtensionFunctions.php. Ikkje gløym å lasta opp denne fila til den eksterne tenaren.

Etter å ha pakka ut filene må du registrera utvidinga i LocalSettings.php. Dokumentasjonen til utvidinga burde ha instruksjonar på korleis ein gjer dette.

Om du har spørsmål om dette distribusjonssytemet for utvidingar, gå til [http://www.mediawiki.org/wiki/Extension_talk:ExtensionDistributor Extension talk:ExtensionDistributor].",
	'extdist-want-more' => 'Hent fleire utvidingar',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author EivindJ
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'extensiondistributor' => 'Last ned utvidelser til MediaWiki',
	'extdist-desc' => 'Utvidelse for distribusjon av andre utvidelser',
	'extdist-not-configured' => 'Still inn $wgExtDistTarDir og $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Mappen med arbeidskopien finnes ikke.',
	'extdist-no-such-extension' => 'Ingen utvidelse ved navn «$1»',
	'extdist-no-such-version' => 'Versjon «$2» av «$1» finnes ikke',
	'extdist-choose-extension' => 'Velg hvilken utvidelse du ønsker å laste ned:',
	'extdist-wc-empty' => 'Mappen med arbeidskopien har ingen distribuerbare utvidelser.',
	'extdist-submit-extension' => 'Fortsett',
	'extdist-current-version' => 'Utviklingsversjon (trunk)',
	'extdist-choose-version' => '<big>Du laster ned utvidelsen <b>$1</b>.</big>

Angi hvilken MediaWiki-versjon du bruker.

De fleste utvidelser fungerer på flere versjoner av MediaWiki, så om versjonen du bruker ikke listes opp her, kan du prøve å velge den nyeste versjonen.',
	'extdist-no-versions' => 'Den valgte utvidelsen ($1) er ikke tilgjengelig i noen versjon.',
	'extdist-submit-version' => 'Fortsett',
	'extdist-no-remote' => 'Kunne ikke kontakte ekstern SVN-klient.',
	'extdist-remote-error' => 'Feil fra ekstern SVN-klient: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ugyldig svar fra ekstern SVN-klient.',
	'extdist-svn-error' => 'SVN fant en feil: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Kunne ikke prosessere XML fra «svn info»: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar ga utgangsfeilen $1:',
	'extdist-created' => "Et øyeblikksbilde av versjon <b>$2</b> av utvidelsen <b>$1</b> for MediaWiki <b>$3</b> har blitt opprettet. Nedlastingen vil begynne automatisk om fem&nbsp;sekunder.

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
	'extdist-want-more' => 'Hent flere utvidelser',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'extensiondistributor' => 'Telecargar l’extension MediaWiki',
	'extdist-desc' => 'Extension per la distribucion dels archius fotografics de las extensions',
	'extdist-not-configured' => 'Configuratz $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Lo repertòri de la còpia de trabalh configurada existís pas !',
	'extdist-no-such-extension' => "Pas cap d'extension « $1 »",
	'extdist-no-such-version' => 'L’extension « $1 » existís pas dins la version « $2 ».',
	'extdist-choose-extension' => 'Seleccionatz l’extension que volètz telecargar :',
	'extdist-wc-empty' => "Lo repertòri de la còpia de trabalh configurada a pas cap d'extension distribuibla !",
	'extdist-submit-extension' => 'Contunhar',
	'extdist-current-version' => 'Version de desvolopament (trunk)',
	'extdist-choose-version' => "<big>Sètz a telecargar l’extension <b>$1</b>.</big>

Seleccionatz vòstra version MediaWiki.

La màger part de las extensions vira sus diferentas versions de MediaWiki. Atal, se vòstra version es pas presenta aicí, o s'avètz besonh de las darrièras foncionalitats de l’extension, ensajatz d’utilizar la version correnta.",
	'extdist-no-versions' => 'L’extension seleccionada ($1) es indisponibla dins mantuna version !',
	'extdist-submit-version' => 'Contunhar',
	'extdist-no-remote' => 'Impossible de contactar lo client subversion distant.',
	'extdist-remote-error' => 'Error del client subversion distant : <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Responsa incorrècta dempuèi lo client subversion distant.',
	'extdist-svn-error' => 'Subversion a rencontrat una error : <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Impossible de tractar lo XML a partir de « svn info » : <pre>$1</pre>',
	'extdist-tar-error' => 'Tar a tornat lo còde de sortida $1 :',
	'extdist-created' => "Una fòto de la version <b>$2</b> de l’extension <b>$1</b> per MediaWiki <b>$3</b> es estada creada. Vòstre telecargament deuriá començar automaticament dins 5 segondas.

L'adreça d'aquesta fòto es :
:$4
Pòt èsser utilizat per un telecargament immediat cap a un servidor, mas evitatz de l’inscriure dins vòstres signets, tre alara lo contengut serà pas mes a jorn, e poirà èsser escafat a una data ulteriora.

L’archiu tar deuriá èsser extracha dins vòstre repertòri d'extensions. A títol d’exemple, sus un sistèma basat sus UNIX :

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Jos Windows, podètz utilizar [http://www.7-zip.org/ 7-zip] per extraire los fichièrs.

Se vòstre wiki se tròba sus un servidor distant, extractatz los fichièrs dins un fichièr temporari sus vòstre ordenador local, e en seguida televersatz los '''totes''' dins lo repertòri d'extensions del servidor.

Notatz plan que qualques extensions necessitan un fichièr nomenat ExtensionFunctions.php, localizat sus  <tt>extensions/ExtensionFunctions.php</tt>, qu'es dins lo repertòri ''parent'' del repertòri particular de ladicha extension. L’imatge d'aquestas extensions contenon aqueste fichièr dins l’archiu tar que serà extrach jos ./ExtensionFunctions.php. Neglijatz pas de le televersar tanben sul servidor.

Un còp l’extraccion facha, auretz besonh d’enregistrar l’extension dins LocalSettings.php. Aquesta deuriá aver un mòde operatòri per aquò.

S'avètz de questions a prepaus d'aqueste sistèma de distribucion de las extensions, anatz sus [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Obténer una autra extension',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'extensiondistributor' => 'Æрбавгæн MediaWiki-йы æххæстгæнæн',
	'extdist-choose-extension' => 'Æрбавгæнынмæ æххæстгæнæнтæ равзæр:',
	'extdist-want-more' => 'Æндæр æххæстгæнæн æрбавгæн',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'extdist-submit-extension' => 'Weiter',
	'extdist-submit-version' => 'Weiter',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'extensiondistributor' => 'Pobierz rozszerzenie MediaWiki',
	'extdist-desc' => 'Rozszerzenie odpowiedzialne za dystrybucję zarchiwizowanych rozszerzeń gotowych do pobrania',
	'extdist-not-configured' => 'Proszę skonfigurować zmienne $wgExtDistTarDir i $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Skonfigurowany katalog z kopią roboczą nie istnieje!',
	'extdist-no-such-extension' => 'Brak rozszerzenia „$1”',
	'extdist-no-such-version' => 'Rozszerzenie „$1” w wersji „$2” nie istnieje.',
	'extdist-choose-extension' => 'Wybierz rozszerzenie, które chcesz pobrać:',
	'extdist-wc-empty' => 'Skonfigurowany katalog z kopią roboczą nie zawiera rozszerzeń, które można by było dystrybuować!',
	'extdist-submit-extension' => 'Kontynuuj',
	'extdist-current-version' => 'Wersja rozwijana (trunk)',
	'extdist-choose-version' => '<big>Do pobrania zostało wybrane rozszerzenie <b>$1</b>.</big>

Wybierz z listy wersję MediaWiki.

Większość rozszerzeń działa ze wszystkimi wersjami MediaWiki, więc jeśli nie ma na liście Twojej wersji MediaWiki lub potrzebujesz najnowszej wersji rozszerzenia, należy wybrać bieżącą wersję.',
	'extdist-no-versions' => 'Wybrane rozszerzenie „$1” nie jest dostępne w żadnej wersji oprogramowania!',
	'extdist-submit-version' => 'Kontynuuj',
	'extdist-no-remote' => 'Nie można połączyć się ze zdalnym klientem Subversion.',
	'extdist-remote-error' => 'Błąd zdalnego klienta Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Nieprawidłowa odpowiedź zdalnego klienta Subversion.',
	'extdist-svn-error' => 'Subversion napotkał błąd <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Nie można przetworzyć danych XML z „svn info”: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar zwrócił kod zakończenia $1:',
	'extdist-created' => "Utworzono skompresowane archiwum z rozszerzeniem <b>$1</b> na podstawie wersji <b>$2</b> dla MediaWiki <b>$3</b>. Pobieranie powinno rozpocząć się w ciągu 5 sekund.

Archiwum znajduje się pod adresem URL:
:$4
Adresu można użyć do natychmiastowego przesłania archiwum na serwer, ale nie należy zapisywać adresu, ponieważ zawartość archiwum nie będzie aktualizowana i w późniejszym czasie archiwum może zostać usunięte.

Archiwum tar należy rozpakować w katalogu z rozszerzeniami. W systemach uniksowych wygląda to następująco:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

W systemach Windows do rozpakowania plików możesz użyć programu [http://www.7-zip.org/ 7-zip].

Jeśli Twoja wiki znajduje się na zdalnym serwerze, wypakuj pliki do tymczasowego katalogu na lokalnym komputerze a następnie prześlij na serwer '''wszystkie''' pliki do katalogu z rozszerzeniami.

Uwaga – niektóre rozszerzenia wymagają pliku o nazwie ExtensionFunctions.php, który znajduje się w <tt>extensions/ExtensionFunctions.php</tt>, tzn. w głównym katalogu danego rozszerzenia. Dla tego typu rozszerzeń skompresowane archiwum zawiera plik bez katalogu, który jest rozpakowywany w bieżącym katalogu ./ExtensionFunctions.php. Nie zapomnij przesłać ten plik na zdalny serwer.

Po umieszczeniu plików w odpowiednich katalogach, należy włączyć rozszerzenie w pliku LocalSettings.php. Dokumentacja rozszerzenia powinna zawierać instrukcję jak to zrobić.

Jeśli masz jakieś pytania na temat systemu dystrybuującego rozszerzenia, zadaj je na stronie [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Pobierz inne rozszerzenie',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'extensiondistributor' => "Dëscaria l'estension MediaWiki",
	'extdist-desc' => "Estension për distribuì j'archivi snapshot ëd j'estension",
	'extdist-not-configured' => 'Për piasì configura $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Ël dossié configurà për còpie ëd travaj a esist pa!',
	'extdist-no-such-extension' => 'Pa gnun-e estension "$1"',
	'extdist-no-such-version' => 'L\'estension "$1" a esist pa ant la version "$2".',
	'extdist-choose-extension' => 'Selession-a che estension it veule dëscarié:',
	'extdist-wc-empty' => "Ël dossié configurà për còpie ëd travaj a l'ha pa gnun-e estension distribuìbij!",
	'extdist-submit-extension' => 'Continua',
	'extdist-current-version' => 'Version ëd dësvlup (trunk)',
	'extdist-choose-version' => "<big>It ses an camin ch'it dëscarie l'estension <b>$1</b>.</big>

Selession-a toa version MediaWiki.

Vàire estension a travajo dzora a 'd version diferente ëd MediaWiki, parèj se toa version ëd MediaWiki a l'é pa sì, o s'it l'has dabzògn ëd j'ùltime funsion ëd l'estension, preuva a dovré la version corenta.",
	'extdist-no-versions' => "L'estension selessionà ($1) a l'é pa disponìbil an gnun-e version!",
	'extdist-submit-version' => 'Continua',
	'extdist-no-remote' => 'As peul pa contaté ël client leugn ëd la sot-version.',
	'extdist-remote-error' => 'Eror dal client leugn ëd la sot-version: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Rispòsta pa bon-a dal client leugn ëd la sot-version.',
	'extdist-svn-error' => "La sot-version a l'ha rëncontrà n'eror: <pre>$1</pre>",
	'extdist-svn-parse-error' => 'As peul pa processesse l\'XML da "svn info": <pre>$1</pre>',
	'extdist-tar-error' => "Tar a l'ha restituì ël còdes ëd surtìa $1:",
	'extdist-created' => "Na còpia d'amblé ëd la version <b>$2</b> ëd l'estension <b>$1</b> për MediaWiki <b>$3</b> a l'é stàita creà. Toa dëscaria a dovrìa parte automaticament tra 5 second.

L'URL për sta còpia-sì a l'é:
:$4
A peul esse dovrà për cariela sùbit su un servent, ma për piasì memorisla pa, da già che ël contnù a sarà pa modificà, e a peul esse scancelà un doman.

L'archivi tar a dovrìa esse dëscompatà an tò dossié d'estension. Për esempi, ant un sistema ëd tipo OS unix:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Dzora a Windows, it peule dovré [http://www.7-zip.org/ 7-zip] për dëscompaté j'archivi.

Se toa wiki a l'é su un servent leugn, dëscompata j'archivi ant un dossié dzora a tò ordinator local, e peui caria '''tùit''' j'archivi dëscompatà ant ël dossié d'estension dzora al servent.

Nòta che chèiche estension a l'han dabzògn ëd n'archivi ciamà ExtensionFunctions.php, piassà an <tt>extensions/ExtensionFunctions.php</tt>, visadì, ant ël dossié ''pare'' dë sto particolar dossié d'estension. La còpia d'amblé për coste estension a conten st'archivi com un tarbomb, dëscompatà con ./ExtensionFunctions.php. Dësmentia pa ëd carié st'archivi-sì dzora a tò servent leugn.

Apress ch'it l'has dëscompatà j'archivi, it deve argistré l'estension an LocalSettings.php. La documentassion ëd l'estension a dovrìa avèj d'istrussion su com fé sòn.

S'it l'has chèiche chestion su sto sistema ëd distribuì j'estension, për piasì va a [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => "Pija n'àutra estension",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'extensiondistributor' => 'Descarregar extensão MediaWiki',
	'extdist-desc' => "Extensão para distribuir instantâneos arquivados ''(snapshot archives)'' de extensões",
	'extdist-not-configured' => 'Por favor, configure $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'A directoria de cópia de trabalho configurada não existe!',
	'extdist-no-such-extension' => 'A extensão "$1" não existe',
	'extdist-no-such-version' => 'A extensão "$1" não existe na versão "$2".',
	'extdist-choose-extension' => 'Selecione que extensão pretende descarregar:',
	'extdist-wc-empty' => 'A directoria de cópia de trabalho não possui extensões distribuíveis!',
	'extdist-submit-extension' => 'Continuar',
	'extdist-current-version' => 'Versão de desenvolvimento (tronco)',
	'extdist-choose-version' => '<big>Você está a descarregar a extensão <b>$1</b>.</big>

Selecione a versão do seu MediaWiki.

A maioria das extensões funciona através de múltiplas versões do MediaWiki, portanto, se a versão do seu MediaWiki não estiver aqui, ou se tiver necessidade das últimas funcionalidades da extensão, experimente usar a versão atual.',
	'extdist-no-versions' => 'A extensão selecionada ($1) não está disponível em nenhuma versão!',
	'extdist-submit-version' => 'Continuar',
	'extdist-no-remote' => 'Não foi possível contactar o cliente Subversion remoto.',
	'extdist-remote-error' => 'Erro do cliente Subversion remoto: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Resposta inválida do cliente Subversion remoto.',
	'extdist-svn-error' => 'O Subversion encontrou um erro: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Não foi possível processar o XML da informação SVN: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar retornou código de saída $1:',
	'extdist-created' => "Foi criado um instantâneo ''(snapshot)'' da versão <b>$2</b> da extensão <b>$1</b>, para o MediaWiki <b>$3</b>. A transferência deverá iniciar-se automaticamente em 5 segundos.

A URL deste instantâneo é:
:$4
Esta pode ser usada para descarregamento imediato para um servidor, mas por favor não a adicione aos seus favoritos, já que o conteúdo não será actualizado e poderá ser eliminado posteriormente.

Deve extrair o arquivo tar para o seu directório de extensões. Por exemplo, num sistema operativo tipo UNIX, use:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

No Windows, poderá usar o [http://www.7-zip.org/ 7-zip] para extrair os ficheiros.

Se a sua wiki estiver localizada num servidor remoto, extraia os ficheiros para um directório temporário no seu computador local, e depois carregue '''todos''' os directórios e ficheiros extraídos para o directório de extensões da wiki no servidor.

Note que algumas extensões precisam que um ficheiro ExtensionFunctions.php seja colocado em <tt>extensions/ExtensionFunctions.php</tt>, ou seja, no directório acima do desta extensão. O instantâneo dessas extensões deverá conter este ficheiro como uma 'tarbomb', que é extraída para ./ExtensionFunctions.php. Não negligencie o carregamento deste ficheiro para o seu servidor remoto.

Após ter colocado a extensão no directório de extensões da sua wiki, terá de registá-la em LocalSettings.php. A documentação da extensão deverá ter indicações sobre como o fazer.

Se tiver alguma questão sobre este sistema de distribuição de extensões, por favor, vá a [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Obter outra extensão',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'extensiondistributor' => 'Descarregar extensão MediaWiki',
	'extdist-desc' => 'Extensão para distribuir arquivos snapshot de extensões',
	'extdist-not-configured' => 'Por favor, configure $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'O diretório de cópia de trabalho configurado não existe!',
	'extdist-no-such-extension' => 'A extensão "$1" não existe',
	'extdist-no-such-version' => 'A extensão "$1" não existe na versão "$2".',
	'extdist-choose-extension' => 'Selecione que extensão pretende descarregar:',
	'extdist-wc-empty' => 'O diretório de cópia de trabalho não possui extensões distribuíveis!',
	'extdist-submit-extension' => 'Continuar',
	'extdist-current-version' => 'Versão em desenvolvimento (tronco)',
	'extdist-choose-version' => '<big>Você está a descarregando a extensão <b>$1</b>.</big>

Selecione a versão do seu MediaWiki.

A maioria das extensões funciona através de múltiplas versões do MediaWiki, portanto, se a versão do seu MediaWiki não estiver aqui, ou se tiver necessidade das últimas funcionalidades da extensão, experimente usar a versão atual.',
	'extdist-no-versions' => 'A extensão selecionada ($1) não está disponível em nenhuma versão!',
	'extdist-submit-version' => 'Continuar',
	'extdist-no-remote' => 'Não foi possível contatar o cliente Subversion remoto.',
	'extdist-remote-error' => 'Erro do cliente Subversion remoto: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Resposta inválida do cliente Subversion remoto.',
	'extdist-svn-error' => 'O Subversion encontrou um erro: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Não foi possível processar o XML do "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar retornou código de saída $1:',
	'extdist-created' => "Um instantâneo (''snapshot'') da versão <b>$2</b> da extensão <b>$1</b> para o MediaWiki <b>$3</b> foi criado. A sua descarga deverá iniciar-se automaticamente em 5 segundos.

A URL deste instantâneo é:
:$4
Esta pode ser utilizada para descarga imediata para um servidor, mas por favor não a adicione aos seus favoritos, já que o seu conteúdo não será atualizado, e poderá ser eliminado posteriormente.

O arquivo tar deverá ser extraído para o seu diretório de extensões. Por exemplo, num SO tipo UNIX:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

No Windows, poderá usar o [http://www.7-zip.org/ 7-zip] para extrair os arquivos.

Se o seu wiki está num servidor remoto, extraia os ficheiros para um diretório temporário no seu computador local, e depois carregue '''todos''' os ficheiros extraídos no diretório de extensões do servidor.

Note que algumas extensões precisam de um arquivo chamado ExtensionFunctions.php, situado em <tt>extensions/ExtensionFunctions.php</tt>, ou seja, no diretório ''pai'' da diretoria desta extensão em particular. O instantâneo destas extensões contém este arquivo como uma 'tarbomb', extraída para ./ExtensionFunctions.php. Não negligencie o carregamento deste ficheiro para o seu servidor remoto.

Após ter extraído os ficheiros, terá que registar a extensão em LocalSettings.php. A documentação da extensão deverá ter instruções de como o fazer.

Se tiver alguma questão sobre este sistema de distribuição de extensões, por favor, vá a [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Obter outra extensão',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'extensiondistributor' => 'Descarcă extensia MediaWiki',
	'extdist-no-such-extension' => 'Extensia "$1" inexistentă',
	'extdist-no-such-version' => 'Extensia "$1" nu există în versiunea "$2".',
	'extdist-submit-extension' => 'Continuă',
	'extdist-current-version' => 'Versiune dezvoltare (trunchi)',
	'extdist-choose-version' => '<big>Descărcaţi extensia <b>$1</b>.</big>

Alegeţi versiunea dvs MediaWiki.

Cele mai multe extensii funcţionează în mai multe versiuni de MediaWiki, deci dacă versiunea dvs MediaWiki nu este aici sau dacă aveţi nevoie de cele mai recente funcţionalităţi pentru extensii, încercaţi să folosiţi versiunea curentă.',
	'extdist-submit-version' => 'Continuă',
	'extdist-want-more' => 'Obţine altă extensie',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'extensiondistributor' => 'Scareche le estenziune de MediaUicchi',
	'extdist-submit-extension' => 'Condinue',
	'extdist-submit-version' => 'Condinue',
	'extdist-want-more' => "Pigghie 'n'otra estenzione",
);

/** Russian (Русский)
 * @author MaxSem
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'extensiondistributor' => 'Скачать расширения MediaWiki',
	'extdist-desc' => 'Расширение для скачивания дистрибутивов с расширениями',
	'extdist-not-configured' => 'Пожалуйста, задайте $wgExtDistTarDir и $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Заданная в настройках директория с рабочей копией не существует!',
	'extdist-no-such-extension' => 'Расширение «$1» не найдено',
	'extdist-no-such-version' => 'Версия $2 расширения «$1» не найдена.',
	'extdist-choose-extension' => 'Выберите расширение для скачивания:',
	'extdist-wc-empty' => 'Заданная в настройках директория с рабочей копией не имеет расширений для распространения!',
	'extdist-submit-extension' => 'Продолжить',
	'extdist-current-version' => 'Разрабатываемая версия (trunk)',
	'extdist-choose-version' => '<big>Вы скачиваете расширение <b>«$1»</b>.</big>

Выберите свою версию MediaWiki.

Большинство расширений работают с несколькими версиями MediaWiki, поэтому если установленная у вас версия здесь не приведена, или вам требуются возможности последней версии расширения — попробуйте последнюю версию.',
	'extdist-no-versions' => 'Выбранное расширение («$1») не доступно ни в одной версии!',
	'extdist-submit-version' => 'Продолжить',
	'extdist-no-remote' => 'Не получилось связаться с удалённым клиентом Subversion.',
	'extdist-remote-error' => 'Ошибка удалённого клиента Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ошибочный ответ клиента subversion.',
	'extdist-svn-error' => 'Ошибка Subversion: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Ошибка обработки XML, возвращённого командой «svn info»: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar вернул код ошибки $1:',
	'extdist-created' => "Был создан снимок версии <b>$2</b> расширения <b>$1</b> для MediaWiki <b>$3</b>. Загрузка должна начаться автоматически через 5 секунд.

URL данного снимка:
:$4
Этот адрес может быть использован для немедленного начала загрузки на сервер, но, пожалуйста, не заносите ссылку в закладки, так как содержание не будет обновляться, а адрес может перестать работать в будущем.

Tar-архив следует распаковать в вашу директорию для расширений. Например, для юникс-подобных ОС это будет команда:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

В Windows для извлечения файлов вы можете использовать программу [http://www.7-zip.org/ 7-zip]

Если ваша вики находится на удалённом сервере, извлеките файлы во временную директорию вашего компьютера и затем загрузите '''все''' извлечённые файлы в директорию расширения на сервере.

Заметьте, что некоторые расширения требуют наличия файла ExtensionFunctions.php, размещённого в родительской директории по отношению к директории расширения — <tt>extensions/ExtensionFunctions.php</tt>. Снимок для таких расширений содержит этот файл в виде tar-бомбы, распакованной в ./ExtensionFunctions.php. Не забывайте загрузить этот файл на ваш сервер.

После извлечения файлов, вам следует прописать это расширение в файл LocalSettings.php. Документация по расширению должна содержать соответствующие указания.

Если у вас есть вопрос об этой системе распространения расширений, пожалуйста, обратитесь к странице [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Скачать другое расширение',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'extensiondistributor' => 'МедиаВики тупсарыыларын хачайдааһын',
	'extdist-desc' => 'Тупсарыылары хачайдыыр тупсарыы',
	'extdist-not-configured' => 'Бука диэн балары туруор: $wgExtDistTarDir уонна $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Туруорууга бэриллибит үлэлиир копиялаах паапка суох!',
	'extdist-no-such-extension' => '"$1" тупсарыы булуллубата',
	'extdist-no-such-version' => '"$1" тупсарыы "$2" барыла булуллубата.',
	'extdist-choose-extension' => 'Тупсарыыны хачайдыырга тал:',
	'extdist-wc-empty' => 'Уларытыллыахтаах үлэлиир копиялаах директория тупсарыыта суох!',
	'extdist-submit-extension' => 'Салгыы',
	'extdist-current-version' => 'Сайдар барыла (trunk)',
	'extdist-choose-version' => '<big><b>«$1»</b> тупсарыыны хачайдаан эрэҕин.</big>

Бэйэҕэр турар MediaWiki барылын тал.

Тупсарыылар үгүстэрэ MediaWiki хас да барылын кытта үлэлииллэр, онон эйиэхэ турар барыл тиһиккэ суох буоллаҕына эбэтэр бүтэһик барыл биэрэр кыахтара наада буоллахтарына — бүтэһик барылы хачайдаан көр.',
	'extdist-no-versions' => 'Талбыт ($1) тупсарыыҥ ханнык да барылга үлэлиир кыаҕа суох!',
	'extdist-submit-version' => 'Салгыы',
	'extdist-no-remote' => 'Атын барылы (subversion client) кытта сибээс кыайан олохтоммото.',
	'extdist-remote-error' => 'Атын барыл (subversion client) алҕастаах: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Атын барыл (subversion client) алҕастаах хоруйа.',
	'extdist-svn-error' => 'Барыл (Subversion) алҕаһа: <pre>$1</pre>',
	'extdist-svn-parse-error' => '"Svn info" хамаанда ыыппыт XML уларытар процеһын алҕаһа: <pre>$1</pre>',
	'extdist-tar-error' => 'Куод $1 сыыһатын Tar көрдөрөр:',
	'extdist-created' => "MediaWiki <b>$3</b> анаан <b>$1</b> тупсарыы <b>$2</b> барылын снэпшота (снимок) оҥоһулунна. 5 сөкүүндэннэн хачайданыы саҕаланыахтаах. 

Снэпшот URL-а:
:$4
Бу аадырыс сиэрбэргэ сип-сибилигин хачайдыырга туһаныллыан сөп эрээри, иһэ уларыйбат буолан кэлин үлэлиэ суоҕун сөп. Онон сигэни закладкаҕа киллэрэр наадата суох. 

Tar-архыыбы тупсарыылар паапкаларыгар арыйыахха наада. Холобур, юникс бииһин ууһун ОС бу хамаанда туттуллар:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Windows-ка билэлэри туттарга [http://www.7-zip.org/ 7-zip] бырагыраамманы туттуоххун сөп.

Эн биикиҥ атын ыраах сиэрбэргэ турар буоллаҕына билэлэри быстах кэмҥэ оҥоһуллубут паапкаҕа хостоо, онтон хостоммут билэлэри '''барытын''' сиэрбэр тупсарыыга аналлаах паапкатыгар көһөр. 

Сорох тупсарыылар ExtensionFunctions.php билэ баарын ирдииллэр, ол манна ''төрөппүт'' паапкаҕа баар — <tt>extensions/ExtensionFunctions.php</tt>. Маннык тупсарыылар снэпшоттара манна ./ExtensionFunctions.php tar-бомба көрүҥүҥэн сытар. Бу билэни бэйэҥ сиэрбэргэр хачайдыыргын умнума.

Билэлэри хостоон баран тупсарыыны бу билэҕэ LocalSettings.php суруттарыахха наада. Тупсарыы дөкүмүөнүгэр манна аналлаах ыйыылар баар буолуохтахтар.

Тугу эмит бу туһунан ыйытыаххын баҕардаххына бу сирэйгэ киир: [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Атын тупсарыыны хачайдыырга',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'extensiondistributor' => 'Stiahnuť rozšírenie MediaWiki',
	'extdist-desc' => 'Rozšírenie na distribúciu archívov rozšírení',
	'extdist-not-configured' => 'Prosím, nastavte $wgExtDistTarDir a $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Nastavený adresár pre pracovnú kópiu neexistuje!',
	'extdist-no-such-extension' => 'Rozšírenie „$1” neexistuje',
	'extdist-no-such-version' => 'Rozšírenie „$1” neexistuje vo verzii „$2”',
	'extdist-choose-extension' => 'Vyberte, ktoré rozšírenie chcete stiahnuť:',
	'extdist-wc-empty' => 'Nastavená pracovná kópia nemá rozšírenia, ktoré je možné distribuovať!',
	'extdist-submit-extension' => 'Pokračovať',
	'extdist-current-version' => 'Vývojová verzia (trunk)',
	'extdist-choose-version' => '<big>Sťahujete rozšírenie <b>$1</b>.</big>

Vyberte vašu verziu MediaWiki.

Väčšina rozšírení funguje na viacerých verziách MediaWiki, takže ak tu nie je vaša verzia MediaWiki uvedená alebo potrebujete najnovšiu vývojovú verziu rozšírenia, pokúste sa použiť aktuálnu verziu.',
	'extdist-no-versions' => 'Zvolené rozšírenie ($1) nie je dostupné v žiadnej verzii!',
	'extdist-submit-version' => 'Pokračovať',
	'extdist-no-remote' => 'Nepodarilo sa kontaktovať vzdialeného klienta Subversion.',
	'extdist-remote-error' => 'Chyba od vzdialeného klienta Subversion: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Neplatná odpoveď od vzdialeného klienta Subversion.',
	'extdist-svn-error' => 'Subversion narazil na chybu: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Nebolo možné spracovať XML z výstupu „svn info”: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar skončil s návratovým kódom $1:',
	'extdist-created' => "Obraz verzie <b>$2</b> rozšírenia <b>$1</b> pre MediaWiki <b>$3</b> bol stiahnutý. Sťahovanie by malo začať automaticky do 5 sekúnd.

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
	'extdist-want-more' => 'Stiahnuť iné rozšírenie',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 */
$messages['sv'] = array(
	'extensiondistributor' => 'Ladda ner tillägg till MediaWiki',
	'extdist-desc' => 'Tillägg för distribution av övriga tillägg',
	'extdist-not-configured' => 'Var god bekräfta $wgExtDistTarDir och $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Mappen med arbetskopian finns inte!',
	'extdist-no-such-extension' => 'Ingen sådant tillägg "$1"',
	'extdist-no-such-version' => 'Tillägget "$1" finns inte i versionen "$2".',
	'extdist-choose-extension' => 'Välj vilket tillägg du vill ladda ner:',
	'extdist-wc-empty' => 'Mappen med arbetskopian har inga distribuerbara tillägg!',
	'extdist-submit-extension' => 'Fortsätt',
	'extdist-current-version' => 'Utvecklingsversion (trunk)',
	'extdist-choose-version' => '
<big>Du laddar ner tillägget <b>$1</b>.</big>

Ange vilken version av MediaWiki du använder.

De flesta tilläggen fungerar på flera versioner av MediaWiki, så om versionen du använder inte listas upp här, kan du pröva att välja den nyaste versionen.',
	'extdist-no-versions' => 'Det valda tillägget ($1) är inte tillgängligt i någon version!',
	'extdist-submit-version' => 'Fortsätt',
	'extdist-no-remote' => 'Kunde inte kontakta extern SVN-klient.',
	'extdist-remote-error' => 'Fel från extern SVN-klient: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Ogiltigt svar från extern SVN-klient.',
	'extdist-svn-error' => 'SVN hittade ett fel: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Kunde inte processera XML från "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar returnerade utgångskod $1:',
	'extdist-created' => "En ögonblicksbild av version <b>$2</b> av tillägget <b>$1</b> för MediaWiki <b>$3</b> har skapats. Din nerladdning ska starta automatiskt om 5 sekunder.

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
	'extdist-want-more' => 'Hämta andra tillägg',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'extdist-no-such-extension' => '"$1" అనే పొడగింత లేదు',
	'extdist-choose-extension' => 'మీరు ఏ పొడగింతని దింపుకోవాలనుకుంటున్నారో ఎంచుకోండి:',
	'extdist-submit-extension' => 'కొనసాగించు',
	'extdist-choose-version' => '<big>మీరు <b>$1</b> పొడగింతని దింపుకోబోతున్నారు.</big>

మీ మిడియావికీ సంచికని ఎంచుకోండి.

చాలా పొడగింతలు పలు మీడియావికీ సంచికల్లో పనిచేస్తాయి, కాబట్టి మీ మీడియావికీ సంచిక ఇక్కడ లేకపోతే, లేదా మీకు పొడగింతల సరికొత్త సౌలభ్యాల అవసరం ఉంటే, ప్రస్తుత సంచికని ఉపయోగించండి.',
	'extdist-submit-version' => 'కొనసాగించు',
	'extdist-want-more' => 'మరొక పొడగింతని పొందండి',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'extdist-submit-extension' => 'ดำเนินการต่อ',
	'extdist-choose-version' => '<big>คุณกำลังจะดาวน์โหลดซอฟต์แวร์เสริมชื่อ <b>$1</b> </big>

กรุณาเลือกรุ่นปรับปรุงของ MediaWiki ที่คุณใช้อยู่

ซอฟต์แวร์เสริมส่วนใหญ่สามารถใช้งานได้บนหลายรุ่นปรับปรุงของ MediaWiki ดังนั้นถ้ารุ่นปรับปรุงของ MediaWiki ของคุณไม่ปรากฎในนี้ หรือถ้าคุณต้องการใช้คุณสมบัติล่าสุดของซอฟต์แวร์เสริมนี้ ให้ลองใช้ซอฟต์แวร์เสริมรุ่นปรับปรุงปัจจุบัน',
	'extdist-submit-version' => 'ดำเนินการต่อ',
	'extdist-created' => "ไฟล์คัดลอกของซอฟต์แวร์เสริมของ MediaWiki <b>$3</b> ชื่อ <b>$1</b> รุ่นหมายเลข <b>$2</b> ได้ถูกสร้างขึ้นแล้ว และการดาวน์โหลดไฟล์ของคุณจะเริ่มต้นโดยอัติโนมัติภายใน 5 วินาที

URL สำหรับไฟล์คัดลอกคือ:
:$4
ซึ่งสามารถใช้สำหรับการดาวน์โหลดโดยตรงจากเซิร์ฟเวอร์ได้ แต่กรุณาอย่าคั่นหน้านี้ไว้เนื่องจากเนื้อหาของไฟล์จะไม่ถูกปรับปรุงเป็นรุ่นล่าสุด และอาจจะถูกลบได้ในภายหลัง

ไฟล์ภายในของไฟล์ tar ควรจะถูกดึงออกมาวางไว้ที่ไดเร็กทอรีซอฟต์แวร์เสริมของคุณ ตัวอย่างเช่น ในระบบปฏิบัติการ UNIX หรือคล้ายคลึง:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

สำหรับบนระบบปฏิบัติการวินโดวส์ คุณสามารถใช้โปรแกรม [http://www.7-zip.org/ 7-zip] เพิ่อดึงไฟล์ออกมา

ถ้าวิกิของคุณอยู่ในเซิร์ฟเวอร์สั่งการทางไกล ให้ดึงไฟล์ออกมาวางไว้ที่โฟลเดอร์ชั่วคราวบนคอมพิวเตอร์ของคุณก่อน แล้วจึงอัพโหลดไฟล์'''ทั้งหมด'''ไปยังไดเร็กทอรีของซอฟต์แวร์เสริมบนเซิร์ฟเวอร์

อย่าลืมว่าซอฟต์แวร์เสริมบางอย่างต้องการไฟล์ที่ชื่อว่า ExtensionFunctions.php ซึ่งอยู่ที่ <tt>extensions/ExtensionFunctions.php</tt> ซึ่งนั่นก็คือไดเร็กทอรี''หลัก''ของซอฟต์แวร์เสริมนั้นๆ ไฟล์คัดลอกของซอฟต์แวร์เสริมเหล่านี้มีไฟล์ภายในที่อยู่ในลักษณะ tarbomb และถูกดึงออกไว้ที่ ./ExtensionFunctions.php ดังนั้นห้ามเว้นการอัพโหลดไฟล์นี้ไปยังเซิร์ฟเวอร์สั้งการของคุณ

หลังจากที่คุณดึงไฟล์ออกมาแล้ว คุณจำเป็นต้องลงทะเบียนซอฟต์แวร์เสริมใน LocalSettings.php ซึ่งเอกสารแนบที่มากับซอฟต์แวร์เสริมจะมีขั้นตอนการทำอยู่

ถ้าคุณยังมีข้อสงสัยประการใดเกี่ยวกับระบบการแผยแพร่ซอฟต์แวร์เสริมนี้ กรุณาไปที่ [[Extension talk:ExtensionDistributor]].",
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'extensiondistributor' => 'MediaWiki giňeltmesini düşür',
	'extdist-desc' => 'Giňeltmeleriň pursatlyk görnüş arhiwlerini paýlamak üçin giňeltme',
	'extdist-not-configured' => 'Konfigurirläň: $wgExtDistTarDir we $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Konfigurirlenen iş nusgasy direktoriýasy ýok!',
	'extdist-no-such-extension' => '"$1" diýip giňeltme ýok.',
	'extdist-no-such-version' => '"$2" wersiýasynda "$1" giňeltmesi ýok.',
	'extdist-choose-extension' => 'Düşürmek isleýän giňeltmäňizi saýlaň:',
	'extdist-wc-empty' => 'Konfigurirlenen iş nusgasy direktoriýasynda hiç hili paýlap boljak giňeltme ýok!',
	'extdist-submit-extension' => 'Dowam et',
	'extdist-current-version' => 'Ösdüriş wersiýasy (trunk)',
	'extdist-no-versions' => 'Saýlanylan giňeltme ($1) hiç bir wersiýada ýok!',
	'extdist-submit-version' => 'Dowam et',
	'extdist-no-remote' => 'Uzakdan Subversion müşderisi bilen aragatnaşyk gurup bolmaýar.',
	'extdist-remote-error' => 'Uzakdan Subversion müşderisinden säwlik: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Uzakdan Subversion müşderisined nädogry jogap.',
	'extdist-svn-error' => 'Subversion säwlige duçar boldy: <pre>$1</pre>',
	'extdist-svn-parse-error' => '"svn info"dan XML-ni işläp bolmaýar: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar çykyş kody $1 gaýdyp geldi:',
	'extdist-want-more' => 'Başga giňeltme al',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'extensiondistributor' => 'Ikarga pababa ang karugtong na pang-MediaWiki',
	'extdist-desc' => 'Karugtong para sa pagpapamahagi ng sinupan/arkibo ng mga karugtong na para sa mga kuha ng larawan/litrato',
	'extdist-not-configured' => 'Paki-isaayos ang $wgExtDistTarDir at $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Hindi umiiral ang naisaayos nang direktoryo ng siping panggawain!',
	'extdist-no-such-extension' => 'Walang ganyang karugtong na "$1"',
	'extdist-no-such-version' => 'Hindi umiiral ang karugtong na "$1" sa loob ng bersyong "$2".',
	'extdist-choose-extension' => 'Piliin kung aling karugtong ang nais mong ikarga pababa:',
	'extdist-wc-empty' => 'Walang maaaring ipamahaging mga karugtong ang naisaayos na direktoryo ng siping panggawain!',
	'extdist-submit-extension' => 'Ipagpatuloy',
	'extdist-current-version' => 'Bersyon ng pagpapaunlad (baul)',
	'extdist-choose-version' => "<big>Ikinakarga mo pababa ang <b>$1</b> na karugtong.</big>

Piliin ang iyong bersyon ng MediaWiki.

Gumagawa sa kahabaan ng maramihang mga bersyon ng MediaWiki ang karamihan sa mga karugtong, kaya't kung ang iyong bersyon ng MediaWiki ay hindi dito, o kung kailangan mo ng isang pinakabagong mga kasangkapang-katangian ng karugtong, subuking gamitin ang pangkasalukuyang bersyon.",
	'extdist-no-versions' => 'Hindi makukuha mula sa loob ng anumang bersyon ang napiling karugtong na ($1)!',
	'extdist-submit-version' => 'Ipagpatuloy',
	'extdist-no-remote' => 'Hindi nagawang makipag-ugnayan sa malayong kliyente ng kabahaging bersyon.',
	'extdist-remote-error' => 'Kamalian mula sa malayong kliyente ng kabahaging bersyon: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Hindi tanggap na tugon mula sa malayong kliyente ng kabahaging bersyon.',
	'extdist-svn-error' => 'Nakaranas ng isang kamalian ang kabahaging bersyon: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Hindi naisagawa ang XML mula sa "svn info": <pre>$1</pre>',
	'extdist-tar-error' => "Ibinalik ng pormat na ''tar'' ang kodigo sa paglabas na $1:",
	'extdist-created' => "Nalikha na ang isang kuha ng larawan ng bersyong <b>\$2</b> ng karugtong na <b>\$1</b> para sa MediaWiking <b>\$3</b>. Dapat na kusang magsimula na ang iyong pagkakargang pababa sa loob ng 5 mga segundo.

Ang URL ng kuha ng larawang ito ay:
:\$4
Maaaring gamitin ito para sa kaagad na pagkakargang pababa patungo sa isang serbidor, ngunit huwag po lamang itong lagyan ng \"panandang pang-aklat\" (''bookmark''), dahil hindi maisasapanahon ang mga nilalaman, at maaaring mabura ito sa paglaon.

Dapat na hanguin ang sinupan/arkibo ng ''tar'' (pormat ng talaksan) patungo sa iyong direktoryo ng mga karugtong.  Halimbawa na, sa isang mistulang ''unix'' na OS:

<pre>
tar -xzf \$5 -C /var/www/mediawiki/extensions
</pre>

Sa Windows, maaari mong gamitin ang [http://www.7-zip.org/ 7-zip] upang mahango ang mga talaksan.

Kung ang wiki mo ay nasa ibabaw ng isang malayong serbidor/tagahain, hanguin ang mga talaksan patungo sa isang pansamantalang direktoryong nasa ibabaw ng pampook/lokal mong kompyuter, at pagkatapos ay ikarga pataas ang '''lahat''' ng nahangong mga talaksan papunta sa direktoryo ng mga karugtong na nasa ibabaw ng serbidor.

Tandaan na nangangailangan ang ilang mga karugtong ng isang talaksang tinatawag na ExtensionFunctions.php, na nasa <tt>extensions/ExtensionFunctions.php</tt>, na ang ibig sabihin ay nasa loob ng ''magulang'' na direktoryo ng partikular na direktoryong ito ng karugtong.  Ang mga kuha ng larawang para sa mga karugtong na ito ay napapalooban ng ganitong talaksan upang magsilbi bilang isang \"pampasabog na tar\" (''tarbomb''), na hinahango patungo sa ./ExtensionFunctions.php. Huwag kalimutang ikarga pataas ang talaksang ito patungo sa iyong malayong serbidor.

Matapos  mong hangunin ang mga talaksan, kakailanganin mong itala/irehistro ang karugtong sa loob ng LocalSettings.php.  Ang kasulatan ng karugtong ay dapat na mayroong mga panuntunan hinggil sa kung paano ito maisasagawa.

Kung mayroon kang anumang katanungan hinggil sa sistemang ito ng pagpapamahagi ng karugtong, mangyaring pumunta lamang po sa [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Kumuha ng iba pang karugtong',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'extensiondistributor' => 'MedyaViki eklentisini indir',
	'extdist-desc' => 'Eklentilerin anlık görüntü arşivlerini dağıtmak için eklenti',
	'extdist-not-configured' => 'Lütfen $wgExtDistTarDir ve $wgExtDistWorkingCopy ayarlayın',
	'extdist-wc-missing' => 'Ayarlanan çalışma kopyası dizini mevcut değil!',
	'extdist-no-such-extension' => '"$1" adında bir eklenti yok',
	'extdist-no-such-version' => '"$2" versiyonunda "$1" eklentisi mevcut değil.',
	'extdist-choose-extension' => 'İndirmek istediğiniz eklentiyi seçin:',
	'extdist-wc-empty' => 'Ayarlanan çalışma kopyası dizininde hiç dağıtılabilir eklenti yok!',
	'extdist-submit-extension' => 'Devam et',
	'extdist-current-version' => 'Geliştirme sürümü (trunk)',
	'extdist-choose-version' => '<big><b>$1</b> eklentisini indiriyosunuz.</big>

MedyaViki sürümünüzü seçin.

Pekçok eklenti MedyaVikinin birçok sürümünde çalışır, eğer MedyaViki sürümünüz burada yoksa, ya da en son eklenti özelliklerine ihtiyacınız varsa, güncel sürümü kullanmayı deneyin.',
	'extdist-no-versions' => 'Seçili eklenti ($1) hiçbir versiyonda mevcut değil!',
	'extdist-submit-version' => 'Devam et',
	'extdist-no-remote' => 'Uzaktan altsürüm istemcisiyle temas kurulamıyor.',
	'extdist-remote-error' => 'Uzaktan altsürüm istemcisinde hata: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Uzaktan altsürüm istemcisinden geçersiz yanıt.',
	'extdist-svn-error' => 'Altsürüm bir hatayla karşılaştı: <pre>$1</pre>',
	'extdist-svn-parse-error' => '"svn info"daki XML işlenemiyor: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar çıkış kodu $1 geri döndürdü:',
	'extdist-created' => "<b>$1</b> eklentisinin <b>$2</b> versiyonunun anlık görüntüsü MediaWiki <b>$3</b> için oluşturuldu. İndirmeniz 5 saniye içinde otomatik olarak başlamalıdır.

Anlık görüntünün URLsi:
:$4
Bu, bir sunucuya anında indirme için kullanılabilir. Ancak içerik güncellenmeyeceğinden ve ileri bir tarihte silinebileceğinden, lütfen yer imlerine eklemeyin.

Tar arşivi eklenti dizininize çıkarılmalıdır. Örneğin, unix tipi işletim sistemlerinde:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Windows'ta, dosyaları çıkartmak için [http://www.7-zip.org/ 7-zip]'i kullanabilirsiniz.

Eğer vikiniz uzaktan bir sunucuda ise, dosyaları yerel bilgisayarınızda geçici bir dizine çıkarın, ve sonra '''bütün''' çıkarılan dosyaları sunucunun eklenti dizinine kopyalayın.

Bazı eklentiler ExtensionFunctions.php adlı bir dosyaya ihtiyaç duyar, <tt>extensions/ExtensionFunctions.php</tt>'de, bu belirli eklentinin dizininin ''ana'' dizininde. Bu eklentilerin anlık görüntüsü, bu dosyayı tarbomb olarak içerir, ExtensionFunctions.php'a çıkarılmıştır. Bu dosyayı uzaktan sunucunuza yüklemeyi ihmal etmeyin.

Dosyaları çıkardıktan sonra, eklentiyi LocalSettings.php'de kaydetmelisiniz. Eklenti dokümantasyonu bunu nasıl yapacağınızın açıklamasını içerebilir.

Eğer bu eklenti dağıtım sistemi ile herhangi bir sorunuz varsa, lütfen [[Extension talk:ExtensionDistributor]]'a gidin.",
	'extdist-want-more' => 'Başka eklenti al',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'extensiondistributor' => 'Завантажити розширення MediaWiki',
	'extdist-desc' => 'Розширення для завантаження дистрибутивів розширень',
	'extdist-not-configured' => 'Будь ласка, налаштуйте $wgExtDistTarDir і $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Зазначеного в налаштуваннях каталогу робочої копії не існує!',
	'extdist-no-such-extension' => 'Розширення «$1» не знайдено',
	'extdist-no-such-version' => 'Розширення "$1" не існує у версії "$2".',
	'extdist-choose-extension' => 'Виберіть розширення, яке ви хочете завантажити:',
	'extdist-wc-empty' => 'Зазначений в налаштуваннях каталог робочої копії не містить дистрибутивів розширень!',
	'extdist-submit-extension' => 'Продовжити',
	'extdist-current-version' => 'Версія в розробці (trunk)',
	'extdist-choose-version' => '<big>Ви завантажуєте <b>$1</b> розширення.</big>

Оберіть вашу версію MediaWiki.

Більшість розширень працюють на кількох версіях MediaWiki, тому, якщо вашої версії MediaWiki тут немає, або якщо у Вас є потреба в функціях останньої версії розширення, спробуйте використати поточну версію.',
	'extdist-no-versions' => 'Обране розширення ($1) не доступне в жодній версії!',
	'extdist-submit-version' => 'Продовжити',
	'extdist-no-remote' => "Не вдається зв'язатись з віддаленим клієнтом субверсії.",
	'extdist-remote-error' => 'Помилка віддаленого клієнту субверсії: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Неприпустима відповідь від віддаленого клієнту субверсії.',
	'extdist-svn-error' => 'Помилка субверсії: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Не вдається обробити XML з "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar повернув код помилки $1:',
	'extdist-want-more' => 'Завантажити інше розширення',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'extensiondistributor' => 'Descarga na estension MediaWiki',
	'extdist-desc' => 'Estension par distribuir archivi snapshot de le estension',
	'extdist-not-configured' => 'Par piaser configura $wgExtDistTarDir e $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'La cartèla par copie de laoro configurà no la esiste!',
	'extdist-no-such-extension' => 'L\'estension "$1" no la esiste',
	'extdist-no-such-version' => 'L\'estension "$1" no la esiste in te la version "$2".',
	'extdist-choose-extension' => 'Siegli quala estension te voli descargar:',
	'extdist-wc-empty' => 'La cartèla par copie de laoro configurà no la contien estension distribuibili!',
	'extdist-submit-extension' => 'Continua',
	'extdist-current-version' => 'Version de svilùpo (trunk)',
	'extdist-choose-version' => "<big>Te sì drio descargar l'estension <b>$1</b>.</big>

Selessiona la to version de MediaWiki.

Tante estension le va su più version de MediaWiki, quindi se la to version de MediaWiki no la xe qua o se te serve le ultime funsion de l'estension, próa a doparar la version corente.",
	'extdist-no-versions' => "L'estension che ti gà sielto ($1) no la xe disponibile in nissuna version!",
	'extdist-submit-version' => 'Continua',
	'extdist-no-remote' => 'No se riesse a contatar el client subversion remoto.',
	'extdist-remote-error' => 'Eròr dal client subversion remoto: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Risposta mia valida dal client subversion remoto.',
	'extdist-svn-error' => 'Subversion el gà catà un eròr: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'No se riesse a elaborar l\'XML da "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'El Tar el gà ritornà el seguente còdese de uscita $1:',
	'extdist-created' => "Na istantanea de la version <b>$2</b> de l'estension <b>$1</b> par MediaWiki <b>$3</b> la xe stà creà. El scaricamento el dovarìa partir da solo fra 5 secondi.

L'URL par sta istantanea el xe:
:$4
El pode vegner doparà par descargar de boto dal server, ma no stà zontarlo ai Preferiti parché el contenuto no'l vegnarà mia ajornà e el colegamento el podarìa in futuro èssar cavà.

L'archivio tar el dovarìa vegner estrato in te la to cartèla de le estension. Par esenpio, su de un sistema operativo de tipo unix:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Su Windows te podi doparar [http://www.7-zip.org/ 7-zip] par estrarre i file.

Se la to wiki la se cata su de un server remoto, estrai i file in te na cartèla tenporanea sul to computer locale e in seguito carga '''tuti quanti''' i file estrati in te la cartèla de le estension sul server.

Stà tento che serte estension le gà bisogno de un file ciamà ExtensionFunctions.php, che se cata in <tt>extensions/ExtensionFunctions.php</tt>, che xe la cartèla ''superior'' de sta particolare cartèla de l'estension. L'istantanea par ste estensioni la contien sto file come na tarbom, estrata in ./ExtensionFunctions.php. No stà desmentegarte de cargar sto file sul to server locale.

Dopo che ti gà estrato i file, te gavarè bisogno de registrar l'estension in LocalSettings.php. El manual de l'estension el dovarìa contegner le istrussion su come far.

Se ti gà qualche domanda riguardo el sistema de distribussion de sta estension, varda [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => "Toli n'antra estension",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'extdist-submit-extension' => 'Jatkta',
	'extdist-submit-version' => 'Jatkata',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'extensiondistributor' => 'Tải bộ mở rộng MediaWiki về',
	'extdist-desc' => 'Bộ mở rộng để phân phối các bản lưu trữ ảnh của các bộ mở rộng',
	'extdist-not-configured' => 'Xin hãy cấu hình $wgExtDistTarDir và $wgExtDistWorkingCopy',
	'extdist-wc-missing' => 'Không tồn tại thư mục sao chép hiện hành đã được cấu hình!',
	'extdist-no-such-extension' => 'Không có bộ mở rộng "$1"',
	'extdist-no-such-version' => 'Bộ mở rộng "$1" không tồn tại trong phiên bản "$2".',
	'extdist-choose-extension' => 'Chọn bộ mở rộng bạn muốn tải về:',
	'extdist-wc-empty' => 'Thư mục sao chép hiện hành được cấu hình không có bộ mở rộng nào phân phối được!',
	'extdist-submit-extension' => 'Tiếp tục',
	'extdist-current-version' => 'Phiên bản phát triển (trunk)',
	'extdist-choose-version' => '<big>Bạn đang tải xuống bộ mở rộng <b>$1</b>.</big>

Chọn phiên bản MediaWiki của bạn.

Phần lớn bộ mở rộng có thể chạy được trên nhiều phiên bản MediaWiki, do đó nếu phiên bản MediaWiki của bạn không được liệt kê ở đây, hoặc nếu bạn cần sử dụng các tính năng mở rộng mới nhất, hãy thử sử dụng phiên bản hiện hành.',
	'extdist-no-versions' => 'Phiên bản được chọn ($1) không có sẵn trong bất kỳ phiên bản nào!',
	'extdist-submit-version' => 'Tiếp tục',
	'extdist-no-remote' => 'Không thể liên hệ với máy khách phiên bản con ở xa.',
	'extdist-remote-error' => 'Lỗi trả về từ máy khách phiên bản con từ xa: <pre>$1</pre>',
	'extdist-remote-invalid-response' => 'Phản hồi không hợp lệ từ máy khách phiên bản con từ xa.',
	'extdist-svn-error' => 'Phiên bản con gặp một lỗi: <pre>$1</pre>',
	'extdist-svn-parse-error' => 'Không thể xử lý XML từ "svn info": <pre>$1</pre>',
	'extdist-tar-error' => 'Tar trả về mã thoát $1:',
	'extdist-created' => "Ảnh của phiên bản <b>$2</b> của bộ mở rộng <b>$1</b> dành cho MediaWiki <b>$3</b> đã được tạo ra. Nó sẽ được tự động bắt đầu trong 5 giây nữa.

Địa chỉ URL của ảnh này là:
:$4
Nó có thể được dùng để tải trực tiếp về máy chủ, nhưng xin đừng đánh dấu trang (bookmark) nó, vì nội dung co thể sẽ không được cập nhật, và nó có thể bị xóa sau vài ngày nữa.

Tập tin lưu trữ tar nên được bung vào thư mục chứa bộ mở rộng của bạn. Ví dụ, trên hệ điều hành tương tự Unix:

<pre>
tar -xzf $5 -C /var/www/mediawiki/extensions
</pre>

Trên Windows, bạn có thể sử dụng [http://www.7-zip.org/ 7-zip] để giải nén các tập tin.

Nếu wiki của bạn nằm ở máy chủ từ xa, hãy bung các tập tin đó vào một thư mục tạm trên máy tính hiện tại của bạn, rồi sau đó tải '''tất cả''' các tập tin đã giải nén lên thư mục chứa bộ mở rộng trên máy chủ.

Chú ý rằng một số bộ mở rộng cần một tập tin có tên ExtensionFunctions.php, nằm tại <tt>extensions/ExtensionFunctions.php</tt>, tức là, trong thư mục ''cha'' của thư mục chứa bộ mở rộng nào đó. Ảnh của các bộ mở rộng này có chứa tập này dưới dạng tarbomb, được giải nén thành ./ExtensionFunctions.php. Đừng quên tải tập tin này lên máy chủ từ xa của bạn.

Sau khi đã giải nén tập tin, bạn sẽ cần phải đăng ký bộ mở rộng trong LocalSettings.php. Tài liệu đi kèm với bộ mở rộng sẽ có những hướng dẫn về cách thực hiện điều này.

Nếu bạn có câu hỏi nào về hệ thống phân phối bộ mở rộng này, xin đi đến [[Extension talk:ExtensionDistributor]].",
	'extdist-want-more' => 'Lấy một bộ mở rộng khác',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'extensiondistributor' => '下載MediaWiki擴展',
	'extdist-desc' => '發佈擴展歸檔映像嘅擴展',
	'extdist-not-configured' => '請設定 $wgExtDistTarDir 同 $wgExtDistWorkingCopy',
	'extdist-wc-missing' => '已經設定咗嘅工作複本目錄唔存在！',
	'extdist-no-such-extension' => '無呢個擴展 "$1"',
	'extdist-no-such-version' => '個擴展 "$1" 唔存在於呢個版本 "$2" 度。',
	'extdist-choose-extension' => '揀你要去下載嘅擴展:',
	'extdist-wc-empty' => '設定咗嘅工作複本目錄無可發佈嘅擴展！',
	'extdist-submit-extension' => '繼續',
	'extdist-current-version' => '現時版本 (trunk)',
	'extdist-choose-version' => '
<big>你而家下載緊 <b>$1</b> 擴展。</big>

揀你要嘅 MediaWiki 版本。

多數嘅擴展都可以響多個 MediaWiki 嘅版本度行到，噉如果你嘅 MediaWiki 版本唔響度，又或者你需要最新嘅擴展功能嘅話，試吓用最新嘅版本。',
	'extdist-no-versions' => '所揀嘅擴展 ($1) 不適用於任何嘅版本！',
	'extdist-submit-version' => '繼續',
	'extdist-no-remote' => '唔能夠聯絡遠端 subversion 客戶端。',
	'extdist-remote-error' => '自遠端 subversion 客戶端嘅錯誤: <pre>$1</pre>',
	'extdist-remote-invalid-response' => '自遠端 subversion 客戶端嘅無效回應。',
	'extdist-svn-error' => 'Subversion 遇到一個錯誤: <pre>$1</pre>',
	'extdist-svn-parse-error' => '唔能夠處理 "svn info" 嘅 XML: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar 回應結束碼 $1:',
	'extdist-created' => "一個可供 MediaWiki <b>$3</b> 用嘅 <b>$1</b> 擴展之 <b>$2</b> 版本嘅映像已經整好咗。你嘅下載將會響5秒鐘之後自動開始。

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

如果你有任何對於呢個擴展發佈系統有問題嘅話，請去[[Extension talk:ExtensionDistributor]]。",
	'extdist-want-more' => '攞另一個擴展',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author Shinjiman
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'extensiondistributor' => '下载MediaWiki扩展',
	'extdist-desc' => '发布扩展存档映像的扩展',
	'extdist-not-configured' => '请设置 $wgExtDistTarDir 和 $wgExtDistWorkingCopy',
	'extdist-wc-missing' => '已经设置的工作复本目录不存在！',
	'extdist-no-such-extension' => '没有这个扩展 "$1"',
	'extdist-no-such-version' => '该扩展 "$1" 不存在于这个版本 "$2" 中。',
	'extdist-choose-extension' => '选择您要去下载的扩展:',
	'extdist-wc-empty' => '设置的工作复本目录无可发布之扩展！',
	'extdist-submit-extension' => '继续',
	'extdist-current-version' => '开发版本（trunk）',
	'extdist-choose-version' => '
<big>您现正下载 <b>$1</b> 扩展。</big>

选择您要的 MediaWiki 版本。

多数的扩展都可以在多个 MediaWiki 版本上运行，如果您的 MediaWiki 版本不存在，又或者您需要最新的扩展功能的话，可尝试用最新的版本。',
	'extdist-no-versions' => '所选择扩展 （$1） 不适用于任何的版本！',
	'extdist-submit-version' => '继续',
	'extdist-no-remote' => '不能够联络远端 subversion 客户端。',
	'extdist-remote-error' => '自远端 subversion 客户端的错误: <pre>$1</pre>',
	'extdist-remote-invalid-response' => '自远端 subversion 客户端的无效反应。',
	'extdist-svn-error' => 'Subversion 遇到一个错误: <pre>$1</pre>',
	'extdist-svn-parse-error' => '不能够处理 "svn info" 之 XML: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar 反应结束码 $1:',
	'extdist-created' => "一个可供 MediaWiki <b>$3</b> 使用的 <b>$1</b> 扩展之 <b>$2</b> 版本的映像已经建立。您的下载将会在5秒钟之后自动开始。

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

如果您有任何对于这个扩展发布系统有问题的话，请去[[Extension talk:ExtensionDistributor]]。",
	'extdist-want-more' => '取另一个扩展',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'extensiondistributor' => '下載MediaWiki擴展',
	'extdist-desc' => '發佈擴展存檔映像的擴展',
	'extdist-not-configured' => '請設定 $wgExtDistTarDir 和 $wgExtDistWorkingCopy',
	'extdist-wc-missing' => '已經設定的工作複本目錄不存在！',
	'extdist-no-such-extension' => '沒有這個擴展 "$1"',
	'extdist-no-such-version' => '該擴展 "$1" 不存在於這個版本 "$2" 中。',
	'extdist-choose-extension' => '選擇您要去下載的擴展:',
	'extdist-wc-empty' => '設定的工作複本目錄無可發佈之擴展！',
	'extdist-submit-extension' => '繼續',
	'extdist-current-version' => '開發版本（trunk）',
	'extdist-choose-version' => '
<big>您現正下載 <b>$1</b> 擴展。</big>

選擇您要的 MediaWiki 版本。

多數的擴展都可以在多個 MediaWiki 版本上運行，如果您的 MediaWiki 版本不存在，又或者您需要最新的擴展功能的話，可嘗試用最新的版本。',
	'extdist-no-versions' => '所選擇擴展 （$1） 不適用於任何的版本！',
	'extdist-submit-version' => '繼續',
	'extdist-no-remote' => '不能夠聯絡遠端 subversion 客戶端。',
	'extdist-remote-error' => '自遠端 subversion 客戶端的錯誤: <pre>$1</pre>',
	'extdist-remote-invalid-response' => '自遠端 subversion 客戶端的無效回應。',
	'extdist-svn-error' => 'Subversion 遇到一個錯誤: <pre>$1</pre>',
	'extdist-svn-parse-error' => '不能夠處理 "svn info" 之 XML: <pre>$1</pre>',
	'extdist-tar-error' => 'Tar 回應結束碼 $1:',
	'extdist-created' => "一個可供 MediaWiki <b>$3</b> 使用的 <b>$1</b> 擴展之 <b>$2</b> 版本的映像已經建立。您的下載將會在5秒鐘之後自動開始。

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

如果您有任何對於這個擴展發佈系統有問題的話，請去[[Extension talk:ExtensionDistributor]]。",
	'extdist-want-more' => '取另一個擴展',
);

