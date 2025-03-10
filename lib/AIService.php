<?php
class AIService {
    private $apiKey;

    public function __construct() {
        $this->apiKey = AI_API_KEY;
    }

    /**
     * Envía una solicitud a la IA y obtiene una respuesta
     */
    public function sendRequest($prompt) {
        try {
            // Por ahora, implementamos una versión simulada
            // En una implementación real, aquí se conectaría con una API de IA
            return $this->simulateAIResponse($prompt);

        } catch (Exception $e) {
            error_log("Error en AIService::sendRequest: " . $e->getMessage());
            throw new Exception('Error al procesar la solicitud con la IA: ' . $e->getMessage());
        }
    }

    /**
     * Simula una respuesta de IA para desarrollo y pruebas
     */
    private function simulateAIResponse($prompt) {
        $prompt = strtolower($prompt);
        
        // Patrones de comandos comunes
        if (strpos($prompt, 'crear') !== false) {
            if (strpos($prompt, 'página') !== false || strpos($prompt, 'pagina') !== false) {
                return [
                    'action' => 'create',
                    'message' => 'Entendido, voy a crear una nueva página web.',
                    'file_path' => 'workspace/index.html',
                    'content' => $this->generateHTMLTemplate(),
                    'suggestions' => [
                        'Puedes pedirme modificar los colores',
                        'Puedo agregar más secciones',
                        'Puedo modificar el diseño'
                    ]
                ];
            }
        } 
        elseif (strpos($prompt, 'editar') !== false) {
            return [
                'action' => 'edit',
                'message' => 'De acuerdo, ¿qué cambios específicos te gustaría hacer?',
                'suggestions' => [
                    'Especifica qué elementos quieres modificar',
                    'Puedo cambiar colores, textos o estructura'
                ]
            ];
        }
        elseif (strpos($prompt, 'eliminar') !== false || strpos($prompt, 'borrar') !== false) {
            return [
                'action' => 'delete',
                'message' => '¿Estás seguro de que quieres eliminar? Esta acción no se puede deshacer.',
                'suggestions' => [
                    'Confirma el nombre del archivo a eliminar',
                    'Puedo hacer una copia de seguridad antes'
                ]
            ];
        }

        // Respuesta por defecto
        return [
            'action' => 'chat',
            'message' => 'No estoy seguro de qué quieres hacer. ¿Podrías ser más específico?',
            'suggestions' => [
                'Prueba diciendo "Crear una página web"',
                'O "Editar el archivo style.css"',
                'O "Eliminar archivo.txt"'
            ]
        ];
    }

    /**
     * Genera una plantilla HTML básica
     */
    private function generateHTMLTemplate() {
        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Web</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-globe text-blue-500 text-2xl mr-2"></i>
                    <h1 class="text-xl font-semibold text-gray-900">Mi Sitio Web</h1>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-600 hover:text-gray-900">Inicio</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900">Acerca</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900">Servicios</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900">Contacto</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <section class="text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Bienvenido a Mi Sitio</h2>
            <p class="text-xl text-gray-600 mb-8">Un lugar donde tus ideas cobran vida</p>
            <button class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
                Comenzar
            </button>
        </section>

        <section class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <i class="fas fa-rocket text-blue-500 text-3xl mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Rápido</h3>
                <p class="text-gray-600">Optimizado para velocidad y rendimiento.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <i class="fas fa-shield-alt text-blue-500 text-3xl mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Seguro</h3>
                <p class="text-gray-600">Protección y seguridad garantizadas.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <i class="fas fa-magic text-blue-500 text-3xl mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Intuitivo</h3>
                <p class="text-gray-600">Diseñado pensando en el usuario.</p>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">Sobre Nosotros</h4>
                    <p class="text-gray-400">Creando experiencias web únicas y memorables.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Inicio</a></li>
                        <li><a href="#" class="hover:text-white">Servicios</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                        <li><a href="#" class="hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> info@ejemplo.com</li>
                        <li><i class="fas fa-phone mr-2"></i> (123) 456-7890</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Ciudad, País</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Síguenos</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; 2024 Mi Sitio Web. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
HTML;
    }
}
?>
