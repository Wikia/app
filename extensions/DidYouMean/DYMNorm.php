<?php

function wfDymNormalise( $norm ) {
	# ignore: spaces, hyphens, commas, periods, mid dots
	$norm = preg_replace( '/[\- _,.·]/u', '', $norm );

	# ignore apostrophe-like characters
	$norm = preg_replace( '/[\'’`ˊʻʼ]/u', '', $norm );

	# ignore all combinng diacritics
	$norm = preg_replace( '/[̱̃]/u', '', $norm );

	# latin / roman
	$norm = preg_replace( '/[AaＡａÁáÀàÂâÄäǍǎĂăĀāÃãÅåĄąẤấẢảẠạẬậª]/u', 'A', $norm );
	$norm = preg_replace( '/[ÆæǼǽǢǣ]/u', 'AE', $norm );
	$norm = preg_replace( '/[BbＢｂ]/u', 'B', $norm );
	$norm = preg_replace( '/[CcＣｃĆćĊċĈĉČčÇç]/u', 'C', $norm );
	$norm = preg_replace( '/[DdＤｄĎďĐđÐðƉɖ]/u', 'D', $norm );
	$norm = preg_replace( '/[EeＥｅÉéÈèĖėÊêËëĚěĒēẼẽĘęẾếỀềḖḗỂểẸẹỆệƏə]/u', 'E', $norm );
	$norm = preg_replace( '/[Ɛɛ]/u', 'Ɛ', $norm );
	$norm = preg_replace( '/[FfＦｆ]/u', 'F', $norm );
	$norm = preg_replace( '/[GgＧｇĠġĜĝǦǧĞğĢģǤǥ]/u', 'G', $norm );
	$norm = preg_replace( '/[HhＨｈĤĥĦħḤḥ]/u', 'H', $norm );
	$norm = preg_replace( '/[IiＩｉÍíÌìİıÎîÏïĬĭĪīĨĩĮįỊị]/u', 'I', $norm );
	$norm = preg_replace( '/[Ĳĳ]/u', 'IJ', $norm );
	$norm = preg_replace( '/[JjＪｊĴĵ]/u', 'J', $norm );
	$norm = preg_replace( '/[KkＫｋǨǩ]/u', 'K', $norm );
	$norm = preg_replace( '/[LlＬｌĹĺĽľĻļŁłḺḻ]/u', 'L', $norm );
	$norm = preg_replace( '/[MmＭｍḾḿṂṃ]/u', 'M', $norm );
	$norm = preg_replace( '/[NnＮｎŃńŇňÑñṆṇŊŋⁿ]/u', 'N', $norm );
	$norm = preg_replace( '/[OoＯｏÓóÒòÔôÖöŌōÕõŐőỐốỒồØøǾǿƠơỚớỜờỘộỞở0º]/u', 'O', $norm );
	$norm = preg_replace( '/[Œœ]/u', 'OE', $norm );
	$norm = preg_replace( '/[Ɔɔ]/u', 'Ɔ', $norm );
	$norm = preg_replace( '/[PpＰｐ]/u', 'P', $norm );
	$norm = preg_replace( '/[QqＱｑ]/u', 'Q', $norm );
	$norm = preg_replace( '/[RrＲｒŔŕŘřṞṟṚṛ]/u', 'R', $norm );
	$norm = preg_replace( '/[SsＳｓŚśŜŝŠšŞşṢṣ]/u', 'S', $norm );
	$norm = preg_replace( '/[TtＴｔŤťŢţṮṯṬṭŦŧ]/u', 'T', $norm );
	$norm = preg_replace( '/[UuＵｕÚúÙùÛûÜüŬŭŪūŨũŮůŲųŰűǗǘǛǜǙǚǕǖỦủƯưỤụỨứỪừỮữỬửỬửỰự]/u', 'U', $norm );
	$norm = preg_replace( '/[VvＶｖ]/u', 'V', $norm );
	$norm = preg_replace( '/[WwＷｗẂẃẀẁŴŵẄẅ]/u', 'W', $norm );
	$norm = preg_replace( '/[XxＸｘ]/u', 'X', $norm );
	$norm = preg_replace( '/[YyＹｙÝýỲỳŶŷŸÿỸỹ]/u', 'Y', $norm );
	$norm = preg_replace( '/[ZzＺｚŹźŻżŽž]/u', 'Z', $norm );
	$norm = preg_replace( '/[ÞþǷƿ]/u', 'þ', $norm );

	# greek
	$norm = preg_replace( '/[ΑαΆάᾶ]/u', 'Α', $norm );
	$norm = preg_replace( '/[Ββ]/u', 'Β', $norm );
	$norm = preg_replace( '/[Γγ]/u', 'Γ', $norm );
	$norm = preg_replace( '/[Δδ]/u', 'Δ', $norm );
	$norm = preg_replace( '/[ΕεΈέ]/u', 'Ε', $norm );
	$norm = preg_replace( '/[Ζζ]/u', 'Ζ', $norm );
	$norm = preg_replace( '/[ΗηΉήῆῆ]/u', 'Η', $norm );
	$norm = preg_replace( '/[Θθ]/u', 'Θ', $norm );
	$norm = preg_replace( '/[ΙιΊίΪϊἸἰἼἴἿἷῖ]/u', 'Ι', $norm );
	$norm = preg_replace( '/[Κκ]/u', 'Κ', $norm );
	$norm = preg_replace( '/[Λλ]/u', 'Λ', $norm );
	$norm = preg_replace( '/[Μμ]/u', 'Μ', $norm );
	$norm = preg_replace( '/[Νν]/u', 'Ν', $norm );
	$norm = preg_replace( '/[Ξξ]/u', 'Ξ', $norm );
	$norm = preg_replace( '/[ΟοΌό]/u', 'Ο', $norm );
	$norm = preg_replace( '/[Ππ]/u', 'Π', $norm );
	$norm = preg_replace( '/[ΡρῤῤῬῥ]/u', 'Ρ', $norm );
	$norm = preg_replace( '/[Σσς]/u', 'Σ', $norm );
	$norm = preg_replace( '/[Ττ]/u', 'Τ', $norm );
	$norm = preg_replace( '/[ΥυΎύὐὐ]/u', 'Υ', $norm );
	$norm = preg_replace( '/[Φφ]/u', 'Φ', $norm );
	$norm = preg_replace( '/[Χχ]/u', 'Χ', $norm );
	$norm = preg_replace( '/[Ψψ]/u', 'Ψ', $norm );
	$norm = preg_replace( '/[ΩωΏώῶῶ]/u', 'Ω', $norm );

	# cyrillic
	$norm = preg_replace( '/[Аа]/u', 'А', $norm );
	$norm = preg_replace( '/[Бб]/u', 'Б', $norm );
	$norm = preg_replace( '/[Вв]/u', 'В', $norm );
	$norm = preg_replace( '/[ГгҐґҒғҔҕ]/u', 'Г', $norm );
	$norm = preg_replace( '/[Дд]/u', 'Д', $norm );
	$norm = preg_replace( '/[Ђђ]/u', 'Ђ', $norm );
	$norm = preg_replace( '/[ЕеЁёӘә]/u', 'Е', $norm );
	$norm = preg_replace( '/[Жж]/u', 'Ж', $norm );
	$norm = preg_replace( '/[ЗзЭэЄє]/u', 'З', $norm );
	$norm = preg_replace( '/[Ѕѕ]/u', 'Ѕ', $norm );
	$norm = preg_replace( '/[ИиЙй]/u', 'И', $norm );
	$norm = preg_replace( '/[ІіЇїӀ]/u', 'І', $norm );
	$norm = preg_replace( '/[Јј]/u', 'Ј', $norm );
	$norm = preg_replace( '/[Кк]/u', 'К', $norm );
	$norm = preg_replace( '/[ЛлЉљ]/u', 'Л', $norm );
	$norm = preg_replace( '/[Мм]/u', 'М', $norm );
	$norm = preg_replace( '/[НнЊњ]/u', 'Н', $norm );
	$norm = preg_replace( '/[ОоӨө]/u', 'О', $norm );
	$norm = preg_replace( '/[Пп]/u', 'П', $norm );
	$norm = preg_replace( '/[Рр]/u', 'Р', $norm );
	$norm = preg_replace( '/[Сс]/u', 'С', $norm );
	$norm = preg_replace( '/[Тт]/u', 'Т', $norm );
	$norm = preg_replace( '/[ЋћҺһ]/u', 'Ћ', $norm );
	$norm = preg_replace( '/[УуЎўҮү]/u', 'У', $norm );
	$norm = preg_replace( '/[Фф]/u', 'Ф', $norm );
	$norm = preg_replace( '/[Хх]/u', 'Х', $norm );
	$norm = preg_replace( '/[ЦцЏџ]/u', 'Ц', $norm );
	$norm = preg_replace( '/[Чч]/u', 'Ч', $norm );
	$norm = preg_replace( '/[ШшЩщ]/u', 'Ш', $norm );
	$norm = preg_replace( '/[Ыы]/u', 'Ы', $norm );
	$norm = preg_replace( '/[ЬьЪъѢѣ]/u', 'Ь', $norm );
	$norm = preg_replace( '/[Юю]/u', 'Ю', $norm );
	$norm = preg_replace( '/[Яя]/u', 'Я', $norm );

	# hebrew
	# strip combining rafe, patah, qamats, dagesh/mapiq, shin dot, sin dot
	$norm = preg_replace( '/[\x{05bf}\x{05b7}\x{05b8}\x{05bc}\x{05c1}\x{05c2}]/u', '', $norm );
	$norm = preg_replace( '/־/u', '', $norm );
	$norm = preg_replace( '/ײ/u', 'יי', $norm );
	$norm = preg_replace( '/װ/u', 'וו', $norm );
	$norm = preg_replace( '/[כך]/u', 'כ', $norm );
	$norm = preg_replace( '/[מם]/u', 'מ', $norm );
	$norm = preg_replace( '/[נן]/u', 'נ', $norm );
	$norm = preg_replace( '/[פף]/u', 'פ', $norm );
	$norm = preg_replace( '/[צץ]/u', 'צ', $norm );

	# arabic
	# strip tatweel, vowels, shada, sukun
	$norm = preg_replace( '/[ـ\x{064b}-\x{0652}\x{200c}]/u', '', $norm );
	$norm = preg_replace( '/[ء]/u', 'ء', $norm );
	$norm = preg_replace( '/[اآأإٱٲٳٵ]/u', 'ا', $norm );
	$norm = preg_replace( '/[بٮٻپڀ]/u', 'ب', $norm );
	$norm = preg_replace( '/[تثٹٺټٽٿ]/u', 'ت', $norm );
	$norm = preg_replace( '/[حجخځڂڃڄڅچڇڿ]/u', 'ح', $norm );
	$norm = preg_replace( '/[دذڈډڊڋڌڍڎڏڐ]/u', 'د', $norm );
	$norm = preg_replace( '/[رزڑڒړڔڕږڗژڙ]/u', 'ر', $norm );
	$norm = preg_replace( '/[سشښڛڜۺ]/u', 'س', $norm );
	$norm = preg_replace( '/[صضڝڞۻ]/u', 'ص', $norm );
	$norm = preg_replace( '/[طظڟ]/u', 'ط', $norm );
	$norm = preg_replace( '/[عغڠۼع]/u', 'ع', $norm );
	$norm = preg_replace( '/[فڡڢڣڤڥڦ]/u', 'ف', $norm );
	$norm = preg_replace( '/[قٯڧڨ]/u', 'ق', $norm );
	$norm = preg_replace( '/[كکڪګڬڭڮگڰڱڲڳڴ]/u', 'ك', $norm );
	$norm = preg_replace( '/[لڵڶڷڸ]/u', 'ل', $norm );
	$norm = preg_replace( '/[م]/u', 'م', $norm );
	$norm = preg_replace( '/[نڹںڻڼڽ]/u', 'ن', $norm );
	$norm = preg_replace( '/[هةھۀہۂۃە]/u', 'ه', $norm );
	$norm = preg_replace( '/[وؤٶٷۄۅۆۇۈۉۊۋۏ]/u', 'و', $norm );
	$norm = preg_replace( '/[ىئيٸیۍێېۑےۓ]/u', 'ى', $norm );

	# japanese
	# strip middle dot, prolonged sound mark, circumflex, grave, voice, semivoice, hw voice, hw semivoice
	$norm = preg_replace( '/[・･ーｰ＾｀゛゜ﾞﾟ]/u', '', $norm );
	# strip combining voice, semivoice
	$norm = preg_replace( '/[\x{3099}\x{309a}]/u', '', $norm );
	$norm = preg_replace( '/[アァｱｧ]/u', 'ア', $norm );
	$norm = preg_replace( '/[イィｲｨ]/u', 'イ', $norm );
	$norm = preg_replace( '/[ウヴゥｳｩ]/u', 'ウ', $norm );
	$norm = preg_replace( '/[エェｴｪ]/u', 'エ', $norm );
	$norm = preg_replace( '/[オォｵｫ]/u', 'オ', $norm );
	$norm = preg_replace( '/[カガヵｶ]/u', 'カ', $norm );
	$norm = preg_replace( '/[キギｷ]/u', 'キ', $norm );
	$norm = preg_replace( '/[クグｸ]/u', 'ク', $norm );
	$norm = preg_replace( '/[ケゲヶｹ]/u', 'ケ', $norm );
	$norm = preg_replace( '/[コゴｺ]/u', 'コ', $norm );
	$norm = preg_replace( '/[サザｻ]/u', 'サ', $norm );
	$norm = preg_replace( '/[シジｼ]/u', 'シ', $norm );
	$norm = preg_replace( '/[スズｽ]/u', 'ス', $norm );
	$norm = preg_replace( '/[セゼｾ]/u', 'セ', $norm );
	$norm = preg_replace( '/[ソゾｿ]/u', 'ソ', $norm );
	$norm = preg_replace( '/[タダﾀ]/u', 'タ', $norm );
	$norm = preg_replace( '/[チヂﾁ]/u', 'チ', $norm );
	$norm = preg_replace( '/[ツヅッﾂｯ]/u', 'ツ', $norm );
	$norm = preg_replace( '/[テデﾃ]/u', 'テ', $norm );
	$norm = preg_replace( '/[トドﾄ]/u', 'ト', $norm );
	$norm = preg_replace( '/[ナﾅ]/u', 'ナ', $norm );
	$norm = preg_replace( '/[ニﾆ]/u', 'ニ', $norm );
	$norm = preg_replace( '/[ヌﾇ]/u', 'ヌ', $norm );
	$norm = preg_replace( '/[ネﾈ]/u', 'ネ', $norm );
	$norm = preg_replace( '/[ノﾉ]/u', 'ノ', $norm );
	$norm = preg_replace( '/[ハバパﾊ]/u', 'ハ', $norm );
	$norm = preg_replace( '/[ヒビピﾋ]/u', 'ヒ', $norm );
	$norm = preg_replace( '/[フブプﾌ]/u', 'フ', $norm );
	$norm = preg_replace( '/[ヘベペﾍ]/u', 'ヘ', $norm );
	$norm = preg_replace( '/[ホボポﾎ]/u', 'ホ', $norm );
	$norm = preg_replace( '/[マﾏ]/u', 'マ', $norm );
	$norm = preg_replace( '/[ミﾐ]/u', 'ミ', $norm );
	$norm = preg_replace( '/[ムﾑ]/u', 'ム', $norm );
	$norm = preg_replace( '/[メﾒ]/u', 'メ', $norm );
	$norm = preg_replace( '/[モﾓ]/u', 'モ', $norm );
	$norm = preg_replace( '/[ヤャﾔｬ]/u', 'ヤ', $norm );
	$norm = preg_replace( '/[ユュﾕｭ]/u', 'ユ', $norm );
	$norm = preg_replace( '/[ヨョﾖｮ]/u', 'ヨ', $norm );
	$norm = preg_replace( '/[ラﾗ]/u', 'ラ', $norm );
	$norm = preg_replace( '/[リﾘ]/u', 'リ', $norm );
	$norm = preg_replace( '/[ルﾙ]/u', 'ル', $norm );
	$norm = preg_replace( '/[レﾚ]/u', 'レ', $norm );
	$norm = preg_replace( '/[ロﾛ]/u', 'ロ', $norm );
	$norm = preg_replace( '/[ワヮヷﾜ]/u', 'ワ', $norm );
	$norm = preg_replace( '/[ヰヸ]/u', 'ヰ', $norm );
	$norm = preg_replace( '/[ヱヹ]/u', 'ヱ', $norm );
	$norm = preg_replace( '/[ヲヺｦ]/u', 'ヲ', $norm );
	$norm = preg_replace( '/[ンﾝ]/u', 'ン', $norm );

	$norm = preg_replace( '/[あぁ]/u', 'あ', $norm );
	$norm = preg_replace( '/[いぃ]/u', 'い', $norm );
	$norm = preg_replace( '/[うゔぅ]/u', 'う', $norm );
	$norm = preg_replace( '/[えぇ]/u', 'え', $norm );
	$norm = preg_replace( '/[おぉ]/u', 'お', $norm );
	$norm = preg_replace( '/[かがゕ]/u', 'か', $norm );
	$norm = preg_replace( '/[きぎ]/u', 'き', $norm );
	$norm = preg_replace( '/[くぐ]/u', 'く', $norm );
	$norm = preg_replace( '/[けげゖ]/u', 'け', $norm );
	$norm = preg_replace( '/[こご]/u', 'こ', $norm );
	$norm = preg_replace( '/[さざ]/u', 'さ', $norm );
	$norm = preg_replace( '/[しじ]/u', 'し', $norm );
	$norm = preg_replace( '/[すず]/u', 'す', $norm );
	$norm = preg_replace( '/[せぜ]/u', 'せ', $norm );
	$norm = preg_replace( '/[そぞ]/u', 'そ', $norm );
	$norm = preg_replace( '/[ただ]/u', 'た', $norm );
	$norm = preg_replace( '/[ちぢ]/u', 'ち', $norm );
	$norm = preg_replace( '/[つづっ]/u', 'つ', $norm );
	$norm = preg_replace( '/[てで]/u', 'て', $norm );
	$norm = preg_replace( '/[とど]/u', 'と', $norm );
	$norm = preg_replace( '/[な]/u', 'な', $norm );
	$norm = preg_replace( '/[に]/u', 'に', $norm );
	$norm = preg_replace( '/[ぬ]/u', 'ぬ', $norm );
	$norm = preg_replace( '/[ね]/u', 'ね', $norm );
	$norm = preg_replace( '/[の]/u', 'の', $norm );
	$norm = preg_replace( '/[はばぱ]/u', 'は', $norm );
	$norm = preg_replace( '/[ひびぴ]/u', 'ひ', $norm );
	$norm = preg_replace( '/[ふぶぷ]/u', 'ふ', $norm );
	$norm = preg_replace( '/[へべぺ]/u', 'へ', $norm );
	$norm = preg_replace( '/[ほぼぽ]/u', 'ほ', $norm );
	$norm = preg_replace( '/[ま]/u', 'ま', $norm );
	$norm = preg_replace( '/[み]/u', 'み', $norm );
	$norm = preg_replace( '/[む]/u', 'む', $norm );
	$norm = preg_replace( '/[め]/u', 'め', $norm );
	$norm = preg_replace( '/[も]/u', 'も', $norm );
	$norm = preg_replace( '/[やゃ]/u', 'や', $norm );
	$norm = preg_replace( '/[ゆゅ]/u', 'ゆ', $norm );
	$norm = preg_replace( '/[よょ]/u', 'よ', $norm );
	$norm = preg_replace( '/[ら]/u', 'ら', $norm );
	$norm = preg_replace( '/[り]/u', 'り', $norm );
	$norm = preg_replace( '/[る]/u', 'る', $norm );
	$norm = preg_replace( '/[れ]/u', 'れ', $norm );
	$norm = preg_replace( '/[ろ]/u', 'ろ', $norm );
	$norm = preg_replace( '/[わゎ]/u', 'わ', $norm );
	$norm = preg_replace( '/[ゐ]/u', 'ゐ', $norm );
	$norm = preg_replace( '/[ゑ]/u', 'ゑ', $norm );
	$norm = preg_replace( '/[を]/u', 'を', $norm );
	$norm = preg_replace( '/[ん]/u', 'ん', $norm );

	return $norm;
}


