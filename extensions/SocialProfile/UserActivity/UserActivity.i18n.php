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
	'useractivity-comment' => '$1 {{PLURAL:$4|commented on the page|commented on the following pages:}} $3',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Naudefj
 * @author Siebrand
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
	'useractivity-comment' => 'Parameters:
* $1 is a username
* $3 is a list of pages
* $4 is the number of elements in $3; used for PLURAL.',
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

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'useractivity-group-user_message' => '{{PLURAL:$1|un mensache|$1 mensaches}}',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'useractivity' => 'نشاط الأصدقاء',
	'useractivity-award' => '$1 تلقى جائزة',
	'useractivity-all' => 'اعرض الكل',
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

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'useractivity-all' => 'ܚܙܝ ܟܠ',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'useractivity-all' => 'Hamısına bax',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Renessaince
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
	'useractivity-comment' => '$1 {{GENDER:$1|камэнтаваў|камэнтавала}} на {{PLURAL:$4|старонцы|наступных старонках:}} $3',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'useractivity' => 'বন্ধুদের সক্রিয়তা',
	'useractivity-award' => '$1 একটি পুরস্কার লাভ করেছেন',
	'useractivity-all' => 'সব দেখাও',
	'useractivity-siteactivity' => 'সাইটের সক্রিয়তা',
	'useractivity-title' => 'বন্ধুদের সক্রিয়তা',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'useractivity' => 'Obererezh ar vignoned',
	'useractivity-award' => '$1 en deus resevet ur garedon',
	'useractivity-all' => 'Gwelet pep tra',
	'useractivity-edit' => '$1 en deus kemmet {{PLURAL:$4|ar bajenn|ar pajennoù}} da heul : $3',
	'useractivity-foe' => 'Bremañ ez eo $1 {{PLURAL:$2|enebour|enebourien}} da $3',
	'useractivity-friend' => 'Bremañ ez eo $1 {{PLURAL:$2|mignon|mignoned}} gant $3',
	'useractivity-gift' => '$1 en deus resevet ur prof a-berzh $2',
	'useractivity-group-edit' => "{{PLURAL:$1|ur c'hemm|$1 kemm}}",
	'useractivity-group-comment' => '{{PLURAL:$1|un evezhiadenn|$1 evezhiadenn}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|ur gemennadenn|$1 kemennadenn}}',
	'useractivity-group-friend' => '{{PLURAL:$1|ur mignon|$1 mignon}}',
	'useractivity-siteactivity' => "Obererezh al lec'hienn",
	'useractivity-title' => 'Obererezh ar vignoned',
	'useractivity-user_message' => '$1 en deus kaset {{PLURAL:$4|ur gemennadenn|kemennadennoù}} da $3',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'useractivity' => 'Aktivnost prijatelja',
	'useractivity-award' => '$1 je dobio nagradu',
	'useractivity-all' => 'Pogledajte sve',
	'useractivity-edit' => '$1 {{PLURAL:$4|je uredio stranicu|je uredio slijedeće stranice:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|je sada neprijatelj sa|su sada neprijatelji sa}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|je sada prijatelj sa|su sada prijatelji sa}} $3',
	'useractivity-gift' => '$1 primio poklon od $2',
	'useractivity-group-edit' => '{{PLURAL:$1|jedna izmjena|$1 izmjene|$1 izmjena}}',
	'useractivity-group-comment' => '{{PLURAL:$1|jedan komentar|$1 komentara}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|jedna poruka|$1 poruke|$1 poruka}}',
	'useractivity-group-friend' => '{{PLURAL:$1|jedan prijatelj|$1 prijatelja}}',
	'useractivity-siteactivity' => 'Aktivnosti na stranici',
	'useractivity-title' => 'Aktivnosti prijatelja',
	'useractivity-user_message' => '$1 {{PLURAL:$4|je poslao poruku|je poslao poruke}} $3',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'useractivity-all' => 'Zobrazit všechny',
);

/** German (Deutsch)
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de'] = array(
	'useractivity' => 'Aktivitäten des Freundes',
	'useractivity-award' => '$1 erhielt eine Auszeichnung',
	'useractivity-all' => 'Alle anzeigen',
	'useractivity-edit' => '$1 {{PLURAL:$4|bearbeitete die Seite|bearbeitete die folgenden Seiten:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|ist nun {{GENDER:$6|Gegner|Gegnerin|Gegner}} von|sind nun Gegner von}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|ist nun {{GENDER:$6|Freund|Freundin|Freund}} von|sind nun Freunde von}} $3',
	'useractivity-gift' => '$1 erhielt ein Geschenk von $2',
	'useractivity-group-edit' => '{{PLURAL:$1|eine Bearbeitung|$1 Bearbeitungen}}',
	'useractivity-group-comment' => '{{PLURAL:$1|ein Kommentar|$1 Kommentare}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|eine Nachricht|$1 Nachrichten}}',
	'useractivity-group-friend' => '{{PLURAL:$1|ein Freund|$1 Freunde}}',
	'useractivity-siteactivity' => 'Aktivität auf der Seite',
	'useractivity-title' => 'Aktivitäten des Freundes',
	'useractivity-user_message' => '$1 {{PLURAL:$4|sandte eine Nachricht an|sandte Nachrichten an}} $3',
	'useractivity-comment' => '$1 {{PLURAL:$4|kommentierte die Seite|kommentierte die folgenden Seiten:}} $3',
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
 * @author Mor
 * @author Peter17
 * @author Translationista
 */
$messages['es'] = array(
	'useractivity' => 'Actividad de amigos',
	'useractivity-award' => '$1 ha recibido un premio',
	'useractivity-all' => 'Ver todo',
	'useractivity-edit' => '$1 {{PLURAL:$4|ha editado la página|ha editado las siguientes páginas:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|se ha enemistado de|se han enemistado de}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|es ahora amigos|son ahora amigos}} de  $3',
	'useractivity-gift' => '$1 ha recibido un regalo de $2',
	'useractivity-group-edit' => '{{PLURAL:$1|una edición|$1 ediciones}}',
	'useractivity-group-comment' => '{{PLURAL:$1|un comentario|$1 comentarios}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|un mensaje|$1 mensajes}}',
	'useractivity-group-friend' => '{{PLURAL:$1|un amigo|$1 amigos}}',
	'useractivity-siteactivity' => 'Actividad del sitio',
	'useractivity-title' => 'Actividad de amigos',
	'useractivity-user_message' => '$1 {{PLURAL:$4|ha enviado un mensaje a |ha enviado mensajes a}} $3',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'useractivity-all' => 'مشاهده همه',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Jack Phoenix <jack@countervandalism.net>
 * @author Str4nd
 */
$messages['fi'] = array(
	'useractivity' => 'Ystävien aktiivisuus',
	'useractivity-award' => '$1 sai palkinnon',
	'useractivity-all' => 'Katso kaikki',
	'useractivity-edit' => '$1 {{PLURAL:$2|muokkasi|muokkasivat}} {{PLURAL:$4|sivua|sivuja:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|on nyt vihollinen|ovat nyt vihollisia}} {{PLURAL:$4|käyttäjälle|käyttäjille}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|on nyt ystävä|ovat nyt ystäviä}} {{PLURAL:$4|käyttäjälle|käyttäjille}} $3',
	'useractivity-gift' => '$1 sai lahjan käyttäjältä $2',
	'useractivity-group-edit' => '{{PLURAL:$1|yksi muokkaus|$1 muokkausta}}',
	'useractivity-group-comment' => '{{PLURAL:$1|yksi kommentti|$1 kommenttia}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|yksi viesti|$1 viestiä}}',
	'useractivity-group-friend' => '{{PLURAL:$1|yksi ystävä|$1 ystävät}}',
	'useractivity-siteactivity' => 'Sivuston aktiivisuus',
	'useractivity-title' => 'Ystävien aktiivisuus',
	'useractivity-user_message' => '$1 {{PLURAL:$4|lähetti viestin käyttäjälle|lähetti viestejä käyttäjille}} $3',
	'useractivity-comment' => '$1 {{PLURAL:$2|kommentoi|kommentoivat}} {{PLURAL:$4|sivua|sivuja}}: $3',
);

/** French (Français)
 * @author Gomoko
 * @author IAlex
 * @author Verdy p
 * @author Y-M D
 */
$messages['fr'] = array(
	'useractivity' => 'Activité des amis',
	'useractivity-award' => '$1 a reçu une récompense',
	'useractivity-all' => 'Tout voir',
	'useractivity-edit' => '$1 a modifié {{PLURAL:$4|la page|les pages suivantes :}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|est maintenant ennemi|sont maintenant ennemis}} avec $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|est maintenant ami|sont maintenant amis}} avec $3',
	'useractivity-gift' => '$1 a reçu un cadeau de la part de $2',
	'useractivity-group-edit' => '$1 {{PLURAL:$1|modification|modifications}}',
	'useractivity-group-comment' => '$1 commentaire{{PLURAL:$1||s}}',
	'useractivity-group-user_message' => '$1 {{PLURAL:$1|message|messages}}',
	'useractivity-group-friend' => '$1 {{PLURAL:$1|ami|amis}}',
	'useractivity-siteactivity' => 'Activité du site',
	'useractivity-title' => 'Activité des amis',
	'useractivity-user_message' => '$1 a envoyé {{PLURAL:$4|un message|des messages}} à $3',
	'useractivity-comment' => '$1 a fait des commentaires sur {{PLURAL:$4|la page|les pages:}} $3',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'useractivity' => 'Activitât ux amis',
	'useractivity-award' => '$1 at reçu un prix',
	'useractivity-all' => 'Vêre tot',
	'useractivity-edit' => '$1 at changiê {{PLURAL:$4|la pâge|cetes pâges :}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|est ora ènemi|sont ora ènemis}} avouéc $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|est ora ami|sont ora amis}} avouéc $3',
	'useractivity-gift' => '$1 at reçu un present de $2',
	'useractivity-group-edit' => '$1 changement{{PLURAL:$1||s}}',
	'useractivity-group-comment' => '$1 comentèro{{PLURAL:$1||s}}',
	'useractivity-group-user_message' => '$1 mèssâjo{{PLURAL:$1||s}}',
	'useractivity-group-friend' => '$1 ami{{PLURAL:$1||s}}',
	'useractivity-siteactivity' => 'Activitât du seto',
	'useractivity-title' => 'Activitât ux amis',
	'useractivity-user_message' => '$1 at mandâ {{PLURAL:$4|un mèssâjo|des mèssâjos}} a $3',
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
	'useractivity-comment' => '$1 comentou {{PLURAL:$4|na páxina|nas seguintes páxinas:}} $3',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
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
	'useractivity-comment' => '$1 {{PLURAL:$4|het die Syte kommentiert|het die Syte kommentiert:}} $3',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'useractivity' => 'פעילות החברים',
	'useractivity-award' => '$1 {{GENDER:$1|קיבל|קיבלה}} פרס',
	'useractivity-all' => 'הצגת הכול',
	'useractivity-edit' => '$1 ערך את {{PLURAL:$4|הדף הבא|הדפים הבאים}}: $3',
	'useractivity-foe' => 'עכשיו $1 {{PLURAL:$2|יריב|יריבים}} של $3',
	'useractivity-friend' => 'עכשיו $1 {{PLURAL:$2|חבר|חברים}} של $3',
	'useractivity-gift' => '$1 {{GENDER:$6|קיבל|קיבלה}} מתנה מ־$2',
	'useractivity-group-edit' => '{{PLURAL:$1|עריכה אחת|$1 עריכות}}',
	'useractivity-group-comment' => '{{PLURAL:$1|הערה אחת|$1 הערות}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|הודעה אחת|$1 הודעות}}',
	'useractivity-group-friend' => '{{PLURAL:$1|חבר אחד|$1 חברים}}',
	'useractivity-siteactivity' => 'פעילות באתר',
	'useractivity-title' => 'פעילות החברים',
	'useractivity-user_message' => '$1 {{GENDER:$1|שלח|שלחה}} {{PLURAL:$4|הודעה|הודעות}} אל $3',
	'useractivity-comment' => '$1 הגיב על {{PLURAL:$4|הדף|הדפים הבאים:}} $3',
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
	'useractivity' => 'Barátok aktivitása',
	'useractivity-award' => '$1 kapott egy díjat',
	'useractivity-all' => 'Összes megjelenítése',
	'useractivity-edit' => '$1 szerkesztette a következő {{PLURAL:$4|lapot|lapokat}}: $3',
	'useractivity-foe' => '$1 és $3 mostantól ellenségek',
	'useractivity-friend' => '$1 és $3 mostantól barátok',
	'useractivity-gift' => '$1 ajándékot kapott $2 felhasználótól',
	'useractivity-group-edit' => '{{PLURAL:$1|egy szerkesztés|$1 szerkesztés}}',
	'useractivity-group-comment' => '$1 hozzászólás',
	'useractivity-group-user_message' => '$1 üzenet',
	'useractivity-group-friend' => '$1 barát',
	'useractivity-siteactivity' => 'Oldal aktivitás',
	'useractivity-title' => 'Barátok aktivitása',
	'useractivity-user_message' => '$1 {{PLURAL:$4|üzenetet|üzeneteket}} küldött neki: $3',
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
	'useractivity-comment' => '$1 commentava le {{PLURAL:$4|pagina|sequente paginas:}} $3',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 */
$messages['id'] = array(
	'useractivity' => 'Aktivitas teman',
	'useractivity-award' => '$1 menerima penghargaan',
	'useractivity-all' => 'Lihat semua',
	'useractivity-edit' => '$1 {{PLURAL:$4|menyunting halaman|menyunting halaman berikut:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|sekarang bermusuhan dengan|sekarang bermusuhan dengan}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|sekarang berteman dengan|sekarang berteman dengan}} $3',
	'useractivity-gift' => '$1 menerima hadiah dari $2',
	'useractivity-group-edit' => '{{PLURAL:$1|satu suntingan|$1 suntingan}}',
	'useractivity-group-comment' => '{{PLURAL:$1|satu komentar|$1 komentar}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|satu pesan|$1 pesan}}',
	'useractivity-group-friend' => '{{PLURAL:$1|satu teman|$1 teman}}',
	'useractivity-siteactivity' => 'Aktivitas situs',
	'useractivity-title' => 'Aktivitas teman',
	'useractivity-user_message' => '$1 {{PLURAL:$4|mengirimkan pesan ke|mengirimkan pesan ke}} $3',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Hosiryuhosi
 * @author Naohiro19
 * @author Schu
 * @author 青子守歌
 */
$messages['ja'] = array(
	'useractivity' => '友達の活動度',
	'useractivity-award' => '$1が賞を受賞しました',
	'useractivity-all' => 'すべて表示',
	'useractivity-edit' => '$1 {{PLURAL:$4|ページを編集|以下のページを編集:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|は次の人と敵対しています|は次の人々と敵対しています}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|は次の人と友好関係にあります|は次の人々と友好関係にあります}} $3',
	'useractivity-gift' => '$1が$2からのギフトを受け取りました',
	'useractivity-group-edit' => '{{PLURAL:$1|$1回の編集}}',
	'useractivity-group-comment' => '{{PLURAL:$1|$1コのコメント}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|$1コのメッセージ}}',
	'useractivity-group-friend' => '{{PLURAL:$1|$1人の友達}}',
	'useractivity-siteactivity' => 'サイトの活動度',
	'useractivity-title' => '友達の活動度',
	'useractivity-user_message' => '$1 {{PLURAL:$2|は次の人にメッセージを送りました|は次の人々にメッセージを送りました}} $3',
	'useractivity-comment' => '$1 {{PLURAL:$4|はページにコメントしました|は次にあげるページにコメントしました :}} $3',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'useractivity-group-user_message' => '{{PLURAL:$1|ಒಂದು ಸಂದೇಶ|$1 ಸಂದೇಶಗಳು}}',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'useractivity' => 'Wat de Frünnde aam donn sin',
	'useractivity-award' => '{{GENDER:$1|Dä|Et|Dä Metmaacher|De|Dat}} $1 hät en Ußzeichnung krääje.',
	'useractivity-all' => 'Alles aanzeije',
	'useractivity-edit' => '{{PLURAL:$2|{{GENDER:$6|Dä|Et|Dä Metmaacher|De|Dat}} $1 hät|$1 han|Keine hät}} {{PLURAL:$4|di Sigg|de Sigge|kein Sigg}} $3 beärbeidt.',
	'useractivity-foe' => '{{PLURAL:$2|{{GENDER:$6|Dä|Et|Dä Metmaacher|De|Dat}} $1 es jäz {{GENDER:$6|ene Feind|en Feinden|ene Feind|en Feinden|ene Feind}}|$1 sen jäz Feinde|Keine es jät}} {{GENDER:$3|vum|vum|vum Metmaacher|vun dä|vum}} $3',
	'useractivity-friend' => '{{PLURAL:$2|{{GENDER:$6|Dä|Et|Dä Metmaacher|De|Dat}} $1 es jäz {{GENDER:$6|ene Fründ|en Fründin|ene Fründ|en Fründin|ene Fründ}}|$1 sen jäz Fründe|Keine es jät}} {{GENDER:$3|vum|vum|vum Metmaacher|vun dä|vum}} $3',
	'useractivity-gift' => '{{PLURAL:$2|{{GENDER:$6|Dä|Et|Dä Metmaacher|De|Dat}} $1 hät|$1 han|Keine hät}} e Jeschenk {{GENDER:$2|vum|vum|vum Metmaacher|vun dä|vum}} $2 krääje.',
	'useractivity-group-edit' => '{{PLURAL:$1|Ein Änderong|$1 Änderonge|Kein Änderong}}',
	'useractivity-group-comment' => '{{PLURAL:$1|Ein Aanmärkong|$1 Aanmärkonge|Kein Aanmärkonge}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|Ein Nohreesch|$1 Nohreeschte|Kein Nohreesch}}',
	'useractivity-group-friend' => '{{PLURAL:$1|Eine Fründ|$1 Fründe|Keine Fründ}}',
	'useractivity-siteactivity' => 'Wat op dä ßait loß es',
	'useractivity-title' => 'Wat de Frünnde donn',
	'useractivity-user_message' => '{{GENDER:$1|Dä|Et|Dä Metmaacher|De|Dat}} $1 {{PLURAL:$4|hät en Nohreesch|hät Nohreeschte|kein Nohreesch}} aan {{GENDER:$6|der|et|dä Metmaacher|de|dat}} $3 jescheck',
	'useractivity-comment' => '{{GENDER:$1|Dä|Et|Dä Metmaacher|De|Dat}} $1 hät en Röckmäldong hergerlohße för {{PLURAL:$4|di Sigg|de Sigge|kein Sigg}} $3',
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
	'useractivity-comment' => '$1 huet dës {{PLURAL:$4|Säit|Säite}} kommentéiert: $3',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'useractivity' => 'Draugu darbeibys',
	'useractivity-award' => '$1 dabuoja apduovaņu',
	'useractivity-all' => 'Vērtīs vysys',
	'useractivity-gift' => '$1 dabuoja duovonu nu $2',
	'useractivity-group-edit' => '{{PLURAL:$1|vīna puormeja|$1 puormejis}}',
	'useractivity-group-comment' => '{{PLURAL:$1|vīns komentars|$1 komentari}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|vīns viestejums|$1 viestejumi}}',
	'useractivity-group-friend' => '{{PLURAL:$1|vīns draugs|$1 draugi}}',
	'useractivity-siteactivity' => 'Teiklavītys aktivums',
	'useractivity-title' => 'Draugu darbeibys',
	'useractivity-user_message' => '$1 nūsyuteja {{PLURAL:$4|viestejumu|viestejumus}} $3',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'useractivity' => 'Draugu aktivitāte',
	'useractivity-award' => '$1 saņēma balvu',
	'useractivity-all' => 'Skatīt visu',
	'useractivity-edit' => '$1 {{PLURAL:$4|rediģēja lapu|rediģēja šādas lapas:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|tagad ir ienaidnieks ar|tagad ir ienaidnieki ar}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|tagad ir draugs ar|tagad ir draugi ar}} $3',
	'useractivity-gift' => '$1 saņēma dāvanu no $2',
	'useractivity-group-edit' => '{{PLURAL:$1|viens labojums|$1 labojumi}}',
	'useractivity-group-comment' => '{{PLURAL:$1|viens komentārs|$1 komentāri}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|viens ziņojums|$1 ziņojumi}}',
	'useractivity-group-friend' => '{{PLURAL:$1|viens draugs|$1 draugi}}',
	'useractivity-siteactivity' => 'Aktivitāte vietnē',
	'useractivity-title' => 'Draugu aktivitāte',
	'useractivity-user_message' => '$1 {{PLURAL:$4|nosūtīja ziņu|nosūtīja ziņas uz}} $3',
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
	'useractivity-siteactivity' => 'Активност на мрежното место',
	'useractivity-title' => 'Активности на пријателите',
	'useractivity-user_message' => '$1 {{PLURAL:$4|испрати порака на|испрати пораки на}} $3',
	'useractivity-comment' => '$1 {{PLURAL:$4|коментираше на страницата|коментираше на следниве страници:}} $3',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'useractivity-group-comment' => '{{PLURAL:$1|нэг сэтгэгдэл|$1 сэтгэгдэл}}',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'useractivity' => 'Kegiatan kawan',
	'useractivity-award' => '$1 menerima satu anugerah',
	'useractivity-all' => 'Lihat semua',
	'useractivity-edit' => '$1 {{PLURAL:$4|menyunting laman|menyunting laman-laman berikut:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|kini bermusuhan dengan|kini bermusuhan dengan}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|kini berkawan dengan|kini berkawan dengan}} $3',
	'useractivity-gift' => '$1 menerima hadiah daripada $2',
	'useractivity-group-edit' => '{{PLURAL:$1|satu suntingan|$1 suntingan}}',
	'useractivity-group-comment' => '{{PLURAL:$1|satu komen|$1 komen}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|satu pesanan|$1 pesanan}}',
	'useractivity-group-friend' => '{{PLURAL: $1|seorang kawan|$1 kawan}}',
	'useractivity-siteactivity' => 'Kegiatan tapak',
	'useractivity-title' => 'Kegiatan rakan',
	'useractivity-user_message' => '$1 {{PLURAL:$4|menghantar satu pesanan kepada|menghantar pesanan-pesanan kepada}} $3',
	'useractivity-comment' => '$1 {{PLURAL:$4|mengulas laman|mengulas laman-laman berikut:}} $3',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'useractivity' => 'Acitiviteit van vrienden',
	'useractivity-award' => '$1 heeft een prijs ontvangen',
	'useractivity-all' => 'Allemaal bekijken',
	'useractivity-edit' => "$1 bewerkte de volgende {{PLURAL:$4|pagina|pagina's}}: $3",
	'useractivity-foe' => '$1 {{PLURAL:$2|is nu een tegenstander van|zijn nu tegenstanders van}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|is|zijn}} nu vrienden met $3',
	'useractivity-gift' => '$1 heeft een gift van $2 ontvangen',
	'useractivity-group-edit' => '$1 {{PLURAL:$1|bewerking|bewerkingen}}',
	'useractivity-group-comment' => '$1 {{PLURAL:$1|opmerking|opmerkingen}}',
	'useractivity-group-user_message' => '$1 {{PLURAL:$1|bericht|berichten}}',
	'useractivity-group-friend' => '$1 {{PLURAL:$1|vriend|vrienden}}',
	'useractivity-siteactivity' => 'Siteactiviteit',
	'useractivity-title' => 'Acitiviteit van vrienden',
	'useractivity-user_message' => '$1 heeft {{PLURAL:$4|een bericht|berichten}} verzonden aan $3',
	'useractivity-comment' => "$1 heeft opmerkingen geplaatst bij de {{PLURAL:$4|pagina|volgende pagina's:}} $3",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'useractivity-group-comment' => '{{PLURAL:$1|éin kommentar|$1 kommentarar}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|éi melding|$1 meldingar}}',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
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

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'useractivity-group-comment' => '{{PLURAL:$1|ee Aamaericking|$1 Aamaerickinge}}',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'useractivity' => 'Aktywność przyjaciół',
	'useractivity-award' => '$1 otrzymał nagrodę',
	'useractivity-all' => 'Pokaż wszystko',
	'useractivity-edit' => '$1 {{PLURAL:$4|{{GENDER:$6|edytował|edytowała|edytował}}|edytowali}} strony: $3',
	'useractivity-foe' => '{{PLURAL:}}$1 oraz $3 są obecnie wrogami',
	'useractivity-friend' => '{{PLURAL:}}$1 oraz $3 są obecnie przyjaciółmi',
	'useractivity-gift' => '$1 {{GENDER:$6|otrzymał|otrzymała|otrzymali}} prezent od $2',
	'useractivity-group-edit' => '{{GRAMMAR:$2|{{PLURAL:$1|raz edytował|$1 razy edytował}}|{{PLURAL:$1|raz edytowała|$1 razy edytowała}}|{{PLURAL:$1|raz edytowali|$1 razy edytowali}}}}',
	'useractivity-group-comment' => '{{GRAMMAR:$2|{{PLURAL:$1|raz skomentował|$1 razy skomentował}}|{{PLURAL:$1|raz skomentowała|$1 razy skomentowała}}|{{PLURAL:$1|raz skomentowali|$1 razy skomentowali}}}}',
	'useractivity-group-user_message' => '{{GRAMMAR:$2|{{PLURAL:$1|wysłał jedną wiadomość|wysłał $1 wiadomości}}|{{PLURAL:$1|wysłała jedną wiadomość|wysłała $1 wiadomości}}|{{PLURAL:$1|wysłali po jednej wiadomość|wysłali po $1 wiadomości}}}}',
	'useractivity-group-friend' => '{{PLURAL:$1|ma jednego przyjaciela|ma $1 przyjaciół}}',
	'useractivity-siteactivity' => 'Aktywność witryny',
	'useractivity-title' => 'Aktywność przyjaciół',
	'useractivity-user_message' => '$1 {{GENDER:$6|wysłał|wysłała|wysłali}} {{PLURAL:$4|wiadomość do|wiadomości do}} $3',
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
	'useractivity-comment' => "$1 a l'ha comentà {{PLURAL:$4|la pàgina|le pàgine sì-dapress:}} $3",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'useractivity-all' => 'ټول کتل',
	'useractivity-group-edit' => '{{PLURAL:$1|يو سمون|$1 سمونونه}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|يو پيغام|$1 پيغامونه}}',
	'useractivity-group-friend' => '{{PLURAL:$1|يو ملګری|$1 ملګري}}',
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
	'useractivity-comment' => '$1 {{PLURAL:$4|comentou a página|comentou as seguintes páginas:}} $3',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Danielsouzat
 * @author Giro720
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'useractivity' => 'Atividade dos amigos',
	'useractivity-award' => '$1 recebeu um prêmio',
	'useractivity-all' => 'Ver tudo',
	'useractivity-edit' => '$1 {{PLURAL:$4|editou a página|editou as seguintes páginas:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|é agora inimigo de|são agora inimigos de}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|é agora amigo de|são agora amigos de}} $3',
	'useractivity-gift' => '$1 recebeu um presente de $2',
	'useractivity-group-edit' => '{{PLURAL:$1|uma edição|$1 edições}}',
	'useractivity-group-comment' => '{{PLURAL:$1|um comentário|$1 comentários}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|uma mensagem|$1 mensagens}}',
	'useractivity-group-friend' => '{{PLURAL:$1|um amigo|$1 amigos}}',
	'useractivity-siteactivity' => 'Atividade no site',
	'useractivity-title' => 'Atividade dos amigos',
	'useractivity-user_message' => '$1 {{PLURAL:$4|enviou uma mensagem para|enviou mensagens para}} $3',
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
	'useractivity-comment' => '$1 {{PLURAL:$4|прокомментировал страницу|прокомментировал следующие страницы:}} $3',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'useractivity' => 'Актівіты приятелїв',
	'useractivity-award' => '$1 дістав оцінїня',
	'useractivity-all' => 'Видїти вшытко',
	'useractivity-gift' => '$1 дістав подарунок од $2',
	'useractivity-group-comment' => '$1 {{PLURAL:$1|коментарь|коментарї|коментарів}}',
	'useractivity-siteactivity' => 'Актівіта сайту',
	'useractivity-title' => 'Актівіты приятелїв',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'useractivity' => 'Активност пријатеља',
	'useractivity-award' => '$1 је примио/ла награду',
	'useractivity-all' => 'Прикажи све',
	'useractivity-foe' => '$1 {{PLURAL:$2|је сада непријатељ са}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|је сада пријатељ са}} $3',
	'useractivity-gift' => '$1 је примио/ла поклон од $2',
	'useractivity-group-edit' => '{{PLURAL:$1|једна измена|$1 измене|$1 измена}}',
	'useractivity-group-comment' => '{{PLURAL:$1|један коментар|$1 коментара|$1 коментара}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|једна|$1}} порука',
	'useractivity-group-friend' => '{{PLURAL:$1|један пријатељ|$1 пријатеља}}',
	'useractivity-siteactivity' => 'Активност сајта',
	'useractivity-title' => 'Активност пријатеља',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'useractivity' => 'Aktivnost prijatelja',
	'useractivity-award' => '$1 je primio/la nagradu',
	'useractivity-all' => 'Vidi sve',
	'useractivity-foe' => '$1 je sada neprijatelj sa $3',
	'useractivity-friend' => '$1 je sada prijatelj sa $3',
	'useractivity-gift' => '$1 je primio/la poklon od $2',
	'useractivity-group-edit' => '{{PLURAL:$1|jedna|$1}} izmena',
	'useractivity-group-comment' => '{{PLURAL:$1|jedan komentar|$1 komentara}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|jedna|$1}} poruka',
	'useractivity-group-friend' => '{{PLURAL:$1|jedan prijatelj|$1 prijatelja}}',
	'useractivity-siteactivity' => 'Aktivnost sajta',
	'useractivity-title' => 'Aktivnost prijatelja',
);

/** Swedish (Svenska)
 * @author Per
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'useractivity' => 'Vänners aktivitet',
	'useractivity-award' => '$1 fick en utmärkelse',
	'useractivity-all' => 'Visa alla',
	'useractivity-edit' => '$1 {{PLURAL:$4|redigerade sidan|redigerade följande sidor:}} $3',
	'useractivity-foe' => '$1 {{PLURAL:$2|är nu en fiende till|är nu fiender till}} $3',
	'useractivity-friend' => '$1 {{PLURAL:$2|är nu en vän med|är nu vänner med}} $3',
	'useractivity-gift' => '$1 fick en present från $2',
	'useractivity-group-edit' => '{{PLURAL:$1|en redigering|$1 redigeringar}}',
	'useractivity-group-comment' => '{{PLURAL:$1|en kommentar|$1 kommentarer}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|ett meddelande|$1 meddelanden}}',
	'useractivity-group-friend' => '{{PLURAL:$1|en vän|$1 vänner}}',
	'useractivity-siteactivity' => 'Sajtaktivitet',
	'useractivity-title' => 'Vänners aktivitet',
	'useractivity-user_message' => '$1 {{PLURAL:$4|skickade ett meddelande till|skickade meddelande till}} $3',
	'useractivity-comment' => '$1 {{PLURAL:$4|kommenterade på sidan|kommenterade på följande sidor:}} $3',
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

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'useractivity' => 'Galaw ng mga kaibigan',
	'useractivity-award' => 'Nakatanggap ng isang gantimpala si $1',
	'useractivity-all' => 'Tingnan lahat',
	'useractivity-edit' => 'Si $1 ay {{PLURAL:$4|nagbago ng pahinang|nagbago ng sumusunod na mga pahina:}} $3',
	'useractivity-foe' => 'Si(na) $1 ay {{PLURAL:$2|ay kaaway na ngayon ni|ay mga kaaway na ngayon ni}} $3',
	'useractivity-friend' => 'Si(na) $1 ay {{PLURAL:$2|kaibigan na ngayon ni|ay mga kaibigan na ngayon ni}} $3',
	'useractivity-gift' => 'Nakatanggap si $1 ng regalo mula kay $2',
	'useractivity-group-edit' => '{{PLURAL:$1|isang pagbabago|$1 mga pagbabago}}',
	'useractivity-group-comment' => '{{PLURAL:$1|isang puna|$1 mga puna}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|isang mensahe|$1 mga mensahe}}',
	'useractivity-group-friend' => '{{PLURAL:$1|isang kaibigan|$1 mga kaibigan}}',
	'useractivity-siteactivity' => 'Galaw sa sityo',
	'useractivity-title' => 'Galaw ng mga kaibigan',
	'useractivity-user_message' => 'Si $1 ay {{PLURAL:$4|nagpadala ng isang mensahe kay|nagpadala ng mga mensahe kay}} $3',
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
 * @author Тест
 */
$messages['uk'] = array(
	'useractivity-all' => 'Переглянути все',
	'useractivity-group-edit' => '$1 {{PLURAL:$1|редагування|редагування|редагувань}}',
	'useractivity-group-comment' => '{{PLURAL:$1|один коментар|$1 коментарі|$1 коментарів}}',
	'useractivity-user_message' => '$1 {{GENDER:$6|відправив|відправила}} {{PLURAL:$4|повідомлення|повідомлення|повідомлень}} $3',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Xiaomingyan
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
	'useractivity-group-user_message' => '$1条信息',
	'useractivity-group-friend' => '{{PLURAL:$1|1位好友|$1位好友}}',
	'useractivity-siteactivity' => '站点动态',
	'useractivity-title' => '好友动态',
	'useractivity-user_message' => '$1向$3{{PLURAL:$4|发送了1条信息|发送了信息}}',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'useractivity' => '好友動態',
	'useractivity-award' => '$1 獲得了一個獎勵',
	'useractivity-all' => '檢視全部',
	'useractivity-edit' => '$1 {{PLURAL:$4|編輯了頁面|編輯了如下頁面：}}$3',
	'useractivity-foe' => '$1 {{PLURAL:$2|現在與|現在與}} $3 成為仇人',
	'useractivity-friend' => '$1 {{PLURAL:$2|現在與|現在與}} $3 成為好友',
	'useractivity-gift' => '$1 收到了一份來自 $2 的禮物',
	'useractivity-group-edit' => '{{PLURAL:$1|一次編輯|$1 次編輯}}',
	'useractivity-group-comment' => '{{PLURAL:$1|一個評論|$1 個評論}}',
	'useractivity-group-user_message' => '{{PLURAL:$1|一則留言|$1 則留言}}',
	'useractivity-group-friend' => '{{PLURAL:$1|一位好友|$1 位好友}}',
	'useractivity-siteactivity' => '站點動態',
	'useractivity-title' => '好友動態',
	'useractivity-user_message' => '$1 向 $3 {{PLURAL:$4|傳送了 1 則訊息|傳送了訊息}}',
);

