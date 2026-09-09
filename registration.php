<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="CSS/css/bootstrap.min.css">
</head>
<body>
<?php

require "config.php";

$registration_success = false;
$registered_first_name = "";
$registered_last_name = "";

if (isset($_POST['create'])) {

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email'];

    // Hash the password before storing it
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO students
            (firstname, lastname, ph, email, pw)
            VALUES (?, ?, ?, ?, ?)";

    $stmtinsert = $db->prepare($sql);

    try {

        $result = $stmtinsert->execute([
            $first_name,
            $last_name,
            $phone,
            $email,
            $password
        ]);

        if ($result) {
            $registration_success = true;
            $registered_first_name = $first_name;
            $registered_last_name = $last_name;
        }

    } catch (PDOException $e) {

        $registration_success = false;

    }
}

?>
    
    <div class="container py-5">
        
                <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-6">
                        <div class="card shadow border-1">
                             <!-- Card Header -->
                              <div class="card-header bg-primary text-white text-center py-3">
                                <h1 class="mb-0">Student Registration</h1>
                                <small>Please fill in your information</small>
                              </div>

                            <!-- Card Body -->
                            <div class="card-body p-4">
                                <form action="registration.php" method="post">
                                    <!-- First Name + Last Name -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="first_name">First Name:</label>
                                            <input class="form-control" type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                                        </div>
                                        <div  class="col-md-6 mb-3">
                                            <label for="last_name">Last Name:</label>
                                            <input class="form-control"  type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                                        </div>
                                   </div>
                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number:</label>
                                        <input class="form-control" type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                                    </div>
                                    <!-- Email -->
                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email:</label>
                                        <input class="form-control" type="email" id="email" name="email" placeholder="Enter your email" required>
                                    </div>
                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password:</label>
                                        <input class="form-control" type="password" id="password" name="password" placeholder="set your password" required>
                                    </div>
                                    <!-- Register Button -->
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" type="submit" id="register" name="create">Register</button>
                                    </div>
                                    <!-- Card Footer -->
                                    <div class="card-footer text-center text-muted">
                                        <small>Student Registration System</small>
                                    </div>
                                </form>
                        </div>
                        
                    </div>
                </div> 
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
<?php if ($registration_success): ?>

Swal.fire({
    title: "Registration Successful!",
    text: "Welcome, <?php echo htmlspecialchars($registered_first_name . ' ' . $registered_last_name); ?>!",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#0d6efd"
});

<?php else: ?>

<?php if (isset($_POST['create'])): ?>

Swal.fire({
    title: "Registration Failed",
    text: "There was an error while saving your information.",
    icon: "error",
    confirmButtonText: "Try Again",
    confirmButtonColor: "#dc3545"
});

<?php endif; ?>

<?php endif; ?>
</script>
</body>
</html>