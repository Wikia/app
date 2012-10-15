<?php
/**
 * Internationalization file for the Donation Interface - GlobalCollect - extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English */
$messages['en'] = array(
	'globalcollectgateway' => 'Make your donation now',
	'globalcollect_gateway-desc' => 'GlobalCollect payment processing',
	'globalcollect_gateway-response-9130' => 'Invalid country.',
	'globalcollect_gateway-response-9140' => 'Invalid currency.',
	'globalcollect_gateway-response-9150' => 'Invalid language.',
	'globalcollect_gateway-response-400530' => 'Invalid payment method.',
	'globalcollect_gateway-response-430306' => 'Your credit card has expired. Please try a different card or one of our other payment methods.',
	'globalcollect_gateway-response-430330' => 'Invalid card number.',
	'globalcollect_gateway-response-430421' => 'Your credit card could not be validated. Please verify that all information matches your credit card profile, or try a different card.', // suspected fraud
	'globalcollect_gateway-response-430360' => 'The transaction could not be authorized. Please try a different card or one of our other payment methods.', // low funds
	'globalcollect_gateway-response-430285' => 'The transaction could not be authorized. Please try a different card or one of our other payment methods.', // do not honor
	'globalcollect_gateway-response-21000150' => 'Invalid bank account number.',
	'globalcollect_gateway-response-21000155' => 'Invalid bank code.',
	'globalcollect_gateway-response-21000160' => 'Invalid giro account number.',
	'globalcollect_gateway-response-default' => 'There was an error processing your transaction.
Please try again later.',
);

/** Message documentation (Message documentation)
 * @author Kaldari
 */
$messages['qqq'] = array(
	'globalcollectgateway' => '{{Identical|Support Wikimedia}}',
	'globalcollect_gateway-desc' => '{{desc}}',
	'globalcollect_gateway-response-9130' => 'Error message for invalid country.',
	'globalcollect_gateway-response-9140' => 'Error message for invalid currency.',
	'globalcollect_gateway-response-9150' => 'Error message for invalid language.',
	'globalcollect_gateway-response-400530' => 'Error message for invalid payment method, for example, not a valid credit card type.',
	'globalcollect_gateway-response-430306' => 'Error message for expired credit card.',
	'globalcollect_gateway-response-430330' => 'Error message for invalid card number.',
	'globalcollect_gateway-response-430421' => 'Error message for declined credit card transaction. This error may be due to incorrect information being entered into the form.',
	'globalcollect_gateway-response-430360' => 'Error message for declined credit card transaction due to insuffient funds.',
	'globalcollect_gateway-response-430285' => 'Error message for declined credit card transaction due to "do not honor" message from payment provider.',
	'globalcollect_gateway-response-21000150' => 'Error message for invalid bank account number.',
	'globalcollect_gateway-response-21000155' => 'Error message for invalid bank code.',
	'globalcollect_gateway-response-21000160' => 'Error message for invalid giro account number.',
	'globalcollect_gateway-response-default' => 'Error message if something went wrong on our side.',
);

/** Arabic (العربية)
 * @author AwamerT
 * @author Peadara
 */
$messages['ar'] = array(
	'globalcollectgateway' => 'تبرع الآن',
	'globalcollect_gateway-desc' => 'تجهيز المدفوعات جلوبالكوليكت',
	'globalcollect_gateway-response-9130' => 'إسم بلد غير صالح',
	'globalcollect_gateway-response-9140' => 'العملة غير صالح',
	'globalcollect_gateway-response-9150' => 'لغة غير صحيحة.',
	'globalcollect_gateway-response-400530' => 'طريقة الدفع غير صحيحة.',
	'globalcollect_gateway-response-430306' => 'انتهت مدة صلاحية بطاقة الائتمان الخاصة بك. الرجاء استخدام بطاقة أخرى أو أحد من وسائل الدفع الأخرى.',
	'globalcollect_gateway-response-430330' => 'رقم بطاقة غير صالح.',
	'globalcollect_gateway-response-430421' => 'تعذرالتحقق من صحة بطاقة الائتمان الخاصة بك. الرجاء التحقق من أن جميع المعلومات يطابق تعريف بطاقة الائتمان الخاصة بك، أو حاول ببطاقة مختلفة.',
	'globalcollect_gateway-response-430360' => 'لا يمكن السماح بالحركة. الرجاء استخدام بطاقة أخرى أو أحد من وسائلنا للدفع الأخرى.',
	'globalcollect_gateway-response-430285' => 'لا يمكن السماح بالحركة. الرجاء استخدام بطاقة أخرى أو أحد من وسائلنا للدفع الأخرى.',
	'globalcollect_gateway-response-21000150' => 'رقم حساب مصرفي غير صالح.',
	'globalcollect_gateway-response-21000155' => 'رمز البنك غير صالح.',
	'globalcollect_gateway-response-21000160' => 'رقم حساب جيرو غير صالح.',
	'globalcollect_gateway-response-default' => 'حدث خطأ أثناء معالجة الحركة الخاصة بك.
الرجاء المحاولة مرة أخرى لاحقاً.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'globalcollectgateway' => 'Зрабіце ахвяраваньне зараз',
	'globalcollect_gateway-desc' => 'Шлюз апрацоўкі плацяжоў GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Няслушная краіна.',
	'globalcollect_gateway-response-9140' => 'Няслушная валюта.',
	'globalcollect_gateway-response-9150' => 'Няслушная мова.',
	'globalcollect_gateway-response-400530' => 'Няслушны мэтад плацяжу.',
	'globalcollect_gateway-response-430306' => 'Вашая крэдытная картка пратэрмінаваная. Калі ласка, выкарыстайце іншую картку ці выберыце іншыя мэтады плацяжу.',
	'globalcollect_gateway-response-430330' => 'Няслушны нумар карткі.',
	'globalcollect_gateway-response-430421' => 'Вашая картка не прайшла праверку. Калі ласка, упэўніцеся, што ўсе зьвесткі па картцы слушныя, ці скарыстайцеся іншай карткай.',
	'globalcollect_gateway-response-430360' => 'Немагчыма аўтарызаваць транзакцыю. Калі ласка, скарыстайцеся іншай карткай ці выберыце іншы мэтад плацяжу.',
	'globalcollect_gateway-response-430285' => 'Немагчыма аўтарызаваць транзакцыю. Калі ласка, скарыстайцеся іншай карткай ці выберыце іншы мэтад плацяжу.',
	'globalcollect_gateway-response-21000150' => 'Няслушны нумар банкаўскага рахунку.',
	'globalcollect_gateway-response-21000155' => 'Няслушны код банку.',
	'globalcollect_gateway-response-21000160' => 'Няслушны нумар рахунку giro.',
	'globalcollect_gateway-response-default' => 'У час апрацоўкі Вашай транзакцыі ўзьнікла памылка.
Калі ласка, паспрабуйце зноў пазьней.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'globalcollect_gateway-response-9130' => 'Bro direizh.',
	'globalcollect_gateway-response-9140' => 'Moneiz direizh.',
	'globalcollect_gateway-response-9150' => 'Yezh direizh.',
	'globalcollect_gateway-response-21000150' => 'Niverenn gont-vank direizh.',
	'globalcollect_gateway-response-21000155' => 'Kod-bank direizh.',
	'globalcollect_gateway-response-21000160' => 'Niverenn gont an dreuzvankadenn direizh.',
	'globalcollect_gateway-response-default' => 'Ur fazi zo bet e-ser plediñ gant ho treuzgread.
Klaskit en-dro a-benn ur pennadig.',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'globalcollectgateway' => 'Rhoddwch nawr',
	'globalcollect_gateway-desc' => 'Prosesu taliadau trwy GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Gwlad annilys.',
	'globalcollect_gateway-response-9140' => 'Arian breiniol annilys.',
	'globalcollect_gateway-response-9150' => 'Iaith annilys.',
	'globalcollect_gateway-response-400530' => 'Modd talu annilys.',
	'globalcollect_gateway-response-430306' => 'Mae eich cerdyn credyd wedi dod i ben. Defnyddiwch gerdyn arall neu fodd gwahanol o dalu.',
	'globalcollect_gateway-response-430330' => 'Rhif annilys i gerdyn.',
	'globalcollect_gateway-response-430421' => 'Ni ddilyswyd eich cerdyn credyd. Sicrhewch bod yr holl fanylion yn gywir fel ag y maent ar eich cyfrif cerdyn credyd, neu rhowch gynnig ar gerdyn arall.',
	'globalcollect_gateway-response-430360' => "Ni ellid awdurdodi'r gweithrediad hwn. Rhowch gynnig ar gerdyn arall neu defnyddiwch modd arall o dalu.",
	'globalcollect_gateway-response-430285' => "Ni ellid awdurdodi'r gweithrediad hwn. Rhowch gynnig ar gerdyn arall neu defnyddiwch modd arall o dalu.",
	'globalcollect_gateway-response-21000150' => 'Rhif annilys i gyfrif banc.',
	'globalcollect_gateway-response-21000155' => 'Côd banc annilys.',
	'globalcollect_gateway-response-21000160' => 'Rhif annilys i gyfrif giro.',
	'globalcollect_gateway-response-default' => 'Cafwyd gwall wrth drin eich gweithrediad.
Ceisiwch eto ymhen tipyn.',
);

/** Danish (Dansk)
 * @author Peter Alberti
 */
$messages['da'] = array(
	'globalcollectgateway' => 'Doner nu',
	'globalcollect_gateway-desc' => 'Håndtering af betaling via GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Ugyldigt land.',
	'globalcollect_gateway-response-9140' => 'Ugyldig valuta.',
	'globalcollect_gateway-response-9150' => 'Ugyldigt sprog.',
	'globalcollect_gateway-response-400530' => 'Ugyldig betalingsmetode.',
	'globalcollect_gateway-response-430306' => 'Dit kreditkort er udløbet. Vær så venlig at prøve et andet kort eller en af vores andre betalingsmetoder.',
	'globalcollect_gateway-response-430330' => 'Ugyldigt kortnummer.',
	'globalcollect_gateway-response-430421' => 'Dit kreditkort kunne ikke valideres. Vær så venlig at kontrollere, at al information stemmer overens med dit kort, eller prøv med et andet kort.',
	'globalcollect_gateway-response-430360' => 'Transaktionen kunne ikke godkendes. Vær så venlig at prøve et andet kort eller en af vores andre betalingsmetoder.',
	'globalcollect_gateway-response-430285' => 'Transaktionen kunne ikke godkendes. Vær så venlig at prøve et andet kort eller en af vores andre betalingsmetoder.',
	'globalcollect_gateway-response-21000150' => 'Ugyldigt kontonummer.',
	'globalcollect_gateway-response-21000155' => 'Ugyldig bankkode.',
	'globalcollect_gateway-response-21000160' => 'Ugyldigt girokontonummer.',
	'globalcollect_gateway-response-default' => 'Der opstod en fejl under behandlingen af din transaktion.
Prøv venligst igen senere.',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'globalcollectgateway' => 'Jetzt spenden',
	'globalcollect_gateway-desc' => 'Ermöglicht die Zahlungsabwicklung durch GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Ungültiger Staat.',
	'globalcollect_gateway-response-9140' => 'Ungültige Währung.',
	'globalcollect_gateway-response-9150' => 'Ungültige Sprache.',
	'globalcollect_gateway-response-400530' => 'Ungültige Zahlungsmethode.',
	'globalcollect_gateway-response-430306' => 'Ihre Kreditkarte ist nicht mehr gültig. Bitte verwenden Sie eine andere Karte oder nutzen Sie eine andere Zahlungsmethode.',
	'globalcollect_gateway-response-430330' => 'Die Kreditkartennummer ist ungültig.',
	'globalcollect_gateway-response-430421' => 'Ihre Kreditkarte konnte nicht geprüft werden. Bitte stellen Sie sicher, dass alle Informationen denen Ihrer Kreditkarte entsprechend oder verwenden Sie eine andere Karte.',
	'globalcollect_gateway-response-430360' => 'Die Transaktion wurde nicht bestätigt. Bitte verwenden Sie eine andere Karte oder nutzen Sie eine andere Zahlungsmethode.',
	'globalcollect_gateway-response-430285' => 'Die Transaktion wurde nicht bestätigt. Bitte verwenden Sie eine andere Karte oder nutzen Sie eine andere Zahlungsmethode.',
	'globalcollect_gateway-response-21000150' => 'Die Kontonummer ist ungültig.',
	'globalcollect_gateway-response-21000155' => 'Die Bankleitzahl ist ungültig.',
	'globalcollect_gateway-response-21000160' => 'Die Girokontonummer ist ungültig.',
	'globalcollect_gateway-response-default' => 'Während des Ausführens der Transaktion ist ein Verarbeitungsfehler aufgetreten.
Bitte versuchen Sie es später noch einmal.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'globalcollect_gateway-response-430306' => 'Ihre Kreditkarte ist nicht mehr gültig. Bitte verwenden Sie eine andere Karte oder nutzen Sie eine andere Zahlungsmethode.',
	'globalcollect_gateway-response-430421' => 'Ihre Kreditkarte konnte nicht geprüft werden. Bitte stellen Sie sicher, dass alle Informationen denen Ihrer Kreditkarte entsprechend oder verwenden Sie eine andere Karte.',
	'globalcollect_gateway-response-430360' => 'Die Transaktion wurde nicht bestätigt. Bitte verwenden Sie eine andere Karte oder nutzen Sie eine andere Zahlungsmethode.',
	'globalcollect_gateway-response-430285' => 'Die Transaktion wurde nicht bestätigt. Bitte verwenden Sie eine andere Karte oder nutzen Sie eine andere Zahlungsmethode.',
	'globalcollect_gateway-response-default' => 'Während des Ausführens der Transaktion ist ein Verarbeitungsfehler aufgetreten.
Bitte versuchen Sie es später noch einmal.',
);

/** Spanish (Español)
 * @author Bea.miau
 */
$messages['es'] = array(
	'globalcollectgateway' => 'Haga su donación ahora',
	'globalcollect_gateway-response-9130' => 'País no válido',
	'globalcollect_gateway-response-9140' => 'Moneda no válida',
	'globalcollect_gateway-response-9150' => 'Idioma no válido.',
	'globalcollect_gateway-response-400530' => 'Método de pago no válido',
	'globalcollect_gateway-response-430306' => 'Su tarjeta de crédito ha caducado. Porfavor, use otra tarjeta u otro de nuestros métodos de pago.',
	'globalcollect_gateway-response-430330' => 'Número de tarjeta no válido',
	'globalcollect_gateway-response-430421' => 'Su tarjeta de crédito no puede ser validada. Porfavor, verifique que toda la información concuerda con el perfil de su tarjeta de crédito, o pruebe otra tarjeta diferente.',
	'globalcollect_gateway-response-430360' => 'La transacción no puede ser autorizada. Porfavor, pruebe otra tarjeta de crédito u otro de nuestros métodos de pago.',
	'globalcollect_gateway-response-430285' => 'La transacción no puede ser autorizada. Porfavor, pruebe otra tarjeta de crédito u otro de nuestros métodos de pago.',
	'globalcollect_gateway-response-21000150' => 'Cuenta bancaria no válida',
	'globalcollect_gateway-response-21000155' => 'Codigo bancario no válido',
	'globalcollect_gateway-response-default' => 'Hubo un error procesando su transacción.
Por favor intentelo de nuevo mas tarde.',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'globalcollectgateway' => 'Anneta kohe',
);

/** French (Français)
 * @author Gomoko
 * @author IAlex
 */
$messages['fr'] = array(
	'globalcollectgateway' => 'Faire un don maintenant',
	'globalcollect_gateway-desc' => 'Traitement des paiements GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Pays invalide.',
	'globalcollect_gateway-response-9140' => 'Monnaie invalide.',
	'globalcollect_gateway-response-9150' => 'Langue invalide.',
	'globalcollect_gateway-response-400530' => 'Méthode de paiement invalide.',
	'globalcollect_gateway-response-430306' => "Votre carte de crédit a expiré. Veuillez essayer avec une autre carte ou l'une de nos autres méthodes de paiement.",
	'globalcollect_gateway-response-430330' => 'Numéro de carte non valide.',
	'globalcollect_gateway-response-430421' => 'Votre carte de crédit ne peut pas être validée. Veuillez vérifier que toutes les informations correspondent à votre carte de crédit, ou essayez avec une autre carte.',
	'globalcollect_gateway-response-430360' => "La transaction ne peut pas être autorisée. Veuillez essayer avec une autre carte ou l'une de nos autres méthodes de paiement.",
	'globalcollect_gateway-response-430285' => "La transaction ne peut pas être autorisée. Veuillez essayer avec une autre carte ou l'une de nos autres méthodes de paiement.",
	'globalcollect_gateway-response-21000150' => 'Numéro de compte bancaire non valide.',
	'globalcollect_gateway-response-21000155' => 'Code bancaire non valide.',
	'globalcollect_gateway-response-21000160' => 'Numéro de compte du virement invalide.',
	'globalcollect_gateway-response-default' => 'Une erreur est survenue lors du traitement de votre transaction.
Veuillez réessayer plus tard.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'globalcollectgateway' => 'Balyéd orendrêt',
	'globalcollect_gateway-response-9130' => 'Payis envalido.',
	'globalcollect_gateway-response-9140' => 'Monéya envalida.',
	'globalcollect_gateway-response-9150' => 'Lengoua envalida.',
	'globalcollect_gateway-response-400530' => 'Moyen de payement envalido.',
	'globalcollect_gateway-response-430330' => 'Numerô de cârta envalido.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'globalcollectgateway' => 'Fai a túa doazón agora',
	'globalcollect_gateway-desc' => 'Procesamento de pagamentos GlobalCollect',
	'globalcollect_gateway-response-9130' => 'O país non é válido.',
	'globalcollect_gateway-response-9140' => 'A moeda non é válida.',
	'globalcollect_gateway-response-9150' => 'A lingua non é válida.',
	'globalcollect_gateway-response-400530' => 'O método de pagamento non é válido.',
	'globalcollect_gateway-response-430306' => 'A túa tarxeta de crédito caducou. Proba cunha tarxeta diferente ou con algún dos outros métodos de pagamento.',
	'globalcollect_gateway-response-430330' => 'O número de tarxeta non é válido.',
	'globalcollect_gateway-response-430421' => 'Non se puido validar a túa tarxeta de crédito. Comproba que toda a información coincide coa do perfil da tarxeta ou inténtao con outra tarxeta.',
	'globalcollect_gateway-response-430360' => 'Non se puido autorizar a transacción. Proba cunha tarxeta diferente ou con algún dos outros métodos de pagamento.',
	'globalcollect_gateway-response-430285' => 'Non se puido autorizar a transacción. Proba cunha tarxeta diferente ou con algún dos outros métodos de pagamento.',
	'globalcollect_gateway-response-21000150' => 'O número da conta bancaria non é válido.',
	'globalcollect_gateway-response-21000155' => 'O código bancario non é válido.',
	'globalcollect_gateway-response-21000160' => 'O número de conta da transferencia non é válido.',
	'globalcollect_gateway-response-default' => 'Houbo un erro ao procesar a túa transacción.
Por favor, inténtao de novo máis tarde.',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 */
$messages['gsw'] = array(
	'globalcollectgateway' => 'Jetz spände',
	'globalcollect_gateway-desc' => 'Ermöglicht d Zaaligsabwicklig dur GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Nit giltige Staat.',
	'globalcollect_gateway-response-9140' => 'Wäärig nit gültig.',
	'globalcollect_gateway-response-9150' => 'Sprooch nit gültig.',
	'globalcollect_gateway-response-400530' => 'Zaaligsmethod isch nit gültig.',
	'globalcollect_gateway-response-430306' => 'Dyni Kreditcharte isch abgloffe. Bitte probier e andri Charte oder e andri Zaaligsmethod uss.',
	'globalcollect_gateway-response-430330' => 'D Kreditchartenummer isch nit gültig.',
	'globalcollect_gateway-response-430421' => "Dyni Kreditcharte het nit chönne validiert werde. Due bitte überpriefe, ob alli Informatione mit dyner Charte überyystimme, oder probier's mit ere andre Charte.",
	'globalcollect_gateway-response-430360' => 'D Transaktion het nit chönne bstätigt werde. Nimm bitte e andri Charte oder probier e andri Zaaligsmethod uss.',
	'globalcollect_gateway-response-430285' => 'D Transaktion het nit chönne bstätigt werde. Nimm bitte e andri Charte oder probier e andri Zaaligsmethod uss.',
	'globalcollect_gateway-response-21000150' => 'D Kontonummer isch nit gültig.',
	'globalcollect_gateway-response-21000155' => 'D Bankleitzaal isch nit gültig.',
	'globalcollect_gateway-response-21000160' => 'D Girokontonummer isch nit gültig.',
	'globalcollect_gateway-response-default' => 'S het e Verarbeitigsfähler gee bi dr Uusfierig vu Dyyre Transaktion.
Bitte versuech s speter nonemol.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'globalcollectgateway' => 'תִרמו עכשיו',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'globalcollectgateway' => 'Nětko darić',
	'globalcollect_gateway-desc' => 'Zmóžnja přewjedźenje płaćenjow přez GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Njepłaćiwy kraj.',
	'globalcollect_gateway-response-9140' => 'Njepłaćiwa měna.',
	'globalcollect_gateway-response-9150' => 'Njepłaćiwa rěč.',
	'globalcollect_gateway-response-400530' => 'Njepłaćiwa płaćenska metoda.',
	'globalcollect_gateway-response-430306' => 'Waša kreditna karta hižo płaćiwy njeje. Prošu spytajće druhu kartu abo druhu płaćensku metodu.',
	'globalcollect_gateway-response-430330' => 'Njepłaćiwe kartowe čisło.',
	'globalcollect_gateway-response-430421' => 'Waša kreditna karta njeda so přepruwować. Prošu zawěsćće, zo wšě informacije wašemu profilej kreditneje karty wotpowěduja abo wužijće druhu kartu.',
	'globalcollect_gateway-response-430360' => 'Transakcija njeda so awtorizować. Prošu wužijće druhu kartu abo druhu płaćensku metodu.',
	'globalcollect_gateway-response-430285' => 'Transakcija njeda so awtorizować. Prošu wužijće druhu kartu abo druhu płaćensku metodu.',
	'globalcollect_gateway-response-21000150' => 'Njepłaćiwe kontowe čisło.',
	'globalcollect_gateway-response-21000155' => 'Njepłaćiwe bankowe wodźenske čisło.',
	'globalcollect_gateway-response-21000160' => 'Njepłaćiwe girokontowe čisło.',
	'globalcollect_gateway-response-default' => 'Při předźěłowanju wašeje transakcije je zmylk wustupił.
Prošu spytajće pozdźišo hišće raz.',
);

/** Hungarian (Magyar)
 * @author Dj
 * @author Misibacsi
 */
$messages['hu'] = array(
	'globalcollectgateway' => 'Adakozz most',
	'globalcollect_gateway-desc' => 'GlobalCollect fizetés feldolozása',
	'globalcollect_gateway-response-9130' => 'Érvénytelen ország.',
	'globalcollect_gateway-response-9140' => 'Érvénytelen pénznem.',
	'globalcollect_gateway-response-9150' => 'Érvénytelen nyelv.',
	'globalcollect_gateway-response-400530' => 'Érvénytelen fizetési mód.',
	'globalcollect_gateway-response-430306' => 'A hitelkártyád lejárt. Próbálkozz másik kártyával, vagy más fizetési móddal!',
	'globalcollect_gateway-response-430330' => 'Érvénytelen kártyaszám.',
	'globalcollect_gateway-response-430421' => 'A hitelkártyádat nem lehet ellenőrizni. Nézd meg, hogy a megadott adatok egyeznek-e a kártyán lévő adatokkal vagy próbálkozz másik kártyával!',
	'globalcollect_gateway-response-430360' => 'A tranzakciót nem lehet érvényesíteni. Próbálkozz másik kártyával, vagy másik fizetési móddal!',
	'globalcollect_gateway-response-430285' => 'A tranzakciót nem lehet érvényesíteni. Próbálkozz másik kártyával, vagy másik fizetési móddal!',
	'globalcollect_gateway-response-21000150' => 'Érvénytelen bankszámlaszám.',
	'globalcollect_gateway-response-21000155' => 'Érvénytelen bank kód.',
	'globalcollect_gateway-response-21000160' => 'Érvénytelen giro számlaszám.',
	'globalcollect_gateway-response-default' => 'Hiba történt a tranzakció feldolgozása során.
Próbáld meg később újra!',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'globalcollectgateway' => 'Face un donation ora',
	'globalcollect_gateway-desc' => 'Processamento de pagamentos GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Pais invalide.',
	'globalcollect_gateway-response-9140' => 'Moneta invalide.',
	'globalcollect_gateway-response-9150' => 'Lingua invalide.',
	'globalcollect_gateway-response-400530' => 'Methodo de pagamento invalide.',
	'globalcollect_gateway-response-430306' => 'Vostre carta de credito ha expirate. Per favor essaya un altere carta o un de nostre altere methodos de pagamento.',
	'globalcollect_gateway-response-430330' => 'Numero de carta invalide.',
	'globalcollect_gateway-response-430421' => 'Vostre carta de credito non poteva esser validate. Per favor verifica que tote le informationes corresponde al profilo de vostre carta, o usa un altere carta.',
	'globalcollect_gateway-response-430360' => 'Le transaction non poteva esser autorisate. Per favor usa un altere carta o un de nostre altere methodos de pagamento.',
	'globalcollect_gateway-response-430285' => 'Le transaction non poteva esser autorisate. Per favor usa un altere carta o un de nostre altere methodos de pagamento.',
	'globalcollect_gateway-response-21000150' => 'Numero de conto bancari invalide.',
	'globalcollect_gateway-response-21000155' => 'Codice bancari invalide.',
	'globalcollect_gateway-response-21000160' => 'Numero de conto de giro invalide.',
	'globalcollect_gateway-response-default' => 'Un error occurreva durante le tractamento de tu transaction.
Per favor reproba plus tarde.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Kenrick95
 */
$messages['id'] = array(
	'globalcollectgateway' => 'Menyumbanglah sekarang',
	'globalcollect_gateway-desc' => 'Pemrosesan pembayaran GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Negara tidak valid.',
	'globalcollect_gateway-response-9140' => 'Mata uang tidak valid.',
	'globalcollect_gateway-response-9150' => 'Bahasa tidak valid.',
	'globalcollect_gateway-response-400530' => 'Metode pembayaran tidak valid.',
	'globalcollect_gateway-response-430306' => 'Kartu kredit Anda telah kadaluarsa. Silakan coba dengan kartu kredit yang lain atau metode pembayaran lainnya.',
	'globalcollect_gateway-response-430330' => 'Nomor kartu tidak valid.',
	'globalcollect_gateway-response-430421' => 'Kartu kredit Anda tidak dapat divalidasi. Mohon verifikasi bahwa semua informasi cocok dengan profil kartu kredit Anda, atau coba dengan kartu yang lain.',
	'globalcollect_gateway-response-430360' => 'Transaksi tidak dapat diotorisasi. Silakan coba dengan kartu yang lain atau metode pembayaran lainnya.',
	'globalcollect_gateway-response-430285' => 'Transaksi tidak dapat diotorisasi. Silakan coba dengan kartu yang lain atau metode pembayaran lainnya.',
	'globalcollect_gateway-response-21000150' => 'Nomor rekening bank tidak valid.',
	'globalcollect_gateway-response-21000155' => 'Kode bank tidak valid.',
	'globalcollect_gateway-response-21000160' => 'Nomor rekening giro tidak valid.',
	'globalcollect_gateway-response-default' => 'Terjadi kesalahan dalam pemrosesan transaksi Anda.
Silakan coba lagi nanti.',
);

/** Japanese (日本語)
 * @author Whym
 */
$messages['ja'] = array(
	'globalcollectgateway' => '今すぐ寄付を',
	'globalcollect_gateway-desc' => 'グローバルコレクト決済処理',
	'globalcollect_gateway-response-9130' => '国名が無効です。',
	'globalcollect_gateway-response-9140' => '通貨が無効です。',
	'globalcollect_gateway-response-9150' => '言語名が無効です。',
	'globalcollect_gateway-response-400530' => '支払い方法が無効です。',
	'globalcollect_gateway-response-430306' => 'あなたのクレジットカードは有効期限が切れています。他のカードか他の支払い方法をお試しください。',
	'globalcollect_gateway-response-430330' => 'カード番号が無効です。',
	'globalcollect_gateway-response-430421' => 'あなたのクレジットカードの妥当性が確かめられませんでした。すべての情報がクレジットカードの個人情報と一致しているかどうかお確かめください。もしくは他のカードをお試しください。',
	'globalcollect_gateway-response-430360' => '取引は許可されませんでした。他のカードか他の支払い方法をお試しください。',
	'globalcollect_gateway-response-430285' => '取引は許可されませんでした。他のカードか他の支払い方法をお試しください。',
	'globalcollect_gateway-response-21000150' => '銀行口座番号が無効です。',
	'globalcollect_gateway-response-21000155' => '銀行コードが無効です。',
	'globalcollect_gateway-response-21000160' => '振替口座番号が無効です。',
	'globalcollect_gateway-response-default' => '取引の処理中にエラーが起こりました。後でもう一度お試しください。',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'globalcollectgateway' => '지금 기부해주세요',
	'globalcollect_gateway-response-21000150' => '잘못된 은행 계좌 번호.',
	'globalcollect_gateway-response-21000155' => '은행 코드가 잘못되었습니다.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'globalcollectgateway' => 'Maacht Ären Don elo',
	'globalcollect_gateway-desc' => 'Ofwécklung vum Bezuelen duerch GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Net valabelt Land.',
	'globalcollect_gateway-response-9140' => 'Net valabel Währung.',
	'globalcollect_gateway-response-9150' => 'Net valabel Sprooch.',
	'globalcollect_gateway-response-400530' => 'Bezuelmethod net valabel.',
	'globalcollect_gateway-response-430306' => 'Är Kreditkaart ass ofgelaf. Probéiert w.e.g. en aner Kaart oder eng vun eisen anere Méiglechkeete fir ze bezuelen.',
	'globalcollect_gateway-response-430330' => "D'Kaartennummer ass net valabel.",
	'globalcollect_gateway-response-430421' => 'Är Kreditkaart konnt net validéiert ginn. Kuckt w.e.g. no ob all Informatiounen mat deene vun Ärer Kreditkaart iwwertenee stëmmen, oder probéiert eng aner Kaart.',
	'globalcollect_gateway-response-430360' => "D'Transaktioun konnt net autoriséiert ginn. Versicht et w.e.g. mat enger anerer Kaart oder enger anerer Method fir ze bezuelen.",
	'globalcollect_gateway-response-430285' => "D'Transaktioun konnt net autoriséiert ginn. Versicht et w.e.g. mat enger anerer Kaart oder enger anerer Method fir ze bezuelen.",
	'globalcollect_gateway-response-21000150' => "D'Kontonummer ass net valabel.",
	'globalcollect_gateway-response-21000155' => "De Code fir d'Bank ass net valabel.",
	'globalcollect_gateway-response-21000160' => "D'Giro-Kontonummer ass net valabel.",
	'globalcollect_gateway-response-default' => 'Et gouf e Feeler beim Verschaffe vun Ärer Transaktioun.
Probéiert et w.e.g. spéider nach eng Kéier.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'globalcollectgateway' => 'Дарувајте сега',
	'globalcollect_gateway-desc' => 'Платежна обработка GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Неважечка земја.',
	'globalcollect_gateway-response-9140' => 'Неважечка валута.',
	'globalcollect_gateway-response-9150' => 'Неважечки јазик.',
	'globalcollect_gateway-response-400530' => 'Неважечки начин на плаќање',
	'globalcollect_gateway-response-430306' => 'Картичката ви е истечена. Обидете се со друга картичка или поинаков начин на плаќање.',
	'globalcollect_gateway-response-430330' => 'Неважечки број на картичка.',
	'globalcollect_gateway-response-430421' => 'Не можв да ја потврдам картичката. Проверете дали сите наведени информации се совпаѓаат со оние во профилот на картичката, или пак обидете се со друга картичка.',
	'globalcollect_gateway-response-430360' => 'Не можев да ја овластам трансакцијата. Обидете се со друга картичка или поинаков начин на плаќање.',
	'globalcollect_gateway-response-430285' => 'Не можев да ја овластам трансакцијата. Обидете се со друга картичка или поинаков начин на плаќање.',
	'globalcollect_gateway-response-21000150' => 'Неважечка сметка.',
	'globalcollect_gateway-response-21000155' => 'Неважечки банковски код.',
	'globalcollect_gateway-response-21000160' => 'Неважечка жиро сметка.',
	'globalcollect_gateway-response-default' => 'Настана грешка при обработката на плаќањето.
Обидете се повторно.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Vssun
 */
$messages['ml'] = array(
	'globalcollectgateway' => 'ഉടൻ സംഭാവന ചെയ്യുക',
	'globalcollect_gateway-desc' => 'ഗ്ലോബൽ കളക്റ്റ് പണമിടപാട്',
	'globalcollect_gateway-response-9130' => 'രാജ്യം അസാധുവാണ്.',
	'globalcollect_gateway-response-9140' => 'നാണയം അസാധുവാണ്.',
	'globalcollect_gateway-response-9150' => 'ഭാഷ അസാധുവാണ്.',
	'globalcollect_gateway-response-400530' => 'അസാധുവായ പണമടക്കൽ രീതി',
	'globalcollect_gateway-response-430306' => 'നിങ്ങളുടെ ക്രെഡിറ്റ്കാർഡിന്റെ കാലാവധി തീർന്നിരിക്കുന്നു. ദയവായി മറ്റൊരു കാർഡോ മറ്റേതെങ്കിലും പണമടക്കൽ രീതിയോ ഉപയോഗിക്കുക.',
	'globalcollect_gateway-response-430330' => 'അസാധുവായ കാർഡ് നമ്പർ',
	'globalcollect_gateway-response-430421' => 'നിങ്ങളുടെ ക്രെഡിറ്റ്കാർഡ് സാധൂകരിക്കാനാകുന്നില്ല. ദയവായി വിവരങ്ങളെല്ലാം നിങ്ങളുടെ ക്രെഡിറ്റ്കാർഡ് വിവരങ്ങളുമായി ഒത്തുനോക്കുക, അല്ലെങ്കിൽ മറ്റൊരു കാർഡുപയോഗിക്കുക.',
	'globalcollect_gateway-response-430360' => 'ഈ ഇടപാട് സാധൂകരിക്കാനാകുന്നില്ല. ദയവായി മറ്റൊരു കാർഡുപയോഗിക്കുകയോ മറ്റേതെങ്കിലും പണമടക്കൽ രീതി അവലംബിക്കുകയോ ചെയ്യുക.',
	'globalcollect_gateway-response-430285' => 'ഈ ഇടപാട് സാധൂകരിക്കാനാകുന്നില്ല. ദയവായി മറ്റൊരു കാർഡുപയോഗിക്കുകയോ മറ്റേതെങ്കിലും പണമടക്കൽ രീതി അവലംബിക്കുകയോ ചെയ്യുക.',
	'globalcollect_gateway-response-21000150' => 'അസാധുവായ ബാങ്ക് അക്കൗണ്ട് നമ്പർ.',
	'globalcollect_gateway-response-21000155' => 'അസാധുവായ ബാങ്ക് കോഡ്.',
	'globalcollect_gateway-response-21000160' => 'അസാധുവായ ഗിറോ അക്കൗണ്ട് നമ്പർ.',
	'globalcollect_gateway-response-default' => 'താങ്കളുടെ ഇടപാട് കൈകാര്യം ചെയ്തുകൊണ്ടിരിക്കെ ഒരു പിഴവുണ്ടായിരിക്കുന്നു.
ദയവായി അൽപ്പസമയത്തിനു ശേഷം ശ്രമിക്കുക.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Diagramma Della Verita
 */
$messages['ms'] = array(
	'globalcollectgateway' => 'Derma sekarang',
	'globalcollect_gateway-desc' => 'Pemprosesan pembayaran GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Negara tidak sah.',
	'globalcollect_gateway-response-9140' => 'Mata wang tidak sah.',
	'globalcollect_gateway-response-9150' => 'Bahasa tidak sah.',
	'globalcollect_gateway-response-400530' => 'Jenis pembayaran yang dipilih tidak sah.',
	'globalcollect_gateway-response-430306' => 'Kad kredit anda telah luput. Sila cuba dengan kad yang lain atau pilih satu daripada empat cara pembayaran yang lain.',
	'globalcollect_gateway-response-430330' => 'Kad kredit tidak sah.',
	'globalcollect_gateway-response-430421' => 'Kad kredit anda tidak dapat disahkan. Sila pastikan kesemua maklumat yang diisi sama dengan profil kad kredit anda atau sila cuba semula dengan kad yang lain.',
	'globalcollect_gateway-response-430360' => 'Transaksi tidak dapat disahkan. Sila cuba dengan kad yang lain atau pilih satu daripada empat cara pembayaran yang lain.',
	'globalcollect_gateway-response-430285' => 'Transaksi tidak dapat disahkan. Sila cuba dengan kad yang lain atau pilih satu daripada empat cara pembayaran yang lain.',
	'globalcollect_gateway-response-21000150' => 'Nombor akaun bank tidah sah.',
	'globalcollect_gateway-response-21000155' => 'Kod bank tidak sah.',
	'globalcollect_gateway-response-21000160' => 'Nombor akaun giro tidak sah.',
	'globalcollect_gateway-response-default' => 'Terdapat masalah dalam memproses transaksi anda. 
Sila cuba sebentar lagi.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jsoby
 */
$messages['nb'] = array(
	'globalcollectgateway' => 'Doner nå',
	'globalcollect_gateway-desc' => 'Betalingsprosessering med GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Ugyldig land.',
	'globalcollect_gateway-response-9140' => 'Ugyldig valuta.',
	'globalcollect_gateway-response-9150' => 'Ugyldig språk.',
	'globalcollect_gateway-response-400530' => 'Ugylding betalingsmetode.',
	'globalcollect_gateway-response-430306' => 'Kredittkortet ditt er utgått. Prøv et annet kort eller en av de andre betalingsmetodene våre.',
	'globalcollect_gateway-response-430330' => 'Ugyldig kortnummer.',
	'globalcollect_gateway-response-430421' => 'Kredittkortet ditt kunne ikke valideres. Sjekk at informasjonen du har oppgitt stemmer overens med det som står på kortet, eller prøv et annet kort.',
	'globalcollect_gateway-response-430360' => 'Overføringen kunne ikke autoriseres. Prøv et annet kort eller en av de andre betalingsmåtene våre.',
	'globalcollect_gateway-response-430285' => 'Overføringen kunne ikke autoriseres. Prøv et annet kort eller en av de andre betalingsmetodene våre.',
	'globalcollect_gateway-response-21000150' => 'Ugyldig kontonummer.',
	'globalcollect_gateway-response-21000155' => 'Ugyldig bankkode.',
	'globalcollect_gateway-response-21000160' => 'Ugyldig girokontonummer.',
	'globalcollect_gateway-response-default' => 'Det oppsto en feil under behandlingen av overføringen din.
Prøv igjen senere.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'globalcollectgateway' => 'Doneer nu',
	'globalcollect_gateway-desc' => 'Betalingsverwerking via GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Ongeldig land.',
	'globalcollect_gateway-response-9140' => 'Ongeldige valuta.',
	'globalcollect_gateway-response-9150' => 'Ongeldige taal.',
	'globalcollect_gateway-response-400530' => 'Ongeldige betalingsmethode.',
	'globalcollect_gateway-response-430306' => 'Uw creditcard is verlopen. Probeer een andere kaart of een van onze andere betalingsmethoden.',
	'globalcollect_gateway-response-430330' => 'Ongeldig kaartnummer.',
	'globalcollect_gateway-response-430421' => 'Uw creditcard kan niet worden gevalideerd. Controleer alstublieft of alle informatie overeenkomt met uw creditcardgegevens, of gebruik een andere kaart.',
	'globalcollect_gateway-response-430360' => 'De transactie kan niet worden geautoriseerd. Gebruik een andere kaart of een van onze andere betalingsmethoden.',
	'globalcollect_gateway-response-430285' => 'De transactie kan niet worden geautoriseerd. Gebruik een andere kaart of een van onze andere betalingsmethoden.',
	'globalcollect_gateway-response-21000150' => 'Ongeldig rekeningnummer.',
	'globalcollect_gateway-response-21000155' => 'Ongeldige bankcode.',
	'globalcollect_gateway-response-21000160' => 'Ongeldig girorekeningnummer.',
	'globalcollect_gateway-response-default' => 'Er is een fout opgetreden bij het verwerken van uw transactie.
Probeer het later alstublieft nog een keer.',
);

/** Polish (Polski)
 * @author Mikołka
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'globalcollectgateway' => 'Przekaż darowiznę',
	'globalcollect_gateway-desc' => 'Przetwarzanie płatności GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Nieprawidłowy kraj.',
	'globalcollect_gateway-response-9140' => 'Nieprawidłowa waluta.',
	'globalcollect_gateway-response-9150' => 'Nieprawidłowy język.',
	'globalcollect_gateway-response-400530' => 'Nieprawidłowa metoda płatności.',
	'globalcollect_gateway-response-430306' => 'Twoja karta kredytowa jest przeterminowana. Spróbuj użyć innej karty lub zmień sposób dokonania wpłaty.',
	'globalcollect_gateway-response-430330' => 'Nieprawidłowy numer karty.',
	'globalcollect_gateway-response-430421' => 'Wystąpił problem z weryfikacją Twojej karty kredytowej. Sprawdź wprowadzone dane lub spróbuj użyć innej karty.',
	'globalcollect_gateway-response-430360' => 'Wpłata nie może zostać zrealizowana. Spróbuj użyć innej karty lub zmień sposób dokonania wpłaty.',
	'globalcollect_gateway-response-430285' => 'Wpłata nie może zostać zrealizowana. Spróbuj użyć innej karty lub zmień sposób dokonania wpłaty.',
	'globalcollect_gateway-response-21000150' => 'Nieprawidłowy numer konta bankowego.',
	'globalcollect_gateway-response-21000155' => 'Nieprawidłowy kod banku.',
	'globalcollect_gateway-response-21000160' => 'Nieprawidłowy numer konta.',
	'globalcollect_gateway-response-default' => 'Wystąpił błąd podczas przeprowadzania transakcji.
Spróbuj ponownie później.',
);

/** Portuguese (Português)
 * @author João Sousa
 */
$messages['pt'] = array(
	'globalcollectgateway' => 'Faça o seu donativo agora',
	'globalcollect_gateway-desc' => 'Processamento de pagamentos GlobalCollect',
	'globalcollect_gateway-response-9130' => 'País inválido',
	'globalcollect_gateway-response-9140' => 'Moeda inválida',
	'globalcollect_gateway-response-9150' => 'Língua inválida',
	'globalcollect_gateway-response-400530' => 'Método de pagamento inválido',
	'globalcollect_gateway-response-430306' => 'O seu cartão de crédito caducou. Por favor use um cartão diferente ou um outro método de pagamento.',
	'globalcollect_gateway-response-430330' => 'Número de cartão é inválido.',
	'globalcollect_gateway-response-430421' => 'Não foi possível validar o seu cartão de crédito. Por favor verifique se toda a informação corresponde ao seu perfil de cartão de crédito, ou tente usar outro cartão.',
	'globalcollect_gateway-response-430360' => 'Não foi possível autorizar a transação. Por favor tente com outro cartão ou outro método de pagamento.',
	'globalcollect_gateway-response-430285' => 'Não foi possível autorizar a transação. Por favor tente com outro cartão ou outro método de pagamento.',
	'globalcollect_gateway-response-21000150' => 'Número de conta bancário inválido.',
	'globalcollect_gateway-response-21000155' => 'Código bancário inválido.',
	'globalcollect_gateway-response-21000160' => 'Número de conta de transferência inválido.',
	'globalcollect_gateway-response-default' => 'Ocorreu um erro no processamento desta transacção.
Por favor, tente novamente mais tarde.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Ppena
 */
$messages['pt-br'] = array(
	'globalcollectgateway' => 'Faça a sua doação agora',
	'globalcollect_gateway-desc' => 'Processamento de pagamentos GlobalCollect',
	'globalcollect_gateway-response-9130' => 'País inválido',
	'globalcollect_gateway-response-9140' => 'Moeda inválida',
	'globalcollect_gateway-response-9150' => 'Língua inválida',
	'globalcollect_gateway-response-400530' => 'Método de pagamento inválido',
	'globalcollect_gateway-response-430306' => 'O seu cartão de crédito esta vencido. Por favor use um cartão diferente ou um outro método de pagamento.',
	'globalcollect_gateway-response-430330' => 'Número de cartão é inválido.',
	'globalcollect_gateway-response-430421' => 'Não foi possível validar o seu cartão de crédito. Por favor verifique se toda a informação corresponde ao seu perfil de cartão de crédito, ou tente usar outro cartão.',
	'globalcollect_gateway-response-430360' => 'Não foi possível autorizar a transação. Por favor tente com outro cartão ou outro método de pagamento.',
	'globalcollect_gateway-response-430285' => 'Não foi possível autorizar a transação. Por favor tente com outro cartão ou outro método de pagamento.',
	'globalcollect_gateway-response-21000150' => 'Número de conta bancária inválido.',
	'globalcollect_gateway-response-21000155' => 'Código bancário inválido.',
	'globalcollect_gateway-response-21000160' => 'Número de conta bancária inválido.',
	'globalcollect_gateway-response-default' => 'Ocorreu um erro no processamento desta transação.
Por favor tente novamente mais tarde.',
);

/** Romanian (Română)
 * @author Minisarm
 */
$messages['ro'] = array(
	'globalcollectgateway' => 'Faceți o donație acum',
	'globalcollect_gateway-desc' => 'Procesarea plății prin GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Țară incorectă.',
	'globalcollect_gateway-response-9140' => 'Monedă incorectă.',
	'globalcollect_gateway-response-9150' => 'Limbă incorectă.',
	'globalcollect_gateway-response-400530' => 'Metodă de plată incorectă.',
	'globalcollect_gateway-response-430306' => 'Cardul dumneavoastră de credit a expirat. Vă rugăm să încercați cu un alt card sau să alegeți o altă metodă de plată pusă la dispoziție de noi.',
	'globalcollect_gateway-response-430330' => 'Număr de card incorect.',
	'globalcollect_gateway-response-430421' => 'Cardul dumneavoastră de credit nu a putut fi validat. Vă rugăm fie să verificați dacă toate informațiile corespund cardului dumneavoastră de credit, fie să încercați cu un alt card.',
	'globalcollect_gateway-response-430360' => 'Tranzacția nu a putut fi autorizată. Vă rugăm să încercați cu un alt card sau să alegeți o altă metodă de plată pusă la dispoziție de noi.',
	'globalcollect_gateway-response-430285' => 'Tranzacția nu a putut fi autorizată. Vă rugăm să încercați cu un alt card sau să alegeți o altă metodă de plată pusă la dispoziție de noi.',
	'globalcollect_gateway-response-21000150' => 'Număr de cont incorect.',
	'globalcollect_gateway-response-21000155' => 'Cod de bancă incorect.',
	'globalcollect_gateway-response-21000160' => 'Număr de cont giro incorect.',
	'globalcollect_gateway-response-default' => 'S-a produs o eroare în timpul procesării tranzacției dumneavoastră.
Vă rugăm să reîncercați mai târziu.',
);

/** Russian (Русский)
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'globalcollectgateway' => 'Сделайте пожертвование сейчас',
	'globalcollect_gateway-desc' => 'Шлюз обработки платежей GlobalCollect',
	'globalcollect_gateway-response-9130' => 'Указана неподдерживаемая страна.',
	'globalcollect_gateway-response-9140' => 'Указана неподдерживаемая валюта.',
	'globalcollect_gateway-response-9150' => 'Указан неподдерживаемый язык.',
	'globalcollect_gateway-response-400530' => 'Некорректный способ платежа.',
	'globalcollect_gateway-response-430306' => 'Истёк срок действия вашей кредитной карты. Пожалуйста, попробуйте использовать другую карту или выберите другой способ платежа.',
	'globalcollect_gateway-response-430330' => 'Некорректный номер карты.',
	'globalcollect_gateway-response-430421' => 'Ваша кредитная карта не прошла проверку. Пожалуйста, проверьте, что вся введённая вами информация соответствует данным вашей карты, или попробуйте использовать другую карту.',
	'globalcollect_gateway-response-430360' => 'Транзакция не может быть авторизована. Пожалуйста, попробуйте использовать другую карту или выберите другой способ платежа.',
	'globalcollect_gateway-response-430285' => 'Транзакция не может быть авторизована. Пожалуйста, попробуйте использовать другую карту или выберите другой способ платежа.',
	'globalcollect_gateway-response-21000150' => 'Неправильный номер банковского счёта.',
	'globalcollect_gateway-response-21000155' => 'Неправильный код банка.',
	'globalcollect_gateway-response-21000160' => 'Неправильный номер счёта giro.',
	'globalcollect_gateway-response-default' => 'При обработке вашей транзакции возникла ошибка.
Пожалуйста, повторите попытку позже.',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'globalcollectgateway' => 'ඔබගේ පරිත්‍යාගය දැන් සපයන්න',
);

/** Slovenian (Slovenščina)
 * @author Artelind
 * @author Dbc334
 */
$messages['sl'] = array(
	'globalcollectgateway' => 'Oddajte svoj prispevek zdaj',
	'globalcollect_gateway-desc' => 'Plačilo GlobalCollect je v obdelavi',
	'globalcollect_gateway-response-9130' => 'Neveljavna država.',
	'globalcollect_gateway-response-9140' => 'Neveljavna valuta.',
	'globalcollect_gateway-response-9150' => 'Neveljaven jezik.',
	'globalcollect_gateway-response-400530' => 'Neveljaven način plačila.',
	'globalcollect_gateway-response-430306' => 'Vaša kreditna kartica je potekla. Prosimo, poskusite z drugo kartico ali pa uporabite katerega od naših drugih načinov plačila.',
	'globalcollect_gateway-response-430330' => 'Številka kartice ni veljavna.',
	'globalcollect_gateway-response-430421' => 'Vaše kreditne kartice ni bilo mogoče potrditi. Prosimo, preverite, da so podatki o vaši kreditni kartici pravilni, ali pa poskusite z drugo kartico.',
	'globalcollect_gateway-response-430360' => 'Pri potrjevanju transakcije je prišlo do napake. Prosimo, poskusite z drugo kartico ali pa uporabite katerega od naših drugih načinov plačila.',
	'globalcollect_gateway-response-430285' => 'Pri potrjevanju transakcije je prišlo do napake. Prosimo, poskusite z drugo kartico ali pa uporabite katerega od naših drugih načinov plačila.',
	'globalcollect_gateway-response-21000150' => 'Številka bančnega računa je napačna.',
	'globalcollect_gateway-response-21000155' => 'Številka banke je napačna.',
	'globalcollect_gateway-response-21000160' => 'Številka žiroračuna je napačna.',
	'globalcollect_gateway-response-default' => 'Pri obdelavi vaše transakcije je prišlo do napake. Prosimo, poskusite pozneje.',
);

/** Swedish (Svenska)
 * @author Warrakkk
 */
$messages['sv'] = array(
	'globalcollectgateway' => 'Ge ditt bidrag nu',
	'globalcollect_gateway-desc' => 'GlobalCollect betalningshantering',
	'globalcollect_gateway-response-9130' => 'Ogiltig land.',
	'globalcollect_gateway-response-9140' => 'Ogiltig valuta.',
	'globalcollect_gateway-response-9150' => 'Ogiltigt språk.',
	'globalcollect_gateway-response-400530' => 'Ogiltig betalningsmetod.',
	'globalcollect_gateway-response-430306' => 'Ditt kreditkort har slutat gälla. Prova ett annat kort eller något av våra andra betalningsalternativ.',
	'globalcollect_gateway-response-430330' => 'Ogiltig kortnummer.',
	'globalcollect_gateway-response-430421' => 'Ditt kreditkort kunde inte verifieras. Kontrollera att alla uppgifter stämmer överens med kreditkortsprofilen eller prova ett annat kort.',
	'globalcollect_gateway-response-430360' => 'Transaktionen kan inte godkännas. Prova ett annat kort eller något av våra andra betalningsalternativ.',
	'globalcollect_gateway-response-430285' => 'Transaktionen kan inte godkännas. Prova ett annat kort eller något av våra andra betalningsalternativ.',
	'globalcollect_gateway-response-21000150' => 'Ogiltig bankkontonummer.',
	'globalcollect_gateway-response-21000155' => 'Ogiltig bankkod.',
	'globalcollect_gateway-response-21000160' => 'Ogiltigt girokontonummer.',
	'globalcollect_gateway-response-default' => 'Ett fel uppstod när din transaktion behandlades.
Försök igen senare.',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'globalcollectgateway' => 'Changia sasa',
	'globalcollect_gateway-response-9130' => 'Jina batili la nchi.',
	'globalcollect_gateway-response-9150' => 'Lugha batili.',
	'globalcollect_gateway-response-430330' => 'Namba batili ya kadi.',
	'globalcollect_gateway-response-21000155' => 'Kodi batili ya benki.',
	'globalcollect_gateway-response-default' => 'Ilitokea hitilafu wakati wa kufanya malipo yako.
Tafadhali jaribu tena baadaye.',
);

/** Vietnamese (Tiếng Việt)
 * @author Trần Nguyễn Minh Huy
 */
$messages['vi'] = array(
	'globalcollectgateway' => 'Quyên góp ngay bây giờ',
	'globalcollect_gateway-response-9130' => 'Quốc gia này không hợp lệ.',
	'globalcollect_gateway-response-9140' => 'Loại tiền tệ không hợp lệ.',
	'globalcollect_gateway-response-9150' => 'Ngôn ngữ không hợp lệ.',
	'globalcollect_gateway-response-400530' => 'Phương thức thanh toán không hợp lệ.',
	'globalcollect_gateway-response-430306' => 'Thẻ tín dụng của bạn đã hết hạn. Hãy thử dùng một thẻ khác hoặc một trong các phương thức thanh toán khác của chúng tôi.',
	'globalcollect_gateway-response-430330' => 'Mã số thẻ không hợp lệ.',
	'globalcollect_gateway-response-430421' => 'Thẻ tín dụng của bạn không được xác nhận. Xin vui lòng kiểm chứng rằng tất cả thông tin phù hợp với hồ sơ thẻ tín dụng của bạn hoặc thử dùng một thẻ khác.',
	'globalcollect_gateway-response-430360' => 'Giao dịch này không cho phép. Hãy thử dùng một thẻ khác hoặc một trong các phương thức thanh toán khác của chúng tôi.',
	'globalcollect_gateway-response-430285' => 'Giao dịch này không cho phép. Hãy thử dùng một thẻ khác hoặc một trong các phương thức thanh toán khác của chúng tôi.',
	'globalcollect_gateway-response-21000150' => 'Số tài khoản ngân hàng không hợp lệ.',
	'globalcollect_gateway-response-21000155' => 'Mã ngân hàng không hợp lệ.',
	'globalcollect_gateway-response-default' => 'Đã xảy ra lỗi khi xử lý giao dịch của bạn.
Xin hãy thử lại sau.',
);

