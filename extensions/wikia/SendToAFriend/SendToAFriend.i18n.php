<?php
if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SiteWideMessages.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
		'invitespecialpage'        => 'Invite friends to join Wikia',	//the name displayed on Special:SpecialPages
		'stf_button'               => 'Send this article to a friend',
		'stf_after_reg'            => 'Invite a friend to join Wikia! [[Special:InviteSpecialPage|Click here]].',
		'stf_subject'              => '$2 has sent you an article from $1!',
		'stf_confirm'              => 'Message sent! Invite others?',
		'stf_error'                => 'Error sending email.',
		'stf_error_name'           => 'You didn\'t provide your name.',
		'stf_error_from'           => 'You didn\'t provide your email address.',
		'stf_error_to'             => 'You didn\'t provide your friend\'s email address.',
		'stf_frm1'                 => 'Your email address: ',
		'stf_frm2'                 => 'Email addresses (More than one? Separate with commas) ',
		'stf_msg_label'            => 'Message to be send',
		'stf_name_label'           => 'Your name',
		'stf_email_label'          => 'Your email',
		'stf_frm3_send'            => "Hi!\n\n\$1 thought you'd like this page from Wikia!\n\n$2\n\nCome check it out!",
		'stf_frm3_invite'          => "Hi!\n\nI just joined this wiki at Wikia...  \$1\n\nCome check it out!",
		'stf_frm4_send'            => 'Send',
		'stf_frm4_cancel'          => 'Cancel',
		'stf_frm4_invite'          => 'Send Invite!',
		'stf_multiemail'           => 'Send to more than one recipient?',
		'stf_frm5'                 => '(the URL of this site will be appended to your message)',
		'stf_frm6'                 => 'Close this window',
		'stf_throttle'             => 'For security reasons, you can only send $1 invites a day.',
		'stf_abuse'                => "This email was sent by $1 via Wikia.\nIf you think this was sent in error, please let us know at support@wikia.com.\n",
		'stf_ctx_invite'           => 'More than one? Separate with commas - up to $1!',
		'stf_ctx_check'            => 'Check Contacts',
		'stf_ctx_empty'            => 'You have no contacts in this account.',
		'stf_ctx_invalid'          => 'Login or password you typed is invalid. Please try again.',
		'stf_sending'	           => 'Please wait...',
		'stf_email_sent'           => 'Send confirmation',
		'stf_back_to_article'      => 'Back to article',
		'stf_most_emailed'         => 'Most emailed articles on $1 today:',
		'stf_most_popular'         => 'Most popular articles on $1:',
		'stf_choose_from_existing' => 'Choose from your existing contacts:',
		'stf_add_emails'           => 'Add Email Addresses:',
		'stf_your_email'           => 'Your Email Service',
		'stf_your_login'           => 'Your Login Name',
		'stf_your_password'        => 'Your Password',
		'stf_your_name'            => 'Your name',
		'stf_your_address'         => 'Your email address',
		'stf_your_friends'         => 'Your friend\'s|email addresses',
		'stf_we_dont_keep'         => ' We don\'t keep this email / password',
		'stf_need_approval'        => 'No emails sent without your approval',
		'stf_message'              => 'Message',
		'stf_instructions'         => '1. Select friends.|2. Click "$1"',
		'stf_select_all'           => 'Select all',
		'stf_select_friends'       => 'Select Friends:',
	),
	'pl' => array(
		'invitespecialpage'        => 'Zaproś znajomych do Wikii!',
		'stf_button'               => 'Wyślij ten artykuł do znajomego',
		'stf_after_reg'            => 'Zaproś znajomego do Wikii! [[Special:InviteSpecialPage|Kliknij tutaj]].',
		'stf_subject'              => '$2 wysłał(a) Ci artykuł z $1!',
		'stf_confirm'              => 'Zaproszenie wysłane! Zaprosić następnych?',
		'stf_error'                => 'Błąd podczas wysyłania emaila.',
		'stf_error_name'           => 'Nie podałeś swojego imienia.',
		'stf_error_from'           => 'Nie podałeś swojego adresu email.',
		'stf_error_to'             => 'Nie podałeś adresu email swojego przyjaciela.',
		'stf_frm1'                 => 'Twój adres email: ',
		'stf_frm2'                 => 'Adres email znajomego (Chcesz wysłać kilka emaili? Rozdziel je przecinkami)',
		'stf_msg_label'            => 'Wiadomość do wysłania',
		'stf_name_label'           => 'Twoje imię',
		'stf_email_label'          => 'Twój email',
		'stf_frm3_send'            => "Cześć!\n\n\$1 uważa, że spodoba Ci się ta strona na Wikii!\n\n$2\n\nKliknij i zobacz!",
		'stf_frm3_invite'          => "Cześć!\n\nWłaśnie dołączyłem do tego wiki na Wikii...  \$1\n\nWejdź i zobacz!",
		'stf_frm4_send'            => 'Wyślij',
		'stf_frm4_cancel'          => 'Anuluj',
		'stf_frm4_invite'          => 'Zaproś!',
		'stf_multiemail'           => 'Wysłać emaile na podane adresy?',
		'stf_frm5'                 => '(URL tej strony zostanie dołączony do Twojego tekstu)',
		'stf_frm6'                 => 'Zamknij to okienko',
		'stf_throttle'             => 'Ze względów bezpieczeństwa możesz wysłać dziennie jedynie $1 zaproszeń.',
		'stf_abuse'                => "Ten email został wysłany przez $1 z Wikii.\nJeśli uważasz, że nie powinien on do Ciebie trafić, daj nam znać na support@wikia.com.\n",
		'stf_ctx_invite'           => 'Więcej niż jeden? Rozdziel przecinkami - aż do $1 !',
		'stf_ctx_check'            => 'Sprawdź Kontakty',
		'stf_ctx_empty'            => 'Lista kontaktów tego konta jest pusta.',
		'stf_ctx_invalid'          => 'Podany login lub hasło są nieprawidłowe. Proszę spróbować ponownie.',
		'stf_sending'	           => 'Proszę czekać...',
		'stf_email_sent'           => 'Potwierdzenie wysyłki',
		'stf_back_to_article'      => 'Wróć do artykułu',
		'stf_most_emailed'         => 'Najczęściej wysyłane dziś artykuły na $1:',
		'stf_most_popular'         => 'Najpopularniejsze artykuły na $1:',
		'stf_choose_from_existing' => 'Wybierz z istniejących kontaktów:',
		'stf_add_emails'           => 'Dodaj adresy:',
		'stf_your_email'           => 'Twoja usługa email',
		'stf_your_login'           => 'Twój login',
		'stf_your_password'        => 'Twoje hasło',
		'stf_your_name'            => 'Twoje imię',
		'stf_your_address'         => 'Twój adres email',
		'stf_your_friends'         => 'Adresy email|Twoich przyjaciół',
		'stf_we_dont_keep'         => ' Email i hasło nie są nigdzie zapisywane',
		'stf_need_approval'        => 'Nic nie wyślemy bez Twojej zgody',
		'stf_message'              => 'Wiadomość',
		'stf_instructions'         => '1. Wybierz przyjaciół.|2. Kliknij "$1"',
		'stf_select_all'           => 'Zaznacz wszystkich',
		'stf_select_friends'       => 'Wybierz przyjaciół:',
	)
);

$messages['de'] = array(
	'invitespecialpage' => 'Lade Freunde zu Wikia ein',
	'stf_button' => 'Artikel an einen Freund versenden',
	'stf_after_reg' => 'Lade einen Freund zu Wikia ein! [[Special:InviteSpecialPage|Klick]].',
	'stf_subject' => '$2 hat dir einen Artikel von $1 geschickt!',
	'stf_confirm' => 'Nachricht versandt! Weitere Freunde einladen?',
	'stf_error' => 'Fehler beim Mailversand.',
	'stf_error_name' => 'Du hast deinen Namen nicht angegeben.',
	'stf_error_from' => 'Du hast deine E-Mail-Adresse nicht angegeben.',
	'stf_error_to' => 'Du hast die E-Mail-Adresse deines Freundes nicht angegeben.',
	'stf_frm1' => 'Deine E-Mail-Adresse:',
	'stf_frm2' => 'E-Mail-Adressen (Mehr als eine? Trenne sie durch Kommata.)',
	'stf_msg_label' => 'Zu versendende Nachricht',
	'stf_name_label' => 'Dein Name',
	'stf_email_label' => 'Deine E-Mail-Adresse:',
	'stf_frm3_send' => 'Hi!

$1 denkt, dass dir diese Seite von Wikia gefallen könnte: $2

Wirf mal einen Blick drauf!',
	'stf_frm3_invite' => 'Hi!

Ich hab\' mich gerade bei diesem Wiki bei Wikia angemeldet: $1

Schau doch mal vorbei!',
	'stf_frm4_send' => 'Abschicken',
	'stf_frm4_cancel' => 'Abbrechen',
	'stf_frm4_invite' => 'Einladung verschicken!',
	'stf_multiemail' => 'An mehr als einen Empfänger verschicken?',
	'stf_frm5' => '(Die URL dieser Seite wird an deine Nachricht angehängt.)',
	'stf_frm6' => 'Fenster schließen',
	'stf_throttle' => 'Aus Sicherheitsgründen kannst du nur $1 Einladungen pro Tag verschicken.',
	'stf_abuse' => 'Diese E-Mail wurde über Wikia verschickt.
Wenn du glaubst, dass dieses Angebot missbraucht wird, teile uns dies bitte unter support@wikia.com mit!',
	'stf_ctx_invite' => 'Mehrere Adressen? Mit Komma getrennt - bis zu $1!',
	'stf_ctx_check' => 'Checke Kontakte',
	'stf_ctx_empty' => 'Unter diesem Benutzerkonto existieren keine Kontakte.',
	'stf_ctx_invalid' => 'Der Benutzername oder das Passwort ist ungültig. Bitte probier es noch einmal.',
	'stf_sending' => 'Etwas Geduld...',
	'stf_email_sent' => 'Bestätigung senden',
	'stf_back_to_article' => 'Zurück zum Artikel',
	'stf_most_emailed' => 'Heute am häufigsten verschickter Artikel in $1:',
	'stf_most_popular' => 'Beliebtester Artikel in $1:',
	'stf_choose_from_existing' => 'Wähle aus deinen bestehenden Kontakten:',
	'stf_add_emails' => 'E-Mail-Addressen hinzufügen:',
	'stf_your_email' => 'Dein Mail-Anbieter',
	'stf_your_login' => 'Dein Benutzername',
	'stf_your_password' => 'Dein Passwort',
	'stf_your_name' => 'Dein Name',
	'stf_your_address' => 'Deine E-Mail-Adresse',
	'stf_your_friends' => 'E-Mail-Adressen|deiner Freunde',
	'stf_we_dont_keep' => 'Diese E-Mail-Adresse und das Passwort werden nicht gespeichert',
	'stf_need_approval' => 'Es werden keine E-Mails ohne deine Zustimmung verschickt',
	'stf_message' => 'Nachricht',
	'stf_instructions' => '1. Freunde auswählen.|2. "$1" klicken',
	'stf_select_all' => 'Alle auswählen',
	'stf_select_friends' => 'Freunde auswählen:',
);


$messages['es'] = array(
	'invitespecialpage' => 'Invita a tus amigos a participar en Wikia',
	'stf_button' => 'Envía este artículo a un amigo',
	'stf_after_reg' => '¡Invita a un amigo a unirse a Wikia! [[Special:InviteSpecialPage|Haz clic aquí]].',
	'stf_subject' => '$2 te ha enviado un artículo desde $1!',
	'stf_confirm' => '¡Mensaje enviado! ¿Deseas invitar a alguien más?',
	'stf_error' => 'Error enviando el correo electrónico',
	'stf_error_name' => 'No especificaste tu nombre.',
	'stf_error_from' => 'No has especificado tu dirección de correo electrónico.',
	'stf_error_to' => 'No especificaste la dirección de correo electrónico de tu amigo.',
	'stf_frm1' => 'Tu dirección de correo electrónico:',
	'stf_frm2' => 'Direcciones de correo (¿Más de una? Sepáralas con una coma).',
	'stf_msg_label' => 'Mensaje a enviar',
	'stf_name_label' => 'Tu nombre',
	'stf_email_label' => 'Tu email',
	'stf_frm3_send' => '¡Hola!

¡$1 piensa que te gustará esta página de Wikia!

$2

¡Ven a revisarla!',
	'stf_frm3_invite' => '¡Hola!

Acabo de unirme a este wiki de Wikia...  $1

¡Te invito a revisarlo!',
	'stf_frm4_send' => 'Enviar',
	'stf_frm4_cancel' => 'Cancelar',
	'stf_frm4_invite' => '¡Envía la invitación!',
	'stf_multiemail' => '¿Enviar a más de un receptor?',
	'stf_frm5' => '(la dirección de este sitio será incluida al final de tu mensaje)',
	'stf_frm6' => 'Cerrar esta ventana',
	'stf_throttle' => 'Por razones de seguridad, sólo puedes enviar $1 invitaciones por día.',
	'stf_abuse' => 'Este email fue enviado por $1 via Wikia.
Si piensas que fue enviado por error, por favor háznoslo saber a support@wikia.com',
	'stf_ctx_invite' => '¿Más de una? Sepáralas con comas, ¡puedes ingresar hasta $1 !',
	'stf_ctx_check' => 'Comprobar contactos',
	'stf_ctx_empty' => 'No tienes contactos en esta cuenta.',
	'stf_ctx_invalid' => 'El nombre de usuario o la contraseña que escribiste no son válidos. Por favor inténtalo nuevamente.',
	'stf_sending' => 'Espera un momento, por favor...',
	'stf_email_sent' => 'Enviar confirmación',
	'stf_back_to_article' => 'Volver al artículo',
	'stf_most_emailed' => 'Artículos que más se han enviado hoy por correo electrónico en $1:',
	'stf_most_popular' => 'Artículos más populares en $1:',
	'stf_choose_from_existing' => 'Elige desde tus contactos existentes:',
	'stf_add_emails' => 'Añade direcciones de correo electrónico:',
	'stf_your_email' => 'Tu servicio de correo electrónico',
	'stf_your_login' => 'Tu nombre de usuario',
	'stf_your_password' => 'Tu contraseña',
	'stf_your_name' => 'Tu nombre',
	'stf_your_address' => 'Tu dirección de correo electrónico',
	'stf_your_friends' => 'La dirección de correo|electrónico de tu|amigo',
	'stf_we_dont_keep' => 'No conservaremos tu dirección de correo electrónico y/o contraseña',
	'stf_need_approval' => 'No se enviarán correos electrónicos sin tu aprobación',
	'stf_message' => 'Mensaje',
	'stf_instructions' => '1. Selecciona amigos.|2. Haz clic en "$1"',
	'stf_select_all' => 'Seleccionar todos',
	'stf_select_friends' => 'Seleccionar amigos:',
);


$messages['fa'] = array(
	'invitespecialpage' => 'دعوت دوستان برای پیوستن به ویکیا',
);


$messages['fi'] = array(
	'invitespecialpage' => 'Kutsu ystävä',
);


$messages['fr'] = array(
	'invitespecialpage' => 'Inviter des amis à rejoindre Wikia',
	'stf_frm4_invite' => 'Envoyer les invitations!',
	'stf_ctx_invite' => 'Plus d\'une adresse? Séparez les avec des virgules - jusqu\'à $1 !',
	'stf_ctx_check' => 'Vérification des contacts',
	'stf_choose_from_existing' => 'Choisir parmi vos contacts actuels :',
	'stf_add_emails' => 'Ajouter des adresses email',
	'stf_your_email' => 'Votre service d\'email',
	'stf_your_login' => 'Votre nom d\'utilisateur',
	'stf_your_password' => 'Votre mot de passe',
	'stf_your_name' => 'Votre nom',
	'stf_your_address' => 'Votre adresse email',
	'stf_your_friends' => 'Les adresses email|de vos amis',
	'stf_we_dont_keep' => 'Nous ne gardons pas ces email et mot de passe',
	'stf_need_approval' => 'Aucun envoi d\'email sans votre approbation',
);


$messages['ja'] = array(
	'invitespecialpage' => '友人を招待する',
	'stf_button' => 'この記事を友達に送ります',
	'stf_after_reg' => '友達をウィキアに招待してみましょう! [[Special:InviteSpecialPage|こちら]]をクリックしてください。',
	'stf_subject' => '$2さんが$1からの記事を送りました。',
	'stf_confirm' => 'メッセージを送りました! 他の人も招待しますか?',
	'stf_error' => 'メールの送信に失敗しました。',
	'stf_error_name' => 'お名前が入力されていません',
	'stf_error_from' => 'メールアドレスが入力されていません。',
	'stf_error_to' => '送信先が入力されていません',
	'stf_frm1' => '自分のメールアドレス:',
	'stf_frm2' => 'メールアドレス(ひとつ以上の場合はカンマ(,)で区切ってください)',
	'stf_msg_label' => '送信されたメッセージ',
	'stf_name_label' => '名前',
	'stf_email_label' => 'メールアドレス',
	'stf_frm3_send' => 'こんにちは!

ウィキアのこのページのがお薦めです。

$2

是非ともチェックしてみてください。',
	'stf_frm3_invite' => 'こんにちは!

ウィキアの $1 のウィキサイトに参加しました。

是非ともチェックしてみてください。',
	'stf_frm4_send' => '送信',
	'stf_frm4_cancel' => 'キャンセル',
	'stf_frm4_invite' => '招待状を送りましょう!',
	'stf_multiemail' => '二人以上に送りますか?',
	'stf_frm5' => '(このページのURLはメールに自動で含まれます)',
	'stf_frm6' => 'ウィンドウを閉じる',
	'stf_throttle' => 'セキュリティ上の理由により、一日に$1回までしか送信できません。',
	'stf_abuse' => 'このメールは、ウィキアからの送信によるものです。もし、何らかの間違いであったら、 support@wikia.com までお知らせください。',
	'stf_ctx_invite' => '一人以上の場合は、カンマ(,)で区切ってください。制限は$1人までです。',
	'stf_ctx_check' => 'アドレス帳を確認',
	'stf_ctx_empty' => 'このアカウントにアドレス帳がありません',
	'stf_ctx_invalid' => 'アカウント名、またはパスワードが違います。もう一度確認してみてください。',
	'stf_sending' => '少しお待ちください',
	'stf_email_sent' => '送信の確認',
	'stf_back_to_article' => '記事に戻る',
	'stf_most_emailed' => '$1で今日一番メールで送られた記事:',
	'stf_most_popular' => '$1の人気の記事:',
	'stf_choose_from_existing' => '下から、使っているサービスを選んでください:',
	'stf_add_emails' => '追加のメールアドレス:',
	'stf_your_email' => '利用しているメールサービス',
	'stf_your_login' => 'アカウント名',
	'stf_your_password' => 'パスワード',
	'stf_your_name' => '名前',
	'stf_your_address' => 'メールアドレス',
	'stf_your_friends' => '友達のメールアドレス',
	'stf_we_dont_keep' => 'メールアドレス、パスワードは保存しません',
	'stf_need_approval' => '承認が無いため、メールが送られませんでした。',
	'stf_message' => 'メッセージ',
	'stf_instructions' => '1. 友達を選択|2. "$1"をクリックする',
	'stf_select_all' => '全て選択',
	'stf_select_friends' => '友達を選択:',
);


$messages['zh'] = array(
	'invitespecialpage' => '邀請朋友加入Wikia',
);


$messages['zh-cn'] = array(
	'invitespecialpage' => '邀請朋友加入Wikia',
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);


$messages['zh-hk'] = array(
	'invitespecialpage' => '邀請朋友加入Wikia',
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);


$messages['zh-tw'] = array(
	'invitespecialpage' => '邀請朋友加入Wikia',
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);


$messages['zh-hans'] = array(
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);


$messages['zh-hant'] = array(
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);
