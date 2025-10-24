import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const postDetailModalEl = document.getElementById('postDetailModal');
    if (!postDetailModalEl) return;

    const postDetailModal = new bootstrap.Modal(postDetailModalEl);
    
    const postsContainer = document.querySelector('.posts-grid');
    if (!postsContainer) return;

    postsContainer.addEventListener('click', async (event) => {
        const readMoreButton = event.target.closest('.read-more-btn');
        if (!readMoreButton) return;

        event.preventDefault();
        const postId = readMoreButton.dataset.postId;
        const postUrl = `/blog/post/${postId}`;

        const modalTitle = postDetailModalEl.querySelector('.modal-title');
        const modalBody = postDetailModalEl.querySelector('#modal-post-body');
        const modalImage = postDetailModalEl.querySelector('#modal-post-image');
        const modalMeta = postDetailModalEl.querySelector('#modal-post-meta');

        modalTitle.textContent = 'Cargando...';
        modalBody.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
        modalImage.style.display = 'none';
        modalMeta.textContent = '';
        postDetailModal.show();

        try {
            const response = await fetch(postUrl);
            if (!response.ok) throw new Error('No se pudo cargar la publicación.');
            
            const post = await response.json();
            
            modalTitle.textContent = post.title;
            
            if (post.imageUrl) {
                modalImage.src = post.imageUrl;
                modalImage.alt = post.title;
                modalImage.style.display = 'block';
            }
            
            modalMeta.textContent = `${post.category} - ${post.createdAt}`;
            modalBody.innerHTML = post.content;

        } catch (error) {
            modalBody.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        }
    });
});