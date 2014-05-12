class CursorTestPage
  include PageObject

  include URL
  page_url URL.url('User:Selenium_user/cursor_test_page')
# contents of this page must contain EXACTLY the wikitext string:
# Reference one <ref> this is ref1 </ref>invisible transclusion here{{Template sandbox notice}} and visible transclusion here{{User:Selenium_user/cursor}}[http://www.google.com This is link to google]{{reflist}}

  span(:references_hover, class: 'oo-ui-iconedElement-icon oo-ui-icon-reference', index: 1)
  span(:transclusion_hover, class: 'oo-ui-iconedElement-icon oo-ui-icon-template', index: 1)
  span(:link_hover, class: 'oo-ui-iconedElement-icon oo-ui-icon-link', index: 1)

end
