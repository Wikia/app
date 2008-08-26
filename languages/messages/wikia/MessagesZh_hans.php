<?php

$messages = array_merge( $messages, array(
'add_comment' => '留言',
'addsection' => '留言',
'admin_skin' => '管理员功能',
'ajaxLogin2' => '这动作可能会使你跳离编辑页面，可能会损失编辑结果。确定要离开吗？',
'community' => '社区',
'copyrightwarning' => '{| style="width:100%; padding: 5px; font-size: 95%;"
|- valign="top"
|
{{SITENAME}}的所有文本资料均依GNU自由文档许可证（GFDL）的条款释出(请见$1）<br/>
您对文章所做的更动，将会被所有读者立即看见。 \'\'\'请在此下栏简述您更动的动作或修改目的。\'\'\'

<div style="font-weight: bold; font-size: 120%;">在未得到著作权利人准许的情況下，\'\'\'请勿发佈受著作权保护的资料\'\'\'。</div>

| NOWRAP |
* \'\'\'[[Special:Upload|上传]]\'\'\'图片
* 別忘了将发表的文章加上\'\'\'[[Special:Categories|分类]]\'\'\'!
* 如果您想测试Wiki的功能，可以前往沙盒进行测试。\'\'\'
<div><small>\'\'[[MediaWiki:Copyrightwarning|检视此模板]]\'\'</small></div>
|}',
'createpage_loading_mesg' => '下载中......请稍後。',
'defaultskin_choose' => '设定此站预设皮肤:',
'edit' => '编辑',
'edittools' => '<!-- Text here will be shown below edit and upload forms. -->
<div style="margin-top: 2em; margin-bottom:1em;">以下为几个常用的符号，点选你想要的符号后，它会立即出现在编辑框中你所指定的位置。</div>

<div id="editpage-specialchars" class="plainlinks" style="border-width: 1px; border-style: solid; border-color: #aaaaaa; padding: 2px;">
<span id="edittools_main">\'\'\'符号:\'\'\' <charinsert>– — … ° ≈ ≠ ≤ ≥ ± − × ÷ ← → · § </charinsert></span><span id="edittools_name">&nbsp;&nbsp;\'\'\'签名:\'\'\' <charinsert>~~&#126;~</charinsert></span>
----
<small><span id="edittools_wikimarkup">\'\'\'Wiki语法:\'\'\'
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
<span id="edittools_symbols">\'\'\'符号:\'\'\' <charinsert> ~ | ¡ ¿ † ‡ ↔ ↑ ↓ • ¶</charinsert> &nbsp;
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
<span id="edittools_greek">\'\'\'希腊字母:\'\'\'
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
<span style="float:right;"><small>\'\'[[MediaWiki:Edittools|检视此模板]]\'\'</small></span>',
'multiuploadtext' => '上传档案。 <br/><br/> 点选\'\'\'浏览\'\'\'，选择欲上传的档案，可同时上传1至5件档案。 <br/><br/> <b>档案描述</b>栏位中可填入档案说明，描述图片內容。<br/><br/> <br/> 不当的图片将会被刪除，请见[[Project:Image Deletion Policy|圖像刪除規定]]。<br/><br/>',
'newarticletext' => '<div style="float:right;"><small>\'\'[[MediaWiki:Newarticletext|检视此模板]]\'\'</small></div>
\'\'\'您正準备开始撰写一个新页面\'\'\'
* 如有编辑问题，欢迎参考[[{{ns:project}}:帮助|帮助页面]]
* 小叮咛：別忘了为你的文章加上分类，只要在页面底部加上<nowiki>[[Category:分类名]]</nowiki>即可。所有分类请见[[Special:Categories]]。<br/><br/>',
'noarticletext' => '\'\'\'喔喔！ {{SITENAME}}还沒有以{{NAMESPACE}}为题的文章。\'\'\'
* \'\'\'<span class="plainlinks">[{{fullurl:{{FULLPAGENAMEE}}|action=edit}} 鲇此]开始编辑这个页面</span>\'\'\'或\'\'\'<span class="plainlinks">[{{fullurl:Special:Search|search={{PAGENAMEE}}}} 鲇此]在此Wiki中搜寻此词汇</span>\'\'\'.
* 如果以此为题的文章曾经存在，请查寻\'\'\'<span class="plainlinks">[{{fullurl:Special:Log/delete|page={{FULLPAGENAMEE}}}} 刪除记錄]</span>\'\'\'.',
'problemreports' => '问题回报列表',
'rcnote' => '以下是在$3，最近\'\'\'$2\'\'\'天内的\'\'\'$1\'\'\'次最近更改记录:',
'rcshowhideenhanced' => '$1 折页式显示模式',
'recentchangestext' => '<span style="float:right;"><small>\'\'[[MediaWiki:Recentchangestext|View this template]]\'\'</small></span>
此页为本站最近更新的內容：

{| class="plainlinks" style="background: transparent; margin-left:0.5em; margin-bottom:0.5em;" cellpadding="0" cellspacing="0"
|-valign="top"
|align="right"|\'\'\'记錄&nbsp;:&nbsp;\'\'\'
|align="left" |[[Special:Newpages|最新文章]] - [[Special:Newimages|最新档案]] - [[Special:Log/delete|刪除]] - [[Special:Log/move|移动页面]] - [[Special:Log/upload|上载记錄]] - [[Special:Log/block|封锁]] - [[Special:Log|更多记錄...]]
|-valign="top"
|align="right"|\'\'\'特殊页面&nbsp;:&nbsp;\'\'\'
|align="left" |[[Special:Wantedpages|请求页面]] - [[Special:Longpages|长页面]] - [[Special:Uncategorizedimages|未分类图片]] - [[Special:Uncategorizedpages|未分类文章]] - [[Special:Specialpages|更多特殊页面...]]
|}',
'sitestatstext' => '__NOTOC__
{| class="plainlinks" align="top" width="100%"
| valign="top" width="50%" | 
===页面统计===
\'\'\'{{SITENAME}}共有$1 [[Special:Allpages|页面]]\'\'\' ([[Special:Newpages|新文章]]):

*\'\'\'$2 合理的页面:\'\'\'
**[[Special:Allpages|主要名字空间]]
**存在一个內部链结
**可能为[[Special:Shortpages|短页面]]或[[Special:Longpages|长页面]]
**可能为[[Special:Disambiguations|消歧異页]]
**可能为[[Special:Lonelypages|孤立页面]]

*非文章页，例如:
**主要名字空间外的页面<br/>(例如模板页、讨论页)
**[[Special:Listredirects|重定向页]] ([[Special:BrokenRedirects|失效的重定向页]]/[[Special:DoubleRedirects|重覆重定向页]])
**[[Special:Deadendpages|终鲇页]]

| valign="top" width="50%" |

===其他统计===
*\'\'\'$8 [[Special:Imagelist|图片]]\'\'\' ([[Special:Newimages|新进图片]])
*\'\'\'$4\'\'\' 页编辑数 / \'\'\'$1\'\'\' 页数 = \'\'\'$5\'\'\' 编辑数/页数 ([[Special:Mostrevisions|最多修订]])

=== 工作排程 ===
*目前的[http://meta.wikimedia.org/wiki/Help:Job_queue 工作排程]长度为\'\'\'$7\'\'\'

===进阶资讯===
* [[Special:Specialpages|特殊页面]]
* [[Special:Allmessages|系统介面]]

想知道更多的统计资料，请使用Wikia中心的\'\'\'[[Wikia:Wikia:Statistics|WikiStats]]\'\'\'。
|}',
'stf_back_to_article' => '返回文章',
'stf_frm4_cancel' => '取消',
'subcategorycount' => '在這個分類中有{{PLURAL:$1|is one subcategory| $1}}个亚类。请见{{PLURAL:$1|以下}}。{{PLURAL:$1||更多分类可见於次一级的分类}}。',
'talkpagetext' => '<div style="margin: 0 0 1em; padding: .5em 1em; vertical-align: middle; border: solid #999 1px;">\'\'\'这是一个讨论页。请在您的留言后面加上四个波折号簽名。 (<code><nowiki>~~~~</nowiki></code>)\'\'\'</div>',
'this_user' => '此用戶',
'tog-htmlemails' => '以HTML格式发送邮件',
'whosonline' => '谁在线上？',
'widgets' => 'Widgets列表',
) );
