<?php
require 'db.php';
$getdata= $conn->query("SELECT * FROM appointments ORDER BY appointment_id");
$appoint = $getdata->fetchAll();
?>


<!DOCTYPE html>
<html>
<head><title>APPOINTMENT DETAILS</title></head>
<body>
  
    <style>
  body {
    background-image: url('blur-hospital.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
  </style>
<h1>APPOINTMENT DETAILS</h1>
<a href="HOME.html">HOME</a> |<a href="patients.php">Patients</a> | <a href="Doctors.php">Doctors</a> | <a href="ADDAppointment.php"> Add Appointment </a>

<table border="1" cellpadding="50">
<tr><th>APPOINTMENT ID</th><th>PATIENT ID </th><th>PATIENT NAME</th><th>DOCTOR NAME</th><th>APPOINTMENT DATE </th></tr>

<?php foreach ($appoint as $a): ?>
<tr>
 <td><?= ($a['appointment_id']) ?></td>
   <td><?= ($a['p_id']) ?></td>
  <td><?= ($a['patient_name']) ?></td> 
<!-- <td><?=($a['d_id']) ?></td> -->
  <td><?= ($a['doctor_name']) ?></td>
  <td><?= ($a['appointment_date']) ?></td>
 
 

</tr>
<?php endforeach; ?>


</table>
</body>
</html>