import type { FormData } from '@/composables/useRegistrationForm'

export interface RegistrationFormProps {
  formData: FormData
  isSubmitting: boolean
  submitMessage: string
  submitError: string
}

export type RegistrationFormEmits = {
  'update:formData': [value: FormData]
  submit: []
}

export const useRegistrationFormComponent = () => {
  const handleSubmit = () => {
    // Emit submit event to parent
    // Parent will call the actual submit handler
  }

  return {
    handleSubmit
  }
}
