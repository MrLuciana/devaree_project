import { createApp, ref } from 'vue';

createApp({
  setup() {
    const formData = ref({
      firstName: window.firstName || '',
      lastName: window.lastName || '',
      gender: '',
      birthDate: '',
      phone: '',
      email: window.email || '',
      address: ''
    });

    const submitForm = () => {
      // Handle form submission here
      console.log('Form submitted:', formData.value);
      // You can add your form submission logic here, e.g., using fetch or axios
    };

    const checkFields = () => {

      return formData.value.firstName && formData.value.lastName && formData.value.gender &&
        formData.value.birthDate && formData.value.phone &&
        formData.value.email && formData.value.address;
    }

    return {
      formData,
      submitForm,
      checkFields,
    };
  }
}).mount('#user-form');
