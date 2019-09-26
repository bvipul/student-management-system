import React, { Component } from 'react';
import PropTypes from 'prop-types';

const propTypes = {
  children: PropTypes.node,
};

const defaultProps = {};

class Footer extends Component {
  render() {

    // eslint-disable-next-line
    const {children, ...attributes} = this.props;

    return (
      <React.Fragment>
        <span>
            <a href="https://github.com/bvipul/laravel-react-redux-boilerplate">Student Managment Portal</a> © 2019
        </span>
        <span className="ml-auto">Powered by <a href="https://coreui.io/react">CoreUI for React</a></span>
      </React.Fragment>
    );
  }
}

Footer.propTypes = propTypes;
Footer.defaultProps = defaultProps;

export default Footer;
