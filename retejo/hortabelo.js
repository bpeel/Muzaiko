/* Cxi tiu dosiero estas auxtomate farite per mallongigi-hortabelon.sh.
   Bonvolu ne redakti gxin. */
(function(){function e(i){i=i.toString();if(i.length<2){return"0"+i}else{return i}}function n(i){i=new Date(i*1000);return(e(i.getHours())+":"+e(i.getMinutes()))}var h;programo.sort(function(o,i){return o[0]-i[0]});var m=programo[0][0];var a=programo[programo.length-1][1];var b=new Date();var c=b.getTime()/1000-m;if(c<0){return}var f=a-m;var l=c%f;var j=Math.floor(c/f);var d=m+j*f;var k=null;for(h=0;h<programo.length;h++){if(l+m>=programo[h][0]&&l+m<programo[h][1]){k=h;break}}if(k===null){return}var g=function(){var r;var v=document.getElementById("programo");v.innerHTML="";r=k;do{var w=programo[r];var p=document.createElement("li");var u=w[0]-m+d;var o=w[1]-m+d;var s=(n(u)+"\u2013"+n(o)+": ");p.appendChild(document.createTextNode(s));var q=document.createElement("span");q.innerHTML=w[2];p.appendChild(q);v.appendChild(p);if(++r>=programo.length){d+=f;r=0}}while(r!=k);var t=document.getElementById("tempozononoto");t.innerHTML=(" \u0108iuj horoj montri\u011das la\u016d via loka tempozono.")};if(window.addEventListener){window.addEventListener("load",g,false)}else{if(window.attachEvent){window.attachEvent("onload",g)}}})();