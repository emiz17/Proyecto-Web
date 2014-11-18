
function guardarDatos(){
 	sessionStorage.nombre = document.getElementById("nombre").value;
 	sessionStorage.password = document.getElementById("password").value;
 	// alert("Nombre: " + sessionStorage.nombre + "<br/> Password: " + sessionStorage.password);
}
 
function recuperarDatos(){
 	if ((localStorage.nombre != undefined) && (localStorage.password != undefined)) {
 		document.getElementById("datos").innerHTML = "Nombre: " + localStorage.nombre + "<br/> Password: " + localStorage.password;
 	}
 	else{
  		document.getElementById("datos").innerHTML = "No has introducido tu nombre y tu password";
 	}
}
