const letterInput = document.querySelector('input[name="letter"]');

letterInput.addEventListener('input', e => {
	const text = e.target.value;
	const filteredText = text.replace(/[^a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]/g, '').toUpperCase();
	if (filteredText !== text) {
		event.target.value = filteredText;
	}
});
