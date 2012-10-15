<?php
/**
 * Internationalisation file for Reflect extension.
 *
 * @file
 * @ingroup Extensions
 * @author Travis Kriplean <travis@cs.washington.edu>
 * @license GPL2
 */

$messages = array();

$messages['en'] = array(
	'reflect-desc' => 'Augmentation of threaded comments',
	'reflect-bulleted' => 'Hi $1,
	
$2 has summarized a point that you made in the thread "$3". 

Their summary: "$5".

You can verify whether $2 got your point right by visiting <$4>. 

You will be able to clarify your point if there is a misunderstanding.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Your point was summarized by $2',
	'reflect-responded' => 'Hi $1, 
	
$2 has responded to your summary of a point that they made.

The summary you left: "$6". 
Their message: "$5".

If you want to read the response in context, visit <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 has responded to your summary bullet point',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'reflect-desc' => 'Павелічэньне камэнтараў галіны',
	'reflect-bulleted' => 'Вітаем, $1!
	
$2 падсумаваў Ваш пункт гледжаньня ў галіне «$3». 

У спрошчаным выглядзе: «$5».

Вы можаце праверыць, ці правільна $2 зразумеў Вас, наведаўшы <$4>. 

Вы зможаце ўдакладніць Ваш пункт гледжаньня, калі заўважыце непаразуменьні.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Выш пункт гледжаньня быў падсумаваны $2',
	'reflect-responded' => 'Вітаем, $1! 
	
$2 адказаў на Вашае падсумаваньне яго пункту гледжаньня.

У спрошчаным выглядзе Вы зрабілі: «$6». 
Яго паведамленьне: «$5».

Калі Вы жадаеце прачытаць адказ у кантэксьце, наведайце <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 адказаў на Вашае рэзюміраваньне пункту гледжаньня',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'reflect-desc' => 'Gwellaenn dedennus evit an neudennadoù kaozeal',
	'reflect-bulleted' => 'Demat dit $1,
	
Un tamm diverrañ eus ar soñj embannet ganeoc\'h zo bet graet gant $2 en neudennad "$3". 

An tamm diverrañ : "$5".

Gwiriañ a c\'halllit hag-eñ eo bet dastumet mat ho soñjoù gant $2 en ur vont da welet war <$4>. 

Gouest e viot da sklaeraat ho soñj eno e ken kaz e vije bet treuzkompren.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Un tamm diverrañ eus ho soñj zo bet graet gant $2',
	'reflect-responded' => 'Demat dit $1, 
	
Ur respont zo bet graet gant $2 d\'an diverradenn graet ganeoc\'h eus e soñj.

An tamm diverrañ graet ganeoc\'h : "$6". 
Ar gemennadenn : "$5".

Mar fell deoc\'h lenn ar respont er gendestenn, kit da welet <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] respontet ez eus bet gant $2 an diverradenn graet diwar-benn e soñj',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'reflect-desc' => 'Nadopunjavanje nizanih komentara',
	'reflect-bulleted' => 'Zdravo $1,
	
$2 je napravio sažetak vašeg doprinosa na temu "$3". 

Njihov sažetak: "$5".

Možete potvrditi da li je $2 vašu izjavu dobro shvatio tako što će te posjetiti link <$4>. 

Ako je bilo nejasnoća, možete objasniti vašu zamisao.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Vaš doprinos je sažet od strane $2',
	'reflect-responded' => 'Zdravo $1, 
	
$2 je odgovorio na sažetak vašeg unosa koji je načinjen.

Sažetak koji ste ostavili: "$6". 
Njihova poruka: "$5".

Ako želite pročitati odgovor u kontekstu, posjetite <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 je odgovorio na vašu sažetu tačku izlaganja',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'reflect-desc' => 'Erweitert die Möglichkeiten Themenstränge auf Diskussionsseiten zu nutzen',
	'reflect-bulleted' => 'Hallo $1,

$2 hat eine Aussage aus deinem Beitrag zum Thema „$3“ zusammengefasst.

Die Zusammenfassung lautet: „$5“.

Du kannst überprüfen, ob $2 deine Aussage richtig verstanden hat, indem du <$4> aufrufst.

Sofern ein Missverständnis vorliegt, kannst du deine Aussage klarstellen.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Dein Beitrag wurde von $2 zusammengefasst',
	'reflect-responded' => 'Hallo $1,

$2 hat auf deine Zusammenfassung zu einer Aussage in seinem Beitrag reagiert.

Die Zusammenfassung, die du erstellt hast: „$6“.
Dessen Nachricht: „$5“.

Rufe <$4> auf, sofern du die Antwort im entsprechenden Zusammenhang lesen möchtest.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 hat auf deine Zusammenfassung einer Aussage reagiert.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'reflect-bulleted' => 'Hallo $1,

$2 hat eine Aussage aus Ihrem Beitrag zum Thema „$3“ zusammengefasst.

Die Zusammenfassung lautet: „$5“.

Sie können überprüfen, ob $2 Ihre Aussage richtig verstanden hat, indem Sie <$4> aufrufen.

Sofern ein Missverständnis vorliegt, können Sie Ihre Aussage klarstellen.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Ihr Beitrag wurde von $2 zusammengefasst',
	'reflect-responded' => 'Hallo $1,

$2 hat auf Ihre Zusammenfassung zu einer Aussage in seinem Beitrag reagiert.

Die Zusammenfassung, die Sie erstellt haben: „$6“.
Dessen Nachricht: „$5“.

Rufen Sie <$4> auf, sofern Sie die Antwort im entsprechenden Zusammenhang lesen möchten.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 hat auf Ihre Zusammenfassung einer Aussage reagiert.',
);

/** Spanish (Español)
 * @author Sanbec
 */
$messages['es'] = array(
	'reflect-desc' => 'Añade una columna a la páginas de discusión por hilos, en la cual los usuarios pueden resumir las conversaciones existentes',
	'reflect-bulleted' => 'Hola $1,
	
$2 ha resumido un comentario tuyo en el hilo "$3". 

Su resumen: "$5".

Puedes verificar si $2 ha comprendido bien tu punto de vista visitando <$4>.

Podrás aclarar tu punto de vista si hubo un malentendido.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Su opinión fue resumida por $2',
	'reflect-responded' => 'Hola $1,
	
$2 ha respondido a tu resumen de un comentario que hizo. 

El resumen que hiciste: "$6".
Su mensaje: "$5".


Para leer la respuesta en contexto, visita <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 respondió a tu resumen de su opinión',
);

/** French (Français)
 * @author Peter17
 */
$messages['fr'] = array(
	'reflect-desc' => 'Amélioration originale des fils de commentaires',
	'reflect-bulleted' => 'Bonjour $1,

$2 a résumé un point de vue que vous avez exprimé dans le fil « $3 ».

Son résumé : « $5 ».

Vous pouvez vérifier si $2 a bien compris votre position en visitant <$4>.

Vous pourrez alors clarifier votre point de vue s’il y a une incompréhension.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Votre opinion a été résumée par $2',
	'reflect-responded' => 'Bonjour $1,

$2 a répondu à votre résumé d’un point de vue qu’il avait exprimé.

Le résumé que vous avez écrit : « $6 ».
Son message : « $5 ».

Si vous voulez lire la réponse dans son contexte, visitez <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 a répondu à votre résumé de son opinion',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'reflect-desc' => 'Ôgmentacion des fils de comentèros',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Voutron avis at étâ rèsumâ per $2',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 at rèpondu a voutron rèsumâ de son avis',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'reflect-desc' => 'Incremento de fíos de comentarios',
	'reflect-bulleted' => 'Ola $1:
	
$2 resumiu un punto que fixo no fío "$3". 

O seu resumo: "$5".

Pode comprobar se $2 comprendeu ben o punto visitando <$4>. 

Poderá aclarar o seu punto se houbo unha interpretación errónea.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] $2 resumiu o seu punto',
	'reflect-responded' => 'Ola $1: 
	
$2 respondeu ao seu resumo dun punto que ese usuario escribiu.

O resumo que deixou vostede: "$6". 
A súa mensaxe: "$5".

Se quere ler a resposta no seu contexto visite <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 respondeu ao seu resumo',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'reflect-desc' => 'Uuswytig vu no Themesträng gordnete Diskussionsyte',
	'reflect-bulleted' => 'Sali $1,

$2 het e Uussag us Dyym Byytrag zum Thema „$3“ zämmegfasst.

D Zämmefassig isch: „$5“.

Du chasch iberpriefe, eb $2 Dyy Uussag richtig verstande het, indäm Du <$4> ufruefsch.

Wänn imfall e Missverständnis vorlyt, chasch Dyy Uussag klarstelle.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Dyy Byytrag isch vu $2 zämmegfasst wore',
	'reflect-responded' => 'Sali $1,

$2 het uf Dyy Zämmefassig zuen ere Uussag in syym Byytrag reagiert.

D Zämmefassig, wu Du aagleit hesch: „$6“.
Sällem syy Nochricht: „$5“.

Ruef <$4> uf, wänn Du d Antwort im däm Zämmehang witt läse.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 het uf Dyy Zämmefassig vun ere Uussag reagiert.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'reflect-desc' => 'הרחבה של תגובות משורשרות',
	'reflect-bulleted' => 'שלום $1,

$2 סיכם נקודה שהעלית בשרשור "$3".

תוכן הסיכום: "$5".

אפשר לוודא שהסיכום של $2 מציג את נקודתך כראוי על־ידי ביקור ב־<$4>.

שם אפשר להבהיר הנקודה אם חלה אי־הבנה.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] הדעה שלך סוכמה על־ידי $2',
	'reflect-responded' => 'שלום $1,

$2 השיב לסיכום דעתו.

הסיכום שלך: "$6".
ההודעה של $2: "$5".

לקריאת התשובה בהקשר, ר\' <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] התקבלה תשובה מ{{GRAMMAR:תחילית|$2}} לנקודה בסיכום שלך',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'reflect-desc' => 'Rozšěrja móžnosće za komentarowe nitki',
	'reflect-bulleted' => 'Witaj $1,

$2 je wuprajenje wot tebje z nitki "$3" zjał.

Zjeće je: "$5".

Móžeš kontrolować, hač $2 je twoje wuprajenje prawje zrozumił, wopytujo <$4>.

Změješ móžnosć swoje wuprajenje wujasnić, jeli je njedorozumjenje.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Twoje wuprajenje bu wot $2 zjate',
	'reflect-responded' => 'Witaj $1,

$2 je na twoje zjeće swojeho wuprajenja wotmołwił.

Zjeće, kotrež sy zawostajił: "$6".
Twoja powěsć: "$5".

Jeli chceš wotmołwu w konteksće čitać, wopytaj <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 je na twoje zjeće wotmołwił',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'reflect-desc' => 'Augmentation de commentos in discussiones',
	'reflect-bulleted' => 'Salute $1,

$2 ha summarisate un puncto de vista que tu ha exprimite in le discussion "$3".

Su summario: "$5".

Tu pote verificar si $2 te ha ben comprendite per visitar <$4>.

Tu potera clarificar tu puncto de vista si il ha un miscomprension.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Tu puncto de vista ha essite summarisate per $2',
	'reflect-responded' => 'Salute $1, 
	
$2 ha respondite a tu summario de un puncto de vista que ille/illa ha exprimite.

Le summario que tu lassava: "$6". 
Su message: "$5".

Si tu vole leger le responsa in contexto, visita <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 ha respondite a tu curte summario',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'reflect-desc' => 'Memperluas komentar berutas',
	'reflect-bulleted' => 'Halo $1, 

$2 telah meringkas gagasan yang Anda pada utas "$3". 

Ringkasan mereka: "$5". 

Anda dapat memverifikasi apakah $2 memahami maksud Anda dengan mengunjungi <$4>. 

Anda akan dapat memperjelas maksud Anda jika ada kesalahpahaman.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Gagasan Anda telah diringkas oleh $2',
	'reflect-responded' => 'Halo $1, 

$2 telah membalas ringkasan Anda terhadap gagasannya. 

Ringkasan Anda: "$6". 
Pesan $2: "$5". 

Jika Anda ingin membaca langsung tanggapannya, kunjungi <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 telah menanggapi ringkasan Anda',
);

/** Japanese (日本語)
 * @author Aphaia
 * @author Yanajin66
 * @author 青子守歌
 */
$messages['ja'] = array(
	'reflect-desc' => 'スレッドでのコメントの拡張',
	'reflect-bulleted' => 'こんにちは $1さん。

$2はスレッド「$3」での$1さんの投稿の要約です。

要約は以下のとおりです：「$5」

<$4>で、$2があなたの投稿の論点を正しくとらえているかどうか確認できます。

もし、間違いがあれば、論点を説明しなおすことができます。',
	'reflect-bulleted-subject' => '[{{SITENAME}}] 投稿が$2によって要約されました。',
	'reflect-responded' => 'こんにちは、$1さん。

$2が、彼らの投稿の論点に関する、$1さんの要約に返答しました。

作成された要約：「$6」
彼らの返答メッセージ：「$5」

この返答をスレッド中で読むには、<$4>をご覧ください。',
	'reflect-responded-subject' => '[{{SITENAME}}] $2が、要約の箇条書きに返答しました',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'reflect-desc' => 'Mieh Müjjeleschkeite för Jeschprääschsfäddeme op Klaafsigge.',
	'reflect-bulleted' => 'Daach $1,

{{GENDER:Dä|Dat|Dä Metmaacher|De|Et}} $2 hät e Schtöck us Deinem Beidraach zodammejevaß zom Thema:
„$3“

De Zusammenfassung es: „$5“.

Do kanns nohloore, of dat esu reschtesch es, indämm dat De <$4> oprööfs.

Falls dat e Meßverschtändnes wohr, kanns De dat kloh schtelle.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Dinge Beidraach wood {{GENDER:$2|vum|vum|vun däm Metmaacher|vun der|vum}} $2 zosammejefaß',
	'reflect-responded' => 'Dach $1,

{{GENDER:$2|Dä|Et|Dä Metmaacher|De|Dat}} $2 hät op Ding Zosammefassong en {{GENDER:$2|singem|singem|däm singem|ierem|singem}} Beidraach jeschrevve:
„$5“

Ding Zosammefassong wohr: „$6“

Jangk op di Sigg <$4> wann De di Antwoot em Zosammehang lässe wells.',
	'reflect-responded-subject' => '[{{SITENAME}}] {{GENDER:$2|Dä|Et|Dä Metmaacher|De|Dat}} $2 hät op Ding Zosammefassong jeantwoot.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'reflect-desc' => 'Erweiderung vu Bemierkungs-Rubriken',
	'reflect-bulleted' => 'Salut $1,

$2 huet e Punkt resuméiert deen Dir an der Rubrik "$3" gemaach hutt.

Resumé: "$5"

Dir kënnt nokucken ob de $2 Äre Standpunkt richteg verstan huet wann Dir op <$4> nokuckt.

Dir kënnt Äre Punkt och kloerstelle wann et e Mëssverständnis gëtt.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Är Meenung gouf vum $2 resuméiert',
	'reflect-responded' => 'Salut $1, 
	
$2 huet op Äre Resumé zu enger Ausso vu sengem Standpunkt reagéiert.

De Resumé deen Dir gemaach hutt: "$6". 
Säi Message: "$5".

Wann dir de Message am Kontext liese wëllt, da gitt op <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 huet op Äre Resumé vun enger Bemierkung geäntwert.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'reflect-desc' => 'Надополнување на нанижани коментари',
	'reflect-bulleted' => 'Здраво $1,

$2 резимираше ваше излагање на темата „$3“. 

Резимето гласи: "$5".

Можете да појдете на <$4> за да проверите дали $2 ве има сфатено правилно. 

Ако постои некое недоразсбирање, така ќе можете да појасните за што станува збор.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] $2 го резимираше вашето излагање',
	'reflect-responded' => 'Здраво $1, 

$2 одговори на вашето резиме на излагањето.

Вашето резиме гласеше: „$6“. 
Одговорот гласи: „$5“.

Ако сакате да го прочитате одговорот во контекст, одете на <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 одговори на вашата резимирана потточка со излагање',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'reflect-desc' => 'Uitbreiding van gestructureerd overleg',
	'reflect-bulleted' => 'Hallo $1, 

$2 heeft een punt samengevat dat u hebt gemaakt in het overleg "$3".

De samenvatting luidt: "$5" 

U kunt via de volgende verwijzing controleren of de samenvatting correct is: <$4>.

Als er sprake is van een misverstand, kunt u uw bijdrage toelichten.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Uw punt is samengevat door $2',
	'reflect-responded' => 'Hallo $1, 

$2 heeft gereageerd op een punt dat u hebt samengevat.

De samenvatting die u hebt achtergelaten: "$6" 
De reactie: "$5"

U kunt via de volgende verwijzing de reactie in context bekijken: <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 heeft gereageerd op uw bondige samenvatting',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'reflect-desc' => 'Forbedring av trådede kommentarer',
	'reflect-bulleted' => 'Hei $1,

$2 har oppsummert et poeng du kom med i tråden «$3».

Deres oppsummering: «$5».

Du kan bekrefte hvorvidt $2 tok poenget ditt riktig ved å gå til <$4>.

Du vil være i stand til klargjøre poenget ditt om det skulle være en misforståelse.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Ditt poeng ble oppsummert av $2',
	'reflect-responded' => 'Hei $1,

$2 har svart på ditt sammendrag av et poeng de gjorde.

Sammendraget du lagde: «$6».
Deres melding: «$5».

Om du vil lese dette svaret i kontekst, gå til <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 har svart på ditt sammendragspunkt',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'reflect-desc' => 'Rozszerzenie o komentarze w wątkach',
	'reflect-bulleted' => 'Witam $1,

$2 podsumował opinię, którą przedstawiłeś w wątku „$3”. 

Jego podsumowanie: „$5”.

Możesz sprawdzić czy $2 właściwie to zrobił odwiedzając <$4>. 

Objaśnij swoją opinię, jeśli zostałeś źle zrozumiany.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Twoja opinia została podsumowana przez $2',
	'reflect-responded' => 'Witam $1,

$2 odpowiedział na Twoje podsumowanie opinii, którą przedstawił.

Podsumowanie które napisałeś: „$6”. 
Jego odpowiedź: „$5”. 

Jeśli chcesz zobaczyć odpowiedź w kontekście wątku, odwiedź <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 odpowiedział na Twoje podsumowanie',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'reflect-desc' => 'Aument dij coment concatenà',
	'reflect-bulleted' => 'Cerea $1,

$2 a l\'ha fàit un resumé d\'un rasonament ch\'a l\'has fàit ant la discussion "$3".

Sò resumé: "$5".

A peule verifiché se $2 a l\'ha capì bin tò rasonament an visitand <$4>.

A podrà s-ciairì sò rasonament s\'a-i son dj\'incomprension.',
	'reflect-bulleted-subject' => "[{{SITENAME}}] Ëd sò rasonament a l'ha fàit un resumé $2",
	'reflect-responded' => 'Cerea $1,

$2 a l\'ha arspondù a sò resumé d\'un rasonament ch\'a l\'avìa fàit.

Ël resumé ch\'a l\'ha lassà: "$6".
Soa rispòsta: "$5".

S\'a veule lese l\'arspòsta ant ël contest, ch\'a vìsita <$4>.',
	'reflect-responded-subject' => "[{{SITENAME}}] $2 a l'ha arspondù al resumé ëd soa opinion",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'reflect-desc' => 'Adiciona uma coluna às páginas de discussão por tópicos, na qual os utilizadores podem resumir as conversações existentes',
	'reflect-bulleted' => 'Olá $1,
	
$2 resumiu uma afirmação sua no tópico "$3". 

O resumo: "$5".

Para verificar se o resumo de $2 está correcto, visite <$4>. 

Se a sua afirmação foi mal entendida, poderá clarificá-la.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] A sua afirmação foi resumida por $2',
	'reflect-responded' => 'Olá $1, 
	
o resumo que fez de uma afirmação de $2 tem uma resposta.

O seu resumo: "$6". 
A resposta: "$5".

Para ler a resposta em contexto, visite <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 respondeu ao seu resumo',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'reflect-desc' => 'Adiciona uma coluna às páginas de discussão por tópicos, na qual os usuários podem resumir as conversações existentes',
	'reflect-bulleted' => 'Olá $1,
	
$2 resumiu uma afirmação sua no tópico "$3". 

O resumo: "$5".

Para verificar se o resumo de $2 está correto, visite <$4>. 

Se a sua afirmação foi mal entendida, poderá clarificá-la.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] A sua afirmação foi resumida por $2',
	'reflect-responded' => 'Olá $1, 
	
o resumo que fez de uma afirmação de $2 tem uma resposta.

O seu resumo: "$6". 
A resposta: "$5".

Para ler a resposta em contexto, visite <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 respondeu ao seu resumo',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'reflect-desc' => 'Расширение обсуждений по веткам',
	'reflect-bulleted' => 'Привет, $1.

$2 кратко сформулировал вашу точку зрения в ветке «$3». 

Получилось описание: «$5». 

Вы можете проверить правильность формулировок $2, посетив <$4>.

Вы сможете уточнить вашу точку зрения, если возникло недоразумение.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Ваша точка зрения была кратко сформулирована участником $2',
	'reflect-responded' => 'Привет, $1.

$2 отреагировал на вашу формулировку его точки зрения.

Ваша формулировка: «$6». 
Его замечание: «$5». 

Если вы хотите увидеть ответ в контексте, зайдите на <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] $2 ответил на вашу формулировку',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'reflect-desc' => 'Pagdaragdag sa sinulid ng mga puna',
	'reflect-bulleted' => 'Kumusta $1,

Ibinuod ni $2 ang puntong ginawa mo sa bagting na "$3".

Ang kanilang buod: "$5".

Masusuri mo kung nakuha ng tama ni $2 ang punto mo sa pamamagita n ng pagdalaw sa <$4>.

Maaari mong linawin ang punto mo kung mayroon hindi pagkakaunawaan.',
	'reflect-bulleted-subject' => '[{{SITENAME}}] Ang puno mo ay ibinuod ni $2',
	'reflect-responded' => 'Kumusta $1,

Tumugon si $2 sa iyong buod ng isang puntong ginawa nila.

Ang buod na iniwanan mo: "$6".
Ang kanilang mensahe: "$5".

Kung naisa mong basahin ang tugon ayon sa konteksto, dalawin ang <$4>.',
	'reflect-responded-subject' => '[{{SITENAME}}] Tumugon si $2 sa iyong puntong-punglo ng buod',
);

