import React from 'react';
import { connect } from 'react-redux';
import { Route, Switch, Redirect } from 'react-router-dom';
import { 
    AppBreadcrumb,
    AppAside,
    AppHeader, 
    AppSidebar, 
    AppFooter,
    AppSidebarHeader, 
    AppSidebarForm, 
    AppSidebarNav, 
    AppSidebarFooter,
    AppSidebarMinimizer 
} from '@coreui/react';
import Header from './Header';
import Aside from './Aside';
import Footer from './Footer';
import { Container } from 'reactstrap';

import navigation from '../_nav';
import routes from '../routes/routes';

function mapStateToProps(state) {
    console.log({
        state
    })
  return {
    user: state.auth.user,
    is_admin: state.auth.isAdmin,
    is_student: state.auth.isStudent
  }
}

class BackendLayout extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    const navConfig = this.props.is_admin ? navigation['admin'] : navigation['student'];
    return (
      <div className="app">
        <AppHeader fixed>
          <Header />
        </AppHeader>
        <div className="app-body">
            <AppSidebar fixed display="lg">
                <AppSidebarHeader />
                <AppSidebarForm />
                <AppSidebarNav navConfig={navConfig} {...this.props} />
                <AppSidebarFooter />
                <AppSidebarMinimizer />
            </AppSidebar>
            <main className="main">
                <AppBreadcrumb appRoutes={routes} />
                <Container fluid>
                    <Switch>
                        {
                            routes.map((route, index) => 
                            {
                                return route.component 
                                ? (<Route 
                                    key={index} 
                                    path={route.path} 
                                    exact={route.exact} 
                                    name={route.name} 
                                    render={ props => (
                                        <route.component {...props} />
                                    )} 
                                />)
                                : (null);
                            })
                        }
                        <Redirect from="/admin" to="/admin/dashboard" />
                    </Switch>
                </Container>
            </main>
            <AppAside fixed hidden>
                <Aside />
            </AppAside>
        </div>
        <AppFooter>
            <Footer />
        </AppFooter>
      </div>
      );
  }
}
;

BackendLayout = connect(mapStateToProps)(BackendLayout);

export default BackendLayout;