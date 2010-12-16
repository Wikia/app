<?php header('Content-type: text/xml') ?>
<smil xmlns="http://www.w3.org/2001/SMIL20/Language">
  <head>
    <meta name="title" content="Wikipedia"/>
  </head>
  <body>
    <seq>
       <video src="http://footage.stealthisfilm.com/stream/Yochai%20Benkler%20-%20On%20Autonomy%2C%20Control%20and%20Cultureal%20Experience.ogg?t=npt:00:04:<?=rand(40,59)?>.500/00:05:00.900" type="video/ogg" />  
       <video src="http://footage.stealthisfilm.com/stream/Howard%20Rheingold%20-%20Shifts%20in%20Technology%20and%20Power.ogg?t=npt:00:04:<?=rand(10,20)?>.000/00:04:22.000" type="video/ogg" />  
       <video src="http://footage.stealthisfilm.com/stream/Yochai%20Benkler%20-%20Conflicts%20in%20Cultural%20Production.ogg?t=npt:00:01:<?=rand(0,5)?>.500/00:01:10.500" type="video/ogg" />  
    </seq>
  </body>
</smil>
