# Cypress E2E Tests

This directory contains comprehensive end-to-end tests for the Vue Laravel application.

## Test Coverage

The test suite covers the following areas:

### 1. **Navigation Bar**
- Navbar visibility
- Mobile menu toggle
- Navigation functionality

### 2. **Hero Section**
- Title and subtitle display
- Congratulations section
- Button interactions
- Form modal triggering

### 3. **Products Section (BodyOne)**
- Product display (3 products)
- Product descriptions
- Product images
- Layout verification (alternating left-right on desktop)
- Mobile responsiveness (single column)

### 4. **Influence Section**
- Section title and subtitle
- Influencer cards (3 cards)
- Influencer information display
- Grid layout on desktop
- Single column on mobile

### 5. **CTA Section**
- CTA heading display
- Button visibility and functionality
- Form modal triggering

### 6. **Form Modal**
- Modal visibility
- Form field display
- Form validation
- Button interactions
- Image display (desktop only)
- Submit functionality
- Close button functionality

### 7. **Form Section**
- Form section display
- Form layout

### 8. **Footer**
- Footer visibility
- Copyright information
- Navigation links
- Styling verification

### 9. **Responsive Design**
- Mobile (iPhone X)
- Tablet (iPad)
- Desktop (MacBook)

### 10. **Accessibility**
- Heading structure
- Image alt text
- Form labels
- Input accessibility

### 11. **Error Handling**
- Required field validation
- Email format validation
- Form submission prevention

### 12. **User Flows**
- Complete registration flow
- Full page navigation

## Running Tests

### Prerequisites
- Dev server must be running: `npm run dev`
- Application must be accessible at `http://localhost:5173`

### Run All Tests (Headless)
```bash
npm run test:e2e
```

### Run Tests in Interactive Mode
```bash
npm run test:e2e:dev
```

This opens the Cypress Test Runner where you can:
- Run tests individually
- See real-time execution
- Debug test failures
- Inspect DOM elements

### Run Specific Test File
```bash
npx cypress run --spec "cypress/e2e/app.cy.ts"
```

### Run Tests with GUI
```bash
npx cypress open
```

## Test Structure

Each test follows this pattern:

```typescript
describe('Feature Category', () => {
  beforeEach(() => {
    cy.visit('/') // Setup
  })

  it('should do something', () => {
    // Arrange
    // Act
    cy.click('button')
    // Assert
    cy.contains('expected text').should('be.visible')
  })
})
```

## Tips for Writing Tests

1. **Use descriptive test names** - Should explain what is being tested
2. **Test user interactions** - Focus on what users do
3. **Use semantic selectors** - Prefer text content over CSS classes
4. **Keep tests isolated** - Each test should be independent
5. **Use fixtures** - For mock data if needed
6. **Test accessibility** - Ensure proper semantic HTML

## Debugging Tests

### View Logs
```bash
npm run test:e2e -- --headed
```

### Debug Single Test
```bash
npm run test:e2e -- --spec "cypress/e2e/app.cy.ts" --headed
```

### Step Through Test
In Cypress Test Runner:
1. Click the test case
2. Use Step debugger
3. Hover over commands to see what happened

## CI/CD Integration

For CI/CD pipelines, use:
```bash
npm run test:e2e
```

This runs all tests in headless mode and reports results.

## Common Assertions

```typescript
// Visibility
cy.get('selector').should('be.visible')
cy.get('selector').should('not.be.visible')

// Text content
cy.contains('text').should('be.visible')
cy.contains('h1', 'text').should('exist')

// Form inputs
cy.get('input').should('have.value', 'text')
cy.get('input[type="checkbox"]').should('be.checked')

// Attributes
cy.get('img').should('have.attr', 'alt')
cy.get('input').should('have.attr', 'required')

// CSS Classes
cy.get('element').should('have.class', 'className')
```

## Notes

- Tests use the dev server port (`5173`)
- Mobile viewport tests are included for responsive design validation
- Form submission tests will show "Registering..." state (backend integration needed for full flow)
- All tests are E2E (end-to-end) and test the full user experience

## Future Enhancements

- [ ] Add API mocking with cypress-mock-server
- [ ] Add visual regression tests
- [ ] Add performance benchmarks
- [ ] Add cross-browser testing
- [ ] Add custom commands for common actions
