var crypto = require('crypto');

var md5 = function (plainText) {
	var md5Hash = crypto.createHash('md5');
  //plainText = utf8_encode(plainText); // should be able to skip this line
  md5Hash.update(plainText);
  return md5Hash.digest('hex');
}

module.exports.md5 = md5;
