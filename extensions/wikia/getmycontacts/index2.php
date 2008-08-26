<?

// GET NETWORK TO IMPORT FROM
if ($get =="" || empty($get)){
	
$get = $_GET["domain"];

}
if (empty($get)){

	$script = "myhotmail.php";

	$img = "myhotmail.gif";

}else{

$script = $get.'.php';

$img = $get.'.gif';

}

?>



<HEAD>

<SCRIPT LANGUAGE="Javascript">

<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function emailCheck (emailStr) {
/* The following pattern is used to check if the entered e-mail address
   fits the user@domain format.  It also is used to separate the username
   from the domain. */
var emailPat=/^(.+)@(.+)$/
/* The following string represents the pattern for matching all special
   characters.  We don't want to allow special characters in the address. 
   These characters include ( ) < > @ , ; : \ " . [ ]    */
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
/* The following string represents the range of characters allowed in a 
   username or domainname.  It really states which chars aren't allowed. */
var validChars="\[^\\s" + specialChars + "\]"
/* The following pattern applies if the "user" is a quoted string (in
   which case, there are no rules about which characters are allowed
   and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
   is a legal e-mail address. */
var quotedUser="(\"[^\"]*\")"
/* The following pattern applies for domains that are IP addresses,
   rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
   e-mail address. NOTE: The square brackets are required. */
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
/* The following string represents an atom (basically a series of
   non-special characters.) */
var atom=validChars + '+'
/* The following string represents one word in the typical username.
   For example, in john.doe@somewhere.com, john and doe are words.
   Basically, a word is either an atom or quoted string. */
var word="(" + atom + "|" + quotedUser + ")"
// The following pattern describes the structure of the user
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
/* The following pattern describes the structure of a normal symbolic
   domain, as opposed to ipDomainPat, shown above. */
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")


/* Finally, let's start trying to figure out if the supplied address is
   valid. */

/* Begin with the coarse pattern to simply break up user@domain into
   different pieces that are easy to analyze. */
var matchArray=emailStr.match(emailPat)
if (matchArray==null) {
  /* Too many/few @'s or something; basically, this address doesn't
     even fit the general mould of a valid e-mail address. */
	alert("Email address seems incorrect - Please type a valid email address")
	return false
}
var user=matchArray[1]
var domain=matchArray[2]

// See if "user" is valid 
if (user.match(userPat)==null) {
    // user is not valid
    alert("The username doesn't seem to be valid.")
    return false
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
   host name) make sure the IP address is valid. */
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
    // this is an IP address
	  for (var i=1;i<=4;i++) {
	    if (IPArray[i]>255) {
	        alert("Destination IP address is invalid!")
		return false
	    }
    }
    return true
}

// Domain is symbolic name
var domainArray=domain.match(domainPat)
if (domainArray==null) {
	alert("The domain name doesn't seem to be valid.")
    return false
}

/* domain name seems valid, but now make sure that it ends in a
   three-letter word (like com, edu, gov) or a two-letter word,
   representing country (uk, nl), and that there's a hostname preceding 
   the domain or country. */

/* Now we need to break up the domain to get a count of how many atoms
   it consists of. */
var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 || 
    domArr[domArr.length-1].length>3) {
   // the address must end in a two letter or three letter word.
   alert("The address must end in a three-letter domain, or two letter country.")
   return false
}

// Make sure there's a host name preceding the domain.
if (len<2) {
   var errStr="This address is missing a hostname!"
   alert(errStr)
   return false
}

// If we've gotten this far, everything's valid!

return true;
document.emailform.reset();

}
//  End -->
</script>

<script language="javascript1.3" src="js/ahah2.js" ></script>

<style type="text/css">

td.off {
background: #A4A4A4;
}

td.on {
background: #000000;
}

</style>

</head>

<body>
<div align="center">
  <center>
<table border="0" width="551">
                          <tr>
    <TD width="545"><IMG height=2 alt="" src="images/spacer.gif" 
      width=1 border=0></TD>
                          </tr>
                          <tr>
    <TD align=middle width="545">
      <TABLE cellSpacing=0 cellPadding=0 width=530 border=0>
        <TBODY>
        <TR>
          <TD width=5 height=5><IMG height=5 alt="" 
            src="images/tls.gif" width=5 border=0></TD>
          <TD background="images/t.gif" colSpan=2 width="520"><IMG 
            height=1 alt="" src="images/spacer.gif" width=1 
            border=0></TD>
          <TD width=6 height=5><IMG height=5 alt="" 
            src="images/trs.gif" width=5 border=0></TD></TR>
        <TR>
          <TD width=5 background="images/l.gif" 
            height=5><IMG height=5 alt="" 
            src="images/spacer.gif" width=5 border=0></TD>
          <TD width=6><IMG height=1 alt="" 
            src="images/spacer.gif" width=6 border=0></TD>
          <TD vAlign=top width=488>
          
<!-- Start of Form -->
          
<form name="emailform" enctype="multipart/form-data" id="emailform" action="<?= $script ?>"  method="post"> 

            <TABLE cellSpacing=0 cellPadding=5 width=628 align=center 
            bgColor=#ffffff border=0>
              <TBODY>
              <TR>
                <TD vAlign=top height=44 width="141"><IMG src="images/<?= $img ?>">
                <TD class=txt_sucks style="COLOR: #223f7a; PADDING-TOP: 12px" 
                width=467>
                  <p align="left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; 
					<font color="#666666" face="Arial" size="2">INVITE MY CONTACTS</font></b></TD></TR>
              <TR>
                <TD vAlign=top width=618 colspan="2">
				<div align="center">
                    <center>
                  <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100%">
                        <table border="0" width="100%" cellspacing="1" cellpadding="0" height="22">
                          <tr>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="8%" bgcolor="#CCCCCC" align="center">
							<font face="Arial">
							<a href="index.php?domain=myyahoo">
							<font color="#FFFFFF" style="font-size: 9pt">Yahoo</font></a></font></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="7%" bgcolor="#CCCCCC" align="center">
							<font face="Arial">
							<a href="index.php?domain=mygmail">
							<font color="#FFFFFF" style="font-size: 9pt">Gmail</font></a></font></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="9%" bgcolor="#CCCCCC" align="center">
							<font face="Arial">
							<a href="index.php?domain=myhotmail">
							<font color="#FFFFFF" style="font-size: 9pt">Hotmail</font></a></font></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="6%" bgcolor="#CCCCCC" align="center">
							<font face="Arial">
							<a href="index.php?domain=myaol">
							<font color="#FFFFFF" style="font-size: 9pt">AOL</font></a></font></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="8%" bgcolor="#CCCCCC" align="center">
							<a href="index.php?domain=mylycos">
							<font face="Arial" color="#FFFFFF" style="font-size: 9pt">Lycos</font></a></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="7%" bgcolor="#CCCCCC" align="center">
							<a href="index.php?domain=myrediffmail">
							<font face="Arial" color="#FFFFFF" style="font-size: 9pt">
							Rediff</font></a></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="10%" bgcolor="#CCCCCC" align="center">
							<a href="index.php?domain=mymail">
							<font face="Arial" color="#FFFFFF" style="font-size: 9pt">Mail.com</font></a></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="10%" bgcolor="#CCCCCC" align="center">
							<font face="Arial">
							<a href="index.php?domain=myindiatimes">
							<font color="#FFFFFF" style="font-size: 9pt">Indiatimes</font></a></font></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="9%" bgcolor="#CCCCCC" align="center">
							<font face="Arial" style="font-size: 9pt">
							<a href="index2.php?domain=myoutlook"><font color="#FFFFFF">Outlook</font></a></font></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="9%" bgcolor="#CCCCCC" align="center">
							<font face="Arial" style="font-size: 9pt">
							<a href="index2.php?domain=myexpress">
							<font color="#FFFFFF">Express</font></a><font color="#FFFFFF">
							</font></font></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="13%" bgcolor="#CCCCCC" align="center">
							<font face="Arial" style="font-size: 9pt">
							<a href="index2.php?domain=mythunderbird">
							<font color="#FFFFFF">Thunder Bird</font></a></font></td>
                            <td class="off" onmouseover="this.className='on'" onmouseout="this.className='off'" width="4%" bgcolor="#CCCCCC" align="center">
							<a href="index2.php">
							<font face="Arial" style="font-size: 9pt" color="#FFFFFF">
							I</font></a><font face="Arial" style="font-size: 9pt"><a href="index.php?domain=myicq"><font color="#FFFFFF">CQ</font></a></font></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td width="100%" bgcolor="#FFFFFF" height="107">

<div align="center">
  <center>
  <table border="0" width="93%">
    <tr>
      <td width="100%">
        <div align="center">
          <table border="0" width="445">
            </center>
                    </center>

  </center>
            <tr>
    <td align="right" width="439" colspan="2">
      <p align="center">
		<table width="436" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<td>
<table width="426" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td><font face="Arial" size="1">Email CSV <strong style="font-weight: 400">&nbsp;(Limit file size 
2MB)</strong></font></td>
</tr>
<tr>
<td align="center">
<p align="left"><font face="Arial" size="1">Select File</font>
<input name="ufile" type="file" id="ufile" size="28" /></td>
</tr>
</table>
</td>
</form>
</tr>
</table></td>
  <center>
                    <center>
  <center>
            </tr>
            <tr>
    <td align="right" width="144">
	<p align="left"><font face="Arial" size="1">&nbsp; <u>No details are stored</u></font></td>
    <td width="315">
	<input type="submit" value="Invite My Contacts" style="background-color: #CCCCCC; border: 1 solid #666666"></td>
            </tr>
          </table>
        </div>
      </center></center></center>
      </td>
    </tr>
  </table>
</div>
</form>
</td>
                    </tr>
                  </table>
                  </div>
                </TD>
              </TR>
              </TBODY></TABLE></FORM></TD>
          <TD width=6 background="images/r.gif" 
            height=5><IMG height=1 alt="" 
            src="images/spacer.gif" width=1 border=0></TD></TR>
        <TR>
          <TD width=5 height=5><IMG height=5 alt="" 
            src="images/bls.gif" width=5 border=0></TD>
          <TD background="images/b.gif" colSpan=2 width="520"><IMG 
            height=1 alt="" src="images/spacer.gif" width=1 
            border=0></TD>
          <TD width=6 height=5><IMG height=5 alt="" 
            src="images/brs.gif" width=5 
        border=0></TD></TR></TBODY></TABLE></TD>
                          </tr>
                        </table>

