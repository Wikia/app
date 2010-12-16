<?php
/**
 * Translations of Translate extension.
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$messages = array();

/** English
 * @author Nike
 * @author Siebrand
 */
$messages['en'] = array(
	'translate-fs-pagetitle-done' => ' - done!',
	'translate-fs-pagetitle' => 'Steps to translator - $1',
	'translate-fs-signup-title' => 'Sign up',
	'translate-fs-settings-title' => 'Configure your preferences',
	'translate-fs-userpage-title' => 'Create user page for yourself',
	'translate-fs-permissions-title' => 'Request permissions',
	'translate-fs-target-title' => 'Start translating!',
	'translate-fs-email-title' => 'Confirm your e-mail address',
	
	'translate-fs-intro' => "Welcome to the {{SITENAME}} first steps wizard.
You will be guided trough the process of becoming a translator step by step.
In the end you will be able to translate ''interface messages'' of all supported projects at {{SITENAME}}.",

	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

In the first step you must sign up.

Credits for your translations are attributed to your user name.
The image on the right shows how to fill the fields.

If you have already signed up, $1log in$2 instead.
Once you are signed up, please return to this page.

$3Sign up$4',
	'translate-fs-settings-text' => 'You should now go to your preferences and
at least change your interface language to the language you are going to translate to.

Your interface languages is used as the default target language.
It is easy to forget to change the langauge to the correct one, so setting it now is higly recommended.

While you are there, you can also request the software to display translations in other languages you know.
This setting can be found under {{int:prefs-editing}} tab.
Feel free to explore other settings too.

Go to your [[Special:Preferences|preferences page]] now and then return back to this page.',
	'translate-fs-settings-skip' => "I'm done. Let me proceed.",
	'translate-fs-userpage-text' => 'Now you need to create an user page.

Please tell something about yourself, who you are and what you do.
This will help {{SITENAME}} community to work together.
In {{SITENAME}} there are people all around the world doing different things.

In the prefilled box above in the very first line there is <nowiki>{{#babel:en-2}}</nowiki>.
You should fill it accordingly to your language knowledge.
The number behind the language code describes how well you know the language.
The alternatives are:
* 0 not at all
* 1 little
* 2 basic
* 3 good
* 4 like a native speaker
* 5 you use the language professionally, for example you are a professional translator.

If you are a native speaker of a language, leave the number away.
Example: if you speak Tamil natively, good English and little Swahili, you would write:
<tt><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></tt>

If you do not know the language code of a language, now is good time to check it up. You can use the list below.',
	'translate-fs-userpage-submit' => 'Create my userpage',
	'translate-fs-userpage-done' => 'Well done! You now have an userpage.',
	'translate-fs-permissions-text' => 'Now you need to place a request to be added to the translator group.

Until we fix the code, please go to [[Project:Translator]] and follow the instructions.
Then come back to this page.

After you have filed your request, one of the volunteer staff member will check your request and approve it as soon as possible.
Please be patient.

<del>Check that the following request is correctly filled and then press the request button.</del>',

	'translate-fs-target-text' => 'Congratulations!
You can now start translating.

Don\'t be afraid if still feels confusing.
At [[Project list]] there is an overview of what you can translate.
Most of the projects have a short description page with \'\'Translate this project\'\' link,
that will take you to a page which lists all untranslated messages.
The list of all projects is at [[Special:Translate]].

If you feel that you need to understand more before you start translating,
you can read [[FAQ|Frequently asked questions]].
Unfortanely we do not currently have good documentation.
If there is something that you can\'t find answer for,
don\'t hesitate to ask it at [[Support]].

You can also try to seek help of fellow translators that speak the same language at [[Portal:$1]]
(change the language code if it is incorrect).',

	'translate-fs-email-text' => 'You should add e-mail to your preferences and confirm it.

This helps us to contact you.
You also receive newsletters at most once a month.
If you don\'t want receive them, you can opt-out from your [[Special:Preferences]].',
);