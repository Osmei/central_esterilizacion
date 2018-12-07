import { get } from './ApiServices';

export const getEmpresas = () => {
    return get("empresasEsterilizadoras")
}