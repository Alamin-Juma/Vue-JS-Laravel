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
                    <RouterLink to="/" class="text-[#416887] hover:text-[#2d4a5f] font-normal transition-colors text-[16px] leading-[100%] tracking-[0.02em]">HOME</RouterLink>
                    <RouterLink to="/shop" class="text-[#99A1A5] hover:text-gray-900 font-normal transition-colors text-[16px] leading-[100%] tracking-[0.02em]">SHOP</RouterLink>
                    <RouterLink to="/about" class="text-[#99A1A5] hover:text-gray-900 font-normal transition-colors text-[16px] leading-[100%] tracking-[0.02em]">ABOUT US</RouterLink>
                    <RouterLink to="/influencer" class="text-[#99A1A5] hover:text-gray-900 font-normal transition-colors text-[16px] leading-[100%] tracking-[0.02em]">BE AN INFLUENCER</RouterLink>
                    <RouterLink to="/reports/commission" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">COMMISSION REPORT</RouterLink>
                    <RouterLink to="/reports/top-distributors" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">TOP DISTRIBUTORS</RouterLink>
                </div>

                <!-- Right Side: Hamburger (Mobile) + Icons -->
                <div class="flex flex-row items-center justify-between w-full md:w-auto md:justify-start md:space-x-4">
                    <!-- Hamburger Menu Button (Mobile Only) -->
                    <button @click="isMenuOpen = !isMenuOpen" class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
              <i class="pi pi-bars text-2xl"></i>
            </button>

                    <!-- Social Icons -->
                    <div class="flex flex-row items-center space-x-4">
                        <a href="#" class="hover:opacity-80 transition-opacity">
                <img src="@/assets/icon-facebook.png" alt="Facebook" class="w-5 h-5" />
              </a>
                        <a href="#" class="hover:opacity-80 transition-opacity">
                <img src="@/assets/icon-linkedin.png" alt="LinkedIn" class="w-5 h-5" />
              </a>
                        <a href="#" class="hover:opacity-80 transition-opacity">
                <img src="@/assets/icon-slack.png" alt="Slack" class="w-5 h-5" />
              </a>
                        <a href="#" class="hover:opacity-80 transition-opacity">
                <img src="@/assets/icon-twitter.png" alt="Twitter" class="w-5 h-5" />
              </a>
                    </div>
                </div>
            </div>


        </div>

        <!-- Mobile Menu Dropdown -->
        <div v-show="isMenuOpen" class="md:hidden absolute top-full left-0 w-full bg-white shadow-md flex flex-col py-4 px-6 space-y-4 z-50">
            <RouterLink to="/" class="text-[#416887] hover:text-[#2d4a5f] font-normal transition-colors block">HOME</RouterLink>
            <RouterLink to="/shop" class="text-[#99A1A5] hover:text-gray-900 font-normal transition-colors block">SHOP</RouterLink>
            <RouterLink to="/about" class="text-[#99A1A5] hover:text-gray-900 font-normal transition-colors block">ABOUT US</RouterLink>
            <RouterLink to="/influencer" class="text-[#99A1A5] hover:text-gray-900 font-normal transition-colors block">BE AN INFLUENCER</RouterLink>
            <RouterLink to="/reports/commission" class="text-gray-600 hover:text-gray-900 font-medium transition-colors block">COMMISSION REPORT</RouterLink>
            <RouterLink to="/reports/top-distributors" class="text-gray-600 hover:text-gray-900 font-medium transition-colors block">TOP DISTRIBUTORS</RouterLink>
        </div>
    </nav>
</template>
