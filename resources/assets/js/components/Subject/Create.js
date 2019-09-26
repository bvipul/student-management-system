import React from 'react';
import { Link } from 'react-router-dom';
import { Card, CardHeader, CardBody, CardFooter, Row, Col, Button, Form, FormGroup, Label, Input, FormText, Dropdown, DropdownToggle, DropdownMenu, DropdownItem } from 'reactstrap';
import { reduxForm, Field } from 'redux-form';
import FormField from '../FormField';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { errors } from '../../store/actions';
import Server from '../../Helpers/Server';

const validatorSubjectCreateForm = (values) => {
    const result = validate(values, {
        name: {
            presence:{
                message: 'Please enter Subject name'
            }
        },
        course_id: {
            presence: {
                message: 'Please select a Course.'
            }
        },
        semester_id: {
            presence: {
                message: 'Please select a Semester.'
            }
        },
    });

    return result;
};

function validate(values, messages) {
    const errors = {};

    if(!values.name) {
        errors.name = messages.name.presence.message;
    }

    if(!values.course_id) {
        errors.course_id = messages.course_id.presence.message;
    }

    if(!values.semester_id) {
        errors.semester_id = messages.semester_id.presence.message;
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
            courses: [],
            semesters: []
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

        Server
            .get('/api/semesters')
            .then((response) => {
                if (response.status == "200") {
                    this.props.errors(new Array());
                    this.setState({
                        semesters: response.data.data
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
            .post('/api/subjects', values)
            .then((response) => {
                if (response.data.success) {
                    this.props.errors(new Array());
                    this.props.history.push('/admin/subject');
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
                            <h1 style={{ display: 'inline-block', textTransform: 'uppercase', letterSpacing: '5px' }}>Create New Subject</h1>
                        </Col>
                        <Col md={4} className="text-right">
                            <Link className="nav-link" to="/admin/subject">
                                <Button color="secondary">
                                    Cancel
                                </Button>
                            </Link>
                        </Col>
                    </Row>
                </CardHeader>
                <Form onSubmit={handleSubmit(this.processSubmit)}>
                    <CardBody>
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
                        <div className="form-group">
                            <label htmlFor="course_id">Select Semester</label>
                            <Field
                              name="semester_id"
                              component="select"
                              className="form-control"
                            >
                              {this.state.semesters.length && this.state.semesters.map(semester => <option key={semester.id} value={semester.id}>{semester.name}</option>)}
                            </Field>
                        </div>
                        <Field
                            label="Name"
                            name="name"
                            component={FormField}
                            id="name"
                            type="name"
                            className="form-control"
                        />
                    </CardBody>
                    <CardFooter>
                        <FormGroup row>
                            <Col sm={{
                                size: 12,
                                offset: 5
                            }}>
                                <Link className="btn btn-secondary" to="/admin/subject">Cancel</Link>
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
  form: 'subjectCreate',
  validate: validatorSubjectCreateForm
})(connect(mapStateToProps, mapDispatchToProps)(Create));

export default Create;