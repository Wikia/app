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


(** This simple page class is used to count how many revisions each page has. *)

type word = string 
open Eval_defs

let n_rev_to_keep = 100
let n_revs_to_print = [50; 100]

class page 
  (id: int)
  (title: string)
  (out_file: out_channel)
  (page_seq_n: int) 
  = 
  object (self)

    val mutable n_revisions : int = 0; 
    val mutable total_text : int64 = Int64.zero; 
    val mutable last_ip : string option = None 
    val mutable last_user_id : int option = None 
    val mutable revs : Revision.write_only_revision Vec.t = Vec.empty
    val mutable offset : int = 0
    val mutable last_rev : Revision.write_only_revision option = None 
    val mutable sizes : int list = []
    
    method private find_size_of_last_n_revs n : int = 
      (* Here, we sum up the size of all of the revsions *)
      let n_revs = Vec.length revs in 
      let count = ref 0 in      
      if n_revs > 0 then begin 
        (* Computes the range of revisions to be output *)
        let start_rev = max 0 (n_revs - n) in 
        (* the range is from start_rev to n_revs - 1 *)               
        for rev_idx = start_rev to n_revs - 1 do 
          (* Ok, here we have to output the reduced revision *)
          let r = (Vec.get rev_idx revs) in 
          count := !count + r#get_size;
        done;
      end; (* there is some revision *)
      
    !count  

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
      (* Counts the revision only if it is from a different author than the previous one *)
      let count_this = 
	match last_user_id with 
	  None -> true
	| Some oldid -> begin 
	    if oldid <> user_id
	    then true 
	    else if oldid <> 0 
	    then false
	    else match last_ip with 
	      None -> false
	    | Some oldip -> oldip <> ip_addr
	  end
      in 
      if count_this then begin 
	n_revisions <- n_revisions + 1; 
	let r = new Revision.write_only_revision id page_id timestamp time contributor
    user_id ip_addr username is_minor comment text_init in
  revs <- Vec.append r revs;  
  if (Vec.length revs) > n_rev_to_keep then begin 
                  (* The parameter 0 is the index of what is considered to be the oldest. 
                    It is used, since in no_more_revisions it may be a larger number *)
    revs <- Vec.remove 0 revs; 
    (* increments the offset of the oldest version *)
    offset <- offset + 1 
  end; (* if *)   

  	(* Measures the amount of text *)
	(* Visitor function for string Vec.t that computes the amount of text *)
	let vn l s r = 
	  let sl = Int64.of_int (String.length s) in 
	  Int64.add l (Int64.add sl r)
	in 
	let l = Vec.visit_post Int64.zero vn text_init in 
	total_text <- Int64.add total_text l
      end; 
      last_user_id <- Some user_id; 
      last_ip <- Some ip_addr

    method print_id_title = ()

    method eval = 
      let f n =
        sizes <- (self#find_size_of_last_n_revs n) :: sizes in 
      List.iter f n_revs_to_print; 
      Printf.fprintf out_file "Page_id: %d Seq_n: %d N_revs: %d Text: %s Title: %S Size50: %d Size100 %d\n" 
	id page_seq_n n_revisions (Int64.to_string total_text) title (List.nth sizes 1) (List.nth sizes 0); 

  end (* page *)

