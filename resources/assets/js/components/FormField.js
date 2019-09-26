import React from 'react';

const FormField = ({
        label,
        input,
        type,
        name,
        className,
        children,
        defaultValue,
        disabled,
        meta: { touched, error, warning }
}) => {
    let renderedInput;
    if (type == 'select') {
        renderedInput = (<select {...input} name={name} className={
            `${className} ${
                touched && (
                    (error && 'is-invalid')
                )
            }`
        } >
            { children }
        </select>);
    } else {
        if(!input.value && defaultValue) {
            input.value = defaultValue;
        }
        renderedInput = (<input { ...input } name={name} type={type} disabled={disabled ? true : false} className={
            `${className} ${
                touched && (
                (error && 'is-invalid')
                )
            }`}
        />);
    }
    return ( 
        <div className="form-group">
            {
                label &&
                <label htmlFor={name}>{label}</label>
            }

            {
                renderedInput
            }
            {
                touched &&
                    (error && <span className="invalid-feedback">{error}</span>)
            }
        </div>
    );
};

export default FormField;