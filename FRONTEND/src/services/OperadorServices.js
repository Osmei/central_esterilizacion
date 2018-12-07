import { get } from './ApiServices';

export const getOperadores = () => {
    return get("operadoresCE")
}