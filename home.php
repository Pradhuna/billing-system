<?php
require_once "checkUserAuth.php";
if($_SESSION['role'] != "admin"){
  header("HTTP/1.0 404 Not Found");
  echo "<h1>404 Not Found</h1>";
  echo "The page that you have requested could not be found.";
  exit;
}
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
  </head>
  <body>
    <section class="main">
      <div class="headbar">
        <div class="head">
          <h1><i class="fa-solid fa-desktop"></i> RBS</h1>
          <nav>
          <ul>
              <?php if($_SESSION["role"] == "admin"){ ?>
              <li>
                <a href="home.php"><i class="fa-solid fa-house"></i> Home</a>
              </li>
              <li>
                <a href="insert.php"
                  ><i class="fa-solid fa-list"></i> Items Details</a
                >
              </li>
             
              <li>
                <a href="users.php"
                  ><i class="fa-solid fa-users"></i> Users</a
                >
              </li>
              <?php } ?>
              <?php if($_SESSION["role"] == "user"){ ?>
            <?php if($_SESSION["role"] == "user"){ ?>
              <li>
                <a href="orders.php" class="active"
                  ><i class="fa-solid fa-users"></i> Orders</a
                >
              </li>
              <?php } ?>
              <?php } ?>
              <li>
                <a href="info.php"
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
          <div class="ho-head">
            <h2>Dashboard</h2>
            <div class="wel-ad">
              Welcome, <?php echo $_SESSION["username"]; ?>
              <i class="fa fa-user-circle" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <?php
          include 'connection.php';
          $sql = "SELECT SUM(grand_total) as total_sales FROM bills";
          $result = $con->query($sql);
          $row = $result->fetch_assoc();
          $total_sales = $row['total_sales'];
        ?>
        <div class="stats">
          <div class="stat-box">
            <h2>Total Sales</h2>
            <p>$<?php echo $total_sales; ?></p>
          </div>

          <!-- <div class="stat-box">
            <h2>Total Earn</h2>
            <p>$4,000</p>
          </div> -->

          <?php
            $sql = "SELECT p.name, SUM(bp.qty) as total_units 
                    FROM billProducts bp 
                    JOIN products p ON bp.product_id = p.id 
                    GROUP BY bp.id 
                    ORDER BY total_units DESC 
                    LIMIT 5";
            $result = $con->query($sql);
            
          ?>
          <div class="stat-box">
            <h2>Top Sales</h2>
            <?php
            while($row = $result->fetch_assoc()) {
            ?>
            <p><?php echo $row['name']; ?> - <?php echo $row['total_units']; ?> units</p>
          <?php
            }
          ?>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
