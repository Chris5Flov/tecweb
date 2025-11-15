// JSON BASE A MOSTRAR EN FORMULARIO
/*var baseJSON = {
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
            url: './Nature/Read/product-list.php',
            type: 'GET',
            success: function(response) {
                console.log(response);
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
                                    <button class="product-delete btn btn-danger">
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
                url: './Nature/Read/product-search.php?search='+$('#search').val(), 
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
                                    <li>${producto.nombre}</li>
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

    $('#product-form').submit(e => {
        e.preventDefault();

        // SE CONVIERTE EL JSON DE STRING A OBJETO
        let postData = JSON.parse( $('#description').val() );
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();

        /**
         * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
         * --> EN CASO DE NO HABER ERRORES, SE ENVIAR EL PRODUCTO A AGREGAR
         **/

/*        const url = edit === false ? './Nature/Create/product-add.php' : './Nature/Update/product-edit.php';
        
        $.post(url, postData, (response) => {
            console.log(response);
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let respuesta = JSON.parse(response);
            // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
            let template_bar = '';
            template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
            // SE REINICIA EL FORMULARIO
            $('#name').val('');
            $('#description').val(JsonString);
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').show();
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
            // SE REGRESA LA BANDERA DE EDICIÓN A false
            edit = false;
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./Nature/Delete/product-delete.php', {id}, (response) => { 
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./Nature/Read/product-single.php', {id}, (response) => { 
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response);
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#name').val(product.nombre);
            // EL ID SE INSERTA EN UN CAMPO OCULTO PARA USARLO DESPUÉS PARA LA ACTUALIZACIÓN
            $('#productId').val(product.id);
            // SE ELIMINA nombre, eliminado E id PARA PODER MOSTRAR EL JSON EN EL <textarea>
            delete(product.nombre);
            delete(product.eliminado);
            delete(product.id);
            // SE CONVIERTE EL OBJETO JSON EN STRING
            let JsonString = JSON.stringify(product,null,2);
            // SE MUESTRA STRING EN EL <textarea>
            $('#description').val(JsonString);
            
            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
        });
        e.preventDefault();
    });    
});
*/
// JSON BASE A MOSTRAR EN FORMULARIO
const baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

$(document).ready(function() {
    let edit = false;

    // Inicializa textarea con JSON base
    $('#description').val(JSON.stringify(baseJSON, null, 2));
    $('#product-result').hide();

    listarProductos();

    // -------------------------------
    // FUNCION PARA LISTAR PRODUCTOS
    // -------------------------------
    function listarProductos() {
        $.ajax({
            url: 'http://localhost/tecweb/practicas/p12/product_app/Nat/Read/product-list.php',
            type: 'GET',
            success: function(response) {
                console.log('Response product-list:', response);

                let productos;
                try {
                    productos = JSON.parse(response);
                } catch (e) {
                    console.error('Error parseando JSON:', e);
                    return;
                }

                if (productos && productos.length > 0) {
                    let template = '';

                    productos.forEach(producto => {
                        let descripcion = `
                            <li>precio: ${producto.precio}</li>
                            <li>unidades: ${producto.unidades}</li>
                            <li>modelo: ${producto.modelo}</li>
                            <li>marca: ${producto.marca}</li>
                            <li>detalles: ${producto.detalles}</li>
                        `;

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">Eliminar</button>
                                </td>
                            </tr>
                        `;
                    });

                    $('#products').html(template);
                } else {
                    $('#products').html('<tr><td colspan="4">No hay productos</td></tr>');
                }
            }
        });
    }

    // -------------------------------
    // BUSQUEDA
    // -------------------------------
    $('#search').keyup(function() {
        const search = $(this).val();
        if (search) {
            $.ajax({
                url: `./Nat/Read/product-search.php?search=${search}`, 
                type: 'GET',
                success: function(response) {
                    let productos;
                    try {
                        productos = JSON.parse(response);
                    } catch (e) {
                        console.error('Error parseando JSON:', e);
                        return;
                    }

                    if (productos && productos.length > 0) {
                        let template = '';
                        let template_bar = '';

                        productos.forEach(producto => {
                            let descripcion = `
                                <li>precio: ${producto.precio}</li>
                                <li>unidades: ${producto.unidades}</li>
                                <li>modelo: ${producto.modelo}</li>
                                <li>marca: ${producto.marca}</li>
                                <li>detalles: ${producto.detalles}</li>
                            `;

                            template += `
                                <tr productId="${producto.id}">
                                    <td>${producto.id}</td>
                                    <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="product-delete btn btn-danger">Eliminar</button>
                                    </td>
                                </tr>
                            `;

                            template_bar += `<li>${producto.nombre}</li>`;
                        });

                        $('#product-result').show();
                        $('#container').html(template_bar);
                        $('#products').html(template);
                    } else {
                        $('#product-result').hide();
                        $('#products').html('<tr><td colspan="4">No hay productos</td></tr>');
                        $('#container').html('');
                    }
                }
            });
        } else {
            $('#product-result').hide();
            listarProductos();
        }
    });

    // -------------------------------
    // AGREGAR / EDITAR PRODUCTO
    // -------------------------------
    $('#product-form').submit(e => {
        e.preventDefault();

        let postData = JSON.parse($('#description').val());
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();

        const url = edit ? './Nat/Update/product-edit.php' : './Nat/Create/product-add.php';

        $.post(url, postData, (response) => {
            let respuesta;
            try {
                respuesta = JSON.parse(response);
            } catch (e) {
                console.error('Error parseando respuesta JSON:', e);
                return;
            }

            $('#container').html(`
                <li style="list-style:none;">status: ${respuesta.status}</li>
                <li style="list-style:none;">message: ${respuesta.message}</li>
            `);

            $('#name').val('');
            $('#description').val(JSON.stringify(baseJSON, null, 2));
            $('#product-result').show();
            listarProductos();
            edit = false;
        });
    });

    // -------------------------------
    // ELIMINAR PRODUCTO
    // -------------------------------
    $(document).on('click', '.product-delete', (e) => {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(e.target).closest('tr');
            const id = $(element).attr('productId');

            $.post('./Nat/Delete/product-delete.php', { id }, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    // -------------------------------
    // VER PRODUCTO
    // -------------------------------
    $(document).on('click', '.product-item', (e) => {
        const element = $(e.target).closest('tr');
        const id = $(element).attr('productId');

        $.post('./Nat/Read/product-single.php', { id }, (response) => {
            let product;
            try {
                product = JSON.parse(response);
            } catch (e) {
                console.error('Error parseando JSON:', e);
                return;
            }

            $('#name').val(product.nombre);
            $('#productId').val(product.id);

            delete product.nombre;
            delete product.eliminado;
            delete product.id;

            $('#description').val(JSON.stringify(product, null, 2));
            edit = true;
        });

        e.preventDefault();
    });
});
