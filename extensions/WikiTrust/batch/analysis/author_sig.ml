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

TYPE_CONV_PATH "UCSC_WIKI_RESEARCH"

open Eval_defs

(** Type of author signature *)
type packed_author_signature_t = int with sexp
type unpacked_author_signature_t = int * int * int
type author_signature_t = int 

let mask = 0o1777
let offset = 10

external hash_param : int -> int -> 'a -> int = "caml_hash_univ_param" "noalloc"
let hash x = 1 + (hash_param 10 100 x) mod 1023

let empty_sigs = 0

(* These are simple versions; I now use a more compact translation
let sexp_of_sigs = Sexplib.Conv.sexp_of_int
let sigs_of_sexp = Sexplib.Conv.int_of_sexp
 *)
let sexp_of_sigs x = 
  let s = Printf.sprintf "%x" x in 
  Sexplib.Conv.sexp_of_string s

let sigs_of_sexp x = 
  let s = Sexplib.Conv.string_of_sexp x in 
  let get_sig y = y in 
  Scanf.sscanf s "%x" get_sig 


let pack (a0: int) (a1: int) (a2: int) : packed_author_signature_t = 
  a0 lor ((a1 lor (a2 lsl offset)) lsl offset)

let unpack (p: packed_author_signature_t) : unpacked_author_signature_t = 
  let a0 = p  land mask in
  let b1 = p  lsr offset in 
  let a1 = b1 land mask in 
  let b2 = b1 lsr offset in 
  let a2 = b2 land mask in 
  (a0, a1, a2)

(** [is_author_in_sigs id w sigs] returns [true] if author [id] is in the signatures [sigs] of 
    word [w], and returns [false] otherwise. *)
let is_author_in_sigs (id: int) (w: string) (sigs: packed_author_signature_t) : bool = 
  if is_anonymous id then true 
  else 
    let (a0, a1, a2) = unpack sigs in 
    let h = hash (id, w) in 
    (h = a0 || h = a1 || h = a2)

(** [add_author id word sigs] adds author id to the signatures [sigs] for word [word], 
    and returns the new signature.  It assumes that the author was not already in the 
    list. *)
let add_author (id: int) (w: string) (sigs: packed_author_signature_t) : packed_author_signature_t = 
  if is_anonymous id then sigs 
  else 
    let (a0, a1, a2) = unpack sigs in 
    let h = hash (id, w) in 
    pack h a0 a1
