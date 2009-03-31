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

(** Priority Queue *)

module Make (A : sig type t val compare : t -> t -> int end) =
  struct
    exception Empty
      
    type 'a elt = { 
      mutable priority:A.t;
      mutable contents:'a 
    }
    type 'a t = { 
      mutable n:int;
      mutable a:'a elt option array;
    } 
	
    let lt x y =
      match (x,y) with
      | (None,None) -> false
      | (Some(x),None) -> true
      | (None,Some(x)) -> false
      | (Some(x),Some(y)) -> A.compare x.priority y.priority = -1
      
    let create () = { n = 0; a = Array.create 256 None }
	
    let clear q =
      for i = 0 to q.n - 1 do
	q.a.(i) <- None
      done;
      q.n <- 0
	
    let is_empty q = q.n = 0
    let length q = q.n
      
    let iter (f:int -> A.t -> 'a -> unit) q =
      for i = 0 to q.n - 1 do
	match q.a.(i) with
	| Some(x) -> f i x.priority x.contents
	| None -> raise (Invalid_argument "malformed queue")
      done
	
    (* priorites are sorted in ascending order *)

    let array_swap q i j =
      let t = q.a.(i) in
      q.a.(i) <- q.a.(j);
      q.a.(j) <- t
	
    let child_0 i = i * 2 + 1
    let child_1 i = i * 2 + 2
    let parent i = (i - 1) / 2
      
    let rec percolate_up q i =
      if i > 0 && (lt q.a.(i) q.a.(parent i)) then
	begin
	  array_swap q i (parent i);
	  percolate_up q (parent i)
	end
	  
    (** Internal *)	
    let rec percolate_down q i =
      let swap_and_percolate j =
	begin
	  array_swap q i j;
	  percolate_down q j
	end
      in
      if child_1 i < q.n then
	begin
	  if lt q.a.(child_0 i) q.a.(child_1 i) then
	    swap_and_percolate (child_0 i)
	  else
	    swap_and_percolate (child_1 i)
	end
      else
	if child_0 i < q.n then
	  swap_and_percolate (child_0 i)
	else
	  ()
	    
    let add q x p =
      let n = q.n in
      if n = Array.length q.a then
	  q.a <- Array.append q.a (Array.create 256 None);
      let c = { priority = p; contents = x } in
      q.a.(n) <- Some c;
      q.n <- n + 1;
      percolate_up q n;
      c
	
    let take q =
      if q.n = 0 then raise Empty
      else
	let r = q.a.(0) in
	let n = q.n in
	q.a.(0) <- None;
	q.n <- n - 1;
	if n > 1 
	then
	  begin
      	    array_swap q 0 (n - 1);
	    percolate_down q 0
	  end;
	match r with
	| Some(x) -> x
	| None -> raise (Invalid_argument "malformed queue")
	    
  end

