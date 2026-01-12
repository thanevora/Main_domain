<?php
session_start();
header('Content-Type: application/json');
include("../main_connection.php");

$db_name = "rest_soliera_usm";
$conn = $connections[$db_name] ?? die(json_encode(['error' => 'Database connection failed']));

// Handle CORS properly
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        getCards();
        break;
    case 'POST':
        createCard($input);
        break;
    case 'PUT':
        updateCard($input);
        break;
    case 'DELETE':
        deleteCard($input['id'] ?? 0);
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function getCards() {
    global $conn;
    
    $sql = "SELECT * FROM dashboard_cards ORDER BY display_order, title";
    $result = $conn->query($sql);
    
    $cards = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Decode features JSON
            $row['features'] = json_decode($row['features'], true);
            $cards[] = $row;
        }
    }
    
    echo json_encode($cards);
}

function createCard($data) {
    global $conn;
    
    // Validate required fields - REMOVED ICON VALIDATION
    if (empty($data['title']) || empty($data['description']) || empty($data['redirect_link'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }
    
    $title = $conn->real_escape_string($data['title']);
    $description = $conn->real_escape_string($data['description']);
    $redirect_link = $conn->real_escape_string($data['redirect_link']);
    
    // Handle features
    if (isset($data['features']) && is_string($data['features'])) {
        // Convert string to array if it's from textarea
        $featuresArray = array_map('trim', explode("\n", $data['features']));
        $features = json_encode($featuresArray);
    } else if (isset($data['features']) && is_array($data['features'])) {
        $features = json_encode($data['features']);
    } else {
        $features = json_encode([]);
    }
    
    $is_active = isset($data['is_active']) ? intval($data['is_active']) : 1;
    
    // Use default icon 'layout-dashboard'
    $icon = 'layout-dashboard';
    
    $sql = "INSERT INTO dashboard_cards (title, icon, description, redirect_link, features, is_active) 
            VALUES ('$title', '$icon', '$description', '$redirect_link', '$features', $is_active)";
    
    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'id' => $conn->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $conn->error]);
    }
}

function updateCard($data) {
    global $conn;
    
    if (empty($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing card ID']);
        return;
    }
    
    $id = intval($data['id']);
    $title = $conn->real_escape_string($data['title'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');
    $redirect_link = $conn->real_escape_string($data['redirect_link'] ?? '');
    
    // Handle features
    if (isset($data['features']) && is_string($data['features'])) {
        // Convert string to array if it's from textarea
        $featuresArray = array_map('trim', explode("\n", $data['features']));
        $features = json_encode($featuresArray);
    } else if (isset($data['features']) && is_array($data['features'])) {
        $features = json_encode($data['features']);
    } else {
        $features = '[]';
    }
    
    $is_active = isset($data['is_active']) ? intval($data['is_active']) : 1;
    
    // Build update query
    $updates = [];
    if (!empty($title)) $updates[] = "title = '$title'";
    if (!empty($description)) $updates[] = "description = '$description'";
    if (!empty($redirect_link)) $updates[] = "redirect_link = '$redirect_link'";
    if (!empty($features)) $updates[] = "features = '$features'";
    if (isset($data['is_active'])) $updates[] = "is_active = $is_active";
    
    // Always update the timestamp
    $updates[] = "updated_at = CURRENT_TIMESTAMP";
    
    if (empty($updates)) {
        echo json_encode(['success' => true]); // Nothing to update
        return;
    }
    
    $sql = "UPDATE dashboard_cards SET " . implode(', ', $updates) . " WHERE id = $id";
    
    if ($conn->query($sql)) {
        if ($conn->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => true, 'message' => 'No changes made']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $conn->error]);
    }
}

function deleteCard($id) {
    global $conn;
    
    $id = intval($id);
    
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid card ID']);
        return;
    }
    
    $sql = "DELETE FROM dashboard_cards WHERE id = $id";
    
    if ($conn->query($sql)) {
        if ($conn->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Card not found']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $conn->error]);
    }
}

// Close connection
$conn->close();
?>