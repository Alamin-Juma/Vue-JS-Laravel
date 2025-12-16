<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink } from 'vue-router'

const isMenuOpen = ref(false)
</script>

<template>
    <nav class="w-full bg-white shadow-md relative">
        <div class="flex flex-col md:flex-row items-center justify-between px-6 py-4">
            <!-- Logo -->
            <h1 class="text-3xl md:text-7xl font-bold text-gray-800 mb-4 md:mb-0">LOGO</h1>

            <div class="flex flex-row items-center justify-around w-full md:w-auto md:justify-start md:space-x-8">
                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex flex-row items-center space-x-8">
                    <RouterLink to="/" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">HOME</RouterLink>
                    <RouterLink to="/shop" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">SHOP</RouterLink>
                    <RouterLink to="/about" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">ABOUT US</RouterLink>
                    <RouterLink to="/influencer" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">BE AN INFLUENCER</RouterLink>
                </div>

                <!-- Right Side: Hamburger (Mobile) + Icons -->
                <div class="flex flex-row items-center justify-between w-full md:w-auto md:justify-start md:space-x-4">
                    <!-- Hamburger Menu Button (Mobile Only) -->
                    <button @click="isMenuOpen = !isMenuOpen" class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
              <i class="pi pi-bars text-2xl"></i>
            </button>

                    <!-- Social Icons -->
                    <div class="flex flex-row items-center space-x-4">
                        <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors">
                <i class="pi pi-facebook text-xl"></i>
              </a>
                        <a href="#" class="text-gray-500 hover:text-blue-700 transition-colors">
                <i class="pi pi-linkedin text-xl"></i>
              </a>
                        <a href="#" class="text-gray-500 hover:text-blue-700 transition-colors">
                <i class="pi pi-hashtag text-xl"></i>
              </a>
                        <a href="#" class="text-gray-500 hover:text-blue-400 transition-colors">
                <i class="pi pi-twitter text-xl"></i>
              </a>
                    </div>
                </div>
            </div>


        </div>

        <!-- Mobile Menu Dropdown -->
        <div v-show="isMenuOpen" class="md:hidden absolute top-full left-0 w-full bg-white shadow-md flex flex-col py-4 px-6 space-y-4 z-50">
            <RouterLink to="/" class="text-gray-600 hover:text-gray-900 font-medium transition-colors block">HOME</RouterLink>
            <RouterLink to="/shop" class="text-gray-600 hover:text-gray-900 font-medium transition-colors block">SHOP</RouterLink>
            <RouterLink to="/about" class="text-gray-600 hover:text-gray-900 font-medium transition-colors block">ABOUT US</RouterLink>
            <RouterLink to="/influencer" class="text-gray-600 hover:text-gray-900 font-medium transition-colors block">BE AN INFLUENCER</RouterLink>
        </div>
    </nav>
</template>
