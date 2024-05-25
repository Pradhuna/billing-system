<?php

include 'connection.php';

if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM products WHERE name LIKE '%".$_POST["query"]."%'";  
      $result = mysqli_query($con, $query);  
      $output = '<ul class="list-unstyled">';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
            $output .= '<li data-id="'.$row["id"].'" data-price="'.$row["price"].'">'.$row["name"].'</li>';
           }  
      }  
      else  
      {  
           $output .= '<li> Not Found</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }  




?>