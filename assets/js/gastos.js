import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('gastos-table-body');
    if (!tableBody) return;

    const showNotification = (message, type = 'success') => {
        const container = document.getElementById('notification-container');
        if (!container) return;
        const toastId = 'toast-' + Date.now();
        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex"><div class="toast-body">${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
            </div>`;
        container.insertAdjacentHTML('beforeend', toastHtml);
        const toastElement = document.getElementById(toastId);
        const bsToast = new bootstrap.Toast(toastElement, { delay: 5000 });
        bsToast.show();
        toastElement.addEventListener('hidden.bs.toast', () => toastElement.remove());
    };

    const handleAjaxFormSubmit = async (form, successCallback) => {
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonHtml = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Procesando...`;
        try {
            const response = await fetch(form.action, { method: form.method, body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            
            const contentType = response.headers.get("content-type");
            if (!response.ok) {
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    const errorData = await response.json();
                    throw new Error(errorData.errors ? errorData.errors.join('<br>') : 'Ocurrió un error.');
                } else {
                    throw new Error('Ocurrió un error en el servidor. Revisa la pestaña "Network" para más detalles.');
                }
            }

            const data = await response.json();
            showNotification(data.message, 'success');
            if (successCallback) successCallback(data);
        } catch (error) {
            showNotification(error.message, 'danger');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonHtml;
            }
        }
    };

    document.body.addEventListener('submit', (event) => {
        const form = event.target.closest('form');
        if (form && form.id === 'form-registrar-gasto') {
            event.preventDefault();
            handleAjaxFormSubmit(form, (data) => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = `<table><tbody>${data.newRowHtml}</tbody></table>`;
                const newRow = tempDiv.querySelector('tr');
                
                tableBody.prepend(newRow);
                document.getElementById('no-gastos-row')?.remove();
                bootstrap.Modal.getInstance(form.closest('.modal'))?.hide();
                form.reset();
            });
        }
    });
});