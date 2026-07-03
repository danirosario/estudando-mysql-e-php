<?php
require_once("config.php");

// Example of using password_hash() for secure password storage
$plainPassword = "user_secret_password";

// Generates a secure, 60-character BCrypt hash
$hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
echo "<br><br>Hashed Password: ";
echo $hashedPassword; // Example output: $2y$10$e0NR9J8Q1F5Z1K1J1J1J1J1J

echo "<br><br>";
// To verify the password later
$userInput = "user_secret_password"; // From login form
$storedHash = '$2y$10$pH7TJLZznconcO.l1Wko2OW23k7jtDsvetqEgkvAe5Mcb.rpsB6f6'; // Retrieved from your database

if (password_verify($userInput, $storedHash)) {
    echo "Password is valid!";
} else {
    echo "Invalid password.";
}
?>

<br> <br> 
Note: Always use password_hash() and password_verify() for secure password handling in PHP. 
Avoid using MD5 or SHA1 for password storage.

