import React from 'react';
import { Link } from 'react-router-dom';
import { Card, CardHeader, CardBody, CardFooter, Row, Col, Button, Form, FormGroup, Label, Input, FormText, Dropdown, DropdownToggle, DropdownMenu, DropdownItem } from 'reactstrap';
import { reduxForm, Field, formValueSelector } from 'redux-form';
import FormField from '../FormField';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { errors } from '../../store/actions';
import Server from '../../Helpers/Server';

const validatorMarksCreateForm = (values) => {
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
    console.log({
        values,
        messages
    })
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

class Create extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            courses: [],
            students: [],
            semesters: [],
            subjects: []
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

    componentDidUpdate(prevProps, prevState) {
        if(prevProps.course != this.props.course) {
            Server
            .post('/api/getStudents', { course: this.props.course })
            .then((response) => {
                if (response.status == "200") {
                    this.props.errors(new Array());
                    this.setState({
                        students: response.data.data
                    });
                }
            })
            .catch((error) => {
                const { response: { data: { error: { message } } } } = error;
                this.props.errors(new Array(message));
            });
        }

        if(prevProps.semester != this.props.semester) {
            Server
            .post('/api/getSubjects', { course: this.props.course, semester: this.props.semester })
            .then((response) => {
                if (response.status == "200") {
                    this.props.errors(new Array());
                    this.setState({
                        subjects: response.data.data
                    });
                }
            })
            .catch((error) => {
                const { response: { data: { error: { message } } } } = error;
                this.props.errors(new Array(message));
            });
        }

        if(prevProps.subject != this.props.subject) {
            Server
            .post('/api/getMarks', { 
                course: this.props.course, 
                student: this.props.student,
                semester: this.props.semester,
                subject: this.props.subject
            })
            .then((response) => {
                if (response.status == "200") {
                    this.props.errors(new Array());
                    console.log({
                        response
                    })
                    if(response.data && response.data.data && response.data.data.marks) {
                        // this.props.initialize({
                        //     marks: response.data.data.marks
                        // });

                        this.setState({
                            marksAvailable: response.data.data.id,
                            marks: response.data.data.marks
                        });
                    }
                }
            })
            .catch((error) => {
                const { response: { data: { error: { message } } } } = error;
                this.props.errors(new Array(message));
            });   
        }
    }

    processSubmit(values) {
        values.marksAvailable = this.state.marksAvailable;
        Server
            .post('/api/marks', values)
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

    getOptions(values) {
        if(values && Array.isArray(values) && values.length) {
            const options = [
                <option key={0} value={""}>Select</option>
            ];

            values.forEach(value => {
                options.push(<option key={value.id} value={value.id}>{value.name}</option>)
            });

            return options;
        } else {
            return null;
        }
    }

    render() {
        const { error, handleSubmit, submitting, course, student, subject, semester } = this.props;
        
        return (
            <Card>
                <CardHeader className="text-center">
                    <Row>
                        <Col md={8} className="text-right">
                            <h1 style={{ display: 'inline-block', textTransform: 'uppercase', letterSpacing: '5px' }}>Add/Update Marks</h1>
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
                                { this.getOptions(this.state.courses) }
                            </Field>
                        </div>
                        { course && 
                            <div className="form-group">
                                <label htmlFor="course_id">Select Student</label>
                                <Field
                                  name="student_id"
                                  component="select"
                                  className="form-control"
                                >
                                    { this.getOptions(this.state.students) }
                                </Field>
                            </div>
                        }

                        { course && student && 
                            <div className="form-group">
                                <label htmlFor="course_id">Select Semester</label>
                                <Field
                                  name="semester_id"
                                  component="select"
                                  className="form-control"
                                >
                                    { this.getOptions(this.state.semesters) }
                                </Field>
                            </div>
                        }

                        { course && student && semester && 
                            <div className="form-group">
                                <label htmlFor="course_id">Select Subject</label>
                                <Field
                                  name="subject_id"
                                  component="select"
                                  className="form-control"
                                >
                                    { this.getOptions(this.state.subjects) }
                                </Field>
                            </div>
                        }

                        { course && student && semester && subject && 
                            <Field
                                label="Marks"
                                name="marks"
                                component={FormField}
                                id="marks"
                                type="number"
                                min={1}
                                step={1}
                                max={100}
                                defaultValue={this.state.marks ? this.state.marks : 1}
                                className="form-control"
                            />
                        }
                    </CardBody>
                    <CardFooter>
                        <FormGroup row>
                            <Col sm={{
                                size: 12,
                                offset: 5
                            }}>
                                <Link className="btn btn-secondary" to="/admin/marks">Cancel</Link>
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
  form: 'marksCreate',
  validate: validatorMarksCreateForm
})(Create);


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

const selector = formValueSelector('marksCreate');

Create = connect(state => {
    const { course_id: course, student_id: student, semester_id: semester, subject_id: subject } = selector(state, 'course_id', 'student_id', 'semester_id', 'subject_id');

    return {
      course,
      student,
      semester,
      subject
    }
  }, 
  mapDispatchToProps)(Create);

export default Create;