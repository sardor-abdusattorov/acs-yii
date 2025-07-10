$(document).ready(function () {
    let previewImages = document.querySelectorAll('.card .preview');
    if (previewImages) {
        previewImages.forEach(function(previewImage) {

            const defaultImageSrc = previewImage.parentNode.parentNode.querySelector('img').src;

            previewImage.onchange = function(e) {
                const [file] = previewImage.files;
                if (file) {
                    this.parentNode.parentNode.querySelector('img').src = URL.createObjectURL(file);
                }
            };

            const resetImage = function() {
                previewImage.value = '';
                previewImage.parentNode.parentNode.querySelector('img').src = defaultImageSrc;
            };

            const resetButton = previewImage.parentNode.parentNode.querySelector('.reset-button');
            if (resetButton) {
                resetButton.addEventListener('click', resetImage);
            }
        });
    }

})