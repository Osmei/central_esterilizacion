import { get, post } from './ApiServices';
import * as storage from '../utils/Storage';

export const login = (usuario, password) => {
    return post("public/auth/login", {
        usuario: usuario,
        clave: password
    });
}

export const forgotPassword = (usuario) => {
    return post("public/auth/forgotpassword", {
        usuario: usuario
    });
}

export const recoverPassword = (activationKey, clave) => {
    return post("public/auth/recoverPassword/" + activationKey, {
        clave: clave
    });
}

export const user = (activationKey) => {
    return get("public/auth/usuario/" + activationKey);
}

export const logout = () => { 
    return get("auth/logout");
}

export const checkToken = () => {
    return get("auth/check");
}

export const checkSession = () => {
    return new Promise((resolve, reject) => {
        if (!isAuthenticated()) {
            resolve(false);
        } else {
            checkToken()
            .then(response => {
                if (response.status === 200) {
                    resolve(true);
                } else {
                    storage.clearToken(); 
                    resolve(false);
                }
            })
            .catch(() => {
                storage.clearToken();
                resolve(false);
            });
        }
    });
}

export const isAuthenticated = () => {
    const token = storage.getToken();
    return typeof(token) !== undefined && token !== null
}