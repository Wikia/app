CREATE TABLE /*$wgDBprefix*/dympage (
	`dp_pageid` int(8) NOT NULL,
	`dp_normid` int(8) NOT NULL,
	PRIMARY KEY (`dp_pageid`),
	UNIQUE KEY `dp_pageid` (`dp_pageid`),
	KEY `dp_normid` (`dp_normid`)
);

CREATE TABLE /*$wgDBprefix*/dymnorm (
	`dn_normid` int(8) AUTO_INCREMENT,
	`dn_normtitle` varchar(255) binary NOT NULL,
	PRIMARY KEY (`dn_normid`),
	UNIQUE KEY `dn_normid` (`dn_normid`),
	UNIQUE KEY `dn_normtitle` (`dn_normtitle`)
);
