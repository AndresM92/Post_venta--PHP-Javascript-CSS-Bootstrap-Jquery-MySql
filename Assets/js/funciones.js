//////////////////////////////////////Usuarios///////////////////////////////////////////

let t_Usuarios, t_Clientes, t_Categorias, t_Cajas, t_Medidas, t_Productos, t_historial_c, t_historial_s, myModal;

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

                    window.location.href = base_url + "Administracion/home";
                } else {
                    document.getElementById("alerta").classList.remove("d-none");
                    document.getElementById("alerta").innerHTML = res;
                }
            }
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {

    if (document.getElementById('my_modal')) {
        myModal = new bootstrap.Modal(document.getElementById('my_modal'))
    }

    $('#cliente_Search').select2();

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
            responsive: true,
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
        t_historial_c = $('#t_historial_buy').DataTable({
            ajax: {
                url: base_url + "Compras/list_historial",
                dataSrc: "",
            },
            columns: [
                { data: 'id' },
                { data: 'total' },
                { data: 'fecha' },
                { data: 'estado' },
                { data: 'acciones' }
            ]

        });
    });

    $(document).ready(function () {
        t_historial_s = $('#t_historial_sale').DataTable({
            ajax: {
                url: base_url + "Compras/list_historial_venta",
                dataSrc: "",
            },
            columns: [
                { data: 'id' },
                { data: 'nombre' },
                { data: 'total' },
                { data: 'fecha' },
                { data: 'acciones' }
            ]

        });
    });

    $(document).ready(function () {
        t_Productos = $('#ta_Productos').DataTable({
            responsive: true,
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
            ],
            dom: '<"row"<"col-sm-2"l><"col-sm-8 text-center"B><"col-sm-2"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-5"i><"col-sm-7"p>>',

            layout: {
                topStart: {
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            text: '<i class="fas fa-copy"></i>',
                            className: 'btn btn-primary'
                        },
                        {
                            extend: 'excelHtml5',
                            footer: true,
                            title: 'Archivo',
                            filename: 'Export_File',
                            text: '<span class="badge bg-success"><i class="fas fa-file-excel"></i></span>'
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i>',
                            className: 'btn btn-danger'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> Imprimir'
                        }
                    ]
                }
            }
        });
    });

})

function frmChange_Pass(e) {
    e.preventDefault();
    const actual = document.getElementById("clave_actual").value;
    const nueva_clave = document.getElementById("clave_nueva").value;
    const confirmar_clave = document.getElementById("confirmar_clave").value;
    if (actual == "" || nueva_clave == "" || confirmar_clave == "") {
        Swal.fire({
            icon: "warning",
            title: "Todos los campos son obligatorios",
            timer: 3000
        });
    }
    else if (nueva_clave.value != confirmar_clave.value) {
        Swal.fire({
            icon: "warning",
            title: "Las contraseñas no coinciden",
            timer: 3000
        });
    } else {

        const url = base_url + "Usuarios/cambiarPass";
        const frm = document.getElementById("frmChangePass");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const response = JSON.parse(this.responseText);
                if (response.msg == "Contraseña modificada con exito") {
                    Swal.fire({
                        title: response.msg,
                        icon: "success",
                        draggable: true,
                        timer: 3000
                    });
                    $("#changePass").modal("hide");
                    frm.reset();
                } else {
                    Swal.fire({
                        title: response.msg,
                        icon: response.icono,
                        draggable: true,
                        timer: 3000
                    });
                }
            }
        };
    }
}

function frmUsers() {
    document.getElementById("title").textContent = "Nuevo Usuario";
    document.getElementById("btnAction").textContent = "Registrar";
    document.getElementById("passwords").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    myModal.show();
    document.getElementById("id").value = "";
    //$("#new_user").modal("show");
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
    document.getElementById("title").textContent = "Nueva Medida";
    document.getElementById("btnAction").textContent = "Registrar";
    document.getElementById("frmMeasuress").reset();
    document.getElementById("id").value = "";
    myModal.show();
    //$("#new_measure").modal("show");

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
                            myModal.hide();
                            t_Medidas.ajax.reload();

                        } else if (response.msg == "Medida modificada con éxito") {
                            Swal.fire({
                                title: "Medida modificada con éxito",
                                icon: "success",
                                draggable: true,
                                timer: 3000
                            });
                            myModal.hide();
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

    document.getElementById("title").textContent = "Actualizar Medida";
    document.getElementById("btnAction").textContent = "Modificar";
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
            myModal.show();
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
    const cod = document.getElementById("codigo").value;
    if (cod != "") {
        if (e.which == 13) {
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
                        document.getElementById("cantidad").removeAttribute("disabled");
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
    } else {
        Swal.fire({
            title: "Ingrese el codigo",
            icon: "warning",
            draggable: true,
            showConfirmButton: false,
            timer: 2000
        });

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
                            title: "Producto fue agregado",
                            icon: "success",
                            draggable: true,
                            timer: 2000
                        });
                        frm.reset();
                    } else if (response.msg == "Se agrego la cantidad adicional") {
                        Swal.fire({
                            icon: 'success',
                            title: "Producto actualizado",
                            draggable: true,
                            timer: 2000
                        });
                        frm.reset();
                    }
                    document.getElementById("cantidad").setAttribute("disabled", "disable");
                    document.getElementById("codigo").focus();

                    upload_Detalis();
                }
            }
        }
    }
}

function Calc_Price_Sale(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("sub_total").value = precio * cant;
    if (e.which == 13) {
        if (cant > 0) {
            const url = base_url + "Compras/ingresarVenta/";
            const frm = document.getElementById("frmSale");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.msg == "El producto fue ingresado con exito") {
                        Swal.fire({
                            title: "Producto fue agregado",
                            icon: "success",
                            draggable: true,
                            timer: 2000
                        });
                        frm.reset();
                    } else if (response.msg == "Se agrego la cantidad adicional") {
                        Swal.fire({
                            icon: 'success',
                            title: "Producto actualizado",
                            draggable: true,
                            timer: 2000
                        });
                        frm.reset();
                    }
                    document.getElementById("cantidad").setAttribute("disabled", "disable");
                    document.getElementById("codigo").focus();

                    upload_Detalis_Sale();
                }
            }
        }
    }
}

if (document.getElementById("tblDetails")) {
    upload_Detalis();
}

if (document.getElementById("tblDetails_Sale")) {
    upload_Detalis_Sale();
}


function upload_Detalis() {

    const url = base_url + "Compras/listar/detalle";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
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
                    <button class="btn btn-danger type="button" onclick="deleteDetails(${row["id"]},1)">
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

function upload_Detalis_Sale() {

    const url = base_url + "Compras/listar/detalle_venta_temp";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            res.detalle.forEach(row => {
                html += `<tr> 
                <td>${row["id"]}</td>
                <td>${row["descripcion"]}</td>
                <td>${row["cantidad"]}</td>
                <td><input class="form-control" placeholder="Desc" type="text" onkeyup="calDescuento(event,${row["id"]})"></td>
                <td>${row["descuento"]}</td>
                <td>${row["precio"]}</td>
                <td>${row["sub_total"]}</td>
                <td>
                    <button class="btn btn-danger type="button" onclick="deleteDetails(${row["id"]},2)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr> `;
            });
            document.getElementById("tblDetails_Sale").innerHTML = html;
            document.getElementById("total").value = res.total_pagar.total;
        }
    }
}

function calDescuento(e, id) {
    e.preventDefault();
    if (e.target.value == "") {

        Swal.fire({
            title: "Ingrese el Descuento",
            icon: "warning",
            draggable: true,
            showConfirmButton: false,
            timer: 2000
        });
    } else {
        if (e.which == 13) {
            const url = base_url + "Compras/calDescuento/" + id + "/" + e.target.value;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    upload_Detalis_Sale();
                    //const response = JSON.parse(this.responseText);

                }
            }

        }
    }
}

function deleteDetails(id, accion) {

    let url;
    if (accion == 1) {
        url = base_url + "Compras/delete/" + id;

    } else {
        url = base_url + "Compras/deleteVenta/" + id;
    }
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
            if (accion == 1) {
                upload_Detalis();

            } else {
                upload_Detalis_Sale();
            }

        }
    }

}

function generate_Purchase_Sale(accion) {


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

            let url;
            if (accion == 1) {
                url = base_url + "compras/registrarCompra/";
            } else {
                const id_cliente = document.getElementById("cliente_Search").value;
                url = base_url + "compras/registrarVenta/" + id_cliente;
            }
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    let ruta;
                    if (response.msg == "Se ha generado la Compra") {
                        Swal.fire(
                            'Compra Generada',
                            '',
                            "success"
                        )
                        ruta = base_url + 'Compras/generarPdf/' + response.id_compra;
                        window.open(ruta);
                        setTimeout(() => { window.location.reload(); }, 300);
                    } else {
                        Swal.fire(
                            response.msg,
                            response,
                            "success"
                        )
                        ruta = base_url + 'Compras/generarPdfVenta/' + response.id_venta;
                        window.open(ruta);
                        setTimeout(() => { window.location.reload(); }, 300);
                    }
                }
            }
        }
    })

}

function modiEmpresa(params) {

    const frm = document.getElementById('frmEmpresa');
    const url = base_url + "Administracion/modificar";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            if (response.msg == "Datos de la empresa modificados con exito") {
                Swal.fire(
                    response.msg,
                    '',
                    "success"
                )
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

function search_Codigo_Sale(e) {

    e.preventDefault;
    const cod = document.getElementById("codigo").value;
    if (cod != "") {
        if (e.which == 13) {
            const url = base_url + "Compras/buscarCodigo/" + cod;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res) {
                        document.getElementById("nombre").value = res.descripcion;
                        document.getElementById("precio").value = res.precio_venta;
                        document.getElementById("id").value = res.id;
                        document.getElementById("cantidad").removeAttribute("disabled");
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
    } else {
        Swal.fire({
            title: "Ingrese el codigo",
            icon: "warning",
            draggable: true,
            showConfirmButton: false,
            timer: 2000
        });

    }

}

if (document.getElementById("stockMin")) {
    ReportStock();
    ReportMSales();
}

function ReportStock() {

    const url = base_url + "Administracion/reportStock";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            let nombre = [];
            let cantidad = [];

            for (let i = 0; i < response.length; i++) {
                nombre.push(response[i]["descripcion"]);
                cantidad.push(response[i]["cantidad"]);
            }
            var ctx = document.getElementById("stockMin");
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: nombre,
                    datasets: [{
                        data: cantidad,
                        backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
                    }],
                },
            });

        }
    }


}

function ReportMSales() {

    const url = base_url + "Administracion/reportProVentas";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            let nombre = [];
            let cantidad = [];

            for (let i = 0; i < response.length; i++) {
                nombre.push(response[i]["descripcion"]);
                cantidad.push(response[i]["total"]);
            }
            var ctx = document.getElementById("stockVen");
            var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: nombre,
                    datasets: [{
                        data: cantidad,
                        backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
                    }],
                },
            });

        }
    }


}

function btnAnularC(id) {

    Swal.fire({
        title: "Estas seguro de anular la compra?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Compras/anularCompra/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    Swal.fire(
                        response.msg,
                        '',
                        response.icono
                    )
                }
                t_historial_c.ajax.reload();
            }
        }
    })
}






