$(document).ready(function () {
    let edit = false; // Indica si estamos editando
    const API_URL = './backend/products_api.php';

    $('#product-result').hide();

    // --- Funciones de validación ---
    function setError($input, msg) {
        $input.addClass('is-invalid');
        $input.siblings('.invalid-feedback').text(msg).show();
    }
    function clearError($input) {
        $input.removeClass('is-invalid');
        $input.siblings('.invalid-feedback').text('').hide();
    }

    function validarFormulario() {
        let errores = [];

        const nombre = $('#name').val().trim();
        if (!nombre || nombre.length > 100) errores.push('Nombre obligatorio y máximo 100 caracteres.');

        const marca = $('#marca').val();
        if (!marca) errores.push('Selecciona una marca.');

        const modelo = $('#modelo').val().trim();
        if (!modelo || !/^[a-zA-Z0-9\s-]+$/.test(modelo) || modelo.length > 25) errores.push('Modelo requerido, alfanumérico y máximo 25.');

        const precio = parseFloat($('#precio').val());
        if (isNaN(precio) || precio <= 99.99) errores.push('Precio debe ser mayor a $99.99.');

        const unidades = parseInt($('#unidades').val());
        if (isNaN(unidades) || unidades < 0) errores.push('Unidades deben ser 0 o más.');

        const detalles = $('#detalles').val();
        if ((detalles || '').length > 250) errores.push('Detalles máximo 250 caracteres.');

        if (errores.length > 0) mostrarErrores(errores);

        return errores.length === 0;
    }

    function mostrarErrores(errores) {
        let template = '<li style="list-style:none;font-weight:bold;">Errores:</li>';
        errores.forEach(e => template += `<li style="list-style:none;">${e}</li>`);
        $('#container').html(template).show();
    }

    // --- Listar productos ---
    function listarProductos() {
        $.get(API_URL + '?action=list', function(response) {
            let productos = [];
            try { productos = JSON.parse(response); } catch(e){}

            if (productos.length === 0) {
                $('#products').html('<tr><td colspan="4" class="text-center">No hay productos.</td></tr>');
                return;
            }

            let template = '';
            productos.forEach(p => {
                template += `
                    <tr data-id="${p.id}">
                        <td>${p.id}</td>
                        <td><a href="#" class="product-item">${p.nombre}</a></td>
                        <td>
                            <ul>
                                <li>Precio: ${p.precio}</li>
                                <li>Unidades: ${p.unidades}</li>
                                <li>Modelo: ${p.modelo}</li>
                                <li>Marca: ${p.marca}</li>
                                <li>Detalles: ${p.detalles}</li>
                            </ul>
                        </td>
                        <td>
                            <button class="product-delete btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $('#products').html(template);
        });
    }

    listarProductos();

    // --- Agregar o editar producto ---
    $('#product-form').submit(function(e){
        e.preventDefault();
        $('#product-result').hide();

        if (!validarFormulario()) return;

        const postData = {
            nombre: $('#name').val().trim(),
            marca: $('#marca').val(),
            modelo: $('#modelo').val().trim(),
            precio: $('#precio').val(),
            unidades: $('#unidades').val(),
            detalles: $('#detalles').val(),
            imagen: $('#imagen').val(),
            id: $('#productId').val()
        };

        const action = edit ? 'edit' : 'add';

        $.post(API_URL + '?action=' + action, postData, function(response){
            let r = {};
            try { r = JSON.parse(response); } catch(e){ r = {status:'error', message:'Error en respuesta del servidor'}; }

            $('#product-result').html(`<li style="list-style:none;font-weight:bold;">${r.message}</li>`).show();
            $('#product-form').trigger('reset');
            $('#productId').val('');
            $('.form-control').removeClass('is-invalid');
            edit = false;
            $('button.btn-primary').text('Agregar Producto');
            listarProductos();
        });
    });

    // --- Cargar producto para editar ---
    $(document).on('click', '.product-item', function(e){
        e.preventDefault();
        const id = $(this).closest('tr').data('id');

        $.post(API_URL + '?action=single', {id}, function(response){
            let p = {};
            try { p = JSON.parse(response); } catch(e){}

            $('#name').val(p.nombre);
            $('#marca').val(p.marca);
            $('#modelo').val(p.modelo);
            $('#precio').val(p.precio);
            $('#unidades').val(p.unidades);
            $('#detalles').val(p.detalles);
            $('#imagen').val(p.imagen);
            $('#productId').val(p.id);

            edit = true;
            $('button.btn-primary').text('Modificar Producto');
        });
    });

    // --- Eliminar producto ---
    $(document).on('click', '.product-delete', function(){
        const id = $(this).closest('tr').data('id');
        if (!confirm('¿Deseas eliminar este producto?')) return;

        $.post(API_URL + '?action=delete', {id}, function(response){
            listarProductos();
        });
    });

    // --- Buscar productos ---
    $('#search').on('keyup', function(e){
        e.preventDefault();
        const search = $(this).val().trim();
        if (!search) return listarProductos();

        $.get(API_URL + '?action=search&search=' + encodeURIComponent(search), function(response){
            let productos = [];
            try { productos = JSON.parse(response); } catch(e){}
            if (productos.length === 0) {
                $('#products').html('<tr><td colspan="4" class="text-center">No se encontraron coincidencias.</td></tr>');
                return;
            }

            let template = '';
            productos.forEach(p => {
                template += `
                    <tr data-id="${p.id}">
                        <td>${p.id}</td>
                        <td><a href="#" class="product-item">${p.nombre}</a></td>
                        <td>
                            <ul>
                                <li>Precio: ${p.precio}</li>
                                <li>Unidades: ${p.unidades}</li>
                                <li>Modelo: ${p.modelo}</li>
                                <li>Marca: ${p.marca}</li>
                                <li>Detalles: ${p.detalles}</li>
                            </ul>
                        </td>
                        <td>
                            <button class="product-delete btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $('#products').html(template);
        });
    });
});
