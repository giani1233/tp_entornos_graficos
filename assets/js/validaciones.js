document.addEventListener('DOMContentLoaded', function() {
    const selectTipo = document.getElementById('tipoUsuario');
    if(selectTipo) {
        selectTipo.addEventListener('change', mostrarSelectorLocal)
    }

    const formRegistro = document.getElementById('formRegistro')
    if(formRegistro) {
        formRegistro.addEventListener('submit', validarRegistro)
    }
})

function mostrarSelectorLocal() {
    const tipoUsuario = document.getElementById('tipoUsuario').value;
    const selectorLocal = document.getElementById('selector-local');
    const selectLocal = document.getElementById('codLocal');

    if (tipoUsuario === 'dueño'){
        selectorLocal.style.display = 'block';
        if(selectLocal) {
            selectLocal.required = true;
        } 
    } else {
        selectorLocal.style.display = 'none';
        if(selectLocal) {
            selectLocal.required = false;
        } 
    }
}

function validarRegistro(event) {
    event.preventDefault();

    const nombre = document.getElementById('nombreUsuario').value;
    const apellido = document.getElementById('apellidoUsuario').value;
    const email = document.getElementById('emailUsuario').value;
    const contraseña = document.getElementById('passwordUsuario').value;
    const confirmar = document.getElementById('confirmPasswordUsuario').value;
    const tipoUsuario = document.getElementById('tipoUsuario').value;
    const localId = document.getElementById('local_id') ? document.getElementById('local_id').value : '';

    let errores = [];

    if(nombre == null || apellido == null || email == null || contraseña == null || confirmar == null || tipoUsuario == null){
        errores.push['Debe completar todos los campos']
    }

    if (contraseña !== confirmar) {
        errores.push('Las contraseñas no coinciden');
    } 

    if (contraseña.length < 8){
        errores.push('La contraseña debe tener al menos 8 caracteres');
    }

    if (errores.length > 0) {
        alert('Errores:\n' + errores.join('\n'));
        return false;
    }

    event.target.submit();
}

