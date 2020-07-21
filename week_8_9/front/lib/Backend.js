export default axios.create({
	baseURL: "http://back",
	withCredentials: true,
	headers: {
		"Content-Type": "multipart/form-data",
	},
	transformRequest: (data, headers) => {
		const form = new FormData;

		for(let key in data)
			form.set(key, data[key]);

		return form;
	},
});
