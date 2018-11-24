const urlBase = "http://localhost/central_esterilizacion/BACKEND/Public/index.php/api";
const operadorSelect = document.getElementById("operadorSelect");

let get = (url) => {
        return fetch(urlBase + url, {
            method: "GET",
            accept: "application/json",
            contentType: "application/json"
        })
        .then((response) => {
            return response.json();
        });
    }

let promises = [];

const metodos = get("/metodos");
const operadores = get("/operadoresCE");
const proveedores = get("/proveedores");
const empresas = get("/empresasEsterilizadoras");

promises.push(operadores, metodos, proveedores, empresas);

Promise.all(promises)
.then(
    (response) => {
        const operadores = response[0];
        
        let opcionesOperadores = "<option id=0>Seleccione un operador</option>";
        operadores.map((operador, index) => {            
            opcionesOperadores += "<option id="+operador.id+">"+operador.nombre+"</option>";
        })
        operadorSelect.innerHTML = opcionesOperadores;
    }
);