import React from 'react';
import ReactToolTip from 'react-tooltip';
import { withRouter } from 'react-router-dom';

const InstrumentalFila = (props) => {

    return(
        <tr>
            <td>{props.instrumental.operador}</td>
            <td>{props.instrumental.paciente}</td>
            <td>{props.instrumental.numeroHistoriaClinica}</td>
            <td>{props.instrumental.medicoSolicitante}</td>
            <td>
                <i  className="fa fa-search fa-lg"
                    data-tip="Ver Información"
                    onClick={()=>props.history.push("/configuracion/instrumental/ver")} />
                <ReactToolTip   place="top" type="info" effect="float"  />
            </td>
        </tr>        
    );
}

export default withRouter(InstrumentalFila);