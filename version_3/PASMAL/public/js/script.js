document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('input-photo');
    const button = document.getElementById('btn-choisir');
    const apercu = document.getElementById('aperçu-photo');

    // Quand on clique sur "Choisir une photo"
    button.addEventListener('click', () => {
        input.click();
    });

    // Quand une photo est sélectionnée
    input.addEventListener('change', () => {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                apercu.src = e.target.result;
                apercu.hidden = false;
            };
            reader.readAsDataURL(file);
        }
    });
});
