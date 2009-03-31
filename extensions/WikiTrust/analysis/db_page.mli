(*

Copyright (c) 2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, Ian Pye 

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

open Eval_defs;;
open Online_types;;

(** This class contains methods to read consecutive revisions belonging
    to a page from the database. *)

class page : 
  Online_db.db -> (* Online database containing the pages and revisions *)
  int -> (* page id to which the revisions belong *)
  int -> (* revision id.  This is the first revision to read; after this, 
	    each read operation returns the previous revision (so the
	    read is backwards. *)
  int -> (* number of revisions to fetch, used to limit the query to 
	    the database.  Note that this class can return more (as there 
	    is some slack in the query, see inside the class for details) 
	    or fewer revisions (in case e.g. the page has fewer than the
	    specified number of revisions), so that the caller must still
	    then check on reading that the desired number of revisions
	    is returned. *)
  object
    (* This method gets, every time, the previous revision of the page, 
       starting from the revision id that was given as input. 
       The method returns a revision option, returning either (Some revision) 
       or (None), the latter to indicate that no previous revision was 
       present in the database. *)
    method get_rev : Online_revision.revision option
  end
