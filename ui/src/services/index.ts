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
