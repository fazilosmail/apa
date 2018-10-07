<!DOCTYPE html>
<html>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_query($conn, "UPDATE `sample` SET `Date_of_Birth`= '" . date("Y-m-d") . "' LIMIT 1");
$sql = "SELECT `Employee Name`, `Emp. email id` , `Employee Image`, `Date_of_Birth` FROM `sample` ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> Employee Name: ". $row["Employee Name"]. "<br>";
        echo "<br> Emp. email id: ". $row["Emp. email id"]. "<br>";
        echo '<div class="caption"><h3><img src="data:image/jpeg;base64,'.base64_encode($row['Employee Image']).'"/></h3></div>';
        echo "<br> Date_of_Birth: ". $row["Date_of_Birth"]. "<br>";

?>
<?php
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';
require 'class.smtp.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'samplefaz789@gmail.com';                 // SMTP username
$mail->Password = 'admin!123';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('from@example.com', 'Mailer');
$mail->addAddress($row["Emp. email id"], 'Joe User');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('faziljp@gmail.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');
$mail->AddEmbeddedImage(dirname(__FILE__).'/download.jpg', 'logo_2u');
    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = ' <html>
    <head>
        <title>Apa Wishes</title>
        <style type="text/css">
            p{
                    font-size: 20px;
                    font-family: sans-serif;
            }
            @media only screen and (max-width: 900px){
    td { 
        display: block; 
    }
}
        </style>
    </head>
    <body>
        <table cellspacing="0" style="border: 2px solid red;width: 50%;height: auto;display: table;margin: auto;padding: 0 15px;">
            <tr>
                <td colspan="2"> <p style="color: #0d0dff;">APA Wishes</p>
                    <p style="color: #ff9c0b;">'. $row["Employee Name"].'</p>
                <p style="color: #0d0dff;">Who is celebrating his birthday on</p>
            <p style="color: #498230;">'. $row["Date_of_Birth"].'</p>
            <p style="color: #0d0dff;">A very Happy Birthday!!</p>
            <p style="color: #0d0dff;">Have a great day &amp; glorious year aheah</p></td>
                <td colspan="2" style="padding: 15px 0px;"><img src="cid:logo_2u" alt="Employee Name"></td>
            </tr>
            
        </table>
        <table cellspacing="0" style="border: 20px solid red;width: 50%;height: auto;display: table;margin: auto;padding: 0 15px;">
        </table>
    </body>
    </html>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}?>
<?php
    }
} else {
    echo "0 results";
}

$conn->close();
?> 

</body>
</html>
