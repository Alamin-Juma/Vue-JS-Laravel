<script setup lang="ts">
import { useRegistrationFormComponent, type RegistrationFormProps, type RegistrationFormEmits } from '@/composables/useRegistrationFormComponent'

const props = defineProps<RegistrationFormProps>()

defineEmits<RegistrationFormEmits>()

const { handleSubmit } = useRegistrationFormComponent()
</script>

<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <!-- First Name -->
    <div>
      <input
        :value="formData.firstName"
        @input="$emit('update:formData', { ...formData, firstName: ($event.target as HTMLInputElement).value })"
        type="text"
        placeholder="First Name"
        class="w-full px-0 py-2 border-b border-gray-300 bg-transparent focus:outline-none focus:border-blue-900 transition text-sm"
      />
    </div>

    <!-- Last Name -->
    <div>
      <input
        :value="formData.lastName"
        @input="$emit('update:formData', { ...formData, lastName: ($event.target as HTMLInputElement).value })"
        type="text"
        placeholder="Last Name"
        class="w-full px-0 py-2 border-b border-gray-300 bg-transparent focus:outline-none focus:border-blue-900 transition text-sm"
      />
    </div>

    <!-- Phone -->
    <div>
      <input
        :value="formData.phone"
        @input="$emit('update:formData', { ...formData, phone: ($event.target as HTMLInputElement).value })"
        type="tel"
        placeholder="Best Phone Number"
        class="w-full px-0 py-2 border-b border-gray-300 bg-transparent focus:outline-none focus:border-blue-900 transition text-sm"
      />
    </div>

    <!-- Email -->
    <div>
      <input
        :value="formData.email"
        @input="$emit('update:formData', { ...formData, email: ($event.target as HTMLInputElement).value })"
        type="email"
        placeholder="Email"
        class="w-full px-0 py-2 border-b border-gray-300 bg-transparent focus:outline-none focus:border-blue-900 transition text-sm"
        required
      />
    </div>

    <!-- Checkbox -->
    <div class="flex items-center gap-3 py-4">
      <input
        :checked="formData.agreeToTerms"
        @change="$emit('update:formData', { ...formData, agreeToTerms: ($event.target as HTMLInputElement).checked })"
        type="checkbox"
        id="agreement"
        class="w-4 h-4 rounded border-gray-300 cursor-pointer accent-blue-900"
      />
      <label for="agreement" class="text-sm text-gray-600 cursor-pointer">
        I'm not a robot
      </label>
      <svg class="w-5 h-5 text-blue-900 ml-auto" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
      </svg>
    </div>

    <!-- Register Button -->
    <button
      type="submit"
      :disabled="props.isSubmitting"
      class="w-full bg-blue-900 text-white py-3 rounded-md font-semibold hover:bg-blue-800 transition-colors mt-8 disabled:opacity-50 disabled:cursor-not-allowed"
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



