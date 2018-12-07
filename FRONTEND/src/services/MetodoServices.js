import { get } from './ApiServices';

export const getMetodos = () => {
    return get("metodos")
}