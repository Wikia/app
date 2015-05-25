at_exit do
  $browser.close unless ENV["KEEP_BROWSER_OPEN"] == "true"
end

#This is for the multiedit test
Before("@edit_user_page_login") do
  if (!$edit_user_page_login or !(ENV["REUSE_BROWSER"] == "true")) and @browser
    step "I am logged in"
    step "I go to the browser specific edit page page"
    step "I edit the page with Editing with"
    $edit_user_page_login=true
  end
end
