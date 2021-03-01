<?php
require_once "basedatos.php";
require_once "producto.php";
require_once "venta.php";
require_once "Detalle.php";


 class Data{
    private $con; 

public function __construct(){

  $this->con = new Conexion("localhost", "ventas", "root", "");
 
 
}

   public function getProductos(){

     $productos = array();

     $query = "select * from Producto ";
     $res = $this->con->ejecutar($query);
      while ($reg = mysql_fetch_array($res)) {

      $p = new Producto();

      $p->id = $reg[0];
      $p->nombre = $reg[1];
      $p->precio = $reg[2];
      $p->stock = $reg[3];
 

  array_push($productos, $p);


}

     return $productos;

   }
 
   public function getventas(){

     $ventas = array();

     $query = "select * from venta";
     $res = $this->con->ejecutar($query);
     while ($reg = mysql_fetch_array($res)) {

    $v = new venta();
 
    $v->id = $reg[0];
    $v->fecha = $reg[1];
    $v->total = $reg[2];



  array_push($ventas, $v);


  }

     return $ventas;

   }


   public function getdetalles($idventa){
    $query = "select d.id,p.nombre,d.cantidad, d.subtotal, p.precio
    from detalle d, producto p
    where d.producto = p.id and
    d.venta = '$idventa'";

    $detalles = array();

    $res = $this->con->ejecutar($query);

    while ($reg = mysql_fetch_array($res)){
       $d = new Detalle();
       
       $d->id = $reg[0];
       $d->nombreproducto = $reg[1];
       $d->cantidad = $reg[2];
       $d->subtotal = $reg[3];
       $d->precio = $reg[4];


       array_push($detalles, $d);
    }


      return $detalles;

  }




   public function crearventa($listaproductos,  $total){

     $query = "insert into venta values(null, now(), $total)";
     $this->con->ejecutar($query);
 
      $idultimaventa = 0;

     $query = "select max(id) from venta";
     $res = $this->con->ejecutar($query);
     if ($reg = mysql_fetch_array($res)) {

    } 
          $idultimaventa = $reg[0];

     // insert del detalle
          foreach ($listaproductos as $p) {
            $query = "insert into detalle values(null,
              '".$idultimaventa."',
              '".$p->id."',
              '".$p->cantidad."',
              '".$p->subtotal."')";

             $this->con->ejecutar($query);
             
             $this->actualizarstock($p->id,$p->cantidad);
            
       }

      
 
 

       }

     public function actualizarstock($id , $stockAdescontar){ 
      $query = "select stock from producto where id = $id"; 
      $res = $this->con->ejecutar($query);
      $stockActual = 0;
      if ($reg = mysql_fetch_array($res)) {
        $stockActual = $reg[0];
  }



      $stockActual -= $stockAdescontar;  

      $query="update producto set stock = $stockActual where id = $id"; 
      $this->con->ejecutar($query);

     } 
     
    
     



  }


  /*  public function tieneStock($id, $stock){
        $query = "select stock from producto where id = $id";

        $res = $this->con->ejecutar($query);
        $stockactual = 0;
        if ($reg = mysql_fetch_array($res)) {
                   $stockActual = $reg[0];
             }
             if ($stockActual >= $stock) {
               return true;
             }else {
               return false;
             }


          }

 }*/



 ?>
