<?php

$messages = array_merge( $messages, array(
'editingTips' => '<div class="persian" style="direction:rtl">
=چگونه متن را ویرایش کنیم=
شما متن را با \'wikimarkup\' یا HTML می توانید ویرایش کنید.

<br /><nowiki>\'\'کج\'\'</nowiki> به صورت \'\'کج\'\' نمایش می‌یابد.

<br /><nowiki>\'\'\'پُررنگ\'\'\'</nowiki> به صورت \'\'\'پُررنگ\'\'\' نمایش می‌یابد. 

<br /><nowiki>\'\'\'\'\'پررنگ کج\'\'\'\'\'</nowiki> به صورت \'\'\'\'\'پررنگ کج\'\'\'\'\'نمایش می‌یابد. 

----
<br />
<nowiki><s>متن خط خورده</s></nowiki> => <s>متن خط خورده</s>

<br />
<nowiki><u>زیر خط</u></nowiki> => <u>زیر خط</u>

<br />
<nowiki><span style="color:red;">متن قرمز</span></nowiki> => <span style="color:red;">متن قرمز</span>

=شیوهٔ پیونددهی=
برای پیونددهی از دوقلاب یا یک قلاب استفاده می‌شود.

<br />
\'\'\'یک پیوند داخلی ساده:\'\'\'<br />
<nowiki>[[نام مقاله]]</nowiki>

<br />
\'\'\' پیوند داخلی با واژه‌ای به غیر از عنوان مقالهٔ مقصد :\'\'\'<br />
<nowiki>[[نام مقاله|متن من]]</nowiki>

<br />
----

<br />
\'\'\':پیوند بیرونی\'\'\'<br />
<nowiki>[http://www.example.com]</nowiki>

<br />
\'\'\'پیوند بیرونی به همراه نام پیوند:\'\'\'

<nowiki>[http://www.example.com  نام پیوند]</nowiki>

=عنوان و زیر عنوان=
برای عنوان‌ها از علامت مساوی استفاده می‌شود. هر «=» بیشتر عنوان کوچکتر.

<br />
<span style="font-size: 1.6em"><nowiki>==عنوان اصلی==</nowiki></span>

<br />
<span style="font-size: 1.3em"><nowiki>===زیرعنوان===</nowiki></span>

<br />
<nowiki>====یک پله پایین‌تر====</nowiki>

=تورفتگی=
تورفتگی‌ها به سه صورت :تورفتگی ساده،نشانهٔ نکته و خطوط شماره‌گذاری شده می‌باشد. 
<br />
<nowiki> تورفتگی ساده</nowiki><br />
<nowiki>: کمی تورفتگی</nowiki><br />
<nowiki>:: تورفتگی</nowiki><br />
<nowiki>::: تورفتگی بیشتر</nowiki>

<br />
<nowiki>نشانهٔ نکته</nowiki><br />
<nowiki>* اولین فقرهٔ فهرست</nowiki><br />
<nowiki>* دومین فقرهٔ فهرست</nowiki><br />
<nowiki>**زیرفهرست دومین فقرهٔ فهرست</nowiki><br />
<nowiki>* سومین فقرهٔ فهرست</nowiki><br />

<br />
<nowiki>خطوط شماره‌گذاری شده</nowiki><br />
<nowiki># اولین مورد</nowiki><br />
<nowiki># دومین مورد</nowiki><br />
<nowiki>## یک مورد زیر دومین مورد</nowiki><br />
<nowiki># سومین مورد</nowiki>

=چگونه در مقالات تصویر بگذاریم=
تصاویر به صورت زیر در مقالات قرار می‌دهند.

<br />
<nowiki>[[</nowiki>{{ns:image}}:نام.jpg<nowiki>]]</nowiki>

<br />
\'\'\' می‌توانید توضیح مختصری را نیز در پایین قاب اضافه کنید.\'\'\'<br />
<nowiki>[[</nowiki>{{ns:image}}:نام.jpg|alt text<nowiki>]]</nowiki>

<br />
\'\'\'اگر تصویر شما فقط یک نمونه کوچک (thumbnail) از تصویر اصلی است می‌توانید با دستور thumb آن را مشخص کنید.\'\'\'<br />
<nowiki>[[</nowiki>{{ns:image}}:نام.jpg|thumb|<nowiki>]]</nowiki>

<br />
\'\'\'می‌توانید ابعاد تصویر را بر حسب پبکسل تنظیم کنید.\'\'\'<br />
<nowiki>[[</nowiki>{{ns:image}}:نام.jpg|200px|<nowiki>]]</nowiki>

<br />
\'\'\'با به کارگیری تنظیم left تصویر در سمت چپ متن ظاهر می‌شود.\'\'\'<br />
<nowiki>[[</nowiki>{{ns:image}}:نام.jpg|left|<nowiki>]]</nowiki>

<br />
می‌توانید به  صورت زیر همه تنظیمات را با هم انجام دهید.
<br /><nowiki>[[تصویر:نام_فایل_تصویری|تنظیم_یک|تنظیم_دو|....|تنظیم_آخر]]</nowiki>
</div>',
) );
