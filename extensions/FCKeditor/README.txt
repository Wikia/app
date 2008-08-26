== Installation ==

This integration is mainly done by a dedicated MediaWiki extension. But, to better integration with MediaWiki, some of its code had to be "hacked", detailed instruction may be found here:
http://mediawiki.fckeditor.net/index.php/FCKeditor_integration_guide

== About the project ==

After several attempts to provide a WYSIWYG interface for MediaWiki, we at FCKeditor have decided starting a dedicated project for it, aiming to propose a definitive solution for it. 

The main criticism again such kind of integration is that rich text editors produce HTML code, and MediaWiki runs with Wikitext. We prioritized this problem when developing this prototype and our FCKeditor integration now produces Wikitext, satisfying this need. 
 
== Integration screenshot ==

So, to see it in action, just go to our Sandbox: http://mediawiki.fckeditor.net/index.php/Sandbox and start editing that page. 

== Integration status ==

We have created the first working prototype for this integration. It is still in the first stages, but shows the potential of it, and it’s actually fully usable. In any case, use it on production web sites at your own risk. 

The following features are currently available: 
* Rich editing: instead of writing inside a plain text area, using Wikitext markup for the text    * structure and formatting, you can use visual tools, which reflect the final output. 
* Easy table creation. 
* Easy link creation, including automated search for internal articles. 
* Easy image insertion, including automated search for uploaded image files. 
* Templates handling: a template icon is displayed in the editor so they can be easily edited or inserted, without impacting in the editing interface. 
* References are displayed as small icons, not disturbing the editing, making them easy to create and edit. 
* Formulas are rendered inside the editor, making it easy to edit them with a mouse click. 
* My preferences: the editor can be disable at "Editing > Disable rich editor". Also, if the editor is enabled, a new tab called "Rich editor" is available so you can disable it under specific namespaces. 

== Final notes ==

Take it easy! This is a prototype and it is expected to present undesired behaviors if bugs are forced to happen. Feel free to use the discussion space in this page to talk about it. 

=== Project future ===

As stated at the top of this page, at FCKeditor we have "started" coding this integration. We need help now to continue with it, as we are (and have to be) focused on FCKeditor. 

We are looking for help on coding it, so PHP and JavaScript developers are welcome.

