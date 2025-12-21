<template>
  <div v-if="formModal.isOpen" class="fixed inset-0 bg-black/60 z-40 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full animate-fade-in flex overflow-hidden relative">
      <!-- Close Button - Top Right Corner -->
      <button
        @click="formModal.closeModal"
        class="absolute top-4 right-4 text-[#888888] hover:text-gray-600 transition-colors z-10 w-[11.41px] h-[11.41px]"
      >
        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </button>

      <!-- Left Side - Image -->
      <div class="hidden md:flex md:w-1/2 bg-gray-100 relative overflow-hidden items-center justify-center">
        <div class="relative z-10 flex items-center justify-center w-full h-full">
          <img src="/2f44839c43532837e4d02666db098ab46d08fa1e.png" alt="Person with phone" class="h-full object-cover" />
        </div>
      </div>

      <!-- Right Side - Form -->
      <div class="w-full md:w-1/2 p-8 pt-12">
        <!-- Header -->
        <div class="mb-6">
          <h2 class="text-[27px] font-medium text-[#416887] leading-[30px] tracking-[-0.02em] uppercase">
            REGISTER TO learn more
          </h2>
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
