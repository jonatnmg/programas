/*
 * SISTEMA DE INFORMACION PARA APOYO DE PROCESOS ADMINISTRATIVOS - SISPROAD
 * VERSION: 1.0
 * FECHA CREACION: 09 SEPTIEMBRE 2018
 * FECHA ULTIMA MODIFICACIÓN: 20 SEPTIEMBRE 2018
 * CREADO POR: JONATHAN MUÑOZ GONZALEZ
 * EMAIL: DAVIDSANSONII@HOTMAIL.COM - JONATN@JONATHANMUNOZ.COM.CO
 * SINTÉSIS ARCHIVO: JS, ADMINISTRADOR PARA CREACION, MODIFICACION, ELIMINACION Y LISTAD DE TIPOS DE ASIGNACION
 * TODOS LOS DERECHOS SON RESERVADOS (ALGUNOS SURDOS IGUAL)    
*/

$(document).ready(function()
{
   //FOCUS PRIMER INPUT
    $("#name").focus();
       
   //TABLE 
    mostrar_table();
        
    //CARGAR INICIO
    listar();
   
   //ASIGNAR EVENTO AL BOTON LISTA
    $("#lista").click(function()
    {
        listar();
    });    
    
    cancel();
    
    //FORMULARIO Y VALIDADOR
    $("#formulario").validate({	
        submitHandler: function(forma) 
        {
            var datos = $("#formulario").serialize();
            var idEnviado = $("#idEnviado").val();
            var iud = $("#iud").val();
                $.ajax
                ({  
                    url:        'guardar',  //@routing => Web\TipodeasignacionBundle\Resources\config\routing.yml  - tipo_asignacion_guardar:
                    type:       'POST',   
                    data:       datos+'&iud='+iud+"&idEnviado="+idEnviado,  //i = inset, u = update, d = delete ; 1 -> Nuevo, 2 -> Modificar, 3 -> Eliminar
                    async:      true, 
                    success: function(info) 
                    {               
                        alert(info[0].msg);
                        mostrar_table();
                    },  
                    error : function(xhr, textStatus, errorThrown) {  
                        alert('Error Ajax!');
                        mostrar_table();
                    }  
                }); 
             return false;
        }	
    });  
    
});

//FUNCIONES
var obtener_data_editar = function(tbody, table)
{
    $(tbody).on("click","button.editar",function()
    {
        limpiar_datos();
        var data = table.row($(this).parents("tr")).data();
        var nombre = $("#name").val(data.nombre);
        var desc = $("#desc").val(data.descripcion);
        
        if ( data.estado == "Activo" )
        {
            $("#estado").val(1);
        }
        else
        {
           $("#estado").val(0); 
        }
        
        $("#idEnviado").val(data.id);
        //console.log(data);
        editar();        
    });
}

var obtener_data_elminar = function (tbody, table)
{
    $(tbody).on("click","button.eliminar",function()
    {
        limpiar_datos();
        var data = table.row($(this).parents("tr")).data();
        var nombre2 = $("#MensajeEliminar").html("¿Está seguro de eliminar el registro "+data.nombre+" ?");
        var idEliminar = $("#idEliminar").val(data.id);
        
    });
}

function eliminar_data()
{
    var idEliminar = $("#idEliminar").val();

    $.ajax
        ({  
            url:        'eliminar',  //@routing => Web\TipodeasignacionBundle\Resources\config\routing.yml  - tipo_asignacion_guardar:
            type:       'POST',   
            data:       "idEnviado="+idEliminar+'&iud='+2,  //i = inset, u = update, d = delete ; 0 -> Nuevo, 1 -> Modificar, 2 -> Eliminar
            async:      true, 
            success: function(info) 
            {               
                alert(info[0].msg);
                mostrar_table();
            },  
            error : function(xhr, textStatus, errorThrown) {  
                  alert('Error Ajax!'); 
                  mostrar_table();
            }  
        }); 
  return false;
}

var nuevo = function ()
{
    limpiar_datos();
    $("#conetendor-formulario").slideDown("slow");
    $("#contenedor-tabla").slideUp("slow");
    $("#name").focus(); 
    $("#estado").val(1);
}

var editar = function ()
{
    $("#conetendor-formulario").slideDown("slow");
    $("#contenedor-tabla").slideUp("slow");
    $("#name").focus();
    $("#iud").val(1);
}

var limpiar_datos = function ()
{   
    $("#name").val("");
    $("#desc").val("");
    $("#iud").val(0);
    $("#idEnviado").val(0);
}

var listar = function ()
{
    limpiar_datos();
    $("#contenedor-tabla").slideDown("slow");
    $("#conetendor-formulario").slideUp("slow");
    //mostrar_table();
}

var cancel = function ()
{
    $("#cancel").on("click" , function() {
       limpiar_datos();      
    });
}
var mostrar_table = function ()
   {
    var table = $('#datatable1').DataTable( {
         "processing": true,
         "serverSide": true,
         "destroy": true,
         
         "ajax": {
            "method": "POST",
            "url": "todotipoasignacion",           
        },
         "columns": [
             { "data": "nombre" },
             { "data": "estado"},
             
             { "defaultContent" : "<button id='editar' id='editar' type='button' class='editar btn btn-round btn-default fa fa-edit'></button> \n\
                                   <button id='eliminar' id='eliminar' type='button' class='eliminar btn btn-round btn-default fa fa-archive' data-toggle='modal' data-target='.bs-example-modal-lg'></button> "},
         ],
        "language": idioma_espanol, 
         "dom": '<"top"lBf> rt <"bottom"p> ',
         "buttons": [
             {
                 "text": "<i class='fa fa-file'></i>",
                 "titleAttr": "Nuevo",
                 "className": "btn btn-default",
                 "action": function ()
                 {
                     nuevo();
                 }
             },
             {
                 extend: "excelHtml5",
                 text: "<i class='fa fa-file-excel-o'></i>",
                 titleAttr: "Excel"
             },
             {
                 extend: "csvHtml5",
                 text: "<i class='fa fa-file-text-o'></i>",
                 titleAttr: "CSV"
             },
             {
                 extend: "pdfHtml5",
                 text: "<i class='fa fa-file-pdf-o'></i>",
                 titleAttr: "PDF"
             }
         ]        
     }); 
     
     //ASIGNAR FUNCIONES
 obtener_data_editar("#datatable1 tbody", table);
 obtener_data_elminar("#datatable1 tbody", table);

}
