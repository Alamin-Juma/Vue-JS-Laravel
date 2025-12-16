import { apiService } from './api'

// Types
export interface FormSubmission {
  firstName: string
  lastName: string
  phone: string
  email: string
  agreeToTerms: boolean
}

export interface FormResponse {
  success: boolean
  message: string
  data?: any
}

export interface Product {
  id: number
  name: string
  description: string
  image: string
}

export interface Influencer {
  id: number
  name: string
  username: string
  image: string
}

// Form Service
export const formService = {
  // Submit registration form
  async submitRegistration(formData: FormSubmission): Promise<FormResponse> {
    try {
      const response = await apiService.post('/register', formData)
      return response
    } catch (error) {
      console.error('Form submission error:', error)
      throw error
    }
  },

  // Subscribe to newsletter
  async subscribeNewsletter(email: string): Promise<FormResponse> {
    try {
      const response = await apiService.post('/subscribe', { email })
      return response
    } catch (error) {
      console.error('Newsletter subscription error:', error)
      throw error
    }
  }
}

// Product Service
export const productService = {
  // Get all products
  async getProducts(): Promise<Product[]> {
    try {
      const response = await apiService.get('/products')
      return response.data || []
    } catch (error) {
      console.error('Fetch products error:', error)
      return []
    }
  },

  // Get single product
  async getProduct(id: number): Promise<Product | null> {
    try {
      const response = await apiService.get(`/products/${id}`)
      return response.data || null
    } catch (error) {
      console.error('Fetch product error:', error)
      return null
    }
  }
}

// Influencer Service
export const influencerService = {
  // Get all influencers
  async getInfluencers(): Promise<Influencer[]> {
    try {
      const response = await apiService.get('/influencers')
      return response.data || []
    } catch (error) {
      console.error('Fetch influencers error:', error)
      return []
    }
  },

  // Get single influencer
  async getInfluencer(id: number): Promise<Influencer | null> {
    try {
      const response = await apiService.get(`/influencers/${id}`)
      return response.data || null
    } catch (error) {
      console.error('Fetch influencer error:', error)
      return null
    }
  }
}

// Commission Report Types
export interface CommissionReportItem {
  invoice: string
  purchaser: string
  purchaser_id: number | null
  distributor: string | null
  distributor_id: number | null
  referred_distributors: number
  order_date: string
  percentage: string
  order_total: string
  commission: string
}

export interface OrderItem {
  sku: string
  product_name: string
  price: string
  quantity: number
  total: string
}

export interface Pagination {
  current_page: number
  per_page: number
  total: number
  last_page: number
  from: number | null
  to: number | null
}

export interface CommissionReportFilters {
  distributor?: string
  date_from?: string
  date_to?: string
  invoice?: string
  per_page?: number
  page?: number
}

export interface CommissionReportResponse {
  success: boolean
  message: string
  data: CommissionReportItem[]
  pagination: Pagination
}

export interface OrderItemsResponse {
  success: boolean
  message: string
  data: {
    invoice: string
    items: OrderItem[]
  }
}

// Commission Report Service
export const commissionReportService = {
  // Get commission report with filters
  async getReport(filters: CommissionReportFilters = {}): Promise<CommissionReportResponse> {
    try {
      const queryParams = new URLSearchParams()

      if (filters.distributor) queryParams.append('distributor', filters.distributor)
      if (filters.date_from) queryParams.append('date_from', filters.date_from)
      if (filters.date_to) queryParams.append('date_to', filters.date_to)
      if (filters.invoice) queryParams.append('invoice', filters.invoice)
      if (filters.per_page) queryParams.append('per_page', filters.per_page.toString())
      if (filters.page) queryParams.append('page', filters.page.toString())

      const queryString = queryParams.toString()
      const endpoint = `/v1/reports/commission${queryString ? `?${queryString}` : ''}`

      const response = await apiService.get(endpoint)
      return response
    } catch (error) {
      console.error('Fetch commission report error:', error)
      throw error
    }
  },

  // Get order items for a specific invoice
  async getOrderItems(invoice: string): Promise<OrderItemsResponse> {
    try {
      const response = await apiService.get(`/v1/reports/commission/orders/${invoice}/items`)
      return response
    } catch (error) {
      console.error('Fetch order items error:', error)
      throw error
    }
  }
}
