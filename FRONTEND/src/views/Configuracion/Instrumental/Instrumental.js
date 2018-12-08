import React, { Component } from 'react';
import { Form, FormGroup, Card, CardHeader, CardBody, CardFooter, Row, Col, Button, Input, Label, Alert } from 'reactstrap';
import Select from 'react-select';

import { getOperadores } from '../../../services/OperadorServices';
import { getProveedores } from '../../../services/ProveedorServices';
import { getEmpresas } from '../../../services/EmpresaServices';
import { getMetodos } from '../../../services/MetodoServices';

import { nuevoInstrumental } from '../../../services/InstrumentalServices';

class Instrumental extends Component{
    constructor(props){
        super(props);
        this.state = {
            instrumental: {
                operador: null,
                fecha: null,
                hora: null,
                paciente: null,
                nroHistoriaClinica: null,
                descripcion: null,
                medicoSolicitante: null,
                peso: null,
                proveedor: null,
                empresa: null,
                metodo: null,
                observaciones: null
            },
            status: {
                codigo: null,
                mensaje: null,
                detalle: []
            },
            primeraVez: true,
            operadores: [],
            proveedores: [],
            empresas: [],
            metodos: [],

            verDatos: false,

            loaded: false
        }
        this.submitForm = this.submitForm.bind(this);
        this.handleSelect = this.handleSelect.bind(this);
        this.handleInput = this.handleInput.bind(this);
    }

    handleInput(event){
        const miState = {...this.state};

        if(event != null){
            miState.instrumental[event.target.name] = event.target.value;
        }else{
            miState.instrumental[event.target.name] = null;
        }

        this.setState(miState);
    }

    handleSelect(opcion, event){
        let miState = {...this.state};  
        
        if(event != null){
            miState.instrumental[opcion] = event.value;
        }else{
            miState.instrumental[opcion] = null;
        }
        

        this.setState(miState);        
    }

    componentDidMount(){
        let arrayPromises = [];
        const miState = {...this.state};
        const that = this;

        let p1 = getOperadores().then(result=>result.json());
        let p2 = getProveedores().then(result=>result.json());
        let p3 = getEmpresas().then(result=>result.json());
        let p4 = getMetodos().then(result=>result.json());

        arrayPromises.push(p1,p2,p3,p4);

        Promise.all(arrayPromises)
        .then(
            (result) => {
                miState.operadores = result[0].map((operador, index) => {
                    return (
                        {value: operador.id, label: operador.nombre}
                    )
                })
                miState.proveedores = result[1].map((proveedor, index) => {
                    return (
                        {value: proveedor.id, label: proveedor.nombre}
                    )
                })
                miState.empresas = result[2].map((empresa, index) => {
                    return (
                        {value: empresa.id, label: empresa.nombre}
                    )
                })
                miState.metodos = result[3].map((metodo, index) => {
                    return (
                        {value: metodo.id, label: metodo.nombre}
                    )
                })
                
                if(that.props.history.location.pathname === "/configuracion/instrumental/ver"){
                    miState.verDatos = true;
                }

                miState.loaded = true;
                that.setState(miState);
        });
    }

    submitForm(event){
        const miState = {...this.state};
        let instrumental = {            
            operador: null,
            fecha: null,
            hora: null,
            paciente: null,
            nroHistoriaClinica: null,
            descripcion: null,
            medicoSolicitante: null,
            peso: null,
            proveedor: null,
            empresa: null,
            metodo: null,
            observaciones: null
        }
        instrumental = miState.instrumental;

        nuevoInstrumental(instrumental)
        .then(
            (result) => {
                if(result.status===201){
                    result.json()
                    .then(result=>{
                        miState.status = {
                            codigo: 2001,
                            mensaje: "Instrumental Creado Correctamente",
                            detalle: []
                        }
                        miState.primeraVez = false;
                    });
                }else if(result.status===400){
                    result.json()
                    .then(result=>{
                        miState.status = result;
                        miState.primeraVez = false;
                    });
                }

                this.setState(miState);
            }
        )
    }

    render(){
        if(!this.state.loaded)
            return null;

        let mensaje = null;
        if(!this.state.primeraVez){
            console.log("si?");
            if(this.state.status.codigo === 2001){
                console.log("estoy por acá");
                mensaje =
                    <Alert color="success">
                        {this.state.status.mensaje}
                    </Alert>
            }else if(this.state.status.codigo === 4000){
                console.log("estoy por allá");
                mensaje =
                    (<Alert color="danger">
                        {this.state.status.mensaje}
                    </Alert>)
            }
        }

        return(
        <Card> 
            <CardHeader>
                <h4>Registrar Instrumental</h4>
            </CardHeader>       
            <CardBody>
                <Form>
                    <Row>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="operadorCE">Operador CE</Label>
                                <Select name="operadorCE"  placeholder="Seleccionar un operador..."
                                        valueKey="value"    labelKey="label"
                                        isSearchable={true} isClearable={true}
                                        isDisabled={this.state.verDatos ? "true" : ""}
                                        options={this.state.operadores}
                                        value={ this.state.operadores.find(e => e.value === this.state.instrumental.operador)}
                                        onChange={(e) => this.handleSelect("operador", e)}
                                />
                            </FormGroup>
                        </Col>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="fecha">Fecha</Label>
                                <Input  type="date" placeholder="Ingresar Fecha"
                                        id="fecha"  name="fecha"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.fecha ? this.state.instrumental.fecha : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="hora">Hora</Label>
                                <Input  type="time" placeholder="Ingresar Hora"
                                        id="hora"  name="hora"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.hora ? this.state.instrumental.hora : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row>
                        <Col xs="6">
                            <FormGroup>
                                <Label htmlFor="paciente">Paciente</Label>
                                <Input  type="text" placeholder="Ingresar Paciente"
                                        id="paciente"  name="paciente"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.paciente ? this.state.instrumental.paciente : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                        <Col xs="6">
                            <FormGroup>
                                <Label htmlFor="nroHistoriaClinica">Número de Historia Clínica</Label>
                                <Input  type="text" placeholder="Ingresar Número de Historia Clínica"
                                        id="nroHistoriaClinica"  name="nroHistoriaClinica"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.nroHistoriaClinica ? this.state.instrumental.nroHistoriaClinica : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="descripcion">Descripción del Material</Label>
                                <Input  type="text" placeholder="Ingresar Descripción del Material"
                                        id="descripcion"  name="descripcion"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.descripcion ? this.state.instrumental.descripcion : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="medicoSolicitante">Médico Solicitante</Label>
                                <Input  type="text" placeholder="Ingresar Médico Solicitante"
                                        id="medicoSolicitante"  name="medicoSolicitante"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.medicoSolicitante ? this.state.instrumental.medicoSolicitante : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="peso">Peso de la Caja</Label>
                                <Input  type="text" placeholder="Ingresar Peso de la Caja"
                                        id="peso"  name="peso"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.peso ? this.state.instrumental.peso : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="proveedor">Proveedor</Label>
                                <Select name="proveedor"  placeholder="Seleccionar un proveedor..."
                                        valueKey="value"    labelKey="label"
                                        isSearchable={true} isClearable={true}
                                        options={this.state.proveedores}
                                        isDisabled={this.state.verDatos ? "true" : ""}
                                        value={ this.state.proveedores.find(e => e.value === this.state.instrumental.proveedor)}
                                        onChange={(e) => this.handleSelect("proveedor", e)}
                                />
                            </FormGroup>
                        </Col>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="empresa">Empresa Esterilizadora</Label>
                                <Select name="empresa"  placeholder="Seleccionar una empresa..."
                                        valueKey="value"    labelKey="label"
                                        isSearchable={true} isClearable={true}
                                        options={this.state.empresas}
                                        isDisabled={this.state.verDatos ? "true" : ""}
                                        value={ this.state.empresas.find(e => e.value === this.state.instrumental.empresa)}
                                        onChange={(e) => this.handleSelect("empresa", e)}
                                />
                            </FormGroup>
                        </Col>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="metodo">Método de Esterilización</Label>
                                <Select name="metodo"  placeholder="Seleccionar un método..."
                                        valueKey="value"    labelKey="label"
                                        isSearchable={true} isClearable={true}
                                        options={this.state.metodos}
                                        isDisabled={this.state.verDatos ? "true" : ""}
                                        value={ this.state.metodos.find(e => e.value === this.state.instrumental.metodo)}
                                        onChange={(e) => this.handleSelect("metodo", e)}
                                />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row>
                        <Col xs="12">
                            <FormGroup>
                                <Label htmlFor="observaciones">Observaciones</Label>
                                <Input  type="textarea" placeholder="Ingresar Observaciones"
                                        id="observaciones"  name="observaciones"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.observaciones ? this.state.instrumental.observaciones : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row>
                        <Col xs="4">
                            {mensaje}
                        </Col>
                    </Row>
                </Form>
            </CardBody>
            <CardFooter style={{textAlign: "right"}}>
                <Button color="success" className="mr-1"
                        onClick={(e)=>this.submitForm(e)}>
                    Registrar
                </Button>
                <Button color="danger"
                        onClick={()=>this.props.history.push("/configuracion/instrumental")}>
                    Cancelar
                </Button>
            </CardFooter>
        </Card>
        );
    }
}

export default Instrumental;
