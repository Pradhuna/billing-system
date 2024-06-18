<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant Billing system</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <style>

    </style>
  </head>
  <body>
    <section class="main">
      <div class="headbar">
        <div class="head">
          <h1><i class="fa-solid fa-desktop"></i> RBS</h1>
          <nav>
            <ul>
              <li>
                <a href="home.php"><i class="fa-solid fa-house"></i> Home</a>
              </li>
              <li>
                <a href="insert.php" class="active"
                  ><i class="fa-solid fa-list"></i> Items Details</a
                >
              </li>
              <li>
                <a href=""
                  ><i class="fa-solid fa-book"></i> Sales Report</a
                >
              </li>
              <li>
                <a href="users.php"
                  ><i class="fa-solid fa-users"></i> Users</a
                >
              </li>
              <li>
                <a href="orders.php"
                  ><i class="fa-solid fa-users"></i> Orders</a
                >
              </li>
              <li>
                <a href="info.php"
                  ><i class="fa-solid fa-barcode"></i> About Us</a
                >
              </li>
              <li>
                <a href=""
                  ><i class="fa-solid fa-right-from-bracket"></i> Logout</a
                >
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="pro-it">
        <div class="so-in">
          <div class="top-search">
            <h1>Items Details</h1>
            <form id="searchForm" method="POST">
            <div class="it-se">
              <input type="text" id="searchTerm" name="searchTerm" />
              <button type="submit"><i class="fa fa-search"></i> Search</button>
            </div>
          </form>
          </div>
        </div>
        <div class="it-de-ma">
          <div class="maintain-items">
            <div class="input-items">
                
              <form action="" method="POST">
                <div class="it-fo-co">
                  <label for="">Product ID</label>
                  <input type="text" name="pid" />
                </div>
                <div class="it-fo-co">
                  <label for="">Product Name</label>
                  <input type="text" name="pname"/>
                </div>
                <div class="it-fo-co">
                  <label for="">Price</label>
                  <input type="text" name="pprice" />
                </div>
                <div class="it-fo-co">
                  <button class="ad" name="padd">
                    <i class="fa-solid fa-plus"></i> Add
                  </button>
                  
                  <button class="ca">
                    <i class="fa-solid fa-xmark"></i> Cancel
                  </button>
                </div>
                <div class="it-fo-co"></div>
                <?php
                    include 'connection.php';
                    // if($_SERVER["REQUEST_METHOD"] == "POST")
                    if(isset($_POST['padd'])){
                        $id = $_POST["pid"];
                        $name = $_POST["pname"];
                        $price = $_POST["pprice"];

                        // if ($updateMode) {
                        //     $query = "UPDATE products SET name='$name', price=$price WHERE id=$id";
                        // } else {
                        //     $query = "INSERT INTO products VALUES($id, '$name', $price)";
                        // }
                        if(empty($id) || empty($name) || empty($price)) {
                          echo "All fields are required.";
                          return;
                      }
                        $query = "INSERT INTO products VALUES($id, '$name', $price)";
                        $result = mysqli_query($con,$query);
                        if($result){
                            echo "Insert Successfully!";
                            
                        }else{
                          echo "Error:" . mysqli_error($con);
                            // die(mysqli_error($result));
                        }
                    }

                ?>
              </form>
            </div>
            <div class="output-items">
              <div class="item-ta">
                <table border='1'cellspacing='0' border-collapse="collapse" color="red">
                  <tr>
                    <th>ID</th>
                    <th>Particular</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                  <!-- PHP Code Start -->
                  <?php
                    include "connection.php";
                    $query = "SELECT * FROM products";
                    $result = mysqli_query($con, $query);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        
                        $id = $row['id'];
                        $name = $row['name'];
                        $price = $row['price'];
                        
                        echo "<tr>
                        <td>".$id."</td>
                        <td>".$name."</td>
                        <td>".$price."</td>
                        <td>
                        <a href='update.php?id=$id'><button><i class='fas fa-edit'></i></button></a>
                        <a href='delete.php?id=$id'<button><i class='fa-solid fa-trash'></i></i></button></>
                        </td>
                        </tr>";
                    }
                    ?>
                    
                </table>
              </div>
              <!-- <div class="up-de">
                <button class="up">
                  <i class="fa-solid fa-pen-to-square"></i> Update
                </button>
                <button class="de">
                  <i class="fa-solid fa-trash"></i> Delete
                </button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#searchForm').submit(function(e){
        e.preventDefault();
        var searchTerm = $('#searchTerm').val();
        $.ajax({
            type: 'POST',
            url: 'search.php', // Create a PHP file named search.php to handle the search
            data: { searchTerm: searchTerm },
            success: function(response){
                $('.item-ta').html(response);
            }
        });
    });
});
</script>

  </body>
</html>
