<?php
require_once __DIR__ . '/../lib/AIService.php';
require_once __DIR__ . '/FileController.php';

class ChatController {
    private $aiService;
    private $fileController;

    public function __construct() {
        $this->aiService = new AIService();
        $this->fileController = new FileController();
    }

    public function processChat($message) {
        try {
            if (empty($message)) {
                throw new Exception('El mensaje no puede estar vacío');
            }

            // Obtener respuesta de la IA
            $aiResponse = $this->aiService->sendRequest($message);
            
            // Si la respuesta es un string, convertirlo a array
            if (is_string($aiResponse)) {
                $aiResponse = [
                    'message' => $aiResponse,
                    'action' => 'chat'
                ];
            }

            // Procesar la respuesta según el tipo de acción
            switch ($aiResponse['action'] ?? 'chat') {
                case 'create':
                    if (isset($aiResponse['file_path']) && isset($aiResponse['content'])) {
                        $this->fileController->createFile($aiResponse['file_path'], $aiResponse['content']);
                    }
                    break;
                    
                case 'edit':
                    if (isset($aiResponse['file_path']) && isset($aiResponse['content'])) {
                        $this->fileController->editFile($aiResponse['file_path'], $aiResponse['content']);
                    }
                    break;
                    
                case 'delete':
                    if (isset($aiResponse['file_path'])) {
                        $this->fileController->deleteFile($aiResponse['file_path']);
                    }
                    break;
            }

            // Preparar respuesta para el cliente
            return [
                'success' => true,
                'response' => [
                    'message' => $aiResponse['message'] ?? 'Procesado correctamente',
                    'action' => $aiResponse['action'] ?? 'chat',
                    'suggestions' => $aiResponse['suggestions'] ?? []
                ]
            ];

        } catch (Exception $e) {
            error_log("Error en ChatController: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function formatResponse($response) {
        if (is_string($response)) {
            return [
                'message' => $response,
                'action' => 'chat'
            ];
        }
        return $response;
    }

    private function validateMessage($message) {
        if (empty($message)) {
            throw new Exception('El mensaje no puede estar vacío');
        }
        if (strlen($message) > 1000) {
            throw new Exception('El mensaje es demasiado largo');
        }
        return true;
    }
}
?>
