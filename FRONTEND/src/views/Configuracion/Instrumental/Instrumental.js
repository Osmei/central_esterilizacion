import React, { Component } from 'react';
import { Form, FormGroup, Card, CardHeader, CardBody, CardFooter, Row, Col, Button, Input, Label, Alert } from 'reactstrap';
import Select from 'react-select';

import { getOperadores } from '../../../services/OperadorServices';
import { getProveedores } from '../../../services/ProveedorServices';
import { getEmpresas } from '../../../services/EmpresaServices';
import { getMetodos } from '../../../services/MetodoServices';

import { nuevoInstrumental, getInstrumental } from '../../../services/InstrumentalServices';

class Instrumental extends Component{
    constructor(props){
        super(props);
        this.state = {
            instrumental: {
                id: null,
                operador: null,
                fecha: null,
                hora: null,
                paciente: null,
                numeroHistoriaClinica: null,
                descripcionMaterial: null,
                medicoSolicitante: null,
                pesoDeLaCaja: null,
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

        if(this.props.match.params.id){
            const idUrl = this.props.match.params.id;
            let p5 = getInstrumental(idUrl).then(result=>result.json());

            arrayPromises.push(p5);
        }

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
                
                if(that.props.history.location.pathname === "/configuracion/instrumental/ver/"+this.props.match.params.id){
                    miState.verDatos = true;
                }
                if(this.props.match.params.id){
                    miState.instrumental = result[4];
                }

                miState.loaded = true;
                that.setState(miState);
        });
    }

    submitForm(event){
        const miState = {...this.state};
        const that = this;

        let instrumental = {            
            id: null,
            operador: null,
            fecha: null,
            hora: null,
            paciente: null,
            numeroHistoriaClinica: null,
            descripcionMaterial: null,
            medicoSolicitante: null,
            pesoDeLaCaja: null,
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

                        that.setState(miState);
                        setTimeout(() => {
                            this.props.history.push("/");
                        }, 2500);
                    });
                }else if(result.status===400){
                    result.json()
                    .then(result=>{
                        miState.status = result;
                        miState.primeraVez = false;

                        that.setState(miState);
                    });
                }

            }
        )
    }

    render(){
        let miState = {...this.state};
        if(!miState.loaded)
            return null;
        
        let mensaje = null;
        mensaje =   !miState.primeraVez ?
                        miState.status.codigo === 2001  ?
                            (<Alert color="success">
                                <strong>{miState.status.mensaje}</strong>
                                <br />
                                Usted será redirigido al inicio
                            </Alert>)   : 
                        miState.status.codigo === 4000  ?
                            (<Alert color="danger">
                                <strong>{miState.status.mensaje}</strong>
                                <ul>
                                    {
                                        miState.status.detalle.map((detalle, index)=>{
                                            return(
                                                <li key={index}>{detalle}</li>
                                            )
                                        })
                                    }
                                </ul>
                            </Alert>)   : null
                        :   null

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
                                        value={ this.state.operadores.find(e => e.value === parseInt(this.state.instrumental.operador))}
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
                                <Label htmlFor="numeroHistoriaClinica">Número de Historia Clínica</Label>
                                <Input  type="text" placeholder="Ingresar Número de Historia Clínica"
                                        id="numeroHistoriaClinica"  name="numeroHistoriaClinica"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.numeroHistoriaClinica ? this.state.instrumental.numeroHistoriaClinica : ''}
                                        onChange={this.handleInput}
                                />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row>
                        <Col xs="4">
                            <FormGroup>
                                <Label htmlFor="descripcionMaterial">Descripción del Material</Label>
                                <Input  type="text" placeholder="Ingresar Descripción del Material"
                                        id="descripcionMaterial"  name="descripcionMaterial"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.descripcionMaterial ? this.state.instrumental.descripcionMaterial : ''}
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
                                <Label htmlFor="pesoDeLaCaja">Peso de la Caja</Label>
                                <Input  type="text" placeholder="Ingresar Peso de la Caja"
                                        id="pesoDeLaCaja"  name="pesoDeLaCaja"
                                        disabled={this.state.verDatos ? "true" : ""}
                                        value={this.state.instrumental.pesoDeLaCaja ? this.state.instrumental.pesoDeLaCaja : ''}
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
                                        value={ this.state.proveedores.find(e => e.value === parseInt(this.state.instrumental.proveedor))}
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
                                        value={ this.state.empresas.find(e => e.value === parseInt(this.state.instrumental.empresa))}
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
                                        value={ this.state.metodos.find(e => e.value === parseInt(this.state.instrumental.metodo))}
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
                        <Col xs="12">
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
                        onClick={()=>this.props.history.push("/")}>
                    Cancelar
                </Button>
            </CardFooter>
        </Card>
        );
    }
}

export default Instrumental;
