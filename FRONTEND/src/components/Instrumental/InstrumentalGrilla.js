import React from 'react';
import { Table } from 'reactstrap';

import InstrumentalFila from './InstrumentalFila'

const InstrumentalGrilla = (props) => {    
    return(
        <Table>
            <thead>
                <tr>
                    <th>Operador</th>
                    <th>Paciente</th>
                    <th>Nro. Historia Clínica</th>
                    <th>Médico Solicitante</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            { props.instrumentales.map((instrumental, index)=> {
                return(
                    <InstrumentalFila   key={index}
                                        instrumental={instrumental} />
                )
            }) }
            </tbody>                        
        </Table>
    );
}

export default InstrumentalGrilla;