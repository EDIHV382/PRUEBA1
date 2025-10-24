import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
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
            const data = await response.json();
            if (!response.ok) throw new Error(data.errors ? data.errors.join('<br>') : 'Ocurrió un error.');
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

    const grid = document.querySelector('.patient-card-grid');
    const historialContainer = document.getElementById('historial-container');
    const buscador = document.getElementById('buscador-pacientes');

    if (!grid || !historialContainer || !buscador) return;

    // Lógica del Buscador de Pacientes
    buscador.addEventListener('input', e => {
        const termino = e.target.value.toLowerCase();
        const cards = grid.querySelectorAll('.col');
        cards.forEach(cardCol => {
            const cardText = cardCol.querySelector('.patient-card')?.innerText.toLowerCase();
            if (cardText) {
                cardCol.style.display = cardText.includes(termino) ? '' : 'none';
            }
        });
    });

    // Lógica para cargar el historial
    grid.addEventListener('click', async (event) => {
        const card = event.target.closest('.patient-card');
        if (!card) return;

        grid.querySelectorAll('.patient-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        const pacienteId = card.dataset.pacienteId;
        historialContainer.innerHTML = '<div class="text-center p-5"><div class="spinner-border"></div><p class="mt-2">Cargando historial...</p></div>';

        try {
            const response = await fetch(`/consultas/historial/${pacienteId}`);
            if (!response.ok) throw new Error('No se pudo cargar el historial.');
            const data = await response.json();
            historialContainer.innerHTML = data.html;
        } catch (error) {
            historialContainer.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        }
    });

    // Lógica para las acciones DENTRO del historial cargado
    historialContainer.addEventListener('submit', (event) => {
        const form = event.target.closest('form');
        if (!form) return;
        
        event.preventDefault();

        if (form.id.startsWith('form-registrar-consulta') || form.id.startsWith('form-editar-consulta')) {
            handleAjaxFormSubmit(form, (data) => {
                const isCreating = form.id.startsWith('form-registrar-consulta');
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = `<table><tbody>${data.newRowHtml}</tbody></table>`;
                const newRow = tempDiv.querySelector('tr');
                const tableBody = historialContainer.querySelector('#consultas-table-body');
                
                if (isCreating) {
                    tableBody.prepend(newRow);
                    historialContainer.querySelector('#no-consultas-row')?.remove();
                    historialContainer.querySelector('#modals-consultas-container').insertAdjacentHTML('beforeend', data.newEditModalHtml);
                    form.reset();
                } else {
                    document.getElementById(`consulta-row-${data.entidadId}`)?.replaceWith(newRow);
                }
                bootstrap.Modal.getInstance(form.closest('.modal'))?.hide();
            });
        }
        
        if (form.id === 'delete-consulta-form') {
            handleAjaxFormSubmit(form, () => {
                const urlParts = form.action.split('/');
                const id = urlParts[urlParts.length - 2];
                document.getElementById(`consulta-row-${id}`)?.remove();
                bootstrap.Modal.getInstance(document.getElementById('modalEliminarConsulta'))?.hide();
            });
        }
    });

    historialContainer.addEventListener('click', (event) => {
        const deleteButton = event.target.closest('.delete-consulta-btn');
        if (deleteButton) {
            const deleteModalEl = document.getElementById('modalEliminarConsulta');
            if (deleteModalEl) {
                const deleteModal = bootstrap.Modal.getOrCreateInstance(deleteModalEl);
                deleteModalEl.querySelector('#delete-consulta-info').innerHTML = deleteButton.dataset.consultaInfo;
                deleteModalEl.querySelector('form').action = deleteButton.dataset.deleteUrl;
                deleteModalEl.querySelector('input[name="_token"]').value = deleteButton.dataset.csrfToken;
                deleteModal.show();
            }
        }
    });
});