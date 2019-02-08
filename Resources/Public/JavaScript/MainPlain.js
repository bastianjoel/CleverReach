(function() {
    var cleaverreachForms = document.getElementsByClassName('cleverreach__form--ajax');

    for(var i = 0; i < cleaverreachForms.length; i++) {
        var currentForm = cleaverreachForms[i];

        currentForm.onsubmit = function (e) {
            e.preventDefault();
            var formData = new FormData(e.target);
            var submitButton = currentForm.querySelector('input[type="submit"]');

            submitButton.disabled = true;

            fetch(e.target.action, {
                method: e.target.method,
                body: formData
            }).then(response => {
                response.json().then(data => {
                    if (data.success) {
                        currentForm.style.display = 'none';
                    }

                    currentForm.parentElement.getElementsByClassName('cleverreach__errors')[0].innerHTML = '<p>' + data.message + '</p>';
                    submitButton.disabled = false;
                });
            }).catch(error => {
                console.error(error);
            });
        };
    }
})();