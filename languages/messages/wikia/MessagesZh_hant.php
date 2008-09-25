<?php

$messages = array_merge( $messages, array(
'add_comment' => '留言',
'addsection' => '留言',
'admin_skin' => '管理員功能',
'ajaxLogin2' => '這動作可能會使你跳離編輯頁面，可能會損失編輯結果。確定要離開嗎？',
'community' => '社群',
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
'createpage_loading_mesg' => '下載中......請稍後。',
'defaultskin_choose' => '設定此站預設面板:',
'edit' => '編輯',
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
'footer_1' => '覺得 $1 不夠好嗎?',
'footer_9' => '打分數',
'monaco-welcome-back' => '歡迎回來， <b>$1</b><br />',
'multipleupload' => '上傳檔案',
'multiuploadtext' => '上傳檔案。 <br/><br/> 點選\'\'\'瀏覽\'\'\'，選擇欲上傳的檔案，可同時上傳1至5個檔案。 <br/><br/> <b>檔案描述</b>欄位中可填入檔案說明，描述圖片內容。<br/><br/> <br/> 不當的圖片將會被刪除，請見[[Project:Image Deletion Policy|圖像刪除規定]]。<br/><br/>',
'newarticletext' => '<div style="float:right;"><small>\'\'[[MediaWiki:Newarticletext|檢視此模板]]\'\'</small></div>
\'\'\'您正準備開始撰寫一個新頁面\'\'\'
* 如有編輯問題，歡迎參考[[{{ns:project}}:帮助|幫助頁面]]
* 小叮嚀：別忘了為你的文章加上分類，只要在頁面底部加上<nowiki>[[Category:分類名]]</nowiki>即可。所有分類請見[[Special:Categories]]。<br/><br/>',
'noarticletext' => '\'\'\'喔喔！ {{SITENAME}}還沒有以{{NAMESPACE}}為題的文章。\'\'\'
* \'\'\'<span class="plainlinks">[{{fullurl:{{FULLPAGENAMEE}}|action=edit}} 點此]開始編輯這個頁面</span>\'\'\'或\'\'\'<span class="plainlinks">[{{fullurl:Special:Search|search={{PAGENAMEE}}}} 點此]在此Wiki中搜尋此詞彙</span>\'\'\'.
* 如果以此為題的文章曾經存在，請查尋\'\'\'<span class="plainlinks">[{{fullurl:Special:Log/delete|page={{FULLPAGENAMEE}}}} 刪除記錄]</span>\'\'\'.',
'problemreports' => '問題回報列表',
'rcnote' => '以下是在$3，最近\'\'\'$2\'\'\'天內的\'\'\'$1\'\'\'次最近更改記錄:',
'rcshowhideenhanced' => '$1 折頁式顯示模式',
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
'shared-problemreport' => '問題回報',
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
'stf_back_to_article' => '返回文章',
'stf_frm4_cancel' => '取消',
'subcategorycount' => '在這個分類中有{{PLURAL:$1|is one subcategory| $1}}個次分類，請見{{PLURAL:$1|以下}}。{{PLURAL:$1||更多分類可見於更次一級的分類}}。',
'talkpagetext' => '<div style="margin: 0 0 1em; padding: .5em 1em; vertical-align: middle; border: solid #999 1px;">\'\'\'這是一個討論頁。請在您的留言後面加上四個波折號簽名。 (<code><nowiki>~~~~</nowiki></code>).\'\'\'</div>',
'this_user' => '此用戶',
'tog-htmlemails' => '以HTML格式發送郵件',
'whosonline' => '誰在線上？',
'widgets' => 'Widgets列表',
'activeusers' => '活躍用戶',
'captcha-badlogin' => '請輸入以下數學算式的答案([[Special:Captcha/help|更多資訊]])：',
'captcha-create' => '請輸入以下數學算式的答案([[Special:Captcha/help|更多資訊]])：',
'createpage' => '新增文章',
'createpage_alternate_creation' => '原始編輯模式請點選 $1',
'createpage_button_caption' => '發布！',
'createpage_caption' => '分類：',
'createpage_categories' => '分類：',
'createpage_categories_help' => '將文章加註分類，可加強這個站上的文章的組織。你可以在下方挑選一個適當的分類，或是直接輸入一個新的分類。',
'createpage_enter_text' => '輸入文字',
'createpage_here' => '這裡',
'createpage_hide_cloud' => '[隱藏分類雲]',
'createpage_show_cloud' => '[顯示分類雲]',
'createpage_title' => '發表新文章',
'createpage_title_caption' => '文章標題',
'createwiki' => '申請wiki',
'createwikipagetitle' => '申請wiki',
'editingtips_enter_widescreen' => '放大編輯',
'editingtips_exit_widescreen' => '退出放大編輯',
'editingtips_hide' => '隱藏編輯小技巧',
'fancycaptcha-badlogin' => '請輸入認證碼([[Special:Captcha/help|更多資訊]])：',
'fancycaptcha-createaccount' => '請輸入認證碼([[Special:Captcha/help|更多資訊]])：',
'footer_1.5' => '快來編輯此頁！',
'footer_2' => '回應此文',
'footer_5' => '修改:$1 - $2',
'footer_6' => '檢視隨機頁面',
'footer_7' => '轉寄此文',
'footer_8' => '分享到網路書籤',
'monaco-articles-on' => '站上共有 $1 篇文章<br />',
'monaco-latest' => '最新動態',
'monaco-toolbox' => '* Special:Search|進階搜尋
* upload-url|上傳圖片
* Special:MultipleUpload|大量上傳
* specialpages-url|特殊頁面
* recentchanges-url|最近更改
* randompage-url|隨機頁面
* whatlinkshere|鏈入頁面
* helppage|說明手冊',
'multipleupload-text' => '大量上傳檔案！

使用\'\'\'瀏覽\'\'\'按鈕選擇要上傳檔案的位置。可同時上傳1至$1個檔案。 你可以選擇輸入\'\'\'目標檔案名\'\'\'和\'\'\'檔案描述\'\'\'來簡述此檔案。不當的檔案將可能被刪除，詳見[[{{MediaWiki:Multipleupload-page}}|檔案刪除政策]]。',
'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
'pr_table_problem_id' => '問題編號',
'pr_table_problem_type' => '问题类型',
'pr_table_reporter_name' => '回報人',
'pr_table_status' => '狀態',
'pr_total_number' => '回報總數',
'pr_view_all' => '顯示所有回報',
'pr_what_problem_change' => '更改問題類型',
'uploadtext-ext' => 'Wikia支援的所有延申套件請見[[{{ns:Special}}:Version|版本頁]]。',
) );
