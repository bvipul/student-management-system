import React from 'react';
import { connect } from 'react-redux';
import ReactTable from "react-table";
import { Link } from 'react-router-dom';

import { bindActionCreators } from 'redux';
import { errors } from '../../store/actions';
import Server from '../../Helpers/Server';

import { Badge, Button, ButtonGroup, Card, CardHeader, CardBody, Row, Col, Modal, ModalHeader, ModalBody, ModalFooter } from 'reactstrap';

import 'react-table/react-table.css';

function mapStateToProps(state) {
    return {
        user: state.auth.user
    }
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
      errors
    }, dispatch);
}

class Profile extends React.Component {
    constructor(props) {
        super(props);
        // this.state = {
        //     semesters: [],
        //     selectedSemester: null
        // }
    }

    // componentDidMount() {
    //     Server
    //     .get('/api/semesters')
    //     .then((response) => {
    //         console.log({
    //             response
    //         })
    //         if (response.status == "200") {
    //             this.props.errors(new Array());
    //             this.setState({
    //                 semesters: response.data.data
    //             });
    //         }
    //     })
    //     .catch((error) => {
    //         console.log({
    //             error
    //         })
    //         const { response: { data: { error: { message } } } } = error;
    //         this.props.errors(new Array(message));
    //     });
    // }

    render() {
        return (
            <React.Fragment>
                <Card>
                    <CardHeader className="text-center">
                        <Row>
                            <Col md={12} className="text-center">
                                <h1 style={{ display: 'inline-block', textTransform: 'uppercase', letterSpacing: '5px' }}>Profile</h1>
                            </Col>
                        </Row>
                    </CardHeader>
                    <CardBody>
                        <div className="">
                            <Row>
                                <Col md={4}>
                                    <b>Name</b>
                                </Col>
                                <Col md={8}>
                                    <b>{this.props.user.name}</b>
                                </Col>
                            </Row>
                            <Row>
                                <Col md={4}>
                                    <b>Email</b>
                                </Col>
                                <Col md={8}>
                                    <b>{this.props.user.email}</b>
                                </Col>
                            </Row>
                            <Row>
                                <Col md={4}>
                                    <b>Enrolled In:</b>
                                </Col>
                                <Col md={8}>
                                    <b>{this.props.user.course.name}</b>
                                </Col>
                            </Row>
                        </div>
                    </CardBody>
                </Card>
            </React.Fragment>
        );
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Profile);