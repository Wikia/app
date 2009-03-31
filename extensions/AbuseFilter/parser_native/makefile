# Copyright (c) 2008 Andrew Garrett.
# Copyright (c) 2008 River Tarnell <river@wikimedia.org>
# Derived from public domain code contributed by Victor Vasiliev.
#
# Permission is granted to anyone to use this software for any purpose,
# including commercial applications, and to alter it and redistribute it
# freely. This software is provided 'as-is', without any express or
# implied warranty.

include makefile.config

CPPFLAGS	= -Iinclude $(EXTRA_CPPFLAGS)
LDFLAGS		= $(EXTRA_LDFLAGS)

LIBS		= -lboost_regex$(BOOST_TAG) -lboost_date_time$(BOOST_TAG) -lgmp -lgmpxx -licuuc -licui18n -licudata

af_expr_objs =				\
	af_expr-eval.o			\
	af_expr-parser.o		\
	af_expr-ast.o			\
	af_expr-filter_evaluator.o	\
	af_expr-equiv.o			\
	af_expr-request.o

af_parser_objs =			\
	af_parser-main.o		\
	af_parser-request.o		\
	af_parser-parser.o		\
	af_parser-ast.o			\
	af_parser-filter_evaluator.o	\
	af_parser-equiv.o

check_objs = 				\
	check-check.o			\
	check-parser.o			\
	check-ast.o			\
	check-filter_evaluator.o	\
	check-equiv.o

syntax_check_objs = 			\
	syntax_check-equiv.o		\
	syntax_check-parser.o		\
	syntax_check-ast.o		\
	syntax_check-filter_evaluator.o	\
	syntax_check-syntax_check.o

expr_objs = 				\
	expr-equiv.o			\
	expr-parser.o			\
	expr-ast.o			\
	expr-expr.o

xml_objs = 				\
	xml-parser.o			\
	xml-ast.o			\
	xml-xml.o

evaluate_objs = 			\
	evaluate-equiv.o		\
	evaluate-parser.o		\
	evaluate-ast.o			\
	evaluate-filter_evaluator.o	\
	evaluate-evaluate.o

maketest_objs = 			\
	maketest-maketest.o

progs = check af_parser syntax_check af_expr expr evaluate xml maketest

all: $(progs)

af_expr: $(af_expr_objs)
	$(CXX) $(CXXFLAGS) -o $@ $(af_expr_objs) $(LDFLAGS) $(LIBS)
af_parser: $(af_parser_objs)
	$(CXX) $(CXXFLAGS) -o $@ $(af_parser_objs) $(LDFLAGS) $(LIBS)
check: $(check_objs)
	$(CXX) $(CXXFLAGS) -o $@ $(check_objs) $(LDFLAGS) $(LIBS)
syntax_check: $(syntax_check_objs)
	$(CXX) $(CXXFLAGS) -o $@ $(syntax_check_objs) $(LDFLAGS) $(LIBS)
expr: $(expr_objs)
	$(CXX) $(CXXFLAGS) -o $@ $(expr_objs) $(LDFLAGS) $(LIBS)
evaluate: $(evaluate_objs)
	$(CXX) $(CXXFLAGS) -o $@ $(evaluate_objs) $(LDFLAGS) $(LIBS)
xml: $(xml_objs)
	$(CXX) $(CXXFLAGS) -o $@ $(xml_objs) $(LDFLAGS) $(LIBS)
maketest: $(maketest_objs)
	$(CXX) $(CXXFLAGS) -o $@ $(maketest_objs) $(LDFLAGS)

$(af_expr_objs): af_expr-%.o: %.cpp
	$(CXX) $(CPPFLAGS) $(CXXFLAGS) -o $@ -c $(@:af_expr-%.o=%.cpp)

$(af_parser_objs): af_parser-%.o: %.cpp
	$(CXX) $(CPPFLAGS) $(CXXFLAGS) -o $@ -c $(@:af_parser-%.o=%.cpp)

$(check_objs): check-%.o: %.cpp
	$(CXX) $(CPPFLAGS) $(CXXFLAGS) -o $@ -c $(@:check-%.o=%.cpp)

$(syntax_check_objs): syntax_check-%.o: %.cpp
	$(CXX) $(CPPFLAGS) $(CXXFLAGS) -o $@ -c $(@:syntax_check-%.o=%.cpp)

$(expr_objs): expr-%.o: %.cpp
	$(CXX) $(CPPFLAGS) $(CXXFLAGS) -o $@ -c $(@:expr-%.o=%.cpp)

$(evaluate_objs): evaluate-%.o: %.cpp
	$(CXX) $(CPPFLAGS) $(CXXFLAGS) -o $@ -c $(@:evaluate-%.o=%.cpp)

$(xml_objs): xml-%.o: %.cpp
	$(CXX) $(CPPFLAGS) $(CXXFLAGS) -o $@ -c $(@:xml-%.o=%.cpp)

$(maketest_objs): maketest-%.o: %.cpp
	$(CXX) $(CPPFLAGS) $(CXXFLAGS) -o $@ -c $(@:maketest-%.o=%.cpp)

test: maketest af_parser
	cd tests && ../runtests.sh

clean:
	rm -f *.o $(progs)

clean-final:
	rm -f $(progs)

.SUFFIXES: .cpp .o
