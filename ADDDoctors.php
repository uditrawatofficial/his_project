<?php
require 'db.php';
$errors=[];
$formfilled = false;

 if ($_SERVER['REQUEST_METHOD'] == 'POST') 
  {
    $first_name = trim($_POST['first_name'] ?? '');
     $last_name = trim($_POST['last_name'] ?? '');
    $specialization = trim($_POST['specialization'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email= trim($_POST['email'] ?? '');

  
    if ($first_name === '') 
    $errors[] = "First name is required.";
    
    if ($last_name === '') 
    $errors[] = "last name is required.";

    if ($specialization=== '') 
    $errors[] = "Fill it properly";

    if (!preg_match('/^[0-9]{10}$/', $phone)) 
    $errors[] = "Phone must be 10 digits.";

    if ($email === '') 
        $errors[] = "Email is required.";

    if (empty($errors)) 
      {
        try {


            $x = $conn->prepare
            ("INSERT INTO doctors (first_name, last_name,specialization,  phone, email)
                 VALUES (:first_name, :last_name,:specialization, :phone, :email)");


            $x->execute([
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':specialization' => $specialization,
             
                ':phone' => $phone,
                ':email' => $email
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
<head><title>Add Doctor</title></head>
<body>

<h1>Add Doctor</h1>

<a href="HOME.html">HOME</a> |

<a href="doctors.PHP">Back to Doctor Details</a> |

<a href="patients.php">Patients</a> 


<?php 
if ($formfilled): ?>
  <p style="color:green;">Doctor added successfully!</p>
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

specialization:
  <br>
  <input type="text" name="specialization" value="<?= ($_REQUEST['specialization'] ?? '') ?>">
  <br>
  <br>



  Phone:<br>
  <input type="text" name="phone" value="<?= ($_POST['phone'] ?? '') ?>"><br><br>

  email:<br>
  <input type="text" name="email" value="<?=($_POST['email'] ?? '') ?>"><br><br>

  <button type="submit">Click To Add Doctor</button>
</form>

</body>
</html>