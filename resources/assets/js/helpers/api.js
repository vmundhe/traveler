import axios from 'axios'

export function post(url, payload) {
    return axios({
        method: 'POST',
        url: url,
        data: payload
    })
}