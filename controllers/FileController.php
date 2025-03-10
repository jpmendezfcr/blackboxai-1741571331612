<?php
require_once __DIR__ . '/../models/WorkspaceModel.php';

class FileController {
    private $workspaceModel;

    public function __construct() {
        $this->workspaceModel = new WorkspaceModel();
    }

    /**
     * Crea un nuevo archivo en el workspace
     */
    public function createFile($filePath, $content) {
        try {
            // Validar el path
            $this->validatePath($filePath);

            // Crear el archivo
            $result = $this->workspaceModel->writeFile($filePath, $content);

            return [
                'success' => true,
                'message' => 'Archivo creado correctamente',
                'path' => $filePath
            ];

        } catch (Exception $e) {
            error_log("Error en FileController::createFile: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Edita un archivo existente
     */
    public function editFile($filePath, $content) {
        try {
            // Validar el path
            $this->validatePath($filePath);

            // Verificar que el archivo existe
            if (!file_exists(WORKSPACE_DIR . '/' . $filePath)) {
                throw new Exception('El archivo no existe');
            }

            // Editar el archivo
            $result = $this->workspaceModel->writeFile($filePath, $content);

            return [
                'success' => true,
                'message' => 'Archivo actualizado correctamente',
                'path' => $filePath
            ];

        } catch (Exception $e) {
            error_log("Error en FileController::editFile: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Elimina un archivo del workspace
     */
    public function deleteFile($filePath) {
        try {
            // Validar el path
            $this->validatePath($filePath);

            // Verificar que el archivo existe
            if (!file_exists(WORKSPACE_DIR . '/' . $filePath)) {
                throw new Exception('El archivo no existe');
            }

            // Eliminar el archivo
            $result = $this->workspaceModel->deleteFile($filePath);

            return [
                'success' => true,
                'message' => 'Archivo eliminado correctamente',
                'path' => $filePath
            ];

        } catch (Exception $e) {
            error_log("Error en FileController::deleteFile: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Lista los archivos en el workspace
     */
    public function listFiles() {
        try {
            $files = $this->workspaceModel->listFiles();
            return [
                'success' => true,
                'files' => $files
            ];
        } catch (Exception $e) {
            error_log("Error en FileController::listFiles: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Lee el contenido de un archivo
     */
    public function readFile($filePath) {
        try {
            // Validar el path
            $this->validatePath($filePath);

            // Leer el archivo
            $content = $this->workspaceModel->readFile($filePath);

            return [
                'success' => true,
                'content' => $content,
                'path' => $filePath
            ];

        } catch (Exception $e) {
            error_log("Error en FileController::readFile: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Valida que el path sea seguro
     */
    private function validatePath($filePath) {
        // Prevenir directory traversal
        if (strpos($filePath, '..') !== false) {
            throw new Exception('Path no válido: contiene ".."');
        }

        // Verificar caracteres no permitidos
        if (preg_match('/[<>:"\\|?*]/', $filePath)) {
            throw new Exception('Path no válido: contiene caracteres no permitidos');
        }

        // Verificar extensión de archivo permitida
        $allowedExtensions = ['html', 'css', 'js', 'php', 'txt', 'json', 'md'];
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception('Extensión de archivo no permitida');
        }

        return true;
    }
}
?>
