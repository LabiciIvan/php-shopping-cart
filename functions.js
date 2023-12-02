const addToCart = (key) => {

	fetch('./process.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify({key: key})
	})
	.then((response) => {
		console.log('resp', response.body);

		if (!response.ok) {
			console.log(response.status)
		}

		return response.json();
	})
	.then((data) => {
		console.log('Data received : ', data);
	});

	window.location.reload();
}