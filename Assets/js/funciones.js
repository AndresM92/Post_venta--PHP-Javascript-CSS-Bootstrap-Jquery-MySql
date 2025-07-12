//////////////////////////////////////Usuarios///////////////////////////////////////////

let t_Usuarios,t_Clientes;

function frmLogin(e) {
    /*window.location="http://localhost/pos_venta/Usuarios";*/
    e.preventDefault();
    const usuario = document.getElementById("usuario");
    const clave = document.getElementById("clave");

    if (usuario.value == "" || clave.value == "") {
        //alertify.error("Todo los campos son requeridos");
        Swal.fire({
            icon: "error",
            title: "Todo los campos son requeridos",
            timer: 3000
        });
    } else {
        const url = base_url + "Usuarios/validar";
        const frm = document.getElementById("frmLoginn");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res.msg == "Iniciando sesion") {
                    
                    window.location.href = base_url + "Usuarios";
                } else {
                    document.getElementById("alerta").classList.remove("d-none");
                    document.getElementById("alerta").innerHTML = res;
                }
            }
        }
    }
}

$(document).ready(function () {
    t_Clientes = $('#ta_Clientes').DataTable({
        ajax: {
            url: base_url + "Clientes/listar",
            dataSrc: "",
        },
        columns: [
            { data: 'id' },
            { data: 'cc' },
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'direccion' },
            { data: 'estado' },
            { data: 'acciones' }
        ]

    });
});

$(document).ready(function () {
    //let t_Usuarios;
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

function frmUsers() {
    document.getElementById("title").innerHTML = "Nuevo Usuario";
    document.getElementById("btnAction").innerHTML = "Registrar";
    document.getElementById("passwords").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    document.getElementById("id").value = "";
    $("#new_user").modal("show");
}

function register_user(e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    const usuario = document.getElementById("usuario");
    const nombre = document.getElementById("nombre");
    const pass = document.getElementById("pass");
    const confirmar = document.getElementById("confirmar");
    const caja = document.getElementById("caja");

    // Validaciones
    if (usuario.value == "" || nombre.value == "" || caja.value == "") {
        Swal.fire({
            icon: "error",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    } else if (pass.value != confirmar.value) {
        Swal.fire({
            icon: "error",
            title: "Las contraseñas no coinciden",
            timer: 3000
        });
    } else {
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
                            t_Usuarios.ajax.reload();

                        } else if (response.msg == "Usuario modificado con éxito") {
                            Swal.fire({
                                title: "Usuario modificado con éxito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            //frm.reset();
                            $("#new_user").modal("hide");
                            t_Usuarios.ajax.reload(null, true);


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

            document.getElementById("id").value = res.id;
            document.getElementById("usuario").value = res.usuario;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("caja").value = res.id_caja;
            document.getElementById("passwords").classList.add("d-none");
            $("#new_user").modal("show");
        }
    };
}

function btn_delete_User(id) {

    Swal.fire({
        title: "Estas seguro de eliminar?",
        text: "El usuario no se eliminara de forma permanente, solo pasara a estado inactivo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/eliminar/" + id; // Asegúrate de que base_url esté definido
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Usuario eliminado con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Usuarios.ajax.reload();

                    } else {
                        Swal.fire(
                            response.msg,
                            response,
                            "error"
                        )
                    }
                }
            }
        }
    })
}

function btn_reingre_User(id) {

    Swal.fire({
        title: "Estas seguro de reingresar el usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/reingresar/" + id; // Asegúrate de que base_url esté definido
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Usuario reingresado con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Usuarios.ajax.reload();

                    } else {
                        Swal.fire(
                            response.msg,
                            response,
                            "error"
                        )
                    }
                }
            }
        }
    })
}

//////////////////////////////////////Clientes////////////////////////////////////////////

function frmCustomers() {
    document.getElementById("title").innerHTML = "Nuevo Cliente";
    document.getElementById("btnAction").innerHTML = "Registrar";
    document.getElementById("frmCustomerr").reset();
    document.getElementById("id").value = "";
    $("#new_customer").modal("show");
     
}

function register_customer(e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    const usuario = document.getElementById("CC");
    const nombre = document.getElementById("nombre");
    const pass = document.getElementById("telefono");
    const confirmar = document.getElementById("direccion");

    // Validaciones
    if (cc.value == "" || nombre.value == "" || telefono.value == ""|| direccion.value == "") {
        Swal.fire({
            icon: "error",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    } else {
        const url = base_url + "Clientes/registrar"; // Asegúrate de que base_url esté definido
        const frm = document.getElementById("frmCustomerr");
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
                            $("#new_customer").modal("hide");
                            t_Clientes.ajax.reload();

                        } else if (response.msg == "Cliente modificado con éxito") {
                            Swal.fire({
                                title: "Cliente modificado con éxito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            //frm.reset();
                            $("#new_customer").modal("hide");
                            t_Clientes.ajax.reload(null, true);
                        }
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

function btn_edit_Customer(id) {
    document.getElementById("title").innerHTML = "Actualizar Cliente";
    document.getElementById("btnAction").innerHTML = "Modificar";
    const url = base_url + "Clientes/editar/" + id; // Asegúrate de que base_url esté definido
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            document.getElementById("id").value = res.id;
            document.getElementById("cc").value = res.cc;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("direccion").value=res.direccion;
            $("#new_customer").modal("show");
        }
    };
}

function btn_delete_Customer(id) {

    Swal.fire({
        title: "Estas seguro de eliminar?",
        text: "El cliente no se eliminara de forma permanente, solo pasara a estado inactivo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Clientes/eliminar/" + id; // Asegúrate de que base_url esté definido
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Cliente eliminado con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Clientes.ajax.reload();

                    } else {
                        Swal.fire(
                            response.msg,
                            response,
                            "error"
                        )
                    }
                }
            }
        }
    })
}

function btn_reingre_Customer(id) {

    Swal.fire({
        title: "Estas seguro de reingresar el cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Clientes/reingresar/" + id; // Asegúrate de que base_url esté definido
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Cliente reingresado con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Clientes.ajax.reload();

                    } else {
                        Swal.fire(
                            response.msg,
                            response,
                            "error"
                        )
                    }
                }
            }
        }
    })
}