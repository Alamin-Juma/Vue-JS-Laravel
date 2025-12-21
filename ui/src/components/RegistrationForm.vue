<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRegistrationFormComponent, type RegistrationFormProps, type RegistrationFormEmits } from '@/composables/useRegistrationFormComponent'

const props = defineProps<RegistrationFormProps>()
const emit = defineEmits<RegistrationFormEmits>()

const { handleSubmit } = useRegistrationFormComponent()

// Local validation errors
const errors = ref<Record<string, string>>({})
const touched = ref<Record<string, boolean>>({})

// Validation functions
const validateEmail = (email: string): string => {
  if (!email) return 'Email is required'
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailRegex.test(email)) return 'Please enter a valid email address'
  return ''
}

const validateRequired = (value: string, fieldName: string): string => {
  if (!value || value.trim() === '') return `${fieldName} is required`
  return ''
}

const validatePhone = (phone: string): string => {
  if (!phone) return 'Phone number is required'
  const phoneRegex = /^[\d\s\-\+\(\)]+$/
  if (!phoneRegex.test(phone)) return 'Please enter a valid phone number'
  return ''
}

// Field validation handlers
const validateField = (field: string) => {
  touched.value[field] = true
  
  switch(field) {
    case 'firstName':
      errors.value.firstName = validateRequired(props.formData.firstName, 'First name')
      break
    case 'lastName':
      errors.value.lastName = validateRequired(props.formData.lastName, 'Last name')
      break
    case 'phone':
      errors.value.phone = validatePhone(props.formData.phone)
      break
    case 'email':
      errors.value.email = validateEmail(props.formData.email)
      break
    case 'agreeToTerms':
      errors.value.agreeToTerms = props.formData.agreeToTerms ? '' : 'You must agree to continue'
      break
  }
}

// Check if form is valid
const isFormValid = computed(() => {
  return props.formData.firstName &&
         props.formData.lastName &&
         props.formData.phone &&
         props.formData.email &&
         props.formData.agreeToTerms &&
         !errors.value.firstName &&
         !errors.value.lastName &&
         !errors.value.phone &&
         !errors.value.email &&
         !errors.value.agreeToTerms
})

// Handle form submission with validation
const onSubmit = () => {
  console.log('🚀 Register Now button clicked!')
  console.log('📋 Form data:', props.formData)
  
  // Touch all fields
  Object.keys(props.formData).forEach(field => {
    touched.value[field] = true
    validateField(field)
  })

  // Check if form is valid
  if (isFormValid.value) {
    console.log('✅ Form is valid, submitting...')
    emit('submit')
  } else {
    console.log('❌ Form has validation errors')
  }
}
</script>

<template>
  <form @submit.prevent="onSubmit" class="space-y-6">
    <!-- First Name -->
    <div>
      <input
        :value="formData.firstName"
        @input="$emit('update:formData', { ...formData, firstName: ($event.target as HTMLInputElement).value })"
        @blur="validateField('firstName')"
        type="text"
        placeholder="First Name"
        :class="[
          'w-full max-w-[304px] px-0 py-2 border-b-[1.5px] bg-transparent focus:outline-none transition text-[14px] font-light leading-[100%] text-black placeholder:text-black',
          touched.firstName && errors.firstName ? 'border-red-500' : 'border-[#4FA0D5] focus:border-[#4FA0D5]'
        ]"
        required
      />
      <p v-if="touched.firstName && errors.firstName" class="text-red-500 text-xs mt-1">{{ errors.firstName }}</p>
    </div>

    <!-- Last Name -->
    <div>
      <input
        :value="formData.lastName"
        @input="$emit('update:formData', { ...formData, lastName: ($event.target as HTMLInputElement).value })"
        @blur="validateField('lastName')"
        type="text"
        placeholder="Last Name"
        :class="[
          'w-full max-w-[304px] px-0 py-2 border-b-[1.5px] bg-transparent focus:outline-none transition text-[14px] font-light leading-[100%] text-black placeholder:text-black',
          touched.lastName && errors.lastName ? 'border-red-500' : 'border-[#4FA0D5] focus:border-[#4FA0D5]'
        ]"
        required
      />
      <p v-if="touched.lastName && errors.lastName" class="text-red-500 text-xs mt-1">{{ errors.lastName }}</p>
    </div>

    <!-- Phone -->
    <div>
      <input
        :value="formData.phone"
        @input="$emit('update:formData', { ...formData, phone: ($event.target as HTMLInputElement).value })"
        @blur="validateField('phone')"
        type="tel"
        placeholder="Best Phone Number"
        :class="[
          'w-full max-w-[304px] px-0 py-2 border-b-[1.5px] bg-transparent focus:outline-none transition text-[14px] font-light leading-[100%] text-black placeholder:text-black',
          touched.phone && errors.phone ? 'border-red-500' : 'border-[#4FA0D5] focus:border-[#4FA0D5]'
        ]"
        required
      />
      <p v-if="touched.phone && errors.phone" class="text-red-500 text-xs mt-1">{{ errors.phone }}</p>
    </div>

    <!-- Email -->
    <div>
      <input
        :value="formData.email"
        @input="$emit('update:formData', { ...formData, email: ($event.target as HTMLInputElement).value })"
        @blur="validateField('email')"
        type="email"
        placeholder="Email"
        :class="[
          'w-full max-w-[304px] px-0 py-2 border-b-[1.5px] bg-transparent focus:outline-none transition text-[14px] font-light leading-[100%] text-black placeholder:text-black',
          touched.email && errors.email ? 'border-red-500' : 'border-[#4FA0D5] focus:border-[#4FA0D5]'
        ]"
        required
      />
      <p v-if="touched.email && errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
    </div>

    <!-- Checkbox -->
    <div>
      <div :class="[
        'flex items-center gap-3 py-4 max-w-[304px] h-[49px] rounded-[8px] border-[1.5px] px-3',
        touched.agreeToTerms && errors.agreeToTerms ? 'border-red-500' : 'border-[#4FA0D5]'
      ]">
        <input
          :checked="formData.agreeToTerms"
          @change="$emit('update:formData', { ...formData, agreeToTerms: ($event.target as HTMLInputElement).checked }); validateField('agreeToTerms')"
          type="checkbox"
          id="agreement"
          class="w-4 h-4 rounded border-gray-300 cursor-pointer accent-blue-900"
          required
        />
        <label for="agreement" class="text-sm text-gray-600 cursor-pointer">
          I'm not a robot
        </label>
        <svg class="w-5 h-5 text-blue-900 ml-auto" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
      </div>
      <p v-if="touched.agreeToTerms && errors.agreeToTerms" class="text-red-500 text-xs mt-1">{{ errors.agreeToTerms }}</p>
    </div>

    <!-- Register Button -->
    <button
      type="submit"
      :disabled="props.isSubmitting"
      class="w-full max-w-[304px] bg-[#456276] text-white py-3 rounded-md font-semibold hover:bg-[#3a5163] transition-colors mt-8 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
    >
      {{ props.isSubmitting ? 'Registering...' : 'Register Now' }}
    </button>

    <!-- Error Message -->
    <div v-if="submitError" class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
      {{ submitError }}
    </div>

    <!-- Success Message -->
    <div v-if="submitMessage" class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md text-sm">
      {{ submitMessage }}
    </div>
  </form>
</template>



