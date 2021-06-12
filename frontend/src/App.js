import './App.css';

import React from "react";
import { Provider } from "react-redux";
import { BrowserRouter, Redirect, Route, Switch } from 'react-router-dom'
import { CountiveDataStore } from "./data/DataStore";
import {RequestError} from "./webservices/RequestError";
import {Dashboard} from "./components/Dashboard2/Dashboard";
import {Login} from "./components/Dashboard2/Login";
import Logout from "./components/Dashboard2/Logout";
import {Settings} from "./components/Dashboard2/Settings";
import {Register} from "./components/Dashboard2/Register";

function App() {
  return (
    <Provider store={CountiveDataStore}>
      <BrowserRouter>
        <Switch>
          <Route path="/dashboard" component={Dashboard} />
          <Route path="/login" component={Login} />
          <Route path="/register" component={Register} />
          <Route path="/logout" component={Logout} />
          <Route path="/settings" component={Settings} />
          <Route path={"/error/:code/:message"} component={RequestError} />
          <Route path="/:mode(edit|create)//:api?/:datatype?/:id?" component={Settings} />
          <Route path="/:category/:mode(edit|create)//:api?/:datatype?/:id?" component={Dashboard} />
          <Route path="/:category/:subcategory/:mode(edit|create)//:api?/:datatype?/:id?" component={Dashboard} />
          <Route path="/:category/:subcategory?" component={Dashboard} />
          <Redirect to="/error/404/Page not found" />
        </Switch>
      </BrowserRouter>
    {/*<StoreAccessForDebug store={CountiveDataStore} />*/}
    {/* TODO: delete debug dataStore */}
    </Provider>
  );
}

export default App;
