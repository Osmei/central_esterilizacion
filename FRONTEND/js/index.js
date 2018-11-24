const urlBase = "http://localhost/central_esterilizacion/BACKEND/Public/index.php/api";

const operadorSelect = document.getElementById("operadorSelect");
const metodoSelect = document.getElementById("metodoSelect");
const proveedorSelect = document.getElementById("proveedorSelect");
const empresaSelect = document.getElementById("empresaSelect");

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
        const metodos = response[1];
        const proveedores = response[2];
        const empresas = response[3];
        
        let opcionesOperadores = "<option id=0>Seleccione un operador</option>";
        operadores.map((operador, index) => {            
            opcionesOperadores += "<option id="+operador.id+">"+operador.nombre+"</option>";
        })
        operadorSelect.innerHTML = opcionesOperadores;

        let opcionesMetodos = "<option id=0>Seleccione un método</option>";
        metodos.map((metodo, index) => {            
            opcionesMetodos += "<option id="+metodo.id+">"+metodo.nombre+"</option>";
        })
        metodoSelect.innerHTML = opcionesMetodos;

        let opcionesProveedores = "<option id=0>Seleccione un operador</option>";
        proveedores.map((proveedor, index) => {            
            opcionesProveedores += "<option id="+proveedor.id+">"+proveedor.nombre+"</option>";
        })
        proveedorSelect.innerHTML = opcionesProveedores;

        let opcionesEmpresas = "<option id=0>Seleccione un método</option>";
        empresas.map((empresa, index) => {            
            opcionesEmpresas += "<option id="+empresa.id+">"+empresa.nombre+"</option>";
        })
        empresaSelect.innerHTML = opcionesEmpresas;


    }
);