# before all
require 'bundler/setup'
require 'page-object'
require 'page-object/page_factory'
require 'watir-webdriver'
require 'yaml'

World(PageObject::PageFactory)

def browser(environment, test_name, saucelabs_username, saucelabs_key, language)
  if environment == :cloudbees
    sauce_browser(test_name, saucelabs_username, saucelabs_key, language)
  else
    local_browser(language)
  end
end
def environment
  if ENV['ENVIRONMENT'] == 'cloudbees'
    :cloudbees
  else
    :local
  end
end
def local_browser(language)
  if ENV['BROWSER_LABEL']
    browser_label = ENV['BROWSER_LABEL'].to_sym
  else
    browser_label = :firefox
  end

  if language == 'default'
    Watir::Browser.new browser_label
  else
    if browser_label == :firefox
      profile = Selenium::WebDriver::Firefox::Profile.new
    elsif browser_label == :chrome
      profile = Selenium::WebDriver::Chrome::Profile.new
    else
      raise "Changing default language is currently supported only for Firefox and Chrome!"
    end
    profile['intl.accept_languages'] = language
    Watir::Browser.new browser_label, :profile => profile
  end
end
def sauce_api(json, saucelabs_username, saucelabs_key)
  %x{curl -H 'Content-Type:text/json' -s -X PUT -d '#{json}' http://#{saucelabs_username}:#{saucelabs_key}@saucelabs.com/rest/v1/#{saucelabs_username}/jobs/#{$session_id}}
end
def sauce_browser(test_name, saucelabs_username, saucelabs_key, language)
  config = YAML.load_file('config/config.yml')
  browser_label = config[ENV['BROWSER_LABEL']]

  if language == 'default'
    caps = Selenium::WebDriver::Remote::Capabilities.send(browser_label['name'])
  elsif browser_label['name'] == 'firefox'
    profile = Selenium::WebDriver::Firefox::Profile.new
    profile['intl.accept_languages'] = language
    caps = Selenium::WebDriver::Remote::Capabilities.firefox(:firefox_profile => profile)
  elsif browser_label['name'] == 'chrome'
    profile = Selenium::WebDriver::Chrome::Profile.new
    profile['intl.accept_languages'] = language
    caps = Selenium::WebDriver::Remote::Capabilities.chrome('chrome.profile' => profile.as_json['zip'])
  end

  caps.platform = browser_label['platform']
  caps.version = browser_label['version']
  caps[:name] = "#{test_name} #{ENV['JOB_NAME']}##{ENV['BUILD_NUMBER']}"

  require 'selenium/webdriver/remote/http/persistent' # http_client
  browser = Watir::Browser.new(
    :remote,
    http_client: Selenium::WebDriver::Remote::Http::Persistent.new,
    url: "http://#{saucelabs_username}:#{saucelabs_key}@ondemand.saucelabs.com:80/wd/hub",
    desired_capabilities: caps)

  browser.wd.file_detector = lambda do |args|
    # args => ['/path/to/file']
    str = args.first.to_s
    str if File.exist?(str)
  end

  browser
end
def secret_yml_location
  secret_yml_locations = ['/private/wmf/', 'config/']
  secret_yml_locations.each do |secret_yml_location|
    return secret_yml_location if File.exists?("#{secret_yml_location}secret.yml")
  end
  nil
end
def test_name(scenario)
  if scenario.respond_to? :feature
    "#{scenario.feature.name}: #{scenario.name}"
  elsif scenario.respond_to? :scenario_outline
    "#{scenario.scenario_outline.feature.name}: #{scenario.scenario_outline.name}: #{scenario.name}"
  end
end

config = YAML.load_file('config/config.yml')
mediawiki_username = config['mediawiki_username']

unless secret_yml_location == nil
  secret = YAML.load_file("#{secret_yml_location}secret.yml")
  mediawiki_password = secret['mediawiki_password']
end

if ENV['ENVIRONMENT'] == 'cloudbees'
  saucelabs_username = secret['saucelabs_username']
  saucelabs_key = secret['saucelabs_key']
end

Before('@language') do |scenario|
  @language = true
  @saucelabs_username = saucelabs_username
  @saucelabs_key = saucelabs_key
  @scenario = scenario
end
Before('@login') do
  puts "secret.yml file at /private/wmf/ or config/ is required for tests tagged @login" if secret_yml_location == nil
end

Before do |scenario|
  @config = config
  @does_not_exist_page_name = Random.new.rand.to_s
  @mediawiki_username = mediawiki_username
  @mediawiki_password = mediawiki_password
  if ENV['REUSE_BROWSER'] == 'true' and $browser then
    @browser = $browser
  else
    @browser = browser(environment, test_name(scenario), saucelabs_username, saucelabs_key, 'default')
    $browser = @browser
  end
  $session_id = @browser.driver.instance_variable_get(:@bridge).session_id
end

After do |scenario|
  if environment == :cloudbees
    sauce_api(%Q{{"passed": #{scenario.passed?}}}, saucelabs_username, saucelabs_key)
    sauce_api(%Q{{"public": true}}, saucelabs_username, saucelabs_key)
  end
  @browser.close unless ENV['KEEP_BROWSER_OPEN'] == 'true' or ENV['REUSE_BROWSER'] == 'true'
end

at_exit do
  $browser.close unless ENV['KEEP_BROWSER_OPEN'] == 'true'
end
