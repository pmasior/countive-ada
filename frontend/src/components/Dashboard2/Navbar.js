import React from "react";
import {NavLink} from "react-router-dom";

export default function Navbar() {
  return (
    <>
      <button className="navbar-toggler d-md-none collapsed" type="button"
              data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
              aria-controls="sidebarMenu" aria-expanded="false"
              aria-label="Toggle navigation">
        <i className="fas fa-bars"/>
      </button>
      <NavLink className="navbar-brand col-md-2 me-auto px-3"
               to="/dashboard">
        Countive
      </NavLink>
      <ul className="navbar-nav px-3">
        <li className="nav-item text-nowrap">
          <NavLink className="nav-link"
                   to="/logout">
            Sign out
          </NavLink>
        </li>
      </ul>
    </>
  )
}
