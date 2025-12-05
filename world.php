<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

$host = 'localhost';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

$country = isset($_GET['country']) ? $_GET['country'] : "";
$lookup  = isset($_GET['lookup']) ? $_GET['lookup'] : "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($lookup === "cities") {

        // CITY LOOKUP USING JOIN
        $stmt = $pdo->prepare("
            SELECT cities.name, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country
        ");

        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // OUTPUT CITIES TABLE
        if ($results) {
            echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>District</th>
                        <th>Population</th>
                    </tr>";

            foreach ($results as $row) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['district']}</td>
                        <td>{$row['population']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No cities found.";
        }

    } else {

        // COUNTRY LOOKUP
        if (!empty($country)) {
            $stmt = $pdo->prepare("
                SELECT name, continent, independence_year, head_of_state 
                FROM countries 
                WHERE name LIKE :country
            ");
            $stmt->execute(['country' => "%$country%"]);
        } else {
            $stmt = $pdo->query("
                SELECT name, continent, independence_year, head_of_state 
                FROM countries
            ");
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // OUTPUT COUNTRIES TABLE
        if ($results) {
            echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>Continent</th>
                        <th>Independence</th>
                        <th>Head of State</th>
                    </tr>";

            foreach ($results as $row) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['continent']}</td>
                        <td>{$row['independence_year']}</td>
                        <td>{$row['head_of_state']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No results found.";
        }
    }

} catch (PDOException $e) {
    echo "Database error.";
}
?>
