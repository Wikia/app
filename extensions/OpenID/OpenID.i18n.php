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

If you already have an account on {{SITENAME}}, you can [[Special:UserLogin|log in]] with your username and password as usual.
To use OpenID in the future, you can [[Special:OpenIDConvert|convert your account to OpenID]] after you have logged in normally.

There are many [http://wiki.openid.net/Public_OpenID_providers Public OpenID providers], and you may already have an OpenID-enabled account on another service.

; Other wikis : If you have an account on an OpenID-enabled wiki, like [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] or [http://kei.ki/ Keiki], you can log in to {{SITENAME}} by entering the \'\'\'full URL\'\'\' of your user page on that other wiki in the box above. For example, \'\'<nowiki>http://kei.ki/en/User:Evan</nowiki>\'\'.
; [http://openid.yahoo.com/ Yahoo!] : If you have an account with Yahoo!, you can log in to this site by entering your Yahoo!-provided OpenID in the box above. Yahoo! OpenID URLs have the form \'\'<nowiki>https://me.yahoo.com/yourusername</nowiki>\'\'.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : If you have an account with [http://www.aol.com/ AOL], like an [http://www.aim.com/ AIM] account, you can log in to {{SITENAME}} by entering your AOL-provided OpenID in the box above. AOL OpenID URLs have the form \'\'<nowiki>http://openid.aol.com/yourusername</nowiki>\'\'. Your username should be all lowercase, no spaces.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : If you have a blog on any of these services, enter your blog URL in the box above. For example, \'\'<nowiki>http://yourusername.blogspot.com/</nowiki>\'\', \'\'<nowiki>http://yourusername.wordpress.com/</nowiki>\'\', \'\'<nowiki>http://yourusername.livejournal.com/</nowiki>\'\', or \'\'<nowiki>http://yourusername.vox.com/</nowiki>\'\'.',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'openid-desc' => 'Short description of the Openid extension, shown in [[Special:Version]]. Do not translate or change links.',
	'openidtrustinstructions' => '* $1 is a trust root. A trust root looks much like a normal URL, but is used to describe a set of URLs. Trust roots are used by OpenID to verify that a user has approved the OpenID enabled website.',
	'openidoptional' => '{{Identical|Optional}}',
	'openidemail' => '{{Identical|E-mail address}}',
	'openidlanguage' => '{{Identical|Language}}',
	'openidchoosepassword' => '{{Identical|Password}}',
	'openidalreadyloggedin' => '$1 is a user name.',
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
	'openidoptional' => 'Opsioneel',
	'openidrequired' => 'Verpligtend',
	'openidemail' => 'E-pos adres',
	'openidlanguage' => 'Taal',
	'openidchoosepassword' => 'wagwoord:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'openidemail' => 'የኢ-ሜል አድራሻ',
	'openidlanguage' => 'ቋንቋ',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'openid-desc' => 'سجل الدخول للويكي [http://openid.net/ بهوية مفتوحة]، وسجل الدخول لمواقع ويب أخرى تعرف الهوية المفتوحة بحساب مستخدم ويكي',
	'openidlogin' => 'تسجيل الدخول بالهوية المفتوحة',
	'openidfinish' => 'إنهاء دخول الهوية المفتوحة',
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
	'openidfailure' => 'التأكيد فشل',
	'openidfailuretext' => 'التحقق من مسار الهوية المفتوحة فشل. رسالة خطأ: "$1"',
	'openidsuccess' => 'التأكيد نجح',
	'openidsuccesstext' => 'التحقق من مسار الهوية المفتوحة نجح.',
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
	'openidnotavailable' => 'لقبك المفضل ($1) قيد الاستخدام بالفعل بواسطة مستخدم آخر.',
	'openidnotprovided' => 'خادم هويتك المفتوحة لم يوفر لقبا (إما لأنه لا يستطيع، أو لأنك أخبرته ألا يفعل).',
	'openidchooseinstructions' => 'كل المستخدمين يحتاجون إلى لقب؛
يمكنك أن تختار واحدا من الخيارات بالأسفل.',
	'openidchoosefull' => 'اسمك الكامل ($1)',
	'openidchooseurl' => 'اسم مختار من هويتك المفتوحة ($1)',
	'openidchooseauto' => 'اسم مولد تلقائيا ($1)',
	'openidchoosemanual' => 'اسم من اختيارك:',
	'openidchooseexisting' => 'حساب موجود في هذه الويكي:',
	'openidchoosepassword' => 'كلمة السر:',
	'openidconvertinstructions' => 'هذه الإستمارة تسمح لك بتغيير حساب مستخدمك ليستعمل مسار هوية مفتوحة.',
	'openidconvertsuccess' => 'تم التحول بنجاح إلى الهوية المفتوحة',
	'openidconvertsuccesstext' => 'أنت حولت بنجاح هويتك المفتوحة إلى $1.',
	'openidconvertyourstext' => 'هذه بالفعل هويتك المفتوحة.',
	'openidconvertothertext' => 'هذه هي الهوية المفتوحة لشخص آخر.',
	'openidalreadyloggedin' => "'''أنت مسجل الدخول بالفعل، $1!'''

لو كنت تريد استخدام الهوية المفتوحة لتسجيل الدخول في المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك لاستخدام الهوية المفتوحة]].",
	'tog-hideopenid' => 'أخف هويتك <a href="http://openid.net/">هويتك المفتوحة</a> على صفحتك الشخصية، لو سجلت الدخول بالهوية المفتوحة.',
	'openidnousername' => 'لا اسم مستخدم تم تحديده.',
	'openidbadusername' => 'اسم المستخدم المحدد سيء.',
	'openidautosubmit' => 'هذه الصفحة تحتوي على إستمارة ينبغي أن يتم إرسالها تلقائيا لو أنك لديك الجافاسكريبت مفعلة.
لو لا، جرب زر \\"Continue\\".',
	'openidclientonlytext' => 'أنت لا يمكنك استخدام الحسابات من هذا الويكي كهوية مفتوحة على موقع آخر.',
	'openidloginlabel' => 'مسار الهوية المفتوحة',
	'openidlogininstructions' => "{{SITENAME}} تدعم معيار [http://openid.net/ الهوية المفتوحة] للدخول الفردي بين مواقع الويب.
الهوية المفتوحة تسمح لك بتسجيل الدخول إلى مواقع ويب عديدة مختلفة بدون استخدام كلمة سر مختلفة لكل موقع.
(انظر [http://en.wikipedia.org/wiki/OpenID مقالة الهوية المفتوحة في يويكيبيديا] لمزيد من المعلومات.)

لو أنك لديك بالفعل حساب في {{SITENAME}}، يمكنك [[Special:UserLogin|تسجيل الدخول]] باسم مستخدمك وكلمة السر الخاصة بك كالمعتاد.
لاستخدام الهوية المفتوحة في المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك إلى الهوية المفتوحة]] بعد تسجيل دخولك بشكل عادي.

يوجد العديد من [http://wiki.openid.net/Public_OpenID_providers موفري الهوية المفتوحة العلنيين]، وربما يكون لديك حسابك بهوية مفتوحة على خدمة أخرى.

; الويكيات الأخرى : لو أنك لديك حساب على ويكي مفعل الهوية المفتوحة، مثل [http://wikitravel.org/ ويكي ترافيل]، [http://www.wikihow.com/ ويكي هاو]، [http://vinismo.com/ فينيزمو]، [http://aboutus.org/ أبوت أس] أو [http://kei.ki/ كيكي]، يمكنك تسجيل الدخول إلى {{SITENAME}} بواسطة إدخال '''المسار الكامل''' لصفحة مستخدمك على هذا الويكي الآخر في الصندوق بالأعلى. على سبيل المثال، ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ ياهو!] : إذا لديك حساب مع ياهو!، يمكنك تسجيل الدخول إلى هذا الموقع بواسطة إدخال هويتك المفتوحة الموفرة بواسطة ياهو! في الصندوق بالأعلى. مسارات هوية ياهو! المفتوحة تأخذ الصيغة ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids إيه أو إل] : لو لديك حساب مع [http://www.aol.com/ إيه أو إل]، مثل حساب [http://www.aim.com/ إيه أي إم]، يمكنك تسجيل الدخول إلى {{SITENAME}} بواسطة إدخال هويتك المفتوحة الموفرة بواسطة AOL في الصندوق بالأعلى. مسارات هوية AOL المفتوحة تأخذ الصيغة ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. اسم مستخدمك ينبغي أن يكون كله حروفا صغيرة، لا مسافات.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html بلوجر], [http://faq.wordpress.com/2007/03/06/what-is-openid/ وورد بريس دوت كوم]، [http://www.livejournal.com/openid/about.bml ليف جورنال]، [http://bradfitz.vox.com/library/post/openid-for-vox.html فوكس] : لو لديك مدونة على أي من هذه الخدمات، أدخل مسار مدونتك في الصندوق بالأعلى. على سبيل المثال، ''<nowiki>http://yourusername.blogspot.com/</nowiki>''، ''<nowiki>http://yourusername.wordpress.com/</nowiki>''، ''<nowiki>http://yourusername.livejournal.com/</nowiki>''، أو ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'openid-desc' => 'سجل الدخول للويكى [http://openid.net/ بهوية مفتوحة]، وسجل الدخول لمواقع ويب أخرى تعرف الهوية المفتوحة بحساب مستخدم ويكي',
	'openidlogin' => 'تسجيل الدخول بالهوية المفتوحة',
	'openidfinish' => 'إنهاء دخول الهوية المفتوحة',
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
	'openidnotavailable' => 'لقبك المفضل ($1) قيد الاستخدام بالفعل بواسطة مستخدم آخر.',
	'openidnotprovided' => 'خادم هويتك المفتوحة لم يوفر لقبا (إما لأنه لا يستطيع، أو لأنك أخبرته ألا يفعل).',
	'openidchooseinstructions' => 'كل المستخدمين يحتاجون إلى لقب؛
يمكنك أن تختار واحدا من الخيارات بالأسفل.',
	'openidchoosefull' => 'اسمك الكامل ($1)',
	'openidchooseurl' => 'اسم مختار من هويتك المفتوحة ($1)',
	'openidchooseauto' => 'اسم مولد تلقائيا ($1)',
	'openidchoosemanual' => 'اسم من اختيارك:',
	'openidchooseexisting' => 'حساب موجود فى هذه الويكي:',
	'openidchoosepassword' => 'كلمة السر:',
	'openidconvertinstructions' => 'هذه الإستمارة تسمح لك بتغيير حساب مستخدمك ليستعمل مسار هوية مفتوحة.',
	'openidconvertsuccess' => 'تم التحول بنجاح إلى الهوية المفتوحة',
	'openidconvertsuccesstext' => 'أنت حولت بنجاح هويتك المفتوحة إلى $1.',
	'openidconvertyourstext' => 'هذه بالفعل هويتك المفتوحة.',
	'openidconvertothertext' => 'هذه هى الهوية المفتوحة لشخص آخر.',
	'openidalreadyloggedin' => "'''أنت مسجل الدخول بالفعل، $1!'''

لو كنت تريد استخدام الهوية المفتوحة لتسجيل الدخول فى المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك لاستخدام الهوية المفتوحة]].",
	'tog-hideopenid' => 'أخف هويتك <a href="http://openid.net/">هويتك المفتوحة</a> على صفحتك الشخصية، لو سجلت الدخول بالهوية المفتوحة.',
	'openidnousername' => 'مافيش اسم يوزر تم تحديده.',
	'openidbadusername' => 'اسم المستخدم المحدد سيء.',
	'openidautosubmit' => 'هذه الصفحة تحتوى على إستمارة ينبغى أن يتم إرسالها تلقائيا لو أنك لديك الجافاسكريبت مفعلة.
لو لا، جرب زر \\"Continue\\".',
	'openidclientonlytext' => 'أنت لا يمكنك استخدام الحسابات من هذا الويكى كهوية مفتوحة على موقع آخر.',
	'openidloginlabel' => 'مسار الهوية المفتوحة',
	'openidlogininstructions' => "{{SITENAME}} تدعم معيار [http://openid.net/ الهوية المفتوحة] للدخول الفردى بين مواقع الويب.
الهوية المفتوحة تسمح لك بتسجيل الدخول إلى مواقع ويب عديدة مختلفة بدون استخدام كلمة سر مختلفة لكل موقع.
(انظر [http://en.wikipedia.org/wiki/OpenID مقالة الهوية المفتوحة فى يويكيبيديا] لمزيد من المعلومات.)

لو أنك لديك بالفعل حساب فى {{SITENAME}}، يمكنك [[Special:UserLogin|تسجيل الدخول]] باسم مستخدمك وكلمة السر الخاصة بك كالمعتاد.
لاستخدام الهوية المفتوحة فى المستقبل، يمكنك [[Special:OpenIDConvert|تحويل حسابك إلى الهوية المفتوحة]] بعد تسجيل دخولك بشكل عادي.

يوجد العديد من [http://wiki.openid.net/Public_OpenID_providers موفرى الهوية المفتوحة العلنيين]، وربما يكون لديك حسابك بهوية مفتوحة على خدمة أخرى.

; الويكيات الأخرى : لو أنك لديك حساب على ويكى مفعل الهوية المفتوحة، مثل [http://wikitravel.org/ ويكى ترافيل]، [http://www.wikihow.com/ ويكى هاو]، [http://vinismo.com/ فينيزمو]، [http://aboutus.org/ أبوت أس] أو [http://kei.ki/ كيكي]، يمكنك تسجيل الدخول إلى {{SITENAME}} بواسطة إدخال '''المسار الكامل''' لصفحة مستخدمك على هذا الويكى الآخر فى الصندوق بالأعلى. على سبيل المثال، ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ ياهو!] : إذا لديك حساب مع ياهو!، يمكنك تسجيل الدخول إلى هذا الموقع بواسطة إدخال هويتك المفتوحة الموفرة بواسطة ياهو! فى الصندوق بالأعلى. مسارات هوية ياهو! المفتوحة تأخذ الصيغة ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids إيه أو إل] : لو لديك حساب مع [http://www.aol.com/ إيه أو إل]، مثل حساب [http://www.aim.com/ إيه أى إم]، يمكنك تسجيل الدخول إلى {{SITENAME}} بواسطة إدخال هويتك المفتوحة الموفرة بواسطة AOL فى الصندوق بالأعلى. مسارات هوية AOL المفتوحة تأخذ الصيغة ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. اسم مستخدمك ينبغى أن يكون كله حروفا صغيرة، لا مسافات.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html بلوجر], [http://faq.wordpress.com/2007/03/06/what-is-openid/ وورد بريس دوت كوم]، [http://www.livejournal.com/openid/about.bml ليف جورنال]، [http://bradfitz.vox.com/library/post/openid-for-vox.html فوكس] : لو لديك مدونة على أى من هذه الخدمات، أدخل مسار مدونتك فى الصندوق بالأعلى. على سبيل المثال، ''<nowiki>http://yourusername.blogspot.com/</nowiki>''، ''<nowiki>http://yourusername.wordpress.com/</nowiki>''، ''<nowiki>http://yourusername.livejournal.com/</nowiki>''، أو ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'openidlanguage' => 'Llingua',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'openidlogin' => 'Влизане с OpenID',
	'openidfinish' => 'Приключване на OpenID влизането',
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
	'openidnotavailable' => 'Избраното потребителско име ($1) вече се използва от друг потребител.',
	'openidchooseinstructions' => 'Всички потребители трябва да имат потребителско име;
можете да изберете своето от предложенията по-долу.',
	'openidchoosefull' => 'Вашето пълно име ($1)',
	'openidchooseauto' => 'Автоматично генерирано име ($1)',
	'openidchoosemanual' => 'Име по избор:',
	'openidchooseexisting' => 'Съществуваща сметка в това уики:',
	'openidchoosepassword' => 'парола:',
	'openidconvertinstructions' => 'Този формуляр позволява да се промени потребителската сметка да използва OpenID URL.',
	'openidconvertsuccess' => 'Преобразуването в OpenID беше успешно',
	'openidconvertsuccesstext' => 'Успешно преобразувахте вашият OpenID в $1.',
	'openidconvertyourstext' => 'Това вече е вашият OpenID.',
	'openidconvertothertext' => 'Това е OpenID на някой друг.',
	'openidalreadyloggedin' => "'''Вече сте влезли в системата, $1!'''

Ако желаете да използвате OpenID за бъдещи влизания, можете да [[Special:OpenIDConvert|преобразувате сметката си да използва OpenID]].",
	'tog-hideopenid' => 'Скриване на <a href="http://openid.net/">OpenID</a> от потребителската страница ако влезете чрез OpenID.',
	'openidnousername' => 'Не е посочено потребителско име.',
	'openidbadusername' => 'Беше посочено невалидно име.',
	'openidautosubmit' => 'Тази страница включва формуляр, който би трябвало да се изпрати автоматично ако Джаваскриптът е разрешен.
Ако не е, можете да използвате бутона \\"Продължаване\\".',
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
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'openidlogin' => 'Prijava sa OpenID',
	'openidfinish' => 'Završi OpenID prijavu',
	'openidserver' => 'OpenID server',
	'openidxrds' => 'Yadis datoteka',
	'openidconvert' => 'OpenID pretvarač',
	'openiderror' => 'Greška pri provjeri',
	'openiderrortext' => 'Desila se greška pri provjeri OpenID URL adrese.',
	'openidconfigerror' => 'Greška OpenID postavki',
	'openidpermission' => 'Greška kod OpenID dopuštenja',
	'openidcancel' => 'Provjera poništena',
	'openidfailure' => 'Potvrda nije uspjela',
	'openidsuccess' => 'Provjera uspješna',
	'openidserverlogininstructions' => 'Unesite ispod Vašu šifru da biste se prijavili na $3 kao korisnik $2 (korisnička stranica $1).',
	'openidtrustinstructions' => 'Provjerite da li želite dijeliti podatke sa $1.',
	'openidallowtrust' => 'Omogući $1 da vjeruje ovom korisničkom računu.',
	'openidnopolicy' => 'Sajt nema napisana pravila privatnosti.',
	'openidoptional' => 'opcionalno',
	'openidrequired' => 'obavezno',
	'openidnickname' => 'Nadimak',
	'openidfullname' => 'Puno ime',
	'openidemail' => 'E-mail adresa',
	'openidlanguage' => 'Jezik',
	'openidnotavailable' => 'Vaš odabrani nadimak ($1) je već upotrijebio drugi korisnik.',
	'openidchooseinstructions' => 'Svi korisnici trebaju imati nadimak;
možete odabrati jedan sa opcijama ispod.',
	'openidchoosefull' => 'Vaše puno ime ($1)',
	'openidchooseurl' => 'Ime uzeto sa Vašeg OpenID ($1)',
	'openidchooseauto' => 'Automatski generisano ime ($1)',
	'openidchoosemanual' => 'Naziv po Vašem izboru:',
	'openidchooseexisting' => 'Postojeći račun na ovoj wiki:',
	'openidchoosepassword' => 'šifra:',
	'openidconvertinstructions' => 'Ovaj obrazac Vam omogućuje da promijeniti Vaš korisnički račun za upotrebu URL OpenID.',
	'openidconvertsuccesstext' => 'Uspješno ste pretvorili Vaš OpenID u $1.',
	'openidconvertyourstext' => 'To je već Vaš OpenID.',
	'openidconvertothertext' => 'To je OpenID koji pripada nekom drugom.',
	'openidalreadyloggedin' => "'''Vi ste već prijavljeni, $1!'''

Ako želite da koristite OpenID za buduće prijave, možete [[Special:OpenIDConvert|promijeniti Vaš račun za upotrebu OpenID]].",
	'tog-hideopenid' => 'Sakrij Vaš <a href="http://openid.net/">OpenID</a> na Vašoj korisničkoj stranici, ako ste prijavljeni sa OpenID.',
	'openidnousername' => 'Nije navedeno korisničko ime.',
	'openidbadusername' => 'Navedeno loše korisničko ime.',
	'openidclientonlytext' => 'Ne možete koristiti račune sa ove wiki kao OpenID na drugom sajtu.',
	'openidloginlabel' => 'OpenID URL adresa',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'openid-desc' => 'Přihlaste se na wiki pomocí [http://openid.net OpenID] a přihlaste se na jiné stránky podporující OpenID pomocí uživatelského účtu wiki',
	'openidlogin' => 'Přihlásit se pomocí OpenID',
	'openidfinish' => 'Dokončit přihlášení pomocí OpenID',
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
	'openidnotavailable' => 'Vaši preferovanou přezdívku ($1) už používá jiný uživatel.',
	'openidnotprovided' => 'Váš OpenID server neposkytnul přezdívku (buď protože nemůže, nebo protože jste mu určili aby ji neposkytoval).',
	'openidchooseinstructions' => 'Kyždý uživatel musí mít přezdívku; můžete si vybrat z níže uvedených možností.',
	'openidchoosefull' => 'Vaše celé jméno ($1)',
	'openidchooseurl' => 'Jméno na základě vašeho OpenID ($1)',
	'openidchooseauto' => 'Automaticky vytvořené jméno ($1)',
	'openidchoosemanual' => 'Jméno, které si vyberete:',
	'openidchooseexisting' => 'Existující účet na této wiki:',
	'openidchoosepassword' => 'heslo:',
	'openidconvertinstructions' => 'Tento formulář vám umožňuje změnit váš učet, aby používal OpenID URL.',
	'openidconvertsuccess' => 'Úspěšně převedeno na OpenID',
	'openidconvertsuccesstext' => 'Úspěšně jste převedli váš OpenID na $1.',
	'openidconvertyourstext' => 'To už je váš OpenID.',
	'openidconvertothertext' => 'To je OpenID někoho jiného.',
	'openidalreadyloggedin' => "'''Už jste přihlášený, $1!'''

Pokud chcete pro přihlašování v budoucnu používat OpenID, můžete [[Special:OpenIDConvert|převést váš účet na OpenID]].",
	'tog-hideopenid' => 'Nezobrazovat váš <a href="http://openid.net/">OpenID</a> na vaší uživatelské stránce pokud se přihlašujete pomocí OpenID.',
	'openidnousername' => 'Nebylo zadáno uživatelské jméno.',
	'openidbadusername' => 'Bylo zadáno chybné uživatelské jméno.',
	'openidautosubmit' => 'Tato stránka obsahuje formulář, který by měl být automaticky odeslán pokud máte zapnutý JavaScript.
Pokud ne, zkuste tlačátko „Pokračovat“.',
	'openidclientonlytext' => 'Nemůžete používat účty z této wiki jako OpenID na jinýh webech.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => "{{SITENAME}} podporuje standard [http://openid.net/ OpenID] pro sjednocené přihlašování na webové stránky.
OpenID vám umožňuje přihlašovat se na množství různých webových stránek bez nutnosti používat pro každou jiné heslo. (Přečtěte si [http://en.wikipedia.org/wiki/OpenID článek o OpenID na Wikipedii])

Pokud už máte na {{GRAMMAR:6sg|{{SITENAME}}}} učet, můžete se [[Special:UserLogin|přihlásit]] pomocí uživatelského jména a heslo jako obvykle. Pokud chcete v budoucnosti pouívat OpenID, můžete po normálním přihlášení [[Special:OpenIDConvert|převést svůj účet na OpenID]].

Existuje množství [http://wiki.openid.net/Public_OpenID_providers veřejných poskytovatelů OpenID] a možná už máte učet s podporou OpenID u jiného poskytovatele.

; Jiné wiki: Pokud máte účet na wiki s podporou OpenID, jako např. [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] nebo [http://kei.ki/ Keiki], můžete se přihlásit na {{GRAMMAR:4sg|{{SITENAME}}}}
; [http://openid.yahoo.com/ Yahoo!]: Pokud máte učet Yahoo!, můžete se na tuto wiki přihlásit zadáním vašeho OpenID, které poskytuje Yahoo!, do pole výše. Yahoo! OpenID URL bývají ve tvaru ''<nowiki>https://me.yahoo.com/uzivatelskejmeno</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL]: Pokud máte účet [http://www.aol.com/ AOL], jako například účet [http://www.aim.com/ AIM], můžete se přihlásit na {{GRAMMAR:4sg|{{SITENAME}}}} zadáním vaeho OpenID, které poskytuje AOL, do pole výše. AOL OpenID URL bývají ve tvaru ''<nowiki>http://openid.aol.com/uzivatelskejmeno</nowiki>''. Vaše uživatelské jméno by mělo mít jen malá písmena a žádné mezery.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox]: Pokud máte blog na některé z této služeb, zadejte do pole výše URL svého blogu. Například ''<nowiki>http://uzivatelskejmeno.blogspot.com/</nowiki>'', ''<nowiki>http://uzivatelskejmeno.wordpress.com/</nowiki>'', ''<nowiki>http://uzivatelskejmeno.livejournal.com/</nowiki>'' nebo ''<nowiki>http://uzivatelskejmeno.vox.com/</nowiki>''.",
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
 * @author Leithian
 */
$messages['de'] = array(
	'openid-desc' => 'Anmeldung an dieses Wiki mit einer [http://openid.net/ OpenID] und anmelden an anderen Websites, die OpenID unterstützen, mit einem Wiki-Benutzerkonto.',
	'openidlogin' => 'Anmelden mit OpenID',
	'openidfinish' => 'OpenID-Anmeldung abschließen',
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
	'openidnotavailable' => 'Dein bevorzugter Benutzername ($1) wird bereits von einem anderen Benutzer verwendet.',
	'openidnotprovided' => 'Dein OpenID-Server unterstützt keine Nicknamen (entweder, weil er es nicht kann, oder weil du es ihm nicht erlaubst hast).',
	'openidchooseinstructions' => 'Alle Benutzer benötigen einen Benutzernamen;
du kannst einen aus der untenstehenden Liste auswählen.',
	'openidchoosefull' => 'Dein vollständiger Name ($1)',
	'openidchooseurl' => 'Ein Name aus deiner OpenID ($1)',
	'openidchooseauto' => 'Ein automatisch erzeugter Name ($1)',
	'openidchoosemanual' => 'Ein Name deiner Wahl:',
	'openidchooseexisting' => 'Ein existierendes Benutzerkonto in diesem Wiki:',
	'openidchoosepassword' => 'Passwort:',
	'openidconvertinstructions' => 'Mit diesem Formular kannst du dein Benutzerkonto zur Benutzung einer OpenID-URL freigeben.',
	'openidconvertsuccess' => 'Erfolgreich nach OpenID konvertiert',
	'openidconvertsuccesstext' => 'Du hast die Konvertierung deiner OpenID nach $1 erfolgreich durchgeführt.',
	'openidconvertyourstext' => 'Dies ist bereits deine OpenID.',
	'openidconvertothertext' => 'Dies ist die OpenID von jemand anderem.',
	'openidalreadyloggedin' => "'''Du bist bereits angemeldet, $1!'''

Wenn du OpenID für künftige Anmeldevorgänge nutzen möchtest, kannst du [[Special:OpenIDConvert|dein Benutzerkonto nach OpenID konvertieren]].",
	'tog-hideopenid' => 'Verstecke deine <a href="http://openid.net/">OpenID</a> auf deiner Benutzerseite, wenn du dich mit OpenID anmeldest.',
	'openidnousername' => 'Kein Benutzername angegeben.',
	'openidbadusername' => 'Falscher Benutzername angegeben.',
	'openidautosubmit' => 'Diese Seite enthält ein Formular, das automatisch übertragen wird, wenn JavaSkript aktiviert ist. Falls nicht, klicke bitte auf „Weiter“.',
	'openidclientonlytext' => 'Du kannst keine Benutzerkonten aus diesem Wiki als OpenID für andere Seiten verwenden.',
	'openidloginlabel' => 'OpenID-URL',
	'openidlogininstructions' => "{{SITENAME}} unterstützt den [http://openid.net/ OpenID]-Standard für ein Login für mehrere Websites.
OpenID meldet dich bei vielen unterschiedlichen Webseiten an, ohne dass du für jede ein anderes Passwort verwenden musst.
(Mehr Informationen bietet der [http://de.wikipedia.org/wiki/OpenID Wikipedia-Artikel zu OpenID].)

Falls du bereits ein Benutzerkonto bei {{SITENAME}} hast, kannst du dich ganz normal mit Benutzername und Passwort [[Special:UserLogin|anmelden]].
Wenn du in Zukunft OpenID verwenden möchtest, kannst du [[Special:OpenIDConvert|deinen Account zu OpenID konvertieren]], nachdem du dich normal eingeloggt hast.

Es gibt viele [http://wiki.openid.net/Public_OpenID_providers öffentliche OpenID-Provider] und möglicherweise hast du bereits ein Benutzerkonto mit aktiviertem OpenID bei einem anderen Anbieter.

; Andere Sites: Wenn du bereits ein Benutzerkonto auf einem Wiki mit aktiviertem OpenID hast, wie beispielsweise [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] oder [http://kei.ki/ Keiki], kannst du dich bei {{SITENAME}} anmelden, indem du die '''komplette URL''' deiner Benutzerseite auf dem anderen Wiki in das obige Textfeld eingibst. Beispielsweise ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!]: Wenn du ein Yahoo!-Konto hast, kannst du dich mit der von Yahoo! angegebenen OpenID im obigen Textfeld anmelden. Yahoo!-OpenIDs haben die Form ''<nowiki>https://me.yahoo.com/deinbenutzername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL]: Wenn du ein [http://www.aol.com/ AOL]-Konto hast, beispielsweise ein [http://www.aim.com/ AIM]-Benutzerkonto, kannst du dich bei {{SITENAME}} anmelden, indem du die von AOL angegebene OpenID im obigen Textfeld eingibst. AOL-OpenIDs haben die Form ''<nowiki>http://openid.aol.com/deinbenutzername</nowiki>''. Dein Benutzername sollte nur aus kleinen Buchstaben bestehen und keine Leerzeichen enthalten.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox]: Wenn du auf diesen Seiten ein Blog hast, gib die URL deines Blogs in das obige Textfeld ein. Beispielsweise ''<nowiki>http://deinbenutzername.blogspot.com/</nowiki>'', ''<nowiki>http://deinbenutzername.wordpress.com/</nowiki>'', ''<nowiki>http://deinbenutzername.livejournal.com/</nowiki>'', oder ''<nowiki>http://deinbenutzername.vox.com/</nowiki>''.",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'openid-desc' => 'Pśizjawjenje pla wikija z [http://openid.net/ OpenID] a pśizjawjenje pla drugich websedłow, kótarež pódpěraju OpenID z wikijowym wužywarskim kontom',
	'openidlogin' => 'Pśizjawjenje z OpenID',
	'openidfinish' => 'Pśizjawjenje OpenID dokóńcyś',
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
	'openidnotavailable' => 'Twójo preferěrowane pśimě ($1) se južo wužywa wót drugego wužywarja.',
	'openidnotprovided' => 'Twój server OpenID njejo dodał pśimě (pak, dokulaž njamóžo, pak, dokulaž njejsy jo jomu k wěsći dał).',
	'openidchooseinstructions' => 'Wše wužywarje trjebaju pśimě;
móžoš jadne ze slědujucych opcijow wubraś.',
	'openidchoosefull' => 'Twójo dopołne mě ($1)',
	'openidchooseurl' => 'Mě z twójogo OpenID ($1)',
	'openidchooseauto' => 'Awtomatiski napórane mě ($1)',
	'openidchoosemanual' => 'Mě twójogo wuzwólenja:',
	'openidchooseexisting' => 'Eksistěrujuce konto w toś tom wikiju:',
	'openidchoosepassword' => 'gronidło:',
	'openidconvertinstructions' => 'Z toś tym formularom móžoš swójo wužywarske konto změniś, aby wužywało URL OpenID.',
	'openidconvertsuccess' => 'Wuspěšnje do OpenID konwertěrowany',
	'openidconvertsuccesstext' => 'Sy wuspěšnje konwertěrował twój OpenID do $1.',
	'openidconvertyourstext' => 'To jo južo twój OpenID.',
	'openidconvertothertext' => 'Toś ten OpenID słuša někomu drugemu.',
	'openidalreadyloggedin' => "'''Sy južo pśizjawjony, $1!'''

Jolic pśichodnje coš OpenID wužywaś, aby se pśizjawił, móžoš [[Special:OpenIDConvert|swójo konto za wužiwanje OpenID konwertěrowaś]].",
	'tog-hideopenid' => 'Schowaj swój <a href="http://openid.net/">OpenID</a> na swójom wužywarskem boku, jolic se pśizjawjaś z OpenID.',
	'openidnousername' => 'Žedne wužywarske mě pódane.',
	'openidbadusername' => 'Wopacne wužywarske mě pódane.',
	'openidautosubmit' => 'Toś ten bok wopśimujo formular, kótaryž se awtmatiski wótpósćeła, jolic JavaScript jo zmóžnjony. Jolic nic, klikni na tłocašk "Dalej".',
	'openidclientonlytext' => 'Njamóžoš konta z toś togo wikija ako OpneID na drugem sedle wužywaś.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => "{{SITENAME}} pódpěra standard [http://openid.net/ OpenID] za jadnotliwe pśizjawjenje mjazy websedłami.
OpenID śi zmóžnja se do wjele rozdźělnych websedłow pśizawiś, mimo až musyš za kužde websedło druge gornidło wužywaś.
(Glědaj [http://de.wikipedia.org/wiki/OpenID nastawk wó OpenID we Wikipediji] za dalšne informacije.)

Jolic maš južo konto na {{GRAMMAR:lokatiw|{{SITENAME}}}}, móžoš se ze swójim wužywarskim mjenim a gronidłom ako pśecej [[Special:UserLogin|pśizjawiś]].
Aby pśichodnje wužywał OpenID, móžoš [[Special:OpenIDConvert|swójo konto do OpenID konwertěrowaś]], za tym až sy se normalnje pśizjawił.

Jo wjele [http://wiki.openid.net/Public_OpenID_providers zjawnych póbitowarjow OpenID] a snaź maš južo konto z OpenID pla drugeje słužby.

; Druge wikije: Jolic maš konto na wikiju z OpenID, kaž [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] ab [http://kei.ki/ Keiki], móžoš se pla {{GRAMMAR:genitiw|{{SITENAME}}}} pśizjawiś, z tym až zapódaš '''dopołny URL''' swójogo wužywarskego boka na tom drugem wikiju górjejce w kašćiku. Na pśikład, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!]: Jolic maš konto pla Yahoo!, móžoš se pla toś togo sedła pśizjawiś, z tym až zapódaš OpenID, kótaryž sy dostał wót Yahoo górjejce w kašćiku. URL OpenID wót Yahoo! maju formu ''<nowiki>https://me.yahoo.com/twójowužywarske mě</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL]: Jolic maš konto pla [http://www.aol.com/ AOL], kaž na pśikład konto [http://www.aim.com/ AIM], móžoš se pla {{GRAMMAR:lokatiw|{{SITENAME}}}} pśizjawiś, z tym až zapódaš OpenId, kótaryž sy dostał wót AOL, górjejce w kašćiki. URL OpenID wót AOL maju formu ''<nowiki>http://openid.aol.com/twójowužywarskemě</nowiki>''. Twójo wužywarske mě by měło jano małe pismiki wopśimjeś, ale žedne prozne znamjenja.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox]: Jolic maš blog na jadnej z toś tych słužbow, zapódaj swój blogowy URL górjejce w kašćiku. Na pśikład, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'' abo ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'openidlanguage' => 'Γλώσσα',
	'openidchoosemanual' => 'Ένα όνομα της επιλογής σας:',
	'openidchoosepassword' => 'κωδικός:',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'openid-desc' => 'Ensaluti la vikion kun [http://openid.net/ identigo OpenID], kaj ensaluti aliajn retejon uzantajn OpenID kun vikia uzula konto',
	'openidlogin' => 'Ensaluti kun OpenID',
	'openidfinish' => 'Elsaluti kun OpenID',
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
	'openidnopolicy' => 'Retejo ne specifigis regularon pri privateco.',
	'openidpolicy' => 'Kontroli la <a target="_new" href="$1">regularon pri privateco</a> pri plua informo.',
	'openidoptional' => 'Nedeviga',
	'openidrequired' => 'Deviga',
	'openidnickname' => 'Kaŝnomo',
	'openidfullname' => 'Plena nomo',
	'openidemail' => 'Retadreso',
	'openidlanguage' => 'Lingvo',
	'openidnotavailable' => 'Via preferata kromnomo ($1) jam estas uzata de alia uzanto.',
	'openidnotprovided' => 'Via OpenID-a servilo ne provizis kromnomo (ĉar aŭ ĝi ne eblis, aŭ tial vi malpermesigis ĝin).',
	'openidchooseinstructions' => 'Ĉiuj uzantoj bezonas kromnomo;
vi povas selekti el unu la jenaj opcioj.',
	'openidchoosefull' => 'Via plena nomo ($1)',
	'openidchooseurl' => 'Nomo eltenita de via OpenID ($1)',
	'openidchooseauto' => 'Automate generita nomo ($1)',
	'openidchoosemanual' => 'Nomo de via elekto:',
	'openidchooseexisting' => 'Ekzistanta konto en ĉi tiu vikio:',
	'openidchoosepassword' => 'pasvorto:',
	'openidconvertinstructions' => 'Ĉi tiu paĝo permesas al vi ŝanĝi vian uzulan konton por uzi URL-on OpenID.',
	'openidconvertsuccess' => 'Sukcese konvertis al OpenID',
	'openidconvertsuccesstext' => 'Vi sukcese konvertis vian identigon OpenID al $1.',
	'openidconvertyourstext' => 'Tio jam estas via OpenID.',
	'openidconvertothertext' => 'Tio estas OpenID de alia persono.',
	'openidalreadyloggedin' => "'''Vi jam ensalutis, $1!'''

Se vi volas utiligi OpenID por ensaluti estontece, vi povas [[Special:OpenIDConvert|konverti vian konton por uzi OpenID]].",
	'tog-hideopenid' => 'Kaŝi viajn identigon <a href="http://openid.net/">OpenID</a> en via uzula paĝo, se vi ensalutas kun OpenID.',
	'openidnousername' => 'Neniu salutnomo estis donita.',
	'openidbadusername' => 'Fuŝa salutnomo donita.',
	'openidautosubmit' => 'Ĉi tiu paĝo inkluzivas kamparo kiu estos aŭtomate enigita se vi havas JavaScript-on ŝaltan.
Se ne, klaku la butonon \\"Daŭri\\".',
	'openidclientonlytext' => 'Vi ne povas uzi kontojn de ĉi tiu vikio kiel OpenID-ojn en alia retejo.',
	'openidloginlabel' => 'URL-o OpenID',
);

/** Spanish (Español)
 * @author Imre
 * @author Sanbec
 */
$messages['es'] = array(
	'openidoptional' => 'Opcional',
	'openidrequired' => 'Necesario',
	'openidemail' => 'Dirección de correo electrónico',
	'openidlanguage' => 'Idioma',
	'openidchoosepassword' => 'contraseña:',
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
	'openidnotavailable' => 'Sinu eelistatud hüüdnimi ($1) on juba kasutuses.',
	'openidchoosefull' => 'Sinu täisnimi ($1)',
	'openidchoosemanual' => 'Sinu valitud nimi:',
	'openidchooseexisting' => 'Olemasolev konto siin vikis:',
	'openidchoosepassword' => 'parool:',
	'openidconvertyourstext' => 'See on juba Sinu avatud ID.',
	'openidconvertothertext' => 'See on kellegi teise avatud ID.',
	'openidalreadyloggedin' => "'''Sa oled juba sisse logitud, $1!'''

Kui soovid kasutada avatud ID-d tulevikus sisselogimiseks, võid [[Special:OpenIDConvert|konvertida oma konto, kasutamaks avatud ID-d]].",
);

/** Basque (Euskara)
 * @author Theklan
 */
$messages['eu'] = array(
	'openidoptional' => 'Aukerazkoa',
	'openidrequired' => 'Nahitaezkoa',
	'openidnickname' => 'Ezizena',
	'openidfullname' => 'Izen osoa',
	'openidemail' => 'E-posta helbidea',
	'openidlanguage' => 'Hizkuntza',
	'openidnotavailable' => 'Nahi duzun ezizena ($1) beste lankide batek erabiltzen du jada.',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Mobe
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'openid-desc' => 'Kirjaudu wikiin [http://openid.net/ OpenID:llä] ja muille OpenID-tuetuille sivustoille wiki-käyttäjätilillä',
	'openidlogin' => 'Kirjaudu OpenID:llä',
	'openidfinish' => 'Lopeta OpenID-kirjautuminen',
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
	'openidnopolicy' => 'Sivusto ei ole määritellyt yksityisyyskäytäntöä.',
	'openidpolicy' => 'Lisää tietoa on <a target="_new" href="$1">yksityisyyskäytännöissä</a>.',
	'openidoptional' => 'Valinnainen',
	'openidrequired' => 'Vaadittu',
	'openidnickname' => 'Nimimerkki',
	'openidfullname' => 'Koko nimi',
	'openidemail' => 'Sähköpostiosoite',
	'openidlanguage' => 'Kieli',
	'openidnotavailable' => 'Toinen käyttäjä käyttää jo haluamaasi nimimerkkiä ($1).',
	'openidnotprovided' => 'OpenID-palvelimesi ei tarjoa nimimerkkiä (joko se ei osaa, tai olet kieltänyt sen).',
	'openidchooseinstructions' => 'Kaikki käyttäjät tarvitsevat nimimerkin.
Voit valita omasi alla olevista vaihtoehdoista.',
	'openidchoosefull' => 'Koko nimesi ($1)',
	'openidchooseurl' => 'OpenID:stäsi poimittu nimi ($1)',
	'openidchooseauto' => 'Automaattisesti luotu nimi ($1)',
	'openidchoosemanual' => 'Omavalintainen nimi',
	'openidchooseexisting' => 'Olemassa oleva tunnus tässä wikissä',
	'openidchoosepassword' => 'salasana:',
	'openidconvertinstructions' => 'Tällä lomakkeella voit muuttaa käyttäjätilisi käyttämään OpenID-osoitetta.',
	'openidconvertsuccess' => 'Muutettiin onnistuneesti OpenID:hen.',
	'openidconvertyourstext' => 'Tämä on jo OpenID:si.',
	'openidconvertothertext' => 'Tämä on jonkun muun OpenID.',
	'openidalreadyloggedin' => "'''Olet jo kirjautuneena sisään, $1!'''

Jos haluat käyttää OpenID:tä kirjautumiseen jatkossa, voit [[Special:OpenIDConvert|muuntaa tunnuksesi käyttämään OpenID:tä]].",
	'tog-hideopenid' => 'Piilota <a href="http://openid.net/">OpenID:si</a> käyttäjäsivultani, jos kirjaudun sisään OpenID-tunnuksilla.',
	'openidnousername' => 'Käyttäjätunnus puuttuu.',
	'openidbadusername' => 'Käyttäjätunnus on virheellinen.',
	'openidautosubmit' => 'Tämä sivu sisältää lomakkeen, joka lähettää itse itsensä, jos JavaScript käytössä.
Muussa tapauksessa valitse <code>Jatka</code>.',
	'openidclientonlytext' => 'Et voi käyttää tämän wikin käyttäjätunnuksia OpenID-tunnuksina muilla sivustoilla.',
	'openidloginlabel' => 'OpenID-URL',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Zetud
 */
$messages['fr'] = array(
	'openid-desc' => "Se connecter au wiki avec [http://openid.net/ OpenID] et se connecter à d'autres sites internet OpenID avec un compte utilisateur du wiki.",
	'openidlogin' => 'Se connecter avec OpenID',
	'openidfinish' => 'Finir la connection OpenID',
	'openidserver' => 'Serveur OpenID',
	'openidxrds' => 'Fichier Yadis',
	'openidconvert' => 'Convertisseur OpenID',
	'openiderror' => 'Erreur de vérification',
	'openiderrortext' => "Une erreur est intervenue pendant la vérification de l'adresse OpenID.",
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
	'openidnotavailable' => 'Votre surnom préféré ($1) est déjà utilisé par un autre utilisateur.',
	'openidnotprovided' => "Votre serveur OpenID n'a pas pu fournir un surnom (soit il ne le peut pas, soit vous lui avez demandé de ne pas le faire).",
	'openidchooseinstructions' => "Tous les utilisateurs ont besoin d'un surnom ; vous pouvez en choisir un à partir du choix ci-dessous.",
	'openidchoosefull' => 'Votre nom entier ($1)',
	'openidchooseurl' => 'Un nom a été choisi depuis votre OpenID ($1)',
	'openidchooseauto' => 'Un nom créé automatiquement ($1)',
	'openidchoosemanual' => 'Un nom de votre choix :',
	'openidchooseexisting' => 'Un compte existant sur ce wiki :',
	'openidchoosepassword' => 'Mot de passe :',
	'openidconvertinstructions' => 'Ce formulaire vous laisse changer votre compte utilisateur pour utiliser une adresse OpenID.',
	'openidconvertsuccess' => 'Converti avec succès vers OpenID',
	'openidconvertsuccesstext' => 'Vous avez converti avec succès votre OpenID vers $1.',
	'openidconvertyourstext' => 'C’est déjà votre OpenID.',
	'openidconvertothertext' => "Ceci est l'OpenID de quelqu'un d'autre.",
	'openidalreadyloggedin' => "'''Vous êtes déjà connecté, $1 !'''

Vous vous désirez utiliser votre OpenID pour vous connecter ultérieurement, vous pouvez [[Special:OpenIDConvert|convertir votre compte pour utiliser OpenID]].",
	'tog-hideopenid' => 'Cache votre <a href="http://openid.net/">OpenID</a> sur votre page utilisateur, si vous vous connectez avec OpenID.',
	'openidnousername' => 'Aucun nom d’utilisateur n’a été indiqué.',
	'openidbadusername' => 'Un mauvais nom d’utilisatteur a été indiqué.',
	'openidautosubmit' => 'Cette page comprend un formulaire qui pourrait être envoyé automatiquement si vous avez activé JavaScript.
Si tel n’était pas le cas, essayez le bouton « Continuer ».',
	'openidclientonlytext' => 'Vous ne pouvez utiliser des comptes depuis ce wiki en tant qu’OpenID sur d’autres sites.',
	'openidloginlabel' => 'Adresse OpenID',
	'openidlogininstructions' => "{{SITENAME}} supporte le format [http://openid.net/ OpenID] pour une seule signature entre des sites Internet.
OpenID vous permet de vous connecter sur plusieurs sites différents sans à avoir à utiliser un mot de passe différent pour chacun d’entre eux.

Si vous avez déjà un compte sur {{SITENAME}}, vous pouvez vous [[Special:UserLogin|connecter]] avec votre nom d'utilisateur et son mot de pas comme d’habitude. Pour utiliser OpenID, à l’avenir, vous pouvez [[Special:OpenIDConvert|convertir votre compte en OpenID]] après que vous vous soyez connecté normallement.

Il existe plusieurs [http://wiki.openid.net/Public_OpenID_providers fournisseur d'OpenID publiques], et vous pouvez déjà obtenir un compte OpenID activé sur un autre service.

; Autres wiki : si vous avez avec un wiki avec OpenID activé, tel que [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] ou encore [http://kei.ki/ Keiki], vous pouvez vous connecter sur {{SITENAME}} en entrant '''l’adresse internet complète'' de votre page de cet autre wiki dans la boîte ci-dessus. Par exemple : ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Si vous avez un compte avec Yahoo! , vous pouvez vous connecter sur ce site en entrant votre OpenID Yahoo! fournie dans la boîte ci-dessous. Les adresses OpenID doivent avoir la syntaxe ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : si vous avec un compte avec [http://www.aol.com/ AOL], tel qu'un compte [http://www.aim.com/ AIM], vous pouvez vous connecter sur {{SITENAME}} en entrant votre OpenID fournie par AOL dans la boîte ci-dessous. Les adresses OpenID doivent avoir le format ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Votre nom d’utilisateur doit être entièrement en lettres minuscules avec aucun espace.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Si vous avec un blog ou un autre de ces services, entrez l’adresse de votre blog dans la boîte ci-dessous. Par exemple, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', ou encore ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
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
	'openidfinish' => 'Saír do sistema OpenID',
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
	'openidnotavailable' => 'O seu alcume preferido ($1) xa está sendo usado por outro usuario.',
	'openidnotprovided' => 'O servidor do seu OpenID non proporcionou un alcume (porque non pode ou porque vostede lle dixo que non o fixera).',
	'openidchooseinstructions' => 'Todos os usuarios precisan un alcume; pode escoller un de entre as opcións de embaixo.',
	'openidchoosefull' => 'O seu nome completo ($1)',
	'openidchooseurl' => 'Un nome tomado do seu OpenID ($1)',
	'openidchooseauto' => 'Un nome autoxerado ($1)',
	'openidchoosemanual' => 'Un nome da súa escolla:',
	'openidchooseexisting' => 'Unha conta existente neste wiki:',
	'openidchoosepassword' => 'contrasinal:',
	'openidconvertinstructions' => 'Este formulario permítelle cambiar a súa conta de usuario para usar un enderezo URL de OpenID.',
	'openidconvertsuccess' => 'Convertiuse con éxito a OpenID',
	'openidconvertsuccesstext' => 'Converteu con éxito o seu OpenID a $1.',
	'openidconvertyourstext' => 'Ese xa é o seu OpenID.',
	'openidconvertothertext' => 'Ese é o OpenID de alguén.',
	'openidalreadyloggedin' => "'''Está dentro do sistema, $1!'''

Se quere usar OpenID para acceder ao sistema no futuro, pode [[Special:OpenIDConvert|converter a súa conta para usar OpenID]].",
	'tog-hideopenid' => 'Agoche o seu <a href="http://openid.net/">OpenID</a> na súa páxina de usuario, se accede ao sistema con OpenID.',
	'openidnousername' => 'Non foi especificado ningún nome de usuario.',
	'openidbadusername' => 'O nome de usuario especificado é incorrecto.',
	'openidautosubmit' => 'Esta páxina inclúe un formulario que debería ser enviado automaticamente se ten o JavaScript permitido.
Se non é así, probe a premer no botón \\"Continuar\\".',
	'openidclientonlytext' => 'Non pode usar contas deste wiki como OpenIDs noutro sitio.',
	'openidloginlabel' => 'Dirección URL do OpenID',
	'openidlogininstructions' => "{{SITENAME}} soporta o [http://openid.net/ OpenID] estándar para unha soa sinatura entre os sitios web.
OpenID permítelle rexistrarse en diferentes sitios web sen usar un contrasinal diferente para cada un.
(Consulte o [http://en.wikipedia.org/wiki/OpenID artigo sobre o OpenID na Wikipedia en inglés] para máis información.)

Se xa ten unha conta en {{SITENAME}}, pode [[Special:UserLogin|acceder ao sistema]] co seu nome de usuario e contrasinal como o fai habitualmente.
Para usar o OpenID no futuro, pode [[Special:OpenIDConvert|converter a súa conta en OpenID]] tras ter accedido ao sistema como fai normalmente.

Hai moitos [http://wiki.openid.net/Public_OpenID_providers proveedores públicos de OpenID] e xa pode ter unha conta co OpenID permitido noutro servizo.

; Outros wikis : Se ten unha conta nun wiki co OpenID permitido, como [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] ou [http://kei.ki/ Keiki], pode acceder ao sistema de {{SITENAME}}  tecleando o '''URL completo''' da súa páxina de usuario nesoutro wiki na caixa de enriba. Por exemplo, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Se ten unha conta no Yahoo!, pode acceder ao sistema deste sitio tecleando o seu OpenID de Yahoo! proporcionado na caixa de enriba. Os URLs do Yahoo! para os OpenID son da seguinte maneira: ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Se ten unha conta con [http://www.aol.com/ AOL], como unha conta [http://www.aim.com/ AIM], pode acceder ao sistema de {{SITENAME}} tecleando o seu OpenID proporcionado polo AOL na caixa de enriba. Os URLs do AOL para os OpenID son da seguinte maneira: ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. O seu nome de usuario debe estar en letras minúsculas e escrito sen espazos.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provicoder.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Se ten un blogue nalgún destes servizos, teclee o URL do seu blogue na caixa de enriba. Por exemplo, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', ou ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'openidoptional' => 'Προαιρετικόν',
	'openidnickname' => 'Ψευδώνυμον',
	'openidemail' => 'Ἡλεκτρονικὴ διεύθυνσις',
	'openidlanguage' => 'Γλῶττα',
	'openidchoosepassword' => 'σύνθημα:',
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
	'openidfinish' => 'יציאה מהחשבון עם OpenID',
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
	'openidnotavailable' => 'הכינוי המועדף עליכם ($1) כבר נמצא בשימוש של משתמש אחר.',
	'openidnotprovided' => 'שרת ה־OpenID לא סיפק כינוי (או בגלל שאינו יכול, או בגלל שכך הוריתם לו).',
	'openidchooseinstructions' => 'כל המשתמשים זקוקים לכינוי;
תוכלו לבחור אחת מהאפשרויות שלהלן.',
	'openidchoosefull' => 'שמכם המלא ($1)',
	'openidchooseurl' => 'שם שנבחר מה־OpenID שלכם ($1)',
	'openidchooseauto' => 'שם שנוצר אוטומטית ($1)',
	'openidchoosemanual' => 'השם הנבחר:',
	'openidchooseexisting' => 'חשבון קיים בוויקי זה:',
	'openidchoosepassword' => 'סיסמה:',
	'openidconvertinstructions' => 'טופס זה מאפשר לכם לשנות את חשבון המשתמשים שלכם לשימוש בכתובת OpenID.',
	'openidconvertsuccess' => 'הומר בהצלחה ל־OpenID',
	'openidconvertsuccesstext' => 'המרתם בהצלחה את ה־OpenID שלכם ל־$1.',
	'openidconvertyourstext' => 'זהו כבר ה־OpenID שלכם.',
	'openidconvertothertext' => 'זהו ה־OpenID של מישהו אחר.',
	'openidalreadyloggedin' => "'''הינכם כבר מחוברים לחשבון, $1!'''

אם ברצונכם להשתמש ב־OpenID כדי להתחבר בעתיד, תוכלו [[Special:OpenIDConvert|להמיר את חשבונכם לשימוש ב־OpenID]].",
	'tog-hideopenid' => 'הסתרת ה־<a href="http://openid.net/">OpenID</a> מדף המשתמש, במקרה של כניסה לחשבון עם OpenID.',
	'openidnousername' => 'לא צוין שם משתמש.',
	'openidbadusername' => 'שם המשתמש שצוין אינו תקין.',
	'openidautosubmit' => 'דף זה מכיל טופס שאמור להשלח אוטומטית אם יש לכם JavaScript פעיל.
אם זה לא פועל, נסו את הכפתור \\"המשך\\".',
	'openidclientonlytext' => 'אינכם יכולים להשתמש בחשבונות משתמש מוויקי זה כזהויות OpenID באתר אחר.',
	'openidloginlabel' => 'כתובת OpenID',
	'openidlogininstructions' => "ב{{grammar:תחילית|{{SITENAME}}}} מותקנת תמיכה בתקן ה־[http://openid.net/ OpenID] לחשבון משתמש מאוחד בין אתרי אינטרנט.
OpenID מאפשר לכם להיכנס לחשבון במגוון אתרים מבלי להשתמש בסיסמה שונה עבור כל אחד מהם.
(עיינו ב[http://he.wikipedia.org/wiki/OpenID ערך על OpenID בוויקיפדיה העברית] למידע נוסף.)

אם כבר יש ברשותכם חשבון במערכת {{SITENAME}}, תוכלו [[Special:UserLogin|להיכנס לחשבון]] עם שם המשתמש והסיסמה שלכם כרגיל.
על מנת להשתמש ב־OpenID בעתיד, תוכלו [[Special:OpenIDConvert|להמיר את חשבונכם ל־OpenID]] לאחר שנכנסתם לחשבון באופן הרגיל.

ישנם [http://wiki.openid.net/Public_OpenID_providers ספקי OpenID ציבוריים] רבים, ויתכן שכבר יש לכם חשבון התומך ב־OpenID בשירות אחר.

; אתרי ויקי אחרים : אם יש לכם חשבון באתר ויקי התומך ב־OpenID, כגון [http://wikitravel.org/he ויקיטיול], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] או [http://kei.ki/ Keiki], תוכלו להיכנס לחשבון ב{{grammar:תחילית|{{SITENAME}}}} על ידי כתיבת '''הכתובת המלאה''' של דף המשתמש שלכם באתר הוויקי האחר בתיבה שלהלן. לדוגמה, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : אם יש ברשותכם חשבון Yahoo!, תוכלו להיכנס לחשבון ב{{grammar:תחילית|{{SITENAME}}}} על ידי כתיבת ה־OpenID שסופק על ידי Yahoo! בתיבה שלהלן. כתובות OpenID של Yahoo! הינן בתבנית ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : אם יש ברשותכם חשבון אצל [http://www.aol.com/ AOL], כגון חשבון [http://www.aim.com/ AIM], תוכלו להיכנס לחשבון ב{{grammar:תחילית|{{SITENAME}}}} על ידי כתיבת ה־OpenID שסופק לכם על ידי AOL בתיבה שלהלן. כתובת OpenID של AOL הינן בתבנית ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. על שם המשתמש שלכם להיות כולו באותיות קטנות באנגלית, ללא רווחים.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : אם אתם מנהלים בלוג באחד מהשירותים הללו, תוכלו להיכנס לחשבון ב{{grammar:תחילית|{{SITENAME}}}} על ידי כתיבת כתובת הבלוג שלכם בתיבה שלהלן. לדוגמה, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', או ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'openidlogin' => 'OpenID से लॉग इन करें',
	'openidfinish' => 'OpenID लॉग इन पूरा करें',
	'openidserver' => 'OpenID सर्वर',
	'openidxrds' => 'Yadis फ़ाइल',
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
	'tog-hideopenid' => 'अगर आपने ओपनID का इस्तेमाल करके लॉग इन किया हैं, तो आपके सदस्यपन्नेपर आपका <a href="http://openid.net/">ओपनID</a> छुपायें।',
	'openidnousername' => 'सदस्यनाम दिया नहीं हैं।',
	'openidbadusername' => 'गलत सदस्यनाम दिया हैं।',
	'openidclientonlytext' => 'इस विकिपर खोले गये खाते आप अन्य साइटपर ओपनID के तौर पर इस्तेमाल नहीं कर सकतें हैं।',
	'openidloginlabel' => 'ओपनID URL',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'openidchoosepassword' => 'kontra-senyas:',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'openidchoosepassword' => 'lozinka:',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'openid-desc' => 'Přizjewjenje pola wikija z [http://openid.net/ OpenID], a přizjewjenje pola druhich websydłow, kotrež OpenID podpěruja, z wikijowym wužiwarskim kontom',
	'openidlogin' => 'Přizjewjenje z OpenID',
	'openidfinish' => 'Přizjewjenje OpenID skónčić',
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
	'openidnotavailable' => 'Twoje preferowane přimjeno ($1) so hižo wot druheho wužiwarja wužiwa.',
	'openidnotprovided' => 'Twój serwer OpenID njedoda přimjeno (pak dokelž njemóže pak dokelž njejsy je jemu zdźělił).',
	'openidchooseinstructions' => 'Wšitcy wužiwarjo trjebaja přimjeno; móžěs jedne z opcijow deleka wuzwolić.',
	'openidchoosefull' => 'Twoje dospołne mjeno ($1)',
	'openidchooseurl' => 'Mjeno wzate z twojeho OpenID ($1)',
	'openidchooseauto' => 'Awtomatisce wutworjene mjeno ($1)',
	'openidchoosemanual' => 'Mjeno twojeje wólby:',
	'openidchooseexisting' => 'Eksistowace konto na tutym wikiju:',
	'openidchoosepassword' => 'hesło:',
	'openidconvertinstructions' => 'Tutón formular ći dowola swoje wužiwarske konto zmňić, zo by URL OpenID wužiwał.',
	'openidconvertsuccess' => 'Wuspěšnje do OpenID konwertowany.',
	'openidconvertsuccesstext' => 'Sy swój OpenID wuspěšnje do $1 konwertował.',
	'openidconvertyourstext' => 'To je hižo twój OpenID.',
	'openidconvertothertext' => 'To je OpenID někoho druheho.',
	'openidalreadyloggedin' => "'''Sy hižo přizjewjeny, $1!'''

Jeli chceš OpenID wužiwać, hdyž přichodnje přizjewiš, móžeš [[Special:OpenIDConvert|swoje konto za wužiwanje OpenID konwertować]].",
	'tog-hideopenid' => 'Twój <a href="http://openid.net/">OpenID</a> na twojej wužiwarskej stronje schować, jeli so z OpenID přizjewješ.',
	'openidnousername' => 'Žane wužiwarske mjeno podate.',
	'openidbadusername' => 'Wopačne wužiwarske mjeno podate.',
	'openidautosubmit' => 'Tuta strona wobsahuje formular, kotryž měł so awtomatisce wotpósłać, jeli sy JavaScript zmóžnił. Jeli nic, spytaj tłóčatko "Dale".',
	'openidclientonlytext' => 'Njemóžeš konta z tutoho wikija jako OpenID na druhim sydle wužiwać.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => 'Zapodaj swój identifikator OpenID, zo by so přizjewił:',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Tgr
 */
$messages['hu'] = array(
	'openid-desc' => 'Bejelentkezés [http://openid.net/ OpenID] azonosítóval, és más OpenID-kompatibilis weboldalak használata a wikis azonosítóval',
	'openidlogin' => 'Bejelentkezés OpenID-vel',
	'openidfinish' => 'OpenID bejelentkezés befejezése',
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
	'openidoptional' => 'Opcionális',
	'openidrequired' => 'Kötelező',
	'openidnickname' => 'Felhasználónév',
	'openidfullname' => 'Teljes név',
	'openidemail' => 'Email-cím',
	'openidlanguage' => 'Nyelv',
	'openidnotavailable' => 'Az alapértelmezett felhasználónevedet ($1) már használja valaki.',
	'openidnotprovided' => 'Az OpenID szervered nem adta meg a felhasználónevedet (vagy azért, mert nem tudja, vagy mert nem engedted neki).',
	'openidchooseinstructions' => 'Mindenkinek választania kell egy felhasználónevet; választhatsz egyet az alábbi opciókból.',
	'openidchoosefull' => 'A teljes neved ($1)',
	'openidchooseurl' => 'Az OpenID-dből vett név ($1)',
	'openidchooseauto' => 'Egy automatikusan generált név ($1)',
	'openidchoosemanual' => 'Egy általad megadott név:',
	'openidchooseexisting' => 'Egy létező felhasználónév erről a wikiről:',
	'openidchoosepassword' => 'jelszó:',
	'openidconvertinstructions' => 'Ezzel az űrlappal átállíthatod a felhasználói fiókodat, hogy egy OpenId URL-t használjon.',
	'openidconvertsuccess' => 'Sikeres átállás OpenID-re',
	'openidconvertsuccesstext' => 'Sikeresen átállítottad az OpenID-det erre: $1.',
	'openidconvertyourstext' => 'Ez az OpenID már a tiéd.',
	'openidconvertothertext' => 'Ez az OpenID másvalakié.',
	'openidalreadyloggedin' => "'''Már be vagy jelentkezve, $1!'''

Ha ezentúl az OpenID-del akarsz bejelentkezni, [[Special:OpenIDConvert|konvertálhatod a felhasználói fiókodat OpenID-re]].",
	'tog-hideopenid' => 'Az <a href="http://openid.net/">OpenID</a>-d elrejtése a felhasználói lapodon, amikor OpenID-vel jelentkezel be.',
	'openidnousername' => 'Nem adtál meg felhasználónevet.',
	'openidbadusername' => 'Rossz felhasználónevet adtál meg.',
	'openidautosubmit' => 'Az ezen az oldalon lévő űrlap automatikusan elküldi az adatokat, ha a JavaScript engedélyezve van. Ha nem, használd a \\"Tovább\\" gombot.',
	'openidclientonlytext' => 'Az itteni felhasználónevedet nem használhatod OpenID-ként más weboldalon.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => "A(z) {{SITENAME}} támogatja az [http://openid.net/ OpenID]-alapú bejelentkezést.
A OpenID lehetővé teszi, hogy számos különböző weboldalra jelentkezz be úgy, hogy csak egyszer kell megadnod a jelszavadat. (Lásd [http://hu.wikipedia.org/wiki/OpenID a Wikipédia OpenID cikkét] további információkért.)

Ha már regisztráltál korábban, [[Special:UserLogin|bejelentkezhetsz]] a felhasználóneveddel és a jelszavaddal, ahogy eddig is. Ha a továbbiakban OpenID-t akarsz használni, [[Special:OpenIDConvert|állítsd át a felhasználói fiókodat OpenID-re]], miután bejelentkeztél.

Számos [http://wiki.openid.net/Public_OpenID_providers nyilvános OpenID szolgáltató] van, lehetséges, hogy van már OpenID-fiókod egy másik weboldalon.

; Más wikik: ha regisztráltál egy OpenID-kompatibilis wikin, mint a [http://wikitravel.org/ Wikitravel], a [http://www.wikihow.com/ wikiHow], a [http://vinismo.com/ Vinismo], az [http://aboutus.org/ AboutUs] vagy a [http://kei.ki/ Keiki], bejelentkezhetsz ide az ottani felhasználói lapod '''teljes címének''' megadásával. (Például ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.)
; [http://openid.yahoo.com/ Yahoo!] :  ha van Yahoo! azonosítód, bejelentkezhetsz a Yahoo! OpenID-d megadásával. A Yahoo! OpenID-k ''<nowiki>https://me.yahoo.com/felhasználónév</nowiki>'' alakúak.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Ha van valamilyen [http://www.aol.com/ AOL] azonosítód, például egy [http://www.aim.com/ AIM] felhasználónév, bejelentkezhetsz az AOL OpenID-del. Az AOL OpenID-k ''<nowiki>http://openid.aol.com/felhasználónév</nowiki>'' alakúak (a felhasználónév csupa kisbetűvel, szóköz nélkül).
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : ezek a blogszolgáltatók mind biztosítanak OpenID-t, a következő formákban: ''<nowiki>http://felhasználónév.blogspot.com/</nowiki>'', ''<nowiki>http://felhasználónév.wordpress.com/</nowiki>'', ''<nowiki>http://felhasználónév.livejournal.com/</nowiki>'', or ''<nowiki>http://felhasználónév.vox.com/</nowiki>''.",
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'openid-desc' => 'Aperir un session in le wiki con [http://openid.net/ OpenID], e aperir un session in altere sitos web usante OpenID con un conto de usator del wiki',
	'openidlogin' => 'Aperir un session con OpenID',
	'openidfinish' => 'Completar le session OpenID',
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
	'openidnotavailable' => 'Tu pseudonymo preferite ($1) ja es in uso per un altere usator.',
	'openidnotprovided' => 'Tu servitor OpenID non forniva un pseudonymo (o proque illo non lo pote, o proque tu lo diceva de non facer lo).',
	'openidchooseinstructions' => 'Tote le usatores require un pseudonymo;
tu pote seliger un del optiones in basso.',
	'openidchoosefull' => 'Tu nomine integre ($1)',
	'openidchooseurl' => 'Un nomine seligite de tu OpenID ($1)',
	'openidchooseauto' => 'Un nomine automaticamente generate ($1)',
	'openidchoosemanual' => 'Un nomine de tu preferentia:',
	'openidchooseexisting' => 'Un conto existente in iste wiki:',
	'openidchoosepassword' => 'contrasigno:',
	'openidconvertinstructions' => 'Iste formulario te permitte cambiar tu conto de usator pro usar un adresse URL de OpenID.',
	'openidconvertsuccess' => 'Conversion a OpenID succedite',
	'openidconvertsuccesstext' => 'Tu ha convertite con successo tu OpenID a $1.',
	'openidconvertyourstext' => 'Isto es ja tu OpenID.',
	'openidconvertothertext' => 'Isto es le OpenID de alcuno altere.',
	'openidalreadyloggedin' => "'''Tu es ja identificate, $1!'''

Si tu vole usar OpenID pro aperir un session in le futuro, tu pote [[Special:OpenIDConvert|converter tu conto pro usar OpenID]].",
	'tog-hideopenid' => 'Celar tu <a href="http://openid.net/">OpenID</a> in tu pagina de usator, si tu aperi un session con OpenID.',
	'openidnousername' => 'Nulle nomine de usator specificate.',
	'openidbadusername' => 'Mal nomine de usator specificate.',
	'openidautosubmit' => 'Iste pagina include un formulario que debe esser submittite automaticamente si tu ha JavaScript activate.
Si non, prova le button \\"Continuar\\".',
	'openidclientonlytext' => 'Tu non pote usar contos ab iste wiki como contos OpenID in un altere sito.',
	'openidloginlabel' => 'Adresse URL de OpenID',
	'openidlogininstructions' => "{{SITENAME}} supporta le standard [http://openid.net/ OpenID] pro contos unificate inter sitos web.
OpenID te permitte aperir un session in multe diverse sitos web sin usar un differente contrasigno pro cata un.
(Vide [http://ia.wikipedia.org/wiki/OpenID le articulo super OpenID in Wikipedia] pro plus informationes.)

Si tu possede ja un conto in {{SITENAME}}, tu pote [[Special:UserLogin|aperir un session]] con tu nomine de usator e contrasigno como normal.
Pro usar OpenID in le futuro, tu pote [[Special:OpenIDConvert|converter tu conto a OpenID]] post que tu ha aperite un session normal.

Il ha multe [http://wiki.openid.net/Public_OpenID_providers providitores de OpenID public], e tu pote ja disponer de un conto con capacitate OpenID in un altere servicio.

; Altere wikis : Si tu possede un conto in un wiki con capacitate OpenID, como [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] o [http://kei.ki/ Keiki], tu pote aperir un session a {{SITENAME}} per entrar le '''adresse URL complete''' de tu pagina de usator in ille altere wiki in le quadro supra. Per exemplo, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Si tu possede un conto a Yahoo!, tu pote aperir un session a iste sito per entrar tu OpenID fornite per Yahoo! in le quadro supra. Le adresses URL OpenID de Yahoo! ha le forma ''<nowiki>https://me.yahoo.com/tunominedeusator</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Si tu possede un conto a [http://www.aol.com/ AOL], como un conto de [http://www.aim.com/ AIM], tu pote aperir un session a {{SITENAME}} per entrar tu OpenID fornite per AOL in le quadro supra. Le adresses URL OpenID de AOL ha le forma ''<nowiki>http://openid.aol.com/tunominedeusator</nowiki>''. Tu nomine de usator debe esser toto in minusculas, sin spatios.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Si tu possede un blog in alcun de iste servicios, entra le adresse URL de tu blog in le quadro supra. Per exemplo, ''<nowiki>http://tunominedeusator.blogspot.com/</nowiki>'', ''<nowiki>http://tunominedeusator.wordpress.com/</nowiki>'', ''<nowiki>http://tunominedeusator.livejournal.com/</nowiki>'', o ''<nowiki>http://tunominedeusator.vox.com/</nowiki>''.",
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'openid-desc' => 'Masuk log ke wiki dengan sebuah [http://openid.net/ OpenID], dan masuk log ke situs web lain yang berbasis OpenID dengan sebuah akun pengguna wiki',
	'openidlogin' => 'Masuk log dengan OpenID',
	'openidfinish' => 'Selesai masuk log dengan OpenID',
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
	'openidemail' => 'Alamat surat-e',
	'openidlanguage' => 'Bahasa',
	'openidnotavailable' => 'Nama panggilan yang Anda masukkan ($1) sudah digunakan oleh pengguna lain.',
	'openidnotprovided' => 'Server OpenID Anda tidak menyediakan nama panggilan (entah karena server tersebut tidak bisa, atau Anda telah menspesifikasikan untuk tidak menyediakannya).',
	'openidchooseinstructions' => 'Semua pengguna memerlukan sebuah nama panggilan;
Anda dapat memilih dari salah satu opsi berikut.',
	'openidchoosefull' => 'Nama lengkap Anda ($1)',
	'openidchooseurl' => 'Sebuah nama diambil dari OpenID Anda ($1)',
	'openidchooseauto' => 'Nama yang dibuat secara otomatis ($1)',
	'openidchoosemanual' => 'Nama pilihan Anda:',
	'openidchooseexisting' => 'Akun telah ada di wiki ini:',
	'openidchoosepassword' => 'kata sandi:',
	'openidconvertinstructions' => 'Form ini mengizinkan Anda untuk mengubah akun pengguna Anda menjadi menggunakan sebuah URL OpenID.',
	'openidconvertsuccess' => 'Berhasil dikonversi menjadi OpenID',
	'openidconvertsuccesstext' => 'Anda telah berhasil mengkonversi OpenID Anda menjadi $1.',
	'openidconvertyourstext' => 'Sudah merupakan OpenID Anda.',
	'openidconvertothertext' => 'Itu adalah OpenID orang lain.',
	'openidalreadyloggedin' => "'''Anda telah masuk log, $1!'''

Jika Anda ingin menggunakan OpenID untuk masuk log di masa yang akan datang, Anda dapat [[Special:OpenIDConvert|mengkonversi akun Anda menjadi OpenID]].",
	'tog-hideopenid' => 'Sembunyikan <a href="http://openid.net/">OpenID</a> Anda di halaman pengguna Anda, jika Anda masuk log dengan OpenID.',
	'openidnousername' => 'Tidak ada nama pengguna diberikan.',
	'openidbadusername' => 'Nama pengguna salah.',
	'openidautosubmit' => 'Dalam halaman ini terdapat formulir yang akan dikirimkan secara otomatis jika Anda mengaktifkan JavaScript.
Jika tidak, coba tombol \\"Lanjutkan\\".',
	'openidclientonlytext' => 'Anda tidak dapat menggunakan akun dari wiki ini sebagai OpenID di situs lain.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => "{{SITENAME}} ini mendukung standar [http://openid.net/ OpenID] untuk masuk log lintas situs web.
OpenID mengizinkan Anda untuk masuk log di lintas situs web dengan menggunakan kata sandi yang sama.
(Lihat [http://id.wikipedia.org/wiki/OpenID artikel Wikipedia mengenai OpenID] untuk informasi lebih lanjut.)

Jika Anda telah memiliki akun di {{SITENAME}}, Anda dapat [[Special:UserLogin|masuk log]] dengan nama pengguna dan kata sandi Anda seperti biasa.
Untuk menggunakan OpenID di masa yang akan datang, Anda dapat [[Special:OpenIDConvert|mengkonversi akun Anda menjadi OpenID]] setelah Anda masuk log seperti biasa.

Ada banyak [http://wiki.openid.net/Public_OpenID_providers penyedia OpenID Publik], dan Anda mungkin telah memiliki akun OpenID di salah satu layanan situs lain.

; Wiki lain : Jika Anda memiliki akun di wiki lain dengan OpenID, seperti [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs], atau [http://kei.ki/ Keiki], Anda dapat masuk log ke {{SITENAME}} menggunakan '''URL lengkap''' dari halaman pengguna Anda di wiki lain tersebut di kotak di atas. Sebagai contoh, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Jika Anda memiliki akun di Yahoo!, Anda dapat masuk log di situs ini dengan menggunakan OpenID Yahoo! Anda di kotak di atas. URL OpenID Yahoo! memiliki format ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Jika Anda memiliki akun di [http://www.aol.com/ AOL], seperti akun [http://www.aim.com/ AIM], Anda dapat masuk log di {{SITENAME}} dengan menggunakan OpenID AOL Anda di kotak di atas. URL OpenID AOL memiliki format ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Nama pengguna Anda haruslah dalam huruf kecil semua dan tanpa spasi.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Jika Anda memiliki blog di situs-situs layanan ini, masukkan URL blog Anda di kotak di atas. Sebagai contoh, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', atau ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'openidchoosepassword' => 'lykilorð:',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author McDutchie
 * @author Nemo bis
 * @author Pietrodn
 */
$messages['it'] = array(
	'openid-desc' => 'Effettua il login alla wiki con [http://openid.net/ OpenID] e agli altri siti web che utilizzano OpenID con un account wiki',
	'openidlogin' => 'Login con OpenID',
	'openidfinish' => 'Completa il login OpenID',
	'openidserver' => 'server OpenID',
	'openidxrds' => 'file Yadis',
	'openidconvert' => 'convertitore OpenID',
	'openiderror' => 'Errore di verifica',
	'openiderrortext' => "Si è verificato un errore durante la verifica dell'URL OpenID.",
	'openidconfigerror' => 'Errore nella configurazione OpenID',
	'openidconfigerrortext' => 'La configurazione della memorizzazione di OpenID per questa wiki non è valida.
Per favore consulta un [[Special:ListUsers/sysop|amministratore]].',
	'openidpermission' => 'Errore nei permessi OpenID',
	'openidpermissiontext' => "Non è stato permesso di effettuare il login a questo server all'OpenID che hai fornito.",
	'openidcancel' => 'Verifica annullata',
	'openidcanceltext' => "La verifica dell'URL OpenID è stata annullata.",
	'openidfailure' => 'Verifica fallita',
	'openidfailuretext' => 'La verifica dell\'URL OpenID è fallita. Messaggio di errore: "$1"',
	'openidsuccess' => 'Verifica effettuata',
	'openidsuccesstext' => "La verifica dell'URL OpenID è stata effettuata con successo.",
	'openidusernameprefix' => 'Utente OpenID',
	'openidserverlogininstructions' => 'Inserisci di seguito la tua password per effettuare il login a $3 come utente $2 (pagina utente  $1).',
	'openidtrustinstructions' => 'Controlla se desideri condividere i dati con $1.',
	'openidallowtrust' => 'Permetti a $1 di fidarsi di questo account utente.',
	'openidnopolicy' => 'Il sito nono ha specificato una politica relativa alla privacy.',
	'openidpolicy' => 'Controlla la <a target="_new" href="$1">politica relativa alla privacy</a> per maggiori informazioni.',
	'openidoptional' => 'Opzionale',
	'openidrequired' => 'Richiesto',
	'openidnickname' => 'Nickname',
	'openidfullname' => 'Nome completo',
	'openidemail' => 'Indirizzo e-mail',
	'openidlanguage' => 'Lingua',
	'openidnotavailable' => 'Il tuo nickname preferito ($1) è già utilizzato da un altro utente.',
	'openidnotprovided' => 'Il tuo server OpenID non ha fornito un nickname (o perché non ha potuto o perché hai detto di non farlo).',
	'openidchooseinstructions' => 'Tutti gli utenti hanno bisogno di un nickname;
puoi sceglierne uno dalle opzioni seguenti.',
	'openidchoosefull' => 'Il tuo nome completo ($1)',
	'openidchooseurl' => 'Un nome scelto dal tuo OpenID ($1)',
	'openidchooseauto' => 'Un nome auto-generato ($1)',
	'openidchoosemanual' => 'Un nome di tua scelta:',
	'openidchooseexisting' => 'Un account esistente su questa wiki:',
	'openidchoosepassword' => 'password:',
	'openidconvertinstructions' => 'Questo modulo ti permette di cambiare il tuo account per usare un URL OpenID.',
	'openidconvertsuccess' => 'Convertito con successo a OpenID',
	'openidconvertsuccesstext' => 'Il tuo OpenID è stato convertito con successo a $1.',
	'openidconvertyourstext' => 'Questo è già il tuo OpenID.',
	'openidconvertothertext' => "Questo è l'OpenID di qualcun altro.",
	'openidalreadyloggedin' => "'''Hai già effettuato il login, $1!'''

Se desideri usare OpenID per effettuare il login in futuro, puoi [[Special:OpenIDConvert|convertire il tuo account per utilizzare OpenID]].",
	'tog-hideopenid' => 'Nascondi il tuo <a href="http://openid.net/">OpenID</a> sulla tua pagina utente, se effettui il login con OpenID.',
	'openidnousername' => 'Nessun nome utente specificato.',
	'openidbadusername' => 'Nome utente specificato errato.',
	'openidautosubmit' => 'Questa pagina include un modulo che dovrebbe essere inviato automaticamente se hai JavaScript attivato. Se non lo è, prova a premere il pulsante \\"Continue\\".',
	'openidclientonlytext' => 'Non puoi usare gli account di questa wiki come OpenID su un altro sito.',
	'openidloginlabel' => 'URL OpenID',
	'openidlogininstructions' => "{{SITENAME}} supporta lo standard [http://openid.net/ OpenID] per il login unico sui siti web.
OpenID ti permette di registrarti in molti siti web senza utilizzare una password diversa per ciascuno.
(Leggi la [http://en.wikipedia.org/wiki/OpenID voce di Wikipedia sull'OpenID] per maggiori informazioni.)

Se possiedi già un account su {{SITENAME}}, puoi effettuare il [[Special:UserLogin|login]] con il tuo nome utente e la tua password come al solito.
Per utilizzare OpenID in futuro, puoi [[Special:OpenIDConvert|convertire il tuo account a OpenID]] dopo che hai effettuato normalmente il login.

Esistono molti [http://wiki.openid.net/Public_OpenID_providers Provider OpenID pubblici], e potresti avere già un account abilitato all'OpenID su un altro servizio.

; Altre wiki : Se possiedi un account su una wiki abilitata all'OpenID, come [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] o [http://kei.ki/ Keiki], puoi effettuare il login a {{SITENAME}} inserendo l<nowiki>'</nowiki>'''URL completo''' della tua pagina utente in quell'altra wiki nel box soprastante. Per esempio, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Se possiedi un account con Yahoo!, puoi effettuare il login a questo sito inserendo il tuo OpenID Yahoo! nel box soprastante. Gli URL OpenID Yahoo! hanno la forma ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Se possiedi un account con [http://www.aol.com/ AOL], come un account [http://www.aim.com/ AIM], puoi effettuare il login a {{SITENAME}} inserendo il tuo OpenID AOL nel box soprastante. Gli URL OpenID AOL hanno la forma ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Il tuo nome utente dovrebbe essere tutto in carattere minuscolo, senza spazi.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Se possiedi un blog su uno di questi siti, inserisci l'URL del blog nel box soprastante. Per esempio, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', or ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Japanese (日本語)
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'openid-desc' => '[http://openid.net/ OpenID]によるウィキへのログインを可能にし、ウィキユーザーアカウントを他のOpenID対応サイトにログインすることを可能にする。',
	'openidlogin' => 'OpenIDでログイン',
	'openidfinish' => 'OpenIDでのログインが完了しました。',
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
	'openidoptional' => '任意',
	'openidrequired' => '必須',
	'openidnickname' => 'ニックネーム',
	'openidfullname' => 'フルネーム',
	'openidemail' => 'Eメールアドレス',
	'openidlanguage' => '言語',
	'openidnotavailable' => 'あなたが選んだニックネーム ($1) は既に他の利用者が使っています。',
	'openidnotprovided' => 'あなたの OpenID サーバーはニックネームを提供していません（提供できない場合と、提供しないようあなたが指示している場合とがあります）。',
	'openidchooseinstructions' => 'すべての利用者はニックネームが必要です。以下の選択肢から1つを選ぶことができます。',
	'openidchoosefull' => 'あなたのフルネーム ($1)',
	'openidchooseurl' => 'あなたの OpenID から選んだ名前 ($1)',
	'openidchooseauto' => '自動生成された名前 ($1)',
	'openidchoosemanual' => '名前を別に設定する:',
	'openidchooseexisting' => 'このウィキに存在するアカウント:',
	'openidchoosepassword' => 'パスワード:',
	'openidconvertinstructions' => 'このフォームを使うとあなたの利用者アカウントが OpenID URLを使うように変更できます。',
	'openidconvertsuccess' => 'OpenID への変換に成功しました',
	'openidconvertsuccesstext' => 'あなたは OpenID の $1 への変換に成功しました。',
	'openidconvertyourstext' => 'これは既にあなたの OpenID です。',
	'openidconvertothertext' => 'これは他の誰かの OpenID です。',
	'openidalreadyloggedin' => "'''$1 さん、あなたは既にログインしています!'''

将来は OpenID を使ってログインしたい場合は、[[Special:OpenIDConvert|あなたのアカウントを OpenID を使うように変換する]]ことができます。",
	'tog-hideopenid' => 'OpenID でログインしている場合に、あなたの <a href="http://openid.net/">OpenID</a> をあなたの利用者ページで表示しない。',
	'openidnousername' => '利用者名が指定されていません。',
	'openidbadusername' => '利用者名の指定が不正です。',
	'openidautosubmit' => 'このページにあるフォームはあなたが JavaScript を有効にしていれば自動的に送信されるはずです。そうならない場合は、「続ける」ボタンを試してください。',
	'openidclientonlytext' => 'あなたはこのウィキのアカウントを他のサイトで OpenID として使うことができません。',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => "{{SITENAME}} はウェブサイト間でのシングルサインオンのための [http://openid.net/ OpenID] 規格に対応しています。OpenID によって、個別のパスワードを使うことなく、たくさんの様々なウェブサイトにログインできるようになります（より詳しい情報は[http://ja.wikipedia.org/wiki/OpenID ウィキペディアの OpenID についての記事]を参照してください）。

あなたが既に {{SITENAME}} でアカウントをもっている場合は、いつもどおりに利用者名とパスワードで[[Special:UserLogin|ログイン]]できます。将来、OpenID を使うためには、通常のログインをした後で[[Special:OpenIDConvert|あなたのアカウントを OpenID に変換する]]ことができます。

多くの[http://wiki.openid.net/Public_OpenID_providers 公開 OpenID プロバイダー]が存在し、あなたは既に別のサービスで OpenID が有効となったアカウントを保持しているかもしれません。

; 他のウィキ : あなたが、[http://wikitravel.org/ Wikitravel]、[http://www.wikihow.com/ wikiHow]、[http://vinismo.com/ Vinismo]、[http://aboutus.org/ AboutUs] あるいは [http://kei.ki/ Keiki] といった、OpenID が有効となったウィキでアカウントをもっている場合は、そのウィキでの利用者ページのフルURL (例: ''<nowiki>http://kei.ki/en/User:Evan</nowiki>'') を上のボックスに入力することで {{SITENAME}} にログインできます。
; [http://openid.yahoo.com/ Yahoo!] : あなたが Yahoo! でアカウントをもっている場合は、Yahoo! が提供する OpenID を上のボックスに入力することでこのサイトにログインできます。Yahoo! の OpenID URL は ''<nowiki>https://me.yahoo.com/yourusername</nowiki>'' という形式をしています。
; [http://dev.aol.com/aol-and-63-million-openids AOL] : あなたが、例えば [http://www.aim.com/ AIM] アカウントなど、[http://www.aol.com/ AOL] でアカウントをもっている場合は、AOL が提供する OpenID を上のボックスに入力することで {{SITENAME}} にログインできます。AOL の OpenID URL は ''<nowiki>http://openid.aol.com/yourusername</nowiki>'' という形式をしています。利用者名はすべて小文字で、スペースを含んではなりません。
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger]・[http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com]・[http://www.livejournal.com/openid/about.bml LiveJournal]・[http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : あなたがこれらのサービスのどれかでブログをもっている場合は、あなたのブログの URL を上のボックスに入力してください。例えば、''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'' あるいは ''<nowiki>http://yourusername.vox.com/</nowiki>'' といったものです。",
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
	'openidnotavailable' => 'ឈ្មោះហៅក្រៅ​ដែលអ្នកពេញចិត្ត ($1) ត្រូវបានប្រើដោយ​អ្នកប្រើប្រាស់​ម្នាក់​ផ្សេងទៀតហើយ។',
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
	'tog-hideopenid' => 'លាក់<a href="http://openid.net/">OpenID</a>របស់អ្នកនៅលើទំព័រអ្នកប្រើប្រាស់របស់អ្នក ប្រសិនបើអ្នកឡុកអ៊ីនដោយប្រើOpenID។',
	'openidnousername' => 'មិនមានឈ្មោះអ្នកប្រើប្រាស់បានបញ្ជាក់ទេ។',
	'openidbadusername' => 'ឈ្មោះមិនត្រឹមត្រូវត្រូវបានបញ្ជាក់',
);

/** Korean (한국어)
 * @author Ficell
 * @author Kwj2772
 */
$messages['ko'] = array(
	'openidlogin' => 'OpenID로 로그인',
	'openidserver' => 'OpenID 서버',
	'openidemail' => '이메일 주소',
	'openidlanguage' => '언어',
	'openidchoosepassword' => '비밀번호:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'openid-desc' => 'Hee em Wiki met ener [http://openid.net/ OpenID] enlogge, un angerschwoh mer OpenID kennt met enem Metmaacher-Name fum Wiki enlogge.',
	'openidlogin' => 'Met OpenID enlogge',
	'openidfinish' => 'Et Enlogge met OpenID afschleeße',
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
	'openidnotavailable' => 'Dinge leevste Spetznam, „$1“, es ald beleesch,
un enen anderen Metmaacher es dä am bruche.',
	'openidnotprovided' => 'Dinge OpenID Server hät keine Spetzname aanjejovve. Künnt sin, hä kann dat nit, künnt sin, Do häss_et imm verbodde.',
	'openidchooseinstructions' => 'Jede Metmaacher bruch enne Spetznam,
Do kannß Der der Dinge unge druß üßsöke.',
	'openidchoosefull' => 'Dinge komplätte Name ($1)',
	'openidchooseurl' => 'Enne Name uß Dinge OpenID eruß jejreffe ($1)',
	'openidchooseauto' => 'Enne automattesch zerääsch jemaate Name ($1)',
	'openidchoosemanual' => 'Ene Name, dä De Der sellver ußjedaach un jejovve häs:',
	'openidchooseexisting' => 'Ene Metmaachername, dä et alld jitt op däm Wiki hee:',
	'openidchoosepassword' => 'Paßwoot:',
	'openidconvertinstructions' => 'He kanns De Ding Aanmeldung als ene Metmaacher esu aanpasse, dat De en OpenID URL bruche kanns.',
	'openidconvertsuccess' => 'De Aanpassung aan OpenID hät jeklapp',
	'openidconvertsuccesstext' => 'Do häß Ding OpenID jez ömjewandelt noh $1.',
	'openidconvertyourstext' => 'Dat es ald Ding OpenID.',
	'openidconvertothertext' => 'Dat wämm anders sing OpenID.',
	'openidalreadyloggedin' => "'''Leeven $1, Do bes all enjelogg.'''

Wann De OpenID zom Enlogge bruche wells, spääder, dann kanns De
[[Special:OpenIDConvert|Ding Aanmeldung op OpenID ömstelle]] jonn.",
	'tog-hideopenid' => 'Versteich Ding <a lang="en" href="http://openid.net/">OpenID</a> op Dinge Metmaacher-Sigg, wann de met <span lang="en">OpenID</span> enloggs.',
	'openidnousername' => 'Keine Metmaacher-Name aanjejovve.',
	'openidbadusername' => 'Ene kapodde Metmaacher-Name aanjejovve.',
	'openidautosubmit' => 'Di Sigg enthääld_e Fomulaa för Ennjave, wat automattesch afjeschek weed, wann de Javaskrip enjeschalldt häs.
Wann nit, donn dä \\"Wigger\\" Knopp nemme.',
	'openidclientonlytext' => 'Do kann de Aanmelldunge fun hee dämm Wiki nit als <span lang="en">OpenIDs</span> op annder Webßöövere nämme.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => 'De {{SITENAME}} ongerstöz der <span lang="en">[http://openid.net/ OpenID]</span> Standat för et eijfache un eijmoolije Enlogge zwesche diverse Websigge.
<span lang="en">OpenID</span> määd_et müjjesch, dat mer op ongerscheedlijje Websigge enlogge kann, oohne dat mer övverall en annder Paßwoot bruch.
Loor Der [http://ksh.wikipedia.org/wiki/OpenID der Wikipedia ier Atikkel övver <span lang="en">OpenID</span>] aan, do steit noch mieh dren.

Wann de alld aanjemeldt bes op de {{SITENAME}}, dann kanns De met Dingem Metmaacher-Name un Paßwoot [[Special:UserLogin|enlogge]] wi sönß och.
Öm spääder och <span lang="en">OpenID</span> ze bruche, kann noh_m nomaale Enlogge Ding Aanmeldungsdate [[Special:OpenIDConvert|op <span lang="en">OpenID</span> ömstelle]].

Et jitt en jruuße Zahl [http://wiki.openid.net/Public_OpenID_providers <span lang="en">OpenID Provider</span> för de Öffentleschkeit], un et künnt joot sin, dat De alld ene <span lang="en">OpenID</span>-fä\'ijje Zojang häß, op däm eine udder andere Server.

; Annder Wikis : Wann De op enem Wiki aanjemelldt bes, wat <span lang="en">OpenID</span> ongerschtöz, zem Beispöll [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] udder [http://kei.ki/ Keiki], kanns de hee op de {{SITENAME}} enlogge, indämm dat De de komplätte URL fun Dinge Metmaacher-Sigg op däm aandere Wiki hee bovve endrähß. Zem Beispöll esu jät wi: \'\'<nowiki>http://kei.ki/en/User:Evan</nowiki>\'\'.
; [http://openid.yahoo.com/ Yahoo!] : Wann De bei <span lang="en">Yahoo!</span> aanjemelldt bes, kanns de hee op de {{SITENAME}} enlogge, indämm dat De de Ding <span lang="en">OpenID URL</span> bovve aanjiß, di De fun <span lang="en">Yahoo!</span> bekumme häß. Di <span lang="en">OpenID URLs</span> sinn uß wi zem Beispöll: \'\'<nowiki>https://me.yahoo.com/DingeMetmaacherName</nowiki>\'\'.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Wann de ene zohjang op [http://www.aol.com/ AOL] häß, esu jet wie ennen Zojang zom [http://www.aim.com/ AIM], do kanns de Desch hee op de {{SITENAME}} enlogge, indämm dat De de Ding <span lang="en">OpenID</span> bovve enjiß. De <span lang="en">OpenID URLs</span> fun AOL sen opjebout wi \'\'<nowiki>http://openid.aol.com/dingemetmaachername</nowiki>\'\'. Dinge Metmaacher-Name sullt uß luuter Kleinbochstave bestonn, kein Zwescheräum.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Wann de e <span lang="en">Blog</span> op einem fun dä Söövere häß, dann draach der Url fu Dingem <span lang="en">Blog</span> bovve en. Zem Beispöll: \'\'<nowiki>http://dingeblogname.blogspot.com/</nowiki>\'\', \'\'<nowiki>http://dingeblogname.wordpress.com/</nowiki>\'\', \'\'<nowiki>http://dingeblogname.livejournal.com/</nowiki>\'\', udder \'\'<nowiki>http://dingeblogname.vox.com/</nowiki>\'\'.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'openid-desc' => "Sech an d'Wiki matt enger http://openid.net/ OpenID] aloggen, a sech op aneren Internetsiten, déi OpenID ënerstetzen, matt engem Wiki-Benotzerkont aloggen.",
	'openidlogin' => 'Umellen mat OpenID',
	'openidfinish' => "D'Aloggen mat OpenID ofschléissen",
	'openidserver' => 'OpenID-Server',
	'openidxrds' => 'Yadis Fichier',
	'openidconvert' => 'OpenID-Ëmwandler',
	'openiderror' => 'Feeler bäi der Iwwerpréifung',
	'openiderrortext' => 'Beim Iwwerpréifen vun der OpenID URL ass e Feeler geschitt.',
	'openidconfigerror' => 'OpenId-Konfiguratiounsfeeler',
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
	'openidfullname' => 'Ganze Numm',
	'openidemail' => 'E-Mailadress',
	'openidlanguage' => 'Sprooch',
	'openidnotavailable' => 'De Spëtznumm deen Dir wollt hun ($1) gëtt scho vun engem anere Benotzer benotzt.',
	'openidnotprovided' => 'Ären OpenID-Server huet kee Spëtznumm ginn (entweder well en dat net kann, oder well Dir him gesot huet dat ne t ze maachen).',
	'openidchooseinstructions' => 'All Benotzer brauchen e Spëtznumm; Dir kënnt iech ee vun de Méiglechkeeten ënnendrënner auswielen.',
	'openidchoosefull' => 'Äre ganze Numm ($1)',
	'openidchooseurl' => 'En Numm gouf vun ärer OpenID ($1) geholl',
	'openidchooseauto' => 'Een Numm deen automatesch generéiert gouf ($1)',
	'openidchoosemanual' => 'E Numm vun ärer Wiel:',
	'openidchooseexisting' => 'E Benotzerkont den et op dëser Wiki scho gëtt:',
	'openidchoosepassword' => 'Passwuert:',
	'openidconvertinstructions' => 'Mat dësem Formaulaire kënnt dir Äre Benotzerkont ännere fir eng OpenID URL ze benotzen.',
	'openidconvertsuccess' => 'An en OpenID-Benotzerkont ëmgewandelt',
	'openidconvertsuccesstext' => 'Dir hutt Är OpenID op $1 ëmgewandelt.',
	'openidconvertyourstext' => 'Dat ass schon är OpenID.',
	'openidconvertothertext' => 'Dëst ass engem anere seng OpenID.',
	'openidalreadyloggedin' => "'''Dir sidd schonn ageloggt, $1!'''

Wann Dir OpenID benotze wëllt fir Iech an Zukunft anzeloggen, da kënnt Dir [Special:OpenIDConvert|Äre Benotzerkont an en OpenID-Benotzerkont ëmwandelen]].",
	'tog-hideopenid' => 'Verstoppt Är <a href="http://openid.net/">OpenID</a> op ärer Benotzersäit, wann dir Iech mat OpenID aloggt.',
	'openidnousername' => 'Kee Benotzernumm uginn.',
	'openidbadusername' => 'Falsche Benotzernumm uginn.',
	'openidautosubmit' => 'Op dëser Säit gëtt et e Formulaire deen automatesch soll verschéckt ginn wann Dir JavaScript ageschalt hutt.
Wann net, da verich et mam Knäppche "Weider"',
	'openidclientonlytext' => 'Dir kënnt keng Benotzerkonten aus dëser Wiki als OpendIDen op anere Site benotzen.',
	'openidloginlabel' => 'URL vun der OpenID',
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'openiderror' => 'Tikrinimo klaida',
	'openidnickname' => 'Slapyvardis',
	'openidfullname' => 'Pilnas vardas',
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

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'openidlogin' => 'ഓപ്പണ്‍ ഐഡി ഉപയോഗിച്ച് ലോഗിന്‍ ചെയ്യുക',
	'openidserver' => 'OpenID സെര്‍‌വര്‍',
	'openidcancel' => 'സ്ഥിരീകരണം റദ്ദാക്കിയിരിക്കുന്നു',
	'openidfailure' => 'സ്ഥിരീകരണം പരാജയപ്പെട്ടു',
	'openidsuccess' => 'സ്ഥിരീകരണം വിജയിച്ചു',
	'openidusernameprefix' => 'ഓപ്പണ്‍ ഐഡി ഉപയോക്താവ്',
	'openidserverlogininstructions' => '$3യിലേക്ക് $2 എന്ന ഉപയോക്താവായി (ഉപയോക്തൃതാള്‍ $1) ലോഗിന്‍ ചെയ്യുവാന്‍ താങ്കളുടെ രഹസ്യവാക്ക് താഴെ രേഖപ്പെടുത്തുക.',
	'openidtrustinstructions' => '$1 താങ്കളുടെ ഡാറ്റ പങ്കുവെക്കണമോ എന്ന കാര്യം പരിശോധിക്കുക.',
	'openidnopolicy' => 'സൈറ്റ് സ്വകാര്യതാ നയം കൊടുത്തിട്ടില്ല.',
	'openidoptional' => 'നിര്‍ബന്ധമില്ല',
	'openidrequired' => 'അത്യാവശ്യമാണ്‌',
	'openidnickname' => 'ചെല്ലപ്പേര്',
	'openidfullname' => 'പൂര്‍ണ്ണനാമം',
	'openidemail' => 'ഇമെയില്‍ വിലാസം',
	'openidlanguage' => 'ഭാഷ',
	'openidnotavailable' => 'താങ്കള്‍ തിരഞ്ഞെടുത്ത വിളിപ്പേര്‌ ($1) മറ്റൊരാള്‍ ഉപയോഗിക്കുന്നതാണ്‌.',
	'openidchooseinstructions' => 'എല്ലാ ഉപയോക്താക്കള്‍ക്കും ഒരു വിളിപ്പേരു ആവശ്യമാണ്‌. താഴെ കൊടുത്തിരിക്കുന്നവയില്‍ നിന്നു ഒരെണ്ണം നിങ്ങള്‍ക്ക് തിരഞ്ഞെടുക്കാവുന്നതാണ്‌.',
	'openidchoosefull' => 'താങ്കളുടെ പൂര്‍ണ്ണനാമം ($1)',
	'openidchooseurl' => 'താങ്കളുടെ ഓപ്പണ്‍‌ഐഡിയില്‍ നിന്നു തിരഞ്ഞെടുത്ത ഒരു പേര്‌ ($1)',
	'openidchooseauto' => 'യാന്ത്രികമായി ഉണ്ടാക്കിയ പേര്‌ ($1)',
	'openidchoosemanual' => 'താങ്കള്‍ക്ക് ഇഷ്ടമുള്ള ഒരു പേര്‌:',
	'openidchooseexisting' => 'ഈ വിക്കിയില്‍ നിലവിലുള്ള അക്കൗണ്ട്:',
	'openidchoosepassword' => 'രഹസ്യവാക്ക്:',
	'openidconvertsuccess' => 'ഓപ്പണ്‍ ഐഡിയിലേക്ക് വിജയകരമായി പരിവര്‍ത്തനം ചെയ്തിരിക്കുന്നു',
	'openidconvertsuccesstext' => 'താങ്കളുടെ ഓപ്പണ്‍‌ഐഡി $1ലേക്കു വിജയകരമായി പരിവര്‍ത്തനം ചെയ്തിരിക്കുന്നു.',
	'openidconvertyourstext' => 'ഇതു ഇപ്പോള്‍ തന്നെ നിങ്ങളുടെ ഓപ്പണ്‍‌ഐഡിയാണ്‌.',
	'openidconvertothertext' => 'ഇതു മറ്റാരുടേയോ ഓപ്പണ്‍‌ഐഡിയാണ്‌.',
	'openidnousername' => 'ഉപയോക്തൃനാമം തിരഞ്ഞെടുത്തിട്ടില്ല.',
	'openidbadusername' => 'അസാധുവായ ഉപയോക്തൃനാമമാണു തിരഞ്ഞെടുത്തിരിക്കുന്നത.',
	'openidloginlabel' => 'ഓപ്പണ്‍‌ഐഡി വിലാസം',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'openid-desc' => 'विकिवर [http://openid.net/ ओपनID] वापरून प्रवेश करा, तसेच कुठल्याही इतर ओपनID संकेतस्थळावर विकि सदस्य नाम वापरून प्रवेश करा',
	'openidlogin' => 'ओपनID वापरून प्रवेश करा',
	'openidfinish' => 'ओपनID प्रवेश प्रक्रिया पूर्ण करा',
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
	'openidnotavailable' => 'तुम्ही दिलेले टोपणनाव ($1) अगोदरच दुसर्‍या सदस्याने वापरलेले आहे.',
	'openidnotprovided' => 'तुमच्या ओपनID सर्व्हरने टोपणनाव दिले नाही (कदाचित तो देऊ शकत नसेल किंवा तुम्ही देण्यास मनाई केली असेल).',
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
	'tog-hideopenid' => 'जर तुम्ही ओपनID वापरून प्रवेश केला, तर तुमच्या सदस्यपानावरील तुमचा <a href="http://openid.net/">ओपनID</a> लपवा.',
	'openidnousername' => 'सदस्यनाव दिले नाही.',
	'openidbadusername' => 'चुकीचे सदस्यनाव दिले आहे.',
	'openidautosubmit' => 'या पानावरील अर्ज जर तुम्ही जावास्क्रीप्ट वापरत असाल तर आपोआप पाठविला जाईल. जर तसे झाले नाही, तर \\"पुढे\\" कळीवर टिचकी मारा.',
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
);

/** Malay (Bahasa Melayu)
 * @author Aviator
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
	'openidnousername' => 'Nama pengguna tidak dinyatakan.',
	'openidbadusername' => 'Nama pengguna yang dinyatakan tidak sah.',
	'openidloginlabel' => 'URL OpenID',
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
	'openidlanguage' => 'Кель',
	'openidchoosepassword' => 'совамо валось:',
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
	'openidfinish' => 'Aanmelden met OpenID afronden',
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
	'openidnotavailable' => 'Uw voorkeursnaam ($1) wordt al gebruikt door een andere gebruiker.',
	'openidnotprovided' => 'Uw OpenID-server heeft geen gebruikersnaam opgegeven (omdat het niet wordt ondersteund of omdat u dit zo hebt opgegeven).',
	'openidchooseinstructions' => 'Alle gebruikers moeten een gebruikersnaam kiezen. U kunt er een kiezen uit de onderstaande opties.',
	'openidchoosefull' => 'Uw volledige naam ($1)',
	'openidchooseurl' => 'Een naam uit uw OpenID ($1)',
	'openidchooseauto' => 'Een automatisch samengestelde naam ($1)',
	'openidchoosemanual' => 'Een te kiezen naam:',
	'openidchooseexisting' => 'Een bestaande gebruiker op deze wiki:',
	'openidchoosepassword' => 'wachtwoord:',
	'openidconvertinstructions' => 'Met dit formulier kunt u uw gebruiker als OpenID URL gebruiken.',
	'openidconvertsuccess' => 'Omzetten naar OpenID is uitgevoerd',
	'openidconvertsuccesstext' => 'Uw OpenID is omgezet naar $1.',
	'openidconvertyourstext' => 'Dat is al uw OpenID.',
	'openidconvertothertext' => 'Iemand anders heeft die OpenID al in gebruik.',
	'openidalreadyloggedin' => "'''U bent al aangemeld, $1!'''

Als u in de toekomst uw OpenID wilt gebruiken om aan te melden, [[Special:OpenIDConvert|zet uw gebruiker dan om naar OpenID]].",
	'tog-hideopenid' => 'Bij aanmelden met <a href="http://openid.net/">OpenID</a>, uw OpenID op uw gebruikerspagina verbergen.',
	'openidnousername' => 'Er is geen gebruikersnaam opgegeven.',
	'openidbadusername' => 'De opgegeven gebruikersnaam is niet toegestaan.',
	'openidautosubmit' => 'Deze pagina bevat een formulier dat automatisch wordt verzonden als JavaScript is ingeschaked.
Als dat niet werkt, klik dan op de knop "Doorgaan".',
	'openidclientonlytext' => 'U kunt gebruikers van deze wiki niet als OpenID gebruiken op een andere site.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => "{{SITENAME}} ondersteunt de standaard [http://openid.net/ OpenID] voor maar een keer hoeven aanmelden voor meerdere websites.
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
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'openid-desc' => 'Logg inn på wikien med ein [http://openid.net/ OpenID] og logg inn på andre sider som bruker OpenID med kontoen herifrå',
	'openidlogin' => 'Logg inn med OpenID',
	'openidfinish' => 'Fullfør OpenID-innlogging',
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
	'openidnotavailable' => 'Føretrukke kallenamn ($1) blir allereie nytta av ein annan brukar.',
	'openidnotprovided' => 'OpenID-tenaren din oppgav ikkje eit kallenamn (anten med di han ikkje kunne det, eller med di du har sagt at han ikkje skal gjera det).',
	'openidchooseinstructions' => 'All brukarar må ha eit kallenamn; du kan velja mellom vala nedanfor.',
	'openidchoosefull' => 'Fullt namn ($1)',
	'openidchooseurl' => 'Eit namn teke frå OpenID-en din ($1)',
	'openidchooseauto' => 'Eit automatisk oppretta namn ($1)',
	'openidchoosemanual' => 'Eit valfritt namn:',
	'openidchooseexisting' => 'Ein konto på denne wikien som finst frå før:',
	'openidchoosepassword' => 'passord:',
	'openidconvertinstructions' => 'Dette skjemaet lèt deg endra brukarkontoen din slik at han kan nytta ei OpenID-adressa.',
	'openidconvertsuccess' => 'Konverterte til OpenID',
	'openidconvertsuccesstext' => 'Du har konvertert din OpenID til $1.',
	'openidconvertyourstext' => 'Det er allereie din OpenID.',
	'openidconvertothertext' => 'Den OpenID-en tilhøyrer einkvan annan.',
	'openidalreadyloggedin' => "'''Du er allereie innlogga, $1.'''

Om du ynskjer å nytta OpenID i framtida, kan du [[Special:OpenIDConvert|konvertera kontoen din til å nytta OpenID]].",
	'tog-hideopenid' => 'Gøym <a href="http://openid.net/">OpenID</a> på brukarsida di om du loggar inn med ein.',
	'openidnousername' => 'Du oppgav ingen brukarnamn.',
	'openidbadusername' => 'Du oppgav eit ugyldig brukarnamn.',
	'openidautosubmit' => 'Denne sida inneheld eit skjema som blir levert automatisk om du har JavaSvript slege på. Dersom ikkje, trykk på «Hald fram».',
	'openidclientonlytext' => 'Du kan ikkje nytta kontoar frå denne wikien som OpenID på ei onnor sida.',
	'openidloginlabel' => 'OpenID-adressa',
	'openidlogininstructions' => "{{SITENAME}} støttar [http://openid.net/ OpenID]-standarden for einskapleg innlogging på forskjellige nettstader. OpenID lèt deg logga inn på mange forskjellige nettsider utan at du må nytta forskjellige passord overalt. (Sjå [http://no.wikipedia.org/wiki/OpenID Wikipedia-artikkelen om OpenID] for meir informasjon.)

Om du allereie har ein konto på {{SITENAME}}, kan du logga på som vanleg med brukarnamnet og passordet ditt. For å nytta OpenID i framtida, kan du [[Special:OpenIDConvert|konvertera kontoen din til OpenID]] etter at du har logga inn på vanleg vis.

Det er mange [http://wiki.openid.net/Public_OpenID_providers leverandørar av OpenID], og du kan allereie ha ein OpenID-aktivert konto ein annan stad.

;Andre wikiar: Om du har ein konto på ein OpenID-aktivert wiki, som [http://wikitravel.org/ Wikitravel], [http://wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] eller [http://kei.ki/ Keiki], kan du logga inn på {{SITENAME}} ved å skriva inn den '''fullstendige adressa''' til brukarsida di på wikien i boksen ovanfor. Til dømes ''<nowiki>http://kei.kei/en/User:Døme</nowiki>''.
;[http://openid.yahoo.com/ Yahoo!]: Om du har ein konto hjå Yahoo! kan du logga inn på denne sida ved å skriva inn OpenID-en din frå Yahoo i boksen ovanfor. Yahoo! sine OpenID-adresser har forma ''<nowiki>https://me.yahoo.com/brukarnamnetditt</nowiki>''.
;[http://dev.aol.com/aol-and-63-million-openids AOL]: Om du har ein konto hjå [http://aol.com/ AOL], til dømes ein [http://aim.com/ AIM]-konto, kan du logga inn på {{SITENAME}} ved å skriva inn OpenID-en din frå AOL i boksen ovanfor. AOL sine OpenID-adresser har forma ''<nowiki>http://openid.aol.com/brukarnamnetditt</nowiki>''. Brukarnamnet må vera skrive med små bokstavar og utan mellomrom.
;[http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox]: Om du har ein konto på ei av desse tenestene, skriv inn adressa til bloggen din i boksen ovanfor. Til dømes ''<nowiki>http://brukarnamnetditt.blogspot.com/</nowiki>'', ''<nowiki>http://brukarnamnetditt.wordpress.com/</nowiki>'', ''<nowiki>http://brukarnamnetditt.livejournal.com/</nowiki>'', or ''<nowiki>http://brukarnamnetditt.vox.com/</nowiki>''.",
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'openid-desc' => 'Logg inn på wikien med en [http://openid.net/ OpenID] og logg inn på andre sider som bruker OpenID med kontoen herfra',
	'openidlogin' => 'Logg inn med OpenID',
	'openidfinish' => 'Fullfør OpenID-innlogging',
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
	'openidnotavailable' => 'Foretrukket kallenavn ($1) brukes allerede av en annen bruker.',
	'openidnotprovided' => 'OpenID-tjeneren din oppga ikke et kallenavn (enten fordi den ikke kunne det, eller fordi du har sagt at den ikke skal gjøre det).',
	'openidchooseinstructions' => 'Alle brukere må ha et kallenavn; du kan velge blant valgene nedenfor.',
	'openidchoosefull' => 'Fullt navn ($1)',
	'openidchooseurl' => 'Et navn tatt fra din OpenID ($1)',
	'openidchooseauto' => 'Et automatisk opprettet navn ($1)',
	'openidchoosemanual' => 'Et valgfritt navn:',
	'openidchooseexisting' => 'En eksisterende konto på denne wikien:',
	'openidchoosepassword' => 'passord:',
	'openidconvertinstructions' => 'Dette skjemaet lar deg endre brukerkontoen din til å bruke en OpenID-adresse.',
	'openidconvertsuccess' => 'Konverterte til OpenID',
	'openidconvertsuccesstext' => 'Du har konvertert din OpenID til $1.',
	'openidconvertyourstext' => 'Det er allerede din OpenID.',
	'openidconvertothertext' => 'Den OpenID-en tilhører noen andre.',
	'openidalreadyloggedin' => "'''$1, du er allerede logget inn.'''

Om du ønsker å bruke OpenID i framtiden, kan du [[Special:OpenIDConvert|konvertere kontoen din til å bruke OpenID]].",
	'tog-hideopenid' => 'Skjul <a href="http://openid.net/">OpenID</a> på brukersiden din om du logger inn med en.',
	'openidnousername' => 'Intet brukernavn oppgitt.',
	'openidbadusername' => 'Ugyldig brukernavn oppgitt.',
	'openidautosubmit' => 'Denne siden inneholder et skjema som vil leveres automatisk om du har JavaScript slått på. Om ikke, trykk på «Fortsett».',
	'openidclientonlytext' => 'Du kan ikke bruke kontoer fra denne wikien som OpenID på en annen side.',
	'openidloginlabel' => 'OpenID-adresse',
	'openidlogininstructions' => "{{SITENAME}} støtter [http://openid.net/ OpenID]-standarden for enhetlig innlogging på forskjellige nettsteder. OpenID lar deg logge inn på mange forskjellige nettsider uten å bruke forskjellige passord overalt. (Se [http://no.wikipedia.org/wiki/OpenID Wikipedia-artikkelen om OpenID] for mer informasjon.)

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
	'openid-desc' => "Se connecta al wiki amb [http://openid.net/ OpenID] e se connecta a d'autres sits internet OpenID amb un wiki utilizant un compte d'utilizaire.",
	'openidlogin' => 'Se connectar amb OpenID',
	'openidfinish' => 'Acabar la conneccion OpenID',
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
	'openidnopolicy' => 'Lo sit a pas indicat una politica de las donadas personnalas.',
	'openidpolicy' => 'Verificar la <a target="_new" href="$1">Politica de las donadas personalas</a> per mai d’entresenhas.',
	'openidoptional' => 'Facultatiu',
	'openidrequired' => 'Exigit',
	'openidnickname' => 'Escais',
	'openidfullname' => 'Nom complet',
	'openidemail' => 'Adreça de corrièr electronic',
	'openidlanguage' => 'Lenga',
	'openidnotavailable' => 'Vòstre escais preferit ($1) ja es utilizat per un autre utilizaire.',
	'openidnotprovided' => "Vòstre servidor OpenID a pas pogut provesir un escais (siá o pòt pas, siá li avètz demandat d'o far pas mai).",
	'openidchooseinstructions' => "Totes los utilizaires an besonh d'un escais ; ne podètz causir un a partir de la causida çaijós.",
	'openidchoosefull' => 'Vòstre nom complet ($1)',
	'openidchooseurl' => 'Un nom es estat causit dempuèi vòstra OpenID ($1)',
	'openidchooseauto' => 'Un nom creat automaticament ($1)',
	'openidchoosemanual' => "Un nom qu'avètz causit :",
	'openidchooseexisting' => 'Un compte existent sus aqueste wiki :',
	'openidchoosepassword' => 'Senhal :',
	'openidconvertinstructions' => "Aqueste formulari vos daissa cambiar vòstre compte d'utilizaire per utilizar una adreça OpenID.",
	'openidconvertsuccess' => 'Convertit amb succès cap a OpenID',
	'openidconvertsuccesstext' => 'Avètz convertit amb succès vòstra OpenID cap a $1.',
	'openidconvertyourstext' => 'Ja es vòstra OpenID.',
	'openidconvertothertext' => "Aquò es quicòm d'autre qu'una OpenID.",
	'openidalreadyloggedin' => "'''Ja sètz connectat, $1 !'''

Se desiratz utilizar vòstra OpenID per vos connectar ulteriorament, podètz [[Special:OpenIDConvert|convertir vòstre compte per utilizar OpenID]].",
	'tog-hideopenid' => 'Amaga vòstra <a href="http://openid.net/">OpenID</a> sus vòstra pagina d\'utilizaire, se vos connectaz amb OpenID.',
	'openidnousername' => 'Cap de nom d’utilizaire es pas estat indicat.',
	'openidbadusername' => 'Un nom d’utilizaire marrit es estat indicat.',
	'openidautosubmit' => 'Aquesta pagina compren un formulari que poiriá èsser mandat automaticament se avètz activat JavaScript.
S’èra pas lo cas, ensajatz lo boton « Contunhar ».',
	'openidclientonlytext' => 'Podètz pas utilizar de comptes dempuèi aqueste wiki en tant qu’OpenID sus d’autres sits.',
	'openidloginlabel' => 'Adreça OpenID',
	'openidlogininstructions' => "{{SITENAME}} supòrta lo format [http://openid.net/ OpenID] estandard per una sola signatura entre de sits Internet.
OpenID vos permet de vos connectar sus maites sits diferents sens aver d'utilizar un senhal diferent per cadun d’entre eles.
(Vejatz [http://en.wikipedia.org/wiki/OpenID Wikipedia's OpenID article] per mai d'entresenhas.)

S'avètz ja un compte sus {{SITENAME}}, vos podètz [[Special:UserLogin|connectar]] amb vòstre nom d'utilizaire e son senhal coma de costuma. Per utilizar OpenID, a l’avenidor, podètz [[Special:OpenIDConvert|convertir vòstre compte en OpenID]] aprèp vos èsser connectat normalament.

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
	'openidnickname' => 'Фæсномыг',
	'openidlanguage' => 'Æвзаг',
	'openidchoosepassword' => 'пароль:',
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
	'openidoptional' => 'Opcjonalnie',
	'openidrequired' => 'Wymagane',
	'openidnickname' => 'Nazwa użytkownika',
	'openidfullname' => 'Imię i nazwisko',
	'openidemail' => 'Adres e-mail',
	'openidlanguage' => 'Język',
	'openidnotavailable' => 'Wybrana nazwa użytkownika „$1” jest już zajęta.',
	'openidchooseinstructions' => 'Wszyscy użytkownicy muszą posiadać nazwę.
Możesz wybrać spośród propozycji podanych poniżej.',
	'openidchoosefull' => 'Twoje imię i nazwisko ($1)',
	'openidchooseauto' => 'Automatycznie utworzono nazwę użytkownika ($1)',
	'openidchoosemanual' => 'Nazwa użytkownika wybrana przez Ciebie',
	'openidchooseexisting' => 'Istniejące konto na tej wiki',
	'openidchoosepassword' => 'hasło',
	'openidnousername' => 'Nie wybrano żadnej nazwy użytkownika.',
	'openidbadusername' => 'Wybrano nieprawidłową nazwę użytkownika.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'openidnickname' => 'کورنی نوم',
	'openidfullname' => 'بشپړ نوم',
	'openidemail' => 'برېښليک پته',
	'openidlanguage' => 'ژبه',
	'openidchooseinstructions' => 'ټولو کارونکيو ته د يوه کورني نوم اړتيا شته؛
تاسو يو نوم د لاندينيو خوښو نه ځانته ټاکلی شی.',
	'openidchoosefull' => 'ستاسو بشپړ نوم ($1)',
	'openidchoosemanual' => 'ستاسو د خوښې يو نوم:',
	'openidchoosepassword' => 'پټنوم:',
	'openidnousername' => 'هېڅ يو کارن-نوم نه دی ځانګړی شوی.',
	'openidbadusername' => 'يو ناسم کارن-نوم مو ځانګړی کړی.',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'openid-desc' => 'Autentique-se no wiki com um [http://openid.net/ OpenID], e autentique-se noutros sítios que usem OpenID com uma conta de utilizador wiki',
	'openidlogin' => 'Autenticação com OpenID',
	'openidfinish' => 'Terminar autenticação OpenID',
	'openidserver' => 'Servidor OpenID',
	'openidxrds' => 'Ficheiro Yadis',
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
	'openidtrustinstructions' => 'Verifique se pretender partilhar dados com $1.',
	'openidallowtrust' => 'Permitir que $1 confie nesta conta de utilizador.',
	'openidnopolicy' => 'O sítio não especificou uma política de privacidade.',
	'openidpolicy' => 'Consulte a <a target="_new" href="$1">política de privacidade</a> para mais informações.',
	'openidoptional' => 'Opcional',
	'openidrequired' => 'Requerido',
	'openidnickname' => 'Alcunha',
	'openidfullname' => 'Nome completo',
	'openidemail' => 'Endereço de e-mail',
	'openidlanguage' => 'Língua',
	'openidnotavailable' => 'A sua alcunha preferida ($1) já está em uso por outro utilizador.',
	'openidnotprovided' => 'O seu servidor OpenID não forneceu uma alcunha (ou porque não pôde, ou porque você lhe disse para não o fazer).',
	'openidchooseinstructions' => 'Todos os utilizadores precisam de uma alcunha;
pode escolher uma das opções abaixo.',
	'openidchoosefull' => 'O seu nome completo ($1)',
	'openidchooseurl' => 'Um nome escolhido a partir do seu OpenID ($1)',
	'openidchooseauto' => 'Um nome gerado automaticamente ($1)',
	'openidchoosemanual' => 'Um nome à sua escolha:',
	'openidchooseexisting' => 'Uma conta existente neste wiki:',
	'openidchoosepassword' => 'palavra-chave:',
	'openidconvertinstructions' => 'Este formulário permite-lhe alterar a sua conta de utilizador para usar uma URL OpenID.',
	'openidconvertsuccess' => 'Convertido para OpenID com sucesso',
	'openidconvertsuccesstext' => 'Você converteu com sucesso o seu OpenID para $1.',
	'openidconvertyourstext' => 'Esse já é o seu OpenID.',
	'openidconvertothertext' => 'Esse é o OpenID de outra pessoa.',
	'openidalreadyloggedin' => "'''Você já se encontra autenticado, $1!'''

Se de futuro pretender usar OpenID para se autenticar, pode [[Special:OpenIDConvert|converter a sua conta para usar OpenID]].",
	'tog-hideopenid' => 'Esconder o seu <a href="http://openid.net/">OpenID</a> na sua página de utilizador, se se autenticar com OpenID.',
	'openidnousername' => 'Nenhum nome de utilizador especificado.',
	'openidbadusername' => 'Nome de utilizador especificado inválido.',
	'openidautosubmit' => 'Esta página inclui um formulário que deverá ser automaticamente submetido se tiver JavaScript activado.
Caso contrário, utilize o botão \\"Continuar\\".',
	'openidclientonlytext' => 'Você pode usar contas deste wiki como OpenIDs noutro sítio.',
	'openidloginlabel' => 'URL do OpenID',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'openidcancel' => 'Verificare anulată',
	'openidfailure' => 'Verificare eşuată',
	'openidsuccess' => 'Verificare cu succes',
	'openidoptional' => 'Opţional',
	'openidemail' => 'Adresă e-mail',
	'openidlanguage' => 'Limbă',
	'openidchoosemanual' => 'Un nume la alegere:',
	'openidchooseexisting' => 'Un cont existent pe acest wiki:',
	'openidchoosepassword' => 'parolă:',
);

/** Russian (Русский)
 * @author Aleksandrit
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'openid-desc' => 'Вход в вики с помощью [http://openid.net/ OpenID], а также вход на другие сайты поддерживающие OpenID с помощью учётной записи в вики',
	'openidlogin' => 'Вход с помощью OpenID',
	'openidfinish' => 'Завершить вход OpenID',
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
	'openidserverlogininstructions' => 'Введите ниже ваш пароль, чтобы войти на $3 как пользователь $2 (личная страница $1).',
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
	'openidnotavailable' => 'Указанный вами псевдоним ($1) уже используется другим участником.',
	'openidnotprovided' => 'Ваш сервер OpenID не предоставил псевдоним (либо потому, что он не может, либо потому, что вы указали не делать этого)',
	'openidchooseinstructions' => 'Каждый участник должен иметь псевдоним;
вы можете выбрать один из представленных ниже.',
	'openidchoosefull' => 'Ваше полное имя ($1)',
	'openidchooseurl' => 'Имя, полученное из вашего OpenID ($1)',
	'openidchooseauto' => 'Автоматически созданное имя ($1)',
	'openidchoosemanual' => 'Имя на ваш выбор:',
	'openidchooseexisting' => 'Существующая учётная запись на этой вики:',
	'openidchoosepassword' => 'пароль:',
	'openidconvertinstructions' => 'Эта форма позволяет вам сменить использование учётной записи на использование адреса OpenID.',
	'openidconvertsuccess' => 'Успешное преобразование в OpenID',
	'openidconvertsuccesstext' => 'Вы успешно преобразовали ваш OpenID в $1.',
	'openidconvertyourstext' => 'Это уже ваш OpenID.',
	'openidconvertothertext' => 'Это чужой OpenID.',
	'openidalreadyloggedin' => "'''Вы уже вошли, $1!'''

Если вы желаете использовать в будущем вход через OpenID, вы можете [[Special:OpenIDConvert|преобразовать вашу учётную запись для использования в OpenID]].",
	'tog-hideopenid' => 'Скрывать ваш <a href="http://openid.net/">OpenID</a> на вашей странице участника, если вы вошли с помощью OpenID.',
	'openidnousername' => 'Не указано имя участника.',
	'openidbadusername' => 'Указано неверное имя участника.',
	'openidautosubmit' => 'Эта страница содержит форму, которая должна быть автоматически отправлена, если у вас включён JavaScript.
Если этого не произошло, попробуйте нажать на кнопку «Продолжить».',
	'openidclientonlytext' => 'Вы не можете использовать учётные записи с этой вики, как OpenID на другом сайте.',
	'openidloginlabel' => 'Адрес OpenID',
	'openidlogininstructions' => "{{SITENAME}} поддерживает стандарт [http://openid.net/ OpenID], позволяющий использовать одну учётную запись для входа на различные веб-сайты.
OpenID позволяет вам заходить на различные веб-сайты без указания разных паролей для них
(подробнее см. [http://ru.wikipedia.org/wiki/OpenID статью об OpenID в Википедии]).

Если вы уже имеете учётную запись на {{SITENAME}}, вы можете [[Special:UserLogin|войти]] как обычно, используя  ваши имя пользователя и пароль.
Чтобы использовать в дальнейшем OpenID, вы можете [[Special:OpenIDConvert|преобразовать вашу учётную запись в  OpenID]], после того, как вы вошли обычным образом.

Существует множество [http://wiki.openid.net/Public_OpenID_providers общедоступных провайдеров OpenID], возможно, вы уже имеете учётную запись OpenID на другом сайте.

; Другие вики : Если вы имеете учётную запись с OpenID на другой вики, например, [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] или [http://kei.ki/ Keiki], вы можете войти на {{SITENAME}}, введя ниже '''полный адрес''' вашей страницы участника на другой вики. Например, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Если вы зарегистрированы на Yahoo!, вы можете войти, введя ниже ваш OpenID с Yahoo!. Адреса OpenID Yahoo! имеют вид ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Если вы зарегистрированы на [http://www.aol.com/ AOL], например, имеете учётную запись в [http://www.aim.com/ AIM], вы можете зайти на {{SITENAME}}, введя ниже ваш OpenID с AOL. Адреса AOL OpenID имеют вид ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Ваше имя должно быть в нижнем регистре, без пробелов.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Если вы ведёте блог с помощью одной из этих служб, введите ниже адрес вашего блога. Например, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', или ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'openid-desc' => "Fai lu login a la wiki cu [http://openid.net/ OpenID] r a l'àutri siti web ca non ùsanu OpenID cu n'account wiki",
	'openidlogin' => 'Login cu OpenID',
	'openidfinish' => 'Cumpleta lu login OpenID',
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
	'openidnotavailable' => "Lu tò nickname favuritu ($1) ci l'havi già n'àutru utenti.",
	'openidnotprovided' => 'Lu tò server OpenID non desi nu nickname (o picchi non potti o picchi ci dicisti di non fàrilu).',
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
	'tog-hideopenid' => 'Ammuccia lu tò <a href="http://openid.net/">OpenID</a> supr\'a tò pàggina utenti, si fai lu login cu OpenID.',
	'openidnousername' => 'Nuddu nomu utenti spicificatu.',
	'openidbadusername' => 'Nomu utenti spicificatu sbagghiatu.',
	'openidautosubmit' => 'Sta pàggina havi nu mòdulu c\'avissi èssiri mannatu autumàticamenti si JavaScript ci l\'hai attivatu. Si, mmeci, nun è accuddì, prova a mùnciri lu buttuni \\"Continue\\".',
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
	'openidfinish' => 'Dokončiť prihlásenie pomocou OpenID',
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
	'openidnotavailable' => 'Vašu preferovanú prezývku ($1) už používa iný používateľ.',
	'openidnotprovided' => 'Váš OpenID server neposkytol prezývku (buď preto, že nemôže alebo preto, že ste mu povedali aby ju neposkytoval).',
	'openidchooseinstructions' => 'Každý používateľ musí mať prezývku; môžete si vybrať z dolu uvedených možností.',
	'openidchoosefull' => 'Vaše plné meno ($1)',
	'openidchooseurl' => 'Meno na základe vášho OpenID ($1)',
	'openidchooseauto' => 'Automaticky vytvorené meno ($1)',
	'openidchoosemanual' => 'Meno, ktoré si vyberiete:',
	'openidchooseexisting' => 'Existujúci účet na tejto wiki:',
	'openidchoosepassword' => 'heslo:',
	'openidconvertinstructions' => 'Tento formulár vám umožňuje zmeniť váš učet, aby používal OpenID URL.',
	'openidconvertsuccess' => 'Úspešne prevedené na OpenID',
	'openidconvertsuccesstext' => 'Úspešne ste previedli váš OpenID na $1.',
	'openidconvertyourstext' => 'To už je váš OpenID.',
	'openidconvertothertext' => 'To je OpenID niekoho iného.',
	'openidalreadyloggedin' => "'''Už ste prihlásený, $1!'''

Ak chcete na prihlasovanie v budúcnosti využívať OpenID, môžete [[Special:OpenIDConvert|previesť váš účet na OpenID]].",
	'tog-hideopenid' => 'Nezobrazovať váš <a href="http://openid.net/">OpenID</a> na vašej používateľskej stránke ak sa prihlasujete pomocou OpenID.',
	'openidnousername' => 'Nebolo zadané používateľské meno.',
	'openidbadusername' => 'Bolo zadané chybné používateľské meno.',
	'openidautosubmit' => 'Táto stránka obsahuje formulár, ktorý by mal byť automaticky odoslaný ak máte zapnutý JavaScript.
Ak nie, skúste tlačidlo „Pokračovať“.',
	'openidclientonlytext' => 'Nemôžete používať účty z tejto wiki ako OpenID na iných weboch.',
	'openidloginlabel' => 'OpenID URL',
	'openidlogininstructions' => "{{SITENAME}} podporuje štandard [http://openid.net/ OpenID] na zjednotené prihlasovanie na webstránky.
OpenID vám umožňuje prihlasovať sa na množstvo rozličných webstránok bez nutnosti používať pre každú odlišné heslo. (Pozri [http://sk.wikipedia.org/wiki/OpenID Článok o OpenID na Wikipédii])

Ak už máte účet na {{GRAMMAR:lokál|{{SITENAME}}}}, môžete sa [[Special:UserLogin|prihlásiť]] pomocou používateľského mena a hesla ako zvyčajne. Ak chcete v budúcnosti používať OpenID, môžete po normálnom prihlásení [[Special:OpenIDConvert|previesť svoj účet na OpenID]].

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
	'openidemail' => 'Е-пошта',
	'openidlanguage' => 'Језик',
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
 * @author Jon Harald Søby
 * @author Lokal Profil
 * @author M.M.S.
 */
$messages['sv'] = array(
	'openid-desc' => 'Logga in på wikin med en [http://openid.net/ OpenID] och logga in på andra sidor som använder OpenID med konton härifrån',
	'openidlogin' => 'Logga in med OpenID',
	'openidfinish' => 'Fullfölj OpenID-inloggning',
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
	'openidnotavailable' => 'Ditt framförda användarnamn ($1) används redan av en annan användare.',
	'openidnotprovided' => 'Din OpenID-server uppgav inte ett användarnamn (antingen för att den inte kan, eller för att du har sagt till den att den inte ska göra det).',
	'openidchooseinstructions' => 'Alla användare måste ha ett användarnamn;
du kan välja ett från alternativen nedan.',
	'openidchoosefull' => 'Fullt namn ($1)',
	'openidchooseurl' => 'Ett namn taget från din OpenID ($1)',
	'openidchooseauto' => 'Ett automatiskt genererat namn ($1)',
	'openidchoosemanual' => 'Ett valfritt namn:',
	'openidchooseexisting' => 'Ett existerande konto på denna wiki:',
	'openidchoosepassword' => 'lösenord:',
	'openidconvertinstructions' => 'Detta formulär låter dig ändra dina användarkonton till att använda en OpenID-adress.',
	'openidconvertsuccess' => 'Konverterade till OpenID',
	'openidconvertsuccesstext' => 'Du har konverterat din OpenID till $1.',
	'openidconvertyourstext' => 'Det är redan din OpenID.',
	'openidconvertothertext' => 'Den OpenID tillhör någon annan.',
	'openidalreadyloggedin' => "'''Du är redan inloggad, $1!'''

Om du vill använda OpenID att logga in i framtiden, kan du [[Special:OpenIDConvert|konvertera dina konton till att använda OpenID]].",
	'tog-hideopenid' => 'Dölj <a href="http://openid.net/">OpenID</a> på din användarsida, om du loggar in med OpenID.',
	'openidnousername' => 'Inget användarnamn angivet.',
	'openidbadusername' => 'Ogiltigt användarnamn angivet.',
	'openidautosubmit' => 'Denna sida innehåller ett formulär som kommer levereras automatiskt om du har slagit på JavaScript. Om inte, tryck på "Fortsätt".',
	'openidclientonlytext' => 'Du kan inte använda konton från denna wikin som OpenID på en annan sida.',
	'openidloginlabel' => 'OpenID-adress',
	'openidlogininstructions' => "{{SITENAME}} stödjer [http://openid.net/ OpenID]-standarden för enhetlig inlogging på många webbsidor. OpenID låter dig logga in på många webbsidor utan att använda massor med lösenord överallt. (Se [http://en.wikipedia.org/wiki/OpenID Wikipedia-artikeln om OpenID] för mer information.)

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
	'openidpermission' => 'ఓపెన్ఐడీ అనుమతుల పొరపాటు',
	'openidcancel' => 'తనిఖీ రద్దయింది',
	'openidfailure' => 'తనిఖీ విఫలమైంది',
	'openidsuccess' => 'తనిఖీ విజయవంతమైంది',
	'openidoptional' => 'ఐచ్చికం',
	'openidrequired' => 'తప్పనిసరి',
	'openidnickname' => 'ముద్దుపేరు',
	'openidfullname' => 'పూర్తిపేరు',
	'openidemail' => 'ఈ-మెయిల్ చిరునామా',
	'openidlanguage' => 'భాష',
	'openidchoosefull' => 'మీ పూర్తి పేరు ($1)',
	'openidchoosemanual' => 'మీరు ఎన్నుకున్న పేరు:',
	'openidchooseexisting' => 'ఈ వికీలో ఇప్పటికే ఉన్న ఖాతా:',
	'openidchoosepassword' => 'సంకేతపదం:',
	'openidconvertyourstext' => 'అది ఇప్పటికే మీ ఓపెన్ఐడీ.',
	'openidnousername' => 'వాడుకరిపేరు ఇవ్వలేదు.',
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
	'openidfinish' => 'Хотима додан вурудшавии OpenID',
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

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'openid-desc' => 'Lumagda sa wiki na may [http://openid.net/ OpenID], at lumagda sa iba pang mga websayt na nakakaalam sa/nakababatid ng OpenID na may kuwenta/akawnt na pang-wiki',
	'openidlogin' => 'Lumagda na may OpenID',
	'openidfinish' => 'Tapusin na ang paglagdang pang-OpenID',
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
	'openidnotavailable' => 'Ang ninanais mong bansag na ($1) ay ginagamit na ng ibang tagagamit.',
	'openidnotprovided' => 'Hindi nagbigay ng isang bansag ang iyong serbidor ng OpenID (maaaring hindi niya ito maibigay, o dahil sinabi mo sa kaniyang huwag gawin ito).',
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
	'tog-hideopenid' => 'Itago ang <a href="http://openid.net/">OpenID</a> mo sa ibabaw ng iyong pahina ng tagagamit, kapag lumagda ka sa pamamagitan ng OpenID.',
	'openidnousername' => 'Walang tinukoy na pangalan ng tagagamit.',
	'openidbadusername' => 'Masama ang tinukoy na pangalan ng tagagamit.',
	'openidautosubmit' => 'Kabilang/kasama sa pahinang ito ang isang pormularyo na dapat na kusang maipasa/maipadala kapag hindi pinaandar (pinagana) ang JavaScript.
Kung hindi, subukin ang pindutang \\"Magpatuloy\\".',
	'openidclientonlytext' => 'Hindi mo magagamit ang mga kuwenta mula sa wiking ito bilang mga OpenID sa iba pang sityo/sayt.',
	'openidloginlabel' => 'URL ng OpenID',
	'openidlogininstructions' => "Tinatangkilik (sinusuportahan) ng {{SITENAME}} ang pamantayang [http://openid.net/ OpenID] para sa mga isahang paglagda sa pagitan ng mga sayt ng Web.
Hinahayaan ka ng OpenID na makalagda sa maraming iba't ibang mga sityo ng Web na hindi gumagamit ng isang iba pang hudyat para sa bawat isa.
(Tingnan ang [http://en.wikipedia.org/wiki/OpenID lathalaing OpenID ng Wikipedia] para sa mas marami pang kabatiran.)

Kung mayroon ka anng kuwenta sa {{SITENAME}}, maaari kang [[Special:UserLogin|lumagda]] sa pamamagitan ng iyong pangalan ng tagagamit at hudyat sa karaniwang paraan.
Upang makagamit ng OpenID sa hinaharap, maaari mong [[Special:OpenIDConvert|palitan ang iyong akawnt upang maging OpenID]] pagkatapos mong lumagda sa normal na paraan.

Maraming mga [http://wiki.openid.net/Public_OpenID_providers Pangmadlang tagapagbigay ng OpenID], at maaaring mayroon ka nang isang kuwentang pinagana ng OpenID na nasa ibang palingkuran (serbisyo).

; Ibang mga wiki : Kung mayroon ka nang isang kuwenta sa isang wiking pinaga ng OpenID, katulad ng [http://wikitravel.org/ Wikitravel] (\"Wikilakbay\"), [http://www.wikihow.com/ wikiHow] (\"wikPaano\"), [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] (\"Tungkol sa Amin\") o [http://kei.ki/ Keiki], maaari kang lumagda sa {{SITENAME}} sa pamamagitan ng pagpapasok/paglalagay ng '''buong URL''' ng pahina ng tagagamit mo sa loob ng kahong nasa itaas doon sa ibang wiking iyon. Halimbawa na ang ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Kung mayroon kang kuwenta sa Yahoo!, maaari kang lumagda sa sayt na ito sa pamamagitan ng paglalagay ng iyong Open-ID na ibinigay ng Yahoo! sa loob ng kahong nasa itaas. Ang mga URL ng OpenID ng Yahoo! ay mayroong pormularyong ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Kung mayroon kang kuwenta sa [http://www.aol.com/ AOL], katulad ng akawnt na [http://www.aim.com/ AIM], maaari kang lumagda sa {{SITENAME}} sa pamamagitan ng OpenID na ibinigay ng AOL sa loob ng kahong nasa itaas. Ang mga URL ng OpenID ng AOL ay maryoong pormularyong ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Ang kalahatan/kabuoan ng  iyong pangalan ng tagagamit ay dapat na nasa/may maliliit na mga panitik, at walang mga puwang/patlang.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Kung mayroon kang isang ''blog'' sa alin man sa mga palingkurang (serbisyong) ito, ipasok/ilagay ang URL ng ''blog'' mo sa kahong nasa itaas. Bilang halimbawa, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', o ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
);

/** Ukrainian (Українська)
 * @author AS
 * @author Aleksandrit
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
	'openidnotavailable' => 'Зазначений вами псевдонім ($1) вже використовується іншим учасником.',
	'openidnotprovided' => 'Ваш сервер OpenID не надав псевдонім (чи тому, що він не може, чи тому, що ви вказали не робити цього).',
	'openidchooseinstructions' => 'Кожен користувач повинен мати псевдонім; 
ви можете вибрати один з представлених нижче.',
	'openidchoosefull' => "Ваше повне ім'я ($1)",
	'openidchooseurl' => 'Ім`я, отримане з вашого OpenID ($1)',
	'openidchooseauto' => "Автоматично створене ім'я ($1)",
	'openidchoosemanual' => "Ім'я на ваш вибір:",
	'openidchooseexisting' => 'Існуючий акаунт на цій вікі:',
	'openidchoosepassword' => 'пароль:',
	'openidconvertinstructions' => 'Ця форма дозволяє вам змінити використання акаунту на використання адреси OpenID.',
	'openidconvertsuccess' => 'Успішне перетворення в OpenID',
	'openidconvertsuccesstext' => 'Ви успішно перетворили ваш OpenID в $1.',
	'openidconvertyourstext' => 'Це вже ваш OpenID.',
	'openidconvertothertext' => 'Це чужий OpenID.',
	'openidalreadyloggedin' => "'''Ви вже ввійшли, $1!'''

Якщо ви бажаєте використовувати в майбутньому вхід через OpenID, ви можете [[Special:OpenIDConvert|перетворити ваш акаунт для використання в OpenID]].",
	'tog-hideopenid' => 'Приховувати ваш <a href="http://openid.net/">OpenID</a> на вашій сторінці користувача, якщо ви ввійшли з допомогою OpenID.',
	'openidnousername' => "Не вказано ім'я користувача.",
	'openidbadusername' => "Зазначено невірне ім'я користувача.",
	'openidautosubmit' => 'Ця сторінка містить форму, яка повинна бути автоматично відправлена, якщо у вас включений JavaScript. 
Якщо цього не сталося, спробуйте натиснути на кнопку «Продовжити».',
	'openidclientonlytext' => 'Ви не можете використовувати акаунти з цієї вікі, як OpenID на іншому сайті.',
	'openidloginlabel' => 'Адреса OpenID',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'openid-desc' => "Entra con [http://openid.net/ OpenID] in te la wiki, e entra in tei altri siti web che dòpara OpenID co' na utensa wiki",
	'openidlogin' => 'Acesso con OpenID',
	'openidfinish' => "Conpleta l'acesso OpenID",
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
	'openidnotavailable' => "El to soranòme preferìo ($1) el xe xà doparà da n'antro utente.",
	'openidnotprovided' => "El to server OpenID no'l gà fornìo un soranòme (o parché no'l gà podesto, o parché ti ti gà dito de no farlo).",
	'openidchooseinstructions' => 'Tuti i utenti i gà da verghe un soranòme;
te pol tórghene uno da le opzioni seguenti.',
	'openidchoosefull' => 'El to nome par intiero ($1)',
	'openidchooseurl' => 'Un nome sielto dal to OpenID ($1)',
	'openidchooseauto' => 'Un nome generà automaticamente ($1)',
	'openidchoosemanual' => 'Un nome a sielta tua:',
	'openidchooseexisting' => 'Na utensa esistente su sta wiki:',
	'openidchoosepassword' => 'password:',
	'openidconvertinstructions' => 'Sto modulo el te parmete de canbiar la to utensa par doparar un URL OpenID.',
	'openidconvertsuccess' => 'Convertìo con successo a OpenID',
	'openidconvertsuccesstext' => 'El to OpenID el xe stà convertìo a $1.',
	'openidconvertyourstext' => 'Sto chì el xe xà el to OpenID.',
	'openidconvertothertext' => "Sto chì el xe l'OpenID de calchidun altro.",
	'openidalreadyloggedin' => "'''Te sì xà entrà, $1!'''

Se ti vol doparar OpenID par entrar in futuro, te pol [[Special:OpenIDConvert|convertir la to utensa par doparar OpenID]].",
	'tog-hideopenid' => 'Scondi el to <a href="http://openid.net/">OpenID</a> su la to pàxena utente, se te fè el login con OpenID.',
	'openidnousername' => 'Nissun nome utente indicà.',
	'openidbadusername' => "El nome utente indicà no'l xe mia valido.",
	'openidautosubmit' => 'Sta pàxena la include un modulo che\'l dovarìa èssar invià automaticamente se ti gà JavaScript ativà. Se no, próa a strucar el boton \\"Continua\\".',
	'openidclientonlytext' => 'No te podi doparar le utense de sta wiki come OpenID su de un altro sito.',
	'openidloginlabel' => 'URL OpenID',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'openid-desc' => 'Đăng nhập vào wiki dùng [http://openid.net/ OpenID] và đăng nhập vào các website nhận OpenID dùng tài khoản wiki',
	'openidlogin' => 'Đăng nhập dùng OpenID',
	'openidfinish' => 'Đăng nhập dùng OpenID xong',
	'openidserver' => 'Dịch vụ OpenID',
	'openidxrds' => 'Tập tin Yadis',
	'openidconvert' => 'Chuyển đổi ID Mở',
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
	'openidusernameprefix' => 'Thành viên ID Mở',
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
	'openidnotavailable' => 'Tên hiệu mà bạn muốn sử dụng, “$1”, đã được sử dụng bởi người khác.',
	'openidnotprovided' => 'Dịch vụ OpenID của bạn chưa cung cấp tên hiệu, hoặc vì nó không có khả năng này, hoặc bạn đã tắt tính năng tên hiệu.',
	'openidchooseinstructions' => 'Mọi người dùng cần có tên hiệu; bạn có thể chọn tên hiệu ở dưới.',
	'openidchoosefull' => 'Tên đầy đủ của bạn ($1)',
	'openidchooseurl' => 'Tên bắt nguồn từ OpenID của bạn ($1)',
	'openidchooseauto' => 'Tên tự động ($1)',
	'openidchoosemanual' => 'Tên khác:',
	'openidchooseexisting' => 'Một tài khoản hiện có trên wiki này:',
	'openidchoosepassword' => 'mật khẩu:',
	'openidconvertinstructions' => 'Mẫu này cho phép bạn thay đổi tài khoản người dùng của bạn để sử dụng một địa chỉ URL ID Mở.',
	'openidconvertsuccess' => 'Đã chuyển đổi sang ID Mở thành công',
	'openidconvertsuccesstext' => 'Bạn đã chuyển đổi ID Mở của bạn sang $1 thành công.',
	'openidconvertyourstext' => 'Đó đã là ID Mở của bạn.',
	'openidconvertothertext' => 'Đó là ID Mở của một người nào khác.',
	'openidalreadyloggedin' => "'''Bạn đã đăng nhập rồi, $1!'''

Nếu bạn muốn sử dụng ID Mở để đăng nhập vào lần sau, bạn có thể [[Special:OpenIDConvert|chuyển đổi tài khoản của bạn để dùng ID Mở]].",
	'tog-hideopenid' => 'Ẩn <a href="http://openid.net/">ID Mở</a> của bạn khỏi trang thành viên, nếu bạn đăng nhập bằng ID Mở.',
	'openidnousername' => 'Chưa chỉ định tên người dùng.',
	'openidbadusername' => 'Tên người dùng không hợp lệ.',
	'openidautosubmit' => 'Trang này có một mẫu sẽ tự động đăng lên nếu bạn kích hoạt JavaScript.
Nếu không, hãy thử nút \\"Tiếp tục\\".',
	'openidclientonlytext' => 'Bạn không thể sử dụng tài khoản tại wiki này như ID Mở tại trang khác.',
	'openidloginlabel' => 'Địa chỉ OpenID',
	'openidlogininstructions' => "{{SITENAME}} hỗ trợ chuẩn [http://openid.net/ OpenID] (ID Mở) để đăng nhập một lần giữa các trang web.
ID Mở cho phép bạn đăng nhập vào nhiều trang web khác nhau mà không phải sử dụng mật khẩu khác nhau tại mỗi trang.
(Xem [http://en.wikipedia.org/wiki/OpenID bài viết về ID Mở của Wikipedia] để biết thêm chi tiết.)

Nếu bạn đã có một tài khoản tại {{SITENAME}}, bạn có thể [[Special:UserLogin|đăng nhập]] bằng tên người dùng và mật khẩu của bạn như thông thường.
Để dùng ID Mở vào lần sau, bạn có thể [[Special:OpenIDConvert|chuyển đổi tài khoản của bạn sang ID Mở]] sau khi đã đăng nhập bình thường.

Có nhiều [http://wiki.openid.net/Public_OpenID_providers nhà cung cấp ID Mở Công cộng], và có thể bạn đã có một tài khoản kích hoạt ID Mở tại dịch vụ khác.

; Các wiki khác : Nếu bạn có tài khoản tại một wiki có sử dụng ID Mở, như [http://wikitravel.org/ Wikitravel], [http://www.wikihow.com/ wikiHow], [http://vinismo.com/ Vinismo], [http://aboutus.org/ AboutUs] hay [http://kei.ki/ Keiki], bạn có thể đặp nhập vào {{SITENAME}} bằng cách gõ vào '''URL đầy đủ''' của trang người dùng của bạn tại wiki đó trong hộp ở phía trên. Ví dụ, ''<nowiki>http://kei.ki/en/User:Evan</nowiki>''.
; [http://openid.yahoo.com/ Yahoo!] : Nếu bạn có tài khoản Yahoo!, bạn có thể đăng nhập vào trang này bằng cách gõ vào ID Mở do Yahoo! cung cấp vào hộp phía trên. Địa chỉ URL của Yahoo! OpenID có dạng ''<nowiki>https://me.yahoo.com/yourusername</nowiki>''.
; [http://dev.aol.com/aol-and-63-million-openids AOL] : Nếu bạn có tài khoản [http://www.aol.com/ AOL], như một tài khoản [http://www.aim.com/ AIM], bạn có thể đăng nhập vào {{SITENAME}} bằng cách gõ ID Mở do AOL cung cấp cho bạn vào hộp phía trên. Địa chỉ URL của Open ID AOL có dạng ''<nowiki>http://openid.aol.com/yourusername</nowiki>''. Tên người dùng của bạn nên tất cả là chữ thường, không có khoảng cách.
; [http://bloggerindraft.blogspot.com/2008/01/new-feature-blogger-as-openid-provider.html Blogger], [http://faq.wordpress.com/2007/03/06/what-is-openid/ Wordpress.com], [http://www.livejournal.com/openid/about.bml LiveJournal], [http://bradfitz.vox.com/library/post/openid-for-vox.html Vox] : Nếu bạn có blog tại bất kỳ một dịch nào bên trên, gõ vào địa chỉ URL blog của bạn vào hộp phía trên. Ví dụ, ''<nowiki>http://yourusername.blogspot.com/</nowiki>'', ''<nowiki>http://yourusername.wordpress.com/</nowiki>'', ''<nowiki>http://yourusername.livejournal.com/</nowiki>'', hay ''<nowiki>http://yourusername.vox.com/</nowiki>''.",
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

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'openidlogin' => '使用OpenID登陆',
	'openidfinish' => '结束OpenID登陆',
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
	'openidserverlogininstructions' => '请在下面输入您的密码以便以用户$2登陆$3 (用户页面$1)。',
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
	'openidnotavailable' => '您选择的昵称($1)已经被其他用户使用。',
	'openidnotprovided' => '您的OpenID服务器没有提供昵称（可能无法提供，或者您选择不提供）。',
	'openidchooseinstructions' => '所有的用户都需要提供昵称；
您可以从下面任选一个。',
	'openidchoosefull' => '您的全名（$1）',
	'openidchooseurl' => '从您的OpenID获取的名称（$1）',
	'openidchooseauto' => '自动生成的名称（$1）',
	'openidchoosemanual' => '您选择的名称：',
	'openidchooseexisting' => '本维基已经存在的帐户：',
	'openidchoosepassword' => '密码：',
	'openidconvertinstructions' => '本表单可以将您的用户账号修改为OpenID地址。',
	'openidconvertsuccess' => '成功转换为OpenID',
	'openidconvertsuccesstext' => '您已经成功的将您的OpenID转化为$1。',
	'openidconvertyourstext' => '这已经是您的OpenID。',
	'openidconvertothertext' => '这是别人的OpenID。',
	'openidalreadyloggedin' => "'''您已经成功登陆了，$1！'''

如果您想以后使用OpenID登陆，您可以[[Special:OpenIDConvert|转换您的帐户使用OpenID]]。",
	'tog-hideopenid' => '如果使用OpenID登陆，您可以在您的用户页隐藏您的<a href="http://openid.net/">OpenID</a>。',
	'openidnousername' => '没有指定用户名。',
	'openidbadusername' => '指定的用户名是错误的。',
	'openidautosubmit' => '本页包含的表单在启用JavaScript的情况下可以自动提交。
如果没有自动提交，请按 \\"继续\\" 按钮。',
	'openidloginlabel' => 'OpenID地址',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'openidserver' => 'OpenID伺服器',
	'openidconvert' => 'OpenID轉換器',
	'openiderror' => '驗證錯誤',
	'openidnickname' => '暱稱',
	'openidfullname' => '全名',
	'openidchoosefull' => '您的全名 ($1)',
	'openidchoosepassword' => '密碼：',
	'openidconvertyourstext' => '這已是您的OpenID了。',
	'openidloginlabel' => 'OpenID網址',
);

