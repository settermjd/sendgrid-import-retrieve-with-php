<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('SENDGRID_API_KEY');

$sg = new \SendGrid($_ENV['SENDGRID_API_KEY']);
$jobId = "";

/**
 * Attempt to retrieve a SendGrid contact
 */
function retrieveContact(string $emailAddress, SendGrid $sg): string
{
    $requestBody = json_decode(
        sprintf(
            '{"emails": ["%s"]}',
            $emailAddress
        )
    );

    try {
        $response = $sg
            ->client
            ->marketing()
            ->contacts()
            ->search()
            ->emails()
            ->post($requestBody);
        return $response->body();
    } catch (Exception $ex) {
        echo 'Caught exception: ' . $ex->getMessage();
    }
    return $ex;
}

try {
    $response = $sg
        ->client
        ->marketing()
        ->contacts()
        ->imports()
        ->_($jobId)
        ->get();

    $contactData = json_decode(
        file_get_contents(
            __DIR__ . '/data/user_data.json'
        )
    );

    $emailAddress = $contactData->contacts[0]->email;
    $response = json_decode($response->body());
    return match ($response->status) {
        'completed' => retrieveContact($emailAddress, $sg),
        'pending' => 'Contact is not yet ready',
        'errored', 'failed' => 'The contact was not able to be imported',
    };
} catch (Exception $ex) {
    echo 'Caught exception: ' . $ex->getMessage();
}
