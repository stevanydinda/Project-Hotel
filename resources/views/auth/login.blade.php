<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | ASTON</title>
  <link rel="shortcut icon"
    href="https://play-lh.googleusercontent.com/FcRZx_UEXN2uc7uKM5EKGn7Jmb65c8VVELlmligxdfUcjKKIpzFX0SHXFePllD2g4ik"
    type="image/x-icon">

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">

    {{-- ALERT --}}
    @if (Session::get('success'))
      <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">
        {{ Session::get('success') }}
      </div>
    @endif

    @if (Session::get('error'))
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg">
        {{ Session::get('error') }}
      </div>
    @endif

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login to ASTON 🔑</h2>

    <form method="POST" action="{{ route('login.auth') }}" enctype="multipart/form-data" class="space-y-5">
      @csrf

      {{-- Email --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 @error('email') border-red-500 @enderror"
          required>
        @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 @error('password') border-red-500 @enderror"
          required>
        @error('password')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>


      {{-- Tombol Login --}}
      <button type="submit"
        class="w-full bg-yellow-400 text-gray-900 font-semibold py-2 rounded-lg hover:bg-yellow-500 transition shadow-md">
        Login
      </button>

      {{-- Link Kembali --}}
      <div class="text-center mt-3">
        <a href="{{ route('home') }}" class="text-gray-500 text-sm hover:text-yellow-500">← Kembali</a>
      </div>

    </form>
  </div>

</body>
</html>
