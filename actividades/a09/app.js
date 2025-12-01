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
//LISTAR PRODUCTOS
    function listarProductos() {
        $.ajax({
            url: `http://localhost/tecweb/actividades/a09/Nat/Read/product-list.php`,
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

//BUSQUEDA
    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: `./Nat/Read/product-search.php` + encodeURIComponent(search),
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
//AGREGAR/EDITAR
    $('#product-form').submit(e => {
        e.preventDefault();
    
        let postData = JSON.parse($('#description').val());
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();

        const url = edit ? './Nat/Update/product-edit.php' : './Nat/Create/product-add.php';
        console.log('edit es:', edit);

        $.ajax({
            url: url,
            type: edit ? 'PUT' : 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            success: function(response){
                console.log(response);
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $('#name').val('');
                $('#description').val('');
                $('#product-result').show();
                $('#container').html(template_bar);
                listarProductos();
                edit = false;
            }
        });
    });
    
    
    
//ELIMINAR
    $(document).on('click', '.product-delete', function () {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const row = $(this).closest('tr');
            const id = row.attr('productId');
    
            $.ajax({
                url: `http://localhost/tecweb/actividades/a09/Nat/Delete/product-delete.php/${id}`,
                type: 'DELETE',
                success: function(response){
                    $('#product-result').hide();
                    listarProductos();
                }
            });
        }
    });
    
//DETALLES DEL PRODUCTO
    $(document).on('click', '.product-item', function(e) {
        e.preventDefault();
    
        const row = $(this).closest('tr');
        const id = row.attr('productId');
    
        $.get(`http://localhost/tecweb/actividades/a09/Nat/Read/product-single.php${id}`, { name: id }, (response) => {
            let product = JSON.parse(response);
    
            $('#name').val(product.nombre);
            $('#productId').val(product.id);
    
            delete product.nombre;
            delete product.eliminado;
            delete product.id;
    
            let JsonString = JSON.stringify(product, null, 2);
            $('#description').val(JsonString);
    
            edit = true;
        });
    });    
});