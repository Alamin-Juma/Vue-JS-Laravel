<script setup lang="ts">
import { ref, reactive, onMounted, watch } from 'vue'
import {
  commissionReportService,
  type CommissionReportItem,
  type OrderItem,
  type Pagination,
  type CommissionReportFilters
} from '@/services'

// State
const reportData = ref<CommissionReportItem[]>([])
const pagination = ref<Pagination>({
  current_page: 1,
  per_page: 15,
  total: 0,
  last_page: 1,
  from: null,
  to: null
})
const loading = ref(false)
const error = ref<string | null>(null)

// Filters
const filters = reactive<CommissionReportFilters>({
  distributor: '',
  date_from: '',
  date_to: '',
  invoice: '',
  per_page: 15
})

// Expanded rows for order items
const expandedRows = ref<Set<string>>(new Set())
const orderItems = ref<Record<string, OrderItem[]>>({})
const loadingItems = ref<Set<string>>(new Set())

// Fetch commission report
async function fetchReport(page = 1) {
  loading.value = true
  error.value = null

  try {
    const response = await commissionReportService.getReport({
      ...filters,
      page
    })

    if (response.success) {
      reportData.value = response.data
      pagination.value = response.pagination
    } else {
      error.value = response.message || 'Failed to fetch report'
    }
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'An error occurred'
  } finally {
    loading.value = false
  }
}

// Toggle row expansion for order items
async function toggleRowExpansion(invoice: string) {
  if (expandedRows.value.has(invoice)) {
    expandedRows.value.delete(invoice)
    expandedRows.value = new Set(expandedRows.value)
  } else {
    expandedRows.value.add(invoice)
    expandedRows.value = new Set(expandedRows.value)

    // Fetch order items if not already loaded
    if (!orderItems.value[invoice]) {
      await fetchOrderItems(invoice)
    }
  }
}

// Fetch order items for a specific invoice
async function fetchOrderItems(invoice: string) {
  loadingItems.value.add(invoice)

  try {
    const response = await commissionReportService.getOrderItems(invoice)

    if (response.success && response.data) {
      orderItems.value[invoice] = response.data.items
    }
  } catch (err) {
    console.error(`Failed to fetch order items for ${invoice}:`, err)
  } finally {
    loadingItems.value.delete(invoice)
    loadingItems.value = new Set(loadingItems.value)
  }
}

// Apply filters
function applyFilters() {
  fetchReport(1)
}

// Clear filters
function clearFilters() {
  filters.distributor = ''
  filters.date_from = ''
  filters.date_to = ''
  filters.invoice = ''
  fetchReport(1)
}

// Pagination handlers
function goToPage(page: number) {
  if (page >= 1 && page <= pagination.value.last_page) {
    fetchReport(page)
  }
}

function previousPage() {
  if (pagination.value.current_page > 1) {
    goToPage(pagination.value.current_page - 1)
  }
}

function nextPage() {
  if (pagination.value.current_page < pagination.value.last_page) {
    goToPage(pagination.value.current_page + 1)
  }
}

// Generate page numbers for pagination
function getPageNumbers(): (number | string)[] {
  const pages: (number | string)[] = []
  const current = pagination.value.current_page
  const last = pagination.value.last_page

  if (last <= 7) {
    for (let i = 1; i <= last; i++) {
      pages.push(i)
    }
  } else {
    pages.push(1)

    if (current > 3) {
      pages.push('...')
    }

    const start = Math.max(2, current - 1)
    const end = Math.min(last - 1, current + 1)

    for (let i = start; i <= end; i++) {
      pages.push(i)
    }

    if (current < last - 2) {
      pages.push('...')
    }

    pages.push(last)
  }

  return pages
}

// Load report on mount
onMounted(() => {
  fetchReport()
})
</script>

<template>
  <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Commission Report</h1>
        <p class="mt-2 text-gray-600">
          View and filter commission reports for all orders in the system.
        </p>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Search Filters</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Distributor Filter -->
          <div>
            <label for="distributor" class="block text-sm font-medium text-gray-700 mb-1">
              Distributor
            </label>
            <input
              id="distributor"
              v-model="filters.distributor"
              type="text"
              placeholder="ID, First Name, or Last Name"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>

          <!-- Date From Filter -->
          <div>
            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">
              Date From
            </label>
            <input
              id="date_from"
              v-model="filters.date_from"
              type="date"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>

          <!-- Date To Filter -->
          <div>
            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">
              Date To
            </label>
            <input
              id="date_to"
              v-model="filters.date_to"
              type="date"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>

          <!-- Invoice Filter -->
          <div>
            <label for="invoice" class="block text-sm font-medium text-gray-700 mb-1">
              Invoice (Optional)
            </label>
            <input
              id="invoice"
              v-model="filters.invoice"
              type="text"
              placeholder="Invoice number"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>

        <!-- Filter Actions -->
        <div class="mt-4 flex flex-wrap gap-3">
          <button
            @click="applyFilters"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
          >
            <i class="pi pi-search mr-2"></i>
            Search
          </button>
          <button
            @click="clearFilters"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors"
          >
            <i class="pi pi-times mr-2"></i>
            Clear Filters
          </button>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Error State -->
      <div
        v-else-if="error"
        class="bg-red-50 border border-red-200 rounded-lg p-6 text-center text-red-700"
      >
        <i class="pi pi-exclamation-triangle text-2xl mb-2"></i>
        <p>{{ error }}</p>
        <button
          @click="fetchReport()"
          class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
        >
          Try Again
        </button>
      </div>

      <!-- Report Table -->
      <div v-else class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Table Header Info -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex justify-between items-center">
            <p class="text-sm text-gray-600">
              Showing {{ pagination.from || 0 }} to {{ pagination.to || 0 }} of
              {{ pagination.total }} records
            </p>
            <div class="flex items-center gap-2">
              <label for="perPage" class="text-sm text-gray-600">Per page:</label>
              <select
                id="perPage"
                v-model.number="filters.per_page"
                @change="fetchReport(1)"
                class="px-2 py-1 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
              >
                <option :value="10">10</option>
                <option :value="15">15</option>
                <option :value="25">25</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-100">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-10">
                  <!-- Expand column -->
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Invoice
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Purchaser
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Distributor
                </th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Referred Distributors
                </th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Order Date
                </th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Percentage
                </th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Order Total
                </th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Commission
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <template v-for="item in reportData" :key="item.invoice">
                <!-- Main Row -->
                <tr
                  class="hover:bg-gray-50 cursor-pointer transition-colors"
                  @click="toggleRowExpansion(item.invoice)"
                >
                  <td class="px-4 py-4 whitespace-nowrap">
                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                      <i
                        :class="[
                          'pi transition-transform duration-200',
                          expandedRows.has(item.invoice) ? 'pi-chevron-down' : 'pi-chevron-right'
                        ]"
                      ></i>
                    </button>
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                    {{ item.invoice }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ item.purchaser }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ item.distributor || '-' }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                    {{ item.referred_distributors }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ item.order_date }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                    {{ item.percentage }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                    ${{ item.order_total }}
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                    ${{ item.commission }}
                  </td>
                </tr>

                <!-- Expanded Row - Order Items -->
                <tr v-if="expandedRows.has(item.invoice)">
                  <td colspan="9" class="px-4 py-4 bg-gray-50">
                    <div class="ml-8">
                      <h4 class="text-sm font-semibold text-gray-700 mb-3">Order Items</h4>

                      <!-- Loading Order Items -->
                      <div v-if="loadingItems.has(item.invoice)" class="flex items-center gap-2 text-gray-500">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                        <span>Loading items...</span>
                      </div>

                      <!-- Order Items Table -->
                      <table v-else-if="orderItems[item.invoice]?.length" class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-md">
                        <thead class="bg-gray-100">
                          <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                              SKU
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                              Product Name
                            </th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">
                              Price
                            </th>
                            <th class="px-4 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                              Quantity
                            </th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">
                              Total
                            </th>
                          </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                          <tr v-for="orderItem in orderItems[item.invoice]" :key="orderItem.sku">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ orderItem.sku }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ orderItem.product_name }}</td>
                            <td class="px-4 py-2 text-sm text-right text-gray-700">${{ orderItem.price }}</td>
                            <td class="px-4 py-2 text-sm text-center text-gray-700">{{ orderItem.quantity }}</td>
                            <td class="px-4 py-2 text-sm text-right font-medium text-gray-900">${{ orderItem.total }}</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- No Items -->
                      <p v-else class="text-sm text-gray-500 italic">No items found for this order.</p>
                    </div>
                  </td>
                </tr>
              </template>

              <!-- Empty State -->
              <tr v-if="reportData.length === 0">
                <td colspan="9" class="px-4 py-12 text-center text-gray-500">
                  <i class="pi pi-inbox text-4xl mb-3 block"></i>
                  <p>No records found</p>
                  <p class="text-sm mt-1">Try adjusting your search filters</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div
          v-if="pagination.last_page > 1"
          class="px-6 py-4 border-t border-gray-200 bg-gray-50"
        >
          <div class="flex items-center justify-between">
            <button
              @click="previousPage"
              :disabled="pagination.current_page === 1"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Previous
            </button>

            <div class="flex items-center gap-1">
              <template v-for="page in getPageNumbers()" :key="page">
                <span v-if="page === '...'" class="px-3 py-2 text-gray-500">...</span>
                <button
                  v-else
                  @click="goToPage(page as number)"
                  :class="[
                    'px-3 py-2 text-sm font-medium rounded-md',
                    page === pagination.current_page
                      ? 'bg-blue-600 text-white'
                      : 'text-gray-700 hover:bg-gray-100'
                  ]"
                >
                  {{ page }}
                </button>
              </template>
            </div>

            <button
              @click="nextPage"
              :disabled="pagination.current_page === pagination.last_page"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
