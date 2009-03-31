/*
 * Copyright (c) 2008 Andrew Garrett.
 * Copyright (c) 2008 River Tarnell <river@wikimedia.org>
 * Derived from public domain code contributed by Victor Vasiliev.
 *
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or
 * implied warranty.
 */

#include	<boost/spirit/core.hpp>
#include	<boost/spirit/utility/confix.hpp>
#include	<boost/spirit/utility/chset.hpp>
#include	<boost/spirit/utility/loops.hpp>
#include	<boost/spirit/tree/ast.hpp>
#include	<boost/spirit/tree/tree_to_xml.hpp>
#include	<boost/spirit/symbols.hpp>
#include	<boost/spirit/utility/escape_char.hpp>
#include	<boost/function.hpp>
#include	<boost/noncopyable.hpp>
#include	<boost/format.hpp>
#include	<boost/regex/icu.hpp>

#include	"parser.h"
#include	"ast.h"

/*
 *                    ABUSEFILTER EXPRESSION PARSER
 *                    =============================
 *
 * This is the basic expression parser.  It doesn't contain any AF logic
 * itself, but rather presents an interface for the user to add custom
 * functions and variables.
 *
 * The interface to the parser is the 'expressor' class.  Use it like this:
 *
 *   expressor e;
 *   e.add_variable("ONE", 1);
 *   e.add_function("f", myfunc);
 *   e.evaluate("ONE + 2");     -- returns 3 
 * 
 * Custom functions should have the following prototype:
 *
 *   afp::u32datum (std::vector<afp::u32datum> const &args);
 *
 * Functions must return a value; they cannot be void.  The arguments passed to
 * the function are stored in the 'args' array in left-to-right order.
 *
 * The parser implements a C-like grammar with some differences.  The following
 * operators are available:
 *
 *   a & b		true if a and b are both true
 *   a | b		true if either a or b is true
 *   a ^ b		true if either a or b is true, but not if both are true
 *   a + b		arithmetic
 *   a - b
 *   a * b
 *   a / b
 *   a % b
 *   a ** b		power-of (a^b)
 *   a in b		true if the string "b" contains the substring "a"
 *   a contains b	true if b contains the string a
 *   a like b		true if a matches the Unix glob b
 *   a matches b	'' ''
 *   a rlike b		true if a matches the Perl regex b
 *   a regex b		'' ''
 *   !a			true if a is false
 *   (a)		same value as a
 *   a ? b : c		if a is true, returns the value of b, otherwise c
 *   a == b		comparison operators
 *   a != b
 *   a < b
 *   a <= b
 *   a > b
 *   a >= b
 *   a === b		returns true if a==b and both are the same type
 *   a !== b		return true if a != b or they are different types
 *
 * The parser uses afp::datum for its variables.  This means it supports
 * strings, ints and floats, with automatic conversion between types.
 *
 * String constants are C-style.  The standard C escapes \a \b \f \t \r \n \v are
 * supported.  \xHH encodes a 1-byte Unicode character, \uHHHH encodes a 2-byte
 * Unicode characters, and \UHHHHHHHH encodes a 4-byte Unicode character.
 *
 * Numeric constants can be integers (e.g. 1), or floating pointers (e.g.
 * 1., .1, 1.2).
 *
 * Function calls are f(arg1, arg2, ...).  
 */

namespace afp {

using namespace boost::spirit;

/*
 * The grammar itself.
 */
struct parser_grammar : public grammar<parser_grammar>
{
	parser_state &state_;

	void add_variable(u32fray const &name, u32datum const &value) {
		state_.variables.add(name.c_str(), value);
	}

	void add_function(
			u32fray name,
			boost::function<u32datum (std::vector<u32datum>)> func) {
		state_.functions.add(name.c_str(), func);
	}

	symbols<int, UChar32> eq_opers, ord_opers, plus_opers, mult_opers, in_opers, bool_opers;

	parser_grammar(parser_state &state) : state_(state) {
		eq_opers.add("=", 0);
		eq_opers.add("==", 0);
		eq_opers.add("===", 0);
		eq_opers.add("!=", 0);
		eq_opers.add("!==", 0);
		eq_opers.add("/=", 0);
		ord_opers.add("<", 0);
		ord_opers.add("<=", 0);
		ord_opers.add(">", 0);
		ord_opers.add(">=", 0);
		plus_opers.add("+", 0);
		plus_opers.add("-", 0);
		mult_opers.add("*", 0);
		mult_opers.add("/", 0);
		mult_opers.add("%", 0);
		bool_opers.add("&", 0);
		bool_opers.add("|", 0);
		bool_opers.add("^", 0);
		in_opers.add("in", 0);
		in_opers.add("contains", 0);
		in_opers.add("matches", 0);
		in_opers.add("like", 0);
		in_opers.add("rlike", 0);
		in_opers.add("regex", 0);
		state_.time_units.add("seconds", tval_seconds);
		state_.time_units.add("minutes", tval_minutes);
		state_.time_units.add("hours", tval_hours);
		state_.time_units.add("days", tval_days);
		state_.time_units.add("weeks", tval_weeks);
		state_.time_units.add("years", tval_years);
		state_.time_units.add("second", tval_seconds);
		state_.time_units.add("minute", tval_minutes);
		state_.time_units.add("hour", tval_hours);
		state_.time_units.add("day", tval_days);
		state_.time_units.add("week", tval_weeks);
		state_.time_units.add("year", tval_years);
	}

	template<typename ScannerT>
	struct definition
	{
		parser_grammar const &self_;
 
		definition(parser_grammar const &self) 
		: self_(self)
		{
			/*
			 * A literal value.  Either a string, a floating
			 * pointer number or an integer.
			 */
			value = 
				  reduced_node_d[ lexeme_d[
				  	  (+chset<>("0-9") >> '.' >> +chset<>("0-9"))
					| (                   '.' >> +chset<>("0-9"))
					| (+chset<>("0-9") >> '.'                   )
				  ] ]
				| as_lower_d[ leaf_node_d[
					  +chset<>("0-7") >> 'o'
					| +chset<>("0-9a-f") >> 'x'
					| +chset<>("0-1") >> 'b'
					| +chset<>("0-9")
				] ]
				| date
				| string
				;

			hexchar = chset<>("a-fA-F0-9")
				;

			octchar = chset<>("0-7")
				;

			c_string_char =
				  "\\x" >> hexchar >> hexchar
				| "\\u" >> repeat_p(4)[hexchar]
				| "\\U" >> repeat_p(8)[hexchar]
				| "\\o" >> octchar >> octchar >> octchar
				| "\\" >> anychar_p - (ch_p('x') | 'u' | 'o')
				| anychar_p - (ch_p('"') | '\\')
				;

			string = inner_node_d[
					   '"'
					>> leaf_node_d[ *(c_string_char) ]
					>> '"'
				]
				;

			date =
				inner_node_d[
					   '"'
					>> leaf_node_d[ *(anychar_p - '"') ]
					>> "\"d"
				]
				;

			/*
			 * A variable.  If the variable is found in the
			 * user-supplied variable list, we use that.
			 * Otherwise, unknown variables (containing uppercase
			 * letters and underscore only) are returned as the
			 * empty string.
			 */
			variable = reduced_node_d[ +(upper_p | '_') ]
				;

			/*
			 * A function call: func([arg[, arg...]]).
			 */
			function = 
				  (
					   root_node_d[ reduced_node_d[
					   	+(lower_p | '_')
					   ] ]
					>> inner_node_d[
						   '('
						>> ( tern_expr % discard_node_d[ch_p(',')] )
						>> ')'
					   ]
				  )
				;

			if_then_expr =
				   root_node_d[ str_p("if") ]
				>> tern_expr
				>> discard_node_d[ str_p("then") ]
				>> tern_expr
				>> discard_node_d[ str_p("else") ]
				>> tern_expr
				>> discard_node_d[ str_p("end") ]
				;

			/*
			 * A basic atomic value.  Either a variable, function
			 * or literal, or a negated expression !a, or a
			 * parenthesised expression (a).
			 */
			basic =
				  value
				| variable
				| function
				| if_then_expr
				| inner_node_d[ '(' >> tern_expr >> ')' ]
				| root_node_d[ch_p('!')] >> tern_expr
				| root_node_d[ch_p('+')] >> tern_expr 
				| root_node_d[ch_p('-')] >> tern_expr
				;

			time_unit =
				   basic
				>> !( root_node_d[ self.state_.time_units ] )
				;

			/*
			 * "a in b" operator
			 */
			in_expr = 
				  time_unit
				>> *( root_node_d[ self.in_opers ] >> time_unit )
				;

			/*
			 * power-of.  This is right-associative. 
			 */
			pow_expr =
				   in_expr
				>> !( root_node_d[ str_p("**") ] >> pow_expr )
				;

			/*
			 * Multiplication and operators with the same
			 * precedence.
			 */
			mult_expr =
				   pow_expr
				>> *( root_node_d[ self.mult_opers ] >> pow_expr )
				;

			/*
			 * Additional and operators with the same precedence.
			 */
			plus_expr =
				   mult_expr
				>> *( root_node_d[ self.plus_opers ] >> mult_expr )
				;

			/*
			 * Ordinal comparisons and operators with the same
			 * precedence.
			 */
			ord_expr  =
				   plus_expr
				>> *( root_node_d[ self.ord_opers ] >> plus_expr )
				;

			/*
			 * Equality comparisons.
			 */
			eq_expr =
				   ord_expr
				>> *( root_node_d[ self.eq_opers ] >> ord_expr )
				;

			/*
			 * Boolean expressions.
			 */
			bool_expr =
				  eq_expr
				>> *( root_node_d[ self.bool_opers ] >> eq_expr )
				;

			comma_expr =
				   bool_expr
				>> *( root_node_d[ str_p(",") ] >> bool_expr )
				;

			/*
			 * The ternary operator.  Notice this is
			 * right-associative: a ? b ? c : d : e
			 * is supported.
			 */
			tern_expr =
				   comma_expr
				>> !(
					   root_node_d[ch_p('?')] >> tern_expr
					>> discard_node_d[ch_p(':')] >> tern_expr
				   )
				;


		}

		rule<ScannerT, parser_context<>, parser_tag<pid_tern_expr> >
		const &start() const {
			return tern_expr;
		}

		rule<ScannerT> c_string_char, hexchar, octchar;
		rule<ScannerT, parser_context<>, parser_tag<pid_value> > value;
		rule<ScannerT, parser_context<>, parser_tag<pid_variable> > variable;
		rule<ScannerT, parser_context<>, parser_tag<pid_basic> > basic;
		rule<ScannerT, parser_context<>, parser_tag<pid_bool_expr> > bool_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_ord_expr> > ord_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_eq_expr> > eq_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_pow_expr> > pow_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_mult_expr> > mult_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_plus_expr> > plus_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_in_expr> > in_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_date> > date;
		rule<ScannerT, parser_context<>, parser_tag<pid_time_unit> > time_unit;
		rule<ScannerT, parser_context<>, parser_tag<pid_comma_expr> > comma_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_ifthen> > if_then_expr;

		rule<ScannerT, parser_context<>, parser_tag<pid_function> > function;
		rule<ScannerT, parser_context<>, parser_tag<pid_tern_expr> > tern_expr;
		rule<ScannerT, parser_context<>, parser_tag<pid_string> > string;
	};
};

expressor::expressor()
{
	grammar_ = new parser_grammar(state_);
	/*
	 * We provide a couple of standard variables everyone wants.
	 */
	add_variable(make_astring<UChar32>("true"), afp::u32datum::from_int(true));
	add_variable(make_astring<UChar32>("false"), afp::u32datum::from_int(false));

	/*
	 * The cast functions.
	 */
	add_function(make_astring<UChar32>("int"), &f_int<UChar32>);
	add_function(make_astring<UChar32>("string"), &f_string<UChar32>);
	add_function(make_astring<UChar32>("float"), &f_float<UChar32>);
}

expressor::~expressor()
{
	delete grammar_;
}

/*
 * The user interface to evaluate an expression.  It returns the result, or
 * throws an exception if an error occurs.
 */
u32datum
expressor::evaluate(u32fray const &filter) const
{
	using namespace boost::spirit;

	typedef u32fray::const_iterator iterator_t;

	u32datum ret;

	tree_parse_info<iterator_t> info = ast_parse(filter.begin(), filter.end(), *grammar_ >> end_p,
			chset<>("\r\n\t ") | comment_p("/*", "*/"));

	if (info.full) {
		ast_evaluator ae(state_);
		return ae.tree_eval(info.trees.begin());
	} else {
		throw parse_error("parsing failed");
	}
}

void
expressor::print_xml(std::ostream &strm, u32fray const &filter) const
{
	using namespace boost::spirit;

	typedef u32fray::const_iterator iterator_t;

	tree_parse_info<iterator_t> info = ast_parse(filter.begin(), filter.end(), *grammar_ >> end_p,
			+chset<>("\n\t ") | comment_p("/*", "*/"));

	if (info.full) {
		std::map<parser_id, std::string> rule_names;
		rule_names[pid_value] = "value";
		rule_names[pid_variable] = "variable";
		rule_names[pid_basic] = "basic";
		rule_names[pid_bool_expr] = "bool_expr";
		rule_names[pid_ord_expr] = "ord_expr";
		rule_names[pid_eq_expr] = "eq_expr";
		rule_names[pid_pow_expr] = "pow_expr";
		rule_names[pid_mult_expr] = "mult_expr";
		rule_names[pid_plus_expr] = "plus_expr";
		rule_names[pid_in_expr] = "in_expr";
		rule_names[pid_function] = "function";
		rule_names[pid_tern_expr] = "tern_expr";
		rule_names[pid_string] = "string";
		rule_names[pid_date] = "date";
		rule_names[pid_time_unit] = "time_unit";
		rule_names[pid_comma_expr] = "comma_expr";
		rule_names[pid_ifthen] = "if_then_expr";
		tree_to_xml(strm, info.trees, "", rule_names);
	} else {
		throw parse_error("parsing failed");
	}
}

void
expressor::clear()
{
	clear_variables();
	clear_functions();
}

void
expressor::clear_variables()
{
	symbols<u32datum, UChar32> variables;
	state_.variables = variables;
}

void
expressor::clear_functions()
{
	symbols<boost::function<u32datum (std::vector<u32datum>)>, UChar32> functions;
	state_.functions = functions;
}

void
expressor::add_variable(u32fray const &name, u32datum const &value)
{
	grammar_->add_variable(name, value);
}

void
expressor::add_function(u32fray const &name, func_t value)
{
	grammar_->add_function(name, value);
}

} // namespace afp
