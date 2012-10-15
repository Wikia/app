<?php
/*
	Score, a MediaWiki extension for rendering musical scores with LilyPond.
	Copyright © 2011 Alexander Klauer

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.

	To contact the author:
	<Graf.Zahl@gmx.net>
	http://en.wikisource.org/wiki/User_talk:GrafZahl
	https://github.com/TheCount/score

 */

$messages = array();

/* English */
$messages['en'] = array(
	'score-abc2lynotexecutable' => 'ABC to LilyPond converter could not be executed: $1 is not an executable file. Make sure <code>$wgScoreAbc2Ly</code> is set correctly.',
	'score-abcconversionerr' => 'Unable to convert ABC file to LilyPond format:
$1',
	'score-chdirerr' => 'Unable to change to directory $1',
	'score-cleanerr' => 'Unable to clean out old files before re-rendering',
	'score-compilererr' => 'Unable to compile LilyPond input file:
$1',
	'score-desc' => 'Adds a tag for rendering musical scores with LilyPond',
	'score-getcwderr' => 'Unable to obtain current working directory',
	'score-invalidlang' => 'Invalid score language lang="<nowiki>$1</nowiki>". Currently recognised languages are lang="lilypond" (the default) and lang="ABC".',
	'score-invalidoggoverride' => 'The file "<nowiki>$1</nowiki>" you specified with override_ogg is invalid. Please specify the file name only, omit <nowiki>[[…]]</nowiki> and the "{{ns:file}}:" prefix.',
	'score-midioverridenotfound' => 'The file "<nowiki>$1</nowiki>" you specified with override_midi could not be found. Please specify the file name only, omit <nowiki>[[…]]</nowiki> and the "{{ns:file}}:" prefix.',
	'score-noabcinput' => 'ABC source file $1 could not be created.',
	'score-noimages' => 'No score images were generated. Please check your score code.',
	'score-noinput' => 'Failed to create LilyPond input file $1.',
	'score-noogghandler' => 'Ogg/Vorbis conversion requires an installed and configured OggHandler extension, see [//www.mediawiki.org/wiki/Extension:OggHandler Extension:OggHandler].',
	'score-nomidi' => 'No MIDI file generated despite being requested. If you are working in raw LilyPond mode, make sure to provide a proper \midi block.',
	'score-nooutput' => 'Failed to create output directory $1.',
	'score-notexecutable' => 'Could not execute LilyPond: $1 is not an executable file. Make sure <code>$wgScoreLilyPond</code> is set correctly.',
	'score-novorbislink' => 'Unable to generate Ogg/Vorbis link: $1',
	'score-oggconversionerr' => 'Unable to convert MIDI to Ogg/Vorbis:
$1',
	'score-oggoverridenotfound' => 'The file "<nowiki>$1</nowiki>" you specified with override_ogg does not exist.',
	'score-page' => 'Page $1',
	'score-pregreplaceerr' => 'PCRE regular expression replacement failed',
	'score-readerr' => 'Unable to read file $1.',
	'score-timiditynotexecutable' => 'TiMidity++ could not be executed: $1 is not an executable file. Make sure <code>$wgScoreTimidity</code> is set correctly.',
	'score-renameerr' => 'Error moving score files to upload directory.',
	'score-trimerr' => 'Image could not be trimmed:
$1
Set <code>$wgScoreTrim=false</code> if this problem persists.',
	'score-versionerr' => 'Unable to obtain LilyPond version:
$1',
	'score-vorbisoverrideogg' => 'You cannot request Ogg/Vorbis rendering and specify override_ogg at the same time.',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'score-abc2lynotexecutable' => 'Displayed if the ABC to LilyPond converter could not be executed. $1 is the path to the abc2ly binary.',
	'score-abcconversionerr' => 'Displayed if the ABC to LilyPond conversion failed. $1 is the error (generally big block of text in a pre tag)',
	'score-chdirerr' => 'Displayed if the extension cannot change its working directory. $1 is the path to the target directory.',
	'score-cleanerr' => 'Displayed if an old file cleanup operation fails.',
	'score-compilererr' => 'Displayed if the LilyPond code could not be compiled. $1 is the error (generally big block of text in a pre tag)',
	'score-desc' => '{{desc}}',
	'score-getcwderr' => 'Displayed if the extension cannot obtain the current working directory.',
	'score-invalidlang' => 'Displayed if the lang="…" attribute contains an unrecognised score language. $1 is the unrecognised language.',
	'score-invalidoggoverride' => 'Displayed if the file specified with the override_ogg="…" attribute is invalid. $1 is the value of the override_ogg attribute.',
	'score-midioverridenotfound' => 'Displayed if the file specified with the override_midi="…" attribute could not be found. $1 is the value of the override_midi attribute.',
	'score-noabcinput' => 'Displayed if an ABC source file could not be created for lang="ABC". $1 is the path to the file that could not be created.',
	'score-noimages' => 'Displayed if no score images were rendered.',
	'score-noinput' => 'Displayed if the LilyPond input file cannot be created. $1 is the path to the input file.',
	'score-noogghandler' => 'Displayed if Ogg/Vorbis rendering was requested without the OggHandler extension installed.',
	'score-nomidi' => 'Displayed if MIDI file generation was requested but no MIDI file was generated.',
	'score-nooutput' => 'Displayed if an output directory could not be created. $1 is the name of the directory.',
	'score-notexecutable' => 'Displayed if LilyPond binary cannot be executed. $1 is the path to the LilyPond binary.',
	'score-novorbislink' => 'Displayed if an Ogg/Vorbis link could not be generated. $1 is the explanation why.',
	'score-oggconversionerr' => 'Displayed if the MIDI to Ogg/Vorbis conversion failed. $1 is the error (generally big block of text in a pre tag)',
	'score-oggoverridenotfound' => 'Displayed if the file specified with the override_ogg="…" attribute could not be found. $1 is the value of the override_ogg attribute.',
	'score-page' => 'The word "Page" as used in pagination. $1 is the page number',
	'score-pregreplaceerr' => 'Displayed if a PCRE regular expression replacement failed.',
	'score-readerr' => 'Displayed if the extension could not read a file. $1 is the path to the file that could not be read.',
	'score-timiditynotexecutable' => 'Displayed if TiMidity++ could not be executed. $1 is the path to the TiMidity++ binary.',
	'score-renameerr' => 'Displayed if moving the resultant files from the working environment to the upload directory fails.',
	'score-trimerr' => 'Displayed if the extension failed to trim an output image. $1 is the error (generally big block of text in a pre tag)',
	'score-versionerr' => 'Displayed if the extension failed to obtain the version string of LilyPond. $1 is the LilyPond stdout output generated by the attempt.',
	'score-vorbisoverrideogg' => 'Displayed if both vorbis="1" and override_ogg="…" were specified.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'score-abc2lynotexecutable' => 'Пераўтваральнік з ABC у LilyPond ня можа быць выкліканы: $1 не зьяўляецца выканальным файлам. Праверце, ці <code>$wgScoreAbc2Ly</code> устаноўлены слушна.',
	'score-abcconversionerr' => 'Немагчыма пераўтварыць ABC-файл у фармат LilyPond:
$1',
	'score-chdirerr' => 'Немагчыма зьмяніць дырэкторыю $1',
	'score-cleanerr' => 'Немагчыма ачысьціць старыя файлы перад паказам',
	'score-compilererr' => 'Немагчыма скампіляваць зыходны файл LilyPond:
$1',
	'score-desc' => 'Дадае тэг для паказу музычных нот праз LilyPond',
);

/** Danish (Dansk)
 * @author Peter Alberti
 */
$messages['da'] = array(
	'score-abc2lynotexecutable' => 'Kunne ikke køre programmet til at konvertere fra ABC til LilyPond: $1 er ikke en eksekverbar fil. Kontroller at <code>$wgScoreAbc2Ly</code> er sat korrekt.',
	'score-abcconversionerr' => 'Kunne ikke konvertere ABC-fil til LilyPond-format:
$1',
	'score-chdirerr' => 'Kunne ikke skifte folder til $1',
	'score-cleanerr' => 'Kunne ikke rense ud i gamle filer før genrendering',
	'score-compilererr' => 'Kunne ikke kompilere inddatafil til LilyPond:
$1',
	'score-desc' => 'Tilføjer et tag til at gengive partiturer ved hjælp af LilyPond',
	'score-getcwderr' => 'Kunne ikke bestemme navnet på den gældende arbejdsfolder',
	'score-invalidlang' => 'lang="<nowiki>$1</nowiki>" er et ugyldigt partitursprog. De sprog, der kan genkendes i øjeblikket, er lang="lilypond" (standardværdien) og lang="ABC".',
	'score-noabcinput' => 'Kunne ikke oprette ABC-kildefilen $1.',
	'score-noinput' => 'Kunne ikke oprette inddatafil til LilyPond, $1.',
	'score-noogghandler' => 'Omdannelse til Ogg/Vorbis kræver at udvidelsen OggHandler er installeret og sat op, se [//www.mediawiki.org/wiki/Extension:OggHandler Extension:OggHandler].',
	'score-nomidi' => 'Ingen MIDI blev dannet på trods af anmodning. Hvis du arbejder i rå LilyPond-tilstand, sørg for at angive en passende \\midi-blok.',
	'score-nooutput' => 'Kunne ikke oprette folder til LilyPond-billeder, $1.',
	'score-notexecutable' => 'Kunne ikke køre LilyPond: $1 er ikke en eksekverbar fil. Kontroller at <code>$wgScoreLilyPond</code> er sat korrekt.',
	'score-novorbislink' => 'Kunne ikke oprette henvisning til Ogg/Vorbis: $1',
	'score-oggconversionerr' => 'Kunne ikke omdanne MIDI til Ogg/Vorbis:
$1',
	'score-page' => 'Side $1',
	'score-pregreplaceerr' => 'Erstatning med PCRE regulært udtryk lykkedes ikke',
	'score-readerr' => 'Kunne ikke læse filen $1.',
	'score-timiditynotexecutable' => 'Kunne ikke køre TiMidity++: $1 er ikke en eksekverbar fil. Kontroller at <code>$wgScoreTimidity</code> er sat korrekt.',
	'score-renameerr' => 'Der opstod en fejl under flytningen af partiturfiler til folderen for oplægning',
	'score-trimerr' => 'Billedet kunne ikke beskæres:
$1
Sæt $wgScoreTrim=false, hvis dette problem fortsætter.',
	'score-versionerr' => 'Kunne ikke bestemme LilyPonds version:
$1',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'score-abc2lynotexecutable' => 'Der Konverter von ABC nach LilyPond konnte nicht ausgeführt werden: $1 ist keine ausführbare Datei. Es muss sichergestellt sein, dass <code>$wgScoreAbc2Ly</code> in der Konfigurationsdatei richtig eingestellt wurde.',
	'score-abcconversionerr' => 'Die ABC-Datei konnte nicht in das LilyPond-Format konvertiert werden:
$1',
	'score-chdirerr' => 'Es konnte nicht zum Verzeichnis $1 gewechselt werden',
	'score-cleanerr' => 'Die alten Dateien konnten vor dem erneuten Rendern nicht bereinigt werden',
	'score-compilererr' => 'Die Eingabedatei von LilyPond konnte nicht kompiliert werden:
$1',
	'score-desc' => 'Ergänzt das Tag <code><score></code>, welches das Rendern und Einbetten von Partituren mit LilyPond ermöglicht',
	'score-getcwderr' => 'Das aktuelle Arbeitsverzeichnis konnte nicht aufgerufen werden',
	'score-invalidlang' => 'Die für die Partitur verwendete Sprache <code>lang="<nowiki>$1</nowiki>"</code> ist ungültig. Die derzeit verwendbaren Sprache sind <code>lang="lilypond"</code> (Standardeinstellung) und <code>lang="ABC"</code>.',
	'score-invalidoggoverride' => 'Die zu <code>override_ogg</code> angegebene Datei „<nowiki>$1</nowiki>“ ist ungültig. Bitte nur den Dateinamen angeben und dabei <nowiki>[[…]]</nowiki> sowie das Prefix „{{ns:file}}:“ weglassen.',
	'score-midioverridenotfound' => 'Die zu <code>override_midi</code> angegebene Datei „<nowiki>$1</nowiki>“ konnte nicht gefunden werden. Bitte nur den Dateinamen angeben und dabei <nowiki>[[…]]</nowiki> sowie das Prefix „{{ns:file}}:“ weglassen.',
	'score-noabcinput' => 'Die ABC-Quelldatei $1 konnte nicht erstellt werden.',
	'score-noimages' => 'Es wurden keine Bilder zur Partitur generiert. Bitte prüfe den Code zur Partitur.',
	'score-noinput' => 'Die Eingabedatei $1 für LilyPond konnte nicht erstellt werden.',
	'score-noogghandler' => 'Um eine Ogg-Vorbnis-Konvertierung durchführen zu können, muss eine Erweiterung zur Nutzung von Ogg installiert sein. Siehe hierzu die [//www.mediawiki.org/wiki/Extension:OggHandler Erweiterung OggHandler].',
	'score-nomidi' => 'Ungeachtet einer entsprechenden Anforderung wurde keine MIDI-Datei generiert. Sofern der reine LilyPond-Modus genutzt wird, muss ein richtiger „\\midi“-Block angegeben werden.',
	'score-nooutput' => 'Das Ausgabeverzeichnis $1 konnte nicht erstellt werden.',
	'score-notexecutable' => 'LilyPond konnte nicht ausgeführt werden: $1 ist eine nicht ausführbare Datei. Es muss sichergestellt sein, dass <code>$wgScoreLilyPond</code> in der Konfigurationsdatei richtig eingestellt wurde.',
	'score-novorbislink' => 'Es konnte kein Ogg-Vorbis-Link generiert werden: $1',
	'score-oggconversionerr' => 'MIDI konnte nicht in Ogg-Vorbis konvertiert werden:
$1',
	'score-oggoverridenotfound' => 'Die zu <code>override_ogg</code> angegebene Datei „<nowiki>$1</nowiki>“ ist nicht vorhanden.',
	'score-page' => 'Seite $1',
	'score-pregreplaceerr' => 'Die PCRE-Musterersetzung ist gescheitert.',
	'score-readerr' => 'Die Datei $1 kann nicht gelesen werden.',
	'score-timiditynotexecutable' => 'TiMidity++ konnte nicht ausgeführt werden: $1 ist keine ausführbare Datei. Es muss sichergestellt sein, dass <code>$wgScoreTimidity</code> in der Konfigurationsdatei richtig eingestellt wurde.',
	'score-renameerr' => 'Beim Verschieben der Partiturdateien in das Verzeichnis zum Hochladen ist ein Fehler aufgetreten',
	'score-trimerr' => 'Das Bild konnte nicht zugeschnitten werden:
$1 
In der Konfigurationsdatei muss <code>$wgScoreTrim = false;</code> festgelegt werden, sofern das Problem bestehen bleibt.',
	'score-versionerr' => 'Die Version von LilyPond konnte nicht ermittelt werden:
$1',
	'score-vorbisoverrideogg' => 'Es kann kein Ogg-Vorbis-Rendern angefordert und gleichzeitig <code>override_ogg</code> angegeben werden.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'score-noimages' => 'Es wurden keine Bilder zur Partitur generiert. Bitte prüfen Sie den Code zur Partitur.',
);

/** French (Français)
 * @author Crochet.david
 * @author Gomoko
 * @author Od1n
 * @author Seb35
 */
$messages['fr'] = array(
	'score-abc2lynotexecutable' => 'Le convertisseur ABC vers LilyPond n\'a pas pu être exécuté: $1 n\'est pas un fichier exécutable. Assurez-vous que <code>$wgScoreAbc2Ly</code> est défini correctement.',
	'score-abcconversionerr' => 'Impossible de convertir le fichier ABC au format LilyPond:
$1',
	'score-chdirerr' => 'Impossible de changer de répertoire vers $1',
	'score-cleanerr' => 'Impossible d’effacer les anciens fichiers avant de regénérer',
	'score-compilererr' => 'Impossible de compiler le fichier d’entrée LilyPond :
$1',
	'score-desc' => 'Ajoute une balise pour le rendu d’extraits musicaux avec LilyPond',
	'score-getcwderr' => 'Impossible d’obtenir le répertoire de travail actuel',
	'score-invalidlang' => 'Langage de partition invalide lang="<nowiki>$1</nowiki>". Les langages actuellement reconnus sont lang="lilypond" (par défaut) et lang="ABC".',
	'score-invalidoggoverride' => 'Le fichier "<nowiki>$1</nowiki>" que vous avez spécifié avec override_ogg n\'est pas valide. Veuillez spécifier uniquement le nom du fichier, omettez <nowiki>[[…]]</nowiki> et le préfixe "{{ns:file}}:".',
	'score-midioverridenotfound' => 'Le fichier "<nowiki>$1</nowiki>" que vous avez spécifié avec override_midi est introuvable. Veuillez spécifier uniquement le nom du fichier, sans <nowiki>[[…]]</nowiki> et le préfixe "{{ns:file}}:".',
	'score-noabcinput' => "Le fichier source ABC $1 n'a pas pu être créé.",
	'score-noimages' => "Aucune image de résultat n'a été générée. Veuillez vérifier votre code de résultat.",
	'score-noinput' => 'Erreur lors de la création du fichier d’entrée $1 LilyPond',
	'score-noogghandler' => 'La conversion Ogg/Vorbis nécessite une extension OggHandler installée et configurée, voir [//www.mediawiki.org/wiki/Extension:OggHandler Extension:OggHandler].',
	'score-nomidi' => 'Pas de fichier MIDI généré malgré la demande. Si vous travaillez en mode brut de LilyPond, assurez-vous de fournir un bloc \\midi correct.',
	'score-nooutput' => 'Erreur lors de la création du répertoire de sortie $1.',
	'score-notexecutable' => 'Impossible d’exécuter LilyPond: $1 n\'est pas un fichier exécutable. Vérifiez que <code>$wgScoreLilyPond</code> est correctement configuré.',
	'score-novorbislink' => 'Impossible de générer un lien Ogg/Vorbis: $1',
	'score-oggconversionerr' => 'Impossible de convertir de MIDI en Ogg/Vorbis:
$1',
	'score-oggoverridenotfound' => 'Le fichier "<nowiki>$1</nowiki>" que vous avez spécifié avec override_ogg n’existe pas.',
	'score-page' => 'Page $1',
	'score-pregreplaceerr' => "Le remplacement de l'expression régulière PCRE a échoué",
	'score-readerr' => 'Impossible de lire le fichier $1',
	'score-timiditynotexecutable' => "TiMidity++ n'a pas pu s'exécuter: \$1 n'est pas un fichier exécutable. Assurez-vous que <code>\$wgScoreTimidity</code> est défini correctement.",
	'score-renameerr' => 'Erreur lors du déplacement des fichiers de musique vers le répertoire de téléversement',
	'score-trimerr' => 'L\'image n\'a pas pu être retaillée:
$1
Paramétrez <code>$wgScoreTrim=false</code> si ce problème persiste.',
	'score-versionerr' => "Impossible d'obtenir la version de LilyPond:
$1",
	'score-vorbisoverrideogg' => 'Vous ne peut pas demander de rendu de Ogg/Vorbis et spécifier override_ogg en même temps.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'score-abc2lynotexecutable' => 'Non se puido executar o conversor ABC a LilyPond: "$1" non é un ficheiro executable. Asegúrese de que <code>$wgScoreAbc2Ly</code> está definido correctamente.',
	'score-abcconversionerr' => 'Non se puido converter o ficheiro ABC ao formato LilyPond:
$1',
	'score-chdirerr' => 'Non se puido cambiar ao directorio "$1"',
	'score-cleanerr' => 'Non se puideron limpar os ficheiros vellos antes de volver renderizar',
	'score-compilererr' => 'Non se puido compilar o ficheiro de entrada LilyPond:
$1',
	'score-desc' => 'Engade unha etiqueta para renderizar partituras musicais co LilyPond',
	'score-getcwderr' => 'Non se puido obter o directorio de traballo actual',
	'score-invalidlang' => 'A lingua da partitura lang="<nowiki>$1</nowiki>" é incorrecta. As linguas recoñecidas nestes momentos son lang="lilypond" (predeterminada) e lang="ABC".',
	'score-invalidoggoverride' => 'O ficheiro "<nowiki>$1</nowiki>" que especificou con override_ogg non é válido. Especifique unicamente o nome do ficheiro, omita <nowiki>[[…]]</nowiki> e o prefixo "{{ns:file}}:".',
	'score-midioverridenotfound' => 'O ficheiro "<nowiki>$1</nowiki>" que especificou con override_midi non se puido atopar. Especifique unicamente o nome do ficheiro, omita <nowiki>[[…]]</nowiki> e o prefixo "{{ns:file}}:".',
	'score-noabcinput' => 'Non se puido crear o ficheiro de fonte ABC "$1".',
	'score-noimages' => 'Non se xerou ningunha imaxe de partitura. Comprobe o código.',
	'score-noinput' => 'Erro ao crear o ficheiro de entrada "$1" do LilyPond.',
	'score-noogghandler' => 'Para a conversión Ogg/Vorbis cómpre unha extensión OggHandler instalada e configurada; olle [//www.mediawiki.org/wiki/Extension:OggHandler Extension:OggHandler].',
	'score-nomidi' => 'Non se xerou ficheiro MIDI ningún malia a solicitude. Se está a traballar no modo LilyPond en bruto asegúrese de proporcionar un bloque \\midi axeitado.',
	'score-nooutput' => 'Erro ao crear o directorio de saída "$1".',
	'score-notexecutable' => 'Non se puido executar o LilyPond: "$1" non é un ficheiro executable. Asegúrese de que <code>$wgScoreLilyPond</code> está definido correctamente.',
	'score-novorbislink' => 'Non se puido xerar a ligazón Ogg/Vorbis: $1',
	'score-oggconversionerr' => 'Non se puido converter o MIDI a Ogg/Vorbis:
$1',
	'score-oggoverridenotfound' => 'O ficheiro "<nowiki>$1</nowiki>" que especificou con override_ogg non existe.',
	'score-page' => 'Páxina $1',
	'score-pregreplaceerr' => 'Fallou a substitución da expresión regular PCRE',
	'score-readerr' => 'Non se puido ler o ficheiro "$1".',
	'score-timiditynotexecutable' => 'Non se puido executar o TiMidity++: "$1" non é un ficheiro executable. Asegúrese de que <code>$wgScoreTimidity</code> está definido correctamente.',
	'score-renameerr' => 'Erro ao mover os ficheiros das partituras ao directorio de cargas.',
	'score-trimerr' => 'Non se puido axustar a imaxe:
$1
Defina <code>$wgScoreTrim=false</code> se o problema persiste.',
	'score-versionerr' => 'Non se puido obter a versión do LilyPond:
$1',
	'score-vorbisoverrideogg' => 'Non pode solicitar unha renderización Ogg/Vorbis e asemade especificar override_ogg.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'score-page' => 'Strona $1',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'score-abc2lynotexecutable' => 'Le convertitor ABC a LilyPond non poteva esser executate: $1 non es un file executabile. Assecura te que <code>$wgScoreAbc2Ly</code> es definite correctemente.',
	'score-abcconversionerr' => 'Impossibile converter le file ABC al formato LilyPond:
$1',
	'score-chdirerr' => 'Impossibile cambiar al directorio $1',
	'score-cleanerr' => 'Impossibile rader le vetere files ante de regenerar',
	'score-compilererr' => 'Impossibile compilar le file de entrata LilyPond:
$1',
	'score-desc' => 'Adde un etiquetta pro le rendition de partituras musical con LilyPond',
	'score-getcwderr' => 'Impossibile obtener le directorio de labor actual',
	'score-invalidlang' => 'Linguage de partitura invalide: lang="<nowiki>$1</nowiki>". Le linguages actualmente recognoscite es lang="lilypond" (le predefinition) e lang="ABC".',
	'score-invalidoggoverride' => 'Le file "<nowiki>$1</nowiki>" que tu specificava con override_ogg es invalide. Per favor specifica le nomine del file solmente, omittente <nowiki>[[…]]</nowiki> e le prefixo "{{ns:file}}:".',
	'score-midioverridenotfound' => 'Le file "<nowiki>$1</nowiki>" que tu specificava con override_ogg non poteva esser trovate. Per favor specifica le nomine del file solmente, omittente <nowiki>[[…]]</nowiki> e le prefixo "{{ns:file}}:".',
	'score-noabcinput' => 'Le file de fonte ABC $1 non poteva esser create.',
	'score-noimages' => 'Nulle imagine de partitura ha essite generate. Per favor verifica tu codice de partitura.',
	'score-noinput' => 'Le creation del file de entrata LilyPond $1 ha fallite.',
	'score-noogghandler' => 'Le conversion in Ogg/Vorbis require un extension OggHandler installate e configurate, vide [//www.mediawiki.org/wiki/Extension:OggHandler Extension:OggHandler].',
	'score-nomidi' => 'Nulle file MIDI ha essite generate, malgrado que illo esseva requestate. Si tu travalia in modo LilyPond brute, assecura te de fornir un bloco \\midi correcte.',
	'score-nooutput' => 'Le creation del directorio de output $1 ha fallite.',
	'score-notexecutable' => 'Impossibile executar LilyPond: $1 non es un file executabile. Assecura te que <code>$wgScoreLilyPond</code> es definite correctemente.',
	'score-novorbislink' => 'Impossibile generar ligamine Ogg/Vorbis: $1',
	'score-oggconversionerr' => 'Impossibile converter MIDI in Ogg/Vorbis:
$1',
	'score-oggoverridenotfound' => 'Le file "<nowiki>$1</nowiki>" que tu specificava con override_ogg non existe.',
	'score-page' => 'Pagina $1',
	'score-pregreplaceerr' => 'Le reimplaciamento del expression regular PCRE ha fallite',
	'score-readerr' => 'Impossibile leger le file $1.',
	'score-timiditynotexecutable' => 'TiMidity++ non poteva esser executate: $1 non es un file executabile. Assecura te que <code>$wgScoreTimidity</code> es definite correctemente.',
	'score-renameerr' => 'Error durante le displaciamento de files de partitura al directorio de incargamento.',
	'score-trimerr' => 'Le imagine non poteva esser taliate:
$1
Defini <code>$wgScoreTrim=false</code> si iste problema persiste.',
	'score-versionerr' => 'Impossibile obtener le version de LilyPond:
$1',
	'score-vorbisoverrideogg' => 'Tu non pote requestar un rendition in Ogg/Vorbis e specificar override_ogg al mesme tempore.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'score-chdirerr' => 'Et konnt net op de Repertoire $1 gewiesselt ginn',
	'score-oggoverridenotfound' => 'De Fichier "<nowiki>$1</nowiki>" deen Dir mat override_ogg uginn hutt  gëtt et net.',
	'score-page' => 'Säit $1',
	'score-readerr' => 'De Fichier $1 konnt net geliest ginn.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'score-abc2lynotexecutable' => 'Не можев да го извршам претворањето од ABC во LilyPond:$1 не е извршна податотека. Проверете дали <code>$wgScoreAbc2Ly</code> е правилно наместен.',
	'score-abcconversionerr' => 'Не можам да ја претворам ABC податотеката во формат LilyPond:
$1',
	'score-chdirerr' => 'Не можам да го сменам директориумот $1',
	'score-cleanerr' => 'Не можам да ги исчистам старите податотеки пред да извршам повторен испис',
	'score-compilererr' => 'Не можам да составам влезна податотека за LilyPond:
$1',
	'score-desc' => 'Додава ознака за испис на музички партитури со LilyPond',
	'score-getcwderr' => 'Не можам да го добијам тековниот работен директориум',
	'score-invalidlang' => 'lang="<nowiki>$1</nowiki>" не е важечки јазик за партитурата. Моментално се признаваат јазиците lang="lilypond" (основниот) и lang="ABC".',
	'score-invalidoggoverride' => 'Податотеката „<nowiki>$1</nowiki>“ што ја укажавте со override_ogg е неважечка. Укажете го само нејзиното име, изоставувајќи го <nowiki>[[…]]</nowiki> и префиксот „{{ns:file}}:“.',
	'score-midioverridenotfound' => 'Податотеката „<nowiki>$1</nowiki>“ што ја укажавте со override_midi не е пронајдена. Укажете го само нејзиното име, изоставувајќи го <nowiki>[[…]]</nowiki> и префиксот „{{ns:file}}:“.',
	'score-noabcinput' => 'Не можев да ја создадам изворната ABC податотека $1.',
	'score-noimages' => 'Не создадов партитурни слики. Проверете го кодот.',
	'score-noinput' => 'Не можев да ја создадам влезната податотека $1 за LilyPond.',
	'score-noogghandler' => 'Претворањето во Ogg/Vorbis бара инсталиран и наместен додаток OggHandler. Погл. [//www.mediawiki.org/wiki/Extension:OggHandler?uselang=mk Extension:OggHandler].',
	'score-nomidi' => 'Не е создадена MIDI податотека и покрај барањето. Ако работите во сиров режим на LilyPond, не заборавајте да ставите соодветен \\midi блок.',
	'score-nooutput' => 'Не можев да го создадам излезниот директориум $1',
	'score-notexecutable' => 'Не можев да го пуштам LilyPond. $1 не е извршна податотека. Проверете дали <code>$wgScoreLilyPond</code> е правилно наместен.',
	'score-novorbislink' => 'Не можам да создадам врска за Ogg/Vorbis: $1',
	'score-oggconversionerr' => 'Не можам да го претворам ова MIDI во Ogg/Vorbis:
$1',
	'score-oggoverridenotfound' => 'Податотеката „<nowiki>$1</nowiki>“ што ја укажавте со override_ogg не постои.',
	'score-page' => 'Страница $1',
	'score-pregreplaceerr' => 'Не успеа замената на регуларниот израз PCRE',
	'score-readerr' => 'Не можам да ја прочитам податотеката $1',
	'score-timiditynotexecutable' => 'TiMidity++ не може да се изврши: $1 не е извршна податотека. Проверете дали <code>$wgScoreTimidity</code> е правилно зададено.',
	'score-renameerr' => 'Грешка при преместувањето на партитурните податотеки во директориумот за подигања',
	'score-trimerr' => 'Не можев да ја скастрам сликата. 
$1
Ако проблемот продолжи да се јавува, задајте <code>$wgScoreTrim=false</code>.',
	'score-versionerr' => 'Не можам да ја добијам верзијата на LilyPond.
$1',
	'score-vorbisoverrideogg' => 'Не можете истовремено да побарате испис во Ogg/Vorbis и да укажете override_ogg.',
);

/** Dutch (Nederlands)
 * @author Patio
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'score-abc2lynotexecutable' => 'Het conversieprogramma voor ABC naar LilyPond kon niet uitgevoerd worden: $1 is geen uitvoerbaar bestand. Zorg dat de instelling <code>$wgScoreAbc2Ly</code> correct is.',
	'score-abcconversionerr' => 'Het was niet mogelijk het ABC-bestand om te zetten naar LilyPond:
$1',
	'score-chdirerr' => 'Het was niet mogelijk naar de map $1 te gaan.',
	'score-cleanerr' => 'Het was niet mogelijk de oude bestanden op te ruimen voor het opnieuw aanmaken van de afbeeldingen',
	'score-compilererr' => 'Het was niet mogelijk de LilyPondinvoer te compileren:
$1',
	'score-desc' => 'Voegt een label toe voor het weergeven van bladmuziek met LilyPond',
	'score-getcwderr' => 'Het was niet mogelijk de ingestelde werkmap te gebruiken',
	'score-invalidlang' => 'Er is een onjuiste taal voor bladmuziek aangegeven (lang="<nowiki>$1</nowiki>"). Op dit moment worden lang="lilypond" (standaard) en lang="ABC" ondersteund.',
	'score-invalidoggoverride' => 'Het bestand "<nowiki>$1</nowiki>" dat u hebt opgegeven met "override_ogg is ongeldig". Gebruik alleen de bestandsnaam, laat <nowiki>[[…]]</nowiki> weg en gebruik het voorvoegsel "{{ns:file}}:".',
	'score-noabcinput' => 'Het ABC-bronbestand $1 kon niet aangemaakt worden',
	'score-noimages' => 'Er zijn geen afbeeldingen met bladmuziek aangemaakt. Controleer uw notatie.',
	'score-noinput' => 'Het was niet mogelijk het invoerbestand $1 voor LilyPond aan te maken',
	'score-noogghandler' => 'Voor het omzetten naar Ogg/Vorbis moet de uitbreiding OggHandler geïnstalleerd en ingesteld zijn. Zie [//www.mediawiki.org/wiki/Extension:OggHandler Extension:OggHandler].',
	'score-nomidi' => 'Ondank een verzoek, is er geen MIDI-bestand aangemaakt. Als u in de modus LilyPond ruw werkt, zorg dan dat u een correcte opmaak van het onderdeel "\\midi" hebt.',
	'score-nooutput' => 'Het was niet mogelijk de uitvoermap $1 aan te maken',
	'score-notexecutable' => 'Het was niet mogelijk om LilyPond uit te voeren: $1 is geen uitvoerbaar bestand. Zorg dat de instelling <code>$wgScoreLilyPond</code> correct is.',
	'score-novorbislink' => 'Het was niet mogelijk een Ogg/Vorbis-verwijzing aan te maken: $1',
	'score-oggconversionerr' => 'Het was niet mogelijk MIDI naar Ogg/Vorbis om te zetten:
$1',
	'score-oggoverridenotfound' => 'Het bestand "<nowiki>$1</nowiki>" dat u hebt opgegeven met "override_ogg" bestaat niet.',
	'score-page' => 'Pagina $1',
	'score-pregreplaceerr' => 'Vervangen met behulp van een PCRE reguliere expressie is mislukt',
	'score-readerr' => 'Het bestand $1 kan niet gelezen worden.',
	'score-timiditynotexecutable' => 'TiMidity++ kon niet uitgevoerd worden: $1 is geen uitvoerbaar bestand. Zorg dat de instelling <code>$wgScoreTimidity</code> correct is.',
	'score-renameerr' => 'Er is een fout opgetreden tijdens het verplaatsen van de bladmuziekbestanden naar de uploadmap',
	'score-trimerr' => 'De afbeelding kon niet bijgesneden worden:
$1
Stel de volgende waarde in als dit probleem blijft bestaan: <code>$wgScoreTrim=false</code>.',
	'score-versionerr' => 'Het was niet mogelijk de LiliPond-versie te achterhalen:
$1',
	'score-vorbisoverrideogg' => 'U kunt niet vragen om Ogg/Vorbisrendering en tegelijkertijd "override_ogg" gebruiken.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'score-abc2lynotexecutable' => 'Không thể thực thi trình chuyển đổi ABC qua LilyPond: $1 không phải là một tập tin thực thi. Hãy chắc chắn rằng <code>$wgScoreAbc2Ly</code> có giá trị chính xác.',
	'score-abcconversionerr' => 'Không thể chuyển đổi tập tin ABC qua định dạng LilyPond:
$1',
	'score-chdirerr' => 'Không thể chuyển đến thư mục $1',
	'score-cleanerr' => 'Không thể xóa sạch các tập tin cũ trước khi kết xuất lại',
	'score-compilererr' => 'Không thể biên dịch tập tin đầu vào LilyPond:
$1',
	'score-desc' => 'Cung cấp thẻ để vẽ tài liệu âm nhạc dùng LilyPond',
	'score-getcwderr' => 'Không thể lấy thư mục làm việc hiện tại',
	'score-invalidlang' => 'Ngôn ngữ nốt nhạc lang="<nowiki>$1</nowiki>" không hợp lệ. Các ngôn ngữ đang được chấp nhận là lang="lilypond" (mặc định) và lang="ABC".',
	'score-invalidoggoverride' => 'Tập tin “<nowiki>$1</nowiki>” mà bạn chỉ định override_ogg không hợp lệ. Xin vui lòng chỉ đưa vào tên tập tin; bỏ qua <nowiki>[[…]]</nowiki> và tiền tố “{{ns:file}}:”.',
	'score-midioverridenotfound' => 'Tập tin “<nowiki>$1</nowiki>” mà bạn chỉ định override_midi không hợp lệ. Xin vui lòng chỉ đưa vào tên tập tin; bỏ qua <nowiki>[[…]]</nowiki> và tiền tố “{{ns:file}}:”.',
	'score-noabcinput' => 'Không thể tạo ra tập tin mã nguồn ABC $1.',
	'score-noimages' => 'Các hình tài liệu âm nhạc không được tạo ra. Xin vui lòng kiểm tra lại mã nguồn.',
	'score-noinput' => 'Thất bại trong việc tạo ra tập tin đầu vào LilyPond $1.',
	'score-noogghandler' => 'Tính năng chuyển đổi Ogg/Vorbis cần cài đặt và thiết lập phần mở rộng OggHandler; xem [//www.mediawiki.org/wiki/Extension:OggHandler/vi?uselang=vi Extension:OggHandler].',
	'score-nomidi' => 'Tập tin MIDI đã yêu cầu không được tạo ra. Nếu bạn đang làm việc trong chế độ LilyPond nguyên văn, hãy chắc chắn cung cấp một khối \\midi hợp lệ.',
	'score-nooutput' => 'Thất bại trong việc tạo ra thư mục đầu ra $1.',
	'score-notexecutable' => 'Không thể thực thi LilyPond: $1 không phải là một tập tin thực thi. Hãy chắc chắn rằng <code>$wgScoreLilyPond</code> có giá trị chính xác.',
	'score-novorbislink' => 'Không thể tạo ra liên kết Ogg/Vorbis: $1',
	'score-oggconversionerr' => 'Không thể chuyển đổi MIDI qua Ogg/Vorbis:
$1',
	'score-oggoverridenotfound' => 'Tập tin “<nowiki>$1</nowiki>” mà bạn chỉ định override_ogg không tồn tại.',
	'score-page' => 'Trang $1',
	'score-pregreplaceerr' => 'Thất bại trong việc thay thế theo biểu thưc chính quy PCRE',
	'score-readerr' => 'Không thể đọc tập tin $1.',
	'score-timiditynotexecutable' => 'Không thể thực thi TiMidity++: $1 không phải là một tập tin thực thi. Hãy chắc chắn rằng <code>$wgScoreTimidity</code> có giá trị chính xác.',
	'score-renameerr' => 'Lỗi khi di chuyển các tập tin tài liệu âm nhạc sang thư mục tải lên.',
	'score-trimerr' => 'Không thể tỉa hình:
$1
Nếu vấn đề này vẫn còn xuất hiện, hãy đặt <code>$wgScoreTrim=false</code>.',
	'score-versionerr' => 'Không thể lấy phiên bản của LilyPond:
$1',
	'score-vorbisoverrideogg' => 'Bạn không thể yêu cầu kết xuất Ogg/Vorbis và định override_ogg cùng lúc.',
);

