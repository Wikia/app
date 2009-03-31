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

#ifndef AST_H
#define AST_H

#include	<boost/spirit/tree/ast.hpp>

#include	"parserdefs.h"

namespace afp {

struct ast_evaluator {
	typedef boost::spirit::tree_match<u32fray::const_iterator>::tree_iterator iterator_t;
	parser_state const &state_;

	ast_evaluator(parser_state const &);

	u32datum tree_eval(iterator_t const &);

	u32datum ast_eval_basic		(UChar32, iterator_t const &);
	u32datum ast_eval_variable	(u32fray const &);
	u32datum ast_eval_in		(UChar32, iterator_t const &, iterator_t const &);
	u32datum ast_eval_bool		(UChar32, iterator_t const &, iterator_t const &);
	u32datum ast_eval_plus		(UChar32, iterator_t const &, iterator_t const &);
	u32datum ast_eval_mult		(UChar32, iterator_t const &, iterator_t const &);
	u32datum ast_eval_pow		(iterator_t const &, iterator_t const &);
	u32datum ast_eval_string	(u32fray const &);
	u32datum ast_eval_date		(u32fray const &);
	u32datum ast_eval_num		(u32fray const &);
	u32datum ast_eval_ord		(u32fray const &, iterator_t const &, iterator_t const &);
	u32datum ast_eval_eq		(u32fray const &, iterator_t const &, iterator_t const &);
	u32datum ast_eval_tern		(iterator_t const &, iterator_t const &, iterator_t const &);
	u32datum ast_eval_function	(u32fray const &, iterator_t, iterator_t const &);
	u32datum ast_eval_time_unit	(u32fray const &, iterator_t const &);
	u32datum ast_eval_comma		(iterator_t const &, iterator_t const &);

};


} // namespace afp

#endif	/* !AST_H */
