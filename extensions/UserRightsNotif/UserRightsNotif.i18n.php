<?php
/**
 * Internationalisation file for extension UserRightsNotif.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'userrightsnotifysubject' => 'Group membership change on $1',
	'userrightsnotifybody'    => "Hello $1.

This is to inform you that your group memberships on $2 were changed by $3 at $4.

Added: $5
Removed: $6

With regards,

$2",
	'userrightsnotif-desc'    => 'Sends e-mail notification to users upon rights changes',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Lloffiwr
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'userrightsnotifysubject' => 'Probably the heading on an e-mail sent to notify a user of changes in his group membership rights.

$1 is probably the name of the wiki.',
	'userrightsnotifybody' => '* $1 is the recipient
* $2 is the sitename
* $3 is the user that made the change that is notified for
* $4 is a timestamp in the content language
* $5 are the groups that have been added
* $6 are the groups that have been removed',
	'userrightsnotif-desc' => '{{desc}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'userrightsnotifysubject' => 'Groepslidmaatskap is gewysig op $1',
	'userrightsnotifybody' => 'Hallo $1

Dit is om u in kennis te stel dat u groepslidmaatskap op $2 deur $3 op $4 gewysig is.

Bygevoeg: $5
Verwyder: $6

Met vriendelike groete,

$2',
	'userrightsnotif-desc' => 'E-pos kennisgewing aan gebruikers sodra gebruikersregte verander',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'userrightsnotifysubject' => 'Grupi ndryshojë anëtarësimi në $1',
	'userrightsnotifybody' => 'Përshëndetje $1. Kjo është për të ju informuar se grupi i anëtarësisë suaj në $2 u ndryshuar nga $3 më $4. Added: $5 Removed: $6  Lidhur me,

$2',
	'userrightsnotif-desc' => 'dërgon lajmërim me e-mail përdoruesve të mbi të drejtat e ndryshimeve',
);

/** Arabic (العربية)
 * @author Meno25
 * @author ترجمان05
 */
$messages['ar'] = array(
	'userrightsnotifysubject' => 'تغيير مجموعات العضوية في $1',
	'userrightsnotifybody' => 'مرحبا $1

هذا لإعلامك أن مجموعات عضويتك في $2 تغيرت بواسطة $3 في $4.

أضاف: $5
أزال: $6

مع التحية،

$2',
	'userrightsnotif-desc' => 'يرسل إشعار بريد إلكتروني إلى المستخدمين على تغييرات الحقوق',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'userrightsnotifysubject' => 'تغيير مجموعات العضوية فى $1',
	'userrightsnotifybody' => 'مرحبا $1

هذا لإعلامك أن مجموعات عضويتك فى $2 تغيرت بواسطة $3 فى $4.

أضاف: $5
أزال: $6

مع التحية،

$2',
	'userrightsnotif-desc' => 'يبعت إيميل لليوزرز على تغييرات الحقوق',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'userrightsnotifysubject' => "Cambiu del grupu d'usuariu a $1",
	'userrightsnotifybody' => "Hola $1:

Esti corréu ye pa informate de que'l grupu al que pertenecíes en $2 camudolu $3 el $4.


Amestáu: $5
Desaniciáu: $6

Un saludu caldiu,

$2",
	'userrightsnotif-desc' => 'Unviar un avisu per corréu a los usuarios tres camudar los permisos',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'userrightsnotifysubject' => 'Зьменены ўдзел у групах $1',
	'userrightsnotifybody' => 'Вітаем, $1.

Гэтае паведамленьне інфармуе Вас пра тое, што Ваш удзел у групах $2 быў зьменены з $3 у $4.

Дададзеная: $5
Выдалена: $6

З найлепшымі пажаданьнямі,

$2',
	'userrightsnotif-desc' => 'Дасылае ўдзельнікам паведамленьні па электроннай пошце пра зьмены правоў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'userrightsnotifysubject' => 'Промяна на груповата принадлежност в $1',
	'userrightsnotifybody' => 'Здравейте $1,

С това писмо ви уведомяваме, че вашата групова принадлежност в $2 беше променена от $3 на $4.

Добавено: $5
Премахнато: $6

Поздрави,

$2',
	'userrightsnotif-desc' => 'Изпраща оповестяване по е-поща при промяна на потребителски права',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'userrightsnotifysubject' => '$1-এ দলের সদস্যপদ পরিবর্তন',
	'userrightsnotifybody' => 'প্রিয় $1

আপনার অবগতির জন্য জানানো যাচ্ছে যে $2-এ আপনার দলীয় সদস্যপদ $3 পরিবর্তন করে $4 করেছেন।

যোগ করা হয়েছে: $5
মুছে ফেলা হয়েছে: $6

ধন্যবাদান্তে,

$2',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'userrightsnotifysubject' => 'Kemmoù emezeladur e strolladoù implijerien war $1',
	'userrightsnotifybody' => "Demat $1

Setu aze ur c'hemenn evit ho kelaouiñ eo bet kemmet hoc'h emezeladur d'ar strolladoù implijerien war $2 gant $3 d'an $4.

Ouzhpennet : $5
Tennet : $6

A galon,

$2",
	'userrightsnotif-desc' => "Kas a ra ur postel kelaouiñ d'an implijerien zo bet kemmet o gwirioù",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'userrightsnotifysubject' => 'Članstvo grupe se promijenilo na $1',
	'userrightsnotifybody' => 'Zdravo $1,

Ovo je poruka koja Vas obavještava da je Vaše članstvo u grupi od $2 promijenjeno od strane korisnika $3 dana $4.

Dodano: $5
Uklonjeno: $6

S poštovanjem,

$2',
	'userrightsnotif-desc' => 'Šalje obavještenje e-mailom korisnicima nakon promjena njihovih prava',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'userrightsnotifysubject' => "Canvi del grup d'usuari a $1",
	'userrightsnotifybody' => "Hola $1.

Us voldríem informar que els vostre grup d'usuari de $2 ha estat canviat per $3 a $4.

Heu estat afegit a: $5
Ja no formeu part de: $6

Atentament,

$2",
	'userrightsnotif-desc' => 'Envia una notificació als usuaris per correu electrònic quan es canvien els seus drets',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'userrightsnotifybody' => 'سڵاو $1.

ئەمە بۆ ئاگادارکردنەوەتە کە هاوبەشیەکانی گرووپت لە $2 دا بەدەست $3 لە $4 دا گۆڕدرا.

زیادکرا:$5 <br />
لابرا:$6  

لەگەڵ ڕێزدا، 

$2',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'userrightsnotifysubject' => 'Změna členství $1 ve skupině',
	'userrightsnotifybody' => 'Dobrý den, $1

Tímto vás informujeme, že vaše členství ve skupině bylo změněno z $3 na $4.

Přidáno: $5
Odstraněno: $6

S pozdravem,

$2',
	'userrightsnotif-desc' => 'Posílá upozornění na emaily uživatelům při změně oprávnění',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'userrightsnotifysubject' => 'Newid yn eich aelodaeth grŵp ar $1',
	'userrightsnotifybody' => "Henffych $1.

Fe'ch hysbysir bod eich aelodaeth o grwpiau ar $2 wedi ei newid gan $3 am $4.

Ychwanegwyd: $5
Tynnwyd: $6

Yn ddiffuant,

$2",
	'userrightsnotif-desc' => 'Yn anfon e-bost i hysbysu defnyddiwr o newid yn ei alluoedd',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'userrightsnotifysubject' => 'Änderung der Gruppenzugehörigkeit vom $1',
	'userrightsnotifybody' => 'Hallo $1

Dies ist eine Information, dass deine Gruppenzugehörigkeit von $2 durch $3 am $4 geändert wurde.

Hinzugefügt: $5
Entfernt: $6

Mit freundlichen Grüßen,

$2',
	'userrightsnotif-desc' => 'Sendet E-Mail-Benachrichtungen über Rechteänderungen an den Benutzer',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Raimond Spekking
 */
$messages['de-formal'] = array(
	'userrightsnotifybody' => 'Hallo $1

Dies ist eine Information, dass Ihre Gruppenzugehörigkeit von $2 durch $3 am $4 geändert wurde.

Hinzugefügt: $5
Entfernt: $6

Mit freundlichen Grüßen,

$2',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'userrightsnotifysubject' => 'Změna kupkoweje pśisłušnosći na $1',
	'userrightsnotifybody' => 'Halo $1.

To jo informacija, až jo se twója kupkowa pśisłušnosć na $2 wót $3 na $4 změniła.

Pśidany: $5
Wótwónoźony: $6

Z pśijaśelnymi póstrowami,

$2',
	'userrightsnotif-desc' => 'Sćele e-mailowe powěźeńki wužywarjam pśi změnjenju pšawow',
);

/** Greek (Ελληνικά)
 * @author Απεργός
 */
$messages['el'] = array(
	'userrightsnotifysubject' => 'Αλλαγή ιδιότητας μέλους στο εγχείρημα $1',
	'userrightsnotifybody' => 'Γεια σας, $1

Σας ειδοποιούμε ότι οι ιδιότητες μέλους σας στο εγχείρημα $2 αλλάχτηκαν από τον/την $3 στις $4.

Προσθήκη: $5
Αφαίρεση: $6

Με εκτίμηση,

$2',
	'userrightsnotif-desc' => 'Στέλνει ηλεκτρονική ειδοποίηση σε χρήστες μετά από αλλαγή δικαιωμάτων',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'userrightsnotifysubject' => 'Ŝanĝo de grupa membreco en $1',
	'userrightsnotifybody' => 'Saluton, $1.

Bonvolu noti ke via grupa membreco en $2 estis ŝanĝita de $3 je $4.

Aldonis: $5
Forigis: $6

Kore salutas $2',
	'userrightsnotif-desc' => 'Sendus retpoŝtajn noticojn al uzantoj se rajtoj ŝangus',
);

/** Spanish (Español)
 * @author Antur
 * @author Dferg
 */
$messages['es'] = array(
	'userrightsnotifysubject' => 'Grupo de usuario modificado en $1',
	'userrightsnotifybody' => 'Hola $1.

Por la presente le informo que sus derechos de usuario en $2 fueron modificados por $3 y $4.

Agregado: $5

Retirado: $6

Cordialmente,

$2',
	'userrightsnotif-desc' => 'Enviar notificación por correo electrónico a usuarios cuyos derechos se han modificado',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Str4nd
 */
$messages['fi'] = array(
	'userrightsnotifysubject' => 'Käyttäjäryhmän jäsenyyden vaihto wikissä $1',
	'userrightsnotifybody' => 'Hei $1.

Tämä on ilmoitus, että jäsenyyttäsi käyttäjäryhmissä on muutettu sivustolla $2 käyttäjän $3 toimesta $4.

Lisättiin: $5
Poistettiin: $6

Terveisin,

$2',
	'userrightsnotif-desc' => 'Lähettää sähköpostiviestin käyttäjille, kun heidän oikeuksiaan muutetaan.',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'userrightsnotifysubject' => 'Changement d’appartenance à des groupes d’utilisateurs sur $1',
	'userrightsnotifybody' => 'Bonjour $1,

J’ai l’honneur de vous informer que votre appartenance aux groupes d’utilisateurs sur $2 a été modifiée par $3 le $4.

Ajouté : $5
Retiré : $6

Cordialement,

$2',
	'userrightsnotif-desc' => 'Envoie un courriel de notification aux utilisateurs dont les droits ont été modifiés',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'userrightsnotifysubject' => 'Changement d’apartegnence a des tropes d’usanciérs dessus $1',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'userrightsnotifysubject' => 'Os membros do grupo cambiaron a $1',
	'userrightsnotifybody' => 'Ola $1:

Isto é para informalo de que o grupo ao que pertencía en $2 foi cambiado por $3 o $4.


Engadido: $5
Eliminado: $6

Un cordial saúdo,

$2',
	'userrightsnotif-desc' => 'Envía unha notificación por correo electrónico aos usuarios unha vez que os seus dereitos cambien',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author Melancholie
 */
$messages['gsw'] = array(
	'userrightsnotifysubject' => 'Änderig vu dr Gruppezuegherigkeit vum $1',
	'userrightsnotifybody' => 'Sali $1

Des isch e Information, ass Dyyni Gruppezuegherigkeit vu $2 dur $3 am $4 gänderet woren isch.

Zuegfeigt: $5
Usegnuh: $6

Mit härzlige Grieß,

$2',
	'userrightsnotif-desc' => 'Schickt E-Mail-Benochrichtunge iber Rächtänderige an de Benutzer',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 */
$messages['gu'] = array(
	'userrightsnotifysubject' => '$1 પર સમૂહ સદસ્યતામાં પરિવર્તન',
	'userrightsnotifybody' => 'નમસ્કાર $1.

આપને જાણ કરવામા આવે છે કે આપની $2 પરની સમૂહ સદસ્યતામાં $3 દ્વારા $4 ના ફેરફાર થયેલ છે. 

ઉમેર્યા: $5

હટાવ્યા: $6

સાદર,

$2',
	'userrightsnotif-desc' => 'હક્કોમાં ફેરફારની સુચના સભ્યોને ઇ-મેઇલથી મોકલો',
);

/** Hebrew (עברית)
 * @author Rotemliss
 */
$messages['he'] = array(
	'userrightsnotifysubject' => 'החברות בקבוצה השתנתה באתר $1',
	'userrightsnotifybody' => 'שלום $1.

מטרת הודעה זו היא ליידע אתכם שחברותכם בקבוצות באתר $2 שונתה על ידי $3 ב־$4.

נוספו: $5
הוסרו: $6

בברכה,

$2',
	'userrightsnotif-desc' => 'שליחת התראה בדואר האלקטרוני למשתמשים כאשר משתנות הרשאותיהם',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'userrightsnotifysubject' => 'Promijenjena suradnička prava za $1',
	'userrightsnotifybody' => 'Pozdrav $1.

Ovo je obavijest o promijeni suradničkih prava za vas koje je promijenio $3 na $4, dana $2.

Dodano: $5
Uklonjeno: $6

$2',
	'userrightsnotif-desc' => 'Šalje suradnicima obavijest elektroničkom poštom o promjeni prava',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'userrightsnotifysubject' => 'Změna skupinoweho čłonstwa na $1',
	'userrightsnotifybody' => 'Witaj $1

To je informacija, zo twoje skupinowe čłonstwo na $2 bu wot $3 pola $4 změnjene.

Přidaty: $5
Wotstronjeny: $6

Postrowy,

$2',
	'userrightsnotif-desc' => 'Sćele wužiwarjam e-mejlowu powěsće při změnjenju prawow',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'userrightsnotifysubject' => 'Csoporttagság változás a $1 oldalon',
	'userrightsnotifybody' => 'Szia $1!

Tájékoztatlak, hogy a csoporttagságodat a(z) $2 oldalon $3 megváltoztatta. Módosítás ideje: $4.

Hozzáadva: $5
Eltávolítva: $6

Üdvözlettel,
$2',
	'userrightsnotif-desc' => 'E-mail üzenetet küld a felhasználóknak jogosultságaik megváltozásakor',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'userrightsnotifysubject' => 'Cambiamento de appertinentia a gruppos in $1',
	'userrightsnotifybody' => 'Salute $1,

Isto es pro informar te que tu appertinentia al gruppos in $2 ha essite cambiate per $3 le $4.

Addite: $5
Retirate: $6

Cordialmente,

$2',
	'userrightsnotif-desc' => 'Invia un notification per e-mail al usatores cuje derectos es cambiate',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'userrightsnotifysubject' => 'Perubahan kelompok pengguna pada $1',
	'userrightsnotifybody' => 'Halo $1.

Kelompok pengguna Anda di $2 telah diubah oleh $3 pada $4.

Penambahan: $5
Pengurangan: $6

Terima kasih,

$2',
	'userrightsnotif-desc' => 'Mengirimkan notifikasi melalui surel ke para pengguna saat ada perubahan hak pengguna',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Melos
 */
$messages['it'] = array(
	'userrightsnotifysubject' => 'Cambiato gruppo di appartenenza in $1',
	'userrightsnotifybody' => 'Ciao $1.

Ti informiamo che il tuo gruppo di appartenenza su $2 è stato cambiato da $3 il $4

Aggiunti: $5
Rimossi: $6

Cordiali saluti,

$2',
	'userrightsnotif-desc' => 'Invia una e-mail di notifica quando vengono cambiati i diritti del gruppo utente di un utente',
);

/** Japanese (日本語)
 * @author Aotake
 */
$messages['ja'] = array(
	'userrightsnotifysubject' => '$1における所属グループ変更のお知らせ',
	'userrightsnotifybody' => '$1さん、こんにちは。

この通知は、$2におけるあなたの所属グループが$4に$3によって変更されたことをお知らせするものです。

加入: $5
脱退: $6

今後ともよろしくお願いいたします。

$2',
	'userrightsnotif-desc' => '利用者権限が変更された時に利用者に電子メールによる通知を送付する',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'userrightsnotifysubject' => 'Kaanggotan grup diganti ing $1',
	'userrightsnotifybody' => 'Halo $1.

Klompok panganggo panjenengan ing $2 wis diowahi déning $3 ing $4.

Panambahan: $5
Pangurangan: $6

Matur nuwun,

$2',
	'userrightsnotif-desc' => 'Kirim notifikasi liwat layang-e marang para panganggo wektu ana owah-owahan hak',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'userrightsnotifysubject' => 'ការផ្លាស់ប្តូរក្រុមសមាជិកភាពនៅលើ $1',
	'userrightsnotifybody' => 'ជម្រាបសួរ $1 ។

នេះជាសេចក្តីជូនដំណឹងដល់អ្នកដោយក្រុមសមាជិកភាពរបស់អ្នកនៅលើ $2 ត្រូវបានផ្លាស់ប្តូរដោយ $3 នៅ $4 ។

បានដាក់បន្ថែម: $5
បានដកហូត: $6

ដោយសេចក្តីគោរពរាប់អាន

$2',
	'userrightsnotif-desc' => 'ផ្ញើអ៊ីមែលជូនដំណឹងទៅកាន់អ្នកប្រើប្រាស់នៅពេលផ្លាស់ប្តូរសិទ្ធិ',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'userrightsnotifysubject' => '$1에서의 사용자 권한 변경',
	'userrightsnotifybody' => '$1님 안녕하세요.

이 메일을 통해 $4에 $2의 사용자 권한이 $3에 의해 변경되었음을 알리고자 합니다.

추가: $5
제거: $6

안녕히 계세요.

$2',
	'userrightsnotif-desc' => '사용자 권한 변경 후 사용자에게 알림 이메일을 보냄',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'userrightsnotifysubject' => 'De Medmaacher ier Jroppe woote verändert op $1',
	'userrightsnotifybody' => 'Dach $1.

Am $4 hät dä Metmaacher $3 Ding Metmaacher-Jroppe
em Wiki §2 verändert, un hät Dich
dobeijedonn in $5,
eruß jenomme uß $6.

Enne schöne Jroß!

$2',
	'userrightsnotif-desc' => 'Scheck en E-Mail aan dä Medmaacher, wann em sing Rääschte (övver Metmaacher-Jroppe) verändert woode sin',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'userrightsnotifysubject' => 'Ännerung vun de Memberen vun de Gruppen vum $1',
	'userrightsnotifybody' => 'Salut $1

Heimat gitt Dir informéiert, datt äer Meberschaft am Grupp vun $2 vum $3 den $4 geännert gouf.

Derbäigesat: $5
Erausgeholl: $6

Mat beschte Gréiss,

$2',
	'userrightsnotif-desc' => 'Schéckt dem Benotzer eng Informatioun per E-mail wa seng Rechter änneren',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'userrightsnotifysubject' => 'Промена во членството во група на $1',
	'userrightsnotifybody' => 'Здраво $1.

Би сакале да ве информираме дека вашите членства во групите на страницата $2 беа променети од $3 во $4.

Додадени: $5
Отстранети: $6

Со почит,

$2',
	'userrightsnotif-desc' => 'Им испраќа известување на корисниците по е-пошта кога ќе се променат правата',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'userrightsnotifybody' => 'നമസ്കാരം $1.

താങ്കളുടെ $2ലുള്ള സംഘ അംഗത്വം $3, $4 നു മാറ്റി എന്നറിയിക്കാനാണ്‌ ഈ കത്ത്.

ചേർത്തത്: $5
ഒഴിവാക്കിയത്: $6

ആശംസകളോടെ,

$2',
	'userrightsnotif-desc' => 'അവകാശങ്ങളിൽ വന്ന വ്യത്യാസങ്ങളെക്കുറിച്ച് ഉപയോക്താക്കൾക്ക് ഇമെയിൽ അറിയിപ്പ് അയക്കുന്നു',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'userrightsnotifysubject' => '$1 वरील गट सदस्यत्व बदल',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'userrightsnotifysubject' => "Tibdil fil-grupp ta' sħubija fuq $1",
	'userrightsnotif-desc' => "Tibgħat nota permezz ta' posta elettronika biex tinforma lill-utenti fuq tibdil tad-drittjiet",
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'userrightsnotifysubject' => 'Endring av gruppemedlemskap på $1',
	'userrightsnotifybody' => 'Hei $1.

Du informeres herved at dine gruppemedlemskap på $2 ble endret av $3 $4.

Lagt til: $5
Fjernet: $6

Hilsen

$2',
	'userrightsnotif-desc' => 'Sender e-postmelding til brukere ved rettighetsendringer',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Tvdm
 */
$messages['nl'] = array(
	'userrightsnotifysubject' => 'Groepslidmaatschap is gewijzigd op $1',
	'userrightsnotifybody' => 'Hallo $1

Dit is om u te informeren dat uw groepslidmaatschap op $2 is gewijzigd door $3 op $4.

Toegevoegd: $5
Verwijderd: $6

Vriendelijke groeten,

$2',
	'userrightsnotif-desc' => 'Verstuurt e-mails om wijzingen in de gebruikersrechten te melden aan gebruikers',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 */
$messages['nn'] = array(
	'userrightsnotifysubject' => 'Endring av gruppemedlemskap på $1',
	'userrightsnotifybody' => 'Hei, $1.

Du vert hermed informert at gruppemedlemskapa dine på $2 vart endra av $3 $4.

Lagt til: $5
Fjerna: $6

Helsing
$2',
	'userrightsnotif-desc' => 'Sender e-postmelding til brukarar ved endring av rettane deira',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'userrightsnotifysubject' => 'Cambiament d’apartenéncia a de gropes d’utilizaires sus $1',
	'userrightsnotifybody' => "Bonjorn $1, Ai l'onor de vos informar que vòstra apartenéncia als gropes d'utilizaires sus $2 es estada modificada per $3 lo $4. Apondut : $5 Levat : $6 Coralament, $2",
	'userrightsnotif-desc' => 'Manda una notificacion, per corrièr electronic, als utilizaires concernits al moment de la modificacion de lors dreches',
);

/** Polish (Polski)
 * @author Leinad
 * @author Masti
 */
$messages['pl'] = array(
	'userrightsnotifysubject' => 'Zmiana członkostwa w grupach w $1',
	'userrightsnotifybody' => 'Witaj $1,

informuję, że Twoje członkostwo w grupach w $2 zostało zmienione przez $4 o $3.

Dodano: $5
Usunięto: $6


Pozdrowienia

$2',
	'userrightsnotif-desc' => 'Wyślij informację do użytkowników o zmianach uprawnień',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'userrightsnotifysubject' => "Cambi dl'apartenensa dël grup an dzora a $1",
	'userrightsnotifybody' => "Cerea $1.

Sòn sì a l'é për anformete che ël tò grup d'apartenensa an dzora a $2 a l'é stàit cambià da $3 a $4.

Giontà: $5
Gavà: $6

Tante bele còse,

$2",
	'userrightsnotif-desc' => "A manda na e-mail ëd notìfica a j'utent con un cambiament ëd drit",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'userrightsnotifysubject' => 'په $1 باندې د يوې ډلې د غړيتوب بدلون',
	'userrightsnotifybody' => '$1 ګرانه/ګرانې سلامونه.

تاسې ته خبر درکول کېږي چې په $2 باندې ستاسې د ډلې غړيتوب، د $3 لخوا په $4 بدلون موندلی.

ورګډ شوي: $5
بېل شوي: $6

په ډېر درنښت،

$2',
	'userrightsnotif-desc' => 'د کارنانو په رښتو کې د بدلون سره سم کارنانو ته خبرونکی برېښليک ورلېږل کېږي',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Waldir
 */
$messages['pt'] = array(
	'userrightsnotifysubject' => 'Mudança de estatuto de utilizador em $1',
	'userrightsnotifybody' => 'Olá $1

Serve esta mensagem para informar que os seus grupos de utilizador foram modificados na $2, por $3 às $4.

Adicionados: $5
Removidos: $6

Os melhores cumprimentos,

$2',
	'userrightsnotif-desc' => 'Notifica por correio electrónico os utilizadores cujos privilégios forem alterados',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'userrightsnotifysubject' => 'Mudança de estatuto de usuário em $1',
	'userrightsnotifybody' => 'Olá $1

Esta mensagem lhe foi enviada para informar que os seu estatuto de usuário foi modificado em $2, de $3 para $4.

Adicionado: $5
Removido: $6

Os melhores cumprimentos,

$2',
	'userrightsnotif-desc' => 'Enviar notificação por email a usuários que sofreram alteração de privilégios',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'userrightsnotif-desc' => 'Trimite notificare prin e-mail utilizatorilor când li se modifică permisiunile',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'userrightsnotifysubject' => "Le membre d'u gruppe cangiane sus a $1",
	'userrightsnotifybody' => "Cià $1.

Queste jè pe te 'mbormà ca le membre d'u gruppe sus a $2 onne state cangiate da $3 a le $4.

Aggiunde: $5
Luate: $6

Fattà calà,

$2",
	'userrightsnotif-desc' => "Manne 'na e-mail de notifiche a l'utinde de sus ca onne cangiate le deritte",
);

/** Russian (Русский)
 * @author Flrn
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'userrightsnotifysubject' => 'Членство в группах было изменено на «$1»',
	'userrightsnotifybody' => 'Здравствуйте, $1.

Это сообщение информирует вас о том, что ваше членство в группах было изменено $3 в $4.

Добавлено: $5
Удалено: $6

С наилучшими пожеланиями,

$2',
	'userrightsnotif-desc' => 'Отправляет уведомления участникам при изменении прав',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'userrightsnotifysubject' => '$1 මත කණ්ඩායම් සාමාජිකත්වය මාරු කිරීම',
	'userrightsnotifybody' => 'හෙලෝ $1.

මෙමඟින් $2 මත ඔබේ කණ්ඩායම් සාමාජිකත්වය $3 විසින් $4ට මාරු කර ඇති බව දැනුම් දෙමි.

එකතු කළා: $5
ඉවත් කළා: $6

සුභ පැතුම් සමඟ,

$2',
	'userrightsnotif-desc' => 'අයිතීන් වෙනස්කිරීම් මත සිටින පරිශීලකයින්ට ඊ-මේල් නිවේදනයක් යවයි.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'userrightsnotifysubject' => 'Zmena členstva $1 v skupine',
	'userrightsnotifybody' => 'Dobrý deň, $1

Týmto vás informujeme, že vaše členstvo v skupine $2 bolo zmenené z $3 na $4.

Pridané: $5
Odstránené: $6

S pozdravom,

$2',
	'userrightsnotif-desc' => 'Posiela upozornenia na emaily používateľom pri zmene oprávnení',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'userrightsnotifysubject' => 'Annerenge fon ju Gruppentouheeregaid fon dän $1',
	'userrightsnotifybody' => 'Moin $1

Dit is ne Information, dät dien Gruppentouheeregaid fon $2 truch $3 an n $4 annerd wuude.

Bietouföiged: $5
Wächhoald: $6\\

Mäd früntelke Gröitnis,

$2',
	'userrightsnotif-desc' => 'Soant E-Mail-Beskeed uur Gjuchte-Annerengen an dän Benutser',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'userrightsnotifysubject' => 'Kaanggotaan Grup robah dina $1',
	'userrightsnotifybody' => ':Bagéa, $1

:Kaanggotaan grup anjeun di $2 geus dirobah ku $3 $4.

:Diasupkeun: $5
:Dikaluarkeun: $6

:Baktos,

:$2',
	'userrightsnotif-desc' => 'Kirim surélék ka pamaké ngeunaan parobahan hak ieu.',
);

/** Swedish (Svenska)
 * @author Lejonel
 */
$messages['sv'] = array(
	'userrightsnotifysubject' => 'Ändring av gruppmedlemskap på $1',
	'userrightsnotifybody' => 'Hej $1,

Det här är ett meddelande om att ditt medlemskap i användargrupper på $2 har ändrats av $3 den $4.

Lade till: $5
Tog bort: $6

Hälsningar 

$2',
	'userrightsnotif-desc' => 'Skickar e-postmeddelanden till användare när deras behörigheter ändras',
);

/** Silesian (Ślůnski)
 * @author Lajsikonik
 */
$messages['szl'] = array(
	'userrightsnotifysubject' => 'Zmjana człůnkostwa we grupach we $1',
	'userrightsnotifybody' => 'Witej $1,

informuja, co Twoje człůnkostwo we grupach we $2 zostało zmjyńůne bez $4 uo $3.

Dodano: $5
Wyćepano: $6


Pozdrowjyńa

$2',
	'userrightsnotif-desc' => 'Wyślij informacyjo e-brifym ku użytkowńikům uo půmjyńańu uprowńyń',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'userrightsnotifysubject' => '$1 లో సమూహ సభ్యత్వ మార్పు',
	'userrightsnotifybody' => 'హలో $1,

$2 లోని మీ సభ్యత్వాలను $3 $4కి మార్చారని తెలియజేస్తున్నాం.

చేర్చినవి: $5
తొలగించినవి: $6

శుభాశీస్సులతో,

$2',
	'userrightsnotif-desc' => 'హక్కుల మార్పుల గురించి వాడుకర్లకు ఈ-మెయిలు గమనింపులు పంపిస్తుంది',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'userrightsnotifybody' => 'Hello $1.

This is to inform you that your group memberships on $2 were changed by $3 at $4.

Added: $5
Removed: $6

With regards,

$2
-----
Салом $1.

Ба иттилоъи шумо мерасонем, ки узвияти шумо дар $2 тавассути $3 дар $4 тағйир дода шуд.

Илова шуд: $5
Пок шуд: $6

Бо салом,

$2',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'userrightsnotifybody' => "Hello $1.

This is to inform you that your group memberships on $2 were changed by $3 at $4.

Added: $5
Removed: $6

With regards,

$2
-----
Salom $1.

Ba ittilo'i şumo merasonem, ki uzvijati şumo dar $2 tavassuti $3 dar $4 taƣjir doda şud.

Ilova şud: $5
Pok şud: $6

Bo salom,

$2",
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'userrightsnotifysubject' => 'Pagbabago sa kasapiang pampangkat noong $1',
	'userrightsnotifybody' => 'Kumusta ka $1.

Isa itong pagpapabatid sa iyo na ang mga kasapiang pangkapangkatan mo ay binago ni $3 noong $4.

Idinagdag: $5
Tinanggal: $6

Gumagalang,

$2',
	'userrightsnotif-desc' => 'Nagpapadala ng e-liham patungo sa mga tagagamit na may dalang pabatid kapag naganap ang mga pagbabago sa karapatan',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'userrightsnotifysubject' => '$1 üzerinde grup üyeliği değişikliği',
	'userrightsnotifybody' => 'Hoşgeldiniz $1 

This is to inform you that your group memberships on $2 were changed by $3 at $4.

Eklendi: $5

Taşındı: $6

With regards,

$2',
	'userrightsnotif-desc' => 'Hak değişiklikleri sonrasında kullanıcılara e-posta bildirimi gönderir',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'userrightsnotifysubject' => 'Членство в групах змінено на $1',
	'userrightsnotifybody' => 'Вітаю, $1.

Повідомляю вам, що ваше членство в групах проекту $2 було змінено $3 о $4.

Додано: $5
Вилучено: $6

З повагою,

$2',
	'userrightsnotif-desc' => 'Надсилає користувачам повідомлення електронною поштою в разі зміни прав',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'userrightsnotifysubject' => 'Canbiamento del grupo de apartenensa in $1',
	'userrightsnotifybody' => 'Ciao $1.

Te informemo che el to grupo de apartenensa su $2 el xe stà canbià da $3 el $4

Xontà: $5
Cavà: $6

Con tanti saluti,

$2',
	'userrightsnotif-desc' => 'Manda na e-mail de notifica co vien canbià i diriti del grupo utente de un utente',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'userrightsnotifysubject' => 'Nhóm thành viên đã thay đổi vào $1',
	'userrightsnotifybody' => 'Xin chào $1

Xin thông báo với bạn rằng nhóm thành viên của bạn tại $2 đã được $3 thay đổi vào $4.

Thêm: $5
Bớt: $6

Trân trọng,

$2',
	'userrightsnotif-desc' => 'Gửi thông báo thư điện tử cho thành viên về các thay đổi về quyền truy cập',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'userrightsnotifysubject' => 'Votükam grupalimanama in $1',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Jimmy xu wrk
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'userrightsnotifysubject' => '$1上的用户群组资格改变',
	'userrightsnotifybody' => '$1您好，

这个消息通知您您在$2的用户权限已在$4被$3更改。

添加了：$5
移除了：$6

此致，

$2',
	'userrightsnotif-desc' => '在权限改变时给用户发送电子邮件通知',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'userrightsnotifysubject' => '$1 上的用戶群組資格改變',
	'userrightsnotifybody' => '$1 您好，

這個消息通知您您在 $2 的用戶權限已在 $4 被 $3 更改。

增加了：$5
移除了：$6

此致，

$2',
	'userrightsnotif-desc' => '在權限改變時給使用者發送電子郵件通知',
);

