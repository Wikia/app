<?php

/* Messages for Special:SignDocument.
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'signdocument'         => 'Sign document',
	'sign-nodocselected'   => 'Please select the document you wish to sign.',
	'sign-selectdoc'       => 'Document:',
	'sign-docheader'       => '<div class="noarticletext">Please use this form to sign the document "[[$1]]," shown below.
Please read through the entire document, and if you wish to indicate your support for it, please fill in the required fields to sign it.</div>',
	'sign-error-nosuchdoc' => 'The document you requested ($1) does not exist.',
	'sign-realname'        => 'Name:',
	'sign-address'         => 'Street address:',
	'sign-city'            => 'City:',
	'sign-state'           => 'State:',
	'sign-zip'             => 'Zip code:',
	'sign-country'         => 'Country:',
	'sign-phone'           => 'Phone number:',
	'sign-bday'            => 'Age:',
	'sign-email'           => 'E-mail address:',
	'sign-indicates-req'   => '<small><i><font color="red">*</font> indicates required field.</i></small>',
	'sign-hide-note'       => '<small><i><font color="red">**</font> Note: Unlisted information will still be visible to moderators.</i></small>',
	'sign-list-anonymous'  => 'List anonymously',
	'sign-list-hideaddress'=> 'Do not list address',
	'sign-list-hideextaddress'=>'Do not list city, state, zip, or country',
	'sign-list-hidephone'  => 'Do not list phone',
	'sign-list-hidebday'   => 'Do not list age',
	'sign-list-hideemail'  => 'Do not list e-mail',
	'sign-submit'          => 'Sign document',
	'sign-information'     => '<div class="noarticletext">Thank you for taking the time to read through this document.
If you agree with it, please indicate your support by filling in the required fields below and clicking "Sign document".
Please ensure that your personal information is correct and that we have some way to contact you to verify your identity.
Note that your IP address and other identifying information will be recorded by this form and used by moderators to eliminate duplicate signatures and confirm the correctness of your personal information.
As the use of open and anonymizing proxies inhibits our ability to perform this task, signatures from such proxies will likely not be counted.
If you are currently connected through a proxy server, please disconnect from it and use a standard connection while signing.</div>

$1',
	'sig-success'               => 'You have successfully signed the document.',
	'sign-view-selectfields'    => '<b>Fields to display:</b>',
	'sign-viewfield-entryid'    => 'Entry ID',
	'sign-viewfield-timestamp'  => 'Timestamp',
	'sign-viewfield-realname'   => 'Name',
	'sign-viewfield-address'    => 'Address',
	'sign-viewfield-city'       => 'City',
	'sign-viewfield-state'      => 'State',
	'sign-viewfield-country'    => 'Country',
	'sign-viewfield-zip'        => 'Zip',
	'sign-viewfield-ip'         => 'IP address',
	'sign-viewfield-agent'      => 'User agent',
	'sign-viewfield-phone'      => 'Phone',
	'sign-viewfield-email'      => 'E-mail',
	'sign-viewfield-age'        => 'Age',
	'sign-viewfield-options'    => 'Options',
	'sign-viewsigs-intro'       => 'Shown below are the signatures recorded for <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen'=>'Signing is currently enabled for this document.',
	'sign-sigadmin-close'       => 'Disable signing',
	'sign-sigadmin-currentlyclosed'=>'Signing is currently disabled for this document.',
	'sign-sigadmin-open'        => 'Enable signing',
	'sign-signatures'           => 'Signatures',
	'sign-sigadmin-closesuccess'=> 'Signing successfully disabled.',
	'sign-sigadmin-opensuccess' => 'Signing successfully enabled.',
	'sign-viewsignatures'       => 'view signatures',
	'sign-closed'               => 'closed',
	'sign-error-closed'         => 'Signing of this document is currently disabled.',
	'sig-anonymous'             => '<i>Anonymous</i>',
	'sig-private'               => '<i>Private</i>',
	'sign-sigdetails'           => 'Signature details',
	'sign-emailto'              => '<a href="mailto:$1">$1</a>',
	'sign-iptools'              => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|talk]] • <!--
-->[[Special:Contributions/$1|contribs]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|block user]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} block log] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} checkip])<!--
--></span>',
	'sign-viewfield-stricken'      => 'Stricken',
	'sign-viewfield-reviewedby'    => 'Reviewer',
	'sign-viewfield-reviewcomment' => 'Comment',
	'sign-detail-uniquequery'      => 'Similar entities',
	'sign-detail-uniquequery-run'  => 'Run query',
	'sign-detail-strike'           => 'Strike signature',
	'sign-reviewsig'               => 'Review signature',
	'sign-review-comment'          => 'Comment',
	'sign-submitreview'            => 'Submit review',
	'sign-uniquequery-similarname' => 'Similar name',
	'sign-uniquequery-similaraddress'=> 'Similar address',
	'sign-uniquequery-similarphone'=> 'Similar phone',
	'sign-uniquequery-similaremail'=> 'Similar email',
	'sign-uniquequery-1signed2'    => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] signed [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 */
$messages['qqq'] = array(
	'signdocument' => '{{Identical|Sign document}}',
	'sign-realname' => '{{Identical|Name}}',
	'sign-city' => '{{Identical|City}}',
	'sign-state' => '{{Identical|State}}',
	'sign-country' => '{{Identical|Country}}',
	'sign-phone' => '{{Identical|Phone number}}',
	'sign-email' => '{{Identical|E-mail address}}',
	'sign-submit' => '{{Identical|Sign document}}',
	'sign-viewfield-realname' => '{{Identical|Name}}',
	'sign-viewfield-city' => '{{Identical|City}}',
	'sign-viewfield-state' => '{{Identical|State}}',
	'sign-viewfield-country' => '{{Identical|Country}}',
	'sign-viewfield-ip' => '{{Identical|IP Address}}',
	'sign-viewfield-agent' => '{{Identical|User agent}}',
	'sign-viewfield-email' => '{{Identical|E-mail}}',
	'sign-viewfield-options' => '{{Identical|Options}}',
	'sig-private' => '{{Identical|Private}}',
	'sign-viewfield-reviewedby' => '{{Identical|Reviewer}}',
	'sign-viewfield-reviewcomment' => '{{Identical|Comment}}',
	'sign-review-comment' => '{{Identical|Comment}}',
	'sign-submitreview' => '{{Identical|Submit review}}',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'sign-viewfield-email' => 'Meli hila',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'sign-realname' => 'Naam:',
	'sign-city' => 'Stad:',
	'sign-country' => 'Land:',
	'sign-email' => 'E-pos adres:',
	'sign-viewfield-realname' => 'Naam',
	'sign-viewfield-city' => 'Stad',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-email' => 'E-pos',
	'sign-viewfield-options' => 'Opsies',
	'sign-viewfield-reviewcomment' => 'Opmerking',
	'sign-review-comment' => 'Opmerking',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'sign-realname' => 'ስም:',
	'sign-city' => 'ከተማ:',
	'sign-country' => 'ሀገር:',
	'sign-phone' => 'የስልክ ቁጥር፦',
	'sign-bday' => 'ዕድሜ፦',
	'sign-email' => 'የኢ-ሜል አድራሻ:',
	'sign-viewfield-realname' => 'ስም',
	'sign-viewfield-city' => 'ከተማ',
	'sign-viewfield-country' => 'ሀገር',
	'sign-viewfield-phone' => 'ስልክ',
	'sign-viewfield-email' => 'ኢ-ሜል',
	'sign-viewfield-reviewcomment' => 'ማጠቃለያ',
	'sign-review-comment' => 'ማጠቃለያ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'sign-realname' => 'Nombre:',
	'sign-viewfield-realname' => 'Nombre',
	'sign-viewfield-reviewedby' => 'Rebisador',
	'sign-viewfield-reviewcomment' => 'Comentario',
	'sign-review-comment' => 'Comentario',
	'sign-submitreview' => 'Nimbiar rebisión',
);

/** Old English (Anglo-Saxon) */
$messages['ang'] = array(
	'sign-realname' => 'Nama:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author ترجمان05
 */
$messages['ar'] = array(
	'signdocument' => 'توقيع الوثيقة',
	'sign-nodocselected' => 'من فضلك اختر الوثيقة التي تود توقيعها.',
	'sign-selectdoc' => 'وثيقة:',
	'sign-docheader' => '<div class="noarticletext">من فضلك استخدم هذه الاستمارة لتوقيع الوثيقة "[[$1]]," المعروضة بالأسفل.
من فضلك اقرأ الوثيقة كلها، وإذا كنت تود التعبير عن تأييدك لها، من فضلك املأ الحقول المطلوبة لتوقعها.</div>',
	'sign-error-nosuchdoc' => 'الوثيقة التي طلبتها ($1) غير موجودة.',
	'sign-realname' => 'الاسم:',
	'sign-address' => 'عنوان الشارع:',
	'sign-city' => 'المدينة:',
	'sign-state' => 'الولاية:',
	'sign-zip' => 'كود الرقم البريدي:',
	'sign-country' => 'البلد:',
	'sign-phone' => 'رقم الهاتف:',
	'sign-bday' => 'العمر:',
	'sign-email' => 'عنوان البريد الإلكتروني:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> يشير إلى حقل مطلوب.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> ملاحظة: المعلومات غير المعروضة ستظل مرئية للمديرين.</i></small>',
	'sign-list-anonymous' => 'عرض كمجهول',
	'sign-list-hideaddress' => 'لا تعرض العنوان',
	'sign-list-hideextaddress' => 'لا تعرض المدينة، الولاية، الرقم البريدي، أو البلد',
	'sign-list-hidephone' => 'لا تعرض الهاتف',
	'sign-list-hidebday' => 'لا تعرض العمر',
	'sign-list-hideemail' => 'لا تعرض البريد الإلكتروني',
	'sign-submit' => 'توقيع الوثيقة',
	'sign-information' => '<div class="noarticletext">شكرا لك لقضائك وقتا في قراءة هذه الوثيقة.
لو أنك تتفق معها، من فضلك عبر عن تأييدك بواسطة ملأ الحقول المطلوبة بالأسفل وضغط "توقيع الوثيقة."
من فضلك تأكد من أن معلوماتك الشخصية صحيحة وأننا نملك وسيلة للاتصال بك للتأكد من هويتك.
لاحظ أن عنوان الأيبي الخاص بك ومعلومات التعريف الأخرى سيتم تسجيلها بواسطة هذه الاستمارة وسيتم استخدامها بواسطة المديرين لتحجيم التوقيعات المكررة وتأكيد صحة معلوماتك الشخصية.
بما أن استخدام البروكسيهات المجهولة والمفتوحة يمنع قدرتنا على أداء هذه المهمة، التوقيعات من هذه البروكسيهات على الأرجح لن يتم احتسابها.
لو أنك موصول حاليا بواسطة خادم بروكسي، من فضلك اقطع التوصيل منه واستخدم اتصالا قياسيا أثناء التوقيع.</div>

$1',
	'sig-success' => 'لقد وقعت الوثيقة بنجاح.',
	'sign-view-selectfields' => '<b>الحقول للعرض:</b>',
	'sign-viewfield-entryid' => 'رقم المدخلة',
	'sign-viewfield-timestamp' => 'طابع الزمن',
	'sign-viewfield-realname' => 'اسم',
	'sign-viewfield-address' => 'عنوان',
	'sign-viewfield-city' => 'مدينة',
	'sign-viewfield-state' => 'ولاية',
	'sign-viewfield-country' => 'بلد',
	'sign-viewfield-zip' => 'الرقم البريدي',
	'sign-viewfield-ip' => 'عنوان الأيبي',
	'sign-viewfield-agent' => 'وكيل المستخدم',
	'sign-viewfield-phone' => 'هاتف',
	'sign-viewfield-email' => 'بريد إلكتروني',
	'sign-viewfield-age' => 'عمر',
	'sign-viewfield-options' => 'اختيارات',
	'sign-viewsigs-intro' => 'معروض بالأسفل التوقيعات المسجلة ل<span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'التوقيع مفعل حاليا لهذه الوثيقة.',
	'sign-sigadmin-close' => 'عطل التوقيع',
	'sign-sigadmin-currentlyclosed' => 'التوقيع معطل حاليا لهذه الوثيقة.',
	'sign-sigadmin-open' => 'فعل التوقيع',
	'sign-signatures' => 'توقيعات',
	'sign-sigadmin-closesuccess' => 'تم تعطيل التوقيع بنجاح.',
	'sign-sigadmin-opensuccess' => 'تم تفعيل التوقيع بنجاح.',
	'sign-viewsignatures' => 'عرض التوقيعات',
	'sign-closed' => 'مغلق',
	'sign-error-closed' => 'توقيع هذه الوثيقة معطل حاليا.',
	'sig-anonymous' => '<i>مجهول</i>',
	'sig-private' => '<i>خاص</i>',
	'sign-sigdetails' => 'تفاصيل التوقيع',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|نقاش]] • <!--
-->[[Special:Contributions/$1|مساهمات]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|منع المستخدم]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} سجل المنع] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} تدقيق الأيبي])<!--
--></span>',
	'sign-viewfield-stricken' => 'مشطوب',
	'sign-viewfield-reviewedby' => 'مراجع',
	'sign-viewfield-reviewcomment' => 'تعليق',
	'sign-detail-uniquequery' => 'كيانات مشابهة',
	'sign-detail-uniquequery-run' => 'تنفيذ الاستعلام',
	'sign-detail-strike' => 'شطب التوقيع',
	'sign-reviewsig' => 'راجع التوقيع',
	'sign-review-comment' => 'تعليق',
	'sign-submitreview' => 'تنفيذ المراجعة',
	'sign-uniquequery-similarname' => 'اسم مشابه',
	'sign-uniquequery-similaraddress' => 'عنوان مشابه',
	'sign-uniquequery-similarphone' => 'هاتف مشابه',
	'sign-uniquequery-similaremail' => 'بريد إلكتروني مشابه',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] وقع [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'signdocument' => 'توقيع الوثيقة',
	'sign-nodocselected' => 'من فضلك اختر الوثيقة التى تود توقيعها.',
	'sign-selectdoc' => 'وثيقة:',
	'sign-docheader' => '<div class="noarticletext">من فضلك استخدم هذه الاستمارة لتوقيع الوثيقة "[[$1]]," المعروضة بالأسفل.
من فضلك اقرأ الوثيقة كلها، وإذا كنت تود التعبير عن تأييدك لها، من فضلك املأ الحقول المطلوبة لتوقعها.</div>',
	'sign-error-nosuchdoc' => 'الوثيقة التى طلبتها ($1) غير موجودة.',
	'sign-realname' => 'الاسم:',
	'sign-address' => 'عنوان الشارع:',
	'sign-city' => 'المدينة:',
	'sign-state' => 'الولاية:',
	'sign-zip' => 'كود الرقم البريدي:',
	'sign-country' => 'البلد:',
	'sign-phone' => 'رقم الهاتف:',
	'sign-bday' => 'العمر:',
	'sign-email' => 'عنوان البريد الإلكتروني:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> يشير إلى حقل مطلوب.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> ملاحظة: المعلومات غير المعروضة ستظل مرئية للمديرين.</i></small>',
	'sign-list-anonymous' => 'عرض كمجهول',
	'sign-list-hideaddress' => 'لا تعرض العنوان',
	'sign-list-hideextaddress' => 'لا تعرض المدينة، الولاية، الرقم البريدي، أو البلد',
	'sign-list-hidephone' => 'لا تعرض الهاتف',
	'sign-list-hidebday' => 'لا تعرض العمر',
	'sign-list-hideemail' => 'لا تعرض البريد الإلكتروني',
	'sign-submit' => 'توقيع الوثيقة',
	'sign-information' => '<div class="noarticletext">شكرا لك لقضائك وقتا فى قراءة هذه الوثيقة.
لو أنك تتفق معها، من فضلك عبر عن تأييدك بواسطة ملأ الحقول المطلوبة بالأسفل وضغط "توقيع الوثيقة."
من فضلك تأكد من أن معلوماتك الشخصية صحيحة وأننا نملك وسيلة للاتصال بك للتأكد من هويتك.
لاحظ أن عنوان الأيبى الخاص بك ومعلومات التعريف الأخرى سيتم تسجيلها بواسطة هذه الاستمارة وسيتم استخدامها بواسطة المديرين لتحجيم التوقيعات المكررة وتأكيد صحة معلوماتك الشخصية.
بما أن استخدام البروكسيهات المجهولة والمفتوحة يمنع قدرتنا على أداء هذه المهمة، التوقيعات من هذه البروكسيهات على الأرجح لن يتم احتسابها.
لو أنك موصول حاليا بواسطة خادم بروكسي، من فضلك اقطع التوصيل منه واستخدم اتصالا قياسيا أثناء التوقيع.</div>

$1',
	'sig-success' => 'لقد وقعت الوثيقة بنجاح.',
	'sign-view-selectfields' => '<b>الحقول للعرض:</b>',
	'sign-viewfield-entryid' => 'رقم المدخلة',
	'sign-viewfield-timestamp' => 'طابع الزمن',
	'sign-viewfield-realname' => 'اسم',
	'sign-viewfield-address' => 'عنوان',
	'sign-viewfield-city' => 'مدينة',
	'sign-viewfield-state' => 'ولاية',
	'sign-viewfield-country' => 'بلد',
	'sign-viewfield-zip' => 'الرقم البريدي',
	'sign-viewfield-ip' => 'عنوان الأيبي',
	'sign-viewfield-agent' => 'وكيل المستخدم',
	'sign-viewfield-phone' => 'هاتف',
	'sign-viewfield-email' => 'بريد إلكتروني',
	'sign-viewfield-age' => 'عمر',
	'sign-viewfield-options' => 'اختيارات',
	'sign-viewsigs-intro' => 'معروض بالأسفل التوقيعات المسجلة ل<span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'التوقيع مفعل حاليا لهذه الوثيقة.',
	'sign-sigadmin-close' => 'عطل التوقيع',
	'sign-sigadmin-currentlyclosed' => 'التوقيع معطل حاليا لهذه الوثيقة.',
	'sign-sigadmin-open' => 'فعل التوقيع',
	'sign-signatures' => 'توقيعات',
	'sign-sigadmin-closesuccess' => 'تم تعطيل التوقيع بنجاح.',
	'sign-sigadmin-opensuccess' => 'تم تفعيل التوقيع بنجاح.',
	'sign-viewsignatures' => 'عرض التوقيعات',
	'sign-closed' => 'مغلق',
	'sign-error-closed' => 'توقيع هذه الوثيقة معطل حاليا.',
	'sig-anonymous' => '<i>مجهول</i>',
	'sig-private' => '<i>خاص</i>',
	'sign-sigdetails' => 'تفاصيل التوقيع',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|نقاش]] • <!--
-->[[Special:Contributions/$1|مساهمات]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|منع اليوزر]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} سجل المنع] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} تشييك الأى بى])<!--
--></span>',
	'sign-viewfield-stricken' => 'مشطوب',
	'sign-viewfield-reviewedby' => 'مراجع',
	'sign-viewfield-reviewcomment' => 'تعليق',
	'sign-detail-uniquequery' => 'كيانات مشابهة',
	'sign-detail-uniquequery-run' => 'تنفيذ الاستعلام',
	'sign-detail-strike' => 'شطب التوقيع',
	'sign-reviewsig' => 'راجع التوقيع',
	'sign-review-comment' => 'تعليق',
	'sign-submitreview' => 'تنفيذ المراجعة',
	'sign-uniquequery-similarname' => 'اسم مشابه',
	'sign-uniquequery-similaraddress' => 'عنوان مشابه',
	'sign-uniquequery-similarphone' => 'هاتف مشابه',
	'sign-uniquequery-similaremail' => 'بريد إلكترونى مشابه',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] وقع [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'signdocument' => 'Pirmahan an Dokumento',
	'sign-selectdoc' => 'Dokumento:',
	'sign-realname' => 'Pangaran:',
	'sign-city' => 'Ciudad:',
	'sign-country' => 'Nacion:',
	'sign-viewfield-realname' => 'Pangaran',
	'sign-viewfield-address' => 'Istaran',
	'sign-viewfield-city' => 'Ciudad',
	'sign-viewfield-country' => 'Nacion',
	'sign-viewfield-age' => 'Edad',
	'sign-viewfield-reviewcomment' => 'Komento',
	'sign-review-comment' => 'Komento',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'sign-viewfield-realname' => 'Імя',
	'sign-viewfield-reviewcomment' => 'Камэнтар',
	'sign-review-comment' => 'Камэнтар',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'sign-selectdoc' => 'Документ:',
	'sign-error-nosuchdoc' => 'Документът, който пожелахте ($1) не съществува.',
	'sign-realname' => 'Име:',
	'sign-address' => 'Адрес:',
	'sign-city' => 'Град:',
	'sign-zip' => 'Пощенски код:',
	'sign-country' => 'Държава:',
	'sign-phone' => 'Телефонен номер:',
	'sign-bday' => 'Възраст:',
	'sign-email' => 'Адрес за е-поща:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> задължително поле</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Забележка: Информацията, която не се показана ще бъде видима за модераторите.</i></small>',
	'sign-list-hideaddress' => 'Без показване на адрес',
	'sign-list-hideextaddress' => 'Без показване на град, щат, пощенски код или държава',
	'sign-list-hidephone' => 'Без показване на телефон',
	'sign-list-hidebday' => 'Без показване на възраст',
	'sign-list-hideemail' => 'Без показване на е-поща',
	'sign-view-selectfields' => '<b>Полета за показване:</b>',
	'sign-viewfield-realname' => 'Име',
	'sign-viewfield-address' => 'Адрес',
	'sign-viewfield-city' => 'Град',
	'sign-viewfield-country' => 'Държава',
	'sign-viewfield-zip' => 'Пощенски код',
	'sign-viewfield-ip' => 'IP адрес',
	'sign-viewfield-phone' => 'Телефон',
	'sign-viewfield-email' => 'Е-поща',
	'sign-viewfield-age' => 'Възраст',
	'sign-viewfield-options' => 'Настройки',
	'sign-error-closed' => 'В момента подписването на този документ не е позволено.',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|беседа]] • <!--
-->[[Special:Contributions/$1|приноси]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|блокиране]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} дневник на блокиранията] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} проверка])<!--
--></span>',
	'sign-viewfield-reviewcomment' => 'Коментар',
	'sign-detail-strike' => 'Задраскване на подписа',
	'sign-review-comment' => 'Коментар',
	'sign-uniquequery-similarname' => 'Подобно име',
	'sign-uniquequery-similaraddress' => 'Подобен адрес',
	'sign-uniquequery-similarphone' => 'Подобен телефон',
	'sign-uniquequery-similaremail' => 'Подобна е-поща',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] подписа [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'sign-realname' => 'Ime:',
	'sign-viewfield-realname' => 'Ime',
	'sign-viewfield-ip' => 'IP adresa',
	'sign-viewfield-options' => 'Opcije',
	'sign-viewfield-reviewcomment' => 'Komentar',
	'sign-review-comment' => 'Komentar',
);

/** Catalan (Català)
 * @author Jordi Roqué
 */
$messages['ca'] = array(
	'sign-viewfield-options' => 'Opcions',
	'sign-viewfield-reviewcomment' => 'Comentari',
	'sign-review-comment' => 'Comentari',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'sign-realname' => 'Navn:',
	'sign-city' => 'By:',
	'sign-country' => 'Land:',
	'sign-viewfield-realname' => 'Navn',
	'sign-viewfield-city' => 'By',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-ip' => 'IP-adresse',
	'sign-viewfield-email' => 'E-mail',
	'sig-private' => '<i>Privat</i>',
);

/** German (Deutsch)
 * @author Imre
 * @author Leithian
 * @author Melancholie
 * @author Revolus
 */
$messages['de'] = array(
	'signdocument' => 'Dokument signieren',
	'sign-nodocselected' => 'Bitte wähle das zu signierende Dokument aus.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => '<div class="noarticletext">Bitte benutze dieses Formular, um das hierunter angezeigte Dokument „[[$1]]“ zu signieren.
Bitte lies das gesammte Dokument und wenn du ihm deine Zustimmung gibt, fülle bitte die nötigen Felder aus, um es zu signieren.',
	'sign-error-nosuchdoc' => 'Das angeforderte Dokument ($1) existiert nicht.',
	'sign-realname' => 'Name:',
	'sign-address' => 'Straße:',
	'sign-city' => 'Stadt:',
	'sign-state' => 'Bundesland:',
	'sign-zip' => 'Postleitzahl:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telefonnummer:',
	'sign-bday' => 'Alter:',
	'sign-email' => 'E-Mail-Adresse:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> benötigtes Feld.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Beachte: Unaufgelistete Informationen sind trotzdem für Moderatoren sichtbar.</i></small>',
	'sign-list-anonymous' => 'Anonym auflisten',
	'sign-list-hideaddress' => 'Adresse nicht auflisten',
	'sign-list-hideextaddress' => 'Stadt, Staat, PLZ oder Land nicht auflisten',
	'sign-list-hidephone' => 'Telefonnummer nicht auflisten',
	'sign-list-hidebday' => 'Alter nicht auflisten',
	'sign-list-hideemail' => 'E-Mail-Adresse nicht auflisten',
	'sign-submit' => 'Dokument unterzeichnen',
	'sign-information' => '<div class="noarticletext">Danke, dass du dir die Zeit genommen hast, dieses Dokument durchzulesen.
Wenn du ihm zustimmst, zeige dies bitte indem du die benötigten Felder unten ausfüllst und anschließend auf „Dokument unterschreiben“ klickst.
Bitte stelle sicher, dass deine persönlichen Informationen korrekt sind und dass wir die Möglichkeit haben, dich zur Feststellung deiner Identität zu kontaktieren.
Beachte, dass deine IP-Adresse und andere persönliche Informationen von diesem Formular aufgezeichnet werden und dass sie von Moderatoren benutzt werden, um doppelte Unterschriften zu beseitigen und deine Daten zu verifizieren.
Da die Benutzung offener Proxys uns in der Durchführung dieser Aufgabe einschränkt, werden Unterschriften über solche Proxys in der Regel nicht bearbeitet.
Solltest du gerade über einen solchen Server verbunden sein, trenne bitte die Verbindung von ihm und nutze eine Standardverbindung.</div>

$1',
	'sig-success' => 'Du hast das Dokument erfolgreich unterschrieben.',
	'sign-view-selectfields' => '<b>Anzuzeigende Felder:</b>',
	'sign-viewfield-entryid' => 'Eintragskennung',
	'sign-viewfield-timestamp' => 'Zeitstempel',
	'sign-viewfield-realname' => 'Name',
	'sign-viewfield-address' => 'Adresse',
	'sign-viewfield-city' => 'Stadt',
	'sign-viewfield-state' => 'Bundesland',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-zip' => 'Postleitzahl',
	'sign-viewfield-ip' => 'IP-Adresse',
	'sign-viewfield-agent' => 'Browser',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-Mail',
	'sign-viewfield-age' => 'Alter',
	'sign-viewfield-options' => 'Optionen',
	'sign-viewsigs-intro' => 'Unterhalb werden die für <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span> aufgezeichneten Signaturen aufgelistet.',
	'sign-sigadmin-currentlyopen' => 'Es ist derzeit möglich, dieses Dokument zu signieren.',
	'sign-sigadmin-close' => 'Signieren deaktivieren',
	'sign-sigadmin-currentlyclosed' => 'Es ist derzeit nicht möglich, dieses Dokument zu signieren.',
	'sign-sigadmin-open' => 'Signieren ermöglichen',
	'sign-signatures' => 'Signaturen',
	'sign-sigadmin-closesuccess' => 'Signieren erfolgreich aktiviert.',
	'sign-sigadmin-opensuccess' => 'Signieren erfolgreich aktiviert.',
	'sign-viewsignatures' => 'Signaturen anschauen',
	'sign-closed' => 'geschlossen',
	'sign-error-closed' => 'Es ist derzeit nicht möglich, dieses Dokument zu signieren.',
	'sig-anonymous' => '<i>Anonym</i>',
	'sig-private' => '<i>Privat</i>',
	'sign-sigdetails' => 'Signaturdetails',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|Diskussion]] • <!--
-->[[Special:Contributions/$1|Beiträge]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|Benutzer sperren]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} Sperr-Logbuch] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} Checkuser])<!--
--></span>',
	'sign-viewfield-stricken' => 'Gestrichen',
	'sign-viewfield-reviewedby' => 'Prüfer',
	'sign-viewfield-reviewcomment' => 'Kommentar',
	'sign-detail-uniquequery' => 'Ähnliche Einträge',
	'sign-detail-uniquequery-run' => 'Anfrage laufen lassen',
	'sign-detail-strike' => 'Signatur ausstreichen',
	'sign-reviewsig' => 'Signatur überprüfen',
	'sign-review-comment' => 'Kommentar',
	'sign-submitreview' => 'Bericht absenden',
	'sign-uniquequery-similarname' => 'Ähnlicher Name',
	'sign-uniquequery-similaraddress' => 'Ähnliche Adresse',
	'sign-uniquequery-similarphone' => 'Ähnliche Telefonnummer',
	'sign-uniquequery-similaremail' => 'Ähnliche E-Mail-Adresse',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] signierte [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Revolus
 */
$messages['de-formal'] = array(
	'sign-nodocselected' => 'Bitte wählen Sie das zu signierende Dokument aus.',
	'sign-docheader' => '<div class="noarticletext">Bitte benutzen Sie dieses Formular, um das hierunter angezeigte Dokument „[[$1]]“ zu signieren.
Bitte lesen Sie das gesammte Dokument und wenn Sie ihm Ihre Zustimmung geben, füllen Sie bitte die nötigen Felder aus, um es zu signieren.',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'sign-realname' => 'Όνομα:',
	'sign-city' => 'Πόλη:',
	'sign-country' => 'Χώρα:',
	'sign-phone' => 'Αριθμός τηλεφώνου:',
	'sign-bday' => 'Ηλικία:',
	'sign-email' => 'Διεύθυνση ηλεκτρονικού ταχυδρομείου:',
	'sign-viewfield-realname' => 'Όνομα',
	'sign-viewfield-address' => 'Διεύθυνση',
	'sign-viewfield-city' => 'Πόλη',
	'sign-viewfield-country' => 'Χώρα',
	'sign-viewfield-phone' => 'Τηλέφωνο',
	'sign-viewfield-email' => 'Ηλεκτρονικό ταχυδρομείο',
	'sign-viewfield-age' => 'Ηλικία',
	'sign-viewfield-options' => 'Επιλογές',
	'sign-signatures' => 'Υπογραφές',
	'sig-anonymous' => '<i>Ανώνυμος</i>',
	'sign-viewfield-reviewcomment' => 'Σχόλιο',
	'sign-review-comment' => 'Σχόλιο',
	'sign-uniquequery-similarname' => 'Παρόμοιο όνομα',
	'sign-uniquequery-similaraddress' => 'Παρόμοια διεύθυνση',
	'sign-uniquequery-similarphone' => 'Παρόμοιο τηλέφωνο',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'signdocument' => 'Subskribi dokumenton',
	'sign-nodocselected' => 'Bonvolu selekti la dokumenton kiun vi volas subskribi.',
	'sign-selectdoc' => 'Dosiero:',
	'sign-error-nosuchdoc' => 'La dokumento kiun vi petis ($1) ne ekzistas.',
	'sign-realname' => 'Nomo:',
	'sign-address' => 'Adreso:',
	'sign-city' => 'Urbo:',
	'sign-state' => 'Ŝtato:',
	'sign-zip' => 'Poŝta kodo:',
	'sign-country' => 'Lando:',
	'sign-phone' => 'Nombro de telefono:',
	'sign-bday' => 'Aĝo:',
	'sign-email' => 'Retpoŝta adreso:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> indikas devigan kampon.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font>Notu: Nelistigita informo ankoraŭ estos videbla al administrantoj.</i></small>',
	'sign-list-anonymous' => 'Listigu anonime',
	'sign-list-hideaddress' => 'Ne listigu adreson',
	'sign-list-hideextaddress' => 'Ne montru urbon, subŝtaton, poŝtkodon, aŭ landon',
	'sign-list-hidephone' => 'Ne listigu nombron de telefono',
	'sign-list-hidebday' => 'Ne montru aĝon',
	'sign-list-hideemail' => 'Ne listigu retadreson',
	'sign-submit' => 'Subskribi dokumenton',
	'sig-success' => 'Vi sukcese subskribis la dokumenton.',
	'sign-view-selectfields' => '<b>Kampoj montri:</b>',
	'sign-viewfield-realname' => 'Nomo',
	'sign-viewfield-address' => 'Adreso',
	'sign-viewfield-city' => 'Urbo',
	'sign-viewfield-state' => 'Ŝtato',
	'sign-viewfield-country' => 'Lando',
	'sign-viewfield-zip' => 'Poŝta kodo',
	'sign-viewfield-ip' => 'IP-adreso',
	'sign-viewfield-phone' => 'Telefono',
	'sign-viewfield-email' => 'Retadreso',
	'sign-viewfield-age' => 'Aĝo',
	'sign-viewfield-options' => 'Preferoj',
	'sign-sigadmin-close' => 'Malŝalti subskribadon',
	'sign-sigadmin-open' => 'Ŝalti subskribadon',
	'sign-signatures' => 'Subskriboj',
	'sign-sigadmin-closesuccess' => 'Subskribado estis sukcese malŝaltita.',
	'sign-sigadmin-opensuccess' => 'Subskribado estis sukcese ŝaltita.',
	'sign-viewsignatures' => 'vidi subskribojn',
	'sign-closed' => 'fermita',
	'sig-anonymous' => '<i>Anonima</i>',
	'sig-private' => '<i>Privata</i>',
	'sign-sigdetails' => 'Subskribaj detaloj',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-viewfield-stricken' => 'Trostrekigi',
	'sign-viewfield-reviewedby' => 'Kontrolanto',
	'sign-viewfield-reviewcomment' => 'Komento',
	'sign-detail-uniquequery-run' => 'Infommendi',
	'sign-detail-strike' => 'Forstreki subskribon',
	'sign-reviewsig' => 'Kontroli subskribon',
	'sign-review-comment' => 'Komento',
	'sign-submitreview' => 'Aldoni kontrolon',
	'sign-uniquequery-similarname' => 'Simila nomo',
	'sign-uniquequery-similaraddress' => 'Simila adreso',
	'sign-uniquequery-similarphone' => 'Simila nombro de telefono',
	'sign-uniquequery-similaremail' => 'Simila retadreso',
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'sign-selectdoc' => 'Documento:',
	'sign-realname' => 'Nombre:',
	'sign-city' => 'Ciudad:',
	'sign-state' => 'Estado:',
	'sign-country' => 'País:',
	'sign-phone' => 'Número de teléfono:',
	'sign-bday' => 'Edad:',
	'sign-email' => 'Dirección de correo electrónico:',
	'sign-viewfield-realname' => 'Nombre',
	'sign-viewfield-city' => 'Ciudad',
	'sign-viewfield-state' => 'Estado',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-ip' => 'Dirección IP',
	'sign-viewfield-email' => 'Correo electrónico',
	'sig-anonymous' => '<i>Anónimo</i>',
	'sig-private' => '<i>Privado</i>',
	'sign-viewfield-reviewcomment' => 'Comentario',
	'sign-review-comment' => 'Comentario',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'signdocument' => 'Dokumentua sinatu',
	'sign-selectdoc' => 'Dokumentu:',
	'sign-realname' => 'Izena:',
	'sign-address' => 'Helbidea:',
	'sign-city' => 'Udalerria:',
	'sign-state' => 'Estatua:',
	'sign-zip' => 'Posta kodea:',
	'sign-country' => 'Herrialdea:',
	'sign-phone' => 'Telefono zenbakia:',
	'sign-bday' => 'Adina:',
	'sign-email' => 'Email helbidea:',
	'sign-submit' => 'Dokumentua sinatu',
	'sig-success' => 'Dokumentua arrakastatsuki sinatu duzu.',
	'sign-viewfield-entryid' => 'NAN zenbakia:',
	'sign-viewfield-realname' => 'Izena',
	'sign-viewfield-address' => 'Helbidea',
	'sign-viewfield-city' => 'Udalerria',
	'sign-viewfield-state' => 'Estatua',
	'sign-viewfield-country' => 'Herrialdea',
	'sign-viewfield-zip' => 'Posta',
	'sign-viewfield-ip' => 'IP helbidea',
	'sign-viewfield-phone' => 'Telefonoa',
	'sign-viewfield-email' => 'Emaila',
	'sign-viewfield-age' => 'Adina',
	'sign-viewfield-options' => 'Aukerak',
	'sign-signatures' => 'Sinadurak',
	'sign-viewsignatures' => 'ikusi sinadurak',
	'sign-closed' => 'itxita',
	'sig-anonymous' => '<i>Anonimoa</i>',
	'sig-private' => '<i>Pribatua</i>',
	'sign-sigdetails' => 'Sinaduraren xehetasunak',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'sign-selectdoc' => 'Decumentu:',
	'sign-error-nosuchdoc' => 'El decumentu que piisti ($1) nu desisti.',
	'sign-realname' => 'Nombri:',
	'sign-city' => 'Ciá:',
	'sign-state' => 'Estau:',
	'sign-country' => 'Pais:',
	'sign-viewfield-realname' => 'Nombri',
	'sign-viewfield-city' => 'Ciá',
	'sign-viewfield-state' => 'Estau',
	'sign-viewfield-country' => 'Pais',
	'sign-viewfield-options' => 'Ocionis',
	'sign-signatures' => 'Firmas',
	'sign-closed' => 'afechau',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'sign-realname' => 'Nimi',
	'sign-address' => 'Katuosoite',
	'sign-city' => 'Kaupunki',
	'sign-state' => 'Lääni',
	'sign-zip' => 'Postinumero',
	'sign-country' => 'Maa',
	'sign-phone' => 'Puhelinnumero',
	'sign-bday' => 'Ikä',
	'sign-email' => 'Sähköpostiosoite',
	'sign-indicates-req' => '<small><i><font color="red">*</font> tarkoittaa pakollista kenttää.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Valvojat voivat nähdä piilotetut tiedot.</i></small>',
	'sign-list-anonymous' => 'Listaa nimettömänä',
	'sign-list-hideaddress' => 'Älä listaa osoitetta',
	'sign-list-hideextaddress' => 'Älä listaa kaupunkia, osavaltiota ja lääniä, postinumeroa tai maata',
	'sign-list-hidephone' => 'Älä listaa puhelinnumeroa',
	'sign-list-hidebday' => 'Älä listaa ikää',
	'sign-list-hideemail' => 'Älä listaa sähköpostiosoitetta',
	'sign-viewfield-timestamp' => 'Aikaleima',
	'sign-viewfield-realname' => 'Nimi',
	'sign-viewfield-address' => 'Osoite',
	'sign-viewfield-city' => 'Kaupunki',
	'sign-viewfield-state' => 'Lääni',
	'sign-viewfield-country' => 'Maa',
	'sign-viewfield-zip' => 'Postinumero',
	'sign-viewfield-ip' => 'IP-osoite',
	'sign-viewfield-phone' => 'Puhelin',
	'sign-viewfield-email' => 'Sähköpostiosoite',
	'sign-viewfield-age' => 'Ikä',
	'sign-closed' => 'suljettu',
	'sig-anonymous' => '<i>Nimetön</i>',
	'sig-private' => '<i>Yksityinen</i>',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|keskustelu]] • <!--
-->[[Special:Contributions/$1|muokkaukset]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBL:t] • <!--
-->[[Special:BlockIP/$1|estä käyttäjä]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} estoloki] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} osoitepaljastus])<!--
--></span>',
);

/** French (Français)
 * @author Grondin
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'signdocument' => 'Authentifier le document',
	'sign-nodocselected' => 'Prière de choisir le document que vous voulez authentifier',
	'sign-selectdoc' => 'Document :',
	'sign-docheader' => '<div class="noarticletext">Prière d\'utiliser ce formulaire pour authentifier le document « [[$1]] » affichée ci-dessous. Lire le document au complet, et si vous souhaitez signifier votre appui, remplir les champs pour l\'authentifier.</div>',
	'sign-error-nosuchdoc' => "Le document demandé ($1) n'existe pas.",
	'sign-realname' => 'Nom :',
	'sign-address' => 'Adresse rue :',
	'sign-city' => 'Ville :',
	'sign-state' => 'État, département ou province :',
	'sign-zip' => 'Code postal :',
	'sign-country' => 'Pays :',
	'sign-phone' => 'Numéro de téléphone :',
	'sign-bday' => 'Âge :',
	'sign-email' => 'Adresse de courriel :',
	'sign-indicates-req' => '<small><i><font color="red">*</font> indique les champs obligatoires.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Les informations non listées sont toujours visibles pour les modérateurs.</i></small>',
	'sign-list-anonymous' => 'Lister de façon anonyme',
	'sign-list-hideaddress' => "Ne pas lister l'adresse",
	'sign-list-hideextaddress' => "Ne pas lister la ville, l'état (le département ou la province), le code postal ou le pays",
	'sign-list-hidephone' => 'Ne pas lister le numéro de téléphone',
	'sign-list-hidebday' => "Ne pas lister l'âge",
	'sign-list-hideemail' => "Ne pas lister l'adresse de courriel",
	'sign-submit' => 'Authentifier le document',
	'sign-information' => '<div class="noarticletext">Merci d’avoir complètement lu ce document. Si vous êtes d’accord avec son contenu, signifiez votre appui en remplissant les champs requis ci-dessous et en cliquant « Authentifier document ». Prière de vérifier que vos informations personnelles sont exactes et que nous possédons un moyen de vous contacter pour valider votre identité. Votre adresse IP et d’autres informations qui peuvent vous identifier sont notées et seront utilisées par les modérateurs pour éliminer les signatures en doublon et confirmer les informations saisies. Les mandataires (proxys) ne nous permettant pas d’identifier à coup sûr le signataire, les signatures obtenues à travers ceux-ci ne seront probablement pas comptées. Si vous êtes connecté à travers un mandataire, prière d’utiliser un compte qui n’en utilise pas.</div>

$1',
	'sig-success' => 'Vous avez authentifié le document.',
	'sign-view-selectfields' => "'''Champs à afficher :'''",
	'sign-viewfield-entryid' => "ID de l'entrée",
	'sign-viewfield-timestamp' => 'Date et heure',
	'sign-viewfield-realname' => 'Nom',
	'sign-viewfield-address' => 'Adresse',
	'sign-viewfield-city' => 'Ville',
	'sign-viewfield-state' => 'État (département ou province)',
	'sign-viewfield-country' => 'Pays',
	'sign-viewfield-zip' => 'Code postal',
	'sign-viewfield-ip' => 'Adresse IP',
	'sign-viewfield-agent' => 'Agent utilisateur',
	'sign-viewfield-phone' => 'Numéro de téléphone',
	'sign-viewfield-email' => 'Adresse de courriel',
	'sign-viewfield-age' => 'Âge',
	'sign-viewfield-options' => 'Options',
	'sign-viewsigs-intro' => 'Ci-dessous apparaissent les signatures enregistrées pour <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => "L'authentification est présentement activée pour ce document.",
	'sign-sigadmin-close' => "Désactiver l'authentification",
	'sign-sigadmin-currentlyclosed' => "L'authentification est présentement désactivée pour ce document.",
	'sign-sigadmin-open' => "Activer l'authentification",
	'sign-signatures' => 'Signatures',
	'sign-sigadmin-closesuccess' => "L'authentification est désactivée.",
	'sign-sigadmin-opensuccess' => "L'authentification est activée.",
	'sign-viewsignatures' => 'Voir les signatures',
	'sign-closed' => 'fermée',
	'sign-error-closed' => "L'authentification de ce document est présentée désactivée.",
	'sig-anonymous' => "''Anonymement''",
	'sig-private' => "''Privé''",
	'sign-sigdetails' => 'Détails de la signature',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
		-->[[User:$1|$1]] ([[User talk:$1|Discussion]] • <!--
		-->[[Special:Contributions/$1|Contributions]] • <!--
		-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
		-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
		-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
		-->[[Special:BlockIP/$1|Bloquer l\'utisateur]] • <!--
		-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} Journal des blocages] • <!--
		-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} Vérification d\'utilisateur])<!--
		--></span>',
	'sign-viewfield-stricken' => 'Biffé',
	'sign-viewfield-reviewedby' => 'Réviseur',
	'sign-viewfield-reviewcomment' => 'Commentaire',
	'sign-detail-uniquequery' => 'Entités semblables',
	'sign-detail-uniquequery-run' => 'Lancer la requête',
	'sign-detail-strike' => 'Biffer la signature',
	'sign-reviewsig' => 'Réviser la signature',
	'sign-review-comment' => 'Commentaire',
	'sign-submitreview' => 'Soumettre la révision',
	'sign-uniquequery-similarname' => 'Nom semblable',
	'sign-uniquequery-similaraddress' => 'Adresse semblable',
	'sign-uniquequery-similarphone' => 'Numéro de téléphone semblable',
	'sign-uniquequery-similaremail' => 'Adresse de courriel semblable',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] a authentifié [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'sign-viewfield-reviewedby' => 'Kontroleur',
	'sign-viewfield-reviewcomment' => 'Oanmerking',
	'sign-review-comment' => 'Oanmerking',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'signdocument' => 'Asine o Documento',
	'sign-nodocselected' => 'Seleccione o documento que vostede quere asinar.',
	'sign-selectdoc' => 'Documento:',
	'sign-docheader' => '<div class="noarticletext">Use este formulario para asinar o documento "[[$1]],", amosado a continuación. Lea o documento enteiro, e se desexa indicar o seu apoio o mesmo, encha os campos necesarios para asinalo.</div>',
	'sign-error-nosuchdoc' => 'O documento que vostede pediu ($1) non existe.',
	'sign-realname' => 'Nome:',
	'sign-address' => 'Enderezo postal:',
	'sign-city' => 'Cidade:',
	'sign-state' => 'Estado:',
	'sign-zip' => 'Código postal:',
	'sign-country' => 'País:',
	'sign-phone' => 'Número de teléfono:',
	'sign-bday' => 'Idade:',
	'sign-email' => 'Enderezo de correo electrónico:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> indica campo requirido.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Nota: a información non listada poderana ver, porén, os moderadores.</i></small>',
	'sign-list-anonymous' => 'Listar anonimamente',
	'sign-list-hideaddress' => 'Non listar o enderezo',
	'sign-list-hideextaddress' => 'Non listar cidade, estado/provincia, código postal ou país',
	'sign-list-hidephone' => 'Non listar o teléfono',
	'sign-list-hidebday' => 'Non listar a idade',
	'sign-list-hideemail' => 'Non listar o enderezo de correo electrónico',
	'sign-submit' => 'Asinar o documento',
	'sign-information' => '<div class="noarticletext">Grazas por botar un tempo a ler este documento. Se está de acordo con el, indique o seu apoio enchendo os campos requiridos de embaixo e prema en "Asinar Documento". Asegúrese de que a súa información persoal é correcta e de que ten maneira de ser contactado para verificar a súa identidade. Observe que o seu enderezo IP e outra información identificativa serán gardados con este formulario e usados polos moderadores para eliminar sinaturas duplicadas e confirmar que a súa información persoal é correcta. Dado que o uso de proxies abertos e que permitan o anonimato dificulta a nosa capacidade de realizar esta tarefa, as sinaturas desde eses proxies probabelmente non se teñan en conta. Se está conectado neste momento a través dun servidor proxy, desconéctese del e use unha conexión normal ao asinar.</div>

$1',
	'sig-success' => 'Asinou o documento sen problemas.',
	'sign-view-selectfields' => '<b>Campos a mostrar:</b>',
	'sign-viewfield-entryid' => 'ID da entrada',
	'sign-viewfield-timestamp' => 'Selo temporal',
	'sign-viewfield-realname' => 'Nome',
	'sign-viewfield-address' => 'Enderezo',
	'sign-viewfield-city' => 'Cidade',
	'sign-viewfield-state' => 'Estado/Provincia',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-zip' => 'Código postal',
	'sign-viewfield-ip' => 'Enderezo IP',
	'sign-viewfield-agent' => 'Axente de usuario',
	'sign-viewfield-phone' => 'Teléfono',
	'sign-viewfield-email' => 'Correo electrónico',
	'sign-viewfield-age' => 'Idade',
	'sign-viewfield-options' => 'Opcións',
	'sign-viewsigs-intro' => 'Abaixo amósanse as sinaturas gardadas para <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Actualmente están habilitadas as sinaturas para este documento.',
	'sign-sigadmin-close' => 'Desactivar as sinaturas',
	'sign-sigadmin-currentlyclosed' => 'Actualmente están desactivadas as sinaturas para este documento.',
	'sign-sigadmin-open' => 'Activar as sinaturas',
	'sign-signatures' => 'Sinaturas',
	'sign-sigadmin-closesuccess' => 'As sinaturas desactiváronse sen problemas.',
	'sign-sigadmin-opensuccess' => 'As sinaturas activáronse sen problemas.',
	'sign-viewsignatures' => 'ver as sinaturas',
	'sign-closed' => 'fechado',
	'sign-error-closed' => 'Actualmente están desactivadas as sinaturas neste documento.',
	'sig-anonymous' => '<i>Anónimo</i>',
	'sig-private' => '<i>Privado</i>',
	'sign-sigdetails' => 'Detalles da sinatura',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|conversa]] • <!--
-->[[Special:Contributions/$1|contribucións]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|bloquear o usuario]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} rexistro de bloqueos] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} comprobar o enderezo IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'Tachado',
	'sign-viewfield-reviewedby' => 'Revisor',
	'sign-viewfield-reviewcomment' => 'Comentario',
	'sign-detail-uniquequery' => 'Entidades semellantes',
	'sign-detail-uniquequery-run' => 'Executar consulta',
	'sign-detail-strike' => 'Tachar a sinatura',
	'sign-reviewsig' => 'Revisar a sinatura',
	'sign-review-comment' => 'Comentario',
	'sign-submitreview' => 'Enviar a revisión',
	'sign-uniquequery-similarname' => 'Nome parecido',
	'sign-uniquequery-similaraddress' => 'Enderezo parecido',
	'sign-uniquequery-similarphone' => 'Teléfono parecido',
	'sign-uniquequery-similaremail' => 'Correo electrónico parecido',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] asinado [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'sign-realname' => 'Ὄνομα:',
	'sign-phone' => 'Ἀριθμὸς τηλεφώνου:',
	'sign-email' => 'Ἡλεκτρονικὴ διεύθυνσις:',
	'sign-viewfield-realname' => 'Ὄνομα',
	'sign-viewfield-ip' => 'IP-διεύθυνσις',
	'sign-viewfield-agent' => 'Χρώμενος πράκτωρ',
	'sign-viewfield-email' => 'Ἠλεκτρονικαὶ ἐπιστολαί',
	'sign-viewfield-options' => 'Ἐπιλογαί',
	'sig-private' => '<ι>Ἰδιωτική</ι>',
	'sign-viewfield-reviewedby' => 'ἐπιθεωρητής',
	'sign-viewfield-reviewcomment' => 'Σχόλιον',
	'sign-review-comment' => 'Σχόλιον',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 */
$messages['gu'] = array(
	'sign-realname' => 'નામ:',
	'sign-address' => 'સરનામુ:',
	'sign-city' => 'શહેર/નગરઃ',
	'sign-state' => 'રાજ્ય:',
	'sign-zip' => 'પોસ્ટ કોડ:',
	'sign-country' => 'દેશ:',
	'sign-phone' => 'દુરભાષઃ',
	'sign-bday' => 'ઉંમરઃ',
	'sign-email' => 'ઇ મેલ:',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'sign-realname' => 'Inoa:',
	'sign-viewfield-realname' => 'Inoa',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'signdocument' => 'חתימת מסמכים',
	'sign-nodocselected' => 'אנא בחרו את המסמך עליו תרצו לחתום.',
	'sign-selectdoc' => 'מסמך:',
	'sign-docheader' => '<div class="noarticletext">אנא השתמשו בטופס שלהלן כדי לחתום על המסמך "[[$1]]", המוצג להלן.
אנא קראו את המסמך כולו בעיון, ואם ברצונכם לציין את תמיכתם בו, אנא מלאו את השדות הדרושים כדי לחתום עליו.</div>',
	'sign-error-nosuchdoc' => 'המסמך המבוקש ($1) אינו קיים.',
	'sign-realname' => 'שם:',
	'sign-address' => 'כתובת (רחוב):',
	'sign-city' => 'עיר:',
	'sign-state' => 'מדינה:',
	'sign-zip' => 'מיקוד:',
	'sign-country' => 'ארץ:',
	'sign-phone' => 'מספר טלפון:',
	'sign-bday' => 'גיל:',
	'sign-email' => 'כתובת דוא"ל:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> פירושה שדה חובה.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> הערה: גם נתונים שלא מוצגים יהיו גלויים בפני מפעילים.</i></small>',
	'sign-list-anonymous' => 'חתימה אנונימית',
	'sign-list-hideaddress' => 'מבלי להציג כתובת',
	'sign-list-hideextaddress' => 'מבלי להציג עיר, מדינה, מיקוד או ארץ',
	'sign-list-hidephone' => 'מבלי להציג מספר טלפון',
	'sign-list-hidebday' => 'מבלי להציג גיל',
	'sign-list-hideemail' => 'מבלי להציג כתובת דוא"ל',
	'sign-submit' => 'חתימה על המסמך',
	'sign-information' => '<div class="noarticletext">תודה לכם על שהשקעתם את הזמן לקריאת המסמך הזה.
אם אתם מסכימים לתוכנו, אנא הביעו את תמיכתכם על ידי מילוי השדות הדרושים להלן ולחיצה על "חתימה על המסמך".
אנא ודאו כי הנתונים האישיים שלכם נכונים ושתהיה לנו אפשרות ליצור איתכם קשר לאימות זהותכם.
שימו לב שכתובת ה־IP שלכם וכל מידע מזהה אחר יישמר עם הטופס וישמש את המפעילים כדי למנוע חתימות כפולות וכדי לאמת את פרטיכם האישיים.
כיוון שהשימוש בשרתי פרוקסי פתוחים עלול למנוע מאיתנו לבצע משימה זו, חתימות שנשלחו משרתים כאלה ככל הנראה לא ייחשבו.
אם אתם מחוברים כרגע דרך שרת פרוקסי, אנא התנתקו ממנו והשתמשו בחיבור הרגיל בעת החתימה.</div>

$1',
	'sig-success' => 'החתימה על המסמך נרשמה בהצלחה.',
	'sign-view-selectfields' => '<b>שדות להצגה:</b>',
	'sign-viewfield-entryid' => 'מספר הרשומה',
	'sign-viewfield-timestamp' => 'תאריך ושעה',
	'sign-viewfield-realname' => 'שם',
	'sign-viewfield-address' => 'כתובת',
	'sign-viewfield-city' => 'עיר',
	'sign-viewfield-state' => 'מדינה',
	'sign-viewfield-country' => 'ארץ',
	'sign-viewfield-zip' => 'מיקוד',
	'sign-viewfield-ip' => 'כתובת IP',
	'sign-viewfield-agent' => 'מזהה הדפדפן',
	'sign-viewfield-phone' => 'טלפון',
	'sign-viewfield-email' => 'דוא"ל',
	'sign-viewfield-age' => 'גיל',
	'sign-viewfield-options' => 'אפשרויות',
	'sign-viewsigs-intro' => 'להלן החתימות על <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'ניתן כעת לחתום על מסמך זה.',
	'sign-sigadmin-close' => 'ביטול אפשרות החתימה',
	'sign-sigadmin-currentlyclosed' => 'לא ניתן כעת לחתום על מסמך זה.',
	'sign-sigadmin-open' => 'הפעלת אפשרות החתימה',
	'sign-signatures' => 'חתימות',
	'sign-sigadmin-closesuccess' => 'אפשרות החתימה בוטלה בהצלחה.',
	'sign-sigadmin-opensuccess' => 'אפשרות החתימה הופעלה בהצלחה.',
	'sign-viewsignatures' => 'צפייה בחתימות',
	'sign-closed' => 'סגור',
	'sign-error-closed' => 'לא ניתן כעת לחתום על מסמך זה.',
	'sig-anonymous' => '<i>אנונימי</i>',
	'sig-private' => '<i>פרטי</i>',
	'sign-sigdetails' => 'פרטי החתימה',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|שיחה]] • <!--
-->[[Special:Contributions/$1|תרומות]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|חסימת המשתמש]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} יומן חסימות] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} בדיקת IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'מחוקה',
	'sign-viewfield-reviewedby' => 'בודק',
	'sign-viewfield-reviewcomment' => 'הערה',
	'sign-detail-uniquequery' => 'יישויות דומות',
	'sign-detail-uniquequery-run' => 'הרצת שאילתה',
	'sign-detail-strike' => 'מחיקת החתימה',
	'sign-reviewsig' => 'בדיקת החתימה',
	'sign-review-comment' => 'הערה',
	'sign-submitreview' => 'שליחת בדיקה',
	'sign-uniquequery-similarname' => 'שם דומה',
	'sign-uniquequery-similaraddress' => 'כתובת דומה',
	'sign-uniquequery-similarphone' => 'טלפון דומה',
	'sign-uniquequery-similaremail' => 'דוא"ל דומה',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] חתם על [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'sign-realname' => 'नाम:',
	'sign-email' => 'इ-मेल एड्रेस:',
	'sign-viewfield-realname' => 'नाम',
	'sign-viewfield-ip' => 'आइपी एड्रेस',
	'sign-viewfield-email' => 'इ-मेल',
	'sign-viewfield-options' => 'विकल्प',
	'sign-viewfield-reviewcomment' => 'टिप्पणी',
	'sign-review-comment' => 'टिप्पणी',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'sign-viewfield-email' => 'E-mail',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'sign-viewfield-reviewcomment' => 'Komentar',
	'sign-review-comment' => 'Komentar',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'signdocument' => 'Dokument podpisać',
	'sign-nodocselected' => 'Prošu wubjer dokument, kotryž chceš podpisać.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => '<div class="noarticletext">Prošu wužij tutón formular, zo by dokument podpisał "[[$1]]," kotryž deleka steji. Prošu přečitaj cyły dokument, a jeli chceš jón podpěrać, wupjelń prošu trěbne pola a podpisaj jón.</div>',
	'sign-error-nosuchdoc' => 'Dokument, kotryž sy požadał ($1) njeeksistuje.',
	'sign-realname' => 'Mjeno:',
	'sign-address' => 'Hasa:',
	'sign-city' => 'Město:',
	'sign-state' => 'Stat:',
	'sign-zip' => 'Póstowe wodźenske čisło:',
	'sign-country' => 'Kraj:',
	'sign-phone' => 'Telefonowe čisło:',
	'sign-bday' => 'Staroba:',
	'sign-email' => 'E-mejlowa adresa:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> trěbne polo poznamjenja.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Kedźbu: Njenalistowane informacije budu hišće moderatoram widźomne być.</i></small>',
	'sign-list-anonymous' => 'Anonymnje nalistować',
	'sign-list-hideaddress' => 'Njenalistuj adresu',
	'sign-list-hideextaddress' => 'Njenalistuj město, stat, póstowe wodźenske čisło abo kraj',
	'sign-list-hidephone' => 'Njenalistuj telefonowe čisło',
	'sign-list-hidebday' => 'Njenalistuj starobu',
	'sign-list-hideemail' => 'Njenalistuj e-mejlowu adresu',
	'sign-submit' => 'Dokument podpisać',
	'sign-information' => '<div class="noarticletext">Dźakujemy so, zo sej bjerješ čas, zo by tutón dokument přečitał. Jeli sy z nim přezjedny, wupjelń trěbne pola a klikń na "Dokument podpisać", zo by swoje podpěru pokazał. Prošu zawěsć sej, zo twoje wosobinske informacije su korektne a podaj móžnosć, z kotrejž móžemy će skontaktować, zo bychmy twoju identitu přepruwowali. Wobkedźbuj, zo twoja IP-adresa a druhe identifikowace informacije budu so z tutym formularom registrować a wot moderatorow wužiwać, zo bychu dwójne podpisy wotstronili a korektnosć twojich wosobinskich informacijow potwjerdźili. Dokelž wotewrjene a anonymizowace proksy wobmjezuja našu kmanosć tutón nadawk wuwjesć, njebudu so podpisy z tajkich proksy najskerje ličić. Jeli sy tuchwilu přez proksy-serwer zwjazany, rozdźěl tutón zwjazk a wutwar standardny zwjazk za podpisowanje.</div>

$1',
	'sig-success' => 'Sy dokument wuspěšnje podpisał.',
	'sign-view-selectfields' => '<b>Pola, kotrež maja so zwobraznić:</b>',
	'sign-viewfield-entryid' => 'ID zapiska',
	'sign-viewfield-timestamp' => 'Časowy kołk',
	'sign-viewfield-realname' => 'Mjeno',
	'sign-viewfield-address' => 'Adresa',
	'sign-viewfield-city' => 'Město',
	'sign-viewfield-state' => 'Stat',
	'sign-viewfield-country' => 'Kraj',
	'sign-viewfield-zip' => 'Póstowe wodźenske čisło',
	'sign-viewfield-ip' => 'IP-adresa',
	'sign-viewfield-agent' => 'User agent',
	'sign-viewfield-phone' => 'Telefonowe čisło',
	'sign-viewfield-email' => 'E-mejl',
	'sign-viewfield-age' => 'Staroba',
	'sign-viewfield-options' => 'Opcije',
	'sign-viewsigs-intro' => 'Deleka su podpisy, kotrež buchu za <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1] zregistrowane.',
	'sign-sigadmin-currentlyopen' => 'Podpisanje je tuchwilu za tutón dokument zmóžnjene.',
	'sign-sigadmin-close' => 'Podpisanje znjemóžnić',
	'sign-sigadmin-currentlyclosed' => 'Podpisanje je tuchwilu za tutón dokument znjemóžnjene.',
	'sign-sigadmin-open' => 'Podpisanje zmóžnić',
	'sign-signatures' => 'Podpisy',
	'sign-sigadmin-closesuccess' => 'Podpisanje wuspěšnje znjemóžnjene.',
	'sign-sigadmin-opensuccess' => 'Podpisanje wuspěšnje zmóžnjene.',
	'sign-viewsignatures' => 'Podpisy sej wobhladać',
	'sign-closed' => 'začinjeny',
	'sign-error-closed' => 'Podpisanje tutoho dokumenta je tuchwilu znjemóžnjene.',
	'sig-anonymous' => '<i>Anonymny</i>',
	'sig-private' => '<i>Priwatny</i>',
	'sign-sigdetails' => 'Podrobnosće podpisanja',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
		-->[[User:$1|$1]] ([[User talk:$1|Diskusija]] • <!--
		-->[[Special:Contributions/$1|Přinoški]] • <!--
		-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
		-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
		-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
		-->[[Special:BlockIP/$1|Wužiwarja blokować]] • <!--
		-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} Protokol blokowanja] • <!--
		-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} checkip])<!--
		--></span>',
	'sign-viewfield-stricken' => 'Wušmórnjeny',
	'sign-viewfield-reviewedby' => 'Pruwowar',
	'sign-viewfield-reviewcomment' => 'Komentar',
	'sign-detail-uniquequery' => 'Podobne entity',
	'sign-detail-uniquequery-run' => 'Wotprašenje startować',
	'sign-detail-strike' => 'Podpis šmórnyć',
	'sign-reviewsig' => 'Podpis přepruwować',
	'sign-review-comment' => 'Komentar',
	'sign-submitreview' => 'Pruwowanje přewjesć',
	'sign-uniquequery-similarname' => 'Podobne mjeno',
	'sign-uniquequery-similaraddress' => 'Podobna adresa',
	'sign-uniquequery-similarphone' => 'Podobne telefonowe čisło',
	'sign-uniquequery-similaremail' => 'Podobna e-mejlowa adresa',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] je [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2] podpisał.',
);

/** Hungarian (Magyar)
 * @author Dorgan
 */
$messages['hu'] = array(
	'sign-realname' => 'Név:',
	'sign-city' => 'Város:',
	'sign-zip' => 'Irányítószám:',
	'sign-phone' => 'Telefonszám:',
	'sign-bday' => 'Életkor:',
	'sign-email' => 'E-mail cím:',
);

/** Armenian (Հայերեն)
 * @author Togaed
 */
$messages['hy'] = array(
	'sign-realname' => 'Անուն`',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'signdocument' => 'Signar documento',
	'sign-nodocselected' => 'Per favor selige le documento que tu vole signar.',
	'sign-selectdoc' => 'Documento:',
	'sign-docheader' => '<div class="noarticletext">Usa iste formulario pro signar le documento "[[$1]]," monstrate infra.
Per favor lege le documento integre, e si tu vole indicar tu appoio de illo, completa le campos requisite pro signar lo.</div>',
	'sign-error-nosuchdoc' => 'Le documento que tu requestava ($1) non existe.',
	'sign-realname' => 'Nomine:',
	'sign-address' => 'Adresse residential:',
	'sign-city' => 'Citate:',
	'sign-state' => 'Stato/provincia:',
	'sign-zip' => 'Codice postal:',
	'sign-country' => 'Pais:',
	'sign-phone' => 'Numero de telephono:',
	'sign-bday' => 'Etate:',
	'sign-email' => 'Adresse de e-mail:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> indica un campo obligatori.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Nota: Le informationes non listate essera totevia disponibile al moderatores.</i></small>',
	'sign-list-anonymous' => 'Listar anonymemente',
	'sign-list-hideaddress' => 'Non listar adresse',
	'sign-list-hideextaddress' => 'Non listar citate, stato/provincia, codice postal, o pais',
	'sign-list-hidephone' => 'Non listar telephono',
	'sign-list-hidebday' => 'Non listar etate',
	'sign-list-hideemail' => 'Non listar e-mail',
	'sign-submit' => 'Signar documento',
	'sign-information' => '<div class="noarticletext">Gratias pro haber completemente legite iste documento.
Si tu es de accordo con illo, per favor indica tu appoio per completar le campos requisite in basso e cliccar "Signar documento".
Per favor assecura te que tu informationes personal sia correcte e que nos dispone de un modo de contactar te pro verificar tu identitate.
Nota que iste formulario face registrar tu adresse IP e altere informationes que pote identificar te; le moderatores usa istes pro eliminar signaturas duplice e pro confirmar le accuratessa de tu informationes personal.
Post que le uso de servitores proxy public e anonyme nos impedi de facer isto, le signaturas ab istes probabilemente non essera contate.
Si tu es actualmente connectite via un servitor proxy, per favor disconnecte te de illo e usa un connexion standard durante le signatura.</div>

$1',
	'sig-success' => 'Tu ha signate le documento con successo.',
	'sign-view-selectfields' => '<b>Campos a monstrar:</b>',
	'sign-viewfield-entryid' => 'ID del entrata',
	'sign-viewfield-timestamp' => 'Data e hora',
	'sign-viewfield-realname' => 'Nomine',
	'sign-viewfield-address' => 'Adresse',
	'sign-viewfield-city' => 'Citate',
	'sign-viewfield-state' => 'Stato/provincia',
	'sign-viewfield-country' => 'Pais',
	'sign-viewfield-zip' => 'Codice postal',
	'sign-viewfield-ip' => 'Adresse IP',
	'sign-viewfield-agent' => 'Agente usator',
	'sign-viewfield-phone' => 'Telephono',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Etate',
	'sign-viewfield-options' => 'Optiones',
	'sign-viewsigs-intro' => 'Infra se monstra le signaturas registrate pro <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Le signatura es actualmente active pro iste documento.',
	'sign-sigadmin-close' => 'Disactivar signatura',
	'sign-sigadmin-currentlyclosed' => 'Le signatura non es actualmente active pro iste documento.',
	'sign-sigadmin-open' => 'Activar signatura',
	'sign-signatures' => 'Signaturas',
	'sign-sigadmin-closesuccess' => 'Le signatura ha essite disactivate con successo.',
	'sign-sigadmin-opensuccess' => 'Le signatura ha essite activate con successo.',
	'sign-viewsignatures' => 'vider signaturas',
	'sign-closed' => 'claudite',
	'sign-error-closed' => 'Le signatura de iste documento non es actualmente active.',
	'sig-anonymous' => '<i>Anonyme</i>',
	'sig-private' => '<i>Private</i>',
	'sign-sigdetails' => 'Detalios del signatura',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|discussion]] • <!--
-->[[Special:Contributions/$1|contributiones]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|blocar usator]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} registro de blocadas] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} verificar IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'Cancellate',
	'sign-viewfield-reviewedby' => 'Revisor',
	'sign-viewfield-reviewcomment' => 'Commento',
	'sign-detail-uniquequery' => 'Entitates similar',
	'sign-detail-uniquequery-run' => 'Executar consulta',
	'sign-detail-strike' => 'Cancellar signatura',
	'sign-reviewsig' => 'Revider signatura',
	'sign-review-comment' => 'Commento',
	'sign-submitreview' => 'Submitter revision',
	'sign-uniquequery-similarname' => 'Nomine similar',
	'sign-uniquequery-similaraddress' => 'Adresse similar',
	'sign-uniquequery-similarphone' => 'Telephono similar',
	'sign-uniquequery-similaremail' => 'E-mail similar',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] signava [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'sign-realname' => 'Nama:',
	'sign-viewfield-realname' => 'Nama',
	'sign-viewfield-agent' => 'Aplikasi pengguna',
	'sign-viewfield-options' => 'Pilihan',
);

/** Icelandic (Íslenska) */
$messages['is'] = array(
	'sign-realname' => 'Nafn:',
	'sign-city' => 'Staður:',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'sign-realname' => 'Nome:',
	'sign-viewfield-realname' => 'Nome',
	'sign-viewfield-ip' => 'Indirizzo IP',
	'sign-viewfield-email' => 'Indirizzo e-mail',
	'sign-viewfield-options' => 'Opzioni',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'sign-selectdoc' => 'ドキュメント:',
	'sign-realname' => '名前:',
	'sign-viewfield-timestamp' => 'タイムスタンプ',
	'sign-viewfield-realname' => '名前',
	'sign-viewfield-address' => '住所',
	'sign-viewfield-ip' => 'IPアドレス',
	'sign-viewfield-phone' => '電話',
	'sign-viewfield-options' => 'オプション',
	'sign-viewfield-reviewcomment' => 'コメント',
	'sign-review-comment' => 'コメント',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'signdocument' => 'Tapak tangani Dokumèn',
	'sign-nodocselected' => 'Mangga milih dokumèn sing kepéngin panjenengan tapa tangani.',
	'sign-selectdoc' => 'Dokumèn:',
	'sign-error-nosuchdoc' => 'Dokumèn sing panjenengan suwun iku ora ana ($1).',
	'sign-realname' => 'Jeneng:',
	'sign-address' => 'Dalan:',
	'sign-city' => 'Kutha:',
	'sign-state' => 'Negara bagéyan:',
	'sign-zip' => 'Kode pos:',
	'sign-country' => 'Negara:',
	'sign-phone' => 'Nomer tilpun:',
	'sign-bday' => 'Umur:',
	'sign-email' => 'Alamat e-mail:',
	'sign-hide-note' => '<small><i><font color="red">**</font> Cathetan: Informasi sing ora olèh dituduhaké tetep isih bisa dideleng para pangurus.</i></small>',
	'sign-list-anonymous' => 'Mèlu sacara anonim',
	'sign-list-hideaddress' => 'Aja nuduhaké dalan',
	'sign-list-hideextaddress' => 'Aja nuduhaké kutha, negara bagéyan, kode pos, utawa negara',
	'sign-list-hidephone' => 'Aja nuduhaké tilpun',
	'sign-list-hidebday' => 'Aja nuduhaké umur',
	'sign-list-hideemail' => 'Aja nuduhaké e-mail',
	'sign-submit' => 'Napak astani dokumèn',
	'sig-success' => 'Panjenengan bisa sacara suksès napak tangani dokumèn.',
	'sign-view-selectfields' => '<b>Lapangan-lapangan sing dituduhaké:</b>',
	'sign-viewfield-realname' => 'Jeneng',
	'sign-viewfield-address' => 'Alamat',
	'sign-viewfield-city' => 'Kutha',
	'sign-viewfield-state' => 'Negara bagéyan',
	'sign-viewfield-country' => 'Negara',
	'sign-viewfield-zip' => 'Kode pos',
	'sign-viewfield-ip' => 'Alamat IP',
	'sign-viewfield-agent' => 'User agent',
	'sign-viewfield-phone' => 'Tilpun',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Umur',
	'sign-viewfield-options' => 'Opsi:',
	'sign-sigadmin-close' => 'Patènana fitur tapak tangan',
	'sign-sigadmin-open' => 'Uripna fitur tapak tangan',
	'sign-sigadmin-closesuccess' => 'Fitur tapak tangan bisa dipatèni sacara suksès.',
	'sign-sigadmin-opensuccess' => 'Fitur tapak tangan bisa diuripaké sacara suksès.',
	'sign-closed' => 'ditutup',
	'sig-anonymous' => '<i>Anonim</i>',
	'sig-private' => '<i>Pribadi</i>',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-viewfield-reviewcomment' => 'Komentar',
	'sign-detail-uniquequery' => 'Èntitas sing mèmper',
	'sign-detail-uniquequery-run' => 'Lakokna kwéri',
	'sign-review-comment' => 'Komentar',
	'sign-uniquequery-similarname' => 'Jeneng sing mèmper',
	'sign-uniquequery-similaraddress' => 'Alamat sing mèmper',
	'sign-uniquequery-similarphone' => 'Tilpun sing mèmper',
	'sign-uniquequery-similaremail' => 'E-mail sing mèmper',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'sign-realname' => 'სახელი:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'signdocument' => 'ចុះហត្ថលេខា​លើ​ឯកសារ',
	'sign-nodocselected' => 'សូម​ជ្រើសរើស​ឯកសារ​ដែលអ្នក​ចង់​ចុះហត្ថលេខា។',
	'sign-selectdoc' => 'ឯកសារ៖',
	'sign-error-nosuchdoc' => 'មិនមាន​ឯកសារ ដែល​អ្នក​បាន​ស្នើ ($1) ទេ​។',
	'sign-realname' => 'ឈ្មោះ៖',
	'sign-address' => 'អាសយដ្ឋាន ផ្លូវ​៖',
	'sign-city' => 'ក្រុង៖',
	'sign-state' => 'រដ្ឋ៖',
	'sign-zip' => 'កូដ​លេខប្រចាំ​តំបន់:',
	'sign-country' => 'ប្រទេស៖',
	'sign-phone' => 'លេខទូរស័ព្ទ៖',
	'sign-bday' => 'អាយុ៖',
	'sign-email' => 'អាសយដ្ឋានអ៊ីមែល៖',
	'sign-list-anonymous' => 'ចុះបញ្ជី​ដោយ​អនាមិក',
	'sign-list-hideaddress' => 'មិនចុះ​អាសយដ្ឋាន',
	'sign-list-hideextaddress' => 'មិន​ចុះ ទីក្រុង, រដ្ឋ, លេខប្រចាំតំបន់, ឬ ប្រទេស',
	'sign-list-hidephone' => 'មិន​ចុះ​លេខទូរស័ព្ទ',
	'sign-list-hidebday' => 'មិន​ចុះ​អាយុ',
	'sign-list-hideemail' => 'សូមកុំដាក់ក្នុងបញ្ជីអ៊ីមែល',
	'sign-submit' => 'ចុះហត្ថលេខា​លើ​ឯកសារ',
	'sig-success' => 'អ្នក​បាន​ចុះហត្ថលេខា​លើ​អត្ថបទ ដោយជោគជ័យ​ហើយ​។',
	'sign-view-selectfields' => '<b>វាល​ត្រូវ​បង្ហាញ:</b>',
	'sign-viewfield-entryid' => 'អត្តលេខ​ធាតុបញ្ចូល',
	'sign-viewfield-realname' => 'ឈ្មោះ',
	'sign-viewfield-address' => 'អាសយដ្ឋាន',
	'sign-viewfield-city' => 'ក្រុង',
	'sign-viewfield-state' => 'រដ្ឋ',
	'sign-viewfield-country' => 'ប្រទេស',
	'sign-viewfield-zip' => 'លេខប្រចាំតំបន់',
	'sign-viewfield-ip' => 'អាសយដ្ឋាន IP',
	'sign-viewfield-agent' => 'ភ្នាក់ងារ​អ្នកប្រើប្រាស់',
	'sign-viewfield-phone' => 'ទូរស័ព្ទ',
	'sign-viewfield-email' => 'អ៊ីមែល',
	'sign-viewfield-age' => 'អាយុ',
	'sign-viewfield-options' => 'ជម្រើសនានា',
	'sign-sigadmin-currentlyopen' => 'ការចុះហត្ថលេខា ត្រូវ​បាន​អនុញ្ញាត​សម្រាប់​ឯកសារ​នេះ​ទេ នាពេលនេះ​។',
	'sign-sigadmin-close' => 'មិនអនុញ្ញាតឱ្យ​ចុះហត្ថលេខា',
	'sign-sigadmin-currentlyclosed' => 'ការចុះហត្ថលេខា មិន​ត្រូវ​បាន​អនុញ្ញាត​សម្រាប់​ឯកសារ​នេះ​ទេ នាពេលនេះ​។',
	'sign-sigadmin-open' => 'អនុញ្ញាតឱ្យ​ចុះហត្ថលេខា',
	'sign-signatures' => 'ហត្ថលេខា',
	'sign-sigadmin-closesuccess' => 'ការចុះហត្ថលេខា​មិន​ត្រូវ​បាន​អនុញ្ញាត ដោយជោគជ័យ​ហើយ​។',
	'sign-sigadmin-opensuccess' => 'ការចុះហត្ថលេខា​ត្រូវ​បាន​អនុញ្ញាត ដោយជោគជ័យ​ហើយ​។',
	'sign-viewsignatures' => 'មើល​ហត្ថលេខា',
	'sign-closed' => 'ត្រូវបានបិទ',
	'sign-error-closed' => 'ការចុះហត្ថលេខា​លើ​ឯកសារ​នេះ មិន​ត្រូវ​បាន​អនុញ្ញាត​ទេ​ នាពេលនេះ​។',
	'sig-anonymous' => '<i>អនាមិក</i>',
	'sig-private' => '<i>ឯកជន</i>',
	'sign-sigdetails' => 'ហត្ថលេខា​លំអិត',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-viewfield-reviewedby' => 'អ្នកត្រួតពិនិត្យឡើងវិញ',
	'sign-viewfield-reviewcomment' => 'យោបល់',
	'sign-detail-uniquequery' => 'ធាតុបញ្ចូល​ស្រដៀងគ្នា',
	'sign-detail-strike' => 'ឆូត​ហត្ថលេខា',
	'sign-reviewsig' => 'ពិនិត្យ​ហត្ថលេខា​ឡើងវិញ',
	'sign-review-comment' => 'សេចក្ដីពន្យល់',
	'sign-submitreview' => 'ដាក់ស្នើ​ឱ្យ​ពិនិត្យឡើងវិញ',
	'sign-uniquequery-similarname' => 'ឈ្មោះស្រដៀងគ្នា',
	'sign-uniquequery-similaraddress' => 'អាសយដ្ឋានស្រដៀងគ្នា',
	'sign-uniquequery-similarphone' => 'ទូរស័ព្ទ​ស្រដៀងគ្នា',
	'sign-uniquequery-similaremail' => 'អ៊ីមែលស្រដៀងគ្នា',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'sign-viewfield-email' => 'E-mail',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'signdocument' => 'Dokkemänt ongerschriive',
	'sign-nodocselected' => 'Donn da Dokkemänt ußsöke, wat De ungerschriive wells.',
	'sign-selectdoc' => 'Dokkemänt:',
	'sign-docheader' => '<div class="noarticletext">Donn dat Formulaa bruche, öm dat Dokkemänt „[[$1]]“ ze ongerschriive, wat hee dronger aanjezeisch es.

Beß esu joot, un liß dat janze Dokkemänt. Wann De dämm dann Ding Zohshtemmung jiß, dann föll all de nüdejje Felder uß, för dat ze Ongerschriive.',
	'sign-error-nosuchdoc' => 'Dat Dokkemänt „$1“, woh De noh jefrooch häß, dat jidd_et jaa nit.',
	'sign-realname' => 'Name:',
	'sign-address' => 'Shtrohß un Nommer:',
	'sign-city' => 'Shtadt udder Dörp:',
	'sign-state' => 'Land udder Provinß:',
	'sign-zip' => 'Poßleizahl:',
	'sign-country' => 'Shtaat:',
	'sign-phone' => 'Tellefon-Nommer:',
	'sign-bday' => 'Allder:',
	'sign-email' => 'e-mail Address:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> dat Feld es nüdesch.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Opjepaß: Wat nit opjeliß es, dat künne de Moderatore trozdämm aankike.</i></small>',
	'sign-list-anonymous' => 'Namelos opliste',
	'sign-list-hideaddress' => 'De Addräß nit opliste',
	'sign-list-hideextaddress' => 'Shtadt, Shtaat, Land, un Poßtizahl nit opliste',
	'sign-list-hidephone' => 'De Tellefoon-Nummer nit opliste',
	'sign-list-hidebday' => 'Et Allder nit opliste',
	'sign-list-hideemail' => 'De <i lang="en">e-mail</i> Addräß nit opliste',
	'sign-submit' => 'Loß Jonn!',
	'sign-information' => '<div class="noarticletext">Merci, dat De Der de Zick jenumme häs, dorch hee dat Dokkemänt ze lässe.
Wann de dämm zostemme kanns, dann donn Ding Ongerstötzung dodorch ußdröcke, dat De hee unge de notwendijje Felder ußföllß, un dann op „{{int:sign-submit}}“ klecks.
Paß joot drop op, dat dat wat De övver Dech sellver enndrähß och rechtech es, un dat mer winnichsdens eine Wääch hät, öm met Der en Kuntack ze kumme, öm ze kike, wä De bes, un öm ze ovverpröfe, dat dat all ääsch es.
Opjepaß: Ding aktoälle IP-Addräß un ander ähnlijje Date wäde zosamme met dä Date us dämm Dommulaa faßjehallde. Se wäde vun de Moderatore jebruch, öm dubbel dijjitaale Ongerschreffte eruß ze sammelle, un de Rechtechkeit vun Ding päsönlejje Date eruß ze krijje.
Weil de Moderatore fö_jewööhnlesch esu en Pröfunge för Fobendunge övver offe, un namelos maachende <i lang="en">proxy server</i> täschnesch koum udder jaa nit maache künne, es et müjjelech, un beinah secher, dat Ungerschreffte övver esu en <i lang="en">proxies</i> nit jezallt weede.
Wann de jrad övver ene <i lang="en">proxy</i> am Netz am hange bes, dann bes esu joot, donn Dich för ene Momang vun em trenne, un nemm en nommaale Verbendung för et Ongerschriive.</div>

$1',
	'sig-success' => 'De häs dat Dokkemänt jäz eläktroonesch ungerschrevve.',
	'sign-view-selectfields' => '<b>De Felder för Aanzezeije:</b>',
	'sign-viewfield-entryid' => 'De Kennong odder Nommer för dä Enndraach',
	'sign-viewfield-timestamp' => 'Däm Dattum un dä Zick iere Stempel',
	'sign-viewfield-realname' => 'Name',
	'sign-viewfield-address' => 'Address',
	'sign-viewfield-city' => 'Shtadt udder Dörp',
	'sign-viewfield-state' => 'Land udder Provinß',
	'sign-viewfield-country' => 'Shtaat',
	'sign-viewfield-zip' => 'Poßleizahl',
	'sign-viewfield-ip' => 'IP-Address',
	'sign-viewfield-agent' => 'Brauser',
	'sign-viewfield-phone' => 'Tellefon-Nommer',
	'sign-viewfield-email' => 'e-mail',
	'sign-viewfield-age' => 'Allder',
	'sign-viewfield-options' => 'Ußwahle',
	'sign-viewsigs-intro' => 'Hee kütt en Leß met de Singnature för <span class="plainlinks">[{{SERVER}}{{localurl:Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Et Singneere es em Momänt ennjeschalldt för hee dat Dokkement.',
	'sign-sigadmin-close' => 'Singneere ußschallde',
	'sign-sigadmin-currentlyclosed' => 'Et Singneere es em Momänt ußjeschalldt för hee dat Dokkement.',
	'sign-sigadmin-open' => 'Singneere aanschallde',
	'sign-signatures' => 'Singnatuure',
	'sign-sigadmin-closesuccess' => 'Et Singneere es afjeschalldt.',
	'sign-sigadmin-opensuccess' => 'Et Singneere es enjeschalldt.',
	'sign-viewsignatures' => 'de Ongerschreffte beloore',
	'sign-closed' => 'afjeschloße',
	'sign-error-closed' => 'Et Ongerschriive för dat Dokkemänt is em Momang affjeschalldt.',
	'sig-anonymous' => '<i>Nameloss</i>',
	'sig-private' => '<i>Prevaat</i>',
	'sign-sigdetails' => 'Einzelheite fun dä Ongerschreff',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|{{ns:talk}}]] • <!--
-->[[Special:Contributions/$1|Beidrääsch]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|Metmaacher sperre]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} Logboch med de Medmaachersperre] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} Metmaacher Pröfe])<!--
--></span>',
	'sign-viewfield-stricken' => 'Ußjeshtresche',
	'sign-viewfield-reviewedby' => 'Wä de Ongerschreff nohjeprüüf hät',
	'sign-viewfield-reviewcomment' => 'Kommäntaa',
	'sign-detail-uniquequery' => 'Ähnlijje Enndräsch',
	'sign-detail-uniquequery-run' => 'Affroch loufe lohße',
	'sign-detail-strike' => 'De Ongerschreff ußshtiishe',
	'sign-reviewsig' => 'De Ongerschreff nohloore',
	'sign-review-comment' => 'Kommäntaa',
	'sign-submitreview' => 'Dä Pröfungsbereesh afschecke',
	'sign-uniquequery-similarname' => 'Ähnlijje Name',
	'sign-uniquequery-similaraddress' => 'Ähnlijje Addresse',
	'sign-uniquequery-similarphone' => 'Ähnlijje Tellefon-Nommere',
	'sign-uniquequery-similaremail' => 'Ähnlijje <i lang="en">e-mail</i> Adresse',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] hät [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2] ungerschrevve.',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'sign-realname' => 'Nomen:',
	'sign-city' => 'Urbs:',
	'sign-viewfield-realname' => 'Nomen',
	'sign-viewfield-city' => 'Urbs',
	'sign-viewfield-reviewcomment' => 'Sententia',
	'sign-review-comment' => 'Sententia',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'signdocument' => 'Dokument ënnerschreiwen',
	'sign-nodocselected' => 'Wielt w.e.g dat Dokument aus dat Dir ënenrschreiwe wëllt.',
	'sign-selectdoc' => 'Dokument:',
	'sign-error-nosuchdoc' => 'Dat Dokument, dat Dir ugefrot hutt ($1), gëtt et net.',
	'sign-realname' => 'Numm:',
	'sign-city' => 'Stad/Gemeng:',
	'sign-state' => 'Staat:',
	'sign-zip' => 'Postleitzuel:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telefonsnummer:',
	'sign-bday' => 'Alter:',
	'sign-email' => 'E-Mail-Adress:',
	'sign-list-anonymous' => 'Als anonym weisen',
	'sign-list-hideaddress' => 'Adress net weisen',
	'sign-list-hidephone' => "D'Telefeonsnummer net weisen",
	'sign-list-hidebday' => 'Den Alter net weisen',
	'sign-list-hideemail' => "D'E-Mailadress net weisen",
	'sign-submit' => 'Dokument ënnerschreiwen',
	'sig-success' => "Dir hutt d'Dokument ënnerschriwwen",
	'sign-view-selectfields' => '<b>Felder déi gewise solle ginn:</b>',
	'sign-viewfield-timestamp' => 'Datum an Auerzäit',
	'sign-viewfield-realname' => 'Numm',
	'sign-viewfield-address' => 'Adress',
	'sign-viewfield-city' => 'Stad/Gemeng',
	'sign-viewfield-state' => 'Staat (Departement oder Provënz)',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-zip' => 'Postcode',
	'sign-viewfield-ip' => 'IP-Adress',
	'sign-viewfield-phone' => 'Telefonsnummer',
	'sign-viewfield-email' => 'E-Mail',
	'sign-viewfield-age' => 'Alter',
	'sign-viewfield-options' => 'Optiounen',
	'sign-sigadmin-currentlyopen' => 'Ënnerschreiwen ass elo fir dëst Dokument ageschalt.',
	'sign-sigadmin-close' => 'Ënnerschreiwen ausschalten',
	'sign-sigadmin-currentlyclosed' => 'Ënnerschreiwen ass elo fir dëst Dokument ausgeschalt.',
	'sign-sigadmin-open' => 'Ënnerchreiwen aschalten',
	'sign-signatures' => 'Ënnerschreften',
	'sign-sigadmin-closesuccess' => 'ënnerschreiwen ausgeschalt',
	'sign-sigadmin-opensuccess' => 'Ënnerschreiwen agechalt',
	'sign-viewsignatures' => 'Ënnerschrëfte weisen',
	'sign-closed' => 'zou',
	'sig-anonymous' => '<i>Anonym</i>',
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Detailer vun der Ënnerschrëft',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-viewfield-stricken' => 'Duerchgestrach',
	'sign-viewfield-reviewedby' => 'Reviseur',
	'sign-viewfield-reviewcomment' => 'Bemierkung',
	'sign-detail-strike' => 'Ënnerschreft duerchsträichen',
	'sign-reviewsig' => 'Ënnerschrëft nokucken',
	'sign-review-comment' => 'Bemierkung',
	'sign-uniquequery-similarname' => 'Ähnleche Numm',
	'sign-uniquequery-similaraddress' => 'Ähnlech Adress',
	'sign-uniquequery-similarphone' => 'Ähnlech Telefonsnummer',
	'sign-uniquequery-similaremail' => 'Ähnlech E-Mailadress',
);

/** Lithuanian (Lietuvių)
 * @author Tomasdd
 */
$messages['lt'] = array(
	'sign-realname' => 'Vardas:',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'sign-viewfield-email' => 'Электрон почто',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'signdocument' => 'പ്രമാണത്തില്‍ ഒപ്പിടുക',
	'sign-nodocselected' => 'താങ്കള്‍ ഒപ്പിടുവാന്‍ ആഗ്രഹിക്കുന്ന പ്രമാണം തിരഞ്ഞെടുക്കുക',
	'sign-selectdoc' => 'പ്രമാണം:',
	'sign-error-nosuchdoc' => 'താങ്കള്‍ ആവശ്യപ്പെട്ട പ്രമാണം ($1) നിലവിലില്ല.',
	'sign-realname' => 'പേര്‌:',
	'sign-address' => 'വിലാസം:',
	'sign-city' => 'പട്ടണം:',
	'sign-state' => 'സംസ്ഥാനം:',
	'sign-zip' => 'സിപ്പ് കോഡ്:',
	'sign-country' => 'രാജ്യം:',
	'sign-phone' => 'ഫോണ്‍ നമ്പര്‍:',
	'sign-bday' => 'വയസ്സ്',
	'sign-email' => 'ഇമെയില്‍ വിലാസം:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> നിര്‍ബന്ധമായും ചേര്‍ക്കേണ്ട ഫീല്‍ഡിനെ സൂചിപ്പിക്കുന്നു.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> കുറിപ്പ്: പട്ടികയില്‍ ചേര്‍ത്തിട്ടില്ലാത്ത വിവരങ്ങള്‍ മോഡരേറ്ററുമാര്‍ക്ക് ഇപ്പോഴും ദൃശ്യമാകും.</i></small>',
	'sign-list-hideaddress' => 'വിലാസം പ്രദര്‍ശിപ്പിക്കരുത്',
	'sign-list-hideextaddress' => 'നഗരം, സംസ്ഥാനം, സിപ്പ് കോഡ്, രാജ്യം എന്നിവ പ്രദര്‍ശിപ്പിക്കരുത്',
	'sign-list-hidephone' => 'ഫോണ്‍ നമ്പര്‍ പ്രദര്‍ശിപ്പിക്കരുത്',
	'sign-list-hidebday' => 'വയസ്സ് പ്രദര്‍ശിപ്പിക്കരുത്',
	'sign-list-hideemail' => 'ഇമെയില്‍ വിലാസം പ്രദര്‍ശിപ്പിക്കരുത്',
	'sign-submit' => 'പ്രമാണത്തില്‍ ഒപ്പിടുക',
	'sig-success' => 'താങ്കള്‍ പ്രമാണത്തില്‍ വിജയകരമായി ഒപ്പിട്ടിരിക്കുന്നു.',
	'sign-view-selectfields' => '<b>പ്രദര്‍ശിപ്പിക്കേണ്ട ഫീല്‍ഡുകള്‍:</b>',
	'sign-viewfield-realname' => 'പേര്‌',
	'sign-viewfield-address' => 'വിലാസം',
	'sign-viewfield-city' => 'പട്ടണം',
	'sign-viewfield-state' => 'സംസ്ഥാനം',
	'sign-viewfield-country' => 'രാജ്യം',
	'sign-viewfield-zip' => 'സിപ്പ്',
	'sign-viewfield-ip' => 'ഐപി വിലാസം',
	'sign-viewfield-phone' => 'ഫോണ്‍',
	'sign-viewfield-email' => 'ഇമെയില്‍',
	'sign-viewfield-age' => 'വയസ്സ്',
	'sign-sigadmin-close' => 'ഒപ്പിടല്‍ നിരോധിക്കുക',
	'sign-sigadmin-currentlyclosed' => 'ഈ പ്രമാണത്തില്‍ നിലവില്‍ ഒപ്പിടല്‍ നിരോധിച്ചിരിക്കുന്നു.',
	'sign-sigadmin-open' => 'ഒപ്പിടല്‍ അനുവദിക്കുക',
	'sign-signatures' => 'ഒപ്പുകള്‍',
	'sign-sigadmin-closesuccess' => 'ഒപ്പിടല്‍ വിജയകരമായി നിരോധിച്ചിരിക്കുന്നു.',
	'sign-sigadmin-opensuccess' => 'ഒപ്പിടല്‍ വിജയകരമായി അനുവദിച്ചിരിക്കുന്നു.',
	'sign-viewsignatures' => 'ഒപ്പുകള്‍ കാണുക',
	'sign-closed' => 'അടച്ചു',
	'sign-error-closed' => 'ഈ പ്രമാണത്തില്‍ ഒപ്പിടല്‍ നിലവില്‍ നിരോധിച്ചിരിക്കുന്നു.',
	'sig-anonymous' => '<i>അജ്ഞാതം</i>',
	'sig-private' => "''സ്വകാര്യം''",
	'sign-sigdetails' => 'ഒപ്പിന്റെ വിവരങ്ങള്‍',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-viewfield-reviewedby' => 'സം‌ശോധകന്‍',
	'sign-viewfield-reviewcomment' => 'അഭിപ്രായം',
	'sign-detail-strike' => 'ഒപ്പ് വെട്ടുക',
	'sign-reviewsig' => 'ഒപ്പ് സംശോധനം ചെയ്യുക',
	'sign-review-comment' => 'അഭിപ്രായം',
	'sign-submitreview' => 'സംശോധനം ചെയ്തത് സമര്‍പ്പിക്കുക',
	'sign-uniquequery-similarname' => 'ഒരേപോലുള്ള പേര്‌',
	'sign-uniquequery-similaraddress' => 'ഒരേപോലുള്ള വിലാസം',
	'sign-uniquequery-similarphone' => 'ഒരേപോലുള്ള ഫോണ്‍',
	'sign-uniquequery-similaremail' => 'ഒരേ പോലുള്ള ഇമെയില്‍',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1],  [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2]ല്‍ ഒപ്പിട്ടു.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'signdocument' => 'डक्यूमेंट वर सही करा',
	'sign-nodocselected' => 'तुम्ही सही करू इच्छित असलेले डक्यूमेंट निवडा.',
	'sign-selectdoc' => 'डक्यूमेंट:',
	'sign-docheader' => '<div class="noarticletext">खाली दाखविलेल्या डॉक्यूमेंट "[[$1]]" वर सही करण्यासाठी हा अर्ज वापरा.
कृपया संपूर्ण डॉक्यूमेंट वाचा, व जर तुम्ही त्यामधील मजकूराशी सहमत असाल, तर कृपया योग्य ते रकाने भरून सही करा.</div>',
	'sign-error-nosuchdoc' => 'मागितलेले डक्यूमेंट ($1) अस्तित्वात नाही',
	'sign-realname' => 'नाव:',
	'sign-address' => 'रस्ता पत्ता:',
	'sign-city' => 'शहर:',
	'sign-state' => 'राज्य:',
	'sign-zip' => 'झिप कोड:',
	'sign-country' => 'देश:',
	'sign-phone' => 'दूरध्वनी क्रमांक:',
	'sign-bday' => 'वय:',
	'sign-email' => 'इ-मेल पत्ता:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> आवश्यक रकाने दर्शवितो.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> सूचना: प्रबंधकांना यादीत नसलेली माहिती सुद्धा पाहता येईल.</i></small>',
	'sign-list-anonymous' => 'अनामिक म्हणून नोंद करा',
	'sign-list-hideaddress' => 'पत्त्याची नोंद करू नका',
	'sign-list-hideextaddress' => 'शहर, राज्य, झिप व देश यांची नोंद करू नका',
	'sign-list-hidephone' => 'दूरध्वनी क्रमांकाची नोंद करू नका',
	'sign-list-hidebday' => 'वयाची नोंद करू नका',
	'sign-list-hideemail' => 'इ-मेल ची नोंद करू नका',
	'sign-submit' => 'डक्यूमेंट वर सही करा',
	'sign-information' => '<div class="noarticletext">हे डॉक्यूमेंट वाचण्यासाठी वेळ काढल्याबद्दल धन्यवाद.
जर तुम्ही त्याच्याशी सहमत असाल, तर खालील योग्यते रकाने भरून व "डॉक्यूमेंट वर सही करा" या कळीवर टिचकी देऊन तुमची सहमती द्या.
कृपया तपासून पहा की तुमची वैयक्तिक माहिती खरी आहे व तुमच्याशी संपर्क करण्याचे काहीतरी माध्यम उपलब्ध आहे.
कृपया लक्षात असू द्या की तुमचा आयपी अंकपत्ता व इतर माहिती या अर्जासमवेत नोंदली जाईल. ज्यामुळे प्रबंधकांना परत परत केलेल्या सह्या वगळता येतील व तुमची माहिती तपासून पाहता येईल.
उघड्या व अनामिक प्रॉक्सींमध्ये हे कार्य करणे शक्य होत नाही त्यामुळे अशा प्रॉक्सी वापरून केलेल्या सह्या ग्राह्य धरल्या जाणार नाहीत.
जर तुम्ही प्रॉक्सी वापरत असाल तर कृपया दुसर्‍या कनेक्शन मधून सही करा.</div>

$1',
	'sig-success' => 'तुम्ही यशस्वीरित्या डॉक्यूमेंटवर सही केलेली आहे.',
	'sign-view-selectfields' => '<b>हे रकाने दाखवा:</b>',
	'sign-viewfield-entryid' => 'नोंद क्र',
	'sign-viewfield-timestamp' => 'वेळशिक्का',
	'sign-viewfield-realname' => 'नाव',
	'sign-viewfield-address' => 'पत्ता',
	'sign-viewfield-city' => 'शहर',
	'sign-viewfield-state' => 'राज्य',
	'sign-viewfield-country' => 'देश',
	'sign-viewfield-zip' => 'झीप(पीन)',
	'sign-viewfield-ip' => 'आयपी अंकपत्ता:',
	'sign-viewfield-agent' => 'सदस्य एजंट',
	'sign-viewfield-phone' => 'दूरध्वनी',
	'sign-viewfield-email' => 'विपत्र',
	'sign-viewfield-age' => 'वय',
	'sign-viewfield-options' => 'विकल्प',
	'sign-viewsigs-intro' => 'खाली <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span> साठी नोंदल्या गेलेल्या सह्या दर्शविल्या आहेत.',
	'sign-sigadmin-currentlyopen' => 'या डॉक्यूमेंटवर सही करता येऊ शकते.',
	'sign-sigadmin-close' => 'सही करण्यावर बंदी घाला',
	'sign-sigadmin-currentlyclosed' => 'या डॉक्यूमेंटवर सध्या सही करता येत नाही.',
	'sign-sigadmin-open' => 'सही करण्याची परवानगी द्या',
	'sign-signatures' => 'सह्या',
	'sign-sigadmin-closesuccess' => 'सही करणे बंद केले.',
	'sign-sigadmin-opensuccess' => 'सही करणे सुरू केले.',
	'sign-viewsignatures' => 'सह्या पहा',
	'sign-closed' => 'बंद केलेले',
	'sign-error-closed' => 'या डॉक्यूमेंटवर सध्या सही करता येत नाही.',
	'sig-anonymous' => '<i>अनामिक</i>',
	'sig-private' => '<i>खाजगी</i>',
	'sign-sigdetails' => 'सही माहिती',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|चर्चा]] • <!--
-->[[Special:Contributions/$1|योगदान]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|सदस्याला ब्लक करा]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} ब्लक नोंदी] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} आयपी तपासा])<!--
--></span>',
	'sign-viewfield-stricken' => 'स्ट्राईकन',
	'sign-viewfield-reviewedby' => 'तपासनीस',
	'sign-viewfield-reviewcomment' => 'शेरा',
	'sign-detail-uniquequery' => 'सारख्या एन्टिटीज',
	'sign-detail-uniquequery-run' => 'पृच्छा चालवा',
	'sign-detail-strike' => 'सही ठोका',
	'sign-reviewsig' => 'सही पुन्हा तपासा',
	'sign-review-comment' => 'शेरा',
	'sign-submitreview' => 'अहवाल पाठवा',
	'sign-uniquequery-similarname' => 'सारखे नाव',
	'sign-uniquequery-similaraddress' => 'सारखा पत्ता',
	'sign-uniquequery-similarphone' => 'सारखा दूरध्वनी',
	'sign-uniquequery-similaremail' => 'तसलेच विपत्र',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] ने [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2] वर सही केली.',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 */
$messages['ms'] = array(
	'sign-viewfield-agent' => 'Ejen pengguna',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-reviewcomment' => 'Kumment',
	'sign-review-comment' => 'Kumment',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'sign-realname' => 'Леметь:',
	'sign-city' => 'Ошось:',
	'sign-state' => 'Штатось:',
	'sign-country' => 'Масторось:',
	'sign-bday' => 'Иеть:',
	'sign-viewfield-realname' => 'Леметь',
	'sign-viewfield-address' => 'Сёрма парго',
	'sign-viewfield-city' => 'Ош',
	'sign-viewfield-state' => 'Штат',
	'sign-viewfield-country' => 'Мастор',
	'sign-viewfield-zip' => 'Код',
	'sign-viewfield-phone' => 'Телефон',
	'sign-closed' => 'пекстазь',
	'sig-anonymous' => '<i>Лемтеме</i>',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'sign-realname' => 'Tōcāitl:',
	'sign-address' => 'Ohcān:',
	'sign-city' => 'Āltepētl:',
	'sign-state' => 'Tlahtōcāyōtl:',
	'sign-country' => 'Tlācatiyān:',
	'sign-viewfield-realname' => 'Tōcāitl',
	'sign-viewfield-address' => 'Tlacān',
	'sign-viewfield-city' => 'Āltepētl',
	'sign-viewfield-state' => 'Tlahtōcāyōtl',
	'sign-viewfield-country' => 'Tlācatiyān',
	'sign-viewfield-ip' => 'IP',
	'sign-viewfield-email' => 'E-mail',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'signdocument' => 'Document ondertekenen',
	'sign-nodocselected' => 'Selecteer het document dat u wilt ondertekenen.',
	'sign-selectdoc' => 'Document:',
	'sign-docheader' => '<div class="noarticletext">Gebruik dit formulier om het document "[[$1]]" te ondertekenen, dat hieronder wordt weergeven.
Lees het hele document en als u het wilt steunen vul dan de verplichte velden in om het te ondertekenen.</div>',
	'sign-error-nosuchdoc' => 'Het opgegeven document ($1) bestaat niet.',
	'sign-realname' => 'Naam:',
	'sign-address' => 'Straat:',
	'sign-city' => 'Plaats:',
	'sign-state' => 'Staat:',
	'sign-zip' => 'Postcode:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telefoonnummer:',
	'sign-bday' => 'Leeftijd:',
	'sign-email' => 'E-mailadres:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> geeft verplichte velden aan.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Nota bene: Informatie die niet wordt weergegeven, blijft zichtbaar voor beheerders.</i></small>',
	'sign-list-anonymous' => 'Neem anoniem deel',
	'sign-list-hideaddress' => 'Verberg straat',
	'sign-list-hideextaddress' => 'Verberg plaats, staat, postcode en/of land',
	'sign-list-hidephone' => 'Verberg telefoonnummer',
	'sign-list-hidebday' => 'Verberg leeftijd',
	'sign-list-hideemail' => 'Verberg e-mailadres',
	'sign-submit' => 'Document ondertekenen',
	'sign-information' => '<div class="noarticletext">Dank u wel voor het nemen van de tijd om dit document door te lezen.
Als u ermee instemt, geef uw steun dan alstublieft aan door hieronder de benodigde velden in te vullen en daar te klikken op "Document ondertekenen."
Zorg er alstublieft voor dat uw persoonlijke informatie correct is en dat we op een of andere manier contact met u kunnen opnemen.
om uw identiteit te bevestigen.
Uw IP-adres en andere identificerende informatie die via dit formulier woren opgeslagen, worden gebruikt voor beheerders om dubbele ondertekeningen te verwijderen en om de juistheid van uw persoonlijke informatie te toetsen.
Omdat het gebruik van open en anonimiserende proxy\'s voorkomt dat deze taak uitgevoerd kan worden, worden ondertekeningen via deze wegen waarschijnlijk niet meegeteld.
Als u op dit moment verbonden bent via een proxyserver, maak dan voor het ondertekenen een directe verbinding.</div>

$1',
	'sig-success' => 'U hebt het document ondertekend.',
	'sign-view-selectfields' => '<b>Weer te geven velden:</b>',
	'sign-viewfield-entryid' => 'ID-nummer',
	'sign-viewfield-timestamp' => 'Tijdstip',
	'sign-viewfield-realname' => 'Naam',
	'sign-viewfield-address' => 'Adres',
	'sign-viewfield-city' => 'Plaats',
	'sign-viewfield-state' => 'Staat',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-zip' => 'Postcode',
	'sign-viewfield-ip' => 'IP-address',
	'sign-viewfield-agent' => 'User agent',
	'sign-viewfield-phone' => 'Telefoonnummer',
	'sign-viewfield-email' => 'E-mailadres',
	'sign-viewfield-age' => 'Leeftijd',
	'sign-viewfield-options' => 'Opties',
	'sign-viewsigs-intro' => 'Hieronder worden de ondertekeningen weergegeven voor <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Ondertekenen is ingeschakeld voor dit document.',
	'sign-sigadmin-close' => 'Onderteken uitschakelen',
	'sign-sigadmin-currentlyclosed' => 'Onderteken is uitgeschakeld voor dit document.',
	'sign-sigadmin-open' => 'Ondertekenen inschakelen',
	'sign-signatures' => 'Ondertekeningen',
	'sign-sigadmin-closesuccess' => 'Ondertekenen uitgeschakeld.',
	'sign-sigadmin-opensuccess' => 'Ondertekenen ingeschakeld.',
	'sign-viewsignatures' => 'ondertekeningen bekijken',
	'sign-closed' => 'gesloten',
	'sign-error-closed' => 'Onderteken eis uitgeschakeld voor dit document.',
	'sig-anonymous' => '<i>Anoniem</i>',
	'sig-private' => '<i>Privé</i>',
	'sign-sigdetails' => 'Ondertekeningsdetails',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|overleg]] • <!--
-->[[Special:Contributions/$1|bijdragen]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBL\'s] • <!--
-->[[Special:BlockIP/$1|gebruiker blokkeren]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} blokkeerlogboek] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} IP-adres controleren])<!--
--></span>',
	'sign-viewfield-stricken' => 'Doorgehaald',
	'sign-viewfield-reviewedby' => 'Controleur',
	'sign-viewfield-reviewcomment' => 'Opmerking',
	'sign-detail-uniquequery' => 'Gelijkaardige entiteiten',
	'sign-detail-uniquequery-run' => 'Zoekopdracht uitvoeren',
	'sign-detail-strike' => 'Ondertekening doorhalen',
	'sign-reviewsig' => 'Ondertekening controleren',
	'sign-review-comment' => 'Opmerking',
	'sign-submitreview' => 'Controle opslaan',
	'sign-uniquequery-similarname' => 'Gelijkaardige naam',
	'sign-uniquequery-similaraddress' => 'Gelijkaardige adres',
	'sign-uniquequery-similarphone' => 'Gelijkaardige telefoonnummer',
	'sign-uniquequery-similaremail' => 'Gelijkaardige e-mailadres',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] ondertekende [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'signdocument' => 'Signer dokument',
	'sign-nodocselected' => 'Vel dokumentet du ønskjer å signera.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => '<div class="noarticletext">Nytt dette skjemaet for å signera dokumentet «[[$1]]» vist nedanfor. Ver venleg les gjennom heile dokumentet, og om du ønskjer å syna di støtta for det, fyll inn dei nødvendige felta for å signera.</div>',
	'sign-error-nosuchdoc' => 'Dokumentet du etterspurde ($1) finst ikkje.',
	'sign-realname' => 'Namn:',
	'sign-address' => 'Gateaddressa:',
	'sign-city' => 'By:',
	'sign-state' => 'Delstat, fylke, etc.:',
	'sign-zip' => 'Postnummer:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telefonnummer:',
	'sign-bday' => 'Alder:',
	'sign-email' => 'E-postadressa:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> indikerer felt som må bli fylte ut.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Merk: Informasjon som ikkje blir lista opp vil framleis vera synleg for moderatorar.</i></small>',
	'sign-list-anonymous' => 'List opp anonymt',
	'sign-list-hideaddress' => 'Ikkje list opp adressa',
	'sign-list-hideextaddress' => 'Ikkje list opp by, stat, postnummer eller land',
	'sign-list-hidephone' => 'Ikkje list opp telefonnummer',
	'sign-list-hidebday' => 'Ikkje list opp alder',
	'sign-list-hideemail' => 'Ikkje list opp e-post',
	'sign-submit' => 'Signer dokumentet',
	'sign-information' => '<div class="noarticletext">Takk for at du har teke deg tida til å lesa gjennom dokumentet. Om du er einig med det, syn støtta di ved å fylla inn dei nødvendige felta nedanfor og trykk «Signer dokumentet». Gjer deg viss om at personleg informasjon er korrekt, og at me har ein måte å kontakta deg på for å stadfesta identiteten din. Merk at IP-adressa di og annan identifiserbar informasjon vil bli nytta av moderatorar for å eliminera duplikatsignaturar og for å stadfesta at den personlege informasjonen din er korrekt. Sidan nyttinga av opne og anonymiserande proxyar hindrar evna vår til å gjera dette, vil signaturar frå slike proxyar truleg ikkje bli talde. Om du er tilkopla via ein proxytenar, kopl deg frå han og nytt ei vanleg tilkopling når du signerer.</div>

$1',
	'sig-success' => 'Du har signert dokumentet.',
	'sign-view-selectfields' => '<b>Felt som skal bli viste:</b>',
	'sign-viewfield-entryid' => 'Innskrifts-ID',
	'sign-viewfield-timestamp' => 'Tidsmerke',
	'sign-viewfield-realname' => 'Namn',
	'sign-viewfield-address' => 'Adressa',
	'sign-viewfield-city' => 'By',
	'sign-viewfield-state' => 'Delstat, fylke, etc.',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-zip' => 'Postnummer',
	'sign-viewfield-ip' => 'IP-adressa',
	'sign-viewfield-agent' => 'Brukaragent',
	'sign-viewfield-phone' => 'Telefonnummer',
	'sign-viewfield-email' => 'E-post',
	'sign-viewfield-age' => 'Alder',
	'sign-viewfield-options' => 'Val',
	'sign-viewsigs-intro' => 'Under er dei oppsamla signaturane for <span class="plainlinks">[{{fullurl:Special:SignDocument|doc=$2}} $1]</span> viste.',
	'sign-sigadmin-currentlyopen' => 'Signering er slege på for dette dokumentet.',
	'sign-sigadmin-close' => 'Slå av signering',
	'sign-sigadmin-currentlyclosed' => 'Signering er slege av for dette dokumentet.',
	'sign-sigadmin-open' => 'Slå på signering',
	'sign-signatures' => 'Signaturar',
	'sign-sigadmin-closesuccess' => 'Signering blei slege av.',
	'sign-sigadmin-opensuccess' => 'Signering blei slege på.',
	'sign-viewsignatures' => 'syn signaturar',
	'sign-closed' => 'stengd',
	'sign-error-closed' => 'Signering av dette dokumentet er slege av.',
	'sig-anonymous' => '<i>Anonym</i>',
	'sig-private' => '<i>Privat</i>',
	'sign-sigdetails' => 'Signaturdetaljar',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|diskusjon]] • <!--
-->[[Special:Contributions/$1|bidrag]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBL-ar] • <!--
-->[[Special:BlockIP/$1|blokker]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} blokkeringslogg] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} sjekk IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'Stroke',
	'sign-viewfield-reviewedby' => 'Gjennomgåar',
	'sign-viewfield-reviewcomment' => 'Kommentar',
	'sign-detail-uniquequery' => 'Liknande einingar',
	'sign-detail-uniquequery-run' => 'Køyr spørjing',
	'sign-detail-strike' => 'Stryk signatur',
	'sign-reviewsig' => 'Sjå over signatur',
	'sign-review-comment' => 'Kommentar',
	'sign-submitreview' => 'Send inn gjennomgang',
	'sign-uniquequery-similarname' => 'Liknande namn',
	'sign-uniquequery-similaraddress' => 'Liknande adressa',
	'sign-uniquequery-similarphone' => 'Liknande telefonnummer',
	'sign-uniquequery-similaremail' => 'Liknande e-postadressa',
	'sign-uniquequery-1signed2' => '[{{fullurl:Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] signerte [{{fullurl:Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'signdocument' => 'Signer dokument',
	'sign-nodocselected' => 'Vennligst velg dokumentet du ønsker å signere.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => '<div class="noarticletext">Bruk dette skjemaet for å signere dokumentet «[[$1]]» vist nedenunder. Vennligst les gjennom hele dokumentet, og om du ønsker å vise din støtte for det, fyll inn de nødvendige feltene for å signere.</div>',
	'sign-error-nosuchdoc' => 'Dokumentet du etterspurte ($1) finnes ikke.',
	'sign-realname' => 'Navn:',
	'sign-address' => 'Hjemmeadresse:',
	'sign-city' => 'By:',
	'sign-state' => 'Delstat, fylke, etc.:',
	'sign-zip' => 'Postnummer:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telefonnummer:',
	'sign-bday' => 'Alder:',
	'sign-email' => 'E-postadresse:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> indikerer felt som må fylles ut.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Merk: Informasjon som ikke listes opp vil fortsatt kunne ses av moderatorer.</i></small>',
	'sign-list-anonymous' => 'List opp anonymt',
	'sign-list-hideaddress' => 'Ikke list opp adresse',
	'sign-list-hideextaddress' => 'Ikke list opp by, stat, postnummer eller land',
	'sign-list-hidephone' => 'Ikke list opp telefonnummer',
	'sign-list-hidebday' => 'Ikke list opp alder',
	'sign-list-hideemail' => 'Ikke list opp e-post',
	'sign-submit' => 'Signer dokumentet',
	'sign-information' => '<div class="noarticletext">Takk for at du har tatt deg tiden til å lese gjennom dokumentet. Om du er enig med det, vis din støtte ved å fylle inn de nødvendige feltene nedenfor og klikke «Signer dokumentet». Forsikre deg om at personlig informasjon er korrekt, og at vi har en måte å kontakte deg på for å bekrefte din identitet. Merk at din IP-adresse og annen identifiserbar informasjon vil bli brukt av moderatorer for å eliminere duplikatsignaturer og bekrefte korrektheten av din personlige informasjon. Siden bruken av åpne og anonymiserende proxyer hindrer vår evne til å gjøre dette, vil signaturer fra slike proxyer trolig ikke telles. Om du er tilkoblet via en proxytjener, koble fra denne og bruk en vanlig tilkobling når du signerer.</div>

$1',
	'sig-success' => 'Du har signert dokumentet.',
	'sign-view-selectfields' => '<b>Felter som vises:</b>',
	'sign-viewfield-entryid' => 'Innskrifts-ID',
	'sign-viewfield-timestamp' => 'Tidsmerke',
	'sign-viewfield-realname' => 'Navn',
	'sign-viewfield-address' => 'Adresse',
	'sign-viewfield-city' => 'By',
	'sign-viewfield-state' => 'Delstat, fylke, etc.',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-zip' => 'Postnummer',
	'sign-viewfield-ip' => 'IP-adresse',
	'sign-viewfield-agent' => 'Brukeragent',
	'sign-viewfield-phone' => 'Telefonnummer',
	'sign-viewfield-email' => 'E-post',
	'sign-viewfield-age' => 'Alder',
	'sign-viewfield-options' => 'Alternativer',
	'sign-viewsigs-intro' => 'Under vises de oppsamlede signaturene for <span class="plainlinks">[{{fullurl:Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Signering er slått på for dette dokumentet.',
	'sign-sigadmin-close' => 'Slå av signering',
	'sign-sigadmin-currentlyclosed' => 'Signering er slått av for dette dokumentet.',
	'sign-sigadmin-open' => 'Slå på signering',
	'sign-signatures' => 'Signaturer',
	'sign-sigadmin-closesuccess' => 'Signering ble slått av.',
	'sign-sigadmin-opensuccess' => 'Signering ble slått på.',
	'sign-viewsignatures' => 'vis signaturer',
	'sign-closed' => 'stengt',
	'sign-error-closed' => 'Signering av dette dokumentet er slått av.',
	'sig-anonymous' => '<i>Anonym</i>',
	'sig-private' => '<i>Privat</i>',
	'sign-sigdetails' => 'Signaturdetaljer',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|diskusjon]] • <!--
-->[[Special:Contributions/$1|bidrag]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBL-er] • <!--
-->[[Special:BlockIP/$1|blokker]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} blokkeringslogg] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} sjekk IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'Strøket',
	'sign-viewfield-reviewedby' => 'Gjennomgangsperson',
	'sign-viewfield-reviewcomment' => 'Kommentar',
	'sign-detail-uniquequery' => 'Lignende entiteter',
	'sign-detail-uniquequery-run' => 'Kjør spørring',
	'sign-detail-strike' => 'Stryk signatur',
	'sign-reviewsig' => 'Se over signatur',
	'sign-review-comment' => 'Kommentar',
	'sign-submitreview' => 'Send inn gjennomgang',
	'sign-uniquequery-similarname' => 'Lignende navn',
	'sign-uniquequery-similaraddress' => 'Lignende adresse',
	'sign-uniquequery-similarphone' => 'Lignende telefonnummer',
	'sign-uniquequery-similaremail' => 'Lignende e-postadresse',
	'sign-uniquequery-1signed2' => '[{{fullurl:Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] signerte [{{fullurl:Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'sign-realname' => 'Leina:',
	'sign-city' => 'Toropo:',
	'sign-country' => 'Naga:',
	'sign-bday' => 'Mengwaga:',
	'sign-email' => 'Email atrese:',
	'sign-viewfield-realname' => 'Leina',
	'sign-viewfield-city' => 'Toropo',
	'sign-viewfield-country' => 'Naga',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'signdocument' => 'Autentificar lo document',
	'sign-nodocselected' => 'Mercés de causir lo document que volètz autentificar',
	'sign-selectdoc' => 'Document :',
	'sign-docheader' => '<div class="noarticletext">Mercés d\'utilizar aqueste formulari per autentificar lo document « [[$1]] » afichat çaijós. Legissètz lo document al complet, e se desiratz significar vòstre sosten, emplenatz los camps per l\'autentificar.</div>',
	'sign-error-nosuchdoc' => 'Lo document demandat ($1) existís pas.',
	'sign-realname' => 'Nom :',
	'sign-address' => 'Adreça civica :',
	'sign-city' => 'Vila :',
	'sign-state' => 'Estat, departament o província :',
	'sign-zip' => 'Còde postal :',
	'sign-country' => 'País :',
	'sign-phone' => 'Numèro de telèfon :',
	'sign-bday' => 'Edat :',
	'sign-email' => 'Adreça de corrièr electronic :',
	'sign-indicates-req' => '<small><i><font color="red">*</font> indica los camps obligatòris.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Las entresenhas pas listadas son totjorn visiblas pels moderaires.</i></small>',
	'sign-list-anonymous' => 'Listar de biais anonim',
	'sign-list-hideaddress' => "Listar pas l'adreça",
	'sign-list-hideextaddress' => "Listar pas la vila, l'estat (lo departament o la província), lo còde postal o lo país",
	'sign-list-hidephone' => 'Listar pas lo numèro de telèfon',
	'sign-list-hidebday' => "Listar pas l'edat",
	'sign-list-hideemail' => "Listar pas l'adreça de corrièr electronic",
	'sign-submit' => 'Autentificar lo document',
	'sign-information' => "<div class=\"noarticletext\">Mercés d'aver complètament legit aqueste document. Se sètz d'acòrdi amb son contengut, significatz vòstre sosten en emplenant los camps requeses çaijós e en clicant « Autentificar document ». Mercés de verificar que vòstras entresenhas personalas son exactas e qu'avèm un mejan de vos contactar per validar vòstra identitat. Vòstra adreça IP e d'autras entresenhas que vos pòdon identificar son notadas e seràn utilizadas pels moderaires per eliminar de signaturas en doblon e confirmar las entresenhas picadas. Los proxys nos permeton pas d'identificar de segur lo signatari, las signaturas obtengudas a travèrs los proxys seràn probablament pas comptadas. Se sètz connectat a travèrs un proxy, mercés d'utilizar un compte que l'utiliza pas.</div>

\$1",
	'sig-success' => 'Avètz autentificat lo document.',
	'sign-view-selectfields' => "'''Camps d'afichar :'''",
	'sign-viewfield-entryid' => 'ID de la dintrada',
	'sign-viewfield-timestamp' => 'Data e ora',
	'sign-viewfield-realname' => 'Nom',
	'sign-viewfield-address' => 'Adreça',
	'sign-viewfield-city' => 'Vila',
	'sign-viewfield-state' => 'Estat (departament o província)',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-zip' => 'Còde postal',
	'sign-viewfield-ip' => 'Adreça IP :',
	'sign-viewfield-agent' => 'Agent utilizaire',
	'sign-viewfield-phone' => 'Numèro de telèfon',
	'sign-viewfield-email' => 'Adreça de corrièr electronic',
	'sign-viewfield-age' => 'Edat',
	'sign-viewfield-options' => 'Opcions',
	'sign-viewsigs-intro' => 'Çaijós apareisson las signaturas enrgistradas per <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => "L'autentificacion es presentament activada per aqueste document.",
	'sign-sigadmin-close' => "Desactivar l'autentificacion",
	'sign-sigadmin-currentlyclosed' => "L'autentificacion es presentament desactivada per aqueste document.",
	'sign-sigadmin-open' => "Activar l'autentificacion",
	'sign-signatures' => 'Signaturas',
	'sign-sigadmin-closesuccess' => "L'autentificacion es desactivada.",
	'sign-sigadmin-opensuccess' => "L'autentificacion es activada.",
	'sign-viewsignatures' => 'Veire las signaturas',
	'sign-closed' => 'tampada',
	'sign-error-closed' => "L'autentificacion d'aqueste document es presentada desactivada.",
	'sig-anonymous' => "''Anonimament''",
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Detalhs de la signatura',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
		-->[[User:$1|$1]] ([[User talk:$1|talk]] • <!--
		-->[[Special:Contributions/$1|contribs]] • <!--
		-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
		-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
		-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
		-->[[Special:BlockIP/$1|block user]] • <!--
		-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} block log] • <!--
		-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} checkip])<!--
		--></span>',
	'sign-viewfield-stricken' => 'Fautiu',
	'sign-viewfield-reviewedby' => 'Revisor',
	'sign-viewfield-reviewcomment' => 'Comentari',
	'sign-detail-uniquequery' => 'Entitats semblablas',
	'sign-detail-uniquequery-run' => 'Amodar la requèsta',
	'sign-detail-strike' => 'Raiar la signatura',
	'sign-reviewsig' => 'Revisar la signatura',
	'sign-review-comment' => 'Comentari',
	'sign-submitreview' => 'Sometre la revision',
	'sign-uniquequery-similarname' => 'Nom similar',
	'sign-uniquequery-similaraddress' => 'Adreça similara',
	'sign-uniquequery-similarphone' => 'Numèro de telèfon similar',
	'sign-uniquequery-similaremail' => 'Adreça de corrièr electronica similara',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] a autentificat [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'sign-viewfield-email' => 'Эл. посты адрис',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'signdocument' => 'Podpisz dokument',
	'sign-nodocselected' => 'Wybierz dokument, który chcesz podpisać.',
	'sign-selectdoc' => 'Dokument',
	'sign-docheader' => '<div class="noarticletext">Użyj tego formularza, by podpisać wyświetlony poniżej dokument „[[$1]]”.
Przeczytaj cały dokument dokładnie i jeśli uznasz, że chcesz go poprzeć, w celu podpisania wypełnij wymagane pola.</div>',
	'sign-error-nosuchdoc' => 'Szukany dokument ($1) nie istnieje.',
	'sign-realname' => 'Nazwisko:',
	'sign-address' => 'Ulica:',
	'sign-city' => 'Miasto:',
	'sign-state' => 'Stan:',
	'sign-zip' => 'Kod ZIP:',
	'sign-country' => 'Kraj:',
	'sign-phone' => 'Numer telefonu:',
	'sign-bday' => 'Wiek:',
	'sign-email' => 'Adres e-mail:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> oznacza wymagane pole.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Uwaga: Ukryte przez Ciebie informacje nadal będą widoczne dla moderatorów/administratorów.</i></small>',
	'sign-list-hideaddress' => 'Nie pokazuj adresu',
	'sign-list-hideextaddress' => 'Nie pokazuj miejscowości, kodu pocztowego ani kraju.',
	'sign-list-hidephone' => 'Nie pokazuj numeru telefonu',
	'sign-list-hidebday' => 'Nie pokazuj wieku',
	'sign-list-hideemail' => 'Nie pokazuj adresu e-mail',
	'sign-submit' => 'Podpisz dokument',
	'sig-success' => 'Dokument został podpisany.',
	'sign-view-selectfields' => '<b>Pola do wyświetlenia:</b>',
	'sign-viewfield-timestamp' => 'Znacznik czasu',
	'sign-viewfield-realname' => 'Nazwa',
	'sign-viewfield-address' => 'Adres',
	'sign-viewfield-city' => 'Miasto',
	'sign-viewfield-state' => 'Województwo',
	'sign-viewfield-country' => 'Państwo',
	'sign-viewfield-zip' => 'Kod pocztowy',
	'sign-viewfield-ip' => 'Adres IP',
	'sign-viewfield-agent' => 'User agent',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Wiek',
	'sign-viewfield-options' => 'Opcje',
	'sign-sigadmin-close' => 'Wyłącz podpisywanie',
	'sign-signatures' => 'Podpisy',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|dyskusja]] • <!--
-->[[Special:Contributions/$1|wkład]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|zablokuj]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} blokady] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} sprawdź IP])<!--
--></span>',
	'sign-review-comment' => 'Komentarz',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'signdocument' => "Firma digital d'un document",
	'sign-nodocselected' => "Për piasì, ch'a sërna ël document ch'a veul firmé.",
	'sign-selectdoc' => 'Document:',
	'sign-docheader' => "<div class=\"noarticletext\">Për piasì, ch'a dòvra ës mòdulo-sì për firmé an manera digital ël document \"[[\$1]],\" che i-j ësmonoma ambelessì sota. Ch'a sia gentil, ch'a lesa tut ël document e '''ch<nowiki>'</nowiki>a firma mach s<nowiki>'</nowiki>a l<nowiki>'</nowiki>é d<nowiki>'</nowiki>acòrdi an manera completa'''. Për firmé ch'a buta sò dat ant ij camp a pòsta.</div>",
	'sign-error-nosuchdoc' => "A l'ha ciamane un document ($1) ch'a-i é pa.",
	'sign-realname' => 'Nòm e cognòm:',
	'sign-address' => 'Abitant an via:',
	'sign-city' => 'Sità:',
	'sign-state' => 'Provinsa:',
	'sign-zip' => 'Còdes postal:',
	'sign-country' => 'Stat:',
	'sign-phone' => 'Nùmer ëd telèfono:',
	'sign-bday' => 'Età:',
	'sign-email' => 'Adrëssa ëd pòsta eletrònica:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> a marca ij camp ch\'a-i é òbligh dë buté.</i></small>',
	'sign-hide-note' => "<small><i><font color=\"red\">**</font> Nòta: a l'é n'anformassion nen pùblica, ch'a s-ciàiro mach j'aministrator.</i></small>",
	'sign-list-anonymous' => "An pùblich march-me coma anònim, sensa gnente ch'a peula feje capì a la gent chi ch'i son (contut che j'aministrator ij dat personaj a-j ës-ciàiro franch midem)",
	'sign-list-hideaddress' => "Pùblica nen mia adrëssa (contut che j'aministrator ij dat personaj a-j ës-ciàiro franch midem)",
	'sign-list-hideextaddress' => "Pùblica nen stat, provinsa, còdes postal ò sità (contut che j'aministrator ij dat personaj a-j ës-ciàiro franch midem)",
	'sign-list-hidephone' => "Pùblica nen ël telèfono (contut che j'aministrator ij dat personaj a-j ës-ciàiro franch midem)",
	'sign-list-hidebday' => "Pùblica nen l'età (contut che j'aministrator ij dat personaj a-j ës-ciàiro franch midem)",
	'sign-list-hideemail' => "Pùblica nen l'adrëssa ëd pòsta eletrònica (contut che j'aministrator ij dat personaj a-j ës-ciàiro franch midem)",
	'sign-submit' => "Ch'a-i daga 'n colp ambelessì për firmé",
	'sign-information' => "<div class=\"noarticletext\">Motobin mersì për avej dovrà sò temp a lese ës document-sì. S'a l'é d'acòrdi con lòn ch'a-i é scrit për piasì ch'a lo disa ën butand sò dat personaj e dand-ie un colp ansima al boton dla firma.

Ch'a varda che sò dat a sio giust, e che i peulo contatela për verifiché soa identità. Ch'a ten-a present che soa adrëssa IP e dj'àotre anformassion ansima soa identità a resteran registrà quand a firma e saran dovrà da j'aministrator për eliminé le firme dobie e confermé che ij dat personaj a sio giust.

'''Nòta''': për via che ën passand për ij '''proxy duvèrt''' (ch'a fan ëvnì anònima la gent), un an permëtt nen da fé sossì, le firme ch'a rivo ën passand për dij canaj parej as peulo nen contesse. Se ant ës moment-sì chiel/chila a l'é tacà a 'n proxy, për piasì, '''për firmé''' ch'as dëstaca e '''ch'a dòvra na conession normal'''.</div>

\$1",
	'sig-success' => "La firma dël document a l'é andaita a bonfin.",
	'sign-view-selectfields' => '<b>Camp da smon-e:</b>',
	'sign-viewfield-entryid' => "Id dl'element",
	'sign-viewfield-timestamp' => 'Tìmber data e ora',
	'sign-viewfield-realname' => 'Nòm',
	'sign-viewfield-address' => 'Adrëssa',
	'sign-viewfield-city' => 'Sità',
	'sign-viewfield-state' => 'Provinsa',
	'sign-viewfield-country' => 'Nassion',
	'sign-viewfield-zip' => 'Còdes postal',
	'sign-viewfield-ip' => 'Adrëssa IP',
	'sign-viewfield-agent' => "Agent dl'utent",
	'sign-viewfield-phone' => 'Teléfono',
	'sign-viewfield-email' => 'Pòsta eletrònica',
	'sign-viewfield-age' => 'Età',
	'sign-viewfield-options' => 'Opsion',
	'sign-viewsigs-intro' => 'Ambelessì sota a-i son le firme butà al document <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Ës document-sì as peul firmesse.',
	'sign-sigadmin-close' => 'Chité dë cheuje firme',
	'sign-sigadmin-currentlyclosed' => 'Ës document-sì as peul nen firmesse.',
	'sign-sigadmin-open' => 'Deurbe la cheujta dle firme',
	'sign-signatures' => 'Firme',
	'sign-sigadmin-closesuccess' => "La possibilità dë firmé a l'é stàita gavà",
	'sign-sigadmin-opensuccess' => "La possibilità dë firmé a l'é stàita butà",
	'sign-viewsignatures' => 'vardé le firme',
	'sign-closed' => 'sërà',
	'sign-error-closed' => 'Ës document-sì al moment as peul nen firmesse',
	'sig-anonymous' => '<i>Anònim</i>',
	'sig-private' => '<i>Privà</i>',
	'sign-sigdetails' => 'Detaj dla firma',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|talk]] • <!--
-->[[Special:Contributions/$1|contribs]] • <!-- -->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!-- -->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|block user]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} block log] • <!-- -->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} checkip])<!-- --></span>',
	'sign-viewfield-stricken' => 'Anulà',
	'sign-viewfield-reviewedby' => 'Controlor',
	'sign-viewfield-reviewcomment' => 'Coment',
	'sign-detail-uniquequery' => "Entità ch'a-j ësmijo",
	'sign-detail-uniquequery-run' => 'Consulté la base dat',
	'sign-detail-strike' => 'Anulé la firma',
	'sign-reviewsig' => 'Controlé la firma',
	'sign-review-comment' => 'Coment',
	'sign-submitreview' => 'Registré ël contròl',
	'sign-uniquequery-similarname' => "Nòm ch'a-j ësmija",
	'sign-uniquequery-similaraddress' => "Adrëssa ch'a-j ësmija",
	'sign-uniquequery-similarphone' => "Teléfono ch'a-j ësmija",
	'sign-uniquequery-similaremail' => "Pòsta eletrònica ch'a-j ësmija",
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] firmà [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'sign-selectdoc' => 'لاسوند:',
	'sign-error-nosuchdoc' => 'د کوم لاسوند غوښتنه چې تاسو کړې ($1)، هغه نشته.',
	'sign-realname' => 'نوم:',
	'sign-address' => 'د کوڅې پته:',
	'sign-city' => 'ښار:',
	'sign-state' => 'ايالت:',
	'sign-zip' => 'پوست کوډ:',
	'sign-country' => 'هېواد:',
	'sign-phone' => 'د ټيليفون شمېره:',
	'sign-bday' => 'عمر:',
	'sign-email' => 'برېښليک پته:',
	'sign-list-anonymous' => 'په ورکنومي توګه مې ښکاره کړه',
	'sign-list-hideaddress' => 'پته مې مه ښکاره کوه',
	'sign-list-hideextaddress' => 'ښار، ايالت، پوست کوډ، يا هېواد مې مه ښکاره کوه',
	'sign-list-hidephone' => 'د ټيليفون شمېره مې مه ښکاره کوه',
	'sign-list-hidebday' => 'عمر مې مه ښکاره کوه',
	'sign-list-hideemail' => 'برېښليک مې مه ښکاره کوه',
	'sign-viewfield-realname' => 'نوم',
	'sign-viewfield-address' => 'پته',
	'sign-viewfield-city' => 'ښار',
	'sign-viewfield-state' => 'ايالت',
	'sign-viewfield-country' => 'هېواد',
	'sign-viewfield-ip' => 'IP پته',
	'sign-viewfield-agent' => 'د کارونکي پلاوی',
	'sign-viewfield-phone' => 'ټيليفون',
	'sign-viewfield-email' => 'برېښليک',
	'sign-viewfield-age' => 'عمر',
	'sign-signatures' => 'لاسليکونه',
	'sig-anonymous' => '<i>ورکنومی</i>',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'signdocument' => 'Assinar documento',
	'sign-selectdoc' => 'Documento:',
	'sign-error-nosuchdoc' => 'O documento que requisitou ($1) não existe.',
	'sign-realname' => 'Nome:',
	'sign-address' => 'Endereço da morada:',
	'sign-city' => 'Cidade:',
	'sign-state' => 'Estado:',
	'sign-zip' => 'Código postal:',
	'sign-country' => 'País:',
	'sign-phone' => 'Número de telefone:',
	'sign-bday' => 'Idade:',
	'sign-email' => 'Endereço de e-mail:',
	'sign-list-anonymous' => 'Listar como anónimo',
	'sign-list-hideaddress' => 'Não listar endereço',
	'sign-list-hideextaddress' => 'Não listar cidade, estado, código postal ou país',
	'sign-list-hidephone' => 'Não listar telefone',
	'sign-list-hidebday' => 'Não listar idade',
	'sign-list-hideemail' => 'Não listar email',
	'sign-submit' => 'Assinar documento',
	'sig-success' => 'O documento foi assinado com sucesso.',
	'sign-viewfield-realname' => 'Nome',
	'sign-viewfield-address' => 'Endereço',
	'sign-viewfield-city' => 'Cidade',
	'sign-viewfield-state' => 'Estado',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-zip' => 'Código Postal',
	'sign-viewfield-ip' => 'Endereço IP',
	'sign-viewfield-phone' => 'Telefone',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Idade',
	'sign-viewfield-options' => 'Opções',
	'sign-sigadmin-close' => 'Desactivar assinaturas',
	'sign-signatures' => 'Assinaturas',
	'sign-viewsignatures' => 'ver assinaturas',
	'sign-closed' => 'fechado',
	'sig-anonymous' => '<i>Anónimo</i>',
	'sig-private' => '<i>Privado</i>',
	'sign-sigdetails' => 'Detalhes da assinatura',
	'sign-viewfield-reviewedby' => 'Revisor',
	'sign-viewfield-reviewcomment' => 'Comentário',
	'sign-detail-uniquequery' => 'Entidades similares',
	'sign-review-comment' => 'Comentar',
	'sign-uniquequery-similarname' => 'Nome similar',
	'sign-uniquequery-similaremail' => 'Email similar',
);

/** Rhaeto-Romance (Rumantsch) */
$messages['rm'] = array(
	'sign-viewfield-realname' => 'Num',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'sign-selectdoc' => 'Document:',
	'sign-realname' => 'Nume:',
	'sign-city' => 'Oraş:',
	'sign-zip' => 'Cod poştal:',
	'sign-country' => 'Ţară:',
	'sign-phone' => 'Număr de telefon:',
	'sign-bday' => 'Vârstă:',
	'sign-email' => 'Adresă e-mail:',
	'sign-list-hideaddress' => 'Nu afişa adresa',
	'sign-list-hidephone' => 'Nu afişa telefonul',
	'sign-list-hidebday' => 'Nu afişa vârsta',
	'sign-list-hideemail' => 'Nu afişa adresa de e-mail',
	'sign-viewfield-realname' => 'Nume',
	'sign-viewfield-address' => 'Adresă',
	'sign-viewfield-city' => 'Oraş',
	'sign-viewfield-country' => 'Ţară',
	'sign-viewfield-ip' => 'Adresă IP',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Vârstă',
	'sign-viewfield-options' => 'Opţiuni',
	'sign-signatures' => 'Semnături',
	'sig-private' => '<i>Privat</i>',
	'sign-sigdetails' => 'Detaliile semnăturii',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-viewfield-reviewcomment' => 'Comentariu',
	'sign-detail-uniquequery' => 'Entităţi similare',
	'sign-detail-uniquequery-run' => 'Rulează interogare',
	'sign-review-comment' => 'Comentariu',
	'sign-uniquequery-similarname' => 'Nume similar',
	'sign-uniquequery-similaraddress' => 'Adresă similară',
	'sign-uniquequery-similarphone' => 'Telefon similar',
	'sign-uniquequery-similaremail' => 'E-mail similar',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'sign-realname' => 'Nome:',
	'sign-address' => 'Indirizze (via, chiazze,...):',
	'sign-city' => 'Cetate:',
	'sign-state' => 'State/Reggione (i.e. California, Pugghie, ...)',
	'sign-zip' => 'C.A.P.:',
	'sign-country' => 'Nazione (i.e. Itaglie, ...)',
	'sign-phone' => 'Numere de telefone:',
	'sign-bday' => 'Età:',
	'sign-email' => 'Indirizze e-mail:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> indichesce le cambe obbligatorije.</i></small>',
	'sign-view-selectfields' => '<b>Cambe ca a fà vedè:</b>',
	'sign-viewfield-entryid' => "ID de l'inzerimende",
	'sign-viewfield-timestamp' => 'Orarie de stambe',
	'sign-viewfield-realname' => 'Nome',
	'sign-viewfield-address' => 'Indirizze',
	'sign-viewfield-city' => 'Cetate',
	'sign-viewfield-state' => 'Nazione/Reggione (i.e. California, Pugghie, ...)',
	'sign-viewfield-country' => 'Nazione (i.e. Itaglie,...)',
	'sign-viewfield-zip' => 'C.A.P.',
	'sign-viewfield-ip' => 'Indirizze IP',
	'sign-viewfield-agent' => "Agende de l'utende",
	'sign-viewfield-phone' => 'Telefone',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Età',
	'sign-viewfield-options' => 'Opzione',
	'sig-anonymous' => '<i>Anonime</i>',
	'sig-private' => '<i>Privete</i>',
	'sign-viewfield-reviewcomment' => 'Commende',
	'sign-detail-uniquequery-run' => "Lange l'inderrogazione",
	'sign-review-comment' => 'Commende',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'signdocument' => 'Подписание документа',
	'sign-nodocselected' => 'Пожалуйста, выберите документ, который вы хотите подписать.',
	'sign-selectdoc' => 'Документ:',
	'sign-docheader' => '<div class="noarticletext">Пожалуйста, используйте эту форму для подписи документа «[[$1]]», представленного ниже.
Пожалуйста, прочтите документ целиком, и если вы хотите выразить ему поддержку, заполните требуемые поля, чтобы подписать его.</div>',
	'sign-error-nosuchdoc' => 'Запрошенный вами документ ($1) не существует.',
	'sign-realname' => 'Имя:',
	'sign-address' => 'Адрес (улица, дом и пр.):',
	'sign-city' => 'Город:',
	'sign-state' => 'Положение:',
	'sign-zip' => 'Почтовый индекс:',
	'sign-country' => 'Страна:',
	'sign-phone' => 'Номер телефона:',
	'sign-bday' => 'Возраст:',
	'sign-email' => 'Адрес эл. почты:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> отмечает обязательные поля.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Замечание: невключённая в список информация будет видна модераторам.</i></small>',
	'sign-list-anonymous' => 'Анонимно',
	'sign-list-hideaddress' => 'Не включать в список адрес',
	'sign-list-hideextaddress' => 'Не включать в список город, страну и индекс',
	'sign-list-hidephone' => 'Не включать в список телефон',
	'sign-list-hidebday' => 'Не включать в список возраст',
	'sign-list-hideemail' => 'Не включать в список эл. почту',
	'sign-submit' => 'Подписать документ',
	'sign-information' => '<div class="noarticletext">Спасибо, что потратили своё время на прочтение этого документа.
Если вы согласны с ним, пожалуйста, выразите вашу поддержку, заполнив приведённые ниже поля и нажав кнопку «Подписать документ». 
Пожалуйста, убедитесь, что приводимые вами личные сведения правильны, что указаны способы связи, которыми можено воспользоваться для проверки подлинности.
Заметьте, что ваш IP-адрес и иная идентификационная информация будет записана с помощью этой формы и использована модераторами для удаления повторных подписей и подтверждения правильности личных сведений.
Поскольку использование открытых и анонимизирующих прокси препятствует нашей возможности выполнить эту задачу, подписи с таких прокси, скорее всего, будут учитываться.
Если вы подключены через прокси-сервер, пожалуйста, отсоединитесь от него, используйте обычное подключение к сети во время подписи документа.</div>

$1',
	'sig-success' => 'Подписание документа прошло успешно.',
	'sign-view-selectfields' => '<b>Поля для оображения:</b>',
	'sign-viewfield-entryid' => 'ID записи',
	'sign-viewfield-timestamp' => 'Дата/время',
	'sign-viewfield-realname' => 'Имя',
	'sign-viewfield-address' => 'Адрес',
	'sign-viewfield-city' => 'Город',
	'sign-viewfield-state' => 'Штат',
	'sign-viewfield-country' => 'Страна',
	'sign-viewfield-zip' => 'Почт. индекс',
	'sign-viewfield-ip' => 'IP-адрес',
	'sign-viewfield-agent' => 'Браузер',
	'sign-viewfield-phone' => 'Телефон',
	'sign-viewfield-email' => 'Эл. почта',
	'sign-viewfield-age' => 'Возраст',
	'sign-viewfield-options' => 'Настройки',
	'sign-viewsigs-intro' => 'Ниже показаны подписи, собранные за <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Сбор подписей включён для этого документа.',
	'sign-sigadmin-close' => 'Отключить сбор подписей',
	'sign-sigadmin-currentlyclosed' => 'Сбор подписей сейчас отключён для этого документа.',
	'sign-sigadmin-open' => 'Включить сбор подписей',
	'sign-signatures' => 'Подписи',
	'sign-sigadmin-closesuccess' => 'Сбор подписей успешно отключён.',
	'sign-sigadmin-opensuccess' => 'Сбор подписей успешно включён.',
	'sign-viewsignatures' => 'просмотреть подписи',
	'sign-closed' => 'закрыто',
	'sign-error-closed' => 'Сбор подписей для этого документа в настоящее время отключён.',
	'sig-anonymous' => '<i>Аноним</i>',
	'sig-private' => '<i>Частный</i>',
	'sign-sigdetails' => 'Подробнее о подписи',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|обсуждение]] • <!--
-->[[Special:Contributions/$1|вклад]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|заблокировать участника]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} журнал блокировок] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} проверить])<!--
--></span>',
	'sign-viewfield-stricken' => 'Вычеркнуто',
	'sign-viewfield-reviewedby' => 'Проверяющий',
	'sign-viewfield-reviewcomment' => 'Примечание',
	'sign-detail-uniquequery' => 'Схожие записи',
	'sign-detail-uniquequery-run' => 'Выполнить запрос',
	'sign-detail-strike' => 'Вычеркнуть подпись',
	'sign-reviewsig' => 'Проверить подпись',
	'sign-review-comment' => 'Примечание',
	'sign-submitreview' => 'Отправить проверку',
	'sign-uniquequery-similarname' => 'Схожее имя',
	'sign-uniquequery-similaraddress' => 'Схожий адрес',
	'sign-uniquequery-similarphone' => 'Схожий телефон',
	'sign-uniquequery-similaremail' => 'Схожий эл. адрес',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] подписал [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'signdocument' => 'Podpísať dokument',
	'sign-nodocselected' => 'Prosím, zvoľte dokument, ktorý chcete podpísať.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => '<div class="noarticletext">Prosím, použite tento formulár na podpísanie dolu zobrazeného dokumentu „[[$1]]“. Prosím, prečítajte si celý dokument a ak chcete vyjadriť jeho podporu, vyplňte prosím požadované polia, aby mohol byť podpísaný.</div>',
	'sign-error-nosuchdoc' => 'Dokument, ktorý ste vyžiadali ($1) neexistuje.',
	'sign-realname' => 'Meno:',
	'sign-address' => 'Adresa:',
	'sign-city' => 'Mesto:',
	'sign-state' => 'Štát:',
	'sign-zip' => 'PSČ:',
	'sign-country' => 'Krajina:',
	'sign-phone' => 'Telefónne číslo:',
	'sign-bday' => 'Vek:',
	'sign-email' => 'Emailová adresa:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> označuje povinné polia.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Pozn.: Informácie, ktoré sa nezobrazujú budú aj tak viditeľné moderátorom.</i></small>',
	'sign-list-anonymous' => 'Uviesť anonymne',
	'sign-list-hideaddress' => 'Neuvádzať adresu',
	'sign-list-hideextaddress' => 'Neuvádzať mesto, štát, PSČ a krajinu',
	'sign-list-hidephone' => 'Neuvádzať telefón',
	'sign-list-hidebday' => 'Neuvádzať vek',
	'sign-list-hideemail' => 'Neuvádzať email',
	'sign-submit' => 'Podpísať dokument',
	'sign-information' => '<div class="noarticletext">Ďakujeme, že ste si našli čas prečítať tento dokument. Ak s jeho obsahom súhlasíte, prosím vyjadrite svoju podporu tým, že nižšie vyplníte požadované polia a kliknete na „Podpísať dokument“. Prosím, uistite sa, že vaše osobné údaje sú správne uvedené a že ste nám poskytli spôsob, ako vás kontaktovať pre overenie vašej identity. Majte na pamäti, že vaša IP adresa a iné identifikačné informáce budú zaznamenané s týmto formulárom a moderátori ich použijú na elimináciu dvojitých podpisov a potvrdenie správnosti vašich osobných údajov. Keďže používanie otvorených a anonymných proxy serverov bráni našej schopnosti vykonávať túto úlohu, podpisy z takýcto proxy pravdepodobne nebudú započítané. Ak ste momentálne pripojený prostredníctvom proxy, odpojte sa prosím a použite pri podpisovaní priame pripojenie.</div>

$1',
	'sig-success' => 'Úspešne ste podpísali dokument',
	'sign-view-selectfields' => '<b>Zobrazované polia:</b>',
	'sign-viewfield-entryid' => 'ID záznamu',
	'sign-viewfield-timestamp' => 'Časová známka',
	'sign-viewfield-realname' => 'Meno',
	'sign-viewfield-address' => 'Adresa',
	'sign-viewfield-city' => 'Mesto',
	'sign-viewfield-state' => 'Štát',
	'sign-viewfield-country' => 'Krajina',
	'sign-viewfield-zip' => 'PSČ',
	'sign-viewfield-ip' => 'IP adresa',
	'sign-viewfield-agent' => 'Prehliadač',
	'sign-viewfield-phone' => 'Telefón',
	'sign-viewfield-email' => 'Email',
	'sign-viewfield-age' => 'Vek',
	'sign-viewfield-options' => 'Voľby',
	'sign-viewsigs-intro' => 'Dolu zobrazené sú zaznamenané podpisy <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Pre tento dokument je momentálne pospisovanie zapnuté.',
	'sign-sigadmin-close' => 'Vypnúť podpisovanie',
	'sign-sigadmin-currentlyclosed' => 'Podpisovanie pre tento dokument je momentálne vypnuté.',
	'sign-sigadmin-open' => 'Zapnúť podpisovanie',
	'sign-signatures' => 'Podpisy',
	'sign-sigadmin-closesuccess' => 'Podpisovanie je úspešne vypnuté.',
	'sign-sigadmin-opensuccess' => 'Podpisovanie je úspešne zapnuté.°',
	'sign-viewsignatures' => 'zobraziť podpisy',
	'sign-closed' => 'zatvorené',
	'sign-error-closed' => 'Podpisovanie pre tento dokument je momentálne vypnuté.',
	'sig-anonymous' => '<i>anonym</i>',
	'sig-private' => '<i>súkromné</i>',
	'sign-sigdetails' => 'Podrobnosti podpisu',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|diskusia]] • <!--
-->[[Special:Contributions/$1|príspevky]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|zablokovať používateľa]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} záznam blokovaní] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} kontrola ip])<!--
--></span>',
	'sign-viewfield-stricken' => 'Vyčiarknuté',
	'sign-viewfield-reviewedby' => 'Kontrolór',
	'sign-viewfield-reviewcomment' => 'Komentár',
	'sign-detail-uniquequery' => 'Podobné entity',
	'sign-detail-uniquequery-run' => 'Spustiť požiadavku',
	'sign-detail-strike' => 'Vyčiarknuť podpis',
	'sign-reviewsig' => 'Skontrolovať podpis',
	'sign-review-comment' => 'Komentár',
	'sign-submitreview' => 'Odoslať kontrolu',
	'sign-uniquequery-similarname' => 'Podobné meno',
	'sign-uniquequery-similaraddress' => 'Podobná adresa',
	'sign-uniquequery-similarphone' => 'Podobný telefón',
	'sign-uniquequery-similaremail' => 'Podobný email',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] podpísal [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'sign-email' => 'Е-пошта:',
	'sign-viewfield-reviewcomment' => 'Коментар',
	'sign-review-comment' => 'Коментар',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'sign-realname' => 'Noome:',
);

/** Swedish (Svenska)
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'signdocument' => 'Signera dokument',
	'sign-nodocselected' => 'Välj det dokument du vill signera.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => '<div class="noarticletext">Använd det här formuläret för att signera dokumentet "[[$1]]," som visas härunder. Var god läs igenom hela dokumentet, och om du vill visa ditt stöd för det, fyll i de nödvändiga fälten för att signera.</div>',
	'sign-error-nosuchdoc' => 'Dokumentet du efterfrågade ($1) existerar inte.',
	'sign-realname' => 'Namn:',
	'sign-address' => 'Gatuadress:',
	'sign-city' => 'Ort:',
	'sign-state' => 'Stat:',
	'sign-zip' => 'Postnummer:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telefonnummer:',
	'sign-bday' => 'Ålder:',
	'sign-email' => 'E-postadress:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> betyder att fältet måste fyllas i.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Observera: Dold informationen är fortfarande tillgänglig för moderatorer.</i></small>',
	'sign-list-anonymous' => 'Lista anonymt',
	'sign-list-hideaddress' => 'Lista inte adress',
	'sign-list-hideextaddress' => 'Lista inte ort, stat, postnummer eller land',
	'sign-list-hidephone' => 'Lista inte telefon',
	'sign-list-hidebday' => 'Lista inte ålder',
	'sign-list-hideemail' => 'Lista inte e-post',
	'sign-submit' => 'Signera dokumentet',
	'sign-information' => '<div class="noarticletext">Tack för att du har tagit dig tiden till att läsa igenom det här dokumentet.
Om du är enig med det, var god visa ditt stöd genom att fylla i de nödvändiga fälten nedan och klicka på "Signera dokument".
Försäkra dig om att din personliga information är korrekt, och att vi har en möjlighet att kontakta dig för att bekräfta din identitet.
Notera att din IP-adress och annan identifierbar information kommer att användas av moderatorer för att eliminera dublettsignaturer och att bekräfta giltigheten av din personliga informaton.
När sidan används av öppna och anonymiserade proxyservrar hindrar det vår möjlighet att göra det här, då kommer signaturer från vissa proxyservrar troligen inte att räknas med.
Om du är ansluten via en proxyserver, koppla från den och använd en vanlig uppkoppling när du signerar.</div>

$1',
	'sig-success' => 'Du har signerat dokumentet lyckat.',
	'sign-view-selectfields' => '<b>Fält som visas:</b>',
	'sign-viewfield-entryid' => 'Inskrifts-ID',
	'sign-viewfield-timestamp' => 'Tidssttämpel',
	'sign-viewfield-realname' => 'Namn',
	'sign-viewfield-address' => 'Adress',
	'sign-viewfield-city' => 'Ort',
	'sign-viewfield-state' => 'Stat',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-zip' => 'Postnummer',
	'sign-viewfield-ip' => 'IP-adress',
	'sign-viewfield-agent' => 'Användaragent',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-post',
	'sign-viewfield-age' => 'Ålder',
	'sign-viewfield-options' => 'Alternativ',
	'sign-viewsigs-intro' => 'Nedan visas de uppsamlade signaturerna för <span class="plainlinks">[{{fullurl:Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Signering är just nu påslaget för det här dokumentet.',
	'sign-sigadmin-close' => 'Stäng av signering',
	'sign-sigadmin-currentlyclosed' => 'Signering är just nu avslaget för det här dokumentet.',
	'sign-sigadmin-open' => 'Slå på signering',
	'sign-signatures' => 'Signaturer',
	'sign-sigadmin-closesuccess' => 'Signeringen är nu avslagen.',
	'sign-sigadmin-opensuccess' => 'Signeringen är nu påslagen.',
	'sign-viewsignatures' => 'visa signaturer',
	'sign-closed' => 'stängd',
	'sign-error-closed' => 'Signering av detta dokument är just nu stängd.',
	'sig-anonymous' => '<i>Anonym</i>',
	'sig-private' => '<i>Privat</i>',
	'sign-sigdetails' => 'Signatur detaljer',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|diskussion]] • <!--
-->[[Special:Contributions/$1|ändringar]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|blockera användare]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} blockerings logg] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} kontrollera IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'Struken',
	'sign-viewfield-reviewedby' => 'Granskare',
	'sign-viewfield-reviewcomment' => 'Kommentar',
	'sign-detail-uniquequery' => 'Liknande entiteter',
	'sign-detail-uniquequery-run' => 'Kör frågning',
	'sign-detail-strike' => 'Stryk signatur',
	'sign-reviewsig' => 'Granska signatur',
	'sign-review-comment' => 'Kommentar',
	'sign-submitreview' => 'Slutför granskning',
	'sign-uniquequery-similarname' => 'Liknande namn',
	'sign-uniquequery-similaraddress' => 'Liknande adress',
	'sign-uniquequery-similarphone' => 'Liknande telefonnummer',
	'sign-uniquequery-similaremail' => 'Liknande e-postadress',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] signerade [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'sign-realname' => 'Mjano:',
	'sign-viewfield-realname' => 'Mjano',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'signdocument' => 'పత్రంపై సంతకం చేయండి',
	'sign-nodocselected' => 'మీ సంతకం చేయాలనుకుంటున్న పత్రాన్ని ఎంచుకోండి.',
	'sign-selectdoc' => 'పత్రం:',
	'sign-error-nosuchdoc' => 'మీరు అభ్యర్థించిన పత్రం ($1) ఇక్కడ లేదు.',
	'sign-realname' => 'పేరు:',
	'sign-address' => 'వీధి చిరునామా:',
	'sign-city' => 'నగరం:',
	'sign-state' => 'రాష్ట్రం:',
	'sign-zip' => 'జిప్ కోడ్:',
	'sign-country' => 'దేశం:',
	'sign-phone' => 'ఫోన్ నెంబర్:',
	'sign-bday' => 'వయసు:',
	'sign-email' => 'ఈ-మెయిల్ చిరునామా:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> తప్పనిసరి వాటిని సూచిస్తుంది.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> గమనిక: చూపించని సమాచారాన్ని నిర్వాహకులు మాత్రం చూడగలరు.</i></small>',
	'sign-list-anonymous' => 'అనామకంగా చూపించు',
	'sign-list-hideaddress' => 'చిరునామాని చూపించకు',
	'sign-list-hideextaddress' => 'నగరం, రాష్ట్రం, జిప్, లేదా దేశంలను చూపించకు',
	'sign-list-hidephone' => 'ఫోన్ నంబరు చూపించకు',
	'sign-list-hidebday' => 'వయసుని చూపించకు',
	'sign-list-hideemail' => 'ఈ-మెయిలుని చూపించకు',
	'sign-submit' => 'సంతకం చేయండి',
	'sig-success' => 'ఈ పత్రంపై మీరు విజయవంతంగా సంతకం చేసారు.',
	'sign-view-selectfields' => '<b>చూపించాల్సిన ఖాళీలు:</b>',
	'sign-viewfield-timestamp' => 'కాలముద్ర',
	'sign-viewfield-realname' => 'పేరు',
	'sign-viewfield-address' => 'చిరునామా',
	'sign-viewfield-city' => 'నగరం',
	'sign-viewfield-state' => 'రాష్ట్రం',
	'sign-viewfield-country' => 'దేశం',
	'sign-viewfield-zip' => 'జిప్',
	'sign-viewfield-ip' => 'IP చిరునామా',
	'sign-viewfield-phone' => 'ఫోన్',
	'sign-viewfield-email' => 'ఈమెయిల్',
	'sign-viewfield-age' => 'వయసు',
	'sign-viewfield-options' => 'ఎంపికలు',
	'sign-sigadmin-currentlyopen' => 'ఈ పత్రంపై సంతకం చేయడం ప్రస్తుతం సచేతనమైవుంది.',
	'sign-sigadmin-close' => 'సంతకం చేయడాన్ని అచేతనం చెయ్యండి',
	'sign-sigadmin-currentlyclosed' => 'ఈ పత్రంపై సంతకం చేయడం ప్రస్తుతం అచేతనమైవుంది.',
	'sign-sigadmin-open' => 'సంతకం చేయడాన్ని చేతనం చెయ్యండి',
	'sign-signatures' => 'సంతకాలు',
	'sign-sigadmin-closesuccess' => 'సంతకం చేయడాన్ని విజయవంతంగా అచేతనం చేసాం.',
	'sign-sigadmin-opensuccess' => 'సంతకం చేయడాన్ని విజయవంతంగా చేతనం చేసాం.',
	'sign-viewsignatures' => 'సంతకాలు చూడండి',
	'sign-error-closed' => 'ఈ పత్రంపై సంతకం చేయడాన్ని ప్రస్తుతం అచేతనం చేసారు.',
	'sig-anonymous' => '<i>అనామకం</i>',
	'sig-private' => '<i>అంతరంగికం</i>',
	'sign-sigdetails' => 'సంతకం వివరాలు',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-viewfield-reviewedby' => 'సమీక్షకులు',
	'sign-viewfield-reviewcomment' => 'వ్యాఖ్య',
	'sign-reviewsig' => 'సంతకాన్ని సమీక్షించండి',
	'sign-review-comment' => 'వ్యాఖ్య',
	'sign-submitreview' => 'సమీక్షని దాఖలు చేయండి',
	'sign-uniquequery-similarname' => 'అలాంటి పేరు',
	'sign-uniquequery-similaraddress' => 'అలాంటి చిరునామా',
	'sign-uniquequery-similarphone' => 'అలాంటి ఫోను',
	'sign-uniquequery-similaremail' => 'అలాంటి ఈమెయిలు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'sign-realname' => 'Naran:',
	'sign-city' => 'Sidade:',
	'sign-email' => 'Diresaun korreiu eletróniku:',
	'sign-viewfield-realname' => 'Naran',
	'sign-viewfield-city' => 'Sidade',
	'sign-viewfield-ip' => 'Diresaun IP',
	'sign-viewfield-email' => 'Korreiu eletróniku',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'sign-realname' => 'Ном:',
	'sign-address' => 'Нишонаи кӯча:',
	'sign-city' => 'Шаҳр:',
	'sign-state' => 'Вилоят:',
	'sign-country' => 'Кишвар:',
	'sign-phone' => 'Шумораи телефон:',
	'sign-bday' => 'Синну сол:',
	'sign-email' => 'Нишонаи E-mail:',
	'sign-viewfield-realname' => 'Ном',
	'sign-viewfield-address' => 'Нишона',
	'sign-viewfield-city' => 'Шаҳр',
	'sign-viewfield-state' => 'Вилоят',
	'sign-viewfield-country' => 'Кишвар',
	'sign-viewfield-zip' => 'Индекс',
	'sign-viewfield-ip' => 'Нишонаи IP',
	'sign-viewfield-phone' => 'Телефон',
	'sign-viewfield-email' => 'Почтаи электронӣ',
	'sign-viewfield-options' => 'Ихтиёрот',
	'sign-viewfield-reviewcomment' => 'Тавзеҳот',
	'sign-review-comment' => 'Тавзеҳ',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'sign-viewfield-ip' => 'หมายเลขไอพี',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'signdocument' => 'Lagdaan ang kasulatan/dokumento',
	'sign-nodocselected' => 'Pakipili ang kasulatan/dokumentong nais mong lagdaan.',
	'sign-selectdoc' => 'Kasulatan/Dokumento:',
	'sign-docheader' => '<div class="noarticletext">Pakigamit ang pormularyong ito upang malagdaan ang kasulatang "[[$1]]," na ipinapakita sa ibaba.
Pakibasang mabuti ang buong dokumento, at kung ibig mong ipahayag ang pagtangkilik/pagsuporta mo rito, pakipunan ang mga kinakailangang kahanayan upang malagdaan ito.</div>',
	'sign-error-nosuchdoc' => 'Hindi umiiral ang hiniling mong kasulatan/dokumento ($1).',
	'sign-realname' => 'Pangalan:',
	'sign-address' => 'Kalsada/kalye ng adres (tirahan):',
	'sign-city' => 'Lungsod:',
	'sign-state' => 'Estado:',
	'sign-zip' => 'Kodigong ZIP:',
	'sign-country' => 'Bansa:',
	'sign-phone' => 'Bilang (numero) ng telepono:',
	'sign-bday' => 'Edad (gulang):',
	'sign-email' => 'Adres ng e-liham:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> nagpapahayag ng kinakailangang kahanayan.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Paunawa: Ang hindi nakatalang kabatiran ay matatanaw pa rin ng mga tagapamagitan.</i></small>',
	'sign-list-anonymous' => 'Itala bilang hindi nagpapakilala (anonimo)',
	'sign-list-hideaddress' => 'Huwag itala ang adres/tirahan',
	'sign-list-hideextaddress' => "Huwag itala ang lungsod, estado, kodigong ''zip'', o bansa",
	'sign-list-hidephone' => 'Huwag itala ang telepono',
	'sign-list-hidebday' => 'Huwag itala ang edad/gulang',
	'sign-list-hideemail' => 'Huwag itala ang e-liham',
	'sign-submit' => 'Lagdaan ang kasulatan/dokumento',
	'sign-information' => '<div class="noarticletext">Salamat sa pagbibigay mo ng panahon upang basahin ang kahabaan ng kasulatang ito.
Kung pumapayag ka rito, pakipahayag ang iyong pagtangkilik sa pamamagitan ng pagpupuno sa loob ng kinakailangang mga kahanayan sa ibaba at pagpindot sa "Lagdaan ang kasulatan".  
Pakitiyak lamang na tama ang iyong pansariling kabatiran at na mayroon nga kaming paraan upang makipagugnayan sa iyo upang mapatunayan ang iyong katauhan.
Pakitandaan lamang na ang adres ng IP mo at iba pang mapagkikilanlang kabatiran ay itatala sa pamamagitan ng pormularyong ito at gagamitin ng mga tagapamagitan upang maalis ang nagkakadalawang mga lagda at tiyakin ang katumpakan ng iyong pansariling kabatiran.
Dahil sa nagbibigay ng hangganan sa aming kakayanan ang pagsasagawa ng gawaing ito ang paggamit ng bukas at mga pamalit (\'\'proxy\'\') na pang-hindi nagpapakilala, mas malamang na hindi bibilangin ang mga lagdang nagmumula sa ganyang mga pamalit.
Kung pangkasalukuyan kang nakaugnay sa pamamagitan ng isang serbidor na pamalit, pakitanggal lamang ang pagkakakunekta mo rito at gamitin ang isang pampamantayang ugnayan/kuneksyon habang lumalagda.</div>

$1',
	'sig-success' => 'Matagumpay mo nang nalagdaan ang kasulatan/dokumento.',
	'sign-view-selectfields' => '<b>Mga kahanayang ipapakita/palilitawin:</b>',
	'sign-viewfield-entryid' => 'ID na pampasok:',
	'sign-viewfield-timestamp' => 'Tatak ng oras',
	'sign-viewfield-realname' => 'Pangalan',
	'sign-viewfield-address' => 'Adres/Tirahan',
	'sign-viewfield-city' => 'Lungsod',
	'sign-viewfield-state' => 'Estado',
	'sign-viewfield-country' => 'Bansa',
	'sign-viewfield-zip' => "Kodigong ''Zip''",
	'sign-viewfield-ip' => 'Adres ng IP',
	'sign-viewfield-agent' => 'Ahente ng tagagamit',
	'sign-viewfield-phone' => 'Telepono',
	'sign-viewfield-email' => 'E-liham',
	'sign-viewfield-age' => 'Edad (gulang)',
	'sign-viewfield-options' => 'Mga mapagpipilian',
	'sign-viewsigs-intro' => 'Ipinapakita sa ibaba ang mga lagdang naitala para kay <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Kasalukuyang pinapagana/pinapaandar ang paglalagda para sa kasulatan/dokumentong ito.',
	'sign-sigadmin-close' => 'Huwag paganahin/paandarin ang paglalagda',
	'sign-sigadmin-currentlyclosed' => 'Kasalukuyang hindi pinapagana/pinapaandar ang paglalagda para sa kasulatan/dokumentong ito.',
	'sign-sigadmin-open' => 'Paganahin/paandarin ang paglalagda',
	'sign-signatures' => 'Mga lagda',
	'sign-sigadmin-closesuccess' => 'Matagumpay na hindi pinagana/pinaandar ang paglalagda.',
	'sign-sigadmin-opensuccess' => 'Matagumpay na napagana/napaandar ang paglalagda.',
	'sign-viewsignatures' => 'tingnan ang mga lagda',
	'sign-closed' => 'nakasarado na',
	'sign-error-closed' => 'Kasalukuyang hindi pinapagana/pinapaandar ang paglalagda ng kasulatan/dokumentong ito.',
	'sig-anonymous' => '<i>Anonimo/Hindi nagpapakilala</i>',
	'sig-private' => '<i>Pribado/Pansarili</i>',
	'sign-sigdetails' => 'Mga detalye ng lagda',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|usapan]] • <!--
-->[[Special:Contributions/$1|mga ambag]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on "SINO SI" (WHOIS)] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|hadlangan ang tagagamit]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} talaan ng paghadlang] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} suriin ang IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'Nakaltas/Kinaltas na (pinatamaan ng guhit)',
	'sign-viewfield-reviewedby' => 'Tagapagsuri',
	'sign-viewfield-reviewcomment' => 'Puna/Kumento',
	'sign-detail-uniquequery' => 'Katulad na mga katauhan/katawan',
	'sign-detail-uniquequery-run' => 'Ihatid (pagalawin/patakbuhin) ang katangunan',
	'sign-detail-strike' => 'Kaltasin ang lagda (patamaan ng guhit)',
	'sign-reviewsig' => 'Suriin ang lagda',
	'sign-review-comment' => 'Puna/Kumento',
	'sign-submitreview' => 'Ipasa/ipadala ang pagsusuri',
	'sign-uniquequery-similarname' => 'Katulad na pangalan',
	'sign-uniquequery-similaraddress' => 'Katulad na adres/tirahan',
	'sign-uniquequery-similarphone' => 'Katulad na telepono',
	'sign-uniquequery-similaremail' => 'Katulad na e-liham',
	'sign-uniquequery-1signed2' => 'Nilagdaan ni [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] ang [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'signdocument' => 'Ký tài liệu',
	'sign-nodocselected' => 'Xin hãy chọn tài liệu bạn muốn ký.',
	'sign-selectdoc' => 'Tài liệu:',
	'sign-docheader' => '<div class="noarticletext">Xin hãy dùng mẫu này để ký tài liệu "[[$1]]," ghi ở dưới.
Xin hãy đọc qua toàn bộ tài liệu, và nếu bạn muốn chỉ rõ sự hỗ trợ của bạn cho nó, xin hãy điền các ô cần thiết để ký tên.</div>',
	'sign-error-nosuchdoc' => 'Tài liệu bạn yêu cầu ($1) không tồn tại.',
	'sign-realname' => 'Tên:',
	'sign-address' => 'Địa chỉ nhà:',
	'sign-city' => 'Thành phố:',
	'sign-state' => 'Bang:',
	'sign-zip' => 'Mã zip:',
	'sign-country' => 'Quốc gia:',
	'sign-phone' => 'Số điện thoại:',
	'sign-bday' => 'Tuổi:',
	'sign-email' => 'Địa chỉ email:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> chỉ các ô bắt buộc.</i></small>',
	'sign-hide-note' => '<small><i><font color="red">**</font> Chú ý: Thông tin không liệt kê sẽ hiển thị cho người quản trị.</i></small>',
	'sign-list-anonymous' => 'Liệt kê ẩn danh',
	'sign-list-hideaddress' => 'Đừng liệt kê địa chỉ',
	'sign-list-hideextaddress' => 'Đừng liệt kê thành phố, bang, zip, hay quốc gia',
	'sign-list-hidephone' => 'Đừng liệt kê số điện thoại',
	'sign-list-hidebday' => 'Đừng liệt kê tuổi',
	'sign-list-hideemail' => 'Đừng liệt kê email',
	'sign-submit' => 'Ký tài liệu',
	'sign-information' => '<div class="noarticletext">Cảm ơn bạn đã bỏ chút thời gian đọc hết tài liệu này.
Nếu bạn đồng ý với nó, xin hãy biểu thị sự ủng hộ của bạn bằng cách điền vào các khung bắt buộc phía dưới và nhấn "Ký tài liệu."
Xin hãy đảm bảo rằng thông tin cá nhân của bạn là đúng và rằng chúng ra có cách nào đó để liên lạc với bạn để xác nhận danh tính.
Chú ý rằng địa chỉ IP của bạn và những thông tin định danh khác sẽ được lưu giữ bởi mẫu này và được người quản trị xử dụng để xóa các chữ ký trùng lặp và xác nhận tính đúng đắn của thông tin cá nhân.
Vì việc sử dụng proxy mở và nặc danh ngăn trở khả năng thực hiện nhiệm vụ này của chúng tôi, chữ ký từ proxy như vậy sẽ không được tính.
Nếu hiện nay bạn đang kết nối thông qua máy chủ proxy, xin hãy tắt kết nối đến nó và sử dụng một kết nối tiêu chuẩn khi ký.</div>

$1',
	'sig-success' => 'Bạn đã ký tài liệu thành công.',
	'sign-view-selectfields' => '<b>Các vùng sẽ hiển thị:</b>',
	'sign-viewfield-entryid' => 'Mã số nhập',
	'sign-viewfield-timestamp' => 'Thời gian',
	'sign-viewfield-realname' => 'Tên',
	'sign-viewfield-address' => 'Địa chỉ',
	'sign-viewfield-city' => 'Thành phố',
	'sign-viewfield-state' => 'Bang',
	'sign-viewfield-country' => 'Quốc gia',
	'sign-viewfield-zip' => 'Zip',
	'sign-viewfield-ip' => 'Địa chỉ IP',
	'sign-viewfield-agent' => 'Trình duyệt người dùng',
	'sign-viewfield-phone' => 'Điện thoại',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Tuổi',
	'sign-viewfield-options' => 'Tùy chọn',
	'sign-viewsigs-intro' => 'Dưới đây là những chữ ký được lưu dữ lại cho <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Tài liệu này hiện đang cho phép ký tên.',
	'sign-sigadmin-close' => 'Tắt ký tên',
	'sign-sigadmin-currentlyclosed' => 'Tài liệu này hiện không kích hoạt ký tên.',
	'sign-sigadmin-open' => 'Cho phép ký tên',
	'sign-signatures' => 'Chữ ký',
	'sign-sigadmin-closesuccess' => 'Đã tắt ký tên thành công.',
	'sign-sigadmin-opensuccess' => 'Đã bật ký tên thành công.',
	'sign-viewsignatures' => 'xem chữ ký',
	'sign-closed' => 'đã đóng',
	'sign-error-closed' => 'Hiện không phép ký tên cho tài liệu này.',
	'sig-anonymous' => '<i>Vô danh</i>',
	'sig-private' => '<i>Riêng tư</i>',
	'sign-sigdetails' => 'Chi tiết chữ ký',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|thảo luận]] • <!--
-->[[Special:Contributions/$1|đóng góp]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|cấm thành viên]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} nhật trình cấm] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} kiểm ip])<!--
--></span>',
	'sign-viewfield-stricken' => 'Gạch bỏ',
	'sign-viewfield-reviewedby' => 'Người duyệt',
	'sign-viewfield-reviewcomment' => 'Bình luận',
	'sign-detail-uniquequery' => 'Thực thể tương tự',
	'sign-detail-uniquequery-run' => 'Chạy truy vấn',
	'sign-detail-strike' => 'Gạch bỏ chữ ký',
	'sign-reviewsig' => 'Duyệt chữ ký',
	'sign-review-comment' => 'Bình luận',
	'sign-submitreview' => 'Đăng bản duyệt',
	'sign-uniquequery-similarname' => 'Tên tương tự',
	'sign-uniquequery-similaraddress' => 'Địa chỉ tương tự',
	'sign-uniquequery-similarphone' => 'Số điện thoại tương tự',
	'sign-uniquequery-similaremail' => 'Email tương tự',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] đã ký [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'signdocument' => 'Dispenön dokümi',
	'sign-nodocselected' => 'Välolös dokümi, keli vilols dispenön.',
	'sign-selectdoc' => 'Doküm',
	'sign-docheader' => '<div class="noarticletext">Gebolös fometi at ad dispenön dokümi: „[[$1]]“, dono pajonöli. Dareidolös dokümi lölik ed if vilol jonön stüti olik tefü on, fulükolös felis paflagöl ad dispenön oni.</div>',
	'sign-error-nosuchdoc' => 'Doküm fa ol pavilöl no dabinon',
	'sign-realname' => 'Nem:',
	'sign-address' => 'Ladet (süt, domanüm):',
	'sign-city' => 'Zif:',
	'sign-state' => 'Tat:',
	'sign-zip' => 'Potakot:',
	'sign-country' => 'Län:',
	'sign-phone' => 'Telefonanüm:',
	'sign-bday' => 'Bäldot',
	'sign-email' => 'Ladet leäktronik:',
	'sign-indicates-req' => '<small><i><font color="red">*</font> malon felis peflagöl.</i></small>',
	'sign-list-anonymous' => 'Lisedön nennemiko',
	'sign-list-hideaddress' => 'No lisedön ladeti',
	'sign-list-hideextaddress' => 'No lisedön zifi, tati, potakoti u läni',
	'sign-list-hidephone' => 'No lisedön telefonanümi',
	'sign-list-hidebday' => 'No lisedön bäldoti',
	'sign-list-hideemail' => 'No lisedön ladeti leäktronik',
	'sign-submit' => 'Dispenön dokümi',
	'sig-success' => 'Edispenol dokümi benosekiko.',
	'sign-view-selectfields' => '<b>Fels jonabik:</b>',
	'sign-viewfield-realname' => 'Nem',
	'sign-viewfield-address' => 'Ladet',
	'sign-viewfield-city' => 'Zif',
	'sign-viewfield-state' => 'Tat',
	'sign-viewfield-country' => 'Län',
	'sign-viewfield-zip' => 'Potakot',
	'sign-viewfield-ip' => 'Ladet-IP',
	'sign-viewfield-phone' => 'Telefonanüm',
	'sign-viewfield-email' => 'Ladet leäktronik',
	'sign-viewfield-age' => 'Bäldot',
	'sign-sigadmin-currentlyopen' => 'Dispenam doküma at mögon anu.',
	'sign-sigadmin-close' => 'Nemögükön dispenami',
	'sign-sigadmin-currentlyclosed' => 'Dispenam doküma at nemögon anu.',
	'sign-sigadmin-open' => 'Mögükön dispenami',
	'sign-signatures' => 'Dispenäds',
	'sign-sigadmin-closesuccess' => 'Dispenam penemögükon benosekiko.',
	'sign-sigadmin-opensuccess' => 'Dispenam pemögükon benosekiko.',
	'sign-viewsignatures' => 'logön dispenädis',
	'sign-closed' => 'färmik',
	'sign-error-closed' => 'Dispenam doküma at nemögon anu.',
	'sig-anonymous' => '<i>Nennemik</i>',
	'sig-private' => '<i>Privatik</i>',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-viewfield-reviewcomment' => 'Küpet',
	'sign-review-comment' => 'Küpet',
	'sign-uniquequery-similarname' => 'Nem sümik',
	'sign-uniquequery-similaraddress' => 'Ladet sümik',
	'sign-uniquequery-similarphone' => 'Telefonanüm sümik',
	'sign-uniquequery-similaremail' => 'Ladet leäktronik sümik',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] edispenon dokümi: [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'sign-viewfield-realname' => '姓名',
	'sign-viewfield-address' => '地址',
	'sign-viewfield-ip' => 'IP地址',
	'sign-viewfield-phone' => '电话',
	'sign-viewfield-email' => '电子邮件',
	'sign-viewfield-age' => '年龄',
	'sign-uniquequery-similarname' => '近似姓名',
	'sign-uniquequery-similaraddress' => '近似地址',
	'sign-uniquequery-similarphone' => '近似电话',
	'sign-uniquequery-similaremail' => '近似电邮',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'sign-viewfield-realname' => '姓名',
	'sign-viewfield-address' => '地址',
	'sign-viewfield-ip' => 'IP位址',
	'sign-viewfield-phone' => '電話',
	'sign-viewfield-email' => '電郵',
	'sign-viewfield-age' => '年齡',
	'sign-uniquequery-similarname' => '近似姓名',
	'sign-uniquequery-similaraddress' => '近似地址',
	'sign-uniquequery-similarphone' => '近似電話',
	'sign-uniquequery-similaremail' => '近似電郵',
);

