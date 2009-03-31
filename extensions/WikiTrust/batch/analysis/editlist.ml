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

TYPE_CONV_PATH "UCSC_WIKI_RESEARCH"

(* editlist.ml : this file contains the types related to edit lists *)

type edit = Ins of int * int         (* Ins i l means add l words at position i *)
	    | Del of int * int       (* Del i l means delete l words from position i *)
	    | Mov of int * int * int with sexp (* Mov i j l means move l words from pos i to pos l *)

(* same as edit, but for the case when the lhs and rhs are lists of chunks *)
type medit = Mins of int * int (* Mins i l is insert l chars at pos i of chunk 0 *)
	     | Mdel of int * int * int (* Mdel i k l is del l chars at pos i of chunk k *)
	     | Mmov of int * int * int * int * int (* Mmov i k j n l is mov l chars from pos i of chunk k to pos j of chunk n *)


(** Useful for debugging purposes *)
let rec print_diff l = 
  match l with 
    d :: l' ->
      begin
	begin 
	  match d with 
	    Ins (i, l) -> Printf.printf "\nIns %d %d" i l 
	  | Del (i, l) -> Printf.printf "\nDel %d %d" i l 
	  | Mov (i, j, l) -> Printf.printf "\nMov %d %d %d" i j l 
	end;
	print_diff l'
      end
  | [] -> Printf.printf "\n";;

let rec print_mdiff l = 
  match l with 
    d :: l' ->
      begin
	begin 
	  match d with 
	    Mins (i, l) -> Printf.printf "\nIns (%d, 0) %d" i l 
	  | Mdel (i, k, l) -> Printf.printf "\nDel (%d, %d) %d" i k l 
	  | Mmov (i, k, j, n, l) -> Printf.printf "\nMov (%d, %d) (%d, %d) %d" i k j n l 
	end;
	print_mdiff l'
      end
  | [] -> Printf.printf "\n";;

(* **************************************************************** *)
(* Edit distance computation *)

let edit_distance (edits: edit list) (l: int) : float = 
  let tot_ins = ref 0 in 
  let tot_del = ref 0 in 
  (* Adds up Ins and Del, and leaves the Mov for later analysis *)
  let rec sum_changes (el: edit list) : (int * int * int) list =  
    match el with 
      [] -> []
    | e :: l -> begin
	match e with 
	  Mov (i, j, m) -> (i, j, m) :: (sum_changes l)
	| Ins (i, len) -> begin
	    tot_ins := !tot_ins + len; 
	    sum_changes l
	  end
	| Del (i, len) -> begin
	    tot_del := !tot_del + len; 
	    sum_changes l
	  end
      end
  in
  let mov_l = sum_changes edits in 
  (* Computes the contribution of movs *)
  (* Makes an array of the moves *)
  let a = Array.of_list mov_l in 
  (* comparison for sorting *)
  let cmp m1 m2 = 
    let (i1, j1, l1) = m1 in 
    let (i2, j2, l2) = m2 in 
    let d = i1 - i2 in 
    if d > 0 then 1
    else if d < 0 then -1 
    else 0
  in
  (* sorts the array *)
  Array.sort cmp a;
  (* now we sort it wrt the move destination, 
     adding contributions as we go along *)
  let tot_mov = ref 0 in 
  (* sorts between lower_b and upper_b *)
  let lower_b = ref 0 in 
  let upper_b = ref ((Array.length a) - 1) in 
  while !upper_b > !lower_b do 
    begin 
      (* first, we go up *)
      let change = ref 0 in 
      for i = !lower_b to !upper_b - 1 do 
	begin
	  let (i1, j1, l1) = a.(i) in 
	  let (i2, j2, l2) = a.(i+1) in 
	  if j2 < j1 then 
	    begin
	      (* swaps, and takes cost into consideration *)
	      let m = a.(i) in 
	      a.(i) <- a.(i+1);
	      a.(i+1) <- m; 
	      tot_mov := !tot_mov + l1 * l2; 
	      (* keeps track of the upper change in sort order *)
	      change := i
	    end
	end
      done; 
      upper_b := !change; 
      (* then we go down *)
      change := !upper_b; 
      for i = !upper_b downto !lower_b + 1 do 
	begin 
	  let (i2, j2, l2) = a.(i) in 
	  let (i1, j1, l1) = a.(i-1) in 
	  if j2 < j1 then 
	    begin
	      (* swaps, and takes cost into consideration *)
	      let m = a.(i) in 
	      a.(i) <- a.(i-1);
	      a.(i-1) <- m; 
	      tot_mov := !tot_mov + l1 * l2; 
	      (* keeps track of the upper change in sort order *)
	      change := i
	    end
	end
      done; 
      lower_b := !change; 
    end
  done;
  (* computes the distance *)
  let ins' = float_of_int !tot_ins in 
  let del' = float_of_int !tot_del in 
  let mov' = float_of_int !tot_mov in 
  let len' = (if l = 0 then 1.0 else float_of_int l) in 
  (max ins' del') -. (0.5 *. (min ins' del')) +. (mov' /. len');;


(** Unit test for edit distance *)
if false then begin 
  let e = [Ins (1, 2); Ins (4, 5); Mov (3, 4, 5); Del (3, 2)] in 
  print_string (string_of_float (edit_distance e 20));
  print_newline ();
  let e = [Ins (1, 2); Ins (4, 5); Mov (3, 4, 5); Mov (4, 0, 2); Mov (5, 0, 5); Del (3, 2)] in 
  print_string (string_of_float (edit_distance e 20));
  print_newline ();
  let e = [Ins (1, 2); Ins (4, 5); Mov (3, 4, 5); Mov (4, 1, 2); Mov (5, 0, 5); Del (3, 2)] in 
  print_string (string_of_float (edit_distance e 20));
  print_newline ()
end;;


