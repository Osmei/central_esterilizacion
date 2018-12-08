import React, { Component } from 'react';
import { Card, CardHeader, CardBody, Button } from 'reactstrap';

import InstrumentalGrilla from '../../components/Instrumental/InstrumentalGrilla';
import { getInstrumentales } from '../../services/InstrumentalServices';

class Dashboard extends Component{
    state = {
        instrumentales: [],

        loaded: false
    }

    componentDidMount(){
        const that = this;
        const miState = {...this.state};

        getInstrumentales().then(result=>result.json())
        .then(
            result => {
                miState.instrumentales = result;

                miState.loaded = true;
                that.setState(miState);
        });
    }

    render(){
        if(!this.state.loaded)
            return null;
            
        return(
        <Card>
            <CardHeader style={{fontSize:"1.5em"}}>
                <strong> Instrumentales Registrados </strong>
            </CardHeader>
            <CardBody>
                <InstrumentalGrilla instrumentales={this.state.instrumentales}    />
            </CardBody>
        </Card>
        );
    }
}

export default Dashboard;
