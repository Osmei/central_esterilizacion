import { get, post } from './ApiServices';

export const nuevoInstrumental = (instrumental) => {
    return post("materiales", instrumental);
}

export const getInstrumentales = () => {
    return get("materiales");
}

export const getInstrumental = (id) => {
    return get("materiales/"+id);
}