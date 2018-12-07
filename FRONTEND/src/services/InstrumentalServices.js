import { get, post, put } from './ApiServices';

export const nuevoInstrumental = (instrumental) => {
    return post("materiales", instrumental);
}