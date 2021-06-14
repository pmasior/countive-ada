import {NavLink} from "react-router-dom";

export default function SettingsDisplay(props) {
  return (
    <>
      <div className="card w-100 m-3">
        <div className="card-header">
          Categories
        </div>
        <ul className="list-group list-group-flush">
          {props.categories && props.categories.map(c =>
            <li className="list-group-item">
              <NavLink to={`/edit/${c['@id']}`}>
                {c.name}
              </NavLink>
            </li>
          )}
            <li className="list-group-item">
              <NavLink to={`/create//api/categories/`}>
                <i className="fas fa-plus pe-2" />Add category
              </NavLink>
            </li>
        </ul>
      </div>
      <div className="card w-100 m-3">
        <div className="card-header">
          Subcategories
        </div>
        <ul className="list-group list-group-flush">
          {props.subcategories && props.subcategories.map(s =>
            <li className="list-group-item">
              <NavLink to={`/edit/${s['@id']}`}>
                {s.name}
              </NavLink>
            </li>
          )}
            <li className="list-group-item">
              <NavLink to={`/create//api/subcategories/`}>
                <i className="fas fa-plus pe-2" />Add subcategory
              </NavLink>
            </li>
        </ul>
      </div>
      <div className="card w-100 m-3">
        <div className="card-header">
          Settlement Accounts
        </div>
        <ul className="list-group list-group-flush">
          {props.settlementAccounts && props.settlementAccounts.map(s =>
            <li className="list-group-item">
              <NavLink to={`/edit/${s['@id']}`}>
                {s.name}
              </NavLink>
            </li>
          )}
            <li className="list-group-item">
              <NavLink to={`/create//api/settlement_accounts/`}>
                <i className="fas fa-plus pe-2" />Add settlement account
              </NavLink>
            </li>
        </ul>
      </div>
      <div className="card w-100 m-3">
        <div className="card-header">
          Method Of Payments
        </div>
        <ul className="list-group list-group-flush">
          {props.methodOfPayments && props.methodOfPayments.map(m =>
            <li className="list-group-item">
              <NavLink to={`/edit/${m['@id']}`}>
                {m.name}
              </NavLink>
            </li>
          )}
            <li className="list-group-item">
              <NavLink to={`/create//api/method_of_payments/`}>
                <i className="fas fa-plus pe-2" />Add method of payment
              </NavLink>
            </li>
        </ul>
      </div>
    </>
  )
}
