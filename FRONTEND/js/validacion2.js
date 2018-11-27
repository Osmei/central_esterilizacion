window.addEventListener('DOMContentLoaded', () => {
   const btnEnviar = document.getElementById('btn-enviar')

   btnEnviar.addEventListener('click', (e) => {
      e.preventDefault()
      
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
})
   
