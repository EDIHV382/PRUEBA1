import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('pagos-table-body');
    if (!tableBody) {
        return;
    }

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

    const flashContainer = document.getElementById('flash-messages-data');
    if (flashContainer) {
        const flashMessages = JSON.parse(flashContainer.textContent);
        for (const type in flashMessages) {
            flashMessages[type].forEach(message => {
                if (message) showNotification(message, type);
            });
        }
    }

    const deleteModalElement = document.getElementById('modalEliminarPago');
    if (deleteModalElement) {
        const deleteModal = new bootstrap.Modal(deleteModalElement);
        const pagoInfoSpan = document.getElementById('delete-pago-info');
        const deleteForm = document.getElementById('delete-pago-form');
        const csrfTokenInput = document.getElementById('delete-csrf-token-pago');
        document.body.addEventListener('click', (event) => {
            const deleteButton = event.target.closest('.delete-pago-btn');
            if (deleteButton) {
                if (pagoInfoSpan) pagoInfoSpan.innerHTML = deleteButton.dataset.pagoInfo;
                if (deleteForm) deleteForm.action = deleteButton.dataset.deleteUrl;
                if (csrfTokenInput) csrfTokenInput.value = deleteButton.dataset.csrfToken;
                deleteModal.show();
            }
        });
    }

    const handleFormSubmit = async (form, successCallback) => {
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonHtml = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Procesando...`;
        try {
            const response = await fetch(form.action, { method: form.method, body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();
            if (!response.ok) throw new Error(data.errors ? data.errors.join('<br>') : 'Ocurrió un error.');
            showNotification(data.message, 'success');
            if (successCallback) successCallback(data);
        } catch (error) {
            showNotification(error.message, 'danger');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonHtml;
        }
    };

    document.body.addEventListener('submit', (event) => {
        const form = event.target.closest('form');
        if (!form || !form.closest('.modal') || form.id === 'delete-pago-form') return;
        event.preventDefault();

        const successCallback = (data) => {
            const isCreating = form.id === 'form-registrar-pago';
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = `<table><tbody>${data.newRowHtml}</tbody></table>`;
            const newRow = tempDiv.querySelector('tr');

            if (isCreating) {
                document.getElementById('no-pagos-row')?.remove();
                tableBody.appendChild(newRow);
                document.getElementById('modals-pagos-container').insertAdjacentHTML('beforeend', data.newEditModalHtml);
            } else {
                document.getElementById(`pago-row-${data.entidadId}`)?.replaceWith(newRow);
            }
            bootstrap.Modal.getInstance(form.closest('.modal')).hide();
            if (isCreating) form.reset();
        };
        
        handleFormSubmit(form, successCallback);
    });

    const buscador = document.getElementById('buscador-pagos');
    if (buscador && tableBody) {
        buscador.addEventListener('input', e => {
            const termino = e.target.value.toLowerCase();
            const filas = tableBody.querySelectorAll('tr');
            filas.forEach(fila => {
                if (fila.id === 'no-pagos-row') return;
                fila.style.display = fila.innerText.toLowerCase().includes(termino) ? 'table-row' : 'none';
            });
        });
    }
});