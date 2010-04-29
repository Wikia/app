<?php
global $wgSitename;

$messages = array();

$messages['en'] = array( 
	'newwikibuilder' => 'New Wiki Builder',
	"nwb-choose-a-file" => "Please choose a file",
	"nwb-error-saving-description" => "Error Saving Description",
	"nwb-error-saving-theme" => "Error Saving Theme",
	"nwb-error-saving-articles" => "Error Saving Pages",
	"nwb-error-saving-logo" => "Error Uploading Logo",
	"nwb-saving-articles" => "Saving Pages...",
	"nwb-finalizing" => "Finalizing...",
	"nwb-articles-saved" => "Pages Saved",
	"nwb-theme-saved" => "Theme Choice Saved",
	"nwb-saving-description" => "Saving Description...",
	"nwb-description-saved" => "Description Saved",
	"nwb-uploading-logo" => "Uploading Logo...",
	"nwb-readonly-try-again" => "The Wiki is currently in readonly mode. Please try again in a few moments",
	"nwb-logo-uploaded" => "Logo Uploaded",
	"nwb-login-successful" => "Login Successful",
	"nwb-logout-successful" => "Logout Successful",
	"nwb-login-error" => "Error logging in",
	"nwb-logging-in" => "Logging in...",
	"nwb-api-error" => "There was a problem:",
	"nwb-no-more-pages" => "No more pages can be created",
	"nwb-must-be-logged-in" => "You must be logged in for this action",
	"nwb-skip-this-step" => "Skip this step",
	"nwb-coming-soon" => "Coming Soon",
	"nwb-new-pages" => "New pages",
	"nwb-unable-to-edit-description" => "The description is uneditable with New Wiki Builder",
	"nwb-step1-headline" => "Describe your wiki",
	"nwb-step1-text" => "<p>Let's start setting up <b>". $wgSitename ."</b>. You can skip any step and come back to it later on.</p><p>First: Write a message for the front page of your wiki that describes what ". $wgSitename ." is about.</p>",
	"nwb-step1-example" => "<b>Example</b><br />Muppet Wiki is an encyclopedia about everything related to Jim Henson, The Muppet Show and Sesame Street. The wiki format allows anyone to create or edit any article, so we can all work together to create a comprehensive database for fans of the Muppets.",
	"nwb-step2-headline" => "Upload a logo",
	"nwb-step2-text" => "<p>Next: Choose a logo for <b>". $wgSitename ."</b>.</p><p>Upload a picture from your computer to represent your wiki.</p><p>You can skip this step if you don't have a picture that you want to use right now.</p>",
	"nwb-step2-example" => "This would be a good logo for a skateboarding wiki.",
	"nwb-step3-headline" => "Pick a theme",
	"nwb-step3-text" => "<p>Now choose a color scheme for <b>". $wgSitename ."</b>.</p><p>You can change this later on if you change your mind.</p>",
	"nwb-step4-headline" => "Create pages",
	"nwb-step4-text" => "<p>What do you want to write about?</p><p>Make a list of some pages you want to have on your wiki.</p>",
	"nwb-step4-example" => "<b>Example</b><p>For a Monster Movie Wiki, your first pages would be: <ul class=\"bullets\"><li>Dracula</li><li>Frankenstein's Monster</li><li>The Wolfman</li><li>The Mummy</li></ul></p><p>For a Board Games Wiki: <ul class=\"bullets\"><li>Monopoly</li><li>Risk</li><li>Scrabble</li><li>Trivial Pursuit</li></ul></p>",
	"nwb-step5-headline" => "What's Next?",
	"nwb-step5-text" => "<p>That's all the steps! <b>{{SITENAME}}</b> is ready to go.</p><p>Now it's time to start writing and adding some pictures, to give people something to read when they find your wiki.</p><p>The list of pages that you made in the last step has been added to a \"New pages\" box on the main page. You can get started by clicking on those pages. Have fun!</p>",
	"nwb-preview" => "Preview",
	"nwb-logo-preview" => "Logo preview",
	"nwb-choose-logo" => "Choose logo",
	"nwb-save-description" => "Save Description",
	"nwb-save-theme" => "Save Theme",
	"nwb-create-pages" => "Create Pages",
	"nwb-save-logo" => "Save Logo",
	"nwb-go-to-your-wiki" => "Go to your wiki",
	"nwb-back-to-step-1" => "Back to step 1",
	"nwb-back-to-step-2" => "Back to step 2",
	"nwb-back-to-step-3" => "Back to step 3",
	"nwb-back-to-step-4" => "Back to step 4",
	"nwb-or" => "or",
	"nwb-new-pages-text" => "[[File:Placeholder|right|300px]]
Write the first paragraph of your article here.

==Section heading==

Write the first section of your article here. Remember to include links to other pages on the wiki.

==Section heading==

Write the second section of your article here. Don't forget to add a category, to help people find the article.",
	"nwb-sample-question-1" => "What is this site about?",
	"nwb-sample-question-2" => "Who created this site?",
        "nwb-question" => "Question",
        "nwb-tag" => "Tag"
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'nwb-choose-a-file' => "Kies 'n lêer",
	'nwb-error-saving-description' => 'Fout met die stoor van die beskrywing',
	'nwb-error-saving-theme' => 'Fout met die stoor van die tema',
	'nwb-error-saving-articles' => 'Fout met die stoor van bladsye',
	'nwb-error-saving-logo' => 'Fout met die oplaai van die logo',
	'nwb-saving-articles' => 'Stoor bladsye...',
	'nwb-finalizing' => 'Finalisering...',
	'nwb-articles-saved' => 'Bladsye is gestoor',
	'nwb-theme-saved' => 'Die gekose tema is gestoor',
	'nwb-saving-description' => 'Besig om die beskrywing te stoor...',
	'nwb-description-saved' => 'Beskrywing is gestoor',
	'nwb-uploading-logo' => 'Besig met die oplaai van die logo...',
	'nwb-logo-uploaded' => 'Die logo is opgelaai',
	'nwb-login-successful' => 'Suksesvol aangeteken',
	'nwb-logout-successful' => 'Suksesvol afgeteken',
	'nwb-login-error' => 'Fout met aanmelding',
	'nwb-logging-in' => 'Besig met aanmelding...',
	'nwb-api-error' => "Daar was 'n probleem:",
	'nwb-no-more-pages' => 'Geen bladsye kan meer geskep word nie',
	'nwb-must-be-logged-in' => 'U moet aanteken alvorens u hierdie aksie kan uitvoer',
	'nwb-skip-this-step' => 'Slaan hierdie stap oor',
	'nwb-coming-soon' => 'Binnekort',
	'nwb-new-pages' => 'Nuwe bladsye',
	'nwb-step1-headline' => 'Beskryf u wiki',
	'nwb-step2-headline' => 'Laai logo op',
	'nwb-step3-headline' => "Kies 'n tema",
	'nwb-step4-headline' => 'Skep bladsye',
	'nwb-step5-headline' => 'Wat is volgende?',
	'nwb-preview' => 'Voorskou',
	'nwb-logo-preview' => 'Logo voorskou',
	'nwb-choose-logo' => "Kies 'n logo",
	'nwb-save-description' => 'Stoor beskrywing',
	'nwb-save-theme' => 'Stoor tema',
	'nwb-create-pages' => 'Skep bladsye',
	'nwb-save-logo' => 'Stoor logo',
	'nwb-go-to-your-wiki' => 'Gaan na u wiki',
	'nwb-back-to-step-1' => 'Terug na stap 1',
	'nwb-back-to-step-2' => 'Terug na stap 2',
	'nwb-back-to-step-3' => 'Terug na stap 3',
	'nwb-back-to-step-4' => 'Terug na stap 4',
	'nwb-or' => 'of',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'nwb-uploading-logo' => 'Загрузка лягатыпу…',
	'nwb-logo-uploaded' => 'Лягатып загружаны',
	'nwb-step2-headline' => 'Загрузіць лягатып',
	'nwb-save-description' => 'Захаваць апісаньне',
	'nwb-save-theme' => 'Захаваць тэму',
	'nwb-save-logo' => 'Захаваць лягатып',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'newwikibuilder' => 'Saver wikioù nevez',
	'nwb-choose-a-file' => 'Mar plij dibabit ur restr',
	'nwb-error-saving-description' => "Ur fazi 'zo bet e-pad enrolladenn an diskrivadur",
	'nwb-error-saving-theme' => 'Ur fazi a zo bet e-pad enrolladenn an dodenn',
	'nwb-error-saving-articles' => 'Ur fazi a zo bet e-pad enrolladenn ar pajennoù',
	'nwb-saving-articles' => "Oc'h enrollañ pajennoù...",
	'nwb-finalizing' => 'O finvezekaat...',
	'nwb-articles-saved' => 'Pajennoù enrollet',
	'nwb-theme-saved' => 'Dibab an dodenn enrollet',
	'nwb-uploading-logo' => "Oc'h enporzhiañ al Logo...",
	'nwb-logo-uploaded' => 'Logo enporzhiet',
	'nwb-login-successful' => "Kevreet oc'h",
	'nwb-logout-successful' => "Digevreet oc'h",
	'nwb-login-error' => "Ur fazi  'zo bet pa oac'h o kevreañ",
	'nwb-logging-in' => 'Kevreadenn...',
	'nwb-api-error' => 'Ur gudenn a zo bet :',
	'nwb-no-more-pages' => "Ne c'hell bezañ krouet pajenn ebet all",
	'nwb-must-be-logged-in' => "Evit ober kement-mañ e rankoc'h bezañ luget",
	'nwb-skip-this-step' => 'Tremen al lodenn-mañ',
	'nwb-coming-soon' => 'Bez e vo dioutañ a-benn nebeut',
	'nwb-new-pages' => 'Pajennoù nevez',
	'nwb-step1-headline' => 'Diskrivit ho wiki',
	'nwb-step2-headline' => 'Enporzhiañ ul logo',
	'nwb-step3-headline' => 'Diuzit un dodenn',
	'nwb-step4-headline' => 'Krouiñ pajennoù',
	'nwb-step5-headline' => "Petra 'zo da heul ?",
	'nwb-preview' => 'Rakwelet',
	'nwb-logo-preview' => 'Rakwelet al logo',
	'nwb-choose-logo' => 'Dibabit al logo',
	'nwb-save-description' => 'Enrollañ an deskrivadur',
	'nwb-save-theme' => 'Enrollañ an tem',
	'nwb-create-pages' => 'Krouiñ pajennoù',
	'nwb-save-logo' => 'Enrollañ al Logo',
	'nwb-go-to-your-wiki' => "Mont d'ho wiki",
	'nwb-back-to-step-1' => "Distreiñ d'ar bazenn 1",
	'nwb-back-to-step-2' => "Distreiñ d'ar bazenn 2",
	'nwb-back-to-step-3' => "Distreiñ d'ar bazenn 3",
	'nwb-back-to-step-4' => "Distreiñ d'ar bazenn 4",
	'nwb-or' => 'pe',
);

/** German (Deutsch) */
$messages['de'] = array(
	'nwb-choose-a-file' => 'Wähle eine Datei',
	'nwb-error-saving-description' => 'Fehler beim Speichern der Beschreibung',
	'nwb-error-saving-theme' => 'Fehler beim Speichern des Farbschemas',
	'nwb-error-saving-articles' => 'Fehler beim Speichern der Seiten',
	'nwb-error-saving-logo' => 'Fehler beim Hochladen des Logos',
	'nwb-saving-articles' => 'Speichere Seiten...',
	'nwb-finalizing' => 'Gleich fertig...',
	'nwb-articles-saved' => 'Seiten gespeichert',
	'nwb-theme-saved' => 'Farbschema-Auswahl gespeichert',
	'nwb-saving-description' => 'Speichere Beschreibung...',
	'nwb-description-saved' => 'Beschreibung gespeichert',
	'nwb-uploading-logo' => 'Lade Logo hoch...',
	'nwb-readonly-try-again' => 'Das Wiki ist momentan im "Nur Lesen"-Modus. Bitte warte kurz und probiere es erneut.',
	'nwb-logo-uploaded' => 'Logo hochgeladen',
	'nwb-login-successful' => 'Anmeldung erfolgreich',
	'nwb-logout-successful' => 'Abmeldung erfolgreich',
	'nwb-login-error' => 'Fehler beim Anmelden',
	'nwb-logging-in' => 'Anmeldung...',
	'nwb-api-error' => 'Folgendes Problem ist aufgetreten:',
	'nwb-no-more-pages' => 'Es können keine weiteren Seiten erstellt werden',
	'nwb-must-be-logged-in' => 'Du musst angemeldet sein, um diese Aktion durchzuführen!',
	'nwb-skip-this-step' => 'Schritt überspringen',
	'nwb-new-pages' => 'Neue Seiten',
	'nwb-unable-to-edit-description' => 'Die Beschreibung kann mit dem New Wiki Builder nicht bearbeitet werden',
	'nwb-step1-headline' => 'Beschreibe dein Wiki',
	'nwb-step1-example' => '<b>Beispiel</b><br />Das Muppet-Wiki ist eine Enzyklopädie über alles was mit Jim Henson, der Muppetshow und der Sesamstraße zu tun hat. Jeder kann Artikel erstellen und bearbeiten, so dass wir zusammen an einer umfangreichen Datenbank für alle Muppet-Fans arbeiten können.',
	'nwb-step2-headline' => 'Logo hochladen',
	'nwb-step2-example' => 'Das hier wäre ein gutes Logo für ein Skateboard-Wiki.',
	'nwb-step3-headline' => 'Wähle ein Farbschema',
	'nwb-step4-headline' => 'Erstelle Seiten',
	'nwb-step4-text' => '<p>Worüber möchtest du schreiben?</p><p>Erstelle eine Liste einiger Seiten, die du in deinem Wiki haben möchtest.</p>',
	'nwb-step4-example' => '<b>Beispiel</b><p>In einem Monsterfilm-Wiki könnten deine ersten Seiten so aussehen: <ul class="bullets"><li>Drakula</li><li>Frankensteins Monster</li><li>Die Mumie</li><li>Tarantula</li></ul></p><p>Bei einem Wiki über Brettspiele: <ul class="bullets"><li>Monopoly</li><li>Risiko</li><li>Scrabble</li><li>Trivial Pursuit</li></ul></p>',
	'nwb-step5-headline' => 'Wie gehts weiter?',
	'nwb-preview' => 'Vorschau',
	'nwb-logo-preview' => 'Vorschau des Logos',
	'nwb-choose-logo' => 'Logo auswählen',
	'nwb-save-description' => 'Beschreibung speichern',
	'nwb-save-theme' => 'Farbschema speichern',
	'nwb-create-pages' => 'Seiten erstellen',
	'nwb-save-logo' => 'Logo speichern',
	'nwb-go-to-your-wiki' => 'Starte dein Wiki',
	'nwb-back-to-step-1' => 'Zurück zu Schritt 1',
	'nwb-back-to-step-2' => 'Zurück zu Schritt 2',
	'nwb-back-to-step-3' => 'Zurück zu Schritt 3',
	'nwb-back-to-step-4' => 'Zurück zu Schritt 4',
	'nwb-or' => 'oder',
	'nwb-new-pages-text' => '[[Datei:Platzhalter|thumb|300px]]
Ersetzte diesen Text durch deinen Artikel!',
);

/** Spanish (Español)
 * @author Translationista
 */
$messages['es'] = array(
	'newwikibuilder' => 'Nuevo Constructor Wiki',
	'nwb-choose-a-file' => 'Por favor, elige un archivo',
	'nwb-error-saving-description' => 'Error guardando la descripción',
	'nwb-error-saving-theme' => 'Error guardando apariencia',
	'nwb-error-saving-articles' => 'Error guardando páginas',
	'nwb-error-saving-logo' => 'Error guardando logo',
	'nwb-saving-articles' => 'Guardando páginas...',
	'nwb-finalizing' => 'Finalizando...',
	'nwb-articles-saved' => 'Páginas guardadas',
	'nwb-theme-saved' => 'Aspecto elegido guardado',
	'nwb-saving-description' => 'Guardando descripción...',
	'nwb-description-saved' => 'Descripción guardada',
	'nwb-uploading-logo' => 'Subiendo logo...',
	'nwb-readonly-try-again' => 'El wiki está actualmente en modo de solo lectura. Por favor, inténtalo de nuevo en unos momentos',
	'nwb-logo-uploaded' => 'Logo subido',
	'nwb-login-successful' => 'Identificado satisfactoriamente',
	'nwb-logout-successful' => 'Desconectado satisfactoriamente',
	'nwb-login-error' => 'Error en la identificación',
	'nwb-logging-in' => 'Identificándote...',
	'nwb-api-error' => 'Hubo un problema',
	'nwb-no-more-pages' => 'No pueden ser creadas más páginas',
	'nwb-must-be-logged-in' => 'Debes estar identificado para hacer esto',
	'nwb-skip-this-step' => 'Saltar este paso',
	'nwb-coming-soon' => 'Pronto estará disponible',
	'nwb-new-pages' => 'Páginas nuevas',
	'nwb-unable-to-edit-description' => 'La descripción no es editable con el New Wiki Builder',
	'nwb-step1-headline' => 'Describe tu wiki',
	'nwb-step1-example' => '<b>Ejemplo</b><br />Muppet Wiki es una enciclopedia sobre cualquier cosa relacionada con Jim Henson, Los Muppets/Los Teleñecos y Plaza Sésamo/Barrio Sésamo.
El formato wiki permite a cualquiera crear o editar cualquier artículo, así que todos nosotros podemos trabajar juntos para crear una base de datos comprensible para los Muppets/Teleñecos.',
	'nwb-step2-headline' => 'Subir un logo',
	'nwb-step2-example' => 'Este debería ser un buen logo para un wiki de patinaje.',
	'nwb-step3-headline' => 'Escoge un aspecto',
	'nwb-step4-headline' => 'Crear páginas',
	'nwb-step4-text' => '<p>¿Sobre qué quieres escribir?</p><p>Haz una lista de algunas páginas que quieras que tenga tu wiki.</p>',
	'nwb-step4-example' => '<b>Ejemplo</b><p>Para un wiki sobre una película de monstruos, tus primeras páginas deben ser: <ul class="bullets"><li>Drácula</li><li>Monstruo de Frankenstein</li><li>El hombrelobo</li><li>La momia</li></ul></p><p>Para un wiki de juegos de mesa: <ul class="bullets"><li>Monopoly</li><li>Risk</li><li>Scrabble</li><li>Trivial Pursuit</li></ul></p>',
	'nwb-step5-headline' => '¿Qué es lo próximo?',
	'nwb-preview' => 'Previsualizar',
	'nwb-logo-preview' => 'Previsualización del logo',
	'nwb-choose-logo' => 'Elige un logo',
	'nwb-save-description' => 'Guardar descripción',
	'nwb-save-theme' => 'Guardar apariencia',
	'nwb-create-pages' => 'Crear páginas',
	'nwb-save-logo' => 'Guardar logo',
	'nwb-go-to-your-wiki' => 'Ir a tu wiki',
	'nwb-back-to-step-1' => 'Volver a paso 1',
	'nwb-back-to-step-2' => 'Volver a paso 2',
	'nwb-back-to-step-3' => 'Volver a paso 3',
	'nwb-back-to-step-4' => 'Volver a paso 4',
	'nwb-or' => 'o',
	'nwb-new-pages-text' => '[[File:Placeholder|thumb|300px]] ¡Reemplaza este texto escribiendo aquí tu artículo!',
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'newwikibuilder' => 'Constructeur de nouveau wiki',
	'nwb-choose-a-file' => 'Veuillez choisir un fichier',
	'nwb-error-saving-description' => 'Erreur lors de la sauvegarder de la description',
	'nwb-error-saving-theme' => 'Erreur lors de la sauvegarde du thème',
	'nwb-error-saving-articles' => 'Erreur lors de la sauvegarde des pages',
	'nwb-error-saving-logo' => "Erreur lors de l'import du logo",
	'nwb-saving-articles' => 'Sauvegarder des pages...',
	'nwb-finalizing' => 'Finalisation...',
	'nwb-articles-saved' => 'Pages sauvegardées',
	'nwb-theme-saved' => 'Choix du thème sauvegardé',
	'nwb-saving-description' => 'Sauvegarde de la description...',
	'nwb-description-saved' => 'Description sauvegardée',
	'nwb-uploading-logo' => 'Import du logo...',
	'nwb-readonly-try-again' => 'Le wiki est actuellement en lecture seule. Veuillez réessayer dans un moment.',
	'nwb-logo-uploaded' => 'Logo importé',
	'nwb-login-successful' => 'Connexion réussie',
	'nwb-logout-successful' => 'Déconnexion réussie',
	'nwb-login-error' => 'Erreur lors de la connexion',
	'nwb-logging-in' => 'Connexion...',
	'nwb-api-error' => 'Il y a eu un problème :',
	'nwb-no-more-pages' => 'Aucune page supplémentaire ne peut être créée',
	'nwb-must-be-logged-in' => 'Vous devez vous connecter pour effectuer cette action',
	'nwb-skip-this-step' => 'Sauter cette étape',
	'nwb-coming-soon' => 'Disponible prochainement',
	'nwb-new-pages' => 'Nouvelles pages',
	'nwb-unable-to-edit-description' => "La description n'est pas modifiable avec le constructeur de nouveaux wikis",
	'nwb-step1-headline' => 'Décrivez votre wiki',
	'nwb-step1-example' => '<b>Exemple</b><br />Muppet Wiki est une encyclopédie à propos de tout sur Jim Henson, The Muppet Show et Sesame Street. Le format wiki permet à tout le monde de créer ou modifier tous les articles, comme cela nous pouvons travailler ensemble une base de données pour les fans des Muppets.',
	'nwb-step2-headline' => 'Importer un logo',
	'nwb-step2-example' => 'Ceci serait un bon exemple pour un wiki sur le skateboard.',
	'nwb-step3-headline' => 'Choisissez un thème',
	'nwb-step4-headline' => 'Créer des pages',
	'nwb-step4-text' => '<p>À propos de quoi voudriez-vous écrire ?</p><p>Faites une liste des quelques de vous voudriez avoir sur votre wiki.</p>',
	'nwb-step4-example' => '<b>Exemple</b><p>Pour un wiki sur les monstres de film, vos premières page serait : <ul class="bullets"><li>Dracula</li><li>Monstre de Frankenstein</li><li>Le loup garoup</li><li>La momie</li></ul></p><p>Pour un wiki sur les jeux de plateau : <ul class="bullets"><li>Monopoly</li><li>Risk</li><li>Scrabble</li><li>Trivial Pursuit</li></ul></p>',
	'nwb-step5-headline' => 'Ensuite ?',
	'nwb-preview' => 'Prévisualisation',
	'nwb-logo-preview' => 'Prévisualisation du logo',
	'nwb-choose-logo' => 'Choisissez le logo',
	'nwb-save-description' => 'Sauvegarder la description',
	'nwb-save-theme' => 'Sauvegarder le thème',
	'nwb-create-pages' => 'Créer les pages',
	'nwb-save-logo' => 'Sauvegarder le logo',
	'nwb-go-to-your-wiki' => 'Aller à votre wiki',
	'nwb-back-to-step-1' => "Revenir à l'étape 1",
	'nwb-back-to-step-2' => "Revenir à l'étape 2",
	'nwb-back-to-step-3' => "Revenir à l'étape 3",
	'nwb-back-to-step-4' => "Revenir à l'étape 4",
	'nwb-or' => 'ou',
	'nwb-new-pages-text' => "[[File:Placeholder|right|300px]]
Écrivez le premier paragraphe de votre article ici.

== Titre de section ==

Écrivez la première section de votre article ici. Rappelez-vous d'inclure des liens vers d'autres pages de wiki.

== Titre de section ==

Écrivez la deuxième section de votre article ici. Rappelez-vous d'ajouter des catégories, pour aider les personnes à trouver cet article.",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'newwikibuilder' => 'Construtor dun novo wiki',
	'nwb-choose-a-file' => 'Por favor, seleccione un ficheiro',
	'nwb-error-saving-description' => 'Erro ao gardar a descrición',
	'nwb-error-saving-theme' => 'Erro ao gardar o tema',
	'nwb-error-saving-articles' => 'Erro ao gardar as páxinas',
	'nwb-error-saving-logo' => 'Erro ao cargar o logo',
	'nwb-saving-articles' => 'Gardando as páxinas...',
	'nwb-finalizing' => 'Finalizando...',
	'nwb-articles-saved' => 'Gardáronse as páxinas',
	'nwb-theme-saved' => 'Gardouse a escolla do tema',
	'nwb-saving-description' => 'Gardando a descrición...',
	'nwb-description-saved' => 'Gardouse a descrición',
	'nwb-uploading-logo' => 'Cargando o logo...',
	'nwb-readonly-try-again' => 'O wiki está arestora en modo de lectura. Por favor, inténteo de novo nuns intres',
	'nwb-logo-uploaded' => 'Cargouse o logo',
	'nwb-login-successful' => 'Acceso exitoso',
	'nwb-logout-successful' => 'Desconexión exitosa',
	'nwb-login-error' => 'Erro ao iniciar a sesión',
	'nwb-logging-in' => 'Accedendo ao sistema...',
	'nwb-api-error' => 'Houbo un problema:',
	'nwb-no-more-pages' => 'Non se poden crear máis páxinas',
	'nwb-must-be-logged-in' => 'Debe acceder ao sistema para levar a cabo esta acción',
	'nwb-skip-this-step' => 'Saltar este paso',
	'nwb-coming-soon' => 'Proximamente',
	'nwb-new-pages' => 'Páxinas novas',
	'nwb-unable-to-edit-description' => 'A descrición non se pode editar co construtor de wikis novos',
	'nwb-step1-headline' => 'Describa o seu wiki',
	'nwb-step1-example' => '<b>Exemplo</b><br />O wiki Xabarín é unha enciclopedia sobre todo o relacionado con Miguelanxo Prado, o Xabarín Club e as súas series. O formato wiki permite a todo o mundo crear ou editar calquera artigo, e así podermos traballar todos xuntos para conseguir unha ampla base de datos para os seguidores do porco bravo.',
	'nwb-step2-headline' => 'Cargar un logo',
	'nwb-step2-example' => 'Este sería un bo logo para un wiki sobre monopatíns.',
	'nwb-step3-headline' => 'Escolla un tema',
	'nwb-step4-headline' => 'Crear páxinas',
	'nwb-step4-text' => '<p>Sobre que quere escribir?</p><p>Faga unha lista con algunhas das páxinas que queira ter no seu wiki.</p>',
	'nwb-step4-example' => '<b>Exemplo</b><p>Para un wiki sobre películas de monstros, as súas primeiras páxinas poderían ser: <ul class="bullets"><li>Drácula</li><li>O monstro de Frankenstein</li><li>O lobishome</li><li>A momia</li></ul></p><p>Para un wiki sobre xogos de mesa: <ul class="bullets"><li>Monopoly</li><li>Risk</li><li>Scrabble</li><li>Trivial Pursuit</li></ul></p>',
	'nwb-step5-headline' => 'E agora?',
	'nwb-preview' => 'Vista previa',
	'nwb-logo-preview' => 'Vista previa do logo',
	'nwb-choose-logo' => 'Escolla o logo',
	'nwb-save-description' => 'Gardar a descrición',
	'nwb-save-theme' => 'Gardar o tema',
	'nwb-create-pages' => 'Crear as páxinas',
	'nwb-save-logo' => 'Gardar o logo',
	'nwb-go-to-your-wiki' => 'Ir ao seu wiki',
	'nwb-back-to-step-1' => 'Voltar ao paso 1',
	'nwb-back-to-step-2' => 'Voltar ao paso 2',
	'nwb-back-to-step-3' => 'Voltar ao paso 3',
	'nwb-back-to-step-4' => 'Voltar ao paso 4',
	'nwb-or' => 'ou',
	'nwb-new-pages-text' => '[[File:Placeholder|right|300px]]
Escriba aquí o primeiro parágrafo do seu artigo.

==Cabeceira de sección==

Escriba aquí a primeira sección do seu artigo. Lembre incluír ligazóns cara a outras páxinas do wiki.

==Cabeceira de sección==

Escriba aquí a segunda sección do seu artigo. Non esqueza engadir unha categoría, para axudar así á xente a atopar o artigo.',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'nwb-finalizing' => 'Véglegesítés …',
	'nwb-articles-saved' => 'Lapok mentve',
	'nwb-saving-description' => 'Megjegyzés mentése …',
	'nwb-description-saved' => 'Megjegyzés elmentve',
	'nwb-logo-uploaded' => 'Logó feltöltve',
	'nwb-login-successful' => 'Sikeres bejelentkezés',
	'nwb-logout-successful' => 'Sikeres kijelentkezés',
	'nwb-login-error' => 'Hiba a bejelentkezés közben',
	'nwb-logging-in' => 'Bejelentkezés …',
	'nwb-skip-this-step' => 'Lépés kihagyása',
	'nwb-coming-soon' => 'Hamarosan',
	'nwb-new-pages' => 'Új lapok',
	'nwb-step1-headline' => 'Wiki leírása',
	'nwb-step2-headline' => 'Logó feltöltése',
	'nwb-step4-headline' => 'Lapok létrehozása',
	'nwb-step5-headline' => 'Hogyan tovább?',
	'nwb-preview' => 'Előnézet',
	'nwb-logo-preview' => 'Logó előnézete',
	'nwb-choose-logo' => 'Logó választása',
	'nwb-save-description' => 'Megjegyzés mentése',
	'nwb-create-pages' => 'Lapok létrehozása',
	'nwb-save-logo' => 'Logó mentése',
	'nwb-go-to-your-wiki' => 'Ugrás a wikidre',
	'nwb-back-to-step-1' => 'Vissza az első lépéshez',
	'nwb-back-to-step-2' => 'Vissza a második lépéshez',
	'nwb-back-to-step-3' => 'Vissza a harmadik lépéshez',
	'nwb-back-to-step-4' => 'Vissza a negyedik lépéshez',
	'nwb-or' => 'vagy',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'newwikibuilder' => 'Constructor de nove wikis',
	'nwb-choose-a-file' => 'Selige un file',
	'nwb-error-saving-description' => 'Error durante le salveguarda del description',
	'nwb-error-saving-theme' => 'Error durante le salveguarda del apparentia',
	'nwb-error-saving-articles' => 'Error durante le salveguarda del paginas',
	'nwb-error-saving-logo' => 'Error durante le incargamento del logotypo',
	'nwb-saving-articles' => 'Salveguarda paginas…',
	'nwb-finalizing' => 'Finalisation…',
	'nwb-articles-saved' => 'Paginas salveguardate',
	'nwb-theme-saved' => 'Selection de apparentia salveguardate',
	'nwb-saving-description' => 'Salveguarda description…',
	'nwb-description-saved' => 'Description salveguardate',
	'nwb-uploading-logo' => 'Incarga logotypo…',
	'nwb-readonly-try-again' => 'Le wiki es actualmente in modo de lectura sol. Per favor reproba lo in alcun momentos.',
	'nwb-logo-uploaded' => 'Logotypo incargate',
	'nwb-login-successful' => 'Session aperite con successo',
	'nwb-logout-successful' => 'Session claudite con successo',
	'nwb-login-error' => 'Error durante le apertura del session',
	'nwb-logging-in' => 'Aperi session…',
	'nwb-api-error' => 'Il habeva un problema:',
	'nwb-no-more-pages' => 'Non es possibile crear plus paginas',
	'nwb-must-be-logged-in' => 'Tu debe aperir un session pro facer isto',
	'nwb-skip-this-step' => 'Saltar iste passo',
	'nwb-coming-soon' => 'Disponibile tosto',
	'nwb-new-pages' => 'Nove paginas',
	'nwb-unable-to-edit-description' => 'Le description non es modificabile con le Constructor de nove wikis',
	'nwb-step1-headline' => 'Describe tu wiki',
	'nwb-step1-example' => '<b>Exemplo</b><br />Muppet Wiki es un encyclopedia super tote le cosas connexe a Jim Henson, The Muppet Show e Strata Sesamo. Le formato wiki permitte a omnes de crear o modificar omne articulo, de sorta que nos pote laborar totes insimul pro crear un base de datos comprehensive pro le fans del Muppets.',
	'nwb-step2-headline' => 'Incargar un logotypo',
	'nwb-step2-example' => 'Isto esserea un bon logotypo pro un wiki super skateboard.',
	'nwb-step3-headline' => 'Selige un apparentia',
	'nwb-step4-headline' => 'Crear paginas',
	'nwb-step4-text' => '<p>Super que vole tu scriber?</p><p>Face un lista de alcun paginas que tu vole haber in tu wiki.</p>',
	'nwb-step4-example' => '<b>Exemplo</b><p>Pro un wiki super filmes de monstros, le prime paginas pote esser: <ul class="bullets"><li>Dracula</li><li>Le monstro de Frankenstein</li><li>Le homine lupo</li><li>Le mumia</li></ul></p><p>Pro un wiki super jocos de tabuliero: <ul class="bullets"><li>Monopoly</li><li>Risk</li><li>Scrabble</li><li>Trivial Pursuit</li></ul></p>',
	'nwb-step5-headline' => 'Que facer ora?',
	'nwb-preview' => 'Previsualisation',
	'nwb-logo-preview' => 'Previsualisation del logotypo',
	'nwb-choose-logo' => 'Selige logotypo',
	'nwb-save-description' => 'Salveguardar description',
	'nwb-save-theme' => 'Salveguardar apparentia',
	'nwb-create-pages' => 'Crear paginas',
	'nwb-save-logo' => 'Salveguardar logotypo',
	'nwb-go-to-your-wiki' => 'Ir a tu wiki',
	'nwb-back-to-step-1' => 'Retornar al passo 1',
	'nwb-back-to-step-2' => 'Retornar al passo 2',
	'nwb-back-to-step-3' => 'Retornar al passo 3',
	'nwb-back-to-step-4' => 'Retornar al passo 4',
	'nwb-or' => 'o',
	'nwb-new-pages-text' => '[[File:Placeholder|right|300px|Spatio reservate]]
Scribe hic le prime paragrapho de tu articulo.

==Titulo de section==

Scribe hic le prime section de tu articulo. Rememora de includer ligamines a altere paginas in le wiki.

==Titulo de section==

Scribe hic le secunde section de tu articulo. Non oblida de adder un categoria, pro adjutar le gente a trovar le articulo.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'newwikibuilder' => 'Изработувач на нови викија',
	'nwb-choose-a-file' => 'Одберете податотека',
	'nwb-error-saving-description' => 'Грешка при зачувувањето на описот',
	'nwb-error-saving-theme' => 'Грешка при зачувувањето на мотивот',
	'nwb-error-saving-articles' => 'Грешка при зачувувањето на страниците',
	'nwb-error-saving-logo' => 'Грешка при подигањето на логото',
	'nwb-saving-articles' => 'Ги зачувувам страниците...',
	'nwb-finalizing' => 'Финализирам...',
	'nwb-articles-saved' => 'Страниците се зачувани',
	'nwb-theme-saved' => 'Изборот на мотив е зачуван',
	'nwb-saving-description' => 'Го зачувувам описот...',
	'nwb-description-saved' => 'Описот е зачуван',
	'nwb-uploading-logo' => 'Го подигам логото...',
	'nwb-readonly-try-again' => 'Во моментов викито е во режим недостапен за запишување. Обидете се повторно за некоја минута',
	'nwb-logo-uploaded' => 'Логото е подигнато',
	'nwb-login-successful' => 'Успешно најавување',
	'nwb-logout-successful' => 'Успешно одјавување',
	'nwb-login-error' => 'Грешка при најавувањето',
	'nwb-logging-in' => 'Ве најавувам...',
	'nwb-api-error' => 'Се појави проблем:',
	'nwb-no-more-pages' => 'Не може да се создадат повеќе страници',
	'nwb-must-be-logged-in' => 'Мора да сте најавени за ова дејство',
	'nwb-skip-this-step' => 'Прескокни го овој чекор',
	'nwb-coming-soon' => 'Наскоро',
	'nwb-new-pages' => 'Нови страници',
	'nwb-unable-to-edit-description' => 'Описот не е уредлив со Изработувачот на нови викија',
	'nwb-step1-headline' => 'Опишете го вашето вики',
	'nwb-step1-text' => '<p>Да започнеме со поставување на викито Можете да прескокнете било кој чекор и да се навратите на него подоцна.</p><p>Најпрво: напишете порака за насловната страница на вашето вики во која ќе опишете за какво вики се работи.</p>',
	'nwb-step1-example' => '<b>Пример</b><br />Мапет Вики (Muppet Wiki) е енциклопедија на сите нешта поврзани со Џим Хенсон, Мапет Шоу и Улицата Сесами. Вики-форматот овозможува секој да може да создаде и напише било каква статија, така што сите работиме заеднички и создаваме опсежна база на податоци која ќе им користи на обожавателите на Мапетите.',
	'nwb-step2-headline' => 'Подигни лого',
	'nwb-step2-text' => '<p>Следно: Одберете лого за викито.</p><p>Подигнете слика од компјутерот која ќе го претставува вашето вики.</p><p>Ако во моментов немате слика која би ја употребиле за лого, можете да го прескокнете овој чекор и да се навратите подоцна.</p>',
	'nwb-step2-example' => 'Ова би било добро лого за вики за скејтбординг.',
	'nwb-step3-headline' => 'Одберете мотив',
	'nwb-step3-text' => '<p>Сега одберете бои за викито.</p><p>Ова може да се менува подоцна, ако се премислите.</p>',
	'nwb-step4-headline' => 'Создај страници',
	'nwb-step4-text' => '<p>За што сакате да пишувате?</p><p>Направете листа од некои страници кои би сакале да ги имате на викито.</p>',
	'nwb-step4-example' => '<b>Пример</b><p>Ако сакате да направите вики за филмови со чудовишта, првите страници на викито би биле: <ul class="bullets"><li>Дракула</li><li>Франкенштајн</li><li>Врколак</li><li>Мумија</li></ul></p><p>Ако сакате вики за таблени игри, тогаш први би биле: <ul class="bullets"><li>Монопол</li><li>Ризик</li><li>Не лути се човече</li><li>Скребл</li></ul></p>',
	'nwb-step5-headline' => 'Што понатаму?',
	'nwb-step5-text' => '<p>Тоа беа сите потребни чекори! Викито е подготвено за работа.</p><p>Сега е време да почнете со пишување и да додадете некои слики, за да има што да читаат луѓето кога ќе го пронајдат вашето вики..</p><p>Листата на страниците што ги направивте во последниот чекор е додадена во кутијата „Нови страници“ на главната страница. Можете да започнете со работа со кликнување на тие страници. Забавувајте се!</p>',
	'nwb-preview' => 'Преглед',
	'nwb-logo-preview' => 'Преглед на логото',
	'nwb-choose-logo' => 'Одберете лого',
	'nwb-save-description' => 'Зачувај опис',
	'nwb-save-theme' => 'Зачувај мотив',
	'nwb-create-pages' => 'Создај страници',
	'nwb-save-logo' => 'Зачувај лого',
	'nwb-go-to-your-wiki' => 'Одете на вашето вики',
	'nwb-back-to-step-1' => 'Назад на чекор 1',
	'nwb-back-to-step-2' => 'Назад на чекор 2',
	'nwb-back-to-step-3' => 'Назад на чекор 3',
	'nwb-back-to-step-4' => 'Назад на чекор 4',
	'nwb-or' => 'или',
	'nwb-new-pages-text' => '[[File:Placeholder|right|300px]]
Тука напишете го првиот пасус од статијата.

==Поднаслов==

Тука напишете го првиот дел од статијата. Не заборавете да вклучите врски до други страници на викито.

==Поднаслов==

Тука напишете го првиот дел од статијата. Не заборавајте да додадете категорија, за да можат корисниците да ја пронајдат статијата.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'newwikibuilder' => 'Nieuwe wiki bouwen',
	'nwb-choose-a-file' => 'Kies een bestand',
	'nwb-error-saving-description' => 'Fout bij het opslaan van de beschrijving',
	'nwb-error-saving-theme' => 'Fout bij het opslaan van het uiterlijk',
	'nwb-error-saving-articles' => "Fout bij het opslaan van pagina's",
	'nwb-error-saving-logo' => 'Fout bij het uploaden van het logo',
	'nwb-saving-articles' => "Bezig met het opslaan van pagina's...",
	'nwb-finalizing' => 'Bezig met afronden...',
	'nwb-articles-saved' => "De pagina's zijn opgeslagen",
	'nwb-theme-saved' => 'Het geselecteerde uiterlijk is opgeslagen',
	'nwb-saving-description' => 'Bezig met het opslaan van de beschrijving...',
	'nwb-description-saved' => 'Beschrijving opgeslagen',
	'nwb-uploading-logo' => 'Bezig met het uploaden van het logo...',
	'nwb-readonly-try-again' => 'Deze wiki is op het moment alleen-lezen.
Probeer het over een aantal minuten opnieuw.',
	'nwb-logo-uploaded' => 'Het logo is geüpload',
	'nwb-login-successful' => 'Aangemeld',
	'nwb-logout-successful' => 'Afgemeld',
	'nwb-login-error' => 'Fout bij het aanmelden',
	'nwb-logging-in' => 'Bezig met aanmelden...',
	'nwb-api-error' => 'Er is een probleem opgetreden:',
	'nwb-no-more-pages' => "Er kunnen geen pagina's meer gemaakt worden",
	'nwb-must-be-logged-in' => 'U moet aangemeld zijn voor deze handeling',
	'nwb-skip-this-step' => 'Deze stap overslaan',
	'nwb-coming-soon' => 'Binnenkort',
	'nwb-new-pages' => "Nieuwe pagina's",
	'nwb-unable-to-edit-description' => 'De beschrijving is niet te bewerken met de Nieuwe Wikibouwer',
	'nwb-step1-headline' => 'Beschrijf uw wiki',
	'nwb-step1-example' => "<b>Voorbeeld</b><br />Muppetwiki is een encyclopedie over alles dat met Jim Henson, De Muppetshow en Sesamstraat te maken heeft. Door een wiki te gebruiken kan iedereen alle pagina's bewerken en pagina's aanmaken. Daardoor kunnen we allemaal samenwerken en een complete beschijving maken voor alle fans van de Muppets.",
	'nwb-step2-headline' => 'Een logo uploaden',
	'nwb-step2-example' => 'Dit zou een goed logo zijn voor een wiki over skateboarden.',
	'nwb-step3-headline' => 'Kies een vormgeving',
	'nwb-step4-headline' => "Pagina's aanmaken",
	'nwb-step4-text' => "<p>Waar wilt u over schrijven?</p>
<p>Maak een lijst van een aantal pagina's die u in uw wiki terug zou willen zien.</p>",
	'nwb-step4-example' => '<b>Voorbeeld</b><p>For a Monsterfilmwiki zouden uw eerste pagina\'s kunnen zijn:
<ul class="bullets">
<li>Dracula</li>
<li>Frankenstein\'s Monster</li>
<li>The Wolfman</li>
<li>The Mummy</li>
</ul></p>
<p>Voor een wiki over bordspellen:
<ul class="bullets">
<li>Monopoly</li>
<li>Risk</li>
<li>Scrabble</li>
<li>Trivial Pursuit</li></ul>
</p>',
	'nwb-step5-headline' => 'Wat nu?',
	'nwb-preview' => 'Voorvertoning',
	'nwb-logo-preview' => 'Voorvertoning logo',
	'nwb-choose-logo' => 'Kies een logo',
	'nwb-save-description' => 'Beschrijving opslaan',
	'nwb-save-theme' => 'Vormgeving opslaan',
	'nwb-create-pages' => "Pagina's aanmaken",
	'nwb-save-logo' => 'Logo opslaan',
	'nwb-go-to-your-wiki' => 'Naar uw wiki gaan',
	'nwb-back-to-step-1' => 'Terug naar stap 1',
	'nwb-back-to-step-2' => 'Terug naar stap 2',
	'nwb-back-to-step-3' => 'Terug naar stap 3',
	'nwb-back-to-step-4' => 'Terug naar stap 4',
	'nwb-or' => 'of',
	'nwb-new-pages-text' => "[[File:Placeholder|right|300px]]
Schrijf hier de eerste paragraaf van uw pagina.

==Koptekst==
Schrijf hier de eerste paragraaf van uw pagina. Denk eraan verwijzingen naar andere wikipagina's op te nemen.

==Koptekst==
Schrijf hier de tweede paragraaf van uw pagina. Denk eraan een categorie toe te voegen, zodat andere gebruikers de pagina kunnen vinden.",
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'newwikibuilder' => 'Neuv Costrutor ëd Wiki',
	'nwb-choose-a-file' => "Për piasì, ch'a serna n'archivi",
	'nwb-error-saving-description' => 'Eror an Salvand la Descrission',
	'nwb-error-saving-theme' => 'Eror an Salvand ël Tema',
	'nwb-error-saving-articles' => 'Eror an Salvand le Pàgine',
	'nwb-error-saving-logo' => 'Eror an Cariand la marca',
	'nwb-saving-articles' => 'Salvé le Pagine...',
	'nwb-finalizing' => 'Finalisé...',
	'nwb-articles-saved' => 'Pàgine Salvà',
	'nwb-theme-saved' => 'Sèrnia ëd Tema Salvà',
	'nwb-saving-description' => 'Salvatagi dla Descrission...',
	'nwb-description-saved' => 'Descrission Salvà...',
	'nwb-uploading-logo' => 'Amportassion dla marca...',
	'nwb-readonly-try-again' => "La Wiki a l'é al moment an modalità mach ëd letura. Për piasì, ch'a preuva torna da sì 'n pòch",
	'nwb-logo-uploaded' => 'Marca Carià',
	'nwb-login-successful' => 'Intrà ant ël sistema',
	'nwb-logout-successful' => 'Surtì dal sistema',
	'nwb-login-error' => 'Eror an intrand ant ël sistema',
	'nwb-logging-in' => 'Intrada ant ël sistema...',
	'nwb-api-error' => 'A-i é staje un problema:',
	'nwb-no-more-pages' => 'Pa pi gnun-e pàgine a peulo esse creà',
	'nwb-must-be-logged-in' => 'A deuv esse intrà ant ël sistema për costa assion-sì',
	'nwb-skip-this-step' => 'Sàuta sto pass-sì',
	'nwb-coming-soon' => 'A sarà tòst disponìbil',
	'nwb-new-pages' => 'Pàgine neuve',
	'nwb-unable-to-edit-description' => 'La descrission as peul pa modifichesse con Neuv Costrutor ëd Wiki',
	'nwb-step1-headline' => 'Descriv toa wiki',
	'nwb-step1-text' => "<p>Ancaminoma a amposté <b>translatewiki.net</b>. A peul sauté mincadun dij passagi e torneje pi tard.</p><p>Prim: Ch'a scriva un mëssagi për la prima pàgina ëd soa wiki ch'a descriva lòn ch'a l'é translatewiki.net.</p>",
	'nwb-step1-example' => "<b>Esempi</b><br />Muppet Wiki a l'é n'enciclopedìa dzora a tut lòn ch'a rësguarda Jim Henson, The Muppet Show e Sesame Street. Ël formà ëd la wiki a përmët a mincadun ëd creé o modifiché minca artìcol, parèj i podoma travajé tùit ansema për creé na base ëd dàit completa për j'apassionà dij Muppets.",
	'nwb-step2-headline' => 'Carié na marca',
	'nwb-step2-text' => "<p>Dapress: Ch'a serna na marca për <b>translatewiki.net</b>.</p><p>Ch'a caria na figura da sò ordinator për arpresenté soa wiki.</p>
<p>A peul sauté sto pass-sì s'a l'has pa adess ij drit ëd na figura ch'a veul dovré.</p>",
	'nwb-step2-example' => 'Cost-sì a podrìa esse na bon-a marca për na wiki an sle tàule a roe.',
	'nwb-step3-headline' => 'Sern un tema',
	'nwb-step3-text' => "<p>Adess ch'a serna në schema ëd color për <b>translatewiki.net</b>.</p><p>A peul cangé sòn pi tard s'a cangia idèja.</p>",
	'nwb-step4-headline' => 'Creé dle pàgine',
	'nwb-step4-text' => "<p>Ëd lòn ch'a veul ëscrive?</p><p>Ch'a pronta na lista ëd chèich pàgine ch'a veul avèj dzora a soa wiki.</p>",
	'nwb-step4-example' => '<b>Esempi</b><p>Për na Wiki ëd Film ëd Mostro, soa prima pàgina a dovrìa esse: <ul class="bullets"><li>Dràcula</li><li>Ël mostro \'d Frankenstein</li><li>L\'Òm Luv</li><li>La Mumia</li></ul></p><p>Për na Wiki ëd Gieugh da Tàula: <ul class="bullets"><li>Monòpoli</li><li>Arzigh</li><li>Scarabé</li><li>Trivial Pursuit</li></ul></p>',
	'nwb-step5-headline' => "Lòn ch'a-i Ven?",
	'nwb-step5-text' => "<p>Costi-sì a son tùit ij pass! <b>translatewiki.net</b> a l'é pronta a andé.</p><p>Adess a l'é temp ëd parte a scrive e gionté chèich figure, për dé ai visitador cheicòs da lese quand a treuvo soa wiki.</p><p>La lista ëd pàgine ch'a l'ha fàit ant l'ùltim pass a l'é stàita giontà ant ël quàder \"Pàgine Neuve\" ant la prima pàgina. A peul ancaminé an sgnacand su cole pàgine. Avèj gòj!</p>",
	'nwb-preview' => 'Preuva',
	'nwb-logo-preview' => 'Preuva dla marca',
	'nwb-choose-logo' => 'Serne la marca',
	'nwb-save-description' => 'Salva Descrission',
	'nwb-save-theme' => 'Salva Tema',
	'nwb-create-pages' => 'Creé le Pàgine',
	'nwb-save-logo' => 'Salvé la marca',
	'nwb-go-to-your-wiki' => 'Va a toa wiki',
	'nwb-back-to-step-1' => 'André al pass 1',
	'nwb-back-to-step-2' => 'André al pass 2',
	'nwb-back-to-step-3' => 'André al pass 3',
	'nwb-back-to-step-4' => 'André al pass 4',
	'nwb-or' => 'o',
	'nwb-new-pages-text' => "[[File:Placeholder|right|300px]]
Scriv ël prim paràgraf ëd tò artìcol ambelessì.

==Antestassion dla Session==

Ch'a scriva la prima session ëd sò artìcol ambelessì. Ch'as visa d'anserì j'anliure a j'àutre pàgine an sla wiki.

==Antestassion dla Session==

Ch'a scriva la sconda session ëd sò artìcol ambelessì. Ch'as dësmentia pa ëd gionté na categorìa, për giuté ij visitador a trové l'artìcol.",
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'newwikibuilder' => 'Criador de novas Wikis',
	'nwb-choose-a-file' => 'Por favor, escolha um arquivo',
	'nwb-error-saving-description' => 'Erro ao salvar a descrição',
	'nwb-error-saving-theme' => 'Erro ao salvar o tema',
	'nwb-error-saving-articles' => 'Erro ao salvar as páginas',
	'nwb-error-saving-logo' => 'Erro ao carregar o logo',
	'nwb-saving-articles' => 'Salvando páginas...',
	'nwb-finalizing' => 'Finalizando...',
	'nwb-articles-saved' => 'Páginas salvadas',
	'nwb-theme-saved' => 'Escolha do tema salvado',
	'nwb-saving-description' => 'Salvando descrição...',
	'nwb-description-saved' => 'Descrição salvada',
	'nwb-uploading-logo' => 'Carregando o logo...',
	'nwb-readonly-try-again' => 'Esta wiki está atualmente disponível apenas para leitura. Por favor, tente novamente em breve.',
	'nwb-logo-uploaded' => 'Logo carregado',
	'nwb-login-successful' => 'Login bem sucedido',
	'nwb-logout-successful' => 'Logout bem sucedido',
	'nwb-login-error' => 'Erro no login',
	'nwb-logging-in' => 'Fazendo o login...',
	'nwb-api-error' => 'Houve um problema:',
	'nwb-no-more-pages' => 'Não podem ser criadas mais páginas',
	'nwb-must-be-logged-in' => 'Você precisa estar logado para fazer isto',
	'nwb-skip-this-step' => 'Pule este passo',
	'nwb-coming-soon' => 'Disponível em breve',
	'nwb-new-pages' => 'Páginas novas',
	'nwb-step1-headline' => 'Descreva sua wiki',
	'nwb-step1-example' => '<b>Exemplo</b><br />Muppet Wiki é uma enciclopédia sobre qualquer coisa relacionada a Jim Henson, Os Muppets e Vila Sésamo. O formato Wiki permite que qualquer um crie e edite um artigo, então nós todos podemos trabalhar juntos para criar uma base de dados abrangente para os fãs dos Muppets.',
	'nwb-step2-headline' => 'Carregue um logotipo',
	'nwb-step2-example' => 'Este seria um bom logo para uma wiki sobre skateboarding.',
	'nwb-step3-headline' => 'Escolha um tema',
	'nwb-step4-headline' => 'Criar páginas',
	'nwb-step4-text' => '<p>Sobre o que você quer escrever?</p><p>Faça uma lista de algumas páginas que você queria ter na sua wiki.</p>',
	'nwb-step4-example' => '<b>Exemplo</b><p>Para uma wiki de filmes de monstros, suas primeiras páginas poderia ser: <ul class="bullets"><li>Drácula</li><li>Frankenstein</li><li>Lobisomen</li><li>Múmia</li></ul></p><p>Para uma wiki de jogos de mesa: <ul class="bullets"><li>Monopoly</li><li>Risk</li><li>Scrabble</li><li>Trivial Pursuit</li></ul></p>',
	'nwb-step5-headline' => 'Que é o próximo?',
	'nwb-preview' => 'Previsualizar',
	'nwb-logo-preview' => 'Previsualizar o logo',
	'nwb-choose-logo' => 'Escolher um logo',
	'nwb-save-description' => 'Salvar descrição',
	'nwb-save-theme' => 'Salvar tema',
	'nwb-create-pages' => 'Criar páginas',
	'nwb-save-logo' => 'Salvar logo',
	'nwb-go-to-your-wiki' => 'Ir para sua wiki',
	'nwb-back-to-step-1' => 'Voltar para o passo 1',
	'nwb-back-to-step-2' => 'Voltar para o passo 2',
	'nwb-back-to-step-3' => 'Voltar para o passo 3',
	'nwb-back-to-step-4' => 'Voltar para o passo 4',
	'nwb-or' => 'ou',
	'nwb-new-pages-text' => '[[File:Placeholder|right|300px]]
Escreva o primeiro parágrafo do seu artigo aqui.

==Cabeçalho de seção==

Escreva a primeira seção do seu artigo aqui. Lembre-se de incluir links para outras páginas da wiki.

==Cabeçalho de seção==

Escreva a segunda seção do seu artigo aqui. Não se esqueça de adicionar uma categoria pra ajudar outras pessoas a encontrar esse artigo.',
);

/** Russian (Русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'nwb-error-saving-description' => 'Ошибка при сохранении описания',
	'nwb-error-saving-theme' => 'Ошибка при сохранении темы',
	'nwb-error-saving-articles' => 'Ошибка при сохранении страниц',
	'nwb-error-saving-logo' => 'Ошибка при загрузке логотипа',
	'nwb-saving-articles' => 'Сохранение страниц…',
	'nwb-finalizing' => 'Завершение…',
	'nwb-saving-description' => 'Сохранение описания…',
	'nwb-description-saved' => 'Описание сохранено',
	'nwb-uploading-logo' => 'Загрузка логотипа…',
	'nwb-logo-uploaded' => 'Логотип загружен',
	'nwb-skip-this-step' => 'Пропустить этот шаг',
	'nwb-new-pages' => 'Новые страницы',
	'nwb-step1-headline' => 'Опишите вашу вики',
	'nwb-step2-headline' => 'Загрузите логотип',
	'nwb-step3-headline' => 'Выберите тему',
	'nwb-step4-headline' => 'Создайте страницы',
	'nwb-step4-text' => '<p>О чём вы хотите написать?</p><p>Создайте список из нескольких страниц, которые бы вы хотели иметь в вашей вики.</p>',
	'nwb-step5-headline' => 'Что дальше?',
	'nwb-preview' => 'Предварительный просмотр',
	'nwb-logo-preview' => 'Предпросмотр логотипа',
	'nwb-choose-logo' => 'Выбрать логотип',
	'nwb-save-description' => 'Сохранить описание',
	'nwb-save-theme' => 'Сохранить тему',
	'nwb-save-logo' => 'Сохранить логотип',
	'nwb-go-to-your-wiki' => 'Перейти к вашей вики',
	'nwb-back-to-step-1' => 'Возврат к шагу 1',
	'nwb-back-to-step-2' => 'Возврат к шагу 2',
	'nwb-back-to-step-3' => 'Возврат к шагу 3',
	'nwb-back-to-step-4' => 'Возврат к шагу 4',
	'nwb-or' => 'или',
	'nwb-new-pages-text' => '[[File:Placeholder|right|300px]]
Напишите здесь первый параграф статьи.

== Заголовок секции ==
Напишите здесь первую секцию статьи. Не забудьте включить ссылки на другие страницы в вики.

== Заголовок секции ==
Напишите здесь вторую секцию статьи. Не забудьте добавить категорию, чтобы помочь людям найти статью.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'nwb-new-pages' => 'కొత్త పేజీలు',
	'nwb-or' => 'లేదా',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'nwb-back-to-step-1' => 'Повернутись до кроку 1',
	'nwb-or' => 'або',
);

// Note that this variable is referenced in the NewWikiBuilder.html.php file
global $NWBmessages;
$NWBmessages = $messages; 
