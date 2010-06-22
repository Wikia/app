<?php

$messages = array();

$messages['en'] = array(
	'follow-desc' => 'Improvements for the watchlist functionality',
	'wikiafollowedpages-special-heading-category' => "Categories ($1)",
	'wikiafollowedpages-special-heading-article' => "Articles ($1)",
	'wikiafollowedpages-special-heading-blogs' => "Blogs and posts ($1)",
	'wikiafollowedpages-special-heading-forum' => 'Forum threads ($1)',
	'wikiafollowedpages-special-heading-project' => 'Project pages ($1)',
	'wikiafollowedpages-special-heading-user' => 'User pages ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Templates pages ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'MediaWiki pages ($1)',
	'wikiafollowedpages-special-heading-media' => 'Images and videos ($1)',
	'wikiafollowedpages-special-namespace' => "($1 page)",
	'wikiafollowedpages-special-empty' => "This user's followed pages list is empty.
Add pages to this list by clicking \"{{int:watch}}\" at the top of a page.",
	'wikiafollowedpages-special-anon' => 'Please [[Special:Signup|log in]] to create or view your followed pages list.',

	'wikiafollowedpages-special-showall' => 'Show all',
	'wikiafollowedpages-special-title' => 'Followed pages',
	'wikiafollowedpages-special-delete-tooltip' => 'Remove this page',

	'wikiafollowedpages-special-hidden' => 'This user has chosen to hide {{GENDER:$1|his|her|their}} followed pages list from public view.',
	'wikiafollowedpages-special-hidden-unhide' => 'Unhide this list.',
	'wikiafollowedpages-special-blog-by' => 'by $1',
	'wikiafollowedpages-masthead' => 'Followed pages',
	'wikiafollowedpages-following' => 'Following',
	'wikiafollowedpages-special-title-userbar' => 'Followed pages',

	'tog-enotiffollowedpages' => 'E-mail me when a page I am following is changed',
	'tog-enotiffollowedminoredits' => 'E-mail me for minor edits to pages I am following',

	'wikiafollowedpages-prefs-advanced' => 'Advanced options',
	'wikiafollowedpages-prefs-watchlist' => '[[Special:Watchlist|Watchlist]] only',

	'tog-hidefollowedpages' => 'Make my followed pages lists private',
	'follow-categoryadd-summary' => "Page added to category", //TODO check this
	'follow-bloglisting-summary' => "Blog posted on blog page",

	'wikiafollowedpages-userpage-heading' => "Pages I am following",
	'wikiafollowedpages-userpage-more' => 'More',
	'wikiafollowedpages-userpage-hide' => 'hide',
	'wikiafollowedpages-userpage-empty' => "This user's followed pages list is empty.
Add pages to this list by clicking \"{{int:watch}}\" at the top of a page.",

	'enotif_subject_categoryadd' => '{{SITENAME}} page $PAGETITLE has been added to $CATEGORYNAME by $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Dear $WATCHINGUSERNAME,

A page has been added to a category you are following on {{SITENAME}}.

See "$PAGETITLE_URL" for the new page.

Please visit and edit often...

{{SITENAME}}

___________________________________________
* Check out our featured wikis! http://www.wikia.com

* Want to control which e-mails you receive?
Go to: {{fullurl:{{ns:special}}:Preferences}}.',

	'enotif_body_categoryadd-html' => '<p>
Dear $WATCHINGUSERNAME,
<br /><br />
A page has been added to a category you are following on {{SITENAME}}.
<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the new page.
<br /><br />
Please visit and edit often...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Check out our featured wikis!</a></li>
<li>Want to control which e-mails you receive? Go to <a href="{{fullurl:{{ns:special}}:Preferences}}">User preferences</a></li>
</ul>
</p>',

	'enotif_subject_blogpost' => '{{SITENAME}} page $PAGETITLE has been posted to $BLOGLISTINGNAME by $PAGEEDITOR',
	'enotif_body_blogpost' => 'Dear $WATCHINGUSERNAME,

There has been an edit to a blog listing page you are following on {{SITENAME}}.

See "$PAGETITLE_URL" for the new post.

Please visit and edit often...

{{SITENAME}}

___________________________________________
* Check out our featured wikis! http://www.wikia.com

* Want to control which e-mails you receive?
Go to: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Dear $WATCHINGUSERNAME,
<br /><br />
There has been an edit to a blog listing page you are following on {{SITENAME}}.
<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the new post.
<br /><br />
Please visit and edit often...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Check out our featured wikis!</a></li>
<li>Want to control which e-mails you receive? Go to <a href="{{fullurl:{{ns:special}}:Preferences}}">User preferences</a></li>
</ul>
</p>'
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'wikiafollowedpages-special-heading-category' => 'Rummadoù ($1)',
	'wikiafollowedpages-special-heading-article' => 'Pennadoù ($1)',
	'wikiafollowedpages-special-heading-project' => 'Pajennoù raktres ($1)',
	'wikiafollowedpages-special-heading-user' => 'Pajennoù implijer ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Pajennoù patromoù ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'Pajennoù MediaWiki ($1)',
	'wikiafollowedpages-special-heading-media' => 'Skeudennoù ha videoioù ($1)',
	'wikiafollowedpages-special-namespace' => '(pajenn $1)',
	'wikiafollowedpages-special-showall' => 'Diskouez pep tra',
	'wikiafollowedpages-special-blog-by' => 'gant $1',
	'wikiafollowedpages-prefs-advanced' => 'Dibarzhioù araokaet',
	'wikiafollowedpages-prefs-watchlist' => '[[Special:Watchlist|Roll evezhiañ]] hepken',
	'wikiafollowedpages-userpage-more' => "Muioc'h",
	'wikiafollowedpages-userpage-hide' => 'kuzhat',
);

/** German (Deutsch)
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de'] = array(
	'follow-desc' => 'Verbesserungen an der Beobachtungsliste',
	'wikiafollowedpages-special-heading-category' => 'Kategorien ($1)',
	'wikiafollowedpages-special-heading-article' => 'Artikel ($1)',
	'wikiafollowedpages-special-heading-blogs' => 'Blogs und Einträge ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Forum-Diskussionsstränge ($1)',
	'wikiafollowedpages-special-heading-project' => 'Projektseiten ($1)',
	'wikiafollowedpages-special-heading-user' => 'Benutzerseiten ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Vorlagenseiten ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'MediaWiki-Seiten ($1)',
	'wikiafollowedpages-special-heading-media' => 'Bilder und Videos ($1)',
	'wikiafollowedpages-special-namespace' => '($1 Seite)',
	'wikiafollowedpages-special-empty' => 'Die Liste der beobachteten Seiten dieses Benutzers ist leer.
Du kannst durch Klicken des {{int:watch}}-Buttons Seiten dieser Liste hinzufügen.',
	'wikiafollowedpages-special-anon' => 'Bitte [[Special:Signup|anmelden]] um deine Beobachtungsliste zu erstellen oder betrachten.',
	'wikiafollowedpages-special-showall' => 'Alle anzeigen',
	'wikiafollowedpages-special-title' => 'Beobachtete Seiten',
	'wikiafollowedpages-special-delete-tooltip' => 'Diese Seite entfernen',
	'wikiafollowedpages-special-hidden' => 'Dieser {{GENDER:$1|Benutzer|Benutzerin|Benutzer}} hat sich dazu entschieden, {{GENDER:$1|seine|ihre|seine}} Beobachtungsliste von der Öffentlichkeit zu verstecken.',
	'wikiafollowedpages-special-hidden-unhide' => 'Diese Liste nicht mehr verstecken.',
	'wikiafollowedpages-special-blog-by' => 'von $1',
	'wikiafollowedpages-masthead' => 'Beobachtete Seiten',
	'wikiafollowedpages-following' => 'Folgende',
	'wikiafollowedpages-special-title-userbar' => 'Beobachtete Seiten',
	'tog-enotiffollowedpages' => 'Bei Änderungen an beobachteten Seiten E-Mails senden',
	'tog-enotiffollowedminoredits' => 'Auch bei kleinen Änderungen an beobachteten Seiten E-Mails senden',
	'wikiafollowedpages-prefs-advanced' => 'Erweiterte Optionen',
	'wikiafollowedpages-prefs-watchlist' => 'Nur [[Special:Watchlist|Beobachtungsliste]]',
	'tog-hidefollowedpages' => 'Halte meine Beobachtungsliste privat',
	'follow-categoryadd-summary' => 'Seite zu Kategorie hinzugefügt',
	'follow-bloglisting-summary' => 'Blog auf Blogseite gepostet',
	'wikiafollowedpages-userpage-heading' => 'Seiten, die ich beobachte',
	'wikiafollowedpages-userpage-more' => 'Mehr',
	'wikiafollowedpages-userpage-hide' => 'verstecken',
	'wikiafollowedpages-userpage-empty' => 'Die Liste der beobachteten Seiten dieses Benutzers ist leer.
Du kannst durch Klicken des {{int:watch}}-Buttons Seiten dieser Liste hinzufügen.',
	'enotif_subject_categoryadd' => '[{{SITENAME}}] Die Seite „$PAGETITLE“ wurde von $PAGEEDITOR in die Kategorie $CATEGORYNAME hinzugefügt',
	'enotif_body_categoryadd' => 'Hallo $WATCHINGUSERNAME,

Eine Seite, die du auf {{SITENAME}} beobachtest, wurde einer Kategorie hinzugefügt.

Siehe „$PAGETITLE_URL“ für die neue Seite.

Schau doch mal rein und bearbeite sie weiter...

{{SITENAME}}

___________________________________________
* Schau dir unsere exzellenten Wikis an! http://www.wikia.com

* Willst du kontrollieren, welche E-Mails du erhältst?
Gehe auf: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>
Hallo $WATCHINGUSERNAME,
<br /><br />
Eine Seite, die du auf {{SITENAME}} beobachtest, wurde einer Kategorie hinzugefügt.
<br /><br />
Siehe <a href="$PAGETITLE_URL">$PAGETITLE</a> für die neue Seite
<br /><br />
Schau doch mal rein und bearbeite sie weiter...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Schau dir unsere exzellenten Wikis an!</a></li>
<li>Willst du kontrollieren, welche E-Mails du erhältst? Gehe auf: <a href="{{fullurl:{{ns:special}}:Preferences}}">Benutzer-Einstellungen</a></li>
</p>',
	'enotif_subject_blogpost' => '[{{SITENAME}}] Die Seite $PAGETITLE wurde von $PAGEEDITOR auf $BLOGLISTINGNAME gepostet',
	'enotif_body_blogpost' => 'Hallo $WATCHINGUSERNAME,

Es gab eine Bearbeitung an einem Blog, den du auf {{SITENAME}} beobachtest.

Siehe „$PAGETITLE_URL“ für den neuen Post.

Schau doch mal rein und bearbeite sie weiter...

{{SITENAME}}

___________________________________________

* Schau dir unsere exzellenten Wikis an! http://www.wikia.com

* Willst du kontrollieren, welche E-Mails du erhältst?
Gehe auf: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Hallo $WATCHINGUSERNAME,
<br /><br />
Es gab eine Bearbeitung an einem Blog, den du auf {{SITENAME}} beobachtest.
<br /><br />
Siehe <a href="$PAGETITLE_URL">$PAGETITLE</a> für den neuen Post.
<br /><br />
Schau doch mal rein und bearbeite sie weiter...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Schau dir unsere exzellenten Wikis an!</a></li>
<li>Willst du kontrollieren, welche E-Mails du erhältst? Gehe auf: <a href="{{fullurl:{{ns:special}}:Preferences}}">Benutzer-Einstellungen</a>.</li>
</ul>
</p>',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'wikiafollowedpages-special-empty' => 'Die Liste der beobachteten Seiten dieses Benutzers ist leer.
Sie können durch Klicken des {{int:watch}}-Buttons Seiten dieser Liste hinzufügen.',
	'wikiafollowedpages-special-anon' => 'Bitte [[Special:Signup|anmelden]] um Ihre Beobachtungsliste zu erstellen oder betrachten.',
	'wikiafollowedpages-userpage-empty' => 'Die Liste der beobachteten Seiten dieses Benutzers ist leer.
Sie können durch Klicken des {{int:watch}}-Buttons Seiten dieser Liste hinzufügen.',
	'enotif_body_categoryadd' => 'Hallo $WATCHINGUSERNAME,

Eine Seite, die Sie auf {{SITENAME}} beobachten, wurde einer Kategorie hinzugefügt.

Siehe „$PAGETITLE_URL“ für die neue Seite.

Schauen Sie doch mal rein und bearbeiten Sie sie weiter...

{{SITENAME}}

___________________________________________
* Schauen Sie sich unsere exzellenten Wikis an! http://www.wikia.com

* Wollen Sie kontrollieren, welche E-Mails Sie erhalten?
Gehen Sie auf: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>
Hallo $WATCHINGUSERNAME,
<br /><br />
Eine Seite, die Sie auf {{SITENAME}} beobachten, wurde einer Kategorie hinzugefügt.
<br /><br />
Siehe <a href="$PAGETITLE_URL">$PAGETITLE</a> für die neue Seite
<br /><br />
Schauen Sie doch mal rein und bearbeiten Sie sie weiter...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Schauen Sie sich unsere exzellenten Wikis an!</a></li>
<li>Wollen Sie kontrollieren, welche E-Mails Sie erhalten? Gehen Sie auf: <a href="{{fullurl:{{ns:special}}:Preferences}}">Benutzer-Einstellungen</a></li>
</p>',
	'enotif_body_blogpost' => 'Hallo $WATCHINGUSERNAME,

Es gab eine Bearbeitung an einem Blog, den Sie auf {{SITENAME}} beobachten.

Siehe „$PAGETITLE_URL“ für den neuen Post.

Schauen Sie doch mal rein und bearbeiten Sie sie weiter...

{{SITENAME}}

___________________________________________

* Schauen Sie sich unsere exzellenten Wikis an! http://www.wikia.com

* Wollen Sie kontrollieren, welche E-Mails Sie erhalten?
Gehen Sie auf: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Hallo $WATCHINGUSERNAME,
<br /><br />
Es gab eine Bearbeitung an einem Blog, den Sie auf {{SITENAME}} beobachten.
<br /><br />
Siehe <a href="$PAGETITLE_URL">$PAGETITLE</a> für den neuen Post.
<br /><br />
Schauen Sie doch mal rein und bearbeiten Sie sie weiter...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Schauen Sie sich unsere exzellenten Wikis an!</a></li>
<li>Wollen Sie kontrollieren, welche E-Mails Sie erhalten? Gehen Sie auf: <a href="{{fullurl:{{ns:special}}:Preferences}}">Benutzer-Einstellungen</a>.</li>
</ul>
</p>',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'follow-desc' => 'Mejoras para la funcionalidad de la lista de vigilancia',
	'wikiafollowedpages-special-heading-category' => 'Categorías ($1)',
	'wikiafollowedpages-special-heading-article' => 'Artículos ($1)',
	'wikiafollowedpages-special-heading-blogs' => 'Blogs y mensajes ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Hilos del foro ($1)',
	'wikiafollowedpages-special-heading-project' => 'Páginas de proyecto ($1)',
	'wikiafollowedpages-special-heading-user' => 'Páginas de usuario ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Páginas de plantillas ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'Páginas de MediaWiki ($1)',
	'wikiafollowedpages-special-heading-media' => 'Imágenes y videos ($1)',
	'wikiafollowedpages-special-namespace' => '($1 página)',
	'wikiafollowedpages-special-empty' => 'La lista de páginas seguidas por este usuario está vacía.
Agregar páginas a esta lista haciendo click en "{{int:watch}}" arriba de una página.',
	'wikiafollowedpages-special-anon' => 'Por favor [[Special:Signup|inicia sesión]] para crear o ver tu lista de páginas seguidas.',
	'wikiafollowedpages-special-showall' => 'Mostrar todo',
	'wikiafollowedpages-special-title' => 'Páginas seguidas',
	'wikiafollowedpages-special-delete-tooltip' => 'remover esta página',
	'wikiafollowedpages-special-hidden' => 'Este usuario ha elegido ocultar {{GENDER:$1|su|su|su}} lista de páginas seguidas a la vista del público.',
	'wikiafollowedpages-special-hidden-unhide' => 'Dejar de ocultar esta lista.',
	'wikiafollowedpages-special-blog-by' => 'por $1',
	'wikiafollowedpages-masthead' => 'Páginas seguidas',
	'wikiafollowedpages-following' => 'Siguiendo',
	'wikiafollowedpages-special-title-userbar' => 'Páginas seguidas',
	'tog-enotiffollowedpages' => 'Enviarme un correo electrónico cuando una página que estoy siguiendo es cambiada',
	'tog-enotiffollowedminoredits' => 'Enviarme un correo electrónico por ediciones menores a las páginas que estoy siguiendo',
	'wikiafollowedpages-prefs-advanced' => 'Opciones avanzadas',
	'wikiafollowedpages-prefs-watchlist' => '[[Special:Watchlist|Lista de seguimiento]] solamente',
	'tog-hidefollowedpages' => 'Hacer privada mi lista de páginas seguidas',
	'follow-categoryadd-summary' => 'Página agregada a categoría',
	'follow-bloglisting-summary' => 'Blog publicado en la página de blog',
	'wikiafollowedpages-userpage-heading' => 'Páginas que estoy siguiendo',
	'wikiafollowedpages-userpage-more' => 'Más',
	'wikiafollowedpages-userpage-hide' => 'ocultar',
	'wikiafollowedpages-userpage-empty' => 'La lista de páginas seguidas de este usuario está vacía.
Agregar páginas a esta lista haciendo click en "{{int:watch}}" en la parte superior de una página.',
	'enotif_subject_categoryadd' => 'Página {{SITENAME}} $PAGETITLE ha sido agregada a $CATEGORYNAME por $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Querido $WATCHINGUSERNAME,

Una página ha sido agregada a una categoría que estás siguiendo en {{SITENAME}}.

Ver "$PAGETITLE_URL" para la nueva página.

Por favor visita y edita frecuentemente...

{{SITENAME}}

___________________________________________
* Verifica nuestros wikis destacados! http://www.wikia.com

* Deseas controlar los correos que recibes?
Ve a: {{fullurl:{{ns:special}}:Preferencias}}.',
	'enotif_body_categoryadd-html' => '<p>
Querido $WATCHINGUSERNAME,
<br /><br />
Una página ha sido agregada a una categoría que estás siguiendo en {{SITENAME}}.
<br /><br />
Ver <a href="$PAGETITLE_URL">$PAGETITLE</a> para la nueva página.
<br /><br />
Por favor visita y edita frecuentemente...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Verifica nuestros wikis destacados!</a></li>
<li>Deseas controlar los correos que recibes? Ve a <a href="{{fullurl:{{ns:special}}:Preferenciass}}">Preferencias de usuario</a></li>
</ul>
</p>',
	'enotif_subject_blogpost' => 'Página {{SITENAME}} $PAGETITLE ha sido publicada en $BLOGLISTINGNAME por $PAGEEDITOR',
	'enotif_body_blogpost' => 'Querido $WATCHINGUSERNAME,

Hubo una edición a una página de listado de blogs que estás siguiendo en {{SITENAME}}.

Ver "$PAGETITLE_URL" para el nuevo mensaje.

Por favor visita y edita frecuentemente...

{{SITENAME}}

___________________________________________
* Verifica nuestros wikis destacados! http://www.wikia.com

* Deseas controlar los correos que recibes?
Ve a: {{fullurl:{{ns:special}}:Preferencias}}.',
	'enotif_body_blogpost-HTML' => '<p>
Querido $WATCHINGUSERNAME,
<br /><br />
Hubo una edición a una página de listado de blogs que estás siguiendo en {{SITENAME}}.
<br /><br />
Ver <a href="$PAGETITLE_URL">$PAGETITLE</a> para el nuevo mensaje.
<br /><br />
Por favor visita y edita frecuentemente...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Verifica nuestros wikis destacados!</a></li>
<li>Deseas controlar los correos que recibes? Ve a <a href="{{fullurl:{{ns:special}}:Preferencias}}">Preferencias de usuario</a></li>
</ul>
</p>',
);

/** French (Français)
 * @author Peter17
 */
$messages['fr'] = array(
	'follow-desc' => 'Améliorations pour la liste de suivi',
	'wikiafollowedpages-special-heading-category' => 'Catégories ($1)',
	'wikiafollowedpages-special-heading-article' => 'Articles ($1)',
	'wikiafollowedpages-special-heading-blogs' => 'Blogs et posts ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Sujets de forums ($1)',
	'wikiafollowedpages-special-heading-project' => 'Pages de projet ($1)',
	'wikiafollowedpages-special-heading-user' => 'Pages utilisateur ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Pages de modèles ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'Pages MediaWiki ($1)',
	'wikiafollowedpages-special-heading-media' => 'Images et vidéos ($1)',
	'wikiafollowedpages-special-namespace' => '(page $1)',
	'wikiafollowedpages-special-empty' => 'La liste de suivi de cet utilisateur est vide.
Ajoutez des pages à cette liste en cliquant sur « Suivre » en haut d’une page.',
	'wikiafollowedpages-special-anon' => 'Veuillez [[Special:Signup|vous identifier]] pour créer ou voir votre liste de suivi.',
	'wikiafollowedpages-special-showall' => 'Tout afficher',
	'wikiafollowedpages-special-title' => 'Pages suivies',
	'wikiafollowedpages-special-delete-tooltip' => 'Supprimer cette page',
	'wikiafollowedpages-special-hidden' => 'Cet {{GENDER:$1|utilisateur|utilisatrice|utilisateur}} a choisi de cacher sa liste de suivi au public.',
	'wikiafollowedpages-special-hidden-unhide' => 'Ne pas masquer cette liste.',
	'wikiafollowedpages-special-blog-by' => 'par $1',
	'wikiafollowedpages-masthead' => 'Pages suivies',
	'wikiafollowedpages-following' => 'Suivi',
	'wikiafollowedpages-special-title-userbar' => 'Pages suivies',
	'tog-enotiffollowedpages' => 'M’avertir par courrier électronique lorsqu’une page de ma liste de suivi est modifiée',
	'tog-enotiffollowedminoredits' => 'M’avertir par courrier électronique lors des modifications mineures des pages que je suis',
	'wikiafollowedpages-prefs-advanced' => 'Options avancées',
	'wikiafollowedpages-prefs-watchlist' => '[[Special:Watchlist|Liste de suivi]] uniquement',
	'tog-hidefollowedpages' => 'Rendre privée ma liste de suivi',
	'follow-categoryadd-summary' => 'Page ajoutée à la catégorie',
	'follow-bloglisting-summary' => 'Blog posté sur une page de blog',
	'wikiafollowedpages-userpage-heading' => 'Pages que je suis',
	'wikiafollowedpages-userpage-more' => 'Plus',
	'wikiafollowedpages-userpage-hide' => 'masquer',
	'wikiafollowedpages-userpage-empty' => 'La liste de suivi de cet utilisateur est vide.
Ajoutez des pages à cette liste en cliquant sur « Suivre » en haut d’une page.',
	'enotif_subject_categoryadd' => 'La page $PAGETITLE de {{SITENAME}} a été ajoutée à $CATEGORYNAME par $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Bonjour $WATCHINGUSERNAME,

Une page a été ajoutée à une catégorie que vous suivez sur {{SITENAME}}.

Voyez « $PAGETITLE_URL » pour la nouvelle page.

Merci de visiter ce site et de le modifier fréquemment...

{{SITENAME}}

___________________________________________
* Jetez un œil à nos wikis vedettes ! http://www.wikia.com

* Vous voulez contrôler l’envoi des courriers électroniques ?
Allez sur : {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>
Bonjour $WATCHINGUSERNAME,
<br /><br />
Une page a été ajoutée à une catégorie que vous suivez sur {{SITENAME}}.
<br /><br />
Voyez <a href="$PAGETITLE_URL">$PAGETITLE</a> pour la nouvelle page.
<br /><br />
Merci de visiter ce site et de le modifier fréquemment...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Jetez un œil à nos wikis vedettes !</a></li>
<li>Vous voulez contrôler l’envoi des courriers électroniques ? Allez sur <a href="{{fullurl:{{ns:special}}:Preferences}}">vos préférences utilisateur</a></li>
</ul>
</p>',
	'enotif_subject_blogpost' => 'La page $PAGETITLE de {{SITENAME}} a été postée sur $BLOGLISTINGNAME par $PAGEEDITOR',
	'enotif_body_blogpost' => 'Bonjour $WATCHINGUSERNAME,

Une modification a été apportée à l’une des pages de liste de blogs que vous suivez sur {{SITENAME}}.

Voyez « $PAGETITLE_URL » pour ce nouveau post.

Merci de visiter ce site et de le modifier fréquemment...

{{SITENAME}}

___________________________________________
* Jetez un œil à nos wikis vedettes ! http://www.wikia.com

* Vous voulez contrôler l’envoi des courriers électroniques ?
Allez sur : {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Bonjour $WATCHINGUSERNAME,
<br /><br />
Une modification a été apportée à l’une des pages de liste de blogs que vous suivez sur {{SITENAME}}.
<br /><br />
Voyez <a href="$PAGETITLE_URL">$PAGETITLE</a> pour ce nouveau post.
<br /><br />
Merci de visiter ce site et de le modifier fréquemment...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Jetez un œil à nos wikis vedettes !</a></li>
<li>Vous voulez contrôler l’envoi des courriers électroniques ? Allez sur <a href="{{fullurl:{{ns:special}}:Preferences}}">vos préférences utilisateur</a></li>
</ul>
</p>',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'follow-desc' => 'Melloras para a lista de vixilancia',
	'wikiafollowedpages-special-heading-category' => 'Categorías ($1)',
	'wikiafollowedpages-special-heading-article' => 'Artigos ($1)',
	'wikiafollowedpages-special-heading-blogs' => 'Blogues e publicacións ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Fíos no foro ($1)',
	'wikiafollowedpages-special-heading-project' => 'Páxinas do proxecto ($1)',
	'wikiafollowedpages-special-heading-user' => 'Páxinas de usuario ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Páxinas de modelo ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'Páxinas de MediaWiki ($1)',
	'wikiafollowedpages-special-heading-media' => 'Imaxes e vídeos ($1)',
	'wikiafollowedpages-special-namespace' => '(páxina $1)',
	'wikiafollowedpages-special-empty' => 'A lista de vixilancia deste usuario está baleira.
Engada páxinas a esta lista premendo no botón "{{int:watch}}" que aparecerá na parte superior das páxinas.',
	'wikiafollowedpages-special-anon' => '[[Special:Signup|Acceda ao sistema]] para crear ou ollar a súa lista de vixilancia.',
	'wikiafollowedpages-special-showall' => 'Mostrar todo',
	'wikiafollowedpages-special-title' => 'Páxinas vixiadas',
	'wikiafollowedpages-special-delete-tooltip' => 'Eliminar esta páxina',
	'wikiafollowedpages-special-hidden' => '{{GENDER:$1|Este usuario|Esta usuaria|Este usuario}} optou por agochar a súa lista de vixilancia da vista dos demais.',
	'wikiafollowedpages-special-hidden-unhide' => 'Descubrir esta lista.',
	'wikiafollowedpages-special-blog-by' => 'por $1',
	'wikiafollowedpages-masthead' => 'Páxinas vixiadas',
	'wikiafollowedpages-following' => 'Vixiando',
	'wikiafollowedpages-special-title-userbar' => 'Páxinas vixiadas',
	'tog-enotiffollowedpages' => 'Enviádeme unha mensaxe de correo electrónico cando unha páxina da miña lista de vixilancia cambie',
	'tog-enotiffollowedminoredits' => 'Enviádeme unha mensaxe de correo electrónico cando fagan unha edición pequena nalgunha páxina que vixío',
	'wikiafollowedpages-prefs-advanced' => 'Opcións avanzadas',
	'wikiafollowedpages-prefs-watchlist' => '[[Special:Watchlist|Lista de vixilancia]] só',
	'tog-hidefollowedpages' => 'Facer privada a miña lista de vixilancia',
	'follow-categoryadd-summary' => 'Páxina engadida á categoría',
	'follow-bloglisting-summary' => 'Blogue publicado na páxina do blogue',
	'wikiafollowedpages-userpage-heading' => 'Páxinas que vixío',
	'wikiafollowedpages-userpage-more' => 'Máis',
	'wikiafollowedpages-userpage-hide' => 'agochar',
	'wikiafollowedpages-userpage-empty' => 'A lista de vixilancia deste usuario está baleira.
Engada páxinas a esta lista premendo no botón "{{int:watch}}" que aparecerá na parte superior das páxinas.',
	'enotif_subject_categoryadd' => '$PAGEEDITOR engadiu a páxina "$PAGETITLE" de {{SITENAME}} a $CATEGORYNAME',
	'enotif_body_categoryadd' => 'Estimado $WATCHINGUSERNAME:

Engadiron unha páxina a unha categoría que vixía en {{SITENAME}}.

Olle "$PAGETITLE_URL" para ver a nova páxina.

Volva e edite a miúdo...

{{SITENAME}}

___________________________________________
* Visite os nosos wikis destacados! http://www.wikia.com

* Quere controlar os correos que lle chegan?
Vaia a: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>
Estimado $WATCHINGUSERNAME:
<br /><br />
Engadiron unha páxina a unha categoría que vixía en {{SITENAME}}.
<br /><br />
Olle <a href="$PAGETITLE_URL">$PAGETITLE</a> para ver a nova páxina.
<br /><br />
Volva e edite a miúdo...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Visite os nosos wikis destacados!</a></li>
<li>Quere controlar os correos que lle chegan? Vaia ás <a href="{{fullurl:{{ns:special}}:Preferences}}">preferencias de usuario</a></li>
</ul>
</p>',
	'enotif_subject_blogpost' => '$PAGEEDITOR publicou a páxina "$PAGETITLE" de {{SITENAME}} en $BLOGLISTINGNAME',
	'enotif_body_blogpost' => 'Estimado $WATCHINGUSERNAME:

Fixeron unha edición nunha das páxinas da lista de bloques que vixía en {{SITENAME}}.

Olle "$PAGETITLE_URL" para ver a nova entrada.

Volva e edite a miúdo...

{{SITENAME}}

___________________________________________
* Visite os nosos wikis destacados! http://www.wikia.com

* Quere controlar os correos que lle chegan?
Vaia a: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Estimado $WATCHINGUSERNAME:
<br /><br />
Fixeron unha edición nunha das páxinas da lista de bloques que vixía en {{SITENAME}}.
<br /><br />
Olle <a href="$PAGETITLE_URL">$PAGETITLE</a> para ver a nova entrada.
<br /><br />
Volva e edite a miúdo...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Visite os nosos wikis destacados!</a></li>
<li>Quere controlar os correos que lle chegan? Vaia ás <a href="{{fullurl:{{ns:special}}:Preferences}}">preferencias de usuario</a></li>
</ul>
</p>',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'follow-desc' => 'Meliorationes pro le functionalitate del observatorio',
	'wikiafollowedpages-special-heading-category' => 'Categorias ($1)',
	'wikiafollowedpages-special-heading-article' => 'Articulos ($1)',
	'wikiafollowedpages-special-heading-blogs' => 'Blogs e articulos ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Filos de discussion in foros ($1)',
	'wikiafollowedpages-special-heading-project' => 'Paginas de projecto ($1)',
	'wikiafollowedpages-special-heading-user' => 'Paginas de usator ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Paginas de patronos ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'Paginas de MediaWiki ($1)',
	'wikiafollowedpages-special-heading-media' => 'Imagines e videos ($1)',
	'wikiafollowedpages-special-namespace' => '(pagina $1)',
	'wikiafollowedpages-special-empty' => 'Le lista de paginas sub observation de iste usator es vacue.
Adde paginas a iste lista cliccante super "Observar" in alto de un pagina.',
	'wikiafollowedpages-special-anon' => 'Per favor [[Special:Signup|aperi un session]] pro crear e vider tu lista de paginas sub observation.',
	'wikiafollowedpages-special-showall' => 'Monstrar toto',
	'wikiafollowedpages-special-title' => 'Paginas sub observation',
	'wikiafollowedpages-special-delete-tooltip' => 'Remover iste pagina',
	'wikiafollowedpages-special-hidden' => 'Iste {{GENDER:$1|usator|usatrice|usator}} ha optate pro absconder su lista de paginas sub observation al vista del publico.',
	'wikiafollowedpages-special-hidden-unhide' => 'Revelar iste lista.',
	'wikiafollowedpages-special-blog-by' => 'per $1',
	'wikiafollowedpages-masthead' => 'Paginas sub observation',
	'wikiafollowedpages-following' => 'Sub observation',
	'wikiafollowedpages-special-title-userbar' => 'Paginas sub observation',
	'tog-enotiffollowedpages' => 'Notificar me via e-mail quando un pagina que io observa es modificate',
	'tog-enotiffollowedminoredits' => 'Notificar me via e-mail de minor modificationes a paginas que io observa',
	'wikiafollowedpages-prefs-advanced' => 'Optiones avantiate',
	'wikiafollowedpages-prefs-watchlist' => '[[Special:Watchlist|Observatorio]] solmente',
	'tog-hidefollowedpages' => 'Render mi listas de paginas sub observation private',
	'follow-categoryadd-summary' => 'Pagina addite a categoria',
	'follow-bloglisting-summary' => 'Articulo publicate in pagina de blog',
	'wikiafollowedpages-userpage-heading' => 'Paginas que io observa',
	'wikiafollowedpages-userpage-more' => 'Plus',
	'wikiafollowedpages-userpage-hide' => 'celar',
	'wikiafollowedpages-userpage-empty' => 'Le lista de paginas sub observation de iste usator es vacue.
Adde paginas a iste lista cliccante super "Observar" in alto de un pagina.',
	'enotif_subject_categoryadd' => 'Le pagina $PAGETITLE de {{SITENAME}} ha essite addite a $CATEGORYNAME per $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Car $WATCHINGUSERNAME,

Un pagina ha essite addite a un categoria que tu observa in {{SITENAME}}.

Vide "$PAGETITLE_URL" pro le nove pagina.

Per favor visita e modifica frequentemente...

{{SITENAME}}

___________________________________________
* Reguarda nostre wikis in evidentia! http://www.wikia.com

* Vole determinar qual e-mails tu recipe?
Visita: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>
Car $WATCHINGUSERNAME,
<br /><br />
Un pagina ha essite addite a un categoria que tu observa in {{SITENAME}}.
<br /><br />
Vide <a href="$PAGETITLE_URL">$PAGETITLE</a> pro le nove pagina.
<br /><br />
Per favor visita e modifica frequentemente...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Reguarda nostre wikis in evidentia!</a></li>
<li>Vole determinar qual e-mails tu recipe? Visita <a href="{{fullurl:{{ns:special}}:Preferences}}">Preferentias de usator</a></li>
</ul>
</p>',
	'enotif_subject_blogpost' => 'Le pagina $PAGETITLE de {{SITENAME}} ha essite publicate in $BLOGLISTINGNAME per $PAGEEDITOR',
	'enotif_body_blogpost' => 'Car $WATCHINGUSERNAME,

Il ha un modification in un pagina de lista de blog que tu observa in {{SITENAME}}.

Vide "$PAGETITLE_URL" pro le nove articulo.

Per favor visita e modifica frequentemente...

{{SITENAME}}

___________________________________________
* Reguarda nostre wikis in evidentia! http://www.wikia.com

* Vole determinar qual e-mails tu recipe?
Visita: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Car $WATCHINGUSERNAME,
<br /><br />
Il ha un modification in un pagina de lista de blog que tu observa in {{SITENAME}}.
<br /><br />
Vide <a href="$PAGETITLE_URL">$PAGETITLE</a> pro le nove articulo.
<br /><br />
Per favor visita e modifica frequentemente...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Reguarda nostre wikis in evidentia!</a></li>
<li>Vole determinar qual e-mails tu recipe? Visita <a href="{{fullurl:{{ns:special}}:Preferences}}">Preferentias de usator</a></li>
</ul>
</p>',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'follow-desc' => 'Perbaharuan untuk fungsi daftar pantauan',
	'wikiafollowedpages-special-heading-category' => '($1) Kategori',
	'wikiafollowedpages-special-heading-article' => '($1) Artikel',
	'wikiafollowedpages-special-heading-blogs' => '($1) Blog dan posting',
	'wikiafollowedpages-special-heading-forum' => '($1) untaian Forum',
	'wikiafollowedpages-special-heading-project' => '($1) Halaman proyek',
	'wikiafollowedpages-special-heading-user' => '($1) Halaman pengguna',
	'wikiafollowedpages-special-heading-templates' => '($1) Halaman templat',
	'wikiafollowedpages-special-heading-mediawiki' => '($1) Halaman MediaWiki',
	'wikiafollowedpages-special-heading-media' => '($1) Berkas dan video',
	'wikiafollowedpages-special-namespace' => '($1 halaman)',
	'wikiafollowedpages-special-blog-by' => 'oleh $1',
	'wikiafollowedpages-userpage-hide' => 'sembunyikan',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'follow-desc' => 'Verbesserunge vun der Iwwerwaachungslëscht',
	'wikiafollowedpages-special-heading-category' => 'Kategorien ($1)',
	'wikiafollowedpages-special-heading-article' => 'Artikelen ($1)',
	'wikiafollowedpages-special-heading-project' => 'Projetssäiten ($1)',
	'wikiafollowedpages-special-heading-user' => 'Benotzersäiten ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Schabloune-Säiten ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'MediaWiki-Säiten ($1)',
	'wikiafollowedpages-special-heading-media' => 'Biller a Videoen ($1)',
	'wikiafollowedpages-special-namespace' => '($1-Säit)',
	'wikiafollowedpages-special-showall' => 'All weisen',
	'wikiafollowedpages-special-title' => 'Iwwerwaachte Säiten',
	'wikiafollowedpages-special-delete-tooltip' => 'Dës Säit ewechhuelen',
	'wikiafollowedpages-special-hidden-unhide' => 'Dës Lëscht net méi verstoppen.',
	'wikiafollowedpages-masthead' => 'Iwwerwaachte Säiten',
	'wikiafollowedpages-special-title-userbar' => 'Iwwerwaachte Säiten',
	'wikiafollowedpages-prefs-advanced' => 'Erweidert Optiounen',
	'follow-categoryadd-summary' => "Säit gouf bäi d'Kategorie derbäigesat",
	'wikiafollowedpages-userpage-heading' => 'Säiten, déi ech iwwerwaachen',
	'wikiafollowedpages-userpage-more' => 'Méi',
	'wikiafollowedpages-userpage-hide' => 'verstoppen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'follow-desc' => 'Збогатени можности на списокот на набљудувања',
	'wikiafollowedpages-special-heading-category' => 'Категории ($1)',
	'wikiafollowedpages-special-heading-article' => 'Статии ($1)',
	'wikiafollowedpages-special-heading-blogs' => 'Блогови и написи ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Форумски разговори ($1)',
	'wikiafollowedpages-special-heading-project' => 'Проектни страници ($1)',
	'wikiafollowedpages-special-heading-user' => 'Кориснички страници ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Шаблонски страници ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'МедијаВики-страници ($1)',
	'wikiafollowedpages-special-heading-media' => 'Слики и видеоснимки ($1)',
	'wikiafollowedpages-special-namespace' => '($1 страница)',
	'wikiafollowedpages-special-empty' => 'Списокот на следени страници на овој корисник е празен.
Додавајте страници на списокот со стискање на „Следи“ на врвот од страницата.',
	'wikiafollowedpages-special-anon' => '[[Special:Signup|Најавете се]] за да создадете или прегледате ваш список на следени страници.',
	'wikiafollowedpages-special-showall' => 'Прикажи сè',
	'wikiafollowedpages-special-title' => 'Следени страници',
	'wikiafollowedpages-special-delete-tooltip' => 'Отстранување на оваа страница',
	'wikiafollowedpages-special-hidden' => 'Овој корисник решил да го скрие {{GENDER:$1|неговиот|неговиот|неговиот}} список на следени страници.',
	'wikiafollowedpages-special-hidden-unhide' => 'Прикажи го списоков.',
	'wikiafollowedpages-special-blog-by' => 'од $1',
	'wikiafollowedpages-masthead' => 'Следени страници',
	'wikiafollowedpages-following' => 'Следени',
	'wikiafollowedpages-special-title-userbar' => 'Следени страници',
	'tog-enotiffollowedpages' => 'Извести ме по е-пошта кога ќе се измени страница што ја следам',
	'tog-enotiffollowedminoredits' => 'Известувај ме по е-пошта за ситни промени во страниците што ги следам',
	'wikiafollowedpages-prefs-advanced' => 'Напредни нагодувања',
	'wikiafollowedpages-prefs-watchlist' => 'Само [[Special:Watchlist|Списокот на набљудувања]]',
	'tog-hidefollowedpages' => 'Сокриј ги од други корисници моите списоци на следени страници',
	'follow-categoryadd-summary' => 'Страницата е додадена во категоријата',
	'follow-bloglisting-summary' => 'Блогот е објавен на страницата за блогови',
	'wikiafollowedpages-userpage-heading' => 'Страници што ги следам',
	'wikiafollowedpages-userpage-more' => 'Повеќе',
	'wikiafollowedpages-userpage-hide' => 'сокриј',
	'wikiafollowedpages-userpage-empty' => 'Списокот на следени страници на овој корисник е празен.
Додавајте страници на списокот со стискање на „Следи“ на врвот од страницата.',
	'enotif_subject_categoryadd' => 'Страницата $PAGETITLE на {{SITENAME}} е додадена во $CATEGORYNAME од $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Почитуван/а $WATCHINGUSERNAME,

Во категоријата што ја следите на {{SITENAME}} е додадена страница.

Погледајте ја новата страница на „$PAGETITLE_URL“.

Посетувајте нè и уредувајте често...

{{SITENAME}}

___________________________________________
* Погледајте ги одбраните викија! http://www.wikia.com

* Сакате да изберете кои пораки ги добивате по е-пошта?
Одете на: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>
Драг/а $WATCHINGUSERNAME,
<br /><br />
Во категоријата што ја следите на {{SITENAME}} е додадена страница.
<br /><br />
Погледајте ја новата страница на <a href="$PAGETITLE_URL">$PAGETITLE</a>.
<br /><br />
Посетувајте нè и уредувајте често...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Погледајте ги одбраните викија!</a></li>
<li>Сакате да изберете кои пораки ги добивате по е-пошта? Одете на <a href="{{fullurl:{{ns:special}}:Preferences}}">Корисничките нагодувања</a></li>
</ul>
</p>',
	'enotif_subject_blogpost' => 'Страницата $PAGETITLE на {{SITENAME}} е објавена на $BLOGLISTINGNAME од $PAGEEDITOR',
	'enotif_body_blogpost' => 'Драг/а $WATCHINGUSERNAME,

На страницата со блогови што ја следите на {{SITENAME}} има ново уредување.

Погледајте го новиот запис на „$PAGETITLE_URL“.

Посетувајте нè и уредувајте често...

{{SITENAME}}

___________________________________________
* Погледајте ги одбраните викија! http://www.wikia.com

* Сакате да изберете кои пораки ги добивате по е-пошта?
Одете на: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Драг/а $WATCHINGUSERNAME,
<br /><br />
На страницата со блогови што ја следите на {{SITENAME}} има ново уредување.
<br /><br />
Погледајте го новиот запис на <a href="$PAGETITLE_URL">$PAGETITLE</a>.
<br /><br />
Посетувајте нè и уредувајте често...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Погледајте ги одбраните викија!</a></li>
<li>Сакате да изберете кои пораки ги добивате по е-пошта? Одете на <a href="{{fullurl:{{ns:special}}:Preferences}}">Корисничките нагодувања</a></li>
</ul>
</p>',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'follow-desc' => 'Verbeteringen voor de volglijstfunctie',
	'wikiafollowedpages-special-heading-category' => 'Categorieën ($1)',
	'wikiafollowedpages-special-heading-article' => "Inhoudspagina's ($1)",
	'wikiafollowedpages-special-heading-blogs' => 'Blogs en blogberichten ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Forumberichten ($1)',
	'wikiafollowedpages-special-heading-project' => "Projectpagina's ($1)",
	'wikiafollowedpages-special-heading-user' => "Gebruikerspagina's ($1)",
	'wikiafollowedpages-special-heading-templates' => "Sjabloonpagina's ($1)",
	'wikiafollowedpages-special-heading-mediawiki' => "MediaWiki-pagina's ($1)",
	'wikiafollowedpages-special-heading-media' => "Afbeeldingen en video's ($1)",
	'wikiafollowedpages-special-namespace' => '($1 pagina)',
	'wikiafollowedpages-special-empty' => 'De volglijst van deze gebruiker is leeg.
Voeg pagina\'s toe aan deze lijst door te klikken op "Volgen" bovenaan pagina\'s.',
	'wikiafollowedpages-special-anon' => '[[Special:Signup|Meld u aan]] om uw volglijst te bewerken of te bekijken.',
	'wikiafollowedpages-special-showall' => 'Allemaal weergeven',
	'wikiafollowedpages-special-title' => "Pagina's op volglijst",
	'wikiafollowedpages-special-delete-tooltip' => 'Deze pagina verwijderen',
	'wikiafollowedpages-special-hidden' => 'Deze gebruiker wil {{GENDER:$1|zijn|haar}} volglijst niet publiek maken.',
	'wikiafollowedpages-special-hidden-unhide' => 'Deze lijst zichtbaar maken.',
	'wikiafollowedpages-special-blog-by' => 'door $1',
	'wikiafollowedpages-masthead' => "Pagina's op volglijst",
	'wikiafollowedpages-following' => "Gevolgde pagina's",
	'wikiafollowedpages-special-title-userbar' => "Pagina's op volglijst",
	'tog-enotiffollowedpages' => 'Mij e-mailen als een pagina op mijn volglijst wijzigt',
	'tog-enotiffollowedminoredits' => 'Mij e-mailen bij kleine bewerkingen van pagina’s op mijn volglijst',
	'wikiafollowedpages-prefs-advanced' => 'Gevorderde instellingen',
	'wikiafollowedpages-prefs-watchlist' => 'Alleen [[Special:Watchlist|volglijst]]',
	'tog-hidefollowedpages' => "Pagina's op mijn volglijst niet publiek maken",
	'follow-categoryadd-summary' => 'Pagina aan een categorie toegevoegd',
	'follow-bloglisting-summary' => 'Blogbericht toegevoegd aan blogpagina',
	'wikiafollowedpages-userpage-heading' => "Pagina's op mijn volglijst",
	'wikiafollowedpages-userpage-more' => 'Meer',
	'wikiafollowedpages-userpage-hide' => 'verbergen',
	'wikiafollowedpages-userpage-empty' => 'Deze gebruiker volgt geen pagina\'s.
Voeg pagina\'s aan deze lijst toe door op "{{int:watch}}" te klikken bovenaan een pagina.',
	'enotif_subject_categoryadd' => 'Pagina $PAGETITLE is op {{SITENAME}} toegevoegd aan $CATEGORYNAME door $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Beste $WATCHINGUSERNAME,

Er is een pagina is toegevoegd aan een categorie die u volgt op {{SITENAME}}.

Zie "$PAGETITLE_URL" voor de nieuwe pagina.

Kom alstublieft vaak langs om bewerkingen te maken...

{{SITENAME}}

___________________________________________ 
* Kom kijken op onze uitgelichte wiki\'s! http://www.wikia.com 

 * Wilt u bepalen welke e-mails u ontvangt? 
Ga naar: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>
Beste $WATCHINGUSERNAME,
<br /><br />
Er is een pagina is toegevoegd aan een categorie die u volgt op {{SITENAME}}.
<br /><br />
Zie <a href="$PAGETITLE_URL">$PAGETITLE</a> voor de nieuwe pagina.
<br /><br />
Kom alstublieft vaak langs om bewerkingen te maken...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Kom kijken op onze uitgelichte wiki\'s</a></li>
<li>Wilt u bepalen welke e-mails u ontvangt? Ga naar uw <a href="{{fullurl:{{ns:special}}:Preferences}}">gebruikersvoorkeuren</a>.</li>
</ul>
</p>',
	'enotif_subject_blogpost' => 'Pagina $PAGETITLE op {{SITENAME}} is gemaakt op $BLOGLISTINGNAME door $PAGEEDITOR',
	'enotif_body_blogpost' => 'Beste $WATCHINGUSERNAME,

Er is een bewerking gemaakt aan een blog die u volgt op {{SITENAME}}.

Zie "$PAGETITLE_URL" voor het nieuwe blogbericht.

Kom alstublieft vaak langs om bewerkingen te maken...

{{SITENAME}}

___________________________________________ 
* Kom kijken op onze uitgelichte wiki\'s! http://www.wikia.com 

 * Wilt u bepalen welke e-mails u ontvangt?
Ga naar: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Beste $WATCHINGUSERNAME,
<br /><br />
Er is een bewerking gemaakt aan een blog die u volgt op {{SITENAME}}.
<br /><br />
Zie <a href="$PAGETITLE_URL">$PAGETITLE</a> voor het nieuwe blogbericht.
<br /><br />
Kom alstublieft vaak langs om bewerkingen te maken...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Kom kijken op onze uitgelichte wiki\'s</a></li>
<li>Wilt u bepalen welke e-mails u ontvangt? Ga naar uw <a href="{{fullurl:{{ns:special}}:Preferences}}">gebruikersvoorkeuren</a>.</li>
</ul>
</p>',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'follow-desc' => 'Forbedringer for overvåkningslistens funksjonalitet',
	'wikiafollowedpages-special-heading-category' => 'Kategorier ($1)',
	'wikiafollowedpages-special-heading-article' => 'Artikler ($1)',
	'wikiafollowedpages-special-heading-blogs' => 'Blogger og innlegg ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Forumtråder ($1)',
	'wikiafollowedpages-special-heading-project' => 'Prosjektsider ($1)',
	'wikiafollowedpages-special-heading-user' => 'Brukersider ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Maler ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'MediaWiki-sider ($1)',
	'wikiafollowedpages-special-heading-media' => 'Bilder og videoer ($1)',
	'wikiafollowedpages-special-namespace' => '($1-side)',
	'wikiafollowedpages-special-empty' => 'Denne brukerens liste over fulgte sider er tom.
Legg til sider i listen ved å trykke «Følg» øverst på siden.',
	'wikiafollowedpages-special-anon' => 'Vennligst [[Special:Signup|logg inn]] for å opprette eller vise din liste over fulgte sider.',
	'wikiafollowedpages-special-showall' => 'Vis alle',
	'wikiafollowedpages-special-title' => 'Fulgte sider',
	'wikiafollowedpages-special-delete-tooltip' => 'Fjern denne siden',
	'wikiafollowedpages-special-hidden' => 'Denne brukeren har valgt å skjule listen over fulgte sider for offentlig visning.',
	'wikiafollowedpages-special-hidden-unhide' => 'Vis denne listen.',
	'wikiafollowedpages-special-blog-by' => 'av $1',
	'wikiafollowedpages-masthead' => 'Fulgte sider',
	'wikiafollowedpages-following' => 'Følger',
	'wikiafollowedpages-special-title-userbar' => 'Fulgte sider',
	'tog-enotiffollowedpages' => 'Send meg en e-post når en side jeg følger blir redigert',
	'tog-enotiffollowedminoredits' => 'Send meg en e-post for mindre endringer på sider jeg følger',
	'wikiafollowedpages-prefs-advanced' => 'Avanserte innstillinger',
	'wikiafollowedpages-prefs-watchlist' => 'Kun [[Special:Watchlist|overvåkningsliste]]',
	'tog-hidefollowedpages' => 'Gjør min liste over fulgte sider privat',
	'follow-categoryadd-summary' => 'Side lagt til kategori',
	'follow-bloglisting-summary' => 'Blogg lagt ut på bloggsiden',
	'wikiafollowedpages-userpage-heading' => 'Sider jeg følger',
	'wikiafollowedpages-userpage-more' => 'Mer',
	'wikiafollowedpages-userpage-hide' => 'skjul',
	'wikiafollowedpages-userpage-empty' => 'Denne brukerens liste over fulgte sider er tom.
Legg til sider i listen ved å trykke «Følg» øverst på siden.',
	'enotif_subject_categoryadd' => '{{SITENAME}}-siden $PAGETITLE har blitt lagt til $CATEGORYNAME av $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Kjære $WATCHINGUSERNAME,

En side har blitt lagt til i en kategori du følger på {{SITENAME}}.

Se «$PAGETITLE_URL» for den nye siden.

Vennligst kom på besøk og rediger ofte...

{{SITENAME}}

___________________________________________
* Sjekk ut våre utvalgte wikier! http://www.wikia.com

* Vil du kontrollere hva slags e-post du får?
Gå til: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>
Kjære $WATCHINGUSERNAME,
<br /><br />
En side har blitt lagt til i en kategori du følger på {{SITENAME}}.
<br /><br />
Se <a href="$PAGETITLE_URL">$PAGETITLE</a> for den nye siden.
<br /><br />
Vennligst kom på besøk og rediger ofte...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Sjekk ut våre utvalgte wikier!</a></li>
<li>Vil du kontrollere hva slags e-post du får? Gå til <a href="{{fullurl:{{ns:special}}:Preferences}}">Brukerinnstillinger</a></li>
</ul>
</p>',
	'enotif_subject_blogpost' => '{{SITENAME}}-siden $PAGETITLE har blitt postet i $BLOGLISTINGNAME av $PAGEEDITOR',
	'enotif_body_blogpost' => 'Kjære $WATCHINGUSERNAME,

En bloggoppføring du følger på {{SITENAME}} har blitt redigert.

Se «$PAGETITLE_URL» for det nye innlegget.

Vennligst kom på besøk og rediger ofte...

{{SITENAME}}

___________________________________________
* Sjekk ut våre utvalgte wikier! http://www.wikia.com

* Vil du kontrollere hva slags e-post du får?
Gå til: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Kjære $WATCHINGUSERNAME,
<br /><br />
En bloggoppføring du følger på {{SITENAME}} har blitt redigert.
<br /><br />
Se <a href="$PAGETITLE_URL">$PAGETITLE</a> for det nye innlegget.
<br /><br />
Vennligst kom på besøk og rediger ofte...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Sjekk ut våre utvalgte wikier!</a></li>
<li>Vil du kontrollere hva slags e-post du får? Gå til <a href="{{fullurl:{{ns:special}}:Preferences}}">Brukerinnstillinger</a></li>
</ul>
</p>',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wikiafollowedpages-special-showall' => 'ټول ښکاره کول',
	'wikiafollowedpages-userpage-heading' => 'هغه مخونه چې زه يې څارم',
	'wikiafollowedpages-userpage-more' => 'نور',
	'wikiafollowedpages-userpage-hide' => 'پټول',
);

/** Russian (Русский)
 * @author Eleferen
 * @author G0rn
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'follow-desc' => 'Улучшения для функциональности списка наблюдения',
	'wikiafollowedpages-special-heading-category' => 'Категории ($1)',
	'wikiafollowedpages-special-heading-article' => 'Статьи ($1)',
	'wikiafollowedpages-special-heading-blogs' => 'Блоги и сообщения ($1)',
	'wikiafollowedpages-special-heading-forum' => 'Темы форумов ($1)',
	'wikiafollowedpages-special-heading-project' => 'Страницы проектов ($1)',
	'wikiafollowedpages-special-heading-user' => 'Страницы участников ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Шаблоны ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'Страницы MediaWiki ($1)',
	'wikiafollowedpages-special-heading-media' => 'Изображения и видео ($1)',
	'wikiafollowedpages-special-namespace' => '($1 cтраница)',
	'wikiafollowedpages-special-empty' => 'Список отслеживаемых этим пользователем статей пуст.
Для добавления страниц в этот список нажмите «{{int:watch}}» наверху этой страницы.',
	'wikiafollowedpages-special-anon' => 'Пожалуйста, [[Special:Signup|представьтесь]] для создания или просмотра своего списка отслеживаемых страниц.',
	'wikiafollowedpages-special-showall' => 'Показать всё',
	'wikiafollowedpages-special-title' => 'Отслеживаемые страницы',
	'wikiafollowedpages-special-delete-tooltip' => 'Удалить эту страницу',
	'wikiafollowedpages-special-hidden' => '{{GENDER:$1|Это участник предпочёл|Эта участница предпочла}} скрыть свой список отслеживаемых страниц от публичного просмотра.',
	'wikiafollowedpages-special-hidden-unhide' => 'Показать этот список.',
	'wikiafollowedpages-special-blog-by' => 'от $1',
	'wikiafollowedpages-masthead' => 'Отслеживаемые страницы',
	'wikiafollowedpages-following' => 'Отслеживание',
	'wikiafollowedpages-special-title-userbar' => 'Отслеживаемые страницы',
	'tog-enotiffollowedpages' => 'Уведомлять по эл. почте об изменениях страниц, которые я отслеживаю',
	'tog-enotiffollowedminoredits' => 'Уведомлять меня по эл. почте о малых правках в страницах, которые я отслеживаю',
	'wikiafollowedpages-prefs-advanced' => 'Расширенные настройки',
	'wikiafollowedpages-prefs-watchlist' => 'Только [[Special:Watchlist|список наблюдения]]',
	'tog-hidefollowedpages' => 'Спрятать мой список отслеживаемых страниц от публичного просмотра',
	'follow-categoryadd-summary' => 'Страница добавлена в категорию',
	'follow-bloglisting-summary' => 'Блог опубликован на странице блога',
	'wikiafollowedpages-userpage-heading' => 'Страницы, которые я отслеживаю',
	'wikiafollowedpages-userpage-more' => 'Ещё',
	'wikiafollowedpages-userpage-hide' => 'скрыть',
	'wikiafollowedpages-userpage-empty' => 'Список отслеживаемых этим пользователем статей пуст.
Для добавления страниц в этот список нажмите «{{int:watch}}» наверху этой страницы.',
	'enotif_subject_categoryadd' => 'Страница проекта «{{SITENAME}}» $PAGETITLE была добавлена в категорию $CATEGORYNAME участником $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Уважаемый $WATCHINGUSERNAME,
страница была добавлена в категорию, которую Вы отслеживаете в проекте «{{SITENAME}}».

Ознакомьтесь с новой страницей по адресу: $PAGETITLE_URL

Пожалуйста, посещайте и редактируйте часто…

{{SITENAME}}

___________________________________________ 
* Посмотрите наши избранные вики! http://wikia.com

* Хотите изменить параметры уведомления по электронной почте?
Пройдите по ссылке: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_categoryadd-html' => '<p>Уважаемый $WATCHINGUSERNAME,
<br /><br />
страница была добавлена в категорию, которую Вы отслеживаете в проекте «{{SITENAME}}».
<br /><br />
Ознакомьтесь с новой страницей по адресу: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Пожалуйста, посещайте и редактируйте часто…
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Посмотрите наши избранные вики!</a>
<li>Хотите изменить параметры уведомления по электронной почте?
Пройдите в <a href="{{fullurl:{{ns:special}}:Preferences}}">настройки участника</a>.
</ul>
</p>',
	'enotif_subject_blogpost' => 'Страница $PAGETITLE проекта «{{SITENAME}}» была размещена в $BLOGLISTINGNAME участником $PAGEEDITOR',
	'enotif_body_blogpost' => 'Уважаемый $WATCHINGUSERNAME,
В проекте «{{SITENAME}}» была совершена правка на странице списка блогов, которую вы отслеживаете.

Ознакомьтесь с изменением по адресу: $PAGETITLE_URL

Пожалуйста, посещайте и редактируйте часто…

{{SITENAME}}

___________________________________________
* Посмотрите наши избранные вики! http://wikia.com

* Хотите изменить параметры уведомления по электронной почте?
Пройдите по ссылке: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Уважаемый $WATCHINGUSERNAME,
<br /><br />
В проекте «{{SITENAME}}» была совершена правка на странице списка блогов, которую вы отслеживаете.
<br /><br />
Ознакомьтесь с изменением по адресу: <a href="$PAGETITLE_URL">$PAGETITLE</a>.
<br /><br />
Пожалуйста, посещайте и редактируйте часто…
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Посмотрите наши избранные вики!</a>
<li>Хотите изменить параметры уведомления по электронной почте?
Пройдите в <a href="{{fullurl:{{ns:special}}:Preferences}}">настройки участника</a>.
</ul>
</p>',
);

