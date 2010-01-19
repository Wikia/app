<?php
/**
 * Internationalisation file for WikiFactory extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	'privatedomains_nomanageaccess' => "<p>Sorry, you do not have enough rights to manage the allowed private domains for this wiki. Only wiki bureaucrats and staff members have access.</p><p>If you aren't logged in, you probably <a href='/wiki/Special:Userlogin'>should</a>.</p>",
	'privatedomains' =>  'Manage Private Domains',
	'privatedomains_ifemailcontact' => "<p>Otherwise, please contact [[Special:Emailuser/$1|$1]] if you have any questions.</p>",
	'saveprivatedomains_success' => "Private Domains changes saved.",
	'privatedomains_invalidemail' => "<p>Sorry, access to this wiki is restricted to members of $1. If you have an email address affiliated with $1, you can enter or reconfirm your email address on your account preference page <a href=/wiki/Special:Preferences>here</a>. You can still view pages on this wiki, but you will be unable to edit.</p>",
	'privatedomains_affiliatenamelabel' => "<br>Name of organization:",
	'privatedomains_emailadminlabel' => "<br>Contact username for access problems or queries:",
	'privatedomainsinstructions' => "<br /> <br /> <p>Below is the list of email domains allowed for editors of this wiki. Each line designates an email suffix that is given access for editing. This should be formatted with one suffix per line. For example:</p> <p style=\"width: 20%; padding:5px; border: 1px solid grey;\">cs.stanford.edu<br /> stanfordalumni.org</p> <p>This would allow edits from anyone with the email address whatever@cs.stanford.edu or whatever@stanfordalumni.org</p> <p><b>Enter the allowed domains in the text box below, and click \"save\".</b></p>"
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'privatedomains_affiliatenamelabel' => 'Leading newline does not make sense. Consider hardcoding it.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'privatedomains_affiliatenamelabel' => '<br>Naam van organisasie:',
);

/** Breton (Brezhoneg)
 * @author Gwenn-Ael
 */
$messages['br'] = array(
	'privatedomains_nomanageaccess' => "<p> Ma digarezit,  n'ho peus ket gwirioù a-walc'h evit merañ domanioù prevez ar wiki-mañ. N'eus nemet ar vurevourien hag izili ar c'hoskor a c'hall mont warnañ.</p><p> Ma n'oc'h ket kevreet, ret e vefe deoc'h <a href='/wiki/Special:Userlogin'>kevreañ</a> marteze.</p>",
	'privatedomains' => 'Merañ an domanioù prevez',
	'privatedomains_ifemailcontact' => "<p> Anez, kit e darempred gant [[Special:Emailuser/$1|$1]]  m'ho peus goulenn pe c'houlenn.</p>",
	'saveprivatedomains_success' => 'Kemmoù en domanioù prevez saveteet.',
	'privatedomains_invalidemail' => "<p> Ma digarezit, Miret eo ar moned d'ar wiki-mañ evit izili $1.  M'ho peus ur chomlec'h postel emezelet ouzh $1 e challit mont e-barzh pe adkarnaat ho chomlec'h postel war pajenn zibaboù ar gont <a href=/wiki/Special:Dibaboù>amañ</a>. Gallout a rit gwelet pajennoù ar wiki-mañ, met ne c'hallit ket kemmañ anezho .</p>",
	'privatedomains_affiliatenamelabel' => '<br />Anv an aozadur :',
	'privatedomains_emailadminlabel' => "<br /> Anv implijer an darempred m'ho peus kudennoù mont pe rekedoù :",
	'privatedomainsinstructions' => '<br /> <br /> <p>Diskwelet eo roll domanioù ar chomlec\'hioù postel zo aotreet evit embannerien ar wiki-mañ. Pep linenn a ziskouez ur rakverk postel a ro tro d\'an embannerien da vont warno. Furmadet e tle ar roll  bezañ gant ur rakverk dre linenn. Da skouer,  :</p> <p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p> <p>p>This would allow edits from anyone with the email address whatever@cs.stanford.edu or whatever@stanfordalumni.org</p> <p><b>Ebarzhit roll an domanioù aotreet er voest amañ amañ dindan ha klikit war « saveteiñ».</b></p>',
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'privatedomains_nomanageaccess' => "<p>Désolé, vous n'avez les droits suffisants pour gérer les domaines privés de ce wiki. Seuls les bureaucrates et les membres du personnel y ont accès.</p><p>Si vous n'êtes pas connecté, vous devriez probablement <a href='/wiki/Special:Userlogin'>vous connecter</a>.</p>",
	'privatedomains' => 'Gérer les domaines privés',
	'privatedomains_ifemailcontact' => '<p>Sinon, veuillez contacter [[Special:Emailuser/$1|$1]] si vous avec une question.</p>',
	'saveprivatedomains_success' => 'Modifications dans les domaines privés sauvegardés.',
	'privatedomains_invalidemail' => "<p>Désolé, l'accès à ce wiki est réservé aux membre de $1. Si vos avez une adresse de courriel affiliée avec $1, vous pouvez entrer ou reconfirmer votre adresse de courriel dans sur la page de préférences du compte <a href=/wiki/Special:Preferences>ici</a>. Vous pouvez toujours voir les pages de ce wiki, mais vous ne pouvez pas le modifier.</p>",
	'privatedomains_affiliatenamelabel' => "<br />Nom de l'organisation :",
	'privatedomains_emailadminlabel' => "<br />Nom d'utilisateur du contact pour des problèmes d'accès ou requêtes :",
	'privatedomainsinstructions' => '<br /> <br /> <p>La liste des domaines des adresses de courriel autorisées pour les éditeurs de ce wiki est affichée ci-dessous. Chaque ligne désigne un suffixe d\'adresse de courriel qui donne accès aux éditeurs. La liste doit être formatée avec un suffixe par ligne. Par exemple :</p> <p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p> <p>This would allow edits from anyone with the email address whatever@cs.stanford.edu or whatever@stanfordalumni.org</p> <p><b>Entrez la liste des domaines autorisés dans la boîte ci-dessous et cliquez sur « sauvegarder ».</b></p>',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'privatedomains_nomanageaccess' => "<p>Sentímolo, non ten os dereitos necesarios para xestionar os dominios privados deste wiki. Só os burócratas do wiki e os membros do persoal teñen acceso.</p><p>Se non accedeu ao sistema, probabelmente <a href='/wiki/Special:Userlogin'>debería</a> facelo.</p>",
	'privatedomains' => 'Xestionar os dominios privados',
	'privatedomains_ifemailcontact' => '<p>Se non, póñase en contacto con [[Special:Emailuser/$1|$1]] se ten algunha dúbida.</p>',
	'saveprivatedomains_success' => 'Gardáronse os cambios feitos nos dominios privados.',
	'privatedomains_invalidemail' => '<p>Sentímolo, o acceso a este wiki está restrinxido aos membros de $1. Se ten un enderezo de correo electrónico afiliado con $1, pode entrar ou confirmar o seu enderezo de correo electrónico na páxina de preferencias da súa conta <a href=/wiki/Special:Preferences>aquí</a>. Aínda pode ver páxinas neste wiki, pero non será capaz de editalas.</p>',
	'privatedomains_affiliatenamelabel' => '<br />Nome da organización:',
	'privatedomains_emailadminlabel' => '<br />Nome de usuario de contacto para os problemas de acceso ou dúbidas:',
	'privatedomainsinstructions' => '<br /> <br /> <p>A continuación está a lista de dominios de correo electrónico autorizados para os editores deste wiki. Cada liña designa un sufixo que dá acceso á edición. A lista debe estar ordenada de xeito que haxa un sufixo por liña. Por exemplo:</p> <p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p> <p>Isto permitirá as edicións daqueles usuarios que teñan un enderezo de correo electrónico o_que_sexa@cs.stanford.edu ou o_que_sexa@stanfordalumni.org</p> <p><b>Insira os dominios autorizados no cadro de texto de embaixo e prema en "Gardar".</b></p>',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'privatedomains' => 'Privát tartományok kezelése',
	'privatedomains_affiliatenamelabel' => '<br />Szervezet neve:',
	'privatedomains_emailadminlabel' => '<br />Kapcsolattartó neve hozzáférési problémák vagy kérdések esetére:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'privatedomains_nomanageaccess' => "<p>U hebt niet de juiste rechten om de toegewezen privédomeinen voor deze wiki te beheren.
Alle bureaucraten van deze wiki en stafleden hebben deze rechten.</p>
<p>Als u niet bent aangemeld, <a href='/wiki/Special:Userlogin'>doe dat dan</a>.</p>",
	'privatedomains' => 'Privédomeinen beheren',
	'privatedomains_ifemailcontact' => '<p>Neem anders contact op met [[Special:Emailuser/$1|$1]] voor antwoord op uw vragen.</p>',
	'saveprivatedomains_success' => 'De wijzigingen in de privédomeinen zijn opgeslagen.',
	'privatedomains_invalidemail' => '<p>Alleen leden van de groep $1 hebben schrijftoegang voor deze wiki.
Als u een e-mailadres hebt dat is verbonden met "$1", voer dat dan in bij <a href=/wiki/Special:Preferences>uw voorkeuren</a> of bevestig uw e-mailadres.
U kunt pagina\'s bekijken, maar deze niet bewerken.</p>',
	'privatedomains_affiliatenamelabel' => '<br />Organisatienaam:',
	'privatedomains_emailadminlabel' => '<br />Contactgebruiker bij toegangsproblemen of vragen:',
	'privatedomainsinstructions' => '<br /><br /><p>Hieronder staat een lijst met e-maildomeinen waarvan gebruiker op deze wiki kunnen bewerken.
Op iedere regel staat een domeinnaam waarmee bewerkingstoegang tot de wiki verkregen kan worden.
Er mag maar 1 domeinnaam per regel staan.
Bijvoorbeeld:</p>
<p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br />stanfordalumni.org</p>
<p>Met deze instellingen zouden gebruikers met het e-mailadres pietje.precies@cs.stanford.edu en jantje.beton@stanfordalumni.org bijvoorbeeld pagina\'s mogen bewerken.</p>
<p><b>Voer de toegelaten domeinen in het onderstaande invoervenster in en klik op "Opslaan".</b></p>',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'privatedomains_nomanageaccess' => "<p>Belavans a l'ha pa basta drit për gestì ël domini privà për sta wiki-sì. Mach mangiapapé dla wiki e mèmber ëd l'echip a l'han acess.</p><p>S'a l'é pa rintrà ant ël sistema, a peul esse <a href='/wiki/Special:Userlogin'>ch'a deva felo</a>.</p>",
	'privatedomains' => 'Gestiss Domini Privà',
	'privatedomains_ifemailcontact' => "<p>Dësnò, për piasì ch'a contata [[Special:Emailuser/$1|$1]] s'a l'has chèich chestion.</p>",
	'saveprivatedomains_success' => 'Salvà ij cangiament ai Domini Privà.',
	'privatedomains_invalidemail' => "<p>Belavans l'acess a sta wiki-sì a l'é arstrenzù ai mèmber ëd $1. S'a l'ha n'adrëssa ëd pòsta eletrònica afilià con $1, a peul anserì o riconfirmé soa adrëssa an soa pàgina dle preferense ëd sò cont <a href=/wiki/Special:Preferences>ambelessì</a>. A peul ancó visualisé pàgine an sta wiki-sì, ma a podrà pa fé 'd modìfiche.",
	'privatedomains_affiliatenamelabel' => "<br />Nòm ëd l'organisassion:",
	'privatedomains_emailadminlabel' => "<br />Nòm utent ëd contat për problema d'acess o arceste:",
	'privatedomainsinstructions' => "<br /> <br /> <p>Sota a-i é la lista dij domini ëd pòsta eletrònica përmëttù a j'editor dë sta wiki-sì. Minca linia a spessìfica un sufiss ëd pòsta eletrònica che a l'ha acess për modifiché. Sòn a dovrìa pijé la forma con un sufiss për linia. Për esempi:</p> <p style=\"width: 20%; padding:5px; border: 1px solid grey;\">cs.stanford.edu<br /> stanfordalumni.org</p> <p>Sòn a përmët modìfiche da tuti coj ch'a l'han l'adrëssa ëd pòsta eletrònica whatever@cs.stanford.edu o whatever@stanfordalumni.org</p> <p><b>Ch'a anserissa ij domini përmëttù ant la casela ëd test sì-sota, e ch'a sgnaca \"salvé\".</b></p>",
);

