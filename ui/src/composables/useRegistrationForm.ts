import { ref } from 'vue'
import { useFormModalStore } from '@/stores/formModal'
import { formService } from '@/services'

export interface FormData {
  firstName: string
  lastName: string
  phone: string
  email: string
  agreeToTerms: boolean
}

export const useRegistrationForm = () => {
  const formModal = useFormModalStore()
  const isSubmitting = ref(false)
  const submitMessage = ref('')
  const submitError = ref('')

  const initialFormData: FormData = {
    firstName: '',
    lastName: '',
    phone: '',
    email: '',
    agreeToTerms: false
  }

  const formData = ref<FormData>({ ...initialFormData })

  const resetForm = () => {
    formData.value = { ...initialFormData }
    submitMessage.value = ''
    submitError.value = ''
  }

  const handleSubmit = async () => {
    isSubmitting.value = true
    submitError.value = ''
    submitMessage.value = ''

    try {
      const response = await formService.submitRegistration(formData.value)

      if (response.success) {
        submitMessage.value = response.message || 'Registration successful!'

        // Reset form after 2 seconds and close modal
        setTimeout(() => {
          formModal.closeModal()
          resetForm()
        }, 2000)
      }
    } catch (error: any) {
      submitError.value = error.message || 'Failed to submit form. Please try again.'
      console.error('Form submission error:', error)
    } finally {
      isSubmitting.value = false
    }
  }

  return {
    formData,
    isSubmitting,
    submitMessage,
    submitError,
    handleSubmit,
    resetForm
  }
}
