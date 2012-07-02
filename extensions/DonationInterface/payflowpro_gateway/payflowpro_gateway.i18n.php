<?php
/**
 * Internationalization file for the Donation Interface - PayflowPro - extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English */
$messages['en'] = array(
	'payflowprogateway' => 'Make your donation now',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro credit card processing',
	'payflowpro_gateway-response-0' => 'Your transaction has been approved.
Thank you for your donation!',
	'payflowpro_gateway-response-126' => 'Your transaction is pending approval.',
	'payflowpro_gateway-response-126-2' => 'Some of the information you provided did not match your credit card profile, or you made a very large gift. For your own security, your donation is currently under review, and we will notify you through the provided e-mail address if we cannot finalize your donation. Please e-mail <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> if you have any questions. Thank you!',
	'payflowpro_gateway-response-12' => 'Please contact your credit card company for further information.',
	'payflowpro_gateway-response-13' => 'Your transaction requires voice authorization.
Please contact us to continue your transaction.', // This will not apply to Wikimedia accounts
	'payflowpro_gateway-response-114' => 'Please contact your credit card company for further information.',
	'payflowpro_gateway-response-23' => 'Your credit card number or expiration date is incorrect.',
	'payflowpro_gateway-response-4' => 'Invalid amount.',
	'payflowpro_gateway-response-24' => 'Your credit card number or expiration date is incorrect.',
	'payflowpro_gateway-response-112' => 'Your address or CVV number (security code) is incorrect.',
	'payflowpro_gateway-response-125' => 'Your transaction has been declined by Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Your credit card could not be validated. Please verify that all provided information matches your credit card profile, or try a different card. You can also use one of our <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">other ways to give</a> or contact us at <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Thank you for your support.',
	'payflowpro_gateway-response-default' => 'There was an error processing your transaction.
Please try again later.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Hamilton Abreu
 * @author Jsoby
 * @author Kghbln
 * @author Lloffiwr
 * @author Minh Nguyen
 * @author Purodha
 * @author Siebrand
 * @author Yekrats
 * @author Тест
 */
$messages['qqq'] = array(
	'payflowprogateway' => '{{Identical|Support Wikimedia}}',
	'payflowpro_gateway-desc' => '{{desc}}',
	'payflowpro_gateway-response-0' => 'Message after the donation has gone through.',
	'payflowpro_gateway-response-126' => "Message if the donation is done, but waiting for something beyond the user's control.",
	'payflowpro_gateway-response-126-2' => '',
	'payflowpro_gateway-response-12' => 'Message if there is something wrong with the card.',
	'payflowpro_gateway-response-13' => 'Message if the card requires voice authorization.',
	'payflowpro_gateway-response-114' => 'Message after the donate form is done, asking for the user to contact his/her credit card company.',
	'payflowpro_gateway-response-23' => 'Final message if the credit card number or expiration is wrong.',
	'payflowpro_gateway-response-4' => 'Error message for invalid amount.',
	'payflowpro_gateway-response-24' => 'Error message for card number or expiration date.',
	'payflowpro_gateway-response-112' => 'Error message for address or CVV number.',
	'payflowpro_gateway-response-125' => 'Error message if the transaction is declined automatically.',
	'payflowpro_gateway-response-125-2' => 'Error message if the card could not be validated.',
	'payflowpro_gateway-response-default' => 'Error message if something went wrong on our side.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'payflowprogateway' => 'Skenk nou',
	'payflowpro_gateway-desc' => 'Kredietkaart-verwerking via PayPal se PayFlow Pro',
	'payflowpro_gateway-response-0' => 'U transaksie is goedgekeur.
Baie dankie vir u skenking!',
	'payflowpro_gateway-response-126' => 'U transaksie wag tans vir goedkeuring.',
	'payflowpro_gateway-response-126-2' => 'Van die inligting wat u verskaf het stem nie met u kredietkaart ooreen nie, of u het \'n baie groot donasie probeer maak. Vir u veiligheid word u donasie tans hersien, en ons sal u per die e-posadres wat u verskaf het in kennis stel as ons nie u donasie kan finaliseer nie. Stuur \'n e-pos aan <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> as u nog vrae het. Dankie!',
	'payflowpro_gateway-response-12' => 'Kontak asseblief u kredietkaart-verskaffer vir verdere inligting.',
	'payflowpro_gateway-response-13' => 'U transaksie vereis mondelinge toestemming.
Kontak ons asseblief om voort te gaan met u transaksie.',
	'payflowpro_gateway-response-114' => 'Kontak asseblief u kredietkaart-verskaffer vir verdere inligting.',
	'payflowpro_gateway-response-23' => 'U kredietkaart-nommer of die vervaldatum is verkeerd.',
	'payflowpro_gateway-response-4' => 'Ongeldig bedrag.',
	'payflowpro_gateway-response-24' => 'Die kredietkaart-nommer of vervaldatum is verkeerd.',
	'payflowpro_gateway-response-112' => 'U adres of CVV-nommer (veiligheidskode) is verkeerd.',
	'payflowpro_gateway-response-125' => 'U transaksie is deur Bedrog-voorkomingsdienste afgekeur.',
	'payflowpro_gateway-response-125-2' => 'U kredietkaart kon nie gevalideer word nie. Bevestig asseblief dat alle inligting verskaf ooreenstem met u kredietkaart se profiel, of probeer \'n ander kaart. U kan ook deur <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">ander maniere gee</a> of kontak ons by <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Dankie vir u ondersteuning.',
	'payflowpro_gateway-response-default' => "Daar was 'n fout met die verwerking van u transaksie.
Probeer asseblief later weer.",
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'payflowprogateway' => 'Asistenca Wikimedia',
	'payflowpro_gateway-desc' => 'PayPal kartë krediti të përpunimit Payflow Pro',
);

/** Arabic (العربية)
 * @author AwamerT
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 * @author زكريا
 */
$messages['ar'] = array(
	'payflowprogateway' => 'تبرع الآن',
	'payflowpro_gateway-desc' => 'معالجة PayPal Payflow Pro لبطاقات الائتمان',
	'payflowpro_gateway-response-0' => 'اعتمدت حوالتك.
شكرا لك على التبرع!',
	'payflowpro_gateway-response-126' => 'حوالتك تنتظر الموافقة.',
	'payflowpro_gateway-response-126-2' => 'بعض من المعلومات التي وفرتها لم تطابق ملف بطاقتك الائتمانية، أو أنت قمت بتبرع كبير جدا. لتأمينك، تبرعك حاليا تحت المراجعة، وسنخطرك من خلال عنوان البريد الإلكتروني الموفر لو لم نتمكن من إنهاء تبرعك. من فضلك راسل <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> لو لديك أي أسئلة. شكرا لك!',
	'payflowpro_gateway-response-12' => 'من فضلك اتصل بشركة بطاقة ائتمانك لمزيد من المعلومات.',
	'payflowpro_gateway-response-13' => 'تتطلب حوالتك الاستيثاق بالصوت.
من فضلك اتصل بنا لتكمل الحوالة',
	'payflowpro_gateway-response-114' => 'من فضلك اتصل بشركة بطاقة ائتمانك لمزيد من المعلومات.',
	'payflowpro_gateway-response-23' => 'رقم بطاقة ائتمانك أو تاريخ انتهائها غير صحيح.',
	'payflowpro_gateway-response-4' => 'قيمة غير صالحة.',
	'payflowpro_gateway-response-24' => 'رقم بطاقة ائتمانك أو تاريخ انتهائها غير صالح.',
	'payflowpro_gateway-response-112' => 'عنوانك أو رقم CVV (كود الأمان) غير صحيح.',
	'payflowpro_gateway-response-125' => 'ألغت Fraud Prevention Services تحويلك.',
	'payflowpro_gateway-response-125-2' => 'بطاقتك الائتمانية لم يمكن التحقق منها. من فضلك تأكد من أن كل المعلومات الموفرة تطابق ملف بطاقتك الائتمانية، أو جرب بطاقة أخرى. يمكنك أيضا استخدام إحدى <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">وسائلنا الاخرى للعطاء</a> أو اتصل بنا في <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. شكرا لدعمك.',
	'payflowpro_gateway-response-default' => 'ثمة خطأ أثناء تنفيذ التحويل.
من فضلك حاول مرة أخرى.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'payflowprogateway' => 'ادعم ويكيميديا',
	'payflowpro_gateway-desc' => 'معالجه PayPal Payflow Pro لبطاقات الائتمان',
	'payflowpro_gateway-response-0' => 'تمت الموافقه على تحويلك.
شكرا لك على التبرع!',
	'payflowpro_gateway-response-126' => 'تحويلك ينتظر الموافقه.',
	'payflowpro_gateway-response-126-2' => 'بعض من المعلومات التى وفرتها لم تطابق ملف بطاقتك الائتمانيه، أو أنت قمت بتبرع كبير جدا. لتأمينك، تبرعك حاليا تحت المراجعه، وسنخطرك من خلال عنوان البريد الإلكترونى الموفر لو لم نتمكن من إنهاء تبرعك. من فضلك راسل <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> لو لديك أى أسئله. شكرا لك!',
	'payflowpro_gateway-response-12' => 'من فضلك اتصل بشركه بطاقه ائتمانك لمزيد من المعلومات.',
	'payflowpro_gateway-response-13' => 'يتطلب تحويلك الاستيثاق بالصوت.
من فضلك اتصل بنا لتكمل تحويلك.',
	'payflowpro_gateway-response-114' => 'من فضلك اتصل بشركه بطاقه ائتمانك لمزيد من المعلومات.',
	'payflowpro_gateway-response-23' => 'رقم بطاقه ائتمانك أو تاريخ انتهائها غير صحيح.',
	'payflowpro_gateway-response-4' => 'قيمه غير صالحه.',
	'payflowpro_gateway-response-24' => 'رقم بطاقه ائتمانك أو تاريخ انتهائها غير صالح.',
	'payflowpro_gateway-response-112' => 'عنوانك أو رقم CVV (كود الأمان) غير صحيح.',
	'payflowpro_gateway-response-125' => 'ألغت Fraud Prevention Services تحويلك.',
	'payflowpro_gateway-response-125-2' => 'بطاقتك الائتمانيه لم يمكن التحقق منها. من فضلك تأكد من أن كل المعلومات الموفره تطابق ملف بطاقتك الائتمانيه، أو جرب بطاقه أخرى. يمكنك أيضا استخدام إحدى <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">وسائلنا الاخرى للعطاء</a> أو اتصل بنا فى <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. شكرا لدعمك.',
	'payflowpro_gateway-response-default' => 'ثمه خطأ أثناء تنفيذ التحويل.
من فضلك حاول مره أخرى.',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'payflowprogateway' => 'Хәҙер иғәнә итегеҙ',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro кредит картаһын эшкәртеү',
	'payflowpro_gateway-response-0' => 'Һеҙҙең ғәмәлегеҙ раҫланды.
Иғәнәгеҙ өсөн рәхмәт!',
	'payflowpro_gateway-response-126' => 'Һеҙҙең ғәмәлегеҙ раҫланыуын көтә.',
	'payflowpro_gateway-response-126-2' => 'Һеҙ кереткән мәғлүмәттең ҡайһы бере һеҙҙең кредит картағыҙҙа күрһәтелгәндән айырыла, йәки һеҙ бигерәк ҙур иғәнә яһағанһығыҙ. Һеҙҙең хәүефһеҙлегеҙ маҡсаттарында, иғәнәгеҙ әлеге ваҡытта ҡарала, әгәр иғәнәгеҙҙе эшкәртә алмаһаҡ, беҙ һеҙгә күрһәтелгән электрон почта адресы аша белдерербеҙ. Зинһар, әгәр һорауҙарығыҙ булһа,<a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>  адресына яҙығыҙ. Рәхмәт!',
	'payflowpro_gateway-response-12' => 'Зинһар, өҫтәмә мәғлүмәт алыр өсөн, кредит картаһын биргән ойошмаға мөрәжәғәт итегеҙ.',
	'payflowpro_gateway-response-13' => 'Һеҙҙең ғәмәлегеҙ тауыш аша танылыуҙы талап итә.
Зинһар, ғәмәлде дауам итер өсөн, беҙҙең менән бәйләнешкә керегеҙ.',
	'payflowpro_gateway-response-114' => 'Зинһар, өҫтәмә мәғлүмәт алыр өсөн, кредит картаһын биргән ойошмаға мөрәжәғәт итегеҙ.',
	'payflowpro_gateway-response-23' => 'Һеҙҙең кредит карта номеры йәки уның ҡулланыу ваҡыты дөрөҫ түгел.',
	'payflowpro_gateway-response-4' => 'Күләм дөрөҫ түгел.',
	'payflowpro_gateway-response-24' => 'Һеҙҙең кредит карта номеры йәки уның ҡулланыу ваҡыты дөрөҫ түгел.',
	'payflowpro_gateway-response-112' => 'Һеҙҙең адресығыҙ йәки CVV коды (именлек коды) дөрөҫ түгел.',
	'payflowpro_gateway-response-125' => 'Һеҙҙең ғәмәлегеҙ Мутлыҡҡа ҡаршы көрәш хеҙмәте тарафынан кире ҡағылды.',
	'payflowpro_gateway-response-125-2' => 'Һеҙҙең кредит картағыҙ раҫлана алмай. Зинһар, бөтә күрһәтелгән мәғлүмәттең кредит картаһындағы мәғлүмәт менән тап килеүен тикшерегеҙ, йәки икенсе кредит картаһын ҡулланып ҡарағыҙ. Һеҙ шулай уҡ <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">башҡа иғәнә яһау ысулдарының</a> береһен ҡуллана йәки беҙҙең менән <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> адресы аша бәйләнешкә керә алаһығыҙ. Ярҙамығыҙ өсөн рәхмәт.',
	'payflowpro_gateway-response-default' => 'Ғәмәлде эшкәртеү ваҡытында хата килеп сыҡты.
Зинһар, һуңыраҡ тағы ҡабатлап ҡарағыҙ.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Lloffiwr
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'payflowprogateway' => 'Зрабіце ахвяраваньне зараз',
	'payflowpro_gateway-desc' => 'Апрацоўка крэдытных картак PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Ваша транзакцыя была зацьверджаная.
Дзякуй за Вашае ахвяраваньне!',
	'payflowpro_gateway-response-126' => 'Ваша транзакцыя чакае пацьверджаньня.',
	'payflowpro_gateway-response-126-2' => 'Некаторая інфармацыя, якую Вы падалі, не супадае з профілем Вашай крэдытнай карткі, альбо Вы зрабілі занадта вялікае ахвяраваньне. Для Вашай бясьпекі, Вашае ахвяраваньне ў цяперашні момант разглядаецца і мы паведамім Вам па электроннай пошце, калі мы ня зможам яго апрацаваць. Калі ласка лістуйце на адрас <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>, калі Вы маеце пытаньні. Дзякуй!',
	'payflowpro_gateway-response-12' => 'Калі ласка, зьвяжыцеся з Вашай крэдытнай кампаніяй для дадатковай інфармацыі.',
	'payflowpro_gateway-response-13' => 'Вашая транзакцыя патрабуе галасавой аўтарызацыі.
Калі ласка, скантактуйцеся з намі каб працягнуць транзакцыю.',
	'payflowpro_gateway-response-114' => 'Калі ласка, скантактуйцеся з Вашай крэдытнай кампаніяй для дадатковай інфармацыі.',
	'payflowpro_gateway-response-23' => 'Нумар Вашай крэдытнай карткі альбо тэрмін сканчэньня яе дзеяньня зьяўляецца няслушным.',
	'payflowpro_gateway-response-4' => 'Няслушная сума.',
	'payflowpro_gateway-response-24' => 'Нумар Вашай крэдытнай карткі альбо тэрмін сканчэньня яе дзеяньня зьяўляецца няслушным.',
	'payflowpro_gateway-response-112' => 'Ваш адрас альбо нумар код бясьпекі зьяўляецца няслушным.',
	'payflowpro_gateway-response-125' => 'Ваша транзакцыя была адмененая Службай прадухіленьня махлярстваў.',
	'payflowpro_gateway-response-125-2' => 'Вашая крэдытная картка ня можа быць пацьверджана. Калі ласка, упэўніцеся што ўся пададзеная інфармацыя супадае з профілем Вашай крэдытнай карткі, альбо паспрабуйце іншую крэдытную картку. Вы можаце паспрабаваць адзін з <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">іншых спосабаў ахвяраваньня</a>, альбо зьвязацца з намі праз <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Дзякуй за Вашую падтрымку.',
	'payflowpro_gateway-response-default' => 'Пад час апрацоўкі Вашай транзакцыі ўзьнікла памылка.
Калі ласка, паспрабуйце ізноў пазьней.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'payflowprogateway' => 'Направете дарение сега',
	'payflowpro_gateway-desc' => 'Обработка на кредитни карти с PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Преводът ви е одобрен.
Благодарим за дарението!',
	'payflowpro_gateway-response-126' => 'Преводът ви очаква одобрение.',
	'payflowpro_gateway-response-126-2' => 'Изглежда, че някои от данните, които сте предоставили, не отговарят на профила на кредитната ви карта, или се опитвате да направите твърде голямо дарение. От съображения за вашата собствена сигурност, в момента проучваме дарението ви и ще ви уведомим на посочения от вас имейл адрес в случай, че не може да бъде извършено. Моля, свържете се с нас на адрес <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>, ако имате някакви въпроси. Благодарим ви!',
	'payflowpro_gateway-response-12' => 'Свържете се с издателя на кредитната ви карта за повече подробности.',
	'payflowpro_gateway-response-13' => 'Преводът ви изисква гласово потвърждение.
Свържете се с нас за продължаване на превода.',
	'payflowpro_gateway-response-114' => 'Свържете се с издателя на кредитната ви карта за повече подробности.',
	'payflowpro_gateway-response-23' => 'Номерът на кредитната ви карта или датата й на изтичане е неправилна.',
	'payflowpro_gateway-response-4' => 'Недопустима сума.',
	'payflowpro_gateway-response-24' => 'Номерът на кредитната ви карта или датата й на изтичане е неправилна.',
	'payflowpro_gateway-response-112' => 'Адресът ви или номерът CCV (кодът за сигурност) е неправилен.',
	'payflowpro_gateway-response-125' => 'Вашата транзакция беше спряна от службите за предотвратяване на измамите.',
	'payflowpro_gateway-response-125-2' => 'Вашата кредитна карта не може да бъде валидирана. Моля, уверете се, че всички предоставени данни отговарят на профила на кредитната ви карта или опитайте с друга карта. Можете да използвате и някой от <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">другите начини да ни направите дарение</a> или да се свържете с нас на адрес <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Благодарим ви за подкрепата.',
	'payflowpro_gateway-response-default' => 'Имаше грешка при обработката на превода ми.
Опитайте отново по-късно.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Ehsanulhb
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'payflowprogateway' => 'এখনই আপনার অনুদানটি প্রদান করুন',
	'payflowpro_gateway-desc' => 'পেপ্যাল পেফ্লো প্রো ক্রেডিট কার্ড প্রসেসিং',
	'payflowpro_gateway-response-0' => 'আপনার লেনদেনটি সফলভাবে সম্পন্ন হয়েছে।
আপনার অনুদানের জন্য ধন্যবাদ!',
	'payflowpro_gateway-response-126' => 'আপনার লেনদেনটির অনুমোদন বাকী রয়েছে।',
	'payflowpro_gateway-response-126-2' => 'আপনার প্রদানকৃত কিছু তথ্য ক্রেডিট কার্ডের প্রোফাইলের সাথে সাদৃশ্যপূর্ণ নয়, অথবা আপনি একটি বড় ধরনের উপহার প্রদান করেছেন। আপনার নিজের নিরাপত্তার জন্যই, আপনার অনুদানটি বর্তমানে পরীক্ষণের জন্য রাখা হয়েছে। আমরা যদি আপনার অনুদান গ্রহণ করতে ব্যর্থ হই তবে আমরা আপনার প্রদানকৃত ই-মেইল ঠিকানার মাধ্যমে আপনার সাথে যোগাযোগ করবো। অনুগ্রহপূর্বক আপনার যে-কোনো প্রশ্নের জন্য <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> ঠিকানায় ই-মেইল করতে পারেন। ধন্যবাদ!',
	'payflowpro_gateway-response-12' => 'আরও তথ্যের জন্য অনুগ্রহপূর্বক আপনার ক্রেডিট কার্ড কোম্পানির সাথে যোগাযোগ করুন।',
	'payflowpro_gateway-response-13' => 'আপনার লেনদেনটি সম্পূর্ণ করতে ভয়েজ অথরাইজেশন প্রয়োজন।
লেনদেনটি সম্পূর্ণ করতে অনুগ্রহপূর্বক আমাদের সাথে যোগোযোগ করুন।',
	'payflowpro_gateway-response-114' => 'আরও তথ্যের জন্য অনুগ্রহপূর্বক আপনার ক্রেডিট কার্ড কোম্পানির সাথে যোগাযোগ করুন।',
	'payflowpro_gateway-response-23' => 'আপনার ক্রেডিট কার্ড নম্বর অথবা মেয়াদ উত্তীর্ণের তারিখটি সঠিক নয়।',
	'payflowpro_gateway-response-4' => 'ভুল পরিমাণ',
	'payflowpro_gateway-response-24' => 'আপনার ক্রেডিট কার্ড নম্বর অথবা মেয়াদ উত্তীর্ণের তারিখটি সঠিক নয়।',
	'payflowpro_gateway-response-112' => 'আপনার ঠিকানা বা সিভিভি নম্বরটি (নিরাপত্তা কোড) সঠিক নয়।',
	'payflowpro_gateway-response-125' => 'ফ্রড প্রিভেনশন সার্ভিস কর্তৃক আপনার লেনদেনটি প্রত্যাখান করা হয়েছে।',
	'payflowpro_gateway-response-125-2' => 'আপনার ক্রেডিট কার্ড নিশ্চিত করা সম্ভব হয়নি। অনুগ্রহপূর্বক আপনার সকল তথ্যাদি, আপনার ক্রেডিট কার্ডের প্রোফাইলের সাথে মিলিয়ে প্রদান করুন, অথবা ভিন্ন একটি কার্ডের মাধ্যমে চেষ্টা করুন। এছাড়াও আপনি আমাদের <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">প্রদানের অন্যান্য পদ্ধতি</a> থেকে একটি পদ্ধতি বেছে নিতে পারেন অথবা <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> ঠিকানায় আমাদের সাথে যোগাযোগ করতে পারেন। আপনার সহায়তার জন্য আপনাকে ধন্যবাদ!',
	'payflowpro_gateway-response-default' => 'আপনার লেনদেনটি প্রক্রিয়াকৃত করার সময় কোনো সমস্যা সৃষ্টি হয়েছে।
অনুগ্রহপূর্বক কিছুক্ষণ পর আবার চেষ্টা করুন।',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'payflowprogateway' => 'Grit ur roadenn bremañ',
	'payflowpro_gateway-desc' => 'Treterezh dre gartenn-gred PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => "Asantet ez eus bet d'an treuzgread.
Ho trugarekaat evit ho tonezon!",
	'payflowpro_gateway-response-126' => "O c'hortoz asantiñ d'an treuzgread emeur",
	'payflowpro_gateway-response-126-2' => "Lod eus an titouroù lakaet ganeoc'h ne glotont ket gant profil ho kartenn-vank, pe neuze hoc'h eus graet ur prof uhel-kaer. Evit ho kwareziñ, emeur bremañ o wiriañ an donezon. Kaset e vo deoc'h keloù dre ar postel merket ganeoc'h ma ne zeuomp ket a-benn d'ober war-dro ho tonezon. Mar fell deoc'h gouzout hiroc'h e c'hallit kas ur postel deomp da <a href=\"mailto:donate@wikimedia.org\">donate@wikimedia.org</a>. Trugarez vras !",
	'payflowpro_gateway-response-12' => "Kit e darempred gant ho kompagnunezh kartenn-gred evit gouzout hiroc'h.",
	'payflowpro_gateway-response-13' => "Un aotre dre ar vouezh  zo rekis evit an treuzgread.
Deuit e darempred ganeomp evit kenderc'hel ganti.",
	'payflowpro_gateway-response-114' => "Kit e darempred gant ho kompagnunezh kartenn-gred evit gouzout hiroc'h.",
	'payflowpro_gateway-response-23' => 'Fall eo an niverenn kartenn-gred pe an deiziad termen lakaet.',
	'payflowpro_gateway-response-4' => 'Sammad direizh.',
	'payflowpro_gateway-response-24' => 'Fall eo an niverenn kartenn-gred pe an deiziad termen lakaet.',
	'payflowpro_gateway-response-112' => "Fall eo ar chomlec'h pe an niverenn CVV (kod surentez) lakaet.",
	'payflowpro_gateway-response-125' => "Dinac'het eo bet an treuzgread gant Servijoù Dizarbenn ar Floderezh.",
	'payflowpro_gateway-response-125-2' => "N'eus ket bet gallet kadarnaat ho kartenn. Gwiriit mat e klot an titouroù lakaet ganeoc'h gant profil ho kartenn-vank, pe neuze klaskit gant ur gartenn all. Gallout a rit ober gant <a href=\"http://wikimediafoundation.org/wiki/Ways_to_Give/en\">diskoulmoù all da reiñ, ivez,</a> pe mont e darempred ganeomp dre ar chomlec'h da-heul <a href=\"mailto:donate@wikimedia.org\">donate@wikimedia.org</a>. Trugarez deoc'h evit harpañ ac'hanomp.",
	'payflowpro_gateway-response-default' => 'Ur fazi zo bet e-ser plediñ gant ho treuzgread.
Klaskit en-dro a-benn ur pennadig.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'payflowprogateway' => 'Donirajte sada',
	'payflowpro_gateway-desc' => 'Procesiranje kreditnih kartica preko PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Vaša transakcija je odobrena.
Hvala Vam za Vašu donaciju!',
	'payflowpro_gateway-response-126' => 'Vaša transakcija čeka na provjeru.',
	'payflowpro_gateway-response-126-2' => 'Neke informacije koje ste unijeli ne odgovaraju vašem profilu kreditne kartice, ili ste unijeli veoma veliki poklon. Za vašu sigurnost, vaša donacije je trenutno pod provjerom i mi ćemo vas obavijestiti putem navedenog e-maila ako ne uspijemo okončati vašu donaciju. Molimo pošaljite e-mail na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> ako imate nekih pitanja. Hvala vam!',
	'payflowpro_gateway-response-12' => 'Molimo kontaktirajte vašu kompaniju koja izdaje kreditnu karticu za daljnje informacije.',
	'payflowpro_gateway-response-13' => 'Vaša transakcija zahtjeva glasovnu potvrdu.
Molimo kontaktirajte nas da biste mogli nastaviti vašu transakciju.',
	'payflowpro_gateway-response-114' => 'Molimo kontaktirajte vašu kompaniju koja izdaje kreditne kartice za daljnje informacije.',
	'payflowpro_gateway-response-23' => 'Vaš broj kreditne kartice ili datum isteka nisu tačni.',
	'payflowpro_gateway-response-4' => 'Nevaljan iznos.',
	'payflowpro_gateway-response-24' => 'Vaš broj kreditne kartice ili datum isteka nisu tačni.',
	'payflowpro_gateway-response-112' => 'Vaša adresa ili CVV broj (sigurnosni kod) nisu tačni.',
	'payflowpro_gateway-response-125' => 'Vaša transakcija je odbijena od strane Službe za prevenciju zloupotreba.',
	'payflowpro_gateway-response-125-2' => 'Vaša kreditna kartica nije mogla biti provjerena. Molimo provjerite da li svi navedeni podaci odgovaraju profilu vaše kreditne kartice ili pokušajte drugu karticu. Također možete koristiti neki od naših <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">drugih načina za doniranje</a> ili nas kontaktirate na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Hvala vam za vašu podršku.',
	'payflowpro_gateway-response-default' => 'Desila se greška pri procesiranju vaše transakcije.
Molimo pokušajte kasnije.',
);

/** Catalan (Català)
 * @author Aleator
 * @author Martorell
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'payflowprogateway' => 'Feu ara un donatiu',
	'payflowpro_gateway-desc' => 'Processament de targetes de crèdit amb PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'La transacció ha estat aprovada.
Gràcies pel donatiu!',
	'payflowpro_gateway-response-126' => "La transacció està pendent d'aprovació.",
	'payflowpro_gateway-response-126-2' => 'Part de la informació que ens heu proporcionat no coincideix amb el vostre perfil de targeta de crèdit, o bé heu fet un donatiu molt gran. Per a la vostra pròpia seguretat, el donatiu és objecte d\'examen, i us notificarem a través de l\'adreça de correu electrònic facilitada, si no podem finalitzar el donatiu. Podeu enviar un missatge a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> si teniu alguna pregunta. Gràcies!',
	'payflowpro_gateway-response-12' => 'Poseu-vos en contacte amb la companyia de la targeta de crèdit per a més informació.',
	'payflowpro_gateway-response-13' => 'Aquesta operació requereix autorització de veu.
Poseu-vos en contacte amb nosaltres per continuar amb la transacció.',
	'payflowpro_gateway-response-114' => 'Poseu-vos en contacte amb la companyia de la targeta de crèdit per a més informació.',
	'payflowpro_gateway-response-23' => 'La data de caducitat o el número de la targeta de crèdit és incorrecte.',
	'payflowpro_gateway-response-4' => 'Quantitat no vàlida.',
	'payflowpro_gateway-response-24' => 'La data de caducitat o el número de targeta de crèdit és incorrecte.',
	'payflowpro_gateway-response-112' => "L'adreça o el codi de seguretat CVV és incorrecte.",
	'payflowpro_gateway-response-125' => 'La vostra transacció ha estat rebutjada pel Servei de Prevenció del Frau.',
	'payflowpro_gateway-response-125-2' => 'No s\'ha pogut validar la vostra targeta de crèdit. Si us plau, verifiqueu que tota la informació facilitada correspongui al vostre perfil de targeta de crèdit, o proveu amb una altra targeta. També podeu usar una altra de les nostres <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">formes de donar</a> o podeu posar-vos en contacte amb nosaltres a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Gràcies pel vostre suport.',
	'payflowpro_gateway-response-default' => 'Hi ha hagut un error en processar la vostra transacció. Torneu-ho a provar més tard.',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Jkjk
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'payflowprogateway' => 'Přispět teď',
	'payflowpro_gateway-desc' => 'Zpracování kreditních karet PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Vaše transakce byla schválena.
Děkujeme za váš příspěvek!',
	'payflowpro_gateway-response-126' => 'Čeká se na schválení vaší transakce.',
	'payflowpro_gateway-response-126-2' => 'Některé ze zadaných údajů nesouhlasí s informacemi ke kreditní kartě nebo byl váš dar velmi vysoký. Kvůli vaší bezpečnosti bude váš příspěvek nyní prověřen; pokud bychom nemohli darování dokončit, budeme vás informovat prostřednictvím vámi uvedené e-mailové adresy. Pokud máte libovolné dotazy, napište na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Děkujeme!',
	'payflowpro_gateway-response-12' => 'O podrobnější informace požádejte vydavatele vaší kreditní karty.',
	'payflowpro_gateway-response-13' => 'Vaše transakce vyžaduje hlasovou autorizaci.
Pro dokončení transakce nás kontaktujte.',
	'payflowpro_gateway-response-114' => 'O podrobnější informace požádejte vydavatele vaší kreditní karty.',
	'payflowpro_gateway-response-23' => 'Číslo kreditní karty nebo datum konce platnosti nesouhlasí.',
	'payflowpro_gateway-response-4' => 'Neplatná částka.',
	'payflowpro_gateway-response-24' => 'Číslo vaší karty nebo datum konce platnosti nesouhlasí.',
	'payflowpro_gateway-response-112' => 'Vaše adresa nebo bezpečnostní kód CVV nesouhlasí.',
	'payflowpro_gateway-response-125' => 'Vaše transakce byla zamítnuta ochranou proti zneužití karet.',
	'payflowpro_gateway-response-125-2' => 'Vaši kreditní kartu se nepodařilo ověřit. Zkontrolujte, že všechny uvedené informace odpovídají údajům o vaší kartě, nebo zkuste použít jinou kartu. Můžete také využít našich <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">dalších způsobů, jak přispět,</a> nebo nám napište na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Děkujeme za vaši podporu.',
	'payflowpro_gateway-response-default' => 'Při zpracovávání vaší transakce došlo k chybě.
Zkuste to znovu o něco později.',
);

/** Welsh (Cymraeg)
 * @author Arwel Parry
 * @author Lloffiwr
 * @author Reedy
 */
$messages['cy'] = array(
	'payflowprogateway' => 'Rhoddwch nawr',
	'payflowpro_gateway-desc' => 'Prosesu cerdyn credyd gyda PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Cadarnhawyd eich taliad.
Diolch am roi!',
	'payflowpro_gateway-response-126' => "Mae'ch taliad yn disgwyl cadarnhad.",
	'payflowpro_gateway-response-126-2' => "Nid oedd rhai o'r manylion a roesoch yn cyfateb â'ch proffil cerdyn credyd, ynteu mae'ch rhodd yn un mawr iawn. Er mwyn eich diogelu, rydym wrthi'n bwrw golwg dros eich rhodd. Os na allwn gwblhau'ch rhodd, fe rown wybod ichi mewn e-bost at y cyfeiriad y rhoesoch i ni. Anfonwch e-bost at <a href=\"mailto:donate@wikimedia.org\">donate@wikimedia.org</a> os ydych am holi rhywbeth, os gwelwch yn dda. Diolch!",
	'payflowpro_gateway-response-12' => "Cysylltwch â'r cwmni sy'n darparu'ch cerdyn credyd i gael rhagor o wybodaeth.",
	'payflowpro_gateway-response-13' => "Mae angen awdurdodi'ch taliad â'ch llais.
Cysylltwch â ni er mwyn parhau gyda'ch taliad.",
	'payflowpro_gateway-response-114' => "Cysylltwch â'r cwmni sy'n darparu'ch cerdyn credyd i gael rhagor o wybodaeth.",
	'payflowpro_gateway-response-23' => "Mae manylion naill ai rhif eich cerdyn neu'r dyddiad y daw i ben yn anghywir.",
	'payflowpro_gateway-response-4' => 'Swm annilys.',
	'payflowpro_gateway-response-24' => "Mae manylion naill ai rhif eich cerdyn neu'r dyddiad y daw i ben yn anghywir.",
	'payflowpro_gateway-response-112' => "Mae manylion naill ai'ch cyfeiriad neu rhif CVV eich cerdyn (y cod diogelwch) yn anghywir.",
	'payflowpro_gateway-response-125' => 'Gwrthodwyd eich taliad gan y Gwasanaethau Atal Twyll.',
	'payflowpro_gateway-response-125-2' => 'Ni lwyddwyd i ddilysu\'ch cerdyn credyd. Sicrhewch bod y manylion a roesoch yn cyfateb â\'ch proffil cerdyn credyd, neu ceisiwch ddefnyddio cerdyn arall. Gallwch hefyd ddefnyddio <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">modd arall o roi</a>, neu anfon e-bost atom yn <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Diolch am eich cefnogaeth.',
	'payflowpro_gateway-response-default' => "Cafwyd gwall wrth brosesu'ch taliad.
Ceisiwch eto ymhen ychydig, os gwelwch yn dda.",
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 * @author Peter Alberti
 */
$messages['da'] = array(
	'payflowprogateway' => 'Doner nu',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro kreditkorthåndtering',
	'payflowpro_gateway-response-0' => 'Din transaktion er blevet godkendt.
Tak for din donation!',
	'payflowpro_gateway-response-126' => 'Din overførsel afventer godkendelse.',
	'payflowpro_gateway-response-126-2' => 'Nogle af de oplysninger, du har angivet, passer ikke til din kreditkortprofil, eller du har givet en meget stor gave. For din egen sikkerhed, er din donation i øjeblikket under revision, og vi vil give dig besked via den oplyste email-adresse, hvis vi ikke kan færdiggøre din donation. Venligst e-mail <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> , hvis du har nogle spørgsmål. Tak!',
	'payflowpro_gateway-response-12' => 'Du bedes kontakte firmaet, der har udstedt dit kreditkort, for flere oplysninger.',
	'payflowpro_gateway-response-13' => 'Din transaktion kræver stemmegodkendelse.
Vær så venlig at kontakte os for at fortsætte din transaktion.',
	'payflowpro_gateway-response-114' => 'Du bedes kontakte firmaet, der har udstedt dit kreditkort, for flere oplysninger.',
	'payflowpro_gateway-response-23' => 'Dit kreditkortnummer eller udløbsdatoen er forkert.',
	'payflowpro_gateway-response-4' => 'Ugyldigt beløb.',
	'payflowpro_gateway-response-24' => 'Dit kreditkortnummer eller udløbsdatoen er forkert.',
	'payflowpro_gateway-response-112' => 'Din adresse eller dit CVV-nummer (sikkerhedskode) er forkert.',
	'payflowpro_gateway-response-125' => 'Din transaktion er blevet afvist af Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Dit kreditkort kunne ikke valideres. Vær så venlig at kontrollere at alle opgivne oplysninger svarer til din kreditkortprofil eller prøv et andet kort. Du kan også bruge en af vores <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">andre måder at give på</a> eller kontakte os på <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Tak for din støtte.',
	'payflowpro_gateway-response-default' => 'Der opstod en fejl under behandlingen af din transaktion.
Prøv venligst igen senere.',
);

/** German (Deutsch)
 * @author Imre
 * @author Kghbln
 * @author Lyzzy
 * @author Metalhead64
 * @author Purodha
 * @author Tbleher
 * @author Umherirrender
 */
$messages['de'] = array(
	'payflowprogateway' => 'Jetzt spenden',
	'payflowpro_gateway-desc' => 'Ermöglicht die Spendenabwicklung per „Payflow Pro“ von PayPal oder per Kreditkarte',
	'payflowpro_gateway-response-0' => 'Ihre Transaktion wurde genehmigt.
Vielen Dank für Ihre Spende.',
	'payflowpro_gateway-response-126' => 'Es wird auf eine Freigabe Ihrer Transaktion gewartet.',
	'payflowpro_gateway-response-126-2' => 'Einige Informationen stimmen nicht mit Ihrem Kreditkartenprofil überein oder die Spende ist zu hoch. Zu Ihrer eigenen Sicherheit wird Ihre Spende überprüft. Wir informieren Sie über die angegebene E-Mail-Adresse, sofern wir Ihre Spende nicht abschließen können. Bitte schicken Sie uns im Fall von Fragen eine E-Mail an <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Vielen Dank.',
	'payflowpro_gateway-response-12' => 'Bitte nehmen Sie für weitere Informationen mit Ihrem Kreditinstitut Kontakt auf.',
	'payflowpro_gateway-response-13' => 'Ihre Transaktion erfordert eine manuelle Bearbeitung.
Bitte nehmen Sie mit uns Kontakt auf, um Ihre Transaktion abzuschließen.',
	'payflowpro_gateway-response-114' => 'Bitte nehmen Sie mit dem Kreditinstitut Kontakt auf, das Ihre Karte ausgegeben hat.',
	'payflowpro_gateway-response-23' => 'Ihre Kreditkartennummer oder das Ablaufdatum der Kreditkarte ist falsch.',
	'payflowpro_gateway-response-4' => 'Ungültiger Betrag.',
	'payflowpro_gateway-response-24' => 'Ihre Kreditkartennummer oder das Ablaufdatum der Kreditkarte ist falsch.',
	'payflowpro_gateway-response-112' => 'Ihre Anschrift oder der Sicherheitscode (CVV) ist falsch.',
	'payflowpro_gateway-response-125' => 'Ihre Transaktion wurde durch den Betrugs-Vorbeuge-Service abgelehnt.',
	'payflowpro_gateway-response-125-2' => 'Ihre Kreditkarte kann nicht geprüft werden. Bitte bestätigen Sie, dass alle Informationen mit Ihrem Kreditkartenprofil übereinstimmen oder versuchen Sie es mit einer anderen Karte. Sie können auch unsere <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">anderen Spendemöglichkeiten</a> ausprobieren oder kontaktieren Sie uns unter der E_Mail-Adresse <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Vielen Dank.',
	'payflowpro_gateway-response-default' => 'Während des Ausführens der Transaktion ist ein Verarbeitungsfehler aufgetreten.
Bitte versuchen Sie es später noch einmal.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'payflowpro_gateway-response-0' => 'Ihre Transaktion wurde durchgeführt.
Vielen Dank für Ihre Spende.',
	'payflowpro_gateway-response-126' => 'Für Ihre Transaktion wird auf eine Freigabe gewartet.',
	'payflowpro_gateway-response-126-2' => 'Einige Informationen stimmen nicht mit Ihrem Kreditkartenprofil überein oder die Spende ist zu hoch. Zu Ihrer eigenen Sicherheit befindet sich Ihre Spende unter Prüfung und wir informieren Sie über die angegebene E-Mail-Adresse, falls wir Ihre Spende nicht abschließen können. Bitte schicken Sie uns bei Fragen eine E-Mail an <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Vielen Dank!',
	'payflowpro_gateway-response-12' => 'Bitte nehmen Sie für weitere Informationen mit Ihrem Kreditinstitut Kontakt auf.',
	'payflowpro_gateway-response-13' => 'Ihre Transaktion benötigt eine manuelle Bearbeitung.
Bitte nehmen Sie mit uns Kontakt auf, um Ihre Transaktion abzuschließen.',
	'payflowpro_gateway-response-114' => 'Bitte nehmen Sie mit ihrem kartenausgebenden Kreditinstitut Kontakt auf.',
	'payflowpro_gateway-response-23' => 'Ihre Kreditkartennummer oder das Ablaufdatum ist falsch.',
	'payflowpro_gateway-response-24' => 'Ihre Kreditkartennummer oder das Ablaufdatum ist falsch.',
	'payflowpro_gateway-response-112' => 'Ihre Anschrift oder der Sicherheitscode (CVV) ist falsch.',
	'payflowpro_gateway-response-125' => 'Ihre Transaktion wurde durch den Betrugs-Vorbeuge-Service abgelehnt.',
	'payflowpro_gateway-response-125-2' => 'Ihre Kreditkarte kann nicht geprüft werden. Bitte bestätigen Sie, dass alle Informationen mit Ihrem Kreditkartenprofil übereinstimmen oder versuchen Sie es mit einer anderen Karte. Sie können auch unsere <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">anderen Spendemöglichkeiten</a> ausprobieren oder kontaktieren Sie uns unter <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Vielen Dank.',
	'payflowpro_gateway-response-default' => 'Während des Ausführens der Transaktion ist ein Verarbeitungsfehler aufgetreten.
Bitte versuchen Sie es später noch einmal.',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 * @author Xoser
 */
$messages['diq'] = array(
	'payflowprogateway' => 'Wikimediya rê destek bide',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro prosesa kardê krediyi',
	'payflowpro_gateway-response-0' => 'Transactionê ti testiq biyo.
Bexşê ti ra ma zaf teşkur kenê!',
	'payflowpro_gateway-response-126' => 'Transactionê ti ho testiq beno.',
	'payflowpro_gateway-response-126-2' => 'Tayê melumato ke to dayo, ebe karta krediyê profili ra yewbini nêgêno, ya zi to meblağo de gırd da. Seba emniyetê xo, beğşê to nıka qontrol beno, u ma ebe email adresa daiye ra to rê rışenime eke beğşê to qebul nêbi. Kerem ke, persê to ke estê be <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> ra ma rê email bırışe. Weş u war be!',
	'payflowpro_gateway-response-12' => 'Ma rica keno ser kardê kredi xo ra bank ra kontak bike.',
	'payflowpro_gateway-response-13' => 'Qe transaksiyon ti ra otorizationo veng lazim o. 
Ma rica kenê mar ra yew mesaj bişawi ke ma transaksiyon tu biqedi.',
	'payflowpro_gateway-response-114' => 'Ma rica keno bankê xo ra kontak bike ser kardê kredi xo.',
	'payflowpro_gateway-response-23' => 'Ma rica keno ser kardê kredi xo ra bank ra kontak bike.',
	'payflowpro_gateway-response-4' => 'Meblagê raşti.',
	'payflowpro_gateway-response-24' => 'Numreyê kard ê kredi tu ya zi wextê kard ê kredi raşt niyo.',
	'payflowpro_gateway-response-112' => 'Numreyê CVV kardê kredi tu ya zi adresê tu raşt niyo.',
	'payflowpro_gateway-response-125' => 'Fraud Prevention Services trasaktion tu kebul nikena.',
	'payflowpro_gateway-response-125-2' => 'Karta krediyê to nêşaye tesdiq bo. Kerem ke, melumato ke pêro dayo be karta krediyê profiliê to yewbini gêno wa qontrol ke, ya zi karta de bine bıcerrebne. Tı şena yewê da ê ma <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">be raya bine dayış</a> bıgurênê ya zi ma de be <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> temas kewe. Seba beğşê xo weş u war be!',
	'payflowpro_gateway-response-default' => 'Transaction tu de yew gelet biyo.
Ma rica kenê reyna dest bi bike.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'payflowprogateway' => 'Něnto pósćiś',
	'payflowpro_gateway-desc' => 'Pśeźěłowanje kreditoweje kórty PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Twója transakcija jo se pśizwóliła.
Źěkujomy s za twój dar!',
	'payflowpro_gateway-response-126' => 'Twója transakcija caka na pśizwólenje.',
	'payflowpro_gateway-response-126-2' => 'Někotare z informacijow, kótarež sćo pódał, njewótpowěduju profiloju wašeje kredtineje kórty, abo sy wjelgin wjeliki dar pósćił. Za wašu wěstotu waš dar pśekontrolěrujo se tuchylu, a buźomy was informěrowaś pśez pódanu e-mailowu adresu, jolic njamóžomy wašo pósćiwanje dokóńcyś. Pšosym pósćelśo e-mail na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>, jolic maśo pšašanja. Źěkujomy se!',
	'payflowpro_gateway-response-12' => 'Pšosym staj se ze swójim pśedewześim kreditoweje kórty za dalšne informacije do zwiska.',
	'payflowpro_gateway-response-13' => 'Twója transakcija pomina se głosowu awtorizaciju.
Pšosym staj se z nami do zwiska, aby z transakciju pókšacował.',
	'payflowpro_gateway-response-114' => 'Pšosym staj se ze swójim pśedewześim kreditoweje kórty za dalšne informacije do zwiska.',
	'payflowpro_gateway-response-23' => 'Cysło twójeje kreditoweje kórty abo datum spadnjenja jo wopak.',
	'payflowpro_gateway-response-4' => 'Njepłaśiwa suma.',
	'payflowpro_gateway-response-24' => 'Cysło twójeje kreditoweje kórty abo datum spadnjenja jo wopak.',
	'payflowpro_gateway-response-112' => 'Twója adresa abo CVV-cysło (wěstotny kod) jo wopak.',
	'payflowpro_gateway-response-125' => 'Twója transakcija jo se wot Fraud Prevention Services wótpokazała.',
	'payflowpro_gateway-response-125-2' => 'Waša kreditna kórta njedajo se pśekotnrolěrowaś. Pšosym pśeglědajśo, lěc wše pódane informacije wótpowěduju profiloju wašeje kreditneje kórty abo wopytajśo drugu kórtu. Móžoš teke jadnu z našych <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">drugich pósćiwańskich móžnosćow</a> wužywaś abo se z nami pśez <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> do zwiska stajiś. Źěkujomy se za wašu pódpěru.',
	'payflowpro_gateway-response-default' => 'Pśi pśeźěłowanju twójeje transakcije jo zmólka nastała.
Pšosym wopytaj pózdźej hyšći raz.',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Glavkos
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'payflowprogateway' => 'Κάντε τη δωρεά σας τώρα',
	'payflowpro_gateway-response-0' => 'Έχει εγκριθεί η συναλλαγή σας.
Σας ευχαριστούμε για την δωρεά σας!',
	'payflowpro_gateway-response-126' => 'Εκκρεμεί έγκριση της συναλλαγής σας.',
	'payflowpro_gateway-response-12' => 'Παρακαλούμε επικοινωνήστε με την εταιρεία της πιστωτικής σας κάρτας για περισσότερες πληροφορίες.',
	'payflowpro_gateway-response-114' => 'Παρακαλούμε επικοινωνήστε με την εταιρεία της πιστωτικής σας κάρτας για περισσότερες πληροφορίες.',
	'payflowpro_gateway-response-23' => 'Ο αριθμός της πιστωτικής σας κάρτα ή η ημερομηνία λήξης είναι λανθασμένος.',
	'payflowpro_gateway-response-4' => 'Άκυρο ποσό.',
	'payflowpro_gateway-response-24' => 'Ο αριθμός της πιστωτικής σας κάρτα ή η ημερομηνία λήξης είναι λανθασμένος.',
	'payflowpro_gateway-response-112' => 'Η διεύθυνσή σας ή ο αριθμός CVV (κωδικός ασφαλείας) είναι εσφαλμένος.',
	'payflowpro_gateway-response-125' => 'Συναλλαγή σας έχει απορριφθεί από τις υπηρεσίες καταπολέμησης της απάτης.',
	'payflowpro_gateway-response-default' => 'Παρουσιάστηκε σφάλμα κατά την επεξεργασία της συναλλαγής σας.
Ξαναπροσπαθήστε αργότερα.',
);

/** British English (British English)
 * @author Reedy
 */
$messages['en-gb'] = array(
	'payflowpro_gateway-response-126-2' => 'Some of the information you provided did not match your credit card profile, or you made a very large gift. For your own security, your donation is currently under review, and we will notify you through the provided e-mail address if we cannot finalise your donation. Please e-mail <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> if you have any questions. Thank you!',
	'payflowpro_gateway-response-13' => 'Your transaction requires voice authorisation.
Please contact us to continue your transaction.',
);

/** Esperanto (Esperanto)
 * @author ArnoLagrange
 * @author Yekrats
 */
$messages['eo'] = array(
	'payflowprogateway' => 'Donacu nun',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro kreditkarta proceso',
	'payflowpro_gateway-response-0' => 'Via pago estis aprobita.
Dankon pro via donaco!',
	'payflowpro_gateway-response-126' => 'Via pago atendas aprobon.',
	'payflowpro_gateway-response-126-2' => 'Iom da la informo kiun vi provizis ne kongruis vian kreditkartan profilon, aŭ vi faris tre grandan donacon. Por via propra sekureco, via mondonaco nune estas kontrolota, kaj ni notigos vin per la provizita retadreso se ni ne povas finigi vian donacon. Bonvolu retpoŝti <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> se vi havas iun ajn demandojn. Dankon!',
	'payflowpro_gateway-response-12' => 'Bonvolu kontakti vian kreditkartan firmaon por pliaj informoj.',
	'payflowpro_gateway-response-13' => 'Via pago postulas voĉan rajtigon. 
Bonvolu kontakti nin por plufari vian pagon.',
	'payflowpro_gateway-response-114' => 'Bonvolu kontakti vian kreditkartan firmaon por pliaj informoj.',
	'payflowpro_gateway-response-23' => 'Via kreditkarta numero aŭ validlimdato estas malĝusta.',
	'payflowpro_gateway-response-4' => 'Malvalida monsumo.',
	'payflowpro_gateway-response-24' => 'Via kreditkarta numero aŭ validlimdato estas malĝusta.',
	'payflowpro_gateway-response-112' => 'Via adreso aŭ sekureca kodo estas malĝusta.',
	'payflowpro_gateway-response-125' => 'Via pago estis malaprobita de Kontraŭfraŭdaj Servoj.',
	'payflowpro_gateway-response-125-2' => 'Via kreditkarto ne estis validigebla. Bonvolu verigi ke ĉiu provizita informo kongruas vian kreditkartan profilon, aŭ utiligi alian karton. Vi ankaŭ povas uzi unu el niaj <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">aliaj metodoj por donaci</a> aŭ kontakti nin ĉe <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Dankon pro via subteno.',
	'payflowpro_gateway-response-default' => 'Estis eraro dum procedado de via pago.
Bonvolu provi denove pli poste.',
);

/** Spanish (Español)
 * @author Cbrown1023
 * @author Crazymadlover
 * @author Dferg
 * @author Diego Grez
 * @author Drini
 * @author Fitoschido
 * @author Locos epraix
 * @author MetalBrasil
 * @author MisterWiki
 * @author Mor
 * @author Od1n
 * @author Translationista
 */
$messages['es'] = array(
	'payflowprogateway' => 'Haga su donación ahora',
	'payflowpro_gateway-desc' => 'Procesando tarjeta de crédito PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'La transacción ha sido aprobada.
¡Gracias por tu donación!',
	'payflowpro_gateway-response-126' => 'Tu transacción está pendiente de ser aprobada.',
	'payflowpro_gateway-response-126-2' => 'La información que has dado no coincide con tu perfil de tarjeta de crédito, o haz hecho un regalo muy grande. Por tu propia seguridad, tu donación aún se encuentra bajo estudio, y te notificaremos por medio del e-mail que has dado si no pudimos finalizar tu donación. Por favor envíe un e-mail a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> si tiene cualquier pregunta. ¡Gracias!',
	'payflowpro_gateway-response-12' => 'Por favor, contacta con la compañía de tu tarjeta de crédito para más información.',
	'payflowpro_gateway-response-13' => 'Tu transacción requiere de autorización de palabra.
Por favor contáctanos para continuar la transacción.',
	'payflowpro_gateway-response-114' => 'Por favor, contacta con la compañía de tu tarjeta de crédito para más información.',
	'payflowpro_gateway-response-23' => 'La fecha de vencimiento de tu tarjeta de crédito es incorrecta.',
	'payflowpro_gateway-response-4' => 'Cantidad inválida.',
	'payflowpro_gateway-response-24' => 'La fecha de vencimiento de tu tarjeta de crédito es incorrecta.',
	'payflowpro_gateway-response-112' => 'Tu dirección o número CVV (código de seguridad) son incorrectos.',
	'payflowpro_gateway-response-125' => 'Tu transacción ha sido rechazada por los Servicios de Prevención de Fraudes (Fraud Prevention Services).',
	'payflowpro_gateway-response-125-2' => 'Tu tarjeta de crédito no pudo ser validada. Por favor verifique que toda la información dada coincide con tu perfil de tarjeta de crédito, o prueba con una tarjeta diferente. Puedes usar también una de nuestras <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">otras formas de dar</a> o contactarnos a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Gracias por tu apoyo.',
	'payflowpro_gateway-response-default' => 'Hubo un error procesando tu transacción.
Por favor intente mas tarde.',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'payflowprogateway' => 'Anneta kohe',
	'payflowpro_gateway-response-0' => 'Sinu ülekanne on heakskiidetud. 
Aitäh annetamast.',
	'payflowpro_gateway-response-126' => 'Sinu ülekanne ootab heakskiitu.',
	'payflowpro_gateway-response-12' => 'Lisainfo krediitkaardi väljastanud ettevõttelt.',
	'payflowpro_gateway-response-114' => 'Lisateave krediitkaardi väljastanud ettevõttelt.',
	'payflowpro_gateway-response-23' => 'Krediitkaardinumber või aegumistähtaeg on vale.',
	'payflowpro_gateway-response-4' => 'Vigane summa.',
	'payflowpro_gateway-response-24' => 'Krediitkaardinumber või aegumistähtaeg on vale.',
	'payflowpro_gateway-response-112' => 'Aadress või turvakood on vale.',
	'payflowpro_gateway-response-default' => 'Sinu ülekande töötlemisel tekkis viga.
Palun ürita hiljem uuesti.',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'payflowprogateway' => 'Egin orain zure dohaintza',
	'payflowpro_gateway-response-12' => 'Mesedez jar zaitez zure kreditu txartelaren enpresarekin harremanetan informazio gehiagorako.',
	'payflowpro_gateway-response-4' => 'Kopuru okerra.',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Mjbmr
 * @author Sahim
 * @author Wayiran
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'payflowprogateway' => 'همینک اهدا کنید',
	'payflowpro_gateway-desc' => 'پردازش کارت اعتباری PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'انتقال وجه شما تأیید شده است.
تشکر از کمک مالی شما!',
	'payflowpro_gateway-response-126' => 'انتقال وجه شما در انتظار تأیید است.',
	'payflowpro_gateway-response-126-2' => 'برخی از اطلاعاتی که ارائه کردید با پروندهٔ کارت اعتباری‌تان همخوانی نداشت، یا آنکه هدیهٔ بسیار بزرگی اهداء کردید. برای امنیت خودتان، کمک مالی شما هم‌اکنون در حال بازبینی است، و اگر ما نتوانستیم کمک مالی شما را نهایی کنیم، از طریق نشانی پست الکترونیکی ارائه‌شده به شما خبر خواهیم داد. اگر سوالی دارید، لطفاً به ما پست الکترونیکی <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> بفرستید. سپاسگذاریم',
	'payflowpro_gateway-response-12' => 'لطفاً با شرکت کارت اعتباری برای اطلاعات بیشتر تماس بگیرید.',
	'payflowpro_gateway-response-13' => 'انتقال وجه شما به مجوز صوتی نیاز دارد.
لطفاً برای ادامهٔ انتقال وجه با ما تماس بگیرید.',
	'payflowpro_gateway-response-114' => 'لطفاً با شرکت کارت اعتباری برای اطلاعات بیشتر تماس بگیرید.',
	'payflowpro_gateway-response-23' => 'شمارهٔ کارت اعتباری یا تاریخ انقضایتان معتبر نیست.',
	'payflowpro_gateway-response-4' => 'مبلغ نامعتبر',
	'payflowpro_gateway-response-24' => 'شمارهٔ کارت اعتباری یا تاریخ انقضایتان معتبر نیست.',
	'payflowpro_gateway-response-112' => 'نشانی شما یا شمارهٔ CVV (کد امنیتی) نادرست است.',
	'payflowpro_gateway-response-125' => "انتقال وجه شما توسط ''خدمات جلوگیری از کلاه‌برداری'' رد شده است.",
	'payflowpro_gateway-response-125-2' => 'کارت اعتباری شما نتوانست تائید اعتبار شود. لطفاً تائید کنید که همهٔ اطلاعات ارائه‌شده با پروندهٔ کارت اعتباری شما همخوانی دارد، یا یک کارت اعتباری دیگر را بیازمایید. شما همچنین می‌توانید از <a href="http://wikimediafoundation.org/wiki/ارسال">دیگر راه‌های ما برای اعطا</a> استفاده کنید یا از طریق <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> با ما تماس بگیرید. از پشتیبانی شما سپاسگذاریم',
	'payflowpro_gateway-response-default' => 'برای پردازش تراکنش شما خطا وجود دارد.
لطفا دوباره تلاش کنید.',
);

/** Finnish (Suomi)
 * @author Cbrown1023
 * @author Centerlink
 * @author Crt
 * @author Nike
 * @author Olli
 * @author Str4nd
 * @author Tofu II
 * @author ZeiP
 */
$messages['fi'] = array(
	'payflowprogateway' => 'Tee lahjoituksesi nyt',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro -luottokorttikäsittely.',
	'payflowpro_gateway-response-0' => 'Tapahtumasi on hyväksytty.
Kiitos lahjoituksestasi.',
	'payflowpro_gateway-response-126' => 'Siirtosi odottaa hyväksyntää.',
	'payflowpro_gateway-response-126-2' => 'Joku antamistasi tiedoista ei täsmännyt luottokorttisi tietoihin, tai teit erittäin suuren lahjoituksen. Oman turvallisuutesi vuoksi lahjoituksesi on tarkistettavana, ja ilmoitamme antamaasi sähköpostiosoitteeseen jos emme voi viimeistellä lahjoitustasi. Lähetä sähköpostia osoitteeseen <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> jos sinulla on kysymyksiä. Kiitos!',
	'payflowpro_gateway-response-12' => 'Lisätietoja saat luottokorttiyhtiöltäsi.',
	'payflowpro_gateway-response-13' => 'Siirtosi vaatii äänihyväksynnän. 
Ota yhteyttä jatkaaksesi siirtoa.',
	'payflowpro_gateway-response-114' => 'Ota yhteyttä luottokorttiyhtiöösi saadaksesi lisätietoa.',
	'payflowpro_gateway-response-23' => 'Luottokorttisi numero tai vanhenemisaika on väärä.',
	'payflowpro_gateway-response-4' => 'Virheellinen määrä.',
	'payflowpro_gateway-response-24' => 'Luottokorttisi numero tai vanhenemisaika on väärä.',
	'payflowpro_gateway-response-112' => 'Osoitteesi tai CVV-numerosi (turvakoodi) on väärä.',
	'payflowpro_gateway-response-125' => 'Petoksenehkäisypalvelu kielsi siirtosi.',
	'payflowpro_gateway-response-125-2' => 'Luottokorttiasi ei voitu varmentaa. Tarkista, että kaikki antamasi tiedot täsmäävät luottokorttiprofiilisi kanssa, tai kokeile toista korttia. Voit myös käyttää <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">muita lahjoitustapojamme</a> tai ottaa yhteyttä osoitteeseen <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Kiitos tuestasi.',
	'payflowpro_gateway-response-default' => 'Siirtosi käsittelyssä tapahtui virhe.
Yritä myöhemmin uudelleen.',
);

/** French (Français)
 * @author Cedric31
 * @author Crochet.david
 * @author DavidL
 * @author Gomoko
 * @author Grondin
 * @author Hashar
 * @author IAlex
 * @author Jean-Frédéric
 * @author Peter17
 * @author PieRRoMaN
 * @author Quentinv57
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'payflowprogateway' => 'Faire un don maintenant',
	'payflowpro_gateway-desc' => 'Traitement de carte de crédit par PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Votre transaction a été approuvée.
Merci pour votre don !',
	'payflowpro_gateway-response-126' => 'Votre transaction est en cours d’approbation.',
	'payflowpro_gateway-response-126-2' => 'Certaines informations que vous avez fournies ne correspondent pas au profil de votre carte bancaire, ou bien vous avez offert un montant très élevée. Pour votre propre sécurité, votre don est actuellement en cours de vérification, et nous vous préviendrons via l’adresse de courriel que vous avez fournie si nous ne parvenons à finaliser votre don. Pour toute question, n’hésitez pas à adresser un courriel à <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Merci !',
	'payflowpro_gateway-response-12' => 'Veuillez contacter le fournisseur de votre carte de crédit pour plus d’informations.',
	'payflowpro_gateway-response-13' => 'Votre transaction requiert une autorisation vocale.
Veuillez nous contacter pour poursuivre votre transaction.',
	'payflowpro_gateway-response-114' => "Veuillez contacter le fournisseur de votre carte de crédit pour plus d'information.",
	'payflowpro_gateway-response-23' => 'La date d’expiration de votre numéro de carte de crédit est incorrecte.',
	'payflowpro_gateway-response-4' => 'Montant invalide.',
	'payflowpro_gateway-response-24' => "Votre numéro de carte de crédit ou date d'expiration est incorrect(e).",
	'payflowpro_gateway-response-112' => 'Votre adresse ou numéro CVV (code de sécurité) est incorrect(e).',
	'payflowpro_gateway-response-125' => 'Votre transaction a été déclinée par les Services de prévention des fraudes.',
	'payflowpro_gateway-response-125-2' => 'Votre carte bancaire n’a pas pu être validée. Veuillez vérifier que les informations fournies correspondent au profil de votre carte bancaire, ou essayez avec une autre carte. Vous pouvez aussi utiliser <a href="//wikimediafoundation.org/wiki/Ways_to_Give/en">d’autres solutions pour faire un don</a> ou nous contacter à l’adresse <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Nous vous remercions de votre soutien.',
	'payflowpro_gateway-response-default' => 'Une erreur est survenue lors du traitement de votre transaction.
Veuillez réessayer plus tard.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'payflowprogateway' => 'Balyéd orendrêt',
	'payflowpro_gateway-desc' => 'Trètament per cârta de crèdit PayPal Payflow Pro.',
	'payflowpro_gateway-response-0' => 'Voutra transaccion at étâ aprovâ.
Grant-marci por voutron don !',
	'payflowpro_gateway-response-126' => 'Voutra transaccion est aprés étre aprovâ.',
	'payflowpro_gateway-response-126-2' => 'Quârques enformacions que vos éd balyês corrèspondont pas u profil de voutra cârta banquère, ou ben vos éd semondu un montent bien hôt. Por voutra prôpra sècuritât, voutron don est orendrêt en cors de contrôlo, et pués nos vos prèvindrens per l’adrèce èlèctronica que vos éd balyê se nos parvegnens pas a concllure voutron don. Por tota quèstion, volyéd adrèciér un mèssâjo a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Grant-marci !',
	'payflowpro_gateway-response-12' => 'Vos volyéd veriér vers lo fornissor de voutra cârta de crèdit por més d’enformacions.',
	'payflowpro_gateway-response-13' => 'Voutra transaccion at fôta d’una ôtorisacion vocala.
Vos volyéd veriér vers nos por porsiuvre voutra transaccion.',
	'payflowpro_gateway-response-114' => 'Vos volyéd veriér vers lo fornissor de voutra cârta de crèdit por més d’enformacions.',
	'payflowpro_gateway-response-23' => 'Voutron numerô de cârta de crèdit ou ben la dâta d’èxpiracion est fôssa.',
	'payflowpro_gateway-response-4' => 'Montent envalido.',
	'payflowpro_gateway-response-24' => 'Voutron numerô de cârta de crèdit ou ben la dâta d’èxpiracion est fôssa.',
	'payflowpro_gateway-response-112' => 'Voutra adrèce ou ben lo numerô CVV (code de sècuritât) est fôx.',
	'payflowpro_gateway-response-125' => 'Voutra transaccion at étâ refusâ per los Sèrviços de prèvencion de les frôdes.',
	'payflowpro_gateway-response-125-2' => 'Voutra cârta banquère at pas possu étre validâ. Volyéd controlar que totes les enformacions balyês corrèspondont u profil de voutra cârta banquère, ou ben èprovâd avouéc una ôtra cârta. Vos pouede asse-ben utilisar <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">d’ôtros moyens de balyér</a> ou ben vos veriér vers nos a l’adrèce <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Nos vos remarciens por voutron sotin.',
	'payflowpro_gateway-response-default' => 'Una èrror est arrevâ pendent lo trètament de voutra transaccion.
Volyéd tornar èprovar pués aprés.',
);

/** Irish (Gaeilge)
 * @author Kwekubo
 */
$messages['ga'] = array(
	'payflowprogateway' => 'Tacaigh le Wikimedia',
	'payflowpro_gateway-desc' => 'Próiseáil chárta creidmheasa PayPal Payflow Pro',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'payflowprogateway' => 'Fai a túa doazón agora',
	'payflowpro_gateway-desc' => 'Procesamento por tarxeta de crédito PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'A túa transacción foi aprobada.
Grazas pola doazón!',
	'payflowpro_gateway-response-126' => 'A túa transacción está pendente de aprobación.',
	'payflowpro_gateway-response-126-2' => 'Algún dato da información que proporcionaches non coincide co perfil da túa tarxeta de crédito; ou pode ser que fixeras un agasallo moi grande. Pola túa propia seguridade, a túa doazón está sendo revisada nestes intres e serás notificado a través do enderezo de correo electrónico que deches se non podemos finalizar a túa doazón. Envía un correo electrónico a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> se tes algunha dúbida. Grazas!',
	'payflowpro_gateway-response-12' => 'Ponte en contacto coa empresa da túa tarxeta de crédito para obter máis información.',
	'payflowpro_gateway-response-13' => 'A túa transacción esixe unha autorización de voz.
Ponte en contacto connosco para continuar con esta operación.',
	'payflowpro_gateway-response-114' => 'Ponte en contacto coa empresa da túa tarxeta de crédito para obter máis información.',
	'payflowpro_gateway-response-23' => 'O número da túa tarxeta de crédito ou a data de caducidade é incorrecto.',
	'payflowpro_gateway-response-4' => 'A cantidade non é válida.',
	'payflowpro_gateway-response-24' => 'O número da túa tarxeta de crédito ou a data de caducidade é incorrecto.',
	'payflowpro_gateway-response-112' => 'O teu enderezo ou número CVV (código de seguridade) é incorrecto.',
	'payflowpro_gateway-response-125' => 'A túa transacción foi rexeitada polo servizo de prevención de fraudes.',
	'payflowpro_gateway-response-125-2' => 'A túa tarxeta de crédito non se puido validar. Por favor, comproba que toda a información que proporcionaches coincide coa do perfil da túa tarxeta de crédito, ou intenta empregar outra tarxeta. Tamén podes utilizar calquera dos <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">outros xeitos de doar</a> ou porte en contacto connosco no correo electrónico <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Grazas polo teu apoio.',
	'payflowpro_gateway-response-default' => 'Houbo un erro ao procesar a túa transacción.
Por favor, inténtao de novo máis tarde.',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'payflowprogateway' => 'Jetz spände',
	'payflowpro_gateway-desc' => 'Kreditcharte verwände iber PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Dyy Transaktion isch uusgfiert wore.
Dankschen fir Dyy Spände!',
	'payflowpro_gateway-response-126' => 'Dyy Transaktion isch no hängig.',
	'payflowpro_gateway-response-126-2' => 'E Teil vu dr Informatione, wu Du aagee hesch, passe nit zue Dyym Kreditcharte-Profil oder Du hesch e seli große Betrag gspändet. Zue Dyyre eigene Sicherheit wird Dyy Spände zur Zyt iberprieft, un mir mälden is bi Dir iber d E-Mail-Adräss, wu du aagee hesch, wänn mer Dyy Spände nit chenne abschließe. Bitte schryb e Mail an <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>, wänn Du Froge hesch. Dankschen!',
	'payflowpro_gateway-response-12' => 'Bitte nimm Kontakt uf zue Dyyre Charte-Firma fir meh Informatione.',
	'payflowpro_gateway-response-13' => 'Fir Dyy Transaktion brucht s e Stimmeerchännig.
Bitte nimm Kontakt zuen is uf go Dyy Transaktio wyterfiere.',
	'payflowpro_gateway-response-114' => 'Bitte nimm Kontakt uf zue Dyyre Kreditcharte-Firma fir meh Informatione.',
	'payflowpro_gateway-response-23' => 'Dyy Kreditchartenummere oder s Verfallsdatum isch nit korrekt.',
	'payflowpro_gateway-response-4' => 'Nit giltige Betrag.',
	'payflowpro_gateway-response-24' => 'Dyy Kreditchartenummere oder s Verfallsdatum isch nit korrekt.',
	'payflowpro_gateway-response-112' => 'Dyy Adräss oder d CVV-Nummere (Gheimnummere) isch nit korrekt.',
	'payflowpro_gateway-response-125' => 'Dyy Transaktion isch dur Fraud Prevention Services abbroche wore.',
	'payflowpro_gateway-response-125-2' => 'Dyy Kreditcharte het nit chenne validert wäre. Bitte iberprief, eb alli Infomatione, wu Du aagee hesch, zue Dyyre Kreditcharte passe oder versuech s mit ere andre Charte. Du chasch au ne <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">andre Wäg ebis z spände</a> versueche oder nimm Kontakt uf zue uns iber <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Dankschen fir Dyy Unterstitzig.',
	'payflowpro_gateway-response-default' => 'S het e Fähler gee bi dr Uusfierig vu Dyyre Transaktion.
Bitte versuech s speter nonemol.',
);

/** Gujarati (ગુજરાતી)
 * @author Rangilo Gujarati
 */
$messages['gu'] = array(
	'payflowprogateway' => 'તમારું દાન હમણાં કરો',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro credit card processing',
	'payflowpro_gateway-response-0' => 'તમારી લેવડદેવડ મંજૂર કરવામાં આવી છે. </br> 
તમારા દાન માટે આભાર!',
	'payflowpro_gateway-response-126' => 'તમારી લેવડદેવડ મંજૂરી બાકી છે',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'payflowprogateway' => 'הבעת תמיכתך בוויקימדיה כעת',
	'payflowpro_gateway-desc' => 'עיבוד תשלום בכרטיס אשראי PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'העברת הכספים אושרה.
תודה על תרומתכם!',
	'payflowpro_gateway-response-126' => 'העברת הכספים ממתינה לאישור.',
	'payflowpro_gateway-response-126-2' => 'חלק מהפרטים שהזנת אינם תואמים לפרופיל כרטיס האשראי שלך או שהענקת מתנה גדולה מדי. לביטחונך, התרומה שלך נבדקת כעת ואנו נודיע לך דרך כתובת הדוא״ל שסיפקת במידה שלא נוכל לקבל את תרומתך. נא לשלוח דוא״ל אל <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> אם יש לך שאלות כלשהן.  תודה לך!',
	'payflowpro_gateway-response-12' => 'נא ליצור קשר עם חברת האשראי שלך למידע נוסף.',
	'payflowpro_gateway-response-13' => 'העברת הכספים מצידכם דורשת אימות קולי.
אנא צרו איתנו קשר כדי להמשיך בהעברת הכספים.',
	'payflowpro_gateway-response-114' => 'אנא צרו קשר עם חברת האשראי שלכם למידע נוסף.',
	'payflowpro_gateway-response-23' => 'מספר כרטיס האשראי או תאריך התפוגה אינם נכונים.',
	'payflowpro_gateway-response-4' => 'הסכום שגוי.',
	'payflowpro_gateway-response-24' => 'תאריך תפוגת כרטיס האשראי שלך אינו נכון.',
	'payflowpro_gateway-response-112' => 'הכתובת או קוד הביטחון שלך אינם נכונים.',
	'payflowpro_gateway-response-125' => 'העברת הכספים מצידכם נדחתה על ידי השירותים למניעת ההונאה.',
	'payflowpro_gateway-response-125-2' => 'לא ניתן לאמת את כרטיס האשראי שלך. נא לוודא שכל הפרטים המופיעים להלן תואמים לפרופיל כרטיס האשראי שלך או פשוט לנסות כרטיס אחר. ניתן גם להשתמש באחת מ<a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">הדרכים האחות לתת</a> או ליצור אתנו קשר בכתובת <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. תודה לך על תמיכתך.',
	'payflowpro_gateway-response-default' => 'אירעה שגיאה בעיבוד הבקשה שלך.
נא לנסות שוב מאוחר יותר.',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'payflowprogateway' => 'अपने दान अभी करें',
	'payflowpro_gateway-desc' => 'पेपाल पेफ्लो प्रो क्रेडिट कार्ड प्रसंस्करण',
	'payflowpro_gateway-response-0' => 'आपके लेनदेन को मंजूरी दी गई है ।
आपको दान के लिए धन्यवाद!',
	'payflowpro_gateway-response-126' => 'आपके लेनदेन अनुमोदन के लिए है।',
	'payflowpro_gateway-response-12' => 'कृपया अधिक जानकारी के लिए अपने क्रेडिट कार्ड कंपनी से संपर्क करें।',
	'payflowpro_gateway-response-13' => 'आपके लेनदेन में आवाज प्राधिकरण की आवश्यकता है ।
कृपया आपके लेनदेन जारी रखने के लिए हमें संपर्क करें।',
	'payflowpro_gateway-response-114' => 'कृपया अधिक जानकारी के लिए अपने क्रेडिट कार्ड कंपनी से संपर्क करें।',
	'payflowpro_gateway-response-23' => 'आपके क्रेडिट कार्ड नंबर या समय सीमा समाप्ति दिनांक ग़लत है।',
	'payflowpro_gateway-response-4' => 'अमान्य राशि।',
	'payflowpro_gateway-response-24' => 'आपके क्रेडिट कार्ड नंबर या समय सीमा समाप्ति दिनांक ग़लत है।',
	'payflowpro_gateway-response-112' => 'आपके पते या CVV नंबर (सुरक्षा कोड) सही नहीं है।',
	'payflowpro_gateway-response-125' => 'आपके लेनदेन, फ़्रौड रोकथाम सेवाओं द्वारा अस्वीकार कर दिया गया है।',
	'payflowpro_gateway-response-default' => 'आपके लेनदेन प्रसंस्करण में कोई त्रुटि थी ।
कृपया बाद में पुन: प्रयास करें।',
);

/** Croatian (Hrvatski)
 * @author Herr Mlinka
 * @author Roberta F.
 * @author SpeedyGonsales
 * @author Tivek
 */
$messages['hr'] = array(
	'payflowprogateway' => 'Darujte sada',
	'payflowpro_gateway-desc' => 'PayPal PayFlow Pro obrada kreditnih kartica',
	'payflowpro_gateway-response-0' => 'Vaša transakcija je odobrena.
Hvala Vam za Vašu donaciju!',
	'payflowpro_gateway-response-126' => 'Vaša transakcija čeka odobrenje.',
	'payflowpro_gateway-response-126-2' => 'Neke informacije koje ste unijeli ne odgovaraju vašem profilu kreditne kartice, ili ste unijeli veoma veliki poklon. Za vašu sigurnost, vaša donacije je trenutno pod provjerom, obavijestiti ćemo Vas putem navedenog e-maila ako ne uspijemo izvršiti vašu donaciju. Molimo pošaljite e-mail na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> ako imate nekih pitanja. Hvala Vam!',
	'payflowpro_gateway-response-12' => 'Molimo obratite se vašoj tvrtki koja Vam je izdala kreditnu karticu za daljnje informacije.',
	'payflowpro_gateway-response-13' => 'Vaša transakcija zahtjeva glasovnu potvrdu.
Molimo kontaktirajte nas da biste mogli nastaviti vašu transakciju.',
	'payflowpro_gateway-response-114' => 'Molimo obratite se vašoj tvrtki koja Vam je izdala kreditnu karticu za daljnje informacije.',
	'payflowpro_gateway-response-23' => 'Broj vaše kreditne kartice ili datum isteka nisu ispravni.',
	'payflowpro_gateway-response-4' => 'Nevaljan iznos.',
	'payflowpro_gateway-response-24' => 'Broj vaše kreditne kartice ili datum isteka nisu ispravni.',
	'payflowpro_gateway-response-112' => 'Vaša adresa ili CVV broj (sigurnosni kod) nisu točni.',
	'payflowpro_gateway-response-125' => 'Vaša transakcija je odbijena od strane Službe za prevenciju zloupotreba.',
	'payflowpro_gateway-response-125-2' => 'Vaša kreditna kartica nije mogla biti provjerena. Molimo provjerite da li svi navedeni podaci odgovaraju profilu vaše kreditne kartice ili pokušajte drugu karticu. Također možete koristiti neki od naših <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">drugih načina za doniranje</a> ili nas kontaktirajte na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Hvala vam za vašu podršku.',
	'payflowpro_gateway-response-default' => 'Došlo je do pogreške u obradi vaše transakcije.
Molimo pokušajte kasnije.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'payflowprogateway' => 'Nětko darić',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro předźěłowanje kreditneje karty',
	'payflowpro_gateway-response-0' => 'Waša transakcija bu schwalena.
Dźakujemy so za waš dar!',
	'payflowpro_gateway-response-126' => 'Waša transakcija hišće na schwalenje čaka.',
	'payflowpro_gateway-response-126-2' => 'Někotre z informacijow, kotrež sće podał, njewotpowěduja profilej wašeje kreditneje karty abo sy jara wulki dar darił. Za wašu wěstotu so dar tuchwilu přepruwuje, a zdźělimy wam přez podatu e-mejlowu adresu, jeli njemóžemy waše darjenje dokónčić. Prošu pósćelće e-mejl na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>, jeli maće prašenja. Dźakujemy so!',
	'payflowpro_gateway-response-12' => 'Prošu stajće so ze swojim předewzaćom kreditneje karty za dalše informacije do zwiska.',
	'payflowpro_gateway-response-13' => 'Waša transakcija wužaduje hłosowu awtorizaciju.
Prošu stajće so z nami do zwiska, zo byšće ze swoju transakciju pokročował.',
	'payflowpro_gateway-response-114' => 'Prošu stajće so ze swojim předewzaćom kreditneje karty za dalše informacije do zwiska.',
	'payflowpro_gateway-response-23' => 'Čisło wašeje kreditneje karty abo datum spadnjenja je wopak.',
	'payflowpro_gateway-response-4' => 'Njepłaćiwa suma.',
	'payflowpro_gateway-response-24' => 'Čisło wašeje kreditneje karty abo datum spadnjenja je wopak.',
	'payflowpro_gateway-response-112' => 'Waša adresa abo CVV-čisło (wěstotny kod) je wopak.',
	'payflowpro_gateway-response-125' => 'Waša transakcija bu wot Fraud Prevention Services wotpokazana.',
	'payflowpro_gateway-response-125-2' => 'Waša kreditna karta njehodźi so přepruwować. Prošu pruwuj, hač wšě podate informacije profilej wašeje kreditneje karty wotpowěduja abo spytajće druhu kartu. Móžeće tež jednu z našich <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">druhich darjenskich móžnosćow</a> wužiwać abo so z nami přez <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> do zwiska stajić. Dźakujemy so za wašu podpěru.',
	'payflowpro_gateway-response-default' => 'Při předźěłowanju wašeje transakcije je zmylk wustupił.
Prošu spytajće pozdźišo hišće raz.',
);

/** Hungarian (Magyar)
 * @author BáthoryPéter
 * @author Dani
 * @author Dj
 * @author Glanthor Reviol
 * @author Misibacsi
 */
$messages['hu'] = array(
	'payflowprogateway' => 'Adakozz most',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro hitelkártya feldolgozása',
	'payflowpro_gateway-response-0' => 'A tranzakció elfogadva.
Köszönjük az adományt!',
	'payflowpro_gateway-response-126' => 'A tranzakciód elfogadásra vár.',
	'payflowpro_gateway-response-126-2' => 'Néhány megadott információ nem egyezik a kártyádéval, vagy túl nagy ajándékot szerettél volna adni. Saját biztonságod érdekében az adományodat ellenőrizni fogjuk, és a megadott e-mail címen értesítünk, ha nem sikerül végrehajtani. Kérdéseidet a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> címre küldheted el. Köszönjük!',
	'payflowpro_gateway-response-12' => 'További információért lépj kapcsolatba a bankkártyát kibocsátó céggel.',
	'payflowpro_gateway-response-13' => 'A tranzakcióhoz szóbeli megerősítés szükséges.
Kérünk vedd fel velünk a kapcsolatot a tranzakció folytatásához.',
	'payflowpro_gateway-response-114' => 'További információkért vedd fel a kapcsolatot a hitelkártya kibocsátójával.',
	'payflowpro_gateway-response-23' => 'A hitelkártyaszám vagy a lejárati dátum helytelen.',
	'payflowpro_gateway-response-4' => 'Érvénytelen összeg.',
	'payflowpro_gateway-response-24' => 'A bankkártyád száma vagy lejárati dátuma érvénytelen.',
	'payflowpro_gateway-response-112' => 'A cím vagy a CVV-szám (biztonsági kód) helytelen.',
	'payflowpro_gateway-response-125' => 'A tranzakciódat visszautasította a Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'A bankkártyád érvényességét nem sikerült ellenőrizni. Erősítsd meg, hogy az összes megadott információ megegyezik a bankkártyádéval, vagy próbálkozz egy másikkal. Használhatsz egy <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">másik módszert is az adományozásra</a>, vagy értesítsd minket a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> címen. Köszönjük a támogatásodat!',
	'payflowpro_gateway-response-default' => 'Hiba történt a tranzakció feldolgozásakor.
Később próbáld meg újra.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'payflowprogateway' => 'Face un donation ora',
	'payflowpro_gateway-desc' => 'Processamento per carta de credito PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Le transaction ha essite approbate.
Gratias pro tu donation!',
	'payflowpro_gateway-response-126' => 'Le transaction attende approbation.',
	'payflowpro_gateway-response-126-2' => 'Alcun information que tu forniva non correspondeva al profilo de tu carta de credito, o alteremente tu faceva un donation multo grande. Pro tu proprie securitate, tu donation es actualmente sub revision, e nos te notificara al adresse de e-mail fornite si nos non pote finalisar tu donation. Per favor invia e-mail a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> si tu ha questiones. Gratias!',
	'payflowpro_gateway-response-12' => 'Per favor contacta tu compania de carta de credito pro ulterior informationes.',
	'payflowpro_gateway-response-13' => 'Iste transaction require un autorisation vocal.
Per favor contacta nos pro continuar le transaction.',
	'payflowpro_gateway-response-114' => 'Per favor contacta tu compania de carta de credito pro ulterior information.',
	'payflowpro_gateway-response-23' => 'Le numero de carta de credito o le data de expiration es incorrecte.',
	'payflowpro_gateway-response-4' => 'Amonta invalide.',
	'payflowpro_gateway-response-24' => 'Le numero de carta de credito o le data de expiration es incorrecte.',
	'payflowpro_gateway-response-112' => 'Le adresse o le numero CVV (codice de securitate) es incorrecte.',
	'payflowpro_gateway-response-125' => 'Le transaction ha essite refusate per Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Le validation de tu carta de credito non ha succedite. Per favor verifica que tote le informationes fornite corresponde al profilo de tu carta de credito, o proba un altere carta. Tu pote tamben usar un de nostre <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">altere modos de donar</a> o contactar nos a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Gratias pro tu supporto.',
	'payflowpro_gateway-response-default' => 'Un error occurreva durante le tractamento de tu transaction.
Per favor reproba plus tarde.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author IvanLanin
 * @author Kenrick95
 */
$messages['id'] = array(
	'payflowprogateway' => 'Menyumbanglah sekarang',
	'payflowpro_gateway-desc' => 'Pemrosesan kartu credit PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Transaksi Anda telah disetujui.
Terima kasih atas sumbangan Anda!',
	'payflowpro_gateway-response-126' => 'Transaksi Anda menunggu persetujuan.',
	'payflowpro_gateway-response-126-2' => 'Beberapa informasi yang Anda berikan tidak sesuai dengan profil kartu kredit Anda atau Anda memberikan donasi yang terlalu besar. Untuk keamanan Anda, donasi Anda kini sedang ditinjau dan kami akan memberi tahu Anda melalui alamat surel yang diberikan jika kami tidak dapat merampungkan donasi Anda. Harap sureli <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> jika Anda punya pertanyaan. Terima kasih!',
	'payflowpro_gateway-response-12' => 'Silakan hubungi penyedia kartu kredit Anda untuk informasi lebih lanjut.',
	'payflowpro_gateway-response-13' => 'Transaksi Anda membutuhkan otorisasi suara.
Silakan hubungi kami untuk melanjutkan transaksi Anda.',
	'payflowpro_gateway-response-114' => 'Silakan hubungi penyedia kartu kredit Anda untuk informasi lebih lanjut.',
	'payflowpro_gateway-response-23' => 'Nomor atau tanggal kedaluwarsa kartu kredit Anda salah.',
	'payflowpro_gateway-response-4' => 'Nilai tidak benar.',
	'payflowpro_gateway-response-24' => 'Nomor atau tanggal kedaluwarsa kartu kredit Anda salah.',
	'payflowpro_gateway-response-112' => 'Alamat atau nomor CVV (kode keamanan) Anda salah.',
	'payflowpro_gateway-response-125' => 'Transaksi Anda telah ditolak oleh Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Kartu kredit Anda tidak dapat divalidasi. Harap verifikasikan bahwa semua informasi yang disediakan sesuai dengan profil kartu kredit, atau cobalah kartu yang berbeda. Anda juga dapat menggunakan salah satu <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/id">cara lain untuk menyumbang</a> atau hubungi kami di <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Terima kasih atas dukungan Anda.',
	'payflowpro_gateway-response-default' => 'Terjadi kesalahan dalam pemrosesan transaksi Anda.
Silakan coba lagi nanti.',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'payflowpro_gateway-response-4' => 'Ne-valida sumo.',
);

/** Italian (Italiano)
 * @author Aushulz
 * @author Beta16
 * @author Blaisorblade
 * @author F. Cosoleto
 * @author Karika
 */
$messages['it'] = array(
	'payflowprogateway' => 'Fai ora la tua donazione',
	'payflowpro_gateway-desc' => 'Gestione carta di credito PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'La transazione è stata approvata.
Grazie per la tua donazione!',
	'payflowpro_gateway-response-126' => 'La transazione è in attesa di approvazione.',
	'payflowpro_gateway-response-126-2' => 'Parte delle informazioni che sono state fornite non corrispondono al profilo della carta di credito usata, oppure è stata fatta una grande donazione. Per sicurezza, la donazione verrà esaminata e si riceverà una notifica via email, usando l\'indirizzo fornito, nel caso non sia possibile concluderla. Se desiderate contattarci, potete inviare una email a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Grazie!',
	'payflowpro_gateway-response-12' => 'Contatta la compagnia della tua carta di credito per ulteriori informazioni.',
	'payflowpro_gateway-response-13' => 'Questa transazione richiede una autorizzazione a voce.
Puoi contattarci per proseguire con la transazione.',
	'payflowpro_gateway-response-114' => 'Contatta la compagnia della tua carta di credito per ulteriori informazioni.',
	'payflowpro_gateway-response-23' => 'Il tuo numero di carta di credito o la data di scadenza non è corretto.',
	'payflowpro_gateway-response-4' => 'Importo non valido.',
	'payflowpro_gateway-response-24' => 'Il tuo numero di carta di credito o la data di scadenza non è corretto.',
	'payflowpro_gateway-response-112' => "L'indirizzo o il numero CVV (codice di sicurezza) non è corretto.",
	'payflowpro_gateway-response-125' => 'La transazione non è stata accettata dal Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'La convalida della carta di credito usata non è riuscita. Verificare che tutte le informazioni fornite corrispondano al profilo della propria carta di credito, o provare con una differente carta. È possibile usare anche <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">altri modi per donare</a> o contattarci all\'indirizzo <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Grazie per il tuo sostegno.',
	'payflowpro_gateway-response-default' => "Si è verificato un errore durante l'elaborazione della transazione.
Si prega di riprovare più tardi.",
);

/** Japanese (日本語)
 * @author Akaniji
 * @author Aphaia
 * @author Fryed-peach
 * @author Kanon und wikipedia
 * @author Ohgi
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'payflowprogateway' => '今すぐ寄付',
	'payflowpro_gateway-desc' => 'PayPalのPayflow Proによるクレジットカード処理',
	'payflowpro_gateway-response-0' => '取引は承認されました。
ご寄付をありがとうございます！',
	'payflowpro_gateway-response-126' => '取引は承認待ちです。',
	'payflowpro_gateway-response-126-2' => '入力された情報の中にあなたのクレジットカード情報と一致しないものがあるか、または金額が非常に大きなものになっています。安全のため、この寄付は現在審査中となっており、寄付を完了させることができない場合は、指定されたメールアドレスを通じて通知いたします。質問があれば <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> にメールをお願いします。ありがとうございました！',
	'payflowpro_gateway-response-12' => 'より詳しい情報はクレジットカード会社にお問い合わせください。',
	'payflowpro_gateway-response-13' => '取引には音声による認証が必要です。
取引を続けるには私たちにお問い合わせください。',
	'payflowpro_gateway-response-114' => 'より詳しい情報はクレジットカード会社にお問い合わせください。',
	'payflowpro_gateway-response-23' => 'クレジットカード番号あるいは有効期限が正しくありません。',
	'payflowpro_gateway-response-4' => '金額が無効です。',
	'payflowpro_gateway-response-24' => 'クレジットカード番号あるいは有効期限が正しくありません。',
	'payflowpro_gateway-response-112' => '住所あるいはカード照合番号（セキュリティコード）が正しくありません。',
	'payflowpro_gateway-response-125' => 'あなたの取引は詐欺防止サービスによって拒否されました。',
	'payflowpro_gateway-response-125-2' => 'あなたのクレジットカードの妥当性が確認できませんでした。入力した情報すべてがクレジットカードの情報と一致しているか検証するか、または別のカードを試してください。<a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">他の寄付方法</a>のどれかを利用したり、我々に <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> で連絡を取ることもできます。ご支援ありがとうございます。',
	'payflowpro_gateway-response-default' => 'お取引を処理している際にエラーがおきました。
後ほどまたお試しください。',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author David1010
 * @author Dawid Deutschland
 * @author Temuri rajavi
 */
$messages['ka'] = array(
	'payflowprogateway' => 'გაიღე  თანხა ახლავე',
	'payflowpro_gateway-response-23' => 'თქვენი საკრედიტო ბარათის ნომერი ან ვადის გასვლის თარიღი არასწორია.',
	'payflowpro_gateway-response-4' => 'არასწორი თანხა.',
	'payflowpro_gateway-response-24' => 'თქვენი საკრედიტო ბარათის ნომერი ან ვადის გასვლის თარიღი არასწორია.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'payflowprogateway' => 'ធ្វើការបរិច្ចាគនៅពេលនេះ',
	'payflowpro_gateway-response-0' => 'ការទូទាត់ទឹកប្រាស់របស់អ្នកត្រូវបានអនុម័តហើយ។

សូមថ្លែងអំណរគុណសំរាប់ការបរិច្ចាគរបស់អ្នក!',
	'payflowpro_gateway-response-126' => 'ការទូទាត់ទឹកប្រាក់របស់អ្នកកំពុងសូមការអនុម័ត។',
	'payflowpro_gateway-response-126-2' => 'ព័ត៌មានមួយចំនួនដែលអ្នកបានផ្ដល់មក មិនត្រូវគ្នានឹងព័ត៌មានរបស់ក្រេឌីតកាតរបស់អ្នកទេ ឬប្រហែលជាទឹកប្រាក់អ្នកអ្នកផ្ដល់មកមានចំនួនច្រើនពេក។ ដើម្បីសុវត្ថិភាព ការបរិច្ចាគរបស់អ្នកនឹងត្រូវពិនិត្យឡើងវិញ ហើយយើងនឹង​ផ្ដល់ដំណឹងទៅអ្នក​តាមរយៈអសយដ្ឋានអ៊ីមែលអ្នកដែលបានផ្ដល់មក ក្នុងករណីដែលយើងបានអាចសំរេចការបរិច្ចាគរបស់អ្នកបានរួចរាល់ទេ។ សូមអ៊ីមែលមកកាន់ <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> ប្រសិនបើអ្នកមានចំងល់ចង់សួរ។ សូមអរគុណ!',
	'payflowpro_gateway-response-12' => 'សូមទាក់ទងទៅក្រុមហ៊ុនក្រេឌីតកាតរបស់អ្នកសំរាប់ព័ត៌មានបន្ថែម។',
	'payflowpro_gateway-response-13' => 'ការទូទាត់ទឹកប្រាក់របស់អ្នកតំរូវអោយធ្វើការផ្ទៀតផ្ទាត់តាមសំលេង។

សូមទាក់ទងមកយើងខ្ញុំដើម្បីបន្តការទូទាត់នេះ។',
	'payflowpro_gateway-response-114' => 'សូមទាក់ទងទៅក្រុមហ៊ុនក្រេឌីតកាតរបស់អ្នកសំរាប់ព័ត៌មានបន្ថែម។',
	'payflowpro_gateway-response-23' => 'លេខឬកាលបរិច្ឆេទផុតកំណត់របស់ក្រេឌីតកាតរបស់អ្នកមិនត្រឹមត្រូវទេ។',
	'payflowpro_gateway-response-4' => 'ចំនួនទឹកប្រាក់មិនត្រឹមត្រូវ។',
	'payflowpro_gateway-response-24' => 'លេខឬកាលបរិច្ឆេទផុតកំណត់របស់ក្រេឌីតកាតរបស់អ្នកមិនត្រឹមត្រូវទេ។',
	'payflowpro_gateway-response-112' => 'អាសយដ្ឋានឬលេខ CVV (លេខសំងាត់) របស់អ្នកមិនត្រឹមត្រូវទេ។',
	'payflowpro_gateway-response-125' => 'ការទូទាត់ប្រាក់របស់អ្នកត្រូវបានបដិសេដដោយ Fraud Prevention Services។',
	'payflowpro_gateway-response-125-2' => 'ក្រេឌីតកាតរបស់អ្នកមិនអាចប្រើប្រាស់បានទេ។ សូមផ្ទៀងផ្ទាត់ថាព័ត៌មានដែលអ្នកបានផ្ដល់មក​ត្រូវគ្នានឹងព័ត៌មានរបស់ក្រេឌីតកាតរបស់អ្នក ឬសាកប្រើកាតផ្សេងពីនេះ។ អ្នកក៏អាចប្រើ<a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">វីធីផ្សេងទៀតក្នុងការធ្វើការបរិច្ចាគ</a> ឬទាក់ទងមកយើងខ្ញុំតាមរយៈ <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>។ សូមថ្លែងអំណរគុណដល់ការគាំទ្ររបស់អ្នក។',
	'payflowpro_gateway-response-default' => 'មានបញ្ហាក្នុងការធ្វើការទូទាត់ទឹកប្រាក់។

សូមសាកល្បងម្ដងទៀតនៅពេលក្រោយ។',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'payflowprogateway' => '지금 기부해주세요',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro 신용 카드 처리 시스템',
	'payflowpro_gateway-response-0' => '거래가 승인되었습니다.
당신의 기부에 감사드립니다!',
	'payflowpro_gateway-response-126' => '거래 승인을 기다리고 있습니다.',
	'payflowpro_gateway-response-126-2' => '입력하신 정보 중 일부가 당신의 신용 카드 정보와 일치하지 않거나 너무 많은 액수를 입력하였습니다. 당신의 안전을 위해 당신의 기부를 심사히고 있으며 기부를 완료하지 못할 경우 입력하신 이메일 주소로 알려 드릴 것입니다. 질문이 있으시다면 <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>로 이메일을 보내주세요. 감사합니다!',
	'payflowpro_gateway-response-12' => '자세한 정보를 얻으시려면 신용카드 회사에 문의하십시오.',
	'payflowpro_gateway-response-13' => '당신의 거래는 음성 확인을 필요로 합니다.
거래를 계속하려면 연락해주십시오.',
	'payflowpro_gateway-response-114' => '자세한 정보를 얻으시려면 신용카드 회사에 문의하십시오.',
	'payflowpro_gateway-response-23' => '당신의 신용 카드 번호나 유효기간이 잘못되었습니다.',
	'payflowpro_gateway-response-4' => '금액이 잘못되었습니다.',
	'payflowpro_gateway-response-24' => '당신의 신용 카드 번호나 유효기간이 잘못되었습니다.',
	'payflowpro_gateway-response-112' => '당신의 주소 또는 CVV 번호(보안 코드)가 잘못되었습니다.',
	'payflowpro_gateway-response-125' => '당신의 거래가 사기 방지 시스템에 의해 거부되었습니다.',
	'payflowpro_gateway-response-125-2' => '당신의 신용 카드를 확인할 수 없습니다. 모든 정보가 신용 카드 정보와 일치하는지 확인하거나 다른 카드를 이용해 주십시오. <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">다른 방법으로 기부</a>할 수도 있으며 <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>로 문의할 수도 있습니다. 당신의 후원에 감사드립니다.',
	'payflowpro_gateway-response-default' => '거래를 처리하는 중에 오류가 발생했습니다.
잠시 후에 다시 시도해주세요.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'payflowprogateway' => 'Donn jäz jävve',
	'payflowpro_gateway-desc' => 'Met <i lang="en">PayPal Payflow Pro</i> vun Kredditkaate afhallde.',
	'payflowpro_gateway-response-0' => 'Ding Zahlung es beschtäätesch woode.
Mer donn uns bedangke för Ding Schpänd!',
	'payflowpro_gateway-response-126' => 'Ding Zahlung moß noch beschtäätesch wääde.',
	'payflowpro_gateway-response-126-2' => 'Ene Aandeil vun dämm, wat De aanjejovve häß, paß nit met Dinge Kreditkaate-Daate zosamme, udder Do häs en unjewöhlesch jruuße Spende jemaat. Dröm es för Ding eije Sescherheit, Ding Spende em Momang en der Pröövung. Mer lohße Desch wesse, falls mer Ding Spend nit annämme künne udder dörve, dann kriß De en <i lang="en">e-mail</i> aan Ding aanjejovve Addräß. Donn selver en <i lang="en">e-mail</i> aan <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> schecke, wann Der jät unklohr es. Häzlijjen Dank!',
	'payflowpro_gateway-response-12' => 'Donn Desch aan Ding Kreddittkaate-Fermma wände, öm mieh doh drövver ze wesse ze krijje.',
	'payflowpro_gateway-response-13' => 'Ding Zahlung moß met Dinge Schtemm beschtäätesch wääde.
Donn Desch aan uns wände, öm heh met wigger ze maache.',
	'payflowpro_gateway-response-114' => 'Donn Desch aan Ding Kreddittkaate-Fermma wände, öm mieh doh drövver ze wesse ze krijje.',
	'payflowpro_gateway-response-23' => 'De Nommer vun Dinge Kreddittkaat udder et Dattum, wann se ußleuf, es verkeeht.',
	'payflowpro_gateway-response-4' => 'Onjöltijje Bedraach.',
	'payflowpro_gateway-response-24' => 'De Nommer vun Dinge Kreddittkaat udder et Dattum, wann se ußleuf, es verkeeht.',
	'payflowpro_gateway-response-112' => 'Ding Addräß udder de <i lang="en">CVV</i> Nommer (Sescherheitskood) vun Dinge Kreddittkaat, es verkeeht.',
	'payflowpro_gateway-response-125' => 'Ding Zahlung es afjelehnt woode, vun einem vun dä Deenste, di Betuppereije verhendere well.',
	'payflowpro_gateway-response-125-2' => 'Ding Kreditkaat kunnt nit beschtäätesch wääde. Bes esu joot un donn all de Enfommazjuhne nohluure, of dat, wat De aanjejovve has och esu op Dinge Kaat dropschteiht un schtemmp, udder versöhk et met en ander Kaat. Do kanns och eine vun unser <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">ander Müjjeleschkeijte ze jävve</a>, udder donn uns en e-mail schriive noh <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Mer bedanke uns för Ding Ongerschtözung.',
	'payflowpro_gateway-response-default' => 'Et es ene Fähler opjetrodde beim Övverdraare udder Affärbeide vu Dinge Zahlung.
Versöhk et schpääder noch ens.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'payflowprogateway' => 'Maacht Ären Don elo',
	'payflowpro_gateway-desc' => 'Behandele vun der Kreditkaart PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Är Transaktioun gouf kzeptéiert.
Merci fir Ären Don!',
	'payflowpro_gateway-response-126' => 'Är Transaktiun muss nach akzeptéiert ginn.',
	'payflowpro_gateway-response-126-2' => 'En Deel vun den Informatiounen déi Dir uginn hutt stëmmt net mat dem Profil vun Ärer Kreditkaart iwwereneen, oder Dir hutt e ganz groussen Don gemaach. Fir Är eege Sécherheet gëtt Ären Don elo iwwerpréift a mir informéieren Iech iwwer d\'E-Mailadress déi Dir uginn hutt wa mir Ären Don net ofschléisse kënnen. Schéckt eis w.e.g. e Mail op <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> wann Dir Froen hutt. Merci!',
	'payflowpro_gateway-response-12' => "Kontaktéiert d'Firma vun Ärer Krditkaart fir weider Informatiounen.",
	'payflowpro_gateway-response-13' => 'Är Transaktioun muss duerch STëmmenerkennung autoriséiert ginn.
Kontaktéiert eis w.e.g. fir mat Ärer Transaktioun weiderzefueren.',
	'payflowpro_gateway-response-114' => "Kontaktéiert d'Firma vun Ärer Kreditkaart fir méi Informatiounen.",
	'payflowpro_gateway-response-23' => "D'Nummer vun Ärer Kreditkaart oder den Datum wou d'Kaart ofleeft si falsch.",
	'payflowpro_gateway-response-4' => 'Net valabele Betrag.',
	'payflowpro_gateway-response-24' => "D'Nummer vun Ärer Kreditkaart oder den Datum wou d'Kaart ofleeft si falsch.",
	'payflowpro_gateway-response-112' => 'Är Adress oder CVV-Nummer (Sécherheetscode) ass net richteg.',
	'payflowpro_gateway-response-125' => "Är Transaktioun gouf net vun de Servicer, déi sech ëm d'Verhënnerung vun der Fraude bekëmmeren, akzeptéiert.",
	'payflowpro_gateway-response-125-2' => 'Är Kreditkaart konnt net validéiert ginn. Kuckt w.e.g. no ob all déi Informatiounen déi Dir uginn hutt mat dem Profil vun Ärer Kreditkaart iwwereneestëmmt oder probéiert mat enger anerer Kaart. Dir kënnt och op eng vun eisen anere <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">Manéiere fir ze spenden</a> benotzen oder eis iwwer <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> kontaktéieren. Merci fir Är Ënnerstëtzung.',
	'payflowpro_gateway-response-default' => 'Et gouf e Feeler beim Verschaffe vun Ärer Transaktioun.
Probéiert et w.e.g. spéider nach eng Kéier.',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'payflowprogateway' => 'Steun Wikimedia',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'payflowprogateway' => 'Atlikite aukojimą',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro kredito kortelė apdorojama',
	'payflowpro_gateway-response-0' => 'Mokėjimas patvirtintas. 
Dėkojame už aukojimą!',
	'payflowpro_gateway-response-126' => 'Jūsų mokėjimas laukia patvirtinimo.',
	'payflowpro_gateway-response-126-2' => 'Dalis informacijos, kurią nurodėte, neatitinka kredito kortelės profilio, arba pasirinkote aukoti per didelę sumą. Dėl Jūsų pačio saugumo, aukojimas šiuo metu yra peržiūrimas, mes Jus informuosime jūsų pateiktu el. paštu, jei negalime užbaigti mokėjimo. Jei turite klausimų, prašome susisiekti su <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Ačiū!',
	'payflowpro_gateway-response-12' => 'Prašome susisiekti su kredito kortelę išdavusia įmone dėl papildomos informacijos.',
	'payflowpro_gateway-response-13' => 'Jūsų operacija reikalauja balso patvirtinimo.
Prašome susisiekti su mumis, norėdami tęsti savo mokėjimą.',
	'payflowpro_gateway-response-114' => 'Prašome susisiekti su kredito kortelę išdavusia įmone dėl papildomos informacijos.',
	'payflowpro_gateway-response-23' => 'Jūsų kreditinės kortelės numeris arba galiojimo pabaigos data yra neteisinga.',
	'payflowpro_gateway-response-4' => 'Neleistina suma.',
	'payflowpro_gateway-response-24' => 'Jūsų kreditinės kortelės numeris arba galiojimo pabaigos data yra neteisinga.',
	'payflowpro_gateway-response-112' => 'Jūsų adresas arba CVV numeris (saugos kodas) yra neteisingas.',
	'payflowpro_gateway-response-125' => 'Mokėjimas buvo atmestas Sukčiavimo Prevencijos Tarnybos.',
	'payflowpro_gateway-response-125-2' => 'Jūsų kreditinė kortelė negali būti patvirtinta. Prašome įsitikinti, kad visi pateikti duomenys sutampa su Jūsų kreditinės kortelės profiliu, arba bandykite naudoti kitą kortelę. Taip pat galite naudoti vieną iš mūsų pateiktų<a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">kitų būdų paaukoti</a> arba susisiekti su mumis el. paštu <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Dėkojame už Jūsų supratingumą.',
	'payflowpro_gateway-response-default' => 'Įvyko klaida apdorojant mokėjimą. 
Pabandykite dar kartą vėliau.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'payflowprogateway' => 'Дарувајте сега',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro обработка на податоците за плаќање со кредитна картичка',
	'payflowpro_gateway-response-0' => 'Вашето плаќање е одобрено.
Ви благодариме што дарувавте!',
	'payflowpro_gateway-response-126' => 'Вашето плаќање чека одобрение.',
	'payflowpro_gateway-response-126-2' => 'Некои од податоците кои ги наведовте не се совпаѓаат со профилот на вашата кредитна картичка, или пак сте дариле многу голема сума. За ваша безбедност, дарувањето моментално се разгледува, и ако не можеме да го обработиме, ќе ве контактираме по наведената е-пошта.
Ако имате прашања, обратете ни се на <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Ви благодариме!',
	'payflowpro_gateway-response-12' => 'Контактирајте го издавачот на кредитната картичка за повеќе информации.',
	'payflowpro_gateway-response-13' => 'Вашето плаќање бара гласовно овластување.
Контактирајте нè за да продолжите со плаќањето.',
	'payflowpro_gateway-response-114' => 'Контактирајте го издавачот на кредитната картичка за повеќе информации.',
	'payflowpro_gateway-response-23' => 'Бројот на кредитната картичка или датумот на истекување е погрешен.',
	'payflowpro_gateway-response-4' => 'Неважечки износ.',
	'payflowpro_gateway-response-24' => 'Бројот на кредитната картичка или датумот на истекување е погрешен.',
	'payflowpro_gateway-response-112' => 'Вашата адреса или CVV-број (сигурносен код) е неправилен.',
	'payflowpro_gateway-response-125' => 'Вашето плаќање е одбиено од страна на Службата за спречување на финансиски криминал (Fraud Prevention Services)',
	'payflowpro_gateway-response-125-2' => 'Вашата кредитна картичка не можеше да се потврди. Проверете дали сите доставени податоци се совпаѓаат со профилот на вашата кредитна картичка, или пак обидете се со друга картичка. Можете и да искористите еден од <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">другите начини на дарување</a> или да нè исконтактирате на <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Ви благодариме за поддршката.',
	'payflowpro_gateway-response-default' => 'Настана грешка при обработката на плаќањето.
Обидете се повторно.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Vssun
 */
$messages['ml'] = array(
	'payflowprogateway' => 'ഇപ്പോൾ തന്നെ സംഭാവന നൽകുക',
	'payflowpro_gateway-desc' => 'പേപാൽ പേഫ്ലോ പ്രോ ക്രെഡിറ്റ് കാർഡ് ഉപയോഗിച്ചുള്ള പണമിടപാട്',
	'payflowpro_gateway-response-0' => 'താങ്കളുടെ ഇടപാട് അംഗീകരിക്കപ്പെട്ടിരിക്കുന്നു.
താങ്കളുടെ സംഭാവനയ്ക്ക് നന്ദി!',
	'payflowpro_gateway-response-126' => 'താങ്കളുടെ ഇടപാടിനുള്ള അംഗീകാരം അനിശ്ചിതത്വത്തിലാണ്.',
	'payflowpro_gateway-response-126-2' => 'താങ്കൾ നൽകിയ ചില വിവരങ്ങൾ താങ്കളുടെ ക്രെഡിറ്റ് കാർഡിലെ വിവരങ്ങളുമായി ഒത്തുപോകുന്നില്ല, അല്ലെങ്കിൽ താങ്കൾ വളരെ വലിയൊരു സംഭാവനയാണ് ചെയ്തിരിക്കുന്നത്. താങ്കളുടെ സുരക്ഷയ്ക്കായി, താങ്കളുടെ സംഭാവന പരിശോധിച്ചുകൊണ്ടിരിക്കുന്നു, താങ്കളുടെ സംഭാവന സ്വീകരിക്കാൻ സാധിക്കുകയില്ലെങ്കിൽ താങ്കൾ നൽകിയ ഇമെയിൽ വിലാസം വഴി താങ്കളെ അക്കാര്യം അറിയിക്കുന്നതാണ്. താങ്കൾക്കെന്തെങ്കിലും ചോദിക്കാനുണ്ടെങ്കിൽ ദയവായി <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> എന്ന വിലാസത്തിൽ ചോദിക്കുക. നന്ദി!',
	'payflowpro_gateway-response-12' => 'ദയവായി കൂടുതൽ വിവരങ്ങൾക്കായി താങ്കളുടെ ക്രെഡിറ്റ് കാർഡ് കമ്പനിയുമായി ബന്ധപ്പെടുക.',
	'payflowpro_gateway-response-13' => 'ഈ ഇടപാടിനു താങ്കളുടെ ശബ്ദത്തിലുള്ള സാധൂകരണമാവശ്യമാണ്.
ദയവായി ഇടപാട് പൂർത്തീകരിക്കാൻ ഞങ്ങളെ ബന്ധപ്പെടുക.',
	'payflowpro_gateway-response-114' => 'ദയവായി കൂടുതൽ വിവരങ്ങൾക്കായി താങ്കളുടെ ക്രെഡിറ്റ് കാർഡ് കമ്പനിയുമായി ബന്ധപ്പെടുക.',
	'payflowpro_gateway-response-23' => 'താങ്കളുടെ ക്രെഡിറ്റ് കാർഡ് നമ്പരോ അതിന്റെ കാലാവധി തീരുന്ന തീയതിയോ തെറ്റാണ്.',
	'payflowpro_gateway-response-4' => 'തുക അസാധുവാണ്.',
	'payflowpro_gateway-response-24' => 'താങ്കളുടെ ക്രെഡിറ്റ് കാർഡ് നമ്പരോ അതിന്റെ കാലാവധി തീരുന്ന തീയതിയോ തെറ്റാണ്.',
	'payflowpro_gateway-response-112' => 'താങ്കളുടെ വിലാസമോ സി.വി.വി. സംഖ്യയോ (സുരക്ഷാ കോഡ്) തെറ്റാണ്.',
	'payflowpro_gateway-response-125' => 'കബളിപ്പിക്കൽ തടയൽ സൗകര്യം ഉപയോഗിച്ച് താങ്കളുടെ ഇടപാട് നിരാകരിച്ചിരിക്കുന്നു.',
	'payflowpro_gateway-response-125-2' => 'താങ്കളുടെ ക്രെഡിറ്റ് കാർഡിന്റെ സാധുത തെളിയിക്കാനായില്ല. ദയവായി താങ്കൾ നൽകിയ വിവരങ്ങൾ താങ്കളുടെ ക്രെഡിറ്റ് കാർഡിലേതുമായി ഒത്തുപോകുന്നുണ്ടോയെന്നു നോക്കുക, അല്ലെങ്കിൽ മറ്റൊരു കാർഡ് ഉപയോഗിക്കുക. താങ്കൾക്ക് ഇതേ കാര്യത്തിന് <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">മറ്റു മാർഗ്ഗങ്ങൾ</a> ഉപയോഗിക്കാവുന്നതാണ് അല്ലെങ്കിൽ ഞങ്ങളെ ബന്ധപ്പെടുക <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. താങ്കളുടെ പിന്തുണയ്ക്ക് നന്ദി.',
	'payflowpro_gateway-response-default' => 'താങ്കളുടെ ഇടപാട് കൈകാര്യം ചെയ്തുകൊണ്ടിരിക്കെ ഒരു പിഴവുണ്ടായിരിക്കുന്നു.
ദയവായി അൽപ്പസമയത്തിനു ശേഷം ശ്രമിക്കുക.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Diagramma Della Verita
 */
$messages['ms'] = array(
	'payflowprogateway' => 'Derma sekarang',
	'payflowpro_gateway-desc' => 'Kad kredit anda sedang diproses melalui PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Transaksi anda berjaya dilakukan. 
Terima kasih atas sumbangan anda!',
	'payflowpro_gateway-response-126' => 'Transaksi anda sedang diproses.',
	'payflowpro_gateway-response-126-2' => 'Maklumat yang anda berikan tidak sama dengan profil kad kredit anda atau jumlah derma yang anda berikan terlalu besar. Untuk tujuan keselamatan, derma anda akan diteliti dan kami akan memaklumkan kepada anda melalui alamat e-mel yang diberikan sekiranya derma anda tidak dapat diproses. Sila hantarkan e-mel kepada <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> sekiranya anda mempunyai sebarang persoalan. Terima kasih!',
	'payflowpro_gateway-response-12' => 'Sila hubungi syarikat kad kredit anda untuk maklumat lanjut.',
	'payflowpro_gateway-response-13' => 'Transaksi anda memerlukan pengesahan suara. 
Sila hubungi kami untuk meneruskan transaksi anda.',
	'payflowpro_gateway-response-114' => 'Sila hubungi syarikat kad kredit anda untuk maklumat lebih lanjut.',
	'payflowpro_gateway-response-23' => 'Nombor kad kredit atau tarikh luput yang dimasukkan tidak tepat.',
	'payflowpro_gateway-response-4' => 'Jumlah tidak sah.',
	'payflowpro_gateway-response-24' => 'Nombor kad kredit atau tarikh luput tidak tepat.',
	'payflowpro_gateway-response-112' => 'Alamat anda atau nombor CVV (kod keselamatan) tidak tepat.',
	'payflowpro_gateway-response-125' => "Transaksi anda telah ditolak oleh ''Fraud Prevention Services''.",
	'payflowpro_gateway-response-125-2' => 'Kad kerdit anda tidak dapat dikenal pasti. Sila pastikan maklumat yang anda berikan sama seperti profil kad kredit anda atau cuba gunakan kad yang lain. Anda juga boleh <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">menderma menggunakan cara lain</a> atau menghubungi kami melalui <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Terima kasih atas sokongan anda.',
	'payflowpro_gateway-response-default' => 'Terdapat masalah dalam memproses transaksi anda. 
Sila cuba sebentar lagi.',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'payflowprogateway' => 'Agħmel id-donazzjoni tiegħek issa',
	'payflowpro_gateway-response-0' => 'It-transazzjoni tiegħek ġiet approvata.
Grazzi tad-donazzjoni tiegħek!',
	'payflowpro_gateway-response-126' => 'It-transazzjoni tiegħek qegħda tistenna li tiġi approvata.',
	'payflowpro_gateway-response-126-2' => 'Ċerti dettalji li tajt ma qablux mal-profil tal-karta tal-kreditu tiegħek, jew inkella għamilt donazzjoni kbira. Għas-sigurtà tiegħek, id-donazzjoni tiegħek qegħda tiġi reviżjonata, u aħna ngħarrfuk permezz tal-indirizz elettroniku li provdejt f\'każ li t-transazzjoni ma tistax titkompla. Jekk għandek xi mistoqsijiet, ibgħatilna ittra-e fuq <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Grazzi!',
	'payflowpro_gateway-response-12' => 'Jekk jogħġbok ikkuntattja lill-kumpanija tal-karta tal-kreditu tiegħek għal aktar informazzjoni.',
	'payflowpro_gateway-response-13' => 'It-transazzjoni tiegħek għandha bżonn awtorizzazzjoni bil-vuċi.
Jekk jogħġbok ikkuntatjana sabiex tkompli t-transazzjoni tiegħek.',
	'payflowpro_gateway-response-114' => 'Jekk jogħġbok ikkuntattja lill-kumpanija tal-karta tal-kreditu tiegħek għal aktar informazzjoni.',
	'payflowpro_gateway-response-23' => "In-numru tal-karta tal-kreditu tiegħek jew id-data ta' skadenza hija żbaljata.",
	'payflowpro_gateway-response-4' => 'Ammont invalidu.',
	'payflowpro_gateway-response-24' => "In-numru tal-karta tal-kreditu tiegħek jew id-data ta' skadenza hija żbaljata.",
	'payflowpro_gateway-response-112' => "L-indirizz tiegħek jew in-numru CVV (kodiċi ta' sigurtà) huwa żbaljat.",
	'payflowpro_gateway-response-125' => 'It-transazzjoni tiegħek ġiet rifjutata mill-Fraud Prevention Services.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Finnrind
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 * @author Sjurhamre
 */
$messages['nb'] = array(
	'payflowprogateway' => 'Gi nå',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro kredittkortbehandling',
	'payflowpro_gateway-response-0' => 'Transaksjonen din har blitt godkjent.
Takk for din gave!',
	'payflowpro_gateway-response-126' => 'Transaksjonen din venter på godkjenning.',
	'payflowpro_gateway-response-126-2' => 'Noen av opplysningene du oppga passet ikke med kredittkortopplysningene, eller du ga en veldig stor gave. For din egen sikkerhet gjennomgås donasjonen din og vi vil varlse deg gjennom den oppgitte e-postadressen om vi ikke kan fullføre donasjonen din. Vennligst send en e-post til <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> om du har noen spørsmål. Takk!',
	'payflowpro_gateway-response-12' => 'Kontakt kredittkortselskapet ditt for mer informasjon.',
	'payflowpro_gateway-response-13' => 'Transaksjonen din krever stemmeautorisasjon.
Kontakt oss for å fortsette din transaksjon.',
	'payflowpro_gateway-response-114' => 'Vennligst kontakt kredittkortselskapet ditt for mer informasjon.',
	'payflowpro_gateway-response-23' => 'Ditt kredittkortnummer eller utløpsdato er ikke korrekt.',
	'payflowpro_gateway-response-4' => 'Ugyldig beløp.',
	'payflowpro_gateway-response-24' => 'Ditt kredittkortnummer eller utløpsdato er ikke korrekt.',
	'payflowpro_gateway-response-112' => 'Din adresse eller CVV nummer (sikkerhetskode) er ikke korrekt.',
	'payflowpro_gateway-response-125' => 'Din transaksjon har blitt avvist av Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Kredittkortet ditt kunne i godkjennes. Vennligst sjekk at alle opplysningene stemmer overens med dine kredittkortopplysninger, eller prøv et annet kort. Du kan også bruke en av våre <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">alternative måter</a> eller kontakt oss på <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Takk for din støtte.',
	'payflowpro_gateway-response-default' => 'Det oppsto en feil under behandlingen av din transaksjon.
Vennligst prøv igjen senere.',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Krinkle
 * @author Servien
 */
$messages['nds-nl'] = array(
	'payflowprogateway' => 'Noen geld schenken',
	'payflowpro_gateway-desc' => 'Kredietkaortverwarking via PayPal PayFlow Pro',
	'payflowpro_gateway-response-0' => 'Joew storting is goedekeurd!
Bedankt veur de schenking!',
	'payflowpro_gateway-response-126' => 'Joew storting wacht op goedkeuring.',
	'payflowpro_gateway-response-126-2' => "Der is wat informasie da'j op-egeven hebben, en niet t zelfde is as op t prefiel van joew kredietkaorte, of je hebben eprobeerd um n alderbarstens grote schenking te doon. Veur joew eigen veiligheid wörden disse schenking op dit moment nao-ekeken en wie laoten t joe weten via t op-egeven netpostadres a'w de schenking niet kunnen verwarken. Neem kontakt op via <a href=\"mailto:donate@wikimedia.org\">donate@wikimedia.org</a> a'j nog vragen hebben. Bedank!",
	'payflowpro_gateway-response-12' => 'Neem kontakt op mit de kredietkaortmaotschappieje veur meer informasie.',
	'payflowpro_gateway-response-13' => "Veur disse storting mö'j mondelinge toestemming geven.
Neem kontakt op mit ons veur de storting.",
	'payflowpro_gateway-response-114' => 'Neem kontakt op mit de kredietkaortmaotschappieje veur meer informasie.',
	'payflowpro_gateway-response-23' => 't Nummer van disse kredietkaorte is vervuilen of verkeerd.',
	'payflowpro_gateway-response-4' => 'Ongeldig bedrag.',
	'payflowpro_gateway-response-24' => 't Nummer van de kredietkaorte is vervuilen of verkeerd.',
	'payflowpro_gateway-response-112' => 'Joew adres of CVV-nummer (beveiligingskode) is verkeerd.',
	'payflowpro_gateway-response-125' => 'Joew storting is aofewezen deur Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Der kon niet bevestigd wörden dat joew kredietkaorte geldig is. Kiek effen nao of alle gegevens die\'j op-egeven hebben t zelfde bin as op t kredietkaortprefiel, of probeer n schenking te doon mit n aandere kredietkaorte, a\'j dat hebben. Je kunnen oek op <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">aandere menieren geld schenken</a> of kontakt mit ons opnemen via <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Bedank veur joe steun.',
	'payflowpro_gateway-response-default' => 'Der gung wat fout mit de storting.
Probeer t laoter weer.',
);

/** Nepali (नेपाली)
 * @author Bhawani Gautam
 * @author Bhawani Gautam Rhk
 */
$messages['ne'] = array(
	'payflowprogateway' => 'तपाईंको दान अहिले नैं गर्नुहोस्।',
);

/** Dutch (Nederlands)
 * @author Als-Holder
 * @author Mihxil
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'payflowprogateway' => 'Doneer nu',
	'payflowpro_gateway-desc' => 'Creditcardverwerking via PayPal PayFlow Pro',
	'payflowpro_gateway-response-0' => 'Uw transactie is goedgekeurd.
Dank u wel voor uw donatie!',
	'payflowpro_gateway-response-126' => 'Uw transactie wacht op goedkeuring.',
	'payflowpro_gateway-response-126-2' => 'Enige informatie die u hebt opgegeven komt niet overeen met het profiel van uw creditcard, of u hebt een zeer grote donatie geprobeerd te maken. Voor uw eigen veiligheid wordt uw donatie op dit moment gecontroleerd en we stellen u via het opgegeven e-mailadres op de hoogte als we uw donatie niet kunnen afronden. Neem alstublieft contact op via <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> als u vragen hebt. Dank u wel!',
	'payflowpro_gateway-response-12' => 'Neem alstublieft contact op met uw creditcardmaatschappij voor meer informatie.',
	'payflowpro_gateway-response-13' => 'Voor uw transactie is mondelinge toestemming vereist.
Neem alstublieft contact met ons op voor uw transactie.',
	'payflowpro_gateway-response-114' => 'Neem alstublieft contact op met uw creditcardmaatschappij voor meer informatie.',
	'payflowpro_gateway-response-23' => 'Het opgegeven creditcardnummer of de vervaldatum is onjuist.',
	'payflowpro_gateway-response-4' => 'Ongeldig bedrag.',
	'payflowpro_gateway-response-24' => 'Het opgegeven creditcardnummer of de vervaldatum is onjuist.',
	'payflowpro_gateway-response-112' => 'Uw adres of CVV-nummer (veiligheidscode) is onjuist.',
	'payflowpro_gateway-response-125' => 'Uw transactie is geweigers door Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Het was niet mogelijk uw creditcard te valideren. Controleer alstublieft of alle gegevens die u hebt opgegeven overeenkomen met uw creditkaartprofiel, of probeer te doneren met een andere creditkaart. U kunt ook op <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">andere wijzen doneren</a> of contact met ons opnemen via <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Dank u wel voor uw steun.',
	'payflowpro_gateway-response-default' => 'Er is een fout opgetreden bij het verwerken van uw transactie.
Probeer het later nog een keer.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'payflowprogateway' => 'Støtt Wikimedia',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro kredittkorthandsaming',
	'payflowpro_gateway-response-0' => 'Overføringa di har vorte godkjend.
Takk for gåva di!',
	'payflowpro_gateway-response-126' => 'Pengeoverføringa di ventar på godkjenning',
	'payflowpro_gateway-response-23' => 'Kredittkortnummeret ditt eller utløpsdatoen er ikkje rett.',
	'payflowpro_gateway-response-125' => 'Overføringa di har vorte avvist av tenesta som skal hindra svindel.',
);

/** Occitan (Occitan)
 * @author Boulaur
 * @author Cedric31
 */
$messages['oc'] = array(
	'payflowprogateway' => 'Sostenètz Wikimedia',
	'payflowpro_gateway-desc' => 'Tractament par carta de credit PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Vòstre transaccion es estada aprovada.
Mercés per vòstre don !',
	'payflowpro_gateway-response-126' => "Vòstra transaccion es en cors d'aprovacion.",
	'payflowpro_gateway-response-126-2' => "D'unas informacions qu'avètz provesidas correspondon pas al perfil de vòstra carta bancària, o alara avètz fach un don fòrça elevat. Per vòstra pròpria seguretat, vòstre don es actualament en cors de verificacion, e vos avisarem via l'adreça de corrièl qu'avètz provesida se capitam pas finalizar vòstre don. Per tota question, trantalhetz pas a adreçar un corrièl a <a href=\"mailto:donate@wikimedia.org\">donate@wikimedia.org</a>. Mercés !",
	'payflowpro_gateway-response-12' => "Contactatz lo provesidor de vòstra carta de credit per mai d'entresenhas.",
	'payflowpro_gateway-response-13' => 'Vòstra transaccion requerís una autorizacion vocala.
Contactatz-nos per perseguir vòstra transaccion.',
	'payflowpro_gateway-response-114' => "Contactatz lo provesidor de vòstra carta de credit per mai d'entresenhas.",
	'payflowpro_gateway-response-23' => "La data d'expiracion de vòstre numèro de carta de credit es incorrècte.",
	'payflowpro_gateway-response-4' => 'Montant invalid.',
	'payflowpro_gateway-response-24' => "Vòstre numèro de carta de credit o data d'expiracion es incorrècte(a).",
	'payflowpro_gateway-response-112' => 'Vòstra adreça o numèro CVV (còde de seguretat) es incorrècte(a).',
	'payflowpro_gateway-response-125' => 'Vòstra transaccion es estada refusada pels Servicis de prevencion de las fraudas.',
	'payflowpro_gateway-response-125-2' => 'Vòstra carta bancària a pas pogut èsser validada. Verificatz que las informacions provesidas correspondon al perfil de vòstra carta bancària, o ensajatz amb una autra carta. Podètz tanben utilizar d\'<a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">autras solucions per far un don</a> o nos contactar a l\'adreça <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Vos mercejam per vòstre sosten.',
	'payflowpro_gateway-response-default' => "Una error s'es producha al moment del tractament de vòstra transaccion.
Tornatz ensajar mai tard.",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'payflowpro_gateway-response-4' => 'ଭୁଲ ପରିମାଣ ।',
);

/** Polish (Polski)
 * @author Maire
 * @author Mikołka
 * @author Odder
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'payflowprogateway' => 'Przekaż darowiznę już teraz',
	'payflowpro_gateway-desc' => 'PayPal obsługa kart kredytowych Payflow Pro',
	'payflowpro_gateway-response-0' => 'Transakcja została przeprowadzona.
Dziękujemy za wsparcie!',
	'payflowpro_gateway-response-126' => 'Transakcja oczekuje na potwierdzenie.',
	'payflowpro_gateway-response-126-2' => 'Część z podanych informacji była niezgodna z profilem karty kredytowej lub kwota darowizny była bardzo wysoka. Dla Twojego bezpieczeństwa, transakcja zostanie dodatkowo sprawdzona. Poinformujemy Cię pod podanym przez Ciebie adresem e‐mail, jeśli darowizna nie zostanie wykonana. Swoje pytania możesz kierować pod adres <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Dziękujemy.',
	'payflowpro_gateway-response-12' => 'Skontaktuj się z wystawcą karty aby uzyskać dokładniejszą informację.',
	'payflowpro_gateway-response-13' => 'Transakcja wymaga autoryzacji głosowej.
Skontaktuj się z nami w celu kontynuowania transakcji.',
	'payflowpro_gateway-response-114' => 'Skontaktuj się z wystawcą karty, aby uzyskać szczegółowe informacje.',
	'payflowpro_gateway-response-23' => 'Numer karty kredytowej lub data ważności są nieprawidłowe.',
	'payflowpro_gateway-response-4' => 'Nieprawidłowa kwota.',
	'payflowpro_gateway-response-24' => 'Numer karty kredytowej lub data ważności są nieprawidłowe.',
	'payflowpro_gateway-response-112' => 'Adres lub kod zabezpieczający CVV są nieprawidłowe.',
	'payflowpro_gateway-response-125' => 'Transakcja została odrzucona przez system zapobiegania nadużyciom.',
	'payflowpro_gateway-response-125-2' => 'Nie udało się zweryfikować danych karty kredytowej. Prosimy o sprawdzenie, czy podane informacje odpowiadają tym w profilu karty, lub o spróbowanie transakcji z użyciem innej karty. Można skorzystać z <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">innych sposobów złożenia darowizny</a>, lub skontaktować się z Wikimedia Foundation pod adresem <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Dziękujemy za wsparcie.',
	'payflowpro_gateway-response-default' => 'Wystąpił błąd podczas przeprowadzania transakcji.
Spróbuj ponownie później.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'payflowprogateway' => 'Fà toa donassion adess',
	'payflowpro_gateway-desc' => 'Tratament ëd le carte ëd crédit PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => "Toa transassion a l'é stàita aprovà.
Mersì për toa donassion!",
	'payflowpro_gateway-response-126' => "Toa transassion a speta l'aprovassion.",
	'payflowpro_gateway-response-126-2' => "Cheidun-e dj'anformassion ch'it l'has dàit a corispondo pa al profil ëd toa carta ëd crédit, o it l'has fàit un cadò motobin gròss. Për toa sicurëssa, toa donassion a l'é al moment sota revision, e noi it avisroma con la pòsta eletrònica dàita se i podoma pa finalisé toa donassion. Për piasì scriv a <a href=\"mailto:donate@wikimedia.org\">donate@wikimedia.org</a> s'it l'has dle chestion. Mersì!",
	'payflowpro_gateway-response-12' => "Për piasì contata la companìa ëd toa carta ëd crédit për d'àutre anformassion.",
	'payflowpro_gateway-response-13' => 'Toa transassion a veul autorisassion a vos.
Për piasì contatne për continué toa transassion.',
	'payflowpro_gateway-response-114' => "Për piasì contata la companìa ëd toa carta ëd crédit për d'àutre anformassion.",
	'payflowpro_gateway-response-23' => 'Ël nùmer ëd carta ëd crédit o la data dë scadensa a son pa bon.',
	'payflowpro_gateway-response-4' => 'Ampòrt pa bon.',
	'payflowpro_gateway-response-24' => 'Tò nùmer ëd carta ëd crédit o la data dë scadensa a son pa bon.',
	'payflowpro_gateway-response-112' => 'Toa adrëssa o nùmer CVV (còdes ëd sicurëssa) a son pa bon.',
	'payflowpro_gateway-response-125' => "Toa transassion a l'é stàita arfudà dai Servissi ëd Prevension ëd le Fregadure.",
	'payflowpro_gateway-response-125-2' => 'Toa carta ëd crédit a peul pa esse validà. Për piasì verìfica che tute j\'anformassion dàite a corispondo a tò profil ëd carta ëd crédit, o preuva na carta diferenta. It peule ëdcò dovré un-a dle nòstre <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">àutre manere ëd dé</a> o contatene a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Mersì për tò sosten.',
	'payflowpro_gateway-response-default' => "A l'é staje n'eror an processand toa transassion.
Për piasì prova torna pì tard.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'payflowprogateway' => 'خپله بسپنه همدا اوس ورکړۍ',
);

/** Portuguese (Português)
 * @author Alchimista
 * @author GTNS
 * @author Giro720
 * @author GoEThe
 * @author Hamilton Abreu
 * @author Luckas Blade
 * @author Malafaya
 */
$messages['pt'] = array(
	'payflowprogateway' => 'Faça o seu donativo agora',
	'payflowpro_gateway-desc' => 'Processamento de cartões de crédito pela plataforma PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'A transacção foi aprovada.
Obrigado pelo seu donativo!',
	'payflowpro_gateway-response-126' => 'A transacção foi submetida para aprovação.',
	'payflowpro_gateway-response-126-2' => 'Alguma da informação que forneceu não corresponde ao perfil do seu cartão de crédito, ou então fez um donativo de montante muito significativo. Por segurança, o seu donativo está presentemente sob análise. Se não pudermos finalizar o processo, será enviada uma notificação para o correio electrónico fornecido. Em caso de dúvidas contacte-nos, por favor, no endereço <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Obrigado!',
	'payflowpro_gateway-response-12' => 'Por favor, contacte o emissor do seu cartão de crédito para mais informação.',
	'payflowpro_gateway-response-13' => 'A transacção requer autorização por viva voz.
Por favor, contacte-nos para continuar a transacção.',
	'payflowpro_gateway-response-114' => 'Por favor, contacte o emissor do seu cartão de crédito para mais informação.',
	'payflowpro_gateway-response-23' => 'O número do cartão ou a data de expiração estão incorrectos.',
	'payflowpro_gateway-response-4' => 'Montante inválido.',
	'payflowpro_gateway-response-24' => 'O número do cartão ou a data de expiração estão incorrectos.',
	'payflowpro_gateway-response-112' => 'O endereço ou o código de segurança (CVV) estão incorrectos.',
	'payflowpro_gateway-response-125' => 'A transacção foi recusada pela Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Não foi possível validar o seu cartão de crédito. Por favor, verifique que toda a informação fornecida coincide com o perfil do seu cartão de crédito. Pode também usar um dos nossos <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">outros métodos para fazer donativos</a> ou contactar-nos no endereço <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Obrigado pelo seu apoio.',
	'payflowpro_gateway-response-default' => 'Ocorreu um erro no processamento desta transacção.
Por favor, tente novamente mais tarde.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author GoEThe
 * @author Luckas Blade
 * @author MetalBrasil
 * @author Raylton P. Sousa
 */
$messages['pt-br'] = array(
	'payflowprogateway' => 'Faça o seu doação agora',
	'payflowpro_gateway-desc' => 'Processamento de cartões de crédito pela plataforma PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'A transação foi aprovada.
Agradecemos a sua doação!',
	'payflowpro_gateway-response-126' => 'A transação foi submetida para aprovação.',
	'payflowpro_gateway-response-126-2' => 'Alguma informação que você forneceu não corresponde ao perfil do seu cartão de crédito, ou então você fez a doação de montante muito significativo. Por segurança, o seu donativo está sob análise no momento. Se não pudermos finalizar o processo, será enviada uma notificação para o e-mail fornecido. Em caso de dúvidas contate-nos, por favor, no endereço <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Obrigado!',
	'payflowpro_gateway-response-12' => 'Por favor entre em contato com a companhia do seu cartão de crédito para mais informações.',
	'payflowpro_gateway-response-13' => 'A transação requer autorização por viva voz.
Por favor, contate-nos para continuar a transação.',
	'payflowpro_gateway-response-114' => 'Por favor entre em contato com a companhia do seu cartão de crédito para mais informações.',
	'payflowpro_gateway-response-23' => 'O número do cartão ou a data de expiração estão incorretos.',
	'payflowpro_gateway-response-4' => 'Quantia inválida.',
	'payflowpro_gateway-response-24' => 'O número do cartão ou a data de expiração estão incorretos.',
	'payflowpro_gateway-response-112' => 'O endereço ou o código de segurança (CVV) estão incorretos.',
	'payflowpro_gateway-response-125' => 'A transação foi recusada pela Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Não foi possível validar o seu cartão de crédito. Por favor, verifique se toda a informação fornecida coincide com o perfil do seu cartão de crédito. Você pode também usar um dos nossos <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">outros métodos para fazer doação</a> ou contatar-nos no endereço <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Obrigado pelo seu apoio.',
	'payflowpro_gateway-response-default' => 'Ocorreu um erro no processamento desta transação.
Por favor tente novamente mais tarde.',
);

/** Romanian (Română)
 * @author AdiJapan
 * @author Cin
 * @author Firilacroco
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'payflowprogateway' => 'Donați acum',
	'payflowpro_gateway-desc' => 'Prelucrează cardul de credit PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Tranzacția dumneavoastră a fost aprobată.
Vă mulțumim pentru donație!',
	'payflowpro_gateway-response-126' => 'Tranzacția dumneavoastră este în curs de aprobare.',
	'payflowpro_gateway-response-126-2' => 'Anumite informații pe care le-ați furnizat nu se potrivesc cu profilul cardului de credit sau ați făcut un cadou foarte consistent. Pentru siguranța dumneavoastră, donația este în curs de verificare, urmând să vă înștiințăm, în cazul în care acesta nu poate fi finalizată, prin intermediul adresei de e-mail oferite. Dacă aveți întrebări vă rugăm să ne contactați la <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Vă mulțumim!',
	'payflowpro_gateway-response-12' => 'Vă rugăm să contactați compania emitentă a cardului dumneavoastră de credit pentru informații suplimentare.',
	'payflowpro_gateway-response-13' => 'Tranzacția dumneavoastră necesită autorizare vocală.
Contactați-ne pentru a vă continua tranzacția.',
	'payflowpro_gateway-response-114' => 'Vă rugăm să contactați compania emitentă a cardului dumneavoastră de credit pentru informații suplimentare.',
	'payflowpro_gateway-response-23' => 'Numărul cardului de credit sau data expirării este incorect(ă).',
	'payflowpro_gateway-response-4' => 'Sumă incorectă.',
	'payflowpro_gateway-response-24' => 'Numărul cardului de credit sau data expirării este incorect(ă).',
	'payflowpro_gateway-response-112' => 'Adresa dumneavoastră sau codul CCV (cod de securitate) este incorect(ă).',
	'payflowpro_gateway-response-125' => 'Tranzacția dumneavoastră a fost respinsă de către serviciile de prevenire a fraudelor.',
	'payflowpro_gateway-response-125-2' => 'Cardul dumneavoastră de credit nu a putut fi validat. Vă rugăm să verificați dacă toate informațiile introduse corespund profilului cardului sau să reîncercați cu un alt card de credit. Puteți de asemenea utiliza celelalte <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">modalități de donare</a> sau ne puteți contacta la <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Vă mulțumim pentru sprijinul acordat.',
	'payflowpro_gateway-response-default' => 'S-a produs o eroare în timpul procesării tranzacției dumneavoastră.
Vă rugăm să reîncercați mai târziu.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'payflowprogateway' => "Fà 'a donazziona toje mò",
	'payflowpro_gateway-response-0' => "'A transaziona toje ha state approvate.
Grazie pa donazzione!",
	'payflowpro_gateway-response-126' => "'A transaziona toje jè in attese de approvazione.",
	'payflowpro_gateway-response-12' => "Pè avè cchiù 'mbormazziune sì pregate de cundattà 'a società d'a toje carte de credite.",
	'payflowpro_gateway-response-114' => "Pè avè cchiù 'mbormazziune sì pregate de cundattà 'a società d'a toje carte de credite.",
	'payflowpro_gateway-response-23' => "'U toje nomere d'a carte de credite o 'a date de scadenze non g'ète currette.",
	'payflowpro_gateway-response-4' => 'Importe invalide.',
	'payflowpro_gateway-response-24' => "'U toje nomere d'a carte de credite o 'a date de scadenze non g'ète currette",
	'payflowpro_gateway-response-112' => "'U toje 'nderizze o 'u numere d'u CVV (codece de sicurezze) non g'ète currette.",
	'payflowpro_gateway-response-125' => "'A transizione jè state refiutate d'a Fraud Prevention Services.",
	'payflowpro_gateway-response-default' => "S'è verifecate 'nu errore durande l'elaborazziune d'a transizione.
Sì pregate de pruvà n'otre vote cchù nnande.",
);

/** Russian (Русский)
 * @author Dim Grits
 * @author Eleferen
 * @author Kaganer
 * @author MaxSem
 * @author Putnik
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'payflowprogateway' => 'Сделайте пожертвование сейчас',
	'payflowpro_gateway-desc' => 'Обработка кредитных карт PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Ваша транзакция была санкционирована.
Спасибо за ваше пожертвование!',
	'payflowpro_gateway-response-126' => 'Ваша транзакция ожидает санкционирования.',
	'payflowpro_gateway-response-126-2' => 'Некоторые из представленных вами данных не совпадают со сведениями профиля вашей кредитной карты, или вы сделали очень большое пожертвование. В целях вашей безопасности, ваше пожертвование в настоящее время рассматривается, мы уведомим вас по электронной почты, если мы не сможем обработать данную заявку на пожертвование. Пожалуйста, напишите на <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>, если у вас есть какие-либо вопросы. Спасибо!',
	'payflowpro_gateway-response-12' => 'Пожалуйста, свяжитесь с компанией, выдавшей кредитную карту, для получения дополнительной информации.',
	'payflowpro_gateway-response-13' => 'Ваша транзакция требует голосовой авторизации.
Пожалуйста, свяжитесь с нами, чтобы продолжить операцию.',
	'payflowpro_gateway-response-114' => 'Пожалуйста, свяжитесь с компанией, выдавшей кредитную карту, для получения дополнительной информации.',
	'payflowpro_gateway-response-23' => 'Номер вашей кредитной карты и срок окончания её действия является неверным.',
	'payflowpro_gateway-response-4' => 'Некорректная сумма.',
	'payflowpro_gateway-response-24' => 'Номер вашей кредитной карты или срок окончания её действия неверны.',
	'payflowpro_gateway-response-112' => 'Ваш адрес или номер CVV (код безопасности) является неправильным.',
	'payflowpro_gateway-response-125' => 'Ваша транзакция была отклонена Службой предотвращения мошенничества.',
	'payflowpro_gateway-response-125-2' => 'Ваша кредитная карта не может быть подтверждена. Пожалуйста, убедитесь, что указанная информация соответствует профилю вашей кредитной карты, или попробуйте использовать другую карту. Вы можете также использовать один из <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">других способов пожертвования</a>, или связаться с нами посредством <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Спасибо за вашу поддержку.',
	'payflowpro_gateway-response-default' => 'При обработке вашей транзакции возникла ошибка.
Пожалуйста, повторите попытку позже.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'payflowprogateway' => 'Зробити вашу пожертву теперь',
	'payflowpro_gateway-desc' => 'Спрацованя кредітных карт  PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Ваша трансакція была схвалена.
Дякуєме за ваше пожертвованя!',
	'payflowpro_gateway-response-126' => 'Чекать ся на схвалїня вашой трансакції.',
	'payflowpro_gateway-response-126-2' => 'Дакотры із уведеных дат ся не згодують з інформаціями ку кредітній картї або ваше пожертвованя было дуже высоке. Про вашу безпечность буде ваше пожертвованя нынї овірене; покы бы сьме пожертвованя не могли докінчіти, будеме вас інформовати средством вами уведеной адресы ел. пошты. Кідь маєте будь-якы вопросы, напиште на <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Дякуєме!',
	'payflowpro_gateway-response-12' => 'Про детайлнїшы інформації пожадайте выдавателя вашой кредітной карты.',
	'payflowpro_gateway-response-13' => 'Ваша трансакція выжадує авторізацію голосом.
Просиме, про докінчіня трансакції нас контактуйте.',
	'payflowpro_gateway-response-114' => 'Про детайлнїшы інформації пожадайте выдавателя вашой кредітной карты.',
	'payflowpro_gateway-response-23' => 'Чісло кредітной карты або датум кінце платности не є згодный.',
	'payflowpro_gateway-response-4' => 'Неправилна сума.',
	'payflowpro_gateway-response-24' => 'Чісло кредітной карты або датум кінце платности не є згодный.',
	'payflowpro_gateway-response-112' => 'Ваша адреса або безпечностный код CVV є неправилный.',
	'payflowpro_gateway-response-125' => 'Ваша трансакція была одмітнута охоронов проти знеужытю карет.',
	'payflowpro_gateway-response-125-2' => 'Вашу кредітну карту ся не подарило овірити. Перевірте, же вшыткы уведены інформації одповідають датам о вашій картї, або спробуйте хосновати іншу карту. Можете тыж выужыти нашых <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">далшых способів, як пожертвовати,</a> або нам напиште на <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Дякуєме за вашу підпору.',
	'payflowpro_gateway-response-default' => 'Почас спрацованя вашой трансакції дішло ку хыбі.
Спробуйте то знову о дашто пізнїше.',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'payflowprogateway' => 'Харчыны билигин сиэртибэлээ',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro кирэдьиит каартатын таҥастааһын',
	'payflowpro_gateway-response-0' => 'Эн төлөбүрүҥ ааста.
Сиэртибэҥ иһин махталбытын биллэрэбит!',
	'payflowpro_gateway-response-126' => 'Эн төлөбүрүҥ бигэргэтиини кэтэһэр.',
	'payflowpro_gateway-response-126-2' => 'Эн билигин киллэрбит дааннайдарыҥ сорҕото кирэдьиитиҥ каартатын дааннайдарын кытта сөп түбэспэт эбит, эбэтэр Эн наһаа улахан сиэртибэни оҥорбуккун. Онон, эйиэхэ куттал суоһаабатын туһугар, сиэртибэҥ эбии тургутууну аһыахтаах, ол сатамматаҕына электроннай почтаҕар биллэриэхпит. Туох эмит ыйытардаах буоллаххына бу аадырыска суруйаар <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Махтанабыт!',
	'payflowpro_gateway-response-12' => 'Бука диэн кирэдьиит каартатын биэрбит хампаанньаҕын кытта сибээстэһэн эбии быһаарыыта ыл.',
	'payflowpro_gateway-response-13' => 'Эн транзакцияҥ куолаһынан авторизацияланыыны ирдиир эбит.
Бука диэн, биһигини кытта сибээскэ тахсан операцияҕын салгыы толор.',
	'payflowpro_gateway-response-114' => 'Бука диэн кирэдьиит каартатын биэрбит хампаанньаҕын кытта сибээстэһэн эбии быһаарыыта ыл.',
	'payflowpro_gateway-response-23' => 'Кирэдьиит каартаҥ нүөмэрэ уонна болдьоҕо алҕастаахтар.',
	'payflowpro_gateway-response-4' => 'Сатаммат суумма',
	'payflowpro_gateway-response-24' => 'Кирэдиит каартаҥ нүөмэрэ эбэтэр болдьоҕо алҕастаахтаахтар.',
	'payflowpro_gateway-response-112' => 'Эн аадырыһыҥ эбэтэр каарта CVV нүөмэрэ алҕастаахтар.',
	'payflowpro_gateway-response-125' => 'Эн транзакцияҕын Сүүлүктээһини тохтотор сулууспа аһарбата',
	'payflowpro_gateway-response-125-2' => 'Эн кредиткэҥ бигэргэтиллэр кыаҕа суох. Бука диэн, ыйбыт дааннайдарыҥ кирэдьиит каартаҕар сөп түбэһэллэрин тургут, эбэтэр атын каартаны туһан. Эбии <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">сиэртибэ ыытыы атын көрүҥнэрин</a> туһаныаххын сөп, эбэтэр биһигини кытта манна <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> суруйан сибээстэс. Өйөбүлүҥ иһин махтанабыт.',
	'payflowpro_gateway-response-default' => 'Эн транзакцияҕын таҥастааһын кэмигэр алҕас тахсыбыт.
Бука диэн тохтуу түһэн баран хатылаан көр.',
);

/** Sinhala (සිංහල)
 * @author Singhalawap
 * @author චතුනි අලහප්පෙරුම
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'payflowprogateway' => 'දැන් ඔබගේ පරිත්‍යාගය සපයන්න',
	'payflowpro_gateway-desc' => 'පේපැල් පේෆ්ලෝ ප්‍රෝ ණයපත සකසමින්',
	'payflowpro_gateway-response-0' => 'ඔබගේ ගනුදෙනුව අනුමත කර ඇත.
ඔබ‍ගේ පරිත්‍යාගයට ස්තූතියි!',
	'payflowpro_gateway-response-126' => 'ඔබගේ ගනුදෙනුව අනුමත කර ඇත.',
	'payflowpro_gateway-response-126-2' => 'ඔබ විසින් ඉදිරිපත් කරනු ලැබූ සමහර තොරතුරු ඔබගේ ණයපත් පැතිකඩ සමග නොගැලපෙයි, හෝ ඔබ විසින් විශාල පරිත්‍යාගයක් සිදු කර ඇත. ඔබේම ආරක්ෂාව පිණිස, ඔබගේ පරිත්‍යාගය තවමත් විමර්ශනය කරමින් පවතියි, අප හට ඔබේ පරිත්‍යාගය අවසානයක් කල නොහැකි නම් ඔබ විසින් ලබා දුන් විද්‍යුත් තැපැල් ලිපිනයට අපි දැනුම් දීමක් කරන්නෙමු. ඔබට කිසියම් ප්‍රශ්නයක් තිබේ නම් කරුණාකර <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> වෙත විද්‍යුත් තැපැලක් එවන්න. ස්තුතියි!',
	'payflowpro_gateway-response-12' => 'වැඩි විස්තර සඳහා ඔබගේ ක්‍රෙඩිට් කාඩ් සමාගම හා සම්බන්ධ වන්න.',
	'payflowpro_gateway-response-13' => 'ඔබගේ ගනුදෙනුව සඳහා ශ්‍රව්‍ය අවසරදීම අවශ්‍ය වේ.
ඔබගේ ගනුදෙනුව පවත්වාගෙන යෑමට කරුණාකර අප හා සම්බන්ධ වන්න.',
	'payflowpro_gateway-response-114' => 'වැඩි විස්තර සඳහා ඔබගේ ක්‍රෙඩිට් කාඩ් සමාගම හා සම්බන්ධ වන්න.',
	'payflowpro_gateway-response-23' => 'ඔබගේ ක්‍රෙඩිට් කාඩ් පත් අංකය හෝ කල් ඉකුත්වීම් දිනය හෝ සාවද්‍යයි.',
	'payflowpro_gateway-response-4' => 'අනීතික අගයකි.',
	'payflowpro_gateway-response-24' => 'ඔබගේ ක්‍රෙඩිට් කාඩ් පත් අංකය හෝ කල් ඉකුත්වීම් දිනය හෝ සාවද්‍යයි.',
	'payflowpro_gateway-response-112' => 'ඔබගේ ලිපිනය හෝ කාඩ්-සුරැකුම්-කේතය (සුරැකුම් කේතය) හෝ සාවද්‍යයි.',
	'payflowpro_gateway-response-125' => 'වංචා වැලැක්වීමේ සේවාවන් විසින් ඔබගේ ගනුදෙනුව ප්‍රතික්‍ෂේප කර ඇත.',
	'payflowpro_gateway-response-125-2' => 'ඔබගේ ණයපත වලංගු කල නොහැක. කරුණාකර ලබා දුන් සියලු තොරතුරු ඔබගේ ණයපත් පැතිකඩ සමග ගැලපේදැයි තහවුරු කරන්න, හෝ වෙනත් කාඩ්පතක් භාවිතා කරන්න. ඔබට අපගේ <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">දීමට ඇති අනෙකුත් මාර්ග</a>  එකක් භාවිතා කෙරුම හෝ <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> මගින් අපව ඇමතිය හැක. ඔබගේ සහයෝගයට ස්තුතියි.',
	'payflowpro_gateway-response-default' => 'ඔබගේ ගනුදෙනුව සැකසීමේදී දෝෂයක් ඇති වී ඇත.
කරුණාකර පසුව නැවත උත්සාහ කරන්න.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'payflowprogateway' => 'Darovať teraz',
	'payflowpro_gateway-desc' => 'Spracovanie kreditnej karty PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Vaša transakcia bola schválená.
Ďakujeme za váš dar!',
	'payflowpro_gateway-response-126' => 'Vaša transakcia čaká na schválenie.',
	'payflowpro_gateway-response-126-2' => 'Niektoré z informácií, ktoré ste uviedli sa nezhodovali s tými v profile vašej kreditnej karty alebo ste zadali príliš veľkú čiastku daru. Pre vašu vlastnú bezpečnosť váš dar teraz podlieha kontrole a upozorníme vás na emailovú adresu, ktorú ste poskytli, ak by sme nemohli váš dar dokončiť. V prípade akýchkoľvek otázok prosím píšte na adresu <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Ďakujeme!',
	'payflowpro_gateway-response-12' => 'Ďalšie informácie sa dozviete od spoločnosti, ktorá vydala vašu kreditnú kartu.',
	'payflowpro_gateway-response-13' => 'Vaša transakcia vyžaduje overenie hlasom,
Kontaktujte nás prosím, aby sme mohli pokračovať vo vašej transakcii.',
	'payflowpro_gateway-response-114' => 'Ďalšie informácie sa dozviete od spoločnosti, ktorá vydala vašu kreditnú kartu.',
	'payflowpro_gateway-response-23' => 'Číslo alebo dátum expirácie vašej kreditnej karty nie je správne.',
	'payflowpro_gateway-response-4' => 'Neplatná čiastka.',
	'payflowpro_gateway-response-24' => 'Číslo alebo dátum expirácie vašej kreditnej karty nie je správne.',
	'payflowpro_gateway-response-112' => 'Vaša adresa alebo číslo CVV (bezpečnostný kód) nie sú správne.',
	'payflowpro_gateway-response-125' => 'Vašu transakciu zamietli Služby na ochranu fondov.',
	'payflowpro_gateway-response-125-2' => 'Vašu kreditnú kartu nebolo možné overiť. Prosím, overte, že všetky uvedené informácie sa zhodujú s uvedenými v profile vašej kreditnej karty alebo skúste inú kartu. Môžete tiež využiť jeden z <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">iných spôsobov darovania</a> alebo nás kontaktovať na adrese <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Ďakujeme za vašu podporu.',
	'payflowpro_gateway-response-default' => 'Nastala chyba pri spracovaní vašej transakcie.
Skúste to prosím opäť neskôr.',
);

/** Slovenian (Slovenščina)
 * @author Artelind
 * @author Dbc334
 */
$messages['sl'] = array(
	'payflowprogateway' => 'Oddajte svoj prispevek zdaj',
	'payflowpro_gateway-desc' => 'Obdelava kreditnih kartic preko PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Vaša transakcija je bila odobrena.
Zahvaljujemo se vam za vaš prispevek!',
	'payflowpro_gateway-response-126' => 'Vaša transakcija čaka na odobritev.',
	'payflowpro_gateway-response-126-2' => 'Nekatere navedene informacije ne ustrezajo profilu vaše kreditne kartice ali pa ste naredili zelo visoko donacijo. Zavoljo vaše varnosti je vaš prispevek trenutno v pregledu in preko navedenega e-poštnega naslova vas bomo obvestili, če vaše donacije nismo mogli zaključiti. Če imate kakršno koli vprašanje, nas kontaktirajte preko e-poštnega naslova <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Hvala!',
	'payflowpro_gateway-response-12' => 'Za dodatne informacije se, prosimo, obrnite na izdajatelja vaše kreditne kartice.',
	'payflowpro_gateway-response-13' => 'Vaša transakcija potrebuje glasovno odobritev.
Prosimo, stopite v stik z nami za nadaljevanje vaše transakcije.',
	'payflowpro_gateway-response-114' => 'Prosimo, da se za dodatne informacije obrnete na izdajatelja vaše kreditne kartice.',
	'payflowpro_gateway-response-23' => 'Številka vaše kreditne kartice ali datum njene veljavnosti je napačen.',
	'payflowpro_gateway-response-4' => 'Neveljaven znesek.',
	'payflowpro_gateway-response-24' => 'Številka vaše kreditne kartice ali datum njene veljavnosti je napačen.',
	'payflowpro_gateway-response-112' => 'Vaš naslov ali številka CVV (varnostna koda) je napačna.',
	'payflowpro_gateway-response-125' => 'Vašo transakcijo je zavrnila Storitev preprečitve goljufij (Fraud Prevention Services).',
	'payflowpro_gateway-response-125-2' => 'Vaša kreditna kartica ni bila potrjena. Prosimo, preverite, če vse informacije ustrezajo profilu vaše kreditne kartice, ali pa poskusite z drugo kartico. Uporabite lahko tudi enega od <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">drugih načinov prispevanja</a> ali pa nam pišite na <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Zahvaljujemo se vam za vašo podporo.',
	'payflowpro_gateway-response-default' => 'Pri obdelavi transakcije je prišlo do napake 
Prosimo, poskusite znova kasneje.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'payflowprogateway' => 'Приложите новац',
	'payflowpro_gateway-desc' => 'Обрађивање кредитних картица преко Пејпала',
	'payflowpro_gateway-response-0' => 'Ваш пренос новца је одобрен.
Хвала вам на подршци!',
	'payflowpro_gateway-response-126' => 'Ваш пренос новца чека на одобрење.',
	'payflowpro_gateway-response-12' => 'Обратите се компанији која вам је издала кредитну картицу за више детаља.',
	'payflowpro_gateway-response-114' => 'Обратите се компанији која вам је издала кредитну картицу за више детаља.',
	'payflowpro_gateway-response-23' => 'Број ваше кредитне картице или датум истека је неисправан.',
	'payflowpro_gateway-response-4' => 'Неисправан износ.',
	'payflowpro_gateway-response-24' => 'Број ваше кредитне картице или датум истека је неисправан.',
	'payflowpro_gateway-response-125' => 'Ваш пренос новца је одбијен од стране Службе за превенцију злоупотреба.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'payflowprogateway' => 'Priložite novac',
	'payflowpro_gateway-desc' => 'Obrađivanje kreditnih kartica preko Pejpala',
	'payflowpro_gateway-response-0' => 'Vaš prenos novca je odobren.
Hvala vam na podršci!',
	'payflowpro_gateway-response-126' => 'Vaš prenos novca čeka na odobrenje.',
	'payflowpro_gateway-response-12' => 'Obratite se kompaniji koja vam je izdala kreditnu karticu za više detalja.',
	'payflowpro_gateway-response-114' => 'Obratite se kompaniji koja vam je izdala kreditnu karticu za više detalja.',
	'payflowpro_gateway-response-23' => 'Broj vaše kreditne kartice ili datum isteka je neispravan.',
	'payflowpro_gateway-response-4' => 'Neispravan iznos.',
	'payflowpro_gateway-response-24' => 'Broj vaše kreditne kartice ili datum isteka je neispravan.',
	'payflowpro_gateway-response-125' => 'Vaš prenos novca je odbijen od strane Službe za prevenciju zloupotreba.',
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Boivie
 * @author Cohan
 * @author GameOn
 * @author Nghtwlkr
 * @author Per
 * @author Tobulos1
 */
$messages['sv'] = array(
	'payflowprogateway' => 'Donera nu',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro kreditkortsbearbetning',
	'payflowpro_gateway-response-0' => 'Transaktionen har godkänts.
Tack för din gåva!',
	'payflowpro_gateway-response-126' => 'Transaktionen väntar på godkännande.',
	'payflowpro_gateway-response-126-2' => 'Något av informationen du angav matchade inte din kreditkortsprofil, eller så gav du en väldigt stor gåva. För din egen säkerhet så granskas din donation nu, och vi kommer att meddela till den angivna epost-adressen om vi inte kan slutföra din donation. Vänligen eposta till <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> om du har några frågor. Tack!',
	'payflowpro_gateway-response-12' => 'Kontakta utställaren av ditt kreditkort för mer information.',
	'payflowpro_gateway-response-13' => 'Transaktionen kräver röstgodkännande.
Kontakta oss för att gå vidare med transaktionen.',
	'payflowpro_gateway-response-114' => 'Vänligen kontakta utställaren av ditt kreditkort för mer information.',
	'payflowpro_gateway-response-23' => 'Ditt kreditkortsnummer eller utgångsdatum är felaktigt.',
	'payflowpro_gateway-response-4' => 'Ogiltigt belopp.',
	'payflowpro_gateway-response-24' => 'Ditt kreditkortsnummer eller utgångsdatum är felaktigt.',
	'payflowpro_gateway-response-112' => 'Din adress eller CVV nummer (säkerhetskod) är felaktig.',
	'payflowpro_gateway-response-125' => 'Din transaktion har blivit avvisad av Fraud Prevention Services.',
	'payflowpro_gateway-response-125-2' => 'Ditt kreditkort kunde inte godkännas. Vänligen kontrollera att all information stämmer med dina kreditkortsdata eller prova ett annat kort. Du kan också använda ett av de <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">andra sätt att ge ett bidrag</a> eller kontakta oss på <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Tack för att du stöttar oss.',
	'payflowpro_gateway-response-default' => 'Ett fel uppstod när din transaktion behandlades.
Försök igen senare.',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 * @author Muddyb Blast Producer
 */
$messages['sw'] = array(
	'payflowprogateway' => 'Changia sasa',
	'payflowpro_gateway-desc' => 'Kutekeleza malipo ya kadi ya malipo kwa kupitia PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Malipo yako yamepitishwa. 
Ahsante kwa mchango wako!',
	'payflowpro_gateway-response-126' => 'Shughuli yako yanasubiri kuidhinishwa.',
	'payflowpro_gateway-response-126-2' => 'Baadhi ya taarifa ulizozitoa hazikuendana na taarifa kamili za kadi yako ya malipo, ama umetoa mchango mkubwa sana. Kwa ajili ya usalama wako, mchango wako unachunguzwa. Tutakutaarifu kupitia anwani ya barua pepe uliyoitaja, iwapo tutashindwa kukamilisha mchango wako. Tafadhali tuma barua pepe kwa <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> kama una maswali. Ahsante!',
	'payflowpro_gateway-response-12' => 'Tafadhali wasiliana na kampuni ya kadi yako ya malipo ili kupata maelezo zaidi.',
	'payflowpro_gateway-response-13' => 'Malipo yako yanahitaji uidhinishaji kwa njia ya sauti. 
Tafadhali wasiliana nasi ili kuendelea kushughulika malipo yako.',
	'payflowpro_gateway-response-114' => 'Tafadhali wasiliana na kampuni ya kadi yako ya malipo ili kupata maelezo zaidi.',
	'payflowpro_gateway-response-23' => 'Namba au tarehe ya kuisha kwa kadi yako ya malipo haipo sahihi.',
	'payflowpro_gateway-response-4' => 'Kiasi batili.',
	'payflowpro_gateway-response-24' => 'Namba au tarehe ya kuisha kwa kadi yako ya malipo haipo sahihi.',
	'payflowpro_gateway-response-112' => 'Anwani au namba ya CVV yako (kodi ya usalama) haipo sahihi.',
	'payflowpro_gateway-response-125' => 'Malipo yako yamekataliwa na Huduma za Kuzuia Ulaghai.',
	'payflowpro_gateway-response-125-2' => 'Kadi yako ya malipo haikuweza kuidhinishwa. Tafadhali hakikisha kwamba taarifa zote zilizotolewa zipo sawa na maelezo ya kadi yako, au jaribu kadi nyingine. Pia unaweza kuchangia kwa <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">njia nyingine</a> au unaweza kuwasiliana nasi hapo <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Ahsante kwa mchango wako.',
	'payflowpro_gateway-response-default' => 'Ilitokea hitilafu wakati wa kufanya malipo yako.
Tafadhali jaribu tena baadaye.',
);

/** Tamil (தமிழ்)
 * @author Surya Prakash.S.A.
 * @author TRYPPN
 */
$messages['ta'] = array(
	'payflowprogateway' => 'உங்கள் நன்கொடையை இப்போதே தரவும்',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro கடனட்டைச் செயலாக்கம்',
	'payflowpro_gateway-response-0' => 'உங்கள் பரிமாற்றம் ஒத்துக் கொள்ளப்பட்டது.
உங்கள் நன்கொடைக்கு நன்றி!',
	'payflowpro_gateway-response-126' => 'உங்கள் பரிமாற்றம் ஒப்புதல் அளிக்கப்படாமல் நிலுவையிலுள்ளது.',
	'payflowpro_gateway-response-126-2' => 'நீங்கள் அளித்த தகவல்கள் சில உங்கள் கடனட்டை தற்குறிப்புடன் (Profile) ஒத்துப்போகவில்லை. அல்லது, நீங்கள் ஒரு பெரிய தொகையைத் தேர்ந்தெடுத்துள்ளீர்கள். உங்களது சொந்தப் பாதுகாப்பிற்காக உங்கள் நன்கொடை தற்போது பரிசீலனையில் உள்ளது. உங்கள் நன்கொடையை இறுதி செய்யவில்லையெனில், நீங்கள் அளித்துள்ள மின்னஞ்சல் முகவரிக்குத் தெரிவிக்கப்படும். ஏதேனும் வினவல் இருப்பின் <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> என்ற மின்னஞ்சல் முகவரிக்கு செய்தி அனுப்புக. நன்றி!',
	'payflowpro_gateway-response-12' => 'மேலதிக தகவலுக்கு உங்கள் கடனட்டை நிறுவனத்தைத் தொடர்பு கொள்க.',
	'payflowpro_gateway-response-13' => 'உங்கள் பரிமாற்றத்திற்குக் குரல் அங்கீகாரம் (voice authorization) தேவைப்படுகிறது.
உங்கள் பரிமாற்றத்தைத் தொடர எங்களைத் தொடர்பு கொள்க.',
	'payflowpro_gateway-response-114' => 'மேலதிக தகவலுக்கு உங்கள் கடனட்டை நிறுவனத்தைத் தொடர்பு கொள்க.',
	'payflowpro_gateway-response-23' => 'உங்கள் கடனட்டை எண்ணோ அதன் காலாவதியாகும் தேதியோ தவறாக உள்ளது.',
	'payflowpro_gateway-response-4' => 'செல்லாத் தொகை.',
	'payflowpro_gateway-response-24' => 'உங்கள் கடனட்டை எண்ணோ அதன் காலாவதியாகும் தேதியோ தவறாக உள்ளது.',
	'payflowpro_gateway-response-112' => 'உங்கள் முகவரியோ CCV எண்ணோ (பாதுகாப்புக் குறியீடு) தவறாக உள்ளது.',
	'payflowpro_gateway-response-125' => 'உங்கள் பரிமாற்றாம் மோசடித் தடுப்புச் சேவைகள் மூலம் மறுக்கப்பட்டுள்ளது.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'payflowprogateway' => 'ఇప్పుడే విరాళమివ్వండి',
	'payflowpro_gateway-desc' => 'పేపాల్ పేఫ్లో ప్రో క్రెడిట్ కార్డు ప్రక్రియాపన',
	'payflowpro_gateway-response-0' => 'మీ లావాదేవీని అనుమతించారు.
మీ విరాళానికి ధన్యవాదాలు!',
	'payflowpro_gateway-response-126' => 'మీ లావాదేవీ అనుమతి కోసం వేచివుంది.',
	'payflowpro_gateway-response-12' => 'మరింత సమాచారం కొరకు మీ క్రెడిట్ కార్డు కంపెనీని సంప్రదించండి.',
	'payflowpro_gateway-response-13' => 'మీ లావాదేవీకి మౌఖిక అధీకరణ కావాలి.
మీ లావాదేవీని కొనసాగించడానికి దయచేసి మమ్మల్ని సంప్రదించండి.',
	'payflowpro_gateway-response-114' => 'మరింత సమాచారం కోసం దయచేసి మీ క్రెడిట్ కార్డు కంపెనీని సంప్రదించండి.',
	'payflowpro_gateway-response-23' => 'మీ క్రెడిట్ కార్డు నంబరు లేదా కాలపరిమితి తేదీ తప్పుగా ఉంది.',
	'payflowpro_gateway-response-4' => 'తప్పుడు మొత్తం.',
	'payflowpro_gateway-response-24' => 'మీ క్రెడిట్ కార్డు నెంబరు లేదా కాలపరిమితి తేదీ తప్పు.',
	'payflowpro_gateway-response-112' => 'మీ చిరునామా లేదా CVV సంఖ్య (భద్రతా సంకేతం) సరైనది కాదు.',
	'payflowpro_gateway-response-125' => 'మీ లావాదేవీని మోసాల నియంత్రణా సేవలు తిరస్కరించాయి.',
	'payflowpro_gateway-response-default' => 'మీ లావాదేవీని జరిపించడంలో పొరపాటు దొర్లింది. దయచేసి కాసేపాగి మళ్ళీ ప్రయత్నించండి.',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'payflowprogateway' => 'สนับสนุนวิกิมีเดีย',
	'payflowpro_gateway-desc' => 'บริกาีร PayPal Payflow Pro สำหรับบัตรเครดิต',
	'payflowpro_gateway-response-0' => 'รายการของคุณได้รับการอนุมัติแล้ว
ขอบคุณสำหรับการบริจาค!',
	'payflowpro_gateway-response-126' => 'รายการของคุณกำลังรอการอนุมัติ',
	'payflowpro_gateway-response-126-2' => 'ข้อมูลบางอย่างที่คุณกรอกไม่ตรงกับข้อมูลของบัตรเครดิตของคุณ หรือคุณบริจาคเป็นจำนวนมาก เพื่อความปลอดภัยของตัวคุณ การบริจาคของคุณกำลังอยู่ในระหว่างการตรวจสอบ และเราจะแจ้งให้คุณทราบทางอีเมล์ที่คุณกรอกไว้แล้วหากเราไม่สามารถรับเงินบริจาคจากคุณได้ กรุณาอีเมล์มาที่ <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> ถ้าคุณมีคำถามอื่นๆ ขอบคุณ!',
	'payflowpro_gateway-response-12' => 'กรุณาติดต่อบริษัทผู้ออกบัตรสำหรับข้อมูลเพิ่มเติม',
	'payflowpro_gateway-response-13' => 'รายการของคุณต้องการการยืนยันทางเสียง
กรุณาติดต่อเราเพื่อดำเนินการรายการนี้ต่อ',
	'payflowpro_gateway-response-114' => 'กรุณาติดต่อบริษัทผู้ออกบัตรสำหรับข้อมูลเพิ่มเติม',
	'payflowpro_gateway-response-23' => 'หมายเลขบัตรเครดิตหรือวันหมดอายุไม่ถูกต้อง',
	'payflowpro_gateway-response-4' => 'จำนวนเงินไม่ถูกต้อง',
	'payflowpro_gateway-response-24' => 'หมายเลขบัตรเครดิตหรือวันหมดอายุไม่ถูกต้อง',
	'payflowpro_gateway-response-112' => 'ที่อยู่หรือหมายเลข CVV ไม่ถูกต้อง',
	'payflowpro_gateway-response-125' => 'รายการของคุณได้ถูกยกเลิกโดยบริการป้องกันการฉ้อโกง',
	'payflowpro_gateway-response-125-2' => 'ไม่สามารถยืนยันบัตรเครดิตของคุณได้ กรุณาตรวจสอบข้อมูลที่กรอกไว้ทั้งหมดเพื่อให้ตรงกับข้อมูลของบัตรเครดิตของคุณ คุณสามารถ<a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">บริจาคด้วยวิธีอื่น</a> หรือติดต่อเราที่ <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. ขอบคุณสำหรับการสนับสนุนของคุณ',
	'payflowpro_gateway-response-default' => 'เกิดความผิดพลาดในการทำรายการของคุณ
กรุณาลองใหม่ภายหลัง',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'payflowprogateway' => 'Wikimediany goldaň',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro kredit kartynyň işlenişi',
	'payflowpro_gateway-response-0' => 'Tranzaksiýaňyz tassyklanyldy.
Bagyşyňyz üçin sag boluň!',
	'payflowpro_gateway-response-126' => 'Tranzaksiýaňyzyň tassyklamasyna garaşylýar.',
	'payflowpro_gateway-response-12' => 'Goşmaça maglumat üçin kredit kart kompaniýaňyz bilen habarlaşyň.',
	'payflowpro_gateway-response-13' => 'Tranzaksiýaňyz ses ygtyýarlandyrmasyny talap edýär.
Tranzaksiýaňyza dowam etmek üçin biziň bilen habarlaşyň.',
	'payflowpro_gateway-response-114' => 'Goşmaça maglumat üçin kredit kart kompaniýaňyz bilen habarlaşyň.',
	'payflowpro_gateway-response-23' => 'Kredit kart belgiňiz ýa-da onuň gutarýan senesi nädogry.',
	'payflowpro_gateway-response-4' => 'Nädogry summa.',
	'payflowpro_gateway-response-24' => 'Kredit kart belgiňiz ýa-da onuň gutarýan senesi nädogry.',
	'payflowpro_gateway-response-112' => 'Adresiňiz ýa-da CVV belgiňiz (howpsuzlyk kody) nädogry.',
	'payflowpro_gateway-response-125' => 'Tranzaksiýaňyz Fraud Prevention Services tarapyndan yzyna gaýtaryldy.',
	'payflowpro_gateway-response-default' => 'Tranzaksiýaňyz işlenýärkä säwlik döredi.
Soňra gaýtadan synaň.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 * @author Sky Harbor
 */
$messages['tl'] = array(
	'payflowprogateway' => 'Magkaloob na ngayon',
	'payflowpro_gateway-desc' => 'Pagsasagawa ng tarheng pang-utang ng PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Napayagan na ang transaksyon mo.
Salamat sa kaloob mo!',
	'payflowpro_gateway-response-126' => 'Naghihintay ng pahintulot ang transaksyon mo.',
	'payflowpro_gateway-response-126-2' => 'Ilan sa mga kabatirang ibinigay mo ang hindi tumugma sa talaksan ng kasaysayan ng iyong tarhetang pang-utang, o nagbigay ka ng isang napakalaking handog.  Para sa iyong kaligtasan, kasalukuyang sinusuri ang iyong abuloy, at ipagbibigay-alam namin sa pamamagitan ng tirahan ng e-liham kung hindi namin napagpasyahan ang donasyon mo.  Mangyaring magpadala ng e-liham sa <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> kung mayroon kang mga katanungan.  Salamat!',
	'payflowpro_gateway-response-12' => 'Mangyaring makipag-ugnayan sa iyong kompanya ng tarhetang pang-utang para sa iba pang kabatiran.',
	'payflowpro_gateway-response-13' => 'Nangangailangan ang transaksyon mo ng pagpapatotoong may tinig.
Mangyaring makipag-ugnayan sa amin upang maipagpatuloy ang transaksyon mo.',
	'payflowpro_gateway-response-114' => 'Mangyaring makipag-ugnayang sa iyong kumpanya ng tarhetang pang-utang hinggil sa iba pang kabatiran.',
	'payflowpro_gateway-response-23' => 'Hindi tama ang iyong bilang na pangtarhetang pang-utang o petsa ng pagwawakas.',
	'payflowpro_gateway-response-4' => 'Hindi tanggap na halaga.',
	'payflowpro_gateway-response-24' => 'Hindi tama ang iyong bilang na pangtarhetang pang-utang o petsa ng wakas.',
	'payflowpro_gateway-response-112' => 'Hindi tama ang iyong tirahan o bilang pang-CVV (kodigong pangkaligtasan).',
	'payflowpro_gateway-response-125' => 'Tinanggihan ng Palingkuran ng Pag-iwas sa Panloloko ang iyong transaksyon.',
	'payflowpro_gateway-response-125-2' => 'Hindi mapatunayan ang iyong tarhetang pang-utang.  Mangyaring patunayan na tumutugma ang lahat ng ibinigay na kabatiran sa iyong talaksan ng kasaysayan ng tarhetang pang-utang, o sumubok ng ibang tarheta.  Maaari mo ring gamitin ang isa sa aming <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">ibang mga paraan ng pagbibigay</a> o makipag-ugnayan sa amin sa href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>.  Salamat sa iyong pagtangkilik.',
	'payflowpro_gateway-response-default' => 'Nagkaroon ng kamalian sa pagsasagawa ng transaksyon mo.
Mangyaring subukan uli mamaya.',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Joseph
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'payflowprogateway' => 'Bağışınızı şimdi yapın',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro kredi kartı işlemi',
	'payflowpro_gateway-response-0' => 'İşleminiz onaylandı.
Bağışınız için teşekkürler!',
	'payflowpro_gateway-response-126' => 'İşleminiz onay bekliyor.',
	'payflowpro_gateway-response-126-2' => 'Vermiş olduğunuz bazı bilgiler kredi kartı profiliniz ile uyuşmuyor, ya da çok büyük bir hediye yaptınız. Kendi güvenliğiniz için, bağışınız gözden geçirme altındadır, ve eğer bağışınızı neticelendiremezsek, sizi verdiğiniz e-posta adresi aracılığıyla bilgilendireceğiz. Eğer sorunuz varsa lütfen <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> adresine e-posta atın. Teşekkürler!',
	'payflowpro_gateway-response-12' => 'Daha fazla bilgi için lütfen kredi kartı şirketinizle irtibata geçin.',
	'payflowpro_gateway-response-13' => 'İşleminiz ses yetkilendirmesi istiyor.
İşleminize devam edebilmek için lütfen bizimle irtibata geçin.',
	'payflowpro_gateway-response-114' => 'Daha fazla bilgi için lütfen kredi kartı şirketinizle irtibata geçin.',
	'payflowpro_gateway-response-23' => 'Kredi kartı numaranız ya da son kullanma tarihi doğru değil.',
	'payflowpro_gateway-response-4' => 'Geçersiz miktar.',
	'payflowpro_gateway-response-24' => 'Kredi kartı numaranız ya da son kullanma tarihi doğru değil.',
	'payflowpro_gateway-response-112' => 'Adresiniz ya da CVV numaranız (güvenlik kodu) doğru değil.',
	'payflowpro_gateway-response-125' => 'İşleminiz Fraud Prevention Services tarafından reddedildi.',
	'payflowpro_gateway-response-125-2' => 'Kredi kartınız doğrulanamadı. Lütfen verdiğiniz tüm bilgilerin kredi kartınız profiliniz ile ile uyuştuğunu doğrulayın, ya da farklı bir kart deneyin. Ayrıca, <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">vermenin diğer yolları\'nı</a> kullanabilir ya da bizimle <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a> adresinde ilteişime geçebilirsiniz. Desteğiniz için teşekkürler.',
	'payflowpro_gateway-response-default' => 'İşleminiz işlenirken bir hata oluştu.
Lütfen daha sonra tekrar deneyin.',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'payflowprogateway' => 'Сез хәзер үк иганә ясый аласыз',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro кредит карталарын куллану',
	'payflowpro_gateway-response-0' => 'Керткән иганәгез өчен бик зур рәхмәт сезгә!',
	'payflowpro_gateway-response-126' => 'Сезнең транзакция тикшерүне көтә.',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Alex Khimich
 * @author Dim Grits
 * @author NickK
 * @author Olvin
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'payflowprogateway' => 'Зробіть Вашу пожертву зараз',
	'payflowpro_gateway-desc' => 'Обробка кредитних карт PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Транзакцію підтверджено.
Дякуємо за вашу пожертву!',
	'payflowpro_gateway-response-126' => 'Ваша транзакція очікує підтвердження.',
	'payflowpro_gateway-response-126-2' => 'Деякі з наданих вами відомостей не відповідають профілю вашої кредитної картки, або ж ви зробили дуже велику пожертву. Для забезпечення вашої безпеки пожертва наразі розглядається, і ми повідомимо вас через надану адресу електронної пошти, якщо не зможемо обробити запит на пожертву. Будь ласка, повідомте електронною поштою <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>, якщо маєте які-небудь питання. Дякуємо!',
	'payflowpro_gateway-response-12' => 'Будь-ласка, зверніться до компанії, що обслуговує кредитну картку, для отримання подальшої інформації.',
	'payflowpro_gateway-response-13' => "Ваша транзакція вимагає голосової авторизації.
Будь ласка, зв'яжіться з нами, щоб продовжити операцію.",
	'payflowpro_gateway-response-114' => 'Будь-ласка, зверніться до компанії, що обслуговує кредитну картку, для отримання детальнішої інформації.',
	'payflowpro_gateway-response-23' => 'Номер вашої кредитної картки або дата закінчення терміну дії є невірними.',
	'payflowpro_gateway-response-4' => 'Неправильна сума.',
	'payflowpro_gateway-response-24' => 'Номер вашої кредитної картки або дата закінчення терміну дії є невірними.',
	'payflowpro_gateway-response-112' => 'Ваша адреса або номер CVV (захисний код) є неправильним.',
	'payflowpro_gateway-response-125' => 'Вашу транзакцію було відхилено службою запобігання шахрайству.',
	'payflowpro_gateway-response-125-2' => 'Ваша кредитна картка не може бути підтверджена. Будь ласка, переконайтеся, що всі заповнені дані відповідають профілю вашої кредитної картки або скористайтесь іншою карткою. Ви також можете скористатись одним з <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">інших способів пожертвування</a> або зв\'язатись з нами електронною поштою <a href="mailto:donate@wikimedia.org">donate@wikimedia.org.</a> Дякуємо за вашу підтримку.',
	'payflowpro_gateway-response-default' => 'Під час обробки вашої транзакції виникла помилка.
Будь ласка, спробуйте пізніше.',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'payflowprogateway' => 'Juta Wikimedia',
	'payflowpro_gateway-desc' => 'Tratamento de carte de credito PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'La to transazion la xe stà aprovà.
Grassie de la to donassion!',
	'payflowpro_gateway-response-126' => 'La to transazion la xe drio spetar de vegner aprovà.',
	'payflowpro_gateway-response-126-2' => 'Alcune de le informassion che te n\'è dato no le corisponde mia al profilo de la carta de credito usà, opure xe stà fata na donassion granda assè. Par sicuressa, la donassion la vegnarà esaminà e te rivarà na notifica via email, usando l\'indirizo fornìo, nel caso no sia possibile concluderla. Par ogni dubio, te poli scrìvarne a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Grassie!',
	'payflowpro_gateway-response-12' => 'Par piaser, parla co la to conpagnia de carte de credito par savérghene piassè.',
	'payflowpro_gateway-response-13' => 'La to transazion la richiede na autorisassion a voce.
Par piaser ciàmene par continuar la transazion.',
	'payflowpro_gateway-response-114' => 'Par piaser, ciama la to conpagnia de carte de credito par savérghene piassè.',
	'payflowpro_gateway-response-23' => 'El to nùmaro de carta de credito o la data de scadensa i xe sbajà.',
	'payflowpro_gateway-response-4' => 'Inporto mia valido.',
	'payflowpro_gateway-response-24' => 'El to nùmaro de carta de credito o la data de scadensa i xe sbajà.',
	'payflowpro_gateway-response-112' => 'El to indirisso o el nùmaro CVV (còdese de sicuressa) i xe sbajà.',
	'payflowpro_gateway-response-125' => 'La to transazion la xe stà rifiutà dal Servissio de Prevension da le Frodi.',
	'payflowpro_gateway-response-125-2' => 'La to carta de credito no la gà podù vegner validà. Controla che tute le informassion che te n\'è dato le sia giuste, o proa co na carta difarente. Ghe xe anca <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">altre maniere de donassion</a> e te scrìvarne a <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Grassie del to suporto.',
	'payflowpro_gateway-response-default' => 'Ghe xe stà un eror durante el tratamento de la to transazion.
Par piaser, ripròa de novo tra un tocheto.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Trần Nguyễn Minh Huy
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'payflowprogateway' => 'Quyên góp ngay bây giờ',
	'payflowpro_gateway-desc' => 'Xử lý thẻ tín dụng dùng PayPal Payflow Pro',
	'payflowpro_gateway-response-0' => 'Giao dịch của bạn đã được chứng nhận.
Cảm ơn sự đóng góp của bạn!',
	'payflowpro_gateway-response-126' => 'Giao dịch của bạn đang chờ được chứng nhận.',
	'payflowpro_gateway-response-126-2' => 'Một số thông tin mà bạn cung cấp không đúng với hồ sơ thẻ tín dụng của bạn, hoặc bạn đã đóng góp rất nhiều tiền. Để bảo vệ tài khoản của bạn, chúng tôi hiện đang xem xét sự đóng góp của bạn. Nếu trường hợp chúng tôi không thể hoàn thành sự đóng góp của bạn, chúng tôi sẽ liên lạc với bạn qua địa chỉ thư điện tử mà bạn cung cấp. Nếu có thắc mắc gì, xin hãy gửi thư điện tử cho <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Cảm ơn!',
	'payflowpro_gateway-response-12' => 'Xin liên hệ với công ty thẻ tín dụng của bạn để biết thêm chi tiết.',
	'payflowpro_gateway-response-13' => 'Giao dịch này cần xác nhận bằng điện thoại.
Xin hãy liên lạc với chúng tôi để tiếp tục thực hiện giao dịch.',
	'payflowpro_gateway-response-114' => 'Xin hãy liên lạc công ty thẻ tín dụng để biết thêm thông tin.',
	'payflowpro_gateway-response-23' => 'Số thẻ tín dụng của bạn hoặc ngày hết hạn không đúng.',
	'payflowpro_gateway-response-4' => 'Số tiền không hợp lệ.',
	'payflowpro_gateway-response-24' => 'Số thẻ tín dụng hoặc ngày hết hạn không đúng.',
	'payflowpro_gateway-response-112' => 'Địa chỉ hoặc mã CCV (mã bảo mật) của bạn không đúng.',
	'payflowpro_gateway-response-125' => 'Giao dịch của bạn đã bị Dịch vụ Ngăn chặn Giả mạo từ chối.',
	'payflowpro_gateway-response-125-2' => 'Không thể xác nhận thẻ tín dụng của bạn. Xin hãy chắc chắn rằng tất cả các thông tin đúng với hồ sơ thẻ tín dụng của bạn hoặc thử một thẻ tín dụng khác. Bạn cũng có thể <a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en?uselang=vi">quyên góp bằng cách khác</a> hoặc liên lạc với chúng tôi tại <a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>. Cảm ơn sự hỗ trợ của bạn.',
	'payflowpro_gateway-response-default' => 'Đã xảy ra lỗi khi xử lý giao dịch của bạn.
Xin hãy thử lại sau.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'payflowprogateway' => 'גיט אײַער נדבה אַצינד',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'payflowprogateway' => '支持 Wikimedia',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro 信用咭處理',
	'payflowpro_gateway-response-0' => '你嘅交易已經批准咗。
多謝你嘅捐款！',
	'payflowpro_gateway-response-126' => '你嘅交易等緊批准。',
	'payflowpro_gateway-response-12' => '請聯絡你嘅信用咭公司去拎更詳細嘅資料。',
	'payflowpro_gateway-response-13' => '你嘅交易需要音訊認證。
請聯絡我地去繼續你嘅交易。',
	'payflowpro_gateway-response-114' => '請聯絡你嘅信用咭公司去拎更詳細嘅資料。',
	'payflowpro_gateway-response-23' => '你張信用咭冧吧或者到期日唔正確。',
	'payflowpro_gateway-response-4' => '無效嘅金額。',
	'payflowpro_gateway-response-24' => '你張信用咭冧吧或者到期日唔正確。',
	'payflowpro_gateway-response-112' => '你嘅地址或者CVV冧吧 (安全碼) 唔正確。',
	'payflowpro_gateway-response-125' => '你嘅交易已經畀欺詐防止服務拒絕咗。',
	'payflowpro_gateway-response-default' => '當處理緊你嘅交易嗰陣出錯。
請遲啲再試。',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Chenxiaoqino
 * @author Hydra
 * @author Kuailong
 * @author Liangent
 * @author Wilsonmess
 */
$messages['zh-hans'] = array(
	'payflowprogateway' => '现在捐款',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro信用卡处理',
	'payflowpro_gateway-response-0' => '您的交易已经成功。
感谢您的捐助！',
	'payflowpro_gateway-response-126' => '您的交易正在等待确认中。',
	'payflowpro_gateway-response-126-2' => '您所提供的部分信息和您的信用卡账户信息不符，或者您的捐款金额较大。为了阁下的账户安全，您的捐款目前正在接受审查，如果捐款失败，我们会通过您提供的电子邮件联系您。如有疑问，请致信<a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>。感谢！',
	'payflowpro_gateway-response-12' => '请向您的信用卡公司咨询更多信息。',
	'payflowpro_gateway-response-13' => '您的交易需要语音授权。
请联系我们以完成您的这笔交易。',
	'payflowpro_gateway-response-114' => '请向您的信用卡公司咨询更多信息。',
	'payflowpro_gateway-response-23' => '您的信用卡号码或有效期有误。',
	'payflowpro_gateway-response-4' => '无效的数额。',
	'payflowpro_gateway-response-24' => '您的信用卡号或有效期有误。',
	'payflowpro_gateway-response-112' => '您的地址或CVV码（安全码）有误。',
	'payflowpro_gateway-response-125' => '反欺诈系统拒绝了您的捐献。',
	'payflowpro_gateway-response-125-2' => '无法验证您的信用卡。请确保您所提供的信息与信用卡资料信息相符，或者换一张信用卡再试一次。您可以使用我们其他的<a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">捐款方式</a>，或者与<a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>联系。再次感谢您的支持。',
	'payflowpro_gateway-response-default' => '在处理交易的过程中出错。
请稍后再试。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 * @author Horacewai2
 * @author Liangent
 * @author Mark85296341
 * @author Pbdragonwang
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'payflowprogateway' => '現在捐款',
	'payflowpro_gateway-desc' => 'PayPal Payflow Pro信用卡處理',
	'payflowpro_gateway-response-0' => '您的交易已經成功。
感謝您的捐助！',
	'payflowpro_gateway-response-126' => '您的交易正在等待確認中。',
	'payflowpro_gateway-response-126-2' => '你提供的部份資料可能與你的信用卡資料不符，或者你作出了一個大數量的捐款；為確保你的安全，你的捐款正在審核中，如果你的捐款不成功，我們將會透過你填入的電郵通知你。如有查詢，請電郵至<a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>。',
	'payflowpro_gateway-response-12' => '請聯絡您的信用卡公司提供進一步資料。',
	'payflowpro_gateway-response-13' => '您的交易需要語音授權。
請聯絡我們以完成您的這筆交易。',
	'payflowpro_gateway-response-114' => '請聯絡您的信用卡公司提供進一步資料。',
	'payflowpro_gateway-response-23' => '您的信用卡號碼或有效期有誤。',
	'payflowpro_gateway-response-4' => '無效的數額。',
	'payflowpro_gateway-response-24' => '您的信用卡號或有效期有誤。',
	'payflowpro_gateway-response-112' => '您的地址或CVV碼（安全碼）有誤。',
	'payflowpro_gateway-response-125' => '反欺詐系統拒絕了您的捐獻。',
	'payflowpro_gateway-response-125-2' => '您的信用卡無法被驗證。請確保您所提供的資料與信用卡的資料相符，或者換另外一張信用卡再試一次。您可以使用我們其他的<a href="http://wikimediafoundation.org/wiki/Ways_to_Give/en">捐款方式</a>，或與<a href="mailto:donate@wikimedia.org">donate@wikimedia.org</a>聯絡。再次感謝您的支持。',
	'payflowpro_gateway-response-default' => '在處理交易的過程中出錯。
請稍後再試。',
);

