import React from 'react';
import { Link } from 'react-router-dom';
import { Card, CardHeader, CardBody, CardFooter, Row, Col, Button, Form, FormGroup, Label, Input, FormText } from 'reactstrap';
import { reduxForm, Field } from 'redux-form';
import FormField from '../FormField';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { errors } from '../../store/actions';
import Server from '../../Helpers/Server';

const validatorCourseCreateForm = (values) => {
    const result = validate(values, {
        name: {
            presence:{
                message: 'Please enter course name'
            }
        }
    });

    return result;
};

function validate(values, messages) {
    const errors = {};

    if(!values.name) {
        errors.name = messages.name.presence.message;
    }
    
    return errors;
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators({
      errors
    }, dispatch);
}

class Create extends React.Component {
    constructor(props) {
        super(props);

        this.processSubmit = this.processSubmit.bind(this);
    }

    processSubmit(values) {
        Server
            .post('/api/courses', values)
            .then((response) => {
                if (response.data.success) {
                    this.props.errors(new Array());
                    this.props.history.push('/admin/course');
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
                            <h1 style={{ display: 'inline-block', textTransform: 'uppercase', letterSpacing: '5px' }}>Create New Course</h1>
                        </Col>
                        <Col md={4} className="text-right">
                            <Link className="nav-link" to="/admin/course">
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
                    </CardBody>
                    <CardFooter>
                        <FormGroup row>
                            <Col sm={{
                                size: 12,
                                offset: 5
                            }}>
                                <Link className="btn btn-secondary" to="/admin/course">Cancel</Link>
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
  form: 'courseCreate',
  validate: validatorCourseCreateForm
})(connect(null, mapDispatchToProps)(Create));

export default Create;