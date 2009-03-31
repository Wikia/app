# Copyright (c) 2007-2008 The Regents of the University of California
# All rights reserved.
#
# Authors: Luca de Alfaro, B. Thomas Adler, Ian Pye
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions are met:
#
# 1. Redistributions of source code must retain the above copyright notice,
# this list of conditions and the following disclaimer.
#
# 2. Redistributions in binary form must reproduce the above copyright notice,
# this list of conditions and the following disclaimer in the documentation
# and/or other materials provided with the distribution.
#
# 3. The names of the contributors may not be used to endorse or promote
# products derived from this software without specific prior written
# permission.
#
# THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
# AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
# LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
# CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
# SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
# INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
# CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
# ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
# POSSIBILITY OF SUCH DAMAGE.

# Vars we use in our rules to build ocaml programs
PACKAGES = unix,str,vec,mapmin,hashtbl_bounded,fileinfo,intvmap,extlib,mysql,netsys,netclient,camlzip,xml-light,sexplib.syntax 
SYNTAX = camlp4o
OUR_LIBS = evalwiki.cma
OUR_LIBS_OPT = evalwiki.cmxa
INCLUDES = -I ../batch/analysis

OCAMLC=ocamlfind ocamlc -package $(PACKAGES) -syntax $(SYNTAX)
OCAMLOPT=ocamlfind ocamlopt -package $(PACKAGES) -syntax $(SYNTAX)

OCAMLDEP=ocamlfind ocamldep -package $(PACKAGES) -syntax $(SYNTAX)
OCAMLDOC=ocamldoc

SUFFIXES= .ml .cmo .cmi .cmx

# For profiling
# OCAMLDEBUG = -g -p film 
OCAMLDEBUG = -g


# Flags for commands, depending on optimization/debugging
OCAML_CFLAGS=$(INCLUDES) $(OCAMLDEBUG)
OCAMLOPT_FLAGS=$(INCLUDES)

%.cmo: %.ml
	@echo '$(OCAMLC) $(OCAML_CFLAGS) -c $<'; \
	$(OCAMLC) $(OCAML_CFLAGS) -c $<

%.cmi: %.mli
	@echo '$(OCAMLC) $(OCAML_CFLAGS) -c $<'; \
	$(OCAMLC) $(OCAML_CFLAGS) -c $<

%.cmx: %.ml
	@echo '$(OCAMLOPT) $(OCAMLOPT_FLAGS) -c $<'; \
	$(OCAMLOPT) $(OCAMLOPT_FLAGS) -c $<

.PHONY: all allopt universe clean

# Here are the objects that we want to build. 
# We need two lines of these, one for the debugging compilation,
# one for the optimizing compilation. 
OUR_ONLINE_OBJS = online_types.cmo online_db.cmo online_revision.cmo \
	db_page.cmo online_page.cmo online_log.cmo event_feed.cmo  \
	online_command_line.cmo tmpfile.cmo wikipedia_api.cmo \

OUR_OPT_ONLINE_OBJS = online_types.cmx online_db.cmx online_revision.cmx \
	db_page.cmx online_page.cmx online_log.cmx event_feed.cmx \
	online_command_line.cmx tmpfile.cmx wikipedia_api.cmx \


online_eval: $(OUR_ONLINE_OBJS) 
	$(OCAMLC) -linkpkg -o eval_online_wiki $(OCAML_CFLAGS) $(OUR_LIBS) $(OUR_ONLINE_OBJS) eval_online_wiki.ml 

online_evalopt: $(OUR_OPT_ONLINE_OBJS)
	$(OCAMLOPT) -linkpkg -o eval_online_wiki $(OCAMLOPT_FLAGS) $(OUR_LIBS_OPT) $(OUR_OPT_ONLINE_OBJS) eval_online_wiki.ml

vote_revision: $(OUR_ONLINE_OBJS) 
	$(OCAMLC) -linkpkg -o vote_revision $(OCAML_CFLAGS) $(OUR_LIBS) $(OUR_ONLINE_OBJS) vote_revision.ml 

vote_revisionopt: $(OUR_OPT_ONLINE_OBJS)
	$(OCAMLOPT) -linkpkg -o vote_revision $(OCAMLOPT_FLAGS) $(OUR_LIBS_OPT) $(OUR_OPT_ONLINE_OBJS) vote_revision.ml

server: $(OUR_ONLINE_OBJS) 
	$(OCAMLC) -package "netstring,netcgi2,unix,nethttpd-for-netcgi2,netplex" -linkpkg -o server $(OCAML_CFLAGS) $(OUR_LIBS) $(OUR_ONLINE_OBJS) -thread server.ml 

serveropt: $(OUR_OPT_ONLINE_OBJS)
	$(OCAMLOPT) -package "netstring,netcgi2,unix,nethttpd-for-netcgi2,netplex" -linkpkg -o server $(OCAMLOPT_FLAGS) $(OUR_LIBS_OPT) $(OUR_OPT_ONLINE_OBJS) -thread server.ml 

dispatcher: $(OUR_ONLINE_OBJS) 	
	$(OCAMLC) -linkpkg -o dispatcher $(OCAML_CFLAGS) $(OUR_LIBS) $(OUR_ONLINE_OBJS) server_coloring_dispatcher.ml 

dispatcheropt: $(OUR_OPT_ONLINE_OBJS)
	$(OCAMLOPT) -linkpkg -o dispatcher $(OCAMLOPT_FLAGS) $(OUR_LIBS_OPT) $(OUR_OPT_ONLINE_OBJS) server_coloring_dispatcher.ml

all:
	cd ../batch/analysis; make all
	make online_eval
	make vote_revision
	make server
	make dispatcher

allopt:
	cd ../batch/analysis; make allopt
	make online_evalopt
	make vote_revisionopt
	make serveropt
	make dispatcheropt

universe: all allopt

clean:
	cd ../batch/analysis; make clean
	rm -f *.o *.cmo *.cmx *.cmi .depends run_harness eval_online_wiki vote_revision server dispatcher

# Boilerplate code for building ocaml dependencies.

.depends: *.ml
	$(OCAMLDEP) $^ > $@

-include .depends

