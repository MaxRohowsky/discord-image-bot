<?PHP
echo "Bot executed \n";

// Server data - replace placeholders below with your data
$servername = "placeholder";
$username   = "placeholder";
$password   = "placeholder";
$dbname     = "placeholder";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Set index
$result = $conn->query("SELECT * FROM Counter");
$row_cnt = $result->num_rows;
// If database is empty - set 0 as initial value.
if ($row_cnt === 0) {
  $initial_entry = 0;
  $sql_init = "INSERT INTO Counter (Number) VALUES ($initial_entry)";
  $conn->query($sql_init);
  $index = $initial_entry;
}
// If database is not empty - set index to highest value.
else{
  $newest_entry = "SELECT * FROM Counter ORDER BY Number DESC LIMIT 1";
  $newest_entry = $conn->query($newest_entry);
  $newest_entry= mysqli_fetch_assoc($newest_entry);
  $index = $newest_entry["Number"];
}

//Set image to post - replace path_placeholder with path to the file that stores the images.
$image = "path_placeholder".$index.".png";

// Post to Discord - replace webhook_placeholder with your webhook.
$webhook = "webhook_placeholder";
$message = json_encode([
  "content" => $image,  
  "username" => "Image Bot",
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$send = curl_init($webhook);
curl_setopt($send, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
curl_setopt($send, CURLOPT_POST, 1);
curl_setopt($send, CURLOPT_POSTFIELDS, $message);
curl_setopt($send, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($send, CURLOPT_HEADER, 0);
curl_setopt($send, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($send);
curl_close($send);

// Increment index and save
$next_entry = $index+1;
$sql_save = "INSERT INTO Counter (Number) VALUES ($next_entry)"; 
$conn->query($sql_save);

// Close connection to database
$conn->close();

?>










