<template>
  <div v-if="formModal.isOpen" class="fixed inset-0 bg-[#0000009e] z-40 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full animate-fade-in flex overflow-hidden">
      <!-- Left Side - Image -->
      <div class="hidden md:flex md:w-1/2 bg-gray-700 relative overflow-hidden items-center justify-center">
        <img src="/specs.png" alt="Background pattern" class="absolute inset-0 w-full h-full object-cover opacity-20" />
        <div class="relative z-10 flex items-center justify-center w-full h-full">
          <img src="/specs.png" alt="Person" class="h-full object-cover" />
        </div>
      </div>

      <!-- Right Side - Form -->
      <div class="w-full md:w-1/2 p-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-semibold text-blue-900">REGISTER TO<br />LEARN MORE</h2>
          <button
            @click="formModal.closeModal"
            class="text-gray-400 hover:text-gray-600 transition-colors ml-4 shrink-0"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Registration Form Component -->
        <RegistrationForm
          :form-data="formData"
          :is-submitting="isSubmitting"
          :submit-message="submitMessage"
          :submit-error="submitError"
          @update:form-data="formData = $event"
          @submit="handleSubmit"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useFormModalStore } from '@/stores/formModal'
import { useRegistrationForm } from '@/composables/useRegistrationForm'
import RegistrationForm from './RegistrationForm.vue'

const formModal = useFormModalStore()
const { formData, isSubmitting, submitMessage, submitError, handleSubmit } = useRegistrationForm()
</script>
