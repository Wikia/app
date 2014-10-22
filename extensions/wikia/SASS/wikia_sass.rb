require 'sass'
require 'base64'

module WikiaFunctions
  def base64_string(dataString, dataType)
    assert_type dataString, :String

    dataString = Base64.encode64(dataString.value).chop

    case dataType.value.downcase
      when "jpg", "jpeg"
        returnVal = "'data:image/jpeg;base64,#{dataString}'"
      when "png"
        returnVal = "'data:image/png;base64,#{dataString}'"
      when "gif"
        returnVal = "'data:image/gif;base64,#{dataString}'"
      when "svg"
        returnVal = "'data:image/svg+xml;charset=utf-8;base64,#{dataString}'"
      else
        returnVal = "'#{dataString}'";
        end
    begin
      Sass::Script::Parser.parse(returnVal, 0, 0)
    rescue
      Sass::Script::String.new(returnVal)
    end
  end

  def get_command_line_param(paramName, defaultResult='')
    assert_type paramName, :String
    retVal = defaultResult.to_s

    # Look through all of the arguments given to the SASS command-line
    ARGV.each do |arg|
        # If it has an '=' in it and there is something to each side, it is one of our key/value pairs
        if arg =~ /.=./
            params = arg.split(/=/)
            key = params.shift
            if(key == paramName.value)
                # Found correct param-name.  Use the values if those exists, default to the passed-in default.
                retVal = params.join('=') || defaultResult
            end
        end
    end
    begin
      Sass::Script::Parser.parse(retVal, 0, 0)
    rescue
      Sass::Script::String.new(retVal)
    end
  end
end

module Sass::Script::Functions
  include WikiaFunctions
end
