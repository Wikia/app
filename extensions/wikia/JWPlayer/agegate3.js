(function(jwplayer){
	var test = document.cookie.toString();
	var result = test.search("agegatejs");
	var result2 = test.search("agegatenotoldenough");
	var template = function(player, config, agegate){
    function setup(evt){
    	checkAge = function(){
			if (config.minage == null){
			var minage = 18;
			} else {
			var minage = parseFloat(config.minage);
			}
			if (config.maxage == null){
			var maxage = 100;
			} else {
			var maxage = parseFloat(config.maxage);
			}
			var year = document.getElementById('year');
			year = year.options[year.selectedIndex].text;
			parseInt(year);
			var month = document.getElementById('month');
			if (document.getElementById('month').options[month.selectedIndex].text == "January"){
			month = "1";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "February"){
			month = "2";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "March"){
			month = "3";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "April"){
			month = "4";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "May"){
			month = "5";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "June"){
			month = "6";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "July"){
			month = "7";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "August"){
			month = "8";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "September"){
			month = "9";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "October"){
			month = "10";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "November"){
			month = "11";
			parseInt(month);
			} else 
			if (document.getElementById('month').options[month.selectedIndex].text == "December"){
			month = "12";
			parseInt(month);
			}
			var day = document.getElementById('day');
			day = day.options[day.selectedIndex].text;
			parseInt(day);
			var theirDate = new Date((parseInt(year) + minage), parseInt(month), parseInt(day));
			var today = new Date;
			if ((today.getTime() - theirDate.getTime()) < 0){
				message.style.visibility = "visible";
				form.style.visibility = "hidden";
				header.style.visibility = "hidden";
				subheader.style.visibility = "hidden";
				var dt3 = new Date();
				if (config.cookielife == null){
				dt3.setTime(dt3.getTime() + (60 * 60 * 1000)); 
				document.cookie = 'agegatenotoldenough=okay;expires=' + dt3.toGMTString();
				} else {
				var cookielife3 = parseFloat(config.cookielife);
				dt3.setTime(dt3.getTime() + (cookielife3 * 60 * 1000));
				document.cookie = 'agegatenotoldenough=okay;expires=' + dt3.toGMTString();
				}
			} else {
				theBg.style.visibility = "hidden";
				message.style.visibility = "hidden";
				player.play();
				var dt = new Date();
				if (config.cookielife == null){
				dt.setTime(dt.getTime() + (60 * 60 * 1000)); 
				document.cookie = 'agegatejs=okay;expires=' + dt.toGMTString();
				} else {
				var cookielife2 = parseFloat(config.cookielife);
				dt.setTime(dt.getTime() + (cookielife2 * 60 * 1000));
				document.cookie = 'agegatejs=okay;expires=' + dt.toGMTString();
				}
			}
		}
		if (player.getRenderingMode() == "html5"){
		var theBody = document.getElementById(player.id);
		} else {
		var theBody = document.getElementById(player.id+"_wrapper");
		}
		if(player.config.autostart == "true"){
		player.pause();
		}
		var playerWidthPX2 = theBody.style.width;
		var playerWidthPX = parseFloat(playerWidthPX2);
		var playerHeightPX2 = theBody.style.height;
		var playerHeightPX = parseFloat(playerHeightPX2);
		var theBg = document.createElement("div");
		theBg.setAttribute('id', 'theBg');
		theBg.style.textAlign = "center";
		theBg.style.height = playerHeightPX2;
		theBg.style.width = playerWidthPX2;		
		if (config.backgroundcolor == null){
		theBg.style.background = "#000000";
		} else {
		theBg.style.background = config.backgroundcolor;
		}
		theBg.style.opacity = "1.00";
		theBg.style.position = "absolute";
		theBg.style.top = "0";
		theBg.style.left = "0";
		theBg.style.zIndex = "999";
		theBg.width = playerWidthPX;
		theBg.height = playerHeightPX;
		theBody.appendChild(theBg); 
		var header = document.createElement('div');
		if (config.header == null){
		header.innerHTML = "The content in this video requires age verification.";
		} else {
		header.innerHTML = config.header;
		}
		header.style.fontSize = "14px";
		if (config.textcolor == null){
		header.style.color = "#FFFFFF";
		} else {
		header.style.color = config.textcolor;
		}
		header.style.fontFamily = "arial,_sans";
		header.style.position = "relative";
		header.style.top = playerHeightPX - (playerHeightPX/2) - 60 +"px";
		header.setAttribute('id', 'header');
		header.style.MozUserSelect = 'none';
		header.style.KhtmlUserSelect = 'none';
		header.style.WebkitUserSelect = 'none';
		header.style.OUserSelect = 'none';
		header.style.UserSelect = 'none';
		theBg.appendChild(header);
		var subheader = document.createElement('div');
		if (config.subheader == null){
		subheader.innerHTML = "Please enter your date of birth below:";
		} else {
		subheader.innerHTML = config.subheader;
		}
		if (config.subheadertextcolor == null){
		subheader.style.color = "#FFCC00";
		} else {
		subheader.style.color = config.subheadertextcolor;
		}
		subheader.style.fontSize = "12px";
		subheader.style.fontFamily = "arial,_sans";
		subheader.style.position = "relative";
		subheader.style.top = "5px";
		subheader.setAttribute('id', 'subheader');
		subheader.style.MozUserSelect = 'none';
		subheader.style.KhtmlUserSelect = 'none';
		subheader.style.WebkitUserSelect = 'none';
		subheader.style.OUserSelect = 'none';
		subheader.style.UserSelect = 'none';
		header.appendChild(subheader);
		var form = document.createElement('div');
		form.style.position = "relative";
		form.style.top = "10px";
		form.style.fontSize = "12px";
		if (config.textcolor == null){
		form.style.color = "#FFF";
		} else {
		form.style.color = config.textcolor;
		}
		form.style.fontFamily = "arial,_sans";
		form.innerHTML = '<form onSubmit="return false;" name="age_form">&nbsp;&nbsp;<select name="month" id="month" style="background-color:#EEE; border:none;"><option>January</option><option>February</option><option>March</option><option>April</option><option>May</option><option>June</option><option>July</option><option>August</option><option>September</option><option>October</option><option>November</option><option>December</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<select id="day" name="day" style="background-color:#EEE; border:none;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<select name="year" id="year" style="background-color:#EEE; border:none;"><option>2012</option><option>2011</option><option>2010</option><option>2009</option><option>2008</option><option>2007</option><option>2006</option><option>2005</option><option>2004</option><option>2003</option><option>2002</option><option>2001</option><option>2000</option><option>1999</option><option>1998</option><option>1997</option><option>1996</option><option>1995</option><option>1994</option><option>1993</option><option>1992</option><option>1991</option><option>1990</option><option>1989</option><option>1988</option><option>1987</option><option>1986</option><option>1985</option><option>1984</option><option>1983</option><option>1982</option><option>1981</option><option>1980</option><option>1979</option><option>1978</option><option>1977</option><option>1976</option><option>1975</option><option>1974</option><option>1973</option><option>1972</option><option>1971</option><option>1970</option><option>1969</option><option>1968</option><option>1967</option><option>1966</option><option>1965</option><option>1964</option><option>1963</option><option>1962</option><option>1961</option><option>1960</option><option>1959</option><option>1958</option><option>1957</option><option>1956</option><option>1955</option><option>1954</option><option>1953</option><option>1952</option><option>1951</option><option>1950</option><option>1949</option><option>1948</option><option>1947</option><option>1946</option><option>1945</option><option>1944</option><option>1943</option><option>1942</option><option>1941</option><option>1940</option><option>1939</option><option>1938</option><option>1937</option><option>1936</option><option>1935</option><option>1934</option><option>1933</option><option>1932</option><option>1931</option><option>1930</option><option>1929</option><option>1928</option><option>1927</option><option>1926</option><option>1925</option><option>1924</option><option>1923</option><option>1922</option><option>1921</option><option>1920</option><option>1919</option><option>1918</option><option>1917</option><option>1916</option><option>1915</option><option>1914</option><option>1913</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="_send_date_" id="_send_date_" value="Verify" style="background-color:#FFCC00 !important; border:none !important;" onclick="return checkAge();"></form>';
		subheader.appendChild(form);
		var btn = document.getElementById("_send_date_");
		btn.style.cssText = "background-color:#FFCC00 !important; border:none !important;"
		btn.style.backgroundImage = "none";
		btn.style.border = "none";
		btn.style.borderRadius = "4px 4px 4px 4px";
		var message = document.createElement('div');
		message.style.position = "relative";
		message.style.top = "30px";
		message.style.fontSize = "12px";
		if (config.messagetextcolor == null){
		message.style.color = "#FF0000";
		} else {
		message.style.color = config.messagetextcolor;
		}
		message.style.fontFamily = "arial,_sans";
		if (config.message == null){
		message.innerHTML = "You do not meet the age criteria for this video.";
		} else {
		message.innerHTML = config.message;
		}
		if (config.redirecturl != null && config.redirecttarget == null){
		message.onmouseup = function(){
		window.open(config.redirecturl,"_blank");
		}
		}
		if (config.redirecturl != null && config.redirecttarget != null){
		message.onmouseup = function(){
		window.open(config.redirecturl,config.redirecttarget);
		}
		}
		message.style.visibility = "hidden";
		form.appendChild(message);
		if (result == "-1"){
		theBg.style.visibility = "visible";
		if(player.config.autostart == "true"){
		player.stop();
		}
		} else {
		theBg.style.visibility = "hidden";
		if(player.config.autostart == "true"){
		player.play();
		}
		}
		if (result2 != "-1"){
		message.style.visibility = "visible";
		form.style.visibility = "hidden";
		header.style.visibility = "hidden";
		subheader.style.visibility = "hidden";
		}
    };
    player.onReady(setup);
    this.resize = function(width, height){
	};
  };
  jwplayer().registerPlugin('agegate3', template);
})(jwplayer);