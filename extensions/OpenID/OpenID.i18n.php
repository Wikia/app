<?php
/**
 * OpenID.i18n.php -- Interface messages for OpenID for MediaWiki
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * Copyright 2007,2008 Evan Prodromou <evan@prodromou.name>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@prodromou.name>
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Evan Prodromou <evan@prodromou.name>
 */
$messages['en'] = array(
	'openid-desc' => 'Login to the wiki with an [http://openid.net/ OpenID], and login to other OpenID-aware web sites with a wiki user account',
	'openidlogin' => 'Login with OpenID',
	'openidfinish' => 'Finish OpenID login',
	'openidserver' => 'OpenID server',
	'openidxrds' => 'Yadis file',						
	'openidconvert' => 'OpenID converter',
	'openiderror' => 'Verification error',
	'openiderrortext' => 'An error occured during verification of the OpenID URL.',
	'openidconfigerror' => 'OpenID configuration error',
	'openidconfigerrortext' => 'The OpenID storage configuration for this wiki is invalid.
Please consult this site\'s administrator.',
	'openidpermission' => 'OpenID permissions error',
	'openidpermissiontext' => 'The OpenID you provided is not allowed to login to this server.',
	'openidcancel' => 'Verification cancelled',
	'openidcanceltext' => 'Verification of the OpenID URL was cancelled.',
	'openidfailure' => 'Verification failed',
	'openidfailuretext' => 'Verification of the OpenID URL failed. Error message: "$1"',
	'openidsuccess' => 'Verification succeeded',
	'openidsuccesstext' => 'Verification of the OpenID URL succeeded.',
	'openidusernameprefix' => 'OpenIDUser',
	'openidserverlogininstructions' => 'Enter your password below to log in to $3 as user $2 (user page $1).',
	'openidtrustinstructions' => 'Check if you want to share data with $1.',
	'openidallowtrust' => 'Allow $1 to trust this user account.',
	'openidnopolicy' => 'Site has not specified a privacy policy.',
	'openidpolicy' => 'Check the <a target="_new" href="$1">privacy policy</a> for more information.',
	'openidoptional' => 'Optional',
	'openidrequired' => 'Required',
	'openidnickname' => 'Nickname',
	'openidfullname' => 'Fullname',
	'openidemail' => 'E-mail address',
	'openidlanguage' => 'Language',
	'openidnotavailable' => 'Your preferred nickname ($1) is already in use by another user.',
	'openidnotprovided' => 'Your OpenID server did not provide a nickname (either because it cannot, or because you told it not to).',
	'openidchooseinstructions' => 'All users need a nickname;
you can choose one from the options below.',
	'openidchoosefull' => 'Your full name ($1)',
	'openidchooseurl' => 'A name picked from your OpenID ($1)',
	'openidchooseauto' => 'An auto-generated name ($1)',
	'openidchoosemanual' => 'A name of your choice: ',
	'openidchooseexisting' => 'An existing account on this wiki: ',
	'openidchoosepassword' => 'password: ',
	'openidconvertinstructions' => 'This form lets you change your user account to use an OpenID URL.',
	'openidconvertsuccess' => 'Successfully converted to OpenID',
	'openidconvertsuccesstext' => 'You have successfully converted your OpenID to $1.',
	'openidconvertyourstext' => 'That is already your OpenID.',
	'openidconvertothertext' => 'That is someone else\'s OpenID.',
	'openidalreadyloggedin' => "'''You are already logged in, $1!'''

If you want to use OpenID to log in in the future, you can [[Special:OpenIDConvert|convert your account to use OpenID]].",
	'tog-hideopenid' => 'Hide your <a href="http://openid.net/">OpenID</a> on your user page, if you log in with OpenID.',
	'openidnousername' => 'No username specified.',
	'openidbadusername' => 'Bad username specified.',
	'openidautosubmit' => 'This page includes a form that should be automatically submitted if you have JavaScript enabled.
If not, try the \"Continue\" button.',
	'openidclientonlytext' => 'You cannot use accounts from this wiki as OpenIDs on another site.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => '{{SITENAME}} supports the [http://openid.net/ OpenID] standard for single signon between Web sites.
OpenID lets you log into many different Web sites without using a different password for each.
(See [http://en.wikipedia.org/wiki/OpenID Wikipedia\'s OpenID article] for more information.)

If you already have an account on {{SITENAME}}, you can [[Special:Userlogin|log in]] with your username and password as usual.
To use OpenID in the future, you can [[Special:OpenIDConvert|convert your account to OpenID]] after you have logged in normally.

There are many [http://wiki.openid.net/Public_OpenID_providers Public OpenID providers], and you may already have an OpenID-enabled account on another service.

; Other wikis : If you have an account on an OpenID-enabled wiki, like [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] or [http://kei.ki/ Keiki], you can log in to {{SITENAME}} by entering the \'\'\'full URL\'\'\' of your user page on that other wiki in the box above. For example, \'\'<nowiki>http://kei.ki/en/User:Evan</nowiki>\'\'.
; [http://openid.yahoo.com/ Yahoo!] : If you have an account with Yahoo!, you can log in to this site by entering your Yahoo!-provided OpenID in the box above. Yahoo! OpenID URLs have the form \'\'<nowiki>https://me.yahoo.com/yourusername</nowiki>\'\'.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : If you have an account with [http://www.aol.com/ AOL], like an [http://www.aim.com/ AIM] account, you can log in to {{SITENAME}} by entering your AOL-provided OpenID in the box above. AOL OpenID URLs have the form \'\'<nowiki>http://openid.aol.com/yourusername</nowiki>\'\'. Your username should be all lowercase, no spaces.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : If you have a blog on any of these services, enter your blog URL in the box above. For example, \'\'<nowiki>http://yourusername.blogspot.com/</nowiki>\'\', \'\'<nowiki>http://yourusername.wordpress.com/</nowiki>\'\', \'\'<nowiki>http://yourusername.livejournal.com/</nowiki>\'\', or \'\'<nowiki>http://yourusername.vox.com/</nowiki>\'\'.',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'openidchoosepassword' => 'ou password:',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'openidchoosepassword' => 'шолыпмут:',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'openidchoosepassword' => 'kupu fufu:',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'openidoptional'       => 'Opsioneel',
	'openidrequired'       => 'Verpligtend',
	'openidemail'          => 'E-pos adres',
	'openidlanguage'       => 'Taal',
	'openidchoosepassword' => 'wagwoord:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'openidlogin'             => 'تسجيل الدخول بالهوية المفتوحة',
	'openidserver'            => 'خادم الهوية المفتوحة',
	'openiderror'             => 'خطأ تأكيد',
	'openidcancel'            => 'التأكيد تم إلغاؤه',
	'openidfailure'           => 'التأكيد فشل',
	'openidsuccess'           => 'التأكيد نجح',
	'openidusernameprefix'    => 'مستخدم الهوية المفتوحة',
	'openidallowtrust'        => 'السماح ل$1 بالوثوق بحساب هذا المستخدم.',
	'openidnopolicy'          => 'الموقع لا يمتلك سياسة محددة للخصوصية.',
	'openidoptional'          => 'اختياري',
	'openidrequired'          => 'مطلوب',
	'openidnickname'          => 'اللقب',
	'openidfullname'          => 'الاسم الكامل',
	'openidemail'             => 'عنوان البريد الإلكتروني',
	'openidlanguage'          => 'اللغة',
	'openidchoosefull'        => 'اسمك الكامل ($1)',
	'openidchoosemanual'      => 'اسم من اختيارك:',
	'openidchooseexisting'    => 'حساب موجود في هذه الويكي:',
	'openidchoosepassword'    => 'كلمة السر:',
	'openidnousername'        => 'لا اسم مستخدم تم تحديده.',
	'openidbadusername'       => 'اسم المستخدم المحدد سيء.',
	'openidloginlabel'        => 'مسار الهوية المفتوحة',
	'openidlogininstructions' => "{{SITENAME}} تدعم معيار [http://openid.net/ الهوية المفتوحة] للدخول الفردي بين مواقع الويب.
الهوية المفتوحة تسمح لك بتسجيل الدخول إلى مواقع ويب عديدة مختلفة بدون استخدام كلمة سر مختلفة لكل موقع.
(انظر [http://en.wikipedia.org/wiki/OpenID مقالة الهوية المفتوحة في يويكيبيديا] لمزيد من المعلومات.)

لو أنك لديك بالفعل حساب في {{SITENAME}}، يمكنك [[Special:Userlogin|تسجيل الدخول]] باسم مستخدمك وكلمة السر الخاصة بك كالمعتاد.
لاستخدام الهوية المفتوحة في المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك إلى الهوية المفتوحة]] بعد تسجيل دخولك بشكل عادي.

يوجد العديد من [http://wiki.openid.net/Public_OpenID_providers موفري الهوية المفتوحة العلنيين]، وربما يكون لديك حسابك بهوية مفتوحة على خدمة أخرى.

; الويكيات الأخرى : لو أنك لديك حساب على ويكي مفعل الهوية المفتوحة، مثل [http://wikitravel.org/ ويكي ترافيل]، [http://www.wikihow.com/ ويكي هاو]، [http://vinismo.com/ فينيزمو]، [http://aboutus.org/ أبوت أس] أو [http://kei.ki/ كيكي]، يمكنك تسجيل الدخول إلى {{SITENAME}} بواسطة إدخال '''المسار الكامل''' لصفحة مستخدمك على هذا الويكي الآخر في الصندوق بالأعلى. على سبيل المثال، ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ ياهو!] : إذا لديك حساب مع ياهو!، يمكنك تسجيل الدخول إلى هذا الموقع بواسطة إدخال هويتك المفتوحة الموفرة بواسطة ياهو! في الصندوق بالأعلى. مسارات هوية ياهو! المفتوحة تأخذ الصيغة ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids إيه أو إل] : لو لديك حساب مع [http://www.aol.com/ إيه أو إل]، مثل حساب [http://www.aim.com/ إيه أي إم]، يمكنك تسجيل الدخول إلى {{SITENAME}} بواسطة إدخال هويتك المفتوحة الموفرة بواسطة AOL في الصندوق بالأعلى. مسارات هوية AOL المفتوحة تأخذ الصيغة ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. اسم مستخدمك ينبغي أن يكون كله حروفا صغيرة، لا مسافات.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html بلوجر], [http://faq.wordpress.com/2007/03/06/what-is-openid/ وورد بريس دوت كوم]، [http://www.livejournal.com/openid/about.bml ليف جورنال]، [http://bradfitz.vox.com/library/post/openid-for-vox.html فوكس] : لو لديك مدونة على أي من هذه الخدمات، أدخل مسار مدونتك في الصندوق بالأعلى. على سبيل المثال، ''<nowiki>http://yourusername.blogspot.com/</nowiki>''، ''<nowiki>http://yourusername.wordpress.com/</nowiki>''، ''<nowiki>http://yourusername.livejournal.com/</nowiki>''، أو ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'openidlogin'                   => 'Влизане с OpenID',
	'openidfinish'                  => 'Приключване на OpenID влизането',
	'openidserver'                  => 'OpenID сървър',
	'openidxrds'                    => 'Yadis файл',
	'openidconvert'                 => 'Конвертор за OpenID',
	'openiderror'                   => 'Грешка при потвърждението',
	'openidconfigerror'             => 'OpenID грешка при конфигурирането',
	'openidpermissiontext'          => 'На предоставеното OpenID не е позволено да влиза на този сървър.',
	'openidcancel'                  => 'Потвърждението беше прекратено',
	'openidcanceltext'              => 'Потвърждението на OpenID URL беше прекратено.',
	'openidfailure'                 => 'Потвърждението беше неуспешно',
	'openidfailuretext'             => 'Потвърждението на OpenID URL беше неуспешно. Грешка: „$1“',
	'openidsuccess'                 => 'Потвърждението беше успешно',
	'openidsuccesstext'             => 'Потвърждението на OpenID URL беше успешно.',
	'openidserverlogininstructions' => 'Въведете паролата си по-долу за да влезете в $3 като потребител $2 (потребителска страница $1).',
	'openidnopolicy'                => 'Сайтът няма уточнена политика за защита на личните данни.',
	'openidpolicy'                  => 'За повече информация вижте политиката за <a target="_new" href="$1">защита на личните данни</a>.',
	'openidoptional'                => 'Незадължително',
	'openidrequired'                => 'Изисква се',
	'openidnickname'                => 'Псевдоним',
	'openidfullname'                => 'Име',
	'openidemail'                   => 'Електронна поща',
	'openidlanguage'                => 'Език',
	'openidnotavailable'            => 'Избраното потребителско име ($1) вече се използва от друг потребител.',
	'openidchooseinstructions'      => 'Всички потребители трябва да имат потребителско име;
можете да изберете своето от предложенията по-долу.',
	'openidchoosefull'              => 'Вашето пълно име ($1)',
	'openidchooseauto'              => 'Автоматично генерирано име ($1)',
	'openidchoosemanual'            => 'Име по избор:',
	'openidchooseexisting'          => 'Съществуваща сметка в това уики:',
	'openidchoosepassword'          => 'парола:',
	'openidconvertinstructions'     => 'Този формуляр позволява да се промени потребителската сметка да използва OpenID URL.',
	'openidconvertsuccess'          => 'Преобразуването в OpenID беше успешно',
	'openidconvertsuccesstext'      => 'Успешно преобразувахте вашият OpenID в $1.',
	'openidconvertyourstext'        => 'Това вече е вашият OpenID.',
	'openidconvertothertext'        => 'Това е OpenID на някой друг.',
	'openidalreadyloggedin'         => "'''Вече сте влезли в системата, $1!'''

Ако желаете да използвате OpenID за бъдещи влизания, можете да [[Special:OpenIDConvert|преобразувате сметката си да използва OpenID]].",
	'tog-hideopenid'                => 'Скриване на <a href="http://openid.net/">OpenID</a> от потребителската страница ако влезете чрез OpenID.',
	'openidnousername'              => 'Не е посочено потребителско име.',
	'openidbadusername'             => 'Беше посочено невалидно име.',
	'openidautosubmit'              => 'Тази страница включва формуляр, който би трябвало да се изпрати автоматично ако Джаваскриптът е разрешен.
Ако не е, можете да използвате бутона \\"Продължаване\\".',
	'openidclientonlytext'          => 'Не можете да използвате сметки от това уики като OpenID за друг сайт.',
	'openidloginlabel'              => 'OpenID Адрес',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'openidlanguage' => 'ѩꙁꙑ́къ',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'openidnickname'       => 'Kaldenavn',
	'openidlanguage'       => 'Sprog',
	'openidchoosepassword' => 'adgangskode:',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'openidlanguage'       => 'Γλώσσα',
	'openidchoosemanual'   => 'Ένα όνομα της επιλογής σας:',
	'openidchoosepassword' => 'κωδικός:',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'openidconvert'            => 'OpenID konvertilo',
	'openidoptional'           => 'Nedeviga',
	'openidrequired'           => 'Deviga',
	'openidnickname'           => 'Kaŝnomo',
	'openidfullname'           => 'Plena nomo',
	'openidemail'              => 'Retadreso',
	'openidlanguage'           => 'Lingvo',
	'openidchooseinstructions' => 'Ĉiuj uzantoj bezonas kromnomo;
vi povas selekti el unu la jenaj opcioj.',
	'openidchoosefull'         => 'Via plena nomo ($1)',
	'openidchooseauto'         => 'Automate generita nomo ($1)',
	'openidchoosemanual'       => 'Nomo de via elekto:',
	'openidchoosepassword'     => 'pasvorto:',
	'openidnousername'         => 'Neniu salutnomo estis donita.',
	'openidbadusername'        => 'Fuŝa salutnomo donita.',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 */
$messages['fr'] = array(
	'openid-desc'                   => "Se connecte au wiki avec [http://openid.net/ OpenID] et se connecte à d'autres site internet OpenID avec un wiki utilisant un compte utilisateur.",
	'openidlogin'                   => 'Se connecter avec OpenID',
	'openidfinish'                  => 'Finir la connection OpenID',
	'openidserver'                  => 'Serveur OpenID',
	'openidxrds'                    => 'Fichier Yadis',
	'openidconvert'                 => 'Convertisseur OpenID',
	'openiderror'                   => 'Erreur de vérification',
	'openiderrortext'               => "Une erreur est intervenue pendant la vérification de l'adresse OpenID.",
	'openidconfigerror'             => 'Erreur de configuration de OpenID',
	'openidconfigerrortext'         => 'Le stockage de la configuration OpenID pour ce wiki est incorrecte.
Veuillez vous mettre en rapport avec l’administrateur de ce site.',
	'openidpermission'              => 'Erreur de permission OpenID',
	'openidpermissiontext'          => 'L’OpenID que vous avez fournie n’est pas autorisée à se connecter sur ce serveur.',
	'openidcancel'                  => 'Vérification annulée',
	'openidcanceltext'              => 'La vérification de l’adresse OpenID a été annulée.',
	'openidfailure'                 => 'Échec de la vérification',
	'openidfailuretext'             => 'La vérification de l’adresse OpenID a échouée. Message d’erreur : « $1 »',
	'openidsuccess'                 => 'Vérification réussie',
	'openidsuccesstext'             => 'Vérification de l’adresse OpenID réussie.',
	'openidusernameprefix'          => 'Utilisateur OpenID',
	'openidserverlogininstructions' => "Entrez votre mot de passe ci-dessous pour vous connecter sur $3 comme utilisateur '''$2''' (page utilisateur $1).",
	'openidtrustinstructions'       => 'Cochez si vous désirez partager les données avec $1.',
	'openidallowtrust'              => 'Autorise $1 à faire confiance à ce compte utilisateur.',
	'openidnopolicy'                => 'Le site n’a pas indiqué une politique des données personnelles.',
	'openidpolicy'                  => 'Vérifier la <a target="_new" href="$1">Politique des données personnelles</a> pour plus d’information.',
	'openidoptional'                => 'Facultatif',
	'openidrequired'                => 'Exigé',
	'openidnickname'                => 'Surnom',
	'openidfullname'                => 'Nom en entier',
	'openidemail'                   => 'Adresse courriel',
	'openidlanguage'                => 'Langue',
	'openidnotavailable'            => 'Votre surnom préféré ($1) est déjà utilisé par un autre utilisateur.',
	'openidnotprovided'             => "Votre serveur OpenID n'a pas pu fournir un surnom (soit il ne le peut pas, soit vous lui avez demandé de ne pas le faire).",
	'openidchooseinstructions'      => "Tous les utilisateurs ont besoin d'un surnom ; vous pouvez en choisir un à partir du choix ci-dessous.",
	'openidchoosefull'              => 'Votre nom entier ($1)',
	'openidchooseurl'               => 'Un nom a été choisi depuis votre OpenID ($1)',
	'openidchooseauto'              => 'Un nom créé automatiquement ($1)',
	'openidchoosemanual'            => 'Un nom de votre choix :',
	'openidchooseexisting'          => 'Un compte existant sur ce wiki :',
	'openidchoosepassword'          => 'Mot de passe :',
	'openidconvertinstructions'     => 'Ce formulaire vous laisse changer votre compte utilisateur pour utiliser une adresse OpenID.',
	'openidconvertsuccess'          => 'Converti avec succès vers OpenID',
	'openidconvertsuccesstext'      => 'Vous avez converti avec succès votre OpenID vers $1.',
	'openidconvertyourstext'        => 'C’est déjà votre OpenID.',
	'openidconvertothertext'        => "Ceci est quelque chose autre qu'une OpenID.",
	'openidalreadyloggedin'         => "'''Vous êtes déjà connecté, $1 !'''

Vous vous désirez utiliser votre OpenID pour vous connecter ultérieurement, vous pouvez [[Special:OpenIDConvert|convertir votre compte pour utiliser OpenID]].",
	'tog-hideopenid'                => 'Cache votre <a href="http://openid.net/">OpenID</a> sur votre page utilisateur, si vous vous connectez avec OpenID.',
	'openidnousername'              => 'Aucun nom d’utilisateur n’a été indiqué.',
	'openidbadusername'             => 'Un mauvais nom d’utilisatteur a été indiqué.',
	'openidautosubmit'              => 'Cette page comprend un formulaire qui pourrait être envoyé automatiquement si vous avez activé JavaScript.
Si tel n’était pas le cas, essayez le bouton « Continuer ».',
	'openidclientonlytext'          => 'Vous ne pouvez utiliser des comptes depuis ce wiki en tant qu’OpenID sur d’autres sites.',
	'openidloginlabel'              => 'Adresse OpenID',
	'openidlogininstructions'       => "{{SITENAME}} supporte le format [http://openid.net/ OpenID] pour une seule signature entre des sites Internet.
OpenID vous permet de vous connecter sur plusieurs sites différents sans à avoir à utiliser un mot de passe différent pour chacun d’entre eux.

Si vous avez déjà un compte sur {{SITENAME}}, vous pouvez vous [[Special:Userlogin|connecter]] avec votre nom d'utilisateur et son mot de pas comme d’habitude. Pour utiliser OpenID, à l’avenir, vous pouvez [[Special:OpenIDConvert|convertir votre compte en OpenID]] après que vous vous soyez connecté normallement.

Il existe plusieurs [http://wiki.openid.net/Public_OpenID_providers fournisseur d'OpenID publiques], et vous pouvez déjà obtenir un compte OpenID activé sur un autre service.

; Autres wiki : si vous avez avec un wiki avec OpenID activé, tel que [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] ou encore [http://kei.ki/ Keiki], vous pouvez vous connecter sur {{SITENAME}} en entrant '''l’adresse internet complète'' de votre page de cet autre wiki dans la boîte ci-dessus. Par exemple : ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Si vous avez un compte avec Yahoo! , vous pouvez vous connecter sur ce site en entrant votre OpenID Yahoo! fournie dans la boîte ci-dessous. Les adresses OpenID doivent avoir la syntaxe ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : si vous avec un compte avec [http://www.aol.com/ AOL], tel qu'un compte [http://www.aim.com/ AIM], vous pouvez vous connecter sur {{SITENAME}} en entrant votre OpenID fournie par AOL dans la boîte ci-dessous. Les adresses OpenID doivent avoir le format ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Votre nom d’utilisateur doit être entièrement en lettres minuscules avec aucun espace.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Si vous avec un blog ou un autre de ces services, entrez l’adresse de votre blog dans la boîte ci-dessous. Par exemple, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', ou encore ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'openid-desc'                   => 'Acceder ao sistema do wiki cun [http://openid.net/ OpenID] e acceder a outras páxinas web OpenID cunha conta de usuario dun wiki',
	'openidlogin'                   => 'Acceder ao sistema co OpenID',
	'openidfinish'                  => 'Saír do sistema OpenID',
	'openidserver'                  => 'Servidor do OpenID',
	'openidxrds'                    => 'Ficheiro Yadis',
	'openidconvert'                 => 'Conversor OpenID',
	'openiderror'                   => 'Erro de verificación',
	'openiderrortext'               => 'Ocorreu un erro durante a verificación do URL do OpenID.',
	'openidconfigerror'             => 'Erro na configuración do OpenID',
	'openidconfigerrortext'         => 'A configuración do almacenamento no OpenID deste wiki é inválido.
Por favor, consúlteo co administrador do sitio.',
	'openidpermission'              => 'Erro de permisos OpenID',
	'openidpermissiontext'          => 'O OpenID que proporcionou non ten permitido o acceso a este servidor.',
	'openidcancel'                  => 'A verificación foi cancelada',
	'openidcanceltext'              => 'A verificación da dirección URL do OpenID foi cancelada.',
	'openidfailure'                 => 'Fallou a verificación',
	'openidfailuretext'             => 'Fallou a verificación da dirección URL do OpenID. Mensaxe de erro: "$1"',
	'openidsuccess'                 => 'A verificación foi un éxito',
	'openidsuccesstext'             => 'A verificación da dirección URL do OpenID foi un éxito.',
	'openidusernameprefix'          => 'Usuario do OpenID',
	'openidserverlogininstructions' => 'Insira o seu contrasinal embaixo para acceder a $3 como o usuario $2 (páxina de usuario $1).',
	'openidtrustinstructions'       => 'Comprobe se quere compartir datos con $1.',
	'openidallowtrust'              => 'Permitir que $1 revise esta conta de usuario.',
	'openidnopolicy'                => 'O sitio non especificou unha política de privacidade.',
	'openidpolicy'                  => 'Comprobe a <a target="_new" href="$1">política de privacidade</a> para máis información.',
	'openidoptional'                => 'Opcional',
	'openidrequired'                => 'Necesario',
	'openidnickname'                => 'Alcume',
	'openidfullname'                => 'Nome completo',
	'openidemail'                   => 'Enderezo de correo electrónico',
	'openidlanguage'                => 'Lingua',
	'openidnotavailable'            => 'O seu alcume preferido ($1) xa está sendo usado por outro usuario.',
	'openidnotprovided'             => 'O servidor do seu OpenID non proporcionou un alcume (porque non pode ou porque vostede lle dixo que non o fixera).',
	'openidchooseinstructions'      => 'Todos os usuarios precisan un alcume; pode escoller un de entre as opcións de embaixo.',
	'openidchoosefull'              => 'O seu nome completo ($1)',
	'openidchooseurl'               => 'Un nome tomado do seu OpenID ($1)',
	'openidchooseauto'              => 'Un nome autoxerado ($1)',
	'openidchoosemanual'            => 'Un nome da súa escolla:',
	'openidchooseexisting'          => 'Unha conta existente neste wiki:',
	'openidchoosepassword'          => 'contrasinal:',
	'openidconvertinstructions'     => 'Este formulario permítelle cambiar a súa conta de usuario para usar unha dirección OpenID.',
	'openidconvertsuccess'          => 'Convertiuse con éxito a OpenID',
	'openidconvertsuccesstext'      => 'Converteu con éxito o seu OpenID a $1.',
	'openidconvertyourstext'        => 'Ese xa é o seu OpenID.',
	'openidconvertothertext'        => 'Ese é o OpenID de alguén.',
	'openidalreadyloggedin'         => "'''Está dentro do sistema, $1!'''

Se quere usar OpenID para acceder ao sistema no futuro, pode [[Special:OpenIDConvert|converter a súa conta para usar OpenID]].",
	'tog-hideopenid'                => 'Agoche o seu <a href="http://openid.net/">OpenID</a> na súa páxina de usuario, se accede ao sistema con OpenID.',
	'openidnousername'              => 'Non foi especificado ningún nome de usuario.',
	'openidbadusername'             => 'O nome de usuario especificado é incorrecto.',
	'openidautosubmit'              => 'Esta páxina inclúe un formulario que debería ser enviado automaticamente se ten o JavaScript permitido.
Se non é así, probe a premer no botón \\"Continuar\\".',
	'openidclientonlytext'          => 'Non pode usar contas deste wiki como OpenIDs noutro sitio.',
	'openidloginlabel'              => 'Dirección URL do OpenID',
	'openidlogininstructions'       => "{{SITENAME}} soporta o [http://openid.net/ OpenID] estándar para unha soa sinatura entre os sitios web.
OpenID permítelle rexistrarse en diferentes sitios web sen usar un contrasinal diferente para cada un.
(Consulte o [http://en.wikipedia.org/wiki/OpenID artigo sobre o OpenID na Wikipedia en inglés] para máis información.)

Se xa ten unha conta en {{SITENAME}}, pode [[Special:Userlogin|acceder ao sistema]] co seu nome de usuario e contrasinal como o fai habitualmente.
Para usar o OpenID no futuro, pode [[Special:OpenIDConvert|converter a súa conta en OpenID]] tras ter accedido ao sistema como fai normalmente.

Hai moitos [http://wiki.openid.net/Public_OpenID_providers proveedores públicos de OpenID] e xa pode ter unha conta co OpenID permitido noutro servizo.

; Outros wikis : Se ten unha conta nun wiki co OpenID permitido, como [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] ou [http://kei.ki/ Keiki], pode acceder ao sistema de {{SITENAME}}  tecleando o '''URL completo''' da súa páxina de usuario nesoutro wiki na caixa de enriba. Por exemplo, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Se ten unha conta no Yahoo!, pode acceder ao sistema deste sitio tecleando o seu OpenID de Yahoo! proporcionado na caixa de enriba. Os URLs do Yahoo! para os OpenID son da seguinte maneira: ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Se ten unha conta con [http://www.aol.com/ AOL], como unha conta [http://www.aim.com/ AIM], pode acceder ao sistema de {{SITENAME}} tecleando o seu OpenID proporcionado polo AOL na caixa de enriba. Os URLs do AOL para os OpenID son da seguinte maneira: ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. O seu nome de usuario debe estar en letras minúsculas e escrito sen espazos.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provicoder.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Se ten un blogue nalgún destes servizos, teclee o URL do seu blogue na caixa de enriba. Por exemplo, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', ou ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'openidemail'          => 'Enmys post-L',
	'openidlanguage'       => 'Çhengey',
	'openidchoosepassword' => 'fockle yn arrey:',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'openidlogin'                   => 'OpenID से लॉग इन करें',
	'openidfinish'                  => 'OpenID लॉग इन पूरा करें',
	'openidserver'                  => 'OpenID सर्वर',
	'openidxrds'                    => 'Yadis फ़ाइल',
	'openidconvert'                 => 'OpenID कन्वर्टर',
	'openiderror'                   => 'प्रमाणिकरण गलती',
	'openiderrortext'               => 'OpenID URL के प्रमाणिकरण में समस्या आई हैं।',
	'openidconfigerror'             => 'OpenID व्यवस्थापन समस्या',
	'openidpermission'              => 'OpenID अनुमति समस्या',
	'openidpermissiontext'          => 'आपने दिये ओपनID से इस सर्वरपर लॉग इन नहीं किया जा सकता हैं।',
	'openidcancel'                  => 'प्रमाणिकरण रद्द कर दिया',
	'openidcanceltext'              => 'ओपनID URL प्रमाणिकरण रद्द कर दिया गया हैं।',
	'openidfailure'                 => 'प्रमाणिकरण पूरा नहीं हुआ',
	'openidfailuretext'             => 'ओपनID URL प्रमाणिकरण पूरा नहीं हो पाया। समस्या: "$1"',
	'openidsuccess'                 => 'प्रमाणिकरण पूर्ण',
	'openidsuccesstext'             => 'ओपनID URL प्रमाणिकरण पूरा हो गया।',
	'openidusernameprefix'          => 'OpenIDसदस्य',
	'openidserverlogininstructions' => '$3 पर $2 नामसे (सदस्य पृष्ठ $1) लॉग इन करनेके लिये अपना कूटशब्द नीचे दें।',
	'openidtrustinstructions'       => 'आप $1 के साथ डाटा शेअर करना चाहते हैं इसकी जाँच करें।',
	'openidallowtrust'              => '$1 को इस सदस्य खातेपर भरोसा रखने की अनुमति दें।',
	'openidnopolicy'                => 'साइटने गोपनियता नीति नहीं बनाई हैं।',
	'openidoptional'                => 'वैकल्पिक',
	'openidrequired'                => 'आवश्यक',
	'openidnickname'                => 'उपनाम',
	'openidfullname'                => 'पूरानाम',
	'openidemail'                   => 'इ-मेल एड्रेस',
	'openidlanguage'                => 'भाषा',
	'openidchoosefull'              => 'आपका पूरा नाम ($1)',
	'openidchooseurl'               => 'आपके OpenID से लिया एक नाम ($1)',
	'openidchooseauto'              => 'एक अपनेआप बनाया नाम ($1)',
	'openidchoosemanual'            => 'आपके पसंद का नाम:',
	'openidchooseexisting'          => 'इस विकिपर पहले से होने वाला खाता:',
	'openidchoosepassword'          => 'कूटशब्द:',
	'openidconvertsuccess'          => 'ओपनID में बदल दिया गया हैं',
	'openidconvertsuccesstext'      => 'आपने आपका ओपनID $1 में बदल दिया हैं।',
	'openidconvertyourstext'        => 'यह आपका ही ओपनID हैं।',
	'openidconvertothertext'        => 'यह किसी औरका ओपनID हैं।',
	'tog-hideopenid'                => 'अगर आपने ओपनID का इस्तेमाल करके लॉग इन किया हैं, तो आपके सदस्यपन्नेपर आपका <a href="http://openid.net/">ओपनID</a> छुपायें।',
	'openidnousername'              => 'सदस्यनाम दिया नहीं हैं।',
	'openidbadusername'             => 'गलत सदस्यनाम दिया हैं।',
	'openidclientonlytext'          => 'इस विकिपर खोले गये खाते आप अन्य साइटपर ओपनID के तौर पर इस्तेमाल नहीं कर सकतें हैं।',
	'openidloginlabel'              => 'ओपनID URL',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'openidchoosepassword' => 'kontra-senyas:',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'openidlogin'                   => 'Přizjewjenje z OpenID',
	'openidfinish'                  => 'Přizjewjenje OpenID skónčić',
	'openidserver'                  => 'Serwer OpenID',
	'openidconvert'                 => 'Konwerter OpenID',
	'openiderror'                   => 'Pruwowanski zmylk',
	'openiderrortext'               => 'Zmylk je při pruwowanju URL OpenID wustupił.',
	'openidconfigerror'             => 'OpenID konfiguraciski zmylk',
	'openidconfigerrortext'         => 'Składowanska konfiguracija OpenID zu tutón wiki je njepłaćiwy. Prošu skonsultuj administratora tutoho sydła.',
	'openidpermissiontext'          => 'OpenID, kotryž sy podał, njesmě so za přizjewjenje pola tutoho serwera wužiwać.',
	'openidusernameprefix'          => 'Wužiwar OpenID',
	'openidserverlogininstructions' => 'Zapodaj deleka swoje hesło, zo by so pola $3 jako wužiwar $2 přizjewił (wužiwarska strona $1).',
	'openidtrustinstructions'       => 'Pruwuj, hač chceš z $1 daty dźělić.',
	'openidallowtrust'              => '$1 dowolić, zo by so tutomu wužiwarskemu konće dowěriło.',
	'openidnopolicy'                => 'Sydło njeje zasady za priwatnosć podało.',
	'openidoptional'                => 'Opcionalny',
	'openidrequired'                => 'Trěbny',
	'openidnickname'                => 'Přimjeno',
	'openidfullname'                => 'Dospołne mjeno',
	'openidemail'                   => 'E-mejlowa adresa',
	'openidlanguage'                => 'Rěč',
	'openidnotavailable'            => 'Twoje preferowane přimjeno ($1) so hižo wot druheho wužiwarja wužiwa.',
	'openidnotprovided'             => 'Twój serwer OpenID njedoda přimjeno (pak dokelž njemóže pak dokelž njejsy je jemu zdźělił).',
	'openidchooseinstructions'      => 'Wšitcy wužiwarjo trjebaja přimjeno; móžěs jedne z opcijow deleka wuzwolić.',
	'openidchoosefull'              => 'Twoje dospołne mjeno ($1)',
	'openidchooseurl'               => 'Mjeno wzate z twojeho OpenID ($1)',
	'openidchooseauto'              => 'Awtomatisce wutworjene mjeno ($1)',
	'openidchoosemanual'            => 'Mjeno twojeje wólby:',
	'openidconvertinstructions'     => 'Tutón formular ći dowola swoje wužiwarske konto zmňić, zo by URL OpenID wužiwał.',
	'openidconvertsuccess'          => 'Wuspěšnje do OpenID konwertowany.',
	'openidconvertsuccesstext'      => 'Sy swój OpenID wuspěšnje do $1 konwertował.',
	'openidconvertyourstext'        => 'To je hižo twój OpenID.',
	'openidconvertothertext'        => 'To je OpenID někoho druheho.',
	'openidalreadyloggedin'         => "'''Sy hižo přizjewjeny, $1!'''

Jeli chceš OpenID wužiwać, hdyž přichodnje přizjewiš, móžeš [[Special:OpenIDConvert|swoje konto za wužiwanje OpenID konwertować]].",
	'tog-hideopenid'                => 'Twój <a href="http://openid.net/">OpenID</a> na twojej wužiwarskej stronje schować, jeli so z OpenID přizjewješ.',
	'openidlogininstructions'       => 'Zapodaj swój identifikator OpenID, zo by so přizjewił:',
);

/** Hungarian (Magyar)
 * @author Tgr
 */
$messages['hu'] = array(
	'openid-desc'                   => 'Bejelentkezés [http://openid.net/ OpenID] azonosítóval, és más OpenID-kompatibilis weboldalak használata a wikis azonosítóval',
	'openidlogin'                   => 'Bejelentkezés OpenID-vel',
	'openidfinish'                  => 'OpenID bejelentkezés befejezése',
	'openidserver'                  => 'OpenID szerver',
	'openidxrds'                    => 'Yadis fájl',
	'openidconvert'                 => 'OpenID konverter',
	'openiderror'                   => 'Hiba az ellenőrzés során',
	'openiderrortext'               => 'Az OpenID URL elenőrzése nem sikerült.',
	'openidconfigerror'             => 'OpenID konfigurációs hiba',
	'openidconfigerrortext'         => 'A wiki OpenID-tárhely-beállítása hibás. Beszélj a wiki üzemeltetőjével.',
	'openidpermission'              => 'OpenID jogosultság hiba',
	'openidpermissiontext'          => 'Ezzel az OpenID-vel nem vagy jogosult belépni erre a wikire.',
	'openidcancel'                  => 'Ellenőrzés visszavonva',
	'openidcanceltext'              => 'Az OpenID URL ellenőrzése vissza lett vonva.',
	'openidfailure'                 => 'Ellenőrzés sikertelen',
	'openidfailuretext'             => 'Az OpenID URL ellenőrzése nem sikerült. A kapott hibaüzenet: „$1”',
	'openidsuccess'                 => 'Sikeres ellenőrzés',
	'openidsuccesstext'             => 'Az OpenID URL ellenőrzése sikerült.',
	'openidserverlogininstructions' => 'Add meg a jelszót a(z) $3 oldalra való bejelentkezéshez $2 néven (userlap: $1).',
	'openidtrustinstructions'       => 'Adatok megosztása a(z) $1 oldallal.',
	'openidallowtrust'              => '$1 megbízhat ebben a felhasználóban.',
	'openidnopolicy'                => 'Az oldalnak nincsen adatvédelmi szabályzata.',
	'openidpolicy'                  => 'További információkért lásd az <a target="_new" href="$1">adatvédelmi szabályzatot</a>.',
	'openidoptional'                => 'Opcionális',
	'openidrequired'                => 'Kötelező',
	'openidnickname'                => 'Felhasználónév',
	'openidfullname'                => 'Teljes név',
	'openidemail'                   => 'Email-cím',
	'openidlanguage'                => 'Nyelv',
	'openidnotavailable'            => 'Az alapértelmezett felhasználónevedet ($1) már használja valaki.',
	'openidnotprovided'             => 'Az OpenID szervered nem adta meg a felhasználónevedet (vagy azért, mert nem tudja, vagy mert nem engedted neki).',
	'openidchooseinstructions'      => 'Mindenkinek választania kell egy felhasználónevet; választhatsz egyet az alábbi opciókból.',
	'openidchoosefull'              => 'A teljes neved ($1)',
	'openidchooseurl'               => 'Az OpenID-dből vett név ($1)',
	'openidchooseauto'              => 'Egy automatikusan generált név ($1)',
	'openidchoosemanual'            => 'Egy általad megadott név:',
	'openidchooseexisting'          => 'Egy létező felhasználónév erről a wikiről:',
	'openidchoosepassword'          => 'jelszó:',
	'openidconvertinstructions'     => 'Ezzel az űrlappal átállíthatod a felhasználói fiókodat, hogy egy OpenId URL-t használjon.',
	'openidconvertsuccess'          => 'Sikeres átállás OpenID-re',
	'openidconvertsuccesstext'      => 'Sikeresen átállítottad az OpenID-det erre: $1.',
	'openidconvertyourstext'        => 'Ez az OpenID már a tiéd.',
	'openidconvertothertext'        => 'Ez az OpenID másvalakié.',
	'openidalreadyloggedin'         => "'''Már be vagy jelentkezve, $1!'''

Ha ezentúl az OpenID-del akarsz bejelentkezni, [[Special:OpenIDConvert|konvertálhatod a felhasználói fiókodat OpenID-re]].",
	'tog-hideopenid'                => 'Az <a href="http://openid.net/">OpenID</a>-d elrejtése a felhasználói lapodon, amikor OpenID-vel jelentkezel be.',
	'openidnousername'              => 'Nem adtál meg felhasználónevet.',
	'openidbadusername'             => 'Rossz felhasználónevet adtál meg.',
	'openidautosubmit'              => 'Az ezen az oldalon lévő űrlap automatikusan elküldi az adatokat, ha a JavaScript engedélyezve van. Ha nem, használd a \\"Tovább\\" gombot.',
	'openidclientonlytext'          => 'Az itteni felhasználónevedet nem használhatod OpenID-ként más weboldalon.',
	'openidlogininstructions'       => "A(z) {{SITENAME}} támogatja az [http://openid.net/ OpenID]-alapú bejelentkezést.
A OpenID lehetővé teszi, hogy számos különböző weboldalra jelentkezz be úgy, hogy csak egyszer kell megadnod a jelszavadat. (Lásd [http://hu.wikipedia.org/wiki/OpenID a Wikipédia OpenID cikkét] további információkért.)

Ha már regisztráltál korábban, [[Special:Userlogin|bejelentkezhetsz]] a felhasználóneveddel és a jelszavaddal, ahogy eddig is. Ha a továbbiakban OpenID-t akarsz használni, [[Special:OpenIDConvert|állítsd át a felhasználói fiókodat OpenID-re]], miután bejelentkeztél.

Számos [http://wiki.openid.net/Public_OpenID_providers nyilvános OpenID szolgáltató] van, lehetséges, hogy van már OpenID-fiókod egy másik weboldalon.

; Más wikik: ha regisztráltál egy OpenID-kompatibilis wikin, mint a [http://wikitravel.org/ Wikitravel], a [http://www.wikihow.com/ wikiHow], a [http://vinismo.com/ Vinismo], az [http://aboutus.org/ AboutUs] vagy a [http://kei.ki/ Keiki], bejelentkezhetsz ide az ottani felhasználói lapod '''teljes címének''' megadásával. (Például ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.)
; [http://openid.yahoo.com/ Yahoo!] :  ha van Yahoo! azonosítód, bejelentkezhetsz a Yahoo! OpenID-d megadásával. A Yahoo! OpenID-k ''<nowiki>https://me.yahoo.com/felhasználónév</nowiki>'' alakúak.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Ha van valamilyen [http://www.aol.com/ AOL] azonosítód, például egy [http://www.aim.com/ AIM] felhasználónév, bejelentkezhetsz az AOL OpenID-del. Az AOL OpenID-k ''<nowiki>http://openid.aol.com/felhasználónév</nowiki>'' alakúak (a felhasználónév csupa kisbetűvel, szóköz nélkül).
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : ezek a blogszolgáltatók mind biztosítanak OpenID-t, a következő formákban: ''<nowiki>http://felhasználónév.blogspot.com/</nowiki>'', ''<nowiki>http://felhasználónév.wordpress.com/</nowiki>'', ''<nowiki>http://felhasználónév.livejournal.com/</nowiki>'', or ''<nowiki>http://felhasználónév.vox.com/</nowiki>''.",
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'openidchoosepassword' => 'contrasigno:',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'openidlanguage' => 'Bahasa',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'openidchoosepassword' => 'lykilorð:',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'openidxrds'               => 'Berkas Yadis',
	'openiderror'              => 'Kaluputan vérifikasi',
	'openidcancel'             => 'Vérifikasi dibatalaké',
	'openidfailure'            => 'Vérifikasi gagal',
	'openidtrustinstructions'  => 'Mangga dipriksa yèn panjenengan péngin mbagi data karo $1.',
	'openidallowtrust'         => 'Marengaké $1 percaya karo rékening panganggo iki.',
	'openidnopolicy'           => 'Situs iki durung spésifikasi kawicaksanan privasi.',
	'openidoptional'           => 'Opsional',
	'openidrequired'           => 'Diperlokaké',
	'openidnickname'           => 'Jeneng sesinglon',
	'openidfullname'           => 'Jeneng jangkep',
	'openidemail'              => 'Alamat e-mail',
	'openidlanguage'           => 'Basa',
	'openidchooseinstructions' => 'Kabèh panganggo prelu jeneng sesinglon;
panjenengan bisa milih salah siji saka opsi ing ngisor iki.',
	'openidchoosefull'         => 'Jeneng pepak panjenengan ($1)',
	'openidchooseauto'         => 'Jeneng ($1) sing digawé sacara otomatis',
	'openidchoosemanual'       => 'Jeneng miturut pilihan panjenengan:',
	'openidchoosepassword'     => 'tembung sandhi:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author Lovekhmer
 */
$messages['km'] = array(
	'openiderror'          => 'កំហុស​ក្នុងការផ្ទៀងផ្ទាត់',
	'openidcancel'         => 'ការផ្ទៀងផ្ទាត់​ត្រូវបានលុបចោល',
	'openidfailure'        => 'ការផ្ទៀងផ្ទាត់បរាជ័យ',
	'openidsuccess'        => 'ផ្ទៀងផ្ទាត់ដោយជោគជ័យ',
	'openidoptional'       => 'ជាជំរើស',
	'openidrequired'       => 'ត្រូវការជាចាំបាច់',
	'openidnickname'       => 'ឈ្មោះហៅក្រៅ',
	'openidfullname'       => 'ឈ្មោះពេញ',
	'openidemail'          => 'អាសយដ្ឋានអ៊ីមែល',
	'openidlanguage'       => 'ភាសា',
	'openidnotavailable'   => 'ឈ្មោះហៅក្រៅ​ដែលអ្នកពេញចិត្ត ($1) ត្រូវបានប្រើដោយ​អ្នកប្រើប្រាស់​ម្នាក់​ផ្សេងទៀតហើយ។',
	'openidchoosefull'     => 'ឈ្មោះពេញ​របស់អ្នក ($1)',
	'openidchoosepassword' => 'ពាក្យសំងាត់៖',
);

/** Korean (한국어)
 * @author Ficell
 */
$messages['ko'] = array(
	'openidchoosepassword' => '비밀번호:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'openidlanguage' => 'Sproch',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'openidxrds'               => 'Yadis Fichier',
	'openiderror'              => 'Feeler bäi der Iwwerpréifung',
	'openidsuccess'            => 'Iwwerpréifung huet geklappt',
	'openidusernameprefix'     => 'OpenIDBenotzer',
	'openidtrustinstructions'  => 'Klickt un wann Dir Donnéeën mat $1 deele wellt.',
	'openidallowtrust'         => 'Erlaabt $1 fir dësem Benotzerkont ze vertrauen.',
	'openidoptional'           => 'Facultatif',
	'openidrequired'           => 'Obligatoresch',
	'openidnickname'           => 'Spëtznumm',
	'openidfullname'           => 'Ganze Numm',
	'openidemail'              => 'E-Mailadress',
	'openidlanguage'           => 'Sprooch',
	'openidnotavailable'       => 'De Spëtznumm deen Dir wollt hun ($1) gëtt scho vun engem anere Benotzer benotzt.',
	'openidchooseinstructions' => 'All Benotzer brauchen e Spëtznumm; Dir kënnt iech ee vun de Méiglechkeeten ënnendrënner auswielen.',
	'openidchoosefull'         => 'Äre ganze Numm ($1)',
	'openidchooseauto'         => 'Een Numm deen automatesch generéiert gouf ($1)',
	'openidchoosemanual'       => 'E Numm vun ärer Wiel:',
	'openidchooseexisting'     => 'E Benotzerkont den et op dëser Wiki scho gëtt:',
	'openidchoosepassword'     => 'Passwuert:',
	'openidnousername'         => 'Kee Benotzernumm uginn.',
	'openidbadusername'        => 'Falsche Benotzernumm uginn.',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'openidlogin'                   => 'ഓപ്പണ്‍ ഐഡി ഉപയോഗിച്ച് ലോഗിന്‍ ചെയ്യുക',
	'openidserver'                  => 'OpenID സെര്‍‌വര്‍',
	'openidcancel'                  => 'സ്ഥിരീകരണം റദ്ദാക്കിയിരിക്കുന്നു',
	'openidfailure'                 => 'സ്ഥിരീകരണം പരാജയപ്പെട്ടു',
	'openidsuccess'                 => 'സ്ഥിരീകരണം വിജയിച്ചു',
	'openidusernameprefix'          => 'ഓപ്പണ്‍ ഐഡി ഉപയോക്താവ്',
	'openidserverlogininstructions' => '$3യിലേക്ക് $2 എന്ന ഉപയോക്താവായി (ഉപയോക്തൃതാള്‍ $1) ലോഗിന്‍ ചെയ്യുവാന്‍ താങ്കളുടെ രഹസ്യവാക്ക് താഴെ രേഖപ്പെടുത്തുക.',
	'openidtrustinstructions'       => '$1 താങ്കളുടെ ഡാറ്റ പങ്കുവെക്കണമോ എന്ന കാര്യം പരിശോധിക്കുക.',
	'openidnopolicy'                => 'സൈറ്റ് സ്വകാര്യതാ നയം കൊടുത്തിട്ടില്ല.',
	'openidoptional'                => 'നിര്‍ബന്ധമില്ല',
	'openidrequired'                => 'അത്യാവശ്യമാണ്‌',
	'openidnickname'                => 'ചെല്ലപ്പേര്',
	'openidfullname'                => 'പൂര്‍ണ്ണനാമം',
	'openidemail'                   => 'ഇമെയില്‍ വിലാസം',
	'openidlanguage'                => 'ഭാഷ',
	'openidnotavailable'            => 'താങ്കള്‍ തിരഞ്ഞെടുത്ത വിളിപ്പേര്‌ ($1) മറ്റൊരാള്‍ ഉപയോഗിക്കുന്നതാണ്‌.',
	'openidchooseinstructions'      => 'എല്ലാ ഉപയോക്താക്കള്‍ക്കും ഒരു വിളിപ്പേരു ആവശ്യമാണ്‌. താഴെ കൊടുത്തിരിക്കുന്നവയില്‍ നിന്നു ഒരെണ്ണം നിങ്ങള്‍ക്ക് തിരഞ്ഞെടുക്കാവുന്നതാണ്‌.',
	'openidchoosefull'              => 'താങ്കളുടെ പൂര്‍ണ്ണനാമം ($1)',
	'openidchooseurl'               => 'താങ്കളുടെ ഓപ്പണ്‍‌ഐഡിയില്‍ നിന്നു തിരഞ്ഞെടുത്ത ഒരു പേര്‌ ($1)',
	'openidchooseauto'              => 'യാന്ത്രികമായി ഉണ്ടാക്കിയ പേര്‌ ($1)',
	'openidchoosemanual'            => 'താങ്കള്‍ക്ക് ഇഷ്ടമുള്ള ഒരു പേര്‌:',
	'openidchooseexisting'          => 'ഈ വിക്കിയില്‍ നിലവിലുള്ള അക്കൗണ്ട്:',
	'openidchoosepassword'          => 'രഹസ്യവാക്ക്:',
	'openidconvertsuccess'          => 'ഓപ്പണ്‍ ഐഡിയിലേക്ക് വിജയകരമായി പരിവര്‍ത്തനം ചെയ്തിരിക്കുന്നു',
	'openidconvertsuccesstext'      => 'താങ്കളുടെ ഓപ്പണ്‍‌ഐഡി $1ലേക്കു വിജയകരമായി പരിവര്‍ത്തനം ചെയ്തിരിക്കുന്നു.',
	'openidconvertyourstext'        => 'ഇതു ഇപ്പോള്‍ തന്നെ നിങ്ങളുടെ ഓപ്പണ്‍‌ഐഡിയാണ്‌.',
	'openidconvertothertext'        => 'ഇതു മറ്റാരുടേയോ ഓപ്പണ്‍‌ഐഡിയാണ്‌.',
	'openidnousername'              => 'ഉപയോക്തൃനാമം തിരഞ്ഞെടുത്തിട്ടില്ല.',
	'openidbadusername'             => 'അസാധുവായ ഉപയോക്തൃനാമമാണു തിരഞ്ഞെടുത്തിരിക്കുന്നത.',
	'openidloginlabel'              => 'ഓപ്പണ്‍‌ഐഡി വിലാസം',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'openid-desc'                   => 'विकिवर [http://openid.net/ ओपनID] वापरून प्रवेश करा, तसेच कुठल्याही इतर ओपनID संकेतस्थळावर विकि सदस्य नाम वापरून प्रवेश करा',
	'openidlogin'                   => 'ओपनID वापरून प्रवेश करा',
	'openidfinish'                  => 'ओपनID प्रवेश प्रक्रिया पूर्ण करा',
	'openidserver'                  => 'ओपनID सर्व्हर',
	'openidxrds'                    => 'Yadis संचिका',
	'openidconvert'                 => 'ओपनID कन्व्हर्टर',
	'openiderror'                   => 'तपासणी त्रुटी',
	'openiderrortext'               => 'ओपनID URL च्या तपासणीमध्ये त्रुटी आढळलेली आहे.',
	'openidconfigerror'             => 'ओपनID व्यवस्थापन त्रुटी',
	'openidconfigerrortext'         => 'या विकिसाठीचे ओपनID जतन व्यवस्थापन चुकीचे आहे.
कृपया प्रबंधकांशी संपर्क करा.',
	'openidpermission'              => 'ओपनID परवानगी त्रुटी',
	'openidpermissiontext'          => 'आपण दिलेल्या ओपनID या सर्व्हरवर प्रवेश करता येणार नाही.',
	'openidcancel'                  => 'तपासणी रद्द',
	'openidcanceltext'              => 'ओपनID URL ची तपासणी रद्द केलेली आहे.',
	'openidfailure'                 => 'तपासणी पूर्ण झाली नाही',
	'openidfailuretext'             => 'ओपनID URL ची तपासणी पूर्ण झालेली नाही. त्रुटी संदेश: "$1"',
	'openidsuccess'                 => 'तपासणी पूर्ण',
	'openidsuccesstext'             => 'ओपनID URL ची तपासणी पूर्ण झालेली आहे.',
	'openidusernameprefix'          => 'ओपनIDसदस्य',
	'openidserverlogininstructions' => '$3 वर $2 या नावाने (सदस्य पान $1) प्रवेश करण्यासाठी आपला परवलीचा शब्द खाली लिहा.',
	'openidtrustinstructions'       => 'तुम्ही $1 बरोबर डाटा शेअर करू इच्छिता का याची तपासणी करा.',
	'openidallowtrust'              => '$1 ला ह्या सदस्य खात्यावर विश्वास ठेवण्याची अनुमती द्या.',
	'openidnopolicy'                => 'संकेतस्थळावर गोपनियता नीती दिलेली नाही.',
	'openidpolicy'                  => 'अधिक माहितीसाठी <a target="_new" href="$1">गुप्तता नीती</a> तपासा.',
	'openidoptional'                => 'वैकल्पिक',
	'openidrequired'                => 'आवश्यक',
	'openidnickname'                => 'टोपणनाव',
	'openidfullname'                => 'पूर्णनाव',
	'openidemail'                   => 'इमेल पत्ता',
	'openidlanguage'                => 'भाषा',
	'openidnotavailable'            => 'तुम्ही दिलेले टोपणनाव ($1) अगोदरच दुसर्‍या सदस्याने वापरलेले आहे.',
	'openidnotprovided'             => 'तुमच्या ओपनID सर्व्हरने टोपणनाव दिले नाही (कदाचित तो देऊ शकत नसेल किंवा तुम्ही देण्यास मनाई केली असेल).',
	'openidchooseinstructions'      => 'सर्व सदस्यांना टोपणनाव असणे आवश्यक आहे;
तुम्ही खाली दिलेल्या नावांमधून एक निवडू शकता.',
	'openidchoosefull'              => 'तुमचे पूर्ण नाव ($1)',
	'openidchooseurl'               => 'तुमच्या ओपनID मधून घेतलेले नाव ($1)',
	'openidchooseauto'              => 'एक आपोआप तयार झालेले नाव ($1)',
	'openidchoosemanual'            => 'तुमच्या आवडीचे नाव:',
	'openidchooseexisting'          => 'या विकिवरील अस्तित्वात असलेले सदस्य खाते:',
	'openidchoosepassword'          => 'परवलीचा शब्द:',
	'openidconvertinstructions'     => 'हा अर्ज तुम्हाला ओपनID URL वापरण्यासाठी तुमचे सदस्यनाव बदलण्याची परवानगी देतो.',
	'openidconvertsuccess'          => 'ओपनID मध्ये बदल पूर्ण झालेले आहेत',
	'openidconvertsuccesstext'      => 'तुम्ही तुमचा ओपनID $1 मध्ये यशस्वीरित्या बदललेला आहे.',
	'openidconvertyourstext'        => 'हा तुमचाच ओपनID आहे.',
	'openidconvertothertext'        => 'हा दुसर्‍याचा ओपनID आहे.',
	'openidalreadyloggedin'         => "'''$1, तुम्ही अगोदरच प्रवेश केलेला आहे!'''

जर तुम्ही भविष्यात ओपनID वापरून प्रवेश करू इच्छित असाल, तर तुम्ही [[Special:OpenIDConvert|तुमचे खाते ओपनID साठी बदलू शकता]].",
	'tog-hideopenid'                => 'जर तुम्ही ओपनID वापरून प्रवेश केला, तर तुमच्या सदस्यपानावरील तुमचा <a href="http://openid.net/">ओपनID</a> लपवा.',
	'openidnousername'              => 'सदस्यनाव दिले नाही.',
	'openidbadusername'             => 'चुकीचे सदस्यनाव दिले आहे.',
	'openidautosubmit'              => 'या पानावरील अर्ज जर तुम्ही जावास्क्रीप्ट वापरत असाल तर आपोआप पाठविला जाईल. जर तसे झाले नाही, तर \\"पुढे\\" कळीवर टिचकी मारा.',
	'openidclientonlytext'          => 'या विकिवरील खाती तुम्ही इतर संकेतस्थळांवर ओपनID म्हणून वापरू शकत नाही.',
	'openidloginlabel'              => 'ओपनID URL',
	'openidlogininstructions'       => "{{SITENAME}} [http://openid.net/ ओपनID] वापरून विविध संकेतस्थळांवर प्रवेश करण्याची अनुमती देते.
ओपनID वापरुन तुम्ही एकाच परवलीच्या शब्दाने विविध संकेतस्थळांवर प्रवेश करू शकता.
(अधिक माहिती साठी [http://en.wikipedia.org/wiki/OpenID विकिपीडिया वरील ओपनID लेख] पहा.)

जर {{SITENAME}} वर अगोदरच तुमचे खाते असेल, तुम्ही नेहमीप्रमाणे तुमचे सदस्यनाव व परवलीचा शब्द वापरून [[Special:Userlogin|प्रवेश करा]].
भविष्यात ओपनID वापरण्यासाठी, तुम्ही प्रवेश केल्यानंतर [[Special:OpenIDConvert|तुमचे खाते ओपनID मध्ये बदला]].

अनेक [http://wiki.openid.net/Public_OpenID_providers Public ओपनID वितरक] आहेत, व तुम्ही अगोदरच ओपनID चे खाते उघडले असण्याची शक्यता आहे.

; इतर विकि : जर तुमच्याकडे ओपनID वापरणार्‍या विकिवर खाते असेल, जसे की [http://wikitravel.org/ विकिट्रॅव्हल], [http://www.wikihow.com/ विकिहाऊ], [http://vinismo.com/ विनिस्मो], [http://aboutus.org/ अबाउट‍अस] किंवा [http://kei.ki/ कैकी], तुम्ही {{SITENAME}} वर तुमच्या त्या विकिवरील सदस्य पानाची '''पूर्ण URL''' वरील पृष्ठपेटीमध्ये देऊन प्रवेश करू शकता. उदाहरणार्थ, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ याहू!] : जर तुमच्याकडे याहू! चे खाते असेल, तर तुम्ही वरील पृष्ठपेटीमध्ये याहू! ने दिलेल्या ओपनID चा वापर करून प्रवेश करू शकता. याहू! ओपनID URL ची रुपरेषा ''<nowiki>https://me.yahoo.com/तुमचेसदस्यनाव</nowiki>'' अशी आहे.
; [http://dev.aol.com/aol-and-63-million-openids एओएल] : जर तुमच्याकडे [http://www.aol.com/ एओएल]चे खाते असेल, जसे की [http://www.aim.com/ एम] खाते, तुम्ही {{SITENAME}} वर वरील पृष्ठपेटीमध्ये एओएल ने दिलेल्या ओपनID चा वापर करून प्रवेश करू शकता. एओएल ओपनID URL ची रुपरेषा ''<nowiki>http://openid.aol.com/तुमचेसदस्यनाव</nowiki>'' अशी आहे. तुमच्या सदस्यनावात अंतर (space) चालणार नाही.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html ब्लॉगर], [http://faq.wordpress.com/2007/03/06/what-is-openid/ वर्डप्रेस.कॉम], [http://www.livejournal.com/openid/about.bml लाईव्ह जर्नल], [http://bradfitz.vox.com/library/post/openid-for-vox.html वॉक्स] : जर यापैकी कुठेही तुमचा ब्लॉग असेल, तर वरील पृष्ठपेटीमध्ये तुमच्या ब्लॉगची URL भरा. उदाहरणार्थ, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', किंवा ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'openidlanguage' => 'Tlahtōlli',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'openid-desc'                   => 'Aanmelden bij de wiki met een [http://openid.net/ OpenID] en aanmelden bij andere websites die OpenID ondersteunen met een wikigebruiker',
	'openidlogin'                   => 'Aanmelden met OpenID',
	'openidfinish'                  => 'Aanmelden met OpenID afronden',
	'openidserver'                  => 'OpenID-server',
	'openidxrds'                    => 'Yadis-bestand',
	'openidconvert'                 => 'OpenID-convertor',
	'openiderror'                   => 'Verificatiefout',
	'openiderrortext'               => 'Er is een fout opgetreden tijdens de verificatie van de OpenID URL.',
	'openidconfigerror'             => 'Fout in de installatie van OpenID',
	'openidconfigerrortext'         => "De instellingen van de opslag van OpenID's voor deze wiki klopt niet.
Raadpleeg alstublieft de beheerder van de site.",
	'openidpermission'              => 'Fout in de rechten voor OpenID',
	'openidpermissiontext'          => 'Met de OpenID die u hebt opgegeven kunt u niet aanmelden bij deze server.',
	'openidcancel'                  => 'Verificatie geannuleerd',
	'openidcanceltext'              => 'De verificatie van de OpenID URL is geannuleerd.',
	'openidfailure'                 => 'Verificatie mislukt',
	'openidfailuretext'             => 'De verificatie van de OpenID URL is mislukt. Foutmelding: "$1"',
	'openidsuccess'                 => 'Verificatie geslaagd',
	'openidsuccesstext'             => 'De verificatie van de OpenID URL is geslaagd.',
	'openidusernameprefix'          => 'OpenIDGebruiker',
	'openidserverlogininstructions' => 'Voer uw wachtwoord hieronder in om aan te melden bij $3 als gebruiker $2 (gebruikerspagina $1).',
	'openidtrustinstructions'       => 'Controleer of u gegevens wilt delen met $1.',
	'openidallowtrust'              => 'Toestaan dat $1 deze gebruiker vertrouwt.',
	'openidnopolicy'                => 'De site heeft geen privacybeleid.',
	'openidpolicy'                  => 'Lees het <a target="_new" href="$1">privacybeleid</a> voor meer informatie.',
	'openidoptional'                => 'Optioneel',
	'openidrequired'                => 'Verplicht',
	'openidnickname'                => 'Nickname',
	'openidfullname'                => 'Volledige naam',
	'openidemail'                   => 'E-mailadres',
	'openidlanguage'                => 'Taal',
	'openidnotavailable'            => 'Uw voorkeursnaam ($1) wordt al gebruikt door een andere gebruiker.',
	'openidnotprovided'             => 'Uw OpenID-server heeft geen gebruikersnaam opgegeven (omdat het niet wordt ondersteund of omdat u dit zo hebt opgegeven).',
	'openidchooseinstructions'      => 'Alle gebruikers moeten een gebruikersnaam kiezen. U kunt er een kiezen uit de onderstaande opties.',
	'openidchoosefull'              => 'Uw volledige naam ($1)',
	'openidchooseurl'               => 'Een naam uit uw OpenID ($1)',
	'openidchooseauto'              => 'Een automatisch samengestelde naam ($1)',
	'openidchoosemanual'            => 'Een te kiezen naam:',
	'openidchooseexisting'          => 'Een bestaande gebruiker op deze wiki:',
	'openidchoosepassword'          => 'wachtwoord:',
	'openidconvertinstructions'     => 'Met dit formulier kunt u uw gebruiker als OpenID URL gebruiken.',
	'openidconvertsuccess'          => 'Omzetten naar OpenID geslaagd',
	'openidconvertsuccesstext'      => 'U hebt uw OpenID succesvol omgezet naar $1.',
	'openidconvertyourstext'        => 'Dat is al uw OpenID.',
	'openidconvertothertext'        => 'Iemand anders heeft die OpenID al in gebruik.',
	'openidalreadyloggedin'         => "'''U bent al aangemeld, $1!'''

Als u in de toekomst uw OpenID wilt gebruiken om aan te melden, [[Special:OpenIDConvert|zet uw gebruiker dan om naar OpenID]].",
	'tog-hideopenid'                => 'Bij aanmelden met <a href="http://openid.net/">OpenID</a>, uw OpenID op uw gebruikerspagina verbergen.',
	'openidnousername'              => 'Er is geen gebruikersnaam opgegeven.',
	'openidbadusername'             => 'De opgegeven gebruikersnaam is niet toegestaan.',
	'openidautosubmit'              => 'Deze pagina bevat een formulier dat automatisch wordt verzonden als JavaScript is ingeschaked.
Als dat niet werkt, klik dan op de knop "Doorgaan".',
	'openidclientonlytext'          => 'U kunt gebruikers van deze wiki niet als OpenID gebruiken op een andere site.',
	'openidloginlabel'              => 'OpenID URL',
	'openidlogininstructions'       => "{{SITENAME}} ondersteunt de standaard [http://openid.net/ OpenID] voor maar een keer hoeven aanmelden voor meerdere websites.
Met OpenID kunt u aanmelden bij veel verschillende websites zonder voor iedere site opnieuw een wachtwoord te moeten opgeven.
Zie het [http://nl.wikipedia.org/wiki/OpenID Wikipedia-artikel over OpenID] voor meer informatie.

Als u al een gebruiker hebt op {{SITENAME}}, dan kunt u aanmelden met uw gebruikersnaam en wachtwoord zoals u normaal doet. Om in de toekomst OpenID te gebruiken, kunt u uw [[Special:OpenIDConvert|gebruiker naar OpenID omzetten]] nadat u hebt aangemeld.

Er zijn veel [http://wiki.openid.net/Public_OpenID_providers publieke OpenID-providers], en wellicht hebt u al een gebruiker voor OpenID bij een andere dienst.

; Andere wiki's : Als u een gebruiker hebt op een andere wiki die OpenID understeunt, zoals [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] of [http://kei.ki/ Keiki], dan kunt u bij {{SITENAME}} aanmelden door de '''volledige URL''' van uw gebruikerspagina in die andere wiki in het veld hierboven in te geven. Voorbeeld: ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Als u een gebruiker hebt bij Yahoo!, dan kunt u bij deze site aanmelden door uw OpenID van Yahoo! in het veld hierboven in te voeren. Een URL van een OpenID van Yahoo! heeft de volgende opmaak: ''<nowiki>https://me.yahoo.com/gebruikersnaam</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Als u een gebruiker hebt bij [http://www.aol.com/ AOL], zoals een [http://www.aim.com/ AIM]-gebruiker, dan kunt u bij {{SITENAME}} aanmelden door uw OpenID van AOL in het veld hierboven in te voeren. Een URL van een OpenID van AOL heeft de volgende opmaak: ''<nowiki>http://openid.aol.com/gebruikersnaam</nowiki>''. Uw gebruikersnaam moet in kleine letters ingevoerd worden, zonder spaties.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Als u een blog hebt bij een van de voorgaande diensten, dan kunt u bij deze site aanmelden door als uw OpenID de URL van uw blog in te geven in het veld hierboven. Bijvoorbeeld: ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'' of ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'openidoptional'       => 'Valfri',
	'openidnickname'       => 'Kallenamn',
	'openidlanguage'       => 'Språk',
	'openidchoosepassword' => 'passord:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'openid-desc'                   => 'Logg inn på wikien med en [http://openid.net/ OpenID] og logg inn på andre sider som bruker OpenID med kontoen herfra',
	'openidlogin'                   => 'Logg inn med OpenID',
	'openidfinish'                  => 'Fullfør OpenID-innlogging',
	'openidserver'                  => 'OpenID-tjener',
	'openidxrds'                    => 'Yadis-fil',
	'openidconvert'                 => 'OpenID-konvertering',
	'openiderror'                   => 'Bekreftelsesfeil',
	'openiderrortext'               => 'En feil oppsto under bekrefting av OpenID-adressen.',
	'openidconfigerror'             => 'Oppsettsfeil med OpenID',
	'openidconfigerrortext'         => 'Lagringsoppsettet for OpenID på denne wikien er ugyldig. Vennligst oppsøk sidens administrator om problemet.',
	'openidpermission'              => 'Tillatelsesfeil med OpenID',
	'openidpermissiontext'          => 'Du kan ikke logge inn på denne tjeneren med OpenID-en du oppga.',
	'openidcancel'                  => 'Bekreftelse avbrutt',
	'openidcanceltext'              => 'Bekreftelsen av OpenID-adressen ble avbrutt.',
	'openidfailure'                 => 'Bekreftelse mislyktes',
	'openidfailuretext'             => 'Bekreftelse av OpenID-adressen mislyktes. Feilbeskjed: «$1»',
	'openidsuccess'                 => 'Bekreftelse lyktes',
	'openidsuccesstext'             => 'Bekreftelse av OpenID-adressen lyktes.',
	'openidusernameprefix'          => 'OpenID-bruker',
	'openidserverlogininstructions' => 'Skriv inn passordet ditt nedenfor for å logge på $3 som $2 (brukerside $1).',
	'openidtrustinstructions'       => 'Sjekk om du ønsker å dele data med $1.',
	'openidallowtrust'              => 'La $1 stole på denne kontoen.',
	'openidnopolicy'                => 'Siden har ingen personvernerklæring.',
	'openidpolicy'                  => 'Sjekk <a href="_new" href="$1">personvernerklæringen</a> for mer informasjon.',
	'openidoptional'                => 'Valgfri',
	'openidrequired'                => 'Påkrevd',
	'openidnickname'                => 'Kallenavn',
	'openidfullname'                => 'Fullt navn',
	'openidemail'                   => 'E-postadresse',
	'openidlanguage'                => 'Språk',
	'openidnotavailable'            => 'Foretrukket kallenavn ($1) brukes allerede av en annen bruker.',
	'openidnotprovided'             => 'OpenID-tjeneren din oppga ikke et kallenavn (enten fordi den ikke kunne det, eller fordi du har sagt at den ikke skal gjøre det).',
	'openidchooseinstructions'      => 'Alle brukere må ha et kallenavn; du kan velge blant valgene nedenfor.',
	'openidchoosefull'              => 'Fullt navn ($1)',
	'openidchooseurl'               => 'Et navn tatt fra din OpenID ($1)',
	'openidchooseauto'              => 'Et automatisk opprettet navn ($1)',
	'openidchoosemanual'            => 'Et valgfritt navn:',
	'openidchooseexisting'          => 'En eksisterende konto på denne wikien:',
	'openidchoosepassword'          => 'passord:',
	'openidconvertinstructions'     => 'Dette skjemaet lar deg endre brukerkontoen din til å bruke en OpenID-adresse.',
	'openidconvertsuccess'          => 'Konverterte til OpenID',
	'openidconvertsuccesstext'      => 'Du har konvertert din OpenID til $1.',
	'openidconvertyourstext'        => 'Det er allerede din OpenID.',
	'openidconvertothertext'        => 'Den OpenID-en tilhører noen andre.',
	'openidalreadyloggedin'         => "'''$1, du er allerede logget inn.'''

Om du ønsker å bruke OpenID i framtiden, kan du [[Special:OpenIDConvert|konvertere kontoen din til å bruke OpenID]].",
	'tog-hideopenid'                => 'Skjul <a href="http://openid.net/">OpenID</a> på brukersiden din om du logger inn med en.',
	'openidnousername'              => 'Intet brukernavn oppgitt.',
	'openidbadusername'             => 'Ugyldig brukernavn oppgitt.',
	'openidautosubmit'              => 'Denne siden inneholder et skjema som vil leveres automatisk om du har JavaScript slått på. Om ikke, trykk på «Fortsett».',
	'openidclientonlytext'          => 'Du kan ikke bruke kontoer fra denne wikien som OpenID på en annen side.',
	'openidloginlabel'              => 'OpenID-adresse',
	'openidlogininstructions'       => "{{SITENAME}} støtter [http://openid.net/ OpenID]-standarden for enhetlig innlogging på forskjellige nettsteder. OpenID lar deg logge inn på mange forskjellige nettsider uten å bruke forskjellige passord overalt. (Se [http://no.wikipedia.org/wiki/OpenID Wikipedia-artikkelen om OpenID] for mer informasjon.)

Om du allerede har en konto på {{SITENAME}}, kan du logge på som vanlig med ditt brukernavn og passord. For å bruke OpenID i framtiden kan du [[Special:OpenIDConvert|konvertere kontoen din til OpenID]] etter at du har logget inn på vanlig vis.

Det er mange [http://wiki.openid.net/Public_OpenID_providers leverandører av OpenID], og du kan allerede ha en OpenID-aktivert konto et annet sted.

;Andre wikier :Om du har en konto på en OpenID-aktivert wiki, som [http://wikitravel.org/ Wikitravel], [http://wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] eller [http://kei.ki/ Keiki], kan du logge inn på {{SITENAME}} ved å skrive inn den '''fullstendige adressen''' til din brukerside på den wikien i boksen ovenfor. For eksempel ''<nowiki>http://kei.kei/en/User:Eksempel</nowiki>''.
;[http://openid.yahoo.com/ Yahoo!] :Om du har en konto hos Yahoo! kan du logge inn på denne siden ved å skrive inn OpenID-en din fra Yahoo i boksen ovenfor. Yahoo!s OpenID-adresser har formen ''<nowiki>https://me.yahoo.com/dittbrukernavn</nowiki>''.
;[http://dev.aol.com/aol-and-63-million-openids AOL] :Om du har en konto hos [http://aol.com/ AOL], for eksempel en [http://aim.com/ AIM]-konto, kan du logge inn på {{SITENAME}} ved å skrive inn OpenID-en din fra AOL i boksen ovenfor. AOLs OpenID-adresser har formen ''<nowiki>http://openid.aol.com/dittbrukernavn</nowiki>''. Brukernavnet må være i små bokstaver og uten mellomrom.
;[http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] :Om du har en konto på en av disse tjenestene, skriv inn adressen til bloggen din i boksen ovenfor. For eksempel ''<nowiki>http://dittbrukernavn.blogspot.com/</nowiki>'', ''<nowiki>http://dittbrukernavn.wordpress.com/</nowiki>'', ''<nowiki>http://dittbrukernavn.livejournal.com/</nowiki>'', or ''<nowiki>http://dittbrukernavn.vox.com/</nowiki>''.",
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'openid-desc'                   => "Se connecta al wiki amb [http://openid.net/ OpenID] e se connecta a d'autres sits internet OpenID amb un wiki utilizant un compte d'utilizaire.",
	'openidlogin'                   => 'Se connectar amb OpenID',
	'openidfinish'                  => 'Acabar la conneccion OpenID',
	'openidserver'                  => 'Servidor OpenID',
	'openidxrds'                    => 'Fichièr Yadis',
	'openidconvert'                 => 'Convertisseire OpenID',
	'openiderror'                   => 'Error de verificacion',
	'openiderrortext'               => "Una error es intervenguda pendent la verificacion de l'adreça OpenID.",
	'openidconfigerror'             => 'Error de configuracion de OpenID',
	'openidconfigerrortext'         => "L'estocatge de la configuracion OpenID per aqueste wiki es incorrècte.
Metetz-vos en rapòrt amb l’administrator d'aqueste sit.",
	'openidpermission'              => 'Error de permission OpenID',
	'openidpermissiontext'          => "L’OpenID qu'avètz provesida es pas autorizada a se connectar sus aqueste servidor.",
	'openidcancel'                  => 'Verificacion anullada',
	'openidcanceltext'              => 'La verificacion de l’adreça OpenID es estada anullada.',
	'openidfailure'                 => 'Fracàs de la verificacion',
	'openidfailuretext'             => 'La verificacion de l’adreça OpenID a fracassat. Messatge d’error : « $1 »',
	'openidsuccess'                 => 'Verificacion capitada',
	'openidsuccesstext'             => 'Verificacion de l’adreça OpenID capitada.',
	'openidusernameprefix'          => 'Utilizaire OpenID',
	'openidserverlogininstructions' => "Picatz vòstre senhal çaijós per vos connectar sus $3 coma utilizaire '''$2''' (pagina d'utilizaire $1).",
	'openidtrustinstructions'       => 'Marcatz se desiratz partejar las donadas amb $1.',
	'openidallowtrust'              => "Autoriza $1 a far fisança a aqueste compte d'utilizaire.",
	'openidnopolicy'                => 'Lo sit a pas indicat una politica de las donadas personnalas.',
	'openidpolicy'                  => 'Verificar la <a target="_new" href="$1">Politica de las donadas personalas</a> per mai d’entresenhas.',
	'openidoptional'                => 'Facultatiu',
	'openidrequired'                => 'Exigit',
	'openidnickname'                => 'Escais',
	'openidfullname'                => 'Nom complet',
	'openidemail'                   => 'Adreça de corrièr electronic',
	'openidlanguage'                => 'Lenga',
	'openidnotavailable'            => 'Vòstre escais preferit ($1) ja es utilizat per un autre utilizaire.',
	'openidnotprovided'             => "Vòstre servidor OpenID a pas pogut provesir un escais (siá o pòt pas, siá li avètz demandat d'o far pas mai).",
	'openidchooseinstructions'      => "Totes los utilizaires an besonh d'un escais ; ne podètz causir un a partir de la causida çaijós.",
	'openidchoosefull'              => 'Vòstre nom complet ($1)',
	'openidchooseurl'               => 'Un nom es estat causit dempuèi vòstra OpenID ($1)',
	'openidchooseauto'              => 'Un nom creat automaticament ($1)',
	'openidchoosemanual'            => "Un nom qu'avètz causit :",
	'openidchooseexisting'          => 'Un compte existent sus aqueste wiki :',
	'openidchoosepassword'          => 'Senhal :',
	'openidconvertinstructions'     => "Aqueste formulari vos daissa cambiar vòstre compte d'utilizaire per utilizar una adreça OpenID.",
	'openidconvertsuccess'          => 'Convertit amb succès vèrs OpenID',
	'openidconvertsuccesstext'      => 'Avètz convertit amb succès vòstra OpenID vèrs $1.',
	'openidconvertyourstext'        => 'Ja es vòstra OpenID.',
	'openidconvertothertext'        => "Aquò es quicòm d'autre qu'una OpenID.",
	'openidalreadyloggedin'         => "'''Ja sètz connectat, $1 !'''

Se desiratz utilizar vòstra OpenID per vos connectar ulteriorament, podètz [[Special:OpenIDConvert|convertir vòstre compte per utilizar OpenID]].",
	'tog-hideopenid'                => 'Amaga vòstra <a href="http://openid.net/">OpenID</a> sus vòstra pagina d\'utilizaire, se vos connectaz amb OpenID.',
	'openidnousername'              => 'Cap de nom d’utilizaire es pas estat indicat.',
	'openidbadusername'             => 'Un nom d’utilizaire marrit es estat indicat.',
	'openidautosubmit'              => 'Aquesta pagina compren un formulari que poiriá èsser mandat automaticament se avètz activat JavaScript.
S’èra pas lo cas, ensajatz lo boton « Contunhar ».',
	'openidclientonlytext'          => 'Podètz pas utilizar de comptes dempuèi aqueste wiki en tant qu’OpenID sus d’autres sits.',
	'openidloginlabel'              => 'Adreça OpenID',
	'openidlogininstructions'       => "{{SITENAME}} supòrta lo format [http://openid.net/ OpenID] estandard per una sola signatura entre de sits Internet.
OpenID vos permet de vos connectar sus maites sits diferents sens aver d'utilizar un senhal diferent per cadun d’entre eles.
(Vejatz [http://en.wikipedia.org/wiki/OpenID Wikipedia's OpenID article] per mai d'entresenhas.)

S'avètz ja un compte sus {{SITENAME}}, vos podètz [[Special:Userlogin|connectar]] amb vòstre nom d'utilizaire e son senhal coma de costuma. Per utilizar OpenID, a l’avenidor, podètz [[Special:OpenIDConvert|convertir vòstre compte en OpenID]] aprèp vos èsser connectat normalament.

Existís maites [http://wiki.openid.net/Public_OpenID_providers provesidors d'OpenID publicas], e podètz ja obténer un compte OpenID activat sus un autre servici.

; Autres wiki : s'avètz un wiki amb OpenID activat, tal coma [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] o encara [http://kei.ki/ Keiki], vos podètz connectar sus {{SITENAME}} en picant '''l’adreça internet complèta'' de vòstra pagina d'aqueste autre wiki dins la bóstia çaisús. Per exemple : ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Se avètz un compte amb Yahoo! , vos podètz connectar sus aqueste sit en picant vòstra OpenID Yahoo! provesida dins la bóstia çaijós. Las adreças OpenID devon aver la sintaxi ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : se avètz un compte amb [http://www.aol.com/ AOL], coma un compte [http://www.aim.com/ AIM], vos podètz connectar sus {{SITENAME}} en picant vòstra OpenID provesida per AOL dins la bóstia çaijós. Las adreças OpenID devon aver lo format ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Vòstre nom d’utilizaire deu èsser entièrament en letras minusculas amb cap d'espaci.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Se avètz un blog o un autre d'aquestes servicis, picatz l’adreça de vòstre blog dins la bóstia çaijós. Per exemple, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', o encara ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'openidnickname'       => 'Фæсномыг',
	'openidlanguage'       => 'Æвзаг',
	'openidchoosepassword' => 'пароль:',
);

/** Polish (Polski)
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'openidoptional'           => 'Opcjonalnie',
	'openidrequired'           => 'Wymagane',
	'openidnickname'           => 'Nazwa użytkownika',
	'openidfullname'           => 'Imię i nazwisko',
	'openidemail'              => 'Adres e-mail',
	'openidlanguage'           => 'Język',
	'openidnotavailable'       => 'Wybrana nazwa użytkownika „$1” jest już zajęta.',
	'openidchooseinstructions' => 'Wszyscy użytkownicy muszą posiadać nazwę.
Możesz wybrać spośród propozycji podanych poniżej.',
	'openidchoosefull'         => 'Twoje imię i nazwisko ($1)',
	'openidchooseauto'         => 'Automatycznie utworzono nazwę użytkownika ($1)',
	'openidchoosemanual'       => 'Nazwa użytkownika wybrana przez Ciebie',
	'openidchooseexisting'     => 'Istniejące konto na tej wiki',
	'openidchoosepassword'     => 'hasło',
	'openidnousername'         => 'Nie wybrano żadnej nazwy użytkownika.',
	'openidbadusername'        => 'Wybrano nieprawidłową nazwę użytkownika.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'openidnickname'       => 'کورنی نوم',
	'openidfullname'       => 'بشپړ نوم',
	'openidemail'          => 'برېښليک پته',
	'openidlanguage'       => 'ژبه',
	'openidchoosefull'     => 'ستاسو بشپړ نوم ($1)',
	'openidchoosemanual'   => 'ستاسو د خوښې يو نوم:',
	'openidchoosepassword' => 'پټنوم:',
	'openidnousername'     => 'هېڅ يو کارن-نوم نه دی ځانګړی شوی.',
	'openidbadusername'    => 'يو ناسم کارن-نوم مو ځانګړی کړی.',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Lijealso
 */
$messages['pt'] = array(
	'openidlogin'                   => 'Autenticação com OpenID',
	'openidfinish'                  => 'Terminar autenticação OpenID',
	'openidserver'                  => 'Servidor OpenID',
	'openidxrds'                    => 'Ficheiro Yadis',
	'openidconvert'                 => 'Conversor de OpenID',
	'openiderror'                   => 'Erro de verificação',
	'openidconfigerror'             => 'Erro de Configuração do OpenID',
	'openidpermission'              => 'Erro de permissões OpenID',
	'openidcancel'                  => 'Verificação cancelada',
	'openidfailure'                 => 'Verificação falhou',
	'openidsuccess'                 => 'Verificação com sucesso',
	'openidusernameprefix'          => 'UtilizadorOpenID',
	'openidserverlogininstructions' => 'Introduza a sua palavra-chave abaixo para se autenticar em $3 como utilizador $2 (página de utilizador $1).',
	'openidnopolicy'                => 'O sítio não especificou uma política de privacidade.',
	'openidoptional'                => 'Opcional',
	'openidrequired'                => 'Requerido',
	'openidfullname'                => 'Nome completo',
	'openidemail'                   => 'Endereço de e-mail',
	'openidlanguage'                => 'Língua',
	'openidchoosefull'              => 'O seu nome completo ($1)',
	'openidchooseauto'              => 'Um nome gerado automaticamente ($1)',
	'openidchoosemanual'            => 'Um nome à sua escolha:',
	'openidchooseexisting'          => 'Uma conta existente neste wiki:',
	'openidchoosepassword'          => 'palavra-chave:',
	'openidconvertsuccess'          => 'Convertido para OpenID com sucesso',
	'openidconvertsuccesstext'      => 'Você converteu com sucesso o seu OpenID para $1.',
	'openidconvertyourstext'        => 'Esse já é o seu OpenID.',
	'openidconvertothertext'        => 'Esse é o OpenID de outra pessoa.',
	'openidnousername'              => 'Nenhum nome de utilizador especificado.',
	'openidbadusername'             => 'Nome de utilizador especificado inválido.',
	'openidclientonlytext'          => 'Você pode usar contas deste wiki como OpenIDs noutro sítio.',
	'openidloginlabel'              => 'URL do OpenID',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'openidemail'    => 'Adresă e-mail',
	'openidlanguage' => 'Limbă',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'openid-desc'                   => 'Вход в вики с помощью [http://openid.net/ OpenID], а также вход на другие сайты поддерживающие OpenID с помощью учётной записи в вики',
	'openidlogin'                   => 'Вход с помощью OpenID',
	'openidfinish'                  => 'Завершить вход OpenID',
	'openidserver'                  => 'Сервер OpenID',
	'openidxrds'                    => 'Файл Yadis',
	'openidconvert'                 => 'Преобразователь OpenID',
	'openiderror'                   => 'Ошибка проверки полномочий',
	'openiderrortext'               => 'Во время проверки адреса OpenID произошла ошибка.',
	'openidconfigerror'             => 'Ошибка настройки OpenID',
	'openidconfigerrortext'         => 'Настройка хранения OpenID для этой вики ошибочна.
Пожалуйста, обратитесь к администратору сайта.',
	'openidpermission'              => 'Ошибка прав доступа OpenID',
	'openidpermissiontext'          => 'Указанный OpenID не позволяет войти на этот сервер.',
	'openidcancel'                  => 'Проверка отменена',
	'openidcanceltext'              => 'Проверка адреса OpenID была отменена.',
	'openidfailure'                 => 'Проверка неудачна',
	'openidfailuretext'             => 'Проверка адреса OpenID завершилась неудачей. Сообщение об ошибке: «$1»',
	'openidsuccess'                 => 'Проверка прошла успешно',
	'openidsuccesstext'             => 'Проверка адреса OpenID прошла успешно.',
	'openidusernameprefix'          => 'УчастникOpenID',
	'openidserverlogininstructions' => 'Введите ниже ваш пароль, чтобы войти на $3 как пользователь $2 (личная страница $1).',
	'openidtrustinstructions'       => 'Отметьте, если вы хотите предоставить доступ к данным для $1.',
	'openidallowtrust'              => 'Разрешить $1 доверять этой учётной записи.',
	'openidnopolicy'                => 'Сайт не указал политику конфиденциальности.',
	'openidpolicy'                  => 'Дополнительную информацию см. в <a target="_new" href="$1">политике конфиденциальности</a>.',
	'openidoptional'                => 'необязательное',
	'openidrequired'                => 'обязательное',
	'openidnickname'                => 'Псевдоним',
	'openidfullname'                => 'Полное имя',
	'openidemail'                   => 'Адрес эл. почты',
	'openidlanguage'                => 'Язык',
	'openidnotavailable'            => 'Указанный вами псевдоним ($1) уже используется другим участником.',
	'openidnotprovided'             => 'Ваш сервер OpenID не предоставил псевдоним (либо потому, что он не может, либо потому, что вы указали не делать этого)',
	'openidchooseinstructions'      => 'Каждый участник должен иметь псевдоним;
вы можете выбрать один представленных ниже.',
	'openidchoosefull'              => 'Ваше полное имя ($1)',
	'openidchooseurl'               => 'Имя, полученное из вашего OpenID ($1)',
	'openidchooseauto'              => 'Автоматически созданное имя ($1)',
	'openidchoosemanual'            => 'Имя на ваш выбор:',
	'openidchooseexisting'          => 'Существующая учётная запись на этой вики:',
	'openidchoosepassword'          => 'пароль:',
	'openidconvertinstructions'     => 'Эта форма позволяет вам сменить использование учётной записи на использование адреса OpenID.',
	'openidconvertsuccess'          => 'Успешное преобразование в OpenID',
	'openidconvertsuccesstext'      => 'Вы успешно преобразовали ваш OpenID в $1.',
	'openidconvertyourstext'        => 'Это уже ваш OpenID.',
	'openidconvertothertext'        => 'Это чужой OpenID.',
	'openidalreadyloggedin'         => "'''Вы уже вошли, $1!'''

Если вы желаете использовать в будущем вход через OpenID, вы можете [[Special:OpenIDConvert|преобразовать вашу учётную запись для использования в OpenID]].",
	'tog-hideopenid'                => 'Скрывать ваш <a href="http://openid.net/">OpenID</a> на вашей странице участника, если вы вошли с помощью OpenID.',
	'openidnousername'              => 'Не указано имя участника.',
	'openidbadusername'             => 'Указано неверное имя участника.',
	'openidautosubmit'              => 'Эта страница содержит форму, которая должна быть автоматически отправлена, если у вас включён JavaScript.
Если этого не произошло, попробуйте нажать на кнопку «Продолжить».',
	'openidclientonlytext'          => 'Вы не можете использовать учётные записи с этой вики, как OpenID на другом сайте.',
	'openidloginlabel'              => 'Адрес OpenID',
	'openidlogininstructions'       => "{{SITENAME}} поддерживает стандарт [http://openid.net/ OpenID], позволяющий использовать одну учётную запись для входа на различные веб-сайты.
OpenID позволяет вам заходить на различные веб-сайты без указания разных паролей для них
(подробнее см. [http://ru.wikipedia.org/wiki/OpenID статью об OpenID в Википедии]).

Если вы уже имеете учётную запись на {{SITENAME}}, вы можете [[Special:Userlogin|войти]] как обычно, используя  ваши имя пользователя и пароль.
Чтобы использовать в дальнейшем OpenID, вы можете [[Special:OpenIDConvert|преобразовать вашу учётную запись в  OpenID]], после того, как вы вошли обычным образом.

Существует множество [http://wiki.openid.net/Public_OpenID_providers общедоступных провайдеров OpenID], возможно, вы уже имеете учётную запись OpenID на другом сайте.

; Другие вики : Если вы имеете учётную запись с OpenID на другой вики, например, [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] или [http://kei.ki/ Keiki], вы можете войти на {{SITENAME}}, введя ниже '''полный адрес''' вашей страницы участника на другой вики. Например, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Если вы зарегистрированы на Yahoo!, вы можете войти, введя ниже ваш OpenID с Yahoo!. Адреса OpenID Yahoo! имеют вид ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Если вы зарегистрированы на [http://www.aol.com/ AOL], например, имеете учётную запись в [http://www.aim.com/ AIM], вы можете зайти на {{SITENAME}}, введя ниже ваш OpenID с AOL. Адреса AOL OpenID имеют вид ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Ваше имя должно быть в нижнем регистре, без пробелов.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Если вы ведёте блог с помощью одной из этих служб, введите ниже адрес вашего блога. Например, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', или ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'openid-desc'                   => 'Prihlásenie sa na wiki pomocou [http://openid.net/ OpenID] a prihlásenie na iné stránky podporujúce OpenID pomocou používateľského účtu wiki',
	'openidlogin'                   => 'Prihlásiť sa pomocou OpenID',
	'openidfinish'                  => 'Dokončiť prihlásenie pomocou OpenID',
	'openidserver'                  => 'OpenID server',
	'openidxrds'                    => 'Súbor Yadis',
	'openidconvert'                 => 'OpenID konvertor',
	'openiderror'                   => 'Chyba pri overovaní',
	'openiderrortext'               => 'Počas overovania OpenID URL sa vyskytla chyba.',
	'openidconfigerror'             => 'Chyba konfigurácie OpenID',
	'openidconfigerrortext'         => 'Konfigurácia OpenID tejto wiki je neplatná.
Prosím, poraďte sa so správcom tejto webovej lokality.',
	'openidpermission'              => 'Chyba oprávnení OpenID',
	'openidpermissiontext'          => 'OpenID, ktorý ste poskytli, nemá oprávnenie prihlásiť sa k tomuto serveru',
	'openidcancel'                  => 'Overovanie bolo zrušené',
	'openidcanceltext'              => 'Overovanie OpenID URL bolo zrušené.',
	'openidfailure'                 => 'Overovanie bolo zrušené',
	'openidfailuretext'             => 'Overovanie OpenID URL zlyhalo. Chybová správa: „$1“',
	'openidsuccess'                 => 'Overenie bolo úspešné',
	'openidsuccesstext'             => 'Overenie OpenID URL bolo úspešné.',
	'openidusernameprefix'          => 'PoužívateľOpenID',
	'openidserverlogininstructions' => 'Dolu zadajte heslo pre prihlásenie na $3 ako používateľ $2 (používateľská stránka $1).',
	'openidtrustinstructions'       => 'Skontrolujte, či chcete zdieľať dáta s používateľom $1.',
	'openidallowtrust'              => 'Povoliť $1 dôverovať tomuto používateľskému účtu.',
	'openidnopolicy'                => 'Lokalita nešpecifikovala politiku ochrany osobných údajov.',
	'openidpolicy'                  => 'Viac informácií na stránke <a target="_new" href="$1">Ochrana osobných údajov</a>',
	'openidoptional'                => 'Voliteľné',
	'openidrequired'                => 'Požadované',
	'openidnickname'                => 'Prezývka',
	'openidfullname'                => 'Plné meno',
	'openidemail'                   => 'Emailová adresa',
	'openidlanguage'                => 'Jazyk',
	'openidnotavailable'            => 'Vašu preferovanú prezývku ($1) už používa iný používateľ.',
	'openidnotprovided'             => 'Váš OpenID server neposkytol prezývku (buď preto, že nemôže alebo preto, že ste mu povedali aby ju neposkytoval).',
	'openidchooseinstructions'      => 'Každý používateľ musí mať prezývku; môžete si vybrať z dolu uvedených možností.',
	'openidchoosefull'              => 'Vaše plné meno ($1)',
	'openidchooseurl'               => 'Meno na základe vášho OpenID ($1)',
	'openidchooseauto'              => 'Automaticky vytvorené meno ($1)',
	'openidchoosemanual'            => 'Meno, ktoré si vyberiete:',
	'openidchooseexisting'          => 'Existujúci účet na tejto wiki:',
	'openidchoosepassword'          => 'heslo:',
	'openidconvertinstructions'     => 'Tento formulár vám umožňuje zmeniť váš učet, aby používal OpenID URL.',
	'openidconvertsuccess'          => 'Úspešne prevedené na OpenID',
	'openidconvertsuccesstext'      => 'Úspešne ste previedli váš OpenID na $1.',
	'openidconvertyourstext'        => 'To už je váš OpenID.',
	'openidconvertothertext'        => 'To je OpenID niekoho iného.',
	'openidalreadyloggedin'         => "'''Už ste prihlásený, $1!'''

Ak chcete na prihlasovanie v budúcnosti využívať OpenID, môžete [[Special:OpenIDConvert|previesť váš účet na OpenID]].",
	'tog-hideopenid'                => 'Nezobrazovať váš <a href="http://openid.net/">OpenID</a> na vašej používateľskej stránke ak sa prihlasujete pomocou OpenID.',
	'openidnousername'              => 'Nebolo zadané používateľské meno.',
	'openidbadusername'             => 'Bolo zadané chybné používateľské meno.',
	'openidautosubmit'              => 'Táto stránka obsahuje formulár, ktorý by mal byť automaticky odoslaný ak máte zapnutý JavaScript.
Ak nie, skúste tlačidlo „Pokračovať“.',
	'openidclientonlytext'          => 'Nemôžete používať účty z tejto wiki ako OpenID na iných weboch.',
	'openidloginlabel'              => 'OpenID URL',
	'openidlogininstructions'       => "{{SITENAME}} podporuje štandard [http://openid.net/ OpenID] na zjednotené prihlasovanie na webstránky.
OpenID vám umožňuje prihlasovať sa na množstvo rozličných webstránok bez nutnosti používať pre každú odlišné heslo. (Pozri [http://sk.wikipedia.org/wiki/OpenID Článok o OpenID na Wikipédii])

Ak už máte účet na {{GRAMMAR:lokál|{{SITENAME}}}}, môžete sa [[Special:Userlogin|prihlásiť]] pomocou používateľského mena a hesla ako zvyčajne. Ak chcete v budúcnosti používať OpenID, môžete po normálnom prihlásení [[Special:OpenIDConvert|previesť svoj účet na OpenID]].

Existuje množstvo [http://wiki.openid.net/Public_OpenID_providers Verejných poskytovateľov OpenID] a možno už máte účet s podporou OpenID u iného poskytovateľa.

; Iné wiki: Ak máte účet na wiki stránke s podporou OpenID ako napr. [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] alebo [http://kei.ki/ Keiki], môžete sa prihlásiť na {{GRAMMAR:akuzatív|{{SITENAME}}}} zadaním '''plného URL''' svojej používateľskej stránky na danej wiki do poľa vyššie. Napríklad ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!]: Ak máte účet Yahoo!, môžete sa na túto stránku prihlásiť zadaním vášho OpenID, ktoré poskytuje Yahoo!, do poľa vyššie. Yahoo! OpenID URL bývajú v tvare  ''<nowiki>https://me.yahoo.com/pouzivatelskemeno</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL]: Ak máte účet [http://www.aol.com/ AOL] ako napríklad účet [http://www.aim.com/ AIM], môžete sa prihlásiť na {{GRAMMAR:akuzatív|{{SITENAME}}}} zadaním vášho OpenID, ktoré poskytuje AOL, do poľa vyššie. AOL OpenID URL bývajú v tvare ''<nowiki>http://openid.aol.com/pouzivatelskemeno</nowiki>''. Vaše používateľské meno by malo mať len malé písmená a žiadne medzery.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox]: Ak máte blog na niektorej z týchto služieb, zadajte do poľa vyššie URL svojho blogu. Napríklad ''<nowiki>http://pouzivatelskemeno.blogspot.com/</nowiki>'', ''<nowiki>http://pouzivatelskemeno.wordpress.com/</nowiki>'', ''<nowiki>http://pouzivatelskemeno.livejournal.com/</nowiki>'' alebo ''<nowiki>http://pouzivatelskemeno.vox.com/</nowiki>''.",
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'openidemail'    => 'Е-пошта',
	'openidlanguage' => 'Језик',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'openidnickname'       => 'Landihan',
	'openidlanguage'       => 'Basa',
	'openidchoosepassword' => 'sandi:',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Lokal Profil
 * @author Jon Harald Søby
 */
$messages['sv'] = array(
	'openid-desc'                   => 'Logga in på wikin med en [http://openid.net/ OpenID] och logga in på andra sidor som använder OpenID med konton härifrån',
	'openidlogin'                   => 'Logga in med OpenID',
	'openidfinish'                  => 'Fullfölj OpenID-inloggning',
	'openidserver'                  => 'OpenID-server',
	'openidxrds'                    => 'Yadis-fil',
	'openidconvert'                 => 'OpenID-konvertering',
	'openiderror'                   => 'Bekräftelsefel',
	'openiderrortext'               => 'Ett fel uppstod under bekräftning av OpenID-adressen.',
	'openidconfigerror'             => 'Konfigurationsfel med OpenID',
	'openidconfigerrortext'         => 'Langringkonfigurationen för OpenID på den här wikin är ogiltig.
Var god konsultera sajtens administratör om problemet.',
	'openidpermission'              => 'Tillåtelsefel med OpenID',
	'openidpermissiontext'          => 'Du kan inte logga in på den här servern med den OpenID du angedde.',
	'openidcancel'                  => 'Bekräftning avbruten',
	'openidcanceltext'              => 'Bekräftningen av OpenID-adressen avbrytes.',
	'openidfailure'                 => 'Bekräftning misslyckades',
	'openidfailuretext'             => 'Bekräftning av OpenID-adressen misslyckades. Felmeddelande: "$1"',
	'openidsuccess'                 => 'Bekräftning lyckades',
	'openidsuccesstext'             => 'Bekräftning av OpenID-adressen lyckades.',
	'openidusernameprefix'          => 'OpenID-användare',
	'openidserverlogininstructions' => 'Skriv in ditt lösenord nedan för att logga in på $3 som $2 (användarsida $1).',
	'openidtrustinstructions'       => 'Kolla om du vill dela data med $1.',
	'openidallowtrust'              => 'Tillåter $1 att förlita sig på detta användarkonto.',
	'openidnopolicy'                => 'Sajten har inga riktlinjer för personlig integritet.',
	'openidpolicy'                  => 'Kolla <a href="_new" href="$1">riktlinjer för personlig integritet</a> för mer information.',
	'openidoptional'                => 'Valfri',
	'openidrequired'                => 'Behövs',
	'openidnickname'                => 'Smeknamn',
	'openidfullname'                => 'Fullt namn',
	'openidemail'                   => 'E-postadress',
	'openidlanguage'                => 'Språk',
	'openidnotavailable'            => 'Ditt framförda användarnamn ($1) används redan av en annan användare.',
	'openidnotprovided'             => 'Din OpenID-server uppgav inte ett användarnamn (antingen för att den inte kan, eller för att du har sagt till den att den inte ska göra det).',
	'openidchooseinstructions'      => 'Alla användare måste ha ett användarnamn;
du kan välja ett från alternativen nedan.',
	'openidchoosefull'              => 'Fullt namn ($1)',
	'openidchooseurl'               => 'Ett namn taget från din OpenID ($1)',
	'openidchooseauto'              => 'Ett automatiskt genererat namn ($1)',
	'openidchoosemanual'            => 'Ett valfritt namn:',
	'openidchooseexisting'          => 'Ett existerande konto på denna wiki:',
	'openidchoosepassword'          => 'lösenord:',
	'openidconvertinstructions'     => 'Detta formulär låter dig ändra dina användarkonton till att använda en OpenID-adress.',
	'openidconvertsuccess'          => 'Konverterade till OpenID',
	'openidconvertsuccesstext'      => 'Du har konverterat din OpenID till $1.',
	'openidconvertyourstext'        => 'Det är redan din OpenID.',
	'openidconvertothertext'        => 'Den OpenID tillhör någon annan.',
	'openidalreadyloggedin'         => "'''Du är redan inloggad, $1!'''

Om du vill använda OpenID att logga in i framtiden, kan du [[Special:OpenIDConvert|konvertera dina konton till att använda OpenID]].",
	'tog-hideopenid'                => 'Dölj <a href="http://openid.net/">OpenID</a> på din användarsida, om du loggar in med OpenID.',
	'openidnousername'              => 'Inget användarnamn angivet.',
	'openidbadusername'             => 'Ogiltigt användarnamn angivet.',
	'openidautosubmit'              => 'Denna sida innehåller ett formulär som kommer levereras automatiskt om du har slagit på JavaScript. Om inte, tryck på "Fortsätt".',
	'openidclientonlytext'          => 'Du kan inte använda konton från denna wikin som OpenID på en annan sida.',
	'openidloginlabel'              => 'OpenID-adress',
	'openidlogininstructions'       => "{{SITENAME}} stödjer [http://openid.net/ OpenID]-standarden för enhetlig inlogging på många webbsidor. OpenID låter dig logga in på många webbsidor utan att använda massor med lösenord överallt. (Se [http://en.wikipedia.org/wiki/OpenID Wikipedia-artikeln om OpenID] för mer information.)

Om du redan har ett konto på {{SITENAME}}, kan du logga in som vanligt med ditt användarnamn och lösenord. För att använda OpenID i framtiden kan du [[Special:OpenIDConvert|konvertera dina konton till OpenID]] efter att du har loggat in på normalt sätt.

Det finns många [http://wiki.openid.net/Public_OpenID_providers leverantörer av OpenID], och du kan redan ha ett OpenID-aktiverat konto på en annan plats.

;Andra wikier :Om du har ett konto på en OpenID-aktiverad wiki, som [http://wikitravel.org/ Wikitravel], [http://wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] eller [http://kei.ki/ Keiki], kan du logga in på {{SITENAME}} genom att skriva in den '''fullständiga adressen''' till din användarsida på den wikin i boxen ovanför. För exempel ''<nowiki>http://kei.kei/en/User:Exempel</nowiki>''.
;[http://openid.yahoo.com/ Yahoo!] :Om du har ett konto hos Yahoo! kan du logga in på denna sida genom att skriva in din OpenID från Yahoo i boxen övanför. Yahoo!s OpenID-adresser har formen ''<nowiki>https://me.yahoo.com/dittanvändarnamn</nowiki>''.
;[http://dev.aol.com/aol-and-63-million-openids AOL] :Om du har ett konto hos [http://aol.com/ AOL], för exempel ett [http://aim.com/ AIM]-konto, kan du logga in på {{SITENAME}} genom att skriva in din OpenID från AOL i boxen ovanför. AOLs OpenID-adresser har formen ''<nowiki>http://openid.aol.com/dittanvändarnamn</nowiki>''. Användarnamner måste vara små bokstäver och utan mellanrum.
;[http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] :Om du har ett konto på en av dessa tjänster, skriv in adressen till din bloggen i boxen ovanför. För exempel ''<nowiki>http://dittanvändarnamn.blogspot.com/</nowiki>'', ''<nowiki>http://dittanvändarnamn.wordpress.com/</nowiki>'', ''<nowiki>http://dittanvändarnamn.livejournal.com/</nowiki>'', or ''<nowiki>http://dittanvändarnamn.vox.com/</nowiki>''.",
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'openidoptional'       => 'ఐచ్చికం',
	'openidrequired'       => 'తప్పనిసరి',
	'openidfullname'       => 'పూర్తిపేరు',
	'openidemail'          => 'ఈ-మెయిల్ చిరునామా',
	'openidlanguage'       => 'భాష',
	'openidchoosefull'     => 'మీ పూర్తి పేరు ($1)',
	'openidchoosemanual'   => 'మీరు ఎన్నుకున్న పేరు:',
	'openidchoosepassword' => 'సంకేతపదం:',
	'openidnousername'     => 'వాడుకరిపేరు ఇవ్వలేదు.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'openidemail' => 'Diresaun korreiu eletróniku',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 * @author Siebrand
 */
$messages['tg-cyrl'] = array(
	'openid-desc'           => 'Ба вики бо [http://openid.net/ OpenID] вуруд кунед, ва ба дигар сомонаҳои OpenID бо ҳисоби корбарии вики вуруд кунед',
	'openidlogin'           => 'Бо OpenID вуруд кунед',
	'openidfinish'          => 'Хотима додан вурудшавии OpenID',
	'openidserver'          => 'Хидматгузори OpenID',
	'openidxrds'            => 'Парвандаи Yadis',
	'openidconvert'         => 'Табдилкунандаи OpenID',
	'openiderror'           => 'Хатои тасдиқ',
	'openiderrortext'       => 'Дар ҳолати тасдиқи нишонаи OpenID хатое рух дод.',
	'openidconfigerror'     => 'Хатои Танзимоти OpenID',
	'openidconfigerrortext' => 'Танзимоти захирасозии OpenID барои ин вики номӯътабар аст.
Лутфан бо мудири сомона тамос бигиред.',
	'openidoptional'        => 'Ихтиёрӣ',
	'openidemail'           => 'Нишонаи почтаи электронӣ',
	'openidlanguage'        => 'Забон',
	'openidchoosepassword'  => 'гузарвожа:',
);

/** Ukrainian (Українська)
 * @author AS
 */
$messages['uk'] = array(
	'openidlanguage' => 'Мова',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'openid-desc'                   => 'Đăng nhập vào wiki dùng [http://openid.net/ OpenID] và đăng nhập vào các website nhận OpenID dùng tài khoản wiki',
	'openidlogin'                   => 'Đăng nhập dùng OpenID',
	'openidfinish'                  => 'Đăng nhập dùng OpenID xong',
	'openidserver'                  => 'Dịch vụ OpenID',
	'openidxrds'                    => 'Tập tin Yadis',
	'openidconvert'                 => 'Chuyển đổi ID Mở',
	'openiderror'                   => 'Lỗi thẩm tra',
	'openiderrortext'               => 'Có lỗi khi thẩm tra địa chỉ OpenID.',
	'openidconfigerror'             => 'Lỗi thiết lập OpenID',
	'openidconfigerrortext'         => 'Phần giữ thông tin OpenID cho wiki này không hợp lệ. Xin hãy liên lạc với người quản lý website này.',
	'openidpermission'              => 'Lỗi quyền OpenID',
	'openidpermissiontext'          => 'Địa chỉ OpenID của bạn không được phép đăng nhập vào dịch vụ này.',
	'openidcancel'                  => 'Đã hủy bỏ thẩm tra',
	'openidcanceltext'              => 'Đã hủy bỏ việc thẩm tra địa chỉ OpenID.',
	'openidfailure'                 => 'Không thẩm tra được',
	'openidfailuretext'             => 'Không thể thẩm tra địa chỉ OpenID. Lỗi: “$1”',
	'openidsuccess'                 => 'Đã thẩm tra thành công',
	'openidsuccesstext'             => 'Đã thẩm tra địa chỉ OpenID thành công.',
	'openidusernameprefix'          => 'Thành viên ID Mở',
	'openidserverlogininstructions' => 'Hãy cho vào mật khẩu ở dưới để đăng nhập vào $3 dùng tài khoản $2 (trang thảo luận $1).',
	'openidtrustinstructions'       => 'Hãy kiểm tra hộp này nếu bạn muốn cho $1 biết thông tin cá nhân của bạn.',
	'openidallowtrust'              => 'Để $1 tin cậy vào tài khoản này.',
	'openidnopolicy'                => 'Website chưa xuất bản chính sách về sự riêng tư.',
	'openidpolicy'                  => 'Hãy đọc <a target="_new" href="$1">chính sách về sự riêng tư</a> để biết thêm chi tiết.',
	'openidoptional'                => 'Tùy ý',
	'openidrequired'                => 'Bắt buộc',
	'openidnickname'                => 'Tên hiệu',
	'openidfullname'                => 'Tên đầy đủ',
	'openidemail'                   => 'Địa chỉ thư điện tử',
	'openidlanguage'                => 'Ngôn ngữ',
	'openidnotavailable'            => 'Tên hiệu mà bạn muốn sử dụng, “$1”, đã được sử dụng bởi người khác.',
	'openidnotprovided'             => 'Dịch vụ OpenID của bạn chưa cung cấp tên hiệu, hoặc vì nó không có khả năng này, hoặc bạn đã tắt tính năng tên hiệu.',
	'openidchooseinstructions'      => 'Mọi người dùng cần có tên hiệu; bạn có thể chọn tên hiệu ở dưới.',
	'openidchoosefull'              => 'Tên đầy đủ của bạn ($1)',
	'openidchooseurl'               => 'Tên bắt nguồn từ OpenID của bạn ($1)',
	'openidchooseauto'              => 'Tên tự động ($1)',
	'openidchoosemanual'            => 'Tên khác:',
	'openidchooseexisting'          => 'Một tài khoản hiện có trên wiki này:',
	'openidchoosepassword'          => 'mật khẩu:',
	'openidconvertinstructions'     => 'Mẫu này cho phép bạn thay đổi tài khoản người dùng của bạn để sử dụng một địa chỉ URL ID Mở.',
	'openidconvertsuccess'          => 'Đã chuyển đổi sang ID Mở thành công',
	'openidconvertsuccesstext'      => 'Bạn đã chuyển đổi ID Mở của bạn sang $1 thành công.',
	'openidconvertyourstext'        => 'Đó đã là ID Mở của bạn.',
	'openidconvertothertext'        => 'Đó là ID Mở của một người nào khác.',
	'openidalreadyloggedin'         => "'''Bạn đã đăng nhập rồi, $1!'''

Nếu bạn muốn sử dụng ID Mở để đăng nhập vào lần sau, bạn có thể [[Special:OpenIDConvert|chuyển đổi tài khoản của bạn để dùng ID Mở]].",
	'tog-hideopenid'                => 'Ẩn <a href="http://openid.net/">ID Mở</a> của bạn khỏi trang thành viên, nếu bạn đăng nhập bằng ID Mở.',
	'openidnousername'              => 'Chưa chỉ định tên người dùng.',
	'openidbadusername'             => 'Tên người dùng không hợp lệ.',
	'openidautosubmit'              => 'Trang này có một mẫu sẽ tự động đăng lên nếu bạn kích hoạt JavaScript.
Nếu không, hãy thử nút \\"Tiếp tục\\".',
	'openidclientonlytext'          => 'Bạn không thể sử dụng tài khoản tại wiki này như ID Mở tại trang khác.',
	'openidloginlabel'              => 'Địa chỉ OpenID',
	'openidlogininstructions'       => "{{SITENAME}} hỗ trợ chuẩn [http://openid.net/ OpenID] (ID Mở) để đăng nhập một lần giữa các trang web.
ID Mở cho phép bạn đăng nhập vào nhiều trang web khác nhau mà không phải sử dụng mật khẩu khác nhau tại mỗi trang.
(Xem [http://en.wikipedia.org/wiki/OpenID bài viết về ID Mở của Wikipedia] để biết thêm chi tiết.)

Nếu bạn đã có một tài khoản tại {{SITENAME}}, bạn có thể [[Special:Userlogin|đăng nhập]] bằng tên người dùng và mật khẩu của bạn như thông thường.
Để dùng ID Mở vào lần sau, bạn có thể [[Special:OpenIDConvert|chuyển đổi tài khoản của bạn sang ID Mở]] sau khi đã đăng nhập bình thường.

Có nhiều [http://wiki.openid.net/Public_OpenID_providers nhà cung cấp ID Mở Công cộng], và có thể bạn đã có một tài khoản kích hoạt ID Mở tại dịch vụ khác.

; Các wiki khác : Nếu bạn có tài khoản tại một wiki có sử dụng ID Mở, như [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] hay [http://kei.ki/ Keiki], bạn có thể đặp nhập vào {{SITENAME}} bằng cách gõ vào '''URL đầy đủ''' của trang người dùng của bạn tại wiki đó trong hộp ở phía trên. Ví dụ, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Nếu bạn có tài khoản Yahoo!, bạn có thể đăng nhập vào trang này bằng cách gõ vào ID Mở do Yahoo! cung cấp vào hộp phía trên. Địa chỉ URL của Yahoo! OpenID có dạng ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Nếu bạn có tài khoản [http://www.aol.com/ AOL], như một tài khoản [http://www.aim.com/ AIM], bạn có thể đăng nhập vào {{SITENAME}} bằng cách gõ ID Mở do AOL cung cấp cho bạn vào hộp phía trên. Địa chỉ URL của Open ID AOL có dạng ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Tên người dùng của bạn nên tất cả là chữ thường, không có khoảng cách.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Nếu bạn có blog tại bất kỳ một dịch nào bên trên, gõ vào địa chỉ URL blog của bạn vào hộp phía trên. Ví dụ, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', hay ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'openidlanguage' => 'Pük',
);

