<?php 
     
     require_once "model/data.php"; 

    session_start(); 



    if (isset($_SESSION["carrito"])){
        $carrito = $_SESSION["carrito"];

            
        $total = 0; 
        $i = 0;  
 

        foreach ($carrito as $p ) {
          echo "<tr>";
                echo "<td>.$p->id.</td>";
                echo "<td>.$p->nombre.</td>";
                echo "<td>.$p->precio.</td>";
                echo "<td>.$p->stock.</td>";
                echo "<td>.$p->cantidad.</td>";
                echo "<td>$.$p->subtotal.</td>";
                echo "<td>";
                   echo "<a href='controller/eliminarprocar.php?in=$i'>eliminar</a>";
                echo "</td>";
              $total += $p->subtotal;
                $i++;
         

 
          echo "</tr>";

        }
       echo "<tr>";
             echo "<td colspan='5'>total: </td>";
             echo "<td colspan='2'>total:$total</td>";
             $_SESSION["total"] = $total;
        echo "</tr>";
        echo "<tr>";
              echo "<td colspan='7'>";
                    echo "<form  action='controller/generarventa.php' method='post'>";
                    echo "<input type='submit' name='btn_generar' value='comprar'>"; 
                    

                    echo"<a href='#' id='print'>Download PDF</a>";
                    

              echo "</td>";
         echo "</tr>";



    echo "</table>";




      








           echo "<tr>";
                 echo "<td colspan='5'>total: </td>";
                 echo "<td colspan='2'>total:$total</td>";
                 $_SESSION["total"] = $total;
            echo "</tr>";
            echo "<tr>";
                  echo "<td colspan='7'>";
                        echo "<form  action='controller/generarventa.php' method='post'>";
                        echo "<input type='submit' name='btn_generar' value='comprar'>"; 
                        

                        echo"<a href='#' id='print'>Download PDF</a>";
                        

                  echo "</td>";
             echo "</tr>";



        echo "</table>";




    }
        
   


     ?>