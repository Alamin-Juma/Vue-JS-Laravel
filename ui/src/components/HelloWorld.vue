<template>
  <div class="font-sans text-gray-800 antialiased">
    <header class="flex justify-between items-center py-5 px-4 md:px-12 border-b border-gray-100">
      <div class="text-2xl font-black tracking-tighter">
        LOGO
      </div>
      <nav class="hidden md:flex space-x-8 text-sm font-medium uppercase">
        <a href="#" class="hover:text-blue-700 transition duration-150">Home</a>
        <a href="#" class="hover:text-blue-700 transition duration-150">Shop</a>
        <a href="#" class="hover:text-blue-700 transition duration-150">About Us</a>
        <a href="#" class="hover:text-blue-700 transition duration-150">Be An Influencer</a>
      </nav>

      <div class="flex space-x-4 text-gray-500 text-lg">
        <span class="hover:text-gray-900 cursor-pointer">📧</span>
        <span class="hover:text-gray-900 cursor-pointer">🔗</span>
        <span class="hover:text-gray-900 cursor-pointer">📱</span>
      </div>
    </header>

    <section class="flex flex-col md:flex-row justify-between items-start py-8 md:py-16 px-4 md:px-12 bg-white">

      <div class="w-full md:w-5/12 pt-10 md:pt-20 pb-8 md:pb-0 z-10 relative">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-blue-800 tracking-tighter">
          COLLAGEN IS <br> THE FOUNTAIN <br> OF YOUTH
        </h1>
        <p class="mt-4 text-xl text-gray-600">
          WHAT'S YOUR INFLUENCE?
        </p>

        <button class="mt-8 flex items-center px-6 py-3 bg-blue-800 text-white rounded-full text-base font-semibold shadow-lg hover:bg-blue-700 transition duration-300">
          <img src="../../public/ben.jpg" alt="Ben's avatar" class="w-7 h-7 rounded-full mr-3 object-cover">
          Connect with Ben
        </button>

        <div class="absolute -left-16 bottom-0 opacity-70 w-24 h-24 bg-contain bg-no-repeat" style="background-image: url('/assets/feather-icon.png');"></div>
      </div>

      <div class="w-full md:w-6/12 mt-6 md:mt-0">
        <img src="../../public/hafface.png" alt="Beautiful woman's face, close-up" class="w-full h-auto object-cover max-h-[600px]">
      </div>
    </section>

    <section class="py-16 px-4 md:px-12 bg-gray-50">
      <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-semibold tracking-wide text-gray-900 mb-6 uppercase">
          CONGRATULATIONS
        </h2>
        <div class="text-lg leading-relaxed text-gray-600">
          <p class="mb-5">
            You are among the very first to learn of **NXM**, a superior luxury & lifestyle brand developed by some of the greatest minds in the industry.
          </p>
          <p>
            Launching with a perfect trio of proprietary, results-driven beauty products, NXM is primed to cause major disruption in the direct-selling industry with its hybrid, influencer marketing platform and rewards system.
          </p>
        </div>
      </div>
    </section>

  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'LandingPageSection',
});
</script>
