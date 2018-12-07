import { get } from './ApiServices';

export const getProveedores = () => {
    return get("proveedores")
}