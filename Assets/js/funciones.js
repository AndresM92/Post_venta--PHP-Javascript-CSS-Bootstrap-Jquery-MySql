
$(document).ready(function () {
    let t_Usuarios;
    t_Usuarios = $('#ta_Usuarios').DataTable({
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: "",
            /*error: function(xhr, error, thrown) {
                console.error("Error en DataTables:", error);
                console.log("Respuesta del servidor:", xhr.responseText);
            }*/
        },
        columns: [
            { data: 'id' },
            { data: 'usuario' },
            { data: 'nombre' },
            { data: 'caja' },
            { data: 'estado' },
            { data: 'acciones' }
        ]

    });
});

function frmLogin(e) {
    /*window.location="http://localhost/pos_venta/Usuarios";*/
    e.preventDefault();
    const usuario = document.getElementById("usuario");
    const clave = document.getElementById("clave");

    if (usuario.value == "" || clave.value == "") {
        alertify.error("Todo los campos son requeridos");
    } else {
        const url = base_url + "Usuarios/validar";
        const frm = document.getElementById("frmLogin");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res == "success") {
                    window.location = base_url + "Usuarios";
                } else {
                    document.getElementById("alerta").classList.remove("d-none");
                    document.getElementById("alerta").innerHTML = res;
                }
            }
        }
    }
}

function frmUsers() {
    document.getElementById("title").innerHTML = "Nuevo Usuario";
    document.getElementById("btnAction").innerHTML = "Registrar";
    document.getElementById("passwords").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    $("#new_user").modal("show");
}

/*
function register_user(e) {
    e.preventDefault();
    const usuario = document.getElementById("usuario");
    const nombre = document.getElementById("nombre");
    const clave = document.getElementById("clave");
    const confirmar = document.getElementById("confirmar");
    const caja = document.getElementById("caja");

    if (usuario.value == "" || clave.value == "" || nombre.value == "" || caja.value == "") {
        Swal.fire({
            icon: "error",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    } else if (clave.value != confirmar.value) {
        Swal.fire({
            icon: "error",
            title: "Las contraseñas no coinciden",
            timer: 3000
        });

    } else {
        const url = base_url + "Usuarios/registrar";
        const frm = document.getElementById("frmUsuario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const contentType = this.getResponseHeader('Content-Type');
                const response = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    alertify.success(res.msg);
                    setTimeout(() => {
                        window.location = base_url + "dashboard";
                    }, 1500);                    
                }
            }
        }

    }
}*/

function register_user(e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    const usuario = document.getElementById("usuario");
    const nombre = document.getElementById("nombre");
    const pass = document.getElementById("pass");
    const confirmar = document.getElementById("confirmar");
    const caja = document.getElementById("caja");

    // Validaciones
    if (usuario.value == ""  || nombre.value == "" || caja.value == "") {
        Swal.fire({
            icon: "error",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    } /*else if (pass.value != confirmar.value) {
        Swal.fire({
            icon: "error",
            title: "Las contraseñas no coinciden",
            timer: 3000
        });
    } */else {
        const url = base_url + "Usuarios/registrar"; // Asegúrate de que base_url esté definido
        const frm = document.getElementById("frmUsuario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const contentType = this.getResponseHeader('Content-Type');
                if (contentType && contentType.includes('application/json')) {
                    try {
                        const response = JSON.parse(this.responseText);
                        if (response.msg == "Cliente registrado con éxito") {
                            Swal.fire({
                                title: "Registrado Exitosamente",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            frm.reset();
                            $("#new_user").modal("hide");
                        } else if (response.msg == "Usuario modificado con éxito") {
                            Swal.fire({
                                title: "Usuario modificado con éxito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            frm.reset();
                            $("#new_user").modal("hide");
                            

                        }/* else if (response.msg == "Todos los campos son obligatorios") {
                            Swal.fire({
                                title: response.msg,
                                icon: "info",
                                draggable: true,
                                timer: 3000
                            });
                            $("#new_user").modal("hide");
                        }*/
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: response.msg,
                                timer: 3000
                            });
                        }
                    } catch (e) {
                        console.error("Error al parsear JSON:", e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Hubo un problema con la respuesta del servidor.',
                            timer: 3000
                        });
                    }
                } else {
                    console.error("La respuesta del servidor no es JSON. Respuesta recibida:", this.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'La respuesta del servidor no es válida.',
                        timer: 3000
                    });
                }
            }
        };
    }
}

function btn_edit_User(id) {
    document.getElementById("title").innerHTML = "Actualizar Usuario";
    document.getElementById("btnAction").innerHTML = "Modificar";
    const url = base_url + "Usuarios/editar/" + id; // Asegúrate de que base_url esté definido
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            document.getElementById("id").value=res.id;
            document.getElementById("usuario").value=res.usuario;
            document.getElementById("nombre").value=res.nombre;
            document.getElementById("caja").value=res.id_caja;
            document.getElementById("passwords").classList.add("d-none");
            $("#new_user").modal("show");
        }
    };
}