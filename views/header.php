<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Web System Generator</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:,">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <script>
        // Configuración de Tailwind
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    
    <style>
        /* Estilos críticos inline para evitar FOUC */
        body {
            font-family: 'Inter', sans-serif;
            opacity: 0;
            animation: fadeIn 0.3s ease-in forwards;
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        
        .chat-container {
            height: calc(100vh - 180px);
        }
        
        .chat-messages {
            height: calc(100% - 70px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-robot mr-2 text-blue-500"></i>
                    AI Web System Generator
                </h1>
                <div class="flex items-center space-x-4">
                    <button id="clearChat" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <button id="toggleTheme" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
