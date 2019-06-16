class DashboardForm {
    constructor(data) {
        this.originalData = JSON.parse(JSON.stringify(data));

        Object.assign(this, data);

        this.errors = {};
        this.submitted = false;
    }

    data(){
        return Object.keys(this.originalData).reduce((data, attr) => {
            data[attr] = this[attr];

            return data;
        }, {});
    }

    patch(endpoint) {
        return this.submit(endpoint, 'patch');
    }

    delete(endpoint) {
        return this.submit(endpoint, 'delete');
    }

    post(endpoint) {
        return this.submit(endpoint);
    }

    submit(endpoint, requestType = 'post') {
        return axios[requestType](endpoint, this.data())
            .then(this.onSuccess.bind(this))
            .catch(this.onFail.bind(this));
    }

    onSuccess(response) {
        this.submitted = true;
        this.errors = {};

        return response;
    }

    onFail(error){
        this.errors = error.response.data.errors;
        this.submitted = false;

        throw error;
    }

    reset(){
        Object.assign(this, this.originalData);
    }
}

export default DashboardForm;
