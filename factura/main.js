$(document).ready(function () {
// agregar concepto  

$('#agregar_concepto').on('submit',function(e) {
   e.preventDefault();
   var concepto, precio_uni, cantidad; 
    
   concepto =  $('#concepto').val();
   precio_uni =  $('#precio_uni').val();
   cantidad =  $('#cantidad').val();
   action =   'add_pro'; 
   
   $.ajax({
       url: 'app/ajax.php',
       type:'POST',
       dataType: 'JSON',
       data: {
           concepto,
           precio_uni,
           cantidad,
           action
       },
       beforeSend: function() {
           alert('cargando');
       } 

     })
     .done(function(res) { 
         if (res.status === 200) { 

        } else { 
            $('#agregar_concepto').trigger('reset');

             cargar_productos();
         }
     })
     .always(function() {
         
     })
     .fail(function(err) {
        alert('error fail()...');
     });
}); 


// cargar concepto 
   function cargar_productos() { 
    var cotizar = $('#cotizacion'),
       action = 'cargar_pro';
    $.ajax({
        url: 'app/ajax.php',
        type:'POST',
        dataType: 'JSON',
        data: {
            action
        },
        beforeSend: function() { 

        }  
        
      })
      .done(function(res) { 
          if (res.status === 200) {
              cotizar.html(res.data);
          } else {
              alert(res.msg);
          }
      })
      .always(function() {
          
      })
      .fail(function(err) {
         alert('hubo un error al cargar productos');
      }); 

   }
   cargar_productos();
// borrar concepto
 $('body').on('click', '.delete_pro', function(e) {
     alert("hello word");
 });

// editar concepto  


// cargar concepto individual  
 
 


});  

