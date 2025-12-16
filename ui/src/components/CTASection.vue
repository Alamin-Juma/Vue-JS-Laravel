<script setup lang="ts">
import { useFormModalStore } from '@/stores/formModal'

const formModal = useFormModalStore()
</script>

<template>
  <section class="bg-[#f0f1f2] py-12 px-4">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center  justify-around gap-8">
      <div>
        <h2 class="text-2xl md:text-3xl font-semibold text-blue-900">
          WOULD YOU LIKE TO<br />LEARN MORE?
        </h2>
      </div>
      <button @click="formModal.openModal" class="flex items-center justify-center bg-[#456276] border border-gray-200 rounded-md shadow-lg pr-8 pl-6 py-2 hover:shadow-xl transition-shadow duration-300 group w-full md:w-auto">
          <img src="/ben.jpg" alt="Ben's avatar" class="w-10 h-10 rounded-full mr-3 object-cover" />
          <span class="text-white font-bold group-hover:text-gray-100 transition-colors">Connect with Ben</span>
        </button>
    </div>
  </section>
</template>

<style scoped>
/* Component styles are handled by Tailwind CSS */
</style>
