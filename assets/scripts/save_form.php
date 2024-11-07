<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitCounter = 0;

    $formData = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['number'],
        'rating' => $_POST['rating']
    ];

    $formValuesString = json_encode($formData, JSON_PRETTY_PRINT);

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

    file_put_contents($fileName, $formValuesString);

    echo "Form submitted successfully.";
}
?>