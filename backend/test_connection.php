<?php
// Plik testowy do sprawdzenia połączenia z bazą danych
// Użyj tego pliku aby zweryfikować czy backend działa poprawnie

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Test połączenia z bazą danych</h1>";

try {
    require_once 'config/database.php';
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if($conn) {
        echo "<p style='color: green;'>✅ Połączenie z bazą danych udane!</p>";
        
        // Test zapytania
        $query = "SELECT COUNT(*) as user_count FROM users";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<p>Liczba użytkowników w bazie: <strong>{$result['user_count']}</strong></p>";
        
        // Test modułów
        $query = "SELECT COUNT(*) as module_count FROM modules";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<p>Liczba modułów: <strong>{$result['module_count']}</strong></p>";
        
        // Test pakietów
        $query = "SELECT COUNT(*) as package_count FROM packages";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<p>Liczba pakietów: <strong>{$result['package_count']}</strong></p>";
        
        echo "<hr>";
        echo "<h2>Informacje o bazie danych:</h2>";
        echo "<p><strong>Host:</strong> " . $conn->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "</p>";
        echo "<p><strong>Wersja MySQL:</strong> " . $conn->getAttribute(PDO::ATTR_SERVER_VERSION) . "</p>";
        echo "<p><strong>Wersja PHP:</strong> " . phpversion() . "</p>";
        
    } else {
        echo "<p style='color: red;'>❌ Błąd połączenia z bazą danych</p>";
    }
    
} catch(Exception $e) {
    echo "<p style='color: red;'>❌ Błąd: " . $e->getMessage() . "</p>";
    echo "<p><strong>Szczegóły:</strong></p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<h2>Test API endpoints:</h2>";
echo "<p>Możesz przetestować API endpoints:</p>";
echo "<ul>";
echo "<li><strong>GET</strong> <a href='api/admin.php?action=dashboard_stats' target='_blank'>api/admin.php?action=dashboard_stats</a></li>";
echo "<li><strong>GET</strong> <a href='api/admin.php?action=default_checklists' target='_blank'>api/admin.php?action=default_checklists</a></li>";
echo "</ul>";

echo "<p><strong>Uwaga:</strong> Ten plik powinien zostać usunięty po wdrożeniu na produkcję!</p>";
?>

