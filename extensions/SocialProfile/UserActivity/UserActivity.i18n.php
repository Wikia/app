<?php
/**
 * Internationalization file for UserActivity extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Aaron Wright
 * @author David Pean
 */
$messages['en'] = array(
	'useractivity' => "Friends' activity",
	'useractivity-award' => '$1 received an award',
	'useractivity-all' => 'View all',
	'useractivity-edit' => '$1 {{PLURAL:$4|edited the page|edited the following pages:}} $3', // Supports GENDER for the editor ($1) as $6 if $1 is one user.
	'useractivity-foe' => '$1 {{PLURAL:$2|is now foes with|are now foes with}} $3', // Supports GENDER for $1 as $6 if $1 is one user.
	'useractivity-friend' => '$1 {{PLURAL:$2|is now friends with|are now friends with}} $3', // Supports GENDER for the $1 as $6 if $1 is one user.
	'useractivity-gift' => '$1 received a gift from $2', // Supports GENDER for the editor ($1) as $6 if $1 is one user.
	'useractivity-group-edit' => '{{PLURAL:$1|one edit|$1 edits}}', // Supports GENDER for the one having made edits as $2
	'useractivity-group-comment' => '{{PLURAL:$1|one comment|$1 comments}}', // Supports GENDER for the one having made comments as $2
	'useractivity-group-user_message' => '{{PLURAL:$1|one message|$1 messages}}', // Supports GENDER for the one having messages as $2
	'useractivity-group-friend' => '{{PLURAL:$1|one friend|$1 friends}}', // Supports GENDER for the one having friends as $2
	'useractivity-siteactivity' => 'Site activity',
	'useractivity-title' => "Friends' activity",
	'useractivity-user_message' => '$1 {{PLURAL:$4|sent a message to|sent messages to}} $3', // Supports GENDER for the sender ($1) as $6 if $1 is one user.
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Naudefj
 */
$messages['qqq'] = array(
	'useractivity-edit' => 'Supports GENDER for the editor ($1) as $6 if $1 is one user.',
	'useractivity-foe' => 'Supports GENDER for $1 as $6 if $1 is one user.',
	'useractivity-friend' => 'Supports GENDER for the $1 as $6 if $1 is one user.',
	'useractivity-gift' => 'Supports GENDER for the editor ($1) as $6 if $1 is one user.',
	'useractivity-group-edit' => 'Supports GENDER for the one having made edits as $2',
	'useractivity-group-comment' => 'Supports GENDER for the one having made comments as $2
{{Identical|Comment}}',
	'useractivity-group-user_message' => 'Supports GENDER for the one having messages as $2
{{Identical|Message}}',
	'useractivity-group-friend' => 'Supports GENDER for the one having friends as $2',
	'useractivity-user_message' => 'Supports GENDER for the sender ($1) as $6 if $1 is one user.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'useractivity' => 'Vriende se aktiwiteit',
	'useractivity-award' => "$1 het 'n prys ontvang",
	'useractivity-all' => 'Wys almal',
	'useractivity-edit' => '$1 het die volgende {{PLURAL:$4|bladsy|bladsye}} wysig: $3',
	'useractivity-foe' => "$1 is nou {{PLURAL:$2|'n teenstander|teenstanders}} van $3",
	'useractivity-friend' => '$1 {{PLURAL:$2|is|is}} nou vriende met $3',
	'useractivity-gift' => "$1 het 'n geskenk van $2 ontvang",
	'useractivity-group-edit' => '$1 {{PLURAL:$1|wysiging|wysigings}}',
	'useractivity-group-comment' => '$1 {{PLURAL:$1|opmerking|opmerkings}}',
	'useractivity-group-user_message' => '$1 {{PLURAL:$1|boodskap|boodskappe}}',
	'useractivity-group-friend' => '$1 {{PLURAL:$1|vriend|vriende}}',
	'useractivity-siteactivity' => 'Werf-aktiwiteit',
	'useractivity-title' => 'Vriende se aktiwiteit',
	'useractivity-user_message' => "$1 het {{PLURAL:$4|'n boodskap|boodskappe}} aan $3 gestuur",
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'useractivity' => 'نشاط الأصدقاء',
	'useractivity-award' => '$1 تلقى جائزة',
	'useractivity-all' => 'عرض الكل',
	'useractivity-edit' => '$1 {{PLURAL:$4|عدل الصفحة|عدل الصفحات التالية:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|هو الآن عدو مع|هم الآن أعداء مع}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|هو الآن صديق مع|هم الآن أصدقاء مع}} $3',
	'useractivity-gift' => '$1 تلقى هدية من $2',
	'useractivity-group-edit' => '{{PLURAL:$1|تعديل واحد|$1 تعديل}}',
	'useractivity-group-comment' => '{{PLURAL:$1|تعليق واحد|$1 تعليق}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|رسالة واحدة|$1 رسالة}}',
	'useractivity-group-friend' => '{{PLURAL:$1|صديق واحد|$1 صديق}}',
	'useractivity-siteactivity' => 'نشاط الموقع',
	'useractivity-title' => 'نشاط الأصدقاء',
	'useractivity-user_message' => '$1 {{PLURAL:$4|أرسل رسالة إلى|أرسل رسائل إلى}} $3',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'useractivity' => 'Актыўнасьць сяброў',
	'useractivity-award' => '$1 атрымаў узнагароду',
	'useractivity-all' => 'Паказаць усё',
	'useractivity-edit' => '$1 рэдагаваў {{PLURAL:$4|старонку|наступныя старонкі:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|варагуе|варагуюць}} зараз з $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|сябруе|сябруюць}} зараз з $3',
	'useractivity-gift' => '$1 атрымаў падарунак ад $2',
	'useractivity-group-edit' => '$1 {{PLURAL:$1|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}',
	'useractivity-group-comment' => '$1 {{PLURAL:$1|камэнтар|камэнтары|камэнтараў}}',
	'useractivity-group-user_message' => '$1 {{PLURAL:$1|паведамленьне|паведамленьні|паведамленьняў}}',
	'useractivity-group-friend' => '$1 {{PLURAL:$1|сябар|сябры|сяброў}}',
	'useractivity-siteactivity' => 'Актыўнасьць на сайце',
	'useractivity-title' => 'Актыўнасьць сяброў',
	'useractivity-user_message' => '$1 {{GENDER:$6|даслаў|даслала}} {{PLURAL:$4|паведамленьне|паведамленьні}} $3',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'useractivity' => 'Obererezh ar mignoned',
	'useractivity-award' => '$1 en deus resevet ur garedon',
	'useractivity-all' => 'Gwelet pep tra',
	'useractivity-edit' => '$1 en deus kemmet {{PLURAL:$4|ar bajenn|ar bajennoù}} da heul : $3',
	'useractivity-foe' => 'Bremañ ez eo $1 {{PLURAL:$2|enebour|enebourien}} da $3',
	'useractivity-friend' => 'Bremañ ez eo $1 {{PLURAL:$2|mignon|mignoned}} gant $3',
	'useractivity-gift' => '$1 en deus resevet ur prof a-berzh $2',
	'useractivity-group-edit' => "{{PLURAL:$1|ur c'hemm|$1 kemm}}",
	'useractivity-group-comment' => '{{PLURAL:$1|un evezhiadenn|$1 evezhiadenn}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|ur gemennadenn|$1 kemennadenn}}',
	'useractivity-group-friend' => '{{PLURAL:$1|ur mignon|$1 mignon}}',
	'useractivity-siteactivity' => "Obererezh al lec'hienn",
	'useractivity-title' => 'Oberezh ar mignoned',
	'useractivity-user_message' => '$1 en deus kaset {{PLURAL:$4|ur gemennadenn|kemennadennoù}} da $3',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'useractivity' => 'Aktivnost prijatelja',
	'useractivity-award' => '$1 je dobio nagradu',
	'useractivity-all' => 'Pogledajte sve',
	'useractivity-group-edit' => '{{PLURAL:$1|jedna izmjena|$1 izmjene|$1 izmjena}}',
	'useractivity-siteactivity' => 'Aktivnosti na stranici',
	'useractivity-title' => 'Aktivnosti prijatelja',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'useractivity' => 'Aktiwita pśijaśelow',
	'useractivity-award' => '$1 jo myto dostał.',
	'useractivity-all' => 'Wšykno se woglědaś',
	'useractivity-edit' => '$1 {{PLURAL:$4|jo bok wobźěłał|jo slědujucej boka wobźěłał|jo slědujuce boki wobźěłał|jo slědujuce boki wobźěłał}}: $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|jo něnto njepśijaśel wót|stej něnto njepśijaśela wót|su něnto njepśijaśele wót|su něnto njepśijaśele wót}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|jo něnto pśijaśel wót|stej něnto pśijaśela|su něnto pśijaśele wót|su něnto pśijaśele wót}} $3',
	'useractivity-gift' => '$1 jo dóstał dar wót $2',
	'useractivity-group-edit' => '{{PLURAL:$1|jadna změna|$1 změnje|$1 změny|$1 změnow}}',
	'useractivity-group-comment' => '{{PLURAL:$1|jaden komentar|$1 komentara|$1 komentary|$1 komentarow}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|jadna powěźeńka|$1 powěźeńce|$1 powěźeńki|$1 powěźeńkow}}',
	'useractivity-group-friend' => '{{PLURAL:$1|jaden pśijaśel|$1 pśijaśela|$1 pśijaśele|$1 pśijaśelow}}',
	'useractivity-siteactivity' => 'Aktiwita sedła',
	'useractivity-title' => 'Aktiwita pśijaśelow',
	'useractivity-user_message' => '$1 {{PLURAL:$4|jo pósłał powěźeńku na|jo pósłał powěźeńce|jo pósłał powěźeńki|jo pósłał powěźeńki}} k $3',
);

/** Spanish (Español)
 * @author Peter17
 * @author Translationista
 */
$messages['es'] = array(
	'useractivity' => 'Actividad de amigos',
	'useractivity-award' => '$1 ha recibido un premio',
	'useractivity-all' => 'Ver todo',
	'useractivity-edit' => '$1 {{PLURAL:$4|ha editado la página|ha editado las siguientes páginas:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|se ha enemistado de|se han enemistado de}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|se ha|se han}}amistado con  $3',
	'useractivity-gift' => '$1 ha recibido un regalo de $2',
	'useractivity-group-edit' => '{{PLURAL:$1|una edición|$1 ediciones}}',
	'useractivity-group-comment' => '{{PLURAL:$1|un comentario|$1 comentarios}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|un mensaje|$1 mensajes}}',
	'useractivity-group-friend' => '{{PLURAL:$1|un amigo|$1 amigos}}',
	'useractivity-siteactivity' => 'Actividad del sitio',
	'useractivity-title' => 'Actividad de amigos',
	'useractivity-user_message' => '$1 {{PLURAL:$4|ha enviado un mensaje a |ha enviado mensajes a}} $3',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'useractivity' => 'Ystävien aktiivisuus',
	'useractivity-award' => '$1 sai palkinnon',
	'useractivity-all' => 'Katso kaikki',
	'useractivity-edit' => '$1 {{PLURAL:$2|muokkasi|muokkasivat}} {{PLURAL:$4|sivua|seuraavia sivuja:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|on nyt vihollinen|ovat nyt vihollisia}} {{PLURAL:$3|käyttäjälle|käyttäjille}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|on nyt ystävä|ovat nyt ystäviä}} {{PLURAL:$3|käyttäjälle|käyttäjille}} $3',
	'useractivity-gift' => '$1 sai lahjan käyttäjältä $2',
	'useractivity-group-edit' => '{{PLURAL:$1|yksi muokkaus|$1 muokkausta}}',
	'useractivity-group-comment' => '{{PLURAL:$1|yksi kommentti|$1 kommenttia}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|yksi viesti|$1 viestiä}}',
	'useractivity-group-friend' => '{{PLURAL:$1|yksi ystävä|$1 ystävät}}',
	'useractivity-siteactivity' => 'Sivuston aktiivisuus',
	'useractivity-title' => 'Ystävien aktiivisuus',
	'useractivity-user_message' => '$1 {{PLURAL:$4|lähetti viestin käyttäjälle|lähetti viestejä käyttäjille}} $3',
);

/** French (Français)
 * @author IAlex
 * @author Y-M D
 */
$messages['fr'] = array(
	'useractivity' => 'Activité des amis',
	'useractivity-award' => '$1 a reçu une récompense',
	'useractivity-all' => 'Tout voir',
	'useractivity-edit' => '$1 a modifié {{PLURAL:$4|la page|les pages suivantes :}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|est maintenant ennemi|sont maintenant ennemis}} avec $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|est maintenant ami avec|sont maintenant amis avec}} $3',
	'useractivity-gift' => '$1 a reçu un cadeau de la part de $2',
	'useractivity-group-edit' => '$1 {{PLURAL:$1|modification|modifications}}',
	'useractivity-group-comment' => '$1 {{PLURAL:$1|commentaire|commentaires}}',
	'useractivity-group-user_message' => '$1 {{PLURAL:$1|message|messages}}',
	'useractivity-group-friend' => '$1 {{PLURAL:$1|ami|amis}}',
	'useractivity-siteactivity' => 'Activité du site',
	'useractivity-title' => 'Activité des amis',
	'useractivity-user_message' => '$1 a envoyé {{PLURAL:$4|un message|des messages}} à $3',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'useractivity' => 'Actividade dos amigos',
	'useractivity-award' => '$1 recibiu un premio',
	'useractivity-all' => 'Ver todos',
	'useractivity-edit' => '$1 editou {{PLURAL:$4|a páxina|as seguintes páxinas:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|é agora inimigo de|son agora inimigos de}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|é agora amigo de|son agora amigos de}} $3',
	'useractivity-gift' => '$1 recibiu un agasallo de $2',
	'useractivity-group-edit' => '{{PLURAL:$1|unha edición|$1 edicións}}',
	'useractivity-group-comment' => '{{PLURAL:$1|un comentario|$1 comentarios}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|unha mensaxe|$1 mensaxes}}',
	'useractivity-group-friend' => '{{PLURAL:$1|un amigo|$1 amigos}}',
	'useractivity-siteactivity' => 'Actividade do sitio',
	'useractivity-title' => 'Actividade dos amigos',
	'useractivity-user_message' => '$1 enviou {{PLURAL:$4|unha mensaxe|mensaxes}} a $3',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'useractivity' => 'Aktivitet vu dr Frynd',
	'useractivity-award' => '$1 het e Uuszeichnig ibercuu',
	'useractivity-all' => 'Alli aaluege',
	'useractivity-edit' => '$1 {{PLURAL:$4|het die Syte bearbeitet|het die Syte bearbeitet:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|isch jetz e Fynd zuet|sin jetz Fynd zue}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|isch jetz e Frynd zue|sin jetz Frynd zue}} $3',
	'useractivity-gift' => '$1 het e Gschänk vu $2 iberchuu',
	'useractivity-group-edit' => '{{PLURAL:$1|Ei Änderig|$1 Änderige}}',
	'useractivity-group-comment' => '{{PLURAL:$1|Ei Aamerkig|$1 Aamerkige}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|Ei Nochricht|$1 Nochrichte}}',
	'useractivity-group-friend' => '{{PLURAL:$1|Ei Frynd|$1 Frynd}}',
	'useractivity-siteactivity' => 'Syteaktivitet',
	'useractivity-title' => 'Aktivitet vu dr Frynd',
	'useractivity-user_message' => '$1 {{PLURAL:$4|het e Nochricht gschickt an|het Nochrichte gschickt an}} $3',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'useractivity' => 'Aktiwita přećelow',
	'useractivity-award' => '$1 je myto dóstał',
	'useractivity-all' => 'Wšě sej wobhladać',
	'useractivity-edit' => '$1 {{PLURAL:$4|wobdźěła stronu|wobdźěła slědowacej stronje|wobdźěła slědowace strony|wobdźěła slědowace strony}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|je nětko njepřećel wot|staj nětko njepřećelej wot|su nětko njepřećeljo wot|su nětko njepřećeljo wot}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|je nětko přećel wot|staj nětko přećeljo wot|su nětko přećeljo wot|su nětko přećeljo wot}} $3',
	'useractivity-gift' => '$1 dósta dar wot $2',
	'useractivity-group-edit' => '{{PLURAL:$1|jedna změna|$1 změnje|$1 změny|$1 změnow}}',
	'useractivity-group-comment' => '{{PLURAL:$1|jedyn komentar|$1 komentaraj|$1 komentary|$1 komentarow}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|jedna zdźělenka|$1 zdźělence|$1 zdźělenki|$1 zdźělenkow}}',
	'useractivity-group-friend' => '{{PLURAL:$1|jedyn přećel|$1 přećelej|$1 přećeljo|$1 přećelow}}',
	'useractivity-siteactivity' => 'Aktiwita sydła',
	'useractivity-title' => 'Aktiwita přećelow',
	'useractivity-user_message' => '$1 {{PLURAL:$4|pósła powěsć na|pósła powěsći na|pósła powěsć na|pósła powěsće na}} $3',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'useractivity-award' => '$1 kapott egy díjat',
	'useractivity-all' => 'Összes megjelenítése',
	'useractivity-gift' => '$1 ajándékot kapott $2 felhasználótól',
	'useractivity-group-edit' => '{{PLURAL:$1|egy szerkesztés|$1 szerkesztés}}',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'useractivity' => 'Activitate de amicos',
	'useractivity-award' => '$1 ha recipite un premio',
	'useractivity-all' => 'Vider toto',
	'useractivity-edit' => '$1 modificava {{PLURAL:$4|le pagina|le sequente paginas:}} $3',
	'useractivity-foe' => '$1 es ora {{PLURAL:$2|inimico|inimicos}} de $3',
	'useractivity-friend' => '$1 es ora {{PLURAL:$2|amico|amicos}} de $3',
	'useractivity-gift' => '$1 ha recipite un presente de $2',
	'useractivity-group-edit' => '{{PLURAL:$1|un modification|$1 modificationes}}',
	'useractivity-group-comment' => '{{PLURAL:$1|un commento|$1 commentos}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|un message|$1 messages}}',
	'useractivity-group-friend' => '{{PLURAL:$1|un amico|$1 amicos}}',
	'useractivity-siteactivity' => 'Activitate del sito',
	'useractivity-title' => 'Activitate de amicos',
	'useractivity-user_message' => '$1 ha inviate {{PLURAL:$4|un message|messages}} a $3',
);

/** Japanese (日本語)
 * @author Hosiryuhosi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'useractivity' => '友達の活動度',
	'useractivity-all' => 'すべて表示',
	'useractivity-gift' => '$1が$2からのギフトを受け取りました',
	'useractivity-group-edit' => '{{PLURAL:$1|$1回の編集}}',
	'useractivity-group-comment' => '{{PLURAL:$1|$1コのコメント}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|$1コのメッセージ}}',
	'useractivity-group-friend' => '{{PLURAL:$1|$1人の友達}}',
	'useractivity-siteactivity' => 'サイトの活動度',
	'useractivity-title' => '友達の活動度',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'useractivity' => 'Wat de Frünnde aam donn sin',
	'useractivity-all' => 'Alles aanzeije',
	'useractivity-group-edit' => '{{PLURAL:$1|Ein Änderong|$1 Änderonge|Kein Änderong}}',
	'useractivity-group-comment' => '{{PLURAL:$1|Ein Aanmärkong|$1 Aanmärkonge|Kein Aanmärkonge}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|Ein Nohreesch|$1 Nohreeschte|Kein Nohreesch}}',
	'useractivity-group-friend' => '{{PLURAL:$1|Eine Fründ|$1 Fründe|Keine Fründ}}',
	'useractivity-siteactivity' => 'Wat op dä ßait loß es',
	'useractivity-title' => 'Wat de Frünnde donn',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'useractivity' => 'Aktivitéit vu Frënn',
	'useractivity-award' => '$1 huet eng Auszeechnung kritt',
	'useractivity-all' => 'Alles weisen',
	'useractivity-edit' => '$1 huet dës {{PLURAL:$4|Säit|Säite}} geännert: $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|ass elo e Feind|sinn elo Feinde}} vum $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|ass elo e Frënd vum|sinn elo Frënn vum}} $3',
	'useractivity-gift' => '$1 huet e Cadeau vum $2 kritt',
	'useractivity-group-edit' => '{{PLURAL:$1|eng Ännerung|$1 Ännerungen}}',
	'useractivity-group-comment' => '{{PLURAL:$1|eng Bemierkung|$1 Bemierkungen}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|ee Message|$1 Messagen}}',
	'useractivity-group-friend' => '{{PLURAL:$1|ee Frënd|$1 Frënn}}',
	'useractivity-siteactivity' => 'Aktivitéit um Site',
	'useractivity-title' => 'Aktivitéit vun de Frënn',
	'useractivity-user_message' => '$1 huet dem $3 {{PLURAL:$4|ee Message|Message}} geschéckt',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'useractivity' => 'Активности на пријателите',
	'useractivity-award' => '$1 доби награда',
	'useractivity-all' => 'Види ги сите',
	'useractivity-edit' => '$1 {{PLURAL:$4|ја уреди страницата|ги уреди следниве страници:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|стана непријател со|станаа непријатели со}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|се спријатели со|се спријателија со}} $3',
	'useractivity-gift' => '$1 прими подарок од $2',
	'useractivity-group-edit' => '{{PLURAL:$1|едно уредување|$1 уредувања}}',
	'useractivity-group-comment' => '{{PLURAL:$1|еден коментар|$1 коментари}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|една порака|$1 пораки}}',
	'useractivity-group-friend' => '{{PLURAL:$1|еден пријател|$1 пријатели}}',
	'useractivity-siteactivity' => 'Активност на веб-страницата',
	'useractivity-title' => 'Активности на пријателите',
	'useractivity-user_message' => '$1 {{PLURAL:$4|испрати порака на|испрати пораки на}} $3',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'useractivity-group-comment' => '{{PLURAL:$1|нэг сэтгэгдэл|$1 сэтгэгдэл}}',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'useractivity' => 'Acitiviteit van vrienden',
	'useractivity-award' => '$1 heeft een prijs ontvangen',
	'useractivity-all' => 'Allemaal bekijken',
	'useractivity-edit' => "$1 bewerkte de volgende {{PLURAL:$4|pagina|pagina's}}: $3",
	'useractivity-foe' => '$1 {{PLURAL:$2|is nu een tegenstander|zijn nu tegenstanders}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|is|zijn}} nu vrienden met $3',
	'useractivity-gift' => '$1 heeft een gift van $2 ontvangen',
	'useractivity-group-edit' => '$1 {{PLURAL:$1|bewerking|bewerkingen}}',
	'useractivity-group-comment' => '$1 {{PLURAL:$1|opmerking|opmerkingen}}',
	'useractivity-group-user_message' => '$1 {{PLURAL:$1|bericht|berichten}}',
	'useractivity-group-friend' => '$1 {{PLURAL:$1|vriend|vrienden}}',
	'useractivity-siteactivity' => 'Siteactiviteit',
	'useractivity-title' => 'Acitiviteit van vrienden',
	'useractivity-user_message' => '$1 heeft {{PLURAL:$4|een bericht|berichten}} verzonden aan $3',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'useractivity' => 'Venners aktivitet',
	'useractivity-award' => '$1 mottok en pris',
	'useractivity-all' => 'Vis alt',
	'useractivity-edit' => '$1 {{PLURAL:$4|redigerte siden|redigerte følgende sider:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|er nå en fiende av|er nå en fiende av}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|er nå en venn av|er nå en venn av}} $3',
	'useractivity-gift' => '$1 fikk en gave av $2',
	'useractivity-group-edit' => '{{PLURAL:$1|én redigering|$1 redigeringer}}',
	'useractivity-group-comment' => '{{PLURAL:$1|én kommentar|$1 kommentarer}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|én beskjed|$1 beskjeder}}',
	'useractivity-group-friend' => '{{PLURAL:$1|én venn|$1 venner}}',
	'useractivity-siteactivity' => 'Sideaktivitet',
	'useractivity-title' => 'Venners aktivitet',
	'useractivity-user_message' => '$1 {{PLURAL:$4|sendte en beskjed til|sendte flere beskjeder til}} $3',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'useractivity' => "Atività dj'amis",
	'useractivity-award' => "$1 a l'ha arsèivù un premi",
	'useractivity-all' => 'Varda tut',
	'useractivity-edit' => "$1 a l'ha modificà {{PLURAL:$4|la pàgina|le pàgine sì-dapress:}} $3",
	'useractivity-foe' => "$1 {{PLURAL:$2|a l'é adess nemis con|a son adess nemis con}} $3",
	'useractivity-friend' => "$1 {{PLURAL:$2|a l'é adess amis con|a son adess amis con}} $3",
	'useractivity-gift' => "$1 a l'ha arseivù un cadò da $2",
	'useractivity-group-edit' => '{{PLURAL:$1|na modìfica|$1 modìfiche}}',
	'useractivity-group-comment' => '{{PLURAL:$1|un coment|$1 coment}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|un mëssagi|$1 mëssagi}}',
	'useractivity-group-friend' => "{{PLURAL:$1|n'amis|$1 amis}}",
	'useractivity-siteactivity' => 'Atività dël sit',
	'useractivity-title' => "Atività dj'amis",
	'useractivity-user_message' => "$1 {{PLURAL:$4|a l'ha mandà un messagi a|a l'ha mandà ëd messagi a}} $3",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'useractivity-siteactivity' => 'د وېبځي فعاليت',
	'useractivity-title' => 'د ملګري فعاليت',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Luckas Blade
 */
$messages['pt'] = array(
	'useractivity' => 'Actividade dos amigos',
	'useractivity-award' => '$1 recebeu um prémio',
	'useractivity-all' => 'Ver todos',
	'useractivity-edit' => '$1 {{PLURAL:$4|editou a página|editou as seguintes páginas:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|é agora inimigo de|são agora inimigos de}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|é agora amigo de|são agora amigos de}} $3',
	'useractivity-gift' => '$1 recebeu uma prenda de $2',
	'useractivity-group-edit' => '{{PLURAL:$1|uma edição|$1 edições}}',
	'useractivity-group-comment' => '{{PLURAL:$1|um comentário|$1 comentários}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|uma mensagem|$1 mensagens}}',
	'useractivity-group-friend' => '{{PLURAL:$1|um amigo|$1 amigos}}',
	'useractivity-siteactivity' => 'Actividade no site',
	'useractivity-title' => 'Actividade dos amigos',
	'useractivity-user_message' => '$1 {{PLURAL:$4|enviou uma mensagem para|enviou mensagens para}} $3',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'useractivity-edit' => '$1 {{PLURAL:$4|editou a página|editou as seguintes páginas:}} $3',
	'useractivity-gift' => '$1 recebeu um presente de $2',
	'useractivity-group-edit' => '{{PLURAL:$1|uma edição|$1 edições}}',
	'useractivity-group-comment' => '{{PLURAL:$1|um comentário|$1 comentários}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|uma mensagem|$1 mensagens}}',
	'useractivity-group-friend' => '{{PLURAL:$1|um amigo|$1 amigos}}',
);

/** Russian (Русский)
 * @author Kv75
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'useractivity' => 'Действия друзей',
	'useractivity-award' => '$1 получил награду',
	'useractivity-all' => 'Смотреть все',
	'useractivity-edit' => '$1 отредактировал {{PLURAL:$4|страницу|следующие страницы:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|враждует сейчас с|враждуют сейчас с}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|дружит сейчас с|дружат сейчас с}} $3',
	'useractivity-gift' => '$1 получил подарок от $2',
	'useractivity-group-edit' => '$1 {{PLURAL:$1|правка|правки|правок}}',
	'useractivity-group-comment' => '$1 {{PLURAL:$1|комментарий|комментария|комментариев}}',
	'useractivity-group-user_message' => '$1 {{PLURAL:$1|сообщение|сообщения|сообщений}}',
	'useractivity-group-friend' => '$1 {{PLURAL:$1|друг|друга|друзей}}',
	'useractivity-siteactivity' => 'Активность сайта',
	'useractivity-title' => 'Действия друзей',
	'useractivity-user_message' => '$1 отправил {{PLURAL:$4|сообщение|сообщения}} $3',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'useractivity' => 'Vänners aktivitet',
	'useractivity-award' => '$1 {{PLURAL:$4|skickade ett meddelande till|skickade meddelanden till}} $3',
	'useractivity-all' => 'Visa alla',
	'useractivity-foe' => '$1 {{PLURAL:$2|är nu en fiende till|är nu fiender till}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|är nu en vän med|är nu vänner med}} $3',
	'useractivity-gift' => '$1 fick en present från $2',
	'useractivity-group-edit' => '{{PLURAL:$1|en redigering|$1 redigeringar}}',
	'useractivity-group-comment' => '{{PLURAL:$1|en kommentar|$1 kommentarer}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|ett meddelande|$1 meddelanden}}',
	'useractivity-group-friend' => '{{PLURAL:$1|en vän|$1 vänner}}',
	'useractivity-siteactivity' => 'Sajtaktivitet',
	'useractivity-title' => 'Vänners aktivitet',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'useractivity-all' => 'అన్నీ చూడండి',
	'useractivity-edit' => '$1 {{PLURAL:$4|ఈ పేజీని|ఈ పేజీలను}} మార్చారు: $3',
	'useractivity-gift' => '$1 $2 నుండి ఒక బహుమతిని అందుకున్నారు',
	'useractivity-group-edit' => '{{PLURAL:$1|ఒక మార్పు|$1 మార్పులు}}',
	'useractivity-group-comment' => '{{PLURAL:$1|ఒక వ్యాఖ్య|$1 వ్యాఖ్యలు}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|ఒక సందేశం|$1 సందేశాలు}}',
	'useractivity-group-friend' => '{{PLURAL:$1|ఒక స్నేహితుడు|$1 స్నేహితులు}}',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'useractivity' => 'Arkadaşların etkinliği',
	'useractivity-award' => '$1 bir ödül aldı',
	'useractivity-all' => 'Hepsini gör',
	'useractivity-siteactivity' => 'Site etkinliği',
	'useractivity-title' => 'Arkadaşların etkinliği',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'useractivity-user_message' => '$1 {{GENDER:$6|відправив|відправила}} {{PLURAL:$4|повідомлення|повідомлення|повідомлень}} $3',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'useractivity' => '好友动态',
	'useractivity-award' => '$1获得了一个奖励',
	'useractivity-all' => '查看全部',
	'useractivity-edit' => '$1{{PLURAL:$4|编辑了页面|编辑了如下页面：}}$3',
	'useractivity-foe' => '$1{{PLURAL:$2|现在与|现在与}}$3成为仇敌',
	'useractivity-friend' => '$1{{PLURAL:$2|现在与|现在与}}$3成为好友',
	'useractivity-gift' => '$1收到了一份来自$2的礼物',
	'useractivity-group-edit' => '{{PLURAL:$1|1次编辑|$1次编辑}}',
	'useractivity-group-comment' => '{{PLURAL:$1|1个评论|$1个评论}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|1条留言|$1条留言}}',
	'useractivity-group-friend' => '{{PLURAL:$1|1位好友|$1位好友}}',
	'useractivity-siteactivity' => '站点动态',
	'useractivity-title' => '好友动态',
	'useractivity-user_message' => '$1向$3{{PLURAL:$4|发送了1条信息|发送了信息}}',
);

