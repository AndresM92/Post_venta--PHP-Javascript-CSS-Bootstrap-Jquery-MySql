//////////////////////////////////////Usuarios///////////////////////////////////////////

let t_Usuarios, t_Clientes, t_Categorias, t_Cajas, t_Medidas, t_Productos;

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

$(document).ready(function () {
    t_Categorias = $('#ta_Categorias').DataTable({
        ajax: {
            url: base_url + "Categorias/listar",
            dataSrc: "",
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'estado' },
            { data: 'acciones' }
        ]

    });
});

$(document).ready(function () {
    t_Cajas = $('#ta_Cajas').DataTable({
        ajax: {
            url: base_url + "Cajas/listar",
            dataSrc: "",
        },
        columns: [
            { data: 'id' },
            { data: 'caja' },
            { data: 'estado' },
            { data: 'acciones' }
        ]

    });
});

$(document).ready(function () {
    t_Medidas = $('#ta_Medidas').DataTable({
        ajax: {
            url: base_url + "Medidas/listar",
            dataSrc: "",
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'nombre_corto' },
            { data: 'estado' },
            { data: 'acciones' }
        ]

    });
});

$(document).ready(function () {
    t_Productos = $('#ta_Productos').DataTable({
        ajax: {
            url: base_url + "Productos/listar",
            dataSrc: "",
        },
        columns: [
            { data: 'id' },
            { data: 'imagen' },
            { data: 'codigo' },
            { data: 'descripcion' },
            { data: 'precio_venta' },
            { data: 'cantidad' },
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
    if (cc.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == "") {
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
            document.getElementById("direccion").value = res.direccion;
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

//////////////////////////////////////Categorias////////////////////////////////////////////

function frmCategories() {
    document.getElementById("title").innerHTML = "Nueva Categoria";
    document.getElementById("btnAction").innerHTML = "Registrar";
    document.getElementById("frmCategoryy").reset();
    document.getElementById("id").value = "";
    $("#new_category").modal("show");

}

function register_category(e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    const nombre = document.getElementById("nombre");

    // Validaciones
    if (nombre.value == "") {
        Swal.fire({
            icon: "error",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    } else {
        const url = base_url + "Categorias/registrar"; // Asegúrate de que base_url esté definido
        const frm = document.getElementById("frmCategoryy");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const contentType = this.getResponseHeader('Content-Type');
                if (contentType && contentType.includes('application/json')) {
                    try {

                        const response = JSON.parse(this.responseText);
                        if (response.msg == "Categoria registrado con éxito") {
                            Swal.fire({
                                title: "Registrado Exitosamente",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            frm.reset();
                            $("#new_category").modal("hide");
                            t_Categorias.ajax.reload();

                        } else if (response.msg == "Categoria modificado con éxito") {
                            Swal.fire({
                                title: "Categoria modificado con éxito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            //frm.reset();
                            $("#new_category").modal("hide");
                            t_Categorias.ajax.reload(null, true);
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

function btn_edit_Category(id) {

    document.getElementById("title").innerHTML = "Actualizar Categoria";
    document.getElementById("btnAction").innerHTML = "Modificar";
    const url = base_url + "Categorias/editar/" + id; // Asegúrate de que base_url esté definido
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            document.getElementById("id").value = res.id;
            document.getElementById("nombre").value = res.nombre;
            $("#new_category").modal("show");
        }
    };
}

function btn_delete_Category(id) {

    Swal.fire({
        title: "Estas seguro de eliminar?",
        text: "La categoria no se eliminara de forma permanente, solo pasara a estado inactivo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Categorias/eliminar/" + id; // Asegúrate de que base_url esté definido
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Categoria eliminada con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Categorias.ajax.reload();

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

function btn_reingre_Category(id) {

    Swal.fire({
        title: "Estas seguro de reingresar la Categoria?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Categorias/reingresar/" + id; // Asegúrate de que base_url esté definido
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Categoria reingresado con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Categorias.ajax.reload();

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

//////////////////////////////////////Cajas////////////////////////////////////////////

function frmBoxes() {
    document.getElementById("title").innerHTML = "Nueva Caja";
    document.getElementById("btnAction").innerHTML = "Registrar";
    document.getElementById("frmBoxx").reset();
    document.getElementById("id").value = "";
    $("#new_box").modal("show");

}

function register_Box(e) {
    e.preventDefault();
    const caja = document.getElementById("caja");

    if (caja.value == "") {
        Swal.fire({
            icon: "error",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    } else {
        const url = base_url + "Cajas/registrar";
        const frm = document.getElementById("frmBoxx");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const contentType = this.getResponseHeader('Content-Type');
                if (contentType && contentType.includes('application/json')) {
                    try {

                        const response = JSON.parse(this.responseText);
                        if (response.msg == "Caja registrada con éxito") {
                            Swal.fire({
                                title: "Registrado Exitosamente",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            frm.reset();
                            $("#new_box").modal("hide");
                            t_Cajas.ajax.reload();

                        } else if (response.msg == "Caja modificada con éxito") {
                            Swal.fire({
                                title: "Catja modificado con éxito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            $("#new_box").modal("hide");
                            t_Cajas.ajax.reload(null, true);
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

function btn_edit_Box(id) {

    document.getElementById("title").innerHTML = "Actualizar Caja";
    document.getElementById("btnAction").innerHTML = "Modificar";
    const url = base_url + "Cajas/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("caja").value = res.caja;
            $("#new_box").modal("show");
        }
    };
}

function btn_delete_Box(id) {

    Swal.fire({
        title: "Estas seguro de eliminar?",
        text: "La caja no se eliminara de forma permanente, solo pasara a estado inactivo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Cajas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Caja eliminada con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Cajas.ajax.reload();

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

/*function btn_reingre_Box(id) {

    Swal.fire({
        title: "Estas seguro de reingresar la Caja?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Cajas/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Caja reingresada con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Cajas.ajax.reload();

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
}*/

//////////////////////////////////////Medidas////////////////////////////////////////////

function frmMeasures() {
    document.getElementById("title").innerHTML = "Nueva Medida";
    document.getElementById("btnAction").innerHTML = "Registrar";
    document.getElementById("frmMeasuress").reset();
    document.getElementById("id").value = "";
    $("#new_measure").modal("show");

}

function register_Measure(e) {
    e.preventDefault();
    const nombre = document.getElementById("nombre");
    const nombre_corto = document.getElementById("nombre_corto");

    if (nombre.value == "" || nombre_corto.value == "") {
        Swal.fire({
            icon: "error",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    } else {
        const url = base_url + "Medidas/registrar";
        const frm = document.getElementById("frmMeasuress");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const contentType = this.getResponseHeader('Content-Type');
                if (contentType && contentType.includes('application/json')) {
                    try {

                        const response = JSON.parse(this.responseText);
                        if (response.msg == "Medida registrada con éxito") {
                            Swal.fire({
                                title: "Registrado Exitosamente",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            frm.reset();
                            $("#new_measure").modal("hide");
                            t_Medidas.ajax.reload();

                        } else if (response.msg == "Medida modificada con éxito") {
                            Swal.fire({
                                title: "Medida modificada con éxito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            $("#new_measure").modal("hide");
                            t_Medidas.ajax.reload(null, true);
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

function btn_edit_Measure(id) {

    document.getElementById("title").innerHTML = "Actualizar Medida";
    document.getElementById("btnAction").innerHTML = "Modificar";
    const url = base_url + "Medidas/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("nombre_corto").value = res.nombre_corto;
            $("#new_measure").modal("show");
        }
    };
}

function btn_delete_Measure(id) {

    Swal.fire({
        title: "Estas seguro de eliminar?",
        text: "La Medida no se eliminara de forma permanente, solo pasara a estado inactivo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Medidas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Medida eliminada con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Medidas.ajax.reload();

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

/*function btn_reingre_Measure(id) {


    Swal.fire({
        title: "Estas seguro de reingresar la Medida?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Medidas/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Medida reingresada con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Medidas.ajax.reload();

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
}*/

/////////////////////////////////////////////////Productos///////////////////////////////////
function frmProducts() {
    document.getElementById("title").innerHTML = "Nuevo Producto";
    document.getElementById("btnAction").innerHTML = "Registrar";
    document.getElementById("frmProduct").reset();
    document.getElementById("id").value = "";
    $("#new_product").modal("show");
    deleteImg();
}

function register_product(e) {
    e.preventDefault();

    const codigo = document.getElementById("codigo");
    const descripcion = document.getElementById("nombre");
    const precio_compra = document.getElementById("precio_compra");
    const precio_venta = document.getElementById("precio_venta");
    const id_medida = document.getElementById("medida");
    const id_categoria = document.getElementById("categoria");

    // Validaciones
    if (codigo.value == "" || descripcion.value == "" || precio_compra.value == "" || precio_venta.value == "") {
        Swal.fire({
            icon: "error",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    } else {
        const url = base_url + "Productos/registrar";
        const frm = document.getElementById("frmProduct");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const contentType = this.getResponseHeader('Content-Type');
                if (contentType && contentType.includes('application/json')) {
                    try {

                        const response = JSON.parse(this.responseText);
                        if (response.msg == "Producto registrado con éxito") {
                            Swal.fire({
                                title: "Producto registrado con exito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            frm.reset();
                            $("#new_product").modal("hide");
                            t_Productos.ajax.reload();

                        } else if (response.msg == "Producto modificado con éxito") {
                            Swal.fire({
                                title: "Producto modificado con éxito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            //frm.reset();
                            $("#new_product").modal("hide");
                            t_Productos.ajax.reload(null, true);


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

function btn_edit_Product(id) {
    document.getElementById("title").innerHTML = "Actualizar Producto";
    document.getElementById("btnAction").innerHTML = "Modificar";
    const url = base_url + "Productos/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            document.getElementById("id").value = res.id;
            document.getElementById("codigo").value = res.codigo;
            document.getElementById("nombre").value = res.descripcion;
            document.getElementById("precio_compra").value = res.precio_compra;
            document.getElementById("precio_venta").value = res.precio_venta;
            document.getElementById("medida").value = res.id_medida;
            document.getElementById("categoria").value = res.id_categoria;
            document.getElementById("img-preview").src = base_url + 'Assets/img/' + res.foto;
            document.getElementById("icon-cerrar").innerHTML =
                `<button class="btn btn-danger" onclick="deleteImg()"> 
                <i class="fas fa-times"></i> </button>`;
            document.getElementById("icon-image").classList.add("d-none");
            document.getElementById("foto_actual").value = res.foto;
            $("#new_product").modal("show");
        }
    };
}

function btn_delete_Product(id) {

    Swal.fire({
        title: "Estas seguro de eliminar?",
        text: "El Producto no se eliminara de forma permanente, solo pasara a estado inactivo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Productos/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Producto eliminado con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Productos.ajax.reload();

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

function btn_reingre_Product(id) {

    Swal.fire({
        title: "Estas seguro de reingresar el Producto?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Productos/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Producto reingresado con exito") {
                        Swal.fire(
                            response.msg,
                            '',
                            "success"
                        )
                        t_Productos.ajax.reload();

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

function preview_foto(e) {

    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML =
        `<button class="btn btn-danger" onclick="deleteImg()"> <i class="fas fa-times"></i> </button>
    ${url['name']}`;
}

function deleteImg() {
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("img-preview").src = '';
    document.getElementById("imagen").value = '';
    document.getElementById("foto_actual").value = '';

}

function search_Codigo(e) {
    e.preventDefault;
    if (e.which == 13) {
        const cod = document.getElementById("codigo").value;
        const url = base_url + "Compras/buscarCodigo/" + cod;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res) {
                    document.getElementById("nombre").value = res.descripcion;
                    document.getElementById("precio").value = res.precio_compra;
                    document.getElementById("id").value = res.id;
                    document.getElementById("cantidad").focus();

                } else {
                    Swal.fire({
                        title: "Producto no existe",
                        icon: "error",
                        draggable: true,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    document.getElementById("codigo").value = "";
                    document.getElementById("codigo").focus();
                }
            }
        }

    }
}

function Calc_Price(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("sub_total").value = precio * cant;
    if (e.which == 13) {
        if (cant > 0) {
            const url = base_url + "Compras/ingresar/";
            const frm = document.getElementById("frmBuy");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "El producto fue ingresado con exito") {
                        Swal.fire({
                            title: "Producto fue registrado con exito",
                            icon: "success",
                            draggable: true,
                            timer: 3000
                        });
                        frm.reset();
                    } else if (response.msg == "Se agrego la cantidad adicional") {
                        Swal.fire({
                            icon: 'success',
                            title: response.msg,
                            timer: 3000
                        });
                        frm.reset();
                    }
                    upload_Detalis();
                }
            }
        }
    }
}

upload_Detalis();

function upload_Detalis() {

    const url = base_url + "Compras/listar/";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            let html = '';
            res.detalle.forEach(row => {
                html += `<tr> 
                <td>${row["id"]}</td>
                <td>${row["descripcion"]}</td>
                <td>${row["cantidad"]}</td>
                <td>${row["precio"]}</td>
                <td>${row["sub_total"]}</td>
                <td>
                    <button class="btn btn-danger type="button" onclick="deleteDetails(${row["id"]})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr> `;
            });
            document.getElementById("tblDetails").innerHTML = html;
            document.getElementById("total").value = res.total_pagar.total;
        }
    }
}

function deleteDetails(id) {

    const url = base_url + "Compras/delete/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
             const response = JSON.parse(this.responseText);
            if (response.msg == "El producto fue eliminado de la lista") {
                Swal.fire({
                    title: "El producto fue eliminado de la lista",
                    icon: "success",
                    draggable: true,
                    timer: 3000
                });
            } else if (response.msg == "Error al eliminar el producto") {
                Swal.fire({
                    icon: 'error',
                    title: response.msg,
                    timer: 3000
                });
            }
            upload_Detalis();
        }
    }

}

function generate_purchase(){

        Swal.fire({
        title: "Estas seguro de realizar la Compra?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "compras/registrarCompra/";
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "Se ha generado la Compra") {
                        Swal.fire(
                            'Compra Generada',
                            '',
                            "success"
                        )
                        const ruta= base_url+'Compras/generarPdf/'+ response.id_compra;
                        window.open(ruta);
                        setTimeout(() => {
                            window.location.reload();
                        }, 300);
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




