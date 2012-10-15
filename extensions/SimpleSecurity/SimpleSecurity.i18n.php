<?php
/**
 * Internationalisation for SimpleSecurity extension
 *
 * @author Nad
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Nad
 */
$messages['en'] = array(
	'security'                 => 'Security log',
	'security-desc'            => 'Extends the MediaWiki page protection to allow restricting viewing of page content',
	'security-logpage'         => 'Security log',
	'security-logpagetext'     => 'This is a log of actions blocked by the [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity extension].',
	'security-logentry'        => '', # do not translate or duplicate this message to other languages
	'badaccess-read'           => '\'\'\'Warning:\'\'\' "$1" is referred to here, but you do not have sufficient permissions to access it.',
	'security-info'            => 'There are $1 on this page',
	'security-info-toggle'     => 'security restrictions', // FIXME: should be integrated into 'security-info'
	'security-inforestrict'    => '$1 is restricted to $2',
	'security-desc-LS'         => '(applies because this page is in the "$2 $1")',
	'security-desc-PR'         => '(set from the "protect" tab)',
	#'security-desc-CR'         => "(this restriction is in effect now)",
	'security-infosysops'      => 'No restrictions are in effect because you are a member of the "sysop" group',
	'security-manygroups'      => 'groups $1 and $2',
	'security-unchain'         => 'Modify actions individually',
	'security-type-category'   => 'category',
	'security-type-namespace'  => 'namespace',
	'security-restricttogroup' => 'Access content restricted to members of "$1"',
	'restriction-read'         => 'Read',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'security' => '{{doc-important|The translation for this message cannot be equal to that of {{msg-mw|protectlogpage}} ({{int:protectlogpage}})!}}',
	'security-desc' => '{{desc}}',
	'badaccess-read' => '$1 is a page title that is restricted to access.',
	'security-info' => '$1 is {{msg-mw|Security-info-toggle}} with a link',
	'security-inforestrict' => '* $1 is an action name
* $2 contains user group name(s)',
	'security-desc-LS' => '* $1 is the name of a category or namespace
* $2 is {{msg-mw|security-type-category}} or {{msg-mw|security-type-namespace}}',
	'security-type-category' => '{{Identical|Category}}',
	'security-type-namespace' => '{{Identical|Namespace}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'security-type-category' => 'kategorie',
	'security-type-namespace' => 'naamruimte',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'security' => 'Regjistri i Sigurimit',
	'security-desc' => 'Zgjat mbrojtja faqe MediaWiki të lejojë shikimin e kufizuar e faqes përmbajtjes',
	'security-logpage' => 'Regjistri i Sigurimit',
	'security-logpagetext' => 'Ky është një regjistër për veprimet e bllokuar nga ana e] SimpleSecurity [http://www.mediawiki.org/wiki/Extension:SimpleSecurity extension.',
	'badaccess-read' => "'''Kujdes:''' \"\$1\" është përmendur këtu, por ju nuk keni leje të mjaftueshme për të hyrë në të.",
	'security-info' => 'Ka $1  në këtë faqe',
	'security-info-toggle' => 'kufizimet e sigurisë',
	'security-inforestrict' => '$1 është i kufizuar në $2',
	'security-desc-LS' => '(Vlen për shkak se kjo faqe është në "$2 $1")',
	'security-desc-PR' => '(Përcaktuar nga "të mbrojtur" tab)',
	'security-infosysops' => 'Nuk ka kufizime janë në fuqi, sepse ju jeni një anëtar i "grupit sysop"',
	'security-manygroups' => 'grupeve $1 dhe $2',
	'security-unchain' => 'veprimet Modifiko individualisht',
	'security-type-category' => 'kategori',
	'security-type-namespace' => 'namespace',
	'security-restricttogroup' => 'Përmbajtja Hyrje kufizuar për anëtarët e "$1"',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'security-type-namespace' => 'espacio de nombres',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author روخو
 */
$messages['ar'] = array(
	'security' => 'سجل الأمن',
	'security-desc' => 'يمدد حماية المقالات في ميدياويكي للسماح بتحديد رؤية محتوى المقالات',
	'security-logpage' => 'سجل الأمن',
	'security-logpagetext' => 'هذا سجل بالأفعال الممنوعة بواسطة [http://www.mediawiki.org/wiki/Extension:SimpleSecurity امتداد الأمن البسيط].',
	'badaccess-read' => 'تحذير: "$1" ترجع إلى هنا، لكنك لا تمتلك سماحات كافية للوصول إليها.',
	'security-info' => 'توجد $1 على هذه المقالة',
	'security-info-toggle' => 'ضوابط الأمن',
	'security-inforestrict' => '$1 مضبوط إلى $2',
	'security-desc-LS' => '(يطبق لأن هذه المقالة موجودة في "$2 $1")',
	'security-desc-PR' => '(اضبط من لسان "الحماية")',
	'security-infosysops' => 'لا قيود مفعّلة لأنك عضو في مجموعة "sysop"',
	'security-manygroups' => 'المجموعات $1 و $2',
	'security-unchain' => 'عدل الأفعال بشكل فردي',
	'security-type-category' => 'تصنيف',
	'security-type-namespace' => 'نطاق',
	'security-restricttogroup' => 'الوصول إلى المحتوى مُقيّد لأعضاء "$1"',
	'restriction-read' => 'اقرأ',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'security' => 'ܣܓܠܐ ܕܫܝܢܐ',
	'security-type-category' => 'ܣܕܪܐ',
	'security-type-namespace' => 'ܚܩܠܐ',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'security-type-category' => 'kateqoriya',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'security' => 'Хәүефһеҙлек яҙмалары журналы',
	'security-desc' => 'MediaWiki биттәрен һаҡлауҙы, биттең эстәлеген ҡарауҙы сикләргә мөмкинлек биреп, киңәйтә',
	'security-logpage' => 'Хәүефһеҙлек яҙмалары журналы',
	'security-logpagetext' => 'Был — [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity] тарафынан бикләнгән ғәмәлдәр яҙмалары журналы.',
	'badaccess-read' => "'''Киҫәтеү:''' \"\$1\" бында һылтана, әммә һеҙҙең етәрлек хоҡуҡтарығыҙ юҡ.",
	'security-info' => 'Был бит өсөн $1 бар',
	'security-info-toggle' => 'хәүефһеҙлек сикләүҙәре',
	'security-inforestrict' => '$1 $2 өсөн сикләнгән',
	'security-desc-LS' => '(ҡулланылған, сөнки был бит "$2 $1" эсендә)',
	'security-desc-PR' => '("һаҡларға" бүлеге аша ҡуйылған)',
	'security-infosysops' => 'Сикләүҙәр ҡулланылмай, сөнки һеҙ — "sysop" төркөмө ағзаһы',
	'security-manygroups' => '$1 һәм $2 төркөмө',
	'security-unchain' => 'Ғәмәлдәрҙе шәхси рәүештә үҙгәртергә',
	'security-type-category' => 'категориялар',
	'security-type-namespace' => 'исемдәр арауығы',
	'security-restricttogroup' => 'Эстәлекте ҡарау "$1" ағазалары менән сикләнгән',
	'restriction-read' => 'Уҡыу',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'security-type-category' => 'катэгорыя',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'security' => 'Журнал бясьпекі',
	'security-desc' => 'Пашырае магчымасьці абароны старонак MediaWiki і дазваляе абмяжоўваць прагляд зьместу старонак',
	'security-logpage' => 'Журнал бясьпекі',
	'security-logpagetext' => 'Гэта журнал дзеяньняў не дазволеных з дапамогай [http://www.mediawiki.org/wiki/Extension:SimpleSecurity пашырэньня SimpleSecurity].',
	'badaccess-read' => 'Увага: «$1» спасылаецца сюды, але Вы ня маеце адпаведных правоў для доступу.',
	'security-info' => 'Гэтая старонка мае $1',
	'security-info-toggle' => 'абмежаваньні бясьпекі',
	'security-inforestrict' => '$1 забаронены для $2',
	'security-desc-LS' => "(адпавядае, таму што гэтая старонка ў '''$2 $1''')''",
	'security-desc-PR' => "(устаноўленая з '''закладкі абароны''')''",
	'security-infosysops' => "Ніякія абмежаваньні ня будуць дзейнічаць, таму што Вы зьяўляецеся '''адміністратарам'''",
	'security-manygroups' => 'групы $1 і $2',
	'security-unchain' => 'Зьмяніць дзеяньні індывідуальна',
	'security-type-category' => 'катэгорыя',
	'security-type-namespace' => 'прастора назваў',
	'security-restricttogroup' => 'Доступ да зьместу абмежаваны для групы «$1»',
	'restriction-read' => 'Чытаць',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'security-type-category' => 'категория',
	'security-type-namespace' => 'именно пространство',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'security' => 'নিরাপত্তা লগ',
	'security-logpage' => 'নিরাপত্তা লগ',
	'security-info-toggle' => 'নিরাপত্তা সীমাবদ্ধতা',
	'security-type-category' => 'বিষয়শ্রেণী',
	'security-type-namespace' => 'নামস্থান',
	'restriction-read' => 'পড়ুন',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'security' => 'Marilh surentez',
	'security-desc' => 'Astenn a ra etrefas gwarez MediaWiki evit ma vo gallet strishaat ar gwel ouzh danvez pennadoù zo.',
	'security-logpage' => 'Marilh surentez',
	'security-logpagetext' => 'Ur marilh eus an oberezhioù stanket gant an [http://www.mediawiki.org/wiki/Extension:SimpleSecurity astenn SimpleSecurity] eo.',
	'badaccess-read' => "'''Diwallit :''' \"menegeret eo \$1\" amañ met n'oc'h ket c'hwi aotreet da vont e-barzh.",
	'security-info' => " Bez' ez eus $1 war ar bajenn-mañ",
	'security-info-toggle' => 'strishadurioù surentez',
	'security-inforestrict' => '$1 zo strishaet da $2',
	'security-desc-LS' => '(arloet dre ma \'z eo ar pennad-mañ en "$2 $1")',
	'security-desc-PR' => '(termenet adalek an ivinell gwarez)',
	'security-infosysops' => "N'eus strishadur ebet o ren abalamour ma'z oc'h ezel eus ar strollad \"sysop\"",
	'security-manygroups' => 'strolladoù $1 ha $2',
	'security-unchain' => 'Kemmañ an oberoù unan-hag-unan',
	'security-type-category' => 'rummad',
	'security-type-namespace' => 'esaouenn anv',
	'security-restricttogroup' => 'Mont d\'an endalc\'had evit izili "$1" hepken',
	'restriction-read' => 'Lenn',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'security' => 'Zapisnik sigurnosti',
	'security-desc' => 'Proširuje zaštitu MediaWiki stranice da bi se dopustilo pregledanje zaštićenog sadržaja stranice',
	'security-logpage' => 'Zapisnik sigurnosti',
	'security-logpagetext' => 'Ovo je zapisnik akcija blokiranih putem [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity proširenja].',
	'badaccess-read' => 'Upozorenje: "$1" je povezano ovdje, ali nemate dovoljno privilegija da ovdje pristupite.',
	'security-info' => 'Postoji $1 na ovom članku',
	'security-info-toggle' => 'sigurnosna ograničenja',
	'security-inforestrict' => '$1 je onemogućena za $2',
	'security-desc-LS' => '(primjenjuje se jer je ova stranica u "$2 $1")',
	'security-desc-PR' => '(postavljeno iz stranice "zaštite")',
	'security-infosysops' => 'Nemate aktivnih ograničenja jer ste član grupe "administratora"',
	'security-manygroups' => 'grupe $1 i $2',
	'security-unchain' => 'Izmijeni svaku akciju zasebno',
	'security-type-category' => 'kategorija',
	'security-type-namespace' => 'imenski prostor',
	'security-restricttogroup' => 'Pristup sadržaju onemogućen članovima "$1"',
	'restriction-read' => 'Čitanje',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'security' => 'Registre de seguretat',
	'security-info-toggle' => 'Restriccions de seguretat',
	'security-type-category' => 'categoria',
	'security-type-namespace' => 'espai de noms',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'security-type-category' => 'پۆل',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'security-type-category' => 'kategorie',
	'security-type-namespace' => 'jmenný prostor',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Kghbln
 * @author Purodha
 * @author Umherirrender
 */
$messages['de'] = array(
	'security' => 'Sicherheits-Logbuch',
	'security-desc' => 'Erweitert den Seitenschutz um die Möglichkeit, das Betrachten von Seiten einzuschränken.',
	'security-logpage' => 'Sicherheits-Logbuch',
	'security-logpagetext' => 'Dies ist das Logbuch der von [http://www.mediawiki.org/wiki/Extension:SimpleSecurity Extension „SimpleSecurity“] blockierten Aktionen.',
	'badaccess-read' => "'''Warnung:''' „$1“ verweist hierher. Du hast aber keine ausreichende Berechtigung um die Seite zu sehen.",
	'security-info' => 'Für diese Seite gibt es $1.',
	'security-info-toggle' => 'Sicherheitseinschränkungen',
	'security-inforestrict' => '$1 ist beschränkt auf $2',
	'security-desc-LS' => '(gilt, weil diese Seite $2 „$1“ ist)',
	'security-desc-PR' => '(gesetzt über den Reiter „Seitenschutz“)',
	'security-infosysops' => 'Für dich sind keine Einschränkungen aktiv, weil du der Gruppe „Administratoren“ angehörst.',
	'security-manygroups' => 'Gruppen $1 und $2',
	'security-unchain' => 'Ändere Aktionen einzeln',
	'security-type-category' => 'in der Kategorie',
	'security-type-namespace' => 'im Namensraum',
	'security-restricttogroup' => 'Zugriff auf Inhalte, die auf Benutzer der Gruppe „$1“ beschränkt sind',
	'restriction-read' => 'Lesen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'badaccess-read' => "'''Warnung:''' „$1“ verweist hierher. Sie haben aber keine ausreichende Berechtigung um die Seite zu sehen.",
	'security-infosysops' => 'Für Sie sind keine Einschränkungen aktiv, weil Sie der Gruppe „Administratoren“ angehören.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'security' => 'Wěstotny protokol',
	'security-desc' => 'Rozšyrja nastawkowy šćit MediaWiki wó móžnosć wobglědanje nastawkowego wopśimjeśa wobgranicowaś',
	'security-logpage' => 'Wěstotny protokol',
	'security-logpagetext' => 'To jo protokol akcijow blokěrowanych pséz [http://www.mediawiki.org/wiki/Extension:SimpleSecurity rozšyrjenje Simple Security].',
	'badaccess-read' => 'Warnowanje: How se na "$1" póśěgujo, ale njamaš pšawa, aby měł na njen pśistup.',
	'security-info' => 'Su $1 wó toś tom nastawku',
	'security-info-toggle' => 'wěstotne wobgranicowanja',
	'security-inforestrict' => '$1 jo na $2 wobgranicowany',
	'security-desc-LS' => '(nałožujo se, dokulaž toś ten bok jo w "$2 $1")',
	'security-desc-PR' => '(ze "šćitowego rejtarka" stajony)',
	'security-infosysops' => 'Njejsu žedne wobgranicowanja, dokulaž sy cłonk w kupce "administratorow"',
	'security-manygroups' => 'kupce $1 a $2',
	'security-unchain' => 'Akcije jadnotliwje změniś',
	'security-type-category' => 'kategorija',
	'security-type-namespace' => 'mjenjowy rum',
	'security-restricttogroup' => 'Pśistup na wopśimjeśe na cłonkow kupki "$1" wobgranicowany',
	'restriction-read' => 'Cytaś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'security' => 'Αρχείο ασφαλείας',
	'security-logpage' => 'Αρχείο ασφαλείας',
	'security-info' => 'Υπάρχουν $1 σε αυτή τη σελίδα',
	'security-info-toggle' => 'περιορισμοί ασφαλείας',
	'security-inforestrict' => 'Ο $1 είναι περιορισμένος στο $2',
	'security-desc-PR' => '(έτοιμο από την καρτέλα "προστασία")',
	'security-manygroups' => 'ομάδες $1 και $2',
	'security-unchain' => 'Τροποποίηση ενεργειών ατομικά',
	'security-type-category' => 'κατηγορία',
	'security-type-namespace' => 'περιοχή ονομάτων',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'security' => 'Protokolo pri sekureco',
	'security-info' => 'Estas $1 en ĉi tiu paĝo',
	'security-manygroups' => 'grupoj $1 kaj $2',
	'security-type-category' => 'kategorio',
	'security-type-namespace' => 'nomspaco',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Dferg
 */
$messages['es'] = array(
	'security' => 'Registro de seguridad',
	'security-desc' => 'Extiende la protección de artículos MediaWiki para permitir vista restringida del contenido del artículo',
	'security-logpage' => 'Registro de seguridad',
	'security-logpagetext' => 'Esto es un registro de bloqueo de acciones hechos por [http://www.mediawiki.org/wiki/Extension:SimpleSecurity la extensión SimpleSecurity].',
	'badaccess-read' => 'Advertencia:"$1" está referenciado aquí, pero no tienes permisos suficientes para acceder a el.',
	'security-info' => 'Hay $1 en este artículo',
	'security-info-toggle' => 'restricciones de seguridad',
	'security-inforestrict' => '$1 está restringido a $2',
	'security-desc-LS' => '(aplica porque esta página está en el "$2 $1")',
	'security-desc-PR' => '(aplicar desde la pestaña "proteger")',
	'security-infosysops' => 'No tiene restricciones activas porque Ud. es miembro del grupo "administradores".',
	'security-manygroups' => 'grupos $1 y $2',
	'security-unchain' => 'modificar acciones individualmente',
	'security-type-category' => 'categoría',
	'security-type-namespace' => 'espacio de nombre',
	'security-restricttogroup' => 'Acceso a contenidos restringido a miembros de "$1"',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'security' => 'Segurtasun erregistroa',
	'security-logpage' => 'Segurtasun erregistroa',
	'security-info-toggle' => 'segurtasun murrizketak',
	'security-manygroups' => '$1 eta $2 taldeak',
	'security-type-category' => 'kategoria',
	'security-type-namespace' => 'izen-tartea',
	'restriction-read' => 'Irakurri',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 */
$messages['fi'] = array(
	'security' => 'Tietoturvaloki',
	'security-desc' => 'Laajentaa MediaWikin sivujen suojausta myös sivujen sisällön katsomisen rajoittamiseen',
	'security-logpage' => 'Tietoturvaloki',
	'security-info' => 'Tällä sivulla on $1',
	'security-info-toggle' => 'turvallisuusrajoitukset',
	'security-inforestrict' => '$1 on rajoitettu ryhmälle $2',
	'security-infosysops' => 'Rajoitukset eivät koske sinua, koska kuulut ylläpitäjäryhmään',
	'security-manygroups' => 'ryhmät $1 ja $2',
	'security-type-category' => 'luokka',
	'security-type-namespace' => 'nimiavaruus',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'security' => 'Journal de sécurité',
	'security-desc' => 'Étend l’interface de protection de MediaWiki pour permettre de restreindre la vue des pages',
	'security-logpage' => 'Journal de sécurité',
	'security-logpagetext' => 'Ceci est un journal des actions bloquées par l’[http://www.mediawiki.org/wiki/Extension:SimpleSecurity extension SimpleSecurity].',
	'badaccess-read' => 'Attention : « $1 » est référencé ici, mais vous ne disposez pas des autorisations pour y accéder.',
	'security-info' => 'Il y a $1 sur cet article',
	'security-info-toggle' => 'restrictions de sécurité',
	'security-inforestrict' => '$1 est limité à $2',
	'security-desc-LS' => '(s’applique parce que cet article est dans le « $1 $2 »)',
	'security-desc-PR' => '(défini depuis l’onglet de protection)',
	'security-infosysops' => 'Aucune restriction en vigueur parce que vous êtes un membre du groupe « administrateur »',
	'security-manygroups' => 'groupes $1 et $2',
	'security-unchain' => 'Modifier les actions individuellement',
	'security-type-category' => 'catégorie',
	'security-type-namespace' => 'espace de noms',
	'security-restricttogroup' => 'Accès au contenu réservé aux membres de « $1 »',
	'restriction-read' => 'Lire',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'security' => 'Jornal de sècuritât',
	'security-logpage' => 'Jornal de sècuritât',
	'security-info' => 'Y at $1 sur ceta pâge',
	'security-info-toggle' => 'rèstriccions de sècuritât',
	'security-inforestrict' => '$1 est limitâ a $2',
	'security-desc-LS' => '(s’aplique perce que ceta pâge est dens lo « $1 $2 »)',
	'security-desc-PR' => '(dèfeni dês l’ongllèta de « protèccion »)',
	'security-manygroups' => 'tropes $1 et $2',
	'security-unchain' => 'Changiér les accions en particuliér',
	'security-type-category' => 'catègorie',
	'security-type-namespace' => 'èspâço de noms',
	'security-restricttogroup' => 'Accès u contegnu resèrvâ ux membros de « $1 »',
	'restriction-read' => 'Liére',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'security' => 'Rexistro de seguridade',
	'security-desc' => 'Amplía a protección da páxina MediaWiki para permitir a restrición da visualización da páxina de contido',
	'security-logpage' => 'Rexistro de seguridade',
	'security-logpagetext' => 'Este é un rexistro das accións bloqueadad pola [http://www.mediawiki.org/wiki/Extension:SimpleSecurity extensión SimpleSecurity].',
	'badaccess-read' => 'Advertencia: "$1" está aquí referida, pero non ten os permisos necesarios para acceder a ela.',
	'security-info' => 'Hai $1 nesta páxina',
	'security-info-toggle' => 'restricións de seguridade',
	'security-inforestrict' => '$1 está restrinxido a $2',
	'security-desc-LS' => '(aplícase porque esta páxina está no/na "$2 $1")',
	'security-desc-PR' => '(establecido desde a "lapela de protección")',
	'security-infosysops' => 'Non hai restricións en vigor porque vostede é membro do grupo dos "administradores"',
	'security-manygroups' => 'grupos $1 e $2',
	'security-unchain' => 'Modificar as accións individualmente',
	'security-type-category' => 'categoría',
	'security-type-namespace' => 'espazo de nomes',
	'security-restricttogroup' => 'Acceso ao contido restrinxido aos membros de "$1"',
	'restriction-read' => 'Ler',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'security-type-category' => 'κατηγορία',
	'security-type-namespace' => 'Ὀνοματεῖον',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'security' => 'Sicherheits-Logbuech',
	'security-desc' => 'Erwyteret dr Mediawiki-Syteschutz, zum Aaluege vum Syteinhalt yyzschränke',
	'security-logpage' => 'Sicherheits-Logbuech',
	'security-logpagetext' => 'Des isch s Logbuech vu dr Aktione, wu gsperrt sin dur d [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity-Erwyterig].',
	'badaccess-read' => 'Warnig: "$1" isch do aagee, aber Du hesch nit d netig Berächtigung go die Syte aaluege.',
	'security-info' => 'Uf däre Syte het s $1',
	'security-info-toggle' => 'Sicherheitsyyschränkige',
	'security-inforestrict' => '$1 isch yygschränkt uf $2',
	'security-desc-LS' => "(giltet, wel die Syte in dr „$2 $1“ isch)''",
	'security-desc-PR' => '(gsetzt iber dr Regischtercharte „Syteschutz“)',
	'security-infosysops' => 'Fir Dii git s kei Yyschränkige, wel Du zue dr Gruppe „Ammann“ ghersch',
	'security-manygroups' => 'Gruppe $1 un $2',
	'security-unchain' => 'Aktione einzeln ändere',
	'security-type-category' => 'Kategorii',
	'security-type-namespace' => 'Namensruum',
	'security-restricttogroup' => 'Zuegriff uf Inhalt bschränkt uf Mitgliider vu „$1“',
	'restriction-read' => 'Läse',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'security-type-category' => 'rukuni',
	'security-type-namespace' => 'sararin suna',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'security' => 'יומן האבטחה',
	'security-desc' => 'הרחבת הגנת הדפים במדיה־ויקי כך שתתאפשר הגבלת הצפיה בתוכן הדף',
	'security-logpage' => 'יומן האבטחה',
	'security-logpagetext' => 'זהו יומן הפעולות שנחסמו על ידי [http://www.mediawiki.org/wiki/Extension:SimpleSecurity ההרחבה SimpleSecurity].',
	'badaccess-read' => 'אזהרה: נמצאת כאן הפניה אל "$1", אך הרשאותיכם אינן מאפשרות גישה אליו.',
	'security-info' => 'ישנם $1 בדף זה',
	'security-info-toggle' => 'הגבלות אבטחה',
	'security-inforestrict' => 'הפעולה $1 מוגבלת לקבוצה $2',
	'security-desc-LS' => '(חל כיוון שדף זה נמצא ב"$2 $1")',
	'security-desc-PR' => '(הוגדר דרך לשונית ה"הגנה")',
	'security-infosysops' => 'לא חלות הגבלות כלשהן כיוון שאתם חברים בקבוצה "מפעילי מערכת"',
	'security-manygroups' => 'הקבוצות $1 ו־$2',
	'security-unchain' => 'שינוי פעולות בנפרד',
	'security-type-category' => 'קטגוריה',
	'security-type-namespace' => 'מרחב השם',
	'security-restricttogroup' => 'הגישה לתוכן מוגבלת לחברים בקבוצה "$1"',
	'restriction-read' => 'קריאה',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'security' => 'Wěstotny protokol',
	'security-desc' => 'Rozšěrja nastawkowy škit MediaWiki wo móžnosć wobhladanje nastawkoweho wobsaha wobmjezować',
	'security-logpage' => 'Wěstotny protokol',
	'security-logpagetext' => 'To je protokol akcijow zablokowanych přez [http://www.mediawiki.org/wiki/Extension:SimpleSecurity rozšěrjenje Simple Security].',
	'badaccess-read' => 'Warnowanje: Na "$1 so tu poćahuje, ale nimaš prawa, zo by přistup na njón měł.',
	'security-info' => 'Su $1 wo tutym nastawku',
	'security-info-toggle' => 'wěstotne wobmjezowanja',
	'security-inforestrict' => '$1 je na $2 wobmjezowany',
	'security-desc-LS' => '(nałožuje so, dokelž tuta strona je w "$2 $1")',
	'security-desc-PR' => '(ze "škitoweho rajtarka" stajeny)',
	'security-infosysops' => 'Njejsu wobmjezowanja, dokelž sy čłon skupiny "administratorow"',
	'security-manygroups' => 'skupinje $1 a $2',
	'security-unchain' => 'Akcije jednotliwje změnić',
	'security-type-category' => 'kategorija',
	'security-type-namespace' => 'mjenowy rum',
	'security-restricttogroup' => 'Přistup na wobsah je za čłonow wot "$1" wobmjezowany',
	'restriction-read' => 'Čitać',
);

/** Hungarian (Magyar)
 * @author Dj
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'security' => 'Biztonsági napló',
	'security-desc' => 'Kiterjeszti a MediaWiki lapvédelem funkcióját, lehetővé teszi a lapok olvasásának korlátozását',
	'security-logpage' => 'Biztonsági napló',
	'security-logpagetext' => 'Azon műveletek naplója, amelyeket a [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity kiterjesztés] blokkolt.',
	'badaccess-read' => "'''Figyelmeztetés:''' „$1” ide hivatkozott, de nincs jogosultságod a lap olvasására.",
	'security-info' => '$1 vannak ezen a lapon',
	'security-info-toggle' => 'biztonsági megkötések',
	'security-inforestrict' => '$1 korlátozva a(z) $2 tagjaira',
	'security-desc-LS' => '(érvényes, mivel ez a lap a(z) „$2 $1” része)',
	'security-desc-PR' => '(beállítva a „lapvédelem” fülről)',
	'security-infosysops' => 'Nincsenek érvényben levő korlátozások, mert tagja vagy a „sysop” csoportnak',
	'security-manygroups' => '$1 és $2 csoportok',
	'security-unchain' => 'Műveletek módosítása egyenként',
	'security-type-category' => 'kategória',
	'security-type-namespace' => 'névtér',
	'security-restricttogroup' => 'A tartalom megjelenítése a(z) „$1” csoport tagjaira van korlátozva',
	'restriction-read' => 'Olvasás',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'security' => 'Registro de securitate',
	'security-desc' => 'Extende le protection de paginas MediaWiki pro permitter restringer le vista del contento del paginas',
	'security-logpage' => 'Registro de securitate',
	'security-logpagetext' => 'Isto es un registro de actiones blocate per le [http://www.mediawiki.org/wiki/Extension:SimpleSecurity extension SimpleSecurity].',
	'badaccess-read' => 'Attention: "$1" es referentiate ci, ma tu non ha permissiones sufficiente pro acceder a illo.',
	'security-info' => 'Iste pagina es subjecte a $1',
	'security-info-toggle' => 'restrictiones de securitate',
	'security-inforestrict' => '$1 es restringite a $2',
	'security-desc-LS' => "(se applica proque iste pagina es in le ''$2 $1'')",
	'security-desc-PR' => '(definite in le scheda "proteger")',
	'security-infosysops' => 'Nulle restriction es in vigor proque tu es membro del gruppo "administratores"',
	'security-manygroups' => 'gruppos $1 e $2',
	'security-unchain' => 'Modificar actiones individualmente',
	'security-type-category' => 'categoria',
	'security-type-namespace' => 'spatio de nomines',
	'security-restricttogroup' => 'Accesso al contento restringite al membros de "$1"',
	'restriction-read' => 'Leger',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 * @author Kenrick95
 */
$messages['id'] = array(
	'security' => 'Log pengamanan',
	'security-desc' => 'Memperkaya proteksi halaman MediaWiki untuk membatasi tampilan isi halaman',
	'security-logpage' => 'Log pengamanan',
	'security-logpagetext' => 'Ini merupakan aksi yang diblok oleh [http://www.mediawiki.org/wiki/Extension:SimpleSecurity pengaya SimpleSecurity].',
	'badaccess-read' => "'''Peringatan''': \"\$1\" merujuk ke sini, tapi Anda tidak memiliki izin yang memadai untuk mengaksesnya.",
	'security-info' => 'Ada $1 pada halaman ini',
	'security-info-toggle' => 'batasan pengamanan',
	'security-inforestrict' => '$1 terbatas pada $2',
	'security-desc-LS' => '(karena halaman ini berada di "$2 $1")',
	'security-desc-PR' => '(pasang dari tab "proteksi")',
	'security-infosysops' => 'Tidak ada batasan karena Anda anggota kelompok "sysop"',
	'security-manygroups' => 'kelompok $1 dan $2',
	'security-unchain' => 'Ubah aksi per individu',
	'security-type-category' => 'kategori',
	'security-type-namespace' => 'ruang nama',
	'security-restricttogroup' => 'Akses dibatasi untuk anggota "$1"',
	'restriction-read' => 'Baca',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'security-type-category' => 'ébéonọr',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 * @author Marco 27
 * @author Nemo bis
 */
$messages['it'] = array(
	'security' => 'Registro di sicurezza',
	'security-desc' => 'Estende la protezione delle pagine di MediaWiki per permettere di limitare la visualizzazione del contenuto di pagine',
	'security-logpage' => 'Registro di sicurezza',
	'security-logpagetext' => "Di seguito sono elencate le azioni bloccate dall'[http://www.mediawiki.org/wiki/Extension:SimpleSecurity estensione SimpleSecurity].",
	'badaccess-read' => "'''Attenzione:''' la pagina \"\$1\" è richiamata qui, ma non si dispone di permessi sufficienti per accedervi.",
	'security-info' => 'Sono presenti $1 in questa pagina',
	'security-info-toggle' => 'restrizioni di sicurezza',
	'security-inforestrict' => "L'azione $1 è limitata a $2",
	'security-desc-LS' => '(si applica perché questa pagina è in $1 "$2")',
	'security-desc-PR' => '(impostato dalla scheda "proteggi")',
	'security-infosysops' => 'Non sono applicate restrizioni perché sei un membro del gruppo "sysop"',
	'security-manygroups' => 'gruppi $1 e $2',
	'security-unchain' => 'Modificare azioni individualmente',
	'security-type-category' => 'categoria',
	'security-type-namespace' => 'namespace',
	'security-restricttogroup' => 'Accesso al contenuto riservato ai membri di "$1"',
	'restriction-read' => 'Leggi',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Whym
 */
$messages['ja'] = array(
	'security' => 'セキュリティ記録',
	'security-desc' => 'ページの閲覧を制限できるようにMediaWikiのページ保護機能を拡張する',
	'security-logpage' => 'セキュリティ記録',
	'security-logpagetext' => 'これは、[http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity 拡張機能]によって阻止された操作の記録です。',
	'badaccess-read' => '警告:「$1」はここを参照していますが、あなたにはアクセスに必要な権限がありません。',
	'security-info' => 'このページには$1があります',
	'security-info-toggle' => 'セキュリティ制限',
	'security-inforestrict' => '$1は$2に限定されています',
	'security-desc-LS' => '(この記事が「$2 $1」にあるため)',
	'security-desc-PR' => '(「保護」タブからの設定)',
	'security-infosysops' => 'あなたは「管理者」グループに所属しているため、制限は無効です',
	'security-manygroups' => 'グループ $1 および $2',
	'security-unchain' => '操作別に変更する',
	'security-type-category' => 'カテゴリ',
	'security-type-namespace' => '名前空間',
	'security-restricttogroup' => '「$1」の構成員に限定されているコンテンツにアクセスする',
	'restriction-read' => '閲覧',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'security-type-namespace' => 'លំហឈ្មោះ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'security-type-category' => 'ವರ್ಗ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'security' => 'Et Logboch övver de Beschrängkunge för et Aanloore',
	'security-desc' => 'Määt der Siggeschotz en MediaWiki esu jruuß,
dat mer och et Sigge-Aanloore ennschrängke kann.',
	'security-logpage' => 'Et Logboch övver de Beschrängkunge för et Aanloore',
	'security-logpagetext' => 'Dat hee es et Logboch met de Akßjuhne, di dat [http://www.mediawiki.org/wiki/Extension:SimpleSecurity Zosatzprojramm <i lang="en">SimpleSecurity</i>] afjeblock hät.',
	'badaccess-read' => 'Opjepaß: De Sigg „$1“ jeiht noh hee, ävver Do häs nit jenooch Rääschde för der Zohjreff doh drop.',
	'security-info' => 'Mer han $1 op dä Sigg hee',
	'security-info-toggle' => 'Beschrängkunge för et Aanloore',
	'security-inforestrict' => '$1 es beschrängk op $2',
	'security-desc-LS' => '(jelt, weil de Sigg en $2 „$1“ es)',
	'security-desc-PR' => '(jesaz övver dä Lengk „{{int:Protect}}“)',
	'security-infosysops' => 'För Disch jidd_et kein Beschrängkonge, weil De dä Metmaacher-Jropp vun de {{int:group-sysop}} bes.',
	'security-manygroups' => 'Jroppe $1 un $2',
	'security-unchain' => 'Donn de Akßjuhne einzel ändere',
	'security-type-category' => 'dä Saachjropp',
	'security-type-namespace' => 'dämm Appachtemang',
	'security-restricttogroup' => 'Aan de Saache draan dörve, di op de Metmaacher en dä Jropp „$1“ beschrängk sin',
	'restriction-read' => 'Lässe',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'security' => 'Sécherheets-Logbuch',
	'security-desc' => "Erweidert de MediaWiki-Säiteschutz fir et z'erlaben d'Kucke vum Säiteninhalt ze limitéieren",
	'security-logpage' => 'Sécherheets-Logbuch',
	'security-logpagetext' => "Dëst ass d'Logbuch vun den Aktioune vun der [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity Erweiderung].",
	'badaccess-read' => 'Opgepasst: "$1" weist heihinn, awer dir hutt net genuch Rechter fir d\'Säit ze gesinn.',
	'security-info' => 'Et sinn $1 op dëser Säit',
	'security-info-toggle' => 'Sécherheetsrestrictiounen',
	'security-inforestrict' => '$1 ass limitéiert op $2',
	'security-desc-LS' => '(gëllt well dës Säit an der "$2 $1" ass)',
	'security-desc-PR' => '(agestallt vum Tab "Protectioun")',
	'security-infosysops' => "Keng Limitatioune gëlle fir Iech wëll Dir e Member vum Grupp vun den '''Administrateure''' sidd",
	'security-manygroups' => 'Gruppen $1 a(n) $2',
	'security-unchain' => 'Aktiounen individuell änneren',
	'security-type-category' => 'Kategorie',
	'security-type-namespace' => 'Nummraum',
	'security-restricttogroup' => 'Zougang zum Inhalt limitéiert fir Membere vu(n) "$1"',
	'restriction-read' => 'Liesen',
);

/** Ganda (Luganda)
 * @author Kizito
 */
$messages['lg'] = array(
	'security-type-namespace' => 'kuŋaanyizo',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'security-type-namespace' => 'vuordu pluots',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'security' => 'Дневник на сигурност',
	'security-desc' => 'Ја дополнува заштитата на страниците „МедијаВики“, овозможувајќи ограничување на прегледувањето на содржините на страницата',
	'security-logpage' => 'Дневник на сигурност',
	'security-logpagetext' => 'Ова е дневник на дејства блокирани од [http://www.mediawiki.org/wiki/Extension:SimpleSecurity додатокот SimpleSecurity].',
	'badaccess-read' => "'''Предупредување:''' „$1“ е наведена тука, но немате доволно дозволи за да ја отворите.",
	'security-info' => 'На оваа страница има $1',
	'security-info-toggle' => 'сигурносни ограничувања',
	'security-inforestrict' => '$1 е ограничен на $2',
	'security-desc-LS' => '(важи бидејќи оваа страница се наоѓа во „$2 $1“)',
	'security-desc-PR' => '(поставено преку јазичето „заштити“)',
	'security-infosysops' => 'Не важат никакви ограничувања бидејќи вие членувате во групата „sysop“',
	'security-manygroups' => 'групите $1 и $2',
	'security-unchain' => 'Менувај дејства поединечно',
	'security-type-category' => 'категорија',
	'security-type-namespace' => 'именски простор',
	'security-restricttogroup' => 'Отвори содржина ограничена на членови на „$1“',
	'restriction-read' => 'Прочитај',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'security-type-namespace' => 'нэрний зай',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 */
$messages['ms'] = array(
	'security-type-category' => 'kategori',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'security-type-namespace' => 'лемпотмо',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 * @author Simny
 */
$messages['nb'] = array(
	'security' => 'Sikkerhetslogg',
	'security-desc' => 'Utvider MediaWiki sin funksjon for sidevern til å tillate restriksjoner mot innsyn i sideinnhold',
	'security-logpage' => 'Sikkerhetslogg',
	'security-logpagetext' => 'Dette er en handlingslogg blokkert av [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity-utvidelsen].',
	'badaccess-read' => "'''Advarsel:''' «$1» blir henvist hit, men du har ikke tilstrekkelige rettigheter til å nå den.",
	'security-info' => 'Det finnes $1 på denne siden',
	'security-info-toggle' => 'sikkerhetsrelaterte begrensninger',
	'security-inforestrict' => '$1 er avgrenset til $2',
	'security-desc-LS' => '(gjelder fordi denne siden er i «$2 $1»)',
	'security-desc-PR' => '(kan settes fra «beskytt»-fanen)',
	'security-infosysops' => 'Ingen restriksjoner er virksomme fordi du er medlem av administratorgruppen',
	'security-manygroups' => 'gruppene $1 og $2',
	'security-unchain' => 'Endre handligene individuelt',
	'security-type-category' => 'kategori',
	'security-type-namespace' => 'navnerom',
	'security-restricttogroup' => 'Tilgang til innholdet er begrenset til medlemmer av «$1»',
	'restriction-read' => 'Les',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'security' => 'Paginabeveiligingslogboek',
	'security-desc' => "Breidt de paginabescherming van MediaWiki uit door het bekijken van pagina's te beperken",
	'security-logpage' => 'Paginabeveiligingslogboek',
	'security-logpagetext' => 'Dit is een logboek met de handelingen die geblokkeerd zijn door de uitbreiding [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity].',
	'badaccess-read' => 'Waarschuwing: "$1" verwijst naar deze pagina, maar u hebt niet de toegangsrechten om deze pagina te bekijken.',
	'security-info' => 'Er zijn $1 voor deze pagina',
	'security-info-toggle' => 'beveiligingsbeperkingen',
	'security-inforestrict' => '$1 is alleen mogelijk door $2',
	'security-desc-LS' => '(van toepassing omdat deze pagina is zich in de "$2 $1" bevindt)',
	'security-desc-PR' => '(ingesteld vanuit de functie "beveiligen")',
	'security-infosysops' => 'Beperkingen zijn niet van kracht zijn omdat u lid bent van de groep beheerders',
	'security-manygroups' => 'groepen $1 en $2',
	'security-unchain' => 'Handelingen individueel wijzigen',
	'security-type-category' => 'categorie',
	'security-type-namespace' => 'naamruimte',
	'security-restricttogroup' => 'Toegang tot de inhoud is beperkt tot de leden van de groep "$1"',
	'restriction-read' => 'Lezen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'security' => 'Tryggingslogg',
	'security-desc' => 'Utvidar MediaWiki sin funksjon for sidevern til å gje høve til å sperra mot innsyn i sideinnhald',
	'security-logpage' => 'Tryggingslogg',
	'security-logpagetext' => 'Dette er ein logg over handlingar som er blokkerte av [http://www.mediawiki.org/wiki/Extension:SimpleSecurity SimpleSecurity-utvidinga].',
	'badaccess-read' => "'''Åtvaring''': «$1» er synt til her, men du har ikkje turvande løyve til å få tilgjenge.",
	'security-info' => 'Det finst $1 på denne sida',
	'security-info-toggle' => 'tryggingsrelaterte avgrensingar',
	'security-inforestrict' => '$1 er avgrensa til $2',
	'security-infosysops' => 'Ingen avgrensingar er verksame etter di du er ein medlem av administratorgruppa',
	'security-manygroups' => 'gruppene $1 og $2',
	'security-unchain' => 'Endra handlingar individuelt',
	'security-type-category' => 'kategori',
	'security-type-namespace' => 'namnerom',
	'restriction-read' => 'Les',
);

/** Occitan (Occitan)
 * @author Boulaur
 * @author Cedric31
 */
$messages['oc'] = array(
	'security' => 'Jornal de seguretat',
	'security-desc' => "Espandís l'interfàcia de proteccion de MediaWiki per permetre de restrénher la vista de las paginas",
	'security-logpage' => 'Jornal de seguretat',
	'security-logpagetext' => "Aquò es un jornal de las accions blocadas per l'[http://www.mediawiki.org/wiki/Extension:SimpleSecurity extension SimpleSecurity].",
	'badaccess-read' => 'Atencion : « $1 » es referenciat aicí, mas dispausatz pas de las autorizacions per i accedir.',
	'security-info' => 'I a $1 sus aqueste article',
	'security-info-toggle' => 'restriccions de seguretat',
	'security-inforestrict' => '$1 es limitat a $2',
	'security-desc-LS' => "(s'aplica perque aqueste article es dins lo « $1 $2 »)",
	'security-desc-PR' => "(definit dempuèi l'onglet de proteccion)",
	'security-infosysops' => 'Cap de restriccion pas en vigor perque sètz un membre del grop « administrator »',
	'security-manygroups' => 'gropes $1 e $2',
	'security-unchain' => 'Modificar las accions individualament',
	'security-type-category' => 'categoria',
	'security-type-namespace' => 'espaci de nom',
	'security-restricttogroup' => 'Accès al contengut reservat als membres de « $1 »',
	'restriction-read' => 'Legir',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'security-type-category' => 'in de Abdeeling',
	'security-type-namespace' => 'Blatznaame vun',
);

/** Polish (Polski)
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'security' => 'Rejestr zabezpieczania',
	'security-desc' => 'Dodaje do funkcjonalności zabezpieczania stron możliwość ograniczania wyświetlania zawartości strony',
	'security-logpage' => 'Rejestr zabezpieczania',
	'security-logpagetext' => 'Jest to rejestr działań zablokowanych przez [http://www.mediawiki.org/wiki/Extension:SimpleSecurity rozszerzenie SimpleSecurity].',
	'badaccess-read' => 'Uwaga – nie masz wystarczających uprawnień dla dostępu do żądanej strony „$1”.',
	'security-info' => 'Dostęp do tej strony jest $1',
	'security-info-toggle' => 'ograniczony',
	'security-inforestrict' => '$1 jest ograniczone do $2',
	'security-desc-LS' => '(ma zastosowanie, ponieważ ta strona jest w „$2 $1”)',
	'security-desc-PR' => '(ustawione poprzez zakładkę „zabezpiecz”)',
	'security-infosysops' => 'Brak obowiązujących ograniczeń, ponieważ jesteś członkiem grupy „administratorzy”.',
	'security-manygroups' => 'grup $1 oraz $2',
	'security-unchain' => 'Zmiana działania indywidualnie',
	'security-type-category' => 'kategoria',
	'security-type-namespace' => 'przestrzeń nazw',
	'security-restricttogroup' => 'Dostęp do zawartości ograniczony do członków „$1”',
	'restriction-read' => 'Czytaj',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'security' => 'Registr ëd sicurëssa',
	'security-desc' => 'A estend la protession dla pàgina ëd MediaWiki për përmëtte dë strenze la visualisassion dël contnù dla pàgina',
	'security-logpage' => 'Registr ëd sicurëssa',
	'security-logpagetext' => "Sto sì a l'é un registr ëd l'assion blocà da l'[http://www.mediawiki.org/wiki/Extension:SimpleSecurity estension SimpleSecurity].",
	'badaccess-read' => "'''Avis''': \"\$1\" a l'é riferìa sì, ma it l'has pa basta përmess për acedje.",
	'security-info' => 'A-i son $1 an dzora a sta pàgina-sì',
	'security-info-toggle' => 'restrission ëd sicurëssa',
	'security-inforestrict' => "$1 a l'é strenzùa a $2",
	'security-desc-LS' => '(a s\'àplica përchè sta pàgina-sì a l\'é "$2 $1")',
	'security-desc-PR' => '(ampòsta dal tab "protegg")',
	'security-infosysops' => 'Pa gnun-e restrission a son aplicà përchè it ses un mèmber ëd la partìa "sysop"',
	'security-manygroups' => 'partìe $1 e $2',
	'security-unchain' => 'Modìfica assion andividualment',
	'security-type-category' => 'categorìa',
	'security-type-namespace' => 'spassi nominal',
	'security-restricttogroup' => 'Vëdde contnù riservà ai mèmber ëd "$1"',
	'restriction-read' => 'Les',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'security-type-category' => 'وېشنيزه',
	'security-type-namespace' => 'نوم-تشيال',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Indech
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'security' => 'Registo de segurança',
	'security-desc' => 'Expande a protecção de páginas do MediaWiki para permitir restrições ao visionamento do conteúdo de páginas',
	'security-logpage' => 'Registo de segurança',
	'security-logpagetext' => 'Este é um registo de acções bloqueadas pela [http://www.mediawiki.org/wiki/Extension:SimpleSecurity extensão SimpleSecurity].',
	'badaccess-read' => "'''Aviso:''' \"\$1\" é referido aqui, mas não tem permissões suficientes para aceder ao registo.",
	'security-info' => 'Há $1 nesta página',
	'security-info-toggle' => 'restrições de segurança',
	'security-inforestrict' => '$1 está limitado a $2',
	'security-desc-LS' => '(aplica-se porque esta página está no "$2 $1")',
	'security-desc-PR' => '(definido a partir da "aba proteger")',
	'security-infosysops' => 'Não está em vigor nenhuma restrição porque é membro do grupo "sysop"',
	'security-manygroups' => 'grupos $1 e $2',
	'security-unchain' => 'Modificar ações individualmente',
	'security-type-category' => 'categoria',
	'security-type-namespace' => 'espaço nominal',
	'security-restricttogroup' => 'Aceder a conteúdo restrito aos membros de "$1"',
	'restriction-read' => 'Ler',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Raylton P. Sousa
 */
$messages['pt-br'] = array(
	'security' => 'Registro de segurança',
	'security-desc' => 'Extende a proteção de páginas do MediaWiki permitindo a restrição de visualização de conteúdo da página',
	'security-logpage' => 'Registro de segurança',
	'security-logpagetext' => 'Este é um registro de ações bloqueadas pela [http://www.mediawiki.org/wiki/Extension:SimpleSecurity extensão SimpleSecurity].',
	'badaccess-read' => 'Aviso: "$1" se refere à esta página, mas você não tem permissões suficientes para acessá-la.',
	'security-info' => 'Há $1 nesta página',
	'security-info-toggle' => 'restrições de segurança',
	'security-inforestrict' => '$1 é restrita a $2',
	'security-desc-LS' => '(aplica-se porque esta página está no "$2 $1")',
	'security-desc-PR' => '(definido a partir da "aba proteger")',
	'security-infosysops' => 'Nenhuma restrição está em vigor, porque você é um membro do grupo "sysop"',
	'security-manygroups' => 'grupos $1 e $2',
	'security-unchain' => 'Modificar ações individualmente',
	'security-type-category' => 'categoria',
	'security-type-namespace' => 'domínio',
	'security-restricttogroup' => 'Acessar conteúdo restrito a membros de "$1"',
	'restriction-read' => 'Ler',
);

/** Romanian (Română)
 * @author Danutz
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'security' => 'Jurnal securitate',
	'security-logpage' => 'Jurnal securitate',
	'security-type-category' => 'categorie',
	'security-type-namespace' => 'spațiu de nume',
	'restriction-read' => 'Lectură',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'security' => 'Журнал безопасности',
	'security-desc' => 'Расширяет защиту страниц MediaWiki, позволяя ограничивать просмотр содержания страницы',
	'security-logpage' => 'Журнал безопасности',
	'security-logpagetext' => 'Это журнал заблокированных действий со стороны [http://www.mediawiki.org/wiki/Extension:SimpleSecurity расширения SimpleSecurity].',
	'badaccess-read' => 'Предупреждение. «$1» ссылается сюда, но у вас нет достаточных полномочий для доступа к ней.',
	'security-info' => 'Для этой страницы существуют $1',
	'security-info-toggle' => 'ограничения, связанные с безопасностью',
	'security-inforestrict' => '$1 запрещён для $2',
	'security-desc-LS' => '(применено, так как эта страница находится в «$2 $1»)',
	'security-desc-PR' => '(установлено через вкладку «защитить»)',
	'security-infosysops' => 'Ограничения не действуют, так как вы являетесь членом группы «sysop»',
	'security-manygroups' => 'групп $1 и $2',
	'security-unchain' => 'Изменить действия в индивидуальном порядке',
	'security-type-category' => 'категории',
	'security-type-namespace' => 'пространстве имён',
	'security-restricttogroup' => 'Доступ к содержимому ограничен членами «$1»',
	'restriction-read' => 'Чтение',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'security-type-category' => 'катеґорія',
	'security-type-namespace' => 'простор назв',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'security' => 'Bezpečnostný záznam',
	'security-desc' => 'Rozširuje zamykanie stránok MediaWiki o možnosť obmedziť zobrazovanie obsahu článku',
	'security-logpage' => 'Bezpečnostný záznam',
	'security-logpagetext' => 'Toto je záznam operácií, ktoré zablokovalo [http://www.mediawiki.org/wiki/Extension:SimpleSecurity rozšírenie SimpleSecurity].',
	'badaccess-read' => 'Upozornenie: odkazuje sa tu na „$1“, ale nemáte dostatočné oprácnenia na prístup k nemu.',
	'security-info' => 'Táto stránka má $1',
	'security-info-toggle' => 'bezpečnostné obmedzenia',
	'security-inforestrict' => '$1 nemá povolené $2',
	'security-desc-LS' => '(týka sa tejto stránky, pretože je na „$2 $1“)',
	'security-desc-PR' => '(nastavené zo „záložky zamykania“)',
	'security-infosysops' => 'Žiadne obmedzenia nie sú účinné, pretože ste členom skupiny „sysop“',
	'security-manygroups' => 'skupiny $1 a $2',
	'security-unchain' => 'Zmeniť operácie samostatne',
	'security-type-category' => 'kategória',
	'security-type-namespace' => 'menný priestor',
	'security-restricttogroup' => 'Prístup k obsahu obmedzenému len pre členov skupiny „$1“',
);

/** Somali (Soomaaliga)
 * @author Maax
 */
$messages['so'] = array(
	'security-type-category' => 'qeybta',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'security-info-toggle' => 'сигурносна ограничења',
	'security-manygroups' => 'групе $1 и $2',
	'security-type-category' => 'категорија',
	'security-type-namespace' => 'именски простор',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'security-info-toggle' => 'sigurnosna ograničenja',
	'security-manygroups' => 'grupe $1 i $2',
	'security-type-category' => 'kategorija',
	'security-type-namespace' => 'imenski prostor',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author Per
 * @author Rotsee
 */
$messages['sv'] = array(
	'security' => 'Säkerhetslogg',
	'security-desc' => 'Utökar MediaWikis sidskydd genom att tillåta begränsning av att sidinnehållet visas.',
	'security-logpage' => 'Säkerhetslogg',
	'security-info' => 'Det finns $1 på denna sida',
	'security-info-toggle' => 'säkerhetsbegränsningar',
	'security-inforestrict' => '$1 är begränsad till $2',
	'security-infosysops' => 'Inga restriktioner är aktiva eftersom du tillhör gruppen "Administratörer"',
	'security-manygroups' => 'grupperna $1 och $2',
	'security-unchain' => 'Ändra åtgärderna individuellt',
	'security-type-category' => 'kategori',
	'security-type-namespace' => 'namnrymd',
	'security-restricttogroup' => 'Tillgång till innehållet är begränsat till medlemmar av "$1"',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'security-info-toggle' => 'భద్రతా నియంత్రణలు',
	'security-desc-LS' => '(ఈ పుట "$2 $1"లో ఉన్నందున వర్తిస్తుంది)',
	'security-type-category' => 'వర్గం',
	'security-type-namespace' => 'పేరుబరి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'security-type-category' => 'kategoria',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'security-type-namespace' => 'เนมสเปซ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'security-type-category' => 'kategoriýa',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'security' => 'Talaang pangkaligtasan',
	'security-desc' => 'Nagdurugtong sa pag-iingat ng pahina ng MediaWiki upang pahintulutan ang pagbibigay ng hangganan sa pagtingin ng nilalaman ng pahina',
	'security-logpage' => 'Talaang pangkaligtasan',
	'security-logpagetext' => 'Isa itong talaan ng mga kilos na hinadlangan ng [http://www.mediawiki.org/wiki/Extension:SimpleSecurity karugtong na Kaligtasang Payak].',
	'badaccess-read' => 'Babala: isinangguni rito ang "$1", subalit wala kang sapat na mga kapahintulutan upang mapuntahan ito.',
	'security-info' => 'Mayroon mga $1 sa ibabaw ng pahinang ito',
	'security-info-toggle' => 'mga hangganang pangkaligtasan',
	'security-inforestrict' => 'Nakahangga ang $1 sa $2',
	'security-desc-LS' => "(naaangkop dahil nasa loob ng '''$2 $1''' ang pahinang ito)''",
	'security-desc-PR' => '(itinakda mula sa panglaylay na "pangpananggalang")',
	'security-infosysops' => 'Walang umiiral na mga paghahangga dahil isa kang kasapi ng pangkat na "tagapagpaandar ng sistema"',
	'security-manygroups' => 'mga pangkat na $1 at $2',
	'security-unchain' => 'Baguhin na paisa-isa ang mga galaw',
	'security-type-category' => 'kaurian',
	'security-type-namespace' => 'espasyo ng pangalan',
	'security-restricttogroup' => 'Puntahan ang nilalaman na nakalaan lamang para sa mga kasapi ng "$1"',
	'restriction-read' => 'Basahin',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'security' => 'Güvenlik günlüğü',
	'security-logpage' => 'Güvenlik kaydı',
	'security-info' => 'Bu sayfada $1 mevcut',
	'security-info-toggle' => 'güvenlik kısıtlamaları',
	'security-desc-PR' => '("koruma" sekmesinden ayarla)',
	'security-unchain' => 'İşlemleri ayrı ayrı değiştir',
	'security-type-namespace' => 'ad alanı',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'security' => 'Журнал безпеки',
	'security-desc' => 'Розширює захист сторінок MediaWiki, дозволяючи обмежувати перегляд вмісту сторінки',
	'security-logpage' => 'Журнал безпеки',
	'security-logpagetext' => 'Це журнал дій, заблокованих [http://www.mediawiki.org/wiki/Extension:SimpleSecurity розширенням SimpleSecurity].',
	'security-info' => 'На цій сторінці діють $1',
	'security-info-toggle' => 'обмеження для забезпечення безпеки',
	'security-inforestrict' => '$1 обмежений для $2',
	'security-type-category' => 'категорія',
	'security-type-namespace' => 'простір назв',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'security-type-category' => 'kategorii',
	'security-type-namespace' => 'nimiavaruz',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Trần Nguyễn Minh Huy
 */
$messages['vi'] = array(
	'security' => 'Nhật trình bảo mật',
	'security-logpage' => 'Nhật trình bảo mật',
	'security-info' => 'Có $1 tại trang này',
	'security-info-toggle' => 'hạn chế an toàn',
	'security-manygroups' => 'các nhóm $1 và $2',
	'security-type-category' => 'thể loại',
	'security-type-namespace' => 'không gian tên',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'badaccess-read' => "'''ווארענונג:''' \"\$1\" ווערט אָנגעוויזן אַהער, אבער איר האט נישט גענוג דערלויבנישן צו האָבן צוטריט צו אים.",
	'security-type-category' => 'קאַטעגאריע',
	'security-type-namespace' => 'נאָמענטייל',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Liangent
 * @author PhiLiP
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'security-type-category' => '分类',
	'security-type-namespace' => '名字空间',
	'restriction-read' => '读',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'security-type-category' => '分類',
	'security-type-namespace' => '名字空間',
	'restriction-read' => '讀',
);

