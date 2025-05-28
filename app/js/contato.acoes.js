(() => {
    document.getElementById('form_contato').addEventListener('submit', async function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const response = await fetch('email.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if (data.status === 'success') {
            document.getElementById('form_contato').reset();
            alert('Mensagem enviada com sucesso!');
        }
    })
})();