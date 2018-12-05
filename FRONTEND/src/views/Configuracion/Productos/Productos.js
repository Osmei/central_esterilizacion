import React, { Component } from 'react';
import {Card, CardHeader, CardBody, CardFooter, Button} from 'reactstrap';
import ProductosGrilla from '../../../components/Productos/ProductosGrilla';

class Productos extends Component{
  state={
    productos:[
      {id: 1, nombre: "Lapiz", categoria: "A", cantidad: 16, precio: "5.00"},
      {id: 2, nombre: "Lapicera", categoria: "B", cantidad: 5, precio: "12.90"},
      {id: 3, nombre: "Hojas A4", categoria: "F", cantidad: 28, precio: "8.15"},
      {id: 4, nombre: "Regla 20cm", categoria: "S", cantidad: 15, precio: "9.00"},
    ]
  }

  
  render(){
    const alignBtn = {
      textAlign: "right"
    }

    return(
      <React.Fragment>
        <Card>
          <CardHeader style={alignBtn}>
            <Button className="btn-pill" color="primary"
                    onClick = { ()=>this.props.history.push('/configuracion/productos/nuevo') }
                    >
              Nuevo Producto
            </Button>
          </CardHeader>
          <CardBody>
            <ProductosGrilla productos={this.state.productos} />
          </CardBody>
        </Card>
      </React.Fragment>
    );
  }
}

export default Productos;
