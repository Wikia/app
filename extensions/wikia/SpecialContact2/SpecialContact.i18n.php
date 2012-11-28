<?php
/**
 * Internationalisation file for SpecialContact extension.
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	/* special page */
	'contact' => 'Contact Wikia',
	'specialcontact-wikia' => 'Contact Wikia',
	'specialcontact-pagetitle' => 'Contact Wikia Support Staff',

	/* picker */
	'specialcontact-intro-main-head' => "<big>Need help? Don't worry, the Wikia community is here to help you!</big><br/>
Follow the links below to learn more about how to use Wikia, make changes to your wiki or modify your account.",
	'specialcontact-intro-main-local' => '', #(this is meant to be blank)
	'specialcontact-intro-main-foot' => "'''Does this page answer your question?''' If not, please feel free to [[Special:contact/general|contact us]] to discuss your issue further. Remember you can always check out our '''[[w:c:help|help pages]]''', [[w:c:community:Blog:Wikia_Staff_Blog|staff blog]]  or post on our '''[[w:c:community:Forum:Community_Central_Forum|community help forums]]'''. If you are looking for admin help and advice, stop by [[w:c:community:Admin_Central:Main_Page|Founder & Admin Central]].",

	
	'specialcontact-secheader-onwiki' => "Questions about this wiki",
		'specialcontact-seclink-content-issue' => "Issue with the wiki’s content",
		'specialcontact-seclink-user-conflict' => "Problem with another user?",
		'specialcontact-seclink-adoption' => "I want admin rights here",
		
	'specialcontact-secheader-account' => "Account changes",
		'specialcontact-seclink-account-issue' => "Can't access my account",
		'specialcontact-seclink-close-account' => "Disable my account",
		'specialcontact-seclink-rename-account' => "Rename my account",
		'specialcontact-seclink-blocked' => "My account is blocked",
		
	'specialcontact-secheader-editing' => "Participating on Wikia",
		'specialcontact-seclink-using-wikia' => "How do I use Wikia?",
		'specialcontact-seclink-feedback' => "I want to offer some feedback",
		'specialcontact-seclink-bug' => "I think I found a bug",
		'specialcontact-seclink-bad-ad' => "I see a broken or inappropriate ad",

	'specialcontact-secheader-setting' => "Changes to this wiki",
		'specialcontact-seclink-wiki-name-change' => "Sitename or URL",
		'specialcontact-seclink-design' => "Design",
		'specialcontact-seclink-features' => "Add or remove Features",
		'specialcontact-seclink-close-wiki' => "Close this wiki",

	/* titles (overrides normal page title) */
	'specialcontact-sectitle' => "Wikia Support - $1",
		'specialcontact-sectitle-general' => "Contact form",
		'specialcontact-sectitle-content-issue' => "Content issue",
		'specialcontact-sectitle-user-conflict' => "User interactions",
		'specialcontact-sectitle-adoption' => "Admin rights",
		
		'specialcontact-sectitle-account-issue' => "Account issue",
		'specialcontact-sectitle-close-account' => "Disable my account",
		'specialcontact-sectitle-rename-account' => "Rename my account",
		'specialcontact-sectitle-blocked' => "Account blocked",
		
		'specialcontact-sectitle-using-wikia' => "Using Wikia",
		'specialcontact-sectitle-feedback' => "Feedback",
		'specialcontact-sectitle-bug' => "Bug Report",
		'specialcontact-sectitle-bad-ad' => "Ad report",

		'specialcontact-sectitle-wiki-name-change' => "Wiki name change",
		'specialcontact-sectitle-design' => "Wiki design",
		'specialcontact-sectitle-features' => "Wiki features",
		'specialcontact-sectitle-close-wiki' => "Close this wiki",

	/* intros (message at top of page) */
	'specialcontact-intro-content-issue' => "The content on this wiki is created by the community here, and managed by the [[Special:ListAdmins|local admins]], not Wikia. If you wish to discuss this content, it is best to first contact the [[Special:ListAdmins|wiki's admins here]]. 

If you feel the content violates our [http://www.wikia.com/Terms_of_Use Terms of Use], you can contact Wikia staff directly [[Special:Contact/general|here]].",
	'specialcontact-intro-user-conflict' => "Wikis are community space where each and every person needs to work together with others for it to be successful. While working together conflicts can sometimes arise - and the best way to solve them is to have an open and respectful conversation on your wiki about the issue. 

If you need help, first contact your [[Special:ListAdmins|local admins]]. Admins are the local experts on the topic and community, so best to first chat with them further. If the admins are not able to help, or you feel the user is violating Wikia's [http://www.wikia.com/Terms_of_Use Terms of Use], you can contact Wikia staff directly [[Special:Contact/general|here]].

Happy editing!",
	'specialcontact-intro-adoption' => "Are you interested in becoming an admin here? If so, please first check if the [[Special:Listusers/sysop|local admins]] are active. If they are, leave them a message with your request. It is also a good idea to talk with fellow users about your request to gather their support. You may want to start by posting in your community forum. 

If the local admins are not active, you can submit a request for admin status. Please visit the [[w:c:adopt|adoption wiki]] for more information, including the adoption criteria and the request page. Please remember to always provide a link to the wiki you wish to adopt.

If there's an active user community on the wiki you wish to adopt, please start a discussion on the wiki about who would make the best admins, and why you would like to become one. Please provide a link to this discussion at the [[w:c:adopt|Adoption wiki]]. Best of luck and happy editing!

Happy editing!",
	
	'specialcontact-intro-account-issue' => "Sorry to hear you are having problems accessing your account. A couple of things to check:

*Remember account names are case sensitive
*Is your browser up-to-date?
*Have you confirmed your email address?
*Are you trying to log in via Facebook Connect? Be sure to follow the steps [[Help:Facebook_Connect|here]]. 
*Not able to create an account? It may be that you are not eligible for an account at this time. See [[w:c::wikia:Wikia:Terms_of_use#Membership|terms of use]] for more details.
*Lost your password? You can request a new password [[Special:Signup|here]] Once there, enter your username, and click the \"new password\" button. You will then receive an email with a new temporary password. You can use this to sign in and update your password to one of your choice. 

If you have done all of these and are still having an issue - please send us a detailed report below. We will get back to you as soon as possible to help fix the problem.


Happy editing!",
	'specialcontact-intro-close-account' => "We are sorry you want to disable your account. Wikia has many wikis on all sorts of subjects and we'd love for you to stick around and find the one that's right for you. If you are having a local problem with your wiki, please don't hesitate to contact your [[Special:Listusers/sysop|local admins]] for help and advice.

If you have decided you definitely want to disable your account please be aware that Wikia does not have the ability to fully remove accounts, but we can disable them. This will ensure the account is locked and can't be used. This process is NOT reversible, and you will have to create a new account if you wish to rejoin Wikia. However, this process will not remove your contributions from a given wiki as these contributions belong to the community as a whole.

If you need any more information on what an account disable actually does, you can visit our [[Help:Close_my_account|help page on disabling your account]]. To confirm and disable your account, please fill out the form below.",
	'specialcontact-intro-rename-account' => "Changing your username is possible on Wikia, but only once, so be sure you want to change it before you submit a request. This process cannot be reversed, and once we change your username, we cannot change it again. Please make sure you have fully read this help page before sending in a request: http://help.wikia.com/wiki/Help:Changing_your_username 

Once you have read that help page and are positive on the spelling of your new username, please submit a request below. Once your username is changed, you will receive a confirmation email. You can then log in with your new user name using your old password.

Happy editing!",
	'specialcontact-intro-blocked' => "Account blocks are usually set by the local admins, and not by Wikia. The name of the blocking admin should be on the block notice you received.You may be able to contact the blocking admin by leaving a message on your user talk page. This is still editable for blocked users (on some wikis) and changes will usually be seen by the other contributors to the wiki. Your user talk page is found by following the \"my talk\" link at the top right of any page.

However, if this talk page option is not available in your situation, then the best advice we can give you is to wait the block out or join the community at another of the many thousand Wikia wikis available. 

If you feel you still need to discuss this block further with Wikia staff, please contact us [[Special:Contact/general|here]].",
	
	'specialcontact-intro-using-wikia' => "Now that you are a part of the community, you are able to edit and contribute to almost any page across Wikia. For some introductory help, check out our [[Help:Getting_Started|help pages here]]. They are a great place to learn the basics of editing, formatting and much more. 

If you have questions about this specific wiki, start by [[Special:ListAdmins|contacting your local admins]]. 
You can also ask general questions to other community members on our [[w:c:community:Forum:Community_Central_Forum|community help forum]].

Remember, you can't break a wiki, so don't be afraid to get started. Happy editing!",
	'specialcontact-intro-feedback' => "Got feedback? We would love to hear it! Please provide your thoughts and details below. If you have feedback on a Wikia Labs product, please provide feedback [[Special:WikiaLabs|there]]. 

Thanks in advance and happy editing!",
	'specialcontact-intro-bug' => "We are sorry to hear that you found a bug on Wikia. Please provide full details of the issue you are seeing below so we can investigate further. Important details to include are:
*Your username
*Link to your wiki
*Your browser information including type and version ([[Help:Supported_browsers|click here for our supported browser list]])
*Screenshot
*Any and all other details.

Thanks again for the report and for using Wikia.

Happy editing!",
	'specialcontact-intro-bad-ad' => "We are sorry to hear you encountered a bad advertisement on Wikia. If you could provide further details below we will share them with our advertising manager, who will review the ad and may be able to remove it from the system. 

Be sure to tell us what wiki you're on, what ad you saw, and why it was a problem. It would also help if you could include a screenshot and the URL of the ad. Instructions for finding the URL of an ad are listed here: http://help.wikia.com/wiki/Help:Bad_advertisements

Thank you and happy editing!",

	'specialcontact-intro-wiki-name-change' => "If you are an admin here, you can request to change your [[Help:Title for the wiki|sitename]] or [[Help:Domain name|URL]] by filing out the form below. Please double check the spelling, and be sure of your correction, as we will not honor multiple requests. If you are not an admin here, here contact your local admins with your request [[Special:ListAdmins|here]].

Happy editing!",
	'specialcontact-intro-design' => "A wiki's design can be updated by any local admin on your wiki by using the [[Help:Theme_designer|Theme designer]]. If you are not an admin and wish to help with your wiki's design, first contact your [[Special:ListAdmins|local admins]].

If you would like help with creating a more customized design, you can submit a request to the Wikia Content team [[w:Community_Central:Content_Team/Requests|here]]. Please read through the guidelines before submitting a request there. 

If you feel you have found a bug while updating your wiki's design, please provide us with a detailed report [[Special:Contact/bug|here]]. 

Happy editing!",
	'specialcontact-intro-features' => "Wikia offers many features, the majority of which are live on all wikis across the site by default.

If you are an admin and feel that specific feature is not working well for your wiki, please discuss with your wiki's community if they would also like the feature turned off. If everyone agrees, you can use the [[Special:WikiFeatures|Wiki Features]] section of the [[Special:AdminDashboard|Admin Dashboard]] to disable or re-enable features. If the feature is not list there, please [[Special:Contact/general|contact us]] with your request.

Admins interested in testing out new features that are still in development can check out the Labs section of [[Special:WikiFeatures|Wiki Features]].

Want to stay current on announcement of new features and improvements to current ones? Stop by and follow the [[w:c:community:Blog:Wikia_New_Features|staff blog new features list]]",

	'specialcontact-intro-close-wiki' => "Thanks for contacting Wikia. We don't usually delete wikis once they have been created. Wikis are community-owned projects, and a wiki you are no longer interested in can wait for someone else to come along and [[Special:Contact/adoption|adopt it]].

If you wish to rename your wiki or \"start-over\" please first consult [[Help:Rename]] for renaming pages, and [[Help:Theme designer]] for renaming the title of your wiki. Wikis can easily have their names changed, without the hassle of starting over. If you wish to change your wiki's URL [[Special:Contact/general|please write to us]] as we'd be more than happy to do so for you.

If you feel this wiki is on a topic that no other users may be interested in (such as a personal or spam wiki), please submit a request using the form below. Please make the request from the wiki that needs closing.

I hope you find another wiki among the many that are part of Wikia, and join in building a fantastic resource about everything you are passionate about.

Happy editing!",
	
	'specialcontact-intro-general' => "You can contact [[w:project:Staff|Wikia Staff]] using this form. Admins of this wiki can be found [[Special:ListAdmins|here]].

	Additional information on how to report problems to Wikia can be found [[w:project:Report_a_problem|here]], or you can post on [[w:Forum:Index|Wikia Community Forums]] for user support.

If you prefer to use regular e-mail or have attachments, you can contact us at [mailto:community@wikia.com community@wikia.com].
",

	/* non-form footer */
	'specialcontact-noform-footer' => "'''Does this page answer your question?''' If not, please feel free to [[Special:contact/general|contact us]] to discuss your issue further. Remember you can always check out our '''[[w:c:help|help pages]]''', [[w:c:community:Blog:Wikia_Staff_Blog|staff blog]]  or post on our '''[[w:c:community:Forum:Community_Central_Forum|community help forums]]'''. If you are looking for admin help and advice, stop by [[w:c:community:Admin_Central:Main_Page|Founder & Admin Central]].",

	/* form */
	'specialcontact-username' => 'Please enter your username',
	'specialcontact-wikiname' => 'Which wiki',
	'specialcontact-realname' => 'Your name',
	'specialcontact-yourmail' => 'Your email',
	'specialcontact-problem' => 'Subject',
	'specialcontact-problemdesc' => 'Message',
	'specialcontact-mail' => 'Send to Wikia',
	'specialcontact-filledin' => 'This information has been filled in from your account preferences',
	'specialcontact-ccme' => 'Send me a copy of this message',
	'specialcontact-ccdisabled' => 'Disabled: Please [[Special:ConfirmEmail|validate]] your e-mail address to use this function',
	'specialcontact-notyou' => 'Not you?',
	'specialcontact-captchainfo' => 'Please enter the text in the image.',
	'specialcontact-captchatitle' => 'Blurry word',
	'specialcontact-formtitle' => 'Contact Wikia Support Staff',
	'specialcontact-label-screenshot' => 'Did you take a screenshot? If so, please upload here.',
	'specialcontact-label-additionalscreenshot' => 'If you have another screenshot please upload it here.',
	'specialcontact-label-bad-ad-description' => 'Please describe the problem with the ad',
	'specialcontact-label-bad-ad-link' => 'Please provide the URL of the page where you saw the bad ad',
	'specialcontact-label-bug-link' => 'Please provide the URL of the page where you are having the problem',
	'specialcontact-label-bug-feature' => 'What feature is this related to?',
	'specialcontact-label-bug-description' => 'Please describe the problem you are having',	
	'specialcontact-label-close-account-confirm' => 'I confirm that I want to disable my Wikia account',	
	'specialcontact-label-close-account-read-help' => 'I have read the [[Help:Close_my_account|help page on closing your account]]',
	'specialcontact-label-account-issue-description' => 'Please provide a detailed description of the issue you are having.',	
	'specialcontact-label-rename-newusername' => 'Please enter the new username',
	'specialcontact-label-rename-account-confirm' => 'I confirm that the spelling and punctuation for my new name is correct',
	'specialcontact-lable-rename-account-read-help' => 'I have read the [[Help:Changing your username|help page on renaming my account]]',
	'specialcontact-form-header' => 'Contact Wikia',
	'specialcontact-logged-in-as' => 'You are logged in as $1. [[Special:UserLogout|Not you?]]',
	'specialcontact-mail-on-file' => 'Your e-mail is set to $1. [[Special:Preferences|Do you wish to change it?]]',

	/* errors */
	'specialcontact-nomessage' => 'Please fill in a message',
	'specialcontact-captchafail' =>	'Incorrect or missing confirmation code.',
	'specialcontact-error-title' => 'Contact Form Error',
	'specialcontact-error-message' => 'Something went wrong while submitting your form. Please try again later.',
	'specialcontact-error-logintext' => 'You must be logged in to make this request. Please [[Special:SignUp|login to your account]] and try again.',
	'specialcontact-error-alreadyrenamed' => 'You have previously been renamed so you are not eligible for another one. Please [[Special:Contact/general|contact staff]] if you require further assistance.',

	/* email */
	'specialcontact-mailsub' => 'Wikia Support',
	'specialcontact-mailsubcc' => 'Copy of Wikia Contact Mail',
	'specialcontact-ccheader' => 'This is a copy of your message that was sent to Wikia Support',

	/* after */
	'specialcontact-submitcomplete' => 'Thank you for contacting Wikia. We receive and review all messages submitted here. We will do our best to get back to you in the next 2-3 business days, but please be patient as we work through all of the messages.

Remember, you can also find help in our [[w:c:community:Forum:Community_Central_Forum|Community Forum]] and [[w:c:community:Help:Index|Help pages]]. You can keep up to date with the latest Wikia news on our [[w:c:community:Blog:Wikia_Staff_Blog |Staff Blog]]. Happy editing!',
);

$messages['de'] = array(
	/* Spezialseite */
	'contact' => 'Kontakt zu Wikia',
	'specialcontact-wikia' => 'Kontakt zu Wikia',
	'specialcontact-pagetitle' => 'Kontaktiere einen Wikia-Mitarbeiter',

	/* picker */
	'specialcontact-intro-main-head' => "<big>Brauchst du Hilfe? Mach dir keine Sorgen, die Wikia-Community ist hier um dir zu helfen.</big><br/>
Klicke auf die folgenden Links, um mehr darüber zu erfahren, wie man Wikis benutzt, Wikis anpasst oder das eigene Profil verändert.",
	'specialcontact-intro-main-local' => '', #(this is meant to be blank)
	'specialcontact-intro-main-foot' => "'''Beantwortet diese Seite deine Fragen?''' Falls nicht, dann [[Special:contact/general|schreib uns]]. Vergiss nicht, dass du dir immer unsere '''[[w:c:help|Hilfeseiten]]''', das [[w:c:de.community:Blog:Wikia_Deutschland_News|Wikia-Blog]]  oder unsere '''[[w:c:de.community:Forum:Übersicht|Foren]]''' ansehen kannst. Falls du ein Admin bist und nach Hilfe suchst, sieh dir unseren [[w:c:de.community:Admin-Bereich:Hauptseite|Gründer- und Adminbereich]] an.",

	
	'specialcontact-secheader-onwiki' => "Allgemeine Wiki-Fragen",
		'specialcontact-seclink-content-issue' => "Problem mit dem Inhalt eines Wiki?",
		'specialcontact-seclink-user-conflict' => "Problem mit einem anderen Benutzer?",
		'specialcontact-seclink-adoption' => "Ich möchte Admin-Rechte",
		
	'specialcontact-secheader-account' => "Profil-Veränderungen",
		'specialcontact-seclink-account-issue' => "Ich kann nicht auf mein Profil zugreifen",
		'specialcontact-seclink-close-account' => "Ich möchte mein Profil schließen lassen",
		'specialcontact-seclink-rename-account' => "Ich möchte meinen Namen ändern",
		'specialcontact-seclink-blocked' => "Mein Profil ist gesperrt",
		
	'specialcontact-secheader-editing' => "Bei Wikia mitmachen",
		'specialcontact-seclink-using-wikia' => "Wie benutze ich Wikia?",
		'specialcontact-seclink-feedback' => "Ich habe Vorschläge",
		'specialcontact-seclink-bug' => "Ich habe einen Bug gefunden",
		'specialcontact-seclink-bad-ad' => "Ich habe unangebrachte Werbung gesehen",

	'specialcontact-secheader-setting' => "Wiki-Veränderungen",
		'specialcontact-seclink-wiki-name-change' => "Namen oder URL ändern",
		'specialcontact-seclink-design' => "Design",
		'specialcontact-seclink-features' => "Funktionen hinzufügen oder entfernen",
		'specialcontact-seclink-close-wiki' => "Wiki schließen",

	/* titles (overrides normal page title) */
	'specialcontact-sectitle' => "Wikia-Support - $1",
		'specialcontact-sectitle-general' => "Kontaktformular",
		'specialcontact-sectitle-content-issue' => "Probleme mit dem Inhalt",
		'specialcontact-sectitle-user-conflict' => "Benutzer-Probleme",
		'specialcontact-sectitle-adoption' => "Adminrechte",
		
		'specialcontact-sectitle-account-issue' => "Profil-Probleme",
		'specialcontact-sectitle-close-account' => "Profil stilllegen",
		'specialcontact-sectitle-rename-account' => "Namen ändern",
		'specialcontact-sectitle-blocked' => "Profil gesperrt",
		
		'specialcontact-sectitle-using-wikia' => "Wikia benutzen",
		'specialcontact-sectitle-feedback' => "Feedback",
		'specialcontact-sectitle-bug' => "Bugs melden",
		'specialcontact-sectitle-bad-ad' => "Werbung melden",

		'specialcontact-sectitle-wiki-name-change' => "Wiki-Namen ändern",
		'specialcontact-sectitle-design' => "Wiki-Design",
		'specialcontact-sectitle-features' => "Wiki-Funktionen",
		'specialcontact-sectitle-close-wiki' => "Wiki schließen",

	/* intros (message at top of page) */
	'specialcontact-intro-content-issue' => "Der Inhalt dieses Wikis wurde von dessen Community erstellt und wird nicht von Wikia, sondern von den [[Special:ListAdmins|lokalen Admins]] verwaltet. Falls du Probleme oder Fragen zum Inhalt dieses Wikis hast, wende dich bitte an die [[Special:ListAdmins|Admins]]. 

Falls du glaubst, dass der Inhalt gegen unsere [http://de.wikia.com/Nutzungsbedingungen Nutzungsbedingungen] verstößt, kannst du dich [[Special:Contact/general|hier]] an einen Wikia-Mitarbeiter wenden.",
	'specialcontact-intro-user-conflict' => "Ein Wiki ist ein Treffpunkt der Community, wo alle zusammenarbeiten müssen, damit es zum Erfolg wird. Dort, wo viele zusammen an einer Sache arbeiten, gibt es immer Konflikte und Meinungsverschiedenheiten. Diese lassen sich am besten durch eine gesunde und respektvolle Diskussion regeln.

Falls du Hilfe brauchst, wende dich zuerst an deine [[Special:ListAdmins|lokalen Admins]]. Die Admins sind die Experten was das Wiki und dessen Benutzer angeht. Falls die Admins nicht im Stande sind, dir zu helfen, oder der Benutzer gegen Wikias [http://de.wikia.com/Nutzungsbedingungen Nutzungsbedingungen] verstößt, kannst du dich [[Special:Contact/general|hier]] direkt an einen Wikia-Mitarbeiter wenden.",
	'specialcontact-intro-adoption' => "Würdest du gerne Admin auf diesem Wiki werden? Falls ja, dann musst du zuerst überprüfen ob einer der [[Special:Listusers/sysop|lokalen Admins]] aktiv ist. Falls ja, dann schreib ihn einfach an. Des Weiteren ist es immer schlau mit den anderen Benutzern des Wikis darüber zu diskutieren. Wenn du ihren Segen hast, dann ist is grundsätzlich einfacher die Adminrechte im Wiki zu bekommen. 

Falls die Admins nicht aktiv sind, dann kannst du einen Antrag für eine [[w:c:de.community:Projekt:Beantragung_einer_Wiki-Adoption|Adoption]] stellen.

Wenn das Wiki eine aktive Community besitzt, dann diskutiere mit ihnen wer ein passender Admin für das Wiki wäre, und warum ausgerechnet du der Beste für diesen Job bist. Füge bitte den Link zur Diskussion der [[w:c:de.community:Projekt:Beantragung_einer_Wiki-Adoption|Adoptionsanfrage]] bei.",
	
	'specialcontact-intro-account-issue' => 'Es tut uns Leid, dass du Probleme beim Zugriff auf dein Profil hast. Hier ein paar Sachen die zu überprüfen sind:

*Beachte die Groß-und Kleinschreibung des Profilnamens
*Hast du auch den neusten Browser?
*Ist deine E-Mail bestätigt?
*Versuchst du dich über Facebook Connect anzumelden? Folge den Anweisungen [[Help:Facebook_Connect|hier]]. 
*Du kannst kein Profil erstellen? Vielleicht bist du zur Zeit nicht berechtigt ein Profil zu erstellen. Um mehr darüber zu erfahren, besuche unsere  [http://de.wikia.com/Nutzungsbedingungen Nutzungsbedingungen].
*Passwort verloren? Du kannst [[Special:Signup|hier]] ein neues Passwort beantragen. Gib deinen Benutzernamen ein und klicke auf "neues Passwort". Dannach erhälst du eine E-Mail mit einem temporären Passwort. Benutze dieses Passwort um dich anzumelden und schließlich ein neues Passwort zu erstellen.',

	'specialcontact-intro-close-account' => "Es tut uns Leid, dass du deinen Account schließen möchtest. Wikia bietet eine große Anzahl an Wikis mit vielfältigen Themen und vielleicht ist da auch war für dich dabei. Falls du Probleme mit einem besonderen Wiki hast, dann kontaktiere bitte die [[Special:Listusers/sysop|lokalen Admins]]. Die helfen gerne weiter und können gegebenenfalls auch Ratschläge parat haben. 

Beachte, dass wir Benutzerkonten nicht vollkommen löschen können. Wir können das Konto schließen, so dass der Zugang nicht mehr benutzt werden kann. Dieser Prozess kann nicht rückgängig gemacht werden. Solltest du den Wunsch verspüren, wieder bei Wikia mitzumachen, dann wirst du einen neuen Account erstellen müssen. Dieser Prozess löscht nicht deine Beiträge, da diese unter freier Lizenz stehen und dem Wiki und seiner Community gehören.

Um die Konto-Schließung zu bestätigen, fülle dieses Formular aus.",

	'specialcontact-intro-rename-account' => 'Der Benutzername auf Wikia kann zwar verändert werden, aber nur einmal. Der Prozess kann nicht rückgängig gemacht werden. Stelle sicher, dass du die [http://help.wikia.com/wiki/Help:Changing_your_username Hilfeseite] zum Thema "Benutzernamen umbennenen" gelesen habt bevor du den Antrag auf eine Umbennenung stellst.

Nachdem du die Hilfeseite gelesen und sichergestellt hast, dass dein neuer Name richtig geschrieben wurde, fülle bitte dieses Formular aus. Nachdem der Prozess beendet ist, bekommst du eine Bestätigungsmail geschickt. Im Anschluß kannst du dich mit dem neuen Namen anmelden und aktiv an Wikia teilnehmen.',

	'specialcontact-intro-blocked' => 'Die Benutzerkontosperren werden meistens von den lokalen Admins und nicht von Wikia verhängt. Der Name des Admins, der dich gesperrt hat, sollte auf der Sperrnotiz zu finden sein. Du kannst den Admin kontaktieren, indem du eine Nachricht auf deiner Nachrichtenseite hinterlässt. Das ist grundsätzlich möglich, (auf manchen Wikis sogar wenn ihr gesperrt worden seit). Du findest deine Nachrichtenseite, indem du auf "Nachrichten" (oben rechts in jedem Wiki) klickst.
Falls die Nachrichtenseite nicht bearbeitet werden kann, ist es am Besten, die Sperre auszusitzen oder sich ein neues Wiki zu suchen.

Falls du die Sperre dennoch mit einem Wikia-Mitarbeiter diskutieren willst dann kontaktiere uns [[Special:Contact/general|hier]].',
	
	'specialcontact-intro-using-wikia' => "Jetzt wo du ein Teil der Community bist, steht dir frei bei den Wikis deiner Wahl mitzumachen. Für Starthilfe, besuche die [[Help:Getting_Started|Hilfeseiten]]. 

Hast du Fragen zu einem bestimmten Wiki, dann [[Special:ListAdmins|frag die lokalen Admins]]. 
Du kannst auch jederzeit in unserem [[w:c:de.community:Forum:Übersicht|Hilfeforum]] fragen.

Und vergiss nicht, dass man ein Wiki nicht kaputt machen kann! Experementieren ist erwünscht!",

	'specialcontact-intro-feedback' => "Vorschläge oder Feedback? Bitte schreibt uns! Falls eure Vorschläge sich auf Produkte aus Wikia Labs beziehen, dann schreibt bitte [[Special:WikiaLabs|hier]]. 

Danke und viel Spaß bei Wikia!",
	'specialcontact-intro-bug' => "Bitte beschreibt das Problem so deutlich wie möglich. Wichtige Details die einzubringen sind:
*Benutzername
*Ein Link zu ihrem Wiki
*Typ und Version eures Browsers ([[Help:Supported_browsers|Klickt hier für eine Liste der von uns unterstützten Browser]])
*Screenshot
*Alle weiteren Details.

Danke für eure Meldung und viel Erfolg auf Wikia.",

	'specialcontact-intro-bad-ad' => "Es tut uns Leid, dass du Probleme mit einer Anzeige hattest. Falls du weitere Details hast, teile sie mit uns. Wir leiten sie dann an unsere Marketing-Abteilung weiter, die die Anzeige eventuell von der Seite nehmen kann.

Vergiss nicht uns mitzuteilen, auf welchem Wiki du warst, welche Anzeige du gesehen hast und warum diese ein Problem darstellt. Eine große Hilfe wäre auch ein Screenshot und die URL der Anzeige. Hier findes du die Anleitung wie du die URL der Anzeige herausfinden kannst: http://help.wikia.com/wiki/Help:Bad_advertisements

Danke schön!",

	'specialcontact-intro-wiki-name-change' => "Falls du ein Admin in dem Wiki bist, kannst du hier den Antrag stellen, um den [[Help:Title for the wiki|Namen]] oder die [[Help:Domain name|URL]] zu ändern. Überprüfe die Schreibweise mehrmals um sicher zu stellen, das alles korrekt ist. Falls du kein Admin bist, dann wende dich mit deinem Antrag an die [[Special:ListAdmins|lokalen Admins]].",

	'specialcontact-intro-design' => "Das Wiki-Design kann von Admins im [[Help:Theme_designer|Theme-Designer]] bearbeitet werden. Falls du kein Admin bist, aber mit dem Design helfen willst, wende dich bitte zuerst an die [[Special:ListAdmins|lokalen Admins]].

Falls du ein fortgeschrittenes Design für dein Wiki willst, stelle einen Antrag an unser Team [[w:Community_Central:Content_Team/Requests|hier]]. Bitte lies dir die Richtlinien durch, bevor du den Antrag abschickst.  

Falls du glaubst, dass du während des Design-Updates einen Bug gefunden hast, schicke uns einen detailierten [[Special:Contact/bug|Fehler-Report]].",

	'specialcontact-intro-features' => "Wikia bietet eine Vielfalt an Funktionen, von denen die meisten automatisch eingeschaltet sind.

Wenn du ein Admin bist und glaubst, dass dein Wiki eine der Funktionen nicht gebrauchen kann, dann berede das mit den Benutzern des Wikis. Falls die Mehrheit dafür ist, dann kannst du die Funktion im Menüpunkt [[Special:WikiFeatures|Wiki-Funktionen]] der [[Special:AdminDashboard|Wiki-Verwaltung]] abschalten. Falls die Funktion nicht in den Wiki-Funktionen zu finden ist, dann [[Special:Contact/general|kontaktiere uns]].

Admins, die Interesse daran haben Optionen zu testen, die noch in Entwicklung sind, können diese im Wikia Labs-Menü in den [[Special:WikiFeatures|Wiki-Funktionen]] einschalten.

Wenn du über neue Funktionen auf dem Laufenden gehalten werden willst, dann folge einfach unserem [[w:c:de.community:Blog:Neue_Wikia-Funktionen|Blog]]",

	'specialcontact-intro-close-wiki' => "Danke, dass du Wikia kontaktiert hast. Üblicherweise löschen wir keine Wikis, sofern sie einmal erstellt worden sind. Wiki-Projekte gehören der Community, und falls du nicht länger an einem Wiki interessiert bist, gibt es vielleicht jemand anderen, der es [[Special:Contact/adoption|adoptieren möchte]].

Falls du den Namen deines Wikis ändern möchtest oder es komplett neu gestalten möchtest, besuche [[Help:Rename]] um Seitennamen zu ändern, und [[Help:Theme designer]] um den Titel des Wikis zu ändern. Die Namen der Wikis können einfach geändert werden, ohne dass man komplett von vorne beginnen muss. Falls du die URL deines Wikis ändern möchtest, dann [[Special:Contact/general|schreib uns]] und wir werden es liebend gern für dich machen.

Wenn du das Gefühl hast, dass dieses Wiki keinen Nutzen für andere darstellt (wie z.B. ein Spam-Wiki oder ein persönliches Wiki), dann stelle einen Antrag, indem du dieses Formular benutzt. Bitte stelle den Antrag aus dem betreffenden Wiki.",
	
	'specialcontact-intro-general' => "Du kannst einen [[w:project:Staff|Wikia Mitarbeiter]] kontaktieren, indem du dieses Formular benutzt. Die Admins dieses Wiki können [[Special:ListAdmins|hier]] gefunden werden.

	Zusätzliche Informationen zur Meldung von Problemen können [[w:project:Report_a_problem|hier]] gefunden werden, oder ihr postet es in unseren [[w:Forum:Index|Foren]].

Falls ihr lieber eine E-Mail schicken wollt, dann schreibt uns an [mailto:community@wikia.com community@wikia.com].
",

	/* non-form footer */
	'specialcontact-noform-footer' => "'''Beantwortet das hier deine Frage?''' Wenn nicht, dann [[Special:contact/general|schreib uns]]. Vergiss nicht, du kannst dir jederzeit die '''[[w:c:help|Hilfeseiten]]''' ansehen, das [[w:c:de.community:Blog:Wikia_Deutschland_News|Wikia-Blog]] lesen oder in unseren '''[[w:c:de.community:Forum:Übersicht|Foren]]''' posten. Falls du ein Admin bist und nach Hilfe und Ratschlägen suchst, dann besuche unseren [[w:c:de.community:Admin-Bereich:Hauptseite|Gründer & Admin Bereich]].",

	/* form */
	'specialcontact-username' => 'Bitte gib deinen Benutzernamen ein',
	'specialcontact-wikiname' => 'Welches Wiki',
	'specialcontact-realname' => 'Dein Name',
	'specialcontact-yourmail' => 'Deine E-Mail',
	'specialcontact-problem' => 'Betreff',
	'specialcontact-problemdesc' => 'Nachricht',
	'specialcontact-mail' => 'An Wikia senden',
	'specialcontact-filledin' => 'Diese Information wurde aus deinen Einstellungen entnommen',
	'specialcontact-ccme' => 'Schicke mir eine Kopie der Nachricht',
	'specialcontact-ccdisabled' => 'Deaktiviert: Bitte [[Special:ConfirmEmail|bestätige]] deine E-Mail, um diese Funktion benutzen zu können',
	'specialcontact-notyou' => 'Nicht du?',
	'specialcontact-captchainfo' => 'Bitte gib den Text des Bildes ein.',
	'specialcontact-captchatitle' => 'Undeutliches Wort',
	'specialcontact-formtitle' => 'Kontaktiere einen Wikia.Mitarbeiter',
	'specialcontact-label-screenshot' => 'Hast du einen Screenshot? Falls ja, lade ihn hier hoch.',
	'specialcontact-label-additionalscreenshot' => 'Hast du einen weiteren Screenshot? Lade ihn hier hoch.',
	'specialcontact-label-bad-ad-description' => 'Bitte beschreibe das Problem mit der Anzeige',
	'specialcontact-label-bad-ad-link' => 'Bitte gib die URL der Seite an, wo du die Anzeige gesehen hast',
	'specialcontact-label-bug-link' => 'Bitte gib die URL der Seite an, mit der du das Problem hast',
	'specialcontact-label-bug-feature' => 'Um welche Funktion geht es?',
	'specialcontact-label-bug-description' => 'Bitte beschreibe das Problem, das du hast',	
	'specialcontact-label-close-account-confirm' => 'Ich bestätige, dass ich mein Benutzerkonto schließen möchte',	
	'specialcontact-label-close-account-read-help' => 'Ich habe die [[Help:Close_my_account|Hilfeseite zur Konto-Schließung gelesen]]',
	'specialcontact-label-account-issue-description' => 'Bitte gib eine detailierte Beschreibung des Problems an',	
	'specialcontact-label-rename-newusername' => 'Gib den neuen Benutzernamen ein',
	'specialcontact-label-rename-account-confirm' => 'Ich bestätige hiermit, dass der Name korrekt geschrieben wurde',
	'specialcontact-lable-rename-account-read-help' => 'Ich habe die [[Help:Changing_your_username|Hilfeseiten zur Namensänderung gelesen]]',
	'specialcontact-form-header' => 'Wikia kontaktieren',
	'specialcontact-logged-in-as' => 'Du bist als $1 angemeldet. [[Special:UserLogout|Nicht du?]]',
	'specialcontact-mail-on-file' => 'Deine E-Mail ist $1. [[Special:Preferences|Möchtest du sie ändern?]]',

	/* errors */
	'specialcontact-nomessage' => 'Bitte eine Nachricht eingeben',
	'specialcontact-captchafail' =>	'Falscher, oder nicht vorhandender Nachrichtencode.',
	'specialcontact-error-title' => 'Kontaktformular-Fehler',
	'specialcontact-error-message' => 'Beim Absenden des Formulars ist ein Fehler aufgetreten. Bitte versuche es später erneut.',
	'specialcontact-error-logintext' => 'Du musst angemeldet sein, um diesen Antrag zu stellen. Bitte [[Special:SignUp|melde dich an]] und versuche es erneut.',
	'specialcontact-error-alreadyrenamed' => 'Dein Benutzername wurde schon einmal geändert. Kontaktiere einen [[Special:Contact/general|Wikia-Mitarbeiter]] um weitere Informationen darüber zu erhalten.',

	/* email */
	'specialcontact-mailsub' => 'Wikia-Support',
	'specialcontact-mailsubcc' => 'Kopie der Wikia Kontakt-Mail',
	'specialcontact-ccheader' => 'Das ist eine Kopie der E-Mail, die an den Wikia-Support geschickt wurde',

	/* after */
	'specialcontact-submitcomplete' => "Danke, dass du Wikia kontaktiert hast. Wir haben alle hier angegebenen Informationen bekommen. Wir werden unser bestes tun, um innerhalb von 2 Arbeitstagen auf deine Nachricht zu antworten. Wir bitten um Geduld.

Vergiss nicht, du kannst dir jederzeit die '''[[w:c:help|Hilfeseiten]]''' ansehen, den [[w:c:community:Blog:Wikia_Staff_Blog|Wikia-Blog]] lesen oder in unseren '''[[w:c:community:Forum:Community_Central_Forum|Foren]]''' posten.",
);

// include "SpecialContact.i18n2.php";
