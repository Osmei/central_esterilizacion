import React, { Component } from 'react';
import { Card, CardHeader, CardBody, Button } from 'reactstrap';

class Instrumentales extends Component{



  render(){
    return(
      <Card>
        <CardHeader style={{textAlign: "right"}}>          
          <Button color="primary"
              onClick={() => this.props.history.push('/configuracion/instrumental/nuevo')}>
            Nuevo
          </Button>
        </CardHeader>
        <CardBody>
          
        </CardBody>
      </Card>
    );
  }
}

export default Instrumentales;
