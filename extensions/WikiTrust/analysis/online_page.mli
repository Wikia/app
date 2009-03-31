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

(** This class does the main job of evaluating a revision, computing the trust
    of its words, as well as the reputation increments for various wiki users. 
    The call is: 
    [new page db logger page_id revision_id coeff]
    where: 
    [db] is the db handle
    [logger] is the logger handle
    [page_id] is the page_id of the revision that is to be processed
    [revision_id] is the revision id to be processed.  All previous revisions
                  should have already been processed. 
    [coeff] contains the coefficients to be used for the evaluation. 

    The methods of this class, such as [vote] and [eval], should be 
    called NO MORE THAN ONCE. 
 *)

exception Missing_trust of int * int

class page :
  (** Database handle *)
  (* db *) Online_db.db ->
  (** Logger handle *)
  Online_log.logger ->
  (** page_id of the page to analyze *)
  (* page_id *) int ->
  (** revision id of the revision to analyze. All previous revisions should
      have been already evaluated. *)
  (* revision_id *) int -> 
  (** Coefficients to be used for the evaluation *)
  (* trust_coeff *) Online_types.trust_coeff_t ->
  (** Number of retries in the use of transactions *)
  (* n_retries *) int -> 
  object
    (** [eval] is used to evaluate the trust of the given [page_id], [revision_id],
	and update all reputations, etc etc.  This is the main method of the 
	online code.  If the page has already been evaluated, it does nothing. 
	It returns a flag indicating whether it did something. *)
    method eval : bool

    (** [vote voter_uid] is called to process the fact that user [voter_uid] 
	has pushed on the "I agree with this revision" button.  
        The method does something only if the revision is the latest for the page. 
	It returns a flag indicating whether it did something. *)
    method vote : int -> bool

  end
