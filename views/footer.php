</main>

    <!-- Scripts personalizados -->
    <script src="assets/js/script.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Capturar elementos del DOM
            const chatForm = document.getElementById('chatForm');
            const messageInput = document.getElementById('messageInput');
            const chatMessages = document.getElementById('chatMessages');
            const typingIndicator = document.getElementById('typingIndicator');
            const toggleThemeBtn = document.getElementById('toggleTheme');
            const clearChatBtn = document.getElementById('clearChat');
            const togglePanelBtn = document.getElementById('togglePanelBtn');
            const filePanel = document.getElementById('filePanel');
            const closePanelBtn = document.getElementById('closePanelBtn');

            // Manejar errores de carga de recursos
            window.addEventListener('error', function(e) {
                if (e.target.tagName === 'LINK' || e.target.tagName === 'SCRIPT') {
                    console.warn('Error loading resource:', e.target.src || e.target.href);
                }
            }, true);

            // Manejar envío del formulario
            if (chatForm) {
                chatForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const message = messageInput.value.trim();
                    if (!message) return;

                    // Agregar mensaje del usuario
                    addMessage(message, true);
                    messageInput.value = '';

                    // Mostrar indicador de escritura
                    if (typingIndicator) {
                        typingIndicator.classList.remove('hidden');
                    }

                    try {
                        // Enviar mensaje al servidor
                        const response = await fetch('?action=chat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ message })
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        // Ocultar indicador de escritura
                        if (typingIndicator) {
                            typingIndicator.classList.add('hidden');
                        }

                        // Mostrar respuesta
                        if (data.success) {
                            const formattedResponse = formatMessage(data.response);
                            addMessage(formattedResponse);
                        } else {
                            addMessage(`<span class="text-red-500">Error: ${data.message}</span>`);
                        }

                    } catch (error) {
                        console.error('Error:', error);
                        if (typingIndicator) {
                            typingIndicator.classList.add('hidden');
                        }
                        addMessage('<span class="text-red-500">Error al procesar tu solicitud. Por favor, intenta de nuevo.</span>');
                    }
                });
            }

            // Función para agregar mensajes al chat
            function addMessage(content, isUser = false) {
                if (!chatMessages) return;

                const messageDiv = document.createElement('div');
                messageDiv.className = 'message flex items-start space-x-4' + (isUser ? ' justify-end' : '');
                
                const iconDiv = document.createElement('div');
                iconDiv.className = 'flex-shrink-0';
                iconDiv.innerHTML = isUser ? 
                    '<i class="fas fa-user text-2xl text-gray-500"></i>' : 
                    '<i class="fas fa-robot text-2xl text-blue-500"></i>';

                const contentDiv = document.createElement('div');
                contentDiv.className = 'flex-grow' + (isUser ? ' text-right' : '');

                const bubbleDiv = document.createElement('div');
                bubbleDiv.className = isUser ? 
                    'bg-blue-500 text-white rounded-lg p-4 shadow-sm inline-block' : 
                    'bg-gray-100 text-gray-800 rounded-lg p-4 shadow-sm';
                bubbleDiv.innerHTML = content;

                const timeDiv = document.createElement('div');
                timeDiv.className = 'text-xs text-gray-500 mt-1';
                timeDiv.textContent = isUser ? 'Tú • Ahora' : 'Sistema • Ahora';

                if (isUser) {
                    contentDiv.appendChild(bubbleDiv);
                    contentDiv.appendChild(timeDiv);
                    messageDiv.appendChild(contentDiv);
                    messageDiv.appendChild(iconDiv);
                } else {
                    messageDiv.appendChild(iconDiv);
                    contentDiv.appendChild(bubbleDiv);
                    contentDiv.appendChild(timeDiv);
                    messageDiv.appendChild(contentDiv);
                }

                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Cambiar tema
            if (toggleThemeBtn) {
                toggleThemeBtn.addEventListener('click', function() {
                    document.documentElement.classList.toggle('dark');
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-moon');
                        icon.classList.toggle('fa-sun');
                    }
                });
            }

            // Limpiar chat
            if (clearChatBtn && chatMessages) {
                clearChatBtn.addEventListener('click', function() {
                    if (confirm('¿Estás seguro de que quieres limpiar el chat?')) {
                        chatMessages.innerHTML = '';
                        // Agregar mensaje de bienvenida nuevamente
                        addMessage(`
                            <p>¡Bienvenido al AI Web System Generator! 👋<br>
                            Puedo ayudarte a crear, editar y gestionar sistemas web. Por ejemplo, puedes pedirme:</p>
                            <ul class="mt-2 space-y-1">
                                <li><i class="fas fa-code mr-2 text-blue-500"></i>"Crear una página de inicio con header y footer"</li>
                                <li><i class="fas fa-edit mr-2 text-green-500"></i>"Editar el archivo style.css para cambiar los colores"</li>
                                <li><i class="fas fa-trash mr-2 text-red-500"></i>"Eliminar el archivo temporal.txt"</li>
                            </ul>
                            <p class="mt-2">¿Qué te gustaría hacer hoy?</p>
                        `);
                    }
                });
            }

            // Panel de archivos
            if (togglePanelBtn && filePanel) {
                togglePanelBtn.addEventListener('click', function() {
                    filePanel.classList.toggle('translate-x-full');
                });
            }

            if (closePanelBtn && filePanel) {
                closePanelBtn.addEventListener('click', function() {
                    filePanel.classList.add('translate-x-full');
                });
            }

            // Cargar lista de archivos inicial
            if (typeof loadFileList === 'function') {
                loadFileList();
            }
        });
    </script>
</body>
</html>
