<template>
  <section class="relative w-full min-h-150 bg-white overflow-hidden flex items-center">
    <!-- Feather Image (Bottom Left) -->
    <img src="/feather.png" alt="Feather" class="absolute -bottom-32 -left-32 w-2/3 md:w-1/2 max-w-[700px] z-0 pointer-events-none" />

    <!-- Half Face Image (Left) with Gradient Overlay on Mobile -->
    <div class="absolute left-43 -top-30 h-[200%] w-full md:hidden z-0 pointer-events-none">
      <img src="/hafface.png" alt="Face" class="w-full h-full object-contain object-left-top" />
      <!-- White Gradient Overlay (Mobile only) -->
      <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-white pointer-events-none"></div>
    </div>

    <!-- Half Face Image (Right) on Desktop -->
    <div class="hidden md:block absolute right-0 -top-90 h-[160%] w-1/2 z-0 pointer-events-none">
      <img src="/hafface.png" alt="Face" class="w-full h-full object-contain object-right-top" />
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-screen-xl mx-auto px-6 md:px-12 flex flex-col justify-center h-full text-left md:ml-20">
      <div class="max-w-lg">
        <h1 class="text-4xl md:text-6xl font-semibold text-blue-900 leading-tight mb-4">
          COLLAGEN IS <br />
          THE FOUNTAIN <br />
          OF YOUTH
        </h1>
        <p class="text-xl text-gray-600 mb-8 tracking-widest uppercase">WHAT'S YOUR INFLUENCE?</p>

        <button @click="formModal.openModal" class="flex items-center justify-center bg-[#456276] border border-gray-200 rounded-md shadow-lg pr-8 pl-6 py-2 hover:shadow-xl transition-shadow duration-300 group w-full md:w-auto">
          <img src="/ben.jpg" alt="Ben's avatar" class="w-10 h-10 rounded-full mr-3 object-cover" />
          <span class="text-white font-bold group-hover:text-gray-100 transition-colors">Connect with Ben</span>
        </button>
      </div>
    </div>
  </section>
  <!-- Congratulations Section -->
    <section class="max-w-screen-xl flex flex-col items-center justify-center mx-auto px-6 md:px-12 py-16 md:py-24">
      <h2 class="text-4xl md:text-5xl font-semibold text-blue-900 mb-8">CONGRATULATIONS</h2>
      <p class="text-lg text-gray-700 leading-relaxed max-w-3xl items-center justify-center text-center">
        You are among the very first to learn of NXM,
        a superior luxury & lifestyle brand developed by some of the greatest minds in the industry.
        <br /><br />
        Launching with a perfect trio of proprietary, results-driven beauty products, NXM is primed to cause major disruption in the direct-selling industry with its hybrid, influencer marketing platform and rewards system.
      </p>
    </section>
</template>

<script setup lang="ts">
import { useFormModalStore } from '@/stores/formModal'

const formModal = useFormModalStore()
</script>
