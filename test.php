<?php
// test.php - Database connection test with nice UI
require_once 'config/database.php';

// Function to get table information
function getTableInfo($conn, $tableName) {
    // Get row count
    $stmt = $conn->query("SELECT COUNT(*) as count FROM $tableName");
    $rowCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get column information
    $stmt = $conn->query("DESCRIBE $tableName");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return [
        'rowCount' => $rowCount,
        'columns' => $columns
    ];
}

// Status variables
$connectionStatus = false;
$errorMessage = '';
$dbInfo = [];
$driversInfo = [];
$passengersInfo = [];

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    // Try a simple query to confirm connection
    $stmt = $conn->query("SELECT 1");
    $connectionStatus = true;
    
    // Get database info
    $stmt = $conn->query("SELECT DATABASE() as db_name");
    $dbInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get table info
    $driversInfo = getTableInfo($conn, 'drivers');
    $passengersInfo = getTableInfo($conn, 'passengers');
    
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scuber - Database Test</title>
    <style>
        :root {
            --primary-color: #4a86e8;
            --secondary-color: #6aa84f;
            --danger-color: #e06666;
            --bg-color: #f7f9fc;
            --card-bg: white;
            --text-color: #333;
            --border-color: #e0e0e0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
            text-align: center;
        }
        
        h1, h2, h3 {
            margin-top: 0;
        }
        
        .card {
            background-color: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        
        .status-success {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .status-error {
            background-color: var(--danger-color);
            color: white;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            padding: 10px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .json-field {
            color: #9900cc;
            font-style: italic;
        }
        
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            font-size: 0.9em;
            color: #777;
        }
        
        .button {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
        }
        
        .button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Scuber Database Test</h1>
            <p>Testing connection to MySQL database</p>
        </header>
        
        <div class="card">
            <div class="card-header">
                Connection Status
                <?php if ($connectionStatus): ?>
                    <span class="status status-success">Connected</span>
                <?php else: ?>
                    <span class="status status-error">Error</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if ($connectionStatus): ?>
                    <p>Successfully connected to database: <strong><?php echo $dbInfo['db_name']; ?></strong></p>
                <?php else: ?>
                    <p>Failed to connect to the database:</p>
                    <p class="status-error"><?php echo $errorMessage; ?></p>
                    <p>Please check your database configuration in config/database.php</p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($connectionStatus): ?>
            <div class="card">
                <div class="card-header">
                    Drivers Table
                    <span class="status status-success"><?php echo $driversInfo['rowCount']; ?> Records</span>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Column Name</th>
                                    <th>Type</th>
                                    <th>Null</th>
                                    <th>Key</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($driversInfo['columns'] as $column): ?>
                                <tr>
                                    <td>
                                        <?php echo $column['Field']; ?>
                                        <?php if ($column['Field'] === 'musicTastes'): ?>
                                            <span class="json-field">(JSON)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $column['Type']; ?></td>
                                    <td><?php echo $column['Null']; ?></td>
                                    <td><?php echo $column['Key']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    Passengers Table
                    <span class="status status-success"><?php echo $passengersInfo['rowCount']; ?> Records</span>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Column Name</th>
                                    <th>Type</th>
                                    <th>Null</th>
                                    <th>Key</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($passengersInfo['columns'] as $column): ?>
                                <tr>
                                    <td>
                                        <?php echo $column['Field']; ?>
                                        <?php if ($column['Field'] === 'musicTastes'): ?>
                                            <span class="json-field">(JSON)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $column['Type']; ?></td>
                                    <td><?php echo $column['Null']; ?></td>
                                    <td><?php echo $column['Key']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        <?php endif; ?>
        
        <footer>
            Scuber Database Test &copy; <?php echo date('Y'); ?>
        </footer>
    </div>
</body>
</html>