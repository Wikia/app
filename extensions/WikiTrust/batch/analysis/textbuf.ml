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


(* Textbuf: text buffers that keep long strings as Vecs of Buffer *)

(* if this bound is reached, a different method is used to split into words *)
let block_len = 50000
(* How much to look ahead for space *)
let space_skip = 100
(* Default length; how long is a page on average? *)
let default_length = 10000


type t = Buffer.t Vec.t

let empty = Vec.empty

(* This is a text buffer containing only an initial cr, useful for wiki analysis *)
let cr () = 
  let b = Buffer.create default_length in 
  Buffer.add_char b '\n'; 
  Vec.singleton b

(* private *)
let string_to_buf (s: string) : Buffer.t = 
  let b = Buffer.create default_length in 
  Buffer.add_string b s; 
  b

(* private *)
let split_if_needed (x: string) : string Vec.t = 
  (* Splits x into pieces, at space locations.  Brutal, but effective. *)
  let x_len = String.length x in 
  if x_len < block_len then Vec.singleton x
  else begin 
    (* Splitting is needed *)
    let accu = ref Vec.empty in 
    (* start_pos, end_pos are the positions of the block to be chopped *)
    let start_pos = ref 0 in 
    while !start_pos < x_len do begin 
      (* Computes the ideal end of a block, after block_len text *)
      let end_pos_ideal = !start_pos + block_len in
      let end_pos = 
	if end_pos_ideal >= x_len 
	  (* go to the end of the text, if within the block *)
	then x_len 
	  (* otherwise, if it falls within a block, looks for a space where to 
	     break the string *) 
	else 
	  let end_pos_space = 
	    try String.index_from x end_pos_ideal ' '
	    with Not_found -> end_pos_ideal 
	  in 
	  if end_pos_space - end_pos_ideal < space_skip
	  then end_pos_space
	  else end_pos_ideal 
      in 
      (* Grabs the string from start_pos to end_pos, splits it, and adds it to the 
	 accumulator *)
      let w = String.sub x !start_pos (end_pos - !start_pos) in 
      accu := Vec.append w !accu; 
      (* Advances the starting position for the split *)
      start_pos := end_pos
    end done; 
    !accu
  end
    

let add (x: string) (b: t) : t = 
  (* Let's do the common case first *)
  let x_len = String.length x in 
  if x_len < block_len then begin 
    if Vec.is_empty b 
    then Vec.singleton (string_to_buf x)
    else begin 
      (* b is non-empty.  Checks whether we can add x to the last buffer, 
	 or whether we have to create a new buffer. *)
      let b_last_idx = (Vec.length b) - 1 in 
      let b_last_el = Vec.get b_last_idx b in 
      let b_last_len = Buffer.length b_last_el in 
      if x_len + b_last_len < block_len 
	(* Short enough: adds x at the end of b_last_el *)
      then begin Buffer.add_string b_last_el x; b end
	(* Not short enough: adds t in a new buffer *)
      else Vec.append (string_to_buf x) b
    end
  end else
    (* x is long, and needs splitting *)
    let sx : string Vec.t = split_if_needed x in 
    Vec.concat b (Vec.map string_to_buf sx)


let get (b: t) : string Vec.t = Vec.map Buffer.contents b
