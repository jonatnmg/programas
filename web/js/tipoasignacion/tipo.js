/*
 * SISTEMA DE INFORMACION PARA APOYO DE PROCESOS ADMINISTRATIVOS - SISPROAD
 * VERSION: 1.0
 * FECHA CREACION: 09 SEPTIEMBRE 2018
 * CREADO POR: JONATHAN MUÑOZ GONZALEZ
 * EMAIL: DAVIDSANSONII@HOTMAIL.COM - JONATN@JONATHANMUNOZ.COM.CO
 * SINTÉSIS ARCHIVO: JS, ADMINISTRADOR PARA CREACION, MODIFICACION, ELIMINACION Y LISTAD DE TIPOS DE ASIGNACION
 * TODOS LOS DERECHOS SON RESERVADOS (ALGUNDOS SURDOS IGUAL)    
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
    
    //FORMULARIO Y VALIDADOR
    $("#formulario").validate({	
        submitHandler: function(forma) 
        {
            var datos = $("#formulario").serialize();
                $.ajax
                ({  
                    url:        'guardar',  //@routing => Web\TipodeasignacionBundle\Resources\config\routing.yml  - tipo_asignacion_guardar:
                    type:       'POST',   
                    data:       datos+'&iud='+1,  //i = inset, u = update, d = delete
                    async:      true, 
                    success: function(data) 
                    {               
                        alert(data[0].msg); 		        
                    },  
                    error : function(xhr, textStatus, errorThrown) {  
                          alert('Error Ajax!'); 
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
        var data = table.row($(this).parents("tr")).data();
        //console.log(data);
        nuevo();
        
    });
}

var nuevo = function ()
{
    limpiar_datos();
    $("#conetendor-formulario").slideDown("slow");
    $("#contenedor-tabla").slideUp("slow");
    $("#name").focus();
}

var limpiar_datos = function ()
{   
    $("#name").val("");
    $("#desc").val("");    
}

var listar = function ()
{
    limpiar_datos();
    $("#contenedor-tabla").slideDown("slow");
    $("#conetendor-formulario").slideUp("slow");    
}

var mostrar_table = function ()
   {
    var table = $('#normal').DataTable( {
         "processing": true,
         "serverSide": true,
         "destroy": true,
         "scrollx": true,
         "scrolly": true,
         "ajax": {
            "method": "POST",
            "url": "todotipoasignacion",
            "dataType": "json"
        },
         "columns": [
             { "data": "nombre" },
             { "data": "estado"},
             { "defaultContent" : "<button id='editar' id='editar' type='button' class='editar btn btn-round btn-default fa fa-edit'></button> \n\
                                   <button id='eliminar' id='eliminar' type='button' class='eliminar btn btn-round btn-default fa fa-archive'></button> "},
         ],
         "dom": '<"top"Bf> rt <"bottom"lp><"clear"> ',
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
 obtener_data_editar("#normal tbody", table);    
 
$('#myInput').on( 'keyup', function () {
    table.search( this.value ).draw();
} );
}