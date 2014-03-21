describe("Stringhelper", function () {
	'use strict';

	var stringHelper = modules['wikia.stringhelper']();

	it('returns string with replaced diacritic characters into normal equivalent', function() {
		expect(stringHelper.latinise('ąśćndhfdjgremęęęęóóalfdsirtgjergóż')).toBe('ascndhfdjgremeeeeooalfdsirtgjergoz');
		expect(stringHelper.latinise('aaa')).toBe('aaa');
		expect(stringHelper.latinise('zxcvbnmasdfghjklqwertyuiop')).toBe('zxcvbnmasdfghjklqwertyuiop');
		expect(stringHelper.latinise('ąśęćńóżźć')).toBe('asecnozzc');
		expect(stringHelper.latinise('Cinéma')).toBe('Cinema');
		expect(stringHelper.latinise('ą')).toBe('a');
		expect(stringHelper.latinise('Jeux vidéo')).toBe('Jeux video');
	});

	it('check if string does not contain any diacritic characters', function() {
		expect(stringHelper.isLatin('ąśćndhfdjgremęęęęóóalfdsirtgjergóż')).toBe(false);
		expect(stringHelper.isLatin('aaa')).toBe(true);
		expect(stringHelper.isLatin('zxcvbnmasdfghjklqwertyuiop')).toBe(true);
		expect(stringHelper.isLatin('ąśęćńóżźć')).toBe(false);
		expect(stringHelper.isLatin('Cinéma')).toBe(false);
		expect(stringHelper.isLatin('ą')).toBe(false);
		expect(stringHelper.isLatin('Jeux vidéo')).toBe(false);
		expect(stringHelper.isLatin('a')).toBe(true);
	});
});
