<?php
require 'db.php';
$errors=[];
$formfilled = false;

 if ($_SERVER['REQUEST_METHOD'] == 'POST') 
  {
    $first_name = trim($_POST['first_name'] ?? '');
     $last_name = trim($_POST['last_name'] ?? '');
    $dob = trim($_POST['date_of_birth'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
  
  
    if ($first_name === '') 
    $errors[] = "First name is required.";
    
    if ($last_name === '') 
    $errors[] = "last name is required.";

    if ($dob === '' || !strtotime($dob)) 
    $errors[] = "Fill it properly";

 if (!in_array($gender, ['Male', 'Female', 'Other'])) 
    $errors[] = "Fill Gender Properly.";

    if (!preg_match('/^[0-9]{10}$/', $phone)) 
    $errors[] = "Phone must be 10 digits.";

  if ($email === '') 
    $errors[] = "Email is required.";

    if ($address === '') $errors[] = "Address is required.";

    if (empty($errors)) 
      {
        try {


            $x = $conn->prepare
            ("INSERT INTO patients (first_name, last_name,date_of_birth, gender, phone, email, address)
                 VALUES (:first_name, :last_name,:dob, :gender, :phone, :email, :address)");


            $x->execute([
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':dob' => $dob,
                ':gender' => $gender,
                ':phone' => $phone,
                ':email' => $email,
                ':address' => $address
            ]);


            $formfilled= true;
        } 
        
        catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head><title>Add Patient</title></head>
<body>

<h1>Add Patient</h1>

<a href="HOME.html">HOME</a> |<a href="patients.PHP">Back to Patients</a>


<?php 
if ($formfilled): ?>
  <p style="color:green;">Patient added successfully!</p>
<?php endif; ?>


<?php foreach ($errors as $er): ?>
  <p style="color:red;"><?=($er) ?></p>
<?php endforeach; ?>

<form method="POST">
  <br>
  First Name:<br>
  <input type="text" name="first_name" value="<?= ($_REQUEST['first_name'] ?? '') ?>">
  <br>
  <br>

    Last Name:<br>
  <input type="text" name="last_name" value="<?= ($_REQUEST['last_name'] ?? '') ?>">
  <br>
  <br>


  Date of Birth:
  <br>
  <input type="date" name="date_of_birth" value="<?= ($_REQUEST['date_of_birth'] ?? '') ?>">
  <br>
  <br>

  Gender:
  <br>
  <select name="gender">
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
  </select>
  <br>
  <br>

  Phone:<br>
  <input type="text" name="phone" value="<?= ($_POST['phone'] ?? '') ?>"><br><br>

  Email:<br>
  <input type="email" name="email" value="<?= ($_POST['email'] ?? '') ?>"><br><br>

  Address:<br>
  <input type="text" name="address" value="<?=($_POST['address'] ?? '') ?>"><br><br>

  <button type="submit">Click To Add Patient</button>
</form>

</body>
</html>