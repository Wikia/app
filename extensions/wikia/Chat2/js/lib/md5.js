var crypto = require('crypto');

var md5 = function (plainText) {
	var md5Hash = crypto.createHash('md5');
	md5Hash.update(plainText);
	return md5Hash.digest('hex');
}

module.exports.md5 = md5;
