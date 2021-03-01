<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="alertifyjs/css/alertify.css">
    <link rel="stylesheet" href="alertifyjs/css/themes/default.css">
    <script  type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script> 
    <script src="alertifyjs/alertify.js"></script>
 
    
    <script>   
  $(document).ready(function(){
     $('#mitabla').DataTable({

     });
    
  });

</script>
     
<script>
  $(document).ready(function() {
    $("#enviar").click(function () { 
     
     var libras = $("#libra").val();
     var gramos = $("#gramos").val();

     $.post("peso.php", {libra:libras,gramos:gramos}, function(data){
					$("#resultado").html(data);
        });

      
    });

  });

</script>
 







    
  </head>


  <body> 

   
      
     
  


    <h1> listado de productos</h1>  
          
         <div>
         <a href="cotizar.php"><button class="btn btn-primary">COTIZACION</button></a> 
         <a href="reporte.php"><button class="btn btn-primary">INFORME VENTA</button></a> 
         <a href="pdf1.php"><button class="btn btn-primary">DETALLE VENTA</button></a> 
         </div> 
  
   <div>
    
   <br>
    <label> precio libra</label> <input type="text" name="libra" id="libra" required> </br>  
   <br> 
    <label>gramos</label> <input type="text" name="gramos" id="gramos" required> </br> 
 
 
    
    <input type="submit" name="calcular" value="calcular"  id="enviar"> 
     
    <div id="resultado"></div>


    
    </div>
   
   
   
 </body> 
 

 

    <table border="1" class="table table-striped" id="mitabla"></br> 

          
        <thead>
          <th>ID</th> 
          <th>nombre</th> 
          <th>precio</th>
          <th>stock</th>
          <th>añadir a venta</th>  
          


          </thead>
      

      <?php
      
      require_once "model/data.php"; 
    

      

      error_reporting(0);

      $d = new Data();


      $productos = $d ->getProductos();

      $cont = 0;
      foreach ($productos as $p ) {
        echo "<tr>";
              echo "<td>.$p->id.</td>";
              echo "<td>.$p->nombre.</td>";
              echo "<td>.$p->precio.</td>";
              echo "<td>.$p->stock.</td>";

                  echo "<td>";
                  echo "<form  method='POST' id='formulario'>";
                      echo "<input type='hidden' name='txtID_". $cont ."'      id='id_" . $cont . "' value='".$p->id."'>";
                      echo "<input type='hidden' name='txtnombre_" . $cont ."'   id='nombre__" . $cont . "'   value='".$p->nombre."'>";
                      echo "<input type='hidden' name='txtprecio_" . $cont ."'   id='precio_" . $cont . "'  value='".$p->precio."'>";
                      echo "<input type='hidden' name='txtstock_". $cont ."'       id='stock_" . $cont . "'  value='".$p->stock."'>";
                      echo "<input type='number' name='txtcantidad_". $cont ."'     id='cantidad_" . $cont . "'  required='required'  step='0.1'>";
                      echo "<button  id='btnAgregar_" . $cont . "' onclick='agregar(" . $cont . ")' type='button' class='btn btn-primary'> Añadir </button>";
                      echo "<a href=''><input type='button' name='btneditar' id='' value='editar' ></a>";
                  echo "</form>"; 
				
                  
              echo "</td>";
        echo "</tr>";
        $cont++;
      }


       ?>



    </table>

<a href="vista/ventas.php">listado de ventas</a>
     <?php
        if (isset($_GET["m"])) {
          $m = $_GET["m"];
          switch ($m) {
            case "1":
            echo "<script>
                       alert('el producto esta agotado');
                       window.location= 'index.php'
           </script>";
              break;
              case "2":
              echo "<script>
                         alert('el producto esta agotado');
                         window.location= 'index.php'
             </script>";
                break;

          }
        }

        
     
        


      ?>
     
     <h1>listado de compra</h1> 
<div>
     <table class="table table-dark">
       
     <tr>
       <th>id</th>
       <th>nombre</th>
       <th>precio</th>
       <th>stock actual</th>
       <th>cantidad</th>
       <th>subtotoal</th>
       <th>eliminar</th>
     </tr> 
     <tbody id="cuerpoTabla" >
		
     </tbody>
     </table>  

</div> 

 
<button class="btn btn-primary" onclick="crearventa()" >Comprar</button>


 <script type="text/javascript">
	var items = [];			// Guarda todos los items que se van a agregando al carrito
	/* ..:: MÉTODO AGERGAR ITEMS ::..*/
	function agregar(num_item){
		var item_id = $("#id_" + num_item).val();
		var item_nombre = $("#nombre__" + num_item).val();
		var precio = $("#precio_" + num_item).val();
		var stock = parseInt($("#stock_" + num_item).val());
		var cantidad = $("#cantidad_" + num_item).val();
			
		var subtotal = parseFloat(precio) * parseFloat(cantidad);
 
    
    if (cantidad === '') { 
      alert("ingrese un numero");
    } else if (cantidad > stock ) { 
     alert("producto agotado");
    
    }else{
      json_carrito = {
        "id" : item_id,
        "nombre" : item_nombre,
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

	/* ..:: MÉTODO CARGAR TABLA ::..*/
	function cargarTabla(){
	  $("#cuerpoTabla").empty();		//Limpiamos la tabla para cargarla de nuevo
	  var cuerpoTabla;
	  
	  for(var i=0;i<items.length;i++){
		cuerpoTabla = "<tr>"+
		  "<td class='text-center'>"+ items[i].id +"</td>"+
		  "<td>"+ items[i].nombre +"</td>"+
		  "<td class='text-center'> $ "+ items[i].precio +"</td>"+
		  "<td class='text-center'>"+ items[i].stock +"</td>"+
		  "<td class='text-center'>"+ items[i].cantidad +"</td>"+
		  "<td class='text-center'> $ "+ items[i].subtotal +"</td>"+
		  "<td class='text-center' id='eliminarArticulo' onclick='eliminarArticulo("+i+")'>Eliminar</td>"+
		"</tr>";
		$("#cuerpoTabla").append(cuerpoTabla);
	  }
	  //Valida si hay articulos en el JSON para activar el botón de Generar Pedido
	  /*
	  if(articulos.length>0)
		$("#btnGenerar").removeClass("disabled");
	  else
		$("#btnGenerar").addClass("disabled");
	*/
	}
  
  
	 
	/* ..:: MÉTODO ELIMINAR ARTÍCULO ::..*/ 

   


         

  
	function eliminarArticulo(x){ 
    
	   var confirmacion = +items[x].id+""
  alertify.confirm("se ha eliminado eliminado.", 
  function(){
    alertify.success('Ok');
  }, 
  function(){
    alertify.error('Cancel');
  }); 
	    
 
    if(confirmacion){
      
		var nuevaLista = [];
		for(var i=0; i<items.length; i++){
		  if(x==i){
			continue;
		  }else{
			jsonArticulos={
				"id" : items[i].id,
				"nombre" : items[i].nombre,
				"precio" : items[i].precio,
				"stock" : items[i].stock,
				"cantidad" : items[i].cantidad,
				"subtotal" : items[i].subtotal,
			};
			nuevaLista.push(jsonArticulos);
		  }
		}
		items = nuevaLista;
		// console.log(articulos);
		cargarTabla();
	  }
	}
   
  


function crearventa(){
   
  var datos= items
    console.log(items); 
   $.ajax({ 
     url: "controller/generarventa.php", 
     method:"POST",
     dataType: "JSON",
     data: datos,
     success: function(e) {
       if (e==1) {
         alertify.success("exito");
       } else {
        alertify.error("error"); 
        

       }
     }
   });
 
 
 


} 



















 </script>
 
 

  </body>
</html>
