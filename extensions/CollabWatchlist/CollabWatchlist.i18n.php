<?php
/**
 * Internationalisation file for Collaborative watchlist extension.
 *
 * @file
 * @ingroup Extensions
 */
 
$messages = array();

/** English
 * @author Florian Hackenberger
 */
$messages['en'] = array(
	'collabwatchlist' => 'Collaborative watchlist',
	'collabwatchlist-desc' => 'Provides collaborative watchlists based on categories',
	'specialcollabwatchlist' => 'Collaborative watchlist special page',
	'collabwatchlist-details'    => '{{PLURAL:$1|$1 category/page|$1 categories/pages}} on this collaborative watchlist.',
	'collabwatchlisttagselect' => 'Tag',
	'collabwatchlisttagcomment' => 'Comment',
	'collabwatchlistsettagbutton' => 'Set tag',
	'collabwatchlist-unset-tag' => 'x',
	'collabwatchlisttools-view' => 'Display',
	'collabwatchlisttools-edit' => 'Edit categories',
	'collabwatchlisttools-rawCategories' => 'Raw edit categories',
	'collabwatchlisttools-rawTags' => 'Raw edit tags',
	'collabwatchlisttools-rawUsers' => 'Raw edit users',
	'collabwatchlisttools-delete' => 'Delete',
	'collabwatchlistsall' => 'All lists',
	'collabwatchlistfiltertags' => 'Hide tags',
	'collabwatchlistedit-users-raw-submit' => 'Save',
	'collabwatchlistedit-raw-title' => 'Raw edit categories',
	'collabwatchlistedit-tags-raw-title' => 'Raw edit tags',
	'collabwatchlistedit-users-raw-title' => 'Raw edit users',
	'collabwatchlistedit-users-last-owner' => 'There must at least one owner',
	'collabwatchlistedit-numitems'       => 'This collaborative watchlist contains {{PLURAL:$1|1 category|$1 categories}}',
	'collabwatchlistedit-noitems'        => 'This collaborative watchlist contains no categories.',
	'collabwatchlistedit-tags-numitems'       => 'This collaborative watchlist contains {{PLURAL:$1|1 tag|$1 tags}}',
	'collabwatchlistedit-tags-noitems'        => 'This collaborative watchlist contains no tags.',
	'collabwatchlistedit-users-numitems'       => 'This collaborative watchlist contains {{PLURAL:$1|1 user|$1 users}}',
	'collabwatchlistedit-users-noitems'        => 'This collaborative watchlist contains no users.',
	'collabwatchlistedit-raw-legend' => 'Raw edit collaborative watchlist categories',
	'collabwatchlistedit-users-raw-legend' => 'Raw edit collaborative watchlist users',
	'collabwatchlistedit-tags-raw-legend' => 'Raw edit collaborative watchlist tags',
	'collabwatchlistedit-raw-explain'    => 'Categories on the collaborative watchlist are shown below, and can be edited by adding to and removing from the list.',
	'collabwatchlistedit-tags-raw-explain'    => 'Tags on the collaborative watchlist are shown below, and can be edited by adding to and removing from the list.',
	'collabwatchlistedit-users-raw-explain'    => 'Users on the collaborative watchlist are shown below, and can be edited by adding to and removing from the list.',
	'collabwatchlistedit-raw-titles'     => 'Categories:',
	'collabwatchlistedit-tags-raw-titles'     => 'Tags:',
	'collabwatchlistedit-users-raw-titles'     => 'Users:',
	'collabwatchlistedit-normal-title'   => 'Edit categories',
	'collabwatchlistedit-normal-legend'  => 'Remove categories from collaborative watchlist',
	'collabwatchlistedit-normal-explain' => 'Categories on your collaborative watchlist are shown below.',
	'collabwatchlistedit-tags-raw-submit'    => 'Save',
	'collabwatchlistedit-normal-done'    => '{{PLURAL:$1|1 category was|$1 categories were}} removed from the collaborative watchlist:',
	'collabwatchlistedit-tags-raw-done'    => 'The collaborative watchlist has been updated.',
	'collabwatchlistedit-users-raw-done'    => 'The collaborative watchlist has been updated.',
	'collabwatchlistedit-tags-raw-added'      => '{{PLURAL:$1|1 tag was|$1 tags were}} added:',
	'collabwatchlistedit-users-raw-added'      => '{{PLURAL:$1|1 user was|$1 users were}} added:',
	'collabwatchlistedit-tags-raw-removed'    => '{{PLURAL:$1|1 tag was|$1 tags were}} removed:',
	'collabwatchlistedit-users-raw-removed'    => '{{PLURAL:$1|1 user was|$1 users were}} removed:',
	'collabwatchlistinverttags' => 'Invert tag filter',
	'collabwatchlistpatrol' => 'Patrol edits',
	'collabwatchlisttools-newList' => 'New collaborative watchlist',
	'collabwatchlistdelete-legend' => 'Delete a collaborative watchlist',
	'collabwatchlistdelete-explain' => 'Deleting a collaborative watchlist will remove all traces of the watchlist. Tags which were set on the edits are preserved.',
	'collabwatchlistdelete-submit' => 'Delete',
	'collabwatchlistdelete-title' => 'Delete collaborative watchlist',
	'collabwatchlistedit-set-tags-numitems' => 'This collaborative watchlist has {{PLURAL:$1|1 tag|$1 tags}} set',
	'collabwatchlistedit-set-tags-noitems' => 'This collaborative watchlist has no tags set',
	'collabwatchlistnew-legend' => 'Create a new collaborative watchlist',
	'collabwatchlistnew-explain' => 'The name of the list has to be unique.',
	'collabwatchlistnew-name' => 'List name',
	'collabwatchlistnew-submit' => 'Create',
	'collabwatchlistedit-raw-done' => 'The collaborative watchlist has been updated',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|1 page or category was|$1 pages or categories were}} added:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|1 page or category was|$1 pages or categories were}} removed',
	'collabwatchlistedit-normal-submit' => 'Save',
	'collabwatchlistshowhidelistusers' => '$1 list users',
	'tog-collabwatchlisthidelistusers' => 'Hide edits from collaborative watchlist users',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author McDutchie
 */
$messages['qqq'] = array(
	'collabwatchlisttagcomment' => '{{Identical|Comment}}',
	'collabwatchlisttools-view' => '{{Identical|Display}}',
	'collabwatchlisttools-delete' => '{{Identical|Delete}}',
	'collabwatchlistedit-users-raw-submit' => '{{Identical|Save}}',
	'collabwatchlistedit-raw-titles' => '{{Identical|Categories}}',
	'collabwatchlistedit-users-raw-titles' => '{{Identical|User}}',
	'collabwatchlistedit-tags-raw-submit' => '{{Identical|Save}}',
	'collabwatchlistdelete-submit' => '{{Identical|Delete}}',
	'collabwatchlistnew-submit' => '{{Identical|Create}}',
	'collabwatchlistedit-normal-submit' => '{{Identical|Save}}',
	'collabwatchlistshowhidelistusers' => '$1 can be "Show" ({{msg-mw|show}}) or "Hide" ({{msg-mw|hide}}). (source: [[Thread:Support/About MediaWiki:Collabwatchlistshowhidelistusers/en|this thread]])',
);

/** Arabic (العربية)
 * @author روخو
 */
$messages['ar'] = array(
	'collabwatchlisttagselect' => 'وسم',
	'collabwatchlisttagcomment' => 'تعليق',
	'collabwatchlisttools-view' => 'اعرض',
	'collabwatchlisttools-delete' => 'احذف',
	'collabwatchlistsall' => 'جميع القوائم',
	'collabwatchlistfiltertags' => 'إخفاء الوسوم',
	'collabwatchlistedit-users-raw-submit' => 'احفظ',
	'collabwatchlistedit-users-last-owner' => 'لا بد من مالك واحد على الاقل',
	'collabwatchlistedit-raw-titles' => 'تصنيفات:',
	'collabwatchlistedit-tags-raw-titles' => 'وسوم:',
	'collabwatchlistedit-users-raw-titles' => 'مستخدمون:',
	'collabwatchlistedit-normal-title' => 'عدل التصانيف',
	'collabwatchlistedit-tags-raw-submit' => 'احفظ',
	'collabwatchlistpatrol' => 'تعديلات مراجعة',
	'collabwatchlistdelete-submit' => 'احذف',
	'collabwatchlistnew-name' => 'اسم القائمة',
	'collabwatchlistnew-submit' => 'أنشئ',
	'collabwatchlistedit-normal-submit' => 'احفظ',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'collabwatchlisttagcomment' => 'Şərh',
	'collabwatchlistsall' => 'Bütün siyahılar',
	'collabwatchlistedit-users-raw-submit' => 'Saxla',
	'collabwatchlistedit-users-raw-titles' => 'İstifadəçilər:',
	'collabwatchlistedit-tags-raw-submit' => 'Saxla',
	'collabwatchlistdelete-submit' => 'Sil',
	'collabwatchlistnew-submit' => 'Yarat',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'collabwatchlist' => 'Агульны сьпіс назіраньня',
	'collabwatchlist-desc' => 'Падае агульныя сьпісы назіраньня заснаваныя на катэгорыях',
	'specialcollabwatchlist' => 'Спэцыяльная старонка агульнага сьпісу назіраньня',
	'collabwatchlist-details' => '{{PLURAL:$1|$1 катэгорыя/старонка|$1 катэгорыі/старонкі|$1 катэгорыяў/старонак}} у гэтым агульным сьпісе назіраньня.',
	'collabwatchlisttagselect' => 'Тэг',
	'collabwatchlisttagcomment' => 'Камэнтар',
	'collabwatchlistsettagbutton' => 'Устанавіць тэг',
	'collabwatchlisttools-view' => 'Паказаць',
	'collabwatchlisttools-edit' => 'Рэдагаваць катэгорыі',
	'collabwatchlisttools-rawCategories' => 'Рэдагаваць нефарматаваны сьпіс катэгорыяў',
	'collabwatchlisttools-rawTags' => 'Рэдагаваць нефарматаваны сьпіс тэгаў',
	'collabwatchlisttools-rawUsers' => 'Рэдагаваць нефарматаваны сьпіс удзельнікаў',
	'collabwatchlisttools-delete' => 'Выдаліць',
	'collabwatchlistsall' => 'Усе сьпісы',
	'collabwatchlistfiltertags' => 'Схаваць тэгі',
	'collabwatchlistedit-users-raw-submit' => 'Захаваць',
	'collabwatchlistedit-raw-title' => 'Рэдагаваньне нефарматаванага сьпісу катэгорыяў',
	'collabwatchlistedit-tags-raw-title' => 'Рэдагаваньне нефарматаванага сьпісу тэгаў',
	'collabwatchlistedit-users-raw-title' => 'Рэдагаваньне нефарматаванага сьпісу удзельнікаў',
	'collabwatchlistedit-users-last-owner' => 'Павінен быць хаця б адзін уладальнік',
	'collabwatchlistedit-numitems' => 'Гэты агульны сьпіс назіраньня ўтрымлівае $1 {{PLURAL:$1|катэгорыю|катэгорыі|катэгорыяў}}',
	'collabwatchlistedit-noitems' => 'Гэты агульны сьпіс назіраньня не ўтрымлівае катэгорыяў.',
	'collabwatchlistedit-tags-numitems' => 'Гэты агульны сьпіс назіраньня ўтрымлівае $1 {{PLURAL:$1|тэг|тэгі|тэгаў}}',
	'collabwatchlistedit-tags-noitems' => 'Гэты агульны сьпіс назіраньня не ўтрымлівае тэгаў.',
	'collabwatchlistedit-users-numitems' => 'Гэты агульны сьпіс назіраньня ўтрымлівае $1 {{PLURAL:$1|удзельніка|удзельнікаў|удзельнікаў}}',
	'collabwatchlistedit-users-noitems' => 'Гэты агульны сьпіс назіраньня не ўтрымлівае ўдзельнікаў.',
	'collabwatchlistedit-raw-legend' => 'Рэдагаваньне нефарматаванага сьпісу катэгорыяў ў агульным сьпісе назіраньня',
	'collabwatchlistedit-users-raw-legend' => 'Рэдагаваньне нефарматаванага сьпісу удзельнікаў у агульным сьпісе назіраньня',
	'collabwatchlistedit-tags-raw-legend' => 'Рэдагаваньне нефарматаванага сьпісу тэгаў ў агульным сьпісе назіраньня',
	'collabwatchlistedit-raw-explain' => 'Унізе паказаныя катэгорыі агульнага сьпісу назіраньня, і сьпіс можа рэдагавацца праз даданьне ці выдаленьне катэгорыяў',
	'collabwatchlistedit-tags-raw-explain' => 'Унізе паказаныя тэгі агульнага сьпісу назіраньня, і сьпіс можа рэдагавацца праз даданьне ці выдаленьне тэгаў.',
	'collabwatchlistedit-users-raw-explain' => 'Унізе паказаныя ўдзельнікі агульнага сьпісу назіраньня, і сьпіс можа рэдагавацца праз даданьне ці выдаленьне ўдзельнікаў.',
	'collabwatchlistedit-raw-titles' => 'Катэгорыі:',
	'collabwatchlistedit-tags-raw-titles' => 'Тэгі:',
	'collabwatchlistedit-users-raw-titles' => 'Удзельнікі:',
	'collabwatchlistedit-normal-title' => 'Рэдагаваць катэгорыі',
	'collabwatchlistedit-normal-legend' => 'Выдаленьне катэгорыяў з агульнага сьпісу назіраньня',
	'collabwatchlistedit-normal-explain' => 'Ніжэй паказаныя катэгорыі з Вашага агульнага сьпісу назіраньня.',
	'collabwatchlistedit-tags-raw-submit' => 'Захаваць',
	'collabwatchlistedit-normal-done' => '$1 {{PLURAL:$1|катэгорыя была выдаленая|катэгорыі былі выдаленыя|катэгорыяў былі выдаленыя}} з агульнага сьпісу назіраньня:',
	'collabwatchlistedit-tags-raw-done' => 'Агульны сьпіс назіраньня быў абноўлены.',
	'collabwatchlistedit-users-raw-done' => 'Агульны сьпіс назіраньня быў абноўлены.',
	'collabwatchlistedit-tags-raw-added' => '$1 {{PLURAL:$1|тэг быў дададзены|тэгі былі дададзеныя|тэгаў былі дададзеныя}}:',
	'collabwatchlistedit-users-raw-added' => '$1 {{PLURAL:$1|удзельнік быў дададзены|удзельнікі былі дададзеныя|ўдзельнікаў былі дададзена}}:',
	'collabwatchlistedit-tags-raw-removed' => '$1 {{PLURAL:$1|тэг быў выдалены|тэгі былі выдаленыя|тэгаў былі выдаленыя}}:',
	'collabwatchlistedit-users-raw-removed' => '$1 {{PLURAL:$1|удзельнік быў выдалены|удзельнікі былі выдаленыя|удзельнікаў былі выдаленыя}}:',
	'collabwatchlistinverttags' => 'Інвэртаваць фільтар тэгаў',
	'collabwatchlistpatrol' => 'Патруляваныя рэдагаваньні',
	'collabwatchlisttools-newList' => 'Новы агульны сьпіс назіраньня',
	'collabwatchlistdelete-legend' => 'Выдаліць агульны сьпіс назіраньня',
	'collabwatchlistdelete-explain' => 'Выдаленьне агульнага сьпісу назіраньня прывядзе да выдаленьня яго бясьсьледна. Тэгі, якія былі пастаўленыя на рэдагаваньні, будуць захаваныя.',
	'collabwatchlistdelete-submit' => 'Выдаліць',
	'collabwatchlistdelete-title' => 'Выдаліць агульны сьпіс назіраньня',
	'collabwatchlistedit-set-tags-numitems' => 'Гэты агульны сьпіс назіраньня ўтрымлівае $1 {{PLURAL:|ўстаноўлены тэг|ўстаноўленыя тэгі|ўстаноўленых тэгаў}}',
	'collabwatchlistedit-set-tags-noitems' => 'Гэты агульны сьпіс назіраньня не ўтрымлівае ўстаноўленых тэгаў.',
	'collabwatchlistnew-legend' => 'Стварыць новы агульны сьпіс назіраньня',
	'collabwatchlistnew-explain' => 'Назва сьпісу павінна быць унікальнай.',
	'collabwatchlistnew-name' => 'Назва сьпісу',
	'collabwatchlistnew-submit' => 'Стварыць',
	'collabwatchlistedit-raw-done' => 'Агульны сьпіс назіраньня быў абноўлены',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|Была дададзеная $1 старонка ці катэгорыя|Былі дададзеныя $1 старонкі ці катэгорыі|Былі дададзеныя $1 старонак ці катэгорыяў}}:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|Была выдаленая $1 старонка ці катэгорыя|Былі выдаленыя $1 старонкі ці катэгорыі|Былі выдаленыя $1 старонак ці катэгорыяў}}:',
	'collabwatchlistedit-normal-submit' => 'Захаваць',
	'collabwatchlistshowhidelistusers' => '$1 сьпіс удзельнікаў',
	'tog-collabwatchlisthidelistusers' => 'Схаваць рэдагаваньні ўдзельнікаў агульнага сьпісу назіраньня',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'collabwatchlisttools-delete' => 'Изтриване',
	'collabwatchlistedit-users-raw-submit' => 'Съхраняване',
	'collabwatchlistedit-raw-titles' => 'Категории:',
	'collabwatchlistedit-tags-raw-submit' => 'Съхраняване',
	'collabwatchlistdelete-submit' => 'Изтриване',
	'collabwatchlistedit-normal-submit' => 'Съхраняване',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'collabwatchlisttagselect' => 'Tikedenn',
	'collabwatchlisttagcomment' => 'Evezhiadenn',
	'collabwatchlisttools-view' => 'Diskwel',
	'collabwatchlisttools-edit' => 'Kemmañ ar rummadoù',
	'collabwatchlisttools-delete' => 'Dilemel',
	'collabwatchlistsall' => 'An holl rolloù',
	'collabwatchlistfiltertags' => 'Kuzhat an tikedennoù',
	'collabwatchlistedit-users-raw-submit' => 'Enrollañ',
	'collabwatchlistedit-users-last-owner' => "Ur perc'henn a rank bezañ da nebeutañ",
	'collabwatchlistedit-raw-titles' => 'Rummadoù :',
	'collabwatchlistedit-tags-raw-titles' => 'Balizennoù :',
	'collabwatchlistedit-users-raw-titles' => 'Implijerien :',
	'collabwatchlistedit-normal-title' => 'Kemmañ ar rummadoù',
	'collabwatchlistedit-tags-raw-submit' => 'Enrollañ',
	'collabwatchlistdelete-submit' => 'Diverkañ',
	'collabwatchlistnew-name' => 'Anv ar roll',
	'collabwatchlistnew-submit' => 'Krouiñ',
	'collabwatchlistedit-normal-submit' => 'Enrollañ',
	'collabwatchlistshowhidelistusers' => '$1 implijer eus ar roll',
);

/** German (Deutsch)
 * @author Florian Hackenberger
 * @author Kghbln
 */
$messages['de'] = array(
	'collabwatchlist' => 'Kollaborative Beobachtungsliste',
	'collabwatchlist-desc' => 'Ermöglicht auf Kategorien basierende kollaborative Beobachtungslisten',
	'specialcollabwatchlist' => 'Kollaborative Beobachtungsliste',
	'collabwatchlist-details' => '{{PLURAL:$1|Eine Kategorie/Seite befindet sich|$1 Kategorien/Seiten befinden sich}} auf dieser kollaborativen Beobachtungsliste.',
	'collabwatchlisttagselect' => 'Stichwort',
	'collabwatchlisttagcomment' => 'Kommentar',
	'collabwatchlistsettagbutton' => 'Stichwort setzen',
	'collabwatchlisttools-view' => 'Anzeigen',
	'collabwatchlisttools-edit' => 'Kategorien bearbeiten',
	'collabwatchlisttools-rawCategories' => 'Kategorien im Listenformat bearbeiten',
	'collabwatchlisttools-rawTags' => 'Stichworte im Listenformat bearbeiten',
	'collabwatchlisttools-rawUsers' => 'Benutzer im Listenformat bearbeiten',
	'collabwatchlisttools-delete' => 'Löschen',
	'collabwatchlistsall' => 'Alle Listen',
	'collabwatchlistfiltertags' => 'Stichworte verbergen',
	'collabwatchlistedit-users-raw-submit' => 'Speichern',
	'collabwatchlistedit-raw-title' => 'Kategorien im Listenformat bearbeiten',
	'collabwatchlistedit-tags-raw-title' => 'Stichworte im Listenformat bearbeiten',
	'collabwatchlistedit-users-raw-title' => 'Benutzer im Listenformat bearbeiten',
	'collabwatchlistedit-users-last-owner' => 'Es muss mindestens einen Besitzer geben',
	'collabwatchlistedit-numitems' => 'Diese kollaborative Beobachtungsliste enthält {{PLURAL:$1|eine Kategorie |$1 Kategorien}}.',
	'collabwatchlistedit-noitems' => 'Diese kollaborative Beobachtungsliste enthält keine Kategorien.',
	'collabwatchlistedit-tags-numitems' => 'Diese kollaborative Beobachtungsliste enthält {{PLURAL:$1|ein Stichwort|$1 Stichwörter}}.',
	'collabwatchlistedit-tags-noitems' => 'Diese kollaborative Beobachtungsliste enthält keine Stichwörter.',
	'collabwatchlistedit-users-numitems' => 'Diese kollaborative Beobachtungsliste enthält {{PLURAL:$1|einen Benutzer |$1 Benutzer}}.',
	'collabwatchlistedit-users-noitems' => 'Diese kollaborative Beobachtungsliste enthält keine Benutzer.',
	'collabwatchlistedit-raw-legend' => 'Kategorien der kollaborativen Beobachtungsliste im Listenformat bearbeiten',
	'collabwatchlistedit-users-raw-legend' => 'Benutzer der kollaborativen Beobachtungsliste im Listenformat bearbeiten',
	'collabwatchlistedit-tags-raw-legend' => 'Stichwörter der kollaborativen Beobachtungsliste im Listenformat bearbeiten',
	'collabwatchlistedit-raw-explain' => 'Dies sind die Kategorien auf der kollaborativen Beobachtungsliste im Listenformat. Die Einträge können zeilenweise gelöscht oder hinzugefügt werden.',
	'collabwatchlistedit-tags-raw-explain' => 'Dies sind die Stichwörter auf der kollaborativen Beobachtungsliste im Listenformat. Die Einträge können zeilenweise gelöscht oder hinzugefügt werden.',
	'collabwatchlistedit-users-raw-explain' => 'Dies sind die Benutzer auf der kollaborativen Beobachtungsliste im Listenformat. Die Einträge können zeilenweise gelöscht oder hinzugefügt werden.',
	'collabwatchlistedit-raw-titles' => 'Kategorien:',
	'collabwatchlistedit-tags-raw-titles' => 'Stichwörter:',
	'collabwatchlistedit-users-raw-titles' => 'Benutzer:',
	'collabwatchlistedit-normal-title' => 'Kategorien bearbeiten',
	'collabwatchlistedit-normal-legend' => 'Kategorien von der kollaborativen Beobachtungsliste entfernen',
	'collabwatchlistedit-normal-explain' => 'Die Kategorien, die sich auf der kollaborativen Beobachtungsliste befinden, werden unten angezeigt.',
	'collabwatchlistedit-tags-raw-submit' => 'Speichern',
	'collabwatchlistedit-normal-done' => '{{PLURAL:$1|Eine Kategorie wurde|$1 Kategorien wurden}} von der kollaborativen Beobachtungsliste entfernt:',
	'collabwatchlistedit-tags-raw-done' => 'Die kollaborative  Beobachtungsliste wurde gespeichert.',
	'collabwatchlistedit-users-raw-done' => 'Die kollaborative  Beobachtungsliste wurde gespeichert.',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|Ein Stichwort wurde|$1 Stichwörter wurden}} hinzugefügt:',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|Ein Benutzer wurde|$1 Benutzer wurden}} hinzugefügt:',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|Ein Stichwort wurde|$1 Stichwörter wurden}} entfernt:',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|Ein Benutzer wurde|$1 Benutzer wurden}} entfernt:',
	'collabwatchlistinverttags' => 'Stichwortfilter umkehren',
	'collabwatchlistpatrol' => 'Änderungen kontrollieren',
	'collabwatchlisttools-newList' => 'Neue kollaborative Beobachtungsliste',
	'collabwatchlistdelete-legend' => 'Kollaborative Beobachtungsliste löschen',
	'collabwatchlistdelete-explain' => 'Während des Löschens werden alle Informationen gelöscht, die mit der Beobachtungsliste in Zusammenhang stehen. Stichwörter die Änderungen zugewiesen wurden, bleiben erhalten.',
	'collabwatchlistdelete-submit' => 'Löschen',
	'collabwatchlistdelete-title' => 'Kollaborative Beobachtungsliste löschen',
	'collabwatchlistedit-set-tags-numitems' => 'Diese kollaborative Beobachtungsliste hat {{PLURAL:$1|Ein Stichwort|$1 Stichwörter}} gesetzt',
	'collabwatchlistedit-set-tags-noitems' => 'Diese kollaborative Beobachtungsliste hat keine Stichwörter gesetzt',
	'collabwatchlistnew-legend' => 'Neue kollaborative Beobachtungsliste anlegen',
	'collabwatchlistnew-explain' => 'Der Name der Liste muss eindeutig sein.',
	'collabwatchlistnew-name' => 'Name der Liste',
	'collabwatchlistnew-submit' => 'Erstellen',
	'collabwatchlistedit-raw-done' => 'Die kollaborative Beobachtungsliste wurde gespeichert.',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|Eine Kategorie/Seite wurde|$1 Kategorien/Seiten wurden}} hinzugefügt:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|Eine Kategorie/Seite wurde|$1 Kategorien/Seiten wurden}} entfernt:',
	'collabwatchlistedit-normal-submit' => 'Speichern',
	'collabwatchlistshowhidelistusers' => 'Listenbenutzer $1',
	'tog-collabwatchlisthidelistusers' => 'Bearbeitungen von Benutzern der kollaborativen Beobachtungsliste ausblenden',
);

/** Greek (Ελληνικά)
 * @author Glavkos
 */
$messages['el'] = array(
	'collabwatchlisttagcomment' => 'Σχόλιο',
	'collabwatchlistsettagbutton' => 'Ορίστε ετικέτα',
	'collabwatchlisttools-view' => 'Εμφάνιση',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'collabwatchlisttagselect' => 'Etikedo',
	'collabwatchlisttagcomment' => 'Komento',
	'collabwatchlistedit-users-raw-submit' => 'Konservi',
	'collabwatchlistedit-raw-titles' => 'Kategorioj:',
	'collabwatchlistedit-tags-raw-titles' => 'Etikedoj:',
	'collabwatchlistedit-users-raw-titles' => 'Uzantoj:',
	'collabwatchlistedit-normal-title' => 'Redakti kategoriojn',
	'collabwatchlistdelete-submit' => 'Forigi',
	'collabwatchlistnew-submit' => 'Krei',
	'collabwatchlistedit-normal-submit' => 'Konservi',
);

/** Spanish (Español)
 * @author Mor
 */
$messages['es'] = array(
	'collabwatchlistedit-raw-titles' => 'Categorías:',
	'collabwatchlistedit-tags-raw-titles' => 'Etiquetas:',
	'collabwatchlistedit-users-raw-titles' => 'Usuarios:',
	'collabwatchlistedit-normal-title' => 'Editar categorías',
);

/** Persian (فارسی)
 * @author Reza1615
 */
$messages['fa'] = array(
	'collabwatchlisttools-delete' => 'حذف',
	'collabwatchlistfiltertags' => 'پنهان کردن برچسب‌ها',
	'collabwatchlistedit-users-raw-submit' => 'ذخیره',
);

/** French (Français)
 * @author Gomoko
 * @author Seb35
 */
$messages['fr'] = array(
	'collabwatchlist' => 'Liste de suivi collaborative',
	'collabwatchlist-desc' => 'Fournit des listes de suivi collaboratives basées sur des catégories',
	'specialcollabwatchlist' => 'Page spéciale de liste de suivi collaborative',
	'collabwatchlist-details' => '{{PLURAL:$1|1 catégorie/page|$1 catégories/pages}} dans cette liste de suivi collaborative.',
	'collabwatchlisttagselect' => 'Balise',
	'collabwatchlisttagcomment' => 'Commentaire',
	'collabwatchlistsettagbutton' => 'Définir la balise',
	'collabwatchlisttools-view' => 'Affichage',
	'collabwatchlisttools-edit' => 'Modifier les catégories',
	'collabwatchlisttools-rawCategories' => 'Modifier en bloc les catégories',
	'collabwatchlisttools-rawTags' => 'Modifier en bloc les balises',
	'collabwatchlisttools-rawUsers' => 'Modifier en bloc les utilisateurs',
	'collabwatchlisttools-delete' => 'Supprimer',
	'collabwatchlistsall' => 'Toutes les listes',
	'collabwatchlistfiltertags' => 'Cacher les balises',
	'collabwatchlistedit-users-raw-submit' => 'Enregistrer',
	'collabwatchlistedit-raw-title' => 'Modifier en bloc les catégories',
	'collabwatchlistedit-tags-raw-title' => 'Modifier en bloc les balises',
	'collabwatchlistedit-users-raw-title' => 'Modifier en bloc les utilisateurs',
	'collabwatchlistedit-users-last-owner' => 'Il doit y avoir au moins un propriétaire',
	'collabwatchlistedit-numitems' => 'Cette liste de suivi collaborative contient {{PLURAL:$1|1 catégorie|$1 catégories}}',
	'collabwatchlistedit-noitems' => 'Cette liste de suivi collaborative ne contient pas de catégorie',
	'collabwatchlistedit-tags-numitems' => 'Cette liste de suivi collaborative contient {{PLURAL:$1|1 balise|$1 balises}}',
	'collabwatchlistedit-tags-noitems' => 'Cette liste de suivi collaborative ne contient pas de balise.',
	'collabwatchlistedit-users-numitems' => 'Cette liste de suivi collaborative contient {{PLURAL:$1|1 utilisateur|$1 utilisateurs}}',
	'collabwatchlistedit-users-noitems' => 'Cette liste de suivi collaborative ne contient pas d’utilisateur',
	'collabwatchlistedit-raw-legend' => 'Modifier en bloc les catégories de la liste de suivi collaborative',
	'collabwatchlistedit-users-raw-legend' => 'Modifier en bloc les utilisateurs de la liste de suivi collaborative',
	'collabwatchlistedit-tags-raw-legend' => 'Modifier en bloc les balises de la liste de suivi collaborative',
	'collabwatchlistedit-raw-explain' => 'Les catégories de la liste de suivi collaborative sont affichées ci-dessous et peuvent être modifiées en en ajoutant ou en en retirant de la liste',
	'collabwatchlistedit-tags-raw-explain' => 'Les balises de la liste de suivi collaborative sont affichées ci-dessous et peuvent être modifiées en en ajoutant ou en en retirant de la liste',
	'collabwatchlistedit-users-raw-explain' => 'Les utilisateurs de la liste de suivi collaborative sont affichés ci-dessous et peuvent être modifiées en en ajoutant ou en en retirant de la liste',
	'collabwatchlistedit-raw-titles' => 'Catégories :',
	'collabwatchlistedit-tags-raw-titles' => 'Balises :',
	'collabwatchlistedit-users-raw-titles' => 'Utilisateurs :',
	'collabwatchlistedit-normal-title' => 'Modifier les catégories',
	'collabwatchlistedit-normal-legend' => 'Retirer des catégories de la liste de suivi collaborative',
	'collabwatchlistedit-normal-explain' => 'Les catégories de votre liste de suivi  collaborative sont affichées ci-dessous.',
	'collabwatchlistedit-tags-raw-submit' => 'Enregistrez',
	'collabwatchlistedit-normal-done' => '{{PLURAL:$1|1 catégorie a été retirée|$1 catégories ont été retirées}} de la liste de suivi collaborative :',
	'collabwatchlistedit-tags-raw-done' => 'La liste de suivi collaborative a été mise à jour.',
	'collabwatchlistedit-users-raw-done' => 'La liste de suivi collaborative a été mise à jour.',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|1 balise a été ajouté|$1 balises ont été ajoutés}} :',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|1 utilisateur a été ajouté|$1 utilisateurs ont été ajoutés}} :',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|1 balise a été retiré|$1 balises ont été retirés}} :',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|1 utilisateur a été retiré|$1 utilisateurs ont été retirés}} :',
	'collabwatchlistinverttags' => 'Inverser le filtre de balises',
	'collabwatchlistpatrol' => 'Contributions de patrouille',
	'collabwatchlisttools-newList' => 'Nouvelle liste de suivi collaborative',
	'collabwatchlistdelete-legend' => 'Supprimer une liste de suivi collaborative',
	'collabwatchlistdelete-explain' => 'Supprimer une liste de suivi collaborative retirera toute trace de cette liste de suivi. Les balises qui ont été apposées sur des éditions sont préservés.',
	'collabwatchlistdelete-submit' => 'Supprimer',
	'collabwatchlistdelete-title' => 'Supprimer la liste de suivi collaborative',
	'collabwatchlistedit-set-tags-numitems' => 'Cette liste de suivi collaborative a {{PLURAL:$1|1 balise|$1 balises}} activées',
	'collabwatchlistedit-set-tags-noitems' => 'Cette liste de suivi collaborative n’a aucune balise activée',
	'collabwatchlistnew-legend' => 'Créer une liste de suivi collaborative',
	'collabwatchlistnew-explain' => 'Le nom de la liste doit être unique.',
	'collabwatchlistnew-name' => 'Nom de la liste',
	'collabwatchlistnew-submit' => 'Créer',
	'collabwatchlistedit-raw-done' => 'La liste de suivi collaborative a été mise à jour',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|1 page/catégorie a été ajoutée|$1 pages/catégories ont été ajoutées}} :',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|1 page/catégorie a été retirée|$1 pages/catégories ont été retirées}} :',
	'collabwatchlistedit-normal-submit' => 'Enregistrer',
	'collabwatchlistshowhidelistusers' => '$1 utilisateurs de la liste',
	'tog-collabwatchlisthidelistusers' => 'Cacher les contributions des utilisateurs de la liste de suivi collaborative',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'collabwatchlisttagselect' => 'Balisa',
	'collabwatchlisttagcomment' => 'Comentèro',
	'collabwatchlistsettagbutton' => 'Dèfenir la balisa',
	'collabwatchlisttools-view' => 'Fâre vêre',
	'collabwatchlisttools-edit' => 'Changiér les catègories',
	'collabwatchlisttools-rawCategories' => 'Changiér en bloco les catègories',
	'collabwatchlisttools-rawTags' => 'Changiér en bloco les balises',
	'collabwatchlisttools-rawUsers' => 'Changiér en bloco los utilisators',
	'collabwatchlisttools-delete' => 'Suprimar',
	'collabwatchlistsall' => 'Totes les listes',
	'collabwatchlistfiltertags' => 'Cachiér les balises',
	'collabwatchlistedit-users-raw-submit' => 'Encartar',
	'collabwatchlistedit-raw-title' => 'Changiér en bloco les catègories',
	'collabwatchlistedit-tags-raw-title' => 'Changiér en bloco les balises',
	'collabwatchlistedit-users-raw-title' => 'Changiér en bloco los utilisators',
	'collabwatchlistedit-raw-titles' => 'Catègories :',
	'collabwatchlistedit-tags-raw-titles' => 'Balises :',
	'collabwatchlistedit-users-raw-titles' => 'Usanciérs :',
	'collabwatchlistedit-normal-title' => 'Changiér les catègories',
	'collabwatchlistedit-tags-raw-submit' => 'Encartar',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|Yona balisa at étâ apondua|$1 balises ont étâ apondues}} :',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|Yon usanciér at étâ apondu|$1 usanciérs ont étâ apondus}} :',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|Yona balisa at étâ enlevâ|$1 balises ont étâ enlevâs}} :',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|Yon usanciér at étâ enlevâ|$1 usanciérs ont étâ enlevâs}} :',
	'collabwatchlistinverttags' => 'Envèrsar lo filtro de balises',
	'collabwatchlistpatrol' => 'Contrôlo des changements',
	'collabwatchlistdelete-submit' => 'Suprimar',
	'collabwatchlistnew-name' => 'Nom de la lista',
	'collabwatchlistnew-submit' => 'Fâre',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|Yona pâge ou ben catègorie at étâ apondua|$1 pâges ou ben catègories ont étâ apondues}} :',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|Yona pâge ou ben catègorie at étâ enlevâ|$1 pâges ou ben catègories ont étâ enlevâs}} :',
	'collabwatchlistedit-normal-submit' => 'Encartar',
	'collabwatchlistshowhidelistusers' => '$1 utilisators de la lista',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'collabwatchlist' => 'Lista de vixilancia colaborativa',
	'collabwatchlist-desc' => 'Proporciona listas de vixilancia colaborativas baseadas en categorías',
	'specialcollabwatchlist' => 'Páxina especial da lista de vixilancia colaborativa',
	'collabwatchlist-details' => '{{PLURAL:$1|$1 categoría ou páxina|$1 categorías ou páxinas}} nesta lista de vixilancia colaborativa.',
	'collabwatchlisttagselect' => 'Etiqueta',
	'collabwatchlisttagcomment' => 'Comentario',
	'collabwatchlistsettagbutton' => 'Aplicar a etiqueta',
	'collabwatchlisttools-view' => 'Visualización',
	'collabwatchlisttools-edit' => 'Editar as categorías',
	'collabwatchlisttools-rawCategories' => 'Edición normal de categorías',
	'collabwatchlisttools-rawTags' => 'Edición normal de etiquetas',
	'collabwatchlisttools-rawUsers' => 'Edición normal de usuarios',
	'collabwatchlisttools-delete' => 'Borrar',
	'collabwatchlistsall' => 'Todas as listas',
	'collabwatchlistfiltertags' => 'Agochar as etiquetas',
	'collabwatchlistedit-users-raw-submit' => 'Gardar',
	'collabwatchlistedit-raw-title' => 'Edición normal de categorías',
	'collabwatchlistedit-tags-raw-title' => 'Edición normal de etiquetas',
	'collabwatchlistedit-users-raw-title' => 'Edición normal de usuarios',
	'collabwatchlistedit-users-last-owner' => 'Debe haber, polo menos, un propietario',
	'collabwatchlistedit-numitems' => 'Esta lista de vixilancia colaborativa contén {{PLURAL:$1|1 categoría|$1 categorías}}',
	'collabwatchlistedit-noitems' => 'Esta lista de vixilancia colaborativa non contén categorías.',
	'collabwatchlistedit-tags-numitems' => 'Esta lista de vixilancia colaborativa contén {{PLURAL:$1|1 etiqueta|$1 etiquetas}}',
	'collabwatchlistedit-tags-noitems' => 'Esta lista de vixilancia colaborativa non contén etiquetas.',
	'collabwatchlistedit-users-numitems' => 'Esta lista de vixilancia colaborativa contén {{PLURAL:$1|1 usuario|$1 usuarios}}',
	'collabwatchlistedit-users-noitems' => 'Esta lista de vixilancia colaborativa non contén usuarios.',
	'collabwatchlistedit-raw-legend' => 'Edición normal das categorías da lista de vixilancia colaborativa',
	'collabwatchlistedit-users-raw-legend' => 'Edición normal dos usuarios da lista de vixilancia colaborativa',
	'collabwatchlistedit-tags-raw-legend' => 'Edición normal das etiquetas da lista de vixilancia colaborativa',
	'collabwatchlistedit-raw-explain' => 'A continuación están as categorías na lista de vixilancia colaborativa; pode editalas engadíndoas ou retirándoas da lista.',
	'collabwatchlistedit-tags-raw-explain' => 'A continuación están as etiquetas na lista de vixilancia colaborativa; pode editalas engadíndoas ou retirándoas da lista.',
	'collabwatchlistedit-users-raw-explain' => 'A continuación están os usuarios na lista de vixilancia colaborativa; pode editalos engadíndoos ou retirándoos da lista.',
	'collabwatchlistedit-raw-titles' => 'Categorías:',
	'collabwatchlistedit-tags-raw-titles' => 'Etiquetas:',
	'collabwatchlistedit-users-raw-titles' => 'Usuarios:',
	'collabwatchlistedit-normal-title' => 'Editar as categorías',
	'collabwatchlistedit-normal-legend' => 'Eliminar categorías da lista de vixilancia colaborativa',
	'collabwatchlistedit-normal-explain' => 'As categorías da súa lista de vixilancia colaborativa están a continuación.',
	'collabwatchlistedit-tags-raw-submit' => 'Gardar',
	'collabwatchlistedit-normal-done' => '{{PLURAL:$1|Eliminouse 1 categoría|Elimináronse $1 categorías}} da lista de vixilancia colaborativa:',
	'collabwatchlistedit-tags-raw-done' => 'Actualizouse a lista de vixilancia colaborativa.',
	'collabwatchlistedit-users-raw-done' => 'Actualizouse a lista de vixilancia colaborativa.',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|Engadiuse unha etiqueta|Engadíronse $1 etiquetas}}:',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|Engadiuse un usuario|Engadíronse $1 usuarios}}:',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|Eliminouse unha etiqueta|Elimináronse $1 etiquetas}}:',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|Eliminouse un usuario|Elimináronse $1 usuarios}}:',
	'collabwatchlistinverttags' => 'Inverter o filtro de etiquetas',
	'collabwatchlistpatrol' => 'Patrullar edicións',
	'collabwatchlisttools-newList' => 'Nova lista de vixilancia colaborativa',
	'collabwatchlistdelete-legend' => 'Borrar unha lista de vixilancia colaborativa',
	'collabwatchlistdelete-explain' => 'Ao borrar unha lista de vixilancia colaborativa eliminará todo indicio desa lista. As etiquetas aplicadas nas edicións consérvanse.',
	'collabwatchlistdelete-submit' => 'Borrar',
	'collabwatchlistdelete-title' => 'Borrar a lista de vixilancia colaborativa',
	'collabwatchlistedit-set-tags-numitems' => 'Esta lista de vixilancia colaborativa ten {{PLURAL:$1|1 etiqueta aplicada|$1 etiquetas aplicadas}}',
	'collabwatchlistedit-set-tags-noitems' => 'Esta lista de vixilancia colaborativa non ten etiquetas aplicadas',
	'collabwatchlistnew-legend' => 'Crear unha nova lista de vixilancia colaborativa',
	'collabwatchlistnew-explain' => 'O nome da lista ten que ser único.',
	'collabwatchlistnew-name' => 'Nome da lista',
	'collabwatchlistnew-submit' => 'Crear',
	'collabwatchlistedit-raw-done' => 'Actualizouse a lista de vixilancia colaborativa',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|Engadiuse 1 páxina ou categoría|Engadíronse $1 páxinas ou categorías}}:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|Eliminouse 1 páxina ou categoría|Elimináronse $1 páxinas ou categorías}}:',
	'collabwatchlistedit-normal-submit' => 'Gardar',
	'collabwatchlistshowhidelistusers' => '$1 os usuarios da lista',
	'tog-collabwatchlisthidelistusers' => 'Agochar as edicións dos usuarios da lista de vixilancia colaborativa',
);

/** Swiss German (Alemannisch)
 * @author 80686
 * @author Als-Chlämens
 */
$messages['gsw'] = array(
	'collabwatchlist' => 'Gmeinsami Beobachtigslischte',
	'collabwatchlist-desc' => 'Git gmeinsami Beobachtigslischte wo uff Kategorie basiere duen',
	'specialcollabwatchlist' => 'Spezialsyte vo de Gmeinsame Beobachtigslische',
	'collabwatchlist-details' => 'Es sin {{PLURAL:$1|$1 Kategori / Syte|$1 Kategorie / Syte}} uff de gmeinsame Beobachtigslischte.',
	'collabwatchlisttagselect' => 'Markierig',
	'collabwatchlisttagcomment' => 'Aamerkig',
	'collabwatchlistsettagbutton' => 'Änderig markiere',
	'collabwatchlisttools-view' => 'Aazeige',
	'collabwatchlisttools-edit' => 'Kategorie ändere',
	'collabwatchlisttools-rawCategories' => 'Kategorie als Lischte ändere',
	'collabwatchlisttools-rawTags' => 'Markiierige als Lischte ändere',
	'collabwatchlisttools-rawUsers' => 'Benutzer als Lischte ändere',
	'collabwatchlisttools-delete' => 'Lösche',
	'collabwatchlistsall' => 'Alli Lischte',
	'collabwatchlistfiltertags' => 'Stichwörter verstecke',
	'collabwatchlistedit-users-raw-submit' => 'Spychere',
	'collabwatchlistedit-raw-title' => 'Kategorie als Lischte ändere',
	'collabwatchlistedit-tags-raw-title' => 'Markiierige als Lischte ändere',
	'collabwatchlistedit-users-raw-title' => 'Benutzer als Lischte ändere',
	'collabwatchlistedit-users-last-owner' => "S' muess mindeschtens ei Bsitzer geh",
	'collabwatchlistedit-numitems' => 'Sälli gmeinsami Beobachtigslischte het {{PLURAL:$1|1 Kategori|$1 Kategorie}}',
	'collabwatchlistedit-noitems' => 'Sälli gmeinsami Beobachtigslischte het cheini Kategorie.',
	'collabwatchlistedit-tags-numitems' => 'Sälli gmeinsami Beobachtigslischte het {{PLURAL:$1|1 Markierig|$1 Markierige}}',
	'collabwatchlistedit-tags-noitems' => 'Sälli gmeinsami Beobachtigslischte het cheini Markierige.',
	'collabwatchlistedit-users-numitems' => 'Sälli gmeinsami Beobachtigslischte het {{PLURAL:$1|ei Benutzer|$1 Benutzer}}',
	'collabwatchlistedit-users-noitems' => 'Sälli gmeinsami Beobachtigslischte het cheini Benutzer.',
	'collabwatchlistedit-users-raw-legend' => 'Benutzer vo kollaborative Beobachtigslischte im Listeformat bearbeite',
	'collabwatchlistedit-raw-titles' => 'Kategorie',
	'collabwatchlistedit-tags-raw-titles' => 'Stichwörter:',
	'collabwatchlistedit-users-raw-titles' => 'Benutzer:',
	'collabwatchlistedit-normal-title' => 'Kategorie ändere',
	'collabwatchlistedit-tags-raw-submit' => 'Spychere',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|ei Stichwort isch|$1 Stichwörter sin}} dezuedüü worde:',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|ei Benutzer isch|$1 Benutzer sin}} dezuedüü worde:',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|ei Stichwort isch|$1 Stichwörter sin}} ussegno worde:',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|ei Benutzer isch|$1 Benutzer sin}} ussegno worde:',
	'collabwatchlistinverttags' => 'Stichwortfilter umdreie',
	'collabwatchlistdelete-submit' => 'Lösche',
	'collabwatchlistnew-name' => 'Name vo de Lischt',
	'collabwatchlistedit-normal-submit' => 'Spychere',
	'tog-collabwatchlisthidelistusers' => 'Due Änderige vo andere gmeinsame Beobachtigslischtebenutzer ussblände.',
);

/** Hebrew (עברית)
 * @author Deror avi
 * @author Ofekalef
 */
$messages['he'] = array(
	'collabwatchlisttagcomment' => 'הערה',
	'collabwatchlisttools-view' => 'תצוגה',
	'collabwatchlisttools-edit' => 'עריכת קטגוריות',
	'collabwatchlisttools-delete' => 'מחיקה',
	'collabwatchlistsall' => 'כל הרשימות',
	'collabwatchlistfiltertags' => 'הסתרת תגיות',
	'collabwatchlistedit-users-raw-submit' => 'שמירה',
	'collabwatchlistedit-raw-titles' => 'קטגוריות:',
	'collabwatchlistedit-users-raw-titles' => 'משתמשים:',
	'collabwatchlistedit-normal-title' => 'עריכת קטגוריות',
	'collabwatchlistedit-tags-raw-submit' => 'שמירה',
	'collabwatchlistdelete-submit' => 'מחיקה',
	'collabwatchlistdelete-title' => 'מחיקת רשימת מעקב שיתופית',
	'collabwatchlistnew-legend' => 'יצירת רשימת מעקב שיתופית חדשה',
	'collabwatchlistnew-explain' => 'שם הרשימה חייב להיות יחידאי.',
	'collabwatchlistnew-name' => 'שם הרשימה',
	'collabwatchlistnew-submit' => 'ליצירה',
	'collabwatchlistedit-raw-done' => 'רשימת המעקב השיתופית עודכנה',
	'collabwatchlistedit-normal-submit' => 'שמירה',
	'tog-collabwatchlisthidelistusers' => 'הסתרת עריכות ממשתמשי רשימת מעקב שיתופית',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'collabwatchlist' => 'Zhromadna wobkedźbowanska lisćina',
	'collabwatchlist-desc' => 'Staja zhromadne wobkedźbowanske lisćiny na zakładźe kategorijow k dispoziciji',
	'specialcollabwatchlist' => 'Specialna strona zhromadneje wobkedźbowanskeje lisćiny',
	'collabwatchlist-details' => '{{PLURAL:$1|$1 kategorija/strona|$1 kategoriji/stronje|$1 kategorije/strony|$1 kategorijow/stronow}} na tutej wobkedźbowanskej lisćinje.',
	'collabwatchlisttagselect' => 'Taflička',
	'collabwatchlisttagcomment' => 'Komentar',
	'collabwatchlistsettagbutton' => 'Tafličku stajić',
	'collabwatchlisttools-view' => 'Zwobraznić',
	'collabwatchlisttools-edit' => 'Kategorije wobdźěłać',
	'collabwatchlisttools-rawCategories' => 'Kategorije w surowej formje wobdźěłać',
	'collabwatchlisttools-rawTags' => 'Taflički w surowej formje wobdźěłać',
	'collabwatchlisttools-rawUsers' => 'Wužiwarjow w surowej formje wobdźěłać',
	'collabwatchlisttools-delete' => 'Zhašeć',
	'collabwatchlistsall' => 'Wšě lisćiny',
	'collabwatchlistfiltertags' => 'Taflički schować',
	'collabwatchlistedit-users-raw-submit' => 'Składować',
	'collabwatchlistedit-raw-title' => 'Kategorije w surowej formje wobdźěłać',
	'collabwatchlistedit-tags-raw-title' => 'Taflički w surowej formje wobdźěłać',
	'collabwatchlistedit-users-raw-title' => 'Wužiwarjow w surowej formje wobdźěłać',
	'collabwatchlistedit-users-last-owner' => 'Dyrbi znajmjeńša jednoho wobsedźerja eksistować',
	'collabwatchlistedit-numitems' => 'Tuta zhromadna wobkedźbowanska lisćina wobsahuje {{PLURAL:$1|1 kategoriju|$1 kategoriji|$1 kategorije|$1 kategorijow}}',
	'collabwatchlistedit-noitems' => 'Tuta zhromadna wobkedźbowanska lisćina žane kategorije njewobsahuje .',
	'collabwatchlistedit-tags-numitems' => 'Tuta zhromadna wobkedźbowanska lisćina wobsahuje {{PLURAL:$1|1 hesło|$1 hesle|$1 hesła|$1 hesłow}}',
	'collabwatchlistedit-tags-noitems' => 'Tuta zhromadna wobkedźbowanska lisćina žane hesła njewobsahuje.',
	'collabwatchlistedit-users-numitems' => 'Tuta zhromadna wobkedźbowanska lisćina wobsahuje {{PLURAL:$1|1 wužiwarja|$1 wužiwarjow|$1 wužiwarjow|$1 wužiwarjow}}',
	'collabwatchlistedit-users-noitems' => 'Tuta zhromadna wobkedźbowanska lisćina žanych wužiwarjow njewobsahuje .',
	'collabwatchlistedit-raw-legend' => 'Kategorije zhromadneje wobkedźbowanskeje lisćiny w surowej formje wobdźěłać',
	'collabwatchlistedit-users-raw-legend' => 'Wužiwarjow zhromadneje wobkedźbowanskeje lisćiny w surowej formje wobdźěłać',
	'collabwatchlistedit-tags-raw-legend' => 'Hesła zhromadneje wobkedźbowanskeje lisćiny w surowej formje wobdźěłać',
	'collabwatchlistedit-raw-explain' => 'Kategorije na zhromadnej wobkedźbowanskej lisćinje so dleka pokazuja a hodźa so přidać a wotstroić.',
	'collabwatchlistedit-tags-raw-explain' => 'Hesła na zhromadnej wobkedźbowanskej lisćinje so dleka pokazuja a hodźa so přidać a wotstroić.',
	'collabwatchlistedit-users-raw-explain' => 'Wužiwarjo na zhromadnej wobkedźbowanskej lisćinje so dleka pokazuja a hodźa so přidać a wotstroić.',
	'collabwatchlistedit-raw-titles' => 'Kategorije:',
	'collabwatchlistedit-tags-raw-titles' => 'Hesła:',
	'collabwatchlistedit-users-raw-titles' => 'Wužiwarjo:',
	'collabwatchlistedit-normal-title' => 'Kategorije wobdźěłać',
	'collabwatchlistedit-normal-legend' => 'Kategorije ze zhromadneje wobkedźbowanskeje lisćiny wotstronić',
	'collabwatchlistedit-normal-explain' => 'Kategorije na twojej zhromadnej wobkedźbowanskej lisćinje so deleka pokazuja.',
	'collabwatchlistedit-tags-raw-submit' => 'Składować',
	'collabwatchlistedit-normal-done' => '{{PLURAL:$1|1 kategorija je|$1 kategoriji stej|$1 kategorije su|$1 kategorijow je}} so ze zhromadneje wobkedźbowanskeje lisćiny {{PLURAL:$1|wotstroniła|wotstroniłoj|wotstronili|wotstroniło}}:',
	'collabwatchlistedit-tags-raw-done' => 'Zhromadna wobkedźbowanska lisćina je so zaktualizowała',
	'collabwatchlistedit-users-raw-done' => 'Zhromadna wobkedźbowanska lisćina je so zaktualizowała',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|1 hesło je so přidało|$1 hesle stej so přidałoj|$1 hesła su so přidali|$1 hesłow je so přidało}}',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|1 wužiwar je so přidał|$1 wužiwarjej staj so přidałoj|$1 wužiwarjo su so přidali|$1 wužiwarjow je so přidało}}',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|1 hesło je so wotstroniło|$1 hesle stej so wotstroniłoj|$1 hesła su so wotstronili|$1 hesłow je so wotstroniło}}',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|1 wužiwar je so wotstronił|$1 wužiwarjej staj so wotstroniłoj|$1 wužiwarjo su so wotstronili|$1 wužiwarjow je so wotstroniło}}',
	'collabwatchlistinverttags' => 'Hesłowy filter wobroćić',
	'collabwatchlistpatrol' => 'Změny dohladować',
	'collabwatchlisttools-newList' => 'Nowa zhromadna wobkedźbowanska lisćina',
	'collabwatchlistdelete-legend' => 'Zhromadnu wobkedźbowansku lisćinu zhašeć',
	'collabwatchlistdelete-explain' => 'Přez wotstronjenje zhromadneje wobkedźbowanskeje lisćiny budu so wšě slědy z wobkedźbowanskeje lisćiny wotstronjeć. Hesła, kotrež su so změnam připokazali, so wobchowuja.',
	'collabwatchlistdelete-submit' => 'Zhašeć',
	'collabwatchlistdelete-title' => 'Zhromadnu wobkedźbowansku lisćinu zhašeć',
	'collabwatchlistedit-set-tags-numitems' => 'Tuta zhromadna wobkedźbowanska lisćina je {{PLURAL:$1|1 hesło stajene|$1 hesle stajenej|$1 hesła stajene|$1 hesłow stajenych}}',
	'collabwatchlistedit-set-tags-noitems' => 'Tuta zhromadna wobkedźbowanska lisćina njeje žane hesła stajiła.',
	'collabwatchlistnew-legend' => 'Nowu zhromadnu wobkedźbowansku lisćinu wutworić',
	'collabwatchlistnew-explain' => 'Mjeno lisćiny dyrbi jónkróćne być.',
	'collabwatchlistnew-name' => 'Mjeno lisćiny',
	'collabwatchlistnew-submit' => 'Wutworić',
	'collabwatchlistedit-raw-done' => 'Zhromadna wobkedźbowanska lisćina je so zaktualizowała',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|1 strona abo kategorija je so přidała|$1 stronje abo kategoriji stej so přidałoj|$1 strony abo kategorije su so přidali|$1 stronow abo kategorijow je so přidało}}',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|1 strona abo kategorija je so wotstroniła|$1 stronje abo kategoriji stej so wotstroniłoj|$1 strony abo kategorije su so wotstronili|$1 stronow abo kategorijow je so wotstroniło}}',
	'collabwatchlistedit-normal-submit' => 'Składować',
	'collabwatchlistshowhidelistusers' => 'Lisćinowych wužiwarjow $1',
	'tog-collabwatchlisthidelistusers' => 'Změny wužiwarjow zhromadneje wobkedźbowanskeje lisćiny schować',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'collabwatchlist' => 'Observatorio collaborative',
	'collabwatchlist-desc' => 'Forni observatorios collaborative a base de categorias',
	'specialcollabwatchlist' => 'Pagina special pro observatorio collaborative',
	'collabwatchlist-details' => '{{PLURAL:$1|$1 categoria/pagina|$1 categorias/paginas}} in iste observatorio collaborative.',
	'collabwatchlisttagselect' => 'Etiquetta',
	'collabwatchlisttagcomment' => 'Commento',
	'collabwatchlistsettagbutton' => 'Mitter etiquetta',
	'collabwatchlisttools-view' => 'Presentar',
	'collabwatchlisttools-edit' => 'Modificar categorias',
	'collabwatchlisttools-rawCategories' => 'Modificar categorias in forma crude',
	'collabwatchlisttools-rawTags' => 'Modificar etiquettas in forma crude',
	'collabwatchlisttools-rawUsers' => 'Modificar usatores in forma crude',
	'collabwatchlisttools-delete' => 'Deler',
	'collabwatchlistsall' => 'Tote le listas',
	'collabwatchlistfiltertags' => 'Celar etiquettas',
	'collabwatchlistedit-users-raw-submit' => 'Salveguardar',
	'collabwatchlistedit-raw-title' => 'Modification crude de categorias',
	'collabwatchlistedit-tags-raw-title' => 'Modification crude de etiquettas',
	'collabwatchlistedit-users-raw-title' => 'Modification crude de usatores',
	'collabwatchlistedit-users-last-owner' => 'Il debe haber al minus un proprietario',
	'collabwatchlistedit-numitems' => 'Iste observatorio collaborative contine {{PLURAL:$1|1 categoria|$1 categorias}}',
	'collabwatchlistedit-noitems' => 'Iste observatorio collaborative non contine categorias.',
	'collabwatchlistedit-tags-numitems' => 'Iste observatorio collaborative contine {{PLURAL:$1|1 etiquetta|$1 etiquettas}}',
	'collabwatchlistedit-tags-noitems' => 'Iste observatorio collaborative non contine etiquettas.',
	'collabwatchlistedit-users-numitems' => 'Iste observatorio collaborative contine {{PLURAL:$1|1 usator|$1 usatores}}',
	'collabwatchlistedit-users-noitems' => 'Iste observatorio collaborative non contine usatores.',
	'collabwatchlistedit-raw-legend' => 'Modification crude del categorias sub observation collaborative',
	'collabwatchlistedit-users-raw-legend' => 'Modification crude del usatores sub observation collaborative',
	'collabwatchlistedit-tags-raw-legend' => 'Modification crude del etiquettas sub observation collaborative',
	'collabwatchlistedit-raw-explain' => 'Le categorias sub observation collaborative es monstrate hic infra. Es possibile modificar le lista per adder e remover categorias.',
	'collabwatchlistedit-tags-raw-explain' => 'Le etiquettas sub observation collaborative es monstrate hic infra. Es possibile modificar le lista per adder e remover etiquettas.',
	'collabwatchlistedit-users-raw-explain' => 'Le usatores sub observation collaborative es monstrate hic infra. Es possibile modificar le lista per adder e remover usatores.',
	'collabwatchlistedit-raw-titles' => 'Categorias:',
	'collabwatchlistedit-tags-raw-titles' => 'Etiquettas:',
	'collabwatchlistedit-users-raw-titles' => 'Usatores:',
	'collabwatchlistedit-normal-title' => 'Modificar categorias',
	'collabwatchlistedit-normal-legend' => 'Remover categorias del observatorio collaborative',
	'collabwatchlistedit-normal-explain' => 'Le categorias sub observation collaborative es monstrate hic infra.',
	'collabwatchlistedit-tags-raw-submit' => 'Salveguardar',
	'collabwatchlistedit-normal-done' => '{{PLURAL:$1|1 categoria|$1 categorias}} ha essite removite del observatorio collaborative:',
	'collabwatchlistedit-tags-raw-done' => 'Le observatorio collaborative ha essite actualisate.',
	'collabwatchlistedit-users-raw-done' => 'Le observatorio collaborative ha essite actualisate.',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|1 etiquetta|$1 etiquettas}} ha essite addite:',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|1 usator|$1 usatores}} ha essite addite:',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|1 etiquetta|$1 etiquettas}} ha essite removite:',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|1 usator|$1 usatores}} ha essite removite:',
	'collabwatchlistinverttags' => 'Inverter filtro de etiquettas',
	'collabwatchlistpatrol' => 'Modificationes de patrulia',
	'collabwatchlisttools-newList' => 'Nove observatorio collaborative',
	'collabwatchlistdelete-legend' => 'Deler un observatorio collaborative',
	'collabwatchlistdelete-explain' => 'Deler un observatorio collaborative resulta in le elimination de tote tracia de illo. Le etiquettas associate al modificationes essera preservate.',
	'collabwatchlistdelete-submit' => 'Deler',
	'collabwatchlistdelete-title' => 'Deler observatorio collaborative',
	'collabwatchlistedit-set-tags-numitems' => 'Iste observatorio collaborative ha {{PLURAL:$1|1 etiquetta|$1 etiquettas}}',
	'collabwatchlistedit-set-tags-noitems' => 'Iste observatorio collaborative non ha etiquettas.',
	'collabwatchlistnew-legend' => 'Crear un nove observatorio collaborative',
	'collabwatchlistnew-explain' => 'Le nomine del lista debe esser unic.',
	'collabwatchlistnew-name' => 'Nomine del lista',
	'collabwatchlistnew-submit' => 'Crear',
	'collabwatchlistedit-raw-done' => 'Le observatorio collaborative ha essite actualisate.',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|1 pagina/categoria|$1 paginas/categorias}} ha essite addite:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|1 pagina/categoria|$1 paginas/categorias}} ha essite removite.',
	'collabwatchlistedit-normal-submit' => 'Salveguardar',
	'collabwatchlistshowhidelistusers' => '$1 usatores del lista',
	'tog-collabwatchlisthidelistusers' => 'Celar modificationes del usatores del observatorio collaborative',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Kenrick95
 */
$messages['id'] = array(
	'collabwatchlist' => 'Daftar pantauan kolaboratif',
	'collabwatchlisttagselect' => 'Penanda',
	'collabwatchlisttagcomment' => 'Komentar',
	'collabwatchlistsettagbutton' => 'Atur penanda',
	'collabwatchlisttools-view' => 'Tampilan',
	'collabwatchlisttools-edit' => 'Sunting kategori',
	'collabwatchlisttools-rawCategories' => 'Sunting mentah kategori',
	'collabwatchlisttools-rawTags' => 'Sunting mentah penanda',
	'collabwatchlisttools-rawUsers' => 'Sunting mentah pengguna',
	'collabwatchlisttools-delete' => 'Hapus',
	'collabwatchlistsall' => 'Semua daftar',
	'collabwatchlistfiltertags' => 'Sembunyikan penanda',
	'collabwatchlistedit-users-raw-submit' => 'Simpan',
	'collabwatchlistedit-tags-raw-submit' => 'Simpan',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'collabwatchlisttools-delete' => '削除',
	'collabwatchlistedit-raw-titles' => 'カテゴリー:',
	'collabwatchlistdelete-submit' => '削除',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Welathêja
 */
$messages['ku-latn'] = array(
	'collabwatchlisttools-delete' => 'Jê bibe',
	'collabwatchlistedit-users-raw-submit' => 'Tomar bike',
	'collabwatchlistedit-normal-submit' => 'Tomar bike',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'collabwatchlist' => 'Gemeinsam Iwwerwaachungslëscht',
	'collabwatchlist-desc' => 'Erméiglecht gemeinsam Iwwerwaachungslëschten déi op Kategorie baséieren',
	'specialcollabwatchlist' => 'Spezialsäit Gemeinsam Iwwerwwaachungslëscht',
	'collabwatchlist-details' => '{{PLURAL:$1|$1 Kategorie/Säit|$1 Kategorien/Säiten}} op dëser gemeinsamer Iwwerwaachungslëscht.',
	'collabwatchlisttagselect' => 'Tag',
	'collabwatchlisttagcomment' => 'Bemierkung',
	'collabwatchlisttools-view' => 'Weisen',
	'collabwatchlisttools-edit' => 'Kategorien änneren',
	'collabwatchlisttools-rawCategories' => 'Kategorien net-formatéiert änneren',
	'collabwatchlisttools-rawUsers' => 'Benotzer net-formatéiert änneren',
	'collabwatchlisttools-delete' => 'Läschen',
	'collabwatchlistsall' => 'All Lëschten',
	'collabwatchlistedit-users-raw-submit' => 'Späicheren',
	'collabwatchlistedit-raw-title' => 'Kategorien net-formatéiert änneren',
	'collabwatchlistedit-users-raw-title' => 'Benotzer net-formatéiert änneren',
	'collabwatchlistedit-users-last-owner' => 'Et muss mindestens ee Proprietaire ginn',
	'collabwatchlistedit-numitems' => 'Dës gemeinsam Iwwerwaachungslëscht huet {{PLURAL:$1|1 Kategorie |$1 Kategorien}}',
	'collabwatchlistedit-noitems' => 'Op dëser gemeinsamer Iwwerwaachungslëscht sti keng Kategorien.',
	'collabwatchlistedit-users-numitems' => 'Dës gemeinsam Iwwerwaachungslëscht huet {{PLURAL:$1|1 Benotzer|$1 Benotzer}}',
	'collabwatchlistedit-users-noitems' => 'Op dëser gemeinsamer Iwwerwaachungslëscht sti keng Benotzer.',
	'collabwatchlistedit-raw-legend' => 'Kategorie vun der gemeinsamer Iwwerwaachungslëscht onformatéiert änneren',
	'collabwatchlistedit-users-raw-legend' => 'Benotzer vun der gemeinsamer Iwwerwaachungslëscht onformatéiert änneren',
	'collabwatchlistedit-raw-explain' => "D'Kategorie vun der gemeinsamer Iwwerwaachungslëscht stinn hei drënner, a kënne geännert ginn an deem der op Lëscht derbäigesat oder dovun erofgeholl ginn",
	'collabwatchlistedit-tags-raw-explain' => "D'Tags op der gemeinsamer Iwwerwaachungslëscht stinn hei drënner, a kënne geännert ginn an deem der op Lëscht derbäigesat oder dovun erofgeholl ginn",
	'collabwatchlistedit-users-raw-explain' => "D'Benotzer vun der gemeinsamer Iwwerwaachungslëscht stinn hei drënner, a kënne geännert ginn an deem der op Lëscht derbäigesat oder dovun erofgeholl ginn.",
	'collabwatchlistedit-raw-titles' => 'Kategorien:',
	'collabwatchlistedit-users-raw-titles' => 'Benotzer:',
	'collabwatchlistedit-normal-title' => 'Kategorien änneren',
	'collabwatchlistedit-normal-legend' => 'Kategorie vun der gemeinsamer Iwwerwaachungslëscht erofhuelen',
	'collabwatchlistedit-normal-explain' => 'Kategorie vun Ärer gemeinsamer Iwwerwaachungslëscht stinn hei drënner.',
	'collabwatchlistedit-tags-raw-submit' => 'Späicheren',
	'collabwatchlistedit-normal-done' => '{{PLURAL:$1|1 Kategorie gouf|$1 Kategorië goufe}} vun der gemeinsamer Iwwerwaachungslëscht erofgeholl:',
	'collabwatchlistedit-tags-raw-done' => 'Déi gemeinsam Iwwerwaachungslëscht gouf aktualiséiert',
	'collabwatchlistedit-users-raw-done' => 'Déi gemeinsam Iwwerwaachungslëscht gouf aktualiséiert.',
	'collabwatchlistedit-users-raw-added' => '$1 Benotzer {{PLURAL:$1|gouf|goufen}} derbäigesat:',
	'collabwatchlistedit-users-raw-removed' => '$1 Benotzer {{PLURAL:$1|gouf|goufen}} ewechgeholl:',
	'collabwatchlistpatrol' => 'Ännerunge kontrolléieren',
	'collabwatchlisttools-newList' => 'Nei gemeinsam Iwwerwaachungslëscht',
	'collabwatchlistdelete-legend' => 'Eng gemeinsam Iwwerwaachungslëscht läschen',
	'collabwatchlistdelete-submit' => 'Läschen',
	'collabwatchlistdelete-title' => 'Gemeinsam Iwwerwaachungslëscht läschen',
	'collabwatchlistnew-legend' => 'Eng nei gemeinsam Iwwerwaachungslëscht uleeën',
	'collabwatchlistnew-explain' => 'Den Numm vun der Lëscht muss eenzeg sinn (et däerf keng zweet Lëscht mat deemselwechten Numm ginn)',
	'collabwatchlistnew-name' => 'Numm vun der Lëscht',
	'collabwatchlistnew-submit' => 'Uleeën',
	'collabwatchlistedit-raw-done' => 'Déi gemeinsam Iwwerwaachungslëscht gouf aktualiséiert',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|1 Kategorie/Säit gouf|$1 Kategorien/Säite goufen}} derbäigesat:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|1 Kategorie/Säit gouf|$1 Kategorien/Säite goufen}} ewechgeholl:',
	'collabwatchlistedit-normal-submit' => 'Späicheren',
	'collabwatchlistshowhidelistusers' => '$1 Lëscht vun de Benotzer',
	'tog-collabwatchlisthidelistusers' => 'Ännerunge vu Benotzer vun der gemeinsamer Iwwerwaachungslëscht verstoppen',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'collabwatchlisttagselect' => 'Žyma',
	'collabwatchlisttagcomment' => 'Komentaras',
	'collabwatchlistsettagbutton' => 'Nustatyti žymę',
	'collabwatchlisttools-edit' => 'Redaguoti kategorijas',
	'collabwatchlisttools-delete' => 'Ištrinti',
	'collabwatchlistsall' => 'Visi sąrašai',
	'collabwatchlistfiltertags' => 'Slėpti žymes',
	'collabwatchlistedit-users-raw-submit' => 'Išsaugoti',
	'collabwatchlistedit-raw-titles' => 'Kategorijos:',
	'collabwatchlistedit-tags-raw-titles' => 'Žymės:',
	'collabwatchlistedit-users-raw-titles' => 'Naudotojai:',
	'collabwatchlistedit-normal-title' => 'Redaguoti kategorijas',
	'collabwatchlistedit-tags-raw-submit' => 'Išsaugoti',
	'collabwatchlistdelete-submit' => 'Ištrinti',
	'collabwatchlistnew-name' => 'Sąrašo pavadinimas',
	'collabwatchlistnew-submit' => 'Sukurti',
	'collabwatchlistedit-normal-submit' => 'Išsaugoti',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'collabwatchlist' => 'Соработен список на набљудувања',
	'collabwatchlist-desc' => 'Овозможува соработни `списоци на набљудувања на основа на категории',
	'specialcollabwatchlist' => 'Специјална страница за соработни списоци на набљудувања',
	'collabwatchlist-details' => '{{PLURAL:$1|$1 категорија/страница|$1 категории/страници}} на овој соработен список ан набљудувања.',
	'collabwatchlisttagselect' => 'Ознака',
	'collabwatchlisttagcomment' => 'Коментар',
	'collabwatchlistsettagbutton' => 'Постави ознака',
	'collabwatchlisttools-view' => 'Прикажи',
	'collabwatchlisttools-edit' => 'Уреди категории',
	'collabwatchlisttools-rawCategories' => 'Категории за сирово уредување',
	'collabwatchlisttools-rawTags' => 'Ознаки за сирово уредување',
	'collabwatchlisttools-rawUsers' => 'Корисници за сирово уредување',
	'collabwatchlisttools-delete' => 'Избриши',
	'collabwatchlistsall' => 'Сите списоци',
	'collabwatchlistfiltertags' => 'Скриј ознаки',
	'collabwatchlistedit-users-raw-submit' => 'Зачувај',
	'collabwatchlistedit-raw-title' => 'Категории за сирово уредување',
	'collabwatchlistedit-tags-raw-title' => 'Ознаки за сирово уредување',
	'collabwatchlistedit-users-raw-title' => 'Корисници за сирово уредување',
	'collabwatchlistedit-users-last-owner' => 'Мора да има барем еден сопственик',
	'collabwatchlistedit-numitems' => 'Оваој соработен список на набљудувања содржи {{PLURAL:$1|1 категорија|$1 категории}}',
	'collabwatchlistedit-noitems' => 'Овој соработен список на набљудувања не содржи категории.',
	'collabwatchlistedit-tags-numitems' => 'Оваој соработен список на набљудувања содржи {{PLURAL:$1|1 ознака|$1 ознаки}}',
	'collabwatchlistedit-tags-noitems' => 'Оваој соработен список на набљудувања не содржи ознаки.',
	'collabwatchlistedit-users-numitems' => 'Оваој соработен список на набљудувања содржи {{PLURAL:$1|1 корисник|$1 корисници}}',
	'collabwatchlistedit-users-noitems' => 'Оваој соработен список на набљудувања не содржи корисници.',
	'collabwatchlistedit-raw-legend' => 'Категории за сирово уредување на соработни списоци на набљудувања',
	'collabwatchlistedit-users-raw-legend' => 'Корисници за сирово уредување на соработни списоци на набљудувања',
	'collabwatchlistedit-tags-raw-legend' => 'Ознаки за сирово уредување на соработни списоци на набљудувања',
	'collabwatchlistedit-raw-explain' => 'Категориите на соработниот список на набљудувања се прикажани подолу, и можат да се уредуваат со надополнување или отстранување на ставки од списокот',
	'collabwatchlistedit-tags-raw-explain' => 'Ознаките на соработниот список на набљудувања се прикажани подолу, и можат да се уредуваат со надополнување или отстранување на ставки од списокот',
	'collabwatchlistedit-users-raw-explain' => 'Корисниците на соработниот список на набљудувања се прикажани подолу, и можат да се уредуваат со надополнување или отстранување на ставки од списокот',
	'collabwatchlistedit-raw-titles' => 'Категории:',
	'collabwatchlistedit-tags-raw-titles' => 'Ознаки:',
	'collabwatchlistedit-users-raw-titles' => 'Корисник:',
	'collabwatchlistedit-normal-title' => 'Уредување на категории',
	'collabwatchlistedit-normal-legend' => 'Отстранување на категории од соработниот список на набљудувања',
	'collabwatchlistedit-normal-explain' => 'Категориите на соработниот список на набљудувања се прикажани подолу.',
	'collabwatchlistedit-tags-raw-submit' => 'Зачувај',
	'collabwatchlistedit-normal-done' => '{{PLURAL:$1|Отстранета е 1 категорија|Отстранети се $1 категории}} од соработниот список на набљудувања:',
	'collabwatchlistedit-tags-raw-done' => 'Соработниот список на набљудувања е подновен.',
	'collabwatchlistedit-users-raw-done' => 'Соработниот список на набљудувања е подновен.',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|Додадена е 1 ознака|Додадени се $1 ознаки}}:',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|Додаден е 1 корисник|Додадени се $1 корисници}}:',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|Отстранета е 1 ознака|Отстранети се $1 ознаки}}:',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|Отстранет е 1 корисник|Отстранети се $1 корисници}}:',
	'collabwatchlistinverttags' => 'Обратен филтер на ознаки',
	'collabwatchlistpatrol' => 'Патролирај уредувања',
	'collabwatchlisttools-newList' => 'Нов соработен список на набљудувања',
	'collabwatchlistdelete-legend' => 'Избриши соработен список на набљудувања',
	'collabwatchlistdelete-explain' => 'Бришејќи го соработниот список на набљудувања ќе ги избришете сите траги од него. Ознаките поставени на уредувањата сепак ќе бидат зачувани.',
	'collabwatchlistdelete-submit' => 'Избриши',
	'collabwatchlistdelete-title' => 'Избриши соработен список на набљудувања',
	'collabwatchlistedit-set-tags-numitems' => 'Овој соработен список на набљудувања има {{PLURAL:$1|1 зададена ознака|$1 зададени ознаки}}',
	'collabwatchlistedit-set-tags-noitems' => 'На овој соработен список на набљудувања не му се зададени ознаки',
	'collabwatchlistnew-legend' => 'Создај нов соработен список на набљудувања',
	'collabwatchlistnew-explain' => 'Списокот треба да има уникатно име.',
	'collabwatchlistnew-name' => 'Име на списокот',
	'collabwatchlistnew-submit' => 'Создај',
	'collabwatchlistedit-raw-done' => 'Соработниот список на набљудувања е подновен',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|Додадена е 1 страница/категорија was|Додадени се $1 страници/категории}}:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|Отстранета е 1 страница/категорија was|Отстранети се $1 страници/категории}}:',
	'collabwatchlistedit-normal-submit' => 'Зачувај',
	'collabwatchlistshowhidelistusers' => '$1 корисници на списокот',
	'tog-collabwatchlisthidelistusers' => 'Скриј ги уедувањата од корисници на соработни списоци на набљудувања',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'collabwatchlisttagcomment' => 'Komen',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 */
$messages['nb'] = array(
	'collabwatchlisttagselect' => 'Tagg',
	'collabwatchlisttagcomment' => 'Kommentar',
	'collabwatchlistsettagbutton' => 'Angi tagg',
	'collabwatchlisttools-view' => 'Visning',
	'collabwatchlisttools-edit' => 'Rediger kategorier',
	'collabwatchlisttools-rawCategories' => 'Rå redigeringskategorier',
	'collabwatchlisttools-rawTags' => 'Rå redigeringstagger',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'collabwatchlisttagcomment' => 'टिप्पणी',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'collabwatchlist' => 'Gezamenlijke volglijst',
	'collabwatchlist-desc' => 'Biedt een gezamenlijke volglijst gebaseerd op categorieën',
	'specialcollabwatchlist' => 'Gezamenlijke volglijst',
	'collabwatchlist-details' => "Er {{PLURAL:$1|staat $1 categorie of pagina|staan $1 categorieën of pagina's}} in deze gezamenlijke volglijst.",
	'collabwatchlisttagselect' => 'Label',
	'collabwatchlisttagcomment' => 'Opmerking',
	'collabwatchlistsettagbutton' => 'Label instellen',
	'collabwatchlisttools-view' => 'Weergeven',
	'collabwatchlisttools-edit' => 'Categorieën bewerken',
	'collabwatchlisttools-rawCategories' => 'Ruwe categorieënlijst bewerken',
	'collabwatchlisttools-rawTags' => 'Ruwe labellijst bewerken',
	'collabwatchlisttools-rawUsers' => 'Ruwe gebruikerslijst bewerken',
	'collabwatchlisttools-delete' => 'Verwijderen',
	'collabwatchlistsall' => 'Alle lijsten',
	'collabwatchlistfiltertags' => 'Labels verbergen',
	'collabwatchlistedit-users-raw-submit' => 'Opslaan',
	'collabwatchlistedit-raw-title' => 'Ruwe categorieënlijst bewerken',
	'collabwatchlistedit-tags-raw-title' => 'Ruwe labellijst bewerken',
	'collabwatchlistedit-users-raw-title' => 'Ruwe gebruikerslijst bewerken',
	'collabwatchlistedit-users-last-owner' => 'Er moet ten minste één eigenaar zijn',
	'collabwatchlistedit-numitems' => 'Deze gezamenlijke volglijst bevat {{PLURAL:$1|1 categorie|$1 categorieën}}',
	'collabwatchlistedit-noitems' => 'Deze gezamenlijke volglijst bevat geen categorieën.',
	'collabwatchlistedit-tags-numitems' => 'Deze gezamenlijke volglijst bevat {{PLURAL:$1|1 label|$1 labels}}',
	'collabwatchlistedit-tags-noitems' => 'Deze gezamenlijke volglijst bevat geen labels.',
	'collabwatchlistedit-users-numitems' => 'Deze gezamenlijke volglijst bevat {{PLURAL:$1|1 gebruiker|$1 gebruikers}}',
	'collabwatchlistedit-users-noitems' => 'Deze gezamenlijke volglijst bevat geen gebruikers.',
	'collabwatchlistedit-raw-legend' => 'Ruwe categorieënlijst van de gezamenlijke volglijst bewerken',
	'collabwatchlistedit-users-raw-legend' => 'Ruwe gebruikerslijst van de gezamenlijke volglijst bewerken',
	'collabwatchlistedit-tags-raw-legend' => 'Ruwe labellijst van de gezamenlijke volglijst bewerken',
	'collabwatchlistedit-raw-explain' => 'Categorieën in de gezamenlijke volglijst worden hieronder weergegeven en kunnen bewerkt worden door ze toe te voegen en te verwijderen van de lijst.',
	'collabwatchlistedit-tags-raw-explain' => 'Labels in de gezamenlijke volglijst worden hieronder weergegeven en kunnen bewerkt worden door ze toe te voegen en te verwijderen van de lijst.',
	'collabwatchlistedit-users-raw-explain' => 'Gebruikers in de gezamenlijke volglijst worden hieronder weergegeven en kunnen bewerkt worden door ze toe te voegen en te verwijderen van de lijst.',
	'collabwatchlistedit-raw-titles' => 'Categorieën:',
	'collabwatchlistedit-tags-raw-titles' => 'Labels:',
	'collabwatchlistedit-users-raw-titles' => 'Gebruikers:',
	'collabwatchlistedit-normal-title' => 'Categorieën bewerken',
	'collabwatchlistedit-normal-legend' => 'Categorieën verwijderen uit gezamenlijke volglijst',
	'collabwatchlistedit-normal-explain' => 'Categorieën in uw gezamenlijke volglijst ​​worden hieronder weergegeven.',
	'collabwatchlistedit-tags-raw-submit' => 'Opslaan',
	'collabwatchlistedit-normal-done' => 'Er {{PLURAL:$1|is 1 categorie|zijn $1 categorieën}} verwijderd uit de gezamenlijke volglijst:',
	'collabwatchlistedit-tags-raw-done' => 'De gezamenlijke volglijst is bijgewerkt.',
	'collabwatchlistedit-users-raw-done' => 'De gezamenlijke volglijst is bijgewerkt.',
	'collabwatchlistedit-tags-raw-added' => 'Er {{PLURAL:$1|is 1 label|zijn $1 labels}} toegevoegd:',
	'collabwatchlistedit-users-raw-added' => 'Er {{PLURAL:$1|is 1 gebruiker|zijn $1 gebruikers}} toegevoegd:',
	'collabwatchlistedit-tags-raw-removed' => 'Er {{PLURAL:$1|is 1 label|zijn $1 labels}} verwijderd:',
	'collabwatchlistedit-users-raw-removed' => 'Er {{PLURAL:$1|is 1 gebruiker|zijn $1 gebruikers}} verwijderd:',
	'collabwatchlistinverttags' => 'Labelfilter omkeren',
	'collabwatchlistpatrol' => 'Wijzigingen controleren',
	'collabwatchlisttools-newList' => 'Nieuwe gezamenlijke volglijst',
	'collabwatchlistdelete-legend' => 'Gezamenlijke volglijst verwijderen',
	'collabwatchlistdelete-explain' => 'Door het verwijderen van een gezamenlijke volglijst worden alle sporen van de volglijst verwijderd. Labels die zijn ingesteld voor de bewerkingen worden bewaard.',
	'collabwatchlistdelete-submit' => 'Verwijderen',
	'collabwatchlistdelete-title' => 'Gezamenlijke volglijst verwijderen',
	'collabwatchlistedit-set-tags-numitems' => 'In deze gezamenlijke volglijst {{PLURAL:$1|is 1 label|zijn $1 labels}} ingesteld',
	'collabwatchlistedit-set-tags-noitems' => 'In deze gezamenlijke volglijst zijn geen labels ingesteld',
	'collabwatchlistnew-legend' => 'Nieuwe gezamenlijke volglijst aanmaken',
	'collabwatchlistnew-explain' => 'De naam van de lijst moet uniek zijn.',
	'collabwatchlistnew-name' => 'Lijstnaam',
	'collabwatchlistnew-submit' => 'Aanmaken',
	'collabwatchlistedit-raw-done' => 'De gezamenlijke volglijst is bijgewerkt.',
	'collabwatchlistedit-raw-added' => "Er {{PLURAL:$1|is $1 categorie of pagina|zijn $1 categorieën of pagina's}} toegevoegd:",
	'collabwatchlistedit-raw-removed' => "Er {{PLURAL:$1|is $1 categorie of pagina|zijn $1 categorieën of pagina's}} verwijderd",
	'collabwatchlistedit-normal-submit' => 'Opslaan',
	'collabwatchlistshowhidelistusers' => 'Lijstgebruikers $1',
	'tog-collabwatchlisthidelistusers' => 'Bewerkingen van gebruikers van de gezamenlijke volglijst verbergen',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'collabwatchlistedit-raw-titles' => 'ଶ୍ରେଣୀସମୂହ:',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'collabwatchlisttools-delete' => 'Verwische',
	'collabwatchlistedit-users-raw-submit' => 'Beilege',
	'collabwatchlistedit-raw-titles' => 'Abdeelinge:',
	'collabwatchlistedit-users-raw-titles' => 'Yuuser:',
	'collabwatchlistedit-tags-raw-submit' => 'Beilege',
	'collabwatchlistdelete-submit' => 'Verwische',
	'collabwatchlistedit-normal-submit' => 'Beilege',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'collabwatchlisttagselect' => 'Etykieta',
	'collabwatchlisttagcomment' => 'Komentarz',
	'collabwatchlisttools-view' => 'Wyświetl',
	'collabwatchlisttools-edit' => 'Edytuj kategorie',
	'collabwatchlisttools-delete' => 'Usuń',
	'collabwatchlistsall' => 'Wszystkie listy',
	'collabwatchlistedit-users-raw-submit' => 'Zapisz',
	'collabwatchlistedit-raw-titles' => 'Kategorie:',
	'collabwatchlistedit-tags-raw-titles' => 'Znaczniki:',
	'collabwatchlistedit-users-raw-titles' => 'Użytkownicy:',
	'collabwatchlistedit-normal-title' => 'Edytuj kategorie',
	'collabwatchlistedit-tags-raw-submit' => 'Zapisz',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|1 znacznik został dodany|$1 znaczniki zostały dodane|$1 znaczników zostało dodanych}}:',
	'collabwatchlistedit-users-raw-added' => 'Dodano {{PLURAL:$1|1 użytkownika|$1 użytkowników}}:',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|1 znacznik został usunięty|$1 znaczniki zostały usunięte|$1 znaczników zostało usuniętych}}:',
	'collabwatchlistedit-users-raw-removed' => 'Usunięto {{PLURAL:$1|1 użytkownika|$1 użytkowników}}:',
	'collabwatchlistdelete-submit' => 'Usuń',
	'collabwatchlistnew-name' => 'Nazwa listy',
	'collabwatchlistnew-submit' => 'Utwórz',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|1 strona lub kategoria została dodana|$1 strony lub kategorie zostały dodane|$1 stron lub kategorii zostało dodanych}}:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|1 strona lub kategoria została usunięta|$1 strony lub kategorie zostały usunięte|$1 stron lub kategorii zostało usuniętych}}:',
	'collabwatchlistedit-normal-submit' => 'Zapisz',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'collabwatchlisttools-delete' => 'ړنګول',
	'collabwatchlistsall' => 'ټول لړليکونه',
	'collabwatchlistedit-users-raw-submit' => 'خوندي کول',
	'collabwatchlistedit-raw-titles' => 'وېشنيزې:',
	'collabwatchlistedit-users-raw-titles' => 'کارنان:',
	'collabwatchlistedit-normal-title' => 'وېشنيزې سمول',
	'collabwatchlistedit-tags-raw-submit' => 'خوندي کول',
	'collabwatchlistdelete-submit' => 'ړنګول',
	'collabwatchlistnew-name' => 'د لړليک نوم',
	'collabwatchlistnew-submit' => 'جوړول',
	'collabwatchlistedit-normal-submit' => 'خوندي کول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'collabwatchlist' => 'Lista colaborativa de páginas vigiadas',
	'collabwatchlist-desc' => 'Permite ter listas colaborativas de páginas vigiadas, com base em categorias',
	'specialcollabwatchlist' => 'Página especial para a lista colaborativa de páginas vigiadas',
	'collabwatchlist-details' => '{{PLURAL:$1|$1 categoria ou página|$1 categorias ou páginas}} nesta lista colaborativa de páginas vigiadas.',
	'collabwatchlisttagselect' => 'Etiqueta',
	'collabwatchlisttagcomment' => 'Comentário',
	'collabwatchlistsettagbutton' => 'Colocar etiqueta',
	'collabwatchlisttools-view' => 'Mostrar',
	'collabwatchlisttools-edit' => 'Editar categorias',
	'collabwatchlisttools-rawCategories' => 'Editar categorias na forma de texto',
	'collabwatchlisttools-rawTags' => 'Editar etiquetas na forma de texto',
	'collabwatchlisttools-rawUsers' => 'Editar utilizadores na forma de texto',
	'collabwatchlisttools-delete' => 'Eliminar',
	'collabwatchlistsall' => 'Todas as listas',
	'collabwatchlistfiltertags' => 'Filtrar etiquetas',
	'collabwatchlistedit-users-raw-submit' => 'Gravar',
	'collabwatchlistedit-raw-title' => 'Editar categorias na forma de texto',
	'collabwatchlistedit-tags-raw-title' => 'Editar etiquetas na forma de texto',
	'collabwatchlistedit-users-raw-title' => 'Editar utilizadores na forma de texto',
	'collabwatchlistedit-users-last-owner' => 'Tem de existir pelo menos um proprietário',
	'collabwatchlistedit-numitems' => 'Esta lista colaborativa de páginas vigiadas contém {{PLURAL:$1|1 categoria|$1 categorias}}',
	'collabwatchlistedit-noitems' => 'Esta lista colaborativa de páginas vigiadas não contém categorias.',
	'collabwatchlistedit-tags-numitems' => 'Esta lista colaborativa de páginas vigiadas contém {{PLURAL:$1|1 etiqueta|$1 etiquetas}}',
	'collabwatchlistedit-tags-noitems' => 'Esta lista colaborativa de páginas vigiadas não contém etiquetas.',
	'collabwatchlistedit-users-numitems' => 'Esta lista colaborativa de páginas vigiadas contém {{PLURAL:$1|1 utilizador|$1 utilizadores}}',
	'collabwatchlistedit-users-noitems' => 'Esta lista colaborativa de páginas vigiadas não contém utilizadores.',
	'collabwatchlistedit-raw-legend' => 'Editar categorias da lista colaborativa de páginas vigiadas, na forma de texto',
	'collabwatchlistedit-users-raw-legend' => 'Editar utilizadores da lista colaborativa de páginas vigiadas, na forma de texto',
	'collabwatchlistedit-tags-raw-legend' => 'Editar etiquetas da lista colaborativa de páginas vigiadas, na forma de texto',
	'collabwatchlistedit-raw-explain' => 'As categorias da lista colaborativa de páginas vigiadas são mostradas abaixo e podem ser adicionadas ou removidas da lista',
	'collabwatchlistedit-tags-raw-explain' => 'As etiquetas da lista colaborativa de páginas vigiadas são mostradas abaixo e podem ser adicionadas ou removidas da lista.',
	'collabwatchlistedit-users-raw-explain' => 'Os utilizadores da lista colaborativa de páginas vigiadas são mostrados abaixo e podem ser adicionados ou removidos da lista.',
	'collabwatchlistedit-raw-titles' => 'Categorias:',
	'collabwatchlistedit-tags-raw-titles' => 'Etiquetas:',
	'collabwatchlistedit-users-raw-titles' => 'Utilizadores:',
	'collabwatchlistedit-normal-title' => 'Editar categorias',
	'collabwatchlistedit-normal-legend' => 'Remover categorias da lista colaborativa de páginas vigiadas',
	'collabwatchlistedit-normal-explain' => 'As categorias da sua lista colaborativa de páginas vigiadas são mostradas abaixo.',
	'collabwatchlistedit-tags-raw-submit' => 'Gravar',
	'collabwatchlistedit-normal-done' => '{{PLURAL:$1|1 categoria foi removida|$1 categorias foram removidas}} da lista colaborativa de páginas vigiadas:',
	'collabwatchlistedit-tags-raw-done' => 'A lista colaborativa de páginas vigiadas foi actualizada.',
	'collabwatchlistedit-users-raw-done' => 'A lista colaborativa de páginas vigiadas foi actualizada.',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|Foi adicionada 1 etiqueta|Foram adicionadas $1 etiquetas}}:',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|Foi adicionado 1 utilizador|Foram adicionados $1 utilizadores}}:',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|Foi removida 1 etiqueta|Foram removidas $1 etiquetas}}:',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|Foi removido 1 utilizador|Foram removidos $1 utilizadores}}:',
	'collabwatchlistinverttags' => 'Inverter o filtro de etiquetas',
	'collabwatchlistpatrol' => 'Patrulhar edições',
	'collabwatchlisttools-newList' => 'Nova lista colaborativa de páginas vigiadas',
	'collabwatchlistdelete-legend' => 'Eliminar uma lista colaborativa de páginas vigiadas',
	'collabwatchlistdelete-explain' => 'A eliminação de uma lista colaborativa de páginas vigiadas remove todos os vestígios dessa lista. As etiquetas que foram colocadas nas edições são mantidas.',
	'collabwatchlistdelete-submit' => 'Eliminar',
	'collabwatchlistdelete-title' => 'Eliminar a lista colaborativa de páginas vigiadas',
	'collabwatchlistedit-set-tags-numitems' => 'Esta lista colaborativa de páginas vigiadas tem {{PLURAL:$1|1 etiqueta colocada|$1 etiquetas colocadas}}',
	'collabwatchlistedit-set-tags-noitems' => 'Esta lista colaborativa de páginas vigiadas não tem etiquetas colocadas.',
	'collabwatchlistnew-legend' => 'Criar uma lista colaborativa de páginas vigiadas nova',
	'collabwatchlistnew-explain' => 'O nome da lista colaborativa tem de ser único.',
	'collabwatchlistnew-name' => 'Nome da lista',
	'collabwatchlistnew-submit' => 'Criar',
	'collabwatchlistedit-raw-done' => 'A lista colaborativa de páginas vigiadas foi actualizada',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|1 página ou categoria foi adicionada|$1 páginas ou categorias foram adicionadas}}:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|1 página ou categoria foi removida|$1 páginas ou categorias foram removidas}}:',
	'collabwatchlistedit-normal-submit' => 'Gravar',
	'collabwatchlistshowhidelistusers' => '$1 utilizadores da lista',
	'tog-collabwatchlisthidelistusers' => 'Esconder edições dos utilizadores da lista colaborativa de páginas vigiadas',
);

/** Russian (Русский)
 * @author Adata80
 * @author Alexandr Efremov
 * @author Eleferen
 * @author Engineering
 */
$messages['ru'] = array(
	'collabwatchlist-desc' => 'Обеспечивает совместные списки наблюдений, основанные на категориях',
	'collabwatchlisttagcomment' => 'Комментарий',
	'collabwatchlisttools-view' => 'Дисплей',
	'collabwatchlisttools-edit' => 'Изменить категорию',
	'collabwatchlisttools-delete' => 'Удалить',
	'collabwatchlistsall' => 'Все списки',
	'collabwatchlistfiltertags' => 'Скрыть метки',
	'collabwatchlistedit-users-raw-submit' => 'Сохранить',
	'collabwatchlistedit-users-raw-titles' => 'Участники:',
	'collabwatchlistedit-tags-raw-submit' => 'Сохранить',
	'collabwatchlistdelete-submit' => 'Удалить',
	'collabwatchlistnew-name' => 'Название списка',
	'collabwatchlistnew-submit' => 'Создать',
	'collabwatchlistedit-normal-submit' => 'Сохранить',
);

/** Swedish (Svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'collabwatchlistdelete-submit' => 'Radera',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'collabwatchlisttagcomment' => 'వ్యాఖ్య',
	'collabwatchlisttools-delete' => 'తొలగించు',
	'collabwatchlistsall' => 'అన్ని జాబితాలు',
	'collabwatchlistedit-users-raw-submit' => 'భద్రపరచు',
	'collabwatchlistedit-raw-titles' => 'వర్గాలు:',
	'collabwatchlistedit-users-raw-titles' => 'వాడుకరులు:',
	'collabwatchlistedit-tags-raw-submit' => 'భద్రపరచు',
	'collabwatchlistdelete-submit' => 'తొలగించు',
	'collabwatchlistnew-name' => 'జాబితా పేరు',
	'collabwatchlistedit-normal-submit' => 'భద్రపరచు',
);

/** Ukrainian (Українська)
 * @author Sodmy
 */
$messages['uk'] = array(
	'collabwatchlist' => 'Спільний список спостереження',
	'collabwatchlist-desc' => 'Забезпечити спільні списки спостереження на основі категорій',
	'specialcollabwatchlist' => 'Спеціальні сторінки спільного списку спостереження',
	'collabwatchlist-details' => '{{PLURAL:$1|$1 category/page|$1 категорії/сторінки}} на цьому спільному списку спостереження.',
	'collabwatchlisttagselect' => 'Мітка',
	'collabwatchlisttagcomment' => 'Коментар',
	'collabwatchlistsettagbutton' => 'Набір тегів',
	'collabwatchlisttools-view' => 'Показати',
	'collabwatchlisttools-edit' => 'Змінити категорію',
	'collabwatchlisttools-rawCategories' => 'Сире редагування категорій',
	'collabwatchlisttools-rawTags' => 'Сире редагування міток',
	'collabwatchlisttools-rawUsers' => 'Сире редагування користувачів',
	'collabwatchlisttools-delete' => 'Вилучити',
	'collabwatchlistsall' => 'Усі списки',
	'collabwatchlistfiltertags' => 'Приховати Мітки',
	'collabwatchlistedit-users-raw-submit' => 'Зберегти',
	'collabwatchlistedit-raw-title' => 'Сире редагування категорій',
	'collabwatchlistedit-tags-raw-title' => 'Сире редагування міток',
	'collabwatchlistedit-users-raw-title' => 'Сире редагування користувачів',
	'collabwatchlistedit-users-last-owner' => 'Там повинен бути принаймні один власник',
	'collabwatchlistedit-raw-legend' => 'Сире редагування спільного списку спостереження категорій',
	'collabwatchlistedit-users-raw-legend' => 'Сире редагування спільного списку спостереження користувачів',
	'collabwatchlistedit-tags-raw-legend' => 'Сире редагування спільного списку спостереження міток',
	'collabwatchlistedit-raw-titles' => 'Категорії:',
	'collabwatchlistedit-tags-raw-titles' => 'Мітки:',
	'collabwatchlistedit-users-raw-titles' => 'Користувачі:',
	'collabwatchlistedit-normal-title' => 'Змінити категорію',
	'collabwatchlistedit-normal-legend' => 'Вилучення категорії зі спільного списку спостереження',
	'collabwatchlistedit-normal-explain' => 'Категорії у вашому спільному списку спостереження наведені нижче.',
	'collabwatchlistedit-tags-raw-submit' => 'Зберегти',
	'collabwatchlistedit-tags-raw-done' => 'Спільний список спостереження було оновлено.',
	'collabwatchlistedit-users-raw-done' => 'Спільний список спостереження було оновлено.',
	'collabwatchlistedit-tags-raw-added' => '{{PLURAL:$1|1 tag was|$1 мітки були}} додані:',
	'collabwatchlistedit-users-raw-added' => '{{PLURAL:$1|1 user was|$1 користувачів було}} додано:',
	'collabwatchlistedit-tags-raw-removed' => '{{PLURAL:$1|1 tag was|$1 мітки були}} вилучені:',
	'collabwatchlistedit-users-raw-removed' => '{{PLURAL:$1|1 user was|$1 користувачі були}} вилучені:',
	'collabwatchlistinverttags' => 'Інвертування фільтру міток',
	'collabwatchlistpatrol' => 'Патрульні редагування',
	'collabwatchlisttools-newList' => 'Новий спільний список спостереження',
	'collabwatchlistdelete-legend' => 'Видалити спільний список спостереження',
	'collabwatchlistdelete-submit' => 'Вилучити',
	'collabwatchlistdelete-title' => 'Видалити спільний список спостереження',
	'collabwatchlistedit-set-tags-noitems' => 'Цей спільний список спостереження не має жодного набору ознак',
	'collabwatchlistnew-legend' => 'Створення нового спільного списку спостереження',
	'collabwatchlistnew-explain' => "Ім'я списку має бути унікальним.",
	'collabwatchlistnew-name' => "Ім'я списку",
	'collabwatchlistnew-submit' => 'Створити',
	'collabwatchlistedit-raw-done' => 'Спільний список спостереження було оновлено',
	'collabwatchlistedit-raw-added' => '{{PLURAL:$1|1 page or category was|$1 сторінки або категорії було}} додано:',
	'collabwatchlistedit-raw-removed' => '{{PLURAL:$1|1 page or category was|$1 сторінки або категорії було}} вилучено',
	'collabwatchlistedit-normal-submit' => 'Зберегти',
	'collabwatchlistshowhidelistusers' => '$1 список користувачів',
	'tog-collabwatchlisthidelistusers' => 'Приховування редагувань від користувачів спільного списку спостереження',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hzy980512
 * @author Linforest
 * @author PhiLiP
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'collabwatchlisttagselect' => '标签',
	'collabwatchlistsettagbutton' => '设置标签',
	'collabwatchlisttools-view' => '显示',
	'collabwatchlisttools-edit' => '编辑类别',
	'collabwatchlisttools-rawUsers' => '原始编辑用户',
	'collabwatchlisttools-delete' => '删除',
	'collabwatchlistsall' => '全部列表',
	'collabwatchlistfiltertags' => '隐藏标签',
	'collabwatchlistedit-users-raw-submit' => '保存',
	'collabwatchlistedit-users-last-owner' => '必须至少一个所有者',
	'collabwatchlistedit-raw-titles' => '分类：',
	'collabwatchlistedit-tags-raw-titles' => '标签：',
	'collabwatchlistedit-users-raw-titles' => '用户：',
	'collabwatchlistedit-normal-title' => '编辑类别',
	'collabwatchlistedit-tags-raw-submit' => '保存',
	'collabwatchlistdelete-submit' => '删除',
	'collabwatchlistnew-name' => '列表名称',
	'collabwatchlistnew-submit' => '创建',
	'collabwatchlistedit-normal-submit' => '保存',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'collabwatchlistedit-raw-titles' => '分類：',
	'collabwatchlistedit-tags-raw-submit' => '保存',
);

