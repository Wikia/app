module URL
  def self.url(name)
    if ENV['MEDIAWIKI_URL']
      mediawiki_url = ENV['MEDIAWIKI_URL']
    else
      mediawiki_url = 'http://en.wikipedia.beta.wmflabs.org/wiki/'
    end
    "#{mediawiki_url}#{name}"
  end
end
