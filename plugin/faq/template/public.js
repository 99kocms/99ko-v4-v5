var faqIe = (document.all) ? true : false;
function faqHideEntries(objClass){
	var elements = (faqIe) ? document.all : document.getElementsByTagName('*');
	for (i=0; i<elements.length; i++){
		if (elements[i].className==objClass){
			elements[i].style.display="none";
		}
	}
}
function faqShowEntry(objID){
	var element = (faqIe) ? document.all(objID) : document.getElementById(objID);
	var content = element.innerHTML;
	element = (faqIe) ? document.all('faqContent') : document.getElementById('faqContent');
	element.innerHTML = content;
	window.scrollTo(0, 0);
}
