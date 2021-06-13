import React, { useState } from "react";
import PropTypes from "prop-types";

export default function SubcategoryEditor(props) {
  const [formState, setFormState] = useState({
    '@id': props.subcategory ? props.subcategory['@id'] : null,
    name: props.subcategory ? props.subcategory.name : "",
    icon: props.subcategory ? props.subcategory.icon : "",
    color: props.subcategory ? props.subcategory.color : "#3b80ce",
    category: props.subcategory ? props.subcategory.category : "",
  })

  const [categories] = useState(props.categories);
  const [icons] = useState(props.icons);

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
                <div className="form-group form-floating mb-3">
                  <select className="form-select" name="icon" aria-label="icon"
                          required
                          onChange={handleChange}>
                    <option value={""}>{""}</option>
                    {icons.map(i => {
                      if (i['@id'] === formState.icon) {
                        return <option selected value={i['@id']}>{i.name}</option>
                      } else {
                        return <option value={i['@id']}>{i.name}</option>
                      }
                    })}
                  </select>
                  <label>icon</label>
                </div>
                <div className="form-group form-floating mb-3">
                  <input className="form-control form-control-color" name="color" type="color"
                         id="colorInput"
                         value={formState.color}
                         onChange={handleChange} />
                  <label htmlFor="colorInput" className="form-check-label">color</label>
                </div>
                <div className="form-group form-floating mb-3">
                  <select className="form-select" name="category" aria-label="category"
                          required
                          value={formState.category}
                          onChange={handleChange}>
                    <option value={""}>{""}</option>
                    {categories.map(c => {
                      if (c['@id'] === formState.category) {
                        return <option selected value={c['@id']}>{c.name}</option>
                      } else {
                        return <option value={c['@id']}>{c.name}</option>
                      }
                    })}
                  </select>
                  <label>category</label>
                </div>
              </div>
              <div className="modal-footer d-flex">
                <button type="button" className="btn btn-danger"
                        data-bs-dismiss="modal"
                        onClick={() => props.deleteCallback(props.subcategory)}>
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

SubcategoryEditor.propTypes = {
  subcategory: PropTypes.object,
  categories: PropTypes.array,
  icons: PropTypes.array,
  saveCallback: PropTypes.func,
  cancelCallback: PropTypes.func
}
