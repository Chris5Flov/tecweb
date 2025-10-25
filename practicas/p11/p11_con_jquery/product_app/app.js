
const baseJSON = {
  precio: 0.0,
  unidades: 1,
  modelo: "XX-000",
  marca: "NA",
  detalles: "NA",
  imagen: "img/default.png"
};

function initForm() {
  const jsonText = JSON.stringify(baseJSON, null, 2);
  $('#description').val(jsonText);
}

function limpiarFormulario() {
  $('#product-form').trigger('reset');
  $('#productId').val('');
  initForm();
  $('#product-form').css('border-left', '5px solid #2ecc71');
  setTimeout(() => $('#product-form').css('border-left', 'none'), 1000);
}

function cargarProductos() {
  $.get('./backend/p-table.php', function(res) {
    const listaProductos = JSON.parse(res);
    let renderHTML = '';

    listaProductos.forEach(prod => {
      const detalles = `
        <li>precio: ${prod.precio}</li>
        <li>unidades: ${prod.unidades}</li>
        <li>modelo: ${prod.modelo}</li>
        <li>marca: ${prod.marca}</li>
        <li>detalles: ${prod.detalles}</li>
      `;

      renderHTML += `
        <tr data-id="${prod.id}">
          <td>${prod.id}</td>
          <td>${prod.nombre}</td>
          <td><ul>${detalles}</ul></td>
          <td>
            <button class="product-edit btn text-light shadow-sm" 
              style="background-color:#27ae60; border:none;">
              <i class="bi bi-pencil-square"></i> Editar
            </button>
          </td>
          <td>
            <button class="product-delete btn text-light shadow-sm"
              style="background-color:#16a085; border:none;">
              <i class="bi bi-trash"></i> Eliminar
            </button>
          </td>
        </tr>
      `;
    });

    $('#products').html(renderHTML);
  });
}

function mostrarMensaje(texto, tipo) {
  const colores = {
    info: '#1abc9c',   
    warning: '#f1c40f', 
    error: '#e74c3c'    
  };

  $('#product-result')
    .removeClass('d-none')
    .addClass('d-block')
    .html(`<li style="list-style:none; color:${colores[tipo]}; font-weight:bold;">${texto}</li>`);
}

$(document).ready(() => {

  initForm();
  cargarProductos();


  $('#search').on('keyup', function() {
    const term = $(this).val().trim();
    if (term.length === 0) {
      $('#product-result').addClass('d-none');
      cargarProductos();
      return;
    }

    $.get('./backend/p-search.php', { search: term }, function(data) {
      const productos = JSON.parse(data);
      let tabla = '';
      let listaEstado = '';

      if (productos.length > 0) {
        productos.forEach(prod => {
          listaEstado += `<li>${prod.nombre}</li>`;
          const desc = `
            <li>precio: ${prod.precio}</li>
            <li>unidades: ${prod.unidades}</li>
            <li>modelo: ${prod.modelo}</li>
            <li>marca: ${prod.marca}</li>
            <li>detalles: ${prod.detalles}</li>
          `;
          tabla += `
            <tr data-id="${prod.id}">
              <td>${prod.id}</td>
              <td>${prod.nombre}</td>
              <td><ul>${desc}</ul></td>
              <td>
                <button class="product-edit btn text-light" 
                  style="background-color:#27ae60; border:none;">
                  <i class="bi bi-pencil-square"></i> Editar
                </button>
              </td>
              <td>
                <button class="product-delete btn text-light" 
                  style="background-color:#16a085; border:none;">
                  <i class="bi bi-trash"></i> Eliminar
                </button>
              </td>
            </tr>
          `;
        });

        $('#product-result').removeClass('d-none').addClass('d-block');
        $('#container').html(listaEstado);
      } else {
        tabla = `<tr><td colspan="5">No se encontraron coincidencias.</td></tr>`;
        $('#product-result').removeClass('d-block').addClass('d-none');
      }

      $('#products').html(tabla);
    });
  });

  $('#product-form').on('submit', function(e) {
    e.preventDefault();

    const nombre = $('#name').val().trim();
    if (nombre === '') {
      mostrarMensaje('El nombre no puede estar vacío.', 'warning');
      return;
    }

    let prodJSON = JSON.parse($('#description').val());
    prodJSON.nombre = nombre;

    const id = $('#productId').val();
    const url = id ? './backend/p-update.php' : './backend/p-add.php';
    if (id) prodJSON.id = id;

    $.ajax({
      url,
      method: 'POST',
      contentType: 'application/json;charset=UTF-8',
      data: JSON.stringify(prodJSON, null, 2),
      success: function(resp) {
        const res = JSON.parse(resp);
        mostrarMensaje(` ${res.message}`, res.status === 'success' ? 'info' : 'error');
        cargarProductos();
        limpiarFormulario();
      }
    });
  });


  $(document).on('click', '.product-delete', function() {
    if (!confirm("¿Deseas eliminar este producto?")) return;

    const fila = $(this).closest('tr');
    const id = fila.data('id');

    $.get('./backend/p-delete.php', { id }, function(res) {
      const info = JSON.parse(res);
      mostrarMensaje(info.message, info.status === 'success' ? 'info' : 'error');
      cargarProductos();
    });
  });

  $(document).on('click', '.product-edit', function() {
    const id = $(this).closest('tr').data('id');

    $.get('./backend/p-single.php', { id }, function(res) {
      const p = JSON.parse(res);

      $('#name').val(p.nombre);
      $('#productId').val(p.id);

      const datos = {
        precio: p.precio,
        unidades: p.unidades,
        modelo: p.modelo,
        marca: p.marca,
        detalles: p.detalles,
        imagen: p.imagen
      };

      $('#description').val(JSON.stringify(datos, null, 2));

      $('html, body').animate({ scrollTop: $('#product-form').offset().top - 100 }, 400);
      $('#product-form').css('box-shadow', '0 0 10px #2ecc71');
      setTimeout(() => $('#product-form').css('box-shadow', 'none'), 1200);
    });
  });

});
