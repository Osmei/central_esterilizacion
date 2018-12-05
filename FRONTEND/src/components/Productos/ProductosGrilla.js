import React from 'react';
import { Table } from 'reactstrap';

import ProductoFila from './ProductoFila'

const ProductosGrilla = (props) => {    
    return(
        <Table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>            
            {
                props.productos.map((producto, index) => {                    
                    return(
                            <ProductoFila   key={index}
                                            item={producto} />                            
                            )
                })
            }
            </tbody>                        
        </Table>
    );
}

export default ProductosGrilla;