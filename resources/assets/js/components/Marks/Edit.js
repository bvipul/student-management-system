import React from 'react';
import { Link } from 'react-router-dom';
import { Card, CardHeader, CardBody, CardFooter, Row, Col, Button, Form, FormGroup, Label, Input, FormText } from 'reactstrap';
import { reduxForm, Field } from 'redux-form';
import FormField from '../FormField';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { authLogin, errors } from '../../store/actions';
import Server from '../../Helpers/Server';

const validatorMarksEditForm = (values) => {
    const result = validate(values, {
        marks: {
            presence:{
                message: 'Please enter Marks'
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
        subject_id: {
            presence: {
                message: 'Please select a Subject.'
            }
        },
        student_id: {
            presence: {
                message: 'Please select a Student.'
            }
        },
    });

    return result;
};

function validate(values, messages) {
    const errors = {};

    if(!values.marks) {
        errors.marks = messages.marks.presence.message;
    }

    if(!values.course_id) {
        errors.course_id = messages.course_id.presence.message;
    }

    if(!values.semester_id) {
        errors.semester_id = messages.semester_id.presence.message;
    }

    if(!values.student_id) {
        errors.student_id = messages.student_id.presence.message;
    }

    if(!values.subject_id) {
        errors.subject_id = messages.subject_id.presence.message;
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

class Edit extends React.Component {
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
            .get(`/api/marks/${this.props.match.params.id}`)
            .then((response) => {
                console.log("response", response);
                if (response.statusText == 'OK') {
                    this.props.initialize(response.data.data);
                    // const { course_name: courseName, student_name: studentName, semester_name: semesterName, subject_name: subjectName } = response.data.data;
                    // this.setState({
                    //     courseName,
                    //     studentName,
                    //     semesterName,
                    //     subjectName
                    // });
                };
            })
            .catch((error) => {
                const { response: { data: { error: { message } } } } = error;
                this.props.errors(new Array(message));
            });
    }

    processSubmit(values) {
        Server
            .patch(`/api/marks/${this.props.match.params.id}`, values)
            .then((response) => {
                if (response.data.success) {
                    this.props.errors(new Array());
                    this.props.history.push('/admin/marks');
                }
            })
            .catch((error) => {
                const { response: { data: { error: { message } } } } = error;
                this.props.errors(new Array(message));
            });
    }

    render() {
        const {error, handleSubmit, submitting} = this.props;
        const {courseName, studentName, semesterName, subjectName} = this.state;

        return (
            <Card>
                <CardHeader className="text-center">
                    <Row>
                        <Col md={8} className="text-right">
                            <h1 style={{ display: 'inline-block', textTransform: 'uppercase', letterSpacing: '5px' }}>Edit Subject</h1>
                        </Col>
                        <Col md={4} className="text-right">
                            <Link className="nav-link" to="/admin/marks">
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
                            label="Course"
                            name="course_name"
                            component={FormField}
                            id="course_name"
                            // defaultValue={courseName}
                            type="text"
                            props={{ disabled: true }}
                            className="form-control"
                        />
                        <Field
                            label="Student"
                            name="student_name"
                            component={FormField}
                            id="student_name"
                            // defaultValue={studentName}
                            type="text"
                            props={{ disabled: true }}
                            className="form-control"
                        />
                        <Field
                            label="Semester"
                            name="semester_name"
                            component={FormField}
                            // defaultValue={semester_name}
                            id="semester_name"
                            type="text"
                            props={{ disabled: true }}
                            className="form-control"
                        />
                        <Field
                            label="Subject"
                            name="subject_name"
                            component={FormField}
                            id="subject_name"
                            // defaultValue={subjectName}
                            type="text"
                            props={{ disabled: true }}
                            className="form-control"
                        />

                        <Field
                            label="Marks"
                            name="marks"
                            component={FormField}
                            id="marks"
                            type="text"
                            className="form-control"
                        />
                    </CardBody>
                    <CardFooter>
                        <FormGroup row>
                            <Col sm={{
                                size: 12,
                                offset: 5
                            }}>
                                <Link className="btn btn-secondary" to="/admin/marks">Cancel</Link>
                                <Button type="submit" className="ml-2" color="success" disabled={submitting}>Update</Button>
                            </Col>
                        </FormGroup>
                    </CardFooter>
                </Form>
            </Card>
        );
    }
};

Edit = reduxForm({
  form: 'subjectEdit',
  validate: validatorMarksEditForm
})(connect(mapStateToProps, mapDispatchToProps)(Edit));

export default Edit;