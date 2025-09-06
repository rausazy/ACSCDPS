<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-red-100 min-h-screen flex items-center justify-center">

    <div class="text-center">
        <h1 class="text-4xl font-bold text-red-600 mb-4">
            🚀 TailwindCSS is Working!
        </h1>
        <p class="text-lg text-blue-300">
            Kung blue ito at gray yung background, ibig sabihin ok na ang Tailwind.
        </p>

        <button class="mt-6 px-6 py-2 bg-orange-500 text-white font-bold rounded-lg shadow-md hover:bg-red-800 transition">
            Test Button
        </button>
    </div>

</body>
</html>
