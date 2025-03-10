<?php
class WorkspaceModel {
    private $workspaceDir;

    public function __construct() {
        $this->workspaceDir = WORKSPACE_DIR;
        $this->initializeWorkspace();
    }

    /**
     * Inicializa el directorio de workspace
     */
    private function initializeWorkspace() {
        if (!file_exists($this->workspaceDir)) {
            if (!mkdir($this->workspaceDir, 0777, true)) {
                throw new Exception('No se pudo crear el directorio workspace');
            }
        }
    }

    /**
     * Lee el contenido de un archivo
     */
    public function readFile($filePath) {
        try {
            $fullPath = $this->getFullPath($filePath);
            
            if (!file_exists($fullPath)) {
                throw new Exception('El archivo no existe');
            }

            $content = file_get_contents($fullPath);
            if ($content === false) {
                throw new Exception('Error al leer el archivo');
            }

            return $content;

        } catch (Exception $e) {
            error_log("Error en WorkspaceModel::readFile: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Escribe contenido en un archivo
     */
    public function writeFile($filePath, $content) {
        try {
            $fullPath = $this->getFullPath($filePath);
            
            // Crear directorios si no existen
            $dir = dirname($fullPath);
            if (!file_exists($dir)) {
                if (!mkdir($dir, 0777, true)) {
                    throw new Exception('Error al crear el directorio: ' . $dir);
                }
            }

            // Escribir el archivo
            if (file_put_contents($fullPath, $content) === false) {
                throw new Exception('Error al escribir el archivo: ' . $filePath);
            }

            // Establecer permisos
            chmod($fullPath, 0666);

            return true;

        } catch (Exception $e) {
            error_log("Error en WorkspaceModel::writeFile: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un archivo
     */
    public function deleteFile($filePath) {
        try {
            $fullPath = $this->getFullPath($filePath);
            
            if (!file_exists($fullPath)) {
                throw new Exception('El archivo no existe');
            }

            if (!unlink($fullPath)) {
                throw new Exception('Error al eliminar el archivo');
            }

            // Eliminar directorios vacíos
            $this->removeEmptyDirectories(dirname($fullPath));

            return true;

        } catch (Exception $e) {
            error_log("Error en WorkspaceModel::deleteFile: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lista archivos en un directorio
     */
    public function listFiles($directory = '') {
        try {
            $fullPath = $this->getFullPath($directory);
            
            if (!file_exists($fullPath)) {
                return [];
            }

            if (!is_dir($fullPath)) {
                throw new Exception('La ruta no es un directorio');
            }

            $files = [];
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($fullPath, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $files[] = substr($file->getPathname(), strlen($this->workspaceDir) + 1);
                }
            }

            return $files;

        } catch (Exception $e) {
            error_log("Error en WorkspaceModel::listFiles: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina directorios vacíos recursivamente
     */
    private function removeEmptyDirectories($dir) {
        if (!is_dir($dir)) {
            return;
        }

        $files = scandir($dir);
        if (count($files) <= 2) { // . y ..
            if (dirname($dir) !== $this->workspaceDir) {
                rmdir($dir);
                $this->removeEmptyDirectories(dirname($dir));
            }
        }
    }

    /**
     * Obtiene la ruta completa de un archivo
     */
    private function getFullPath($path) {
        $fullPath = $this->workspaceDir . '/' . ltrim($path, '/');
        
        // Validar que la ruta esté dentro del workspace
        $realPath = realpath(dirname($fullPath));
        if ($realPath === false || strpos($realPath, realpath($this->workspaceDir)) !== 0) {
            throw new Exception('Ruta no válida: fuera del workspace');
        }

        return $fullPath;
    }
}
?>
