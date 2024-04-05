$email  = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

// Database connection
$con = new mysqli("localhost", "root", "password", "database3");
if ($con->connect_error) {
    die("Failed to connect : " . $con->connect_error);
} else {
    // Using prepared statement with parameterized query
    $stmt = $con->prepare("SELECT * FROM registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if ($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        if (password_verify($password, $data['password'])) {
            echo "Login success";
            // Here you can set session variables or redirect the user to a dashboard.
        } else {
            echo "<h2>Invalid email or password</h2>";
        }
    } else {
        echo "<h2>Invalid email or password</h2>";
    }
}
