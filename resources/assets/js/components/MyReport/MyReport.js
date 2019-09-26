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

class MyReport extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            semesters: [],
            selectedSemester: null
        }
    }

    componentDidMount() {
        Server
        .get('/api/semesters')
        .then((response) => {
            console.log({
                response
            })
            if (response.status == "200") {
                this.props.errors(new Array());
                this.setState({
                    semesters: response.data.data
                });
            }
        })
        .catch((error) => {
            console.log({
                error
            })
            const { response: { data: { error: { message } } } } = error;
            this.props.errors(new Array(message));
        });
    }

    onSemesterSelect(semester) {
        if(this.state.selectedSemester != semester) {
            Server
            .get(`/api/student/${this.props.user.id}/${semester}/marks`)
            .then((response) => {
                console.log({
                    response
                })
                if (response.status == "200") {
                    this.props.errors(new Array());
                    this.setState({
                        selectedSemester: semester,
                        data: response.data.data
                    });
                }
            })
            .catch((error) => {
                console.log({
                    error
                })
                const { response: { data: { error: { message } } } } = error;
                this.props.errors(new Array(message));
            });
        }
    }

    render() {
        const columns = [
            {
                Header:  () => <b>Subject</b>,
                accessor: 'subject.name',
                Cell: row => (
                    <span style={{display: 'block', textAlign: 'center'}}>{row.value}</span>
                )
            },
            {
                Header: () => <b>Marks</b>,
                accessor: 'marks',
                Cell: row => (
                    <b style={{display: 'block', textAlign: 'center'}}>{row.value}</b>
                )
            },
        ];
        return (
            <React.Fragment>
                <Card>
                    <CardHeader className="text-center">
                        <Row>
                            <Col md={8} className="text-right">
                                <h1 style={{ display: 'inline-block', textTransform: 'uppercase', letterSpacing: '5px' }}>My Report</h1>
                            </Col>
                            <Col md={4} className="text-right">
                                <a href={`/student/${this.props.user.id}/report`} target="_blank">
                                    <Button color="primary">
                                        <i className="fa fa-download"></i> Download Report
                                    </Button>
                                </a>
                            </Col>
                        </Row>
                    </CardHeader>
                    <CardBody>
                        <div className="form-group">
                            <label htmlFor="semester_id">Select Semester</label>{'    '}
                            <select>
                                {
                                    this.state.semesters &&
                                    [<option value="">Select</option>].concat(this.state.semesters.map(semester => <option onClick={() => this.onSemesterSelect(semester.id)} key={semester.id} value={semester.id}>{semester.name}</option>))
                                }
                            </select>
                        </div>
                        {this.state.selectedSemester &&
                            <ReactTable
                                data={this.state.data}
                                columns={columns}
                                defaultPageSize={5}
                                className="-striped -highlight"
                            />
                        }
                    </CardBody>
                </Card>
            </React.Fragment>
        );
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(MyReport);