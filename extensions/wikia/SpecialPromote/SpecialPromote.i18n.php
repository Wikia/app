<?php

/**
 * Internationalisation file for the SpecialPromote extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	'promote-desc' => 'SpecialPromote page is enable for admins to add information about their wiki. After review of those informations it can show up on Fandom.com',
	'promote' => 'Promote',

	'promote-title' => 'Promote',
	'promote-introduction-header' => 'Promote your wiki on Fandom.com',
	'promote-nocorp-introduction-header' => 'Promote $1',

	'promote-introduction-copy' => "This page allows you to promote your wiki by making it eligible to appear on [http://www.wikia.com Fandom.com]! Add images and a summary to introduce your wiki to visitors on Fandom's main page. Find more tips [http://help.wikia.com/wiki/Help:Promote here].",
	'promote-nocorp-introduction-copy' => "Add images and a summary to let visitors know what this wiki is all about and encourage them to visit. We'll use this information to promote your wiki in search results, Fandom mobile apps, and more. Find more tips on how to use this tool [http://community.wikia.com/wiki/Help:Promote here].",

	'promote-description' => 'Description',
	'promote-description-header' => 'Headline',
	'promote-description-header-explanation' => 'Something as simple as "Learn more about the Bacon Wiki" or "Welcome to the Bacon Wiki" is great!',

	'promote-description-about' => "What's your wiki about?",
	'promote-description-about-explanation' => "Write a summary about your wiki's topic.  Don't be afraid to make it detailed, you want to get visitors excited about the topic and make sure they have a clear idea of what your wiki is all about.",

	'promote-upload' => 'Add Images',
	'promote-upload-main-photo-header' => 'Main Image',
	'promote-upload-main-photo-explanation' => "This image defines your wiki. It will be the main image we use to represent your wiki on Fandom.com so make sure it's a great one! Don't forget, you can always update this image so it's current and most represents your wiki.",
	'promote-nocorp-upload-main-photo-explanation' => "This will be the main image we use to represent your wiki, so make sure it's a great one! This image can always be updated later so it stays current.",
	'promote-upload-additional-photos-header' => 'Additional Images',
	'promote-upload-additional-photos-explanation' => 'Adding more images makes your wiki look more interesting and engaging to potential visitors.You can add up to nine images here, and we strongly recommend you hit the limit!',

	'promote-publish' => 'Publish',

	'promote-add-photo' => 'Add a photo',
	'promote-remove-photo' => 'Remove',
	'promote-modify-photo' => 'Modify',

	'promote-upload-main-image-form-modal-title' => 'Main Image',
	'promote-upload-main-image-form-modal-copy' => "Upload an image that represents your wiki's topic. Make sure it's a \".png\" file with a minimum size of 480x320.",
	'promote-upload-additional-image-form-modal-title' => 'More Images',
	'promote-upload-additional-image-form-modal-copy' => "Upload additional images to tell people more about your wiki's topic. Make sure your images are \".png\" files with a minimum size of 480x320.",
	'promote-upload-form-modal-cancel' => 'Cancel',

	'promote-upload-submit-button' => 'Submit',

	'promote-error-less-characters-than-minimum' => 'Oops! Your text needs to be at least $2 characters.',
	'promote-error-more-characters-than-maximum' => 'Oops! Your text needs to be $2 characters or less.',
	'promote-error-upload-unknown-error' => 'Unknown upload error',
	'promote-error-upload-filetype-error' => 'Make sure your file is saved as a ".png"',
	'promote-error-upload-dimensions-error' => 'Wrong file dimensions - file should be at least 480x320px',
	'promote-error-too-many-images' => 'Oops! You already have nine images. Remove some if you want to add more.',
	'promote-error-upload-type' => "Oops! Wrong upload type.",
	'promote-error-upload-form' => "Wrong upload type in getUploadForm.",

	'promote-manual-file-size-error' => 'Main image has a minimum size of 480x320px.',
	'promote-manual-upload-error' => 'This file cannot be uploaded manually. Please use Admin Upload Tool.',
	'promote-wrong-rights' => "Darn, looks like you don't have permission to access this page. Make sure you're logged in!",

	'promote-image-rejected' => 'Rejected',
	'promote-image-accepted' => 'Accepted',
	'promote-image-in-review' => 'In review',

	'promote-statusbar-icon' => 'Status',
	'promote-statusbar-inreview' => 'Some of your images are currently in review and will appear on [http://www.wikia.com Fandom.com] after they\'re approved.  This can take 2-4 business days, so we\'ll update you here when we\'re done.',
	'promote-statusbar-approved' => 'Woohoo! $1 is promoted on [http://www.wikia.com Fandom.com]!',
	'promote-statusbar-rejected' => 'One or more of your images was not approved. [[Special:Contact|Find out why]]',
	'promote-statusbar-auto-approved' => 'Woohoo! $1 is being promoted!',

	'promote-error-oasis-only' => 'This page is not supported under your skin. Please [[Special:Preferences|switch to the Fandom skin]] to access this feature.',

	//message included in auto-uploaded image's description fb#45624
	'wikiahome-image-auto-uploaded-comment' => 'Auto-generated image to be used on http://wikia.com/ – stay tuned for more info on the Staff Blog: http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog',

	'promote-upload-image-uploads-disabled' => 'File uploads are currently disabled on your wiki. Please try again later.',

	'promote-extension-under-rework-header' => 'Special:Promote disabled',
	'promote-extension-under-rework' => 'The Special:Promote module has been disabled. A new feature is currently in progress and will be announced soon. If there are questions, please don\'t hesitate to reach us through [[Special:Contact]].'
);

$messages['de'] = array(
	'promote' => 'Wiki vorstellen',

	'promote-title' => 'Wiki vorstellen',
	'promote-introduction-header' => 'Stelle dein Wiki auf Wikia\'s Hauptseite vor!',

	'promote-introduction-copy' => "Diese Seite ermöglicht dir, dein Wiki auf der [http://de.wikia.com Hauptseite von Wikia] vorzustellen! Füge Bilder und eine Beschreibung hinzu, um dein Wiki anderen Besuchern auf Wikia näherzubringen. Weitere Hinweise findest du auf der [http://hilfe.wikia.com/wiki/Hilfe:Wiki_vorstellen Hilfeseite].",

	'promote-description' => 'Beschreibung',
	'promote-description-header' => 'Überschrift',
	'promote-description-header-explanation' => 'Eine einfacher kurzer Text wie "Finde mehr über das Schlumpf-Wiki heraus" oder "Willkommen im Schlumpf-Wiki" funktioniert am besten!',

	'promote-description-about' => "Welches Thema behandelt dein Wiki?",
	'promote-description-about-explanation' => "Beschreibe das Thema deines Wikis. Hab keine Angst davor, den Text zu detailliert zu schreiben - du willst die Besucher ja für dein Thema begeistern und sicherstellen, dass sie eine gute Idee haben, was sie in deinem Wiki erwartet.",

	'promote-upload' => 'Bilder hinzufügen',
	'promote-upload-main-photo-header' => 'Hauptbild',
	'promote-upload-main-photo-explanation' => "Dieses Bild steht für dein Wiki. Es ist das Bild, welches dein Wiki auf der Hauptseite von Wikia repräsentiert - stell also sicher, dass es ein tolles Bild ist! Denk dran: Du kannst dieses Bild jederzeit ändern, so dass es aktuell ist und dein Wiki gut darstellt.",
	'promote-upload-additional-photos-header' => 'Zusätzliche Bilder',
	'promote-upload-additional-photos-explanation' => 'Durch weitere Bilder machst du dein Wiki interessanter und findest mehr mögliche Besucher. Du kannst bis zu neun Bilder hier einfügen - und wir empfehlen jedem, dieses Limit auszunutzen!',

	'promote-publish' => 'Veröffentlichen',

	'promote-add-photo' => 'Bild hinzufügen',
	'promote-remove-photo' => 'Entfernen',
	'promote-modify-photo' => 'Ändern',

	'promote-upload-main-image-form-modal-title' => 'Hauptbild',
	'promote-upload-main-image-form-modal-copy' => "Lade ein Bild hoch, dass das Thema deines Wikis verdeutlicht. Stelle sicher, dass es sich um eine \".png\"-Datei mit einer Mindestgröße von 480x320 Pixeln handelt.",
	'promote-upload-additional-image-form-modal-title' => 'Zusätzliche Bilder',
	'promote-upload-additional-image-form-modal-copy' => "Lade weitere Bilder hoch, um mehr von deinem Wiki zu zeigen. Stelle sicher, dass die Bilder im \".png\"-Format vorliegen und eine Mindestgröße von 480x320 haben.",
	'promote-upload-form-modal-cancel' => 'Abbrechen',

	'promote-upload-submit-button' => 'Los geht\'s',

	'promote-error-less-characters-than-minimum' => 'Ups! Dein Text muss mindestens $2 Buchstaben lang sein.',
	'promote-error-more-characters-than-maximum' => 'Ups! Deine Überschrift darf nicht länger als $2 Buchstaben sein.',
	'promote-error-upload-unknown-error' => 'Unbekannter Fehler beim Hochladen',
	'promote-error-upload-filetype-error' => 'Stelle sicher, dass du deine Datei im \".png\"-Format speicherst.',
	'promote-error-upload-dimensions-error' => 'Falsche Dateigröße - das Bild sollte mindestens 480x320 Pixel groß sein.',
	'promote-error-too-many-images' => 'Ups! Du hast bereits neun Bilder hinzugefügt. Bitte entferne erst welche, bevor du neue hinzufügst.',
	'promote-error-upload-type' => "Ups! Falsches Dateiformat.",
	'promote-error-upload-form' => "Falsches Dateiformat in getUploadForm.",

	'promote-manual-file-size-error' => 'Das Hauptbild muss mindestens 480x320 Pixel groß sein.',
	'promote-manual-upload-error' => 'Diese Datei kann nicht manuell hochgeladen werden - bitte nutze die Admin-Upload-Funktion.',
	'promote-wrong-rights' => "Verflixt - augenscheinlich hast du nicht ausreichende Rechte um diese Seite zu nutzen. Bist du angemeldet?",

	'promote-image-rejected' => 'Abgelehnt',
	'promote-image-accepted' => 'Akzeptiert',
	'promote-image-in-review' => 'Im Review',

	'promote-statusbar-icon' => 'Status',
	'promote-statusbar-inreview' => 'Einige deiner Bilder sind noch im Review-Prozess. Sie tauchen auf [http://de.wikia.com Wikias Hauptseite] auf, nachdem sie gerpüft wurden. Das kann 2-4 Arbeitstage dauern. Du findest dann hier ein Update, sobald das erledigt ist.',
	'promote-statusbar-approved' => 'Juchu! $1 wird nun auf [http://de.wikia.com Wikias Hauptseite] angezeigt!',
	'promote-statusbar-rejected' => 'Ein oder mehrere Bilder wurden nicht akzeptiert [[Special:Contact|Finde den Grund heraus]].',

	//message included in auto-uploaded image's description fb#45624
	'wikiahome-image-auto-uploaded-comment' => 'Automatisch erstelltes Bild für die Nutzung auf http://de.wikia.com – in Kürze dazu mehr Informationen im Wikia-Blog: http://de.community.wikia.com/wiki/Blog:Wikia_Deutschland_News',
);

$messages['fr'] = array(
	'promote' => 'Promouvoir',

	'promote-title' => 'Promouvoir',
	'promote-introduction-header' => 'Promouvez votre wiki sur fr.wikia.com',

	'promote-introduction-copy' => 'Cette page vous permet de promouvoir votre wiki en le rendant éligible pour apparaître sur [http://fr.wikia.com fr.wikia.com]&nbsp;! Ajoutez des images et un résumé pour présenter votre wiki aux visiteurs sur la page d\'accueil de Wikia. Trouvez plus d\'astuces [http://aide.wikia.com/wiki/Aide:Promouvoir ici].',

	'promote-description' => 'Description',
	'promote-description-header' => 'Titre',
	'promote-description-header-explanation' => 'Quelque chose d\'aussi simple que "Apprenez-en plus sur Wiki Saveurs du monde" ou "Bienvenue sur Wiki Saveurs du monde" est super !',

	'promote-description-about' => 'De quoi parle votre wiki ?',
	'promote-description-about-explanation' => 'Écrivez un résumé sur le sujet abordé par votre wiki. N\'ayez pas peur d\'écrire quelque chose de détaillé, vous souhaitez atteindre les visiteurs intéressés par le sujet et assurez-vous qu\'ils aient une idée précise de ce dont traite votre wiki.',

	'promote-upload' => 'Ajouter des images',
	'promote-upload-main-photo-header' => 'Image principale',
	'promote-upload-main-photo-explanation' => 'Cette image définit votre wiki. Ce sera l\'image principale que nous utiliserons pour représenter votre wiki sur fr.wikia.com, aussi assurez-vous que ce soit une bien ! N\'oubliez pas, vous pouvez toujours mettre à jour cette image pour qu\'elle soit d\'actualité et représente au mieux votre wiki.',
	'promote-upload-additional-photos-header' => 'Images supplémentaires',
	'promote-upload-additional-photos-explanation' => 'Ajouter plus d\'images rend votre wiki plus intéressant et attirant auprès de visiteurs potentiels. Vous pouvez ajouter jusqu\'à neuf images ici et nous vous recommandons vivement d\'atteindre la limite !',

	'promote-publish' => 'Publier',

	'promote-add-photo' => 'Ajouter une photo',
	'promote-remove-photo' => 'Retirer',
	'promote-modify-photo' => 'Modifier',

	'promote-upload-main-image-form-modal-title' => 'Image principale',
	'promote-upload-main-image-form-modal-copy' => 'Importez une image qui représente le sujet dont traite votre wiki. Assurez-vous que ce soit un fichier ".png" avec une taille minimale de 480x320 pixels.',
	'promote-upload-additional-image-form-modal-title' => 'Plus d\'images',
	'promote-upload-additional-image-form-modal-copy' => 'Importez des images supplémentaires pour en dire plus sur le sujet dont traite votre wiki. Assurez-vous que vos images soient des fichiers ".png" avec une taille minimale de 480x320 pixels',
	'promote-upload-form-modal-cancel' => 'Annuler',

	'promote-upload-submit-button' => 'Envoyer',

	'promote-error-less-characters-than-minimum' => 'Désolé, votre texte doit faire au moins $2 caractères.',
	'promote-error-more-characters-than-maximum' => 'Désolé, votre texte doit faire au plus $2 caractères.',
	'promote-error-upload-unknown-error' => 'Erreur d\'importation inconnue',
	'promote-error-upload-filetype-error' => 'Assurez-vous que votre fichier est enregistré au format PNG',
	'promote-error-upload-dimensions-error' => 'Taille de fichier incorrecte - le fichier doit être au moins de 480x320 pixels',
	'promote-error-too-many-images' => 'Désolé, vous avez déjà neuf images. Retirez-en quelques-unes si vous souhaitez en ajouter d\'autres.',
	'promote-error-upload-type' => 'Désolé, le type du fichier importé n\'est pas bon.',
	'promote-error-upload-form' => 'Mauvais type de fichier importé dans  getUploadForm.',

	'promote-manual-file-size-error' => 'L\'image principale a une taille minimale de 480x320 pixels.',
	'promote-manual-upload-error' => 'Ce fichier ne peut pas être importé manuellement. Veuillez utiliser l\'Outil d\'importation administrateur.',
	'promote-wrong-rights' => 'Zut, il semble que nous n\'ayez pas le droit d\'accéder à cette page. Assurez-vous d\'être connecté !',

	'promote-image-rejected' => 'Rejetée',
	'promote-image-accepted' => 'Acceptée',
	'promote-image-in-review' => 'Examinée',

	'promote-statusbar-icon' => 'État',
	'promote-statusbar-inreview' => 'Certaines de vos images sont actuellement examinées et apparaîtront sur [http://fr.wikia.com fr.wikia.com] après qu\'elles auront été approuvées. Cela peut prendre entre 2 et 4 jours ouvrés, aussi nous vous tiendrons informé ici quand ce sera fait.',
	'promote-statusbar-approved' => 'Super ! $1 est promu sur [http://fr.wikia.com fr.wikia.com]!',
	'promote-statusbar-rejected' => 'Une ou plusieurs de vos images n\'ont pas été approuvées. [[Special:Contact|Demander pourquoi]].',

	'promote-error-oasis-only' => 'Cette page n\'est pas supportée avec cette apparence. Veuillez [[Special:Preferences|passer à l\'apparence Wikia]] pour accéder à cette fonctionnalité.',

	//message included in auto-uploaded image's description fb#45624
	'wikiahome-image-auto-uploaded-comment' => 'Image générée automatiquement pour être utilisée sur http://fr.wikia.com/ &#8212; retrouvez plus d\'informations sur le blog dédié&nbsp;: http://communaute.wikia.com/wiki/Blog:Actualit%C3%A9_Wikia',
);

$messages['es'] = array(
	'promote' => 'Promocionar',

	'promote-title' => 'Promocionar',
	'promote-introduction-header' => '¡Promociona tu wiki en es.wikia.com!',

	'promote-introduction-copy' => "¡Esta página te permite promocionar tu wiki haciendo posible que aparezca en [http://es.wikia.com es.wikia.com]! Añade imágenes y un resumen para presentar tu wiki a los visitantes en la página principal de Wikia en español. Encuentra algunos consejos en [http://ayuda.wikia.com/wiki/Ayuda:Promocionar esta página]",

	'promote-description' => 'Descripción',
	'promote-description-header' => 'Encabezado',
	'promote-description-header-explanation' => '¡Algo tan simple como "Aprende más en el Wiki de los sombreros" o "Bienvenidos al wiki de los sombreros" suena bien!',

	'promote-description-about' => "¿Sobre qué trata tu wiki?",
	'promote-description-about-explanation' => "Escribe un resumen sobre el tema de tu wiki. No te preocupes por hacerla demasiado detallada, si quieres conseguir más visitantes tienes que asegurarte de que tengan una idea muy clara de todo lo que se trata en tu wiki.",

	'promote-upload' => 'Añadir imágenes',
	'promote-upload-main-photo-header' => 'Imagen principal',
	'promote-upload-main-photo-explanation' => "Esta imagen define tu wiki. Será la imagen principal que usaremos para representar tu wiki en es.wikia.com, ¡así que asegúrate de que sea la mejor! No olvides que siempre puedes actualizar la imagen para que sea más actual y represente mejor tu wiki.",
	'promote-upload-additional-photos-header' => 'Imágenes adicionales',
	'promote-upload-additional-photos-explanation' => 'Añadiendo más imágenes haces que tu wiki parezca más interesante y atraiga a visitantes potenciales. Puedes añadir hasta 9 imágenes desde aquí, y de hecho ¡te recomendamos que llegues al límite!',

	'promote-publish' => 'Publicar',

	'promote-add-photo' => 'Añadir una imagen',
	'promote-remove-photo' => 'Borrar',
	'promote-modify-photo' => 'Modificar',

	'promote-upload-main-image-form-modal-title' => 'Imagen principal',
	'promote-upload-main-image-form-modal-copy' => "Sube una imagen que represente el tema de tu wiki. Asegúrate de que sea un archivo \".png\" con un tamaño mínimo de 480x320.",
	'promote-upload-additional-image-form-modal-title' => 'Más imágenes',
	'promote-upload-additional-image-form-modal-copy' => "Sube imágenes adicionales para mostrar a la gente más cosas sobre tu wiki. Asegúrate de que las imágenes sean archivos \".png\" con un tamaño mínimo de 480x320.",
	'promote-upload-form-modal-cancel' => 'Cancelar',

	'promote-upload-submit-button' => 'Adelante',

	'promote-error-less-characters-than-minimum' => '¡Diantres! Tu texto necesita al menos $2 caracteres.',
	'promote-error-more-characters-than-maximum' => '¡Casi! Tu texto tiene que ser de $2 caracteres o menos.',
	'promote-error-upload-unknown-error' => 'Error de subida desconocido',
	'promote-error-upload-filetype-error' => 'Asegúrate de que el archivo se guarda como ".png".',
	'promote-error-upload-dimensions-error' => 'Dimensiones del archivo incorrectas - el archivo debe ser al menos de 480x320px',
	'promote-error-too-many-images' => '¡Eh! Ya tienes 9 imágenes. Borra alguna si quieres añadir una nueva.',
	'promote-error-upload-type' => "¡Rayos! El tipo de subida es incorrecto.",
	'promote-error-upload-form' => "Tipo de subida incorrecta en getUploadForm.",

	'promote-manual-file-size-error' => 'La imagen principal tiene un tamaño mínimo de 480x320px.',
	'promote-manual-upload-error' => 'Este archivo no puede ser subido manualmente. Por favor, usa la Herramienta de subida para administradores.',
	'promote-wrong-rights' => "¡Maldición! Parece que no tienes permiso para acceder a esta página. ¡Asegúrate de que estás identificado!",

	'promote-image-rejected' => 'Rechazada',
	'promote-image-accepted' => 'Aceptada',
	'promote-image-in-review' => 'En revisión',

	'promote-statusbar-icon' => 'Estado',
	'promote-statusbar-inreview' => 'Algunas de tus imágenes están actualmente bajo revisión y aparecerán en [http://es.wikia.com es.wikia.com] una vez se aprueben. Normalmente esto puede llevar unos 2 o 4 días laborables, así que te mantendremos informado por aquí cuando lo hayamos hecho.',
	'promote-statusbar-approved' => '¡Yuju! $1 se está promocionando en [http://es.wikia.com es.wikia.com]!',
	'promote-statusbar-rejected' => 'Una o más de tus imágenes no fue aprobada. [[Special:Contact|Pregunta por qué]].',

	//message included in auto-uploaded image's description fb#45624
	'wikiahome-image-auto-uploaded-comment' => 'Imagen generada automáticamente para ser usada en http://es.wikia.com/ – estate atento al blog del Staff para más información: http://comunidad.wikia.com/wiki/Blog:Noticias_de_Wikia',
);

$messages['es'] = array(
	'promote' => 'Promocionar',

	'promote-title' => 'Promocionar',
	'promote-introduction-header' => '¡Promociona tu wiki en es.wikia.com!',

	'promote-introduction-copy' => "¡Esta página te permite promocionar tu wiki haciendo posible que aparezca en [http://es.wikia.com es.wikia.com]! Añade imágenes y un resumen para presentar tu wiki a los visitantes en la página principal de Wikia en español. Encuentra algunos consejos en [http://ayuda.wikia.com/wiki/Ayuda:Promocionar esta página]",

	'promote-description' => 'Descripción',
	'promote-description-header' => 'Encabezado',
	'promote-description-header-explanation' => '¡Algo tan simple como "Aprende más en el Wiki de los sombreros" o "Bienvenidos al wiki de los sombreros" suena bien!',

	'promote-description-about' => "¿Sobre qué trata tu wiki?",
	'promote-description-about-explanation' => "Escribe un resumen sobre el tema de tu wiki. No te preocupes por hacerla demasiado detallada, si quieres conseguir más visitantes tienes que asegurarte de que tengan una idea muy clara de todo lo que se trata en tu wiki.",

	'promote-upload' => 'Añadir imágenes',
	'promote-upload-main-photo-header' => 'Imagen principal',
	'promote-upload-main-photo-explanation' => "Esta imagen define tu wiki. Será la imagen principal que usaremos para representar tu wiki en es.wikia.com, ¡así que asegúrate de que sea la mejor! No olvides que siempre puedes actualizar la imagen para que sea más actual y represente mejor tu wiki.",
	'promote-upload-additional-photos-header' => 'Imágenes adicionales',
	'promote-upload-additional-photos-explanation' => 'Añadiendo más imágenes haces que tu wiki parezca más interesante y atraiga a visitantes potenciales. Puedes añadir hasta 9 imágenes desde aquí, y de hecho ¡te recomendamos que llegues al límite!',

	'promote-publish' => 'Publicar',

	'promote-add-photo' => 'Añadir una imagen',
	'promote-remove-photo' => 'Borrar',
	'promote-modify-photo' => 'Modificar',

	'promote-upload-main-image-form-modal-title' => 'Imagen principal',
	'promote-upload-main-image-form-modal-copy' => "Sube una imagen que represente el tema de tu wiki. Asegúrate de que sea un archivo \".png\" con un tamaño mínimo de 480x320.",
	'promote-upload-additional-image-form-modal-title' => 'Más imágenes',
	'promote-upload-additional-image-form-modal-copy' => "Sube imágenes adicionales para mostrar a la gente más cosas sobre tu wiki. Asegúrate de que las imágenes sean archivos \".png\" con un tamaño mínimo de 480x320.",
	'promote-upload-form-modal-cancel' => 'Cancelar',

	'promote-upload-submit-button' => 'Adelante',

	'promote-error-less-characters-than-minimum' => '¡Diantres! Tu texto necesita al menos $2 caracteres.',
	'promote-error-more-characters-than-maximum' => '¡Casi! Tu texto tiene que ser de $2 caracteres o menos.',
	'promote-error-upload-unknown-error' => 'Error de subida desconocido',
	'promote-error-upload-filetype-error' => 'Asegúrate de que el archivo se guarda como ".png".',
	'promote-error-upload-dimensions-error' => 'Dimensiones del archivo incorrectas - el archivo debe ser al menos de 480x320px',
	'promote-error-too-many-images' => '¡Eh! Ya tienes 9 imágenes. Borra alguna si quieres añadir una nueva.',
	'promote-error-upload-type' => "¡Rayos! El tipo de subida es incorrecto.",
	'promote-error-upload-form' => "Tipo de subida incorrecta en getUploadForm.",

	'promote-manual-file-size-error' => 'La imagen principal tiene un tamaño mínimo de 480x320px.',
	'promote-manual-upload-error' => 'Este archivo no puede ser subido manualmente. Por favor, usa la Herramienta de subida para administradores.',
	'promote-wrong-rights' => "¡Maldición! Parece que no tienes permiso para acceder a esta página. ¡Asegúrate de que estás identificado!",

	'promote-image-rejected' => 'Rechazada',
	'promote-image-accepted' => 'Aceptada',
	'promote-image-in-review' => 'En revisión',

	'promote-statusbar-icon' => 'Estado',
	'promote-statusbar-inreview' => 'Algunas de tus imágenes están actualmente bajo revisión y aparecerán en [http://es.wikia.com es.wikia.com] una vez se aprueben. Normalmente esto puede llevar unos 2 o 4 días laborables, así que te mantendremos informado por aquí cuando lo hayamos hecho.',
	'promote-statusbar-approved' => '¡Yuju! $1 se está promocionando en [http://es.wikia.com es.wikia.com]!',
	'promote-statusbar-rejected' => 'Una o más de tus imágenes no fue aprobada. [[Special:Contact|Pregunta por qué]].',
);

$messages['ja'] = array(
	'promote' => 'プロモート',
);

$messages['pl'] = array(
	'promote' => 'Promocja',
	'promote-title' => 'Promocja',
	'promote-introduction-header' => 'Wypromuj swoją wiki na pl.wikia.com',
	'promote-nocorp-introduction-header' => 'Wypromuj $1',
	'promote-introduction-copy' => 'Wypromuj swoją wiki na [http://www.pl.wikia.com pl.wikia.com] uzupełniając dane na tej stronie. Dodaj obrazy i opis, aby przedstawić swoją wiki odwiedzającym. Więcej wskazówek znajdziesz [http://spolecznosc.wikia.com/wiki/Pomoc:Specjalna:Promocja tutaj]. ',
	'promote-nocorp-introduction-copy' => 'Dodaj obrazy i opis, aby przedstawić swoją wiki odwiedzającym. Podanych przez Ciebie informacji użyjemy, aby wypromować Twoją wiki w wynikach wyszukiwania, aplikacjach mobilnych i innych. Więcej wskazówek jak najefektywniej użyć narzędzia znajdziesz [http://spolecznosc.wikia.com/wiki/Pomoc:Specjalna:Promocja tutaj].',
	'promote-description' => 'Opis',
	'promote-description-header' => 'Nagłówek',
	'promote-description-header-explanation' => 'Idealne będzie coś tak nieskomplikowanego jak np. "Dowiedz się więcej o Bacon Wiki" bądź "Witaj na Bacon Wiki"!',
	'promote-description-about' => 'O czym jest Twoja wiki?',
	'promote-description-about-explanation' => 'Napisz na jaki temat jest Twoja wiki. Nie bój się szczegółowych opisów! Chodzi przecież o to, aby zainteresować użytkowników Twoją wiki i aby mieć pewność, że dokładnie wiedzą o czym ona jest.',
	'promote-upload' => 'Dodaj obrazy',
	'promote-upload-main-photo-header' => 'Obraz główny',
	'promote-upload-main-photo-explanation' => 'Ten obraz opisuje Twoją wiki, jest jej wizytówką. Będzie reprezentował Twoją wiki na pl.wikia.com, więc postaraj się, aby był wyjątkowy! Pamiętaj, że w każdej chwili możesz zmienić ten obraz, tak aby zawsze oddawał charakter Twojej wiki.',
	'promote-nocorp-upload-main-photo-explanation' => 'Ten obraz opisuje Twoją wiki, jest jej wizytówką. Będzie reprezentował Twoją wiki w wynikach wyszukiwania, aplikacjach mobilnych i innych, więc postaraj się aby był wyjątkowy! Pamiętaj, że w każdej chwili możesz go zmienić.',
	'promote-upload-additional-photos-header' => 'Dodatkowe obrazy',
	'promote-upload-additional-photos-explanation' => 'Im więcej obrazów dodasz do swojej wikii, tym będzie bardziej interesująca dla innych użytkowników. Maksymalna ilość zdjęć, którą możesz dodać to 9. Gorąco zachęcamy do wyczerpywania limitów!',
	'promote-upload-form-modal-cancel' => 'Anuluj',
	'promote-publish' => 'Publikuj',
	'promote-add-photo' => 'Dodaj obraz',
	'promote-remove-photo' => 'Usuń',
	'promote-modify-photo' => 'Modyfikuj',
	'promote-upload-main-image-form-modal-title' => 'Obraz główny',
	'promote-upload-main-image-form-modal-copy' => 'Dodaj obraz, który najlepiej reprezentuje Twoją wiki. Dozwolony format pliku to ".png", a minimalne wymiary to 480x320px.',
	'promote-upload-additional-image-form-modal-title' => 'Więcej obrazów',
	'promote-upload-additional-image-form-modal-copy' => 'Dodaj więcej obrazów, aby bardziej szczegółowo opowiedzieć o swojej wiki. Dozwolony format pliku to ".png", a minimalna wielkość to 480x320px.',
	'promote-upload-submit-button' => 'Prześlij',
	'promote-error-less-characters-than-minimum' => 'Ups! Wpisany tekst musi mieć minimum $2 znaków.',
	'promote-error-more-characters-than-maximum' => 'Ups! Wpisany tekst musi mieć maksimum $2 znaków',
	'promote-error-upload-unknown-error' => 'Nieznany błąd podczas przesyłania pliku',
	'promote-error-upload-filetype-error' => 'Wymagany format pliku to ".png"',
	'promote-error-upload-dimensions-error' => 'Niepoprawne wymiary pliku - obraz musi być nie mniejszy niż 480x320px',
	'promote-error-too-many-images' => 'Ups! Dodałeś już 9 obrazów. Jeśli chcesz dodać ten obraz, usuń któryś z dotychczas dodanych',
	'promote-error-upload-type' => 'Ups! Niepoprawny typ wysyłania pliku',
	'promote-error-upload-form' => 'Niepoprawny typ wysyłania pliku w getUploadForm',
	'promote-manual-file-size-error' => 'Minimalne wymiary obrazu głównego to 480x320px',
	'promote-manual-upload-error' => 'Ten plik nie może zostać dodany ręcznie. W tym celu użyj narzędzia dla administratorów do wysyłania plików',
	'promote-wrong-rights' => 'Wygląda na to, że nie masz praw aby wejść na tę stronę. Upewnij się, że jesteś zalogowany',
	'promote-image-rejected' => 'Odrzucone',
	'promote-image-accepted' => 'Zaakceptowane',
	'promote-image-in-review' => 'Rozpatrywane',
	'promote-statusbar-auto-approved' => 'Woohoo! $1 jest promowana!',
	'promote-statusbar-icon' => 'Status',
	'promote-statusbar-inreview' => 'Niektóre z przesłanych obrazów są w trakcie przeglądania i zostaną opublikowane na [http://pl.www.wikia.com pl.wikia.com], kiedy przejdą pomyślnie weryfikację. Może to zająć od 2 do 4 dni roboczych. Poinformujemy Cię kiedy proces zostanie zakończony.',
	'promote-statusbar-approved' => 'Woohoo! $1 jest już promowana na [http://pl.www.wikia.com pl.wikia.com]!',
	'promote-statusbar-rejected' => 'Jeden lub więcej dodanych przez Ciebie obrazów nie przeszło weryfikacji pomyślnie. [[Special:Contact|Dowiedz się dlaczego]]',
	'promote-error-oasis-only' => 'Ta strona nie jest dostępna w wybranej skórce. Zmień ją [[Special:Preferences|na skórkę "Wikia" w preferencjach,]] aby uzyskać dostęp.',

	'promote-upload-image-uploads-disabled' => 'Dodawanie plików jest czasowo wyłączone na Twojej wiki. Spróbuj ponownie za jakiś czas.',
);

$messages['pt'] = array(
	'promote' => 'Promover',
);

$messages['qqq'] = array(
	'promote-desc' => '{{desc}}',
	'promote' => 'Promote page heading',

	'promote-title' => 'Promote page title',
	'promote-introduction-header' => 'Promote page header inviting admin to promote his/her wiki on corporate wiki',
	'promote-nocorp-introduction-header' => 'Promote page header inviting admin to promote his/her wiki [not on corporate wikis]. This message is displayed when there is no corp wiki in wikis content lang.',
	'promote-introduction-copy' => 'Promote page explanatory copy and invitation to fill in wiki data that will be used to promote wiki on corporate wiki',
	'promote-nocorp-introduction-copy' => 'Promote page explanatory copy and invitation to fill in wiki data that will be used to promote wiki [not on corporate wikis]. This message is displayed when there is no corp wiki in wikis content lang.',

	'promote-description' => 'Title inviting to describe the wiki',
	'promote-description-header' => 'Label for wiki headline input field',
	'promote-description-header-explanation' => 'Explanatory text for headline input field',

	'promote-description-about' => 'Label for wiki description text input field',
	'promote-description-about-explanation' => 'Explanatory text for wiki description input field',

	'promote-upload' => 'Title inviting to add images',
	'promote-upload-main-photo-header' => 'Label for main wiki image',
	'promote-upload-main-photo-explanation' => 'Explanatory text for main wiki image.',
	'promote-nocorp-upload-main-photo-explanation' => 'Explanatory text for main wiki image. This message is displayed when there is no corp wiki in wikis content lang.',
	'promote-upload-additional-photos-header' => 'Label for additional images section',
	'promote-upload-additional-photos-explanation' => 'Explanatory text for additional optional images section',
	'promote-upload-form-modal-cancel' => 'Cancel (close) image upload modal',

	'promote-publish' => 'Label for publish button',

	'promote-add-photo' => 'Label for add a photo button',
	'promote-remove-photo' => 'Label for image removal',
	'promote-modify-photo' => 'Label for image modification',

	'promote-upload-main-image-form-modal-title' => 'Headline for Main Image upload modal',
	'promote-upload-main-image-form-modal-copy' => 'Explanatory text for Main Image upload',
	'promote-upload-additional-image-form-modal-title' => 'Headline for Additional Images upload modal',
	'promote-upload-additional-image-form-modal-copy' => 'Explanatory text for Additional Images upload',

	'promote-upload-submit-button' => 'Submit button text',

	'promote-error-less-characters-than-minimum' => 'Information about lower than minimal ($2) number of entered characters ($1)',
	'promote-error-more-characters-than-maximum' => 'Information about higher than maximal ($2) number of entered characters ($1)',
	'promote-error-upload-unknown-error' => 'Information about unknown upload error',
	'promote-error-upload-filetype-error' => 'Information about wrong file type',
	'promote-error-upload-dimensions-error' => 'Information about wrong file dimensions error',
	'promote-error-too-many-images' => 'Information about exceeding maxim number of additional images',
	'promote-error-upload-type' => 'Information about wrong file upload type passed to form (internal error)',
	'promote-error-upload-form' => 'Information about wrong file upload type passed in upload request (internal error)',
	'promote-error-oasis-only' => 'Message that informs user that Promote tool is only available on oasis skin',

	'promote-manual-file-size-error' => 'Information about minimum main image size',
	'promote-manual-upload-error' => 'Information about the restriction to upload visualization images by means other than Admin Upload Tool',
	'promote-wrong-rights' => 'Information about lost session / lack of permissions to this extension',

	'promote-image-rejected' => 'Information about image rejection',
	'promote-image-accepted' => 'Information about image approval',
	'promote-image-in-review' => 'Information about image being in review',
	'promote-statusbar-auto-approved' => 'Information about image auto approval - when there is no corporate wiki in that language',

	'promote-statusbar-icon' => 'Text on the status icon at the top of the special:promote page',
	'promote-statusbar-inreview' => 'Status information when wiki is in review',
	'promote-statusbar-approved' => 'Status information when wiki is in approved',
	'promote-statusbar-rejected' => 'Status information when wiki is in rejected',

	'promote-upload-image-uploads-disabled' => 'Information to the user that file uploading is temporarily disabled',

	'promote-extension-under-rework-header' => 'Page title stating that Special:Promote is disabled',
	'promote-extension-under-rework' => 'Information displayed to sysops and bureaucrats that the Special:Promote page has been disabled for maintenance, new feature to replace it is being worked on and will be announced soon. Includes call to action to use [[Special:Contact]] in case of questions.'
);
