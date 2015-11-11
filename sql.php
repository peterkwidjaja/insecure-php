<?php
function connect() {
  $servername = "localhost";
  $username = "admin";
  $password = "admin";
  $dbname = "cs3235";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  // Check connection
  if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
  } 

  return $conn;
}

function getData($matric) {
  $conn = connect();
  $sql = "SELECT matric, mcode, grade
          FROM users
          WHERE matric='$matric'";
  $result = mysqli_query($conn, $sql);
  mysqli_close($conn);
  return $result;
}

function printData($matric) {
  echo "<table class='table'>
  <tr>
  <th>Matric</th>
  <th>Module</th>
  <th>Grade</th>
  </tr>";

  if ($result = getData($matric)) {
    foreach($result as $data) {
      echo "<tr>";
      echo "<td>" . $data['matric'] . "</td>";
      echo "<td>" . $data['mcode'] . "</td>";
      echo "<td>" . $data['grade'] . "</td>";
      echo "</tr>";
    }
  }
  echo "</table>";
}

function printTable() {
  $matric = $mcode = $grade = "";

  if (isset($_POST["submit"])) {
    $matric = $_POST["matric"];
    $mcode = $_POST["mcode"];
    $grade = $_POST["grade"];

    $conn = connect();
    $sql = "INSERT INTO users(matric, mcode, grade)
            VALUES ('$matric', '$mcode', '$grade');";
    $conn->query($sql);
    mysqli_close($conn);

    printData($matric);
  }

  if (isset($_POST["show"])) {
    $matric = $_POST["matric"];

    printData($matric);
  }
}
?>

<html>
  <head>
  <title>SQL Injection</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body> 

    <div class = "form">
      <div class = "container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
            <label for="inputMatric">Matric Number</label>
            <input type="text" class="form-control" id="inputMatric" name="matric">
          </div>
          <div class="form-group">
            <label for="inputModuleCode">Module Code</label>
            <input type="text" class="form-control" id="inputModuleCode" name="mcode">
          </div>
          <div class="form-group">
            <label for="inputGrade">Grade</label>
            <input type="text" class="form-control" id="inputGrade" name="grade">
          </div>
          <input type="submit" class="btn btn-info" id="button" name="show" value="Show">
          <input type="submit" class="btn btn-info" id="button" name="submit" value="Submit">
        </form>
      </div>
    </div>

    <div class="table">
      <div = class="container">
        <?php printTable();?>
      </div>
    </div>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
