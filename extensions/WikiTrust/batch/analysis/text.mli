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

(** Version number of the code *)
val version: string

type word = string
(** The type of words *)

type sep_t =
    (** The type of word tokens *)
    Title_start of string * int
      (** start sequence for a title *)
  | Title_end of string * int
      (** end sequence for a title *)
  | Par_break of string
      (** paragraph break sequence *)
  | Bullet of string * int
      (** bullet sequence *)
  | Indent of string * int
      (** indentation sequence *)
  | Space of string
      (** normal whitespace, without a newline *)
  | Newline of string 
      (** whitespace containing a newline char *)
  | Armored_char of string * int 
      (** Armored char such as &nbsp; *)
  | Table_line of string * int 
      (** table tag that needs to be alone on a line *)
  | Table_cell of string * int 
      (** table tag that signals the start of a cell *)
  | Table_caption of string * int 
      (** table tag for the caption *)
  | Tag of string * int
      (** tag, along with the position in the word array *)
  | Word of string * int
      (** normal word, along with the position in the word array *)
  | Redirect of string * int
      (** redirection tag, along with the position in the word array *)

val split_into_words : bool -> string Vec.t -> word array
  (** [split_into_words arm sv] splits a Vec of strings [sv] into an array of words.
      [arm] denotes whether < and > have to be rearmed into &lt; and &gt; 
      Used for reputation analysis. *)

val split_into_words_seps_and_info : 
  bool -> string Vec.t -> ((word array) * (float array) * (int array) * (string array)
                           * (int array) * (sep_t array))
  (** [split_into_words_seps_and_info arm sv] splits a Vec of strings [sv] into:
   - an array of words (excluding separators, such as white space, etc)
   - an array of trust values of words (float) 
   - an array of origins of words (int) 
   - an array of authors of words (string)
   - an array giving, for each word, its place in the sep array (int)
   - the array of seps, where words, etc, have their position in the word array 
     annotated. 
   [arm] denotes whether < and > have to be rearmed into &lt; and &gt; 
*)

val print_words : word array -> unit
  (** [print_words wa] prints the words in the word array [wa]. *)

val print_seps : sep_t array -> unit 
  (** [print_seps wa] prints the array of separators [wa] *)

val print_words_and_seps : (word array) -> (sep_t array) -> unit
  (** [print_words_and_seps ws sp] prints the array of words [ws] and the array of separators [wa] *)


