<?php
/**
 * Internationalization file for the DeleteBatch extension.
 *
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 */
$messages['en'] = array(
	'deletebatch' => 'Delete batch of pages',
	'deletebatch-desc' => '[[Special:DeleteBatch|Delete a batch of pages]]',
	'deletebatch-button' => 'Delete',
	'deletebatch-here' => '<b>here</b>',
	'deletebatch-help' => 'Delete a batch of pages. You can either perform a single delete, or delete pages listed in a file.
Choose a user that will be shown in deletion logs.
Uploaded file should contain page name and optional reason separated by a "|" character in each line.',
	'deletebatch-caption' => 'Page list',
	'deletebatch-title' => 'Delete batch',
	'deletebatch-link-back' => 'Go back to the special page ',
	'deletebatch-as' => 'Run the script as',
	'deletebatch-both-modes' => 'Please choose either one specified page or a given list of pages.',
	'deletebatch-or' => '<b>or</b>',
	'deletebatch-page' => 'Pages to be deleted',
	'deletebatch-reason' => 'Reason for deletion',
	'deletebatch-processing' => 'deleting pages ',
	'deletebatch-from-file' => 'from file list',
	'deletebatch-from-form' => 'from form',
	'deletebatch-success-subtitle' => 'for $1',
	'deletebatch-link-back' => 'You can go back to the extension ',
	'deletebatch-omitting-nonexistant' => 'Omitting non-existing page $1.',
	'deletebatch-omitting-invalid' => 'Omitting invalid page $1.',
	'deletebatch-file-bad-format' => 'The file should be plain text',
	'deletebatch-file-missing' => 'Unable to read given file',
	'deletebatch-select-script' => 'delete page script',
	'deletebatch-select-yourself' => 'you',
	'deletebatch-no-page' => 'Please specify at least one page to delete OR choose a file containing page list.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'deletebatch'                      => 'حذف باتش من الصفحات',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|حذف باتش من الصفحات]]',
	'deletebatch-button'               => 'حذف',
	'deletebatch-here'                 => '<b>هنا</b>',
	'deletebatch-help'                 => 'حذف باتش من الصفحات. يمكنك إما عمل عملية حذف واحدة، أو حذف الصفحات المرتبة في ملف.
اختر مستخدما ليتم عرضه في سجلات الحذف.
الملف المرفوع ينبغي أن يحتوي على اسم الصفحة وسبب اختياري مفصولين بواسطة حرف "|" في كل سطر.',
	'deletebatch-caption'              => 'قائمة الصفحات',
	'deletebatch-title'                => 'حذف الباتش',
	'deletebatch-link-back'            => 'يمكنك العودة إلى الامتداد',
	'deletebatch-as'                   => 'تشغيل السكريبت ك',
	'deletebatch-both-modes'           => 'من فضلك اختر إما صفحة واحدة أو قائمة معطاة من الصفحات.',
	'deletebatch-or'                   => '<b>أو</b>',
	'deletebatch-page'                 => 'الصفحات للحذف',
	'deletebatch-reason'               => 'سبب الحذف',
	'deletebatch-processing'           => 'جاري حذف الصفحات',
	'deletebatch-from-file'            => 'من قائمة ملف',
	'deletebatch-from-form'            => 'من من',
	'deletebatch-success-subtitle'     => 'ل$1',
	'deletebatch-omitting-nonexistant' => 'إزالة صفحة غير موجودة $1.',
	'deletebatch-omitting-invalid'     => 'إزالة صفحة غير صحيحة $1.',
	'deletebatch-file-bad-format'      => 'الملف ينبغي أن يكون نصا خالصا',
	'deletebatch-file-missing'         => 'غير قادر على قراءة الملف المعطى',
	'deletebatch-select-script'        => 'سكريبت حذف الصفحات',
	'deletebatch-select-yourself'      => 'أنت',
	'deletebatch-no-page'              => 'من فضلك اختر على الأقل صفحة واحدة للحذف أو اختر ملفا يحتوي على قائمة الصفحات.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'deletebatch-button'           => 'ИЗТРИВАНЕ',
	'deletebatch-here'             => '<b>тук</b>',
	'deletebatch-as'               => 'Стартиране на скрипта като',
	'deletebatch-or'               => '<b>ИЛИ</b>',
	'deletebatch-success-subtitle' => 'за $1',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'deletebatch-button'           => 'FORIGI',
	'deletebatch-here'             => '<b>ĉi tie</b>',
	'deletebatch-caption'          => 'Paĝlisto',
	'deletebatch-or'               => '<b>AŬ</b>',
	'deletebatch-from-file'        => 'de dosierlisto',
	'deletebatch-from-form'        => 'de paĝo',
	'deletebatch-success-subtitle' => 'por $1',
	'deletebatch-select-yourself'  => 'vi',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'deletebatch'                      => 'Poista useita sivuja',
	'deletebatch-button'               => 'POISTA',
	'deletebatch-here'                 => '<b>täällä</b>',
	'deletebatch-help'                 => 'Poista useita sivuja. Voit joko tehdä yhden poiston tai poistaa tiedostossa listatut sivut. Valitse käyttäjä, joka näytetään poistolokeissa. Tallennetun tiedoston tulisi sisältää sivun nimi ja vapaaehtoinen syy | -merkin erottamina joka rivillä.',
	'deletebatch-caption'              => 'Sivulista',
	'deletebatch-title'                => 'Poista useita sivuja',
	'deletebatch-link-back'            => 'Voit palata lisäosaan ',
	'deletebatch-as'                   => 'Suorita skripti käyttäjänä',
	'deletebatch-both-modes'           => 'Valitse joko määritelty sivu tai annettu lista sivuista.',
	'deletebatch-or'                   => '<b>TAI</b>',
	'deletebatch-page'                 => 'Poistettavat sivut',
	'deletebatch-reason'               => 'Poiston syy',
	'deletebatch-processing'           => 'poistetaan sivuja ',
	'deletebatch-from-file'            => 'tiedostolistasta',
	'deletebatch-from-form'            => 'lomakkeesta',
	'deletebatch-omitting-nonexistant' => 'Ohitetaan olematon sivu $1.',
	'deletebatch-omitting-invalid'     => 'Ohitetaan kelpaamaton sivu $1.',
	'deletebatch-file-bad-format'      => 'Tiedoston tulisi olla raakatekstiä',
	'deletebatch-file-missing'         => 'Ei voi lukea annettua tiedostoa',
	'deletebatch-select-script'        => 'sivunpoistoskripti',
	'deletebatch-select-yourself'      => 'sinä',
	'deletebatch-no-page'              => 'Määrittele ainakin yksi poistettava sivu TAI valitse tiedosto, joka sisältää sivulistan.',
);

/** French (Français)
 * @author Grondin
 */
$messages['fr'] = array(
	'deletebatch'                      => 'Lot de suppression des pages',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Supprime un lot de pages]]',
	'deletebatch-button'               => 'SUPPRIMER',
	'deletebatch-here'                 => '<b>ici</b>',
	'deletebatch-help'                 => 'Supprime un lot de pages. Vous pouvez soit lancer une simple suppression, soit supprimer des pages listées dans un fichier.
Choisissez un utilisateur qui sera affiché dans le journal des suppressions.
Un fichier importé pourra contenir un nom de la page et un motif facultatif séparé par un « | » dans chaque ligne.',
	'deletebatch-caption'              => 'Liste de la page',
	'deletebatch-title'                => 'Supprimer en lot',
	'deletebatch-link-back'            => 'Vous pouvez revenir à l’extension',
	'deletebatch-as'                   => 'Lancer le script comme',
	'deletebatch-both-modes'           => 'Veuillez choisir, soit une des pages indiquées, soit une liste donnée de pages.',
	'deletebatch-or'                   => '<b>OU</b>',
	'deletebatch-page'                 => 'Pages à supprimer',
	'deletebatch-reason'               => 'Motif de la suppression',
	'deletebatch-processing'           => 'suppression des pages',
	'deletebatch-from-file'            => 'depuis la liste d’un fichier',
	'deletebatch-from-form'            => 'à partir du formulaire',
	'deletebatch-success-subtitle'     => 'pour « $1 »',
	'deletebatch-omitting-nonexistant' => 'Omission de la page « $1 » inexistante.',
	'deletebatch-omitting-invalid'     => 'Omission de la page « $1 » incorrecte.',
	'deletebatch-file-bad-format'      => 'Le fichier doit être en texte simple',
	'deletebatch-file-missing'         => 'Impossible de lire le fichier donné',
	'deletebatch-select-script'        => 'supprimer le script de la page',
	'deletebatch-select-yourself'      => 'vous',
	'deletebatch-no-page'              => 'Veuillez indiquer au moins une page à supprimer OU un fichier donné contenant une liste de pages.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'deletebatch'                      => 'Borrar un conxunto de páxinas',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Borrar un conxunto de páxinas]]',
	'deletebatch-button'               => 'BORRAR',
	'deletebatch-here'                 => '<b>aquí</b>',
	'deletebatch-help'                 => 'Borrar un conxunto de páxinas. Pode levar a cabo un borrado único ou borrar as páxinas listadas nun ficheiro.
Escolla o usuario que será amosado nos rexistros de borrado.
O ficheiro cargado debería conter o nome da páxina e unha razón opcional separados por un carácter de barra vertical ("|") en cada liña.',
	'deletebatch-caption'              => 'Lista da páxina',
	'deletebatch-title'                => 'Borrar un conxunto',
	'deletebatch-link-back'            => 'Pode voltar á extensión',
	'deletebatch-as'                   => 'Executar o guión como',
	'deletebatch-both-modes'           => 'Por favor, escolla unha páxina específica ou unha lista de páxinas dadas.',
	'deletebatch-or'                   => '<b>OU</b>',
	'deletebatch-page'                 => 'Páxinas para ser borradas',
	'deletebatch-reason'               => 'Razón para o borrado',
	'deletebatch-processing'           => 'borrando a páxina',
	'deletebatch-from-file'            => 'da lista de ficheiros',
	'deletebatch-from-form'            => 'do formulario',
	'deletebatch-success-subtitle'     => 'de $1',
	'deletebatch-omitting-nonexistant' => 'Omitindo a páxina $1, que non existe.',
	'deletebatch-omitting-invalid'     => 'Omitindo a páxina inválida $1.',
	'deletebatch-file-bad-format'      => 'O ficheiro debería ser un texto sinxelo',
	'deletebatch-file-missing'         => 'Non se pode ler o ficheiro dado',
	'deletebatch-select-script'        => 'borrar o guión dunha páxina',
	'deletebatch-select-yourself'      => 'vostede',
	'deletebatch-no-page'              => 'Por favor, especifique, polo menos, unha páxina para borrar OU escolla un ficheiro que conteña unha lista de páxinas.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'deletebatch-button' => 'Deler',
	'deletebatch-reason' => 'Motivo pro deletion',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 */
$messages['km'] = array(
	'deletebatch-reason'           => 'មូលហេតុនៃការលុប',
	'deletebatch-processing'       => 'ការលុបទំព័រ',
	'deletebatch-success-subtitle' => 'សំរាប់$1',
	'deletebatch-select-yourself'  => 'អ្នក',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'deletebatch'                      => 'Rei vu Säite läschen',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Läscht eng Rei Säiten]]',
	'deletebatch-button'               => 'LÄSCHEN',
	'deletebatch-here'                 => '<b>hei</b>',
	'deletebatch-caption'              => 'Lëscht vun der Säit',
	'deletebatch-title'                => 'Zesumme läschen',
	'deletebatch-link-back'            => "Dir kënnt op d'Erweiderung zréckgoen",
	'deletebatch-or'                   => '<b>ODER</b>',
	'deletebatch-page'                 => 'Säite fir ze läschen',
	'deletebatch-reason'               => 'Grond fir ze läschen',
	'deletebatch-processing'           => "d'Säite gi geläscht",
	'deletebatch-from-file'            => 'vun der Lëscht vun engem Fichier',
	'deletebatch-from-form'            => 'vum Formulaire',
	'deletebatch-success-subtitle'     => 'fir $1',
	'deletebatch-omitting-nonexistant' => "D'Säit $1 déi et net gëtt iwwersprangen.",
	'deletebatch-omitting-invalid'     => 'Déi ongëlteg Säit $1 iwwersprangen.',
	'deletebatch-select-script'        => 'de Script vun der Säit läschen',
	'deletebatch-select-yourself'      => 'Dir',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'deletebatch-button' => 'Ticpolōz',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'deletebatch'                      => 'Paginareeks verwijderen',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Paginareeks verwijderen]]',
	'deletebatch-button'               => 'VERWIJDEREN',
	'deletebatch-here'                 => '<b>hier</b>',
	'deletebatch-help'                 => 'Een lijst pagina\'s verwijderen.
U kunt een enkele pagina verwijderen of een lijst van pagina\'s in een bestand.
Kies een gebruiker die in het verwijderlogboek wordt genoemd.
Het bestand dat u uploadt moet op iedere regel een paginanaam en een reden bevatten (optioneel), gescheiden door het karakter "|".',
	'deletebatch-caption'              => 'Paginalijst',
	'deletebatch-title'                => 'Reeks verwijderen',
	'deletebatch-link-back'            => 'Teruggaan naar de uitbreiding',
	'deletebatch-as'                   => 'Script uitvoeren als',
	'deletebatch-both-modes'           => "Kies een bepaalde pagina of geef een list met pagina's op.",
	'deletebatch-or'                   => '<b>OF</b>',
	'deletebatch-page'                 => "Te verwijderen pagina's",
	'deletebatch-reason'               => 'Reden voor verwijderen',
	'deletebatch-processing'           => "bezig met het verwijderen van pagina's",
	'deletebatch-from-file'            => 'van een lijst uit een bestand',
	'deletebatch-from-form'            => 'uit het formulier',
	'deletebatch-success-subtitle'     => 'voor $1',
	'deletebatch-omitting-nonexistant' => 'Niet-bestaande pagina $1 is overgeslagen.',
	'deletebatch-omitting-invalid'     => 'Ongeldige paginanaam $1 is overgeslagen.',
	'deletebatch-file-bad-format'      => 'Het bestand moet platte tekst bevatten',
	'deletebatch-file-missing'         => 'Het bestnad kan niet gelezen worden',
	'deletebatch-select-script'        => "script pagina's verwijderen",
	'deletebatch-select-yourself'      => 'u',
	'deletebatch-no-page'              => "Geef tenminste één te verwijderen pagina op of kies een bestand dat de lijst met pagina's bevat.",
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'deletebatch'                      => 'Slett mange sider',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Slett mange sider]]',
	'deletebatch-button'               => 'Slett',
	'deletebatch-here'                 => '<b>her</b>',
	'deletebatch-help'                 => 'Slett en serie av sider. Du kan også utføre en enkel sletting, eller slette sider listet opp i en fil.
Velg en bruker som skal vises i slettingsloggen.
En opplastet fil må inneholde navnet på siden, og kan også ha en valgfri slettingsgrunn skilt fra tittelen med «|».',
	'deletebatch-caption'              => 'Sideliste',
	'deletebatch-title'                => 'Slett serie',
	'deletebatch-link-back'            => 'Du kan gå tilbake til utvidelsen',
	'deletebatch-as'                   => 'Kjør skriptet som',
	'deletebatch-both-modes'           => 'Velg én side eller en liste over sider.',
	'deletebatch-or'                   => '<b>eller</b>',
	'deletebatch-page'                 => 'Sider som skal slettes',
	'deletebatch-reason'               => 'Slettingsårsak',
	'deletebatch-processing'           => 'sletter sider',
	'deletebatch-from-file'            => 'fra filliste',
	'deletebatch-from-form'            => 'fra skjema',
	'deletebatch-success-subtitle'     => 'for $1',
	'deletebatch-omitting-nonexistant' => 'Utelater den ikke-eksisterende siden $1.',
	'deletebatch-omitting-invalid'     => 'Utelater den ugyldige siden $1.',
	'deletebatch-file-bad-format'      => 'Filen bør inneholde ren tekst',
	'deletebatch-file-missing'         => 'Kunne ikke lese filen',
	'deletebatch-select-script'        => 'slett sideskript',
	'deletebatch-select-yourself'      => 'du',
	'deletebatch-no-page'              => 'Vennligst oppgi minst én side å slette eller velg en fil med en liste av sider.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'deletebatch'                      => 'Lòt de supression de las paginas',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Suprimís un lòt de paginas]]',
	'deletebatch-button'               => 'SUPRIMIR',
	'deletebatch-here'                 => '<b>aicí</b>',
	'deletebatch-help'                 => 'Suprimís un lòt de paginas. Podètz siá aviar una supression simpla, siá suprimir de paginas listadas dins un fichièr.
Causissètz un utilizaire que serà afichat dins lo jornal de las supressions.
Un fichièr importat poirà conténer un nom de la pagina e un motiu facultatiu separat per un « | » dins cada linha.',
	'deletebatch-caption'              => 'Tièra de la pagina',
	'deletebatch-title'                => 'Suprimir en lòt',
	'deletebatch-link-back'            => 'Podètz tornar a l’extension',
	'deletebatch-as'                   => "Aviar l'escript coma",
	'deletebatch-both-modes'           => 'Causissètz, siá una de las paginas indicadas, siá una tièra donada de paginas.',
	'deletebatch-or'                   => '<b>o</b>',
	'deletebatch-page'                 => 'Paginas de suprimir',
	'deletebatch-reason'               => 'Motiu de la supression',
	'deletebatch-processing'           => 'supression de las paginas',
	'deletebatch-from-file'            => 'dempuèi la tièra d’un fichièr',
	'deletebatch-from-form'            => 'a partir del formulari',
	'deletebatch-success-subtitle'     => 'per « $1 »',
	'deletebatch-omitting-nonexistant' => 'Omission de la pagina « $1 » inexistenta.',
	'deletebatch-omitting-invalid'     => 'Omission de la pagina « $1 » incorrècta.',
	'deletebatch-file-bad-format'      => 'Lo fichièr deu èsser en tèxt simple',
	'deletebatch-file-missing'         => 'Impossible de legir lo fichièr donat',
	'deletebatch-select-script'        => "suprimir l'escript de la pagina",
	'deletebatch-select-yourself'      => 'vos',
	'deletebatch-no-page'              => 'Indicatz al mens una pagina de suprimir O un fichièr donat que conten una tièra de paginas.',
);

/** Polish (Polski)
 * @author Airwolf
 * @author Sp5uhe
 * @author Maikking
 */
$messages['pl'] = array(
	'deletebatch'                      => 'Usuń grupę stron',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Usuń grupę stron]]',
	'deletebatch-button'               => 'Usuń',
	'deletebatch-here'                 => '<b>tutaj</b>',
	'deletebatch-help'                 => 'Usuwanie grupy stron. Strony możesz usuwać pojedynczo lub poprzez usunięcie grupy stron, wymienionych w pliku.
Wybierz użytkownika, który będzie widoczny w logu stron usuniętych.
Przesyłany plik powinien zawierać nazwę strony i powód usunięcia w jednej linii tekstu, przedzielone symbolem "|".',
	'deletebatch-caption'              => 'Lista stron',
	'deletebatch-title'                => 'Usuń grupę stron',
	'deletebatch-link-back'            => 'Cofnij do usuwania grup stron',
	'deletebatch-as'                   => 'Uruchom skrypt jako',
	'deletebatch-both-modes'           => 'Wybierz jedną stronę albo grupę stron.',
	'deletebatch-or'                   => '<b>lub</b>',
	'deletebatch-page'                 => 'Lista stron do usunięcia',
	'deletebatch-reason'               => 'Powód usunięcia',
	'deletebatch-processing'           => 'usuwanie stron',
	'deletebatch-from-file'            => 'z listy zawartej w pliku',
	'deletebatch-from-form'            => 'z',
	'deletebatch-success-subtitle'     => 'dla $1',
	'deletebatch-omitting-nonexistant' => 'Pominięto nieistniejącą stronę $1.',
	'deletebatch-omitting-invalid'     => 'Pominięto niewłaściwą stronę $1.',
	'deletebatch-file-bad-format'      => 'Plik powinien zawierać wyłącznie tekst',
	'deletebatch-file-missing'         => 'Nie można odczytać pliku',
	'deletebatch-select-script'        => 'usuwanie stron',
	'deletebatch-select-yourself'      => 'Ty',
	'deletebatch-no-page'              => 'Wybierz pojedynczą stronę do usunięcia ALBO wybierz plik zawierający listę stron.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'deletebatch-button'           => 'Şterge',
	'deletebatch-here'             => '<b>aici</b>',
	'deletebatch-or'               => '<b>sau</b>',
	'deletebatch-page'             => 'Pagini de şters',
	'deletebatch-reason'           => 'Motiv pentru ştergere',
	'deletebatch-processing'       => 'ştergere pagini',
	'deletebatch-from-form'        => 'din formular',
	'deletebatch-success-subtitle' => 'pentru $1',
	'deletebatch-file-missing'     => 'Nu se poate citi fişierul dat',
);

/** Russian (Русский)
 * @author Innv
 */
$messages['ru'] = array(
	'deletebatch-button'           => 'Удалить',
	'deletebatch-success-subtitle' => 'для $1',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'deletebatch'                      => 'Zmazanie viacerých stránok',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Zmazanie viacerých stránok]]',
	'deletebatch-button'               => 'ZMAZAŤ',
	'deletebatch-here'                 => '<b>tu</b>',
	'deletebatch-help'                 => 'Zmazanie viacerých stránok. Môžete buď vykonať jedno zmazanie alebo zmazať stránky uvedené v súbore.
Vyberte, ktorý používateľ sa zobrazí v záznamoch zmazania.
Nahraný súbor by mal na každom riadku obsahovať názov stránky a nepovinne aj dôvod zmazania oddelený znakom „|”.',
	'deletebatch-caption'              => 'Zoznam stránok',
	'deletebatch-title'                => 'Zmazať dávku',
	'deletebatch-link-back'            => 'Môžete sa vrátiť späť na rozšírenie',
	'deletebatch-as'                   => 'Spustiť skript ako',
	'deletebatch-both-modes'           => 'Prosím, vyberte buď zadanú stránku alebo zadaý zoznam stránok.',
	'deletebatch-or'                   => '<b>ALEBO</b>',
	'deletebatch-page'                 => 'Stránky, ktoré budú zmazané',
	'deletebatch-reason'               => 'Dôvod zmazania',
	'deletebatch-processing'           => 'mažú sa stránky',
	'deletebatch-from-file'            => 'zo zoznamu v súbore',
	'deletebatch-from-form'            => 'z formulára',
	'deletebatch-success-subtitle'     => 'z $1',
	'deletebatch-omitting-nonexistant' => 'Vynecháva sa neexistujúca stránka $1.',
	'deletebatch-omitting-invalid'     => 'Vynecháva sa neplatná stránka $1.',
	'deletebatch-file-bad-format'      => 'Súbor by mal byť textovom formáte',
	'deletebatch-file-missing'         => 'Nebolo možné prečítať zadaný súbor',
	'deletebatch-select-script'        => 'skript na zmazanie stránok',
	'deletebatch-select-yourself'      => 'vy',
	'deletebatch-no-page'              => 'Prosím, zadajte aspoň jednu stránku, ktorá sa má zmazať ALEBO súbor obsahujúci zoznam stránok.',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'deletebatch'                      => 'Radera serier av sidor',
	'deletebatch-desc'                 => '[[Special:DeleteBatch|Radera en serie av sidor]]',
	'deletebatch-button'               => 'RADERA',
	'deletebatch-here'                 => '<b>här</b>',
	'deletebatch-help'                 => 'Radera en serie av sidor. Du kan också utföra en ensam radering, eller radera sidor listade i en fil.
Välj en användare som kommer att visas i raderingsloggen.
En uppladdad fil ska innehålla sidnamn och en valfri anledning separerade med ett "|"-tecken på varje rad.',
	'deletebatch-caption'              => 'Sidlista',
	'deletebatch-title'                => 'Radera serie',
	'deletebatch-link-back'            => 'Du kan gå tillbaka till tillägget',
	'deletebatch-as'                   => 'Kör skriptet som',
	'deletebatch-both-modes'           => 'Var god välj antingen en specifierad sida eller en lista över sidor.',
	'deletebatch-or'                   => '<b>ELLER</b>',
	'deletebatch-page'                 => 'Sidor som ska raderas',
	'deletebatch-reason'               => 'Anledning för radering',
	'deletebatch-processing'           => 'raderar sidor',
	'deletebatch-from-file'            => 'från fillistan',
	'deletebatch-from-form'            => 'från formulär',
	'deletebatch-success-subtitle'     => 'för $1',
	'deletebatch-omitting-nonexistant' => 'Utelämna ej existerande sida $1.',
	'deletebatch-omitting-invalid'     => 'Utelämna ogiltig sida $1.',
	'deletebatch-file-bad-format'      => 'Filen ska innehålla ren text',
	'deletebatch-file-missing'         => 'Kan inte läsa filen',
	'deletebatch-select-script'        => 'radera sidskript',
	'deletebatch-select-yourself'      => 'du',
	'deletebatch-no-page'              => 'Var god specifiera minst en sida för att radera ELLER välj en fil innehållande en sidlista.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'deletebatch-here'    => '<b>ఇక్కడ</b>',
	'deletebatch-caption' => 'పేజీల జాబితా',
	'deletebatch-or'      => '<b>లేదా</b>',
	'deletebatch-page'    => 'తొలగించాల్సిన పేజీలు',
	'deletebatch-reason'  => 'తొలగింపునకు కారణం',
);

/** Ukrainian (Українська)
 * @author AS
 */
$messages['uk'] = array(
	'deletebatch'                  => 'Вилучення сторінок групами',
	'deletebatch-desc'             => '[[Special:DeleteBatch|Вилучення сторінок групами]]',
	'deletebatch-button'           => 'Вилучити',
	'deletebatch-here'             => '<b>тут</b>',
	'deletebatch-help'             => 'Вилучення групи сторінок. Також ви можете зробити окреме вилучення, або вилучити сторінки, перераховані у файлі.
Виберіть користувача, який згадуватиметься у журналі вилучень.
Завантажений файл повинен містити у кожному рядку назву сторінки та необов\'язкову причину вилучення, відокремлену символом "|".',
	'deletebatch-caption'          => 'Перелік сторінок',
	'deletebatch-title'            => 'Вилучити групу',
	'deletebatch-link-back'        => 'Ви можете повернутися до розширення',
	'deletebatch-as'               => 'Запустити скрипт як',
	'deletebatch-both-modes'       => 'Виберіть або одну вказану сторінку, або наданий список сторінок.',
	'deletebatch-or'               => '<b>або</b>',
	'deletebatch-page'             => 'Сторінки до вилучення',
	'deletebatch-reason'           => 'Причина вилучення',
	'deletebatch-processing'       => 'вилучення сторінок',
	'deletebatch-from-file'        => 'із списку файла',
	'deletebatch-success-subtitle' => 'для $1',
	'deletebatch-file-missing'     => 'Не в змозі прочитати наданий файл',
	'deletebatch-select-yourself'  => 'ви',
);

