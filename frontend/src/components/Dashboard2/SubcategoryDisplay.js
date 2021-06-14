import {NavLink} from "react-router-dom";

export default function SubcategoryDisplay(props) {
  return (
    <>
      <div className="row row-cols-4 g-2 -card-group">
        {props.subcategories && props.subcategories.map(s =>
          <div className="col">
            <div className="card text-dark mb-1" style={{'width': 'auto'}}
                 key={'subcategories_' + s['@id']}>
              <div className="card-header text-center p-0">
                <NavLink to={`/${props.categoryUrl}/${s.name.toLowerCase()}/create//api/transactions/`}
                         key={'subcategories_create_link_' + s.name.toLowerCase()}>
                  <i className={`${s.icon.name ?? ""} card-img-top display-5 p-2`}
                     style={{'color': s.color}}/>
                </NavLink>
              </div>
              <div className="card-body p-0">
                <NavLink className="d-block card-text small w-100 h-100 p-2"
                         style={{'color': s.color}}
                         to={`/${props.categoryUrl}/${s.name.toLowerCase()}`}
                         key={'subcategories_link_' + s.name.toLowerCase()}>
                  {s.name}
                </NavLink>
              </div>
            </div>
          </div>
        )}
      </div>
    </>
  )
}
