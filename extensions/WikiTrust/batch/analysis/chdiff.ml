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

(** chdiff.ml : here we compare chunks of text, to trace text through
    revisions, and to compute edit distances *)

open Editlist;;

type word = string (* so that we know what is going on *)
type heap_el = int * int * int    (* (len, pos1, pos2) *)
type index_t = ((word * word * word), int) Hashtbl_bounded.t

(** This is the maximum number of matches for a word pair that we
    track. If a word pair has more than this number of matches, we
    disregard them all, as we classify the word pair as not sufficiently
    distinctive. *)
let max_matches = 40 
(** This is the minimum length of any dead chunk we keep around.  Dead chunks shorter
    than this are not kept, with the idea that short amounts of text are not 
    rescued, but simply, freshly rewritten. *)
let min_dead_chunk_len = 6
(** This is the minimum length of a match between existing and old text for considering 
    copying to have happened.  It must be 3 <= min_copy_amount <= min_dead_chunk_len *)
(** TODO: here it would be better to rely on word frequencies.  A project for a student? *)
let min_copy_amount = 4
(** Minimum amount that can be considered copied from dead chunks.  It must satisfy 
    min_copy_amount <= min_dead_copy_amount <= min_dead_chunk_len, and it is sensible
    to take min_dead_copy_amount = min_dead_chunk_len *)
let min_dead_copy_amount = 6


module Heap = Coda.PriorityQueue
type match_quality_t = Coda.match_quality_t

(* Quality functions for matches *)

let quality (l: int) (i1: int) (len1: int) (i2: int) (len2: int) (ch1_idx: int) 
    : match_quality_t = 
  let i1' = (float_of_int (i1 + l)) /. 2. in 
  let len1' = float_of_int len1 in 
  let i2' = (float_of_int (i2 + l)) /. 2. in 
  let len2' = float_of_int len2 in 
  let q = abs_float ((i1' /. len1') -. (i2' /. len2'))
  in 
  (l, ch1_idx, q)

let print_chunks (waa: word array array) = 
  let f ws = begin
    Text.print_words ws; 
    print_string "\n"
  end in 
  print_string "\nChunks: \n";
  Array.iter f waa;;
	    

(* **************************************************************** *)
(* Edit difference computation *)

(** This function creates an index as needed for words2 in edit_diff *)
let make_index_diff (words: word array) : index_t = 
  let len = Array.length words in 
  let idx = Hashtbl_bounded.create (1 + len) (10 * max_matches) in 
  (* fills up the index *)
  for i = 0 to len - 3 do 
    let word_tuple = (words.(i), words.(i + 1), words.(i + 2)) in 
    Hashtbl_bounded.add idx word_tuple i
  done; 
  idx;;


(** This function computes a list of edit commands that enable to go from 
    words1 to words2 *)
let edit_diff 
    (words1: word array) 
    (words2: word array) 
    (index2: index_t) : edit list 
    =

  (* creates the heap for the matches *)
  let heap = Heap.create () in 
  
  let len1 = Array.length (words1) in 
  let len2 = Array.length (words2) in 
  (* prev_matches is used to avoid putting smaller matches in the heap when a bigger 
     one in the same location has already been found *)
  let prev_matches = ref [] in 
  (* the - 2 is because we use word pairs to index the hash table *)
  for i1 = 0 to len1 - 3 do 
    let word_tuple = (words1.(i1), words1.(i1 + 1), words1.(i1 + 2)) in 
    if Hashtbl_bounded.mem index2 word_tuple then
      begin
	let matches = Hashtbl_bounded.find_all index2 word_tuple in 
	(* We care only if there are at most max_matches matches. 
	   If there are too many matches, removes them all. *)
	if List.length (matches) > max_matches 
	then Hashtbl_bounded.remove_all index2 word_tuple
	else
	  begin
	    (* This function processes a match at position i2 of words2 *)
	    let process_match (i2: int) = 
	      (* if i2 - 1 is in prev_matches, then we don't need to do anything, 
		 since (i1 - 1, i2 - 1) has already been counted as a match, and is longer *)
	      if not (List.mem (i2 - 1) !prev_matches) then
		begin
		  (* Now we check how long the match is; the min len is 3 of course,
		     since the index contains word triples *)
		  let l = ref 3 in 
		  while (i1 + !l < len1) && (i2 + !l < len2) && 
		    (words1.(i1 + !l) = words2.(i2 + !l)) do l := !l + 1 done; 
		  (* Ok, the match starts in i1, i2, and has length !l *)
		  let q = quality !l i1 len1 i2 len2 0 in 
		  (* Adds it to the heap *)
		  ignore (Heap.add heap (!l, i1, i2) q)
		end
		  (* Applies it to all matches *)
	    in List.iter process_match matches; 
	    (* keeps track of the previous matches *)
	    prev_matches := matches
	  end
      end
    else prev_matches := []
  done;
  
  (* At this point, all the matches between words1 and words2 are in heap *)
  
  (* Creates two arrays, which keep track of what has been matched.
     Remember, here we allow only single matches on either side. *)
  let matched1 = Array.make len1 0 in 
  let matched2 = Array.make len2 0 in
  (* This is for quickly identifying submatches *)
  let match_id = ref 0 in 
  (* diff is where we store the result *)
  let diff = ref [] in 

  (* Removes the matches one by one *)
  while not (Heap.is_empty heap) do 
    begin
      let m = Heap.take heap in
      match_id := !match_id + 1; 
      let (l, i1, i2) = m.Heap.contents in 
      (* Checks whether it has been matched.  As we pull out 
	 longest matches first (in each chunk), we can just
	 check the endpoints. *)
      if (matched1.(i1) = 0 && matched2.(i2) = 0) then 
	(* lower end is not matched *)
	if (matched1.(i1 + l - 1) = 0 && matched2.(i2 + l - 1) = 0) then 
	  (* upper end is not matched *)
	  begin
	    (* adds the edit command *)
	    diff := Mov (i1, i2, l) :: !diff; 
	    (* ... and marks it matched *)
	    for l' = 0 to l - 1 do begin
	      matched1.(i1 + l') <- !match_id; 
	      matched2.(i2 + l') <- !match_id
	    end
	    done
	  end
	else 
	  (* lower end is unmatched, upper end is matched *)
	  begin
	    (* Figures out the longest residual match, and puts it back into the heap *)
	    let k = ref (l - 2) in (* we know l - 1 is matched already *)
	    while (matched1.(i1 + !k) <> 0 || matched2.(i2 + !k) <> 0) do k := !k - 1 done; 
	    let res_l = !k + 1 in (* res_l is the len of the residual match *)
	    if res_l > 1 then begin
	      let q = quality res_l i1 len1 i2 len2 0 in 
	      ignore (Heap.add heap (res_l, i1, i2) q)
	    end
	  end
      else
	(* lower end is matched *)
	if (matched1.(i1 + l - 1) = 0 && matched2.(i2 + l - 1) = 0) then 
	  (* upper end is not matched *)
	  begin
	    (* Figures out the longest residual match, and puts it back into the heap *)
	    let j = ref 1 in (* we know 0 is matched already *)
	    while (matched1.(i1 + !j) <> 0 || matched2.(i2 + !j) <> 0) do j := !j + 1 done; 
	    let res_l = l - !j in (* res_l is the len of the residual match *)
	    if res_l > 1 then begin
	      let q = quality res_l (i1 + !j) len1 (i2 + !j) len2 0 in 
	      ignore (Heap.add heap (res_l, i1 + !j, i2 + !j) q)
	    end
	  end
	else 
	  (* both ends are matched *)
	  (* we need to look at whether there is an umatched portion
	     in the middle only if both ends are not matched by the
	     same match_id.  Note that there can be at most one
	     unmatched portion, as we pull out matches from the heap
	     longest first *)
	  if (matched1.(i1) <> matched1.(i1 + l - 1)) && 
	     (matched2.(i2) <> matched2.(i2 + l - 1)) then 
	       begin 
		 let j = ref 1 in 
		 while (!j < l - 1 && (matched1.(i1 + !j) <> 0 || matched2.(i2 + !j) <> 0)) do 
		   j := !j + 1 done;
		 let k = ref (!j + 1) in 
		 while (!k < l - 1 && not (matched1.(i1 + !k) <> 0 || matched2.(i2 + !k) <> 0)) do 
		   k := !k + 1 done;
		 let res_l = !k - !j in 
		 if res_l > 1 then begin
		   let q = quality res_l (i1 + !j) len1 (i2 + !j) len2 0 in 
		   ignore (Heap.add heap (res_l, i1 + !j, i2 + !j) q)
		 end
	       end
    end
  done; (* while heap is not empty *)
  
  (* Great; at this point, we have to cope with the unmatched stuff *)
  (* first from words1 *)
  let in_matched = ref true in 
  let unmatched_start = ref 0 in 
  for i1 = 0 to len1 - 1 do 
    if (!in_matched) && (matched1.(i1) = 0) then 
      begin 
	(* this is the start of an unmatched chunk *)
	in_matched := false;
	unmatched_start := i1; 
      end;
    if (not !in_matched) && (matched1.(i1) <> 0) then 
      begin
	(* this is the end of an unmatched chunk *)
	in_matched := true;
	if i1 > !unmatched_start then
	  diff := Del (!unmatched_start, i1 - !unmatched_start) :: !diff
      end
  done; 
  (* takes care of the last portion *)
  if (not !in_matched) && len1 > !unmatched_start then 
    diff := Del (!unmatched_start, len1 - !unmatched_start) :: !diff; 

  (* then from words2 *)
  let in_matched = ref true in 
  let unmatched_start = ref 0 in 
  for i2 = 0 to len2 - 1 do 
    if (!in_matched) && (matched2.(i2) = 0) then 
      begin 
	(* this is the start of an unmatched chunk *)
	in_matched := false;
	unmatched_start := i2; 
      end;
    if (not !in_matched) && (matched2.(i2) <> 0) then 
      begin
	(* this is the end of an unmatched chunk *)
	in_matched := true;
	if i2 > !unmatched_start then
	  diff := Ins (!unmatched_start, i2 - !unmatched_start) :: !diff
      end
  done; 
  (* takes care of the last portion *)
  if (not !in_matched) && len2 > !unmatched_start then 
    diff := Ins (!unmatched_start, len2 - !unmatched_start) :: !diff; 

  (* all done *)
  !diff;;


(* **************************************************************** *)
(* Text survival and tracking *)

(* We index by pairs *)
let make_survival_index (chunks: word array array) : ((word * word * word), (int * int)) Hashtbl_bounded.t = 
  (* makes a hashtable of the right size *)
  let f t a = t + (Array.length a) in 
  let tot_els = Array.fold_left f 0 chunks in 
  let idx = Hashtbl_bounded.create (1 + tot_els) (10 * max_matches) in 
  (* now fills up the index *)
  let num_chunks = Array.length chunks in 
  (* makes an index for all chunks *)
  for c_idx = 0 to num_chunks - 1 do 
    begin
      let c = chunks.(c_idx) in 
      let chunk_len = Array.length (c) in 
      for i = 0 to chunk_len - 3 do 
	let word_triple = (c.(i), c.(i+1), c.(i+2)) in 
	Hashtbl_bounded.add idx word_triple (c_idx, i)
      done
    end
  done;
  idx;;
	

(** [text_survival words1 words1_attr dead_chunks dead_chunks_attr words2] 
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
let text_survival 
    (words1: word array)
    (words1_attr: 'a array) 
    (dead_chunks: word array list)
    (dead_chunks_attr: 'a array list)
    (words2: word array)
    (f_inherit: bool -> bool -> 'a -> 'a)
    (c_new: 'a)
    : ('a array) * (word array list) * ('a array list) 
    =
  let chunks1_list = words1 :: dead_chunks in 
  let attr1_list = words1_attr :: dead_chunks_attr in 
  let chunks1 = Array.of_list chunks1_list in 
  let attr1 = Array.of_list attr1_list in 

  (* Make an index of chunks1 *)
  let idx1 = make_survival_index chunks1 in 
  
  (* creates the heap for the matches *)
  let heap = Heap.create () in 
  
  let len2 = Array.length (words2) in 
  let len1 = Array.map Array.length chunks1 in 

  (* This function tells us whether a match is big enough to be worth 
     putting in the heap, depending whether it's a match with live or dead 
     text (given by c1_idx = 0). *)
  let big_enough l c1_idx = 
    if c1_idx = 0 then l >= min_copy_amount 
    else l >= min_dead_copy_amount
  in

    (* prev_matches is used to avoid putting smaller matches in the heap when a bigger 
     one in the same location has already been found *)
  let prev_matches = ref [] in 
  (* the - 2 is because we use word pairs to index the hash table *)
  for i2 = 0 to len2 - 3 do 
    let word_tuple = (words2.(i2), words2.(i2 + 1), words2.(i2 + 2)) in 
    if Hashtbl_bounded.mem idx1 word_tuple then
      begin
	let matches = Hashtbl_bounded.find_all idx1 word_tuple in 
	(* We care only if there are at most max_matches matches *)
	if List.length (matches) > max_matches 
	then Hashtbl_bounded.remove_all idx1 word_tuple
	else 
	  begin
	    (* This function processes a match at position i2 of words2 *)
	    let process_match (m: int * int) = 
	      let (c1_idx, i1) = m in 
	      (* if (c1_idx, i1 - 1) is in prev_matches, then we don't need to do anything, 
		 since a superset match has already been added *)
	      if not (List.mem (c1_idx, i1 - 1) !prev_matches) then
		begin
		  (* Now we check how long the match is; the min len is 2 of course,
		     since the index contains word pairs *)
		  let l = ref 2 in 
		  while (i1 + !l < len1.(c1_idx)) && (i2 + !l < len2) && 
		    (chunks1.(c1_idx).(i1 + !l) = words2.(i2 + !l)) do l := !l + 1 done; 
		  (* Ok, the match starts in i1, i2, and has length !l *)
		  if big_enough !l c1_idx then 
		    (* we add it only if it is long enough *)
		    begin
		      let q = quality !l i1 len1.(c1_idx) i2 len2 c1_idx in 
		      (* Adds it to the heap *)
		      ignore (Heap.add heap (!l, c1_idx, i1, i2) q)
		    end
		end
		  (* Applies it to all matches *)
	    in List.iter process_match matches; 
	    (* keeps track of the previous matches *)
	    prev_matches := matches
	  end
      end
    else prev_matches := []
  done;

  (* At this point, all the matches between chunks1 and words2 are in heap *)
  (* Creates an array which keep track of what has been matched in words2 *)
  let matched2 = Array.make len2 0 in
  (* This is used to quickly find out if both ends of a supposed match are 
     matched by the same match *)
  let match_id = ref 0 in 
  (* matched1 keeps track instead of how many times a piece of text has been matched. *)
  let f a = Array.make (Array.length a) 0 in 
  let matched1 = Array.map f chunks1 in 
  (* words2_attr are the new attributes of words in words2 *)
  let words2_attr = Array.make len2 c_new in 

  (* Removes the matches one by one *)
  while not (Heap.is_empty heap) do 
    begin
      let m = Heap.take heap in
      match_id := !match_id + 1; 
      let (l, c1_idx, i1, i2) = m.Heap.contents in 
      (* Checks whether it has been matched.  As we pull out 
	 longest matches first (in each chunk), we can just
	 check the endpoints. *)
      if matched2.(i2) = 0 then 
	(* lower end is not matched *)
	if matched2.(i2 + l - 1) = 0 then 
	  (* upper end is not matched *)
	  for l' = 0 to l - 1 do 
	    begin
	      (* computes the new attribute of the text *)
	      words2_attr.(i2 + l') <- f_inherit (c1_idx = 0) true attr1.(c1_idx).(i1 + l'); 
	      (* ... and marks the text matched *)
	      matched2.(i2 + l') <- !match_id;
	      matched1.(c1_idx).(i1 + l') <- 1 + matched1.(c1_idx).(i1 + l')
	    end
	  done
	else 
	  (* lower end is unmatched, upper end is matched *)
	  begin
	    (* Figures out the longest residual match, and puts it back into the heap *)
	    let k = ref (l - 2) in (* we know l - 1 is matched already *)
	    while matched2.(i2 + !k) <> 0 do k := !k - 1 done; 
	    let res_l = !k + 1 in (* res_l is the len of the residual match *)
	    if big_enough res_l c1_idx then begin
	      let q = quality res_l i1 len1.(c1_idx) i2 len2 c1_idx in 
	      ignore (Heap.add heap (res_l, c1_idx, i1, i2) q)
	    end
	  end
      else
	(* lower end is matched *)
	if matched2.(i2 + l - 1) = 0 then 
	  (* upper end is not matched *)
	  begin
	    (* Figures out the longest residual match, and puts it back into the heap *)
	    let j = ref 1 in (* we know 0 is matched already *)
	    while matched2.(i2 + !j) <> 0 do j := !j + 1 done; 
	    let res_l = l - !j in (* res_l is the len of the residual match *)
	    if big_enough res_l c1_idx then begin
	      let q = quality 
		res_l (i1 + !j) len1.(c1_idx) (i2 + !j) len2 c1_idx in 
	      ignore (Heap.add heap (res_l, c1_idx, i1 + !j, i2 + !j) q)
	    end
	  end
	else 
	  (* both ends are matched *)
	  (* we need to look at whether there is an umatched portion in the middle, 
	     if the match ends have different ids *)
	  if matched2.(i2) <> matched2.(i2 + l - 1) then 
	    (* there can be only one such portion, as we pull out matches from the heap
	       longest first *)
	    begin 
	      let j = ref 1 in 
	      while !j < l - 1 && matched2.(i2 + !j) <> 0 do 
		j := !j + 1 done;
	      let k = ref (!j + 1) in 
	      while !k < l - 1 && matched2.(i2 + !k) <> 0 do 
		k := !k + 1 done;
	      let res_l = !k - !j in 
	      if big_enough res_l c1_idx then begin
		let q = quality 
		  res_l (i1 + !j) len1.(c1_idx) (i2 + !j) len2 c1_idx in 
		ignore (Heap.add heap (res_l, c1_idx, i1 + !j, i2 + !j) q)
	      end
	    end
    end
  done; (* while heap is not empty *)

  (* I removed the surround effect; it is now replaced by min_copy_amount *)

  (* Great; at this point, we have to cope with the unmatched stuff on the 
     first side, to generate the dead chunks for the second version. *)
  let dead_chunks2_l = ref [] in 
  let dead_chunks2_attr_l = ref [] in 

  for c1_idx = 0 to Array.length (matched1) - 1 do 
    begin 
      let in_matched = ref true in 
      let unmatched_start = ref 0 in 
      for i1 = 0 to len1.(c1_idx) - 1 do 
	if (!in_matched) && (matched1.(c1_idx).(i1) = 0) then 
	  begin 
	    (* this is the start of an unmatched chunk *)
	    in_matched := false;
	    unmatched_start := i1; 
	  end;
	if (not !in_matched) && (matched1.(c1_idx).(i1) > 0) then 
	  begin
	    (* this is the end of an unmatched chunk *)
	    in_matched := true;
	    if i1 - !unmatched_start >= min_dead_chunk_len then
	      begin
		(* Creates the word array for the dead chunk *)
		let l = i1 - !unmatched_start in 
		dead_chunks2_l := (Array.sub chunks1.(c1_idx) !unmatched_start l) 
		                  :: !dead_chunks2_l;
		(* Creates the attribute array for the dead chunk *)
		let dead_chunk2_attr = Array.sub attr1.(c1_idx) !unmatched_start l in 
		(* Now recomputes the attributes *)
		for k = 0 to l - 1 do 
		  dead_chunk2_attr.(k) <- f_inherit (c1_idx = 0) false dead_chunk2_attr.(k)
		done;
		(* and adds it to the list of results *)
		dead_chunks2_attr_l := dead_chunk2_attr :: !dead_chunks2_attr_l
	      end
	  end
      done; 
      (* takes care of the last portion *)
      if (not !in_matched) && len1.(c1_idx) >= (!unmatched_start + min_dead_chunk_len) then 
	begin
	  (* Creates the word array for the dead chunk *)
	  let l = len1.(c1_idx) - !unmatched_start in 
	  dead_chunks2_l := (Array.sub chunks1.(c1_idx) !unmatched_start l) 
	                    :: !dead_chunks2_l;
	  (* Creates the attribute array for the dead chunk *)
	  let dead_chunk2_attr = Array.sub attr1.(c1_idx) !unmatched_start l in 
	  (* Now recomputes the attributes *)
	  for k = 0 to l - 1 do 
	    dead_chunk2_attr.(k) <- f_inherit (c1_idx = 0) false dead_chunk2_attr.(k)
	  done;
	  (* and adds it to the list of results *)
	  dead_chunks2_attr_l := dead_chunk2_attr :: !dead_chunks2_attr_l
	end
    end
  done; (* for each c1_idx *)

  (* We can finally assemble the result *)
  (words2_attr, !dead_chunks2_l, !dead_chunks2_attr_l);;

(* **************************************************************** *)
(* New version of code *)

(** [text_tracking chunks1 words2] takes an array of text [chunks1], 
    and a new word [words2], and produces a new list of chunks [chunks2], 
    and a list of matches that pair up the new text with the old one. 
    chunks2.(0) is guaranteed to exist (but it might be empty). *)

let text_tracking
    (chunks1: word array array)
    (words2: word array)
    : ((word array array) * (medit list))
    =

  (* Make an index of chunks1 *)
  let idx1 = make_survival_index chunks1 in 
  
  (* creates the heap for the matches *)
  let heap = Heap.create () in 
  
  let len2 = Array.length (words2) in 
  let len1 = Array.map Array.length chunks1 in 

  (* This function tells us whether a match is big enough to be worth 
     putting in the heap, depending whether it's a match with live or dead 
     text (given by c1_idx = 0). *)
  let big_enough l c1_idx = 
    if c1_idx = 0 then l >= min_copy_amount 
    else l >= min_dead_copy_amount
  in

    (* prev_matches is used to avoid putting smaller matches in the heap when a bigger 
     one in the same location has already been found *)
  let prev_matches = ref [] in 
  (* the - 2 is because we use word pairs to index the hash table *)
  for i2 = 0 to len2 - 3 do 
    let word_tuple = (words2.(i2), words2.(i2 + 1), words2.(i2 + 2)) in 
    if Hashtbl_bounded.mem idx1 word_tuple then
      begin
	let matches = Hashtbl_bounded.find_all idx1 word_tuple in 
	(* We care only if there are at most max_matches matches *)
	if List.length (matches) > max_matches 
	then Hashtbl_bounded.remove_all idx1 word_tuple
	else 
	  begin
	    (* This function processes a match at position i2 of words2 *)
	    let process_match (m: int * int) = 
	      let (c1_idx, i1) = m in 
	      (* if (c1_idx, i1 - 1) is in prev_matches, then we don't need to do anything, 
		 since a superset match has already been added *)
	      if not (List.mem (c1_idx, i1 - 1) !prev_matches) then
		begin
		  (* Now we check how long the match is; the min len is 2 of course,
		     since the index contains word pairs *)
		  let l = ref 2 in 
		  while (i1 + !l < len1.(c1_idx)) && (i2 + !l < len2) && 
		    (chunks1.(c1_idx).(i1 + !l) = words2.(i2 + !l)) do l := !l + 1 done; 
		  (* Ok, the match starts in i1, i2, and has length !l *)
		  if big_enough !l c1_idx then 
		    (* we add it only if it is long enough *)
		    begin
		      let q = quality !l i1 len1.(c1_idx) i2 len2 c1_idx in 
		      (* Adds it to the heap *)
		      ignore (Heap.add heap (!l, c1_idx, i1, i2) q)
		    end
		end
		  (* Applies it to all matches *)
	    in List.iter process_match matches; 
	    (* keeps track of the previous matches *)
	    prev_matches := matches
	  end
      end
    else prev_matches := []
  done;

  (* At this point, all the matches between chunks1 and words2 are in heap. *)
  (* We now produce the true list of maximal matches, non-overlapping in words2, 
     that explains the inheritance of text. *)

  (* Creates an array which keeps track of what has been matched in words2 *)
  let matched2 = Array.make len2 0 in
  (* This is used to quickly find out if both ends of a supposed match are 
     matched by the same match *)
  let match_id = ref 0 in 
  (* matched1 keeps track instead of how many times a piece of text has been matched. *)
  let f a = Array.make (Array.length a) 0 in 
  let matched1 = Array.map f chunks1 in 
  (* diff is where we store the edit list *)
  let diff = ref [] in 
  (* Removes the matches one by one *)
  while not (Heap.is_empty heap) do 
    begin
      let m = Heap.take heap in
      match_id := !match_id + 1; 
      let (l, c1_idx, i1, i2) = m.Heap.contents in 
      (* Checks whether it has been matched.  As we pull out 
	 longest matches first (in each chunk), we can just
	 check the endpoints. *)
      if matched2.(i2) = 0 then 
	(* lower end is not matched *)
	if matched2.(i2 + l - 1) = 0 then begin 
	  (* upper end is not matched *)
	  diff := Mmov (i1, c1_idx, i2, 0, l) :: !diff; 
	  for l' = 0 to l - 1 do begin
	      (* marks the text matched *)
	      matched2.(i2 + l') <- !match_id;
	      matched1.(c1_idx).(i1 + l') <- 1 + matched1.(c1_idx).(i1 + l')
	  end done 
	end
	else begin 
	  (* lower end is unmatched, upper end is matched *)
	  (* Figures out the longest residual match, and puts it back into the heap *)
	  let k = ref (l - 2) in (* we know l - 1 is matched already *)
	  while matched2.(i2 + !k) <> 0 do k := !k - 1 done; 
	  let res_l = !k + 1 in (* res_l is the len of the residual match *)
	  if big_enough res_l c1_idx then begin
	    let q = quality res_l i1 len1.(c1_idx) i2 len2 c1_idx in 
	    ignore (Heap.add heap (res_l, c1_idx, i1, i2) q)
	  end
	end
      else
	(* lower end is matched *)
	if matched2.(i2 + l - 1) = 0 then 
	  (* upper end is not matched *)
	  begin
	    (* Figures out the longest residual match, and puts it back into the heap *)
	    let j = ref 1 in (* we know 0 is matched already *)
	    while matched2.(i2 + !j) <> 0 do j := !j + 1 done; 
	    let res_l = l - !j in (* res_l is the len of the residual match *)
	    if big_enough res_l c1_idx then begin
	      let q = quality 
		res_l (i1 + !j) len1.(c1_idx) (i2 + !j) len2 c1_idx in 
	      ignore (Heap.add heap (res_l, c1_idx, i1 + !j, i2 + !j) q)
	    end
	  end
	else 
	  (* both ends are matched *)
	  (* we need to look at whether there is an umatched portion in the middle, 
	     if the match ends have different ids *)
	  if matched2.(i2) <> matched2.(i2 + l - 1) then 
	    (* there can be only one such portion, as we pull out matches from the heap
	       longest first *)
	    begin 
	      let j = ref 1 in 
	      while !j < l - 1 && matched2.(i2 + !j) <> 0 do 
		j := !j + 1 done;
	      let k = ref (!j + 1) in 
	      while !k < l - 1 && matched2.(i2 + !k) <> 0 do 
		k := !k + 1 done;
	      let res_l = !k - !j in 
	      if big_enough res_l c1_idx then begin
		let q = quality 
		  res_l (i1 + !j) len1.(c1_idx) (i2 + !j) len2 c1_idx in 
		ignore (Heap.add heap (res_l, c1_idx, i1 + !j, i2 + !j) q)
	      end
	    end
    end
  done; (* while heap is not empty *)

  (* Now, this is very counter-intuitive, but there is a slight chance that the list !diff contains 
     [... Mmov (match1); Mmov (match2); ...] with match2 entirely contained in match1 -- even though
     the biggest matches are supposed to be found first, and thus end up later in !diff. 
     This would create problems later on in Wikipage, since !diff is then scanned linearly to attribute 
     text: it is safer if match1, the bigger match, is processed last, in case it is bigger. 
     Note that if match2 is bigger, it is not possible that match1, found later, is entirely contained 
     in match2, due to how the above algorithm is written. *)
  diff := List.rev !diff; 

  (* We have now matched all the text in words2. 
     We need to cope with the unmatched stuff on the 
     first side, to generate the dead chunks for the second version. *)
  let chunks2_l = ref [words2] in 
  let chunks2_len  = ref 1 in 

  for c1_idx = 0 to Array.length (matched1) - 1 do 
    begin 
      let in_matched = ref true in 
      let unmatched_start = ref 0 in 
      for i1 = 0 to len1.(c1_idx) - 1 do 
	if (!in_matched) && (matched1.(c1_idx).(i1) = 0) then 
	  begin 
	    (* this is the start of an unmatched chunk *)
	    in_matched := false;
	    unmatched_start := i1; 
	  end;
	if (not !in_matched) && (matched1.(c1_idx).(i1) > 0) then 
	  begin
	    (* this is the end of an unmatched chunk *)
	    in_matched := true;
	    let l = i1 - !unmatched_start in 
	    if l >= min_dead_chunk_len then
	      (* The unmatched chunk is big enough that we make it into a dead chunk *)
	      begin
		(* Creates the word array for the dead chunk *)
		chunks2_l := (Array.sub chunks1.(c1_idx) !unmatched_start l) :: !chunks2_l;
		(* And adds the move command to the edit list *)
		diff := Mmov (!unmatched_start, c1_idx, 0, !chunks2_len, l) :: !diff;
		chunks2_len := !chunks2_len + 1
	      end
	    else 
	      (* The unmatched chunk is short, and so we just label it as deleted *)
	      diff := Mdel (!unmatched_start, c1_idx, l) :: !diff 
	  end
      done; 
      (* takes care of the last portion *)
      if (not !in_matched) then
	begin 
	  let l = len1.(c1_idx) - !unmatched_start in 
	  if l >= min_dead_chunk_len then 
	    begin
	      (* Creates the word array for the dead chunk *)
	      chunks2_l := (Array.sub chunks1.(c1_idx) !unmatched_start l) :: !chunks2_l;
	      (* And adds the move command to the edit list *)
	      diff := Mmov (!unmatched_start, c1_idx, 0, !chunks2_len, l) :: !diff;
	      chunks2_len := !chunks2_len + 1
	    end
	  else 
	    (* Last part is too short; just labels it as deleted *)
	    diff := Mdel (!unmatched_start, c1_idx, l) :: !diff 
	end
    end
  done; (* for each c1_idx *)
  
  (* Now we have to account for the new portions of words2 that are not in chunks1 *)
  (* then from words2 *)
  let in_matched = ref true in 
  let unmatched_start = ref 0 in 
  for i2 = 0 to len2 - 1 do 
    if (!in_matched) && (matched2.(i2) = 0) then 
      begin 
	(* this is the start of an unmatched chunk *)
	in_matched := false;
	unmatched_start := i2; 
      end;
    if (not !in_matched) && (matched2.(i2) <> 0) then 
      begin
	(* this is the end of an unmatched chunk *)
	in_matched := true;
	if i2 > !unmatched_start then
	  diff := Mins (!unmatched_start, i2 - !unmatched_start) :: !diff
      end
  done; 
  (* takes care of the last portion *)
  if (not !in_matched) && len2 > !unmatched_start then 
    diff := Mins (!unmatched_start, len2 - !unmatched_start) :: !diff; 

  (* Ok, now we have everything, and we can assemble the result *)
  
  ((Array.of_list (List.rev !chunks2_l)), !diff);;


(* **************************************************************** *)
(* Unit testing of text diff functions *)


(** Unit test for text survival *)
if false then begin
  let c_new = 1 in 
  let f_inherit live1 live2 val1 = 
    if live2 then 
      if live1 
      then val1 + 3
      else val1 + 4
    else
      if live1
      then val1 + 1
      else val1 + 2
  in
  let ts1 = "Il bene comune coincide col bene individuale." in 
  let ts2 = "Il bene comune non coincide col bene individuale." in 
  let ts3 = "Nella maggior parte dei casi, il bene comune non coincide con il bene individuale." in 
  let ts4 = "In molti casi, il bene comune non coincide completamente con quello individuale, a causa dell'egoismo delle persone." in 
  let ts5 = "In molti casi, il bene comune non coincide con quello individuale.  Questo e' causato dall'egoismo delle persone, che cercano di massimizzare il loro bene individuale, invece di quello comune." in 
  let ts6 = "In generale, il bene comune non coincide con quello individuale.  La causa e' l'egoismo delle persone, che cercano di massimizzare il loro bene individuale, invece di quello comune." in 
  let ts7 = "In generale, il bene comune non coincide con quello individuale, dato che le persone non badano a quello comune." in 
  let ts8 = "Volete comperare Viagra? Molto buono basso prezzo dato che le persone non badano a quello comune." in 
  let ts9 = ts7 in 

  let print_vals (wa: word array) (ia: int array) = 
    print_string "\n";
    if not ((Array.length wa) = (Array.length ia))
    then print_string "Arrays have different lengths!\n"
    else begin
      for i = 0 to (Array.length wa) - 1 do 
	print_string ((string_of_int ia.(i)) ^ ":" ^ wa.(i) ^ " ")
      done
    end 
  in 

  let print_chunks (wal: word array list) (ial: int array list) = 
    print_string "\nDead chunks:";
    List.iter2 print_vals wal ial
  in 

  let make_init_attr (wl: word array) = 
    let l = Array.length wl in 
    Array.make l 0
  in 

  let ta1 = Text.split_into_words false (Vec.singleton ts1) in 
  let ta2 = Text.split_into_words false (Vec.singleton ts2) in 
  let ta3 = Text.split_into_words false (Vec.singleton ts3) in 
  let ta4 = Text.split_into_words false (Vec.singleton ts4) in 
  let ta5 = Text.split_into_words false (Vec.singleton ts5) in 
  let ta6 = Text.split_into_words false (Vec.singleton ts6) in 
  let ta7 = Text.split_into_words false (Vec.singleton ts7) in 
  let ta8 = Text.split_into_words false (Vec.singleton ts8) in 
  let ta9 = Text.split_into_words false (Vec.singleton ts9) in 

  let ia1 = make_init_attr ta1 in 

  print_vals ta1 ia1; 

  let (ia2, tc2, ic2) = text_survival ta1 ia1 [] [] ta2 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta2 ia2;
  print_chunks tc2 ic2; 

  let (ia3, tc3, ic3) = text_survival ta2 ia2 tc2 ic2 ta3 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta3 ia3;
  print_chunks tc3 ic3; 

  let (ia4, tc4, ic4) = text_survival ta3 ia3 tc3 ic3 ta4 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta4 ia4;
  print_chunks tc4 ic4; 

  let (ia5, tc5, ic5) = text_survival ta4 ia4 tc4 ic4 ta5 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta5 ia5;
  print_chunks tc5 ic5;

  let (ia6, tc6, ic6) = text_survival ta5 ia5 tc5 ic5 ta6 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta6 ia6;
  print_chunks tc6 ic6;

  let (ia7, tc7, ic7) = text_survival ta6 ia6 tc6 ic6 ta7 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta7 ia7;
  print_chunks tc7 ic7;

  print_string "\n\n";

  let c_new = 0 in 
  let f_inherit live1 live2 val1 = 
    if live2 then 
      if live1 
      then val1 + 1
      else val1 + 1
    else
      if live1
      then val1
      else val1
  in
    
  let ia1 = make_init_attr ta1 in 

  print_vals ta1 ia1; 

  let (ia2, tc2, ic2) = text_survival ta1 ia1 [] [] ta2 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta2 ia2;
  print_chunks tc2 ic2; 

  let (ia3, tc3, ic3) = text_survival ta2 ia2 tc2 ic2 ta3 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta3 ia3;
  print_chunks tc3 ic3; 

  let (ia4, tc4, ic4) = text_survival ta3 ia3 tc3 ic3 ta4 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta4 ia4;
  print_chunks tc4 ic4; 

  let (ia5, tc5, ic5) = text_survival ta4 ia4 tc4 ic4 ta5 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta5 ia5;
  print_chunks tc5 ic5;

  let (ia6, tc6, ic6) = text_survival ta5 ia5 tc5 ic5 ta6 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta6 ia6;
  print_chunks tc6 ic6;

  let (ia7, tc7, ic7) = text_survival ta6 ia6 tc6 ic6 ta7 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta7 ia7;
  print_chunks tc7 ic7;

  let (ia8, tc8, ic8) = text_survival ta7 ia7 tc7 ic7 ta8 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta8 ia8;
  print_chunks tc8 ic8;

  let (ia9, tc9, ic9) = text_survival ta8 ia8 tc8 ic8 ta9 f_inherit c_new in 
  print_string "\n\n";
  print_vals ta9 ia9;
  print_chunks tc9 ic9;

  print_string "\n\n"

end;;

(** Unit test for text tracking *)

if false then begin
  let ts1 = "Il bene comune coincide col bene individuale." in 
  let ts2 = "Il bene comune non coincide col bene individuale." in 
  let ts3 = "Nella maggior parte dei casi, il bene comune non coincide con il bene individuale." in 
  let ts4 = "In molti casi, il bene comune non coincide completamente con quello individuale, a causa dell'egoismo delle persone." in 
  let ts5 = "In molti casi, il bene comune non coincide con quello individuale.  Questo e' causato dall'egoismo delle persone, che cercano di massimizzare il loro bene individuale, invece di quello comune." in 
  let ts6 = "In generale, il bene comune non coincide con quello individuale.  La causa e' l'egoismo delle persone, che cercano di massimizzare il loro bene individuale, invece di quello comune." in 
  let ts7 = "In generale, il bene comune non coincide con quello individuale, dato che le persone non badano a quello comune." in 
  let ts8 = "Volete comperare Viagra? Molto buono basso prezzo." in
  let ts9 = ts7 in 
  let ts10 = "In generale, il bene comune non coincide con quello individuale, dato che le persone non badano a quello comune se non quando gli fa comodo." in 

  let tsa = [| ts1; ts2; ts3; ts4; ts5; ts6; ts7; ts8; ts9; ts10 |] in 
  let taa = Array.map (function x -> Text.split_into_words false (Vec.singleton x)) tsa in 
  let (c, l) = text_tracking [| taa.(0) |] taa.(1) in 
  Text.print_words taa.(0);
  Printf.printf "\n";
  Text.print_words taa.(1);
  Printf.printf "\n";
  print_chunks c;
  print_mdiff  l; 
  let cr = ref c in 
  for i = 2 to (Array.length taa) - 1 do begin 
    let (c, l) = text_tracking !cr taa.(i) in 
    Printf.printf "\n================\n";
    Printf.printf "New words:\n";
    Text.print_words taa.(i);
    print_chunks c; 
    print_mdiff  l;
    cr := c
  end done

end;;


(** One more unit test for text tracking *)

if false then begin
  let ts1 = "a b c d e o o o o o a b c d e" in 
  let ts2 = "a b c d e q q a b c d e q q q q a b c d e" in 
  let ts3 = "o o a b c d o o b c d e o o b c d e" in 
  let tsa = [| ts1; ts2; ts3 |] in
  let taa = Array.map (function x -> Text.split_into_words false (Vec.singleton x)) tsa in 
  let (c, l) = text_tracking [| taa.(0) |] taa.(1) in 
  Text.print_words taa.(0);
  Printf.printf "\n";
  Text.print_words taa.(1);
  Printf.printf "\n";
  print_chunks c;
  print_mdiff  l; 
  let cr = ref c in 
  for i = 2 to (Array.length taa) - 1 do begin 
    let (c, l) = text_tracking !cr taa.(i) in 
    Printf.printf "\n================\n";
    Printf.printf "New words:\n";
    Text.print_words taa.(i);
    print_chunks c; 
    print_mdiff  l;
    cr := c
  end done

end;;


(** Yet more unit test for text tracking *)

if false then begin
  let ch0 = "a b c d e o o o o o a b c d e" in 
  let ch1 = "a b c d e q q q q q q a b c d e q q q q q q a b c d e" in 
  let ts3 = "a b c d o o a b c d e z q q q q q q z a b c d e" in 
  let chunks = [| 
    (Text.split_into_words false (Vec.singleton ch0));
    (Text.split_into_words false (Vec.singleton ch1)) 
  |] in
  let tsa3 = Text.split_into_words false (Vec.singleton ts3) in
  let (c, l) = text_tracking chunks tsa3 in
  print_chunks chunks;
  print_string "Words:\n";
  Text.print_words tsa3;
  print_string "\n";
  print_chunks c;
  print_mdiff l
end;;


(** Yet more unit test for text tracking *)

if false then begin
  let ch0 = "a b c d e o o o o o a b c d e" in 
  let ch1 = "a b c d e o o o o o a b c d e" in 
  let ts3 = "a b c d o o a b c d e z q q q q q q z a b c d e" in 
  let chunks = [| 
    (Text.split_into_words false (Vec.singleton ch0));
    (Text.split_into_words false (Vec.singleton ch1)) 
  |] in
  let tsa3 = Text.split_into_words false (Vec.singleton ts3) in
  let (c, l) = text_tracking chunks tsa3 in
  print_chunks chunks;
  print_string "Words:\n";
  Text.print_words tsa3;
  print_string "\n";
  print_chunks c;
  print_mdiff l
end;;


(** Unit test for edit diff *)
if false then 
  begin 
    let text1a = "la capra canta contenta sotto la collina sopra la panca la capra campa" in
    let text1b = "sotto la panca la capra crepa e la capra canta" in
    
    let text2a = "nel bel mezzo del cammin di nostra vita mi trovai in una selva oscura che la diritta via era smarrita" in
    let text2b = "nel frammezzo del cammin di nostra esistenza mi trovai nel bel mezzo di una selva oscura dove la via era smarrita e non mi trovai nel cammin di casa nostra" in
    
    let text3a = "a me piace bere il caffe' dopo che mi sono svegliato" in
    let text3b = "dopo che mi sono svegliato, a me piace bere il mio caffe'" in
    
    let test_edit_diff t1 t2 = 
      let w1 = Text.split_into_words false (Vec.singleton t1) in 
      let w2 = Text.split_into_words false (Vec.singleton t2) in 
      let i2 = make_index_diff w2 in 
      let e = edit_diff w1 w2 i2 in 
      Text.print_words w1; 
      Text.print_words w2;  
      print_diff e
    in

    test_edit_diff text1a text1b;
    test_edit_diff text2a text2b;
    test_edit_diff text3a text3b
  end;;

(** Another unit test for edit diff *)
if false then 
  begin 
    let ts1 = "a b c d e o o o o o a b c d e" in 
    let ts2 = "a b c d e q q a b c d e q q q q a b c d e" in 
    let test_edit_diff t1 t2 = 
      let w1 = Text.split_into_words false (Vec.singleton t1) in 
      let w2 = Text.split_into_words false (Vec.singleton t2) in 
      let i2 = make_index_diff w2 in 
      let e = edit_diff w1 w2 i2 in 
      Text.print_words w1; 
      print_string "\n";
      Text.print_words w2;  
      print_diff e
    in
    
    test_edit_diff ts1 ts2
  end;;

(** Unit test for text distance *)
if false then begin
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

  let t = [|ta1; ta2; ta3; ta4; ta5; ta6; ta7; ta8; ta9; ta10|] in 
  let len = Array.length (t) in 
  for i = 0 to len - 1 do 
    begin
      print_newline (); 
      print_string ((string_of_int (i + 1)) ^ ": ");
      let idx = make_index_diff t.(i) in 
      for j = 0 to i - 1 do 
	begin
	  let l1 = Array.length (t.(i)) in 
	  let l2 = Array.length (t.(j)) in 
	  let l = min l1 l2 in 
	  print_string (string_of_float (edit_distance (edit_diff t.(j) t.(i) idx) l));
	  print_string " "
	end
      done
    end
  done;
  print_newline ()
end;;

