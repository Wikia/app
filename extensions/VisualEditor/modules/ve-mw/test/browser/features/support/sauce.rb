require 'cucumber/formatter/junit'

module Cucumber::Formatter
  class Sauce < Junit
    def format_exception(exception)
      sauce_job_page = "Sauce Labs job URL: http://saucelabs.com/jobs/#{$session_id}\n"
      ([sauce_job_page] + ["#{exception.message} (#{exception.class})"] + exception.backtrace).join("\n")
    end
  end
end
