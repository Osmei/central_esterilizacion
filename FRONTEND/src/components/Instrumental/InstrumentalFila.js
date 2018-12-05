import React from 'react';
import { Button } from 'reactstrap';

const InstrumentalFila = (props) => {

    const alignCol = {
        textAlign: "right"    
    }
    return(
        <tr>
            <td>{props.item.nombre}</td>
            <td>{props.item.categoria}</td>
            <td>{props.item.cantidad}</td>
            <td>{props.item.precio}</td>
            <td style={alignCol}>
                <Button outline className="btn-pill" color="primary">Modificar</Button>
            </td>
        </tr>        
    );
}

export default InstrumentalFila;