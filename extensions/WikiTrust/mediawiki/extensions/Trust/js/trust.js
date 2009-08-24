var ctrlState = false;
function showOrigin(revnum) {
  document.location.href = wgScriptPath + "/index.php?title=" + encodeURIComponent(wgPageName) + "&diff=" + encodeURIComponent(revnum);
}

// The Vote functionality
function voteCallback(http_request){
  if ((http_request.readyState == 4) && (http_request.status == 200)) {
    document.getElementById("vote-button-done").style.visibility = "visible";
    document.getElementById("vote-button").style.visibility = "hidden";
    //alert(http_request.responseText);
    return true;
  } else {
    // Turn off error reporting.
    //alert(http_request.responseText);
    return false;
  }
}

function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  } 
  return "";
}

function startVote(){

  var revID = getQueryVariable("oldid");
  if (revID == ""){
    revID = getQueryVariable("diff");
    if (revID == ""){
      revID = wgCurRevisionId;
    }
  }

  return sajax_do_call( "TextTrustImpl::handleVote", [wgUserName, wgArticleId, revID, wgPageName] , voteCallback ); 
}
