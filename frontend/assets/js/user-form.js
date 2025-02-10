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

    const submitForm = async () => {
      // Prevent default form submission
      // Handle form submission here
      console.log('Form submitted:', formData.value);

      try {
        const response = await fetch('includes/update_customer.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams(formData.value).toString()
        });

        const data = await response.json();

        if (data.status === 'success') {
          alert(data.message); // Show success message
        } else {
          alert(data.message); // Show error message
        }
      } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while updating your profile.'); // Show generic error message
      }
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
