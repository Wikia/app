<?php
/**
 * Internationalisation file for extension Maintenance.
 *
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Ryan Schmidt
 */
$messages['en'] = array(
	'maintenance'                       => "Run maintenance scripts",
	'maintenance-desc'                  => '[[Special:Maintenance|Web interface]] for various maintenance scripts',
	'maintenance-backlink'              => "Back to script selection",
	'maintenance-header'                => "Please select a script below to execute.
Descriptions are next to each script",
	'maintenance-changePassword-desc'   => "Change a user's password",
	'maintenance-createAndPromote-desc' => "Create a user and promote to sysop status",
	'maintenance-deleteBatch-desc'      => "Mass-delete pages",
	'maintenance-deleteRevision-desc'   => "Remove revisions from the database",
	'maintenance-initEditCount-desc'    => "Recalculate the edit counts of users",
	'maintenance-initStats-desc'        => "Recalculate site statistics",
	'maintenance-moveBatch-desc'        => "Mass-move pages",
	'maintenance-runJobs-desc'          => "Run jobs in the job queue",
	'maintenance-showJobs-desc'         => "Show a list of jobs pending in the job queue",
	'maintenance-stats-desc'            => "Show Memcached statistics",
	'maintenance-changePassword'        => "Use this form to change a user's password",
	'maintenance-createAndPromote'      => "Use this form to create a new user and promote it to sysop.
Check the bureaucrat box if you wish to promote to bureaucrat as well",
	'maintenance-deleteBatch'           => "Use this form to mass-delete pages.
Put only one page per line",
	'maintenance-deleteRevision'        => "Use this form to mass-delete revisions.
Put only one revision number per line",
	'maintenance-initEditCount'         => "",
	'maintenance-initStats'             => "Use this form to recalculate site statistics, specifiying if you want to recalculate page views as well",
	'maintenance-moveBatch'             => "Use this form to mass-move pages.
Each line should specify a source page and destination page separated by a pipe",
	'maintenance-runJobs'               => "",
	'maintenance-showJobs'              => "",
	'maintenance-stats'                 => "",
	'maintenance-invalidtype'           => "Invalid type!",
	'maintenance-name'                  => "Username",
	'maintenance-password'              => "Password",
	'maintenance-bureaucrat'            => "Promote user to bureaucrat status",
	'maintenance-reason'                => "Reason",
	'maintenance-update'                => "Use UPDATE when updating a table? Unchecked uses DELETE/INSERT instead.",
	'maintenance-noviews'               => "Check this to prevent updating the number of pageviews",
	'maintenance-confirm'               => "Confirm",
	'maintenance-invalidname'           => "Invalid username!",
	'maintenance-success'               => "$1 ran successfully!",
	'maintenance-userexists'            => "User already exists!",
	'maintenance-invalidtitle'          => "Invalid title \"$1\"!",
	'maintenance-titlenoexist'          => "Title specified (\"$1\") does not exist!",
	'maintenance-failed'                => "FAILED",
	'maintenance-deleted'               => "DELETED",
	'maintenance-revdelete'             => "Deleting revisions $1 from wiki $2",
	'maintenance-revnotfound'           => "Revision $1 not found!",
	'maintenance-stats-edits'           => "Number of edits: $1",
	'maintenance-stats-articles'        => "Number of pages in the main namespace: $1",
	'maintenance-stats-pages'           => "Number of pages: $1",
	'maintenance-stats-users'           => "Number of users: $1",
	'maintenance-stats-admins'          => "Number of admins: $1",
	'maintenance-stats-images'          => "Number of files: $1",
	'maintenance-stats-views'           => "Number of pageviews: $1",
	'maintenance-stats-update'          => "Updating database...",
	'maintenance-move'                  => "Moving $1 to $2...",
	'maintenance-movefail'              => "Error encountered while moving: $1.
Aborting move",
	'maintenance-error'                 => "Error: $1",
	'maintenance-memc-fake'             => "You are running FakeMemCachedClient. No statistics can be provided",
	'maintenance-memc-requests'         => "Requests",
	'maintenance-memc-withsession'      => "with session:",
	'maintenance-memc-withoutsession'   => "without session:",
	'maintenance-memc-total'            => "total:",
	'maintenance-memc-parsercache'      => "Parser cache",
	'maintenance-memc-hits'             => "hits:",
	'maintenance-memc-invalid'          => "invalid:",
	'maintenance-memc-expired'          => "expired:",
	'maintenance-memc-absent'           => "absent:",
	'maintenance-memc-stub'             => "stub threshold:",
	'maintenance-memc-imagecache'       => "Image cache",
	'maintenance-memc-misses'           => "misses:",
	'maintenance-memc-updates'          => "updates:",
	'maintenance-memc-uncacheable'      => "uncacheable:",
	'maintenance-memc-diffcache'        => "Diff Cache",
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'maintenance-name'     => 'Asa',
	'maintenance-password' => 'Ou password',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'maintenance-name'     => 'Пайдаланышын лӱмжӧ',
	'maintenance-password' => 'Шолыпмут',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'maintenance-name'     => 'Matahigoa he tagata',
	'maintenance-password' => 'Kupu fufu',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 */
$messages['af'] = array(
	'maintenance-name'       => 'Gebruikersnaam',
	'maintenance-password'   => 'Wagwoord',
	'maintenance-reason'     => 'Rede',
	'maintenance-confirm'    => 'Bevestig',
	'maintenance-memc-total' => 'totaal:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'maintenance-confirm' => 'Confirmar',
);

/** Arabic (العربية)
 * @author OsamaK
 * @author Meno25
 */
$messages['ar'] = array(
	'maintenance'                       => 'تشغيل سكريبتات الصيانة',
	'maintenance-desc'                  => '[[Special:Maintenance|واجهة ويب]] لسكريبتات صيانة مختلفة',
	'maintenance-backlink'              => 'الرجوع إلى اختيار السكريبت',
	'maintenance-changePassword-desc'   => 'غير كلمة السر لمستخدم',
	'maintenance-createAndPromote-desc' => 'إنشاء مستخدم وترقية إلى حالة إداري',
	'maintenance-deleteBatch-desc'      => 'حذف كمي للصفحات',
	'maintenance-deleteRevision-desc'   => 'إزالة المراجعات من قاعدة البيانات',
	'maintenance-initEditCount-desc'    => 'إعادة حساب عدد التعديلات للمستخدمين',
	'maintenance-initStats-desc'        => 'إعادة حساب إحصاءات الموقع',
	'maintenance-moveBatch-desc'        => 'نقل كمي للصفحات',
	'maintenance-runJobs-desc'          => 'تنفيذ الأشغال في طابور الشغل',
	'maintenance-stats-desc'            => 'عرض إحصاءات ميم كاشد',
	'maintenance-changePassword'        => 'استخدم هذه الاستمارة لتغيير كلمة السر لمستخدم',
	'maintenance-deleteBatch'           => 'استخدم هذه الإستمارة لحذف الصفحات بشكل كمي.
ضع فقط صفحة واحدة في كل سطر',
	'maintenance-deleteRevision'        => 'استخدم هذه الإستمارة لحذف المراجعات بشكل كمي.
ضع فقط رقم مراجعة واحد في كل سطر',
	'maintenance-invalidtype'           => 'نوع غير صحيح!',
	'maintenance-name'                  => 'اسم مستخدم',
	'maintenance-password'              => 'كلمة السر',
	'maintenance-bureaucrat'            => 'ترقية مستخدم إلى حالة بيروقراط',
	'maintenance-reason'                => 'سبب',
	'maintenance-noviews'               => 'علم على هذا لمنع تحديث عدد عرض الصفحات',
	'maintenance-confirm'               => 'تأكيد',
	'maintenance-invalidname'           => 'اسم مستخدم غير صحيح!',
	'maintenance-success'               => '$1 عمل بنجاح!',
	'maintenance-userexists'            => 'المستخدم موجود حاليا!',
	'maintenance-invalidtitle'          => 'عنوان غير صحيح "$1"!',
	'maintenance-failed'                => 'فشل',
	'maintenance-deleted'               => 'حُذف',
	'maintenance-revdelete'             => 'حذف المراجعات $1 من الويكي $2',
	'maintenance-revnotfound'           => 'المراجعة $1 لم يتم العثور عليها!',
	'maintenance-stats-edits'           => 'عدد التعديلات: $1',
	'maintenance-stats-articles'        => 'عدد الصفحات في النطاق الرئيسي: $1',
	'maintenance-stats-pages'           => 'عدد الصفحات: $1',
	'maintenance-stats-users'           => 'عدد المستخدمين: $1',
	'maintenance-stats-admins'          => 'عدد الإداريين: $1',
	'maintenance-stats-images'          => 'عدد الملفات: $1',
	'maintenance-stats-views'           => 'عدد مرات عرض الصفحة: $1',
	'maintenance-stats-update'          => 'جاري تحديث قاعدة البيانات...',
	'maintenance-move'                  => 'نقل $1 إلى $2...',
	'maintenance-error'                 => 'خطأ: $1',
	'maintenance-memc-requests'         => 'طلبات',
	'maintenance-memc-withsession'      => 'مع جلسة:',
	'maintenance-memc-withoutsession'   => 'بدون جلسة:',
	'maintenance-memc-total'            => 'مجموع:',
	'maintenance-memc-parsercache'      => 'كاش المحلل',
	'maintenance-memc-hits'             => 'ضربات:',
	'maintenance-memc-invalid'          => 'غير صحيح:',
	'maintenance-memc-expired'          => 'انتهى:',
	'maintenance-memc-absent'           => 'غائب:',
	'maintenance-memc-stub'             => 'الحد للبذرة:',
	'maintenance-memc-imagecache'       => 'كاش الصورة',
	'maintenance-memc-misses'           => 'مفقودات:',
	'maintenance-memc-updates'          => 'تحديثات:',
	'maintenance-memc-uncacheable'      => 'لا يمكن تخزينه:',
	'maintenance-memc-diffcache'        => 'كاش الفرق',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'maintenance-reason' => 'Прычына',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'maintenance'                       => 'Пускане на скриптове за поддръжка',
	'maintenance-desc'                  => '[[Special:Maintenance|Уеб интерфейс]] за различни скриптове за поддръжка',
	'maintenance-backlink'              => 'Връщане към избора на скрипт',
	'maintenance-changePassword-desc'   => 'Променяне на потребителска парола',
	'maintenance-createAndPromote-desc' => 'Създаване на потребител и даване на администраторски права',
	'maintenance-deleteBatch-desc'      => 'Масово изтриване на страници',
	'maintenance-deleteRevision-desc'   => 'Премахване на версии от базата от данни',
	'maintenance-initEditCount-desc'    => 'Преизчисляване на броя редакции, направени от потребителите',
	'maintenance-initStats-desc'        => 'Опресняване на статистиките на сайта',
	'maintenance-moveBatch-desc'        => 'Масово преместване на страници',
	'maintenance-changePassword'        => 'Формулярът по-долу се използва за промяна на паролата на потребител',
	'maintenance-createAndPromote'      => 'Следният формуляр служи за създаване на нов потребител и предоставянето му на администраторски права.
Поставянето на отметка ще добави и права на бюрократ.',
	'maintenance-deleteBatch'           => 'Този формуляр служи за масово изтриване на страници.
Всеки ред трябва да съдържа по една страница',
	'maintenance-deleteRevision'        => 'Този формуляр служи за масово изтриване на версии.
Всеки ред трябва да съдържа по един номер на версия',
	'maintenance-moveBatch'             => 'Този формуляр служи за масово преместване на страници.
Всеки ред трябва да съдържа основна страница и целева страница, разделени с отвесна черта',
	'maintenance-invalidtype'           => 'Невалиден тип!',
	'maintenance-name'                  => 'Потребителско име',
	'maintenance-password'              => 'Парола',
	'maintenance-bureaucrat'            => 'Предоставяне на права на бюрократ',
	'maintenance-reason'                => 'Причина',
	'maintenance-update'                => 'Използване на UPDATE при обновяване на таблиците? Без отметка се използва DELETE/INSERT.',
	'maintenance-noviews'               => 'Поставянето на отметка ще спре обновяването на броя прегледи на страниците',
	'maintenance-confirm'               => 'Потвърждаване',
	'maintenance-invalidname'           => 'Невалидно потребителско име!',
	'maintenance-success'               => '$1 беше изпълнен успешно!',
	'maintenance-userexists'            => 'Този потребител вече съществува!',
	'maintenance-invalidtitle'          => 'Невалидно заглавие „$1“!',
	'maintenance-titlenoexist'          => 'Посоченото заглавие („$1“) не съществува!',
	'maintenance-revdelete'             => 'Изтриване на версии $1 от уики $2',
	'maintenance-revnotfound'           => 'Версия $1 не беше намерена!',
	'maintenance-stats-edits'           => 'Брой редакции: $1',
	'maintenance-stats-articles'        => 'Брой страници в основното именно пространство: $1',
	'maintenance-stats-pages'           => 'Брой страници: $1',
	'maintenance-stats-users'           => 'Брой потребители: $1',
	'maintenance-stats-admins'          => 'Брой администратори: $1',
	'maintenance-stats-images'          => 'Брой файлове: $1',
	'maintenance-stats-views'           => 'Брой прегледи на страниците: $1',
	'maintenance-stats-update'          => 'Обновяване на базата от данни...',
	'maintenance-move'                  => 'Преместване на $1 като $2...',
	'maintenance-movefail'              => 'Възникна грешка при преместване: $1.
Прекратяване на преместването.',
	'maintenance-error'                 => 'Грешка: $1',
	'maintenance-memc-requests'         => 'Заявки',
	'maintenance-memc-total'            => 'общо:',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'maintenance-name' => 'по́льꙃєватєлꙗ и́мѧ',
);

/** German (Deutsch)
 * @author DaSch
 */
$messages['de'] = array(
	'maintenance'                     => 'Wartungs-Skript starten',
	'maintenance-desc'                => '[[Special:Maintenance|Web-Interface]] für verschiedene Wartungs-Skripts',
	'maintenance-backlink'            => 'Zurück zur Skript-Auswahl',
	'maintenance-deleteRevision-desc' => 'Revisionen aus der Datenbank entfernen',
	'maintenance-runJobs-desc'        => 'Aufträge in Warteschlange ausführen',
	'maintenance-name'                => 'Benutzername',
	'maintenance-password'            => 'Passwort',
	'maintenance-reason'              => 'Grund',
	'maintenance-confirm'             => 'Bestätigen',
	'maintenance-userexists'          => 'Benutzer existiert bereits!',
	'maintenance-failed'              => 'Fehlgeschlagen',
	'maintenance-deleted'             => 'GELÖSCHT',
	'maintenance-stats-edits'         => 'Anzahl an Bearbeitungen: $1',
	'maintenance-stats-pages'         => 'Anzahl an Seiten: $1',
	'maintenance-stats-users'         => 'Anzahl an Benutzern: $1',
	'maintenance-stats-admins'        => 'Anzahl an Administratoren: $1',
	'maintenance-stats-images'        => 'Anzahl an Dateien: $1',
	'maintenance-stats-views'         => 'Anzahl an Seitenaufrufen: $1',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'maintenance-password' => 'Κωδικός',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'maintenance-changePassword-desc' => 'Ŝangi pasvorton de uzanto',
	'maintenance-deleteBatch-desc'    => 'Amasforigi paĝojn',
	'maintenance-invalidtype'         => 'Nevalida speco!',
	'maintenance-name'                => 'Salutnomo',
	'maintenance-password'            => 'Pasvorto',
	'maintenance-reason'              => 'Kialo',
	'maintenance-confirm'             => 'Konfirmi',
	'maintenance-invalidname'         => 'Nevalida salutnomo!',
	'maintenance-invalidtitle'        => 'Nevalida titolo "$1"!',
	'maintenance-stats-edits'         => 'Nombro de redaktoj: $1',
	'maintenance-stats-users'         => 'Nombro de uzantoj: $1',
	'maintenance-stats-admins'        => 'Nombro de administrantoj: $1',
	'maintenance-stats-images'        => 'Nombro de dosieroj: $1',
	'maintenance-stats-views'         => 'Nombro de paĝvidoj: $1',
	'maintenance-stats-update'        => 'Ĝisdatigante datumbazon...',
	'maintenance-error'               => 'Eraro: $1',
	'maintenance-memc-requests'       => 'Petoj',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 */
$messages['fi'] = array(
	'maintenance-changePassword-desc'   => 'Muuta käyttäjän salasana',
	'maintenance-createAndPromote-desc' => 'Luo käyttäjä ja lisää ylläpitäjäksi',
	'maintenance-deleteBatch-desc'      => 'Massapoista sivuja',
	'maintenance-deleteRevision-desc'   => 'Poista versioita tietokannasta',
	'maintenance-initEditCount-desc'    => 'Laske uudelleen käyttäjien muokkausmäärät',
	'maintenance-initStats-desc'        => 'Laske sivuston tilastot uudelleen',
	'maintenance-moveBatch-desc'        => 'Massasiirrä sivuja',
	'maintenance-runJobs-desc'          => 'Aja työt ohjelmiston ylläpitotyöjonosta',
	'maintenance-changePassword'        => 'Vaihda käyttäjän salasana tällä lomakkeella',
	'maintenance-name'                  => 'Käyttäjätunnus',
	'maintenance-password'              => 'Salasana',
	'maintenance-reason'                => 'Syy',
	'maintenance-confirm'               => 'Vahvista',
	'maintenance-invalidname'           => 'Virheellinen käyttäjätunnus.',
	'maintenance-success'               => '$1 ajettiin onnistuneesti.',
	'maintenance-userexists'            => 'Käyttäjä on jo olemassa.',
	'maintenance-failed'                => 'EPÄONNISTUI',
	'maintenance-deleted'               => 'POISTETTU',
	'maintenance-revnotfound'           => 'Versiota $1 ei löydy.',
	'maintenance-stats-edits'           => 'Muokkauksia yhteensä: $1',
	'maintenance-stats-pages'           => 'Sivuja yhteensä: $1',
	'maintenance-stats-users'           => 'Käyttäjiä yhteensä: $1',
	'maintenance-stats-admins'          => 'Ylläpitäjiä yhteensä: $1',
	'maintenance-stats-images'          => 'Tiedostoja yhteensä: $1',
	'maintenance-stats-views'           => 'Sivuja näytetty yhteensä: $1',
	'maintenance-stats-update'          => 'Päivitetään tietokantaa...',
	'maintenance-move'                  => 'Siirretään $1 nimelle $2...',
	'maintenance-error'                 => 'Virhe: $1',
);

/** French (Français)
 * @author Grondin
 * @author Verdy p
 */
$messages['fr'] = array(
	'maintenance'                       => 'Lancer les scripts de maintenance',
	'maintenance-desc'                  => '[[Special:Maintenance|Interface Web]] pour divers scripts de maintenance',
	'maintenance-backlink'              => 'Retour à la sélection du script',
	'maintenance-header'                => 'Veuillez sélectionnez, ci-dessous, un script à exécuter.
Les descriptions sont à la suite de chacun de ceux-ci.',
	'maintenance-changePassword-desc'   => 'Changer le mot de passe d’un utilisateur',
	'maintenance-createAndPromote-desc' => 'Créer un utilisateur et promouvoir au statut d’administrateur',
	'maintenance-deleteBatch-desc'      => 'Suppression de pages en masse',
	'maintenance-deleteRevision-desc'   => 'Enlever des versions de la base de données',
	'maintenance-initEditCount-desc'    => 'Recalculer les compteurs de modifications des utilisateurs',
	'maintenance-initStats-desc'        => 'Recalculer les statistiques du site',
	'maintenance-moveBatch-desc'        => 'Renommage de pages en masse',
	'maintenance-runJobs-desc'          => 'Lancer les tâches dans la liste de celles à accomplir',
	'maintenance-showJobs-desc'         => 'Afficher une liste des tâches en cours dans la liste de celles à accomplir',
	'maintenance-stats-desc'            => 'Afficher les statistiques de la mémoire cache',
	'maintenance-changePassword'        => 'Utiliser ce formulaire pour changer le mot de passe d’un utilisateur',
	'maintenance-createAndPromote'      => 'Utiliser ce formulaire pour créer un nouvel utilisateur et le promouvoir administrateur.
Cocher la case bureaucrate si vous désirez lui conférer aussi ce statut.',
	'maintenance-deleteBatch'           => 'Utilisez ce formulaire pour supprimer en masse des pages.
Indiquer une seule page par ligne.',
	'maintenance-deleteRevision'        => 'Utilisez ce formulaire pour supprimer en masse des versions.
Indiquez une seule version par ligne.',
	'maintenance-initStats'             => 'Utilisez ce formulaire pour recalculer les statistiques du site, en indiquant, le cas échéant, si vous désirez le recalcul du nombre de visites par page.',
	'maintenance-moveBatch'             => 'Utilisez ce formulaire pour déplacer en masse des pages.
Chaque ligne devra indiquer la page d’origine et celle de destination, lesquelles devront être séparées par un « <nowiki>|</nowiki> »',
	'maintenance-invalidtype'           => 'Type incorrect !',
	'maintenance-name'                  => 'Nom d’utilisateur',
	'maintenance-password'              => 'Mot de passe',
	'maintenance-bureaucrat'            => 'Promouvoir l’utilisateur au statut de bureaucrate',
	'maintenance-reason'                => 'Motif',
	'maintenance-update'                => "Voulez-vous utiliser la méthode ''UPDATE'' pour la mise à jour directe d’une table ? Décochez l’option pour utiliser plutôt ''DELETE/INSERT'' (suppression puis réinsertion).",
	'maintenance-noviews'               => 'Cocher ceci pour empêcher la mise à jour du nombre de visites des pages.',
	'maintenance-confirm'               => 'Confirmer',
	'maintenance-invalidname'           => 'Nom d’utilisateur incorrect !',
	'maintenance-success'               => '$1 s’est déroulé avec succès !',
	'maintenance-userexists'            => 'L’utilisateur existe déjà !',
	'maintenance-invalidtitle'          => 'Titre incorrect « $1 » !',
	'maintenance-titlenoexist'          => 'Le titre indiqué (« $1 ») n’existe pas !',
	'maintenance-failed'                => 'ÉCHEC',
	'maintenance-deleted'               => 'SUPPRIMÉ',
	'maintenance-revdelete'             => 'Suppression des versions $1 du wiki $2',
	'maintenance-revnotfound'           => 'Version $1 introuvable !',
	'maintenance-stats-edits'           => 'Nombre de modifications : $1',
	'maintenance-stats-articles'        => 'Nombre de pages dans l’espace principal : $1',
	'maintenance-stats-pages'           => 'Nombre de pages : $1',
	'maintenance-stats-users'           => 'Nombre d’utilisateurs : $1',
	'maintenance-stats-admins'          => 'Nombre d’administrateurs : $1',
	'maintenance-stats-images'          => 'Nombre de fichiers : $1',
	'maintenance-stats-views'           => 'Nombre de pages visitées : $1',
	'maintenance-stats-update'          => 'Mise à jour de la base de données...',
	'maintenance-move'                  => 'Déplacement de $1 vers $2...',
	'maintenance-movefail'              => 'Erreur survenue lors du renommage : $1.
Déplacement interrompu.',
	'maintenance-error'                 => 'Erreur : $1',
	'maintenance-memc-fake'             => "Vous utilisez ''FakeMemCachedClient''. Aucune statistique ne sera fournie.",
	'maintenance-memc-requests'         => 'Requêtes',
	'maintenance-memc-withsession'      => 'avec la session :',
	'maintenance-memc-withoutsession'   => 'sans la session :',
	'maintenance-memc-total'            => 'total :',
	'maintenance-memc-parsercache'      => 'Cache parseur',
	'maintenance-memc-hits'             => 'clics :',
	'maintenance-memc-invalid'          => 'incorrects :',
	'maintenance-memc-expired'          => 'expirés :',
	'maintenance-memc-absent'           => 'absents :',
	'maintenance-memc-stub'             => 'seuil de départ :',
	'maintenance-memc-imagecache'       => 'Cache image',
	'maintenance-memc-misses'           => 'perdus :',
	'maintenance-memc-updates'          => 'mis à jour :',
	'maintenance-memc-uncacheable'      => 'hors cache :',
	'maintenance-memc-diffcache'        => 'Cache des diff',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'maintenance'                       => 'Executar as escrituras de mantemento',
	'maintenance-desc'                  => '[[Special:Maintenance|Interface da web]] para diversas escrituras de mantemento',
	'maintenance-backlink'              => 'Voltar á selección de escrituras',
	'maintenance-header'                => 'Por favor, seleccione a escritura de embaixo que queira executar.
As descricións están ao lado de cada escritura',
	'maintenance-changePassword-desc'   => 'Cambiar o contrasinal dun usuario',
	'maintenance-createAndPromote-desc' => 'Crear un usuario e promovelo ao status de administrador',
	'maintenance-deleteBatch-desc'      => 'Borrar páxinas masivamente',
	'maintenance-deleteRevision-desc'   => 'Borrar revisións da base de datos',
	'maintenance-initEditCount-desc'    => 'Volver calcular o contador de edicións dos usuarios',
	'maintenance-initStats-desc'        => 'Volver calcular as estatísticas do sitio',
	'maintenance-moveBatch-desc'        => 'Mover páxinas masivamente',
	'maintenance-runJobs-desc'          => 'Executar os traballos na cola de traballo',
	'maintenance-showJobs-desc'         => 'Amosar a listaxe dos traballos pendentes na cola de traballo',
	'maintenance-stats-desc'            => 'Amosar as estatísticas da memoria caché',
	'maintenance-changePassword'        => 'Use este formulario para cambiar o contrasinal dun usuario',
	'maintenance-createAndPromote'      => 'Use este formulario para crear un novo usuario e promovelo ao status de administrador.
Comprobe a caixa de burócrata se quere tamén promovelo ao status de burócrata',
	'maintenance-deleteBatch'           => 'Use este formulario para borrar revisións en masa.
Poña só unha páxina por liña',
	'maintenance-deleteRevision'        => 'Use este formulario para borrar revisións en masa.
Poña só un número de revisión por liña',
	'maintenance-initStats'             => 'Use este formulario para volver calcular as estatíticas do sitio, especificando se tamén quere calcular de novo os visionados por páxina',
	'maintenance-moveBatch'             => 'Use este formulario para mover páxinas en masa.
Cada liña debería especificar unha fonte e destino da páxina separados por unha barra (“|”)',
	'maintenance-invalidtype'           => 'Tipo inválido!',
	'maintenance-name'                  => 'Nome de usuario',
	'maintenance-password'              => 'Contrasinal',
	'maintenance-bureaucrat'            => 'Promover este usuario ao status de burócrata',
	'maintenance-reason'                => 'Razón',
	'maintenance-update'                => 'Desexa usar ACTUALIZAR ao actualizar unha táboa? Se non marca a opción, usarase, no canto diso, BORRAR/INSERTAR.',
	'maintenance-noviews'               => 'Comprove isto para previr a actualización do número de visionados por páxina',
	'maintenance-confirm'               => 'Confirmar',
	'maintenance-invalidname'           => 'Nome de usuario inválido!',
	'maintenance-success'               => '$1 executouse con éxito!',
	'maintenance-userexists'            => 'O usuario xa existe!',
	'maintenance-invalidtitle'          => 'Título inválido "$1"!',
	'maintenance-titlenoexist'          => 'O título especificado ("$1") non existe!',
	'maintenance-failed'                => 'FALLIDO',
	'maintenance-deleted'               => 'BORRADO',
	'maintenance-revdelete'             => 'Eliminando as revisións $1 do wiki $2',
	'maintenance-revnotfound'           => 'A revisión $1 non foi atopada!',
	'maintenance-stats-edits'           => 'Número de edicións: $1',
	'maintenance-stats-articles'        => 'Número de páxinas no espazo de nomes principal: $1',
	'maintenance-stats-pages'           => 'Número de páxinas: $1',
	'maintenance-stats-users'           => 'Número de usuarios: $1',
	'maintenance-stats-admins'          => 'Número de administradores: $1',
	'maintenance-stats-images'          => 'Número de ficheiros: $1',
	'maintenance-stats-views'           => 'Número de visionados por páxina: $1',
	'maintenance-stats-update'          => 'Actualizando a base de datos...',
	'maintenance-move'                  => 'Movendo "$1" a "$2"...',
	'maintenance-movefail'              => 'Produciuse un erro durante o movemento: $1.
Cancelando a operación',
	'maintenance-error'                 => 'Erro: $1',
	'maintenance-memc-fake'             => 'Está executando FakeMemCachedClient. As estatísticas non poden ser amosadas',
	'maintenance-memc-requests'         => 'Solicitudes',
	'maintenance-memc-withsession'      => 'con sesión:',
	'maintenance-memc-withoutsession'   => 'sen sesión:',
	'maintenance-memc-total'            => 'total:',
	'maintenance-memc-parsercache'      => 'Analizador da memoria caché',
	'maintenance-memc-hits'             => 'éxitos:',
	'maintenance-memc-invalid'          => 'inválido:',
	'maintenance-memc-expired'          => 'remata:',
	'maintenance-memc-absent'           => 'falta:',
	'maintenance-memc-stub'             => 'bosquexo:',
	'maintenance-memc-imagecache'       => 'Imaxe da memoria caché',
	'maintenance-memc-misses'           => 'perdas:',
	'maintenance-memc-updates'          => 'actualizacións:',
	'maintenance-memc-uncacheable'      => 'non se pode comprobar a caché:',
	'maintenance-memc-diffcache'        => 'Diferenza na memoria caché',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'maintenance-reason' => 'Kumu',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'maintenance-name'     => 'Nomine de usator',
	'maintenance-password' => 'Contrasigno',
	'maintenance-reason'   => 'Motivo',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'maintenance-name'       => 'Nama pengguna',
	'maintenance-reason'     => 'Alasan',
	'maintenance-memc-total' => 'total:',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'maintenance-password' => 'Lykilorð',
);

/** Italian (Italiano)
 * @author Pietrodn
 */
$messages['it'] = array(
	'maintenance-name' => 'Nome utente',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author Lovekhmer
 */
$messages['km'] = array(
	'maintenance-changePassword-desc' => 'ប្តូរពាក្យសំងាត់របស់អ្នកប្រើប្រាស់',
	'maintenance-name'                => 'អ្នកប្រើប្រាស់',
	'maintenance-password'            => 'ពាក្យសំងាត់',
	'maintenance-reason'              => 'មូលហេតុ',
	'maintenance-confirm'             => 'អះអាង',
	'maintenance-invalidname'         => 'អ្នកប្រើប្រាស់មិនត្រឹមត្រូវ!',
	'maintenance-userexists'          => 'អ្នកប្រើប្រាស់មានរួចជាស្រេចហើយ!',
	'maintenance-stats-edits'         => 'ចំនួនកំនែប្រែ៖ $1',
	'maintenance-stats-pages'         => 'ចំនួនទំព័រ: $1',
	'maintenance-stats-users'         => 'ចំនួនអ្នកប្រើប្រាស់: $1',
	'maintenance-stats-admins'        => 'ចំនួនអ្នកថែទាំប្រព័ន្ធ: $1',
	'maintenance-stats-images'        => 'ចំនួនឯកសារ: $1',
	'maintenance-move'                => 'កំពុងប្តូរទីតាំង$1ទៅ$2...',
	'maintenance-error'               => 'កំហុស: $1',
	'maintenance-memc-total'          => 'សរុប:',
);

/** Korean (한국어)
 * @author Ficell
 */
$messages['ko'] = array(
	'maintenance-password' => '비밀번호',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'maintenance'                       => 'Waadongsprojramme loufe lohße',
	'maintenance-desc'                  => '[[Special:Maintenance|Web Engerfäjß]] för divärse Waadongsprojramme',
	'maintenance-backlink'              => 'Zoröck zom Projramm-Wähle',
	'maintenance-header'                => 'Donn hee e Projramm ußsööke wat De loufe lohße wells.
Näve dä Projramme es koot jesaat, wat se donn.',
	'maintenance-changePassword-desc'   => 'Ennem Metmaacher sing Paßwoot ändere',
	'maintenance-createAndPromote-desc' => 'Don ene Metmaacher aanlääje un zom Wiki-Köbes maache',
	'maintenance-deleteBatch-desc'      => 'Massehaff Sigge fottschmiiße',
	'maintenance-deleteRevision-desc'   => 'Sigge-Versione uß de Datebank schmiiße',
	'maintenance-initEditCount-desc'    => 'Ennem Metmaacher sing Aanzahl Sigge-Änderonge neu ußzälle',
	'maintenance-initStats-desc'        => 'De Sigge ier Statistike neu ußzälle',
	'maintenance-moveBatch-desc'        => 'Messehaff Sigge ömnänne',
	'maintenance-runJobs-desc'          => 'Opjaave uß de Leß aanshtüße, dat jetz jedonn wääde',
	'maintenance-showJobs-desc'         => 'De Leß met de Opjave aanzeije',
	'maintenance-stats-desc'            => 'Zeich de Statistike vom <tt>Memcached</tt>',
	'maintenance-changePassword'        => 'Ennem Medmaacher sing Passwoot övver e Formular änndere',
	'maintenance-name'                  => 'Metmaacher Name',
	'maintenance-password'              => 'Passwood',
	'maintenance-bureaucrat'            => 'Mach enne Bürrokrad uß ennem Metmaacher',
	'maintenance-reason'                => 'Jrond oddo Aanlaß',
	'maintenance-update'                => 'Met Höksche: bruch <span style="text-transform:uppercase">update</span> wann de Tabäll jänndert wede soll. Ohne Höksche: nemm <span style="text-transform:uppercase">delete</span> odder <span style="text-transform:uppercase">insert</span> doför.',
	'maintenance-invalidname'           => 'Der Metmaacher kenne mer nit!',
	'maintenance-success'               => '„$1“ es met Erfolch jeloufe!',
	'maintenance-userexists'            => 'Dä Metmaacher jidd_et ald!',
	'maintenance-failed'                => '<span style="text-transform:uppercase">donevve jejange</span>',
	'maintenance-deleted'               => '<span style="text-transform:uppercase">fottjeschmesse</span>',
	'maintenance-revnotfound'           => 'En Version $1 hammer nit jefonge!',
	'maintenance-stats-edits'           => 'Aanzahl Sigge-Änderonge: $1',
	'maintenance-stats-articles'        => 'Aanzahl Sigge em Appachtemang met de Atikele: $1',
	'maintenance-stats-pages'           => 'Aanzahl Sigge: $1',
	'maintenance-stats-users'           => 'Aanzahl Metmaacher: $1',
	'maintenance-stats-admins'          => 'Aanzahl Wiki-Köbesse: $1',
	'maintenance-stats-images'          => 'Aanzahl Dateie: $1',
	'maintenance-stats-views'           => 'Aanzahl Sigge-Afroofe: $1',
	'maintenance-stats-update'          => 'Ben de Datebank am ändere&nbsp;…',
	'maintenance-move'                  => 'Ben „$1“ op „$2“ aam Ömenne&nbsp;…',
	'maintenance-error'                 => 'Fähler: $1',
	'maintenance-memc-fake'             => 'Ühr hat der <code>FakeMemCachedClient</code> am Loufe. Do jidd_et kein Statistike för.',
	'maintenance-memc-total'            => 'Zosamme:',
	'maintenance-memc-hits'             => 'Treffer:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'maintenance'                     => 'Maintenance-Skripten ausféieren',
	'maintenance-desc'                => '[[Special:Maintenance|Web interface]] fir verschidde Maintenance-Skripten',
	'maintenance-backlink'            => "Zréck op d'Auswiel vum Script",
	'maintenance-changePassword-desc' => 'Engem Benotzer säi Passwuert änneren',
	'maintenance-deleteBatch-desc'    => 'Vill Säite matenee läschen',
	'maintenance-deleteRevision-desc' => 'Versiounen aus der Datebank eraushuelen',
	'maintenance-initEditCount-desc'  => "D'Compteuren vun den Ännerunge vun de Benotzer nei berechnen",
	'maintenance-initStats-desc'      => "D'Statistike vum Site neiberechnen",
	'maintenance-moveBatch-desc'      => 'Vill Säite matenee réckelen',
	'maintenance-showJobs-desc'       => "Weis d'Lësccht vun den Aarbechten déi nach an der ''Queue'' stinn",
	'maintenance-stats-desc'          => 'Statistiken vun der Cache Memoire weisen',
	'maintenance-changePassword'      => "Dëse Formulaire benotze fir engem Benotzer säi Passwuert z'änneren",
	'maintenance-deleteBatch'         => 'Dëse Formulaire benotzen fir eng Rei vu Säiten ze läschen.
Nëmmen eng Säit pro Linn aginn.',
	'maintenance-deleteRevision'      => 'Benotzt dëse Formulaire fir vill Versioune mateneen ze läschen.
Schreiwt an all Linn just eng Versioun.',
	'maintenance-name'                => 'Benotzernumm',
	'maintenance-password'            => 'Passwuert',
	'maintenance-bureaucrat'          => 'Engem Benotzer de Bürokrate-Status ginn',
	'maintenance-reason'              => 'Grond',
	'maintenance-confirm'             => 'Confirméieren',
	'maintenance-invalidname'         => 'Ongëltege Benotzernumm!',
	'maintenance-success'             => '$1 ass gemaach ginn!',
	'maintenance-userexists'          => 'De Benotzer gëtt et schonn!',
	'maintenance-invalidtitle'        => 'Ongëltegen Titel "$1"!',
	'maintenance-titlenoexist'        => 'Den Titel den dir uginn hutt ("$1") gëtt et net!',
	'maintenance-failed'              => 'Huet net fonctionnéiert',
	'maintenance-deleted'             => 'GELÄSCHT',
	'maintenance-revdelete'           => 'Làsche vun de Versioune(n) $1 vun der Wiki $2',
	'maintenance-revnotfound'         => "D'Versioun $1 gouf net fonnt!",
	'maintenance-stats-edits'         => 'Zuel vun den Ännerungen: $1',
	'maintenance-stats-articles'      => 'Zuel vun de Säiten am Haaptnummraum: $1',
	'maintenance-stats-pages'         => 'Zuel vun de Säiten: $1',
	'maintenance-stats-users'         => 'Zuel vun de Benotzer: $1',
	'maintenance-stats-admins'        => 'Zuel vun den Administrateuren: $1',
	'maintenance-stats-images'        => 'Zuel vun de Fichieren: $1',
	'maintenance-stats-views'         => 'Zuel vun de besichte Säiten: $1',
	'maintenance-stats-update'        => "D'Datebank gëtt aktualiséiert ...",
	'maintenance-move'                => '$1 gëtt op $2 geréckelt ...',
	'maintenance-error'               => 'Feeler: $1',
	'maintenance-memc-requests'       => 'Ufroen',
	'maintenance-memc-total'          => 'Total:',
	'maintenance-memc-absent'         => 'net do:',
	'maintenance-memc-updates'        => 'Aktualiséierungen:',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'maintenance'                       => 'പരിപാലന സ്ക്രിപ്റ്റുകള്‍ ഓടിക്കുക',
	'maintenance-desc'                  => 'വിവിധ പരിപാലന സ്ക്രിപ്റ്റുകള്‍ക്കുള്ള [[Special:Maintenance|വെബ്ബ് ഇന്റര്‍ഫേസ്]]',
	'maintenance-backlink'              => 'സ്ക്രിപ്റ്റുകളുടെ തിരഞ്ഞെടുക്കല്‍ താളിലേക്കു തിരിച്ചു പോവുക',
	'maintenance-header'                => 'പ്രവര്‍ത്തിപ്പിക്കുവാനുള്ള സ്ക്രിപ്റ്റ് താഴെ നിന്നു തിരഞ്ഞെടുക്കുക. ഓരോ സ്ക്രിപ്റ്റിനു നേരെയും അതിനെക്കുറിച്ചുള്ള വിവരണം കൊടുത്തിരിക്കുന്നു.',
	'maintenance-changePassword-desc'   => 'ഒരു ഉപയോക്താവിന്റെ രഹസ്യവാക്ക് മാറ്റുക',
	'maintenance-createAndPromote-desc' => 'ഒരു ഉഒഅയോക്താവിനെ സൃഷ്ടിച്ച് സിസോപ്പായി സ്ഥാനക്കയറ്റം നല്‍കുക',
	'maintenance-deleteBatch-desc'      => 'താലുകള്‍ കൂട്ടമായി ഒഴിവാക്കുക',
	'maintenance-deleteRevision-desc'   => 'ഡാറ്റാബേസില്‍ നിന്നു പതിപ്പുകള്‍ മാറ്റുക',
	'maintenance-initEditCount-desc'    => 'ഉപയോക്താക്കളുടെ തിരുത്തലിന്റെ എണ്ണം വീണ്ടും കണക്കുകൂട്ടുക.',
	'maintenance-initStats-desc'        => 'സൈറ്റിന്റെ സ്ഥിതിവിവരക്കണക്ക് വീണ്ടും കണക്കുകൂട്ടുക',
	'maintenance-moveBatch-desc'        => 'താളുകള്‍ കൂട്ടമായി മാറ്റുക',
	'maintenance-changePassword'        => 'ഉപയോക്താവിന്റെ രഹസ്യവാക്ക് മാറ്റാന്‍ ഈ ഫോം ഉപയോഗിക്കുക',
	'maintenance-createAndPromote'      => 'ഒരു ഉപയോക്താവിനെ ഉണ്ടാക്കി പ്രസ്തുത ഉപയോക്താവിനെ സിസോപ്പ് ആയി ഉയര്‍ത്താന്‍ ഈ ഫോം ഉപയോഗിക്കുക.
പ്രസ്തുത ഉപയോക്താവിനെ ബ്യൂറോക്രാറ്റ് ആയി കൂടെ ഉയര്‍ത്തണമെകില്‍ ബ്രൂറോക്രാറ്റിനടുത്തുള്ള ബോക്സ് തിരഞ്ഞെടുക്കുക.',
	'maintenance-deleteBatch'           => 'താളുകള്‍ കൂട്ടത്തോടെ മായ്ക്കുവാന്‍ ഈ താള്‍ ഉപയോഗിക്കുക.
ഓരോ നിരയിലും ഒരു താള്‍ മാത്രം ചേര്‍ക്കുക.',
	'maintenance-deleteRevision'        => 'പതിപ്പുകള്‍ കൂട്ടത്തോടെ മായ്ക്കുവാന്‍ ഈ താള്‍ ഉപയോഗിക്കുക.
ഓരോ നിരയിലും ഒരു പതിപ്പ് മാത്രം ചേര്‍ക്കുക.',
	'maintenance-moveBatch'             => 'താളുകളുടെ തലക്കെട്ട് കൂട്ടത്തോടെ മാറ്റുവാന്‍ ഈ താള്‍ ഉപയോഗിക്കുക. ഓരോ നിരയില്‍ ഒരു സ്രോതസ്സ് താളും പൈപ്പ് ചിഹനം ഇട്ടു വേര്‍തിരിച്ചതിനു ശേഷം അതിന്റെ ലക്ഷ്യതാളും മാത്രം ചേര്‍ക്കുക.',
	'maintenance-name'                  => 'ഉപയോക്തൃനാമം',
	'maintenance-password'              => 'രഹസ്യവാക്ക്',
	'maintenance-bureaucrat'            => 'ഉപയോക്താവിനെ ബ്യൂറോക്രാറ്റ് പദവിയിലേക്കുയര്‍ത്തുക',
	'maintenance-reason'                => 'കാരണം',
	'maintenance-confirm'               => 'സ്ഥിരീകരിക്കുക',
	'maintenance-invalidname'           => 'അസാധുവായ ഉപയോക്തൃനാമം!',
	'maintenance-success'               => '$1 വിജയകരമായി ഓടിച്ചിരിക്കുന്നു!',
	'maintenance-userexists'            => 'ഉപയോക്തനാമം നിലവിലുണ്ട്',
	'maintenance-invalidtitle'          => 'അസാധുവായ തലക്കെട്ട് "$1"!',
	'maintenance-titlenoexist'          => '("$1") എന്ന ശീര്‍ഷകത്തിലുള്ള ലേഖനം നിലവിലില്ല',
	'maintenance-failed'                => 'പരാജയപ്പെട്ടു',
	'maintenance-deleted'               => 'മായ്ച്ചു',
	'maintenance-revdelete'             => '$2 വിക്കിയില്‍ നിന്ന് $1 പതിപ്പുകള്‍ ഒഴിവാക്കുന്നു',
	'maintenance-revnotfound'           => '$1 എന്ന പതിപ്പ് കണ്ടില്ല!',
	'maintenance-stats-edits'           => 'തിരുത്തലുകളുടെ എണ്ണം: $1',
	'maintenance-stats-articles'        => 'മുഖ്യ നെയിംസ്പേസിലുള്ള താളുകളുടെ എണ്ണം: $1',
	'maintenance-stats-pages'           => 'താളുകളുടെ എണ്ണം: $1',
	'maintenance-stats-users'           => 'ഉപയോക്താക്കളുടെ എണ്ണം: $1',
	'maintenance-stats-admins'          => 'കാര്യനിര്‍‌വാഹകരുടെ എണ്ണം: $1',
	'maintenance-stats-images'          => 'പ്രമാണങ്ങളുടെ എണ്ണം: $1',
	'maintenance-stats-views'           => 'പേജ് വ്യൂവിന്റെ എണ്ണം: $1',
	'maintenance-stats-update'          => 'ഡാറ്റാബേസ് പുതുക്കുന്നു...',
	'maintenance-move'                  => '$1 നെ $2 ലേക്ക് മാറ്റുന്നു',
	'maintenance-movefail'              => 'താള്‍ മാറ്റുമ്പോള്‍ പിഴവ് സം‌ഭവിച്ചു: $1
മാറ്റം നിര്‍ത്തിവയ്ക്കുന്നു',
	'maintenance-error'                 => 'പിഴവ്: $1',
	'maintenance-memc-requests'         => 'അഭ്യര്‍ത്ഥനകള്‍',
	'maintenance-memc-withsession'      => 'സെഷനോടെ:',
	'maintenance-memc-withoutsession'   => 'സെഷനില്ലാതെ:',
	'maintenance-memc-total'            => 'മൊത്തം:',
	'maintenance-memc-invalid'          => 'അസാധു:',
	'maintenance-memc-expired'          => 'കാലാവധി:',
	'maintenance-memc-absent'           => 'അഭാവം:',
	'maintenance-memc-updates'          => 'അപ്‌ഡേറ്റ്സ്:',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'maintenance'                       => 'व्यवस्थापन स्क्रीप्ट्स चालवा',
	'maintenance-desc'                  => 'वेगवेगळ्या व्यवस्थापन स्क्रीप्ट्स करिता [[Special:Maintenance|वेब इंटरफेस]]',
	'maintenance-backlink'              => 'स्क्रीप्ट निवडीकडे परत चला',
	'maintenance-header'                => 'चालविण्यासाठी खालील एक स्क्रीप्ट निवडा.
प्रत्येक स्क्रीप्टच्या पुढे माहिती दिलेली आहे',
	'maintenance-changePassword-desc'   => 'एखाद्या सदस्याचा परवलीचा शब्द बदला',
	'maintenance-createAndPromote-desc' => 'एक सदस्य तयार करा व त्याला प्रबंधक बनवा',
	'maintenance-deleteBatch-desc'      => 'खूप पाने एकत्र वगळा',
	'maintenance-deleteRevision-desc'   => 'डाटाबेस मधून आवृत्त्या वगळा',
	'maintenance-initEditCount-desc'    => 'सदस्यांची योगदान संख्या पुन्हा मोजा',
	'maintenance-initStats-desc'        => 'सांख्यिकी पुन्हा मोजा',
	'maintenance-moveBatch-desc'        => 'खूप पाने एकत्र स्थानांतरीत करा',
	'maintenance-runJobs-desc'          => 'कार्य रांगेतील कार्ये करा',
	'maintenance-showJobs-desc'         => 'कार्य रांगेतील पूर्ण न झालेल्या कार्यांची यादी दाखवा',
	'maintenance-stats-desc'            => 'Memcached सांख्यिकी दाखवा',
	'maintenance-changePassword'        => 'हा अर्ज एखाद्या सदस्याचा परवलीचा शब्द बदलण्यासाठी वापरा',
	'maintenance-createAndPromote'      => 'हा अर्ज एखादा नवीन सदस्य बनवून त्याला प्रबंधक करण्यासाठी वापरा.
सदस्याला अधिकारी बनविण्यासाठी अधिकारी बॉक्समध्ये सुद्धा टिचकी द्या',
	'maintenance-deleteBatch'           => 'हा अर्ज एकाच वेळी अनेक पाने वगळण्यासाठी वापरा.
एका ओळीवर एकच पान लिहा',
	'maintenance-deleteRevision'        => 'हा अर्ज अनेक आवृत्त्या एकाचवेळी वगळण्यासाठी वापरा.
एका ओळीवर एकच आवृत्ती लिहा',
	'maintenance-initStats'             => 'हा अर्ज सांख्यिकी पुन्हा मोजण्यासाठी वापरा, त्यामध्ये तुम्ही पान बघण्याची सांख्यिकी सुद्धा पुन्हा मोजू शकता',
	'maintenance-moveBatch'             => 'हा अर्ज एकाचवेळी अनेक पाने स्थानांतरीत करण्यासाठी वापरा.
प्रत्येक ओळीवर स्रोत पान व लक्ष्य पान पाईप चिन्ह वापरून लिहा',
	'maintenance-invalidtype'           => 'चुकीचा प्रकार!',
	'maintenance-name'                  => 'सदस्यनाव',
	'maintenance-password'              => 'परवलीचा शब्द',
	'maintenance-bureaucrat'            => 'सदस्याला अधिकारीपद द्या',
	'maintenance-reason'                => 'कारण',
	'maintenance-update'                => 'सारणी बदलताना UPDATE चा वापर करायचा का? जर निवडले नाही तर DELETE/INSERT चा वापर होईल.',
	'maintenance-noviews'               => 'पान पहाण्याची सांख्यिकी न बदलण्यासाठी हे निवडा',
	'maintenance-confirm'               => 'निश्चित करा',
	'maintenance-invalidname'           => 'चुकीचे सदस्यनाव!',
	'maintenance-success'               => '$1 यशस्वीरित्या पूर्ण झाले!',
	'maintenance-userexists'            => 'सदस्य अगोदरच अस्तित्वात आहे!',
	'maintenance-invalidtitle'          => 'चुकीचे शीर्षक "$1"!',
	'maintenance-titlenoexist'          => 'दिलेले शीर्षक ("$1") अस्तित्वात नाही!',
	'maintenance-failed'                => 'रद्द झाले',
	'maintenance-deleted'               => 'वगळले',
	'maintenance-revdelete'             => '$2 या विकिवरील $1 आवृत्त्या वगळत आहे',
	'maintenance-revnotfound'           => '$1 आवृत्ती सापडली नाही!',
	'maintenance-stats-edits'           => 'संपादनांची संख्या: $1',
	'maintenance-stats-articles'        => 'मुख्य नामविश्वातील पानांची संख्या: $1',
	'maintenance-stats-pages'           => 'पृष्ठ संख्या: $1',
	'maintenance-stats-users'           => 'सदस्य संख्या: $1',
	'maintenance-stats-admins'          => 'प्रबंधकांची संख्या: $1',
	'maintenance-stats-images'          => 'संचिकांची संख्या: $1',
	'maintenance-stats-views'           => 'पाने पहाण्याची संख्या: $1',
	'maintenance-stats-update'          => 'डाटाबेस बदलत आहे...',
	'maintenance-move'                  => ' $1 चे $2 ला स्थानांतरण करीत आहे...',
	'maintenance-movefail'              => 'स्थानांतरण करण्यात त्रुटी: $1.
स्थानांतरण रद्द करत आहे',
	'maintenance-error'                 => 'त्रुटी: $1',
	'maintenance-memc-fake'             => 'तुम्ही FakeMemCachedClient चालवित आहात. सांख्यिकी देता येणार नाही',
	'maintenance-memc-requests'         => 'मागण्या',
	'maintenance-memc-withsession'      => 'सेशन सहित:',
	'maintenance-memc-withoutsession'   => 'सेशन रहित:',
	'maintenance-memc-total'            => 'एकूण:',
	'maintenance-memc-parsercache'      => 'पार्सर सय',
	'maintenance-memc-hits'             => 'हिट्स:',
	'maintenance-memc-invalid'          => 'अवैध:',
	'maintenance-memc-expired'          => 'रद्द झालेले:',
	'maintenance-memc-absent'           => 'गैरहजर:',
	'maintenance-memc-stub'             => 'स्टब थ्रेशहोल्ड:',
	'maintenance-memc-imagecache'       => 'चित्र सय',
	'maintenance-memc-misses'           => 'मिसेस:',
	'maintenance-memc-updates'          => 'अपडेट्स:',
	'maintenance-memc-uncacheable'      => 'सयीत ठेवता येत नाही:',
	'maintenance-memc-diffcache'        => 'फरक सय',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'maintenance-name'       => 'Tlatēquitiltilīltōcāitl',
	'maintenance-memc-total' => 'mochīntīn:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'maintenance'                       => 'Beheerscripts uitvoeren',
	'maintenance-desc'                  => '[[Special:Maintenance|Webinterface]] voor een aantal beheerscripts',
	'maintenance-backlink'              => 'Naar scriptselectie terugkeren',
	'maintenance-header'                => 'Selecteer hieronder een uit te voeren script.
Beschrijvingen staan naast de scripts',
	'maintenance-changePassword-desc'   => 'Wachtwoord van een gebruiker wijzigen',
	'maintenance-createAndPromote-desc' => 'Een nieuwe gebruiker aanmaken en deze beheerder maken',
	'maintenance-deleteBatch-desc'      => "Pagina's en masse verwijderen",
	'maintenance-deleteRevision-desc'   => 'Versies uit de database verwijderen',
	'maintenance-initEditCount-desc'    => 'Aantal bewerkingen van gebruikers herberekenen',
	'maintenance-initStats-desc'        => 'Sitestatistieken herberekenen',
	'maintenance-moveBatch-desc'        => "Pagina's en masse hernoemen",
	'maintenance-runJobs-desc'          => 'Taken uit de jobqueue uitvoeren',
	'maintenance-showJobs-desc'         => 'Openstaande taken in de jobqueue bekijken',
	'maintenance-stats-desc'            => 'Memcachedstatistieken bekijken',
	'maintenance-changePassword'        => 'Gebruik dit formulier om het wachtwoord van een gebruiker te wijzigen',
	'maintenance-createAndPromote'      => "Gebruik dit formulier om een gebruiker aan te maken en deze beheerder te maken.
Vink het vakje 'bureaucraat' aan om de gebruik ook bureacraat te maken",
	'maintenance-deleteBatch'           => "Gebruik dit formulier om en masse pagina's te verwijderen.
Geef op iedere regel een paginanaam op",
	'maintenance-deleteRevision'        => 'Gebruik dit formulier om en masse versie te verwijderen.
Geef op iedere regel een paginanaam op',
	'maintenance-initStats'             => 'Gebruik dit formulier de sitestatistieken opnieuw te berekenen. Geef daarbij aan of u de tellingen van het aantal keren dat een pagina is bekeken ook wilt bijwerken',
	'maintenance-moveBatch'             => 'Gebruik dit formulier om en masse pagina\'s te hernoemen.
Iedere regel moet een doelpagina en een bestemmingspagina bevatten, gescheiden door een pipe-teken ("|")',
	'maintenance-invalidtype'           => 'Ongeldig type!',
	'maintenance-name'                  => 'Gebruiker',
	'maintenance-password'              => 'Wachtwoord',
	'maintenance-bureaucrat'            => 'De gebruiker bureaucraat maken',
	'maintenance-reason'                => 'Reden',
	'maintenance-update'                => 'Gebruik UPDATE als u een tabel wilt bijwerken? Unchecked gebruiker in plaats daarvan DELETE/INSERT.',
	'maintenance-noviews'               => 'Vink dit aan om te voorkomen dat het aantal keren dat een pagina is bekeken wordt bijgewerkt',
	'maintenance-confirm'               => 'Bevestigen',
	'maintenance-invalidname'           => 'Ongeldige gebruikersnaam!',
	'maintenance-success'               => '$1 is uitgevoerd!',
	'maintenance-userexists'            => 'De gebruiker bestaat al!',
	'maintenance-invalidtitle'          => 'Ongeldige paginanaam "$1"!',
	'maintenance-titlenoexist'          => 'De opgegeven pagina ("$1") bestaat niet!',
	'maintenance-failed'                => 'MISLUKT',
	'maintenance-deleted'               => 'VERWIJDERD',
	'maintenance-revdelete'             => 'Bezig met het verwijderen van versies $1 van wiki $2',
	'maintenance-revnotfound'           => 'Versie $1 niet gevonden!',
	'maintenance-stats-edits'           => 'Aantal bewerkingen: $1',
	'maintenance-stats-articles'        => "Aantal pagina's in de hoofdnaamruimte: $1",
	'maintenance-stats-pages'           => "Aantal pagina's: $1",
	'maintenance-stats-users'           => 'Aantal gebruikers: $1',
	'maintenance-stats-admins'          => 'Aantal beheerders: $1',
	'maintenance-stats-images'          => 'Aantal bestanden: $1',
	'maintenance-stats-views'           => "Aantal bekeken pagina's: $1",
	'maintenance-stats-update'          => 'Bezig met het bijwerken van de database...',
	'maintenance-move'                  => 'Bezig met het hernoemen van $1 naar $2...',
	'maintenance-movefail'              => 'Er is een fout opgetreden bij het hernoemen: $1.
Hernoemen is afgebroken',
	'maintenance-error'                 => 'Fout: $1',
	'maintenance-memc-fake'             => 'U maakt gebruik van FakeMemCachedClient. Het is niet mogelijk statistieken te berekenen',
	'maintenance-memc-requests'         => 'Verzoeken',
	'maintenance-memc-withsession'      => 'met sessie:',
	'maintenance-memc-withoutsession'   => 'zonder sessie:',
	'maintenance-memc-total'            => 'totaal:',
	'maintenance-memc-parsercache'      => 'Parsercache',
	'maintenance-memc-hits'             => 'hits:',
	'maintenance-memc-invalid'          => 'ongeldig:',
	'maintenance-memc-expired'          => 'verlopen:',
	'maintenance-memc-absent'           => 'afwezig:',
	'maintenance-memc-stub'             => 'stubdrempelwaarde:',
	'maintenance-memc-imagecache'       => 'Beeldencache',
	'maintenance-memc-misses'           => 'gemist:',
	'maintenance-memc-updates'          => 'bijgewerkt:',
	'maintenance-memc-uncacheable'      => 'kan niet gecached worden:',
	'maintenance-memc-diffcache'        => 'Diff cache',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'maintenance'                       => 'Kjør vedlikeholdsskript',
	'maintenance-desc'                  => '[[Special:Maintenance|Nettgrensesnitt]] for ulike vedlikeholdsskript',
	'maintenance-backlink'              => 'Tilbake til skriptvalget',
	'maintenance-header'                => 'Velg et skript å utføre nedenfor.
Beskrivelser gis ved siden av hvert skript.',
	'maintenance-changePassword-desc'   => 'Endre en brukers passord',
	'maintenance-createAndPromote-desc' => 'Opprett en bruker og gjør til administrator',
	'maintenance-deleteBatch-desc'      => 'Slett mange sider',
	'maintenance-deleteRevision-desc'   => 'Fjern revisjoner fra databasen',
	'maintenance-initEditCount-desc'    => 'Regne om redigeringstelleren for brukere',
	'maintenance-initStats-desc'        => 'Regne om sidestatistikken',
	'maintenance-moveBatch-desc'        => 'Flytte mange sider',
	'maintenance-runJobs-desc'          => 'Kjøre jobber i jobbkøen',
	'maintenance-showJobs-desc'         => 'Vise en liste over jobber som venter i jobbkøen',
	'maintenance-stats-desc'            => 'Vis mellomlagret statistikk',
	'maintenance-changePassword'        => 'Bruk dette skjemaet for å endre en brukers passord',
	'maintenance-createAndPromote'      => 'Bruk dette skjemaet for å opprette en ny bruker og gjøre den til administrator.
Kryss av i byråkratboksen om du ønsker å gjøre den til byråkrat også',
	'maintenance-deleteBatch'           => 'Bruk dette skjemaet for å slette mange sider på én gang.
Skriv én sidetittel per rad',
	'maintenance-deleteRevision'        => 'Bruk dette skjemaet for å slette mange revisjoner på én gang.
Skriv ett revisjonsnummer per rad',
	'maintenance-initStats'             => 'Bruk dette skjemaet for å regne ut sidestatistikken på nytt, spesielt om du vil regne ut sidevisninger på nytt',
	'maintenance-moveBatch'             => 'Bruk dette skjemaet for å flytte mange sider på én gang.
Hver linje bør oppgi kildeside og målside adskilt med strek (|)',
	'maintenance-invalidtype'           => 'Ugyldig type!',
	'maintenance-name'                  => 'Brukernavn',
	'maintenance-password'              => 'Passord',
	'maintenance-bureaucrat'            => 'Forfrem en bruker til byråkrat',
	'maintenance-reason'                => 'Årsak',
	'maintenance-update'                => 'Bruk UPDATE under oppdatering av tabell? Om uavkrysset brukes DELETE/INSERT i stedet.',
	'maintenance-noviews'               => 'Kryss av her for ikke å oppdatere sidevisninger',
	'maintenance-confirm'               => 'Bekreft',
	'maintenance-invalidname'           => 'Ugyldig brukernavn.',
	'maintenance-success'               => '$1 ble gjennomført uten uhell.',
	'maintenance-userexists'            => 'Brukeren finnes allerede.',
	'maintenance-invalidtitle'          => 'Ugyldig tittel «$1».',
	'maintenance-titlenoexist'          => 'Den oppgitte tittelen («$1») finnes ikke.',
	'maintenance-failed'                => 'MISLYKTES',
	'maintenance-deleted'               => 'SLETTET',
	'maintenance-revdelete'             => 'Sletter revisjonene $1 fra wikien $2',
	'maintenance-revnotfound'           => 'Revisjon $1 ikke funnet.',
	'maintenance-stats-edits'           => 'Antal redigeringer: $1',
	'maintenance-stats-articles'        => 'Antall sider i hovednavnerommet: $1',
	'maintenance-stats-pages'           => 'Antall sider: $1',
	'maintenance-stats-users'           => 'Antall brukere: $1',
	'maintenance-stats-admins'          => 'Antall administratorer: $1',
	'maintenance-stats-images'          => 'Antall filer: $1',
	'maintenance-stats-views'           => 'Antall sidevisninger: $1',
	'maintenance-stats-update'          => 'Oppdaterer database …',
	'maintenance-move'                  => 'Flytter $1 til $2 …',
	'maintenance-movefail'              => 'Feil oppsto under flytting: $1.
Avbryter flytting',
	'maintenance-error'                 => 'Feil: $1',
	'maintenance-memc-fake'             => 'Du kjører en FakeMemCachedClient. Ingen statistikk kan oppgis.',
	'maintenance-memc-requests'         => 'Forespørsler',
	'maintenance-memc-withsession'      => 'med sesjon:',
	'maintenance-memc-withoutsession'   => 'uten sesjon:',
	'maintenance-memc-total'            => 'totalt:',
	'maintenance-memc-parsercache'      => 'Parsermellomlager',
	'maintenance-memc-hits'             => 'treff:',
	'maintenance-memc-invalid'          => 'ugyldig:',
	'maintenance-memc-expired'          => 'utgikk:',
	'maintenance-memc-absent'           => 'ikke til stede:',
	'maintenance-memc-stub'             => 'stubbgrense:',
	'maintenance-memc-imagecache'       => 'Bildemellomlager',
	'maintenance-memc-misses'           => 'bom:',
	'maintenance-memc-updates'          => 'Oppdateringer:',
	'maintenance-memc-uncacheable'      => 'Kan ikke mellomlagres:',
	'maintenance-memc-diffcache'        => 'Forskjellsmellomlager',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'maintenance'                       => 'Aviar los escripts de mantenença',
	'maintenance-desc'                  => '[[Special:Maintenance|Interfàcia Web]] pels diferents escripts de mantenença',
	'maintenance-backlink'              => "Retorn vèrs la seleccion de l'escript",
	'maintenance-header'                => "Seleccionatz, çaijós, un escript d'executar.
Las descripcions son a la seguida de cadun d'aquestes.",
	'maintenance-changePassword-desc'   => 'Cambiar lo senhal d’un utilizaire',
	'maintenance-createAndPromote-desc' => "Crear un utilizaire e promòure a l'estatut d’administrator",
	'maintenance-deleteBatch-desc'      => 'Supression en massa de las paginas',
	'maintenance-deleteRevision-desc'   => 'Levar las versions de la banca de donadas',
	'maintenance-initEditCount-desc'    => 'Tornar calcular los comptadors d’edicions dels utilizaires',
	'maintenance-initStats-desc'        => 'Tornar calcular las estatisticas del sit',
	'maintenance-moveBatch-desc'        => 'Cambiament de nom en massa de las paginas',
	'maintenance-runJobs-desc'          => "Aviar los prètzfaches dins la lista de los d'acomplir",
	'maintenance-showJobs-desc'         => "Afichar una lista dels prètzfaches en cors dins la lista de los d'acomplir",
	'maintenance-stats-desc'            => 'Afichar las estatisticas de la memòria-amagatal',
	'maintenance-changePassword'        => 'Utilizar aqueste formulari per cambiar lo senhal d’un utilizaire',
	'maintenance-createAndPromote'      => 'Utilizar aqueste formulari per crear un utilizaire novèl e per lo promòure administrator.
Marcar la casa burocrata se li desiratz conferir tanben aqueste estatut.',
	'maintenance-deleteBatch'           => 'Utilizatz aqueste formulari per suprimir en massa de paginas/
Indicar una sola pagina per linha',
	'maintenance-deleteRevision'        => 'Utilizatz aqueste formulari per suprimir en massa las versions.
Indicatz una sola version per linha',
	'maintenance-initStats'             => 'Utilizatz aqueste formulari per tornar calcular las estatisticas del sit, en indicant, se fa mestièr, se desiratz lo recalcul del nombre de visitas per pagina.',
	'maintenance-moveBatch'             => 'Utilizatz aqueste formulari per desplaçar en massa las paginas.
Cada linha deurà indicar la pagina d’origina e la de destinacion ; lasqualas deuràn èsser separadas per un « <nowiki>|</nowiki> »',
	'maintenance-invalidtype'           => 'Tipe incorrècte !',
	'maintenance-name'                  => "Nom d'utilizaire",
	'maintenance-password'              => 'Senhal',
	'maintenance-bureaucrat'            => "Promòure l’utilizaire a l'estatut de burocrata",
	'maintenance-reason'                => 'Motiu',
	'maintenance-update'                => "Utilizar UPDATE al moment de la mesa a jorn d'una taula ? Desmarcatz l'usatge DELETE/INSERT al luòc d'aquò.",
	'maintenance-noviews'               => 'Marcar aquò per evitar la mesa a jorn del nombre de visitas de las paginas.',
	'maintenance-confirm'               => 'Confirmar',
	'maintenance-invalidname'           => 'Nom d’utilizaire incorrècte !',
	'maintenance-success'               => '$1 a marchat amb succès !',
	'maintenance-userexists'            => 'L’utilizaire existís ja !',
	'maintenance-invalidtitle'          => 'Títol incorrècte « $1 » !',
	'maintenance-titlenoexist'          => 'Lo títol indicat (« $1 ») existís pas !',
	'maintenance-failed'                => 'FRACÀS',
	'maintenance-deleted'               => 'SUPRIMIT',
	'maintenance-revdelete'             => 'Supression de las versions $1 dempuèi lo wiki $2',
	'maintenance-revnotfound'           => 'Version $1 introbabla !',
	'maintenance-stats-edits'           => 'Nombre d’edicions : $1',
	'maintenance-stats-articles'        => 'Nombre de paginas dins lo meteis espaci : $1',
	'maintenance-stats-pages'           => 'Nombre de paginas : $1',
	'maintenance-stats-users'           => "Nombre d'utilizaires : $1",
	'maintenance-stats-admins'          => "Nombre d'administrators : $1",
	'maintenance-stats-images'          => 'Nombre de fichièrs : $1',
	'maintenance-stats-views'           => 'Nombre de paginas visitadas : $1',
	'maintenance-stats-update'          => 'Mesa a jorn de la banca de donadas…',
	'maintenance-move'                  => 'Desplaçament de $1 vèrs $2…',
	'maintenance-movefail'              => 'Error constatada al moment del cambiament de nom : $1.
Arrèst del desplaçament.',
	'maintenance-error'                 => 'Error : $1',
	'maintenance-memc-fake'             => "Sètz a aviar FakeMemCachedClient. Cap d'estatistica serà pas provesida.",
	'maintenance-memc-requests'         => 'Requèstas',
	'maintenance-memc-withsession'      => 'amb la sesilha :',
	'maintenance-memc-withoutsession'   => 'sens la sesilha :',
	'maintenance-memc-total'            => 'soma :',
	'maintenance-memc-parsercache'      => 'Amagatal del parser',
	'maintenance-memc-hits'             => 'clics :',
	'maintenance-memc-invalid'          => 'invalid :',
	'maintenance-memc-expired'          => 'expirats :',
	'maintenance-memc-absent'           => 'absent :',
	'maintenance-memc-stub'             => 'sulhèt de despart :',
	'maintenance-memc-imagecache'       => 'Amagatal imatge',
	'maintenance-memc-misses'           => 'perduts :',
	'maintenance-memc-updates'          => 'meses a jorn :',
	'maintenance-memc-uncacheable'      => "fòra de l'amagatal :",
	'maintenance-memc-diffcache'        => 'Amagatal dels dif',
);

/** Polish (Polski)
 * @author McMonster
 * @author Sp5uhe
 * @author Maikking
 */
$messages['pl'] = array(
	'maintenance'                       => 'Uruchom skrypty konserwacyjne',
	'maintenance-desc'                  => '[[Special:Maintenance|Interfejs]] dla różnych skryptów konserwacyjnych',
	'maintenance-backlink'              => 'Wróć do wyboru skryptu',
	'maintenance-header'                => 'Wybierz skrypt, który chcesz uruchomić.
Przy nazwach skryptów znajdują się ich opisy.',
	'maintenance-changePassword-desc'   => 'Zmień hasło użytkownika',
	'maintenance-createAndPromote-desc' => 'Utwórz użytkownika i nadaj mu uprawnienia administratora',
	'maintenance-deleteBatch-desc'      => 'Usuń masowo strony',
	'maintenance-initEditCount-desc'    => 'Przelicz ponownie liczniki edycji użytkowników',
	'maintenance-initStats-desc'        => 'Przelicz ponownie statystyki strony',
	'maintenance-moveBatch-desc'        => 'Przenieś masowo strony',
	'maintenance-runJobs-desc'          => 'Uruchom zadania z kolejki',
	'maintenance-showJobs-desc'         => 'Pokaż kolejkę zadań oczekujących na wykonanie',
	'maintenance-changePassword'        => 'Użyj tego formularza, by zmienić hasło użytkownika',
	'maintenance-createAndPromote'      => 'Użyj tego formularza, by utworzyć nowe konto użytkownika i nadać mu uprawnienia administratora.
Zaznacz pole wyboru poniżej, aby przyznać mu również uprawnienia biurokraty.',
	'maintenance-deleteBatch'           => 'Używaj tego formularza do masowego usuwania stron.
W każdej linijce podaj tylko jedną nazwę strony.',
	'maintenance-deleteRevision'        => 'Używaj tego formularza do masowego usuwania wersji artykułów.
W każdej linijce podaj tylko jeden numer wersji artykułu.',
	'maintenance-name'                  => 'Nazwa użytkownika',
	'maintenance-password'              => 'Hasło',
	'maintenance-bureaucrat'            => 'Przyznaj użytkownikowi uprawnienia biurokraty',
	'maintenance-reason'                => 'Powód',
	'maintenance-confirm'               => 'Potwierdź',
	'maintenance-userexists'            => 'Użytkownik już istnieje!',
	'maintenance-invalidtitle'          => 'Niepoprawny tytuł „$1”!',
	'maintenance-titlenoexist'          => 'Wybrana nazwa „$1” nie istnieje!',
	'maintenance-failed'                => 'NIEPOWODZENIE',
	'maintenance-deleted'               => 'USUNIĘTO',
	'maintenance-revdelete'             => 'Usuwanie wersji $1 z wiki $2',
	'maintenance-revnotfound'           => 'Wersja $1 nie została odnaleziona!',
	'maintenance-stats-edits'           => 'Liczba edycji $1',
	'maintenance-stats-articles'        => 'Liczba stron w głównej przestrzeni nazw $1',
	'maintenance-stats-pages'           => 'Liczba stron: $1',
	'maintenance-stats-users'           => 'Liczba użytkowników: $1',
	'maintenance-stats-admins'          => 'Liczba administratorów: $1',
	'maintenance-stats-images'          => 'Liczba plików: $1',
	'maintenance-stats-views'           => 'Liczba odwiedzin strony: $1',
	'maintenance-stats-update'          => 'Aktualizacja bazy danych...',
	'maintenance-move'                  => 'Przenoszenie $1 do $2...',
	'maintenance-movefail'              => 'Wystąpił błąd przy przenoszeniu $1.
Przenoszenie przerwane.',
	'maintenance-error'                 => 'Błąd: $1',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'maintenance-memc-total'   => 'ټولټال:',
	'maintenance-memc-invalid' => 'ناسم:',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'maintenance-name'       => 'Nume de utilizator',
	'maintenance-reason'     => 'Motiv',
	'maintenance-confirm'    => 'Confirmă',
	'maintenance-memc-total' => 'total:',
);

/** Russian (Русский)
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'maintenance-name'        => 'Имя участника',
	'maintenance-password'    => 'Пароль',
	'maintenance-reason'      => 'Причина',
	'maintenance-stats-edits' => 'Число правок: $1',
	'maintenance-error'       => 'Ошибка: $1',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'maintenance'                       => 'Spustiť údržbové skripty',
	'maintenance-desc'                  => '[[Special:Maintenance|Webové rozhranie]] pre rozličné údržbové skripty',
	'maintenance-backlink'              => 'Späť na výber skriptu',
	'maintenance-header'                => 'Prosím, vyberte dolu skript, ktorý sa má spustiť.',
	'maintenance-changePassword-desc'   => 'Zmeniť heslo používateľa',
	'maintenance-createAndPromote-desc' => 'Vytvoriť používateľa a povyšiť ho na správcu',
	'maintenance-deleteBatch-desc'      => 'Hromadné mazanie stránok',
	'maintenance-deleteRevision-desc'   => 'Odstránenie revízií z databázy',
	'maintenance-initEditCount-desc'    => 'Znovu spočítať počty úprav používateľov',
	'maintenance-initStats-desc'        => 'Znovu spočítať štatistiky wiki',
	'maintenance-moveBatch-desc'        => 'Hromadný presun stránok',
	'maintenance-runJobs-desc'          => 'Spustiť úlohy vo fronte úloh',
	'maintenance-showJobs-desc'         => 'Zobraziť zoznam čakajúcich úloh vo fronte úloh',
	'maintenance-stats-desc'            => 'Zobraziť štatistiky Memcached',
	'maintenance-changePassword'        => 'Tento formulár slúži na zmenu hesla používateľa',
	'maintenance-createAndPromote'      => 'Tento formulár slúži na vytvorenie nového používateľa a jeho povýšenie na správcu.
Označte pole „byrokrat” ak ho chcete povýšiť aj na byrokrata.',
	'maintenance-deleteBatch'           => 'Tento formulár slúži na hromadné mazanie stránok.
Píšte iba jednu stránku na riadok',
	'maintenance-deleteRevision'        => 'Tento formulár slúži na hromadné mazanie revízií.
Píšte iba jednu revíziu na riadok',
	'maintenance-initStats'             => 'Tento formulár slúži na prepočítanie štatistík tejto wiki. Môžete určiť, či chcete prepočítať aj zobrazenia stránok.',
	'maintenance-moveBatch'             => 'Tento formulár slúži na hromadné presúvanie stránok.
Na každom riadku by ste mali určiť zdrojovú a cieľovú stránku oddelenú znakom rúry („|”).',
	'maintenance-invalidtype'           => 'Neplatný typ!',
	'maintenance-name'                  => 'Používateľské meno',
	'maintenance-password'              => 'Heslo',
	'maintenance-bureaucrat'            => 'Povýšiť používateľa na stav byrokrat',
	'maintenance-reason'                => 'Dôvod',
	'maintenance-update'                => 'Použiť na aktualizáciu tabuľky UPDATE? Ak nie, použije sa DELETE/INSERT.',
	'maintenance-noviews'               => 'Ak je toto pole označené, nebude sa aktualizovať počet zobrazení stránky',
	'maintenance-confirm'               => 'Potvrdiť',
	'maintenance-invalidname'           => 'Neplatné používateľské meno!',
	'maintenance-success'               => '$1 prebehol úspešne!',
	'maintenance-userexists'            => 'Používateľ už existuje!',
	'maintenance-invalidtitle'          => 'Neplatný názov „$1”!',
	'maintenance-titlenoexist'          => 'Uvedený názov („$1”) neexistuje!',
	'maintenance-failed'                => 'ZLYHALO',
	'maintenance-deleted'               => 'ZMAZANÉ',
	'maintenance-revdelete'             => 'Mažú sa revízie $1 z wiki $2',
	'maintenance-revnotfound'           => 'Revízia $1 nenájdená!',
	'maintenance-stats-edits'           => 'Počet úprav: $1',
	'maintenance-stats-articles'        => 'Počet stránok v hlavnom mennom priestore: $1',
	'maintenance-stats-pages'           => 'Počet stránok: $1',
	'maintenance-stats-users'           => 'Počet používateľov: $1',
	'maintenance-stats-admins'          => 'Počet správcov: $1',
	'maintenance-stats-images'          => 'Počet súborov: $1',
	'maintenance-stats-views'           => 'Počet zobrazení stránky: $1',
	'maintenance-stats-update'          => 'Aktualizuje sa databáza...',
	'maintenance-move'                  => 'Presúva sa $1 na $2...',
	'maintenance-movefail'              => 'Počas presúvania sa vyskytla chyba: $1.
Presúvanie sa ruší',
	'maintenance-error'                 => 'Chyba: $1',
	'maintenance-memc-fake'             => 'Používate FakeMemCachedClient. Štatistiky nie sú dostupné',
	'maintenance-memc-requests'         => 'Požiadavky',
	'maintenance-memc-withsession'      => 's reláciou:',
	'maintenance-memc-withoutsession'   => 'bez relácie:',
	'maintenance-memc-total'            => 'celkom:',
	'maintenance-memc-parsercache'      => 'Vyrovnávacia pamäť syntaktického analyzátora',
	'maintenance-memc-hits'             => 'zásahov:',
	'maintenance-memc-invalid'          => 'neplatných:',
	'maintenance-memc-expired'          => 'vypršaných:',
	'maintenance-memc-absent'           => 'chýbajúcich:',
	'maintenance-memc-stub'             => 'prah výhonku:',
	'maintenance-memc-imagecache'       => 'Vyrovnávacia pamäť obrázkov',
	'maintenance-memc-misses'           => 'minutí:',
	'maintenance-memc-updates'          => 'aktualizácií:',
	'maintenance-memc-uncacheable'      => 'nebolo možné použiť vyrovnávaciu pamäť:',
	'maintenance-memc-diffcache'        => 'Rozdiel vo vyrovnávacej pamäti',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'maintenance-name'     => 'Landihan',
	'maintenance-password' => 'Sandi',
	'maintenance-reason'   => 'Alesan',
	'maintenance-deleted'  => 'DIHAPUS',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'maintenance'                       => 'Kör underhållsskripter',
	'maintenance-desc'                  => '[[Special:Maintenance|Webbgränssnitt]] för olika underhållsskripter',
	'maintenance-backlink'              => 'Tillbaka till skriptvalet',
	'maintenance-header'                => 'Var god ange ett skript nedan till att exekvera.
Beskrivningar finns brevid varje skript',
	'maintenance-changePassword-desc'   => 'Ändra en användares lösenord',
	'maintenance-createAndPromote-desc' => 'Skapa en användare och befodra till administratör',
	'maintenance-deleteBatch-desc'      => 'Mass-radera sidor',
	'maintenance-deleteRevision-desc'   => 'Ta bort versioner från databasen',
	'maintenance-initEditCount-desc'    => 'Omräkna redigeringräkningarna för användare',
	'maintenance-initStats-desc'        => 'Omräkna sajtstatistiken',
	'maintenance-moveBatch-desc'        => 'Mass-flytta sidor',
	'maintenance-runJobs-desc'          => 'Köra jobb i jobbkön',
	'maintenance-showJobs-desc'         => 'Visa en lista över jobb som ligger i jobbkön',
	'maintenance-stats-desc'            => 'Visa mellanlagrad statistik',
	'maintenance-changePassword'        => 'Använd detta formulär för att ändra en användares lösenord',
	'maintenance-createAndPromote'      => 'Använd detta formulär för att skapa en ny användare och befodra den till administratör.
Kryssa i byråkratruta om du vill befodra den till byråkrat istället',
	'maintenance-deleteBatch'           => 'Använd detta formulär för att mass-radera sidor.
Skriv endast in en sida per rad',
	'maintenance-deleteRevision'        => 'Använd detta formulär för att mass-radera versioner.
Skriv endast in en version per rad',
	'maintenance-initStats'             => 'Använd detta formulär för att räkna om sajtens statistik, speciellt om du vill räkna om sidvisningar',
	'maintenance-moveBatch'             => 'Använd detta formulär för att mass-flytta sidor.
Varje rad specifierar den nuvarande sidan och destinationssidan separerade med ett lodrätt streck (|)',
	'maintenance-invalidtype'           => 'Ogiltig typ!',
	'maintenance-name'                  => 'Användarnamn',
	'maintenance-password'              => 'Lösenord',
	'maintenance-bureaucrat'            => 'Befodra en användare till en byråkrat',
	'maintenance-reason'                => 'Anledning',
	'maintenance-update'                => 'Använd UPPDATERA när du uppdaterar en tabell? Okryssade använder RADERA/INFOGA istället.',
	'maintenance-noviews'               => 'Kolla det här för att förhindra uppdatering av sidvisningar',
	'maintenance-confirm'               => 'Bekräfta',
	'maintenance-invalidname'           => 'Ogiltigt användarnamn!',
	'maintenance-success'               => '$1 kördes lyckat!',
	'maintenance-userexists'            => 'Användaren existerar redan!',
	'maintenance-invalidtitle'          => 'Ogiltig titel "$1"!',
	'maintenance-titlenoexist'          => 'Titeln som specifierades ("$1") finns inte!',
	'maintenance-failed'                => 'MISSLYCKAD',
	'maintenance-deleted'               => 'RADERAD',
	'maintenance-revdelete'             => 'Raderar versioner $1 från wiki $2',
	'maintenance-revnotfound'           => 'Versionen $1 hittades inte!',
	'maintenance-stats-edits'           => 'Antal redigeringar: $1',
	'maintenance-stats-articles'        => 'Antal sidor i huvudnamnrymden: $1',
	'maintenance-stats-pages'           => 'Antal sidor: $1',
	'maintenance-stats-users'           => 'Antal användare: $1',
	'maintenance-stats-admins'          => 'Antal administratörer: $1',
	'maintenance-stats-images'          => 'Antal filer: $1',
	'maintenance-stats-views'           => 'Antal sidvisningar: $1',
	'maintenance-stats-update'          => 'Uppdaterar databasen...',
	'maintenance-move'                  => 'Flyttar $1 till $2...',
	'maintenance-movefail'              => 'Ett fel uppstod medan flyttningen: $1.
Avbryt flyttning',
	'maintenance-error'                 => 'Fel: $1',
	'maintenance-memc-fake'             => 'Du kör en FakeMemCachedClient. Ingen statistik kan uppges',
	'maintenance-memc-requests'         => 'Efterfrågningar',
	'maintenance-memc-withsession'      => 'med session:',
	'maintenance-memc-withoutsession'   => 'utan session:',
	'maintenance-memc-total'            => 'totalt:',
	'maintenance-memc-parsercache'      => 'Parsercache',
	'maintenance-memc-hits'             => 'träffar:',
	'maintenance-memc-invalid'          => 'ogiltig:',
	'maintenance-memc-expired'          => 'utgick:',
	'maintenance-memc-absent'           => 'frånvarande:',
	'maintenance-memc-stub'             => 'stubbgräns:',
	'maintenance-memc-imagecache'       => 'Bildcache',
	'maintenance-memc-misses'           => 'missar:',
	'maintenance-memc-updates'          => 'uppdateringar:',
	'maintenance-memc-uncacheable'      => 'ej mellanlagringsbara:',
	'maintenance-memc-diffcache'        => 'Skillnadscache',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'maintenance-name'          => 'వాడుకరిపేరు',
	'maintenance-password'      => 'సంకేతపదం',
	'maintenance-reason'        => 'కారణం',
	'maintenance-invalidname'   => 'తప్పుడు వాడుకరిపేరు!',
	'maintenance-success'       => '$1 విజయవంతంగా నడిచింది!',
	'maintenance-userexists'    => 'వాడుకరి ఇప్పటికే ఉన్నారు!',
	'maintenance-stats-edits'   => 'మార్పుల సంఖ్య: $1',
	'maintenance-stats-pages'   => 'పేజీల సంఖ్య: $1',
	'maintenance-stats-users'   => 'వాడుకర్ల సంఖ్య: $1',
	'maintenance-stats-admins'  => 'నిర్వాహకుల సంఖ్య: $1',
	'maintenance-stats-images'  => 'ఫైళ్ళ సంఖ్య: $1',
	'maintenance-error'         => 'పొరపాటు: $1',
	'maintenance-memc-requests' => 'అభ్యర్థనలు',
	'maintenance-memc-total'    => 'మొత్తం:',
);

/** Turkish (Türkçe)
 * @author Suelnur
 */
$messages['tr'] = array(
	'maintenance-reason' => 'Neden',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'maintenance'                       => 'Chạy mã bảo trì',
	'maintenance-desc'                  => '[[Special:Maintenance|Giao diện web]] dành cho các loại mã bảo trì khác nhau',
	'maintenance-backlink'              => 'Quay lại lựa chọn mã',
	'maintenance-header'                => 'Xin hãy chọn một đoạn mã ở dưới để thực thi.
Mô tả nằm ở bên cạnh mỗi đoạn mã',
	'maintenance-changePassword-desc'   => 'Thay đổi mật khẩu của thành viên',
	'maintenance-createAndPromote-desc' => 'Tạo một thành viên và phong cho thành viên này thành sysop',
	'maintenance-deleteBatch-desc'      => 'Xóa trang hàng loạt',
	'maintenance-deleteRevision-desc'   => 'Xóa một phiên bản ra khỏi cơ sở dữ liệu',
	'maintenance-initEditCount-desc'    => 'Tính toán lại số lần sửa đổi của thành viên',
	'maintenance-initStats-desc'        => 'Tính toán lại các thống kê của trang',
	'maintenance-moveBatch-desc'        => 'Di chuyển trang hàng loạt',
	'maintenance-runJobs-desc'          => 'Chạy các tác vụ trong hàng đợi công việc',
	'maintenance-showJobs-desc'         => 'Hiển thị danh sách các công việc đang chờ đợi trong hàng đợi việc',
	'maintenance-stats-desc'            => 'Hiển thị thống kê được lưu vào bộ đệm',
	'maintenance-changePassword'        => 'Sử dụng mẫu này để thay đổi mật khẩu của thành viên',
	'maintenance-createAndPromote'      => 'Sử dụng mẫu này để tạo ra thành viên mới và phong cho thành viên này cờ sysop.
Chọn vào ô hành chính viên nếu bạn cũng muốn phong thành Hành chính viên',
	'maintenance-deleteBatch'           => 'Sử dụng mẫu này để xóa trang hàng loạt.
Chỉ ghi mỗi dòng một trang',
	'maintenance-deleteRevision'        => 'Sử dụng mẫu này để xóa phiên bản hàng loạt.
Chỉ ghi mỗi dòng một phiên bản',
	'maintenance-initStats'             => 'Sử dụng mẫu này để tính lại các thống kê của trang, hãy chỉ rõ nếu bạn cũng muốn tính lại số lần xem trang',
	'maintenance-moveBatch'             => 'Sử dụng mẫu này để di chuyển trang hàng loạt.
Mỗi dòng nên ghi rõ trang nguồn và trang đích, cách nhau bằng dấu sọc đứng',
	'maintenance-invalidtype'           => 'Kiểu không hợp lệ!',
	'maintenance-name'                  => 'Tên người dùng',
	'maintenance-password'              => 'Mật khẩu',
	'maintenance-bureaucrat'            => 'Thăng người này làm hành chính viên',
	'maintenance-reason'                => 'Lý do',
	'maintenance-update'                => 'Có sử dụng UPDATE khi cập nhật một bảng? Thay vào đó hãy bỏ chọn cách dùng DELETE/INSERT.',
	'maintenance-noviews'               => 'Chọn cái này để ngăn cập nhật số lần xem trang',
	'maintenance-confirm'               => 'Xác nhận',
	'maintenance-invalidname'           => 'Tên người dùng không hợp lệ!',
	'maintenance-success'               => '$1 đã chạy thành công!',
	'maintenance-userexists'            => 'Người dùng đã tồn tại!',
	'maintenance-invalidtitle'          => 'Tựa đề “$1” không hợp lệ!',
	'maintenance-titlenoexist'          => 'Tựa đề chỉ định (“$1”) không tồn tại!',
	'maintenance-failed'                => 'THẤT BẠI',
	'maintenance-deleted'               => 'ĐÃ XÓA',
	'maintenance-revdelete'             => 'Đang xóa phiên bản $1 từ wiki $2',
	'maintenance-revnotfound'           => 'Không tìm thấy phiên bản $1!',
	'maintenance-stats-edits'           => 'Số lần sửa đổi: $1',
	'maintenance-stats-articles'        => 'Số trang trong không gian tên chính: $1',
	'maintenance-stats-pages'           => 'Số trang: $1',
	'maintenance-stats-users'           => 'Số người dùng: $1',
	'maintenance-stats-admins'          => 'Số quản lý: $1',
	'maintenance-stats-images'          => 'Số tập tin: $1',
	'maintenance-stats-views'           => 'Số lần xem trang: $1',
	'maintenance-stats-update'          => 'Đang cập nhật cơ sở dữ liệu...',
	'maintenance-move'                  => 'Đang di chuyển $1 sang $2...',
	'maintenance-movefail'              => 'Gặp lỗi khi di chuyển: $1.
Hủy di chuyển',
	'maintenance-error'                 => 'Lỗi: $1',
	'maintenance-memc-fake'             => 'Bạn đang chạy FakeMemCachedClient. Không có thống kê nào',
	'maintenance-memc-requests'         => 'Yêu cầu',
	'maintenance-memc-withsession'      => 'với phiên:',
	'maintenance-memc-withoutsession'   => 'không có phiên',
	'maintenance-memc-total'            => 'tổng cộng:',
	'maintenance-memc-parsercache'      => 'Bộ đệm Phân tích cú pháp',
	'maintenance-memc-hits'             => 'số hit:',
	'maintenance-memc-invalid'          => 'không hợp lệ:',
	'maintenance-memc-expired'          => 'hết hạn:',
	'maintenance-memc-absent'           => 'thiếu:',
	'maintenance-memc-stub'             => 'ngưỡng sơ khai:',
	'maintenance-memc-imagecache'       => 'Bộ đệm Hình ảnh',
	'maintenance-memc-misses'           => 'số miss:',
	'maintenance-memc-updates'          => 'số cập nhật:',
	'maintenance-memc-uncacheable'      => 'không thể lưu đệm:',
	'maintenance-memc-diffcache'        => 'Khác nhau Bộ đệm',
);

