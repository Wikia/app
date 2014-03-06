<?php
/**
 * Internationalisation file for extension PoolCounterClient.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Tim Starling
 */
$messages['en'] = array(
	'poolcounter-desc' => 'MediaWiki client for the pool counter daemon',
	'poolcounter-connection-error' => 'Error connecting to pool counter server: $1',
	'poolcounter-read-error' => 'Error reading from pool counter server.',
	'poolcounter-write-error' => 'Error writing to pool counter server.',
	'poolcounter-remote-error' => 'Pool counter server error: $1',
);

/** Message documentation (Message documentation)
 * @author Mormegil
 * @author Nedergard
 * @author Purodha
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = array(
	'poolcounter-desc' => '{{desc|name=Pool Counter|url=http://www.mediawiki.org/wiki/Extension:PoolCounter}}
A pool counter keeps track of the running processes on a cluster of processors, and may or may not grant a job access to the processing pool. (Note, the word "counter" relates to the counter in a shop, bank, or hotel, not to the verb "to count")',
	'poolcounter-connection-error' => 'Used at least in the MediaWiki message {{msg-mw|view-pool-error}}.

Used as fatal error message.

Parameters:
* $1 - error message which is returned by the server',
	'poolcounter-read-error' => 'Used as error message.

See also:
* {{msg-mw|Poolcounter-write-error}}',
	'poolcounter-write-error' => 'Used as error message.

See also:
* {{msg-mw|Poolcounter-read-error}}',
	'poolcounter-remote-error' => 'Used as error message. Parameters:
* $1 - error message which the server returned, or not-localized string "(no message given)".',
);

/** Afrikaans (Afrikaans)
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'poolcounter-desc' => 'MediaWiki kliënt vir die swembad toonbank daemon',
	'poolcounter-read-error' => 'Fout met lees van die swembad toonbank bediener',
	'poolcounter-write-error' => 'Fout met skryf aan die swembad toonbank bediener',
);

/** Aragonese (aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'poolcounter-desc' => "Client MediaWiki ta demonio d'o contador d'enqüestas poolcounter.py",
	'poolcounter-connection-error' => "Error connectando a o servidor contador d'enqüestas: $1",
	'poolcounter-read-error' => "Error leyendo d'o servidor contador d'enqüestas",
	'poolcounter-write-error' => "Error escribindo a o servidor contador d'enqüestas",
	'poolcounter-remote-error' => "Error d'o servidor contador d'enqüestas: $1",
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'poolcounter-desc' => 'عميل ميدياويكي لمشرف مجموعة daemon poolcounter.py',
	'poolcounter-connection-error' => 'خطأ توصيل إلى خادم مشرف المجموعة: $1',
	'poolcounter-read-error' => 'خطأ قراءة من خادم مشرف المجموعة',
	'poolcounter-write-error' => 'خطأ كتابة إلى خادم مشرف المجموعة',
	'poolcounter-remote-error' => 'خطأ خادم مشرف المجموعة: $1',
);

/** Assamese (অসমীয়া)
 * @author Gitartha.bordoloi
 */
$messages['as'] = array(
	'poolcounter-desc' => 'পুল্‌ কাউণ্টাৰ ডিমনৰ বাবে মিডিয়াৱিকি ক্লায়েণ্ট',
	'poolcounter-connection-error' => 'পুল কাউণ্টাৰ চাৰ্ভাৰলৈ সংযোগ স্থাপনত ত্ৰুটী হৈছে: $1',
	'poolcounter-read-error' => 'পুল কাউণ্টাৰ চাৰ্ভাৰৰ পৰা পঢ়াত ত্ৰুটী হৈছে',
	'poolcounter-write-error' => 'পুল কাউণ্টাৰ চাৰ্ভাৰত লিখাত ত্ৰুটী হৈছে',
	'poolcounter-remote-error' => 'পুল কাউণ্টাৰ চাৰ্ভাৰ ত্ৰুটী: $1',
);

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'poolcounter-desc' => "Cliente MediaWiki pal degorriu del contador d'encuestes",
	'poolcounter-connection-error' => "Error al coneutar col sirvidor del contador d'encuestes: $1",
	'poolcounter-read-error' => "Error al lleer del sirvidor del contador d'encuestes",
	'poolcounter-write-error' => "Error al escribir nel sirvidor del contador d'encuestes",
	'poolcounter-remote-error' => "Error del sirvidor del contador d'encuestes: $1",
);

/** Bikol Central (Bikol Central)
 * @author Geopoet
 */
$messages['bcl'] = array(
	'poolcounter-desc' => 'An kliyente kan MediaWiki para sa pangrupong parabilang na daemon',
	'poolcounter-connection-error' => 'Kasalaan na nagkokonekta sa pangrupong parabilang na serbidor: $1',
	'poolcounter-read-error' => 'Kasalaan sa pagbabasa gikan sa pangrupong parabilang na serbidor.',
	'poolcounter-write-error' => 'Kasalaan sa pagsusurat pasiring sa pangrupong parabilang na serbidor.',
	'poolcounter-remote-error' => 'Kasalaan kan pangrupong parabilang na serbidor: $1',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'poolcounter-desc' => 'Кліент MediaWiki для лічыльніка poolcounter.py',
	'poolcounter-connection-error' => 'Памылка далучэньня для сэрвэра лічыльніка: $1',
	'poolcounter-read-error' => 'Памылка чытаньня з сэрвэра лічыльніка',
	'poolcounter-write-error' => 'Памылка запісу на сэрвэр лічыльніка',
	'poolcounter-remote-error' => 'Памылка сэрвэра лічыльніка: $1',
);

/** Bengali (বাংলা)
 * @author Nasir8891
 */
$messages['bn'] = array(
	'poolcounter-desc' => 'পুল কাউন্টার ডেমনের জন্য মিডিয়াউইকি ক্লায়েন্ট',
	'poolcounter-connection-error' => 'পুল কাউন্টার সার্ভার কানেকশন ত্রুটি: $1',
	'poolcounter-read-error' => 'পুল কাউন্টার সার্ভার থেকে তথ্য পেতে সমস্যা হচ্ছে',
	'poolcounter-write-error' => 'পুল কাউন্টার সার্ভার তথ্য সংযোজন ত্রুটি',
	'poolcounter-remote-error' => 'পুল কাউন্টার সার্ভার ত্রুটি: $1',
);

/** Breton (brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'poolcounter-desc' => 'Kliant evit MediaWiki eus diaoul kanastell strollad poolcounter.py',
	'poolcounter-connection-error' => 'Fazi kevreañ ouzh servijer kanastell ar strollad : $1',
	'poolcounter-read-error' => 'Fazi lenn a-berzh servijer kanastell ar strollad',
	'poolcounter-write-error' => 'Fazi e-ser skrivañ war servijer kanastell ar strollad',
	'poolcounter-remote-error' => 'Fazi servijer kanastell ar strollad : $1',
);

/** Bosnian (bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'poolcounter-desc' => 'MediaWiki klijent daemon za pool brojač poolcounter.py',
	'poolcounter-connection-error' => 'Greška pri povezivanju na server pool brojača: $1',
	'poolcounter-read-error' => 'Greška pri čitanju sa servera pool brojača',
	'poolcounter-write-error' => 'Greška pri pisanju na server pool brojača',
	'poolcounter-remote-error' => 'Greška na serveru pool brojača: $1',
);

/** Catalan (català)
 * @author Aleator
 * @author Gemmaa
 */
$messages['ca'] = array(
	'poolcounter-desc' => "Client MediaWiki per al dimoni del ''pool counter''",
	'poolcounter-connection-error' => "S'està connectant al servidor de taulell de piscina d'error:$1",
	'poolcounter-read-error' => 'Error en llegir del servidor de taulell de piscina',
	'poolcounter-write-error' => 'Error en escriure al servidor de taulell de piscina',
	'poolcounter-remote-error' => 'Error de servidor de taulell de piscina:$1',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'poolcounter-desc' => 'Клиент MediaWiki poolcounter.py пулан доменан лорург',
);

/** Czech (česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'poolcounter-desc' => 'Klient do MediaWiki k démonovi řídícímu přístup ke clusteru',
	'poolcounter-connection-error' => 'Chyba připojování k serveru řídícímu přístup ke clusteru: $1',
	'poolcounter-read-error' => 'Chyba čtení ze serveru řídícího přístup ke clusteru',
	'poolcounter-write-error' => 'Chyba zápisu na server řídící přístup ke clusteru',
	'poolcounter-remote-error' => 'Chyba serveru řídícího přístup ke clusteru: $1',
);

/** Danish (dansk)
 * @author HenrikKbh
 */
$messages['da'] = array(
	'poolcounter-desc' => 'MediaWiki-klient til pool counter daemon',
	'poolcounter-connection-error' => 'Fejl ved tilslutning til pool counter server:$1',
	'poolcounter-read-error' => 'Fejl ved læsning fra pool counter server',
	'poolcounter-write-error' => 'Fejl under skrivning til pool counter server',
	'poolcounter-remote-error' => 'Pool counter server fejl: $1',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Purodha
 */
$messages['de'] = array(
	'poolcounter-desc' => "Ermöglicht einen ''Client'' für den ''„PoolCounter“'' eines Computerclusters",
	'poolcounter-connection-error' => 'Fehler beim Verbinden zum Server $1, auf dem sich das Zählwerk des Computerclusters befindet',
	'poolcounter-read-error' => 'Fehler beim Lesen vom Server, auf dem sich das Zählwerk des Computerclusters befindet',
	'poolcounter-write-error' => 'Fehler beim Schreiben auf dem Server, auf dem sich das Zählwerk des Computerclusters befindet',
	'poolcounter-remote-error' => 'Fehler beim Server $1, auf dem sich das Zählwerk des Computerclusters befindet',
);

/** Swiss High German (Schweizer Hochdeutsch)
 * @author Geitost
 */
$messages['de-ch'] = array(
	'poolcounter-desc' => 'stellt einen Klienten für MediaWiki für den Hintergrundprozess „poolcounter.py“ eines Computerclusters bereit',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'poolcounter-desc' => 'Muşteriyan dê MediaWiki re amardeya arey',
	'poolcounter-connection-error' => 'İrtibat de amargeya areya bırya: $1',
	'poolcounter-read-error' => 'Arden dê hewız da amari de nusno xırab',
	'poolcounter-write-error' => 'Wasterê hewız da amari de nusno xırab',
	'poolcounter-remote-error' => 'Hewız da amariya waster bırya: $1',
);

/** Lower Sorbian (dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'poolcounter-desc' => 'Klient MediaWiki za demon pool counter',
	'poolcounter-connection-error' => 'Zmólka pśi zwězowanju ze serwerom pool counter: $1',
	'poolcounter-read-error' => 'Zmólka pśi cytanju ze serwera pool counter',
	'poolcounter-write-error' => 'Zmólka pśi pisanju na serwer pool counter',
	'poolcounter-remote-error' => 'Zmólka serwera pool counter: $1',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 */
$messages['el'] = array(
	'poolcounter-desc' => 'Πελάτης για τη MediaWiki του daemon του καταμετρητή ομαδοποίησης poolcounter.py',
	'poolcounter-connection-error' => 'Σφάλμα κατά την σύνδεση με τον καταμετρητή ομαδοποίησης: $1',
	'poolcounter-read-error' => 'Σφάλμα κατά την ανάγνωση του εξυπηρετητή του καταμετρητή ομαδοποίησης',
	'poolcounter-write-error' => 'Σφάλμα κατά την εγγραφή στον εξυπηρετητή του καταμετρητή ομαδοποίησης',
	'poolcounter-remote-error' => 'Σφάλμα του εξυπηρετητή του καταμετρητή ομαδοποίησης: $1',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'poolcounter-desc' => 'MediaWiki-kliento por la demono de grupokontilo',
	'poolcounter-connection-error' => 'Eraro konektante al grupokontila servilo: $1',
	'poolcounter-read-error' => 'Eraro legante de la grupokontila servilo',
	'poolcounter-write-error' => 'Eraro skribante al la grupokontila servilo',
	'poolcounter-remote-error' => 'Eraro de la grupokontila servilo: $1',
);

/** Spanish (español)
 * @author Crazymadlover
 * @author Translationista
 */
$messages['es'] = array(
	'poolcounter-desc' => 'Cliente MediaWiki para demonio del contador de encuestas poolcounter.py',
	'poolcounter-connection-error' => 'Error conectando al servidor contador de encuestas: $1',
	'poolcounter-read-error' => 'Error leyendo del servidor contador de encuestas',
	'poolcounter-write-error' => 'Error escribiendo al servidor contador de encuestas',
	'poolcounter-remote-error' => 'Error del servidor contador de encuestas: $1',
);

/** Persian (فارسی)
 * @author Wayiran
 */
$messages['fa'] = array(
	'poolcounter-desc' => 'کارخواه مدیاویکی برای دیو باجهٔ مخزن',
	'poolcounter-connection-error' => 'خطا در اتصال به کارساز باجهٔ مخزن: $1',
	'poolcounter-read-error' => 'خطا در خواندن از کارساز باجهٔ مخزن',
	'poolcounter-write-error' => 'خطا در نوشتن در کارساز باجهٔ مخزن',
	'poolcounter-remote-error' => 'خطای کارساز باجهٔ مخزن: $1',
);

/** Finnish (suomi)
 * @author Nedergard
 * @author Nike
 */
$messages['fi'] = array(
	'poolcounter-desc' => 'MediaWiki-asiakasohjelma varantolaskuritaustapalvelun käyttöön',
	'poolcounter-connection-error' => 'Yhteyden muodostaminen varantolaskuripalvelimeen epäonnistui: $1',
	'poolcounter-read-error' => 'Varantolaskuripalvelimen lukuvirhe',
	'poolcounter-write-error' => 'Varantolaskuripalvelimen kirjoitusvirhe',
	'poolcounter-remote-error' => 'Varantolaskuripalvelimen virhe: $1',
);

/** French (français)
 * @author IAlex
 * @author Urhixidur
 */
$messages['fr'] = array(
	'poolcounter-desc' => 'Client pour MediaWiki du démon de compteur de groupement',
	'poolcounter-connection-error' => 'Erreur lors de la connexion au compteur de groupement : $1',
	'poolcounter-read-error' => 'Erreur lors de la lecture du serveur du compteur de groupement',
	'poolcounter-write-error' => "Erreur lors de l'écriture sur le serveur du compteur de groupement",
	'poolcounter-remote-error' => 'Erreur du serveur du compteur de groupement : $1',
);

/** Franco-Provençal (arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'poolcounter-desc' => 'Cliant por MediaWiki du dèmon du comptor de ressôrses comenes',
	'poolcounter-connection-error' => 'Èrror pendent lo branchement u sèrvor du comptor de ressôrses comenes : $1',
	'poolcounter-read-error' => 'Èrror pendent la lèctura du sèrvor du comptor de ressôrses comenes',
	'poolcounter-write-error' => 'Èrror pendent l’ècritura sur lo sèrvor du comptor de ressôrses comenes',
	'poolcounter-remote-error' => 'Èrror du sèrvor du comptor de ressôrses comenes : $1',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'poolcounter-desc' => 'Cliente para MediaWiki do servidor de contador de recursos comúns poolcounter.py',
	'poolcounter-connection-error' => 'Erro na conexión co servidor de contador de recursos comúns: $1',
	'poolcounter-read-error' => 'Erro na lectura do servidor de contador de recursos comúns',
	'poolcounter-write-error' => 'Erro na escritura do servidor de contador de recursos comúns',
	'poolcounter-remote-error' => 'Erro do servidor de contador de recursos comúns: $1',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'poolcounter-desc' => 'MediaWiki-Client fir dr Poolcounter-Daemon',
	'poolcounter-connection-error' => 'Fähler bim Verbinde zum Poolcounter-Server: $1',
	'poolcounter-read-error' => 'Fähler bim Läse vum Poolcounter-Server',
	'poolcounter-write-error' => 'Fähler bim Schrybe an Poolcounter-Server',
	'poolcounter-remote-error' => 'Poolcounter-Server-Fähler: $1',
);

/** Gujarati (ગુજરાતી)
 * @author Sushant savla
 */
$messages['gu'] = array(
	'poolcounter-desc' => 'પૂલ કૌન્ટર ડાઍમન નો મિડિયા વિકિ ગ્રાહક',
	'poolcounter-connection-error' => 'પૂલ ગણક સર્વર સાથે જોડાણમાં ત્રુટી : $1',
	'poolcounter-read-error' => 'પૂલ ગણક સર્વર પર વાંચવામાં ત્રુટી',
	'poolcounter-write-error' => 'પૂલ ગણક સર્વર પર લખવામાં ત્રુટી',
	'poolcounter-remote-error' => 'પૂલ ગણક સર્વર ત્રુટી: $1',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Guycn2
 */
$messages['he'] = array(
	'poolcounter-desc' => 'לקוח מדיה־ויקי לשרת דלפק מאגר',
	'poolcounter-connection-error' => 'שגיאת התחברות לשרת דלפק מאגר: $1',
	'poolcounter-read-error' => 'שגיאת קריאה משרת דלפק מאגר',
	'poolcounter-write-error' => 'שגיאת כתיבה לשרת דלפק מאגר',
	'poolcounter-remote-error' => 'שגיאת שרת דלפק מאגר: $1',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'poolcounter-remote-error' => 'पूल काउंटर सर्वर त्रुटि: $1',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'poolcounter-desc' => 'Klient MediaWiki demona skupinskeho ličaka poolcounter.py',
	'poolcounter-connection-error' => 'Zmylk při zwjazowanju ze serwerom skupinskeho ličaka: $1',
	'poolcounter-read-error' => 'Zmylk při čitanju ze serwera skupinskeho ličaka',
	'poolcounter-write-error' => 'Zmylk při pisanju na serwer skupinskeho ličaka',
	'poolcounter-remote-error' => 'Zmylk serwera skupinskeho ličaka: $1',
);

/** Hungarian (magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'poolcounter-desc' => 'MediaWiki kliens a poolcounter.py démonhoz',
	'poolcounter-connection-error' => 'Hiba a pool counter szerverhez való kapcsolódáskor: $1',
	'poolcounter-read-error' => 'Hiba a pool counter szerverről való olvasáskor',
	'poolcounter-write-error' => 'Hiba a pool counter szerverre való íráskor',
	'poolcounter-remote-error' => 'Pool counter szerver hiba: $1',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'poolcounter-desc' => 'Cliente MediaWiki pro le daemon contator de ressources commun poolcounter.py',
	'poolcounter-connection-error' => 'Error durante le connexion al contator de ressources commun: $1',
	'poolcounter-read-error' => 'Error durante le lectura del contator de ressources commun',
	'poolcounter-write-error' => 'Error durante le scriptura al contator de ressources commun',
	'poolcounter-remote-error' => 'Error del contator de ressources commun: $1',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 */
$messages['id'] = array(
	'poolcounter-desc' => 'Klien MediaWiki untuk daemon poolcounter.py',
	'poolcounter-connection-error' => 'Kesalahan pada saat berusaha menghubungi server pool counter: $1',
	'poolcounter-read-error' => 'Kesalahan pada saat berusaha membaca server pool counter',
	'poolcounter-write-error' => 'Kesalahan pada saat berusaha menulis peladen pool counter',
	'poolcounter-remote-error' => 'Kesalahan server pool server: $1',
);

/** Interlingue (Interlingue)
 * @author Renan
 */
$messages['ie'] = array(
	'poolcounter-desc' => 'Client MediaWiki por li contator pool daemon',
	'poolcounter-connection-error' => 'Errore conexent por servitor de contator de funde comun: $1',
	'poolcounter-read-error' => 'Errore leent de servitor de contator de funde comun',
	'poolcounter-write-error' => 'Errore scrint por servitor de contator de funde comun',
	'poolcounter-remote-error' => 'Errore de servitor de contator de funde comun: $1',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'poolcounter-desc' => 'Kliente ti MediaWiki para iti panag-bliang ti nairaman a daemon',
	'poolcounter-connection-error' => 'Biddut ti pannakaikabit ti nairaman a panagbilang ti server: $1',
	'poolcounter-read-error' => 'Biddut ti panagbasa manipud idiay nairaman a panagbilang ti server.',
	'poolcounter-write-error' => 'Biddut ti panagsurat idiay nairaman a panagbilang ti server.',
	'poolcounter-remote-error' => 'Biddut ti nairaman a panagbilang ti server: $1',
);

/** Italian (italiano)
 * @author F. Cosoleto
 */
$messages['it'] = array(
	'poolcounter-desc' => 'Client di MediaWiki per il demone contatore dei pool',
	'poolcounter-connection-error' => 'Errore di connessione al server contatore dei pool: $1',
	'poolcounter-read-error' => 'Errore di lettura dal server contatore dei pool',
	'poolcounter-write-error' => 'Errore di scrittura al server contatore dei pool',
	'poolcounter-remote-error' => 'Errore del server contatore dei pool: $1',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Shirayuki
 */
$messages['ja'] = array(
	'poolcounter-desc' => 'プール カウンター デーモン poolcounter.py の MediaWiki クライアント',
	'poolcounter-connection-error' => 'プール カウンター サーバーに接続する際にエラーが発生しました: $1',
	'poolcounter-read-error' => 'プール カウンター サーバーから読み込む際にエラーが発生しました。',
	'poolcounter-write-error' => 'プール カウンター サーバーに書き込む際にエラーが発生しました。',
	'poolcounter-remote-error' => 'プール カウンター サーバーのエラー: $1',
);

/** Javanese (Basa Jawa)
 * @author NoiX180
 */
$messages['jv'] = array(
	'poolcounter-desc' => "Klièn MediaWiki kanggo daèmon ''pool counter''",
	'poolcounter-connection-error' => "Kasalahan ngubungaké nèng sasana ''pool counter'': $1",
	'poolcounter-read-error' => "Kasalahan maca saka sasana ''pool counter''",
	'poolcounter-write-error' => "Ora bisa nulis nèng sasana ''counter pool''",
	'poolcounter-remote-error' => "Kasalahan sasana ''counter pool'': $1",
);

/** Georgian (ქართული)
 * @author David1010
 */
$messages['ka'] = array(
	'poolcounter-desc' => 'MediaWiki-ს კლიენტი პულის მრიცხველის დაემონისთვის',
	'poolcounter-connection-error' => 'შეცდომა პულის მრიცხველის სერვერთან დაკავშირებისას: $1',
	'poolcounter-read-error' => 'პულის მრიცხველის სერვერის წაკითხვის შეცდომა',
	'poolcounter-write-error' => 'ჩანაწერის შეცდომა პულის მრიცხველის სერვერის მიმართვისას',
	'poolcounter-remote-error' => 'პულის მთვლელის სერვერის შეცდომა: $1',
);

/** Korean (한국어)
 * @author Kwj2772
 * @author 아라
 */
$messages['ko'] = array(
	'poolcounter-desc' => 'pool 카운터 데몬을 위한 미디어위키 클라이언트',
	'poolcounter-connection-error' => '풀 카운터 서버에 접속하는 중 오류: $1',
	'poolcounter-read-error' => '풀 카운터 서버 읽기 오류',
	'poolcounter-write-error' => '풀 카운터 서버 쓰기 오류',
	'poolcounter-remote-error' => '풀 카운터 서버 오류: $1',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'poolcounter-desc' => 'Ene MediaWiki <i lang="en">client</i> för dat Hengerjrondprojramm <code lang="en">poolcounter.py</code> för et Parraatshtonn vun enem Pöngel vun Prozessore ze verwallde',
	'poolcounter-connection-error' => 'Beim Verbenge met däm ẞööver för et Parraatshtonn vun enem Pöngel vun Prozessore ze verwallde, es ene Fähler opjetrodde: $1',
	'poolcounter-read-error' => 'Beim Lässe vum ẞööver för et Parraatshtonn vun enem Pöngel vun Prozessore ze verwallde, es ene Fähler opjetrodde.',
	'poolcounter-write-error' => 'Beim Schriive noh däm ẞööver för et Parraatshtonn vun enem Pöngel vun Prozessore ze verwallde, es ene Fähler opjetrodde.',
	'poolcounter-remote-error' => 'Dä ẞööver för et Parraatshtonn vun enem Pöngel vun Prozessore ze verwallde hät dä Fähler „$1“ jemeldt.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'poolcounter-desc' => 'Mediawiki-Client fir de Pool-Counter-Daemon',
	'poolcounter-connection-error' => 'Feeler beim Verbanne mam Pool-Counter-Server: $1',
	'poolcounter-read-error' => 'Feeler beim Liese vum Pool-Counter-Server',
	'poolcounter-write-error' => 'Feeler beim Schreiwen op de Pool-Counter-Server',
	'poolcounter-remote-error' => 'Pool-counter-Server Feeler: $1',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'poolcounter-desc' => 'MediaWiki-client veure poolcounter daemon',
	'poolcounter-connection-error' => "Fout bie 't verbinje mitte poolcounterserver: $1",
	'poolcounter-read-error' => "Fout bie 't laeze vanne poolcounterserver",
	'poolcounter-write-error' => "Fout bie 't sjriever nao de poolcounterserver",
	'poolcounter-remote-error' => 'Poolcounterserverfout: $1',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'poolcounter-desc' => 'МедијаВики клиент за  демонот на фондовскиот шалтер poolcounter.py',
	'poolcounter-connection-error' => 'Грешка при поврзувањето со опслужувачот на фондовскиот шалтер:  $1',
	'poolcounter-read-error' => 'Грешка први читањето од опслужувачот на фондовскиот шалтер',
	'poolcounter-write-error' => 'Грешка при запишувањето во опслужувачот на фондовскиот шалтер',
	'poolcounter-remote-error' => 'Грешка во опслужувачот на фондовскиот шалтер: $1',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'poolcounter-desc' => 'പൂൾ കൗണ്ടർ ഡീമണുള്ള മീഡിയവിക്കി ക്ലയന്റ്',
	'poolcounter-connection-error' => 'പൂൾ കൗണ്ടർ സെർവറുമായി ബന്ധപ്പെടുന്നതിൽ പിഴവുണ്ടായി: $1',
	'poolcounter-read-error' => 'പൂൾ കൗണ്ടർ സെർവറിൽ നിന്ന് വിവരങ്ങൾ ലഭ്യമാക്കുന്നതിൽ പിഴവുണ്ടായി',
	'poolcounter-write-error' => 'പൂൾ കൗണ്ടർ ഡീമണിൽ വിവരങ്ങൾ ചേർക്കുന്നതിൽ പിഴവുണ്ടായി',
	'poolcounter-remote-error' => 'പൂൾ കൗണ്ടർ സെർവർ പിഴവ്: $1',
);

/** Marathi (मराठी)
 * @author Mahitgar
 * @author Rahuldeshmukh101
 */
$messages['mr'] = array(
	'poolcounter-desc' => 'pool counter daemon करिता मिडियाविकि क्लाएंट',
	'poolcounter-connection-error' => 'पूल काउंटर दाताशी संपर्क करण्यात त्रूटी आलेली आहे : $1',
	'poolcounter-read-error' => 'पूल काउंटर दाता कडून माहिती मिळवण्यात त्रूटी आलेली आहे',
	'poolcounter-write-error' => 'पूल काउंटर दातावर माहिती लिहतांना त्रूटी आलेली आहे',
	'poolcounter-remote-error' => 'पूल काउंटर दाता त्रूटी : $1',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'poolcounter-desc' => 'Klien MediaWiki untuk demon kaunter tabung',
	'poolcounter-connection-error' => 'Ralat ketika bersambung dengan pelayan kaunter tabung: $1',
	'poolcounter-read-error' => 'Ralat ketika membaca dari pelayan kaunter tabung',
	'poolcounter-write-error' => 'Ralat ketika menulis ke pelayan kaunter tabung',
	'poolcounter-remote-error' => 'Ralat pelayan kaunter tabung: $1',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Nghtwlkr
 * @author Stigmj
 */
$messages['nb'] = array(
	'poolcounter-desc' => 'MediaWiki-klient for pool counter tjeneren',
	'poolcounter-connection-error' => 'Feil ved tilkobling til pool counter tjener: $1',
	'poolcounter-read-error' => 'Feil ved lesing fra pool counter tjener',
	'poolcounter-write-error' => 'Feil ved skriving til pool counter tjeneren',
	'poolcounter-remote-error' => 'Feil på pool counter tjener: $1',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'poolcounter-desc' => 'MediaWiki-client voor de poolcounter daemon',
	'poolcounter-connection-error' => 'Fout bij het verbinden met de poolcounter server: $1',
	'poolcounter-read-error' => 'Fout bij het lezen van de poolcounter server',
	'poolcounter-write-error' => 'Fout bij het schrijven naar de poolcounter server',
	'poolcounter-remote-error' => 'Poolcounter serverfout: $1',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'poolcounter-desc' => 'Client per MediaWiki del demon de comptador de gropament poolcounter.py',
	'poolcounter-connection-error' => 'Error al moment de la connexion al comptador de gropament : $1',
	'poolcounter-read-error' => 'Error al moment de la lectura del servidor de comptador de gropament',
	'poolcounter-write-error' => "Error al moment de l'escritura sul servidor del comptador de gropament",
	'poolcounter-remote-error' => 'Error del servidor de comptador de gropament : $1',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'poolcounter-desc' => 'ପୁଲ କାଉଣ୍ଟର ଡେମନ ନିମନ୍ତେ ମିଡ଼ିଆଉଇକି କ୍ଲାଏଣ୍ଟ',
	'poolcounter-connection-error' => 'ପୁଲ କାଉଣ୍ଟର ସର୍ଭର ସହ ଯୋଡ଼ିବାରେ ଭୁଲ: $1',
	'poolcounter-read-error' => 'ପୁଲ କାଉଣ୍ଟର ସର୍ଭର ପଢ଼ିବାରେ ଅସୁବିଧା',
	'poolcounter-write-error' => 'ପୁଲ କାଉଣ୍ଟର ସର୍ଭର ଲେଖିବାରେ ଅସୁବିଧା',
	'poolcounter-remote-error' => 'ପୁଲ କାଉଣ୍ଟର ସର୍ଭର ଅସୁବିଧା: $1',
);

/** Polish (polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'poolcounter-desc' => 'Klient MediaWiki dla demona nadzorującego klaster poolcounter.py',
	'poolcounter-connection-error' => 'Błąd podczas łączenia z serwerem nadzorującym klaster – $1',
	'poolcounter-read-error' => 'Błąd odczytu z serwera nadzorującego klaster',
	'poolcounter-write-error' => 'Błąd podczas zapisywania do serwera nadzorującego klaster',
	'poolcounter-remote-error' => 'Błąd serwera nadzorującego klaster – $1',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'poolcounter-desc' => "Client për MediaWiki dël demon ëd conteur d'argropament",
	'poolcounter-connection-error' => 'Eror an colegandse al server ëd pool counter: $1',
	'poolcounter-read-error' => 'Eror an lesend dal server ëd pool counter',
	'poolcounter-write-error' => 'Eror an scrivend al server ëd pool counter',
	'poolcounter-remote-error' => 'Eror dël server ëd pool counter: $1',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'poolcounter-desc' => 'میڈیاوکی کلائینٹ پول کاؤنٹر ڈیمن لئی',
	'poolcounter-connection-error' => 'غلطی پول کاؤنٹر سرور نال جڑن توں:$1',
	'poolcounter-read-error' => 'پول کاؤنٹر سورس نوں پڑھن چ غلطی',
	'poolcounter-write-error' => 'پول کاؤنٹر سرور نوں لکھن چ غلطی',
	'poolcounter-remote-error' => 'پول کاؤنٹر سرور غلطی: $1',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'poolcounter-desc' => "Cliente MediaWiki para o ''pool counter daemon''",
	'poolcounter-connection-error' => "Erro na ligação ao servidor ''pool counter'': $1",
	'poolcounter-read-error' => "Erro ao ler o servidor ''pool counter''",
	'poolcounter-write-error' => "Erro ao escrever no servidor ''pool counter''",
	'poolcounter-remote-error' => "Erro do servidor ''pool counter'': $1",
);

/** Brazilian Portuguese (português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'poolcounter-desc' => 'Cliente mediawiki para o pool counter daemon',
	'poolcounter-connection-error' => 'Erro ao conectar ao servidor do pool counter: $1',
	'poolcounter-read-error' => 'Erro ao ler do servidor do pool counter',
	'poolcounter-write-error' => 'Erro ao escrever no servidor do pool counter',
	'poolcounter-remote-error' => 'Erro no servidor do pool counter: $1',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'poolcounter-desc' => 'Cliende MediaUicchi pu demone ca conde le pool',
	'poolcounter-connection-error' => "Errore de connessione a 'u server ca conde le pool: $1",
	'poolcounter-read-error' => "Errore leggenne da 'u server ca conde le pool.",
	'poolcounter-write-error' => "Errore scrivenne sus a 'u server ca conde le pool.",
	'poolcounter-remote-error' => "Errore sus a 'u server ca conde le pool: $1",
);

/** Russian (русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'poolcounter-desc' => 'Клиент MediaWiki для демона счётчика пула poolcounter.py',
	'poolcounter-connection-error' => 'Ошибка при подключении к серверу-счётчику пула: $1',
	'poolcounter-read-error' => 'Ошибка чтения с сервера-счётчика пула',
	'poolcounter-write-error' => 'Ошибка записи при обращении к серверу-счётчику пула',
	'poolcounter-remote-error' => 'Ошибка сервера-счётчика пула: $1',
);

/** Rusyn (русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'poolcounter-desc' => 'MediaWiki кліент про службу засобне раховадло',
	'poolcounter-connection-error' => 'Хыба при споїню на засобный рахуючій сервер: $1',
	'poolcounter-read-error' => 'Хыба чітаня з засобного рахуючого сервера',
	'poolcounter-write-error' => 'Хыба записованя до засобного рахуючого сервера',
	'poolcounter-remote-error' => 'Хыба засобного сервера рахованя: $1',
);

/** Sanskrit (संस्कृतम्)
 * @author Shubha
 */
$messages['sa'] = array(
	'poolcounter-desc' => 'पूल् कौण्टर् डीमन् कृते मेटावीकी क्लैण्ट्',
	'poolcounter-connection-error' => 'पूल् कौण्टर् वितरकेण सह सम्बन्धकल्पने दोषः : $1',
	'poolcounter-read-error' => 'पूल् कौण्टर् वितरकात् पठनावसरे दोषः',
	'poolcounter-write-error' => 'पूल् कौण्टर् वितरके लेखनावसरे दोषः',
	'poolcounter-remote-error' => 'पूल् कौण्टर् वितरकदोषः : $1',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'poolcounter-desc' => 'සංසද ගණක විනාශකාරී පුද්ගලයා සඳහා වූ මාධ්‍ය විකි සේවාදායකයා',
	'poolcounter-connection-error' => 'සංසද ගණක සර්වරය වෙත සම්බන්ධවීමේ දෝෂය: $1',
	'poolcounter-read-error' => 'සංසද ගණක සර්වරය වෙතින් කියවීමේ දෝෂය',
	'poolcounter-write-error' => 'සංසද ගණක සර්වරය වෙත ලිවීමේ දෝෂය',
	'poolcounter-remote-error' => 'සංසද ගණක සර්වරයේ දෝෂය: $1',
);

/** Slovak (slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'poolcounter-desc' => 'Klient MediaWiki démona počítadla skupiny poolcounter.py',
	'poolcounter-connection-error' => 'Chyba pri pripájaní na server počítadla skupiny: $1',
	'poolcounter-read-error' => 'Chyba pri čítaní zo servera počítadla skupiny',
	'poolcounter-write-error' => 'Chyba pri zapisovaní na server počítadla skupiny',
	'poolcounter-remote-error' => 'Chyba servera počítadla skupiny: $1',
);

/** Slovenian (slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'poolcounter-desc' => 'Odjemalec MediaWiki za prikriti proces založnega pulta',
	'poolcounter-connection-error' => 'Napaka pri povezovanju s strežnikom založnega pulta: $1',
	'poolcounter-read-error' => 'Napaka pri branju iz strežnika založnega pulta',
	'poolcounter-write-error' => 'Napaka pri pisanju v strežnik založnega pulta',
	'poolcounter-remote-error' => 'Napaka strežnika založnega pulta: $1',
);

/** Albanian (shqip)
 * @author Vinie007
 */
$messages['sq'] = array(
	'poolcounter-desc' => 'MediaWiki klient për dreq lloto counter',
	'poolcounter-connection-error' => 'Gabim gjatë lidhjes me server pishinë counter: $1',
	'poolcounter-read-error' => 'Gabim leximi nga pishinë server counter',
	'poolcounter-write-error' => 'Gabim gjatë shkrimit në server pishinë counter',
	'poolcounter-remote-error' => 'server error counter Pool: $1',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'poolcounter-desc' => 'Медијавики клијент за демона фондовског шалтера poolcounter.py',
	'poolcounter-connection-error' => 'Грешка при повезивању са сервером фондовског шалтера: $1',
	'poolcounter-read-error' => 'Грешка при читању са сервера фондовског шалтера',
	'poolcounter-write-error' => 'Грешка при писању на сервер фондовског шалтера',
	'poolcounter-remote-error' => 'Грешка у серверу фондовског шалтера: $1',
);

/** Serbian (Latin script) (srpski (latinica)‎)
 */
$messages['sr-el'] = array(
	'poolcounter-desc' => 'Medijaviki klijent za demona fondovskog šaltera poolcounter.py',
	'poolcounter-connection-error' => 'Greška pri povezivanju sa serverom fondovskog šaltera: $1',
	'poolcounter-read-error' => 'Greška pri čitanju sa servera fondovskog šaltera',
	'poolcounter-write-error' => 'Greška pri pisanju na server fondovskog šaltera',
	'poolcounter-remote-error' => 'Greška u serveru fondovskog šaltera: $1',
);

/** Swedish (svenska)
 * @author Ainali
 */
$messages['sv'] = array(
	'poolcounter-desc' => 'MediaWiki klient för pool counter daemon',
	'poolcounter-connection-error' => 'Fel vid anslutning till pool counter server: $1',
	'poolcounter-read-error' => 'Fel vid läsning från pool counter server',
	'poolcounter-write-error' => 'Fel vid skrivning till pool counter server',
	'poolcounter-remote-error' => 'Pool counter server fel: $1',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 */
$messages['ta'] = array(
	'poolcounter-connection-error' => 'தொகுப்பு(pool) எதிர் சேவையகத்தில் இணைப்பதில் பிழை:$1',
	'poolcounter-read-error' => 'குள வருகையாளர் சேவகனில் இருந்து வாசிக்கையில் பிழை',
	'poolcounter-write-error' => 'குள வருகையாளர் சேவகன் எழுதுகையில் பிழை',
	'poolcounter-remote-error' => 'குள வருகையாளர் சேவகன் பிழை:$1',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'poolcounter-desc' => 'Kliyente ng MediaWiki para sa pambilang ng lawa ng  poolcounter.py ng daemon',
	'poolcounter-connection-error' => 'Kamalian sa pagkunekta sa tagapaghain ng pambilang ng lawa: $1',
	'poolcounter-read-error' => 'Maling pagbasa mula sa tagapaghain ng pambilang ng lawa',
	'poolcounter-write-error' => 'Kamalian sa pagsulat sa tagapaghain ng pambilang ng lawa',
	'poolcounter-remote-error' => 'Kamalian sa tagapaghain ng pambilang ng lawa: $1',
);

/** Ukrainian (українська)
 * @author Dim Grits
 */
$messages['uk'] = array(
	'poolcounter-desc' => 'Клієнт MediaWiki для демона лічильника пулу',
	'poolcounter-connection-error' => "Помилка з'єднання з сервером лічильника пулу: $1",
	'poolcounter-read-error' => 'Помилка зчитування з сервера лічильника пулу',
	'poolcounter-write-error' => 'Помилка запису до сервера лічильника пулу',
	'poolcounter-remote-error' => 'Помилка сервера лічильника пулу: $1',
);

/** Urdu (اردو)
 * @author පසිඳු කාවින්ද
 */
$messages['ur'] = array(
	'poolcounter-read-error' => 'پول کے انسداد کے سرور سے پڑھنے کی خرابی',
	'poolcounter-write-error' => 'لکھنے کے پول انسداد سرور کی غلطی',
);

/** vèneto (vèneto)
 * @author GatoSelvadego
 */
$messages['vec'] = array(
	'poolcounter-desc' => "Client de MediaWiki pa'l demone contador de i pool",
	'poolcounter-connection-error' => 'Eror de conesion al server contador de i pool: $1',
	'poolcounter-read-error' => 'Eror de letura dal server contador de i pool',
	'poolcounter-write-error' => 'Eror de scritura al server contador de i pool',
	'poolcounter-remote-error' => 'Eror del server contador de i pool: $1',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'poolcounter-desc' => 'Trình khách MediaWiki cho trình nền chia việc xử lý (pool counter daemon)',
	'poolcounter-connection-error' => 'Lỗi kết nối với máy chủ chia việc xử lý (pool counter server): $1',
	'poolcounter-read-error' => 'Lỗi đọc từ máy chủ chia việc xử lý (pool counter server)',
	'poolcounter-write-error' => 'Lỗi ghi vào máy chủ chia việc xử lý (pool counter server)',
	'poolcounter-remote-error' => 'Lỗi máy chủ chia việc xử lý (pool counter server): $1',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'poolcounter-desc' => 'MediaWiki 客户端的池计数器守护进程',
	'poolcounter-connection-error' => '连接池计数器服务器的错误：$1',
	'poolcounter-read-error' => '从池计数器服务器读取时出错',
	'poolcounter-write-error' => '池计数器服务器写入时出现错误',
	'poolcounter-remote-error' => '池计数器服务器错误：$1',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'poolcounter-desc' => '頁面的客戶端守護進程池計數器',
	'poolcounter-connection-error' => '連接至連接池計數器服務器發生錯誤$1',
	'poolcounter-read-error' => '從服務器池計數器中錯誤讀取',
	'poolcounter-write-error' => '錯誤寫入至服務器池計數器',
	'poolcounter-remote-error' => '服務器池計數器錯誤：$1',
);
