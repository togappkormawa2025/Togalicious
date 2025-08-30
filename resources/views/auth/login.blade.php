<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-cover-custom {
            background-image: url('{{ asset('images/bg-jamu.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        .backdrop-blur {
            backdrop-filter: blur(14px);
        }
    </style>
</head>
<body class="bg-cover-custom min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white/80 backdrop-blur rounded-2xl shadow-2xl p-8 border border-white/40">
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-800">TOGALICIOUS</h2>
                <p class="text-sm text-gray-600 mt-2">Masuk sebagai <span class="font-semibold">Kasir</span> atau <span class="font-semibold">Admin</span></p>
            </div>

            @error('email')
                <div class="text-red-500 text-sm text-center">{{ $message }}</div>
            @enderror

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required autofocus placeholder="Masukkan Email Anda"
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white/90 shadow-sm" />
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative mt-1">
                    <input type="password" name="password" id="password" required placeholder="********"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white/90 shadow-sm" />
                    <!-- Toggle Eye Icon -->
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065
                                7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tombol Login -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-2.5 rounded-lg shadow-md transition duration-150 ease-in-out">
                Login
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.965
                                    9.965 0 012.189-3.368m2.83-2.547A9.956 9.956 0 0112 5c4.477 0 8.268
                                    2.943 9.542 7a9.956 9.956 0 01-4.046 5.073M15 12a3 3 0 11-6
                                    0 3 3 0 016 0z"/>`;
            } else {
                passwordInput.type = "password";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268
                                    2.943 9.542 7-1.274 4.057-5.065
                                    7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</body>
</html>
