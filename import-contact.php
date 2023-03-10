<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('SENDGRID_API_KEY');
$sg = new \SendGrid($_ENV['SENDGRID_API_KEY']);

$contactData = json_decode(
    file_get_contents(
        __DIR__ . '/data/user_data.json'
    )
);

try {
    $response = $sg
        ->client
        ->marketing()
        ->contacts()
        ->put($contactData);
    $response = json_decode($response->body());
    echo "Job ID is: {$response->job_id}\n";
} catch (Exception $ex) {
    echo 'Caught exception: '.  $ex->getMessage();
}