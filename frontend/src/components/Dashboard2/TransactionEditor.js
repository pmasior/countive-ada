import React, { useState } from "react";
import PropTypes from "prop-types";

export default function TransactionEditor(props) {
  const [formState, setFormState] = useState({
    '@id': props.transaction ? props.transaction['@id'] : null,
    amount: props.transaction ? props.transaction.amount : "-",
    addedAt: props.transaction ? props.transaction.addedAt : new Date(),
    currency: props.transaction ? props.transaction.currency['@id'] : "",
    subcategory: props.transaction ? props.transaction.subcategory['@id'] : "",
    tags: props.transaction ? props.transaction.tags : [],
    note: props.transaction ? props.transaction.note : "",
    settlementAccount: props.transaction ? props.transaction.settlementAccount['@id'] : "",
    methodOfPayment: props.transaction ?
      (props.transaction.methodOfPayment ? props.transaction.methodOfPayment['@id'] : "") : "",
  })

  const [settlementAccounts, setSettlementAccounts] = useState(props.settlementAccounts);
  const [currencies, setCurrencies] = useState(props.currencies);
  const [subcategories, setSubcategories] = useState(props.subcategories);
  const [methodOfPayments, setMethodOfPayments] = useState(props.methodOfPayments);

  if (formState.subcategory === "") {
    formState.subcategory = subcategories.map(s => {
        if (props.match.params.subcategory === s.name.toLowerCase()) {
          setFormState((prev) => ({
            ...prev,
            subcategory: s['@id']
          }));
        }
      });
  }

  const handleChange = ({target}) => {
    const { name, value } = target;
    setFormState((prev) => ({
      ...prev,
      [name]: value
    }));
  }

  const handleSubmit = (event) => {
    event.preventDefault();
    // alert("1 " + JSON.stringify(formState, null, 2));  // TODO: delete alert
    Object.keys(formState).forEach((key) =>
      (formState[key] === null || formState[key] === "") && delete formState[key]);
    // alert("2 " + JSON.stringify(formState, null, 2));  // TODO: delete alert
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
                  <input className="form-control" name="amount" type="text" placeholder=""
                         value={formState.amount}
                         pattern="^-?[0-9]+.?[0-9]*$"
                         required
                         onChange={handleChange} />
                  <label>amount</label>
                </div>
                <div className="form-group form-floating mb-3">
                  <select className="form-select" name="currency" aria-label="currency"
                          required
                          value={formState.currency}
                          onChange={handleChange}>
                    <option value={""}>{""}</option>
                    {currencies.map(c => {
                      if (c['@id'] === formState.currency) {
                        return <option value={c['@id']}>{c.name}</option>
                      } else {
                        return <option value={c['@id']}>{c.name}</option>
                      }
                    })}
                  </select>
                  <label>currency</label>
                </div>
                <div className="form-group form-floating mb-3">
                  <input className="form-control" name="currency" type="datetime-local"
                         required
                         value={formState.addedAt}
                         onChange={handleChange} />  {/* TODO: wybór daty */}
                  <label>addedAt</label>
                </div>
                <div className="form-group form-floating mb-3">
                  <select className="form-select" name="subcategory" aria-label="subcategory"
                          required
                          value={formState.subcategory}
                          onChange={handleChange}>
                    {subcategories.map(s => {
                      if (s['@id'] === formState.subcategory ||
                          props.match.params.subcategory === s.name.toLowerCase()) {
                        return <option value={s['@id']}>{s.name}</option>
                      } else {
                        return <option value={s['@id']}>{s.name}</option>
                      }
                    })}
                  </select>
                  <label>subcategory</label>
                </div>
                <div className="form-group form-floating mb-3">
                  <select className="form-select" multiple name="tags" aria-label="tags"
                          onChange={handleChange}>
                    <option value={formState.tags}>{formState.tags.name}</option>
                  </select>
                  <label>tags</label>  {/* TODO: naprawić tagi */}
                </div>
                <div className="form-group form-floating mb-3">
                  <input className="form-control" name="note" type="text"
                         value={formState.note}
                         onChange={handleChange} />
                  <label>note</label>
                </div>
                <div className="form-group form-floating mb-3">
                  <select className="form-select" name="settlementAccount" aria-label="settlementAccount"
                          required
                          value={formState.settlementAccount}
                          onChange={handleChange}>
                    <option value={""}>{""}</option>
                    {settlementAccounts.map(s => {
                      if (s['@id'] === formState.settlementAccount) {
                        return <option value={s['@id']}>{s.name}</option>
                      } else {
                        return <option value={s['@id']}>{s.name}</option>
                      }
                    }
                    )}
                  </select>
                  <label>settlementAccount</label>
                </div>
                <div className="form-group form-floating mb-3">
                  <select className="form-select" name="methodOfPayment" aria-label="methodOfPayment"
                          value={formState.methodOfPayment}
                          onChange={handleChange}>
                    <option value={""}>{""}</option>
                    {methodOfPayments.map(s => {
                      if (s['@id'] === formState.methodOfPayment) {
                        return <option value={s['@id']}>{s.name}</option>
                      } else {
                        return <option value={s['@id']}>{s.name}</option>
                      }
                    })}
                  </select>
                  <label>methodOfPayment</label>
                </div>  {/* TODO: tylko dostępne metody płatności dla konta rozliczeniowego */}
              </div>
              <div className="modal-footer d-flex">
                <button type="button" className="btn btn-danger"
                        data-bs-dismiss="modal"
                        onClick={() => props.deleteCallback(props.transaction)}>
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

TransactionEditor.propTypes = {
  transaction: PropTypes.object,  //TODO: array or object
  saveCallback: PropTypes.func,
  cancelCallback: PropTypes.func
}
