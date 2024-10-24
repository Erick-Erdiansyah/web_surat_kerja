<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Notification from '@/Pages/Notification.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useDark, useToggle } from '@vueuse/core'
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faMoon, faSun } from '@fortawesome/free-solid-svg-icons';
import { directive as VTippy } from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'

const imageDark = new URL('@/assets/images/logo_hitam.svg', import.meta.url);
const imageWhite = new URL('@/assets/images/logo_putih.svg', import.meta.url);


library.add(faMoon, faSun)

defineProps({
  title: String,
});

const showingNavigationDropdown = ref(false);
const isDark = useDark()
const toggleDark = useToggle(isDark)
const isActive = ref(isDark)


const logout = () => {
  router.post(route('logout'));
};

</script>

<template>
  <div>

    <Head :title="title" />

    <Banner />

    <div class="min-h-screen bg-gray-200 dark:bg-slate-300">
      <nav class="dark:bg-slate-800 bg-white border-b border-gray-100 dark:border-gray-600 w-full fixed top-0 z-50">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                <!-- <ApplicationMark class="block h-9 w-auto" /> -->
                <img :src="imageWhite" alt="img" class="h-20 mt-3 max-w-max hidden dark:block" />
                <img :src="imageDark" alt="img" class="h-20 mt-3 max-w-max block dark:hidden" />
                <!-- <h1 class="dark:text-white">gambar logo logo</h1> -->
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                  Beranda
                </NavLink>
                <NavLink :href="route('index')" :active="route().current('index')">
                  Surat
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
              <!-- Settings Dropdown -->
              <button @click="toggleDark()"
              class="px-4 py-2 dark:text-white rounded-lg dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-gray-700"
              v-tippy="{ content: 'Ganti tema', theme: 'dark', arrow: true, placement: 'bottom' }">
              <font-awesome-icon :icon="isActive ? ['far', 'sun'] : ['far', 'moon']" />
            </button>
            <Notification />
              <div class="ms-3 relative">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                      class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                      <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url"
                        :alt="$page.props.auth.user.name">
                    </button>

                    <span v-else class="inline-flex rounded-md">
                      <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-white dark:bg-slate-800 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        {{ $page.props.auth.user.name }}

                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Kelola akun
                    </div>

                    <DropdownLink :href="route('profile.show')">
                      Profil
                    </DropdownLink>

                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                      API Tokens
                    </DropdownLink>

                    <div class="border-t border-gray-200" />

                    <!-- Authentication -->
                    <form @submit.prevent="logout">
                      <DropdownLink as="button">
                        Keluar
                      </DropdownLink>
                    </form>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
              <button
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                @click="showingNavigationDropdown = !showingNavigationDropdown">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  <path :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
              Beranda
            </ResponsiveNavLink>
            <ResponsiveNavLink :href="route('index')" :active="route().current('index')">
              SK Elektro
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
              <div>
                <div class="font-medium text-base text-gray-800">
                  {{ $page.props.auth.user.name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                  {{ $page.props.auth.user.email }}
                </div>
              </div>
            </div>

            <div class="mt-3 space-y-1">
              <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')"
                :active="route().current('api-tokens.index')">
                API Tokens
              </ResponsiveNavLink>

              <!-- Authentication -->
              <form method="POST" @submit.prevent="logout">
                <ResponsiveNavLink as="button">
                  Log Out
                </ResponsiveNavLink>
              </form>
            </div>
          </div>
        </div>

        <!-- Page Heading -->
        <header v-if="$slots.header"
          class="bg-white dark:bg-slate-800 shadow border-t-2 border-gray-100 dark:border-t-gray-700">
          <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <slot name="header" />
          </div>
        </header>

      </nav>
      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
