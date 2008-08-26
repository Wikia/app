<?php
/**
 * Internationalisation file for the Nuke extension
 * @addtogroup Extensions
 * @author Brion Vibber
 */

$messages = array();

/** English
 * @author Brion Vibber
 */
$messages['en'] = array(
	'nuke'               => 'Mass delete',
	'nuke-desc'          => 'Gives sysops the ability to [[Special:Nuke|mass delete]] pages',
	'nuke-nopages'       => "No new pages by [[Special:Contributions/$1|$1]] in recent changes.",
	'nuke-list'          => "The following pages were recently created by [[Special:Contributions/$1|$1]];
put in a comment and hit the button to delete them.",
	'nuke-defaultreason' => "Mass removal of pages added by $1",
	'nuke-tools'         => 'This tool allows for mass deletions of pages recently added by a given user or IP.
Input the username or IP to get a list of pages to delete:',
	'nuke-submit-user'   => 'Go',
	'nuke-submit-delete' => 'Delete selected',
	'right-nuke'         => 'Mass delete pages',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'nuke-submit-user' => 'Fano',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'nuke-submit-user' => 'Gaan',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'nuke'               => 'Borrato masibo',
	'nuke-desc'          => 'Da á os almenistradors a capazidat de fer [[Special:Nuke|borratos masibos]] de pachinas',
	'nuke-nopages'       => 'No bi ha garra pachina nueba feita por [[Special:Contributions/$1|$1]] entre os zaguers cambeos.',
	'nuke-list'          => 'A siguients pachinas fuoron creyatas por [[Special:Contributions/$1|$1]]; escriba un comentario y punche o botón ta borrar-los.',
	'nuke-defaultreason' => "Borrato masibo d'as pachinas adibitas por $1",
	'nuke-tools'         => "Ista ferramienta fa posible de fer borratos masibos de pachinas adibitas en zaguerías por un usuario u adreza IP datos. Escriba o nombre d'usuario u l'adreza IP ta obtener una lista de pachinas ta borrar:",
	'nuke-submit-user'   => 'Ir-ie',
	'nuke-submit-delete' => 'Borrar as trigatas',
	'right-nuke'         => 'Borrar pachinas masibament',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'nuke'               => 'حذف كمي',
	'nuke-desc'          => 'يعطي مدراء النظام القدرة على [[Special:Nuke|الحذف الكمي]] للصفحات',
	'nuke-nopages'       => 'لا صفحات جديدة بواسطة [[Special:Contributions/$1|$1]] في أحدث التغييرات.',
	'nuke-list'          => 'الصفحات التالية تم إنشاؤها حديثا بواسطة [[Special:Contributions/$1|$1]]؛ ضع تعليقا واضغط الزر لحذفهم.',
	'nuke-defaultreason' => 'إزالة كمية للصفحات المضافة بواسطة $1',
	'nuke-tools'         => 'هذه الأداة تسمح بالحذف الضخم للصفحات المضافة حديثا بواسطة مستخدم أو أيبي معطى. أدخل اسم المستخدم أو الأيبي لعرض قائمة بالصفحات للحذف:',
	'nuke-submit-user'   => 'اذهب',
	'nuke-submit-delete' => 'احذف المختار',
	'right-nuke'         => 'حذف الصفحات كميا',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'nuke'               => 'Borráu masivu',
	'nuke-nopages'       => 'Nun hai páxines nueves de [[Special:Contributions/$1|$1]] nos cambeos recientes.',
	'nuke-list'          => 'Les páxines siguientes foron creaes recién por [[Special:Contributions/$1|$1]]; escribi un comentariu y calca nel botón pa borrales.',
	'nuke-defaultreason' => 'Borráu masivu de páxines añadíes por $1',
	'nuke-tools'         => "Esta ferramienta permite borraos masivo de páxines añadíes recién por un usariu o una IP determinada. Escribi'l nome d'usuariu o la IP pa obtener una llista de páxines pa borrar:",
	'nuke-submit-user'   => 'Dir',
	'nuke-submit-delete' => 'Borrar seleicionaes',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'nuke'               => 'حذف جمعی',
	'nuke-desc'          => 'مدیران سیستمء ای توانایی دنت تا صفحات  [[Special:Nuke|حذف جمعی]]',
	'nuke-nopages'       => 'هچ نوکین صفحه په وسیله  [[Special:Contributions/$1|$1]] ته نوکین تغییرات.',
	'nuke-defaultreason' => 'حذف جمعی صفحات اضافه بوتت په وسیله $1',
	'nuke-submit-user'   => 'برو',
	'nuke-submit-delete' => 'انتخاب بوتگین حذف',
	'right-nuke'         => 'حذف جمعی صفحات',
);

/** Bulgarian (Български)
 * @author Spiritia
 * @author DCLXVI
 * @author Borislav
 */
$messages['bg'] = array(
	'nuke'               => 'Масово изтриване',
	'nuke-desc'          => 'Предоставя на администраторите възможност за [[Special:Nuke|масово изтриване]] на страници',
	'nuke-nopages'       => 'Сред последните промени не съществуват нови страници, създадени от [[Special:Contributions/$1|$1]].',
	'nuke-list'          => 'Следните страници са били наскоро създадени от [[Special:Contributions/$1|$1]]. Напишете коментар и щракнете бутона, за да ги изтриете.',
	'nuke-defaultreason' => 'Масово изтриване на страници, създадени от $1',
	'nuke-tools'         => 'Този инструмент позволява масовото изтриване на страници, създадени от даден регистриран или анонимен потребител. Въведете потребителско име или IP, за да получите списъка от страници за изтриване:',
	'nuke-submit-user'   => 'Изпълняване',
	'nuke-submit-delete' => 'Изтриване на избраните',
	'right-nuke'         => 'масово изтриване на страници',
);

/** Bengali (বাংলা)
 * @author Zaheen
 * @author Bellayet
 */
$messages['bn'] = array(
	'nuke'               => 'গণ মুছে ফেলা',
	'nuke-desc'          => 'প্রশাসকদের পাতাগুলি [[Special:Nuke|গণহারে মুছে ফেলার]] ক্ষমতা দেয়',
	'nuke-nopages'       => 'সাম্প্রতিক পরিবর্তনগুলিতে [[Special:Contributions/$1|$1]]-এর তৈরি কোন নতুন পাতা নেই।',
	'nuke-list'          => '[[Special:Contributions/$1|$1]] সাম্প্রতিক কালে নিচের পাতাগুলি সৃষ্টি করেছেন; একটি মন্তব্য দিন এবং বোতাম চেপে এগুলি মুছে ফেলুন।',
	'nuke-defaultreason' => '$1-এর যোগ করা পাতাগুলির গণ মুছে-ফেলা',
	'nuke-tools'         => 'এই সরঞ্জামটি ব্যবহার করে আপনি একটি প্রদত্ত ব্যবহারকারীর বা আইপি ঠিকানার যোগ করা পাতাগুলি গণ আকারে মুছে ফেলতে পারবেন। পাতাগুলির তালিকা পেতে ব্যবহারকারী নাম বা আইপি ঠিকানাটি ইনপুট করুন:',
	'nuke-submit-user'   => 'যাও',
	'nuke-submit-delete' => 'নির্বাচিত গুলো মুছে ফেলো',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'nuke'               => "Diverkañ a-vloc'h",
	'nuke-nopages'       => "Pajenn nevez ebet bet krouet gant [[Special:Contributions/$1|$1]] er c'hemmoù diwezhañ.",
	'nuke-submit-user'   => 'Mont',
	'nuke-submit-delete' => 'Diverkañ diuzet',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'nuke'               => 'Eliminació massiva',
	'nuke-desc'          => "Dóna als administradors l'habilitat d'[[Special:Nuke|esborrar pàgines massivament]]",
	'nuke-nopages'       => 'No hi ha pàgines noves de [[Special:Contributions/$1|$1]] als canvis recents.',
	'nuke-defaultreason' => 'Esborrat massiu de pàgines creades per $1',
	'nuke-submit-user'   => 'Vés-hi',
	'nuke-submit-delete' => 'Esborra la selecció',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'nuke-submit-user' => 'Hånao',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Danny B.
 */
$messages['cs'] = array(
	'nuke'               => 'Hromadné mazání',
	'nuke-desc'          => 'Dává správcům možnost [[Special:Nuke|hromadného mazání]] stránek',
	'nuke-nopages'       => 'V posledních změnách nejsou žádné nové stránky od uživatele [[Special:Contributions/$1|$1]].',
	'nuke-list'          => 'Následující stránky nedávno vytvořil uživatel [[Special:Contributions/$1|$1]]; vyplňte komentář a všechny smažte kliknutím na tlačítko.',
	'nuke-defaultreason' => 'Hromadné odstranění stránek, které vytvořil $1',
	'nuke-tools'         => 'Tento nástroj umožňuje hromadné smazání stránek nedávno vytvořených zadaným uživatelem na IP adresou. Zadejte uživatelské jméno nebo IP adresu, jejichž seznam stránek ke smazání chcete zobrazit:',
	'nuke-submit-user'   => 'Provést',
	'nuke-submit-delete' => 'Smazat vybrané',
	'right-nuke'         => 'Hromadné mazání stránek',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'nuke'               => 'Massenlöschung',
	'nuke-desc'          => 'Ermöglicht Administratoren die [[Special:Nuke|Massenlöschung]] von Seiten',
	'nuke-nopages'       => 'Es gibt in den Letzten Änderungen keine neuen Seiten von [[Special:Contributions/$1|$1]].',
	'nuke-list'          => 'Die folgenden Seiten wurden von [[Special:Contributions/$1|$1]] erzeugt;
gib einen Kommentar ein und drücke auf den Löschknopf.',
	'nuke-defaultreason' => 'Massenlöschung von Seiten, die von „$1“ angelegt wurden',
	'nuke-tools'         => 'Dieses Werkzeug ermöglicht die Massenlöschung von Seiten, die von einer IP-Adresse oder einem Benutzer angelegt wurden. Gib die IP-Adresse/den Benutzernamen ein, um eine Liste zu erhalten:',
	'nuke-submit-user'   => 'Hole Liste',
	'nuke-submit-delete' => 'Löschen',
	'right-nuke'         => 'Massenlöschung von Seiten',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Raimond Spekking
 */
$messages['de-formal'] = array(
	'nuke-list'  => 'Die folgenden Seiten wurden von [[{{#special:Contributions}}/$1|$1]] erzeugt; geben Sie einen Kommentar ein und drücken Sie auf den Löschknopf.',
	'nuke-tools' => 'Dieses Werkzeug ermöglicht die Massenlöschung von Seiten, die von einer IP-Adresse oder einem Benutzer angelegt wurden. Geben Sie die IP-Adresse/den Benutzernamen ein, um eine Liste zu erhalten:',
);

/** Ewe (Eʋegbe)
 * @author M.M.S.
 */
$messages['ee'] = array(
	'nuke-submit-user' => 'Yi',
);

/** Greek (Ελληνικά)
 * @author ZaDiak
 */
$messages['el'] = array(
	'nuke-submit-user' => 'Πήγαινε',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'nuke'               => 'Amasforigi',
	'nuke-desc'          => 'Rajtigas al administrantoj la kapablon [[Special:Nuke|amasforigi]] paĝojn',
	'nuke-nopages'       => 'Neniuj novaj paĝoj de [[Special:Contributions/$1|$1]] en lastaj ŝanĝoj.',
	'nuke-list'          => 'La jenaj paĝoj estis lastatempe kreitaj de [[Special:Contributions/$1|$1]];
aldonu komenton kaj klaku la butonon forigi ilin.',
	'nuke-defaultreason' => 'Amasforigo de paĝoj aldonita de $1',
	'nuke-tools'         => 'Ĉi tiu ilo ebligas amasforigojn de paĝoj lastatempe aldonitaj de aparta uzanto aŭ IP-adreso.
Enigu la salutnomon aŭ IP-adreson por akiri liston de paĝoj forigi:',
	'nuke-submit-user'   => 'Ek!',
	'nuke-submit-delete' => 'Forigi elekton',
	'right-nuke'         => 'Amasforigi paĝojn',
);

/** Spanish (Español)
 * @author Jatrobat
 */
$messages['es'] = array(
	'nuke-submit-user' => 'Ir',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'nuke'               => 'حذف دسته‌جمعی',
	'nuke-desc'          => 'به مدیران امکان [[Special:Nuke|حذف دسته‌جمعی]] صفحه‌ها را می‌دهد',
	'nuke-nopages'       => 'صفحه‌ٔ جدیدی از [[Special:Contributions/$1|$1]] در تغییرات اخیر وجود ندارد.',
	'nuke-list'          => 'صفحه‌های زیر به تازگی توسط [[Special:Contributions/$1|$1]] ایجاد شده‌اند؛ توضیحی ارائه کنید و دکمه را بزنید تا این صحفه‌ها حذف شوند.',
	'nuke-defaultreason' => 'حذف دسته‌جمعی صفحه‌هایی که توسط $1 ایجاد شده‌اند',
	'nuke-tools'         => 'این ابزار امکان حذف دسته‌جمعی صفحه‌هایی که به تازگی توسط یک کاربر یا نشانی اینترنتی اضافه شده‌اند را فراهم می‌کند. نام کاربری یا نشانی اینترنتی موردنظر را وارد کنید تا فهرست صفحه‌هایی که حذف می‌شوند را ببینید:',
	'nuke-submit-user'   => 'برو',
	'nuke-submit-delete' => 'حذف موارد انتخاب شده',
	'right-nuke'         => 'حذف دسته‌جمعی صفحه‌ها',
);

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'nuke'               => 'Massapoistaminen',
	'nuke-desc'          => 'Mahdollistaa ylläpitäjille sivujen [[Special:Nuke|massapoistamisen]].',
	'nuke-nopages'       => 'Ei käyttäjän [[Special:Contributions/$1|$1]] lisäämiä uusia sivuja tuoreissa muutoksissa.',
	'nuke-list'          => 'Käyttäjä [[Special:Contributions/$1|$1]] on äskettäin luonut seuraavat sivut.',
	'nuke-defaultreason' => 'Käyttäjän $1 lisäämien sivujen massapoistaminen',
	'nuke-tools'         => 'Tämä työkalu mahdollistaa äskettäin lisättyjen sivujen massapoistamisen käyttäjänimen tai IP:n perusteella. Kirjoita käyttäjänimi tai IP, niin saat listan poistettavista sivuista:',
	'nuke-submit-user'   => 'Siirry',
	'nuke-submit-delete' => 'Poista valitut',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'nuke'               => 'Suppression en masse',
	'nuke-desc'          => 'Donne la possiblité aux administrateurs de [[Special:Nuke|supprimer en masse]] des pages.',
	'nuke-nopages'       => 'Aucune nouvelle page créée par [[Special:Contributions/$1|$1]] dans la liste des changements récents.',
	'nuke-list'          => 'Les pages suivantes ont été créées récemment par [[Special:Contributions/$1|$1]]; Indiquer un commentaire et cliquer sur le bouton pour les supprimer.',
	'nuke-defaultreason' => 'Suppression en masse des pages ajoutées par $1',
	'nuke-tools'         => 'Cet outil autorise les suppressions en masse des pages ajoutées récemment par un utilisateur enregistré ou par une adresse IP. Indiquer l’adresse IP afin d’obtenir la liste des pages à supprimer :',
	'nuke-submit-user'   => 'Valider',
	'nuke-submit-delete' => 'Suppression sélectionnée',
	'right-nuke'         => 'Supprimer des pages en masse',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'nuke'               => 'Suprèssion en massa',
	'nuke-desc'          => 'Balye la possibilitât ux administrators de [[Special:Nuke|suprimar en massa]] des pâges.',
	'nuke-nopages'       => 'Niona novèla pâge crèâ per [[Special:Contributions/$1|$1]] dens la lista des dèrriérs changements.',
	'nuke-list'          => 'Les pâges siuventes ont étâ crèâs dèrriérement per [[Special:Contributions/$1|$1]] ; endicâd un comentèro et pués clicâd sur lo boton por les suprimar.',
	'nuke-defaultreason' => 'Suprèssion en massa de les pâges apondues per $1',
	'nuke-tools'         => 'Ceti outil ôtorise les suprèssions en massa de les pâges apondues dèrriérement per un utilisator enregistrâ ou per una adrèce IP. Endicâd l’adrèce IP por obtegnir la lista de les pâges a suprimar :',
	'nuke-submit-user'   => 'Validar',
	'nuke-submit-delete' => 'Suprèssion sèlèccionâ',
);

/** Galician (Galego)
 * @author Toliño
 * @author Alma
 * @author SPQRobin
 * @author Xosé
 */
$messages['gl'] = array(
	'nuke'               => 'Eliminar en masa',
	'nuke-desc'          => 'Dá aos administradores a posibilidade de [[Special:Nuke|borrar páxinas]] masivamente',
	'nuke-nopages'       => 'Non hai novas páxinas feitas por [[Special:Contributions/$1|$1]] nos cambios recentes.',
	'nuke-list'          => 'As seguintes páxinas foron recentemente creadas por [[Special:Contributions/$1|$1]]; poña un comentario e prema o botón para borralos.',
	'nuke-defaultreason' => 'Eliminación en masa das páxinas engadidas por $1',
	'nuke-tools'         => 'Esta ferramenta permite supresións masivas das páxinas engadidas recentemente por un determinado usuario ou enderezo IP. Introduza o nome do usuario ou enderezo IP para obter unha listaxe das páxinas para borrar:',
	'nuke-submit-user'   => 'Adiante',
	'nuke-submit-delete' => 'Eliminar o seleccionado',
	'right-nuke'         => 'Borrar páxinas masivamente',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'nuke-submit-user' => 'Gow',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'nuke'               => 'מחיקה מרובה',
	'nuke-desc'          => 'אפשרות למפעילי המערכת לבצע [[Special:Nuke|מחיקה מרובה]] של דפים',
	'nuke-nopages'       => 'אין דפים חדשים שנוצרו על ידי [[Special:Contributions/$1|$1]] in בשינויים האחרונים.',
	'nuke-list'          => 'הדפים הבאים נוצרו לאחרונה על ידי [[Special:Contributions/$1|$1]];
אנא כתבו נימוק למחיקה ולחצו על הכפתור כדי למחוק אותם.',
	'nuke-defaultreason' => 'הסרה מרובה של דפים שנוספו על ידי $1',
	'nuke-tools'         => 'כלי זה מאפשר מחיקות מרובות של דפים שנוספו לאחרונה על ידי משתמש או כתובת IP מסוימים.
כתבו את שם המשתמש או כתובת ה־IP כדי לקבל את רשימת הדפים למחיקה:',
	'nuke-submit-user'   => 'הצגה',
	'nuke-submit-delete' => 'מחיקת הדפים שנבחרו',
	'right-nuke'         => 'מחיקה מרובה של דפים',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'nuke'               => 'एकसाथ बहुत सारे पन्ने हटायें',
	'nuke-desc'          => 'प्रबंधकोंको एकसाथ [[Special:Nuke|बहुत सारे पन्ने हटानेकी]] अनुमति देता हैं',
	'nuke-nopages'       => 'हाल में हुए बदलावोंमें [[Special:Contributions/$1|$1]] द्वारा नये पन्ने नहीं हैं।',
	'nuke-list'          => 'नीचे दिये हुए पन्ने [[Special:Contributions/$1|$1]] ने हाल में बनायें हैं; टिप्पणी दें और हटाने के लिये बटनपर क्लिक करें।',
	'nuke-defaultreason' => '$1 ने बनाये हुए पन्ने एकसाथ हटायें',
	'nuke-tools'         => 'यह उपकरण किसी सदस्य या IP द्वारा हाल ही में जोड़े गए पृष्ठों को सामूहिक रूप से हटाने में सहायक है।
सदस्यनाम या IP डालकर हटाने वाले पृष्ठों की सूची प्राप्त करें।',
	'nuke-submit-user'   => 'जायें',
	'nuke-submit-delete' => 'चुने हुए हटायें',
	'right-nuke'         => 'बहुतसे पन्ने एकसाथ हटायें',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'nuke-submit-user' => 'Lakat',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 * @author Dnik
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'nuke'               => 'Grupno brisanje',
	'nuke-desc'          => 'Daje administratorima mogućnost [[Special:Nuke|masovnog brisanja]] stranica',
	'nuke-nopages'       => 'Nema novih stranica suradnika [[Special:Contributions/$1|$1]] među nedavnim promjenama.',
	'nuke-list'          => 'Slijedeće stranice je stvorio suradnik [[Special:Contributions/$1|$1]]; napišite zaključak i kliknite gumb za njihovo brisanje.',
	'nuke-defaultreason' => 'Grupno brisanje stranica suradnika $1',
	'nuke-tools'         => 'Ova ekstenzija omogućava grupno brisanje stranica (članaka) nekog prijavljenog ili neprijavljenog suradnika. Upišite ime ili IP adresu za dobivanje popisa stranica koje je moguće obrisati:',
	'nuke-submit-user'   => 'Kreni',
	'nuke-submit-delete' => 'Obriši označeno',
	'right-nuke'         => 'Masovno brisanje stranica',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'nuke'               => 'Masowe wušmórnjenje',
	'nuke-desc'          => 'Zmóžnja administratoram [[Special:Nuke|masowe wušmórnjenje]] stronow',
	'nuke-nopages'       => 'W poslednich změnach njejsu nowe strony z [[Special:Contributions/$1|$1]].',
	'nuke-list'          => 'Slědowace strony buchu runje přez [[Special:Contributions/$1|$1]] wutworjene; zapodaj komentar a klikń na tłóčatko wušmórnjenja.',
	'nuke-defaultreason' => 'Masowe wušmórnjenje stronow, kotrež buchu wot $1 wutworjene',
	'nuke-tools'         => 'Tutón grat zmóžnja masowe wušmórnjenje stronow, kotrež buchu wot IP-adresy abo wužiwarja wutworjene. Zapodaj IP-adresu resp. wužiwarske mjeno, zo by lisćinu dóstał:',
	'nuke-submit-user'   => 'W porjadku',
	'nuke-submit-delete' => 'Wušmórnyć',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author KossuthRad
 * @author Dorgan
 */
$messages['hu'] = array(
	'nuke'               => 'Halmozott törlés',
	'nuke-desc'          => 'Lehetővé teszi az adminisztrátorok számára a lapok [[Special:Nuke|tömeges törlését]].',
	'nuke-nopages'       => 'Nincsenek új oldalak [[Special:Contributions/$1|$1]] az aktuális események között.',
	'nuke-list'          => 'Az alábbi lapokat nem rég készítette [[Special:Contributions/$1|$1]]; adj meg egy indoklást, és kattints a gombra a törlésükhöz.',
	'nuke-defaultreason' => '$1 által készített lapok tömeges eltávolítása',
	'nuke-tools'         => 'Ez az eszköz lehetővé teszi egy adott felhasználó vagy IP által nem rég készített lapok tömeges törlését. Add meg a felhasználónevet vagy az IP-címet, hogy lekérd a törlendő lapok listáját:',
	'nuke-submit-user'   => 'Menj',
	'nuke-submit-delete' => 'Kijelöltek törlése',
	'right-nuke'         => 'oldalak tömeges törlése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'nuke'               => 'Deletion in massa',
	'nuke-desc'          => 'Da le capabilitate al administratores de [[Special:Nuke|deler paginas in massa]]',
	'nuke-nopages'       => 'Nulle nove paginas per [[Special:Contributions/$1|$1]] trovate in le modificationes recente.',
	'nuke-list'          => 'Le sequente paginas esseva recentemente create per [[Special:Contributions/$1|$1]];
entra un commento e clicca le button pro deler los.',
	'nuke-defaultreason' => 'Deletion in massa de paginas addite per $1',
	'nuke-tools'         => 'Iste instrumento permitte le deletion in massa de paginas recentemente addite per un usator o IP specific.
Entra le nomine de usator o adresse IP pro obtener un lista de paginas a deler:',
	'nuke-submit-user'   => 'Ir',
	'nuke-submit-delete' => 'Deler seligites',
	'right-nuke'         => 'Deler paginas in massa',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'nuke'               => 'Penghapusan massal',
	'nuke-desc'          => 'Memberikan kemampuan bagi pengurus untuk [[Special:Nuke|menghapus halaman secara massal]]',
	'nuke-nopages'       => 'Tak ditemukan halaman baru dari [[Special:Contributions/$1|$1]] di perubahan terbaru.',
	'nuke-list'          => 'Halaman berikut baru saja dibuat oleh [[Special:Contributions/$1|$1]]; masukkan suatu komentar dan tekan tombol untuk menghapus halaman-halaman tersebut.',
	'nuke-defaultreason' => 'Penghapusan massal halaman-halaman yang dibuat oleh $1',
	'nuke-tools'         => 'Perkakas ini memungkinkan penghapusan massal halaman-halaman yang baru saja dibuat oleh seorang pengguna atau IP. Masukkan nama pengguna atau IP untuk mendapat daftar halaman yang dapat dihapus:',
	'nuke-submit-user'   => 'Cari',
	'nuke-submit-delete' => 'Hapus yang terpilih',
	'right-nuke'         => 'Penghapusan masal',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'nuke-submit-user' => 'Irar',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'nuke-submit-user' => 'Áfram',
);

/** Italian (Italiano)
 * @author .anaconda
 * @author BrokenArrow
 * @author Darth Kule
 * @author Siebrand
 */
$messages['it'] = array(
	'nuke'               => 'Cancellazione di massa',
	'nuke-desc'          => 'Consente agli amministratori la [[Special:Nuke|cancellazione in massa]] delle pagine',
	'nuke-nopages'       => 'Non sono state trovate nuove pagine create da [[Special:Contributions/$1|$1]] tra le modifiche recenti.',
	'nuke-list'          => 'Le seguenti pagine sono state create di recente da [[Special:Contributions/$1|$1]]; inserisci un commento e conferma la cancellazione.',
	'nuke-defaultreason' => 'Cancellazione di massa delle pagine create da $1',
	'nuke-tools'         => "Questo strumento permette la cancellazione in massa delle pagina create di recente da un determinato utente o IP. Inserisci il nome utente o l'IP per la lista delle pagine da cancellare:",
	'nuke-submit-user'   => 'Vai',
	'nuke-submit-delete' => 'Cancella la selezione',
	'right-nuke'         => 'Cancella pagine in massa',
);

/** Japanese (日本語)
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'nuke'               => 'まとめて削除',
	'nuke-desc'          => '{{int:group-sysop}}に[[Special:Nuke|まとめて削除]]ページを提供する',
	'nuke-nopages'       => '[[Special:Contributions/$1|$1]] が最近更新したページはありません。',
	'nuke-list'          => '以下は、[[Special:Contributions/$1|$1]] によって最近作成されたページの一覧です。要約欄へ記入しボタンを押すと、一気に消えて無くなります。',
	'nuke-defaultreason' => '$1 によって加えられたページを一括して削除',
	'nuke-tools'         => 'このツールを使うと、指定した利用者またはIPから最近追加されたページを、まとめて削除することができます。削除対象ページ一覧を取得する利用者名またはIPアドレスを入力してください:',
	'nuke-submit-user'   => '一覧取得',
	'nuke-submit-delete' => '選択されたページを削除',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'nuke'               => 'Massa slettenge',
	'nuke-desc'          => 'Gæv administråtårer æ mågleghed til [[Special:Nuke|massa slette]] pæge',
	'nuke-nopages'       => 'Ekke ny pæge til [[Special:Contributions/$1|$1]] i seneste ændrenger.',
	'nuke-list'          => 'Æ følgende pæger åorte ræsentleg skep via [[Special:Contributions/$1|$1]]; set i en bemærkenge og slå æ knup til sletter hun.',
	'nuke-defaultreason' => 'Massa sletterenge der pæger skep via $1',
	'nuke-tools'         => 'Dette tool gæv men æ mågleghed før massa sletterenge der pæges ræsentleg skeppen via æ gæven bruger æller IP. Input æ brugernavn æller IP til kriige æ liste der pæges til sletterenge:',
	'nuke-submit-user'   => 'Gå',
	'nuke-submit-delete' => 'Sletterenge sælektærn',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'nuke'               => 'Busak massal',
	'nuke-desc'          => 'Mènèhi opsis fungsionalitas kanggo [[Special:Nuke|mbusak massal]] kaca-kaca',
	'nuke-nopages'       => 'Ora ditemokaké kaca anyar saka [[Special:Contributions/$1|$1]] ing owah-owahan pungkasan.',
	'nuke-list'          => 'Kaca-kaca ing ngisor iki lagi baé digawé déning [[Special:Contributions/$1|$1]];
lebokna komentar lan pencèten tombol kanggo mbusak kabèh.',
	'nuke-defaultreason' => 'Pambusakan massal kaca-kaca sing digawé déning $1',
	'nuke-tools'         => 'Piranti iki bisa ngakibataké pambusakan massal kaca-kaca sing lagi waé ditambahaké déning sawijining panganggo utawa alamat IP.
Lebokna jeneng panganggo utawa alamat IP kanggo olèh daftar kaca-kaca sing bisa dibusak:',
	'nuke-submit-user'   => 'Lakokna',
	'nuke-submit-delete' => 'Busaken sing kapilih',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 */
$messages['km'] = array(
	'nuke'               => 'លុបចេញ ជាខ្សែ',
	'nuke-desc'          => 'ផ្តល់លទ្ធភាព អោយ អ្នកថែទាំប្រព័ន្ធ [[Special:Nuke|លុបចេញ ជាខ្សែ]] ទំព័រនានា',
	'nuke-nopages'       => 'គ្មាន ទំព័រថ្មី [[Special:Contributions/$1|$1]] ក្នុង បំលាស់ប្តូរ ថ្មីៗ ។',
	'nuke-list'          => 'ទំព័រទាំងនេះ ទើបតែ ត្រូវបានបង្កើត ដោយ [[Special:Contributions/$1|$1]]; សូម ដាក់ ហេតុផល និង ចុច ប្រអប់ ដើម្បី លុបចេញ ពួកវា ។',
	'nuke-defaultreason' => 'ការដកចេញ ជាខ្សែ នៃ ទំព័រ បានបន្ថែម ដោយ $1',
	'nuke-tools'         => 'ឧបករនេះ អនុញ្ញាតិ លុបចេញ ជាខ្សែ នូវ ទំព័រទើបបានបន្ថែមថ្មីៗ ដោយ អ្នកប្រើប្រាស់បានចុះឈ្មោះ ឬ ដោយ អាស័យដ្ឋាន IP ។ សូម បញ្ចូល ឈ្មោះអ្នកប្រើប្រាស់ ឬ អាស័យដ្ឋាន IP ដើម្បី មាន បញ្ជីទំព័រ សំរាប់លុប ៖',
	'nuke-submit-user'   => 'ទៅ',
	'nuke-submit-delete' => 'លុបចេញ ជំរើសយក',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'nuke-submit-user' => 'Agto',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'nuke-submit-user' => 'Leß holle',
	'right-nuke'       => 'Massich Sigge Fottschmieße',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'nuke'               => 'Masse-Läschung',
	'nuke-desc'          => "Gëtt Administrateuren d'Méiglechkeet fir [[Special:Nuke|vill Säite mateneen ze läschen]]",
	'nuke-nopages'       => 'Et gëtt bei de läschten Ännerunge keng nei Säite vum [[Special:Contributions/$1|$1]].',
	'nuke-list'          => 'Dës Säite goufe viru kuerzem vum [[Special:Contributions/$1|$1]] nei ugeluecht; gitt w.e.g. eng Bemierkung an an dréckt op de Kneppche Läschen.',
	'nuke-defaultreason' => 'Masse-Läschung vu Säiten, déi vum $1 ugefaang goufen',
	'nuke-tools'         => "Dësen tool erlaabt masse-Läschunge vu Säiten déi vun engem Benotzer oder vun enger IP-Adresse ugeluecht goufen. Gitt w.e.g. d'IP-Adress respektiv de Benotzer un fir eng Lescht ze kréien:",
	'nuke-submit-user'   => 'Lass',
	'nuke-submit-delete' => 'Ugewielt läschen',
	'right-nuke'         => 'Vill Säite matenee läschen',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'nuke'               => 'Massaal verwijdere',
	'nuke-desc'          => "Geeft beheerders de mogelijkheid om [[Special:Nuke|massaal pagina's te verwijdere]]",
	'nuke-nopages'       => "Gein nuje pagina's van [[special:Contributions/$1|$1]] in de recente wijziginge.",
	'nuke-list'          => "De onderstaonde pagina's zien recentelijk aangemaakt door [[Special:Contributions/$1|$1]]; voer 'n rede in en klik op de knop om ze te verwijdere/",
	'nuke-defaultreason' => "Massaal verwijdere van pagina's van $1",
	'nuke-tools'         => "Dit hulpmiddel maakt 't meugelik massaal pagina's te wisse die recentelijk zien aangemaakt door 'n gebroeker of IP-adres. Voer de gebroekersnaam of 't IP-adres in veur 'n lijst van te wisse pagina's:",
	'nuke-submit-user'   => 'Gao',
	'nuke-submit-delete' => 'Geslecteerd wisse',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'nuke'               => 'Masinis trynimas',
	'nuke-desc'          => 'Suteikia administratoriams galimybę [[Special:Nuke|masiškai trinti]] puslapius',
	'nuke-nopages'       => 'Nėra naujų puslapių, sukurtų [[Special:Contributions/$1|$1]] naujausiuose keitimuose.',
	'nuke-submit-user'   => 'Išsiųsti',
	'nuke-submit-delete' => 'Ištrinti pasirinktus(ą)',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'nuke'               => 'കൂട്ട മായ്ക്കല്‍',
	'nuke-desc'          => 'സിസോപ്പുകള്‍ക്ക്  താളുകള്‍ [[Special:Nuke|കൂട്ടമായി മായ്ക്കാനുള്ള]] അവകാശം നല്‍കുക',
	'nuke-nopages'       => '[[Special:Contributions/$1|$1]] ഉണ്ടാക്കിയ പുതിയ താളുകളൊന്നും പുതിയ മാറ്റങ്ങളിലില്ല.',
	'nuke-list'          => 'താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന താളുകള്‍ [[Special:Contributions/$1|$1]] സമീപ കാലത്ത് സൃഷ്ടിച്ചവ ആണ്‌;
ഇവ മായ്ക്കുവാന്‍ അഭിപ്രായം രേഖപ്പെടുത്തിയതിനു ശേഷം ബട്ടണ്‍ അമര്‍ത്തുക.',
	'nuke-defaultreason' => '$1 ചേര്‍ത്ത താളുകള്‍ മൊത്തമായി മായ്ക്കുന്നതിനുള്ള സം‌വിധാനം',
	'nuke-tools'         => 'ഏതെങ്കിലും ഒരു ഉപയോക്താവോ ഐപിയോ സമീപകാലത്തു സൃഷ്ടിച്ച താളുകള്‍ കൂട്ടമായി മായ്ക്കാനുള്ള സൗകര്യം ഈ സം‌വിധാനം നല്‍കുന്നു. താളുകള്‍ മായ്കപ്പെടേണ്ട ഉപയോക്തൃനാമമോ ഐപി വിലാസമോ ഇവിടെ കൊടുക്കുക:',
	'nuke-submit-user'   => 'പോകൂ',
	'nuke-submit-delete' => 'തിരഞ്ഞെടുത്തവ മായ്ക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'nuke'               => 'एकदम खूप पाने वगळा',
	'nuke-desc'          => 'प्रबंधकांना एकाचवेळी [[Special:Nuke|अनेक पाने वगळण्याची]] परवानगी देते',
	'nuke-nopages'       => '[[Special:Contributions/$1|$1]] कडून अलीकडील बदलांमध्ये नवीन पाने नाहीत.',
	'nuke-list'          => 'खालील पाने ही [[Special:Contributions/$1|$1]] ने अलिकडे वाढविलेली आहेत; शेरा द्या व वगळण्यासाठी कळीवर टिचकी द्या.',
	'nuke-defaultreason' => '$1 ने नवीन वाढविलेली अनेक पाने एकावेळी वगळा',
	'nuke-tools'         => 'हे उपकरण एखाद्या विशिष्ट सदस्य अथवा अंकपत्त्याद्वारे नवीन तयार करण्यात आलेल्या पानांना एकाचवेळी वगळण्याची संधी देते. सदस्य नाव अथवा अंकपत्ता दिल्यास वगळण्यासाठी पानांची यादी मिळेल:',
	'nuke-submit-user'   => 'जा',
	'nuke-submit-delete' => 'निवडलेले वगळा',
	'right-nuke'         => 'खूप पाने एकत्र वगळा',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'nuke'               => 'Hapus pukal',
	'nuke-desc'          => 'Membolehkan penyelia [[Special:Nuke|menghapuskan laman-laman]] secara pukal',
	'nuke-nopages'       => 'Tiada laman baru oleh [[Special:Contributions/$1|$1]] dalam senarai perubahan terkini.',
	'nuke-list'          => 'Laman-laman berikut dicipta oleh [[Special:Contributions/$1|$1]]; sila masukkan komen anda dan tekan butang untuk menghapuskannya.',
	'nuke-defaultreason' => 'Menghapuskan laman-laman yang ditambah oleh $1 secara pukal',
	'nuke-tools'         => 'Alat ini digunakan untuk menghapuskan laman-laman yang ditambah oleh pengguna atau IP yang dinyatakan secara pukal. Masukkan nama pengguna atau IP untuk mendapatkan senarai laman untuk dihapuskan:',
	'nuke-submit-user'   => 'Pergi',
	'nuke-submit-delete' => 'Hapus',
	'right-nuke'         => 'Menghapuskan laman secara pukal',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'nuke'             => 'Huēyi tlapololiztli',
	'nuke-submit-user' => 'Yāuh',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'nuke'               => 'General-Utmesten',
	'nuke-desc'          => 'Verlöövt Administraters dat [[{{ns:Special}}:Nuke|General-Utmesten]] vun Sieden',
	'nuke-nopages'       => 'Gifft in de Ne’esten Ännern kene ne’en Sieden vun [[Special:Contributions/$1|$1]].',
	'nuke-list'          => 'Disse Sieden hett [[Special:Contributions/$1|$1]] nee maakt; geev en Kommentar in un drück op den Utmest-Knopp.',
	'nuke-defaultreason' => 'General-Utmesten vun Sieden, de $1 anleggt hett',
	'nuke-tools'         => 'Dit Warktüüch verlöövt dat General-Utmesten vun Sieden, de vun ene IP-Adress oder en Bruker anleggt worrn sünd. Geev de IP-Adress oder den Brukernaam in, dat du ene List kriggst:',
	'nuke-submit-user'   => 'List kriegen',
	'nuke-submit-delete' => 'Utmesten',
	'right-nuke'         => 'Groten Hümpel Sieden wegsmieten',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'nuke'               => 'Massaal verwijderen',
	'nuke-desc'          => "Geeft beheerders de mogelijkheid om [[Special:Nuke|massaal pagina's te verwijderen]]",
	'nuke-nopages'       => "Geen nieuwe pagina's van [[Special:Contributions/$1|$1]] in de recente wijzigingen.",
	'nuke-list'          => "De onderstaande pagina's zijn recentelijk aangemaakt door [[Special:Contributions/$1|$1]]; voer een reden in en klik op de knop om ze te verwijderen.",
	'nuke-defaultreason' => "Massaal verwijderen van pagina's van $1",
	'nuke-tools'         => "Dit hulpmiddel maakt het mogelijk massaal pagina's te verwijderen die recentelijk zijn aangemaakt door een gebruiker of IP-adres. Voer de gebruikernaam of het IP-adres in voor een lijst van te verwijderen pagina's:",
	'nuke-submit-user'   => 'OK',
	'nuke-submit-delete' => 'Geselecteerde verwijderen',
	'right-nuke'         => "Massaal pagina's verwijderen",
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'nuke'               => 'Massesletting',
	'nuke-desc'          => 'Gir administratorer muligheten til å [[Special:Nuke|masseslette]] sider',
	'nuke-nopages'       => 'Ingen nye sider av [[Special:Contributions/$1|$1]] i siste endringer.',
	'nuke-list'          => 'Følgende sider ble nylig opprettet av [[Special:Contributions/$1|$1]]; skriv inn en slettingsgrunn og trykk på knappen for å slette alle sidene.',
	'nuke-defaultreason' => 'Massesletting av sider lagt inn av $1',
	'nuke-tools'         => 'Dette verktøyet muliggjør massesletting av sider som nylig er lagt inn av en gitt bruker eller IP. Skriv et brukernavn eller en IP for å få en liste over sider som slettes:',
	'nuke-submit-user'   => 'Gå',
	'nuke-submit-delete' => 'Slett valgte',
	'right-nuke'         => 'Slette sider <i>en masse</i>',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'nuke-submit-user' => 'Sepela',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'nuke'               => 'Supression en massa',
	'nuke-desc'          => 'Balha la possiblitat als administrators de [[Special:Nuke|suprimir en massa]] de paginas.',
	'nuke-nopages'       => 'Cap de pagina novèla creada per [[Special:Contributions/$1|$1]] dins la lista dels darrièrs cambiaments.',
	'nuke-list'          => 'Las paginas seguentas son estadas creadas recentament per [[Special:Contributions/$1|$1]]; Indicatz un comentari e clicatz sul boton per los suprimir.',
	'nuke-defaultreason' => 'Supression en massa de las paginas ajustadas per $1',
	'nuke-tools'         => 'Aqueste esplech autoriza las supressions en massa de las paginas ajustadas recentament per un utilizaire enregistrat o per una adreça IP. Indicatz l’adreça IP per obténer la lista de las paginas de suprimir :',
	'nuke-submit-user'   => 'Validar',
	'nuke-submit-delete' => 'Supression seleccionada',
	'right-nuke'         => 'Suprimir de paginas en massa',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Derbeth
 */
$messages['pl'] = array(
	'nuke'               => 'Masowe usuwanie',
	'nuke-desc'          => 'Dodaje administratorom funkcjonalność równoczesnego [[Special:Nuke|usuwania dużej liczby stron]]',
	'nuke-nopages'       => 'Brak nowych stron autorstwa [[Special:Contributions/$1|$1]] w ostatnich zmianach.',
	'nuke-list'          => 'Następujące strony zostały ostatnio stworzone przez [[Special:Contributions/$1|$1]]; wpisz komentarz i wciśnij przycisk by usunąć je.',
	'nuke-defaultreason' => 'Masowe usunięcie stron dodanych przez $1',
	'nuke-tools'         => 'Narzędzia pozwala na masowe usuwanie stron ostatnio dodanych przez zarejestrowanego lub anonimowego użytkownika. Wpisz nazwę użytkownika lub adres IP by otrzymać listę stron do usunięcia:',
	'nuke-submit-user'   => 'Dalej',
	'nuke-submit-delete' => 'Usuń zaznaczone',
	'right-nuke'         => 'Masowe usuwanie stron',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'nuke'               => "Scancelament d'amblé",
	'nuke-nopages'       => "Gnun-a pàgine faite da [[Special:Contributions/$1|$1]] ant j'ùltim cambiament.",
	'nuke-list'          => "Ste pàgine-sì a son staite faite ant j'ùltim temp da [[Special:Contributions/$1|$1]]; ch'a lassa un coment e ch'a-i daga 'n colp ansima al boton për gaveje via tute d'amblé.",
	'nuke-defaultreason' => "Scancelament d'amblé dle pàgine faite da $1",
	'nuke-tools'         => "St'utiss-sì a lassa scancelé d'amblé le pàgine gionta ant j'ùltim temp da un chèich utent ò da 'nt na chèich adrëssa IP. Ch'a buta lë stranòm ò l'adrëssa IP për tiré giù na lista dle pàgine da scancelé:",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'nuke-submit-user'   => 'ورځه',
	'nuke-submit-delete' => 'ټاکل شوی ړنګول',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 */
$messages['pt'] = array(
	'nuke'               => 'Eliminação em massa',
	'nuke-desc'          => 'Dá aos sysops a possibilidade de [[Special:Nuke|apagar páginas em massa]]',
	'nuke-nopages'       => 'Não há páginas criadas por [[Special:Contributions/$1|$1]] nas mudanças recentes.',
	'nuke-list'          => 'As páginas a seguir foram criadas recentemente por [[Special:Contributions/$1|$1]]; forneça uma justificativa e pressione o botão a seguir para eliminá-las.',
	'nuke-defaultreason' => 'Eliminação em massa de páginas criadas por $1',
	'nuke-tools'         => 'Esta ferramenta permite a eliminação em massa de páginas recentemente criadas por um utilizador ou IP em específico. Forneça o nome de utilizador ou IP para obter uma lista de páginas a eliminar:',
	'nuke-submit-user'   => 'Ir',
	'nuke-submit-delete' => 'Eliminar as seleccionadas',
	'right-nuke'         => 'Eliminar páginas em massa',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'nuke'               => 'Tawqa qulluy',
	'nuke-list'          => "Kay qatiq p'anqakunataqa [[Special:Contributions/$1|$1]] ruraqmi kamarirqun; imarayku nispa butunta ñit'iy tawqalla qullunapaq.",
	'nuke-defaultreason' => "$1-pa rurasqan p'anqakunata tawqalla qulluy",
	'nuke-tools'         => "Kay llamk'anawanqa huk ruraqpa kamarisqan p'anqakunata tawqalla qulluytam atinki. Ruraqpa sutinta icha IP huchhanta yaykuchiy qulluna p'anqakunata rikunaykipaq.",
	'nuke-submit-user'   => 'Riy',
	'nuke-submit-delete' => 'Akllasqata qulluy',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'nuke-submit-user' => 'Raḥ ɣa',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author HalanTul
 * @author VasilievVV
 */
$messages['ru'] = array(
	'nuke'               => 'Множественное удаление',
	'nuke-desc'          => 'Даёт администраторам возможность [[Special:Nuke|множественного удаления]] страниц',
	'nuke-nopages'       => 'Созданий страниц участником [[Special:Contributions/$1|$1]] не найдено в свежих правках.',
	'nuke-list'          => 'Следующие страницы были недавно созданы участником [[Special:Contributions/$1|$1]]. Введите комментарий и нажмите на кнопку для того, чтобы удалить их.',
	'nuke-defaultreason' => 'Множественное удаление страниц, созданных участником $1',
	'nuke-tools'         => 'Эта страница позволяет множественно удалять страницы, созданные определённым участником или IP. Введите имя участника или IP для того, чтобы получить список созданных им страниц.',
	'nuke-submit-user'   => 'Выполнить',
	'nuke-submit-delete' => 'Удалить выбранные',
	'right-nuke'         => 'множественное удаление страниц',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'nuke'               => 'Маассабай сотуу',
	'nuke-desc'          => 'Администраатардарга [[Special:Nuke|элбэх сирэйи биир дьайыыннан сотор]] кыаҕы биэрэр',
	'nuke-nopages'       => 'Кэнники көннөрүүлэр испииһэктэригэр [[Special:Contributions/$1|$1]] саҥа сирэйи оҥорбута көстүбэтэ.',
	'nuke-list'          => 'Бу сирэйдэри соторутааҕыта [[Special:Contributions/$1|$1]] кыттааччы оҥорбут. Сотуоххун баҕарар буоллаххына быһаарыыны оҥорон баран тимэҕи баттаа.',
	'nuke-defaultreason' => '$1 кыттааччы айбыт сирэйдэрин бүтүннүү суох оҥоруу',
	'nuke-tools'         => 'Бу сирэй көмөтүнэн ханнык эмэ кыттааччы эбэтэр IP оҥорбут көннөрүүлэрин бүтүннүү суох гынахха сөп. Кыттааччы аатын эбэтэр IP-тын киллэрдэххинэ оҥорбут көннөрүүлэрин испииһэгэ тахсыа:',
	'nuke-submit-user'   => 'Толор',
	'nuke-submit-delete' => 'Талыллыбыты сот',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'nuke'               => 'Hromadné mazanie',
	'nuke-desc'          => 'Dáva správcom schopnosť [[Special:Nuke|hromadného mazania]] stránok',
	'nuke-nopages'       => 'V posledných zmenách sa nenachádzajú nové stránky od [[Special:Contributions/$1|$1]].',
	'nuke-list'          => '[[Special:Contributions/$1|$1]] nedávno vytvoril nasledovné nové stránky; vyplňte komentár a stlačením tlačidla ich vymažete.',
	'nuke-defaultreason' => 'Hromadné odstránenie stránok, ktoré pridal $1',
	'nuke-tools'         => 'Tento nástroj umožňuje hromadné odstránenie stránok, ktoré nedávno pridal zadaný používateľ alebo IP. Zadajte používateľa alebo IP a dostanente zoznam stránok na zmazanie:',
	'nuke-submit-user'   => 'Vykonať',
	'nuke-submit-delete' => 'Zmazať vybrané',
	'right-nuke'         => 'Hromadné mazanie stránok',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'nuke'               => 'Massen-Läskenge',
	'nuke-nopages'       => 'Dät rakt in do Lääste Annerengen neen näie Sieden fon [[Special:Contributions/$1|$1]].',
	'nuke-list'          => 'Do foulgjende Sieden wuuden fon [[Special:Contributions/$1|$1]] moaked; reek n Kommentoar ien un tai ap dän Läsk-Knoop.',
	'nuke-defaultreason' => 'Massen-Läskenge fon Sieden, do der fon $1 anlaid wuden',
	'nuke-tools'         => 'Disse Reewe moaket ju Massen-Läskenge muugelk fon Sieden, do der fon een IP-Adresse of aan Benutser anlaid wuuden. Reek ju IP-Adresse/die Benutsernoome ien, uum ne Lieste tou kriegen:',
	'nuke-submit-user'   => 'Hoalje Lieste',
	'nuke-submit-delete' => 'Läskje',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 * @author Irwangatot
 */
$messages['su'] = array(
	'nuke'               => 'Ngahapus masal',
	'nuke-desc'          => 'Leler kuncén kawenangan pikeun [[Special:Nuke|ngahapus kaca sacara masal]]',
	'nuke-nopages'       => 'Euweuh kaca anyar karya [[Special:Contributions/$1|$1]] dina béréndélan nu anyar robah.',
	'nuke-list'          => 'Kaca di handap anyar dijieun ku [[Special:Contributions/$1|$1]];<br />
tuliskeun pamanggih anjeun, terus pencét tombolna pikeun ngahapus.',
	'nuke-defaultreason' => 'Ngahapus kaca sacara masal ditambahkeun ku $1',
	'nuke-tools'         => 'Ieu parabot bisa dipaké pikeun ngahapus masal kaca-kaca nu anyar ditambahkeun ku pamaké atawa IP nu dimaksud. Asupkeun landihan atawa IP pikeun mulut kaca nu rék dihapus:',
	'nuke-submit-user'   => 'Jung',
	'nuke-submit-delete' => 'Hapus nu dipilih',
	'right-nuke'         => 'Ngahapus masal kaca',
);

/** Swedish (Svenska)
 * @author Lejonel
 */
$messages['sv'] = array(
	'nuke'               => 'Massborttagning',
	'nuke-desc'          => 'Gör det möjligt för administratörer att [[Special:Nuke|massradera]] sidor',
	'nuke-nopages'       => 'Inga nya sidor av [[Special:Contributions/$1|$1]] bland de senaste ändringarna.',
	'nuke-list'          => 'Följande sidor har nyligen skapats av [[Special:Contributions/$1|$1]]. Skriv en raderingskommentar och klicka på knappen för att ta bort dem.',
	'nuke-defaultreason' => 'Massradering av sidor skapade av $1',
	'nuke-tools'         => 'Det här verktyget gör det möjligt att massradera sidor som nyligen skapats av en vissa användare eller IP-adress. Ange ett användarnamn eller en IP-adress för att de en lista över sidor som kan tas bort:',
	'nuke-submit-user'   => 'Visa',
	'nuke-submit-delete' => 'Ta bort valda',
	'right-nuke'         => 'Massradera sidor',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'nuke'               => 'సామూహిక తొలగింపు',
	'nuke-desc'          => 'నిర్వాహకులకు పేజీలను [[Special:Nuke|సామూహికంగా తొలగించే]] సౌలభ్యాన్నిస్తుంది',
	'nuke-nopages'       => 'ఇటీవలి మార్పులలో [[Special:Contributions/$1|$1]] సృష్టించిన కొత్త పేజీలేమీ లేవు.',
	'nuke-list'          => 'ఈ క్రింద పేర్కొన్న పేజీలను [[Special:Contributions/$1|$1]] ఇటీవలే సృష్టించారు; వాటిని తొలగించడానికి ఎందుకో ఓ వ్యాఖ్య రాసి ఆతర్వాత తొలగించు అన్న బొత్తం నొక్కండి.',
	'nuke-defaultreason' => '$1 చేర్చిన పేజీల యొక్క సామూహిక తొలగింపు',
	'nuke-tools'         => 'ఓ ప్రత్యేక వాడుకరి లేదా IP చేర్చిన పేజీలను ఒక్కసారిగా తొలగించడానికి ఈ పనిముట్టు వీలుకల్పిస్తుంది. పేజీల జాబితాని పొందడానికి ఆ వాడుకరిపేరుని లేదా IPని ఇవ్వండి:',
	'nuke-submit-user'   => 'వెళ్ళు',
	'nuke-submit-delete' => 'ఎంచుకున్నవి తొలగించు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'nuke-submit-user' => 'Bá',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'nuke'               => 'Ҳазфи дастаҷамъӣ',
	'nuke-desc'          => 'Ба  мудирон имкони [[Special:Nuke|ҳазфи дастаҷамъии]] саҳифаҳоро медиҳад',
	'nuke-nopages'       => 'Саҳифаи ҷадиде аз [[Special:Contributions/$1|$1]] дар тағйироти охирин вуҷуд надорад.',
	'nuke-list'          => 'Саҳифаҳои зерин ба тозагӣ тавассути [[Special:Contributions/$1|$1]] эҷод шудаанд; тавзеҳеро гузоред ва тугмаеро фишор бидиҳед то ин саҳифаҳо ҳазф шаванд.',
	'nuke-defaultreason' => 'Ҳазфи дастиҷамъии саҳифаҳое, ки тавассути $1 эҷод шудаанд',
	'nuke-tools'         => 'Ин абзор имкони ҳазфи дастиҷамъии саҳифаҳое, ки ба тозагӣ тавассути як корбар ё  нишонии интернетӣ IP изофашударо фароҳам мекунад. Номи корбар ё нишонии IP вуруд кунед, феҳристи саҳифаҳои барои ҳазфро дастрас кунед:',
	'nuke-submit-user'   => 'Бирав',
	'nuke-submit-delete' => 'Интихобшудагон ҳазф шаванд',
);

/** Turkish (Türkçe)
 * @author Srhat
 * @author Erkan Yilmaz
 */
$messages['tr'] = array(
	'nuke-submit-user'   => 'Git',
	'nuke-submit-delete' => 'Seçileni sil',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'nuke'               => 'Масове вилучення',
	'nuke-desc'          => 'Дає адміністраторам можливість [[Special:Nuke|масового вилучення]] сторінок',
	'nuke-nopages'       => 'У нових редагуваннях не знайдено сторінок, створених користувачем [[Special:Contributions/$1|$1]].',
	'nuke-list'          => 'Наступні сторінки були нещодавно створені користувачем [[Special:Contributions/$1|$1]].
Уведіть коментар і натисніть на кнопку для того, щоб вилучити їх.',
	'nuke-defaultreason' => 'Масове вилучення сторінок, створених користувачем $1',
	'nuke-tools'         => "Ця сторінка дозволяє масово вилучати сторінки, створені певним користувачем або з певної IP-адреси.
Уведіть ім'я користувача або IP для того, щоб отримати список створених ним сторінок:",
	'nuke-submit-user'   => 'Виконати',
	'nuke-submit-delete' => 'Вилучити обрані',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'nuke'               => 'Scancelazion de massa',
	'nuke-desc'          => 'Consente ai aministradori la [[Special:Nuke|scancelazion in massa]] de le pagine',
	'nuke-nopages'       => 'No xe stà catà pagine nove creà da [[Special:Contributions/$1|$1]] tra le modifiche recenti.',
	'nuke-list'          => 'Le seguenti pagine le xe stà creà de recente da [[Special:Contributions/$1|$1]]; inserissi un comento e conferma la scancelazion.',
	'nuke-defaultreason' => 'Scancelazion de massa de le pagine creà da $1',
	'nuke-tools'         => "Sto strumento el permete la scancelazion in massa de le pagine creà de recente da un determinato utente o IP. Inserissi el nome utente o l'IP par la lista de le pagine da scancelar:",
	'nuke-submit-user'   => 'Và',
	'nuke-submit-delete' => 'Scancela la selezion',
	'right-nuke'         => 'Scancelassion de massa de le pagine',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'nuke'               => 'Xóa hàng loạt',
	'nuke-desc'          => 'Cung cấp cho người quản lý khả năng [[Special:Nuke|xóa trang hàng loạt]]',
	'nuke-nopages'       => 'Không có trang mới do [[Special:Contributions/$1|$1]] tạo ra trong thay đổi gần đây.',
	'nuke-list'          => 'Các trang sau do [[Special:Contributions/$1|$1]] tạo ra gần đây; hãy ghi lý do và nhấn nút để xóa tất cả những trang này.',
	'nuke-defaultreason' => 'Xóa hàng loạt các trang do $1 tạo ra',
	'nuke-tools'         => 'Công cụ này để xóa hàng lạt các trang do một người dùng tạo ra gần đây. Hãy cung cấp tên hiệu của thành viên hay địa chỉ IP của người dùng để tìm kiếm những trang để xóa:',
	'nuke-submit-user'   => 'Tìm kiếm',
	'nuke-submit-delete' => 'Xóa lựa chọn',
	'right-nuke'         => 'Xóa trang hàng loạt',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'nuke'               => 'Moükön pademi',
	'nuke-nopages'       => 'Pads nonik fa geban: [[Special:Contributions/$1|$1]] pejaföls binons su lised votükamas nulik.',
	'nuke-list'          => 'Pads sököl pejafons brefabüo fa geban: [[Special:Contributions/$1|$1]]; penolös küpeti e klikolös gnobi ad moükön onis.',
	'nuke-defaultreason' => 'Moükam padas fa geban: $1 pejafölas',
	'nuke-tools'         => 'Stum at kanon moükön mödoti padas fa geban u ladet-IP semik brefabüo pejafölas. Penolös gebananemi u ladeti-IP ad dagetön lisedi padas moükovik:',
	'nuke-submit-user'   => 'Ledunolöd',
	'nuke-submit-delete' => 'Pevalöl ad pamoükön',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'nuke'               => '大量刪除',
	'nuke-desc'          => '畀操作員去做[[Special:Nuke|大量刪除]]嘅能力',
	'nuke-nopages'       => '響最近更改度無[[Special:Contributions/$1|$1]]所做嘅新頁。',
	'nuke-list'          => '下面嘅頁係由[[Special:Contributions/$1|$1]]響之前所寫嘅；記低一個註解再撳掣去刪除佢哋。',
	'nuke-defaultreason' => '大量刪除由$1所開嘅頁',
	'nuke-tools'         => '呢個工具容許之前提供咗嘅用戶或者IP加入嘅頁。輸入用戶名或者IP去拎頁一覽去刪除:',
	'nuke-submit-user'   => '去',
	'nuke-submit-delete' => '刪除㨂咗嘅',
	'right-nuke'         => '大量刪頁',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'nuke'               => '大量删除',
	'nuke-desc'          => '给操作员作出[[Special:Nuke|大量删除]]的能力',
	'nuke-nopages'       => '在最近更改中没有[[Special:Contributions/$1|$1]]所作的新页面。',
	'nuke-list'          => '以下的页面是由[[Special:Contributions/$1|$1]]在以前所写的；记下一个注解再点击按钮去删除它们。',
	'nuke-defaultreason' => '大量删除由$1所创建的页面',
	'nuke-tools'         => '这个工具容许先前提供了的的用户或IP创建的页面。输入用户名或IP去取得页面列表以作删除:',
	'nuke-submit-user'   => '去',
	'nuke-submit-delete' => '删除已选择的',
	'right-nuke'         => '大量删除页面',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'nuke'               => '大量刪除',
	'nuke-desc'          => '給操作員作出[[Special:Nuke|大量刪除]]的能力',
	'nuke-nopages'       => '在最近更改中沒有[[Special:Contributions/$1|$1]]所作的新頁面。',
	'nuke-list'          => '以下的頁面是由[[Special:Contributions/$1|$1]]在以前所寫的；記下一個註解再點擊按鈕去刪除它們。',
	'nuke-defaultreason' => '大量刪除由$1所創建的頁面',
	'nuke-tools'         => '這個工具容許先前提供了的的用戶或IP創建的頁面。輸入用戶名或IP去取得頁面列表以作刪除:',
	'nuke-submit-user'   => '去',
	'nuke-submit-delete' => '刪除已選擇的',
	'right-nuke'         => '大量刪除頁面',
);

