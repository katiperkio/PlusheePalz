<?php
include 'connect.php';
require '../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

session_start();

// Initialize the S3 Client

$s3 = new S3Client([
    'version' => 'latest',
    'region' => $_ENV['AWS_REGION'],
    'credentials' => [
        'key' => $_ENV['AWS_ACCESS_KEY_ID'],
        'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
    ],
]);



$bucketName = $_ENV['AWS_BUCKET_NAME'];

function sanitizeFileName($string)
{
    return preg_replace("/[^a-zA-Z0-9_\-]/", "_", strtolower($string));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get data from the form
    $palz_name = $_POST['palz_name'];
    $palz_age = !empty($_POST['palz_age']) ? $_POST['palz_age'] : null;
    $palz_birthday = !empty($_POST['palz_birthday']) ? $_POST['palz_birthday'] : null;
    $created_by = $_SESSION['id'];
    $palz_nature = $_POST['palz_nature'] ?? []; // Traits
    $palz_loves = $_POST['palz_loves'] ?? [];   // Likes
    $palz_hates = $_POST['palz_hates'] ?? [];   // Dislikes
    if (!empty($_FILES['file'])) {
        $file = $_FILES['file']['tmp_name'];
        $originalFileName = $_FILES['file']['name'];
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        $fileName = sanitizeFileName($palz_name) . "-" . date('Y-m-d-H-i-s') . "." . $fileExtension;

        try {
            $result = $s3->putObject([
                'Bucket' => $bucketName,
                'Key' => $fileName,
                'SourceFile' => $file,
                'ACL' => 'public-read'
            ]);

            $s3Url = $result['ObjectURL'];

            $image_url = "https://" . $bucketName . ".s3." . $_ENV['AWS_REGION'] . ".amazonaws.com/" . $fileName;


            // Insert into palz table
            $sql = "INSERT INTO palz (name, age, birthday, created_by, image_url) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssis", $palz_name, $palz_age, $palz_birthday, $created_by, $image_url);
            $stmt->execute();

            // Get the inserted palz_id
            $palz_id = $stmt->insert_id;

            // Insert traits into palz_nature table
            $sql_nature = "INSERT INTO palz_nature (palz_id, nature_id) VALUES (?, ?)";
            $stmt_nature = $connection->prepare($sql_nature);
            foreach ($palz_nature as $nature_id) {
                $stmt_nature->bind_param("ii", $palz_id, $nature_id);
                $stmt_nature->execute();
            }

            // Insert likes and dislikes into palz_preferences table
            $sql_preferences = "INSERT INTO palz_preferences (palz_id, preference_id, type) VALUES (?, ?, ?)";
            $stmt_preferences = $connection->prepare($sql_preferences);

            // Insert likes with type 'like'
            foreach ($palz_loves as $preference_id) {
                $type = 'like';
                $stmt_preferences->bind_param("iis", $palz_id, $preference_id, $type);
                $stmt_preferences->execute();
            }

            // Insert dislikes with type 'dislike'
            foreach ($palz_hates as $preference_id) {
                $type = 'dislike';
                $stmt_preferences->bind_param("iis", $palz_id, $preference_id, $type);
                $stmt_preferences->execute();
            }

            // Commit the transaction
            $connection->commit();

            echo "Palz added successfully!";
            $_SESSION['add_palz'] = "success";
            header("Location:" . BASE_URL . "/index.php");
        } catch (Exception $e) {
            // Rollback transaction on failure
            $connection->rollback();
            echo "Error adding Palz: " . $e->getMessage();
        } finally {
            // Close all statements
            $stmt->close();
            $stmt_nature->close();
            $stmt_preferences->close();
        }
    }

    // Start a transaction to ensure all inserts are successful
    $connection->begin_transaction();
}

$connection->close();
