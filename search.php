<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="item-ta">
                <table border='1'cellspacing='0' border-collapse="collapse">
                  <tr>
                    <th>ID</th>
                    <th>Particular</th>
                    <th>Price</th>
                  </tr>
                  <?php
include "connection.php";

if(isset($_POST['searchTerm'])){
    $searchTerm = $_POST['searchTerm'];
    
    $query = "SELECT * FROM products WHERE name LIKE '%$searchTerm%'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];

            echo "<tr>
                <td>".$id."</td>
                <td>".$name."</td>
                <td>".$price."</td>
                
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No results found</td></tr>";
    }
}
?>
                </table>
              </div>
              <!-- <td>
                    <a href='update.php?id=$id'><button><i class='fas fa-edit'></i></button></a>
                    <a href='delete.php?id=$id'><button><i class='fa-solid fa-trash'></i></button></a>
                </td> -->
</body>
</html>
