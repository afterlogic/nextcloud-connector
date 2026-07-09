document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.afterlogic-ajax-form').forEach(form => {

        if (form.dataset.formInited) {
            return;
        }

        form.dataset.formInited = '1';

        const ajaxFile = form.dataset.ajaxFile;
        const submit = form.querySelector('.afterlogic-save-button');
        const result = form.querySelector('.afterlogic-result');

        if (!ajaxFile || !submit || !result) {
            console.error('Afterlogic: form initialization failed.');
            return;
        }

        form.addEventListener('submit', async (event) => {

            event.preventDefault();

            form.classList.remove('afterlogic-error', 'afterlogic-success');
            form.classList.add('afterlogic-ajax');

            result.textContent = '';

            const originalValue = submit.value;
            submit.value = submit.dataset.ajaxButtonValue;

            try {
                const response = await fetch(
                    OC.generateUrl('/apps/afterlogic/ajax/' + ajaxFile),
                    {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'requesttoken': OC.requestToken
                        }
                    }
                );

                let data = {};

                try {
                    data = await response.json();
                } catch (e) {
                    console.error('Invalid JSON response', e);
                }

                if (response.ok && data.status === 'success') {
                    form.classList.add('afterlogic-success');
                } else {
                    form.classList.add('afterlogic-error');
                }

                result.textContent = data.Message || ('HTTP ' + response.status);

            } catch (e) {

                console.error(e);

                form.classList.add('afterlogic-error');
                result.textContent = 'Connection error';

            } finally {

                form.classList.remove('afterlogic-ajax');
                submit.value = originalValue;

            }

        });

    });

});