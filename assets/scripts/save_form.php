<?php
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $submitCounter = 0;

    // User form data
    $formData = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['number'] ?? '',
        'rating' => $_POST['rating'] ?? ''
    ];

    // Additional request, browser, and connection data
    $requestData = [
        'user_ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'request_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'] ?? time()),
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'unknown',
        'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'unknown',
        'encoding' => $_SERVER['HTTP_ACCEPT_ENCODING'] ?? 'unknown',
        'connection_type' => $_SERVER['HTTP_CONNECTION'] ?? 'unknown',
        'server_protocol' => $_SERVER['SERVER_PROTOCOL'] ?? 'unknown',
        'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
        'query_string' => $_SERVER['QUERY_STRING'] ?? '',
        'server_name' => $_SERVER['SERVER_NAME'] ?? 'unknown',
        'server_address' => $_SERVER['SERVER_ADDR'] ?? 'unknown',
        'server_port' => $_SERVER['SERVER_PORT'] ?? 'unknown',
        'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'unknown',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
        'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'unknown',
        'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 'unknown'
    ];

    // Session data (if any)
    session_start(); // Start session if not already started
    $sessionData = $_SESSION ?? []; // All session data

    // Cookie data (if any)
    $cookieData = $_COOKIE ?? []; // All cookies

    // Combine all data into a single array for logging
    $combinedData = [
        'form_data' => $formData,
        'request_data' => $requestData,
        'session_data' => $sessionData,
        'cookie_data' => $cookieData
    ];

    // Convert data to JSON format for easier readability
    $formValuesString = json_encode($combinedData, JSON_PRETTY_PRINT);

    // Ensure the results directory exists
    $resultsDir = 'results';
    if (!is_dir($resultsDir)) {
        mkdir($resultsDir, 0777, true);
    }

    // Find a unique file name
    do {
        $fileName = $resultsDir . '/umfrage_fussabdruck' . $submitCounter . '.txt';
        $submitCounter++;
    } while (file_exists($fileName));

    // Save the JSON data to the file
    file_put_contents($fileName, $formValuesString);

    echo "Form submitted successfully.";
} else {
    echo "This page can only be accessed through a POST request.";
}
?>
