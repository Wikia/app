<style>
	.ppOvr .wkLst {
		margin: 0;
		padding: 0;
		text-align: center;
	}

	.ppOvr .wkLst>li {
		padding: 0;
		line-height: 0;
		width: 50px;
		height: 50px;
		background-position: center;
		background-repeat: no-repeat;
	}

	.facebookShr{
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAcCAMAAACJShVNAAAASFBMVEX///////8shdbV5/dop+JFk9vz+P1tquOSwOqt0O/h7vkuhtb6/P5AkNoxiNe51/Ezidfa6fg9j9nQ5PZqqeI2i9iex+w4jNgdqGi6AAAAAXRSTlMAQObYZgAAAFBJREFUeF7Vx8cBgEAIBEAWzDnbf6fq6oOjA+c3QnM26UNe9aAvsGuryUtNv4SfzNEB/gXnz8Sb2e6vXh++IX0VPoY3EAA5A5Lbd6EfXEDMBY2oA0gMS/SKAAAAAElFTkSuQmCC);
	}

	.twitterShr{
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB0AAAAZCAMAAAD63NUrAAABcVBMVEX///8shdb////9/v/4+/56suXq8/sthdbx9/zE3fRCkdphpOCly+3p8vsvh9eQv+miye3V5/f7/f682PIzidfN4vUxiNelzO6Oven+//87jtk9j9lNmNy92fJ3seV2sOR5seXU5veVwuq61/G31fFsquLd6/iRv+l9tObz+P221fFPmd32+v3W5/eHuuipzu5bod+FuedMmNyBtuc2i9gzidhcoeA5jNnv9vx4seSdx+xQmt1yreSTweo0itg4jNi51vE5jdlVnN5Kl9xMl9xUnN48jtlVnd41itiaxetYnt+hye1+tOZ3sOTc6/haoN9Dk9tjpeHJ4PWTwOo6jdjX6Pev0e+rz++oze7t9PtwrOTh7vmYw+tXnt7r9PvF3fOJu+ng7fnB2/M/kNp5suVBkdpqqOL3+v3P4/Zdod+Xw+s6jdmSwOowh9eKu+guhtb1+f01itePvunk7/rQ5Pb0+f1/tebe7Pk3i9hqqeL8/f74fuJnAAAAAXRSTlMAQObYZgAAARFJREFUeF510WOXxjAQgNFM2te21rZt27Zt69dvtp0maXv2+ZgbzDkh1pSrnulINfmn/JEJ79wlFaBK6JwEuCj+kXRrb4FrCbCSL+9Cw7BWWa/jax5odYv7AmxpqX/7T/2ApTKcE6MAMFNKSJfP0NMDrmW1wGpLk0QQjDb5YH2g5TprBt53VMG3I2NgK+5oeMDju+VJGwebTlArPuI2HZhPoXrA1mOLbxY16v+y6tSxm6IS6jyy6DVlaPSZtegGM16g8NyEvW5ZCXXIeO+hmtbo+HTjlTWEPxzuCMVWhu72Qa5AxZHUtKu98xlMVdXxeTONw2a7XVUY8tZ3csIGl98oIkYPWxe1Ddnxopgw4SLZfgEIsiDQi8pbRwAAAABJRU5ErkJggg==);
	}

	.plusoneShr{
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAARCAMAAAD0U0w/AAAAPFBMVEX///8shdb////K4PWWwuthpOBuq+Pl8PpUnN7X6Pd7s+Xy9/yVwus5jdmw0fCiye2iyu292fJGlNtipOCVACRmAAAAAXRSTlMAQObYZgAAAH9JREFUeF51zskSgzAMBFH3yBuQPf//rwELkqJK6YvlepdJcaXkP5LhoQhsBiygzkg7FfiSSx/idJyLmVWYA0qS3nALaAuYVmp57QXbYy7TvsL4ddGgOxSlM2WneVy+yDpsT3Pq8ByXfJK2nICmFC00uCqmDFUppOorjqTzZ6MPCUcCbE1QGe8AAAAASUVORK5CYII=);
	}

	.emailShr{
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB0AAAAUCAMAAABGQsb1AAAAV1BMVEX///8shdb////y9/y92fLl8Po5jdnK4PVGlNuJu+iiye3X6PdHlNtuq+OVwuphpOCWwutUnN7y9/1Um93K4fXJ4PQ5jNiw0fB7s+WVwutho+DK4PQ5jNlxBHigAAAAAXRSTlMAQObYZgAAAHJJREFUeF7dzFcOAkEMBFGXPWkzOd//nEgIYY3Y4QD071O19HN7JjbR2H5QyRrSKs4ao9DZbiVfol7JAuN3nnodtrwUzz3cwFvhFPRY6tAVmMy6KqyUR9BDgXTWe6FSzy+fC1fPNY80FG4dtBX+QEV/7Amr/Qbyrt6xPQAAAABJRU5ErkJggg==);
	}
</style>
<ul class=wkLst>
<? foreach ( $networks as $n ) :?>
	<li class=<?= $n->getId() ;?>Shr><a href="<?= $n->getUrl( '$1', ($n->getId() == 'email'? '$3' : '$2' ) )/*param substitution happens in JS*/ ;?>" target=_blank></a></li>
<? endforeach ;?>
</ul>