<?php
session_start();
require_once 'config.php';

// Cargar controladores
require_once 'controllers/ChatController.php';
require_once 'controllers/FileController.php';

// Inicializar controladores
$chatController = new ChatController();
$fileController = new FileController();

// Manejar peticiones AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    
    $action = $_GET['action'] ?? '';
    
    switch ($action) {
        case 'chat':
            // Obtener el cuerpo de la solicitud JSON
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (!$data || !isset($data['message'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Datos de solicitud inválidos'
                ]);
                exit;
            }
            
            $result = $chatController->processChat($data['message']);
            echo json_encode($result);
            break;
            
        case 'listFiles':
            try {
                $workspaceModel = new WorkspaceModel();
                $files = $workspaceModel->listFiles();
                echo json_encode([
                    'success' => true,
                    'files' => $files
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Acción no válida'
            ]);
    }
    exit;
}

// Renderizar vista principal
require_once 'views/header.php';
require_once 'views/chat.php';
require_once 'views/footer.php';
?>
