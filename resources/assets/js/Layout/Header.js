import React, { Component } from 'react';
import { Badge, DropdownItem, DropdownMenu, DropdownToggle, Nav, NavItem, NavLink } from 'reactstrap';
import PropTypes from 'prop-types';

import { AppAsideToggler, AppHeaderDropdown, AppNavbarBrand, AppSidebarToggler } from '@coreui/react';

import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';

import { authLogout } from '../store/actions';

import Server from '../Helpers/Server';

class Header extends Component {
    constructor(props) {
        super(props);

        this.handleLogout = this.handleLogout.bind(this);
    }

    handleLogout() {
        Server
        .post('/api/logout')
        .then(({ data: { success }}) => {
            if (success) this.props.authLogout();
        })
        .catch((error) => {
            const {response: {data: {error: {message}}}} = error;
            this.props.errors(new Array(message));
        });
    }

    render() {
        // eslint-disable-next-line
        const {children, ...attributes} = this.props;

        return (
            <React.Fragment>
                <AppSidebarToggler className="d-lg-none" display="md" mobile />
                <AppNavbarBrand>SMP</AppNavbarBrand>
                <AppSidebarToggler className="d-md-down-none" display="lg" />

                <Nav className="d-md-down-none" navbar>
                    <NavItem className="px-3">
                        <NavLink href={ this.props.auth.isAdmin ? "/admin/dashboard" : '/student/dashboard' }>Dashboard</NavLink>
                    </NavItem>
                </Nav>

                <Nav className="ml-auto" navbar style={{marginRight: '40px'}}>                    
                    <AppHeaderDropdown direction="down">
                        <DropdownToggle nav>
                            <span><i className="fa fa-user"></i> {this.props.user.name}</span>
                        </DropdownToggle>
                        <DropdownMenu right style={{right: 'auto'}}>
                            <DropdownItem onClick={this.handleLogout}>
                                <i className="fa fa-lock"></i> Logout
                            </DropdownItem>
                        </DropdownMenu>
                    </AppHeaderDropdown>
                </Nav>
            </React.Fragment>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        user: state.auth.user,
        auth: state.auth
    }
};

const mapDispatchToProps = (dispatch) => {
    return bindActionCreators({
        authLogout
    }, dispatch);
}

Header.propTypes = {
    children: PropTypes.node,
};

Header.defaultProps = {};

export default connect(mapStateToProps, mapDispatchToProps)(Header);
