
<?php
require 'db.php';
$errors = [];
$success = false;

// Always initialize
$p_id = '';
$d_id = '';
$appointment_date = '';

$patients = $conn->query("SELECT p_id, first_name, last_name FROM patients ORDER BY first_name")->fetchAll();
$doctors = $conn->query("SELECT d_id, first_name, last_name FROM doctors ORDER BY first_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p_id = $_POST['p_id'] ?? '';
    $d_id = $_POST['d_id'] ?? '';
    $appointment_date = $_POST['appointment_date'] ?? '';
    

    if (!ctype_digit($p_id)) $errors[] = "Please select a patient.";
    if (!ctype_digit($d_id)) $errors[] = "Please select a doctor.";
    if ($appointment_date === '' || !strtotime($appointment_date)) $errors[] = "Valid appointment date/time is required.";

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO appointments (p_id, d_id, appointment_date)
                 VALUES (:p_id, :d_id, :appointment_date)"
            );
            $stmt->execute([
                ':p_id' => $p_id,
                ':d_id' => $d_id,
                ':appointment_date' => $appointment_date
            ]);
            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}


?>


<!DOCTYPE html>
<html>
<head>
  <title>Add Appointment</title>
  <style>
    body{
      background-image: url('portrait-smiling-front-desk-receptionist-waiting-greet-patients-private-practice-clinic-lobby-professional-healthcare-worker-offering-support-hospital-appointments.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      min-height: 100vh;
      margin: 0;
    }
  </style>
</head>
<body>
<!DOCTYPE html>
<html>
<head>
  <title>Add Appointment</title>
  <style>
    body{
      background-image: url('portrait-smiling-front-desk-receptionist-waiting-greet-patients-private-practice-clinic-lobby-professional-healthcare-worker-offering-support-hospital-appointments.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      min-height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: sans-serif;
    }

    .container{
      background: rgba(182, 185, 183, 0.9);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.25);
      text-align: center;
      width: 90%;
      max-width: 420px;
    }

    form{
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: left;
      width: 100%;
    }

    select, input{
      width: 100%;
      padding: 8px;
      margin-top: 4px;
      box-sizing: border-box;
    }

    button{
      margin-top: 20px;
      padding: 10px 30px;
      cursor: pointer;
    }

    a{
      display: inline-block;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Book Appointment</h1>
  <a href="app.php"> <h3>Back to Appointments</h3></a>

  <?php if ($success): ?>
    <p style="color:green;">Appointment booked successfully!</p>
  <?php endif; ?>

  <?php foreach ($errors as $err): ?>
    <p style="color:red;"><?= ($err) ?></p>
  <?php endforeach; ?>

  <form method="POST">
    Patient:<br>
    <select name="p_id">
      <option value="">-- Select Patient --</option>
      <?php foreach ($patients as $p): ?>

        
        <option value="<?php echo $p['p_id']; ?>">
        <?php echo $p['first_name'] . ' ' . $p['last_name']; ?>  </option>

      <?php endforeach; ?>
    </select><br><br>

    Doctor:<br>
    <select name="d_id">
      <option value="">-- Select Doctor --</option>
      <?php foreach ($doctors as $d): ?>
        <option value="<?= $d['d_id'] ?>"><?= ($d['first_name'] . ' ' . $d['last_name']) ?></option>
      <?php endforeach; ?>
    </select><br><br>

    Date/Time:<br>
    <input type="datetime-local" name="appointment_date"><br><br>

    <button type="submit">Book Appointment</button>
  </form>
</div>

</body>
</html>