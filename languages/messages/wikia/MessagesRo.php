<?php

$messages = array_merge( $messages, array(
'login_greeting' => 'Bun venit la Wikia, [[User:$1|$1]]!',
'create_an_account' => 'Creare cont',
'login_as_another' => 'Înregistrează-te sub un alt nume de utilizator',
'not_you' => 'Nu eşti tu?',
'this_wiki' => 'Acest wiki',
'home' => 'Pagina principală',
'forum' => 'Forum',
'helpfaq' => 'Ajutor şi întrebări frecvente',
'createpage' => 'Creează un nou articol',
'joinnow' => 'Înregistrează-te acum',
'most_popular_articles' => 'Сele mai populare articole',
'expert_tools' => 'Instrumentele expertului',
'this_article' => 'acest articol',
'this_page' => 'această pagină',
'edit_contribute' => 'Modifică / Contribuie',
'discuss' => 'Discuţie',
'share_it' => 'Trimite:',
'my_stuff' => 'Spaţiul meu',
'choose_reason' => 'Alege motivul',
'top_five' => 'Top cinci',
'most_popular' => 'Cele mai populare',
'most_visited' => 'Сele mai vizitate',
'newly_changed' => 'Editate recent',
'highest_ratings' => 'Сele mai punctate',
'most_emailed' => 'Сele mai des trimise prin e-mail',
'rate_it' => 'Punctează:',
'unrate_it' => 'Depunctează',
'use_old_formatting' => 'Modifică înfăţişarea Monobook-ului',
'use_new_formatting' => 'Utilizează noua formatare',
'review_reason_1' => 'Motiv previzualizare 1',
'review_reason_2' => 'Motiv previzualizare 2',
'review_reason_3' => 'Motiv previzualizare 3',
'review_reason_4' => 'Motiv previzualizare 4',
'review_reason_5' => 'Motiv previzualizare 5',
'preferences' => 'Preferinte',
'editingTips' => '=Stilizarea textului=
Se poate stiliza textul fie cu marcajul wiki, fie cu marcajul HTML.

<br />
<span style="font-family: courier"><nowiki>\'\'înclinat\'\'</nowiki></span> => \'\'înclinat\'\'

<br />
<span style="font-family: courier"><nowiki>\'\'\'aldin\'\'\'</nowiki></span> => \'\'\'aldin\'\'\'

<br />
<span style="font-family: courier"><nowiki>\'\'\'\'\'înclinat şi aldin\'\'\'\'\'</nowiki></span> => \'\'\'\'\'înclinat şi aldin\'\'\'\'\'

----

<br />
<nowiki><s>tăiat cu o linie</s></nowiki> => <s>tăiat cu o linie</s>

<br />
<nowiki><u>subliniere</u></nowiki> => <u>subliniere</u>

<br />
<nowiki><span style="color:red;">text roşu</span></nowiki> => <span style="color:red;">text roşu</span>

=Crearea legăturilor=
Legăturile se crează înconjurând un cuvânt sau mai multe cu unul sau două paranteze pătrate.

<br />
\'\'\'Legătură internă simplă:\'\'\'<br />
<nowiki>[[Numele articolului]]</nowiki>

<br />
\'\'\'Legătură internă cu text alternativ:\'\'\'<br />
<nowiki>[[Numele articolului|textul care va fi afişat]]</nowiki>

<br />
----

<br />
\'\'\'Legătură externă numărată:\'\'\'<br />
<nowiki>[http://www.example.com]</nowiki>

<br />
\'\'\'Legătură externă cu text alternativ:\'\'\'

<nowiki>[http://www.example.com textul alternativ]</nowiki>

=Adăugarea subtitlurilor=
Subtitlurile se crează cu semne de egal ("="). Cu cât sunt mai multe semne de egal, cu atât subtitlul este mai mic.
Subtitlul 1 este rezervat pentru titlul paginii şi se foloseşte rar.

<br />
<span style="font-size: 1.6em"><nowiki>==Subtitlu 2==</nowiki></span>

<br />
<span style="font-size: 1.3em"><nowiki>===Subtitlu 3===</nowiki></span>

<br />
<nowiki>====Subtitlu 4====</nowiki>

=Identarea textului=
Textul poate fi identat simplu, cu marcatori sau prin numerotare.

<br />
<nowiki>: indentare</nowiki><br />
<nowiki>: indentare</nowiki><br />
<nowiki>:: mai multă indentare</nowiki><br />
<nowiki>::: şi mai multă indentare</nowiki>

<br />
<nowiki>* marcator</nowiki><br />
<nowiki>* marcator</nowiki><br />
<nowiki>** sub-marcator</nowiki><br />
<nowiki>* marcator</nowiki>

<br />
<nowiki># listă numerotată</nowiki><br />
<nowiki># listă numerotată</nowiki><br />
<nowiki>## sub-listă numerotată</nowiki><br />
<nowiki># listă numerotată</nowiki>

=Introducerea imaginilor=
Imaginile se introduc într-un mod similar adăugării legăturilor.

<br />
<nowiki>[[Image:Imagine.jpg]]</nowiki>

<br />
\'\'\'pentru a adăuga text alternativ\'\'\'<br />
<nowiki>[[Image:Imagine.jpg|text alternativ]]</nowiki>

<br />
\'\'\'pentru a înrăma imaginea\'\'\'<br />
<nowiki>[[Image:Imagine.jpg|thumb|textul alternativ]]</nowiki>

<br />
\'\'\'pentru a specifica mărimea imaginii\'\'\'<br />
<nowiki>[[Image:Imagine.jpg|200px|textul alternativ]]</nowiki>

<br />
\'\'\'pentru a alinia imaginea\'\'\'<br />
<nowiki>[[Image:Imagine.jpg|right|]]</nowiki>

<br />
Se pot combina atributele imaginii punând semnul "pipe" ("|"). Textul pus după ultimul semn pipe este întotdeauna text alternativ.',
) );
