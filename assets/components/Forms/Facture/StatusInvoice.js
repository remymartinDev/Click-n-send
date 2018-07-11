import React from 'react';
import Axios from 'axios';
import { Field } from 'redux-form';

class StatusInvoice extends React.Component {
  state = {
    status: [],
  }

  componentDidMount() {
    Axios.get('/api/status')
      .then(({ data: status }) => {
        this.setState({
          status,
        });
      });
    this.getStatusJSX();
  }

  getStatusJSX = () => (
    this.state.status.map(({ id, invoiceStatus }) => (
      <option key={id}>{invoiceStatus}</option>
    ))
  )

  render() {
    return (
      <Field component="select" name="fieldstatus">
        <option>Sélectionnez le statut</option>
        {this.getStatusJSX()}
      </Field>
    );
  }
}

export default StatusInvoice;
