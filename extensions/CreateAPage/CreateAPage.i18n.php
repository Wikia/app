<?php
/**
 * Internationalization file for CreateAPage extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 * @author Łukasz Garczewski
 * @author Przemek Piotrowski
 */
$messages['en'] = array(
	'createpage-edit-normal' => 'Advanced Edit',
	'createpage-upload' => 'Upload image',
	'createpage-hide' => 'Hide',
	'createpage-show' => 'Show',
	'createpage' => 'Create a new article',
	'createpage-title' => 'Create a new article',
	'createpage-title-additional' => "You've followed a link to a page that doesn't exist yet. To create the page, start typing in the box below",
	'createpage-title-caption' => 'Article Title',
	'createpage-choose-createplate' => 'Choose a page type',
	'createpage-button-createplate-submit' => 'Load this template',
	'createpage-give-title' => 'Please specify a title',
	'createpage-title-invalid' => 'Please specify a valid title',
	'createpage-article-exists' => 'This article already exists. Edit',
	'createpage-article-exists2' => ' or specify another title.',
	'createpage-advanced-warning' => 'Switching editing modes may break page formatting, do you want to continue?',
	'createpage-login-warning' => 'By logging in now, you may lose all your unsaved text. Do you want to continue?',
	'createpage-infobox-legend' => 'Infobox',
	'createpage-yes' => 'Yes',
	'createpage-no' => 'No',
	'createpage-categories' => 'Categories',
	'createpage-addcategory' => 'Add category',
	'createpage-top-of-page' => 'Top of page',
	'createpage-uploaded-from' => 'Uploaded from Special:CreatePage',
	'createplate-list' => 'Blank|Blank',
	'createplate-Blank' => "<!---blanktemplate--->\n", # do not translate or duplicate this message into other languages!
	'createpage-title-check-header' => 'Title check forced',
	'createpage-title-check-text' => 'You cannot perform an action until title check has ended. Please click again on the action button to proceed.',
	'createpage-img-uploaded' => 'Image uploaded successfully',
	'createpage-preview-end' => 'End of preview. You can resume your editing below:',
	'createpage-insert-image' => 'Insert Image',
	'createpage-upload-aborted' => 'Image insert was cancelled',
	'createpage-initial-run' => 'Proceed to edit',
	'createpage-login-required' => 'You need to ',
	'createpage-login-href' => ' log in ',
	'createpage-login-required2' => 'to upload images',
	'createpage-please-wait' => 'Please wait...',
	'createpage-upload-directory-read-only' => 'The upload directory is not writable by the webserver',
	'headline-tip-3' => 'Level 3 headline',
	'createpage-about-info' => 'This is the simplified editor. To find out more go to [[s:Help:CreatePage|ShoutWiki Hub]].',
	'createpage-advanced-text' => 'You can also use the $1.',
	'createpage-advanced-edit' => 'advanced editor',
	'createpage-optionals-text' => 'Add optional sections:',
	'createpage-save' => 'Save',
	'createpage-must-specify-title' => 'Please specify a title first!',
	'createpage-unsaved-changes' => 'Unsaved changes',
	'createpage-unsaved-changes-details' => 'You have unsaved changes. Clicking OK will result in abandoning them.',
	'tog-createpage-redlinks' => 'Use [http://www.shoutwiki.com/wiki/Help:CreatePage CreatePage] when following broken links',
	'createpage-template-infobox-format' => '/\{\{[^\{\}]*Infobox.*\}\}/is', # regex used to find out whether our template is an infobox or not
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'createpage' => "Skep 'n nuwe artikel",
	'createpage-article-exists' => 'Hierdie bladsy bestaan reeds. Wysig',
	'createpage-article-exists2' => " of verskaf 'n ander bladsynaam.",
	'createpage-button-createplate-submit' => 'Laai hierdie sjabloon',
	'createpage-give-title' => "Verskaf 'n naam",
	'createpage-title' => "Skep 'n nuwe artikel",
	'createpage-title-caption' => 'Artikel se titel',
	'createpage-title-invalid' => "Verskaf 'n geldige bladsynaam",
	'createpage-yes' => 'Ja',
	'createpage-no' => 'Nee',
	'createpage-categories' => 'Kategorieë',
	'createpage-addcategory' => 'Voeg kategorie by',
	'createpage-login-required' => 'U moet ',
	'createpage-please-wait' => 'Wag asseblief...',
	'createpage-upload-aborted' => 'Invoeg van beeld was gekanselleer',
	'createpage-uploaded-from' => 'Opgelaai vanuit Special:CreatePage',
);

/** Assamese (অসমীয়া)
 * @author Chaipau
 */
$messages['as'] = array(
	'createpage-show' => 'দেখুৱাওক',
	'createpage-yes' => 'অঁ',
	'createpage-no' => 'না',
	'createpage-login-href' => ' প্রবেশ ',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'createpage-categories' => 'Катэгорыі',
);

/** Bulgarian (Български) */
$messages['bg'] = array(
	'createpage-categories' => 'Категории:',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'createpage-hide' => 'Kuzhat',
	'createpage-show' => 'Diskouez',
	'createpage' => 'Krouiñ ur pennad nevez',
	'createpage-title' => 'Krouiñ ur pennad nevez',
	'createpage-choose-createplate' => 'Dibabit doare ar bajenn',
	'createpage-yes' => 'Ya',
	'createpage-no' => 'Nann',
	'createpage-login-required' => "Rankout a reoc'h",
	'createpage-login-href' => ' kevreañ ',
	'createpage-top-of-page' => 'Penn uhelañ ar bajenn',
	'createpage-advanced-text' => "Tu 'zo deoc'h implijout $1 ivez.",
	'createpage-please-wait' => 'Gortozit mar plij...',
	'headline-tip-3' => 'Titl a live 3',
);

/** German (Deutsch) */
$messages['de'] = array(
	'createpage-edit-normal' => 'Erweiterter Editor',
	'createpage-hide' => 'Ausblenden',
	'createpage-show' => 'Einblenden',
	'createpage' => 'Neue Seite anlegen',
	'createpage-title' => 'Neue Seite anlegen',
	'createpage-title-additional' => 'Diese Seite existiert noch nicht. Um einen neuen Artikel zu erstellen, fülle das untenstehende Formular aus.',
	'createpage-title-caption' => 'Seitentitel:',
	'createpage-choose-createplate' => 'Wähle einen Seitentyp',
	'createpage-button-createplate-submit' => 'Diese Vorlage laden',
	'createpage-give-title' => 'Gib bitte einen Titel an',
	'createpage-title-invalid' => 'Gib bitte einen gültigen Titel an',
	'createpage-article-exists' => 'Diese Seite existiert bereits. Bearbeite',
	'createpage-article-exists2' => 'oder gib einen neuen Titel an.',
	'createpage-advanced-warning' => 'Der Wechsel des Editors kann die Formatierung der Seite stören - trotzdem fortfahren?',
	'createpage-login-warning' => 'Wenn du dich jetzt anmeldest, verlierst du möglicherweise deinen noch nicht gespeicherten Text. Trotzdem fortfahren?',
	'createpage-yes' => 'Ja',
	'createpage-no' => 'Nein',
	'createpage-categories' => 'Kategorien:',
	'createpage-addcategory' => 'Kategorie hinzufügen',
	'createpage-top-of-page' => 'Seitenanfang',
	'createpage-uploaded-from' => 'Upload via Special:CreatePage',
	'createplate-list' => 'Blank|Leer',
	'createplate-Blank' => '<!---blanktemplate--->

Füge hier Text ein',
	'createpage-title-check-header' => 'Du musst warten, bis der Namen überprüft wurde. Klicke dann erneut auf den Knopf zum fortfahren.',
	'createpage-img-uploaded' => 'Bild erfolgreich hochgeladen',
	'createpage-preview-end' => 'Ende der Vorschau. Du kannst jetzt unten mit deine Bearbeitung fortsetzen:',
	'createpage-insert-image' => 'Bild einfügen',
	'createpage-upload-aborted' => 'Einfügung des Bildes abgebrochen',
	'createpage-initial-run' => 'Zur Bearbeitung',
	'createpage-login-required' => 'Du musst dich',
	'createpage-login-href' => 'anmelden',
	'createpage-login-required2' => 'um Bilder hochzuladen',
	'createpage-please-wait' => 'Bitte warten...',
	'createpage-upload-directory-read-only' => 'Das Upload-Verzeichnis konnte nicht vom Webserver beschrieben werden',
	'createpage-about-info' => 'Dies ist der vereinfachte Editor. Weitere Informationen darüber findest du im [[w:c:de:Hilfe:Createpage|hier]].',
	'createpage-advanced-text' => 'Dir steht auch ein $1 zur Verfügung.',
	'createpage-advanced-edit' => 'erweiterter Editor',
	'createpage-optionals-text' => 'Füge optionale Abschnitte hinzu',
);

/** Greek (Ελληνικά)
 * @author Περίεργος
 */
$messages['el'] = array(
	'createpage-edit-normal' => 'Πρηγμένη Επεξεργασία',
	'createpage-upload' => 'Φόρτωση εικόνας',
	'createpage-hide' => 'Απόκρυψη',
	'createpage-show' => 'Εμφάνιση',
	'createpage' => 'Δημιουργήστε ένα καινούργιο άρθρο',
	'createpage-title' => 'Δημιουργήστε ένα καινούργιο άρθρο',
	'createpage-title-additional' => "Έχετε ακολουθήσει ένα σύνδεσμο σε μια σελίδα που δεν υπάρχει προς το παρών. Για να τη δημιουργήσετε, ξεκινήστε να πληκρολογείτε στο παρακάτω πλαίσιο",
	'createpage-title-caption' => 'Τίτλος Άρθρου',
	'createpage-choose-createplate' => 'Διαλέξτε έναν τύπο σελίδας',
	'createpage-button-createplate-submit' => 'Φόρτωση αυτού του προτύπου',
	'createpage-give-title' => 'Παρακαλώ προσδιορίστε έναν τίτλο',
	'createpage-title-invalid' => 'Παρακαλώ προσδιορίστε έναν έγκυρο τίτλο',
	'createpage-article-exists' => 'Αυτό το άρθρο υπάρχει ήδη. Επεξεργαστείτε το',
	'createpage-article-exists2' => ' ή προσδιορίστε άλλον τίτλο.',
	'createpage-advanced-warning' => 'Με την αλλαγή του τρόπου επεξεργασίας ίσως χαλάσει η μορφοποίηση της σελίδας, θέλετε να συνεχίσετε;',
	'createpage-login-warning' => 'Αν συνδεθείτε τώρα, ίσως χάσετε όσο κείμενο σας δεν έχει αποθηκευτεί. Θέλετε να συνεχίσετε;',
	'createpage-infobox-legend' => 'Κουτί πληροφοριών',
	'createpage-yes' => 'Ναι',
	'createpage-no' => 'Όχι',
	'createpage-categories' => 'Κατηγορίες',
	'createpage-addcategory' => 'Προσθήκη κατηγορίας',
	'createpage-top-of-page' => 'Πάνω μέρος της σελίδας',
	'createpage-title-check-header' => 'Υποχρεωτικός έλεγχος τίτλου',
	'createpage-img-uploaded' => 'Η εικόνα φορτωθηκε επιτυχώς',
	'createpage-preview-end' => 'Τέλος της προεπισκόπησης. Μπορείτε να επανέλθετε στην επεξεργασία σας παρακάτω:',
	'createpage-insert-image' => 'Εισαγωγή εικόνας',
	'createpage-upload-aborted' => 'Ακυρώθηκε η εισαγωγή της εικόνας',
	'createpage-initial-run' => 'Για επεξεργασία συνεχίστε',
	'createpage-login-required' => 'Χρειάζεται να ',
	'createpage-login-href' => ' συνδεθείτε ',
	'createpage-login-required2' => 'για να φορτώσετε εικόνες',
	'createpage-please-wait' => 'Παρακαλώ περιμένετε ...',
	'createpage-upload-directory-read-only' => 'Ο κατάλογος φορτώσεων δεν είναι εγγράψιμος από το διακομιστή',
	'headline-tip-3' => 'Επικεφαλίδα επιπέδου 3',
	'createpage-advanced-text' => 'Μπορείτε επίσης να χρησιμοποιήσετε το $ 1.',
	'createpage-advanced-edit' => 'προηγμένος συντάκτης',
	'createpage-optionals-text' => 'Βάλτε προαιρετικά τμήματα:',
);

/** Spanish (Español) */
$messages['es'] = array(
	'createpage-edit-normal' => 'Edición avanzada',
	'createpage-upload' => 'Subir una imagen',
	'createpage-hide' => 'Ocultar',
	'createpage-show' => 'Mostrar',
	'createpage' => 'Crear un nuevo artículo',
	'createpage-title' => 'Crear un nuevo artículo',
	'createpage-title-additional' => 'Has seguido un vínculo a una página que no existe. Para crear la página, comienza a escribir en la caja de debajo',
	'createpage-title-caption' => 'Título:',
	'createpage-choose-createplate' => 'Escoge un tipo de página',
	'createpage-button-createplate-submit' => 'Carga esta plantilla',
	'createpage-give-title' => 'Por favor, especifica un título',
	'createpage-title-invalid' => 'Por favor especifica un título valido',
	'createpage-article-exists' => 'Este artículo ya existe. Edítalo',
	'createpage-article-exists2' => 'o especifica otro título.',
	'createpage-advanced-warning' => 'Cambiar el modo de edición puede romper el formato de la página, ¿quieres continuar?',
	'createpage-login-warning' => 'Identificándote ahora, podrías perder todo el texto que no haya sido guardado. ¿Quieres continuar?',
	'createpage-yes' => 'Sí',
	'createpage-categories' => 'Categorías:',
	'createpage-top-of-page' => 'Parte superior de la página',
	'createpage-uploaded-from' => 'Subida desde Special:CreatePage',
	'createplate-Blank' => '<!---blanktemplate--->

Inserta texto aquí',
	'createpage-title-check-header' => 'Comprobación del título obligada',
	'createpage-title-check-text' => 'No puedes realizar ninguna acción hasta que la comprobación del título haya finalizado. Por favor haz click de nuevo en el botón de acción para continuar.',
	'createpage-img-uploaded' => 'Imagen cargada con éxito',
	'createpage-preview-end' => 'Final de la previsualización. Puedes resumir tu edición debajo.',
	'createpage-insert-image' => 'Insertar Imagen',
	'createpage-upload-aborted' => 'La inserción de la imagen fue cancelada',
	'createpage-initial-run' => 'Proceder a editar',
	'createpage-login-required' => 'Necesitas',
	'createpage-login-href' => 'estar identificado',
	'createpage-login-required2' => 'para subir imágenes',
	'createpage-please-wait' => 'Por favor, espere...',
	'createpage-upload-directory-read-only' => 'El directorio de subida no se puede escribir por el servidor de la web',
	'createpage-about-info' => 'Este es un editor simplificado. Para saber más ve a la [[s:Help:CreatePage|Hub de ShoutWiki]].',
	'createpage-advanced-text' => 'Puedes usar también el $1.',
	'createpage-advanced-edit' => 'editor avanzado',
	'tog-createpage-redlinks' => 'Usa [http://www.shoutwiki.com/wiki/Help:CreatePage CreatePage] cuando sigas enlaces rotos',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'createpage' => 'ایجاد مقالۀ جدید',
	'createpage-title' => 'ایجاد مقالۀ جدید',
	'createpage-title-caption' => 'نام',
	'createpage-categories' => 'رده‌ها:',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'createpage-edit-normal' => 'Kehittynyt muokkaus',
	'createpage-upload' => 'Tallenna kuva',
	'createpage-hide' => 'Piilota',
	'createpage-show' => 'Näytä',
	'createpage' => 'Luo uusi artikkeli',
	'createpage-title' => 'Luo uusi artikkeli',
	'createpage-title-additional' => 'Olet seurannut linkkiä sivulle, jota ei ole vielä olemassa. Aloita kirjoittaminen allaolevaan laatikkoon luodaksesi sivun',
	'createpage-title-caption' => 'Artikkelin otsikko',
	'createpage-choose-createplate' => 'Valitse sivun tyyppi',
	'createpage-button-createplate-submit' => 'Lataa tämä malline',
	'createpage-give-title' => 'Anna otsikko',
	'createpage-title-invalid' => 'Anna kelvollinen otsikko',
	'createpage-article-exists' => 'Tämä artikkeli on jo olemassa. Muokkaa artikkelia',
	'createpage-article-exists2' => ' tai anna toinen otsikko.',
	'createpage-advanced-warning' => 'Muokkaustilojen vaihtaminen saattaa rikkoa sivun muotoilun, haluatko jatkaa?',
	'createpage-login-warning' => 'Kirjautumalla sisään nyt saatat menettää kaiken tallentamattoman tekstin. Haluatko jatkaa?',
	'createpage-infobox-legend' => 'Tietolaatikko',
	'createpage-yes' => 'Kyllä',
	'createpage-no' => 'Ei',
	'createpage-categories' => 'Luokat',
	'createpage-addcategory' => 'Lisää luokka',
	'createpage-top-of-page' => 'Sivun yläosa',
	'createpage-uploaded-from' => 'Tallennettu Special:CreatePage-toimintosivun kautta',
	'createplate-list' => 'Blank|Tyhjä',
	'createpage-title-check-header' => 'Otsikon tarkastus on pakollinen',
	'createpage-title-check-text' => 'Et voi tehdä mitään ennen kuin otsikon tarkastus on päättynyt. Napsauta painiketta jälleen jatkaaksesi.',
	'createpage-img-uploaded' => 'Kuva tallennettu onnistuneesti',
	'createpage-preview-end' => 'Esikatselun loppu. Voit jatkaa muokkaamistasi alempana:',
	'createpage-insert-image' => 'Lisää kuva',
	'createpage-upload-aborted' => 'Kuvan lisääminen peruuttiin',
	'createpage-initial-run' => 'Jatka muokkaamiseen',
	'createpage-login-required' => 'Sinun tulee ',
	'createpage-login-href' => ' kirjautua sisään ',
	'createpage-login-required2' => 'tallentaaksesi kuvia',
	'createpage-please-wait' => 'Odota...',
	'createpage-upload-directory-read-only' => 'Web-palvelin ei voi kirjoittaa tallennuskansioon',
	'headline-tip-3' => 'Kolmostason otsikko',
	'createpage-about-info' => 'Tämä on yksinkertaistettu editori. Katso [[s:w:fi:Ohje:CreatePage|ShoutWikin ohjeista]] saadaksesi lisätietoja.',
	'createpage-advanced-text' => 'Voit myös käyttää $1.',
	'createpage-advanced-edit' => 'kehittynyttä editoria',
	'createpage-optionals-text' => 'Lisää vapaaehtoisia osioita:',
	'createpage-save' => 'Tallenna',
	'createpage-must-specify-title' => 'Anna otsikko ensiksi!',
	'createpage-unsaved-changes' => 'Tallentamattomat muutokset',
	'createpage-unsaved-changes-details' => 'Sinulla on tallentamattomia muutoksia. Painamalla OK-painiketta hylkäät ne.',
	'tog-createpage-redlinks' => 'Käytä [http://fi.shoutwiki.com/wiki/Ohje:CreatePage CreatePagea] rikkinäisiä linkkejä seuratessa',
	'createpage-template-infobox-format' => '/\{\{[^\{\}]*tietolaatikko.*\}\}/is',
);

/** French (Français)
 * @author Alexandre Emsenhuber
 * @author Jack Phoenix <jack@countervandalism.net>
 * @author Peter17
 */
$messages['fr'] = array(
	'createpage-edit-normal' => 'Modification avancée',
	'createpage-upload' => 'Importer une image',
	'createpage-hide' => 'Masquer',
	'createpage-show' => 'Afficher',
	'createpage' => 'Créer un nouvel article',
	'createpage-title' => 'Créer un nouvel article',
	'createpage-title-additional' => "Vous avez suivi un lien vers une page qui n'existe pas. Pour créer cette page, commencer à taper dans la boîte ci-dessous",
	'createpage-title-caption' => "Titre de l'article",
	'createpage-choose-createplate' => 'Choisissez un type de page',
	'createpage-button-createplate-submit' => 'Charger le modèle',
	'createpage-give-title' => 'Spécifiez un titre',
	'createpage-title-invalid' => 'Spécifiez un titre valide',
	'createpage-article-exists' => 'Cet article existe déjà. Modifier',
	'createpage-article-exists2' => ' ou spécifiez un autre titre.',
	'createpage-advanced-warning' => "Basculer entre les modes de modification peut casser l'affichage de la page, voulez-vous continuer ?",
	'createpage-login-warning' => 'En vous connectant maintenant, vous pouvez perdre votre texte non sauvegardé. Voulez-vous continuer ?',
	'createpage-infobox-legend' => 'Infobox',
	'createpage-yes' => 'Oui',
	'createpage-no' => 'Non',
	'createpage-categories' => 'Catégories :',
	'createpage-addcategory' => 'Ajouter une catégorie',
	'createpage-top-of-page' => 'Haut de la page',
	'createpage-uploaded-from' => 'Importé depuis Special:CreatePage',
	'createplate-list' => 'Blank|Vide',
	'createpage-title-check-header' => 'Vérification du titre forcée',
	'createpage-title-check-text' => "Vous ne pouvez rien faire tant que la vérification du titre n'est pas terminée. Pour ce faire, veuillez cliquer à nouveau sur le bouton d'action.",
	'createpage-img-uploaded' => 'Image importée avec succès',
	'createpage-preview-end' => 'Fin de la prévisualisation. Vous pouvez reprendre votre modification ci-dessous :',
	'createpage-insert-image' => 'Insérer un image',
	'createpage-upload-aborted' => "L'insertion de l'image a été annulée",
	'createpage-initial-run' => 'Procéder à la modification',
	'createpage-login-required' => 'Vous devez ',
	'createpage-login-href' => ' vous connecter ',
	'createpage-login-required2' => 'pour importer des images',
	'createpage-please-wait' => 'Veuillez patienter...',
	'createpage-upload-directory-read-only' => "Le dossier d'import n'est pas inscriptible par le serveur web",
	'headline-tip-3' => 'Titre de niveau 3',
	'createpage-about-info' => "Ceci est l'éditeur simplifié. Pour en savoir plus, allez sur [[s:Help:CreatePage|ShoutWiki Hub]].",
	'createpage-advanced-text' => "Vous pouvez également utiliser l'$1.",
	'createpage-advanced-edit' => 'éditeur avancé',
	'createpage-optionals-text' => 'Ajouter des sections optionnelles :',
	'createpage-save' => 'Sauvegarde',
	'tog-createpage-redlinks' => 'Utiliser [http://www.shoutwiki.com/wiki/Help:CreatePage CreatePage] après avoir suivi des liens cassés',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'createpage-edit-normal' => 'Edición avanzada',
	'createpage-upload' => 'Cargar unha imaxe',
	'createpage-hide' => 'Agochar',
	'createpage-show' => 'Mostrar',
	'createpage' => 'Crear un novo artigo',
	'createpage-title' => 'Crear un novo artigo',
	'createpage-title-additional' => 'Seguiu unha ligazón cara a unha páxina que aínda non existe. Para crear a páxina, comece escribindo na caixa de embaixo',
	'createpage-title-caption' => 'Título do artigo',
	'createpage-choose-createplate' => 'Escolla un tipo de páxina',
	'createpage-button-createplate-submit' => 'Cargar este modelo',
	'createpage-give-title' => 'Por favor, especifique un título',
	'createpage-title-invalid' => 'Por favor, especifique un título válido',
	'createpage-article-exists' => 'Este artigo xa existe. Edite',
	'createpage-article-exists2' => ' ou especifique outro título.',
	'createpage-advanced-warning' => 'A alternancia entre modos de edición pode estragar o formato da páxina, quere continuar?',
	'createpage-login-warning' => 'Se accede ao sistema nestes intres, pode perder todo o texto non gardado. Quere continuar?',
	'createpage-infobox-legend' => 'Caixa de información',
	'createpage-yes' => 'Si',
	'createpage-no' => 'Non',
	'createpage-categories' => 'Categorías',
	'createpage-addcategory' => 'Engadir unha categoría',
	'createpage-top-of-page' => 'Alto da páxina',
	'createpage-uploaded-from' => 'Cargado desde Special:CreatePage',
	'createpage-title-check-header' => 'Comprobación do título forzada',
	'createpage-img-uploaded' => 'A imaxe cargouse con éxito',
	'createpage-preview-end' => 'Fin da vista previa. Pode continuar coa súa edición a continuación:',
	'createpage-insert-image' => 'Inserir unha imaxe',
	'createpage-upload-aborted' => 'A inserción da imaxe foi cancelada',
	'createpage-initial-run' => 'Continuar a editar',
	'createpage-login-required' => 'Necesita ',
	'createpage-login-href' => ' acceder ao sistema ',
	'createpage-login-required2' => 'para cargar imaxes',
	'createpage-please-wait' => 'Por favor, agarde...',
	'createpage-upload-directory-read-only' => 'O servidor non pode escribir no directorio de cargas',
	'createpage-about-info' => 'Este é o editor simplificado. Para saber máis olla a [[s:Help:CreatePage|ShoutWiki Hub]].',
	'createpage-advanced-text' => 'Tamén pode usar o $1.',
	'createpage-advanced-edit' => 'editor avanzado',
	'createpage-optionals-text' => 'Engadir seccións opcionais:',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'createpage-hide' => 'Elrejtés',
	'createpage-show' => 'Megjelenítés',
	'createpage-yes' => 'Igen',
	'createpage-no' => 'Nem',
	'createpage-categories' => 'Kategóriák',
	'createpage-addcategory' => 'Kategória hozzáadása',
	'createpage-login-href' => ' bejelentkezés ',
);

/** Japanese (日本語) */
$messages['ja'] = array(
	'createpage-edit-normal' => '通常の編集',
	'createpage-hide' => '非表示',
	'createpage-show' => '表示',
	'createpage' => '新規記事を作成',
	'createpage-title' => '新規記事を作成',
	'createpage-title-additional' => '作成する記事のタイプを選択し、入力欄にタイトルを入力してください。',
	'createpage-title-caption' => 'タイトル:',
	'createpage-title-invalid' => '有効なタイトルを指定してください',
	'createpage-login-warning' => '今ログインすると保存されていないテキストは失われます。続けますか？',
	'createpage-yes' => 'はい',
	'createpage-no' => 'いいえ',
	'createpage-categories' => 'カテゴリ:',
	'createpage-top-of-page' => 'ページトップ',
	'createpage-uploaded-from' => '[[Special:CreatePage]]よりアップロード',
	'createplate-list' => 'Blank|白紙',
	'createplate-Blank' => '<!---blanktemplate--->

ここにテキストを入力してください。',
	'createpage-title-check-text' => 'タイトルのチェックが完了しないと次へ進めません。続けるにはもう一度ボタンをクリックしてください。',
	'createpage-preview-end' => 'プレビューはここまでです。以下で編集を継続できます。',
	'createpage-insert-image' => '画像を挿入',
	'createpage-initial-run' => '編集を開始',
	'createpage-login-required' => '画像をアップロードするには',
	'createpage-login-href' => 'ログイン',
	'createpage-login-required2' => 'する必要があります',
	'createpage-please-wait' => 'お待ちください...',
	'createpage-about-info' => 'シンプルなエディタです。詳細は、ウィキアのヘルプをどうぞ。',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'createpage-edit-normal' => 'Напредно уредување',
	'createpage-upload' => 'Подигни слика',
	'createpage-hide' => 'Сокриј',
	'createpage-show' => 'Прикажи',
	'createpage' => 'Создај нова статија',
	'createpage-title' => 'Создај нова статија',
	'createpage-title-additional' => 'Проследивте врска до статија која сè уште не постои. За да ја создадете, почнете да пишувате во полето подолу',
	'createpage-title-caption' => 'Наслов на статијата',
	'createpage-choose-createplate' => 'Изберете тип на страница',
	'createpage-button-createplate-submit' => 'Вчитај го шаблонов',
	'createpage-give-title' => 'Назначете наслов',
	'createpage-title-invalid' => 'Назначете важечки наслов',
	'createpage-article-exists' => 'Оваа статија веќе постои. Уредете ја',
	'createpage-article-exists2' => ' или назначете друг наслов.',
	'createpage-advanced-warning' => 'Префрлањето од еден на друг режим на уредување може да го поремети форматирањето на страницата. Дали сакате да продолжите?',
	'createpage-login-warning' => 'Ако сега се најавите ќе го загубите сиот незачуван текст. Сакате да продолжите?',
	'createpage-infobox-legend' => 'Инфокутија',
	'createpage-yes' => 'Да',
	'createpage-no' => 'Не',
	'createpage-categories' => 'Категории',
	'createpage-addcategory' => 'Додај категорија',
	'createpage-top-of-page' => 'Врв на страницата',
	'createpage-uploaded-from' => 'Подигнато преку Special:CreatePage',
	'createpage-title-check-header' => 'Проверката на наслови е во сила',
	'createpage-title-check-text' => 'Не можете да извршите дејство сè додека не заврши проверката на насловот. Кликнете повторно на копчето за дејството за да продолжите.',
	'createpage-img-uploaded' => 'Сликата е успешно подигната',
	'createpage-preview-end' => 'Крај на прегледот. Можете да продолжите со уредувањето подолу:',
	'createpage-insert-image' => 'Вметни слика',
	'createpage-upload-aborted' => 'Вметнувањето на слика е откажано',
	'createpage-initial-run' => 'Продолжете кон уредувањето',
	'createpage-login-required' => 'Треба да ',
	'createpage-login-href' => ' се најавите ',
	'createpage-login-required2' => 'да подигнете слики',
	'createpage-please-wait' => 'Почекајте...',
	'createpage-upload-directory-read-only' => 'Директориумот за подигање не е достапен за записи од веб-серверот',
	'headline-tip-3' => 'Наслов - Ниво 3',
	'createpage-about-info' => 'Ова е упростен уредник. За да дознаете повеќе, одете на [[s:Help:CreatePage|Помош со ShoutWiki]].',
	'createpage-advanced-text' => 'Можете да користите и $1.',
	'createpage-advanced-edit' => 'напреден уредник',
	'createpage-optionals-text' => 'Додај дополнителни делови:',
	'tog-createpage-redlinks' => 'Користи [http://www.shoutwiki.com/wiki/Help:CreatePage СоздајСтраница] кога следам прекинати врски',
	'createpage-template-infobox-format' => '/\{\{[^\{\}]*Инфокутија.*\}\}/is',
);

/** Dutch (Nederlands)
 * @author Siebrand Mazeland
 * @author Mitchel Corstjens
 */
$messages['nl'] = array(
	'createpage-edit-normal' => 'Uitgebreid bewerken',
	'createpage-upload' => 'Afbeelding uploaden',
	'createpage-hide' => 'Verbergen',
	'createpage-show' => 'Weergeven',
	'createpage' => 'Nieuwe pagina aanmaken',
	'createpage-title' => 'Nieuwe pagina aanmaken',
	'createpage-title-additional' => 'U hebt een verwijzing gevolgd naar een pagina die niet bestaat. Geef uw invoer in de velden hieronder om te pagina aan te maken.',
	'createpage-title-caption' => 'Paginanaam',
	'createpage-choose-createplate' => 'Kies een paginatype',
	'createpage-button-createplate-submit' => 'Dit sjabloon laden',
	'createpage-give-title' => 'Geef een naam op',
	'createpage-title-invalid' => 'Geef een geldige paginanaam op',
	'createpage-article-exists' => 'Deze pagina bestaat al. Bewerk',
	'createpage-article-exists2' => ' of geef een andere paginaam op.',
	'createpage-advanced-warning' => 'Door het wisselen van tekstverwerker kunt u de paginaopmaak stuk maken. Wilt u doorgaan?',
	'createpage-login-warning' => 'Door nu aan te melden kunt u alle wijzigingen die niet zijn opgeslagen kwijt raken. Wilt u doorgaan?',
	'createpage-infobox-legend' => 'Informatievenster',
	'createpage-yes' => 'Ja',
	'createpage-no' => 'Nee',
	'createpage-categories' => 'Categorieën',
	'createpage-addcategory' => 'Categorie toevoegen',
	'createpage-top-of-page' => 'Bovenaan pagina',
	'createpage-uploaded-from' => 'Geüpload vanuit Special:CreatePage',
	'createplate-list' => 'Blank|Leeg',
	'createpage-title-check-header' => 'Paginanaamcontrole wordt uitgevoerd',
	'createpage-title-check-text' => 'U kunt geen handelingen verrichten tot dat naamcontrole is uitgevoerd. Klik nogmaals op de knop voor de handeling om door te gaan.',
	'createpage-img-uploaded' => 'De afbeelding is geüpload',
	'createpage-preview-end' => 'Einde van de voorvertoning. U kunt hieronder doorgaan met bewerken:',
	'createpage-insert-image' => 'Afbeelding invoegen',
	'createpage-upload-aborted' => 'Het invoegen van de afbeelding is afgebroken',
	'createpage-initial-run' => 'Doorgaan naar bewerken',
	'createpage-login-required' => 'U moet ',
	'createpage-login-href' => ' aanmelden ',
	'createpage-login-required2' => 'om afbeeldingen te uploaden',
	'createpage-please-wait' => 'Even geduld alstublieft...',
	'createpage-upload-directory-read-only' => 'Er kan niet geschreven worden in de uploadmap van de webserver',
	'headline-tip-3' => 'Niveau 3 koptekst',
	'createpage-about-info' => 'Dit is de vereenvoudigde tekstverwerker. Meer hulp is te vinden in [[s:Help:CreatePage|ShoutWiki Hub]].',
	'createpage-advanced-text' => 'U kunt ook de $1 gebruiken.',
	'createpage-advanced-edit' => 'uitgebreide tekstverwerker',
	'createpage-optionals-text' => 'Optionele secties toevoegen:',
	'createpage-save' => 'Opslaan',
	'tog-createpage-redlinks' => 'Gebruik [http://www.shoutwiki.com/wiki/Help:CreatePage pagina aanmaken] als u verbroken verwijzigen volgt',
	'createpage-template-infobox-format' => '/\{\{[^\{\}]*Informatievenster.*\}\}/is',
);

/** Polish (Polskie)
 * @author Bartek Łapiński
 * @author Łukasz Garczewski
 * @author Przemek Piotrowski
 */
$messages['pl'] = array(
	'createpage-edit-normal' => 'Edytor zaawansowany',
	'createpage-upload' => 'Załaduj obrazek',
	'createpage-hide' => 'Ukryj',
	'createpage' => 'Stwórz Stronę',
	'createpage-title' => 'Stwórz Stronę',
	'createpage-title-caption' => 'Tytuł',
	'createpage-choose-createplate' => 'Wybierz typ strony',
	'createpage-button-createplate-submit' => 'Załaduj ten szablon',
	'createpage-give-title' => 'Proszę podać tytuł',
	'createpage-title-invalid' => 'Proszę podać poprawny tytuł',
	'createpage-article-exists' => 'Ten artykuł już istnieje. Edytuj ',
	'createpage-article-exists2' => ' lub podaj inny tytuł',
	'createpage-advanced-warning' => 'Zmiana trybu edycji może spowodować utratę formatowania, czy chcesz kontynuować?',
	'createpage-login-warning' => 'Logowanie w tej chwili może spowodować utratę niezapisanych danych. Czy chcesz kontynuować?',
	'createpage-infobox-legend' => 'Infobox',
	'createpage-yes' => 'Tak',
	'createpage-no' => 'Nie',
	'createpage-categories' => 'Kategorie',
	'createpage-addcategory' => 'Dodaj kategorię',
	'createpage-top-of-page' => 'Początek strony',
	'createpage-uploaded-from' => 'Załadowane z Special:CreatePage',
	'createplate-list' => 'Blank|Pusty',
	'createpage-title-check-header' => 'Konieczne dokończenie sprawdzania tytułu',
	'createpage-title-check-text' => 'Nie możesz dokończyć obecnej akcji, zanim nie zakończy się procedura sprawdzania tytułu. Naciśnij jeszcze raz przycisk akcji, by ją dokończyć.',
	'createpage-img-uploaded' => 'Obrazek został załadowany',
	'createpage-preview-end' => 'Koniec podglądu. Możesz kontynuować tworzenie artykułu poniżej',
	'createpage-insert-image' => 'Wstaw Obrazek',
	'createpage-upload-aborted' => 'Wstawianie obrazka zostało anulowane',
	'createpage-initial-run' => 'Przejdź do edycji',
	'createpage-login-required' => 'Musisz ',
	'createpage-login-href' => ' zalogować się ',
	'createpage-login-required2' => 'by ładować obrazki',
	'createpage-please-wait' => 'Proszę czekać...',
	'createpage-upload-directory-read-only' => 'Katalog ładowania obrazków nie jest zapisywalny przez serwer',
	'headline-tip-3' => 'Nagłówek poziom 3',
	'createpage-about-info' => 'Jesteś w uproszczonym edytorze. Więcej informacji o nim znajdziesz na [[s:Help:CreatePage|ShoutWiki Hub]].',
	'createpage-advanced-text' => 'Możesz też użyć $1',
	'createpage-advanced-edit' => 'zaawansowanego edytora',
	'createpage-optionals-text' => 'Dodaj opcjonalne sekcje:',
	'tog-createpage-redlinks' => 'Otwórz [http://www.shoutwiki.com/wiki/Help:CreatePage CreatePage\'a] po przejściu do nieistniejącej strony'
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'createpage-edit-normal' => 'Modìfiche Avansà',
	'createpage-upload' => 'Carié figura',
	'createpage-hide' => 'Stërmé',
	'createpage-show' => 'Mosté',
	'createpage' => 'Creé un neuv artìcol',
	'createpage-title' => 'Creé un neuv artìcol',
	'createpage-title-additional' => "It ses andàit daré a na pàgina ch'a esist pa ancó. Për creé la pàgina, ancamin-a a scrive ant la forma sota",
	'createpage-title-caption' => "Tìtol ëd l'artìcol",
	'createpage-choose-createplate' => 'Sern na sòrt ëd pàgina',
	'createpage-button-createplate-submit' => 'Caria sto stamp-sì',
	'createpage-give-title' => 'Për piasì spessìfica un tìtol',
	'createpage-title-invalid' => 'Për piasì spessìfica un tìtol bon',
	'createpage-article-exists' => 'Sto artìcol-sì a esist già. Modìfica',
	'createpage-article-exists2' => " o spessìfica n'àutr tìtol.",
	'createpage-advanced-warning' => 'Cangé manera ëd modifiché a peul rompe la formatassion ëd la pàgina, it veus-to continué?',
	'createpage-login-warning' => 'An intrand adess, it peule perde tut tò test pa salvà. It veus-to continué?',
	'createpage-infobox-legend' => 'Infobox',
	'createpage-yes' => 'É',
	'createpage-no' => 'Nò',
	'createpage-categories' => 'Categorìe',
	'createpage-addcategory' => 'Gionta categorìa',
	'createpage-top-of-page' => 'Testa dla pàgina',
	'createpage-uploaded-from' => 'Carià da Special:CreatePage',
	'createpage-title-check-header' => 'Contròl ëd tìtol forsà',
	'createpage-title-check-text' => "It peule pa fé n'assion fin che ël contròl ëd tìtol a sia finì. Për piasì sgnaca torna an sël boton ëd l'assion për andé anans.",
	'createpage-img-uploaded' => 'Figura carià da bin',
	'createpage-preview-end' => 'Fin ëd la previsualisassion. It peule arcominsé toe modìfiche sota:',
	'createpage-insert-image' => 'Ansëriss Figura',
	'createpage-upload-aborted' => "Figura ansërìa a l'é stàita scanselà",
	'createpage-initial-run' => 'Va anans a modifiché',
	'createpage-login-required' => 'It deuve ',
	'createpage-login-href' => ' rintré ant ël sistema ',
	'createpage-login-required2' => 'për carié figure',
	'createpage-please-wait' => 'Për piasì speta...',
	'createpage-upload-directory-read-only' => 'Ël webserver a-i la fa nen a scrive ansima a la directory ëd càrich.',
	'headline-tip-3' => 'Linea testà livel 3',
	'createpage-about-info' => "Sto sì a l'é l'editor semplificà. Për savèjne ëd pi va a [[s:Help:CreatePage|ShoutWiki Hub]].",
	'createpage-advanced-text' => 'It peule ëdcò dovré ël $1.',
	'createpage-advanced-edit' => 'editor avansà',
	'createpage-optionals-text' => 'Gionta session opsinaj:',
	'tog-createpage-redlinks' => 'Dòvra [http://www.shoutwiki.com/wiki/Help:CreatePage CreatePage] quand dré a colegament pa bon',
);

/** Portuguese (Português)
 * @author Jesielt
 */
$messages['pt'] = array(
	'createpage-no' => 'Não',
	'createpage-yes' => 'Sim',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'createpage-login-warning' => 'Ao fazer o login você irá perder todo o texto ainda não salvo. Deseja continuar ainda assim?',
);

/** Russian (Русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'createpage-addcategory' => 'Добавить категорию',
	'createpage-hide' => 'Скрыть',
	'createpage-show' => 'Показать',
	'createpage-insert-image' => 'Вставить изображение',
	'createpage-infobox-legend' => 'Карточка',
	'createpage-yes' => 'Да',
	'createpage-no' => 'Нет',
	'createpage-template-infobox-format' => '/\{\{[^\{\}]*Карточка.*\}\}/is',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'createpage-upload' => 'Ladda upp en bild',
	'createpage-hide' => 'Göm',
	'createpage-show' => 'Visa',
	'createpage' => 'Skapa en ny artikel',
	'createpage-title' => 'Skapa en ny artikel',
	'createpage-title-caption' => 'Artikeltitel',
	'createpage-infobox-legend' => 'Inforuta',
	'createpage-yes' => 'Ja',
	'createpage-no' => 'Nej',
	'createpage-categories' => 'Kategorier',
	'createpage-addcategory' => 'Lägg till kategori',
	'createpage-top-of-page' => 'Överst på sidan',
	'createpage-insert-image' => 'Infoga bild',
	'createpage-login-required' => 'Du måste ',
	'createpage-please-wait' => 'Vänligen vänta...',
	'createpage-advanced-text' => 'Du kan också använda $1.',
	'createpage-advanced-edit' => 'avancerad editor',
	'createpage-template-infobox-format' => '/\{\{[^\{\}]*Inforuta.*\}\}/is',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'createpage-edit-normal' => 'Advanced Edit',
	'createpage-upload' => 'Завантажити зображення',
	'createpage-hide' => 'Сховати',
	'createpage-show' => 'Показати',
	'createpage' => 'Створити нову статтю',
	'createpage-title' => 'Створити нову статтю',
	'createpage-title-caption' => 'Назва статті',
	'createpage-yes' => 'Так',
	'createpage-no' => 'Ні',
	'createpage-categories' => 'Категорії',
	'createpage-addcategory' => 'Додати категорію',
	'createpage-login-required' => 'Вам необхідно ',
	'createpage-please-wait' => 'Будь ласка, зачекайте...',
	'createpage-advanced-text' => 'Ви можете також скористатись $1.',
);

/** Chinese (中文)
 * @author 許瑜真 (Yuchen Hsu/KaurJmeb)
 */
$messages['zh'] = array(
	'createpage' => '發表新文章',
	'createpage-title' => '發表新文章',
	'createpage-title-caption' => '文章標題',
	'createpage-categories' => '分類：',
);

/** Chinese (PRC)‬ (‪中文(中国大陆)‬)
 * @author 許瑜真 (Yuchen Hsu/KaurJmeb)
 */
$messages['zh-cn'] = array(
	'createpage' => '发表新文章',
	'createpage-title' => '发表新文章',
	'createpage-title-caption' => '文章标题',
	'createpage-categories' => '分类：',
);

/** Simplified Chinese (‪中文(简化字)‬)
 * @author 許瑜真 (Yuchen Hsu/KaurJmeb)
 */
$messages['zh-hans'] = array(
	'createpage' => '发表新文章',
	'createpage-title' => '发表新文章',
	'createpage-title-caption' => '文章标题',
	'createpage-categories' => '分类：',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author 許瑜真 (Yuchen Hsu/KaurJmeb)
 */
$messages['zh-hant'] = array(
	'createpage' => '發表新文章',
	'createpage-title' => '發表新文章',
	'createpage-title-caption' => '文章標題',
	'createpage-categories' => '分類：',
);

/** Chinese (Hong Kong) (‪中文(香港)‬)
 * @author 許瑜真 (Yuchen Hsu/KaurJmeb)
 */
$messages['zh-hk'] = array(
	'createpage' => '發表新文章',
	'createpage-title' => '發表新文章',
	'createpage-title-caption' => '文章標題',
	'createpage-categories' => '分類：',
);

/** Chinese (Singapore) (‪中文(新加坡)‬) */
$messages['zh-sg'] = array(
	'createpage' => '发表新文章',
	'createpage-title' => '发表新文章',
	'createpage-title-caption' => '文章标题',
	'createpage-categories' => '分类：',
);

/** Taiwan Chinese (‪中文(台灣)‬)
 * @author 許瑜真 (Yuchen Hsu/KaurJmeb)
 */
$messages['zh-tw'] = array(
	'createpage-edit-normal' => '進階編輯',
	'createpage-upload' => '上傳圖片',
	'createpage-hide' => '隱藏',
	'createpage' => '發表新文章',
	'createpage-title' => '發表新文章',
	'createpage-title-caption' => '文章標題',
	'createpage-button-createplate-submit' => '載入此模板',
	'createpage-article-exists' => '此頁面已存在',
	'createpage-advanced-warning' => '轉換編輯模式可能會影響頁面的格式，你確定要轉換嗎？',
	'createpage-categories' => '分類：',
);