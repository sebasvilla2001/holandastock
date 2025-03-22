
let tblUsuarios, tblClientes, tblCajas, tblCategorias, tblMedidas, tblProductos, tblAcceso, tblMov;
document.addEventListener("DOMContentLoaded", function(){
  $('#cliente').select2();

    tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: base_url + "Usuarios/listar", // URL para obtener los datos
            dataSrc: '' 
        },
        columns: [
            { 'data': 'user_id' },        
            { 'data': 'user_usuario' },  
            { 'data': 'user_nombre' },  
            { 'data': 'user_apellido1' },
            { 'data': 'user_apellido2' },
            { 'data': 'caja_caja' },
            { 'data': 'nombre_rol' },
            { 'data': 'user_estado' },              
            { 'data': 'acciones' }       
        ], language: {
          "url": "Assets/js/Spanish.json"
      },
      dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          buttons: [{
            //Botón para Excel
            extend: 'excelHtml5',
            footer: true,
            title: 'Archivo',
            filename: 'Export_File',

            //Aquí es donde generas el botón personalizado
            text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
        },
        //Botón para PDF
        {
            extend: 'pdfHtml5',
            download: 'open',
            footer: true,
            title: 'Reporte de usuarios',
            filename: 'Reporte de usuarios',
            text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para copiar
        {
            extend: 'copyHtml5',
            footer: true,
            title: 'Reporte de usuarios',
            filename: 'Reporte de usuarios',
            text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        //Botón para print
        {
            extend: 'print',
            footer: true,
            filename: 'Export_File_print',
            text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
        },
        //Botón para cvs
        {
            extend: 'csvHtml5',
            footer: true,
            filename: 'Export_File_csv',
            text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
        },
        {
            extend: 'colvis',
            text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
            postfixButtons: ['colvisRestore']
        }
    ]
    });

    //fin de la tabla usuarios
    

    tblClientes = $('#tblClientes').DataTable({
      ajax: {
          url: base_url + "Clientes/listar", // URL para obtener los datos
          dataSrc: '' 
      },
      columns: [
        { 'data': 'cliente_id' },  
        { 'data': 'cliente_nacionalidad' }, 
        { 
            'data': null,  
            'render': function(data, type, row) {
                // Si la nacionalidad es "Nacional"
                if (row.cliente_nacionalidad === 'Nacional') {
                    return row.cliente_tipoCedulaNacional;
                }
                // Si la nacionalidad es "Internacional"
                else if (row.cliente_nacionalidad === 'Internacional') {
                    return row.cliente_tipoCedulaInternacional;
                }
                
                return 'No especificado';
            }
        },       
        { 'data': 'cliente_cedula' },  
        { 'data': 'cliente_nombre' },  
        { 'data': 'cliente_apellido1' },
        { 'data': 'cliente_apellido2' },
        { 'data': 'cliente_telefono' },
        { 'data': 'cliente_direccion' },
        { 'data': 'cliente_estado' },              
        { 'data': 'acciones' }       
    ], language: {
        "url": "Assets/js/Spanish.json"
    },
    dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
          //Botón para Excel
          extend: 'excelHtml5',
          footer: true,
          title: 'Archivo',
          filename: 'Export_File',

          //Aquí es donde generas el botón personalizado
          text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
      },
      //Botón para PDF
      {
          extend: 'pdfHtml5',
          download: 'open',
          footer: true,
          title: 'Reporte de clientes',
          filename: 'Reporte de clientes',
          text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
          exportOptions: {
              columns: [0, ':visible']
          }
      },
      //Botón para copiar
      {
          extend: 'copyHtml5',
          footer: true,
          title: 'Reporte de clientes',
          filename: 'Reporte de clientes',
          text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
          exportOptions: {
              columns: [0, ':visible']
          }
      },
      //Botón para print
      {
          extend: 'print',
          footer: true,
          filename: 'Export_File_print',
          text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
      },
      //Botón para cvs
      {
          extend: 'csvHtml5',
          footer: true,
          filename: 'Export_File_csv',
          text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
      },
      {
          extend: 'colvis',
          text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
          postfixButtons: ['colvisRestore']
      }
  ]
  });

    //fin de la tabla clientes

    tblCategorias = $('#tblCategorias').DataTable({
      ajax: {
          url: base_url + "Categorias/listar", // URL para obtener los datos
          dataSrc: '' 
      },
      columns: [
          { 'data': 'cat_id' },        
          { 'data': 'cat_nombre' },  
          { 'data': 'cat_estado' },              
          { 'data': 'acciones' }       
      ], language: {
        "url": "Assets/js/Spanish.json"
    },
    dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
          //Botón para Excel
          extend: 'excelHtml5',
          footer: true,
          title: 'Archivo',
          filename: 'Export_File',

          //Aquí es donde generas el botón personalizado
          text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
      },
      //Botón para PDF
      {
          extend: 'pdfHtml5',
          download: 'open',
          footer: true,
          title: 'Reporte de categorias',
          filename: 'Reporte de categorias',
          text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
          exportOptions: {
              columns: [0, ':visible']
          }
      },
      //Botón para copiar
      {
          extend: 'copyHtml5',
          footer: true,
          title: 'Reporte de categorias',
          filename: 'Reporte de categorias',
          text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
          exportOptions: {
              columns: [0, ':visible']
          }
      },
      //Botón para print
      {
          extend: 'print',
          footer: true,
          filename: 'Export_File_print',
          text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
      },
      //Botón para cvs
      {
          extend: 'csvHtml5',
          footer: true,
          filename: 'Export_File_csv',
          text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
      },
      {
          extend: 'colvis',
          text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
          postfixButtons: ['colvisRestore']
      }
  ]
  });

  //fin de la tabla categorias

  tblMedidas = $('#tblMedidas').DataTable({
    ajax: {
        url: base_url + "Medidas/listar", // URL para obtener los datos
        dataSrc: '' 
    },
    columns: [
        { 'data': 'med_id' },        
        { 'data': 'med_nombre' },  
        { 'data': 'med_nom_corto' },
        { 'data': 'med_estado' },              
        { 'data': 'acciones' }       
    ], language: {
     "url": "Assets/js/Spanish.json"
  },
  dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [{
        //Botón para Excel
        extend: 'excelHtml5',
        footer: true,
        title: 'Archivo',
        filename: 'Export_File',

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
    },
    //Botón para PDF
    {
        extend: 'pdfHtml5',
        download: 'open',
        footer: true,
        title: 'Reporte de medidas',
        filename: 'Reporte de medidas',
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para copiar
    {
        extend: 'copyHtml5',
        footer: true,
        title: 'Reporte de medidas',
        filename: 'Reporte de medidas',
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para print
    {
        extend: 'print',
        footer: true,
        filename: 'Export_File_print',
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
    },
    //Botón para cvs
    {
        extend: 'csvHtml5',
        footer: true,
        filename: 'Export_File_csv',
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
    },
    {
        extend: 'colvis',
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ['colvisRestore']
    }
]
  });

  //fin de la tabla medidas

  tblMedidas = $('#tblRoles').DataTable({
    ajax: {
        url: base_url + "Roles_Permisos/listar", // URL para obtener los datos
        dataSrc: '' 
    },
    columns: [
        { 'data': 'id_rol' },        
        { 'data': 'nombre_rol' },  
        { 'data': 'descripcion_rol' },
        { 'data': 'rol_estado' },              
        { 'data': 'acciones' }       
    ], language: {
     "url": "Assets/js/Spanish.json"
  },
  dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [{
        //Botón para Excel
        extend: 'excelHtml5',
        footer: true,
        title: 'Archivo',
        filename: 'Export_File',

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
    },
    //Botón para PDF
    {
        extend: 'pdfHtml5',
        download: 'open',
        footer: true,
        title: 'Reporte de medidas',
        filename: 'Reporte de medidas',
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para copiar
    {
        extend: 'copyHtml5',
        footer: true,
        title: 'Reporte de medidas',
        filename: 'Reporte de medidas',
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para print
    {
        extend: 'print',
        footer: true,
        filename: 'Export_File_print',
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
    },
    //Botón para cvs
    {
        extend: 'csvHtml5',
        footer: true,
        filename: 'Export_File_csv',
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
    },
    {
        extend: 'colvis',
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ['colvisRestore']
    }
]
  });

  //fin de la tabla Roles

  tblCajas = $('#tblCajas').DataTable({
    ajax: {
        url: base_url + "Cajas/listar", // URL para obtener los datos
        dataSrc: '' 
    },
    columns: [
        { 'data': 'caja_id' },         
        { 'data': 'caja_caja' },  
        { 'data': 'caja_estado' },              
        { 'data': 'acciones' }       
    ], language: {
     "url": "Assets/js/Spanish.json"
  },
  dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [{
        //Botón para Excel
        extend: 'excelHtml5',
        footer: true,
        title: 'Archivo',
        filename: 'Export_File',

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
    },
    //Botón para PDF
    {
        extend: 'pdfHtml5',
        download: 'open',
        footer: true,
        title: 'Reporte de cajas',
        filename: 'Reporte de cajas',
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para copiar
    {
        extend: 'copyHtml5',
        footer: true,
        title: 'Reporte de cajas',
        filename: 'Reporte de cajas',
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para print
    {
        extend: 'print',
        footer: true,
        filename: 'Export_File_print',
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
    },
    //Botón para cvs
    {
        extend: 'csvHtml5',
        footer: true,
        filename: 'Export_File_csv',
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
    },
    {
        extend: 'colvis',
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ['colvisRestore']
    }
]
  });

  //fin de la tabla cajas

  tblProductos = $('#tblProductos').DataTable({
    ajax: {
        url: base_url + "Productos/listar", // URL para obtener los datos
        dataSrc: '' 
    },
    columns: [
        { 'data': 'pro_id' },   
        { 'data': 'pro_codigo' }, 
        { 'data': 'pro_descripcion' },  
        { 'data': 'pro_precio_venta' },
        { 'data': 'pro_cantidad' }, 
        { 'data': 'med_nom_corto' },     
        { 'data': 'imagen' },      
        { 'data': 'pro_estado' },                  
        { 'data': 'acciones' }       
    ], language: {
                "url": "Assets/js/Spanish.json"
            },
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                  //Botón para Excel
                  extend: 'excelHtml5',
                  footer: true,
                  title: 'Archivo',
                  filename: 'Export_File',
   
                  //Aquí es donde generas el botón personalizado
                  text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
              },
              //Botón para PDF
              {
                  extend: 'pdfHtml5',
                  download: 'open',
                  footer: true,
                  title: 'Reporte de productos',
                  filename: 'Reporte de productos',
                  text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
                  exportOptions: {
                      columns: [0, ':visible']
                  }
              },
              //Botón para copiar
              {
                  extend: 'copyHtml5',
                  footer: true,
                  title: 'Reporte de productos',
                  filename: 'Reporte de productos',
                  text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
                  exportOptions: {
                      columns: [0, ':visible']
                  }
              },
              //Botón para print
              {
                  extend: 'print',
                  footer: true,
                  filename: 'Export_File_print',
                  text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
              },
              //Botón para cvs
              {
                  extend: 'csvHtml5',
                  footer: true,
                  filename: 'Export_File_csv',
                  text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
              },
              {
                  extend: 'colvis',
                  text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
                  postfixButtons: ['colvisRestore']
              }
          ]
  });

  //fin de la tabla productos

  $('#t_historial_c').DataTable({
    ajax: {
        url: base_url + "Compras/listar_historial", // URL para obtener los datos
        dataSrc: '' 
    },
    columns: [
        { 'data': 'comp_id' },   
        { 'data': 'comp_total' }, 
        { 'data': 'comp_fecha' },                 
        { 'data': 'acciones' }       
    ] ,language: {
      "sProcessing":     "Procesando...",
	"sLengthMenu":     "Mostrar _MENU_ registros",
	"sZeroRecords":    "No se encontraron resultados",
	"sEmptyTable":     "Ningún dato disponible en esta tabla",
	"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	"sInfoPostFix":    "",
	"sSearch":         "Buscar:",
	"sUrl":            "",
	"sInfoThousands":  ",",
	"sLoadingRecords": "Cargando...",
	"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
	},
	"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	}
},
  
  dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [{
        //Botón para Excel
        extend: 'excelHtml5',
        footer: true,
        title: 'Archivo',
        filename: 'Export_File',

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
    },
    //Botón para PDF
    {
        extend: 'pdfHtml5',
        download: 'open',
        footer: true,
        title: 'Reporte del historial de las compras',
        filename: 'Reporte del historial de las compras',
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para copiar
    {
        extend: 'copyHtml5',
        footer: true,
        title: 'Reporte del historial de las compras',
        filename: 'Reporte del historial de las compras',
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para print
    {
        extend: 'print',
        footer: true,
        filename: 'Export_File_print',
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
    },
    //Botón para cvs
    {
        extend: 'csvHtml5',
        footer: true,
        filename: 'Export_File_csv',
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
    },
    {
        extend: 'colvis',
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ['colvisRestore']
    }
]
  });

  //fin de la tabla historial compras

  $('#t_historial_v').DataTable({
    ajax: {
        url: base_url + "Ventas/listar_historial", // URL para obtener los datos
        dataSrc: '' 
    },
    columns: [
        { 'data': 'vent_id' },   
        { 'data': 'vent_total' }, 
        { 'data': 'vent_fecha' },                 
        { 'data': 'acciones' }       
    ] ,language: {
      "sProcessing":     "Procesando...",
	"sLengthMenu":     "Mostrar _MENU_ registros",
	"sZeroRecords":    "No se encontraron resultados",
	"sEmptyTable":     "Ningún dato disponible en esta tabla",
	"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	"sInfoPostFix":    "",
	"sSearch":         "Buscar:",
	"sUrl":            "",
	"sInfoThousands":  ",",
	"sLoadingRecords": "Cargando...",
	"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
	},
	"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	}
},
  
  dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [{
        //Botón para Excel
        extend: 'excelHtml5',
        footer: true,
        title: 'Archivo',
        filename: 'Export_File',

        //Aquí es donde generas el botón personalizado
        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
    },
    //Botón para PDF
    {
        extend: 'pdfHtml5',
        download: 'open',
        footer: true,
        title: 'Reporte del historial de las compras',
        filename: 'Reporte del historial de las compras',
        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para copiar
    {
        extend: 'copyHtml5',
        footer: true,
        title: 'Reporte del historial de las compras',
        filename: 'Reporte del historial de las compras',
        text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
        exportOptions: {
            columns: [0, ':visible']
        }
    },
    //Botón para print
    {
        extend: 'print',
        footer: true,
        filename: 'Export_File_print',
        text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
    },
    //Botón para cvs
    {
        extend: 'csvHtml5',
        footer: true,
        filename: 'Export_File_csv',
        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
    },
    {
        extend: 'colvis',
        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
        postfixButtons: ['colvisRestore']
    }
]
  });

  //fin de la tabla historial ventas


  $(document).ready(function () {
      var tblAcceso = $('#tblAcceso').DataTable({
          ajax: {
              url: base_url + "BitAcceso/listar", // URL para obtener los datos
              type: "POST",
              data: function (d) {
                  d.desde = $('#desde').val();
                  d.hasta = $('#hasta').val();
                  d.usuario = $('#usuario').val();
              },
              dataSrc: '',
              error: function (xhr, error, thrown) {
                  console.log("Error en la petición AJAX:", error);
                  console.log(xhr.responseText);
              }
          },
          columns: [
              { 'data': 'id' },
              { 'data': 'usuario' },
              { 'data': 'fecha_ingreso' },
              { 'data': 'fecha_salida' }
          ],
          language: {
              "url": "Assets/js/Spanish.json"
          }
      });

    
      $('#btnFiltrar').click(function () {
          tblAcceso.ajax.reload(null, false); // Recargar los datos sin resetear la paginación
      });

      $('#usuario').change(function () {
          $('#desde').val('');
          $('#hasta').val('');
      });

      $('#desde, #hasta').change(function () {
          $('#usuario').val('');
      });
  });

  //fin de la tabla Bitacora de acceso

    $(document).ready(function () {
      var tblMov = $('#tblMov').DataTable({
          ajax: {
              url: base_url + "BitMov/listar", // URL para obtener los datos
              type: "POST",
              data: function (d) {
                  d.desde = $('#desde').val();
                  d.hasta = $('#hasta').val();
                  d.usuario = $('#usuario').val();
                  d.tipo_movimiento = $('#tipo_movimiento').val();
              },
              dataSrc: '',
          },
          columns: [
              { 'data': 'id' },
              { 'data': 'usuario' },
              { 'data': 'tipo_movimiento' },
              { 'data': 'fecha' },
              { 'data': 'detalle' }
          ],
          language: {
              "url": "Assets/js/Spanish.json"
          }
      });

      // Evento para aplicar filtros
      $('#btnFiltrar').click(function () {
          tblMov.ajax.reload(null, false); // Recargar los datos sin resetear la paginación
      });

      // Limpiar otros filtros cuando se selecciona un valor en uno de los filtros
      $('#usuario').change(function () {
          $('#tipo_movimiento').val(''); 
          $('#desde').val(''); 
          $('#hasta').val(''); 
      });

      $('#tipo_movimiento').change(function () {
          $('#usuario').val(''); 
          $('#desde').val(''); 
          $('#hasta').val(''); 
      });

      $('#desde').change(function () {
          $('#usuario').val(''); 
          $('#tipo_movimiento').val(''); 
         
      });

      $('#hasta').change(function () {
          $('#usuario').val(''); 
          $('#tipo_movimiento').val(''); 
         
      });
  });

  //fin de la tabla bitacora de moviemientos


})



/*********************** INICIO CAMBIO PASS ***********************/ 

function frmCambiarPass(e){
  e.preventDefault();

}


/*********************** FIN CAMBIO PASS ***********************/ 


/*********************** INICIO USUARIOS ***********************/ 

function frmUsuario(){
    document.getElementById("title").innerHTML = "Nuevo Usuario";
    document.getElementById("btnModificar").innerHTML = "Registrar";
    document.getElementById("claves").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    $("#nuevo_usuario").modal("show");
    document.getElementById("id").value = "";
}

document.addEventListener("DOMContentLoaded", function () {
  configurarEventoUsuario();
});

function configurarEventoUsuario() {
  const usuarioInput = document.getElementById("usuario");
  const modo = document.getElementById("modo")?.value; // ? previene error si "modo" no existe

  if (modo === "nuevo" && usuarioInput) {
      usuarioInput.addEventListener("blur", function () {
          validarUsuario();
      });
  }
}

function validarUsuario() {
  const usuarioInput = document.getElementById("usuario");
  const usuario = usuarioInput.value.trim();

  if (usuario.length > 0) {
      const url = base_url + "Usuarios/validarUsuario";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
              console.log(this.responseText);
              const res = JSON.parse(this.responseText);

              if (res == "existe") {
                  usuarioInput.style.border = "2px solid red"; 
                  document.getElementById("btnModificar").disabled = true;
              } else {
                  usuarioInput.style.border = "2px solid green"; 
                  document.getElementById("btnModificar").disabled = false;
              }
          }
      };
      http.send("usuario=" + encodeURIComponent(usuario));
  }
}

function registrarUser(e) {
  e.preventDefault();
  const modo = document.getElementById("modo").value;
  const usuario = document.getElementById("usuario");
  const nombre = document.getElementById("nombre");
  const apellido1 = document.getElementById("apellido1");
  const apellido2 = document.getElementById("apellido2");
  const clave = document.getElementById("clave");
  const confirmar = document.getElementById("confirmar");
  const caja = document.getElementById("caja");

  if (usuario.value == "" || nombre.value == "" || caja.value == "" || apellido1.value == "" || apellido2.value == "") {
      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Todos los campos son obligatorios",
          showConfirmButton: false,
          timer: 3000
      });
  } else {
      const url = base_url + "Usuarios/registrar";
      const frm = document.getElementById("frmUsuario");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
              console.log(this.responseText);
              const res = JSON.parse(this.responseText);
              if (res == "si") {
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Usuario Agregado Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                  }).then(() => {
                      window.location.reload();
                  });
                  frm.reset();
                  document.getElementById("modo").value = "nuevo"; // Cambia a "nuevo" después de registrar
                  $("#nuevo_usuario").modal("hide");
              } else if (res == "modificado") {
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Usuario Modificado Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                  }).then(() => {
                      window.location.reload();
                  });
                  document.getElementById("modo").value = "nuevo"; // Cambia a "nuevo" después de modificar
                  $("#nuevo_usuario").modal("hide");
              } else {
                  Swal.fire({
                      position: "top-end",
                      icon: "error",
                      title: res,
                      showConfirmButton: false,
                      timer: 3000
                  });
              }
          }
      };
  }
}

$("#nuevo_usuario").on("hidden.bs.modal", function () {
  window.location.reload();
});




function btnEditarUser(id){
    document.getElementById("title").innerHTML = "Actualizar Usuario";
    document.getElementById("btnModificar").innerHTML = "Modificar";
    const url = base_url + "Usuarios/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState== 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.user_id;
            document.getElementById("usuario").value = res.user_usuario;
            document.getElementById("nombre").value = res.user_nombre;
            document.getElementById("apellido1").value = res.user_apellido1;
            document.getElementById("apellido2").value = res.user_apellido2;
            document.getElementById("caja").value = res.user_idcaja;
            document.getElementById("rol").value = res.user_idrol;
            document.getElementById("claves").classList.add("d-none");
            $("#nuevo_usuario").modal("show");
        }

    }
    

}

function btnEliminarUser(id){

    Swal.fire({
        title: "¿Está seguro de que desea modificar el estado de este usuario?",
        text: "Esta acción no eliminará al usuario, únicamente cambiará su estado a 'Inactivo'.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#42ab06",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          const url = `${base_url}Usuarios/eliminar/${id}`;
          const http = new XMLHttpRequest();
      
          http.open("GET", url, true);
          http.send();
      
          http.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
              
                const res = JSON.parse(this.responseText);
              if (res == "ok") {
                Swal.fire({
                    title: "Estado modificado",
                    text: "El estado del usuario ha sido cambiado a 'Inactivo' exitosamente.",
                    confirmButtonColor: "#0686ab",
                    icon: "success"
                  }).then(() => {
                    location.reload(); // Recargar la pantalla
                  });
              }else{

                Swal.fire({
                    title: "!Mensaje¡",
                    text: res,
                    confirmButtonColor: "#0686ab",
                    icon: "error"
                  });
                  
              }
      
            }
          }
        }
      });



}

function btnReingresarUser(id){

    Swal.fire({
        title: "¿Está seguro de que desea modificar el estado de este usuario?",
        text: "Esta acción activará al usuario y cambiará su estado a 'Activo'.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#42ab06",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          const url = `${base_url}Usuarios/reingresar/${id}`;
          const http = new XMLHttpRequest();
      
          http.open("GET", url, true);
          http.send();
      
          http.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
              const res = JSON.parse(this.responseText);
              if (res === "ok") {
                Swal.fire({
                  title: "Estado modificado",
                  text: "El estado del usuario ha sido cambiado a 'Activo' exitosamente.",
                  confirmButtonColor: "#0686ab",
                  icon: "success"
                }).then(() => {
                  location.reload(); // Recargar la pantalla
                });
              } else {
                Swal.fire({
                  title: "¡Error!",
                  text: res,
                  confirmButtonColor: "#0686ab",
                  icon: "error"
                });
              }
            }
          };
        }
      });

}
/*********************** FIN USUARIOS ***********************/ 

/*********************** INICIO CLIENTES ***********************/ 

function frmCliente(){
    document.getElementById("title").innerHTML = "Nuevo Cliente";
    document.getElementById("btnModificar").innerHTML = "Registrar";
    document.getElementById("frmCliente").reset();
    $("#nuevo_cliente").modal("show");
    document.getElementById("id").value = "";
}

document.addEventListener("DOMContentLoaded", function () {
  configurarEventoCli();
});

function configurarEventoCli() {
  const cedulaInput = document.getElementById("cedula");
  const modo = document.getElementById("modo")?.value; // ? previene error si "modo" no existe

  if (modo === "nuevo" && cedulaInput) {
      cedulaInput.addEventListener("blur", function () {
          validarCli();
      });
  }
}

function validarCli() {
  const cedulaInput = document.getElementById("cedula");
  const cedula = cedulaInput.value.trim();

  if (cedula.length > 0) {
      const url = base_url + "Clientes/validarCli";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
              console.log(this.responseText);
              const res = JSON.parse(this.responseText);

              if (res === "existe") {
                cedulaInput.style.border = "2px solid red"; 
                  document.getElementById("btnModificar").disabled = true;
              } else {
                cedulaInput.style.border = "2px solid green"; 
                  document.getElementById("btnModificar").disabled = false;
              }
          }
      };
      http.send("cedula=" + encodeURIComponent(cedula));
  }
}


function registrarCli(e) {
  e.preventDefault();

  // Obtener valores de los inputs correctamente
  const nacionalidad = document.getElementById("nacionalidad").value;
  const tipoCedulaNacional = document.getElementById("tipoCedulaNacional").value;
  const tipoCedulaInternacional = document.getElementById("tipoCedulaInternacional").value;
  const cedula = document.getElementById("cedula").value.trim();
  const nombre = document.getElementById("nombre").value.trim();
  const apellido1 = document.getElementById("apellido1").value.trim();
  const apellido2 = document.getElementById("apellido2").value.trim();
  const telefono = document.getElementById("telefono").value.trim();
  const direccion = document.getElementById("direccion").value.trim();

  // Verificación de campos obligatorios
  if (nacionalidad === "") {
      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Debe seleccionar una nacionalidad",
          showConfirmButton: false,
          timer: 3000
      });
      return;
  }

  // Validar cédula nacional e internacional
  if (nacionalidad === "Nacional" && tipoCedulaNacional === "") {
      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Debe seleccionar el tipo de cédula para clientes nacionales",
          showConfirmButton: false,
          timer: 3000
      });
      return;
  }

  if (nacionalidad === "Internacional" && tipoCedulaInternacional === "") {
      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Debe seleccionar el tipo de documento para clientes internacionales",
          showConfirmButton: false,
          timer: 3000
      });
      return;
  }

  // Verificar que el campo "Cédula / Documento" tenga un valor
  if (cedula === "") {
      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Debe ingresar el número de documento correspondiente",
          showConfirmButton: false,
          timer: 3000
      });
      return;
  }

  const url = base_url + "Clientes/registrar";
  const frm = document.getElementById("frmCliente");
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));

  http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "si") {
              Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Cliente Agregado Correctamente",
                  showConfirmButton: false,
                  timer: 2000
              }).then(() => {
                  window.location.reload();
              });
              frm.reset();
              $("#nuevo_cliente").modal("hide");
          } else if (res == "modificado") {
              Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Cliente Modificado Correctamente",
                  showConfirmButton: false,
                  timer: 2000
              }).then(() => {
                  window.location.reload();
              });
              $("#nuevo_cliente").modal("hide");
          } else {
              Swal.fire({
                  position: "top-end",
                  icon: "error",
                  title: res,
                  showConfirmButton: false,
                  timer: 3000
              });
          }
      }
  };
}

$("#nuevo_cliente").on("hidden.bs.modal", function () {
  window.location.reload();
});


function toggleDocumento() {
  var nacionalidad = document.getElementById("nacionalidad").value;
  var tipoDocumentoNacional = document.getElementById("tipoDocumentoNacional");
  var tipoDocumentoInternacional = document.getElementById("tipoDocumentoInternacional");

  // Restablecer valores al cambiar la nacionalidad
  document.getElementById("tipoCedulaNacional").value = "";
  document.getElementById("tipoCedulaInternacional").value = "";
  document.getElementById("cedula").value = "";

  // Mostrar u ocultar los selectores según la nacionalidad elegida
  if (nacionalidad === "Nacional") {
      tipoDocumentoNacional.style.display = "block";
      tipoDocumentoInternacional.style.display = "none";
  } else if (nacionalidad === "Internacional") {
      tipoDocumentoInternacional.style.display = "block";
      tipoDocumentoNacional.style.display = "none";
  } else {
      // Si no se selecciona ninguna nacionalidad, ocultar ambos selectores
      tipoDocumentoNacional.style.display = "none";
      tipoDocumentoInternacional.style.display = "none";
  }
}

function btnEditarCli(id) {
  document.getElementById("title").innerHTML = "Actualizar Cliente";
  document.getElementById("btnModificar").innerHTML = "Modificar";

  const url = base_url + "Clientes/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      
      document.getElementById("id").value = res.cliente_id;
      document.getElementById("cedula").value = res.cliente_cedula;
      document.getElementById("nombre").value = res.cliente_nombre;
      document.getElementById("apellido1").value = res.cliente_apellido1;
      document.getElementById("apellido2").value = res.cliente_apellido2;
      document.getElementById("telefono").value = res.cliente_telefono;
      document.getElementById("direccion").value = res.cliente_direccion;
      
      let nacionalidadSelect = document.getElementById("nacionalidad");
      nacionalidadSelect.value = res.cliente_nacionalidad.trim();

      actualizarTipoCedula();

      // Asignar el valor correcto al tipo de cédula dependiendo de la nacionalida
      if (res.cliente_nacionalidad === "Nacional") {
        document.getElementById("tipoCedulaNacional").value = res.cliente_tipoCedulaNacional.trim();
      } else if (res.cliente_nacionalidad === "Internacional") {
        document.getElementById("tipoCedulaInternacional").value = res.cliente_tipoCedulaInternacional.trim();
      }


      nacionalidadSelect.addEventListener("change", actualizarTipoCedula);

      console.log("Datos cargados:", res);


      $("#nuevo_cliente").modal("show");
    }
  };
}


function actualizarTipoCedula() { //en el formulario, para traer los datos del tipo de cedula
  let nacionalidad = document.getElementById("nacionalidad").value;
  let tipoCedulaNacional = document.getElementById("tipoCedulaNacional");
  let tipoCedulaInternacional = document.getElementById("tipoCedulaInternacional");

  if (nacionalidad === "Nacional") {
    tipoCedulaNacional.style.display = "block";
    tipoCedulaInternacional.style.display = "none";
    tipoCedulaInternacional.value = ""; // Limpiar el otro campo
  } else if (nacionalidad === "Internacional") {
    tipoCedulaInternacional.style.display = "block";
    tipoCedulaNacional.style.display = "none";
    tipoCedulaNacional.value = ""; // Limpiar el otro campo
  } else {
    tipoCedulaNacional.style.display = "none";
    tipoCedulaInternacional.style.display = "none";
  }
}



function btnEliminarCli(id){

    Swal.fire({
        title: "¿Está seguro de que desea modificar el estado de este Cliente?",
        text: "Esta acción no eliminará al cliente, únicamente cambiará su estado a 'Inactivo'.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#42ab06",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          const url = `${base_url}Clientes/eliminar/${id}`;
          const http = new XMLHttpRequest();
      
          http.open("GET", url, true);
          http.send();
      
          http.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
              console.log(this.responseText);
                const res = JSON.parse(this.responseText);
              if (res == "ok") {
                Swal.fire({
                    title: "Estado modificado",
                    text: "El estado del cliente ha sido cambiado a 'Inactivo' exitosamente.",
                    confirmButtonColor: "#0686ab",
                    icon: "success"
                  }).then(() => {
                    location.reload(); // Recargar la pantalla
                  });
              }else{

                Swal.fire({
                    title: "!Mensaje¡",
                    text: res,
                    confirmButtonColor: "#0686ab",
                    icon: "error"
                  });
                  
              }
      
            }
          }
        }
      });



}

function btnReingresarCli(id){

    Swal.fire({
        title: "¿Está seguro de que desea modificar el estado de este cliente?",
        text: "Esta acción activará al cliente y cambiará su estado a 'Activo'.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#42ab06",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          const url = `${base_url}Clientes/reingresar/${id}`;
          const http = new XMLHttpRequest();
      
          http.open("GET", url, true);
          http.send();
      
          http.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
              console.log(this.responseText);
              const res = JSON.parse(this.responseText);
              if (res === "ok") {
                Swal.fire({
                  title: "Estado modificado",
                  text: "El estado del cliente ha sido cambiado a 'Activo' exitosamente.",
                  confirmButtonColor: "#0686ab",
                  icon: "success"
                }).then(() => {
                  location.reload(); // Recargar la pantalla
                });
              } else {
                Swal.fire({
                  title: "¡Error!",
                  text: res,
                  confirmButtonColor: "#0686ab",
                  icon: "error"
                });
              }
            }
          };
        }
      });

}

/*********************** FIN CLIENTES ***********************/ 


/*********************** INICIO CATEGORIAS ***********************/ 

function frmCategoria(){
  document.getElementById("title").innerHTML = "Nueva Categoría";
  document.getElementById("btnModificar").innerHTML = "Registrar";
  document.getElementById("frmCategoria").reset();
  $("#nueva_categoria").modal("show");
  document.getElementById("id").value = "";
}

function registrarCat(e){

  e.preventDefault();
  const nombre = document.getElementById("nombre");
  if(nombre.value == ""){

      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Todos los campos son obligatorios para completar el registro",
          showConfirmButton: false,
          timer: 3000
        });
      
  }else{
      const url = base_url + "Categorias/registrar";
      const frm = document.getElementById("frmCategoria");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function(){
          if (this.readyState== 4 && this.status == 200) {
              const res = JSON.parse(this.responseText);
              if (res == "si") {
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Categoría Agregada Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(() => {
                      // Recargar la página después de cerrar la alerta
                      window.location.reload();
                  });
                    frm.reset();
                    $("#nueva_categoria").modal("hide");
              }else if(res == "modificado"){
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Categoría Modificada Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(() => {
                      // Recargar la página después de cerrar la alerta
                      window.location.reload();
                  });
                  $("#nueva_categoria").modal("hide");
              }else{
                  Swal.fire({
                      position: "top-end",
                      icon: "error",
                      title: res,
                      showConfirmButton: false,
                      timer: 3000
                    });
              }
          }

      }
  }


}

function btnEditarCat(id){
  document.getElementById("title").innerHTML = "Actualizar Categorias";
  document.getElementById("btnModificar").innerHTML = "Modificar";
  const url = base_url + "Categorias/editar/"+id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function(){
      if (this.readyState== 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          document.getElementById("id").value = res.cat_id;
          document.getElementById("nombre").value = res.cat_nombre;
          $("#nueva_categoria").modal("show");
      }

  }
  

}

function btnEliminarCat(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de esta Categoría?",
      text: "Esta acción no eliminará la categoría, únicamente cambiará su estado a 'Inactivo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Categorias/eliminar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
              const res = JSON.parse(this.responseText);
            if (res == "ok") {
              Swal.fire({
                  title: "Estado modificado",
                  text: "El estado de la categoria ha sido cambiado a 'Inactivo' exitosamente.",
                  confirmButtonColor: "#0686ab",
                  icon: "success"
                }).then(() => {
                  location.reload(); // Recargar la pantalla
                });
            }else{

              Swal.fire({
                  title: "!Mensaje¡",
                  text: res,
                  confirmButtonColor: "#0686ab",
                  icon: "error"
                });
                
            }
    
          }
        }
      }
    });



}

function btnReingresarCat(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de esta catagoría?",
      text: "Esta acción activará la categoría y cambiará su estado a 'Activo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Categorias/reingresar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res === "ok") {
              Swal.fire({
                title: "Estado modificado",
                text: "El estado de la categoría ha sido cambiado a 'Activo' exitosamente.",
                confirmButtonColor: "#0686ab",
                icon: "success"
              }).then(() => {
                location.reload(); // Recargar la pantalla
              });
            } else {
              Swal.fire({
                title: "¡Error!",
                text: res,
                confirmButtonColor: "#0686ab",
                icon: "error"
              });
            }
          }
        };
      }
    });

}

/*********************** FIN CATEGORIAS ***********************/ 


/*********************** INICIO MEDIDAS ***********************/ 

function frmMedida(){
  document.getElementById("title").innerHTML = "Nueva Medida";
  document.getElementById("btnModificar").innerHTML = "Registrar";
  document.getElementById("frmMedida").reset();
  $("#nueva_medida").modal("show");
  document.getElementById("id").value = "";
}

function registrarMed(e){

  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const nomcorto = document.getElementById("nomcorto");
  if(nombre.value == "" || nomcorto.value == ""){

      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Los campos 'Nombre' y 'Abreviatura' son obligatorios para completar el registro",
          showConfirmButton: false,
          timer: 3000
        });
      
  }else{
      const url = base_url + "Medidas/registrar";
      const frm = document.getElementById("frmMedida");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function(){
          if (this.readyState== 4 && this.status == 200) {
              const res = JSON.parse(this.responseText);
              if (res == "si") {
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Medida Agregada Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(() => {
                      // Recargar la página después de cerrar la alerta
                      window.location.reload();
                  });
                    frm.reset();
                    $("#nueva_medida").modal("hide");
              }else if(res == "modificado"){
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Medida Modificada Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(() => {
                      // Recargar la página después de cerrar la alerta
                      window.location.reload();
                  });
                  $("#nueva_medida").modal("hide");
              }else{
                  Swal.fire({
                      position: "top-end",
                      icon: "error",
                      title: res,
                      showConfirmButton: false,
                      timer: 3000
                    });
              }
          }

      }
  }


}

function btnEditarMed(id){
  document.getElementById("title").innerHTML = "Actualizar Medidas";
  document.getElementById("btnModificar").innerHTML = "Modificar";
  const url = base_url + "Medidas/editar/"+id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function(){
      if (this.readyState== 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          document.getElementById("id").value = res.med_id;
          document.getElementById("nombre").value = res.med_nombre;
          document.getElementById("nomcorto").value = res.med_nom_corto;
          $("#nueva_medida").modal("show");
      }

  }
  

}

function btnEliminarMed(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de esta Medida?",
      text: "Esta acción no eliminará la Medida, únicamente cambiará su estado a 'Inactivo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Medidas/eliminar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
              const res = JSON.parse(this.responseText);
            if (res == "ok") {
              Swal.fire({
                  title: "Estado modificado",
                  text: "El estado de la Medida ha sido cambiado a 'Inactivo' exitosamente.",
                  confirmButtonColor: "#0686ab",
                  icon: "success"
                }).then(() => {
                  location.reload(); // Recargar la pantalla
                });
            }else{

              Swal.fire({
                  title: "!Mensaje¡",
                  text: res,
                  confirmButtonColor: "#0686ab",
                  icon: "error"
                });
                
            }
    
          }
        }
      }
    });



}

function btnReingresarMed(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de esta Medida?",
      text: "Esta acción activará la Medida y cambiará su estado a 'Activo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Medidas/reingresar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res === "ok") {
              Swal.fire({
                title: "Estado modificado",
                text: "El estado de la Medida ha sido cambiado a 'Activo' exitosamente.",
                confirmButtonColor: "#0686ab",
                icon: "success"
              }).then(() => {
                location.reload(); // Recargar la pantalla
              });
            } else {
              Swal.fire({
                title: "¡Error!",
                text: res,
                confirmButtonColor: "#0686ab",
                icon: "error"
              });
            }
          }
        };
      }
    });

}

/*********************** FIN MEDIDAS ***********************/ 



/*********************** INICIO CAJAS ***********************/ 

function frmCajas(){
  document.getElementById("title").innerHTML = "Nueva Caja";
  document.getElementById("btnModificar").innerHTML = "Registrar";
  document.getElementById("frmCajas").reset();
  $("#nueva_caja").modal("show");
  document.getElementById("id").value = "";
}

function registrarCajas(e){

  e.preventDefault();
  const nombre = document.getElementById("nombre");
  if(nombre.value == ""){

      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Todos los campos son obligatorios para completar el registro",
          showConfirmButton: false,
          timer: 3000
        });
      
  }else{
      const url = base_url + "Cajas/registrar";
      const frm = document.getElementById("frmCajas");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function(){
          if (this.readyState== 4 && this.status == 200) {
            //console.log(this.responseText);
              const res = JSON.parse(this.responseText);
              if (res == "si") {
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Caja Agregada Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(() => {
                      // Recargar la página después de cerrar la alerta
                      window.location.reload();
                  });
                    frm.reset();
                    $("#nueva_caja").modal("hide");
              }else if(res == "modificado"){
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Caja Modificada Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(() => {
                      // Recargar la página después de cerrar la alerta
                      window.location.reload();
                  });
                  $("#nueva_caja").modal("hide");
              }else{
                  Swal.fire({
                      position: "top-end",
                      icon: "error",
                      title: res,
                      showConfirmButton: false,
                      timer: 3000
                    });
              }
          }

      }
  }


}

function btnEditarCaja(id){
  document.getElementById("title").innerHTML = "Actualizar Cliente";
  document.getElementById("btnModificar").innerHTML = "Modificar";
  const url = base_url + "Cajas/editar/"+id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function(){
      if (this.readyState== 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          document.getElementById("id").value = res.caja_id;
          document.getElementById("nombre").value = res.caja_caja;
          $("#nueva_caja").modal("show");
      }

  }
  

}

function btnEliminarCaja(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de esta caja?",
      text: "Esta acción no eliminará la caja, únicamente cambiará su estado a 'Inactivo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Cajas/eliminar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
           // console.log(this.responseText);
              const res = JSON.parse(this.responseText);
            if (res == "ok") {
              Swal.fire({
                  title: "Estado modificado",
                  text: "El estado de la caja ha sido cambiado a 'Inactivo' exitosamente.",
                  confirmButtonColor: "#0686ab",
                  icon: "success"
                }).then(() => {
                  location.reload(); // Recargar la pantalla
                });
            }else{

              Swal.fire({
                  title: "!Mensaje¡",
                  text: res,
                  confirmButtonColor: "#0686ab",
                  icon: "error"
                });
                
            }
    
          }
        }
      }
    });



}

function btnReingresarCaja(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de esta caja?",
      text: "Esta acción activará la caja y cambiará su estado a 'Activo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Cajas/reingresar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res === "ok") {
              Swal.fire({
                title: "Estado modificado",
                text: "El estado de la caja ha sido cambiado a 'Activo' exitosamente.",
                confirmButtonColor: "#0686ab",
                icon: "success"
              }).then(() => {
                location.reload(); // Recargar la pantalla
              });
            } else {
              Swal.fire({
                title: "¡Error!",
                text: res,
                confirmButtonColor: "#0686ab",
                icon: "error"
              });
            }
          }
        };
      }
    });

}

/*********************** FIN CAJAS ***********************/ 

/*********************** INICIO PRODUCTOS ***********************/ 

function frmProducto(){
  document.getElementById("title").innerHTML = "Nuevo Producto";
  document.getElementById("btnModificar").innerHTML = "Registrar";
  document.getElementById("frmProducto").reset();
  $("#nuevo_producto").modal("show");
  document.getElementById("id").value = "";
  deleteImg();
}

document.addEventListener("DOMContentLoaded", function () {
  configurarEventoPro();
});

function configurarEventoPro() {
  const codigoInput = document.getElementById("codigo");
  const modo = document.getElementById("modo")?.value; // ? previene error si "modo" no existe

  if (modo === "nuevo" && codigoInput) {
      codigoInput.addEventListener("blur", function () {
          validarPro();
      });
  }
}

function validarPro() {
  const codigoInput = document.getElementById("codigo");
  const codigo = codigoInput.value.trim();

  if (codigo.length > 0) {
      const url = base_url + "Productos/validarPro";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
              console.log(this.responseText);
              const res = JSON.parse(this.responseText);

              if (res === "existe") {
                  codigoInput.style.border = "2px solid red"; 
                  document.getElementById("btnModificar").disabled = true;
              } else {
                  codigoInput.style.border = "2px solid green"; 
                  document.getElementById("btnModificar").disabled = false;
              }
          }
      };
      http.send("codigo=" + encodeURIComponent(codigo));
  }
}

function registrarPro(e) {
  e.preventDefault();
  const modo = document.getElementById("modo").value;
  const codigo = document.getElementById("codigo");
  const nombre = document.getElementById("nombre");
  const precio_compra = document.getElementById("precio_compra");
  const precio_venta = document.getElementById("precio_venta");
  const id_medida = document.getElementById("medida");
  const id_categoria = document.getElementById("categoria");

  if (codigo.value == "" || nombre.value == "" || precio_compra.value == "" || precio_venta.value == "") {
      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Todos los campos son obligatorios",
          showConfirmButton: false,
          timer: 3000
      });
  } else {
      const url = base_url + "Productos/registrar";
      const frm = document.getElementById("frmProducto");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
              console.log(this.responseText);
              const res = JSON.parse(this.responseText);
              if (res === "si") {
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Producto Agregado Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                  }).then(() => {
                      window.location.reload();
                  });
                  frm.reset();
                  document.getElementById("modo").value = "nuevo";
                  $("#nuevo_producto").modal("hide");
              } else if (res === "modificado") {
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Producto Modificado Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                  }).then(() => {
                      window.location.reload();
                  });
                  document.getElementById("modo").value = "nuevo";
                  $("#nuevo_producto").modal("hide");
              } else {
                  Swal.fire({
                      position: "top-end",
                      icon: "error",
                      title: res,
                      showConfirmButton: false,
                      timer: 3000
                  });
              }
          }
      };
  }
}

$("#nuevo_producto").on("hidden.bs.modal", function () {
  window.location.reload();
});


function btnEditarPro(id){
  document.getElementById("title").innerHTML = "Actualizar Producto";
  document.getElementById("btnModificar").innerHTML = "Modificar";
  const url = base_url + "Productos/editar/"+id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function(){
      if (this.readyState== 4 && this.status == 200) {
        //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          document.getElementById("id").value = res.pro_id;
          document.getElementById("codigo").value = res.pro_codigo;
          document.getElementById("nombre").value = res.pro_descripcion;
          document.getElementById("precio_compra").value = res.pro_precio_compra;
          document.getElementById("precio_venta").value = res.pro_precio_venta;
          document.getElementById("medida").value = res.pro_id_medida;
          document.getElementById("categoria").value = res.pro_id_categoria;
          document.getElementById("img-preview").src = base_url + 'Assets/img/'+res.pro_foto;
          document.getElementById("icon-cerrar").innerHTML = `
          <button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-times"></i></button>`;
          document.getElementById("icon-image").classList.add("d-none");
          document.getElementById("foto_actual").value = res.pro_foto;
          $("#nuevo_producto").modal("show");
      }

  }
  

}

function btnEliminarPro(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de este producto?",
      text: "Esta acción no eliminará al producto, únicamente cambiará su estado a 'Inactivo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Productos/eliminar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
              const res = JSON.parse(this.responseText);
            if (res == "ok") {
              Swal.fire({
                  title: "Estado modificado",
                  text: "El estado del producto ha sido cambiado a 'Inactivo' exitosamente.",
                  confirmButtonColor: "#0686ab",
                  icon: "success"
                }).then(() => {
                  location.reload(); // Recargar la pantalla
                });
            }else{

              Swal.fire({
                  title: "!Mensaje¡",
                  text: res,
                  confirmButtonColor: "#0686ab",
                  icon: "error"
                });
                
            }
    
          }
        }
      }
    });



}

function btnReingresarPro(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de este producto?",
      text: "Esta acción activará al producto y cambiará su estado a 'Activo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = base_url+ "Productos/reingresar/"+id;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res === "ok") {
              Swal.fire({
                title: "Estado modificado",
                text: "El estado del producto ha sido cambiado a 'Activo' exitosamente.",
                confirmButtonColor: "#0686ab",
                icon: "success"
              }).then(() => {
                location.reload(); // Recargar la pantalla
              });
            } else {
              Swal.fire({
                title: "¡Error!",
                text: res,
                confirmButtonColor: "#0686ab",
                icon: "error"
              });
            }
          }
        }
      }
    });

}
/*********************** FIN PRODUCTOS ***********************/ 

/*********************** INICIO DE ROLES ***********************/ 

function frmRoles(){
  document.getElementById("title").innerHTML = "Nuevo Rol";
  document.getElementById("btnModificar").innerHTML = "Registrar";
  //document.getElementById("frmRoles").reset();
  $("#nuevo_rol").modal("show");
  document.getElementById("id").value = "";
}

function registrarRol(e){

  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const descripcion = document.getElementById("descripcion");
  if(nombre.value == "" || descripcion.value == ""){

      Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Los campos 'Nombre' y 'Descripcion' son obligatorios para completar el registro",
          showConfirmButton: false,
          timer: 3000
        });
      
  }else{
      const url = base_url + "Roles_Permisos/registrar";
      const frm = document.getElementById("frmMedida");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function(){
          if (this.readyState== 4 && this.status == 200) {
              const res = JSON.parse(this.responseText);
              if (res == "si") {
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Rol Agregado Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(() => {
                      // Recargar la página después de cerrar la alerta
                      window.location.reload();
                  });
                    frm.reset();
                    $("#nuevo_rol").modal("hide");
              }else if(res == "modificado"){
                  Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Rol Modificado Correctamente",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(() => {
                      // Recargar la página después de cerrar la alerta
                      window.location.reload();
                  });
                  $("#nuevo_rol").modal("hide");
              }else{
                  Swal.fire({
                      position: "top-end",
                      icon: "error",
                      title: res,
                      showConfirmButton: false,
                      timer: 3000
                    });
              }
          }

      }
  }


}

function btnEditarRol(id){
  document.getElementById("title").innerHTML = "Actualizar Roles";
  document.getElementById("btnModificar").innerHTML = "Modificar";
  const url = base_url + "Roles_Permisos/editar/"+id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function(){
      if (this.readyState== 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          document.getElementById("id").value = res.id_rol;
          document.getElementById("nombre").value = res.nombre_rol;
          document.getElementById("descripcion").value = res.descripcion_rol;
          $("#nuevo_rol").modal("show");
      }

  }
  

}

function btnEliminarRol(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de este Rol?",
      text: "Esta acción no eliminará el Rol, únicamente cambiará su estado a 'Inactivo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Roles_Permisos/eliminar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
              const res = JSON.parse(this.responseText);
            if (res == "ok") {
              Swal.fire({
                  title: "Estado modificado",
                  text: "El estado del Rol ha sido cambiado a 'Inactivo' exitosamente.",
                  confirmButtonColor: "#0686ab",
                  icon: "success"
                }).then(() => {
                  location.reload(); // Recargar la pantalla
                });
            }else{

              Swal.fire({
                  title: "!Mensaje¡",
                  text: res,
                  confirmButtonColor: "#0686ab",
                  icon: "error"
                });
                
            }
    
          }
        }
      }
    });



}

function btnReingresarRol(id){

  Swal.fire({
      title: "¿Está seguro de que desea modificar el estado de este Rol?",
      text: "Esta acción activará el Rol y cambiará su estado a 'Activo'.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#42ab06",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `${base_url}Roles_Permisos/reingresar/${id}`;
        const http = new XMLHttpRequest();
    
        http.open("GET", url, true);
        http.send();
    
        http.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            const res = JSON.parse(this.responseText);
            if (res === "ok") {
              Swal.fire({
                title: "Estado modificado",
                text: "El estado del Rol ha sido cambiado a 'Activo' exitosamente.",
                confirmButtonColor: "#0686ab",
                icon: "success"
              }).then(() => {
                location.reload(); // Recargar la pantalla
              });
            } else {
              Swal.fire({
                title: "¡Error!",
                text: res,
                confirmButtonColor: "#0686ab",
                icon: "error"
              });
            }
          }
        };
      }
    });

}

/*********************** FIN DE ROLES ***********************/ 

/*********************** INICIO IMAGENES ***********************/ 

function preview(e){
  const url = e.target.files[0];
  const urltmp = URL.createObjectURL(url);
  document.getElementById("img-preview").src = urltmp;
  document.getElementById("icon-image").classList.add("d-none");
  document.getElementById("icon-cerrar").innerHTML = `
  <button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-times"></i></button>
  ${url['name']}`;
}

function deleteImg(){
  document.getElementById("icon-cerrar").innerHTML = '';
  document.getElementById("icon-image").classList.remove("d-none");
  document.getElementById("img-preview").src = '';
  document.getElementById("imagen").value='';
  document.getElementById("foto_actual").value='';
}

/*********************** FIN IMAGENES ***********************/ 

/*********************** INICIO BUSCAR CODIGO COMPRAS ***********************/ 

function buscarCodigo(e) {
  e.preventDefault();
  const cod = document.getElementById("codigo").value;
  if (cod !== '') {
    if (e.which == 13) {
      const url = base_url + "Compras/buscarCodigo/" + cod;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          try {
            const res = JSON.parse(this.responseText);
            if (res && res.length > 0) {
              // Producto encontrado

              document.getElementById("nombre").value = res[0].pro_descripcion;
              document.getElementById("precio").value = res[0].pro_precio_compra;
              document.getElementById("medida").value = res[0].med_nombre;
              document.getElementById("id").value = res[0].pro_id;
              document.getElementById("cantidad").removeAttribute('disabled');
              document.getElementById("cantidad").focus();
            } else {
              // Producto no encontrado
              throw new Error("Producto no encontrado");
            }
          } catch (error) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: "El producto no existe",
              showConfirmButton: false,
              timer: 1500
            });
            document.getElementById("codigo").value = '';
            document.getElementById("codigo").focus();
          }
        }
      };
    }
  } else {
    Swal.fire({
      position: "top-end",
      icon: "warning",
      title: "Por favor, ingrese un código",
      showConfirmButton: false,
      timer: 1500
    });
  }
}

function calcularPrecio(e){ //calculo de los kilos y gramos 
  e.preventDefault();
  const cant = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;
  const medida = document.getElementById("medida").value;
  document.getElementById("sub_total").value = precio * cant;
  if (e.which == 13) {
    if (cant > 0) {
      const url = base_url + "Compras/ingresar/";
      const frm = document.getElementById("frmCompra");
      const http = new XMLHttpRequest();
      const cantidad = parseFloat(document.getElementById('cantidad').value);

      // Separar kilos y gramos
      const kilos = Math.floor(cantidad); //Math.floor() extrae la parte entera (kilos)
      const gramos = ((cantidad - kilos) * 1000).toFixed(0);  // Convertir la parte decimal a gramos
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          console.log(this.responseText);
      
          const res = JSON.parse(this.responseText);
         if (res == "ok") {
          frm.reset();
          let alertText = ""; // Variable para el texto de la alerta
          // Validación para determinar el texto de la alerta
          if (medida.toLowerCase() == "kilos") {
              alertText = `Se han agregado ${kilos} kilos y ${gramos} gramos.`;
          }
          Swal.fire({
            title: "Producto Ingresado",
            text: alertText,
            confirmButtonColor: "#0686ab",
            icon: "success",
            timer: 1800
          }).then(() => {
            location.reload(); // Recargar la pantalla
          });
         } else if(res == "modificado"){
          Swal.fire({
            title: "Producto Actualizado",
            confirmButtonColor: "#0686ab",
            icon: "success",
            timer: 1800
          }).then(() => {
            location.reload(); // Recargar la pantalla
          });
          frm.reset();
         }
         document.getElementById('cantidad').setAttribute('disabled' , 'disabled');
         document.getElementById('codigo').focus;
        }
      }
    }
  }

}

if (document.getElementById('tblDetalle')) {
  cargardetalle();
}


function cargardetalle(e){
      const url = base_url + "Compras/listar/";
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          const res = JSON.parse(this.responseText);
          let html = '';
          res.detalle.forEach(row => { //El forEach recorre cada objeto del arreglo y genera el contenido de la tabla 
            html += `<tr>
              <td>${row['det_id']}</td>
              <td>${row['pro_descripcion']}</td>
              <td>${row['det_cantidad']}</td>
              <td>${row['det_precio']}</td>
              <td>${row['det_subtotal']}</td>
              <td>
              <button class="btn btn-danger" type="button" onclick="deleteDetalle(${row['det_id']})"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>`;
          });
          document.getElementById("tblDetalle").innerHTML = html;
          document.getElementById("total").value = res.total_pagar.total;
        }
      }
  

}

function deleteDetalle(id){
  const url = base_url + "Compras/delete/"+id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      if (res == "ok") {
        Swal.fire({
            title: "Producto Eliminado",
            text: "El producto ha sido eliminado exitosamente.",
            confirmButtonColor: "#0686ab",
            icon: "success",
            timer: 1200
          }).then(() => {
            location.reload(); // Recargar la pantalla
          });
      }else{
        Swal.fire({
            title: "!Mensaje¡",
            text: res,
            confirmButtonColor: "#0686ab",
            icon: "error",
            timer: 1200
          });
          
      }
    }
  }

}

function generarCompra(){
  Swal.fire({
    title: "¿Está seguro de que desea realizar esta compra?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#42ab06",
    cancelButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url+ "Compras/registararCompra/";
      const http = new XMLHttpRequest();


      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
         //console.log(this.responseText);
         try {
          const res = JSON.parse(this.responseText);
          if (res.msg === "ok") {
            Swal.fire({
              title: "Compra Generada",
              confirmButtonColor: "#0686ab",
              icon: "success"
            }).then(() => {
              location.reload(); // Recargar la pantalla
            });
            const ruta = base_url + 'Compras/generarPdf/' + res.id_compra;
            window.open(ruta);
          } else {
            Swal.fire({
              title: "¡Error!",
              text: res,
              confirmButtonColor: "#0686ab",
              icon: "error"
            });
          }
        } catch (error) {
          // Manejar errores de parseo de JSON
          Swal.fire({
            title: "Por favor, ingrese un valor numérico válido para la cantidad",
            confirmButtonColor: "#0686ab",
            icon: "warning"
          });
          console.error("Error al parsear JSON:", error);
        }
        }
      }
    }
  });

}

/*********************** FIN BUSCAR CODIGO COMPRAS***********************/ 

/*********************** INICIO BUSCAR CODIGO ***********************/ 

function buscarCodigoVenta(e) {
  e.preventDefault();
  const cod = document.getElementById("codigo").value;
  if (cod !== '') {
    if (e.which == 13) {
      const url = base_url + "Ventas/buscarCodigo/" + cod;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          try {
            const res = JSON.parse(this.responseText);
            if (res && res.length > 0) {
              // Producto encontrado
              console.log(this.responseText);
              document.getElementById("nombre").value = res[0].pro_descripcion;
              document.getElementById("precio").value = res[0].pro_precio_venta;
              document.getElementById("medida").value = res[0].med_nombre;
              document.getElementById("id").value = res[0].pro_id;
              document.getElementById("cantidad").removeAttribute('disabled');
              document.getElementById("cantidad").focus();
            } else {
              // Producto no encontrado
              throw new Error("Producto no encontrado");
            }
          } catch (error) {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: "El producto no existe",
              showConfirmButton: false,
              timer: 1500
            });
            document.getElementById("codigo").value = '';
            document.getElementById("codigo").focus();
          }
        }
      };
    }
  } else {
    Swal.fire({
      position: "top-end",
      icon: "warning",
      title: "Por favor, ingrese un código",
      showConfirmButton: false,
      timer: 1500
    });
  }
}

function calcularPrecioVenta(e) { // Cálculo de los kilos y gramos
  e.preventDefault();
  const cant = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;
  const medida = document.getElementById("medida").value;
  document.getElementById("sub_total").value = precio * cant;

  if (e.which == 13) {
    if (cant > 0) {
      const url = base_url + "Ventas/ingresar/";
      const frm = document.getElementById("frmVenta");
      const http = new XMLHttpRequest();
      const cantidad = parseFloat(document.getElementById('cantidad').value);

      // Separar kilos y gramos
      const kilos = Math.floor(cantidad); // Extraer la parte entera (kilos)
      const gramos = ((cantidad - kilos) * 1000).toFixed(0); // Convertir la parte decimal a gramos

      http.open("POST", url, true);
      http.send(new FormData(frm));

      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          const res = JSON.parse(this.responseText);
          console.log(this.responseText);
          if (res == "ok") {
            frm.reset();
            let alertText = ""; // Variable para el texto de la alerta
            // Validación para determinar el texto de la alerta
            if (medida.toLowerCase() == "kilos") {
              alertText = `Se han agregado ${kilos} kilos y ${gramos} gramos.`;
            }
            Swal.fire({
              title: "Producto Ingresado",
              text: alertText,
              confirmButtonColor: "#0686ab",
              icon: "success",
              timer: 1800
            }).then(() => {
              location.reload(); // Recargar la pantalla
            });

          } else if (res == "modificado") {
            Swal.fire({
              title: "Producto Actualizado",
              confirmButtonColor: "#0686ab",
              icon: "success",
              timer: 1800
            }).then(() => {
              location.reload(); // Recargar la pantalla
            });
            frm.reset();

          } else if (res == "stock0") {
            // Mensaje de error cuando no hay stock disponible
            Swal.fire({
              title: "Stock No Disponible",
              text: "No hay suficiente stock para este producto.",
              confirmButtonColor: "#d33",
              icon: "warning",
              timer: 1800
            });
          }

          document.getElementById('cantidad').setAttribute('disabled', 'disabled');
          document.getElementById('codigo').focus;
        }
      };
    }
  }
}


if (document.getElementById('tblDetalleVenta')) {
  cargardetalleVenta();
}


function cargardetalleVenta(e){
      const url = base_url + "Ventas/listar/";
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          const res = JSON.parse(this.responseText);
          let html = '';
          res.detalle.forEach(row => { //El forEach recorre cada objeto del arreglo y genera el contenido de la tabla 
            html += `<tr>
              <td>${row['det_id']}</td>
              <td>${row['pro_descripcion']}</td>
              <td>${row['det_cantidad']}</td>
              <td><input class="form-control" placeholder="Descuento" type="text" onkeyup="calcularDescuento(event, ${row['det_id']})"></td>
              <td>${row['det_descuento']}</td>
              <td>${row['det_precio']}</td>
              <td>${row['det_subtotal']}</td>
              <td>
              <button class="btn btn-danger" type="button" onclick="deleteDetalleVenta(${row['det_id']})"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>`;
          });
          document.getElementById("tblDetalleVenta").innerHTML = html;
          document.getElementById("total").value = res.total_pagar.total;
        }
      }
  

}

function calcularDescuento(e, id){
  e.preventDefault();
  if (e.target.value=='') {
    Swal.fire({
      title: "Ingrese el descuento",
      confirmButtonColor: "#0686ab",
      icon: "warning",
      timer: 1200
    })
  }else{
    if (e.which == 13) {
      const url = base_url + "Ventas/calcularDescuento/" + id + "/" + e.target.value;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          console.log(this.responseText);
          //const res = JSON.parse(this.responseText);
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
                title: "Descuento Aplicado",
                text: "El descuento del procucto se aplico exitosamente.",
                confirmButtonColor: "#0686ab",
                icon: "success",
                timer: 1200
              }).then(() => {
                location.reload(); // Recargar la pantalla
              });
          }else{

            Swal.fire({
                title: "!Mensaje¡",
                text: res,
                confirmButtonColor: "#0686ab",
                icon: "error"
              });
              
          }

        }
      }
    }
  }
 


}

function deleteDetalleVenta(id){
  const url = base_url + "Ventas/delete/"+id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      const res = JSON.parse(this.responseText);
      if (res == "ok") {
        Swal.fire({
            title: "Producto Eliminado",
            text: "El producto ha sido eliminado exitosamente.",
            confirmButtonColor: "#0686ab",
            icon: "success",
            timer: 1200
          }).then(() => {
            location.reload(); // Recargar la pantalla
          });
      }else{
        Swal.fire({
            title: "!Mensaje¡",
            text: res,
            confirmButtonColor: "#0686ab",
            icon: "error",
            timer: 1200
          });
          
      }
    }
  }

}

function generarVenta(){
  Swal.fire({
    title: "¿Está seguro de que desea realizar esta venta?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#42ab06",
    cancelButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url+ "Ventas/registararVenta/";
      const http = new XMLHttpRequest();


      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
         console.log(this.responseText);
         try {
          const res = JSON.parse(this.responseText);
          if (res.msg === "ok") {
            Swal.fire({
              title: "Venta Generada",
              confirmButtonColor: "#0686ab",
              icon: "success"
            }).then(() => {
              location.reload(); // Recargar la pantalla
            });
            const ruta = base_url + 'Ventas/generarPdf/' + res.id_venta;
            window.open(ruta);
          } else {
            Swal.fire({
              title: "¡Error!",
              text: res,
              confirmButtonColor: "#0686ab",
              icon: "error"
            });
          }
        } catch (error) {
          // Manejar errores de parseo de JSON
          Swal.fire({
            title: "Por favor, ingrese un valor numérico válido para la cantidad",
            confirmButtonColor: "#0686ab",
            icon: "warning"
          });
          console.error("Error al parsear JSON:", error);
        }
        }
      }
    }
  });

}

/*********************** FIN BUSCAR CODIGO VENTAS ***********************/ 

/*********************** INICIO MODIFICAR EMPRESA ***********************/ 

function modificarEmpresa(){
 
  const frm = document.getElementById('frmEmpresa');
  const url = base_url+ "Administracion/modificar/";
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      const res = JSON.parse(this.responseText);
      if (res == "ok") {
        Swal.fire({
            title: "Empresa Modificada",
            text: "Los datos de la empresa fueron mofificados de manera correcta.",
            confirmButtonColor: "#0686ab",
            icon: "success"
          }).then(() => {
            location.reload(); // Recargar la pantalla
          });
      }else{
        Swal.fire({
            title: "!Mensaje¡",
            text: res,
            confirmButtonColor: "#0686ab",
            icon: "error"
          });
          
      }
    }
  }

}

/*********************** FIN MODIFICAR EMPRESA ***********************/ 


/*********************** INICIO ROLES Y PERMISOS ***********************/ 

function registrarPermisos(e){
  e.preventDefault();
  const url = base_url+ "Roles_Permisos/registrarPermiso";
  const frm = document.getElementById('formulario');
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      const res = JSON.parse(this.responseText);
      if (res != '') {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Permiso Agregado Correctamente",
          showConfirmButton: false,
          timer: 2000
        }).then(() => {
          // Redirigir al controlador después de la alerta
          window.location.href = base_url + "Roles_Permisos";
      });
      }else{
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error no Identificado",
          showConfirmButton: false,
          timer: 2000
        }).then(() => {
          // Recargar la página después de cerrar la alerta
          window.location.reload();
      });



      }
    }
  }

}

/*********************** FIN ROLES Y PERMISOS ***********************/ 

window.addEventListener("beforeunload", function (event) {
  navigator.sendBeacon(base_url + "Usuario/cerrarSesion"); // Llamada AJAX silenciosa
});