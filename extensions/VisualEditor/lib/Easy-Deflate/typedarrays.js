/**
Copyright (c) 2013, Specialisterne.
All rights reserved.
Authors:
Jacob Christian Munch-Andersen

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met: 

1. Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer. 
2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution. 

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
**/
;(function(){
	/**
	 * Light shim for JavaScript typed arrays.
	 *
	 * IMPORTANT: This code is not intended to replicate the behaviour of typed
	 * arrays in JavaScript exacly, several features are left out or implemented
	 * dirreferently in order to acheive high performance and browser
	 * compatibility. Code should be tested thorougly both with this shim active
	 * and with a native implementation.
	 * 
	 * For more information and newest version go to:
	 * https://github.com/Jacob-Christian-Munch-Andersen/Typed-arrays-light-shim
	**/
	function Typedarray(length,elementlength,begin,end){
		var obj=[]
		var a
		if(typeof length=="number"){
			for(a=0;a<length;a++){
				obj.push(0)
			}
		}
		else{
			if(end==null){
				begin=0
				end=length.length
			}
			for(a=begin;a<end;a++){
				obj.push(length[a])
			}
		}
		obj.subarray=subarray
		obj.set=set
		obj.byteLength=obj.length*elementlength
		obj.byteOffset=0
		function subarray(begin,end){
			return Typedarray(obj,elementlength,begin,end)
		}
		function set(arr,w){
			w=w||0
			var a
			var target=obj
			var len=arr.length
			for(a=0;a<len;a++,w++){
				target[w]=arr[a]
			}
		}
		return obj
	}
	function array1(length){
		return Typedarray(length,1)
	}
	function array2(length){
		return Typedarray(length,2)
	}
	function array4(length){
		return Typedarray(length,4)
	}
	function array8(length){
		return Typedarray(length,8)
	}
	if(!window.Uint8Array){
		window.Uint8Array=array1
	}
	if(!window.Int8Array){
		window.Int8Array=array1
	}
	if(!window.Uint16Array){
		window.Uint16Array=array2
	}
	if(!window.Int16Array){
		window.Int16Array=array2
	}
	if(!window.Uint32Array){
		window.Uint32Array=array4
	}
	if(!window.Int32Array){
		window.Int32Array=array4
	}
	if(!window.Float32Array){
		window.Float32Array=array4
	}
	if(!window.Float64Array){
		window.Float64Array=array8
	}
}())
