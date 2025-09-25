<?php
/*
channel => @mirzapanel
*/

//-----------------------------database-------------------------------
$dbname = '{DATABASE_NAME}'; // Name Database
$usernamedb = '{DATABASE_USERNAME}'; // Username Database
$passworddb = '{DATABASE_PASSOWRD}'; // Password Database

// اتصال به پایگاه داده با استفاده از mysqli
$connect = mysqli_connect("localhost", $usernamedb, $passworddb, $dbname);
if ($connect->connect_error) {
    die("The connection to the database failed:" . $connect->connect_error);
}
mysqli_set_charset($connect, "utf8mb4");

//-----------------------------info-------------------------------
$APIKEY = "{BOT_TOKEN}"; // Token Bot of Botfather
$adminnumber = "{ADMIN_#ID}"; // Id Number Admin
$domainhosts = "{DOMAIN.COM/PATH/BOT}"; // Domain Host and Path of Bot without trailing /
$usernamebot = "{BOT_USERNAME}"; // Username Bot without @

/*
 * Create agents table in the database if it doesn't exist
 * This table will store agent data such as their balance and special prices
 */
$create_agents_table_query = "
    CREATE TABLE IF NOT EXISTS agents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,  -- Telegram user ID for the agent
        special_price DECIMAL(10, 2) NOT NULL, -- Price that the agent can purchase at
        balance DECIMAL(10, 2) DEFAULT 0, -- Balance in the agent's wallet
        total_sales INT DEFAULT 0, -- Total number of accounts sold
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
";

// Create agents table if it doesn't exist
mysqli_query($connect, $create_agents_table_query);

// Function to add an agent
function addAgent($user_id, $special_price) {
    global $connect;
    // Prepared statement to prevent SQL Injection
    $stmt = $connect->prepare("INSERT INTO agents (user_id, special_price) VALUES (?, ?)");
    $stmt->bind_param("id", $user_id, $special_price);
    return $stmt->execute();
}

// Function to update agent balance after purchase
function updateAgentBalance($agent_id, $amount) {
    global $connect;
    // Prepared statement to prevent SQL Injection
    $stmt = $connect->prepare("UPDATE agents SET balance = balance - ? WHERE id = ?");
    $stmt->bind_param("di", $amount, $agent_id);
    return $stmt->execute();
}

// Function to track the sales for each agent
function trackAgentSale($agent_id) {
    global $connect;
    // Prepared statement to prevent SQL Injection
    $stmt = $connect->prepare("UPDATE agents SET total_sales = total_sales + 1 WHERE id = ?");
    $stmt->bind_param("i", $agent_id);
    return $stmt->execute();
}

//---------------------------- End of added part ----------------------------

/*
 * Connection settings for PDO
 */
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Database connection with PDO for advanced querying (if needed)
$dsn = "mysql:host=localhost;dbname=$dbname;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $usernamedb, $passworddb, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

?>
