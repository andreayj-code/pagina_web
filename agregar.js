  
  var tabla = document.getElementById('cuerpoTabla');  
  var items = [];  
       
 
  
   
  function agregar(carrito) {  
  
  var id =  $("#id"    + carrito).val();       
  var nombre = $("#nombre"  + carrito).val();       
  var precio = $("#precio"  + carrito).val();       
  var stock = parseInt($("#stock"  + carrito).val());       
  var cantidad  = $("#cantidad"  + carrito).val();       
   
  
  var subtotal = parseFloat(precio) * parseFloat(cantidad); 
   
   

   
   console.log(total);

      
  

    if (cantidad == '') { 
      alert("ingrese un numero");
    } else if (cantidad > stock ) { 
     alert("producto agotado");
    
    }else{
      json_carrito = {
        "id" : id,
        "nombre" : nombre,
        "precio" : precio,
        "stock" : stock,
        "cantidad" : cantidad,
        "subtotal" : subtotal
       
     }   
     
     items.push(json_carrito);

     console.log(items);  
       
      
     cargarTabla();  
      
     
   
    } 
 
   
    
   
   
  
  
  
   
  

  }
   
  



function cargarTabla() { 
 tabla.innerHTML = ('<th>id</th><th>nombre</th><th>precio</th><th>stock actual</th><th>cantidad</th><th>subtotoal</th><th>eliminar</th>');
 var total = document.getElementById('total'); 
 var acc = document.getElementById('acc');
 var suma = 0;  
 var cont = 0;

 for (var i = 0; i < items.length; i++) {
   var elemento = document.createElement('tr'); 
  
   elemento.innerHTML += ("<td>"+items[i].id+"</td>");
   elemento.innerHTML += ("<td>"+items[i].nombre+"</td>");
   elemento.innerHTML += ("<td>"+items[i].precio+"</td>");
   elemento.innerHTML += ("<td>"+items[i].stock+"</td>");
   elemento.innerHTML += ("<td>"+items[i].cantidad+"</td>");
   elemento.innerHTML += ("<td>"+items[i].subtotal+"</td>");
   elemento.innerHTML += ("<a href='#' class='btn btn-danger'>"+"eliminar"+"</a>");
   
    suma =  parseFloat(suma) + items[i].subtotal; 
    
    //acumulador de cantidad
    cont = items[i].cantidad++;

    tabla.appendChild(elemento);
   
 }  
 
  
    total.innerText = "$"+parseFloat(suma) ; 
    acc.innerText = +cont;
  
  
   
 

} 







  

  