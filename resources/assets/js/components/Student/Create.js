import React from 'react';
import { Link } from 'react-router-dom';
import { Card, CardHeader, CardBody, CardFooter, Row, Col, Button, Form, FormGroup, Label, Input, FormText, Dropdown, DropdownToggle, DropdownMenu, DropdownItem } from 'reactstrap';
import { reduxForm, Field } from 'redux-form';
import FormField from '../FormField';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { errors } from '../../store/actions';
import Server from '../../Helpers/Server';

const validatorStudentCreateForm = (values) => {
    const result = validate(values, {
        name: {
            presence:{
                message: 'Please enter your name'
            }
        },
        email: {
            presence: {
                message: 'Please enter your email address.'
            },
            email: {
                message: 'Please enter a valid email address.'
            }
        },
        password: {
            presence: {
                message: 'Please enter your password.'
            }
        },
        course_id: {
            presence: {
                message: 'Please select a Course.'
            }
        }
    });

    return result;
};

function validate(values, messages) {
    const errors = {};
    
    if (!values.email) {
        errors.email = messages.email.presence.message;
    } 
    else if (!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(values.email)) {
        errors.email = messages.email.email.message;
    }

    if(!values.password) {
        errors.password = messages.password.presence.message;
    }

    if(!values.name) {
        errors.name = messages.name.presence.message;
    }

    if(!values.course_id) {
        errors.course_id = messages.course_id.presence.message;
    }
    
    return errors;
}

function mapStateToProps(state) {
  return {
    auth: state.auth
  }
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators({
      errors
    }, dispatch);
}

class Create extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            courses: []
        }

        this.processSubmit = this.processSubmit.bind(this);
    }

    componentDidMount() {
        Server
            .get('/api/courses')
            .then((response) => {
                if (response.status == "200") {
                    this.props.errors(new Array());
                    this.setState({
                        courses: response.data.data
                    });
                }
            })
            .catch((error) => {
                const { response: { data: { error: { message } } } } = error;
                this.props.errors(new Array(message));
            });
    }

    processSubmit(values) {
        Server
            .post('/api/students', values)
            .then((response) => {
                if (response.data.success) {
                    this.props.errors(new Array());
                    this.props.history.push('/admin/student');
                }
            })
            .catch((error) => {
                const { response: { data: { error: { message } } } } = error;
                this.props.errors(new Array(message));
            });
    }

    render() {
        const {error, handleSubmit, submitting} = this.props;
        
        return (
            <Card>
                <CardHeader className="text-center">
                    <Row>
                        <Col md={8} className="text-right">
                            <h1 style={{ display: 'inline-block', textTransform: 'uppercase', letterSpacing: '5px' }}>Create New Student</h1>
                        </Col>
                        <Col md={4} className="text-right">
                            <Link className="nav-link" to="/admin/student">
                                <Button color="secondary">
                                    Cancel
                                </Button>
                            </Link>
                        </Col>
                    </Row>
                </CardHeader>
                <Form onSubmit={handleSubmit(this.processSubmit)}>
                    <CardBody>
                        <Field
                            label="Name"
                            name="name"
                            component={FormField}
                            id="name"
                            type="name"
                            className="form-control"
                        />
                        <Field
                            label="Email Address"
                            name="email"
                            component={FormField}
                            id="email"
                            type="email"
                            className="form-control"
                        />
                        <Field
                            label="Password"
                            name="password"
                            component={FormField}
                            id="password"
                            type="password"
                            className="form-control"
                        />
                        <div className="form-group">
                            <label htmlFor="course_id">Select Course</label>
                            <Field
                              name="course_id"
                              component="select"
                              className="form-control"
                            >
                              {this.state.courses.length && this.state.courses.map(course => <option key={course.id} value={course.id}>{course.name}</option>)}
                            </Field>
                        </div>
                    </CardBody>
                    <CardFooter>
                        <FormGroup row>
                            <Col sm={{
                                size: 12,
                                offset: 5
                            }}>
                                <Link className="btn btn-secondary" to="/admin/student">Cancel</Link>
                                <Button type="submit" className="ml-2" color="success" disabled={submitting}>Submit</Button>
                            </Col>
                        </FormGroup>
                    </CardFooter>
                </Form>
            </Card>
        );
    }
};

Create = reduxForm({
  form: 'studentCreate',
  validate: validatorStudentCreateForm
})(connect(mapStateToProps, mapDispatchToProps)(Create));

export default Create;