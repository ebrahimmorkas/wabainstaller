<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard — SimpleWaba</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
  <div class="max-w-3xl mx-auto p-8">
    <div class="bg-white rounded-xl shadow p-6">
      <h1 class="text-2xl font-bold mb-2">Welcome 👋</h1>
      <p class="text-gray-600">You’re logged in.</p>

      <form action="{{ route('logout') }}" method="post" class="mt-6">
        @csrf
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Logout</button>
      </form>
    </div>
  </div>
</body>
</html>
