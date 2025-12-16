import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount, flushPromises } from '@vue/test-utils'
import { createRouter, createMemoryHistory } from 'vue-router'
import CommissionReportView from '../CommissionReportView.vue'

// Mock the commission report service
vi.mock('@/services', () => ({
  commissionReportService: {
    getReport: vi.fn(),
    getOrderItems: vi.fn()
  }
}))

import { commissionReportService } from '@/services'

const mockReportData = {
  success: true,
  message: 'Commission report retrieved successfully.',
  data: [
    {
      invoice: 'ABC4170',
      purchaser: 'John Doe',
      purchaser_id: 1,
      distributor: 'Jane Smith',
      distributor_id: 2,
      referred_distributors: 8,
      order_date: '2020-04-11',
      percentage: '10%',
      order_total: '60.00',
      commission: '6.00'
    },
    {
      invoice: 'ABC6931',
      purchaser: 'Alice Johnson',
      purchaser_id: 3,
      distributor: 'Bob Wilson',
      distributor_id: 4,
      referred_distributors: 5,
      order_date: '2020-05-15',
      percentage: '10%',
      order_total: '372.00',
      commission: '37.20'
    }
  ],
  pagination: {
    current_page: 1,
    per_page: 15,
    total: 2,
    last_page: 1,
    from: 1,
    to: 2
  }
}

const mockOrderItems = {
  success: true,
  message: 'Order items retrieved successfully.',
  data: {
    invoice: 'ABC4170',
    items: [
      {
        sku: 'PROD001',
        product_name: 'Test Product',
        price: '30.00',
        quantity: 2,
        total: '60.00'
      }
    ]
  }
}

describe('CommissionReportView', () => {
  const router = createRouter({
    history: createMemoryHistory(),
    routes: [
      { path: '/reports/commission', name: 'commission-report', component: CommissionReportView }
    ]
  })

  beforeEach(() => {
    vi.clearAllMocks()
    ;(commissionReportService.getReport as any).mockResolvedValue(mockReportData)
    ;(commissionReportService.getOrderItems as any).mockResolvedValue(mockOrderItems)
  })

  it('renders the page title', async () => {
    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Commission Report')
  })

  it('displays filter inputs', async () => {
    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.find('#distributor').exists()).toBe(true)
    expect(wrapper.find('#date_from').exists()).toBe(true)
    expect(wrapper.find('#date_to').exists()).toBe(true)
    expect(wrapper.find('#invoice').exists()).toBe(true)
  })

  it('fetches report data on mount', async () => {
    mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(commissionReportService.getReport).toHaveBeenCalledTimes(1)
  })

  it('displays report data in table', async () => {
    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('ABC4170')
    expect(wrapper.text()).toContain('John Doe')
    expect(wrapper.text()).toContain('Jane Smith')
    expect(wrapper.text()).toContain('$6.00')
  })

  it('displays table headers correctly', async () => {
    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Invoice')
    expect(wrapper.text()).toContain('Purchaser')
    expect(wrapper.text()).toContain('Distributor')
    expect(wrapper.text()).toContain('Referred Distributors')
    expect(wrapper.text()).toContain('Order Date')
    expect(wrapper.text()).toContain('Percentage')
    expect(wrapper.text()).toContain('Order Total')
    expect(wrapper.text()).toContain('Commission')
  })

  it('applies filters when search button is clicked', async () => {
    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()
    vi.clearAllMocks()

    // Set filter values
    await wrapper.find('#distributor').setValue('John')
    await wrapper.find('#date_from').setValue('2020-01-01')
    await wrapper.find('#date_to').setValue('2020-12-31')

    // Click search button
    const searchButton = wrapper.find('button')
    await searchButton.trigger('click')
    await flushPromises()

    expect(commissionReportService.getReport).toHaveBeenCalledWith(
      expect.objectContaining({
        distributor: 'John',
        date_from: '2020-01-01',
        date_to: '2020-12-31'
      })
    )
  })

  it('clears filters when clear button is clicked', async () => {
    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    // Set filter values
    await wrapper.find('#distributor').setValue('John')

    // Find and click clear button (second button)
    const buttons = wrapper.findAll('button')
    const clearButton = buttons.find((btn) => btn.text().includes('Clear'))
    await clearButton?.trigger('click')
    await flushPromises()

    // Check that distributor filter is cleared
    const distributorInput = wrapper.find('#distributor')
    expect((distributorInput.element as HTMLInputElement).value).toBe('')
  })

  it('shows pagination when multiple pages exist', async () => {
    const multiPageData = {
      ...mockReportData,
      pagination: {
        current_page: 1,
        per_page: 15,
        total: 100,
        last_page: 7,
        from: 1,
        to: 15
      }
    }
    ;(commissionReportService.getReport as any).mockResolvedValue(multiPageData)

    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Previous')
    expect(wrapper.text()).toContain('Next')
    expect(wrapper.text()).toContain('1')
  })

  it('displays empty state when no data', async () => {
    const emptyData = {
      ...mockReportData,
      data: [],
      pagination: {
        current_page: 1,
        per_page: 15,
        total: 0,
        last_page: 1,
        from: null,
        to: null
      }
    }
    ;(commissionReportService.getReport as any).mockResolvedValue(emptyData)

    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('No records found')
  })

  it('handles API error gracefully', async () => {
    ;(commissionReportService.getReport as any).mockRejectedValue(new Error('API Error'))

    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    expect(wrapper.text()).toContain('API Error')
    expect(wrapper.text()).toContain('Try Again')
  })

  it('displays commission values correctly', async () => {
    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    // Verify commission amounts from expected test data
    expect(wrapper.text()).toContain('$6.00') // ABC4170
    expect(wrapper.text()).toContain('$37.20') // ABC6931
  })

  it('shows per page selector', async () => {
    const wrapper = mount(CommissionReportView, {
      global: {
        plugins: [router]
      }
    })

    await flushPromises()

    const perPageSelect = wrapper.find('#perPage')
    expect(perPageSelect.exists()).toBe(true)
  })
})
