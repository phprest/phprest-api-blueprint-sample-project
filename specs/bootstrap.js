module.exports = {
	config: {
		url: 'http://localhost'
	},
	frisby: function() {
		var frisby = require('./node_modules/frisby');

		frisby.globalSetup({
			request: {
				headers: {
					'Accept': '*/*',
					'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXUyJ9.eyJ1aWQiOjEsImlhdCI6MTQ0ODIwMTQwN30.mZVAs4ZYmxB8HsjfIcpqMC4_nNJkjsBRPdnfvIx8yBg'
				}
			}
		});

		return frisby;
	}
};
