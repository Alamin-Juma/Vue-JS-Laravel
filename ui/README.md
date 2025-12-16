# Vue Collagen Marketing App

A modern, responsive marketing application built with Vue 3, TypeScript, Tailwind CSS, and featuring comprehensive end-to-end testing with Cypress. The app showcases collagen products with hero sections, product galleries, influencer features, and a modal registration form.

## 🌟 Features

- **Responsive Design**: Fully responsive layout optimized for mobile, tablet, and desktop
- **Interactive Components**: Hero section, product showcase, influencer gallery, CTA sections
- **Modal Registration Form**: Popup form with form state management using Pinia
- **API Integration**: Service layer for backend communication with error handling
- **Type Safety**: Full TypeScript support throughout the application
- **Tailwind CSS**: Modern utility-first styling with custom animations
- **E2E Testing**: Comprehensive Cypress test suite with 54+ test cases
- **Separation of Concerns**: Clean architecture with composables, services, and components

## 📋 Prerequisites

- **Node.js**: v16.0.0 or higher
- **npm**: v7.0.0 or higher
- **Git** (optional, for version control)

## 🚀 Installation

### 1. Clone or Navigate to the Project

```bash
cd path/to/vue-laravel-project/ui
```

### 2. Install Dependencies

```bash
npm install
```

This will install all required packages:
- Vue 3
- TypeScript
- Tailwind CSS v4.1.18
- Pinia (state management)
- Cypress (E2E testing)
- Vite (build tool)
- Vitest (unit testing)
- ESLint (linting)

## 🛠️ Development

### Start Development Server

```bash
npm run dev
```

The app will be available at:
```
http://localhost:5173
```

Features:
- Hot module replacement (HMR) for instant updates
- Automatic page refresh on file changes
- TypeScript type checking
- Tailwind CSS compilation

### Type Check

```bash
npm run type-check
```

Validates all TypeScript files without building.

### Build for Production

```bash
npm run build
```

Creates an optimized production build in the `dist/` directory with:
- Minified JavaScript
- Optimized CSS
- Asset compression

### Preview Production Build

```bash
npm run preview
```

Serves the production build locally for testing before deployment.

## 🧪 Testing

### End-to-End Tests (Cypress)

```bash
npm run test:e2e
```

**Modes:**

- **Headless Mode** (default): Runs all tests in background with results summary
- **Interactive Mode**: Opens Cypress UI for visual debugging
  ```bash
  npm run test:e2e -- --headed
  ```

**Test Specs:**

The test suite (`cypress/e2e/app.cy.ts`) includes 54+ tests across 12 categories:

1. **Navigation Tests**: Verify navigation between sections
2. **Hero Section Tests**: Hero content visibility and buttons
3. **Product Section Tests**: Product cards and layouts
4. **Influence Section Tests**: Influencer cards and images
5. **CTA Section Tests**: Call-to-action button functionality
6. **Form Modal Tests**: Modal open/close and form interactions
7. **Form Section Tests**: Form visibility on page
8. **Footer Tests**: Footer content and styling
9. **Responsive Design Tests**: Mobile, tablet, desktop layouts
10. **Accessibility Tests**: Alt text, semantic HTML, keyboard navigation
11. **Error Handling Tests**: Missing images, invalid states
12. **User Flow Tests**: Complete registration workflows

**Running Specific Tests:**

```bash
# Run a specific test file
npx cypress run --spec "cypress/e2e/app.cy.ts"

# Run tests with specific tag
npx cypress run --spec "cypress/e2e/app.cy.ts" --env TAGS="@critical"

# Run in headed mode for debugging
npx cypress open
```

**Test Results:**

Results are saved to:
- Screenshots: `cypress/screenshots/` (on failures)
- Videos: `cypress/videos/` (if enabled)
- Logs: Console output during test execution

### Unit Tests (Vitest)

```bash
npm run test:unit
```

Runs unit tests for components and utilities.

### Linting

```bash
npm run lint
```

Checks code style and formatting with ESLint.

## 📁 Project Structure

```
src/
├── components/              # Vue components
│   ├── BodyOne.vue         # Product showcase section
│   ├── CTASection.vue       # Call-to-action section
│   ├── FormModal.vue        # Modal form container
│   ├── RegistrationForm.vue # Registration form component
│   ├── HeroSection.vue      # Hero section
│   ├── InfluenceSection.vue # Influencer gallery
│   ├── NavBar.vue           # Navigation bar
│   ├── footerSection.vue    # Footer
│   └── __tests__/           # Component tests
├── composables/             # Reusable composition functions
│   ├── useRegistrationForm.ts       # Form state & submission logic
│   └── useRegistrationFormComponent.ts # Form component types
├── services/                # API and business logic
│   ├── api.ts              # Base HTTP client
│   └── index.ts            # Domain-specific services
├── stores/                  # Pinia state management
│   └── formModal.ts        # Form modal visibility state
├── views/                   # Page-level components
│   └── HomeView.vue        # Main application view
├── router/                  # Vue Router configuration
├── assets/                  # Static assets (CSS, images)
└── main.ts                  # Application entry point

cypress/
├── e2e/
│   └── app.cy.ts           # E2E test suite (54+ tests)
├── fixtures/               # Test data fixtures
├── support/                # Test utilities and commands
├── screenshots/            # Failed test screenshots
└── videos/                 # Test execution videos

public/                      # Static files
├── a.jpg, b.jpg, d.jpg    # Product images
├── face1.png, face2.png, face3.png # Influencer images
└── specs.png               # Pattern image

tailwind.config.js           # Tailwind CSS configuration
cypress.config.ts            # Cypress configuration
vite.config.ts               # Vite build configuration
tsconfig.json                # TypeScript configuration
```

## 🔌 API Integration

The app uses a centralized API service for backend communication:

**Base URL**: Configured via `VITE_API_URL` environment variable
**Default**: `http://localhost:8000/api` (for Laravel backend)

**Available Endpoints:**

- `POST /register` - User registration
- `POST /subscribe` - Newsletter subscription
- `GET /products` - Fetch products list
- `GET /influencers` - Fetch influencers list

**Request/Response Types:**

```typescript
// Form submission
POST /register
{
  firstName: string
  lastName: string
  phone: string
  email: string
  agreeToTerms: boolean
}

// Response
{
  success: boolean
  message: string
  data?: any
}
```

## 🎨 Styling

### Tailwind CSS

The app uses Tailwind CSS v4 utility-first approach:

- **Primary Colors**: Blue-900 (`#111C3B`), Gray tones
- **Spacing**: Consistent padding/margin system
- **Responsive**: Mobile-first breakpoints (sm, md, lg, xl)
- **Custom Animations**: Fade-in effect on modals

**Custom Configuration** (`tailwind.config.js`):
```javascript
- animate-fade-in: Smooth scale and opacity transition
- Custom keyframes for component animations
```

### Component Styling

All components use Tailwind utility classes:
- **No scoped styles** - for consistency and maintainability
- **Responsive classes** - `md:` and `lg:` prefixes for breakpoints
- **Hover states** - Interactive feedback with `hover:` classes
- **Disabled states** - Visual feedback for form interactions

## 🛡️ TypeScript

Full TypeScript support with strict mode enabled:

**Key Types:**
- `FormData` - Registration form data structure
- `FormSubmission` - API request type
- `FormResponse` - API response type
- `RegistrationFormProps` - Component props interface
- `RegistrationFormEmits` - Component emits interface

## 📦 Dependencies

**Core:**
- `vue@^3.5.0` - Progressive framework
- `typescript@^5.0` - Type safety
- `vite@^7.3.0` - Build tool

**Styling:**
- `tailwindcss@^4.1.18` - Utility-first CSS
- `autoprefixer` - CSS vendor prefixes
- `postcss` - CSS transformation

**State Management:**
- `pinia@^3.0.4` - Lightweight store
- `vue-router@^4.0` - Client-side routing

**Testing:**
- `cypress@^15.7.1` - E2E testing
- `vitest@^2.2.0` - Unit testing

**Development:**
- `@vitejs/plugin-vue` - Vue 3 support for Vite
- `eslint@^9.0` - Code linting
- `@typescript-eslint/eslint-plugin` - TypeScript linting

## 🔧 Configuration Files

### `vite.config.ts`
- Build tool configuration
- Plugin setup (Vue)
- Dev server settings

### `cypress.config.ts`
- Test runner configuration
- Base URL: `http://localhost:5173`
- Timeouts: 10000ms
- Screenshot on failure enabled

### `tailwind.config.js`
- Utility classes configuration
- Custom animations and keyframes
- Responsive breakpoints

### `tsconfig.json`
- TypeScript compiler options
- Strict mode enabled
- Path aliases configured

## 📝 Environment Variables

Create a `.env` file in the project root:

```env
# API Configuration
VITE_API_URL=http://localhost:8000/api

# App Configuration
VITE_APP_NAME=Collagen Marketing App
```

See `.env.example` for all available variables.

## 🌐 Browser Support

- Chrome/Chromium (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## 💡 Common Commands Reference

| Command | Purpose |
|---------|---------|
| `npm install` | Install all dependencies |
| `npm run dev` | Start development server |
| `npm run build` | Build for production |
| `npm run preview` | Preview production build |
| `npm run test:e2e` | Run Cypress tests |
| `npm run test:unit` | Run unit tests |
| `npm run type-check` | Check TypeScript types |
| `npm run lint` | Run ESLint |

## 🐛 Troubleshooting

### Port Already in Use
If port 5173 is already in use:
```bash
npm run dev -- --port 5174
```

### Cypress Won't Open
Ensure the dev server is running:
```bash
npm run dev
# In another terminal
npm run test:e2e
```

### TypeScript Errors in IDE
- Install Vue extension: [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar)
- Disable Vetur extension if installed
- Restart VS Code

### Module Not Found Errors
Clear node_modules and reinstall:
```bash
rm -r node_modules
npm install
```

## 📖 Resources

- [Vue 3 Documentation](https://vuejs.org/)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Pinia Documentation](https://pinia.vuejs.org/)
- [Cypress Documentation](https://docs.cypress.io/)
- [Vite Documentation](https://vite.dev/)

## 📄 License

This project is licensed under the MIT License.

## 👤 Author

Created as a modern Vue.js marketing application with comprehensive testing and type safety.

```sh
npm run test:e2e:dev
```

This runs the end-to-end tests against the Vite development server.
It is much faster than the production build.

But it's still recommended to test the production build with `test:e2e` before deploying (e.g. in CI environments):

```sh
npm run build
npm run test:e2e
```

### Lint with [ESLint](https://eslint.org/)

```sh
npm run lint
```
