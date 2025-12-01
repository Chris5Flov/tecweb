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

    // Listar productos
    function listarProductos() {
        $.ajax({
            url: 'http://localhost/tecweb/actividades/a09/Nat/Read/product-list.php',
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

    // búsqueda
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

    // agregar
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

    // eliminar
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

    // ver
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
