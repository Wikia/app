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
type index_t 
val print_chunks : word array array -> unit

(** [make_index_diff words2] makes an index of [words2] suitable for 
    a call to [edit_diff words1 words2 index2] *) 
val make_index_diff : word array -> index_t

(** [edit_diff words1 words2 index2] returns the edit list from 
    [words1] to [words2] given [index2]. *)
val edit_diff : word array -> word array -> index_t -> Editlist.edit list

(** [text_tracking chunks1 words2] takes an array of text [chunks1], 
    and a new word [words2], and produces a new list of chunks [chunks2], 
    and a list of matches that pair up the new text with the old one. 
    chunks2.(0) is guaranteed to exist (but it might be empty). *)
val text_tracking: word array array -> word array -> (word array array * Editlist.medit list)

(** OBSOLETE and deprecated. 
    [text_survival words1 words1_attr dead_chunks dead_chunks_attr words2] 
    takes a piece of text [words1], where each word has its own attribute,
    specified in [words1_attr], and a list of dead chunks [dead_chunks] with 
    their attributes, in [dead_chunks_attr], and a list of new words [words2],
    representing the successive version of the text.  
    The function matches [words2] with [words1] and [dead_chunks], producing 
    [dead_chunks_2].  It also creates attributes for [words2] and 
    [dead_chunks_2], as follows: 
    - the function [f_inherit live1 live2] specifies how to compute an attribute of 
      version 2 ([words2] or [dead_chunks_2]) from one of version 1
      ([words1] or [dead_chunks]), given two flags [live1] and [live2] that 
      specify whether the text is live or dead in versions 1 and 2. 
    - the constant [c_new] specifies an attribute of new text
      for [words2]. 

    It also takes a function attr_inherit, which specifies how attributes 
    are modified when inherited from one revision to the next
 *)
val text_survival :
  word array ->
  'a array ->
  word array list -> 
  'a array list ->
  word array ->
  (bool -> bool -> 'a -> 'a) ->
  'a -> 'a array * word array list * 'a array list

