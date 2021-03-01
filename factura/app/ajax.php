<?php  
require_once 'config.php';


$action = $_POST['action']; 
$conceptos = []; 


if (!isset($_SESSION['conceptos'])) {
    $_SESSION['conceptos'] = [];
}else{
    $conceptos = $_SESSION['conceptos'];
}
 
switch ($action) { 
    case 'add_pro':
       $pro = 
       [ 
            'id'         => rand(111111,999999), 
            'concepto'   => $_POST['concepto'], 
            'cantidad'   => (int)$_POST['cantidad'],
            'precio_uni' => $_POST['precio_uni'], 
            'subtotal'   =>  floatval($_POST['cantidad'] * $_POST['precio_uni'])
       ]; 
       $_SESSION['conceptos'][] = $pro; 
         json_output(json_build('200','producto agregado' ));
        break;
        case 'eliminar_pro':

        if (!isset($_SESSION['id'])) {
        json_output(json_build(400,'producto no valido'));
        }  

        $id = (int) $_POST['id']; 
          
          // si no hay producto
         if (!isset($_SESSION['conceptos']) || empty($_SESSION['conceptos'])) {
             json_output(json_build(400,'no hay producto en la lista'));
         }  
          // si hay producto
         foreach ($_SESSION['conceptos'] as $i => $v) {
             if ($v['id'] == $id) {
                unset($_SESSION['conceptos'][$i]); 
                json_output(json_build(200,'producto borrado con exito'));
             }
         };
         
         json_output(json_build(400,'producto no valido'));
      break;
 
       case 'cargar_pro':
            $conceptos = cargar_productos();   

            $subtotal = 0 ;
            $iva      = 0 ; 
            $total    = 0 ;


            $html = 
            '<div class="card">
                  <div class="card-body">
                  <h4> producto actual</h4>  
                   <table class="table table-hover table-striped">
                       <thead>
                           <tr>
                               <th class="text-center">Producto</th>
                               <th class="text-center">Precio</th>
                               <th>Cantidad</th>
                               <th class="text-right">Total</th>
                               <th class="text-right">Editar y Eliminar</th>
                           </tr>
                       </thead>
                       <tbody>'; 

                                    foreach ($conceptos as $i => $v) {
                                        $html .= '
                                        <tr>                                
                                        <td class="text-center">'.$v['concepto'].'</td>
                                        <td class="text-center">$'.number_format($v['precio_uni'],2).'</td>
                                        <td class="text-right">'.$v['cantidad'].'</td>
                                        <td class="text-right">$'.number_format($v['subtotal'],2).'</td>
                                        <td class="text-right">
                                        <div class="btn-group">
                                            <button class="btn btn-primary edit_pro" data-id="'.$v['id'].'"  >Editar</button>
                                            <button class="btn btn-danger  delete_pro" data-id="'.$v['id'].'" >Eliminar</button>
                                        </div>
                                      </td>
                                    </tr> 
                                      '; 
                                        (float)$subtotal += $v['subtotal'];  
                                       
                                    };
                         
                                    $iva = (float) $subtotal * 0.19;
                                    $total = $subtotal + $iva;

                      $html .='
        
                        <tr>
                               <td colspan="3">Subtotal</td>
                               <td colspan="1" class="text-right">$'.number_format($subtotal,2).'</td>
                               <td></td>
                           </tr> 

                           <tr>
                               <td colspan="3">Iva</td>
                               <td colspan="1" class="text-right">$'.number_format($iva ,2).'</td>
                               <td></td>
                           </tr> 

                           <tr>
                               <td colspan="3">total</td>
                               <td colspan="1" class="text-right"><h5><b>$'.number_format($total ,2).'</b></h5></td>
                               <td></td>
                           </tr>
                       </tbody>
                   </table>
                </div>
             </div>
            ';
            json_output(json_build(200,'OK', $html));
       break; 
     case 'cargar_p': 
      $id = (int) $_POST['id'];     
      $concepto = cargar_p($id);  
      
       if (!$concepto) {
           json_output(json_build(400, 'producto no valido'));
       }
       json_output(json_build(200, 'OK', $concepto));
     break;
    default:
        # code...
        break;
}

 


?>