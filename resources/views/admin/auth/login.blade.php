<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-md border border-slate-100 p-8">
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-700 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Doctor Admin Login</h1>
            <p class="text-sm text-slate-600 mt-2">Use the default admin credentials to manage the portfolio and clinics.</p>
        </div>

        @if($errors->any())
            <div class="mb-5 bg-red-50 text-red-700 border border-red-200 px-4 py-3 rounded-2xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', 'admin@business.com') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                <input type="password" name="password" value="admin123" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <button class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Sign In</button>
        </form>
    </div>
</body>
</html>
