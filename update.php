<?php
require_once "checkUserAuth.php";
?>
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
                <a href="Home.html"><i class="fa-solid fa-house"></i> Home</a>
              </li>
              <li>
                <a href="items.html" class="active"
                  ><i class="fa-solid fa-list"></i> Items Details</a
                >
              </li>
              <li>
                <a href="sales.html"
                  ><i class="fa-solid fa-book"></i> Sales Report</a
                >
              </li>
              <li>
                <a href="register.html"
                  ><i class="fa-solid fa-users"></i> Users</a
                >
              </li>
              <li>
                <a href="orders.php"
                  ><i class="fa-solid fa-users"></i> Orders</a
                >
              </li>
              <li>
                <a href="info.html"
                  ><i class="fa-solid fa-barcode"></i> About Us</a
                >
              </li>
              <li>
                <a href="logout.php"
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
            <div class="it-se">
              <input type="text" name="" id="" />
              <button><i class="fa fa-search"></i> Search</button>
            </div>
          </div>
        </div>
        <div class="it-de-ma">
          <div class="maintain-items">
            <div class="input-items">
                <?php
                include 'connection.php';
                $updateMode = false;

                // Check if "id" is provided for update
                if (isset($_GET['id'])) {
                    $updateMode = true;
                    $id = $_GET['id'];

                    $query = "SELECT * FROM products WHERE id= $id";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);
                    
                }
            ?>
              <form action="" method="POST">
                <div class="it-fo-co">
                  <label for="">Product ID</label>
                  <input type="text" name="pid" value= "<?php echo ($updateMode) ? $row['id'] : ''; ?>"/>
                </div>
                <div class="it-fo-co">
                  <label for="">Product Name</label>
                  <input type="text" name="pname" value="<?php echo ($updateMode) ? $row['name'] : ''; ?>"/>
                </div>
                <div class="it-fo-co">
                  <label for="">Price</label>
                  <input type="text" name="pprice" value= "<?php echo ($updateMode) ? $row['price'] : ''; ?>"/>
                </div>
                <div class="it-fo-co">
                  <button class="ad" name="padd">
                    <i class="fa-solid fa-plus"></i> Update
                  </button>
                 
                  <button class="ca" name="pcancel">
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

                        if ($updateMode) {
                            $query = "UPDATE products SET name='$name', price=$price WHERE id=$id";
                        } else {
                            $query = "INSERT INTO products VALUES($id, '$name', $price)";
                        }
                        // $query = "INSERT INTO products VALUES($id, '$name', $price)";
                        $result = mysqli_query($con,$query);
                        if($result){
                            echo "Insert Successfully!";
                            header('location:insert.php');
                        }else{
                          echo "Error:" . mysqli_error($con);
                            // die(mysqli_error($result));
                        }
                    }
                    if(isset($_POST['pcancel'])){
                      header('location:insert.php');
                    }
                ?>
              </form>
            </div>
            <div class="output-items">
              <div class="item-ta">
                <table border='1'cellspacing='0' border-collapse="collapse">
                  <tr style="background-color: #b4d4ff; height: 30px">
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
                </button>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>
  </body>
</html>
