// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

$(document).ready(function(){
    let edit = false;

    let JsonString = JSON.stringify(baseJSON,null,2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
            
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    // Validación en tiempo real al perder el foco de cada campo
    function estadoBarra(mensaje, validacion, atributo) {
        let estado = validacion ? 'text-success' : 'text-danger';
        let mensajeEstado = `<li class="${estado}">${mensaje}</li>`;
        $(`#status-${atributo}`).html(mensajeEstado); 
    }

    // Validación en tiempo real al perder el foco de cada campo
    $('#name').blur(function() {
        let name = $(this).val();
        if (name.trim() === '' || name.length > 100) {
            estadoBarra('El nombre es requerido y debe tener 100 caracteres o menos.', false, 'name');
        } else {
            estadoBarra('Nombre válido.', true, 'name');
        }
    });

    $('#marca').blur(function() {
        let marca = $(this).val();
        if (marca.trim() === '') {
            estadoBarra('La marca es requerida y debe seleccionarse de la lista de opciones.', false, 'marca');
        } else {
            estadoBarra('Marca válida.', true, 'marca');
        }
    });

    $('#modelo').blur(function() {
        let modelo = $(this).val();
        const regexModelo = /^[a-zA-Z0-9\-]+$/;
        if (modelo.trim() === '') {
            estadoBarra('El modelo es requerido.', false, 'modelo');
        } else {
            estadoBarra('Modelo válido.', true, 'modelo');
        }
    });

    $('#precio').blur(function() {
        let precio = $(this).val();
        if (precio === '' || parseFloat(precio) <= 99.99) {
            estadoBarra('El precio es requerido y debe ser mayor a 99.99.', false, 'precio');
        } else {
            estadoBarra('Precio válido.', true, 'precio');
        }
    });

    $('#detalles').blur(function() {
        let detalles = $(this).val();
        if (detalles.length > 250) {
            estadoBarra('Los detalles deben tener 250 caracteres o menos.', false, 'detalles');
        } else {
            estadoBarra('Detalles válidos.', true, 'detalles');
        }
    });

    $('#unidades').blur(function() {
        let unidades = $(this).val();
        if (unidades === '' || parseInt(unidades) < 0) {
            estadoBarra('Las unidades son requeridas y deben ser 0 o mayores.', false, 'unidades');
        } else {
            estadoBarra('Unidades válidas.', true, 'unidades');
        }
    });

    $('#imagen').blur(function() {
        let imagen = $(this).val();
        if (imagen === '') {
            $(this).val('img/default.png'); 
            estadoBarra('Imagen no proporcionada, se usa una predeterminada.', true, 'imagen');
        } else {
            estadoBarra('Imagen válida.', true, 'imagen');
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();

        // Obtener valores de los campos
        let name = $('#name').val().trim();
        let marca = $('#marca').val().trim();
        let modelo = $('#modelo').val().trim();
        let precio = $('#precio').val();
        let detalles = $('#detalles').val();
        let unidades = $('#unidades').val();
        let imagen = $('#imagen').val().trim();

        let allValid = true;

        // Barra de estado general
        let generalStatus = '';
        
        // Validación de todos los campos
        if (name === '' || name.length > 100) {
            estadoBarra('El nombre es requerido y debe tener 100 caracteres o menos.', false, 'name');
            allValid = false;
        } else {
            estadoBarra('Nombre válido.', true, 'name');
        }

        if (marca === '' ) {
            estadoBarra('La marca es requerida ', false, 'marca');
            allValid = false;
        } else {
            estadoBarra('Marca válida.', true, 'marca');
        }

        const regexModelo = /^[a-zA-Z0-9\-]+$/;
        if (modelo === '' || modelo.length > 25 || !regexModelo.test(modelo)) {
            estadoBarra('El modelo es requerido, debe ser alfanumérico y tener 25 caracteres o menos.', false, 'modelo');
            allValid = false;
        } else {
            estadoBarra('Modelo válido.', true, 'modelo');
        }

        if (precio === '' || parseFloat(precio) <= 99.99) {
            estadoBarra('El precio es requerido y debe ser mayor a 99.99.', false, 'precio');
            allValid = false;
        } else {
            estadoBarra('Precio válido.', true, 'precio');
        }

        if (detalles.length > 250) {
            estadoBarra('Los detalles deben tener 250 caracteres o menos.', false, 'detalles');
            allValid = false;
        } else {
            estadoBarra('Detalles válidos.', true, 'detalles');
        }

        if (unidades === '' || parseInt(unidades) < 0) {
            estadoBarra('Las unidades son requeridas y deben ser 0 o mayores.', false, 'unidades');
            allValid = false;
        } else {
            estadoBarra('Unidades válidas.', true, 'unidades');
        }

        if (imagen === '') {
            $('#imagen').val('img/default.png');
            estadoBarra('Imagen no proporcionada, se usa una predeterminada.', true, 'imagen');
        } else {
            estadoBarra('Imagen válida.', true, 'imagen');
        }

        if(allValid){
            let postData = {
                nombre: name,
                precio: precio,
                unidades: unidades,
                modelo: modelo,
                marca: marca,
                detalles: detalles,
                imagen: imagen,
                id: $('#productId').val()
            };

            const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

            $.post(url, postData, (response) => {
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $('#name').val('');
                $('#precio').val('');
                $('#unidades').val('');
                $('#modelo').val('');
                $('#marca').val('');
                $('#detalles').val('');
                $('#imagen').val('');
                $('#product-result').show();
                $('#container').html(template_bar);
                listarProductos();
                edit = false;
                $('button.btn-primary').text("Agregar Producto");
            });
        }
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response);
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#name').val(product.nombre);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#modelo').val(product.modelo);
            $('#marca').val(product.marca);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);
            
            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
            // CAMBIAR TEXTO A "MODIFICAR PRODUCTO"
            $('button.btn-primary').text("Modificar Producto");
        });
        e.preventDefault();
    });    

     // Evento 'keyup' para la validación asincrónica del nombre
     $('#name').keyup(function() {
        let name = $(this).val().trim();

        // Verificar que el nombre no esté vacío antes de hacer la consulta al servidor
        if (name !== '') {
            $.ajax({
                url: './backend/product-name.php', 
                type: 'GET',
                data: { name: name }, 
                success: function(response) {
                    
                    const data = JSON.parse(response);
                    console.log(data);
                    if (data.status === 'error') {
                        estadoBarra(data.message, false, 'name'); 
                    } else if (data.status === 'success') {
                        estadoBarra(data.message, true, 'name');   
                    }
                },
                error: function() {
                    estadoBarra('Error al validar el nombre.', false, 'name');
                }
            });
        }
    });
});

