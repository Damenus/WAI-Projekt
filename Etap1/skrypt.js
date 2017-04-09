function licz_wizyty() {
	if(sessionStorage.licznik_wizyt) {
		sessionStorage.licznik_wizyt = Number(sessionStorage.licznik_wizyt) + 1;
	}
	else
		sessionStorage.licznik_wizyt = 1;
	
	if(localStorage.licznik_odswiez) {
		localStorage.licznik_odswiez = Number(localStorage.licznik_odswiez) + 1;
	}
	else
		localStorage.licznik_odswiez = 1;
	var div = document.getElementById("licznik");
	div.innerHTML = "Licznik odwiedzin. Odwiedźiłeś tą podstronę " +
	localStorage.licznik_odswiez + " razy. " + 
	"Odświerzyłeś tą stronę w tej sesji " + sessionStorage.licznik_wizyt + 
	" razy. " ;
}	
function load_podzial(){
	$.ajax({
        url: "podzial.html",
    }).done(function (data) {
        $('#wynik').html(data);
    });
}

function zmiana_koloru() {
	document.getElementById("content").style.color='red';
	
}
function modifikacja() {
	var usun = document.getElementById("wynik");
	usun.parentNode.removeChild(usun);
	
}
	
