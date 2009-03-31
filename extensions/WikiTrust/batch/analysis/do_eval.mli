(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, B. Thomas Adler, Vishwanath Raman, Ian Pye

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice,
this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
this list of conditions and the following disclaimer in the documentation
and/or other materials provided with the distribution.

3. The names of the contributors may not be used to endorse or promote
products derived from this software without specific prior written
permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.

 *)


(** [do_single_eval factory in_file out_file] evaluates the xml dump [in_file] via the page factory 
    [factory], writing the resulting output in [out_file]. *)
val do_single_eval : Page_factory.page_factory -> in_channel -> out_channel -> unit

(** [do_multi_eval in_files factory working_dir unzip_cmd continue] evaluates all 
    the wiki xml dumps in [in_files], using [factory].  It stores the output in 
    [working_dir], using extension ".out".  It also uses [working_dir] to store 
    uncompressed wiki files, if needed.  If needed, uses [unzip_cmd] to expand 
    the Wiki files before working on them.  If flag [continue] is used, then 
    it does not stop in case of errors during the evaluation of one of the files. 
    The function returns a Vec of the output files it generated. *)
val do_multi_eval :
  string Vec.t -> Page_factory.page_factory -> string -> string -> bool -> string Vec.t

