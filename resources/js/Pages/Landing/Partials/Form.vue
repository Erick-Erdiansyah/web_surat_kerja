<template>
  <Head title="Welcome" />
  <div class="min-h-screen bg-gradient-to-b from-black to-gray-800 flex justify-center items-center">
    <div class="flex w-full justify-end pr-20">
      <div class="ml-12 w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-center mb-8">
          <button @click="Register = true" class="px-4 py-2 rounded-l-lg"
            :class="Register ? 'bg-gray-800 text-white' : 'bg-gray-300 text-gray-800'">
            Masuk
          </button>
          <button @click="Register = false" class="px-4 py-2 rounded-r-lg"
            :class="!Register ? 'bg-gray-800 text-white' : 'bg-gray-300 text-gray-800'">
            Registrasi
          </button>
        </div>

        <h2 class="text-3xl text-center mb-6">{{ Register ? 'Masuk' : 'Registrasi' }}</h2>

        <form @submit.prevent="submit">
          <input v-model="form.name" v-show="!Register" type="text" id="name" placeholder="Masukkan Nama" 
            :required="!Register" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300" />
          
          <input v-model="form.email" type="email" id="email" placeholder="Masukkan Email" required
            class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300" />

          <input v-model="form.password" type="password" id="password" placeholder="Masukkan Kata Sandi" required
            class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300" />

          <input v-model="form.password_confirmation" v-show="!Register" type="password" id="password_confirmation"
            :required="!Register" placeholder="Konfirmasi Kata Sandi"
            class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300" />

          <div v-show="Register" class="flex justify-between items-center mb-4">
            <a href="#" class="text-sm text-gray-500 hover:underline">Lupa Password?</a>
          </div>

          <div v-show="!Register" class="block mb-4">
            <label class="flex items-center">
              <Checkbox v-model:checked="form.remember" name="remember" />
              <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>
          </div>

          <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            {{ Register ? 'Masuk' : 'Registrasi' }}
          </PrimaryButton>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const Register = ref(true);
const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
  remember: false,
});

const submit = () => {
  if (Register.value) {
    form.post('/login', {
      onFinish: () => form.reset('password'),
    });
  } else {
    form.post('/register', {
      onFinish: () => form.reset('password', 'password_confirmation'),
    });
  }
};
</script>
