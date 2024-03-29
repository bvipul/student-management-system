import React from 'react';
import { Redirect, Route } from 'react-router-dom';
import { connect } from 'react-redux'; 
import jwt_decode from 'jwt-decode';
import { withRouter } from 'react-router-dom';

class PrivateStudentRoute extends React.PureComponent {
    render() {
      const { isAuthenticated, isStudent, component: Component, ...rest } = this.props;

      return (
        <Route {...rest} render={props => (
            checkAuthenticated(isAuthenticated, isStudent)
            ? <Component {...props} />
            : <Redirect to='/login' />
        )} />
      );
    }
}

const mapStateToProps = (state) => {
    return {
        isAuthenticated: state.auth.isAuthenticated,
        isStudent: state.auth.isStudent
    }
};

const checkAuthenticated = (isAuthenticated, isStudent) => {
    if (isAuthenticated && isStudent && localStorage.getItem('jwt_token')) {

        let token = jwt_decode(localStorage.getItem('jwt_token'));

        if (token.exp > (new Date().getTime() / 1000)) {
            return true;
        }

        return false;
    }

    return false;
};

export default withRouter(connect(mapStateToProps)(PrivateStudentRoute));