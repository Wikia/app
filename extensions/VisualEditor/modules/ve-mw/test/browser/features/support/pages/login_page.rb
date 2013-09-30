class LoginPage
  include PageObject

  include URL
  page_url URL.url('Special:UserLogin')

  div(:feedback, class: 'errorbox')
  button(:login, id: 'wpLoginAttempt')
  text_field(:password, id: 'wpPassword1')
  a(:password_strength, text: 'password strength')
  a(:phishing, text: 'phishing')
  text_field(:username, id: 'wpName1')
  a(:username_displayed, title: /Your user page/)

  def logged_in_as_element
    @browser.div(id: 'mw-content-text').p.b
  end
  def login_with(username, password)
    self.username = username
    self.password = password
    login
  end
end
