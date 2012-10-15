<?php
/**
 * Messages for Special:SignDocument.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'signdocument'         => 'Sign document',
	'sign-nodocselected'   => 'Please select the document you wish to sign.',
	'sign-selectdoc'       => 'Document:',
	'sign-docheader'       => 'Please use this form to sign the document "[[$1]]," shown below.
Read through the entire document, and if you wish to indicate your support for it, fill in the required fields to sign it.',
	'sign-error-nosuchdoc' => 'The document you requested ($1) does not exist.',
	'sign-realname'        => 'Name:',
	'sign-address'         => 'Street address:',
	'sign-city'            => 'City:',
	'sign-state'           => 'State:',
	'sign-zip'             => 'Postal code:',
	'sign-country'         => 'Country:',
	'sign-phone'           => 'Phone number:',
	'sign-bday'            => 'Age:',
	'sign-email'           => 'E-mail address:',
	'sign-indicates-req'   => '<small><i><span style="color:red">*</span> Indicates required field.</i></small>',
	'sign-hide-note'       => '<small><i><span style="color:red">**</span> Note: Unlisted information will still be visible to moderators.</i></small>',
	'sign-list-anonymous'  => 'List anonymously',
	'sign-list-hideaddress' => 'Do not list address',
	'sign-list-hideextaddress' => 'Do not list city, state, postal code, or country',
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
	'sign-view-selectfields'    => '\'\'\'Fields to display:\'\'\'',
	'sign-viewfield-entryid'    => 'Entry ID',
	'sign-viewfield-timestamp'  => 'Timestamp',
	'sign-viewfield-realname'   => 'Name',
	'sign-viewfield-address'    => 'Address',
	'sign-viewfield-city'       => 'City',
	'sign-viewfield-state'      => 'State',
	'sign-viewfield-country'    => 'Country',
	'sign-viewfield-zip'        => 'Postal code',
	'sign-viewfield-ip'         => 'IP address',
	'sign-viewfield-agent'      => 'User agent',
	'sign-viewfield-phone'      => 'Phone',
	'sign-viewfield-email'      => 'E-mail',
	'sign-viewfield-age'        => 'Age',
	'sign-viewfield-options'    => 'Options',
	'sign-viewsigs-intro'       => 'Shown below are the signatures recorded for <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Signing is currently enabled for this document.',
	'sign-sigadmin-close'       => 'Disable signing',
	'sign-sigadmin-currentlyclosed' => 'Signing is currently disabled for this document.',
	'sign-sigadmin-open'        => 'Enable signing',
	'sign-signatures'           => 'Signatures',
	'sign-sigadmin-closesuccess' => 'Signing successfully disabled.',
	'sign-sigadmin-opensuccess' => 'Signing successfully enabled.',
	'sign-viewsignatures'       => 'view signatures',
	'sign-closed'               => 'closed',
	'sign-error-closed'         => 'Signing of this document is currently disabled.',
	'sig-anonymous'             => "''Anonymous''",
	'sig-private'               => "''Private''",
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
	'sign-uniquequery-similaraddress' => 'Similar address',
	'sign-uniquequery-similarphone' => 'Similar phone',
	'sign-uniquequery-similaremail' => 'Similar email',
	'sign-uniquequery-1signed2'    => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] signed [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Siebrand
 */
$messages['qqq'] = array(
	'signdocument' => '{{Identical|Sign document}}',
	'sign-realname' => '{{Identical|Name}}',
	'sign-address' => '{{Identical|Street}}',
	'sign-city' => '{{Identical|City}}',
	'sign-state' => '{{Identical|State}}',
	'sign-country' => '{{Identical|Country}}',
	'sign-phone' => '{{Identical|Phone number}}',
	'sign-email' => '{{Identical|E-mail address}}',
	'sign-submit' => '{{Identical|Sign document}}',
	'sign-viewfield-timestamp' => '{{Identical|Timestamp}}',
	'sign-viewfield-realname' => '{{Identical|Name}}',
	'sign-viewfield-address' => '{{Identical|Address}}',
	'sign-viewfield-city' => '{{Identical|City}}',
	'sign-viewfield-state' => '{{Identical|State}}',
	'sign-viewfield-country' => '{{Identical|Country}}',
	'sign-viewfield-ip' => '{{Identical|IP Address}}',
	'sign-viewfield-agent' => '{{Identical|User agent}}',
	'sign-viewfield-email' => '{{Identical|E-mail}}',
	'sign-viewfield-options' => '{{Identical|Options}}',
	'sign-signatures' => '{{Identical|Signature}}',
	'sign-closed' => '{{Identical|Closed}}',
	'sig-private' => '{{Identical|Private}}',
	'sign-emailto' => '{{optional}}',
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
	'signdocument' => 'Onderteken dokument',
	'sign-realname' => 'Naam:',
	'sign-address' => 'Straat:',
	'sign-city' => 'Stad:',
	'sign-state' => 'Staat:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telefoonnommer:',
	'sign-email' => 'E-posadres:',
	'sign-submit' => 'Onderteken dokument',
	'sign-viewfield-realname' => 'Naam',
	'sign-viewfield-address' => 'Adres',
	'sign-viewfield-city' => 'Stad',
	'sign-viewfield-state' => 'Staat',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-ip' => 'IP-adres',
	'sign-viewfield-email' => 'E-pos',
	'sign-viewfield-options' => 'Opsies',
	'sign-signatures' => 'Handtekeninge',
	'sign-closed' => 'gesluit',
	'sig-private' => "''Privaat''",
	'sign-viewfield-reviewedby' => 'Resensent',
	'sign-viewfield-reviewcomment' => 'Opmerking',
	'sign-review-comment' => 'Opmerking',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] ondertekende [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'signdocument' => 'dokument Regjistrohu',
	'sign-nodocselected' => 'Ju lutem zgjidhni dokumentin që dëshironi të nënshkruar.',
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
	'sign-viewfield-options' => 'ምርጫዎች',
	'sign-viewfield-reviewcomment' => 'ማጠቃለያ',
	'sign-review-comment' => 'ማጠቃለያ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'sign-realname' => 'Nombre:',
	'sign-viewfield-realname' => 'Nombre',
	'sign-signatures' => 'Sinyaturas',
	'sign-viewfield-reviewedby' => 'Revisador',
	'sign-viewfield-reviewcomment' => 'Comentario',
	'sign-review-comment' => 'Comentario',
	'sign-submitreview' => 'Ninviar revisión',
);

/** Old English (Ænglisc) */
$messages['ang'] = array(
	'sign-realname' => 'Nama:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 */
$messages['ar'] = array(
	'signdocument' => 'توقيع الوثيقة',
	'sign-nodocselected' => 'من فضلك اختر الوثيقة التي تود توقيعها.',
	'sign-selectdoc' => 'وثيقة:',
	'sign-docheader' => 'من فضلك استخدم هذه الاستمارة لتوقيع الوثيقة "[[$1]]," المعروضة بالأسفل.
من فضلك اقرأ الوثيقة كلها، وإذا كنت تود التعبير عن تأييدك لها، من فضلك املأ الحقول المطلوبة لتوقعها.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> يشير إلى حقل مطلوب.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> ملاحظة: المعلومات غير المعروضة ستظل مرئية للمديرين.</i></small>',
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
	'sign-view-selectfields' => "'''الحقول للعرض:'''",
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
	'sign-viewfield-options' => 'خيارات',
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
	'sig-anonymous' => "''مجهول''",
	'sig-private' => "''خاص''",
	'sign-sigdetails' => 'تفاصيل التوقيع',
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

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'sign-selectdoc' => 'ܐܫܛܪܐ:',
	'sign-realname' => 'ܫܡܐ:',
	'sign-city' => 'ܡܕܝܢܬܐ:',
	'sign-state' => 'ܐܘܚܕܢܐ:',
	'sign-country' => 'ܐܬܪܐ:',
	'sign-phone' => 'ܡܢܝܢܐ ܕܙܥܘܩܐ:',
	'sign-bday' => 'ܥܘܡܪܐ:',
	'sign-email' => 'ܦܪܫܓܢܐ ܕܒܝܠܕܪܐ ܐܠܩܛܪܘܢܝܐ:',
	'sign-list-hideemail' => 'ܠܐ ܓܠܚ ܒܝܠܕܪܐ ܐܠܩܛܪܘܢܝܐ',
	'sign-submit' => 'ܪܫܘܡ ܪܡܝ ܐܝܕܐ ܥܠ ܐܫܛܪܐ',
	'sign-viewfield-realname' => 'ܫܡܐ',
	'sign-viewfield-address' => 'ܦܪܫܓܢܐ',
	'sign-viewfield-city' => 'ܡܕܝܢܬܐ',
	'sign-viewfield-state' => 'ܐܘܚܕܢܐ:',
	'sign-viewfield-country' => 'ܐܬܪܐ',
	'sign-viewfield-agent' => 'ܩܝܝܘܡܐ ܕܡܦܠܚܢܐ',
	'sign-viewfield-phone' => 'ܙܥܘܩܐ',
	'sign-viewfield-email' => 'ܒܝܠܕܪܐ ܐܠܩܛܪܘܢܝܐ',
	'sign-viewfield-age' => 'ܥܘܡܪܐ',
	'sign-viewfield-options' => 'ܓܒܝܬ̈ܐ',
	'sig-anonymous' => "''ܠܐ ܝܕܝܥܐ''",
	'sig-private' => "''ܦܪܨܘܦܝܐ''",
	'sign-sigdetails' => 'ܐܪ̈ܝܟܬܐ ܕܪܡܝ ܐܝܕܐ',
	'sign-submitreview' => 'ܫܕܪ ܬܢܝܬܐ',
	'sign-uniquequery-similarname' => 'ܫܡܐ ܕܡܝܐ',
	'sign-uniquequery-similaraddress' => 'ܦܪܫܓܢܐ ܕܡܝܐ',
	'sign-uniquequery-similarphone' => 'ܙܥܘܩܐ ܕܡܝܐ',
	'sign-uniquequery-similaremail' => 'ܒܝܠܕܪܐ ܐܠܩܛܪܘܢܝܐ ܕܡܝܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'signdocument' => 'توقيع الوثيقة',
	'sign-nodocselected' => 'من فضلك اختر الوثيقة التى تود توقيعها.',
	'sign-selectdoc' => 'وثيقة:',
	'sign-docheader' => 'من فضلك استخدم هذه الاستمارة لتوقيع الوثيقة "[[$1]]," المعروضة بالأسفل.
من فضلك اقرأ الوثيقة كلها، وإذا كنت تود التعبير عن تأييدك لها، من فضلك املأ الحقول المطلوبة لتوقعها.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> يشير إلى حقل مطلوب.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> ملاحظة: المعلومات غير المعروضة ستظل مرئية للمديرين.</i></small>',
	'sign-list-anonymous' => 'عرض كمجهول',
	'sign-list-hideaddress' => 'لا تعرض العنوان',
	'sign-list-hideextaddress' => 'لا تعرض المدينة، الولاية، الرقم البريدى، أو البلد',
	'sign-list-hidephone' => 'لا تعرض الهاتف',
	'sign-list-hidebday' => 'لا تعرض العمر',
	'sign-list-hideemail' => 'لا تعرض البريد الإلكتروني',
	'sign-submit' => 'توقيع الوثيقة',
	'sign-information' => '<div class="noarticletext">شكرا لك لقضائك وقتا فى قراءة هذه الوثيقة.
لو أنك تتفق معها، من فضلك عبر عن تأييدك بواسطة ملأ الحقول المطلوبة بالأسفل وضغط "توقيع الوثيقة."
من فضلك تأكد من أن معلوماتك الشخصية صحيحة وأننا نملك وسيلة للاتصال بك للتأكد من هويتك.
لاحظ أن عنوان الأيبى الخاص بك ومعلومات التعريف الأخرى سيتم تسجيلها بواسطة هذه الاستمارة وسيتم استخدامها بواسطة المديرين لتحجيم التوقيعات المكررة وتأكيد صحة معلوماتك الشخصية.
بما أن استخدام البروكسيهات المجهولة والمفتوحة يمنع قدرتنا على أداء هذه المهمة، التوقيعات من هذه البروكسيهات على الأرجح لن يتم احتسابها.
لو أنك موصول حاليا بواسطة خادم بروكسى، من فضلك اقطع التوصيل منه واستخدم اتصالا قياسيا أثناء التوقيع.</div>

$1',
	'sig-success' => 'لقد وقعت الوثيقة بنجاح.',
	'sign-view-selectfields' => "'''الحقول للعرض:'''",
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
	'sig-anonymous' => "''مجهول''",
	'sig-private' => "''خاص''",
	'sign-sigdetails' => 'تفاصيل التوقيع',
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

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'sign-realname' => 'Ad:',
	'sign-address' => 'Küçə ünvanı:',
	'sign-city' => 'Şəhər:',
	'sign-state' => 'Dövlət:',
	'sign-zip' => 'Poçt indeksi:',
	'sign-country' => 'Ölkə:',
	'sign-phone' => 'Telefon nömrəsi:',
	'sign-email' => 'E-poçt ünvanı:',
	'sign-viewfield-realname' => 'Ad',
	'sign-viewfield-address' => 'Ünvan',
	'sign-viewfield-city' => 'Şəhər',
	'sign-viewfield-state' => 'Dövlət',
	'sign-viewfield-country' => 'Ölkə',
	'sign-viewfield-zip' => 'Poçt indeksi',
	'sign-viewfield-ip' => 'IP ünvanı',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-poçt',
	'sign-viewfield-options' => 'Nizamlamalar',
	'sign-signatures' => 'İmza',
	'sign-viewfield-reviewcomment' => 'Şərh',
	'sign-review-comment' => 'Şərh',
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'sign-zip' => 'Postleitzåih:',
	'sign-country' => 'Lãnd:',
	'sign-phone' => 'Telefonnumma:',
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

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'sign-city' => 'Горад:',
	'sign-state' => 'Штат:',
	'sign-viewfield-city' => 'Горад',
	'sign-viewfield-state' => 'Штат',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'signdocument' => 'Падпісаньне дакумэнту',
	'sign-nodocselected' => 'Калі ласка, выберыце дакумэнт, які Вы жадаеце падпісаць.',
	'sign-selectdoc' => 'Дакумэнт:',
	'sign-docheader' => 'Калі ласка, карыстайцеся гэтай формай для падпісаньня дакумэнту «[[$1]]», які знаходзіцца ніжэй.
Прачытайце ўвесь тэкст дакумэнту, і, калі Вы жадаеце выказаць яму падтрымку, запоўніце неабходныя палі і падпішыце яго.',
	'sign-error-nosuchdoc' => 'Запытаны дакумэнт ($1) не існуе.',
	'sign-realname' => 'Імя:',
	'sign-address' => 'Вуліца:',
	'sign-city' => 'Горад:',
	'sign-state' => 'Штат:',
	'sign-zip' => 'Паштовы індэкс:',
	'sign-country' => 'Краіна:',
	'sign-phone' => 'Нумар тэлефону:',
	'sign-bday' => 'Узрост:',
	'sign-email' => 'Адрас электроннай пошты:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> пазначае абавязковыя палі.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Заўвага: схаваная інфармацыя будзе бачная для мадэратараў.</i></small>',
	'sign-list-anonymous' => 'Сьпіс ананімных',
	'sign-list-hideaddress' => 'Не паказваць адрас',
	'sign-list-hideextaddress' => 'Не паказваць горад, штат, паштовы індэкс ці краіну',
	'sign-list-hidephone' => 'Не паказваць нумар тэлефону',
	'sign-list-hidebday' => 'Не паказваць узрост',
	'sign-list-hideemail' => 'Не паказваць адрас электроннай пошты',
	'sign-submit' => 'Падпісаць дакумэнт',
	'sign-information' => '<div class="noarticletext">Дзякуй, што Вы патрацілі свой час на чытаньне гэтага дакумэнта.
Калі Вы згодныя зь ім, калі ласка, выкажыце яму падтрымку, запоўніўшы ніжэй неабходныя палі і націснуўшы кнопку «Падпісаць дакумэнт».
Калі ласка, упэўніцеся, што Вашая асабістая інфармацыя зьяўляецца дакладнай і мы будзем мець магчымасьць з Вамі скантактавацца для праверкі сапраўднасьці подпісу.
Заўважце, што Ваш ІР-адрас і іншая ідэнтыфікацыйная інфармацыя будзе запісаная ў гэтай форме і выкарыстаная мадэратарамі, каб выключыць магчымасьць падвойных подпісаў і пацьверджаньня Вашай асабістай інфармацыі.
У выніку таго, што адкрытыя і ананімныя проксі-сэрвэра перашкаджаюць падобным праверкам, подпісы пададзеныя зь іх, хутчэй за ўсё, улічвацца ня будуць.
Калі Вы цяпер далучаныя праз проксі-сэрвэр, калі ласка, адлучыцеся ад яго і выкарыстайце стандартнае далучэньне пад час подпісу.</div>

$1',
	'sig-success' => 'Вы пасьпяхова падпісалі дакумэнт.',
	'sign-view-selectfields' => "'''Палі для паказу:'''",
	'sign-viewfield-entryid' => 'Ідэнтыфікатар запісу',
	'sign-viewfield-timestamp' => 'Дата/час',
	'sign-viewfield-realname' => 'Імя',
	'sign-viewfield-address' => 'Адрас',
	'sign-viewfield-city' => 'Горад',
	'sign-viewfield-state' => 'Штат',
	'sign-viewfield-country' => 'Краіна',
	'sign-viewfield-zip' => 'Паштовы індэкс',
	'sign-viewfield-ip' => 'ІР-адрас',
	'sign-viewfield-agent' => 'Браўзэр',
	'sign-viewfield-phone' => 'Тэлефон',
	'sign-viewfield-email' => 'Электронная пошта',
	'sign-viewfield-age' => 'Узрост',
	'sign-viewfield-options' => 'Налады',
	'sign-viewsigs-intro' => 'Ніжэй паказаны подпісы сабраныя за <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Цяпер падпісаньне ўключанае для гэтага дакумэнта.',
	'sign-sigadmin-close' => 'Адключыць падпісаньне',
	'sign-sigadmin-currentlyclosed' => 'Цяпер падпісаньне адключанае для гэтага дакумэнту.',
	'sign-sigadmin-open' => 'Уключыць падпісаньне',
	'sign-signatures' => 'Подпісы',
	'sign-sigadmin-closesuccess' => 'Падпісаньне пасьпяхова адключанае.',
	'sign-sigadmin-opensuccess' => 'Падпісаньне пасьпяхова ўключана.',
	'sign-viewsignatures' => 'паказаць подпісы',
	'sign-closed' => 'закрыта',
	'sign-error-closed' => 'Падпісаньне для гэтага дакумэнту цяпер адключанае.',
	'sig-anonymous' => "''Ананімны''",
	'sig-private' => "''Прыватны''",
	'sign-sigdetails' => 'Падрабязнасьці пра подпіс',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|гутаркі]] • <!--
-->[[Special:Contributions/$1|унёсак]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|блякаваньне ўдзельніка]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} журнал блякаваньняў] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} праверыць ІР-адрас])<!--
--></span>',
	'sign-viewfield-stricken' => 'Выдаленыя',
	'sign-viewfield-reviewedby' => 'Правяраючы',
	'sign-viewfield-reviewcomment' => 'Камэнтар',
	'sign-detail-uniquequery' => 'Падобныя запісы',
	'sign-detail-uniquequery-run' => 'Выканаць запыт',
	'sign-detail-strike' => 'Выдаліць подпіс',
	'sign-reviewsig' => 'Праверыць подпіс',
	'sign-review-comment' => 'Камэнтар',
	'sign-submitreview' => 'Правесьці праверку',
	'sign-uniquequery-similarname' => 'Падобнае імя',
	'sign-uniquequery-similaraddress' => 'Падобны адрас',
	'sign-uniquequery-similarphone' => 'Падобны тэлефон',
	'sign-uniquequery-similaremail' => 'Падобны адрас электроннай пошты',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] падпісаў [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> задължително поле</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Забележка: Информацията, която не се показана ще бъде видима за модераторите.</i></small>',
	'sign-list-hideaddress' => 'Без показване на адрес',
	'sign-list-hideextaddress' => 'Без показване на град, щат, пощенски код или държава',
	'sign-list-hidephone' => 'Без показване на телефон',
	'sign-list-hidebday' => 'Без показване на възраст',
	'sign-list-hideemail' => 'Без показване на е-поща',
	'sign-view-selectfields' => "'''Полета за показване:'''",
	'sign-viewfield-timestamp' => 'Време на запис на действието',
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
	'sign-closed' => 'затворени',
	'sign-error-closed' => 'В момента подписването на този документ не е позволено.',
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

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'sign-realname' => 'নাম:',
	'sign-address' => 'রাস্তার ঠিকানা:',
	'sign-city' => 'শহর:',
	'sign-state' => 'প্রদেশ:',
	'sign-zip' => 'পোস্টাল কোড:',
	'sign-country' => 'দেশ:',
	'sign-phone' => 'ফোন নম্বর:',
	'sign-bday' => 'বয়স:',
	'sign-email' => 'ইমেইল ঠিকানা:',
	'sign-list-anonymous' => 'বেনামী হিসেবে তালিকাভুক্ত করো',
	'sign-list-hideaddress' => 'ঠিকানা তালিকাভুক্ত কোরো না',
	'sign-list-hideextaddress' => 'শহর, প্রদেশ, পোস্টাল কোড, বা দেশ তালিকাভুক্ত কোরো না',
	'sign-list-hidephone' => 'ফোন নম্বর তালিকাভুক্ত কোরো না',
	'sign-list-hidebday' => 'বয়স তালিকাভুক্ত কোরো না',
	'sign-list-hideemail' => 'ই-মেইল তালিকাভুক্ত কোরো না',
	'sign-viewfield-entryid' => 'প্রবেশের আইডি',
	'sign-viewfield-timestamp' => 'সময়বার্তা',
	'sign-viewfield-realname' => 'নাম',
	'sign-viewfield-address' => 'ঠিকানা',
	'sign-viewfield-city' => 'শহর',
	'sign-viewfield-state' => 'প্রদেশ',
	'sign-viewfield-country' => 'দেশ',
	'sign-viewfield-zip' => 'পোস্টাল কোড',
	'sign-viewfield-ip' => 'আইপি ঠিকানা',
	'sign-viewfield-agent' => 'ব্যবহারকারী এজেন্ট',
	'sign-viewfield-phone' => 'ফোন',
	'sign-viewfield-email' => 'ই-মেইল',
	'sign-viewfield-age' => 'বয়স',
	'sign-viewfield-options' => 'অপশন',
	'sign-sigadmin-close' => 'স্বাক্ষর নিষ্ক্রিয় করো',
	'sign-sigadmin-open' => 'স্বাক্ষর সক্রিয় করো',
	'sign-signatures' => 'স্বাক্ষর',
	'sign-sigadmin-closesuccess' => 'স্বাক্ষর সফলভাবে নিষ্ক্রিয় করা হয়েছে।',
	'sign-sigadmin-opensuccess' => 'স্বাক্ষর সফলভাবে সক্রিয় করা হয়েছে।',
	'sign-viewsignatures' => 'স্বাক্ষর দেখাও',
	'sign-closed' => 'বাতিল',
	'sig-anonymous' => "''বেনামী''",
	'sig-private' => "''ব্যক্তিগত''",
	'sign-sigdetails' => 'স্বাক্ষরের বিস্তারিত',
	'sign-viewfield-reviewedby' => 'পর্যবেক্ষক',
	'sign-viewfield-reviewcomment' => 'মন্তব্য',
	'sign-detail-uniquequery-run' => 'কোয়েরি চালু করো',
	'sign-review-comment' => 'মন্তব্য',
	'sign-submitreview' => 'পর্যালোচনা জমা দিন',
	'sign-uniquequery-similarname' => 'সাদৃশ্যপূর্ণ নাম',
	'sign-uniquequery-similaraddress' => 'সাদৃশ্যপূর্ণ ঠিকানা',
	'sign-uniquequery-similarphone' => 'সাদৃশ্যপূর্ণ ফোন নম্বর',
	'sign-uniquequery-similaremail' => 'সাদৃশ্যপূর্ণ ই-মেইল',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'signdocument' => 'Sinañ an teul',
	'sign-nodocselected' => "Diuzit an teul hoc'h eus c'hoant da sinañ, mar plij.",
	'sign-selectdoc' => 'Teul :',
	'sign-docheader' => 'Grit gant ar furmskrid-mañ evit sinañ ar teul "[[$1]]," diskouezet dindan.
Lennit-pizh an teul ha, mar fell deoc\'h embann ho skoazell, leugnit ar maeziennoù rekis evit e sinañ.',
	'sign-error-nosuchdoc' => "N'eus ket eus an teul ($1) hoc'h eus goulennet.",
	'sign-realname' => 'Anv :',
	'sign-address' => "Chomlec'h :",
	'sign-city' => 'Kêr :',
	'sign-state' => 'Stad :',
	'sign-zip' => 'Kod-post :',
	'sign-country' => 'Bro :',
	'sign-phone' => 'Niverenn bellgomz :',
	'sign-bday' => 'Oad :',
	'sign-email' => "Chomlec'h postel :",
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> diskouez a ra ar maeziennoù ret.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Notenn : Gallout a raio atav an habaskerien lenn an titouroù n\'int ket bet rollet.</i></small>',
	'sign-list-anonymous' => 'Rollañ en un doare dizanv',
	'sign-list-hideaddress' => "Chom hep menegiñ ar chomlec'h",
	'sign-list-hideextaddress' => "Arabat menegiñ ar gêr, ar stad (departamant), ar c'hod post pe ar vro",
	'sign-list-hidephone' => 'chom hep menegiñ an niverenn bellgomz',
	'sign-list-hidebday' => 'Chom hep menegiñ an oad',
	'sign-list-hideemail' => "Chom hep menegiñ ar chomlec'h postel",
	'sign-submit' => 'Sinañ an teul',
	'sign-information' => "<div class=\"noarticletext\">Ho trugarekaat da vezañ kemeret amzer da lenn an teul-mañ penn-da-benn.
M'emaoc'h a-du gantañ, embannit ho skoazell en ur leuniañ ar maeziennoù rekis a-is ha klikit war \"Sinañ an teul\".
Gwiriit mat eo reizh ho titouroù personel hag e c'hallomp mont e darempred ganeoc'h en un doare bennak evit gwiriañ piv oc'h.
Notit ma vo enrollet ho chomlec'h IP ha titouroù all gant ar furmskrid-mañ; implijet e vint gant an habaskerien evit skarzhañ ar sinadurioù doubl ha kadarnaat reizhder an titouroù merket.
Dre ma n'hallomp ket ober se pa implijer proksioù digor ha dianavout ne vo ket kontet ar sinadurioù o tont diwar seurt proksioù. 
Mard oc'h kevreet dre ur servijer proksi, digevreit ha grit gant ur gevreadenn voutin evit sinañ.</div>

\$1",
	'sig-success' => "Sinet hoc'h eus an teul.",
	'sign-view-selectfields' => "'''Maeziennoù da ziskwel :'''",
	'sign-viewfield-entryid' => 'Id ar gasadenn',
	'sign-viewfield-timestamp' => 'Deiziad hag eur',
	'sign-viewfield-realname' => 'Anv',
	'sign-viewfield-address' => "Chomlec'h",
	'sign-viewfield-city' => 'Kêr',
	'sign-viewfield-state' => 'Stad',
	'sign-viewfield-country' => 'Bro',
	'sign-viewfield-zip' => 'Kod post',
	'sign-viewfield-ip' => "Chomlec'h IP",
	'sign-viewfield-agent' => 'Dileuriad an implijer',
	'sign-viewfield-phone' => 'Pellgomz',
	'sign-viewfield-email' => 'Postel',
	'sign-viewfield-age' => 'Oad',
	'sign-viewfield-options' => 'Dibarzhioù',
	'sign-viewsigs-intro' => 'Amañ dindan emañ ar sinadurioù enrollet evit <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Gweredekaet eo ar sinañ evit an teul-mañ.',
	'sign-sigadmin-close' => 'Diweredekaat an dilesadur',
	'sign-sigadmin-currentlyclosed' => 'Diweredekaet eo ar sinañ evit an teul-mañ.',
	'sign-sigadmin-open' => 'Gweredekaat an dilesadur',
	'sign-signatures' => 'Sinadurioù',
	'sign-sigadmin-closesuccess' => 'Diweredekaet eo bet an dilesadur.',
	'sign-sigadmin-opensuccess' => 'Gweredekaet eo bet an dilesadur.',
	'sign-viewsignatures' => 'gwelet ar sinadurioù',
	'sign-closed' => 'serr',
	'sign-error-closed' => 'Diweredekaet eo sinadur an teul-mañ evit poent.',
	'sig-anonymous' => "''Dizanv''",
	'sig-private' => "''Prevez''",
	'sign-sigdetails' => 'Munudoù ar sinadur',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|Kaozeadenn]] • <!--
-->[[Special:Contributions/$1|Degasadennoù]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|Stankañ an implijer]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} Marilh ar stankadennoù] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} Gwiriekadur un implijer])<!--
--></span>',
	'sign-viewfield-stricken' => 'Barrennet',
	'sign-viewfield-reviewedby' => 'Adweler',
	'sign-viewfield-reviewcomment' => 'Addispleg',
	'sign-detail-uniquequery' => 'Hennadoù damheñvel',
	'sign-detail-uniquequery-run' => 'Lañsañ ar reked',
	'sign-detail-strike' => 'Barrennañ ar sinadur',
	'sign-reviewsig' => 'Adwelet ar sinadur',
	'sign-review-comment' => 'Addispleg',
	'sign-submitreview' => 'Kas an adweladenn',
	'sign-uniquequery-similarname' => 'Anv damheñvel',
	'sign-uniquequery-similaraddress' => "Chomlec'h damheñvel",
	'sign-uniquequery-similarphone' => 'Niverenn bellgomz damheñvel',
	'sign-uniquequery-similaremail' => 'Postel damheñvel',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] en deus kadarnaet [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'signdocument' => 'Potpisivanje dokumenta',
	'sign-nodocselected' => 'Molimo odaberite dokument koji želite da potpišete.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => 'Molimo koristite ovaj obrazac za potpisivanje dokumenta "[[$1]]," prikazanog dolje.
Pročitajte cijeli dokument i ako želite da izrazite vašu podršku, popunite neophodna polja da ga potpišete.',
	'sign-error-nosuchdoc' => 'Dokument koji ste zahtijevali ($1) ne postoji.',
	'sign-realname' => 'Ime:',
	'sign-address' => 'Kućna adresa:',
	'sign-city' => 'Grad:',
	'sign-state' => 'Pokrajina:',
	'sign-zip' => 'Poštanski broj:',
	'sign-country' => 'Država:',
	'sign-phone' => 'Broj telefona:',
	'sign-bday' => 'Starost:',
	'sign-email' => 'E-mail adresa:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> označava obavezna polja.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Napomena: Ne prikazane informacije će i dalje biti dostupne moderatorima.</i></small>',
	'sign-list-anonymous' => 'Prikaži anonimne',
	'sign-list-hideaddress' => 'Ne prikazuj adresu',
	'sign-list-hideextaddress' => 'Ne prikazuj grad, pokrajinu, poštanski broj ili državu',
	'sign-list-hidephone' => 'Ne prikazuj broj telefona',
	'sign-list-hidebday' => 'Ne prikazuj godine',
	'sign-list-hideemail' => 'Ne prikazuj e-mail',
	'sign-submit' => 'Potpiši dokument',
	'sign-information' => "<div class=\"noarticletext\">Hvala vam što ste uzeli vremena da pročitate ovaj dokument.
Ako se slažete s njim, molimo pokažite vašu podršku tako što ćete popuniti neophodna polja ispod i kliknuti ''Potpiši dokument''.

Molimo provjerite da su vaši lični podaci tačni i da ćemo vas kontaktirati na neki način da provjerimo vaš identitet.
Zapamtite da će vaša IP adresa i drugi identifikujući podaci biti spremljeni u ovom obrazcu i da će ih koristiti moderatori da uklone dvostruke potpise i potvrde tačnost vaših ličnih podataka.
Pošto korištenje otvorenih i anonimnih proksija onemogućuje vašu mogućnost da uradite ovaj zadatak, potpisi iz takvih proksija se sigurno neće brojati.
Ako ste trenutno konektovani preko proksi servera, molimo diskonektujte se i koristite standardnu konekciju dok se potpisujete.</div>

\$1",
	'sig-success' => 'Uspješno ste potpisali dokument.',
	'sign-view-selectfields' => "'''Polja za prikaz:'''",
	'sign-viewfield-entryid' => 'ID stavke',
	'sign-viewfield-timestamp' => 'Vremenska oznaka',
	'sign-viewfield-realname' => 'Ime',
	'sign-viewfield-address' => 'Adresa',
	'sign-viewfield-city' => 'Grad',
	'sign-viewfield-state' => 'Pokrajina',
	'sign-viewfield-country' => 'Država',
	'sign-viewfield-zip' => 'Poštanski broj',
	'sign-viewfield-ip' => 'IP adresa',
	'sign-viewfield-agent' => 'Korisnički agent',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Starost',
	'sign-viewfield-options' => 'Opcije',
	'sign-viewsigs-intro' => 'Ispod su prikazani potpisi spremljeni za <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Potpisivanje ovog dokumenta je trenutno omogućeno.',
	'sign-sigadmin-close' => 'Onemogući potpisivanje',
	'sign-sigadmin-currentlyclosed' => 'Potpisivanje ovog dokumenta trenutno je onemogućeno.',
	'sign-sigadmin-open' => 'Omogući potpisivanje',
	'sign-signatures' => 'Potpisi',
	'sign-sigadmin-closesuccess' => 'Potpisivanje uspješno onemogućeno.',
	'sign-sigadmin-opensuccess' => 'Potpisivanje uspješno omogućeno.',
	'sign-viewsignatures' => 'vidi potpise',
	'sign-closed' => 'zatvoreno',
	'sign-error-closed' => 'Potpisivanje ovog dokumenta je trenutno onemogućeno.',
	'sig-anonymous' => "''Anonimni''",
	'sig-private' => "''Privatno''",
	'sign-sigdetails' => 'Detalji potpisa',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|razgovor]] • <!--
-->[[Special:Contributions/$1|doprinosi]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|blokiraj korisnika]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} zapisnik blokiranja] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} provjera ip])<!--
--></span>',
	'sign-viewfield-stricken' => 'Precrtano',
	'sign-viewfield-reviewedby' => 'Pregledač',
	'sign-viewfield-reviewcomment' => 'Komentar',
	'sign-detail-uniquequery' => 'Slične stavke',
	'sign-detail-uniquequery-run' => 'Pokreni upit',
	'sign-detail-strike' => 'Precrtaj potpis',
	'sign-reviewsig' => 'Provjeri potpis',
	'sign-review-comment' => 'Komentar',
	'sign-submitreview' => 'Pošalji pregled',
	'sign-uniquequery-similarname' => 'Slično ime',
	'sign-uniquequery-similaraddress' => 'Slične adrese',
	'sign-uniquequery-similarphone' => 'Slični telefoni',
	'sign-uniquequery-similaremail' => 'Sličan e-mail',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] je potpisao [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author Solde
 */
$messages['ca'] = array(
	'sign-selectdoc' => 'Document:',
	'sign-realname' => 'Nom:',
	'sign-address' => 'Adreça:',
	'sign-city' => 'Ciutat:',
	'sign-state' => 'Estat:',
	'sign-zip' => 'Codi postal:',
	'sign-country' => 'País:',
	'sign-phone' => 'Telèfon:',
	'sign-bday' => 'Edat:',
	'sign-email' => 'Correu electrònic:',
	'sign-list-hideaddress' => "No mostris l'adreça",
	'sign-list-hideextaddress' => "No mostris la ciutat, l'estat, el codi postal, o el país",
	'sign-list-hidephone' => 'No mostris el telèfon',
	'sign-list-hidebday' => "No mostris l'edat",
	'sign-list-hideemail' => 'No mostris el correu electrònic',
	'sign-viewfield-timestamp' => 'Fus horari',
	'sign-viewfield-realname' => 'Nom',
	'sign-viewfield-address' => 'Adreça',
	'sign-viewfield-city' => 'Ciutat',
	'sign-viewfield-state' => 'Estat',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-zip' => 'Codi postal',
	'sign-viewfield-ip' => 'Adreça IP',
	'sign-viewfield-phone' => 'Telèfon',
	'sign-viewfield-email' => 'Correu electrònic',
	'sign-viewfield-age' => 'Edat',
	'sign-viewfield-options' => 'Opcions',
	'sig-anonymous' => "''Anònim''",
	'sig-private' => "''Privat''",
	'sign-viewfield-reviewcomment' => 'Comentari',
	'sign-review-comment' => 'Comentari',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|дийцаре]] • <!--
-->[[Special:Contributions/$1|къинхьегам]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|сацаве декъашхо]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} сацораш долу тéптар] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} хьажа])<!--
--></span>',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'sign-realname' => 'Jméno:',
	'sign-address' => 'Adresu:',
	'sign-city' => 'Město:',
	'sign-state' => 'Stát:',
	'sign-country' => 'Země:',
	'sign-bday' => 'Věk:',
	'sign-email' => 'E-mailová adresa:',
	'sign-viewfield-timestamp' => 'Časová značka',
	'sign-viewfield-realname' => 'Jméno',
	'sign-viewfield-address' => 'Adresa',
	'sign-viewfield-city' => 'Město',
	'sign-viewfield-country' => 'Země',
	'sign-viewfield-zip' => 'PSČ',
	'sign-viewfield-ip' => 'IP adresa',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Věk',
	'sign-closed' => 'zavřeno',
	'sign-viewfield-reviewcomment' => 'Komentář',
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
	'sig-private' => "''Privat''",
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Imre
 * @author Kghbln
 * @author Leithian
 * @author Melancholie
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'signdocument' => 'Dokument signieren',
	'sign-nodocselected' => 'Bitte wähle das zu signierende Dokument aus.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => 'Bitte benutze dieses Formular, um das hierunter angezeigte Dokument „[[$1]]“ zu signieren.
Bitte lies das gesammte Dokument und wenn du ihm deine Zustimmung gibt, fülle bitte die nötigen Felder aus, um es zu signieren.',
	'sign-error-nosuchdoc' => 'Das angeforderte Dokument ($1) existiert nicht.',
	'sign-realname' => 'Name:',
	'sign-address' => 'Straße:',
	'sign-city' => 'Stadt:',
	'sign-state' => 'Bundesland:',
	'sign-zip' => 'Postleitzahl:',
	'sign-country' => 'Staat:',
	'sign-phone' => 'Telefonnummer:',
	'sign-bday' => 'Alter:',
	'sign-email' => 'E-Mail-Adresse:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> benötigtes Feld.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Beachte: Unaufgelistete Informationen sind trotzdem für Moderatoren sichtbar.</i></small>',
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
	'sign-view-selectfields' => "'''Anzuzeigende Felder:'''",
	'sign-viewfield-entryid' => 'Eintragskennung',
	'sign-viewfield-timestamp' => 'Zeitstempel',
	'sign-viewfield-realname' => 'Name',
	'sign-viewfield-address' => 'Anschrift',
	'sign-viewfield-city' => 'Stadt',
	'sign-viewfield-state' => 'Bundesland',
	'sign-viewfield-country' => 'Staat',
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
	'sign-sigadmin-closesuccess' => 'Signieren erfolgreich deaktiviert.',
	'sign-sigadmin-opensuccess' => 'Signieren erfolgreich aktiviert.',
	'sign-viewsignatures' => 'Signaturen anschauen',
	'sign-closed' => 'geschlossen',
	'sign-error-closed' => 'Es ist derzeit nicht möglich, dieses Dokument zu signieren.',
	'sig-anonymous' => "''Anonym''",
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Signaturdetails',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|Diskussion]] • <!--
-->[[Special:Contributions/$1|Beiträge]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|Benutzer sperren]] • <!--
-->[{{fullurl:{{#special:Log}}|type=block&page={{ns:2}}:{{urlencode:$1}}}} Sperr-Logbuch] • <!--
-->[{{fullurl:{{#special:CheckUser}}|ip={{urlencode:$1}}}} Checkuser])<!--
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

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Revolus
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'sign-nodocselected' => 'Bitte wählen Sie das zu signierende Dokument aus.',
	'sign-docheader' => 'Bitte benutzen Sie dieses Formular, um das hierunter angezeigte Dokument „[[$1]]“ zu signieren.
Bitte lesen Sie das gesammte Dokument und wenn Sie ihm Ihre Zustimmung geben, füllen Sie bitte die nötigen Felder aus, um es zu signieren.',
	'sign-information' => '<div class="noarticletext">Danke, dass Sie sich die Zeit genommen haben, dieses Dokument durchzulesen.
Wenn Sie ihm zustimmen, zeigen Sie dies bitte indem Sie die benötigten Felder unten ausfüllen und anschließend auf „Dokument unterschreiben“ klicken.
Bitte stellen Sie sicher, dass Ihre persönlichen Informationen korrekt sind und dass wir die Möglichkeit haben, Sie zur Feststellung Ihrer Identität zu kontaktieren.
Beachten Sie, dass Ihre IP-Adresse und andere persönliche Informationen von diesem Formular aufgezeichnet werden und dass sie von Moderatoren benutzt werden, um doppelte Unterschriften zu beseitigen und Ihre Daten zu verifizieren.
Da die Benutzung offener Proxys uns in der Durchführung dieser Aufgabe einschränkt, werden Unterschriften über solche Proxys in der Regel nicht bearbeitet.
Sollten Sie gerade über einen solchen Server verbunden sein, trennen Sie bitte die Verbindung von ihm und nutzen Sie eine Standardverbindung.</div>

$1',
	'sig-success' => 'Sie haben das Dokument erfolgreich unterschrieben.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'signdocument' => 'Dokument signěrowaś',
	'sign-nodocselected' => 'Pšosym wubjeŕ dokument, kótaryž coš signěrowaś.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => 'Pšosym wužyj toś ten formular, aby signěrował slědujucy dokument "[[$1]]".
Pśecytaj ceły dokument, a jolic coš swóju pódpěru za njen daś, wupołń trěbne póla, aby jen signěrował.',
	'sign-error-nosuchdoc' => 'Dokument, kótaryž sy se pominał ($1), njeeksistěrujo.',
	'sign-realname' => 'Mě:',
	'sign-address' => 'Droga:',
	'sign-city' => 'Město:',
	'sign-state' => 'Zwězkowy kraj:',
	'sign-zip' => 'Postowa licba:',
	'sign-country' => 'Kraj:',
	'sign-phone' => 'Telefonowy numer:',
	'sign-bday' => 'Starstwo:',
	'sign-email' => 'E-mailowa adresa:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> wobznamjenjujo trěbne pólo.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Pśispomnjeśe: Njepódane informacije su weto za moderatorow widobne.</i></small>',
	'sign-list-anonymous' => 'Anonymnje nalicyś',
	'sign-list-hideaddress' => 'Adresu njepomjeniś',
	'sign-list-hideextaddress' => 'Město, zwězkowy kraj, postowu licbu abo kraj njenalicyś',
	'sign-list-hidephone' => 'Telefonowy numer njepomjeniś',
	'sign-list-hidebday' => 'Starstwo njepomjeniś',
	'sign-list-hideemail' => 'E-mailowu adresu njepomjeniś',
	'sign-submit' => 'Dokument signěrowaś',
	'sign-information' => '<div class="noarticletext">Źěkujomy se za to, až sy se cas wzeł, toś ten dokument pśecytaś. Jolic sy z tym wobjadny, pokaž pšosym swój pódpěru a wupołń trěbne póla  dołojce a klikni na "Dokument signěrowaś".
Pšosym pśeznań se, až twóje wósobinske informacije su korektne a až mamy móžnosć se z tobu do zwiska stajiś, aby my pśekontrolěrowali twóju identitu.
Glědaj, až twója IP-adresa a druge identificěrujuce informacije budu se pśez toś ten formular registrěrowaś a budu se wót moderatorow wužywaś, aby eliminěrowali dwójne signatury a wobkšuśowali pšawosć twójich wósobinskich informacijow.
Dokulaž wužywanje wócynjonych a anonymnych proksy wobgranicujo našu móžnosć toś ten nadawk dopołniś, signatury ze takich proksy njebudu se nejskerje licyś.
Jolic sy tuchylu pśez serwer proksy zwězany, pśetergni pšosym zwisk a wužyj standardny zwisk pśi signěrowanju.</div>

$1',
	'sig-success' => 'Sy wuspěšnje signěrował dokument.',
	'sign-view-selectfields' => "'''Póla, kótarež maju se zwobrazniś:'''",
	'sign-viewfield-entryid' => 'ID zapiska',
	'sign-viewfield-timestamp' => 'Casowy kołk',
	'sign-viewfield-realname' => 'Mě',
	'sign-viewfield-address' => 'Adresa',
	'sign-viewfield-city' => 'Město',
	'sign-viewfield-state' => 'Zwězkowy kraj',
	'sign-viewfield-country' => 'Kraj',
	'sign-viewfield-zip' => 'Postowa licba',
	'sign-viewfield-ip' => 'IP-adresa',
	'sign-viewfield-agent' => 'Identifikacija wobglědowaka',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Starstwo',
	'sign-viewfield-options' => 'Opcije',
	'sign-viewsigs-intro' => 'Dołojce slěduju signatury zregistrěrowane za <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Signěrowanje jo tuchylu zmóžnjone za toś ten dokument.',
	'sign-sigadmin-close' => 'Signěrowanje znjemóžniś',
	'sign-sigadmin-currentlyclosed' => 'Signěrowanje jo tuchylu znjemóžnjone za toś ten dokument.',
	'sign-sigadmin-open' => 'Signěrowanje zmóžniś',
	'sign-signatures' => 'Signatury',
	'sign-sigadmin-closesuccess' => 'Signěrowanje wuspěšnje znjemóžnjone.',
	'sign-sigadmin-opensuccess' => 'Signěrowanje wuspěšnje zmóžnjone.',
	'sign-viewsignatures' => 'signatury se woglědaś',
	'sign-closed' => 'zacynjony',
	'sign-error-closed' => 'Signěrowanje toś togo dokumenta jo tuchylu znjemóžnjone.',
	'sig-anonymous' => "''Anonymny''",
	'sig-private' => "''Priwatny''",
	'sign-sigdetails' => 'Drobnostki signatury',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|diskusija]] • <!--
-->[[Special:Contributions/$1|pśinoski]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|wužywarja blokerowaś]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} protokol blokěrowanjow] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} kontrolowy wužywaŕ])<!--
--></span>',
	'sign-viewfield-stricken' => 'Wušmarnjony',
	'sign-viewfield-reviewedby' => 'Pséglědowaŕ',
	'sign-viewfield-reviewcomment' => 'Komentar',
	'sign-detail-uniquequery' => 'Pódobne entity',
	'sign-detail-uniquequery-run' => 'Napšašowanje startowaś',
	'sign-detail-strike' => 'Signaturu wušmarnuś',
	'sign-reviewsig' => 'Signaturu pśeglědaś',
	'sign-review-comment' => 'Komentar',
	'sign-submitreview' => 'Pśeglědanje wótpósłaś',
	'sign-uniquequery-similarname' => 'Pódobne mě',
	'sign-uniquequery-similaraddress' => 'Pódobna adresa',
	'sign-uniquequery-similarphone' => 'Pódobny telefonowy numer',
	'sign-uniquequery-similaremail' => 'Pódobna e-mailowa adresa',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] jo signěrował [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'signdocument' => 'Υπογραφή εγγράφου',
	'sign-nodocselected' => 'Παρακαλώ επιλέξτε το έγγραφο που θα θέλατε να υπογράψετε.',
	'sign-selectdoc' => 'Έγγραφο:',
	'sign-error-nosuchdoc' => 'Το έγγραφο που ζητήσατε ($1) δεν υπάρχει.',
	'sign-realname' => 'Όνομα:',
	'sign-address' => 'Διεύθυνση οικίας:',
	'sign-city' => 'Πόλη:',
	'sign-state' => 'Πολιτεία:',
	'sign-zip' => 'Ταχυδρομικός κώδικας:',
	'sign-country' => 'Χώρα:',
	'sign-phone' => 'Αριθμός τηλεφώνου:',
	'sign-bday' => 'Ηλικία:',
	'sign-email' => 'Διεύθυνση ηλεκτρονικού ταχυδρομείου:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> υποδεικνύει τα υποχρεωτικά πεδία.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Σημείωση: Ακαταχώρητες πληροφορίες θα είναι ορατές στους μεσολαβητές.</i></small>',
	'sign-list-anonymous' => 'Ανώνυμη κατάταξη',
	'sign-list-hideaddress' => 'Μην περιλαβάνετε τη διεύθυνση',
	'sign-list-hideextaddress' => 'Μην περιλαμβάνετε πόλη, πολιτεία, Τ.Κ., ή χώρα',
	'sign-list-hidephone' => 'Μην περιλαμβάνετε το τηλέφωνο',
	'sign-list-hidebday' => 'Μην περιλαμβάνετε την ηλικία',
	'sign-list-hideemail' => 'Μην περιλαμβάνετε την ηλεκτρονική διεύθυνση',
	'sign-submit' => 'Πιστοποίηση εγγράφου',
	'sig-success' => 'Έχεις επιτυχώς υπογράψει το έγγραφο.',
	'sign-view-selectfields' => "'''Πεδία προς προβολή:'''",
	'sign-viewfield-entryid' => 'Καταχώρηση ταυτότητας',
	'sign-viewfield-timestamp' => 'Ημερομηνία',
	'sign-viewfield-realname' => 'Όνομα',
	'sign-viewfield-address' => 'Διεύθυνση',
	'sign-viewfield-city' => 'Πόλη',
	'sign-viewfield-state' => 'Πολιτεία',
	'sign-viewfield-country' => 'Χώρα',
	'sign-viewfield-zip' => 'Τ.Κ.',
	'sign-viewfield-ip' => 'IP διεύθυνση',
	'sign-viewfield-agent' => 'Χρήστης πράκτορας',
	'sign-viewfield-phone' => 'Τηλέφωνο',
	'sign-viewfield-email' => 'Ηλεκτρονικό ταχυδρομείο',
	'sign-viewfield-age' => 'Ηλικία',
	'sign-viewfield-options' => 'Επιλογές',
	'sign-sigadmin-currentlyopen' => 'Η υπογραφή είναι τώρα ενεργοποιημένη για αυτό το έγγραφο.',
	'sign-sigadmin-close' => 'Απενεργοποίηση υπογραφής',
	'sign-sigadmin-currentlyclosed' => 'Η υπογραφή είναι τώρα απενεργοποιημένη για αυτό το έγγραφο.',
	'sign-sigadmin-open' => 'Ενεργοποίηση υπογραφής',
	'sign-signatures' => 'Υπογραφές',
	'sign-sigadmin-closesuccess' => 'Η επιτυχής υπογραφή απενεργοποιήθηκε.',
	'sign-sigadmin-opensuccess' => 'Η επιτυχής υπογραφή ενεργοποιήθηκε.',
	'sign-viewsignatures' => 'προβολή υπογραφών',
	'sign-closed' => 'κλεισμένο',
	'sign-error-closed' => 'Η υπογραφή αυτού του εγγράφου είναι τώρα απενεργοποιημένη.',
	'sig-anonymous' => "''Ανώνυμος''",
	'sig-private' => "''Ιδιωτικός''",
	'sign-sigdetails' => 'Λεπτομέρειες υπογραφής',
	'sign-viewfield-stricken' => 'Σβησμένο',
	'sign-viewfield-reviewedby' => 'Κριτικός',
	'sign-viewfield-reviewcomment' => 'Σχόλιο',
	'sign-detail-uniquequery' => 'Παρόμοιες οντότητες',
	'sign-detail-uniquequery-run' => 'Εκτέλεση αιτήματος',
	'sign-detail-strike' => 'Σβήσιμο υπογραφής',
	'sign-reviewsig' => 'Επισκόπηση υπογραφής',
	'sign-review-comment' => 'Σχόλιο',
	'sign-submitreview' => 'Καταχώρηση κριτικής',
	'sign-uniquequery-similarname' => 'Παρόμοιο όνομα',
	'sign-uniquequery-similaraddress' => 'Παρόμοια διεύθυνση',
	'sign-uniquequery-similarphone' => 'Παρόμοιο τηλέφωνο',
	'sign-uniquequery-similaremail' => 'Παρόμοιο email',
);

/** British English (British English)
 * @author Reedy
 */
$messages['en-gb'] = array(
	'sign-information' => '<div class="noarticletext">Thank you for taking the time to read through this document.
If you agree with it, please indicate your support by filling in the required fields below and clicking "Sign document".
Please ensure that your personal information is correct and that we have some way to contact you to verify your identity.
Note that your IP address and other identifying information will be recorded by this form and used by moderators to eliminate duplicate signatures and confirm the correctness of your personal information.
As the use of open and anonymising proxies inhibits our ability to perform this task, signatures from such proxies will likely not be counted.
If you are currently connected through a proxy server, please disconnect from it and use a standard connection while signing.</div>

$1',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indikas devigan kampon.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span>Notu: Nelistigita informo ankoraŭ estos videbla al administrantoj.</i></small>',
	'sign-list-anonymous' => 'Listigu anonime',
	'sign-list-hideaddress' => 'Ne listigu adreson',
	'sign-list-hideextaddress' => 'Ne montru urbon, subŝtaton, poŝtkodon, aŭ landon',
	'sign-list-hidephone' => 'Ne listigu nombron de telefono',
	'sign-list-hidebday' => 'Ne montru aĝon',
	'sign-list-hideemail' => 'Ne listigu retadreson',
	'sign-submit' => 'Subskribi dokumenton',
	'sig-success' => 'Vi sukcese subskribis la dokumenton.',
	'sign-view-selectfields' => "'''Kampoj montri:'''",
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
	'sign-sigadmin-currentlyopen' => 'Subskribado estas nune ŝalta por ĉi tiu dokumento.',
	'sign-sigadmin-close' => 'Malŝalti subskribadon',
	'sign-sigadmin-currentlyclosed' => 'Subskribado estas nune malŝalta por ĉi tiu dokumento.',
	'sign-sigadmin-open' => 'Ŝalti subskribadon',
	'sign-signatures' => 'Subskriboj',
	'sign-sigadmin-closesuccess' => 'Subskribado estis sukcese malŝaltita.',
	'sign-sigadmin-opensuccess' => 'Subskribado estis sukcese ŝaltita.',
	'sign-viewsignatures' => 'vidi subskribojn',
	'sign-closed' => 'fermita',
	'sign-error-closed' => 'Subskribado de ĉi tiu dokumento estas nune malŝalta.',
	'sig-anonymous' => "''Anonima''",
	'sig-private' => "''Privata''",
	'sign-sigdetails' => 'Subskribaj detaloj',
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
 * @author Crazymadlover
 * @author Dferg
 * @author Imre
 */
$messages['es'] = array(
	'signdocument' => 'Firmar documento',
	'sign-nodocselected' => 'Por favor seleccione el documento que desea firmar.',
	'sign-selectdoc' => 'Documento:',
	'sign-docheader' => 'Por favor usar este formulario para firmar el documento "[[$1]]," mostrado abajo.
Leer todo el documento completo, y si deseas indicar tu apoyo a él, rellena en los campos requeridos para firmarlo.',
	'sign-error-nosuchdoc' => 'El documento que ha solicitado ($1) no existe.',
	'sign-realname' => 'Nombre:',
	'sign-address' => 'Dirección domiciliaria:',
	'sign-city' => 'Ciudad:',
	'sign-state' => 'Estado:',
	'sign-zip' => 'Código postal:',
	'sign-country' => 'País:',
	'sign-phone' => 'Número de teléfono:',
	'sign-bday' => 'Edad:',
	'sign-email' => 'Dirección de correo electrónico:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indica campos requeridos.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Nota: Información no listada será todavía visible para los moderadores.</i></small>',
	'sign-list-anonymous' => 'Listar anónimamente',
	'sign-list-hideaddress' => 'No listar dirección',
	'sign-list-hideextaddress' => 'No listar ciudad, estado/región/departamento, código postal, o ciudad',
	'sign-list-hidephone' => 'No listar teléfono',
	'sign-list-hidebday' => 'No listar edad',
	'sign-list-hideemail' => 'No listar correo electrónico',
	'sign-submit' => 'Firmar documento',
	'sign-information' => '<div class="noarticletext">Gracias por tomarte el tiempo de revisar este documento.
Si estás de acuerdo con él, Por favor indica tu apoyo llenando en los campos requeridos abajo y haciendo click en "Firmar documento".
Por favor asegúrate que tu información personal es correcta y que tenemos alguna forma de contactarte para verificar tu identidad.
Nota que tu dirección IP y otra información de identidad será registrada mediante este formulario y usada por los moderadores para eliminar firmas duplicadas y confirmar la exactitud de tu información personal.
Como el uso de proxies abiertos y anónimos inhiben nuestra habilidad de ejecutar esta tarea, las firmas desde estos proxies al parecer no serán contadas.
Si estás actualmente conectado a través de un servidor proxy, por favor desconéctate de el y usa una conexión standard cuando firmes.</div>

$1',
	'sig-success' => 'Ha firmado exitosamente el documento.',
	'sign-view-selectfields' => "'''Campos a mostrar:'''",
	'sign-viewfield-entryid' => 'Ingresar ID',
	'sign-viewfield-timestamp' => 'Fechador',
	'sign-viewfield-realname' => 'Nombre',
	'sign-viewfield-address' => 'Dirección',
	'sign-viewfield-city' => 'Ciudad',
	'sign-viewfield-state' => 'Estado',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-zip' => 'Código postal',
	'sign-viewfield-ip' => 'Dirección IP',
	'sign-viewfield-agent' => 'Agente de usuario',
	'sign-viewfield-phone' => 'Teléfono',
	'sign-viewfield-email' => 'Correo electrónico',
	'sign-viewfield-age' => 'Edad',
	'sign-viewfield-options' => 'Opciones',
	'sign-viewsigs-intro' => 'Lo mostrado abajo son las firmas registradas para <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Firma esta actualmente habilitada para este documento.',
	'sign-sigadmin-close' => 'Deshabilitar firma',
	'sign-sigadmin-currentlyclosed' => 'Firma actualmente está deshabilitada para este documento.',
	'sign-sigadmin-open' => 'Habilitar firma',
	'sign-signatures' => 'Firmas',
	'sign-sigadmin-closesuccess' => 'Firma exitosamente deshabilitada.',
	'sign-sigadmin-opensuccess' => 'Firma exitosamente habilitada.',
	'sign-viewsignatures' => 'ver firmas',
	'sign-closed' => 'cerrado',
	'sign-error-closed' => 'Firma de este documento está actualmente deshabilitada.',
	'sig-anonymous' => "''Anónimo''",
	'sig-private' => "''Privado''",
	'sign-sigdetails' => 'detalles de firma',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|discusión]] • <!--
-->[[Special:Contributions/$1|contribuciones]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|bloquear usuario]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} bloquear registro] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} checkip])<!--
--></span>',
	'sign-viewfield-stricken' => 'Tachado',
	'sign-viewfield-reviewedby' => 'Revisor',
	'sign-viewfield-reviewcomment' => 'Comentario',
	'sign-detail-uniquequery' => 'Entidades similares',
	'sign-detail-uniquequery-run' => 'Ejecutar consulta',
	'sign-detail-strike' => 'Tachar firma',
	'sign-reviewsig' => 'Revisar firma',
	'sign-review-comment' => 'Comentario',
	'sign-submitreview' => 'Enviar revisión',
	'sign-uniquequery-similarname' => 'Nombre similar',
	'sign-uniquequery-similaraddress' => 'Dirección similar',
	'sign-uniquequery-similarphone' => 'Teléfono similar',
	'sign-uniquequery-similaremail' => 'Correo electrónico similar',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] firmó [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Estonian (Eesti)
 * @author Silvar
 */
$messages['et'] = array(
	'sign-signatures' => 'Allkirjad',
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
	'sign-email' => 'E-posta helbidea:',
	'sign-submit' => 'Dokumentua sinatu',
	'sig-success' => 'Dokumentua arrakastatsuki sinatu duzu.',
	'sign-viewfield-entryid' => 'NAN zenbakia:',
	'sign-viewfield-realname' => 'Izena',
	'sign-viewfield-address' => 'Helbidea',
	'sign-viewfield-city' => 'Udalerria',
	'sign-viewfield-state' => 'Estatua',
	'sign-viewfield-country' => 'Herrialdea',
	'sign-viewfield-zip' => 'Posta kodea',
	'sign-viewfield-ip' => 'IP helbidea',
	'sign-viewfield-phone' => 'Telefonoa',
	'sign-viewfield-email' => 'Emaila',
	'sign-viewfield-age' => 'Adina',
	'sign-viewfield-options' => 'Aukerak',
	'sign-signatures' => 'Sinadurak',
	'sign-viewsignatures' => 'ikusi sinadurak',
	'sign-closed' => 'itxita',
	'sig-anonymous' => "''Anonimoa''",
	'sig-private' => "''Pribatua''",
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
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 */
$messages['fi'] = array(
	'signdocument' => 'Allekirjoita asiakirja',
	'sign-nodocselected' => 'Valitse asiakirja, jonka haluat allekirjoittaa.',
	'sign-selectdoc' => 'Asiakirja',
	'sign-error-nosuchdoc' => 'Pyytämääsi asiakirjaa ($1) ei löydy.',
	'sign-realname' => 'Nimi',
	'sign-address' => 'Katuosoite',
	'sign-city' => 'Kaupunki',
	'sign-state' => 'Lääni',
	'sign-zip' => 'Postinumero',
	'sign-country' => 'Maa',
	'sign-phone' => 'Puhelinnumero',
	'sign-bday' => 'Ikä',
	'sign-email' => 'Sähköpostiosoite',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> tarkoittaa pakollista kenttää.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Valvojat voivat nähdä piilotetut tiedot.</i></small>',
	'sign-list-anonymous' => 'Listaa nimettömänä',
	'sign-list-hideaddress' => 'Älä listaa osoitetta',
	'sign-list-hideextaddress' => 'Älä listaa kaupunkia, osavaltiota ja lääniä, postinumeroa tai maata',
	'sign-list-hidephone' => 'Älä listaa puhelinnumeroa',
	'sign-list-hidebday' => 'Älä listaa ikää',
	'sign-list-hideemail' => 'Älä listaa sähköpostiosoitetta',
	'sign-submit' => 'Allekirjoita dokumentti',
	'sig-success' => 'Onnistuneesti allekirjoitit asiakirjan.',
	'sign-view-selectfields' => "'''Näytettävät kentät:'''",
	'sign-viewfield-timestamp' => 'Aikaleima',
	'sign-viewfield-realname' => 'Nimi',
	'sign-viewfield-address' => 'Osoite',
	'sign-viewfield-city' => 'Kaupunki',
	'sign-viewfield-state' => 'Lääni',
	'sign-viewfield-country' => 'Maa',
	'sign-viewfield-zip' => 'Postinumero',
	'sign-viewfield-ip' => 'IP-osoite',
	'sign-viewfield-agent' => 'Selaintunniste',
	'sign-viewfield-phone' => 'Puhelin',
	'sign-viewfield-email' => 'Sähköpostiosoite',
	'sign-viewfield-age' => 'Ikä',
	'sign-viewfield-options' => 'Valinnat',
	'sign-sigadmin-currentlyopen' => 'Tällä hetkellä  tämän asiakirjan allekirjoitustoiminto on käytössä.',
	'sign-sigadmin-close' => 'Ota allekirjoittaminen pois käytöstä',
	'sign-sigadmin-currentlyclosed' => 'Tällä hetkellä tämän asiakirjan allekirjoittamistoiminto on estetty.',
	'sign-sigadmin-open' => 'Ota allekirjoittaminen käyttöön',
	'sign-signatures' => 'Allekirjoitukset',
	'sign-sigadmin-closesuccess' => 'Allekirjoittaminen poistettiin käytöstä onnistuneesti.',
	'sign-sigadmin-opensuccess' => 'Allekirjoitus otettiin käyttöön onnistuneesti.',
	'sign-viewsignatures' => 'näytä allekirjoitukset',
	'sign-closed' => 'suljettu',
	'sign-error-closed' => 'Tämän asiakirjan allekirjoittamistoiminto on tällä hetkellä estetty.',
	'sig-anonymous' => "''Nimetön''",
	'sig-private' => "''Yksityinen''",
	'sign-sigdetails' => 'Allekirjoituksen tiedot',
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
	'sign-viewfield-reviewedby' => 'Arvioija',
	'sign-viewfield-reviewcomment' => 'Kommentti',
	'sign-detail-uniquequery-run' => 'Suorita kysely',
	'sign-detail-strike' => 'Yliviivaa allekirjoitus',
	'sign-reviewsig' => 'Arvioi allekirjoitus',
	'sign-review-comment' => 'Kommentoi',
	'sign-submitreview' => 'Lähetä arvio',
	'sign-uniquequery-similarname' => 'Samankaltainen nimi',
	'sign-uniquequery-similaraddress' => 'Samankaltainen osoite',
	'sign-uniquequery-similarphone' => 'Samankaltainen puhelinnumero',
	'sign-uniquequery-similaremail' => 'Samankaltainen sähköpostiosoite',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author Peter17
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'signdocument' => 'Authentifier le document',
	'sign-nodocselected' => 'Prière de choisir le document que vous voulez authentifier',
	'sign-selectdoc' => 'Document :',
	'sign-docheader' => 'Prière d’utiliser ce formulaire pour authentifier le document « [[$1]] » affichée ci-dessous.
Lire le document au complet, et si vous souhaitez signifier votre appui, remplir les champs pour l’authentifier.',
	'sign-error-nosuchdoc' => 'Le document demandé ($1) n’existe pas.',
	'sign-realname' => 'Nom :',
	'sign-address' => 'Adresse rue :',
	'sign-city' => 'Ville :',
	'sign-state' => 'État, département ou province :',
	'sign-zip' => 'Code postal :',
	'sign-country' => 'Pays :',
	'sign-phone' => 'Numéro de téléphone :',
	'sign-bday' => 'Âge :',
	'sign-email' => 'Adresse électronique :',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indique les champs obligatoires.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Les informations non listées sont toujours visibles pour les modérateurs.</i></small>',
	'sign-list-anonymous' => 'Lister de façon anonyme',
	'sign-list-hideaddress' => 'Ne pas lister l’adresse',
	'sign-list-hideextaddress' => 'Ne pas lister la ville, l’état (le département ou la province), le code postal ou le pays',
	'sign-list-hidephone' => 'Ne pas lister le numéro de téléphone',
	'sign-list-hidebday' => 'Ne pas lister l’âge',
	'sign-list-hideemail' => 'Ne pas lister l’adresse de courriel',
	'sign-submit' => 'Authentifier le document',
	'sign-information' => '<div class="noarticletext">Merci d’avoir complètement lu ce document. Si vous êtes d’accord avec son contenu, signifiez votre appui en remplissant les champs requis ci-dessous et en cliquant « {{int:sign-submit}} ».
Prière de vérifier que vos informations personnelles sont exactes et que nous possédons un moyen de vous contacter pour valider votre identité.
Votre adresse IP et d’autres informations qui peuvent vous identifier sont notées et seront utilisées par les modérateurs pour éliminer les signatures en doublon et confirmer les informations saisies.
Les serveurs mandataires (proxys) ne nous permettant pas d’identifier à coup sûr le signataire, les signatures obtenues à travers ceux-ci ne seront probablement pas comptées.
Si vous êtes connecté{{GENDER:||e|(e)}} à travers un serveur mandataire, prière d’utiliser un compte qui n’en utilise pas.</div>

$1',
	'sig-success' => 'Vous avez authentifié le document.',
	'sign-view-selectfields' => "'''Champs à afficher :'''",
	'sign-viewfield-entryid' => 'ID de l’entrée',
	'sign-viewfield-timestamp' => 'Date et heure',
	'sign-viewfield-realname' => 'Nom',
	'sign-viewfield-address' => 'Adresse',
	'sign-viewfield-city' => 'Ville',
	'sign-viewfield-state' => 'État / province',
	'sign-viewfield-country' => 'Pays',
	'sign-viewfield-zip' => 'Code postal',
	'sign-viewfield-ip' => 'Adresse IP',
	'sign-viewfield-agent' => 'Agent utilisateur',
	'sign-viewfield-phone' => 'Numéro de téléphone',
	'sign-viewfield-email' => 'Courriel',
	'sign-viewfield-age' => 'Âge',
	'sign-viewfield-options' => 'Options',
	'sign-viewsigs-intro' => 'Ci-dessous apparaissent les signatures enregistrées pour <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'L’authentification est présentement activée pour ce document.',
	'sign-sigadmin-close' => 'Désactiver l’authentification',
	'sign-sigadmin-currentlyclosed' => 'L’authentification est présentement désactivée pour ce document.',
	'sign-sigadmin-open' => 'Activer l’authentification',
	'sign-signatures' => 'Signatures',
	'sign-sigadmin-closesuccess' => 'L’authentification est désactivée.',
	'sign-sigadmin-opensuccess' => 'L’authentification est activée.',
	'sign-viewsignatures' => 'Voir les signatures',
	'sign-closed' => 'fermée',
	'sign-error-closed' => 'L’authentification de ce document est présentée désactivée.',
	'sig-anonymous' => "''Anonyme''",
	'sig-private' => "''Privé''",
	'sign-sigdetails' => 'Détails de la signature',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
		-->[[User:$1|$1]] ([[User talk:$1|Discussion]] • <!--
		-->[[Special:Contributions/$1|Contributions]] • <!--
		-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
		-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
		-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
		-->[[Special:BlockIP/$1|Bloquer l’utisateur]] • <!--
		-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} Journal des blocages] • <!--
		-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} Vérification d’utilisateur])<!--
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

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'signdocument' => 'Signér lo document',
	'sign-nodocselected' => 'Volyéd chouèsir lo document que vos voléd signér.',
	'sign-selectdoc' => 'Document :',
	'sign-error-nosuchdoc' => 'Lo document demandâ ($1) ègziste pas.',
	'sign-realname' => 'Nom :',
	'sign-address' => 'Rua :',
	'sign-city' => 'Vela :',
	'sign-state' => 'Ètat (dèpartement ou ben province) :',
	'sign-zip' => 'Code postâl :',
	'sign-country' => 'Payis :',
	'sign-phone' => 'Numerô de tèlèfono :',
	'sign-bday' => 'Âjo :',
	'sign-email' => 'Adrèce èlèctronica :',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> endique los champs oblegatouèros.</i></small>',
	'sign-list-anonymous' => 'Listar de façon anonima',
	'sign-list-hideaddress' => 'Pas listar l’adrèce',
	'sign-list-hideextaddress' => 'Pas listar la vela, l’ètat (lo dèpartement ou ben la province), lo code postâl ou ben lo payis',
	'sign-list-hidephone' => 'Pas listar lo numerô de tèlèfono',
	'sign-list-hidebday' => 'Pas listar l’âjo',
	'sign-list-hideemail' => 'Pas listar l’adrèce èlèctronica',
	'sign-submit' => 'Signér lo document',
	'sig-success' => 'Vos éd signê lo document avouéc reusséta.',
	'sign-view-selectfields' => "'''Champs a fâre vêre :'''",
	'sign-viewfield-entryid' => 'Numerô de l’entrâ',
	'sign-viewfield-timestamp' => 'Dâta et hora',
	'sign-viewfield-realname' => 'Nom',
	'sign-viewfield-address' => 'Adrèce',
	'sign-viewfield-city' => 'Vela',
	'sign-viewfield-state' => 'Ètat (dèpartement ou ben province)',
	'sign-viewfield-country' => 'Payis',
	'sign-viewfield-zip' => 'Code postâl',
	'sign-viewfield-ip' => 'Adrèce IP',
	'sign-viewfield-agent' => 'Agent usanciér',
	'sign-viewfield-phone' => 'Numerô de tèlèfono',
	'sign-viewfield-email' => 'Adrèce èlèctronica',
	'sign-viewfield-age' => 'Âjo',
	'sign-viewfield-options' => 'Chouèx',
	'sign-sigadmin-currentlyopen' => 'Ora, la signatura est activâ por ceti document.',
	'sign-sigadmin-close' => 'Dèsactivar la signatura',
	'sign-sigadmin-currentlyclosed' => 'Ora, la signatura est dèsactivâ por ceti document.',
	'sign-sigadmin-open' => 'Activar la signatura',
	'sign-signatures' => 'Signatures',
	'sign-sigadmin-closesuccess' => 'La signatura est dèsactivâ avouéc reusséta.',
	'sign-sigadmin-opensuccess' => 'La signatura est activâ avouéc reusséta.',
	'sign-viewsignatures' => 'vêre les signatures',
	'sign-closed' => 'cllôs',
	'sig-anonymous' => "''Anonimo''",
	'sig-private' => "''Privâ''",
	'sign-sigdetails' => 'Dètalys de la signatura',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|Discussion]] • <!--
-->[[Special:Contributions/$1|Contribucions]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|Blocar l’usanciér]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} Jornal des blocâjos] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} Contrôlo d’usanciér])<!--
--></span>',
	'sign-viewfield-stricken' => 'Traciê',
	'sign-viewfield-reviewedby' => 'Rèvisor',
	'sign-viewfield-reviewcomment' => 'Comentèro',
	'sign-detail-uniquequery' => 'Entitâts semblâbles',
	'sign-detail-uniquequery-run' => 'Ègzécutar la requéta',
	'sign-detail-strike' => 'Traciér la signatura',
	'sign-reviewsig' => 'Revêre la signatura',
	'sign-review-comment' => 'Comentèro',
	'sign-submitreview' => 'Sometre la rèvision',
	'sign-uniquequery-similarname' => 'Nom semblâblo',
	'sign-uniquequery-similaraddress' => 'Adrèce semblâbla',
	'sign-uniquequery-similarphone' => 'Numerô de tèlèfono semblâblo',
	'sign-uniquequery-similaremail' => 'Adrèce èlèctronica semblâbla',
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
	'sign-docheader' => 'Use este formulario para asinar o documento "[[$1]]", amosado a continuación.
Lea o documento enteiro, e se desexa indicar o seu apoio ao mesmo, encha os campos necesarios para asinalo.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> Indica un campo obrigatorio.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Nota: a información non listada poderana ver, porén, os moderadores.</i></small>',
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
	'sign-view-selectfields' => "'''Campos a mostrar:'''",
	'sign-viewfield-entryid' => 'ID da entrada',
	'sign-viewfield-timestamp' => 'Data e hora',
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
	'sign-viewsigs-intro' => 'A continuación móstranse as sinaturas gardadas para <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Actualmente están habilitadas as sinaturas para este documento.',
	'sign-sigadmin-close' => 'Desactivar as sinaturas',
	'sign-sigadmin-currentlyclosed' => 'Actualmente están desactivadas as sinaturas para este documento.',
	'sign-sigadmin-open' => 'Activar as sinaturas',
	'sign-signatures' => 'Sinaturas',
	'sign-sigadmin-closesuccess' => 'As sinaturas desactiváronse sen problemas.',
	'sign-sigadmin-opensuccess' => 'As sinaturas activáronse sen problemas.',
	'sign-viewsignatures' => 'ver as sinaturas',
	'sign-closed' => 'pechado',
	'sign-error-closed' => 'Actualmente están desactivadas as sinaturas neste documento.',
	'sig-anonymous' => "''Anónimo''",
	'sig-private' => "''Privado''",
	'sign-sigdetails' => 'Detalles da sinatura',
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
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'sign-realname' => 'Ὄνομα:',
	'sign-phone' => 'Ἀριθμὸς τηλεφώνου:',
	'sign-email' => 'Ἡλεκτρονικὴ διεύθυνσις:',
	'sign-viewfield-realname' => 'Ὄνομα',
	'sign-viewfield-address' => 'Διεύθυνσις',
	'sign-viewfield-city' => 'Πόλις',
	'sign-viewfield-state' => 'Πολιτεία',
	'sign-viewfield-country' => 'Χώρα',
	'sign-viewfield-ip' => 'Διεύθυνσις IP:',
	'sign-viewfield-agent' => 'Χρώμενος πράκτωρ',
	'sign-viewfield-phone' => 'Τηλέφωνον',
	'sign-viewfield-email' => 'Ἠλεκτρονικαὶ ἐπιστολαί',
	'sign-viewfield-age' => 'Ἡλικία',
	'sign-viewfield-options' => 'Ἐπιλογαί',
	'sig-private' => '<ι>Ἰδιωτική</ι>',
	'sign-viewfield-reviewedby' => 'ἐπιθεωρητής',
	'sign-viewfield-reviewcomment' => 'Σχόλιον',
	'sign-detail-uniquequery-run' => 'Ἐκτελεῖν πεῦσιν',
	'sign-review-comment' => 'Σχόλιον',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'signdocument' => 'Dokumänt signiere',
	'sign-nodocselected' => 'Bitte wehl s Dokumänt uus, wu soll signiert wäre.',
	'sign-selectdoc' => 'Dokumänt:',
	'sign-docheader' => 'Bitte verwänd des Formular go s Dokumänt „[[$1]]“  signiere, wu do unte aazeigt wird.
Bitte liis s ganz Dokumänt un wänn Du Dyyni Zuestimmig gisch, fill bitte di notwändige Fälder uus go s signiere.',
	'sign-error-nosuchdoc' => 'S Dokumänt ($1), wu Du aagforderet hesch, git s nit.',
	'sign-realname' => 'Name:',
	'sign-address' => 'Stroß:',
	'sign-city' => 'Stadt:',
	'sign-state' => 'Bundesland/Kanton:',
	'sign-zip' => 'Poschtleitzahl:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telifonnummere:',
	'sign-bday' => 'Alter:',
	'sign-email' => 'E-Mail-Adräss:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> zeigt s Fäld aa, wu s bruucht.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Obacht: Informatione, wu nit uflischtet sin,  sin einewäg fir Moderatore sichtbar.</i></small>',
	'sign-list-anonymous' => 'Anonym uflischte',
	'sign-list-hideaddress' => 'Adräss nit uflischte',
	'sign-list-hideextaddress' => 'Stadt, Staat, PLZ oder Land nit uflischte',
	'sign-list-hidephone' => 'Telifonnummere nit uflischte',
	'sign-list-hidebday' => 'Alter nit uflischte',
	'sign-list-hideemail' => 'E-Mail-Adräss nit uflischte',
	'sign-submit' => 'Dokumänt unterzeichne',
	'sign-information' => '<div class="noarticletext">Dankschen, ass Du Dir d Zyt gnuh hesch, des Dokumänt durzläse.
Wänn Du ihm zuestimmsch, no zeig des bitte indäm Du di notwändige Fälder unten uusfillsch un deno uf „Dokumänt unterschryybe“ drucksch.
Bitte stell sicher, ass Dyyni persenlige Informatione korrekt sin un ass mir d Megligkeit hän, Di z kontaktiere go Dyyni Identität feschtzstelle.
Gib Acht, ass Dyyni IP-Adräss un anderi persenligi Informatione vu däm Formular ufzeichnet wäre un ass si vu Moderatore bruucht wäre go doppleti Unterschrifte usezneh un Dyyni Date z verifiziere.
Wel mir dodebyy yygschränkt sin, wänn Du uffigi Proxy verwändsch, wäre Unterschrifte iber sonigi Proxy normalerwyys nit bearbeitet.
Wänn Du grad iber eso ne Server verbunde bisch, no tränn bitte d Verbindig vun em un bruuch e Standardverbindig1.</div>

$1',
	'sig-success' => 'Du hesch s Dokumänt erfolgryych unterschribe.',
	'sign-view-selectfields' => "'''Fälder, wu aazeigt wäre:'''",
	'sign-viewfield-entryid' => 'Yytragskännig',
	'sign-viewfield-timestamp' => 'Zytstämpfel',
	'sign-viewfield-realname' => 'Name',
	'sign-viewfield-address' => 'Adräss',
	'sign-viewfield-city' => 'Stadt',
	'sign-viewfield-state' => 'Bundesland/Kanton',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-zip' => 'Poschtleitzahl',
	'sign-viewfield-ip' => 'IP-Adräss',
	'sign-viewfield-agent' => 'Browser',
	'sign-viewfield-phone' => 'Telifon',
	'sign-viewfield-email' => 'E-Mail',
	'sign-viewfield-age' => 'Alter',
	'sign-viewfield-options' => 'Optione',
	'sign-viewsigs-intro' => 'Do unte wäre d Signature ufglischtet, wu fir <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span> ufzeichnet wore sin.',
	'sign-sigadmin-currentlyopen' => 'Im Momänt isch s nit megli, des Dokumänt z signiere.',
	'sign-sigadmin-close' => 'Signiere deaktiviere',
	'sign-sigadmin-currentlyclosed' => 'S isch im Momänt nit megli, des Dokumänt z signiere.',
	'sign-sigadmin-open' => 'Signiere megli mache',
	'sign-signatures' => 'Signature',
	'sign-sigadmin-closesuccess' => 'Signiere erfolgryych deaktiviert.',
	'sign-sigadmin-opensuccess' => 'Signiere erfolgryych aktiviert.',
	'sign-viewsignatures' => 'Signature bschaue',
	'sign-closed' => 'zue',
	'sign-error-closed' => 'S isch im Momänt nit megli, des Dokumänt z signiere.',
	'sig-anonymous' => "''Anonym''",
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Signaturdetail',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|Diskussion]] • <!--
-->[[Special:Contributions/$1|Byyträg]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|Benutzer sperre]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} Sperr-Logbuech] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} Checkuser])<!--
--></span>',
	'sign-viewfield-stricken' => 'Gstriche',
	'sign-viewfield-reviewedby' => 'Priefer',
	'sign-viewfield-reviewcomment' => 'Kommentar',
	'sign-detail-uniquequery' => 'Ähnligi Yyträg',
	'sign-detail-uniquequery-run' => 'Aafrog laufe loo',
	'sign-detail-strike' => 'Signatur uusstryyche',
	'sign-reviewsig' => 'Signatur iberpriefe',
	'sign-review-comment' => 'Kommentar',
	'sign-submitreview' => 'Bericht abschicke',
	'sign-uniquequery-similarname' => 'Ähnlige Name',
	'sign-uniquequery-similaraddress' => 'Ähnligi Adräss',
	'sign-uniquequery-similarphone' => 'Ähnligi Telifonnummere',
	'sign-uniquequery-similaremail' => 'Ähnligi E-Mail-Adräss',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] het [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2] signiert.',
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

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'sign-viewfield-reviewcomment' => 'Bahasi',
	'sign-review-comment' => 'Bahasi',
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
	'sign-docheader' => 'אנא השתמשו בטופס שלהלן כדי לחתום על המסמך "[[$1]]", המוצג להלן.
אנא קראו את המסמך כולו בעיון, ואם ברצונכם לציין את תמיכתם בו, אנא מלאו את השדות הדרושים כדי לחתום עליו.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> פירושה שדה חובה.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> הערה: גם נתונים שלא מוצגים יהיו גלויים בפני מפעילים.</i></small>',
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
	'sign-view-selectfields' => "'''שדות להצגה:'''",
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
	'sig-anonymous' => "''אנונימי''",
	'sig-private' => "''פרטי''",
	'sign-sigdetails' => 'פרטי החתימה',
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
	'sign-docheader' => 'Prošu wužij tutón formular, zo by dokument podpisał "[[$1]]," kotryž deleka steji.
Prošu přečitaj cyły dokument, a jeli chceš jón podpěrać, wupjelń prošu trěbne pola a podpisaj jón.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> trěbne polo poznamjenja.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Kedźbu: Njenalistowane informacije budu hišće moderatoram widźomne być.</i></small>',
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
	'sign-view-selectfields' => "'''Pola, kotrež maja so zwobraznić:'''",
	'sign-viewfield-entryid' => 'ID zapiska',
	'sign-viewfield-timestamp' => 'Časowy kołk',
	'sign-viewfield-realname' => 'Mjeno',
	'sign-viewfield-address' => 'Adresa',
	'sign-viewfield-city' => 'Město',
	'sign-viewfield-state' => 'Stat',
	'sign-viewfield-country' => 'Kraj',
	'sign-viewfield-zip' => 'Póstowe wodźenske čisło',
	'sign-viewfield-ip' => 'IP-adresa',
	'sign-viewfield-agent' => 'Identifikacija wobhladowaka',
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
	'sig-anonymous' => "''Anonymny''",
	'sig-private' => "''Priwatny''",
	'sign-sigdetails' => 'Podrobnosće podpisanja',
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
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'signdocument' => 'Dokumentum aláírása',
	'sign-nodocselected' => 'Kérlek válaszd ki a dokumentumot, ami alá szeretnél írni.',
	'sign-selectdoc' => 'Dokumentum:',
	'sign-docheader' => 'Ezen űrlap segítségével aláírhatod az alább láthatő „[[$1]]” dokumentumot.
Olvasd át az egészet, és ha jelezni szeretnéd a támogatásod, töltsd ki a szükséges mezőket az aláíráshoz.',
	'sign-error-nosuchdoc' => 'Az általad keresett dokumentum ($1) nem létezik.',
	'sign-realname' => 'Név:',
	'sign-address' => 'Utca:',
	'sign-city' => 'Város:',
	'sign-state' => 'Megye:',
	'sign-zip' => 'Irányítószám:',
	'sign-country' => 'Ország:',
	'sign-phone' => 'Telefonszám:',
	'sign-bday' => 'Életkor:',
	'sign-email' => 'E-mail cím:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> kötelező mező.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Megjegyzés: a nem listázott információk továbbra is láthatóak lesznek a moderátorok számára.</i></small>',
	'sign-list-anonymous' => 'Megjelenítés névtelenül',
	'sign-list-hideaddress' => 'Ne jelenítsd meg a címet',
	'sign-list-hideextaddress' => 'Ne jelenítsd meg a várost, megyét, irányítószámot vagy országot',
	'sign-list-hidephone' => 'Ne jelenítsd meg a telefonszámot',
	'sign-list-hidebday' => 'Ne jelenítsd meg a kort',
	'sign-list-hideemail' => 'Ne jelenítsd meg az e-mail címet',
	'sign-submit' => 'Dokumentum aláírása',
	'sign-information' => '<div class="noarticletext">Köszönjük, hogy rászántad az idődet, és végigolvastad a dokumentumot.
Ha egyetértesz vele, jelezd támogatásod: töltsd ki az alábbi mezőket, majd kattints a „Dokumentum aláírása” gombra.
Győződj meg arról, hogy az általad megadott személyes információk helyesek, hogy így meg tudjuk erősíteni valamilyen formában a személyazonosságodat.
Az űrlap rögzíti az IP-címedet, valamint néhány más, azonosító információt, azért, hogy a moderátorok kiszűrhessék a dupla aláírásokat, és megerősíthessék a személyes információid helyességét.
Mivel a nyílt proxyk használata meggátol minket ebben, az innen érkező szavazatok valószínűleg nem lesznek számításba véve.
Ha jelenleg egy proxyszerveren keresztül csatlakozol, kapcsolódj le róla, és használj sima kapcsolatot az aláírás közben.</div>

$1',
	'sig-success' => 'Sikeresen aláírtad a dokumentumot.',
	'sign-view-selectfields' => "'''Megjelenített mezők:'''",
	'sign-viewfield-entryid' => 'Bejegyzés azonosítója',
	'sign-viewfield-timestamp' => 'Időbélyeg',
	'sign-viewfield-realname' => 'Név',
	'sign-viewfield-address' => 'Cím',
	'sign-viewfield-city' => 'Város',
	'sign-viewfield-state' => 'Megye',
	'sign-viewfield-country' => 'Ország',
	'sign-viewfield-zip' => 'Irányítószám',
	'sign-viewfield-ip' => 'IP-cím',
	'sign-viewfield-agent' => 'User agent',
	'sign-viewfield-phone' => 'Telefonszám',
	'sign-viewfield-email' => 'E-mail cím',
	'sign-viewfield-age' => 'Kor',
	'sign-viewfield-options' => 'Beállítások',
	'sign-viewsigs-intro' => 'Alább láthatóak a(z) <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span> dokumentumhoz rögzített aláírások.',
	'sign-sigadmin-currentlyopen' => 'A dokumentum aláírása engedélyezett.',
	'sign-sigadmin-close' => 'Aláírás letiltása',
	'sign-sigadmin-currentlyclosed' => 'A dokumentum aláírása jelenleg nem engedélyezett.',
	'sign-sigadmin-open' => 'Aláírás engedélyezése',
	'sign-signatures' => 'Aláírások',
	'sign-sigadmin-closesuccess' => 'Az aláírás sikeresen letiltva.',
	'sign-sigadmin-opensuccess' => 'Az aláírás sikeresen engedélyezve.',
	'sign-viewsignatures' => 'aláírások megtekintése',
	'sign-closed' => 'lezárva',
	'sign-error-closed' => 'A dokumentum aláírása jelenleg nem lehetséges.',
	'sig-anonymous' => "''Névtelen''",
	'sig-private' => "''Privát''",
	'sign-sigdetails' => 'Aláírás részletei',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|vita]] • <!--
-->[[Special:Contributions/$1|szerkesztések]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBL-ek] • <!--
-->[[Special:BlockIP/$1|blokkolás]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} blokkolási napló] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} IP-ellenőrzés])<!--
--></span>',
	'sign-viewfield-stricken' => 'Érvénytelenítés',
	'sign-viewfield-reviewedby' => 'Ellenőrző',
	'sign-viewfield-reviewcomment' => 'Megjegyzés',
	'sign-detail-uniquequery' => 'Hasonló entitások',
	'sign-detail-uniquequery-run' => 'Lekérdezés futtatása',
	'sign-detail-strike' => 'Aláírás érvénytelenítése',
	'sign-reviewsig' => 'Aláírás értékelése',
	'sign-review-comment' => 'Megjegyzés',
	'sign-submitreview' => 'Értékelés elküldése',
	'sign-uniquequery-similarname' => 'Hasonló név',
	'sign-uniquequery-similaraddress' => 'Hasonló cím',
	'sign-uniquequery-similarphone' => 'Hasonló telefonszám',
	'sign-uniquequery-similaremail' => 'Hasonló e-mail cím',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] aláírta a következő dokumentumot: [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
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
	'sign-docheader' => 'Usa iste formulario pro signar le documento "[[$1]]," monstrate infra.
Per favor lege le documento integre, e si tu vole indicar tu appoio de illo, completa le campos requisite pro signar lo.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indica un campo obligatori.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Nota: Le informationes non listate essera totevia disponibile al moderatores.</i></small>',
	'sign-list-anonymous' => 'Listar anonymemente',
	'sign-list-hideaddress' => 'Non listar adresse',
	'sign-list-hideextaddress' => 'Non listar citate, stato/provincia, codice postal o pais',
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
	'sign-view-selectfields' => "'''Campos a monstrar:'''",
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
	'sig-anonymous' => "''Anonyme''",
	'sig-private' => "''Private''",
	'sign-sigdetails' => 'Detalios del signatura',
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
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'signdocument' => 'Tandatangani dokumen',
	'sign-nodocselected' => 'Silakan pilih dokumen yang ingin Anda tanda tangani.',
	'sign-selectdoc' => 'Dokumen:',
	'sign-docheader' => 'Silakan gunakan formulir ini untuk menandatangani dokumen "[[$1]]," yang ditampilkan berikut.
Baca keseluruhan dokumen, dan jika Anda ingin menunjukkan dukungan Anda terhadapnya, isi isian yang diminta untuk menandatanganinya',
	'sign-error-nosuchdoc' => 'Dokumen yang Anda minta ($1) tidak ada.',
	'sign-realname' => 'Nama:',
	'sign-address' => 'Alamat rumah:',
	'sign-city' => 'Kota:',
	'sign-state' => 'Keadaan:',
	'sign-zip' => 'Kode pos:',
	'sign-country' => 'Negara:',
	'sign-phone' => 'Nomor telepon:',
	'sign-bday' => 'Usia:',
	'sign-email' => 'Alamat surel:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> menunjukkan isian yang dibutuhkan.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Catatan: Informasi yang tidak didaftarkan masih dapat dilihat oleh moderator.</i></small>',
	'sign-list-anonymous' => 'Daftarkan secara anonim',
	'sign-list-hideaddress' => 'Jangan tampilkan alamat',
	'sign-list-hideextaddress' => 'Jangan tampilkan kota, provinsi, kode pos, atau negara',
	'sign-list-hidephone' => 'Jangan tampilkan telepon',
	'sign-list-hidebday' => 'Jangan tampilkan usia',
	'sign-list-hideemail' => 'Jangan tampilkan surel',
	'sign-submit' => 'Tandatangani dokumen',
	'sign-information' => '<div class="noarticletext">Terima kasih telah meluangkan waktu untuk membaca keseluruhan dokumen ini.
Jika Anda setuju dengan isinya, silakan tunjukkan dukungan Anda dengan mengisi kolom yang harus diisi di bawah ini dan mengklik "Tanda tangani dokumen".
Harap pastikan bahwa informasi pribadi Anda sudah benar dan bahwa kami memiliki suatu cara untuk menghubungi Anda untuk memverifikasikan identitas Anda.
Catat bahwa alamat IP Anda dan informasi identifikasi lain akan dicatat oleh isian ini dan digunakan oleh moderator untuk menghilangkan duplikat tanda tangan dan mengkonfirmasi kebenaran informasi pribadi Anda.
Karena penggunaan proksi terbuka dan anonim menghambat kemampuan kami untuk melakukan tugas ini, tanda tangan dari proksi semacam itu cenderung tidak akan diperhitungkan.
Jika Anda sedang tersambung melalui server proksi, silakan putuskan koneksi tersebut gunakan koneksi standar sewaktu menandatangani.</div>

$1',
	'sig-success' => 'Anda berhasil menandatangani dokumen.',
	'sign-view-selectfields' => "'''Isian yang akan ditampilkan:'''",
	'sign-viewfield-entryid' => 'ID Masukan',
	'sign-viewfield-timestamp' => 'Stempel waktu',
	'sign-viewfield-realname' => 'Nama',
	'sign-viewfield-address' => 'Alamat',
	'sign-viewfield-city' => 'Kota',
	'sign-viewfield-state' => 'Keadaan',
	'sign-viewfield-country' => 'Negara',
	'sign-viewfield-zip' => 'Kode pos',
	'sign-viewfield-ip' => 'Alamat IP',
	'sign-viewfield-agent' => 'Aplikasi pengguna',
	'sign-viewfield-phone' => 'Telepon',
	'sign-viewfield-email' => 'Surel',
	'sign-viewfield-age' => 'Usia',
	'sign-viewfield-options' => 'Pilihan',
	'sign-viewsigs-intro' => 'Di bawah ini ditunjukkan tanda tangan yang dicatat untuk <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Penandatanganan saat ini diaktifkan untuk dokumen ini.',
	'sign-sigadmin-close' => 'Nonaktifkan penandatanganan',
	'sign-sigadmin-currentlyclosed' => 'Penandatanganan saat ini dinonaktifkan untuk dokumen ini.',
	'sign-sigadmin-open' => 'Aktifkan penandatanganan',
	'sign-signatures' => 'Tanda tangan',
	'sign-sigadmin-closesuccess' => 'Penandatanganan berhasil dinonaktifkan.',
	'sign-sigadmin-opensuccess' => 'Penandatanganan berhasil diaktifkan.',
	'sign-viewsignatures' => 'lihat tanda tangan',
	'sign-closed' => 'ditutup',
	'sign-error-closed' => 'Penandatanganan dokumen ini sedang dimatikan.',
	'sig-anonymous' => "''Anonim''",
	'sig-private' => "''Pribadi''",
	'sign-sigdetails' => 'Detail tanda tangan',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|bicara]] • <!--
-->[[Special:Contributions/$1|kontribusi]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|blokir]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} log pemblokiran] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} cek ip])<!--
--></span>',
	'sign-viewfield-stricken' => 'Coret',
	'sign-viewfield-reviewedby' => 'Peninjau',
	'sign-viewfield-reviewcomment' => 'Komentar',
	'sign-detail-uniquequery' => 'Entitas serupa',
	'sign-detail-uniquequery-run' => 'Jalankan query',
	'sign-detail-strike' => 'Coret tanda tangan',
	'sign-reviewsig' => 'Tinjau tanda tangan',
	'sign-review-comment' => 'Komentar',
	'sign-submitreview' => 'Kirim tinjauan',
	'sign-uniquequery-similarname' => 'Nama serupa',
	'sign-uniquequery-similaraddress' => 'Alamat serupa',
	'sign-uniquequery-similarphone' => 'Telepon serupa',
	'sign-uniquequery-similaremail' => 'Surel serupa',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] tanda tangan [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'sign-realname' => 'Áhà:',
	'sign-city' => 'Ama Ukwu:',
	'sign-phone' => 'Onuogụgụ nkpo gi:',
	'sign-bday' => 'Áfó olé:',
	'sign-viewfield-realname' => 'Áhà',
	'sign-viewfield-city' => 'Ama ukwu',
	'sign-viewfield-age' => 'Áfọ olé',
	'sign-closed' => 'mmechịrị',
	'sign-viewfield-stricken' => 'Kùrù',
	'sign-detail-uniquequery-run' => 'Gbá ncho',
	'sign-review-comment' => 'Okwu-nokwu',
	'sign-uniquequery-similarname' => 'Áhá yituru nká',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'sign-viewfield-ip' => 'IP-adreso',
);

/** Icelandic (Íslenska) */
$messages['is'] = array(
	'sign-realname' => 'Nafn:',
	'sign-city' => 'Staður:',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 */
$messages['it'] = array(
	'sign-realname' => 'Nome:',
	'sign-address' => 'Via:',
	'sign-zip' => 'Codice postale:',
	'sign-country' => 'Nazione:',
	'sign-bday' => 'Età:',
	'sign-email' => 'Indirizzo e-mail:',
	'sign-viewfield-realname' => 'Nome',
	'sign-viewfield-country' => 'Nazione',
	'sign-viewfield-zip' => 'Codice postale',
	'sign-viewfield-ip' => 'Indirizzo IP',
	'sign-viewfield-email' => 'Indirizzo e-mail',
	'sign-viewfield-age' => 'Età',
	'sign-viewfield-options' => 'Opzioni',
	'sign-closed' => 'chiusa',
	'sign-viewfield-reviewcomment' => 'Commento',
	'sign-review-comment' => 'Commento',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'signdocument' => '文書署名',
	'sign-nodocselected' => '署名したい文書を選んでください。',
	'sign-selectdoc' => '文書:',
	'sign-docheader' => '以下の文書「[[$1]]」に署名するにはこのフォームを使います。文書全体を熟読し、その文書に支持を表明すると決めた場合、必須欄を埋めて署名してください。',
	'sign-error-nosuchdoc' => 'あなたが要求した文書 ($1) は存在しません。',
	'sign-realname' => '名前:',
	'sign-address' => '番地:',
	'sign-city' => '市町村:',
	'sign-state' => '都道府県・州:',
	'sign-zip' => '郵便番号:',
	'sign-country' => '国:',
	'sign-phone' => '電話番号:',
	'sign-bday' => '年齢:',
	'sign-email' => '電子メールアドレス:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> は必須欄を示す。</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> 注: 未掲載の情報も判定者には閲覧が可能です。</i></small>',
	'sign-list-anonymous' => '匿名として掲載',
	'sign-list-hideaddress' => '住所を非掲載',
	'sign-list-hideextaddress' => '国、郵便番号、都道府県、市町村を非掲載',
	'sign-list-hidephone' => '電話番号を非掲載',
	'sign-list-hidebday' => '年齢を非掲載',
	'sign-list-hideemail' => 'メールアドレスを非掲載',
	'sign-submit' => '文書に署名',
	'sign-information' => '<div class="noarticletext">この文書を読み通すことにお時間を割いていただき、ありがとうございます。同意されるのならば、以下の必須欄を埋めて「{{int:Sign-submit}}」をクリックし、支持を表明してください。あなたの個人情報が正確で、我々が身元を検証するために何らかのあなたへの連絡手段があることを確認してください。IPアドレスなどのあなたの識別情報はこのフォームによって記録され、判定者が重複する署名を削除しあなたの個人情報の正確性を確認するために利用されます。公開および匿名プロキシの使用は我々がこの作業を実行する妨げとなるため、その種のプロキシからの署名は無視されるでしょう。あなたが今、プロキシサーバー経由で接続しているのならば、接続を切断し、署名中は標準的な接続環境を使用してください。</div>

$1',
	'sig-success' => '文書の署名に成功しました。',
	'sign-view-selectfields' => "'''表示する欄:'''",
	'sign-viewfield-entryid' => 'ID',
	'sign-viewfield-timestamp' => '時刻',
	'sign-viewfield-realname' => '名前',
	'sign-viewfield-address' => '住所',
	'sign-viewfield-city' => '市町村',
	'sign-viewfield-state' => '都道府県・州',
	'sign-viewfield-country' => '国',
	'sign-viewfield-zip' => '郵便番号',
	'sign-viewfield-ip' => 'IPアドレス',
	'sign-viewfield-agent' => 'ユーザーエージェント',
	'sign-viewfield-phone' => '電話',
	'sign-viewfield-email' => '電子メール',
	'sign-viewfield-age' => '年齢',
	'sign-viewfield-options' => 'オプション',
	'sign-viewsigs-intro' => '以下は <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span> に記録された署名です。',
	'sign-sigadmin-currentlyopen' => '現在、この文書への署名は有効になっています。',
	'sign-sigadmin-close' => '署名を無効化する',
	'sign-sigadmin-currentlyclosed' => '現在、この文書への署名は無効になっています。',
	'sign-sigadmin-open' => '署名を有効化する',
	'sign-signatures' => '署名',
	'sign-sigadmin-closesuccess' => '署名の無効化に成功しました。',
	'sign-sigadmin-opensuccess' => '署名の有効化に成功しました。',
	'sign-viewsignatures' => '署名を閲覧',
	'sign-closed' => '閉鎖完了',
	'sign-error-closed' => 'この文書への署名は現在、無効になっています。',
	'sig-anonymous' => "''匿名''",
	'sig-private' => "''非公開''",
	'sign-sigdetails' => '署名詳細',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|トーク]] • <!--
-->[[Special:Contributions/$1|投稿記録]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|ブロック]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} ブロック記録] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} IPチェック])<!--
--></span>',
	'sign-viewfield-stricken' => '削除済',
	'sign-viewfield-reviewedby' => '確認者',
	'sign-viewfield-reviewcomment' => 'コメント',
	'sign-detail-uniquequery' => '類似項目',
	'sign-detail-uniquequery-run' => '問い合わせ実行',
	'sign-detail-strike' => '署名を削除',
	'sign-reviewsig' => '署名を見直し',
	'sign-review-comment' => 'コメント',
	'sign-submitreview' => '見直し提出',
	'sign-uniquequery-similarname' => '名前の類似',
	'sign-uniquequery-similaraddress' => '住所の類似',
	'sign-uniquequery-similarphone' => '電話番号の類似',
	'sign-uniquequery-similaremail' => 'メールアドレスの類似',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] が [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2] に署名しました。',
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
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Cathetan: Informasi sing ora olèh dituduhaké tetep isih bisa dideleng para pangurus.</i></small>',
	'sign-list-anonymous' => 'Mèlu sacara anonim',
	'sign-list-hideaddress' => 'Aja nuduhaké dalan',
	'sign-list-hideextaddress' => 'Aja nuduhaké kutha, negara bagéyan, kode pos, utawa negara',
	'sign-list-hidephone' => 'Aja nuduhaké tilpun',
	'sign-list-hidebday' => 'Aja nuduhaké umur',
	'sign-list-hideemail' => 'Aja nuduhaké e-mail',
	'sign-submit' => 'Napak astani dokumèn',
	'sig-success' => 'Panjenengan bisa sacara suksès napak tangani dokumèn.',
	'sign-view-selectfields' => "'''Lapangan-lapangan sing dituduhaké:'''",
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
	'sig-anonymous' => "''Anonim''",
	'sig-private' => "''Pribadi''",
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
	'sign-view-selectfields' => "'''វាល​ត្រូវ​បង្ហាញ:'''",
	'sign-viewfield-entryid' => 'អត្តលេខ​ធាតុបញ្ចូល',
	'sign-viewfield-timestamp' => 'ត្រាពេលវេលា',
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
	'sig-anonymous' => "''អនាមិក''",
	'sig-private' => "''ឯកជន''",
	'sign-sigdetails' => 'ហត្ថលេខា​លំអិត',
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

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'sign-realname' => 'ಹೆಸರು:',
	'sign-city' => 'ನಗರ:',
	'sign-state' => 'ರಾಜ್ಯ:',
	'sign-country' => 'ದೇಶ:',
	'sign-bday' => 'ವಯಸ್ಸು:',
	'sign-viewfield-realname' => 'ಹೆಸರು',
	'sign-viewfield-address' => 'ವಿಳಾಸ',
	'sign-viewfield-city' => 'ನಗರ',
	'sign-viewfield-state' => 'ರಾಜ್ಯ',
	'sign-viewfield-country' => 'ದೇಶ',
	'sign-viewfield-email' => 'ಇ-ಅಂಚೆ',
	'sign-viewfield-age' => 'ವಯಸ್ಸು',
	'sign-signatures' => 'ಸಹಿಗಳು',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'signdocument' => '문서 서명',
	'sign-nodocselected' => '서명할 문서를 선택해주세요.',
	'sign-selectdoc' => '문서:',
	'sign-docheader' => '"[[$1]]" 문서에 서명하려면 아래 양식을 이용해주세요.
문서 전체를 읽고 당신이 이 문서의 내용을 지지한다면 서명하면서 필수 사항을 채워주세요.',
	'sign-error-nosuchdoc' => '당신이 요청한 문서($1)가 존재하지 않습니다.',
	'sign-realname' => '실명:',
	'sign-iptools' => 'span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|토론]] • <!--
-->[[Special:Contributions/$1|기여]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|차단]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} 차단 기록] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} IP 확인])<!--
--></span>',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'sign-viewfield-email' => 'E-mail',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'signdocument' => 'Dokkemänt ongerschriive',
	'sign-nodocselected' => 'Donn da Dokkemänt ußsöke, wat De ungerschriive wells.',
	'sign-selectdoc' => 'Dokkemänt:',
	'sign-docheader' => 'Donn dat Formulaa bruche, öm dat Dokkemänt „[[$1]]“ ze ongerschriive, wat hee dronger aanjezeisch es.
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> dat Feld es nüdesch.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Opjepaß: Wat nit opjeliß es, dat künne de Moderatore trozdämm aankike.</i></small>',
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
Opjepaß: Ding aktoälle IP-Addräß un ander ähnlijje Date wäde zosamme met dä Date us dämm Fommulaa faßjehallde. Se wäde vun de Moderatore jebruch, öm dubbel dijjitaale Ongerschreffte eruß ze sammelle, un de Rechtechkeit vun Ding päsönlejje Date eruß ze krijje.
Weil de Moderatore fö_jewööhnlesch esu en Pröfunge för Fobendunge övver offe, un namelos maachende <i lang="en">proxy server</i> täschnesch koum udder jaa nit maache künne, es et müjjelech, un beinah secher, dat Ungerschreffte övver esu en <i lang="en">proxies</i> nit jezallt weede.
Wann de jrad övver ene <i lang="en">proxy</i> am Netz am hange bes, dann bes esu joot, donn Dich för ene Momang vun em trenne, un nemm en nommaale Verbendung för et Ongerschriive.</div>

$1',
	'sig-success' => 'De häs dat Dokkemänt jäz eläktroonesch ungerschrevve.',
	'sign-view-selectfields' => "'''De Felder för Aanzezeije:'''",
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
	'sig-anonymous' => "''Nameloss''",
	'sig-private' => "''Prevaat''",
	'sign-sigdetails' => 'Einzelheite fun dä Ongerschreff',
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

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'sign-realname' => 'Nav:',
	'sign-city' => 'Bajarr',
	'sign-country' => 'Welat:',
	'sign-viewfield-realname' => 'Nav',
	'sign-viewfield-country' => 'Welat',
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
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'signdocument' => 'Dokument ënnerschreiwen',
	'sign-nodocselected' => 'Wielt w.e.g dat Dokument aus dat Dir ënenrschreiwe wëllt.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => "Benotzt w.e.g. dëse Formulaire, fir d'Dokument „[[$1]]“, dat hei ënnendrënner gewisen ass, z'ënnerschreiwen.
Liest dat ganzt Dokument duerch a wann Dir dozou Är Ënnerstëtzung gi wëllt da fëllt déi néideg Felder aus fir et z'ënnerschreiwen.",
	'sign-error-nosuchdoc' => 'Dat Dokument, dat Dir ugefrot hutt ($1), gëtt et net.',
	'sign-realname' => 'Numm:',
	'sign-address' => 'Adress Strooss:',
	'sign-city' => 'Stad/Gemeng:',
	'sign-state' => 'Staat:',
	'sign-zip' => 'Postleitzuel:',
	'sign-country' => 'Land:',
	'sign-phone' => 'Telefonsnummer:',
	'sign-bday' => 'Alter:',
	'sign-email' => 'E-Mail-Adress:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> weist obligatorescht Feld.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Opgepasst: Och déi net ugewisen Informatioune bleiwen fir d\'Moderateuren sichtbar.</i></small>',
	'sign-list-anonymous' => 'Als anonym weisen',
	'sign-list-hideaddress' => 'Adress net weisen',
	'sign-list-hideextaddress' => 'Stad, Stat, Postcode oder Land net weisen',
	'sign-list-hidephone' => "D'Telefeonsnummer net weisen",
	'sign-list-hidebday' => 'Den Alter net weisen',
	'sign-list-hideemail' => "D'E-Mailadress net weisen",
	'sign-submit' => 'Dokument ënnerschreiwen',
	'sig-success' => "Dir hutt d'Dokument ënnerschriwwen",
	'sign-view-selectfields' => "'''Felder déi gewise solle ginn:'''",
	'sign-viewfield-timestamp' => 'Datum an Auerzäit',
	'sign-viewfield-realname' => 'Numm',
	'sign-viewfield-address' => 'Adress',
	'sign-viewfield-city' => 'Stad/Gemeng',
	'sign-viewfield-state' => 'Staat (Departement oder Provënz)',
	'sign-viewfield-country' => 'Land',
	'sign-viewfield-zip' => 'Postcode',
	'sign-viewfield-ip' => 'IP-Adress',
	'sign-viewfield-agent' => 'Browser',
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
	'sign-error-closed' => "Et ass den Ament net méiglech dëst Dokument z'ënnerschreiwen.",
	'sig-anonymous' => "''Anonym''",
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Detailer vun der Ënnerschrëft',
	'sign-viewfield-stricken' => 'Duerchgestrach',
	'sign-viewfield-reviewedby' => 'Reviseur',
	'sign-viewfield-reviewcomment' => 'Bemierkung',
	'sign-detail-uniquequery' => 'Ähnlecht Eenheeten',
	'sign-detail-uniquequery-run' => 'Ufro ausféieren',
	'sign-detail-strike' => 'Ënnerschreft duerchsträichen',
	'sign-reviewsig' => 'Ënnerschrëft nokucken',
	'sign-review-comment' => 'Bemierkung',
	'sign-submitreview' => 'Bewäertung fortschécken',
	'sign-uniquequery-similarname' => 'Ähnlechen Numm',
	'sign-uniquequery-similaraddress' => 'Ähnlech Adress',
	'sign-uniquequery-similarphone' => 'Ähnlech Telefonsnummer',
	'sign-uniquequery-similaremail' => 'Ähnlech E-Mailadress',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] ënnerschriwwen [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Lithuanian (Lietuvių)
 * @author Tomasdd
 */
$messages['lt'] = array(
	'sign-realname' => 'Vardas:',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'sign-realname' => 'Vārds:',
	'sign-address' => 'Ielas adrese:',
	'sign-city' => 'Pilsēta:',
	'sign-state' => 'Štats:',
	'sign-zip' => 'Pasta indekss:',
	'sign-country' => 'Valsts:',
	'sign-phone' => 'Tālruņa numurs:',
	'sign-bday' => 'Vecums:',
	'sign-email' => 'E-pasta adrese:',
	'sign-viewfield-realname' => 'Vārds',
	'sign-viewfield-address' => 'Adrese',
	'sign-viewfield-city' => 'Pilsēta',
	'sign-viewfield-state' => 'Štats',
	'sign-viewfield-country' => 'Valsts',
	'sign-viewfield-zip' => 'Pasta indekss',
	'sign-viewfield-ip' => 'IP adrese',
	'sign-viewfield-agent' => 'Lietotāja aģents',
	'sign-viewfield-phone' => 'Tālrunis',
	'sign-viewfield-email' => 'E-pasts',
	'sign-viewfield-age' => 'Vecums',
	'sign-viewfield-options' => 'Iespējas',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'sign-viewfield-email' => 'Электрон почто',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'signdocument' => 'Потпиши документ',
	'sign-nodocselected' => 'Одберете го документот што сакате да го потпишете.',
	'sign-selectdoc' => 'Документ:',
	'sign-docheader' => 'Употребете го овој образец за да го потпишете документот „[[$1]]“, прикажан подолу.
Испрочитајте го целиот документ, и ако сакате да му изразите поддршка, пополнете ги бараните полиња за да го потпишете.',
	'sign-error-nosuchdoc' => 'Документот кој го побаравте ($1) не постои.',
	'sign-realname' => 'Име:',
	'sign-address' => 'Адреса:',
	'sign-city' => 'Град:',
	'sign-state' => 'Сојуз. држава',
	'sign-zip' => 'Поштенски број:',
	'sign-country' => 'Земја:',
	'sign-phone' => 'Телефон:',
	'sign-bday' => 'Возраст:',
	'sign-email' => 'Е-пошта:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> задолжително поле.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Напомена: Информациите кои нема да се прикажат сепак ќе бидат видливи за модераторите.</i></small>',
	'sign-list-anonymous' => 'Анонимно',
	'sign-list-hideaddress' => 'Не прикажувај адреса',
	'sign-list-hideextaddress' => 'Не прикажувај град, сојузна држава, поштенски број и земја',
	'sign-list-hidephone' => 'Не прикажувај телефон',
	'sign-list-hidebday' => 'Не прикажувај возраст',
	'sign-list-hideemail' => 'Не прикажувај е-пошта',
	'sign-submit' => 'Потпиши',
	'sign-information' => '<div class="noarticletext">Ви благодариме што посветивте време за да го прочитате овој документ.
Доколку се согласувате со него, изразете ја вашата поддршка со пополнување на бараните полиња подолу и кликнување на „Потпиши“.
Проверете дали вашите лични податоци се точни и дека имаме некаков начин да ве исконтактираме за да го провериме вашиот идентитет.
Имајте на ум дека вашата IP-адреса и другите идентификациони информации ќе се запишат со овој образец и ќе им послужат на модераторите за елиминирање на дуплирани потписи и за потврдување на исправноста на вашите лични податоци.
Бидејќи употребата на отворени и анонимизирачки застапници (proxy) ни попречува во извршувањето на оваа задача, најверојатно е дека потписите од такви застапници нема да се сметаат.
Ако моментално сте поврзани преку застапнички опслужувач , исклучете се и користете обично поврзување додека се потпишувате.</div>

$1',
	'sig-success' => 'Успешно го потпишавте документот.',
	'sign-view-selectfields' => "'''Полиња за прикажување:'''",
	'sign-viewfield-entryid' => 'ID на записот',
	'sign-viewfield-timestamp' => 'Време и датум',
	'sign-viewfield-realname' => 'Име',
	'sign-viewfield-address' => 'Адреса',
	'sign-viewfield-city' => 'Град',
	'sign-viewfield-state' => 'Сојуз. држава',
	'sign-viewfield-country' => 'Земја',
	'sign-viewfield-zip' => 'Поштенски број',
	'sign-viewfield-ip' => 'IP-адреса',
	'sign-viewfield-agent' => 'Прелистувач',
	'sign-viewfield-phone' => 'Телефон',
	'sign-viewfield-email' => 'Е-пошта',
	'sign-viewfield-age' => 'Возраст',
	'sign-viewfield-options' => 'Нагодувања',
	'sign-viewsigs-intro' => 'Подолу се прикажани потписи собрани за <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Потпишувањето на овој документ е моментално овозможено.',
	'sign-sigadmin-close' => 'Оневозможи потпишување',
	'sign-sigadmin-currentlyclosed' => 'Потпишувањето на овој документ е моментално оневозможено.',
	'sign-sigadmin-open' => 'Овозможи потпишување',
	'sign-signatures' => 'Потписи',
	'sign-sigadmin-closesuccess' => 'Потпишувањето е успешно оневозможено.',
	'sign-sigadmin-opensuccess' => 'Потпишувањето е успешно овозможено.',
	'sign-viewsignatures' => 'види потписи',
	'sign-closed' => 'затворено',
	'sign-error-closed' => 'Потпишувањето на овој документ е моментално оневозможено.',
	'sig-anonymous' => "''Анонимен''",
	'sig-private' => "''Приватен''",
	'sign-sigdetails' => 'Подробности за потписот',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|разговор]] • <!--
-->[[Special:Contributions/$1|придонеси]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBL-ови] • <!--
-->[[Special:BlockIP/$1|блокирај]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} дневник на блокирања] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} провери])<!--
--></span>',
	'sign-viewfield-stricken' => 'Прецртано',
	'sign-viewfield-reviewedby' => 'Проверувач',
	'sign-viewfield-reviewcomment' => 'Коментар',
	'sign-detail-uniquequery' => 'Слични записи',
	'sign-detail-uniquequery-run' => 'Исполни барање',
	'sign-detail-strike' => 'Прецртај потпис',
	'sign-reviewsig' => 'Провери потпис',
	'sign-review-comment' => 'Коментар',
	'sign-submitreview' => 'Поднеси проверка',
	'sign-uniquequery-similarname' => 'Слично име',
	'sign-uniquequery-similaraddress' => 'Слична адреса',
	'sign-uniquequery-similarphone' => 'Сличен телефон',
	'sign-uniquequery-similaremail' => 'Слична е-пошта',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] се потпиша на [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'signdocument' => 'പ്രമാണത്തിൽ ഒപ്പിടുക',
	'sign-nodocselected' => 'താങ്കൾ ഒപ്പിടുവാൻ ആഗ്രഹിക്കുന്ന പ്രമാണം തിരഞ്ഞെടുക്കുക',
	'sign-selectdoc' => 'പ്രമാണം:',
	'sign-error-nosuchdoc' => 'താങ്കൾ ആവശ്യപ്പെട്ട പ്രമാണം ($1) നിലവിലില്ല.',
	'sign-realname' => 'പേര്‌:',
	'sign-address' => 'വിലാസം:',
	'sign-city' => 'പട്ടണം:',
	'sign-state' => 'സംസ്ഥാനം:',
	'sign-zip' => 'സിപ്പ് കോഡ്:',
	'sign-country' => 'രാജ്യം:',
	'sign-phone' => 'ഫോൺ നമ്പർ:',
	'sign-bday' => 'വയസ്സ്',
	'sign-email' => 'ഇമെയിൽ വിലാസം:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> നിർബന്ധമായും ചേർക്കേണ്ട ഫീൽഡിനെ സൂചിപ്പിക്കുന്നു.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> കുറിപ്പ്: പട്ടികയിൽ ചേർത്തിട്ടില്ലാത്ത വിവരങ്ങൾ മോഡരേറ്ററുമാർക്ക് ഇപ്പോഴും ദൃശ്യമാകും.</i></small>',
	'sign-list-hideaddress' => 'വിലാസം പ്രദർശിപ്പിക്കരുത്',
	'sign-list-hideextaddress' => 'നഗരം, സംസ്ഥാനം, സിപ്പ് കോഡ്, രാജ്യം എന്നിവ പ്രദർശിപ്പിക്കരുത്',
	'sign-list-hidephone' => 'ഫോൺ നമ്പർ പ്രദർശിപ്പിക്കരുത്',
	'sign-list-hidebday' => 'വയസ്സ് പ്രദർശിപ്പിക്കരുത്',
	'sign-list-hideemail' => 'ഇമെയിൽ വിലാസം പ്രദർശിപ്പിക്കരുത്',
	'sign-submit' => 'പ്രമാണത്തിൽ ഒപ്പിടുക',
	'sig-success' => 'താങ്കൾ പ്രമാണത്തിൽ വിജയകരമായി ഒപ്പിട്ടിരിക്കുന്നു.',
	'sign-view-selectfields' => "'''പ്രദർശിപ്പിക്കേണ്ട ഫീൽഡുകൾ:'''",
	'sign-viewfield-timestamp' => 'സമയമുദ്ര',
	'sign-viewfield-realname' => 'പേര്‌',
	'sign-viewfield-address' => 'വിലാസം',
	'sign-viewfield-city' => 'പട്ടണം',
	'sign-viewfield-state' => 'സംസ്ഥാനം',
	'sign-viewfield-country' => 'രാജ്യം',
	'sign-viewfield-zip' => 'സിപ്പ്',
	'sign-viewfield-ip' => 'ഐ.പി. വിലാസം',
	'sign-viewfield-phone' => 'ഫോൺ',
	'sign-viewfield-email' => 'ഇമെയിൽ',
	'sign-viewfield-age' => 'വയസ്സ്',
	'sign-viewfield-options' => 'ഐച്ഛികങ്ങൾ',
	'sign-sigadmin-close' => 'ഒപ്പിടൽ നിരോധിക്കുക',
	'sign-sigadmin-currentlyclosed' => 'ഈ പ്രമാണത്തിൽ നിലവിൽ ഒപ്പിടൽ നിരോധിച്ചിരിക്കുന്നു.',
	'sign-sigadmin-open' => 'ഒപ്പിടൽ അനുവദിക്കുക',
	'sign-signatures' => 'ഒപ്പുകൾ',
	'sign-sigadmin-closesuccess' => 'ഒപ്പിടൽ വിജയകരമായി നിരോധിച്ചിരിക്കുന്നു.',
	'sign-sigadmin-opensuccess' => 'ഒപ്പിടൽ വിജയകരമായി അനുവദിച്ചിരിക്കുന്നു.',
	'sign-viewsignatures' => 'ഒപ്പുകൾ കാണുക',
	'sign-closed' => 'അടച്ചു',
	'sign-error-closed' => 'ഈ പ്രമാണത്തിൽ ഒപ്പിടൽ നിലവിൽ നിരോധിച്ചിരിക്കുന്നു.',
	'sig-anonymous' => "''അജ്ഞാതം''",
	'sig-private' => "''സ്വകാര്യം''",
	'sign-sigdetails' => 'ഒപ്പിന്റെ വിവരങ്ങൾ',
	'sign-viewfield-reviewedby' => 'സം‌ശോധകൻ',
	'sign-viewfield-reviewcomment' => 'അഭിപ്രായം',
	'sign-detail-strike' => 'ഒപ്പ് വെട്ടുക',
	'sign-reviewsig' => 'ഒപ്പ് സംശോധനം ചെയ്യുക',
	'sign-review-comment' => 'അഭിപ്രായം',
	'sign-submitreview' => 'സംശോധനം ചെയ്തത് സമർപ്പിക്കുക',
	'sign-uniquequery-similarname' => 'ഒരേപോലുള്ള പേര്‌',
	'sign-uniquequery-similaraddress' => 'ഒരേപോലുള്ള വിലാസം',
	'sign-uniquequery-similarphone' => 'ഒരേപോലുള്ള ഫോൺ',
	'sign-uniquequery-similaremail' => 'ഒരേ പോലുള്ള ഇമെയിൽ',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1],  [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2]ൽ ഒപ്പിട്ടു.',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'sign-viewfield-reviewcomment' => 'Тайлбар',
	'sign-review-comment' => 'Тайлбар',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'signdocument' => 'डक्यूमेंट वर सही करा',
	'sign-nodocselected' => 'तुम्ही सही करू इच्छित असलेले डक्यूमेंट निवडा.',
	'sign-selectdoc' => 'दस्तऐवज:',
	'sign-docheader' => 'खाली दाखविलेल्या डॉक्यूमेंट "[[$1]]" वर सही करण्यासाठी हा अर्ज वापरा.
कृपया संपूर्ण डॉक्यूमेंट वाचा, व जर तुम्ही त्यामधील मजकूराशी सहमत असाल, तर कृपया योग्य ते रकाने भरून सही करा.',
	'sign-error-nosuchdoc' => 'मागितलेले डक्यूमेंट ($1) अस्तित्वात नाही',
	'sign-realname' => 'नाव:',
	'sign-address' => 'रस्ता पत्ता:',
	'sign-city' => 'शहर:',
	'sign-state' => 'राज्य:',
	'sign-zip' => 'झिप कोड:',
	'sign-country' => 'देश:',
	'sign-phone' => 'दूरध्वनी क्रमांक:',
	'sign-bday' => 'वय:',
	'sign-email' => 'विपत्र पत्ता:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> आवश्यक रकाने दर्शवितो.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> सूचना: प्रबंधकांना यादीत नसलेली माहिती सुद्धा पाहता येईल.</i></small>',
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
	'sign-view-selectfields' => "'''हे रकाने दाखवा:'''",
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
	'sig-anonymous' => "''अनामिक''",
	'sig-private' => "''खाजगी''",
	'sign-sigdetails' => 'सही माहिती',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|चर्चा]] • <!--
-->[[Special:Contributions/$1|योगदान]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on डब्ल्युएचओआयएस] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on आरडीएनएस] • <!--
-->[http://www.robtex.com/rbls/$1.html आरबीएल] • <!--
-->[[Special:BlockIP/$1|सदस्याला प्रतिबंधित करा]] • <!--
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
 * @author Anakmalaysia
 * @author Aurora
 */
$messages['ms'] = array(
	'sign-realname' => 'Nama:',
	'sign-country' => 'Negara:',
	'sign-email' => 'Alamat e-mel:',
	'sign-viewfield-realname' => 'Nama',
	'sign-viewfield-address' => 'Alamat',
	'sign-viewfield-country' => 'Negara',
	'sign-viewfield-ip' => 'Alamat IP',
	'sign-viewfield-agent' => 'Ejen pengguna',
	'sign-viewfield-email' => 'E-mel',
	'sign-viewfield-reviewedby' => 'Pengkaji semula',
	'sign-viewfield-reviewcomment' => 'Komen',
	'sign-review-comment' => 'Komen',
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
	'sig-anonymous' => "''Лемтеме''",
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'signdocument' => 'Signer dokument',
	'sign-nodocselected' => 'Vennligst velg dokumentet du ønsker å signere.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => 'Bruk dette skjemaet for å signere dokumentet «[[$1]]» vist nedenunder.
Vennligst les gjennom hele dokumentet, og om du ønsker å vise din støtte for det, fyll inn de nødvendige feltene for å signere.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indikerer felt som må fylles ut.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Merk: Informasjon som ikke listes opp vil fortsatt kunne ses av moderatorer.</i></small>',
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
	'sign-view-selectfields' => "'''Felter som vises:'''",
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
	'sig-anonymous' => "''Anonym''",
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Signaturdetaljer',
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

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'sign-viewfield-reviewcomment' => 'टिप्पणी',
	'sign-review-comment' => 'टिप्पणी',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'signdocument' => 'Document ondertekenen',
	'sign-nodocselected' => 'Selecteer het document dat u wilt ondertekenen.',
	'sign-selectdoc' => 'Document:',
	'sign-docheader' => 'Gebruik dit formulier om het document "[[$1]]" te ondertekenen, dat hieronder wordt weergeven.
Lees het hele document en als u het wilt steunen vul dan de verplichte velden in om het te ondertekenen.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> geeft verplichte velden aan.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Nota bene: Informatie die niet wordt weergegeven, blijft zichtbaar voor beheerders.</i></small>',
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
	'sign-view-selectfields' => "'''Weer te geven velden:'''",
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
	'sig-anonymous' => "''Anoniem''",
	'sig-private' => "''Privé''",
	'sign-sigdetails' => 'Ondertekeningsdetails',
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
	'sign-docheader' => 'Nytt dette skjemaet for å signera dokumentet «[[$1]]» vist nedanfor.
Ver venleg les gjennom heile dokumentet, og om du ønskjer å syna støtta di for det, fyll inn dei nødvendige felta for å signera.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indikerer felt som må bli fylte ut.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Merk: Informasjon som ikkje blir lista opp vil framleis vera synleg for moderatorar.</i></small>',
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
	'sign-view-selectfields' => "'''Felt som skal bli viste:'''",
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
	'sig-anonymous' => "''Anonym''",
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Signaturdetaljar',
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
	'sign-docheader' => "Mercés d'utilizar aqueste formulari per autentificar lo document « [[$1]] » afichat çaijós.
Legissètz lo document al complet, e se desiratz significar vòstre sosten, emplenatz los camps per l'autentificar.",
	'sign-error-nosuchdoc' => 'Lo document demandat ($1) existís pas.',
	'sign-realname' => 'Nom :',
	'sign-address' => 'Adreça civica :',
	'sign-city' => 'Vila :',
	'sign-state' => 'Estat, departament o província :',
	'sign-zip' => 'Còde postal :',
	'sign-country' => 'País :',
	'sign-phone' => 'Numèro de telefòn :',
	'sign-bday' => 'Edat :',
	'sign-email' => 'Adreça de corrièr electronic :',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indica los camps obligatòris.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Las entresenhas pas listadas son totjorn visiblas pels moderaires.</i></small>',
	'sign-list-anonymous' => 'Listar de biais anonim',
	'sign-list-hideaddress' => "Listar pas l'adreça",
	'sign-list-hideextaddress' => "Listar pas la vila, l'estat (lo departament o la província), lo còde postal o lo país",
	'sign-list-hidephone' => 'Listar pas lo numèro de telefòn',
	'sign-list-hidebday' => "Listar pas l'edat",
	'sign-list-hideemail' => "Listar pas l'adreça de corrièr electronic",
	'sign-submit' => 'Autentificar lo document',
	'sign-information' => "<div class=\"noarticletext\">Mercés d'aver complètament legit aqueste document. Se sètz d'acòrdi amb son contengut, significatz vòstre sosten en emplenant los camps requeses çaijós e en clicant « Autentificar document ». Mercés de verificar que vòstras entresenhas personalas son exactas e qu'avèm un mejan de vos contactar per validar vòstra identitat. Vòstra adreça IP e d'autras entresenhas que vos pòdon identificar son notadas e seràn utilizadas pels moderaires per eliminar de signaturas en doblon e confirmar las entresenhas picadas. Los proxys nos permeton pas d'identificar de segur lo signatari, las signaturas obtengudas a travèrs los proxys seràn probablament pas comptadas. Se sètz connectat a travèrs un proxy, mercés d'utilizar un compte que l'utiliza pas.</div>

\$1",
	'sig-success' => 'Avètz autentificat lo document.',
	'sign-view-selectfields' => "'''Camps d'afichar :'''",
	'sign-viewfield-entryid' => "ID de l'entrada",
	'sign-viewfield-timestamp' => 'Data e ora',
	'sign-viewfield-realname' => 'Nom',
	'sign-viewfield-address' => 'Adreça',
	'sign-viewfield-city' => 'Vila',
	'sign-viewfield-state' => 'Estat (departament o província)',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-zip' => 'Còde postal',
	'sign-viewfield-ip' => 'Adreça IP :',
	'sign-viewfield-agent' => 'Agent utilizaire',
	'sign-viewfield-phone' => 'Numèro de telefòn',
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
	'sign-uniquequery-similarphone' => 'Numèro de telefòn similar',
	'sign-uniquequery-similaremail' => 'Adreça de corrièr electronica similara',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] a autentificat [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'sign-viewfield-timestamp' => 'ସମୟଚିହ୍ନ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'sign-viewfield-email' => 'Эл. посты адрис',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'sign-realname' => 'Naame:',
	'sign-viewfield-realname' => 'Naame',
	'sign-viewfield-address' => 'Adress',
	'sig-private' => "''Private''",
	'sign-viewfield-reviewcomment' => 'Aamaericking',
	'sign-review-comment' => 'Aamaericking',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author McMonster
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'signdocument' => 'Podpisz dokument',
	'sign-nodocselected' => 'Wybierz dokument, który chcesz podpisać.',
	'sign-selectdoc' => 'Dokument',
	'sign-docheader' => 'Użyj tego formularza, by podpisać wyświetlony poniżej dokument „[[$1]]”.
Przeczytaj cały dokument dokładnie i jeśli uznasz, że chcesz go poprzeć, w celu podpisania wypełnij wymagane pola.',
	'sign-error-nosuchdoc' => 'Szukany dokument ($1) nie istnieje.',
	'sign-realname' => 'Nazwisko:',
	'sign-address' => 'Ulica:',
	'sign-city' => 'Miasto:',
	'sign-state' => 'Stan:',
	'sign-zip' => 'Kod ZIP:',
	'sign-country' => 'Kraj:',
	'sign-phone' => 'Numer telefonu:',
	'sign-bday' => 'Wiek:',
	'sign-email' => 'Adres e‐mail:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> oznacza wymagane pole.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Uwaga – ukryte przez Ciebie informacje nadal będą widoczne dla administratorów.</i></small>',
	'sign-list-anonymous' => 'Lista anonimowych',
	'sign-list-hideaddress' => 'Nie pokazuj adresu',
	'sign-list-hideextaddress' => 'Nie pokazuj miejscowości, kodu pocztowego ani kraju.',
	'sign-list-hidephone' => 'Nie pokazuj numeru telefonu',
	'sign-list-hidebday' => 'Nie pokazuj wieku',
	'sign-list-hideemail' => 'Nie pokazuj adresu e‐mail',
	'sign-submit' => 'Podpisz dokument',
	'sign-information' => '<div class="noarticletext">Dziękujemy za poświęcenie czasu na przeczytanie tego dokumentu.
Jeśli zgadzasz się z jego treścią, wyraź swoje poparcie, wypełniając wymagane pola poniżej, a następnie kliknij „Podpisz dokument”.
Upewnij się, że Twoje dane osobowe są poprawne i że mamy metodę na skontaktowanie się z Tobą w celu zweryfikowania tożsamości.
Zauważ, że adres IP i inne dane identyfikacyjne będą rejestrowane w czasie zapisywania formularza, a następnie zostaną wykorzystane przez administratora do wyeliminowania wielu głosów oddanych przez jedną osobę oraz do potwierdzenia poprawności danych osobowych.
Ponieważ stosowanie anonimizujących serwerów proxy uniemożliwia nam weryfikację, podpisy złożone przez proxy nie być liczone.
Jeśli jesteś obecnie połączony przez serwer proxy, rozłącz się, a następnie użyj standardowego połączenia aby się podpisać.</div>

$1',
	'sig-success' => 'Dokument został podpisany.',
	'sign-view-selectfields' => "'''Pola do wyświetlenia:'''",
	'sign-viewfield-entryid' => 'Identyfikator wpisu',
	'sign-viewfield-timestamp' => 'Sygnatura czasowa',
	'sign-viewfield-realname' => 'Nazwa',
	'sign-viewfield-address' => 'Adres',
	'sign-viewfield-city' => 'Miasto',
	'sign-viewfield-state' => 'Województwo',
	'sign-viewfield-country' => 'Państwo',
	'sign-viewfield-zip' => 'Kod pocztowy',
	'sign-viewfield-ip' => 'Adres IP',
	'sign-viewfield-agent' => 'User agent',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E‐mail',
	'sign-viewfield-age' => 'Wiek',
	'sign-viewfield-options' => 'Opcje',
	'sign-viewsigs-intro' => 'Poniżej pokazano zarejestrowane podpisy <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Podpisanie tego dokumentu jest obecnie włączone.',
	'sign-sigadmin-close' => 'Wyłącz podpisywanie',
	'sign-sigadmin-currentlyclosed' => 'Podpisanie tego dokumentu jest obecnie wyłączone.',
	'sign-sigadmin-open' => 'Włącz podpisywanie',
	'sign-signatures' => 'Podpisy',
	'sign-sigadmin-closesuccess' => 'Wyłączono podpisywanie.',
	'sign-sigadmin-opensuccess' => 'Włączono podpisywanie.',
	'sign-viewsignatures' => 'zobacz podpisy',
	'sign-closed' => 'zamknięte',
	'sign-error-closed' => 'Podpisywanie tego dokumentu jest obecnie wyłączone.',
	'sig-anonymous' => "''anonim''",
	'sig-private' => "''prywatne''",
	'sign-sigdetails' => 'Szczegóły podpisu',
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
	'sign-viewfield-stricken' => 'Przekreślone',
	'sign-viewfield-reviewedby' => 'Sprawdzający',
	'sign-viewfield-reviewcomment' => 'Komentarz',
	'sign-detail-uniquequery' => 'Podobne wpisy',
	'sign-detail-uniquequery-run' => 'Uruchom zapytanie',
	'sign-detail-strike' => 'Wykreśl podpis',
	'sign-reviewsig' => 'Sprawdź podpis',
	'sign-review-comment' => 'Komentarz',
	'sign-submitreview' => 'Wyślij wynik sprawdzenia',
	'sign-uniquequery-similarname' => 'Podobna nazwa',
	'sign-uniquequery-similaraddress' => 'Podobny adres',
	'sign-uniquequery-similarphone' => 'Podobny numer telefonu',
	'sign-uniquequery-similaremail' => 'Podobny adres e‐mail',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] podpisał [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'signdocument' => "Firma digital d'un document",
	'sign-nodocselected' => "Për piasì, ch'a sërna ël document ch'a veul firmé.",
	'sign-selectdoc' => 'Document:',
	'sign-docheader' => "Për piasì, ch'a deuvra ës mòdulo-sì për firmé an manera digital ël document \"[[\$1]],\" che ijë smonoma ambelessì-sota.
Ch'a sia gentil, ch'a lesa tut ël papé e '''ch'a firma mach s'a l'é d'acòrdi an manera completa'''. Për firmé ch'a buta sò dat ant ij camp a pòsta.",
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> a marca ij camp ch\'a-i é òbligh dë buté.</i></small>',
	'sign-hide-note' => "<small><i><span style=\"color:red\">**</span> Nòta: a l'é n'anformassion nen pùblica, ch'a s-ciàiro mach j'aministrator.</i></small>",
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
	'sign-view-selectfields' => "'''Camp da smon-e:'''",
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
	'sig-anonymous' => "''Anònim''",
	'sig-private' => "''Privà''",
	'sign-sigdetails' => 'Detaj dla firma',
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
	'sign-error-nosuchdoc' => 'د کوم لاسوند غوښتنه چې تاسې کړې ($1)، هغه نشته.',
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
	'sign-viewfield-agent' => 'د کارن پلاوی',
	'sign-viewfield-phone' => 'ټيليفون',
	'sign-viewfield-email' => 'برېښليک',
	'sign-viewfield-age' => 'عمر',
	'sign-viewfield-options' => 'خوښنې',
	'sign-signatures' => 'لاسليکونه',
	'sign-viewsignatures' => 'لاسليکونه کتل',
	'sign-closed' => 'تړل شوی',
	'sig-anonymous' => "''ورکنومی''",
	'sign-viewfield-reviewcomment' => 'تبصره',
	'sign-review-comment' => 'تبصره',
	'sign-uniquequery-similarname' => 'ورته نوم',
	'sign-uniquequery-similaraddress' => 'ورته پته',
	'sign-uniquequery-similarphone' => 'ورته ټيليفون',
	'sign-uniquequery-similaremail' => 'ورته برېښليک',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'signdocument' => 'Assinar documento',
	'sign-nodocselected' => 'Por favor, selecione o documento que pretende assinar.',
	'sign-selectdoc' => 'Documento:',
	'sign-docheader' => 'Por favor, use este formulário para assinar o documento "[[$1]]", mostrado abaixo.
Leia o documento completo, e se desejar indicar o seu suporte, preencha o campos necessários para o assinar.',
	'sign-error-nosuchdoc' => 'O documento que solicitou ($1) não existe.',
	'sign-realname' => 'Nome:',
	'sign-address' => 'Endereço da morada:',
	'sign-city' => 'Cidade:',
	'sign-state' => 'Estado:',
	'sign-zip' => 'Código postal:',
	'sign-country' => 'País:',
	'sign-phone' => 'Número de telefone:',
	'sign-bday' => 'Idade:',
	'sign-email' => 'Correio electrónico:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indica um campo obrigatório.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Nota: Informação não listada continuará visível a moderadores.</i></small>',
	'sign-list-anonymous' => 'Listar como anónimo',
	'sign-list-hideaddress' => 'Não listar endereço',
	'sign-list-hideextaddress' => 'Não listar cidade, estado, código postal ou país',
	'sign-list-hidephone' => 'Não listar telefone',
	'sign-list-hidebday' => 'Não listar idade',
	'sign-list-hideemail' => 'Não listar correio electrónico',
	'sign-submit' => 'Assinar documento',
	'sign-information' => '<div class="noarticletext">Obrigado pelo tempo que dedicou a ler todo o documento.
Se concorda com ele, por favor, indique o seu apoio preenchendo os campos necessários abaixo e clicando "Assinar documento".
Por favor, certifique-se de que a sua informação pessoal está correcta e de que teremos alguma forma de contactá-lo para verificar a sua identidade.
Note que o seu endereço IP e outras informações identificativas serão registados por este formulário e usados pelos moderadores para eliminar assinaturas duplicadas e confirmar a exactidão da sua informação pessoal.
Como a utilização de proxies abertos e anónimos inibe a nossa capacidade de realizar esta tarefa, as assinaturas provenientes de tais proxies provavelmente não serão contabilizadas.
Se está presentemente ligado através de um servidor proxy, por favor, desligue-se deste e use uma ligação convencional durante a assinatura.</div>

$1',
	'sig-success' => 'O documento foi assinado com sucesso.',
	'sign-view-selectfields' => "'''Campos a apresentar:'''",
	'sign-viewfield-entryid' => 'ID da entrada',
	'sign-viewfield-timestamp' => 'Data e hora',
	'sign-viewfield-realname' => 'Nome',
	'sign-viewfield-address' => 'Endereço',
	'sign-viewfield-city' => 'Cidade',
	'sign-viewfield-state' => 'Estado',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-zip' => 'Código Postal',
	'sign-viewfield-ip' => 'Endereço IP',
	'sign-viewfield-agent' => 'Agente utilizador',
	'sign-viewfield-phone' => 'Telefone',
	'sign-viewfield-email' => 'Correio electrónico',
	'sign-viewfield-age' => 'Idade',
	'sign-viewfield-options' => 'Opções',
	'sign-viewsigs-intro' => 'Mostradas abaixo estão as assinaturas registadas para <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Assinatura está presentemente activada para este documento.',
	'sign-sigadmin-close' => 'Desactivar assinaturas',
	'sign-sigadmin-currentlyclosed' => 'Assinatura está presentemente desactivada para este documento.',
	'sign-sigadmin-open' => 'Activar assinaturas',
	'sign-signatures' => 'Assinaturas',
	'sign-sigadmin-closesuccess' => 'Assinaturas desactivadas com sucesso.',
	'sign-sigadmin-opensuccess' => 'Assinaturas activadas com sucesso.',
	'sign-viewsignatures' => 'ver assinaturas',
	'sign-closed' => 'fechado',
	'sign-error-closed' => 'A possibilidade de assinar este documento está presentemente desactivada.',
	'sig-anonymous' => "''Anónimo''",
	'sig-private' => "''Privado''",
	'sign-sigdetails' => 'Detalhes da assinatura',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|discussão]] • <!--
-->[[Special:Contributions/$1|contribuições]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|bloquear utilizador]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} registo de bloqueios] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} verificar IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'Cortada',
	'sign-viewfield-reviewedby' => 'Revisor',
	'sign-viewfield-reviewcomment' => 'Comentário',
	'sign-detail-uniquequery' => 'Entidades similares',
	'sign-detail-uniquequery-run' => 'Executar comando',
	'sign-detail-strike' => 'Cortar assinatura',
	'sign-reviewsig' => 'Rever assinatura',
	'sign-review-comment' => 'Comentar',
	'sign-submitreview' => 'Enviar revisão',
	'sign-uniquequery-similarname' => 'Nome semelhante',
	'sign-uniquequery-similaraddress' => 'Endereço semelhante',
	'sign-uniquequery-similarphone' => 'Telefone semelhante',
	'sign-uniquequery-similaremail' => 'Correio electrónico semelhante',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] assinou [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'signdocument' => 'Assinar documento',
	'sign-nodocselected' => 'Por favor, selecione o documento que pretende assinar.',
	'sign-selectdoc' => 'Documento:',
	'sign-docheader' => 'Por favor, use este formulário para assinar o documento "[[$1]]", mostrado abaixo.
Leia o documento completo, e se desejar indicar o seu suporte, preencha o campos necessários para o assinar.',
	'sign-error-nosuchdoc' => 'O documento que requisitou ($1) não existe.',
	'sign-realname' => 'Nome:',
	'sign-address' => 'Endereço residencial:',
	'sign-city' => 'Cidade:',
	'sign-state' => 'Estado:',
	'sign-zip' => 'Código postal:',
	'sign-country' => 'País:',
	'sign-phone' => 'Número de telefone:',
	'sign-bday' => 'Idade:',
	'sign-email' => 'Endereço de e-mail:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indica um campo obrigatório.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Nota: Informação não listada continuará visível a moderadores.</i></small>',
	'sign-list-anonymous' => 'Listar como anônimo',
	'sign-list-hideaddress' => 'Não listar endereço',
	'sign-list-hideextaddress' => 'Não listar cidade, estado, código postal ou país',
	'sign-list-hidephone' => 'Não listar telefone',
	'sign-list-hidebday' => 'Não listar idade',
	'sign-list-hideemail' => 'Não listar email',
	'sign-submit' => 'Assinar documento',
	'sign-information' => '<div class="noarticletext">Obrigado por tomar o seu tempo para ler todo o documento.
Se concordar, por favor, indique o seu suporte preenchendo os campos necessários abaixo e clicando em "Assinar documento".
Por favor, certifique-se que a sua informação pessoal está correta, e que teremos alguma forma de contactá-lo para verificar a sua identidade.
Note que o seu endereço IP e outra informação identificativa serão registrados por este formulário e usados por moderadores para eliminar assinaturas duplicadas e confirmar a exatidão da sua informação pessoal.
Como a utilização de proxies abertos e anônimos previne a nossa possibilidade de realizar esta tarefa, assinaturas provenientes de tais proxies provavelmente não serão contabilizadas.
Se está atualmente ligado através de um servidor proxy, por favor, desligue-se deste e use uma ligação convencional durante a assinatura.</div>

$1',
	'sig-success' => 'O documento foi assinado com sucesso.',
	'sign-view-selectfields' => "'''Campos a apresentar:'''",
	'sign-viewfield-entryid' => 'ID da entrada',
	'sign-viewfield-timestamp' => 'Tempo',
	'sign-viewfield-realname' => 'Nome',
	'sign-viewfield-address' => 'Endereço',
	'sign-viewfield-city' => 'Cidade',
	'sign-viewfield-state' => 'Estado',
	'sign-viewfield-country' => 'País',
	'sign-viewfield-zip' => 'Código Postal',
	'sign-viewfield-ip' => 'Endereço IP',
	'sign-viewfield-agent' => 'Agente utilizador',
	'sign-viewfield-phone' => 'Telefone',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Idade',
	'sign-viewfield-options' => 'Opções',
	'sign-viewsigs-intro' => 'Mostradas abaixo estão as assinaturas registradas para <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Assinatura está atualmente ativada para este documento.',
	'sign-sigadmin-close' => 'Desativar assinaturas',
	'sign-sigadmin-currentlyclosed' => 'Assinatura está atualmente desativada para este documento.',
	'sign-sigadmin-open' => 'Ativar assinaturas',
	'sign-signatures' => 'Assinaturas',
	'sign-sigadmin-closesuccess' => 'Assinaturas desativadas com sucesso.',
	'sign-sigadmin-opensuccess' => 'Assinaturas ativadas com sucesso.',
	'sign-viewsignatures' => 'ver assinaturas',
	'sign-closed' => 'fechado',
	'sign-error-closed' => 'A possibilidade de assinar este documento está atualmente desativada.',
	'sig-anonymous' => "''Anônimo''",
	'sig-private' => "''Privado''",
	'sign-sigdetails' => 'Detalhes da assinatura',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|discussão]] • <!--
-->[[Special:Contributions/$1|contribuições]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBLs] • <!--
-->[[Special:BlockIP/$1|bloquear utilizador]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} registro de bloqueios] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} verificar IP])<!--
--></span>',
	'sign-viewfield-stricken' => 'Cortada',
	'sign-viewfield-reviewedby' => 'Revisor',
	'sign-viewfield-reviewcomment' => 'Comentário',
	'sign-detail-uniquequery' => 'Entidades similares',
	'sign-detail-uniquequery-run' => 'Executar consulta',
	'sign-detail-strike' => 'Cortar assinatura',
	'sign-reviewsig' => 'Rever assinatura',
	'sign-review-comment' => 'Comentar',
	'sign-submitreview' => 'Submeter revisão',
	'sign-uniquequery-similarname' => 'Nome similar',
	'sign-uniquequery-similaraddress' => 'Endereço semelhante',
	'sign-uniquequery-similarphone' => 'Telefone semelhante',
	'sign-uniquequery-similaremail' => 'Email similar',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] assinou [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'sign-uniquequery-1signed2' => "[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] sutiyuqqa [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2] nisqa qillqarimata silq'un.",
);

/** Romansh (Rumantsch) */
$messages['rm'] = array(
	'sign-viewfield-realname' => 'Num',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'signdocument' => 'Semnați documentul',
	'sign-selectdoc' => 'Document:',
	'sign-realname' => 'Nume:',
	'sign-address' => 'Adresă stradă:',
	'sign-city' => 'Oraș:',
	'sign-zip' => 'Cod poștal:',
	'sign-country' => 'Ţară:',
	'sign-phone' => 'Număr de telefon:',
	'sign-bday' => 'Vârstă:',
	'sign-email' => 'Adresă e-mail:',
	'sign-list-hideaddress' => 'Nu afișa adresa',
	'sign-list-hideextaddress' => 'Nu afișa orașul, statul, codul poștal sau țara',
	'sign-list-hidephone' => 'Nu afișa telefonul',
	'sign-list-hidebday' => 'Nu afișa vârsta',
	'sign-list-hideemail' => 'Nu afișa adresa de e-mail',
	'sign-submit' => 'Semnați documentul',
	'sign-viewfield-entryid' => 'ID intrare',
	'sign-viewfield-timestamp' => 'Data și ora',
	'sign-viewfield-realname' => 'Nume',
	'sign-viewfield-address' => 'Adresă',
	'sign-viewfield-city' => 'Oraș',
	'sign-viewfield-state' => 'Stat',
	'sign-viewfield-country' => 'Ţară',
	'sign-viewfield-zip' => 'Cod poștal',
	'sign-viewfield-ip' => 'Adresă IP',
	'sign-viewfield-agent' => 'Agent utilizator',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-mail',
	'sign-viewfield-age' => 'Vârstă',
	'sign-viewfield-options' => 'Opțiuni',
	'sign-sigadmin-currentlyopen' => 'Semnarea este momentan activată pentru acest document.',
	'sign-sigadmin-close' => 'Dezactivează semnarea',
	'sign-sigadmin-currentlyclosed' => 'Semnarea este momentan dezactivată pentru acest document.',
	'sign-sigadmin-open' => 'Activează semnarea',
	'sign-signatures' => 'Semnături',
	'sign-sigadmin-closesuccess' => 'Semnarea dezactivată cu succes.',
	'sign-sigadmin-opensuccess' => 'Semnarea activată cu succes.',
	'sign-viewsignatures' => 'vedeți semnături',
	'sign-closed' => 'închis',
	'sign-error-closed' => 'Semnarea acestui document este momentan dezactivată.',
	'sig-anonymous' => "''Anonim''",
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Detaliile semnăturii',
	'sign-viewfield-reviewcomment' => 'Comentariu',
	'sign-detail-uniquequery' => 'Entități similare',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> indichesce le cambe obbligatorije.</i></small>',
	'sign-view-selectfields' => "'''Cambe ca a fà vedè:'''",
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
	'sig-anonymous' => "''Anonime''",
	'sig-private' => "''Privete''",
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
	'sign-docheader' => 'Пожалуйста, используйте эту форму для подписи документа «[[$1]]», представленного ниже.
Пожалуйста, прочтите документ целиком, и если вы хотите выразить ему поддержку, заполните требуемые поля, чтобы подписать его.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> отмечает обязательные поля.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Замечание: невключённая в список информация будет видна модераторам.</i></small>',
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
	'sign-view-selectfields' => "'''Поля для оображения:'''",
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
	'sig-anonymous' => "''Аноним''",
	'sig-private' => "''Частный''",
	'sign-sigdetails' => 'Подробнее о подписи',
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

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'signdocument' => 'Підписати документ',
	'sign-realname' => 'Мено:',
	'sign-address' => 'Поштова адреса:',
	'sign-city' => 'Місто:',
	'sign-state' => 'Штат:',
	'sign-zip' => 'Поштовый код',
	'sign-country' => 'Країна:',
	'sign-phone' => 'Телефонне чісло:',
	'sign-bday' => 'Век:',
	'sign-email' => 'Адреса електронічной пошты:',
	'sign-viewfield-realname' => 'Мено',
	'sign-viewfield-address' => 'Адреса',
	'sign-viewfield-city' => 'Місто',
	'sign-viewfield-state' => 'Штат',
	'sign-viewfield-country' => 'Країна',
	'sign-viewfield-zip' => 'Поштовый код',
	'sign-viewfield-ip' => 'IP адреса',
	'sign-viewfield-phone' => 'Телефон',
	'sign-viewfield-email' => 'Електронічна пошта',
	'sign-viewfield-age' => 'Век',
	'sign-viewfield-options' => 'Можности',
	'sign-signatures' => 'Підписы',
	'sign-viewsignatures' => 'видїти підписы',
	'sign-closed' => 'заперто',
	'sign-uniquequery-similarname' => 'Подобне мено',
	'sign-uniquequery-similaraddress' => 'Подобна адреса',
	'sign-uniquequery-similarphone' => 'Подобный телефон',
	'sign-uniquequery-similaremail' => 'Подобна адреса ел. пошты',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'signdocument' => 'Podpísať dokument',
	'sign-nodocselected' => 'Prosím, zvoľte dokument, ktorý chcete podpísať.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => 'Prosím, použite tento formulár na podpísanie dolu zobrazeného dokumentu „[[$1]]“.
Prosím, prečítajte si celý dokument a ak chcete vyjadriť jeho podporu, vyplňte prosím požadované polia, aby mohol byť podpísaný.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> označuje povinné polia.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Pozn.: Informácie, ktoré sa nezobrazujú budú aj tak viditeľné moderátorom.</i></small>',
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
	'sign-view-selectfields' => "'''Zobrazované polia:'''",
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
	'sig-anonymous' => "''anonym''",
	'sig-private' => "''súkromné''",
	'sign-sigdetails' => 'Podrobnosti podpisu',
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

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'signdocument' => 'Потпиши документ',
	'sign-nodocselected' => 'Молимо Вас, изаберите документ који желите да потпишете',
	'sign-selectdoc' => 'Документ:',
	'sign-docheader' => 'Молимо Вас да користите ову форму као бисте потписали документ "[[$1]]", приказан испод.
Прочитајте цели документ и, ако желите да потврдите да га се са његовим садржајем слажете, попуните потребна поља и потпишите га.',
	'sign-error-nosuchdoc' => 'Документ који сте затражили ($1) не постоји.',
	'sign-realname' => 'Име:',
	'sign-address' => 'Адреса:',
	'sign-city' => 'Град:',
	'sign-state' => 'Држава:',
	'sign-zip' => 'Поштански код:',
	'sign-country' => 'Земља:',
	'sign-phone' => 'Телефонски број:',
	'sign-bday' => 'Старост:',
	'sign-email' => 'Е-адреса:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> означава обавезно поље.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Напомена: неприказане информације ће још увек бити видљиве модераторима.</i></small>',
	'sign-list-anonymous' => 'Прикажи као анонимно',
	'sign-list-hideaddress' => 'Не приказуј адресу',
	'sign-list-hideextaddress' => 'Не приказуј град, државу, поштански код, или земљу',
	'sign-list-hidephone' => 'Не пријазуј телефон',
	'sign-list-hidebday' => 'Не приказуј старост',
	'sign-list-hideemail' => 'Не приказуј е-адресу',
	'sign-submit' => 'Потпиши документ',
	'sign-information' => '<div class="noarticletext">Хвала Вам што сте одвојили времен да прочитате овај документ.
Ако се слажете с њим, молимо Вас да покажете вашу подршку попуњавањем обавезних поља испод и кликом на дугме "Потпиши документ".

Молимо Вас да проверите да ли сте ваше личне информације унели исправно и да сте нам дали довољно информација како бисмо Вас могли контактирати зарад провере идентитета.
Приметите да ће Ваша IP адреса и остале идентификујуће информације бити снимљење кроз ову форму и коришћене од стране модератора, како би се елиминисала дупла слања и потврдила тачност ваших личних података.
Пошто коришћење отворених и анонимних проксија умањује наше могћности да испунимо овај задатак, потписи послати са њих највероватније неће бити урачунати.
Ако сте тренутно повезани на интернет преко прокси сервера, молимо Вас да се дисконектујете с њега и користите стандардну конекцију током потписивања документа.</div>

$1',
	'sig-success' => 'Успешно сте потписали документ.',
	'sign-view-selectfields' => "'''Поља за приказ:'''",
	'sign-viewfield-entryid' => 'ID уноса',
	'sign-viewfield-timestamp' => 'Време и датум',
	'sign-viewfield-realname' => 'Име',
	'sign-viewfield-address' => 'Адреса',
	'sign-viewfield-city' => 'Град',
	'sign-viewfield-state' => 'Држава',
	'sign-viewfield-country' => 'Земља',
	'sign-viewfield-zip' => 'Поштански код',
	'sign-viewfield-ip' => 'ИП адреса',
	'sign-viewfield-agent' => 'Кориснички агент',
	'sign-viewfield-phone' => 'Телефон',
	'sign-viewfield-email' => 'Е-пошта',
	'sign-viewfield-age' => 'Старост',
	'sign-viewfield-options' => 'Поставке',
	'sign-viewsigs-intro' => 'Испод су приказани потписи снимљени за <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Потписивање је тренутно омогућено за овај документ.',
	'sign-sigadmin-close' => 'Онемогући потписивање',
	'sign-sigadmin-currentlyclosed' => 'Потписивање је тренутно онемогућено за овај документ.',
	'sign-sigadmin-open' => 'Омогући потписивање',
	'sign-signatures' => 'Потписи',
	'sign-sigadmin-closesuccess' => 'Потписивање успешно онемогућено.',
	'sign-sigadmin-opensuccess' => 'Потписивање успешно омогућено.',
	'sign-viewsignatures' => 'погледај потписе',
	'sign-closed' => 'затворено',
	'sign-error-closed' => 'Потписивање овог документа је тренутно онемогућено.',
	'sig-anonymous' => "''Анонимно''",
	'sig-private' => "''Приватно''",
	'sign-sigdetails' => 'Детаљи о потпису',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|разговор]] • <!--
-->[[Special:Contributions/$1|прилози]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBL] • <!--
-->[[Special:BlockIP/$1|блокирај корисника]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} историја блокирања] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} checkip])<!--
--></span>',
	'sign-viewfield-stricken' => 'Залепљен',
	'sign-viewfield-reviewcomment' => 'Коментар',
	'sign-detail-uniquequery' => 'Слични ентитети',
	'sign-detail-uniquequery-run' => 'Изврши захтев',
	'sign-review-comment' => 'Коментар',
	'sign-uniquequery-similarname' => 'Слично име',
	'sign-uniquequery-similaraddress' => 'Слична адреса',
	'sign-uniquequery-similarphone' => 'Сличан телефон',
	'sign-uniquequery-similaremail' => 'Слична е-пошта',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] потписан [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'signdocument' => 'Potpiši dokument',
	'sign-nodocselected' => 'Molimo Vas, izaberite dokument koji želite da potpišete',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => 'Molimo Vas da koristite ovu formu kao biste potpisali dokument "[[$1]]", prikazan ispod.
Pročitajte celi dokument i, ako želite da potvrdite da ga se sa njegovim sadržajem slažete, popunite potrebna polja i potpišite ga.',
	'sign-error-nosuchdoc' => 'Dokument koji ste zatražili ($1) ne postoji.',
	'sign-realname' => 'Ime:',
	'sign-address' => 'Adresa:',
	'sign-city' => 'Grad:',
	'sign-state' => 'Država:',
	'sign-zip' => 'Poštanski kod:',
	'sign-country' => 'Zemlja:',
	'sign-phone' => 'Telefonski broj:',
	'sign-bday' => 'Starost:',
	'sign-email' => 'E-adresa:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> označava obavezno polje.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Napomena: neprikazane informacije će još uvek biti vidljive moderatorima.</i></small>',
	'sign-list-anonymous' => 'Prikaži kao anonimno',
	'sign-list-hideaddress' => 'Ne prikazuj adresu',
	'sign-list-hideextaddress' => 'Ne prikazuj grad, državu, poštanski kod, ili zemlju',
	'sign-list-hidephone' => 'Ne prijazuj telefon',
	'sign-list-hidebday' => 'Ne prikazuj starost',
	'sign-list-hideemail' => 'Ne prikazuj e-adresu',
	'sign-submit' => 'Potpiši dokument',
	'sign-information' => '<div class="noarticletext">Hvala Vam što ste odvojili vremen da pročitate ovaj dokument.
Ako se slažete s njim, molimo Vas da pokažete vašu podršku popunjavanjem obaveznih polja ispod i klikom na dugme "Potpiši dokument".

Molimo Vas da proverite da li ste vaše lične informacije uneli ispravno i da ste nam dali dovoljno informacija kako bismo Vas mogli kontaktirati zarad provere identiteta.
Primetite da će Vaša IP adresa i ostale identifikujuće informacije biti snimljenje kroz ovu formu i korišćene od strane moderatora, kako bi se eliminisala dupla slanja i potvrdila tačnost vaših ličnih podataka.
Pošto korišćenje otvorenih i anonimnih proksija umanjuje naše mogćnosti da ispunimo ovaj zadatak, potpisi poslati sa njih najverovatnije neće biti uračunati.
Ako ste trenutno povezani na internet preko proksi servera, molimo Vas da se diskonektujete s njega i koristite standardnu konekciju tokom potpisivanja dokumenta.</div>

$1',
	'sig-success' => 'Uspešno ste potpisali dokument.',
	'sign-view-selectfields' => "'''Polja za prikaz:'''",
	'sign-viewfield-entryid' => 'ID unosa',
	'sign-viewfield-timestamp' => 'Vreme i datum',
	'sign-viewfield-realname' => 'Ime',
	'sign-viewfield-address' => 'Adresa',
	'sign-viewfield-city' => 'Grad',
	'sign-viewfield-state' => 'Država',
	'sign-viewfield-country' => 'Zemlja',
	'sign-viewfield-zip' => 'Poštanski kod',
	'sign-viewfield-ip' => 'IP adresa',
	'sign-viewfield-agent' => 'Korisnički agent',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-pošta',
	'sign-viewfield-age' => 'Starost',
	'sign-viewfield-options' => 'Opcije',
	'sign-viewsigs-intro' => 'Ispod su prikazani potpisi snimljeni za <span class="plainlinks">[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} $1]</span>.',
	'sign-sigadmin-currentlyopen' => 'Potpisivanje je trenutno omogućeno za ovaj dokument.',
	'sign-sigadmin-close' => 'Onemogući potpisivanje',
	'sign-sigadmin-currentlyclosed' => 'Potpisivanje je trenutno onemogućeno za ovaj dokument.',
	'sign-sigadmin-open' => 'Omogući potpisivanje',
	'sign-signatures' => 'Potpisi',
	'sign-sigadmin-closesuccess' => 'Potpisivanje uspešno onemogućeno.',
	'sign-sigadmin-opensuccess' => 'Potpisivanje uspešno omogućeno.',
	'sign-viewsignatures' => 'pogledaj potpise',
	'sign-closed' => 'zatvoreno',
	'sign-error-closed' => 'Potpisivanje ovog dokumenta je trenutno onemogućeno.',
	'sig-anonymous' => "''Anonimno''",
	'sig-private' => "''Privatno''",
	'sign-sigdetails' => 'Detalji o potpisu',
	'sign-emailto' => '<a href="mailto:$1">$1</a>',
	'sign-iptools' => '<span class="plainlinksneverexpand"><!--
-->[[User:$1|$1]] ([[User talk:$1|razgovor]] • <!--
-->[[Special:Contributions/$1|prilozi]] • <!--
-->[http://www.dnsstuff.com/tools/whois.ch?domain={{urlencode:$1}}&cache=off&email=on WHOIS] • <!--
-->[http://www.dnsstuff.com/tools/ptr.ch?ip={{urlencode:$1}}&cache=off&email=on RDNS] • <!--
-->[http://www.robtex.com/rbls/$1.html RBL] • <!--
-->[[Special:BlockIP/$1|blokiraj korisnika]] • <!--
-->[{{fullurl:Special:Log/block|page=User:{{urlencode:$1}}}} istorija blokiranja] • <!--
-->[{{fullurl:Special:CheckUser|ip={{urlencode:$1}}}} checkip])<!--
--></span>',
	'sign-viewfield-stricken' => 'Zalepljen',
	'sign-viewfield-reviewcomment' => 'Komentar',
	'sign-detail-uniquequery' => 'Slični entiteti',
	'sign-detail-uniquequery-run' => 'Izvrši zahtev',
	'sign-review-comment' => 'Komentar',
	'sign-uniquequery-similarname' => 'Slično ime',
	'sign-uniquequery-similaraddress' => 'Slična adresa',
	'sign-uniquequery-similarphone' => 'Sličan telefon',
	'sign-uniquequery-similaremail' => 'Slična e-pošta',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] potpisan [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
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
 * @author Lokal Profil
 * @author M.M.S.
 */
$messages['sv'] = array(
	'signdocument' => 'Signera dokument',
	'sign-nodocselected' => 'Välj det dokument du vill signera.',
	'sign-selectdoc' => 'Dokument:',
	'sign-docheader' => 'Använd det här formuläret för att signera dokumentet "[[$1]]," som visas härunder.
Var god läs igenom hela dokumentet, och om du vill visa ditt stöd för det, fyll i de nödvändiga fälten för att signera.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> betyder att fältet måste fyllas i.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Observera: Dold informationen är fortfarande tillgänglig för moderatorer.</i></small>',
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
	'sign-view-selectfields' => "'''Fält som visas:'''",
	'sign-viewfield-entryid' => 'Inskrifts-ID',
	'sign-viewfield-timestamp' => 'Tidsstämpel',
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
	'sig-anonymous' => "''Anonym''",
	'sig-private' => "''Privat''",
	'sign-sigdetails' => 'Signatur detaljer',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> తప్పనిసరి వాటిని సూచిస్తుంది.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> గమనిక: చూపించని సమాచారాన్ని నిర్వాహకులు మాత్రం చూడగలరు.</i></small>',
	'sign-list-anonymous' => 'అనామకంగా చూపించు',
	'sign-list-hideaddress' => 'చిరునామాని చూపించకు',
	'sign-list-hideextaddress' => 'నగరం, రాష్ట్రం, జిప్, లేదా దేశంలను చూపించకు',
	'sign-list-hidephone' => 'ఫోన్ నంబరు చూపించకు',
	'sign-list-hidebday' => 'వయసుని చూపించకు',
	'sign-list-hideemail' => 'ఈ-మెయిలుని చూపించకు',
	'sign-submit' => 'సంతకం చేయండి',
	'sig-success' => 'ఈ పత్రంపై మీరు విజయవంతంగా సంతకం చేసారు.',
	'sign-view-selectfields' => "'''చూపించాల్సిన ఖాళీలు:'''",
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
	'sig-anonymous' => "''అనామకం''",
	'sig-private' => "''అంతరంగికం''",
	'sign-sigdetails' => 'సంతకం వివరాలు',
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

/** Tajik (Cyrillic script) (Тоҷикӣ)
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

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'sign-realname' => 'Nom:',
	'sign-address' => 'Nişonai kūca:',
	'sign-city' => 'Şahr:',
	'sign-state' => 'Vilojat:',
	'sign-country' => 'Kişvar:',
	'sign-phone' => 'Şumorai telefon:',
	'sign-bday' => 'Sinnu sol:',
	'sign-email' => 'Nişonai E-mail:',
	'sign-viewfield-realname' => 'Nom',
	'sign-viewfield-address' => 'Nişona',
	'sign-viewfield-city' => 'Şahr',
	'sign-viewfield-state' => 'Vilojat',
	'sign-viewfield-country' => 'Kişvar',
	'sign-viewfield-zip' => 'Indeks',
	'sign-viewfield-ip' => 'Nişonai IP',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'Poctai elektronī',
	'sign-viewfield-options' => 'Ixtijorot',
	'sign-viewfield-reviewcomment' => 'Tavzehot',
	'sign-review-comment' => 'Tavzeh',
);

/** Thai (ไทย)
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'sign-email' => 'อีเมล:',
	'sign-viewfield-ip' => 'หมายเลขไอพี',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'sign-realname' => 'At:',
	'sign-viewfield-realname' => 'At',
	'sign-viewfield-reviewedby' => 'Gözden geçiriji',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'signdocument' => 'Lagdaan ang kasulatan/dokumento',
	'sign-nodocselected' => 'Pakipili ang kasulatan/dokumentong nais mong lagdaan.',
	'sign-selectdoc' => 'Kasulatan/Dokumento:',
	'sign-docheader' => 'Pakigamit ang pormularyong ito upang malagdaan ang kasulatang "[[$1]]," na ipinapakita sa ibaba.
Pakibasang mabuti ang buong dokumento, at kung ibig mong ipahayag ang pagtangkilik/pagsuporta mo rito, pakipunan ang mga kinakailangang kahanayan upang malagdaan ito.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> nagpapahayag ng kinakailangang kahanayan.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Paunawa: Ang hindi nakatalang kabatiran ay matatanaw pa rin ng mga tagapamagitan.</i></small>',
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
	'sign-view-selectfields' => "'''Mga kahanayang ipapakita/palilitawin:'''",
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
	'sig-anonymous' => "''Anonimo/Hindi nagpapakilala''",
	'sig-private' => "''Pribado/Pansarili''",
	'sign-sigdetails' => 'Mga detalye ng lagda',
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

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'signdocument' => 'Belgeyi imzala',
	'sign-nodocselected' => 'Lütfen imzalamak istediğiniz belgeyi seçin.',
	'sign-selectdoc' => 'Belge:',
	'sign-realname' => 'Adı:',
	'sign-address' => 'Cadde adresi:',
	'sign-city' => 'Şehir:',
	'sign-state' => 'Eyalet:',
	'sign-zip' => 'Posta kodu:',
	'sign-country' => 'Ülke:',
	'sign-phone' => 'Telefon numarası:',
	'sign-bday' => 'Yaş:',
	'sign-email' => 'E-posta adresi:',
	'sign-list-anonymous' => 'Anonim olarak listele',
	'sign-list-hideaddress' => 'Adres listeleme',
	'sign-list-hideextaddress' => 'Şehir, eyalet, posta kodu ya da ülke listeleme',
	'sign-list-hidephone' => 'Telefon listeleme',
	'sign-list-hidebday' => 'Yaş listeleme',
	'sign-list-hideemail' => 'E-posta listeleme',
	'sign-submit' => 'Belge imzala',
	'sig-success' => 'Belgeyi başarıyla imzaladınız.',
	'sign-viewfield-entryid' => 'Girdi kimliği',
	'sign-viewfield-timestamp' => 'Zaman kodu',
	'sign-viewfield-realname' => 'İsim',
	'sign-viewfield-address' => 'Adres',
	'sign-viewfield-city' => 'Şehir',
	'sign-viewfield-state' => 'Eyalet',
	'sign-viewfield-country' => 'Ülke',
	'sign-viewfield-zip' => 'Posta kodu',
	'sign-viewfield-ip' => 'IP adresi',
	'sign-viewfield-agent' => 'Kullanıcı temsilcisi',
	'sign-viewfield-phone' => 'Telefon',
	'sign-viewfield-email' => 'E-posta',
	'sign-viewfield-age' => 'Yaş',
	'sign-viewfield-options' => 'Seçenekler',
	'sign-sigadmin-currentlyopen' => 'İmzalama, halihazırda bu belge için etkinleştirilmiş durumda.',
	'sign-sigadmin-close' => 'İmzalamayı devre dışı bırak',
	'sign-sigadmin-currentlyclosed' => 'İmzalama halihazırda bu belge için devre dışı bırakılmış durumda.',
	'sign-signatures' => 'İmzalar',
	'sign-sigadmin-closesuccess' => 'İmzalama başarıyla devre dışı bırakıldı.',
	'sign-sigadmin-opensuccess' => 'İmzalama başarıyla etkinleştirildi.',
	'sign-viewsignatures' => 'imzaları gör',
	'sign-closed' => 'kapandı',
	'sign-error-closed' => 'Bu belgenin imzalanması halihazırda devre dışı bırakılmış durumda.',
	'sig-anonymous' => "''Anonim''",
	'sig-private' => "''Özel''",
	'sign-sigdetails' => 'İmza detayları',
	'sign-viewfield-stricken' => 'Üstü çizilmiş',
	'sign-viewfield-reviewedby' => 'İnceleyen',
	'sign-viewfield-reviewcomment' => 'Yorum',
	'sign-detail-uniquequery-run' => 'Sorguyu başlat',
	'sign-detail-strike' => 'İmzanın üstünü çiz',
	'sign-reviewsig' => 'İmzayı incele',
	'sign-review-comment' => 'Yorum',
	'sign-submitreview' => 'Gözden geçirmeyi gönder',
	'sign-uniquequery-similarname' => 'Benzer ad',
	'sign-uniquequery-similaraddress' => 'Benzer adres',
	'sign-uniquequery-similarphone' => 'Benzer telefon',
	'sign-uniquequery-similaremail' => 'Benzer e-posta',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Рашат Якупов
 */
$messages['tt-cyrl'] = array(
	'sign-city' => 'Шәһәр:',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'sign-viewfield-email' => 'ئېلخەت',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'sign-viewfield-email' => 'Élxet',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'sign-realname' => "Ім'я:",
	'sign-address' => 'Поштова адреса:',
	'sign-city' => 'Місто:',
	'sign-state' => 'Штат:',
	'sign-country' => 'Країна:',
	'sign-email' => 'Адреса електронної пошти:',
	'sign-viewfield-realname' => "Ім'я",
	'sign-viewfield-address' => 'Адреса',
	'sign-viewfield-city' => 'Місто',
	'sign-viewfield-state' => 'Штат',
	'sign-viewfield-country' => 'Країна',
	'sign-viewfield-ip' => 'IP-адреса',
	'sign-viewfield-email' => 'Електронна пошта',
	'sign-signatures' => 'Підписи',
	'sign-viewfield-reviewcomment' => 'Коментар',
	'sign-review-comment' => 'Коментар',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'signdocument' => 'Allekitjutada dokument',
	'sign-realname' => 'Nimi:',
	'sign-address' => "Adres (ird, pert' i m. e.):",
	'sign-city' => 'Lidn:',
	'sign-state' => 'Štat:',
	'sign-zip' => 'Počtindeks:',
	'sign-country' => 'Valdkund:',
	'sign-phone' => 'Telefonnomer:',
	'sign-bday' => 'Igä:',
	'sign-email' => 'E-počtan adres:',
	'sign-submit' => 'Allekirjuta dokument',
	'sign-viewfield-entryid' => 'Kirjutesen ID',
	'sign-viewfield-timestamp' => 'Dat/Aig',
	'sign-viewfield-realname' => 'Nimi',
	'sign-viewfield-address' => 'Adres',
	'sign-viewfield-city' => 'Lidn',
	'sign-viewfield-state' => 'Štat, agj',
	'sign-viewfield-country' => 'Valdkund',
	'sign-viewfield-zip' => 'Počtindeks',
	'sign-viewfield-ip' => 'IP-adres',
	'sign-viewfield-agent' => 'Kaclim',
	'sign-viewfield-phone' => 'Telefonnomer',
	'sign-viewfield-email' => 'E-počtan adres',
	'sign-viewfield-age' => 'Igä',
	'sign-viewfield-options' => 'Järgendused',
	'sign-signatures' => 'Allekirjutesed',
	'sign-viewsignatures' => 'nähta allekirjutesed',
	'sign-closed' => 'sauptud',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'signdocument' => 'Ký tài liệu',
	'sign-nodocselected' => 'Xin hãy chọn tài liệu bạn muốn ký.',
	'sign-selectdoc' => 'Tài liệu:',
	'sign-docheader' => 'Xin hãy dùng mẫu này để ký tài liệu "[[$1]]," ghi ở dưới.
Xin hãy đọc qua toàn bộ tài liệu, và nếu bạn muốn chỉ rõ sự hỗ trợ của bạn cho nó, xin hãy điền các ô cần thiết để ký tên.',
	'sign-error-nosuchdoc' => 'Tài liệu bạn yêu cầu ($1) không tồn tại.',
	'sign-realname' => 'Tên:',
	'sign-address' => 'Địa chỉ nhà:',
	'sign-city' => 'Thành phố:',
	'sign-state' => 'Bang:',
	'sign-zip' => 'Mã zip:',
	'sign-country' => 'Quốc gia:',
	'sign-phone' => 'Số điện thoại:',
	'sign-bday' => 'Tuổi:',
	'sign-email' => 'Địa chỉ thư điện tử:',
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> chỉ các ô bắt buộc.</i></small>',
	'sign-hide-note' => '<small><i><span style="color:red">**</span> Chú ý: Thông tin không liệt kê sẽ hiển thị cho người quản trị.</i></small>',
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
	'sign-view-selectfields' => "'''Các vùng sẽ hiển thị:'''",
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
	'sig-anonymous' => "''Vô danh''",
	'sig-private' => "''Riêng tư''",
	'sign-sigdetails' => 'Chi tiết chữ ký',
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
	'sign-docheader' => 'Gebolös fometi at ad dispenön dokümi: „[[$1]]“, dono pajonöli.
Dareidolös dokümi lölik ed if vilol jonön stüti olik tefü on, fulükolös felis paflagöl ad dispenön oni.',
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
	'sign-indicates-req' => '<small><i><span style="color:red">*</span> malon felis peflagöl.</i></small>',
	'sign-list-anonymous' => 'Lisedön nennemiko',
	'sign-list-hideaddress' => 'No lisedön ladeti',
	'sign-list-hideextaddress' => 'No lisedön zifi, tati, potakoti u läni',
	'sign-list-hidephone' => 'No lisedön telefonanümi',
	'sign-list-hidebday' => 'No lisedön bäldoti',
	'sign-list-hideemail' => 'No lisedön ladeti leäktronik',
	'sign-submit' => 'Dispenön dokümi',
	'sig-success' => 'Edispenol dokümi benosekiko.',
	'sign-view-selectfields' => "'''Fels jonabik:'''",
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
	'sig-anonymous' => "''Nennemik''",
	'sig-private' => "''Privatik''",
	'sign-viewfield-reviewcomment' => 'Küpet',
	'sign-review-comment' => 'Küpet',
	'sign-uniquequery-similarname' => 'Nem sümik',
	'sign-uniquequery-similaraddress' => 'Ladet sümik',
	'sign-uniquequery-similarphone' => 'Telefonanüm sümik',
	'sign-uniquequery-similaremail' => 'Ladet leäktronik sümik',
	'sign-uniquequery-1signed2' => '[{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs&detail=$3}} $1] edispenon dokümi: [{{SERVER}}{{localurl: Special:SignDocument|doc=$4&viewsigs}} $2].',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'sign-realname' => 'נאמען:',
	'sign-list-hideaddress' => 'נישט ווײַזן אַדרעס',
	'sign-list-hideextaddress' => 'נישט ווײַזן שטאָט, שטאַט, פאסטקאד אדער לאַנד',
	'sign-list-hidephone' => 'נישט ווײַזן פֿאן נומער',
	'sign-list-hidebday' => 'נישט ווײַזן עלטער',
	'sign-list-hideemail' => 'נישט ווײַזן ע־פאסט אַדרעס',
	'sign-submit' => 'אונטערשרײַבן דאקומענט',
	'sig-success' => 'איר האט דערפֿאלגרייך אונטערגעשריבן דעם דאקומענט.',
	'sign-view-selectfields' => "'''פֿעלדער צו ווייַזן:'''",
	'sign-viewfield-timestamp' => 'צײַטשטעמפל',
	'sign-viewfield-realname' => 'נאָמען',
	'sign-viewfield-address' => 'אַדרעס',
	'sign-closed' => 'פֿאַרמאַכט',
	'sig-private' => "''פריוואַט''",
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Hydra
 * @author Liangent
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'sign-realname' => '姓名：',
	'sign-address' => '街道地址：',
	'sign-city' => '城市：',
	'sign-state' => '州份/省份：',
	'sign-zip' => '邮政编号：',
	'sign-country' => '国家地区：',
	'sign-phone' => '电话号码：',
	'sign-bday' => '年龄：',
	'sign-email' => '电邮地址：',
	'sign-list-hideaddress' => '不要列出地址',
	'sign-list-hideextaddress' => '不要列出城市、州份／省份、邮政编号或国家地区',
	'sign-list-hidephone' => '不要列出电话',
	'sign-list-hidebday' => '不要列出年龄',
	'sign-list-hideemail' => '不要列出电邮',
	'sign-viewfield-realname' => '姓名',
	'sign-viewfield-address' => '地址',
	'sign-viewfield-city' => '城市',
	'sign-viewfield-state' => '州份/省份',
	'sign-viewfield-country' => '国家地区',
	'sign-viewfield-zip' => '邮政编号',
	'sign-viewfield-ip' => 'IP地址',
	'sign-viewfield-phone' => '电话',
	'sign-viewfield-email' => '电子邮件',
	'sign-viewfield-age' => '年龄',
	'sign-viewfield-options' => '选项',
	'sign-signatures' => '签名',
	'sign-closed' => '已关闭',
	'sign-viewfield-reviewcomment' => '评论',
	'sign-review-comment' => '评论',
	'sign-uniquequery-similarname' => '近似姓名',
	'sign-uniquequery-similaraddress' => '近似地址',
	'sign-uniquequery-similarphone' => '近似电话',
	'sign-uniquequery-similaremail' => '近似电邮',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'sign-realname' => '姓名：',
	'sign-address' => '街道地址：',
	'sign-city' => '城市：',
	'sign-state' => '州份/省份：',
	'sign-zip' => '郵政編號：',
	'sign-country' => '國家地區：',
	'sign-phone' => '電話號碼：',
	'sign-bday' => '年齡：',
	'sign-email' => '電郵地址：',
	'sign-list-hideaddress' => '不要列出地址',
	'sign-list-hideextaddress' => '不要列出城市、州份／省份、郵政編號或國家地區',
	'sign-list-hidephone' => '不要列出電話',
	'sign-list-hidebday' => '不要列出年齡',
	'sign-list-hideemail' => '不要列出電郵',
	'sign-viewfield-realname' => '姓名',
	'sign-viewfield-address' => '地址',
	'sign-viewfield-city' => '城市',
	'sign-viewfield-state' => '州份/省份',
	'sign-viewfield-country' => '國家地區',
	'sign-viewfield-zip' => '郵政編號',
	'sign-viewfield-ip' => 'IP位址',
	'sign-viewfield-phone' => '電話',
	'sign-viewfield-email' => '電郵',
	'sign-viewfield-age' => '年齡',
	'sign-viewfield-options' => '選項',
	'sign-signatures' => '簽名',
	'sign-closed' => '已關閉',
	'sign-viewfield-reviewcomment' => '評論',
	'sign-review-comment' => '評論',
	'sign-uniquequery-similarname' => '近似姓名',
	'sign-uniquequery-similaraddress' => '近似地址',
	'sign-uniquequery-similarphone' => '近似電話',
	'sign-uniquequery-similaremail' => '近似電郵',
);

