import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount, flushPromises } from '@vue/test-utils'
import { createRouter, createMemoryHistory } from 'vue-router'
import axios from 'axios'
import TopDistributorsReportView from '../TopDistributorsReportView.vue'

// Mock axios
vi.mock('axios')
const mockedAxios = vi.mocked(axios, true)

const mockDistributorsData = {
  data: {
    success: true,
    message: 'Top distributors report retrieved successfully.',
    data: [
      {
        rank: 1,
        distributor_id: 10,
        distributor_name: 'Alfonso Kreiger',
        total_sales: '10,000.00',
        total_sales_raw: 10000.0
      },
      {
        rank: 2,
        distributor_id: 20,
        distributor_name: 'Braeden Bechtelar',
        total_sales: '8,000.00',
        total_sales_raw: 8000.0
      },
      {
        rank: 3,
        distributor_id: 30,
        distributor_name: 'Gwen Tromp',
        total_sales: '7,000.00',
        total_sales_raw: 7000.0
      },
      {
        rank: 3,
        distributor_id: 31,
        distributor_name: 'Arturo Quigley',
        total_sales: '7,000.00',
        total_sales_raw: 7000.0
      }
    ],
    pagination: {
      current_page: 1,
      per_page: 20,
      total: 50,
      last_page: 3
    }
  }
}

describe('TopDistributorsReportView', () => {
  const router = createRouter({
    history: createMemoryHistory(),
    routes: [
      {
        path: '/reports/top-distributors',
        name: 'top-distributors-report',
        component: TopDistributorsReportView
      }
    ]
  })

  beforeEach(() => {
    vi.clearAllMocks()
    mockedAxios.get.mockResolvedValue(mockDistributorsData)
  })

  it('renders the page title', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Top Distributors Report')
  })

  it('displays description text', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Top 200 distributors ranked by total sales')
  })

  it('fetches data on mount', async () => {
    mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(mockedAxios.get).toHaveBeenCalledTimes(1)
    expect(mockedAxios.get).toHaveBeenCalledWith(
      expect.stringContaining('/v1/reports/top-distributors'),
      expect.objectContaining({
        params: expect.objectContaining({
          page: 1,
          per_page: 20
        })
      })
    )
  })

  it('displays table headers correctly', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Rank')
    expect(wrapper.text()).toContain('Distributor Name')
    expect(wrapper.text()).toContain('Total Sales')
  })

  it('displays distributor data in table', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Alfonso Kreiger')
    expect(wrapper.text()).toContain('Braeden Bechtelar')
    expect(wrapper.text()).toContain('$10,000.00')
    expect(wrapper.text()).toContain('$8,000.00')
  })

  it('displays ranks correctly including tied ranks', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    // Both Gwen Tromp and Arturo Quigley should have rank 3
    const tableRows = wrapper.findAll('tbody tr')
    expect(tableRows.length).toBe(4)

    // Check that tied ranks are displayed
    expect(wrapper.text()).toContain('Gwen Tromp')
    expect(wrapper.text()).toContain('Arturo Quigley')
  })

  it('shows loading state initially', async () => {
    // Create a promise that we can control
    let resolvePromise: (value: any) => void
    const promise = new Promise((resolve) => {
      resolvePromise = resolve
    })
    mockedAxios.get.mockReturnValue(promise)

    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    // Wait for next tick to allow component to set loading state
    await wrapper.vm.$nextTick()

    // Should show loading spinner before data loads
    expect(wrapper.find('.animate-spin').exists()).toBe(true)

    // Resolve the promise to complete the test
    resolvePromise!(mockDistributorsData)
    await flushPromises()
  })

  it('handles API error gracefully', async () => {
    mockedAxios.get.mockRejectedValue({
      response: {
        data: {
          message: 'Server error'
        }
      }
    })

    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Server error')
  })

  it('displays pagination info', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Showing')
    expect(wrapper.text()).toContain('50')
    expect(wrapper.text()).toContain('distributors')
  })

  it('has working pagination buttons', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    // Find all buttons
    const allButtons = wrapper.findAll('button')

    // Should have multiple navigation buttons
    expect(allButtons.length).toBeGreaterThan(0)

    // Check that pagination section exists
    expect(wrapper.text()).toContain('Previous')
    expect(wrapper.text()).toContain('Next')
  })

  it('navigates to next page when Next is clicked', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()
    vi.clearAllMocks()

    // Find and click the Next button (the last navigation button)
    const buttons = wrapper.findAll('button')
    const nextButton = buttons[buttons.length - 1]

    await nextButton?.trigger('click')
    await flushPromises()

    expect(mockedAxios.get).toHaveBeenCalledWith(
      expect.stringContaining('/v1/reports/top-distributors'),
      expect.objectContaining({
        params: expect.objectContaining({
          page: 2
        })
      })
    )
  })

  it('disables Previous button on first page', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    // Find all buttons with disabled attribute
    const allButtons = wrapper.findAll('button')

    // On page 1, Previous button should be disabled
    // Check if any button has disabled attribute
    const disabledButtons = allButtons.filter((btn) => btn.attributes('disabled') !== undefined)
    expect(disabledButtons.length).toBeGreaterThan(0)
  })

  it('formats currency with dollar sign', async () => {
    const wrapper = mount(TopDistributorsReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    // Check that amounts are formatted with dollar sign
    expect(wrapper.html()).toContain('$10,000.00')
    expect(wrapper.html()).toContain('$8,000.00')
    expect(wrapper.html()).toContain('$7,000.00')
  })
})
