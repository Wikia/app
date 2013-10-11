<?php

$messages = array();

$messages['en'] = array(
	'stafflog-desc' => 'Centralised logging for staff',
	'stafflog' => 'StaffLog',
	'stafflog-blockmsg' => '$1 $2 tried to block staff user $3 on wiki $4. Reason: $5',
	'stafflog-piggybackloginmsg' => '$1 Piggyback - user $2 login as $3', // @todo FIXME: event contains 4 parameters.
	'stafflog-piggybacklogoutmsg' => '$1 Piggyback - user $2 logout from $3 acount', // @todo FIXME: event contains 4 parameters.
	'right-stafflog' => 'Can view the stafflog',
	'stafflog-wiki-status-change' => '$1 changed the status of $2 to $3. Reason: $4',
	'stafflog-filter-label' => 'Filter',
	'stafflog-filter-user' => 'User:',
	'stafflog-filter-type' => 'Type:',
	'stafflog-filter-apply' => 'Apply filter',
	'stafflog-filter-type-block' => 'Blocks',
	'stafflog-filter-type-piggyback' => 'Piggyback',
	'stafflog-filter-type-renameuser' => 'User renames',
	'stafflog-filter-type-wikifactory' => 'Wiki status',
	'action-stafflog' => 'view the centralized staff log',
);

/** Message documentation (Message documentation)
 * @author Erdemaslancan
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'stafflog-desc' => '{{desc}}',
	'stafflog' => 'Log name.',
	'stafflog-blockmsg' => 'Log entry. Parameters:
* $1 is the user ID of the acting user
* $2 is the user name of the acting user
* $3 is the blocked user name
* $4 is the blocked wiki name at which the block attempt took place
* $5 is the block reason.',
	'stafflog-piggybackloginmsg' => 'Log entry. Parameters:
* $1 is the user ID of the acting user
* $2 is the user name of the acting user
* $3 is the user ID of the "victim"
* $4 is the user name of the "victim".',
	'stafflog-piggybacklogoutmsg' => 'Log entry. Parameters:
* $1 is the user ID of the acting user
* $2 is the user name of the acting user
* $3 is the user ID of the "victim"
* $4 is the user name of the "victim".',
	'right-stafflog' => '{{doc-right|stafflog}}',
	'stafflog-wiki-status-change' => 'Log entry. Parameters:
* $1 is the name of the acting user,
* $2 is the name of the wiki of which the status was changed,
* $3 is the new status of the wiki,
* $4 is the reason of the change.',
	'stafflog-filter-label' => '{{Identical|Filter}}',
	'stafflog-filter-user' => '{{Identical|User}}',
	'action-stafflog' => '{{doc-action|stafflog}}',
);

/** Arabic (العربية)
 * @author Achraf94
 */
$messages['ar'] = array(
	'stafflog-desc' => 'تسجيل مركزي للموظفين',
	'stafflog' => 'سجل فريق العمل',
	'stafflog-blockmsg' => 'حاول $1 $2 منع المستخدم الموظف $3 في ويكي $4. السبب: $5',
	'stafflog-piggybackloginmsg' => 'استعارة حساب $1 - دخول المستخدم $2 باسم المستخدم $3',
	'stafflog-piggybacklogoutmsg' => 'استعارة حساب $1 - انتهاء المستخدم $2 من استعمال حساب $3',
	'right-stafflog' => 'يمكن له عرض سجلات فريق العمل (الموظفين)',
	'stafflog-wiki-status-change' => 'قام $1 بتغيير حالة $2 ل$3. السبب: $4',
	'stafflog-filter-label' => 'مرشح',
	'stafflog-filter-user' => 'المستخدم:',
	'stafflog-filter-type' => 'النوع:',
	'stafflog-filter-apply' => 'تطبيق المرشح',
	'stafflog-filter-type-block' => 'عمليات المنع',
	'stafflog-filter-type-piggyback' => 'استعارة حساب',
	'stafflog-filter-type-renameuser' => 'إعادة تسمية المستخدم',
	'stafflog-filter-type-wikifactory' => 'حالة الويكي',
);

/** Breton (brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'stafflog-filter-label' => 'Sil',
	'stafflog-filter-user' => 'Implijer :',
	'stafflog-filter-type' => 'Seurt :',
	'stafflog-filter-apply' => 'Arloañ ar sil',
	'stafflog-filter-type-block' => 'Stankadennoù',
);

/** Bosnian (bosanski)
 */
$messages['bs'] = array(
	'stafflog-desc' => 'Centralizirani zapisnik za osoblje',
	'stafflog' => 'ZapisnikOsoblja',
	'stafflog-blockmsg' => '$1 $2 je pokušao da blokira člana osoblja $3 na wiki $4. Razlog: $5',
	'stafflog-piggybackloginmsg' => '$1 nosilac - korisnik $2 prijava kao $3',
	'stafflog-piggybacklogoutmsg' => '$1 nosilac - korisnik $2 odjava sa $3 računa',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Marcmpujol
 */
$messages['ca'] = array(
	'stafflog-desc' => 'Registre centralitzat pel personal',
	'stafflog' => 'Registre del personal',
	'stafflog-blockmsg' => "$1 $2 ha provat bloquejar a l'empleat $3 en el projecte $4. Motiu: $5",
	'stafflog-piggybackloginmsg' => '$1 Personificació - usuari $2 inicia como $3',
	'stafflog-piggybacklogoutmsg' => '$1 Personificació - usuari $2 tanca la sessió del compte $3',
	'right-stafflog' => "Pots veure el registre de l'staff",
	'stafflog-wiki-status-change' => "$1 ha canviat l'estat de $2 a $3. Motiu: $4",
	'stafflog-filter-label' => 'Filtre',
	'stafflog-filter-user' => 'Usuari:',
	'stafflog-filter-type' => 'Tipus:',
	'stafflog-filter-apply' => 'Aplicar el filtre',
	'stafflog-filter-type-block' => 'Bloquejar',
	'stafflog-filter-type-piggyback' => 'Personificar',
	'stafflog-filter-type-renameuser' => "Canviar el nom d'usuari",
	'stafflog-filter-type-wikifactory' => 'Estat del wiki',
	'action-stafflog' => "mostra l'historial centralitzat",
);

/** Czech (česky)
 * @author Chmee2
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'stafflog-desc' => 'Centralizované protokolování pro zaměstnance',
	'stafflog' => 'Protokol zaměstnanců',
	'stafflog-blockmsg' => '$1 $2 se pokusil zablokovat zaměstnance $3 na wiki $4. Důvod: $5',
	'stafflog-piggybackloginmsg' => '$1 Piggyback - uživatel $2 se přihlašuje jako $3',
	'stafflog-piggybacklogoutmsg' => '$1 Piggyback - uživatel $2 se odhlašuje z účtu $3',
	'stafflog-filter-label' => 'Filtr',
	'stafflog-filter-user' => 'Uživatel:',
	'stafflog-filter-type' => 'Typ:',
	'stafflog-filter-apply' => 'Použít filtr',
	'stafflog-filter-type-block' => 'Bloky',
	'stafflog-filter-type-renameuser' => 'Přejmenování uživatele',
	'stafflog-filter-type-wikifactory' => 'Wiki status',
);

/** German (Deutsch)
 * @author Alphakilo
 * @author Claudia Hattitten
 * @author Metalhead64
 * @author PtM
 */
$messages['de'] = array(
	'stafflog-desc' => 'Zentralisiertes Mitarbeiter-Logbuch',
	'stafflog' => 'Mitarbeiter-Logbuch',
	'stafflog-blockmsg' => '$1 $2 versuchte Mitarbeiter „$3“ auf Wiki „$4“ zu sperren. Grund: $5',
	'stafflog-piggybackloginmsg' => '$1 Huckepack - $2-Anmeldung als $3',
	'stafflog-piggybacklogoutmsg' => '$1 Huckepack - $2-Abmeldung von $3-Benutzerkonto',
	'right-stafflog' => 'Kann das Staff-Log einsehen',
	'stafflog-wiki-status-change' => '$1 veränderte den Status des  $2 zu $3. Grund:$4',
	'stafflog-filter-label' => 'Filter',
	'stafflog-filter-user' => 'Benutzer:',
	'stafflog-filter-type' => 'Typ:',
	'stafflog-filter-apply' => 'Filter anwenden',
	'stafflog-filter-type-block' => 'Sperren',
	'stafflog-filter-type-piggyback' => 'Huckepack',
	'stafflog-filter-type-renameuser' => 'Nutzer-Umbenennungen',
	'stafflog-filter-type-wikifactory' => 'Wiki Status',
	'action-stafflog' => 'das zentralisierte Mitarbeiter-Log zu betrachten',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Mirzali
 */
$messages['diq'] = array(
	'stafflog-filter-label' => 'Avrêc',
	'stafflog-filter-user' => 'Karber:',
	'stafflog-filter-type' => 'Babet:',
	'stafflog-filter-type-block' => 'Bloki',
	'stafflog-filter-type-wikifactory' => 'Wiki weziyet',
);

/** British English (British English)
 * @author Shirayuki
 */
$messages['en-gb'] = array(
	'stafflog-desc' => 'Centralised logging for staff',
	'action-stafflog' => 'view the centralised staff log',
);

/** Spanish (español)
 * @author VegaDark
 */
$messages['es'] = array(
	'stafflog-desc' => 'Registro centralizado para el personal',
	'stafflog' => 'Registro del personal',
	'stafflog-blockmsg' => '$1 $2 intentó bloquear al empleado $3 en el proyecto $4. Motivo: $5',
	'stafflog-piggybackloginmsg' => '$1 Personificación - usuario $2 inicia como $3',
	'stafflog-piggybacklogoutmsg' => '$1 Personificación - usuario $2 cierra sesión de la cuenta $3',
	'right-stafflog' => 'Puede ver el registro del staff',
	'stafflog-wiki-status-change' => '$1 cambió el estado de $2 a $3. Motivo: $4',
	'stafflog-filter-label' => 'Filtro',
	'stafflog-filter-user' => 'Usuario:',
	'stafflog-filter-type' => 'Tipo:',
	'stafflog-filter-apply' => 'Aplicar filtro',
	'stafflog-filter-type-block' => 'Bloquear',
	'stafflog-filter-type-piggyback' => 'Personificar',
	'stafflog-filter-type-renameuser' => 'Cambiar nombre de usuario',
	'stafflog-filter-type-wikifactory' => 'Estado del wiki',
	'action-stafflog' => 'ver el registro del staff centralizado',
);

/** French (français)
 * @author Gomoko
 * @author Peter17
 * @author Wyz
 */
$messages['fr'] = array(
	'stafflog-desc' => 'Identification centralisée pour le personnel',
	'stafflog' => 'StaffLog',
	'stafflog-blockmsg' => '$1 $2 a essayé de bloquer l’employé $3 sur le wiki $4. Motif : $5',
	'stafflog-piggybackloginmsg' => '$1 Accès superposé - utilisateur $2 connecté en tant que $3',
	'stafflog-piggybacklogoutmsg' => '$1 Accès superposé - utilisateur $2 déconnecté du compte $3',
	'right-stafflog' => 'Peut afficher le journal de l’équipe d’administration',
	'stafflog-wiki-status-change' => '$1 a changé le statut de $2 en $3. Motif : $4',
	'stafflog-filter-label' => 'Filtre',
	'stafflog-filter-user' => 'Utilisateur :',
	'stafflog-filter-type' => 'Type :',
	'stafflog-filter-apply' => 'Appliquer le filtre',
	'stafflog-filter-type-block' => 'Blocages',
	'stafflog-filter-type-piggyback' => 'Accès superposé',
	'stafflog-filter-type-renameuser' => 'Renommages d’utilisateur',
	'stafflog-filter-type-wikifactory' => 'Statut du wiki',
	'action-stafflog' => 'voir le journal de l’équipe d’administration',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'stafflog-desc' => 'Rexistro centralizado para o persoal',
	'stafflog' => 'Rexistro do persoal',
	'stafflog-blockmsg' => '$1 $2 intentou bloquear o membro do persoal $3 no wiki $4. Motivo: $5',
	'stafflog-piggybackloginmsg' => '$1 acceso non autorizado; usuario $2 conectado como $3',
	'stafflog-piggybacklogoutmsg' => '$1 acceso non autorizado; usuario $2 desconectado da conta $3',
	'right-stafflog' => 'Pode ollar o rexistro do persoal',
	'stafflog-wiki-status-change' => '$1 cambiou o estado de $2 a $3. Motivo: $4',
	'stafflog-filter-label' => 'Filtro',
	'stafflog-filter-user' => 'Usuario:',
	'stafflog-filter-type' => 'Tipo:',
	'stafflog-filter-apply' => 'Aplicar o filtro',
	'stafflog-filter-type-block' => 'Bloqueos',
	'stafflog-filter-type-piggyback' => 'Acceso non autorizado',
	'stafflog-filter-type-renameuser' => 'Cambios no nome de usuario',
	'stafflog-filter-type-wikifactory' => 'Estado do wiki',
	'action-stafflog' => 'ver o rexistro centralizado do persoal',
);

/** Hungarian (magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'stafflog-desc' => 'Központosított naplózás a személyzetnek',
	'stafflog' => 'Személyzeti napló',
	'stafflog-blockmsg' => '$1 $2 megkísérelte blokkolni $3-t a(z) $4-n. Indoklás: $5',
	'right-stafflog' => 'Megtekintheti a személyzeti naplót',
	'stafflog-wiki-status-change' => '$1 megváltoztatta a(z) $2 állapotát $3-ra. Indoklás: $4',
	'stafflog-filter-label' => 'Szűrő',
	'stafflog-filter-user' => 'Felhasználó:',
	'stafflog-filter-type' => 'Típus:',
	'stafflog-filter-apply' => 'Szűrő alkalmazása',
	'stafflog-filter-type-block' => 'Blokkok',
	'stafflog-filter-type-renameuser' => 'Felhasználók átnevezései',
	'stafflog-filter-type-wikifactory' => 'Wiki állapota',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'stafflog-desc' => 'Registros centralisate pro le personal',
	'stafflog' => 'Registro del personal',
	'stafflog-blockmsg' => '$1 $2 tentava blocar le membro del personal $3 in le wiki $4. Motivo: $5',
	'stafflog-piggybackloginmsg' => '$1 Portacontos - le usator $2 aperiva session como $3',
	'stafflog-piggybacklogoutmsg' => '$1 Portacontos - le usator $2 claudeva session del conto $3',
	'right-stafflog' => 'Pote vider le registro del personal',
	'stafflog-wiki-status-change' => '$1 cambiava le stato de $2 in $3. Motivo: $4',
	'stafflog-filter-label' => 'Filtro',
	'stafflog-filter-user' => 'Usator:',
	'stafflog-filter-type' => 'Typo:',
	'stafflog-filter-apply' => 'Applicar filtro',
	'stafflog-filter-type-block' => 'Blocadas',
	'stafflog-filter-type-piggyback' => 'Portacontos',
	'stafflog-filter-type-renameuser' => 'Renominationes de usator',
	'stafflog-filter-type-wikifactory' => 'Stato del wiki',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 */
$messages['id'] = array(
	'stafflog-desc' => 'Logging terpusat untuk staf',
	'stafflog' => 'StaffLog',
	'stafflog-blockmsg' => '$1 $2 mencoba untuk memblokir pengguna staf $3 di wiki $4 . Alasan: $5',
	'stafflog-piggybackloginmsg' => '$1 mendukung - pengguna $2 login sebagai $3',
	'stafflog-piggybacklogoutmsg' => '$1 mendukung - pengguna $2 logout akun $3',
	'right-stafflog' => 'Dapat melihat stafflog',
);

/** Luxembourgish (Lëtzebuergesch)
 */
$messages['lb'] = array(
	'stafflog-desc' => 'Zentraliséiert Logge vun de Staff-Mataarbechter',
	'stafflog-blockmsg' => '$1 $2 huet versicht de Staff-Mataarbechter $3 op der Wiki $4 ze spären: Grond: $5',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'stafflog-desc' => 'Централизирано најавување за персонал',
	'stafflog' => 'ДневникНаПерсонал',
	'stafflog-blockmsg' => '$1 $2 се обиде да го блокира членот на персоналот $3 на викито $4. Причина: $5',
	'stafflog-piggybackloginmsg' => '$1 на ушка - најава на корисникот $2 како $3',
	'stafflog-piggybacklogoutmsg' => '$1 на ушка - одјава на корисникот $2 од сметката $3',
	'right-stafflog' => 'Може да го прегледува дневникот за персоналот',
	'stafflog-wiki-status-change' => '$1 го смени статусот на $2 во $3. Причина: $4',
	'stafflog-filter-label' => 'Филтер',
	'stafflog-filter-user' => 'Корисник:',
	'stafflog-filter-type' => 'Тип:',
	'stafflog-filter-apply' => 'Примени филтер',
	'stafflog-filter-type-block' => 'Блокирања',
	'stafflog-filter-type-piggyback' => 'На ушка',
	'stafflog-filter-type-renameuser' => 'Преименувања на корисници',
	'stafflog-filter-type-wikifactory' => 'Статус на викито',
	'action-stafflog' => 'преглед на централизираниот девник на персоналот',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'stafflog-desc' => 'Pengelogan terpusat untuk kakitangan',
	'stafflog' => 'Nama Log',
	'stafflog-blockmsg' => '$1 $2 telah cuba menyekat pengguna kakitangan $3 di wiki $4. Sebab: $5',
	'stafflog-piggybackloginmsg' => 'Gendong $1 - pengguna $2 log masuk sebagai $3',
	'stafflog-piggybacklogoutmsg' => 'Gendong $1 - pengguna $2 log keluar dari akaun $3',
	'right-stafflog' => 'Boleh melihat log kakitangan',
	'stafflog-wiki-status-change' => '$1 menukar status $2 kepada $3. Sebab: $4',
	'stafflog-filter-label' => 'Penapis',
	'stafflog-filter-user' => 'Pengguna:',
	'stafflog-filter-type' => 'Jenis:',
	'stafflog-filter-apply' => 'Gunakan penapis',
	'stafflog-filter-type-block' => 'Sekatan',
	'stafflog-filter-type-piggyback' => 'Gendong',
	'stafflog-filter-type-renameuser' => 'Penukaran nama pengguna',
	'stafflog-filter-type-wikifactory' => 'Status wiki',
	'action-stafflog' => 'melihat log kakitangan terpusat',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 */
$messages['nb'] = array(
	'stafflog-desc' => 'Sentralisert loggføring for ledelse',
	'stafflog' => 'Ledelseslogg',
	'stafflog-blockmsg' => '$1 $2 forsøkte å blokkere ledelsesbrukeren $3 på wikien $4. Årsak: $5',
	'stafflog-piggybackloginmsg' => '$1 operasjon som annen bruker - bruker $2 logger inn som $3',
	'stafflog-piggybacklogoutmsg' => '$1 operasjon som annen bruker - bruker $2 logger ut fra $3-konto',
	'right-stafflog' => 'Kan vise ledelsesloggen',
	'stafflog-wiki-status-change' => '$1 endret statusen på $2 til $3. Årsak: $4',
	'stafflog-filter-label' => 'Filter',
	'stafflog-filter-user' => 'Bruker:',
	'stafflog-filter-type' => 'Type:',
	'stafflog-filter-apply' => 'Bruk filter',
	'stafflog-filter-type-block' => 'Blokkeringer',
	'stafflog-filter-type-piggyback' => 'Operer som annen bruker',
	'stafflog-filter-type-renameuser' => 'Brukernavnebytter',
	'stafflog-filter-type-wikifactory' => 'Wiki-status',
);

/** Dutch (Nederlands)
 * @author Saruman
 * @author Siebrand
 */
$messages['nl'] = array(
	'stafflog-desc' => 'Gecentraliseerd logboek voor medewerkers',
	'stafflog' => 'Medewerkerslogboek',
	'stafflog-blockmsg' => '$1 $2 heeft geprobeerd medewerker $3 op wiki $4 te blokkeren. Reden: $5',
	'stafflog-piggybackloginmsg' => '$1 piggyback: gebruiker $2 heeft aangemeld als $4 ($3)',
	'stafflog-piggybacklogoutmsg' => '$1 piggyback: gebruiker $2 heeft afgemeld als $4 ($3)',
	'right-stafflog' => 'Kan het staflogboek bekijken',
	'stafflog-wiki-status-change' => '$1 heeft de status gewijzigd van $2 naar $3. Reden: $4',
	'stafflog-filter-label' => 'Filter',
	'stafflog-filter-user' => 'Gebruiker:',
	'stafflog-filter-type' => 'Type:',
	'stafflog-filter-apply' => 'Filter toepassen',
	'stafflog-filter-type-block' => 'Blokkades',
	'stafflog-filter-type-piggyback' => 'Piggyback',
	'stafflog-filter-type-renameuser' => 'Hernoemde gebruikers',
	'stafflog-filter-type-wikifactory' => 'Wikistatus',
	'action-stafflog' => 'het gecentraliseerde staflogboek te bekijken',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'stafflog-desc' => 'Identificacion centralizada pel personal',
	'stafflog' => 'StaffLog',
	'stafflog-blockmsg' => '$1 $2 a ensajat de blocar l’emplegat $3 sul wiki $4. Motiu : $5',
	'stafflog-piggybackloginmsg' => '$1 Accès superpausat - utilizaire $2 connectat en tant que $3',
	'stafflog-piggybacklogoutmsg' => '$1 Accès superpausat - utilizaire $2 desconnectat del compte $3',
	'right-stafflog' => 'Pòt afichar lo jornal de l’equipa d’administracion',
	'stafflog-wiki-status-change' => "$1 a cambiat l'estatut de $2 en $3. Motiu : $4",
	'stafflog-filter-label' => 'Filtre',
	'stafflog-filter-user' => 'Utilizaire :',
	'stafflog-filter-type' => 'Tipe :',
	'stafflog-filter-apply' => 'Aplicar lo filtre',
	'stafflog-filter-type-block' => 'Blocatges',
	'stafflog-filter-type-piggyback' => 'Accès superpausat',
	'stafflog-filter-type-renameuser' => "Cambiaments de noms d'utilizaire",
	'stafflog-filter-type-wikifactory' => 'Estatut del wiki',
	'action-stafflog' => 'veire lo jornal de l’equipa d’administracion',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Nandy
 * @author Odder
 * @author Sovq
 */
$messages['pl'] = array(
	'stafflog-desc' => 'Scentralizowane logowanie dla personelu',
	'stafflog' => 'StaffLog',
	'stafflog-blockmsg' => '$1 $2 próbował zablokować użytkownika z grupy Staff $3 na wiki $4. Powód: $5',
	'stafflog-piggybackloginmsg' => 'Podłączenie $1 - użytkownik $2 zalogowany jako $3',
	'stafflog-piggybacklogoutmsg' => 'Podłączenie $1 - użytkownik $2 wylogowany z konta $3',
	'right-stafflog' => 'Może wyświetlić stafflog',
	'stafflog-wiki-status-change' => '$1 zmienił status  $2  na  $3 . Przyczyna: $4',
	'stafflog-filter-label' => 'Filtr',
	'stafflog-filter-user' => 'Użytkownik:',
	'stafflog-filter-type' => 'Typ:',
	'stafflog-filter-apply' => 'Zastosuj filtr',
	'stafflog-filter-type-block' => 'Blokady',
	'stafflog-filter-type-piggyback' => 'Piggyback',
	'stafflog-filter-type-renameuser' => 'Zmiany nazwy użytkownika',
	'stafflog-filter-type-wikifactory' => 'Stan wiki',
	'action-stafflog' => 'Wyświetlanie centralnego staff-logu',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'stafflog-desc' => "Argistrassion sentralisà për l'echip",
	'stafflog' => 'StaffLog',
	'stafflog-blockmsg' => "$1 $2 a l'ha provà a bloché l'utent ëd l'echip $3 an sla wiki $4. Rason: $5",
	'stafflog-piggybackloginmsg' => "$1 Conession mùltipla - l'utent $2 a l'é intrà com $3",
	'stafflog-piggybacklogoutmsg' => "$1 Conession mùltipla - l'utent $2 a l'é surtì dal cont $3",
	'right-stafflog' => "A peul vëdde l'argistr ëd l'echip d'aministrassion",
	'stafflog-wiki-status-change' => "$1 a l'ha cangià lë stat ëd $2 a $3. Rason: $4",
	'stafflog-filter-label' => 'Filtr',
	'stafflog-filter-user' => 'Utent:',
	'stafflog-filter-type' => 'Sòrt:',
	'stafflog-filter-apply' => 'Apliché ël filtr',
	'stafflog-filter-type-block' => 'Blocagi',
	'stafflog-filter-type-piggyback' => 'Acess mùltipl',
	'stafflog-filter-type-renameuser' => "Arbatiaje d'utent",
	'stafflog-filter-type-wikifactory' => 'Stat dla Wiki',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'stafflog-filter-label' => 'چاڼگر',
	'stafflog-filter-user' => 'کارن:',
	'stafflog-filter-type-block' => 'بنديزونه',
	'stafflog-filter-type-wikifactory' => 'ويکي دريځ',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Luckas
 * @author Malafaya
 */
$messages['pt'] = array(
	'stafflog-desc' => 'Registo centralizado para a equipa',
	'stafflog' => 'Registo da Equipa',
	'stafflog-blockmsg' => '$1 $2 tentou bloquear o utilizador da equipa $3 na wiki $4. Motivo: $5',
	'stafflog-piggybackloginmsg' => 'Personificação $1 - utilizador $2 autenticou-se como $3',
	'stafflog-piggybacklogoutmsg' => 'Personificação $1 - utilizador $2 saiu da conta $3',
	'right-stafflog' => 'Pode ver o Registo da Equipa',
	'stafflog-filter-label' => 'Filtro',
	'stafflog-filter-user' => 'Utilizador:',
	'stafflog-filter-type' => 'Tipo:',
	'stafflog-filter-apply' => 'Aplicar filtro',
	'stafflog-filter-type-block' => 'Bloqueios',
);

/** Brazilian Portuguese (português do Brasil)
 * @author JM Pessanha
 * @author Luckas
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'stafflog-desc' => 'Registro centralizado para a equipe',
	'stafflog' => 'Registro da Equipe',
	'stafflog-blockmsg' => '$1 $2 tentou bloquear o usuário da equipe $3 na wiki $4. Motivo: $5',
	'stafflog-piggybackloginmsg' => 'Personificação $1 - usuário $2 autenticou-se como $3',
	'stafflog-piggybacklogoutmsg' => 'Personificação $1 - usuário $2 saiu da conta $3',
	'right-stafflog' => 'Pode ver o registro da staff',
	'stafflog-wiki-status-change' => '$1 mudou o estado de $2 para $3. Motivo: $4',
	'stafflog-filter-label' => 'Filtro',
	'stafflog-filter-user' => 'Usuário:',
	'stafflog-filter-type' => 'Tipo:',
	'stafflog-filter-apply' => 'Aplicar filtro',
	'stafflog-filter-type-block' => 'Bloqueios',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'stafflog-desc' => 'Trasute cendralizzate pe staff',
	'stafflog' => 'StaffLog',
	'stafflog-blockmsg' => "$1 $2 ha pruvate a bloccà l'utende d'u staff $3 sus a uicchi $4. Mutive: $5",
	'stafflog-piggybackloginmsg' => '$1 Piggyback - utende $2 trase cumme a $3',
	'stafflog-piggybacklogoutmsg' => "$1 Piggyback - utene $2 iesse da 'u cunde $3",
	'right-stafflog' => "Puè 'ndrucà l'archivije d'u staff",
	'stafflog-wiki-status-change' => "$1 cangiate 'u state de $2 jndr'à $3. Mutive: $4",
	'stafflog-filter-label' => 'Filtre',
	'stafflog-filter-user' => 'Utende:',
	'stafflog-filter-type' => 'Tipe:',
	'stafflog-filter-apply' => "Appleche 'u filtre",
	'stafflog-filter-type-block' => 'Blocche',
	'stafflog-filter-type-piggyback' => 'Piggyback',
	'stafflog-filter-type-renameuser' => "Renomene l'utende",
	'stafflog-filter-type-wikifactory' => "State d'a uicchi",
	'action-stafflog' => "'mdruche l'archivije cendralizzate d'u staff",
);

/** Russian (русский)
 * @author DCamer
 * @author Eleferen
 * @author Kuzura
 * @author Okras
 */
$messages['ru'] = array(
	'stafflog-desc' => 'Централизованное ведение журнала для сотрудников',
	'stafflog' => 'Журнал сотрудника',
	'stafflog-blockmsg' => '$2 ($1) попытался заблокировать сотрудника $3 на вики $4. Причина: $5',
	'stafflog-piggybackloginmsg' => 'Вход $1 — участник $2 представился как $3',
	'stafflog-piggybacklogoutmsg' => 'Выход $1 — участник $2 завершил сеанс учётной записи $3',
	'right-stafflog' => 'Может просматривать журнал сотрудника',
	'stafflog-wiki-status-change' => '$1изменил статус  $2  для  $3 . Причина: $4',
	'stafflog-filter-label' => 'Фильтр',
	'stafflog-filter-user' => 'Участник:',
	'stafflog-filter-type' => 'Тип:',
	'stafflog-filter-apply' => 'Применить фильтр',
	'stafflog-filter-type-block' => 'Блокировки',
	'stafflog-filter-type-piggyback' => 'Вход',
	'stafflog-filter-type-renameuser' => 'Переименование участника',
	'stafflog-filter-type-wikifactory' => 'Статус вики',
	'action-stafflog' => 'посмотреть централизованный штатный журнал',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'stafflog-desc' => 'Centraliserad loggning för personal',
	'stafflog' => 'Personallogg',
	'stafflog-blockmsg' => '$1 $2 försökte blockera personalanvändaren $3 på wikin $4. Anledning: $5',
	'stafflog-piggybackloginmsg' => '$1 Ryggridning - användare $2 loggar in som $3',
	'stafflog-piggybacklogoutmsg' => '$1 Ryggridning - användare $2 loggar ut från kontot $3',
	'right-stafflog' => 'Kan visa personalloggen',
	'stafflog-wiki-status-change' => '$1 ändrade statusen för $2 till $3. Anledning: $4',
	'stafflog-filter-label' => 'Filter',
	'stafflog-filter-user' => 'Användare:',
	'stafflog-filter-type' => 'Typ:',
	'stafflog-filter-apply' => 'Verkställ filter',
	'stafflog-filter-type-block' => 'Blockeringar',
	'stafflog-filter-type-piggyback' => 'Ryggridning',
	'stafflog-filter-type-renameuser' => 'Användarnamnbyten',
	'stafflog-filter-type-wikifactory' => 'Wiki-status',
	'action-stafflog' => 'visa centraliserade personalloggen',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'stafflog-desc' => 'Nakagitnang paglagda para sa tauhan',
	'stafflog' => 'Talaan ng Tauhan',
	'stafflog-blockmsg' => 'Si $1 $2 ay sumubok na hadlangan ang tauhang tagagamit na si $3 sa wiking $4. Dahilan: $5',
	'stafflog-piggybackloginmsg' => '$1 Pakikisakay - si tagagamit na $2 ay lumagda bilang si $3',
	'stafflog-piggybacklogoutmsg' => '$1 Pakikisakay - si tagagamit na $2 ay umalis sa pagkakalagda mula sa akawnt ni $3',
	'right-stafflog' => 'Maaaring tingnan ang talaan ng tauhan',
	'stafflog-wiki-status-change' => 'Binago ni $1 ang katayuan ng $2 upang maging $3. Dahilan: $4',
	'stafflog-filter-label' => 'Pansala',
	'stafflog-filter-user' => 'Tagagamit:',
	'stafflog-filter-type' => 'Uri:',
	'stafflog-filter-apply' => 'Ilapat ang pansala',
	'stafflog-filter-type-block' => 'Mga pagharang',
	'stafflog-filter-type-piggyback' => 'Pakikisakay sa likod',
	'stafflog-filter-type-renameuser' => 'Mga muling pagpapangalan ng tagagamit',
	'stafflog-filter-type-wikifactory' => 'Katayuan ng wiki',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Steve.rusyn
 * @author SteveR
 * @author Тест
 */
$messages['uk'] = array(
	'stafflog-desc' => 'Централізоване журналювання для співробітників',
	'stafflog' => 'Журнал співробітника',
	'stafflog-blockmsg' => '$1 $2 спробував заблокувати користувача-співробітника $3 у вікі $4. Причина: $5',
	'stafflog-piggybackloginmsg' => 'Вхід $1 — учасник $2 увійшов як $3',
	'stafflog-piggybacklogoutmsg' => 'Вихід $1 — користувач $2 вийшов з облікового запису $3',
	'right-stafflog' => 'Може переглядати журнал співробітника',
	'stafflog-wiki-status-change' => '$1 {{GENDER:$1|змінив|змінила}} статус $2 на $3. Причина:$4',
	'stafflog-filter-label' => 'Фільтр',
	'stafflog-filter-user' => 'Користувач:',
	'stafflog-filter-type' => 'Тип:',
	'stafflog-filter-apply' => 'Застосувати фільтр',
	'stafflog-filter-type-block' => 'Блокування',
	'stafflog-filter-type-piggyback' => 'Вхід',
	'stafflog-filter-type-renameuser' => 'Перейменування користувача',
	'stafflog-filter-type-wikifactory' => 'Статус вікі',
	'action-stafflog' => 'переглядати журнал централізованого персоналу',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author StephDC
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'stafflog-blockmsg' => '$1 $2 试图封禁在维基系统 $4 上面的员工用户 $3，理由为 $5',
	'stafflog-filter-label' => '过滤器',
	'stafflog-filter-user' => '用户：',
	'stafflog-filter-type' => '类型：',
	'stafflog-filter-apply' => '应用过滤器',
	'stafflog-filter-type-renameuser' => '重命名用户',
	'stafflog-filter-type-wikifactory' => 'Wiki状态',
);
