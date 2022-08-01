<?php
$urltoredirectafterwork = '/';
// $to = 'Daylogicinfotech@gmail.com';
$to = 'h98119@gmail.com';
$from = $_POST['from_email'];
$priority = $_POST['priority'];
$regarding = $_POST['regarding'];
$description = $_POST['description'];
$ftext = "";
/*if (isset($_POST['g-recaptcha-response'])) {
    $captcha = $_POST['g-recaptcha-response'];
}
if (!$captcha) {
    die("Please check the Captcha form.");
}
$secretKey = "6Le0PR8hAAAAAO_-9DC88BY5IXpd81g9AVkWkX3S";
// $secretKey = "use your secret key";
$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
$response = file_get_contents($url);
$responseKeys = json_decode($response, true);
if ($responseKeys["success"] = 1) {*/
   /* $checked = check_all_inputs($from, $priority, $regarding, $description);
    if ($checked != '') {
        echo $checked;
        header("refresh:2;url=$urltoredirectafterwork");
    }*/
    $uploadStatus = 1;
    if (!empty($_FILES["filetosend"]["name"])) {
        // File path config
        $targetDir = "fileuploaded/";
        $fileName = basename($_FILES["filetosend"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $fileatt_type = $_FILES['filetosend']['type'];
        // Allow certain file formats
        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to the server
            if (move_uploaded_file($_FILES["filetosend"]["tmp_name"], $targetFilePath)) {
                $uploadedFile = $targetFilePath;
            } else {
                $uploadStatus = 0;
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $uploadStatus = 0;
            $statusMsg = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
        }
    }
    if ($uploadStatus) {

        // Recipient
        $toEmail = $to;
        $fromemail = $from;
        // Sender
        // $from = 'ticket@olha.telsnet.com.ng';
        $fromName = 'ONEMAK Tickets';

        // Subject
        $emailSubject = $regarding ;

        // Message 
        $htmlContent = '<p><b>Priority:</b> ' . $priority . '</p>
                    <p><b>Description:</b><br/>' . $description . '</p>';

        // Header for sender info
        $headers = "From: $fromName" . " <" . $fromemail . ">";

        if (!empty($uploadedFile) && file_exists($uploadedFile)) {


            // Boundary  
            $semi_rand = md5(time());
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

            // Headers for attachment  
            $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

            // Multipart boundary  
            $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

            if (is_file($uploadedFile)) {
                $message .= "--{$mime_boundary}\n";
                $fp =    @fopen($uploadedFile, "rb");
                $data =  @fread($fp, filesize($uploadedFile));

                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"" . basename($uploadedFile) . "\"\n" .
                    "Content-Description: " . basename($uploadedFile) . "\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"" . basename($uploadedFile) . "\"; size=" . filesize($uploadedFile) . ";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
            $message .= "--{$mime_boundary}--";
            $returnpath = "-f" . $from;

            // Send email 
            $mail = @mail($toEmail, $emailSubject, $message, $headers, $returnpath);


            // Delete attachment file from the server
            @unlink($uploadedFile);
        } else {
            // Set content-type header for sending HTML email
            $headers .= "\r\n" . "MIME-Version: 1.0";
            $headers .= "\r\n" . "Content-type:text/html;charset=UTF-8";

            // Send email
            $mail = mail($toEmail, $emailSubject, $htmlContent, $headers);
        }

        // If mail sent
        if ($mail) {
            echo 'Your ticket has been generated!';
        } else {
            echo 'Your Ticket submission failed, please try again.';
        }
    }
header("refresh:2;url=$urltoredirectafterwork");

function check_all_inputs($from, $priority, $regarding, $description)
{
    $errors = '';
    if ($from == '' || $priority == '' || $regarding == '' || $description == '') {
        $errors .= "All Fields are required.<br>";
    } else {
        $regarding = test_input($regarding);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $regarding)) {
            $errors .= "Only letters and white space allowed in Regarding Field.<br>";
        }
        $from = test_input($from);
        if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
            $errors .= "Invalid email format.<br>";
        }
        $description = test_input($description);
        if (!preg_match("/^[a-zA-Z-' 0-9.]*$/", $regarding)) {
            $errors .= "Only letters, Digits and white space allowed in Description Field.<br>";
        }
    }
    return $errors;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
