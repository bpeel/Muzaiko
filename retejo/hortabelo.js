/* Cxi tiu dosiero estas auxtomate farite per mallongigi-hortabelon.sh.
   Bonvolu ne redakti gxin. */
(function(){function c(e){e=e.toString();if(e.length<2){return"0"+e}else{return e}}function d(e){return(c(e.getHours())+":"+c(e.getMinutes()))}function a(f){var i;var e,h;if((e=f.getAttribute("komenctempo"))&&(h=f.getAttribute("fintempo"))){var g=(d(new Date(parseInt(e)*1000))+"\u2013"+d(new Date(parseInt(h)*1000)));f.innerHTML="";f.appendChild(document.createTextNode(g))}for(i=f.firstChild;i;i=i.nextSibling){if(i.nodeType==1){a(i)}}}var b=function(){var f;var h=document.getElementById("aktualaprogramo");var j=document.createElement("div");j.innerHTML=("\u0108iuj horoj montri\u011das la\u016d via loka horzono.");j.setAttribute("id","horzononoto");h.insertBefore(j,h.firstChild);a(h);var g=document.getElementById("ripetlimo");var e=new Date();e.setUTCHours(4,0);g.innerHTML=(d(e)+" la\u016d via loka horzono")};if(window.addEventListener){window.addEventListener("load",b,false)}else{if(window.attachEvent){window.attachEvent("onload",b)}}})();