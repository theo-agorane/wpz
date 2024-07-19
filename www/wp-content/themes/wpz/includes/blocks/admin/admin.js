window.onload = () => {
	[].forEach.call(document.querySelectorAll('.blocks-create'), (form) => {
		form.addEventListener('submit', (e) => {
			const blockId = form.querySelector('[name="blocks-create-key"]').value;

			if (!confirm("Êtes-vous sûr de vouloir créer le Block « "+ blockId +" » ?")) {
				e.preventDefault();
				e.stopPropagation();
			}
		});
	});

	[].forEach.call(document.querySelectorAll('.blocks-delete'), (form) => {
		form.addEventListener('submit', (e) => {
			const blockId = form.querySelector('[name="blocks-delete-key"]').value;

			if (!confirm("Êtes-vous sûr de vouloir supprimer le Block « "+ blockId +" » ?")) {
				e.preventDefault();
				e.stopPropagation();
			}
		});
	});
}