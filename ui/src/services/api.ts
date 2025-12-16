// API configuration
const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

// Helper function to handle API responses
const handleResponse = async (response: Response) => {
  if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || `HTTP Error: ${response.status}`)
  }
  return response.json()
}

// API Service
export const apiService = {
  // GET request
  async get(endpoint: string) {
    try {
      const response = await fetch(`${API_BASE_URL}${endpoint}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      })
      return handleResponse(response)
    } catch (error) {
      console.error('GET Error:', error)
      throw error
    }
  },

  // POST request
  async post(endpoint: string, data: any) {
    try {
      const response = await fetch(`${API_BASE_URL}${endpoint}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(data)
      })
      return handleResponse(response)
    } catch (error) {
      console.error('POST Error:', error)
      throw error
    }
  },

  // PUT request
  async put(endpoint: string, data: any) {
    try {
      const response = await fetch(`${API_BASE_URL}${endpoint}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(data)
      })
      return handleResponse(response)
    } catch (error) {
      console.error('PUT Error:', error)
      throw error
    }
  },

  // DELETE request
  async delete(endpoint: string) {
    try {
      const response = await fetch(`${API_BASE_URL}${endpoint}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      })
      return handleResponse(response)
    } catch (error) {
      console.error('DELETE Error:', error)
      throw error
    }
  }
}
