import React, {useState} from "react";
import {login} from "../../webservices/userAccount";
import {NavLink, withRouter} from "react-router-dom";

export const Login = withRouter((props) => {
  const [eMail, setEMail] = useState('');
  const [password, setPassword] = useState('');
  const [loginResult, setLoginResult] = useState(null);

  const handleSubmit = (e) => {
    e.preventDefault();
    login(eMail, password, (status) => {
      if (status === 204) {
        props.history.push('/dashboard');
      } else if (status === 401) {
        setLoginResult(false);
      }
    });
  }

  return (
    <>
      <div className="vh-100">
        <nav className="navbar">
          <div className="container-fluid">
            <ul className="navbar-nav ms-auto">
              <li className="nav-item">
                <NavLink className="nav-link"
                         to={`/register`}>
                  Register
                </NavLink>
              </li>
            </ul>
          </div>
        </nav>
        <main className="h-75 d-flex justify-content-center align-items-center">
          <form className="d-flex flex-column w-25 gap-2"
                onSubmit={handleSubmit}>
            <h1 className="align-self-center text-primary">Countive</h1>
            <h2 className="align-self-center text-secondary">Sign in</h2>
            <div className="form-floating">
              <input type="email" className={`form-control ${loginResult === false ? "is-invalid" : ""} `}
                     placeholder="example@example.com"
                     onChange={e => setEMail(e.target.value)} value={eMail}/>
              <label>Email</label>
            </div>
            <div className="form-floating">
              <input type="password" className={`form-control ${loginResult === false ? "is-invalid" : ""} `}
                     placeholder="********"
                     onChange={e => setPassword(e.target.value)} value={password}/>
              <label>Password</label>
            </div>
            <div>
              <button type="submit" className="btn btn-lg btn-primary w-100">Sign in</button>
            </div>
          </form>
        </main>
      </div>
    </>
  )
})
