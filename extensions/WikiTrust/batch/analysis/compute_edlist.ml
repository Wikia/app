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

open Editlist;;
type word = string

(** These are used to delimit chunks when the chunks are put all together in the 
    zipping calculations. Do NOT remove the spaces. *)
let left_separator = " 1 "
let right_separator = " 2 "


(* **************************************************************** *)
(* Code for zipping together edit lists *)

(* This is to generate comparison function out of a function that 
   extracts an integer from each element to be compared *)
let comp_els toint a b = (toint a) - (toint b)


(** sort_right keeps of l only the Ins and Mov elements (which refer to w1), 
   and sorts them in order of position on the right. *)
let sort_right (l: edit list) : edit list = 
  (* Of the lhs, keep only Ins and Mov *)
  let f = function 
      Ins _ | Mov _ -> true
    | Del _ -> false
  in 
  let l' = List.filter f l in 
  let extract_pos = function 
      Ins (i, l) -> i
    | Del (i, l) -> i
    | Mov (i, j, l) -> j
  in
  List.sort (comp_els extract_pos) l'

(** symmetrically *)
let sort_left (l: edit list) : edit list = 
  (* keep only Del and Mov *)
  let f = function 
      Del _ | Mov _ -> true
    | Ins _ -> false
  in 
  let l' = List.filter f l in 
  let extract_pos = function 
      Ins (i, l) -> i
    | Del (i, l) -> i
    | Mov (i, j, l) -> i
  in
  List.sort (comp_els extract_pos) l'


(** [zip_edit_lists l r], given the edit list [l] from w1 to w2, 
    and the edit list [r] from w2 to w3, compute the best approximation 
    of the edit list from w1 to w3. *)
let zip_edit_lists (l: edit list) (r: edit list) : edit list = 
  (* The l edit list is an edit list from w0 to w1 (w0 and w1 are word lists. 
     Similarly, r is an edit list from w1 to w2. *)

  let l' = sort_right l in 
  let r' = sort_left  r in 

  (* Zips the two sorted and prepared edit lists. *)
  let rec zip l r = 
    match (l, r) with 
      (l_el :: lr, r_el :: rr) -> begin 
	(* l_el, r_el are the elements at the front of the lists *)
	match l_el with 
	  Ins (i, m) -> begin 
	    match r_el with 
	      Mov (i', j', m') -> begin (* Ins, Mov match *)
		if m = 0 || i + m - 1 < i' then zip lr r (* left all before right *)
		else if m' = 0 || i' + m' - 1 < i then zip l rr (* right all before left *)
		  (* they have an intersection; looks at which one starts first *)
		else if i < i' then zip (Ins (i', m - (i' - i)) :: lr) r 
		else if i' < i then zip l (Mov (i, j' + (i - i'), m' - (i - i')) :: rr)
		else let c = min m m' in (* equal beginnings *)
		Ins (j', c) :: zip (Ins (i + c, m - c) :: lr) (Mov (i' + c, j' + c, m' - c) :: rr)
	      end
	    | Ins (_, _) -> zip l rr (* The ins on the right is just spurious *) 
	    | Del (i', m') -> begin (* Ins, Del annihilate each other *)
		if m = 0 || i + m - 1 < i' then zip lr r (* left all before right *)
		else if m' = 0 || i' + m' - 1 < i then zip l rr (* right all before left *)
		  (* they have an intersection; looks at which one starts first *)
		else if i < i' then zip (Ins (i', m - (i' - i)) :: lr) r 
		else if i' < i then zip l (Del (i, m' - (i - i')) :: rr)
		else let c = min m m' in (* equal beginnings *)
		zip (Ins (i + c, m - c) :: lr) (Del (i' + c, m' - c) :: rr)
	      end
	  end (* Ins matching *)
	| Mov (i, j, m) -> begin 
	    match r_el with 
	      Mov (i', j', m') -> begin (* Mov, Mov match *)
		if m = 0 || j + m - 1 < i' then zip lr r (* left all before right *)
		else if m' = 0 || i' + m' - 1 < j then zip l rr (* right all before left *)
		  (* they have an intersection; looks at which one starts first *)
		else if j < i' then zip (Mov (i + (i' - j), i', m - (i' - j)) :: lr) r 
		else if i' < j then zip l (Mov (j, j' + (j - i'), m' - (j - i')) :: rr)
		else let c = min m m' in (* equal beginnings *)
		Mov (i, j', c) :: zip (Mov (i + c, j + c, m - c) :: lr) (Mov (i' + c, j' + c, m' - c) :: rr)
	      end
	    | Del (i', m') -> begin (* Mov, Del matching. Outcome is Del. *)
		if m = 0 || j + m - 1 < i' then zip lr r (* left all before right *)
		else if m' = 0 || i' + m' - 1 < j then zip l rr (* right all before left *)
		  (* they have an intersection; looks at which one starts first *)
		else if j < i' then zip (Mov (i + (i' - j), i', m - (i' - j)) :: lr) r 
		else if i' < j then zip l (Del (j, m' - (j - i')) :: rr)
		else let c = min m m' in (* equal beginnings *)
		Del (i, c) :: zip (Mov (i + c, j + c, m - c) :: lr) (Del (i' + c, m' - c) :: rr)
	      end
	    | Ins (_, _) -> zip l rr (* the Ins is spurious *)
	  end (* Mov matching *)
	| Del (_, _) -> zip lr r (* The Del is spurious *)
      end
    | (_, _) -> [] (* Not both lists full *)
  in zip l' r';;

(** Unit testing for zip *)
if false then begin 
  let l = [Del (0, 2); Mov (2, 4, 5)] in 
  let r = [Del (0, 2); Del (2, 5); Mov (7, 5, 3)] in 
  print_diff (zip_edit_lists l r);
  Printf.printf "\n"; 
  let l = [Del (0, 2); Mov (2, 4, 5); Ins (0, 4); Del (7, 3); Mov (10, 9, 3); Ins (12, 1)] in 
  let r = [Del (0, 2); Del (2, 5); Mov (7, 5, 3); Del (10, 1); Mov (11, 13, 2); 
           Ins (0, 5); Ins (8, 5); Del (13, 2)] in 
  print_diff (zip_edit_lists l r)
end;;

(** Measures how many words a difference list covers, on the left, and on the right *)
let rec diff_cover = function 
    [] -> (0, 0)
  | Ins (i, m) :: q -> let (l, r) = diff_cover q in (l, r + m)
  | Del (i, m) :: q -> let (l, r) = diff_cover q in (l + m, r)
  | Mov (i, j, m) :: q -> let (l, r) = diff_cover q in (l + m, r + m);;		      


(** Given an edit list, computes the list of blocks not affected by the edit list. 
    In [left_complement k n], [n] is the total length of the word array, and 
    [k] is how much of it we have processed already.
    The result is a Vec consisting of pairs [(offset, len)], where [offset] is the 
    offset of the block in the original string, and len is its length. *)
let rec left_complement k n = function 
    [] -> if n > k then Vec.insert 0 (k, n - k) Vec.empty else Vec.empty
  | Ins (_, _) :: rest -> left_complement k n rest 
  | Del (i, m) :: rest 
  | Mov (i, _, m) :: rest ->
      if k < i 
      then Vec.insert 0 (k, i - k) (left_complement (i + m) n rest)
      else left_complement (i + m) n rest 

(** See [left_complement] *)
let rec right_complement k n = function 
    [] -> if n > k then Vec.insert 0 (k, n - k) Vec.empty else Vec.empty
  | Del (_, _) :: rest -> right_complement k n rest 
  | Ins (i, m) :: rest
  | Mov (_, i, m) :: rest -> 
      if k < i 
      then Vec.insert 0 (k, i - k) (right_complement (i + m) n rest)
      else right_complement (i + m) n rest 

(** [make_arrays_for_local_diff c wl sep] takes a complement (left or
    right) [c], a word list [w], and a separator [sep], and produces
    two arrays [info] and [w].  A complement [c] is a list of pairs
    (i,j), where i is the offset of the pair, and j is the length.
    [info] is an array of pairs (i,j) of integers, where i is the
    block a word came from, and j is the offset from the beginning of
    the block; (-1, -1) is used to indicate that the word is a
    separator. [w] is the word array consisting of the word blocks,
    and of the separators *)
let make_arrays_for_local_diff (c: (int * int) Vec.t) (wl: word array) (sep: word) 
    : ((int * int) array) * (word array) =
  (* I deal with the case of an empty c separately *)
  if c = Vec.empty 
  then ( [| |], [| |] )
  else begin 
    (* First, it computes the length of the list *)
    let w_len = ref (-1) in (* the -1 eats the spurious +1 in the following summation *)
    for i = 0 to (Vec.length c) - 1 do begin 
      let (_, l) = Vec.get i c in 
      w_len := !w_len + l + 1
    end done; 
    (* Allocates the arrays that will be returned *)
    let info = Array.make !w_len (-1, -1) in 
    let w = Array.make !w_len sep in 
    (* Now fills the array, block by block. !offset is the position in
       the arrays to be filled next *)
    let offset = ref 0 in 
    for i = 0 to (Vec.length c) - 1 do begin 
      let (k, l) = Vec.get i c in 
      (* k is the offset of the word block; l is its length *)
      (* copies the block *)
      for j = 0 to l - 1 do begin 
	w.(!offset) <- wl.(k + j); 
	info.(!offset) <- (i, j); 
	offset := !offset + 1
      end done;
      (* This leaves space between one block and the next, with the separator in between *)
      offset := !offset + 1
    end done;
    (info, w)
  end;;

    
(** [global_from_local_diff left_iar right_iar left_compl right_compl diff_list] 
    produces a global edit list, starting from the edit list of a local comparison. 
    It takes as input: [diff_list], which is the diff list due to the local comparison, 
    [left_iar], which is the left [(int * int) array] produced by [make_arrays_for_local_diff], 
    containing the relation between local information and [left_comp], and the left 
    complement generated by [left_complement].  Same thing for the right hand side. 
    The output is a global difference list. *)
let global_from_local_diff 
    (left_iar: (int * int) array) 
    (right_iar: (int * int) array) 
    (left_compl: (int * int) Vec.t) 
    (right_compl: (int * int) Vec.t)
    (diff_list: edit list) : edit list = 
  let rec loc_to_glob = function 
      [] -> []
    | Mov (i, j, m) :: rest -> begin 
	(* Find starting point in the original lists of words *)
	let (l_block_idx, l_pos_in_block) = left_iar.(i) in 
	let (r_block_idx, r_pos_in_block) = right_iar.(j) in 
	let (l_offset, _) = Vec.get l_block_idx left_compl in 
	let (r_offset, _) = Vec.get r_block_idx right_compl in 
	let l_pos = l_offset + l_pos_in_block in 
	let r_pos = r_offset + r_pos_in_block in 
	Mov (l_pos, r_pos, m) :: (loc_to_glob rest)
      end
    | Del (i, m) :: rest -> begin 
	(* Deletes affect the lhs only, but the problem is that 
	   they can span multiple blocks. *)
	let result = ref (loc_to_glob rest) in 
	(* idx_first is the index in the Del; it is used to measure 
	   the length of Del that is matched.  It is initialized to 
	   -1 to indicate that the start of a valid match has not yet been found. 
	   Global_offset is the index in the global string *)
	let idx_first = ref 0 in 
	(* Fixes the global offset... unfortunately, I need a case analysis *)
	let global_offset = ref 0 in 
	let (l_block_idx, l_pos_in_block) = left_iar.(0) in 
	if l_block_idx > -1 then begin 
	  let (l_offset, _) = Vec.get l_block_idx left_compl in 
	  global_offset := l_offset + l_pos_in_block
	end; 
	(* Now scans the list *)
	for i = 0 to m - 1 do begin 
	  let (l_block_idx, _) = left_iar.(i) in 
	  if l_block_idx = -1 then begin 
	    (* The -1 indicates that a block has ended.  Processes it if needed (if a real block). *)
	    if i > !idx_first then result := Del (!global_offset, i - !idx_first) :: !result; 
	    idx_first := i + 1; 
	    if i + 1 < m then begin 
	      (* sets up for the next block *)
	      let (l_block_idx, l_pos_in_block) = left_iar.(i + 1) in 
	      let (l_offset, _) = Vec.get l_block_idx left_compl in 
	      global_offset := l_offset + l_pos_in_block
	    end
	  end
	end done;
	(* Ok, at this point all we have to do is add the last segment *)
	if m > !idx_first 
	then Del (!global_offset, m - !idx_first) :: !result
	else !result
      end
    | Ins (i, m) :: rest -> begin 
	(* Inserts affect the lhs only, but the problem is that 
	   they can span multiple blocks. *)
	let result = ref (loc_to_glob rest) in 
	(* idx_first is the index in the Ins; it is used to measure 
	   the length of Ins that is matched.  It is initialized to 
	   -1 to indicate that the start of a valid match has not yet been found. 
	   Global_offset is the index in the global string *)
	let idx_first = ref 0 in 
	(* Fixes the global offset... unfortunately, I need a case analysis *)
	let global_offset = ref 0 in 
	let (r_block_idx, r_pos_in_block) = right_iar.(0) in 
	if r_block_idx > -1 then begin 
	  let (r_offset, _) = Vec.get r_block_idx right_compl in 
	  global_offset := r_offset + r_pos_in_block
	end; 
	(* Now scans the list *)
	for i = 0 to m - 1 do begin 
	  let (r_block_idx, _) = right_iar.(i) in 
	  if r_block_idx = -1 then begin 
	    (* The -1 indicates that a block has ended.  Processes it if needed (if a real block). *)
	    if i > !idx_first then result := Ins (!global_offset, i - !idx_first) :: !result; 
	    idx_first := i + 1; 
	    if i + 1 < m then begin 
	      let (r_block_idx, r_pos_in_block) = right_iar.(i + 1) in 
	      let (r_offset, _) = Vec.get r_block_idx right_compl in 
	      global_offset := r_offset + r_pos_in_block
	    end
	  end
	end done;
	(* Ok, at this point all we have to do is add the last segment *)
	if m > !idx_first 
	then Ins (!global_offset, m - !idx_first) :: !result
	else !result
      end
  in loc_to_glob diff_list;; 


(** [edit_diff_using_zipped_edits wl dl wr dr]
    Given two word arrays, and two difference lists to be zipped, 
    this function returns a zipped and completed difference list. 
    [wl] is the word list on the left, [wr] on the right. 
    [dl] is the left difference list, [dr] is the right one. *)
let edit_diff_using_zipped_edits 
    (wl: word array) (wr: word array) 
    (dl: edit list)  (dr: edit list) : edit list = 
  (* First, zips the difference lists *)
  let zipped_diffs = zip_edit_lists dl dr in 
  (* Then, computes the complements, i.e., what is not covered by the joint 
     zipped list. *)
  let zl = sort_left zipped_diffs  in 
  let zr = sort_right zipped_diffs in 
  let cl = left_complement  0 (Array.length wl) zl in 
  let cr = right_complement 0 (Array.length wr) zr in 
  (* Prepares the left and right array for local differences *)
  let (info_l, local_wl) = make_arrays_for_local_diff cl wl left_separator in 
  let (info_r, local_wr) = make_arrays_for_local_diff cr wr right_separator in 
  (* Now computes the local difference between local_wl and local_wr *)
  let index_r = Chdiff.make_index_diff local_wr in 
  let local_diff = Chdiff.edit_diff local_wl local_wr index_r in 
  (* And from the local difference, computes a global one *)
  (global_from_local_diff info_l info_r cl cr local_diff) @ zipped_diffs;;


(* **************************************************************** *)
(* unit testing code for difference with zipping *)


if false then begin
  let ts0 = "Il bene individuale e' bene." in 
  let ts1 = "Il bene comune coincide col bene individuale." in 
  let ts2 = "Il bene comune non coincide col bene individuale." in 
  let ts3 = "Nella maggior parte dei casi, il bene comune non coincide con il bene individuale." in 
  let ts4 = "In molti casi, il bene comune non coincide completamente con quello individuale, a causa dell'egoismo delle persone." in 
  let ts5 = "In molti casi, il bene comune non coincide con quello individuale.  Questo e' causato dall'egoismo delle persone, che cercano di massimizzare il loro bene individuale, invece di quello comune." in 
  let ts6 = "In generale, il bene comune non coincide con quello individuale.  La causa e' l'egoismo delle persone, che cercano di massimizzare il loro bene individuale, invece di quello comune." in 
  let ts7 = "In generale, il bene comune non coincide con quello individuale, dato che le persone non badano a quello comune." in 
  let ts8 = "Volete comperare Viagra? Molto buono dato che le persone non badano a quello comune." in 
  let ts9 = ts7 in 
  let ts10 = "In generale, il bene comune non coincide con quello individuale. Questo e' causato dal fatto che le persone badano al loro bene privato, piuttosto che al bene comune." in

  let ta0  = Text.split_into_words false (Vec.singleton ts0) in 
  let ta1  = Text.split_into_words false (Vec.singleton ts1) in 
  let ta2  = Text.split_into_words false (Vec.singleton ts2) in 
  let ta3  = Text.split_into_words false (Vec.singleton ts3) in 
  let ta4  = Text.split_into_words false (Vec.singleton ts4) in 
  let ta5  = Text.split_into_words false (Vec.singleton ts5) in 
  let ta6  = Text.split_into_words false (Vec.singleton ts6) in 
  let ta7  = Text.split_into_words false (Vec.singleton ts7) in 
  let ta8  = Text.split_into_words false (Vec.singleton ts8) in 
  let ta9  = Text.split_into_words false (Vec.singleton ts9) in 
  let ta10 = Text.split_into_words false (Vec.singleton ts10) in 
 
  let w = [|ts0; ts1; ts2; ts3; ts4; ts5; ts6; ts7; ts8; ts9; ts10|] in 
  let t = [|ta0; ta1; ta2; ta3; ta4; ta5; ta6; ta7; ta8; ta9; ta10|] in 
  let len = Array.length (t) in 
  for i = 0 to len - 3 do begin
    let w0 = t.(i) in 
    for j = i + 1 to len - 2 do begin
      let w1 = t.(j) in 
      let i1 = Chdiff.make_index_diff w1 in 
      let e1 = Chdiff.edit_diff w0 w1 i1 in 
      for k = j + 1 to len - 1 do begin 
	let w2 = t.(k) in 
	let i2 = Chdiff.make_index_diff w2 in 
	let e2 = Chdiff.edit_diff w1 w2 i2 in 
	let e02 = Chdiff.edit_diff w0 w2 i2 in 
	(* Difference from i to k directly *)
	Printf.printf "\n================================================================\n";
	Printf.printf "Difference between %d %d %d:\n" i j k; 
	Printf.printf "String %d: %s\n" i w.(i);
	Printf.printf "String %d: %s\n" j w.(j);
	Printf.printf "String %d: %s\n" k w.(k);
	Printf.printf "------------ direct:\n"; 
	print_diff e02; 
	(* Now interpolating *)
	Printf.printf "------------ zipped:\n"; 
	print_diff (edit_diff_using_zipped_edits w0 w2 e1 e2)
      end done
    end done
  end done
end;;
