/*$(document).ready(function () {
  let edit = false;

  // 🔹 Función principal para listar productos
  function listarProductos() {
    $.ajax({
      url: "./backend/product-list.php",
      type: "GET",
      success: function (response) {
        const productos = JSON.parse(response);
        let template = "";

        productos.forEach((producto) => {
          let descripcion = `
            <li>Precio: ${producto.precio}</li>
            <li>Unidades: ${producto.unidades}</li>
            <li>Modelo: ${producto.modelo}</li>
            <li>Marca: ${producto.marca}</li>
            <li>Detalles: ${producto.detalles}</li>
          `;

          template += `
            <tr productId="${producto.id}">
              <td>${producto.id}</td>
              <td><a href="#" class="product-item">${producto.nombre}</a></td>
              <td><ul>${descripcion}</ul></td>
              <td>
                <button class="product-delete btn btn-danger btn-sm">Eliminar</button>
              </td>
            </tr>
          `;
        });
        $("#products").html(template);
      },
    });
  }

  listarProductos();

  // 🔹 Buscar productos
  $("#search").keyup(function () {
    const search = $("#search").val();
    if (search.trim() === "") {
      listarProductos();
      return;
    }

    $.ajax({
      url: "./backend/product-search.php?search=" + search,
      type: "GET",
      success: function (response) {
        const productos = JSON.parse(response);
        let template = "";

        productos.forEach((producto) => {
          template += `
            <tr productId="${producto.id}">
              <td>${producto.id}</td>
              <td><a href="#" class="product-item">${producto.nombre}</a></td>
              <td>${producto.marca}</td>
              <td>
                <button class="product-delete btn btn-danger btn-sm">Eliminar</button>
              </td>
            </tr>
          `;
        });

        $("#products").html(template);
      },
    });
  });

  // 🔹 Validar cada campo cuando pierde el foco (blur)
  $("#product-form input, #product-form textarea").on("blur", function () {
    let valor = $(this).val().trim();
    let idCampo = $(this).attr("id");

    if (valor === "") {
      $(this).addClass("is-invalid").removeClass("is-valid");
      mostrarEstado(`El campo ${idCampo} no puede estar vacío`, "error");
    } else {
      $(this).removeClass("is-invalid").addClass("is-valid");
      mostrarEstado(`Campo ${idCampo} válido `, "ok");
    }
  });

  // 🔹 Validar nombre del producto mientras se escribe (AJAX)
  $("#nombre").on("keyup", function () {
    const nombre = $(this).val().trim();
    if (nombre.length === 0) {
      $("#product-result").hide();
      return;
    }

    $.ajax({
      url: "./backend/product-checkname.php",
      type: "GET",
      data: { nombre },
      success: function (response) {
        $("#product-result").show();
        if (response === "existe") {
          $("#container").html("<li>El nombre ya existe en la base de datos.</li>");
          $("#nombre").addClass("is-invalid");
        } else {
          $("#container").html("<li>Nombre disponible.</li>");
          $("#nombre").removeClass("is-invalid").addClass("is-valid");
        }
      },
    });
  });

  // 🔹 Al hacer clic en un producto → llenar formulario y cambiar botón
  $(document).on("click", ".product-item", function (e) {
    e.preventDefault();
    const element = $(this)[0].parentElement.parentElement;
    const id = $(element).attr("productId");

    $.post("./backend/product-single.php", { id }, function (response) {
      const product = JSON.parse(response);

      $("#nombre").val(product.nombre);
      $("#precio").val(product.precio);
      $("#unidades").val(product.unidades);
      $("#modelo").val(product.modelo);
      $("#marca").val(product.marca);
      $("#detalles").val(product.detalles);
      $("#imagen").val(product.imagen);
      $("#productId").val(product.id);

      $("button.btn-primary").text("Modificar Producto");
      edit = true;
    });
  });

  // 🔹 Enviar formulario (Agregar o Modificar producto)
  $("#product-form").submit(function (e) {
    e.preventDefault();

    // Validación antes de enviar
    const campos = ["#nombre", "#precio", "#unidades", "#modelo", "#marca", "#detalles"];
    for (let campo of campos) {
      if ($(campo).val().trim() === "") {
        alert("Por favor llena todos los campos requeridos");
        return;
      }
    }

    const postData = {
      nombre: $("#nombre").val(),
      precio: $("#precio").val(),
      unidades: $("#unidades").val(),
      modelo: $("#modelo").val(),
      marca: $("#marca").val(),
      detalles: $("#detalles").val(),
      imagen: $("#imagen").val(),
      id: $("#productId").val(),
    };

    const url = edit ? "./backend/product-edit.php" : "./backend/product-add.php";

    $.post(url, postData, function (response) {
      const respuesta = JSON.parse(response);
      mostrarEstado(` ${respuesta.message}`, "ok");

      $("#product-form").trigger("reset");
      $("#product-form input, #product-form textarea").removeClass("is-valid is-invalid");
      $("button.btn-primary").text("Agregar Producto");
      edit = false;

      listarProductos();
    });
  });

  // 🔹 Eliminar producto
  $(document).on("click", ".product-delete", function () {
    if (!confirm("¿Seguro que quieres eliminar este producto?")) return;
    const element = $(this)[0].parentElement.parentElement;
    const id = $(element).attr("productId");

    $.post("./backend/product-delete.php", { id }, function () {
      mostrarEstado("Ejecución de eliminado correcto", "ok");
      listarProductos();
    });
  });

  // 🔹 Mostrar mensajes en la barra de estado
  function mostrarEstado(mensaje, tipo) {
    $("#product-result").show();
    const color = tipo === "ok" ? "lightgreen" : "salmon";
    $("#container").html(`<li style="color:${color}; list-style:none;">${mensaje}</li>`);
  }
});
*/
$(document).ready(function () {
  let edit = false;

  // 🔹 Función principal para listar productos
  function listarProductos() {
    $.ajax({
      url: "./backend/product-list.php",
      type: "GET",
      success: function (response) {
        const productos = JSON.parse(response);
        let template = "";

        productos.forEach((producto) => {
          let descripcion = `
            <li>Precio: ${producto.precio}</li>
            <li>Unidades: ${producto.unidades}</li>
            <li>Modelo: ${producto.modelo}</li>
            <li>Marca: ${producto.marca}</li>
            <li>Detalles: ${producto.detalles}</li>
          `;

          template += `
            <tr productId="${producto.id}">
              <td>${producto.id}</td>
              <td>${producto.nombre}</td>
              <td>${producto.marca}</td>
              <td>${producto.modelo}</td>
              <td>${producto.precio}</td>
              <td>${producto.unidades}</td>
              <td>
                <button class="product-edit btn btn-success btn-sm">Editar</button>
              </td>
              <td>
                <button class="product-delete btn btn-danger btn-sm">Eliminar</button>
              </td>
            </tr>
          `;
        });
        $("#products").html(template);
      },
    });
  }

  listarProductos();

  // 🔹 Buscar productos
  $("#search").keyup(function () {
    const search = $("#search").val();
    if (search.trim() === "") {
      listarProductos();
      return;
    }

    $.ajax({
      url: "./backend/product-search.php?search=" + search,
      type: "GET",
      success: function (response) {
        const productos = JSON.parse(response);
        let template = "";

        productos.forEach((producto) => {
          template += `
            <tr productId="${producto.id}">
              <td>${producto.id}</td>
              <td>${producto.nombre}</td>
              <td>${producto.marca}</td>
              <td>${producto.modelo}</td>
              <td>${producto.precio}</td>
              <td>${producto.unidades}</td>
              <td>
                <button class="product-edit btn btn-success btn-sm">Editar</button>
              </td>
              <td>
                <button class="product-delete btn btn-danger btn-sm">Eliminar</button>
              </td>
            </tr>
          `;
        });

        $("#products").html(template);
      },
    });
  });

  // 🔹 Al hacer clic en "Editar" en la tabla
  $(document).on("click", ".product-edit", function () {
    const element = $(this).closest("tr");
    const id = $(element).attr("productId");

    $.post("./backend/product-single.php", { id }, function (response) {
      const product = JSON.parse(response);

      $("#nombre").val(product.nombre);
      $("#precio").val(product.precio);
      $("#unidades").val(product.unidades);
      $("#modelo").val(product.modelo);
      $("#marca").val(product.marca);
      $("#detalles").val(product.detalles);
      $("#imagen").val(product.imagen);
      $("#productId").val(product.id);

      $("button.btn-primary").text("Modificar Producto");
      edit = true;
    });
  });

  // 🔹 Validación básica al perder foco
  $("#product-form input, #product-form textarea").on("blur", function () {
    let valor = $(this).val().trim();
    if (valor === "") {
      $(this).addClass("is-invalid").removeClass("is-valid");
    } else {
      $(this).removeClass("is-invalid").addClass("is-valid");
    }
  });

  // 🔹 Enviar formulario (Agregar o Modificar producto)
  $("#product-form").submit(function (e) {
    e.preventDefault();

    const campos = ["#nombre", "#precio", "#unidades", "#modelo", "#marca", "#detalles", "#imagen"];
    for (let campo of campos) {
      if ($(campo).val().trim() === "") {
        alert("Por favor llena todos los campos requeridos");
        return;
      }
    }

    const postData = {
      nombre: $("#nombre").val(),
      precio: $("#precio").val(),
      unidades: $("#unidades").val(),
      modelo: $("#modelo").val(),
      marca: $("#marca").val(),
      detalles: $("#detalles").val(),
      imagen: $("#imagen").val(),
      id: $("#productId").val(),
    };

    const url = edit ? "./backend/product-edit.php" : "./backend/product-add.php";

    $.post(url, postData, function (response) {
      const respuesta = JSON.parse(response);
      mostrarEstado(respuesta.message, "ok");

      $("#product-form").trigger("reset");
      $("#product-form input, #product-form textarea").removeClass("is-valid is-invalid");
      $("button.btn-primary").text("Agregar Producto");
      edit = false;

      listarProductos();
    });
  });

  // 🔹 Eliminar producto
  $(document).on("click", ".product-delete", function () {
    if (!confirm("¿Seguro que quieres eliminar este producto?")) return;
    const element = $(this).closest("tr");
    const id = $(element).attr("productId");

    $.post("./backend/product-delete.php", { id }, function () {
      mostrarEstado("Producto eliminado correctamente", "ok");
      listarProductos();
    });
  });

  // 🔹 Mostrar mensajes en la barra de estado
  function mostrarEstado(mensaje, tipo) {
    $("#product-result").show();
    const color = tipo === "ok" ? "lightgreen" : "salmon";
    $("#container").html(`<li style="color:${color}; list-style:none;">${mensaje}</li>`);
  }
});
