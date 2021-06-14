import { NavLink } from "react-router-dom";

export default function SidebarDisplay(props) {
  return (
    <>
      <div className="position-sticky pt-3">
        <ul className="nav nav-pills flex-column">
            <li className="nav-item">
              <NavLink className="nav-link"
                        active="active"
                       to={`/dashboard`}>
                Dashboard
              </NavLink>
            </li>
          {props.categories && props.categories.map(c =>
            <li className="nav-item">
              <NavLink className="nav-link"
                        active="active"
                       to={`/${c.name.toLowerCase()}`}
                       key={'category_' + c.name.toLowerCase()}>
                {c.name}
              </NavLink>
            </li>
          )}
            <li className="nav-item">
              <NavLink className="nav-link"
                        active="active"
                       to={`/settings`}>
                Settings
              </NavLink>
            </li>
        </ul>
      </div>
    </>
  );
}
