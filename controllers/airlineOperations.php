<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../models/Airline.php';

class AirlineController {
    private $airline;
    
    public function __construct() {
        try {
            $this->airline = new Airline();
        } catch (Exception $e) {
            $this->sendErrorResponse(500, "Database connection failed: " . $e->getMessage());
            exit;
        }
    }
    
    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        $segments = explode('/', trim($pathInfo, '/'));
        
        try {
            switch ($method) {
                case 'GET':
                    $this->handleGet($segments);
                    break;
                case 'POST':
                    $this->handlePost();
                    break;
                case 'PUT':
                    $this->handlePut($segments);
                    break;
                case 'DELETE':
                    $this->handleDelete($segments);
                    break;
                default:
                    $this->sendErrorResponse(405, "Method not allowed");
            }
        } catch (Exception $e) {
            $this->sendErrorResponse(500, $e->getMessage());
        }
    }
    
    private function handleGet($segments) {
        if (empty($segments[0])) {
            $airlines = $this->airline->getAllAirlines();
            $this->sendSuccessResponse($airlines, "Airlines retrieved successfully");
        } else if (is_numeric($segments[0])) {
            $id = (int)$segments[0];
            $airline = $this->airline->getAirlineById($id);
            
            if ($airline) {
                $this->sendSuccessResponse($airline, "Airline retrieved successfully");
            } else {
                $this->sendErrorResponse(404, "Airline not found");
            }
        } else {
            $this->sendErrorResponse(400, "Invalid airline ID");
        }
    }
    
    private function handlePost() {
        $input = $this->getJsonInput();
        
        if (!isset($input['airline_name']) || empty(trim($input['airline_name']))) {
            $this->sendErrorResponse(400, "Airline name is required");
            return;
        }
        
        $airlineName = trim($input['airline_name']);
        $logo = isset($input['logo']) ? trim($input['logo']) : null;
        
        $result = $this->airline->createAirline($airlineName, $logo);
        
        if ($result['success']) {
            $this->sendSuccessResponse([
                'message' => 'Airline created successfully',
                'affected_rows' => $result['affected_rows']
            ], "Airline created successfully", 201);
        } else {
            $this->sendErrorResponse(500, "Failed to create airline");
        }
    }
    
    private function handlePut($segments) {
        if (empty($segments[0]) || !is_numeric($segments[0])) {
            $this->sendErrorResponse(400, "Invalid airline ID");
            return;
        }
        
        $id = (int)$segments[0];
        $input = $this->getJsonInput();
        
        if (!isset($input['airline_name']) || empty(trim($input['airline_name']))) {
            $this->sendErrorResponse(400, "Airline name is required");
            return;
        }
        
        $existingAirline = $this->airline->getAirlineById($id);
        if (!$existingAirline) {
            $this->sendErrorResponse(404, "Airline not found");
            return;
        }
        
        $airlineName = trim($input['airline_name']);
        $logo = isset($input['logo']) ? trim($input['logo']) : null;
        
        $result = $this->airline->updateAirline($id, $airlineName, $logo);
        
        if ($result['success']) {
            $this->sendSuccessResponse([
                'message' => 'Airline updated successfully',
                'affected_rows' => $result['affected_rows']
            ], "Airline updated successfully");
        } else {
            $this->sendErrorResponse(500, "Failed to update airline");
        }
    }
    
    private function handleDelete($segments) {
        if (empty($segments[0]) || !is_numeric($segments[0])) {
            $this->sendErrorResponse(400, "Invalid airline ID");
            return;
        }
        
        $id = (int)$segments[0];
        
        $existingAirline = $this->airline->getAirlineById($id);
        if (!$existingAirline) {
            $this->sendErrorResponse(404, "Airline not found");
            return;
        }
        
        $result = $this->airline->deleteAirline($id);
        
        if ($result['success']) {
            $this->sendSuccessResponse([
                'message' => 'Airline deleted successfully',
                'affected_rows' => $result['affected_rows']
            ], "Airline deleted successfully");
        } else {
            $this->sendErrorResponse(500, "Failed to delete airline");
        }
    }
    
    private function getJsonInput() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->sendErrorResponse(400, "Invalid JSON input");
            exit;
        }
        
        return $data ?: [];
    }
    
    private function sendSuccessResponse($data, $message = "Success", $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s')
        ], JSON_PRETTY_PRINT);
    }
    
    private function sendErrorResponse($statusCode, $message) {
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'error',
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ], JSON_PRETTY_PRINT);
    }
}

$controller = new AirlineController();
$controller->handleRequest();
?>
