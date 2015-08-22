require 'sass'

module WikiaFunctions
	def get_command_line_param(paramName, defaultResult="")
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
