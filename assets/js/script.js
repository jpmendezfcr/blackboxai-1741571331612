// Funciones para manejar archivos
async function editFile(filePath) {
    try {
        const response = await fetch('?action=readFile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ path: filePath })
        });
        
        const data = await response.json();
        if (data.success) {
            // Aquí se podría implementar un editor de código
            console.log('Contenido del archivo:', data.content);
        } else {
            alert('Error al leer el archivo: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    }
}

async function deleteFile(filePath) {
    if (!confirm(`¿Estás seguro de que quieres eliminar ${filePath}?`)) {
        return;
    }

    try {
        const response = await fetch('?action=deleteFile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ path: filePath })
        });
        
        const data = await response.json();
        if (data.success) {
            loadFileList(); // Recargar la lista de archivos
            alert('Archivo eliminado correctamente');
        } else {
            alert('Error al eliminar el archivo: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    }
}

// Función para cargar la lista de archivos
async function loadFileList() {
    try {
        const response = await fetch('?action=listFiles', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();
        
        if (data.success) {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = data.files
                .map(file => `
                    <div class="flex items-center justify-between p-2 hover:bg-gray-100 rounded">
                        <span class="truncate">
                            <i class="fas fa-file-code text-blue-500 mr-2"></i>
                            ${file}
                        </span>
                        <div class="flex space-x-2">
                            <button class="text-gray-500 hover:text-blue-500" onclick="editFile('${file}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-gray-500 hover:text-red-500" onclick="deleteFile('${file}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `)
                .join('');
        }
    } catch (error) {
        console.error('Error al cargar la lista de archivos:', error);
    }
}

// Función para manejar el modo oscuro
function toggleDarkMode() {
    const html = document.documentElement;
    html.classList.toggle('dark');
    
    // Guardar preferencia en localStorage
    const isDark = html.classList.contains('dark');
    localStorage.setItem('darkMode', isDark);
}

// Inicializar modo oscuro según preferencia guardada
function initDarkMode() {
    const isDark = localStorage.getItem('darkMode') === 'true';
    if (isDark) {
        document.documentElement.classList.add('dark');
    }
}

// Función para formatear mensajes del chat
function formatMessage(message, isSystem = false) {
    if (typeof message === 'string') {
        return message;
    }

    let formattedMessage = '';
    
    if (message.action) {
        formattedMessage += `<div class="font-semibold ${isSystem ? 'text-blue-600' : 'text-gray-800'}">${message.message}</div>`;
        
        if (message.suggestions && message.suggestions.length > 0) {
            formattedMessage += '<ul class="mt-2 space-y-1">';
            message.suggestions.forEach(suggestion => {
                formattedMessage += `<li><i class="fas fa-lightbulb text-yellow-500 mr-2"></i>${suggestion}</li>`;
            });
            formattedMessage += '</ul>';
        }
    } else {
        formattedMessage = JSON.stringify(message, null, 2);
    }

    return formattedMessage;
}

// Exportar funciones para uso global
window.editFile = editFile;
window.deleteFile = deleteFile;
window.loadFileList = loadFileList;
window.toggleDarkMode = toggleDarkMode;
window.formatMessage = formatMessage;

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initDarkMode();
    loadFileList();
});
