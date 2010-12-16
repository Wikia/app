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
 * @author Sergey Chernyshev
 * @author Alexandre Emsenhuber
 */
$messages['en'] = array(
	'openid-desc' => 'Login to the wiki with an [http://openid.net/ OpenID], and login to other OpenID-aware web sites with a wiki user account',

	'openidlogin' => 'Login with OpenID',
	'openidserver' => 'OpenID server',
	'openidxrds' => 'Yadis file',
	'openidconvert' => 'OpenID converter',

	'openiderror' => 'Verification error',
	'openiderrortext' => 'An error occured during verification of the OpenID URL.',
	'openidconfigerror' => 'OpenID configuration error',
	'openidconfigerrortext' => 'The OpenID storage configuration for this wiki is invalid.
Please consult an [[Special:ListUsers/sysop|administrator]].',
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
	'openidtimezone' => 'Time zone',
	'openidchooselegend' => 'Username choice',
	'openidchooseinstructions' => 'All users need a nickname;
you can choose one from the options below.',
	'openidchoosenick' => 'Your nickname ($1)',
	'openidchoosefull' => 'Your full name ($1)',
	'openidchooseurl' => 'A name picked from your OpenID ($1)',
	'openidchooseauto' => 'An auto-generated name ($1)',
	'openidchoosemanual' => 'A name of your choice:',
	'openidchooseexisting' => 'An existing account on this wiki',
	'openidchooseusername' => 'Username:',
	'openidchoosepassword' => 'Password:',
	'openidconvertinstructions' => 'This form lets you change your user account to use an OpenID URL or add more OpenID URLs',
	'openidconvertoraddmoreids' => 'Convert to OpenID or add another OpenID URL',
	'openidconvertsuccess' => 'Successfully converted to OpenID',
	'openidconvertsuccesstext' => 'You have successfully converted your OpenID to $1.',
	'openidconvertyourstext' => 'That is already your OpenID.',
	'openidconvertothertext' => 'That is someone else\'s OpenID.',
	'openidalreadyloggedin' => "'''You are already logged in, $1!'''

If you want to use OpenID to log in in the future, you can [[Special:OpenIDConvert|convert your account to use OpenID]].",
	'openidnousername' => 'No username specified.',
	'openidbadusername' => 'Bad username specified.',
	'openidautosubmit' => 'This page includes a form that should be automatically submitted if you have JavaScript enabled.
If not, try the "Continue" button.',
	'openidclientonlytext' => 'You cannot use accounts from this wiki as OpenIDs on another site.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => '{{SITENAME}} supports the [http://openid.net/ OpenID] standard for single signon between Web sites.
OpenID lets you log into many different Web sites without using a different password for each.
(See [http://en.wikipedia.org/wiki/OpenID Wikipedia\'s OpenID article] for more information.)

If you already have an account on {{SITENAME}}, you can [[Special:UserLogin|log in]] with your username and password as usual.
To use OpenID in the future, you can [[Special:OpenIDConvert|convert your account to OpenID]] after you have logged in normally.

There are many [http://openid.net/get/ OpenID providers], and you may already have an OpenID-enabled account on another service.',
	'openidupdateuserinfo' => 'Update my personal information:',

	'openiddelete' => 'Delete OpenID',
	'openiddelete-text' => 'By clicking the "{{int:openiddelete-button}}" button, you will remove the OpenID $1 from your account.
You will not be able anymore to login with this OpenID.',
	'openiddelete-button' => 'Confirm',
	'openiddeleteerrornopassword' => 'You cannot delete all your OpenIDs because your account has no password.
You would not able to log in without an OpenID.',
	'openiddeleteerroropenidonly' => 'You cannot delete all your OpenIDs because your are only allowed to log in with OpenID.
You would not able to log in without an OpenID.',
	'openiddelete-sucess' => 'The OpenID has been successfully removed from your account.',
	'openiddelete-error' => 'An error occured while removing the OpenID from your account.',

	'prefs-openid' => 'OpenID',
	'openid-prefstext' => '[http://openid.net/ OpenID] preferences',
	'openid-pref-hide' => 'Hide your OpenID URL on your user page, if you log in with OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Update the following information from OpenID persona every time I login:',
	'openid-urls-desc' => 'OpenIDs associated with your account:',
	'openid-urls-url' => 'URL',
	'openid-urls-action' => 'Action',
	'openid-urls-delete' => 'Delete',
	'openid-add-url' => 'Add a new OpenID',

	'openidsigninorcreateaccount' => 'Sign-in or Create New Account',
	'openid-provider-label-openid' => 'Enter your OpenID URL',
	'openid-provider-label-google' => 'Login using your Google account',
	'openid-provider-label-yahoo' => 'Login using your Yahoo account',
	'openid-provider-label-aol' => 'Enter your AOL screenname',
	'openid-provider-label-other-username' => 'Enter your $1 username',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author IAlex
 * @author Jon Harald Søby
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 */
$messages['qqq'] = array(
	'openid-desc' => 'Short description of the Openid extension, shown in [[Special:Version]]. Do not translate or change links.',
	'openidtrustinstructions' => '* $1 is a trust root. A trust root looks much like a normal URL, but is used to describe a set of URLs. Trust roots are used by OpenID to verify that a user has approved the OpenID enabled website.',
	'openidoptional' => '{{Identical|Optional}}',
	'openidemail' => '{{Identical|E-mail address}}',
	'openidlanguage' => '{{Identical|Language}}',
	'openidtimezone' => '{{Identical|Time zone}}',
	'openidchoosepassword' => '{{Identical|Password}}',
	'openidalreadyloggedin' => '$1 is a user name.',
	'openidautosubmit' => '{{doc-important|"Continue" will never be localised. It is hardcoded in a PHP extension. Translations could be made like ""Continue" (translation)"}}',
	'openiddelete-button' => '{{Identical|Confirm}}',
	'prefs-openid' => '{{optional}}
OpenID preferences tab title',
	'openid-prefstext' => 'OpenID preferences tab text above the list of preferences',
	'openid-pref-hide' => 'OpenID preference label (Hide your OpenID URL on your user page, if you log in with OpenID)',
	'openid-pref-update-userinfo-on-login' => 'OpenID preference label for updating fron OpenID persona upon login',
	'openid-urls-action' => '{{Identical|Action}}',
	'openid-urls-delete' => '{{identical|Delete}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'openidchoosepassword' => 'ou password:',
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
	'openid-desc' => "Teken by die wiki aan met 'n [http://openid.net/ OpenID], en teken by ander OpenID ondersteunde webwerwe aan met 'n wikigebruiker",
	'openidlogin' => 'Teken aan met OpenID',
	'openidserver' => 'OpenID-bediener',
	'openidxrds' => 'Yadis-lêer',
	'openidconvert' => 'OpenID-omskakeling',
	'openiderror' => 'Verifikasiefout',
	'openiderrortext' => "'n Fout het voorgekom tydens die verifikasie van die OpenID-URL.",
	'openidconfigerror' => 'Fout met OpenID se konfigurasie',
	'openidconfigerrortext' => "OpenID se stoor-instellings vir hierdie wiki is ongeldig.
Raadpleeg asseblief 'n [[Special:ListUsers/sysop|administrateur]].",
	'openidpermission' => 'Fout in die regte vir OpenID',
	'openidpermissiontext' => 'Die OpenID wat u verskaf het word nie toegelaat om na hierdie bediener aan te teken nie.',
	'openidcancel' => 'Verifikasie is gekanselleer',
	'openidcanceltext' => 'Verifikasie van die OpenID-URL is gekanselleer.',
	'openidfailure' => 'Verifikasie het gefaal',
	'openidfailuretext' => 'Verifikasie van die OpenID-URL het gefaal. Foutboodskap: "$1"',
	'openidsuccess' => 'Verifikasie suksesvol uitgevoer',
	'openidsuccesstext' => 'Die OpenID-URL is suksesvol geverifieer.',
	'openidusernameprefix' => 'OpenIDGebruiker',
	'openidserverlogininstructions' => 'Sleutel u wagwoord hier onder in om by $3 aan te meld as gebruiker $2 (gebruikersbladsy $1).',
	'openidtrustinstructions' => 'Kontroleer of u data met $1 wil deel.',
	'openidallowtrust' => 'Laat $1 toe om hierdie gebruiker te vertrou.',
	'openidnopolicy' => "Die werf het nie 'n privaatheidsbeleid nie.",
	'openidpolicy' => 'Lees die <a target="_new" href="$1">privaatheidsbeleid</a> vir meer inligting.',
	'openidoptional' => 'Opsioneel',
	'openidrequired' => 'Verpligtend',
	'openidnickname' => 'Noemnaam',
	'openidfullname' => 'Volledige naam',
	'openidemail' => 'E-posadres',
	'openidlanguage' => 'Taal',
	'openidtimezone' => 'Tydsone',
	'openidchooselegend' => 'Gebruikersnaamkeuse',
	'openidchooseinstructions' => "Alle gebruikers moet 'n gebruikersnaam kies. U kan een kies uit die opsies hieronder.",
	'openidchoosenick' => 'U bynaam ($1)',
	'openidchoosefull' => 'U volledige naam ($1)',
	'openidchooseurl' => "'n Naam vanuit u OpenID ($1)",
	'openidchooseauto' => "'n Outomaties gegenereerde naam ($1)",
	'openidchoosemanual' => "'n Naam van u keuse:",
	'openidchooseexisting' => "'n Bestaande gebruiker op hierdie wiki:",
	'openidchooseusername' => 'Gebruikersnaam:',
	'openidchoosepassword' => 'wagwoord:',
	'openidconvertinstructions' => "Hierdie vorm laat u toe om u gebruiker te verander om 'n OpenID-URL te gebruik of om meer OpenID-URL's by te voeg.",
	'openidconvertoraddmoreids' => "Skakel om na OpenID of voeg 'n ander OpenID-URL by",
	'openidconvertsuccess' => 'Suksesvol omgeskakel na OpenID',
	'openidconvertsuccesstext' => 'U OpenID is omgeskakel na $1.',
	'openidconvertyourstext' => 'Dit is al reeds u OpenID.',
	'openidconvertothertext' => 'Dit is iemand anders se OpenID.',
	'openidalreadyloggedin' => "'''U is reeds aangeteken as $1!'''

As u in die toekoms OpenID wil gebruik om mee aan te teken, [[Special:OpenIDConvert|skakel u gebruiker om na OpenID]].",
	'openidnousername' => 'Geen gebruikersnaam is verskaf nie.',
	'openidbadusername' => 'Slegte gebruikersnaam verskaf.',
	'openidautosubmit' => 'Hierdie bladsy bevat \'n vorm wat outomaties ingedien sal word as u JavaScript in u bladleser geaktveer het.
As dit nie werk nie, kliek op die "Continue"-knoppie om voort te gaan.',
	'openidclientonlytext' => "U kan nie gebruikers van die wiki as OpenID op 'n ander webwerf gebruik nie.",
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => "{{SITENAME}} ondersteun die [http://openid.net/ OpenID]-standaard wat u toelaat om verskeie webtuistes te besoek sonder om telkens weer aan te teken.
Met OpenID kan u by verskeie webwerwe aanmeld sonder om elke keer opnuut 'n wagwoord te moet verskaf.
Sien die [http://af.wikipedia.org/wiki/OpenID Wikipedia-artikel oor OpenID] vir meer inligting.

As u reeds 'n gebruiker op {{SITENAME}} het, kan u [[Special:UserLogin|aanmeld]] met u gebruikersnaam en wagwoord soos u normaalweg doen. Om in die toekoms OpenID te gebruik, kan u u [[Special:OpenIDConvert|gebruiker na OpenID omskakel]] nadat u aangeteken het.

Daar is verskeie [http://wiki.openid.net/Public_OpenID_providers publieke OpenID-verskaffers], en waarskynlik het u reeds 'n OpenID-gebruiker by 'n ander diens.",
	'openidupdateuserinfo' => 'Opdateer my persoonlike inligting:',
	'openiddelete' => 'Skrap OpenID',
	'openiddelete-text' => 'Deur op die "{{int:openiddelete-button}}"-knoppie te kliek, verwyder u die OpenID $1 vanuit u gebruiker.
Dit sal dan nie langer moontlik wees om met hierdie OpenID aan te teken nie.',
	'openiddelete-button' => 'Bevestig',
	'openiddeleteerrornopassword' => "U kan nie al u OpenID's verwyder nie omdat u rekening nie 'n wagwoord het nie.
Sonder 'n OpenID sou u glad nie meer kon aanteken nie.",
	'openiddeleteerroropenidonly' => "U kan nie al u OpenID's verwyder nie omdat u slegs toegelaat word om met OpenID aan te teken.
Sonder 'n OpenID sou u glad nie meer kon aanteken nie.",
	'openiddelete-sucess' => 'Die OpenID is suksesvol van u gebruiker verwyder.',
	'openiddelete-error' => "'n Fout het voorgekom tydens die verwydering van die OpenID uit u gebruiker.",
	'openid-prefstext' => '[http://openid.net/ OpenID] voorkeure',
	'openid-pref-hide' => 'Versteek u OpenID op u gebruikersbladsy as u met OpenID aanteken.',
	'openid-pref-update-userinfo-on-login' => 'Opdateer die volgende inligting vanuit die OpenID-gebruiker elke keer as ek inteken:',
	'openid-urls-desc' => "OpenID's aan u gebruiker gekoppel:",
	'openid-urls-action' => 'Aksie',
	'openid-urls-delete' => 'Skrap',
	'openid-add-url' => "Voeg 'n nuwe OpenID by",
	'openidsigninorcreateaccount' => "Teken aan of skep 'n nuwe gebruiker",
	'openid-provider-label-openid' => 'Sleutel die URL van u OpenID in',
	'openid-provider-label-google' => 'Teken aan met u Google-gebruiker',
	'openid-provider-label-yahoo' => 'Teken aan met u Yahoo-gebruiker',
	'openid-provider-label-aol' => 'Teken aan met u AOL-gebruiker',
	'openid-provider-label-other-username' => 'U gebruikersnaam by $1',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'openidemail' => 'የኢ-ሜል አድራሻ',
	'openidlanguage' => 'ቋንቋ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'openid-urls-delete' => 'Borrar',
);

/** Arabic (العربية)
 * @author ;Hiba;1
 * @author Meno25
 * @author Orango
 * @author OsamaK
 */
$messages['ar'] = array(
	'openid-desc' => 'سجل الدخول للويكي [http://openid.net/ بهوية مفتوحة]، وسجل الدخول لمواقع الوب الأخرى التي تعترف بالهوية المفتوحة بحساب مستخدم ويكي',
	'openidlogin' => 'تسجيل الدخول بالهوية المفتوحة',
	'openidserver' => 'خادم الهوية المفتوحة',
	'openidxrds' => 'ملف ياديس',
	'openidconvert' => 'محول الهوية المفتوحة',
	'openiderror' => 'خطأ تأكيد',
	'openiderrortext' => 'حدث خطأ أثناء التأكد من مسار الهوية المفتوحة.',
	'openidconfigerror' => 'خطأ ضبط الهوية المفتوحة',
	'openidconfigerrortext' => 'ضبط تخزين الهوية المفتوحة لهذا الويكي غير صحيح.
من فضلك استشر [[Special:ListUsers/sysop|إداريا]].',
	'openidpermission' => 'خطأ سماحات الهوية المفتوحة',
	'openidpermissiontext' => 'الهوية المفتوحة التي وفرتها غير مسموح لها بتسجيل الدخول إلى هذا الخادم.',
	'openidcancel' => 'التأكيد تم إلغاؤه',
	'openidcanceltext' => 'التحقق من مسار الهوية المفتوحة تم إلغاؤه.',
	'openidfailure' => 'فشل التحقق',
	'openidfailuretext' => 'التحقق من مسار الهوية المفتوحة فشل. رسالة خطأ: "$1"',
	'openidsuccess' => 'نحج التحقق',
	'openidsuccesstext' => 'نجح التحقق من مسار الهوية المفتوحة.',
	'openidusernameprefix' => 'مستخدم الهوية المفتوحة',
	'openidserverlogininstructions' => 'أدخل كلمة سرك بالأسفل لتسجيل الدخول إلى $3 كمستخدم $2 (صفحة مستخدم $1).',
	'openidtrustinstructions' => 'تأكد مما إذا كنت ترغب في مشاركة البيانات مع $1.',
	'openidallowtrust' => 'السماح ل$1 بالوثوق بحساب هذا المستخدم.',
	'openidnopolicy' => 'الموقع لا يمتلك سياسة محددة للخصوصية.',
	'openidpolicy' => 'تحقق من <a target="_new" href="$1">سياسة الخصوصية</a> لمزيد من المعلومات.',
	'openidoptional' => 'اختياري',
	'openidrequired' => 'مطلوب',
	'openidnickname' => 'اللقب',
	'openidfullname' => 'الاسم الكامل',
	'openidemail' => 'عنوان البريد الإلكتروني',
	'openidlanguage' => 'اللغة',
	'openidtimezone' => 'المنطقة الزمنية',
	'openidchooselegend' => 'اختيار اسم المستخدم',
	'openidchooseinstructions' => 'كل المستخدمين يحتاجون إلى لقب؛
يمكنك أن تختار واحدا من الخيارات بالأسفل.',
	'openidchoosenick' => 'اسمك المستعار ($1)',
	'openidchoosefull' => 'اسمك الكامل ($1)',
	'openidchooseurl' => 'اسم مختار من هويتك المفتوحة ($1)',
	'openidchooseauto' => 'اسم مولد تلقائيا ($1)',
	'openidchoosemanual' => 'اسم من اختيارك:',
	'openidchooseexisting' => 'حساب موجود في هذا الويكي',
	'openidchooseusername' => 'اسم المستخدم:',
	'openidchoosepassword' => 'كلمة السر:',
	'openidconvertinstructions' => 'هذه الاستمارة تتيح لك تغيير حساب مستخدمك لتستخدم مسار هوية مفتوحة أو لاضافة المزيد من مسارات هويات مفتوحة.',
	'openidconvertoraddmoreids' => 'حوّل إلى OpenID أو أضف عنوان OpenID آخر',
	'openidconvertsuccess' => 'تم التحول بنجاح إلى الهوية المفتوحة',
	'openidconvertsuccesstext' => 'أنت حولت بنجاح هويتك المفتوحة إلى $1.',
	'openidconvertyourstext' => 'هذه بالفعل هويتك المفتوحة.',
	'openidconvertothertext' => 'هذه هي الهوية المفتوحة لشخص آخر.',
	'openidalreadyloggedin' => "'''أنت مسجل الدخول بالفعل، $1!'''

لو كنت تريد استخدام الهوية المفتوحة لتسجيل الدخول في المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك لاستخدام الهوية المفتوحة]].",
	'openidnousername' => 'لا اسم مستخدم تم تحديده.',
	'openidbadusername' => 'اسم المستخدم المحدد سيء.',
	'openidautosubmit' => 'هذه الصفحة تحتوي على استمارة ينبغي أن يتم إرسالها تلقائيا لو أنك لديك الجافاسكريبت مفعلة.
لو لا، جرب زر "Continue".',
	'openidclientonlytext' => 'لا يمكنك استخدام حسابات هذه الويكي كهوية مفتوحة على موقع آخر.',
	'openidloginlabel' => 'مسار الهوية المفتوحة',
	'openidlogininstructions' => '{{SITENAME}} تدعم معيار [http://openid.net/ الهوية المفتوحة] للدخول الفردي بين مواقع الوب.
الهوية المفتوحة تسمح لك بتسجيل الدخول إلى مواقع وب عديدة مختلفة بدون استخدام كلمة سر مختلفة لكل موقع.
(راجع [http://en.wikipedia.org/wiki/OpenID مقالة الهوية المفتوحة في يويكيبيديا] لمزيد من المعلومات.)

إذا كان لديك بالفعل حساب في {{SITENAME}}، يمكنك [[Special:UserLogin|تسجيل الدخول]] باسم مستخدمك وكلمة سرك كالمعتاد.
لاستخدام الهوية المفتوحة في المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك إلى الهوية المفتوحة]] بعد تسجيل دخولك بشكل عادي.

يوجد العديد من [http://wiki.openid.net/Public_OpenID_providers مزودي الهوية المفتوحة]، وقد يكون لديك حسابك بهوية مفتوحة على خدمة أخرى.',
	'openidupdateuserinfo' => 'تحديث معلوماتي الشخصية:',
	'openiddelete' => 'احذف الهوية المفتوحة',
	'openiddelete-text' => 'بالضغط على زر "{{int:openiddelete-button}}"، ستزيل الهوية المفتوحة OpenID $1 من حسابك.
لن تتمكن بعد الآن من الدخول بهذه الهوية المفتوحة.',
	'openiddelete-button' => 'أكّد',
	'openiddeleteerrornopassword' => 'لا يمكنك إزالة كل هوياتك المفتوحة لعدم وجود كلمة سر لحسابك.
لن تتمكن من الولوج بدون هوية مفتوحة.',
	'openiddeleteerroropenidonly' => 'لا يمكنك إزالة كل هوياتك المفتوحة لأنه يسمح لك بالدخول عبر هوية مفتوحة فقط.
لن تتمكن من الولوج بدون هوية مفتوحة.',
	'openiddelete-sucess' => 'أزيلت الهوية المفتوحة بنجاح من حسابك.',
	'openiddelete-error' => 'صودف خطأ أثناء إزالة الهوية المفتوحة من حسابك.',
	'prefs-openid' => 'هوية مفتوحة',
	'openid-prefstext' => 'تفضيلات [http://openid.net/ الهوية المفتوحة]',
	'openid-pref-hide' => 'أخفِ مسار هويتك المفتوحة من صفحتك الشخصية، إذا سجلت الدخول بالهوية المفتوحة.',
	'openid-pref-update-userinfo-on-login' => 'حدث المعلومات التالية من شخصية الهوية المفتوحة كل مرة أسجل الدخول:',
	'openid-urls-desc' => 'الهويات المفتوحة المربوطة بحسابك:',
	'openid-urls-url' => 'مسار',
	'openid-urls-action' => 'إجراء',
	'openid-urls-delete' => 'احذف',
	'openid-add-url' => 'أضف هوية مفتوحة جديدة',
	'openidsigninorcreateaccount' => 'سجل الدخول أو أنشئ حسابا جديدا',
	'openid-provider-label-openid' => 'أدخل مسار هويتك المفتوحة',
	'openid-provider-label-google' => 'سجل الدخول باستخدام حسابك في جوجل',
	'openid-provider-label-yahoo' => 'سجل الدخول باستخدام حسابك في ياهو',
	'openid-provider-label-aol' => 'أدخل اسم شاشة AOL الخاص بك',
	'openid-provider-label-other-username' => 'أدخل اسم مستخدمك في $1',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'openidchoosepassword' => 'ܡܠܬܐ ܕܥܠܠܐ:',
	'openiddelete-button' => 'ܚܬܬ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Dudi
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'openid-desc' => 'سجل الدخول للويكى [http://openid.net/ بهوية مفتوحة]، وسجل الدخول لمواقع ويب أخرى تعرف الهوية المفتوحة بحساب مستخدم ويكي',
	'openidlogin' => 'تسجيل الدخول بالهوية المفتوحة',
	'openidserver' => 'خادم الهوية المفتوحة',
	'openidxrds' => 'ملف ياديس',
	'openidconvert' => 'محول الهوية المفتوحة',
	'openiderror' => 'خطأ تأكيد',
	'openiderrortext' => 'حدث خطأ أثناء التأكد من مسار الهوية المفتوحة.',
	'openidconfigerror' => 'خطأ ضبط الهوية المفتوحة',
	'openidconfigerrortext' => 'ضبط تخزين الهوية المفتوحة لهذا الويكى غير صحيح.
من فضلك استشر [[Special:ListUsers/sysop|إداريا]].',
	'openidpermission' => 'خطأ سماحات الهوية المفتوحة',
	'openidpermissiontext' => 'الهوية المفتوحة التى وفرتها غير مسموح لها بتسجيل الدخول إلى هذا الخادم.',
	'openidcancel' => 'التأكيد تم إلغاؤه',
	'openidcanceltext' => 'التحقق من مسار الهوية المفتوحة تم إلغاؤه.',
	'openidfailure' => 'التأكيد فشل',
	'openidfailuretext' => 'التحقق من مسار الهوية المفتوحة فشل. رسالة خطأ: "$1"',
	'openidsuccess' => 'التأكيد نجح',
	'openidsuccesstext' => 'التحقق من مسار الهوية المفتوحة نجح.',
	'openidusernameprefix' => 'مستخدم الهوية المفتوحة',
	'openidserverlogininstructions' => 'أدخل كلمة سرك بالأسفل لتسجيل الدخول إلى $3 كمستخدم $2 (صفحة مستخدم $1).',
	'openidtrustinstructions' => 'تأكد مما إذا كنت ترغب فى مشاركة البيانات مع $1.',
	'openidallowtrust' => 'السماح ل$1 بالوثوق بحساب هذا المستخدم.',
	'openidnopolicy' => 'الموقع لا يمتلك سياسة محددة للخصوصية.',
	'openidpolicy' => 'تحقق من <a target="_new" href="$1">سياسة الخصوصية</a> لمزيد من المعلومات.',
	'openidoptional' => 'اختياري',
	'openidrequired' => 'مطلوب',
	'openidnickname' => 'اللقب',
	'openidfullname' => 'الاسم الكامل',
	'openidemail' => 'عنوان البريد الإلكتروني',
	'openidlanguage' => 'اللغة',
	'openidchooseinstructions' => 'كل المستخدمين يحتاجون إلى لقب؛
يمكنك أن تختار واحدا من الخيارات بالأسفل.',
	'openidchoosefull' => 'اسمك الكامل ($1)',
	'openidchooseurl' => 'اسم مختار من هويتك المفتوحة ($1)',
	'openidchooseauto' => 'اسم مولد تلقائيا ($1)',
	'openidchoosemanual' => 'اسم من اختيارك:',
	'openidchooseexisting' => 'حساب موجود فى الويكى دى',
	'openidchoosepassword' => 'كلمة السر:',
	'openidconvertinstructions' => 'هذه الاستمارة تتيح لك تغيير حساب المستخدم الخاص بك لكى تستخدم OpenID URL او لاضافة المزيد من OpenID URLs .',
	'openidconvertsuccess' => 'تم التحول بنجاح إلى الهوية المفتوحة',
	'openidconvertsuccesstext' => 'أنت حولت بنجاح هويتك المفتوحة إلى $1.',
	'openidconvertyourstext' => 'هذه بالفعل هويتك المفتوحة.',
	'openidconvertothertext' => 'هذه هى الهوية المفتوحة لشخص آخر.',
	'openidalreadyloggedin' => "'''أنت مسجل الدخول بالفعل، $1!'''

لو كنت تريد استخدام الهوية المفتوحة لتسجيل الدخول فى المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك لاستخدام الهوية المفتوحة]].",
	'openidnousername' => 'مافيش اسم يوزر تم تحديده.',
	'openidbadusername' => 'اسم المستخدم المحدد سيء.',
	'openidautosubmit' => 'هذه الصفحة تحتوى على إستمارة ينبغى أن يتم إرسالها تلقائيا لو أنك لديك الجافاسكريبت مفعلة.
لو لا، جرب زر "Continue".',
	'openidclientonlytext' => 'أنت لا يمكنك استخدام الحسابات من هذا الويكى كهوية مفتوحة على موقع آخر.',
	'openidloginlabel' => 'مسار الهوية المفتوحة',
	'openidlogininstructions' => '{{SITENAME}} تدعم معيار [http://openid.net/ الهوية المفتوحة] للدخول الفردى بين مواقع الويب.
الهوية المفتوحة تسمح لك بتسجيل الدخول إلى مواقع ويب عديدة مختلفة بدون استخدام كلمة سر مختلفة لكل موقع.
(انظر [http://en.wikipedia.org/wiki/OpenID مقالة الهوية المفتوحة فى يويكيبيديا] لمزيد من المعلومات.)

لو أنك لديك بالفعل حساب فى {{SITENAME}}، يمكنك [[Special:UserLogin|تسجيل الدخول]] باسم مستخدمك وكلمة السر الخاصة بك كالمعتاد.
لاستخدام الهوية المفتوحة فى المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك إلى الهوية المفتوحة]] بعد تسجيل دخولك بشكل عادى.

يوجد العديد من [http://wiki.openid.net/Public_OpenID_providers موفرى الهوية المفتوحة العلنيين]، وربما يكون لديك حسابك بهوية مفتوحة على خدمة أخرى.',
	'openid-pref-hide' => 'أخف هويتك هويتك المفتوحة على صفحتك الشخصية، لو سجلت الدخول بالهوية المفتوحة.',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'openidlanguage' => 'Llingua',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'openid-desc' => 'Уваход ў {{GRAMMAR:вінавальны|{{SITENAME}}}} з дапамогай [http://openid.net/ OpenID], а так сама ў іншыя сайты, якія падтрымліваюць OpenID з вікі-рахунка',
	'openidlogin' => 'Уваход у сыстэму з дапамогай OpenID',
	'openidserver' => 'Сэрвэр OpenID',
	'openidxrds' => 'Файл Yadis',
	'openidconvert' => 'Канвэртар OpenID',
	'openiderror' => 'Памылка праверкі',
	'openiderrortext' => 'Пад час праверкі адрасу OpenID узьнікла памылка.',
	'openidconfigerror' => 'Памылка ў канфігурацыі OpenID',
	'openidconfigerrortext' => 'Канфігурацыя сховішча OpenID у {{GRAMMAR:месны|{{SITENAME}}}} — няслушная.
Калі ласка, зьвярніцеся да [[Special:ListUsers/sysop|адміністратараў]].',
	'openidpermission' => 'Памылка правоў доступу OpenID',
	'openidpermissiontext' => 'Пазначаны Вамі OpenID не дазваляе ўвайсьці на гэты сэрвэр.',
	'openidcancel' => 'Праверка адменена',
	'openidcanceltext' => 'Праверка адрасу OpenID была скасавана.',
	'openidfailure' => 'Праверка не атрымалася',
	'openidfailuretext' => 'Праверка адрасу OpenID не атрымалася. Паведамленьне пра памылку: «$1»',
	'openidsuccess' => 'Праверка прайшла пасьпяхова',
	'openidsuccesstext' => 'Праверка адрасу OpenID прайшла пасьпяхова.',
	'openidusernameprefix' => 'КарыстальнікOpenID',
	'openidserverlogininstructions' => 'Увядзіце Ваш пароль ніжэй, каб увайсьці на $3 як {{GENDER:$2|удзельнік|удзельніца}} $2 (старонка {{GENDER:$2|ўдзельніка|удзельніцы}} $1).',
	'openidtrustinstructions' => 'Пазначце, калі Вы жадаеце даць доступ да зьвестак для $1.',
	'openidallowtrust' => 'Дазволіць $1 давераць гэтаму рахунку.',
	'openidnopolicy' => 'Сайт ня мае правілаў адносна прыватнасьці.',
	'openidpolicy' => 'Глядзіце дадатковую інфармацыю ў <a target="_new" href="$1">правілах адносна прыватнасьці</a>.',
	'openidoptional' => 'Неабавязковае',
	'openidrequired' => 'Абавязковае',
	'openidnickname' => 'Мянушка',
	'openidfullname' => 'Поўнае імя',
	'openidemail' => 'Адрас электроннай пошты',
	'openidlanguage' => 'Мова',
	'openidtimezone' => 'Часавы пояс',
	'openidchooselegend' => 'Выбар імя карыстальніка',
	'openidchooseinstructions' => 'Кожны ўдзельнік павінен мець мянушку;
Вы можаце выбраць адну з пададзеных ніжэй.',
	'openidchoosenick' => 'Ваша мянушка ($1)',
	'openidchoosefull' => 'Ваша поўнае імя ($1)',
	'openidchooseurl' => 'Імя атрыманае ад Вашага сэрвэра OpenID ($1)',
	'openidchooseauto' => 'Аўтаматычна створанае імя ($1)',
	'openidchoosemanual' => 'Імя на Ваш выбар:',
	'openidchooseexisting' => 'Існуючы рахунак у {{GRAMMAR:месны|{{SITENAME}}}}',
	'openidchooseusername' => 'Імя карыстальніка:',
	'openidchoosepassword' => 'пароль:',
	'openidconvertinstructions' => 'Гэта форма дазваляе выкарыстоўваць для Вашага рахунку адрас OpenID альбо дадаць іншыя адрасы OpenID.',
	'openidconvertoraddmoreids' => 'Канвэртаваць у OpenID альбо дадаць іншы адрас OpenID',
	'openidconvertsuccess' => 'Пасьпяховае пераўтварэньне ў OpenID',
	'openidconvertsuccesstext' => 'Вы пасьпяхова пераўтварылі Ваш OpenID у $1.',
	'openidconvertyourstext' => 'Гэта ўжо Ваш OpenID.',
	'openidconvertothertext' => 'Гэта ня Ваш OpenID.',
	'openidalreadyloggedin' => "'''Вы ўжо ўвайшлі, $1!'''

Калі Вы жадаеце выкарыстоўваць OpenID для ўваходаў у будучыні, Вы можаце [[Special:OpenIDConvert|пераўтварыць Ваш рахунак на выкарыстаньне OpenID]].",
	'openidnousername' => 'Не пазначана імя ўдзельніка.',
	'openidbadusername' => 'Пазначана няслушнае імя ўдзельніка.',
	'openidautosubmit' => 'Гэта старонка ўтрымлівае форму, якая павінна быць аўтаматычна адпраўлена, калі ў Вас уключаны JavaScript.
Калі гэтага не адбылася, паспрабуйце націснуць кнопку «Continue» (Працягнуць).',
	'openidclientonlytext' => 'Вы ня можаце выкарыстоўваць рахункі {{GRAMMAR:родны|{{SITENAME}}}} як OpenID на іншых сайтах.',
	'openidloginlabel' => 'Адрас OpenID',
	'openidlogininstructions' => "{{SITENAME}} падтрымлівае стандарт [http://openid.net/ OpenID], які дазваляе выкарыстоўваць адзіны уліковы запіс для ўваходу ў розныя сайты без выкарыстаньня розных пароляў для кожнага зь іх.
(Глядзіце падрабязнасьці на [http://en.wikipedia.org/wiki/OpenID Wikipedia's OpenID article].)

Калі Вы ўжо маеце рахунак у {{GRAMMAR:месны|{{SITENAME}}}}, Вы можаце [[Special:UserLogin|ўвайсьці]] з Вашым імем і паролем як звычайна.
Каб выкарыстоўваць OpenID у будучыні, Вы можаце [[Special:OpenIDConvert|пераўтварыць Ваш рахунак у OpenID]] пасьля таго, як увайшлі звычайным чынам.

Існуе шмат [http://openid.net/get/ OpenID сэрвісаў], у Вы, магчыма, ужо маеце OpenID рахунак у іншым сэрвісе.",
	'openidupdateuserinfo' => 'Абнавіць маю асабістую інфармацыю:',
	'openiddelete' => 'Выдаліць OpenID',
	'openiddelete-text' => 'Націснуўшы кнопку «{{int:openiddelete-button}}» Вы выдаліце OpenID $1 з Вашага рахунку.
Вы болей ня зможаце ўваходзіць у сыстэму з гэтым OpenID.',
	'openiddelete-button' => 'Пацьвердзіць',
	'openiddeleteerrornopassword' => 'Вы ня можаце выдаліць усе Вашыя OpenID, таму што Ваш рахунак ня мае паролю.
Вы ня зможаце ўвайсьці ў сыстэму без OpenID.',
	'openiddeleteerroropenidonly' => 'Вы ня можаце выдаліць усе Вашыя OpenID, таму што Вам дазволена ўваходзіць у сыстэму толькі праз OpenID.
Вы ня зможаце ўвайсьці ў сыстэму без OpenID.',
	'openiddelete-sucess' => 'OpenID быў пасьпяхова выдалены з Вашага рахунку.',
	'openiddelete-error' => 'Адбылася памылка пад час выдаленьня OpenID з Вашага рахунку.',
	'openid-prefstext' => 'Устаноўкі [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Хаваць Ваш адрас OpenID на Вашай старонцы ўдзельніка, калі Вы ўвайшлі з дапамогай OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Абнаўляць наступную інфармацыю з OpenID кожны раз, калі я уваходжу ў сыстэму:',
	'openid-urls-desc' => 'OpenID зьвязаныя з Вашым рахункам:',
	'openid-urls-action' => 'Дзеяньне',
	'openid-urls-delete' => 'Выдаліць',
	'openid-add-url' => 'Дадаць новы OpenID',
	'openidsigninorcreateaccount' => 'Увайсьці альбо стварыць новы рахунак',
	'openid-provider-label-openid' => 'Увядзіце Ваш адрас OpenID',
	'openid-provider-label-google' => 'Увайсьці з дапамогай Вашага рахунку ў Google',
	'openid-provider-label-yahoo' => 'Увайсьці з дапамогай Вашага рахунку ў Yahoo',
	'openid-provider-label-aol' => 'Увядзіце назву Вашага рахунку ў AOL',
	'openid-provider-label-other-username' => 'Увядзіце Вашае імя ўдзельніка $1',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Stanqo
 */
$messages['bg'] = array(
	'openidlogin' => 'Влизане с OpenID',
	'openidserver' => 'OpenID сървър',
	'openidxrds' => 'Yadis файл',
	'openidconvert' => 'Конвертор за OpenID',
	'openiderror' => 'Грешка при потвърждението',
	'openidconfigerror' => 'OpenID грешка при конфигурирането',
	'openidpermissiontext' => 'На предоставеното OpenID не е позволено да влиза на този сървър.',
	'openidcancel' => 'Потвърждението беше прекратено',
	'openidcanceltext' => 'Потвърждението на OpenID URL беше прекратено.',
	'openidfailure' => 'Потвърждението беше неуспешно',
	'openidfailuretext' => 'Потвърждението на OpenID URL беше неуспешно. Грешка: „$1“',
	'openidsuccess' => 'Потвърждението беше успешно',
	'openidsuccesstext' => 'Потвърждението на OpenID URL беше успешно.',
	'openidserverlogininstructions' => 'Въведете паролата си по-долу за да влезете в $3 като потребител $2 (потребителска страница $1).',
	'openidnopolicy' => 'Сайтът няма уточнена политика за защита на личните данни.',
	'openidpolicy' => 'За повече информация вижте политиката за <a target="_new" href="$1">защита на личните данни</a>.',
	'openidoptional' => 'Незадължително',
	'openidrequired' => 'Изисква се',
	'openidnickname' => 'Псевдоним',
	'openidfullname' => 'Име',
	'openidemail' => 'Електронна поща',
	'openidlanguage' => 'Език',
	'openidtimezone' => 'Часова зона',
	'openidchooselegend' => 'Избор на потребителско име',
	'openidchooseinstructions' => 'Всички потребители трябва да имат потребителско име;
можете да изберете своето от предложенията по-долу.',
	'openidchoosefull' => 'Вашето пълно име ($1)',
	'openidchooseauto' => 'Автоматично генерирано име ($1)',
	'openidchoosemanual' => 'Име по избор:',
	'openidchooseexisting' => 'Съществуваща сметка в това уики',
	'openidchooseusername' => 'Потребителско име:',
	'openidchoosepassword' => 'парола:',
	'openidconvertinstructions' => 'Този формуляр позволява да се промени потребителската сметка да използва OpenID URL.',
	'openidconvertsuccess' => 'Преобразуването в OpenID беше успешно',
	'openidconvertsuccesstext' => 'Успешно преобразувахте вашият OpenID в $1.',
	'openidconvertyourstext' => 'Това вече е вашият OpenID.',
	'openidconvertothertext' => 'Това е OpenID на някой друг.',
	'openidalreadyloggedin' => "'''Вече сте влезли в системата, $1!'''

Ако желаете да използвате OpenID за бъдещи влизания, можете да [[Special:OpenIDConvert|преобразувате сметката си да използва OpenID]].",
	'openidnousername' => 'Не е посочено потребителско име.',
	'openidbadusername' => 'Беше посочено невалидно име.',
	'openidautosubmit' => 'Тази страница включва формуляр, който би трябвало да се изпрати автоматично ако Джаваскриптът е разрешен.
Ако не е, можете да използвате бутона "Continue" (Продължаване).',
	'openidclientonlytext' => 'Не можете да използвате сметки от това уики като OpenID за друг сайт.',
	'openidloginlabel' => 'OpenID Адрес',
	'openidlogininstructions' => "{{SITENAME}} поддържа [http://openid.net/ OpenID] стандарта за single signon between Web sites.
OpenID позволява влизането в много различни сайтове без да е необходимо да се регистрирате за всеки поотделно.
(Вижте [http://en.wikipedia.org/wiki/OpenID статията за OpenID в Уикипедия] за повече информация.)

Ако вече имате сметка в {{SITENAME}}, можете [[Special:UserLogin|да влезете]] с потребителското си име и парола, както обикновено.
Ако желаете да използвате OpenID, можете [[Special:OpenIDConvert|да преобразувате сметката си в OpenID]] след като влезете в системата.

Налични са много [http://wiki.openid.net/Public_OpenID_providers обществени доставчици на OpenID] и е възможно вече да имате сметка, която поддържа OpenID в друг сайт.

; Други уикита: Ако имате сметка в уики, което поддържа OpenID като [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] или [http://kei.ki/ Keiki], можете да влезете в {{SITENAME}} като въведете в кутията по-горе '''пълния адрес''' към потребителската си страница в другото уикиo, напр. ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!]: Ако имате сметка в Yahoo!, можете да влезете в този сайт като в кутията по-горе въведете вашето Yahoo! OpenID. Yahoo! OpenID адресите са от вида ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL]: Ако притежавате сметка в [http://www.aol.com/ AOL], напр. в [http://www.aim.com/ AIM], можете да влезете в {{SITENAME}} като въведете в кутията по-горе вашето AOL OpenID. AOL OpenID адресите са от вида ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Потребителското име се изписва само с малки букви и без интервали.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Ако имате блог в някоя от тези услуги, въведете адреса на блога си в кутията по-горе, напр. ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'' или ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
	'openidupdateuserinfo' => 'Актуализация на моята лична информация',
	'openiddelete' => 'Изтриване на OpenID',
	'openiddelete-button' => 'Потвърждаване',
	'openid-pref-hide' => 'Скриване на OpenID от потребителската страница ако влезете чрез OpenID.',
	'openid-urls-action' => 'Действие',
	'openid-urls-delete' => 'Изтриване',
	'openid-add-url' => 'Добавяне на нов OpenID',
	'openidsigninorcreateaccount' => 'Влизане или създаване на нова сметка',
	'openid-provider-label-openid' => 'Въведете своя OpenID интернет адрес',
	'openid-provider-label-google' => 'Влизане в системата през профила в Google',
	'openid-provider-label-other-username' => 'Въведете вашето $1 потребителско име',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'openidlogin' => 'Kevreañ gant OpenID',
	'openidserver' => 'Servijer OpenID',
	'openidxrds' => 'Restr Yadis',
	'openidconvert' => 'Amdroer OpenID',
	'openiderror' => 'Fazi gwiriañ',
	'openiderrortext' => 'Ur fazi a zo bet e-pad gwiriekadenn ar URL OpenID.',
	'openidconfigerror' => 'Fazi kefluniadur OpenID',
	'openidpermission' => 'Fazi gant an aotre OpenID',
	'openidpermissiontext' => "N'eo ket aotreet an OpenID ho peus roet d'en em lugañ war ar servijer-mañ.",
	'openidcancel' => 'Nullet eo bet ar wiriekadur',
	'openidcanceltext' => "Nullet eo bet ar gwiriekadenn eus ar chomlec'h OpenID.",
	'openidfailure' => "C'hwitet eo ar gwiriadur",
	'openidfailuretext' => 'C\'huitet eo bet gwiriekadenn ar chomlec\'h OpenID. Kemennadenn fazi : "$1"',
	'openidsuccess' => 'Graet eo bet ar wiriekadur',
	'openidsuccesstext' => "Graet eo bet gwiriekadur ar c'homlec'h OpenID.",
	'openidusernameprefix' => 'Implijer OpenID',
	'openidserverlogininstructions' => 'Lakait ho ger tremen amañ a-is evit en em lugañ e $3 evel an implijer $2 (pajenn implijer $1).',
	'openidtrustinstructions' => "Gevaskit m'ho peus c'hoant kenrannañ an titouroù gant $1.",
	'openidallowtrust' => "Aotreañ $1 da gaout fiziañs d'ar gont implijer-se.",
	'openidnopolicy' => "N'en deus ket meneget al lec'hienn a bolitikerezh prevezded.",
	'openidpolicy' => 'Gwiriañ <a target="_new" href="$1">ar bolitikerezh prevezded</a> evit muioc\'h a ditouroù.',
	'openidoptional' => 'Diret',
	'openidrequired' => 'Rekis',
	'openidnickname' => 'Lesanv',
	'openidfullname' => 'Anv klok',
	'openidemail' => "Chomlec'h postel",
	'openidlanguage' => 'Yezh',
	'openidtimezone' => 'Takad eur :',
	'openidchooselegend' => 'Dibab an anv implijer',
	'openidchooseinstructions' => "An holl implijerien o deus ezhomm ul lesanv ;
tu 'zo deoc'h dibab unan eus ar c'hinnigoù a-is.",
	'openidchoosenick' => 'Ho lesanv ($1)',
	'openidchoosefull' => "Hoc'h anv klok ($1)",
	'openidchooseurl' => 'Un anv a zo bet dibabet adalek ho OpenID ($1)',
	'openidchooseauto' => 'Un anv krouet emgefre ($1)',
	'openidchoosemanual' => "Un anv dibabet ganeoc'h :",
	'openidchooseexisting' => 'Ur gont zo anezhi war ar wiki-mañ',
	'openidchooseusername' => 'Anv implijer :',
	'openidchoosepassword' => 'ger-tremen :',
	'openidconvertoraddmoreids' => "Amdreiñ da OpenID pe ouzhpennañ ur chomlec'h OpenID all",
	'openidconvertsuccess' => 'Amdroet eo bet davet OpenID',
	'openidconvertsuccesstext' => 'Amdroet ho peus ho OpenID davet $1.',
	'openidconvertyourstext' => 'Ho OpenID eo dija.',
	'openidconvertothertext' => 'OpenID un implijer all eo dija.',
	'openidalreadyloggedin' => "'''Kevreet oc'h dija, $1!'''

Ma fell deoc'h implijout OpenID da gevreañ diwezhatoc'h, e c'hallit [[Special:OpenIDConvert|amdreiñ ho kont evit implijout OpenID]].",
	'openidnousername' => "N'eus bet diferet anv implijer ebet.",
	'openidbadusername' => 'Un anv implijer fall a zo bet lakaet.',
	'openidloginlabel' => 'URL OpenID',
	'openidupdateuserinfo' => 'Hizivaat ma zitouroù personel :',
	'openiddelete' => 'Dilemel an OpenID',
	'openiddelete-button' => 'Kadarnaat',
	'openiddeleteerrornopassword' => "Ne c'hallit ket dilemel hoc'h holl OpenID abalamour ma n'eus ger-tremen ebet gant ho kont.
Ne c'hallfec'h ket kevreañ hep OpenID.",
	'openiddelete-sucess' => 'Tennet eo bet an OpenID eus ho kont.',
	'openiddelete-error' => "Ur fazi a zo bet pa oac'h o klask tennañ an OpenID eus ho kont.",
	'openid-prefstext' => 'Penndibaboù an [http://openid.net/ OpenID]',
	'openid-pref-hide' => "Kuzhet ho OpenID war ho pajenn implijer, m'en em lugoc'h gant OpenID.",
	'openid-pref-update-userinfo-on-login' => "Hizivaat ar roadennoù da heul adalek OpenID bep tro m'en em lugan :",
	'openid-urls-desc' => 'OpenID kevredet gant ho kont :',
	'openid-urls-action' => 'Ober',
	'openid-urls-delete' => 'Dilemel',
	'openid-add-url' => 'Ouzhpennañ un OpenID nevez',
	'openidsigninorcreateaccount' => 'En em lugañ pe krouiñ ur gont nevez',
	'openid-provider-label-openid' => "Ebarzhit hoc'h URL OpenID",
	'openid-provider-label-google' => 'Kevreañ en ur implijout ho kont Google',
	'openid-provider-label-yahoo' => 'Lugañ en ur implij ho kont Yahoo',
	'openid-provider-label-aol' => "Ebarzhit hoc'h anv AOL",
	'openid-provider-label-other-username' => "Ebarzhit hoc'h anv implijer $1",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'openid-desc' => 'Prijava na wiki sa [http://openid.net/ OpenID] i prijava na druge stranice koje podržavaju OpenID sa wiki korisničkim računom',
	'openidlogin' => 'Prijava sa OpenID',
	'openidserver' => 'OpenID server',
	'openidxrds' => 'Yadis datoteka',
	'openidconvert' => 'OpenID pretvarač',
	'openiderror' => 'Greška pri provjeri',
	'openiderrortext' => 'Desila se greška pri provjeri OpenID URL adrese.',
	'openidconfigerror' => 'Greška OpenID postavki',
	'openidconfigerrortext' => 'OpenID konfiguracija spremanja za ovaj wiki je nevaljana. 
Molimo konsultujte se sa [[Special:ListUsers/sysop|administratorom]].',
	'openidpermission' => 'Greška kod OpenID dopuštenja',
	'openidpermissiontext' => 'OpenID koji ste naveli nije dopušteno da se prijavi na ovaj server.',
	'openidcancel' => 'Provjera poništena',
	'openidcanceltext' => 'Provjera OpenID URL-a je otkazana.',
	'openidfailure' => 'Potvrda nije uspjela',
	'openidfailuretext' => 'Provjera URL-a za OpenID nije uspjela. Poruka greške: "$1"',
	'openidsuccess' => 'Provjera uspješna',
	'openidsuccesstext' => 'Provjera URL-a za OpenID je uspjela.',
	'openidusernameprefix' => 'OpenIDKorisnik',
	'openidserverlogininstructions' => 'Unesite ispod Vašu šifru da biste se prijavili na $3 kao korisnik $2 (korisnička stranica $1).',
	'openidtrustinstructions' => 'Provjerite da li želite dijeliti podatke sa $1.',
	'openidallowtrust' => 'Omogući $1 da vjeruje ovom korisničkom računu.',
	'openidnopolicy' => 'Sajt nema napisana pravila privatnosti.',
	'openidpolicy' => 'Provjerite <a target="_new" href="$1">politiku privatnosti</a> za više informacija.',
	'openidoptional' => 'opcionalno',
	'openidrequired' => 'obavezno',
	'openidnickname' => 'Nadimak',
	'openidfullname' => 'Puno ime',
	'openidemail' => 'E-mail adresa',
	'openidlanguage' => 'Jezik',
	'openidtimezone' => 'Vremenska zona',
	'openidchooselegend' => 'Odabir korisničkog imena',
	'openidchooseinstructions' => 'Svi korisnici trebaju imati nadimak;
možete odabrati jedan sa opcijama ispod.',
	'openidchoosenick' => 'Vaš nadimak ($1)',
	'openidchoosefull' => 'Vaše puno ime ($1)',
	'openidchooseurl' => 'Ime uzeto sa Vašeg OpenID ($1)',
	'openidchooseauto' => 'Automatski generisano ime ($1)',
	'openidchoosemanual' => 'Naziv po Vašem izboru:',
	'openidchooseexisting' => 'Postojeći račun na ovoj wiki',
	'openidchooseusername' => 'korisničko ime:',
	'openidchoosepassword' => 'šifra:',
	'openidconvertinstructions' => 'Ovaj obrazac Vam omogućuje da promijenite Vaš korisnički račun za upotrebu URL OpenID ili da dodate više OpenID URLova',
	'openidconvertoraddmoreids' => 'Pretvorite u OpenID ili dodajte drugi OpenID URL',
	'openidconvertsuccess' => 'Uspješno prevedeno u OpenID',
	'openidconvertsuccesstext' => 'Uspješno ste pretvorili Vaš OpenID u $1.',
	'openidconvertyourstext' => 'To je već Vaš OpenID.',
	'openidconvertothertext' => 'To je OpenID koji pripada nekom drugom.',
	'openidalreadyloggedin' => "'''Vi ste već prijavljeni, $1!'''

Ako želite da koristite OpenID za buduće prijave, možete [[Special:OpenIDConvert|promijeniti Vaš račun za upotrebu OpenID]].",
	'openidnousername' => 'Nije navedeno korisničko ime.',
	'openidbadusername' => 'Navedeno loše korisničko ime.',
	'openidautosubmit' => 'Ova stranica uključuje obrazac koji bi se trebao automatski poslati ako je kod Vas omogućena JavaScript. Ako nije, pokušajte nastaviti dalje putem dugmeta "Continue".',
	'openidclientonlytext' => 'Ne možete koristiti račune sa ove wiki kao OpenID na drugom sajtu.',
	'openidloginlabel' => 'OpenID URL adresa',
	'openidlogininstructions' => '{{SITENAME}} podržava [http://openid.net/ OpenID] standard za jedinstvenu prijavu između web sajtova.
OpenID omogućuje da se prijavite na mnoge različite web stranice bez korištenja različitih šifri za svaku od njih.
(Pogledajte [http://en.wikipedia.org/wiki/OpenID članak na Wikipediji o OpenID-u] za više informacija.)

Ako već imate račun na {{SITENAME}}, možete se [[Special:UserLogin|prijaviti]] sa vašim korisničkim imenom i šifrom kao i uvijek.
Da bi koristili OpenID u buduće, možete [[Special:OpenIDConvert|pretvoriti vaš račun u OpenID]] nakon što se normalno prijavite.

Postoji mnogo [http://wiki.openid.net/Public_OpenID_providers javnih provajdera za OpenID], i možda već imate neki račun na drugom servisu koji podržava OpenID.',
	'openidupdateuserinfo' => 'Ažuriraj moje lične informacije:',
	'openiddelete' => 'Obriši OpenID',
	'openiddelete-text' => 'Klikanjem na dugme "{{int:openiddelete-button}}" uklonićete OpenID $1 sa vašeg računa.
Nećete više biti u mogućnosti da se prijavite s ovim OpenID.',
	'openiddelete-button' => 'Potvrdi',
	'openiddeleteerrornopassword' => 'Ne možete obrisati sve vaše OpenID jer vaš račun nema šifre.
Neće se moći prijaviti bez OpenID.',
	'openiddeleteerroropenidonly' => 'Ne možete obrisati sve vaše OpenID jer vam je omogućeno da se prijavite samo sa OpenID.
Bez OpenId nećete moći da se prijavite.',
	'openiddelete-sucess' => 'OpenID je uspješno uklonjen sa vašeg računa.',
	'openiddelete-error' => 'Desila se greška pri uklanjanju OpenID sa vašeg računa.',
	'openid-prefstext' => '[http://openid.net/ OpenID] postavke',
	'openid-pref-hide' => 'Sakrij Vaš OpenID na Vašoj korisničkoj stranici, ako ste prijavljeni sa OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Ažuriraj slijedeće informacije sa OpenID identiteta svaki put kad se prijavim:',
	'openid-urls-desc' => 'OpenIDovi pridruženi vašem računu:',
	'openid-urls-action' => 'Akcija',
	'openid-urls-delete' => 'Obriši',
	'openid-add-url' => 'Dodaj novi OpenID',
	'openidsigninorcreateaccount' => 'Prijavite se ili napravite novi račun',
	'openid-provider-label-openid' => 'Unesite Vaš OpenID URL',
	'openid-provider-label-google' => 'Prijava putem Vašeg Google računa',
	'openid-provider-label-yahoo' => 'Prijava putem Vašeg Yahoo računa',
	'openid-provider-label-aol' => 'Unesite svoj AOL nadimak',
	'openid-provider-label-other-username' => 'Unesite Vaše $1 korisničko ime',
);

/** Catalan (Català)
 * @author SMP
 * @author Solde
 * @author Toniher
 */
$messages['ca'] = array(
	'openid-desc' => 'Inicieu una sessió al wiki amb un [http://openid.net/ OpenID], i inicieu una sessió a qualsevol lloc web compatible amb OpenID amb el vostre compte wiki',
	'openidlogin' => 'Inicia una sessió amb OpenID',
	'openidserver' => 'Servidor OpenID',
	'openidxrds' => 'Fitxer Yadis',
	'openidconvert' => 'Conversor OpenID',
	'openiderror' => 'Error de verificació',
	'openidfailure' => 'Verificació fallida',
	'openidusernameprefix' => 'Usuari OpenID',
	'openidoptional' => 'Opcional',
	'openidrequired' => 'Requerit',
	'openidnickname' => 'Sobrenom',
	'openidfullname' => 'Nom complet',
	'openidemail' => 'Adreça de correu electrònic',
	'openidlanguage' => 'Idioma',
	'openidtimezone' => 'Zona horaria',
	'openidchooseinstructions' => 'Tots els usuaris cal que tinguin un sobrenom;
podeu triar-ne un de les opcions a continuació.',
	'openidchoosefull' => 'El vostre nom complet ($1)',
	'openidchooseexisting' => 'Un compte existent en aquest wiki:',
	'openidchoosepassword' => 'contrasenya:',
	'openid-urls-action' => 'Acció',
	'openid-urls-delete' => 'Elimina',
	'openid-provider-label-other-username' => "Introduïu el vostre $1 nom d'usuari",
);

/** Czech (Česky)
 * @author Kuvaly
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'openid-desc' => 'Přihlašování se na wiki pomocí [http://openid.net/ OpenID] a přihlašování se na jiné stránky podporující OpenID pomocí uživatelského účtu z wiki',
	'openidlogin' => 'Přihlášení pomocí OpenID',
	'openidserver' => 'OpenID server',
	'openidxrds' => 'Soubor Yadis',
	'openidconvert' => 'OpenID konvertor',
	'openiderror' => 'Chyba při ověřování',
	'openiderrortext' => 'Při ověřování URL OpenID se vyskytla chyba.',
	'openidconfigerror' => 'Chyba konfigurace OpenID',
	'openidconfigerrortext' => 'Konfigurace OpenID této wiki je neplatná.
Prosím, poraďte se se [[Special:ListUsers/sysop|správcem]].',
	'openidpermission' => 'Chyba oprávnění OpenID',
	'openidpermissiontext' => 'OpenID, který jste poskytli, nemá oprávnění příhlásit se k tomuto serveru.',
	'openidcancel' => 'Ověřování bylo zrušeno',
	'openidcanceltext' => 'Ověřování URL OpenID bylo zrušeno.',
	'openidfailure' => 'Ověřování zrušeno',
	'openidfailuretext' => 'Ověřování URL OpenID selhalo. Chybová zpráva: „$1“',
	'openidsuccess' => 'Ověřování bylo úspěšné',
	'openidsuccesstext' => 'Ověření URL OpenID bylo úspěšné.',
	'openidusernameprefix' => 'Uživatel OpenID',
	'openidserverlogininstructions' => 'Do formuláře níže zadejte heslo pro přihlášení na $3 jako uživatel $2 (uživatelská stránka $1).',
	'openidtrustinstructions' => 'Zkontrolujte, jestli chcete sdílet data s uživatelem $1.',
	'openidallowtrust' => 'Povolit $1 důvěřovat tomuto uživatelskému účtu.',
	'openidnopolicy' => 'Lokalita nespecifikovala pravidla ochrany osobních údajů.',
	'openidpolicy' => 'Více informací na stránce <a target="_new" href="$1">Ochrana osobních údajoů</a>.',
	'openidoptional' => 'Volitelné',
	'openidrequired' => 'Požadované',
	'openidnickname' => 'Přezdívka',
	'openidfullname' => 'Celé jméno',
	'openidemail' => 'E-mailová adresa:',
	'openidlanguage' => 'Jazyk',
	'openidtimezone' => 'Časové pásmo',
	'openidchooseinstructions' => 'Kyždý uživatel musí mít přezdívku; můžete si vybrat z níže uvedených možností.',
	'openidchoosefull' => 'Vaše celé jméno ($1)',
	'openidchooseurl' => 'Jméno na základě vašeho OpenID ($1)',
	'openidchooseauto' => 'Automaticky vytvořené jméno ($1)',
	'openidchoosemanual' => 'Jméno, které si vyberete:',
	'openidchooseexisting' => 'Existující účet na této wiki',
	'openidchoosepassword' => 'heslo:',
	'openidconvertinstructions' => 'Tento formulář vám umožňuje změnit váš učet, aby používal OpenID URL, nebo přidat více URL OpenID.',
	'openidconvertoraddmoreids' => 'Převést na OpenID nebo přidat jinou OpenID URL',
	'openidconvertsuccess' => 'Úspěšně převedeno na OpenID',
	'openidconvertsuccesstext' => 'Úspěšně jste převedli váš OpenID na $1.',
	'openidconvertyourstext' => 'To už je váš OpenID.',
	'openidconvertothertext' => 'To je OpenID někoho jiného.',
	'openidalreadyloggedin' => "'''Už jste přihlášený, $1!'''

Pokud chcete pro přihlašování v budoucnu používat OpenID, můžete [[Special:OpenIDConvert|převést váš účet na OpenID]].",
	'openidnousername' => 'Nebylo zadáno uživatelské jméno.',
	'openidbadusername' => 'Bylo zadáno chybné uživatelské jméno.',
	'openidautosubmit' => 'Tato stránka obsahuje formulář, který by měl být automaticky odeslán pokud máte zapnutý JavaScript.
Pokud ne, zkuste tlačátko „Continue“ (Pokračovat).',
	'openidclientonlytext' => 'Nemůžete používat účty z této wiki jako OpenID na jinýh webech.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => '{{SITENAME}} podporuje standard [http://openid.net/ OpenID] pro sjednocené přihlašování na webové stránky.
OpenID vám umožňuje přihlašovat se na množství různých webových stránek bez nutnosti používat pro každou jiné heslo.
(Více informací se dočtete v [http://en.wikipedia.org/wiki/OpenID článku o OpenID na Wikipedii].)

Pokud už máte na {{GRAMMAR:6sg|{{SITENAME}}}} účet, můžete se [[Special:UserLogin|přihlásit]] pomocí uživatelského jména a hesla jako obvykle.
Pokud chcete v budoucnosti používat OpenID, můžete po normálním přihlášení [[Special:OpenIDConvert|převést svůj účet na OpenID]].

Existuje množství [http://openid.net/get/ poskytovatelů OpenID], možná už také máte účet s podporou OpenID v rámci jiné služby.',
	'openidupdateuserinfo' => 'Aktualizovat moje osobní informace:',
	'openiddelete' => 'Smazat OpenID',
	'openiddelete-text' => 'Kliknutím na tlačítko „{{int:openiddelete-button}}“ odstraníte OpenID $1 z vašeho účtu.
Nebudete se již moci tímto OpenID přihlasít.',
	'openiddelete-button' => 'Potvrdit',
	'openiddelete-sucess' => 'OpenID bylo úspěšně odstraněno z vašeho účtu.',
	'openiddelete-error' => 'Během odstraňování OpenID z vašeho účtu se vyskytla chyba.',
	'openid-prefstext' => 'Nastavení [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Nezobrazovat váš OpenID na vaší uživatelské stránce pokud se přihlašujete pomocí OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Aktualizovat následující informace z OpenID identity vždy, když se přihlásím:',
	'openid-urls-desc' => 'OpenID asociovaná s vaším účtem:',
	'openid-urls-action' => 'Operace',
	'openid-urls-delete' => 'Smazat',
	'openid-add-url' => 'Přidat nové OpenID',
	'openidsigninorcreateaccount' => 'Přihlásit se nebo vytvořit nový účet',
	'openid-provider-label-openid' => 'Zadejte URL svého OpenID',
	'openid-provider-label-google' => 'Přihlásit se pomocí Google účtu',
	'openid-provider-label-yahoo' => 'Přihlásit se pomocí Yahoo účtu',
	'openid-provider-label-aol' => 'Přihlásit se pomocí AOL účtu',
	'openid-provider-label-other-username' => 'Zadejte svoje uživatelské jméno pro $1',
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
	'openidnickname' => 'Kaldenavn',
	'openidlanguage' => 'Sprog',
	'openidchoosepassword' => 'adgangskode:',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Church of emacs
 * @author DaSch
 * @author Leithian
 * @author Tbleher
 * @author Umherirrender
 */
$messages['de'] = array(
	'openid-desc' => 'Anmeldung an dieses Wiki mit einer [http://openid.net/ OpenID] und anmelden an anderen Websites, die OpenID unterstützen, mit einem Wiki-Benutzerkonto.',
	'openidlogin' => 'Anmelden mit OpenID',
	'openidserver' => 'OpenID-Server',
	'openidxrds' => 'Yadis-Datei',
	'openidconvert' => 'OpenID-Konverter',
	'openiderror' => 'Überprüfungsfehler',
	'openiderrortext' => 'Ein Fehler ist während der Überprüfung der OpenID-URL aufgetreten.',
	'openidconfigerror' => 'OpenID-Konfigurationsfehler',
	'openidconfigerrortext' => 'Die OpenID-Speicherkonfiguarion für dieses Wiki ist fehlerhaft.
Bitte benachrichtige einen [[Special:ListUsers/sysop|Administrator]].',
	'openidpermission' => 'OpenID-Berechtigungsfehler',
	'openidpermissiontext' => 'Die angegebene OpenID berechtigt nicht zur Anmeldung an diesem Server.',
	'openidcancel' => 'Überprüfung abgebrochen',
	'openidcanceltext' => 'Die Überprüfung der OpenID-URL wurde abgebrochen.',
	'openidfailure' => 'Überprüfungsfehler',
	'openidfailuretext' => 'Die Überprüfung der OpenID-URL ist fehlgeschlagen. Fehlermeldung: „$1“',
	'openidsuccess' => 'Überprüfung erfolgreich beendet',
	'openidsuccesstext' => 'Die Überprüfung der OpenID-URL war erfolgreich.',
	'openidusernameprefix' => 'OpenID-Benutzer',
	'openidserverlogininstructions' => 'Gib dein Passwort unten ein, um dich als Benutzer $2 an $3 anzumelden (Benutzerseite $1).',
	'openidtrustinstructions' => 'Prüfe, ob du Daten mit $1 teilen möchtest.',
	'openidallowtrust' => 'Erlaube $1, diesem Benutzerkonto zu vertrauen.',
	'openidnopolicy' => 'Die Seite hat keine Datenschutzrichtlinie angegeben.',
	'openidpolicy' => 'Prüfe die <a target="_new" href="$1">Datenschutzrichtlinie</a> für weitere Informationen.',
	'openidoptional' => 'Optional',
	'openidrequired' => 'Pflicht',
	'openidnickname' => 'Benutzername',
	'openidfullname' => 'Vollständiger Name',
	'openidemail' => 'E-Mail-Adresse:',
	'openidlanguage' => 'Sprache',
	'openidtimezone' => 'Zeitzone',
	'openidchooseinstructions' => 'Alle Benutzer benötigen einen Benutzernamen;
du kannst einen aus der untenstehenden Liste auswählen.',
	'openidchoosenick' => 'Dein Spitzname ($1)',
	'openidchoosefull' => 'Dein vollständiger Name ($1)',
	'openidchooseurl' => 'Ein Name aus deiner OpenID ($1)',
	'openidchooseauto' => 'Ein automatisch erzeugter Name ($1)',
	'openidchoosemanual' => 'Ein Name deiner Wahl:',
	'openidchooseexisting' => 'Ein existierendes Benutzerkonto in diesem Wiki',
	'openidchooseusername' => 'Benutzername:',
	'openidchoosepassword' => 'Passwort:',
	'openidconvertinstructions' => 'Mit diesem Formular kannst du dein Benutzerkonto zur Benutzung einer OpenID-URL freigeben oder eine weitere OpenID-URL hinzufügen',
	'openidconvertoraddmoreids' => 'Zu OpenID konvertieren oder eine andere OpenID-URL hinzufügen',
	'openidconvertsuccess' => 'Erfolgreich nach OpenID konvertiert',
	'openidconvertsuccesstext' => 'Du hast die Konvertierung deiner OpenID nach $1 erfolgreich durchgeführt.',
	'openidconvertyourstext' => 'Dies ist bereits deine OpenID.',
	'openidconvertothertext' => 'Dies ist die OpenID von jemand anderem.',
	'openidalreadyloggedin' => "'''Du bist bereits angemeldet, $1!'''

Wenn du OpenID für künftige Anmeldevorgänge nutzen möchtest, kannst du [[Special:OpenIDConvert|dein Benutzerkonto nach OpenID konvertieren]].",
	'openidnousername' => 'Kein Benutzername angegeben.',
	'openidbadusername' => 'Falscher Benutzername angegeben.',
	'openidautosubmit' => 'Diese Seite enthält ein Formular, das automatisch übertragen wird, wenn JavaSkript aktiviert ist. Falls nicht, klicke bitte auf „Continue“ (Weiter).',
	'openidclientonlytext' => 'Du kannst keine Benutzerkonten aus diesem Wiki als OpenID für andere Seiten verwenden.',
	'openidloginlabel' => 'OpenID-URL',
	'openidlogininstructions' => '{{SITENAME}} unterstützt den [http://openid.net/ OpenID]-Standard für eine einheitliche Anmeldung für mehrere Websites.
OpenID meldet dich bei vielen unterschiedlichen Webseiten an, ohne dass du für jede ein anderes Passwort verwenden musst.
(Mehr Informationen bietet der [http://de.wikipedia.org/wiki/OpenID Wikipedia-Artikel zu OpenID].)

Falls du bereits ein Benutzerkonto bei {{SITENAME}} hast, kannst du dich ganz normal mit Benutzername und Passwort [[Special:UserLogin|anmelden]].
Wenn du in Zukunft OpenID verwenden möchtest, kannst du [[Special:OpenIDConvert|dein Benutzerkonto zu OpenID konvertieren]], nachdem du dich normal angemeldet hast.

Es gibt viele [http://openid.net/get/ OpenID-Provider] und möglicherweise hast du bereits ein Benutzerkonto mit aktiviertem OpenID bei einem anderen Anbieter.',
	'openidupdateuserinfo' => 'Persönliche Daten aktualisieren:',
	'openiddelete' => 'OpenID löschen',
	'openiddelete-text' => 'Wenn du auf den Button „{{int:openiddelete-button}}“ klickst, löschst du die OpenID $1 von deinem Benutzerkonto.
Du wirst dich nicht mehr mit dieser OpenID anmelden können.',
	'openiddelete-button' => 'Bestätigen',
	'openiddeleteerrornopassword' => 'Du kannst nicht alle deine OpenIDs löschen, da du kein Passwort gesetzt hast.
Ohne OpenID könntest du dich nicht mehr anmelden.',
	'openiddelete-sucess' => 'Die OpenID wurde erfolgreich von deinem Benutzerkonto entfernt.',
	'openiddelete-error' => 'Beim Entfernen der OpenID von deinem Benutzerkonto ist ein Fehler aufgetreten.',
	'openid-prefstext' => '[http://openid.net/ OpenID]-Einstellungen',
	'openid-pref-hide' => 'Verstecke deine OpenID auf deiner Benutzerseite, wenn du dich mit OpenID anmeldest.',
	'openid-pref-update-userinfo-on-login' => 'Nachfolgende Daten anhand des OpenID-Kontos bei jeder Anmeldung aktualisieren:',
	'openid-urls-desc' => 'Mit deinem Benutzerkonto verbundene OpenIDs:',
	'openid-urls-action' => 'Aktion',
	'openid-urls-delete' => 'Löschen',
	'openid-add-url' => 'Eine neue OpenID hinzufügen',
	'openidsigninorcreateaccount' => 'Anmelden oder ein neues Benutzerkonto erstellen',
	'openid-provider-label-openid' => 'Gib deine OpenID-URL an',
	'openid-provider-label-google' => 'Mit deinem Google-Benutzerkonto anmelden',
	'openid-provider-label-yahoo' => 'Mit deinem Yahoo-Benutzerkonto anmelden',
	'openid-provider-label-aol' => 'Gib deinen AOL-Namen an',
	'openid-provider-label-other-username' => 'Gib deinen „$1“-Benutzernamen an',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author ChrisiPK
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'openidconfigerrortext' => 'Die OpenID-Speicherkonfiguarion für dieses Wiki ist fehlerhaft.
Bitte benachrichtigen Sie einen [[Special:ListUsers/sysop|Administrator]].',
	'openidserverlogininstructions' => 'Geben Sie Ihr Passwort unten ein, um sich als Benutzer $2 an $3 anzumelden (Benutzerseite $1).',
	'openidtrustinstructions' => 'Prüfen Sie, ob Sie Daten mit $1 teilen möchten.',
	'openidchooseinstructions' => 'Alle Benutzer benötigen einen Benutzernamen;
Sie können einen aus der untenstehenden Liste auswählen.',
	'openidchoosefull' => 'Ihr vollständiger Name ($1)',
	'openidchooseurl' => 'Ein Name aus Ihrer OpenID ($1)',
	'openidchoosemanual' => 'Ein Name Ihrer Wahl:',
	'openidconvertinstructions' => 'Mit diesem Formular können Sie Ihr Benutzerkonto zur Benutzung einer OpenID-URL freigeben oder eine weitere OpenID-URL hinzufügen',
	'openidconvertsuccesstext' => 'Sie haben die Konvertierung Ihrer OpenID nach $1 erfolgreich durchgeführt.',
	'openidconvertyourstext' => 'Dies ist bereits Ihre OpenID.',
	'openidalreadyloggedin' => "'''Sie sind bereits angemeldet, $1!'''

Wenn Sie OpenID für künftige Anmeldevorgänge nutzen möchten, können Sie [[Special:OpenIDConvert|Ihr Benutzerkonto nach OpenID konvertieren]].",
	'openidautosubmit' => 'Diese Seite enthält ein Formular, das automatisch übertragen wird, wenn JavaSkript aktiviert ist. Falls nicht, klicken Sie bitte auf „Continue“ (Weiter).',
	'openidclientonlytext' => 'Sie können keine Benutzerkonten aus diesem Wiki als OpenID für andere Seiten verwenden.',
	'openidlogininstructions' => '{{SITENAME}} unterstützt den [http://openid.net/ OpenID]-Standard für eine einheitliche Anmeldung für mehrere Websites.
OpenID meldet Sie bei vielen unterschiedlichen Webseiten an, ohne dass Sie für jede ein anderes Passwort verwenden müssen.
(Mehr Informationen bietet der [http://de.wikipedia.org/wiki/OpenID Wikipedia-Artikel zu OpenID].)

Falls Sie bereits ein Benutzerkonto bei {{SITENAME}} haben, können Sie sich ganz normal mit Benutzername und Passwort [[Special:UserLogin|anmelden]].
Wenn Sie in Zukunft OpenID verwenden möchten, können Sie [[Special:OpenIDConvert|Ihr Benutzerkonto zu OpenID konvertieren]], nachdem Sie sich normal angemeldet haben.

Es gibt viele [http://openid.net/get/ OpenID-Provider] und möglicherweise haben Sie bereits ein Benutzerkonto mit aktiviertem OpenID bei einem anderen Anbieter.',
	'openiddelete-text' => 'Wenn Sie auf den Button „{{int:openiddelete-button}}“ klicken, löschen Sie die OpenID $1 von Ihrem Benutzerkonto.
Sie werden sich nicht mehr mit dieser OpenID anmelden können.',
	'openiddelete-sucess' => 'Die OpenID wurde erfolgreich von Ihrem Benutzerkonto entfernt.',
	'openiddelete-error' => 'Beim Entfernen der OpenID von Ihrem Benutzerkonto ist ein Fehler aufgetreten.',
	'openid-pref-hide' => 'Verstecken Sie Ihre OpenID auf Ihrer Benutzerseite, wenn Sie sich mit OpenID anmelden.',
	'openid-urls-desc' => 'Mit Ihrem Benutzerkonto verbundene OpenIDs:',
	'openid-provider-label-openid' => 'Geben Sie Ihre OpenID-URL an',
	'openid-provider-label-google' => 'Mit Ihrem Google-Benutzerkonto anmelden',
	'openid-provider-label-yahoo' => 'Mit Ihrem Yahoo-Benutzerkonto anmelden',
	'openid-provider-label-aol' => 'Geben Sie Ihren AOL-Namen an',
	'openid-provider-label-other-username' => 'Geben Sie Ihren „$1“-Benutzernamen an',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 */
$messages['diq'] = array(
	'openidlanguage' => 'Zıwan',
	'openidtimezone' => 'Warey saete',
	'openidchoosepassword' => 'parola:',
	'openiddelete-button' => 'Tesdiq',
	'openid-urls-delete' => 'Bıestere',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'openid-desc' => 'Pśizjawjenje pla wikija z [http://openid.net/ OpenID] a pśizjawjenje pla drugich websedłow, kótarež pódpěraju OpenID z wikijowym wužywarskim kontom',
	'openidlogin' => 'Pśizjawjenje z OpenID',
	'openidserver' => 'Serwer OpenID',
	'openidxrds' => 'Yadis-dataja',
	'openidconvert' => 'Konwerter OpenID',
	'openiderror' => 'Pśeglědańska zmólka',
	'openiderrortext' => 'Zmólka jo nastała pśi pśeglědowanju URL OpenID.',
	'openidconfigerror' => 'Konfiguraciska zmólka OpenID',
	'openidconfigerrortext' => 'Konfiguracija składowaka OpenID za toś ten wiki jo njepłaśiwy.
Pšosym staj se z [[Special:ListUsers/sysop|administratorom]] do zwiska.',
	'openidpermission' => 'Zmólka pšawow OpenID',
	'openidpermissiontext' => 'OpenID, kótaryž sy pódał, njedowólujo pśizjawjenje pla toś togo serwera.',
	'openidcancel' => 'Pśeglědanje pśetergnjone',
	'openidcanceltext' => 'Pśeglědanje URL OpenID jo se pśetergnuło.',
	'openidfailure' => 'Pséglědanje jo se njeraźiło',
	'openidfailuretext' => 'Pśeglědanje URL OpenID je so njeraźiło. Zmólkowa powěźeńka: "$1"',
	'openidsuccess' => 'Pśeglědanje wuspěšne',
	'openidsuccesstext' => 'Pśeglědanje URL OpenID jo wuspěšnje było.',
	'openidusernameprefix' => 'Wužywaŕ OpenID',
	'openidserverlogininstructions' => 'Zapódaj swójo gronidło dołojce, aby se ako wužywaŕ $2 pla $3 pśizjawił (wužywarski bok $1).',
	'openidtrustinstructions' => 'Kontrolěruj, lěc coš daty z $1 źěliś.',
	'openidallowtrust' => '$1 dowóliś, toś tomu wužywarskemu kontoju dowěriś.',
	'openidnopolicy' => 'Sedło njejo pódało zasady priwatnosći.',
	'openidpolicy' => 'Kontrolěruj <a target="_new" href="$1">zasady priwatnosći</a> za dalšne informacije.',
	'openidoptional' => 'Opcionalny',
	'openidrequired' => 'Trěbny',
	'openidnickname' => 'Pśimě',
	'openidfullname' => 'Dopołne mě',
	'openidemail' => 'E-mailowa adresa:',
	'openidlanguage' => 'Rěc',
	'openidtimezone' => 'Casowa cona',
	'openidchooselegend' => 'Wuběr wužywarskich mjenjow',
	'openidchooseinstructions' => 'Wše wužywarje trjebaju pśimě;
móžoš jadno ze slědujucych opcijow wubraś.',
	'openidchoosenick' => 'Twójo pśimě ($1)',
	'openidchoosefull' => 'Twójo dopołne mě ($1)',
	'openidchooseurl' => 'Mě z twójogo OpenID ($1)',
	'openidchooseauto' => 'Awtomatiski napórane mě ($1)',
	'openidchoosemanual' => 'Mě twójogo wuzwólenja:',
	'openidchooseexisting' => 'Eksistěrujuce konto w toś tom wikiju',
	'openidchooseusername' => 'wužywarske mě:',
	'openidchoosepassword' => 'gronidło:',
	'openidconvertinstructions' => 'Z toś tym formularom móžoš swójo wužywarske konto změniś, aby wužywało URL OpenID abo dalšnje URL OpenID pśidał.',
	'openidconvertoraddmoreids' => 'Do OpenID konwertěrowaś abo dalšny URL OpenID pśidaś',
	'openidconvertsuccess' => 'Wuspěšnje do OpenID konwertěrowany',
	'openidconvertsuccesstext' => 'Sy wuspěšnje konwertěrował twój OpenID do $1.',
	'openidconvertyourstext' => 'To jo južo twój OpenID.',
	'openidconvertothertext' => 'Toś ten OpenID słuša někomu drugemu.',
	'openidalreadyloggedin' => "'''Sy južo pśizjawjony, $1!'''

Jolic pśichodnje coš OpenID wužywaś, aby se pśizjawił, móžoš [[Special:OpenIDConvert|swójo konto za wužiwanje OpenID konwertěrowaś]].",
	'openidnousername' => 'Žedne wužywarske mě pódane.',
	'openidbadusername' => 'Wopacne wužywarske mě pódane.',
	'openidautosubmit' => 'Toś ten bok wopśimujo formular, kótaryž se awtmatiski wótpósćeła, jolic JavaScript jo zmóžnjony. Jolic nic, klikni na tłocašk "Continue" (Dalej).',
	'openidclientonlytext' => 'Njamóžoš konta z toś togo wikija ako OpneID na drugem sedle wužywaś.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => '{{SITENAME}} pódpěra standard [http://openid.net/ OpenID] za jadnotliwe pśizjawjenja mjazy websedłami.
OpenID śi zmóžnja se pla rozdźělnych websedłow pśizjawiś, bźez togo až musyš rozdźělne gronidła wužywaś.
(Glědaj [http://en.wikipedia.org/wiki/OpenID nastawk OpenID we Wikipediji] za dalšne informacije.)

Jolic maš južo konto na {{GRAMMAR:lokatiw|{{SITENAME}}}}, móžoš se ze swójim wužywarskim mjenim a gronidłom ako pśecej [[Special:UserLogin|pśizjawiś]].
Aby wužywał OpenID w pśichoźe, móžoš [[Special:OpenIDConvert|swójo konto do OpenID konwertěrowaś]], za tym až sy se normalnje pśizjawił.

Jo wjele [http://openid.net/get/ póbitowarjow OpenID] a snaź maš južo konto z OpenID pla drugeje słužby.',
	'openidupdateuserinfo' => 'Móje wósobinske informacije aktualizěrowaś:',
	'openiddelete' => 'OpenID wulašowaś',
	'openiddelete-text' => 'Pśez kliknjenje na tłócašk "{{int:openiddelete-button}}", wótpórajoš OpenID $1 z twójogo konta. Njamóžoš se wěcej z toś tym OpenID pśizjawiś.',
	'openiddelete-button' => 'Wobkšuśiś',
	'openiddeleteerrornopassword' => 'Njamóžoš wše swóje OpenID lašowaś, dokulaž twójo konto njama gronidło.
Ty njeby mógał se bźez OpenID pśizjawiś.',
	'openiddeleteerroropenidonly' => 'Njamóžoš wše swóje OpenID lašowaś, dokulaž njesmějoš se z OpenID pśizjawiś.
Ty njeby se bźez OpenID pśizjawiś.',
	'openiddelete-sucess' => 'OpenID jo se wuspěšnje z twójogo konta wótpórał.',
	'openiddelete-error' => 'Pśi wótwónoźowanju OpenID z twójogo konta jo zmólka jo nastata.',
	'openid-prefstext' => 'Nastajenja [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Schowaj swój OpenID na swójom wužywarskem boku, jolic se pśizjawjaś z OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Kuždy raz, gaž se pízjawjam, slědujuce informacije z identity OpenID aktualizěrowaś:',
	'openid-urls-desc' => 'OpenID, kótarež su z twójim kontom zwězane:',
	'openid-urls-action' => 'Akcija',
	'openid-urls-delete' => 'Lašowaś',
	'openid-add-url' => 'Nowy OpenID pśidaś',
	'openidsigninorcreateaccount' => 'Pśizjawiś se abo nowe konto załožyś',
	'openid-provider-label-openid' => 'Zapódaj swój URL OpenID',
	'openid-provider-label-google' => 'Z pomocu twójogo konta Google se pśizjawiś',
	'openid-provider-label-yahoo' => 'Z pomocu twójogo konta Yahoo se pśizjawiś',
	'openid-provider-label-aol' => 'Zapódaj swójo wužywarske mě AOL',
	'openid-provider-label-other-username' => 'Zapódaj swójo wužywarske mě $1',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'openid-desc' => 'Συνδεθείτε στο wiki με ένα [http://openid.net/ OpenID], και συνδεθείτε σε άλλους ιστοτόπους που λαμβάνουν υπόψη το OpenID με ένα λογαριασμό χρήστη wiki',
	'openidlogin' => 'Σύνδεση με OpenID',
	'openidserver' => 'Εξυπηρετητής OpenID',
	'openidxrds' => 'Αρχείο Yadis.',
	'openidconvert' => 'Μετατροπέας OpenID',
	'openiderror' => 'Σφάλμα επαλήθευσης',
	'openiderrortext' => 'Προέκυψε ένα σφάλμα κατά τη διάρκεια της επιβεβαίωσης του OpenID URL σας.',
	'openidconfigerror' => 'Σφάλμα διαμόρφωσης OpenID',
	'openidconfigerrortext' => 'Η διαμόρφωση αποθήκευσης OpenID για αυτό το wiki είναι μη έγκυρη.
Παρακαλώ συμβουλευθείτε έναν [[Special:ListUsers/sysop|διαχειριστή]].',
	'openidpermission' => 'Σφάλμα αδειών OpenID',
	'openidpermissiontext' => 'Το OpenID που παρείχες δεν είναι επιτρεπτό να συνδεθεί σε αυτόν τον εξυπηρετητή.',
	'openidcancel' => 'Η επαλήθευση ακυρώθηκε',
	'openidcanceltext' => 'Η επιβεβαίωση του OpenID URL ακυρώθηκε.',
	'openidfailure' => 'Η επαλήθευση απέτυχε',
	'openidfailuretext' => 'Η επιβεβαίωση του OpenID URL απέτυχε. Μήνυμα σφάλματος: "$1"',
	'openidsuccess' => 'Η επαλήθευση ήταν επιτυχής',
	'openidsuccesstext' => 'Η επιβεβαίωση του OpenID URL ήταν επιτυχής.',
	'openidusernameprefix' => 'Χρήστης OpenID',
	'openidserverlogininstructions' => 'Βάλτε τον κωδικό σας παρακάτω για να συνδεθείτε στο $3 ως χρήστης $2 (σελίδα χρήστη $1).',
	'openidtrustinstructions' => 'Τσεκάρετε αν θέλετε να μοιραστείτε δεδομένα με το $1.',
	'openidallowtrust' => 'Επέτρεψε στο $1 να εμπιστευτεί αυτό το λογαριασμό χρήστη.',
	'openidnopolicy' => 'Ο ιστοτόπος δεν έχει καθορίσει μια πολιτική ιδιωτικότητας.',
	'openidpolicy' => 'Ελέγξατε <a target="_new" href="$1">πολιτική διακριτικότητας</a> για περισσότερες πληροφορίες.',
	'openidoptional' => 'Προαιρετικός',
	'openidrequired' => 'Απαιτημένος',
	'openidnickname' => 'Παρωνύμιο',
	'openidfullname' => 'ονοματεπώνυμο',
	'openidemail' => 'Διεύθυνση ηλεκτρονικού ταχυδρομείου',
	'openidlanguage' => 'Γλώσσα',
	'openidtimezone' => 'Ζώνη ώρας:',
	'openidchooseinstructions' => 'Όλοι οι χρήστες χρειάζονται ένα nickname,
για να επιλέξετε μια από τις παρακάτω επιλογές.',
	'openidchoosefull' => 'Το πλήρες όνομά σας ($1)',
	'openidchooseurl' => 'Ένα όνομα διαλεγμένο από το OpenID σας ($1)',
	'openidchooseauto' => 'Ένα αυτο-δημιουργημένο όνομα ($1)',
	'openidchoosemanual' => 'Ένα όνομα της επιλογής σας:',
	'openidchooseexisting' => 'Ένας υπάρχων λογαριασμός σε αυτό το βίκι:',
	'openidchoosepassword' => 'κωδικός:',
	'openidconvertinstructions' => 'Αυτή η φόρμα σας επιτρέπει να αλλάξετε το λογαριασμό χρήστη σας για να χρησιμοποιήσετε ένα ή περισσόττερα URL OpenID',
	'openidconvertoraddmoreids' => 'Μετατρέψτε το OpenID ή προσθέστε κι άλλο URL OpenID',
	'openidconvertsuccess' => 'Μετατράπηκε επιτυχώς σε OpenID',
	'openidconvertsuccesstext' => 'Έχετε επιτυχώς μετατρέψει το OpenID σας σε $1.',
	'openidconvertyourstext' => 'Αυτό είναι ήδη το OpenID σας.',
	'openidconvertothertext' => 'Αυτό είναι το OpenID κάποιου άλλου.',
	'openidalreadyloggedin' => "'''Έχεις ήδη συνδεθεί, $1!'''

Αν θέλεις να χρησιμοποιήσεις το OpenID για να συνδεθείς στο μέλλον, μπορείς να [[Special:OpenIDConvert|μετατρέψεις το λογαριασμό σου για να χρησιμοποιήσεις το OpenID]].",
	'openidnousername' => 'Δεν καθορίστηκε κανένα όνομα χρήστη.',
	'openidbadusername' => 'Καθορίστηκε κακό όνομα χρήστη.',
	'openidautosubmit' => 'Αυτή η σελίδα περιλαμβάνει μια φόρμα που θα πρέπει να καταχωρηθεί αυτόματα αν έχετε ενεργοποιήσει το JavaScript.
Αν όχι, πατήστε το κουμπί "Συνέχεια".',
	'openidclientonlytext' => 'Δεν μπορείτε να χρησιμοποιείτε λογαριασμούς από το βίκι σαν OpenID σε άλλη ιστοσελίδα.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => 'Ο ιστότοπος {{SITENAME}} υποστηρίζει το πρότυπο [http://openid.net/ OpenID] για μοναδικό υπογραφή μεταξύ ιστοτόπων.
Το OpenID σου επιτρέπει να συνδεθείς σε πολλούς διαφορετικούς ιστοτόπους χωρίς τη χρήση διαφορετικού κωδικού για τον καθένα.
(Δες το [http://en.wikipedia.org/wiki/OpenID άρθρο της Wikipedia για το OpenID] για περισσότερες πληροφορίες.)

Αν έχεις ήδη έναν λογαριασμό στο {{SITENAME}}, μπορείς να [[Special:UserLogin|συνδεθείς]] με το όνομα χρήστη σου και τον κωδικό σου ως συνήθως.
Για να χρησιμοποιήσεις το OpenID στο μέλλον, μπορείς να [[Special:OpenIDConvert|μετατρέψεις το λογαριασμό σου σε OpenID]] αφού έχεις συνδεθεί κανονικά.

Υπάρχουν υπερβολικά πολλοί [http://openid.net/get/ παροχείς OpenID], και μπορεί να έχεις έναν ήδη ενεργοποιημένο με OpenID λογαριασμό σε άλλη υπηρεσία.',
	'openidupdateuserinfo' => 'Ενημέρωση των προσωπικών πληροφοριών μου',
	'openiddelete' => 'Διαγραφή OpenID',
	'openiddelete-text' => 'Κάνωντας κλικ στο κουμπί "{{int:openiddelete-button}}", θα αφαιρέσετε το OpenID $1 από το λογαριασμό σας.
Δεν θα είστε πλέον σε θέση να συνδεθείτε με αυτό το OpenID.',
	'openiddelete-button' => 'Επιβεβαίωση',
	'openiddelete-sucess' => 'Το OpenID αφαιρέθηκε επιτυχώς από τον λογαριασμό σας.',
	'openiddelete-error' => 'Ένα σφάλμα προέκυψε κατά την αφαίρεση του OpenID από το λογαριασμό σας.',
	'openid-prefstext' => 'Προτιμήσεις [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Απόκρυψη του OpenID URL στη σελίδα χρήστη σας, αν συνδεθείτε με το OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Ενημέρωση των ακόλουθων πληροφοριών από το OpenID persona κάθε φορά που συνδέομαι:',
	'openid-urls-desc' => 'OpenID συνδεδεμένα με τον λογαριασμό σας:',
	'openid-urls-action' => 'Ενέργεια',
	'openid-urls-delete' => 'Διαγραφή',
	'openid-add-url' => 'Προσθέστε ένα νέο OpenID',
	'openidsigninorcreateaccount' => 'Σύνδεση ή Δημιουργία Νέου Λογαριασμού',
	'openid-provider-label-openid' => 'Εισαγωγή URL του OpenID σας',
	'openid-provider-label-google' => 'Σύνδεση χρησιμοποιώντας τον Google λογαριασμό σας',
	'openid-provider-label-yahoo' => 'Σύνδεση χρησιμοποιώντας τον Yahoo λογαριασμό σας',
	'openid-provider-label-aol' => 'Εισάγετε το AOL όνομα οθόνης σας',
	'openid-provider-label-other-username' => 'Εισαγωγή του δικού σας $1 ονόματος χρήστη',
);

/** Esperanto (Esperanto)
 * @author Lucas
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'openid-desc' => 'Ensaluti la vikion kun [http://openid.net/ identigo OpenID], kaj ensaluti aliajn retejon uzantajn OpenID kun vikia uzula konto',
	'openidlogin' => 'Ensaluti kun OpenID',
	'openidserver' => 'Servilo OpenID',
	'openidxrds' => 'dosiero Yadis',
	'openidconvert' => 'OpenID konvertilo',
	'openiderror' => 'Atestada eraro',
	'openiderrortext' => 'Eraro okazis dum atestado de la OpenID URL-o.',
	'openidconfigerror' => 'Konfigurada eraro de OpenID',
	'openidconfigerrortext' => 'La konfiguro de la OpenID-identigujo por ĉi tiu vikio estas nevalida.
Bonvolu konsulti [[Special:ListUsers/sysop|administranton]].',
	'openidpermission' => 'OpenID rajt-eraro',
	'openidpermissiontext' => 'La OpenID kiun vi provizis ne estas permesita ensaluti ĉi tiun servilon.',
	'openidcancel' => 'Atestado nuliĝis',
	'openidcanceltext' => 'Atestado de la URL-o OpenID estis nuligita.',
	'openidfailure' => 'Atestado malsukcesis',
	'openidfailuretext' => 'Atestado de la URL-o OpenID malsukcesis. Erara mesaĝo: "$1"',
	'openidsuccess' => 'Atestado sukcesis.',
	'openidsuccesstext' => 'Atestado de la OpenID URL-o sukcesis.',
	'openidusernameprefix' => 'OpenID-Uzanto',
	'openidserverlogininstructions' => 'Enigu vian pasvorton suben por ensaluti al $3 kiel uzanto $2 (uzulpaĝo $1).',
	'openidtrustinstructions' => 'Kontroli se vi volas kunpermesigi datenojn kun $1.',
	'openidallowtrust' => 'Rajtigi $1 fidi ĉi tiun uzulan konton.',
	'openidnopolicy' => 'Retejo ne specifis regularon pri privateco.',
	'openidpolicy' => 'Kontroli la <a target="_new" href="$1">regularon pri privateco</a> pri plua informo.',
	'openidoptional' => 'Nedeviga',
	'openidrequired' => 'Deviga',
	'openidnickname' => 'Kaŝnomo',
	'openidfullname' => 'Plena nomo',
	'openidemail' => 'Retadreso',
	'openidlanguage' => 'Lingvo',
	'openidtimezone' => 'Horzono',
	'openidchooseinstructions' => 'Ĉiuj uzantoj bezonas kromnomo;
vi povas selekti el unu la jenaj opcioj.',
	'openidchoosefull' => 'Via plena nomo ($1)',
	'openidchooseurl' => 'Nomo eltenita de via OpenID ($1)',
	'openidchooseauto' => 'Automate generita nomo ($1)',
	'openidchoosemanual' => 'Nomo de via elekto:',
	'openidchooseexisting' => 'Ekzistanta konto en ĉi tiu vikio:',
	'openidchoosepassword' => 'pasvorto:',
	'openidconvertinstructions' => 'Ĉi tiu paĝo permesas al vi ŝanĝi vian uzulan konton por uzi URL-on OpenID aŭ aldoni pliajn OpenID-URL-ojn.',
	'openidconvertoraddmoreids' => 'Konverti al OpenID aŭ aldoni alian OpenID-URL-on',
	'openidconvertsuccess' => 'Sukcese konvertis al OpenID',
	'openidconvertsuccesstext' => 'Vi sukcese konvertis vian identigon OpenID al $1.',
	'openidconvertyourstext' => 'Tio jam estas via OpenID.',
	'openidconvertothertext' => 'Tio estas OpenID de alia persono.',
	'openidalreadyloggedin' => "'''Vi jam ensalutis, $1!'''

Se vi volas utiligi OpenID por ensaluti estontece, vi povas [[Special:OpenIDConvert|konverti vian konton por uzi OpenID]].",
	'openidnousername' => 'Neniu salutnomo estis donita.',
	'openidbadusername' => 'Fuŝa salutnomo donita.',
	'openidautosubmit' => 'Ĉi tiu paĝo inkluzivas kamparo kiu estos aŭtomate enigita se vi havas JavaScript-on ŝaltan.
Se ne, klaku la butonon "Continue" (Daŭri).',
	'openidclientonlytext' => 'Vi ne povas uzi kontojn de ĉi tiu vikio kiel OpenID-ojn en alia retejo.',
	'openidloginlabel' => 'URL-o OpenID',
	'openidupdateuserinfo' => 'Ĝisdatigi mian personan informon',
	'openiddelete' => 'Forigi OpenID',
	'openiddelete-button' => 'Konfirmi',
	'openiddelete-sucess' => 'La OpenID estis sukcese forigita de via konto.',
	'openiddelete-error' => 'Eraro okazis dum forigado de la OpenID de via konto.',
	'openid-prefstext' => '[http://openid.net/ OpenID]-agordoj',
	'openid-pref-hide' => 'Kaŝi viajn identigon OpenID en via uzula paĝo, se vi ensalutas kun OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Ĝisdatigi mian informon de OpenID-konto ĉiam, kiam mi ensalutos:',
	'openid-urls-desc' => 'Indentigoj OpenID asociigita kun via konto:',
	'openid-urls-action' => 'Ago',
	'openid-urls-delete' => 'Forigi',
	'openid-add-url' => 'Aldoni novan OpenID',
	'openidsigninorcreateaccount' => 'Ensaluti aŭ Krei Novan Konton',
	'openid-provider-label-openid' => 'Enigi vian OpenID-URL-on',
	'openid-provider-label-google' => 'Ensaluti per via Google-konto',
	'openid-provider-label-yahoo' => 'Ensaluti per via Yahoo-konto',
	'openid-provider-label-aol' => 'Enigi vian AOL-salutnomon',
	'openid-provider-label-other-username' => 'Enigi vian salutnomon de $1',
);

/** Spanish (Español)
 * @author Ascánder
 * @author Crazymadlover
 * @author Drini
 * @author Imre
 * @author McDutchie
 * @author Sanbec
 * @author Translationista
 * @author XalD
 */
$messages['es'] = array(
	'openid-desc' => 'Ingresa a la wiki con un [http://openid.net OpenID] e ingresa a los otros sitios que aceptan OpenID con una cuenta de usuario wiki.',
	'openidlogin' => 'Conectarse con OpenID',
	'openidserver' => 'servidor OpenID',
	'openidxrds' => 'Archivo Yadis',
	'openidconvert' => 'Convertidor OpenID',
	'openiderror' => 'Error de verificación',
	'openiderrortext' => 'Un error ocurrió durante la verificación del URL OpenID.',
	'openidconfigerror' => 'Error de configuración OpenID',
	'openidconfigerrortext' => 'La configuración de almacenamiento OpenID de esta wiki es inválido.
Por favor consulte a un [[Special:ListUsers/sysop|administrador]].',
	'openidpermission' => 'Error de permiso OpenID',
	'openidpermissiontext' => 'El OpenID que indicaste no tiene permiso de ingresar a este servidor.',
	'openidcancel' => 'Verificación cancelada',
	'openidcanceltext' => 'Verificación del URL OpenID fue cancelada.',
	'openidfailure' => 'Verificación fracasada',
	'openidfailuretext' => 'Verificación del OpenID fracasó. Mensaje de error: "$1".',
	'openidsuccess' => 'Verificación fue un éxito',
	'openidsuccesstext' => 'Verificación del URL OpenID fue un éxito.',
	'openidusernameprefix' => 'OpenIDUser',
	'openidserverlogininstructions' => 'Ingresa tu password debajo para ingresar a $3 como el usuario $2 (página de usuario $1)',
	'openidtrustinstructions' => 'Verifique si usted desea compartir información con $1.',
	'openidallowtrust' => 'Permitir a $1 confiar en esta cuenta de usuario.',
	'openidnopolicy' => 'El sitio no ha especificado una política de privacidad.',
	'openidpolicy' => 'Verifique la <a target="_new" href="$1">política de privacidad</a> para mayor información.',
	'openidoptional' => 'Opcional',
	'openidrequired' => 'Necesario',
	'openidnickname' => 'Sobrenombre',
	'openidfullname' => 'Nombre completo',
	'openidemail' => 'Dirección de correo electrónico',
	'openidlanguage' => 'Idioma',
	'openidtimezone' => 'Huso horario',
	'openidchooselegend' => 'Elección del nombre de usuario',
	'openidchooseinstructions' => 'Todos los usuarios necesitan un sobrenombre;
puedes escoger uno de las opciones debajo.',
	'openidchoosenick' => 'Tu apodo ($1)',
	'openidchoosefull' => 'Su nombre completo ($1)',
	'openidchooseurl' => 'Un nombre escogido a partir de tu OpenID ($1)',
	'openidchooseauto' => 'Un nombre autogenerado ($1)',
	'openidchoosemanual' => 'Un nombre de su preferencia:',
	'openidchooseexisting' => 'Una cuenta existente en este wiki',
	'openidchooseusername' => 'nombre de usuario:',
	'openidchoosepassword' => 'contraseña:',
	'openidconvertinstructions' => 'Este formulario te permite cambiar tu cuenta de usuario para usar una URL de OpenID o agregar más URLs de OpenID.',
	'openidconvertoraddmoreids' => 'Convertir a OpenID o agregar otro URL OpenID',
	'openidconvertsuccess' => 'Convertido exitosamente a OpenID',
	'openidconvertsuccesstext' => 'Usted ha convertido exitosamente su OpenID a $1.',
	'openidconvertyourstext' => 'Esto ya es su OpenID.',
	'openidconvertothertext' => 'Esto es el OpenID de alguien más.',
	'openidalreadyloggedin' => "'''¡Ya has ingresado al sistema, $1!'''

Si quieres usar OpenID para ingresar en el futuro, puedes [[Special:OpenIDConvert|convertir tu cuenta a OpenID]].",
	'openidnousername' => 'Ningún nombre de usuario especificado.',
	'openidbadusername' => 'Nombre de usuario mal especificado.',
	'openidautosubmit' => 'Esta página incluye un formulario que será automáticamnte enviado si dispones de JavaScript.
De lo contrario, usa el botón "Continue" (Continuar).',
	'openidclientonlytext' => 'No puede usar cuentas de este wiki como OpenID en otro sitio.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => '{{SITENAME}} acepta el estándar [http://openid.net/ OpenID] para ingreso único entre múltiples sitios web.
OpenID te permite ingresar en varios sitios web sin necesidad de usar un password diferente para cada uno.
(Ver [http://es.wikipedia.org/wiki/OpenID el artículo en Wikipedia] para más información)

Si ya dispones de una cuenta en {{SITENAME}} puedes [[Special:UserLogin|ingresar]] con tu usuario y password usuales. Para usar OpenID en el futuro, puedes [[Special:OpenIDConvert|convertir tu cuenta a OpenID]] después de haber ingresado.

Hay muchos [http://openid.net/get proveedores de OpenID] y quizás ya dispongas de una cuenta OpenID en otro servicio.',
	'openidupdateuserinfo' => 'Actualizar mi información personal:',
	'openiddelete' => 'Borrar OpenID',
	'openiddelete-text' => 'Al presionar el botón "{{int:openiddelete-button}}", eliminarás el OpenID $1 de tu cuenta.
Ya no podrás conectarte más con este OpenID.',
	'openiddelete-button' => 'Confirmar',
	'openiddeleteerrornopassword' => 'No puedes borrar todos tus OpenIDs porque tu cuenta no tiene contraseña.
No podrás acceder sin un OpenID.',
	'openiddeleteerroropenidonly' => 'No puedes borrar todos tus OpenIDs porque sólo se te permite acceder con OpenID.
No podrás acceder sin un OpenID.',
	'openiddelete-sucess' => 'El OpenID fue eliminado exitosamente de tu cuenta.',
	'openiddelete-error' => 'Ocurrió un error al eliminar el OpenID de tu cuenta.',
	'openid-prefstext' => 'Preferencias de [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Ocultar su OpenID en su página de usuario, si usted ingresa con OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Actualizar la siguiente información desde mi perfil OpenID cada vez que ingreso:',
	'openid-urls-desc' => 'Los OpenID asociados con tu cuenta:',
	'openid-urls-action' => 'Acción',
	'openid-urls-delete' => 'Borrar',
	'openid-add-url' => 'Agregar un nuevo OpenID',
	'openidsigninorcreateaccount' => 'Ingresar o Crear una nueva cuenta',
	'openid-provider-label-openid' => 'Ingresar tu URL OpenID',
	'openid-provider-label-google' => 'Iniciar sesión usando tu cuenta Google',
	'openid-provider-label-yahoo' => 'Iniciar sesión usando tu cuenta Yahoo',
	'openid-provider-label-aol' => 'Ingrese su nombre screen de AOL',
	'openid-provider-label-other-username' => 'Ingresar tu nombre de usuario $1',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'openidoptional' => 'Valikuline',
	'openidrequired' => 'Nõutav',
	'openidnickname' => 'Hüüdnimi',
	'openidfullname' => 'Täisnimi',
	'openidemail' => 'E-posti aadress',
	'openidlanguage' => 'Keel',
	'openidtimezone' => 'Ajavöönd',
	'openidchoosefull' => 'Sinu täisnimi ($1)',
	'openidchoosemanual' => 'Sinu valitud nimi:',
	'openidchooseexisting' => 'Olemasolev konto siin vikis:',
	'openidchoosepassword' => 'parool:',
	'openidconvertyourstext' => 'See on juba Sinu avatud ID.',
	'openidconvertothertext' => 'See on kellegi teise avatud ID.',
	'openidalreadyloggedin' => "'''Sa oled juba sisse logitud, $1!'''

Kui soovid kasutada avatud ID-d tulevikus sisselogimiseks, võid [[Special:OpenIDConvert|konvertida oma konto, kasutamaks avatud ID-d]].",
	'openidnousername' => 'Kasutajanimi määratlemata.',
	'openidbadusername' => 'Märgitud kasutajanimi on vigane.',
	'openiddelete-button' => 'Kinnita',
	'openid-urls-delete' => 'Kustuta',
	'openid-provider-label-google' => "Logi sisse oma Google'i konto kaudu",
	'openid-provider-label-yahoo' => 'Logi sisse oma Yahoo konto kaudu',
);

/** Basque (Euskara)
 * @author Kobazulo
 * @author Theklan
 */
$messages['eu'] = array(
	'openidserver' => 'OpenID zerbitzaria',
	'openidoptional' => 'Aukerazkoa',
	'openidrequired' => 'Nahitaezkoa',
	'openidnickname' => 'Ezizena',
	'openidfullname' => 'Izen osoa',
	'openidemail' => 'E-posta helbidea',
	'openidlanguage' => 'Hizkuntza',
	'openidchoosepassword' => 'pasahitza:',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Mobe
 * @author Nike
 * @author Olli
 * @author Silvonen
 * @author Str4nd
 * @author Varusmies
 * @author Vililikku
 * @author ZeiP
 */
$messages['fi'] = array(
	'openid-desc' => 'Kirjaudu wikiin [http://openid.net/ OpenID:llä] ja muille OpenID-tuetuille sivustoille wiki-käyttäjätilillä.',
	'openidlogin' => 'Kirjaudu OpenID:llä',
	'openidserver' => 'OpenID-palvelin',
	'openidxrds' => 'Yadis-tiedosto',
	'openidconvert' => 'OpenID-muunnin',
	'openiderror' => 'Todennusvirhe',
	'openiderrortext' => 'Tapahtui virhe OpenID-osoitteen todentamisen aikana.',
	'openidconfigerror' => 'OpenID-asetusvirhe',
	'openidconfigerrortext' => 'OpenID-varaston määritykset ovat epäkelvolliset tässä wikissä.
Ota yhteyttä [[Special:ListUsers/sysop|ylläpitäjään]].',
	'openidpermission' => 'OpenID-oikeusvirhe',
	'openidpermissiontext' => 'Tarjoamallasi OpenID:llä ei ole luvallista kirjautua tälle palvelimelle.',
	'openidcancel' => 'Todennus peruutettiin',
	'openidcanceltext' => 'OpenID-osoitteen todentaminen peruutettiin.',
	'openidfailure' => 'Todennus epäonnistui',
	'openidfailuretext' => 'OpenID-osoitteen todentaminen epäonnistui. Virheilmoitus: ”$1”',
	'openidsuccess' => 'Todennus onnistui',
	'openidsuccesstext' => 'OpenID-osoitteen todennus onnistui.',
	'openidusernameprefix' => 'OpenID-käyttäjä',
	'openidserverlogininstructions' => 'Kirjaudu sisään sivustolle $3 käyttäjänä $2 (käyttäjäsivu $1) syöttämällä salasana alle.',
	'openidtrustinstructions' => 'Tarkista, haluatko jakaa tietoja kohteen $1 kanssa.',
	'openidallowtrust' => 'Salli sivuston $1 luottaa tähän käyttäjätiliin.',
	'openidnopolicy' => 'Sivusto ei ole määritellyt yksityisyyskäytäntöä.',
	'openidpolicy' => 'Lisää tietoa on <a target="_new" href="$1">yksityisyyskäytännöissä</a>.',
	'openidoptional' => 'Valinnainen',
	'openidrequired' => 'Vaadittu',
	'openidnickname' => 'Nimimerkki',
	'openidfullname' => 'Koko nimi',
	'openidemail' => 'Sähköpostiosoite',
	'openidlanguage' => 'Kieli',
	'openidtimezone' => 'Aikavyöhyke',
	'openidchooselegend' => 'Käyttäjätunnuksen valinta',
	'openidchooseinstructions' => 'Kaikki käyttäjät tarvitsevat nimimerkin.
Voit valita omasi alla olevista vaihtoehdoista.',
	'openidchoosefull' => 'Koko nimesi ($1)',
	'openidchooseurl' => 'OpenID:stäsi poimittu nimi ($1)',
	'openidchooseauto' => 'Automaattisesti luotu nimi ($1)',
	'openidchoosemanual' => 'Omavalintainen nimi',
	'openidchooseexisting' => 'Olemassa oleva tunnus tässä wikissä',
	'openidchoosepassword' => 'salasana:',
	'openidconvertinstructions' => 'Tällä lomakkeella voit muuttaa käyttäjätilisi käyttämään OpenID-osoitetta tai lisätä OpenID-osoitteita.',
	'openidconvertoraddmoreids' => 'Siirry OpenID:hen tai lisää uusi OpenID-osoite.',
	'openidconvertsuccess' => 'Muutettiin onnistuneesti OpenID:hen.',
	'openidconvertsuccesstext' => 'OpenID:si on muunnettu muotoon $1.',
	'openidconvertyourstext' => 'Tämä on jo OpenID:si.',
	'openidconvertothertext' => 'Tämä on jonkun muun OpenID.',
	'openidalreadyloggedin' => "'''Olet jo kirjautuneena sisään, $1!'''

Jos haluat käyttää OpenID:tä kirjautumiseen jatkossa, voit [[Special:OpenIDConvert|muuntaa tunnuksesi käyttämään OpenID:tä]].",
	'openidnousername' => 'Käyttäjätunnus puuttuu.',
	'openidbadusername' => 'Käyttäjätunnus on virheellinen.',
	'openidautosubmit' => 'Tämä sivu sisältää lomakkeen, joka lähettää itse itsensä, jos JavaScript käytössä.
Muussa tapauksessa valitse <code>Continue</code> (Jatka).',
	'openidclientonlytext' => 'Et voi käyttää tämän wikin käyttäjätunnuksia OpenID-tunnuksina muilla sivustoilla.',
	'openidloginlabel' => 'OpenID-URL',
	'openidlogininstructions' => '{{SITENAME}} tukee [http://openid.net/ OpenID]-standardia yhden tunnuksen käyttämiseksi eri Web-sivustoilla.
OpenID antaa sinun kirjautua useille eri Web-sivustoille tarvitsematta eri salasanaa jokaiseen.
(Katso [http://en.wikipedia.org/wiki/OpenID Wikipedian OpenID-artikkeli] saadaksesi lisätietoja.)

Jos sinulla on jo tunnus {{SITENAME}}, voit [[Special:UserLogin|kirjautua sisään]] käyttäjätunnuksellasi ja salasanallasi kuten normaalistikin.
Käyttääksesi tulevaisuudessa OpenID:tä, voit [[Special:OpenIDConvert|muuntaa tilisi OpenID:een]] normaalin sisäänkirjautumisen jälkeen.

Tarjolla on monia eri [http://openid.net/get/ OpenID-tarjoajia], ja sinulla saattaa jo olla OpenID:tä tarjoava tunnus toisessa palvelussa.',
	'openidupdateuserinfo' => 'Päivitä minun henkilökohtaiset tietoni.',
	'openiddelete' => 'Poista OpenID',
	'openiddelete-text' => 'Napsauttamalla {{int:openiddelete-button}}-paniketta, voit poistaa OpenID:n $1 tunnuksestasi.
Et voi enää kirjautua sisään tällä OpenID:llä.',
	'openiddelete-button' => 'Vahvista',
	'openiddelete-sucess' => 'OpenID on onnistuneesti poistettu tilistäsi.',
	'openiddelete-error' => 'Virhe poistettaessa OpenID:tä tilistäsi.',
	'openid-prefstext' => '[http://openid.net/ OpenID]-asetukset',
	'openid-pref-hide' => 'Piilota OpenID:si käyttäjäsivultani, jos kirjaudun sisään OpenID-tunnuksilla.',
	'openid-pref-update-userinfo-on-login' => 'Päivitä seuraavat tiedot OpenID-tiedoista jokaisella kirjautumisella:',
	'openid-urls-desc' => 'Tiliisi liitetyt OpenID:eet:',
	'openid-urls-action' => 'Toiminto',
	'openid-urls-delete' => 'Poista',
	'openid-add-url' => 'Lisää uusi OpenID',
	'openidsigninorcreateaccount' => 'Kirjaudu sisään tai luo tunnus',
	'openid-provider-label-openid' => 'Anna sinun OpenID URL-osoitteesi',
	'openid-provider-label-google' => 'Kirjaudu sisään käyttämällä Google-tunnuksiasi',
	'openid-provider-label-yahoo' => 'Kirjaudu sisään käyttämällä Yahoo-tunnuksiasi',
	'openid-provider-label-aol' => 'Anna AOL-käyttäjänimesi',
	'openid-provider-label-other-username' => 'Anna sinun $1-käyttäjätunnuksesi',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Zetud
 */
$messages['fr'] = array(
	'openid-desc' => 'Se connecter au wiki avec [http://openid.net/ OpenID] et se connecter à d’autres sites internet OpenID avec un compte utilisateur du wiki.',
	'openidlogin' => 'Se connecter avec OpenID',
	'openidserver' => 'Serveur OpenID',
	'openidxrds' => 'Fichier Yadis',
	'openidconvert' => 'Convertisseur OpenID',
	'openiderror' => 'Erreur de vérification',
	'openiderrortext' => 'Une erreur est intervenue pendant la vérification de l’adresse OpenID.',
	'openidconfigerror' => 'Erreur de configuration de OpenID',
	'openidconfigerrortext' => 'Le stockage de la configuration OpenID pour ce wiki est incorrecte.
Veuillez vous mettre en rapport avec un [[Special:ListUsers/sysop|administrateur]] de ce site.',
	'openidpermission' => 'Erreur de permission OpenID',
	'openidpermissiontext' => 'L’OpenID que vous avez fournie n’est pas autorisée à se connecter sur ce serveur.',
	'openidcancel' => 'Vérification annulée',
	'openidcanceltext' => 'La vérification de l’adresse OpenID a été annulée.',
	'openidfailure' => 'Échec de la vérification',
	'openidfailuretext' => 'La vérification de l’adresse OpenID a échouée. Message d’erreur : « $1 »',
	'openidsuccess' => 'Vérification réussie',
	'openidsuccesstext' => 'Vérification de l’adresse OpenID réussie.',
	'openidusernameprefix' => 'Utilisateur OpenID',
	'openidserverlogininstructions' => "Entrez votre mot de passe ci-dessous pour vous connecter sur $3 comme utilisateur '''$2''' (page utilisateur $1).",
	'openidtrustinstructions' => 'Cochez si vous désirez partager les données avec $1.',
	'openidallowtrust' => 'Autorise $1 à faire confiance à ce compte utilisateur.',
	'openidnopolicy' => 'Le site n’a pas indiqué une politique des données personnelles.',
	'openidpolicy' => 'Vérifier la <a target="_new" href="$1">Politique des données personnelles</a> pour plus d’information.',
	'openidoptional' => 'Facultatif',
	'openidrequired' => 'Exigé',
	'openidnickname' => 'Surnom',
	'openidfullname' => 'Nom en entier',
	'openidemail' => 'Adresse courriel',
	'openidlanguage' => 'Langue',
	'openidtimezone' => 'Zone horaire',
	'openidchooselegend' => "Choix du nom d'utilisateur",
	'openidchooseinstructions' => 'Tous les utilisateurs ont besoin d’un surnom ; vous pouvez en choisir un à partir des choix ci-dessous.',
	'openidchoosenick' => 'Votre surnom ($1)',
	'openidchoosefull' => 'Votre nom entier ($1)',
	'openidchooseurl' => 'Un nom choisi depuis votre OpenID ($1)',
	'openidchooseauto' => 'Un nom créé automatiquement ($1)',
	'openidchoosemanual' => 'Un nom de votre choix :',
	'openidchooseexisting' => 'Un compte existant sur ce wiki',
	'openidchooseusername' => "nom d'utilisateur :",
	'openidchoosepassword' => 'mot de passe :',
	'openidconvertinstructions' => 'Ce formulaire vous permet de changer votre compte utilisateur pour utiliser une adresse OpenID ou ajouter des adresses OpenID supplémentaires.',
	'openidconvertoraddmoreids' => 'Convertir vers OpenID ou ajouter une autre adresse OpenID',
	'openidconvertsuccess' => 'Converti avec succès vers OpenID',
	'openidconvertsuccesstext' => 'Vous avez converti avec succès votre OpenID vers $1.',
	'openidconvertyourstext' => 'C’est déjà votre OpenID.',
	'openidconvertothertext' => 'Ceci est l’OpenID de quelqu’un d’autre.',
	'openidalreadyloggedin' => "'''Vous êtes déjà connecté{{GENDER:||e|(e)}}, $1 !'''

Vous vous désirez utiliser votre OpenID pour vous connecter ultérieurement, vous pouvez [[Special:OpenIDConvert|convertir votre compte pour utiliser OpenID]].",
	'openidnousername' => 'Aucun nom d’utilisateur n’a été indiqué.',
	'openidbadusername' => 'Un mauvais nom d’utilisatteur a été indiqué.',
	'openidautosubmit' => 'Cette page comprend un formulaire qui pourrait être envoyé automatiquement si vous avez activé JavaScript.
Si tel n’était pas le cas, essayez le bouton « Continue » (continuer).',
	'openidclientonlytext' => 'Vous ne pouvez utiliser des comptes depuis ce wiki en tant qu’OpenID sur d’autres sites.',
	'openidloginlabel' => 'Adresse OpenID',
	'openidlogininstructions' => '{{SITENAME}} supporte le standard [http://openid.net/ OpenID] pour une seule signature entre des sites Internet.
OpenID vous permet de vous connecter sur plusieurs sites différents sans à avoir à utiliser un mot de passe différent pour chacun d’entre eux.
(Voyez [http://fr.wikipedia.org/wiki/OpenID l’article de Wikipédia] pour plus d’informations.)

Si vous avez déjà un compte sur {{SITENAME}}, vous pouvez vous [[Special:UserLogin|connecter]] avec votre nom d’utilisateur et son mot de pas comme d’habitude. Pour utiliser OpenID, à l’avenir, vous pouvez [[Special:OpenIDConvert|convertir votre compte en OpenID]] après que vous vous soyez connecté normallement.

Il existe plusieurs [http://openid.net/get/ fournisseur d’OpenID], et vous pouvez déjà obtenir un compte OpenID activé sur un autre service.',
	'openidupdateuserinfo' => 'Mettre à jour mes données personnelles :',
	'openiddelete' => "Supprimer l'OpenID",
	'openiddelete-text' => "En cliquant sur le bouton « {{int:openiddelete-button}} », vous supprimez l'OpenID $1 de votre compte.
Vous ne pourrez plus vous connecter avec cet OpenID.",
	'openiddelete-button' => 'Confirmer',
	'openiddeleteerrornopassword' => "Vous ne pouvez pas supprimer tous vos OpenID parce que votre compte n'a pas de mot de passe.
Vous ne pourriez pas vous connecter sans un OpenID.",
	'openiddeleteerroropenidonly' => "Vous ne pouvez pas supprimer tous vos OpenID parce que vous ne pouvez vous connecter qu'avec OpenID.
Vous ne pourriez pas vous connecter sans un OpenID.",
	'openiddelete-sucess' => "L'OpenID a été supprimé avec succès de votre compte.",
	'openiddelete-error' => "Une erreur est survenue pendant la suppression de l'OpenID de votre compte.",
	'openid-prefstext' => 'Préférences de [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Cacher votre OpenID sur votre page utilisateur, si vous vous connectez avec OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Mettre à jour les données suivantes depuis OpenID à chaque fois que je me connecte :',
	'openid-urls-desc' => 'OpenID associées avec votre compte :',
	'openid-urls-action' => 'Action',
	'openid-urls-delete' => 'Supprimer',
	'openid-add-url' => 'Ajouter un nouvel OpenID',
	'openidsigninorcreateaccount' => 'Se connecter ou créer un nouveau compte',
	'openid-provider-label-openid' => 'Entrez votre URL OpenID',
	'openid-provider-label-google' => 'Vous connecter en utilisant votre compte Google',
	'openid-provider-label-yahoo' => 'Vous connecter en utilisant votre compte Yahoo',
	'openid-provider-label-aol' => 'Entrez votre nom AOL',
	'openid-provider-label-other-username' => 'Entrez votre nom d’utilisateur $1',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'openidemail' => 'Adrèce èlèctronica',
	'openidlanguage' => 'Lengoua',
	'openidtimezone' => 'Zona horèra',
	'openidchoosepassword' => 'Mot de pâssa :',
	'openiddelete-button' => 'Confirmar',
	'openid-urls-action' => 'Accion',
	'openid-urls-delete' => 'Suprimar',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'openidpermission' => 'Earráid ceadúnais OpenID',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'openid-desc' => 'Acceder ao sistema do wiki cun [http://openid.net/ OpenID] e acceder a outras páxinas web OpenID cunha conta de usuario dun wiki',
	'openidlogin' => 'Acceder ao sistema co OpenID',
	'openidserver' => 'Servidor do OpenID',
	'openidxrds' => 'Ficheiro Yadis',
	'openidconvert' => 'Transformador OpenID',
	'openiderror' => 'Erro de verificación',
	'openiderrortext' => 'Ocorreu un erro durante a verificación do URL do OpenID.',
	'openidconfigerror' => 'Erro na configuración do OpenID',
	'openidconfigerrortext' => 'A configuración do almacenamento no OpenID deste wiki é inválido.
Por favor, consúlteo cun [[Special:ListUsers/sysop|administrador]] do sitio.',
	'openidpermission' => 'Erro de permisos OpenID',
	'openidpermissiontext' => 'O OpenID que proporcionou non ten permitido o acceso a este servidor.',
	'openidcancel' => 'A verificación foi cancelada',
	'openidcanceltext' => 'A verificación do enderezo URL do OpenID foi cancelada.',
	'openidfailure' => 'Fallou a verificación',
	'openidfailuretext' => 'Fallou a verificación da dirección URL do OpenID. Mensaxe de erro: "$1"',
	'openidsuccess' => 'A verificación foi un éxito',
	'openidsuccesstext' => 'A verificación da dirección URL do OpenID foi un éxito.',
	'openidusernameprefix' => 'Usuario do OpenID',
	'openidserverlogininstructions' => 'Insira o seu contrasinal embaixo para acceder a $3 como o usuario $2 (páxina de usuario $1).',
	'openidtrustinstructions' => 'Comprobe se quere compartir datos con $1.',
	'openidallowtrust' => 'Permitir que $1 revise esta conta de usuario.',
	'openidnopolicy' => 'O sitio non especificou unha política de privacidade.',
	'openidpolicy' => 'Comprobe a <a target="_new" href="$1">política de privacidade</a> para máis información.',
	'openidoptional' => 'Opcional',
	'openidrequired' => 'Necesario',
	'openidnickname' => 'Alcume',
	'openidfullname' => 'Nome completo',
	'openidemail' => 'Enderezo de correo electrónico',
	'openidlanguage' => 'Lingua',
	'openidtimezone' => 'Zona horaria',
	'openidchooselegend' => 'Elección do nome de usuario',
	'openidchooseinstructions' => 'Todos os usuarios precisan un alcume; pode escoller un de entre as opcións de embaixo.',
	'openidchoosenick' => 'O seu alcume ($1)',
	'openidchoosefull' => 'O seu nome completo ($1)',
	'openidchooseurl' => 'Un nome tomado do seu OpenID ($1)',
	'openidchooseauto' => 'Un nome autoxerado ($1)',
	'openidchoosemanual' => 'Un nome da súa escolla:',
	'openidchooseexisting' => 'Unha conta existente neste wiki',
	'openidchooseusername' => 'nome de usuario:',
	'openidchoosepassword' => 'contrasinal:',
	'openidconvertinstructions' => 'Este formulario permítelle cambiar a súa conta de usuario para usar un enderezo URL de OpenID ou engadir máis enderezos URL de OpenID.',
	'openidconvertoraddmoreids' => 'Converter a OpenID ou engadir outro enderezo URL de OpenID',
	'openidconvertsuccess' => 'Convertiuse con éxito a OpenID',
	'openidconvertsuccesstext' => 'Converteu con éxito o seu OpenID a $1.',
	'openidconvertyourstext' => 'Ese xa é o seu OpenID.',
	'openidconvertothertext' => 'Ese é o OpenID de alguén.',
	'openidalreadyloggedin' => "'''Está dentro do sistema, $1!'''

Se quere usar OpenID para acceder ao sistema no futuro, pode [[Special:OpenIDConvert|converter a súa conta para usar OpenID]].",
	'openidnousername' => 'Non foi especificado ningún nome de usuario.',
	'openidbadusername' => 'O nome de usuario especificado é incorrecto.',
	'openidautosubmit' => 'Esta páxina inclúe un formulario que debería ser enviado automaticamente se ten o JavaScript activado.
Se non é así, probe a premer no botón "Continue" (Continuar).',
	'openidclientonlytext' => 'Non pode usar contas deste wiki como OpenIDs noutro sitio.',
	'openidloginlabel' => 'Dirección URL do OpenID',
	'openidlogininstructions' => '{{SITENAME}} soporta o  [http://openid.net/ OpenID] estándar para unha soa sinatura entre os sitios web.
OpenID permítelle rexistrarse en diferentes sitios web sen usar un contrasinal diferente para cada un.
(Consulte o [http://en.wikipedia.org/wiki/OpenID artigo sobre o OpenID na Wikipedia en inglés] para obter máis información.)

Se xa ten unha conta en {{SITENAME}}, pode [[Special:UserLogin|acceder ao sistema]] co seu nome de usuario e contrasinal como o fai habitualmente.
Para usar o OpenID no futuro, pode [[Special:OpenIDConvert|converter a súa conta en OpenID]] tras ter accedido ao sistema como fai normalmente.

Hai moitos [http://openid.net/get/ proveedores públicos de OpenID] e xa pode ter unha conta co OpenID activado noutro servizo.',
	'openidupdateuserinfo' => 'Actualizar a miña información persoal:',
	'openiddelete' => 'Borrar o OpenID',
	'openiddelete-text' => 'Ao premer no botón "{{int:openiddelete-button}}", borrará o OpenID $1 da súa conta.
Non será capaz de volver acceder ao sistema con este OpenID.',
	'openiddelete-button' => 'Confirmar',
	'openiddeleteerrornopassword' => 'Non pode borrar todos os seus OpenID porque a súa conta non ten contrasinal.
Non podería conectarse sen un OpenID.',
	'openiddeleteerroropenidonly' => 'Non pode borrar todos os seus OpenID porque non se pode conectar máis que con OpenID.
Non podería conectarse sen un OpenID.',
	'openiddelete-sucess' => 'O OpenID foi eliminado con éxito da súa conta.',
	'openiddelete-error' => 'Houbo un erro ao eliminar o OpenID da súa conta.',
	'openid-prefstext' => 'Preferencias do [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Agoche o enderezo URL do seu OpenID na súa páxina de usuario, se accede ao sistema con OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Actualizar a seguinte información do OpenID cada vez que acceda ao sistema:',
	'openid-urls-desc' => 'OpenIDs asociados á súa conta:',
	'openid-urls-action' => 'Acción',
	'openid-urls-delete' => 'Borrar',
	'openid-add-url' => 'Engadir un novo OpenID',
	'openidsigninorcreateaccount' => 'Acceder ou crear unha conta nova',
	'openid-provider-label-openid' => 'Insira o enderezo URL do seu OpenID',
	'openid-provider-label-google' => 'Acceder usando a súa conta do Google',
	'openid-provider-label-yahoo' => 'Acceder usando a súa conta do Yahoo',
	'openid-provider-label-aol' => 'Insira o seu nome AOL',
	'openid-provider-label-other-username' => 'Insira o seu nome de usuario $1',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'openidoptional' => 'Προαιρετικόν',
	'openidrequired' => 'Ἀπαιτούμενον',
	'openidnickname' => 'Ψευδώνυμον',
	'openidfullname' => 'Πλῆρες ὄνομα',
	'openidemail' => 'Ἡλεκτρονικὴ διεύθυνσις',
	'openidlanguage' => 'Γλῶττα',
	'openidtimezone' => 'Χρονικὴ ζώνη:',
	'openidchoosepassword' => 'σύνθημα:',
	'openiddelete-button' => 'Κυροῦν',
	'openid-urls-action' => 'Δρᾶσις',
	'openid-urls-delete' => 'Σβεννύναι',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'openid-desc' => 'Mit eme Wiki-Benutzerkonto in däm Wiki mit ere [http://openid.net/ OpenID] aamälde un bi andere Netzsyte aamälde, wu OpenID unterstitze',
	'openidlogin' => 'Aamälde mit OpenID',
	'openidserver' => 'OpenID-Server',
	'openidxrds' => 'Yadis-Datei',
	'openidconvert' => 'OpenID-Konverter',
	'openiderror' => 'Iberpriefigsfähler',
	'openiderrortext' => 'S het e Fähle gee derwyylscht d OpenID-URL iberprieft woren isch.',
	'openidconfigerror' => 'OpenID-Konfigurationsfähler',
	'openidconfigerrortext' => 'D OpenID-Spycherkonfiguarion fir des Wiki isch fählerhaft.
Bitte gib eme [[Special:ListUsers/sysop|Ammann]] e Nochricht.',
	'openidpermission' => 'OpenID-Berächtigungsfähler',
	'openidpermissiontext' => 'D OpenID, wu Du aagee hesch, berächtigt nit zue dr Aamäldig bi däm Server.',
	'openidcancel' => 'Iberpriefig abbroche',
	'openidcanceltext' => 'D Iberpriefig vu dr OpenID-URL isch abbroche wore.',
	'openidfailure' => 'Iberpriefigsfähler',
	'openidfailuretext' => 'D Iberpriefig vu dr OpenID-URL isch fählgschlaa. Fählermäldig: „$1“',
	'openidsuccess' => 'Erfolgryych iberprieft',
	'openidsuccesstext' => 'D Iberpriefig vu dr OpenID-URL isch erfolgryych gsi.',
	'openidusernameprefix' => 'OpenID-Benutzer',
	'openidserverlogininstructions' => 'Gib Dyy Passwort unten yy go Di as Benutzer $2 an $3 aazmälde (Benutzersyte $1).',
	'openidtrustinstructions' => 'Prief, eb Du Date mit $1 wit teile.',
	'openidallowtrust' => 'Erlaub $1, däm Benutzerkonto z vertröue.',
	'openidnopolicy' => 'D Syte het kei Dateschutzrichtlinie aagee.',
	'openidpolicy' => 'Prief d <a target="_new" href="$1">Dateschutzrichtlinie</a> fir wyteri Informatione.',
	'openidoptional' => 'Optional',
	'openidrequired' => 'Pflicht',
	'openidnickname' => 'Benutzername',
	'openidfullname' => 'Vollständiger Name',
	'openidemail' => 'E-Mail-Adräss:',
	'openidlanguage' => 'Sproch',
	'openidtimezone' => 'Zytzone',
	'openidchooselegend' => 'Benutzernameuuswahl',
	'openidchooseinstructions' => 'Alli Benutzer bruuche ne Benutzername;
Du chasch us däre Lischt ein uussueche.',
	'openidchoosenick' => 'Dyy Spitzname ($1)',
	'openidchoosefull' => 'Dyy vollständige Name ($1)',
	'openidchooseurl' => 'E Name us Dyynere OpenID ($1)',
	'openidchooseauto' => 'E automatisch aagleite Name ($1)',
	'openidchoosemanual' => 'E vu Dir gwehlte Name:',
	'openidchooseexisting' => 'E Benutzerkonto, wu s in däm Wiki git:',
	'openidchooseusername' => 'Benutzername:',
	'openidchoosepassword' => 'Passwort:',
	'openidconvertinstructions' => 'Mit däm Formular chasch Dyy Benutzerkonto frejgee fir d Benutzig vun ere OpenID-URL oder firzum meh OpenIds yyfiege.',
	'openidconvertoraddmoreids' => 'Zuen ere OpenId wägsle oder e anderi OpenId zuefiege',
	'openidconvertsuccess' => 'Erfolgryych no OpenID konvertiert',
	'openidconvertsuccesstext' => 'Du hesch d Konvertierig vu Dyynere OpenID no $1 erfolgryych durgfiert.',
	'openidconvertyourstext' => 'Des isch scho Dyyni OpenID.',
	'openidconvertothertext' => 'Des isch d OpenID vu eber anderem.',
	'openidalreadyloggedin' => "'''Du bisch scho aagmäldet, $1!'''

Wänn Du OpenID fir s Aamälde in Zuechumft wit nutze, no chasch [[Special:OpenIDConvert|Dyy Benutzerkonto no OpenID konvertiere]].",
	'openidnousername' => 'Kei Benutzername aagee.',
	'openidbadusername' => 'Falsche Benutzername aagee.',
	'openidautosubmit' => 'Uf däre Syte het s e Formular, wu automatisch ibertrait wird, wänn JavaSkript aktiviert isch. Wänn nit, no druck bitte uf „Continue“ (Wyter).',
	'openidclientonlytext' => 'Du chasch kei Benutzerkonte us däm Wiki as OpenID fir anderi Syte verwände.',
	'openidloginlabel' => 'OpenID-URL',
	'openidlogininstructions' => '{{SITENAME}} unterstitzt dr [http://openid.net/ OpenID]-Standard zum sich fir mehreri Websites aazmälde.
OpenID mäldet Di bi vyyle unterschidlige Netzsyte aa, ohni ass Du fir jedi e ander Passwort muesch verwände.
(Meh Informatione bietet dr [http://de.wikipedia.org/wiki/OpenID dytsch Wikipedia-Artikel zue dr OpenID].)

Wänn Du imfall scho ne Benutzerkonto bi {{SITENAME}} hesch, no chasch Di ganz normal mit em Benutzername un em Passwort [[Special:UserLogin|aamälde]].
Wänn Du in Zuechumft OpenID mechtsch verwände, chasch [[Special:OpenIDConvert|Dyy Account zue OpenID konvertiere]], wänn Di normal aagmäldet hesch.

S git vyyl [http://wiki.openid.net/Public_OpenID_providers effentligi OpenID-Provider] un villicht hesch scho ne  Benutzerkonto mit aktiviertem OpenID bin eme andere Aabieter.',
	'openidupdateuserinfo' => 'Myni persenlige Date aktualisiere',
	'openiddelete' => 'OpenID lesche',
	'openiddelete-text' => 'Wänn Du dr „{{int:openiddelete-button}}“-Chnopf drucksch, nimmsch d OpenID $1 us Dyym Benutzerkonto use. Du chasch Di derno nimmi mit däre OpenID aamälde.',
	'openiddelete-button' => 'Bstätige',
	'openiddeleteerrornopassword' => 'Du chasch nit Dyyni ganze OpenID lesche, wel Dyy Benutzerkonto kei Passwort het.
Derno wärsch nimmi imstand, di ohni OpenID aazmälde.',
	'openiddeleteerroropenidonly' => 'Du chasch nit Dyyni ganze OpenID lesche, wel Du di numme mit ere OpenID aamälde derfsch. Derno wärsch nimmi imstand, di ohni OpenID aazmälde.',
	'openiddelete-sucess' => 'D OpenID isch erfolgryych us Dyym Benutzerkonto uusegnuu wore.',
	'openiddelete-error' => 'E Fähler isch ufträtte, derwylscht d OpenID us Dyym Benutzerkonto uusegnuu woren isch.',
	'openid-prefstext' => '[http://openid.net/ OpenID] Yystellige',
	'openid-pref-hide' => 'Versteck Dyyni OpenID uf Dyynere Benutzersyte, wänn Di mit OpenID aamäldsch.',
	'openid-pref-update-userinfo-on-login' => 'Die Informatione mit em OpenID-Konto bi jedere Aamäldig aktualisiere',
	'openid-urls-desc' => 'OpenIDs´, wu mit Dyym Benutzerkonto verbunde sin:',
	'openid-urls-action' => 'Aktion',
	'openid-urls-delete' => 'Lesche',
	'openid-add-url' => 'E neji OpenID zuefiege',
	'openidsigninorcreateaccount' => 'Aamälde oder nej Benutzerkonto aalege',
	'openid-provider-label-openid' => 'Gib Dyy OpenID URL yy',
	'openid-provider-label-google' => 'Mäld Di aa mit Dyynem Google-Konto',
	'openid-provider-label-yahoo' => 'Mäld Di aa mit Dyynme Yahoo-Konto',
	'openid-provider-label-aol' => 'Gib Dyy AOL-Benutzername yy',
	'openid-provider-label-other-username' => 'Gib Dyy $1-Benutzername yy',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'openidemail' => 'Enmys post-L',
	'openidlanguage' => 'Çhengey',
	'openidchoosepassword' => 'fockle yn arrey:',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 */
$messages['haw'] = array(
	'openidlanguage' => 'ʻŌlelo',
	'openidchoosepassword' => 'ʻōlelo hūnā:',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'openid-desc' => 'כניסה לחשבון בוויקי באמצעות [http://openid.net/ OpenID], והתחברות לאתרים נוספים הפועלים עם OpenID באמצעות חשבון משתמש בוויקי',
	'openidlogin' => 'כניסה לחשבון עם OpenID',
	'openidserver' => 'שרת OpenID',
	'openidxrds' => 'קובץ Yadis',
	'openidconvert' => 'ממיר OpenID',
	'openiderror' => 'שגיאת אימות',
	'openiderrortext' => 'אירעה שגיאה במהלך אימות כתובת ה־OpenID.',
	'openidconfigerror' => 'שגיאה בתצורת OpenID',
	'openidconfigerrortext' => 'תצורת איחסון ה־OpenID עבור ויקי זה אינה תקינה.
אנא התייעצו עם אחד מ[[Special:ListUsers/sysop|מפעילי המערכת]].',
	'openidpermission' => 'שגיאת הרשאות OpenID',
	'openidpermissiontext' => 'ה־OpenID שסיפקתם אינו מורשה להתחבר לשרת זה.',
	'openidcancel' => 'האימות בוטל',
	'openidcanceltext' => 'אימות כתובת ה־OpenID בוטל.',
	'openidfailure' => 'האימות נכשל',
	'openidfailuretext' => 'אימות כתובת ה־OpenID נכשל. הודעת השגיאה: "$1"',
	'openidsuccess' => 'האימות הושלם בהצלחה',
	'openidsuccesstext' => 'אימות כתובת ה־OpenID הושלם בהצלחה.',
	'openidusernameprefix' => 'משתמשOpenID',
	'openidserverlogininstructions' => 'כתבו את סיסמתכם להלן כדי להיכנס לחשבון באתר $3 בתור המשתמש $2 (דף המשתמש: $1).',
	'openidtrustinstructions' => 'סמנו אם ברצונכם לשתף מידע עם $1.',
	'openidallowtrust' => 'מתן האפשרות ל־$1 לבטוח בחשבון משתמש זה.',
	'openidnopolicy' => 'האתר לא ציין מדיניות פרטיות.',
	'openidpolicy' => 'בדקו את <a target="_new" href="$1">מדיניות הפרטיות</a> למידע נוסף.',
	'openidoptional' => 'אופציונאלי',
	'openidrequired' => 'נדרש',
	'openidnickname' => 'כינוי',
	'openidfullname' => 'שם מלא',
	'openidemail' => 'כתובת דוא"ל',
	'openidlanguage' => 'שפה',
	'openidtimezone' => 'אזור זמן',
	'openidchooseinstructions' => 'כל המשתמשים זקוקים לכינוי;
תוכלו לבחור אחת מהאפשרויות שלהלן.',
	'openidchoosefull' => 'שמכם המלא ($1)',
	'openidchooseurl' => 'שם שנבחר מה־OpenID שלכם ($1)',
	'openidchooseauto' => 'שם שנוצר אוטומטית ($1)',
	'openidchoosemanual' => 'השם הנבחר:',
	'openidchooseexisting' => 'חשבון קיים בוויקי זה:',
	'openidchoosepassword' => 'סיסמה:',
	'openidconvertinstructions' => 'טופס זה מאפשר לכם לשנות את חשבון המשתמש שלכם לשימוש בכתובת OpenID או להוסיף כתובות OpenID נוספות',
	'openidconvertoraddmoreids' => 'המרה ל־OpenID או הוספת כתובת OpenID נוספת',
	'openidconvertsuccess' => 'הומר בהצלחה ל־OpenID',
	'openidconvertsuccesstext' => 'המרתם בהצלחה את ה־OpenID שלכם ל־$1.',
	'openidconvertyourstext' => 'זהו כבר ה־OpenID שלכם.',
	'openidconvertothertext' => 'זהו ה־OpenID של מישהו אחר.',
	'openidalreadyloggedin' => "'''הינכם כבר מחוברים לחשבון, $1!'''

אם ברצונכם להשתמש ב־OpenID כדי להתחבר בעתיד, תוכלו [[Special:OpenIDConvert|להמיר את חשבונכם לשימוש ב־OpenID]].",
	'openidnousername' => 'לא צוין שם משתמש.',
	'openidbadusername' => 'שם המשתמש שצוין אינו תקין.',
	'openidautosubmit' => 'דף זה מכיל טופס שאמור להשלח אוטומטית אם יש לכם JavaScript פעיל.
אם זה לא פועל, נסו את הכפתור "Continue" (המשך).',
	'openidclientonlytext' => 'אינכם יכולים להשתמש בחשבונות משתמש מוויקי זה כזהויות OpenID באתר אחר.',
	'openidloginlabel' => 'כתובת OpenID',
	'openidlogininstructions' => 'ב{{grammar:תחילית|{{SITENAME}}}} מותקנת תמיכה בתקן ה־[http://openid.net/ OpenID] לחשבון משתמש מאוחד בין אתרי אינטרנט.
OpenID מאפשר לכם להיכנס לחשבון במגוון אתרים מבלי להשתמש בסיסמה שונה עבור כל אחד מהם.
(עיינו ב[http://he.wikipedia.org/wiki/OpenID ערך על OpenID בוויקיפדיה העברית] למידע נוסף.)

אם כבר יש ברשותכם חשבון במערכת {{SITENAME}}, תוכלו [[Special:UserLogin|להיכנס לחשבון]] עם שם המשתמש והסיסמה שלכם כרגיל.
על מנת להשתמש ב־OpenID בעתיד, תוכלו [[Special:OpenIDConvert|להמיר את חשבונכם ל־OpenID]] לאחר שנכנסתם לחשבון באופן הרגיל.

ישנם [http://wiki.openid.net/Public_OpenID_providers ספקי OpenID ציבוריים] רבים, ויתכן שכבר יש לכם חשבון התומך ב־OpenID בשירות אחר.',
	'openidupdateuserinfo' => 'עדכון המידע האישי שלי',
	'openiddelete' => 'מחיקת OpenID',
	'openiddelete-text' => 'אם תלחצו על הכפתור "{{int:openiddelete-button}}", חשבון ה־OpenID בשם $1 יוסר מחשבונכם.
לא תוכלו יותר להכנס עם OpenID זה.',
	'openiddelete-button' => 'אישור',
	'openiddelete-sucess' => 'ה־OpenID הוסר בהצלחה מחשבונכם.',
	'openiddelete-error' => 'ארעה שגיאה בעת הסרת ה־OpenID מחשבונכם.',
	'openid-prefstext' => 'העדפות [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'הסתרת כתובת ה־OpenID בדף המשתמש, במקרה של כניסה לחשבון עם OpenID.',
	'openid-pref-update-userinfo-on-login' => 'עדכון המידע הבא מכרטיס ה־OpenID עם כל כניסה לחשבון:',
	'openid-urls-desc' => 'כתובות OpenID המשויכות לחשבונכם:',
	'openid-urls-action' => 'פעולה',
	'openid-urls-delete' => 'מחיקה',
	'openid-add-url' => 'הוספת OpenID חדש',
	'openidsigninorcreateaccount' => 'כניסה או יצירת חשבון חדש',
	'openid-provider-label-openid' => 'הזינו את כתובת ה־OpenID שלכם',
	'openid-provider-label-google' => 'היכנסו באמצעות חשבונכם ב־Google',
	'openid-provider-label-yahoo' => 'היכנסו באמצעות חשבונכם ב־Yahoo',
	'openid-provider-label-aol' => 'כתבו את כינוי המסך שלכם ב־AOL',
	'openid-provider-label-other-username' => 'כתבו את שם המשתמש שלכם ב־$1',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author आलोक
 */
$messages['hi'] = array(
	'openidlogin' => 'OpenID से लॉग इन करें',
	'openidserver' => 'OpenID सर्वर',
	'openidxrds' => 'याडिस संचिका',
	'openidconvert' => 'OpenID कन्वर्टर',
	'openiderror' => 'प्रमाणिकरण गलती',
	'openiderrortext' => 'OpenID URL के प्रमाणिकरण में समस्या आई हैं।',
	'openidconfigerror' => 'OpenID व्यवस्थापन समस्या',
	'openidpermission' => 'OpenID अनुमति समस्या',
	'openidpermissiontext' => 'आपने दिये ओपनID से इस सर्वरपर लॉग इन नहीं किया जा सकता हैं।',
	'openidcancel' => 'प्रमाणिकरण रद्द कर दिया',
	'openidcanceltext' => 'ओपनID URL प्रमाणिकरण रद्द कर दिया गया हैं।',
	'openidfailure' => 'प्रमाणिकरण पूरा नहीं हुआ',
	'openidfailuretext' => 'ओपनID URL प्रमाणिकरण पूरा नहीं हो पाया। समस्या: "$1"',
	'openidsuccess' => 'प्रमाणिकरण पूर्ण',
	'openidsuccesstext' => 'ओपनID URL प्रमाणिकरण पूरा हो गया।',
	'openidusernameprefix' => 'OpenIDसदस्य',
	'openidserverlogininstructions' => '$3 पर $2 नामसे (सदस्य पृष्ठ $1) लॉग इन करनेके लिये अपना कूटशब्द नीचे दें।',
	'openidtrustinstructions' => 'आप $1 के साथ डाटा शेअर करना चाहते हैं इसकी जाँच करें।',
	'openidallowtrust' => '$1 को इस सदस्य खातेपर भरोसा रखने की अनुमति दें।',
	'openidnopolicy' => 'साइटने गोपनियता नीति नहीं बनाई हैं।',
	'openidoptional' => 'वैकल्पिक',
	'openidrequired' => 'आवश्यक',
	'openidnickname' => 'उपनाम',
	'openidfullname' => 'पूरानाम',
	'openidemail' => 'इ-मेल एड्रेस',
	'openidlanguage' => 'भाषा',
	'openidchoosefull' => 'आपका पूरा नाम ($1)',
	'openidchooseurl' => 'आपके OpenID से लिया एक नाम ($1)',
	'openidchooseauto' => 'एक अपनेआप बनाया नाम ($1)',
	'openidchoosemanual' => 'आपके पसंद का नाम:',
	'openidchooseexisting' => 'इस विकिपर पहले से होने वाला खाता:',
	'openidchoosepassword' => 'कूटशब्द:',
	'openidconvertsuccess' => 'ओपनID में बदल दिया गया हैं',
	'openidconvertsuccesstext' => 'आपने आपका ओपनID $1 में बदल दिया हैं।',
	'openidconvertyourstext' => 'यह आपका ही ओपनID हैं।',
	'openidconvertothertext' => 'यह किसी औरका ओपनID हैं।',
	'openidnousername' => 'सदस्यनाम दिया नहीं हैं।',
	'openidbadusername' => 'गलत सदस्यनाम दिया हैं।',
	'openidclientonlytext' => 'इस विकिपर खोले गये खाते आप अन्य साइटपर ओपनID के तौर पर इस्तेमाल नहीं कर सकतें हैं।',
	'openidloginlabel' => 'ओपनID URL',
	'openid-pref-hide' => 'अगर आपने ओपनID का इस्तेमाल करके लॉग इन किया हैं, तो आपके सदस्यपन्नेपर आपका ओपनID छुपायें।',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'openidchoosepassword' => 'kontra-senyas:',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Ex13
 */
$messages['hr'] = array(
	'openid-desc' => 'Prijava na wiki s [http://openid.net/ OpenID] i prijava na druge stranice koje podržavaju OpenID s wiki suradničkim računom',
	'openidlogin' => 'Prijava s OpenID',
	'openidserver' => 'OpenID poslužitelj',
	'openidxrds' => 'Yadis datoteka',
	'openidconvert' => 'OpenID pretvarač',
	'openiderror' => 'Greška pri provjeri',
	'openiderrortext' => 'Došlo je do pogreške pri provjeri OpenID URL adrese',
	'openidconfigerror' => 'Greška OpenID postavki',
	'openidconfigerrortext' => 'OpenID konfiguracija spremanja za ovaj wiki nije valjana.  
Molimo savjetujte se s [[Special:ListUsers/sysop|administratorom]].',
	'openidpermission' => 'Greška kod OpenID prava pristupa',
	'openidpermissiontext' => 'OpenIDu kojeg ste naveli nije dopušteno prijaviti se na ovaj poslužitelj.',
	'openidcancel' => 'Provjera otkazana',
	'openidcanceltext' => 'Provjera OpenID URL-a je otkazana.',
	'openidfailure' => 'Provjera nije uspjela',
	'openidfailuretext' => 'Provjera URL-a za OpenID nije uspjela. Greška: "$1"',
	'openidsuccess' => 'Provjera uspješna',
	'openidsuccesstext' => 'Provjera URL-a za OpenID je uspjela.',
	'openidusernameprefix' => 'OpenIDSuradnik',
	'openidserverlogininstructions' => 'Unesite ispod Vašu lozinku da biste se prijavili na $3 kao suradnik $2 (suradnička stranica $1).',
	'openidtrustinstructions' => 'Provjerite želite li dijeliti podatke s $1.',
	'openidallowtrust' => 'Omogući $1 da vjeruje ovom suradničkom računu.',
	'openidnopolicy' => 'Stranica nema navedena pravila privatnosti.',
	'openidpolicy' => 'Provjerite <a target="_new" href="$1">politiku privatnosti</a> za više informacija.',
	'openidoptional' => 'Neobavezno',
	'openidrequired' => 'Obavezno',
	'openidnickname' => 'Nadimak',
	'openidfullname' => 'Puno ime',
	'openidemail' => 'E-pošta',
	'openidlanguage' => 'Jezik',
	'openidtimezone' => 'Vremenska zona',
	'openidchooseinstructions' => 'Svi suradnici trebaju imati nadimak;
možete odabrati jedan od niže ponuđenih.',
	'openidchoosefull' => 'Vaše puno ime ($1)',
	'openidchooseurl' => 'Ime uzeto s Vašeg OpenID ($1)',
	'openidchooseauto' => 'Automatski generirano ime ($1)',
	'openidchoosemanual' => 'Ime po Vašem izboru:',
	'openidchooseexisting' => 'Postojeći račun na ovom wiki:',
	'openidchoosepassword' => 'lozinka:',
	'openidconvertinstructions' => 'Ovaj obrazac Vam omogućuje da promijenite Vaš suradničkii račun za upotrebu URL OpenID ili da dodate više OpenID URLova',
	'openidconvertoraddmoreids' => 'Pretvorite u OpenID ili dodajte drugi OpenID URL',
	'openidconvertsuccess' => 'Uspješno pretvoreno u OpenID',
	'openidconvertsuccesstext' => 'Uspješno ste pretvorili Vaš OpenID u $1.',
	'openidconvertyourstext' => 'To je već Vaš OpenID.',
	'openidconvertothertext' => 'To je OpenID koji pripada nekom drugom.',
	'openidalreadyloggedin' => "'''Vi ste već prijavljeni, $1!'''

Ako želite rabiti OpenID za buduće prijave, možete [[Special:OpenIDConvert|promijeniti Vaš račun za uporabu OpenID]].",
	'openidnousername' => 'Nije navedeno suradničko ime.',
	'openidbadusername' => 'Navedeno je neispravno suradničko ime.',
	'openidautosubmit' => 'Ova stranica uključuje obrazac koji bi trebao biti automatski poslan ako je kod Vas omogućen JavaScript. Ako nije, pokušajte nastaviti dalje putem "Continue".',
	'openidclientonlytext' => 'Ne možete rabiti račune s ove wiki kao OpenID na drugoj stranici.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => '{{SITENAME}} podržava [http://openid.net/ OpenID] standard za jedinstvenu prijavu između web stranica.
OpenID omogućuje da se prijavite na mnoge različite web stranice bez uporabe različitih lozinki za svaku od njih.
(Pogledajte [http://en.wikipedia.org/wiki/OpenID članak na Wikipediji o OpenID-u] za više informacija.)

Ako već imate račun na {{SITENAME}}, možete se [[Special:UserLogin|prijaviti]] s Vašim korisničkim imenom i šifrom kao i uvijek.
Da bi koristili OpenID u buduće, možete [[Special:OpenIDConvert|pretvoriti vaš račun u OpenID]] nakon što se normalno prijavite.

Postoji mnogo [http://wiki.openid.net/Public_OpenID_providers javnih pružatelja usluga za OpenID], i možda već imate neki račun na drugom servisu koji podržava OpenID.',
	'openidupdateuserinfo' => 'Ažuriraj moje osobne informacije',
	'openiddelete' => 'Izbriši OpenID',
	'openiddelete-text' => 'Klikom na "{{int:openiddelete-button}}" uklonit ćete OpenID $1 s Vašeg računa.
Nećete više biti u mogućnosti prijaviti se s ovim OpenID.',
	'openiddelete-button' => 'Potvrdi',
	'openiddelete-sucess' => 'OpenID je uspješno uklonjen iz vašeg računa.',
	'openiddelete-error' => 'Došlo je do pogreška pri uklanjanju OpenID iz Vašeg računa.',
	'openid-prefstext' => '[http://openid.net/ OpenID] postavke',
	'openid-pref-hide' => 'Sakrij Vaš OpenID na Vašoj suradničkoj stranici, ako ste prijavljeni s OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Ažuriraj sljedeće informacije iz OpenID identiteta svaki put kad se prijavim:',
	'openid-urls-desc' => 'OpenID-ovi povezani s Vašim računom:',
	'openid-urls-action' => 'Radnja',
	'openid-urls-delete' => 'Izbriši',
	'openid-add-url' => 'Dodaj novi OpenID',
	'openidsigninorcreateaccount' => 'Prijavite se ili napravite novi račun',
	'openid-provider-label-openid' => 'Unesite Vaš OpenID URL',
	'openid-provider-label-google' => 'Prijava putem Vašeg Google računa',
	'openid-provider-label-yahoo' => 'Prijava putem Vašeg Yahoo računa',
	'openid-provider-label-aol' => 'Unesite Vaš AOL nadimak',
	'openid-provider-label-other-username' => 'Unesite Vaše $1 suradničko ime',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'openid-desc' => 'Přizjewjenje pola wikija z [http://openid.net/ OpenID], a přizjewjenje pola druhich websydłow, kotrež OpenID podpěruja, z wikijowym wužiwarskim kontom',
	'openidlogin' => 'Přizjewjenje z OpenID',
	'openidserver' => 'Serwer OpenID',
	'openidxrds' => 'Yadis-dataja',
	'openidconvert' => 'Konwerter OpenID',
	'openiderror' => 'Pruwowanski zmylk',
	'openiderrortext' => 'Zmylk je při pruwowanju URL OpenID wustupił.',
	'openidconfigerror' => 'OpenID konfiguraciski zmylk',
	'openidconfigerrortext' => 'Składowanska konfiguracija OpenID zu tutón wiki je njepłaćiwy. Prošu skonsultuj administratora tutoho sydła.',
	'openidpermission' => 'Zmylk w prawach OpenID',
	'openidpermissiontext' => 'OpenID, kotryž sy podał, njesmě so za přizjewjenje pola tutoho serwera wužiwać.',
	'openidcancel' => 'Přepruwowanje přetorhnjene',
	'openidcanceltext' => 'Přepruwowanje URL OpenID bu přetorhnjene.',
	'openidfailure' => 'Přepruwowanje njeporadźiło',
	'openidfailuretext' => 'Přepruwowanje URL OpenID je so njeporadźiło. Zmylkowa zdźělenka: "$1"',
	'openidsuccess' => 'Přepruwowanje poradźiło',
	'openidsuccesstext' => 'Přepruwowanje URL OpenID je so poradźiło.',
	'openidusernameprefix' => 'Wužiwar OpenID',
	'openidserverlogininstructions' => 'Zapodaj deleka swoje hesło, zo by so pola $3 jako wužiwar $2 přizjewił (wužiwarska strona $1).',
	'openidtrustinstructions' => 'Pruwuj, hač chceš z $1 daty dźělić.',
	'openidallowtrust' => '$1 dowolić, zo by so tutomu wužiwarskemu konće dowěriło.',
	'openidnopolicy' => 'Sydło njeje zasady za priwatnosć podało.',
	'openidpolicy' => 'Pohladaj do <a target="_new" href="$1">zasadow priwatnosće</a> za dalše informacije.',
	'openidoptional' => 'Opcionalny',
	'openidrequired' => 'Trěbny',
	'openidnickname' => 'Přimjeno',
	'openidfullname' => 'Dospołne mjeno',
	'openidemail' => 'E-mejlowa adresa',
	'openidlanguage' => 'Rěč',
	'openidtimezone' => 'Časowe pasmo',
	'openidchooselegend' => 'Wuběr wužiwarskich mjenow',
	'openidchooseinstructions' => 'Wšitcy wužiwarjo trjebaja přimjeno; móžěs jedne z opcijow deleka wuzwolić.',
	'openidchoosenick' => 'Twoje přimjeno ($1)',
	'openidchoosefull' => 'Twoje dospołne mjeno ($1)',
	'openidchooseurl' => 'Mjeno wzate z twojeho OpenID ($1)',
	'openidchooseauto' => 'Awtomatisce wutworjene mjeno ($1)',
	'openidchoosemanual' => 'Mjeno twojeje wólby:',
	'openidchooseexisting' => 'Eksistowace konto na tutym wikiju',
	'openidchooseusername' => 'wužiwarske mjeno:',
	'openidchoosepassword' => 'hesło:',
	'openidconvertinstructions' => 'Tutón formular ći dowola swoje wužiwarske konto změnić, zo by URL OpenID wužiwał abo dalše URL OpenID přidał.',
	'openidconvertoraddmoreids' => 'OpenID konwertować abo dalši URL OpenID přidać',
	'openidconvertsuccess' => 'Wuspěšnje do OpenID konwertowany.',
	'openidconvertsuccesstext' => 'Sy swój OpenID wuspěšnje do $1 konwertował.',
	'openidconvertyourstext' => 'To je hižo twój OpenID.',
	'openidconvertothertext' => 'To je OpenID někoho druheho.',
	'openidalreadyloggedin' => "'''Sy hižo přizjewjeny, $1!'''

Jeli chceš OpenID wužiwać, hdyž přichodnje přizjewiš, móžeš [[Special:OpenIDConvert|swoje konto za wužiwanje OpenID konwertować]].",
	'openidnousername' => 'Žane wužiwarske mjeno podate.',
	'openidbadusername' => 'Wopačne wužiwarske mjeno podate.',
	'openidautosubmit' => 'Tuta strona wobsahuje formular, kotryž měł so awtomatisce wotpósłać, jeli sy JavaScript zmóžnił. Jeli nic, spytaj tłóčatko "Continue" (Dale).',
	'openidclientonlytext' => 'Njemóžeš konta z tutoho wikija jako OpenID na druhim sydle wužiwać.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => '{{SITENAME}} podpěruje standard [http://openid.net/ OpenID] za jednotliwe přizjewjenje mjez websydłami. OpenID ći zmóžnja so pola wjele rozdźělnych websydłow prizjewić, bjeztoho zo dyrbiš rozdźělne hesła wužiwać. (Hlej [http://en.wikipedia.org/wiki/OpenID nastawk OpenID wikipedije] za dalše informacije.)

Jeli maš hižo konto na {{GRAMMAR:lokatiw|{{SITENAME}}}}, móžeš so ze swojim wužiwarskim mjenjom a hesłom kaž přeco [[Special:UserLogin|přizjewić]].
Zo by OpenID w přichodźe wužiwał, móžeš [[Special:OpenIDConvert|swóje konto do OpenID konwertować]], po tym zo sy so normalnje přizjewił.

Je wjele [http://openid.net/get/ poskićowarjow OpenID], snano maš hižo konto z OpenID pola druheje słužby.',
	'openidupdateuserinfo' => 'Moje wosobinske informacije aktualizować:',
	'openiddelete' => 'OpenID wušmórnyć',
	'openiddelete-text' => 'Přez kliknjenje tłóčatka "{{int:openiddelete-button}}", wotstroniš OpenID $1 ze swojeho konta. Njemóžeš potom hižo so z tutym OpenID přizjewić.',
	'openiddelete-button' => 'Wobkrućić',
	'openiddeleteerrornopassword' => 'Njemóžeš wšě swoje OpenID zničić, dokelž twoje konto hesło nima.
Ty njemóhł so bjez OpenID přizjewić.',
	'openiddeleteerroropenidonly' => 'Njemóžeš wšě swoje OpenID zničić, dokelž njesměš so z OpenID přizjewić.
Ty njemóhł so bjez OpenID přizjewić.',
	'openiddelete-sucess' => 'OpenID je so wuspěšnje z twojeho konta wotstronił.',
	'openiddelete-error' => 'Při wotstronjenju OpenID z twojeho konto je zmólk wustupił.',
	'openid-prefstext' => 'Nastajenja [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Twój OpenID na twojej wužiwarskej stronje schować, jeli so z OpenID přizjewješ.',
	'openid-pref-update-userinfo-on-login' => 'Kóždy raz, hdyž so přizjawjam, slědowace informacije z identity OpenID aktualizować:',
	'openid-urls-desc' => 'OpenID, kotrež su z twojim kontom zwjazane:',
	'openid-urls-action' => 'Akcija',
	'openid-urls-delete' => 'Wušmórnyć',
	'openid-add-url' => 'Nowy OpenID přidać',
	'openidsigninorcreateaccount' => 'Přizjewić so abo nowe konto załožić',
	'openid-provider-label-openid' => 'Zapodaj swój URL OpenID',
	'openid-provider-label-google' => 'Z pomocu twojeho konta Google so přizjewić',
	'openid-provider-label-yahoo' => 'Z pomocu twojeho konta Yahoo so přizjewić',
	'openid-provider-label-aol' => 'Zapodaj swoje wužiwarske mjeno AOL',
	'openid-provider-label-other-username' => 'Zapodaj swoje wužiwarske mjeno $1',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author Tgr
 */
$messages['hu'] = array(
	'openid-desc' => 'Bejelentkezés [http://openid.net/ OpenID] azonosítóval, és más OpenID-kompatibilis weboldalak használata a wikis azonosítóval',
	'openidlogin' => 'Bejelentkezés OpenID-vel',
	'openidserver' => 'OpenID szerver',
	'openidxrds' => 'Yadis fájl',
	'openidconvert' => 'OpenID konverter',
	'openiderror' => 'Hiba az ellenőrzés során',
	'openiderrortext' => 'Az OpenID URL elenőrzése nem sikerült.',
	'openidconfigerror' => 'OpenID konfigurációs hiba',
	'openidconfigerrortext' => 'A wiki OpenID tárhelyének beállítása érvénytelen.
Lépj kapcsolatba egy [[Special:ListUsers/sysop|adminisztrátorral]].',
	'openidpermission' => 'OpenID jogosultság hiba',
	'openidpermissiontext' => 'Ezzel az OpenID-vel nem vagy jogosult belépni erre a wikire.',
	'openidcancel' => 'Ellenőrzés visszavonva',
	'openidcanceltext' => 'Az OpenID URL ellenőrzése vissza lett vonva.',
	'openidfailure' => 'Ellenőrzés sikertelen',
	'openidfailuretext' => 'Az OpenID URL ellenőrzése nem sikerült. A kapott hibaüzenet: „$1”',
	'openidsuccess' => 'Sikeres ellenőrzés',
	'openidsuccesstext' => 'Az OpenID URL ellenőrzése sikerült.',
	'openidusernameprefix' => 'OpenID-s szerkesztő',
	'openidserverlogininstructions' => 'Add meg a jelszót a(z) $3 oldalra való bejelentkezéshez $2 néven (userlap: $1).',
	'openidtrustinstructions' => 'Adatok megosztása a(z) $1 oldallal.',
	'openidallowtrust' => '$1 megbízhat ebben a felhasználóban.',
	'openidnopolicy' => 'Az oldalnak nincsen adatvédelmi szabályzata.',
	'openidpolicy' => 'További információkért lásd az <a target="_new" href="$1">adatvédelmi szabályzatot</a>.',
	'openidoptional' => 'Nem kötelező',
	'openidrequired' => 'Kötelező',
	'openidnickname' => 'Felhasználónév',
	'openidfullname' => 'Teljes név',
	'openidemail' => 'Email-cím',
	'openidlanguage' => 'Nyelv',
	'openidtimezone' => 'Időzóna',
	'openidchooselegend' => 'Felhasználónév választás',
	'openidchooseinstructions' => 'Mindenkinek választania kell egy felhasználónevet; választhatsz egyet az alábbi opciókból.',
	'openidchoosenick' => 'A nickneved ($1)',
	'openidchoosefull' => 'A teljes neved ($1)',
	'openidchooseurl' => 'Az OpenID-dből vett név ($1)',
	'openidchooseauto' => 'Egy automatikusan generált név ($1)',
	'openidchoosemanual' => 'Egy általad megadott név:',
	'openidchooseexisting' => 'Egy létező felhasználónév ezen a wikin',
	'openidchooseusername' => 'Felhasználónév:',
	'openidchoosepassword' => 'jelszó:',
	'openidconvertinstructions' => 'Ezzel az űrlappal átállíthatod a felhasználói fiókodat, hogy egy OpenId URL-t használjon, vagy hozzáadhatsz több OpenID URL-t',
	'openidconvertoraddmoreids' => 'Átalakítás OpenID-ra, vagy másik OpenID URL hozzáadása',
	'openidconvertsuccess' => 'Sikeres átállás OpenID-re',
	'openidconvertsuccesstext' => 'Sikeresen átállítottad az OpenID-det erre: $1.',
	'openidconvertyourstext' => 'Ez az OpenID már a tiéd.',
	'openidconvertothertext' => 'Ez az OpenID másvalakié.',
	'openidalreadyloggedin' => "'''Már be vagy jelentkezve, $1!'''

Ha ezentúl az OpenID-del akarsz bejelentkezni, [[Special:OpenIDConvert|konvertálhatod a felhasználói fiókodat OpenID-re]].",
	'openidnousername' => 'Nem adtál meg felhasználónevet.',
	'openidbadusername' => 'Rossz felhasználónevet adtál meg.',
	'openidautosubmit' => 'Az ezen az oldalon lévő űrlap automatikusan elküldi az adatokat, ha a JavaScript engedélyezve van. Ha nem, használd a "Continue" (Tovább) gombot.',
	'openidclientonlytext' => 'Az itteni felhasználónevedet nem használhatod OpenID-ként más weboldalon.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => 'A(z) {{SITENAME}} támogatja az [http://openid.net/ OpenID] szabványt a weboldalak közötti egységes bejelentkezéshez.
A OpenID lehetővé teszi, hogy számos különböző weboldalra jelentkezz be úgy, hogy csak egyszer kell megadnod a jelszavadat. (Lásd [http://hu.wikipedia.org/wiki/OpenID a Wikipédia OpenID cikkét] további információkért.)

Ha már regisztráltál korábban, [[Special:UserLogin|bejelentkezhetsz]] a felhasználóneveddel és a jelszavaddal, ahogy eddig is. Ha a továbbiakban OpenID-t szeretnél használni, [[Special:OpenIDConvert|állítsd át a felhasználói fiókodat OpenID-re]] miután bejelentkeztél.

Számos [http://openid.net/get/ OpenID szolgáltató] van, lehetséges, hogy van már OpenID-fiókod egy másik weboldalon.',
	'openidupdateuserinfo' => 'Személyes információk frissítése:',
	'openiddelete' => 'OpenID törlése',
	'openiddelete-text' => 'A {{int:openiddelete-button}} gomb megnyomásakor eltávolítod a következő OpenID-t a felhasználói fiókodból: $1.
Ezután többé nem fogsz tudni bejelentkezni ezzel az OpenID-vel.',
	'openiddelete-button' => 'Megerősítés',
	'openiddeleteerrornopassword' => 'Nem törölheted az összes OpenID-d, mert a felhasználói fiókodnak nincs jelszava.
Nem tudnál bejelentkezni OpenID nélkül.',
	'openiddeleteerroropenidonly' => 'Nem törölheted az összes OpenID-d, mert csak azzal jelentkezhetsz be.
Nem tudnál bejelentkezni OpenID nélkül.',
	'openiddelete-sucess' => 'Az OpenID sikeresen eltávolítva a felhasználói fiókodból.',
	'openiddelete-error' => 'Hiba történt az OpenID felhasználói fiókodból való eltávolításakor.',
	'openid-prefstext' => '[http://openid.net/ OpenID] beállítások',
	'openid-pref-hide' => 'Az OpenID-d elrejtése a felhasználói lapodon, amikor OpenID-vel jelentkezel be.',
	'openid-pref-update-userinfo-on-login' => 'A következő információ frissítése az OpenID fiókom alapján minden bejelentkezéskor:',
	'openid-urls-desc' => 'A felhasználói fiókodhoz kapcsolt OpenID-k:',
	'openid-urls-action' => 'Művelet',
	'openid-urls-delete' => 'Törlés',
	'openid-add-url' => 'Új OpenID hozzáadása',
	'openidsigninorcreateaccount' => 'Bejelentkezés vagy új felhasználói fiók létrehozása',
	'openid-provider-label-openid' => 'OpenID URL megadása',
	'openid-provider-label-google' => 'Bejelentkezés a Google felhasználói fiókoddal',
	'openid-provider-label-yahoo' => 'Bejelentkezés a Yahoo felhasználói fiókoddal',
	'openid-provider-label-aol' => 'Add meg az AOL felhasználóneved',
	'openid-provider-label-other-username' => 'Add meg a(z) $1 felhasználóneved',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'openid-desc' => 'Aperir un session in le wiki con [http://openid.net/ OpenID], e aperir un session in altere sitos web usante OpenID con un conto de usator del wiki',
	'openidlogin' => 'Aperir un session con OpenID',
	'openidserver' => 'Servitor OpenID',
	'openidxrds' => 'File Yadis',
	'openidconvert' => 'Convertitor de OpenID',
	'openiderror' => 'Error de verification',
	'openiderrortext' => 'Un error occurreva durante le verification del adresse URL de OpenID.',
	'openidconfigerror' => 'Error de configuration de OpenID',
	'openidconfigerrortext' => 'Le configuration de immagazinage OpenID pro iste wiki es invalide.
Per favor contacta un [[Special:ListUsers/sysop|administrator]].',
	'openidpermission' => 'Error de permissiones OpenID',
	'openidpermissiontext' => 'Le OpenID que tu forniva non ha le permission de aperir sessiones in iste servitor.',
	'openidcancel' => 'Verification cancellate',
	'openidcanceltext' => 'Le verification del adresse URL OpenID ha essite cancellate.',
	'openidfailure' => 'Verification fallite',
	'openidfailuretext' => 'Le verification del adresse URL de OpenID ha fallite. Message de error: "$1"',
	'openidsuccess' => 'Verification succedite',
	'openidsuccesstext' => 'Le verification del adresse URL de OpenID ha succedite.',
	'openidusernameprefix' => 'Usator OpenID',
	'openidserverlogininstructions' => 'Entra tu contrasigno in basso pro aperir un session in $3 como le usator $2 (pagina de usator: $1).',
	'openidtrustinstructions' => 'Controla si tu vole repartir datos con $1.',
	'openidallowtrust' => 'Permitte que $1 se fide a iste conto de usator.',
	'openidnopolicy' => 'Le sito non ha specificate un politica de confidentialitate.',
	'openidpolicy' => 'Consulta le <a target="_new" href="$1">politica de confidentialitate</a> pro plus informationes.',
	'openidoptional' => 'Optional',
	'openidrequired' => 'Requirite',
	'openidnickname' => 'Pseudonymo',
	'openidfullname' => 'Nomine integre',
	'openidemail' => 'Adresse de e-mail',
	'openidlanguage' => 'Lingua',
	'openidtimezone' => 'Fuso horari',
	'openidchooselegend' => 'Selection del nomine de usator',
	'openidchooseinstructions' => 'Tote le usatores require un pseudonymo;
tu pote seliger un del optiones in basso.',
	'openidchoosenick' => 'Tu pseudonymo ($1)',
	'openidchoosefull' => 'Tu nomine integre ($1)',
	'openidchooseurl' => 'Un nomine seligite de tu OpenID ($1)',
	'openidchooseauto' => 'Un nomine automaticamente generate ($1)',
	'openidchoosemanual' => 'Un nomine de tu preferentia:',
	'openidchooseexisting' => 'Un conto existente in iste wiki',
	'openidchooseusername' => 'Nomine de usator:',
	'openidchoosepassword' => 'contrasigno:',
	'openidconvertinstructions' => 'Iste formulario te permitte cambiar tu conto de usator pro usar un URL de OpenID o adder altere URL de OpenID.',
	'openidconvertoraddmoreids' => 'Converter in OpenID o adder un altere URL de OpenID',
	'openidconvertsuccess' => 'Conversion a OpenID succedite',
	'openidconvertsuccesstext' => 'Tu ha convertite con successo tu OpenID a $1.',
	'openidconvertyourstext' => 'Isto es ja tu OpenID.',
	'openidconvertothertext' => 'Isto es le OpenID de alcuno altere.',
	'openidalreadyloggedin' => "'''Tu es ja identificate, $1!'''

Si tu vole usar OpenID pro aperir un session in le futuro, tu pote [[Special:OpenIDConvert|converter tu conto pro usar OpenID]].",
	'openidnousername' => 'Nulle nomine de usator specificate.',
	'openidbadusername' => 'Mal nomine de usator specificate.',
	'openidautosubmit' => 'Iste pagina include un formulario que debe esser submittite automaticamente si tu ha JavaScript activate.
Si non, prova le button "Continue" (Continuar).',
	'openidclientonlytext' => 'Tu non pote usar contos ab iste wiki como contos OpenID in un altere sito.',
	'openidloginlabel' => 'Adresse URL de OpenID',
	'openidlogininstructions' => '{{SITENAME}} supporta le standard [http://openid.net/ OpenID] pro contos unificate inter sitos web.
OpenID te permitte aperir un session in multe diverse sitos web sin usar un differente contrasigno pro cata un.
(Vide [http://ia.wikipedia.org/wiki/OpenID le articulo super OpenID in Wikipedia] pro plus informationes.)

Si tu possede ja un conto in {{SITENAME}}, tu pote [[Special:UserLogin|aperir un session]] con tu nomine de usator e contrasigno como normal.
Pro usar OpenID in le futuro, tu pote [[Special:OpenIDConvert|converter tu conto a OpenID]] post que tu ha aperite un session normal.

Il ha multe [http://openid.net/get/ providitores de OpenID], e tu pote ja disponer de un conto con capacitate OpenID in un altere servicio.',
	'openidupdateuserinfo' => 'Actualisar mi informationes personal:',
	'openiddelete' => 'Deler OpenID',
	'openiddelete-text' => 'Per cliccar le button "{{int:openiddelete-button}}", tu removera le OpenID $1 de tu conto.
Tu non potera plus aperir un session con iste OpenID.',
	'openiddelete-button' => 'Confirmar',
	'openiddeleteerrornopassword' => 'Tu non pote deler tote tu OpenIDs proque tu conto non ha un contrasigno.
Il esserea impossibile aperir un session sin OpenID.',
	'openiddeleteerroropenidonly' => 'Tu non pote deler tote tu OpenIDs proque tu ha le permission de identificar te solmente con OpenID.
Il esserea impossibile aperir un session sin OpenID.',
	'openiddelete-sucess' => 'Le OpenID ha essite removite de tu conto con successo.',
	'openiddelete-error' => 'Un error occurreva durante le remotion del OpenID de tu conto.',
	'openid-prefstext' => 'Prreferentias de [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Celar tu OpenID in tu pagina de usator, si tu aperi un session con OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Actualisar le sequente informationes ab mi personage OpenID cata vice que io aperi un session:',
	'openid-urls-desc' => 'OpenIDs associate con tu conto:',
	'openid-urls-action' => 'Action',
	'openid-urls-delete' => 'Deler',
	'openid-add-url' => 'Adder un nove OpenID',
	'openidsigninorcreateaccount' => 'Aperir session o crear nove conto',
	'openid-provider-label-openid' => 'Entra le URL de tu OpenID',
	'openid-provider-label-google' => 'Aperir session con tu conto de Google',
	'openid-provider-label-yahoo' => 'Aperir session con tu conto de Yahoo',
	'openid-provider-label-aol' => 'Entra tu pseudonymo de AOL',
	'openid-provider-label-other-username' => 'Entra tu nomine de usator de $1',
);

/** Indonesian (Bahasa Indonesia)
 * @author -iNu-
 * @author Bennylin
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'openid-desc' => 'Masuk log ke wiki dengan sebuah [http://openid.net/ OpenID], dan masuk log ke situs web lain yang berbasis OpenID dengan sebuah akun pengguna wiki',
	'openidlogin' => 'Masuk log dengan OpenID',
	'openidserver' => 'Server OpenID',
	'openidxrds' => 'berkas Yadis',
	'openidconvert' => 'Konverter OpenID',
	'openiderror' => 'Verifikasi gagal',
	'openiderrortext' => 'Sebuah kesalahan terjadi ketika melakukan verifikasi atas URL OpenID.',
	'openidconfigerror' => 'Kesalahan konfigurasi OpenID',
	'openidconfigerrortext' => 'Konfigurasi penyimpanan OpenID di wiki ini tidak sah.
Silakan hubungi salah satu [[Special:ListUsers/sysop|administrator]].',
	'openidpermission' => 'Izin OpenID tidak sah',
	'openidpermissiontext' => 'OpenID yang Anda berikan tidak diperbolehkan untuk mengakses server ini.',
	'openidcancel' => 'Verifikasi dibatalkan',
	'openidcanceltext' => 'Verifikasi URL OpenID tersebut dibatalkan.',
	'openidfailure' => 'Verifikasi gagal',
	'openidfailuretext' => 'Verifikasi dari URL OpenID tersebut gagal.
Pesan kesalahan: "$1"',
	'openidsuccess' => 'Verifikasi berhasil',
	'openidsuccesstext' => 'Verifikasi dari URL OpenID tersebut berhasil.',
	'openidusernameprefix' => 'PenggunaOpenID',
	'openidserverlogininstructions' => 'Masukkan kata sandi Anda di bawah ini untuk masuk log ke $3 sebagai pengguna $2 (halaman pengguna $1).',
	'openidtrustinstructions' => 'Berikan tanda cek jika Anda ingin berbagi data dengan $1.',
	'openidallowtrust' => 'Izinkan $1 untuk mempercayai akun pengguna ini.',
	'openidnopolicy' => 'Situs ini tidak memiliki kebijakan privasi.',
	'openidpolicy' => 'Lihat <a target="_new" href="$1">kebijakan privasi</a> untuk informasi lebih lanjut.',
	'openidoptional' => 'Opsional',
	'openidrequired' => 'Diperlukan',
	'openidnickname' => 'Nama panggilan',
	'openidfullname' => 'Nama lengkap',
	'openidemail' => 'Alamat surel',
	'openidlanguage' => 'Bahasa',
	'openidtimezone' => 'Zona waktu',
	'openidchooseinstructions' => 'Semua pengguna memerlukan sebuah nama panggilan;
Anda dapat memilih dari salah satu opsi berikut.',
	'openidchoosefull' => 'Nama lengkap Anda ($1)',
	'openidchooseurl' => 'Sebuah nama diambil dari OpenID Anda ($1)',
	'openidchooseauto' => 'Nama yang dibuat secara otomatis ($1)',
	'openidchoosemanual' => 'Nama pilihan Anda:',
	'openidchooseexisting' => 'Akun yang telah ada di wiki ini',
	'openidchoosepassword' => 'kata sandi:',
	'openidconvertinstructions' => 'Formulir ini mengijinkan Anda untuk mengganti akun pengguna Anda menjadi OpenID atau menambahkan pranala OpenID',
	'openidconvertoraddmoreids' => 'Konversi ke OpenID atau tambahkan URL OpenID yang lain',
	'openidconvertsuccess' => 'Berhasil dikonversi menjadi OpenID',
	'openidconvertsuccesstext' => 'Anda telah berhasil mengkonversi OpenID Anda menjadi $1.',
	'openidconvertyourstext' => 'Sudah merupakan OpenID Anda.',
	'openidconvertothertext' => 'Itu adalah OpenID orang lain.',
	'openidalreadyloggedin' => "'''Anda telah masuk log, $1!'''

Jika Anda ingin menggunakan OpenID untuk masuk log di masa yang akan datang, Anda dapat [[Special:OpenIDConvert|mengkonversi akun Anda menjadi OpenID]].",
	'openidnousername' => 'Tidak ada nama pengguna diberikan.',
	'openidbadusername' => 'Nama pengguna salah.',
	'openidautosubmit' => 'Dalam halaman ini terdapat formulir yang akan dikirimkan secara otomatis jika Anda mengaktifkan JavaScript.
Jika tidak, coba tombol "Continue" (Lanjutkan).',
	'openidclientonlytext' => 'Anda tidak dapat menggunakan akun dari wiki ini sebagai OpenID di situs lain.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => '{{SITENAME}} ini mendukung standar [http://openid.net/ OpenID] untuk masuk log lintas situs Web.
OpenID mengizinkan Anda untuk masuk log di berbagai situs Web tanpa harus memasukkan kata sandi yang berbeda.
(Lihat [http://id.wikipedia.org/wiki/OpenID artikel Wikipedia mengenai OpenID] untuk informasi lebih lanjut.)

Jika Anda telah memiliki akun di {{SITENAME}}, Anda dapat [[Special:UserLogin|masuk log]] dengan nama pengguna dan kata sandi Anda seperti biasa.
Untuk menggunakan OpenID di masa yang akan datang, Anda dapat [[Special:OpenIDConvert|mengkonversi akun Anda menjadi OpenID]] setelah Anda masuk log seperti biasa.

Ada banyak [http://openid.net/get penyedia OpenID], dan Anda mungkin telah memiliki akun OpenID di salah satu layanan situs lain.',
	'openidupdateuserinfo' => 'Mutakhirkan informasi pribadi saya:',
	'openiddelete' => 'Hapus OpenID',
	'openiddelete-text' => 'Dengan menekan tombol "{{int:openiddelete-button}}", Anda akan menghapuskan OpenID $1 dari akun Anda.
Anda tidak akan dapat masuk log lagi dengan OpenID ini.',
	'openiddelete-button' => 'Konfirmasi',
	'openiddelete-sucess' => 'OpenID telah dihapus dari akun Anda.',
	'openiddelete-error' => 'Terjadi kesalahan saat berusaha menghapus OpenID dari akun Anda.',
	'openid-prefstext' => 'Preferensi [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Sembunyikan URL OpenID Anda di halaman pengguna Anda, jika Anda masuk log dengan OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Mutakhirkan informasi dari persona OpenID berikut setiap kali saya masuk log:',
	'openid-urls-desc' => 'OpenID yang dihubungkan dengan akun Anda:',
	'openid-urls-action' => 'Tindakan',
	'openid-urls-delete' => 'Hapus',
	'openid-add-url' => 'Tambahkan OpenID baru',
	'openidsigninorcreateaccount' => 'Log Masuk atau Daftarkan Akun Baru',
	'openid-provider-label-openid' => 'Masukkan URL OpenID Anda',
	'openid-provider-label-google' => 'Log masuk mengunakan akun Google Anda',
	'openid-provider-label-yahoo' => 'Log masuk mengunakan akun Yahoo Anda',
	'openid-provider-label-aol' => 'Masukkan nama pengguna AOL Anda',
	'openid-provider-label-other-username' => 'Masukkan nama pengguna $1 Anda',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'openidchoosepassword' => 'lykilorð:',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author McDutchie
 * @author Nemo bis
 * @author Pietrodn
 * @author Stefano-c
 */
$messages['it'] = array(
	'openid-desc' => 'Effettua il login alla wiki con [http://openid.net/ OpenID] e agli altri siti web che utilizzano OpenID con un account wiki',
	'openidlogin' => 'Login con OpenID',
	'openidserver' => 'server OpenID',
	'openidxrds' => 'file Yadis',
	'openidconvert' => 'convertitore OpenID',
	'openiderror' => 'Errore di verifica',
	'openiderrortext' => "Si è verificato un errore durante la verifica dell'URL OpenID.",
	'openidconfigerror' => 'Errore nella configurazione OpenID',
	'openidconfigerrortext' => 'La configurazione della memorizzazione di OpenID per questa wiki non è valida.
Per favore consulta un [[Special:ListUsers/sysop|amministratore]].',
	'openidpermission' => 'Errore nei permessi OpenID',
	'openidpermissiontext' => "L'accesso a questo server non è consentito all'OpenID indicato.",
	'openidcancel' => 'Verifica annullata',
	'openidcanceltext' => "La verifica dell'URL OpenID è stata annullata.",
	'openidfailure' => 'Verifica fallita',
	'openidfailuretext' => 'La verifica dell\'URL OpenID è fallita. Messaggio di errore: "$1"',
	'openidsuccess' => 'Verifica effettuata',
	'openidsuccesstext' => "La verifica dell'URL OpenID è stata effettuata con successo.",
	'openidusernameprefix' => 'Utente OpenID',
	'openidserverlogininstructions' => 'Inserisci di seguito la tua password per effettuare il login a $3 come utente $2 (pagina utente $1).',
	'openidtrustinstructions' => 'Controlla se desideri condividere i dati con $1.',
	'openidallowtrust' => 'Permetti a $1 di fidarsi di questo account utente.',
	'openidnopolicy' => 'Il sito non ha specificato una politica relativa alla privacy.',
	'openidpolicy' => 'Controlla la <a target="_new" href="$1">politica relativa alla privacy</a> per maggiori informazioni.',
	'openidoptional' => 'Opzionale',
	'openidrequired' => 'Richiesto',
	'openidnickname' => 'Nickname',
	'openidfullname' => 'Nome completo',
	'openidemail' => 'Indirizzo e-mail',
	'openidlanguage' => 'Lingua',
	'openidtimezone' => 'Fuso orario',
	'openidchooseinstructions' => 'Tutti gli utenti hanno bisogno di un nickname;
puoi sceglierne uno dalle opzioni seguenti.',
	'openidchoosefull' => 'Il tuo nome completo ($1)',
	'openidchooseurl' => 'Un nome scelto dal tuo OpenID ($1)',
	'openidchooseauto' => 'Un nome auto-generato ($1)',
	'openidchoosemanual' => 'Un nome di tua scelta:',
	'openidchooseexisting' => 'Un account esistente su questa wiki:',
	'openidchoosepassword' => 'password:',
	'openidconvertinstructions' => 'Questo modulo permette di cambiare il proprio account per usare un URL OpenID o aggiungere altri URL OpenID.',
	'openidconvertoraddmoreids' => 'Converti in OpenID o aggiungi un altro URL OpenID',
	'openidconvertsuccess' => 'Convertito con successo a OpenID',
	'openidconvertsuccesstext' => 'Il tuo OpenID è stato convertito con successo a $1.',
	'openidconvertyourstext' => 'Questo è già il tuo OpenID.',
	'openidconvertothertext' => "Questo è l'OpenID di qualcun altro.",
	'openidalreadyloggedin' => "'''Hai già effettuato il login, $1!'''

Se desideri usare OpenID per effettuare il login in futuro, puoi [[Special:OpenIDConvert|convertire il tuo account per utilizzare OpenID]].",
	'openidnousername' => 'Nessun nome utente specificato.',
	'openidbadusername' => 'Nome utente specificato errato.',
	'openidautosubmit' => 'Questa pagina include un modulo che dovrebbe essere inviato automaticamente se hai JavaScript attivato. Se non lo è, prova a premere il pulsante "Continue".',
	'openidclientonlytext' => 'Non puoi usare gli account di questa wiki come OpenID su un altro sito.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => '{{SITENAME}} supporta lo standard [http://openid.net/ OpenID] per il login unico sui siti web.
OpenID consente di effettuare la registrazione su molti siti web senza dover utilizzare una password diversa per ciascuno.
(Leggi la [http://it.wikipedia.org/wiki/OpenID voce di Wikipedia su OpenID] per maggiori informazioni.)

Chi possiede già un account su {{SITENAME}} può effettuare il [[Special:UserLogin|login]] con il proprio nome utente e la propria password come al solito. Per utilizzare OpenID in futuro, si può [[Special:OpenIDConvert|convertire il proprio account a OpenID]] dopo aver effettuato normalmente il login.

Esistono molti [http://openid.net/get/ Provider OpenID]; è possibile che tu abbia già un account abilitato a OpenID su un altro servizio.',
	'openidupdateuserinfo' => 'Aggiorna le mie informazioni personali',
	'openiddelete' => 'Cancella OpenID',
	'openiddelete-text' => 'Facendo clic sul pulsante "{{int:openiddelete-button}}" verrà rimosso l\'OpenID $1 dal proprio account.
Non si potrà più effettuare il login con questo OpenID.',
	'openiddelete-button' => 'Conferma',
	'openiddelete-sucess' => "L'OpenID è stato rimosso con successo dall'account.",
	'openiddelete-error' => "Si è verificato un errore durante la rimozione dell'account OpenID.",
	'openid-prefstext' => 'Preferenze [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Nascondi il tuo OpenID sulla tua pagina utente, se effettui il login con OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Aggiorna le seguenti informazioni dalla persona OpenID a ogni accesso:',
	'openid-urls-desc' => 'OpenID associati al proprio account:',
	'openid-urls-action' => 'Azione',
	'openid-urls-delete' => 'Cancella',
	'openid-add-url' => 'Aggiungi un nuovo OpenID',
	'openidsigninorcreateaccount' => 'Entra o crea un nuovo account',
	'openid-provider-label-openid' => "Inserisci l'URL del tuo OpenID",
	'openid-provider-label-google' => 'Accedi utilizzando il tuo account Google',
	'openid-provider-label-yahoo' => 'Accedi utilizzando il tuo account Yahoo',
	'openid-provider-label-aol' => 'Inserisci il tuo screenname AOL',
	'openid-provider-label-other-username' => 'Inserisci il tuo $1 nome utente',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'openid-desc' => '[http://openid.net/ OpenID]によるウィキへのログインを可能にし、ウィキユーザーアカウントを他のOpenID対応サイトにログインすることを可能にする。',
	'openidlogin' => 'OpenIDでログイン',
	'openidserver' => 'OpenID サーバー',
	'openidxrds' => 'Yadis ファイル',
	'openidconvert' => 'OpenID コンバーター',
	'openiderror' => '検証エラー',
	'openiderrortext' => 'OpenID URLの検証中にエラーが発生しました。',
	'openidconfigerror' => 'OpenID設定エラー',
	'openidconfigerrortext' => 'このウィキの OpenID 格納設定は無効です。[[Special:ListUsers/sysop|管理者]]に相談してください。',
	'openidpermission' => 'OpenID パーミッション・エラー',
	'openidpermissiontext' => 'あなたが与えた OpenID はこのサーバーにログインすることを許可されていません。',
	'openidcancel' => '検証中止',
	'openidcanceltext' => 'OpenID URLの検証は中止されました。',
	'openidfailure' => '検証失敗',
	'openidfailuretext' => 'OpenID URLの検証は失敗しました。エラーメッセージ: "$1"',
	'openidsuccess' => '検証成功',
	'openidsuccesstext' => 'OpenID URLの検証は成功しました。',
	'openidusernameprefix' => 'OpenIDユーザー',
	'openidserverlogininstructions' => '$3 に利用者 $2 (利用者ページ $1) としてログインするには以下にパスワードを入力してください。',
	'openidtrustinstructions' => '$1 とデータを共有したいか確認してください。',
	'openidallowtrust' => '$1 がこの利用者アカウントを信用するのを許可する。',
	'openidnopolicy' => 'サイトはプライバシーに関する方針を明記していません。',
	'openidpolicy' => 'より詳しくは<a target="_new" href="$1">プライバシーに関する方針</a>を確認してください。',
	'openidoptional' => '省略可能',
	'openidrequired' => '必須',
	'openidnickname' => 'ニックネーム',
	'openidfullname' => 'フルネーム',
	'openidemail' => '電子メールアドレス',
	'openidlanguage' => '言語',
	'openidtimezone' => 'タイムゾーン',
	'openidchooselegend' => '利用者名の選択',
	'openidchooseinstructions' => 'すべての利用者はニックネームが必要です。以下の選択肢から1つを選ぶことができます。',
	'openidchoosenick' => 'あなたのニックネーム（$1）',
	'openidchoosefull' => 'あなたのフルネーム ($1)',
	'openidchooseurl' => 'あなたの OpenID から選んだ名前 ($1)',
	'openidchooseauto' => '自動生成された名前 ($1)',
	'openidchoosemanual' => '名前を別に設定する:',
	'openidchooseexisting' => 'このウィキに存在するアカウント',
	'openidchooseusername' => '利用者名：',
	'openidchoosepassword' => 'パスワード:',
	'openidconvertinstructions' => 'このフォームを使うと、あなたの利用者アカウントで OpenID URL を使うように変更するか、OpenID URL をさらに追加できます。',
	'openidconvertoraddmoreids' => 'OpenID か別の OpenID URL に変換する',
	'openidconvertsuccess' => 'OpenID への変換に成功しました',
	'openidconvertsuccesstext' => 'あなたは OpenID の $1 への変換に成功しました。',
	'openidconvertyourstext' => 'これは既にあなたの OpenID です。',
	'openidconvertothertext' => 'これは他の誰かの OpenID です。',
	'openidalreadyloggedin' => "'''$1 さん、あなたは既にログインしています！'''

将来は OpenID を使ってログインしたい場合は、[[Special:OpenIDConvert|あなたのアカウントを OpenID を使うように変換する]]ことができます。",
	'openidnousername' => '利用者名が指定されていません。',
	'openidbadusername' => '利用者名の指定が不正です。',
	'openidautosubmit' => 'このページにあるフォームはあなたが JavaScript を有効にしていれば自動的に送信されるはずです。そうならない場合は、 "Continue" (続ける) ボタンを試してください。',
	'openidclientonlytext' => 'あなたはこのウィキのアカウントを他のサイトで OpenID として使うことができません。',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => '{{SITENAME}} はウェブサイト間でのシングルサインオンのための [http://openid.net/ OpenID] 規格に対応しています。OpenID によって、個別のパスワードを使うことなく、たくさんの様々なウェブサイトにログインできるようになります(より詳しい情報は[http://ja.wikipedia.org/wiki/OpenID ウィキペディアの OpenID についての記事]を参照してください)。

あなたが既に {{SITENAME}} でアカウントをもっている場合は、いつもどおりに利用者名とパスワードで[[Special:UserLogin|ログイン]]できます。将来、OpenID を使うためには、通常のログインをした後で[[Special:OpenIDConvert|あなたのアカウントを OpenID に変換する]]ことができます。

多くの [http://openid.net/get/ OpenID プロバイダー]が存在し、あなたは既に別のサービスで OpenID が有効となったアカウントを保持しているかもしれません。',
	'openidupdateuserinfo' => '自分の個人情報を更新:',
	'openiddelete' => 'OpenID を削除',
	'openiddelete-text' => '「{{int:openiddelete-button}}」ボタンをクリックすると、あなたのアカウントから OpenID $1 を除去します。以降、あなたはこの OpenID を使ってログインすることができなくなります。',
	'openiddelete-button' => '確定',
	'openiddelete-sucess' => 'この OpenID のあなたのアカウントからの除去に成功しました。',
	'openiddelete-error' => 'あなたのアカウントからこの OpenID を除去している途中でエラーが発生しました。',
	'openid-prefstext' => '[http://openid.net/ OpenID] の設定',
	'openid-pref-hide' => 'OpenID でログインしている場合に、あなたの OpenID をあなたの利用者ページで表示しない。',
	'openid-pref-update-userinfo-on-login' => 'ログインするたびに、次の情報を OpenID のペルソナから更新する:',
	'openid-urls-desc' => 'あなたのアカウントに関連づけられた OpenID:',
	'openid-urls-action' => '操作',
	'openid-urls-delete' => '削除',
	'openid-add-url' => '新しい OpenID を追加',
	'openidsigninorcreateaccount' => 'サインインあるいは新規アカウントの作成',
	'openid-provider-label-openid' => 'あなたの OpenID URL を入力します',
	'openid-provider-label-google' => 'あなたの Google アカウントを用いてログインする',
	'openid-provider-label-yahoo' => 'あなたの Yahoo アカウントを用いてログインする',
	'openid-provider-label-aol' => 'あなたの AOL スクリーンネームを入力します',
	'openid-provider-label-other-username' => 'あなたの $1 での利用者名を入力します',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'openidxrds' => 'Berkas Yadis',
	'openiderror' => 'Kaluputan vérifikasi',
	'openidcancel' => 'Vérifikasi dibatalaké',
	'openidfailure' => 'Vérifikasi gagal',
	'openidtrustinstructions' => 'Mangga dipriksa yèn panjenengan péngin mbagi data karo $1.',
	'openidallowtrust' => 'Marengaké $1 percaya karo rékening panganggo iki.',
	'openidnopolicy' => 'Situs iki durung spésifikasi kawicaksanan privasi.',
	'openidoptional' => 'Opsional',
	'openidrequired' => 'Diperlokaké',
	'openidnickname' => 'Jeneng sesinglon',
	'openidfullname' => 'Jeneng jangkep',
	'openidemail' => 'Alamat e-mail',
	'openidlanguage' => 'Basa',
	'openidchooseinstructions' => 'Kabèh panganggo prelu jeneng sesinglon;
panjenengan bisa milih salah siji saka opsi ing ngisor iki.',
	'openidchoosefull' => 'Jeneng pepak panjenengan ($1)',
	'openidchooseauto' => 'Jeneng ($1) sing digawé sacara otomatis',
	'openidchoosemanual' => 'Jeneng miturut pilihan panjenengan:',
	'openidchoosepassword' => 'tembung sandhi:',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'openidtimezone' => 'სასაათო სარტყელი',
);

/** Kirmanjki (Kırmancki)
 * @author Mirzali
 */
$messages['kiu'] = array(
	'openidlanguage' => 'Zon',
	'openidtimezone' => 'Warê sate',
);

/** Kalaallisut (Kalaallisut)
 * @author Qaqqalik
 */
$messages['kl'] = array(
	'openidlanguage' => 'Oqaatsit',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author T-Rithy
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'openidconvert' => 'កម្មវិធីបម្លែងOpenID',
	'openiderror' => 'កំហុស​ក្នុងការផ្ទៀងផ្ទាត់',
	'openidcancel' => 'ការផ្ទៀងផ្ទាត់​ត្រូវបានលុបចោល',
	'openidfailure' => 'ការផ្ទៀងផ្ទាត់បរាជ័យ',
	'openidsuccess' => 'ផ្ទៀងផ្ទាត់ដោយជោគជ័យ',
	'openidtrustinstructions' => 'ចូរ​ពិនិត្យ ប្រសិនបើ​អ្នក​ចង់​ចែករំលែក​ទិន្នន័យ​ជាមួយ $1​។',
	'openidoptional' => 'ជាជម្រើស',
	'openidrequired' => 'ត្រូវការជាចាំបាច់',
	'openidnickname' => 'ឈ្មោះហៅក្រៅ',
	'openidfullname' => 'ឈ្មោះពេញ',
	'openidemail' => 'អាសយដ្ឋានអ៊ីមែល',
	'openidlanguage' => 'ភាសា',
	'openidchooseinstructions' => 'អ្នកប្រើប្រាស់ទាំងត្រូវការឈ្មោះហៅក្រៅ

អ្នកអាចជ្រើសរើសពីក្នុងជម្រើសខាងក្រោម។',
	'openidchoosefull' => 'ឈ្មោះពេញ​របស់អ្នក ($1)',
	'openidchoosemanual' => 'ឈ្មោះនៃជម្រើសរបស់អ្នក:',
	'openidchooseexisting' => 'គណនីមាននៅក្នុងវិគីនេះ:',
	'openidchoosepassword' => 'ពាក្យសំងាត់៖',
	'openidconvertsuccess' => 'បានបម្លែងទៅ OpenID ដោយជោគជ័យ',
	'openidconvertyourstext' => 'វាជាOpenIDរបស់អ្នករួចហើយ។',
	'openidconvertothertext' => 'វាជាOpenIDរបស់អ្នកដទៃ។',
	'openidalreadyloggedin' => "'''អ្នកបានឡុកអ៊ីនរួចហើយ $1!'''
ប្រសិនបើអ្នកចង់់ប្រើ OpenID ដើម្បីឡុកអ៊ីននាពេលអនាគត អ្នកអាច[[Special:OpenIDConvert|បម្លែងគណនីរបស់អ្នកដើម្បីប្រើ OpenID]]។",
	'openidnousername' => 'មិនមានឈ្មោះអ្នកប្រើប្រាស់បានបញ្ជាក់ទេ។',
	'openidbadusername' => 'ឈ្មោះមិនត្រឹមត្រូវត្រូវបានបញ្ជាក់',
	'openid-pref-hide' => 'លាក់OpenIDរបស់អ្នកនៅលើទំព័រអ្នកប្រើប្រាស់របស់អ្នក ប្រសិនបើអ្នកឡុកអ៊ីនដោយប្រើOpenID។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'openidlanguage' => 'ಭಾಷೆ',
	'openidtimezone' => 'ಸಮಯ ವಲಯ',
);

/** Korean (한국어)
 * @author Ficell
 * @author Kwj2772
 * @author happyday19c
 */
$messages['ko'] = array(
	'openid-desc' => '[http://openid.net/ OpenID]를 통한 로그인이 가능합니다. 또한 위키 사용자 계정을 통해 OpenID를 지원하는 다른 사이트에도 로그인이 가능합니다.',
	'openidlogin' => 'OpenID로 로그인',
	'openidserver' => 'OpenID 서버',
	'openidxrds' => 'Yadis 파일',
	'openidconvert' => 'OpenID 변환기',
	'openiderror' => '인증 오류가 발생했습니다.',
	'openiderrortext' => 'OpenID URL을 인증하는 과정에 오류가 발생하였습니다.',
	'openidconfigerror' => 'OpenID 설정 오류',
	'openidconfigerrortext' => 'OpenID 계정 정보 저장소에 문제가 발생하였습니다. [[Special:ListUsers/sysop|{{SITENAME}} 관리자]]에게 문의하시기 바랍니다.',
	'openidpermission' => 'OpenID 권한 오류',
	'openidpermissiontext' => '제출한 OpenID는 위키 접속을 지원하지 않습니다.',
	'openidcancel' => '인증 취소',
	'openidcanceltext' => 'OpenID 인증이 취소되었습니다.',
	'openidfailure' => '인증 실패',
	'openidfailuretext' => 'OpenID 인증이 실패하였습니다. 오류 메시지 : "$1"',
	'openidsuccess' => '인증 성공',
	'openidsuccesstext' => '성공적으로 OpenID URL이 인증되었습니다.',
	'openidserverlogininstructions' => '유저 $2로서 $3에 로그인하기 위한 암호를 입력하십시오. (사용자 페이지 $1)',
	'openidtrustinstructions' => '$1과 데이터를 공유하려면 체크하십시오.',
	'openidallowtrust' => '$1이 이 사용자 계정을 신뢰함.',
	'openidnopolicy' => '사이트가 개인 정보 보호 정책을 제시하지 않았습니다.',
	'openidpolicy' => '자세한 사항은 <a target="_new" href="$1">개인 정보 보호 정책</a>을 참고하십시오.',
	'openidoptional' => '선택 사항',
	'openidrequired' => '필수 사항',
	'openidnickname' => '별명',
	'openidfullname' => '전체이름',
	'openidemail' => '메일 주소',
	'openidlanguage' => '언어',
	'openidtimezone' => '시간대',
	'openidchooseinstructions' => '모든 사용자는 별명을 가져야 합니다.
아래의 옵션 중 하나를 선택할 수 있습니다..',
	'openidchoosefull' => '전체 이름은 ($1)',
	'openidchooseurl' => 'OpenID로 부터 선택한 이름 ($1)',
	'openidchooseauto' => '자동 생성된 이름 ($1)',
	'openidchoosemanual' => '선택하신 이름:',
	'openidchooseexisting' => '위키에 이미 존재하는 계정입니다:',
	'openidchoosepassword' => '암호:',
	'openidconvertinstructions' => '이 양식은 OpenID URL을 통한 로그인을 설정하거나 OpenID URL을 추가하기 위한 곳입니다.',
	'openidconvertoraddmoreids' => 'OpenID로 변환하거나 OpenID URL을 추가합니다.',
	'openidconvertsuccess' => 'OpenID로의 변환이 완료되었습니다',
	'openidconvertsuccesstext' => '성공적으로 제출하신 [$1 OpenID 정보]를 {{SITENAME}} 계정 정보로 변환하였습니다.',
	'openidconvertyourstext' => '이미 사용중인 OpenID입니다.',
	'openidconvertothertext' => '다른 사용자의 OpenID입니다.',
	'openidalreadyloggedin' => "'''이미 $1로 로그인하셨습니다!'''

추후 OpenID를 사용하고자 하신다면, 일반적인 방법으로 로그인 하신 후 [[Special:OpenIDConvert|사용자 계정을 OpenID로 변환]]할 수 있습니다.",
	'openidnousername' => '사용자명을 지정하지 않았습니다.',
	'openidbadusername' => '잘못된 사용자명을 지정하셨습니다.',
	'openidautosubmit' => '자바 스크립트가 허용된 경우 자동으로 데이터가 전송됩니다..
	만약 자동으로 로그인되지 않는다면 ""계속"" 버튼을 눌러주세요.',
	'openidclientonlytext' => '{{SITENAME}}은 OpenID 서비스 제공자로서 동작하지 않습니다.',
	'openidloginlabel' => 'OpenID URL 주소',
	'openidlogininstructions' => '{{SITENAME}}에서는 다양한 웹사이트에서의 Single Sign-On을 지원하는 [http://openid.net/ OpenID] 로그인 기능을 제공합니다.
OpenID는 다른 많은 웹사이트에서 서로 다른 암호나 사용자명을 입력하는 불편없이 편리하게 로그인할 수 있도록 도와줍니다.
(OpenID에 대한 자세한 정보는 [http://ko.wikipedia.org/wiki/OpenID 위키피디아 OpenID 문서]를 참고하세요.)

이미 {{SITENAME}}에 계정을 가지고 계신 경우, 일반적인 방법으로 [[Special:UserLogin|로그인]]이 가능합니다.
추후 OpenID를 사용하고자 하신다면, 일반적인 방법으로 로그인 하신 후 [[Special:OpenIDConvert|사용자 계정을 OpenID로 변환]]할 수 있습니다.

다양한 사이트에서 [http://openid.net/get/ OpenID 서비스]를 제공하며, 이미 사용중인 다른 서비스가 OpenID 서비스를 제공할 수도 있습니다.',
	'openidupdateuserinfo' => '내 사용자 정보를 갱신하기',
	'openiddelete' => 'OpenID 삭제',
	'openiddelete-text' => '"{{int:openiddelete-button}}" 버튼을 누르시면, [$1 OpenID 정보]를 당신의 사용자 계정으로부터 삭제할 것입니다.
이후 OpenID를 통한 현재 사용자 계정으로의 로그인이 불가능하게 될 것입니다.',
	'openiddelete-button' => '확인',
	'openiddelete-sucess' => '사용자 계정으로부터 OpenID 정보가 삭제되었습니다. [[특수기능:OpenIDConvert|OpenID 변환]] 페이지로 돌아갑니다.',
	'openiddelete-error' => '사용자 계정으로부터 OpenID 정보를 삭제하는 과정에 오류가 발생하였습니다.',
	'prefs-openid' => 'OpenID 설정',
	'openid-prefstext' => '[http://openid.net/ OpenID] 사용사 설정',
	'openid-pref-hide' => 'OpenID로 로그인한 경우, 사용자 페이지에서 OpenID 정보를 보여주지 않습니다.',
	'openid-pref-update-userinfo-on-login' => '로그인 시 업데이트 할 OpenID 정보 :',
	'openid-urls-desc' => '현재 열결된 OpenID 계정 목록 :',
	'openid-urls-url' => 'URL 주소',
	'openid-urls-action' => '동작',
	'openid-urls-delete' => '삭제',
	'openid-add-url' => '새 OpenID 추가하기',
	'openidsigninorcreateaccount' => '로그인 또는 새 계정 생성',
	'openid-provider-label-openid' => 'OpenID URL을 입력하십시오',
	'openid-provider-label-google' => '구글 계정을 통해 로그인하기',
	'openid-provider-label-yahoo' => '야후 계정을 통해 로그인하기',
	'openid-provider-label-aol' => 'AOL 사용자명 을입력하십시오',
	'openid-provider-label-other-username' => '$1 사용자명을 입력하십시오',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'openid-desc' => 'Heh em Wiki met ener [http://openid.net/ OpenID] enlogge, un angerschwoh, woh mer OpenID kennt, met enem Metmaacher-Name fun heh fum Wiki enlogge.',
	'openidlogin' => 'Met OpenID enlogge',
	'openidserver' => 'OpenID Server',
	'openidxrds' => 'Yadis-Dattei',
	'openidconvert' => 'OpenID Ömsetzer',
	'openiderror' => 'Fähler beim Pröfe',
	'openiderrortext' => 'Ene Fähler es opjetrodde beim Pröfe fun de OpenID URL.',
	'openidconfigerror' => 'Fähler en dä Aat, wi OpenID opjesaz es',
	'openidconfigerrortext' => 'Dem OpenID sing Enstellung för Date affzelääje es nit en Odenung.
Beß esu joot un don enem [[Special:ListUsers/sysop|Wiki-Köbes]] dofun verzälle.',
	'openidpermission' => 'Fähler mem Rääsch en OpenID',
	'openidpermissiontext' => 'Met de aanjejovve OpenID darrfs de hee ävver nit enlogge.',
	'openidcancel' => 'Övverpröfung affjebroche',
	'openidcanceltext' => 'De Övverpröfung fun dä OpenID URL woht affjebroche.',
	'openidfailure' => 'Övverpröfung jingk donevve',
	'openidfailuretext' => 'De Pröfung fun de OpenID URL es donevve jejange.
Dä Fähler wohr: „$1“',
	'openidsuccess' => 'De Pröfung hät jeflupp',
	'openidsuccesstext' => 'De Pröfung fun dä OpenID URL hät jot jejange.',
	'openidusernameprefix' => 'OpenID Metmaacher',
	'openidserverlogininstructions' => 'Donn Ding Passwoot onge enjävve, öm als dä Metmaacher $2 op $3 enzelogge — de Metmaacher-Sigg es $1.',
	'openidtrustinstructions' => 'Loor, ov De de Date met $1 deile wells.',
	'openidallowtrust' => 'Donn däm $1 zojestonn, däm Metmaacher ze verdraue.',
	'openidnopolicy' => 'Die Websait udder dä Server hät nix aanjejovve övver der Schotz fun private Date.',
	'openidpolicy' => 'Loor Der de <a target="_new" href="$1">Räjele för der Schotz fun private Date</a> aan, wann De mieh do drövver wesse wels.',
	'openidoptional' => 'Nit nüdesch',
	'openidrequired' => 'Nüdesch',
	'openidnickname' => 'Spetznam',
	'openidfullname' => 'Der janze Name',
	'openidemail' => 'De e-mail Address',
	'openidlanguage' => 'Sproch',
	'openidtimezone' => 'Zickzohn',
	'openidchooseinstructions' => 'Jede Metmaacher bruch enne Spetznam,
Do kannß Der der Dinge unge druß üßsöke.',
	'openidchoosefull' => 'Dinge komplätte Name ($1)',
	'openidchooseurl' => 'Enne Name uß Dinge OpenID eruß jejreffe ($1)',
	'openidchooseauto' => 'Enne automattesch zerääsch jemaate Name ($1)',
	'openidchoosemanual' => 'Ene Name, dä De Der sellver ußjedaach un jejovve häs:',
	'openidchooseexisting' => 'Ene Metmaachername, dä et alld jitt op däm Wiki hee:',
	'openidchoosepassword' => 'Paßwoot:',
	'openidconvertinstructions' => 'He kanns De Ding Aanmeldung als ene Metmaacher esu aanpasse, dat De en <i lang="en">OpenID</i> <i lang="en">URL</i> bruche kanns.
Do kanns och noch mieh <i lang="en">OpenID</i> <i lang="en">URLs</i> dobei donn.',
	'openidconvertoraddmoreids' => 'Op <i lang="en">OpenID</i> ömshtelle, udder en <i lang="en">OpenID URL</i> dobei donn',
	'openidconvertsuccess' => 'De Aanpassung aan OpenID hät jeklapp',
	'openidconvertsuccesstext' => 'Do häß Ding OpenID jez ömjewandelt noh $1.',
	'openidconvertyourstext' => 'Dat es ald Ding OpenID.',
	'openidconvertothertext' => 'Dat wämm anders sing OpenID.',
	'openidalreadyloggedin' => "'''Leeven $1, Do bes all enjelogg.'''

Wann De OpenID zom Enlogge bruche wells, spääder, dann kanns De
[[Special:OpenIDConvert|Ding Aanmeldung op OpenID ömstelle]] jonn.",
	'openidnousername' => 'Keine Metmaacher-Name aanjejovve.',
	'openidbadusername' => 'Ene kapodde Metmaacher-Name aanjejovve.',
	'openidautosubmit' => 'Di Sigg enthääld_e Fomulaa för Ennjave, wat automattesch afjeschek weed, wann de Javaskrip enjeschalldt häs.
Wann nit, donn dä "Continue" (Wigger) Knopp nemme.',
	'openidclientonlytext' => 'Do kann de Aanmelldunge fun hee dämm Wiki nit als <span lang="en">OpenIDs</span> op annder Webßöövere nämme.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => 'De {{SITENAME}} ongerstöz der <span lang="en">[http://openid.net/ OpenID]</span> Standat för et eijfache un eijmoolije Enlogge zwesche diverse Websigge.
<span lang="en">OpenID</span> määd_et müjjesch, dat mer op ongerscheedlijje Websigge enlogge kann, oohne dat mer övverall en annder Paßwoot bruch.
Loor Der [http://ksh.wikipedia.org/wiki/OpenID der Wikipedia ier Atikkel övver <span lang="en">OpenID</span>] aan, do steit noch mieh dren.

Wann de alld aanjemeldt bes op de {{SITENAME}}, dann kanns De met Dingem Metmaacher-Name un Paßwoot [[Special:UserLogin|enlogge]] wi sönß och.
Öm spääder och <span lang="en">OpenID</span> ze bruche, kann noh_m nomaale Enlogge Ding Aanmeldungsdate [[Special:OpenIDConvert|op <span lang="en">OpenID</span> ömstelle]].

Et jitt en jruuße Zahl [http://wiki.openid.net/Public_OpenID_providers <span lang="en">OpenID Provider</span> för de Öffentleschkeit], un et künnt joot sin, dat De alld ene <span lang="en">OpenID</span>-fä\'ijje Zojang häß, op däm eine udder andere Server.
<!--
; Annder Wikis : Wann De op enem Wiki aanjemelldt bes, wat <span lang="en">OpenID</span> ongerschtöz, zem Beispöll [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] udder [http://kei.ki/ Keiki], kanns de hee op de {{SITENAME}} enlogge, indämm dat De de komplätte URL fun Dinge Metmaacher-Sigg op däm aandere Wiki hee bovve endrähß. Zem Beispöll esu jät wi: \'\'<nowiki>http://kei.ki/en/User:Evan</nowiki>\'\'.
; [http://openid.yahoo.com/ Yahoo!] : Wann De bei <span lang="en">Yahoo!</span> aanjemelldt bes, kanns de hee op de {{SITENAME}} enlogge, indämm dat De de Ding <span lang="en">OpenID URL</span> bovve aanjiß, di De fun <span lang="en">Yahoo!</span> bekumme häß. Di <span lang="en">OpenID URLs</span> sinn uß wi zem Beispöll: \'\'<nowiki>https://me.yahoo.com/DingeMetmaacherName</nowiki>\'\'.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Wann de ene zohjang op [http://www.aol.com/ AOL] häß, esu jet wie ennen Zojang zom [http://www.aim.com/ AIM], do kanns de Desch hee op de {{SITENAME}} enlogge, indämm dat De de Ding <span lang="en">OpenID</span> bovve enjiß. De <span lang="en">OpenID URLs</span> fun AOL sen opjebout wi \'\'<nowiki>http://openid.aol.com/dingemetmaachername</nowiki>\'\'. Dinge Metmaacher-Name sullt uß luuter Kleinbochstave bestonn, kein Zwescheräum.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Wann de e <span lang="en">Blog</span> op einem fun dä Söövere häß, dann draach der Url fu Dingem <span lang="en">Blog</span> bovve en. Zem Beispöll: \'\'<nowiki>http://dingeblogname.blogspot.com/</nowiki>\'\', \'\'<nowiki>http://dingeblogname.wordpress.com/</nowiki>\'\', \'\'<nowiki>http://dingeblogname.livejournal.com/</nowiki>\'\', udder \'\'<nowiki>http://dingeblogname.vox.com/</nowiki>\'\'.
<!-- -->',
	'openidupdateuserinfo' => 'Donn ming päsöönlijje Enstellunge op der neuste Stand bränge',
	'openiddelete' => 'Donn de <i lang="en">OpenID</i> fott schmiiße',
	'openiddelete-text' => 'Wann De op dä Knopp „{{int:openiddelete-button}}“ klecks, weed de <i lang="en">OpenID</i> „$1“ vun Dinge Aanmeldung heh fott jenumme.
Dann kanns De met dä <i lang="en">OpenID</i> nit mieh heh enlogge.',
	'openiddelete-button' => 'Lohß jonn!',
	'openiddelete-sucess' => 'Di <i lang="en">OpenID</i> es jäz nit mieh met Dinge Aanmeldung verbonge.',
	'openiddelete-error' => 'Et es ene Fähler opjetrodde, wi mer di <i lang="en">OpenID</i> vun Dinge Aanmeldung fott nämme wullte.',
	'openid-prefstext' => '[http://openid.net/ OpenID] Enstellunge',
	'openid-pref-hide' => 'Versteich Ding OpenID op Dinge Metmaacher-Sigg, wann de met <span lang="en">OpenID</span> enloggs.',
	'openid-pref-update-userinfo-on-login' => 'Donn jedesmol wann_esch hee enloggen, di Enfomazjuhne övver mesch heh noh vun <i lang="en">OpenID</i> op der neuste Stand bränge:',
	'openid-urls-desc' => 'De <i lang="en">OpenIDs</i>, di jez met Dinge Aanmeldung heh verbonge sin:',
	'openid-urls-url' => 'de URL',
	'openid-urls-action' => 'Akßuhn',
	'openid-urls-delete' => 'Schmiiß fott',
	'openid-add-url' => 'Donn en neu <i lang="en">OpenID</i> dobei',
	'openidsigninorcreateaccount' => 'Donn enlogge udder Desh neu aanmellde',
	'openid-provider-label-openid' => 'Donn Ding <i lang="en">OpenID</i> URL aanjevve',
	'openid-provider-label-google' => 'Donn met Dingem <i lang="en">Google account</i> enlogge',
	'openid-provider-label-yahoo' => 'Donn met Dinge <i lang="en">Yahoo</i> Kennung enlogge',
	'openid-provider-label-aol' => 'Donn met Dingem <i lang="en">AOL</i>-Name enlogge',
	'openid-provider-label-other-username' => 'Donn Dinge Metmaachername vun $1 aanjevve',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'openid-desc' => "Sech an d'Wiki matt enger [http://openid.net/ OpenID] aloggen, a sech op aneren Internetsiten, déi OpenID ënerstetzen, matt engem Wiki-Benotzerkont aloggen.",
	'openidlogin' => 'Umellen mat OpenID',
	'openidserver' => 'OpenID-Server',
	'openidxrds' => 'Yadis Fichier',
	'openidconvert' => 'OpenID-Ëmwandler',
	'openiderror' => 'Feeler bei der Iwwerpréifung',
	'openiderrortext' => 'Beim Iwwerpréifen vun der OpenID URL ass e Feeler geschitt.',
	'openidconfigerror' => 'OpenId-Konfiguratiounsfeeler',
	'openidconfigerrortext' => "D'OpenID-Späicherastellung fir dës Wiki ass falsch.
Kontaktéiert w.e.g. een [[Special:ListUsers/sysop|Administrateur]].",
	'openidpermission' => 'OpenID-Autorisatiounsfeeler',
	'openidpermissiontext' => "D'OpeniD déi Dir uginn hutt ass net erlaabt fir sech op dëse Server anzeloggen.",
	'openidcancel' => 'Iwwerpréifung ofgebrach',
	'openidcanceltext' => "D'Iwwerpréifung vun der OpenID-URL gouf ofgebrach",
	'openidfailure' => 'Feeler bei der Iwwerpréifung',
	'openidfailuretext' => 'D\'iwwerpréifung vun der OpeniD URL huet net fonctionnéiert. Feeler Message: "$1"',
	'openidsuccess' => 'Iwwerpréifung huet geklappt',
	'openidsuccesstext' => "D'Iwwerpréifung vun der OpenID-URL huet geklappt.",
	'openidusernameprefix' => 'OpenIDBenotzer',
	'openidserverlogininstructions' => 'Gitt ärt Passwuert hei ënnendrënner an, fir iech als Benotzer $2 op $3 unzemellen (Benotzersäit $1).',
	'openidtrustinstructions' => 'Klickt un wann Dir Donnéeën mat $1 deele wellt.',
	'openidallowtrust' => 'Erlaabt $1 fir dësem Benotzerkont ze vertrauen.',
	'openidnopolicy' => 'De Site huet keng Richtlinne fir den Dateschutz uginn.',
	'openidpolicy' => 'Fir méi Informatiounen <a target="_new" href="$1">kuckt d\'Dateschutzrichtlinnen</a>.',
	'openidoptional' => 'Facultatif',
	'openidrequired' => 'Obligatoresch',
	'openidnickname' => 'Spëtznumm',
	'openidfullname' => 'Ganzen Numm',
	'openidemail' => 'E-Mailadress',
	'openidlanguage' => 'Sprooch',
	'openidtimezone' => 'Zäitzone',
	'openidchooselegend' => 'Eraussiche vum Benotzernumm',
	'openidchooseinstructions' => 'All Benotzer brauchen e Spëtznumm; Dir kënnt iech ee vun de Méiglechkeeten ënnendrënner auswielen.',
	'openidchoosenick' => 'Äre Spëtznumm ($1)',
	'openidchoosefull' => 'Äre ganzen Numm ($1)',
	'openidchooseurl' => 'En Numm gouf vun ärer OpenID ($1) geholl',
	'openidchooseauto' => 'En Numm deen automatesch generéiert gouf ($1)',
	'openidchoosemanual' => 'En Numm vun Ärer Wiel:',
	'openidchooseexisting' => 'E Benotzerkont deen et op dëser Wiki gëtt',
	'openidchooseusername' => 'Benotzernumm:',
	'openidchoosepassword' => 'Passwuert:',
	'openidconvertinstructions' => "Mat dësem Formulaire kënnt dir Äre Benotzerkont ännere fir eng OpenID URL ze benotzen oder méi OpenID URL'en derbäizesetzen.",
	'openidconvertoraddmoreids' => 'An en OpenID ëmwandelen oder eng aner OpenID URL derbäisetzen',
	'openidconvertsuccess' => 'An en OpenID-Benotzerkont ëmgewandelt',
	'openidconvertsuccesstext' => 'Dir hutt Är OpenID op $1 ëmgewandelt.',
	'openidconvertyourstext' => 'Dat ass schon är OpenID.',
	'openidconvertothertext' => 'Dëst ass engem anere seng OpenID.',
	'openidalreadyloggedin' => "'''Dir sidd schonn ageloggt, $1!'''

Wann Dir OpenID benotze wëllt fir Iech an Zukunft anzeloggen, da kënnt Dir [[Special:OpenIDConvert|Äre Benotzerkont an en OpenID-Benotzerkont ëmwandelen]].",
	'openidnousername' => 'Kee Benotzernumm uginn.',
	'openidbadusername' => 'Falsche Benotzernumm uginn.',
	'openidautosubmit' => 'Op dëser Säit gëtt et e Formulaire deen automatesch soll verschéckt ginn wann Dir JavaScript ageschalt hutt.
Wann net, da verich et mam Knäppche "Continue" (Weider).',
	'openidclientonlytext' => 'Dir kënnt keng Benotzerkonten aus dëser Wiki als OpendIDen op anere Site benotzen.',
	'openidloginlabel' => 'URL vun der OpenID',
	'openidlogininstructions' => '{{SITENAME}} ënnerstëtzt den [http://openid.net/ OpenID]-Standard fir eng eenheetlech Umeldung fir méi Websäiten.
OpenID mellt Iech bäi ville verschiddene Websäiten un, ouni datt Dir fir jiddwer Säiten een anert Passwuert gebrauche musst.
(Méi Informatiounen fannt Dir am [http://de.wikipedia.org/wiki/OpenID Wikipedia-Artikel iwwer OpenID].)

Wann Dir schonn e Benotzerkont op {{SITENAME}} hutt, kënnt Dir Iech ganz normal mat ärem Benotzernumm a Passwuert [[Special:UserLogin|aloggen]].
Fir an Zukunft OpenID ze benotzen, kënnt Dir [[Special:OpenIDConvert|äre Benotzerkont op OpenID ëmwandelen]], nodeems Dir Iech normal ageloggt huet.

Et gëtt vill [http://openid.net/get/ OpenID-Provider] a méiglecherweis hutt Dir schonn e Benotzerkont mat aktivéierter OpenID bäi engem aneren Ubidder.',
	'openidupdateuserinfo' => 'Meng perséinlech Informatiounen aktualiséieren:',
	'openiddelete' => 'OpenID läschen',
	'openiddelete-text' => 'Wann dir op de Knäppchen "{{int:openiddelete-button}}" klickt, dann huelt Dir d\'OpenID $1 vun Ärem Benotzerkont ewech.
Da kënnt Dir Iech net méi mat dëser OpenID aloggen.',
	'openiddelete-button' => 'Confirméieren',
	'openiddeleteerrornopassword' => 'Dir kënnt net all Är OpenIDe läschen well Äre Benotzerkont kee Paswuert huet.
Dir kéint Iech net ouni eng OpenID aloggen.',
	'openiddeleteerroropenidonly' => 'Dir kënnt net all Är OpenIDe läsche well Dir Iech nëmme mat OpenID aloggen däerft.
Dir kéint Iech ouni OpenID net aloggen.',
	'openiddelete-sucess' => "D'OpenID gouf vun Ärem Benotzerkont ewechgeholl",
	'openiddelete-error' => 'Beim Ewehhuele vun der OpenID vun Ärem Benotzerkont ass e Feeler geschitt.',
	'openid-prefstext' => '[http://openid.net/ OpenID]-Astellungen',
	'openid-pref-hide' => 'Verstoppt Är OpenID op ärer Benotzersäit, wann dir Iech mat OpenID aloggt.',
	'openid-pref-update-userinfo-on-login' => "D'Informatioune vu dësem OpenID-Kont all Kéier aktualiséiere wann ech mech aloggen",
	'openid-urls-desc' => 'OpendIden déi mat Ärem Benotzerkont asoziéiert sinn',
	'openid-urls-action' => 'Aktioun',
	'openid-urls-delete' => 'Läschen',
	'openid-add-url' => 'Eng nei OpenID derbäisetzen',
	'openidsigninorcreateaccount' => 'Loggt Iech an oder Maacht en neie Benotzerkont op',
	'openid-provider-label-openid' => 'Gitt Är OpenID URL un',
	'openid-provider-label-google' => 'Loggt Iech mat Ärem Goggle-Benotzerkont an',
	'openid-provider-label-yahoo' => 'Loggt Iech mat Ärem Yahoo-Benotzerkont an',
	'openid-provider-label-aol' => 'Gitt Ären AOL Numm un',
	'openid-provider-label-other-username' => 'Gitt Äre(n) $1 Benotzernumm  un',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'openidchoosepassword' => 'wachwaord:',
);

/** Lithuanian (Lietuvių)
 * @author Garas
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'openiderror' => 'Tikrinimo klaida',
	'openidnickname' => 'Slapyvardis',
	'openidfullname' => 'Visas vardas',
	'openidemail' => 'El. pašto adresas',
	'openidlanguage' => 'Kalba',
	'openidchoosepassword' => 'slaptažodis:',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'openidchoosepassword' => 'шолыпмут:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'openid-desc' => 'Најавувајте се на викито со [http://openid.net/ OpenID], и најавувајте се со други OpenID-поддржни страници со вики-корисничка сметка',
	'openidlogin' => 'Најавување со OpenID',
	'openidserver' => 'OpenID сервер',
	'openidxrds' => 'Yadis податотека',
	'openidconvert' => 'OpenID претворач',
	'openiderror' => 'Грешка при потврдувањето',
	'openiderrortext' => 'Настана грешка при потврдувањето на URL адресата на OpenID.',
	'openidconfigerror' => 'Грешка со конфигурацијата на OpenID',
	'openidconfigerrortext' => 'Складишната конфигурација на OpenID за ова вики е погрешна.
Консултирајте се со [[Special:ListUsers/sysop|администратор]].',
	'openidpermission' => 'Грешка при дозволување на OpenID',
	'openidpermissiontext' => 'На внесениот OpenID не му е дозволено најавување на овој сервер.',
	'openidcancel' => 'Потврдувањето е откажано',
	'openidcanceltext' => 'Потврдувањето на URL адресата на OpenID беше откажана.',
	'openidfailure' => ' Потврдувањето не успеа',
	'openidfailuretext' => 'Потврдувањето на URL адресата на OpenID не успеа. Извештај за грешката: „$1“',
	'openidsuccess' => 'Потврдувањето успеа',
	'openidsuccesstext' => 'Потврдувањето на URL адресата на OpenID беше успешно.',
	'openidusernameprefix' => 'OpenIDКорисник',
	'openidserverlogininstructions' => 'Внесете ја лозинката подолу за да се најавите на $3 како корисник $2 (корисничка страница $1).',
	'openidtrustinstructions' => 'Штиклирајте ако сакате да споделувате податоци со $1.',
	'openidallowtrust' => 'Дозволи му на $1 да ѝ верува на оваа корисничка сметка.',
	'openidnopolicy' => 'Страницата нема назначено правила за приватност.',
	'openidpolicy' => 'Погледајте го <a target="_new" href="$1">правилникот за приватност</a> за повеќе информации.',
	'openidoptional' => 'Изборно',
	'openidrequired' => 'Задолжително',
	'openidnickname' => 'Прекар',
	'openidfullname' => 'Полно име',
	'openidemail' => 'Е-поштенска адреса',
	'openidlanguage' => 'Јазик',
	'openidtimezone' => 'Часовна зона',
	'openidchooselegend' => 'Избор на корисничко име',
	'openidchooseinstructions' => 'Сите корисници треба да имаат прекар;
можете да изберете едно од долунаведените предлози:',
	'openidchoosenick' => 'Вашиот прекар ($1)',
	'openidchoosefull' => 'Вашето полно име ($1)',
	'openidchooseurl' => 'Име преземено од вашиот OpenID ($1)',
	'openidchooseauto' => 'Автоматски создадено име ($1)',
	'openidchoosemanual' => 'Име по избор:',
	'openidchooseexisting' => 'Постоечка сметка на ова вики',
	'openidchooseusername' => 'корисничко име:',
	'openidchoosepassword' => 'лозинка:',
	'openidconvertinstructions' => 'Овој образец ви овозможува да ја промените вашата корисничка сметка за да користи OpenID URL адреса или да додавате уште OpenID URL адреси',
	'openidconvertoraddmoreids' => 'Претворете во OpenID или додајте друга OpenID URL адреса',
	'openidconvertsuccess' => 'Претворањето во OpenID е успешно',
	'openidconvertsuccesstext' => 'Успешно го претворивте вашиот OpenID во $1.',
	'openidconvertyourstext' => 'Ова веќе е  вашиот OpenID.',
	'openidconvertothertext' => 'Тоа е туѓ OpenID.',
	'openidalreadyloggedin' => "'''Веќе сте најавени, $1!'''

Ако сакате во иднина да користите OpenID за најавување, можете да [[Special:OpenIDConvert|ја претворите вашата сметка за да користи OpenID]].",
	'openidnousername' => 'Нема назначено корисничко име.',
	'openidbadusername' => 'Беше назначено грешно име.',
	'openidautosubmit' => 'На оваа страница стои образец кој треба да се поднесе автоматски ако имате овозможено JavaScript.
Ако ова не се случи, притиснете на копчето "Continue" (Продолжи).',
	'openidclientonlytext' => 'Не можете да користите сметки од ова вики како OpenID за друга стрнаица.',
	'openidloginlabel' => 'OpenID URL адреса',
	'openidlogininstructions' => '{{SITENAME}} го поддржува [http://openid.net/ OpenID] стандардот за една сметка помеѓу веб-страници.
OpenID ви овозможува да се најавувате на многу различни веб-страници без да ви треба различна лозинка за секоја поединечно.
(Погледаје ја [http://mk.wikipedia.org/wiki/OpenID статијата за OpenID на Википедија] за повеќе информации.)

Доколку веќе имате сметка на  {{SITENAME}}, можете да [[Special:UserLogin|се најавите]] со корисничкото име и лозинката по нормална постапка.
За да користите OpenID во иднина, можете да [[Special:OpenIDConvert|ја претворите сметката во OpenID]] откога ќе се најавите нормално.

Постојат многу [http://openid.net/get/ OpenID услужители], и вие можеби веќе да имате OpenID-овозможена сметка на друга служба.',
	'openidupdateuserinfo' => 'Поднови ги моите лични информации:',
	'openiddelete' => 'Избриши го овој OpenID',
	'openiddelete-text' => 'Со кликнување на копчето „{{int:openiddelete-button}}“ ќе го отстраните OpenID $1 од вашата сметка.
Повеќе нема да можете да се најавувате со овој OpenID.',
	'openiddelete-button' => 'Потврди',
	'openiddeleteerrornopassword' => 'Не можете да ги избришете сите ваши OpenID-ја бидејќи вашата сметка нема лозинка.
Ако немате OpenID нема да можете да се најавите.',
	'openiddeleteerroropenidonly' => 'Не можете да ги избришете сите ваши OpenID-ја бидејќи дозволено ви е да се најавувате само со OpenID.
Ако немате OpenID нема да можете да се најавите.',
	'openiddelete-sucess' => 'Овој OpenID е успешно отстранет од вашата сметка.',
	'openiddelete-error' => 'Настана грешка при отстранувањето на OpenID од вашата сметка.',
	'openid-prefstext' => '[http://openid.net/ OpenID] нагодувања',
	'openid-pref-hide' => 'Скријте ја вашата OpenID URL адреса на вашата корисничката страница, ако се најавувате со OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Ажурирајте ги следниве информации од OpenID секојпат кога ќе се најавам:',
	'openid-urls-desc' => 'OpenID поврзани со вашата сметка:',
	'openid-urls-action' => 'Дејство',
	'openid-urls-delete' => 'Избриши',
	'openid-add-url' => 'Додај нов OpenID',
	'openidsigninorcreateaccount' => 'Најавете се или создајте сметка',
	'openid-provider-label-openid' => 'Внесете ја вашата OpenID URL адреса',
	'openid-provider-label-google' => 'Најавете се со вашата Google сметка',
	'openid-provider-label-yahoo' => 'Најавете се со вашата Yahoo сметка',
	'openid-provider-label-aol' => 'Внесете го вашето име на AOL',
	'openid-provider-label-other-username' => 'Внесете го вашето $1 корисничко име',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'openidlogin' => 'ഓപ്പണ്‍ ഐ.ഡി. ഉപയോഗിച്ച് ലോഗിന്‍ ചെയ്യുക',
	'openidserver' => 'OpenID സെര്‍‌വര്‍',
	'openidcancel' => 'സ്ഥിരീകരണം റദ്ദാക്കിയിരിക്കുന്നു',
	'openidfailure' => 'സ്ഥിരീകരണം പരാജയപ്പെട്ടു',
	'openidsuccess' => 'സ്ഥിരീകരണം വിജയിച്ചു',
	'openidusernameprefix' => 'ഓപ്പണ്‍ ഐ.ഡി. ഉപയോക്താവ്',
	'openidserverlogininstructions' => '$3യിലേക്ക് $2 എന്ന ഉപയോക്താവായി (ഉപയോക്തൃതാള്‍ $1) ലോഗിന്‍ ചെയ്യുവാന്‍ താങ്കളുടെ രഹസ്യവാക്ക് താഴെ രേഖപ്പെടുത്തുക.',
	'openidtrustinstructions' => '$1 താങ്കളുടെ ഡാറ്റ പങ്കുവെക്കണമോ എന്ന കാര്യം പരിശോധിക്കുക.',
	'openidnopolicy' => 'സൈറ്റ് സ്വകാര്യതാ നയം കൊടുത്തിട്ടില്ല.',
	'openidoptional' => 'നിര്‍ബന്ധമില്ല',
	'openidrequired' => 'അത്യാവശ്യമാണ്‌',
	'openidnickname' => 'ചെല്ലപ്പേര്',
	'openidfullname' => 'പൂര്‍ണ്ണനാമം',
	'openidemail' => 'ഇമെയില്‍ വിലാസം',
	'openidlanguage' => 'ഭാഷ',
	'openidchooseinstructions' => 'എല്ലാ ഉപയോക്താക്കള്‍ക്കും ഒരു വിളിപ്പേരു ആവശ്യമാണ്‌. താഴെ കൊടുത്തിരിക്കുന്നവയില്‍ നിന്നു ഒരെണ്ണം താങ്കള്‍ക്ക് തിരഞ്ഞെടുക്കാവുന്നതാണ്‌.',
	'openidchoosefull' => 'താങ്കളുടെ പൂര്‍ണ്ണനാമം ($1)',
	'openidchooseurl' => 'താങ്കളുടെ ഓപ്പണ്‍‌ഐ.ഡി.യില്‍ നിന്നു തിരഞ്ഞെടുത്ത ഒരു പേര്‌ ($1)',
	'openidchooseauto' => 'യാന്ത്രികമായി ഉണ്ടാക്കിയ പേര്‌ ($1)',
	'openidchoosemanual' => 'താങ്കള്‍ക്ക് ഇഷ്ടമുള്ള ഒരു പേര്‌:',
	'openidchooseexisting' => 'ഈ വിക്കിയിലെ നിലവിലുള്ള അംഗത്വം',
	'openidchoosepassword' => 'രഹസ്യവാക്ക്:',
	'openidconvertsuccess' => 'ഓപ്പണ്‍ ഐ.ഡി.യിലേക്ക് വിജയകരമായി പരിവര്‍ത്തനം ചെയ്തിരിക്കുന്നു',
	'openidconvertsuccesstext' => 'താങ്കളുടെ ഓപ്പണ്‍‌ഐ.ഡി. $1ലേക്കു വിജയകരമായി പരിവര്‍ത്തനം ചെയ്തിരിക്കുന്നു.',
	'openidconvertyourstext' => 'ഇതു ഇപ്പോള്‍ തന്നെ താങ്കളുടെ ഓപ്പണ്‍‌ഐ.ഡി.യാണ്‌.',
	'openidconvertothertext' => 'ഇതു മറ്റാരുടേയോ ഓപ്പണ്‍‌ഐ.ഡി.യാണ്‌.',
	'openidnousername' => 'ഉപയോക്തൃനാമം തിരഞ്ഞെടുത്തിട്ടില്ല.',
	'openidbadusername' => 'അസാധുവായ ഉപയോക്തൃനാമമാണു തിരഞ്ഞെടുത്തിരിക്കുന്നത.',
	'openidloginlabel' => 'ഓപ്പണ്‍‌ഐ.ഡി. വിലാസം',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'openidtimezone' => 'Цагийн бүс',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'openid-desc' => 'विकिवर [http://openid.net/ ओपनID] वापरून प्रवेश करा, तसेच कुठल्याही इतर ओपनID संकेतस्थळावर विकि सदस्य नाम वापरून प्रवेश करा',
	'openidlogin' => 'ओपनID वापरून प्रवेश करा',
	'openidserver' => 'ओपनID सर्व्हर',
	'openidxrds' => 'Yadis संचिका',
	'openidconvert' => 'ओपनID कन्व्हर्टर',
	'openiderror' => 'तपासणी त्रुटी',
	'openiderrortext' => 'ओपनID URL च्या तपासणीमध्ये त्रुटी आढळलेली आहे.',
	'openidconfigerror' => 'ओपनID व्यवस्थापन त्रुटी',
	'openidconfigerrortext' => 'या विकिसाठीचे ओपनID जतन व्यवस्थापन चुकीचे आहे.
कृपया प्रबंधकांशी संपर्क करा.',
	'openidpermission' => 'ओपनID परवानगी त्रुटी',
	'openidpermissiontext' => 'आपण दिलेल्या ओपनID या सर्व्हरवर प्रवेश करता येणार नाही.',
	'openidcancel' => 'तपासणी रद्द',
	'openidcanceltext' => 'ओपनID URL ची तपासणी रद्द केलेली आहे.',
	'openidfailure' => 'तपासणी पूर्ण झाली नाही',
	'openidfailuretext' => 'ओपनID URL ची तपासणी पूर्ण झालेली नाही. त्रुटी संदेश: "$1"',
	'openidsuccess' => 'तपासणी पूर्ण',
	'openidsuccesstext' => 'ओपनID URL ची तपासणी पूर्ण झालेली आहे.',
	'openidusernameprefix' => 'ओपनIDसदस्य',
	'openidserverlogininstructions' => '$3 वर $2 या नावाने (सदस्य पान $1) प्रवेश करण्यासाठी आपला परवलीचा शब्द खाली लिहा.',
	'openidtrustinstructions' => 'तुम्ही $1 बरोबर डाटा शेअर करू इच्छिता का याची तपासणी करा.',
	'openidallowtrust' => '$1 ला ह्या सदस्य खात्यावर विश्वास ठेवण्याची अनुमती द्या.',
	'openidnopolicy' => 'संकेतस्थळावर गोपनियता नीती दिलेली नाही.',
	'openidpolicy' => 'अधिक माहितीसाठी <a target="_new" href="$1">गुप्तता नीती</a> तपासा.',
	'openidoptional' => 'वैकल्पिक',
	'openidrequired' => 'आवश्यक',
	'openidnickname' => 'टोपणनाव',
	'openidfullname' => 'पूर्णनाव',
	'openidemail' => 'इमेल पत्ता',
	'openidlanguage' => 'भाषा',
	'openidchooseinstructions' => 'सर्व सदस्यांना टोपणनाव असणे आवश्यक आहे;
तुम्ही खाली दिलेल्या नावांमधून एक निवडू शकता.',
	'openidchoosefull' => 'तुमचे पूर्ण नाव ($1)',
	'openidchooseurl' => 'तुमच्या ओपनID मधून घेतलेले नाव ($1)',
	'openidchooseauto' => 'एक आपोआप तयार झालेले नाव ($1)',
	'openidchoosemanual' => 'तुमच्या आवडीचे नाव:',
	'openidchooseexisting' => 'या विकिवरील अस्तित्वात असलेले सदस्य खाते:',
	'openidchoosepassword' => 'परवलीचा शब्द:',
	'openidconvertinstructions' => 'हा अर्ज तुम्हाला ओपनID URL वापरण्यासाठी तुमचे सदस्यनाव बदलण्याची परवानगी देतो.',
	'openidconvertsuccess' => 'ओपनID मध्ये बदल पूर्ण झालेले आहेत',
	'openidconvertsuccesstext' => 'तुम्ही तुमचा ओपनID $1 मध्ये यशस्वीरित्या बदललेला आहे.',
	'openidconvertyourstext' => 'हा तुमचाच ओपनID आहे.',
	'openidconvertothertext' => 'हा दुसर्‍याचा ओपनID आहे.',
	'openidalreadyloggedin' => "'''$1, तुम्ही अगोदरच प्रवेश केलेला आहे!'''

जर तुम्ही भविष्यात ओपनID वापरून प्रवेश करू इच्छित असाल, तर तुम्ही [[Special:OpenIDConvert|तुमचे खाते ओपनID साठी बदलू शकता]].",
	'openidnousername' => 'सदस्यनाव दिले नाही.',
	'openidbadusername' => 'चुकीचे सदस्यनाव दिले आहे.',
	'openidautosubmit' => 'या पानावरील अर्ज जर तुम्ही जावास्क्रीप्ट वापरत असाल तर आपोआप पाठविला जाईल. जर तसे झाले नाही, तर "Continue" (पुढे) कळीवर टिचकी मारा.',
	'openidclientonlytext' => 'या विकिवरील खाती तुम्ही इतर संकेतस्थळांवर ओपनID म्हणून वापरू शकत नाही.',
	'openidloginlabel' => 'ओपनID URL',
	'openidlogininstructions' => "{{SITENAME}} [http://openid.net/ ओपनID] वापरून विविध संकेतस्थळांवर प्रवेश करण्याची अनुमती देते.
ओपनID वापरुन तुम्ही एकाच परवलीच्या शब्दाने विविध संकेतस्थळांवर प्रवेश करू शकता.
(अधिक माहिती साठी [http://en.wikipedia.org/wiki/OpenID विकिपीडिया वरील ओपनID लेख] पहा.)

जर {{SITENAME}} वर अगोदरच तुमचे खाते असेल, तुम्ही नेहमीप्रमाणे तुमचे सदस्यनाव व परवलीचा शब्द वापरून [[Special:UserLogin|प्रवेश करा]].
भविष्यात ओपनID वापरण्यासाठी, तुम्ही प्रवेश केल्यानंतर [[Special:OpenIDConvert|तुमचे खाते ओपनID मध्ये बदला]].

अनेक [http://wiki.openid.net/Public_OpenID_providers Public ओपनID वितरक] आहेत, व तुम्ही अगोदरच ओपनID चे खाते उघडले असण्याची शक्यता आहे.

; इतर विकि : जर तुमच्याकडे ओपनID वापरणार्‍या विकिवर खाते असेल, जसे की [http://wikitravel.org/ विकिट्रॅव्हल], [http://www.wikihow.com/ विकिहाऊ], [http://vinismo.com/ विनिस्मो], [http://aboutus.org/ अबाउट‍अस] किंवा [http://kei.ki/ कैकी], तुम्ही {{SITENAME}} वर तुमच्या त्या विकिवरील सदस्य पानाची '''पूर्ण URL''' वरील पृष्ठपेटीमध्ये देऊन प्रवेश करू शकता. उदाहरणार्थ, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ याहू!] : जर तुमच्याकडे याहू! चे खाते असेल, तर तुम्ही वरील पृष्ठपेटीमध्ये याहू! ने दिलेल्या ओपनID चा वापर करून प्रवेश करू शकता. याहू! ओपनID URL ची रुपरेषा ''<nowiki>https://me.yahoo.com/तुमचेसदस्यनाव</nowiki>'' अशी आहे.
; [http://dev.aol.com/aol-and-63-million-openids एओएल] : जर तुमच्याकडे [http://www.aol.com/ एओएल]चे खाते असेल, जसे की [http://www.aim.com/ एम] खाते, तुम्ही {{SITENAME}} वर वरील पृष्ठपेटीमध्ये एओएल ने दिलेल्या ओपनID चा वापर करून प्रवेश करू शकता. एओएल ओपनID URL ची रुपरेषा ''<nowiki>http://openid.aol.com/तुमचेसदस्यनाव</nowiki>'' अशी आहे. तुमच्या सदस्यनावात अंतर (space) चालणार नाही.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html ब्लॉगर], [http://faq.wordpress.com/2007/03/06/what-is-openid/ वर्डप्रेस.कॉम], [http://www.livejournal.com/openid/about.bml लाईव्ह जर्नल], [http://bradfitz.vox.com/library/post/openid-for-vox.html वॉक्स] : जर यापैकी कुठेही तुमचा ब्लॉग असेल, तर वरील पृष्ठपेटीमध्ये तुमच्या ब्लॉगची URL भरा. उदाहरणार्थ, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', किंवा ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
	'openid-pref-hide' => 'जर तुम्ही ओपनID वापरून प्रवेश केला, तर तुमच्या सदस्यपानावरील तुमचा ओपनID लपवा.',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 * @author Aviator
 * @author Diagramma Della Verita
 */
$messages['ms'] = array(
	'openidlogin' => 'Log masuk dengan OpenID',
	'openidserver' => 'Pelayan OpenID',
	'openidxrds' => 'Fail Yadis',
	'openidconvert' => 'Penukar OpenID',
	'openiderror' => 'Ralat pengesahan',
	'openiderrortext' => 'Berlaku ralat ketika pengesahan URL OpenID.',
	'openidconfigerror' => 'Ralat konfigurasi OpenID',
	'openidconfigerrortext' => 'Konfigurasi storan OpenID bagi wiki ini tidak sah.
Sila hubungi [[Special:ListUsers/sysop|pentadbir]].',
	'openidpermission' => 'Ralat keizinan OpenID',
	'openidcancel' => 'Pengesahan telah dibatalkan',
	'openidcanceltext' => 'Pengesahan URL OpenID telah dibatalkan.',
	'openidoptional' => 'Pilihan',
	'openidrequired' => 'Wajib',
	'openidnickname' => 'Nama ringkas',
	'openidfullname' => 'Nama penuh',
	'openidemail' => 'Alamat e-mel',
	'openidlanguage' => 'Bahasa',
	'openidchoosefull' => 'Nama penuh anda ($1)',
	'openidchooseurl' => 'Nama yang dipilih daripada OpenID anda ($1)',
	'openidchooseauto' => 'Nama janaan automatik ($1)',
	'openidchoosemanual' => 'Nama pilihan anda:',
	'openidchoosepassword' => 'kata laluan:',
	'openidconvertinstructions' => 'Gunakan borang ini untuk menukar akaun anda untuk menggunakan OpenID URL.',
	'openidconvertsuccess' => 'Berjaya ditukar ke OpenID',
	'openidconvertsuccesstext' => 'Anda telah berjaya menukar OpenID ke $1.',
	'openidconvertyourstext' => 'OpenID anda seperti yang tertera.',
	'openidconvertothertext' => 'OpenID tersebut merupakan milik orang lain.',
	'openidalreadyloggedin' => "'''Anda telah log masuk, $1!'''

Sekiranya anda inign menggunakan OpenID untuk log masuk pada masa hadapan, sila [[Special:OpenIDConvert|tukar akaun anda untuk menggunakan OpenID]].",
	'openidnousername' => 'Nama pengguna tidak dinyatakan.',
	'openidbadusername' => 'Nama pengguna yang dinyatakan tidak sah.',
	'openidloginlabel' => 'URL OpenID',
	'openid-urls-action' => 'Tindakan',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'openidlanguage' => 'Lingwa',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'openidoptional' => 'Мелень коряс',
	'openidnickname' => 'Путонь лем',
	'openidfullname' => 'Лем педе-пес',
	'openidemail' => 'Е-сёрма парго',
	'openidlanguage' => 'Кель',
	'openidtimezone' => 'Шкань каркс',
	'openidchoosepassword' => 'совамо валось:',
	'openiddelete-button' => 'Кемекстамс',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'openidemail' => 'E-mailcān',
	'openidlanguage' => 'Tlahtōlli',
	'openidchoosepassword' => 'tlahtōlichtacāyōtl:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'openid-desc' => 'Aanmelden bij de wiki met een [http://openid.net/ OpenID] en aanmelden bij andere websites die OpenID ondersteunen met een wikigebruiker',
	'openidlogin' => 'Aanmelden met OpenID',
	'openidserver' => 'OpenID-server',
	'openidxrds' => 'Yadis-bestand',
	'openidconvert' => 'OpenID-convertor',
	'openiderror' => 'Verificatiefout',
	'openiderrortext' => 'Er is een fout opgetreden tijdens de verificatie van de OpenID URL.',
	'openidconfigerror' => 'Fout in de installatie van OpenID',
	'openidconfigerrortext' => "De instellingen van de opslag van OpenID's voor deze wiki kloppen niet.
Raadpleeg een  [[Special:ListUsers/sysop|beheerder]].",
	'openidpermission' => 'Fout in de rechten voor OpenID',
	'openidpermissiontext' => 'Met de OpenID die u hebt opgegeven kunt u niet aanmelden bij deze server.',
	'openidcancel' => 'Verificatie geannuleerd',
	'openidcanceltext' => 'De verificatie van de OpenID URL is geannuleerd.',
	'openidfailure' => 'Verificatie mislukt',
	'openidfailuretext' => 'De verificatie van de OpenID URL is mislukt. Foutmelding: "$1"',
	'openidsuccess' => 'Verificatie uitgevoerd',
	'openidsuccesstext' => 'De OpenID-URL is geverifieerd.',
	'openidusernameprefix' => 'OpenIDGebruiker',
	'openidserverlogininstructions' => 'Voer uw wachtwoord hieronder in om aan te melden bij $3 als gebruiker $2 (gebruikerspagina $1).',
	'openidtrustinstructions' => 'Controleer of u gegevens wilt delen met $1.',
	'openidallowtrust' => 'Toestaan dat $1 deze gebruiker vertrouwt.',
	'openidnopolicy' => 'De site heeft geen privacybeleid.',
	'openidpolicy' => 'Lees het <a target="_new" href="$1">privacybeleid</a> voor meer informatie.',
	'openidoptional' => 'Optioneel',
	'openidrequired' => 'Verplicht',
	'openidnickname' => 'Nickname',
	'openidfullname' => 'Volledige naam',
	'openidemail' => 'E-mailadres',
	'openidlanguage' => 'Taal',
	'openidtimezone' => 'Tijdzone',
	'openidchooselegend' => 'Gebruikersnaamkeuze',
	'openidchooseinstructions' => 'Alle gebruikers moeten een gebruikersnaam kiezen. U kunt er een kiezen uit de onderstaande opties.',
	'openidchoosenick' => 'Uw bijnaam ($1)',
	'openidchoosefull' => 'Uw volledige naam ($1)',
	'openidchooseurl' => 'Een naam uit uw OpenID ($1)',
	'openidchooseauto' => 'Een automatisch samengestelde naam ($1)',
	'openidchoosemanual' => 'Een te kiezen naam:',
	'openidchooseexisting' => 'Een bestaande gebruiker op deze wiki',
	'openidchooseusername' => 'gebruikersnaam:',
	'openidchoosepassword' => 'wachtwoord:',
	'openidconvertinstructions' => "Via dit formulier kunt u uw gebruiker als OpenID-URL gebruiken of meer OpenID-URL's toevoegen.",
	'openidconvertoraddmoreids' => 'Converteren naar OpenID of een andere OpenID-URL toevoegen',
	'openidconvertsuccess' => 'Omzetten naar OpenID is uitgevoerd',
	'openidconvertsuccesstext' => 'Uw OpenID is omgezet naar $1.',
	'openidconvertyourstext' => 'Dat is al uw OpenID.',
	'openidconvertothertext' => 'Iemand anders heeft die OpenID al in gebruik.',
	'openidalreadyloggedin' => "'''U bent al aangemeld, $1!'''

Als u in de toekomst uw OpenID wilt gebruiken om aan te melden, [[Special:OpenIDConvert|zet uw gebruiker dan om naar OpenID]].",
	'openidnousername' => 'Er is geen gebruikersnaam opgegeven.',
	'openidbadusername' => 'De opgegeven gebruikersnaam is niet toegestaan.',
	'openidautosubmit' => 'Deze pagina bevat een formulier dat automatisch wordt verzonden als JavaScript is ingeschaked.
Als dat niet werkt, klik dan op de knop "Continue" (Doorgaan).',
	'openidclientonlytext' => 'U kunt gebruikers van deze wiki niet als OpenID gebruiken op een andere site.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => '{{SITENAME}} ondersteunt de standaard [http://openid.net/ OpenID] voor maar een keer hoeven aanmelden voor meerdere websites.
Met OpenID kunt u aanmelden bij veel verschillende websites zonder voor iedere site opnieuw een wachtwoord te moeten opgeven.
Zie het [http://nl.wikipedia.org/wiki/OpenID Wikipedia-artikel over OpenID] voor meer informatie.

Als u al een gebruiker hebt op {{SITENAME}}, dan kunt u aanmelden met uw gebruikersnaam en wachtwoord zoals u normaal doet. Om in de toekomst OpenID te gebruiken, kunt u uw [[Special:OpenIDConvert|gebruiker naar OpenID omzetten]] nadat u hebt aangemeld.

Er zijn veel [http://wiki.openid.net/Public_OpenID_providers publieke OpenID-providers], en wellicht hebt u al een gebruiker voor OpenID bij een andere dienst.',
	'openidupdateuserinfo' => 'Mijn persoonlijke gegevens bijwerken:',
	'openiddelete' => 'OpenID verwijderen',
	'openiddelete-text' => 'Door te klikken op de knop "{{int:openiddelete-button}}", verwijdert u de OpenID $1 uit uw gebruiker.
Het is dan niet langer mogelijk aan te melden met de OpenID "$1".',
	'openiddelete-button' => 'Bevestigen',
	'openiddeleteerrornopassword' => "U kunt niet al uw OpenID's verwijderen omdat uw gebruiker geen wachtwoord heeft.
Dan zou u niet langer kunnen aanmelden zonder een OpenID.",
	'openiddeleteerroropenidonly' => "U kunt niet al uw OpenID's verwijderen omdat u alleen mag aanmelden met een OpenID.
Dan zou u niet langer kunnen aanmelden zonder een OpenID.",
	'openiddelete-sucess' => 'De OpenID is verwijderd uit uw gebruiker.',
	'openiddelete-error' => 'Er is een fout opgetreden tijdens het verwijderen van de OpenID uit uw gebruiker.',
	'openid-prefstext' => 'Voorkeuren [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Bij aanmelden met OpenID, uw OpenID op uw gebruikerspagina verbergen.',
	'openid-pref-update-userinfo-on-login' => 'Iedere keer als ik aanmeld de volgende informatie vanuit de OpenID-gebruiker bijwerken:',
	'openid-urls-desc' => "Aan uw gebruiker gekoppelde OpenID's:",
	'openid-urls-action' => 'Handeling',
	'openid-urls-delete' => 'Wissen',
	'openid-add-url' => 'Een nieuwe OpenID toevoegen',
	'openidsigninorcreateaccount' => 'Aanmelden of nieuwe gebruiker aanmaken',
	'openid-provider-label-openid' => 'Voer de URL van uw OpenID in',
	'openid-provider-label-google' => 'Aanmelden met uw Google-gebruiker',
	'openid-provider-label-yahoo' => 'Aanmelden met uw Yahoo-gebruiker',
	'openid-provider-label-aol' => 'Aanmelden met uw AOL-gebruiker',
	'openid-provider-label-other-username' => 'Geef uw gebruikersnaam bij $1 in',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'openid-desc' => 'Logg inn på wikien med ein [http://openid.net/ OpenID] og logg inn på andre sider som bruker OpenID med kontoen herifrå',
	'openidlogin' => 'Logg inn med OpenID',
	'openidserver' => 'OpenID-tenar',
	'openidxrds' => 'Yadis-fil',
	'openidconvert' => 'OpenID-konvertering',
	'openiderror' => 'Feil under stadfesting',
	'openiderrortext' => 'Ein feil oppstod under stadfesting av OpenID-adressa.',
	'openidconfigerror' => 'Konfigurasjonsfeil med OpenID',
	'openidconfigerrortext' => 'Lagreoppsettet for OpenID på denne wikien er ugyldig.
Kontakt ein [[Special:ListUsers/sysop|administrator]].',
	'openidpermission' => 'Tilgjengefeil med OpenID',
	'openidpermissiontext' => 'Du kan ikkje logga deg inn på denne tenaren med OpenID-en du oppgav.',
	'openidcancel' => 'Stadfesting avbrote',
	'openidcanceltext' => 'Stadfestinga av OpenID-adressa blei avbrote.',
	'openidfailure' => 'Stadfesting mislukkast',
	'openidfailuretext' => 'Stadfestinga av OpenID-adressa mislukkast. Feilmelding: «$1»',
	'openidsuccess' => 'Stadfestinga lukkast',
	'openidsuccesstext' => 'Stadfestinga av OpenID-adressa lukkast.',
	'openidusernameprefix' => 'OpenID-brukar',
	'openidserverlogininstructions' => 'Skriv inn passordet ditt nedanfor for å logga deg inn på $3 som $2 (brukarsida $1).',
	'openidtrustinstructions' => 'Sjekk om du ynskjer å dela data med $1.',
	'openidallowtrust' => 'Lat $1 stola på denne kontoen.',
	'openidnopolicy' => 'Sida har inga personvernerklæring.',
	'openidpolicy' => 'Sjekk <a href="_new" href="$1">personvernerklæringa</a> for meir informasjon.',
	'openidoptional' => 'Valfri',
	'openidrequired' => 'Påkravd',
	'openidnickname' => 'Kallenamn',
	'openidfullname' => 'Fullt namn',
	'openidemail' => 'E-postadressa',
	'openidlanguage' => 'Språk',
	'openidtimezone' => 'Tidssone',
	'openidchooselegend' => 'Val av brukarnamn',
	'openidchooseinstructions' => 'All brukarar må ha eit kallenamn; du kan velja mellom vala nedanfor.',
	'openidchoosenick' => 'Kallenamnet ditt ($1)',
	'openidchoosefull' => 'Fullt namn ($1)',
	'openidchooseurl' => 'Eit namn teke frå OpenID-en din ($1)',
	'openidchooseauto' => 'Eit automatisk oppretta namn ($1)',
	'openidchoosemanual' => 'Eit valfritt namn:',
	'openidchooseexisting' => 'Ein konto på denne wikien som finst frå før',
	'openidchooseusername' => 'Brukarnamn:',
	'openidchoosepassword' => 'passord:',
	'openidconvertinstructions' => 'Dette skjemaet lèt deg endra brukarkontoen din slik at han kan nytta ei OpenID-adresse eller leggja til fleire OpenID-adresser.',
	'openidconvertoraddmoreids' => 'Konverter til OpenID eller legg til ei anna OpenID-adresse',
	'openidconvertsuccess' => 'Konverterte til OpenID',
	'openidconvertsuccesstext' => 'Du har konvertert OpenID-en din til $1.',
	'openidconvertyourstext' => 'Det er allereie OpenID-en din.',
	'openidconvertothertext' => 'Den OpenID-en tilhøyrer einkvan annan.',
	'openidalreadyloggedin' => "'''Du er allereie innlogga, $1.'''

Om du ynskjer å nytta OpenID i framtida, kan du [[Special:OpenIDConvert|konvertera kontoen din til å nytta OpenID]].",
	'openidnousername' => 'Du oppgav ingen brukarnamn.',
	'openidbadusername' => 'Du oppgav eit ugyldig brukarnamn.',
	'openidautosubmit' => 'Denne sida inneheld eit skjema som blir levert automatisk om du har JavaSvript slege på.
Dersom ikkje, trykk på «Continue» (Hald fram).',
	'openidclientonlytext' => 'Du kan ikkje nytta kontoar frå denne wikien som OpenID på ei onnor sida.',
	'openidloginlabel' => 'OpenID-adressa',
	'openidlogininstructions' => '{{SITENAME}} støttar [http://openid.net/ OpenID]-standarden for einskapleg innlogging på forskjellige nettstader. OpenID lèt deg logga inn på mange forskjellige nettsider utan at du må nytta forskjellige passord på kvar. (Sjå [http://nn.wikipedia.org/wiki/OpenID Wikipedia-artikkelen om OpenID] for meir informasjon.)

Om du allereie har ein konto på {{SITENAME}}, kan du [[Special:UserLogin|logga på]] som vanleg med brukarnamnet og passordet ditt. For å nytta OpenID i framtida, kan du [[Special:OpenIDConvert|konvertera kontoen din til OpenID]] etter at du har logga inn på vanleg vis.

Det er mange [http://wiki.openid.net/Public_OpenID_providers leverandørar av OpenID], og du kan allereie ha ein OpenID-aktivert konto ein annan stad.',
	'openidupdateuserinfo' => 'Oppdater den personlege informasjonen min:',
	'openiddelete' => 'Slett OpenID',
	'openiddelete-text' => 'Ved å klikka på «{{int:openiddelete-button}}»-knappen vil du fjernae OpenID $1 frå kontoen din.
Du vil ikkje lenger ha høve til å logga inn med denne OpenIDen.',
	'openiddelete-button' => 'Stadfest',
	'openiddeleteerrornopassword' => 'Du kan ikkje sletta alle OpenID-ane dine av di kontoen din ikkje har eit passord.
Du ville ikkje ha kunna logga inn utan ein OpenID.',
	'openiddeleteerroropenidonly' => 'Du kan ikkje sletta alle OpenID-ane dine av di du berre har løyve til å logga inn med OpenID.
Du ville ikkje ha kunna logga inn utan ein OpenID.',
	'openiddelete-sucess' => 'OpenID har vorte fjerna frå kontoen din',
	'openiddelete-error' => 'Ein feil oppstod i prosessen med å fjerna OpenID frå kontoen din.',
	'openid-prefstext' => '[http://openid.net/ OpenID]-innstillingar',
	'openid-pref-hide' => 'Gøym OpenID på brukarsida di om du loggar inn med ein.',
	'openid-pref-update-userinfo-on-login' => 'Oppdatér den fylgjande informasjonen frå OpenID-persona kvar gong eg loggar inn',
	'openid-urls-desc' => 'OpenID-ar knytte til brukarkontoen din:',
	'openid-urls-action' => 'Handling',
	'openid-urls-delete' => 'Slett',
	'openid-add-url' => 'Legg til ein ny OpenID',
	'openidsigninorcreateaccount' => 'Logg inn eller lag ein ny konto',
	'openid-provider-label-openid' => 'Skriv inn OpenID-URL-en din.',
	'openid-provider-label-google' => 'Logg inn med Google-kontoen din',
	'openid-provider-label-yahoo' => 'Logg inn med Yahoo-kontoen din',
	'openid-provider-label-aol' => 'Skriv inn AOL-skjermnamnet ditt',
	'openid-provider-label-other-username' => 'Skriv inn $1-brukarnamnet ditt',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'openid-desc' => 'Logg inn på wikien med en [http://openid.net/ OpenID] og logg inn på andre sider som bruker OpenID med kontoen herfra',
	'openidlogin' => 'Logg inn med OpenID',
	'openidserver' => 'OpenID-tjener',
	'openidxrds' => 'Yadis-fil',
	'openidconvert' => 'OpenID-konvertering',
	'openiderror' => 'Bekreftelsesfeil',
	'openiderrortext' => 'En feil oppsto under bekrefting av OpenID-adressen.',
	'openidconfigerror' => 'Oppsettsfeil med OpenID',
	'openidconfigerrortext' => 'Lagringsoppsettet for OpenID på denne wikien er ugyldig.
Vennligst kontakt en [[Special:ListUsers/sysop|administrator]].',
	'openidpermission' => 'Tillatelsesfeil med OpenID',
	'openidpermissiontext' => 'Du kan ikke logge inn på denne tjeneren med OpenID-en du oppga.',
	'openidcancel' => 'Bekreftelse avbrutt',
	'openidcanceltext' => 'Bekreftelsen av OpenID-adressen ble avbrutt.',
	'openidfailure' => 'Bekreftelse mislyktes',
	'openidfailuretext' => 'Bekreftelse av OpenID-adressen mislyktes. Feilbeskjed: «$1»',
	'openidsuccess' => 'Bekreftelse lyktes',
	'openidsuccesstext' => 'Bekreftelse av OpenID-adressen lyktes.',
	'openidusernameprefix' => 'OpenID-bruker',
	'openidserverlogininstructions' => 'Skriv inn passordet ditt nedenfor for å logge på $3 som $2 (brukerside $1).',
	'openidtrustinstructions' => 'Sjekk om du ønsker å dele data med $1.',
	'openidallowtrust' => 'La $1 stole på denne kontoen.',
	'openidnopolicy' => 'Siden har ingen personvernerklæring.',
	'openidpolicy' => 'Sjekk <a href="_new" href="$1">personvernerklæringen</a> for mer informasjon.',
	'openidoptional' => 'Valgfri',
	'openidrequired' => 'Påkrevd',
	'openidnickname' => 'Kallenavn',
	'openidfullname' => 'Fullt navn',
	'openidemail' => 'E-postadresse',
	'openidlanguage' => 'Språk',
	'openidtimezone' => 'Tidssone',
	'openidchooselegend' => 'Velg brukernavn',
	'openidchooseinstructions' => 'Alle brukere må ha et kallenavn; du kan velge blant valgene nedenfor.',
	'openidchoosenick' => 'Ditt kallenavn ($1)',
	'openidchoosefull' => 'Fullt navn ($1)',
	'openidchooseurl' => 'Et navn tatt fra din OpenID ($1)',
	'openidchooseauto' => 'Et automatisk opprettet navn ($1)',
	'openidchoosemanual' => 'Et valgfritt navn:',
	'openidchooseexisting' => 'En eksisterende konto på denne wikien',
	'openidchooseusername' => 'brukernavn:',
	'openidchoosepassword' => 'passord:',
	'openidconvertinstructions' => 'Dette skjemaet lar deg endre brukerkontoen din til å bruke en OpenID-adresse eller å legge til flere OpenID-adresser.',
	'openidconvertoraddmoreids' => 'Konverter til OpenID eller legg til en annen OpenID-adresse',
	'openidconvertsuccess' => 'Konverterte til OpenID',
	'openidconvertsuccesstext' => 'Du har konvertert din OpenID til $1.',
	'openidconvertyourstext' => 'Det er allerede din OpenID.',
	'openidconvertothertext' => 'Den OpenID-en tilhører noen andre.',
	'openidalreadyloggedin' => "'''$1, du er allerede logget inn.'''

Om du ønsker å bruke OpenID i framtiden, kan du [[Special:OpenIDConvert|konvertere kontoen din til å bruke OpenID]].",
	'openidnousername' => 'Intet brukernavn oppgitt.',
	'openidbadusername' => 'Ugyldig brukernavn oppgitt.',
	'openidautosubmit' => 'Denne siden inneholder et skjema som vil leveres automatisk om du har JavaScript slått på.
Om ikke, trykk på «Continue» (Fortsett).',
	'openidclientonlytext' => 'Du kan ikke bruke kontoer fra denne wikien som OpenID på en annen side.',
	'openidloginlabel' => 'OpenID-adresse',
	'openidlogininstructions' => '{{SITENAME}} støtter [http://openid.net/ OpenID]-standarden for enhetlig innlogging på forskjellige nettsteder.
OpenID lar deg logge inn på mange forskjellige nettsider uten at du må bruke forskjellige passord på hver.
(Se [http://nn.wikipedia.org/wiki/OpenID Wikipedia-artikkelen om OpenID] for mer informasjon.)

Om du allerede har en konto på {{SITENAME}}, kan du [[Special:UserLogin|logga på]] som vanlig med brukarnavnet og passordet ditt.
For å bruke OpenID i fremtiden, kan du [[Special:OpenIDConvert|konvertere kontoen din til OpenID]] etter at du har logget inn på vanlig måte.

Det er mange [http://wiki.openid.net/Public_OpenID_providers leverandører av OpenID], og du kan allerede ha en OpenID-aktivert konto et annet sted.',
	'openidupdateuserinfo' => 'Oppdater min personlige informasjon:',
	'openiddelete' => 'Slett OpenID',
	'openiddelete-text' => 'Ved å klikke på «{{int:openiddelete-button}}»-knappen vil du fjerne OpenID $1 fra din konto.
Du vil ikke lenger ha mulighet til å logge inn med denne OpenID.',
	'openiddelete-button' => 'Bekreft',
	'openiddeleteerrornopassword' => 'Du kan ikke slette alle dine OpenID-er fordi kontoen din ikke har noe passord.
Du ville ikke kunne logge inn uten en OpenID.',
	'openiddeleteerroropenidonly' => 'Du kan ikke slette alle dine OpenID-er fordi du kun kan logge inn med en OpenID.
Du ville ikke kunne logge inn uten en OpenID.',
	'openiddelete-sucess' => 'OpenID-en har blitt fjernet fra din konto.',
	'openiddelete-error' => 'En feil oppsto i prosessen med å fjerne OpenID-en fra din konto.',
	'openid-prefstext' => '[http://openid.net/ OpenID] innstillinger',
	'openid-pref-hide' => 'Skjul OpenID på brukersiden din om du logger inn med en.',
	'openid-pref-update-userinfo-on-login' => 'Oppdater den følgende informasjonen fra OpenID-persona hver gang jeg logger inn:',
	'openid-urls-desc' => 'OpenID-er knyttet til din brukerkonto:',
	'openid-urls-action' => 'Handling',
	'openid-urls-delete' => 'Slett',
	'openid-add-url' => 'Legg til en ny OpenID',
	'openidsigninorcreateaccount' => 'Logg inn eller lag en ny konto',
	'openid-provider-label-openid' => 'Skriv inn din OpenID-nettadresse',
	'openid-provider-label-google' => 'Logg inn med din Google-konto',
	'openid-provider-label-yahoo' => 'Logg inn med din Yahoo-konto',
	'openid-provider-label-aol' => 'Skriv inn ditt AOL-skjermnavn',
	'openid-provider-label-other-username' => 'Skriv inn ditt $1-brukernavn',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'openid-desc' => "Se connècta al wiki amb [http://openid.net/ OpenID] e se connècta a d'autres sites internet OpenID amb un wiki qu'utiliza un compte d'utilizaire.",
	'openidlogin' => 'Se connectar amb OpenID',
	'openidserver' => 'Servidor OpenID',
	'openidxrds' => 'Fichièr Yadis',
	'openidconvert' => 'Convertisseire OpenID',
	'openiderror' => 'Error de verificacion',
	'openiderrortext' => "Una error es intervenguda pendent la verificacion de l'adreça OpenID.",
	'openidconfigerror' => 'Error de configuracion de OpenID',
	'openidconfigerrortext' => "L'estocatge de la configuracion OpenID per aqueste wiki es incorrècte.
Metetz-vos en rapòrt amb l’[[Special:ListUsers/sysop|administrator]].",
	'openidpermission' => 'Error de permission OpenID',
	'openidpermissiontext' => "L’OpenID qu'avètz provesida es pas autorizada a se connectar sus aqueste servidor.",
	'openidcancel' => 'Verificacion anullada',
	'openidcanceltext' => 'La verificacion de l’adreça OpenID es estada anullada.',
	'openidfailure' => 'Fracàs de la verificacion',
	'openidfailuretext' => 'La verificacion de l’adreça OpenID a fracassat. Messatge d’error : « $1 »',
	'openidsuccess' => 'Verificacion capitada',
	'openidsuccesstext' => 'Verificacion de l’adreça OpenID capitada.',
	'openidusernameprefix' => 'Utilizaire OpenID',
	'openidserverlogininstructions' => "Picatz vòstre senhal çaijós per vos connectar sus $3 coma utilizaire '''$2''' (pagina d'utilizaire $1).",
	'openidtrustinstructions' => 'Marcatz se desiratz partejar las donadas amb $1.',
	'openidallowtrust' => "Autoriza $1 a far fisança a aqueste compte d'utilizaire.",
	'openidnopolicy' => 'Lo site a pas indicat una politica de donadas personalas.',
	'openidpolicy' => 'Verificar la <a target="_new" href="$1">Politica de las donadas personalas</a> per mai d’entresenhas.',
	'openidoptional' => 'Facultatiu',
	'openidrequired' => 'Exigit',
	'openidnickname' => 'Escais',
	'openidfullname' => 'Nom complet',
	'openidemail' => 'Adreça de corrièr electronic',
	'openidlanguage' => 'Lenga',
	'openidtimezone' => 'Zòna orària',
	'openidchooseinstructions' => "Totes los utilizaires an besonh d'un escais ; ne podètz causir un a partir de la causida çaijós.",
	'openidchoosefull' => 'Vòstre nom complet ($1)',
	'openidchooseurl' => 'Un nom es estat causit dempuèi vòstra OpenID ($1)',
	'openidchooseauto' => 'Un nom creat automaticament ($1)',
	'openidchoosemanual' => "Un nom qu'avètz causit :",
	'openidchooseexisting' => 'Un compte existent sus aqueste wiki :',
	'openidchoosepassword' => 'Senhal :',
	'openidconvertinstructions' => "Aqueste formulari vos permet de cambiar vòstre compte d'utilizaire per utilizar una adreça OpenID o apondre d'adreças OpenID suplementàrias.",
	'openidconvertoraddmoreids' => 'Convertir cap a OpenID o apondre una autra adreça OpenID',
	'openidconvertsuccess' => 'Convertit amb succès cap a OpenID',
	'openidconvertsuccesstext' => 'Avètz convertit amb succès vòstra OpenID cap a $1.',
	'openidconvertyourstext' => 'Ja es vòstra OpenID.',
	'openidconvertothertext' => "Aquò es quicòm d'autre qu'una OpenID.",
	'openidalreadyloggedin' => "'''Ja sètz connectat, $1 !'''

Se desiratz utilizar vòstra OpenID per vos connectar ulteriorament, podètz [[Special:OpenIDConvert|convertir vòstre compte per utilizar OpenID]].",
	'openidnousername' => 'Cap de nom d’utilizaire es pas estat indicat.',
	'openidbadusername' => 'Un nom d’utilizaire marrit es estat indicat.',
	'openidautosubmit' => "Aquesta pagina conten un formulari que poiriá èsser mandat automaticament s'avètz activat JavaScript.
S’èra pas lo cas, ensajatz lo boton « Continue » (Contunhar).",
	'openidclientonlytext' => 'Podètz pas utilizar de comptes dempuèi aqueste wiki en tant qu’OpenID sus d’autres sites.',
	'openidloginlabel' => 'Adreça OpenID',
	'openidlogininstructions' => "{{SITENAME}} supòrta lo format [http://openid.net/ OpenID] estandard per una sola signatura entre de sites Internet.
OpenID vos permet de vos connectar sus mantun site diferent sens aver d'utilizar un senhal diferent per cadun d’entre eles.
(Vejatz [http://en.wikipedia.org/wiki/OpenID Wikipedia's OpenID article] per mai d'entresenhas.)

S'avètz ja un compte sus {{SITENAME}}, vos podètz [[Special:UserLogin|connectar]] amb vòstre nom d'utilizaire e son senhal coma de costuma. Per utilizar OpenID, a l’avenidor, podètz [[Special:OpenIDConvert|convertir vòstre compte en OpenID]] aprèp vos èsser connectat normalament.

Existís mantun [http://wiki.openid.net/Public_OpenID_providers provesidor d'OpenID publicas], e podètz ja obténer un compte OpenID activat sus un autre servici.",
	'openidupdateuserinfo' => 'Metre a jorn mas donadas personalas',
	'openiddelete' => "Suprimir l'OpenID",
	'openiddelete-text' => "En clicant sul boton « {{int:openiddelete-button}} », suprimtz l'OpenID $1 de vòstre compte.
Vos poiretz pas pus connectar amb aquesta OpenID.",
	'openiddelete-button' => 'Confirmar',
	'openiddelete-sucess' => "L'OpenID es estada suprimida amb succès de vòstre compte.",
	'openiddelete-error' => "Una error es arribada pendent la supression de l'OpenID de vòstre compte.",
	'openid-prefstext' => 'Preferéncias de [http://openid.net/ OpenID]',
	'openid-pref-hide' => "Amaga vòstra OpenID sus vòstra pagina d'utilizaire, se vos connectaz amb OpenID.",
	'openid-pref-update-userinfo-on-login' => 'Metre a jorn las donadas seguentas dempuèi OpenID a cada còp que me connecti :',
	'openid-urls-desc' => 'OpenID associadas amb vòstre compte :',
	'openid-urls-action' => 'Accion',
	'openid-urls-delete' => 'Suprimir',
	'openid-add-url' => 'Apondre un OpenID novèla',
	'openidsigninorcreateaccount' => 'Se connectar o crear un compte novèl',
	'openid-provider-label-openid' => 'Picatz vòstra URL OpenID',
	'openid-provider-label-google' => 'Vos connectar en utilizant vòstre compte Google',
	'openid-provider-label-yahoo' => 'Vos connectar en utilizant vòstre compte Yahoo',
	'openid-provider-label-aol' => 'Picatz vòstre nom AOL',
	'openid-provider-label-other-username' => "Picatz vòstre nom d'utilizaire $1",
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'openidnickname' => 'Фæсномыг',
	'openidlanguage' => 'Æвзаг',
	'openidchoosepassword' => 'пароль:',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'openidlanguage' => 'Schprooch',
	'openidchoosepassword' => 'Paesswatt:',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'openidchoosepassword' => 'Passwuat:',
);

/** Polish (Polski)
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'openid-desc' => 'Logowanie się do wiki z użyciem [http://openid.net/ OpenID], oraz logowanie się do innych witryn używających OpenID z użyciem konta użytkownika z wiki',
	'openidlogin' => 'Zaloguj używając OpenID',
	'openidserver' => 'Serwer OpenID',
	'openidxrds' => 'Plik Yadis',
	'openidconvert' => 'Obsługa OpenID',
	'openiderror' => 'Błąd weryfikacji',
	'openiderrortext' => 'Wystąpił błąd podczas weryfikacji adresu URL OpenID.',
	'openidconfigerror' => 'Błąd konfiguracji OpenID',
	'openidconfigerrortext' => 'Konfiguracja przechowywania w OpenID dla tej wiki jest nieprawidłowa.
Skonsultuj to z [[Special:ListUsers/sysop|administratorem]].',
	'openidpermission' => 'Błąd uprawnień OpenID',
	'openidpermissiontext' => 'OpenID, które podałeś nie ma uprawnień do logowania na ten serwer.',
	'openidcancel' => 'Weryfikacja anulowana',
	'openidcanceltext' => 'Weryfikacja adresu URL OpenID została przerwana.',
	'openidfailure' => 'Weryfikacja nie powiodła się',
	'openidfailuretext' => 'Weryfikacja adresu URL OpenID nie powiodła się. Komunikat o błędzie – „$1”',
	'openidsuccess' => 'Weryfikacja udana',
	'openidsuccesstext' => 'Zweryfikowano adres URL OpenID.',
	'openidusernameprefix' => 'UżytkownikOpenID',
	'openidserverlogininstructions' => 'Wpisz swoje hasło, aby zalogować się do $3 jako użytkownik $2 (strona użytkownika $1).',
	'openidtrustinstructions' => 'Sprawdź, czy chcesz wymieniać informacje z $1.',
	'openidallowtrust' => 'Zezwól $1 na użycie tego konta użytkownika.',
	'openidnopolicy' => 'Witryna nie ma określonej polityki prywatności.',
	'openidpolicy' => 'Zapoznaj się z <a target="_new" href="$1">polityką prywatności</a> aby uzyskać więcej informacji.',
	'openidoptional' => 'Opcjonalnie',
	'openidrequired' => 'Wymagane',
	'openidnickname' => 'Nazwa użytkownika',
	'openidfullname' => 'Imię i nazwisko',
	'openidemail' => 'Adres e‐mail',
	'openidlanguage' => 'Język',
	'openidtimezone' => 'Strefa czasowa',
	'openidchooseinstructions' => 'Wszyscy użytkownicy muszą mieć pseudonim.
Możesz wybrać spośród propozycji podanych poniżej.',
	'openidchoosefull' => 'Twoje imię i nazwisko ($1)',
	'openidchooseurl' => 'Nazwa wybrana spośród OpenID ($1)',
	'openidchooseauto' => 'Automatycznie utworzono nazwę użytkownika ($1)',
	'openidchoosemanual' => 'Nazwa użytkownika wybrana przez Ciebie',
	'openidchooseexisting' => 'Istniejące konto na tej wiki',
	'openidchoosepassword' => 'hasło',
	'openidconvertinstructions' => 'Formularz umożliwia przystosowanie konta użytkownika do korzystania z adresu URL OpenID lub dodanie następnych adresów URL OpenID.',
	'openidconvertoraddmoreids' => 'Konwertuj do OpenID lub dodaj kolejny adres URL OpenID',
	'openidconvertsuccess' => 'Przełączone na korzystanie z OpenID',
	'openidconvertsuccesstext' => 'Zmieniłeś swoje OpenID na $1.',
	'openidconvertyourstext' => 'Już masz swój OpenID.',
	'openidconvertothertext' => 'To jest OpenID należące do kogoś innego.',
	'openidalreadyloggedin' => "'''Jesteś już zalogowany jako $1!'''

Jeśli chcesz w przyszłości używać OpenID do logowania się, możesz [[Special:OpenIDConvert|przełączyć konto na korzystanie z OpenID]].",
	'openidnousername' => 'Nie wybrano żadnej nazwy użytkownika.',
	'openidbadusername' => 'Wybrano nieprawidłową nazwę użytkownika.',
	'openidautosubmit' => 'Strona zawiera formularz, który powinien zostać automatycznie przesłany jeśli masz włączoną obsługę JavaScript.
Jeśli tak się nie stało spróbuj wcisnąć klawisz „Continue” (Kontynuuj).',
	'openidclientonlytext' => 'Nie można korzystać z kont tej wiki jako OpenID w innych witrynach.',
	'openidloginlabel' => 'Adres URL OpenID',
	'openidlogininstructions' => '{{SITENAME}} korzysta ze standardu [http://openid.net/ OpenID] dla zapewnienia jednolitego uwierzytelnienia pomiędzy różnymi witrynami w sieci Web.
OpenID pozwala na zalogowanie się do wielu różnych witryn sieci Web bez użycia osobnego hasła dla każdej witryny. 
(Zobacz [http://pl.wikipedia.org/wiki/OpenID artykuł o OpenID w Wikipedii] jeśli chcesz uzyskać więcej informacji.)

Jeśli masz już konto w {{GRAMMAR:MS.lp|{{SITENAME}}}}, możesz [[Special:UserLogin|zalogować się]] jak zwykle używając nazwy użytkownika i hasła. 
Jeśli chcesz w przyszłości używać OpenID do logowania się, możesz [[Special:OpenIDConvert|przełączyć konto na korzystanie z OpenID]] po normalnym zalogowaniu się.

Jest wielu [http://openid.net/get/ operatorów usługi OpenID] i możesz mieć już konto przełączone na korzystanie z OpenID innego usługodawcy.',
	'openidupdateuserinfo' => 'Uaktualnij moje dane',
	'openiddelete' => 'Usuń OpenID',
	'openiddelete-text' => 'Klikając na przycisk „{{int:openiddelete-button}}” usuniesz OpenID $1 ze swojego konta.
Nie będziesz już mógł więcej logować się korzystając z tego OpenID.',
	'openiddelete-button' => 'Zapisz',
	'openiddelete-sucess' => 'OpenID został pomyślnie usunięty z Twojego konta.',
	'openiddelete-error' => 'Wystąpił błąd podczas usuwania powiązania Twojego konta z OpenID.',
	'openid-prefstext' => 'Preferencje [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Ukryj mój adres URL OpenID na stronie użytkownika, jeśli zaloguję się za pomocą OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Aktualizuj następujące informacje o mnie z OpenID przy każdym logowaniu',
	'openid-urls-desc' => 'OpenID powiązane z Twoim kontem:',
	'openid-urls-action' => 'Akcja',
	'openid-urls-delete' => 'Usuń',
	'openid-add-url' => 'Dodaj nowe OpenID',
	'openidsigninorcreateaccount' => 'Zaloguj się lub utwórz nowe konto',
	'openid-provider-label-openid' => 'Wprowadź adres OpenID',
	'openid-provider-label-google' => 'Zaloguj się korzystając z konta Google',
	'openid-provider-label-yahoo' => 'Zaloguj się korzystając z konta Yahoo',
	'openid-provider-label-aol' => 'Wprowadź nazwę wyświetlaną AOL',
	'openid-provider-label-other-username' => 'Wprowadź swoją nazwę użytkownika $1',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'openid-desc' => "Intra ant la wiki con [http://openid.net/ OpenID], e intra ant j'àutri sit dl'aragnà OpenID con un cont utent wiki",
	'openidlogin' => 'Intré ant ël sistema con OpenID',
	'openidserver' => 'servent OpenID',
	'openidxrds' => 'Archivi Yadis',
	'openidconvert' => 'Convertidor OpenID',
	'openiderror' => 'Eror ëd verìfica',
	'openiderrortext' => "A l'é capitaje n'eror an verificand l'adrëssa OpenID.",
	'openidconfigerror' => "Eror ëd configurassion d'OpenID",
	'openidconfigerrortext' => "La configurassion ëd memorisassion d'OpenID për sta wiki-sì a l'é pa bon-a.
Për piasì ch'a consulta n'[[Special:ListUsers/sysop|aministrator]].",
	'openidpermission' => "Eror ëd përmess d'OpenID",
	'openidpermissiontext' => "L'OpenID ch'a l'ha dàit a peul pa intré an sto servent-sì.",
	'openidcancel' => 'Verìfica scancelà',
	'openidcanceltext' => "La verìfica dl'adrëssa OpenID a l'é stàita scancelà.",
	'openidfailure' => 'verìfica falìa',
	'openidfailuretext' => 'Verìfica ëd l\'adrëssa OpenID falìa. Messagi d\'eror: "$1"',
	'openidsuccess' => 'Verìfica andàita bin',
	'openidsuccesstext' => "Verìfica dl'adrëssa OpenID andàita bin.",
	'openidusernameprefix' => 'Utent OpenID',
	'openidserverlogininstructions' => "Ch'a anserissa soa ciav sì-sota për intré an $3 com utent $2 (pàgina utent $1).",
	'openidtrustinstructions' => "Contròla s'it veule condivide dat con $1.",
	'openidallowtrust' => 'A përmët a $1 ëd fidesse dë sto cont utent-sì.',
	'openidnopolicy' => "Ël sit a l'ha pa spessificà dle régole ëd riservatëssa.",
	'openidpolicy' => 'Contròla le <a target="_new" href="$1">régole ëd riservatëssa</a> për savèjne ëd pi.',
	'openidoptional' => 'Opsional',
	'openidrequired' => 'Obligatòri',
	'openidnickname' => 'Stranòm',
	'openidfullname' => 'Nòm complet',
	'openidemail' => 'Adrëssa ëd pòsta eletrònica',
	'openidlanguage' => 'Lenga',
	'openidtimezone' => 'Fus orari',
	'openidchooselegend' => 'Sërnùa dël nòm utent',
	'openidchooseinstructions' => "Tùit j'utent a l'han dabzògn ëd në stranòm,
a peul sern-ne un da j'opsion sì-sota.",
	'openidchoosenick' => 'Tò stranòm ($1)',
	'openidchoosefull' => 'Tò nòm complet ($1)',
	'openidchooseurl' => 'Un nòm sërnù da tò OpenID ($1)',
	'openidchooseauto' => 'Un nòm generà da sol ($1)',
	'openidchoosemanual' => 'Un nòm sërnù da ti:',
	'openidchooseexisting' => 'Un cont esistent an sta wiki-sì',
	'openidchooseusername' => 'nòm utent:',
	'openidchoosepassword' => 'ciav:',
	'openidconvertinstructions' => "Sta forma-sì a-j përmët ëd cangé sò cont utent për dovré n'adrëssa OpenID o për gionté d'adrësse OpenID",
	'openidconvertoraddmoreids' => "Convertì a OpenID o gionté n'àutra adrëssa OpenID",
	'openidconvertsuccess' => 'Convertì da bin a OpenID',
	'openidconvertsuccesstext' => "A l'ha convertì da bin sò OpenID a $1",
	'openidconvertyourstext' => "Cost-sì a l'é già sò OpenID.",
	'openidconvertothertext' => "Cost-sì a l'é l'OpenID ëd cheidun d'àutri.",
	'openidalreadyloggedin' => "'''A l'é già intrà ant ël sistema, $1!'''

S'a veul dovré OpenID për intré ant l'avnì, a peul [[Special:OpenIDConvert|convertì sò cont për dovré OpenID]].",
	'openidnousername' => 'Gnun nòm utent spessificà.',
	'openidbadusername' => 'Nòm utent spessificà pa bon.',
	'openidautosubmit' => 'Sta pàgina-sì a conten un formolari che a dovrìa esse spedì automaticament se chiel a l\'ha JavaScript abilità. 
Dësnò, ch\'a preuva ël boton "Continua".',
	'openidclientonlytext' => "A peul pa dovré dij cont da sta wiki-sì com OpenID dzora a n'àutr sit.",
	'openidloginlabel' => 'Adrëssa OpenID',
	'openidlogininstructions' => "{{SITENAME}} a sosten lë stàndard [http://openid.net/ OpenID] për na signadura sola antra sit ëd l'aragnà. OpenID at përmët ëd rintré an vàire sit diferent an sl'aragnà sensa dovré na ciav diferenta për mincadun. (Varda [http://en.wikipedia.org/wiki/OpenID Artìcol OpenID ëd Wikipedia] për savèjne ëd pi).

S'a l'ha già un cont dzora a {{SITENAME}}, a peul [[Special:UserLogin|intré ant ël sistema]] con sò nòm utent e ciav com normal.
Për dovré OpenID ant l'avnì, a peul [[Special:OpenIDConvert|convertì sò cont a OpenID]] apress ch'a sia intrà normalment.

A-i é già motobin ëd [http://openid.net/get/ fornitor d'OpenID], e a podrìa già avèj un cont abilità a OpenID dzora a n'àutr servissi.",
	'openidupdateuserinfo' => 'Modìfica mie anformassion përsonaj:',
	'openiddelete' => 'Scancela OpenID',
	'openiddelete-text' => 'An sgnacand ël boton "{{int:openiddelete-button}}", it gavras l\'OpenID $1 da tò cont.
It saras pa pi bon a intré con sto OpenID-sì.',
	'openiddelete-button' => 'Conferma',
	'openiddeleteerrornopassword' => "A peul pa scancelé tùit ij sò OpenID përchè tò sont a l'ha pa 'd ciav.
A podrà pa intré ant ël sistema sensa n'OpenID.",
	'openiddeleteerroropenidonly' => "A peul pa scancelé tùit ij sò OpenID përchè a peule intré intré ant ël sistema mach con OpenID.
A podrà pa intré sensa n'OpenID.",
	'openiddelete-sucess' => "L'OpenID a l'é stàit gavà da bin da tò cont.",
	'openiddelete-error' => "A l'é capitaje n'eror an gavand l'OpenID da tò cont.",
	'openid-prefstext' => 'Preferense [http://openid.net/ OpenID]',
	'openid-pref-hide' => "Stërmé soa adrëssa OpenID dzora a soa pàgina utent, s'a intra con openID.",
	'openid-pref-update-userinfo-on-login' => "Modifiché j'anformassion përsonaj sì-sota OpenID minca vira ch'i intro:",
	'openid-urls-desc' => 'OpenID associà con tò cont:',
	'openid-urls-action' => 'Assion',
	'openid-urls-delete' => 'Scancela',
	'openid-add-url' => 'Gionta un neuv OpenID',
	'openidsigninorcreateaccount' => 'Intra o Crea un Neuv Cont',
	'openid-provider-label-openid' => "Ch'a anserissa soa adrëssa OpenID",
	'openid-provider-label-google' => 'Intra an dovrand tò cont Google',
	'openid-provider-label-yahoo' => 'Intra an dovrand tò cont Yahoo',
	'openid-provider-label-aol' => "Ch'a anserissa sò nòm AOL",
	'openid-provider-label-other-username' => "Ch'a anserissa sò nòm utent $1",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'openidnickname' => 'کورنی نوم',
	'openidfullname' => 'بشپړ نوم',
	'openidemail' => 'برېښليک پته',
	'openidlanguage' => 'ژبه',
	'openidtimezone' => 'د وخت سيمه',
	'openidchooseinstructions' => 'ټولو کارونکيو ته د يوه کورني نوم اړتيا شته؛
تاسو يو نوم د لاندينيو خوښو نه ځانته ټاکلی شی.',
	'openidchoosefull' => 'ستاسو بشپړ نوم ($1)',
	'openidchoosemanual' => 'ستاسو د خوښې يو نوم:',
	'openidchooseusername' => 'کارن-نوم:',
	'openidchoosepassword' => 'پټنوم:',
	'openidnousername' => 'هېڅ يو کارن-نوم نه دی ځانګړی شوی.',
	'openidbadusername' => 'يو ناسم کارن-نوم مو ځانګړی کړی.',
	'openid-urls-delete' => 'ړنګول',
	'openid-provider-label-other-username' => 'تاسې خپل $1 کارن-نوم وليکۍ',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'openid-desc' => 'Autentique-se na wiki com um [http://openid.net/ OpenID] e autentique-se noutros sítios que usem OpenID com uma conta de utilizador wiki',
	'openidlogin' => 'Autenticação com OpenID',
	'openidserver' => 'Servidor OpenID',
	'openidxrds' => 'Ficheiro Yadis',
	'openidconvert' => 'Conversor de OpenID',
	'openiderror' => 'Erro de verificação',
	'openiderrortext' => 'Ocorreu um erro durante a verificação da URL OpenID.',
	'openidconfigerror' => 'Erro de Configuração do OpenID',
	'openidconfigerrortext' => 'A configuração de armazenamento OpenID para esta wiki é inválida.
Por favor, consulte um [[Special:ListUsers/sysop|administrador]].',
	'openidpermission' => 'Erro de permissões OpenID',
	'openidpermissiontext' => 'O OpenID fornecido não está autorizado a autenticar-se neste servidor.',
	'openidcancel' => 'Verificação cancelada',
	'openidcanceltext' => 'A verificação da URL OpenID foi cancelada.',
	'openidfailure' => 'Verificação falhou',
	'openidfailuretext' => 'A verificação da URL OpenID falhou. Mensagem de erro: "$1"',
	'openidsuccess' => 'Verificação com sucesso',
	'openidsuccesstext' => 'A verificação da URL OpenID foi bem sucedida.',
	'openidusernameprefix' => 'UtilizadorOpenID',
	'openidserverlogininstructions' => 'Introduza a sua palavra-chave abaixo para se autenticar em $3 como utilizador $2 (página de utilizador $1).',
	'openidtrustinstructions' => 'Verifique se pretender partilhar dados com $1.',
	'openidallowtrust' => 'Permitir que $1 confie nesta conta de utilizador.',
	'openidnopolicy' => 'O sítio não especificou uma política de privacidade.',
	'openidpolicy' => 'Consulte a <a target="_new" href="$1">política de privacidade</a> para mais informações.',
	'openidoptional' => 'Opcional',
	'openidrequired' => 'Requerido',
	'openidnickname' => 'Alcunha',
	'openidfullname' => 'Nome completo',
	'openidemail' => 'Correio electrónico',
	'openidlanguage' => 'Língua',
	'openidtimezone' => 'Fuso horário',
	'openidchooselegend' => 'Escolha do nome de utilizador',
	'openidchooseinstructions' => 'Todos os utilizadores precisam de uma alcunha;
pode escolher uma das opções abaixo.',
	'openidchoosenick' => 'A sua alcunha ($1)',
	'openidchoosefull' => 'O seu nome completo ($1)',
	'openidchooseurl' => 'Um nome escolhido a partir do seu OpenID ($1)',
	'openidchooseauto' => 'Um nome gerado automaticamente ($1)',
	'openidchoosemanual' => 'Um nome à sua escolha:',
	'openidchooseexisting' => 'Uma conta existente nesta wiki',
	'openidchooseusername' => 'Nome de utilizador:',
	'openidchoosepassword' => 'palavra-chave:',
	'openidconvertinstructions' => 'Este formulário permite-lhe alterar a sua conta de utilizador para usar uma URL OpenID ou adicionar mais URLs OpenID.',
	'openidconvertoraddmoreids' => 'Converter para OpenID ou adicionar outra URL OpenID',
	'openidconvertsuccess' => 'Convertido para OpenID com sucesso',
	'openidconvertsuccesstext' => 'Você converteu com sucesso o seu OpenID para $1.',
	'openidconvertyourstext' => 'Esse já é o seu OpenID.',
	'openidconvertothertext' => 'Esse é o OpenID de outra pessoa.',
	'openidalreadyloggedin' => "'''Você já se encontra autenticado, $1!'''

Se de futuro pretender usar OpenID para se autenticar, pode [[Special:OpenIDConvert|converter a sua conta para usar OpenID]].",
	'openidnousername' => 'Nenhum nome de utilizador especificado.',
	'openidbadusername' => 'Nome de utilizador especificado inválido.',
	'openidautosubmit' => 'Esta página inclui um formulário que deverá ser automaticamente submetido se tiver JavaScript activado.
Caso contrário, utilize o botão "Continue" (Continuar).',
	'openidclientonlytext' => 'Pode usar contas desta wiki como OpenIDs noutro sítio.',
	'openidloginlabel' => 'URL do OpenID',
	'openidlogininstructions' => 'A {{SITENAME}} suporta o padrão [http://openid.net/ OpenID] para autenticação unificada entre vários sítios na internet.
O OpenID permite-lhe autenticar-se em vários sítios sem usar uma palavra-chave diferente em cada um
(veja [http://pt.wikipedia.org/wiki/OpenID o artigo OpenID na Wikipédia] para mais informações).

Se já possui uma conta na {{SITENAME}}, pode [[Special:UserLogin|autenticar-se]] com o seu nome de utilizador e palavra-chave como habitualmente.
Para utilizar o OpenID no futuro, pode [[Special:OpenIDConvert|converter a sua conta para OpenID]] depois de se ter autenticado normalmente.

Existem vários [http://wiki.openid.net/Public_OpenID_providers fornecederes de OpenID] e poderá já ter uma conta activada para OpenID noutro serviço.',
	'openidupdateuserinfo' => 'Atualizar a minha informação pessoal:',
	'openiddelete' => 'Eliminar OpenID',
	'openiddelete-text' => 'Ao clicar o botão "{{int:openiddelete-button}}", irá eliminar o OpenID $1 da sua conta.
Não poderá voltar a autenticar-se com este OpenID.',
	'openiddelete-button' => 'Confirmar',
	'openiddeleteerrornopassword' => 'Não pode apagar todos os seus OpenID porque a sua conta não tem palavra-chave.
Sem um OpenID não se poderia autenticar.',
	'openiddeleteerroropenidonly' => 'Não pode apagar todos os seus OpenID, porque só se pode autenticar usando um OpenID.
Sem um OpenID não se poderia autenticar.',
	'openiddelete-sucess' => 'O OpenID foi removido da sua conta com sucesso.',
	'openiddelete-error' => 'Ocorreu um erro ao remover o OpenID da sua conta.',
	'openid-prefstext' => 'Preferências do [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Esconder o seu OpenID na sua página de utilizador, se se autenticar com OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Atualizar a seguinte informação a partir da minha "persona" OpenID de cada vez que me autentico:',
	'openid-urls-desc' => 'OpenIDs associados à sua conta:',
	'openid-urls-action' => 'Acção',
	'openid-urls-delete' => 'Apagar',
	'openid-add-url' => 'Adicionar novo OpenID',
	'openidsigninorcreateaccount' => 'Entrar ou Criar Nova Conta',
	'openid-provider-label-openid' => 'Introduza a sua URL OpenID',
	'openid-provider-label-google' => 'Entrar usando a sua conta do Google',
	'openid-provider-label-yahoo' => 'Entrar usando a sua conta do Yahoo',
	'openid-provider-label-aol' => 'Introduza o seu nome de utilizador AOL',
	'openid-provider-label-other-username' => 'Introduza o seu nome de utilizador $1',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Hamilton Abreu
 * @author ZehRique
 */
$messages['pt-br'] = array(
	'openid-desc' => 'Autentique-se no wiki com um [http://openid.net/ OpenID], e autentique-se em outros sítios que usem OpenID com uma conta de utilizador wiki',
	'openidlogin' => 'Autenticação com OpenID',
	'openidserver' => 'Servidor OpenID',
	'openidxrds' => 'Arquivo Yadis',
	'openidconvert' => 'Conversor de OpenID',
	'openiderror' => 'Erro de verificação',
	'openiderrortext' => 'Ocorreu um erro durante a verificação da URL OpenID.',
	'openidconfigerror' => 'Erro de Configuração do OpenID',
	'openidconfigerrortext' => 'A configuração de armazenamento OpenID para este wiki é inválida.
Por favor, consulte um [[Special:ListUsers/sysop|administrator]].',
	'openidpermission' => 'Erro de permissões OpenID',
	'openidpermissiontext' => 'O OpenID fornecido não está autorizado a autenticar-se neste servidor.',
	'openidcancel' => 'Verificação cancelada',
	'openidcanceltext' => 'A verificação da URL OpenID foi cancelada.',
	'openidfailure' => 'Verificação falhou',
	'openidfailuretext' => 'A verificação da URL OpenID falhou. Mensagem de erro: "$1"',
	'openidsuccess' => 'Verificação com sucesso',
	'openidsuccesstext' => 'A verificação da URL OpenID foi bem sucedida.',
	'openidusernameprefix' => 'UtilizadorOpenID',
	'openidserverlogininstructions' => 'Introduza a sua palavra-chave abaixo para se autenticar em $3 como utilizador $2 (página de utilizador $1).',
	'openidtrustinstructions' => 'Verifique se pretende compartilhar dados com $1.',
	'openidallowtrust' => 'Permitir que $1 confie nesta conta de utilizador.',
	'openidnopolicy' => 'O sítio não especificou uma política de privacidade.',
	'openidpolicy' => 'Consulte a <a target="_new" href="$1">política de privacidade</a> para mais informações.',
	'openidoptional' => 'Opcional',
	'openidrequired' => 'Requerido',
	'openidnickname' => 'Apelido',
	'openidfullname' => 'Nome completo',
	'openidemail' => 'Endereço de e-mail',
	'openidlanguage' => 'Língua',
	'openidtimezone' => 'Fuso horário',
	'openidchooseinstructions' => 'Todos os utilizadores precisam de um apelido;
pode escolher uma das opções abaixo.',
	'openidchoosefull' => 'O seu nome completo ($1)',
	'openidchooseurl' => 'Um nome escolhido a partir do seu OpenID ($1)',
	'openidchooseauto' => 'Um nome gerado automaticamente ($1)',
	'openidchoosemanual' => 'Um nome à sua escolha:',
	'openidchooseexisting' => 'Uma conta existente neste wiki:',
	'openidchoosepassword' => 'palavra-chave:',
	'openidconvertinstructions' => 'Este formulário lhe permite alterar sua conta de usuário para usar uma URL OpenID ou adicionar mais URLs OpenID.',
	'openidconvertoraddmoreids' => 'Converter para OpenID ou adicionar outra URL OpenID',
	'openidconvertsuccess' => 'Convertido para OpenID com sucesso',
	'openidconvertsuccesstext' => 'Você converteu com sucesso o seu OpenID para $1.',
	'openidconvertyourstext' => 'Esse já é o seu OpenID.',
	'openidconvertothertext' => 'Esse é o OpenID de outra pessoa.',
	'openidalreadyloggedin' => "'''Você já se encontra autenticado, $1!'''

Se no futuro pretender usar OpenID para se autenticar, pode [[Special:OpenIDConvert|converter a sua conta para usar OpenID]].",
	'openidnousername' => 'Nenhum nome de utilizador especificado.',
	'openidbadusername' => 'Nome de utilizador especificado inválido.',
	'openidautosubmit' => 'Esta página inclui um formulário que deverá ser automaticamente submetido se tiver JavaScript ativado.
Caso contrário, utilize o botão "Continue" (Continuar).',
	'openidclientonlytext' => 'Você pode usar contas deste wiki como OpenIDs em outro sítio.',
	'openidloginlabel' => 'URL do OpenID',
	'openidlogininstructions' => '{{SITENAME}} suporta o padrão [http://openid.net/ OpenID] para autenticação única entre sítios Web.
O OpenID lhe permite autenticar-se em diversos sítios Web sem usar uma palavra-chave diferente em cada um.
(Veja [http://pt.wikipedia.org/wiki/OpenID o artigo OpenID na Wikipédia] para mais informação.)

Se já possui uma conta em {{SITENAME}}, pode [[Special:UserLogin|autenticar-se]] com o seu nome de utilizador e palavra-chave como habitualmente.
Para utilizar o OpenID no futuro, pode [[Special:OpenIDConvert|converter a sua conta em OpenID]] após autenticar-se normalmente.

Existem vários [http://wiki.openid.net/Public_OpenID_providers fornecederes de OpenID], e você poderá já ter uma conta ativada para OpenID em outro serviço.',
	'openidupdateuserinfo' => 'Atualizar a minha informação pessoal',
	'openiddelete' => 'Excluir OpenID',
	'openiddelete-text' => 'Ao clicar no botão "{{int:openiddelete-button}}", você removerá o OpenID $1 de sua conta.
Você não poderá mais efetuar autenticação com este OpenID.',
	'openiddelete-button' => 'Confirmar',
	'openiddeleteerrornopassword' => 'Você não pode apagar todos os seus OpenID porque a sua conta não tem uma palavra-chave.
Você ficaria impossibilitado de entrar na sua conta sem um OpenID.',
	'openiddeleteerroropenidonly' => 'Você não pode apagar todos os seus OpenID porque só pode entrar com OpenID.
Você não poderia entrar sem um OpenID.',
	'openiddelete-sucess' => 'O OpenID foi removido de sua conta com sucesso.',
	'openiddelete-error' => 'Ocorreu um erro enquanto removia o OpenID de sua conta.',
	'openid-prefstext' => 'Preferências do [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Esconder o seu OpenID na sua página de utilizador, caso se autentique com OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Atualizar a seguinte informação a partir da minha "persona" OpenID cada vez que me autentico',
	'openid-urls-desc' => 'OpenIDs associadas à sua conta:',
	'openid-urls-action' => 'Ação',
	'openid-urls-delete' => 'Excluir',
	'openid-add-url' => 'Adicionar novo OpenID',
	'openidsigninorcreateaccount' => 'Entrar ou Criar Nova Conta',
	'openid-provider-label-openid' => 'Introduza a sua URL OpenID',
	'openid-provider-label-google' => 'Entrar usando a sua conta do Google',
	'openid-provider-label-yahoo' => 'Entrar usando a sua conta do Yahoo',
	'openid-provider-label-aol' => 'Digite seu nome de utilizador AOL',
	'openid-provider-label-other-username' => 'Introduza o seu nome de utilizador $1',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'openidlogin' => 'Autentificare cu OpenID',
	'openidserver' => 'Server OpenID',
	'openidconvert' => 'Convertor OpenID',
	'openiderror' => 'Eroare de verificare',
	'openiderrortext' => 'A avut loc o eroare în timpul verificării URL-ului OpenID',
	'openidconfigerror' => 'Eroare de configurare OpenID',
	'openidpermission' => 'Eroare de permisiune OpenID',
	'openidcancel' => 'Verificare anulată',
	'openidcanceltext' => 'Verificarea URL-ului OpenID a fost anulată.',
	'openidfailure' => 'Verificare eşuată',
	'openidfailuretext' => 'Verificarea URL-ului OpenID a eşuat. Mesaj de eroare: "$1"',
	'openidsuccess' => 'Verificare cu succes',
	'openidsuccesstext' => 'Verificarea URL-ului OpenID a reuşit.',
	'openidusernameprefix' => 'Utilizator OpenID',
	'openidoptional' => 'Opţional',
	'openidrequired' => 'Necesar',
	'openidnickname' => 'Poreclă',
	'openidfullname' => 'Nume complet:',
	'openidemail' => 'Adresă e-mail',
	'openidlanguage' => 'Limbă',
	'openidtimezone' => 'Fus orar',
	'openidchooseinstructions' => 'Toţi utilizatorii necesită o poreclă;
se poate alege una din opţiunile de mai jos.',
	'openidchoosefull' => 'Numele întreg ($1)',
	'openidchooseauto' => 'Un nume generat automat ($1)',
	'openidchoosemanual' => 'Un nume la alegere:',
	'openidchooseexisting' => 'Un cont existent pe acest wiki:',
	'openidchoosepassword' => 'parolă:',
	'openidconvertsuccess' => 'Convertit cu succes la OpenID',
	'openidconvertothertext' => 'Acesta este OpenID-ul altcuiva.',
	'openidnousername' => 'Nici un nume de utilizator specificat.',
	'openidbadusername' => 'Nume de utilizator specificat greşit.',
	'openidloginlabel' => 'URL OpenID',
	'openiddelete' => 'Şterge OpenID',
	'openiddelete-button' => 'Confirmă',
	'openid-urls-action' => 'Acţiune',
	'openid-urls-delete' => 'Şterge',
	'openid-add-url' => 'Adaugă un nou OpenID',
	'openid-provider-label-google' => 'Autentificare folosind contul Google',
	'openid-provider-label-yahoo' => 'Autentificare folosind contul Yahoo',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'openidxrds' => 'File Yadis',
	'openidoptional' => 'Opzionele',
	'openidrequired' => 'Richieste',
	'openidnickname' => 'Soprannome',
	'openidfullname' => 'Nome comblete',
	'openidemail' => 'Indirizze e-mail',
	'openidlanguage' => 'Lènghe',
	'openidtimezone' => "Orarie d'a zone",
	'openidchoosefull' => "'U nome comblete tue ($1)",
	'openidchoosemanual' => "Scacchie 'nu nome:",
	'openidchoosepassword' => 'password:',
	'openidnousername' => 'Nisciune nome utende specificate.',
	'openidbadusername' => "'U nome utende specificate non g'è valide.",
	'openidloginlabel' => 'URL de OpenID',
	'openiddelete-button' => 'Conferme',
	'openid-prefstext' => 'Preferenze [http://openid.net/ OpenID]',
	'openid-urls-action' => 'Azione',
	'openid-urls-delete' => 'Scangille',
	'openidsigninorcreateaccount' => "Trase o ccreje 'nu cunde utende nuève",
	'openid-provider-label-openid' => "Mitte l'URL toje de OpenID",
	'openid-provider-label-google' => "Tràse ausanne 'u cunde utende de Google",
	'openid-provider-label-yahoo' => "Tràse ausanne 'u cunde utende de Yahoo",
	'openid-provider-label-aol' => "Mitte 'u tue nome utende AOL",
	'openid-provider-label-other-username' => "Mitte 'u tue $1 nome utende",
);

/** Russian (Русский)
 * @author Aleksandrit
 * @author Ferrer
 * @author Kaganer
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'openid-desc' => 'Вход в вики с помощью [http://openid.net/ OpenID], а также вход на другие сайты поддерживающие OpenID с помощью учётной записи в вики',
	'openidlogin' => 'Вход с помощью OpenID',
	'openidserver' => 'Сервер OpenID',
	'openidxrds' => 'Файл Yadis',
	'openidconvert' => 'Преобразователь OpenID',
	'openiderror' => 'Ошибка проверки полномочий',
	'openiderrortext' => 'Во время проверки адреса OpenID произошла ошибка.',
	'openidconfigerror' => 'Ошибка настройки OpenID',
	'openidconfigerrortext' => 'Настройка хранилища OpenID для этой вики ошибочна.
Пожалуйста, обратитесь к [[Special:ListUsers/sysop|администратору сайта]].',
	'openidpermission' => 'Ошибка прав доступа OpenID',
	'openidpermissiontext' => 'Указанный OpenID не позволяет войти на этот сервер.',
	'openidcancel' => 'Проверка отменена',
	'openidcanceltext' => 'Проверка адреса OpenID была отменена.',
	'openidfailure' => 'Проверка неудачна',
	'openidfailuretext' => 'Проверка адреса OpenID завершилась неудачей. Сообщение об ошибке: «$1»',
	'openidsuccess' => 'Проверка прошла успешно',
	'openidsuccesstext' => 'Проверка адреса OpenID прошла успешно.',
	'openidusernameprefix' => 'УчастникOpenID',
	'openidserverlogininstructions' => 'Введите ниже ваш пароль, чтобы войти на $3 как участник $2 (личная страница $1).',
	'openidtrustinstructions' => 'Отметьте, если вы хотите предоставить доступ к данным для $1.',
	'openidallowtrust' => 'Разрешить $1 доверять этой учётной записи.',
	'openidnopolicy' => 'Сайт не указал политику конфиденциальности.',
	'openidpolicy' => 'Дополнительную информацию см. в <a target="_new" href="$1">политике конфиденциальности</a>.',
	'openidoptional' => 'необязательное',
	'openidrequired' => 'обязательное',
	'openidnickname' => 'Псевдоним',
	'openidfullname' => 'Полное имя',
	'openidemail' => 'Адрес эл. почты',
	'openidlanguage' => 'Язык',
	'openidtimezone' => 'Часовой пояс',
	'openidchooselegend' => 'Выбор имени пользователя',
	'openidchooseinstructions' => 'Каждый участник должен иметь псевдоним;
вы можете выбрать один из представленных ниже.',
	'openidchoosenick' => 'Ваш ник ($1)',
	'openidchoosefull' => 'Ваше полное имя ($1)',
	'openidchooseurl' => 'Имя, полученное из вашего OpenID ($1)',
	'openidchooseauto' => 'Автоматически созданное имя ($1)',
	'openidchoosemanual' => 'Имя на ваш выбор:',
	'openidchooseexisting' => 'Существующая учётная запись на этой вики',
	'openidchooseusername' => 'имя участника:',
	'openidchoosepassword' => 'пароль:',
	'openidconvertinstructions' => 'Эта форма позволяет вам сменить использование вашей учётной записи на использование адреса OpenID, добавить несколько адресов OpenID.',
	'openidconvertoraddmoreids' => 'Преобразовать в OpenID или добавить другой адрес OpenID',
	'openidconvertsuccess' => 'Успешное преобразование в OpenID',
	'openidconvertsuccesstext' => 'Вы успешно преобразовали ваш OpenID в $1.',
	'openidconvertyourstext' => 'Это уже ваш OpenID.',
	'openidconvertothertext' => 'Это чужой OpenID.',
	'openidalreadyloggedin' => "'''Вы уже вошли, $1!'''

Если вы желаете использовать в будущем вход через OpenID, вы можете [[Special:OpenIDConvert|преобразовать вашу учётную запись для использования в OpenID]].",
	'openidnousername' => 'Не указано имя участника.',
	'openidbadusername' => 'Указано неверное имя участника.',
	'openidautosubmit' => 'Эта страница содержит форму, которая должна быть автоматически отправлена, если у вас включён JavaScript.
Если этого не произошло, попробуйте нажать на кнопку «Продолжить».',
	'openidclientonlytext' => 'Вы не можете использовать учётные записи с этой вики, как OpenID на другом сайте.',
	'openidloginlabel' => 'Адрес OpenID',
	'openidlogininstructions' => '{{SITENAME}} поддерживает стандарт [http://openid.net/ OpenID], позволяющий использовать одну учётную запись для входа на различные веб-сайты.
OpenID позволяет вам заходить на различные веб-сайты без указания разных паролей для них
(подробнее см. [http://ru.wikipedia.org/wiki/OpenID статью об OpenID в Википедии]).

Если вы уже имеете учётную запись на {{SITENAME}}, вы можете [[Special:UserLogin|войти]] как обычно, используя своё имя учётной записи и пароль.
Чтобы использовать в дальнейшем OpenID, вы можете [[Special:OpenIDConvert|преобразовать вашу учётную запись в OpenID]], после того, как вы вошли обычным образом.

Существует множество [http://openid.net/get/ общедоступных провайдеров OpenID], возможно, вы уже имеете учётную запись OpenID на другом сайте.',
	'openidupdateuserinfo' => 'Обновить мою личную информацию:',
	'openiddelete' => 'Удалить OpenID',
	'openiddelete-text' => 'Нажав на кнопку «{{int:openiddelete-button}}», Вы удалите OpenID $1 из своей учётной записи.
Вы больше не сможете входить с этим OpenID.',
	'openiddelete-button' => 'Подтвердить',
	'openiddeleteerrornopassword' => 'Вы не можете удалить все ваши OpenID, так как у вашей учётной записи нет пароля.
У вас не будет возможности войти в систему без OpenID.',
	'openiddeleteerroropenidonly' => 'Вы не можете удалить все ваши OpenID, так как вам разрешено входить в систему только с использованием OpenID.
У вас не будет возможности войти в систему без OpenID.',
	'openiddelete-sucess' => 'OpenID успешно удалён из Вашей учётной записи.',
	'openiddelete-error' => 'Произошла ошибка при удалении OpenID из Вашей учётной записи.',
	'openid-prefstext' => 'Параметры [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Скрывать ваш OpenID на вашей странице участника, если вы вошли с помощью OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Обновлять следующую информацию обо мне через OpenID каждый раз, когда я представляюсь системе:',
	'openid-urls-desc' => 'OpenID, связанные с Вашей учётной записью:',
	'openid-urls-action' => 'Действие',
	'openid-urls-delete' => 'Удалить',
	'openid-add-url' => 'Добавить новый OpenID',
	'openidsigninorcreateaccount' => 'Представиться системе или создать новую учётную запись',
	'openid-provider-label-openid' => 'Введите URL вашего OpenID',
	'openid-provider-label-google' => 'Представиться, используя учётную запись Google',
	'openid-provider-label-yahoo' => 'Представиться, используя учётную запись Yahoo',
	'openid-provider-label-aol' => 'Введите ваше имя в AOL',
	'openid-provider-label-other-username' => 'Введите ваше имя участника $1',
);

/** Sicilian (Sicilianu)
 * @author Melos
 * @author Santu
 */
$messages['scn'] = array(
	'openid-desc' => "Fai lu login a la wiki cu [http://openid.net/ OpenID] r a l'àutri siti web ca non ùsanu OpenID cu n'account wiki",
	'openidlogin' => 'Login cu OpenID',
	'openidserver' => 'server OpenID',
	'openidxrds' => 'file Yadis',
	'openidconvert' => 'cunvirtituri OpenID',
	'openiderror' => 'Sbàgghiu di virìfica',
	'openiderrortext' => "Ci fu n'erruri ntô mentri dâ virìfica di l'URL OpenID.",
	'openidconfigerror' => 'Sbàgghiu ntâ cunfigurazzioni OpenID',
	'openidconfigerrortext' => 'La cunfigurazzioni dâ mimurizzazzioni di OpenID pi sta wiki non è vàlida.
Pi favuri addumanna cunzigghiu a nu [[Special:ListUsers/sysop|amministraturi]].',
	'openidpermission' => 'Sbàgghiu nna li pirmessi OpenID',
	'openidpermissiontext' => "Non vinni pirmuttutu di fari lu login a stu server a l'OpenID ca dasti.",
	'openidcancel' => 'Virìfica scancillata',
	'openidcanceltext' => "La virìfica di l'URL OpenID vinni scancillata.",
	'openidfailure' => 'Virìfica falluta',
	'openidfailuretext' => 'La virìfica di l\'URL OpenID fallìu. Missaggiu di erruri: "$1"',
	'openidsuccess' => 'Virìfica fatta',
	'openidsuccesstext' => "La virìfica di l'URL OpenID vinni fatta cu successu.",
	'openidusernameprefix' => 'Utenti OpenID',
	'openidserverlogininstructions' => 'Nzirisci di sècutu la tò password pi fari lu  login a  $3 comu utenti $2 (pàggina utenti  $1).',
	'openidtrustinstructions' => 'Cuntrolla si disìi cunnivìdiri li dati cu $1.',
	'openidallowtrust' => "Pirmetti a $1 di fidàrisi di st'account utenti.",
	'openidnopolicy' => "Lu situ non pricisau na pulìtica supr'a la privacy.",
	'openidpolicy' => 'Cuntrolla la  <a target="_new" href="$1">pulìtica supr\'a la privacy</a> pi chiossai nfurmazzioni.',
	'openidoptional' => 'Facultativu',
	'openidrequired' => 'Addumannatu',
	'openidnickname' => 'Nickname',
	'openidfullname' => 'Nomu cumpretu',
	'openidemail' => 'Nnirizzu e-mail',
	'openidlanguage' => 'Lingua',
	'openidchooseinstructions' => "Tutti l'utenti hannu di bisognu di nu nickname;
ni poi pigghiari unu di chisti ccà di sècutu.",
	'openidchoosefull' => 'Lu tò nomu cumpretu ($1)',
	'openidchooseurl' => 'Nu nomu scigghiutu dû tò OpenID ($1)',
	'openidchooseauto' => 'Nu nomu giniràtusi sulu ($1)',
	'openidchoosemanual' => 'Nu nomu scigghiutu di tia:',
	'openidchooseexisting' => "N'account ca ggià c'è nti sta wiki:",
	'openidchoosepassword' => 'password:',
	'openidconvertinstructions' => 'Stu mòdulu ti duna lu pirmessu di canciari lu tò account pi usari nu URL OpenID.',
	'openidconvertsuccess' => 'Canciatu cu successu a OpenID',
	'openidconvertsuccesstext' => 'Lu tò OpenID canciau cu sucessu a $1.',
	'openidconvertyourstext' => 'Chistu è ggià lu tò  OpenID.',
	'openidconvertothertext' => "Chistu è l'OpenID di n'àutru.",
	'openidalreadyloggedin' => "'''Facisti ggià lu login, $1!'''

Si disìi usari OpenID pi fari lu login ntô futuru, poi [[Special:OpenIDConvert|canciari lu tò account pi utilizzari OpenID]].",
	'openidnousername' => 'Nuddu nomu utenti spicificatu.',
	'openidbadusername' => 'Nomu utenti spicificatu sbagghiatu.',
	'openidautosubmit' => 'Sta pàggina havi nu mòdulu c\'avissi èssiri mannatu autumàticamenti si JavaScript ci l\'hai attivatu. Si, mmeci, nun è accuddì, prova a mùnciri lu buttuni "Continue".',
	'openidclientonlytext' => "Non poi usari li account di sta wiki comu OpenID supra a n'àutru situ.",
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => "{{SITENAME}} susteni lu standard [http://openid.net/ OpenID] pô login ùnicu supr'a li siti web.
OpenID ti pirmetti di riggistràriti nni assai siti web senza utilizzari na password diffirenti pi ognidunu d'iddi.
(Leggi la [http://en.wikipedia.org/wiki/OpenID vuci di Wikipedia supr'a l'OpenID] pi cchiossai nfurmazzioni.)

Si n'account ci l'hai gìa supr'a {{SITENAME}}, poi fari lu [[Special:UserLogin|login]] cu lu tò nomu utentu e la tò password comu ô sòlitu.
Pi utilizzari OpenID ntô futuru, poi [[Special:OpenIDConvert|canciari lu tò account a OpenID]] doppu ca hà fattu lu login comu ô sòlitu.

Ci sunnu assai [http://wiki.openid.net/Public_OpenID_providers Provider OpenID pùbbrichi], e tu putissi aviri già n'account abbilitatu a l'OpenID supra a n'àutru sirvizu.

; Àutri wiki : Si pussedi n'account supra a na wiki abbilitata a l'OpenID, comu [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] o [http://kei.ki/ Keiki], poi fari lu login a {{SITENAME}} nzirennu l<nowiki>'</nowiki>'''URL cumpretu''' dâ tò pàggina utenti nti ss'àutra wiki ntô box misu susu. P'asèmpiu, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Si pussedi n'account cu Yahoo!, poi fari lu login a stu situ nzirennu lu tò OpenID Yahoo! ntô box currispunnenti. Li URL OpenID Yahoo! pussèdunu la furma ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Si pussedi n'account cu [http://www.aol.com/ AOL], comu a n'account [http://www.aim.com/ AIM], poi fari lu login a {{SITENAME}} nzirennu lu tò OpenID AOL ntô box curripunnenti. Li URL OpenID AOL pussèdunu la furma ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Lu tò nomu utenti avissi a èssiri tuttu paru 'n caràttiri nichi, senza spàzii.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Si pussedi nu blog supr'a unu di sti siti, nzirisci l'URL dû blog ntô box currispunnenti. P'asèmpiu, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', o ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
	'openid-pref-hide' => "Ammuccia lu tò OpenID supr'a tò pàggina utenti, si fai lu login cu OpenID.",
	'openid-urls-action' => 'Azzioni',
	'openid-provider-label-google' => 'Accedi utilizzannu lu tò account Google',
	'openid-provider-label-aol' => 'Nserisci lu tò screenname AOL',
	'openid-provider-label-other-username' => 'Nserisci lu tò $1 nnomu utenti',
);

/** Sinhala (සිංහල)
 * @author Asiri wiki
 */
$messages['si'] = array(
	'openidlanguage' => 'භාෂාව',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'openid-desc' => 'Prihlásenie sa na wiki pomocou [http://openid.net/ OpenID] a prihlásenie na iné stránky podporujúce OpenID pomocou používateľského účtu wiki',
	'openidlogin' => 'Prihlásiť sa pomocou OpenID',
	'openidserver' => 'OpenID server',
	'openidxrds' => 'Súbor Yadis',
	'openidconvert' => 'OpenID konvertor',
	'openiderror' => 'Chyba pri overovaní',
	'openiderrortext' => 'Počas overovania OpenID URL sa vyskytla chyba.',
	'openidconfigerror' => 'Chyba konfigurácie OpenID',
	'openidconfigerrortext' => 'Konfigurácia OpenID tejto wiki je neplatná.
Prosím, poraďte sa so [[Special:ListUsers/sysop|správcom]] tejto webovej lokality.',
	'openidpermission' => 'Chyba oprávnení OpenID',
	'openidpermissiontext' => 'OpenID, ktorý ste poskytli, nemá oprávnenie prihlásiť sa k tomuto serveru',
	'openidcancel' => 'Overovanie bolo zrušené',
	'openidcanceltext' => 'Overovanie OpenID URL bolo zrušené.',
	'openidfailure' => 'Overovanie bolo zrušené',
	'openidfailuretext' => 'Overovanie OpenID URL zlyhalo. Chybová správa: „$1“',
	'openidsuccess' => 'Overenie bolo úspešné',
	'openidsuccesstext' => 'Overenie OpenID URL bolo úspešné.',
	'openidusernameprefix' => 'PoužívateľOpenID',
	'openidserverlogininstructions' => 'Dolu zadajte heslo pre prihlásenie na $3 ako používateľ $2 (používateľská stránka $1).',
	'openidtrustinstructions' => 'Skontrolujte, či chcete zdieľať dáta s používateľom $1.',
	'openidallowtrust' => 'Povoliť $1 dôverovať tomuto používateľskému účtu.',
	'openidnopolicy' => 'Lokalita nešpecifikovala politiku ochrany osobných údajov.',
	'openidpolicy' => 'Viac informácií na stránke <a target="_new" href="$1">Ochrana osobných údajov</a>',
	'openidoptional' => 'Voliteľné',
	'openidrequired' => 'Požadované',
	'openidnickname' => 'Prezývka',
	'openidfullname' => 'Plné meno',
	'openidemail' => 'Emailová adresa',
	'openidlanguage' => 'Jazyk',
	'openidtimezone' => 'Časové pásmo',
	'openidchooselegend' => 'Výber používateľského mena',
	'openidchooseinstructions' => 'Každý používateľ musí mať prezývku; môžete si vybrať z dolu uvedených možností.',
	'openidchoosenick' => 'Vaša prezývka ($1)',
	'openidchoosefull' => 'Vaše plné meno ($1)',
	'openidchooseurl' => 'Meno na základe vášho OpenID ($1)',
	'openidchooseauto' => 'Automaticky vytvorené meno ($1)',
	'openidchoosemanual' => 'Meno, ktoré si vyberiete:',
	'openidchooseexisting' => 'Existujúci účet na tejto wiki',
	'openidchooseusername' => 'Používateľské meno:',
	'openidchoosepassword' => 'heslo:',
	'openidconvertinstructions' => 'Tento formulár vám umožňuje zmeniť váš učet, aby používal OpenID URL alebo pridať ďalšie OpenID URL.',
	'openidconvertoraddmoreids' => 'Previesť na OpenID alebo pridať iný OpenID URL',
	'openidconvertsuccess' => 'Úspešne prevedené na OpenID',
	'openidconvertsuccesstext' => 'Úspešne ste previedli váš OpenID na $1.',
	'openidconvertyourstext' => 'To už je váš OpenID.',
	'openidconvertothertext' => 'To je OpenID niekoho iného.',
	'openidalreadyloggedin' => "'''Už ste prihlásený, $1!'''

Ak chcete na prihlasovanie v budúcnosti využívať OpenID, môžete [[Special:OpenIDConvert|previesť váš účet na OpenID]].",
	'openidnousername' => 'Nebolo zadané používateľské meno.',
	'openidbadusername' => 'Bolo zadané chybné používateľské meno.',
	'openidautosubmit' => 'Táto stránka obsahuje formulár, ktorý by mal byť automaticky odoslaný ak máte zapnutý JavaScript.
Ak nie, skúste tlačidlo „Continue“ (Pokračovať).',
	'openidclientonlytext' => 'Nemôžete používať účty z tejto wiki ako OpenID na iných weboch.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => '{{SITENAME}} podporuje štandard [http://openid.net/ OpenID] na zjednotené prihlasovanie na webstránky.
OpenID vám umožňuje prihlasovať sa na množstvo rozličných webstránok bez nutnosti používať pre každú odlišné heslo. (Pozri [http://sk.wikipedia.org/wiki/OpenID Článok o OpenID na Wikipédii])

Ak už máte účet na {{GRAMMAR:lokál|{{SITENAME}}}}, môžete sa [[Special:UserLogin|prihlásiť]] pomocou používateľského mena a hesla ako zvyčajne. Ak chcete v budúcnosti používať OpenID, môžete po normálnom prihlásení [[Special:OpenIDConvert|previesť svoj účet na OpenID]].

Existuje množstvo [http://wiki.openid.net/Public_OpenID_providers Verejných poskytovateľov OpenID] a možno už máte účet s podporou OpenID u iného poskytovateľa.',
	'openidupdateuserinfo' => 'Aktualizovať moje používateľské informácie:',
	'openiddelete' => 'Zmazať OpenID',
	'openiddelete-text' => 'Klinužím na tlačidlo „{{int:openiddelete-button}}“ odstránite OpenID $1 z vášho účtu.
Nebudete sa už pomocou tohto OpenID prihlasovať.',
	'openiddelete-button' => 'Potvrdiť',
	'openiddeleteerrornopassword' => 'Nemôžete zmazať všetky svoje OpenID, pretože účet nemá nastavené heslo.
Bez OpenID by ste sa nemohli prihlásiť.',
	'openiddeleteerroropenidonly' => 'Nemôžete zmazať všetky svoje OpenID, pretože máte oprávnenie prihlasovať sa jedine pomocou OpenID.
Bez OpenID by ste sa nemohli prihlásiť.',
	'openiddelete-sucess' => 'OpenID bolo úspešne odstránené z vášho účtu.',
	'openiddelete-error' => 'Počas odstraňovania OpenIOD z vášho účtu sa vyskytla chyba.',
	'openid-prefstext' => 'Nastavenia [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Nezobrazovať váš OpenID na vašej používateľskej stránke ak sa prihlasujete pomocou OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Aktualizovať nasledovné informácie z OpenID identity vždy, keď sa prihlásim:',
	'openid-urls-desc' => 'OpenID asociované s vašim účtom:',
	'openid-urls-action' => 'Operácia',
	'openid-urls-delete' => 'Zmazať',
	'openid-add-url' => 'Pridať nový OpenID',
	'openidsigninorcreateaccount' => 'Prihlásiť sa alebo vytvoriť nový účet',
	'openid-provider-label-openid' => 'Zadajte URL svojho OpenID',
	'openid-provider-label-google' => 'Prihlásiť sa pomocou účtu Google',
	'openid-provider-label-yahoo' => 'Prihlásiť sa pomocou účtu Yahoo',
	'openid-provider-label-aol' => 'Prihlásiť sa pomocou účtu AOL',
	'openid-provider-label-other-username' => 'Zadajte svoje prihlasovacie meno na $1',
);

/** Lower Silesian (Schläsch)
 * @author Schläsinger
 */
$messages['sli'] = array(
	'openidxrds' => 'Yadis-Datei',
	'openidemail' => 'E-Mail-Atresse:',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'openidserver' => 'OpenID сервер',
	'openidconvert' => 'OpenID конвертор',
	'openiderror' => 'Грешка приликом верификације',
	'openiderrortext' => 'Дошло је до грешке приликом верификације OpenID URL-а.',
	'openidconfigerror' => 'Грешка око конфигурације OpenID-а',
	'openidpermission' => 'Грешка око OpenID права приступа',
	'openidpermissiontext' => 'OpenID-у кога сте навели није дозвољено да се улогује на овај сервер.',
	'openidcancel' => 'Верификација поништена',
	'openidcanceltext' => 'Верификација OpenID URL-а је поништена.',
	'openidfailure' => 'Верификација није прошла',
	'openidfailuretext' => 'Верификација OpenID URL-a није прошла. Порука грешке: "$1"',
	'openidsuccess' => 'Верификација успешна',
	'openidsuccesstext' => 'Верификација OpenID URL-а је била успешна.',
	'openidoptional' => 'Необавезно',
	'openidrequired' => 'Обавезно',
	'openidnickname' => 'Надимак',
	'openidfullname' => 'Пуно име',
	'openidemail' => 'Е-пошта',
	'openidlanguage' => 'Језик',
	'openidchooseinstructions' => 'Сваки корисник треба да има надимак;
Можете да изаберете једну од опција испод.',
	'openidchoosefull' => 'Важе пуно име ($1)',
	'openidchooseurl' => 'Име преузето од вашег OpenID ($1)',
	'openidchooseauto' => 'Аутоматски генерисано корисничко име ($1)',
	'openidchoosemanual' => 'Изаберите корисничко име:',
	'openidchooseexisting' => 'Постојећи налог на овој Вики:',
	'openidchoosepassword' => 'лозинка:',
	'openidconvertsuccess' => 'Конверзија ка OpenID је успешна',
	'openidconvertsuccesstext' => 'Успешно сте прменили свој OpenID на $1.',
	'openidconvertyourstext' => 'Тај OpenID је већ ваш.',
	'openidconvertothertext' => 'То је туђ OpenID.',
	'openidnousername' => 'Није наведено корисничко име.',
	'openidbadusername' => 'Задато неисправно корисничко име.',
	'openidclientonlytext' => 'Ви не можете да користите налоге са овог Викија као OpenID-ове на другим сајтовима.',
	'openidloginlabel' => 'OpenID URL',
	'openidupdateuserinfo' => 'Актуализуј моје личне податке',
	'openid-prefstext' => '[http://openid.net/ OpenID] подешавања',
	'openid-pref-hide' => 'Сакријте свој OpenID URL са корисничке стране, ако се са њим логујете.',
	'openid-pref-update-userinfo-on-login' => 'Актуализуј моје информације са OpenID личност сваки пут кад се улогујем',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Ex13
 * @author Michaello
 * @author Suradnik13
 */
$messages['sr-el'] = array(
	'openidserver' => 'OpenID server',
	'openidconvert' => 'OpenID konvertor',
	'openiderror' => 'Greška prilikom verifikacije',
	'openiderrortext' => 'Došlo je do greške prilikom verifikacije OpenID URL-a.',
	'openidconfigerror' => 'Greška oko konfiguracije OpenID-a',
	'openidpermission' => 'Greška oko OpenID prava pristupa',
	'openidpermissiontext' => 'OpenID-u koga ste naveli nije dozvoljeno da se uloguje na ovaj server.',
	'openidcancel' => 'Verifikacija poništena',
	'openidcanceltext' => 'Verifikacija OpenID URL-a je poništena.',
	'openidfailure' => 'Verifikacija nije prošla',
	'openidfailuretext' => 'Verifikacija OpenID URL-a nije prošla. Poruka greške: "$1"',
	'openidsuccess' => 'Verifikacija uspešna',
	'openidsuccesstext' => 'Verifikacija OpenID URL-a je bila uspešna.',
	'openidoptional' => 'Neobavezno',
	'openidrequired' => 'Obavezno',
	'openidnickname' => 'Nadimak',
	'openidfullname' => 'Puno ime',
	'openidemail' => 'E-pošta',
	'openidlanguage' => 'Jezik',
	'openidchooseinstructions' => 'Svaki korisnik treba da ima nadimak;
Možete da izaberete jednu od opcija ispod.',
	'openidchoosefull' => 'Vaše puno ime ($1)',
	'openidchooseurl' => 'Ime preuzeto od vašeg OpenID ($1)',
	'openidchooseauto' => 'Automatski generisano korisničko ime ($1)',
	'openidchoosemanual' => 'Izaberite korisničko ime:',
	'openidchooseexisting' => 'Postojeći nalog na ovoj Viki:',
	'openidchoosepassword' => 'lozinka:',
	'openidconvertsuccess' => 'Konverzija ka OpenID je uspešna',
	'openidconvertsuccesstext' => 'Uspešno ste prmenili svoj OpenID na $1.',
	'openidconvertyourstext' => 'Taj OpenID je već vaš.',
	'openidconvertothertext' => 'To je tuđ OpenID.',
	'openidnousername' => 'Nije navedeno korisničko ime.',
	'openidbadusername' => 'Zadato neispravno korisničko ime.',
	'openidclientonlytext' => 'Vi ne možete da koristite naloge sa ovog Vikija kao OpenID-ove na drugim sajtovima.',
	'openidloginlabel' => 'OpenID URL',
	'openidupdateuserinfo' => 'Aktualizuj moje lične podatke',
	'openid-prefstext' => '[<a href="http://openid.net/">http://openid.net/</a> OpenID] podešavanja',
	'openid-pref-hide' => 'Sakrijte svoj OpenID URL sa korisničke strane, ako se sa njim logujete.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'openid-desc' => 'Anmeldenge an dit Wiki mäd ne [http://openid.net/ OpenID] un anmäldje an uur Websites, do der OpenID unnerstutsje, mäd een Wiki-Benutserkonto.',
	'openidlogin' => 'Anmäldje mäd OpenID',
	'openidserver' => 'OpenID-Server',
	'openidxrds' => 'Yadis-Doatäi',
	'openidconvert' => 'OpenID-Konverter',
	'openiderror' => 'Wröige-Failer',
	'openiderrortext' => 'Aan Failer is unner ju Wröige fon ju OpenID-URL aptreeden.',
	'openidconfigerror' => 'OpenID-Konfigurationsfailer',
	'openidconfigerrortext' => 'Ju OpenID-Spiekerkonfiguration foar dit Wiki ist failerhaft.
Täl n [[Special:ListUsers/sysop|Administrator]] Bescheed.',
	'openidpermission' => 'OpenID-Begjuchtigengsfailer',
	'openidpermissiontext' => 'Ju anroate OpenID begjuchtiget nit tou Anmäldenge an dissen Server.',
	'openidcancel' => 'Wröige oubreeken',
	'openidcanceltext' => 'Ju Wröige fon ju OpenID-URL wuud oubreeken.',
	'openidfailure' => 'Wröige-Failer',
	'openidfailuretext' => 'Ju Wröige fon ju OpenID-URL is failsloain. Failermäldenge: "$1"',
	'openidsuccess' => 'Wröige mäd Ärfoulch be-eended',
	'openidsuccesstext' => 'Ju Wröige fon ju Open-ID hied Ärfoulch.',
	'openidusernameprefix' => 'OpenID-Benutser',
	'openidserverlogininstructions' => 'Reek dien Paaswoud unner ien, uum die as Benutser $2 an $3 antoumäldjen (Benutsersiede $1).',
	'openidtrustinstructions' => 'Wröich, of du Doaten mäd $1 deele moatest.',
	'openidallowtrust' => 'Ferlööwje $1, dissen Benutserkonto tou tjouen.',
	'openidnopolicy' => 'Ju Siede häd neen Doatenschuts-Gjuchtlienje anroat.',
	'openidpolicy' => 'Wröich ju <a target="_new" href="$1">Doatenschuts-Gjuchtlienje</a> foar moor Informatione.',
	'openidoptional' => 'Optionoal',
	'openidrequired' => 'Plicht',
	'openidnickname' => 'Benutsernoome',
	'openidfullname' => 'Fulboodigen Noome',
	'openidemail' => 'E-Mail-Adresse:',
	'openidlanguage' => 'Sproake',
	'openidtimezone' => 'Tiedzone',
	'openidchooseinstructions' => 'Aal Benutsere benöödigje n Benutsernoome;
du koast aan uut ju unnerstoundene Lieste uutwääle.',
	'openidchoosefull' => 'Din fulboodigen Noome ($1)',
	'openidchooseurl' => 'N Noome uut dien OpenID ($1)',
	'openidchooseauto' => 'N automatisk moakeden Noome ($1)',
	'openidchoosemanual' => 'N Noome fon dien Woal:',
	'openidchooseexisting' => 'N existierend Benutserkonto in dit Wiki:',
	'openidchoosepassword' => 'Paaswoud:',
	'openidconvertinstructions' => 'Mäd dit Formular koast du dien Benutserkonto tou Benutsenge fon n OpenID-URL annerje.',
	'openidconvertoraddmoreids' => 'Uumsätte tou OpenID of föich n uur OpenID-URL tou.',
	'openidconvertsuccess' => 'Mäd Ärfoulch ätter OpenID konvertierd',
	'openidconvertsuccesstext' => 'Du hääst ju Konvertierenge fon dien OpenID ätter $1 mäd Ärfoulch truchfierd.',
	'openidconvertyourstext' => 'Dit is al dien OpenID.',
	'openidconvertothertext' => 'Dit is ju OpenID fon uurswäl.',
	'openidalreadyloggedin' => "'''Du bäst al anmälded, $1!'''

Wan du OpenID foar kuumende Anmäldefoargonge nutsje moatest, koast du [[Special:OpenIDConvert|dien Benutserkonto ätter OpenID konvertierje]].",
	'openidnousername' => 'Naan Benutsernoome anroat.',
	'openidbadusername' => 'Falsken Benutsernoome anroat.',
	'openidautosubmit' => 'Disse Siede änthaalt n Formular, dät automatisk uurdrain wäd, wan JavaSkript aktivierd is.
Fals nit, klik ap „Continue“ (Fääre).',
	'openidclientonlytext' => 'Du koast neen Benutserkonten uut dissen Wiki as OpenID foar uur Sieden ferweende.',
	'openidloginlabel' => 'OpenID-URL',
	'openidlogininstructions' => '{{SITENAME}} unnerstutset dän [http://openid.net/ OpenID]-Standoard foar ne eenhaidelke Anmäldenge foar moorere Websites.
OpenID mäldet die bie fuul unnerscheedelke Websieden an, sunner dät du foar älke Siede n uur Paaswoud ferweende moast.
(Moor Informatione bjut die [http://de.wikipedia.org/wiki/OpenID Wikipedia-Artikkel tou OpenID].)

Fals du al n Benutserkonto bie {{SITENAME}} hääst, koast du die gans normoal mäd Benutsernoome un Paaswoud [[Special:UserLogin|anmäldje]].
Wan du in n Toukumst OpenID ferweende moatest, koast du [[Special:OpenIDConvert|dien Account tou OpenID konvertierje]], ätter dät du die normoal ienlogged hääst.

Dät rakt fuul [http://wiki.openid.net/Public_OpenID_providers eepentelke OpenID-Providere] un muugelkerwiese hääst du al n Benutserkonto mäd aktivierden OpenID bie n uur Anbjooder.',
	'openidupdateuserinfo' => 'Persöönelke Doaten aktualisierje',
	'openiddelete' => 'OpenID läskje',
	'openiddelete-button' => 'Bestäätigje',
	'openiddelete-sucess' => 'Ju OpenID wuud mäd Ärfoulch fon din Benutserkonto wächhoald.',
	'openiddelete-error' => 'Bie dät Wächhoaljen fon ju OpenID fon din Benutserkonto is n Failer aptreeden.',
	'openid-prefstext' => '[http://openid.net/ OpenID] Ienstaalengen',
	'openid-pref-hide' => 'Fersteet dien OpenID ap dien Benutsersiede, wan du die mäd OpenID anmäldest.',
	'openid-pref-update-userinfo-on-login' => 'Ju foulgjende Information fon dät OpenID-Konto bie älke Login aktualisierje',
	'openid-urls-action' => 'Aktion',
	'openid-urls-delete' => 'Läskje',
	'openid-add-url' => 'Näien OpenID bietouföigje',
	'openidsigninorcreateaccount' => 'Anmäldje of n näi Benutserkonto moakje',
	'openid-provider-label-openid' => 'Reek dien OpenID-URL an',
	'openid-provider-label-google' => 'Mäd dien Google-Benutserkonto anmäldje',
	'openid-provider-label-yahoo' => 'Mäd dien Yahoo-Benutserkonto anmäldje',
	'openid-provider-label-aol' => 'Reek dien AOL-Noome an',
	'openid-provider-label-other-username' => 'Reek dien „$1“-Benutsernoome an',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'openidnickname' => 'Landihan',
	'openidlanguage' => 'Basa',
	'openidchoosepassword' => 'sandi:',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Fluff
 * @author Jon Harald Søby
 * @author Lokal Profil
 * @author M.M.S.
 * @author Najami
 * @author Per
 */
$messages['sv'] = array(
	'openid-desc' => 'Logga in på wikin med en [http://openid.net/ OpenID] och logga in på andra sidor som använder OpenID med konton härifrån',
	'openidlogin' => 'Logga in med OpenID',
	'openidserver' => 'OpenID-server',
	'openidxrds' => 'Yadis-fil',
	'openidconvert' => 'OpenID-konvertering',
	'openiderror' => 'Bekräftelsefel',
	'openiderrortext' => 'Ett fel uppstod under bekräftning av OpenID-adressen.',
	'openidconfigerror' => 'Konfigurationsfel med OpenID',
	'openidconfigerrortext' => 'Lagringkonfigurationen för OpenID på den här wikin är ogiltig.
Var god konsultera en [[Special:ListUsers/sysop|administratör]].',
	'openidpermission' => 'Tillåtelsefel med OpenID',
	'openidpermissiontext' => 'Du kan inte logga in på den här servern med den OpenID du angedde.',
	'openidcancel' => 'Bekräftning avbruten',
	'openidcanceltext' => 'Bekräftningen av OpenID-adressen avbrytes.',
	'openidfailure' => 'Bekräftning misslyckades',
	'openidfailuretext' => 'Bekräftning av OpenID-adressen misslyckades. Felmeddelande: "$1"',
	'openidsuccess' => 'Bekräftning lyckades',
	'openidsuccesstext' => 'Bekräftning av OpenID-adressen lyckades.',
	'openidusernameprefix' => 'OpenID-användare',
	'openidserverlogininstructions' => 'Skriv in ditt lösenord nedan för att logga in på $3 som $2 (användarsida $1).',
	'openidtrustinstructions' => 'Kolla om du vill dela data med $1.',
	'openidallowtrust' => 'Tillåter $1 att förlita sig på detta användarkonto.',
	'openidnopolicy' => 'Sajten har inga riktlinjer för personlig integritet.',
	'openidpolicy' => 'Kolla <a href="_new" href="$1">riktlinjer för personlig integritet</a> för mer information.',
	'openidoptional' => 'Valfri',
	'openidrequired' => 'Behövs',
	'openidnickname' => 'Smeknamn',
	'openidfullname' => 'Fullt namn',
	'openidemail' => 'E-postadress',
	'openidlanguage' => 'Språk',
	'openidtimezone' => 'Tidszon',
	'openidchooselegend' => 'Välj användarnamn',
	'openidchooseinstructions' => 'Alla användare måste ha ett användarnamn;
du kan välja ett från alternativen nedan.',
	'openidchoosenick' => 'Ditt smeknamn ($1)',
	'openidchoosefull' => 'Fullt namn ($1)',
	'openidchooseurl' => 'Ett namn taget från din OpenID ($1)',
	'openidchooseauto' => 'Ett automatiskt genererat namn ($1)',
	'openidchoosemanual' => 'Ett valfritt namn:',
	'openidchooseexisting' => 'Ett existerande konto på denna wiki',
	'openidchooseusername' => 'Användarnamn:',
	'openidchoosepassword' => 'lösenord:',
	'openidconvertinstructions' => 'Detta formulär låter dig ändra dina användarkonton till att använda eller lägga till en eller flera OpenID-adresser',
	'openidconvertoraddmoreids' => 'Konvertera till OpenID eller lägg till en ny OpenID-adress',
	'openidconvertsuccess' => 'Konverterade till OpenID',
	'openidconvertsuccesstext' => 'Du har konverterat din OpenID till $1.',
	'openidconvertyourstext' => 'Det är redan din OpenID.',
	'openidconvertothertext' => 'Den OpenID tillhör någon annan.',
	'openidalreadyloggedin' => "'''Du är redan inloggad, $1!'''

Om du vill använda OpenID att logga in i framtiden, kan du [[Special:OpenIDConvert|konvertera dina konton till att använda OpenID]].",
	'openidnousername' => 'Inget användarnamn angivet.',
	'openidbadusername' => 'Ogiltigt användarnamn angivet.',
	'openidautosubmit' => 'Denna sida innehåller ett formulär som kommer levereras automatiskt om du har slagit på JavaScript.
Om inte, tryck på "Continue" (Fortsätt).',
	'openidclientonlytext' => 'Du kan inte använda konton från denna wikin som OpenID på en annan sida.',
	'openidloginlabel' => 'OpenID-adress',
	'openidlogininstructions' => '{{SITENAME}} stödjer [http://openid.net/ OpenID]-standarden för enhetlig inlogging på många webbsidor.
OpenID låter dig logga in på många webbsidor utan att använda olika lösenord för varje. 
(Se [http://en.wikipedia.org/wiki/OpenID Wikipedia-artikeln om OpenID] för mer information.)

Om du redan har ett konto på {{SITENAME}}, kan du [[Special:UserLogin|logga in]] som vanligt med ditt användarnamn och lösenord.
För att använda OpenID i framtiden kan du [[Special:OpenIDConvert|konvertera ditt konton till OpenID]] efter att du har loggat in på normalt sätt.

Det finns många [http://openid.net/get/ leverantörer av OpenID], och du kan redan ha ett OpenID-aktiverat konto på en annan plats.',
	'openidupdateuserinfo' => 'Uppdatera min personliga information:',
	'openiddelete' => 'Ta bort OpenID',
	'openiddelete-text' => 'Genom att klicka på knappen "{{int:openiddelete-button}}" kommer du att ta bort OpenID $1 från ditt konto. Du kommer inte att kunna använda detta OpenID för att logga in.',
	'openiddelete-button' => 'Bekräfta',
	'openiddeleteerrornopassword' => 'Du kan inte radera alla dina OpenId eftersom ditt konto saknar lösenord.
Du skulle inte kunna logga in utan ett OpenID.',
	'openiddeleteerroropenidonly' => 'Du kan inte radera alla dina OpenID eftersom du endast får logga in med OpenID.
Du skulle inte kunna logga in utan ett OpenID.',
	'openiddelete-sucess' => 'OpenID-kopplingen har tagits bort från ditt konto.',
	'openiddelete-error' => 'Ett fel uppstod när OpenID-kopplingen skulle tas bort från ditt konto.',
	'openid-prefstext' => '[http://openid.net/ OpenID] inställningar',
	'openid-pref-hide' => 'Dölj OpenID på din användarsida, om du loggar in med OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Uppdatera följande information från min OpenID-profil varje gång jag loggar in',
	'openid-urls-desc' => 'OpenID som är kopplade till ditt konto:',
	'openid-urls-action' => 'Åtgärd',
	'openid-urls-delete' => 'Ta bort',
	'openid-add-url' => 'Lägg till ett nytt OpenID',
	'openidsigninorcreateaccount' => 'Logga in eller skapa ett nytt konto',
	'openid-provider-label-openid' => 'Skriv in din OpenID-URL',
	'openid-provider-label-google' => 'Logga in genom att använda ditt Google-konto',
	'openid-provider-label-yahoo' => 'Logga in genom att använda ditt Yahoo-konto',
	'openid-provider-label-aol' => 'Skriv in ditt AOL-skärmnamn',
	'openid-provider-label-other-username' => 'Skriv in ditt $1-användarnamn',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Ravichandra
 * @author Veeven
 */
$messages['te'] = array(
	'openid-desc' => '[http://openid.net/ ఓపెన్ఐడీ]తో వికీ లోనికి ప్రవేశించండి, మరియు వికీ వాడుకరి ఖాతాతో ఓపెన్ఐడీని అంగీకరించే ఇతర వెబ్ సైట్లలోనికి ప్రవేశించండి',
	'openidlogin' => 'ఓపెన్ఐడీతో ప్రవేశించండి',
	'openidserver' => 'ఓపెన్ఐడీ సేవకి',
	'openiderror' => 'తనిఖీ పొరపాటు',
	'openiderrortext' => 'ఓపెన్ఐడీ చిరునామాని తనిఖీ చేయడంలో పొరపాటు జరిగింది.',
	'openidpermission' => 'ఓపెన్ఐడీ అనుమతుల పొరపాటు',
	'openidpermissiontext' => 'మీరు ఇచ్చిన ఓపెన్ఐడీకి ఈ సేవకి లోనికి ప్రవేశించే అనుమతి లేదు.',
	'openidcancel' => 'తనిఖీ రద్దయింది',
	'openidcanceltext' => 'ఓపెన్ఐడీ చిరునామా యొక్క తనిఖీని రద్దుచేసారు.',
	'openidfailure' => 'తనిఖీ విఫలమైంది',
	'openidfailuretext' => 'ఓపెన్ఐడీ చిరునామా యొక్క తనిఖీ విఫలమైంది. పొరపాటు సందేశం: "$1"',
	'openidsuccess' => 'తనిఖీ విజయవంతమైంది',
	'openidserverlogininstructions' => '$3 లోనికి $2 (వాడుకరి పేజీ $1) అనే వాడుకరిగా ప్రవేశించడానికి మీ సంకేతపదం ఇవ్వండి.',
	'openidallowtrust' => 'ఈ వాడుకరి ఖాతాని విశ్వసించడానికి $1ని అనుమతించు.',
	'openidnopolicy' => 'సైటు అంతరంగికత విధానాన్ని పేర్కొనలేదు.',
	'openidpolicy' => 'మరింత సమాచారం కొరకు <a target="_new" href="$1">అంతరంగికత విధానా</a>న్ని చూడండి.',
	'openidoptional' => 'ఐచ్చికం',
	'openidrequired' => 'తప్పనిసరి',
	'openidnickname' => 'ముద్దుపేరు',
	'openidfullname' => 'పూర్తిపేరు',
	'openidemail' => 'ఈ-మెయిల్ చిరునామా',
	'openidlanguage' => 'భాష',
	'openidtimezone' => 'కాలమానం',
	'openidchooseinstructions' => 'సభ్యులందరికీ ముద్దు పేరు ఉండవలెను. 
క్రింద పేర్కొన్న వాటిలో ఒకటి ఎంచుకోండి',
	'openidchoosefull' => 'మీ పూర్తి పేరు ($1)',
	'openidchooseurl' => 'మీ ఓపెన్ఐడీ నుండి తీసుకున్న పేరు ($1)',
	'openidchoosemanual' => 'మీరు ఎన్నుకున్న పేరు:',
	'openidchooseexisting' => 'ఈ వికీలో ఇప్పటికే ఉన్న ఖాతా',
	'openidchooseusername' => 'వాడుకరిపేరు:',
	'openidchoosepassword' => 'సంకేతపదం:',
	'openidconvertinstructions' => 'మీ ఖాతాని ఓపెన్ఐడీ చిరునామా ఉపయోగించేలా మార్చడానికి లేదా మరిన్ని ఓపెన్ఐడీ చిరునామాలు చేర్చుకోడానికి ఈ ఫారం వీలుకల్పిస్తుంది',
	'openidconvertsuccess' => 'విజయవంతంగా ఓపెనిఐడీకి మారారు',
	'openidconvertsuccesstext' => 'మీ ఓపెన్ఐడీని $1కి విజయవంతంగా మార్చుకున్నారు.',
	'openidconvertyourstext' => 'అది ఇప్పటికే మీ ఓపెన్ఐడీ.',
	'openidconvertothertext' => 'ఇది వేరొకరి ఓపెన్ ఐడి',
	'openidnousername' => 'వాడుకరిపేరు ఇవ్వలేదు.',
	'openidbadusername' => 'తప్పుడు వాడుకరిపేరుని ఇచ్చారు.',
	'openidclientonlytext' => 'ఈ వికీ లోని ఖాతాలను మీరు వేరే సైట్లలో ఓపెన్ఐడీలుగా ఉపయోగించలేరు.',
	'openidloginlabel' => 'ఓపెన్ఐడీ చిరునామా',
	'openidupdateuserinfo' => 'నా వ్యక్తిగత సమాచారాన్ని తాజాకరించు:',
	'openiddelete' => 'ఓపెన్ ఐడి తొలగించు',
	'openiddelete-button' => 'నిర్ధారించు',
	'openiddelete-sucess' => 'మీ ఖాతా నుండి ఆ ఓపెన్ఐడీని విజయవంతంగా తొలగించాం.',
	'openiddelete-error' => 'మీ ఖాతా నుండి ఓపెన్ఐడీని తొలగించడంలో పొరపాటు జరిగింది.',
	'openid-prefstext' => '[http://openid.net/ ఓపెన్ఐడీ] అభిరుచులు',
	'openid-pref-hide' => 'నేను ఓపెన్ఐడీతో ప్రవేశిస్తే, నా ఓపెన్ఐడీ చిరునామాని నా వాడుకరి పేజీలో కనబడకుండా దాచు.',
	'openid-urls-desc' => 'మీ ఖాతాతో సంధానమై ఉన్న ఓపెన్ఐడీలు:',
	'openid-urls-action' => 'చర్య',
	'openid-urls-delete' => 'తొలగించు',
	'openid-add-url' => 'కొత్త ఓపెన్ఐడీని చేర్చు',
	'openidsigninorcreateaccount' => 'ప్రవేశించండి లేదా కొత్త ఖాతాని సృష్టించుకోండి',
	'openid-provider-label-openid' => 'మీ ఓపెన్ఐడీ చిరునామాని ఇవ్వండి',
	'openid-provider-label-google' => 'మీ గూగుల్ ఖాతాని ఉపయోగించి ప్రవేశించండి',
	'openid-provider-label-yahoo' => 'మీ యాహూ ఖాతాని ఉపయోగించి ప్రవేశించండి',
	'openid-provider-label-aol' => 'మీ ఎఓఎల్ స్క్రీన్ నామము ఇవ్వండి',
	'openid-provider-label-other-username' => 'మీ $1 వాడుకరిపేరుని ఇవ్వండి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'openidnickname' => "Naran uza-na'in",
	'openidfullname' => 'Naran kompletu',
	'openidemail' => 'Diresaun korreiu eletróniku',
	'openidlanguage' => 'Lian',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'openid-desc' => 'Ба вики бо [http://openid.net/ OpenID] вуруд кунед, ва ба дигар сомонаҳои OpenID бо ҳисоби корбарии вики вуруд кунед',
	'openidlogin' => 'Бо OpenID вуруд кунед',
	'openidserver' => 'Хидматгузори OpenID',
	'openidxrds' => 'Парвандаи Yadis',
	'openidconvert' => 'Табдилкунандаи OpenID',
	'openiderror' => 'Хатои тасдиқ',
	'openiderrortext' => 'Дар ҳолати тасдиқи нишонаи OpenID хатое рух дод.',
	'openidconfigerror' => 'Хатои Танзимоти OpenID',
	'openidconfigerrortext' => 'Танзимоти захирасозии OpenID барои ин вики номӯътабар аст.
Лутфан бо мудири сомона тамос бигиред.',
	'openidoptional' => 'Ихтиёрӣ',
	'openidemail' => 'Нишонаи почтаи электронӣ',
	'openidlanguage' => 'Забон',
	'openidchoosepassword' => 'гузарвожа:',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'openid-desc' => 'Ba viki bo [http://openid.net/ OpenID] vurud kuned, va ba digar somonahoi OpenID bo hisobi korbariji viki vurud kuned',
	'openidlogin' => 'Bo OpenID vurud kuned',
	'openidserver' => 'Xidmatguzori OpenID',
	'openidxrds' => 'Parvandai Yadis',
	'openidconvert' => 'Tabdilkunandai OpenID',
	'openiderror' => 'Xatoi tasdiq',
	'openiderrortext' => 'Dar holati tasdiqi nişonai OpenID xatoe rux dod.',
	'openidconfigerror' => 'Xatoi Tanzimoti OpenID',
	'openidoptional' => 'Ixtijorī',
	'openidemail' => 'Nişonai poctai elektronī',
	'openidlanguage' => 'Zabon',
	'openidchoosepassword' => 'guzarvoƶa:',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'openidemail' => 'อีเมล',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'openidlanguage' => 'Dil',
	'openid-urls-delete' => 'Öçür',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'openid-desc' => 'Lumagda sa wiki na may [http://openid.net/ OpenID], at lumagda sa iba pang mga websayt na nakakaalam sa/nakababatid ng OpenID na may kuwenta/akawnt na pang-wiki',
	'openidlogin' => 'Lumagda na may OpenID',
	'openidserver' => 'Serbidor ng OpenID',
	'openidxrds' => 'Talaksang Yadis',
	'openidconvert' => 'Tagapagpalit ng OpenID',
	'openiderror' => 'Kamalian sa pagpapatunay',
	'openiderrortext' => 'Naganap ang isang kamalian habang pinatototohanan ang URL ng OpenID.',
	'openidconfigerror' => 'Kamalian sa pagkakaayos ng OpenID',
	'openidconfigerrortext' => 'Hindi tanggap ang kaayusang pangtaguan ng OpenID para sa wiking ito.
Makipagugnayan po lamang sa isang [[Special:ListUsers/sysop|tagapangasiwa]].',
	'openidpermission' => 'May kamalian sa mga kapahintulutang pang-OpenID',
	'openidpermissiontext' => 'Hindi pinapahintulutang makalagda sa serbidor na ito ang ibinigay mong OpenID.',
	'openidcancel' => 'Hindi itinuloy ang pagpapatotoo',
	'openidcanceltext' => 'Hindi itinuloy ang pagpapatotoo sa URL ng OpenID.',
	'openidfailure' => 'Nabigo ang pagpapatotoo',
	'openidfailuretext' => 'Nabigo ang pagpapatoo sa URL ng OpenID.  Mensaheng pangkamalian: "$1"',
	'openidsuccess' => 'Nagtagumpay ang pagpapatotoo',
	'openidsuccesstext' => 'Nagtagumpay ang pagpapatotoo sa URL ng OpenID.',
	'openidusernameprefix' => 'Tagagamit ng OpenID',
	'openidserverlogininstructions' => 'Ipasok (ilagay) ang iyong hudyat sa ibaba upang makalagda patungo sa $3 bilang si tagagamit na  $2 (pahina ng tagagamit na $1).',
	'openidtrustinstructions' => 'Pakisuri kung nais mong isalo ang dato kay $1.',
	'openidallowtrust' => 'Pahintulutan si $1 na pagkatiwalaan ang kuwenta ng tagagamit na ito.',
	'openidnopolicy' => 'Hindi tumukoy ang sityo (sayt) ng isang patakaran sa paglilihim na pansarili.',
	'openidpolicy' => 'Suriin ang <a target="_new" href="$1">patakaran sa paglilihim na pansarili</a> para sa mas marami pang kabatiran.',
	'openidoptional' => 'Opsyonal (hindi talaga kailangan/maaaring wala nito)',
	'openidrequired' => 'Kinakailangan',
	'openidnickname' => 'Bansag',
	'openidfullname' => 'Buong pangalan',
	'openidemail' => 'Adres ng e-liham',
	'openidlanguage' => 'Wika',
	'openidchooseinstructions' => 'Lahat ng mga tagagamit ay kinakailangang may bansag;
makakapili ka mula sa mga pagpipiliang nasa ibaba.',
	'openidchoosefull' => 'Ang buong pangalan mo ($1)',
	'openidchooseurl' => 'Isang pangalang napulot (napili/nakuha) mula sa iyong OpenID ($1)',
	'openidchooseauto' => 'Isang pangalang kusang nalikha ($1)',
	'openidchoosemanual' => 'Isang pangalang ikaw ang pumili:',
	'openidchooseexisting' => 'Isang umiiral na kuwenta sa wiking ito:',
	'openidchoosepassword' => 'hudyat:',
	'openidconvertinstructions' => 'Nagpapahintulot ang pormularyong ito upang mabago mo ang iyong kuwenta ng tagagamit para magamit ang isang URL ng OpenID.',
	'openidconvertsuccess' => 'Matagumpay na napalitan (nabago) upang maging OpenID',
	'openidconvertsuccesstext' => 'Matagumpay mong napalitan/nabago ang iyong OpenID para maging $1.',
	'openidconvertyourstext' => 'Iyan na mismo ang iyong OpenID.',
	'openidconvertothertext' => 'Iyan ay isa nang OpenID ng ibang tao.',
	'openidalreadyloggedin' => "'''Nakalagda ka na, $1!'''

Kung nais mong gumamit ng OpenID upang makalagda sa hinaharap, maaari mong [[Special:OpenIDConvert|palitan ang kuwenta mo para magamit ang OpenID]].",
	'openidnousername' => 'Walang tinukoy na pangalan ng tagagamit.',
	'openidbadusername' => 'Masama ang tinukoy na pangalan ng tagagamit.',
	'openidautosubmit' => 'Kabilang/kasama sa pahinang ito ang isang pormularyo na dapat na kusang maipasa/maipadala kapag hindi pinaandar (pinagana) ang JavaScript.
Kung hindi, subukin ang pindutang "Continue" (Magpatuloy).',
	'openidclientonlytext' => 'Hindi mo magagamit ang mga kuwenta mula sa wiking ito bilang mga OpenID sa iba pang sityo/sayt.',
	'openidloginlabel' => 'URL ng OpenID',
	'openidlogininstructions' => "Tinatangkilik ng {{SITENAME}} ang pamantayang [http://openid.net/ OpenID] para sa mga isahang paglagda sa pagitan ng mga sayt ng Web.
Hinahayaan ka ng OpenID na makalagda sa maraming iba't ibang mga sityo ng Web na hindi gumagamit ng isang iba pang hudyat para sa bawat isa.
(Tingnan ang [http://en.wikipedia.org/wiki/OpenID lathalaing OpenID ng Wikipedia] para sa mas marami pang kabatiran.)

Kung mayroon ka nang kuwenta sa {{SITENAME}}, maaari kang [[Special:UserLogin|lumagdang papasok]] sa pamamagitan ng iyong pangalan ng tagagamit at hudyat sa karaniwang paraan.
Upang makagamit ng OpenID sa hinaharap, maaari mong [[Special:OpenIDConvert|palitan ang iyong akawnt upang maging OpenID]] pagkatapos mong lumagda sa karaniwang paraan.

Maraming mga [http://wiki.openid.net/Public_OpenID_providers tagapagbigay ng OpenID], at maaaring mayroon ka nang isang kuwentang pinagana ng OpenID na nasa iba pang palingkuran.",
	'openidupdateuserinfo' => 'Isapanahon ang aking pansariling kabatiran',
	'openid-prefstext' => 'Mga kagustuhang pang-[http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Itago ang OpenID mo sa ibabaw ng iyong pahina ng tagagamit, kapag lumagda ka sa pamamagitan ng OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Isapahaon ang aking kabatiran mula sa katauhang pang-OpenID sa bawat pagkakataong lalagda akong papasok',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'openid-desc' => 'Vikiye bir [http://openid.net/ OpenID] ile giriş yapın, ve diğer OpenID kullanan web sitelerine bir viki kullanıcı hesabıyla giriş yapın.',
	'openidlogin' => 'OpenID ile giriş yapın',
	'openidserver' => 'OpenID sunucusu',
	'openidxrds' => 'Yadis dosyası',
	'openidconvert' => 'OpenID çeviricisi',
	'openiderror' => 'Doğrulama hatası',
	'openiderrortext' => 'OpenID adresi doğrulanırken bir hata oluştu.',
	'openidconfigerror' => 'OpenID yapılandırma hatası',
	'openidconfigerrortext' => 'Bu viki için OpenID depolama yapılandırması geçersiz.
Lütfen bir [[Special:ListUsers/sysop|yöneticiye]] danışın.',
	'openidpermission' => 'OpenID izinleri hatası',
	'openidpermissiontext' => "Sağladığınız OpenID'nin bu sunucuya oturum açmasına izin verilmiyor.",
	'openidcancel' => 'Doğrulama iptal edildi',
	'openidcanceltext' => 'OpenID URL doğrulaması iptal edildi.',
	'openidfailure' => 'Doğrulama başarısız',
	'openidfailuretext' => 'OpenID URL doğrulaması başarısız oldu. Hata iletisi: "$1"',
	'openidsuccess' => 'Doğrulama başarılı',
	'openidsuccesstext' => 'OpenID URL doğrulaması başarılı.',
	'openidusernameprefix' => 'OpenIDKullanıcısı',
	'openidserverlogininstructions' => '$3 sitesine $2 kullanıcısı (kullanıcı sayfası $1) olarak oturum açmak için parolanızı aşağıya girin.',
	'openidtrustinstructions' => '$1 ile veri paylaşmak istediğinizi kontrol edin.',
	'openidallowtrust' => "Bu kullanıcı hesabına güvenmek için $1'e izin ver.",
	'openidnopolicy' => 'Site bir gizlilik ilkesi belirtmemiş.',
	'openidpolicy' => 'Daha fazla bilgi için <a target="_new" href="$1">gizlilik ilkesine</a> bakın.',
	'openidoptional' => 'İsteğe Bağlı',
	'openidrequired' => 'Gerekli',
	'openidnickname' => 'Kullanıcı adı',
	'openidfullname' => 'Tam ad',
	'openidemail' => 'E-posta adresi',
	'openidlanguage' => 'Dil',
	'openidtimezone' => 'Saat dilimi',
	'openidchooselegend' => 'Kullanıcı adı tercihi',
	'openidchooseinstructions' => 'Tüm kullanıcılar için bir kullanıcı adı gereklidir;
aşağıdaki seçeneklerden birini seçebilirsiniz.',
	'openidchoosenick' => 'Rumuzunuz ($1)',
	'openidchoosefull' => 'Tam adınız ($1)',
	'openidchooseurl' => "OpenID'nizden bir isim alındı ($1)",
	'openidchooseauto' => 'Otomatik oluşturulan bir isim ($1)',
	'openidchoosemanual' => 'Tercihinizden bir isim:',
	'openidchooseexisting' => 'Bu vikide mevcut bir hesap',
	'openidchooseusername' => 'Kullanıcı adı:',
	'openidchoosepassword' => 'parola:',
	'openidconvertinstructions' => 'Bu form bir OpenID URLsi kullanmak ya da daha fazla OpenID URLsi eklemek için kullanıcı hesabınızı değiştirmenizi sağlar.',
	'openidconvertoraddmoreids' => "OpenID'ye dönüştürün ya da başka bir OpenID URLsi ekleyin",
	'openidconvertsuccess' => 'OpenIDye başarıyla dönüştürüldü',
	'openidconvertsuccesstext' => "OpenIDnizi başarıyla $1'e dönüştürdünüz.",
	'openidconvertyourstext' => 'Bu zaten sizin OpenIDniz.',
	'openidconvertothertext' => 'Bu bir başkasının OpenIDsi.',
	'openidalreadyloggedin' => "'''Zaten oturum açtınız, $1!'''

Eğer gelecekte de oturum açmak için OpenID kullanmak isterseniz, [[Special:OpenIDConvert|hesabınızı OpenID kullanmak için dönüştürebilirsiniz]].",
	'openidnousername' => 'Herhangi bir kullanıcı adı belirtilmedi.',
	'openidbadusername' => 'Kötü bir kullanıcı adı belirtildi.',
	'openidautosubmit' => 'Bu sayfa, JavaScript etkin ise otomatik olarak gönderilmesi gereken bir form içeriyor.
Eğer değilse, "Continue" (Devam) düğmesini deneyin.',
	'openidclientonlytext' => 'Bu vikideki hesapları başka sitelerde OpenID olarak kullanamazsınız.',
	'openidloginlabel' => 'OpenID URLsi',
	'openidlogininstructions' => "{{SITENAME}}, web sitelerinde tekli giriş için [http://openid.net/ OpenID] standartını desteklemektedir.
OpenID, herbirine farklı şifre kullanmadan birçok web sitesine giriş yapmanıza izin verir.
(Daha fazla bilgi için [http://en.wikipedia.org/wiki/OpenID Vikipedideki OpenID maddesine bakın].)

Eğer {{SITENAME}} sitesinde mevcut bir hesabınız varsa, her zamanki gibi kullanıcı adınız ve şifrenizle [[Special:UserLogin|giriş yapabilirsiniz]].
İleride OpenID kullanmak için, normal giriş yaptıktan sonra [[Special:OpenIDConvert|hesabınızı OpenID'ye çevirebilirsiniz]].

Birçok [http://openid.net/get/ OpenID sağlayıcısı] vardır, ve bir başka serviste halihazırda bir OpenID-etkin hesabınız olabilir.",
	'openidupdateuserinfo' => 'Kişisel bilgimlerimi güncelle:',
	'openiddelete' => "OpenID'yi sil",
	'openiddelete-text' => '"{{int:openiddelete-button}}" düğmesine tıklayarak, $1 OpenID\'sini hesabınızdan çıkaracaksınız.
Bu OpenID ile artık giriş yapamayacaksınız.',
	'openiddelete-button' => 'Onayla',
	'openiddeleteerrornopassword' => "Tüm OpenID'lerinizi silemezsiniz çünkü hesabınızın şifresi yok.
OpenID olmadan giriş yapamazsınız.",
	'openiddeleteerroropenidonly' => "Tüm OpenID'lerinizi silemezsiniz çünkü sadece OpenID ile giriş yapmaya izniniz var.
OpenID olmadan giriş yapamazsınız.",
	'openiddelete-sucess' => 'OpenID hesabınızdan başarıyla kaldırıldı.',
	'openiddelete-error' => 'OpenID hesabınızdan çıkarılırken bir hata oluştu.',
	'openid-prefstext' => '[http://openid.net/ OpenID] tercihleri',
	'openid-pref-hide' => 'Eğer OpenID ile giriş yaparsanız, kullanıcı sayfanızda OpenID URLnizi gizle.',
	'openid-pref-update-userinfo-on-login' => 'Her oturum açışımda OpenID karakterinden aşağıdaki bilgileri güncelle:',
	'openid-urls-desc' => "Hesabınızla ilişkili OpenID'ler:",
	'openid-urls-action' => 'Eylem',
	'openid-urls-delete' => 'Sil',
	'openid-add-url' => 'Yeni bir OpenID ekle',
	'openidsigninorcreateaccount' => 'Oturum açın ya da Yeni Hesap Oluşturun',
	'openid-provider-label-openid' => 'OpenID URLnizi girin',
	'openid-provider-label-google' => 'Google hesabınızı kullanarak giriş yapın',
	'openid-provider-label-yahoo' => 'Yahoo hesabınızı kullanarak giriş yapın',
	'openid-provider-label-aol' => 'AOL ekran-adınızı girin',
	'openid-provider-label-other-username' => '$1 kullanıcı adınızı girin',
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'openidlanguage' => 'تىل',
);

/** Uighur (Latin) (Uyghurche‎ / ئۇيغۇرچە (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'openidlanguage' => 'Til',
);

/** Ukrainian (Українська)
 * @author A1
 * @author AS
 * @author Aleksandrit
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'openid-desc' => 'Вхід у вікі за допомогою [http://openid.net/ OpenID], а також вхід на інші сайти, що підтримують OpenID за допомогою акаунта в вікі',
	'openidlogin' => 'Вхід з допомогою OpenID',
	'openidserver' => 'Сервер OpenID',
	'openidxrds' => 'Файл Yadis',
	'openidconvert' => 'Перетворювач OpenID',
	'openiderror' => 'Помилка перевірки повноважень',
	'openiderrortext' => 'Під час перевірки адреси OpenID сталася помилка.',
	'openidconfigerror' => 'Помилка налаштування OpenID',
	'openidconfigerrortext' => 'Налаштування сховища OpenID для цієї вікі помилкова.
Будь-ласка, зверніться до [[Special:ListUsers/sysop|адміністратору сайту]].',
	'openidpermission' => 'Помилка прав доступу OpenID',
	'openidpermissiontext' => 'Вказаний OpenID не дозволяє увійти на цей сервер.',
	'openidcancel' => 'Перевірку скасовано',
	'openidcanceltext' => 'Перевірка адреси OpenID була скасована.',
	'openidfailure' => 'Перевірка невдала',
	'openidfailuretext' => 'Перевірка адреси OpenID завершилася невдачею. Повідомлення про помилку: «$1»',
	'openidsuccess' => 'Перевірка пройшла успішно',
	'openidsuccesstext' => 'Перевірка адреси OpenID пройшла успішно.',
	'openidusernameprefix' => 'Користувач OpenID',
	'openidserverlogininstructions' => 'Введіть нижче ваш пароль, щоб увійти на $3 як користувач $2 (особиста сторінка $1).',
	'openidtrustinstructions' => 'Відзначте, якщо ви хочете надати доступ до даних для $1.',
	'openidallowtrust' => 'Дозволити $1 довіряти цьому акаунту.',
	'openidnopolicy' => 'Сайт не вказав політику конфіденційності.',
	'openidpolicy' => 'Додаткову інформацію можна дізнатися в <a target="_new" href="$1">політиці конфіденційності</a>.',
	'openidoptional' => "необов'язкове",
	'openidrequired' => "обов'язкове",
	'openidnickname' => 'Псевдонім',
	'openidfullname' => "Повне ім'я",
	'openidemail' => 'Адреса ел. пошти',
	'openidlanguage' => 'Мова',
	'openidtimezone' => 'Часовий пояс',
	'openidchooselegend' => 'Вибір імені користувача',
	'openidchooseinstructions' => 'Кожен користувач повинен мати псевдонім;
ви можете вибрати один з представлених нижче.',
	'openidchoosenick' => 'Ваш нік ($1)',
	'openidchoosefull' => "Ваше повне ім'я ($1)",
	'openidchooseurl' => 'Ім`я, отримане з вашого OpenID ($1)',
	'openidchooseauto' => "Автоматично створене ім'я ($1)",
	'openidchoosemanual' => "Ім'я на ваш вибір:",
	'openidchooseexisting' => 'Існуючий обліковий запис на цій вікі',
	'openidchooseusername' => "Ім'я користувача:",
	'openidchoosepassword' => 'пароль:',
	'openidconvertinstructions' => 'Ця форма дозволяє вам змінити використання Вашого облікового запису на використання адреси OpenID або додати кілька адрес OpenID.',
	'openidconvertoraddmoreids' => 'Перетворити на OpenID або додати іншу адресу OpenID',
	'openidconvertsuccess' => 'Успішне перетворення в OpenID',
	'openidconvertsuccesstext' => 'Ви успішно перетворили ваш OpenID в $1.',
	'openidconvertyourstext' => 'Це вже ваш OpenID.',
	'openidconvertothertext' => 'Це чужий OpenID.',
	'openidalreadyloggedin' => "'''Ви вже ввійшли, $1!'''

Якщо ви бажаєте використовувати в майбутньому вхід через OpenID, ви можете [[Special:OpenIDConvert|перетворити ваш акаунт для використання в OpenID]].",
	'openidnousername' => "Не вказано ім'я користувача.",
	'openidbadusername' => "Зазначено невірне ім'я користувача.",
	'openidautosubmit' => 'Ця сторінка містить форму, яка повинна бути автоматично відправлена, якщо у вас включений JavaScript.
Якщо цього не сталося, спробуйте натиснути на кнопку «Continue» (Продовжити).',
	'openidclientonlytext' => 'Ви не можете використовувати акаунти з цієї вікі, як OpenID на іншому сайті.',
	'openidloginlabel' => 'Адреса OpenID',
	'openidlogininstructions' => "{{SITENAME}} підтримує стандарт [http://openid.net/ OpenID], що дозволяє використовувати один обліковий запис для входу на різні веб-сайти.
OpenID дозволяє вам заходити на різні веб-сайти без указання різних паролів для них
(детальніше див. [http://uk.wikipedia.org/wiki/OpenID статтю про OpenID в Вікіпедії]).

Якщо ви вже маєте обліковий запис на {{SITENAME}}, Ви можете [[Special:UserLogin|війти]] як звичайно, використовуючи Ваші ім'я користувача і пароль.
Щоб використовувати надалі OpenID, Ви можете [[Special:OpenIDConvert|перетворити Ваш обліковий запис на OpenID]], після того, як ви ввійшли звичайним образом.

Існує безліч [http://wiki.openid.net/Public_OpenID_providers загальнодоступних провайдерів OpenID], можливо, Ви вже маєте обліковий запис OpenID на іншому сайті.",
	'openidupdateuserinfo' => 'Оновити мою особисту інформацію:',
	'openiddelete' => 'Видалити OpenID',
	'openiddelete-text' => 'Натиснувши на кнопку «{{int:openiddelete-button}}», Ви видалите OpenID $1 зі свого облікового запису. Ви більше не зможете входити із цим OpenID.',
	'openiddelete-button' => 'Підтвердити',
	'openiddelete-sucess' => 'OpenID успішно вилучений з Вашого облікового запису.',
	'openiddelete-error' => 'Відбулася помилка при видаленні OpenID з Вашого облікового запису.',
	'openid-prefstext' => 'Параметри [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Приховувати ваш OpenID на вашій сторінці користувача, якщо ви ввійшли з допомогою OpenID.',
	'openid-pref-update-userinfo-on-login' => 'Оновлювати наступну інформацію про мене через OpenID щораз, коли я представляюся системі:',
	'openid-urls-desc' => "OpenID, пов'язані з Вашим обліковим записом:",
	'openid-urls-action' => 'Дія',
	'openid-urls-delete' => 'Видалити',
	'openid-add-url' => 'Додати новий OpenID',
	'openidsigninorcreateaccount' => 'Представитися системі або створити новий обліковий запис',
	'openid-provider-label-openid' => 'Введіть URL Вашого OpenID',
	'openid-provider-label-google' => 'Представитися, використовуючи обліковий запис Google',
	'openid-provider-label-yahoo' => 'Представитися, використовуючи обліковий запис Yahoo',
	'openid-provider-label-aol' => "Введіть ваше ім'я в AOL",
	'openid-provider-label-other-username' => "Введіть Ваше ім'я користувача $1",
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'openid-desc' => "Entra con [http://openid.net/ OpenID] in te la wiki, e entra in tei altri siti web che dòpara OpenID co' na utensa wiki",
	'openidlogin' => 'Acesso con OpenID',
	'openidserver' => 'server OpenID',
	'openidxrds' => 'file Yadis',
	'openidconvert' => 'convertidor OpenID',
	'openiderror' => 'Eròr ne la verifica',
	'openiderrortext' => "Se gà verificà un eròr durante la verifica de l'URL OpenID.",
	'openidconfigerror' => 'Eròr in te la configurassion OpenID',
	'openidconfigerrortext' => 'La configurassion de la memorixassion de OpenID par sta wiki no la xe mia valida.
Par piaser consulta un [[Special:ListUsers/sysop|aministrador]].',
	'openidpermission' => 'Eròr in tei parmessi OpenID',
	'openidpermissiontext' => "A l'OpenID che ti gà fornìo no xe mia parmesso de entrar su sto server.",
	'openidcancel' => 'Verifica anulà',
	'openidcanceltext' => "La verifica de l'URL OpenID le stà scancelà.",
	'openidfailure' => 'Verifica mia riussìa',
	'openidfailuretext' => 'La verifica de l\'URL OpenID la xe \'ndà mal. El messajo de eròr el xe: "$1"',
	'openidsuccess' => 'Verifica efetuà',
	'openidsuccesstext' => "La verifica de l'URL OpenID la xe stà fata coretamente.",
	'openidusernameprefix' => 'Utente OpenID',
	'openidserverlogininstructions' => 'Scrivi qua la to password par entrar su $3 come utente $2 (pàxena utente  $1).',
	'openidtrustinstructions' => 'Contròla se te vol dal bon condivìdar i dati con $1.',
	'openidallowtrust' => 'Parméti a $1 de fidarse de sta utensa.',
	'openidnopolicy' => "El sito no'l gà indicà na polìtega relativa a la privacy.",
	'openidpolicy' => 'Contròla la <a target="_new" href="$1">polìtega relativa a la privacy</a> par savérghene piessè.',
	'openidoptional' => 'Opzional',
	'openidrequired' => 'Obligatorio',
	'openidnickname' => 'Soranòme',
	'openidfullname' => 'Nome par intiero',
	'openidemail' => 'Indirisso de posta eletronica',
	'openidlanguage' => 'Lengoa',
	'openidtimezone' => 'Fuso orario',
	'openidchooseinstructions' => 'Tuti i utenti i gà da verghe un soranòme;
te pol tórghene uno da le opzioni seguenti.',
	'openidchoosefull' => 'El to nome par intiero ($1)',
	'openidchooseurl' => 'Un nome sielto dal to OpenID ($1)',
	'openidchooseauto' => 'Un nome generà automaticamente ($1)',
	'openidchoosemanual' => 'Un nome a sielta tua:',
	'openidchooseexisting' => 'Na utensa esistente su sta wiki:',
	'openidchoosepassword' => 'password:',
	'openidconvertinstructions' => 'Sto modulo el te parmete de canbiar la to utensa par doparar un URL OpenID o zontar altri URL OpenID.',
	'openidconvertsuccess' => 'Convertìo con successo a OpenID',
	'openidconvertsuccesstext' => 'El to OpenID el xe stà convertìo a $1.',
	'openidconvertyourstext' => 'Sto chì el xe xà el to OpenID.',
	'openidconvertothertext' => "Sto chì el xe l'OpenID de calchidun altro.",
	'openidalreadyloggedin' => "'''Te sì xà entrà, $1!'''

Se ti vol doparar OpenID par entrar in futuro, te pol [[Special:OpenIDConvert|convertir la to utensa par doparar OpenID]].",
	'openidnousername' => 'Nissun nome utente indicà.',
	'openidbadusername' => "El nome utente indicà no'l xe mia valido.",
	'openidautosubmit' => 'Sta pàxena la include un modulo che\'l dovarìa èssar invià automaticamente se ti gà JavaScript ativà.
Se no, próa a strucar el boton "Continue" (Continua).',
	'openidclientonlytext' => 'No te podi doparar le utense de sta wiki come OpenID su de un altro sito.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => "{{SITENAME}} el suporta el standard [http://openid.net/ OpenID] par el login unico sui siti web.
OpenID el te permete de registrarte in molti siti web sensa doparar na password difarente par ognuno.
(Lèzi la [http://en.wikipedia.org/wiki/OpenID voce de Wikipedia su l'OpenID] par savérghene piassè.)

Se te ghè zà un account su {{SITENAME}}, te podi far el [[Special:UserLogin|login]] col to nome utente e la to password come al solito.
Par doparar OpenID in futuro, te podi [[Special:OpenIDConvert|convertir el to account a OpenID]] dopo che te ghè fato normalmente el login.

Ghe xe molti [http://openid.net/get/ Provider OpenID], e te podaressi verghe zà un account abilità a l'OpenID su un altro servissio.",
	'openidupdateuserinfo' => 'Ajorna le me informassion personài',
	'openiddelete' => 'Scancela OpenID',
	'openiddelete-button' => 'Va ben',
	'openid-prefstext' => '[http://openid.net/ OpenID] preferense',
	'openid-pref-hide' => 'Scondi el to OpenID su la to pàxena utente, se te fè el login con OpenID.',
	'openid-pref-update-userinfo-on-login' => "Ajorna le seguenti informassion da l'utensa de OpenID ogni olta che me conéto:",
	'openid-urls-action' => 'Azion',
	'openid-urls-delete' => 'Scancela',
	'openid-add-url' => 'Zonta un OpenID novo',
	'openidsigninorcreateaccount' => 'Entra o crèa na utensa nova',
	'openid-provider-label-openid' => "Inserissi l'URL del to OpenID",
	'openid-provider-label-google' => 'Entra doparando la to utensa Google',
	'openid-provider-label-yahoo' => 'Entra doparando la to utensa Yahoo',
	'openid-provider-label-aol' => 'Inserissi el to screenname AOL',
	'openid-provider-label-other-username' => 'Inserissi el to nome utente $1',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'openidxrds' => 'Yadis-fail',
	'openiderror' => 'Verifikacijan petuz',
	'openidoptional' => 'Opcionaline',
	'openidrequired' => 'Pidab',
	'openidnickname' => 'Nikneim',
	'openidemail' => 'E-počtan adres',
	'openidlanguage' => "Kel'",
	'openidtimezone' => 'Aigzon',
	'openidchoosepassword' => 'peitsana:',
	'openidupdateuserinfo' => 'Udištada minun personaline informacii',
	'openiddelete-button' => 'Vahvištoitta',
	'openid-urls-action' => 'Tegend',
	'openid-urls-delete' => 'Heitta poiš',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'openid-desc' => 'Đăng nhập vào wiki dùng [http://openid.net/ OpenID] và đăng nhập vào các website nhận OpenID dùng tài khoản wiki',
	'openidlogin' => 'Đăng nhập dùng OpenID',
	'openidserver' => 'Dịch vụ OpenID',
	'openidxrds' => 'Tập tin Yadis',
	'openidconvert' => 'Chuyển đổi OpenID',
	'openiderror' => 'Lỗi thẩm tra',
	'openiderrortext' => 'Có lỗi khi thẩm tra địa chỉ OpenID.',
	'openidconfigerror' => 'Lỗi thiết lập OpenID',
	'openidconfigerrortext' => 'Cấu hình nơi lưu trữ OpenID cho wiki này không hợp lệ.
Xin hãy liên lạc với [[Special:ListUsers/sysop|quản lý viên]].',
	'openidpermission' => 'Lỗi quyền OpenID',
	'openidpermissiontext' => 'Địa chỉ OpenID của bạn không được phép đăng nhập vào dịch vụ này.',
	'openidcancel' => 'Đã hủy bỏ thẩm tra',
	'openidcanceltext' => 'Đã hủy bỏ việc thẩm tra địa chỉ OpenID.',
	'openidfailure' => 'Không thẩm tra được',
	'openidfailuretext' => 'Không thể thẩm tra địa chỉ OpenID. Lỗi: “$1”',
	'openidsuccess' => 'Đã thẩm tra thành công',
	'openidsuccesstext' => 'Đã thẩm tra địa chỉ OpenID thành công.',
	'openidusernameprefix' => 'Thành viên OpenID',
	'openidserverlogininstructions' => 'Hãy cho vào mật khẩu ở dưới để đăng nhập vào $3 dùng tài khoản $2 (trang thảo luận $1).',
	'openidtrustinstructions' => 'Hãy kiểm tra hộp này nếu bạn muốn cho $1 biết thông tin cá nhân của bạn.',
	'openidallowtrust' => 'Để $1 tin cậy vào tài khoản này.',
	'openidnopolicy' => 'Website chưa xuất bản chính sách về sự riêng tư.',
	'openidpolicy' => 'Hãy đọc <a target="_new" href="$1">chính sách về sự riêng tư</a> để biết thêm chi tiết.',
	'openidoptional' => 'Tùy ý',
	'openidrequired' => 'Bắt buộc',
	'openidnickname' => 'Tên hiệu',
	'openidfullname' => 'Tên đầy đủ',
	'openidemail' => 'Địa chỉ thư điện tử',
	'openidlanguage' => 'Ngôn ngữ',
	'openidtimezone' => 'Múi giờ',
	'openidchooseinstructions' => 'Mọi người dùng cần có tên hiệu; bạn có thể chọn tên hiệu ở dưới.',
	'openidchoosenick' => 'Tên hiệu của bạn ($1)',
	'openidchoosefull' => 'Tên đầy đủ của bạn ($1)',
	'openidchooseurl' => 'Tên bắt nguồn từ OpenID của bạn ($1)',
	'openidchooseauto' => 'Tên tự động ($1)',
	'openidchoosemanual' => 'Tên khác:',
	'openidchooseexisting' => 'Một tài khoản hiện có trên wiki này',
	'openidchooseusername' => 'tên người dùng:',
	'openidchoosepassword' => 'mật khẩu:',
	'openidconvertinstructions' => 'Mẫu này cho phép bạn thay đổi tài khoản người dùng của bạn để sử dụng một địa chỉ URL OpenID hay thêm địa chỉ OpenID.',
	'openidconvertoraddmoreids' => 'Chuyển đổi OpenID hay thêm địa chỉ OpenID',
	'openidconvertsuccess' => 'Đã chuyển đổi sang OpenID thành công',
	'openidconvertsuccesstext' => 'Bạn đã chuyển đổi OpenID của bạn sang $1 thành công.',
	'openidconvertyourstext' => 'Đó đã là OpenID của bạn.',
	'openidconvertothertext' => 'Đó là OpenID của một người nào khác.',
	'openidalreadyloggedin' => "'''Bạn đã đăng nhập rồi, $1!'''

Nếu bạn muốn sử dụng OpenID để đăng nhập vào lần sau, bạn có thể [[Special:OpenIDConvert|chuyển đổi tài khoản của bạn để dùng OpenID]].",
	'openidnousername' => 'Chưa chỉ định tên người dùng.',
	'openidbadusername' => 'Tên người dùng không hợp lệ.',
	'openidautosubmit' => 'Trang này có một mẫu sẽ tự động đăng lên nếu bạn kích hoạt JavaScript.
Nếu không, hãy thử nút "Continue" (Tiếp tục).',
	'openidclientonlytext' => 'Bạn không thể sử dụng tài khoản tại wiki này như OpenID tại trang khác.',
	'openidloginlabel' => 'Địa chỉ OpenID',
	'openidlogininstructions' => '{{SITENAME}} hỗ trợ chuẩn [http://openid.net/ OpenID] để đăng nhập một lần giữa các trang web.
OpenID cho phép bạn đăng nhập vào nhiều trang web khác nhau mà không phải sử dụng mật khẩu khác nhau tại mỗi trang.
(Xem [http://en.wikipedia.org/wiki/OpenID bài viết về OpenID của Wikipedia] để biết thêm chi tiết.)

Nếu bạn đã có một tài khoản tại {{SITENAME}}, bạn có thể [[Special:UserLogin|đăng nhập]] bằng tên người dùng và mật khẩu của bạn như thông thường.
Để dùng OpenID vào lần sau, bạn có thể [[Special:OpenIDConvert|chuyển đổi tài khoản của bạn sang OpenID]] sau khi đã đăng nhập bình thường.

Có nhiều [http://wiki.openid.net/Public_OpenID_providers nhà cung cấp OpenID Công cộng], và có thể bạn đã có một tài khoản kích hoạt OpenID tại dịch vụ khác.',
	'openidupdateuserinfo' => 'Cập nhật thông tin cá nhân của tôi:',
	'openiddelete' => 'Xóa OpenID',
	'openiddelete-text' => 'Khi bấm nút “{{int:openiddelete-button}}”, bạn sẽ dời OpenID $1 khỏi tài khoản của bạn.
Bạn sẽ không đăng nhập được dùng OpenID này.',
	'openiddelete-button' => 'Xác nhận',
	'openiddelete-sucess' => 'Đã dời OpenID thành công khỏi tài khoản của bạn.',
	'openiddelete-error' => 'Đã gặp lỗi khi dời OpenID khỏi tài khoản của bạn.',
	'openid-prefstext' => 'Tùy chỉnh [http://openid.net/ OpenID]',
	'openid-pref-hide' => 'Ẩn OpenID của bạn khỏi trang thành viên, nếu bạn đăng nhập bằng ID Mở.',
	'openid-pref-update-userinfo-on-login' => 'Cập nhật thông tin sau từ persona OpenID mỗi khi tôi đăng nhập:',
	'openid-urls-desc' => 'Các OpenID được gắn vào tài khoản của bạn:',
	'openid-urls-action' => 'Tác vụ',
	'openid-urls-delete' => 'Xóa',
	'openid-add-url' => 'Thêm OpenID mới',
	'openidsigninorcreateaccount' => 'Đăng nhập hay mở tài khoản mới',
	'openid-provider-label-openid' => 'Ghi vào URL OpenID của bạn',
	'openid-provider-label-google' => 'Đăng nhập dùng tài khoản Google',
	'openid-provider-label-yahoo' => 'Đăng nhập dùng tài khoản Yahoo!',
	'openid-provider-label-aol' => 'Ghi vào tên màn hình AOL',
	'openid-provider-label-other-username' => 'Ghi vào tên người dùng $1',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'openiderror' => 'Kontrolamapöl',
	'openidoptional' => 'No peflagon',
	'openidrequired' => 'Peflagon',
	'openidnickname' => 'Näinem',
	'openidfullname' => 'Nem lölik',
	'openidemail' => 'Ladet leäktronik',
	'openidlanguage' => 'Pük',
	'openidchooseinstructions' => 'Gebans valik neodons näinemi;
kanol välön bali sökölas.',
	'openidchoosefull' => 'Nem lölik ola ($1)',
	'openidchooseauto' => 'Nem itjäfidiko pejaföl ($1)',
	'openidchoosemanual' => 'Nem fa ol pevälöl:',
	'openidchooseexisting' => 'Kal in vük at dabinöl:',
	'openidchoosepassword' => 'letavöd:',
	'openidnousername' => 'Gebananem nonik pegivon.',
	'openidbadusername' => 'Gebananem no lonöföl pegivon.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'openidchoosepassword' => 'פאַסווארט:',
	'openid-urls-delete' => 'אויסמעקן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hans'] = array(
	'openid-desc' => '使用一个[http://openid.net/ OpenID]来登录到这个wiki，以及使用wiki用户帐号登录到其他接受OpenID的网站',
	'openidlogin' => '使用OpenID登陆',
	'openidserver' => 'OpenID服务器',
	'openidxrds' => 'Yadis文件',
	'openidconvert' => 'OpenID转换',
	'openiderror' => '验证错误',
	'openiderrortext' => '在验证OpenID地址时出现了一个错误。',
	'openidconfigerror' => 'OpenID配制出错',
	'openidconfigerrortext' => '这个维基的OpenID存储设置无法使用。
请通知[[Special:ListUsers/sysop|管理员]]。',
	'openidpermission' => 'OpenID许可错误',
	'openidpermissiontext' => '您提供的OpenID不允许在本服务器上登录。',
	'openidcancel' => '验证取消',
	'openidcanceltext' => 'OpenID地址验证被取消。',
	'openidfailure' => '验证失败',
	'openidfailuretext' => 'OpenID地址验证失败。错误信息："$1"',
	'openidsuccess' => '验证成功',
	'openidsuccesstext' => 'OpenID地址验证成功。',
	'openidusernameprefix' => 'OpenID用户',
	'openidserverlogininstructions' => '请在下面输入您的密码以便以用户$2登陆$3 （用户页面$1）。',
	'openidtrustinstructions' => '请确认您是否愿与$1分享数据。',
	'openidallowtrust' => '允许$1信任这个用户的账户。',
	'openidnopolicy' => '站点没有提供隐私政策。',
	'openidpolicy' => '如要获得更多信息，请参见<a target="_new" href="$1">隐私政策</a>。',
	'openidoptional' => '可选',
	'openidrequired' => '必选',
	'openidnickname' => '昵称',
	'openidfullname' => '全称',
	'openidemail' => '电子邮件地址',
	'openidlanguage' => '语言',
	'openidtimezone' => '时区',
	'openidchooseinstructions' => '所有的用户都需要提供昵称；
您可以从下面任选一个。',
	'openidchoosefull' => '您的全名（$1）',
	'openidchooseurl' => '从您的OpenID获取的名称（$1）',
	'openidchooseauto' => '自动生成的名称（$1）',
	'openidchoosemanual' => '您选择的名称：',
	'openidchooseexisting' => '本维基已经存在的帐户：',
	'openidchoosepassword' => '密码：',
	'openidconvertinstructions' => '本表单可以将您的用户账号修改为OpenID地址。',
	'openidconvertoraddmoreids' => '转换到OpenID或添加另一个OpenID URL',
	'openidconvertsuccess' => '成功转换为OpenID',
	'openidconvertsuccesstext' => '您已经成功的将您的OpenID转化为$1。',
	'openidconvertyourstext' => '这已经是您的OpenID。',
	'openidconvertothertext' => '这是别人的OpenID。',
	'openidalreadyloggedin' => "'''您已经成功登陆了，$1！'''

如果您想以后使用OpenID登陆，您可以[[Special:OpenIDConvert|转换您的帐户使用OpenID]]。",
	'openidnousername' => '没有指定用户名。',
	'openidbadusername' => '指定的用户名是错误的。',
	'openidautosubmit' => '本页包含的表单在启用JavaScript的情况下可以自动提交。
如果没有自动提交，请按 "Continue" （继续）按钮。',
	'openidclientonlytext' => '你不能在其他站点上使用这个wiki的帐号作为OpenID。',
	'openidloginlabel' => 'OpenID地址',
	'openidupdateuserinfo' => '更新我的个人信息',
	'openiddelete' => '删除OpenID',
	'openiddelete-button' => '确认',
	'openid-prefstext' => '[http://openid.net/ OpenID]参数设置',
	'openid-pref-hide' => '如果使用OpenID登陆，您可以在您的用户页隐藏您的OpenID。',
	'openid-urls-desc' => '和你的帐号关联的OpenID：',
	'openid-urls-action' => '动作',
	'openid-urls-delete' => '删除',
	'openid-add-url' => '添加一个新的OpenID',
	'openidsigninorcreateaccount' => '登录或创建新帐号',
	'openid-provider-label-openid' => '输入你的OpenID URL',
	'openid-provider-label-google' => '使用你的Google帐号登录',
	'openid-provider-label-yahoo' => '使用你的Yahoo帐号登录',
	'openid-provider-label-aol' => '输入你的AOL屏幕名称',
	'openid-provider-label-other-username' => '输入你的$1用户名',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'openid-desc' => '使用一個[http://openid.net/ OpenID]來登錄到這個wiki，以及使用wiki用戶帳號登錄到其他接受OpenID的網站',
	'openidlogin' => '使用OpenID登入',
	'openidserver' => 'OpenID伺服器',
	'openidxrds' => 'Yadis文件',
	'openidconvert' => 'OpenID轉換器',
	'openiderror' => '驗證錯誤',
	'openiderrortext' => '在驗證OpenID地址時出現了一個錯誤。',
	'openidconfigerror' => 'OpenID配製出錯',
	'openidconfigerrortext' => '這個維基的OpenID存儲設置無法使用。
請通知[[Special:ListUsers/sysop|管理員]]。',
	'openidpermission' => 'OpenID許可錯誤',
	'openidpermissiontext' => '您提供的OpenID不允許在本服務器上登錄。',
	'openidcancel' => '驗證已取消',
	'openidcanceltext' => 'OpenID地址驗證被取消。',
	'openidfailure' => '驗證失敗',
	'openidfailuretext' => 'OpenID地址驗證失敗。錯誤信息："$1"',
	'openidsuccess' => '驗證成功',
	'openidsuccesstext' => 'OpenID地址驗證成功。',
	'openidusernameprefix' => 'OpenID用戶',
	'openidserverlogininstructions' => '請在下面輸入您的密碼以便以用戶$2登陸$3 （用戶頁面$1）。',
	'openidtrustinstructions' => '請確認您是否願與$1分享數據。',
	'openidallowtrust' => '允許$1信任這個用戶的賬戶。',
	'openidnopolicy' => '站點沒有提供隱私政策。',
	'openidpolicy' => '如要獲得更多信息，請參見<a target="_new" href="$1">隱私政策</a>。',
	'openidoptional' => '可選',
	'openidrequired' => '必選',
	'openidnickname' => '暱稱',
	'openidfullname' => '全名',
	'openidemail' => '電郵地址',
	'openidlanguage' => '語言',
	'openidtimezone' => '時區',
	'openidchooseinstructions' => '所有的用戶都需要提供昵稱；
您可以從下面任選一個。',
	'openidchoosefull' => '您的全名 （$1）',
	'openidchooseurl' => '從您的OpenID獲取的名稱（$1）',
	'openidchooseauto' => '自動生成的名稱（$1）',
	'openidchoosemanual' => '您選擇的名稱：',
	'openidchooseexisting' => '本維基已經存在的帳戶：',
	'openidchoosepassword' => '密碼：',
	'openidconvertinstructions' => '本表單可以將您的用戶賬號修改為OpenID地址。',
	'openidconvertoraddmoreids' => '轉換到OpenID或添加另一個OpenID URL',
	'openidconvertsuccess' => '成功轉換為OpenID',
	'openidconvertsuccesstext' => '您已經成功的將您的OpenID轉化為$1。',
	'openidconvertyourstext' => '這已是您的OpenID了。',
	'openidconvertothertext' => '這是別人的OpenID。',
	'openidalreadyloggedin' => "'''您已經成功登陸了，$1！'''

如果您想以後使用OpenID登陸，您可以[[Special:OpenIDConvert|轉換您的帳戶使用OpenID]]。",
	'openidnousername' => '沒有指定用戶名。',
	'openidbadusername' => '指定的用戶名是錯誤的。',
	'openidautosubmit' => '本頁包含的表單在啟用JavaScript的情況下可以自動提交。
如果沒有自動提交，請按 "Continue" （繼續）按鈕。',
	'openidclientonlytext' => '你不能在其他站點上使用這個wiki的帳號作為OpenID。',
	'openidloginlabel' => 'OpenID網址',
	'openidupdateuserinfo' => '更新我的個人信息',
	'openiddelete' => '刪除OpenID',
	'openiddelete-button' => '確認',
	'openid-prefstext' => '[http://openid.net/ OpenID]參數設置',
	'openid-pref-hide' => '如果使用OpenID登陸，您可以在您的用戶頁隱藏您的OpenID。',
	'openid-urls-desc' => '和你的帳號關聯的OpenID：',
	'openid-urls-action' => '動作',
	'openid-urls-delete' => '删除',
	'openid-add-url' => '加入一個新的OpenID',
	'openidsigninorcreateaccount' => '登錄或創建新帳號',
	'openid-provider-label-openid' => '輸入你的OpenID URL',
	'openid-provider-label-google' => '以您的Google帳戶登入',
	'openid-provider-label-yahoo' => '以您的Yahoo帳戶登入',
	'openid-provider-label-aol' => '輸入你的AOL屏幕名稱',
	'openid-provider-label-other-username' => '輸入你的$1用戶名',
);

