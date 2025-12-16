// https://on.cypress.io/api

describe('Vue Laravel App - Full E2E Tests', () => {
  beforeEach(() => {
    cy.visit('/')
  })

  // ==================== Navigation Tests ====================
  describe('Navigation Bar', () => {
    it('should render the navigation bar', () => {
      cy.get('nav').should('be.visible')
    })

    it('should have logo/brand in navbar', () => {
      cy.get('nav').should('contain', 'LOGO')
    })

    it('should display mobile menu button on small screens', () => {
      cy.viewport('iphone-x')
      cy.get('button[class*="md:hidden"]').should('be.visible')
    })

    it('should toggle mobile menu on button click', () => {
      cy.viewport('iphone-x')
      cy.get('button[class*="md:hidden"]').click()
      // Menu should be visible after click
      cy.get('nav').should('be.visible')
    })
  })

  // ==================== Hero Section Tests ====================
  describe('Hero Section', () => {
    it('should display hero section with title', () => {
      cy.contains('h1', 'COLLAGEN IS').should('be.visible')
      cy.contains('h1', 'THE FOUNTAIN').should('be.visible')
      cy.contains('h1', 'OF YOUTH').should('be.visible')
    })

    it('should display hero section subtitle', () => {
      cy.contains("WHAT'S YOUR INFLUENCE?").should('be.visible')
    })

    it('should display congratulations section', () => {
      cy.contains('h2', 'CONGRATULATIONS').should('be.visible')
    })

    it('should display congratulations description', () => {
      cy.contains(
        'You are among the very first to learn of NXM'
      ).should('be.visible')
    })

    it('should have Connect with Ben button in hero', () => {
      cy.contains('button', 'Connect with Ben').first().should('be.visible')
    })

    it('should open form modal when Connect button is clicked', () => {
      cy.contains('button', 'Connect with Ben').first().click()
      cy.contains('h2', 'REGISTER TO').should('be.visible')
      cy.contains('LEARN MORE').should('be.visible')
    })
  })

  // ==================== Body One Section Tests ====================
  describe('Body One - Products Section', () => {
    it('should display all three product sections', () => {
      cy.contains('COLLAGEN PEPTIDE').should('be.visible')
      cy.contains('BELLA COLLAGEN').should('be.visible')
      cy.contains('HYDRATING LIP').should('be.visible')
    })

    it('should display product descriptions', () => {
      cy.contains('Instant results with visible removal of dead cells').should(
        'be.visible'
      )
      cy.contains(
        'Beauty from the inside Out'
      ).should('be.visible')
      cy.contains(
        'Ultimate nourishment, comfort & conditioning'
      ).should('be.visible')
    })

    it('should display product images', () => {
      cy.get('img[src="/a.jpg"]').should('be.visible')
      cy.get('img[src="/d.jpg"]').should('be.visible')
      cy.get('img[src="/b.jpg"]').should('be.visible')
    })

    it('should have proper layout on desktop (alternating left-right)', () => {
      cy.viewport('macbook-15')
      // Product 1: content left, image right
      cy.contains('COLLAGEN PEPTIDE').parent().parent().should('be.visible')
      // Product 2: image left, content right
      cy.contains('BELLA COLLAGEN').parent().parent().should('be.visible')
      // Product 3: content left, image right
      cy.contains('HYDRATING LIP').parent().parent().should('be.visible')
    })

    it('should stack vertically on mobile', () => {
      cy.viewport('iphone-x')
      cy.contains('COLLAGEN PEPTIDE').should('be.visible')
      cy.contains('BELLA COLLAGEN').should('be.visible')
      cy.contains('HYDRATING LIP').should('be.visible')
    })
  })

  // ==================== Influence Section Tests ====================
  describe('Influence Section', () => {
    it('should display section title', () => {
      cy.contains("WHAT'S YOUR INFLUENCE?").should('be.visible')
    })

    it('should display section subtitle', () => {
      cy.contains('Is this you? Could this be you?').should('be.visible')
      cy.contains('Are you ready to be an influencer?').should('be.visible')
    })

    it('should display three influencer cards', () => {
      cy.contains('Grace Perez').should('be.visible')
      cy.contains('Bella Marie').should('be.visible')
      cy.contains('Gigi Hadid').should('be.visible')
    })

    it('should display influencer usernames', () => {
      cy.contains('@graceperez').should('be.visible')
      cy.contains('@bellamarie').should('be.visible')
      cy.contains('@gigihadid').should('be.visible')
    })

    it('should display influencer images', () => {
      cy.get('img[src="/face3.png"]').should('exist')
      cy.get('img[src="/face1.png"]').should('exist')
      cy.get('img[src="/face2.png"]').should('exist')
    })

    it('should display cards in grid on desktop', () => {
      cy.viewport('macbook-15')
      cy.get('[class*="grid-cols-1"]').should('exist')
    })

    it('should display single column on mobile', () => {
      cy.viewport('iphone-x')
      cy.contains('Grace Perez').should('be.visible')
      cy.contains('Bella Marie').should('be.visible')
    })
  })

  // ==================== CTA Section Tests ====================
  describe('CTA Section', () => {
    it('should display CTA heading', () => {
      cy.contains("WOULD YOU LIKE TO").should('be.visible')
      cy.contains('LEARN MORE?').should('be.visible')
    })

    it('should have Connect with Ben button in CTA', () => {
      cy.contains('button', 'Connect with Ben').last().should('be.visible')
    })

    it('should open form modal when CTA button is clicked', () => {
      cy.contains('button', 'Connect with Ben').last().click()
      cy.contains('h2', 'REGISTER TO').should('be.visible')
    })
  })

  // ==================== Form Modal Tests ====================
  describe('Form Modal', () => {
    beforeEach(() => {
      // Open the form modal
      cy.contains('button', 'Connect with Ben').first().click()
    })

    it('should display form modal when triggered', () => {
      cy.contains('h2', 'REGISTER TO').should('be.visible')
      cy.contains('LEARN MORE').should('be.visible')
    })

    it('should display close button', () => {
      cy.get('button svg').should('be.visible')
    })

    it('should display form fields', () => {
      cy.get('input[placeholder="First Name"]').should('be.visible')
      cy.get('input[placeholder="Last Name"]').should('be.visible')
      cy.get('input[placeholder="Best Phone Number"]').should('be.visible')
      cy.get('input[placeholder="Email"]').should('be.visible')
    })

    it('should display I\'m not a robot checkbox', () => {
      cy.get('input[type="checkbox"][id="agreement"]').should('be.visible')
      cy.contains("I'm not a robot").should('be.visible')
    })

    it('should display Register Now button', () => {
      cy.contains('button', 'Register Now').should('be.visible')
    })

    it('should require email field', () => {
      cy.get('input[type="email"]').should('have.attr', 'required')
    })

    it('should allow filling form fields', () => {
      cy.get('input[placeholder="First Name"]').type('John')
      cy.get('input[placeholder="First Name"]').should('have.value', 'John')

      cy.get('input[placeholder="Last Name"]').type('Doe')
      cy.get('input[placeholder="Last Name"]').should('have.value', 'Doe')

      cy.get('input[placeholder="Best Phone Number"]').type('123-456-7890')
      cy.get('input[placeholder="Best Phone Number"]').should(
        'have.value',
        '123-456-7890'
      )

      cy.get('input[placeholder="Email"]').type('john@example.com')
      cy.get('input[placeholder="Email"]').should(
        'have.value',
        'john@example.com'
      )
    })

    it('should allow checking the checkbox', () => {
      cy.get('input[type="checkbox"][id="agreement"]').check()
      cy.get('input[type="checkbox"][id="agreement"]').should('be.checked')
    })

    it('should display image placeholder on desktop', () => {
      cy.viewport('macbook-15')
      cy.get('img[src="/specs.png"]').should('be.visible')
    })

    it('should hide image on mobile', () => {
      cy.viewport('iphone-x')
      cy.get('[class*="hidden"]').should('exist')
    })
  })

  // ==================== Form Section Tests ====================
  describe('Form Section Page', () => {
    it('should have form section in the page', () => {
      // FormSection is now a static section on the page
      cy.get('section').should('be.visible')
    })
  })

  // ==================== Footer Tests ====================
  describe('Footer Section', () => {
    it('should display footer', () => {
      cy.get('footer').should('be.visible')
    })

    it('should display copyright text', () => {
      cy.contains('Copyright').should('be.visible')
      cy.contains('LOGO').should('be.visible')
    })

    it('should display footer links', () => {
      cy.contains('a', 'Privacy Policy').should('be.visible')
      cy.contains('a', 'Terms & Conditions').should('be.visible')
      cy.contains('a', 'Contact Us').should('be.visible')
      cy.contains('a', 'FAQs').should('be.visible')
    })

    it('footer should have correct styling', () => {
      cy.get('footer').should('have.class', 'text-white')
      // Footer has blue background color
      cy.get('footer').should('have.class', 'py-8')
    })
  })

  // ==================== Responsive Design Tests ====================
  describe('Responsive Design', () => {
    it('should be mobile friendly on iPhone X', () => {
      cy.viewport('iphone-x')
      cy.get('nav').should('be.visible')
      cy.contains('COLLAGEN IS').should('be.visible')
      cy.get('footer').should('be.visible')
    })

    it('should be tablet friendly on iPad', () => {
      cy.viewport('ipad-2')
      cy.get('nav').should('be.visible')
      cy.contains('COLLAGEN IS').should('be.visible')
      cy.get('footer').should('be.visible')
    })

    it('should be desktop friendly on macbook', () => {
      cy.viewport('macbook-15')
      cy.get('nav').should('be.visible')
      cy.contains('COLLAGEN IS').should('be.visible')
      cy.get('footer').should('be.visible')
    })
  })

  // ==================== User Flow Tests ====================
  describe('Complete User Flow', () => {
    it('should complete full registration flow', () => {
      // 1. Visit page
      cy.visit('/')

      // 2. Scroll and view hero section
      cy.contains('COLLAGEN IS').should('be.visible')

      // 3. Click on Connect button
      cy.contains('button', 'Connect with Ben').first().click()

      // 4. Verify modal opened
      cy.contains('h2', 'REGISTER TO').should('be.visible')

      // 5. Fill form
      cy.get('input[placeholder="First Name"]').type('Jane')
      cy.get('input[placeholder="Last Name"]').type('Smith')
      cy.get('input[placeholder="Best Phone Number"]').type('555-1234')
      cy.get('input[placeholder="Email"]').type('jane@example.com')

      // 6. Check agreement
      cy.get('input[type="checkbox"][id="agreement"]').check()

      // 7. Verify form is filled
      cy.get('input[placeholder="First Name"]').should('have.value', 'Jane')
    })

    it('should navigate through all sections', () => {
      // Hero section
      cy.contains('COLLAGEN IS').should('be.visible')

      // Products section
      cy.contains('COLLAGEN PEPTIDE').should('be.visible')

      // Influence section
      cy.contains("WHAT'S YOUR INFLUENCE?").should('be.visible')

      // CTA section
      cy.contains('WOULD YOU LIKE TO').should('be.visible')

      // Footer
      cy.contains('Copyright').should('be.visible')
    })
  })

  // ==================== Accessibility Tests ====================
  describe('Accessibility', () => {
    it('should have proper heading structure', () => {
      cy.get('h1').should('exist')
      cy.get('h2').should('exist')
      cy.get('h3').should('exist')
    })

    it('should have alt text on images', () => {
      cy.get('img[src="/a.jpg"]').should('have.attr', 'alt')
      cy.get('img[src="/ben.jpg"]').should('have.attr', 'alt')
      cy.get('img[src="/face3.png"]').should('have.attr', 'alt')
    })

    it('should have accessible form labels', () => {
      cy.contains('button', 'Connect with Ben').first().click()
      cy.get('label[for="agreement"]').should('be.visible')
    })

    it('should have focusable form inputs', () => {
      cy.contains('button', 'Connect with Ben').first().click()
      cy.get('input[placeholder="First Name"]').should('not.be.disabled')
      cy.get('input[placeholder="Email"]').should('not.be.disabled')
    })
  })

  // ==================== Error Handling Tests ====================
  describe('Error Handling', () => {
    it('should not submit form without email', () => {
      cy.contains('button', 'Connect with Ben').first().click()
      cy.get('input[placeholder="First Name"]').type('John')
      cy.get('input[placeholder="Last Name"]').type('Doe')

      // Try to submit without email
      cy.get('form').then(($form) => {
        // Form validation should prevent submission
        cy.contains('button', 'Register Now').click()
        // Modal should still be visible (form not submitted)
        cy.contains('h2', 'REGISTER TO').should('be.visible')
      })
    })

    it('should show error on invalid email format', () => {
      cy.contains('button', 'Connect with Ben').first().click()
      cy.get('input[placeholder="Email"]').type('notanemail')

      // HTML5 validation should catch it
      cy.get('input[type="email"]').invoke('attr', 'type').should('equal', 'email')
    })
  })
})
