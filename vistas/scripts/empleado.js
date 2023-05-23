var table;

function init() {
  listar();
  mostrarform(false); //ocultamos formulario al cargar la pagina.
  //Agregamos evento a el formulario para guardar y editar
  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

  //llamado al ajax de departamento para traer los options del select de departamentos
  $.post("../ajax/departamento.php?op=select", function (r) {
    //console.log(r);
    $("#idDepartamento").html(r);
    $("#idDepartamento").selectpicker("refresh");
  });

  //llamado al ajax de empleado para traer los options del select de departamentos
  $.post("../ajax/empleado.php?op=selectJefe", function (r) {
    //console.log(r);
    $("#idJefe").html(r);
    $("#idJefe").selectpicker("refresh");
  });
}

//limpiar formulario
function limpiar() {
  $("#idEmpleado").val("");
  $("#nombre").val("");
  $("#primerApellido").val("");
  $("#segundoApellido").val("");
  $("#email").val("");
  $("#fechaEntrada").val("");
  $("#fechaBaja").val("");
  $("#idDepartamento").val("");
  $("#idDepartamento").selectpicker("refresh");
  $("#idJefe").val("");
  $("#idJefe").selectpicker("refresh");
  $("#esJefe").prop("checked", false);
  $("#usr").val("");
  $("#pwd").val("");
  $("#foto").val("");
  $("#fotoActual").val("");
  $("#imagenmuestra").attr("src", "");
}

function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadoregdata").hide();
    $("#formregdata").show();
    $("#btnagregar").hide();
    $("#btnGuardar").prop("disable", false);
  } else {
    $("#formregdata").hide();
    $("#listadoregdata").show();
    $("#btnagregar").show();
  }
}

function cancelarform() {
  limpiar();
  mostrarform(false);
}

function guardaryeditar(e) {
  e.preventDefault();

  $("#btnagregar").prop("disable", true);

  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/empleado.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false, //no manda cabecero
    processData: false, //no convierte objetos en string

    success: function (mensaje) {
      valida = mensaje.indexOf("error");

      if (valida != -1) {
        toastr["error"](mensaje);
      } else {
        toastr["success"](mensaje);
      }
      mostrarform(false);
      table.ajax.reload();
    },
  });

  limpiar();
}

function listar() {
  table = $("#tblistadoregdata")
    .dataTable({
      Processing: true, //activar procesamiento de tablas
      ServerSide: true, //paginacion y filtros sean realizados por el servidor
      responsive: true, //Active capacidades responsivas en la tabla
      dom: '<"top"Bfl>rt<"bottom"ip><"clear">', // definir los elementos de control de dataTables
      //B botones export, f filtro sencillo, l selector de filtas
      //r mensaje de procesamiento, t Table como tal, i informacion
      //p paginacion
      buttons: [
        {
          extend: "copyHtml5",
          text: "Copy",
          titleAttr: "Copiar al portapapeles",
          className: "btn btn-info",
        },
        {
          extend: "excelHtml5",
          text: "Excel",
          titleAttr: "Exportar a Excel",
          className: "btn btn-success",
        },
        {
          extend: "csvHtml5",
          text: "CSV",
          titleAttr: "Exportar a CSV",
          className: "btn btn-secondary",
        },
        {
          extend: "pdfHtml5",
          text: "PDF",
          titleAttr: "Exportar a PDF",
          className: "btn btn-danger",
        },
      ],
      language: {
        url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-MX.json",
      },
      ajax: {
        url: "../ajax/empleado.php?op=listar",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      destroy: true,
      iDisplayLength: 3, //indica cuantos registros vamos a mostrar en el table.
      order: [[1, "desc"]],
    })
    .DataTable();
}

function mostrar(idEmpleado) {
  // utilizamos el short hand de jQuery para Ajax post
  // podemos crear nuestro propio arreglo de variables poniendo los pares entre {}
  // Función anónima para capturar el regreso
  $.post(
    "../ajax/empleado.php?op=mostrar",
    { idEmpleado: idEmpleado },
    function (data) {
      //console.log(data);
      //convertimos los datos que vienen de regreso en formato Json a tipo objeto
      data = JSON.parse(data);
      console.log(data);
      //Mostramos el formulario y ocultamos el listado
      mostrarform(true);
      //rellenamos a través de instrucciones jQuery los campos del formulario con los datos que nos regresó el Ajax
      $("#idEmpleado").val(data.idEmpleado);
      $("#nombre").val(data.nombre);
      $("#primerApellido").val(data.primerApellido);
      $("#segundoApellido").val(data.segundoApellido);
      $("#email").val(data.email);
      $("#fechaEntrada").val(data.fechaEntrada);
      $("#fechaBaja").val(data.fechaBaja);
      $("#idDepartamento").val(data.idDepartamento);
      $("#idDepartamento").selectpicker("refresh");
      $("#idJefe").val(data.idJefe);
      $("#idJefe").selectpicker("refresh");
      data.esJefe == 1
        ? $("#esJefe").prop("#checked", true)
        : $("#esJefe").prop("checked", false);

      $("#usr").val(data.usr);
      $("#pwd").val(data.pwd);
      $("#fotoActual").val(data.fotoActual);
      $("#imagenmuestra").attr("src", "../files/img/" + data.foto);
    }
  );
}

init();
