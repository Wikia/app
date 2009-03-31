(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, Vishwanath Raman

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

(** RepHist.ml
    This file contains the function used to read the history of user reputations, 
    and to retrieve the user reputations at any point in time. *)

module type OFloat = 
  sig
    type t = float
    val compare: t -> t -> int 
  end    

module OrderedFloat: OFloat = 
  struct
    type t = float 
    let compare x y = 
      if x > y then 1
      else if x < y then -1
      else 0
  end;;

module RepHistory = Intvmap.Make (OrderedFloat);;

exception Invalid_data

class rephist
  =
  object (self)
  
    val histories : (int, (int RepHistory.t) ref) Hashtbl.t = Hashtbl.create 1000 

    method read_reps (rep_channel: in_channel) = 
      let read_rep (t: float) (user_id: int) (prev_rep: int) (next_rep: int) : unit =
	if Hashtbl.mem histories user_id then begin 
	  (* The user is already in the table *)
	  (* Check: prev_rep cannot be -1 *)
	  if prev_rep = -1 then raise Invalid_data; 
	  (* Inserts data in hash table *)
	  let v = Hashtbl.find histories user_id in 
	  v := RepHistory.add t next_rep !v
	end else begin 
	  (* New user *)
	  if prev_rep <> -1 then raise Invalid_data; 
	  let t' = t -. 1.0 in 
	  (* Adds the fact that the reputation used to be 0 before *)
	  let r1 = RepHistory.add t' 0 RepHistory.empty in 
	  let r2 = RepHistory.add t next_rep r1 in 
	  Hashtbl.add histories user_id (ref r2)
	end
      in
      begin
	try
	  while true do begin 
            let l = input_line rep_channel in 
	    Scanf.sscanf l "%f %d %d %d" read_rep
	  end done
	with End_of_file -> ()
      end

    method get_rep (user_id: int) (t: float) : int = 
      try 
	let v = Hashtbl.find histories user_id in 
	let ((t1, r1), (t2, r2)) = RepHistory.bracket t !v in 
	r1
      with 
	(* Non-existent users have no reputation *)
	Not_found -> 0

  end (* rephist object *)
