<?php

$messages = array_merge( $messages, array(
'login_greeting' => 'Vítejte ve Wikii, [[User:$1|$1]]!',
'editingTips' => '=Jak formátovat text=
Text můžete formátovat pomocí \'wikiznaček\' nebo HTML.

<br />
<span style="font-family: courier"><nowiki>\'\'kurzíva\'\'</nowiki></span> => \'\'kurzíva\'\'

<br />
<span style="font-family: courier"><nowiki>\'\'\'tučně\'\'\'</nowiki></span> => \'\'\'tučně\'\'\'

<br />
<span style="font-family: courier"><nowiki>\'\'\'\'\'tučná kurzíva\'\'\'\'\'</nowiki></span> => \'\'\'\'\'tučná kurzíva\'\'\'\'\'

----

<br />
<nowiki><s>přeškrtnutí</s></nowiki> => <s>přeškrtnutí</s>

<br />
<nowiki><u>podtržení</u></nowiki> => <u>podtržení</u>

<br />
<nowiki><span style="color:red;">červený text</span></nowiki> => <span style="color:red;">červený text</span>

=Jak vytvářet odkazy=
Odkazy se vytváří pomocí jednoduchých nebo dvojitých hranatých závorek.

<br />
\'\'\'jednoduchý interní odkaz:\'\'\'<br />
<nowiki>[[Název stránky]]</nowiki>

<br />
\'\'\'jednoduchý interní odkaz s textem:\'\'\'<br />
<nowiki>[[Název stránky|nějaký jiný text]]</nowiki>

<br />
----

<br />
\'\'\'číslovaný externí odkaz:\'\'\'<br />
<nowiki>[http://www.example.com]</nowiki>

<br />
\'\'\'externí odkaz s jiným text k zobrazení:\'\'\'

<nowiki>[http://www.example.com text odkazu]</nowiki>

=Jak přidat nadpisy=
Nadpisy se tvoří pomocí rovnítek.  Čím vícekrát „=“, tím menší menší nadpis.
Nadpis 1 je určen pouze pro nadpis celé stránky.

<br />
<span style="font-size: 1.6em"><nowiki>==Nadpis 2==</nowiki></span>

<br />
<span style="font-size: 1.3em"><nowiki>===Nadpis 3===</nowiki></span>

<br />
<nowiki>====Nadpis 4====</nowiki>

=Jak odsazovat text=
Odsazení může být buď prosté, s odrážkami nebo číslované.

<br />
<nowiki>: odsazení</nowiki><br />
<nowiki>: odsazení</nowiki><br />
<nowiki>:: větší odsazení</nowiki><br />
<nowiki>::: ještě větší odsazení</nowiki>

<br />
<nowiki>* odrážka</nowiki><br />
<nowiki>* odrážka</nowiki><br />
<nowiki>** další odrážka</nowiki><br />
<nowiki>* odrážka</nowiki>

<br />
<nowiki># číslovaný seznam</nowiki><br />
<nowiki># číslovaný seznam</nowiki><br />
<nowiki>## podseznam</nowiki><br />
<nowiki># číslovaný seznam</nowiki>

=Jak vkládat obrázky=
Obrázky se vkládají podobně jako odkazy.

<br />
<nowiki>[[Image:Název.jpg]]</nowiki>

<br />
\'\'\'Obrázek s s alternativním textem.\'\'\'<br />
<nowiki>[[Image:Název.jpg|alternativní text]]</nowiki>

<br />
\'\'\'Vytvoření náhledu\'\'\'<br />
<nowiki>[[Image:Název.jpg|thumb|]]</nowiki>

<br />
\'\'\'Určení velikosti zobrazeného obrázku\'\'\'<br />
<nowiki>[[Image:Název.jpg|200px|]]</nowiki>

<br />
\'\'\'Zarovnání obrázku\'\'\'<br />
<nowiki>[[Image:Název.jpg|right|]]</nowiki>

<br />
Atributy můžete kombinovat tak, že mezi ně vložíte svislítko „|“. Cokoliv po posledním svislítku je text.',
) );
