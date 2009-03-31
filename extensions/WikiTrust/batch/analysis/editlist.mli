(*

Copyright (c) 2008 The Regents of the University of California
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

(* editlisttypes.ml : this file contains the types related to edit lists *)

(** This is an edit list between two strings *)
type edit = 
    Ins of int * int (* position, length *)
  | Del of int * int (* position, length *)
  | Mov of int * int * int with sexp (* left position, right position, end *)

val print_diff : edit list -> unit

(** This is an edit list between a chunk array, and a string. *)
type medit =
    Mins of int * int 
(* right position in chunk 0, length *)
  | Mdel of int * int * int (* left position, left chunk idx, length *)
  | Mmov of int * int * int * int * int (* left position, left chunk idx, 
					   right pos, right chunk idx, length *)

val print_mdiff : medit list -> unit

(** [edit_distance el n] computes the edit distance between two 
    pieces of text having an edit list [el], and where the minimum length 
    of a string is [n]. *)
val edit_distance : edit list -> int -> float
