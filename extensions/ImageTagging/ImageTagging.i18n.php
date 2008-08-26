<?php
/**
 * Internationalisation file for ImageTagging extension.
 *
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Tomasz Klim
 * @author Tristan Harris
 */
$messages['en'] = array(
	'taggedimages'                          => 'Tagged images',
	'imagetagging-desc'                     => 'Lets a user select regions of an embedded image and associate a page with that region',
	'imagetagging-addimagetag'              => 'Tag this image',
	'imagetagging-article'                  => 'Page:',
	'imagetagging-articletotag'             => 'Page to tag',
	'imagetagging-canteditothermessage'		=> 'You cannot edit this page, either because you do not have the rights to do so or because the page is locked down for other reasons.',
	'imagetagging-imghistory'               => 'History',
	'imagetagging-images'                   => 'images',
	'imagetagging-inthisimage'              => 'In this image: $1',
	'imagetagging-logentry'                 => 'Removed tag to page [[$1]] by $2',
	'imagetagging-log-tagged'               => 'Image [[$1|$2]] was tagged to page [[$3]] by $4',
	'imagetagging-new'                      => '<sup><span style="color:red">New!</span></sup>',
	'imagetagging-removetag'                => 'remove tag',
	'imagetagging-done-button'              => 'Done tagging',
	'imagetagging-tag-button'               => 'Tag',
	'imagetagging-tagcancel-button'         => 'Cancel',
	'imagetagging-tagging-instructions'     => 'Click on people or things in the image to tag them.',
	'imagetagging-addingtag'                => 'Adding tag…',
	'imagetagging-removingtag'              => 'Removing tag…',
	'imagetagging-addtagsuccess'            => 'Added tag.',
	'imagetagging-removetagsuccess'         => 'Removed tag.',
	'imagetagging-canteditneedloginmessage' => 'You cannot edit this page.
It may be because you need to login to tag images.
Do you want to login now?',
	'imagetagging-oneactionatatimemessage'  => 'Only one tagging action at a time is allowed.
Please wait for the existing action to complete.',
	'imagetagging-oneuniquetagmessage'      => 'This image already has a tag with this name.',
	'imagetagging-imagetag-seemoreimages'   => 'See more images of "$1" ($2)',
	'imagetagging-taggedimages-title'       => 'Images of "$1"',
	'imagetagging-taggedimages-displaying'  => 'Displaying $1 - $2 of $3 images of "$4"',
	'tag-logpagename'						=> 'Tagging log',
	'tag-logpagetext'						=> 'This is a log of all image tag additions and removals.',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'imagetagging-tagcancel-button' => "Mao'ạki",
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'imagetagging-article'          => 'Лаштык:',
	'imagetagging-tagcancel-button' => 'Чараш',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'imagetagging-imghistory'       => 'Liu onoono atu ki tua',
	'imagetagging-tagcancel-button' => 'Tiaki',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 */
$messages['af'] = array(
	'imagetagging-imghistory' => 'Geskiedenis',
);

/** Arabic (العربية)
 * @author OsamaK
 * @author Meno25
 */
$messages['ar'] = array(
	'taggedimages'                          => 'صور موسومة',
	'imagetagging-addimagetag'              => 'وسم هذه الصورة',
	'imagetagging-article'                  => 'صفحة:',
	'imagetagging-articletotag'             => 'صفحة للوسم',
	'imagetagging-canteditothermessage'     => 'أنت لا يمكنك تعديل هذه الصفحة، إما لأنك لا تمتلك الصلاحية لفعل هذا أو لأن الصفحة محمية لأسباب أخرى.',
	'imagetagging-imghistory'               => 'تاريخ',
	'imagetagging-images'                   => 'صور',
	'imagetagging-inthisimage'              => 'في هذه الصورة: $1',
	'imagetagging-logentry'                 => 'أزال الوسم للصفحة [[$1]] بواسطة $2',
	'imagetagging-new'                      => '<sup><span style="color:red">جديد!</span></sup>',
	'imagetagging-removetag'                => 'إزالة وسم',
	'imagetagging-done-button'              => 'إنتهى الوسم',
	'imagetagging-tag-button'               => 'وسم',
	'imagetagging-tagcancel-button'         => 'إلغاء',
	'imagetagging-tagging-instructions'     => 'اضغط على الأشخاص أو الأشياء في الصورة لوسمهم.',
	'imagetagging-addingtag'                => 'إضافة وسم...',
	'imagetagging-removingtag'              => 'إزالة وسم...',
	'imagetagging-addtagsuccess'            => 'أُضيف الوسم.',
	'imagetagging-removetagsuccess'         => 'أُزيل الوسم.',
	'imagetagging-canteditneedloginmessage' => 'أنت لا يمكنك تعديل هذه الصفحة.
ربما يكون ذلك بسبب أنك تحتاج إلى تسجيل الدخول لوسم الصور.
هل تريد تسجيل الدخول الآن؟',
	'imagetagging-oneactionatatimemessage'  => 'فقط فعل وسم واحد مسموح به كل مرة.
من فضلك انتظر الفعل الموجود ليكتمل.',
	'imagetagging-oneuniquetagmessage'      => 'هذه الصورة لديها بالفعل وسم بهذا الاسم.',
	'imagetagging-imagetag-seemoreimages'   => 'راجع المزيد من صور "$1" ($2)',
	'imagetagging-taggedimages-title'       => 'صور "$1"',
	'imagetagging-taggedimages-displaying'  => 'عرض $1 - $2 من $3 صورة ل"$4"',
	'tag-logpagename'                       => 'سجل الوسم',
	'tag-logpagetext'                       => 'هذا سجل بكل عمليات إضافة وإزالة وسم الصور.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'imagetagging-article'          => 'Страница:',
	'imagetagging-imghistory'       => 'История',
	'imagetagging-tagcancel-button' => 'Отказване',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'taggedimages'                         => 'Označené obrázky',
	'imagetagging-desc'                    => 'Umožňuje uživatelům vybrat oblasti vloženého obrázku a k dané oblasti přiřadti stránku.',
	'imagetagging-addimagetag'             => 'Označit tento obrázek',
	'imagetagging-article'                 => 'Stránka:',
	'imagetagging-articletotag'            => 'Označit stránku:',
	'imagetagging-imghistory'              => 'Historie',
	'imagetagging-images'                  => 'obrázky',
	'imagetagging-inthisimage'             => 'V tomto obrázku: $1',
	'imagetagging-logentry'                => '$2 odstranil značku na stránku [[$1]]',
	'imagetagging-log-tagged'              => '$4 označil obrázek [[$1|$2]] na stránku [[$3]]',
	'imagetagging-new'                     => '<sup><span style="color: red;">Nové!</span></sup>',
	'imagetagging-removetag'               => 'odstranit značku',
	'imagetagging-done-button'             => 'Ukončit označování',
	'imagetagging-tag-button'              => 'Značka',
	'imagetagging-tagcancel-button'        => 'Zrušit',
	'imagetagging-tagging-instructions'    => 'Kliknutím na ludi nebo věci na obrázku je můžete označit.',
	'imagetagging-addingtag'               => 'Přidává se značka…',
	'imagetagging-removingtag'             => 'Odstraňuje se značka…',
	'imagetagging-addtagsuccess'           => 'Přidána značka.',
	'imagetagging-removetagsuccess'        => 'Odstraněna značka.',
	'imagetagging-oneuniquetagmessage'     => 'Tento obrázek už má značku s takovým názvem.',
	'imagetagging-imagetag-seemoreimages'  => 'Zobrazit více obrázků „$1” ($2)',
	'imagetagging-taggedimages-title'      => 'Obrázky „$1”',
	'imagetagging-taggedimages-displaying' => 'Zobrazuje se $1 - $2 z $3 obrázků „$4”',
);

/** German (Deutsch)
 * @author DaSch
 */
$messages['de'] = array(
	'taggedimages'                      => 'Bilder mit Tags',
	'imagetagging-addimagetag'          => 'Tags hinzufügen',
	'imagetagging-article'              => 'Seite:',
	'imagetagging-imghistory'           => 'Versionen',
	'imagetagging-images'               => 'Bild',
	'imagetagging-log-tagged'           => 'Bild [[$1|$2]] wurde von $4 mit [[$3]] getagged',
	'imagetagging-new'                  => '<sup><span style="color:red">Neu!</span></sup>',
	'imagetagging-removetag'            => 'Tag entfernen',
	'imagetagging-done-button'          => 'Tagging erledigt',
	'imagetagging-tagcancel-button'     => 'Abbrechen',
	'imagetagging-tagging-instructions' => 'Klick auf Personen oder Dinge in dem Bild um sie mit einem Tag zu versehen.',
	'imagetagging-addingtag'            => 'Füge Tag hinzu…',
	'imagetagging-removingtag'          => 'Entferne Tag…',
	'imagetagging-addtagsuccess'        => 'Hinzugefügte Tags.',
	'imagetagging-removetagsuccess'     => 'Entfernte Tags.',
	'imagetagging-oneuniquetagmessage'  => 'Dieses Bild hat bereits einen Tag mit diesem Namen.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'imagetagging-addimagetag'        => 'Marki ĉi tiun bildon',
	'imagetagging-article'            => 'Paĝo',
	'imagetagging-articletotag'       => 'Paĝo por marki',
	'imagetagging-imghistory'         => 'Historio',
	'imagetagging-images'             => 'bildoj',
	'imagetagging-inthisimage'        => 'En ĉi tiu bildo: $1',
	'imagetagging-removetag'          => 'forigi etikedon',
	'imagetagging-tagcancel-button'   => 'Nuligi',
	'imagetagging-removingtag'        => 'Forigante markon...',
	'imagetagging-taggedimages-title' => 'Bildoj de "$1"',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'taggedimages'                          => 'Merkityt kuvat',
	'imagetagging-addimagetag'              => 'Merkitse tämä kuva',
	'imagetagging-article'                  => 'Sivu:',
	'imagetagging-canteditothermessage'     => 'Et voi muokata tätä sivua, joko koska sinulla ei ole oikeuksia tai koska sivu on lukittu muista syistä.',
	'imagetagging-imghistory'               => 'Historia',
	'imagetagging-images'                   => 'kuvat',
	'imagetagging-inthisimage'              => 'Tässä kuvassa: $1',
	'imagetagging-logentry'                 => 'Poistettiin merkintä sivulle [[$1]] käyttäjän $2 toimesta',
	'imagetagging-log-tagged'               => 'Kuva [[$1|$2]] merkittiin sivulle [[$3]] käyttäjän $4 toimesta',
	'imagetagging-new'                      => '<sup><span style="color:red">Uusi!</span></sup>',
	'imagetagging-removetag'                => 'poista merkintä',
	'imagetagging-done-button'              => 'Valmis',
	'imagetagging-tag-button'               => 'Jatka',
	'imagetagging-tagcancel-button'         => 'Peruuta',
	'imagetagging-tagging-instructions'     => 'Napsauta ihmisiä tai asioita kuvassa merkitäksesi ne.',
	'imagetagging-addingtag'                => 'Lisätään merkintää…',
	'imagetagging-removingtag'              => 'Poistetaan merkintää…',
	'imagetagging-addtagsuccess'            => 'Merkintä lisätty.',
	'imagetagging-removetagsuccess'         => 'Merkintä poistettu.',
	'imagetagging-canteditneedloginmessage' => 'Et voi muokata tätä sivua.
Se saattaa johtua siitä, että sinun tulee kirjautua sisään merkitäksesi kuvia.
Haluatko kirjautua sisään nyt?',
	'imagetagging-oneactionatatimemessage'  => 'Vain yksi merkitsemistapahtuma kerrallaan on sallittu.
Ole hyvä ja odota olemassaolevan tapahtuman päättymistä.',
	'imagetagging-oneuniquetagmessage'      => 'Tällä kuvalla on jo samanniminen merkintä.',
	'imagetagging-imagetag-seemoreimages'   => 'Katso lisää kuvia aiheesta "$1" ($2)',
	'imagetagging-taggedimages-title'       => 'Kuvia aiheesta "$1"',
	'imagetagging-taggedimages-displaying'  => 'Näytetään $1 - $2 kuvaa aiheesta "$4"; yhteensä $3 kuvaa',
	'tag-logpagename'                       => 'Merkintäloki',
	'tag-logpagetext'                       => 'Tämä on loki kaikista kuvien merkinnöistä ja merkintöjen poistoista.',
);

/** French (Français)
 * @author Grondin
 * @author Verdy p
 * @author Cedric31
 */
$messages['fr'] = array(
	'taggedimages'                          => 'Images balisées',
	'imagetagging-desc'                     => "Permet à un utilisateur de sélectionner les régions d’une image incrustée pour l'associer à une page.",
	'imagetagging-addimagetag'              => 'Baliser cette image',
	'imagetagging-article'                  => 'Page :',
	'imagetagging-articletotag'             => 'Page à baliser',
	'imagetagging-canteditothermessage'     => 'Vous ne pouvez pas modifier cette page, soit parce que vous n’en disposez pas des droits nécessaire soit parce que la page est verrouillée pour diverses raisons.',
	'imagetagging-imghistory'               => 'Historique',
	'imagetagging-images'                   => 'images',
	'imagetagging-inthisimage'              => 'Dans cette image : $1',
	'imagetagging-logentry'                 => 'Balise retirée de la page [[$1]] par $2',
	'imagetagging-log-tagged'               => "L'image [[$1|$2]] a été balisée pour la page [[$3]] par $4",
	'imagetagging-new'                      => '<sup><span style="color:red">Nouveau !</span></sup>',
	'imagetagging-removetag'                => 'retirer la balise',
	'imagetagging-done-button'              => 'Balisage effectué',
	'imagetagging-tag-button'               => 'Balise',
	'imagetagging-tagcancel-button'         => 'Annuler',
	'imagetagging-tagging-instructions'     => 'Cliquer sur les personnes ou les choses dans l’image pour les baliser.',
	'imagetagging-addingtag'                => 'Balise en cours d’ajout…',
	'imagetagging-removingtag'              => 'Balise en cours de retrait…',
	'imagetagging-addtagsuccess'            => 'Balise ajoutée.',
	'imagetagging-removetagsuccess'         => 'Balise retirée.',
	'imagetagging-canteditneedloginmessage' => 'Vous ne pouvez pas modifier cette page.
Il se peut que vous deviez d’abord vous connecter pour baliser les images.
Voulez-vous vous connecter maintenant ?',
	'imagetagging-oneactionatatimemessage'  => 'Une seule action de balisage est permise à la fois.
Veuillez attendre la fin de l’action en cours.',
	'imagetagging-oneuniquetagmessage'      => 'Cette image a déjà une balise avec ce nom.',
	'imagetagging-imagetag-seemoreimages'   => 'Voir plus d’images de « $1 » ($2)',
	'imagetagging-taggedimages-title'       => 'Images de « $1 »',
	'imagetagging-taggedimages-displaying'  => 'Affichage des images $1 – $2 sur $3 de « $4 »',
	'tag-logpagename'                       => 'Balisage du journal',
	'tag-logpagetext'                       => 'Ceci est le journal de tous les ajouts et de toutes les suppressions des balises d’image.',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'imagetagging-article' => 'Side:',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'taggedimages'                          => 'Imaxes con etiquetas',
	'imagetagging-desc'                     => 'Deixa que un usuario seleccione as rexións dunha imaxe embebida e asociar unha páxina con esa rexión',
	'imagetagging-addimagetag'              => 'Pór unha etiqueta a esta imaxe',
	'imagetagging-article'                  => 'Páxina:',
	'imagetagging-articletotag'             => 'Páxinar para pór a etiqueta',
	'imagetagging-canteditothermessage'     => 'Non pode editar esta páxina. Se ben pode ser porque non ten os permisos para facelo ou porque a páxina está protexida por outras razóns.',
	'imagetagging-imghistory'               => 'Historial',
	'imagetagging-images'                   => 'imaxes',
	'imagetagging-inthisimage'              => 'Nesta imaxe: $1',
	'imagetagging-logentry'                 => 'Eliminouse a etiqueta da páxina [[$1]] por $2',
	'imagetagging-log-tagged'               => 'A etiqueta da imaxe [[$1|$2]] para a páxina [[$3]] foi posta por $4',
	'imagetagging-new'                      => '<sup><span style="color:red">Novo!</span></sup>',
	'imagetagging-removetag'                => 'eliminar a etiqueta',
	'imagetagging-done-button'              => 'A etiqueta foi posta',
	'imagetagging-tag-button'               => 'Pór a etiqueta',
	'imagetagging-tagcancel-button'         => 'Cancelar',
	'imagetagging-tagging-instructions'     => 'Faga clic sobre a xente ou as cousas da imaxe para pórlles a etiqueta.',
	'imagetagging-addingtag'                => 'Engadindo a etiqueta…',
	'imagetagging-removingtag'              => 'Eliminando a etiqueta…',
	'imagetagging-addtagsuccess'            => 'A etiqueta foi engadida.',
	'imagetagging-removetagsuccess'         => 'A etiqueta foi eliminada.',
	'imagetagging-canteditneedloginmessage' => 'Non pode editar esta páxina.
Pode ser porque precise acceder ao sistema para pór etiquetas ás imaxes.
Desexa acceder ao sistema agora?',
	'imagetagging-oneactionatatimemessage'  => 'Só se lle está permitido realizar unha acción á vez.
Por favor, agarde a que a acción actual remate.',
	'imagetagging-oneuniquetagmessage'      => 'Esta imaxe xa ten unha etiqueta con ese nome.',
	'imagetagging-imagetag-seemoreimages'   => 'Ver máis imaxes de "$1" ($2)',
	'imagetagging-taggedimages-title'       => 'Imaxes de "$1"',
	'imagetagging-taggedimages-displaying'  => 'Amosando da $1 á $2, dun total de $3 imaxes de "$4"',
	'tag-logpagename'                       => 'Rexistro de etiquetas',
	'tag-logpagetext'                       => 'Este é un rexitro de todas as incorporacións e eliminacións de etiquetas de imaxe.',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'imagetagging-article'    => '‘Ao‘ao:',
	'imagetagging-imghistory' => 'Mo‘olelo',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'imagetagging-imghistory'       => 'Versi',
	'imagetagging-tagcancel-button' => 'Batalkan',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 */
$messages['km'] = array(
	'imagetagging-imghistory'       => 'ប្រវត្តិ',
	'imagetagging-images'           => 'រូបភាព',
	'imagetagging-inthisimage'      => 'ក្នុងរូបភាពនេះ: $1',
	'imagetagging-tagcancel-button' => 'បោះបង់',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'imagetagging-tagcancel-button' => 'Draanjevve',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'imagetagging-article'                 => 'Säit:',
	'imagetagging-imghistory'              => 'Versiounen',
	'imagetagging-images'                  => 'Biller',
	'imagetagging-inthisimage'             => 'Op dësem Bild: $1',
	'imagetagging-tagcancel-button'        => 'Zréck',
	'imagetagging-imagetag-seemoreimages'  => 'Kuckt méi Biller vu(n) "$1" ($2)',
	'imagetagging-taggedimages-title'      => 'Biller vun "$1"',
	'imagetagging-taggedimages-displaying' => 'Weis $1 - $2 vu(n) $3 Biller vu(n) "$4"',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'imagetagging-addimagetag'             => 'ഈ ചിത്രം ടാഗ് ചെയ്യുക',
	'imagetagging-article'                 => 'താള്‍:',
	'imagetagging-articletotag'            => 'ടാഗ് ചെയ്യാനുള്ള താള്‍',
	'imagetagging-imghistory'              => 'നാള്‍വഴി',
	'imagetagging-images'                  => 'ചിത്രങ്ങള്‍',
	'imagetagging-inthisimage'             => 'ഈ ചിത്രത്തില്‍: $1',
	'imagetagging-logentry'                => '[[$1]] എന്ന  താളിലെ ടാഗ്  $2 മാറ്റിയിരിക്കുന്നു',
	'imagetagging-log-tagged'              => '[[$1|$2]] എന്ന ചിത്രം [[$3]] എന്ന താളിലേക്ക്  $4 ടാഗ് ചെയ്തിരിക്കുന്നു',
	'imagetagging-removetag'               => 'ടാഗ് മാറ്റുക',
	'imagetagging-tag-button'              => 'ടാഗ്',
	'imagetagging-tagcancel-button'        => 'റദ്ദാക്കുക',
	'imagetagging-addingtag'               => 'ടാഗ് ചേര്‍ക്കുന്നു...',
	'imagetagging-removingtag'             => 'ടാഗ് ഒഴിവാക്കുന്നു...',
	'imagetagging-addtagsuccess'           => 'ടാഗ് ചേര്‍ത്തു.',
	'imagetagging-removetagsuccess'        => 'ടാഗ് ഒഴിവാക്കി.',
	'imagetagging-oneuniquetagmessage'     => 'ഈ ചിത്രത്തിനു ഈ പേരുള്ള ടാഗ് ഇപ്പോള്‍ തന്നെയുണ്ട്',
	'imagetagging-imagetag-seemoreimages'  => '"$1"ന്റെ കൂടുതല്‍ ചിത്രങ്ങള്‍ കാണുക ($2)',
	'imagetagging-taggedimages-title'      => '"$1"ന്റെ ചിത്രങ്ങള്‍',
	'imagetagging-taggedimages-displaying' => '"$4"ന്റെ  $3 ചിത്രങ്ങളില്‍  $1 - $2 വരെയുള്ള  പ്രദര്‍ശിപ്പിക്കുന്നു',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'taggedimages'                          => 'खूणा केलेली चित्रे',
	'imagetagging-desc'                     => 'एखाद्या सदस्याला चित्रातील क्षेत्रे निवडणे व त्या क्षेत्राला एखादे पान जोडण्याची अनुमती देते',
	'imagetagging-addimagetag'              => 'या चित्रावर खूण करा',
	'imagetagging-article'                  => 'पान:',
	'imagetagging-articletotag'             => 'खूण करण्यासाठीचे पान',
	'imagetagging-imghistory'               => 'इतिहास',
	'imagetagging-images'                   => 'चित्रे',
	'imagetagging-inthisimage'              => 'या चित्रामध्ये: $1',
	'imagetagging-logentry'                 => '$2 ने [[$1]] पानाची खूण काढली',
	'imagetagging-log-tagged'               => '$4 ने [[$1|$2]] या चित्राची खूण  [[$3]] या पानावर दिली',
	'imagetagging-new'                      => '<sup><span style="color:red">नवीन!</span></sup>',
	'imagetagging-removetag'                => 'खूण काढा',
	'imagetagging-done-button'              => 'खूण दिली',
	'imagetagging-tag-button'               => 'खूण',
	'imagetagging-tagcancel-button'         => 'रद्द करा',
	'imagetagging-tagging-instructions'     => 'या चित्रातील माणसे किंवा वस्तूंवर खूणा करण्यासाठी टिचकी द्या',
	'imagetagging-addingtag'                => 'खूण देत आहे...',
	'imagetagging-removingtag'              => 'खूण काढत आहे...',
	'imagetagging-addtagsuccess'            => 'खूण वाढविली.',
	'imagetagging-removetagsuccess'         => 'खूण काढली.',
	'imagetagging-canteditneedloginmessage' => 'तुम्ही हे पान संपादित करू शकत नाही.
कदाचित याचे कारण म्हणजे खूणा देण्यासाठी तुम्ही प्रवेश करणे आवश्यक असेल.
तुम्ही आता प्रवेश करू इच्छिता का?',
	'imagetagging-oneactionatatimemessage'  => 'एकावेळी एकच खूण देता येईल.
कृपया चालू असलेली क्रिया पूर्ण होईपर्यंत वाट पहा.',
	'imagetagging-oneuniquetagmessage'      => 'या चित्राला याच नावाची खूण अगोदरच दिलेली आहे.',
	'imagetagging-imagetag-seemoreimages'   => '"$1" ($2) ची अजून चित्रे पहा',
	'imagetagging-taggedimages-title'       => '"$1" ची चित्रे',
	'imagetagging-taggedimages-displaying'  => '"$4" ची $3 चित्रांपैकी $1 - $2 दर्शविली आहेत',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'imagetagging-article'          => 'Zāzanilli:',
	'imagetagging-imghistory'       => 'Tlahcuilōlloh',
	'imagetagging-tagcancel-button' => 'Ticcuepāz',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'taggedimages'                          => 'Afbeeldingen annoteren',
	'imagetagging-desc'                     => 'Laat een gebruiker delen van een afbeeldingen selecteren en associëren met een pagina',
	'imagetagging-addimagetag'              => 'Deze afbeelding annoteren',
	'imagetagging-article'                  => 'Pagina:',
	'imagetagging-articletotag'             => 'Te annoteren pagina',
	'imagetagging-canteditothermessage'     => 'U kunt deze pagina niet bewerken, omdat u geen rechten hebt om dat te doen, of omdat de pagina om een andere reden niet bewerkt kan worden.',
	'imagetagging-imghistory'               => 'Geschiedenis',
	'imagetagging-images'                   => 'afbeeldingen',
	'imagetagging-inthisimage'              => 'In deze afbeelding: $1',
	'imagetagging-logentry'                 => 'verwijderde annotatie naar pagina [[$1]] door $2',
	'imagetagging-log-tagged'               => 'annoteerde afbeelding [[$1|$2]] naar pagina [[$3]] door $4',
	'imagetagging-new'                      => '<sup><span style="color:red">Nieuw!</span></sup>',
	'imagetagging-removetag'                => 'annotatie verwijderen',
	'imagetagging-done-button'              => 'Klaar met annoteren',
	'imagetagging-tag-button'               => 'Annoteren',
	'imagetagging-tagcancel-button'         => 'Annuleren',
	'imagetagging-tagging-instructions'     => 'Klik op mensen of dingen op de afbeelding om ze te annoteren',
	'imagetagging-addingtag'                => 'Annotatie aan het toevoegen…',
	'imagetagging-removingtag'              => 'Annotatie aan het verwijderen…',
	'imagetagging-addtagsuccess'            => 'Annotatie toegevoegd.',
	'imagetagging-removetagsuccess'         => 'Annotatie verwijderd.',
	'imagetagging-canteditneedloginmessage' => 'U kunt deze pagina niet bewerken.
Dat kan zijn omdat u aangemeld moet zijn om afbeeldingen te annoteren.
Wilt u nu aanmelden?',
	'imagetagging-oneactionatatimemessage'  => 'Er kan maar een handeling tegelijkertijd plaatsvinden.
Wacht alstublieft totdat de huidige handeling is voltooid.',
	'imagetagging-oneuniquetagmessage'      => 'Deze afbeelding heeft al een annotatie met deze naam.',
	'imagetagging-imagetag-seemoreimages'   => 'Meer afbeeldingen bekijken van "$1" ($2)',
	'imagetagging-taggedimages-title'       => 'Afbeeldingen van "$1"',
	'imagetagging-taggedimages-displaying'  => 'De resultaten $1 tot $2 van $3 van afbeeldingen van "$4" worden weergegeven',
	'tag-logpagename'                       => 'Annotatielogboek',
	'tag-logpagetext'                       => 'In dit logboek worden toegevoegde en verwijderde annotaties bij afbeeldingen weergegeven.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'taggedimages'                          => 'Merkede bilder',
	'imagetagging-desc'                     => 'Lar en bruker velge områder på et bilde og lenke dette området til en side',
	'imagetagging-addimagetag'              => 'Merk dette bildet',
	'imagetagging-article'                  => 'Side:',
	'imagetagging-articletotag'             => 'Side som skal merkes',
	'imagetagging-canteditothermessage'     => 'Du kan ikke redigere denne siden, enten fordi du ikke har de nødvendige rettighetene eller fordi siden er låst av andre grunner.',
	'imagetagging-imghistory'               => 'Historikk',
	'imagetagging-images'                   => 'bilder',
	'imagetagging-inthisimage'              => 'På dette bildet: $1',
	'imagetagging-logentry'                 => 'Fjernet merking til siden [[$1]] av $2',
	'imagetagging-log-tagged'               => 'Bildet [[$1|$2]] ble merket til siden [[$3]] av $4',
	'imagetagging-new'                      => '<sup><span style="color:red">Ny!</span></sup>',
	'imagetagging-removetag'                => 'fjern merking',
	'imagetagging-done-button'              => 'Ferdig med å merke',
	'imagetagging-tag-button'               => 'Merk',
	'imagetagging-tagcancel-button'         => 'Avbryt',
	'imagetagging-tagging-instructions'     => 'Klikk på folk eller ting på bildet for å merke dem.',
	'imagetagging-addingtag'                => 'Legger til merke …',
	'imagetagging-removingtag'              => 'Fjerner merking …',
	'imagetagging-addtagsuccess'            => 'La til merking.',
	'imagetagging-removetagsuccess'         => 'Fjernet merking.',
	'imagetagging-canteditneedloginmessage' => 'Du kan ikke redigere denne siden.
Det er muligens fordi man må logge inn for å merke bilder.
Vil du logge inn nå?',
	'imagetagging-oneactionatatimemessage'  => 'Kun én merkingshandling av gangen er tillatt.
Vent til den forrige handlingen er ferdig.',
	'imagetagging-oneuniquetagmessage'      => 'Dette bildet har allerede et merke med dette navnet.',
	'imagetagging-imagetag-seemoreimages'   => 'Se flere bilder av «$1» ($2)',
	'imagetagging-taggedimages-title'       => 'Bilder av «$1»',
	'imagetagging-taggedimages-displaying'  => 'Viser $1&ndash;$2 av $3 bilder av «$4»',
	'tag-logpagename'                       => 'Merkingslogg',
	'tag-logpagetext'                       => 'Dette er en logg over alle nye og fjernede bildemerkinger.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'taggedimages'                          => 'Imatges balisats',
	'imagetagging-desc'                     => "Permet a un utilizaire de seleccionar las regions d’un imatge incrustat per l'associar a una pagina.",
	'imagetagging-addimagetag'              => 'Balisar aqueste imatge',
	'imagetagging-article'                  => 'Pagina :',
	'imagetagging-articletotag'             => 'Pagina de balisar',
	'imagetagging-canteditothermessage'     => 'Podètz pas modificar aquesta pagina, siá perque avètz pas los dreches necessaris siá perque la pagina es varrolhada per divèrsas rasons.',
	'imagetagging-imghistory'               => 'Istoric',
	'imagetagging-images'                   => 'imatges',
	'imagetagging-inthisimage'              => 'Dins aqueste imatge : $1',
	'imagetagging-logentry'                 => 'Balisa levada de la pagina [[$1]] per $2',
	'imagetagging-log-tagged'               => "L'imatge [[$1|$2]] es estat balisat per la pagina [[$3]] per $4",
	'imagetagging-new'                      => '<sup><span style="color:red">Novèl !</span></sup>',
	'imagetagging-removetag'                => 'levar la balisa',
	'imagetagging-done-button'              => 'Balisatge efectuat',
	'imagetagging-tag-button'               => 'Balisa',
	'imagetagging-tagcancel-button'         => 'Anullar',
	'imagetagging-tagging-instructions'     => 'Clicar sus las personas o las causas dins l’imatge per las balisar.',
	'imagetagging-addingtag'                => 'Balisa en cors d’ajust…',
	'imagetagging-removingtag'              => 'Balisa en cors de levament…',
	'imagetagging-addtagsuccess'            => 'Balisa ajustada.',
	'imagetagging-removetagsuccess'         => 'Balisa levada.',
	'imagetagging-canteditneedloginmessage' => 'Podètz pas modificar aquesta pagina.
Aquò poiriá èsser perque avètz besonh de vos connectar per balisar los imatges.
Vos volètz connectar ara ?',
	'imagetagging-oneactionatatimemessage'  => "Una accion de balisatge es permesa a l'encòp.
Esperatz la fin de l’accion en cors.",
	'imagetagging-oneuniquetagmessage'      => 'Aqueste imatge ja a una balisa amb aqueste nom.',
	'imagetagging-imagetag-seemoreimages'   => 'Vejatz mai d’imatges de « $1 » ($2)',
	'imagetagging-taggedimages-title'       => 'Imatges de « $1 »',
	'imagetagging-taggedimages-displaying'  => 'Afichatge de $1 - $2 sus $3 imatges de « $4 »',
	'tag-logpagename'                       => 'Balisatge del jornal',
	'tag-logpagetext'                       => 'Aquò es lo jornal de totes los ajustons e de totas las supressions de las balisas d’imatge.',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Maikking
 */
$messages['pl'] = array(
	'imagetagging-article'          => 'Artykuł:',
	'imagetagging-imghistory'       => 'Historia',
	'imagetagging-tagcancel-button' => 'Anuluj',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Enqd
 */
$messages['pt-br'] = array(
	'taggedimages'                  => 'Imagens marcadas',
	'imagetagging-addimagetag'      => 'Marcar esta imagem',
	'imagetagging-images'           => 'imagens',
	'imagetagging-done-button'      => 'Marcação concluída',
	'imagetagging-tag-button'       => 'Marcar',
	'imagetagging-tagcancel-button' => 'Cancelar',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'imagetagging-imghistory' => 'Amzruy',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'taggedimages'                  => 'Imagini etichetate',
	'imagetagging-addimagetag'      => 'Etichetează această imagine',
	'imagetagging-article'          => 'Pagină:',
	'imagetagging-imghistory'       => 'Istoric',
	'imagetagging-images'           => 'imagini',
	'imagetagging-inthisimage'      => 'În această imagine: $1',
	'imagetagging-removetag'        => 'elimină etichetă',
	'imagetagging-tagcancel-button' => 'Anulează',
	'imagetagging-addingtag'        => 'Adăugare etichetă…',
	'imagetagging-removingtag'      => 'Eliminare etichetă…',
	'imagetagging-addtagsuccess'    => 'Adăugat etichetă.',
	'imagetagging-removetagsuccess' => 'Şters etichetă.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'taggedimages'                          => 'Označené obrázky',
	'imagetagging-desc'                     => 'Umožňuje používateľom vybrať oblasti vloženého obrázka a k danej oblasti priradiť stránku.',
	'imagetagging-addimagetag'              => 'Označiť tento obrázok',
	'imagetagging-article'                  => 'Stránka:',
	'imagetagging-articletotag'             => 'Označiť stránku:',
	'imagetagging-canteditothermessage'     => 'Túto stránku nemôžete upravovať, buď preto, že na to nemáte potrebné oprávnenie alebo preto, že stránka je zamknutá z iných dôvodov.',
	'imagetagging-imghistory'               => 'História',
	'imagetagging-images'                   => 'obrázky',
	'imagetagging-inthisimage'              => 'V tomto obrázku: $1',
	'imagetagging-logentry'                 => '$2 odstránil zmačku na stránku [[$1]]',
	'imagetagging-log-tagged'               => '$4 označil obrázok [[$1|$2]] na stránku [[$3]]',
	'imagetagging-new'                      => '<sup><span style="color:red">Nové!</span></sup>',
	'imagetagging-removetag'                => 'odstrániť štítok',
	'imagetagging-done-button'              => 'Ukončiť označovanie',
	'imagetagging-tag-button'               => 'Značka',
	'imagetagging-tagcancel-button'         => 'Zrušiť',
	'imagetagging-tagging-instructions'     => 'Kliknutím na ľudí alebo veci na obrázku ich môžete označiť.',
	'imagetagging-addingtag'                => 'Pridáva sa značka…',
	'imagetagging-removingtag'              => 'Odstraňuje sa značka…',
	'imagetagging-addtagsuccess'            => 'Pridaná značka.',
	'imagetagging-removetagsuccess'         => 'Odstránená značka.',
	'imagetagging-canteditneedloginmessage' => 'Túto stránku nemôžete upravovať.
Možno je to preto, že sa musíte prihlásiť, aby ste mohli označovať obrázky.
Chcete sa teraz prihlásiť?',
	'imagetagging-oneactionatatimemessage'  => 'Je možné naraz označovať iba jeden obrázok.
Počkajte prosím, kým sa dokončí prebiehajúca operácia.',
	'imagetagging-oneuniquetagmessage'      => 'Tento obrázok už má značku s takýmto názvom.',
	'imagetagging-imagetag-seemoreimages'   => 'Zobraziť viac obrázkov „$1” ($2)',
	'imagetagging-taggedimages-title'       => 'Obrázky „$1”',
	'imagetagging-taggedimages-displaying'  => 'Zobrazujú sa $1 - $2 z $3 obrázkov „$4”',
	'tag-logpagename'                       => 'Záznam značenia',
	'tag-logpagetext'                       => 'Toto je záznam všetkých pridaní a odstránení značiek obrázkov.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'imagetagging-imghistory'       => 'Jujutan',
	'imagetagging-images'           => 'gambar',
	'imagetagging-tagcancel-button' => 'Bolay',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Boivie
 */
$messages['sv'] = array(
	'taggedimages'                          => 'Märkta bilder',
	'imagetagging-desc'                     => 'Låter en användare välja områden på en bild och länka de områdena till en sida',
	'imagetagging-addimagetag'              => 'Märk den här bilden',
	'imagetagging-article'                  => 'Sida:',
	'imagetagging-articletotag'             => 'Sida som ska märkas',
	'imagetagging-canteditothermessage'     => 'Du kan inte redigera den här sidan, antingen för att du inte har behörighet att göra det eller för att sidan är låst av andra anledningar.',
	'imagetagging-imghistory'               => 'Historik',
	'imagetagging-images'                   => 'bilder',
	'imagetagging-inthisimage'              => 'På den här bilden: $1',
	'imagetagging-logentry'                 => 'Tog bort märkning till sidan [[$1]] av $2',
	'imagetagging-log-tagged'               => 'Bilden [[$1|$2]] märktes till sidan [[$3]] av $4',
	'imagetagging-new'                      => '<sup><span style="color:red">Ny!</span></sup>',
	'imagetagging-removetag'                => 'ta bort märkning',
	'imagetagging-done-button'              => 'Färdig med att märka',
	'imagetagging-tag-button'               => 'Märk',
	'imagetagging-tagcancel-button'         => 'Avbryt',
	'imagetagging-tagging-instructions'     => 'Klicka på folk eller saker på bilden för att märka dom.',
	'imagetagging-addingtag'                => 'Lägger till märkning...',
	'imagetagging-removingtag'              => 'Tar bort märkning...',
	'imagetagging-addtagsuccess'            => 'Lade till märkning.',
	'imagetagging-removetagsuccess'         => 'Tog bort märkning.',
	'imagetagging-canteditneedloginmessage' => 'Du kan inte redigera den här sidan.
Det kan bero på att man måste logga in för att märka bilder.
Vill du logga in nu?',
	'imagetagging-oneactionatatimemessage'  => 'Endast en märkningshandling är den här gången tillåten.
Var god vänta tills den föregående handlingen är färdig.',
	'imagetagging-oneuniquetagmessage'      => 'Den här bilden har redan en märkning med det här namnet.',
	'imagetagging-imagetag-seemoreimages'   => 'Se mer bilder av "$1" ($2)',
	'imagetagging-taggedimages-title'       => 'Bilder av "$1"',
	'imagetagging-taggedimages-displaying'  => 'Visar $1 - $2 av $3 bilder av "$4"',
	'tag-logpagename'                       => 'Märkningslogg',
	'tag-logpagetext'                       => 'Det här är en logg över alla tillägg och borttagningar av bildmärkningar.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'imagetagging-article'     => 'పేజీ:',
	'imagetagging-imghistory'  => 'చరిత్ర',
	'imagetagging-images'      => 'బొమ్మలు',
	'imagetagging-inthisimage' => 'ఈ బొమ్మలో: $1',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'imagetagging-article'            => 'Sayfa:',
	'imagetagging-imghistory'         => 'Geçmiş',
	'imagetagging-images'             => 'Resimler',
	'imagetagging-taggedimages-title' => '"$1" resimleri',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'taggedimages'                          => 'Hình có gắn thẻ',
	'imagetagging-desc'                     => 'Cho phép người dùng lựa chọn những khu vực của một hình được nhúng vào và gắn một trang vào khu vực đó',
	'imagetagging-addimagetag'              => 'Gắn thẻ hình này',
	'imagetagging-article'                  => 'Trang:',
	'imagetagging-articletotag'             => 'Trang gắn thẻ',
	'imagetagging-imghistory'               => 'Lịch sử',
	'imagetagging-images'                   => 'hình',
	'imagetagging-inthisimage'              => 'Trong hình này: $1',
	'imagetagging-logentry'                 => '$2 đã bỏ thẻ cho trang [[$1]]',
	'imagetagging-log-tagged'               => 'Hình [[$1|$2]] đã được gắn vào trang [[$3]] bởi $4',
	'imagetagging-new'                      => '<sup><span style="color:red">Mới!</span></sup>',
	'imagetagging-removetag'                => 'bỏ thẻ',
	'imagetagging-done-button'              => 'Đã gắn thẻ xong',
	'imagetagging-tag-button'               => 'Thẻ',
	'imagetagging-tagcancel-button'         => 'Bãi bỏ',
	'imagetagging-tagging-instructions'     => 'Nhấn vào người hoặc vật trong hình để gắn thẻ cho chúng.',
	'imagetagging-addingtag'                => 'Đang thêm thẻ…',
	'imagetagging-removingtag'              => 'Đang bỏ thẻ…',
	'imagetagging-addtagsuccess'            => 'Đã thêm thẻ.',
	'imagetagging-removetagsuccess'         => 'Đã bỏ thẻ.',
	'imagetagging-canteditneedloginmessage' => 'Bạn không sửa đổi trang này.
Có thể do bạn cần phải đăng nhập mới gắn thẻ cho hình được.
Bạn có muốn đăng nhập ngay bây giờ?',
	'imagetagging-oneactionatatimemessage'  => 'Chỉ cho phép một tác vụ gắn thẻ vào một thời điểm.
Xin hãy chờ tác vụ hoàn thành.',
	'imagetagging-oneuniquetagmessage'      => 'Hình này đã có một thẻ với tên này.',
	'imagetagging-imagetag-seemoreimages'   => 'Xem nhiều hình của "$1" hơn ($2)',
	'imagetagging-taggedimages-title'       => 'Hình của "$1"',
	'imagetagging-taggedimages-displaying'  => 'Hiển thị $1 - $2 trong tổng số $3 hình của "$4"',
);

