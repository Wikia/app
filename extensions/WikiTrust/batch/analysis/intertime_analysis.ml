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


(** This simple page class is used to analyze the inter-edit time distribution. *)

type word = string 
open Eval_defs
exception Timestamps_not_in_order

class page 
  (id: int)
  (title: string)
  (out_file: out_channel)
  = 
  let max_bin = 11 in  
  object (self)
    val mutable last_time : float option = None 
    val mutable last_uid : int option = None
    val mutable histogram : int array = Array.make (max_bin + 1) 0 (* Histogram, every bin is 5 mins *) 

    method add_revision 
      (id: int) (* revision id *)
      (page_id: int) (* page id *)
      (timestamp: string) (* timestamp string *)
      (time: float) (* time, as a floating point *)
      (contributor: string) (* name of the contributor *)
      (user_id: int) (* user id *)
      (ip_addr: string)
      (username: string) (* name of the user *)
      (is_minor: bool) 
      (comment: string)
      (text_init: string Vec.t) (* Text of the revision, still to be split into words *)
      : unit =
      let do_analysis = 
	match last_uid with 
	  None -> true 
	| Some u -> u <> user_id
      in 
      last_uid <- Some user_id; 

      if do_analysis then begin
	begin 
	  match last_time with 
	    None -> histogram.(max_bin) <- histogram.(max_bin) + 1
	  | Some prev_time -> 
	      let delta = time -. prev_time in 
	      let bin_idx = min 11 (int_of_float (delta /. 300.0)) in 
	      if bin_idx < 0 
	      then Printf.fprintf out_file "\nTimestamps not in order: %f seconds, orig time: %f  last time: %f" delta prev_time time
	      else histogram.(bin_idx) <- histogram.(bin_idx) + 1
	end;
	last_time <- Some time
      end


    method print_id_title = 
      Printf.fprintf out_file "\nPage: %i Title: %S" id title; 
      flush out_file


    method eval = 
      Printf.fprintf out_file "\n%d:" id; 
      for i = 0 to max_bin do Printf.fprintf out_file " %d" histogram.(i) done; 
      flush stdout

  end (* page *)

