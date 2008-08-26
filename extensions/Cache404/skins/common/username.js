// arch-tag: User name indication Javascript 

var page_title = new String;
var script_path = new String;
var db_name = new String;
var specialns = new String;
var admins = new Array;
var watchlist = new Array;
var protected_page = false; 
var message_map = false;

function set_page_title (string) {
    page_title = string;
    return true;
}

function set_script_path (string) {
    script_path = string;
    return true;
}

function set_db_name (string) {
    db_name = string;
    return true;
}

function set_specialns (string) {
    specialns = string;
    return true;
}

function set_admins (list) {
    admins = list.split(',');
    return true;
}

function is_admin(id) {
    for(var i=0;i < admins.length;i++) {
        if (admins[i] == id) {
            return true
        }
    }
    return false;
}

function set_message_map(obj) {
   message_map = obj;
}

function is_logged_in() 
{
   return (read_cookie(db_name + 'UserID') &&
	   read_cookie(db_name + 'UserName') &&
	   (read_cookie(db_name + 'UserToken') ||
	    read_cookie(db_name + 'Session')))
}

function set_watchlist(list) {
    watchlist = list.split(',');
    return true;
}

function set_protected(bool) {
    protected_page = bool;
    return true;
}

function read_cookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function get_link(id) {
  the_link = null;
  the_item = document.getElementById(id);
  if (the_item) {
     nl = the_item.getElementsByTagName('a');
     if (nl.length >= 1) {
         the_link = nl.item(0);
     }
  }
  return the_link;
}

function set_link_text(id, new_text) {
  the_link = get_link(id);
  if (the_link) {
     new_text_node = document.createTextNode(new_text);
     old_text_node = the_link.firstChild;
     the_link.replaceChild(new_text_node, old_text_node);
  }
  return true;
}
      
function string_replace(str, old, repl) {
  index = str.indexOf(old);
  if (index == -1) {
    return str;
  } else {
    return str.substr(0, index) + repl + str.substr(index + old.length);
  }
}
      
function replace_link_href(id, old, repl) {
  the_link = get_link(id);
  if (the_link) {
    old_href = the_link.getAttribute('href');
    new_href = string_replace(old_href, old, repl);
    the_link.setAttribute('href', new_href);
  }
}

function page_name(ns, title) {
  return ns + ":" + title;
}

function setup_user_name(userns, usertalkns, logout) {
   if (is_logged_in()) {
      user_name = read_cookie(db_name + 'UserName');
      set_link_text('pt-logout', logout);
      set_link_text('pt-userpage', user_name);
      replace_link_href('pt-userpage', page_name(specialns, "Mypage"),
                        page_name(userns, user_name));
      replace_link_href('pt-mytalk', page_name(specialns, "Mytalkpage"),
                        page_name(usertalkns, user_name));
   }
  return true;
}

function add_list_link(list, title, url) {
    var link = document.createElement('a');
    var text = document.createTextNode(title);
    link.setAttribute('href', url);
    link.appendChild(text);
    var item = document.createElement('li');
    item.appendChild(link);
    list.appendChild(item);
    return true;
}

function add_move_url(list) {
   return add_list_link(list, message_map.move,
			script_path + '?title=' + page_name(specialns, "Movepage")
			+ '&target=' + page_title);
}

function add_watch_url(list) {
   return add_list_link(list, message_map.watch,
			script_path + '?title=' + page_name(specialns, "Watchunwatch")
			+ '&target=' + page_title);
}

function create_link_element(list, action) {
   return add_list_link(list, message_map[action], script_path + '?title=' + page_title
                        + '&action=' + action);
}

function add_protect_url(list) {
    if (protected_page) {
        create_link_element(list, 'unprotect');
    } else {
        create_link_element(list, 'protect');
    }
    return true;
}

function add_delete_url(list) {
    create_link_element(list, 'delete');
}

function build_content_action_urls() {
   if (is_logged_in()) {
	id = read_cookie(db_name + 'UserID');
	var p_cactions = document.getElementById('p-cactions');
	var list = p_cactions.getElementsByTagName('ul').item(0);
	
	add_move_url(list);
        add_watch_url(list);
      
	if (is_admin(id)) {
	     add_delete_url(list);
	     add_protect_url(list);
	}
   }
   return true;
}

