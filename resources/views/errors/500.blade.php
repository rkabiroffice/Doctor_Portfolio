<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen flex items-center justify-center px-6">
    <div class="max-w-xl text-center bg-white rounded-3xl shadow-sm border border-slate-100 p-10">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">500 Error</p>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">Something went wrong on our end.</h1>
        <p class="text-sm text-slate-600 mt-4">Please try again in a few moments. If the problem persists, contact the clinic administrator.</p>
        <a href="{{ route('home') }}" class="inline-flex mt-8 bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Return Home</a>
    </div>
</body>
</html>
