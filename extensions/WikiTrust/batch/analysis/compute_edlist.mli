(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro

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

type word = string

(** [zip_edit_lists l1 l2] zips the two edit lists [l1] from t1 to t2, and 
    [l2] from [t2] to [t3], where [t1], [t2], [t3] are text (word arrays), 
    and returns the best possible lower approximation to the edit list 
    from [t1] to [t3]. *)
val zip_edit_lists :
  Editlist.edit list -> Editlist.edit list -> Editlist.edit list

(** [diff_cover l] returns [(n, m)], where [n] is how much of the left
    string is covered, and [m] is how much of the right string is covered. *)
val diff_cover : Editlist.edit list -> int * int

(** [edit_diff_using_zipped_edits t1 t2 l1 l2] returns an edit list 
    from [t1] to [t2], given an edit list [l1] from [t1] to [t3] (for some 
    [t3] that the present algorithm does not need to know), and given 
    an edit list [l2] from [t3] to [t2]. *)
val edit_diff_using_zipped_edits :
  word array ->
  word array ->
  Editlist.edit list -> Editlist.edit list -> Editlist.edit list
