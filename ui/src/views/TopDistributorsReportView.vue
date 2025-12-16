<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

interface Distributor {
  rank: number
  distributor_id: number
  distributor_name: string
  total_sales: string
  total_sales_raw: number
}

interface ApiResponse {
  success: boolean
  message: string
  data: Distributor[]
  pagination: {
    current_page: number
    per_page: number
    total: number
    last_page: number
  }
}

const distributors = ref<Distributor[]>([])
const loading = ref(false)
const error = ref<string | null>(null)

// Pagination
const currentPage = ref(1)
const perPage = ref(20)
const totalRecords = ref(0)
const lastPage = ref(1)

const apiBaseUrl = import.meta.env.VITE_API_URL || 'http://localhost/api'

const fetchTopDistributors = async (page: number = 1) => {
  loading.value = true
  error.value = null

  try {
    const response = await axios.get<ApiResponse>(
      `${apiBaseUrl}/v1/reports/top-distributors`,
      {
        params: {
          page,
          per_page: perPage.value,
        },
      }
    )

    if (response.data.success) {
      distributors.value = response.data.data
      currentPage.value = response.data.pagination.current_page
      totalRecords.value = response.data.pagination.total
      lastPage.value = response.data.pagination.last_page
    } else {
      error.value = 'Failed to fetch top distributors'
    }
  } catch (err: any) {
    error.value = err.response?.data?.message || 'An error occurred while fetching data'
    console.error('Error fetching top distributors:', err)
  } finally {
    loading.value = false
  }
}

const goToPage = (page: number) => {
  if (page >= 1 && page <= lastPage.value) {
    fetchTopDistributors(page)
  }
}

const nextPage = () => {
  if (currentPage.value < lastPage.value) {
    goToPage(currentPage.value + 1)
  }
}

const prevPage = () => {
  if (currentPage.value > 1) {
    goToPage(currentPage.value - 1)
  }
}

onMounted(() => {
  fetchTopDistributors()
})
</script>

<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Top Distributors Report</h1>
        <p class="mt-2 text-sm text-gray-600">
          Top 200 distributors ranked by total sales (includes tied rankings)
        </p>
      </div>

      <!-- Error Message -->
      <div v-if="error" class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
        {{ error }}
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Table -->
      <div v-else class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Rank
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Distributor Name
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Total Sales
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="distributor in distributors"
                :key="distributor.distributor_id"
                class="hover:bg-gray-50"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ distributor.rank }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ distributor.distributor_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-semibold">
                  ${{ distributor.total_sales }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div
          class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
        >
          <div class="flex-1 flex justify-between sm:hidden">
            <button
              @click="prevPage"
              :disabled="currentPage === 1"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Previous
            </button>
            <button
              @click="nextPage"
              :disabled="currentPage === lastPage"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ (currentPage - 1) * perPage + 1 }}</span>
                to
                <span class="font-medium">{{
                  Math.min(currentPage * perPage, totalRecords)
                }}</span>
                of
                <span class="font-medium">{{ totalRecords }}</span>
                distributors
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <button
                  @click="prevPage"
                  :disabled="currentPage === 1"
                  class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span class="sr-only">Previous</span>
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path
                      fill-rule="evenodd"
                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </button>

                <!-- Page numbers -->
                <button
                  v-for="page in Math.min(5, lastPage)"
                  :key="page"
                  @click="goToPage(page)"
                  :class="[
                    'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                    page === currentPage
                      ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                      : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                  ]"
                >
                  {{ page }}
                </button>

                <button
                  @click="nextPage"
                  :disabled="currentPage === lastPage"
                  class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span class="sr-only">Next</span>
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path
                      fill-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
