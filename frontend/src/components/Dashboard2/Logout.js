import React from "react";
import {logout} from "../../webservices/userAccount";
import {Redirect} from "react-router-dom";

export default function Logout() {
  logout();

  return <Redirect to="/login" />;
}
