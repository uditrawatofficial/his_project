<?php
require 'db.php';
$getdata = $conn->query("SELECT * FROM doctors");
$doctordetails = $getdata->fetchAll();
?>


<!DOCTYPE html>
<html>
<head><title>DOCTORS DETAILS</title></head>
<body>

<h1>Doctor Details</h1>
<a href="HOME.html">HOME</a> | <a href="patients.php">Back to Patients</a>   |   <a href="ADDDoctors.php">Add Doctors</a> 

<table border="1" cellpadding="50">
<tr><th>ID</th><th>FIRST Name</th><th>LAST Name</th><th>FIELD</th><th>Email</th><th>Contacts</th></tr>


<?php foreach ($doctordetails as $d): ?>
<tr>
  <td><?= ($d['d_id']) ?></td>
  <td><?= ($d['first_name']) ?></td>
<td><?= ($d['last_name']) ?></td>
  <td><?= ($d['specialization']) ?></td>
   <td><?= ($d['email']) ?></td>
  <td><?= ($d['phone']) ?></td>

</tr>
<?php endforeach; ?>
</table>
</body>
</html>