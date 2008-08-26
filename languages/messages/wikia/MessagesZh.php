<?php

$messages = array_merge( $messages, array(
'accountcreated' => '账户已创建',
'accountcreatedtext' => '已创建账户 $1 。',
'add_comment' => '留言',
'addsection' => '留言',
'ajaxLogin1' => '为完成登入动作，請輸入新的密碼。这动作可能会使你跳离编輯頁面，可能会損失編輯結果。',
'allarticles' => '所有页面',
'allmessagesdefault' => '缺省的翻译',
'allmessagesfilter' => '正则表达式过滤条件：',
'allmessagesname' => '名称',
'allnotinnamespace' => '所有页面 (不包括 $1 名字空间)',
'allowemail' => '允许其他用户给您发送电子邮件',
'allpagesfrom' => '显示页面开始自:',
'anoneditwarning' => '\'\'\'注意:\'\'\' 你尚未登入本站，你的IP位置會被記錄在本頁的修訂歷史頁中。',
'anononlyblock' => '仅限匿名用户',
'article' => '文章',
'articletitles' => '页面开始于 \'\'$1\'\'',
'autoredircomment' => '[[WP:AES|←]]重定向到[[$1]]',
'autosumm-blank' => '清空全部内容',
'autosumm-new' => '新頁面: $1',
'badaccess-group0' => '你所请求执行的操作被禁止。',
'badaccess-group1' => '你所请求执行的操作仅限于 $1 组成员。',
'badaccess-group2' => '你所请求执行的操作仅限于 $1 组成员。',
'badaccess-groups' => '你所请求执行的操作仅限于 $1 组成员。',
'badaccess' => '拒绝访问',
'badsig' => '错误的原始签名；请检查HTML标签。',
'block-log-flags-anononly' => '仅匿名用戶',
'block-log-flags-nocreate' => '创建账户已禁用',
'blocked-mailpassword' => '你的IP地址已经被查封而无法编辑，为了防止滥用而停用了你的密码恢复功能。',
'blockededitsource' => '你对\'\'\'$1\'\'\'进行\'\'\'编辑\'\'\'的文字如下:',
'blocklogtext' => '这是关于用户查封和解封操作的日志。 
被自动查封的IP地址没有被列出。请参看[[Special:Ipblocklist|被查封的IP地址和用户列表]]。',
'bold_sample' => '粗体文字',
'booksources-text' => '以下是一份销售新书或二手书的列表，并可能有你正寻找的书的进一步信息：',
'booksources' => '站外书源',
'brokenredirects-delete' => '(删除)',
'brokenredirects-edit' => '(编辑)',
'cachederror' => '下面的页面是被请求页面在缓存中的一个副本，可能不是最新版本的。',
'cannotundelete' => '恢复失败；可能先前已经被人恢复。',
'cantcreateaccounttitle' => '不能创建帐户',
'cantrollback' => '无法恢复编辑；最后的参与者是本文的唯一作者。',
'captcha-createaccount-fail' => '验证码错误或丢失',
'captcha-createaccount' => '为了防止程序自动添加垃圾链接。你需要输入以下图片中显示的文字才能注册帐户：<br />([[Special:Captcha/help|这是什么？]])',
'captchahelp-text' => '象本站一样，对公众开放编辑的站点经常被垃圾链接骚扰。那些人使用自动化垃圾程序将他们的链接张贴到很多站点。虽然这些链接可以被清除，但是这些东西确实令人十分讨厌。

有时，特别是当给一个页面添加新的网页链接时，本站会让你看一幅有颜色的或者有变形文字的图像，并且要你输入所显示的文字。因为这是难以自动完成的一项任务，它将允许人保存他们的编辑，同时阻止大多数发送垃圾邮件者和其他机器人的攻击。 

令人遗憾是，这会使得视力不好的人，或者使用基于文本或者基于声音的浏览器的用户感到不便。而目前我们还没有提供的音频的选择。如果这正好阻止你进行正常的编辑，请和管理员联系获得帮助。 

单击你浏览器中的“后退”按钮返回你所编辑的页面。',
'captchahelp-title' => 'Captcha 帮助',
'cascadeprotected' => '{{#ifexist:{{FULLPAGENAME}}|這個頁面已經被保護，因為這個頁面被以下已標註「連鎖保護」的被保護頁-{面}-包含：|
<div style="background-color: #eee; border: 1px solid #aa8; margin: 0.5em; padding: 0.5em;" class="plainlinks">\'\'\'本页已经被删除，并被[[wikipedia:頁面保護方針|保护]]以防止重复创建。除非您有正当的理由，请不要新建该条目。\'\'\'
[[Image:Icono archivo borrar.png|80px|right|]]
如果您正在搜寻关于这个题目的信息，你可以[http://zh.wikipedia.org/wiki/Special:Search?search={{FULLPAGENAMEE}}&fulltext=Search 搜索“{{FULLPAGENAME}}”]其他条目。

*删除的原因请参见[[Wikipedia:可以快速删除的条目的标准|可以快速删除的条目的标准]]，[[Wikipedia:删除投票/侵权]]，[[Wikipedia:删除投票和请求|删除投票和请求]]。 
*本页被删除的历史记录可以在\'\'\'[{{fullurl:Special:Log|page={{FULLPAGENAMEE}}}} 它的活动日志]\'\'\'中找到。或者也可以联系保护本页的[[wikipedia:管理员|管理员]]了解详情。
*如果你是从其他条目的链接中来到本页，你可以帮助维基百科移除这个[[Special:Whatlinkshere/{{FULLPAGENAME}}|错误的链接]]。
*恢复或者编辑这个条目，请在{{#switch:{{NAMESPACE}}
|Category|Help|Portal|Template|Image|User|Wikipedia|=[[{{TALKPAGENAME}}|讨论页]]}}或者[[wikipedia:删除检讨|删除检讨]]中提出请求。
*管理员可以在[[Special:Undelete/{{FULLPAGENAME}}]]查看页面的历史和内容。
</div>

您可以在以下的頁面找到有關的資訊：
}}',
'cascadeprotectedwarning' => '\'\'\'警告：\'\'\'本頁已經被保護，只有擁有管理員權限的用戶才可修改，因為本頁已被以下連鎖保護的頁面所包含：',
'category-media-count' => '本分类中{{PLURAL:$1|只有一个文件|共有$1个文件}}。',
'category-media-header' => '類別「$1」中的媒體檔',
'categorytree-header' => '在此可以查詢以分類的樹狀結構。

注意： 本特殊頁面使用[[AJAX]]技術，如果您的瀏覽器非常老舊，或者是關閉了[[JavaScript]]，本頁面將會無法正常運作。',
'categorytree-load' => '查詢此分類其下的子分類',
'categorytree-loading' => '載入中…',
'categorytree-mode-all' => '所有页面',
'categorytree-mode-pages' => '除去图像页面',
'categorytree-no-subcategories' => '沒有任何子分類',
'categorytree-not-found' => '找不到分類<b>$1</b>。',
'categorytree-nothing-found' => '找不到任何項目。',
'categorytree-show-list' => '以清單顯示',
'categorytree-show-tree' => '以樹狀顯示',
'categorytree-tab' => '树形目录',
'categorytree-too-many-subcats' => '子分類太多，無法顯示。',
'categorytree' => '分类树',
'changed' => '被改变',
'cite' => '引用文章',
'cite_croak' => '引用阻塞; $1: $2',
'cite_error' => '引用错误 $1; $2',
'cite_error_-1' => '内部错误；非法的 $str',
'cite_error_-2' => '内部错误；非法键值',
'cite_error_-3' => '内部错误；非法键值',
'cite_error_-4' => '内部错误；非法堆栈键值',
'cite_error_1' => '无效请求；需要一个非整数的键值',
'cite_error_2' => '无效请求；没有特定键值',
'cite_error_3' => '无效请求；非法键值，例如：过多或错误的特定键值',
'cite_error_4' => '无效请求；没有指定的输入',
'cite_error_5' => '无效请求；需求为空',
'cite_error_6' => '非法参数；需求为空',
'cite_error_7' => '过时的自定义后退标签，现在可在标签 "\'\'cite_references_link_many_format_backlink_labels\'\'" 定义更多信息',
'community' => '社群',
'compareselectedversions' => '比较被选版本',
'confirm_purge' => '清除本页缓存？

$1',
'confirmedittext' => '在编辑页面前你需要确认你的电子邮件地址。请在[[Special:Preferences|参数设定]]中设置并验证你的电子邮件地址。',
'confirmedittitle' => '编辑前需要验证你的电子邮件地址',
'confirmemail' => '确认电子邮件地址',
'confirmemail_error' => '你的确认过程发生错误.',
'confirmemail_invalid' => '不正确的确认码. 这个确认码已经过期.',
'confirmemail_loggedin' => '您的电子邮件已被确认.',
'confirmemail_noemail' => '你没有在账户的[[Special:Preferences|参数设置]]中验证你的电子邮件地址。',
'confirmemail_send' => '寄出确认码',
'confirmemail_sendfailed' => '不能发出确认信件. 请检查地址中是否包括不可用的字符.',
'confirmemail_sent' => '确认信已发出',
'confirmemail_success' => '您的电子邮件地址已经确认. 您现在可以登入并开始享受您的Wikia之旅了.',
'confirmemail_text' => '您需要先确认电子邮件地址，您才能收到通过Wikia送出的电子邮件。请点击下方的确认按钮，这将会向您所登记的地址发出确认信件。确认信包括一个含有确认码的超连结，您在浏览器中打开这个连结即可完成确认。如果你已经通过验证，请参看[[Special:Preferences|您的参数设置]]。',
'confirmprotect' => '确认保护',
'confirmrecreate' => '在你编辑这个条目後, 用户[[User:$1|$1]]([[User talk:$1|讨论]])以下列原因删除了这个条目:
: \'\'$2\'\'
请在重新创建条目前三思.',
'copyrightwarning' => '{| style="width:100%; padding: 5px; font-size: 95%;"
|- valign="top"
|
{{SITENAME}}的所有文本資料均依GNU自由文檔許可證（GFDL）的條款釋出(請見$1）<br/>
您對文章所做的更動，將會被所有讀者立即看見。 \'\'\'請在此下欄簡述您更動的動作或修改目的。\'\'\'

<div style="font-weight: bold; font-size: 120%;">在未得到著作權利人准許的情況下，\'\'\'請勿發佈受著作權保護的資料\'\'\'。</div>

| NOWRAP |
* \'\'\'[[Special:Upload|上傳]]\'\'\'圖片
* 別忘了將發表的文章加上\'\'\'[[Special:Categories|分類]]\'\'\'!
* 如果您想測試Wiki的功能，可以前往沙盒進行測試。\'\'\'
<div><small>\'\'[[MediaWiki:Copyrightwarning|檢視此模板]]\'\'</small></div>
|}',
'copyrightwarning2' => '请注意您在{{SITENAME}}所做出的所有贡献都可能被其他贡献者编辑, 修改或删除.
如果您不想您写的文章被他人修改, 请不要在这里提交.<br />
你也必须向我们保证你所写的一切都出自你自己的笔下, 或者是复制于公共领域或其他类似的自由来源(详情请参见 $1).
<strong>请不要在未获授权的情况下发表受版权保护的作品！</strong>',
'createaccountblock' => '禁止创建帐户',
'createarticle' => '创建新条目',
'created' => '已被创建',
'createpage' => '新增文章',
'createpage_button' => '新增文章',
'creditspage' => '页面作者',
'currentevents-url' => 'Portal:新聞動態',
'currentrevisionlink' => '查看当前版本',
'data' => '数据',
'databasenotlocked' => '数据库未被锁定。',
'datedefault' => '默认值',
'dateformat' => '日期格式',
'datetime' => '日期和时间',
'dberrortextcl' => '发生了一个数据库查询语法错误。
最后一次的数据库查询是：
“$1”
来自于函数“$2”。
MySQL返回错误“$3: $4”。',
'deadendpages' => '斷鏈頁面',
'deadendpagestext' => '以下页面没有链接到本站的其他页面。',
'defemailsubject' => 'Wikia电子邮件',
'delete' => '刪除',
'delete_and_move' => '删除并移动',
'delete_and_move_confirm' => '确认删除本页面',
'delete_and_move_reason' => '删除以便移动',
'delete_and_move_text' => '==删除请求==

目标页面 "[[$1]]"已经存在。你确认需要删除原页面并以进行移动吗？',
'deletedcontributions' => '被删除的用户贡献',
'deletedrev' => '[已删除]',
'deletedrevision' => '$1的旧版本已被删除。',
'descending_abbrev' => '降序',
'destfilename' => '重新命名档案',
'diff-multi' => '({{plural:$1|一個中途的修訂版本|$1 個中途的修訂版本}}沒有顯示。)',
'disclaimerpage' => '{{ns:4}}:免责声明',
'download' => '下载',
'dynamicpagelistsp' => '動態文章列表',
'eauthentsent' => '一封确认信已经发送到推荐的地址.
在发送其他邮件前, 您必须首先依照这封信中的指导确认这个电子信箱真实有效.',
'edit-externally-help' => '请参看[http://meta.wikimedia.org/wiki/Help:External_editors 安装说明]了解详细信息。',
'edit-externally' => '使用外部程序编辑这个文件',
'edit' => '编辑',
'editcomment' => '编辑的评论为：“<i>$1</i>”。',
'editcount' => '編輯統計',
'editinginterface' => '\'\'\'警告：\'\'\'你正在编辑的页面将用于软件的界面显示。更改本页面将影响其他用户的界面显示。',
'edittools' => '<!-- Text here will be shown below edit and upload forms. -->
<div style="margin-top: 2em; margin-bottom:1em;">以下為幾個常用的符號，點選你想要的符號後，它會立即出現在編輯框中你所指定的位置。</div>

<div id="editpage-specialchars" class="plainlinks" style="border-width: 1px; border-style: solid; border-color: #aaaaaa; padding: 2px;">
<span id="edittools_main">\'\'\'符號:\'\'\' <charinsert>– — … ° ≈ ≠ ≤ ≥ ± − × ÷ ← → · § </charinsert></span><span id="edittools_name">&nbsp;&nbsp;\'\'\'簽名:\'\'\' <charinsert>~~&#126;~</charinsert></span>
----
<small><span id="edittools_wikimarkup">\'\'\'Wiki語法:\'\'\'
<charinsert><nowiki>{{</nowiki>+<nowiki>}}</nowiki> </charinsert> &nbsp;
<charinsert><nowiki>|</nowiki></charinsert> &nbsp;
<charinsert>[+]</charinsert> &nbsp;
<charinsert>[[+]]</charinsert> &nbsp;
<charinsert>[[Category:+]]</charinsert> &nbsp;
<charinsert>#REDIRECT&#32;[[+]]</charinsert> &nbsp;
<charinsert><s>+</s></charinsert> &nbsp;
<charinsert><sup>+</sup></charinsert> &nbsp;
<charinsert><sub>+</sub></charinsert> &nbsp;
<charinsert><code>+</code></charinsert> &nbsp;
<charinsert><blockquote>+</blockquote></charinsert> &nbsp;
<charinsert><ref>+</ref></charinsert> &nbsp;
<charinsert><nowiki>{{</nowiki>Reflist<nowiki>}}</nowiki></charinsert> &nbsp;
<charinsert><references/></charinsert> &nbsp;
<charinsert><includeonly>+</includeonly></charinsert> &nbsp;
<charinsert><noinclude>+</noinclude></charinsert> &nbsp;
<charinsert><nowiki>{{</nowiki>DEFAULTSORT:+<nowiki>}}</nowiki></charinsert> &nbsp;
<charinsert>&lt;nowiki>+</nowiki></charinsert> &nbsp;
<charinsert><nowiki><!-- </nowiki>+<nowiki> --></nowiki></charinsert>&nbsp;
<charinsert><nowiki><span class="plainlinks"></nowiki>+<nowiki></span></nowiki></charinsert><br/></span>
<span id="edittools_symbols">\'\'\'符號:\'\'\' <charinsert> ~ | ¡ ¿ † ‡ ↔ ↑ ↓ • ¶</charinsert> &nbsp;
<charinsert> # ¹ ² ³ ½ ⅓ ⅔ ¼ ¾ ⅛ ⅜ ⅝ ⅞ ∞ </charinsert> &nbsp;
<charinsert> ‘ “ ’ ” «+»</charinsert> &nbsp;
<charinsert> ¤ ₳ ฿ ₵ ¢ ₡ ₢ $ ₫ ₯ € ₠ ₣ ƒ ₴ ₭ ₤ ℳ ₥ ₦ № ₧ ₰ £ ៛ ₨ ₪ ৳ ₮ ₩ ¥ </charinsert> &nbsp;
<charinsert> ♠ ♣ ♥ ♦ </charinsert><br/></span>
<!-- Extra characters, hidden by default
<span id="edittools_characters">\'\'\'字母:\'\'\'
<span class="latinx">
<charinsert> Á á Ć ć É é Í í Ĺ ĺ Ń ń Ó ó Ŕ ŕ Ś ś Ú ú Ý ý Ź ź </charinsert> &nbsp;
<charinsert> À à È è Ì ì Ò ò Ù ù </charinsert> &nbsp;
<charinsert> Â â Ĉ ĉ Ê ê Ĝ ĝ Ĥ ĥ Î î Ĵ ĵ Ô ô Ŝ ŝ Û û Ŵ ŵ Ŷ ŷ </charinsert> &nbsp;
<charinsert> Ä ä Ë ë Ï ï Ö ö Ü ü Ÿ ÿ </charinsert> &nbsp;
<charinsert> ß </charinsert> &nbsp;
<charinsert> Ã ã Ẽ ẽ Ĩ ĩ Ñ ñ Õ õ Ũ ũ Ỹ ỹ</charinsert> &nbsp;
<charinsert> Ç ç Ģ ģ Ķ ķ Ļ ļ Ņ ņ Ŗ ŗ Ş ş Ţ ţ </charinsert> &nbsp;
<charinsert> Đ đ </charinsert> &nbsp;
<charinsert> Ů ů </charinsert> &nbsp;
<charinsert> Ǎ ǎ Č č Ď ď Ě ě Ǐ ǐ Ľ ľ Ň ň Ǒ ǒ Ř ř Š š Ť ť Ǔ ǔ Ž ž </charinsert> &nbsp;
<charinsert> Ā ā Ē ē Ī ī Ō ō Ū ū Ȳ ȳ Ǣ ǣ </charinsert> &nbsp;
<charinsert> ǖ ǘ ǚ ǜ </charinsert> &nbsp;
<charinsert> Ă ă Ĕ ĕ Ğ ğ Ĭ ĭ Ŏ ŏ Ŭ ŭ </charinsert> &nbsp;
<charinsert> Ċ ċ Ė ė Ġ ġ İ ı Ż ż </charinsert> &nbsp;
<charinsert> Ą ą Ę ę Į į Ǫ ǫ Ų ų </charinsert> &nbsp;
<charinsert> Ḍ ḍ Ḥ ḥ Ḷ ḷ Ḹ ḹ Ṃ ṃ Ṇ ṇ Ṛ ṛ Ṝ ṝ Ṣ ṣ Ṭ ṭ </charinsert> &nbsp;
<charinsert> Ł ł </charinsert> &nbsp;
<charinsert> Ő ő Ű ű </charinsert> &nbsp;
<charinsert> Ŀ ŀ </charinsert> &nbsp;
<charinsert> Ħ ħ </charinsert> &nbsp;
<charinsert> Ð ð Þ þ </charinsert> &nbsp;
<charinsert> Œ œ </charinsert> &nbsp;
<charinsert> Æ æ Ø ø Å å </charinsert> &nbsp;
<charinsert> Ə ə </charinsert></span>&nbsp;<br/></span>
<span id="edittools_greek">\'\'\'希臘字母:\'\'\'
<charinsert> Ά ά Έ έ Ή ή Ί ί Ό ό Ύ ύ Ώ ώ </charinsert> &nbsp; 
<charinsert> Α α Β β Γ γ Δ δ </charinsert> &nbsp;
<charinsert> Ε ε Ζ ζ Η η Θ θ </charinsert> &nbsp;
<charinsert> Ι ι Κ κ Λ λ Μ μ </charinsert> &nbsp;
<charinsert> Ν ν Ξ ξ Ο ο Π π </charinsert> &nbsp;
<charinsert> Ρ ρ Σ σ ς Τ τ Υ υ </charinsert> &nbsp;
<charinsert> Φ φ Χ χ Ψ ψ Ω ω </charinsert> &nbsp;<br/></span>
<span id="edittools_cyrillic">\'\'\'Cyrillic:\'\'\' <charinsert> А а Б б В в Г г </charinsert> &nbsp;
<charinsert> Ґ ґ Ѓ ѓ Д д Ђ ђ </charinsert> &nbsp;
<charinsert> Е е Ё ё Є є Ж ж </charinsert> &nbsp;
<charinsert> З з Ѕ ѕ И и І і </charinsert> &nbsp;
<charinsert> Ї ї Й й Ј ј К к </charinsert> &nbsp;
<charinsert> Ќ ќ Л л Љ љ М м </charinsert> &nbsp;
<charinsert> Н н Њ њ О о П п </charinsert> &nbsp;
<charinsert> Р р С с Т т Ћ ћ </charinsert> &nbsp;
<charinsert> У у Ў ў Ф ф Х х </charinsert> &nbsp;
<charinsert> Ц ц Ч ч Џ џ Ш ш </charinsert> &nbsp;
<charinsert> Щ щ Ъ ъ Ы ы Ь ь </charinsert> &nbsp;
<charinsert> Э э Ю ю Я я </charinsert> &nbsp;<br/></span>
<span id="edittools_ipa">\'\'\'IPA:\'\'\' <span title="Pronunciation in IPA" class="IPA"><charinsert>t̪ d̪ ʈ ɖ ɟ ɡ ɢ ʡ ʔ </charinsert> &nbsp;
<charinsert> ɸ ʃ ʒ ɕ ʑ ʂ ʐ ʝ ɣ ʁ ʕ ʜ ʢ ɦ </charinsert> &nbsp;
<charinsert> ɱ ɳ ɲ ŋ ɴ </charinsert> &nbsp;
<charinsert> ʋ ɹ ɻ ɰ </charinsert> &nbsp;
<charinsert> ʙ ʀ ɾ ɽ </charinsert> &nbsp;
<charinsert> ɫ ɬ ɮ ɺ ɭ ʎ ʟ </charinsert> &nbsp;
<charinsert> ɥ ʍ ɧ </charinsert> &nbsp;
<charinsert> ɓ ɗ ʄ ɠ ʛ </charinsert> &nbsp;
<charinsert> ʘ ǀ ǃ ǂ ǁ </charinsert> &nbsp;
<charinsert> ɨ ʉ ɯ </charinsert> &nbsp;
<charinsert> ɪ ʏ ʊ </charinsert> &nbsp;
<charinsert> ɘ ɵ ɤ </charinsert> &nbsp;
<charinsert> ə ɚ </charinsert> &nbsp;
<charinsert> ɛ ɜ ɝ ɞ ʌ ɔ </charinsert> &nbsp;
<charinsert> ɐ ɶ ɑ ɒ </charinsert> &nbsp;
<charinsert> ʰ ʷ ʲ ˠ ˤ ⁿ ˡ </charinsert> &nbsp;
<charinsert> ˈ ˌ ː ˑ  ̪ </charinsert>&nbsp;</span><br/></span>
-->
</small></div>
<span style="float:right;"><small>\'\'[[MediaWiki:Edittools|檢視此模板]]\'\'</small></span>',
'editusergroup' => '编辑用户组',
'email' => '电子邮件',
'emailauthenticated' => '您的电子邮件地址已经於 $1 确认有效.',
'emailccme' => '将我的消息通过电子邮件发送一份副本。',
'emailccsubject' => '复制你的消息到 $1: $2',
'emailconfirmlink' => '确认您的电邮地址',
'emailnotauthenticated' => '您的电子邮件地址<strong>还未被认证</strong>. 下述的功能将不会向您发出电子邮件.',
'emptyfile' => '您上传的这个文件似乎没有内容。这可能是由于输入了错误的文件名。请检查并确定您真的需要上传这个文件。',
'enotif_body' => '亲爱的$WATCHINGUSERNAME,

{{SITENAME}}上的 $PAGETITLE 页面已经在 $PAGEEDITDATE 被 $PAGEEDITOR 进行了 $CHANGEDORCREATED 操作, 请前往 $PAGETITLE_URL 查看最新版本.

$NEWPAGE

编辑摘要为: $PAGESUMMARY $PAGEMINOREDIT

联络这位编辑者:
邮件: $PAGEEDITOR_EMAIL
维基: $PAGEEDITOR_WIKI

除非您访问该页, 否则我们不会再发出下一次更改通知. 你对您的监视列表中需要通知的页面重置通知标签.


真诚的,             
    {{SITENAME}} 邮件通知系统

--
改变您的监视列表设置请访问
{{SERVER}}{{localurl:Special:Watchlist/edit}}

反馈与帮助:
{{SERVER}}{{localurl:Help:Contents}}',
'enotif_lastvisited' => '查看您上次访问後的所有更改请访问 $1 .',
'enotif_mailer' => '{{SITENAME}} 邮件通知机器人',
'enotif_newpagetext' => '这是一个新建页面.',
'enotif_reset' => '把所有页面标记为已访问',
'enotif_subject' => '{{SITENAME}} 上的 $PAGETITLE 页已经被 $PAGEEDITOR 执行过 $CHANGEDORCREATED 操作',
'exbeforeblank' => '空白之前的内容是：',
'exblank' => '空白页面',
'excontent' => '内容为：\'$1\'',
'excontentauthor' => '内容为：\'$1\'（而且贡献者只有[[Special:Contributions/$2|$2]] | [[User talk:$2|Talk]]）',
'exif-aperturevalue' => '光圈',
'exif-artist' => '作者',
'exif-bitspersample' => '每象素字元长',
'exif-brightnessvalue' => '亮度',
'exif-cfapattern' => 'CFA模式<!--色彩滤镜阵列?-->',
'exif-colorspace' => '颜色空间',
'exif-componentsconfiguration-0' => '不存在',
'exif-componentsconfiguration' => '每分量含义',
'exif-compressedbitsperpixel' => '图像压缩模式',
'exif-compression-1' => '未压缩',
'exif-compression' => '压缩模式',
'exif-contrast-0' => '标准',
'exif-contrast-1' => '低',
'exif-contrast-2' => '髙',
'exif-contrast' => '对比度',
'exif-copyright' => '版权所有者',
'exif-customrendered-0' => '标准处理',
'exif-customrendered-1' => '自定义处理',
'exif-customrendered' => '自定义图像处理',
'exif-datetime' => '文件更改的日期与时间',
'exif-datetimedigitized' => '数字化的日期与时间',
'exif-datetimeoriginal' => '数据生成的日期与时间',
'exif-devicesettingdescription' => '设备设定描述',
'exif-digitalzoomratio' => '数字变焦比率',
'exif-exifversion' => 'Exif 版本',
'exif-exposurebiasvalue' => '曝光补偿',
'exif-exposureindex' => '曝光指数',
'exif-exposuremode-0' => '自动曝光',
'exif-exposuremode-1' => '手动曝光',
'exif-exposuremode-2' => '自动曝光感知调节',
'exif-exposuremode' => '曝光模式',
'exif-exposureprogram-0' => '未定义',
'exif-exposureprogram-1' => '手动',
'exif-exposureprogram-2' => '标准程序',
'exif-exposureprogram-3' => '光圈优先模式',
'exif-exposureprogram-4' => '快门优先模式',
'exif-exposureprogram-5' => '艺术程序(景深优先)',
'exif-exposureprogram-6' => '运动程序(快速快门速度优先)',
'exif-exposureprogram-7' => '肖像模式(适用于背景在焦距以外的近距摄影)',
'exif-exposureprogram-8' => '风景模式(适用于背景在焦距上的风景照片)',
'exif-exposureprogram' => '曝光模式',
'exif-exposuretime-format' => '$1 秒 ($2)',
'exif-exposuretime' => '曝光时间',
'exif-filesource' => '文件源',
'exif-flash' => '闪光灯',
'exif-flashenergy' => '闪光灯强度',
'exif-flashpixversion' => '支持的Flashpix版本',
'exif-fnumber' => '光圈（F值）',
'exif-focallength' => '焦距',
'exif-focallengthin35mmfilm' => '35毫米胶片焦距',
'exif-focalplaneresolutionunit-2' => '吋',
'exif-focalplaneresolutionunit' => '焦平面解析单位',
'exif-focalplanexresolution' => 'X轴焦平面解析度',
'exif-focalplaneyresolution' => 'Y轴焦平面解析度',
'exif-gaincontrol-0' => '無',
'exif-gaincontrol-1' => '低增益',
'exif-gaincontrol-2' => '髙增益',
'exif-gaincontrol-3' => '低减益',
'exif-gaincontrol-4' => '高减益',
'exif-gaincontrol' => '场景控制',
'exif-gpsaltitude' => '海拔',
'exif-gpsaltituderef' => '海拔正负参照',
'exif-gpsareainformation' => 'GPS区域名称',
'exif-gpsdatestamp' => 'GPS日期',
'exif-gpsdestbearing' => '目标方位',
'exif-gpsdestbearingref' => '目标方位参照',
'exif-gpsdestdistance' => '目标距离',
'exif-gpsdestdistanceref' => '目标距离参照',
'exif-gpsdestlatitude' => '纬度目标',
'exif-gpsdestlatituderef' => '目标的纬度参照',
'exif-gpsdestlongitude' => '目标的经度',
'exif-gpsdestlongituderef' => '目标的经度的参照',
'exif-gpsdifferential' => 'GPS差动修正',
'exif-gpsdirection-m' => '地磁方位',
'exif-gpsdirection-t' => '真方位',
'exif-gpsdop' => '测量精度',
'exif-gpsimgdirection' => '图像方位',
'exif-gpsimgdirectionref' => '图像方位参照',
'export' => '導出頁面',
'filedesc' => '简述',
'footer_1.5' => '快来编修本页',
'footer_1' => '想改善 $1 ?',
'footer_10' => '与$1分享',
'footer_2' => '发表意见',
'footer_5' => '最近编辑：$1 $2',
'footer_6' => '随机页面',
'footer_7' => '转寄本文',
'footer_8' => '加到网路书签',
'footer_9' => '打分数',
'footer_About_Wikia' => '[http://www.wikia.com/wiki/About_Wikia 关於Wikia]',
'footer_Advertise_on_Wikia' => '[http://www.wikia.com/wiki/Advertising 广告合作]',
'footer_Contact_Wikia' => '[http://www.wikia.com/wiki/Contact_us 联络Wikia]',
'footer_Terms_of_use' => '[http://www.wikia.com/wiki/Terms_of_use 使用条款]',
'history_short' => '沿革',
'importfreeimages' => '匯入自由版權圖片',
'invitespecialpage' => '邀請朋友加入Wikia',
'listredirects' => '重定向頁面列表',
'monaco-articles-on' => '現有$1篇文章<br />',
'monaco-edit-this-menu' => '編輯此選單',
'monaco-gaming' => '遊戲',
'monaco-latest' => '最近更新',
'monaco-toolbox' => '* randompage-url|隨機頁面
* upload-url|上傳檔案
* whatlinkshere|鏈入頁面
* recentchanges-url|最近更新
* specialpages-url|特殊頁面
* helppage|使用說明',
'monaco-welcome-back' => '歡迎回來，<b>$1</b><br />',
'monaco-whos-online' => '誰在線上？',
'monaco-widgets' => '小工具',
'mostlinked' => '最多被連結的頁面',
'mostlinkedcategories' => '最多被使用的分類',
'mostrevisions' => '最多修訂的文章',
'move' => '移動',
'my_profile' => '个人档案',
'mypreferences' => '用戶设定',
'myprofile' => '个人档案',
'new_article' => '新增文章',
'new_wiki' => '申请 wiki',
'newarticletext' => '<div style="float:right;"><small>\'\'[[MediaWiki:Newarticletext|檢視此模板]]\'\'</small></div>
\'\'\'您正準備開始撰寫一個新頁面\'\'\'
* 如有編輯問題，歡迎參考[[{{ns:project}}:帮助|幫助頁面]]
* 小叮嚀：別忘了為你的文章加上分類，只要在頁面底部加上<nowiki>[[Category:分類名]]</nowiki>即可。所有分類請見[[Special:Categories]]。<br/><br/>',
'newimages' => '新圖像',
'noarticletext' => '\'\'\'喔喔！ {{SITENAME}}還沒有以{{NAMESPACE}}為題的文章。\'\'\'
* \'\'\'<span class="plainlinks">[{{fullurl:{{FULLPAGENAMEE}}|action=edit}} 點此]開始編輯這個頁面</span>\'\'\'或\'\'\'<span class="plainlinks">[{{fullurl:Special:Search|search={{PAGENAMEE}}}} 點此]在此Wiki中搜尋此詞彙</span>\'\'\'.
* 如果以此為題的文章曾經存在，請查尋\'\'\'<span class="plainlinks">[{{fullurl:Special:Log/delete|page={{FULLPAGENAMEE}}}} 刪除記錄]</span>\'\'\'.',
'nstab-main' => '正文',
'permalink' => '固定链结',
'prefixindex' => '前缀索引',
'prefs-help-email' => '*<strong>电子邮件</strong>（可选）：让他人通过网站在不知道您的电子邮件地址的情况下通过电子邮件与您联络，以及通过电子邮件取得遗忘的密码。',
'protectedpages' => '被保護的頁面',
'rcnote' => '以下是在$3，最近\'\'\'$2\'\'\'天内的\'\'\'$1\'\'\'次最近更改记录:',
'rcshowhideanons' => '$1 匿名用戶',
'rcshowhidebots' => '$1 机器人',
'rcshowhideenhanced' => '$1 折頁式顯示模式',
'rcshowhideliu' => '$1 登入用戶',
'recentchanges_combined' => '最近更改',
'recentchangestext' => '<span style="float:right;"><small>\'\'[[MediaWiki:Recentchangestext|View this template]]\'\'</small></span>
此頁為本站最近更新的內容：

{| class="plainlinks" style="background: transparent; margin-left:0.5em; margin-bottom:0.5em;" cellpadding="0" cellspacing="0"
|-valign="top"
|align="right"|\'\'\'記錄&nbsp;:&nbsp;\'\'\'
|align="left" |[[Special:Newpages|最新文章]] - [[Special:Newimages|最新檔案]] - [[Special:Log/delete|刪除]] - [[Special:Log/move|移動頁面]] - [[Special:Log/upload|上傳記錄]] - [[Special:Log/block|封鎖]] - [[Special:Log|更多記錄...]]
|-valign="top"
|align="right"|\'\'\'特殊頁面&nbsp;:&nbsp;\'\'\'
|align="left" |[[Special:Wantedpages|請求頁面]] - [[Special:Longpages|長頁面]] - [[Special:Uncategorizedimages|未分類圖片]] - [[Special:Uncategorizedpages|未分類文章]] - [[Special:Specialpages|更多特殊頁面...]]
|}',
'reportproblem' => '問題回報',
'see_more' => '更多內容...',
'shared-problemreport' => '回報問題',
'showdiff' => '显示差異',
'sitestatstext' => '__NOTOC__
{| class="plainlinks" align="top" width="100%"
| valign="top" width="50%" | 
===頁面統計===
\'\'\'{{SITENAME}}共有$1 [[Special:Allpages|頁面]]\'\'\' ([[Special:Newpages|新文章]]):

*\'\'\'$2 合理的頁面:\'\'\'
**[[Special:Allpages|主要名字空間]]
**存在一個內部鏈結
**可能為[[Special:Shortpages|短頁面]]或[[Special:Longpages|長頁面]]
**可能為[[Special:Disambiguations|消歧異頁]]
**可能為[[Special:Lonelypages|孤立頁面]]

*非文章頁，例如:
**主要名字空間外的頁面<br/>(例如模板頁、討論頁)
**[[Special:Listredirects|重定向頁]] ([[Special:BrokenRedirects|失效的重定向頁]]/[[Special:DoubleRedirects|重覆重定向頁]])
**[[Special:Deadendpages|終點頁]]

| valign="top" width="50%" |

===其他統計===
*\'\'\'$8 [[Special:Imagelist|圖片]]\'\'\' ([[Special:Newimages|新進圖片]])
*\'\'\'$4\'\'\' 頁編輯數 / \'\'\'$1\'\'\' 頁數 = \'\'\'$5\'\'\' 編輯數/頁數 ([[Special:Mostrevisions|最多修訂]])

=== 工作排程 ===
*目前的[http://meta.wikimedia.org/wiki/Help:Job_queue 工作隊列]長度為\'\'\'$7\'\'\'

===進階資訊===
* [[Special:Specialpages|特殊頁面]]
* [[Special:Allmessages|系統介面]]

想知道更多的統計資料，請使用Wikia中心的\'\'\'[[Wikia:Wikia:Statistics|WikiStats]]\'\'\'。
|}',
'subcategorycount' => '在这个分类中有{{PLURAL:$1|is one subcategory| $1}}个亚类，請見{{PLURAL:$1|以下}}。{{PLURAL:$1||更多分類可見於更次一級的分類}}。',
'talkpagetext' => '<div style="margin: 0 0 1em; padding: .5em 1em; vertical-align: middle; border: solid #999 1px;">\'\'\'這是一個討論。請在您的留言後面加上四個波折號簽名。 (<code><nowiki>~~~~</nowiki></code>)\'\'\'</div>',
'tooltip-pt-userpage' => '个人用戶页',
'uncategorizedcategories' => '待分類類別',
'uncategorizedimages' => '待分類圖像',
'uncategorizedpages' => '待分類頁面',
'unwatch' => '取消監視',
'uploadbtn' => '上传档案',
'widgets' => 'Widgets列表',
) );
