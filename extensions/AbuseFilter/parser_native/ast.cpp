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

#include	<boost/date_time.hpp>
#include	<boost/date_time/date_parsing.hpp>

#include	"parser.h"
#include	"ast.h"

namespace {

int
hex2int(UChar32 const *str, int ndigits)
{
	int ret = 0;

	while (ndigits--) {
		ret *= 0x10;
		if (*str >= 'a' && *str <= 'f')
			ret += 10 + int(*str - 'a');
		else if (*str >= 'A' && *str <= 'F')
			ret += 10 + int(*str - 'A');
		else if (*str >= '0' && *str <= '9')
			ret += int(*str - '0');

		str++;
	}

	return ret;
}

}

namespace afp {

ast_evaluator::ast_evaluator(parser_state const &state)
	: state_(state)
{
}

u32datum
ast_evaluator::ast_eval_time_unit(
		u32fray const &value,
		iterator_t const &child)
{
	int mult = tree_eval(child).toInt().get_si();
	int type = *find(state_.time_units, value.c_str());

	switch (type) {
	case tval_seconds:
		return u32datum::from_interval(
			boost::posix_time::seconds(mult));
	case tval_minutes:
		return u32datum::from_interval(
			boost::posix_time::minutes(mult));
	case tval_hours:
		return u32datum::from_interval(
			boost::posix_time::hours(mult));
	case tval_days:
		return u32datum::from_interval(
			boost::posix_time::hours(mult * 24));
	case tval_weeks:
		return u32datum::from_interval(
			boost::posix_time::hours(mult * 24 * 7));
	case tval_years:
		return u32datum::from_interval(
			boost::posix_time::hours(mult * 24 * 7 * 365));
	default:
		throw parse_error("internal error: unrecognised time unit");
	}
}

u32datum
ast_evaluator::ast_eval_comma(
		iterator_t const &a, iterator_t const &b)
{
	return tree_eval(a) + tree_eval(b);
}

u32datum
ast_evaluator::ast_eval_in(UChar32 oper, iterator_t const &a, iterator_t const &b)
{
	switch (oper) {
	case 'i':
		return f_in(tree_eval(a), tree_eval(b));
	case 'c':
		return f_in(tree_eval(b), tree_eval(a));
	case 'l':
	case 'm':
		return f_like(tree_eval(a), tree_eval(b));
	case 'r':
		return f_regex(tree_eval(a), tree_eval(b));
	default:
		abort();
	}
}

u32datum
ast_evaluator::ast_eval_bool(UChar32 oper, iterator_t const &a, iterator_t const &b)
{
	switch (oper) {
	case '&':
		if (tree_eval(a).toBool())
			if (tree_eval(b).toBool())
				return u32datum::from_int(1);
		return u32datum::from_int(0);
	
	case '|':
		if (tree_eval(a).toBool())
			return u32datum::from_int(1);
		else
			if (tree_eval(b).toBool())
				return u32datum::from_int(1);
		return u32datum::from_int(0);

	case '^': 
		{
			int va = tree_eval(a).toBool(), vb = tree_eval(b).toBool();
			if ((va && !vb) || (!va && vb))
				return u32datum::from_int(1);
			return u32datum::from_int(0);
		}
	}

	abort();
}
			
u32datum
ast_evaluator::ast_eval_plus(UChar32 oper, iterator_t const &a, iterator_t const &b)
{
	switch (oper) {
	case '+':
		return tree_eval(a) + tree_eval(b);

	case '-':
		return tree_eval(a) - tree_eval(b);

	default:
		abort();
	}
}

u32datum
ast_evaluator::ast_eval_mult(UChar32 oper, iterator_t const &a, iterator_t const &b)
{
	switch (oper) {
	case '*':
		return tree_eval(a) * tree_eval(b);
	case '/':
		return tree_eval(a) / tree_eval(b);
	case '%':
		return tree_eval(a) % tree_eval(b);
	default:
		abort();
	}
}

u32datum
ast_evaluator::ast_eval_ord(u32fray const &oper, iterator_t const &a, iterator_t const &b)
{
	switch (oper.size()) {
	case 1:
		switch (oper[0]) {
		case '<':
			return u32datum::from_int(tree_eval(a) < tree_eval(b));
		case '>':
			return u32datum::from_int(tree_eval(a) > tree_eval(b));
		default:
			abort();
		}

	case 2:
		switch(oper[0]) {
		case '<':
			return u32datum::from_int(tree_eval(a) <= tree_eval(b));
		case '>':
			return u32datum::from_int(tree_eval(a) >= tree_eval(b));
		default:
			abort();
		}

	default:
		abort();
	}
}

u32datum
ast_evaluator::ast_eval_eq(u32fray const &oper, iterator_t const &a, iterator_t const &b)
{
	switch (oper.size()) {
	case 1: /* = */
		return u32datum::from_int(tree_eval(a) == tree_eval(b));
	case 2: /* != /= == */
		switch (oper[0]) {
		case '!':
		case '/':
			return u32datum::from_int(tree_eval(a) != tree_eval(b));
		case '=':
			return u32datum::from_int(tree_eval(a) == tree_eval(b));
		default:
			abort();
		}
	case 3: /* === !== */
		switch (oper[0]) {
		case '=':
			return u32datum::from_int(tree_eval(a).compare_with_type(tree_eval(b)));
		case '!':
			return u32datum::from_int(!tree_eval(a).compare_with_type(tree_eval(b)));
		default:
			abort();
		}
	default:
		abort();
	}
}

u32datum
ast_evaluator::ast_eval_pow(iterator_t const &a, iterator_t const &b)
{
	return pow(tree_eval(a), tree_eval(b));
}

u32datum
ast_evaluator::ast_eval_string(u32fray const &s)
{
	std::vector<UChar32> ret;
	ret.reserve(int(s.size() * 1.2));

	for (std::size_t i = 0, end = s.size(); i < end; ++i) {
		if (s[i] != '\\') {
			ret.push_back(s[i]);
			continue;
		}

		if (i+1 == end)
			break;

		switch (s[i + 1]) {
		case 't':
			ret.push_back('\t');
			break;
		case 'n':
			ret.push_back('\n');
			break;
		case 'r':
			ret.push_back('\r');
			break;
		case 'b':
			ret.push_back('\b');
			break;
		case 'a':
			ret.push_back('\a');
			break;
		case 'f':
			ret.push_back('\f');
			break;
		case 'v':
			ret.push_back('\v');
			break;
		case 'x':
			if (i + 3 >= end)
				break;
			ret.push_back(hex2int(s.data() + i + 2, 2));
			i += 2;
			break;

		case 'u':
			if (i + 5 >= end)
				break;
			ret.push_back(hex2int(s.data() + i + 2, 4));
			i += 4;
			break;

		case 'U':
			if (i + 9 >= end)
				break;
			ret.push_back(hex2int(s.data() + i + 2, 8));
			i += 8;
			break;

		default:
			ret.push_back(s[i + 1]);
			break;
		}

		i++;
	}

	return u32datum::from_string(u32fray(ret.begin(), ret.end()));
}

u32datum
ast_evaluator::ast_eval_tern(iterator_t const &cond, iterator_t const &iftrue, iterator_t const &iffalse)
{
	if (tree_eval(cond).toBool())
		return tree_eval(iftrue);
	else
		return tree_eval(iffalse);
}

u32datum
ast_evaluator::ast_eval_num(u32fray const &s)
{
	if (s.find('.') != u32fray::npos) {
		return u32datum::from_double(u32datum::float_t(make_u8fray(s).c_str()));
	}

	int base;
	int trim = 1;
	switch (s[s.size() - 1]) {
	case 'x':
		base = 16;
		break;
	case 'o':
		base = 8;
		break;
	case 'b':
		base = 2;
		break;
	default:
		base = 10;
		trim = 0;
		break;
	}

	fray t(make_u8fray(s));
	std::string str(t.begin(), t.end() - trim);
	return u32datum::from_int(u32datum::integer_t(str, base));
}

u32datum
ast_evaluator::ast_eval_function(u32fray const &f, iterator_t abegin, iterator_t const &aend)
{
	std::vector<u32datum > args;

	for (; abegin != aend; ++abegin)
		args.push_back(tree_eval(abegin));

	boost::function<u32datum (std::vector<u32datum>)> *fptr;
	if ((fptr = find(state_.functions, f.c_str())) == NULL)
		return u32datum::from_string(u32fray());
	else
		return (*fptr)(args);
}

u32datum
ast_evaluator::ast_eval_basic(UChar32 op, iterator_t const &val)
{
	switch (op) {
	case '!':
		if (tree_eval(val).toBool())
			return u32datum::from_int(0);
		else
			return u32datum::from_int(1);

	case '-':
		return -tree_eval(val);

	case '+':
		return tree_eval(val);
	default:
		abort();
	}
}

u32datum
ast_evaluator::ast_eval_variable(u32fray const &v)
{
	u32datum const *var;
	if ((var = find(state_.variables, v.c_str())) == NULL)
		return u32datum::from_string(u32fray());
	else
		return *var;
}

u32datum
ast_evaluator::ast_eval_date(u32fray const &v)
{
	using namespace boost::posix_time;
	return u32datum::from_date(ptime(time_from_string(std::string(v.begin(), v.end()))));
}


u32datum
ast_evaluator::tree_eval(iterator_t const &i)
{
	switch (i->value.id().to_long()) {
	case pid_value:
		return ast_eval_num(
			u32fray(i->value.begin(), i->value.end()));

	case pid_string:
		return ast_eval_string(u32fray(i->value.begin(), i->value.end()));

	case pid_date:
		return ast_eval_date(u32fray(i->value.begin(), i->value.end()));

	case pid_basic:
		return ast_eval_basic(*i->value.begin(), i->children.begin());

	case pid_variable:
		return ast_eval_variable(u32fray(i->value.begin(), i->value.end()));

	case pid_function:
		return ast_eval_function(
				u32fray(i->value.begin(), i->value.end()),
				i->children.begin(), i->children.end());

	case pid_in_expr:
		return ast_eval_in(*i->value.begin(), i->children.begin(), i->children.begin() + 1);

	case pid_bool_expr:
		return ast_eval_bool(*i->value.begin(), i->children.begin(), i->children.begin() + 1);

	case pid_plus_expr:
		return ast_eval_plus(*i->value.begin(), i->children.begin(), i->children.begin() + 1);

	case pid_mult_expr:
		return ast_eval_mult(*i->value.begin(), i->children.begin(), i->children.begin() + 1);

	case pid_pow_expr:
		return ast_eval_pow(i->children.begin(), i->children.begin() + 1);

	case pid_ord_expr:
		return ast_eval_ord(
			u32fray(i->value.begin(), i->value.end()),
			i->children.begin(), i->children.begin() + 1);

	case pid_eq_expr:
		return ast_eval_eq(
			u32fray(i->value.begin(), i->value.end()),
			i->children.begin(), i->children.begin() + 1);

	case pid_tern_expr:
	case pid_ifthen:
		return ast_eval_tern(
				i->children.begin(),
				i->children.begin() + 1,
				i->children.begin() + 2);

	case pid_comma_expr:
		return ast_eval_comma(
				i->children.begin(),
				i->children.begin() + 1);

	case pid_time_unit:
		return ast_eval_time_unit(
				u32fray(i->value.begin(), i->value.end()),
				i->children.begin());

	default:
		throw parse_error(
			str(boost::format("internal error: unmatched expr type %d") % i->value.id().to_long()));
	}
}

} // namespace afp

