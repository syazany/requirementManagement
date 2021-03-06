const resource = 'requirements'

window.axios = require('axios');

export default {
    all(requirementId) {
        return axios.get(`/api/requirements/${requirementId}/comments`);
    },
    store(requirementId, payload) {
        return axios.post(`/api/${resource}/${requirementId}/comments`, payload)
    }
}
