window.addEventListener('DOMContentLoaded', () => {
   const btnEnviar = document.getElementById('btn-enviar');

   btnEnviar.addEventListener('click', (e) => {
      e.preventDefault()
      
      const formulario = {
         operador: null,
         fecha: null,
         hora: null,
         paciente: null,
         nhc: null,
         descripcion: null,
         medico: null,
         peso: null,
         proveedor: null,
         empresa: null,
         metodo: null,
         observaciones: null
      }

      getDataForm(formulario);

      let divError = document.getElementById('error')
      let paciente = document.getElementById('paciente')
      let descripcion = document.getElementById('descripcion')
      let proveedor = document.getElementById('proveedorSelect')
      
      if (!paciente.value) {
         divError.classList.add('error')
         divError.innerText = 'Campo Requerido'
         paciente.focus()
      } else if (!descripcion.value) {
         divError.classList.add('error')
         divError.innerText = 'Campo Requerido' 
         descripcion.focus()
      }  else if (!proveedor.value) {
         divError.classList.add('error')
         divError.innerText = 'Campo Requerido'
         proveedor.focus()
      } else {
         divError.classList.remove('error')
         divError.innerText = ''
      }
   })

   getDataForm = (formulario) => {
      const operadorSelect = document.getElementById("operadorSelect");
      const idOperador = operadorSelect.options[operadorSelect.selectedIndex].id;
      const fecha = document.getElementById("fecha").value;
      const hora = document.getElementById("hora").value;
      const paciente = document.getElementById("paciente").value;
      const nhc = document.getElementById("nhc").value;
      const descripcion = document.getElementById("descripcion").value;
      const medico = document.getElementById("medico").value;
      const peso = document.getElementById("peso").value;
      const proveedorSelect = document.getElementById("proveedorSelect");
      const idProvedor = proveedorSelect.options[proveedorSelect.selectedIndex].id;
      const empresaSelect = document.getElementById("empresaSelect");
      const idEmpresa = empresaSelect.options[empresaSelect.selectedIndex].id;
      const metodoSelect = document.getElementById("metodoSelect");
      const idMetodo = metodoSelect.options[metodoSelect.selectedIndex].id;
      const observaciones = document.getElementById("observaciones").value;

      formulario.operador = idOperador;
      formulario.fecha = fecha;
      formulario.hora = hora;
      formulario.paciente = paciente;
      formulario.nhc = nhc;
      formulario.descripcion = descripcion;
      formulario.medico = medico;
      formulario.peso = peso;
      formulario.proveedor = idProvedor;
      formulario.empresa = idEmpresa;
      formulario.metodo = idMetodo;
      formulario.observaciones = observaciones;

      console.log(formulario);
   }
})
   
