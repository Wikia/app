<?php
/**
 * Internationalisation file for extension PagedTiffHandler.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English (English)
 * @author Hallo Welt! - Medienwerkstatt GmbH
 */
$messages['en'] = array(
	'tiff-desc' => 'Handler for viewing TIFF files in image mode',
	'tiff_no_metadata' => 'Cannot get metadata from TIFF',
	'tiff_page_error' => 'Page number not in range',
	'tiff_too_many_embed_files' => 'The image contains too many embedded files.',
	'tiff_sourcefile_too_large' => 'The resolution of the source file is too large.
No thumbnail will be generated.',
	'tiff_targetfile_too_large' => 'The resolution of the target file is too large.
No thumbnail will be generated.',
	'tiff_file_too_large' => 'The uploaded file is too large and was rejected.',
	'tiff_out_of_service' => 'The uploaded file could not be processed.
ImageMagick is not available.',
	'tiff_too_much_meta' => 'Metadata uses too much space.',
	'tiff_error_cached' => 'This file can only be rerendered after the caching interval.',
	'tiff_size_error' => 'The reported file size does not match the actual file size.',
	'tiff_script_detected' => 'The uploaded file contains scripts.',
	'tiff_bad_file' => 'The uploaded file contains errors: $1',
	'tiff-file-info-size' => '$1 × $2 pixels, file size: $3, MIME type: $4, $5 {{PLURAL:$5|page|pages}}',
 );

/** Message documentation (Message documentation)
 * @author Hallo Welt! - Medienwerkstatt GmbH
 */
$messages['qqq'] = array(
	'tiff-desc' => 'Short description of the extension, shown in [[Special:Version]]. Do not translate or change links.',
	'tiff_no_metadata' => 'Error message shown when no metadata extraction is not possible',
	'tiff_page_error' => 'Error message shown when page number is out of range',
	'tiff_too_many_embed_files' => 'Error message shown when the uploaded image contains too many embedded files.',
	'tiff_sourcefile_too_large' => 'Error message shown when the resolution of the source file is too large.',
	'tiff_targetfile_too_large' => 'Error message shown when the resolution of the target file is too large.',
	'tiff_file_too_large' => 'Error message shown when the uploaded file is too large.',
	'tiff_out_of_service' => 'Error message shown when the uploaded file could not be processed by external renderer (ImageMagick).',
	'tiff_too_much_meta' => 'Error message shown when the metadata uses too much space.',
	'tiff_error_cached' => 'Error message shown when a error occurres and it is cached.',
	'tiff_size_error' => 'Error message shown when the reported file size does not match the actual file size.',
	'tiff_script_detected' => 'Error message shown when the uploaded file contains scripts.',
	'tiff_bad_file' => 'Error message shown when the uploaded file contains errors. First parameter contains error messages',
	'tiff-file-info-size' => 'Information about the image dimensions etc. on image page. Extended by page information',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'tiff-desc' => '{{desc}}',
	'tiff_no_metadata' => 'Error message shown when no metadata extraction is not possible',
	'tiff_page_error' => 'Error message shown when page number is out of range',
	'tiff_too_many_embed_files' => 'Error message shown when the uploaded image contains too many embedded files.',
	'tiff_sourcefile_too_large' => 'Error message shown when the resolution of the source file is too large.',
	'tiff_targetfile_too_large' => 'Error message shown when the resolution of the target file is too large.',
	'tiff_file_too_large' => 'Error message shown when the uploaded file is too large.',
	'tiff_out_of_service' => 'Error message shown when the uploaded file could not be processed by external renderer (ImageMagick).',
	'tiff_too_much_meta' => 'Error message shown when the metadata uses too much space.',
	'tiff_error_cached' => 'Error message shown when a error occurres and it is cached.',
	'tiff_size_error' => 'Error message shown when the reported file size does not match the actual file size.',
	'tiff_script_detected' => 'Error message shown when the uploaded file contains scripts.',
	'tiff_bad_file' => 'Error message shown when the uploaded file contains errors. First parameter contains error messages.',
	'tiff-file-info-size' => 'Information about the image dimensions etc. on image page. Extended by page information',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'tiff-desc' => 'Hanteerder vir die besigtiging van TIFF-lêers in die beeld-modus',
	'tiff_no_metadata' => 'Kan nie metadata vanuit TIFF kry nie',
	'tiff_page_error' => 'Bladsynommer kom nie in dokument voor nie',
	'tiff_too_many_embed_files' => 'Die beeld bevat te veel ingebedde lêers.',
	'tiff_sourcefile_too_large' => 'Die resolusie van die bronlêer is te groot. Geen duimnael sal gegenereer word nie.',
	'tiff_file_too_large' => 'Die opgelaaide lêer is te groot en is verwerp.',
	'tiff_out_of_service' => 'Die opgelaaide lêer kon nie verwerk word nie. ImageMagick is nie beskikbaar is nie.',
	'tiff_too_much_meta' => 'Metadata gebruik te veel spasie.',
	'tiff_error_cached' => 'Hierdie lêer kan slegs na die die kas-interval gerendeer word.',
	'tiff_size_error' => 'Die gerapporteerde lêergrootte stem nie met die lêer se werklike grootte ooreen nie.',
	'tiff_script_detected' => 'Die opgelaaide lêer bevat skrips.',
	'tiff_bad_file' => 'Die opgelaaide lêer bevat foute: $1',
	'tiff-file-info-size' => 'bladsy $5, $1 × $2 spikkels, lêergrootte: $3, MIME-tipe: $4',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'tiff-desc' => 'TIFF файлдарҙы рәсемдәр рәүешендә ҡарау өсөн эшкәртеүсе ҡорал',
	'tiff_no_metadata' => 'TIFF-тан мета-мәғлүмәтте алыу мөмкин түгел',
	'tiff_page_error' => 'Бит һаны биттәр һанынан ашҡан',
	'tiff_too_many_embed_files' => 'Рәсемдең индерелгән файлдары бигерәк күп.',
	'tiff_sourcefile_too_large' => 'Сығанаҡ файлдың асыҡлығы бигерәк ҙур.
Бәләкәй рәсемдәр булдырылмаясаҡ.',
	'tiff_targetfile_too_large' => 'Кәрәкле файлдың асыҡлығы бигерәк ҙур.
Бәләкәй рәсемдәр булдырылмаясаҡ.',
	'tiff_file_too_large' => 'Тейәлгән файл бигерәк ҙур һәм ул кире ҡағылған.',
	'tiff_out_of_service' => 'Тейәлгән файл эшкәртелә алмай. ImageMagick-ты ҡулланыу мөмкин түгел.',
	'tiff_too_much_meta' => 'Мета-мәғлүмәт бигерәк күп урын ала.',
	'tiff_error_cached' => 'Был файл кэшлау арауығы үткәндән һуң ғына яңынан төшөрөлә ала.',
	'tiff_size_error' => 'Күрһәтелгән файл күләме уның ғәмәлдәге күләме менән тап килмәй.',
	'tiff_script_detected' => 'Тейәлгән файлдың скриптары бар.',
	'tiff_bad_file' => 'Тейәлгән файлдың хаталары бар: $1',
	'tiff-file-info-size' => '$5 бите, $1 × $2 нөктә, файлдың дәүмәле: $3, MIME төрө: $4',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'tiff-desc' => 'Апрацоўшчык для прагляду TIFF-файлаў у выглядзе выяваў',
	'tiff_no_metadata' => 'Немагчыма атрымаць мэта-зьвесткі з TIFF-файла',
	'tiff_page_error' => 'Нумар старонкі паза дыяпазонам',
	'tiff_too_many_embed_files' => 'Выява ўтрымлівае зашмат убудаваных файлаў.',
	'tiff_sourcefile_too_large' => 'Разрозьненьне крынічнага файла занадта вялікае. Мініятуры стварацца ня будуць.',
	'tiff_targetfile_too_large' => 'Разрозьненьне файла занадта вялікае. Выява для папярэдняга прагляду ня будзе створаная.',
	'tiff_file_too_large' => 'Памер загружанага файла — занадта вялікі, файл быў адхілены.',
	'tiff_out_of_service' => 'Загружаны файл ня можа быць апрацаваны. ImageMagick недаступная.',
	'tiff_too_much_meta' => 'Мэта-зьвесткі займаюць зашмат месца.',
	'tiff_error_cached' => 'Гэты файл можа быць паўторна згенэраваны толькі пасьля інтэрвалу для кэшаваньня.',
	'tiff_size_error' => 'Пададзены памер файла не супадае з фактычным памерам файла.',
	'tiff_script_detected' => 'Загружаны файл утрымлівае скрыпты.',
	'tiff_bad_file' => 'Загружаны файл утрымлівае памылкі: $1',
	'tiff-file-info-size' => '$1 × $2 піксэляў, памер файла: $3, тып MIME: $4, $5 {{PLURAL:$5|старонка|старонкі|старонак}}',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'tiff-desc' => 'Maveg evit gwelet ar restroù TIFF e mod skeudenn',
	'tiff_no_metadata' => "Ne c'haller ket tapout metaroadennoù eus TIFF",
	'tiff_page_error' => "N'emañ ket niverenn ar bajenn er skeuliad",
	'tiff_too_many_embed_files' => 'Re a restroù enklozet zo er skeudenn.',
	'tiff_sourcefile_too_large' => 'Re vras eo spister ar rest mammenn. Ne vo ket krouet a skeudennig.',
	'tiff_targetfile_too_large' => 'Re vras eo spister ar rest sibl. Ne vo ket krouet a skeudennig.',
	'tiff_file_too_large' => 'Re vras eo ar restr karget ha distaolet eo bet.',
	'tiff_out_of_service' => "N'eus ket bet gellet tretiñ ar restr pellgarget. Dizimplijadus eo ImageMagick.",
	'tiff_too_much_meta' => "Ar metaroadennoù a implij re a lec'h.",
	'tiff_error_cached' => "N'hall ar restr-mañ bezañ adderaouekaet nemet goude termen ar grubuilh.",
	'tiff_size_error' => 'Ne glot ket ment ar restr meneget gant ment gwir ar restr.',
	'tiff_script_detected' => 'Skriptoù zo er restr karget.',
	'tiff_bad_file' => 'Fazioù zo er restr enporzhiet : $1',
	'tiff-file-info-size' => 'pajenn $5, $1 × $2 piksel, ment ar restr : $3, seurt MIME : $4',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'tiff-desc' => 'Uređivač za pregled TIFF datoteka u modu za slike',
	'tiff_no_metadata' => 'Ne mogu se naći metapodaci iz TIFF',
	'tiff_page_error' => 'Broj stranice nije u rasponu',
	'tiff_too_many_embed_files' => 'Slika sadrži previše umetnutih datoteka.',
	'tiff_sourcefile_too_large' => 'Rezolucija izvorne datoteke je prevelika.
Neće se generirati smanjeni prikaz.',
	'tiff_targetfile_too_large' => 'Rezolucija ciljne datoteke je prevelika.
Neće se generirati smanjeni prikaz.',
	'tiff_file_too_large' => 'Postavljena datoteka je prevelika ili je odbijena.',
	'tiff_out_of_service' => 'Poslana datoteka ne može biti obrađena.
ImageMagick nije dostupan.',
	'tiff_too_much_meta' => 'Metapodaci koriste previše prostora.',
	'tiff_error_cached' => 'Ova datoteka se može ponovo iscrtati samo nakon perioda keširanja.',
	'tiff_size_error' => 'Prijavljena veličina datoteke ne odgovara njenoj stvarnoj veličini.',
	'tiff_script_detected' => 'Poslana datoteka sadrži skripte.',
	'tiff_bad_file' => 'Poslana datoteka sadrži greške: $1',
	'tiff-file-info-size' => '$1 × $2 piksela, veličina datoteka: $3, MIME vrsta: $4, $5 {{PLURAL:$5|stranica|stranice|stranica}}',
);

/** Danish (Dansk)
 * @author Peter Alberti
 */
$messages['da'] = array(
	'tiff-desc' => 'Håndtering af TIFF-visning i billedtilstand',
	'tiff_no_metadata' => 'Kan ikke hente metadata fra TIFF',
	'tiff_page_error' => 'Sidetallet er større end antallet af sider i dokumentet',
	'tiff_too_many_embed_files' => 'Billedet indeholder for mange indlejrede filer.',
	'tiff_sourcefile_too_large' => 'Opløsningen af kildefilen er for stor.
Der vil ikke blive dannet miniaturebilleder.',
	'tiff_targetfile_too_large' => 'Opløsningen af destinationsfilen er for stor.
Der vil ikke blive dannet miniaturebilleder.',
	'tiff_file_too_large' => 'Den overførte fil er for stor og blev afvist.',
	'tiff_out_of_service' => 'Den overførte fil kunne ikke behandles.
ImageMagick er ikke tilgængelig.',
	'tiff_too_much_meta' => 'Metadata bruger for meget plads.',
	'tiff_error_cached' => 'Denne fil kan kun gengives påny efter mellemlagringen udløber.',
	'tiff_size_error' => 'Den rapporterede filstørrelse svarer ikke til den aktuelle filstørrelse.',
	'tiff_script_detected' => 'Den overførte fil indeholder scripts.',
	'tiff_bad_file' => 'Den overførte fil indeholder fejl: $1',
	'tiff-file-info-size' => '$1 × $2 punkter, filstørrelse: $3, MIME-type: $4, $5 {{PLURAL:$5|side|sider}}',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Hallo Welt! - Medienwerkstatt GmbH
 * @author Kghbln
 * @author Purodha
 */
$messages['de'] = array(
	'tiff-desc' => 'Stellt eine Schnittstelle zur Ansicht von TIFF-Dateien im Bildermodus bereit',
	'tiff_no_metadata' => 'Keine Metadaten im TIFF vorhanden.',
	'tiff_page_error' => 'Seitenzahl außerhalb des Dokumentes.',
	'tiff_too_many_embed_files' => 'Die Datei enthält zu viele eingebettete Dateien.',
	'tiff_sourcefile_too_large' => 'Die Quelldatei hat eine zu hohe Auflösung. Es wird kein Thumbnail generiert.',
	'tiff_targetfile_too_large' => 'Die Zieldatei hat eine zu hohe Auflösung. Es wird kein Thumbnail generiert.',
	'tiff_file_too_large' => 'Die hochgeladene Datei ist zu groß und wurde abgewiesen.',
	'tiff_out_of_service' => 'Die hochgeladene Datei konnte nicht verarbeitet werden. ImageMagick ist nicht verfügbar.',
	'tiff_too_much_meta' => 'Die Metadaten benötigen zu viel Speicherplatz.',
	'tiff_error_cached' => 'Diese Datei kann erst nach Ablauf der Caching-Periode neu gerendert werden.',
	'tiff_size_error' => 'Die übergebene Größe der Datei stimmt nicht mit der tatsächlichen überein.',
	'tiff_script_detected' => 'Die hochgeladene Datei enthält Skripte.',
	'tiff_bad_file' => 'Die hochgeladene Datei ist fehlerhaft: $1',
	'tiff-file-info-size' => '$1 × $2 Pixel, Dateigröße: $3, MIME-Typ: $4, Seiten: $5',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'tiff-desc' => 'Rěd za woglědowanje TIFF-datajow we wobrazowem modusu',
	'tiff_no_metadata' => 'Njedaju se žedne metadaty z TIFF ekstrahěrowaś',
	'tiff_page_error' => 'Bokowa licba njejo we wobcerku',
	'tiff_too_many_embed_files' => 'Wobraz wopśimujo pśewjele zasajźonych datajow.',
	'tiff_sourcefile_too_large' => 'Rozeznaśe žrědłoweje dataje jo pśewjelike. Miniaturny wobraz se njenapórajo.',
	'tiff_targetfile_too_large' => 'Rozeznaśe celoweje dataje jo pśewjelike. Miniaturny wobraz so njenapórajo.',
	'tiff_file_too_large' => 'Nagrata dataja jo pśewjelika a jo se wótpokazała.',
	'tiff_out_of_service' => 'Nagrata dataja njedajo se pśeźěłaś. ImageMagick njestoj k dispoziciji.',
	'tiff_too_much_meta' => 'Metadaty wužywa pśewjele ruma.',
	'tiff_error_cached' => 'Toś ta dataja dajo se akle pó puferowańskem interwalu znowego wuceriś.',
	'tiff_size_error' => 'K wěsći dana datajowa wjelikosć njewótpowědujo wopšawdnej datajowej wjelikosći.',
	'tiff_script_detected' => 'Nagrata dataja wopśimujo skripty.',
	'tiff_bad_file' => 'Nagrata dataja wopśimujo zmólki: $1',
	'tiff-file-info-size' => '$1 × $2 pikselow, datajowa wjelikosć: $3, typ MIME: $4, $5 {{PLURAL:$5|bok|boka|boki|bokow}}',
);

/** Greek (Ελληνικά)
 * @author Dada
 */
$messages['el'] = array(
	'tiff_no_metadata' => 'Αδύνατη η ανάκτηση μεταδεδομένων από το TIFF',
	'tiff_page_error' => 'Αριθμός σελίδας εκτός ορίου',
	'tiff_file_too_large' => 'Το μεταφορτωμένο αρχείο είναι πολύ μεγάλο και απορρίφθηκε.',
);

/** Spanish (Español)
 * @author Pertile
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'tiff-desc' => 'Controlador para ver archivos TIFF en modo de imagen',
	'tiff_no_metadata' => 'No se pudo obtener los metadatos de TIFF',
	'tiff_page_error' => 'Número de página fuera de rango',
	'tiff_too_many_embed_files' => 'La imagen contiene demasiados archivos incrustados.',
	'tiff_sourcefile_too_large' => 'La resolución del archivo fuente es muy grande. No se generará miniaturas.',
	'tiff_targetfile_too_large' => 'La resolución del archivo destino es muy grande. No se generará ninguna miniatura.',
	'tiff_file_too_large' => 'El archivo subido es muy grande y ha sido rechazado.',
	'tiff_out_of_service' => 'El archivo subido no pudo ser procesado. ImageMagick no está disponible.',
	'tiff_too_much_meta' => 'Los metadatos utilizan demasiado espacio.',
	'tiff_error_cached' => 'Este archivo sólo puede ser reprocesado tras el intervalo de cacheo.',
	'tiff_size_error' => 'El tamaño del archivo reportado no coincide con el tamaño real del archivo.',
	'tiff_script_detected' => 'El archivo cargado contiene scripts.',
	'tiff_bad_file' => 'El archivo cargado contiene errores: $1',
	'tiff-file-info-size' => 'Página $5, $1 × $2 píxeles, tamaño de archivo: $3, tipo de MIME: $4',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Nike
 */
$messages['fi'] = array(
	'tiff_no_metadata' => 'Metatietojen hakeminen TIFF-tiedostosta epäonnistui',
	'tiff_too_many_embed_files' => 'Kuvassa on liian monta upotettua tiedostoa.',
	'tiff_file_too_large' => 'Palvelimelle kopioitu tiedosto on liian suuri ja torjuttiin.',
	'tiff_out_of_service' => 'Palvelimelle kopioitua tiedostoa ei voitu käsitellä. ImageMagick ei ollut käytettävissä.',
	'tiff_too_much_meta' => 'Metatiedot vievät liikaa tilaa.',
	'tiff_script_detected' => 'Palvelimelle kopioitu tiedosto sisältää skriptejä.',
	'tiff_bad_file' => 'Tallennenttu tiedosto sisältää virheitä: $1',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Jagwar
 * @author Jean-Frédéric
 * @author Peter17
 * @author Urhixidur
 */
$messages['fr'] = array(
	'tiff-desc' => 'Gestionnaire pour visionner les fichiers TIFF en mode image',
	'tiff_no_metadata' => "Impossible d'obtenir les métadonnées depuis TIFF",
	'tiff_page_error' => 'Le numéro de page n’est pas dans la plage.',
	'tiff_too_many_embed_files' => "L'image contient trop de fichiers embarqués.",
	'tiff_sourcefile_too_large' => 'La résolution du fichier source est trop élevée. Aucune miniature ne sera générée.',
	'tiff_targetfile_too_large' => 'La résolution de l’image cible est trop importante. Aucun aperçu ne sera généré.',
	'tiff_file_too_large' => 'Le fichier téléversé est trop grand et a été rejeté.',
	'tiff_out_of_service' => "Le fichier téléversé n'a pas pu être traité. ImageMagick n'est pas disponible.",
	'tiff_too_much_meta' => "Les métadonnées utilisent trop d'espace.",
	'tiff_error_cached' => "Ce fichier ne peut être régénéré qu'après l'expiration du cache.",
	'tiff_size_error' => 'La taille de fichier indiquée ne correspond pas à la taille réelle du fichier.',
	'tiff_script_detected' => 'Le fichier téléchargé contient des scripts.',
	'tiff_bad_file' => 'Le fichier importé contient des erreurs : $1',
	'tiff-file-info-size' => '$1 × $2 pixels, taille du fichier : $3, type MIME: $4, $5 page{{PLURAL:$5||s}}',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'tiff_page_error' => 'Lo numerô de pâge est en defôr de la plage.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'tiff-desc' => 'Manipulador para ver ficheiros TIFF no modo de imaxe',
	'tiff_no_metadata' => 'Non se puideron obter os metadatos do TIFF',
	'tiff_page_error' => 'O número da páxina non está no rango',
	'tiff_too_many_embed_files' => 'A imaxe contén moitos ficheiros incorporados.',
	'tiff_sourcefile_too_large' => 'A resolución do ficheiro de orixe é moi grande. Non se xerará ningunha miniatura.',
	'tiff_targetfile_too_large' => 'A resolución do ficheiro de destino é moi grande. Non se xerará ningunha miniatura.',
	'tiff_file_too_large' => 'O ficheiro cargado é moi grande e foi rexeitado.',
	'tiff_out_of_service' => 'O ficheiro cargado non se puido procesar. ImageMagick non está dispoñible.',
	'tiff_too_much_meta' => 'Os metadatos empregan moito espazo.',
	'tiff_error_cached' => 'O ficheiro só se pode renderizar despois do intervalo da caché.',
	'tiff_size_error' => 'O tamaño do ficheiro do que se informou non se corresponde co tamaño real do ficheiro.',
	'tiff_script_detected' => 'O ficheiro cargado contén escrituras.',
	'tiff_bad_file' => 'O ficheiro cargado contén erros: $1',
	'tiff-file-info-size' => '$1 × $2 píxeles, tamaño do ficheiro: $3, tipo MIME: $4, $5 {{PLURAL:$5|páxina|páxinas}}',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'tiff-desc' => 'Funktion zum Aaluege vu TIFF-Dateie im Bildmodus',
	'tiff_no_metadata' => 'Cha d Metadate vum TIFF nit läse',
	'tiff_page_error' => 'Sytenummere lyt nit im Beryych',
	'tiff_too_many_embed_files' => 'Im Bild het s zvil yybundeni Dateie',
	'tiff_sourcefile_too_large' => 'D Uflesig vu dr Quälldatei isch z hoch. S wird kei Vorschaubild generiert.',
	'tiff_targetfile_too_large' => 'D Uflesig vu dr Ziildatei isch z hoch. S wird kei Miniaturbild generiert.',
	'tiff_file_too_large' => 'D Datei, wu uffeglade woren isch, isch z groß un isch abgwise wore.',
	'tiff_out_of_service' => 'D Datei, wu uffeglade woren isch, het nit chenne verarbeitet wäre. ImageMagick isch nit verfiegbar.',
	'tiff_too_much_meta' => 'D Metadate bruch zvil Spycherplatz.',
	'tiff_error_cached' => 'Die Datei cha erscht no Ablauf vu dr Caching-Periode nej grenderet wäre.',
	'tiff_size_error' => 'Di brichtet Greßi vu dr Datei stimmt nit zue dr tatsächlige.',
	'tiff_script_detected' => 'In dr Datei, wu uffeglade woren isch, het s Skript din.',
	'tiff_bad_file' => 'D Datei, wu uffeglade woren isch, isch fählerhaft: $1',
	'tiff-file-info-size' => '$1 × $2 Pixel, Dateigrössi: $3, MIME type: $4, $5 {{PLURAL:$5|Syte|Syte}}',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'tiff-desc' => 'טיפול בהצגת קובצי TIFF במצב תמונה',
	'tiff_no_metadata' => 'לא ניתן לקבל מטא־נתונים מ־TIFF',
	'tiff_page_error' => 'מספר הדף אינו בטווח',
	'tiff_too_many_embed_files' => 'יש יותר מדי קבצים בתמונה',
	'tiff_sourcefile_too_large' => 'הרזולוציה של קובץ המקור גדולה מדי.
לא תיווצר תמונה ממוזערת.',
	'tiff_targetfile_too_large' => 'הרזולוציה של קובץ היעד גדולה מדי.
לא תיווצר תמונה ממוזערת.',
	'tiff_file_too_large' => 'הקובץ שהועלה היה גדול מדי ונדחה.',
	'tiff_out_of_service' => 'לא ניתן לעבד את הקובץ שהועלה.
חבילת ImageMagick אינה זמינה.',
	'tiff_too_much_meta' => 'מטא־נתונים צורכים יותר מדי נפח.',
	'tiff_error_cached' => 'ניתן לעבד את הקובץ הזה רק אחרי מרווח ההטמנה.',
	'tiff_size_error' => 'גודל הקובץ שדווח אינו תואם לגדול הקובץ האמתי.',
	'tiff_script_detected' => 'הקובץ שהועלה מכיל סקריפטים.',
	'tiff_bad_file' => 'הקובץ שהועלה מכיל שגיאות: $1',
	'tiff-file-info-size' => '$1 × $2 פיקסלים, גודל הקובץ: $3, סוג MIME‏: $4, {{PLURAL:$5|דף אחד|$5 דפים}}',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'tiff-desc' => 'Rozšěrjenje za wobhladowanje TIFF-datajow we wobrazowym modusu',
	'tiff_no_metadata' => 'Z TIFF njedadźa so metadaty wućahać.',
	'tiff_page_error' => 'Čisło strony we wobłuku njeje',
	'tiff_too_many_embed_files' => 'Wobraz wobsahuje přewjele zapřijatych datajow.',
	'tiff_sourcefile_too_large' => 'Rozeznaće žórłoweje dataje je přewulke. Přehladowy wobraz njebudźe so płodźić.',
	'tiff_targetfile_too_large' => 'Rozeznaće ciloweje dataje je přewulke. Přehledowy wobrazk njeje so wutworił.',
	'tiff_file_too_large' => 'Nahrata dataja je přewulka a bu wotpokazana.',
	'tiff_out_of_service' => 'Nahrata dataja njeda so předźěłać. ImageMagick njesteji k dispoziciji.',
	'tiff_too_much_meta' => 'Metadaty wužiwaja přewjele ruma.',
	'tiff_error_cached' => 'Tuta dataja da so hakle po pufrowanskim interwalu znowa rysować.',
	'tiff_size_error' => 'Zdźělena wulkosć dataje njewotpowěduje woprawdźitej wulkosći dataje.',
	'tiff_script_detected' => 'Nahrata dataja wobsahuje skripty.',
	'tiff_bad_file' => 'Nahrata dataja wobsahuje zmylki: $1',
	'tiff-file-info-size' => '$1 × $2 pikselow, wulkosć dataje: $3, MIME-typ: $4, $5 {{PLURAL:$5|strona|stronje|strony|stronow}}',
);

/** Hungarian (Magyar)
 * @author BáthoryPéter
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'tiff_no_metadata' => 'Nem sikerült lekérni a TIFF metaadatait',
	'tiff_page_error' => 'Az oldalszám a tartományon kívül esik',
	'tiff_too_many_embed_files' => 'A kép túl sok beágyazott fájlt tartalmaz.',
	'tiff_targetfile_too_large' => 'A célfájl felbontása túl nagy. Nem fog bélyegkép készülni hozzá.',
	'tiff_file_too_large' => 'A feltöltött fájl túl nagy, vissza lett utasítva.',
	'tiff_out_of_service' => 'A feltöltött fájlt nem sikerült feldolgozni.
Az ImageMagick nem érhető el.',
	'tiff_too_much_meta' => 'A metaadatok túl sok helyet foglalnak.',
	'tiff_script_detected' => 'A feltöltött fájl parancsfájlokat tartalmaz.',
	'tiff_bad_file' => 'A feltöltött fájl hibákat tartalmaz: $1',
	'tiff-file-info-size' => '$5 oldal, $1 × $2 képpont, fájlméret: $3, MIME-típus: $4',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'tiff-desc' => 'Gestor pro visualisar files TIFF in modo de imagine',
	'tiff_no_metadata' => 'Non pote obtener metadatos ab TIFF',
	'tiff_page_error' => 'Numero de pagina foras del intervallo',
	'tiff_too_many_embed_files' => 'Le imagine contine troppo de files incastrate.',
	'tiff_sourcefile_too_large' => 'Le resolution del file de fonte es troppo alte. Nulle miniatura essera generate.',
	'tiff_targetfile_too_large' => 'Le resolution del file de destination es troppo alte. Nulle miniatura essera generate.',
	'tiff_file_too_large' => 'Le file incargate es troppo grande e ha essite rejectate.',
	'tiff_out_of_service' => 'Le file incargate non poteva esser processate. ImageMagick non es disponibile.',
	'tiff_too_much_meta' => 'Le metadatos usa troppo de spatio.',
	'tiff_error_cached' => 'Iste file pote solmente esser re-rendite post le expiration de su copia in cache.',
	'tiff_size_error' => 'Le grandor reportate del file non corresponde al grandor real del file.',
	'tiff_script_detected' => 'Le file incargate contine scripts.',
	'tiff_bad_file' => 'Le file incargate contine errores: $1',
	'tiff-file-info-size' => '$1 × $2 pixels, dimension del file: $3, typo MIME: $4, $5 {{PLURAL:$5|pagina|paginas}}',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author IvanLanin
 */
$messages['id'] = array(
	'tiff-desc' => 'Pengatur untuk melihat berkas TIFF dalam mode gambar',
	'tiff_no_metadata' => 'Tidak dapat memeroleh metadata dari TIFF',
	'tiff_page_error' => 'Nomor halaman di luar batas',
	'tiff_too_many_embed_files' => 'Gambar berisi terlalu banyak berkas tertanam.',
	'tiff_sourcefile_too_large' => 'Resolusi berkas sumber terlalu besar.
Miniatur tidak akan dibuat.',
	'tiff_targetfile_too_large' => 'Resolusi berkas tujuan terlalu besar.
Miniatur tidak akan dibuat.',
	'tiff_file_too_large' => 'Berkas unggahan terlalu besar dan ditolak.',
	'tiff_out_of_service' => 'Berkas unggahan tidak dapat diproses.
ImageMagick tidak tersedia.',
	'tiff_too_much_meta' => 'Metadata memakan banyak ruang.',
	'tiff_error_cached' => 'Berkas hanya dapat ditampilkan ulang setelah jeda penyinggahan.',
	'tiff_size_error' => 'Ukuran berkas yang dilaporkan tidak sama dengan ukuran berkas aslinya.',
	'tiff_script_detected' => 'Berkas unggahan berisi skrip.',
	'tiff_bad_file' => 'Berkas unggahan berisi kesalahan: $1',
	'tiff-file-info-size' => '$1 × $2 piksel, ukuran berkas: $3, tipe MIME: $4, $5 {{PLURAL:$5|halaman|halaman}}',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Naohiro19
 * @author Schu
 * @author Yanajin66
 * @author 青子守歌
 */
$messages['ja'] = array(
	'tiff-desc' => 'TIFFファイルの画像モードを表示するためのハンドラ',
	'tiff_no_metadata' => 'TIFFからのメタデータが取得できません',
	'tiff_page_error' => '範囲にないページ番号',
	'tiff_too_many_embed_files' => 'この画像には埋め込みファイルが多すぎます。',
	'tiff_sourcefile_too_large' => 'ソースファイルの解像度が大きすぎます。サムネイルは生成されません。',
	'tiff_targetfile_too_large' => 'ターゲットファイルの解像度が大きすぎます。サムネイルは生成されません。',
	'tiff_file_too_large' => 'アップロードされたファイルは容量が大きすぎるために拒否されました。',
	'tiff_out_of_service' => 'アップロードされたファイルを処理できませんでした。ImageMagick が利用できません。',
	'tiff_too_much_meta' => 'メタデータが使用する容量が大きすぎます。',
	'tiff_error_cached' => 'このファイルはキャッシュの有効期限が切れてからでなければレンダリングできません。',
	'tiff_size_error' => '報告されたファイルサイズが実際のサイズと一致しません。',
	'tiff_script_detected' => 'アップロードされたファイルに、スクリプトが含まれます。',
	'tiff_bad_file' => 'アップロードされたファイルは次のエラーを含んでいます: $1',
	'tiff-file-info-size' => '$1 × $2 ピクセル、ファイルサイズ : $3 、MIMEタイプ : $4 、 $5 {{PLURAL:$5|ページ|ページ}}',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'tiff-desc' => 'TIFF 파일을 이미지 모드에서 볼 수 있도록 하는 핸들러',
	'tiff_no_metadata' => 'TIFF 파일에서 메타데이터를 가져올 수 없습니다.',
	'tiff_page_error' => '쪽수가 범위 바깥에 있습니다.',
	'tiff_too_many_embed_files' => '이 이미지가 너무 많은 임베드 파일을 포함하고 있습니다.',
	'tiff_sourcefile_too_large' => '원본 파일의 해상도가 너무 큽니다.
섬네일이 생성되지 않을 것입니다.',
	'tiff_too_much_meta' => '메타데이터가 너무 많은 공간을 차지합니다.',
	'tiff-file-info-size' => '$1 × $2 픽셀, 파일 크기: $3, MIME 종류: $4, $5{{PLURAL:$5|페이지}}',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'tiff-desc' => 'Määt et müjjelesch, <i lang="en">TIFF</i>-Dateie als Bellder ze beloore.',
	'tiff_no_metadata' => 'Mer künne kein Metta_Daate uß dä TIFF-Dattei krijje',
	'tiff_page_error' => 'En Sigge-Nommer es ußerhallef',
	'tiff_too_many_embed_files' => 'En dämm Beld sin zoh vill Datteije dren enthallde.',
	'tiff_sourcefile_too_large' => 'De Oplühsong vun dää Enjangs_Dattei es esu jruuß,
dat mer kein Breefmarkebelldsche druß ußrääschne künne.',
	'tiff_targetfile_too_large' => 'De Oplühsong vun dää Ußjangs_Dattei es esu jruuß,
dat mer kein Breefmarkebelldsche ußrääschne künne.',
	'tiff_file_too_large' => 'De huhjelaade Dattei es zoh jruuß un wood zeröckjewiise.',
	'tiff_out_of_service' => 'De huhjelaade Dattei kunnte mer nit beärbeide.
<i lang="en">ImageMagick</i> shteiht nit paraat.',
	'tiff_too_much_meta' => 'De Mettadaate bruche zoh vill Plaz.',
	'tiff_error_cached' => 'Di Dattei kann eez neu aanjezeisch wääde, wan de Zick för der Zwescheschpeischer (<i lang="en">cache</i>) afjeloufe es.',
	'tiff_size_error' => 'Der aanjejovve Ömfang vun dä Dattei es nit der verhaftijje Ömfang.',
	'tiff_script_detected' => 'En dä huhjelaade Dattei sen Skrepte dren.',
	'tiff_bad_file' => 'De huhjelaade Dattei hät Fähler: $1',
	'tiff-file-info-size' => '$1&nbsp;×&nbsp;$2&nbsp;Pixelle, Ömfang:&nbsp;$3, de&nbsp;<i lang="en">MIME</i>–Zoot&nbsp;es: $4, {{PLURAL:$5|ein&nbsp;Sigg|$5&nbsp; Sigge|kein&nbsp;Sigg}}',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'tiff-desc' => 'Programm deen et erméiglech TIFF-Fichieren als Bild ze kucken',
	'tiff_page_error' => "D'Nummer vun der Säit ass net am Beräich",
	'tiff_file_too_large' => 'Den eropgeluedene Fichier ass ze grouss a gouf net akzeptéiert.',
	'tiff_out_of_service' => 'Den eropgeluedene Fichier konnt net verschafft ginn. ImageMagick ass net disponibel.',
	'tiff_too_much_meta' => "D'Metadate benotzen zevill Späicherplaz.",
	'tiff_size_error' => "Déi berechent Gréisst vum Fichier ass net d'selwëscht wéi déi wierklech Gréisst vum Fichier.",
	'tiff_script_detected' => 'Am eropgeluedene Fichier si Skripten dran.',
	'tiff_bad_file' => 'Am eropgeluedene Fichier si Feeler: $1',
	'tiff-file-info-size' => '$1 × $2 Pixelen, Gréisst vum Fichier: $3, MIME Typ: $4, $5 {{PLURAL:$5|Säit|Säiten}}',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'tiff-desc' => 'Ракувач за прегледување на TIFF податотеки во сликовен режим',
	'tiff_no_metadata' => 'Не можам да добијам метаподатоци од TIFF',
	'tiff_page_error' => 'Бројот на страница е надвор од опсег',
	'tiff_too_many_embed_files' => 'Сликата содржи премногу вградени податотеки.',
	'tiff_sourcefile_too_large' => 'Резолуцијата на изворната податотека е преголема. Минијатурата нема да биде создадена.',
	'tiff_targetfile_too_large' => 'Резолуцијата на целната податотека е преголема. Нема да биде направена минијатура.',
	'tiff_file_too_large' => 'Подигнатата податотека е преголема и затоа беше одбиена.',
	'tiff_out_of_service' => 'Подигнатата податотека не може да се обработи. ImageMagick не е достапен.',
	'tiff_too_much_meta' => 'Метаподатоците заземаат премногу простор.',
	'tiff_error_cached' => 'Оваа податотека може да се оформи само по кеширање на интервалот.',
	'tiff_size_error' => 'Пријавената големина на податотеката не се совпаѓа со фактичката.',
	'tiff_script_detected' => 'Подигнатата податотека содржи скрипти.',
	'tiff_bad_file' => 'Подигнатата податотека содржи грешки: $1',
	'tiff-file-info-size' => '$1 × $2 пиксели, големина: $3, MIME-тип: $4, $5 {{PLURAL:$5|страница|страници}}',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'tiff-desc' => 'ടിഫ് (TIFF) പ്രമാണങ്ങൾ ചിത്രരൂപത്തിൽ കാണുന്നതിനുള്ള കൈകാര്യോപകരണം',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'tiff-desc' => 'Håndterer for visning av TIFF-filer i bildemodus',
	'tiff_no_metadata' => 'Kan ikke hente metadata fra TIFF',
	'tiff_page_error' => 'Sidenummer er utenfor sideintervallet',
	'tiff_too_many_embed_files' => 'Bildet inneholder for mange innebygde filer.',
	'tiff_sourcefile_too_large' => 'Oppløsningen til kildefilen er for stor. Miniatyrbilde vil ikke bli opprettet.',
	'tiff_targetfile_too_large' => 'Oppløsningen på målfilen er for stor. Inget miniatyrbilde vil bli generert.',
	'tiff_file_too_large' => 'Den opplastede filen var for stor og ble avvist.',
	'tiff_out_of_service' => 'Den opplastede filen kunne ikke behandles. ImageMagick er ikke tilgjengelig.',
	'tiff_too_much_meta' => 'Metadata bruker for mye plass.',
	'tiff_error_cached' => 'Filen kan bare gjengis på nytt etter hurtiglagerintervallet.',
	'tiff_size_error' => 'Den rapporterte filstørrelsen samsvarer ikke med den faktiske filstørrelsen.',
	'tiff_script_detected' => 'Den opplastede filen inneholder skript.',
	'tiff_bad_file' => 'Den opplastede filen inneholder feil: $1',
	'tiff-file-info-size' => 'side $5, $1 x $2 piksler, filstørrelse: $3, MIME-type: $4',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'tiff-desc' => 'Uitbreiding voor het bekijken van TIFF-bestanden in beeldmodus',
	'tiff_no_metadata' => 'De metadata van het TIFF-bestand kan niet uitgelezen worden',
	'tiff_page_error' => 'Het paginanummer ligt niet binnen het bereik',
	'tiff_too_many_embed_files' => 'De afbeelding bevat te veel ingesloten bestanden.',
	'tiff_sourcefile_too_large' => 'De resolutie van het bronbestand is te groot.
Er kan geen miniatuur worden aangemaakt.',
	'tiff_targetfile_too_large' => 'De resolutie van het doelbestand is te groot.
Er wordt geen miniatuur aangemaakt.',
	'tiff_file_too_large' => 'Het geüploade bestand is te groot en kan niet verwerkt worden.',
	'tiff_out_of_service' => 'Het geüploade bestand kan niet worden verwerkt.
ImageMagick is niet beschikbaar.',
	'tiff_too_much_meta' => 'De metadata gebruikt te veel ruimte.',
	'tiff_error_cached' => 'Dit bestand kan alleen worden verwerkt na de cachinginterval.',
	'tiff_size_error' => 'De gerapporteerde bestandsgrootte komt niet overeen met de werkelijke bestandsgrootte.',
	'tiff_script_detected' => 'Het geüploade bestand bevat scripts.',
	'tiff_bad_file' => 'Het geüploade bestand bevat fouten: $1',
	'tiff-file-info-size' => "$1 × $2 pixels, bestandsgrootte: $3, MIME-type: $4, $5 {{PLURAL:$5|pagina|pagina's}}",
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'tiff-desc' => 'Obsługa przeglądania plików w formacie TIFF',
	'tiff_no_metadata' => 'Nie można odczytać metadanych z TIFF',
	'tiff_page_error' => 'Numer strony poza zakresem',
	'tiff_too_many_embed_files' => 'Grafika zawiera zbyt wiele osadzonych plików.',
	'tiff_sourcefile_too_large' => 'Miniaturki nie zostaną wygenerowane.',
	'tiff_targetfile_too_large' => 'Zbyt duża rozdzielczość pliku docelowego.
Miniaturki nie zostaną wygenerowane.',
	'tiff_file_too_large' => 'Przesłany plik jest zbyt duży i został odrzucony.',
	'tiff_out_of_service' => 'Przesłany plik nie może być przetworzony.
ImageMagick nie jest dostępny.',
	'tiff_too_much_meta' => 'Metadane wymagają zbyt wiele przestrzeni.',
	'tiff_error_cached' => 'Plik może zostać przetworzony dopiero po zakończeniu buforowania.',
	'tiff_size_error' => 'Zgłoszony rozmiar pliku nie przystaje do jego rzeczywistego rozmiaru.',
	'tiff_script_detected' => 'Przesłany plik zawiera skrypty.',
	'tiff_bad_file' => 'Przesłany plik zawiera błędy – $1',
	'tiff-file-info-size' => '$1 × $2 pikseli, rozmiar pliku – $3, typ MIME – $4, $5 {{PLURAL:$5|strona|strony|stron}}',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'tiff-desc' => 'Gestor për vëdde archivi TIFF an manera figure',
	'tiff_no_metadata' => 'As riess nen a pijé ij metadat dal TIFF',
	'tiff_page_error' => "Nùmer ëd pàgina pa ant l'antërval",
	'tiff_too_many_embed_files' => 'La figura a conten andrinta tròpi archivi.',
	'tiff_sourcefile_too_large' => "L'arzolussion dl'archivi sorgiss a l'é tròp gròssa. Gnun-e figurin-e a saran generà.",
	'tiff_targetfile_too_large' => "L'arzolussion ëd l'archivi ëd destinassion a l'é tròp gròssa. Gnun-e figurin-e a saran generà.",
	'tiff_file_too_large' => "L'archivi carià a l'é tròp gròss e a l'é stàit arfudà.",
	'tiff_out_of_service' => "L'archivi carià a l'ha pa podù esse processà. ImageMagick a l'é nen disponìbil.",
	'tiff_too_much_meta' => 'Ij Metadat a deuvro tròp dë spassi.',
	'tiff_error_cached' => "Cost archivi-sì a peul mach esse rendù apress l'antërval ëd memorisassion local.",
	'tiff_size_error' => "La dimension diciairà dl'archivi a l'é pa l'istessa ëd soa dimension vera.",
	'tiff_script_detected' => "L'archivi carià a conten ëd senari.",
	'tiff_bad_file' => "L'archivi carià a conten d'eror: $1",
	'tiff-file-info-size' => "$1 x $2 pontin, dimension dl'archivi: $3, sòrt MIME: $4, $5 {{PLURAL:$5|pàgina|pàgine}}",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'tiff-desc' => 'Permite o visionamento de ficheiros TIFF em modo de imagem',
	'tiff_no_metadata' => 'Não foi possível extrair metadados do TIFF',
	'tiff_page_error' => 'Número de página fora do intervalo',
	'tiff_too_many_embed_files' => 'A imagem tem demasiados ficheiros embutidos.',
	'tiff_sourcefile_too_large' => "A resolução do ficheiro de origem é demasiado grande. Não será gerada uma miniatura ''(thumbnail)''.",
	'tiff_targetfile_too_large' => "A resolução do ficheiro de destino é demasiado grande. Não será gerada uma miniatura ''(thumbnail)''.",
	'tiff_file_too_large' => 'O ficheiro transferido é demasiado grande e foi rejeitado.',
	'tiff_out_of_service' => 'Não foi possível processar o ficheiro transferido. O ImageMagick não está disponível.',
	'tiff_too_much_meta' => 'Os metadados usam demasiado espaço.',
	'tiff_error_cached' => 'Só será possível voltar a renderizar o ficheiro após o intervalo de caching, porque o erro foi colocado na cache.',
	'tiff_size_error' => 'O tamanho reportado do ficheiro não corresponde ao tamanho real.',
	'tiff_script_detected' => "O ficheiro transferido tem ''scripts''.",
	'tiff_bad_file' => 'O ficheiro enviado contém erros: $1',
	'tiff-file-info-size' => '$1 × $2 pixels, tamanho do ficheiro: $3, tipo MIME: $4, $5 {{PLURAL:$5|página|páginas}}',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author 555
 * @author Giro720
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'tiff-desc' => 'Permite visualizar arquivos TIFF como imagens',
	'tiff_no_metadata' => 'Não foi possível obter os metadados do TIFF',
	'tiff_page_error' => 'Número de página fora do intervalo',
	'tiff_too_many_embed_files' => 'A imagem possui arquivos embutidos demais.',
	'tiff_sourcefile_too_large' => 'A resolução do arquivo original é muito grande.
Não serão geradas miniaturas.',
	'tiff_targetfile_too_large' => 'A resolução do arquivo de destino é muito grande.
Não serão geradas miniaturas.',
	'tiff_file_too_large' => 'O arquivo enviado foi recusado por ser muito grande.',
	'tiff_out_of_service' => 'O arquivo enviado não pôde ser processado.
ImageMagick não está disponível.',
	'tiff_too_much_meta' => 'Os metadados ocupam muito espaço.',
	'tiff_error_cached' => 'Este arquivo só poderá ser renderizado no próximo intervalo de cache.',
	'tiff_size_error' => 'O tamanho reportado do arquivo não confere com o tamanho real.',
	'tiff_script_detected' => 'O arquivo enviado contém scripts.',
	'tiff_bad_file' => 'O arquivo enviado contém erros: $1',
	'tiff-file-info-size' => '$1 × $2 pixels, tamanho do arquivo: $3, tipo MIME: $4, $5 {{PLURAL:$5|página|páginas}}',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'tiff-desc' => 'Обработчик для просмотра TIFF-файлов в виде изображений',
	'tiff_no_metadata' => 'Невозможно получить метаданные из TIFF',
	'tiff_page_error' => 'Номер страницы вне диапазона',
	'tiff_too_many_embed_files' => 'Изображение содержит слишком много встроенных файлов.',
	'tiff_sourcefile_too_large' => 'Разрешение исходного файла слишком велико. Миниатюры создаваться не будут.',
	'tiff_targetfile_too_large' => 'Разрешение целевого файла слишком велико. Миниатюра не будет создана.',
	'tiff_file_too_large' => 'Размер загружаемого файла слишком велик, файл отклонён.',
	'tiff_out_of_service' => 'Загруженный файл не может быть обработан. ImageMagick недоступен.',
	'tiff_too_much_meta' => 'Метаданные занимают слишком много места.',
	'tiff_error_cached' => 'Этот файл может быть повторно перерисован только после кэширующего промежутка.',
	'tiff_size_error' => 'Указанный размер файла не совпадает с фактическим размером файла.',
	'tiff_script_detected' => 'Загруженный файл содержит сценарии.',
	'tiff_bad_file' => 'Загруженный файл содержит ошибки: $1',
	'tiff-file-info-size' => '$1 × $2 пикселей, размер файла: $3, MIME-тип: $4, $5 {{PLURAL:$5|страница|страницы|страниц}}',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'tiff_no_metadata' => 'Не могу да преузмем метаподатке из TIFF-а',
	'tiff_page_error' => 'Број страница ван опсега',
	'tiff_too_many_embed_files' => 'Слика садржи превише уграђених датотека.',
	'tiff_file_too_large' => 'Послата датотека је превелика и зато је одбачена.',
	'tiff_out_of_service' => 'Послата датотека се не може обрадити.
Имиџмеџик није доступан.',
	'tiff_too_much_meta' => 'Метаподаци користе превише простора.',
	'tiff_error_cached' => 'Ова датотека се може поново исцртати само након периода међумеморисања.',
	'tiff_size_error' => 'Пријављена величина датотеке не одговара њеној стварној величини.',
	'tiff_script_detected' => 'Послата датотека садржи скриптове.',
	'tiff_bad_file' => 'Послата датотека садржи грешке: $1',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'tiff_no_metadata' => 'Ne mogu se preuzeti metapodaci iz TIFF-a',
	'tiff_page_error' => 'Broj strane nije u opsegu',
	'tiff_too_many_embed_files' => 'Slika sadrži previše umetnutih fajlova.',
	'tiff_file_too_large' => 'Poslati fajl je prevelik i odbačen je.',
	'tiff_out_of_service' => 'Poslati fajl nije mogao biti obraćen. ImageMagick nije dostupan.',
	'tiff_too_much_meta' => 'Metapodaci koriste previše prostora.',
	'tiff_error_cached' => 'Ovaj fajl može biti renderovan samo nakon keširanja.',
	'tiff_size_error' => 'Prijavljena veličina fajla ne odgovara njegovoj stvarnoj veličini.',
	'tiff_script_detected' => 'Poslati fajl sadrži skripte.',
	'tiff_bad_file' => 'Poslata datoteka sadrži greške: $1',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'tiff-desc' => 'Tagapaghawak para sa pagtanaw ng mga talaksang TIFF na nasa modalidad na panglarawan',
	'tiff_no_metadata' => 'Hindi makuha ang metadata mula sa TIFF',
	'tiff_page_error' => 'Wala sa sakop ang bilang ng pahina',
	'tiff_too_many_embed_files' => 'Naglalaman ang larawan ng napakaraming ibinaong mga talaksan.',
	'tiff_sourcefile_too_large' => 'Napakalaki ng resolusyon ng pinagmulang talaksan.  Walang malilikhang maliit na larawan.',
	'tiff_targetfile_too_large' => 'Napakalaki ng resolusyon ng puntiryang talaksan. Walang malilikhang maliit na larawan.',
	'tiff_file_too_large' => "Napakalaki ng ikinargang-paitaas na talaksan kaya't tinanggihan.",
	'tiff_out_of_service' => 'Hindi maaasikaso ang talaksang ikinargang pataas.  Hindi kasi makuha ang ImageMagick.',
	'tiff_too_much_meta' => 'Gumagamit ng labis na puwang ang metadata.',
	'tiff_error_cached' => 'Maaari lamang muling ibigay ang talaksan pagkatapos ng tagal ng agwat ng pagkukubli.',
	'tiff_size_error' => 'Hindi tumutugma ang inulat na sukat ng talaksan sa talagang sukat ng talaksan.',
	'tiff_script_detected' => 'Naglalaman ng mga baybayin ang ikinargang talaksan.',
	'tiff_bad_file' => 'Naglalaman ng mga kamalian ang ikinargang talaksan: $1',
	'tiff-file-info-size' => 'pahina $5, $1 × $2 piksel, sukat ng talaksan: $3, uri ng MIME: $4',
);

/** Vietnamese (Tiếng Việt)
 * @author Kaganer
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'tiff-desc' => 'Bộ xử lý để xem tập tin TIFF ở dạng hình ảnh',
	'tiff_no_metadata' => 'Không thể lấy siêu dữ liệu từ TIFF',
	'tiff_page_error' => 'Số trang không nằm trong giới hạn',
	'tiff_too_many_embed_files' => 'Hình này có nhúng quá nhiều tập tin.',
	'tiff_sourcefile_too_large' => 'Tập tin nguồn có độ phân giải quá cao.
Không thể tạo hình thu nhỏ.',
	'tiff_targetfile_too_large' => 'Tập tin đích có độ phân giải quá cao.
Không thể tạo hình thu nhỏ.',
	'tiff_file_too_large' => 'Tập tin được tải lên bị bác bỏ vì quá lớn.',
	'tiff_out_of_service' => 'Không thể xử lý tập tin được tải lên vì ImageMagick không có sẵn.',
	'tiff_too_much_meta' => 'Siêu dữ liệu tốn nhiều không gian quá.',
	'tiff_error_cached' => 'Chỉ có thể kết xuất lại tập tin sau khi bộ nhớ đệm hết hạn.',
	'tiff_size_error' => 'Kích thước được ghi vào tập tin không đúng với kích thước thực sự của tập tin.',
	'tiff_script_detected' => 'Tập tin được tải lên chứa script.',
	'tiff_bad_file' => 'Tập tin được tải lên có lỗi: $1',
	'tiff-file-info-size' => '$1 × $2 điểm ảnh, kích thước tập tin: $3, kiểu MIME: $4, $5 trang',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'tiff_too_much_meta' => 'מעטאַדאַטן באַניצן צו פֿיל פלאַץ.',
	'tiff-file-info-size' => '$1 × $2 פיקסעלן, טעקע גרייס: $3, MIME טיפ: $4,  $5 {{PLURAL:$5|בלאט|בלעטער}}',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'tiff_too_many_embed_files' => '该图像包含太多嵌入档案。',
	'tiff_file_too_large' => '上传的档案过大而被拒绝。',
	'tiff_too_much_meta' => '元数据占用太多的空间。',
	'tiff_bad_file' => '上传的档案有错误：$1',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'tiff_too_many_embed_files' => '該圖像包含太多嵌入檔案。',
	'tiff_file_too_large' => '上傳的檔案過大而被拒絕。',
	'tiff_too_much_meta' => '元數據佔用太多的空間。',
	'tiff_bad_file' => '上傳的檔案有錯誤：$1',
	'tiff-file-info-size' => '$5 頁面，$1 × $2 像素，檔案大小：$3，MIME類型：$4',
);

