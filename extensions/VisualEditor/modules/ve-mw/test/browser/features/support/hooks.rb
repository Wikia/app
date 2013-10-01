
Before('@edit_user_page') do
  if !$set_up_edited_page or !(ENV['REUSE_BROWSER'] == 'true')
    step 'I am logged in'
    step 'I am at my user page'
    step 'I edit the page with a string'
    $set_up_edited_page=true
  end
end