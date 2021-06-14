import React, { useState } from "react";
import PropTypes from "prop-types";

export default function SettlementAccountEditor(props) {
  const [formState, setFormState] = useState({
    '@id': props.settlementAccount ? props.settlementAccount['@id'] : null,
    name: props.settlementAccount ? props.settlementAccount.name : "",
    color: props.settlementAccount ? props.settlementAccount.color : "#3b80ce",
  })

  const handleChange = ({target}) => {
    const { name, value } = target;
    setFormState((prev) => ({
      ...prev,
      [name]: value
    }));
  }

  const handleSubmit = (event) => {
    event.preventDefault();
    Object.keys(formState).forEach((key) =>
      (formState[key] === null || formState[key] === "") && delete formState[key]);
    props.saveCallback(formState);
  }

  const stopPropagation = (event) => {
    event.stopPropagation();
  }

  return (
    <>
      <div className="modal-backdrop fade show"
           onClick={props.cancelCallback}/>
      <div className="modal fade in show" id="exampleModal" tabIndex="-1"
           style={{display: 'block'}}
           role="dialog"
           aria-modal="true"
           onClick={props.cancelCallback}>
        <div className="modal-dialog"
             onClick={stopPropagation}>
          <div className="modal-content">
            <form onSubmit={handleSubmit}>
              <div className="modal-header">
                <h5 className="modal-title" id="exampleModalLabel">
                  {props.headerTitle}
                </h5>
                <button type="button" className="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"
                        onClick={props.cancelCallback}/>
              </div>
              <input name="id" type="hidden" value={formState["@id"]} />
              <div className="modal-body">
                <div className="form-group form-floating mb-3">
                  <input className="form-control" name="name" type="text" placeholder=""
                         value={formState.name}
                         required
                         onChange={handleChange} />
                  <label>name</label>
                </div>
              </div>
              <div className="modal-footer d-flex">
                <button type="button" className="btn btn-danger"
                        data-bs-dismiss="modal"
                        onClick={() => props.deleteCallback(props.settlementAccount)}>
                  Delete
                </button>
                <span className="flex-grow-1" />
                <button type="button" className="btn btn-secondary"
                        data-bs-dismiss="modal"
                        onClick={props.cancelCallback}>
                  Close
                </button>
                <button className="btn btn-primary" type="submit">
                  Save
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </>
  );
}

SettlementAccountEditor.propTypes = {
  settlementAccount: PropTypes.object,
  saveCallback: PropTypes.func,
  cancelCallback: PropTypes.func
}

