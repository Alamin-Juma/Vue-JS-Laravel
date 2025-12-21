<template>
  <section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
      <!-- Section Title -->
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-semibold text-[#416887] mb-4">
          WHAT'S YOUR INFLUENCE?
        </h2>
        <p class="text-gray-600 text-center">
          <span class="block">Is this you? Could this be you?</span>
          <span class="block">Are you ready to be an influencer?</span>
        </p>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-md md:max-w-none mx-auto md:mx-0">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow w-full">
          <div class="relative overflow-hidden bg-gray-200 h-100">
            <img
              src="/face3.png"
              alt="Grace Perez"
              class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
            />
          </div>
          <div class="p-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden">
                <img
                  src="/face3.png"
                  alt="Grace Perez avatar"
                  class="w-full h-full object-cover"
                />
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Grace Perez</h3>
                <p class="text-sm text-gray-500">@graceperez</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow w-full">
          <div class="relative overflow-hidden bg-gray-200 h-100">
            <img
              src="/face1.png"
              alt="Bella Marie"
              class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
            />
          </div>
          <div class="p-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden">
                <img
                  src="/face1.png"
                  alt="Bella Marie avatar"
                  class="w-full h-full object-cover"
                />
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Bella Marie</h3>
                <p class="text-sm text-gray-500">@bellamarie</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow w-full">
          <div class="relative overflow-hidden bg-gray-200 h-100">
            <img
              src="/face2.png"
              alt="Gigi Hadid"
              class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
            />
          </div>
          <div class="p-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden">
                <img
                  src="/face2.png"
                  alt="Gigi Hadid avatar"
                  class="w-full h-full object-cover"
                />
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Gigi Hadid</h3>
                <p class="text-sm text-gray-500">@gigihadid</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
// InfluenceSection component
</script>

<style scoped>
/* Component styles are handled by Tailwind CSS */
</style>
