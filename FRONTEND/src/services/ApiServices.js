import * as storage from '../utils/Storage';
import { apiUrlBase } from './ApiUrl';


export const get = (url) => {
    return fetch(apiUrlBase + url,{
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
            //, 'Authorization-Token': storage.getToken()
        }
    });
}

export const post = (url, payload) => {
    return fetch(apiUrlBase + url,{
        method: 'POST',
        body: JSON.stringify(payload),
        headers: {
            'Content-Type': 'application/json'
            //, 'Authorization-Token': storage.getToken()
        }
    });
}

export const patch = (url) => {
    return fetch(storage.getConfig().apiUrlBase + url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
            //, 'Authorization-Token': storage.getToken()
        }
    });
}

export const getFile = (url) => {
    return fetch(storage.getConfig().apiUrlBase + url,{
        method: 'GET',
        headers: {
            //'Authorization-Token': storage.getToken()
        }
    });
}

export const postFile = (url, payload) => {
    return fetch(storage.getConfig().apiUrlBase + url,{
        method: 'POST',
        body: payload,
        headers: {
            //'Authorization-Token': storage.getToken()
        }
    });
}

export const put = (url, payload) => {
    return fetch(storage.getConfig().apiUrlBase + url,{
        method: 'PUT',
        body: JSON.stringify(payload),
        headers: {
            'Content-Type': 'application/json'
            //, 'Authorization-Token': storage.getToken()
        }
    });
}

export const remove = (url) => {
    return fetch(storage.getConfig().apiUrlBase + url,{
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
            //, 'Authorization-Token': storage.getToken()
        }
    });
}