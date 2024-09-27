<template>
  <div class="min-h-screen bg-gradient-to-b from-black to-orange-800 flex justify-center items-center">
    <div class="flex w-full justify-end pr-20">
      <div class="ml-12 w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-center mb-8">
          <button class="px-4 py-2 bg-gray-800 text-white rounded-l-lg">Masuk</button>
          <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded-r-lg">Registrasi</button>
        </div>
        <h2 class="text-3xl text-center mb-6">Register</h2>
        <form>
          <input type="email" placeholder="Masukkan Email"
            class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300" />
          <input type="password" placeholder="Masukkan Password"
            class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300" />
          <div class="flex justify-between items-center mb-4">
            <a href="#" class="text-sm text-gray-500 hover:underline">Lupa Password?</a>
          </div>
          <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded-lg hover:bg-gray-700">
            Masuk
          </button>
        </form>
      </div>
    </div>
  </div>
</template>