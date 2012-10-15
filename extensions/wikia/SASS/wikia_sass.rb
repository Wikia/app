require 'sass'

module WikiaFunctions
	def get_command_line_param(paramName, defaultResult="")
		assert_type paramName, :String
		retVal = defaultResult.to_s

		# Look through all of the arguments given to the SASS command-line
		ARGV.each do |arg|
				# If it has an '=' in it and there is something to each side, it is one of our key/value pairs
				if arg =~ /.=./
						pair = arg.split(/=/)
						if(pair[0] == paramName.value)
								# Found correct param-name.  Use the first value if it exists, default to the passed-in default.
								retVal = pair[1] || defaultResult
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
