<?PHP
echo "bot executed";

// Server data - replace Placeholders below with your data
$servername = "placeholder";
$username = "placeholder";
$password = "placeholder";
$dbname = "placeholder";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Set index
$newest_entry = "SELECT * FROM Counter ORDER BY timestamp DESC LIMIT 1";
$newest_entry = $conn->query($newest_entry);
$newest_entry = mysqli_fetch_assoc($newest_entry);
$index = $newest_entry["Number"];

// Set image to post - replace path_placeholder with path to the file that stores the images.
$image = "path_placeholder".$index.".png";

// Post to Discord - replace webhook_placeholder with your webhook.
$webhook = "webhook_placeholder";
$message = json_encode([
  "content" => $image,  
  "username" => "Max's Meme Bot",
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
$next_entry = $newest_entry["Number"]+1;
$sql_save = "INSERT INTO Counter (Number) VALUES ($next_entry)"; 

if ($conn->query($sql_save) === TRUE) {
echo "New record created successfully";
} else {
echo "Error: " . $sql_save . "<br>" . $conn->error;
}

$conn->close();

?>













