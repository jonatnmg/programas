$(document).ready(function()
{
   document.getElementById("name").focus();
    
    var oTable = $('#normal').dataTable();
    oTable.paginate(true);
    oTable.sort(true);
   
/* expande filas con información
    var oTable;		 
    // 'open' an information row when a row is clicked on
   $('#normal tbody tr').click( function () {
      if ( oTable.fnIsOpen(this) ) {
        oTable.fnClose( this );
      } else {
        oTable.fnOpen( this, "Temporalmente abierto", "info_row" );
      }
   } );

   oTable = $('#normal').dataTable();
   
   */
  
  /* Eliminar fila
  var oTable = $('#normal').dataTable();
    oTable.fnDeleteRow( 0 );
    
    */
  
 /*   Filtro activo en la tabla
  var oTable = $('#normal').dataTable();
   oTable.fnFilter( 'test string' );
   */
  
 /*Mostrar valor celda seleccionada  
  oTable = $('#normal').dataTable();
    oTable.$('td').click( function () {
      var sData = oTable.fnGetData( this );
       alert( 'Celda seleccionada '+sData );
    } );
*/
  
 /*Al pulsar doble click puedo editar la celda
  *  $('#normal tbody td').click( function () {
		         // Get the position of the current data from the node
		         var aPos = oTable.fnGetPosition( this );
		
		         // Get the data array for this row
		        var aData = oTable.fnGetData( aPos[0] );
                        var sData = oTable.fnGetData( this );
                        
		        // Update the data array and return the value
		        //aData[ aPos[1] ] = sData;
		        this.innerHTML = '<input type="text" value="'+sData+'" class="form-control col-md-7 col-xs-12"/>';
		      } );
		 
		       // Init DataTables
oTable = $('#normal').dataTable();*/
         
//Sortea una columna
//  oTable.fnSort( [ [0,'asc'], [1,'asc'] ] );         
  
 //oTable.fnClearTable();
  
    $("#formulario").validate({	
        submitHandler: function(forma) 
        {
            var datos = $("#formulario").serialize();
                $.ajax
                ({  
                    url:        'guardar',  
                    type:       'POST',   
                    data:       datos+'&iud='+1,  
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
