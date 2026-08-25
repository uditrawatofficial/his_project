<?php
require 'db.php';
$getdata = $conn->query("SELECT * FROM patients ");
$patients = $getdata->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Patients</title></head>
<body>
<h1>Patients Details</h1>


 <a href="HOME.html">HOME</a> | <a href="AddPatients.php">Add Patient</a>   |   <a href="doctors.php">Doctors</a>   |   <a href="app.php"> Appointment Details</a>  
<table border="10" cellpadding="50">

<tr><th>ID</th><th>FName</th><th>lName</th><th>Gender</th><th>DOB</th><th>Phone</th><th>EMail</th><th>Address</th></tr>

<?php 
foreach ($patients as $p): ?>
<tr>
  <td><?= ($p['p_id']) ?></td>
  <td><?= ($p['first_name']) ?></td>
  <td><?= ($p['last_name']) ?></td>
  <td><?= ($p['gender']) ?></td>
  <td><?= ($p['date_of_birth']) ?></td>
  <td><?= ($p['phone']) ?></td>
  <td><?=  ($p['email']) ?></td>
  <td><?=  ($p['address']) ?></td>
</tr>
<?php endforeach; ?>



</table>
</body>
</html>