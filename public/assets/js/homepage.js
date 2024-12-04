document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#register-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch('/final-project-template/public/api/users/register', {
                method: 'POST',
                body: formData,
            });

            const contentType = response.headers.get('Content-Type');
            const textResponse = await response.text();

            if (contentType && contentType.includes('application/json')) {
                const jsonResponse = JSON.parse(textResponse);

                if (response.ok && jsonResponse.success) {
                    alert(jsonResponse.success);
                    form.reset();
                } else {
                    alert('Error: ' + (jsonResponse.error || 'Unknown error occurred.'));
                }
            } else {
                console.error('Non-JSON response:', textResponse);
                alert('Non-JSON response received from the server.');
            }
        } catch (error) {
            console.error('Fetch error:', error.message);
            alert('An error occurred. Check the console for details.');
        }
    });
});