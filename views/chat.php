<div class="bg-white rounded-lg shadow-lg p-6 chat-container">
            <!-- Área de mensajes -->
            <div class="chat-messages overflow-y-auto mb-4 p-4 space-y-4" id="chatMessages">
                <!-- Mensaje de bienvenida -->
                <div class="message flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-robot text-2xl text-blue-500"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="bg-gray-100 rounded-lg p-4 shadow-sm">
                            <p class="text-gray-800">
                                ¡Bienvenido al AI Web System Generator! 👋<br>
                                Puedo ayudarte a crear, editar y gestionar sistemas web. Por ejemplo, puedes pedirme:
                            </p>
                            <ul class="mt-2 space-y-1 text-gray-700">
                                <li><i class="fas fa-code mr-2 text-blue-500"></i>"Crear una página de inicio con header y footer"</li>
                                <li><i class="fas fa-edit mr-2 text-green-500"></i>"Editar el archivo style.css para cambiar los colores"</li>
                                <li><i class="fas fa-trash mr-2 text-red-500"></i>"Eliminar el archivo temporal.txt"</li>
                            </ul>
                            <p class="mt-2 text-gray-800">
                                ¿Qué te gustaría hacer hoy?
                            </p>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Sistema • Ahora
                        </div>
                    </div>
                </div>
            </div>

            <!-- Área de entrada de mensaje -->
            <div class="border-t pt-4">
                <form id="chatForm" class="flex space-x-4">
                    <div class="flex-grow relative">
                        <input 
                            type="text" 
                            id="messageInput"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Escribe tu mensaje aquí..."
                            autocomplete="off"
                        >
                        <div id="typingIndicator" class="hidden absolute right-3 top-3">
                            <div class="typing-indicator">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <button 
                        type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                    >
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar
                    </button>
                </form>
            </div>
        </div>

        <!-- Panel de archivos (oculto por defecto) -->
        <div id="filePanel" class="hidden fixed right-0 top-0 h-full w-80 bg-white shadow-lg transform transition-transform duration-300 ease-in-out translate-x-full">
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Archivos del Workspace</h2>
                    <button id="closePanelBtn" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="fileList" class="space-y-2">
                    <!-- Los archivos se cargarán dinámicamente aquí -->
                </div>
            </div>
        </div>

        <!-- Botón flotante para mostrar/ocultar panel de archivos -->
        <button 
            id="togglePanelBtn"
            class="fixed bottom-6 right-6 bg-blue-500 text-white rounded-full p-4 shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
        >
            <i class="fas fa-folder"></i>
        </button>
