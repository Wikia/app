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

(* The match quality is a tuple: match length, chunk index 
   (the lower the better), and a floating-point "quality". *)
type match_quality_t = int * int * float

module type Elqt = 
  sig
    type t = int * int * float
    val compare: t -> t -> int
  end

module OrderedMatch: Elqt = struct 
  type t = int * int * float
  let compare (el1: match_quality_t) (el2: match_quality_t) : int = 
    let (l1, c1, q1) = el1 in 
    let (l2, c2, q2) = el2 in 
    (* The longer, the better *)
    if l1 < l2 then 1
    else if l1 > l2 then -1
      (* The lower chunk, the better *)
    else if c1 < c2 then -1
    else if c1 > c2 then 1
      (* The lower the mismatch, the better *)
    else if q1 < q2 then -1
    else if q1 > q2 then 1
    else 0
end;;

(* In the other code, do: 
   module Heap = Queue.PriorityQueue *)

module PriorityQueue = Prioq.Make (OrderedMatch);;
