import React, { Component } from 'react';
import { Form, Card, CardHeader, CardBody, CardFooter, Row, Col, Button, Input, Label } from 'reactstrap';
import Select from 'react-select';

class Instrumental extends Component{
    constructor(props){
        super(props);

        this.submitForm = this.submitForm.bind(this);
    }

    submitForm(event){
        alert("A");
    }


    render(){
        const distanciaRows = {
            marginBottom: "1.5em"
        }
        return(
        <Card> 
            <CardHeader>
                <h4>Registrar Instrumental</h4>
            </CardHeader>       
            <CardBody>                
                    <Row style={distanciaRows}>
                        <Col xs="4">
                            <Label htmlFor="operadorCE">Operador CE</Label>
                            <Select />
                        </Col>
                        <Col xs="4">
                            <Label htmlFor="fecha">Fecha</Label>
                            <Input />
                        </Col>
                        <Col xs="4">
                            <Label htmlFor="hora">Hora</Label>
                            <Input />
                        </Col>
                    </Row>
                    <Row style={distanciaRows}>
                        <Col xs="6">
                            <Label htmlFor="paciente">Paciente</Label>
                            <Input />
                        </Col>
                        <Col xs="6">
                            <Label htmlFor="nroHistoriaClinica">Número de Historia Clínica</Label>
                            <Input />
                        </Col>
                    </Row>
                    <Row style={distanciaRows}>
                        <Col xs="4">
                            <Label htmlFor="descripcion">Descripción del Material</Label>
                            <Input />
                        </Col>
                        <Col xs="4">
                            <Label htmlFor="medicoSol">Médico Solicitante</Label>
                            <Input />
                        </Col>
                        <Col xs="4">
                            <Label htmlFor="peso">Peso de la Caja</Label>
                            <Input />
                        </Col>
                    </Row>
                    <Row style={distanciaRows}>
                        <Col xs="4">
                            <Label htmlFor="proveedor">Proveedor</Label>
                            <Select />
                        </Col>
                        <Col xs="4">
                            <Label htmlFor="empresaEsterilizadora">Empresa Esterilizadora</Label>
                            <Select />
                        </Col>
                        <Col xs="4">
                            <Label htmlFor="metodoEsterilizacion">Método de Esterilización</Label>
                            <Select />
                        </Col>
                    </Row>
                    <Row style={distanciaRows}>
                        <Col xs="12">
                            <Label htmlFor="observaciones">Observaciones</Label>
                            <Input type="textarea" />
                        </Col>
                    </Row>                
            </CardBody>
            <CardFooter style={{textAlign: "right"}}>
                <Button color="success" className="mr-1"
                        onClick={(e)=>this.submitForm(e)}>
                    Registrar
                </Button>
                <Button color="danger">
                    Cancelar
                </Button>
            </CardFooter>
        </Card>
        );
    }
}

export default Instrumental;
