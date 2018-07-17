import React from 'react';
import PropTypes from 'prop-types';
import { Switch, Route, Redirect } from 'react-router-dom';

import Home from '~/components/Home';
import Routes from '~/components/Routes';
import Test from '~/components/Test';

import '~/components/Forms/forms.scss';

class App extends React.Component {
  componentDidMount() {

    // chargement des données 
    //TODO A refaire:
    this.props.loadAllData();
  }

  render() {
    return (
      <Switch>
        <Route
          path="/"
          exact
          render={() => (
            this.props.loggedIn ? (<Redirect to="/dashboard" />) : (<Home />)
          )}
        />
        {/* On redirigie toutes les autre route vers le composant Routes */}
        <Route path="/test" component={Test} />
        { this.props.loggedIn ? <Route component={Routes} /> : <Redirect to="/" />}
      </Switch>
    );
  }
}

App.propTypes = {
  loadAllData: PropTypes.func.isRequired,
  loggedIn: PropTypes.bool.isRequired,
};

export default App;
